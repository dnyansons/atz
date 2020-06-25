<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Summary.
 * affiliate class is a class of affiliate marketing.
 * 
 * Description.
 * affiliate marketing is a process of promoting others product on their own website.
 * 
 * @package affiliate marketing.
 * @version PHP 7.1 20190909.
 * @author shubham patil <shubhampatil@ayninfotech.com>
 * @see http://atzcart/admin/affiliate
 */
class Affiliate extends CI_Controller {

    public function __construct() 
    {
        parent::__construct();
        if (!$this->session->userdata("admin_logged_in")) {
            $error = "<div class='alert alert-danger alert-dismissible'>
                        <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                        <strong>Error!</strong> Session timeout, relogin!.
                      </div>";
            $this->session->set_flashdata("message", $error);
            redirect("admin/login", "refresh");
        }
        $this->load->model("Affiliate_model");
        $this->load->library('Userpermission');
        $this->load->library('form_validation');
    }

    public function index() {
        $data['pageTitle'] = "Pending Affiliates";
        $data['page'] = "Pending";
        $data["status"] = "Pending";
        $data["get_url"] = "admin/affiliate/AffiliateAjaxlist";
        $this->load->view("affiliate/affliateList", $data);
    }

    public function approvedAffiliates() {
        $data['pageTitle'] = "Approved Affiliates";
        $data['page'] = "Approved";
        $data["status"] = "Approved";
        $data["get_url"] = "admin/affiliate/AffiliateAjaxlist";
        $this->load->view("affiliate/affliateList", $data);
    }

    public function rejectedAffiliates() {
        $data['pageTitle'] = "Rejected Affiliates";
        $data['page'] = "Rejected";
        $data["status"] = "Rejected";
        $data["get_url"] = "admin/affiliate/AffiliateAjaxlist";
        $this->load->view("affiliate/affliateList", $data);
    }

    /**
     * 
     * Description 
     * this ajax function returns approved, rejected, and pending affiliates.
     * this function is being called by above three functions.
     * 
     * @author shubham patil <shuhampatil@ayninfotech.com>
     * @version PHP 7.1 20190910
     */
    public function AffiliateAjaxlist() {
        $from = $this->input->post("fromdate");
        $to = $this->input->post("todate");
        $status = $this->input->post("status");

        $result = $this->Affiliate_model->getAffiliateList($from, $to, $status);

        $data = array();
        $no = $this->input->post('start');
        foreach ($result as $res) {

            $no++;
            $row = array();
            $row[] = $no;
            if ($status == "Pending") {
                $row[] = date("d M Y", strtotime($res->added_date));
            } else if ($status == "Approved") {
                $row[] = date("d M Y", strtotime($res->approved_date));
            } else {
                $row[] = date("d M Y", strtotime($res->approved_date));
            }
            $row[] = $res->id;
            $row[] = $res->fullname;
            $row[] = $res->companyname;
            if ($status == "Rejected") {
                $row[] = $res->reason;
            }
            $row[] = '<a href="' . base_url() . 'admin/affiliate/viewAffiliate/' . $res->id . '" target="_blank" ><button type="button" class="btn btn-sm btn-info">View</button></a>';
            
            $data[] = $row;
        }

        $output = array(
            "draw" => $this->input->post('draw'),
            "recordsTotal" => $this->Affiliate_model->count_all(),
            "recordsFiltered" => $this->Affiliate_model->count_filtered($from, $to, $status),
            "data" => $data,
            "posts" => $this->input->post()
        );
        echo json_encode($output);
    }

    public function viewAffiliate($affiliateId) {

        $this->form_validation->set_error_delimiters('<p style="color:red" class="text-left">', '</p>');
        $this->form_validation->set_rules("rate", "Rate", "required");
        $this->form_validation->set_rules("per_order", "Per Order Click", "required");
        if ($this->form_validation->run() === false) {
            $affiliateId = $this->security->xss_clean($affiliateId);
            $data['pageTitle'] = "Affiliate Details";
            $data["affiliateData"] = $this->Affiliate_model->getAffiliateDataById($affiliateId);
            $this->load->view("affiliate/viewAffiliate", $data);
        } else {
            $affiliateId = $this->input->post("affid");
            $todays_date = date("Y-m-d H:i:s"); 
            $updatedata = array(
                "approved_by"   =>$this->session->userdata("admin_id"),
                "status"        =>"Approved",
                "rate"          =>$this->input->post("rate"),
                "perclick"      =>$this->input->post("per_order"),
                "refurl"        =>$this->input->post("referenceUrl"),
                "approved_date" =>$todays_date
            );
            
            $result = $this->Affiliate_model->updateAdminActionOnAfflt($affiliateId, $updatedata);
            $this->send_email($affiliateId);
            
            $success = '<div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong>Affiliate!</strong> approved successfully.
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>';
            $this->session->set_flashdata("message", $success);
            redirect("admin/affiliate/approvedAffiliates", "refresh");
        }
    }

