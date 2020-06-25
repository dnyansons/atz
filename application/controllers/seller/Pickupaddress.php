<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Pickupaddress extends CI_Controller {

    public function __construct() {
        parent::__construct();
        if (!$this->session->userdata("user_logged_in") || $this->session->userdata("user_role") != "seller") {
            $error = "<div id='login-error' class='form-error notice notice-error'><span class='icon-notice icon-error'></span><span><strong>Error!</strong> Session timeout, relogin!. </span></div>";
            $this->session->set_flashdata("message", $error);
            redirect("login", "refresh");
        }
        $this->load->model('Pickaddress_model');
        $this->load->model('Shipping_model');
        $this->load->library("Send_data");
        $this->load->library("Shiprocket");
    }

    public function index() {
        $data["pageTitle"] = "My Pick Up Address";
        $this->load->view("user/pickupaddr/list", $data);
    }

    public function ajax_list() {
        $user_id = $this->session->userdata("user_id");

        $columns = array(
            0 => 'pick_id',
            1 => 'seller_name',
            2 => 'seller_email',
            3 => 'seller_mobile',
            4 => 'address_type',
            5 => 'address',
            6 => 'name',
            7 => 'pincode',
            8 => 'is_default',
        );

        $limit = $this->input->post('length');
        $start = $this->input->post('start');
        $order = $columns[$this->input->post('order')[1]['column']];
        $dir = $this->input->post('order')[1]['dir'];

        $totalData = $this->Pickaddress_model->alladdr_count($user_id);


        $totalFiltered = $totalData;

        if (empty($this->input->post('search')['value'])) {
            $aladdress = $this->Pickaddress_model->alladdr($user_id, $limit, $start, $order, $dir);
        } else {
            $search = $this->input->post('search')['value'];

            $aladdress = $this->Pickaddress_model->addr_search($user_id, $limit, $start, $search, $order, $dir);
            //echo $this->db->last_query();

            $totalFiltered = $this->Pickaddress_model->addr_search_count($user_id, $search);
        }


        $data = array();
        $sl = 0;
        if (!empty($aladdress)) {
            foreach ($aladdress as $br) {
                $sl++;
                if ($br->is_default == 1) {
                    $is_default = 'YES';
                } else {
                    $is_default = 'NO';
                }
                $nestedData['sr_no'] = $sl;
                $nestedData['seller_name'] = $br->seller_name;
                $nestedData['seller_email'] = $br->seller_email;
                $nestedData['seller_mobile'] = $br->seller_mobile;
                $nestedData['address_type'] = $br->address_type;
                $nestedData['address'] = $br->address;
                $nestedData['name'] = $br->name;
                $nestedData['pincode'] = $br->pincode;
                $nestedData['is_default'] = $is_default;

                $nestedData['action'] = '<a type="button" href="' . base_url() . 'seller/pickupaddress/updateaddr/' . $br->pick_id . '" class="btn btn-warning btn-sm">Update</a>
		<a onclick="return confirm(&apos;Are You Sure ?&apos;)" type="button" href="' . base_url() . 'seller/pickupaddress/deleteaddr/' . $br->pick_id . '" class="btn btn-danger btn-sm">Delete</a>';

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

    public function addaddr() { // add addaddr
        if ($_SERVER['REQUEST_METHOD'] == "POST") {

            $this->form_validation->set_rules("seller_name", "Name", "required");
            $this->form_validation->set_rules("seller_email", "Email", "required");
            $this->form_validation->set_rules("seller_mobile", "Mobile", "required");
            $this->form_validation->set_rules("address", "Address", "required");
            $this->form_validation->set_rules("address2", "Address Two", "required");
            $this->form_validation->set_rules("address3", "Address Three", "required");
            $this->form_validation->set_rules("pincode", "Pincode", "required");
            $this->form_validation->set_rules("office_close", "office close", "required");
            $this->form_validation->set_rules('pincode', 'Pincode', 'required|max_length[6]|min_length[6]');
            $this->form_validation->set_rules('city', 'City', 'required');

            if ($this->form_validation->run() === false) {
                $msg = '<span style="color:red;">' . validation_errors() . '</span>';

                $this->session->set_flashdata('message', $msg);
                redirect("seller/pickupaddress");
                exit;
            } else {
                $ship_method = $this->send_data->get_shipping_method();
                if ($ship_method == 1) {
                    $check_postcode = $this->Shipping_model->get_buyer_area($this->input->post('pincode'));
                    if (empty($check_postcode)) {
                        $msg = "<div class='alert alert-danger alert-dismissible'>
                               <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                               <strong>Error !</strong> Pincode Not Pickable !.
                            </div>";
                        $this->session->set_flashdata('message', $msg);

                        redirect(base_url() . "seller/pickupaddress/addaddr");
                        exit;
                    }
                }

                if ($ship_method == 2) {
                    $seller_pincode = 411057;
                    $buyer_pincode = $this->input->post("pincode");

                    $res = $this->shiprocket->serviceability($seller_pincode, $buyer_pincode, 1, 0.5, 0.5, 0.5, 1);

                    if ($res['status'] != 200) {
                        $msg = "<div class='alert alert-danger alert-dismissible'>
                               <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                               <strong>Error !</strong> Pincode Not Pickable !.
                            </div>";
                        $this->session->set_flashdata('message', $msg);

                        redirect(base_url() . "seller/pickupaddress/addaddr");
                        exit;
                    }
                }


                $data = $this->input->post();
                $data['user_id'] = $this->session->userdata("user_id");
                if ($ship_method == 1) {
                    $check_postcode = $this->Shipping_model->get_buyer_area($this->input->post('pincode'));
                    if (empty($check_postcode)) {
                        $msg = '<div style="color:red;" Pincode Not Pickable !.
                            </div>';
                        $this->session->set_flashdata('message', $msg);
                        redirect(base_url() . "seller/pickupaddress");
                        exit;
                    }
                }

                $data['created_at'] = date('Y-m-d H:i:s');
                $data['updated_at'] = date('Y-m-d H:i:s');

                $is_default = $this->input->post('is_default');
                if ($is_default == 1) {
                    $data['is_default'] = 1;
                } else {
                    $data['is_default'] = 0;
                }

                $result = $this->Common_model->insert('seller_pick_address', $data);

                if ($result) {
                    $postData = array(
                        'pickup_location' => 'DEMO' . $result,
                        'name' => $this->input->post("seller_name"),
                        'email' => $this->input->post("seller_email"),
                        'phone' => $this->input->post("seller_mobile"),
                        'address' => $this->input->post("address"),
                        'address_2' => $this->input->post("address"),
                        'city' => $this->input->post("city"),
                        'state' => $this->input->post("state"),
                        'country' => 'India',
                        'pin_code' => $this->input->post("pincode"),
                    );
                    if ($ship_method == 2) {
                       
                        $response = $this->shiprocket->add_new_pickup(json_encode($postData));
                        if ($response!= 1) {
                            $this->Common_model->delete('seller_pick_address', array("pick_id" => $result));
                            $msg = "<div class='alert alert-danger alert-dismissible'>
                               <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                               <strong>Error !</strong> Not Added In server
                            </div>";
                            $this->session->set_flashdata('message', $msg);
                            redirect(base_url() . "seller/pickupaddress");
                        }
                    }

                    if ($is_default == 1) {
                        $this->db->query('update seller_pick_address set is_default=0 where pick_id!="' . $result . '"');
                    }

                    $msg = "<div class='alert alert-success alert-dismissible'>
                               <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                               <strong>Success !</strong> Address Added Successfully !.
                            </div>";

                    $this->session->set_flashdata('message', $msg);
                    redirect(base_url() . "seller/pickupaddress");
                }
            }
        } else {
            $data['title'] = "Add Address";
            $data['country'] = $this->Common_model->getAll('country')->result_array();
            $this->load->view('user/pickupaddr/create', $data);
        }
    }

    public function updateaddr($addr_id) { // update addr_id
        $user_id = $this->session->userdata("user_id");
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $this->form_validation->set_rules("seller_name", "Name", "required");
            $this->form_validation->set_rules("seller_email", "Email", "required");
            $this->form_validation->set_rules("seller_mobile", "Mobile", "required");
            $this->form_validation->set_rules("address", "Address", "required");
            $this->form_validation->set_rules("address2", "Address Two", "required");
            $this->form_validation->set_rules("address3", "Address Three", "required");
            $this->form_validation->set_rules("pincode", "Pincode", "required");
            $this->form_validation->set_rules('pincode', 'Pincode', 'required|max_length[6]|min_length[6]');

            if ($this->form_validation->run() === false) {
                $msg = '<span style="color:red;">' . validation_errors() . '</span>';

                $this->session->set_flashdata('message', $msg);
                redirect(base_url() . "seller/pickupaddress");
                exit;
            } else {
                $ship_method = $this->send_data->get_shipping_method();
                if ($ship_method == 1) {
                    $check_postcode = $this->Shipping_model->get_buyer_area($this->input->post('pincode'));

                    if (empty($check_postcode)) {
                        $msg = '<div style="color:red;" Pincode Not Pickable !
                            </div>';
                        $this->session->set_flashdata('message', $msg);

                        redirect(base_url() . "seller/pickupaddress/updateaddr/$addr_id");
                        exit;
                    }
                }


                $data = $this->input->post();

                $data['updated_at'] = date('Y-m-d H:i:s');

                $is_default = $this->input->post('is_default');
                if ($is_default == 1) {
                    $data['is_default'] = 1;
                } else {
                    $data['is_default'] = 0;
                }


                $result = $this->Common_model->update("seller_pick_address", $data, array("pick_id" => $addr_id, "user_id" => $user_id));

                if ($is_default == 1) {
                    $this->db->query('update seller_pick_address set is_default=0 where pick_id!="' . $addr_id . '"');
                }

                if ($result) {
                    $msg = '<div class="alert alert-success alert-dismissible">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                            <strong>Success!</strong> Update successfully.
                        </div>';
                    $this->session->set_flashdata('message', $msg);
                    redirect(base_url() . "seller/pickupaddress");
                }
            }
        } else {
            $data['title'] = "Edit Address";

            $data['country'] = $this->Common_model->getAll('country')->result_array();

            $data['addr_data'] = $this->Pickaddress_model->getaddress($addr_id);

            $data["pageTitle"] = "Manage Pickup Address";
            $this->load->view('user/pickupaddr/edit', $data);
        }
    }

    function deleteaddr($pick_id = 0) {
        $user_id = $this->session->userdata("user_id");

        $result = $this->Common_model->delete('seller_pick_address', array('pick_id' => $pick_id, "user_id" => $user_id));
        if ($result) {
            $msg = '<span style="color:red;">Delete Successfully !</span>';
            $this->session->set_flashdata('message', $msg);
            redirect(base_url() . "seller/pickupaddress");
        }
    }

}
