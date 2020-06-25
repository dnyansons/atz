<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Settings extends CI_Controller 
{
    public function __construct() 
    {
        parent::__construct();
        if (!$this->session->userdata("user_logged_in")) {
            $error = "<div id='login-error' class='form-error notice notice-error'><span class='icon-notice icon-error'></span><span><strong>Error!</strong> Session timeout, relogin!. </span></div>";
            $this->session->set_flashdata("message", $error);
            redirect("login", "refresh");
        }
        $this->load->model('Users_model');
        $this->load->library("get_header_data");
    }
    
    public function index()
    {
        $user = $this->session->userdata("userid");
        $data = $this->get_header_data->get_categories();
        $data["userInfo"] = $this->db->getUserById($user);
        $data["pageTitle"] = "Account Settings";
        $this->load->view("front/myaccount/userinfo",$data);
    }
}