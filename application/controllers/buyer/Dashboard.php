<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Dashboard extends CI_Controller 
{
    public function __construct() 
    {
        parent::__construct();
        if (!$this->session->userdata("user_logged_in")) {
            $error = "<div id='login-error' class='form-error notice notice-error'><span class='icon-notice icon-error'></span><span> Please login to proceed!. </span></div>";
            $this->session->set_flashdata("message", $error);
            redirect("login", "refresh");
        }
        $this->load->library("get_header_data");
        $this->load->model("Users_model");
        $this->load->model("Offer_model");
    }
    
    public function index()
    {                            
        $data = $this->get_header_data->get_categories();
		$data['title'] = "ATZCart - Buyer Dashboard";
        $this->load->view("front/myaccount/dashboard",$data);
    }
    
    public function accountinfo()
    {
        $userid = $this->session->userdata("user_id");
        //echo $userid;
        $data["userinfo"] = $this->Users_model->getUserById($userid);
      
    }
}