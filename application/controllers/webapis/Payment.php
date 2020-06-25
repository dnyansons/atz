<?php

defined('BASEPATH') OR exit('No direct script access allowed');

//require('MySoapClient.php');
use Firebase\JWT\JWT;

class Payment extends REST_Controller {

    private $_payload;

    public function __construct($config = 'rest') {
        parent::__construct($config);
//        $token = $this->input->get_request_header('Token');
//        try {
//            $this->_payload = JWT::decode($token, $this->config->item('jwt_secret_key'), array('HS256'));
//        } catch (Exception $ex) {
//            $output = array("status" => 0, "message" => $ex->getMessage());
//            $this->response($output, REST_Controller::HTTP_UNAUTHORIZED);
//        }
        $this->load->library('form_validation');
        $this->load->model('Order_model');
        $this->load->model('Product_model');
        $this->load->model('Users_model');
        $this->load->model('Common_model');
        $this->load->model('Categories_model');
        $this->load->library('Browser_notification');
        $this->load->library('Shipping');
        $this->load->library('Send_data');
        $this->load->model('Coupon_model');
        $this->load->model('Shipping_model');
        $this->load->model('Profile_model');
        $this->load->model('Myorders_model');
    }

    function getRSA_post() {

        $ws = $this->post('ws');

        if (empty($ws)) {
            $ws = "getRSA";
        }

        $output = [
            "ws" => $ws,
            "status" => 0,
            "message" => ""
        ];
        $user_data = $this->post("user_data");
        $merchant_data=$user_data;
        $user_id = $this->_payload->userid;
       // $order_id = $this->post("order_id");
        //$access_code = $this->post("access_code");

       
       $working_key='F01FEB197DF7A57851A8354B75C7FADC';//Shared by CCAVENUES
       //$data['access_code']='AVLT86GG37AJ33TLJA';//Shared by CCAVENUES
       
       //foreach ($_POST as $key => $value){
           //$merchant_data.=$key.'='.urlencode($value).'&';
      // }
       $this->load->library('crypto');
       // $CI = & get_instance();
       $encrypted_data=$this->crypto->encrypt($merchant_data,$working_key);
        // echo $result;
        $output["status"] = 1;
        $output["result"] = $encrypted_data;
        $output["message"] = "Success";
        //print_r($output);
        $this->response($output, REST_Controller::HTTP_OK);
    }

