<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Login_security extends CI_Controller 
{
    public function __construct() 
    {
        parent::__construct();
		if (!$this->session->userdata("user_logged_in")) {
            $error = "<div id='login-error' class='form-error notice notice-error'><span class='icon-notice icon-error'></span><span><strong>Error!</strong> Session timeout, relogin!. </span></div>";
            $this->session->set_flashdata("message", $error);
            redirect("login", "refresh");
        }
		$this->load->model('Myorders_model');
                $this->load->model('Common_model');
		$this->load->library('Shipping');
		$this->load->library("get_header_data");
    }

    public function index() 
    {	
        $data = $this->get_header_data->get_categories();
        $data["title"] = "ATZCart - Login & Security";
        $user_id=$this->session->userdata("user_id");
        $data1['user_data']=$this->Common_model->getAll('users',array('id'=>$user_id))->row();

        $this->load->view('front/common/header',$data);
        $this->load->view("front/myaccount/account_security",$data1);
        $this->load->view('front/common/footer');
    }
    
   
    function update_name()
    {
        $user_id=$this->session->userdata("user_id");
        $first_name= htmlentities($this->input->post('first_name'));
        $last_name=  htmlentities($this->input->post('last_name'));
        
        if(!empty($first_name) && !empty($last_name))
        {
            $dat['first_name']=$first_name;
             $dat['last_name']=$last_name;
             
             $up=$this->Common_model->update('users',$dat,array('id'=>$user_id));
             if($up)
             {
                 $msg="<div class='alert alert-success alert-dismissible'>
									<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
									<strong>Success !</strong> Update Successfully !
								  </div>";
		$this->session->set_flashdata('message',$msg);
             }
             redirect('buyer/login_security');
        }
        
    }
   
    
}
    ?>