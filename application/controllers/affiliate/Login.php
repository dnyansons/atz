<?php
/**
 * affiliate Login.
 * 
 * @package affiliate marketing.
 * @version PHP 7.1 20190909
 * @author shubham patil <shubhampatil@ayninfotech.com>
 * @see http://atzcart/affiliate/login
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

    public function __construct() {
        parent::__construct();
        
        $this->load->model("Affiliate_model");
        $this->load->library("get_header_data");
        $this->load->library('form_validation');
    }

    public function index() 
    {
        $this->form_validation->set_error_delimiters('<p style="color:red" class="text-left m-0 pb-2 ml-4">', '</p>');
        $this->form_validation->set_rules("username", "Username", "required");
        $this->form_validation->set_rules("password", "password", "required");

        if ($this->form_validation->run() === false) {
            $data = $this->get_header_data->get_categories();
            $data["title"] = "ATZCart - Login";
            $this->load->view('affiliate/loginAffiliate',$data);
        } else {
            $username = htmlentities($this->input->post("username"));
            $password = htmlentities($this->input->post("password"));
            
            $check_email = $this->Is_email($username);
            if ($check_email) {
                $affilite = $this->Affiliate_model->getUserByUsername($username);
            } else {
                $affilite = $this->Affiliate_model->getUserBymobile($username);
            }

            if ($affilite) {
                if($affilite->status == "Pending") {
                    $error = "<div class='alert alert-danger alert-dismissible pr-0' style='font-size:12px'>
                                <a href='#' class='close' data-dismiss='alert' aria-label='close' style='padding-right:12px'>&times;</a>
                                <strong>Error!</strong> Your account hasn't been approved yet! try again after some time.
                              </div>";
                     $this->session->set_flashdata("affiliatemessage", $error);
                     redirect("affiliate/login", "refresh");
                } else if($affilite->status == "Rejected") {
                    $error = "<div class='alert alert-danger alert-dismissible pr-0' style='font-size:12px'>
                                <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                                <strong>Sorry!</strong> Your account has been Rejected.
                              </div>";
                         $this->session->set_flashdata("affiliatemessage", $error);
                         redirect("affiliate/login", "refresh");
                }

                $verifyPassword = password_verify($password, $affilite->password);
                
                if ($verifyPassword == 1) {
                    $AffiliatesessionData   = array(
                        "affiliateLogin"    => TRUE,
                        "affiliateId"       => $affilite->id,
                        "affiliateFullname" => $affilite->fullname,
                        "affiliateCompany"  => $affilite->companyname,
                        "affiliateEmail"    => $affilite->username,
                    );
					
                    $this->session->set_userdata("affiliate_session",$AffiliatesessionData);
                    redirect("affiliate/affiliate");
                }
                
            }
            $error = "<div class='alert alert-danger alert-dismissible pr-0' style='font-size:12px'>
                                <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                                <strong>Error!</strong> Invalid Username Or Password.
                              </div>";
            $this->session->set_flashdata("affiliatemessage", $error);
            redirect("affiliate/login", "refresh");
        }
    }
    
    /**
     * 
     * @version PHP 7.1 20190909
     * @author shubham patil <shubhampatil@ayninfotech.com>
     * @param type $username
     * @return boolean , it will return true if the parameter is email else it will return false.
     * 
     * 
     */
    private function Is_email($username) {
        if (filter_var($username, FILTER_VALIDATE_EMAIL)) {
            return true;
        } else {
            return false;
        }
    }
    
     /**
     * 
     * @version PHP 7.1 20190917
     * @author shubham patil <shubhampatil@ayninfotech.com>

     */
    public function forgotPassword() 
    {
        $this->load->library("form_validation");
        $this->form_validation->set_rules("username", "Username", "required");
        $this->form_validation->set_rules("otp", "Otp", "required");
        if ($this->form_validation->run() === false) {
            $data["title"] = "Affiliate - Forgot Password";
            $data = $this->get_header_data->get_categories();
            $this->load->view("affiliate/forgotpassword", $data);
        } else {
            $username = $this->input->post("username");
            $otp = $this->input->post("otp");

            if ($otp == $this->session->userdata("affiliateotp")) {
                $tempArr = ["forgotpassword" => 1, 'tempusername' => $username];
                $this->session->set_userdata($tempArr);
                $output = ['status' => 1];
                echo json_encode($output);
            } else {
                $output = ['status' => 0];
                echo json_encode($output);
            }
        }
    }

    function resetPassword() {
        $forgotpassword = $this->session->userdata("forgotpassword");
        if ($forgotpassword == 1) {
            $this->load->library("form_validation");
            $this->form_validation->set_rules('password', 'Password', 'required');
            $this->form_validation->set_rules('confirm_password', 'Confirm Password', 'required|matches[password]');
            $this->form_validation->set_error_delimiters('<div class="alert alert-dismissible alert-danger mt-2"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'
                            . '<b> Error :</b>', '</div>');
            if ($this->form_validation->run() === false) {
                $data["title"] = "Affiliate - Reset Password";
                $data = $this->get_header_data->get_categories();
                $this->load->view("affiliate/resetpassword", $data);
            } else {

                $username = $this->session->userdata("tempusername");
                $password = $this->input->post('password');
                $hash_password = password_hash($password, PASSWORD_DEFAULT);
                $res = $this->Affiliate_model->updatePassword($username, $hash_password);
                $success = "<div class='alert alert-success alert-dismissible pr-0' style='font-size:12px'>
                                <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                                <strong>Success!</strong> Password Changed Successfully.
                              </div>";
                $this->session->set_flashdata("affiliatemessage", $success);
                $tempArr = ["forgotpassword" => '', "tempusername" => ''];
                $this->session->set_userdata($tempArr);
                redirect("Affiliate/login", "refresh");
            }
        } else {
            redirect('login/forgot_password');
        }
    }

    public function ajaxSendOtp() {
        
        $output = ["status" => 0, "message" => "failed"];
        $this->load->library("form_validation");
        $this->form_validation->set_rules("username", "Username", "required");
        if ($this->form_validation->run() === false) {
            echo json_encode($output);
        } else{
            $username = $this->input->post("username");
            $check_email = $this->Is_email($username);
            if ($check_email) {
                $res = $this->Affiliate_model->getUserByUsername($username);
            } else {
                $res = $this->Affiliate_model->getUserBymobile($username);
            }
            
            if($res)
            {
                $otp = rand(100000, 999999);
                $tempArr = ["affiliateotp" => $otp];
                $this->session->set_userdata($tempArr);
                $this->session->mark_as_temp('affiliateotp', 900);

                if($this->sendOtp($otp, $res->mobileno)){
                        $output = ["status" => 1, "message" => "success"];
                        echo json_encode($output);
                }
            }else{
                $output = ["status" => 2, "message" => "failed"];
                echo json_encode($output);
            }
        }
    }
    
    function sendOtp($otp=0,$mob=0)
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
}