    public function adminActionOnRejectedAffiliates() {
        $reason = $this->input->post("rejectReason");
        $affiliateId = $this->input->post("affid");
        $result = $this->Affiliate_model->updateAdminActionOnRjected("Rejected", $affiliateId, $reason);
        $success = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Affiliate!</strong> rejected successfully.
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>';
        $this->session->set_flashdata("message", $success);
        redirect("admin/affiliate/rejectedAffiliates", "refresh");
    }
    
    public function affiliatePaidBilling($affiliateId,$affid='')
    {
        $this->form_validation->set_error_delimiters('<p style="color:red" class="text-left">', '</p>');
        $this->form_validation->set_rules("paymentStatus", "Payment Status", "required");
 
        if ($this->form_validation->run() === false) {
            $data['pageTitle'] = "Affiliate Paid Billing";
            $result = $this->Affiliate_model->getAffiliateBillingData($affiliateId);
            $billingAmount = 0;
            $totalCount = 0;
            if($result)
            {
                foreach($result as $row){
                    $totalCount += $row->count; 
                    $billingAmount =  ( $totalCount/$row->perclick)*$row->rate;
                }
            }
            $data["affid"] = $affid;
            $data["billingAmount"] = $billingAmount;
            $data["totalCount"] = $totalCount;
            $this->load->view("affiliate/paidBilling", $data);
            
        } else {

              $admin_id = $this->session->userdata("admin_id");
              $paymentStatus = $this->input->post("paymentStatus");
              $paymentDate = $this->input->post("paymentDate");
              $affId = $this->input->post("affId");
              if($paymentDate == "")
              {
                  $paidDate = date("Y-m-d");
              }else{
                  $paidDate = date("Y-m-d",strtotime($paymentDate));
              }
              $bilingDetails = array(
                  "affid"           => $affiliateId,
                  "totalorder"      => $this->input->post("totalCount"),
                  "amount"          => $this->input->post("billingAmount"),
                  "paymentstatus"   => $paymentStatus,
                  "referenceid"     => $this->input->post("referenceId"),
                  "paymentdate"     => $paidDate,
                  "paymentby"       => $admin_id,
                  "holdcomment"     => $this->input->post("holdreason")
              );
              
              if($paymentStatus == "Hold")
              {
                  $this->Affiliate_model->updateaffiliate($affId);
                  $result = $this->Affiliate_model->insertAffiliateBilling($bilingDetails);
                  
              }else{
                  $result = $this->Affiliate_model->insertAffiliateBilling($bilingDetails);
              }
              if($result)
              {
                    if($paymentStatus == "Paid")
                    {
                          $this->send_Billing_email($affiliateId);
                          $this->load->library("Browser_notification");
                          $this->load->model("Product_model");

                          $msg = "Payment done successfully for ". $this->input->post("totalCount")." Orders!";
                          $tag = 'atzcart.com';
                    }else{
                          $this->load->library("Browser_notification");
                          $this->load->model("Product_model");

                          $msg = "Payment done successfully for ". $this->input->post("totalCount")." Orders!";
                          $tag = 'atzcart.com';
                    }
                    
                    $this->Affiliate_model->updateAffiliateOrders($affiliateId);
                    $this->browser_notification->notify_buyer('hello!', $msg, $tag);
                    $buyerNotify = array(
                        'title' => 'Billings',
                        'msg' => $msg . ' ( Web ) ',
                        'user_id' => $affiliateId,
                        'type' => 'AffiliatePayment',
                        'reference_id' => $admin_id,
                        'status' => 'Received'
                    );
                    
                  $this->Product_model->insertBuyerNotify($buyerNotify);
                  if($paymentStatus == "Paid")
                  {
                    $success = '<div class="alert alert-success alert-dismissible fade show" role="alert">
                          <strong>Affiliate!</strong> Payment done successfully.
                          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>';
                   $this->session->set_flashdata("message", $success);
                   redirect("admin/affiliate/affiliateBillingPaid", "refresh");
                  }else{
                      $success = '<div class="alert alert-success alert-dismissible fade show" role="alert">
                          <strong>Affiliate!</strong> Payment On Hold.
                          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>';
                   $this->session->set_flashdata("message", $success);
                   redirect("admin/affiliate/affiliateBillinghold", "refresh");
                  }
              }
        }
    }
    
