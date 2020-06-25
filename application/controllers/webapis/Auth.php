<?php

defined('BASEPATH') OR exit('No direct script access allowed');

use Firebase\JWT\JWT;

class Auth extends REST_Controller {

    public function __construct($config = 'rest') {
        parent::__construct($config);
        $this->load->library('form_validation');
        $this->load->model('Users_model');
        $this->load->model('Company_model');
        $this->load->model('Common_model');
    }

    public function login_post() {

        $this->form_validation->set_rules("username", "Username", "required");
        $this->form_validation->set_rules("password", "password", "required");
        $this->form_validation->set_rules("firebase_id", "password", "required");
        $this->form_validation->set_rules("device_os", "password", "required");
        $this->form_validation->set_rules("device_name", "password", "required");
        $this->form_validation->set_rules("device_imei", "password", "required");
        if ($this->form_validation->run() === false) {
            $output = array(
                "ws" => "login",
                "status" => 0,
                "message" => "invalid inputs"
            );
            $this->set_response($output, REST_Controller::HTTP_OK);
        } else {

            //shailesh sawant update the code by this callled something is 
            $username = $this->post("username");
            $password = $this->post("password");
            $firebase_id = $this->post("firebase_id");
            $device_os = $this->post("device_os");
            $device_name = $this->post("device_name");
            $device_imei = $this->post("device_imei");
            $user = $this->Users_model->getUserByUsername($username);

            if ($user) {
                if ($user->status == 0) {
                    $output = array(
                        "ws" => "login",
                        "status" => 0,
                        "message" => "Account banned! Contact support..."
                    );
                    $this->set_response($output, REST_Controller::HTTP_OK);
                } else {
                    if (password_verify($password, $user->password)) {
                        $device_data = array(
                            "firebase_id" => $this->post("firebase_id"),
                            "device_os" => $this->post("device_os"),
                            "device_name" => $this->post("device_name"),
                            "device_imei" => $this->post("device_imei")
                        );
                        $this->Users_model->updateUserDeviceDetails($user->id, $device_data);
                        $date = new DateTime();
                        $token = [
                            'userid' => $user->id,
                            'user_full_name' => $user->first_name . " " . $user->last_name,
                            'email' => $user->email,
                            'phone' => $user->phone,
                            'profile_photo' => $user->profile_photo,
                            "iat" => $date->getTimestamp(),
                            "exp" => $date->getTimestamp() + 60 * 60 * 24
                        ];
                        $output = [
                            "token" => JWT::encode($token, $this->config->item('jwt_secret_key')),
                            "ws" => "login",
                            "status" => 1,
                            "message" => "success"
                        ];
                        $this->set_response($output, REST_Controller::HTTP_OK);
                    } else {
                        $output = array(
                            "ws" => "login",
                            "status" => 0,
                            "message" => "invalid username / password"
                        );
                        $this->set_response($output, REST_Controller::HTTP_OK);
                    }
                }
            } else {
                $output = array(
                    "ws" => "login",
                    "status" => 0,
                    "message" => "invalid username / password"
                );
                $this->set_response($output, REST_Controller::HTTP_OK);
            }
        }
    }

