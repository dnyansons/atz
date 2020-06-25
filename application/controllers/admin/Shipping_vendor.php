<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Shipping_vendor extends CI_Controller {

    public function __construct() {
        parent::__construct();
        if (!$this->session->userdata("admin_logged_in")) {
            $error = "<div class='alert alert-danger alert-dismissible'>
                        <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                        <strong>Error!</strong> Session timeout, relogin!.
                      </div>";
            $this->session->set_flashdata("message", $error);
            redirect("admin/login", "refresh");
        }
        $this->load->library('Userpermission');
        $this->load->model('Common_model');
    }

    public function index() {
        $data = array();
        $this->load->view("admin/shipping_vendor/index", $data);
    }

    public function ajax_get_shipping_vendors() {
        $columns = array(
            0 => 'id',
            1 => 'vendor_name',
           // 2 => 'contract_start_date',
            //3 => 'contract_end_date',
            2 => 'shipping_type',
            3 => 'free_amount',
            4 => 'status',
        );

        $limit = $this->input->post('length');
        $start = $this->input->post('start');
        $order = $columns[$this->input->post('order')[0]['column']];
        //$dir = $this->input->post('order')[0]['dir'];
        $dir = "desc";

        $totalData = $this->Common_model->select('count(id)', 'shipping_vendor')[0]['count_id'];

        $totalFiltered = $totalData;

        if (empty($this->input->post('search')['value'])) {
            $list = $this->Common_model->select('*', 'shipping_vendor', '', array(1 => array('colname' => $order, 'type' => 'DESC')), $limit, $start);
        } else {
            $search = $this->input->post('search')['value'];

            $list = $this->shipping_vendor_search($limit, $start, $search, $order, $dir);

            $totalFiltered = $this->shipping_vendor_search_count($search);
        }

        $data = array();
        if (!empty($list)) {
            foreach ($list as $row) {
                $nestedData['id'] = $row['id'];
                $nestedData['vendor_name'] = $row['vendor_name'];
                //$nestedData['contract_start_date'] = $row['contract_start_date'];
                //$nestedData['contract_end_date'] = $row['contract_end_date'];
                $nestedData['is_default'] = $row['is_default'] == 1 ? '<span style="color:green;">Yes</span>' : '<span style="color:red;">No</span>';
                $nestedData['shipping_type'] = $row['shipping_type'];
                $nestedData['free_amount'] = '>= '.$row['free_amount'];
                $nestedData['action'] = ' <a href="' . base_url() . 'admin/shipping_vendor/edit/' . $row['id'] . '" class="tabledit-delete-button btn btn-info waves-effect waves-light btn-sm" data-toggle="tooltip" data-placement="top" title="Edit Vendor" data-original-title="Edit"><i class="fa fa-edit"></i></i></a>
						  
                <a href="' . base_url() . 'admin/shipping_vendor/mark_default/' . $row['id'] . '" class="tabledit-edit-button btn btn-danger waves-effect waves-light btn-sm" data-toggle="tooltip" data-placement="top" title="Mark" data-original-title="Mark Dedaut" onclick="return confirm(&#39;Are You Sure ?&#39;)"><i class="fa fa-check"></i></a>';


                $data[] = $nestedData;
            }
        }
        //<a href="' . base_url() . 'admin/shipping_vendor/view/' . $row['id'] . '" class="tabledit-delete-button btn btn-success waves-effect waves-light btn-sm" data-toggle="tooltip" data-placement="top" title="View" data-original-title="Delete"><i class="fa fa-eye"></i></a>
        //<a href="' . base_url() . 'admin/shipping_vendor/add_by_weight/' . $row['id'] . '" class="tabledit-edit-button btn btn-primary waves-effect waves-light btn-sm" data-toggle="tooltip" data-placement="top" title="Add By Weight" data-original-title="Add By Weight"><i class="fa fa-plus-square"></i></a>
						  
	//<a href="' . base_url() . 'admin/shipping_vendor/add_by_distance/' . $row['id'] . '" class="tabledit-edit-button btn btn-primary waves-effect waves-light btn-sm" data-toggle="tooltip" data-placement="top" title="Add By Distance" data-original-title="Add By Distance"><i class="fa fa-plus-square"></i></a>

        $json_data = array(
            "draw" => intval($this->input->post('draw')),
            "recordsTotal" => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data" => $data
        );

        echo json_encode($json_data);
    }

    public function shipping_vendor_search_count($search) {
        $query = $this
                ->db
                ->like('id', $search)
                ->or_like('vendor_name', $search)
                //->or_like('contract_start_date', $search)
                //->or_like('contract_end_date', $search)
                ->get("shipping_vendor");

        return $query->num_rows();
    }

    function shipping_vendor_search($limit, $start, $search, $col, $dir) {
        $query = $this
                ->db
                ->select('*')
                ->like('id', $search)
                ->or_like('vendor_name', $search)
                //->or_like('contract_start_date', $search)
                //->or_like('contract_end_date', $search)
                ->limit($limit, $start)
                ->order_by($col, $dir)
                ->get("shipping_vendor");

        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return null;
        }
    }

    public function add() {
        $data = [];

        $this->form_validation->set_rules('vendor_name', 'Vendor Name', 'required');

        $this->form_validation->set_rules('vendor_name', 'Vendor Name', 'required');
       // $this->form_validation->set_rules('contract_start_date', 'Contract Start Date', 'required');
        //$this->form_validation->set_rules('contract_end_date', 'Contract End Date', 'required');
        $this->form_validation->set_rules('free_amount', 'On Amount', 'required');
        $this->form_validation->set_rules('shipping_type', 'Shippment type', 'required');
        $this->form_validation->set_error_delimiters('<p style="color:red" class="text-left">', '</p>');
        if ($this->form_validation->run() == false) {
            $err_msg = validation_errors();
            $this->session->set_flashdata('error', $err_msg);
            $this->load->view("admin/shipping_vendor/add", $data);
        } else {
            $vendor_name = $this->input->post('vendor_name');

            //$contract_start_date = $this->input->post('contract_start_date');
           // $contract_end_date = $this->input->post('contract_end_date');
            $notify_me = $this->input->post('notify_me');
            $is_default = $this->input->post('is_default');
            $transport_medium = $this->input->post('transport_medium');
            $status = $this->input->post('status');
            $free_amount = $this->input->post('free_amount');
            $shippment_type = $this->input->post('shipping_type');

            $insert_shipping_vendor_arr = array();

            $insert_shipping_vendor_arr['vendor_name'] = $vendor_name;
            $insert_shipping_vendor_arr['status'] = $status;
            $insert_shipping_vendor_arr['shipping_type'] = $shippment_type;
            $insert_shipping_vendor_arr['free_amount'] = $free_amount;
            $insert_shipping_vendor_arr['contract_start_date'] = date('Y-m-d', strtotime($contract_start_date));
            $insert_shipping_vendor_arr['contract_end_date'] = date('Y-m-d', strtotime($contract_end_date));
            $insert_shipping_vendor_arr['notify_me'] = $notify_me == 'on' ? 'Y' : 'N';
            $insert_shipping_vendor_arr['is_default'] = $is_default == 'on' ? 1 : 0;
            // $insert_shipping_vendor_arr['transport_medium'] = implode(',',$transport_medium);

            $vendor_id = $this->Common_model->insert('shipping_vendor', $insert_shipping_vendor_arr);
            if ($is_default == 'on') {
                $this->db->set('is_default',0);
                $this->db->where('id!=', $vendor_id);
                $this->db->update('shipping_vendor');
               
            }
            $message = "<div class='alert alert-success alert-dismissible'>
                            <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                            <strong>Success!</strong> Added successfully.
                          </div>";
            $this->session->set_flashdata("message", $message);
            redirect("admin/shipping_vendor");
        }
    }

    function edit($id) {
        $data['vendor'] = $this->Common_model->getAll('shipping_vendor', array('id' => $id))->row_array();
        if (isset($_POST['submit']) && $_POST['submit'] != '') {



            $this->form_validation->set_rules('vendor_name', 'Vendor Name', 'required');
            //$this->form_validation->set_rules('contract_start_date', 'Contract Start Date', 'required');
            //$this->form_validation->set_rules('contract_end_date', 'Contract End Date', 'required');
            $this->form_validation->set_rules('shipping_type', 'Shippment type', 'required');
            $this->form_validation->set_rules('free_amount', 'On Amount', 'required|numeric');
            $this->form_validation->set_error_delimiters('<p style="color:red" class="text-left">', '</p>');


            if ($this->form_validation->run() == false) {
                $err_msg = validation_errors();
                $this->session->set_flashdata('error', $err_msg);
            } else {
                $vendor_name = $this->input->post('vendor_name');

               // $contract_start_date = date('Y-m-d', strtotime($this->input->post('contract_start_date')));
                //$contract_end_date = date('Y-m-d', strtotime($this->input->post('contract_end_date')));
                $notify_me = $this->input->post('notify_me');
                $is_default = $this->input->post('is_default');
                $transport_medium = $this->input->post('transport_medium');
                $status = $this->input->post('status');
                $free_amount = $this->input->post('free_amount');
                $shippment_type = $this->input->post('shipping_type');

                $insert_shipping_vendor_arr = array();

                $insert_shipping_vendor_arr['vendor_name'] = $vendor_name;
                $insert_shipping_vendor_arr['status'] = $status;
                $insert_shipping_vendor_arr['free_amount'] = $free_amount;
                $insert_shipping_vendor_arr['shipping_type'] = $shippment_type;
               // $insert_shipping_vendor_arr['contract_start_date'] = date('Y-m-d', strtotime($contract_start_date));
               // $insert_shipping_vendor_arr['contract_end_date'] = date('Y-m-d', strtotime($contract_end_date));
                $insert_shipping_vendor_arr['notify_me'] = $notify_me == 'on' ? 'Y' : 'N';
                $insert_shipping_vendor_arr['is_default'] = $is_default == 'on' ? 1 : 0;
                //$insert_shipping_vendor_arr['transport_medium'] = implode(',',$transport_medium);

                $vendor_id = $this->Common_model->update('shipping_vendor', $insert_shipping_vendor_arr, array('id' => $id));
                if ($is_default == 'on') {
                $this->db->set('is_default',0);
                $this->db->where('id!=', $id);
                $this->db->update('shipping_vendor');
            }
                $succ_msg = "Record Update Successfully";
                $this->session->set_flashdata('success', $succ_msg);
                redirect('admin/shipping_vendor/');
            }
        }

        $this->load->view("admin/shipping_vendor/edit", $data);
    }

    public function view($id = 0) {
        $data['by_weight'] = $this->Common_model->getAll('shipping_vendor_rate_by_weight', array('vendor_id' => $id))->result_array();
        $data['by_distance'] = $this->Common_model->getAll('shipping_vendor_rate_by_distance', array('vendor_id' => $id))->result_array();
        $this->load->view("admin/shipping_vendor/view", $data);
    }

    //Ad By Weight
    function add_by_weight($id) {
        $data['vendor_id'] = $id;
        if (isset($_POST['submit'])) {
            $vendor_id = $this->input->post('vendor_id');
            $weight_arr = $this->input->post('weight');
            $weight_price_arr = $this->input->post('price');
            $zone_from_arr = $this->input->post('zone_from');
            $zone_to_arr = $this->input->post('zone_to');
            $weight_price_arr = $this->input->post('price');

            if (!empty($vendor_id)) {
                if (!empty($weight_arr)) {
                    $tot = count($weight_arr);

                    for ($i = 0; $i < $tot; $i++) {
                        $shipping_vendor_rate_by_weight['vendor_id'] = $vendor_id;
                        $shipping_vendor_rate_by_weight['zone_from'] = $zone_from_arr[$i];
                        $shipping_vendor_rate_by_weight['zone_to'] = $zone_to_arr[$i];
                        $shipping_vendor_rate_by_weight['weight'] = $weight_price_arr[$i];
                        $shipping_vendor_rate_by_weight['rate'] = $weight_price_arr[$i];
                        $this->Common_model->insert('shipping_vendor_rate_by_weight', $shipping_vendor_rate_by_weight);
                    }
                }


                $succ_msg = "Shipping Charges By Weight  Added Successfully";
                $this->session->set_flashdata('success', $succ_msg);
                redirect('admin/shipping_vendor/');
            }
        } else {
            $this->load->view("admin/shipping_vendor/add_by_weight", $data);
        }
    }

    //Ad By Distance
    function add_by_distance($id) {
        $data['vendor_id'] = $id;
        if (isset($_POST['submit'])) {
            $vendor_id = $this->input->post('vendor_id');
            $distance = $this->input->post('distance_from');
            $distance = $this->input->post('distance_to');
            $kg = $this->input->post('kg_from');
            $kg = $this->input->post('kg_to');
            $weight_price_arr = $this->input->post('price');

            //$this->form_validation->set_rules('zone_from','Zone From','required');


            if (!empty($vendor_id)) {
                if (!empty($distance)) {
                    $tot = count($distance);

                    for ($i = 0; $i < $tot; $i++) {
                        $shipping_vendor_rate_by_weight['vendor_id'] = $vendor_id;
                        $shipping_vendor_rate_by_weight['distance_from'] = $distance[$i];
                        $shipping_vendor_rate_by_weight['distance_to'] = $distance[$i];
                        $shipping_vendor_rate_by_weight['kg_from'] = $kg[$i];
                        $shipping_vendor_rate_by_weight['kg_to'] = $kg[$i];
                        $shipping_vendor_rate_by_weight['rate'] = $weight_price_arr[$i];
                        $this->Common_model->insert('shipping_vendor_rate_by_distance', $shipping_vendor_rate_by_weight);
                    }
                }


                $succ_msg = "Shipping Charges By Distance  Added Successfully";
                $this->session->set_flashdata('success', $succ_msg);
            }

            redirect('admin/shipping_vendor/');
        } else {
            $this->load->view("admin/shipping_vendor/add_by_distance", $data);
        }
    }

    function get_single_wt() {
        $id = $this->input->post('wt_id');
        if ($id != '') {
            $dat = $this->Common_model->getAll('shipping_vendor_rate_by_weight', array('id' => $id))->row_array();

            $str = '<div class="row">
			<input type="hidden" name="id" value="' . $id . '">
                                    <div class="col-md-6">
									<label>Zone From</label>
                                        <select class="form-control" name="zone_from" required>
															<option value="' . $dat["zone_from"] . '">' . $dat["zone_from"] . '</option>';
            $str.='<option value="EAST">EAST</option>
															<option value="WEST">WEST</option>
															<option value="NORTH">NORTH</option>
															<option value="SOUTH">SOUTH</option>
															<option value="CENTRAL">CENTRAL</option>
															<option value="NE">NE</option>
															<option value="NORTHEAST">NORTHEAST</option>
															</select>
                                    </div>
                                    <div class="col-md-6">
									<label>Zone To</label>
                                      <select class="form-control" name="zone_to" required>
															<option value="' . $dat["zone_to"] . '">' . $dat["zone_to"] . '</option>';
            $str.='<option value="EAST">EAST</option>
															<option value="WEST">WEST</option>
															<option value="NORTH">NORTH</option>
															<option value="SOUTH">SOUTH</option>
															<option value="CENTRAL">CENTRAL</option>
															<option value="NE">NE</option>
															<option value="NORTHEAST">NORTHEAST</option>
															</select>
                                    </div>
									<div class="col-md-6">
									<label>Weight</label>
                                      <input  type="number" value="' . $dat["weight"] . '" class="form-control" name="weight" placeholder="weight / Kg" required>
                                    </div>
									<div class="col-md-6">
									<label>Rate</label>
                                      <input type="number" class="form-control" value="' . $dat["rate"] . '" name="rate" placeholder="0" required>
                                    </div>
                                </div>';
            echo $str;
        }
    }

    function update_weight() {
        $id = $this->input->post('id');
        $data['zone_from'] = $this->input->post('zone_from');
        $data['zone_to'] = $this->input->post('zone_to');
        $data['weight'] = $this->input->post('weight');
        $data['rate'] = $this->input->post('rate');

        $this->form_validation->set_rules('zone_from', 'Zone From', 'required');

        $this->form_validation->set_rules('zone_to', 'Zone to', 'required');
        $this->form_validation->set_rules('weight', 'Weight', 'required');
        $this->form_validation->set_rules('rate', 'Rate', 'required');


        if ($this->form_validation->run() == false) {
            $err_msg = validation_errors();
            $this->session->set_flashdata('error', $err_msg);
        } else {
            if (!empty($id)) {
                $result = $this->Common_model->update('shipping_vendor_rate_by_weight', $data, array('id' => $id));
                $succ_msg = "Update Successfully";
                $this->session->set_flashdata('success', $succ_msg);
            }
        }
        redirect('admin/shipping_vendor');
    }

    function get_single_dist() {
        $id = $this->input->post('dist_id');
        if ($id != '') {
            $dat = $this->Common_model->getAll('shipping_vendor_rate_by_distance', array('id' => $id))->row_array();

            $str = '<div class="row">
			<input type="hidden" name="id" value="' . $id . '">
                                    <div class="col-md-6">
									<label>Distance From</label>
                                        <select class="form-control" name="distance_from" required>
															<option value="' . $dat["distance_from"] . '">' . $dat["distance_from"] . '</option>';
            $str.='<option value="20">20</option>
															<option value="51">51</option>
															<option value="101">101</option>
															<option value="151">151</option>
															<option value="201">201</option>
															</select>
                                    </div>
									<div class="col-md-6">
									<label>Distance To</label>
                                        <select class="form-control" name="distance_to" required>
															<option value="' . $dat["distance_to"] . '">' . $dat["distance_to"] . '</option>';
            $str.='<option value="50">50</option>
															<option value="100">100</option>
															<option value="150">150</option>
															<option value="200">200</option>
															<option value="250">250</option>
															</select>
                                    </div>
                                    <div class="col-md-6">
									<label>Kg From</label>
                                      <select class="form-control" name="kg_from" required>
															<option value="' . $dat["kg_from"] . '">' . $dat["kg_from"] . '</option>';
            $str.='<option value="0">0</option>
															<option value="101">101</option>
															<option value="251">251</option>
															<option value="501">501</option>
															<option value="1001">1001</option>
															</select>
                                    </div>
									<div class="col-md-6">
									<label>Kg To</label>
                                      <select class="form-control" name="kg_to" required>
															<option value="' . $dat["kg_to"] . '">' . $dat["kg_to"] . '</option>';
            $str.='<option value="100">100</option>
															<option value="250">250</option>
															<option value="500">500</option>
															<option value="1000">1000</option>
															<option value="1500">1500</option>
															</select>
                                    </div>
									
									<div class="col-md-4">
									<label>Rate</label>
                                      <input type="number" class="form-control" value="' . $dat["rate"] . '" name="rate" placeholder="0" required>
                                    </div>
                                </div>';
            echo $str;
        }
    }

    function update_distance() {
        $id = $this->input->post('id');
        $data['distance_from'] = $this->input->post('distance_from');
        $data['distance_to'] = $this->input->post('distance_to');
        $data['kg_from'] = $this->input->post('kg_from');
        $data['kg_to'] = $this->input->post('kg_to');
        $data['rate'] = $this->input->post('rate');

        $this->form_validation->set_rules('distance_from', 'distance from', 'required');
        $this->form_validation->set_rules('distance_to', 'distance to', 'required');

        $this->form_validation->set_rules('kg_from', 'kg from', 'required');
        $this->form_validation->set_rules('kg_to', 'kg to', 'required');
        $this->form_validation->set_rules('rate', 'Rate', 'required');


        if ($this->form_validation->run() == false) {
            $err_msg = validation_errors();
            $this->session->set_flashdata('error', $err_msg);
        } else {
            if (!empty($id)) {
                $result = $this->Common_model->update('shipping_vendor_rate_by_distance', $data, array('id' => $id));
                $succ_msg = "Update Successfully";
                $this->session->set_flashdata('success', $succ_msg);
            }
        }
        redirect('admin/shipping_vendor');
    }

    public function mark_default($id) {
        if (!empty($id)) {
            $this->Common_model->update('shipping_vendor', ['is_default' => 0], ['id !=' => $id]);
            $this->Common_model->update('shipping_vendor', ['is_default' => 1], ['id' => $id]);
            $this->session->set_flashdata('success', 'Shipping Vendor Marked As Default');
            redirect('admin/shipping_vendor');
        }
    }

    public function delete_by_weight($id) {
        if ($id) {
            $delete_status = $this->Common_model->delete('shipping_vendor_rate_by_weight', ['id' => $id]);
            if ($delete_status == 1) {
                $this->session->set_flashdata('error', 'Record Deleted');
                redirect('admin/shipping_vendor');
            }
        }
    }

    public function delete_by_distance($id) {
        if ($id) {
            $delete_status = $this->Common_model->delete('shipping_vendor_rate_by_distance', ['id' => $id]);
            if ($delete_status == 1) {
                $this->session->set_flashdata('error', 'Record Deleted');
                redirect('admin/shipping_vendor');
            }
        }
    }

}