    public function success_post() 
    {
        if ($this->input->server("REQUEST_METHOD") !== 'POST') {
            show_error('Direct script access not allowed.!');
        }
        $this->load->library('crypto');

        $encResp = $_REQUEST['encResp'];
        if (isset($encResp)) {
            $working_key = 'F01FEB197DF7A57851A8354B75C7FADC';
            $decryptValues = explode('&', $this->crypto->decrypt($encResp, $working_key));
            $dataSize = sizeof($decryptValues);
            $order_status = '';
            $orders_id = '';
            $tracking_id = '';
            $order_amt = '';
            $paymnt_mode = '';
            $currency = '';
            /* CODE FOR GET YOUR VERIABLE WHEN REDIRECT ON YOUR URL */

            for ($i = 0; $i < $dataSize; $i++) {
                $information = explode('=', $decryptValues[$i]);

                if (trim($information[0]) === 'order_id') {
                    $orders_id = $information[1];
                }
                if (trim($information[0]) === 'tracking_id') {
                    $tracking_id = $information[1];
                }
                if (trim($information[0]) === 'order_status') {
                    $order_status = $information[1];
                }
                if (trim($information[0]) === 'amount') {
                    $order_amt = $information[1];
                }
                if (trim($information[0]) === 'payment_mode') {
                    $paymnt_mode = $information[1];
                }
                if (trim($information[0]) === 'currency') {
                    $currency = $information[1];
                }
                if (trim($information[0]) === 'trans_date') {
                    $trans_date = $information[1];
                }
                if (trim($information[0]) === 'merchant_param1') {
                    $user_id = $information[1];
                }
                if (trim($information[0]) === 'merchant_param2') {
                    $email_id = $information[1];
                }
                if (trim($information[0]) === 'merchant_param3') {
                    $phone_no = $information[1];
                }
            }


            $amt_to_pay = ($order_amt / 100); //From User

            
            $orderDetail = $this->Order_model->getBuyersOrderbyOrderID($orders_id);
            $pay_amount = round($orderDetail['grand_price'], 2); //From Database

            /* CHECK PAYMENT IS SUCCESS OR FAIL */
            if (trim($order_status) == 'Success' && $order_amt == $pay_amount) {

                /* DO what ever you want after successful payment */

                //Order Request
                $insertHistory['orders_id'] = $orders_id;
                $insertHistory['status'] = 16;
                $insertHistory['date_added'] = date('Y-m-d H:i:s');
                $insertHistory['comment'] = 'Order Accepted';
                $insertHistory['customer_notified'] = 1;
                $this->Common_model->insert('orders_history', $insertHistory);

                $updata['orders_status'] = 10;
                $updata['payment_method'] = $paymnt_mode;
                $up = $this->Common_model->update('orders', $updata, array('orders_id' => $orders_id, 'orders_status' => 8));

                if ($up) {
                    $this->addToVendorWallet($orders_id);
                    /* Redirecting Userorder to addToVendorWallet method */

                    $output["data"] = $this->Order_model->getBuyersOrderbyOrderID($orders_id);
                    $output["status"] = 1;
                    $output["message"] = "<div class='alert alert-success alert-dismissible'>
                                    <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                                    <strong>Success !</strong> Order Placed Successfully !
                                  </div>";

                    //Order History
                    $orderHistory['orders_id'] = $orders_id;
                    $orderHistory['status'] = 10;
                    $orderHistory['date_added'] = date('Y-m-d H:i:s');
                    $orderHistory['comment'] = 'Order in Processing !';

                    $this->Common_model->insert('orders_history', $orderHistory);

                    $orderDetails = $this->Order_model->getOrderDetailsByOrderId($orders_id);

                    $count = count($orderDetails);
                    $j = 0;
                    $pro_name = '';
                    $products_quantity = 0;

                    while ($j < $count) {
                        $pro_name = $orderDetails[$j]['product_name'] . ' ,';
                        // $products_quantity = $products_quantity + $orderDetails[$i]['products_quantity'];

                        $j++;
                    }

                    //Send SMS to Buyer

                    $message = 'Order Placed: Order Placed Successfully: Beautiful Set Of ' . $pro_name . ', Order ID- #ORD' . $orders_id . ' is Placed and Amount Received is Rs. ' . $pay_amount . '. You can Track the order on atzcart.com.';
                    $mob = $orderDetails['user_telephone'];

                    $this->send_data->send_sms($message, $mob);
                    //sms send to seller
                    $seller_mob = $orderDetails['pick_mobile'];
                    $message = 'You have a new order from buyer with order #ORD' . $orders_id . 'Please Visit ATZCart.com for further process.';
                    $this->send_data->send_sms($message, $seller_mob);

                    //Notify To Seller
                    $seller_id = $orderDetail['seller_id'];
                    $title = 'New Order';
                    $msg = " From " . $this->session->userdata('user_name') . ' with order #ORD' . $orders_id;
                    $tag = 'atzcart.com';
                    $this->browser_notification->notifyseller($seller_id, $title, $msg, $tag);

                    //insert in adminnotify table
                    $msg_buyer = "New Order Placed with order #ORD" . $orders_id . ' Click to track Order ';
                    $adminNotify = array(
                        'title' => 'New Order',
                        'msg' => $msg . ' ( Web ) ',
                        'type' => 'order_place',
                        'reference_id' => $orders_id,
                        'status' => 'Received'
                    );
                    $sellerNotify = array(
                        'title' => 'New Order',
                        'msg' => $msg,
                        'type' => 'order_place',
                        'reference_id' => $orders_id,
                        'status' => 'Received'
                    );
                    $buyerNotify = array(
                        'title' => 'New Order',
                        'msg' => $msg_buyer,
                        'user_id' => $user_id,
                        'type' => 'order_place',
                        'reference_id' => $orders_id,
                        'status' => 'Received'
                    );

                    //send Email
                    $this->send_email_order_placed($orders_id);


                    $insertAdminNotify = $this->Product_model->insertAdminNotify($adminNotify);
                    $insertSellerNotify = $this->Product_model->insertSellerNotify($sellerNotify);
                    $insertBuyerNotify = $this->Product_model->insertBuyerNotify($buyerNotify);

                    $this->browser_notification->notifyadmin('New Order Placed !', $msg, $tag);

                    $order = $this->Common_model->getAll("orders", ["orders_id" => $orders_id])->row();

                    $cart_prod = $this->Product_model->get_orderproduct($orders_id);
                    foreach ($cart_prod as $row) {
                        $prod_id[] = $row['products_id'];
                    }


                    $result = $this->Product_model->removeAllProductsOfOrder_id($user_id, $prod_id);
                    $msg = $orders_id;

                    $coupon = $this->Product_model->get_coupononproduct($orders_id);
                    foreach ($coupon as $row) {
                        $coupon_id[] = $row['coupon_id'];
                    }
                    $res = $this->Product_model->updatemycouponStatus($user_id, $coupon_id);

                    $this->session->set_flashdata('message', $msg);
                } else {

                    $msg = '<i class="fa fa-exclamation-triangle" aria-hidden="true"></i><div align="center" style="color: red;">

                                   <div id="login-error" class="form-error notice notice-error">
                                      <span class="icon-notice icon-error"></span>
                                      <span>Error ! Order Not Found !</span>
                                   </div>
                                </div>';
                    $this->session->set_flashdata('message', $msg);
                }
                $payData['payment_id'] = $tracking_id; //Tras Id
                $payData['user_id'] = $user_id;
                $payData['email'] = $email_id;
                $payData['contact'] = $phone_no;
                $payData['orders_id'] = $orders_id;
                $payData['amount'] = $order_amt;
                $payData['currency'] = $currency;
                $payData['status'] = $order_status;
                $payData['method'] = $paymnt_mode;
                $payData['platform'] = 'Web';
                $payData['payment_by'] = 'CCAVENUE';
                $payData['description'] = 'Order # ' . $orders_id;
                $payData['created_at'] = $trans_date;
                $up = $this->Common_model->insert('order_payment', $payData);
                $sdata = [
                    "status" => "Success",
                    "trans_id" => $tracking_id,
                    "amount" => $order_amt,
                    "order_id" => $order_amt,
                    "mode" => "CCAVENUE"
                ];
                $this->load->view("webviews/billdesksuccess",$sdata);
            } else {
                echo "Failure";
            }
            
        } else {
            echo "Aborted";
        } 
    }

