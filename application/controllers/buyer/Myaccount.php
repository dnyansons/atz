<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Myaccount extends CI_Controller {

    public function __construct() {
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
        $this->load->library("form_validation");
        $this->load->library("get_header_data");
        $this->load->library('awsupload');
    }

    public function index() {
        $user_id = $this->session->userdata("user_id");
        $data['user'] = $this->Users_model->getUserAsSellerInfo($user_id);
        $data['company'] = $this->Company_model->getCompanyDetailsBySeller($user_id);
        $this->load->view('user/account/info', $data);
    }

    function edit_profile() {
        $user_id = $this->session->userdata("user_id");
        $this->form_validation->set_rules("first_name", "First Name", "required");
        $this->form_validation->set_rules("last_name", "Last Name", "required");
        $this->form_validation->set_rules("company_type", "Company Type", "required");
        $this->form_validation->set_rules("address", "Address", "required");
        $this->form_validation->set_rules("company_name", "Comany Name", "required");
        if ($this->form_validation->run() === false) {
            $data['user'] = $this->Users_model->getUserAsSellerInfo($user_id);
            $data['company'] = $this->Common_model->getAll("company_types")->result_array();
            $this->load->view('user/account/edit', $data);
        } else {
            $userData = [
                "first_name" => $this->input->post("first_name"),
                "last_name" => $this->input->post("last_name"),
            ];
            $sellerInfoData = [
                "company_type" => $this->input->post("company_type"),
                "company_name" => $this->input->post("company_name"),
                "address1" => $this->input->post("address")
            ];
            $this->Users_model->updateUserInfo($user_id, $userData);
            $this->Users_model->updateUserSellerInfo($user_id, $sellerInfoData);
            $error = "<div class='alert alert-success alert-dismissible'>
                <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                <strong>Success!</strong> Profile updated successfully.
            </div>";
            $this->session->set_flashdata("message", $error);
            redirect("buyer/myaccount/edit_profile", "refresh");
        }
    }

    /*     * ******************** shubham patil ********************** */

    public function change_password() {

        $this->load->library("form_validation");
        $this->form_validation->set_rules('old_password', 'Old password', 'required');
        $this->form_validation->set_rules('new_password', 'New Password', 'required|callback_check_old_new_pwd|callback_valid_password');
        $this->form_validation->set_rules('confirm_password', 'Confirm Password', 'required|matches[new_password]');
        $this->form_validation->set_error_delimiters('<div class="alert alert-danger alert-dismissible mt-2">'
                . ' <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><b> Error :</b>', '</div>');

        if ($this->form_validation->run() === false) {
            $data = $this->get_header_data->get_categories();
            $data['title'] = "ATZCart - Change Password";
            $this->load->view('front/common/header', $data);
            $this->load->view('front/myaccount/change_pass');
            $this->load->view('front/common/footer');
        } else {
            $old_password = $this->input->post('old_password');
            $new_password = $this->input->post('new_password');
            $username = $this->session->userdata('user_email');
            $user_password = $this->Users_model->getUserpassword($username);

            if ($user_password) {
                if (password_verify($old_password, $user_password->password)) {
                    $hash_password = password_hash($new_password, PASSWORD_DEFAULT);
                    $result = $this->Users_model->change_password($username, $hash_password);

                    $success = "<div class='alert alert-success alert-dismissible'>
										 <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
										 <strong>Success!</strong> Password Changed!!.
								   </div>";
                    $this->session->set_flashdata("change_pass_error", $success);
                    redirect("buyer/myaccount/change_password");
                } else {
                    $change_password_error = "<div class='alert alert-danger alert-dismissible'>
					<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
					<strong>Error!</strong> Incorrect Old Password!</div>";

                    $this->session->set_flashdata('change_pass_error', $change_password_error);
                    redirect('buyer/myaccount/change_password');
                }
            }
        }
    }

    function set_security_questions() {
        $data = $this->get_header_data->get_categories();
        $data['success'] = '';
        $user_id = $this->session->userdata('user_id');
        $res = $this->Users_model->check_for_suppler($user_id);
        if ($res) {
            $data['success'] = "<div class='alert alert-danger alert-dismissible'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><strong>Note!</strong> You have already Submitted the Security Questions!!</div>";
            $data['update'] = $user_id;
        } else {
            $this->load->library("form_validation");
            $this->form_validation->set_rules('questions1', 'questions1', 'required');
            $this->form_validation->set_rules('questions2', 'questions2', 'required');
            $this->form_validation->set_rules('questions3', 'questions3', 'required');

            $this->form_validation->set_rules('answer1', 'answer1', 'required');
            $this->form_validation->set_rules('answer2', 'answer2', 'required');
            $this->form_validation->set_rules('answer3', 'answer3', 'required');
            if ($this->form_validation->run()) {

                $todays_date = date('Y-m-d H:i:s');
                $arr = array();

                $arr["user_id"] = $user_id;
                $arr["question_id_one"] = $this->input->post('questions1');
                $arr["question_id_two"] = $this->input->post('questions2');
                $arr["question_id_three"] = $this->input->post('questions3');

                $arr["answer_one"] = $this->input->post('answer1');
                $arr["answer_two"] = $this->input->post('answer2');
                $arr["answer_three"] = $this->input->post('answer3');

                $arr["added_date"] = $todays_date;
                $result = $this->Users_model->add_user_questions($id = '', $arr);
                if ($result) {
                    $data['success'] = "<div class='alert alert-success alert-dismissible'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><strong>Success!</strong> Submitted!!</div>";
                }
            }
        }


        $this->load->view("front/myaccount/security_questions", $data);
    }

    public function update_security_questions($id) {
        $data1 = $this->get_header_data->get_categories();
        $data['result'] = $this->Users_model->get_user_questions($id);

        $this->load->library("form_validation");
        $this->form_validation->set_rules('questions1', 'questions1', 'required');
        $this->form_validation->set_rules('questions2', 'questions2', 'required');
        $this->form_validation->set_rules('questions3', 'questions3', 'required');

        $this->form_validation->set_rules('answer1', 'answer1', 'required');
        $this->form_validation->set_rules('answer2', 'answer2', 'required');
        $this->form_validation->set_rules('answer3', 'answer3', 'required');
        if ($this->form_validation->run()) {
            $todays_date = date('Y-m-d H:i:s');
            $arr = array();
            $row_id = $this->input->post('row_id');
            $arr["user_id"] = $id;
            $arr["question_id_one"] = $this->input->post('questions1');
            $arr["question_id_two"] = $this->input->post('questions2');
            $arr["question_id_three"] = $this->input->post('questions3');

            $arr["answer_one"] = $this->input->post('answer1');
            $arr["answer_two"] = $this->input->post('answer2');
            $arr["answer_three"] = $this->input->post('answer3');
            $arr["added_date"] = $todays_date;

            $result = $this->Users_model->add_user_questions($row_id, $arr);
            if ($result) {
                $data['result'] = $this->Users_model->get_user_questions($id);
                $data['success'] = "<div class='alert alert-success alert-dismissible'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><strong>Success!</strong> Updated!!</div>";
            }
        }
        $this->load->view("front/common/header", $data1);
        $this->load->view("front/myaccount/update_security_questions", $data);
        $this->load->view("front/common/footer");
    }

    public function ajax_get_questions() {
        $result = $this->Users_model->get_all_questions();
        $this->output->set_output(json_encode($result));
    }

    public function email_preferences() {
        $user_id = $this->session->userdata('user_id');
        $data['result'] = $this->Users_model->gat_email_services($user_id);
        $this->load->view("user/common/header");
        $this->load->view("user/account/email_preferences", $data);
        $this->load->view("user/common/footer");
    }

    public function ajax_manage_email_services($id, $val) {
        $user_id = $this->session->userdata('user_id');
        $result = $this->Users_model->update_email_services($user_id, $id, $val);
        $this->output->set_output(json_encode($result));
    }

    public function change_email_address() {

        $data = $this->get_header_data->get_categories();
        $data['title'] = "ATZCart - Change Email Address";

        $this->load->view('front/common/header', $data);
        $this->load->view("front/myaccount/change_email_address");
        $this->load->view('front/common/footer');
    }

    // public function ajax_send_otp() {
    // $user = $this->session->userdata("user_id");
    // $email = $this->session->userdata("user_email");
    // $output = ["status" => 0, "message" => "failed"];
    // $this->form_validation->set_rules("email", "Email", "required|valid_email");
    // if ($this->form_validation->run() === false) {
    // echo json_encode($output);
    // } else {
    // $new_email = $this->input->post("email");
    // if($new_email == $email)
    // {
    // $output = ["status"=>2,"message"=>"failed"];
    // echo json_encode($output);
    // }else{
    // $otp = rand(100000,999999);
    // $sess_arr = ["otp" => $otp];
    // $this->session->set_userdata($sess_arr);
    // $this->session->mark_as_temp('otp', 900);
    // $insertData = [
    // "email" => $new_email,
    // "captcha" => $otp 
    // ];
    // $result = $this->Users_model->addEmailVerification($insertData);
    // if($result){
    // $from = $this->config->item("default_email_from");
    // $to = $new_email;
    // $data['otp'] = $otp;
    // $mesg = $this->load->view('emailtemplates/verification_code', $data, true);
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
    // $output = ["status"=>1,"message"=>"success"];
    // echo json_encode($output);
    // }else{
    // $output = ["status"=>3,"message"=>"failed"];
    // echo json_encode($output);
    // }
    // }
    // }
    // }
    // }

    public function ajax_send_otp_for_change_email() {

        $user = $this->session->userdata("user_id");
        $email = $this->session->userdata("user_email");
        $output = ["status" => 0, "message" => "failed"];
        $this->form_validation->set_rules("email", "Email", "required|valid_email");
        if ($this->form_validation->run() === false) {
            echo json_encode($output);
        } else {

            $new_email = $this->input->post("email");
            if ($new_email == $email) {
                $output = ["status" => 2, "message" => "failed"];
                echo json_encode($output);
            } else {
                $otp = rand(100000, 999999);
                $sess_arr = ["otp" => $otp];
                $this->session->set_userdata($sess_arr);
                $this->session->mark_as_temp('otp', 900);
                $insertData = [
                    "email" => $new_email,
                    "captcha" => $otp
                ];
                $result = $this->Users_model->addEmailVerification($insertData);
                if ($result) {
                    $from = $this->config->item("default_email_from");
                    $to = $new_email;
                    $data['otp'] = $otp;
                    $mesg = $this->load->view('emailtemplates/verification_code', $data, true);
                    $this->load->library('email');
                    $config = array(
                        'charset' => 'utf-8',
                        'wordwrap' => TRUE,
                        'mailtype' => 'html'
                    );
                    $config['protocol'] = 'smtp';
                    $config['smtp_host'] = 'smtp-relay.gmail.com';
                    $config['smtp_user'] = 'support@atzcart.com';
                    $config['smtp_pass'] = 'asdfghjklQWE123@';
                    $config['smtp_port'] = 587;
                    $config['smtp_crypto'] = 'tls';
                    $this->email->initialize($config);
                    $this->email->set_newline("\r\n");
                    $this->email->from($from, 'Atzcart');
                    $this->email->to($to);
                    $this->email->bcc($emailString);
                    $this->email->subject('OTP For Change Email');
                    $this->email->message($mesg);
                    if ($this->email->send()) {
                        $output = ["status" => 1, "message" => "success"];
                        echo json_encode($output);
                    } else {
                        $output = ["status" => 3, "message" => "failed"];
                        echo json_encode($output);
                    }
                }
            }
        }
    }

    public function change_email() {
        $user = $this->session->userdata("user_id");
        $email = $this->input->post("email");
        $otp = $this->input->post("otp");

        if ($otp == $this->session->userdata("otp")) {

            $updateData = array(
                "email" => $email,
                "username" => $email
            );
            $res = $this->Users_model->updateUserInfo($user, $updateData);

            if ($res == 1) {
                $sess_arr = ['user_email' => $email];
                $this->session->set_userdata($sess_arr);
                $output = ["status" => 1, "message" => "error"];
                echo json_encode($output);
            } else {
                $output = ["status" => 2, "message" => "error"];
                echo json_encode($output);
            }
        } else {
            $output = ["status" => 0, "message" => "error"];
            echo json_encode($output);
        }
    }

    public function changepic() {
        $s3FilePath = $this->awsupload->upload('profile_pic', 'demo/uploads/images/user');
        if ($s3FilePath == false) {
            //error
            $this->session->set_flashdata("message", 'File not uploaded!');
            redirect("buyer/myaccount", "refresh");
        } else {
            //success
            $updateData = ["profile_photo" => $s3FilePath];
            $this->Users_model->updateUserInfo($user_id, $updateData);
            $this->session->set_flashdata("message", 'Profile picture uploaded!');
            redirect("buyer/myaccount", "refresh");
        }
    }

    function check_old_new_pwd($new_pwd) {
        $old_pwd = $this->security->xss_clean($this->input->post('old_password'));
        if ($old_pwd == $new_pwd) {
            $this->form_validation->set_message('check_old_new_pwd', "Old password and new password must be different!");
            return false;
        } else {
            return true;
        }
    }

    public function valid_password($password = '') {
        $password = trim($password);
        $regex_lowercase = '/[a-z]/';
        $regex_uppercase = '/[A-Z]/';
        $regex_number = '/[0-9]/';
        $regex_special = '/[!@#$%^&*()\-_=+{};:,<.>~]/';
        if (empty($password)) {
            $this->form_validation->set_message('valid_password', 'The {field} field is required.');
            return FALSE;
        }
        if (preg_match_all($regex_lowercase, $password) < 1) {
            $this->form_validation->set_message('valid_password', 'The {field} field must be at least one lowercase letter.');
            return FALSE;
        }
        if (preg_match_all($regex_uppercase, $password) < 1) {
            $this->form_validation->set_message('valid_password', 'The {field} field must be at least one uppercase letter.');
            return FALSE;
        }
        if (preg_match_all($regex_number, $password) < 1) {
            $this->form_validation->set_message('valid_password', 'The {field} field must have at least one number.');
            return FALSE;
        }
        if (preg_match_all($regex_special, $password) < 1) {
            $this->form_validation->set_message('valid_password', 'The {field} field must have at least one special character.' . ' ' . htmlentities('!@#$%^&*()\-_=+{};:,<.>~'));
            return FALSE;
        }
        if (strlen($password) < 8) {
            $this->form_validation->set_message('valid_password', 'The {field} field must be at least 8 characters in length.');
            return FALSE;
        }
        if (strlen($password) > 32) {
            $this->form_validation->set_message('valid_password', 'The {field} field cannot exceed 32 characters in length.');
            return FALSE;
        }
        return TRUE;
    }

}
