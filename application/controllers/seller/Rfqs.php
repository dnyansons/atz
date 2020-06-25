<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Rfqs extends CI_Controller {

    public function __construct() {
        parent::__construct();
        if (!$this->session->userdata("user_logged_in") || $this->session->userdata("user_role") != "seller") {
            $error = "<div id='login-error' class='form-error notice notice-error'><span class='icon-notice icon-error'></span><span><strong>Error!</strong> Session timeout, relogin!. </span></div>";
            $this->session->set_flashdata("message", $error);
            redirect("login", "refresh");
        }
        $this->load->model('Rfqs_model');
        $this->load->model('Inquiries_model');
        $this->load->model('Users_model');
        $this->load->library("form_validation");
        $this->load->library("email");
        $this->load->library('awsupload');
        $this->load->helper("file");
    }

    public function index() {
        $supplier = $this->session->userdata("user_id");
        $data["pageTitle"] = "User || rfqs";
        $data["rfqs"] = $this->Rfqs_model->getRfqsBySupplier($supplier);
        $this->load->view("user/rfqs/list", $data);
    }

    public function reply($id = 0, $rfq_id) {
        if ($id == 0) {
            $error = "<div class='alert alert-danger alert-dismissible'>
				<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
				<strong>Error!</strong> Please select valid rfq.
				</div>";
            $this->session->set_flashdata("message", $error);
            redirect("seller/rfqs", "refresh");
        }
        $this->load->library("form_validation");
        $this->form_validation->set_rules("quantity", "Quantity", "required");
        $this->form_validation->set_rules("unit", "Unit", "required");
        $this->form_validation->set_rules("price", "Price", "required");
        $this->form_validation->set_rules("comment", "Comment", "required");
        if (empty($_FILES['quote_attachment']['name'])) {
            $this->form_validation->set_rules('quote_attachment', 'Quotation Document', 'required');
        }
        if ($this->form_validation->run() === false) {
            $data["id"] = $id;
            $data["rfqid"] = $rfq_id;
            $data["pageTitle"] = "User || Reply to rfq";
            $data['units'] = $this->Rfqs_model->get_units();
            $this->load->view("user/rfqs/reply", $data);
        } else {

            if ($_FILES['quote_attachment']['name'] != '' || !empty($_FILES['quote_attachment']['name'])) {
                    $s3FilePath = $this->awsupload->upload('quote_attachment', 'uploads/images/rfqs','document');
                    if ($s3FilePath == false) {
                        $error = "<div class='alert alert-danger alert-dismissible'>
                                <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                                <strong>Error!</strong> File type not allowed.!
                                </div>";
                        $this->session->set_flashdata("message", $error);
                        redirect("seller/rfqs", "refresh");
                    } else {
                        $updateData["attachment"] = $s3FilePath;
                    }
            } else {
                $updateData["attachment"] = '';
            }

            $todays_date = date('Y-m-d H:i:s');
            $updateData["quantity"] = htmlentities($this->input->post("quantity"));
            $updateData["unit"] = htmlentities($this->input->post("unit"));
            $updateData["price"] = htmlentities($this->input->post("price"));
            $updateData["reply"] = 1;
            $updateData["status"] = "Approved";
            $updateData["comment"] = htmlentities($this->input->post("comment"));
            $updateData["added_date"] = $todays_date;

            $this->Rfqs_model->addReplyToRfq($id, $updateData);
            $this->Rfqs_model->updateRfq_approve($rfq_id);

            $this->rfq_notify($rfq_id);


            $success = "<div class='alert alert-success alert-dismissible'>
					<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
					<strong>Success!</strong> Reply submitted succesfully.
					</div>";

            /*$rfq_rec = $this->Rfqs_model->getRfqById($rfq_id);
            $customer_id = $rfq_rec->customer_id;

            $rfqUser = $this->Users_model->getUserById($customer_id);

            $from = $this->config->item("default_email_from");
            $to = $rfqUser->email;
            $data["refq"] = $rfq;
            $mesg = "Reply recieved for Request for quotation. Please login to your account to view the details.";
            $this->email->initialize();
            $this->email->from($from, 'Atzcart');
            $this->email->to($to);
            $this->email->subject('Request For Quotaion Reply');
            $this->email->message($mesg);
            $this->email->send();*/
            $this->session->set_flashdata("message", $success);
            redirect("seller/rfqs", "refresh");
        }
    }

    public function reject($id, $rfq_id) {
        if ($id == 0) {
            $error = "<div class='alert alert-danger alert-dismissible'>
				<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
				<strong>Error!</strong> Please select valid rfq.
				</div>";
            $this->session->set_flashdata("message", $error);
            redirect("seller/rfqs", "refresh");
        }

        $this->Rfqs_model->rejectRfq($id);
        $this->Rfqs_model->updateRfq_rejected($rfq_id);
        $success = "<div class='alert alert-success alert-dismissible'>
				<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
				<strong>Success!</strong> RFQ Rejected Successfully !.
				</div>";
        $from = $this->config->item("default_email_from");
        $to = $this->config->item("default_email_to");
        $mesg = "Dear user Your Request for Quotation has been Rejected. Please login to your account to view the details.";
        $this->email->initialize();
        $this->email->from($from, 'Atzcart');
        $this->email->to($to);
        $this->email->subject('Request For Quotaion Reply');
        $this->email->message($mesg);
        $this->email->send();
        $this->session->set_flashdata("message", $success);
        redirect("seller/rfqs", "refresh");
    }

    function rfq_notify($rfq_id) {

        $this->load->library("Browser_notification");
        $this->load->model('Product_model');
        $supplier = $this->session->userdata("user_id");
        //get Customer
        $this->db->distinct();
        $this->db->select('customer_id');
        $this->db->from('rfqs');
        $this->db->where('id', $rfq_id);
        $query = $this->db->get()->row();
        if (!empty($query->customer_id)) {
            //get Firebse_id
            $buyer_firbase = $this->Users_model->get_firbase_id($query->customer_id);
            //To Buyer
            $msg = 'RFQ Replied From Seller !';
            if (!empty($buyer_firbase)) {
                $type = "RFQ";
                $type_id = $rfq_id;
                $this->browser_notification->notify_buyer('Replied From Seller!', $msg, $buyer_firbase, $type, $type_id = '');
            }
            $buyerNotify = array(
                'title' => 'New RFQ !',
                'msg' => "RFQ# $rfq_id reply from seller!",
                'user_id' => $query->customer_id,
                'type' => 'RFQ',
                'reference_id' => $supplier,
                'status' => 'Received'
            );

            $this->Product_model->insertBuyerNotify($buyerNotify);
        }

        $msg = 'RFQ#' . $rfq_id . ' Replied From Seller !';
        $tag = 'atzart.com';
        $this->browser_notification->notifyadmin('RFQ Replied From Seller!', $msg, $tag);
    }

}
