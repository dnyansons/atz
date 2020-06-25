<?php

defined('BASEPATH') OR exit('No direct script access allowed');

use Firebase\JWT\JWT;

class Profile extends REST_Controller {

    private $_payload;

    public function __construct($config = 'rest') {

        parent::__construct($config);
        $token = $this->input->get_request_header('Token');
        try {
            $this->_payload = JWT::decode($token, $this->config->item('jwt_secret_key'), array('HS256'));
        } catch (Exception $ex) {
            $output = array("status" => 0, "message" => $ex->getMessage());
            $this->response($output, REST_Controller::HTTP_UNAUTHORIZED);
        }
        $this->load->library('form_validation');
        $this->load->library('Shipping');
        $this->load->library('Browser_notification');
        $this->load->library('Shiprocket');
        $this->load->library('Send_data');
        $this->load->model('Users_model');
        $this->load->model('Company_model');
        $this->load->model('Inquiries_model');
        $this->load->model('Coupon_model');
        $this->load->model('Myfavourite_model');
        $this->load->model('Product_model');
        $this->load->model('Profile_model');
        $this->load->model('Common_model');
    }

    public function retrive_get() {
        $output = [
            "ws" => "profile",
            "status" => 0,
            "message" => "Unable to fetch profile details",
            "data" => []
        ];

        $user = $this->Users_model->getUserAsSellerInfo($this->_payload->userid);

        if ($user) {

            $user->profile_photo = $user->profile_photo;
            $company = $this->Company_model->getCompanyDetailsBySeller($this->_payload->userid);
            $unreadInquiriesCount = $this->Inquiries_model->getUnreadInquiriesCountByUserData($this->_payload->userid);
            ///////////////////////////////////

            $user->unread_inquiries_count = $unreadInquiriesCount;
            $user->profile_complete_status_count = 0;

            if ($user->email_verified == 0) {
                $user->email_verified_status = 0;
                //$user->profile_complete_status_count--;
            } else {
                $user->email_verified_status = 1;
                $user->profile_complete_status_count++;
            }

            //prefer reason
            // $prefer_reason=$user->preferred_sourcing_reasons_id[0]->reason_id;
            // if(!empty($prefer_reason))
            // {
            //  }
            ///////////////////////////////////
            ///////////////////////////////////

            if (empty($user->annual_purchasing_amount)) {
                $user->annual_purchasing_amount_status = 0;
                //$user->profile_complete_status_count--;
            } else {
                $user->annual_purchasing_amount_status = 1;
                $user->profile_complete_status_count++;
            }

            ///////////////////////////////////
            ///////////////////////////////////

            if (empty($user->annual_purchasing_frequency)) {
                $user->annual_purchasing_frequency_status = 0;
                //$user->profile_complete_status_count--;
            } else {
                $user->annual_purchasing_frequency_status = 1;
                $user->profile_complete_status_count++;
            }

            ///////////////////////////////////
            ///////////////////////////////////

            $prefer_reason = $user->preferred_sourcing_reasons_id[0]->reason_id;
            if (empty($prefer_reason)) {
                $user->business_type_status = 0;
                //$user->profile_complete_status_count--;
            } else {
                $user->business_type_status = 1;
                $user->profile_complete_status_count++;
            }

            ///////////////////////////////////
            ///////////////////////////////////

            if (empty($company->location_country) || empty($company->building_number_and_street) || empty($company->comp_operational_city) || empty($company->comp_operational_state) || empty($company->comp_operational_zip_code) || empty($company->company_name)) {
                $user->company_address_status = 0;
                $user->company_name_status = 0;
                //$user->profile_complete_status_count--;
            } else {
                $user->company_address_status = 1;
                $user->company_name_status = 1;
                $user->profile_complete_status_count++;
                $user->profile_complete_status_count++;
            }
            $user->shopping_cart_count = $this->getUsersCartItemsCount($this->_payload->userid);

            ///////////////////////////////////

            $output["data"] = [
                "user" => $user,
                "company" => $company,
                "rate_app_image" => "https://www.atzcart.com/uploads/images/rate_app.jpg",
                "help_center_url" => "https://www.atzcart.com/help-center",
                "terms_of_licence" => "https://m.atzcart.com/policy/term",
                "privacy_policy" => "https://m.atzcart.com/policy",
                "cookies" => "https://m.atzcart.com/policy/cookie",
            ];
            $output["status"] = 1;
            $output["message"] = "profile data fetch successfully";
            $this->response($output, REST_Controller::HTTP_OK);
        } else {
            $this->response($output, REST_Controller::HTTP_OK);
        }
    }

