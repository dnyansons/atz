<?php

defined('BASEPATH') OR exit("Direct access denied");

class Inquiries extends CI_Controller {

    public function __construct() {
        parent::__construct();
        if (!$this->session->userdata("user_logged_in") || $this->session->userdata("user_role") != "seller") {
            $error = "<div id='login-error' class='form-error notice notice-error'><span class='icon-notice icon-error'></span><span><strong>Error!</strong> Session timeout, relogin!. </span></div>";
            $this->session->set_flashdata("message", $error);
            redirect("login", "refresh");
        }
        $this->load->model("Inquiries_model");
        $this->load->model("Rfqs_model");
        $this->load->model("Users_model");
        $this->load->library('awsupload');
    }

    public function index() {
        $data["pageTitle"] = "Inquiries";
        $this->load->view("user/inquiries/list", $data);
    }

    public function ajax_list() {
        $user_id = $this->session->userdata('user_id');
        $inquiries = $this->Inquiries_model->get_datatables_for_user($user_id);
        $data = array();
        $no = $this->input->post('start');
        $sr_no = 1;
        foreach ($inquiries as $enquiry) {

            $no++;
            $replydata = $this->Inquiries_model->getReplydata($enquiry->id);

            if (isset($replydata) && $replydata != "") {
                $replied = "yes";
                $reply_attachment = $replydata->attachments;
            } else {
                $replied = "no";
            }

            if ($enquiry->attachments_by_buyer != '') {

                // $attachment = '<a href="Inquiries/download_file/' . urlencode($enquiry->attachments_by_buyer) . '">Download</a>';
                $attachment = '<a href="Inquiries/view_file/' . $enquiry->id . '">View</a>';
            } else {
                $attachment = "No Attachment";
            }
            $row = array();
            $row[] = $sr_no;
            $row[] = $enquiry->first_name . ' ' . $enquiry->last_name;
            $row[] = $enquiry->products_name;
            $row[] = $enquiry->quantity . " (" . $enquiry->units_name . ")";
            $row[] = '<p title="' . $enquiry->comment . '">' . substr($enquiry->comment, 0, 30) . '..</p>';
            $row[] = $attachment;
            $row[] = '<button type="button" class="btn btn-primary waves-effect waves-light " id="button" data-toggle="modal" data-target="#inquiry_modal" data-inquiryid="' . $enquiry->id . '" data-replied="' . $replied . '" data-comment="' . $replydata->comment . '" data-replytype="' . $replydata->reply_type . '" data-price="' . $replydata->price . '" data-attachment="' . $reply_attachment . '"><i class="fa fa-eye"></i></button>';

            if ($replied == "yes") {
                $row[6] .= '&nbsp;&nbsp;<span style="color:green;"><i class="fa fa-check"></i>Replied</span>';
            } else {
                $row[6] .= '';
            }
            $data[] = $row;
            $sr_no++;
        }

        $output = array(
            "draw" => $this->input->post('draw'),
            "recordsTotal" => $this->Inquiries_model->count_all(),
            "recordsFiltered" => $this->Inquiries_model->count_filtered_for_user($user_id),
            "data" => $data,
        );
        echo json_encode($output);
    }

    public function inquiries_reply() {

        $seller_id = $this->session->userdata('user_id');

        if ($_FILES['file']['name'] != '' || !empty($_FILES['file']['name'])) {
            $s3FilePath = $this->awsupload->upload('file', 'uploads/inquiries_attachment','document');
            if ($s3FilePath == false) {
                     $data = ["error" => "error"];
                     echo json_encode($data);
                     exit;
            } else {
                $arr["attachments"] = json_encode($s3FilePath);
            }
        } else {
            $arr['attachments'] = '';
        }

        $todays_date = date('Y-m-d H:i:s');
        $arr['inquiry_id'] = $this->input->post('inquiry_id');
        $arr['seller_id'] = $seller_id;
        $arr['comment'] = htmlentities($this->input->post('comment'));
        $arr['reply_type'] = htmlentities($this->input->post('reply_type'));
        $arr['price'] = htmlentities($this->input->post('price'));
        $arr['added_date'] = $todays_date;
        $arr['status'] = "Approved";
        $result = $this->Inquiries_model->add_inquiry_reply($arr);
        $result = TRUE;

        if ($result) {
            $inquiry_id = $this->input->post('inquiry_id');
            $resultStatus = $this->Inquiries_model->updateinquiryStatus($inquiry_id);
            $by_user = $this->Inquiries_model->get_inquiry_user($inquiry_id);

            $user_firebase_id_arr = $this->Inquiries_model->get_user_firebase_id($by_user);

            $title = 'ATZ Inquiry Replay';
            $message_body['msg'] = 'Seller Replied to your enquiry';
            $message_body['inquiry_id'] = $inquiry_id;
            $notification_type = 'Inquiry';
            $reference_id = $inquiry_id;

            $this->inquiry_notify($by_user, $inquiry_id);

            $output = ["status" => 1, "message" => "success"];
            echo json_encode($output);
        }
    }

