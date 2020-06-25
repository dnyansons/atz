<?php

header('Access-Control-Allow-Origin: *');

class Payment extends CI_Controller {

    public function __construct() {
        parent::__construct();

        if (!$this->session->userdata("user_logged_in")) {
            $error = "<div id='login-error' class='form-error notice notice-error'><span class='icon-notice icon-error'></span><span><strong>Error!</strong> Session timeout, relogin!. </span></div>";
            $this->session->set_flashdata("message", $error);
            redirect("login", "refresh");
        }

        $this->load->model("Shipping_model");
        $this->load->model("Users_model");
        $this->load->model("Common_model");
        $this->load->model("Categories_model");
        $this->load->model("Banners_model");
        $this->load->model("Rfqs_model");
        $this->load->model("Subscribers_model");
        $this->load->library("get_header_data");
        $this->load->model('Product_model');
        $this->load->model('Order_model');
        $this->load->model('myfavourite_model');
        $this->load->model('Inquiries_model');
        $this->load->model('Offer_model');
        $this->load->model('Company_model');
        $this->load->model('Wallet_model');
        $this->load->library('Shipping');
        $this->load->library('user_agent');
        $this->load->library('Send_data');
        $this->load->library('Browser_notification');
        $this->load->model("Affiliate_model");
    }

    public function index() {
        //xyzzyxabcbca1@00!1
        $data['title'] = 'CCAVENUES | Billing Shipping';
    }

    /*
      function for payment gateway process
     */

    public function payment_process() {
        if ($this->input->server("REQUEST_METHOD") !== 'POST') {
            show_error("Direct script access not allowed.!");
        }
        $this->load->library("form_validation");
        $user_id = $this->session->userdata('user_id');
        $data['bal'] = $this->Common_model->getAll('buyer_wallet', array('user_id' => $user_id))->row();
        $order_id = $this->input->post('order_id');


        //By Yogesh Pardeshi 26082019 508pm
        //Check iff order contains expird offer products if yes then remove that order 
        //from cart and redirect to cart so as to avoid invalid payment

        $deleteExpiredOfferProducts = $this->Offer_model->deleteExpiredOfferFromOrders($order_id);
        if ($deleteExpiredOfferProducts > 0) {
            $msg = '<div class="alert alert-danger alert-dismissible col-md-6 offset-3">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <strong>Info:</strong>Offer expired for some your products. </div>';

            $this->session->set_flashdata('success_msg', $msg);
            redirect(base_url('home_product/getCartProducts'));
        }

        ////By Yogesh Pardeshi 27082019 1pm
        //if orders has a product which is out of stock then redirect user to all orders page
        //in order to stop user from sending to payments page iff product quantity reaches to low stock
        $pr_details = $this->Order_model->getOrderDetails($order_id);
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


        $this->form_validation->set_rules("billing_email", "billing_email", "required");
        $this->form_validation->set_rules("order_id", "Order ID", "required");
        // $this->form_validation->set_rules("merchant_id", "Merchant ID", "required");
        $this->form_validation->set_rules("amount", "Amount", "required");
        $this->form_validation->set_rules("currency", "Currency", "required");
        $this->form_validation->set_rules("redirect_url", "Redirect URL", "required");
        $this->form_validation->set_rules("cancel_url", "Cancel URL", "required");
        $this->form_validation->set_rules("language", "Language", "required");
        $this->form_validation->set_rules("delivery_name", "Delivery Name", "required");
        $this->form_validation->set_rules("delivery_address", "Delivery Address", "required");
        $this->form_validation->set_rules("delivery_city", "Delivery City", "required");
        $this->form_validation->set_rules("delivery_state", "Delivery State", "required");
        $this->form_validation->set_rules("delivery_zip", "Delivery Zip", "required");
        $this->form_validation->set_rules("delivery_country", "Delivery Country", "required");
        $this->form_validation->set_rules('delivery_tel', 'Mobile Number ', 'required');
        $this->form_validation->set_rules('total_order_amount', 'Total Order Amount', 'required');
        $this->form_validation->set_rules('order_price', 'Order Price ', 'required');
        $this->form_validation->set_rules('shipping_amt', 'Shipping Cost ', 'required');

        if ($this->form_validation->run() === false) {

            $msg = "<div class='alert alert-danger alert-dismissible'>
                            <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                            <strong>Error !</strong> Invalid Parameter.!
                    </div>";

            $this->session->set_flashdata('message', $msg);
            redirect('userorder/ship_order/' . $order_id, 'refresh');
        } else {

            $merchant_data = '';
            $working_key = 'F01FEB197DF7A57851A8354B75C7FADC'; //Shared by CCAVENUES
            $data['access_code'] = 'AVLT86GG37AJ33TLJA'; //Shared by CCAVENUES

            $chk_wallet_val = $this->input->post('chk_wallet_val');
            $wallet_amount = $this->input->post('wallet_amount');
            $total_amount = $this->input->post('total_amount');

            $product_id = $this->input->post('product_id');
            $total_qty = $this->input->post('total_qty');
            $amount = $this->input->post('total_order_amount');
            $order_price = $this->input->post('order_price');
            $order_amount = $this->input->post('amount');

            $check_order = $this->Order_model->check_accepted_order($order_id);
              if (count($check_order) > 0) {
                $order_detail = $check_order;

//                $order_detail = $check_order->row_array();

                $orderTotal = $order_detail['order_price'];
                $db_order_id = $order_detail['orders_id'];



                $ch_prod_price = $this->Shipping_model->get_qty_wise_product_rate($product_id, $total_qty);
                // echo $db_total_price = round($ch_prod_price * $total_qty,2);
                $db_total_price1 = number_format((float) $ch_prod_price * $total_qty, 2, '.', '');


                if ($chk_wallet_val === 'checked' && $data['bal']->balance >= $amount) {

                    redirect('userorder/atz_success_wallet/' . $order_id);
                } else if ($chk_wallet_val === 'checked' && $amount >= $data['bal']->balance) {

                    $WalletOrderData = array(
                        'update_wallet_amount_payment' => round($wallet_amount, 2),
                        'privious_wallet_amout' => $data['bal']->balance
                    );

                    $this->session->set_userdata($WalletOrderData);

                    $update_order_amt = $amount - $data['bal']->balance;

                    if ((int) $total_amount != (int) $update_order_amt) {
                        $msg = '<div class="alert alert-danger" role="alert">Somthing Went Wrong !</div>';
                        $this->session->set_flashdata('message', $msg);
                        redirect('userorder/ship_order/' . $order_id);
                    }

                    // $updata['wallet_option'] = $chk_wallet_val;
                    // $up = $this->Common_model->update('orders', $updata, array('orders_id' => $order_id, 'orders_status' => 8));

                    foreach ($_POST as $key => $value) {
                        $merchant_data .= $key . '=' . urlencode($value) . '&';
                    }

                    $this->load->library('crypto');
                    // $CI = & get_instance();
                    $data['encrypted_data'] = $this->crypto->encrypt($merchant_data, $working_key); // Method for encrypting the data.
                    $this->load->view('ccavenue/ccavenue_payment', $data);
                } else {

                    if ($orderTotal != $order_amount) {
                        $msg = "<div class='alert alert-danger alert-dismissible'>
                                <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                                <strong>Error !</strong> Invalid Amount.!
                                  </div>";

                        $this->session->set_flashdata('message', $msg);
                        redirect('userorder/ship_order/' . $order_id, 'refresh');
                    }
                    foreach ($_POST as $key => $value) {

                        $merchant_data .= $key . '=' . urlencode($value) . '&';
                    }

                    $this->load->library('crypto');
                    // $CI = & get_instance();
                    $data['encrypted_data'] = $this->crypto->encrypt($merchant_data, $working_key); // Method for encrypting the data.
                    $this->load->view('ccavenue/ccavenue_payment', $data);
                }
            } else {
                $msg = '<i class="fa fa-exclamation-triangle" aria-hidden="true"></i><div align="center" style="color: red;">

                               <div id="login-error" class="form-error notice notice-error">
                                  <span class="icon-notice icon-error"></span>
                                  <span>Error ! Order Not Found !</span>
                               </div>
                            </div>';
                $this->session->set_flashdata('message', $msg);
                redirect('userorder/ship_order/' . $order_id);
            }
        }
    }