    public function updateprofile_post() {

        $ws = $this->post('ws');

        if (empty($ws)) {
            $ws = "updateprofile";
        }

        $output = [
            "ws" => $ws,
            "status" => 0,
            "message" => "Unable to update profile details"
        ];


        if ($ws == "profileupdate_name") {
            $this->form_validation->set_rules("first_name", "First name", "required");
            $this->form_validation->set_rules("last_name", "last name", "required");
            $this->form_validation->set_error_delimiters('', '');

            if ($this->form_validation->run() === false) {
                $output = array(
                    "ws" => $ws,
                    "status" => 0,
                    "message" => "invalid input"
                );

                $this->set_response($output, REST_Controller::HTTP_OK);
            } else {
                $update_data = [];
                $update_data['first_name'] = $this->post('first_name');
                $update_data['last_name'] = $this->post('last_name');
                //echo "<pre>";
                //print_r($update_data);
                $this->Users_model->updateUserInfo($this->_payload->userid, $update_data);
                $output["status"] = 1;
                $output["message"] = "profile data updated successfully";
                $this->response($output, REST_Controller::HTTP_OK);
                exit;
            }
        }


        if ($ws == "profileupdate_email") {
            
        }


        if ($ws == "profileupdate_companyname") {
            $this->form_validation->set_rules("location_country", "location_country", "required");
            $this->form_validation->set_rules("building_number_and_street", "building_number_and_street", "required");
            $this->form_validation->set_rules("comp_operational_city", "comp_operational_city", "required");
            $this->form_validation->set_rules("comp_operational_state", "comp_operational_state", "required");
            $this->form_validation->set_rules("comp_operational_zip_code", "comp_operational_zip_code", "required");
            $this->form_validation->set_rules("company_name", "company_name", "required");

            if ($this->form_validation->run() === false) {
                $output = array(
                    "ws" => $ws,
                    "status" => 0,
                    "message" => "invalid inputs"
                );

                $this->set_response($output, REST_Controller::HTTP_OK);
            } else {
                $update_data['location_country'] = $this->post('location_country');
                $update_data['building_number_and_street'] = $this->post('building_number_and_street');
                $update_data['comp_operational_city'] = $this->post('comp_operational_city');
                $update_data['comp_operational_state'] = $this->post('comp_operational_state');
                $update_data['comp_operational_zip_code'] = $this->post('comp_operational_zip_code');
                $update_data['company_name'] = $this->post('company_name');
                $update_data['update_at'] = date('Y-m-d H:i:s');
                $this->Company_model->updateCompanyProfile($this->_payload->userid, $update_data);
                $output["status"] = 1;
                $output["message"] = "profile data updated successfully";
                $this->response($output, REST_Controller::HTTP_OK);
            }
        }



        if ($ws == "profileupdate_companyaddress") {
            $this->form_validation->set_rules("location_country", "location_country", "required");
            $this->form_validation->set_rules("building_number_and_street", "building_number_and_street", "required");
            $this->form_validation->set_rules("comp_operational_city", "comp_operational_city", "required");
            $this->form_validation->set_rules("comp_operational_state", "comp_operational_state", "required");
            $this->form_validation->set_rules("comp_operational_zip_code", "comp_operational_zip_code", "required");
            $this->form_validation->set_rules("company_name", "company_name", "required");

            if ($this->form_validation->run() === false) {
                $output = array(
                    "ws" => $ws,
                    "status" => 0,
                    "message" => "invalid inputs"
                );

                $this->set_response($output, REST_Controller::HTTP_OK);
            } else {
                $update_data['location_country'] = $this->post('location_country');
                $update_data['building_number_and_street'] = $this->post('building_number_and_street');
                $update_data['comp_operational_city'] = $this->post('comp_operational_city');
                $update_data['comp_operational_state'] = $this->post('comp_operational_state');
                $update_data['comp_operational_zip_code'] = $this->post('comp_operational_zip_code');
                $update_data['company_name'] = $this->post('company_name');
                $update_data['update_at'] = date('Y-m-d H:i:s');
                $this->Company_model->updateCompanyProfile($this->_payload->userid, $update_data);
                $output["status"] = 1;
                $output["message"] = "profile data updated successfully";
                $this->response($output, REST_Controller::HTTP_OK);
            }
        }



        if ($ws == "profileupdate_profilephoto") {

            $this->form_validation->set_rules("profile_photo", "profile_photo", "required");


            if ($this->form_validation->run() === false) {
                $output = array(
                    "ws" => $ws,
                    "status" => 0,
                    "message" => "invalid inputs"
                );

                $this->set_response($output, REST_Controller::HTTP_OK);
            } else {
                $this->load->library("Awsupload");
                $image_parts = $this->post('profile_photo');
                $image_base64 = base64_decode($image_parts);
                $uniqueName = $this->awsupload->getUniqueName('png');
                $file = 'uploads/images/user/' .$uniqueName;
                //file_put_contents($file, $image_base64);
                
                $s3FilePath = $this->awsupload->filePutContents($file, $image_base64, 'image');

                $update_data['profile_photo'] = $s3FilePath;
                $update_data['updated_on'] = date('Y-m-d H:i:s');
                $this->Users_model->updateUserInfo($this->_payload->userid, $update_data);
                $output["status"] = 1;
                $output["message"] = "profile data updated successfully";
                $output["profile_photo"] = $s3FilePath;
                $this->response($output, REST_Controller::HTTP_OK);
            }
        }
    }

    public function getUsersCartItemsCount($user_id) {
        $cartItemsCount = $this->Users_model->getUsersCartItemsCountData($user_id);
        return $cartItemsCount;
    }

    public function setPrimaryNeedPreference_post() {

        $ws = $this->post('ws');

        if (empty($ws)) {
            $ws = "setPrimaryNeedPreference";
        }


        $primary_need = $this->post('primary_need');

        if (empty($primary_need) && $primary_need == "") {
            $output = [
                "ws" => $ws,
                "status" => 0,
                "message" => "Unable to update data"
            ];

            $this->set_response($output, REST_Controller::HTTP_OK);
        } else {
            $output['ws'] = $ws;
            $output['status'] = 1;
            $output['message'] = "preferred primary need updated successfully";
            $this->Users_model->setPrimaryNeedData($this->_payload->userid, $primary_need);
            $this->response($output, HTTP_OK);
        }
    }

