<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Myaccount extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        if (!$this->session->userdata("user_logged_in") || $this->session->userdata("user_role") != "seller") {
            $error = "<div id='login-error' class='form-error notice notice-error'><span class='icon-notice icon-error'></span><span><strong>Error!</strong> Session timeout, relogin!. </span></div>";
            $this->session->set_flashdata("message", $error);
            redirect("login", "refresh");
        }
        $this->load->helper('captcha');
        $this->load->model('Common_model');
        $this->load->model('Company_model');
        $this->load->model('Users_model');
        $this->load->library("form_validation");
        $this->load->library("awsupload");
        $this->load->helper("file");
    }

    public function index() {
        $user_id = $this->session->userdata("user_id");
        $data['user'] = $this->Users_model->getUserAsSellerInfo($user_id);
        $data['company'] = $this->Company_model->getCompanyDetailsBySeller($user_id);
        $data["pageTitle"] = "Profile Details";
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
            $data["pageTitle"] = "Update Profile";
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
            redirect("seller/myaccount", "refresh");
        }
    }

    /*     * ******************** shubham patil ********************** */

    public function change_password() {
        $user = $this->session->userdata("user_id");
        $this->load->library("form_validation");
        $this->form_validation->set_rules('old_password', 'old_password', 'required|callback_isvalidOldPass');
        $this->form_validation->set_error_delimiters('<p style="color:red" class="text-left">', '</p>');
        $this->form_validation->set_rules('new_password', 'New Password', 'required|callback_valid_password');
        $this->form_validation->set_rules('confirm_password', 'Confirm Password', 'required|matches[new_password]');
        $this->form_validation->set_error_delimiters('<div class="alert alert-danger alert-dismissible mt-2">'
                . ' <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><b> Error :</b>', '</div>');

        if ($this->form_validation->run() === false) {
            $data["pageTitle"] = "Change Password";
            $this->load->view("user/account/change_pass", $data);
        } else {
            $update["password"] = password_hash($this->input->post("new_password"), PASSWORD_DEFAULT);
            $this->Users_model->updateUserInfo($user, $update);
            $msg = "<div class='alert alert-success alert-dismissible'>
                    <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                        <strong>Success!</strong> Password updated successfully! Effective from next login.
                    </div>";
            $this->session->set_flashdata("message", $msg);
            redirect("seller/myaccount/change_password", "refresh");
        }
    }

    function set_security_questions() {
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
                $arr["question_id_one"] = htmlentities($this->input->post('questions1'));
                $arr["question_id_two"] = htmlentities($this->input->post('questions2'));
                $arr["question_id_three"] = htmlentities($this->input->post('questions3'));

                $arr["answer_one"] = htmlentities($this->input->post('answer1'));
                $arr["answer_two"] = htmlentities($this->input->post('answer2'));
                $arr["answer_three"] = htmlentities($this->input->post('answer3'));

                $arr["added_date"] = $todays_date;
                $result = $this->Users_model->add_user_questions($id = '', $arr);
                if ($result) {
                    $msg = "<div class='alert alert-success alert-dismissible'>
                    <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                        <strong>Success!</strong> Update Successfully !
                    </div>";
                    $this->session->set_flashdata("message", $msg);
                    redirect("seller/myaccount", "refresh");

                    // $data['success'] = "<div class='alert alert-success alert-dismissible'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><strong>Success!</strong> Submitted!!</div>";
                }
            }
        }

        $data["pageTitle"] = "Security Questions";
        $this->load->view("user/account/security_questions", $data);
    }

    public function update_security_questions($id) {
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
            $arr["question_id_one"] = htmlentities($this->input->post('questions1'));
            $arr["question_id_two"] = htmlentities($this->input->post('questions2'));
            $arr["question_id_three"] = htmlentities($this->input->post('questions3'));

            $arr["answer_one"] = htmlentities($this->input->post('answer1'));
            $arr["answer_two"] = htmlentities($this->input->post('answer2'));
            $arr["answer_three"] = htmlentities($this->input->post('answer3'));
            $arr["added_date"] = $todays_date;

            $result = $this->Users_model->add_user_questions($row_id, $arr);
            if ($result) {
                $msg = "<div class='alert alert-success alert-dismissible'>
                    <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                        <strong>Success!</strong> Update Successfully !
                    </div>";
                $this->session->set_flashdata("message", $msg);
                redirect("seller/myaccount", "refresh");
                // $data['result'] = $this->Users_model->get_user_questions($id);
                // $data['success'] = "<div class='alert alert-success alert-dismissible'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><strong>Success!</strong> Updated!!</div>";
            }
        }

        $data["pageTitle"] = "Security Questions";
        $this->load->view("user/account/update_security_questions", $data);
    }

    public function ajax_get_questions() {
        $result = $this->Users_model->get_all_questions();
        $this->output->set_output(json_encode($result));
    }

    public function email_preferences() {
        $user_id = $this->session->userdata('user_id');
        $data['result'] = $this->Users_model->gat_email_services($user_id);
        $data["pageTitle"] = "Email Preferences";
        $this->load->view("user/account/email_preferences", $data);
    }

    public function ajax_manage_email_services($id, $val) {
        $user_id = $this->session->userdata('user_id');
        $result = $this->Users_model->update_email_services($user_id, $id, $val);
        $this->output->set_output(json_encode($result));
    }

    public function change_email_address() {
        $this->form_validation->set_rules("email", "Email", "required|valid_email|is_unique[users.username]", [
            "is_unique" => "This email id is already registered"
        ]);
        $this->form_validation->set_rules("otp", "Otp", "required");
        if ($this->form_validation->run() === false) {
            $data["email"] = $this->session->userdata("user_email");
            $data["pageTitle"] = "Update Email";
            $this->load->view("user/account/change_email_address", $data);
        } else {
            $user = $this->session->userdata("user_id");
            $email = $this->input->post("email");
            $otp = $this->input->post("otp");
            if ($otp == $this->session->userdata("otp")) {

                $updateData = ["email" => $email];
                $updateData = ["username" => $email];
                $this->Users_model->updateUserInfo($user, $updateData);
                $msg = "<div class='alert alert-success alert-dismissible'>
                        <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                            <strong>Success!</strong> Email changed successfully!.
                          </div>";
                $this->session->set_flashdata("message", $msg);
                redirect("seller/myaccount", "refresh");
            } else {

                $msg = "<div class='alert alert-danger alert-dismissible'>
                <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                <strong>error!</strong> Invalid otp!.
                </div>";
                $this->session->set_flashdata("message", $msg);
                redirect("seller/myaccount/change_email_address", "refresh");
            }
        }
    }

    public function ajax_send_otp() {

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
                    $this->email->subject('OTP For Change Email !');
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

    public function changepic() {
        $user_id = $this->session->userdata("user_id");
        if ($_FILES['profile_pic']['name'] != '' || !empty($_FILES['profile_pic']['name'])) {

            $s3FilePath = $this->awsupload->upload('profile_pic', 'uploads/images/user', 'image');
            if ($s3FilePath == false) {
                $msg = '<div class="alert alert-danger alert-dismissible">
                                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                        <strong>Error!</strong> File type not allowed.!
                                    </div>';
                $this->session->set_flashdata('message', $msg);
                redirect('seller/myaccount');
            } else {
                $updateData["profile_photo"] = $s3FilePath;
                $this->Users_model->updateUserInfo($user_id, $updateData);
            }
        } else {
            $msg = '<div class="alert alert-danger alert-dismissible">
                                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                        <strong>Error!</strong> No file selected.!
                                    </div>';
            $this->session->set_flashdata('message', $msg);
            redirect('seller/myaccount');
        }
        redirect("seller/myaccount", "refresh");
    }

    public function isvalidOldPass($password) {
        $user = $this->session->userdata("user_id");
        $userInfo = $this->Users_model->getUserById($user);
        if (password_verify($password, $userInfo->password)) {
            return true;
        } else {
            $this->form_validation->set_message("isvalidOldPass", "Invalid old password");
            return false;
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
