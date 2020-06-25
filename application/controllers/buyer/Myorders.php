<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Myorders extends CI_Controller {

    public function __construct() {
        parent::__construct();
        if (!$this->session->userdata("user_logged_in")) {
            $error = "<div id='login-error' class='form-error notice notice-error'><span class='icon-notice icon-error'></span><span><strong>Error!</strong> Session timeout, relogin!. </span></div>";
            $this->session->set_flashdata("message", $error);
            redirect("login", "refresh");
        }
        $this->load->model('Myorders_model');
        $this->load->model('Product_model');
        $this->load->model('Common_model');
        $this->load->library('Shipping');
        $this->load->library('Shiprocket');
        $this->load->library("get_header_data");
        $this->load->library("Browser_notification");
        $this->load->library("Send_data");
        $this->load->model("Offer_model");
    }

    public function index() {
        $data["pageTitle"] = "My Orders";
        $data = $this->get_header_data->get_categories();
        $user_id = $this->session->userdata("user_id");

        //Update Views Status
        $upviewed['viewed_by_user'] = 1;
        $this->Common_model->update('orders', $upviewed, array('user_id' => $user_id, 'viewed_by_user' => 0));


        if ($this->input->get('order') == 'today') {
            $fordate = date('Y-m-d');
        } elseif ($this->input->get('order') == 'yesterday') {
            $fordate = date('Y-m-d', strtotime("-1 days"));
        } elseif ($this->input->get('order') == 'all') {
            $fordate = 'all';
        } else {
            $fordate = date('Y-m-d');
        }

        $this->db->select('*');
        $this->db->from('orders a');
        $this->db->join('orders_status b', 'a.orders_status=b.orders_status_id');
        $this->db->where('a.user_id', $user_id);
        if ($fordate != 'all') {
            $this->db->where('date(a.date_purchased)', $fordate);
        }
        $this->db->order_by('a.orders_id', 'desc');
        $data['allorder'] = $this->db->get()->result();
        // echo $this->db->last_query();
        ///exit;
        $this->load->view('front/common/header', $data);
        $this->load->view("front/myaccount/orders");
        $this->load->view('front/common/footer');
    }

    public function get_orders() {
        $user_id = $this->session->userdata("user_id");
        $data['allorder'] = $this->Myorders_model->allorders($user_id, $limit = 1000, $start = 0, $order = 0, $dir = 0);
        $this->output->set_output(json_encode($data));
    }

    public function ajax_list() {
        $ret_id = $this->session->userdata("user_id");
        $columns = array(
            0 => 'orders_id',
            1 => 'order_price',
            2 => 'orders_status_name',
            3 => 'date_purchased',
        );

        $limit = $this->input->post('length');
        $start = $this->input->post('start');
        $order = $columns[$this->input->post('order')[1]['column']];
        $dir = $this->input->post('order')[1]['dir'];

        $totalData = $this->Myorders_model->allorders_count($ret_id);


        $totalFiltered = $totalData;

        if (empty($this->input->post('search')['value'])) {
            $alorder = $this->Myorders_model->allorders($ret_id, $limit, $start, $order, $dir);
        } else {
            $search = $this->input->post('search')['value'];

            $alorder = $this->Myorders_model->order_search($ret_id, $limit, $start, $search, $order, $dir);
            //echo $this->db->last_query();

            $totalFiltered = $this->Myorders_model->order_search_count($ret_id, $search);
        }

        $data = array();
        if (!empty($alorder)) {
            foreach ($alorder as $br) {
                $nestedData['orders_id'] = $br->orders_id;
                $nestedData['order_price'] = $br->order_price;

                $nestedData['orders_status_name'] = $br->orders_status_name;
                $nestedData['date_purchased'] = date('d-m-Y', strtotime($br->date_purchased));
                $nestedData['action'] = '<a type="button" href="' . base_url() . 'buyer/myorders/order_view/' . $br->orders_id . '" class="btn btn-warning btn-sm">View&nbsp;Detail</a>';

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

    function order_view($order_id) {
        $data1 = $this->get_header_data->get_categories();
        $user_id = $this->session->userdata("user_id");
        //Get Latest Tracking Status//
        $ord = $this->Common_model->getAll('orders', array('orders_id' => $order_id))->row();
        $data['retord'] = $this->Common_model->getAll('return_orders', array('orders_id' => $order_id))->row();

        if ($ord->user_id == $user_id) {
            $this->shipping->latest_tracking_status($order_id);
            $data['reason'] = $this->Common_model->getAll('refund_reason', array('status' => 'Active','reason_type'=>'Cancel'))->result_array();
            $data['orderDetails'] = $this->Order_model->getOrderDetailsByOrderId($order_id);
            $data['sorder'] = $this->Myorders_model->single_order($order_id);
            $data['products'] = $this->Myorders_model->order_products($order_id);
            $data['return_order_shipping'] = $this->Common_model->getAll('return_order_shipping',array('orders_id'=>$order_id))->row();



            $this->load->view('front/common/header', $data1);
            $this->load->view("front/myaccount/order_view", $data);
            $this->load->view('front/common/footer');
        } else {
            redirect('buyer/myorders');
        }
    }

    function invoice_view($order_id) {

        $user_id = $this->session->userdata("user_id");
        //Get Latest Tracking Status//
        $ord = $this->Common_model->getAll('orders', array('orders_id' => $order_id))->row();

        if ($ord->user_id == $user_id) {
            $data['reason'] = $this->Common_model->getAll('refund_reason', array('status' => 'Active'))->result_array();
            $data['orderDetails'] = $this->Order_model->getOrderDetailsByOrderId($order_id);
            $data['sorder'] = $this->Myorders_model->single_order($order_id);
            $data['products'] = $this->Myorders_model->order_products($order_id);
            $this->load->view("front/myaccount/invoice", $data);
        } else {
            redirect('buyer/myorders');
        }
    }

    function get_order_details() {

        $order_id = $this->input->post('ord');
        $reason = $this->Common_model->getAll('refund_reason', array('status' => 'Active', 'reason_type' => 'cancel'))->result_array();
        $sorder = $this->Myorders_model->single_order($order_id);

        if((($sorder["order_price"]-$sorder["shipping_cost"]) >=500) &&  $sorder['shippment_type']=='Free')
        {
            $shipping_cost='0.00'; 
        }else{
            $shipping_cost=$sorder["shipping_cost"];
        }
        $str = '';
        $str .= '<div class="row">
		<input type="hidden" name="order_id" value="' . $sorder["orders_id"] . '">
									 <table class="table table-striped table-bordered nowrap dataTable">
									 <tr>
										<td>Total Order Price </td>
										<td>' . $sorder["order_price"] . '</td>
									 </tr> 
									 <tr>
										<td>Shipping Cost</td>
										<td>' . $shipping_cost . '</td>
									 </tr>
									 <tr>
										<td>Current Order Status</td>
										<td>' . $sorder["orders_status_name"] . '</td>
									 </tr>
									 </table>
									 
									 <hr>
									 <div class="col-md-12">
									 <label><b>Select Cancel Reason</b></label>
									 <select class="form-control" name="cancel_reason" id="reason" required>
										<option value="">Select Cancel Reason</option>';

        foreach ($reason as $re) {
            $str .= '<option value="' . $re["reason_id"] . '">' . $re["reason_name"] . '</option>';
        }

        $str .= '</select><div class="reason_error" style="color:red" class="pt-2"></div>
                </div>

                <div class="col-md-12">
                <br>
                <label><b>Any Other ?</b></label>
                        <textarea class="form-control" name="other_reason" required></textarea>
                </div>
	 </div>';
        echo $str;
    }

    function track_order($order_id = 0) {

        if ($order_id != 0) {

            $user_id = $this->session->userdata("user_id");
            $ord = $this->Common_model->getAll('orders', array('orders_id' => $order_id))->row();

            if ($ord->user_id == $user_id) {


                //Get Latest Tracking Status//
                $this->shipping->latest_tracking_status($order_id);
                $data2['order_id'] = $order_id;
                $data2['hist_dat'] = $this->Order_model->get_order_status($order_id);

                $data = $this->get_header_data->get_categories();
                $user_id = $this->session->userdata("user_id");

                $this->load->view('front/common/header', $data);
                $this->load->view("front/myaccount/track_order", $data2);
                $this->load->view('front/common/footer');
            } else {
                redirect('buyer/myorders');
            }
        } else {
            redirect('buyer/myorders');
        }
    }

    function cancel_order() {

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

                    //added by Yogesh Pardeshi for inventory management 08082019
                    //Below we add the cancelled order product quantity to available quantity in order to maintain
                    //inventory automatically
                    //first get all the products from an order
                    $order_product = $this->Order_model->getOrderProducts($order_id);
                    //then for each product do the quantity update in table
                    foreach ($order_product as $product):
                        //added by Yogesh Pardeshi for inventory management 08082019
                        $quantity_cancelled = $product->products_quantity; //from order_id details
                        //here directly add the cancelled quantity to Table
                        //don't fetch available quantity first and then add cancelled quantity
                        //leave it on query to update it accordingly
                        $this->db->set('available_quantity', "available_quantity + $quantity_cancelled", FALSE)
                                ->where('id', $product->id)
                                ->update('product_details');


                        //after update available qty will increase by $quan
                        $now_available_qty = $product->available_quantity + $quantity_cancelled;

                        //added by Yogesh Pardeshi for inventory management
                        //notify buyer iff product available quantity is greater than 0
                        //so as to let them buy the product
                        if ($now_available_qty > 0) {
                            $notify_numbers = $this->Common_model->get_notify_list_buyers($product->id, 'phone');
                            $notify_emails = $this->Common_model->get_notify_list_buyers($product->id, 'email');
                            $sms_message = "Hurry Up! Product " . $product->products_name . " is available for shopping atzcart.com!";
                            if ($sms_message != "") {
                                $this->send_data->send_sms($sms_message, $notify_numbers);
                                $this->load->library('Common_email');
                                $this->common_email->send_custom_email("", $notify_emails, $sms_message, $sms_message);
                                //update buyer notify timestamp after sms sent
                                $this->Common_model->update_notify_list_buyer($product->id);
                            }
                        }

                    endforeach;
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

                    $this->order_cancel_notify($order_id, 0, 0);

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
        redirect('buyer/myorders');
    }

    function review_view() {
        $ret_id = $this->session->userdata("user_id");
        $products_id = $this->input->post('products_id');
        $myreview = $this->Myorders_model->product_review($ret_id, $products_id);

        $str = '';
        $str .= '<table class="table table-striped table-bordered nowrap dataTable">';
        $i = 1;
        foreach ($myreview as $re) {
            $not_rating = 5 - $re->reviews_rating;
            $rating = $re->reviews_rating;
            $str .= '<tr>';
            $str .= '<th>Review</th>';
            $str .= '<td>' . $re->review_text . '</td>';
            $str .= '</tr>';
            $str .= '<tr>';

            $str .= '<th>Rating</th>';
            $str .= '<td>';
            for ($i = 1; $i <= $rating; $i++) {
                $str .= '<span class="fa fa-star checked_star"></span>';
            }
            for ($i = 1; $i <= $not_rating; $i++) {
                $str .= '<span class="fa fa-star"></span>';
            }
            $str .= '</td>';

            $str .= '</tr>';
            $str .= '<tr>';
            $str .= '<th>Date Added</th>';
            $str .= '<td>' . $re->date_added . '</td>';
            $str .= '</tr>';
            $i++;
        }
        $str .= '</table>';
        echo $str;
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
        $empMsg = "#ORD" . $order_id . '! has been cancelled by buyer ' . $user_name;
        $empMobileNums = $this->getMobileNumbers();
        //iff empmobile are not assigned then don't send sms
        if (!empty($empMobileNums)) {
            //Send SMS to Employees Of ATZCART From admin
            $this->send_data->send_sms($empMsg, $empMobileNums);
        }

        if ($cancel == 1) {
            //Send SMS to Customer
            $msg = "Dear user, you have successfully cancelled your order #ORD" . $order_id . "! Your wallet will be credited with INR " . $amt . " within few hours.";
            $mob = $this->session->userdata("phone");
            $this->send_data->send_sms($msg, $user_phone);
            $email = $query->user_email_address;
            if (!empty($email)) {
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
            $msg = 'Your Cancel Request Sent Successfully against order #ORD' . $order_id . '! Shipping cost will be applicable against your cancelled order';
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

    public function remove_order($order_id) {
        $ord = $this->Myorders_model->single_order($order_id);
        if ($ord && $ord["orders_status"] == 8) {
            $this->Myorders_model->remove_order($order_id);
            $this->Myorders_model->remove_order_products($order_id);
            $this->Myorders_model->remove_order_history($order_id);
            $error = "<div class='alert alert-success alert-dismissible'>
                            <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                            <strong>Success !</strong> Order Removed!
                      </div>";
        } else {
            $error = "<div class='alert alert-success alert-dismissible'>
                            <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                            <strong>Success !</strong> Cancel Request Send Successfully !
                      </div>";
        }
        $this->session->set_flashdata("message", $error);
        redirect('buyer/myorders');
    }

    function get_order_track_details() {
        $ord_id = $this->input->post('ord');
        $ord = $this->Common_model->getAll('orders', array('orders_id' => $ord_id))->row();


        $phone = $ord->user_telephone;
        $user_id = $ord->user_id;
        $awb_number = $ord->awb_number;
        $str = '<table class="table table-striped" style="width:100%">';
        if ($awb_number != 0) {

            //check shippment
            $checkshipMethod = $this->Common_model->getAll("order_shipping", array('orders_id' => $ord_id))->row();

            if ($checkshipMethod->ship_vendor_id == 2) {
                $tracking=$this->shiprocket->track_shippment($checkshipMethod->shipment_id);
                
               // if()
                //echo'<pre>';
                //print_r($tracking['tracking_data']['shipment_track_activities']);
                if($tracking['tracking_data']['track_status']==1)
                {
                    foreach($tracking['tracking_data']['shipment_track_activities'] as $track_arr) {
                    $str .= '<tr>';
                        $str .= '<td>' . date("d M y h:i A",strtotime($track_arr["date"])) . '</td>';
                        $str .= '<td> ' . $track_arr["activity"] . ' at ' . $track_arr["location"] . '</td>';
                        $str .= '</tr>';
                    }
                    
                }else{
                     $str .= '<tr>';
                    $str .= '<td colspan="2">No Tracking Details Available</td>';
                    $str .= '</tr>';
                }
            } else {

                $this->shipping->latest_tracking_status($ord_id);

                //$url = "http://www.bluedart.com/servlet/RoutingServlet?handler=tnt&action=custawbquery&loginid=PNQ68152&awb=awb&numbers=53386678026&format=xml&lickey=shpfrizntrznsoenuinitepppenfhuun&verno=1.3&scan=1";
                $url = "http://www.bluedart.com/servlet/RoutingServlet?handler=tnt&action=custawbquery&loginid=PNQ68152&awb=awb&numbers=" . $awb_number . "&format=xml&lickey=shpfrizntrznsoenuinitepppenfhuun&verno=1.3&scan=1";


                $get = file_get_contents($url);

                $arr = simplexml_load_string($get);

                $sdate = $arr->Shipment->StatusDate;

                //echo $arr->Shipment->Scans;
                $new_arr = json_decode(json_encode($arr->Shipment->Scans));

                $track_array = (array_reverse($new_arr->ScanDetail));
                $dt = '';

                if (!empty($track_array)) {
                    foreach ($track_array as $track_arr) {
                        //echo'<pre>';
                        // print_r($track_arr);
                        // echo $track_arr->ScanCode . '<br>';

                        $DLdate = date('d M Y', strtotime($track_arr->ScanDate));
                        $DLtime = date('H:i:s', strtotime($track_arr->ScanTime));

                        //   echo $DLt = $DLdate . ' ' . $DLtime;
                        //  echo'<br>';
                        if ($dt != $DLdate) {
                            $str .= '<tr ><th colspan="2"><b>' . $DLdate . '</b></th></tr>';
                            $dt = $DLdate;
                        }
                        $str .= '<tr>';
                        $str .= '<td>' . $track_arr->ScanTime . '</td>';
                        $str .= '<td>Product In ' . $track_arr->Scan . ' at ' . $track_arr->ScannedLocation . '</td>';
                        $str .= '</tr>';
                    }
                } else {
                    $str .= '<tr>';
                    $str .= '<td colspan="2">No Tracking Details Available</td>';
                    $str .= '</tr>';
                }
            }
        } else {
            $str .= '<tr>';
            $str .= '<td colspan="2">No Tracking Details Available</td>';
            $str .= '</tr>';
        }
        $str .= '</table>';
        echo $str;
    }

    /**
     * @auther Yogesh Pardeshi 19072019 1036pm
     * Fetches contacts for sending sms_for = cancel orders
     * @return type comma seperated list of mobile numbers
     */
    private function getMobileNumbers() {
        $mobile_nums = $this->db->select('emp_mobile')->from('order_cancel_sms_emp_receiver')
                        ->where('sms_for', 'Order Cancel')
                        ->where('status', 'active')
                        ->get()->result_array();
        $numbers = "";
        foreach ($mobile_nums as $nums) {
            $numbers .= $nums['emp_mobile'] . ',';
        }
        return rtrim($numbers, ',');
    }

    function send_email($email, $title, $msg) {

        $buyer_email = $email;

        $data['msg'] = $msg;
        $data['title'] = $title;

        $from = $this->config->item("default_email_from");

        $to = $buyer_email;
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

    function finalOrderInvoice($order_id) {
        $data['orderDetails'] = $this->Order_model->getOrderDetailsByOrderId($order_id);
        $data['sorder'] = $this->Myorders_model->single_order($order_id);
        $this->load->view("user/orders/final_order_invoice", $data);
    }

}