    public function setSourcingReasonsPreference_post() {

        $ws = $this->post('ws');

        if (empty($ws)) {
            $ws = "setSourcingReasonsPreference";
        }


        $preferred_sourcing_reasons_id = $this->post('preferred_sourcing_reasons_id');




        if (empty($preferred_sourcing_reasons_id) && $preferred_sourcing_reasons_id == "") {
            $output = [
                "ws" => $ws,
                "status" => 0,
                "message" => "Unable to update data"
            ];

            $this->set_response($output, REST_Controller::HTTP_OK);
        } else {

            $preferred_sourcing_reasons_id = implode(',', $preferred_sourcing_reasons_id);
            $this->Users_model->setSourcingReasonsPreferenceData($this->_payload->userid, $preferred_sourcing_reasons_id);
            $output['ws'] = $ws;
            $output['status'] = 1;
            $output['message'] = "preferred sourcing reasons updated successfully";
            $this->response($output, HTTP_OK);
        }
    }

    public function setRootCategoriesPreference_post() {

        $ws = $this->post('ws');

        if (empty($ws)) {
            $ws = "setRootCategoriesPreference";
        }


        $preferred_root_categories_id = $this->post('preferred_root_categories_id');


        if (empty($preferred_root_categories_id) && $preferred_root_categories_id == "") {
            $output = [
                "ws" => $ws,
                "status" => 0,
                "message" => "Unable to update data"
            ];

            $this->set_response($output, REST_Controller::HTTP_OK);
        } else {
            $preferred_root_categories_id = implode(',', $preferred_root_categories_id);
            $output['ws'] = $ws;
            $output['status'] = 1;
            $output['message'] = "preferred root categories updated successfully";
            $this->Users_model->setRootCategoriesPreferenceData($this->_payload->userid, $preferred_root_categories_id);
            $this->response($output, HTTP_OK);
        }
    }

    public function setSubCategoriesPreference_post() {

        $ws = $this->post('ws');

        if (empty($ws)) {
            $ws = "setSubCategoriesPreference";
        }


        $preferred_sub_categories_id = $this->post('preferred_sub_categories_id');


        if (empty($preferred_sub_categories_id) && $preferred_sub_categories_id == "") {
            $output = [
                "ws" => $ws,
                "status" => 0,
                "message" => "Unable to update data"
            ];

            $this->set_response($output, REST_Controller::HTTP_OK);
        } else {
            $preferred_sub_categories_id = implode(',', $preferred_sub_categories_id);

            $output['ws'] = $ws;
            $output['status'] = 1;
            $output['message'] = "preferred sub categories updated successfully";
            $this->Users_model->setSubCategoriesPreferenceData($this->_payload->userid, $preferred_sub_categories_id);
            $this->response($output, HTTP_OK);
        }
    }

    public function setAnnualPurchasingAmount_post() {
        $ws = $this->post('ws');

        if (empty($ws)) {
            $ws = "setAnnualPurchasingAmount";
        }


        $annual_purchasing_amount = $this->post('annual_purchasing_amount');


        if (empty($annual_purchasing_amount) && $annual_purchasing_amount == "") {
            $output = [
                "ws" => $ws,
                "status" => 0,
                "message" => "Unable to update data"
            ];

            $this->set_response($output, REST_Controller::HTTP_OK);
        } else {
            $output['ws'] = $ws;
            $output['status'] = 1;
            $output['message'] = "annual purchasing amount updated successfully";
            $this->Users_model->setAnnualPurchasingAmountData($this->_payload->userid, $annual_purchasing_amount);
            $this->response($output, HTTP_OK);
        }
    }

    public function setAnnualPurchasingFrequency_post() {
        $ws = $this->post('ws');

        if (empty($ws)) {
            $ws = "setAnnualPurchasingFrequency";
        }


        $annual_purchasing_frequency = $this->post('annual_purchasing_frequency');


        if (empty($annual_purchasing_frequency) && $annual_purchasing_frequency == "") {
            $output = [
                "ws" => $ws,
                "status" => 0,
                "message" => "Unable to update data"
            ];

            $this->set_response($output, REST_Controller::HTTP_OK);
        } else {
            $output['ws'] = $ws;
            $output['status'] = 1;
            $output['message'] = "annual purchasing frequency updated successfully";
            $this->Users_model->setAnnualPurchasingFrequencyData($this->_payload->userid, $annual_purchasing_frequency);
            $this->response($output, HTTP_OK);
        }
    }

    public function setOnlineShopWebAddress_post() {
        $ws = $this->post('ws');

        if (empty($ws)) {
            $ws = "setOnlineShopWebAddress";
        }


        $online_shop_web_address = $this->post('online_shop_web_address');


        if (empty($online_shop_web_address) && $online_shop_web_address == "") {
            $output = [
                "ws" => $ws,
                "status" => 0,
                "message" => "Unable to update data"
            ];

            $this->set_response($output, REST_Controller::HTTP_OK);
        } else {
            $output['ws'] = $ws;
            $output['status'] = 1;
            $output['message'] = "online shop web address updated successfully";
            $this->Company_model->setOnlineShopWebAddressData($this->_payload->userid, $online_shop_web_address);
            $this->response($output, HTTP_OK);
        }
    }

