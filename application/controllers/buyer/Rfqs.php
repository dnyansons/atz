<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Rfqs extends CI_Controller {

    public function __construct() {
        parent::__construct();
        if (!$this->session->userdata("user_logged_in")) {
            $error = "<div id='login-error' class='form-error notice notice-error'><span class='icon-notice icon-error'></span><span><strong>Error!</strong> Session timeout, relogin!. </span></div>";
            $this->session->set_flashdata("message", $error);
            redirect("login", "refresh");
        }
        $this->load->model('Rfqs_model');
        $this->load->model('Inquiries_model');
        $this->load->library("form_validation");
        $this->load->library("email");
        $this->load->library("get_header_data");
    }

    public function index() {

        $data = $this->get_header_data->get_categories();
        $data["title"] = "ATZCart - Buyer RFQS";
        $this->load->view("front/myaccount/rfq/buyers_rfqs", $data);
    }

    public function get_RFQsStatus() {
        $user_id = $this->session->userdata("user_id");
        $data["pending"] = $this->Rfqs_model->getPendingRFQs($user_id);
        $data["approved"] = $this->Rfqs_model->getApprovedRFQs($user_id);
        $data["rejected"] = $this->Rfqs_model->getRejectedRFQs($user_id);
        echo json_encode($data);
    }

    public function getSellerReply() {
        $rfq_id = $this->input->post('rfqs_id');
        $result = $this->Rfqs_model->getSellerReply($rfq_id);
        echo json_encode($result);
    }

}
