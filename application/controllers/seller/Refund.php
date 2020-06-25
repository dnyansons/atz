<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Refund extends CI_Controller {

    public function __construct() {
        parent::__construct();
        if (!$this->session->userdata("user_logged_in") || $this->session->userdata("user_role") != "seller") {
            $error = "<div id='login-error' class='form-error notice notice-error'><span class='icon-notice icon-error'></span><span><strong>Error!</strong> Session timeout, relogin!. </span></div>";
            $this->session->set_flashdata("message", $error);
            redirect("login", "refresh");
        }
        $this->load->model('Product_model');
        $this->load->model('Refund_model');
        $this->load->model('Common_model');
        $this->load->model('Users_model');
        $this->load->library('Send_data');
        $this->load->library('awsupload');
    }

    public function index() {
        $data["pageTitle"] = "My Refund";
        $this->load->view("user/refund/list", $data);
    }

    public function ajax_list() {
        $ret_id = $this->session->userdata("user_id");

        $columns = array(
            0 => 'orders_id',
            1 => 'final_price',
            2 => 'orders_status',
            3 => 'created_at',
        );

        $limit = $this->input->post('length');
        $start = $this->input->post('start');
        $order = $columns[$this->input->post('order')[1]['column']];
        $dir = $this->input->post('order')[1]['dir'];

        $totalData = $this->Refund_model->allrefund_count($ret_id);
        // echo $this->db->last_query();

        $totalFiltered = $totalData;

        if (empty($this->input->post('search')['value'])) {
            $alorder = $this->Refund_model->allrefund($ret_id, $limit, $start, $order, $dir);
            //echo $this->db->last_query();
        } else {
            $search = $this->input->post('search')['value'];

            $alorder = $this->Refund_model->refund_search($ret_id, $limit, $start, $search, $order, $dir);
            //echo $this->db->last_query();

            $totalFiltered = $this->Refund_model->refund_search_count($ret_id, $search);
        }

        $data = array();
        if (!empty($alorder)) {
            foreach ($alorder as $br) {
                $nestedData['orders_id'] = $br->orders_id;
                $nestedData['final_price'] = $br->f_price;
                $nestedData['orders_status'] = $br->orders_status;
                $nestedData['created_at'] = date('d-m-Y H:i:s', strtotime($br->created_at));
                //$nestedData['action'] = '<button title="View Detail" type="button" onclick="view_refund('.$br->orders_id.')" class="btn btn-info btn-sm" data-toggle="modal" data-target="#myRefund"><i class="fa fa-eye"></i></button>';
                $nestedData['action'] = '<a href="' . base_url() . 'seller/refund/view_refund/' . $br->orders_id . '" title="View Detail" class="btn btn-info btn-sm"><i class="fa fa-eye"></i></a>';

                $data[] = $nestedData;
            }
        }

        $json_data = array(
            "draw" => intval($this->input->post('draw')),
            "recordsTotal" => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data" => $data
        );

        echo json_encode($json_data);
    }

    function view_refund($order_id) {
        if ($order_id != '') {

            $data['order_id'] = $order_id;
            $data['refund'] = $this->Refund_model->single_refund($order_id);
            $data['refund_history'] = $this->Refund_model->refund_history($order_id);

            $this->load->view('user/refund/view_refund', $data);
        } else {
            redirect("seller/refund", "refresh");
        }
    }

    function refund_view() {
        $order_id = $this->input->post('order_id');
        $refund = $this->Refund_model->single_refund($order_id);
        $refund_reason = $this->Refund_model->refund_reason($order_id);

        $str = '';
        $str .= '<table class="table" style="width:100%">';
        $i = 0;
        foreach ($refund as $fund) {
            if ($i == 0) {
                $str .= '<tr>';
                $str .= '<th>Product Name</th>';
                $str .= '<td>' . $fund->products_name . '</td>';
                $str .= '</tr>';
                $str .= '<tr>';
                $str .= '<th>Refund Status</th>';
                $str .= '<td>' . $fund->orders_status . '</td>';
                $str .= '</tr>';
                $str .= '<tr>';
                $str .= '<tr>';
                $str .= '<th>Refund Reason</th>';
                if (!empty($fund->reason_name)) {
                    $str .= '<td>' . $fund->reason_name . '</td>';
                } else {
                    $str .= '<td>' . $fund->other_reason . '</td>';
                }
                $str .= '</tr>';
                $str .= '<tr>';

                $str .= '<th colspan="2" style="text-align:center;" class="alert alert-info">Request Process</th>';
                $str .= '</tr>';
            }
            //Refund History
            $str .= '<tr>';
            $str .= '<th colspan="2"><i class="fa fa-space-shuttle"></i>&nbsp;&nbsp;' . $fund->comment . '</th>';
            $str .= '</tr>';
            $i++;
        }

        $str .= '</table>';
        echo $str;
    }

    //As Supplier
    //As Supplier
    function refund_request() {
        $data["pageTitle"] = "Refund Request";
        $this->load->view("user/refund/refund_request_list", $data);
    }

    function all_request_ajax_list() {
        $ret_id = $this->session->userdata("user_id");

        $columns = array(
            0 => 'orders_id',
            1 => 'order_price',
            2 => 'refund_amount',
            3 => 'orders_status',
        );

        $limit = $this->input->post('length');
        $start = $this->input->post('start');
        $order = $columns[$this->input->post('order')[1]['column']];
        $dir = $this->input->post('order')[1]['dir'];

        $totalData = $this->Refund_model->allrefund_count_supplier($ret_id);


        $totalFiltered = $totalData;

        if (empty($this->input->post('search')['value'])) {
            $alorder = $this->Refund_model->allrefund_supplier($ret_id, $limit, $start, $order, $dir);
        } else {
            $search = $this->input->post('search')['value'];

            $alorder = $this->Refund_model->refund_search_supplier($ret_id, $limit, $start, $search, $order, $dir);

            $totalFiltered = $this->Refund_model->refund_search_count_supplier($ret_id, $search);
        }

        $data = array();
        if (!empty($alorder)) {
            foreach ($alorder as $br) {
                if (($br->orders_status == 'Case Canceled') || ($br->orders_status == 'Approved by Supplier') || ($br->orders_status == 'Case Completed')) {
                    $button = '';
                    $proof_arr = json_decode($br->supplier_proof);
                    $count_proof = count($proof_arr);
                    if ($count_proof > 0) {
                        $button = ' <button title="Supplier Evidence" type="button" onclick="supp_evidence(' . $br->orders_id . ')" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#suppEvidence"><i class="fa fa-info-circle"></i></button> ';
                    }
                } else {
                    if ($br->orders_status == 'Initiated') {
                        $button = ' <a class="btn btn-warning btn-sm" href="' . base_url() . 'seller/refund/refund_action/' . $br->orders_id . '" title="Action On Refund">Action</a>
					';
                    }
                }
                $nestedData['orders_id'] = $br->orders_id;
                $nestedData['final_price'] = $br->f_price;
                $nestedData['refund_amount'] = $br->refund_amount;
                $nestedData['orders_status'] = $br->orders_status;

                /* $nestedData['action'] = '<button title="View Detail" type="button" onclick="view_refund('.$br->orders_id.')" class="btn btn-info btn-sm" data-toggle="modal" data-target="#myRefund"><i class="fa fa-eye"></i></button>'.$button; */
                $nestedData['action'] = '<a href="' . base_url() . 'seller/refund/view_refund/' . $br->orders_id . '" title="View Detail" class="btn btn-info btn-sm"><i class="fa fa-eye"></i></a>' . $button;
                ;


                $data[] = $nestedData;
            }
        }

        $json_data = array(
            "draw" => intval($this->input->post('draw')),
            "recordsTotal" => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data" => $data
        );

        echo json_encode($json_data); 
	}
	
	
    //Supplier Refund Action 
    function refund_action($order_id = 0) {
        $data["pageTitle"] = "Order Refund Action";
        $data["order_id"] = $order_id;
        $this->load->view("user/refund/refund_action_view", $data);
    }

    function action_on_refund() {
        $orders_id = $this->input->post('orders_id');
        if (!empty($orders_id)) {
            $ch_cancel_status = 0;
            $data['orders_status'] = $this->input->post('orders_status');
            if ($data['orders_status'] == 'Case Canceled') {
                $ch_cancel_status = 1;
                $data['supplier_reason'] = $this->input->post('supplier_reason');
                //Upload Evidence
                if (!empty($_FILES['userFiles']['name'])) {
                    $s3FilePath = $this->awsupload->multiUpload($_FILES, 'uploads/order_refund', 'image');
                    if ($s3FilePath == false) {
                        //error
                        echo json_encode(array('msg' => 'File not uploaded!'));
                    } else {
                        //success
                        $data['supplier_proof'] = json_encode($s3FilePath, true);
                    }
                }
            }

            if ($ch_cancel_status == 0) {
                //Order Status

                $ch_processing = $this->Common_model->getAll('orders_history', array('status' => 10, 'orders_id' => $orders_id))->num_rows();

                $ch_picked = $this->Common_model->getAll('orders_history', array('status' => 18, 'orders_id' => $orders_id))->num_rows();


                //get Order
                $order = $this->Common_model->getAll('orders', array('orders_id' => $orders_id))->row_array();
                $order_price = $order['order_price'];
                $shipping_cost = $order['shipping_cost'];

                if ($ch_processing > 0 && $ch_picked == 0) {
                    $refund_price = $order_price;
                } elseif ($ch_processing > 0 && $ch_picked == 1) {
                    $refund_price = $order_price - $shipping_cost;
                } else {
                    $refund_price = 0;
                }

                $data['refund_amount'] = $refund_price;
            }


            $result = $this->Common_model->update("order_refund", $data, array("orders_id" => $orders_id));
            if ($result) {
                $data_hist['orders_id'] = $orders_id;
                $data_hist['comment'] = $this->input->post('orders_status');
                $data_hist['created_at'] = date('Y-m-d H:i:s');
                $this->Common_model->insert('order_refund_history', $data_hist);


                $adminNotify = array(
                    'title' => 'Seller Action on Order Refund Request',
                    'msg' => $this->input->post('orders_status') . ' By Seller ',
                    'type' => 'order_refund',
                    'reference_id' => $order_id,
                    'status' => 'Received'
                );

                $insertAdminNotify = $this->Product_model->insertAdminNotify($adminNotify);

                //Get User Mob Number
                $mob = $this->Users_model->get_user_mob_number_by_order_id($orders_id);

                $message = 'Your Refund Order Request ' . $this->input->post('orders_status');
                $this->send_data->send_sms($message, $mob);



                $msg = "<div class='alert alert-success alert-dismissible'>

									<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
									<strong>Success !</strong> Refund Status Update Successfully !
								  </div>";
            } else {
                $msg = "<div class='alert alert-danger alert-dismissible'>
									<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
									<strong>Error !</strong> Refund Status Not Update !
								  </div>";
            }
        } else {
            $msg = "<div class='alert alert-danger alert-dismissible'>
									<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
									<strong>Error !</strong> Refund Order Not Found ! !
								  </div>";
			
		}
		$this->session->set_flashdata('message',$msg);
		redirect('seller/refund/refund_request');
	}
	
	
	public function file_check(){

        $allowed_mime_type_arr = array('image/jpeg','image/jpg','image/png');
        $mime = get_mime_by_extension($_FILES['logo']['name']);
        if(isset($_FILES['logo']['name']) && $_FILES['logo']['name']!=""){
            if(in_array($mime, $allowed_mime_type_arr)){
                return true;
            }else{

                 $msg= '<div class="alert alert-danger alert-dismissible">
                                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                    <strong>Error!</strong> Please select only jpg/png file.!
                                </div>';
            $this->session->set_flashdata('message',$msg);
            redirect('seller/companyprofile');
            // $this->form_validation->set_message('file_check', 'Please select only pdf/jpg/png file.');
                return false;
            }
        }else{

             $msg= '<div class="alert alert-danger alert-dismissible">
                                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                    <strong>Error!</strong> Please choose a file to upload.!
                                </div>';
             $this->session->set_flashdata('message',$msg);     
             redirect('seller/companyprofile');              
             // $this->form_validation->set_message('file_check', 'Please choose a file to upload.');
            return false;
        }
       
    }

    //Supplier Evidence Viewfunction 
    function supp_evidence_view() {
        $str = '';
        $orders_id = $this->input->post('orders_id');
        $result = $this->Common_model->getAll("order_refund", array("orders_id" => $orders_id))->row_array();
        if ($result) {
            $proof_arr = json_decode($result['supplier_proof']);
            $count_proof = count($proof_arr);
            if ($count_proof > 0) {
                for ($i = 1; $i <= $count_proof; $i++) {
                    if (!empty($proof_arr[$i])) {
                        $str .= '<div class="col-xs-6 col-md-3"><div class="thumbnail">
 
							 <div class="thumb">
							<a href="' . $proof_arr[$i] . '" data-lightbox="1" data-title="My caption 1">
							<img src="' .$proof_arr[$i]. '" alt="" class="img-fluid img-thumbnail">
							</a>
							</div>
							</div>
							</div>';
                    }
                }
            } else {
                $str = 'No Cancel Evidence Found !';
            }
        } else {
            $str = 'No Cancel Evidence Found !';
        }
        echo $str;
    }

}