    public function requestEmailOtp_post() {
        $ws_temp = $this->post("ws");
        $ws = "requestEmailOtp";
        if (isset($ws_temp)) {
            $ws = $ws_temp;
        }
        $output = [
            "status" => 0,
            "message" => "Invalid Inputs",
            "ws" => $ws
        ];
        $this->form_validation->set_rules("email", "Email", "required");
        if ($this->form_validation->run() == false) {
            $this->response($output, REST_Controller::HTTP_OK);
        } else {

            $user = $this->_payload->userid;
            $email = $this->post("email");

            $data["otp"] = rand(100000, 999999);
            $insertData = [
                "email" => $email,
                "captcha" => $data["otp"]
            ];
            $this->Users_model->addEmailVerification($insertData);
            $message = $this->load->view("emailtemplates/verification_code", $data, true);

            $this->load->library('email');
            $this->email->from($this->config->item("default_email_from"), "Atzcart");
            $this->email->to($email);
            $this->email->mailtype = "html";
            $this->email->newline = "\r\n";
            $this->email->subject('Email verification');
            $this->email->message($message);
            $this->email->send();


            $output["status"] = 1;
            $output["message"] = "verification email sent successfully";
            //$output["debug"] = $this->email->print_debugger(true);
            $this->response($output, REST_Controller::HTTP_OK);
        }
    }

    public function verifyEmailOtp_post() {
        $ws_temp = $this->post("ws");
        $ws = "verifyEmailOtp";
        if (isset($ws_temp)) {
            $ws = $ws_temp;
        }
        $output = [
            "status" => 0,
            "message" => "Invalid Inputs",
            "ws" => $ws
        ];
        $this->form_validation->set_rules("email", "Email", "required");
        $this->form_validation->set_rules("otp", "Otp", "required");
        if ($this->form_validation->run() == false) {
            $this->response($output, REST_Controller::HTTP_OK);
        } else {
            $email = $this->post("email");
            $otp = $this->post("otp");
            $dbOtp = $this->Users_model->getVerficationDetailsByEmail($email);
            if ($dbOtp && $dbOtp->captcha == $otp) {
                $data = [
                    "verify_email" => 1
                ];
                $this->Users_model->updateEmailVerification($email, $data);
                $output["status"] = 1;
                $output["message"] = "Otp verified!";
                $this->response($output, REST_Controller::HTTP_OK);
            } else {
                $output["message"] = "Invalid Otp!";
                $this->response($output, REST_Controller::HTTP_OK);
            }
        }
    }

    public function addressBook_get() {

        $user = $this->_payload->userid;
        $items = $this->Users_model->getAddressBook($user);
        $output = [
            "status" => 1,
            "message" => "Address Book List",
            "ws" => "addressBook",
            "data" => $items
        ];
        $this->response($output, REST_Controller::HTTP_OK);
    }

    public function setShippingAddress_post() {
        $user = $this->_payload->userid;
        $ws_temp = $this->post("ws");
        $ws = "setShippingAddress";
        if (isset($ws_temp)) {
            $ws = $ws_temp;
        }
        $output = [
            "status" => 0,
            "message" => "Invalid Inputs",
            "ws" => $ws
        ];
        $this->form_validation->set_rules("contact_person", "Name", "required");
        $this->form_validation->set_rules("contact_number", "Contact", "required");
        $this->form_validation->set_rules("street", "street", "required");
        $this->form_validation->set_rules("postcode", "postcode", "required");
        $this->form_validation->set_rules("city", "city", "required");
        $this->form_validation->set_rules("state", "state", "required");
        $this->form_validation->set_rules("country", "country", "required");
        $this->form_validation->set_rules("is_default", "is_default", "required");
        if ($this->form_validation->run() == false) {
            $this->response($output, REST_Controller::HTTP_OK);
        } else {
            $ship_method = $this->send_data->get_shipping_method();
            if ($ship_method == 2) {

                $seller_pincode = 411057;
                $res = $this->shiprocket->serviceability($seller_pincode, $this->post("postcode"), 1, 0.5, 0.5, 0.5, 1);

                if ($res['status'] != 200) {
                    $output["status"] = 0;
                    $output["message"] = "Pincode Not Deliverable !";
                    $check_status = 0;
                } else {
                    $check_status = 1;
                }
            } elseif ($ship_method == 1) {
                //Check Valid Pincode
                $check_pincode = $this->shipping->location_finder($this->post("postcode"));

                if ($check_pincode['GetServicesforPincodeResult']['AreaCode'] != '' && $check_pincode['GetServicesforPincodeResult']['EDLDist'] == 0) {
                    $check_status = 1;
                } else {
                    $output["status"] = 0;
                    $output["message"] = "Pincode Not Deliverable !";
                    $check_status = 0;
                }
            }
            if ($check_status == 1) {
                $items = $this->Users_model->getAddressBook($user);
                $is_default = $this->post('is_default');
                if (count($items) != 0) {
                    if ($is_default != 0) {
                        $dat['is_default'] = 0;
                        $this->Common_model->update('address_book', $dat, array('user_id' => $user));
                    }
                }

                $insertData = [
                    "user_id" => $user,
                    "contact_person" => $this->post("contact_person"),
                    "contact_number" => $this->post("contact_number"),
                    "street" => $this->post("street"),
                    "suburb" => $this->post("suburb"),
                    "postcode" => $this->post("postcode"),
                    "city" => $this->post("city"),
                    "state" => $this->post("state"),
                    "country" => $this->post("country"),
                    "is_default" => $is_default,
                    "tag" => $this->post("tag"),
                ];
                $address_id = $this->Users_model->addAddressBook($insertData);
                $output["status"] = 1;
                $output["message"] = "Added new address";
                $output["address_id"] = $address_id;
            }
            $this->response($output, REST_Controller::HTTP_OK);
        }
    }