    public function requestotp_post() {
        $ws_temp = $this->post("ws");
        $ws = "requestotp";
        if (isset($ws_temp)) {
            $ws = $ws_temp;
        }
        $output = [
            "status" => 0,
            "message" => "Invalid inputs",
            "ws" => $ws
        ];
        $this->form_validation->set_rules("mobile", "mobile", "required");
        if ($this->form_validation->run() === false) {
            $this->response($output, REST_Controller::HTTP_OK);
        } else {

            //SMS Otp to Mobile
            $otp = rand(100000, 999999);
            $mob = $this->post("mobile");
            $tag = $this->post("tag");

            //check email /Mobile
            $this->db->select('*');
            $this->db->from('users');
            $this->db->where('username', $mob);
            $this->db->or_where('phone', $mob);
            $query = $this->db->get();
            $res = $query->row();

            if (!empty($res) && $tag != 'register') {
                $mob = $res->phone;

                $email = $res->email;

                $ch_send = $this->send_otp($otp, $mob);
                //////////////////SENT OTP End////////////////////

                if ($ch_send == 'success') {
                    $insertData = [
                        "mobile" => $mob,
                        "otp" => $otp
                    ];
                    $this->Users_model->addMobileOtp($insertData);
                    $this->send_otp_by_mail($otp, $email);

                    $output["ws"] = $ws;
                    $output["status"] = 1;
                    $output["message"] = "Otp sent successfully !";
                } else {
                    $output["ws"] = $ws;
                    $output["status"] = 0;
                    $output["message"] = "Otp Not Sent Retry !";
                }
            } elseif ($tag == 'register' && empty($res)) {
                $ch_send = $this->send_otp($otp, $mob);
                //////////////////SENT OTP End////////////////////

                if ($ch_send == 'success') {
                    $insertData = [
                        "mobile" => $mob,
                        "otp" => $otp
                    ];
                    $this->Users_model->addMobileOtp($insertData);
                    $output["ws"] = $ws;
                    $output["status"] = 1;
                    $output["message"] = "Otp sent successfully !";
                } else {
                    $output["ws"] = $ws;
                    $output["status"] = 0;
                    $output["message"] = "Otp Not Sent Retry !";
                }
            } elseif ($tag == 'forget' && empty($res)) {
                $output["ws"] = $ws;
                $output["status"] = 0;
                $output["message"] = "No Record Found !";
            } else {
                $output["ws"] = $ws;
                $output["status"] = 0;
                $output["message"] = "Already Exist !";
            }
            $this->response($output, REST_Controller::HTTP_OK);
        }
    }

    public function verifyotp_post() {
        $ws_temp = $this->post("ws");
        $ws = "verifyotp";
        if (isset($ws_temp)) {
            $ws = $ws_temp;
        }
        $output = [
            "status" => 0,
            "message" => "Invalid Inputs",
            "ws" => $ws
        ];
        $this->form_validation->set_rules("mobile", "mobile", "required");
        $this->form_validation->set_rules("otp", "otp", "required");
        if ($this->form_validation->run() === false) {
            $this->response($output, REST_Controller::HTTP_OK);
        } else {
            $mobile = $this->post("mobile");
            $userOtp = $this->post("otp");
            $tag = $this->post("tag");
            $dbOtp = $this->Users_model->getMobileOtpByMobileNo($mobile, $tag);
            //echo $this->db->last_query();
            //exit;
            //echo $dbOtp->otp.'|'.$userOtp;
            // exit;
            if ($dbOtp && $dbOtp->otp == $userOtp) {
                $updateData = ["status" => 1];
                $this->Users_model->updateMobileOtp($updateData, $dbOtp->id);
                //echo $this->db->last_query();
                //exit;
                $output["message"] = "Otp Verified";
                $output["status"] = 1;
                $this->response($output, REST_Controller::HTTP_OK);
            } else {
                $output["message"] = "Invalid Otp";
                $this->response($output, REST_Controller::HTTP_OK);
            }
        }
    }