    public function failed_post() 
    {
        echo "Failure";
    }
    
    public function addToVendorWallet($order_id) {
        $orderInfo = $this->Order_model->getOrderInfo($order_id);
        $this->load->model("Vendorwallet_model");
        $this->load->model("Vendorwallethistory_model");
        $this->Vendorwallet_model->creditVendorPendingWallet($orderInfo->seller_id, $orderInfo->vendor_payable_price);
        $wallet_history = [
            "vendor_id" => $orderInfo->seller_id,
            "order_id" => $order_id,
            "amount" => $orderInfo->vendor_payable_price,
            "status" => "pending",
            "type" => "credit",
            "remark" => "After order payment from mobile app!",
        ];
        $this->Vendorwallethistory_model->addHistory($wallet_history);
    }
    
    public function send_email_order_placed($order_id) {

        $dat = $this->Common_model->getAll('orders', array('orders_id' => $order_id))->row();

        $buyer_email = $dat->user_email_address;
        $seller_email = $dat->pick_email;

        $data['user_name'] = $dat->user_name;
        $data['pick_name'] = $dat->pick_name;
        $data['order_price'] = $dat->order_price;
        $data['shipping_cost'] = $dat->shipping_cost;
        $data['orders_id'] = $dat->orders_id;
        $data['order_desc'] = $this->Common_model->getAll('orders_products', array('orders_id' => $order_id))->result();

        $from = $this->config->item("default_email_from");

        $to = $buyer_email;
        $mesg = $this->load->view('emailtemplates/buyer_order', $data, true);
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
        $this->email->subject('Order Placed Successfully');
        $this->email->message($mesg);
        $this->email->send();

        //For Seller
        $to = $seller_email;
        $mesg2 = $this->load->view('emailtemplates/seller_order', $data, true);

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
        $this->email->subject('New Order Received !');
        $this->email->message($mesg2);
        $this->email->send();
    }
    
    public function check_get()
    {
        $data = [
            "status" => "Success",
            "trans_id" => "1234",
            "amount" => "1000"
        ];
        $this->load->view("webviews/billdesksuccess",$data);
    }

}
