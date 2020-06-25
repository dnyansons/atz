<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

    public function __construct() {
        parent::__construct();
        if ($this->session->userdata("user_logged_in")) {
            if ($this->session->userdata("user_role") == "seller") {
                redirect("seller/dashboard/", "refresh");
            } else {
                redirect("buyer/dashboard/", "refresh");
            }
        }
        $this->load->model("Users_model");
        $this->load->model('Common_model');
        $this->load->model('Company_model');
        $this->load->library('google');
        $this->load->library('facebook');
        $this->load->library("get_header_data");
    }

    public function index() 
    {

        $this->load->library("form_validation");
        $this->form_validation->set_rules("username", "Username", "required");
        $this->form_validation->set_rules("password", "password", "required");

        if ($_SERVER['HTTP_REFERER'] != base_url() . 'login') {
            $this->session->set_userdata("refferer", $_SERVER['HTTP_REFERER']);
        }
        if ($this->form_validation->run() === false) {
            $data = $this->get_header_data->get_categories();
            $data["title"] = "ATZCart - Login";
            // $data['fburl'] = $this->facebook->login_url();
            // $data['google_login_url']=$this->google->get_login_url();
	
            $this->load->view("front/sign_in/sign_in", $data);
        } else {
            $username = htmlentities($this->input->post("username"));
            $password = htmlentities($this->input->post("password"));
            $refferer = htmlentities($this->input->post("refferer"));

            $check_email = $this->Is_email($username);
            if ($check_email) {
                $user = $this->Users_model->getUserByUsername($username);
            } else {
                $user = $this->Users_model->getUserBymobile($username);
            }


            if ($user) {
                        if($user->status == 0) {
                                $error = "<div id='login-error' class='form-error notice notice-error'>
                                                <span class='icon-notice icon-error'></span>
                                                <span><b>Error! : </b></strong>Your account has been banned! Please contact support. </span>
                                                </div>";
                                 $this->session->set_flashdata("message", $error);
                                 redirect("login", "refresh");
                        }

                $v_password = password_verify($password, $user->password);
				$userFavProducts = $this->Product_model->userFavProd($user->id);
				$v_password;
                if ($v_password == 1) {
                    $session_data = array(
                        "user_logged_in" => TRUE,
                        "user_id" => $user->id,
                        "user_name" => $user->first_name . " " . $user->last_name,
                        "user_role" => $user->role,
                        "user_currency" => $user->currency,
                        "user_email" => $user->email,
                        "phone" => $user->phone,
			"faverite_products" => json_decode($userFavProducts->products)
                    );
					
                    $this->session->set_userdata($session_data);
                    //Update Last Login Time
                    $get_last_time = $this->Common_model->getAll("users", array("id" => $user->id))->row_array();
                    $dat_time['last_login_activity'] = $get_last_time['updated_on'];
                    $dat_time['updated_on'] = date('Y-m-d H:i:s');
                    $this->Common_model->update("users", $dat_time, array("id" => $user->id));
			
                    //redirect($refferer);
                    if ($user->role == 'seller') {
                        redirect("seller/dashboard");
                    } else {
				
                        if(($refferer == 'http://localhost/atzcart/buyer/myaccount/change_password') || ($refferer == 'http://localhost/atzcart/signup/complete') || ($refferer == 'http://localhost/atzcart/change-email')){
                            redirect("buyer/dashboard");
                        } else{
                            redirect($refferer);
                        }
                    }
                }
                
            }
            $error = "<div id='login-error' class='form-error notice notice-error text-left'>
				<span>Error!</strong> Invalid Username Or Password.</span>
			</div>";
            $this->session->set_flashdata("message", $error);
            redirect("login/", "refresh");
        }
    }

    function Is_email($username) {
        //If the username input string is an e-mail, return true
        if (filter_var($username, FILTER_VALIDATE_EMAIL)) {
            return true;
        } else {
            return false;
        }
    }

    public function facebook_login() {
        echo "Disabled";
        exit();
        /*
          if ($this->facebook->is_authenticated()) {

          $userProfile = $this->facebook->request('get', '/me?fields=id,first_name,last_name,picture,email,gender');

          if (!isset($userProfile['error'])) {
          if (isset($userProfile['email'])) {
          $user = $this->Users_model->getUserByUsername($userProfile['email']);

          if ($user) {
          $socialFBData = array(
          "user_logged_in" => TRUE,
          "user_id" => $user->id,
          "user_name" => $user->first_name . " " . $user->last_name,
          "user_role" => $user->role,
          "user_currency" => $user->currency,
          "user_email" => $user->email,
          "phone" => $user->phone,
          );
          $this->session->set_userdata($socialFBData);

          $this->facebook->logout_url();
          //Update Last Login Time
          $get_last_time = $this->Common_model->getAll("users", array("id" => $user->id))->row_array();
          $dat_time['last_login_activity'] = $get_last_time['updated_on'];
          $dat_time['updated_on'] = date('Y-m-d H:i:s');
          $this->Common_model->update("users", $dat_time, array("id" => $user->id));

          if ($user->role == 'seller') {
          redirect("seller/dashboard", "refresh");
          } else {
          redirect("buyer/dashboard", "refresh");
          }
          } else {

          $source = "facebook";
          $tmp_pass = rand(100000, 999999);
          $email = $userProfile['email'];
          $first_name = $userProfile['first_name'];
          $last_name = $userProfile['last_name'];
          $source_id = $userProfile['id'];

          $insertData = [
          "username" => $email,
          "password" => password_hash($tmp_pass, PASSWORD_DEFAULT),
          "role" => "seller",
          "first_name" => $first_name,
          "last_name" => $last_name,
          "email" => $email,
          "phone" => '0',
          "country" => 'India',
          "profile_photo" => "default.png",
          "status" => 1,
          ];
          $user = $this->Users_model->add_user($insertData);

          $email_services = [
          "user_id" => $user,
          "trade_alerts" => 1,
          "expos_trade" => 1,
          "service_instruction" => 1,
          "survey_invitations" => 1,
          "gold_membership" => 1,
          "brq_notifications" => 1,
          "connection_notification" => 1,
          ];

          //Add Free (Package ID 1) Package to Register User
          $insertPkg['pkg_id'] = 1;
          $insertPkg['user_id'] = $user;
          $insertPkg['duration'] = 0;
          $insertPkg['status'] = 'Active';
          $this->Common_model->insert('user_packages', $insertPkg);


          $companyData = [
          "user_id" => $user,
          "company_name" => $first_name . ' ' . $last_name,
          "primary_business_type" => 1
          ];
          $companyInfo = [
          "user_id" => $user,
          "company_name" => $first_name . ' ' . $last_name,
          "company_type" => 1,
          ];
          $email_prefferences = $this->Users_model->add_email_services($email_services);

          $company = $this->Company_model->createCompany($companyData);
          $this->Users_model->addSellerInfo($companyInfo);
          $defaultInfo = [
          "company_id" => $company
          ];
          $this->Company_model->addExportInfo($defaultInfo);
          $this->Company_model->addManufactureInfo($defaultInfo);
          $this->Company_model->addQcInfo($defaultInfo);
          $this->Company_model->addRndInfo($defaultInfo);


          $socialData = [
          "user_id" => $user,
          "facebook_id" => $source_id,
          ];
          $this->Users_model->addSocialAuth($socialData);
          // $this->send_password($tmp_pass, $this->post("mobile"));
          redirect("buyer/dashboard", "refresh");
          }
          } else {
          redirect("register", "refresh");
          }
          } else {
          $this->facebook->destroy_session();
          redirect("login", "refresh");
          }
          } else {
          $data['fburl'] = $this->facebook->login_url();
          $this->load->view('front/sign_in/sign_in', $data);
          }
         * 
         */
    }

    public function oauth2callback() {
        echo "Disabled";
        exit();
        /*
          $google_data = $this->google->validate();
          if (isset($google_data['email'])) {
          $user = $this->Users_model->getUserByUsername($google_data['email']);
          if ($user) {
          $socialgoogleData = array(
          "user_logged_in" => TRUE,
          "user_id" => $user->id,
          "user_name" => $user->first_name . " " . $user->last_name,
          "user_role" => $user->role,
          "user_currency" => $user->currency,
          "user_email" => $user->email,
          "phone" => $user->phone,
          );
          $this->session->set_userdata($socialgoogleData);

          //Update Last Login Time
          $get_last_time = $this->Common_model->getAll("users", array("id" => $user->id))->row_array();
          $dat_time['last_login_activity'] = $get_last_time['updated_on'];
          $dat_time['updated_on'] = date('Y-m-d H:i:s');
          $this->Common_model->update("users", $dat_time, array("id" => $user->id));

          if ($user->role == 'seller') {
          redirect("seller/dashboard", "refresh");
          } else {
          redirect("buyer/dashboard", "refresh");
          }
          } else {

          $source = "google";
          $tmp_pass = rand(100000, 999999);
          $email = $google_data['email'];
          $first_name = $google_data['name'];
          $last_name = '';
          $source_id = $google_data['id'];

          $insertData = [
          "username" => $email,
          "password" => password_hash($tmp_pass, PASSWORD_DEFAULT),
          "role" => "seller",
          "first_name" => $first_name,
          "last_name" => $last_name,
          "email" => $email,
          "phone" => '',
          "country" => 'India',
          "profile_photo" => "default.png",
          "status" => 1,
          ];
          $user = $this->Users_model->add_user($insertData);
          $email_services = [
          "user_id" => $user,
          "trade_alerts" => 1,
          "expos_trade" => 1,
          "service_instruction" => 1,
          "survey_invitations" => 1,
          "gold_membership" => 1,
          "brq_notifications" => 1,
          "connection_notification" => 1,
          ];

          //Add Free (Package ID 1) Package to Register User
          $insertPkg['pkg_id'] = 1;
          $insertPkg['user_id'] = $user;
          $insertPkg['duration'] = 0;
          $insertPkg['status'] = 'Active';
          $this->Common_model->insert('user_packages', $insertPkg);


          $companyData = [
          "user_id" => $user,
          "company_name" => $first_name . ' ' . $last_name,
          "primary_business_type" => 1
          ];
          $companyInfo = [
          "user_id" => $user,
          "company_name" => $first_name . ' ' . $last_name,
          "company_type" => 1,
          ];
          $email_prefferences = $this->Users_model->add_email_services($email_services);

          $company = $this->Company_model->createCompany($companyData);
          $this->Users_model->addSellerInfo($companyInfo);
          $defaultInfo = [
          "company_id" => $company
          ];
          $this->Company_model->addExportInfo($defaultInfo);
          $this->Company_model->addManufactureInfo($defaultInfo);
          $this->Company_model->addQcInfo($defaultInfo);
          $this->Company_model->addRndInfo($defaultInfo);


          $socialData = [
          "user_id" => $user,
          "google_id" => $source_id,
          ];
          $this->Users_model->addSocialAuth($socialData);
          // $this->send_password($tmp_pass, $this->post("mobile"));
          redirect("buyer/dashboard", "refresh");
          }
          } else {
          redirect("register", "refresh");
          }
          redirect(base_url() . "googlelogin");
         * 
         */
    }

    /*     * *********** shubham patil ******** */

    public function forgot_password() 
    {
        $this->load->library("form_validation");
        $this->form_validation->set_rules("username", "Username", "required");
        $this->form_validation->set_rules("otp", "Otp", "required");
        if ($this->form_validation->run() === false) {
            $data["title"] = "ATZCart - Forgot Password";
            $this->load->view("user/auth/retrive_password", $data);
        } else {
            $username = $this->input->post("username");
            $otp = $this->input->post("otp");

            if ($otp == $this->session->userdata("otp")) {
                $sess_arr = ["forgot_password" => 1, 'temp_username' => $username];
                $this->session->set_userdata($sess_arr);
                $output = ['status' => 1];
                echo json_encode($output);
            } else {
                $output = ['status' => 0];
                echo json_encode($output);
            }
        }
    }

    function reset_password() {
        $forgot_password = $this->session->userdata("forgot_password");
        if ($forgot_password == 1) {
            $this->load->library("form_validation");
            $this->form_validation->set_rules('password', 'Password', 'required|callback_valid_password');
            $this->form_validation->set_rules('confirm_password', 'Confirm Password', 'required|matches[password]');
            $this->form_validation->set_error_delimiters('<div class="alert alert-dismissible alert-danger mt-2">'
                            . '<b> Error :</b>', '</div>');
            if ($this->form_validation->run() === false) {
                $data["title"] = "ATZCart - Reset Password";
                $this->load->view("user/auth/reset_password", $data);
            } else {

                $username = $this->session->userdata("temp_username");
                $password = $this->input->post('password');
                $hash_password = password_hash($password, PASSWORD_DEFAULT);
                $res = $this->Users_model->reset_password($username, $hash_password);
                $success = "<div class='alert alert-success alert-dismissible'>
                                             <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                                             <strong>Success!</strong> Password Changed!!.
                                       </div>";
                $this->session->set_flashdata("message", $success);
                $sess_arr = ["forgot_password" => '', "temp_username" => ''];
                $this->session->set_userdata($sess_arr);
                redirect("login", "refresh");
            }
        } else {
            redirect('login/forgot_password');
        }
    }

    public function ajax_send_otp() {
        
        $output = ["status" => 0, "message" => "failed"];
        $this->load->library("form_validation");
        $this->form_validation->set_rules("username", "Username", "required");
        if ($this->form_validation->run() === false) {
            echo json_encode($output);
        } else{
            $username = $this->input->post("username");
            $check_email = $this->Is_email($username);
            if ($check_email) {
                $res = $this->Users_model->getUserByUsername($username);
            } else {
                $res = $this->Users_model->getUserBymobile($username);
            }
            
            if($res)
            {
                $otp = rand(100000, 999999);
                $sess_arr = ["otp" => $otp];
                $this->session->set_userdata($sess_arr);
                $this->session->mark_as_temp('otp', 900);

                if($this->send_otp($otp, $res->phone)){
                        $output = ["status" => 1, "message" => "success"];
                        echo json_encode($output);
                }
            }else{
                $output = ["status" => 2, "message" => "failed"];
                echo json_encode($output);
            }
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
	
    public function generatePass() {
        if ($this->config->item("is_profiler")) {
            echo password_hash("testpass", PASSWORD_DEFAULT);
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
                    $this->form_validation->set_message('valid_password', 'The {field} field must have at least one special character.' . ' ' . htmlentities('!@#$%^&*()\-_=+{};:,<.>~'));
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

}
