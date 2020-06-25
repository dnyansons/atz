<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Signup extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model("Users_model");
        $this->load->model("Product_model");
        $this->load->model("Common_model");
        $this->load->library('Browser_notification');
        $this->load->library("Send_data");
        $this->load->library("form_validation");
        if ($this->session->userdata("user_logged_in")) {
            redirect("buyer/dashboard", "refresh");
        }
    }

    public function index() {
        $array_items = array('mobile_otp' => '', 'temp_email' => '', 'temp_mobile' => '');
        $this->session->unset_userdata($array_items);
        $this->session->set_userdata(["mobile_otp" => "", "temp_email" => "", "temp_mobile" => '']);
        $this->form_validation->set_error_delimiters('<p style="color:red" class="text-left">', '</p>');
        $this->form_validation->set_rules("email", "Email", "required|valid_email|is_unique[users.username]", [
            "is_unique" => "This email id is already registered"
        ]);

        $this->form_validation->set_rules('mobile_number', 'Mobile Number ', 'required|is_unique[users.phone]|regex_match[/^[0-9]{10}$/]', ['regex_match' => 'Please Enter The Valid Mobile Number', 'is_unique' => 'This Mobile number is already registered']); //{10} for 10 digits number


        if ($this->form_validation->run() === false) {
            $data["pageTitle"] = "Sign up - atzcart";
            $this->load->view("user/signup/send_code");
        } else {
            $email = $this->input->post("email");
            $mobile_no = $this->input->post("mobile_number");
            $otp = rand(100000, 999999);
            if ($this->send_otp($otp, $mobile_no)) {
                $this->session->set_userdata(["mobile_otp" => $otp, "temp_email" => $email, "temp_mobile" => $mobile_no]);
                $msg = '<div class="text-left alert alert-success alert-dismissible">
                                <a href="#" class="text-left close pb-2" data-dismiss="alert" aria-label="close">&times;</a>
                                <strong>Success!</strong> Please Insert OTP.
                                </div>';
                $this->session->set_flashdata("message", $msg);
                redirect("signup/verify", "refresh");
            } else {
                $msg = '<div class="text-left alert alert-success alert-dismissible">
                            <a href="#" class="text-left close" data-dismiss="alert" aria-label="close">&times;</a>
                            <strong>Success!</strong> Indicates a successful or positive action.
                        </div>';
                $this->session->set_flashdata("message", $msg);
                redirect("signup", "refresh");
            }
        }
    }

    function send_otp($otp = 0, $mob = 0) {
        if ($mob > 0) {
            $msg = urlencode("Dear user please use " . $otp . " as your one time password verification code.");
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, "http://sms.smslab.in/api/sendhttp.php?authkey=271209AqkMbb4pSiXR5ca89dc7&mobiles=" . $mob . "&message=" . $msg . "&new&mobile&sender=ATZCRT&route=4");
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            $res = curl_exec($ch);
            curl_close($ch);

            return true;
        } else {
            return false;
        }
    }

    public function verify() {
        $this->form_validation->set_rules("otp", "Otp", "required", ['required' => 'Please Enter OTP']);
        $this->form_validation->set_error_delimiters('<p style="color:red" class="text-left">', '</p>');
        if ($this->form_validation->run() === false) {
            $data["pageTitle"] = "Sign up - atzcart";
            $this->load->view("user/signup/verify_code");
        } else {
            $otp = $this->input->post("otp");
            $sess_otp = $this->session->userdata("mobile_otp");
            if ($otp == $sess_otp) {
                $this->session->set_userdata(["email_verified" => true]);
                redirect("signup/generalinfo", "refresh");
            } else {
                $msg = '<div class="text-left alert alert-danger alert-dismissible">
                             <a href="#"  class="close pt-2" data-dismiss="alert" aria-label="close">&times;</a>
                             <strong>Error!</strong> Invalid Otp.
                         </div>';
                $this->session->set_flashdata("message", $msg);
                redirect("signup/verify", "refresh");
            }
        }
    }

    public function generalinfo() {
        $is_verified_email = $this->session->userdata("email_verified");
        if ($is_verified_email) {
            $this->form_validation->set_rules("first_name", "First Name", "required");
            $this->form_validation->set_rules("last_name", "Last Name", "required");
            $this->form_validation->set_rules("password", "Password", "required");
            $this->form_validation->set_rules("pincode", "PIN code", "required");
            $this->form_validation->set_error_delimiters('<p style="color:red" class="text-left">', '</p>');
            if ($this->form_validation->run() === false) {
                $data["pageTitle"] = "General Information";
                $states = $this->Common_model->getAll("states", ["country_id" => 101])->result_array();
                $stat = array();
                foreach ($states as $st):
                    $stat[$st["name"]] = $st["name"];
                endforeach;
                $data["states"] = $stat;

                $this->load->view("user/signup/general", $data);
            } else {
                $email = $this->session->userdata("temp_email");
                $mobile_no = $this->session->userdata("temp_mobile");
                $insertData = [
                    "username" => $email,
                    "password" => password_hash($this->input->post("password"), PASSWORD_DEFAULT),
                    "role" => "buyer",
                    "first_name" => $this->input->post("first_name"),
                    "last_name" => $this->input->post("last_name"),
                    "email" => $email,
                    "phone" => $mobile_no,
                    "address" => $this->input->post("address"),
                    "country" => $this->input->post("country"),
                    "state" => $this->input->post("state"),
                    "city" => $this->input->post("city"),
                    "status" => 1,
                ];

                $user = $this->Users_model->add_user($insertData);
                $addressBook = [
                    "user_id" => $user,
                    "contact_person" => $this->input->post("first_name") . " " . $this->input->post("last_name"),
                    "contact_number" => $mobile_no,
                    "street" => $this->input->post("address"),
                    "city" => $this->input->post("city"),
                    "postcode" => $this->input->post("pincode"),
                    "state" => $this->input->post("state"),
                    "country" => $this->input->post("country"),
                ];
                $this->Users_model->addAddressBook($addressBook);

                //Zero Buyer wallet Entry
                $b_wallet['user_id'] = $user;
                $b_wallet['balance'] = 0.00;
                $b_wallet['status'] = 1;
                $b_wallet['created'] = date('Y-m-d H:i:s');
                $b_wallet['updated'] = date('Y-m-d H:i:s');
                $this->Common_model->insert('buyer_wallet', $b_wallet);

                //insert in adminnotify table
                $adminNotify = array(
                    'title' => 'New Buyer Joined',
                    'msg' => 'Buyer ' . $this->input->post("first_name") . " " . $this->input->post("last_name") . ' ( Web ) ',
                    'type' => 'Buyer_Registration',
                    'reference_id' => $user,
                    'status' => 'Received'
                );

                $insertAdminNotify = $this->Product_model->insertAdminNotify($adminNotify);


                //Notification 

                $title = 'New Buyer Joined';
                $message = $this->input->post("first_name") . " " . $this->input->post("last_name");
                $tag = date('d M Y H:i');
                $this->browser_notification->notifyadmin($title, $message, $tag);

                //Send SMS to Buyer
                $message = 'Dear valuable Customer,Thank you for choosing atzcart.com as your bulk ecommerce platform. Enjoy our seamless Products and Services for Your Requirements. Visit Our Site www.atzcart.com or Download our Mobile Application from Google Playstore and Apple Appstore.';

                $this->send_data->send_sms($message, $mobile_no);

                //send Email
                $name = $this->input->post("first_name") . " " . $this->input->post("last_name");
                $this->welcome_mail($email, $name);

                //$this->session->set_userdata(["success_flag" => true, "email_verified" => false]);
                //redirect("signup/complete", "refresh");
                $session_data = array(
                    "user_logged_in" => TRUE,
                    "user_id" => $user,
                    "user_name" => $this->input->post("first_name") . " " . $this->input->post("first_name"),
                    "user_role" => "buyer",
                    "user_currency" => "INR",
                    "user_email" => $email,
                    "phone" => $mobile_no,
                );

                $this->session->set_userdata($session_data);

                redirect(base_url(), "refresh");
            }
        } else {
            redirect("signup", "refresh");
        }
    }

    function welcome_mail($email, $name) {


        $data['email'] = $email;
        $data['name'] = $name;
        $data['up_date'] = date('Y-m-d H:i:s');
        $from = $this->config->item("default_email_from");
        $to = $email;
        $this->load->library('email');
        $mesg2 = $this->load->view('emailtemplates/welcome', $data, true);

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
        //$this->email->bcc($emailString);
        $this->email->subject('Welcome To ATZ Cart !');
        $this->email->message($mesg2);
        $this->email->send();
    }

    public function complete() {
        if ($this->session->userdata("success_flag")) {
            $data["pageTitle"] = "Registration Successfull";
            $this->load->view("user/signup/success", $data);
        } else {
            redirect("signup", "refresh");
        }
    }

    public function check() {
        //echo "<pre>";
        //print_r($_SESSION);
    }

    function resend_otp() {
        $mob = $this->input->post('mob');
        $otp = $this->input->post('otp');
        if ($mob > 0 && $otp != '') {
            $msg = "Dear user please use " . $otp . " as your one time password verification code.";

            $this->send_data->send_sms($msg, $mob);

            echo '<div class="alert alert-success alert-dismissible">
          <a href="#" class="close" data-dismiss="alert" aria-label="close" style="margin-top: -1px;">&times;</a>
          OTP Resent Successfully
        </div>';
        }
    }

}
