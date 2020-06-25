<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Bank extends CI_Controller 
{
    
    public function __construct() 
    {
        parent::__construct();
        if (!$this->session->userdata("user_logged_in") || $this->session->userdata("user_role")!="seller") {
            $error = "<div id='login-error' class='form-error notice notice-error'><span class='icon-notice icon-error'></span><span><strong>Error!</strong> Session timeout, relogin!. </span></div>";
            $this->session->set_flashdata("message", $error);
            redirect("login", "refresh");
        }
        
        $this->load->model("Bank_model");
        $this->load->model("Common_model");
        $this->load->library('form_validation');
    }

    public function index() 
    {
        $data["pageTitle"] = "Bank Account Details";
        $this->load->view("user/common/header",$data);
        $this->load->view("user/bank/list");
        $this->load->view("user/common/footer");
    }

    public function ajax_list() {
		$user_id = $this->session->userdata('user_id');
        $result = $this->Bank_model->getBankDetailsList($user_id);
        $this->output->set_output(json_encode($result));
    }
	
    public function add_bank() 
    {
        $this->load->library("form_validation");

        $this->form_validation->set_rules("account_no", "Account No", "required|min_length[9]|max_length[18]|callback_not_all_zeros");
        $this->form_validation->set_rules("bank", "Bank", "required");
        $this->form_validation->set_rules("ifsc_code", "IFSC Code", "required");
        $this->form_validation->set_rules("account_holder_name", "Account Holder Name", "required");
        //$this->form_validation->set_rules("is_default", "Is Default", "required");


        if ($this->form_validation->run() === false) {
            $data['banks'] = $this->Bank_model->getBanks();
            $data["pageTitle"] = "Add Bank Account Details";
            $this->load->view("user/bank/add", $data);
        } else {
            $ch_acc_number=$this->Common_model->getAll('supplier_bank_details',array('account_no'=>$this->input->post("account_no")))->num_rows();
            if($ch_acc_number==0)
            {
            $user_id = $this->session->userdata('user_id');
         
            $insertData = [
                "user_id" => $user_id,
                "account_no" => htmlentities($this->input->post("account_no")),
                "bank" => htmlentities($this->input->post("bank")),
                "ifsc_code" => htmlentities($this->input->post("ifsc_code")),
                "account_holder_name" => htmlentities($this->input->post("account_holder_name")),
                "is_default" => htmlentities($this->input->post("is_default")),
                "created_date" => date("Y-m-d H:i:s"),
                "updated_date" => date("Y-m-d H:i:s"),
            ];

            $result = $this->Bank_model->addUserBank($insertData);
            $message = "<div class='alert alert-info alert-dismissible'>
                        <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                        <strong>Success!</strong> Bank details added!
                    </div>";
            }
            else
            {
            $message = "<div class='alert alert-danger alert-dismissible'>
                        <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                        <strong>Error!</strong> Same Account Number Not Allowed !
                    </div>";
            }
            $this->session->set_flashdata("message", $message);
            redirect("seller/bank");
        }
    }

    public function edit_bank($id)
	{
		$this->load->library("form_validation");
        $this->form_validation->set_rules("account_no", "Account No", "required|min_length[9]|max_length[18]|callback_not_all_zeros");
        $this->form_validation->set_rules("bank", "Bank", "required");
		$this->form_validation->set_rules("ifsc_code", "IFSC Code", "required");
        $this->form_validation->set_rules("account_holder_name", "Account Holder Name", "required");
        if ($this->form_validation->run() === false) {
			$data['banks'] = $this->Bank_model->getBanks();
			$data['result'] = $this->Bank_model->getUserBanksDetails($id);
                        $data["pageTitle"] = "Update Bank Account Details";
			$this->load->view("user/bank/edit",$data);
        } else {
			   
			   $user_id = $this->session->userdata('user_id');
			   $updateData = [
					"user_id" => $user_id,
					"account_no" => htmlentities($this->input->post("account_no")),
					"bank" =>  htmlentities($this->input->post("bank")),
					"ifsc_code" => htmlentities($this->input->post("ifsc_code")),
					"account_holder_name" => htmlentities($this->input->post("account_holder_name")),
					"is_default" => htmlentities($this->input->post("is_default")),
					"created_date" => htmlentities($this->input->post("created_date")),
					"updated_date" => date("Y-m-d H:i:s"),
			];
				
			$result = $this->Bank_model->editUserBank($updateData,$id);
			redirect("seller/bank");
		}
    }

    public function not_all_zeros($number)
    {
        $number += 0;
        if($number == 0) {
            $this->form_validation->set_message('not_all_zeros', 'Account number must not be zero only!');
            return false;
        } else {
            return true;
        }
    }
    
       
}