    public function updateShippingAddress_post() {
        $user = $this->_payload->userid;
        $ws_temp = $this->post("ws");
        $ws = "updateShippingAddress";
        if (isset($ws_temp)) {
            $ws = $ws_temp;
        }
        $output = [
            "status" => 0,
            "message" => "Invalid Inputs",
            "ws" => $ws
        ];
        $this->form_validation->set_rules("id", "id", "required");
        //$this->form_validation->set_rules("name","Name","required");
        $this->form_validation->set_rules("contact_person", "Name", "required");
        $this->form_validation->set_rules("contact_number", "Contact", "required");
        $this->form_validation->set_rules("street", "street", "required");
        $this->form_validation->set_rules("postcode", "postcode", "required");
        $this->form_validation->set_rules("city", "city", "required");
        $this->form_validation->set_rules("state", "state", "required");
        $this->form_validation->set_rules("country", "country", "required");
        $this->form_validation->set_rules("is_default", "is_default", "required");
        if ($this->form_validation->run() == false) {

            $this->response($output, REST_Controller::HTTP_OK);
        } else {

           $ship_method = $this->send_data->get_shipping_method();
            if ($ship_method == 2) {

                $seller_pincode = 411057;
                $res = $this->shiprocket->serviceability($seller_pincode, $this->post("postcode"), 1, 0.5, 0.5, 0.5, 1);

                if ($res['status'] != 200) {
                    $output["status"] = 0;
                    $output["message"] = "Pincode Not Deliverable !";
                    $check_status = 0;
                } else {
                    $check_status = 1;
                }
            } elseif ($ship_method == 1) {
                //Check Valid Pincode
                $check_pincode = $this->shipping->location_finder($this->post("postcode"));

                if ($check_pincode['GetServicesforPincodeResult']['AreaCode'] != '' && $check_pincode['GetServicesforPincodeResult']['EDLDist'] == 0) {
                    $check_status = 1;
                } else {
                    $output["status"] = 0;
                    $output["message"] = "Pincode Not Deliverable !";
                    $check_status = 0;
                }
            }
             if ($check_status == 1) {

                $id = $this->post("id");
                $updateData = [
                    //"contact_person" => $this->post("name"), 
                    "user_id" => $user,
                    "contact_person" => $this->post("contact_person"),
                    "contact_number" => $this->post("contact_number"),
                    "street" => $this->post("street"),
                    "postcode" => $this->post("postcode"),
                    "suburb" => $this->post("suburb"),
                    "city" => $this->post("city"),
                    "state" => $this->post("state"),
                    "country" => $this->post("country"),
                    "is_default" => $this->post("is_default"),
                    "tag" => $this->post("tag")
                ];
                $up2 = ["is_default" => 0];
                $this->Users_model->updateAddressBook($id, $updateData);
                $this->Users_model->updateAllAddressBookByUser($user, $up2, $id);
                $output["status"] = 1;
                $output["message"] = "Address Updated!";
            }
            $this->response($output, REST_Controller::HTTP_OK);
        }
    }

    public function shippingAddressDetails_post() {
        $user = $this->_payload->userid;
        $ws_temp = $this->post("ws");
        $ws = "shippingAddressDetails";
        if (isset($ws_temp)) {
            $ws = $ws_temp;
        }
        $output = [
            "status" => 0,
            "message" => "Data Not Found",
            "ws" => $ws
        ];
        $id = $this->post("id");
        $result = $this->Users_model->getShippingAddressDetails($id);
        if ($result) {
            $output["status"] = 1;
            $output["message"] = "Address fetched successfully!";
            $output["data"] = $result;
            $this->response($output, REST_Controller::HTTP_OK);
        } else {
            $this->response($output, REST_Controller::HTTP_OK);
        }
    }

    public function defaultaddress_get() {
        $user = $this->_payload->userid;
        $data = $this->Users_model->getDefaultAddressBook($user);
        //print_r($data);die;
        if (!empty($data)) {
            $output = [
                "status" => 1,
                "message" => "Default address book",
                "ws" => "defaultaddress",
                "data" => $data
            ];
        } else {
            $output = [
                "status" => 0,
                "message" => "Not found",
                "ws" => "defaultaddress",
                "data" => $data
            ];
        }
        $this->response($output, REST_Controller::HTTP_OK);
    }

    public function change_password_post() {
        $ws_temp = $this->post("ws");
        $ws = "change_password";
        if (isset($ws_temp)) {
            $ws = $ws_temp;
        }
        $output = [
            "status" => 0,
            "message" => "Invalid inputs",
            "ws" => $ws
        ];

        $this->form_validation->set_rules("current_password", "current_password", "required");
        $this->form_validation->set_rules("new_password", "new_password", "required");

        if ($this->form_validation->run() == false) {
            $this->response($output, REST_Controller::HTTP_OK);
        } else {
            $current_password = $this->post('current_password');
            $new_password = $this->post('new_password');


            $userdata = $this->Users_model->getUserById($this->_payload->userid);

            $password_hashed = $userdata->password;

            if (password_verify($current_password, $password_hashed)) {
                $new_password = password_hash($new_password, PASSWORD_DEFAULT);
                $this->Users_model->changePasswordData($new_password, $this->_payload->userid);

                $output["status"] = 1;
                $output["message"] = "Password changed successfully";

                //$this->response($output, REST_Controller::HTTP_UNAUTHORIZED);
                $this->response($output, REST_Controller::HTTP_OK);
            } else {
                $output = [
                    "status" => 0,
                    "message" => "Entered old password is wrong",
                    "ws" => $ws
                ];
                $this->response($output, REST_Controller::HTTP_OK);
            }
        }
    }

