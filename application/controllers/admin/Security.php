<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Security extends CI_Controller 
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
        $this->load->model('Security_model');
        $this->load->library('Userpermission');
    }

    public function index() 
    {
        $data["pageTitle"] = "Security Questions Master";
        $this->load->view("admin/security/list");
    }
	
	public function ajax_list() 
    {
		$result = $this->Security_model->get_list($id='');
		$this->output->set_output(json_encode($result));
	}
	
    public function add_questions() 
    {
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $todays_date = date('Y-m-d H:i:s');
            $arr = array();
            $arr["questions"] = $this->input->post('questions');
            $arr["added_date"] = $todays_date;

            $result = $this->Security_model->add_questions($id = '', $arr);
            $error = "<div class='alert alert-success alert-dismissible'>
                        <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                        <strong>Success!</strong> Security question added successfully!.
                      </div>";
            $this->session->set_flashdata("message", $error);
            redirect('admin/security');
        }
        $this->load->view("admin/common/header");
        $this->load->view("admin/security/add");
        $this->load->view("admin/common/footer");
    }

    public function edit_questions($id)
    {

        $data['result'] = $this->Security_model->get_list($id);
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $todays_date = date('Y-m-d H:i:s');
            $arr = array();
            $arr["questions"] = $this->input->post('questions');
            $arr["added_date"] = $todays_date;

            $result = $this->Security_model->add_questions($id, $arr);
            $error = "<div class='alert alert-success alert-dismissible'>
                        <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                        <strong>Success!</strong> Security question updated successfully!.
                      </div>";
            $this->session->set_flashdata("message", $error);
            redirect('admin/security');
        }
        $this->load->view("admin/common/header");
        $this->load->view("admin/security/edit", $data);
        $this->load->view("admin/common/footer");
    }
	
	public function delete_questions($id)
	{
		$result = $this->Security_model->delete_questions($id);
		$error = "<div class='alert alert-success alert-dismissible'>
                        <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                        <strong>Success!</strong> Security question deleted successfully!.
                      </div>";
            $this->session->set_flashdata("message", $error);
		redirect('admin/security');
	}

}