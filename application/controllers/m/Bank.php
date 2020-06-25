<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Bank extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('Users_model');
        $this->load->model('Common_model');
        $this->load->library("form_validation");
        $this->load->library("get_header_data");
    }

    public function index() {
        
        $user = $this->session->userdata("user_id");
        $data = $this->get_header_data->get_categories();
        $this->form_validation->set_rules("acc_no", "Account Number", "required|numeric");
        $this->form_validation->set_rules("bank_name", "Bank Name", "required");
        $this->form_validation->set_rules("ifsc_code", "IFSC Code", "trim|required");
        $this->form_validation->set_rules("acc_holder_name", "Account Holder Name", "required");
        $this->form_validation->set_error_delimiters('<p style="color:red" class="text-left">', '</p>');

        $data["bank"] = $this->Common_model->getAll('buyer_bank_details',array('user_id'=>$user))->row();
        
        if ($this->form_validation->run() === false) {
            $data["title"] = "ATZCart - Add Bank Details";
            $this->load->view("mobile/bankdetails/createnew", $data);
        } 
        else{
            $insertData = [
                "user_id" => $user,
                "acc_no" => $this->input->post("acc_no"),
                "bank_name" => $this->input->post("bank_name"),
                "ifsc_code" => $this->input->post("ifsc_code"),
                "acc_holder_name" => $this->input->post("acc_holder_name"),
                "updated_at" =>date('Y-m-d H:i:s'),
            ];
            $ch_bank = $this->Common_model->getAll('buyer_bank_details',array('user_id'=>$user))->num_rows();
            if($ch_bank==0)
            {
                $this->Common_model->insert('buyer_bank_details',$insertData);
                $message = '<div class="alert alert-success alert-dismissible">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                            Bank details added successfully.
                            </div>';
            }
            else
            {
                $this->Common_model->update('buyer_bank_details',$insertData,array('user_id'=>$user));
                $message = '<div class="alert alert-success alert-dismissible">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                            Bank details Updated successfully.
                        </div>';
            }

            $this->session->set_flashdata("message", $message);
            redirect("m/bank/", "refresh");
        }
    }
}