    public function success() {
        if ($this->input->server("REQUEST_METHOD") !== 'POST') {
            show_error('Direct script access not allowed.!');
        }
        $this->load->library('crypto');

        $encResp = $_POST['encResp'];

        if (isset($encResp)) {
            $working_key = 'F01FEB197DF7A57851A8354B75C7FADC';
            $decryptValues = explode('&', $this->crypto->decrypt($encResp, $working_key));
            // print_r($decryptValues);
            $dataSize = sizeof($decryptValues);
            $order_status = '';
            $orders_id = '';
            $tracking_id = '';
            $order_amt = '';
            $paymnt_mode = '';
            $currency = '';
            $param_wallet_option = '';
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
                    $param_wallet_option = $information[1];
                }
            }

            $amt_to_pay = ($order_amt / 100); //From User

            $check_order = $this->Order_model->check_accepted_order_payment($orders_id, $order_status);

            $user_id = $this->session->userdata('user_id');
            $email_id = $this->session->userdata('user_email');
            $phone_no = $this->session->userdata('phone');
            $data['bal'] = $this->Common_model->getAll('buyer_wallet', array('user_id' => $user_id))->row();

            $orderDetail = $this->Order_model->getBuyersOrderbyOrderID($orders_id);

            $pay_amount = round($orderDetail['grand_price'], 2); //From Database    
            $optionChecked = '';
              if (count($check_order) > 0) {
                $order_detail = $check_order;

                /* CHECK PAYMENT IS SUCCESS OR FAIL */
                if (trim($order_status) === 'Success' && $pay_amount == $order_amt) {

                    /* DO what ever you want after successful payment */

                    //Order Request
                    $insertHistory['orders_id'] = $orders_id;
                    $insertHistory['status'] = 16;
                    $insertHistory['date_added'] = date('Y-m-d H:i:s');
                    $insertHistory['comment'] = 'Order Accepted';
                    $insertHistory['customer_notified'] = 1;
                    $this->Common_model->insert('orders_history', $insertHistory);

                    //change available_quantity in product_details table
                    //iff available qty is > buyer buying qty then accept order
                    //else keep order in waiting as available qty is less
                    $order_qty_available = $this->Order_model->reduceProductQty($orders_id);

                    if ($order_qty_available > 0) {
                        $updata['orders_status'] = 10;
                        
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
                        
                    } else {
                        $updata['orders_status'] = 22;
                    }

                    $updata['payment_method'] = $paymnt_mode;
                    $updata['wallet_option'] = $param_wallet_option;
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

                        if ($order_qty_available > 0) {
                            $orderHistory['status'] = 10;
                            $orderHistory['comment'] = 'Order in Processing !';
                        } else {
                            $orderHistory['status'] = 22;
                            $orderHistory['comment'] = 'Order in waiting as product available'
                                    . ' quantity is less than buyer wants!';
                        }

                        //Order History
                        $orderHistory['orders_id'] = $orders_id;
                        $orderHistory['date_added'] = date('Y-m-d H:i:s');

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

                        $chk_total_amount = $order_amt + $data['bal']->balance;

                        if ($param_wallet_option === 'checked' && $chk_total_amount >= $data['bal']->balance) {
                            // $update_wallet_amt=$order_amt-$data['bal']->balance;
                            $wallet_amount = $this->session->userdata('update_wallet_amount_payment');

                            $UpdateWalletResult = $this->Wallet_model->update_wallet_amount($data['bal']->id, round($wallet_amount, 2));
                        }
                    } else {

                        $msg = '<i class="fa fa-exclamation-triangle" aria-hidden="true"></i><div align="center" style="color: red;">

                                   <div id="login-error" class="form-error notice notice-error">
                                      <span class="icon-notice icon-error"></span>
                                      <span>Error ! Order Not Found !</span>
                                   </div>
                                </div>';
                        $this->session->set_flashdata('message', $msg);
                    }

                    // redirect('welcome/success');
                    // exit;
                } else {
                    /* do whatever you want after failure */
                    $msg = '<i class="fa fa-exclamation-triangle" aria-hidden="true"></i><div align="center" style="color: red;">
                                       <div id="login-error" class="form-error notice notice-error">
                                          <span class="icon-notice icon-error"></span>
                                          <span>Error ! Payment Cancelled Successfully.! Amount added to Your walletr.!</span>
                                       </div>
                                    </div>';
                    $this->session->set_flashdata('message', $msg);
                }
            } else if ($check_order->num_rows() > 0) {
                $msg = "<div class='alert alert-danger alert-dismissible'>
                                    <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                                    <strong>Error !</strong> Payment Already Done.Try Other Order.!
                                  </div>";
                
                $this->session->set_flashdata('message', $msg);
                redirect('buyer-orders/');
            }

            $up = 0;

            if ($orderDetail['wallet_option'] === 'checked' && $chk_total_amount >= $data['bal']->balance) {
                //Insert Payment Transaction
                $payData['payment_id'] = $tracking_id; //Tras Id
                $payData['user_id'] = $user_id;
                $payData['email'] = $email_id;
                $payData['contact'] = $phone_no;
                $payData['orders_id'] = $orders_id;
                $payData['amount'] = $amt_to_pay;
                $payData['currency'] = $currency;
                $payData['status'] = $order_status;
                $payData['method'] = 'wallet_' . $paymnt_mode;
                $payData['platform'] = 'Web';
                $payData['payment_by'] = 'billdesk';
                $payData['description'] = 'Order # ' . $orders_id;
                $payData['created_at'] = $trans_date;

                $up = $this->Common_model->insert('order_payment', $payData);
            } else {

                //Insert Payment Transaction
                $payData['payment_id'] = $tracking_id; //Tras Id
                $payData['user_id'] = $user_id;
                $payData['email'] = $email_id;
                $payData['contact'] = $phone_no;
                $payData['orders_id'] = $orders_id;
                $payData['amount'] = $amt_to_pay;
                $payData['currency'] = $currency;
                $payData['status'] = $order_status;
                $payData['method'] = $paymnt_mode;
                $payData['platform'] = 'Web';
                $payData['payment_by'] = 'billdesk';
                $payData['description'] = 'Order # ' . $orders_id;
                $payData['created_at'] = $trans_date;
                $up = $this->Common_model->insert('order_payment', $payData);
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
    }

    public function failed() {

        $msg = "<div class='alert alert-danger alert-dismissible'>
                                    <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                                    <strong>Error !</strong> Payment Cancelled Successfully.! Amount added to Your wallet.!
    </div>";


        $this->session->set_flashdata('message', $msg);
        redirect(base_url() . "buyer-orders");
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

}