    public function social_signup_post() {
        //$user = $this->_payload->userid;
        echo "skd";
        exit;
        $ws_temp = $this->post("ws");
        $ws = "social_signup";
        if (isset($ws_temp)) {
            $ws = $ws_temp;
        }
        $output = [
            "status" => 0,
            "message" => "Data Not Found",
            "ws" => $ws
        ];

        $this->form_validation->set_rules("country_name", "country_name", "required");
        $this->form_validation->set_rules("email_id", "email_id", "required");
        $this->form_validation->set_rules("first_name", "first_name", "required");
        $this->form_validation->set_rules("last_name", "last_name", "required");
        $this->form_validation->set_rules("social_media_type", "social_media_type", "required");

        if ($this->form_validation->run() == false) {
            $this->response($output, REST_Controller::HTTP_OK);
        } else {
            $country_name = $this->input->post('country_name');
            $email_id = $this->input->post('email_id');
            $first_name = $this->input->post('first_name');
            $last_name = $this->input->post('last_name');
            $social_media_type = $this->input->post('social_media_type');

            $user_arr = $this->Common_model->select('*', 'users', ['email' => $email]);

            if (empty($user_arr)) {
                $insert_arr = array();
                $insert_arr['user_name'] = $email_id;
                $insert_arr['password'] = password_hash($this->randomPassword(), PASSWORD_DEFAULT);
                $insert_arr['first_name'] = $first_name;
                $insert_arr['last_name'] = $last_name;
                $insert_arr['email'] = $email_id;

                $user_id = $this->Common_model->insert('users', $insert_arr);

                if (!empty($user_id)) {
                    $message = 'You are registered successfully and your password is ' . $this->randomPassword();
                    $this->load->library('email');
                    $this->email->from($this->config->item("default_email_from"), "Atzcart");
                    $this->email->to($email_id);
                    $this->email->mailtype = "html";
                    $this->email->newline = "\r\n";
                    $this->email->subject('Email verification');
                    $this->email->message($message);
                    $this->email->send();
                }
            } else {
                $output["status"] = 1;
                $output["user_info"] = $user_arr[0];
            }

            $this->response($output, REST_Controller::HTTP_OK);
        }
    }

    function randomPassword() {
        $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
        $pass = array(); //remember to declare $pass as an array
        $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
        for ($i = 0; $i < 8; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }
        return implode($pass); //turn the array into a string
    }

    public function getProfileStatus() {
        $data['user'] = $this->Users_model->getUserAsSellerInfo($this->_payload->userid);
        $data['company'] = $this->Company_model->getCompanyDetailsBySeller($this->_payload->userid);

        //print_r($data);exit;
        //echo $data['company']->location_country;exit;

        $output['username'] = $data['user']->first_name . " " . $data['user']->last_name;
        $output['user_profile_photo'] = $data['user']->profile_photo;
        $output['company_name'] = $data['company']->company_name;
        $output['company_type'] = $data['user']->companyType;


        ///////////////////////////////////

        if ($data['user']->email_verified == 0) {
            $output['email_verified_status'] = 0;
        } else {
            $output['email_verified_status'] = 1;
        }

        ///////////////////////////////////
        ///////////////////////////////////

        if (empty($data['user']->annual_purchasing_amount)) {
            $output['annual_purchasing_amount_status'] = 0;
        } else {
            $output['annual_purchasing_amount_status'] = 1;
        }

        ///////////////////////////////////
        ///////////////////////////////////

        if (empty($data['user']->annual_purchasing_frequency)) {
            $output['annual_purchasing_frequency_status'] = 0;
        } else {
            $output['annual_purchasing_frequency_status'] = 1;
        }

        ///////////////////////////////////
        ///////////////////////////////////

        if (empty($data['user']->companyType)) {
            $output['business_type_status'] = 0;
        } else {
            $output['business_type_status'] = 1;
        }

        ///////////////////////////////////
        ///////////////////////////////////

        if (empty($data['company']->location_country) || empty($data['company']->building_number_and_street) || empty($data['company']->comp_operational_city) || empty($data['company']->comp_operational_state) || empty($data['company']->comp_operational_zip_code) || empty($data['company']->company_name)) {
            $output['company_address_status'] = 0;
            $output['company_name_status'] = 0;
        } else {
            $output['company_address_status'] = 1;
            $output['company_name_status'] = 1;
        }

        ///////////////////////////////////

        print_r($output);
        exit;
    }

    public function getCoupon_post() {

        $ws_temp = $this->post("ws");
        $ws = "getCoupon";
        if (isset($ws_temp)) {
            $ws = $ws_temp;
        }
        $output = [
            "status" => 0,
            "message" => "Invalid inputs",
            "ws" => $ws
        ];

        $this->form_validation->set_rules("coupon_id", "coupon", "required");
        if ($this->form_validation->run() === false) {
            $this->response($output, REST_Controller::HTTP_OK);
        } else {
            $user = $this->_payload->userid;
            $coupon_id = $this->post("coupon_id");
            $chk = $this->Coupon_model->isAlreadyExists($user, $coupon_id);
            if (!$chk) {
                $insertData = [
                    "user_id" => $user,
                    "coupon_id" => $coupon_id,
                    "status" => "GET"
                ];
                $this->Coupon_model->addUserCoupon($insertData);
                $output["status"] = 1;
                $output["message"] = "Added Successfully";
            } else {
                $output["status"] = 0;
                $output["message"] = "Coupon already added";
            }

            $this->response($output, REST_Controller::HTTP_OK);
        }
    }

    public function myCoupons_get() {
        $output = [
            "status" => 1,
            "message" => "My coupons List",
            "ws" => "myCoupons",
            "data" => []
        ];
        $user = $this->_payload->userid;
        $data["active_coupons"] = $this->Coupon_model->getUserCoupons($user, 1);
        $data["inactive_coupons"] = $this->Coupon_model->getUserCoupons($user);
        $output["data"] = $data;
        $this->response($output, REST_Controller::HTTP_OK);
    }

