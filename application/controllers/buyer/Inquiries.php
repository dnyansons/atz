<?php

defined('BASEPATH') OR exit("Direct access denied");

class Inquiries extends CI_Controller {

    public function __construct() {
        parent::__construct();
        if (!$this->session->userdata("user_logged_in")) {
            $error = "<div id='login-error' class='form-error notice notice-error'><span class='icon-notice icon-error'></span><span><strong>Error!</strong> Session timeout, relogin!. </span></div>";
            $this->session->set_flashdata("message", $error);
            redirect("login", "refresh");
        }
        $this->load->model("Inquiries_model");
        $this->load->model("Rfqs_model");
        $this->load->library("upload");
        $this->load->model("Product_model");
        $this->load->library("get_header_data");
    }

    public function index() {
        $data = $this->get_header_data->get_categories();
        $data["title"] = "ATZCart - Buyers Inquiries";
        $user_id = $this->session->userdata("user_id");
        //Update Views Status
        $upviewed['viewed_by_user'] = 1;
        $this->Common_model->update('inquiries', $upviewed, array('by_user' => $user_id, 'viewed_by_user' => 0));
        $this->load->view("front/myaccount/buyer_inquiries", $data);
    }

    public function get_inquiries() {
        $user_id = $this->session->userdata('user_id');
        $res = $this->Inquiries_model->count_inquiries($user_id);
        $data['inquiries'] = $res;
        $this->output->set_output(json_encode($data));
    }

//    public function getSellerReply() {
//        $inquiry_id = $this->input->post('inquiry_id');
//        $result = $this->Inquiries_model->getSellerReply($inquiry_id);
//        echo json_encode($result);
//    }

    //////////////Buyer wise Enquires//////////////////////

    function myenquiry_list() {
        $data["Title"] = "My Inquiries";
        $this->load->view("user/inquiries/buyer_enquiry_list", $data);
    }

    function buyer_ajax_enquires_list() {
        $user_id = $this->session->userdata("user_id");

        $columns = array(
            0 => 'id',
            1 => 'comment',
            2 => 'for_product',
            3 => 'quantity',
            4 => 'is_forwarded',
            5 => 'added_date',
        );

        $limit = $this->input->post('length');
        $start = $this->input->post('start');
        $order = $columns[$this->input->post('order')[0]['column']];
        $dir = $this->input->post('order')[0]['dir'];

        $totalData = $this->Inquiries_model->allenq_count($user_id);


        $totalFiltered = $totalData;

        if (empty($this->input->post('search')['value'])) {
            $enquiry = $this->Inquiries_model->allbuyerenquiries($user_id, $limit, $start, $order, $dir);
        } else {
            $search = $this->input->post('search')['value'];

            $enquiry = $this->Inquiries_model->buyer_enquires_search($user_id, $limit, $start, $search, $order, $dir);
            //echo $this->db->last_query();

            $totalFiltered = $this->Inquiries_model->buye_renquiries_search_count($user_id, $search);
        }

        $data = array();
        if (!empty($enquiry)) {
            foreach ($enquiry as $se) {

                if ($se->is_forwarded == 0) {
                    $for = 'No';
                } else {
                    $for = 'Yes';
                }
                $nestedData['id'] = $se->id;
                $nestedData['comment'] = $se->comment;
                $nestedData['for_product'] = $se->name;
                $nestedData['quantity'] = $se->quantity . ' / ' . $se->units_name;
                $nestedData['is_forwarded'] = $for;
                $nestedData['created_on'] = date('d-m-Y H:i:s', strtotime($se->added_date));
                $nestedData['action'] = "<a class='btn btn-link' href='" . base_url() . "product-details/" . $se->name . "/" . $se->for_product . "'>Place Order</a>";
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
//
//    public function myrfqs() {
//        $user_id = $this->session->userdata("user_id");
//        $rfqs = $this->Rfqs_model->getRfqByUser($user_id);
//        $data["Title"] = "My Rfq List";
//        echo "<pre>";
//        print_r($rfqs);
//    }

}
