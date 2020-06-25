<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Summary.
 * affiliate class is a class of affiliate marketing.
 * 
 * Description.
 * affiliate marketing is a process of promoting others product on their own website.
 * 
 * @package affiliate marketing.
 * @author shubham patil <shubhampatil@ayninfotech.com>
 * @see http://atzcart/affiliate-marketing
 */
class Affiliate extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model("Affiliate_model");
        $this->load->library('form_validation');
        $this->load->library('Userpermission');
        $sess_data = $this->session->userdata("affiliate_session");
        if ($sess_data["affiliateLogin"] != 1) {
            $error = "<div class='alert alert-danger alert-dismissible pr-0' style='font-size:12px'>
                                <a href='#' class='close' data-dismiss='alert' aria-label='close' style='padding-right:12px'>&times;</a>
                                <strong>Error!</strong> Please Login.
                              </div>";
            $this->session->set_flashdata("message", $error);
            redirect("affiliate/login");
        }
        $this->sess_data = $sess_data;
    }

    public function index() {
        $data["pageTitle"] = "Affiliate Marketing - Dashboard";
        $affiliateId = $this->sess_data["affiliateId"];
        $data["affiliateId"] = $affiliateId;
        $result = $this->Affiliate_model->getAffilliateTotalOrders($affiliateId);

        $data["billingAmount"] = $result->amount;
        $data["totalCount"] = $result->totalorder;

        $data["affiliateFullname"] = $this->sess_data["affiliateFullname"];
        $this->load->view("affiliate/dashboard/dashboard", $data);
    }

    public function affiliateProfile() {
        $user_id = $this->sess_data["affiliateId"];
        $data["affiliateId"] = $user_id;
        $data['user'] = $this->Affiliate_model->getAffiliateDataById($user_id);
        $data["affiliateFullname"] = $this->sess_data["affiliateFullname"];
        $data["pageTitle"] = "Profile Details";
        $this->load->view('affiliate/dashboard/profile', $data);
    }

    public function affiliateBillingList() {
        $data['pageTitle'] = "Paid Billing List";
        $data["affiliateId"] = $this->sess_data["affiliateId"];
        $data["affiliateFullname"] = $this->sess_data["affiliateFullname"];
        $data["get_url"] = "affiliate/affiliate/BillingAjaxlist";
        $data["page"] = "Paid";
        $data["status"] = "Paid";
        $this->load->view("affiliate/dashboard/billingList", $data);
    }

    public function affiliateBillinghold() {
        $data['pageTitle'] = "Hold Billing List";
        $data["affiliateFullname"] = $this->sess_data["affiliateFullname"];
        $data["affiliateId"] = $this->sess_data["affiliateId"];
        $data["get_url"] = "affiliate/affiliate/BillingAjaxlist";
        $data["page"] = "Hold";
        $data["status"] = "Hold";
        $this->load->view("affiliate/dashboard/billingList", $data);
    }

    public function BillingAjaxlist() {
        $from = $this->input->post("fromdate");
        $to = $this->input->post("todate");
        $affiliateId = $this->sess_data["affiliateId"];
        $status = $this->input->post("status");

        $result = $this->Affiliate_model->getAffiliateBillingList($from, $to, $affiliateId, $status);
        $data = array();
        $no = $this->input->post('start');
        foreach ($result as $res) {

            $no++;
            $row = array();
            $row[] = $no;
            $row[] = date("d M Y", strtotime($res->paymentdate));
            $row[] = $res->affid;
            $row[] = $res->fullname;
            $row[] = $res->totalorder;
            $row[] = $res->amount;
            $row[] = $res->paymentstatus;
            if($status == "Paid"){
                 $row[] = $res->referenceid;
            }

            $data[] = $row;
        }

        $output = array(
            "draw" => $this->input->post('draw'),
            "recordsTotal" => $this->Affiliate_model->countBillingAll(),
            "recordsFiltered" => $this->Affiliate_model->countBillingfiltered($from, $to, $affiliateId, $status),
            "data" => $data,
            "posts" => $this->input->post()
        );
        echo json_encode($output);
    }

    public function editPaymentDetails($affiliateId) {
        $this->form_validation->set_rules('benfryname', 'Beneficiary Name', "required");
        $this->form_validation->set_rules('accno', 'Account Number', "required");
        $this->form_validation->set_rules('bankname', 'Bank Name', "required");
        $this->form_validation->set_rules('ifsccode', 'IFSC Code', "required");
        if ($this->form_validation->run() === false) {
            $data["pageTitle"] = "Edit Payment Details";
            $data["affiliateId"] = $this->sess_data["affiliateId"];
            $data['user'] = $this->Affiliate_model->getAffiliateDataById($affiliateId);
            $this->load->view('affiliate/dashboard/editPaymentDetails', $data);
        } else {
            $paymentUpdate = array(
                "affid" => $affiliateId,
                "beneficiaryname" => $this->input->post("benfryname"),
                "accno" => $this->input->post("accno"),
                "bankname" => $this->input->post("bankname"),
                "ifscno" => $this->input->post("ifsccode")
            );

            $result = $this->Affiliate_model->updateBankDetails($affiliateId, $paymentUpdate);
            $success = '<div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>Success!</strong> Bank details updated successfully.
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>';
            $this->session->set_flashdata("paymentmessage", $success);
            redirect("affiliate/affiliate/affiliateProfile", "refresh");
        }
    }

    public function changePassword() {
        $this->load->library("form_validation");
        $this->form_validation->set_rules('old_password', 'old_password', 'required|callback_isvalidOldPass');
        $this->form_validation->set_error_delimiters('<p style="color:red" class="text-left">', '</p>');
        $this->form_validation->set_rules('new_password', 'New Password', 'required');
        $this->form_validation->set_rules('confirm_password', 'Confirm Password', 'required|matches[new_password]');
        $this->form_validation->set_error_delimiters('<div class="alert alert-danger alert-dismissible mt-2">'
                . ' <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><b> Error :</b>', '</div>');

        if ($this->form_validation->run() === false) {
            $data["pageTitle"] = "Affiliate - Change Password";
            $data["affiliateId"] = $this->sess_data["affiliateId"];
            $data["affiliateFullname"] = $this->sess_data["affiliateFullname"];
            $this->load->view("affiliate/dashboard/changepassword", $data);
        } else {
            $affiliateId = $this->sess_data["affiliateId"];
            $password = password_hash($this->input->post("new_password"), PASSWORD_DEFAULT);
            $this->Affiliate_model->updatePassword($affiliateId, $password);
            $msg = '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Success!</strong> Password updated successfully! Effective from next login.
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>';
            $this->session->set_flashdata("changepass", $msg);
            redirect("affiliate/affiliate/changePassword", "refresh");
        }
    }

    public function isvalidOldPass($password) {
        $affiliateId = $this->sess_data["affiliateId"];
        $userInfo = $this->Affiliate_model->getAffiliateDataById($affiliateId);

        if (password_verify($password, $userInfo->password)) {
            return true;
        } else {
            $this->form_validation->set_message("isvalidOldPass", "Invalid old password");
            return false;
        }
    }

}

?>