<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Login extends CI_Controller 
{
    public function __construct() 
    {
        parent::__construct();
        $this->load->model("Adminusers_model");
        if($this->session->userdata("admin_logged_in")){
            redirect("admin/dashboard","refresh");
        }
    }
    
    public function index() 
    {
        $this->load->library("form_validation");
        $this->form_validation->set_rules("username","Username","required");
        $this->form_validation->set_rules("password","password","required");
        if($this->form_validation->run()===false){
            $this->load->view("admin/auth/login");
        } else {
            
            $username = $this->input->post("username");
            $password = $this->input->post("password");
            $user = $this->Adminusers_model->getUserByUsername($username);
            if($user){
                if($user->status == "0"){
                    $error = "<div class='alert alert-danger alert-dismissible'>
                        <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                        <strong>Error!</strong> Yo dont have Permission ! Conatct to Administrator.
                      </div>";
                    $this->session->set_flashdata("message", $error);
                    redirect("admin/login", "refresh");
                } else {
                    if(password_verify($password, $user->admin_password)) {

                        //Check Permission
                        $this->db->select('*');
                        $this->db->from('user_permission as a');
                        $this->db->where('a.user_id="' . $user->admin_id . '"');
                        $ch_query = $this->db->get();

                        if ($ch_query->num_rows() > 0) {
                            $session_data = array(
                                "admin_logged_in" => "TRUE",
                                "admin_id" => $user->admin_id,
                                "admin_username" => ucfirst($user->admin_firstname),
                                "admin_email" => $user->admin_email,
                                "admin_role" => $user->admin_role
                            );

                            $this->session->set_userdata($session_data);
                            redirect(base_url() . "admin/dashboard");
                        } else {
                            $error = "<div class='alert alert-danger alert-dismissible'>
                                <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                                <strong>Error!</strong> You Have No Permission ! Conatct to Administrator.
                              </div>";
                            $this->session->set_flashdata("message", $error);
                            redirect("admin/login", "refresh");
                        }
                    } else {
                        $error = "<div class='alert alert-danger alert-dismissible'>
                                <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                                <strong>Error!</strong> Invalid Username Or Password.
                              </div>";
                        $this->session->set_flashdata("message", $error);
                        redirect("admin/login", "refresh");
                    }
                }	
                
            } else {
                $error = "<div class='alert alert-danger alert-dismissible'>
                            <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                            <strong>Error!</strong> Invalid Username Or Password.
                          </div>";
                $this->session->set_flashdata("message",$error);
                redirect("admin/login","refresh");
            }
        }
    }
    
    public function forgot_password()
    {
		
		$this->load->library("form_validation");
        $this->form_validation->set_rules("username","Username","required");
        if($this->form_validation->run()){
     
			$username = $this->input->post("username");
			$otp = $this->input->post("otp");
			if(isset($username) && isset($otp)){
				$otp_match= $this->Adminusers_model->match_otp($otp);
				if($otp_match){
					$data['username'] = $username;
					$this->load->view("admin/auth/reset_password",$data);
				}else{
					$data['error'] = "<div class='alert alert-danger alert-dismissible'>
					<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
					<strong>Error!</strong> Invalid OTP!!. </div>";
				}
				$this->load->view("admin/auth/forgot_password",$data);
			}
			$res= $this->Adminusers_model->getUserByUsername($username);
			if($res){
					// $gen_otp = rand(100000,999999);
					// $from = $this->config->item("default_email_from");
					// $to = "sandeshpangrekar@ayninfotech.com";
					// $mesg = "Your OTP For Forgot password is : ".$gen_otp;
					// $this->load->library('email');
					// $config=array(
						// 'charset'=>'utf-8',
						// 'wordwrap'=> TRUE,
						// 'mailtype' => 'html'
					// );
					// $this->email->initialize($config);	
					// $this->email->from($from, 'Atzcart');
					// $this->email->to($to);
					// $this->email->bcc($emailString);
					// $this->email->subject('OTP For Forgot Password');
					// $this->email->message($mesg);
					// if($this->email->send())
					 // {
							$data['success'] = "<div class='alert alert-success alert-dismissible'>
							 <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
							 <strong>Verified!</strong> Check Your Email For OTP!!.</div>";
					 // }else{
						 
						 // $data['error'] = $this->email->print_debugger();
					 // }

				 
		} else {
				$data['error'] = "<div class='alert alert-danger alert-dismissible'>
				<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
				<strong>Error!</strong> Invalid Username!!. </div>";
		} 
	}
	
	$this->load->view("admin/auth/forgot_password",$data);
	
   }
   
   function reset_password()
   {
	   $this->load->library("form_validation");
	   $this->form_validation->set_rules('password', 'Password', 'required');
	   $this->form_validation->set_rules('confirm_password', 'Confirm Password', 'required|matches[password]');
	   if($this->form_validation->run()){
		   $username = $this->input->post('username');
		   $password = $this->input->post('password');
		   $hash_password = password_hash($password, PASSWORD_DEFAULT);
		   $res= $this->Adminusers_model->reset_password($username,$hash_password);
		   $success = "<div class='alert alert-success alert-dismissible'>
					<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
					<strong>Success!</strong> Password Changed!!.
				  </div>";
           $this->session->set_flashdata("message",$success);
		   redirect("admin/login","refresh");
	   }
	   $this->load->view("admin/auth/reset_password",$data);
   }
}