    public function register_post() {
        $ws_temp = $this->post("ws");
        $ws = "register";
        if (isset($ws_temp)) {
            $ws = $ws_temp;
        }
        $output = [
            "status" => 0,
            "message" => "Invalid Inputs",
            "ws" => $ws
        ];
        $this->form_validation->set_rules("first_name", "First Name", "required");
        $this->form_validation->set_rules("last_name", "Last Name", "required");
        $this->form_validation->set_rules("country", "Country", "required");
        $this->form_validation->set_rules("email", "Email", "required|is_unique[users.email]");
        $this->form_validation->set_rules("password", "Password", "required");
        $this->form_validation->set_rules("company", "Comapany", "required");
        $this->form_validation->set_rules("mobile", "Mobile", "required|is_unique[users.phone]");
        $this->form_validation->set_rules("firebase_id", "password", "required");
        $this->form_validation->set_rules("device_os", "password", "required");
        $this->form_validation->set_rules("device_name", "password", "required");
        $this->form_validation->set_rules("device_imei", "password", "required");
        if ($this->form_validation->run() === false) {
            $this->response($output, REST_Controller::HTTP_OK);
        } else {
            $tag = $this->post("tag");
            $extMobile = $this->Users_model->getMobileOtpByMobileNo($this->post("mobile"), $tag);
            // echo $this->db->last_query();
            //echo $extMobile->status;
            // exit;
            if ($extMobile && $extMobile->status == 1) {
                $tmp_pass = $this->post("password");
                $tmp_company = $this->post("company");
                $source = $this->post("source");
                $source_id = $this->post("source_unique_id");
                $flag = 0;
                if ($source != "" && $source_id != "") {
                    $tmp_pass = rand(100000, 999999);
                    $flag = 1;
                    $tmp_company = $this->post("first_name") . " " . $this->post("last_name");
                }

                $email = $this->post("email");
                $first_name = $this->post('first_name');
                $last_name = $this->post('last_name');
                $insertData = [
                    "username" => $email,
                    "password" => password_hash($tmp_pass, PASSWORD_DEFAULT),
                    "role" => "buyer",
                    "first_name" => $this->post("first_name"),
                    "last_name" => $this->post("last_name"),
                    "email" => $email,
                    "phone" => $this->post("mobile"),
                    "country" => $this->post("country"),
                    "profile_photo" => "default.png",
                    "status" => 1,
                ];
                $user = $this->Users_model->add_user($insertData);
                $notification_title = 'Seller Registration';
                $notification_msg = 'New Seller ' . $first_name . ' ' . $last_name . 'has joined ATZCart';
                $notification_type = 'User Registration';
                $reference_id = $user;
                add_admin_notification($notification_title, $notification_msg, $notification_type, $reference_id);
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


                //Zero Buyer wallet Entry
                $b_wallet['user_id'] = $user;
                $b_wallet['balance'] = 0.00;
                $b_wallet['status'] = 1;
                $b_wallet['created'] = date('Y-m-d H:i:s');
                $b_wallet['updated'] = date('Y-m-d H:i:s');
                $this->Common_model->insert('buyer_wallet', $b_wallet);


                $companyData = [
                    "user_id" => $user,
                    "company_name" => $tmp_company,
                    "primary_business_type" => $this->post("business_type")
                ];
                $companyInfo = [
                    "user_id" => $user,
                    "company_name" => $tmp_company,
                    "company_type" => $this->post("business_type"),
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

                $device_data = array(
                    "user_id" => $user,
                    "firebase_id" => $this->post("firebase_id"),
                    "device_os" => $this->post("device_os"),
                    "device_name" => $this->post("device_name"),
                    "device_imei" => $this->post("device_imei")
                );

                $this->Users_model->addUserDeviceDetails($device_data);

                if ($flag) {
                    $socialData = [
                        "user_id" => $user,
                        "facebook_id" => "",
                    ];
                    if ($source == "facebook") {
                        $socialData["facebook_id"] = $source_id;
                    } else {
                        $socialData["google_id"] = $source_id;
                    }
                    $this->Users_model->addSocialAuth($socialData);
                    $this->send_password($tmp_pass, $this->post("mobile"));
                }

                $userInfo = $this->Users_model->getUserById($user);
                $date = new DateTime();
                $token = [
                    'userid' => $userInfo->id,
                    'user_full_name' => $userInfo->first_name . " " . $userInfo->last_name,
                    'email' => $userInfo->email,
                    'phone' => $userInfo->phone,
                    "iat" => $date->getTimestamp(),
                    "exp" => $date->getTimestamp() + 60 * 60 * 24
                ];
                $output = [
                    "token" => JWT::encode($token, $this->config->item('jwt_secret_key')),
                    "ws" => "auth",
                    "status" => 1,
                    "message" => "success"
                ];
                $this->set_response($output, REST_Controller::HTTP_OK);
            } else {
                $output["message"] = "Unrecognised mobile number!";
                $output["status"] = 0;
                $this->response($output, REST_Controller::HTTP_OK);
            }
        }
    }

    public function checkUniqueUser_post() {
        $ws_temp = $this->post("ws");
        $ws = "checkUniqueUser";
        if (isset($ws_temp)) {
            $ws = $ws_temp;
        }
        $output = [
            "status" => 0,
            "message" => "",
            "ws" => $ws
        ];
        $email = $this->input->post('email');

        $this->form_validation->set_rules("email", "email", "required|valid_email|is_unique[users.email]", array(
            "is_unique" => "Email already exists"
        ));
        if ($this->form_validation->run() === false) {
            $output["message"] = strip_tags(validation_errors());
            $this->response($output, REST_Controller::HTTP_OK);
        } else {
            $output["status"] = 1;
            $output["message"] = "Success";
            $this->response($output, REST_Controller::HTTP_OK);
        }
    }

    public function socialAuth_post() {
        $ws_temp = $this->post("ws");
        $ws = "socialAuth";
        if (isset($ws_temp)) {
            $ws = $ws_temp;
        }
        $output = [
            "status" => 0,
            "message" => "invalid inputs",
            "ws" => $ws,
                //"debug" => $this->post()
        ];
        $this->form_validation->set_rules("email", "Email", "required");
        $this->form_validation->set_rules("firebase_id", "firebase_id", "required");
        $this->form_validation->set_rules("device_os", "device_os", "required");
        $this->form_validation->set_rules("device_name", "device_name", "required");
        $this->form_validation->set_rules("device_imei", "device_imei", "required");
        $this->form_validation->set_rules("source", "source", "required");
        $this->form_validation->set_rules("source_unique_id", "source_unique_id", "required");
        if ($this->form_validation->run() === false) {
            //echo validation_errors();
            $this->response($output, REST_Controller::HTTP_OK);
        } else {
            $username = $this->post("email");
            $user = $this->Users_model->getUserByUsername($username);
            if ($user) {
                $user_social_auth = $this->Users_model->getSocialAuth($user->id);
                $source = $this->post("source");
                $source_id = $this->post("source_unique_id");
                $valid = false;
                if ($user_social_auth) {
                    if ($source == "facebook" && $source_id == $user_social_auth->facebook_id) {
                        $valid = true;
                    } else if ($source == "google" && $source_id == $user_social_auth->google_id) {
                        $valid = true;
                    }
                }
                if ($valid) {
                    $device_data = array(
                        "user_id" => $user->id,
                        "firebase_id" => $this->post("firebase_id"),
                        "device_os" => $this->post("device_os"),
                        "device_name" => $this->post("device_name"),
                        "device_imei" => $this->post("device_imei")
                    );

                    $ch_exist = $this->Common_model->getAll('users', array('email' => $username))->num_rows();
                    if ($ch_exist == 0) {
                        //Zero Buyer wallet Entry
                        $b_wallet['user_id'] = $user->id;
                        $b_wallet['balance'] = 0.00;
                        $b_wallet['status'] = 1;
                        $b_wallet['created'] = date('Y-m-d H:i:s');
                        $b_wallet['updated'] = date('Y-m-d H:i:s');
                        $this->Common_model->insert('buyer_wallet', $b_wallet);
                    }
                    $this->Users_model->addUserDeviceDetails($device_data);
                    $date = new DateTime();
                    $token = [
                        'userid' => $user->id,
                        'user_full_name' => $user->first_name . " " . $user->last_name,
                        'email' => $user->email,
                        'phone' => $user->phone,
                        'profile_photo' => $user->profile_photo,
                        "iat" => $date->getTimestamp(),
                        "exp" => $date->getTimestamp() + 60 * 60 * 24
                    ];
                    $output["status"] = 1;
                    $output["redirect"] = "Dashboard";
                    $output["message"] = "Login Successfull";
                    $output["token"] = JWT::encode($token, $this->config->item('jwt_secret_key'));
                    $this->response($output, REST_Controller::HTTP_OK);
                } else {
                    $output["status"] = 0;
                    $output["redirect"] = "";
                    $output["message"] = "Social authentication id did not match!";
                    $this->response($output, REST_Controller::HTTP_OK);
                }
            } else {
                $output["status"] = 1;
                $output["redirect"] = "Register";
                $output["message"] = "Authenticated";
                $this->response($output, REST_Controller::HTTP_OK);
            }
        }
    }

    function send_otp($otp, $mob) {
        if ($mob > 0) {
            $msg = urlencode("OTP From ATZ Cart is : " . $otp);
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, "http://sms.smslab.in/api/sendhttp.php?authkey=271209AqkMbb4pSiXR5ca89dc7&mobiles=" . $mob . "&message=" . $msg . "&new&mobile&sender=ATZCRT&route=4");
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            $res = curl_exec($ch);
            curl_close($ch);
            $msg = 'success';
            return $msg;
        } else {
            $msg = 'error';
            return $msg;
        }
    }

