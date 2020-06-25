<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Banks extends CI_Controller {

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
            $this->load->library("Datatables");
            $this->load->library('table');
            $this->load->model('Offer_model');
            $this->load->model('Common_model');
            $this->load->model('Categories_model');
            $this->load->model('Product_model');
            $this->load->model('Bank_model');
            $this->load->model('adminusers_model', 'adminusers_model');
            $this->load->library('Userpermission');
            $this->load->library('awsupload');
    }

    public function index() {

        $data["pageTitle"] = "Banks List";
        $data["status"] = 1;
        $this->load->view("admin/banks/banklists", $data);
    }
    
    public function ajax_list()
    {
        $list = $this->Bank_model->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $bank) { 
            $no++;
            $row = array();
            $row[] = $bank->id;
            $row[] = $bank->bank_name;
            $row[] = ($bank->status==0)?"<button class='btn btn-danger btn-sm btn-deactivate' data-aid='".$bank->id."'>Deactivate</button>":"<button class='btn btn-info btn-sm btn-activate' data-aid='".$bank->id."'>activate</button>";
            $data[] = $row;
        }
        
        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->Bank_model->count_all(),
                        "recordsFiltered" => $this->Bank_model->count_filtered(),
                        "data" => $data,
                );
        
        echo json_encode($output);
    }
    
    public function addBank(){
        $this->form_validation->set_rules('bank_name', 'Bank Name', 'required');
        if ($this->form_validation->run() == FALSE) {
          $data['title']="Add Bank"; 
          $this->load->view('admin/banks/addbank',$data);
        }
        else{
        $data['bank_name'] = $this->input->post('bank_name');
        $data['country'] = 99;
        $data['status'] = 1;
        $result = $this->Common_model->insert('banks', $data);
        $msg = '<div class="alert alert-success background-success">
                                          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                          <i class="icofont icofont-close-line-circled text-white"></i>
                                          </button>
                                          <strong>Bank Added Successfully
                                          </div>';
        $this->session->set_flashdata('message', $msg);
        redirect("admin/banks","refresh");
      }
    }
}