    public function isValidCoupon_post() {

        $ws = $this->post("ws");
        if (!$ws) {
            $ws = "isValidCoupon";
        }
        $output = [
            "status" => 0,
            "message" => "Invalid Inputs!",
            "ws" => $ws
        ];
        $this->form_validation->set_rules("coupon_id", "Coupon", "required");
        $this->form_validation->set_rules("product_id", "Product", "required");
        if ($this->form_validation->run() === false) {
            $this->response($output, REST_Controller::HTTP_OK);
        } else {
            $coupon_id = $this->post("coupon_id");
            $product_id = $this->post("product_id");
            $user = $this->_payload->userid;
            $data = $this->Coupon_model->isCouponAvailableForUser($coupon_id, $product_id, $user);
            if ($data) {
                $output["status"] = 1;
                $output["message"] = "Valid coupon";
            } else {
                $output["status"] = 0;
                $output["message"] = "Invalid Coupon";
            }
            $this->response($output, REST_Controller::HTTP_OK);
        }
    }

    /*     * *
     * @desc to check is the product and respective seller is allready
     * present in favorioutes list of buyer
     * Type:Post
     * 
     */

    public function checkFavourites_post() {

        $ws = $this->post("ws");
        if (!$ws) {
            $ws = "checkFavorioutes";
        }
        $user_id = $this->_payload->userid;
        $is_favourite_product = false;
        $is_favourite_seller = false;
        $product = $this->post("product_id");
        $seller = $this->Product_model->getSellerIdByProduct($product);
        $fav = $this->Myfavourite_model->getUsersFaveriotes($user_id);

        if ($fav) {
            $products = json_decode($fav->products);
            //echo "<pre>";
            //print_r($products);
            //exit;
            $sellers = json_decode($fav->suppliers);
            if (in_array($product, $products)) {
                //echo "check";
                $is_favourite_product = true;
            }
            if (in_array($seller, $sellers)) {
                $is_favourite_seller = true;
            }
        }
        //$product = $this->post("product");
        $output = [
            "status" => 1,
            "message" => "Check favourites",
            "ws" => $ws,
            "is_favourite_product" => $is_favourite_product,
            "is_favourite_seller" => $is_favourite_seller,
        ];
        $this->response($output, REST_Controller::HTTP_OK);
    }

    // Develoer : Shailesh; Use : Get User Wallet Balance; Date:03/06/2019

    public function getUserWalletBalanceWithHistory_post() {
        $ws = $this->post("ws");
        $output = array();
        if (!$ws) {
            $ws = "getUserWalletBalanceWithHistory";
        }
        $user_id = $this->_payload->userid;
        $check_user = $this->Profile_model->check_user_exits($user_id);
        if ($check_user) {
            $balance = $this->Profile_model->user_wallet_balance($user_id);
            $output['status'] = 1;
            $output['message'] = 'User Wallet Balance';
            $output['balance'] = $balance;
            $output['history'] = $this->Profile_model->user_wallet_history($user_id);
        } else {
            $output['status'] = 0;
            $output['message'] = 'User Not Exists';
        }
        $output["ws"] = $ws;
        $this->response($output, REST_Controller::HTTP_OK);
    }

    public function getUserWalletBalance_post() {
        $ws = $this->post("ws");
        $output = array();
        if (!$ws) {
            $ws = "getUserWalletBalance";
        }
        $user_id = $this->_payload->userid;
        $check_user = $this->Profile_model->check_user_exits($user_id);
        if ($check_user) {
            $balance = $this->Profile_model->user_wallet_balance($user_id);
            $output['status'] = 1;
            $output['message'] = 'User Wallet Balance';
            $output['balance'] = $balance;
        } else {
            $output['status'] = 0;
            $output['message'] = 'User Not Exists';
        }
        $output["ws"] = $ws;
        $this->response($output, REST_Controller::HTTP_OK);
    }

    public function getBankDetails_get() {
        $ws = $this->post("ws");
        $output = array();
        if (!$ws) {
            $ws = "getBankDetails";
        }
        $user_id = $this->_payload->userid;
        $check_user = $this->Profile_model->check_user_exits($user_id);
        if ($check_user) {

            $output['status'] = 1;
            $output['message'] = 'User Bank Details';
            $output['data'] = $this->Common_model->getAll('buyer_bank_details', array('user_id' => $user_id))->result_array();
        } else {
            $output['status'] = 0;
            $output['message'] = 'User Not Exists';
        }
        $output["ws"] = $ws;
        $this->response($output, REST_Controller::HTTP_OK);
    }

    public function addBankDetails_post() {
        $ws = $this->post("ws");
        if (!$ws) {
            $ws = "addBankDetails";
        }
        $output = [
            "status" => 0,
            "message" => "Invalid Inputs!",
            "ws" => $ws
        ];
        $this->form_validation->set_rules("acc_no", "Account Number", "required|numeric");
        $this->form_validation->set_rules("bank_name", "Bank Name", "required");
        $this->form_validation->set_rules("ifsc_code", "IFSC Code", "trim|required");
        $this->form_validation->set_rules("acc_holder_name", "Account Holder Name", "required");
        if ($this->form_validation->run() === false) {
            $this->response($output, REST_Controller::HTTP_OK);
        } else {
            $user = $this->_payload->userid;
            $insertData = [
                "user_id" => $user,
                "acc_no" => $this->input->post("acc_no"),
                "bank_name" => $this->input->post("bank_name"),
                "ifsc_code" => $this->input->post("ifsc_code"),
                "acc_holder_name" => $this->input->post("acc_holder_name"),
                "updated_at" => date('Y-m-d H:i:s'),
            ];
            $ch_bank = $this->Common_model->getAll('buyer_bank_details', array('user_id' => $user))->num_rows();
            if ($ch_bank == 0) {
                $data = $this->Common_model->insert('buyer_bank_details', $insertData);
            } else {
                $data = $this->Common_model->update('buyer_bank_details', $insertData, array('user_id' => $user));
            }
            if ($data) {
                $output["status"] = 1;
                $output["message"] = "Success";
                $output['data'] = $this->Common_model->getAll('buyer_bank_details', array('user_id' => $user))->result_array();
            } else {
                $output["status"] = 0;
                $output["message"] = "Invalid Data";
            }
            $this->response($output, REST_Controller::HTTP_OK);
        }
    }

