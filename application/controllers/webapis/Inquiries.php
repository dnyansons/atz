<?php

defined('BASEPATH') OR exit('No direct script access allowed');

use Firebase\JWT\JWT;

class Inquiries extends REST_Controller {

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
        $this->load->model('Users_model');
        $this->load->model('Company_model');
        $this->load->model('Inquiries_model');
        $this->load->model('Rfqs_model');
        $this->load->model('Common_model');
        $this->load->library('upload');
        $this->load->library('awsupload');
    }

    public function rfqlist_get() {
        $user = $this->_payload->userid;
        $items = $this->Rfqs_model->getRfqByUser($user);
        $output = [
            "ws" => "rfqlist",
            "status" => 1,
            "message" => "Rfq list",
            "data" => $items
        ];
        $this->response($output, REST_Controller::HTTP_OK);
    }

    public function rfqdetails_post() {
        $ws_temp = $this->post("ws");
        $ws = "rfqdetails";
        if (isset($ws_temp)) {
            $ws = $ws_temp;
        }
        $output = [
            "status" => 0,
            "message" => "Invalid Inputs",
            "ws" => $ws
        ];
        $this->form_validation->set_rules("id", "id", "required");
        if ($this->form_validation->run() == false) {
            $this->response($output, REST_Controller::HTTP_OK);
        } else {
            $user = $this->_payload->userid;
            $id = $this->post("id");
            $data = $this->Rfqs_model->getRfqById($id);
            $output["status"] = $data;
            $output["data"] = $data;
            $this->response($output, REST_Controller::HTTP_OK);
        }
    }

    public function addnewrfq_post() {
        $ws_temp = $this->post("ws");
        $ws = "addnewrfq";
        if (isset($ws_temp)) {
            $ws = $ws_temp;
        }
        $output = [
            "status" => 0,
            "message" => "Invalid Inputs",
            "ws" => $ws
        ];
        $this->form_validation->set_rules("looking_for", "Product", "required");
        $this->form_validation->set_rules("quanity", "Quantity", "required");
        $this->form_validation->set_rules("unit", "Unit", "required");
        $this->form_validation->set_rules("description", "Description", "required");
        if ($this->form_validation->run() == false) {
            $this->response($output, REST_Controller::HTTP_OK);
        } else {
            $user = $this->_payload->userid;
            $image_parts = $this->post('uploadFile');

            $arr = array();
            if ($image_parts != "") {
                $file_array = array();
                for ($i = 0; $i < count($image_parts); $i++) {
                    $image_base64 = base64_decode($image_parts[$i]);
                    $uniqueName = $this->awsupload->getUniqueName('png');
                    $file = 'uploads/images/rfqs/' . $uniqueName;
                    $s3FilePath = $this->awsupload->filePutContents($file, $image_base64, 'image');
                    //file_put_contents($file, $image_base64);
                    $file_array[$i] = $s3FilePath;
                }
                $arr['attachments'] = json_encode($file_array);
            } else {
                $arr['attachments'] = '';
            }

            $todays_date = date("Y-m-d H:i:s");
            $arr['customer_id'] = $user;
            $arr['looking_for'] = $this->post("looking_for");
            $arr['quanity'] = $this->post("quanity");
            $arr['unit'] = $this->post("unit");
            $arr['description'] = $this->post("description");
            $arr['status'] = "Pending";
            $arr['added_date'] = $todays_date;
            $arr['updated_date'] = $todays_date;
            $arr['expiry_date'] = date('Y-m-d', strtotime("+30 days"));

            $arr['agree_share_contact'] = $this->post("agree_share_contact");
            $arr['agree_terms_and_conditions'] = $this->post("agree_terms_and_conditions");

            $data = $this->Rfqs_model->addRfq($arr);
            if ($data) {
                $this->rfq_notify();
                $output["status"] = 1;
                $output["message"] = "Request submitted successfully";
                $this->response($output, REST_Controller::HTTP_OK);
            }
            $this->response($output, REST_Controller::HTTP_OK);
        }
    }

    public function editrfq_post() {
        $ws_temp = $this->post("ws");
        $ws = "editrfq";
        if (isset($ws_temp)) {
            $ws = $ws_temp;
        }
        $output = [
            "status" => 0,
            "message" => "Invalid Inputs",
            "ws" => $ws
        ];

        $this->form_validation->set_rules("rfq_id", "RFQ ID", "required");
        $this->form_validation->set_rules("looking_for", "Product", "required");
        $this->form_validation->set_rules("quanity", "Quantity", "required");
        $this->form_validation->set_rules("unit", "Unit", "required");
        $this->form_validation->set_rules("description", "Description", "required");
        if ($this->form_validation->run() == false) {
            $this->response($output, REST_Controller::HTTP_OK);
        } else {
            $user = $this->_payload->userid;
            $id = $this->post('rfq_id');
            $image_parts = $this->post('uploadFile');
            $old_files = $this->post('old_files');


            $arr = array();
            $file_array = array();
            if ($image_parts != "") {
                for ($i = 0; $i < count($image_parts); $i++) {
                    $image_base64 = base64_decode($image_parts[$i]);
                    $uniqueName = $this->awsupload->getUniqueName('png');
                    $file = 'uploads/images/rfqs/' . $uniqueName;
                    $s3FilePath = $this->awsupload->filePutContents($file, $image_base64, 'image');
                    $file_array[$i] = $s3FilePath;
                }
            }

            if ($old_files != '') {
                if ($file_array != '') {
                    $merged_array = array_merge($old_files, $file_array);
                    $arr['attachments'] = json_encode($merged_array);
                } else {
                    $arr['attachments'] = json_encode($old_files);
                }
            } else {
                $arr['attachments'] = '';
            }

            $todays_date = date("Y-m-d H:i:s");
            $arr['customer_id'] = $user;
            $arr['looking_for'] = $this->post("looking_for");
            $arr['quanity'] = $this->post("quanity");
            $arr['unit'] = $this->post("unit");
            $arr['description'] = $this->post("description");
            $arr['added_date'] = $this->post("added_date");
            $arr['updated_date'] = $todays_date;
            $arr['expiry_date'] = date('Y-m-d', strtotime("+30 days"));

            $arr['agree_share_contact'] = $this->post("agree_share_contact");
            $arr['agree_terms_and_conditions'] = $this->post("agree_terms_and_conditions");

            $data = $this->Rfqs_model->editRfq($arr, $id);
            if ($data) {
                $output["status"] = 1;
                $output["message"] = "Request updated successfully";
                $this->response($output, REST_Controller::HTTP_OK);
            }

            $this->response($output, REST_Controller::HTTP_OK);
        }
    }

    public function rfqSellerReply_post() {
        $rfq_id = $this->post('rfq_id');
        $items = $this->Rfqs_model->getSupplierRepliesForRfq($rfq_id);

        if ($items) {
            $output = [
                "ws" => "rfqSellerReply",
                "status" => 1,
                "message" => "Suppliers Reply",
                "data" => $items
            ];
        } else {
            $output = [
                "ws" => "rfqSellerReply",
                "status" => 1,
                "message" => "Data Not Found",
                "data" => []
            ];
        }
        $this->response($output, REST_Controller::HTTP_OK);
    }

    public function addinquiry_post() {
        $ws_temp = $this->post("ws");
        $ws = "addinquiry";
        if (isset($ws_temp)) {
            $ws = $ws_temp;
        }
        $output = [
            "status" => 0,
            "message" => "Invalid Inputs",
            "ws" => $ws
        ];
        $this->form_validation->set_rules("quantity", "Quantity", "required");
        $this->form_validation->set_rules("unit", "Unit", "required");
        $this->form_validation->set_rules("comment", "Comment", "required");
        if ($this->form_validation->run() == false) {
            $this->response($output, REST_Controller::HTTP_OK);
        } else {
            $user = $this->_payload->userid;
            $image_parts = $this->post('uploadFile');
            $arr = array();
            if ($image_parts != "") {
                $file_array = array();
                for ($i = 0; $i < count($image_parts); $i++) {
                    $image_base64 = base64_decode($image_parts[$i]);
                    $uniqueName = $this->awsupload->getUniqueName('png');
                    $file = 'uploads/inquiries_attachment/' . $uniqueName;
                    //file_put_contents($file, $image_base64);
                    $s3FilePath = $this->awsupload->filePutContents($file, $image_base64, 'image');
                    $file_array[$i] = $s3FilePath;
                }
                $arr['attachments_by_buyer'] = json_encode($file_array);
            } else {
                $arr['attachments_by_buyer'] = '';
            }

            $todays_date = date("Y-m-d H:i:s");
            $arr['by_user'] = $user;
            $arr['for_product'] = $this->post("product_id");
            $arr['quantity'] = $this->post("quantity");
            $arr['unit'] = $this->post("unit");
            $arr['comment'] = $this->post("comment");
            $arr['status'] = "Pending";
            $arr['added_date'] = $todays_date;

            $arr['follow_supplier'] = $this->post("follow_supplier");
            $arr['recommend_other_supplier'] = $this->post("recommend_other_supplier");
            $arr['agree_share_contact'] = $this->post("agree_share_contact");

            $seller_id = $this->post("seller_id");

            if (!empty($arr['follow_supplier']) && $arr['follow_supplier'] == true) {
                $get_exist = $this->Common_model->getAll('buyer_favourites', array('user_id' => $this->_payload->userid))->row_array();
                $exist_supp = json_decode($get_exist['suppliers']);


                if (in_array($seller_id, $exist_supp)) {
                    //$output["follow_message"] = "Already Added In Favourite !";
                } else {
                    array_push($exist_supp, $seller_id);
                    $insertdata['suppliers'] = json_encode($exist_supp, JSON_NUMERIC_CHECK);
                    $this->Common_model->update("buyer_favourites", $insertdata, array('user_id' => $this->_payload->userid));
                    //$output["follow_message"] = "Favourite Supplier Add successfully !";    
                }
            }

            $data = $this->Inquiries_model->addEnquiry($arr);

            $this->enquiry_notify($seller_id);

            if ($data) {
                $output["status"] = 1;
                $output["message"] = "Inquiry submitted successfully";


                $this->response($output, REST_Controller::HTTP_OK);
            }
            $this->response($output, REST_Controller::HTTP_OK);
        }
    }

    public function inquiryList_get() {

        $user = $this->_payload->userid;
        $items = $this->Inquiries_model->getInquiryByUser($user);
        for ($i = 0; $i < count($items); $i++) {
            $result = $this->Inquiries_model->getProductPrices($items[$i]->product_id);
            $items[$i]->price = $result;
            $items[$i]->country_flag = base_url() . "assets/images/flags/png/" . strtolower($items[$i]->iso) . ".png";
        }

        $output = [
            "ws" => profile,
            "status" => 1,
            "message" => "Inquiry list",
            "data" => $items
        ];
        $this->response($output, REST_Controller::HTTP_OK);
    }

    public function InquirySellerReply_post() {
        $inquiry_id = $this->post('inquiry_id');
        $items = $this->Inquiries_model->getSupplierRepliesForInquiries($inquiry_id);

        if ($items) {
            $output = [
                "ws" => "InquirySellerReply",
                "status" => 1,
                "message" => "Suppliers Reply",
                "data" => $items
            ];
        } else {
            $output = [
                "ws" => "InquirySellerReply",
                "status" => 1,
                "message" => "Data Not Found",
                "data" => []
            ];
        }
        $this->response($output, REST_Controller::HTTP_OK);
    }

    public function updateInquiriesReadStatus_post() {
        $ws = $this->post("ws");

        if (empty($ws)) {
            $ws = "updateInquiriesReadStatus";
        }

        $inquiry_id = $this->post('inquiry_id');
        $status = $this->Inquiries_model->updateInquiriesReadStatusData($inquiry_id);

        if ($status) {
            $output = [
                "ws" => $ws,
                "status" => 1,
                "message" => "Inquiries Read Status updated successfully",
            ];
        } else {
            $output = [
                "ws" => $ws,
                "status" => 0,
                "message" => "Data Not Updated",
            ];
        }
        $this->response($output, REST_Controller::HTTP_OK);
    }

    public function userNotificationList_get() {

        //$user_id = $this->input->post('user_id');
        $notification_list = $this->Inquiries_model->getUserNoticationList($user_id);


        $output = [
            "ws" => 'userNotificationList',
            "status" => 1,
            "message" => "Notification list",
            "data" => $notification_list
        ];
        $this->response($output, REST_Controller::HTTP_OK);
    }

    function push_notification_android_get() {
        $device_id = "flLJU7ILw-w:APA91bGA6Bp7Np-T3umxH4KNXHZSa8A92kqFqfpf3QV8-aCuVeUL2GDmTxhkXQcTlfcipOjAK5u1E2xI4mn7asMdiahwJ1M9azDWWdWfXK02u9dXS-mSOjZ-RCXNh8ZbVjVDThl7e4eA";
        $message = "Check kr";
        //API URL of FCM
        $url = 'https://fcm.googleapis.com/fcm/send';

        /* api_key available in:
          Firebase Console -> Project Settings -> CLOUD MESSAGING -> Server key */ $api_key = 'AAAAQZPhbOI:APA91bE66fLevVa21qhnG0Wg6pAcUtDCk4CnUDxTDMHCwdDnn1WoHHnkn7oxPOjfG8yZb8H08VwbM6X6VWZoJ7JrP4kZki-Ke8Z5ZipqEhFwq8YviFuOrycxNERMdpNlUOE4NaV4i_j1';

        $fields = array(
            'registration_ids' => array(
                $device_id
            ),
            'data' => array(
                "message" => $message,
                "title" => "he title ahe",
                "body" => "hi body aahe",
                "type" => ""
            )
        );

        //header includes Content type and api key
        $headers = array(
            'Content-Type:application/json',
            'Authorization:key=' . $api_key
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        $result = curl_exec($ch);
        if ($result === FALSE) {
            die('FCM Send Error: ' . curl_error($ch));
        }
        curl_close($ch);
        $this->response($result, REST_Controller::HTTP_OK);
    }

    function rfq_notify() {

        $this->load->library("Browser_notification");
        $msg = 'New RFQ added !';
        $tag = 'atzart.com';
        $this->browser_notification->notifyadmin('New RFQ !', $msg, $tag);
    }

    function enquiry_notify($seller_id) {

        $this->load->library("Browser_notification");
        $title = 'Product Inquiry';
        $msg = 'You have new Product Enquiry !';
        $tag = 'atzart.com';
        if (!empty($seller_id)) {
            $this->browser_notification->notifyseller($seller_id, $title, $msg, $tag);
        }
    }

}