    function send_password($otp, $mob) {
        if ($mob > 0) {
            $msg = urlencode("Generated password for atzcart.com is : " . $otp);
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, "http://sms.smslab.in/api/sendhttp.php?authkey=271209AqkMbb4pSiXR5ca89dc7&mobiles=" . $mob . "&message=" . $msg . "&new&mobile&sender=ATZCRT&route=4");
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            $res = curl_exec($ch);
            curl_close($ch);
            $msg = 'success';
            return $msg;
        } else {
            $msg = 'error';
            return $msg;
        }
    }

    public function forgot_password_post() {

        $ws_temp = $this->post("ws");
        $ws = "forgot_password";
        if (isset($ws_temp)) {
            $ws = $ws_temp;
        }
        $output = [
            "status" => 0,
            "message" => "Data Not Found",
            "ws" => $ws
        ];

        $this->form_validation->set_rules("email_id", "email_id", "required");
        if ($this->form_validation->run() == false) {
            $this->response($output, REST_Controller::HTTP_OK);
        } else {
            $email_id = $this->input->post('email_id');

            $user_record = $this->Common_model->select('email,id', 'users', ['email' => $email_id]);

            if (!empty($user_record)) {
//                echo "<pre>";
//                print_r($user_record);
//                exit;
                $message = 'Oops! Bad luck, you forgot your password? No worries.
                            Reset your password via the given link <br/><a href="' . base_url('user/login/reset_password/') . '">Click here to reset password</a>';
                $this->load->library('email');
                $this->email->from($this->config->item("default_email_from"), "Atzcart");
                $this->email->to($email_id);
                $this->email->mailtype = "html";
                $this->email->newline = "\r\n";
                $this->email->subject('Email verification');
                $this->email->message($message);
                $this->email->send();

                $output["status"] = 1;
                $output["message"] = "Email Sent Successfully!";
            } else {
                $output = [
                    "status" => 0,
                    "message" => "User not found",
                    "ws" => $ws
                ];
            }
            $this->response($output, REST_Controller::HTTP_OK);
        }
    }

    public function change_password_post() {

        $ws_temp = $this->post("ws");
        $ws = "change_password";
        if (isset($ws_temp)) {
            $ws = $ws_temp;
        }
        $output = [
            "status" => 0,
            "message" => "Data Not Found",
            "ws" => $ws
        ];

        $this->form_validation->set_rules("new_password", "new_password", "required");
        $this->form_validation->set_rules("confirm_password", "confirm_password", "required");
        if ($this->form_validation->run() == false) {
            $this->response($output, REST_Controller::HTTP_OK);
        } else {
            $new_password = $this->post('new_password');
            $confirm_password = $this->post('confirm_password');

            $userdata = $this->Users_model->getUserById($this->_payload->userid);


            $new_password = password_hash($new_password, PASSWORD_DEFAULT);
            $this->Users_model->changePasswordData($new_password, $this->_payload->userid);

            $output["status"] = 1;
            $output["message"] = "Password changed successfully";

            $this->response($output, REST_Controller::HTTP_OK);
        }
    }

    public function testPassword_get() {
        echo password_hash("123456", PASSWORD_DEFAULT);
    }

    function send_otp_by_mail($otp, $email) {
        $from = $this->config->item("default_email_from");
        $to = $email;
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
        $this->email->subject('OTP For Forget Password');
        $this->email->message($mesg);
        
        $this->email->send();
    }

}
