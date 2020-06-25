<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Refund_reason extends CI_Controller 
{

    public function __construct() 
    {
        parent::__construct();
        if (!$this->session->userdata("admin_logged_in")) {
            $error = "<div class='alert alert-danger alert-dismissible'>
                        <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                        <strong>Error!</strong> Session timeout, relogin!.
                      </div>";
            $this->session->set_flashdata("message", $error);
            redirect("admin/login", "refresh");
        }
        $this->load->library("Datatables");
        $this->load->library('table');
        $this->load->model('Refund_reason_model');
        $this->load->library('Userpermission');
    }

    public function index() 
    {
        $this->load->view("admin/common/header");
        $this->load->view("admin/refund_reason/list");
        $this->load->view("admin/common/footer");
    }

    public function ajax_list() 
    {
        $result = $this->Refund_reason_model->get_list($id = '');
        $this->output->set_output(json_encode($result));
    }

    public function add_reason() 
    {
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $todays_date = date('Y-m-d H:i:s');
            $arr = array();
			$arr["reason_type"] = $this->input->post('reason_type');
            $arr["reason_name"] = $this->input->post('reason');
            $arr["status"] = $this->input->post('status');
            $arr["created_at"] = $todays_date;

            $result = $this->Refund_reason_model->add_reason($id = '', $arr);
            $message = "<div class='alert alert-success alert-dismissible'>
                                    <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                                    <strong>Success!</strong> Refund Reason Added Successfully.
                                    </div>";
            $this->session->set_flashdata("message", $message);
            redirect('admin/refund_reason');
        }
        $this->load->view("admin/common/header");
        $this->load->view("admin/refund_reason/add");
        $this->load->view("admin/common/footer");
    }

    public function edit_reason($id) 
    {
        $data['result'] = $this->Refund_reason_model->get_list($id);
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $todays_date = date('Y-m-d H:i:s');
            $arr = array();
            $arr["reason_name"] = $this->input->post('reason');
            $arr["status"] = $this->input->post('status');
            $arr["created_at"] = $todays_date;
            $message = "<div class='alert alert-success alert-dismissible'>
                                    <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                                    <strong>Success!</strong> Refund Reason Updated Successfully.
                                    </div>";
            $this->session->set_flashdata("message", $message);
            $result = $this->Refund_reason_model->add_reason($id, $arr);
            redirect('admin/refund_reason');
        }
        $this->load->view("admin/common/header");
        $this->load->view("admin/refund_reason/edit", $data);
        $this->load->view("admin/common/footer");
    }

    public function delete_reason($id) 
    {
        $result = $this->Refund_reason_model->delete_reason($id);
         $message = "<div class='alert alert-success alert-dismissible'>
                                    <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                                    <strong>Success!</strong> Refund Reason Deleted Successfully.
                                    </div>";
            $this->session->set_flashdata("message", $message);
        redirect('admin/refund_reason');
    }

}