    function view_file($enq_id) {
        $q = $this->Common_model->getAll('inquiries', array('id' => $enq_id))->row();
        $files = json_decode($q->attachments_by_buyer, true);
        $data['files'] = $files;
        $this->load->view('user/inquiries/view_file', $data);
    }


    function myenquiry_list() {
        $data["Title"] = "My Inquiries";
        $this->load->view("user/inquiries/buyer_enquiry_list", $data);
    }

    function buyer_ajax_enquires_list() {
        $user_id = $this->session->userdata("user_id");

        $columns = array(
            0 => 'id',
            1 => 'comment',
            2 => 'for_product',
            3 => 'quantity',
            4 => 'is_forwarded',
            5 => 'added_date',
        );

        $limit = $this->input->post('length');
        $start = $this->input->post('start');
        $order = $columns[$this->input->post('order')[0]['column']];
        $dir = $this->input->post('order')[0]['dir'];

        $totalData = $this->Inquiries_model->allenq_count($user_id);


        $totalFiltered = $totalData;

        if (empty($this->input->post('search')['value'])) {
            $enquiry = $this->Inquiries_model->allbuyerenquiries($user_id, $limit, $start, $order, $dir);
        } else {
            $search = $this->input->post('search')['value'];

            $enquiry = $this->Inquiries_model->buyer_enquires_search($user_id, $limit, $start, $search, $order, $dir);
            //echo $this->db->last_query();

            $totalFiltered = $this->Inquiries_model->buye_renquiries_search_count($user_id, $search);
        }

        $data = array();
        if (!empty($enquiry)) {
            foreach ($enquiry as $se) {

                if ($se->is_forwarded == 0) {
                    $for = 'No';
                } else {
                    $for = 'Yes';
                }
                $nestedData['id'] = $se->id;
                $nestedData['comment'] = $se->comment;
                $nestedData['for_product'] = $se->name;
                $nestedData['quantity'] = $se->quantity . ' / ' . $se->units_name;
                $nestedData['is_forwarded'] = $for;
                $nestedData['created_on'] = date('d-m-Y H:i:s', strtotime($se->added_date));
                $nestedData['action'] = "<a class='btn btn-link' href='" . base_url() . "product-details/" . $se->name . "/" . $se->for_product . "'>Place Order</a>";
                $data[] = $nestedData;
            }
        }

        $json_data = array(
            "draw" => intval($this->input->post('draw')),
            "recordsTotal" => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data" => $data
        );

        echo json_encode($json_data);
    }


    function inquiry_notify($user_id, $inquiry_id) {

        $this->load->library("Browser_notification");

        if (!empty($user_id)) {
            //get Firebse_id
            $buyer_firbase = $this->Users_model->get_firbase_id($user_id);
            //To Buyer
            $msg = 'Replied to Inquiry From Seller !';
            if (!empty($buyer_firbase)) {
                $type = "Inquiry";
                $type_id = $inquiry_id;
                $this->browser_notification->notify_buyer('Replied From Seller!', $msg, $buyer_firbase, $type, $type_id = '');
            }
        }

        $msg = 'Replied to Inquiry #' . $inquiry_id . '  From Seller !';
        $tag = 'atzart.com';
        $this->browser_notification->notifyadmin('Replied From Seller!', $msg, $tag);
    }

}