    public function affiliateHoldBilling($affiliateId,$billingId)
    {
        $this->form_validation->set_error_delimiters('<p style="color:red" class="text-left">', '</p>');
        $this->form_validation->set_rules("paymentStatus", "Payment Status", "required");
        $this->form_validation->set_rules("referenceId", "Refference Id", "required");
        $this->form_validation->set_rules("paymentDate", "Payment Date", "required");
 
        if ($this->form_validation->run() === false) {
            $data['pageTitle'] = "Affiliate Hold Billing";
            $result = $this->Affiliate_model->getAffiliateholdBillingData($billingId);
            $data["result"] = $result;
            $data["billingId"] = $billingId;
            $this->load->view("affiliate/holdbilling", $data);
            
        } else {

              $admin_id = $this->session->userdata("admin_id");
              $paymentStatus = $this->input->post("paymentStatus");
              $paymentDate = $this->input->post("paymentDate");
              $billingId = $this->input->post("billingId");
            
              $bilingDetails = array(
                  "affid"           => $affiliateId,
                  "totalorder"      => $this->input->post("totalCount"),
                  "amount"          => $this->input->post("billingAmount"),
                  "paymentstatus"   => $paymentStatus,
                  "referenceid"     => $this->input->post("referenceId"),
                  "paymentdate"     => date("Y-m-d"),
                  "paymentby"       => $admin_id,
                  "holdcomment"     => ""
              );

              $result = $this->Affiliate_model->updateAffiliateBilling($bilingDetails,$billingId);
              if($result)
              {
                    $this->send_Billing_email($affiliateId);
                    $this->load->library("Browser_notification");
                    $this->load->model("Product_model");

                    $msg = "Payment done successfully for ". $this->input->post("totalCount")." Orders!";
                    $tag = 'atzcart.com';
                    $this->browser_notification->notify_buyer('hello!', $msg, $tag);
                    
                    $buyerNotify = array(
                        'title' => 'Billings',
                        'msg' => $msg . ' ( Web ) ',
                        'user_id' => $affiliateId,
                        'type' => 'AffiliatePayment',
                        'reference_id' => $admin_id,
                        'status' => 'Received'
                    );
                    
                  $this->Product_model->insertBuyerNotify($buyerNotify);
                  $success = '<div class="alert alert-success alert-dismissible fade show" role="alert">
                      <strong>Affiliate!</strong> Payment done successfully.
                      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>';
                 $this->session->set_flashdata("message", $success);
                 redirect("admin/affiliate/affiliateBillingPaid", "refresh");
              }
        }
    }
    
    public function affiliateBillingList()
    {
        $data['pageTitle'] = "Affiliates Billing List";
        $data["get_url"] = "admin/affiliate/billingPendingAjaxlist";
        $data["page"] = "Pending";
        $this->load->view("affiliate/pendingBillingList", $data);
    }
    
    public function billingPendingAjaxlist()
    {

        $result = $this->Affiliate_model->getAffiliatePendingBillingList();
        $data = array();
        $no = $this->input->post('start');
        foreach ($result as $res) {

            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $res->id;
            $row[] = $res->fullname;
             $row[] = $res->companyname;
            $row[] = '<span style="color:red">Pending</span>'; 
            $row[] = '<a href="' . base_url() . 'admin/affiliate/affiliatePaidBilling/'.$res->id. '/'. $res->afid .'" target="_blank" ><button type="button" onClick="this.disabled=true" class="btn btn-sm btn-info">Billing</button></a>';

            $data[] = $row;
        }

        $output = array(
            "draw" => $this->input->post('draw'),
            "recordsTotal" => $this->Affiliate_model->countPendingBillingAll(),
            "recordsFiltered" => $this->Affiliate_model->countPendingBillingfiltered(),
            "data" => $data,
            "posts" => $this->input->post()
        );
        echo json_encode($output);
    }
    
    public function affiliateBillingPaid()
    {
        $data['pageTitle'] = "Affiliates Billing List";
        $data["get_url"] = "admin/affiliate/BillingAjaxlist";
        $data["page"] = "Paid";
        $data["status"] = "Paid";
        $this->load->view("affiliate/billingList", $data);
    }

    
    public function affiliateBillinghold()
    {
        $data['pageTitle'] = "Affiliates Billing List";
        $data["get_url"] = "admin/affiliate/BillingAjaxlist";
        $data["page"] = "Hold";
        $data["status"] = "Hold";
        $this->load->view("affiliate/billingList", $data);
    }
    
    public function BillingAjaxlist()
    {
        $from = $this->input->post("fromdate");
        $to = $this->input->post("todate");
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
            if($res->paymentstatus == "Hold")
            {
                $row[] = $res->holdcomment;
                $row[] = '<a href="' . base_url() . 'admin/affiliate/affiliateHoldBilling/'.$res->affid.'/' . $res->id . '" target="_blank" ><button type="button" onClick="this.disabled=true" class="btn btn-sm btn-info">Billing</button></a>';
            }else{
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
    
    function send_email($affiliateId) {
        
        $result = $this->Affiliate_model->getAffiliateDataById($affiliateId);
        $data["affiliateId"] = $result->id;
        $data["rate"] = $result->rate;
        
        $from = $this->config->item("default_email_from");
        $to = trim($result->username);

        $msg = $this->load->view('emailtemplates/affiliateTemplate',$data,true);
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
        $this->email->subject('Welcome - ATZCart Affiliate Program');
        $this->email->message($msg);
        $this->email->send();
    }
    
    function send_Billing_email($affiliateId) {
        
        $data = $this->Affiliate_model->getAffiliateDataById($affiliateId);
        $from = $this->config->item("default_email_from");
        $to = trim($data->username);

        $mesg = $this->load->view('emailtemplates/affiliateBilling','',true);
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
        $this->email->subject('ATZCart Affiliate Program Billing');
        $this->email->message($mesg);
        $this->email->send();
    }
}

?>