<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Orders extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Product_model');
        $this->load->model('Users_model');
        $this->load->model('Inquiries_model');
        $this->load->model('Order_model');
        $this->load->model('Common_model');
        $this->load->library('Shipping');
        $this->load->model('Shipping_model');
        $this->load->model('Myfavourite_model');
        $this->load->model('Coupon_model');
        $this->load->library("get_header_data");
        $this->load->library('Shipping');
        $this->load->library('Shiprocket');
        $this->load->library('send_data');
        $this->load->library('email');
        $this->load->model('Myorders_model');
        $this->load->library('browser_notification');
    }

    public function index($order_id) {
        if (!$this->session->userdata("user_logged_in")) {
            redirect("signin", "refresh");
        } else {
            $reason = $this->Common_model->getAll('refund_reason', array('status' => 'Active', 'reason_type' => 'Cancel'))->result_array();
            $data['sorder'] = $this->Myorders_model->single_order($order_id);
            $data['reasons'] = $reason; 
            $this->load->view("mobile/cancel_order_view", $data);
        }
    }

    public function submit_cancel_order() {

        if (!$this->session->userdata("user_logged_in")) {
            redirect("signin", "refresh");
        } else {

            $this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>');
            $this->form_validation->set_rules("cancel_reason", "Reason", "required");
            if ($this->form_validation->run() === false) {

                $order_id = $this->input->post('order_id');
                $reason = $this->Common_model->getAll('refund_reason', array('status' => 'Active', 'reason_type' => 'Cancel'))->result_array();
                $data['sorder'] = $this->Myorders_model->single_order($order_id);
                $data['reasons'] = $reason;
                $this->load->view("mobile/cancel_order_view", $data);
            } else {

                $order_id = $this->input->post('order_id');
                $reason = $this->input->post('cancel_reason');
                $other_reason = $this->input->post('other_reason');

            if (!empty($order_id) && !empty($reason)) {
                    //Update Tracking
                    $this->shipping->latest_tracking_status($order_id);
                    $seller_q = $this->Order_model->getOrderDetailsByOrderId($order_id);
                    $seller = $seller_q[0]['seller'];
                    $user_id = $this->session->userdata("user_id");
                    $ch_order = $this->Common_model->getAll('orders', array('user_id' => $user_id, 'orders_id' => $order_id))->num_rows();
                    
                    if ($ch_order > 0) {
                        ////////////////////Refund Check////////////////////
                        $ordcheck = 0;
                        //check status Processing Or Not
                        $ch_processing = $this->Common_model->getAll('orders_history', array('status' => 10, 'orders_id' => $order_id))->num_rows();
                        //Check Pick Up
                        $ch_pick = $this->Common_model->getAll('orders_history', array('status' => 18, 'orders_id' => $order_id))->num_rows();
                        if ($ch_pick == 0 && $ch_processing > 0) {
                           
                            //Insert Refund Data
                            $insertRefund['orders_id'] = $order_id;
                            $insertRefund['seller'] = $seller;
                            $insertRefund['orders_status'] = 'ATZCART.COM Approved';
                            $insertRefund['reason_id'] = $reason;
                            $insertRefund['other_reason'] = $other_reason;
                            $insertRefund['created_at'] = date('Y-m-d H:i:s');

                            //Get refund Amount
                            $orderDetails = $this->Order_model->getOrderDetailsByOrderId($order_id);
                            $ch_refund = $this->Common_model->getAll('orders_history', array('status' => 18, 'orders_id' => $order_id))->num_rows();
                            if ($ch_refund > 0) {
                                $insertRefund['refund_amount'] = $orderDetails[0]['order_price'] - $orderDetails[0]['shipping_cost'];
                            } else {
                                $insertRefund['refund_amount'] = $orderDetails[0]['order_price'];
                            }
                          
                           //Shipping Cost Deducted and Refund
                            $this->Common_model->insert('order_refund', $insertRefund);

                            $this->Myorders_model->update_cancel_order_history($order_id);

                            //insert in adminnotify table
                            $msg = "Order Canceled By Buyer  " . $this->session->userdata('user_name') . ' of order #ORD' . $order_id;
                            $msg_buyer = "Order Cancel of order #ORD" . $order_id;
                            
                            $adminNotify = array(
                                'title' => 'Order Cancel & Refund',
                                'msg' => $msg . ' ( Web ) ',
                                'type' => 'order_cancel',
                                'reference_id' => $order_id,
                                'status' => 'Received'
                            );
                            
                            $buyerNotify = array(
                                'title' => 'Order Cancel & Refund',
                                'msg' => $msg_buyer,
                                'user_id' => $user_id,
                                'type' => 'order_cancel',
                                'reference_id' => $order_id,
                                'status' => 'Received'
                            );

                            $insertAdminNotify = $this->Product_model->insertAdminNotify($adminNotify);
                            $insertBuyerNotify = $this->Product_model->insertBuyerNotify($buyerNotify);
                            
                            //Cancel Approved By Update
                            $da['cancelled_by'] = 'Buyer-' . $this->session->userdata("user_name");
                            $this->Common_model->update('orders', $da, array('orders_id' => $order_id));
                            
                            // Shipping Vendor Checked Whether Bluedart or Shipprocket
                            $checkshipMethod = $this->Common_model->getAll("order_shipping", array('orders_id' => $order_id))->row();
                            if ($checkshipMethod->ship_vendor_id == 2) {
                                    $postData = json_encode(array(
                                        'ids' =>
                                        array(
                                            0 => $checkshipMethod->ship_order_id,
                                        ),
                                    ));
                                    $this->shiprocket->cancel_order($postData);
                                    
                                } else {
                                    //Cancel Order 
                                    if ($orderDetails[0]['order_token_number'] != 0) {
                                        $token_no = $orderDetails[0]['order_token_number'];
                                        $pickup_date = $orderDetails[0]['ShipmentPickupDate'];
                                        $res = $this->shipping->cancel_pickup($token_no, $pickup_date);   
                                    }
                                    if ($orderDetails[0]['awb_number'] != 0) { 
                                        $res = $this->shipping->cancelwaybill($orderDetails[0]['awb_number']);
                                    }
                                }

                            $dat['order_tracking_status'] = 2;
                            $dat['orders_status'] = 25;
                            
                            $up = $this->Common_model->update('orders', $dat, array('orders_id' => $order_id));
                           
                            if ($up) {
                                $this->Myorders_model->refund_added_to_wallet_from_buyer($order_id);
                            }

                            $this->order_cancel_notify($order_id, 1, $insertRefund['refund_amount']);

                            $error = "<div class='alert alert-success alert-dismissible'>
                                        <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                                        <strong>Success !</strong> Order Cancelled Successfully ! Amount added to Your wallet
                                  </div>";
                            
                        } elseif ($ch_pick > 0 && $ch_processing > 0) {
                        
                            //Insert Refund Data
                            $insertRefund['orders_id'] = $order_id;
                            $insertRefund['seller'] = $seller;
                            $insertRefund['orders_status'] = 'Initiated';
                            $insertRefund['reason_id'] = $reason;
                            $insertRefund['other_reason'] = $other_reason;
                            $insertRefund['created_at'] = date('Y-m-d H:i:s');
                            //Shipping Cost Deducted and Refund
                            $this->Common_model->insert('order_refund', $insertRefund);

                            //Order Refund History
                            $inserRefundHistory['orders_id'] = $order_id;
                            $inserRefundHistory['comment'] = 'Initiated';
                            $inserRefundHistory['created_at'] = date('Y-m-d H:i:s');
                            $this->Common_model->insert('order_refund_history', $inserRefundHistory);
                            
                            $dat['order_tracking_status'] = 2;
                            $dat['orders_status'] = 20;
                            $up = $this->Common_model->update('orders', $dat, array('orders_id' => $order_id));

                            //Pending
                            $orderHistory['orders_id'] = $order_id;
                            $orderHistory['status'] = 20;
                            $orderHistory['date_added'] = date('Y-m-d H:i:s');
                            $orderHistory['comment'] = 'Order Cancel Request Pending !';

                            $this->Common_model->insert('orders_history', $orderHistory);

                            //insert in adminnotify table
                            $msg = "Order Canceled By Buyer  " . $this->session->userdata('user_name') . ' of order #ORD' . $order_id . ' ( Pending )';
                            $msg_buyer = "Order Cancel Request of order #ORD" . $order_id;
                            
                            $adminNotify = array(
                                'title' => 'Order Cancel Request Pending',
                                'msg' => $msg . ' ( Web ) ',
                                'type' => 'order_cancel',
                                'reference_id' => $order_id,
                                'status' => 'Received'
                            );
                            
                            $buyerNotify = array(
                                'title' => 'Order Cancel Request',
                                'msg' => $msg_buyer,
                                'user_id' => $user_id,
                                'type' => 'order_cancel',
                                'reference_id' => $order_id,
                                'status' => 'Received'
                            );

                            $insertAdminNotify = $this->Product_model->insertAdminNotify($adminNotify);
                            $insertBuyerNotify = $this->Product_model->insertBuyerNotify($buyerNotify);
                            
                            $this->order_cancel_notify($order_id, 0,0);
                            $error = "<div class='alert alert-success alert-dismissible'>
                                                        <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                                                        <strong>Success !</strong> Cancel Request Send Successfully !
                                                  </div>";
                        } else {
                            $error = "<div class='alert alert-danger alert-dismissible'>
                                                    <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                                                    <strong>Error !</strong> Somthing Went Wrong !
                                              </div>";
                        }
                        ///////////////////Refund End//////////////////////
                    }
                } else {
                    $error = "<div class='alert alert-danger alert-dismissible'>
                                            <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                                            <strong>Error !</strong> Reason Must be Fill Up !
                                      </div>";
                }
                $this->session->set_flashdata("message", $error);
                redirect('home/myorders');
            }
        }
    }
    function order_cancel_notify($order_id = 0, $cancel, $amt = 0) {
        //Get Data
        $this->db->select('a.user_email_address,a.orders_id,a.user_name,a.user_id,a.user_telephone,a.seller_id,b.firebase_id as buyer_firbase,c.firebase_id as seller_firebase');
        $this->db->from('orders a');
        $this->db->join('users_firebase_details b', 'a.user_id=b.user_id', 'left');
        $this->db->join('users_firebase_details c', 'a.seller_id=c.user_id', 'left');
        $this->db->where('a.orders_id', $order_id);
        $query = $this->db->get()->row();

        $user_id = $query->user_id;
        $seller_id = $query->seller_id;
        $user_name = $query->user_name;
        $user_phone = $query->user_telephone;
        $buyer_firbase = $query->buyer_firbase;
        
        //Employee SMS Text and number list
        $empMsg = "#ORD".$order_id.'! has been cancelled by buyer '.$user_name;
        $empMobileNums = $this->getMobileNumbers();
        //iff empmobile are not assigned then don't send sms
        if(!empty($empMobileNums)) {
            //Send SMS to Employees Of ATZCART From admin
            $this->send_data->send_sms($empMsg, $empMobileNums);
        }
        
        if ($cancel == 1) {
            //Send SMS to Customer
            $msg = "Dear user, you have successfully cancelled your order #ORD".$order_id."! Your wallet will be credited with INR ".$amt." within few hours.";
            $mob = $this->session->userdata("phone");
            $this->send_data->send_sms($msg, $user_phone);
            $email=$query->user_email_address;
            
            if(!empty($email))
            {
                $title = 'Order Cancelled !';
                $this->send_email($email, $title, $msg);
            }
            //Notify To Seller
            $title = 'Order Cancelled';
            $msg = "Order #ORD" . $order_id . " By Buyer " . $user_name . ' ! Order Amount has been added to Your wallet';
            $tag = date('d M Y');
            $this->browser_notification->notifyseller($seller_id, $title, $msg, $tag);

            //To Buyer
            if (!empty($buyer_firbase)) {
                $type = "Cancel";
                $this->browser_notification->notify_buyer('Order Cancelled !', $msg, $buyer_firbase, $type, $type_id = '');
            }
            $msg = 'Order Cancelled by  Buyer ' . $user_name;
            $tag = date('d M Y');
            $this->browser_notification->notifyadmin('Order Cancelled!', $msg, $tag);
        }

        if ($cancel == 0) {
            //Send SMS to Customer
            $msg = 'Your Cancel Request Sent Successfully against order #ORD'.$order_id.'! Shipping cost will be applicable against your cancelled order';
            $this->send_data->send_sms($msg, $user_phone);

            $title = 'Cancel Order Request';
            $msg = "Order #ORD" . $order_id . " By Buyer " . $user_name;
            $tag = date('d M Y');
            $this->browser_notification->notifyseller($seller_id, $title, $msg, $tag);

            //To Buyer
            if (!empty($buyer_firbase)) {
                $type = "Cancel";
                $this->browser_notification->notify_buyer('Cancel Order Request !', $msg, $buyer_firbase, $type, $type_id = '');
            }

            $msg = 'Order Cancel Request from Buyer ' . $user_name;
            $tag = date('d M Y');
            $this->browser_notification->notifyadmin('Order Cancelled!', $msg, $tag);
        }
    }
    
    /**
     * Send Mail While Cancel Order. 
     */
    function send_email($email,$title,$msg) {
        
        $buyer_email =$email;
        $data['msg'] = $msg;
        $data['title'] = $title;
        
        $from = $this->config->item("default_email_from");

        $to =$buyer_email;
        $mesg = $this->load->view('emailtemplates/cancel_order', $data, true);
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
        $this->email->subject('Order Cancelled');
        $this->email->message($mesg);
        $this->email->send();
    }
    
    /**
     * @auther Yogesh Pardeshi 20072019 436pm
     * Fetches contacts for sending sms_for = cancel orders
     * @return type comma seperated list of mobile numbers 
     */
    private function getMobileNumbers() {
        $mobile_nums = $this->db->select('emp_mobile')->from('order_cancel_sms_emp_receiver')
                                   ->where('sms_for', 'Order Cancel')
                                   ->where('status', 'active')
                                   ->get()->result_array();
        $numbers  = "";
        foreach ($mobile_nums as $nums){
            $numbers .= $nums['emp_mobile'].',';
        }
        return rtrim($numbers, ',');
    }
    /*
     * Author Ravindra Warthi.
     * Remove Order Product Which are Pending from Order,Order_product,Order-history.
     * @param $order_id
     */
    public function remove_order()
    {
        $order_id=$this->input->post("order_id");
        
        $this->db->trans_begin();
        $this->db->delete('orders', array('orders_id' =>  $order_id)); 
        $this->db->delete('orders_products', array('orders_id' => $order_id));
        $this->db->delete('orders_history', array('orders_id' => $order_id));
        if ($this->db->trans_status() === FALSE)
        {
                $this->db->trans_rollback();
        }
        else
        {
                $this->db->trans_commit();
        }
    }
}