    public function addWithdrawRequest_post() {
        $ws = $this->post("ws");
        if (!$ws) {
            $ws = "addWithdrawRequest";
        }
        $output = [
            "status" => 0,
            "message" => "Invalid Inputs!",
            "ws" => $ws
        ];
        $this->form_validation->set_rules("req_amt", "Request Amount", "required|numeric");

        if ($this->form_validation->run() === false) {
            $this->response($output, REST_Controller::HTTP_OK);
        } else {
            $user_id = $this->_payload->userid;
            $req_amount = $this->input->post('req_amt');
            $bal = $this->Common_model->getAll('buyer_wallet', array('user_id' => $user_id))->row();
            $ch_bank = $this->Common_model->getAll('buyer_bank_details', array('user_id' => $user_id))->num_rows();
            if ($ch_bank > 0) {
                if ($req_amount <= $bal && $bal > 0 && $req_amount > 0) {
                    $ch_pending = $this->Common_model->getAll('buyer_withdraw_request', array('user_id' => $user_id, 'status' => 'Pending'))->num_rows();
                    if ($ch_pending == 0) {
                        $dat['user_id'] = $user_id;
                        $dat['amount'] = $req_amount;
                        $dat['status'] = 'Pending';
                        $dat['created_at'] = date('Y-m-d');
                        $dat['updated_at'] = date('Y-m-d');
                        $this->Common_model->insert('buyer_withdraw_request', $dat);
                        $this->request_notify();
                        $output["status"] = 1;
                        $output["message"] = "Withdraw Request Sent Successfully !";
                    } else {

                        $output["status"] = 0;
                        $output["message"] = "Already Your Withdraw Request in Pending !";
                    }
                } else {
                    $output["status"] = 0;
                    $output["message"] = "Not Sufficent Amount to Withdraw !";
                }
            } else {
                $output["status"] = 0;
                $output["message"] = "Please Add Bank Detail !";
            }

            $this->response($output, REST_Controller::HTTP_OK);
        }
    }

    function request_notify() {
        $msg = 'New Withdraw Request from Buyer !';
        $tag = date('d M Y');
        $this->browser_notification->notifyadmin('Withdraw Request', $msg, $tag);
    }

    public function deleteShipaddress_post() {
        $ws = $this->post("ws");
        if (!$ws) {
            $ws = "deleteShipaddress";
        }
        $output = [
            "status" => 0,
            "message" => "Invalid Inputs!",
            "ws" => $ws
        ];
        $this->form_validation->set_rules("ship_id", "Ship Address", "required|numeric");

        if ($this->form_validation->run() === false) {
            $this->response($output, REST_Controller::HTTP_OK);
        } else {
            $user_id = $this->_payload->userid;
            $ship_id = $this->input->post('ship_id');
            $ch = $this->Common_model->getAll('address_book', array('address_book_id' => $ship_id))->row();
            if ($ch) {
                $this->db->delete('address_book', array('address_book_id' => $ship_id));
                $output["status"] = 1;
                $output["message"] = "Delete Successfully !";
            } else {
                $output["status"] = 0;
                $output["message"] = "No Record Found !";
            }

            $this->response($output, REST_Controller::HTTP_OK);
        }
    }

    function get_notification_post() {
        $ws = $this->post("ws");
        $output = array();
        if (!$ws) {
            $ws = "get_notification";
        }
        $user_id = $this->_payload->userid;
        $noti_date = $this->input->post('noti_date');
        $check_user = $this->Profile_model->check_user_exits($user_id);
        if ($check_user) {

            $output['status'] = 1;
            $output['message'] = 'Notification';
            $output['data'] = $this->Profile_model->buyer_notification($user_id, $noti_date);
        } else {
            $output['status'] = 0;
            $output['message'] = 'User Not Exists';
        }
        $output["ws"] = $ws;
        $this->response($output, REST_Controller::HTTP_OK);
    }

    function read_notification_post() {
        $ws = $this->post("ws");
        $output = array();
        if (!$ws) {
            $ws = "read_notification";
        }
        $user_id = $this->_payload->userid;
        $noti_id = $this->input->post('noti_id');
        $check_user = $this->Profile_model->check_user_exits($user_id);
        if ($check_user) {
            $dat['status'] = 'Read';
            $up = $this->Common_model->update('buyer_notification', $dat, array('user_id' => $user_id, "id" => $noti_id));
            if ($up) {
                $output['status'] = 1;
                $output['message'] = 'Status Updated';
                // $output['data'] =$this->Profile_model->buyer_notification($user_id,$noti_date);
            } else {
                $output['status'] = 1;
                $output['message'] = 'Already Updated';
            }
        } else {
            $output['status'] = 0;
            $output['message'] = 'User Not Exists';
        }
        $output["ws"] = $ws;
        $this->response($output, REST_Controller::HTTP_OK);
    }

}
