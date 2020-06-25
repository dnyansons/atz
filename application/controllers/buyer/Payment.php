<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Payment extends CI_Controller 
{

    public function __construct() 
    {
        parent::__construct();
        $this->load->library('session');
        if (!$this->session->userdata("user_logged_in")) {
            $error = "<div id='login-error' class='form-error notice notice-error'><span class='icon-notice icon-error'></span><span><strong>Error!</strong> Session timeout, relogin!. </span></div>";
            $this->session->set_flashdata("message", $error);
            redirect("login", "refresh");
        }
        $this->load->helper('captcha');
        $this->load->model('Common_model');
        $this->load->model('Company_model');
        $this->load->model('Users_model');
        $this->load->library("form_validation");
        $this->load->library("get_header_data");
    }

    public function index() 
    {
        $data = $this->get_header_data->get_categories();
		$data["title"] = "ATZCart - Buyer Payment";
        
        $this->load->view('front/common/header',$data);
        $this->load->view('front/myaccount/payment');
        $this->load->view('front/common/footer');
    }
	
	public function get_payments()
	{
		$user_id = $this->session->userdata("user_id");
        // $data['user'] = $this->Users_model->getUserAsSellerInfo($user_id);
        $data['ord_pay']=$this->Common_model->getAll('order_payment',array('user_id'=>$user_id))->result();

		$this->output->set_output(json_encode($data));
	}
}