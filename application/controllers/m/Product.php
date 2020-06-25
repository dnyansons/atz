<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Product extends CI_Controller {
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
        $this->load->model('Wallet_model');
        $this->load->model('Offer_model');
        $this->load->library("get_header_data");
        $this->load->library('Shiprocket');
        $this->load->library('Shipping');
        $this->load->library('Send_data');
        $this->load->library('email');
        $this->load->library('browser_notification');
    }

    public function index() {
        $this->load->view("mobile/product_view");    
    }

    function ship_order($order_id = 0) {
      
        $user_id = $this->session->userdata('user_id');
        $data['bal']=$this->Common_model->getAll('buyer_wallet',array('user_id'=>$user_id))->row();
        $user_role = $this->session->userdata('user_role');
        $ord = $this->Common_model->getAll('orders', array('orders_id' => $order_id))->row();
       
       if ($ord->user_id == $user_id)
       {
            //printr($ord->user_id );
            $check_order = $this->Order_model->check_accepted_order($order_id);
            if (count($check_order) > 0) {
            $order_detail = $check_order;

            $pro_id = $order_detail['products_id'];
            $unit_price = $this->Order_model->get_unit_price($pro_id);
            $pro_detail = $this->Order_model->get_product_detail($pro_id);
            $data['res'] = $pro_detail->row_array();
            $data['order_dtail'] = $order_detail;
            $data['price_per'] = $unit_price->result_array();
            $data['quantity'] = $order_detail['products_quantity'];
            $data['qty_price_per'] = $order_detail['final_price'];

            if ($order_detail['orders_status'] == '17') {
                //Rejected
                $data['pending_order'] = 'Rejected';
                $this->load->view('front/order/payment', $data);
                $this->load->view('front/common/footer');
                
            } elseif ($order_detail['orders_status'] == '8') {
                $ship_method = $this->send_data->get_shipping_method();
                $chech_shipp = $this->Common_model->getAll('shipping_vendor', array('id' => $ship_method))->row();
                   //Check Shipping Status
                $data['shipping_type']=$chech_shipp->shipping_type;             
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
                $data['return_url'] = base_url() . 'm/product/callback';

                //Accepted
                $data['pending_order'] = 'Accepted';
                //Ship Address
                $pr_details = $this->Order_model->getOrderDetails($order_id);
                $data['seller_info'] = $this->Product_model->getSellerInformation($pr_details[0]->seller_id);
                $data['details'] = json_decode($pr_details[0]->product_specifications);
                $user_address = $this->Users_model->getDefaultAddressBook($user_id);
                $products = $this->Product_model->getProductDetails($pro_id);
                $sellerinfo = $this->Users_model->getSellerInfo($pr_details[0]->seller_id);
                // Get PRoduct Range Price
                $price_range=$this->Product_model->getProductPriceByQuantity($pro_id,$data['quantity']);
                $data['user_address'] = $user_address;
                $data['productsinfos'] = $products;
                $data['sellerinfos'] = $sellerinfo;
                $data['price_range']=$price_range;
                $this->load->view('mobile/payment_view', $data);
            } else {
                redirect(base_url() . "product/atz_messgae");
            }
        } else {
            redirect(base_url() . "product/atz_messgae");
        }
      }
    }

    // Cart Multiple Product
    function ship_cart_product($order_id = 0) {
       if (!$this->session->userdata("user_logged_in")){
            redirect("signin", "refresh");
        } else { 
            
            if(!$this->checkBannedUser()) {
                //here we will check before payment wheather the user has been banned
                //iff banned will be logged out of account
                //Did this for excel row number 184 by vishal ....tester issue
                session_unset();
                $this->session->set_flashdata('message', 'Your account has been banned! Please contact support!');
                redirect("signin", "refresh");
            }
        
            $user_id = $this->session->userdata('user_id');
            $data['bal']=$this->Common_model->getAll('buyer_wallet',array('user_id'=>$user_id))->row();
            $check_order = $this->Order_model->check_accepted_order($order_id);
             if (count($check_order) > 0) {
                $order_detail = $check_order;
                $pr_details = $this->Order_model->getOrderDetails($order_id);
                
               $data['order_dtail'] = $order_detail;
               // remove from cart done From callback Url
               $cart_products = $this->Product_model->getCartProducts_Byid($order_detail['seller_id'],$order_detail['user_id']);

                if ($order_detail['orders_status'] == '17') {
                    //Rejected
                    $data['pending_order'] = 'Rejected';
                    $this->load->view('front/order/payment', $data);
                    $this->load->view('front/common/footer');
                    
                 }elseif ($order_detail['orders_status'] == '8') {

                $data['productinfo'] = 'Product Description';
                $data['txnid'] = time();
                $data['surl'] = site_url() . 'userorder/success';
                $data['furl'] = site_url() . 'userorder/failed';
                $data['key_id'] = RAZOR_KEY_ID;
                $data['currency_code'] = 'INR';
                $data['total'] = $order_detail['order_price']*100;
                
                $data['amount'] = $order_detail['order_price'];
                $data['merchant_order_id'] = $order_id;
                $data['card_holder_name'] = $order_detail['user_name'];
                $data['email'] = $this->session->userdata('user_email');
                $data['phone'] = $this->session->userdata('phone');
                $data['name'] = 'ATZ Cart';
                $data['return_url'] = base_url() . 'm/product/callback';

                //Accepted
                $data['pending_order'] = 'Accepted';
                //Ship Address
                $user_address = $this->Users_model->getDefaultAddressBook($user_id);                
                $i=0;
                foreach($pr_details as $pr_detail){ 
                   $pr_details[$i]->prod_decode= json_decode($pr_detail->product_specifications);
                   $pr_details[$i]->images = $this->Product_model->getproduct_image($pr_detail->products_id);
                   $pr_details[$i]->units=$this->Product_model->getUnitNameByProductId($pr_details[$i]->products_id); 
                   $i++;
                }
                $data['seller_info'] = $this->Product_model->getSellerInformation($pr_details[0]->seller_id);
                $data['productsinfos'] = $pr_details; 
                $data['user_address'] = $user_address;
                
//              Please Check Cart_product is Uncomment;
                foreach($cart_products as $cartproduct)
                {
                    $cart_pro_arr[]=$cartproduct['product_id'];
                    $cart_user_id=$cartproduct['user_id'];
                }
                $data["cart_implode_arr"]=implode(',',$cart_pro_arr);
                $data["cart_user_id"]=$cart_user_id;
                $ship_method = $this->send_data->get_shipping_method();
                $chech_shipp = $this->Common_model->getAll('shipping_vendor', array('id' => $ship_method))->row();
                   //Check Shipping Status
                $data['shipping_type']=$chech_shipp->shipping_type;
                $data['free_amount']=$chech_shipp->free_amount;
                $this->load->view('mobile/payment_cart_view_new', $data);
             }else {
                    redirect(base_url() . "product/atz_messgae");
                }   
           }else {
                redirect(base_url() . "product/atz_messgae");
            }
        }
    }
    
     function send_email_order_placed($order_id) {
       $dat = $this->Common_model->getAll('orders', array('orders_id' => $order_id))->row();
       $data['order_desc'] = $this->Common_model->getAll('orders_products', array('orders_id' => $order_id))->result();
       $buyer_email = $dat->user_email_address;       
       $seller_email = $dat->pick_email;
       $data['user_name'] = $dat->user_name;
       $data['pick_name'] = $dat->pick_name;
       $data['order_price'] = $dat->order_price;
       $data['shipping_cost'] = $dat->shipping_cost;
       $data['orders_id'] = $dat->orders_id;
       
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
        
    public function callback() 
    { 
        if (!empty($this->input->post('razorpay_payment_id')) && !empty($this->input->post('merchant_order_id'))) {

            /* Getting Product id Array and User Id from Hidden Field*/
            $cart_pro_str = $this->input->post('cart_pro_arr');
            $cart_pro_arr=explode(",",$cart_pro_str);
            $cart_user_id = $this->input->post('cart_user_id');
            $seller_phone=$this->input->post('seller_phone');
            $wallet_option1 = $this->input->post('wallet_option1');    
            
            //Remove Product From Cart
            $this->Product_model->removeAllProductsOfOrder_id($cart_user_id,$cart_pro_arr);
            
            $this->session->unset_userdata("start_order_page");
            $this->session->unset_userdata("prev_page");
            /***************************************************/
            // Destroy Specification from Session which Store to show Order_view
            $this->session->unset_userdata("specifications");
            $this->session->unset_userdata("spec_id");
            $this->session->unset_userdata("spec_value");
            $this->session->unset_userdata("moq");
            $this->session->unset_userdata("unit");
            $this->session->unset_userdata("qty_value");
            /***************************************************/
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
                     $wallet_amt=0;
                     $UpdateWalletResult= $this->Wallet_model->update_wallet_amount($data['bal']->id,round($wallet_amt,2));

                    if ((int) $pay_amount1 != (int) $amt_to_pay) {
                        $msg = '<div class="alert alert-danger" role="alert">Somthing Went Wrong !</div>';
                        $this->session->set_flashdata('message', $msg);
                        redirect('userorder/ship_order/' . $orders_id);
                    }
                } else {
                    $pay_amount1 = round($orderDetail['grand_price'], 2); //From Database
                    
                }

                if ((trim($array[4]) == 'authorized') && (trim($pay_amount1) == trim($amt_to_pay))) {

                    $updata['orders_status'] = 10;
                    $updata['wallet_option'] = $wallet_option1;
                    $up = $this->Common_model->update('orders', $updata, array(
                        'orders_id' => $orders_id,
                        'orders_status' => 8
                    ));

                    if ($up) {
                        
                        $output["data"] = $this->Order_model->getBuyersOrderbyOrderID($orders_id);
                        $output["status"] = 1;
                        $output["message"] = "Order Placed Successfully !";
                        
                        //Order Accepted
                        $insertHistory['orders_id'] = $orders_id;
                        $insertHistory['status'] = 16;
                        $insertHistory['date_added'] = date('Y-m-d H:i:s');
                        $insertHistory['comment'] = 'Order Accepted';
                        $insertHistory['customer_notified'] = 1;
                        $this->Common_model->insert('orders_history', $insertHistory);
                        
                        //Order History
                        $orderHistory['orders_id'] = $orders_id;
                        $orderHistory['status'] = 10;
                        $orderHistory['date_added'] = date('Y-m-d H:i:s');
                        $orderHistory['comment'] = 'Order in Processing !';

                        $this->Common_model->insert('orders_history', $orderHistory);

                       $orderDetails = $this->Order_model->getOrderDetailsByOrderId($orders_id);
                       $count = count($orderDetails);
                       $j = 0;
                       $pro_name = array();
                       $products_quantity = 0;

                       while ($j < $count) {
                           $pro_name[] = $orderDetails[$j]['product_name'];
                          // $products_quantity = $products_quantity + $orderDetails[$i]['products_quantity'];
                           $j++;
                       }
                        $pro_name= implode(",",$pro_name);
                        //Send SMS To Buyer
                        $message = 'Order Placed: Your Order for Product '. $pro_name .' with Order ID- #ORD' . $orders_id . ' is placed and Rs.' . $pay_amount . ' has been received towards your order. We will let you know the Expected delivery date when your order is Packed by the Seller. We will keep you updated as and when your order is Packed/Shipped. You can manage your order at- www.atzcart.com.';
                        $mob = $this->session->userdata('phone');
                        $this->send_sms($message, $mob);
                 
                        //Send SMS To Seller
                        $seller_mob = $orderDetail['pick_mobile'];
                        
                        $message = 'Order Placed: Order Placed Successfully: Beautiful Set Of ' . $pro_name . ', Order ID- #ORD' . $orders_id . ' is Placed and Amount Received is Rs. ' . $pay_amount . '. You can Track the order on atzcart.com.';
                        //$message = 'You have a new order from buyer '.$this->session->userdata('user_name'). ' with order #ORD'.$orders_id. ' Please Visit atzcart.com for further process.';
                        $this->send_data->send_sms($message,$seller_mob);
          
                        //Notification Sellers
                        $seller_id=$orderDetail['seller_id'];
                        $title='New Order';
                        $msg=" From ".$this->session->userdata('user_name').' with order #ORD'.$orders_id;
                        $tag='atzcart.com';
                        $this->browser_notification->notifyseller($seller_id,$title,$msg,$tag); 
                        //insert in adminnotify table
                        $adminNotify = array(
                            'title'	=> 'New Order',
                            'msg'  	=> $msg.' ( Mobile Web ) ',
                            'type' 	=> 'order_place',
                            'reference_id'  => $orders_id,
                            'status'	=> 'Received'
                        );  
                        
                        $sellerNotify = array(
                            'title' => 'New Order',
                            'msg' => $msg,
                            'type' => 'order_place',
                            'reference_id' => $orders_id,
                            'status' => 'Received'
                        );

                        $insertAdminNotify = $this->Product_model->insertAdminNotify($adminNotify);
                        $insertSellerNotify = $this->Product_model->insertSellerNotify($sellerNotify);


                        $this->browser_notification->notifyadmin('New Order Placed !', $msg, $tag);
                        
                        // Send Orderplaced Email Both Buyer and Seller
                        $this->send_email_order_placed($orders_id);
                        $msg = '<i class="fa fa-check-circle" aria-hidden="true"></i><div align="center" style="color: green;">
                                   <div id="login-error" class="form-error notice notice-success">
                                      <span> Order Placed Successfully !</span>
                                   </div>
                                </div>';
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

                if ($wallet_option1 === 'checked' && $pay_amount >= $data['bal']->balance)
                {
                    //Insert Payment Transaction
                    $payData['payment_id'] = $array[0]; //Tras Id
                    $payData['user_id'] = $user_id;
                    $payData['email'] = $array[17];
                    $payData['contact'] = $array[18];
                    $payData['orders_id'] = $orders_id;
                    $payData['amount'] = ($array[2] / 100);
                    $payData['currency'] = $array[3];
                    $payData['status'] = 'wallet_'.$array[4];
                    $payData['method'] = $array[8];
                    $payData['platform'] = 'Web';
                    $payData['payment_by'] = 'razorpay';
                    $payData['description'] = $array[12];
                    $payData['created_at'] = date('Y-m-d H:i:s');
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
                    $payData['created_at'] = date('Y-m-d H:i:s');
                }
                $up = $this->Common_model->insert('order_payment', $payData);
                //Redirct to Page
                redirect(base_url() . "product/order_success/".$orders_id);
            } else {
                redirect(base_url() . "product/atz_messgae");
            }
        } else {  
            redirect(base_url() . "product/atz_messgae");
        }
    }

    function pickupregister($orders_id = 0) {
        //Get Order
        $orderDetails = $this->Order_model->getOrderDetailsById($orders_id);
        $order_product = $this->Order_model->getOrderProducts($orders_id);
        //get Area Code
        $areaCode_q = $this->Common_model->getAll('order_accepted_dimention', array(
                    'orders_id' => $orders_id
                ))->row_array();
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


        $this->Common_model->update('orders', $ship_date, array(
            'orders_id' => $orders_id
        ));

        $paddress = $this->Common_model->getAll('seller_pick_address', array(
                    'pick_id' => $pick_id
                ))->row_array();

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
        $pickData['ShipmentPickupTime'] = '13:00';
        $pickData['VolumeWeight'] = $total_weight;
        $pickData['WeightofShipment'] = $total_weight;
        if ($areaCode == 'PNQ') {
            $pickData['isToPayShipper'] = 'false';
        } else {
            $pickData['isToPayShipper'] = 'True';
        }

        //From Api Pick Up Registration and Way Billl Generation
        $token_no = $this->shipping->pickupRegistration($pickData);
        if (!empty($token_no)) {
            $dat['order_token_number'] = $token_no["token"];
            $this->Common_model->update('orders', $dat, array(
                'orders_id' => $orders_id
            ));
        }
    }

    public function start_order($product_id) 
    {
        if (!$this->session->userdata("user_logged_in")) {
            redirect("signin", "refresh");
        } else {
            $user_id = $this->session->userdata('user_id');
            $user_address = $this->Users_model->getDefaultAddressBook($user_id);
            $products = $this->Product_model->getProductDetails($product_id);
            $sellerinfo = $this->Users_model->getSellerInfo($products['seller']);
            
            $data['user_address'] = $user_address;
            $data['productsinfos'] = $products;
            $product_prices     =   $products['product_prices'];
            $data['product_prices'] = $product_prices;
            $data['sellerinfos'] = $sellerinfo;
            
            $data['moq'] = $this->input->post("hidemoq");
            $data['unit'] = $this->input->post("hideunit");
            $data['pro_id'] = $this->input->post("hidepro_id");
            $data['spec_id'] = $this->input->post("hidespec_id");
            $data['spec_value'] = $this->input->post("hidespec_value");
            $data['qty_value'] = $this->input->post("hideqty_value");            $data['unit_price'] = $this->input->post("hideunit_price");
            $offer_id = $this->input->post("hideoffer_id");
            
            if(!empty($offer_id))
            {
                $data["prod_total_price"]= $data['unit_price'];
            }else{
                if(!empty($data['pro_id']) && !empty($data['qty_value'])){
                $total_price=$this->Product_model->getProductPriceByQuantity($this->input->post("hidepro_id"),$this->input->post("hideqty_value"));     
                $data["prod_total_price"]=$total_price;
                 }
            }

            /*------------------Start Showing Specification at Start Order Page-----------------*/
            $specid_arr=explode(",",$data['spec_id']);
            $specval_arr=explode(",",$data['spec_value']);
            $results=$this->Product_model->getSpecification($specid_arr,$specval_arr,$data['pro_id']);
            $i=0;
            foreach($results as $result){
                $results[$i]["spec"]=$this->Product_model->specName($result['spec_id']); 
                $i++;
            }
              
           //  Set Specification On Order View Page, Its Destroy After adding address 
           //  or change Address so now We Store Spcification at session. 
           //    $data["specifications"]= $results; // This is old Code Before Saving Specification on Session.
               $this->session->set_userdata("spec_id",$data['spec_id']);
               $this->session->set_userdata("spec_value",$data['spec_value']);
               $this->session->set_userdata("qty_value",$data['qty_value']);
               $this->session->set_userdata("moq",$data['moq']);
               $this->session->set_userdata("unit",$data['unit']);
               $data["specifications"]= $this->session->set_userdata("specifications",$results); 
           
            /*------------------End Showing Specification at Start Order Page-------------------*/
            /* Product Offer Start Here */
            $offerRunningStatus = $this->Offer_model->checkOfferValidity(
                                        $data['productsinfos']['valid_from'] . ' ' . $data['productsinfos']['time_from'],
                                        $data['productsinfos']['valid_to'] . ' ' . $data['productsinfos']['time_to'],
                                        $data['productsinfos']['offer_status']);

            if($offerRunningStatus == true) {
                    for ($i = 0; $i < count($product_prices); $i++) {
                        $product_prices[$i]->mrp = $product_prices[$i]->atz_price;
                        if(strtolower($data['productsinfos']['offer_type']) == 'flat') {
                            $data['productsinfos']['discount'] = '<i class="fa fa-inr"></i> '.$data['productsinfos']['offer_discount_value']. ' OFF';
                            $product_prices[$i]->final_price = $product_prices[$i]->atz_price - $data['productsinfos']['offer_discount_value'];
                        }
                        
                        if(strtolower($data['productsinfos']['offer_type']) == 'percentage') {
                            $data['productsinfos']['discount'] = $data['productsinfos']['offer_discount_value'].'% OFF';
                            $product_prices[$i]->final_price = $product_prices[$i]->atz_price - ($product_prices[$i]->atz_price * $data['productsinfos']['offer_discount_value'] * 0.01);
                        }
                    }
                } else {
                    $data['product_prices'] = $productinfos['product_prices'];
                    $data['productsinfos']['discount'] = $data['productsinfos']['discount']. ' % OFF';
                }
            /* Product Offer End Calculation */    
            $last_page="start_order/".$product_id;
            $this->session->set_userdata('start_order_page',$last_page);
            //printr($results);
            $this->load->view("mobile/order_view", $data);
        }
    }
        /*
            @author Ishwar290819
            This function is used display to notify status for uses
        */
      public function add_notify_buyer() { 
        if ($this->session->has_userdata('user_id')) {
            $inserted = 0;
            $product_id = $this->input->post('product_id');
            $buyer_id = $this->session->user_id;
            $checkDuplicate = $this->db->select('id')->from('product_notify_list')
                ->where(array('product_id' => $product_id, 'user_id' => $buyer_id))
                ->where('date_user_notified is null')
                ->get()->result_array()[0];
            if ($checkDuplicate['id'] > 0) {
                echo "2"; //ajaxresponse
            } else {
                $inserted = $this->db->insert('product_notify_list', array('product_id' => $product_id, 'user_id' => $buyer_id));
                echo $inserted; //ajaxresponse
            }
        } else {
            echo 'Invalid Access!';
        }
    }

    public function add_shipping_address() 
    {
        if (!$this->session->userdata('user_id')) {
            redirect("signin", "refresh");
        } else {
            $user_id = $this->session->userdata('user_id');
            $data['address'] = $this->Users_model->get_buyer_info1($user_id);
            $this->load->view("mobile/shipping_address", $data);
        }
    }

    public function change_address() {
        $address_id = $this->input->post('address_id');
        $user_id = $this->input->post('user_id');
        $this->Users_model->setDefaultAddress($user_id, $address_id);
    }

    public function shipping_form() {
        if (!$this->session->userdata("user_logged_in")) {

            redirect("signin", "refresh");
        } else {
            $this->load->view("mobile/shipping_form_view");
        }
    }
    
    public function edit_shipping_form($address_id) {
        if (!$this->session->userdata("user_logged_in")) {
            redirect("signin", "refresh");
        } else {
            $data['user_address']=$this->Users_model->getAddressBookById($address_id);
            $this->load->view("mobile/edit_shipping_form_view",$data);
        }
    }

    /**
     * @auther Yogesh Pardeshi
     * @param $address_id takes pk of id 
     * 04-07-2019
     */
    public function delete_shipping_address($address_id)
    {
        $address_id = $this->security->xss_clean($address_id);
        if (!$this->session->userdata("user_logged_in")) {
            redirect("signin", "refresh");
        } else {
            $this->db->delete('address_book', array("address_book_id" => $address_id));
            $msg = '<div class="text-success ml-2 del_shipping_address"><strong>Success!</strong> Address Deleted Successfully.</div>';
            $this->session->set_flashdata("message",$msg);
            redirect("product/add_shipping_address");
        }
    }
    
    public function update_shipping_form(){
        
        if (!$this->session->userdata("user_logged_in")) {
            redirect("signin", "refresh");
            
        } else {
//          updateAddressBook($id, $data);
            $this->form_validation->set_rules("contact_person", "Contact Person", "required");
            $this->form_validation->set_rules("address_type", "Address Type", "required");
            $this->form_validation->set_rules("street", "Street Description","required");
            $this->form_validation->set_rules("city", "City", "required");
            $this->form_validation->set_rules("state", "State", "required");
            $this->form_validation->set_rules("postcode", "Zip code", "required|numeric|max_length[6]");
            $this->form_validation->set_rules("contact_number", "Mobile Number", "required|numeric|max_length[10]");
            if ($this->form_validation->run() === false) { 
                $address_id=$this->input->post('hide_address_id');
                $this->form_validation->set_error_delimiters('<div class="error" style="text-color:red">', '</div>');
                $data['user_address']=$this->Users_model->getAddressBookById($address_id);       
                $this->load->view("mobile/edit_shipping_form_view");   
           
            }else{
                
                $address_id=$this->input->post('hide_address_id');   
                $contact_person=$this->input->post('contact_person');
                $address_type=$this->input->post('address_type');
                $country=$this->input->post('country');
                $street=$this->input->post('street');
                $alternateAddress=$this->input->post('alternateAddress');
                $city=$this->input->post('city');
                $state=$this->input->post('state');
                $postcode=$this->input->post('postcode');
                $contact_number=$this->input->post('contact_number');
                
                $ship_method = $this->send_data->get_shipping_method();
                if ($ship_method == 1) {
                        $check_postcode = $this->Shipping_model->get_buyer_area($postcode);
                        if (empty($check_postcode)) {
                            $msg="Sorry ! Not Deliverble Pincode.";
                            $this->session->set_flashdata("address_msg",$msg); 
                            redirect("product/shipping_form/".$address_id);
                        }
                    }
                    if ($ship_method == 2) {
                        
                        $seller_pincode = 411057;
                        $res = $this->shiprocket->serviceability($seller_pincode, $postcode, 1, 0.5, 0.5, 0.5, 1);
                        if ($res['status'] != 200) {
                            $msg="Sorry ! Not Deliverble Pincode.";
                            $this->session->set_flashdata("address_msg",$msg); 
                            redirect("product/edit_shipping_form/".$address_id);
                        }
                    }
                
                $data=array(
                    "address_book_id"=>$address_id,
                    "contact_person"=>$contact_person,
                    "tag"=>$address_type,
                    "contact_number"=>$contact_number,
                    "street"=>$street,
                    "suburb"=>$alternateAddress,
                    "postcode"=>$postcode,
                    "city"=>$city,
                    "state"=>$state,
                    "country"=>$country,
                    );

                $this->Users_model->updateAddressBook($address_id,$data);
                $msg="Address Updated Successfully.";
                $this->session->set_flashdata("update_address_msg",$msg);
                redirect("product/".$this->session->userdata("start_order_page"));
            }
        }
    }

    public function submit_shipping_form() {  
        if (!$this->session->userdata("user_logged_in")) {
            redirect("signin", "refresh");
        } else {   
            $this->form_validation->set_rules("contact_person", "Contact Person", "required");
            $this->form_validation->set_rules("address_type", "Address Type", "required");
            $this->form_validation->set_rules("street", "Street Description","required");
            $this->form_validation->set_rules("city", "City", "required");
            $this->form_validation->set_rules("state", "State", "required");
            $this->form_validation->set_rules("postcode", "Zip code", "required|numeric|max_length[6]");
            $this->form_validation->set_rules("contact_number", "Mobile Number", "required|numeric|max_length[10]");   
            //$insert_shipping_add = $this->input->post();
            if ($this->form_validation->run() === false) { 
                  $this->form_validation->set_error_delimiters('<div class="error" style="text-color:red">', '</div>');
                  $this->load->view("mobile/shipping_form_view");   
            }else{
                $user_id=$this->input->post('hide_user_id');
                $contact_person=$this->input->post('contact_person');
                $address_type=$this->input->post('address_type');
                $country=$this->input->post('country');
                $street=$this->input->post('street');
                $alternateAddress=$this->input->post('alternateAddress');
                $city=$this->input->post('city');
                $state=$this->input->post('state');
                $postcode=$this->input->post('postcode');
                $contact_number=$this->input->post('contact_number');
                
                $ship_method = $this->send_data->get_shipping_method();
                if ($ship_method == 1) {
                        $check_postcode = $this->Shipping_model->get_buyer_area($postcode);
                        if (empty($check_postcode)) {
                            $msg="Sorry ! Not Deliverble Pincode.";
                            $this->session->set_flashdata("address_msg",$msg); 
                            redirect("product/shipping_form");
                        }
                    }
                    if ($ship_method == 2) {
                        
                        $seller_pincode = 411057;
                        $res = $this->shiprocket->serviceability($seller_pincode, $postcode, 1, 0.5, 0.5, 0.5, 1);
                        if ($res['status'] != 200) {
                            
                            $msg="Sorry ! Not Deliverble Pincode.";
                            $this->session->set_flashdata("address_msg",$msg); 
                            redirect("product/shipping_form");
                        }
                    }
                
                $insert_shipping_add=array(
                    "address_book_id"=>$address_id,
                    "user_id"=>$user_id,
                    "contact_person"=>$contact_person,
                    "tag"=>$address_type,
                    "contact_number"=>$contact_number,
                    "street"=>$street,
                    "suburb"=>$alternateAddress,
                    "postcode"=>$postcode,
                    "city"=>$city,
                    "state"=>$state,
                    "country"=>$country,
                    );
                
                $msg="Address Added Successfully.";
                $this->session->set_flashdata("update_address_msg",$msg);    
                $address_id=$this->Users_model->addAddressBook($insert_shipping_add); 
                $this->Users_model->setDefaultAddress($user_id, $address_id);
                $redirecttostartorder = "product/".$this->session->userdata("start_order_page");
                redirect($redirecttostartorder, "refresh");
            }
        }
    }

    public function success_enquiry() {
        $this->load->view("mobile/enquiry_sent_view");
    }

    public function send_enquiry($product_id) {
        if (!$this->session->userdata("user_logged_in")) {
            redirect("signin", "refresh");
        } else {
            $products = $this->Product_model->getProductDetails($product_id);
            $sellerinfo = $this->Users_model->getSellerInfo($products['seller']);
            $data['productsinfos'] = $products;
            $data['sellerinfos'] = $sellerinfo;
            //$data['product_id'] = $product_id;
            $this->load->view("mobile/enquiry_view", $data);
        }
    }

    public function product_enquiry() {
        if (!$this->session->userdata("user_logged_in")) {
            redirect("signin", "refresh");
        } else {

            $product_id = $this->security->xss_clean($this->input->post('prod_id'));
            $this->form_validation->set_rules("quantity", "Quantity", "required|greater_than[0]",
                                                array('greater_than' => 'Quantity must not be zero!'));
            $this->form_validation->set_rules("product_description", "Product Description", 'required');

            if ($this->form_validation->run() === false) {
                $products = $this->Product_model->getProductDetails($product_id);
                $sellerinfo = $this->Users_model->getSellerInfo($products['seller']);
                $data['productsinfos'] = $products;
                $data['sellerinfos'] = $sellerinfo;
                $this->load->view("mobile/enquiry_view", $data);
            } else {
                $user_id = $this->session->userdata('user_id');
                $todays_date = date("Y-m-d H:i:s");
                $arr['by_user'] = $user_id;
                $arr['for_product'] = $this->input->post('prod_id');
                $arr['quantity'] = $this->input->post('quantity');
                $arr['unit'] = $this->input->post('unit_id');
                $arr['comment'] = $this->input->post('product_description');
                $arr['is_forwarded'] = 0;
                $arr['status'] = 'Pending';
                $result = $this->Inquiries_model->addEnquiry($arr);
                redirect("product/success_enquiry", "refresh");
            }
        }
    }
	
    public function productOverview($product_id) 
    {
        
        $user_id = $this->session->userdata('user_id');
        $cart = $this->Product_model->getCartProducts($user_id);
        $orders = $this->Order_model->order_details($user_id);
        if ($orders) {
            $data['orders_count'] = $orders->orders_status;
        } else {
            $data['orders_count'] = 0;
        }
        
        if ($cart) {
            $data['cart_count'] = count($cart);
        } else {
            $data['cart_count'] = 0;
        }

        $prev_page_info="product/productOverview/" .$product_id;
        
        $this->session->set_userdata("prev_page", $prev_page_info); // set session when goes to supplier page.
        $productinfos = $this->Product_model->getProductDetails($product_id);
       
        $prod_array = array();
        $prod = $this->Product_model->get_recommended_products_by_category($productinfos['category_id'], $productinfos['id']);
        for($i=0;$i<count($prod);$i++) {
                if (strtolower($prod[$i]['offer_status']) == 'active') {
                    $offerRunningStatus = $this->Offer_model->checkOfferValidity(
                            $prod[$i]['valid_from'] . ' ' . $prod[$i]['time_from'],
                            $prod[$i]['valid_to'] . ' ' . $prod[$i]['time_to'],
                            $prod[$i]['offer_status']);
                    
                    if ($offerRunningStatus == true) {

                        if (strtolower($prod[$i]['offer_type']) == 'flat') {
                            
                            $prod[$i]['discount'] = '<i class="fa fa-inr"></i> ' . $prod[$i]['offer_discount_value'] . ' OFF';
                            $prod[$i]['final_price'] = $prod[$i]['mrp'] - $prod[$i]['offer_discount_value'];
                            

                        }
                        if (strtolower($prod[$i]['offer_type']) == 'percentage') {
                            $prod[$i]['discount'] = $prod[$i]['offer_discount_value']."% OFF";
                            $prod[$i]['final_price'] = $prod[$i]['mrp'] - ($prod[$i]['mrp'] * $prod[$i]['offer_discount_value'] * 0.01); 
                        }
                    }else{
                        // this case very rare if offer status active but date and time expired.
                        $prod[$i]['discount'] = $prod[$i]['discount']."% OFF";
                    }
                } else {
                        $prod[$i]['discount'] = $prod[$i]['discount']."% OFF";
                } 
            }
            
       
        foreach ($prod as $products) { 
            $image_url = $this->Product_model->getproduct_image($products['id']);
            $prod_array[] = array(
                'products_id' => $products['id'],
                'products_name' => $products['name'],
                'products_price' => $products['final_price'],
                'max_order_quantity' => $products['quantity_upto'],
                'units_name' => $products['units_name'],
                'products_image' => $image_url->url,
                'discount' => $products['discount'],
                'mrp' => $products['mrp']
            );
        }
        $sellerinfo = $this->Users_model->getSellerInfo($productinfos['seller']);
        /*  Favourite Product HighLight */
        $result = $this->Common_model->getAll('buyer_favourites', array('user_id' => $user_id))->num_rows();
        
        if ($result > 0) {
            $get_exist = $this->Common_model->getAll('buyer_favourites', array('user_id' => $user_id))->row_array();
            $exist_product = json_decode($get_exist['products']);
            if (in_array($product_id, $exist_product)) {
                $data['isColor'] = "#ff6a00";
            }
        }
        $product_prices     =   $productinfos['product_prices'];
        $data['product_prices'] = $product_prices;
        $data['productinfos'] = $productinfos;
        $data['prod_array'] = $prod_array;
        $data['sellerinfos'] = $sellerinfo;

        $offerRunningStatus = $this->Offer_model->checkOfferValidity(
                                        $data['productinfos']['valid_from'] . ' ' . $data['productinfos']['time_from'],
                                        $data['productinfos']['valid_to'] . ' ' . $data['productinfos']['time_to'],
                                        $data['productinfos']['offer_status']);
        
        if($offerRunningStatus == true) {
            for ($i = 0; $i < count($product_prices); $i++) {
                
                $product_prices[$i]->mrp = $product_prices[$i]->atz_price;
                if(strtolower($data['productinfos']['offer_type']) == 'flat') {
                    $data['productinfos']['discount'] = '<i class="fa fa-inr"></i> '.$data['productinfos']['offer_discount_value']. ' OFF';
                    $product_prices[$i]->final_price = $product_prices[$i]->atz_price - $data['productinfos']['offer_discount_value'];
                }

                if(strtolower($data['productinfos']['offer_type']) == 'percentage') {
                    
                    $data['productinfos']['discount'] = $data['productinfos']['offer_discount_value'].' % OFF';
                    $product_prices[$i]->final_price = $product_prices[$i]->atz_price - ($product_prices[$i]->atz_price * $data['productinfos']['offer_discount_value'] * 0.01);
                }
            }
        } else {
            $data['product_prices'] = $productinfos['product_prices'];
            $data['productinfos']['discount'] = $data['productinfos']['discount']. ' % OFF';
        }
        $data["notify_status"] = $this->check_duplicate_notify_buyer($product_id);//iff 1 means user is alredy 
        
        $this->load->view("mobile/product_view", $data);
    }

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

    function order_success($order_id) {      
        $results=$this->Order_model->getOrderProductTrans($order_id);
        $check_order = $this->Order_model->check_accepted_order($order_id);
        $order_products=$this->Order_model->getTrackProductDetails($order_id);
        $data['user_orders']=$order_products;
        $ship_method = $this->send_data->get_shipping_method();
        $data['chech_shipp'] = $this->Common_model->getAll('shipping_vendor', array('id' =>$ship_method))->row();
        $data["results"]=$results;
        $data["orders"]=$check_order;
        $data["orderProduct"]=$order_products;
       
        $this->load->view('mobile/order_success_view',$data);
    }
    
    function order_success_wallet($order_id) {
      if(!empty($order_id))
       {
            $check_order = $this->Order_model->check_accepted_order($order_id);
            $user_id = $this->session->userdata('user_id');
            $email_id=$this->session->userdata('user_email');
            $phone_no=$this->session->userdata('phone');
             
            $data['bal']=$this->Common_model->getAll('buyer_wallet',array('user_id'=>$user_id))->row();
           
            if (count($check_order) > 0) 
            {
               // $order_detail = $check_order->row_array();
                $order_detail = $check_order;               
                $pro_id = $order_detail['products_id'];
                $unit_price = $this->Order_model->get_unit_price($pro_id);
                $pro_detail = $this->Order_model->get_product_detail($pro_id);

                $data['res'] = $pro_detail->row_array();
                $data['order_dtail'] = $order_detail;
                $data['price_per'] = $unit_price->result_array();

                $data['quantity'] = $order_detail['products_quantity'];
              
                $data['qty_price_per'] = $order_detail['final_price'];


                $data['order'] = $order_detail['order_from'];
                $data['wallet'] = $order_detail['wallet_option'];
                
                $receivedwalletAmount=0;   
                if($data['order']==='Start_order')
                {
                     $receivedwalletAmount = $order_detail['order_price'];
                }   
                if($data['order']==='Cart'){
                    $receivedwalletAmount += $order_detail['order_price'];
                }
              
                $update_wallet_amount=0;
                if($data['bal']->balance>=$receivedwalletAmount)
                {
                     $update_wallet_amount=  $data['bal']->balance-$receivedwalletAmount;
                }
                
            $UpdateWalletResult= $this->Wallet_model->update_wallet_amount($data['bal']->id,$update_wallet_amount);
       
            if($UpdateWalletResult>0)
            {
                    $wallet_history['buyer_id']=$data['bal']->user_id;
                    $wallet_history['amount']=round($receivedwalletAmount,2);
                    $wallet_history['previous_amount']=$data['bal']->balance;
                    $wallet_history['current_amount']=round($wallet_amount,2);
                    $wallet_history['transaction_type']='debit';
                    $wallet_history['against']='withdraw';
                    $wallet_history['referrence']='#ORD'.$order_id;
                    $wallet_history['remark']='Amount withdraw to wallet against Order #'.$order_id;

                    $this->Wallet_model->add_wallet_history($wallet_history);

                     //Send SMS to Buyer
                    $message = 'Order Placed: Order Placed Successfully: Order ID- #ORD' . $order_id . ' is Placed and Amount is Received From Wallet Rs. ' .round($receivedwalletAmount,2) . '. You can Track the order on atzcart.com.';
                        $mob = $order_detail['user_telephone'];

                        $this->send_data->send_sms($message, $mob);
                   
                        //sms send to seller
                        $seller_mob = $orderDetails['pick_mobile'];
                        $message = 'You have a new order from buyer ' . $this->session->userdata('user_name') . ' with order #ORD' . $order_id . 'Please Visit ATZCart.com for further process.';
                        $this->send_data->send_sms($message, $seller_mob);
                        
                        //Notify To Seller
                        $seller_id = $orderDetail['seller_id'];
                        $title = 'New Order';
                        $msg = " From " . $this->session->userdata('user_name') . ' with order #ORD' . $order_id;
                        $tag = 'atzcart.com';
                        $this->browser_notification->notifyseller($seller_id, $title, $msg, $tag);
                        
                         //insert in adminnotify table
                        $msg_buyer = "New Order Placed with order #ORD" . $order_id . ' Click to track Order ';
                        $adminNotify = array(
                            'title' => 'New Order',
                            'msg' => $msg . ' ( Mobile Web ) ',
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
                    
                        $payData['payment_id'] = time(); //Tras Id
                        $payData['user_id'] = $user_id;
                        $payData['email'] = $email_id;
                        $payData['contact'] = $phone_no;
                        $payData['orders_id'] = $order_id;
                        $payData['amount'] = round($order_detail['order_price'],2);
                        $payData['currency'] = 'INR';
                        $payData['status'] = 'success';
                        $payData['method'] = 'wallet';
                        $payData['platform'] = 'Mobile Web';
                        $payData['payment_by'] = 'wallet';
                        $payData['description'] = 'Order # '.$order_id;
                        $payData['created_at'] = date('Y-m-d H:i:s');
                        
                    $up = $this->Common_model->insert('order_payment', $payData);
            
            if ($order_detail['orders_status'] == '17') {
                    //Rejected
                    $data['pending_order'] = 'Rejected';

                    $this->load->view('front/order/payment', $data);
                    $this->load->view('front/common/footer');
                } elseif ($order_detail['orders_status'] == 10) {

                  $results=$this->Order_model->getOrderProductTrans($order_id);
                  $data["results"]=$results;

                  $ship_method = $this->send_data->get_shipping_method();
                  $chech_shipp = $this->Common_model->getAll('shipping_vendor', array('id' => $ship_method))->row();
                  $this->load->view('mobile/order_success_view',$data);
                }  
             }
          }
          else
            {
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
                redirect(base_url() . "product/atz_success_wallet/".$order_id);
        }
       }
       else
       {
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
                redirect(base_url() . "product/atz_success_wallet/".$order_id);
       }   
    }

    
    function atz_messgae() { 
        //$this->load->view('mobile/home');
        $this->load->view('mobile/order_failure_view');
    }

    // Adding Favourite Product
    function add_favourite_product() {
        $user_id = $this->session->userdata('user_id');
        if ($user_id) {

            $product_id = $this->input->post('product_id');
            $result = $this->Common_model->getAll('buyer_favourites', array('user_id' => $user_id))->num_rows();

            if ($result > 0) {
                $get_exist = $this->Common_model->getAll('buyer_favourites', array('user_id' => $user_id))->row_array();
                $exist_product = json_decode($get_exist['products']);
                if (in_array($product_id, $exist_product)) {
                    $output["status"] = 1;
                    $output["message"] = "<h4 class='text-success'>Already Added In Favourite !</h4>";
                    echo json_encode($output);
                } else {
                    array_push($exist_product, $product_id);
                    $insertdata['products'] = json_encode($exist_product, JSON_NUMERIC_CHECK);
                    $this->Common_model->update("buyer_favourites", $insertdata, array('user_id' => $user_id));
                    $output["status"] = 2;
                    $output["message"] = "<h4 class='text-success'>Product has been Added To Favourite !</h4>";
                    echo json_encode($output);
                }
            } else {

                $arr = array($product_id);
                $insertdata['user_id'] = $user_id;
                $insertdata['products'] = json_encode($arr);
                $insertdata['suppliers'] = json_encode(array());
                $insertdata['created_at'] = date('Y-m-d H:i:s');
                $this->Common_model->insert("buyer_favourites", $insertdata, array('user_id' => $this->_payload->userid));
                $output["status"] = 2;
                $output["message"] = "<h4 class='text-success'>Product has been Added To Favourite !</h4>";
                echo json_encode($output);
            }
        } else {
            $output["status"] = 0;
            echo json_encode($output);
        }
    }

    function remove_favourite_product() {
        $user_id = $this->session->userdata('user_id');
        if ($user_id) {
            $output["status"] = 1;
            $product_id = $this->input->post('product_id');
            $this->Myfavourite_model->deletefavoriteproduct($user_id, $product_id);
            echo "Product Removed From My Favourite.";
        } else {
            redirect("signin", "refresh");
        }
    }

    function getCoupon() {
        
        if (!$this->session->userdata("user_logged_in")) {
            redirect("signin", "refresh");
        } else {
            $user_id = $this->session->userdata('user_id');
            if ($user_id) {          
                $coupon_moq = $this->input->post("coupon_moq");
                $coupon_value = $this->input->post("coupon_value");
                $coupon_id = $this->input->post("coupon_id");
                $current_total_qty = $this->input->post("current_total_qty");
               
                $isExists = $this->Coupon_model->isAlreadyExists($user_id, $coupon_id);
                if ($isExists){
                    
                            $data = array("status" => "ALREADY");
                            echo json_encode($data);
                    }else{
                        if($current_total_qty >= $coupon_moq)
                        {
                            $data = array(
                                        "user_id" => $user_id,
                                        "coupon_id" => $coupon_id,
                                        "status" => "GET"
                                        );
                            $this->Coupon_model->addUserCoupon($data);
                            echo json_encode($data); 
                        }
                        else{
                            
                           $data = array("status" =>0,"message"=>"Please Select Coupon Minimum Value For Coupon.");
                           echo json_encode($data); 
                        }
                    }
                }
             }
        }

    function addtocart() {
	$this->session->unset_userdata("start_order_page");
        $user_id = $this->session->userdata('user_id');
        
        if ($user_id) {
            
            $product_id =  (int)$this->input->post('product_id');
            //Get Product Name By Product id;
            $product=$this->Product_model->getProductNameByid($product_id);
            $pdetail  = $this->Product_model->getSellerIdByProductId($product_id);
            $pimage  = $this->Product_model->getproduct_image($product_id);
           
            $sdetail=$this->Product_model->getSellerInformationBySellerId($pdetail->seller);  
            
            //Create Specification Data
            $moq = $this->input->post('moq');
            $unit = $this->input->post('unit');
            $spec_id = $this->input->post('spec_id');
            $spec_value = $this->input->post('spec_value');
            $unit_price = $this->input->post('unit_price'); //Important check for Offer Price
            $offer_id =$this->input->post('offer_id');
            
            $spec_id = explode(',', $spec_id);
            $spec_value = explode(',', $spec_value);

            $this->db->select("name");
            $this->db->where_in("id", $spec_id);
            $query = $this->db->get("category_specific_specifications");
            $cat_spec_name = $query->result_array();            
            $total_quantity = $this->input->post('total_quantity');
            $total_price=$this->Product_model->getProductPriceByQuantity($product_id,$total_quantity);
  
            $total_price["final_price"]= $unit_price;
            
            $prod_total_price=$total_quantity * $total_price["final_price"];
            
            // Starting Modifying From Here More Than One Specification
            if(count($spec_id)>2){
               $other=array();
               $ispec=2;
                for($i=0;$i<=count($spec_id);$i++){ 
                    if($ispec<count($spec_id)){
                            $other[$i] = array(
                                        'spec_id' => $spec_id[$ispec],
                                        'specification_name' => $cat_spec_name[$ispec]['name'],
                                        'unit_price' => $total_price['final_price'],
                                        'quantity' => $total_quantity,
                                        'spec_value' => $spec_value[$ispec],
                                        'type' => 'dropdown'
                                        );
                                $ispec++;
                                };
                            };
                $spec_arr = array(
                    'primary' => array(
                        'spec_id' => $spec_id[0],
                        'specification_name' => $cat_spec_name[0]['name'],
                        'spec_value' => $spec_value[0]
                    ),
                    'secondary' => array(
                        0 => array(
                            'spec_id' => $spec_id[1],
                            'specification_name' => $cat_spec_name[1]['name'],
                            'unit_price' => $total_price['final_price'],
                            'quantity' => $total_quantity,
                            'spec_value' => $spec_value[1],
                            'type' => 'dropdown'
                        )
                    ),
                    'unit_price' => $total_price['final_price'],
                    'total_quantity' => $total_quantity,
                    'total_price' => $prod_total_price, //$tot_price,
                    'moq' => $moq,
                    'unit_name' => $unit,
                    'coupon_id'=>$coupon_id,
                    'other' => $other
                ); 
            };
            
            // count($spec_id);
            if (count($spec_id) == 2) {
               
                $spec_arr = array(
                    'primary' => array(
                        'spec_id' => $spec_id[0],
                        'specification_name' => $cat_spec_name[0]['name'],
                        'spec_value' => $spec_value[0]
                    ),
                    'secondary' => array(
                        0 => array(
                            'spec_id' => $spec_id[1],
                            'specification_name' => $cat_spec_name[1]['name'],
                            'unit_price' => $total_price['final_price'],
                            'quantity' => $total_quantity,
                            'spec_value' => $spec_value[1],
                            'type' => 'dropdown'
                        )
                    ),
                    'unit_price' => $total_price['final_price'],
                    'total_quantity' => $total_quantity,
                    'total_price' => $prod_total_price,
                    'moq' => $moq,
                    'unit_name' => $unit
                );
            } else if (count($spec_id) == 1) {
               
                $spec_id = implode($spec_id);
                $spec_value = implode($spec_value);

                $spec_arr = array(
                    'secondary' => array(
                        0 => array(
                            'spec_id' => $spec_id[0],
                            'specification_name' => $cat_spec_name[0]['name'],
                            'unit_price' => $total_price['final_price'],
                            'quantity' => $total_quantity,
                            'spec_value' => $spec_value,
                            'type' => 'dropdown'
                        )
                    ),
                    'unit_price' => $total_price['final_price'],
                    'total_quantity' => $total_quantity,
                    'total_price' => $prod_total_price,
                    'moq' => $moq,
                    'unit_name' => $unit
                );
            }

            //Making Array For Json Dyanamic
            $prod_spec = array(
                            0 => array(
                                'specifications' => $spec_arr,   
                                )
                            );
            
            //End Specification Data
            $arr['seller_id'] = $pdetail->seller;
            $arr['user_id'] = $user_id;
            $arr['product_id'] = $product_id;
            $arr['offer_id'] = $offer_id;
            $arr['product_total_quantity'] = $total_quantity; //adding Total Quantiy      
            $arr['product_name'] = $pdetail->name;
            $arr['product_image']= $pimage->url;
            $arr['supplierDetails']= $sdetail->first_name.' '.$sdetail->last_name.' '.$sdetail->company_name;
            $arr['specifications']= json_encode($prod_spec);
            
            $result = $this->Product_model->add_to_cart1($arr);
            
            if ($result=="Insert"){
                    $output["status"] = 1; 
                    $output["message"] = "<h4 class='text-success'>Product added successfully</h4>";
                    echo json_encode($output);
                    
                }else if($result=="Exists")
                {
                    $output["status"] = 2; 
                    $output["message"] = "<h4 class='text-success'>Product already added to cart</h4>";
                    echo json_encode($output);
                }
        }
        else {
               $output["status"] = 0;
               $output["message"] = "Please Login To ATZcart"; 
               echo json_encode($output);  
        }
    }
    
    public function removeCartProduct()
    {
         $user_id = $this->session->userdata('user_id');
         $cart_id=$this->input->post("cart_id");
         $resArr=array();
         $del=$this->Product_model->removeCart($user_id,$cart_id);
         if($del)
         {
             // return true;
             $resArr['flag']=1;
             $resArr['status']='success';
         }
         else
         {
             // return false;
             $resArr['flag']=0;
             $resArr['status']='failed';
         }
        echo json_encode($resArr);
    }
    
    //start Order Cart Product
    public function startOrderForCartProduct($seller_id)
    {
        if (!$this->session->userdata("user_logged_in")) {
            redirect("signin", "refresh");
        }else{ 

        $username = $this->session->userdata('user_name');
        $user_id = $this->session->userdata('user_id');
        
        if ($username) {
            $result = $this->Product_model->getCartProducts_Byid($seller_id,$user_id);
            
           // Amount Zero Then Check Product Model file add Column Product_total_quantity.
            $total_order_product_price=0;
            foreach ($result as $key => $row) {
                $result[$key]["specifications_decode"] = json_decode($row["specifications"]);
                unset($result[$key]["specifications"]);
            }

            foreach($result as $key => $value)
            {
                $product_id=$result[$key]['product_id'];
                $pro_tot_quantity=$result[$key]['product_total_quantity'];
                //$pro_tot_quantity=$result[$key]['specifications_decode'][0]->specifications->total_quantity;
                
                if(!empty($product_id) && !empty($pro_tot_quantity)){  
                    $total_price=$this->Product_model->getProductPriceByQuantity($product_id,$pro_tot_quantity);     
                }
                
                $total_price['final_price']=$result[$key]['specifications_decode'][0]->specifications->unit_price; 
                $total_product_price[]=$pro_tot_quantity * $total_price['final_price'];
                //printr($total_product_price);
                $total_order_product_price = array_sum($total_product_price);
            }
         
            $data['sellerinfos'] = $this->Product_model->getSellerInformation($result[0]['seller_id']);
            $data['cart_product'] = $result;          
            $data['user_address'] = $this->Users_model->getDefaultAddressBook($user_id);
            $data['tot_product_prices']=$total_product_price;
            $data['tot_order_product_prices']=$total_order_product_price;
            $this->session->set_userdata("start_order_page","startOrderForCartProduct/".$seller_id);
            
            $this->load->view('mobile/cart_product_view', $data);    
            } else {
                redirect("signin", "refresh");
          }
      }
    }
    /**
      Order Product While Click On Place order Button
     */
    public function place_order_product() {
        
        $user_id = $this->session->userdata('user_id');
        if (!$this->session->userdata("user_logged_in")) {
            redirect("signin", "refresh");
        } else {
            
            $shipp_addr = $this->input->post('shipp_addr');
            $user_ship_addr=$this->Users_model->getAddressBookById($shipp_addr);
            //get Shipping Method 
            $ship_method = $this->send_data->get_shipping_method();
            
            if(empty($user_ship_addr->postcode) || empty($user_ship_addr->street) || empty($user_ship_addr->city)){
                $address_error="Update Address Before Proceed Order";
                $this->session->set_flashdata('address_error',$address_error);
                $last_page=$this->session->userdata('start_order_page');
                redirect('product/'.$last_page);                
            }else{
            
            $seller_id = $this->input->post("seller_id");
            // Get Seller Info From Seller id
            $seller_info=$this->Users_model->getSellerInfo($seller_id);
            $product_id = $this->input->post('product_id');
            //Get Image Form Product Id
            $image_url=$this->Product_model->getproduct_image($product_id);
            $moq = $this->input->post('moq');
            $unit = $this->input->post('unit');
            $spec_id = $this->input->post('spec_id');
            $spec_value = $this->input->post('spec_value');
            
            $spec_id = explode(',', $spec_id);
            $spec_value = explode(',', $spec_value);
            
            $this->db->select("name");
            $this->db->where_in("id", $spec_id);
            $query = $this->db->get("category_specific_specifications");
            $cat_spec_name = $query->result_array();

            $product_name = $this->input->post('product_name');
            $unit_price = $this->input->post('unit_price'); // Use For Ship Rocket.
            $tot_price = $this->input->post('tot_price');
            $total_quantity = $this->input->post('total_quantity');
            $unit_price = $this->input->post('unit_price');
            $offer_id = $this->input->post('offer_id');
            $offer=$this->Offer_model->getOfferDetailsForOfferId($offer_id);
            //get unit Price according product quantity range.
            $price_range=$this->Product_model->getProductPriceByQuantity($product_id,$total_quantity);
            if(!empty($offer))
            { 
                $price_range['final_price']= $unit_price;
            }
            //User Detail
            $user = $this->Users_model->get_buyer_info($user_id);
            //user Shipping Address
            $user_addr = $this->Order_model->get_ship_address($shipp_addr);
            //Check Whether Coupon Applied or Not
            $coupon=$this->Coupon_model->getUserCoupons($user_id,1);
           
            $coupon_id=0;
            $total_price_after_dis=0;
            $total_discount=0;
            $discount_percent=0;
            
            if($coupon[0]->status=="GET")//GET
            {
                $coupon_id=$coupon[0]->coupon_uniqe_id;
                $totalAmount= $tot_price-($tot_price * ($coupon[0]->coupon_value /100));
            }else
            {
                $totalAmount = $tot_price;
            }
            // Starting Modifying From Here More Than One Specification
            if(count($spec_id)>2){
               $other=array();
               $ispec=2;
                for($i=0;$i<=count($spec_id);$i++){ 
                    if($ispec<count($spec_id)){
                            $other[$i] = array(
                                        'spec_id' => $spec_id[$ispec],
                                        'specification_name' => $cat_spec_name[$ispec]['name'],
                                        'unit_price' => $price_range['final_price'],
                                        'quantity' => $total_quantity,
                                        'spec_value' => $spec_value[$ispec],
                                        'type' => 'dropdown'
                                        );
                                $ispec++;
                                };
                            };
                $spec_arr = array(
                    'primary' => array(
                        'spec_id' => $spec_id[0],
                        'specification_name' => $cat_spec_name[0]['name'],
                        'spec_value' => $spec_value[0]
                    ),
                    'secondary' => array(
                        0 => array(
                            'spec_id' => $spec_id[1],
                            'specification_name' => $cat_spec_name[1]['name'],
                            'unit_price' => $price_range['final_price'],
                            'quantity' => $total_quantity,
                            'spec_value' => $spec_value[1],
                            'type' => 'dropdown'
                        )
                    ),
                    'unit_price' => $price_range['final_price'],
                    'total_quantity' => $total_quantity,
                    'total_price' => $totalAmount, //$tot_price,
                    'moq' => $moq,
                    'unit_name' => $unit,
                    'coupon_id'=>$coupon_id,
                    'other' => $other
                ); 
            };
            
            if (count($spec_id) == 2) {
                $spec_arr = array(
                    'primary' => array(
                        'spec_id' => $spec_id[0],
                        'specification_name' => $cat_spec_name[0]['name'],
                        'spec_value' => $spec_value[0]
                    ),
                    'secondary' => array(
                        0 => array(
                            'spec_id' => $spec_id[1],
                            'specification_name' => $cat_spec_name[1]['name'],
                            'unit_price' => $price_range['final_price'],
                            'quantity' => $total_quantity,
                            'spec_value' => $spec_value[1],
                            'type' => 'dropdown'
                        )
                    ),
                    'unit_price' => $price_range['final_price'],
                    'total_quantity' => $total_quantity,
                    'total_price' => $totalAmount,//$tot_price,
                    'moq' => $moq,
                    'unit_name' => $unit,
                    'coupon_id'=>$coupon_id
                );
            } else if (count($spec_id) == 1) {

                $spec_id = implode($spec_id);
                $spec_value = implode($spec_value);

                $spec_arr = array(
                    'secondary' => array(
                        0 => array(
                            'spec_id' => $spec_id[0],
                            'specification_name' => $cat_spec_name[0]['name'],
                            'unit_price' => $price_range['final_price'],
                            'quantity' => $total_quantity,
                            'spec_value' => $spec_value,
                            'type' => 'dropdown'
                        )
                    ),
                    'unit_price' => $price_range['final_price'],
                    'total_quantity' => $total_quantity,
                    'total_price' => $totalAmount,//$tot_price,
                    'moq' => $moq,
                    'unit_name' => $unit,
                    'coupon_id'=>$coupon_id
                );
            }
            
            //Making Array For Json Dyanamic
            $prod_spec = array(
                    "product_id"=>$product_id,
                    "product_name"=>$product_name,
                    "product_image"=> $image_url->url,
                    "supplierDetails"=>$seller_info['company_name'],
                    'specifications' => 
                array(
                    0 => array(
                        'specifications' => $spec_arr,   
                        )
                    )
                );
            
            $prod_spec_encode = json_encode((object)$prod_spec);
            //Calculate Shipping Cost 
            if(empty($seller_id)){
                //check for Seller Id Present or Not
                $this->session->set_flashdata("address_error","Sorry ! Please Fill Your Company Detail");
                redirect("product/start_order/".$product_id);  
            }
            $paddress = $this->Common_model->getAll('seller_pick_address', array(
                        'user_id' => $seller_id
                    ))->row_array();

            $prod_dat = $this->send_data->get_product_detail($product_id);
            $seller_pin = $paddress['pincode'];
            $buyer_pin = $user_addr["postcode"];
            
            if ($ship_method == 1) {
                //When Admin Select BlueDart
                $shipping_cost = $this->shipping->calculate_shipping_cost($product_id, $total_quantity, $buyer_pin, $seller_id);
                $shipping_rate = $shipping_cost['shipping_data']['shipping_rate'];
                $exp_shipping_date = $shipping_cost['shipping_data']['shipping_date_time'];
                $shipping_subtotal = $shipping_cost['shipping_data']['shipping_subtotal'];
                $shipping_gst = $shipping_cost['shipping_data']['shipping_gst'];

                $ship_status = $shipping_cost['status'];
                $courier_id = 0;
            }
            elseif($ship_method == 2){
                //When Admin Select ShipRocket
                $ship_rocket_cost = $this->shiprocket->serviceability($seller_pin, $buyer_pin, $prod_dat->weight, $prod_dat->length, $pro_dat->width, $prod_dat->height, $total_quantity);
                if ($ship_rocket_cost['status'] == 200) {
                    $courier_id = $ship_rocket_cost['courier_id'];
                    $shipping_rate = $ship_rocket_cost['rate'];
                    $shipping_subtotal = ($ship_rocket_cost['rate'] - ($ship_rocket_cost['rate'] * (18 / 100)));
                    $shipping_gst = ($ship_rocket_cost['rate'] * (18 / 100));
                    $exp_shipping_date = $ship_rocket_cost['est_date'];
                    $ship_status = 1;
                } else {
                    $this->session->set_flashdata("address_error","Pickup Not Available!");
                    redirect("product/start_order/".$product_id);                    
                }
            } else {
                $ship_status = 0;
                $this->session->set_flashdata("address_error","Sorry ! This Item is not Deliverable at this pincode.");
                redirect("product/start_order/".$product_id);
            }
            
            //Check 2 pay charge
            $area_code = $this->Shipping_model->get_seller_area($paddress['pick_id']);
            $areaCode = $area_code['area']; 
            
            if($ship_status == 1){
                //Insert Order///Insert in Order Table
               $insertOrder['user_id'] = $user_id;
               $insertOrder['order_from'] = 'Start_order';
               $insertOrder['seller_id'] = $seller_id;
               $insertOrder['user_name'] = $user_addr['contact_person'];
               $insertOrder['user_city'] = $user_addr['city'];
               $insertOrder['user_postcode'] = $user_addr['postcode'];
               $insertOrder['user_street_address'] = $user_addr['street'];
               $insertOrder['user_state'] = $user_addr['state'];
               $insertOrder['user_country'] = $user_addr['country'];
               $insertOrder['user_telephone'] = $user_addr['contact_number'];
               $insertOrder['user_email_address'] = $user['email'];
               $insertOrder['pick_name'] = $paddress['seller_name'];
               $insertOrder['pick_addr_type'] = $paddress['address_type'].','.$paddress['address'];
               $insertOrder['pick_address'] = $paddress['address2'].','.$paddress['address3'];
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
               $insertOrder['shipping_start_date'] = date("Y-m-d");
               $insertOrder['delivery_date'] = $exp_shipping_date;
               $insertOrder['shipping_expected_date'] = $exp_shipping_date;
               $insertOrder['shipping_cost'] = $shipping_rate;
               $insertOrder['shipping_subtotal'] = $shipping_subtotal;
               $insertOrder['shipping_gst'] = $shipping_gst;
               //Shipping Address Details
               $chech_shipp = $this->Common_model->getAll('shipping_vendor', array('id' => $ship_method))->row();
               //Check Shipping Status
            if ($chech_shipp->shipping_type == 'Free' && $tot_price >= $chech_shipp->free_amount) {
                $insertOrder['order_price'] = $tot_price;
                $insertOrder['shippment_type'] = 'Free';
            } else { 
                $insertOrder['order_price'] = $tot_price + $shipping_rate;
                $insertOrder['shippment_type'] = 'Paid';
            }
                //$insertOrder['order_price'] = $tot_price + $shipping_rate;
                $insertOrder['orders_status'] = 8;
                $insertOrder['shipping_method'] = "Land Transportation";
                $insertOrder['currency'] = 'INR';
                $insertOrder['date_purchased'] = date('Y-m-d H:i:s');
                $insertOrder['remark'] = $this->input->post('order_remark');   
                $insert_id = $this->Common_model->insert('orders', $insertOrder);
            if($insert_id) {
                
                if ($chech_shipp->shipping_type == 'Free' && $tot_price >= $chech_shipp->free_amount) {
                    $insertProPrice['shippment_type'] = 'Free';
                } else { 
                    $insertProPrice['shippment_type'] = 'Paid';
                }
                $insertProPrice['orders_id'] = $insert_id;
                $insertProPrice['products_id'] = $product_id;
                $insertProPrice['offer_id'] = $offer_id;
                $insertProPrice['products_name'] = $product_name;
                $insertProPrice['products_price'] = $price_range['final_price'];
                $insertProPrice['final_price'] = $tot_price;
                $insertProPrice['products_tax'] = 0;
                $insertProPrice['products_quantity'] = $total_quantity;
                $insertProPrice['product_specifications'] = $prod_spec_encode;
                $this->Common_model->insert('orders_products', $insertProPrice);
                
                /////Order Accepted Dimension
                $pro_detail = $this->Common_model->getAll('product_details')->row();
                $acceptData['orders_id'] = $insert_id;
                $acceptData['length'] = $pro_detail->length;
                $acceptData['width'] = $pro_detail->width;
                $acceptData['height'] = $pro_detail->height;
                $acceptData['weight_per_unit'] = $pro_detail->weight;
                $acceptData['pick_id'] = $paddress['pick_id'];
                $acceptData['pick_area_code'] = $areaCode;
                $this->Common_model->insert('order_accepted_dimention', $acceptData);
                 //Order Request
                $insertHistory['orders_id'] = $insert_id;
                $insertHistory['status'] = 8;
                $insertHistory['date_added'] = date('Y-m-d H:i:s');
                $insertHistory['comment'] = 'Order Requested';
                $insertHistory['customer_notified'] = 1;
                $order_history = $this->Common_model->insert('orders_history', $insertHistory);
                
                //Insert into Shipping Order to test
                if ($chech_shipp->shipping_type == 'Free' && $tot_price >= $chech_shipp->free_amount) {
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
                    }else{
                        $this->Common_model->delete('orders', array('orders_id' => $insert_id));
                        $this->Common_model->delete('orders_products', array('orders_id' => $insert_id));
                        $this->Common_model->delete('order_shipping', array('orders_id' => $insert_id));
                        $this->Common_model->delete('orders_history', array('orders_id' => $insert_id));
//                      $output = ['status' => 0];
//                      echo json_encode($output);
                    }
                }
                $this->session->unset_userdata("start_order_page");
                $this->session->unset_userdata("prev_page");
                redirect('product/ship_order/' . $insert_id); 
            }else{
                $this->session->set_flashdata('address_error', $shipping_cost['message']);
                redirect("product/start_order/".$product_id);
            }
          }// Checking PostCode Added or Not
        }
    }
    
    public function place_order_cart_product() {
        
        $user_id = $this->session->userdata('user_id');
        if (!$this->session->userdata("user_logged_in")) {
            redirect("signin", "refresh");
        } else 
        {  
            $shipp_addr = $this->input->post('hide_ship_addr_id');
            $user_ship_addr=$this->Users_model->getAddressBookById($shipp_addr);
            // Checking For Which Shipping Method Used.
            $ship_method = $this->send_data->get_shipping_method();
           
            if(empty($user_ship_addr)||empty($user_ship_addr->postcode) || empty($user_ship_addr->street) || empty($user_ship_addr->city)){
                $address_error="Update Address Before Proceed Order";
                $this->session->set_flashdata('address_error',$address_error);
                $last_page=$this->session->userdata('start_order_page');
                redirect('product/'.$last_page);                
            }
            $cart_id_arr = $_POST["cart_id"];
            $order_remark= $_POST["order_remark"];
            $user_address = $this->Users_model->getDefaultAddressBook($user_id);
            $getCartProduct=$this->Product_model->getCartProductByCartId($cart_id_arr);
            $sellerinfos=$this->Product_model->getSellerInformation($getCartProduct[0]['seller_id']);
            $paddress = $this->Common_model->getAll('seller_pick_address', array('user_id' => $getCartProduct[0]['seller_id']))->row_array();
            
            $i=0;
            $tot_price=0;
            foreach($getCartProduct as $getProduct)
            {   
                $getCartProduct[$i]["spec_decode"]=json_decode($getProduct['specifications']);
                $i++;  
            }
            //printr($getCartProduct); 
            for($i=0;$i<count($getCartProduct);$i++)
            {
                // $tot_price += $getCartProduct[$i]['spec_decode'][0]->specifications->total_price; // This is Comment To Sync With Web 
                $tot_price += ($getCartProduct[$i]['spec_decode'][0]->specifications->total_quantity)*($getCartProduct[$i]['spec_decode'][0]->specifications->unit_price);
            }
                
                $prod_dat = $this->send_data->get_product_detail($getProduct["product_id"]);
                $buyer_pin = $user_address->postcode;
                $seller_id= $paddress['user_id'];
                $seller_pin = $paddress['pincode'];
                $shipping_expected_date = date('Y-m-d');
                $finalShipping_date = date('Y-m-d', strtotime($shipping_expected_date . ' +2 day'));
               
                $shipping_price = 0;

                
                $max_length = 0.5;
                $max_height = 0.5;
                $max_width = 0.5;
                $tot_weight = 0;

                foreach($getCartProduct as $getProduct)
                {
                    if($ship_method == 1){
                            //When Admin Select BlueDart
                            $total_quantity= $getProduct["spec_decode"][0]->specifications->total_quantity;
                            $result= $this->calculate_shipping_cost($getProduct["product_id"],$total_quantity,$buyer_pin, $getProduct["seller_id"]);
                            $shipping_price += $result['shipping_data']['shipping_rate'];
                            if ($finalShipping_date > $result['shipping_data']['shipping_date_time']) {
                                $finalShipping_date = $result['shipping_data']['shipping_date_time'];
                            }
                            $shipping_subtotal = $shipping_price;
                            $shipping_gst = $shipping_subtotal * (18 / 100); // gst on order
                            $shipping_cost = $shipping_subtotal + $shipping_gst;
                            $ship_status = $result['status'];
                            $courier_id = 0;
                            
                        }elseif($ship_method == 2){
                            //When Admin Select ShipRocket
                            if ($prod_dat->length > $max_length) {
                                    $max_length = $prod_dat->length;
                                }

                                if ($prod_dat->width > $max_width) {
                                    $max_width = $prod_dat->width;
                                }

                                if ($prod_dat->height > $max_height) {
                                    $max_height = $prod_dat->height;
                                }
                                
                            $total_quantity= $getProduct['spec_decode'][0]->specifications->total_quantity;
                            $wt = $prod_dat->weight * $total_quantity;
                            $tot_weight = $tot_weight + $wt;
                               
                            $prod_dat = $this->send_data->get_product_detail($getProduct['product_id']);
                            $ship_rocket_cost = $this->shiprocket->serviceability_for_multiple($seller_pin, $buyer_pin, $max_length, $max_width, $max_height, $tot_weight);
                            
                            if ($ship_rocket_cost['status'] == 200) {
                                $courier_id = $ship_rocket_cost['courier_id'];
                                $shipping_price = $ship_rocket_cost['rate'];
                                $shipping_subtotal = round($shipping_price-($shipping_price * (18 / 100)),2);
                                $shipping_gst = ($shipping_subtotal * (18 / 100));
                                $exp_shipping_date = $ship_rocket_cost['est_date'];
                                $finalShipping_date = $exp_shipping_date;
                                $shipping_cost = $shipping_price;
                                $ship_status = 1;
                            } else {
                                $this->session->set_flashdata("address_error","Pickup Not Available!");
                                redirect("product/startOrderForCartProduct/".$seller_id);                    
                            }
                        }else{
                                $ship_status = 0;
                                $this->session->set_flashdata("address_error","Sorry ! This Item is not Deliverable at this pincode.");
                                redirect("product/startOrderForCartProduct/".$seller_id);
                        }
                    }
                
                $user_email=$this->Users_model->getEmailsById($user_id);
                ///Insert in Order Table
                $insertOrder['user_id'] = $user_id;
                $insertOrder['order_from'] = 'Cart';
                $insertOrder['user_name'] = $user_address->contact_person;
                $insertOrder['user_city'] = $user_address->city;
                $insertOrder['user_postcode'] = $user_address->postcode;
                $insertOrder['user_street_address'] = $user_address->street;
                $insertOrder['user_state'] = $user_address->state;
                $insertOrder['user_country'] = $user_address->country;
                $insertOrder['user_telephone'] = $user_address->contact_number;
                $insertOrder['user_email_address'] = $user_email['email'];
                $insertOrder['pick_name'] = $paddress['seller_name'];
                $insertOrder['pick_addr_type'] = $paddress['address_type'].','.$paddress['address'];
                $insertOrder['pick_address'] = $paddress['address2'].','.$paddress['address3'];
                $insertOrder['pick_country'] = $paddress['country'];
                $insertOrder['pick_state'] = $paddress['state'];
                $insertOrder['pick_mobile'] = $paddress['seller_mobile'];
                $insertOrder['pick_email'] = $paddress['seller_email'];
                $insertOrder['pick_pincode'] = $paddress['pincode'];
                $insertOrder['pick_days'] = 2; // Pick Up days

                $insertOrder['delivery_name'] = $user_address->contact_person;
                $insertOrder['delivery_street_address'] = $user_address->street;
                $insertOrder['delivery_city'] = $user_address->city;
                $insertOrder['delivery_postcode'] = $user_address->postcode;
                $insertOrder['delivery_state'] = $user_address->state;
                $insertOrder['delivery_country'] = $user_address->country;
                $insertOrder['delivery_date'] = $finalShipping_date;
                $insertOrder['shipping_start_date'] = date("Y-m-d");
                $insertOrder['payment_method'] = 'razorpay';
                $insertOrder['shipping_expected_date'] = $finalShipping_date;
                $insertOrder['shipping_subtotal'] = $shipping_subtotal;
                $insertOrder['shipping_gst'] = $shipping_gst;
                $insertOrder['shipping_cost'] = round($shipping_cost, 2);
                //Shipping Address Details
                $chech_shipp = $this->Common_model->getAll('shipping_vendor', array('id' => $ship_method))->row();
                //Check Shipping Status
                if ($chech_shipp->shipping_type == 'Free' && $tot_price >=$chech_shipp->free_amount) {
                    $insertOrder['order_price'] = $tot_price;
                    $insertOrder['shippment_type'] = 'Free';
                } else {
                    $insertOrder['order_price'] = round($tot_price+ $shipping_cost,2);
                    $insertOrder['shippment_type'] = 'Paid';
                }
                //$insertOrder['order_price'] = round($tot_price + $shipping_cost, 2);
                $insertOrder['orders_status'] = 8;
                $insertOrder['shipping_method'] = "Land Transportation";
                $insertOrder['seller_id'] = $getCartProduct[0]['seller_id'];
                $insertOrder['currency'] = 'INR';
                $insertOrder['date_purchased'] = date('Y-m-d H:i:s');
                $insertOrder['remark'] = $order_remark;
                
                $insert_id = $this->Common_model->insert('orders', $insertOrder);
                if ($insert_id) {
                $tot_weight = 0;
                $prod = '';
                
                foreach ($getCartProduct as $getProduct) {
                    
                    if ($chech_shipp->shipping_type == 'Free' && $tot_price >= $chech_shipp->free_amount) {
                        $insertProPrice['shippment_type'] = 'Free';
                    } else {
                        $insertProPrice['shippment_type'] = 'Paid';
                    }
                    
                    $pimage  = $this->Product_model->getproduct_image($getProduct['product_id']);
                    $insertProPrice['orders_id'] = $insert_id;
                    $insertProPrice['products_id'] = $getProduct['product_id'];
                    $insertProPrice['offer_id'] = $getProduct['offer_id'];
                    $insertProPrice['products_name'] = $getProduct['product_name'];
                    $insertProPrice['products_price'] = $getProduct['spec_decode'][0]->specifications->unit_price;
                    //$insertProPrice['final_price'] = $getProduct['spec_decode'][0]->specifications->total_price; //Comment Because it not sync with web try to sync
                    $insertProPrice['final_price'] = ($getProduct['spec_decode'][0]->specifications->total_quantity)*($getProduct['spec_decode'][0]->specifications->unit_price);
                    $insertProPrice['products_tax'] = 0;
                    $insertProPrice['products_quantity'] = $getProduct['spec_decode'][0]->specifications->total_quantity;//$getProduct['spec_decode']->specifications[0]->specifications->total_quantity;
                    
                    if ($chech_shipp->shipping_type == 'Free' && $tot_price >= 500) {
                        $insertProPrice['shippment_type'] = 'Free';
                    } else { 
                        $insertProPrice['shippment_type'] = 'Paid';
                    }
                    
                    $prod_spec = array(
                                        "product_id"=>$getProduct['product_id'],
                                        "product_name"=>$getProduct['product_name'],
                                        "product_image"=> $pimage->url,
                                        "supplierDetails"=>$sellerinfos['company_name'],
                                        "specifications"=>$getProduct['spec_decode']
                                       );
                    //$insertProPrice['product_specifications'] = $getProduct['specifications'];
                    $insertProPrice['product_specifications'] = json_encode($prod_spec);
                   
                    $this->Common_model->insert('orders_products', $insertProPrice); 
                    
                    $prod = $prod . ' ,' . $getProduct['product_name'];
                    //get weight
                    $pro_detail = $this->Common_model->getAll('product_details', array('id' => $getProduct['product_id']))->row();
                    $total_quantity= $getProduct['spec_decode'][0]->specifications->total_quantity;
                    $tot_weight = $tot_weight + ($pro_detail->weight * $total_quantity);
                }
                
                    //Insert into Shipping Order
                    if ($chech_shipp->shipping_type == 'Free' && $tot_price >=$chech_shipp->free_amount) {
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
                    $ship_dat['breadth']= $max_width;
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
//                            $output = ['status' => 0];
//                            echo json_encode($output);
                            redirect("product/ship_cart_product/". $insert_id);
                        }
                    }   
                    
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
                    $insertHistory['status'] = 8;
                    $insertHistory['date_added'] = date('Y-m-d H:i:s');
                    $insertHistory['comment'] = 'Order Requested';
                    $insertHistory['customer_notified'] = 1;
                    
                    $this->Common_model->insert('orders_history', $insertHistory);
                }
                redirect("product/ship_cart_product/". $insert_id);
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


                            $size = (($product_height * $product_lenght * $product_width )) / 3600;
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
                        $output["message"] = "Not Deliverable Pincode !";
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
         /**
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
        
        private function check_duplicate_notify_buyer($product_id)
        {
            if ($this->session->has_userdata('user_id')) {
                $buyer_id = $this->session->user_id;
                $duplicate_user = $this->db->select('count(id) as duplicate')
                    ->from('product_notify_list')
                    ->where(array('product_id' => $product_id, 'user_id' => $buyer_id))
                    ->where('date_user_notified IS NULL')
                    ->get()->result_array()[0]['duplicate'];
                if ($duplicate_user == 1) {
                    return 1;
                } else {
                    return 0;
                }
            } else {
                return 'Invalid Access!';
            }
        }
    }
