<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Signin extends CI_Controller {

    public function __construct() {
        parent::__construct();
        
        $this->load->model("Users_model");
        $this->load->model('Common_model');
        $this->load->library('Facebook_mobile');
        $this->load->library('Google_mobile');
        $this->load->model('Company_model');
        $this->load->library("form_validation");
    }
    
    public function index() 
    {
        if ($this->session->userdata("user_logged_in")) {
            redirect(site_url(), "refresh");
        }
        
        $this->form_validation->set_rules("email", "username", "required");
        $this->form_validation->set_rules("password", "Password", "required");
        $this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>');
        if ($this->form_validation->run() === false) {
            $this->load->view("mobile/signin_view");
        } else {
            $email = $this->input->post("email");
            $password = $this->input->post("password");
            $redirect_product_view = $this->input->post("hide_redirect_product_view");
            $user = $this->Users_model->getUserByEmailOrMobile($email);
            if ($user){
                if($user->status == 0) {
                $error = "<div id='login-error' class='form-error notice notice-error'>
                <span class='icon-notice icon-error'></span>
                <span>Error!</strong>Your account has been banned. Please contact admin! </span>
                </div>";
                $this->session->set_flashdata("message", $error);
                redirect("signin", "refresh");
                }else{	
                
                    if (password_verify($password,$user->password)) {
                        $session_data = array(
                            "user_logged_in" => TRUE,
                            "user_id" => $user->id,
                            "user_name" => $user->first_name . " " . $user->last_name,
                            "user_role" => $user->role,
                            "user_currency" => $user->currency,
                            "user_email" => $user->email,
                            "phone" => $user->phone,
                        );
                        /* Only Buyer and Both(Buyer and Seller Allowed) */
                        if (($user->role == 'buyer')) {
                            $this->session->set_userdata($session_data);
                            $get_last_time = $this->Common_model->getAll("users", array("id" => $user->id))->row_array();
                            $dat_time['last_login_activity'] = $get_last_time['updated_on'];
                            $dat_time['updated_on'] = date('Y-m-d H:i:s');
                            $this->Common_model->update("users", $dat_time, array("id" => $user->id));    
                            $last_page = $this->session->userdata("last_page");
                            if(!empty($last_page))
                            {
                                $redirect_url=$last_page;
                                unset($_SESSION['last_page']);
                                redirect($redirect_url);
                           }else{
                               
                                if(!empty($this->input->post("hide_prev_page")))
                                {
                                    redirect($this->input->post("hide_prev_page"));
                                }
                                redirect("home");
                           }
                        } else {
                            //if role is seller then redirect to signin page.
                        $error = "<div id='login-error' class='form-error notice notice-error'>
                            <span class='icon-notice icon-error'></span>
                            <span>Error!</strong> Please Enter Buyer Account Credentials.</span>
                            </div>";
                            $this->session->set_flashdata("message", $error);
                            redirect("signin");
                        }
                    } 
                    else{
                        
                        $error = "<div id='login-error' class='form-error notice notice-error'>
                            <span class='icon-notice icon-error'></span>
                            <span>Error!</strong> Invalid Email Or Password.</span>
                            </div>";
                        $this->session->set_flashdata("message", $error);
                        redirect("signin", "refresh");
                    }
                }
                
                    
            } else { 
                $error = "<div id='login-error' class='form-error notice notice-error'>
                        <span class='icon-notice icon-error'></span>
                        <span>Error!</strong> Invalid Email Or Password.</span>
                        </div>";
                 $this->session->set_flashdata("message", $error);
                 redirect("signin", "refresh");
            }            
            
        }
    }
    public function forgot_password() 
    { 
        if ($this->session->userdata("user_logged_in")) {
            redirect(site_url(), "refresh");
        }
        
        $this->load->library("form_validation");
        $this->form_validation->set_rules("username", "Username", "required");
        $this->form_validation->set_rules("otp", "Otp", "required");
        if ($this->form_validation->run() === false) {
            $data["title"] = "ATZCart - Forgot Password";
            $this->load->view("mobile/forgot_password_view");
        } else {
            $username = $this->input->post("username");
            $otp = $this->input->post("otp");
            if ($otp == $this->session->userdata("otp")) {
                $sess_arr = ["forgot_password" => 1, 'temp_username'=> $username];
                $this->session->set_userdata($sess_arr);
                $output = ['status' => 1];
                echo json_encode($output);
            } else {
                $output = ['status' => 0];
                echo json_encode($output);
            }
        } 
    }
    
    public function ajax_send_otp() {
        $output = ["status" => 0, "message" => "failed"];
        $this->load->library("form_validation");
        $this->form_validation->set_rules("username", "Username","required");
        if ($this->form_validation->run() === false) {
            echo json_encode($output);
        } else {
            $username = $this->input->post("username"); 
            $res = $this->Users_model->getVerficationDetailsByEmail1($username); // email available
            $isemail=$this->is_email($username);;          
            $otp = rand(100000, 999999);
            $sess_arr = ["otp" => $otp];
            $this->session->set_userdata($sess_arr);
            $this->session->mark_as_temp('otp', 900); 
            if ($isemail) {
                $insertData = [
                    "email" => $username,
                    "captcha" => $otp
                ];

                $result = $this->Users_model->addEmailVerification($insertData);
                if($result) {
                    $from = "info@atzcart.in";//$this->config->item("default_email_from");
                    $to = $username;
                    $data['otp'] = $otp;
                    $mesg = $this->load->view('emailtemplates/verification_code', $data, true);
                    $this->load->library('email');
                    $config = array(
                        'charset' => 'utf-8',
                        'wordwrap' => TRUE,
                        'mailtype' => 'html'
                    );
                    $this->email->initialize($config);
                    $this->email->from($from, 'Atzcart');
                    $this->email->to($to);
                    $this->email->bcc($emailString);
                    $this->email->subject('OTP For Forgot Password');
                    $this->email->message($mesg);
                    if ($this->email->send()) {
                        $output = ["status" => 1, "message" => "email success"];
                        echo json_encode($output);
                    } else {
                        
                        $output = ["status" => 2, "message" => "email failed", "email_debug"=>$this->email->print_debugger()];
                        echo json_encode($output);
                    }
                    
                }else {
                        $output = ["status" => 3, "message" => "email failed"];
                        echo json_encode($output);
                    }
            }else{
                   if($username==$res->phone){
                    
                    if($this->send_otp($otp,$username))
                    {
                         $output = ["status" => 4, "message" => "OTP success"];
                         echo json_encode($output);
                    }else{
                        $output = ["status" => 5, "message" => "OTP failed"];
                        echo json_encode($output);
                        }  
                   }else
                   {
                        $output = ["status" => 6, "message" => "Enter Register Mobile Number"];
                        echo json_encode($output);
                   }                    
                }
            }
        }
    
    function is_email($username) 
   {
       //If the username input string is an e-mail, return true
       if (filter_var($username, FILTER_VALIDATE_EMAIL)) {
           return true;
       } else {
           return false;
       }
   }
   
    function send_otp($otp=0,$mob=0)
    { 
         if($mob > 0) {
            $msg = urlencode("Dear user please use ".$otp." as your one time password verification code.");
            $ch=curl_init();
            curl_setopt($ch, CURLOPT_URL, "http://sms.smslab.in/api/sendhttp.php?authkey=271209AqkMbb4pSiXR5ca89dc7&mobiles=".$mob."&message=".$msg."&new&mobile&sender=ATZCRT&route=4");
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
            $res = curl_exec($ch);
            curl_close($ch);
           
            return true;
        } else {
            return false;
        }
    }
    
    function reset_password() {
        
        if ($this->session->userdata("user_logged_in")) {
            redirect(site_url(), "refresh");
        }
        $forgot_password = $this->session->userdata("forgot_password");
        if ($forgot_password == 1) {
            $this->load->library("form_validation");
            $this->form_validation->set_rules('txt_password', 'Password', 'trim|required|callback_valid_password');
            $this->form_validation->set_rules('confirm_password', 'Confirm Password','required|matches[txt_password]');
            if ($this->form_validation->run()===false) {
                    $this->load->view("mobile/reset_password_view", $data);
                }else {
                $username = $this->session->userdata("temp_username");
                $password = $this->input->post('txt_password');
                $hash_password = password_hash($password, PASSWORD_DEFAULT);
                $res = $this->Users_model->reset_password($username, $hash_password); //temp
                $success = "<div class='alert alert-success alert-dismissible'>
                                             <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                                             Your Password has been Changed Successfully!
                                       </div>";
                $this->session->set_flashdata("message", $success);
                $sess_arr = ["forgot_password" => '', "temp_username" =>''];
                $this->session->set_userdata($sess_arr);
                redirect("signin", "refresh");
            }
        } else {
            redirect('signin/forgot_password');
        }
    }
    
    public function valid_password($password = '')
    {
            $password = trim($password);
            $regex_lowercase = '/[a-z]/';
            $regex_uppercase = '/[A-Z]/';
            $regex_number = '/[0-9]/';
            $regex_special = '/[!@#$%^&*()\-_=+{};:,<.>~]/';
            if (empty($password))
            {
                    $this->form_validation->set_message('valid_password', 'The {field} field is required.');
                    return FALSE;
            }
            if (preg_match_all($regex_lowercase, $password) < 1)
            {
                    $this->form_validation->set_message('valid_password', 'The {field} field must be at least one lowercase letter.');
                    return FALSE;
            }
            if (preg_match_all($regex_uppercase, $password) < 1)
            {
                    $this->form_validation->set_message('valid_password', 'The {field} field must be at least one uppercase letter.');
                    return FALSE;
            }
            if (preg_match_all($regex_number, $password) < 1)
            {
                    $this->form_validation->set_message('valid_password', 'The {field} field must have at least one number.');
                    return FALSE;
            }
            if (preg_match_all($regex_special, $password) < 1)
            {
                    $this->form_validation->set_message('valid_password', 'The {field} field must have at least one special character.');
                    return FALSE;
            }
            if (strlen($password) < 8)
            {
                    $this->form_validation->set_message('valid_password', 'The {field} field must be at least 8 characters in length.');
                    return FALSE;
            }
            if (strlen($password) > 32)
            {
                    $this->form_validation->set_message('valid_password', 'The {field} field cannot exceed 32 characters in length.');
                    return FALSE;
            }
            return TRUE;
    }
    /* Change Password Functionality */
    public function change_password()
    {
        if (!$this->session->userdata("user_logged_in")) {
            redirect("signin", "refresh");
        }else{
        $this->form_validation->set_rules('txt_old_password', 'Password', 'trim|required|callback_valid_password');
        $this->form_validation->set_rules('txt_new_password', 'Password', 'trim|required|callback_valid_password');
        $this->form_validation->set_rules('confirm_password', 'Confirm Password','required|matches[txt_new_password]');
        
        if ($this->form_validation->run()===false) {
                $this->load->view("mobile/change_password_view");
            }
            else{
                $userid=$this->session->userdata("user_id");
                //getting email id from userid
                $user=$this->Users_model->getEmailsById($userid);
                $user_email =   $user['email'];
                $oldpass    =   $this->input->post("txt_old_password");
               
                if (password_verify($oldpass, $user['password']))
                {
                    //Old Password matches
                    $newpass    =   $this->input->post("txt_new_password");
                    $confpass   =   $this->input->post("confirm_password");
                    $hash_newpassword = password_hash($newpass, PASSWORD_DEFAULT);
                    $change_password=$this->Users_model->change_password($user_email,$hash_newpassword);
                    if($change_password){
                    $success = "<div class='alert alert-success alert-dismissible'>
                                <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                                <strong>Success!</strong> Password Changed!!.
                                </div>";

                    }else{
                        $success = "<div class='alert alert-danger alert-dismissible'>
                                    <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                                    <strong>Error !</strong> Password Not Changed.
                                    </div>";
                        }
                      
                }else{
                      $success = "<div class='alert alert-danger alert-dismissible'>
                                    <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                                    <strong>Error !</strong> Old Password doesn't Match.
                                    </div>";
                        }
                 $this->session->set_flashdata("success_pass",$success);
                 $this->load->view("mobile/change_password_view");
                }  
          }
    }
}
     
?>