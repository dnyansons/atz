<?php

defined('BASEPATH') OR exit('No direct script access allowed');

//require('MySoapClient.php');
class Userorder extends CI_Controller {

    public function __construct() {

        parent::__construct();

        $this->load->model("Users_model");
        $this->load->model("Common_model");
        $this->load->model("Order_model");
        $this->load->model("Shipping_model");
        $this->load->model('Product_model');
        $this->load->model("Categories_model");
        $this->load->model("Banners_model");
        $this->load->model("Rfqs_model");
        $this->load->model("Subscribers_model");
        $this->load->model('Order_model');
        $this->load->model('myfavourite_model');
        $this->load->model('Inquiries_model');
        $this->load->model('Wallet_model');
        $this->load->model('Offer_model');
        $this->load->library('Shipping');
        $this->load->library('Shiprocket');
        $this->load->library("get_header_data");
        $this->load->library('user_agent');
        $this->load->library('Send_data');
        $this->load->library('Browser_notification');
        $this->load->model("Affiliate_model");
        $this->load->library('awsupload');
    }

    function get_price() {
        $pro_id = $this->input->post('pro_id');
        $qty = $this->input->post('qty');
        if ($pro_id != '' && $qty > 0) {
            $min_qty_q = $this->Order_model->get_min_qty($pro_id);


            $min_qty = $min_qty_q['quantity_from'];

            if ($qty >= $min_qty) {
                $res = $this->Order_model->get_price($pro_id, $qty);

                echo number_format(($qty * $res['price']), 2);
            } else {
                echo 0;
            }
        } else {
            echo 0;
        }
    }

    function before_authenticate_order($orders_id) {
        if (!empty($orders_id)) {
            //Check Order Pending and applied with Coupon
            $check_order = $this->Order_model->check_order_with_coupon_applied($orders_id);
            if ($check_order == 0) {
                //Cross Verify Amount and Coupon Validity
                return 0; // all correct
            } elseif ($check_order == 1) {
                return 1; //Coupon Has been Expired ! Make Payment Again.
            } else {
                return 2;
            }
        }
    }

    function ship_order($order_id = 0) {
        //after deleting expired offer product from orders_products table redirect user to cart
        $deleteExpiredOfferProducts = $this->Offer_model->deleteExpiredOfferFromOrders($order_id);
        if ($deleteExpiredOfferProducts > 0) {
            $msg = '<div class="alert alert-danger alert-dismissible col-md-6 offset-3">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <strong>Info:</strong>Offer expired for some your products. </div>';

            $this->session->set_flashdata('success_msg', $msg);
            redirect(base_url('home_product/getCartProducts'));
        }

        if (!$this->session->userdata("user_logged_in")) {
            $error = "<div id='login-error' class='form-error notice notice-error'><span class='icon-notice icon-error'></span><span><strong>Error!</strong> Session timeout, relogin!. </span></div>";
            $this->session->set_flashdata("message", $error);
            redirect("login", "refresh");
        }

        $data["title"] = "ATZCart - Payment";

        if (!$this->checkBannedUser()) {
            //here we will check before payment wheather the user has been banned
            //iff banned will be logged out of account
            //Did this for excel row number 184 by vishal ....tester issue
            session_unset();
            $this->session->set_flashdata('message', 'Your account has been banned! Please contact support!');
            redirect("login", "refresh");
        }

        $user_id = $this->session->userdata("user_id");
        $data['bal'] = $this->Common_model->getAll('buyer_wallet', array('user_id' => $user_id))->row();
        //Get Latest Tracking Status//
        $ord = $this->Common_model->getAll('orders', array('orders_id' => $order_id))->row();
        $data['runningOffers'] = $this->Offer_model->getRunningOffers();
        if ($ord->user_id == $user_id) {

            $check = $this->before_authenticate_order($order_id);
            if ($check == 1) {
                redirect('userorder/ship_order/' . $order_id);
            }

            $check_order = $this->Order_model->check_accepted_order($order_id);
            $user_id = $this->session->userdata('user_id');
            
            if (count($check_order) > 0) {
                $order_detail = $check_order;

                $pro_id = $order_detail['products_id'];
                $unit_price = $this->Order_model->get_unit_price($pro_id);
                $pro_detail = $this->Order_model->get_product_detail($pro_id);

                $data['res'] = $pro_detail->row_array();
                $data['shippment_type'] = $ord->shippment_type;
                $data['order_dtail'] = $order_detail;

                $data['price_per'] = $unit_price->result_array();

                $data['quantity'] = $order_detail['products_quantity'];

                $data['qty_price_per'] = $order_detail['final_price'];


                $data['productinfo'] = 'Product Description';
                $data['txnid'] = time();
                $data['surl'] = site_url() . 'userorder/success';
                $data['furl'] = site_url() . 'userorder/failed';
              
                $data['key_id'] = RAZOR_KEY_ID;
                $data['currency_code'] = 'INR';
                $data['total'] = $order_detail['order_price'] * 100;
                $data['amount'] = $order_detail['order_price'];
                $data['merchant_order_id'] = $order_id;
                $data['card_holder_name'] = $order_detail['user_name'];
                $data['email'] = $this->session->userdata('user_email');
                $data['phone'] = $this->session->userdata('phone');
                $data['name'] = 'ATZ Cart';
                $data['return_url'] = site_url() . 'userorder/callback';

                if ($order_detail['orders_status'] == '17') {
                    //Rejected
                    $data['pending_order'] = 'Rejected';

                    $this->load->view('front/order/payment_process', $data);
                    $this->load->view('front/common/footer');
                } elseif ($order_detail['orders_status'] == '8') {

                    $data['productinfo'] = 'Product Description';
                    $data['txnid'] = time();
                    $data['surl'] = site_url() . 'userorder/success';
                    $data['furl'] = site_url() . 'userorder/failed';


                    $data['key_id'] = RAZOR_KEY_ID;
                    $data['currency_code'] = 'INR';
                    $data['total'] = $order_detail['order_price'] * 100;
                    $data['amount'] = $order_detail['order_price'];
                    $data['merchant_order_id'] = $order_id;
                    $data['card_holder_name'] = $order_detail['user_name'];
                    $data['email'] = $this->session->userdata('user_email');
                    $data['phone'] = $this->session->userdata('phone');
                    $data['name'] = 'ATZ Cart';
                    $data['return_url'] = site_url() . 'userorder/callback';
                    //Accepted
                    $data['pending_order'] = 'Accepted';
                    //Ship Address
                    $pr_details = $this->Order_model->getOrderDetails($order_id);

                    //if orders has a product which is out of stock then redirect user to all orders page
                    //in order to stop user from sending to payments page iff product quantity reaches to low stock
                    foreach ($pr_details as $order) {
                        $product_details = json_decode($order->product_specifications);
                        $total_quantity_shopped = $product_details->specifications[0]->specifications->total_quantity;
                        $low_stock = $this->Order_model->checkProductAvailQty($product_details->product_id, $total_quantity_shopped);
                        if ($low_stock == 0) {
                            $msg = "<div class='alert alert-danger alert-dismissible'>
									<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
									<strong>Info :</strong> " .
                                    $product_details->product_name . " product is out of stock! </div>";
                            $this->session->set_flashdata('message', $msg);
                            redirect(base_url('buyer-orders'));
                        }
                    }

                    $data['seller_info'] = $this->Product_model->getSellerInformation($pr_details[0]->seller_id);
                    $data['product_details'] = $pr_details;

                    $this->load->view('front/order/payment_process', $data);

                    //$this->load->view('front/order/payment', $data);
                    // $this->load->view('front/common/footer');
                } else {
                    $msg = '<div class=" clearfix">
                        <div id="notfound">
                           <div class="notfound">
                              <div class="notfound-404">
                                 <h1>Oops!!</h1>
                                 <h2>Error ! Order Not Found !</h2>
                              </div>
                              <a href="' . base_url() . '">Go TO Homepage</a>
                           </div>
                        </div>
                     </div>';
                    $this->session->set_flashdata('message', $msg);
                    redirect(base_url() . "userorder/atz_messgae");
                }
            } else {
                $msg = '<div class=" clearfix">
                        <div id="notfound">
                           <div class="notfound">
                              <div class="notfound-404">
                                 <h1>Hey!!</h1>
                                 <h2>Order has been Placed Successfully! Thank You..!!</h2>
                              </div>
                              <a href="' . base_url() . '">Go TO Homepage</a>
                           </div>
                        </div>
                     </div>';
                $this->session->set_flashdata('message', $msg);
                redirect(base_url() . "userorder/atz_messgae");
            }
        } else {
            $msg = '<div class=" clearfix">
                        <div id="notfound">
                           <div class="notfound">
                              <div class="notfound-404">
                                 <h1>Hey!!</h1>
                                 <h2>Somthing Wrong Related to Order..!!</h2>
                              </div>
                              <a href="' . base_url() . '">Go TO Homepage</a>
                           </div>
                        </div>
                     </div>';
            $this->session->set_flashdata('message', $msg);
            redirect(base_url() . "userorder/atz_messgae");
        }
    }

    public function callback() {

        if (!empty($this->input->post('razorpay_payment_id')) && !empty($this->input->post('merchant_order_id'))) {

            $wallet_option1 = $this->input->post('wallet_option1');
            $razorpay_payment_id = $this->input->post('razorpay_payment_id');

            $orders_id = $this->input->post('merchant_order_id');
            $user_id = $this->session->userdata('user_id');
            $data['bal'] = $this->Common_model->getAll('buyer_wallet', array('user_id' => $user_id))->row();
            ///////////////////////////////Payment Verify Start////////////////////
            $key_id = RAZOR_KEY_ID;
            $key_secret = RAZOR_KEY_SECRET;

            $url = 'https://api.razorpay.com/v1/payments/' . $razorpay_payment_id;
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_USERPWD, $key_id . ":" . $key_secret);
            $result = curl_exec($ch);
            curl_close($ch);
            if ($result) {
                //Order Detail
                $orderDetail = $this->Order_model->getBuyersOrderbyOrderID($orders_id);

                $resp = json_decode($result);
                //Response
                foreach ($resp as $value)
                    $array[] = $value;

                $pay_amount = round($orderDetail['grand_price'], 2); //From Database

                $amt_to_pay = ($array[2] / 100); //From User

                $pay_amount1 = 0;
                if ($wallet_option1 === 'checked' && $pay_amount >= $data['bal']->balance) {
                    $pay_amount1 = $pay_amount - $data['bal']->balance;
                    $wallet_option1 = $wallet_option1;
                    if ($pay_amount1 != $amt_to_pay) {
                        $msg = '<div class="alert alert-danger" role="alert">Somthing Went Wrong !</div>';
                        $this->session->set_flashdata('message', $msg);
                        redirect('userorder/ship_order/' . $orders_id);
                    }
                } else {
                    $pay_amount1 = round($orderDetail['grand_price'], 2); //From Database

                    if ($pay_amount1 != $amt_to_pay) {
                        $msg = '<div class="alert alert-danger" role="alert">Somthing Went Wrong1 !</div>';
                        $this->session->set_flashdata('message', $msg);
                        redirect('userorder/ship_order/' . $orders_id);
                    }
                }

                if ((trim($array[4]) == 'authorized') && (trim($pay_amount1) == trim($amt_to_pay))) {

                    //Order Request
                    $insertHistory['orders_id'] = $orders_id;
                    $insertHistory['status'] = 16;
                    $insertHistory['date_added'] = date('Y-m-d H:i:s');
                    $insertHistory['comment'] = 'Order Accepted';
                    $insertHistory['customer_notified'] = 1;
                    $this->Common_model->insert('orders_history', $insertHistory);

                    $updata['orders_status'] = 10;
                    $updata['payment_method'] = $array[8];
                    $updata['wallet_option'] = $wallet_option1;

                    $up = $this->Common_model->update('orders', $updata, array('orders_id' => $orders_id, 'orders_status' => 8));

                    //after a long discussion with vishal, dhananjay and shyam sir below happened
                    //Commented out as from now 08082019 quantity will be deducted from available_quantity
                    //on product processing or purchase i.e. after buyer makes successful payment of order
                    //so as to manage inventory and orders in a better way
                    //Here after update of order status i.e. processing from orders table; we will deduct
                    //all the products ordered quantity to available_quantity from product_details table
                    $order_product = $this->Order_model->getOrderProducts($orders_id);

                    foreach ($order_product as $product):
                        //added by Yogesh Pardeshi for inventory management 08082019
                        $quantity_bought = $product->products_quantity; //from order_id details
                        $this->db->set('available_quantity', "available_quantity - $quantity_bought", FALSE)
                                ->where('id', $product->id)
                                ->update('product_details');

                        //iff seller has opted out to be notified[notifyme = 1] and
                        // also track inventory = 1 on lower stock then
                        //system will send message about product
                        //added by Yogesh Pardeshi for inventory management
                        //notify seller iff product available quantity equals low stock quantity
                        //so as to make them replenish their product stocks
                        $notify_numbers = $this->Common_model->get_notify_list($product->id, 'phone');
                        //send sms only iff there exists at-least one mobile number
                        if ($notify_numbers != '') {
                            $sms_message = "Your product #PRD" . $product->id . " has reached to low stock quantity! Kindly replenish your stock";
                            $this->send_data->send_sms($sms_message, $notify_numbers);
                            // $this->session->set_userdata('sms_seller_numbers', $notify_numbers);
                        }
                    endforeach;
                    if ($up) {
                        $this->addToVendorWallet($orders_id);


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
                            $j++;
                        }

                        //Send SMS to Buyer
                        // $message = 'Order Placed Successfully ! Thank you for truly appreciating atzcart.com products.Your Order ID is #ORD'.$orders_id. '.  We are really delightful to serve you the products on your doorstep. Keep track of your product using this link atzcart.com. Write us on our helpline if you have any queries related to product or supplier or delivery.';
                        //$message = 'Order Placed: Your Order for Product ' . $pro_name . ' with Order ID- #ORD' . $orders_id . ' is placed and Rs.' . $pay_amount . ' has been received towards your order. We will let you know the Expected delivery date when your order is Packed by the Seller. We will keep you updated as and when your order is Packed/Shipped. You can manage your order at- www.atzcart.com.';
                        $message = 'Order Placed: Order Placed Successfully: Product ' . $pro_name . ', Order ID- #ORD' . $orders_id . ' is Placed and Amount Received is Rs. ' . $pay_amount . '. You can Track the order on atzcart.com.';
                        $mob = $orderDetail['user_telephone'];

                        $this->send_data->send_sms($message, $mob);

                        //sms send to seller
                        $seller_mob = $orderDetail['pick_mobile'];
                        $message = 'You have a new order from buyer ' . $this->session->userdata('user_name') . ' with order #ORD' . $orders_id . 'Please Visit ATZCart.com for further process.';
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
                } else {
                    $msg = '<i class="fa fa-exclamation-triangle" aria-hidden="true"></i><div align="center" style="color: red;">
                            <div id="login-error" class="form-error notice notice-error">
                                   <span class="icon-notice icon-error"></span>
                                   <span>Error ! Payment Failed !</span>
                            </div>
                        </div>';
                    $this->session->set_flashdata('message', $msg);
                }
                
             if ($wallet_option1 === 'checked' && $pay_amount >= $data['bal']->balance) {
                 
                  //Insert Payment Transaction
                $payData['payment_id'] = $array[0]; //Tras Id
                $payData['user_id'] = $user_id;
                $payData['email'] = $array[17];
                $payData['contact'] = $array[18];
                $payData['orders_id'] = $orders_id;
                $payData['amount'] = ($array[2] / 100);
                $payData['currency'] = $array[3];
                $payData['status'] = $array[4];
                $payData['method'] = 'wallet_'.$array[8];
                $payData['platform'] = 'Web';
                $payData['payment_by'] = 'razorpay';
                $payData['description'] = $array[12];
                $payData['created_at'] = $array[24];
                
             }        
             else
             {
                  //Insert Payment Transaction
                $payData['payment_id'] = $array[0]; //Tras Id
                $payData['user_id'] = $user_id;
                $payData['email'] = $array[17];
                $payData['contact'] = $array[18];
                $payData['orders_id'] = $orders_id;
                $payData['amount'] = ($array[2] / 100);
                $payData['currency'] = $array[3];
                $payData['status'] = $array[4];
                $payData['method'] = $array[8];
                $payData['platform'] = 'Web';
                $payData['payment_by'] = 'razorpay';
                $payData['description'] = $array[12];
                $payData['created_at'] = $array[24];
                
             }
               

                // affiliate marketing
                // if order placed from the affiliate network.
                // it will check for cookie if cookie exist, it will insert a record in affiliate table.
                // on the count of records in affiliate table, affiliate marketer will get commission.

                if (get_cookie('refcookie')) {
                    $refCookie = $this->input->cookie('refcookie', TRUE);
                    $affidata = array(
                        'OrderId' => $orders_id,
                        'RefId' => $refCookie,
                        'count' => 1
                    );
                    $result = $this->Affiliate_model->checkOrders($affidata);
                }

                $up = $this->Common_model->insert('order_payment', $payData);

                //Redirct to Page
                if ($msg > 0) {
                    redirect(base_url() . "userorder/atz_success");
                } else {
                    redirect(base_url() . "userorder/atz_messgae");
                }
            } else {
                $msg = '<i class="fa fa-exclamation-triangle" aria-hidden="true"></i><div align="center" style="color: red;">
                        <div id="login-error" class="form-error notice notice-error">
                               <span class="icon-notice icon-error"></span>
                               <span>Error ! Order Failed!</span>
                        </div>
                    </div>';
                $this->session->set_flashdata('message', $msg);
                redirect(base_url() . "userorder/atz_messgae");
            }
        } else {
            $msg = '<i class="fa fa-exclamation-triangle" aria-hidden="true"></i><div align="center" style="color: red;">
                    <div id="login-error" class="form-error notice notice-error">
                           <span class="icon-notice icon-error"></span>
                           <span>Error ! An error occured. Please Contact site administrator !</span>
                    </div>
                </div>';
            $this->session->set_flashdata('message', $msg);
            redirect(base_url() . "userorder/atz_messgae");
        }
    }

    function pickupregister($orders_id = 0) {
        //Get Order
        $orderDetails = $this->Order_model->getOrderDetailsById($orders_id);

        $order_product = $this->Order_model->getOrderProducts($orders_id);

        //get Area Code
        $areaCode_q = $this->Common_model->getAll('order_accepted_dimention', array('orders_id' => $orders_id))->row_array();
        $areaCode = $areaCode_q['pick_area_code'];
        $pick_id = $areaCode_q['pick_id'];


        $quantity = 0;
        $actual_order_price = 0;
        foreach ($order_product as $product):
            $quantity = $quantity + $product->products_quantity;
            $actual_order_price = $actual_order_price + $product->grand_price;
        endforeach;


        //Expected Time Calculation
        $curr_date = date('Y-m-d');
        $pick_date = date('Y-m-d', strtotime($curr_date . ' + 2 day'));

        $exp_time = $this->shipping->calculate_expected_time($orders_id, $pick_id, $pick_date);

        $additional_days = $exp_time['GetDomesticTransitTimeForPinCodeandProductResult']['AdditionalDays'] . ' ' . 'days';

        $exp_date = $exp_time['GetDomesticTransitTimeForPinCodeandProductResult']['ExpectedDateDelivery'];

        $shipping_expected_date = date('Y-m-d', strtotime($exp_date . ' +' . $additional_days . ''));

        //Days Difference between pick up and delivery date
        $date1 = strtotime($pick_date);
        $date2 = strtotime($shipping_expected_date);
        $datediff = $date2 - $date1;

        $ship_date['ex_shipping_days'] = abs(round($datediff / (60 * 60 * 24)));
        $ship_date['shipping_start_date'] = $pick_date;
        $ship_date['delivery_date'] = $shipping_expected_date;


        $this->Common_model->update('orders', $ship_date, array('orders_id' => $orders_id));


        $paddress = $this->Common_model->getAll('seller_pick_address', array('pick_id' => $pick_id))->row_array();


        $total_weight = $quantity * $areaCode_q['weight_per_unit'];

        //Order Pick Up Registration

        $pickData['AreaCode'] = $areaCode;
        $pickData['ContactPersonName'] = $orderDetails->pick_name;
        $pickData['CustomerAddress1'] = $orderDetails->pick_addr_type;
        $pickData['CustomerAddress2'] = substr($paddress['address'], 25);
        $pickData['CustomerAddress3'] = $orderDetails->pick_state;
        $pickData['CustomerCode'] = CustomerCode;
        $pickData['CustomerName'] = $orderDetails->pick_name;
        $pickData['CustomerPincode'] = $orderDetails->pick_pincode;
        $pickData['CustomerTelephoneNumber'] = $orderDetails->pick_mobile;
        $pickData['DoxNDox'] = '1';
        $pickData['EmailID'] = $orderDetails->pick_email;
        $pickData['MobileTelNo'] = $orderDetails->pick_mobile;
        $pickData['NumberofPieces'] = $quantity;
        $pickData['OfficeCloseTime'] = $paddress['office_close'];
        $pickData['ProductCode'] = 'E';
        $pickData['ReferenceNo'] = '123456';
        $pickData['Remarks'] = 'ATZ CART';
        $pickData['RouteCode'] = '99';
        $pickData['ShipmentPickupDate'] = $pick_date;
        $pickData['ShipmentPickupTime'] = date('H:i');
        $pickData['VolumeWeight'] = $total_weight;
        $pickData['WeightofShipment'] = $total_weight;
        if ($areaCode == 'PNQ') {
            $pickData['isToPayShipper'] = 'N';
        } else {
            $pickData['isToPayShipper'] = 'Y';
        }

        //From Api Pick Up Registration and Way Billl Generation

        $token_no = $this->shipping->pickupRegistration($pickData);
        //exit;
        if (!empty($token_no)) {
            $dat['order_token_number'] = $token_no;
            $this->Common_model->update('orders', $dat, array('orders_id' => $orders_id));
        }
    }

    function atz_messgae() {

        if ($this->session->flashdata('message')) {
            $data = $this->get_header_data->get_categories();
            $this->load->view('front/common/header', $data);
            $this->load->view('front/error_page');
            $this->load->view('front/common/footer');
        } else {
            redirect('/');
        }
    }

    function atz_success() {
        $data = $this->get_header_data->get_categories();

        $order_id = $this->session->flashdata('message');

        if (!empty($order_id)) {

            $check_order = $this->Order_model->check_accepted_order($order_id);
            $payment_order = $this->Order_model->getPaymentDetail($order_id);
            
            $user_id = $this->session->userdata('user_id');
            $data['bal'] = $this->Common_model->getAll('buyer_wallet', array('user_id' => $user_id))->row();

           if (count($check_order) > 0) {
                $order_detail = $check_order;
                //$order_detail = $check_order->row_array();

                $pro_id = $order_detail['products_id'];
                $unit_price = $this->Order_model->get_unit_price($pro_id);
                $pro_detail = $this->Order_model->get_product_detail($pro_id);

                $data['res'] = $pro_detail->row_array();
                $data['order_dtail'] = $order_detail;
                $data['price_per'] = $unit_price->result_array();

                $data['quantity'] = $order_detail['products_quantity'];
                $data['price'] = $order_detail['order_price'];


                $data['qty_price_per'] = $order_detail['final_price'];
                $data['order'] = $order_detail['order_from'];
                $data['wallet_option'] = $order_detail['wallet_option'];

                /*
                  update wallet amount
                 */

                $productPrice = $this->Product_model->getProductPriceForQuantity($pro_id, $data['quantity']);
                $unit_price = $productPrice->final_price;
                $tot_price = $productPrice->final_price * $total_quantity;

                if ($data['wallet_option'] === 'checked' && (int) $data['price'] >= (int) $data['bal']->balance) {
                    $wallet_amount = 0.00;
                    $update_wallet_amt = (int) $data['price'] - (int) $data['bal']->balance;

                    $UpdateWalletResult = $this->Wallet_model->update_wallet_amount($data['bal']->id, $wallet_amount);

                    if ($UpdateWalletResult > 0) {
                        $wallet_history['buyer_id'] = $data['bal']->user_id;
                        $wallet_history['amount'] = $data['bal']->balance;
                        $wallet_history['previous_amount'] = $data['bal']->balance;
                        $wallet_history['current_amount'] = $wallet_amount;
                        $wallet_history['transaction_type'] = 'debit';
                        $wallet_history['against'] = 'withdraw';
                        $wallet_history['referrence'] = '#' . $order_id;
                        $wallet_history['remark'] = 'Amount withdraw to wallet against Order #' . $order_id;
                        
                    $this->Wallet_model->add_wallet_history($wallet_history);

                        $message = 'Order Placed: Order Placed Successfully: Order ID- #ORD' . $order_id . ' is Placed and Amount Received is From Wallet Rs. ' . $data['bal']->balance . '. You can Track the order on atzcart.com.';
                        $mob = $order_detail['user_telephone'];

                        $this->send_data->send_sms($message, $mob);
                    }
                } else if (trim($data['order']) == 'Cart') {
                    $product_price = 0;
                    foreach ($order_detail as $key => $value) {

                        $product_price += $value['order_price'];
                    }
                    if ($data['wallet_option'] === 'checked' && (int) $product_price >= (int) $data['bal']->balance) {
                        $wallet_amount = 0.00;

                        $UpdateWalletResult = $this->Wallet_model->update_wallet_amount($data['bal']->id, $wallet_amount);

                        if ($UpdateWalletResult > 0) {
                            $wallet_history['buyer_id'] = $data['bal']->user_id;
                            $wallet_history['amount'] = $data['bal']->balance;
                            $wallet_history['previous_amount'] = $data['bal']->balance;
                            $wallet_history['current_amount'] = $wallet_amount;
                            $wallet_history['transaction_type'] = 'debit';
                            $wallet_history['against'] = 'withdraw';
                            $wallet_history['referrence'] = '#' . $order_id;
                            $wallet_history['remark'] = 'Amount withdraw to wallet against Order #' . $order_id;

                            $this->Wallet_model->add_wallet_history($wallet_history);

                            $message = 'Order Placed: Order Placed Successfully: The Product Of ' . $pro_name . ', Order ID- #ORD' . $order_id . ' is Placed and Amount Received is From Wallet Rs. ' . $data['bal']->balance . '. You can Track the order on atzcart.com.';
                            $mob = $order_detail['user_telephone'];

                            $this->send_data->send_sms($message, $mob);
                        }
                    }
                }

                if ($order_detail['orders_status'] == '17') {
                    //Rejected
                    $data['pending_order'] = 'Rejected';

                    $this->load->view('front/order/payment', $data);
                    $this->load->view('front/common/footer');
                } elseif ($order_detail['orders_status'] == 10) {

                    $pr_details = $this->Order_model->getOrderDetails($order_id);
                    $py_details = $this->Order_model->getPaymentDetail($order_id);

                    $data['seller_info'] = $this->Product_model->getSellerInformation($pr_details[0]->seller_id);
                    $data['product_details'] = $pr_details;
                    $data['payment_details'] = $py_details;
                    $data['orders_id'] = $order_id;

                    $this->load->view('front/common/header', $data);
                    $this->load->view('front/order/order_success', $data);
                    $this->load->view('front/common/footer');
                } else {
                    $msg = '<div class=" clearfix">
                        <div id="notfound">
                           <div class="notfound">
                              <div class="notfound-404">
                                 <h1>OOPS!!</h1>
                                 <h2>Error ! Order Not Found !</h2>
                              </div>
                              <a href="' . base_url() . '">Go TO Homepage</a>
                           </div>
                        </div>
                     </div>';
                    $this->session->set_flashdata('message', $msg);
                    redirect(base_url() . "userorder/atz_messgae");
                }
            } else {
                $msg = '<div class=" clearfix">
                        <div id="notfound">
                           <div class="">
                              <div class="notfound-404">
                                 <h1>OOPS!!</h1>
                                 <h2>Error ! User Or Product not found try another !</h2>
                              </div>
                              <a href="' . base_url() . '">Go TO Homepage</a>
                           </div>
                        </div>
                     </div>';
                $this->session->set_flashdata('message', $msg);
                   redirect(base_url() . "userorder/atz_messgae");
            }
        } else {

            $msg = '<div class=" clearfix">
                        <div id="notfound">
                           <div class="">
                              <div class="notfound-404">
                                 <h1>OOPS!!</h1>
                                 <h2>Error ! User Or Product not found try another !</h2>
                              </div>
                              <a href="' . base_url() . '">Go TO Homepage</a>
                           </div>
                        </div>
                     </div>';
            $this->session->set_flashdata('message', $msg);
             redirect(base_url() . "userorder/atz_messgae");
        }
    }

    public function atz_success_wallet($order_id = 0) {
        /*
          Update Wallet Amount
         */
        if ($order_id == '') {
            show_error("Please Provide Valid Order Identification.!");
        }

        $data = $this->get_header_data->get_categories();
        $check_wallet = $this->session->userdata('check_wallet_option');
        $wallet_amount = $this->session->userdata('update_wallet_amount');
        $email_id = $this->session->userdata('user_email');
        $phone_no = $this->session->userdata('phone');
        $user_id = $this->session->userdata('user_id');

        if (!empty($order_id)) {
            $check_order = $this->Order_model->check_accepted_order($order_id);
            $user_id = $this->session->userdata('user_id');
            $data['bal'] = $this->Common_model->getAll('buyer_wallet', array('user_id' => $user_id))->row();

              if (count($check_order) > 0) {
                $order_detail = $check_order;
//                $order_detail = $check_order->row_array();
                $pro_id = $order_detail['products_id'];
                $unit_price = $this->Order_model->get_unit_price($pro_id);
                $pro_detail = $this->Order_model->get_product_detail($pro_id);

                $data['res'] = $pro_detail->row_array();
                $data['order_dtail'] = $order_detail;
                $data['price_per'] = $unit_price->result_array();

                $data['quantity'] = $order_detail['products_quantity'];

                $data['qty_price_per'] = $order_detail['final_price'];


                $data['order'] = $order_detail['order_from'];
                $order_price = $order_detail['order_price'];
                $data['wallet'] = $order_detail['wallet_option'];

                $receivedwalletAmount = 0;
                $UpdateWalletResult = 0;

                if ($data['order'] === 'Start_order') {
                    $receivedwalletAmount = $order_detail['final_price'] + $order_detail['shipping_cost'];
                } else if ($data['order'] === 'Cart') {
                    $receivedwalletAmount += $order_detail['final_price'] + $order_detail['shipping_cost'];
                }

                if ((int) $data['bal']->balance >= (int) $order_price) {
                    $update_wallet_amt = (int) $data['bal']->balance - (int) $order_price;
                    $UpdateWalletResult = $this->Wallet_model->update_wallet_amount($data['bal']->id, round($update_wallet_amt, 2));
                } else {
                    $msg = '<div class="alert alert-danger" role="alert">Something Went Wrong! Invalid Wallet Amount.! </div>';
                    $this->session->set_flashdata('message', $msg);
                    redirect('userorder/ship_order/' . $order_id);
                }
                if ($UpdateWalletResult > 0) {
                    $wallet_history['buyer_id'] = $data['bal']->user_id;
                    $wallet_history['amount'] = round($order_price, 2);
                    $wallet_history['amount'] = round($order_price, 2);
                    $wallet_history['previous_amount'] = $data['bal']->balance;
                    $wallet_history['current_amount'] = round($wallet_amount, 2);
                    $wallet_history['transaction_type'] = 'debit';
                    $wallet_history['against'] = 'withdraw';
                    $wallet_history['referrence'] = '#ORD' . $order_id;
                    $wallet_history['remark'] = 'Amount withdraw to wallet against Order #' . $order_id;

                    $this->Wallet_model->add_wallet_history($wallet_history);

                    //change available_quantity in product_details table
                    $this->Order_model->reduceProductQty($order_id);

                    $message = 'Order Placed: Order Placed Successfully: Order ID- #ORD' . $order_id . ' is Placed and Amount is Received From Wallet Rs. ' . round($receivedwalletAmount, 2) . '. You can Track the order on atzcart.com.';
                    $mob = $order_detail['user_telephone'];

                    $this->send_data->send_sms($message, $mob);

                    //sms send to seller
                    $seller_mob = $order_detail['pick_mobile'];
                    $message = 'You have a new order from buyer ' . $this->session->userdata('user_name') . ' with order #ORD' . $order_id . 'Please Visit ATZCart.com for further process.';
                    $this->send_data->send_sms($message, $seller_mob);


                    //Notify To Seller
                    $seller_id = $order_detail['seller_id'];
                    $title = 'New Order';
                    $msg = " From " . $this->session->userdata('user_name') . ' with order #ORD' . $order_id;
                    $tag = 'atzcart.com';
                    $this->browser_notification->notifyseller($seller_id, $title, $msg, $tag);

                    //insert in adminnotify table
                    $msg_buyer = "New Order Placed with order #ORD" . $order_id . ' Click to track Order ';
                    $adminNotify = array(
                        'title' => 'New Order',
                        'msg' => $msg . ' ( Web ) ',
                        'type' => 'order_place',
                        'reference_id' => $order_id,
                        'status' => 'Received'
                    );
                    $sellerNotify = array(
                        'title' => 'New Order',
                        'msg' => $msg,
                        'type' => 'order_place',
                        'reference_id' => $order_id,
                        'status' => 'Received'
                    );
                    $buyerNotify = array(
                        'title' => 'New Order',
                        'msg' => $msg_buyer,
                        'user_id' => $user_id,
                        'type' => 'order_place',
                        'reference_id' => $order_id,
                        'status' => 'Received'
                    );

                    //send Email
                    $this->send_email_order_placed($order_id);

                    $insertAdminNotify = $this->Product_model->insertAdminNotify($adminNotify);
                    $insertSellerNotify = $this->Product_model->insertSellerNotify($sellerNotify);
                    $insertBuyerNotify = $this->Product_model->insertBuyerNotify($buyerNotify);

                    $this->browser_notification->notifyadmin('New Order Placed !', $msg, $tag);

                    $order = $this->Common_model->getAll("orders", ["orders_id" => $order_id])->row();

                    $cart_prod = $this->Product_model->get_orderproduct($order_id);
                    foreach ($cart_prod as $row) {
                        $prod_id[] = $row['products_id'];
                    }

                    $result = $this->Product_model->removeAllProductsOfOrder_id($user_id, $prod_id);
                    $msg = $order_id;

                    $coupon = $this->Product_model->get_coupononproduct($order_id);
                    foreach ($coupon as $row) {
                        $coupon_id[] = $row['coupon_id'];
                    }
                    $res = $this->Product_model->updatemycouponStatus($user_id, $coupon_id);

                    $this->session->set_flashdata('message', $msg);

                    //Insert Payment Transaction
                    $payData['payment_id'] = time(); //Tras Id
                    $payData['user_id'] = $user_id;
                    $payData['email'] = $email_id;
                    $payData['contact'] = $phone_no;
                    $payData['orders_id'] = $order_id;
                    $payData['amount'] = round($order_price, 2);
                    $payData['currency'] = 'INR';
                    $payData['status'] = 'success';
                    $payData['method'] = 'atz_wallet';
                    $payData['platform'] = 'Web';
                    $payData['payment_by'] = 'wallet';
                    $payData['description'] = 'Order # ' . $order_id;
                    $payData['created_at'] = date('Y-m-d H:i:s');

                    // affiliate marketing
                    // if order placed from the affiliate network.
                    // it will check for cookie if cookie exist, it will insert a record in affiliate table.
                    // on the count of records in affiliate table, affiliate marketer will get commission.

                    if (get_cookie('refcookie')) {
                        $refCookie = $this->input->cookie('refcookie', TRUE);
                        $affidata = array(
                            'OrderId' => $order_id,
                            'RefId' => $refCookie,
                            'count' => 1
                        );

                        $result = $this->Affiliate_model->checkOrders($affidata);
                    }

                    $up = $this->Common_model->insert('order_payment', $payData);

                    $updata['orders_status'] = 10;
                    $updata['payment_method'] = 'wallet';
                    $update_order = $this->Common_model->update('orders', $updata, array('orders_id' => $order_id, 'orders_status' => 8));

                    if ($order_detail['orders_status'] == '17') {
                        //Rejected
                        $data['pending_order'] = 'Rejected';

                        $this->load->view('front/order/payment', $data);
                        $this->load->view('front/common/footer');
                    } {

                        $pr_details = $this->Order_model->getOrderDetails($order_id);
                        $py_details = $this->Order_model->getPaymentDetail($order_id);

                        $data['seller_info'] = $this->Product_model->getSellerInformation($pr_details[0]->seller_id);
                        $data['product_details'] = $pr_details;
                        $data['payment_details'] = $py_details;

                        $data['orders_id'] = $order_id;

                        $this->load->view('front/common/header', $data);
                        $this->load->view('front/order/order_success', $data);
                        $this->load->view('front/common/footer');
                    }
                }
            } else {
                $msg = '<div class=" clearfix">
                    <div id="notfound">
                       <div class="notfound">
                          <div class="notfound-404">
                             <h1>OOPS!!</h1>
                             <h2>Error ! Order Not Found !</h2>
                          </div>
                          <a href="' . base_url() . '">Go TO Homepage</a>
                       </div>
                    </div>
                 </div>';
                $this->session->set_flashdata('message', $msg);
                redirect(base_url() . "userorder/atz_success_wallet/" . $order_id);
            }
        } else {
            $msg = '<div class=" clearfix">
                    <div id="notfound">
                       <div class="notfound">
                          <div class="notfound-404">
                             <h1>OOPS!!</h1>
                             <h2>Error ! Order Not Found !</h2>
                          </div>
                          <a href="' . base_url() . '">Go TO Homepage</a>
                       </div>
                    </div>
                 </div>';
            $this->session->set_flashdata('message', $msg);
            redirect(base_url() . "userorder/atz_success_wallet/" . $order_id);
        }
    }

    //Send OTP Function
    function send_sms($message, $mob) {
        if ($mob > 0) {
            $msg = urlencode($message);
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, "http://sms.smslab.in/api/sendhttp.php?authkey=271209AqkMbb4pSiXR5ca89dc7&mobiles=" . $mob . "&message=" . $msg . "&new&mobile&sender=ATZCRT&route=4");
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            $res = curl_exec($ch);
            curl_close($ch);
        }
    }

    function sons() {
        $arr = $this->shipping->tracking();
    }

    function sons2() {
        $url = "http://www.bluedart.com/servlet/RoutingServlet?handler=tnt&action=custawbquery&loginid=" . LoginID . "&awb=awb&numbers=20077210624&format=html&lickey=" . LicenceKey . "&verno=1.3&scan=1";

        echo $data = file_get_contents($url);
    }

    public function startOrder() {
        $product_id = $this->input->post('product_id');
        $offer_id = $this->input->post('offer_id');
        $t_quantity = $this->input->post('t_quantity');
        $products_detail = $this->Product_model->getProductfullDetails($product_id);

        $arr['product_id'] = $product_id;
        $arr['offer_id'] = $offer_id;
        $arr['product_name'] = $products_detail['name'];
        $arr['product_image'] = $products_detail['images'][0];

        $arr['supplierDetails'] = $products_detail['first_name'] . ' ' . $products_detail['last_name'] . ' ' . $products_detail['company_name'];
        $arr['seller'] = $products_detail['seller'];
        $arr['sellername'] = $products_detail['first_name'] . ' ' . $products_detail['last_name'];
        $arr['companyname'] = $products_detail['company_name'];
        $arr['businesstype'] = $products_detail['business_type'];
        $arr['email'] = $products_detail['email'];
        $arr['phone'] = $products_detail['phone'];
        $arr['countryname'] = $products_detail['country_name'];
        $arr['address'] = $products_detail['comp_operational_addr'] . ' ' . $products_detail['comp_operational_city'] . ' ' . $products_detail['comp_operational_state'];

        $productPrice = $this->Product_model->getProductPriceForQuantity($product_id, $t_quantity);
        $unit_price = $productPrice->final_price;

//        if($offer_id != 0 || $offer_id != NULL) {
//            $offerDetails = $this->Offer_model->getOfferDetailsForOfferId($offer_id);
//            $offerRunningStatus = $this->Offer_model->checkOfferValidity(
//                                                    $offerDetails['offer_start_time'],
//                                                    $offerDetails['offer_end_time'],
//                                                    $offerDetails['status']);
//
//            if($offerRunningStatus == true) {
//                $unit_price = $productPrice->atz_price;
//                if(strtolower($offerDetails['offer_type']) == 'flat') {
//                    $unit_price = $unit_price - $offerDetails['offer_discount_value'];
//                    $tot_price = $unit_price * $total_quantity;
//                }
//                if(strtolower($data['product']['offer_type']) == 'percentage') {
//                    $unit_price = $unit_price - ($unit_price * $offerDetails['offer_discount_value'] * 0.01);
//                    $tot_price = $unit_price * $total_quantity;
//                }
//            }
//        }

        $specifications = $this->input->post('tempList');

        $offerDetails = $this->Offer_model->getProductOfferPrice($product_id, $t_quantity);

        for ($i = 0; $i < count($specifications); $i++) {
            if ($offerDetails['offer_id'] != 0 || $offerDetails['offer_id'] != NULL) {
                if (strtolower($offerDetails['offer_type']) == 'flat') {
                    $unit_price = $offerDetails['atz_price'] - $offerDetails['discount_value'];
                }
                if (strtolower($offerDetails['offer_type']) == 'percentage') {
                    $unit_price = $offerDetails['atz_price'] - ($offerDetails['atz_price'] * $offerDetails['discount_value'] * 0.01);
                }
            }
            $specifications[$i]['specifications']['unit_price'] = $unit_price;
            $specifications[$i]['specifications']['total_quantity'] = $t_quantity;
        }

        $arr['specifications'] = $specifications;
        $sess_arr = ["data" => $arr];
        $this->session->set_userdata($sess_arr);

        $output = ['status' => 1];
        $this->output->set_output(json_encode($output));
    }

    public function proceed_start_order() {

        $username = $this->session->userdata('user_name');
        $user_id = $this->session->userdata('user_id');
        $user_role = $this->session->userdata('user_role');
        $data['bal'] = $this->Common_model->getAll('buyer_wallet', array('user_id' => $user_id))->row();


        if ($user_role == 'buyer') {
            if ($username) {
                //get Shipping Method
                $ship_method = $this->send_data->get_shipping_method();

                $this->load->library("form_validation");
                $this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>');
                $this->form_validation->set_rules("shipp_addr", "shipping Address", "required");
                if ($this->form_validation->run() === false) {

                    $data["title"] = "ATZCart - Start Order";
                    $data['sess_data'] = $this->session->userdata('data');
                    $user_addr = $this->Common_model->getAll('address_book', array('user_id' => $user_id), array('address_book_id' => 'desc'))->result_array();
                    $product_id = $data['sess_data']['product_id'];
                    $total_quantity = $data['sess_data']['specifications'][0]['specifications']['secondary']
                            [0]['quantity'];
                    $offer_id = $data['sess_data']['offer_id'];
                    $productData = $this->Product_model->getProductData($product_id,
                            $offer_id, $total_quantity);
                    $data['product_data'] = $productData;

                    $data['user_addr'] = $user_addr;
                    if (empty($data['sess_data'])) {
                        redirect(base_url());
                    }
                    // check returnable from seller
                    $check_r = $this->Common_model->getAll('product_details', array('id' => $data['sess_data']['product_id']))->row();

                    $ch_returnable = $check_r->is_product_returnable;
                    if (empty($ch_returnable)) {
                        $ch_returnable = 'TRUE';
                    }
                    $data['ch_returnable'] = $ch_returnable;

                    $chech_shipp = $this->Common_model->getAll('shipping_vendor', array('id' => $ship_method))->row();
                    //Check Shipping Status
                    $data['shipping_type'] = $chech_shipp->shipping_type;
                    $this->load->view('front/order/proceed_order', $data);
                } else {

                    $product_id = $this->input->post('product_id');
                    $total_quantity = $this->input->post('total_quantity');

                    $check_wallet_val = $this->input->post('chk_wallet_val');
                    $wallet_balance = $this->input->post('wallet_amount');
                    $productPrice = $this->Product_model->getProductPriceForQuantity($product_id, $total_quantity);
                    $unit_price = 0;
                    $unit_price = $productPrice->final_price;
                    $tot_price = $productPrice->final_price * $total_quantity;

                    $offer_id = $this->session->userdata('data')['offer_id'];

                    if ($offer_id != 0 || $offer_id != NULL) {
                        $offerDetails = $this->Offer_model->getOfferDetailsForOfferId($offer_id);
                        $offerRunningStatus = $this->Offer_model->checkOfferValidity(
                                $offerDetails['offer_start_time'], $offerDetails['offer_end_time'], $offerDetails['status']);
                        if ($offerRunningStatus == true) {
                            $unit_price = $productPrice->atz_price;
                            if (strtolower($offerDetails['offer_type']) == 'flat') {
                                $unit_price = $unit_price - $offerDetails['offer_discount_value'];
                                $tot_price = $unit_price * $total_quantity;
                            }
                            if (strtolower($data['product']['offer_type']) == 'percentage') {
                                $unit_price = $unit_price - ($unit_price * $offerDetails['offer_discount_value'] * 0.01);
                                $tot_price = $unit_price * $total_quantity;
                            }
                        }
                    }


                    $product_name = $productPrice->name;

                    $seller_id = $productPrice->seller;

                    $coupon_id = $this->input->post('coupon_id');

                    if ($coupon_id != 0) {
                        $check_coupon = $this->Product_model->checkValidCoupon($coupon_id, $product_id);
                        if ($check_coupon > 0) {
                            $checkUsedcoupon = $this->Product_model->checkWhetherUsed($coupon_id, $user_id, $product_id);
                            if ($checkUsedcoupon) {
                                $msg = '<div class="alert alert-danger" role="alert">Something Went Wrong! Invalid Coupon </div>';
                                $this->session->set_flashdata('message', $msg);
                                redirect('userorder/proceed_start_order');
                            } else {
                                $cpn = array(
                                    'user_id' => $user_id,
                                    'coupon_id' => $coupon_id,
                                    'status' => 'GET'
                                );
                                $coupon = $this->Product_model->updateMyCoupon($cpn);
                            }
                        } else {

                            $msg = '<div class="alert alert-danger" role="alert">Something Went Wrong! Invalid Coupon </div>';
                            $this->session->set_flashdata('message', $msg);
                            redirect('userorder/proceed_start_order');
                        }
                    }

                    if ($offer_id == 0) {
                        $ch_prod_price = $this->Shipping_model->get_qty_wise_product_rate($product_id, $total_quantity);
                    }


                    if ($offer_id != 0 && $offer_id != NULL) {
                         $ch_prod_price = $this->Shipping_model->get_qty_wise_product_offer_rate($product_id, $total_quantity);
                        if ($offerRunningStatus == true) {
                            if (strtolower($offerDetails['offer_type']) == 'flat') {
                                $ch_prod_price = $ch_prod_price - $offerDetails['offer_discount_value'];
                                $tot_price = $ch_prod_price * $total_quantity;
                            }
                            if (strtolower($offerDetails['offer_type']) == 'percentage') {
                                $ch_prod_price = $ch_prod_price - ($ch_prod_price * $offerDetails['offer_discount_value'] * 0.01);
                                $tot_price = $ch_prod_price * $total_quantity;
                            }
                        }
                    }

                    $db_total_price = round($ch_prod_price * $total_quantity, 2);
                    $total_amount = $this->input->post('total_amount');
                    if ($total_amount == 0) {
                        //Without Discount
                        $totalAmount = round($tot_price, 2);
                        //Compare with Database Value
                        if ($db_total_price != $totalAmount) {
                            $msg = '<div class="alert alert-danger" role="alert">Somthing Went Wrong !</div>';
                            $this->session->set_flashdata('message', $msg);
                            redirect('userorder/proceed_start_order');
                        }
                    } else {
                        //Discounted Price
                        $tlAmount = $this->input->post('total_amount');
                        $checkCouponValue = $this->Product_model->checkCouponValue($coupon_id);

                        if ($total_quantity > $checkCouponValue->moq) {
                            $discounted_price = $tot_price * $checkCouponValue->coupon_value / 100;
                            $finalPrice = $tot_price - $discounted_price;
                            if ($finalPrice == $tlAmount) {
                                $totalAmount = $tlAmount;
                            } else {
                                $msg = '<div class="alert alert-danger" role="alert">Somthing Went Wrong !</div>';
                                $this->session->set_flashdata('message', $msg);
                                redirect('userorder/proceed_start_order');
                            }
                        } else {
                            $msg = '<div class="alert alert-danger" role="alert">Somthing Went Wrong !</div>';
                            $this->session->set_flashdata('message', $msg);
                            redirect('userorder/proceed_start_order');
                        }
                    }

                    $shipp_addr = $this->input->post('shipp_addr');
                    $product_spec = $this->session->userdata('data');

                    $product_specifications = json_encode($product_spec);
                    //User Detail
                    $user = $this->Users_model->get_buyer_info($user_id);




                    $user_addr = $this->Order_model->get_ship_address($shipp_addr);


                    if ($user_addr['user_id'] != $user_id) {

                        $msg = '<div class="alert alert-danger" role="alert"> Invalid UserAddress!</div>';
                        $this->session->set_flashdata('message', $msg);
                        redirect('userorder/proceed_start_order');
                    }
                    //get seller Pick Up Address
                    $paddress = $this->Common_model->getAll('seller_pick_address', array('user_id' => $seller_id))->row_array();
                    $prod_dat = $this->send_data->get_product_detail($product_id);
                    $seller_pin = $paddress['pincode'];
                    $buyer_pin = $user_addr['postcode'];

                    //Calculate Shipping Cost ( Library )
                    if ($ship_method == 1) {
                        $shipping_cost = $this->shipping->calculate_shipping_cost($product_id, $total_quantity, $buyer_pin, $seller_id);

                        $shipping_rate = $shipping_cost['shipping_data']['shipping_rate'];

                        $exp_shipping_date = $shipping_cost['shipping_data']['shipping_date_time'];
                        $shipping_subtotal = $shipping_cost['shipping_data']['shipping_subtotal'];
                        $shipping_gst = $shipping_cost['shipping_data']['shipping_gst'];
                        $ship_status = $shipping_cost['status'];
                        $courier_id = 0;
                    } elseif ($ship_method == 2) {
                        $ship_rocket_cost = $this->shiprocket->serviceability($seller_pin, $buyer_pin, $prod_dat->weight, $prod_dat->length, $pro_dat->width, $prod_dat->height, $total_quantity);

                        if ($ship_rocket_cost['status'] == 200) {

                            $courier_id = $ship_rocket_cost['courier_id'];
                            $shipping_rate = $ship_rocket_cost['rate'];
                            $shipping_subtotal = round(($ship_rocket_cost['rate'] - ($ship_rocket_cost['rate'] * (18 / 100))), 2);
                            $shipping_gst = round(($ship_rocket_cost['rate'] * (18 / 100)), 2);
                            $exp_shipping_date = $ship_rocket_cost['est_date'];
                            $ship_status = 1;
                        } else {
                            $msg = '<div class="alert alert-danger" role="alert">Pickup Not Available!</div>';
                            $this->session->set_flashdata('message', $msg);
                            redirect('userorder/proceed_start_order');
                        }
                    } else {
                        $ship_status = 0;
                        $msg = '<div class="alert alert-danger" role="alert">Currently Shipping Not Available !</div>';
                        $this->session->set_flashdata('message', $msg);
                        redirect('userorder/proceed_start_order');
                    }

                    //Check 2 pay charge
                    $area_code = $this->Shipping_model->get_seller_area($paddress['pick_id']);

                    $areaCode = $area_code['area'];


                    // echo'<pre>';
                    //check pickupregister
                    $pickData['AreaCode'] = $areaCode;
                    $pickData['ContactPersonName'] = $paddress['seller_name'];
                    $pickData['CustomerAddress1'] = $paddress['address_type'];
                    $pickData['CustomerAddress2'] = substr($paddress['address'], 25);
                    $pickData['CustomerAddress3'] = $paddress['country'];
                    $pickData['CustomerCode'] = CustomerCode;
                    $pickData['CustomerName'] = $paddress['seller_name'];
                    $pickData['CustomerPincode'] = $paddress['pincode'];
                    $pickData['CustomerTelephoneNumber'] = $paddress['seller_mobile'];
                    $pickData['DoxNDox'] = '1';
                    $pickData['EmailID'] = $paddress['seller_email'];
                    $pickData['MobileTelNo'] = $paddress['seller_mobile'];
                    $pickData['NumberofPieces'] = $quantity;
                    $pickData['OfficeCloseTime'] = $paddress['office_close'];
                    $pickData['ProductCode'] = 'E';
                    $pickData['ReferenceNo'] = '123456';
                    $pickData['Remarks'] = 'ATZ CART';
                    $pickData['RouteCode'] = '99';
                    $pickData['ShipmentPickupDate'] = date('Y-m-d');
                    $pickData['ShipmentPickupTime'] = date('H:i');
                    $pickData['VolumeWeight'] = 2.5; // Conside approx
                    $pickData['WeightofShipment'] = 2.5; // Conside approx
                    if ($areaCode == 'PNQ') {
                        $pickData['isToPayShipper'] = 'N';
                    } else {
                        $pickData['isToPayShipper'] = 'Y';
                    }

                    //From Api Pick Up Registration and Way Billl Generation

                    $token_no = 1; //$this->shipping->pickupRegistration($pickData);

                    if ($ship_status == 1) {

                        //check Shippment Type
                        ///Insert in Order Table
                        $insertOrder['order_from'] = 'Start_order';
                        $insertOrder['user_id'] = $user_id;
                        $insertOrder['user_name'] = $user_addr['contact_person'];
                        $insertOrder['user_city'] = $user_addr['city'];
                        $insertOrder['user_postcode'] = $user_addr['postcode'];
                        $insertOrder['user_street_address'] = $user_addr['street'];
                        $insertOrder['user_state'] = $user_addr['state'];
                        $insertOrder['user_country'] = $user_addr['country'];
                        $insertOrder['user_telephone'] = $user_addr['contact_number'];
                        $insertOrder['user_email_address'] = $user['email'];

                        $insertOrder['pick_name'] = $paddress['seller_name'];

                        $insertOrder['pick_addr_type'] = $paddress['address'] . ',' . $paddress['address_type'];
                        $insertOrder['pick_address'] = $paddress['address2'] . ',' . $paddress['address3'];
                        $insertOrder['pick_country'] = $paddress['country'];
                        $insertOrder['pick_state'] = $paddress['state'];
                        $insertOrder['pick_mobile'] = $paddress['seller_mobile'];
                        $insertOrder['pick_email'] = $paddress['seller_email'];
                        $insertOrder['pick_pincode'] = $paddress['pincode'];
                        $insertOrder['pick_days'] = 2; // Pick Up days

                        $insertOrder['delivery_name'] = $user_addr['contact_person'];
                        $insertOrder['delivery_street_address'] = $user_addr['street'];
                        $insertOrder['delivery_city'] = $user_addr['city'];
                        $insertOrder['delivery_postcode'] = $user_addr['postcode'];
                        $insertOrder['delivery_state'] = $user_addr['state'];
                        $insertOrder['delivery_country'] = $user_addr['country'];
                        $insertOrder['delivery_date'] = $exp_shipping_date;
                        $insertOrder['shipping_expected_date'] = $exp_shipping_date;
                        $insertOrder['shipping_cost'] = $shipping_rate;
                        $insertOrder['shipping_subtotal'] = $shipping_subtotal;
                        $insertOrder['shipping_gst'] = $shipping_gst;

                        //Shipping Address Details
                        $chech_shipp = $this->Common_model->getAll('shipping_vendor', array('id' => $ship_method))->row();
                        //Check Shipping Status
                        if ($chech_shipp->shipping_type == 'Free' && $totalAmount >= $chech_shipp->free_amount) {
                            $insertOrder['order_price'] = round($totalAmount, 2);
                            $insertOrder['shippment_type'] = 'Free';
                        } else {
                            $insertOrder['order_price'] = round($totalAmount + $shipping_rate, 2);
                            $insertOrder['shippment_type'] = 'Paid';
                        }

                        $insertOrder['orders_status'] = 8;
                        $insertOrder['shipping_method'] = $this->input->post('shipping_method');
                        $insertOrder['seller_id'] = $seller_id;
                        $insertOrder['currency'] = 'INR';
                        $insertOrder['wallet_option'] = 'unchecked';
                        $insertOrder['date_purchased'] = date('Y-m-d H:i:s');

                        $insert_id = $this->Common_model->insert('orders', $insertOrder);

                        if ($insert_id) {

                            if ($chech_shipp->shipping_type == 'Free' && $totalAmount >= $chech_shipp->free_amount) {
                                $insertProPrice['shippment_type'] = 'Free';
                            } else {
                                $insertProPrice['shippment_type'] = 'Paid';
                            }
                            $insertProPrice['orders_id'] = $insert_id;
                            $insertProPrice['products_id'] = $product_id;
                            $insertProPrice['products_name'] = $product_name;
                            $insertProPrice['products_price'] = $unit_price;
                            $insertProPrice['final_price'] = $tot_price;
                            $insertProPrice['products_tax'] = 0;
                            $insertProPrice['coupon_id'] = $coupon_id;
                            $insertProPrice['products_quantity'] = $total_quantity;
                            $insertProPrice['product_specifications'] = $product_specifications;
                            $insertProPrice['offer_id'] = $this->session->userdata('data')['offer_id'];

                            $this->Common_model->insert('orders_products', $insertProPrice);
                            /////Order Accepted Dimension
                            $pro_detail = $this->Common_model->getAll('product_details', array('id' => $product_id))->row();

                            $acceptData['orders_id'] = $insert_id;
                            $acceptData['length'] = $pro_detail->length;
                            $acceptData['width'] = $pro_detail->width;
                            $acceptData['height'] = $pro_detail->height;
                            $acceptData['weight_per_unit'] = $total_quantity * $pro_detail->weight;
                            $acceptData['pick_id'] = $paddress['pick_id'];
                            $acceptData['pick_area_code'] = $areaCode;
                            $this->Common_model->insert('order_accepted_dimention', $acceptData);

                            //Order Request here
                            $insertHistory['orders_id'] = $insert_id;
                            $insertHistory['status'] = 10;
                            $insertHistory['date_added'] = date('Y-m-d H:i:s');
                            $insertHistory['comment'] = 'Order Requested';
                            $insertHistory['customer_notified'] = 1;
                            $this->Common_model->insert('orders_history', $insertHistory);

                            //Insert into Shipping Order
                            if ($chech_shipp->shipping_type == 'Free' && $totalAmount >= $chech_shipp->free_amount) {
                                $ship_dat['shippment_type'] = 'Free';
                            } else {
                                $ship_dat['shippment_type'] = 'Paid';
                            }
                            $ship_dat['ship_vendor_id'] = $ship_method;
                            $ship_dat['orders_id'] = $insert_id;
                            $ship_dat['delivery_date'] = $exp_shipping_date;
                            $ship_dat['courier_id'] = $courier_id;
                            $ship_dat['shipping_subtotal'] = $shipping_subtotal;
                            $ship_dat['shipping_gst'] = $shipping_gst;
                            $ship_dat['shipping_cost'] = $shipping_rate;
                            $ship_dat['on_amount'] = $chech_shipp->free_amount;
                            $ship_dat['pickup_pincode'] = $paddress['pincode'];
                            $ship_dat['delivery_pincode'] = $buyer_pin;
                            $ship_dat['pick_id'] = $paddress['pick_id'];
                            $ship_dat['length'] = $prod_dat->length;
                            $ship_dat['breadth'] = $prod_dat->width;
                            $ship_dat['height'] = $prod_dat->height;
                            $ship_dat['weight'] = ($prod_dat->weight * $total_quantity);
                            $insert_ship_id = $this->Common_model->insert('order_shipping', $ship_dat);
                        }

                        //Generate Order if Use Ship Rocket

                        if ($ship_method == 2) {
                            $resp = $this->shiprocket->create_order($insert_id);
                           
                            if (!empty($resp['order_id'])) {
                                $up_ord['ship_order_id'] = $resp['order_id'];
                                $up_ord['shipment_id'] = $resp['shipment_id'];
                                $this->Common_model->update('order_shipping', $up_ord, array('ship_id' => $insert_ship_id));
                            } else {
                                $this->Common_model->delete('orders', array('orders_id' => $insert_id));
                                $this->Common_model->delete('orders_products', array('orders_id' => $insert_id));
                                $this->Common_model->delete('order_shipping', array('orders_id' => $insert_id));
                                $this->Common_model->delete('orders_history', array('orders_id' => $insert_id));
                                $msg = '<div class="alert alert-danger" role="alert">Order Not Created ! Please Retry </div>';
                                $this->session->set_flashdata('message', $msg);
                                redirect('userorder/proceed_start_order');
                            }
                        }
                        unset($_SESSION["data"]);
                        redirect('userorder/ship_order/' . $insert_id);
                    } else {
                        $msg = '<div class="alert alert-danger" role="alert">' . $shipping_cost['message'] . '</div>';
                        $this->session->set_flashdata('message', $msg);
                        redirect('userorder/proceed_start_order');
                    }
                }
            } else {
                redirect("login", "refresh");
            }
        } else if ($user_role == "seller") {
            $error = '<div class="alert alert-danger alert-dismissible">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        <strong>Error! : </b></strong>Please Login as Buyer to Proceed for Purchase ! 
                    </div>';

            $this->session->set_flashdata("message", $error);
            redirect("seller/dashboard", "refresh");
        } else {
            redirect("login", "refresh");
        }
    }

    function calculate_shipping_cost($product_id, $quantity, $user_pincode, $seller_id) {
        //get Existing Data
        $ch_exist = $this->Common_model->getAll('product_details', array('id' => $product_id))->num_rows();
        if ($ch_exist > 0) {
            $ch_pincode = $this->Common_model->getAll('shipping_surface', array('pincode' => $user_pincode))->num_rows();
            if ($ch_exist > 0) {
                $ch_seller = $this->Common_model->getAll('product_details', array('id' => $product_id))->row();


                $product_weight = $ch_seller->weight;
                $product_lenght = $ch_seller->length;
                $product_width = $ch_seller->width;
                $product_height = $ch_seller->height;
                $ship_from = $ch_seller->state;

                $product_rate = $this->Shipping_model->get_qty_wise_product_rate($product_id, $quantity);

                //get Seller Pincode
                $ch_seller_pin = $this->Common_model->getAll('seller_pick_address', array('user_id' => $seller_id))->row();

                if (!empty($ch_seller_pin->pincode)) {
                    $buyer_pin = $user_pincode;
                    $seller_pin = $ch_seller_pin->pincode;
                    /*                     * ****Calculate Shipping Rate************* */
                    //$this->calculate_approx_shipping_rate($pro_id,$buyer_pin,$seller_pin,$quantity);
                    $rate = $this->Shipping_model->get_shipping_rate_approx($seller_pin, $buyer_pin);
                    if ($rate <= 0) {
                        $output["status"] = 0;
                        $output["message"] = "Not Deliverable Region !";
                    } else {
                        $actual_order_price = $product_rate * $quantity;
                        $total_weight = $product_weight * $quantity;

                        $price = $total_weight * $rate; //As Weight


                        $size = (($product_height * $product_lenght * $product_width)) / 3600;
                        $size = $size * $quantity;

                        $price2 = $size * $rate; //As Length * width * Height

                        $Freight = ($price > $price2) ? $price : $price2;

                        $FS = $Freight * (35 / 100); //FS

                        $CAF = ($Freight + $FS) * (7.5 / 100); //CAF

                        $IDC = ($Freight + $FS + $CAF) * (10 / 100); //IDC

                        $AWB = 75; //AWB

                        $FOV = ($actual_order_price * (0.2 / 100)); //FOV
                        //Sub Total 
                        $sub_total = $Freight + $FS + $CAF + $IDC + $AWB + $VCHC + $FOV;

                        if (($actual_order_price / $total_weight) > 5000) {
                            $VCHC = $sub_total + $actual_order_price; //VCHC;
                        } else {
                            $VCHC = 0;
                        }

                        //Check 2 pay charge
                        $check2Paycharge = $this->Common_model->getAll('shipping_surface', array('pincode' => $seller_pin))->row_array();

                        $areaCode = $check2Paycharge['area'];


                        if ($areaCode != 'PNQ') {
                            $sub_total = $sub_total + 50; //2 pay charge if out of Pune
                        }

                        //$GST = $sub_total * (18 / 100); //GST

                        $tot_shipping_rate = round($sub_total, 2);


                        //approex expected Time
                        $exp_time = $this->shipping->approx_calculate_expected_time($seller_id, $pincode);


                        $additional_days = $exp_time['GetDomesticTransitTimeForPinCodeandProductResult']['AdditionalDays'] . ' ' . 'days';

                        $exp_date = $exp_time['GetDomesticTransitTimeForPinCodeandProductResult']['ExpectedDateDelivery'];

                        $shipping_expected_date = date('Y-m-d', strtotime($exp_date . ' +' . $additional_days . ''));


                        $data['shipping_date_time'] = $shipping_expected_date;
                        $data['shipping_rate'] = $tot_shipping_rate;
                        $output["shipping_data"] = $data;
                        $output["status"] = 1;
                        $output["message"] = "Approx Shippping Data";
                    }
                } else {
                    $output["status"] = 0;
                    $output["message"] = "Not Deliverablee Pincode !";
                }
            } else {
                $output["status"] = 0;
                $output["message"] = "Not Deliverable Pincode !";
            }
        } else {
            $output["status"] = 0;
            $output["message"] = "Product Not Found !";
        }
        return $output;
    }

    public function startOrderForCartProduct($id) {
        $data["title"] = "ATZCart - Cart Start Order";

        $username = $this->session->userdata('user_name');
        $user_id = $this->session->userdata('user_id');
        $user_role = $this->session->userdata('user_role');
        if ($user_role == 'buyer') {
            if ($username) {
                //get Shipping Method
                $ship_method = $this->send_data->get_shipping_method();

                $result = $this->Product_model->getCartProducts_Byid($id, $user_id);
                foreach ($result as $key => $row) {
                    $result[$key]["specifications_decode"] = json_decode($row["specifications"]);
                    $totalQty = $result[$key]["specifications_decode"][0]->specifications->total_quantity;
                    $productData[] = $this->Product_model->getProductData($row['product_id'],
                            $row['offer_id'], $totalQty);
                    unset($result[$key]["specifications"]);
                }
                $data['product_data'] = $productData;
                $data['bal'] = $this->Common_model->getAll('buyer_wallet', array('user_id' => $user_id))->row();
                $data['seller_info'] = $this->Product_model->getSellerInformation($result[0]['seller_id']);
                $data['cart_product'] = $result;
                $chech_shipp = $this->Common_model->getAll('shipping_vendor', array('id' => $ship_method))->row();
                //Check Shipping Status
                $data['shipping_type'] = $chech_shipp->shipping_type;
                $data['user_addr'] = $this->Common_model->getAll('address_book', array('user_id' => $user_id))->result_array();
                //printr($data);
                $this->load->view('front/order/proceedordercartproduct', $data);
            } else {
                redirect("login", "refresh");
            }
        } else {
            $error = '<div class="alert alert-danger alert-dismissible">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        <strong>Error! : </b></strong>Please Login as Buyer to Proceed for Purchase ! 
                    </div>';

            $this->session->set_flashdata("message", $error);
            redirect("seller/dashboard", "refresh");
        }
    }

    public function proceedResponseCartProduct() {

        //get Shipping Method
        $ship_method = $this->send_data->get_shipping_method();

        $products = json_decode($this->input->post('tempList'));

        $shipp_addr = $this->input->post('shipp_addr');

        $shipping_method = $this->input->post('shipping_method');
        $user_id = $this->session->userdata('user_id');
        $data['bal'] = $this->Common_model->getAll('buyer_wallet', array('user_id' => $user_id))->row();
        $user = $this->Users_model->get_buyer_info($user_id);
        $seller_id = $this->input->post('seller');
        $paddress = $this->Common_model->getAll('seller_pick_address', array('user_id' => $seller_id))->row_array();
        if ($paddress && !empty($shipp_addr)) {
            $user_addr = $this->Order_model->get_ship_address($shipp_addr);

            if ($user_addr['user_id'] != $user_id) {
                $output = ['status' => 3];
                echo json_encode($output);
                exit;
            }

            $buyer_pin = $user_addr['postcode'];

            $shipping_expected_date = date('Y-m-d');
            $finalShipping_date = date('Y-m-d', strtotime($shipping_expected_date . ' +2 day'));
            $shipping_price = 0;
            $prod_price_from_db = 0;
            $chk_db_prod_price = 0;

            $max_length = 0.5;
            $max_height = 0.5;
            $max_width = 0.5;
            $tot_qty = 0;
            $tot_weight = 0;
            foreach ($products as $product) {
                $prod_price_from_db = $prod_price_from_db + $this->Shipping_model->get_qty_wise_product_rate($product->product_id, $product->total_quantity);
                $prod_dat = $this->send_data->get_product_detail($product->product_id);

                ///////////////
                ///////////////
                ////Calculate Shipping Cost ( Library )
                if ($ship_method == 1) {
                    $result = $this->shipping->calculate_shipping_cost($product->product_id, $product->total_quantity, $buyer_pin, $product->seller_id);
                    //$result = $this->calculate_shipping_cost($product->product_id, $product->total_quantity, $buyer_pin, $product->seller_id);
                    //$shipping_rate = $result['shipping_data']['shipping_rate']; Comment on 12 sept 2019
                    $shipping_rate = $result['shipping_data']['shipping_subtotal'];
                    $shipping_date_time = $result['shipping_data']['shipping_date_time'];
                    $courier_id = 0;
                } elseif ($ship_method == 2) {


                    //calculate length ,width,height
                    if ($prod_dat->length > $max_length) {
                        $max_length = $prod_dat->length;
                    }

                    if ($prod_dat->width > $max_width) {
                        $max_width = $prod_dat->width;
                    }

                    if ($prod_dat->height > $max_height) {
                        $max_height = $prod_dat->height;
                    }

                    $wt = $prod_dat->weight * $product->total_quantity;
                    $tot_weight = $tot_weight + $wt;


                    //$seller_pin = $paddress['pincode'];
                    //$buyer_pin = $user_addr['postcode'];
                    //$ship_rocket_cost = $this->shiprocket->serviceability($seller_pin, $buyer_pin, $prod_dat->weight, $prod_dat->length, $pro_dat->width, $prod_dat->height, $product->total_quantity);

                    /* if ($ship_rocket_cost['status'] == 200) {
                      $courier_id = $ship_rocket_cost['courier_id'];
                      $shipping_rate = $ship_rocket_cost['rate'];
                      $shipping_date_time = $ship_rocket_cost['est_date'];
                      $ship_status = 1;
                      } else {
                      $output = ['status' => 0];
                      echo json_encode($output);
                      } */
                } else {
                    $output = ['status' => 0];
                    echo json_encode($output);
                }
                //////////////
                //////////////
                $chk_db_prod_price += $product->final_price;
                $shipping_price = $shipping_price + $shipping_rate;
                if ($finalShipping_date > $shipping_date_time) {
                    $finalShipping_date = $shipping_date_time;
                }
            }

            //calculate shiiping cost using Ship Rocket
            if ($ship_method == 2) {
                $seller_pin = $paddress['pincode'];
                $buyer_pin = $user_addr['postcode'];
                $ship_rocket_cost = $this->shiprocket->serviceability_for_multiple($seller_pin, $buyer_pin, $max_length, $max_width, $max_height, $tot_weight);

                if ($ship_rocket_cost['status'] == 200) {
                    $courier_id = $ship_rocket_cost['courier_id'];

                    //$shipping_rate = $ship_rocket_cost['rate'];
                    //$shipping_date_time = $ship_rocket_cost['est_date'];
                    $shipping_price = $ship_rocket_cost['rate'];
                    $finalShipping_date = $ship_rocket_cost['est_date'];
                    $ship_status = 1;
                } else {
                    $output = ['status' => 0];
                    echo json_encode($output);
                }
            }



            $total_order_price = 0;
            $check_wallet_val = $this->input->post('chk_wallet_val');

            $wallet_balance = $this->input->post('wallet_amount');

            $total_amount = $this->input->post('total_amount');
            if ($total_amount == 0) {
                $totalAmount = $this->input->post('tot_price');

                if (round($chk_db_prod_price, 2) != round($totalAmount, 2)) {
                    $msg = '<div class="alert alert-danger" role="alert">Somthing Went Wrong !</div>';
                    $this->session->set_flashdata('message', $msg);

                    $url = 'userorder/startOrderForCartProduct/' . $seller_id;
                    $output = ['status' => 2, 'redirect' => $url];
                    echo json_encode($output);
                    die;
                }
            } else {
                $totalAmount = $this->input->post('total_amount');
            }

            if ($ship_method == 2) {
                $shipping_gst = round($shipping_price * (18 / 100), 2); // gst on order
                $shipping_subtotal = round($shipping_price - $shipping_gst, 2);
                $shipping_cost = $shipping_price;
            } else {
                $shipping_subtotal = $shipping_price;
                $shipping_gst = $shipping_subtotal * (18 / 100); // gst on order
                $shipping_cost = $shipping_subtotal + $shipping_gst;
            }
            ///Insert in Order Table
            $insertOrder['user_id'] = $user_id;
            $insertOrder['user_name'] = $user_addr['contact_person'];
            $insertOrder['user_city'] = $user_addr['city'];
            $insertOrder['user_postcode'] = $user_addr['postcode'];
            $insertOrder['user_street_address'] = $user_addr['street'];
            $insertOrder['user_state'] = $user_addr['state'];
            $insertOrder['user_country'] = $user_addr['country'];
            $insertOrder['user_telephone'] = $user_addr['contact_number'];
            $insertOrder['user_email_address'] = $user['email'];

            $insertOrder['pick_name'] = $paddress['seller_name'];

            $insertOrder['pick_addr_type'] = $paddress['address'] . ',' . $paddress['address_type'];
            $insertOrder['pick_address'] = $paddress['address2'] . ',' . $paddress['address3'];
            $insertOrder['pick_country'] = $paddress['country'];
            $insertOrder['pick_state'] = $paddress['state'];
            $insertOrder['pick_mobile'] = $paddress['seller_mobile'];
            $insertOrder['pick_email'] = $paddress['seller_email'];
            $insertOrder['pick_pincode'] = $paddress['pincode'];
            $insertOrder['pick_days'] = 2; // Pick Up days


            $insertOrder['delivery_name'] = $user_addr['contact_person'];
            $insertOrder['delivery_street_address'] = $user_addr['street'];
            $insertOrder['delivery_city'] = $user_addr['city'];
            $insertOrder['delivery_postcode'] = $user_addr['postcode'];
            $insertOrder['delivery_state'] = $user_addr['state'];
            $insertOrder['delivery_country'] = $user_addr['country'];
            $insertOrder['shipping_expected_date'] = $finalShipping_date;
            $insertOrder['shipping_subtotal'] = $shipping_subtotal;
            $insertOrder['shipping_gst'] = $shipping_gst;
            $insertOrder['shipping_cost'] = $shipping_cost;
            //Shipping Address Details
            $chech_shipp = $this->Common_model->getAll('shipping_vendor', array('id' => $ship_method))->row();
            //Check Shipping Status
            if ($chech_shipp->shipping_type == 'Free' && $totalAmount >= $chech_shipp->free_amount) {
                $insertOrder['order_price'] = round($totalAmount, 2);
                $insertOrder['shippment_type'] = 'Free';
            } else {
                $insertOrder['order_price'] = round($totalAmount + $shipping_cost, 2);
                $insertOrder['shippment_type'] = 'Paid';
            }

            // $insertOrder['order_price'] = round($totalAmount + $shipping_cost, 2);
            $insertOrder['orders_status'] = 8;
            $insertOrder['shipping_method'] = $shipping_method;
            $insertOrder['seller_id'] = $seller_id;
            $insertOrder['currency'] = 'INR';
            $insertOrder['wallet_option'] = 'unchecked';
            $insertOrder['date_purchased'] = date('Y-m-d H:i:s');

            $insert_id = $this->Common_model->insert('orders', $insertOrder);
            if ($insert_id) {
                $tot_weight = 0;
                $prod = '';
                $totalOrderAmount = 0;
                foreach ($products as $product) {
                    if ($chech_shipp->shipping_type == 'Free' && $totalAmount >= $chech_shipp->free_amount) {
                        $insertProPrice['shippment_type'] = 'Free';
                    } else {
                        $insertProPrice['shippment_type'] = 'Paid';
                    }

                    $insertProPrice['orders_id'] = $insert_id;
                    $insertProPrice['products_id'] = $product->product_id;
                    $insertProPrice['products_name'] = $product->product_name;
                    $insertProPrice['products_price'] = $product->unit_price;
                    $insertProPrice['final_price'] = $product->final_price;
                    $insertProPrice['products_tax'] = 0;
                    $insertProPrice['coupon_id'] = $product->coupon_id;
                    $insertProPrice['products_quantity'] = $product->total_quantity;
                    $insertProPrice['product_specifications'] = json_encode($product);
                    $insertProPrice['offer_id'] = $product->offer_id;

                    $this->Common_model->insert('orders_products', $insertProPrice);
                    $prod = $prod . ' ,' . $product->product_name;
                    //get weight
                    $pro_detail = $this->Common_model->getAll('product_details', array('id' => $product->product_id))->row();
                    $tot_weight = $tot_weight + ($pro_detail->weight * $product->total_quantity);

                    if ($product->coupon_id != 0) {
                        $cpn = array(
                            'user_id' => $user_id,
                            'coupon_id' => $product->coupon_id,
                            'status' => 'GET'
                        );
                        $coupon = $this->Product_model->updateMyCoupon($cpn);
                    }
                }

                //Insert into Shipping Order
                if ($chech_shipp->shipping_type == 'Free' && $totalAmount >= $chech_shipp->free_amount) {
                    $ship_dat['shippment_type'] = 'Free';
                } else {
                    $ship_dat['shippment_type'] = 'Paid';
                }
                $ship_dat['ship_vendor_id'] = $ship_method;
                $ship_dat['orders_id'] = $insert_id;
                $ship_dat['delivery_date'] = $finalShipping_date;
                $ship_dat['courier_id'] = $courier_id;
                $ship_dat['shipping_subtotal'] = $shipping_subtotal;
                $ship_dat['shipping_gst'] = $shipping_gst;
                $ship_dat['shipping_cost'] = $shipping_cost;
                $ship_dat['on_amount'] = $chech_shipp->free_amount;
                $ship_dat['pickup_pincode'] = $paddress['pincode'];
                $ship_dat['pick_id'] = $paddress['pick_id'];
                $ship_dat['delivery_pincode'] = $buyer_pin;
                $ship_dat['shippment_type'] = $chech_shipp->shipping_type;
                $ship_dat['length'] = $max_length;
                $ship_dat['breadth'] = $max_width;
                $ship_dat['height'] = $max_height;
                $ship_dat['weight'] = $tot_weight;
                $insert_ship_id = $this->Common_model->insert('order_shipping', $ship_dat);

                //Generate Order if Use Ship Rocket
                if ($ship_method == 2) {
                    $resp = $this->shiprocket->create_order($insert_id);
                    if (!empty($resp['order_id'])) {
                        $up_ord['ship_order_id'] = $resp['order_id'];
                        $up_ord['shipment_id'] = $resp['shipment_id'];
                        $this->Common_model->update('order_shipping', $up_ord, array('ship_id' => $insert_ship_id));
                    } else {
                        $this->Common_model->delete('orders', array('orders_id' => $insert_id));
                        $this->Common_model->delete('orders_products', array('orders_id' => $insert_id));
                        $this->Common_model->delete('order_shipping', array('orders_id' => $insert_id));
                        $this->Common_model->delete('orders_history', array('orders_id' => $insert_id));
                        $output = ['status' => 0];
                        echo json_encode($output);
                    }
                }



                /////Order Accepted Dimension
                //$pro_detail = $this->Common_model->getAll('product_details', array('id' => $product_id))->row();
                //get area code
                $area_c = $this->Shipping_model->get_seller_area($paddress['pick_id']);
                $areaCode = $area_c['area'];
                $acceptData['orders_id'] = $insert_id;
                $acceptData['length'] = '';
                $acceptData['width'] = '';
                $acceptData['height'] = '';
                $acceptData['weight_per_unit'] = $tot_weight;
                $acceptData['pick_id'] = $paddress['pick_id'];
                $acceptData['pick_area_code'] = $areaCode;
                $this->Common_model->insert('order_accepted_dimention', $acceptData);


                //Order Request
                $insertHistory['orders_id'] = $insert_id;
                $insertHistory['status'] = 10;
                $insertHistory['date_added'] = date('Y-m-d H:i:s');
                $insertHistory['comment'] = 'Order Requested';
                $insertHistory['customer_notified'] = 1;
                $this->Common_model->insert('orders_history', $insertHistory);
                
                $output = ['status' => 1, 'insert_id' => $insert_id];
                echo json_encode($output);
            }
        } else {
            $output = ['status' => 0];
            echo json_encode($output);
        }
    }

    function tracking() {

        $url = "http://www.bluedart.com/servlet/RoutingServlet?handler=tnt&action=custawbquery&loginid=PNQ68152&awb=awb&numbers=53387019766&format=xml&lickey=shpfrizntrznsoenuinitepppenfhuun&verno=1.3&scan=1";

        $get = file_get_contents($url);
        $arr = simplexml_load_string($get);

        $sdate = $arr->Shipment->StatusDate;
        echo '<pre>';
        // print_r($arr);
        $new_arr = json_decode(json_encode($arr->Shipment->Scans));

        $track_arr = (array_reverse($new_arr->ScanDetail));

        foreach ($track_arr as $track_arr) {
            print_r($track_arr);
            echo $track_arr->ScanCode . '<br>';

            $DLdate = date('Y-m-d', strtotime($track_arr->ScanDate));
            $DLtime = date('H:i:s', strtotime($track_arr->ScanTime));

            echo $DLt = $DLdate . ' ' . $DLtime;
            echo '<br>';
        }
    }

    private function addToVendorWallet($order_id) {
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

    function check_order_with_coupon_applied($order_id) {

        //Load Coupon Model
        $this->load->model('Coupon_model');
        $this->load->model('Common_model');

        //Check Coupon Applied or Not
        $check = $this->check_coupon_on_order($order_id);
        if ($check == true) {

            //Gel Coupon Applicable Product 
            $this->db->select('a.user_id,a.orders_id,a.shipping_cost,a.order_price,b.products_id,b.coupon_id,b.products_price,b.products_quantity,b.final_price,b.products_name');
            $this->db->from('orders a');
            $this->db->join('orders_products b', 'a.orders_id=b.orders_id');
            $this->db->where('a.orders_id', $order_id);
            $this->db->where('a.orders_status', 8);
            $q = $this->db->get()->result();


            $tot_prod_price = 0;
            $updated_all_product_price = 0;
            $msg = 0;

            foreach ($q as $prod) {

                $user_id = $prod->user_id;
                $orders_id = $prod->orders_id;
                //Order Price
                $orderPrice = $prod->order_price - $prod->shipping_cost;

                $orderPrice_ch = (int) $orderPrice;
                //  echo'<br>';

                $quantity = $prod->products_quantity;
                $unit_price = $prod->products_price;

                $temp_total = $quantity * $unit_price;

                if ($prod->coupon_id != 0) {
                    $coupon_id = $prod->coupon_id;
                    $product = $prod->products_id;


                    //Check Coupon valid or Not
                    $isvalidcoupen = $this->Coupon_model->isCouponAvailableForUser($coupon_id, $product, $user_id);

                    if ($isvalidcoupen) {
                        $coupon = $this->Coupon_model->getCoupenById($coupon_id);

                        if ($coupon->discount_type == "flat") {
                            $tot_prod_price = ($tot_prod_price + $temp_total) - $coupon->coupon_value;
                        } else {
                            $percentage = ($temp_total * $coupon->coupon_value) / 100;
                            $tot_prod_price = ($tot_prod_price + $temp_total) - $percentage;
                        }
                    } else {
                        $msg = $msg . ',' . $prod->products_name;
                        $tot_prod_price = $tot_prod_price + $temp_total;

                        //Update Product Final Price
                        $dat['final_price'] = round($temp_total, 2);
                        // $this->Common_model->update('orders_products',$dat,array('products_id'=>$product,'orders_id'=>$orders_id));
                    }
                } else {
                    $tot_prod_price = $tot_prod_price + $temp_total;
                }
            }

            $tot_prod_price_ch = (int) $tot_prod_price;

            //Check Price
            echo $msg;
            //echo $orderPrice_ch.'|'.$tot_prod_price_ch;
            if (($orderPrice_ch === $tot_prod_price_ch)) {
                $success = 0; // All Correct
                echo $success . 'Hello';
            } else {
                //Update Final Price 
                //$fdat['order_price']=round($tot_prod_price+$prod->shipping_cost,2); 
                //  $this->Common_model->update('orders',$fdat,array('orders_id'=>$orders_id));

                $success = 1; // Coupon Expire and Update Order Price
                echo $success;
            }
        } else {
            $success = 2; // No Coupon Applied
            echo $success;
        }
    }

    function check_coupon_on_order($order_id) {
        //Check Coupon or Not
        $this->db->select('orders_id');
        $this->db->from('orders_products');
        $this->db->where('orders_id', $order_id);
        $this->db->where('coupon_id >', 0);
        $q = $this->db->get()->num_rows();
        if ($q == 0) {
            return false;
        } else {
            return true;
        }
    }

    function send_email_order_placed($order_id) {
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

    function send_email() {
        $this->send_data->sendNormal_email('dnyansons@ayninfotech.com', 'Testing Subject', 'Tesing');
    }

    //Change Status to Delivered
    function ch_to_delivered($order_id) {
        $dat['orders_status'] = 4;
        $dat['delivery_date'] = date('Y-m-d');
        $up = $this->Common_model->update('orders', $dat, array('orders_id' => $order_id));
        if ($up) {
            echo 'Order Delivered';
            $insertHistory['orders_id'] = $order_id;
            $insertHistory['status'] = 4;

            $insertHistory['date_added'] = date('Y-m-d H:i:s');
            $insertHistory['comment'] = 'Order Delivered';
            $insertHistory['customer_notified'] = 1;
            $this->Common_model->insert('orders_history', $insertHistory);
        } else {
            echo 'Not Delivered';
        }
    }

    //Change Status to Delivered
    function ch_to_return($order_id) {
        $dat['orders_status'] = 13;
        $dat['delivery_date'] = date('Y-m-d');
        $up = $this->Common_model->update('return_orders', $dat, array('orders_id' => $order_id));
        if ($up) {
            echo 'Return Update';
            $insertHistory['orders_id'] = $order_id;
            $insertHistory['status'] = 13;

            $insertHistory['date_added'] = date('Y-m-d H:i:s');
            $insertHistory['comment'] = 'Order Return';
            $insertHistory['customer_notified'] = 1;
             $this->Common_model->insert('orders_history', $insertHistory);
        } else {
            echo 'Not Update';
        }
    }

    public function getArea() {
        $output = [
            "status" => 0,
            "data" => ""
        ];
        $this->form_validation->set_rules("pincode", "pincode", "required");
        if ($this->form_validation->run() === true) {
            $this->db->where(["pincode" => $this->input->post("pincode")]);
            $query = $this->db->get("shipping_surface");
            $data = $query->row();
            if ($data) {
                $output["status"] = 1;
                $output["data"] = [
                    "state" => $data->state_desc,
                    "city" => $data->s_c_desc
                ];
            }
        }
        echo json_encode($output);
    }

    function generate_waybill($orders_id) {

        $res = $this->shipping->way_bill($orders_id);

        $awb_no = $res->GenerateWayBillResult->AWBNo;

        if (!empty($awb_no)) {
            $awb_pdf = $res->GenerateWayBillResult->AWBPrintContent;
            $file_name = 'uploads/wayBill_generate/waybill_' . $orders_id . '.pdf';
            // file_put_contents($file_name, $awb_pdf);


            $img_path = $this->awsupload->filePutContents($file_name, $awb_pdf);


            // $dat['awb_number'] = $awb_no;
            //$up = $this->Common_model->update('orders', $dat, array('orders_id' => $orders_id));
        } else {
            echo '<pre>';
            print_r($res);
        }
    }

    /**
     *
     * @return true for banned user and false for unbanned user
     * status 0 means banned
     * and 1 means not banned or unbanned User or active user
     */
    private function checkBannedUser() {
        $isBanned = $this->db->select('status')->from('users')
                        ->where('id', $this->session->user_id)
                        ->get()->result_array()[0]['status'];
        return ($isBanned == 1);
    }

    // must not be private as used by ajax request
    function checkBeforePay() {
        $banStatus = $this->checkBannedUser();
        if ($banStatus) {
            $banStatus = 1; //not banned status
        } else {
            session_unset();
            $message = "<div id='login-error' class='form-error notice notice-error'>
                        <span class='icon-notice icon-error'></span>
                        <span><b>Error! : </b></strong>Your account has been banned! Please contact support. </span>
                        </div>";
            $this->session->set_flashdata('message', $message);
            $banStatus = 0; //banned status 
        }
        echo json_encode($banStatus);
    }

    /**
     * @auther Yogesh Pardeshi 23082019
     * @param $order_id = order id to check whose offer has expired or not
     * @return $count = count of expired products if greater than
     * one then remove order and order products
     * @use before making final payment
     * */
    public function checkOfferBeforePay() {
        $order_id = $this->input->post("order_id");
        if (isset($order_id)) {
            $count = $this->Offer_model->deleteExpiredOfferFromOrders($order_id);
            if ($count > 0) {
                $msg = '<div class="alert alert-danger alert-dismissible col-md-6 offset-3">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <strong>Info:</strong> Offer expired for some of your products </div>';
                $this->session->set_flashdata('success_msg', $msg);
            }
            echo $count; //important for ajax call response
            return;
        }
        echo -1; //important for ajax call response
        return;
    }

    function check_returnable() {
        //echo $this->input->post('prod_id') . '|' . $this->input->post('pin_id');
        $prod_id = $this->input->post('prod_id');

        //get pincode
        $book_id = $this->input->post('pin_id');
        $this->db->select('postcode');
        $this->db->from('address_book');
        $this->db->where('address_book_id', $book_id);
        $pincode_q = $this->db->get()->row();

        $pincode = $pincode_q->postcode;
        $str='';
        //check in shipping
        $ch_seller = $this->Common_model->getAll('product_details', array('id' => $prod_id, 'is_product_returnable' => 'Yes'))->num_rows();
        $ch_pin = $this->Common_model->getAll('shiprocket_pincode', array('pincode' => $pincode, 'reverse' => 'TRUE'))->num_rows();
        if ($ch_seller != 0 && $ch_pin != 0) {
            $ch=1;
            $str=$ch.'|'.$pincode;
        } else {
            $ch=0;
            $str=$ch.'|'.$pincode;
        }
        echo $str;



        //echo $pincode=$this->input->post('pincode');
    }

}
