<?php

defined('BASEPATH') OR exit('No direct script access allowed');

//require('MySoapClient.php');
use Firebase\JWT\JWT;

class Orders extends REST_Controller {

    private $_payload;

    public function __construct($config = 'rest') {
        parent::__construct($config);
        $token = $this->input->get_request_header('Token');
        try {
            $this->_payload = JWT::decode($token, $this->config->item('jwt_secret_key'), array('HS256'));
        } catch (Exception $ex) {
            $output = array("status" => 0, "message" => $ex->getMessage());
            $this->response($output, REST_Controller::HTTP_UNAUTHORIZED);
        }
        $this->load->library('form_validation');
        $this->load->model('Order_model');
        $this->load->model('Product_model');
        $this->load->model('Users_model');
        $this->load->model('Common_model');
        $this->load->model('Categories_model');
        $this->load->library('Browser_notification');
        $this->load->library('Shipping');
        $this->load->library('Send_data');
        $this->load->library('Shiprocket');
        $this->load->model('Coupon_model');
        $this->load->model('Shipping_model');
        $this->load->model('Profile_model');
        $this->load->model('Myorders_model');
        $this->load->model('Offer_model');
    }

    public function start_post() {

        $ws = $this->post('ws');

        if (empty($ws)) {
            $ws = "start";
        }

        $output = [
            "ws" => $ws,
            "status" => 0,
            "message" => ""
        ];
        $this->form_validation->set_error_delimiters('', '');
        $this->form_validation->set_rules("product", "Product", "required", array(
            "required" => "invalid inputs"
        ));
        $this->form_validation->set_rules("address", "Address", "required|callback_validAddress", array(
            "required" => "invalid inputs"
        ));
        $this->form_validation->set_rules("quantity", "Quantity", "required", array(
            "required" => "invalid inputs"
        ));
        $this->form_validation->set_rules("unit_price", "Price", "required", array(
            "required" => "invalid inputs"
        ));
        $this->form_validation->set_rules("total_price", "Price", "required", array(
            "required" => "invalid inputs"
        ));
        /* $this->form_validation->set_rules("shipping_method","Shipping Method","required",array(
          "required" => "invalid inputs"
          )); */

        if ($this->form_validation->run() === false) {
            $errors = $this->form_validation->error_array();
            foreach ($errors as $key => $err):
                if ($err == "invalid inputs") {
                    $output["message"] = "Invalid inputs";
                } else {
                    $output["message"] = $err;
                }
            endforeach;
        } else {
            $user_id = $this->_payload->userid;
            $user_email = $this->_payload->email;
            $product = $this->post("product");
            $order_from = $this->post("order_from");
            $address = $this->post("address");
            $quantity = $this->post("quantity");
            $unit_price = $this->post("unit_price");
            $seller_id = $this->post("seller_id");
//echo $unit_price;
            $total_price = $this->post("total_price");
            $coupon_id = $this->post("coupon_id");
            $offer_id = $this->post("offer_id");
            $shipping_cost = $this->post("shipping_cost");

            //get Shipping Method
            $ship_method = $this->send_data->get_shipping_method();

            // Check if offer has expired iff yes then send with expiration message
            $offerExpire = $this->Offer_model->checkOfferExpiryForCartProducts($offer_id);
            if ($offerExpire != NULL) {
                $output = ["ws" => $ws, "status" => 0, "message" => "Product Offer Has Expired"];
                $this->response($output, REST_Controller::HTTP_OK);
            }

//var_dump($coupon_id);
            $product_specifications = $this->post("product_specifications");
            $user = $this->Users_model->getUserById($user_id);
            $address = $this->Users_model->getAddressBookById($address);
            if ($coupon_id) {
                $isvalidcoupen = $this->Coupon_model->isCouponAvailableForUser($coupon_id, $product, $user_id);
                if ($isvalidcoupen) {
                    $coupon = $this->Coupon_model->getCoupenById($coupon_id);
                    $temp_total = $quantity * $unit_price;
                    if ($coupon->discount_type == "flat") {
                        $temp_total_after_coupon = $temp_total - $coupon->coupon_value;
                    } else {
                        $percentage = ($temp_total * $coupon->coupon_value) / 100;
                        $temp_total_after_coupon = $temp_total - $percentage;
                    }
//$output["mobile_price"] = $total_price;
//$output["api_price"] = $temp_total_after_coupon." ".$temp_total;


                    if ($quantity >= $coupon->moq && $temp_total_after_coupon == ($total_price - $shipping_cost)) {

                        $buyer_pin = $address->postcode;
                        $product_id = $this->post("product");


                        ////////////////////
                        $paddress = $this->Common_model->getAll('seller_pick_address', array('user_id' => $seller_id))->row_array();
                        $buyer_pin = $address->postcode;
                        $seller_pin = $paddress['pincode'];
                        $product_id = $this->post("product");
                        $prod_dat = $this->send_data->get_product_detail($product_id);

                        $area_code = $this->Shipping_model->get_seller_area($paddress['pick_id']);
                        $areaCode = $area_code['area'];

                        //Calculate Shipping Cost ( Library )
                        if ($ship_method == 1) {
                            //calculating shipping Rate
                            $shipping_cost = $this->shipping->calculate_shipping_cost($product_id, $quantity, $buyer_pin, $seller_id);
                            //Check 2 pay charge
                            $ship_status = $shipping_cost['status'];
                            $shipping_rate = $shipping_cost['shipping_data']['shipping_rate'];
                            $exp_shipping_date = $shipping_cost['shipping_data']['shipping_date_time'];

                            $shipping_subtotal = $shipping_cost['shipping_data']['shipping_subtotal'];

                            $shipping_gst = $shipping_cost['shipping_data']['shipping_gst'];
                            $courier_id = 0;
                            $ship_status = 1;
                        } elseif ($ship_method == 2) {
                            $ship_rocket_cost = $this->shiprocket->serviceability($seller_pin, $buyer_pin, $prod_dat->weight, $prod_dat->length, $pro_dat->width, $prod_dat->height, $quantity);

                            if ($ship_rocket_cost['status'] == 200) {

                                $courier_id = $ship_rocket_cost['courier_id'];
                                $shipping_rate = $ship_rocket_cost['rate'];
                                $shipping_subtotal = round(($ship_rocket_cost['rate'] - ($ship_rocket_cost['rate'] * (18 / 100))), 2);
                                $shipping_gst = round(($ship_rocket_cost['rate'] * (18 / 100)), 2);
                                $exp_shipping_date = $ship_rocket_cost['est_date'];
                                $ship_status = 1;
                            } else {
                                $output["status"] = 0;
                                $output["message"] = 'Pickup Not Allowed';
                            }
                        } else {
                            $output["status"] = 0;
                            $output["message"] = 'Pickup Not Allowed';
                        }
                        //////////////////


                        if ($ship_status == 1) {
                            $shipping_rate = $shipping_cost['shipping_data']['shipping_rate'];


                            $exp_shipping_date = $shipping_cost['shipping_data']['shipping_date_time'];
                            $shipping_subtotal = $shipping_cost['shipping_data']['shipping_subtotal'];

                            $shipping_gst = $shipping_cost['shipping_data']['shipping_gst'];

//seller pick address
                            $paddress = $this->Common_model->getAll('seller_pick_address', array('user_id' => $seller_id))->row_array();

                            //Shipping Address Details
                            $chech_shipp = $this->Common_model->getAll('shipping_vendor', array('id' => $ship_method))->row();
                            //Check Shipping Status
                            if ($chech_shipp->shipping_type == 'Free' && ($total_price - $shipping_rate) >= $chech_shipp->free_amount) {
                                $total_price_new = round($total_price - $shipping_rate, 2);
                                $ship_type = 'Free';
                            } else {
                                $total_price_new = round($total_price, 2);
                                $ship_type = 'Paid';
                            }



                            $insertData = [
                                "user_id" => $user_id,
                                "seller_id" => $seller_id,
                                "order_from" => $order_from,
                                "user_name" => $user->first_name . " " . $user->last_name,
                                "user_street_address" => $address->street,
                                "user_suburb" => $address->suburb,
                                "user_city" => $address->city,
                                "user_postcode" => $address->postcode,
                                "user_state" => $address->state,
                                "user_country" => $address->country,
                                "user_telephone" => $address->contact_number,
                                "user_email_address" => $user_email,
                                "delivery_name" => $address->contact_person,
                                "delivery_name" => $user->first_name . " " . $user->last_name,
                                "delivery_street_address" => $address->street,
                                "delivery_suburb" => $address->suburb,
                                "delivery_city" => $address->city,
                                "delivery_postcode" => $address->postcode,
                                "delivery_state" => $address->state,
                                "delivery_country" => $address->country,
                                "pick_name" => $paddress['seller_name'],
                                "pick_addr_type" => $paddress['address'] . ',' . $paddress['address_type'],
                                "pick_address" => $paddress['address2'] . ',' . $paddress['address3'],
                                "pick_country" => $paddress['country'],
                                "pick_state" => $paddress['state'],
                                "pick_mobile" => $paddress['seller_mobile'],
                                "pick_email" => $paddress['seller_email'],
                                "pick_pincode" => $paddress['pincode'],
                                "pick_days" => 0,
                                "ex_shipping_days" => $this->post("shipping_days"),
                                "shipping_method" => $this->post("shipping_method"),
                                "remark" => $this->post("remark"),
                                "orders_status" => 8,
                                "order_price" => $total_price_new,
                                "shipping_subtotal" => $shipping_subtotal,
                                "shipping_gst" => $shipping_gst,
                                "shipping_cost" => $shipping_rate,
                                "shippment_type" => $ship_type,
                                "orders_date_finished" => date('Y-m-d H:i:s')
                            ];
                            $order_id = $this->Order_model->addOrder($insertData);
                            $product_id = $this->input->post('product');

                            if (empty($this->post("coupon_id"))) {
                                $coupon_id = $this->post("coupon_id");
                            }

                            $product_data = [
                                "orders_id" => $order_id,
                                "products_id" => $this->post("product"),
                                "coupon_id" => $coupon_id,
                                "offer_id" => $offer_id,
                                "products_name" => $this->post("product_name"),
                                "products_price" => $unit_price,
                                "products_quantity" => $quantity,
                                "shippment_type" => $ship_type,
                                "final_price" => ($unit_price * $quantity),
                                "product_specifications" => $product_specifications,
                            ];
                            $this->Order_model->addOrderProduct($product_data);

                            //Insert into History
                            $orderHistory['orders_id'] = $order_id;
                            $orderHistory['status'] = 8;
                            $orderHistory['date_added'] = date('Y-m-d H:i:s');
                            $orderHistory['comment'] = 'Order Requested !';

                            $this->Common_model->insert('orders_history', $orderHistory);

                            //Insert into Shipping Order
                            if ($chech_shipp->shipping_type == 'Free' && ($total_price - $shipping_rate) >= $chech_shipp->free_amount) {
                                $ship_dat['shippment_type'] = 'Free';
                            } else {
                                $ship_dat['shippment_type'] = 'Paid';
                            }
                            $ship_dat['ship_vendor_id'] = $ship_method;
                            $ship_dat['orders_id'] = $order_id;
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
                            $ship_dat['weight'] = ($prod_dat->weight * $quantity);
                            $insert_ship_id = $this->Common_model->insert('order_shipping', $ship_dat);

                            // $this->Coupon_model->updateCouponRedeemStatus($user_id, $coupon_id);
                            if ($ship_method == 2) {
                                $resp = $this->shiprocket->create_order($order_id);

                                if (!empty($resp['order_id'])) {
                                    $up_ord['ship_order_id'] = $resp['order_id'];
                                    $up_ord['shipment_id'] = $resp['shipment_id'];
                                    $this->Common_model->update('order_shipping', $up_ord, array('ship_id' => $insert_ship_id));
                                    $output["status"] = 1;
                                    $output["order_id"] = $order_id;
                                    $output["message"] = "Order Requested.";
                                } else {
                                    $this->Common_model->delete('orders', array('orders_id' => $order_id));
                                    $this->Common_model->delete('orders_products', array('orders_id' => $order_id));
                                    $this->Common_model->delete('order_shipping', array('orders_id' => $order_id));
                                    $this->Common_model->delete('orders_history', array('orders_id' => $order_id));

                                    $output["status"] = 0;
                                    $output["message"] = 'Not Pickable ! Please Retry ';
                                }
                            } else {
                                $output["status"] = 1;
                                $output["order_id"] = $order_id;
                                $output["message"] = "Order Requested.";
                            }
                        } else {
                            $output["status"] = 0;
                            $output["message"] = $shipping_cost['message'];
                        }
                        $notification_title = 'New Order';
                        $notification_msg = 'New order placed! Login to your panel to further processing.';
                        $notification_type = 'Order';
                        $reference_id = $order_id;
                        $firebase_id = get_user_firebase_id($seller_id->seller);
                    } else {
                        $output["status"] = 0;
                        $output["message"] = "Invalid price / quantity";
                    }
                } else {
                    $output["status"] = 0;
                    $output["message"] = "Invalid Coupon";
                }
            } else {

                $paddress = $this->Common_model->getAll('seller_pick_address', array('user_id' => $seller_id))->row_array();
                $buyer_pin = $address->postcode;
                $seller_pin = $paddress['pincode'];
                $product_id = $this->post("product");
                $prod_dat = $this->send_data->get_product_detail($product_id);

                $area_code = $this->Shipping_model->get_seller_area($paddress['pick_id']);
                $areaCode = $area_code['area'];

                //Calculate Shipping Cost ( Library )
                if ($ship_method == 1) {
                    //calculating shipping Rate
                    $shipping_cost = $this->shipping->calculate_shipping_cost($product_id, $quantity, $buyer_pin, $seller_id);
                    //Check 2 pay charge
                    $ship_status = $shipping_cost['status'];
                    $shipping_rate = $shipping_cost['shipping_data']['shipping_rate'];
                    $exp_shipping_date = $shipping_cost['shipping_data']['shipping_date_time'];

                    $shipping_subtotal = $shipping_cost['shipping_data']['shipping_subtotal'];

                    $shipping_gst = $shipping_cost['shipping_data']['shipping_gst'];
                    $courier_id = 0;
                    $ship_status = 1;
                } elseif ($ship_method == 2) {
                    $ship_rocket_cost = $this->shiprocket->serviceability($seller_pin, $buyer_pin, $prod_dat->weight, $prod_dat->length, $pro_dat->width, $prod_dat->height, $quantity);

                    if ($ship_rocket_cost['status'] == 200) {

                        $courier_id = $ship_rocket_cost['courier_id'];
                        $shipping_rate = $ship_rocket_cost['rate'];
                        $shipping_subtotal = round(($ship_rocket_cost['rate'] - ($ship_rocket_cost['rate'] * (18 / 100))), 2);
                        $shipping_gst = round(($ship_rocket_cost['rate'] * (18 / 100)), 2);
                        $exp_shipping_date = $ship_rocket_cost['est_date'];
                        $ship_status = 1;
                    } else {
                        $output["status"] = 0;
                        $output["message"] = 'Pickup Not Allowed';
                    }
                } else {
                    $output["status"] = 0;
                    $output["message"] = 'Pickup Not Allowed';
                }

                if ($ship_status == 1) {

                    //seller pick address
                    $paddress = $this->Common_model->getAll('seller_pick_address', array('user_id' => $seller_id))->row_array();

                    //Shipping Address Details
                    $chech_shipp = $this->Common_model->getAll('shipping_vendor', array('id' => $ship_method))->row();
                    //Check Shipping Status
                    if ($chech_shipp->shipping_type == 'Free' && ($total_price - $shipping_rate) >= $chech_shipp->free_amount) {
                        $total_price_new = round($total_price - $shipping_rate, 2);
                        $ship_type = 'Free';
                    } else {
                        $total_price_new = round($total_price, 2);
                        $ship_type = 'Paid';
                    }


                    $insertData = [
                        "user_id" => $user_id,
                        "seller_id" => $seller_id,
                        "user_name" => $user->first_name . " " . $user->last_name,
                        "user_street_address" => $address->street,
                        "user_suburb" => $address->suburb,
                        "user_city" => $address->city,
                        "user_postcode" => $address->postcode,
                        "user_state" => $address->state,
                        "user_country" => $address->country,
                        "user_telephone" => $address->contact_number,
                        "user_email_address" => $user_email,
                        "delivery_name" => $address->contact_person,
                        "delivery_name" => $user->first_name . " " . $user->last_name,
                        "delivery_street_address" => $address->street,
                        "delivery_suburb" => $address->suburb,
                        "pick_name" => $paddress['seller_name'],
                        "pick_addr_type" => $paddress['address_type'],
                        "pick_country" => $paddress['country'],
                        "pick_state" => $paddress['state'],
                        "pick_mobile" => $paddress['seller_mobile'],
                        "pick_email" => $paddress['seller_email'],
                        "pick_pincode" => $paddress['pincode'],
                        "pick_days" => 0,
                        "shipping_subtotal" => $shipping_subtotal,
                        "shipping_gst" => $shipping_gst,
                        "shipping_cost" => $shipping_rate,
                        "order_price" => $total_price_new,
                        "delivery_city" => $address->city,
                        "delivery_postcode" => $address->postcode,
                        "delivery_state" => $address->state,
                        "delivery_country" => $address->country,
                        "ex_shipping_days" => $this->post("shipping_days"),
                        "shipping_method" => $this->post("shipping_method"),
                        "shippment_type" => $ship_type,
                        "remark" => $this->post("remark"),
                        "orders_status" => 8,
                        "orders_date_finished" => date('Y-m-d H:i:s')
                    ];
                    $order_id = $this->Order_model->addOrder($insertData);
                    $product_id = $this->input->post('product');


                    $product_data = [
                        "orders_id" => $order_id,
                        "offer_id" => $offer_id,
                        "products_id" => $this->post("product"),
                        "products_name" => $this->post("product_name"),
                        "products_price" => $unit_price,
                        "products_quantity" => $quantity,
                        "shippment_type" => $ship_type,
                        "final_price" => ($unit_price * $quantity),
                        "product_specifications" => $product_specifications
                    ];
                    $this->Order_model->addOrderProduct($product_data);

                    //Insert into Shipping Order
                    if ($chech_shipp->shipping_type == 'Free' && ($total_price - $shipping_rate) >= $chech_shipp->free_amount) {
                        $ship_dat['shippment_type'] = 'Free';
                    } else {
                        $ship_dat['shippment_type'] = 'Paid';
                    }
                    $ship_dat['ship_vendor_id'] = $ship_method;
                    $ship_dat['orders_id'] = $order_id;
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
                    $ship_dat['weight'] = ($prod_dat->weight * $quantity);
                    $insert_ship_id = $this->Common_model->insert('order_shipping', $ship_dat);

                    //Insert History
                    $orderHistory['orders_id'] = $order_id;
                    $orderHistory['status'] = 8;
                    $orderHistory['date_added'] = date('Y-m-d H:i:s');
                    $orderHistory['comment'] = 'Order Requested !';
                    $this->Common_model->insert('orders_history', $orderHistory);
                    //Generate Order if Use Ship Rocket
                    if ($ship_method == 2) {
                        $resp = $this->shiprocket->create_order($order_id);
                        if (!empty($resp['order_id'])) {
                            $up_ord['ship_order_id'] = $resp['order_id'];
                            $up_ord['shipment_id'] = $resp['shipment_id'];
                            $this->Common_model->update('order_shipping', $up_ord, array('ship_id' => $insert_ship_id));
                            $output["status"] = 1;
                            $output["order_id"] = $order_id;
                            $output["message"] = "Order Requested.";
                        } else {
                            $this->Common_model->delete('orders', array('orders_id' => $order_id));
                            $this->Common_model->delete('orders_products', array('orders_id' => $order_id));
                            $this->Common_model->delete('order_shipping', array('orders_id' => $order_id));
                            $this->Common_model->delete('orders_history', array('orders_id' => $order_id));

                            $output["status"] = 0;
                            $output["message"] = 'Not Pickable ! Please Retry ';
                        }
                    } else {
                        $output["status"] = 1;
                        $output["order_id"] = $order_id;
                        $output["message"] = "Order Requested.";
                    }
                } else {
                    $output["status"] = 0;
                    $output["message"] = $shipping_cost['message'];
                }
                /* $notification_title = 'New Order';
                  $notification_msg = 'New order placed! Login to your panel to further processing.';
                  $notification_type = 'Order';
                  $reference_id = $order_id;
                  $firebase_id = get_user_firebase_id($seller_id->seller);
                  send_android($notification_title,$notification_msg,$firebase_id,$notification_type);
                  add_user_notification($seller_id,$notification_title,$notification_msg,$notification_type,$reference_id);
                  add_admin_notification($notification_title,$notification_msg,$notification_type,$reference_id); */
            }
        }
        $this->response($output, REST_Controller::HTTP_OK);
    }

    public function validAddress($id) {
        $address = $this->Users_model->getAddressBookById($id);
        if ($address) {
            return TRUE;
        } else {
            $this->form_validation->set_message('validAddress', 'Invalid address');
            return FALSE;
        }
    }

    public function orderlist_get() {
        $this->load->model('Offer_model');
        $orders_products = $this->Order_model->getBuyersOrders($this->_payload->userid);
        //print_r($orders_products);
        
        foreach($orders_products as $products){
            if($products->offer_status != null){
                $isOfferExpired = $this->Offer_model->checkOfferValidity(
                        $products->offer_start_time, $products->offer_end_time,
                        $products->offer_status);
                if(!$isOfferExpired){
                    $products->offer_expired_flag = true;
                    $products->offer_expired_msg = 'Product Offer Has Expired!';
                } else {
                    $products->offer_expired_flag = false;
                    $products->offer_expired_msg = "";
                }
            }else {
                $products->offer_expired_flag = false;
                $products->offer_expired_msg = "";
            }
        }
        $output = [
            "ws" => "orderlist",
            "status" => 1,
            "message" => "List of orders",
            "order_status" => $this->Common_model->getAll('orders_status')->result_array(),
            "data" => $orders_products,
            //$this->Order_model->getBuyersOrders($this->_payload->userid),
        ];

        $this->response($output, REST_Controller::HTTP_OK);
    }

    function before_authenticate_order_post() {
        $output = [
            "ws" => 'before_authenticate_order',
            "status" => 0,
            "message" => "Unable to Order",
            "data" => []
        ];

        if (!empty($this->_payload->userid)) {
            $orders_id = $this->input->post('orders_id');

            if (!empty($orders_id)) {
                //Check Order Pending and applied with Coupon
                $check_order = $this->Order_model->check_order_with_coupon_applied($orders_id);

                if ($check_order == 0) {
                    //Cross Verify Amount and Coupon Validity
                    $output["data"] = 0;
                    $output["status"] = 1;
                    $output["message"] = "All Correct !";
                } elseif ($check_order == 1) {
                    $output["data"] = 1;
                    $output["status"] = 1;
                    $output["message"] = "Coupon Has been Expired ! Make Payment Again.";
                } else {
                    $output["data"] = 2;
                    $output["status"] = 0;
                    $output["message"] = "No Coupon Applied !";
                }
            } else {
                $output["status"] = 0;
                $output["message"] = "Invalid Order !";
            }
        }
        $this->response($output, REST_Controller::HTTP_OK);
    }

    public function authenticate_order_post() {

        $output = [
            "ws" => 'authenticate_order',
            "status" => 0,
            "message" => "Unable to Order",
            "data" => []
        ];


        if (!empty($this->_payload->userid)) {

            $userid = $this->_payload->userid;
            $userName = $this->_payload->user_full_name;
            $trans_id = $this->input->post('trans_id');
            $orders_id = $this->input->post('orders_id');
            $sent_wallet_amount = $this->input->post('wallet_amount');
            $sent_card_amount = $this->input->post('card_amount');

            if (($trans_id == 'NA') && (!empty($orders_id) && $sent_card_amount == 0 && $sent_wallet_amount > 0)) {
//Order Detail  

                $orderDetail = $this->Order_model->getBuyersOrderbyOrderID($orders_id);

                $user_wallet_balance = $this->Profile_model->user_wallet_balance($userid);

                $pay_amount = $orderDetail['grand_price']; //From Database

                if ($user_wallet_balance >= $sent_wallet_amount && trim($sent_wallet_amount) == trim($pay_amount)) {

                    //Notify to user admin and seller
                    $this->order_placed_notify($orders_id);

                    $updata['orders_status'] = 10;
                    $updata['payment_method'] = $array[8];

                    $up = $this->Common_model->update('orders', $updata, array('orders_id' => $orders_id, 'orders_status' => 8));

                    if ($up) {
                        /*                         * ********** Add payable amount to vendors wallet ******* */
                        $this->addToVendorWallet($orders_id);

                        $output["data"] = $this->Order_model->getBuyersOrderbyOrderID($orders_id);
                        $output["status"] = 1;
                        $output["message"] = "Order Place Successfully !";

//Order History
                        $orderHistory1['orders_id'] = $orders_id;
                        $orderHistory1['status'] = 16;
                        $orderHistory1['date_added'] = date('Y-m-d H:i:s');
                        $orderHistory1['comment'] = 'Order Accepted !';
                        $this->Common_model->insert('orders_history', $orderHistory1);
//Order History
                        $orderHistory2['orders_id'] = $orders_id;
                        $orderHistory2['status'] = 10;
                        $orderHistory2['date_added'] = date('Y-m-d H:i:s');
                        $orderHistory2['comment'] = 'Order in Processing !';

                        $this->Common_model->insert('orders_history', $orderHistory2);

                        //Exipre Token if Token Available of perticular Product
                        $this->Coupon_model->expire_coupon($orders_id);

                        $update_wallet_arr = array();
                        $insert_wallet_history_arr = array();

                        $update_wallet_arr['balance'] = $user_wallet_balance - $sent_wallet_amount;

                        $update_rec = $this->Common_model->update('buyer_wallet', $update_wallet_arr, ['user_id' => $userid]);

                        if ($update_rec) {
                            $insert_wallet_history_arr = array();
                            $insert_wallet_history_arr['buyer_id'] = $userid;
                            $insert_wallet_history_arr['amount'] = $sent_wallet_amount;
                            $insert_wallet_history_arr['transaction_type'] = 'debit';
                            $insert_wallet_history_arr['against'] = 'refund';
                            $insert_wallet_history_arr['referrence'] = $orders_id;
                            $insert_wallet_history_arr['remark'] = 'Amount Deducted from wallet for order #' . $orders_id;
                            $insert_wallet_history_arr['created'] = date('Y-m-d H:i:s');
                            $insert_wallet_history_arr['status'] = 1;

                            $this->Common_model->insert('buyer_wallet_history', $insert_wallet_history_arr);
                        }
                        $msg = " From User " . $userName . "( app ) with order #ORD" . $orders_id;
                        $msg_buyer = "New Order Placed with order #ORD" . $orders_id . ' Click to track Order ';
                        //INser Notification
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
                            'user_id' => $userid,
                            'type' => 'order_place',
                            'reference_id' => $orders_id,
                            'status' => 'Received'
                        );
                        $this->Product_model->insertAdminNotify($adminNotify);
                        $this->Product_model->insertSellerNotify($sellerNotify);
                        $this->Product_model->insertBuyerNotify($buyerNotify);
                        //send Email
                        $this->send_email_order_placed($orders_id);
                    }
                } else {
                    $output["status"] = 0;
                    $output["message"] = "Order Amount Not Matched!";
                }
            } elseif ((!empty($trans_id)) && (!empty($orders_id) && $sent_card_amount > 0)) {

///////////////////////////////Payment Verify Start////////////////////
                $key_id = RAZOR_KEY_ID;
                $key_secret = RAZOR_KEY_SECRET;

                $url = 'https://api.razorpay.com/v1/payments/' . $trans_id;
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

                    $pay_amount = $orderDetail['grand_price']; //From Database



                    $amt_to_pay = ($array[2] / 100); //From User



                    $user_wallet_balance = $this->Profile_model->user_wallet_balance($userid);


                    $user_total_amount = $sent_wallet_amount + $amt_to_pay;



                    if ($user_wallet_balance >= $sent_wallet_amount && $user_total_amount >= $pay_amount) {

                        if ((trim($array[4]) == 'authorized')) {
                            if (trim($user_total_amount) == trim($pay_amount)) {

                                //Notify to user admin and seller
                                $this->order_placed_notify($orders_id);

                                $updata['orders_status'] = 10;
                                $updata['payment_method'] = $array[8];

                                $up = $this->Common_model->update('orders', $updata, array('orders_id' => $orders_id, 'orders_status' => 8));

                                if ($up) {

                                    /*                                     * ********** Add payable amount to vendors wallet ******* */
                                    $this->addToVendorWallet($orders_id);
                                    $output["data"] = $this->Order_model->getBuyersOrderbyOrderID($orders_id);
                                    $output["status"] = 1;
                                    $output["message"] = "Order Place Successfully !";

//Order History
                                    $orderHistory1['orders_id'] = $orders_id;
                                    $orderHistory1['status'] = 16;
                                    $orderHistory1['date_added'] = date('Y-m-d H:i:s');
                                    $orderHistory1['comment'] = 'Order Accepted !';
                                    $this->Common_model->insert('orders_history', $orderHistory1);
//Order History
                                    $orderHistory2['orders_id'] = $orders_id;
                                    $orderHistory2['status'] = 10;
                                    $orderHistory2['date_added'] = date('Y-m-d H:i:s');
                                    $orderHistory2['comment'] = 'Order in Processing !';

                                    $this->Common_model->insert('orders_history', $orderHistory2);
                                    $update_wallet_arr = array();
                                    $insert_wallet_history_arr = array();

                                    $update_wallet_arr['balance'] = $user_wallet_balance - $sent_wallet_amount;

                                    $update_rec = $this->Common_model->update('buyer_wallet', $update_wallet_arr, ['user_id' => $userid]);

                                    if ($update_rec) {
                                        $insert_wallet_history_arr = array();
                                        $insert_wallet_history_arr['buyer_id'] = $userid;
                                        $insert_wallet_history_arr['amount'] = $sent_wallet_amount;
                                        $insert_wallet_history_arr['transaction_type'] = 'debit';
                                        $insert_wallet_history_arr['referrence'] = $orders_id;
                                        $insert_wallet_history_arr['remark'] = 'Amount Deducted from wallet for order #' . $orders_id;
                                        $insert_wallet_history_arr['created'] = date('Y-m-d H:i:s');
                                        $insert_wallet_history_arr['status'] = 1;

                                        $this->Common_model->insert('buyer_wallet_history', $insert_wallet_history_arr);

                                        $insert_wallet_history_arr = array();
                                        $insert_wallet_history_arr['buyer_id'] = $userid;
                                        $insert_wallet_history_arr['amount'] = $sent_card_amount;
                                        $insert_wallet_history_arr['transaction_type'] = 'debit';
                                        $insert_wallet_history_arr['referrence'] = $orders_id;
                                        $insert_wallet_history_arr['remark'] = 'User Pay through card for order #' . $orders_id;
                                        $insert_wallet_history_arr['created'] = date('Y-m-d H:i:s');
                                        $insert_wallet_history_arr['status'] = 1;

                                        //$this->Common_model->insert('buyer_wallet_history', $insert_wallet_history_arr);
                                        $msg = " From User " . $userName . "( app ) with order #ORD" . $orders_id;
                                        $msg_buyer = "New Order Placed with order #ORD" . $orders_id . ' Click to track Order ';
                                        //INser Notification
                                    }
                                    $msg = " From User " . $userName . "( app ) with order #ORD" . $orders_id;
                                    $msg_buyer = "New Order Placed with order #ORD" . $orders_id . ' Click to track Order ';
                                    //INser Notification
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
                                        'user_id' => $userid,
                                        'type' => 'order_place',
                                        'reference_id' => $orders_id,
                                        'status' => 'Received'
                                    );
                                    $this->Product_model->insertAdminNotify($adminNotify);
                                    $this->Product_model->insertSellerNotify($sellerNotify);
                                    $this->Product_model->insertBuyerNotify($buyerNotify);
                                    //send Email
                                    $this->send_email_order_placed($orders_id);
                                } else {
                                    $output["status"] = 0;
                                    $output["message"] = "Order Not Found!";
                                }
                            } else {
                                $updata['orders_status'] = 22;
                                $this->Common_model->update('orders', $updata, array('orders_id' => $orders_id, 'orders_status' => 8));
//History
                                $orderHistory['orders_id'] = $orders_id;
                                $orderHistory['status'] = 22;
                                $orderHistory['date_added'] = date('Y-m-d H:i:s');
                                $orderHistory['comment'] = 'Order in Waiting !';
                                $this->Common_model->insert('orders_history', $orderHistory);

                                $this->order_waiting_notify($orders_id);

                                $output["status"] = 0;
                                $output["message"] = "Waiting";
                            }
                        } else {

                            $output["status"] = 0;
                            $output["message"] = "Payment Failed !";
                        }
                    } else {
                        $output["status"] = 0;
                        $output["message"] = "Sent Wallet amount is less than wallet balance or total paid amount is not sufficient!";
                    }
                    if (!empty($array[4])) {
//Insert Payment Transaction
                        $payData['payment_id'] = $array[0]; //Tras Id
                        $payData['user_id'] = $userid;
                        $payData['email'] = $array[17];
                        $payData['contact'] = $array[18];
                        $payData['orders_id'] = $orders_id;
                        $payData['amount'] = ($array[2] / 100);
                        $payData['currency'] = $array[3];
                        $payData['status'] = $array[4];
                        $payData['method'] = $array[8];
                        $payData['description'] = $array[12];
                        $payData['created_at'] = $array[24];
                        $up = $this->Common_model->insert('order_payment', $payData);
                    }
                } else {

                    $output["status"] = 0;
                    $output["message"] = "Order Failed !";
                }
            } else {

                $output["status"] = 0;
                $output["message"] = "Order Not Found !";
            }


//////////////////////////Payment Verify End//////////////////////


            $this->response($output, REST_Controller::HTTP_OK);
        } else {
            $this->response($output, REST_Controller::HTTP_OK);
        }
    }

    /* public function cancelReasons_get() {

      $output = [
      "ws" => "cancelReasons",
      "data" => $this->Order_model->getCancellationReasons(),
      "status" => 1,
      "message" => "List of cancel reasons"
      ];
      $this->response($output, REST_Controller::HTTP_OK);
      } */

    public function cancelReasons_post() {

        $ws_temp = $this->post("ws");
        $ws = "cancelReasons";
        if (isset($ws_temp)) {
            $ws = $ws_temp;
        }
        $output = [
            "status" => 0,
            "message" => "Invalid Inputs",
            "ws" => $ws
        ];

        $this->form_validation->set_rules("reason_type", "Type", "required");

        if ($this->form_validation->run() === false) {
            $this->response($output, REST_Controller::HTTP_OK);
        } else {
            $reason_type = $this->input->post('reason_type');

            $output = [
                "ws" => "cancelReasons",
                "data" => $this->Order_model->getCancellationReasons($reason_type),
                "status" => 1,
                "message" => "List of  " . $reason_type . "  reasons"
            ];

            $this->response($output, REST_Controller::HTTP_OK);
        }
    }

    public function returnOrder_post() {

        $ws_temp = $this->post("ws");
        $ws = "returnOrder";
        if (isset($ws_temp)) {
            $ws = $ws_temp;
        }
        $output = [
            "status" => 0,
            "message" => "Invalid Inputs",
            "ws" => $ws
        ];

        $this->form_validation->set_rules("order_id", "Order", "required");
        $this->form_validation->set_rules("reason_id", "Reason", "required");

        if ($this->form_validation->run() === false) {
            $this->response($output, REST_Controller::HTTP_OK);
        } else {
            $order_id = $this->input->post('order_id');
            $reason_id = $this->input->post('reason_id');
            $user_id = $this->_payload->userid;

            $ship_method = $this->send_data->get_shipping_method();

            //Shipping Address Details
            $chech_shipp = $this->Common_model->getAll('shipping_vendor', array('id' => $ship_method))->row();
            $order_shipping_data = $this->Common_model->getAll('order_shipping', array('orders_id' => $order_id))->row();

            //Get Order Details
            $pr_details = $this->Order_model->getOrderDetails($order_id);

            //get +3 Days of delivery date
            $delivery_date = $pr_details[0]->delivery_date;

            $return_days = strtotime(date('Y-m-d', strtotime($delivery_date . ' + 3 days')));

            if ($pr_details[0]->orders_status == 4) {

                ////////////////////////////
                ////////////////////////////
                $user = $this->Common_model->getAll('users', array('id' => $user_id))->row();

                $dat['orders_id'] = $order_id;
                $dat['return_reason'] = $reason_id;
                $dat['user_id'] = $user_id;
                $dat['return_type'] = 'full';
                $dat['order_from'] = $pr_details[0]->order_from;

                $dat['pick_name'] = $pr_details[0]->user_name;
                $dat['pick_addr_type'] = 'From User';
                $dat['pick_country'] = $pr_details[0]->delivery_country;
                $dat['pick_state'] = $pr_details[0]->delivery_city . ' , ' . $pr_details[0]->delivery_state;
                $dat['pick_mobile'] = $user->phone;
                $dat['pick_email'] = $user->email;
                $dat['pick_pincode'] = $pr_details[0]->delivery_postcode;
                $dat['pick_days'] = 0;
                $dat['delivery_name'] = $pr_details[0]->pick_name;
                $dat['delivery_street_address'] = $pr_details[0]->pick_addr_type;
                $dat['delivery_city'] = $pr_details[0]->delivery_city;
                $dat['delivery_postcode'] = $pr_details[0]->pick_pincode;
                $dat['delivery_state'] = $pr_details[0]->pick_state;
                $dat['delivery_country'] = $pr_details[0]->pick_country;
                $dat['delivery_email_address'] = $pr_details[0]->pick_email;

                $dat['delivery_address_format_id'] = 0;
                $dat['payment_method'] = $pr_details[0]->payment_method;
                $dat['last_modified'] = $pr_details[0]->last_modified;
                $dat['date_purchased'] = $pr_details[0]->date_purchased;

                $dat['shipping_cost'] = 0;
                $dat['shipping_subtotal'] = 0;
                $dat['shipping_gst'] = 0;

                if ($pr_details[0]->shippment_type == 'Free') {
                    $dat['order_price'] = $pr_details[0]->order_price;
                } else {
                    $dat['order_price'] = $pr_details[0]->order_price - $pr_details[0]->shipping_cost;
                }


                //$dat['order_price'] = $pr_details[0]->order_price;

                $dat['shipping_method'] = $pr_details[0]->shipping_method;
                $dat['ex_shipping_days'] = $pr_details[0]->ex_shipping_days;
                $dat['shipping_expected_date'] = '';
                $dat['remark'] = $pr_details[0]->remark;
                $dat['orders_status'] = 23;
                $dat['order_tracking_status'] = 1;
                $dat['order_token_number'] = 0;
                $dat['comments'] = $pr_details[0]->comments;
                $dat['currency'] = $pr_details[0]->currency;
                $dat['seller_id'] = $pr_details[0]->seller_id;
                $dat['user_telephone'] = $user->phone;


                $seller_id = $pr_details[0]->seller_id;
                $insert_id = $this->Common_model->insert('return_orders', $dat);
                $grand_price = $pr_details[0]->order_price - $pr_details[0]->shipping_cost;
                if ($insert_id) {
                    $ship_cost_subtotal = 0;
                    $tot_quantity = 0;
                    $actual_order_price = 0;
                    $tot_weight = 0;


                    $max_length = 0.5;
                    $max_height = 0.5;
                    $max_width = 0.5;
                    $max_tot_weight = 0;

                    foreach ($pr_details as $pro) {

                        //Shiipigrate Calculate Start 
                        $prod_dat = $this->send_data->get_product_detail($pro->products_id);
                        //Shippig rate Calculate Start 
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

                        $wt = $prod_dat->weight * $pro->products_quantity;
                        $max_tot_weight = $max_tot_weight + $wt;

                        $ch_seller = $this->Common_model->getAll('product_details', array('id' => $pro->products_id))->row();
                        $ch_addr_seller = $this->Common_model->getAll('seller_pick_address', array('user_id' => $seller_id))->row();

                        //$tot_weight=$tot_weight+$ch_seller->weight;
                        $tot_weight = $ch_seller->weight * $pro->products_quantity;


                        $tot_quantity = $tot_quantity + $pro->products_quantity;
                        $actual_order_price = $pro->products_price;

                        //shipping rate
                        $rate = $this->Shipping_model->get_return_shipping_rate($tot_weight, $pr_details[0]->pick_pincode, $pr_details[0]->delivery_postcode);

                        if ($ship_method == 1 && $rate > 0) {
                            $ship_cost = $this->shipping->get_return_shipping_cost_for_multiple($pro->products_id, $rate, $pro->products_quantity, $tot_weight, $actual_order_price, $pr_details[0]->delivery_postcode);
                            $ship_cost_subtotal = $ship_cost_subtotal + $ship_cost;

                            $dat_pro['return_orders_id'] = $insert_id;
                            $dat_pro['products_id'] = $pro->products_id;
                            $dat_pro['products_name'] = $pro->products_name;
                            $dat_pro['products_price'] = $pro->products_price;
                            $dat_pro['final_price'] = $pro->final_price;
                            $dat_pro['vendors_price'] = $pro->vendors_price;
                            $dat_pro['products_tax'] = 0.00;
                            $dat_pro['products_quantity'] = $pro->products_quantity;
                            $dat_pro['product_specifications'] = $pro->product_specifications;

                            $this->Common_model->insert('return_orders_products', $dat_pro);
                            $sons = 1;
                        } elseif ($ship_method == 2) {

                            $dat_pro['return_orders_id'] = $insert_id;
                            $dat_pro['products_id'] = $pro->products_id;
                            $dat_pro['products_name'] = $pro->products_name;
                            $dat_pro['products_price'] = $pro->products_price;
                            $dat_pro['final_price'] = $pro->final_price;
                            $dat_pro['vendors_price'] = $pro->vendors_price;
                            $dat_pro['products_tax'] = 0.00;
                            $dat_pro['products_quantity'] = $pro->products_quantity;
                            $dat_pro['product_specifications'] = $pro->product_specifications;

                            $this->Common_model->insert('return_orders_products', $dat_pro);
                        } else {
                            $output["status"] = 0;
                            $output["message"] = "Somthing Wrong In Order !";
                            $this->Common_model->delete('return_orders', array('orders_id' => $insert_id));
                        }
                    }


                    // add gst to shipping cost
                    if ($ship_method == 2) {

                        //New
                        $pickup_pincode = $pr_details[0]->delivery_postcode;
                        $delivery_pincode = $pr_details[0]->pick_pincode;
                        //$ship_rocket_cost = $this->shiprocket->serviceability_for_multiple($pickup_pincode, $delivery_pincode, $max_length, $max_width, $max_height, $max_tot_weight);
                        $ship_rocket_cost = $this->shiprocket->return_serviceability_for_multiple($order_shipping_data->ship_order_id);
                        //echo $order_shipping_data->ship_order_id;
                        //echo'<pre>';
                        //print_r($ship_rocket_cost);
                        //  exit;
                        if ($ship_rocket_cost['status'] == 200) {
                            $courier_id = $ship_rocket_cost['courier_id'];
                            $shipping_rate = $ship_rocket_cost['rate'];
                            $shipping_subtotal = ($ship_rocket_cost['rate'] - ($ship_rocket_cost['rate'] * (18 / 100)));
                            $shipping_gst = ($ship_rocket_cost['rate'] * (18 / 100));
                            $exp_shipping_date = $ship_rocket_cost['est_date'];
                            $ship_cost_subtotal = $shipping_rate;
                        } else {
                            $this->Common_model->delete('return_orders', array('return_orders_id' => $insert_id));
                            $this->Common_model->delete('return_orders_products', array('return_orders_id' => $insert_id));

                            $output["status"] = 0;
                            $output["message"] = "Return Not Pickable !";
                            $this->response($output, REST_Controller::HTTP_OK);
                            exit;
                        }
                        //New End
                        $gst = ($shipping_rate * (18 / 100));
                        $final_shipping_cost = $shipping_rate;
                        $ship_cost_subtotal = $final_shipping_cost - $gst;
                    } else {
                        $gst = $ship_cost_subtotal * (18 / 100);
                        $final_shipping_cost = $ship_cost_subtotal + $gst;
                    }

                    $dat['shipping_subtotal'] = $ship_cost_subtotal;
                    $dat['shipping_gst'] = $gst;
                    $dat['shipping_cost'] = $final_shipping_cost;
                    $dat['order_price'] = round($grand_price + $final_shipping_cost, 2);
                    //update Order
                    $this->Common_model->update('return_orders', $dat, array('orders_id' => $order_id));
                }

                //Insert into Return Shipping Order
                $ship_dat['ship_vendor_id'] = $ship_method;
                $ship_dat['orders_id'] = $order_id;
                $ship_dat['return_orders_id'] = $insert_id;
                $ship_dat['courier_id'] = $courier_id;
                $ship_dat['shipping_subtotal'] = $ship_cost_subtotal;
                $ship_dat['shipping_gst'] = $gst;
                $ship_dat['shipping_cost'] = $final_shipping_cost;
                $ship_dat['on_amount'] = $chech_shipp->free_amount;
                $ship_dat['pickup_pincode'] = $pr_details[0]->delivery_postcode;
                $ship_dat['delivery_pincode'] = $pr_details[0]->pick_pincode;
                $ship_dat['shippment_type'] = $chech_shipp->shipping_type;
                $ship_dat['length'] = $max_length;
                $ship_dat['breadth'] = $max_width;
                $ship_dat['height'] = $max_height;
                $ship_dat['weight'] = $max_tot_weight;
                $insert_ship_id = $this->Common_model->insert('return_order_shipping', $ship_dat);

                //Generate Order if Use Ship Rocket
                if ($ship_method == 2) {
                    $resp = $this->shiprocket->return_create_order_new($insert_id, $order_id);
                    //echo'<pre>';
                    //print_r($resp);
                    //exit;
                    if (!empty($resp['shipment_id'])) {
                        $up_ord['ship_order_id'] = $resp['order_id'];
                        $up_ord['shipment_id'] = $resp['shipment_id'];
                        $this->Common_model->update('return_order_shipping', $up_ord, array('ship_id' => $insert_ship_id));

                        $sons = 1;
                    } else {
                        $sons = 0;
                        $this->Common_model->delete('return_orders', array('return_orders_id' => $insert_id));
                        $this->Common_model->delete('return_orders_products', array('return_orders_id' => $insert_id));
                        $this->Common_model->delete('return_order_shipping', array('ship_id' => $insert_ship_id));

                        $output["status"] = 0;
                        $output["message"] = "Return Not Pickable !";
                    }
                }


                if ($sons == 1) {

                    //Update Order Status
                    $up['orders_status'] = 23;
                    $up['order_tracking_status'] = 3;

                    $this->Common_model->update('orders', $up, array('orders_id' => $order_id, 'orders_status' => 4));

                    //Order Request and Return Order Request
                    $insertHistory['orders_id'] = $order_id;
                    $insertHistory['status'] = 23;
                    $insertHistory['date_added'] = date('Y-m-d H:i:s');
                    $insertHistory['comment'] = 'Return Request Pending';
                    $insertHistory['customer_notified'] = 1;
                    $this->Common_model->insert('orders_history', $insertHistory);
                    $RinsertHistory['orders_id'] = $insert_id;
                    $RinsertHistory['status'] = 23;
                    $RinsertHistory['date_added'] = date('Y-m-d H:i:s');
                    $RinsertHistory['comment'] = 'Return Request Pending';
                    $insertHistory['customer_notified'] = 1;

                    $this->Common_model->insert('return_orders_history', $insertHistory);
                    $this->order_return_notify($order_id);

                    $output["status"] = 1;
                    $output["message"] = "Return Request Sent Successfully !";
                }
                ////////////////////////////
                ////////////////////////////
            } else {
                $output["status"] = 0;
                $output["message"] = "Order Return Only In 3 Days !";
            }


            $this->response($output, REST_Controller::HTTP_OK);
        }
    }

    function cancelOrder_post() {
        $ws_temp = $this->post("ws");
        $ws = "cancelOrder";
        if (isset($ws_temp)) {
            $ws = $ws_temp;
        }
        $output = [
            "status" => 0,
            "message" => "Invalid Inputs",
            "ws" => $ws
        ];

        $this->form_validation->set_rules("order_id", "Order ID", "required");
        $this->form_validation->set_rules("cancel_reason", "Reason", "required");

        if ($this->form_validation->run() === false) {
            $this->response($output, REST_Controller::HTTP_OK);
        } else {
            $order_id = $this->input->post('order_id');
            $reason = $this->input->post('cancel_reason');
            $other_reason = $this->input->post('other_reason');
            $user_id = $this->_payload->userid;

            //Update Tracking
            $this->shipping->latest_tracking_status($order_id);

            $seller_q = $this->Order_model->getOrderDetailsByOrderId($order_id);

            $seller = $seller_q[0]['seller'];

            $ch_order = $this->Common_model->getAll('orders', array('user_id' => $user_id, 'orders_id' => $order_id))->num_rows();

            if ($ch_order > 0) {


////////////////////Refund Check////////////////////
                $ordcheck = 0;
//check status Processing Or Not
                $ch_processing = $this->Common_model->getAll('orders_history', array('status' => 10, 'orders_id' => $order_id))->num_rows();

                //Check Pick Up
                $ch_pick = $this->Common_model->getAll('orders_history', array('status' => 18, 'orders_id' => $order_id))->num_rows();


                //Insert Refund Data
                $insertRefund['orders_id'] = $order_id;
                $insertRefund['seller'] = $seller;
                $insertRefund['orders_status'] = 'Initiated';
                $insertRefund['reason_id'] = $reason;
                $insertRefund['other_reason'] = $other_reason;
                $insertRefund['created_at'] = date('Y-m-d H:i:s');


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

                    //Cancel Order 
                    if ($orderDetails[0]['order_token_number'] != 0) {

                        $token_no = $orderDetails[0]['order_token_number'];
                        $pickup_date = $orderDetails[0]['ShipmentPickupDate'];
                        $res = $this->shipping->cancel_pickup($token_no, $pickup_date);
                    }

                    if ($orderDetails[0]['awb_number'] != 0) {
                        $this->shipping->cancelwaybill($orderDetails[0]['awb_number']);
                    }

                    //insert in adminnotify table
                    $msg = "Order Canceled By Buyer  " . $this->_payload->user_full_name . ' of order #ORD' . $order_id;
                    $msg_buyer = "Order Cancel of order #ORD" . $order_id;
                    $adminNotify = array(
                        'title' => 'Order Cancel & Refund',
                        'msg' => $msg . ' ( App ) ',
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

                    $this->Product_model->insertAdminNotify($adminNotify);
                    $this->Product_model->insertBuyerNotify($buyerNotify);

                    $this->order_cancel_notify($order_id, 1);


                    $output["status"] = 1;
                    $output["message"] = "Order Cancelled Successfully ! Amount add to Your wallet ";
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

                    //Send SMS to Customer
                    $msg = 'Cancel Request Send Successfully !';
                    $mob = $this->session->userdata("phone");
                    $this->send_data->send_sms($msg, $mob);

                    //Notify To Seller

                    $this->order_cancel_notify($order_id, 0);

                    //insert in adminnotify table
                    $msg = "Order Canceled Request By Buyer  " . $this->_payload->user_full_name . ' of order #ORD' . $order_id;
                    $msg_buyer = "Order Cancel Request of order #ORD" . $order_id;
                    $adminNotify = array(
                        'title' => 'Order Cancel Request Pending',
                        'msg' => $msg . ' ( App ) ',
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

                    $this->Product_model->insertAdminNotify($adminNotify);
                    $this->Product_model->insertBuyerNotify($buyerNotify);


                    $output["status"] = 1;
                    $output["message"] = "Cancel Request Send Successfully !";
                } else {
                    $output["status"] = 0;
                    $output["message"] = "Order Not Found !";
                }



///////////////////Refund Enf//////////////////////
            } else {
                $output["status"] = 0;
                $output["message"] = "Order Not Found !";
            }


            $this->response($output, REST_Controller::HTTP_OK);
        }
    }

    public function isvalidorder($order_id) {
        $user = $this->_payload->userid;
        $order = $this->Order_model->checkValidUserOrder($user, $order_id);
        if (!$order) {
            $this->form_validation->set_message("isvalidorder", "Invalid order");
            return false;
        } else {
            return true;
        }
    }

    public function getOrderDetails_post() {

        $ws = $this->post("ws");
        if (empty($ws)) {
            $ws = "getOrderDetails";
        }

        $this->form_validation->set_rules("order_id", "order_id", "required");

        if ($this->form_validation->run() === false) {
            $output = array(
                "ws" => $ws,
                "status" => 0,
                "message" => "Invalid Inputs"
            );
            $this->response($output, REST_Controller::HTTP_OK);
        } else {
            $user = $this->_payload->userid;
            //Order Cancel against order status 
            $sid = array(9, 10, 16, 18, 19, 26);
            $this->db->select('orders_status_name as status');
            $this->db->from('orders_status');
            $this->db->where_in('orders_status_id', $sid);
            $cancel_status = $this->db->get()->result_array();

            $order_id = $this->post('order_id');
            $output["ws"] = $ws;
            $output["status"] = 1;
            $output["message"] = "Order Details fetch success.";
            $output["cancel_order_status"] = $cancel_status;
            $orderDetails = $this->Order_model->getOrderDetailsByOrderId($order_id);

            $orderProductDeatails = [];

//Get Latest Tracking Status//
            $this->shipping->latest_tracking_status($order_id);

            $final_tot_prod_amount = 0;
            for ($i = 0; $i < count($orderDetails); $i++) {
                if ($orderDetails[$i]['offer_status'] != null) {
                    $isOfferExpired = $this->Offer_model->checkOfferValidity(
                            $orderDetails[$i]['offer_start_time'], $orderDetails[$i]['offer_end_time'],
                            $orderDetails[$i]['offer_status']);
                    if (!$isOfferExpired) {
                        $orderProductDeatails[$i]['offer_expired_flag'] = true;
                        $orderProductDeatails[$i]['offer_expired_msg'] = 'Product Offer Has Expired!';
                    } else {
                        $orderProductDeatails[$i]['offer_expired_flag'] = false;
                        $orderProductDeatails[$i]['offer_expired_msg'] = "";
                    }
                } else {
                    $orderProductDeatails[$i]['offer_expired_flag'] = false;
                    $orderProductDeatails[$i]['offer_expired_msg'] = "";
                }
                $orderProductDeatails[$i]['product_id'] = $orderDetails[$i]['product_id'];
                $orderProductDeatails[$i]['product_name'] = $orderDetails[$i]['product_name'];
                $orderProductDeatails[$i]['products_price'] = $orderDetails[$i]['products_price'];
                $orderProductDeatails[$i]['products_tax'] = $orderDetails[$i]['products_tax'];
                $orderProductDeatails[$i]['product_image'] = $orderDetails[$i]['product_image'];
                $orderProductDeatails[$i]['units_id'] = $orderDetails[$i]['units_id'];
                $orderProductDeatails[$i]['units_name'] = $orderDetails[$i]['units_name'];
                $orderProductDeatails[$i]['products_quantity'] = $orderDetails[$i]['products_quantity'];
                $orderProductDeatails[$i]['width'] = $orderDetails[$i]['width'];
                $orderProductDeatails[$i]['length'] = $orderDetails[$i]['length'];
                $orderProductDeatails[$i]['weight'] = $orderDetails[$i]['weight'];
                $orderProductDeatails[$i]['product_specifications'] = json_decode($orderDetails[$i]['product_specifications']);
                $final_tot_prod_amount = $final_tot_prod_amount + $orderDetails[$i]['final_price'];
            }
            if (!empty($orderDetails[0]['orders_id'])) {
                $output['data']['payment_detail'] = $this->Common_model->getAll('order_payment', array('orders_id' => $order_id))->result_array();
                $output['data']["products"] = $orderProductDeatails;
                $output['data']["grand_total"] = $orderDetails[0]['order_price'];
                $output['data']["final_order_amount"] = $final_tot_prod_amount;
                $output['data']["seller_company_name"] = $orderDetails[0]['seller_company_name'];
                $output['data']["seller_company_name"] = $orderDetails[0]['seller_company_name'];
                $output['data']["order_status_image"] = $orderDetails[0]['order_status_image'];
                $output['data']["orders_id"] = $orderDetails[0]['orders_id'];
                $output['data']["orders_status"] = $orderDetails[0]['orders_status'];
                $output['data']["orders_status_name"] = $orderDetails[0]['orders_status_name'];
                $output['data']["user_id"] = $orderDetails[0]['user_id'];
                $output['data']["user_name"] = $orderDetails[0]['user_name'];
                $output['data']["user_street_address"] = $orderDetails[0]['user_street_address'];
                $output['data']["user_city"] = $orderDetails[0]['user_city'];
                $output['data']["user_postcode"] = $orderDetails[0]['user_postcode'];
                $output['data']["user_state"] = $orderDetails[0]['user_state'];
                $output['data']["user_country"] = $orderDetails[0]['user_country'];
                $output['data']['payment_country'] = $orderDetails[0]['payment_country'];
                $output['data']["user_telephone"] = $orderDetails[0]['user_telephone'];
                $output['data']["user_email_address"] = $orderDetails[0]['user_email_address'];
                $output['data']["delivery_name"] = $orderDetails[0]['delivery_name'];
                $output['data']["delivery_street_address"] = $orderDetails[0]['delivery_street_address'];
                $output['data']["delivery_city"] = $orderDetails[0]['delivery_city'];
                $output['data']["delivery_postcode"] = $orderDetails[0]['delivery_postcode'];
                $output['data']["delivery_state"] = $orderDetails[0]['delivery_state'];
                $output['data']['delivery_country'] = $orderDetails[0]['delivery_country'];
                $output['data']["date_purchased"] = $orderDetails[0]['date_purchased'];
                $output['data']["shipping_cost"] = $orderDetails[0]['shipping_cost'];
                $output['data']["currency"] = $orderDetails[0]['currency'];
                $output['data']["payment_method"] = $orderDetails[0]['payment_method'];
                $output['data']["delivery_return"] = $this->Order_model->check_delivery_return($order_id);
                $output['data']["return_shipping_cost"] = $this->Order_model->check_return_shipping_cost($order_id);
                $output['data']["ships_outs_within"] = "Ship 1-10 day(s) after initial payment is received";
                $output['data']["logistic_company"] = "Blue Dart";
                $output['data']["shippment_type"] = $orderDetails[0]['shippment_type'];
                $output['data']["coupon_apply"] = $this->Order_model->check_coupon_on_order($order_id);
                $output['data']["coupon_value"] = $this->Order_model->get_coupon_on_order($order_id, $user);
            } else {
                $output['data'] = '';
            }
            $this->response($output, REST_Controller::HTTP_OK);
        }
    }

    public function startMultiProductOrder_post() {

        $ws = $this->post('ws');

        if (empty($ws)) {
            $ws = "startMultiProductOrder";
        }

        $output = [
            "ws" => $ws,
            "status" => 0,
            "message" => "Invalid inputs"
        ];
        $this->form_validation->set_rules("products", "Product", "required", array(
            "required" => "invalid inputs"
        ));
        $this->form_validation->set_rules("address", "Address", "required|callback_validAddress", array(
            "required" => "invalid inputs"
        ));
        $this->form_validation->set_rules("grand_price", "Price", "required", array(
            "required" => "invalid inputs"
        ));
        if ($this->form_validation->run() === false) {
            $this->response($output, REST_Controller::HTTP_OK);
        } else {
            //get Shipping Method
            $ship_method = $this->send_data->get_shipping_method();
            $chech_shipp = $this->Common_model->getAll('shipping_vendor', array('id' => $ship_method))->row();

            $user_id = $this->_payload->userid;
            $user_email = $this->_payload->email;
            $address = $this->post("address");
            $remark = $this->post("remark");
            $order_from = $this->post("order_from");
            $shipping_method = $this->post("shipping_method");
            $shipping_days = $this->post("shipping_days");
            $shipping_cost = $this->post("shipping_cost");
            $seller_id = $this->post("seller_id");
            $grand_price = $this->post("grand_price");

            $products = $this->post("products");
            //check slases

            if ($products[3] == "\\") {
                $products = json_decode(stripslashes(trim($this->post("products"), '"')), true);
            } else {
                $products = json_decode($this->post("products"));
            }


            //$check = $this->validateProducts($products, $grand_price);
            // exit;
//seller pick address
            $paddress = $this->Common_model->getAll('seller_pick_address', array('user_id' => $seller_id))->row_array();
            // if ($check["status"]) {
            $user = $this->Users_model->getUserById($user_id);
            $address = $this->Users_model->getAddressBookById($address);
            $insertData = [
                "user_id" => $user_id,
                "order_from" => $order_from,
                "user_name" => $user->first_name . " " . $user->last_name,
                "user_street_address" => $address->street,
                "user_suburb" => $address->suburb,
                "user_city" => $address->city,
                "user_postcode" => $address->postcode,
                "user_state" => $address->state,
                "user_country" => $address->country,
                "user_email_address" => $user_email,
                "user_telephone" => $address->contact_number,
                "delivery_name" => $address->contact_person,
                "delivery_name" => $user->first_name . " " . $user->last_name,
                "delivery_street_address" => $address->street,
                "delivery_suburb" => $address->suburb,
                "delivery_city" => $address->city,
                "delivery_postcode" => $address->postcode,
                "delivery_state" => $address->state,
                "delivery_country" => $address->country,
                "pick_name" => $paddress['seller_name'],
                "pick_addr_type" => $paddress['address'] . ',' . $paddress['address_type'],
                "pick_address" => $paddress['address2'] . ',' . $paddress['address3'],
                "pick_country" => $paddress['country'],
                "pick_state" => $paddress['state'],
                "pick_mobile" => $paddress['seller_mobile'],
                "pick_email" => $paddress['seller_email'],
                "pick_pincode" => $paddress['pincode'],
                "pick_days" => 0,
                "ex_shipping_days" => $shipping_days,
                "shipping_cost" => $shipping_cost,
                "seller_id" => $seller_id,
                "shipping_method" => $shipping_method,
                "remark" => $remark,
                "orders_status" => 8,
                "order_price" => $grand_price,
                "orders_date_finished" => date('Y-m-d H:i:s')
            ];


            //Cross Check Coupon Applied
            $products = json_decode(json_encode($products), True);
            // echo'<pre>';
            //  print_r($products);
            // exit;
            $temp_total_price = 0;
            foreach ($products as $val):

                //check ANDROID PRODUCT RESPONSE OR IOS
                $ch_prod = $this->post("products");
                //check slases
                if ($ch_prod[3] == "\\") {
                    //for IOS 
                    $product_val = $val['products'];
                } else {
                    //for android
                    $product_val = json_decode($val['products'], true);
                }

                foreach ($product_val as $product) {
                    //echo'<pre>';
                    //  print_r($product);
                    //If Coupon Applied Start 
                    $offer_id = $product['offer_id'];
                    
                    // Check if offer has expired iff yes then send with expiration message
                    $offerExpire = $this->Offer_model->checkOfferExpiryForCartProducts($offer_id);
                    if($offerExpire != NULL){
                        $output = ["ws" => $ws,"status" => 0,"message" => 'redirect'];
                        $this->response($output, REST_Controller::HTTP_OK);
                    }
                    
                    $coupon_id = $product['coupon_id'];
                    $temp_total = $product['quantity'] * $product['unit_price'];
                    if ($coupon_id) {
                        $isvalidcoupen = $this->Coupon_model->isCouponAvailableForUser($coupon_id, $product['product_id'], $user_id);
                        if ($isvalidcoupen) {
                            $coupon = $this->Coupon_model->getCoupenById($coupon_id);
                            $temp_total = $product['quantity'] * $product['unit_price'];
                            if ($coupon->discount_type == "flat") {
                                $temp_total_after_coupon = $temp_total - $coupon->coupon_value;

                                $temp_total_price = $temp_total_price + $temp_total_after_coupon;
                            } else {
                                $percentage = ($temp_total * $coupon->coupon_value) / 100;
                                $temp_total_after_coupon = $temp_total - $percentage;
                                $temp_total_price = $temp_total_price + $temp_total_after_coupon;
                            }

                            //Validate
                            if ($product['quantity'] >= $coupon->moq && $temp_total_after_coupon == ($product['total_price'])) {
                                continue;
                            } else {
                                $output["status"] = 0;
                                $output["message"] = "Invalid Coupon Amount Of Product  " . $product['product_name'];
                                $this->response($output, REST_Controller::HTTP_OK);
                                exit;
                            }
                        } else {

                            $output["status"] = 0;
                            $output["message"] = "Invalid Coupon On " . $product['product_name'];
                            $this->response($output, REST_Controller::HTTP_OK);
                            exit;
                        }
                    } else {
                        $temp_total_price = $temp_total_price + $temp_total;
                    }
                    //Coupon Check End !
                }
            endforeach;
            //echo 'Total Db Price:' . $temp_total_price;
            //echo'<br>';
            // echo 'Passing Final Price:' . $grand_price;
            // exit;
            if ($temp_total_price != $grand_price) {
                $output["status"] = 0;
                $output["message"] = "Grand Price Not Matching !";
                $this->response($output, REST_Controller::HTTP_OK);
                exit;
            } else {

                $order_id = $this->Order_model->addOrder($insertData);


                //Inset History
                $orderHistory['orders_id'] = $order_id;
                $orderHistory['status'] = 8;
                $orderHistory['date_added'] = date('Y-m-d H:i:s');
                $orderHistory['comment'] = 'Order Requested !';

                $this->Common_model->insert('orders_history', $orderHistory);


                $output["order_id"] = $order_id;
                $notification_title = 'New Order';
                $notification_msg = 'You have new order on your product waiting for your approval';
                $notification_type = 'Order';
                $reference_id = $order_id;

                $ship_cost_subtotal = 0;
                $tot_quantity = 0;
                $actual_order_price = 0;
                $tot_weight = 0;



                $max_length = 0.5;
                $max_height = 0.5;
                $max_width = 0.5;
                $tot_qty = 0;
                $tot_weight_sr = 0;
                //For Entering Data in Order Products 
                foreach ($products as $val):

                    if ($ch_prod[3] == "\\") {
                        //for IOS 
                        $product_val = $val['products'];
                    } else {
                        //for android
                        $product_val = json_decode($val['products'], true);
                    }

                    // $product_val = json_decode($val['products'], true);

                    foreach ($product_val as $product) {


                        $ch_seller = $this->Common_model->getAll('product_details', array('id' => $product['product_id']))->row();
                        $ch_addr_seller = $this->Common_model->getAll('seller_pick_address', array('user_id' => $seller_id))->row();

                        $tot_weight = $product['quantity'] * $ch_seller->weight;


                        $tot_quantity = $tot_quantity + $product['quantity'];
                        $actual_order_price = $actual_order_price + $product['total_price'];

                        $prod_dat = $this->send_data->get_product_detail($product['product_id']);

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

                        $wt = $prod_dat->weight * $product['quantity'];
                        $tot_weight_sr = $tot_weight_sr + $wt;

                        if ($ship_method == 2) {


                            if (empty($product['coupon_id'])) {
                                $product['coupon_id'] = 0;
                            }

                            if ($chech_shipp->shipping_type == 'Free' && $grand_price >= $chech_shipp->free_amount) {
                                $shippment_type_pro = 'Free';
                            } else {
                                $shippment_type_pro = 'Paid';
                            }


                            $product_data = [
                                "orders_id" => $order_id,
                                "offer_id" => $product['offer_id'],
                                "products_id" => $product['product_id'],
                                "products_name" => $product['product_name'],
                                "coupon_id" => $product['coupon_id'],
                                "products_price" => $product['unit_price'],
                                "products_quantity" => $product['quantity'],
                                "shippment_type" => $shippment_type_pro,
                                "final_price" => $product['total_price'],
                                "product_specifications" => json_encode($product)
                            ];
                        } else {

                            //shipping rate
                           // echo $order_id.'|'.$ch_addr_seller->pick_id.'|'.$tot_weight;
                            $rate = $this->Shipping_model->get_shipping_rate($order_id, $ch_addr_seller->pick_id, $tot_weight);
                            if ($rate > 0) {
                                $ship_cost = $this->shipping->get_shipping_cost_for_multiple($product_id, $rate, $product['products_quantity'], $tot_weight, $actual_order_price, $pick_id);

                                $ship_cost_subtotal = $ship_cost_subtotal + $ship_cost;

                                if (empty($product['coupon_id'])) {
                                    $product['coupon_id'] = 0;
                                }

                                if ($chech_shipp->shipping_type == 'Free' && $grand_price >= $chech_shipp->free_amount) {
                                    $shippment_type_pro = 'Free';
                                } else {
                                    $shippment_type_pro = 'Paid';
                                }


                                $product_data = [
                                    "orders_id" => $order_id,
                                    "products_id" => $product['product_id'],
                                    "products_name" => $product['product_name'],
                                    "coupon_id" => $product['coupon_id'],
                                    "products_price" => $product['unit_price'],
                                    "products_quantity" => $product['quantity'],
                                    "shippment_type" => $shippment_type_pro,
                                    "final_price" => $product['total_price'],
                                    "product_specifications" => json_encode($product)
                                ];
                            } else {
                                $output["status"] = 0;
                                $output["message"] = "Somthing Wrong !";
                                $this->response($output, REST_Controller::HTTP_OK);
                                exit;
                            }
                        }

                        $firebase_id = get_user_firebase_id($seller_id);
                        $this->Order_model->addOrderProduct($product_data);
                    }
                endforeach;

                $seller_pin = $paddress['pincode'];
                $buyer_pin = $address->postcode;
                //calculate shiiping cost using Ship Rocket
                if ($ship_method == 2) {

                    $ship_rocket_cost = $this->shiprocket->serviceability_for_multiple($seller_pin, $buyer_pin, $max_length, $max_width, $max_height, $tot_weight_sr);

                    if ($ship_rocket_cost['status'] == 200) {
                        $courier_id = $ship_rocket_cost['courier_id'];

                        //$shipping_rate = $ship_rocket_cost['rate'];
                        //$shipping_date_time = $ship_rocket_cost['est_date'];
                        $gst = ($ship_rocket_cost['rate'] * 18 / 100);
                        $ship_cost_subtotal = ($ship_rocket_cost['rate'] - ($ship_rocket_cost['rate'] * 18 / 100));
                        $finalShipping_date = $ship_rocket_cost['est_date'];
                        $ship_status = 1;
                    } else {
                        $output["status"] = 0;
                        $output["message"] = "Order Not Pickable";
                        $this->response($output, REST_Controller::HTTP_OK);
                        exit;
                    }
                }


                //Delete fROM ADD to Cart
                $cart_prod = $this->Product_model->get_orderproduct($order_id);
                foreach ($cart_prod as $row) {
                    $prod_id[] = $row['products_id'];
                }
                $result = $this->Product_model->removeAllProductsOfOrder_id($user_id, $prod_id);


// add gst to shipping cost
                //$gst = $ship_cost_subtotal * (18 / 100);
                $final_shipping_cost = $ship_cost_subtotal + $gst;
                if ($ship_method == 1) {
                    $gst = $ship_cost_subtotal * (18 / 100);
                }
                $dat['shipping_subtotal'] = $ship_cost_subtotal;
                $dat['shipping_gst'] = $gst;
                $dat['shipping_cost'] = $final_shipping_cost;
                //$dat['shipping_cost'] = $shipping_cost;
                if ($chech_shipp->shipping_type == 'Free' && $grand_price >= $chech_shipp->free_amount) {
                    $dat['shippment_type'] = 'Free';
                    $dat['order_price'] = round($grand_price, 2);
                } else {
                    $dat['shippment_type'] = 'Paid';
                    $dat['order_price'] = round($grand_price + $final_shipping_cost, 2);
                }

//update Order
                $this->Common_model->update('orders', $dat, array('orders_id' => $order_id));

                //Insert into Shipping Order
                if ($chech_shipp->shipping_type == 'Free' && $grand_price >= $chech_shipp->free_amount) {
                    $ship_dat['shippment_type'] = 'Free';
                } else {
                    $ship_dat['shippment_type'] = 'Paid';
                }
                $ship_dat['ship_vendor_id'] = $ship_method;
                $ship_dat['orders_id'] = $order_id;
                $ship_dat['delivery_date'] = $finalShipping_date;
                $ship_dat['courier_id'] = $courier_id;
                $ship_dat['shipping_subtotal'] = $ship_cost_subtotal;
                $ship_dat['shipping_gst'] = $gst;
                $ship_dat['shipping_cost'] = $final_shipping_cost;
                $ship_dat['on_amount'] = $chech_shipp->free_amount;
                $ship_dat['pickup_pincode'] = $paddress['pincode'];
                $ship_dat['pick_id'] = $paddress['pick_id'];
                $ship_dat['delivery_pincode'] = $buyer_pin;
                $ship_dat['shippment_type'] = $chech_shipp->shipping_type;
                $ship_dat['length'] = $max_length;
                $ship_dat['breadth'] = $max_width;
                $ship_dat['height'] = $max_height;
                $ship_dat['weight'] = $tot_weight_sr;
                $insert_ship_id = $this->Common_model->insert('order_shipping', $ship_dat);

                //Generate Order if Use Ship Rocket
                if ($ship_method == 2) {
                    $resp = $this->shiprocket->create_order($order_id);
                    if (!empty($resp['order_id'])) {
                        $up_ord['ship_order_id'] = $resp['order_id'];
                        $up_ord['shipment_id'] = $resp['shipment_id'];
                        $this->Common_model->update('order_shipping', $up_ord, array('ship_id' => $insert_ship_id));
                    } else {
                        $this->Common_model->delete('orders', array('orders_id' => $insert_id));
                        $this->Common_model->delete('orders_products', array('orders_id' => $order_id));
                        $this->Common_model->delete('order_shipping', array('orders_id' => $order_id));
                        $this->Common_model->delete('orders_history', array('orders_id' => $order_id));
                        $output["status"] = 1;
                        $output["message"] = "Order Not Pickable";
                        $this->response($output, REST_Controller::HTTP_OK);
                        exit;
                    }
                }

                //add_admin_notification($notification_title, $notification_msg, $notification_type, $reference_id);
                $output["status"] = 1;
                $output["message"] = "Order Requested.";
                $this->response($output, REST_Controller::HTTP_OK);
                // } else {
                // $output["message"] = $check['message'];
                // $this->response($output, REST_Controller::HTTP_OK);
                // }
            }
        }
    }

    public function startMultiProductOrder_IOS_post() {

        $ws = $this->post('ws');

        if (empty($ws)) {
            $ws = "startMultiProductOrder_IOS";
        }

        $output = [
            "ws" => $ws,
            "status" => 0,
            "message" => "Invalid inputs",
        ];
        $this->form_validation->set_rules("products", "Product", "required", array(
            "required" => "invalid inputs"
        ));
        $this->form_validation->set_rules("address", "Address", "required|callback_validAddress", array(
            "required" => "invalid inputs"
        ));
        $this->form_validation->set_rules("grand_price", "Price", "required", array(
            "required" => "invalid inputs"
        ));
        if ($this->form_validation->run() === false) {
            $this->response($output, REST_Controller::HTTP_OK);
        } else {

            $user_id = $this->_payload->userid;
            //$dat=$this->input->post();

            $address = $this->post("address");

            $remark = $this->post("remark");
            $order_from = $this->post("order_from");
            $shipping_method = $this->post("shipping_method");
            $shipping_days = $this->post("shipping_days");
            $shipping_cost = $this->post("shipping_cost");
            $seller_id = $this->post("seller_id");
            $grand_price = $this->post("grand_price");


            $products = $this->post("products");
            //check slases

            if ($products[2] == "\\") {
                $products = json_decode(stripslashes(trim($this->post("products"), '"')), true);
            } else {
                $products = json_decode($this->post("products"));
            }

            //$check = $this->validateProducts($products, $grand_price);
            // exit;
//seller pick address
            $paddress = $this->Common_model->getAll('seller_pick_address', array('user_id' => $seller_id))->row_array();
            // if ($check["status"]) {
            $user = $this->Users_model->getUserById($user_id);
            $address = $this->Users_model->getAddressBookById($address);
            $insertData = [
                "user_id" => $user_id,
                "order_from" => $order_from,
                "user_name" => $user->first_name . " " . $user->last_name,
                "user_street_address" => $address->street,
                "user_suburb" => $address->suburb,
                "user_city" => $address->city,
                "user_postcode" => $address->postcode,
                "user_state" => $address->state,
                "user_country" => $address->country,
                "user_telephone" => $address->contact_number,
                "delivery_name" => $address->contact_person,
                "delivery_name" => $user->first_name . " " . $user->last_name,
                "delivery_street_address" => $address->street,
                "delivery_suburb" => $address->suburb,
                "delivery_city" => $address->city,
                "delivery_postcode" => $address->postcode,
                "delivery_state" => $address->state,
                "delivery_country" => $address->country,
                "pick_name" => $paddress['seller_name'],
                "pick_addr_type" => $paddress['address_type'],
                "pick_country" => $paddress['country'],
                "pick_state" => $paddress['state'],
                "pick_mobile" => $paddress['seller_mobile'],
                "pick_email" => $paddress['seller_email'],
                "pick_pincode" => $paddress['pincode'],
                "pick_days" => 0,
                "ex_shipping_days" => $shipping_days,
                "shipping_cost" => $shipping_cost,
                "seller_id" => $seller_id,
                "shipping_method" => $shipping_method,
                "remark" => $remark,
                "orders_status" => 8,
                "order_price" => $grand_price,
                "orders_date_finished" => date('Y-m-d H:i:s')
            ];


            //Cross Check Coupon Applied
            //$products = json_decode(json_encode($products), True);

            $temp_total_price = 0;
            foreach ($products as $val):

                //check ANDROID PRODUCT RESPONSE OR IOS
                $ch_prod = $this->post("products");
                //check slases
                if ($ch_prod[2] == "\\") {
                    //for IOS 
                    $product_val = $val['products'];
                } else {
                    //for android
                    $product_val = json_decode($val['products'], true);
                }

                foreach ($product_val as $product) {
                    //echo'<pre>';
                    //  print_r($product);
                    //If Coupon Applied Start 
                    $coupon_id = $product['coupon_id'];
                    $temp_total = $product['quantity'] * $product['unit_price'];
                    if ($coupon_id) {
                        $isvalidcoupen = $this->Coupon_model->isCouponAvailableForUser($coupon_id, $product['product_id'], $user_id);
                        if ($isvalidcoupen) {
                            $coupon = $this->Coupon_model->getCoupenById($coupon_id);
                            $temp_total = $product['quantity'] * $product['unit_price'];
                            if ($coupon->discount_type == "flat") {
                                $temp_total_after_coupon = $temp_total - $coupon->coupon_value;

                                $temp_total_price = $temp_total_price + $temp_total_after_coupon;
                            } else {
                                $percentage = ($temp_total * $coupon->coupon_value) / 100;
                                $temp_total_after_coupon = $temp_total - $percentage;
                                $temp_total_price = $temp_total_price + $temp_total_after_coupon;
                            }

                            //Validate
                            if ($product['quantity'] >= $coupon->moq && $temp_total_after_coupon == ($product['total_price'])) {
                                continue;
                            } else {
                                $output["status"] = 0;
                                $output["message"] = "Invalid Coupon Amount Of Product  " . $product['product_name'];
                                $this->response($output, REST_Controller::HTTP_OK);
                                exit;
                            }
                        } else {

                            $output["status"] = 0;
                            $output["message"] = "Invalid Coupon On " . $product['product_name'];
                            $this->response($output, REST_Controller::HTTP_OK);
                            exit;
                        }
                    } else {
                        echo var_dump($temp_total) . " ";
                        $temp_total_price = $temp_total_price + $temp_total;
                    }
                    //Coupon Check End !
                }
            endforeach;
            echo $temp_total_price . "<br />";
            echo $temp_total_price . "<br />";
            if ((float) $temp_total_price != (float) $grand_price) {
                $output["status"] = 0;
                $output["message"] = "Grand Price Not Matching !";
                $output["price1"] = $temp_total_price;
                $output["price2"] = $grand_price;
                $output["product"] = $products;
                $this->response($output, REST_Controller::HTTP_OK);
                exit;
            } else {

                $order_id = $this->Order_model->addOrder($insertData);


                //Inset History
                $orderHistory['orders_id'] = $order_id;
                $orderHistory['status'] = 8;
                $orderHistory['date_added'] = date('Y-m-d H:i:s');
                $orderHistory['comment'] = 'Order Requested !';

                $this->Common_model->insert('orders_history', $orderHistory);


                $output["order_id"] = $order_id;
                $notification_title = 'New Order';
                $notification_msg = 'You have new order on your product waiting for your approval';
                $notification_type = 'Order';
                $reference_id = $order_id;

                $ship_cost_subtotal = 0;
                $tot_quantity = 0;
                $actual_order_price = 0;
                $tot_weight = 0;




                //For Entering Data in Order Products 
                foreach ($products as $val):

                    if ($ch_prod[3] == "\\") {
                        //for IOS 
                        $product_val = $val['products'];
                    } else {
                        //for android
                        $product_val = json_decode($val['products'], true);
                    }

                    // $product_val = json_decode($val['products'], true);

                    foreach ($product_val as $product) {


                        $ch_seller = $this->Common_model->getAll('product_details', array('id' => $product['product_id']))->row();
                        $ch_addr_seller = $this->Common_model->getAll('seller_pick_address', array('user_id' => $seller_id))->row();

                        $tot_weight = $product['quantity'] * $ch_seller->weight;


                        $tot_quantity = $tot_quantity + $product['quantity'];
                        $actual_order_price = $actual_order_price + $product['total_price'];

                        //shipping rate
                        $rate = $this->Shipping_model->get_shipping_rate($order_id, $ch_addr_seller->pick_id, $tot_weight);

                        if ($rate > 0) {
                            $ship_cost = $this->shipping->get_shipping_cost_for_multiple($product_id, $rate, $product['products_quantity'], $tot_weight, $actual_order_price, $pick_id);

                            $ship_cost_subtotal = $ship_cost_subtotal + $ship_cost;
                            if (empty($product['coupon_id'])) {
                                $product['coupon_id'] = 0;
                            }
                            $product_data = [
                                "orders_id" => $order_id,
                                "products_id" => $product['product_id'],
                                "products_name" => $product['product_name'],
                                "coupon_id" => $product['coupon_id'],
                                "products_price" => $product['unit_price'],
                                "products_quantity" => $product['quantity'],
                                "final_price" => $product['total_price'],
                                "product_specifications" => json_encode($product)
                            ];
                        } else {
                            $output["status"] = 0;
                            $output["message"] = "Somthing Wrong !";
                            $this->response($output, REST_Controller::HTTP_OK);
                            exit;
                        }

                        $firebase_id = get_user_firebase_id($seller_id);
                        $this->Order_model->addOrderProduct($product_data);
                    }
                endforeach;

                //Delete fROM ADD to Cart
                $cart_prod = $this->Product_model->get_orderproduct($order_id);
                foreach ($cart_prod as $row) {
                    $prod_id[] = $row['products_id'];
                }
                $result = $this->Product_model->removeAllProductsOfOrder_id($user_id, $prod_id);


// add gst to shipping cost
                $gst = $ship_cost_subtotal * (18 / 100);
                $final_shipping_cost = $ship_cost_subtotal + $gst;

                $dat['shipping_subtotal'] = $ship_cost_subtotal;
                $dat['shipping_gst'] = $gst;

                $dat['shipping_cost'] = $shipping_cost;
                $dat['order_price'] = round($grand_price + $shipping_cost, 2);
//update Order
                $this->Common_model->update('orders', $dat, array('orders_id' => $order_id));

                $output["status"] = 1;
                $output["message"] = "Order Requested.";
                $this->response($output, REST_Controller::HTTP_OK);
            }
        }
    }

    private function validateProducts($products, $grand_price) {
        $output = [
            "status" => true,
            "message" => "Invalid array"
        ];

        $user_id = $this->_payload->userid;
        $calculated_price = 0;
        $products = json_decode(json_encode($products), True);

        foreach ($products as $val):

            $product_val = json_decode($val['products'], true);
            foreach ($product_val as $val) {
// print_r($val);
                $calculated_price = $calculated_price + $val['total_price'];

                if ($val['coupon_id'] != "" && !$this->Coupon_model->isCouponAvailableForUser($val['coupon_id'], $val['product_id'], $user_id)) {
                    $output["status"] = false;
                    $output["message"] = "Invalid coupon for product " . $val->product_name;
                } else if ($val['coupon_id'] != "" && $this->Coupon_model->isCouponAvailableForUser($val['coupon_id'], $val['product_id'], $user_id)) {
                    $coupon = $this->Coupon_model->getCoupenById($val->coupon_id);
                    $temp_total = $val['quantity'] * $val['unit_price'];
                    if ($coupon->discount_type == "flat") {
                        $temp_total_after_coupon = $temp_total - $coupon['coupon_value'];
                    } else {
                        $percentage = ($temp_total * $coupon->coupon_value) / 100;
                        $temp_total_after_coupon = $temp_total - $percentage;
                    }
                    if ($val['quantity'] < $coupon->moq || $temp_total_after_coupon != $val['total_price']) {
                        $output["status"] = false;
                        $output["message"] = "Invalid coupon moq or price for product " . $val['product_name'];
                    }
                }
            }

        endforeach;

        //  echo $grand_price;
        //echo'<br>';
        // echo $calculated_price;

        if ($grand_price != $calculated_price) {
            $grand_price . " " . $calculated_price;
            $output["status"] = false;
            $output["message"] = "Grand Price not matching ";
        }


        return $output;
    }

    function calculate_approx_shipping_rate_post() {
        $ws_temp = $this->post("ws");
        $ws = "calculate_approx_shipping_rate";
        if (isset($ws_temp)) {
            $ws = $ws_temp;
        }
        $output = [
            "status" => 0,
            "message" => "Invalid Inputs",
            "ws" => $ws
        ];

        $this->form_validation->set_rules("product_id", "Product", "required");
        $this->form_validation->set_rules("quantity", "Quantity", "required");
        $this->form_validation->set_rules("pincode", "Pincode", "required");
        if ($this->form_validation->run() === false) {
            $this->response($output, REST_Controller::HTTP_OK);
        } else {
//Pass Value
            $pro_id = $this->post('product_id');
            $quantity = $this->post('quantity');
            $pincode = $this->post('pincode');

            $ship_method = $this->send_data->get_shipping_method();
            //Shipping Address Details
            $chech_shipp = $this->Common_model->getAll('shipping_vendor', array('id' => $ship_method))->row();
            //Check Shipping Status

            $shippment_type = $chech_shipp->shipping_type;
            $free_amount = $chech_shipp->free_amount;


            if ($ship_method == 2) {
                $prod_dat = $this->send_data->get_product_detail($pro_id);
                $paddress = $this->Common_model->getAll('seller_pick_address', array('user_id' => $prod_dat->seller))->row_array();
                $seller_pin = $paddress['pincode'];
                $ship_rocket_cost = $this->shiprocket->serviceability($seller_pin, $pincode, $prod_dat->weight, $prod_dat->length, $pro_dat->width, $prod_dat->height, $quantity);

                if ($ship_rocket_cost['status'] == 200) {

                    $courier_id = $ship_rocket_cost['courier_id'];
                    $shipping_rate = $ship_rocket_cost['rate'];
                    $shipping_subtotal = round(($ship_rocket_cost['rate'] - ($ship_rocket_cost['rate'] * (18 / 100))), 2);
                    $shipping_gst = round(($ship_rocket_cost['rate'] * (18 / 100)), 2);
                    $exp_shipping_date = $ship_rocket_cost['est_date'];

                    $product_weight = $prod_dat->weight * $quantity;
                    $product_length = $prod_dat->length;
                    $product_width = $pro_dat->width;
                    $product_height = $prod_dat->height;
                    $data['weight'] = $product_weight . ' KG';
                    $data['size'] = $product_length . ' x ' . $product_width . ' X ' . $product_height . ' cm';  //(lxbxh)

                    $data['service_provider'] = 'ShipRocket';
                    $data['ship_from'] = '';
                    $data['shipping_days'] = '3-4';
                    $data['shipping_rate'] = $shipping_rate;
                    $data['shippment_type'] = $shippment_type;
                    $data['free_amount'] = sprintf('%.2f', $free_amount);

                    $output["shipping_data"] = $data;
                    $output["status"] = 1;
                    $output["message"] = "Approx Shippping Data";
                } else {
                    $output["status"] = 0;
                    $output["message"] = "Not Deliverable Pincode !";
                }
            } else {
                //get Existing Data
                $ch_exist = $this->Common_model->getAll('product_details', array('id' => $pro_id))->num_rows();
                if ($ch_exist > 0) {
                    // $ch_pincode = $this->Common_model->getAll('shipping_surface', array('pincode' => $pincode,'edl'))->num_rows();

                    $this->db->select('id');
                    $this->db->from('shipping_surface');
                    $this->db->where('pincode', $pincode);
                    $this->db->where('edl!=', 'Y');
                    $ch_pincode = $this->db->get()->num_rows();

                    if ($ch_pincode > 0) {
                        $ch_seller = $this->Common_model->getAll('product_details', array('id' => $pro_id))->row();

                        $seller_id = $ch_seller->seller;
                        $product_weight = $ch_seller->weight;
                        $product_length = $ch_seller->length;
                        $product_width = $ch_seller->width;
                        $product_height = $ch_seller->height;
                        $ship_from = $ch_seller->state;

//get Seller Pincode
                        $ch_seller_pin = $this->Common_model->getAll('seller_pick_address', array('user_id' => $seller_id))->row();

                        if (!empty($ch_seller_pin->pincode)) {
                            $product_rate = $this->Shipping_model->get_qty_wise_product_rate($pro_id, $quantity);
                            $buyer_pin = $pincode;
                            $seller_pin = $ch_seller_pin->pincode;
                            /*                             * ****Calculate Shipping Rate************* */
//$this->calculate_approx_shipping_rate($pro_id,$buyer_pin,$seller_pin,$quantity);
                            $rate = $this->Shipping_model->get_shipping_rate_approx($seller_pin, $buyer_pin);
                            if ($rate <= 0) {
                                $output["status"] = 0;
                                $output["message"] = "Not Deliverable Region !";
                            } else {
                                $actual_order_price = $product_rate * $quantity;
                                $total_weight = $product_weight * $quantity;

                                $price = $total_weight * $rate;

                                $size = (($product_height * $product_length * $product_width )) / 3600;
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

                                if (($actual_order_price / $weight) > 5000) {
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

                                $GST = $sub_total * (18 / 100); //GST

                                $tot_shipping_rate = round($sub_total + $GST, 2);


//approex expected Time
                                $exp_time = $this->shipping->approx_calculate_expected_time($seller_id, $pincode);
//echo "<pre>";
//print_r($exp_time);
//exit;
                                $additional_days = $exp_time['GetDomesticTransitTimeForPinCodeandProductResult']['AdditionalDays'] . ' ' . 'days';

                                $exp_date = $exp_time['GetDomesticTransitTimeForPinCodeandProductResult']['ExpectedDateDelivery'];
                                if ($additional_days) {
                                    $shipping_expected_date = date('Y-m-d', strtotime($exp_date . ' +' . $additional_days . ''));
                                } else {
                                    $shipping_expected_date = date('Y-m-d', strtotime($exp_date));
                                }

                                $pick_date = date('Y-m-d');

                                $date1 = strtotime($pick_date);
                                $date2 = strtotime($shipping_expected_date);
                                $datediff = $date2 - $date1;

                                $shipping_days = abs(round($datediff / (60 * 60 * 24)));

                                $data['weight'] = $product_weight . ' KG';
                                $data['size'] = $product_length . ' x ' . $product_width . ' X ' . $product_height . ' cm';  //(lxbxh)

                                $data['service_provider'] = 'Blue Dart';
                                $data['ship_from'] = $ship_from;
                                $data['shipping_days'] = $shipping_days;
                                $data['shipping_rate'] = $tot_shipping_rate;
                                $data['shippment_type'] = $shippment_type;
                                $data['free_amount'] = sprintf('%.2f', $free_amount);
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
            }

            $this->response($output, REST_Controller::HTTP_OK);
        }
    }

    function track_order_post() {
        $ws_temp = $this->post("ws");
        $ws = "track_order";
        if (isset($ws_temp)) {
            $ws = $ws_temp;
        }
        $output = [
            "status" => 0,
            "message" => "Invalid Inputs",
            "ws" => $ws
        ];

        $this->form_validation->set_rules("order_id", "Order ID", "required");

        if ($this->form_validation->run() === false) {
            $this->response($output, REST_Controller::HTTP_OK);
        } else {

            $order_id = $this->post('order_id');

//Get Latest Tracking Status//
            $this->shipping->latest_tracking_status($order_id);

//get Existing Data
            $ch_exist = $this->Common_model->getAll('orders_history', array('orders_id' => $order_id))->num_rows();
            if ($ch_exist > 0) {
                $hist_dat = $this->Order_model->get_order_status($order_id);

                $output["data"] = $hist_dat;
                $output["status"] = 1;
                $output["message"] = "Order History !";
            } else {
                $output["status"] = 0;
                $output["message"] = "History Not Found !";
            }


            $this->response($output, REST_Controller::HTTP_OK);
        }
    }

    public function calculateMultiProductShippingCost_post() {
        $output = [
            "status" => 0,
            "message" => "Invalid Inputs",
            "ws" => "calculateMultiProductShippingCost"
        ];
        $this->form_validation->set_rules("seller_id", "Seller", "required");
        $this->form_validation->set_rules("products", "Products", "required");
        $this->form_validation->set_rules("pincode", "pincode", "required");
        if ($this->form_validation->run() === false) {
            $this->response($output, REST_Controller::HTTP_OK);
        } else {
            //get Shipping Method
            $ship_method = $this->send_data->get_shipping_method();
            //Shipping Address Details
            $chech_shipp = $this->Common_model->getAll('shipping_vendor', array('id' => $ship_method))->row();
            //Check Shipping Status

            $shippment_type = $chech_shipp->shipping_type;
            $free_amount = $chech_shipp->free_amount;

            $max_length = 0.5;
            $max_height = 0.5;
            $max_width = 0.5;
            $tot_qty = 0;
            $tot_weight = 0;
            $buyer_pin = $this->post("pincode");
            //var_dump($this->post("products"));
            $products = json_decode(stripslashes(trim($this->post("products"), '"')), true);
//            echo "<pre>";
//            print_r($products);
//            exit();
            $seller_id = $this->post("seller_id");
            $shipping_expected_date = date('Y-m-d');
            $finalShipping_date = date('Y-m-d', strtotime($shipping_expected_date . ' +2 day'));
            $shipping_price = 0;
            foreach ($products as $product) {


                //echo "<pre>";
                //print_r($product);
                $product = (object) $product;

                if ($ship_method == 2) {
                    $prod_dat = $this->send_data->get_product_detail($product->product_id);
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
                } else {
                    $result = $this->calculate_shipping_cost($product->product_id, $product->total_quantity, $buyer_pin, $seller_id);
                    $shipping_price = + $result['shipping_data']['shipping_rate'];
                    if ($finalShipping_date > $result['shipping_data']['shipping_date_time']) {
                        $finalShipping_date = $result['shipping_data']['shipping_date_time'];
                    }
                }
            }

            //calculate shiiping cost using Ship Rocket
            if ($ship_method == 2) {
                $paddress = $this->Common_model->getAll('seller_pick_address', array('user_id' => $seller_id))->row_array();
                $seller_pin = $paddress['pincode'];
                $ship_rocket_cost = $this->shiprocket->serviceability_for_multiple($seller_pin, $buyer_pin, $max_length, $max_width, $max_height, $tot_weight);

                if ($ship_rocket_cost['status'] == 200) {
                    $courier_id = $ship_rocket_cost['courier_id'];

                    //$shipping_rate = $ship_rocket_cost['rate'];
                    //$shipping_date_time = $ship_rocket_cost['est_date'];
                    $shipping_price = $ship_rocket_cost['rate'];
                    $finalShipping_date = $ship_rocket_cost['est_date'];
                    $ship_status = 1;
                }
            }


            //echo $finalShipping_date;
            //Shipping Days
            //Days Difference between pick up and delivery date
            $pick_date = date('Y-m-d');
            $date1 = strtotime($pick_date);
            $date2 = strtotime($finalShipping_date);
            $datediff = $date2 - $date1;

            $ship_days = abs(round($datediff / (60 * 60 * 24)));
            if ($ship_method == 2) {
                $ship_days = '3-4';
            }
            $data["shipping_cost"] = $shipping_price;
            $data["shipping_days"] = $ship_days;
            $data['shippment_type'] = $shippment_type;
            $data['free_amount'] = sprintf('%.2f', $free_amount);
            $output["shipping_data"] = $data;
            $output["status"] = 1;
            $output["message"] = "Success";
            $this->response($output, REST_Controller::HTTP_OK);
        }
    }

    function remove_pending_order_post() {
        $ws_temp = $this->post("ws");
        $ws = "remove_pending_order";
        if (isset($ws_temp)) {
            $ws = $ws_temp;
        }
        $output = [
            "status" => 0,
            "message" => "Invalid Inputs",
            "ws" => $ws
        ];

        $this->form_validation->set_rules("order_id", "Order ID", "required");

        if ($this->form_validation->run() === false) {
            $this->response($output, REST_Controller::HTTP_OK);
        } else {

            $order_id = $this->post('order_id');


            $ord = $this->Myorders_model->single_order($order_id);
            if ($ord && $ord["orders_status"] == 8) {
                $this->Myorders_model->remove_order($order_id);
                $this->Myorders_model->remove_order_products($order_id);
                $this->Myorders_model->remove_order_history($order_id);

                $output["status"] = 1;
                $output["message"] = "Removed Successfully";
            } else {
                $output["status"] = 0;
                $output["message"] = "Wrong Data !";
            }

            $this->response($output, REST_Controller::HTTP_OK);
        }
    }

    public function test_get() {
        $var = 541.2;
        $number = sprintf('%.2f', $var);
        echo $number;
    }

    private function calculate_shipping_cost($product_id, $quantity, $user_pincode, $seller_id) {
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

                //get Seller Pincode
                $ch_seller_pin = $this->Common_model->getAll('seller_pick_address', array('user_id' => $seller_id))->row();
                if ($ch_seller_pin) {
                    $buyer_pin = $user_pincode;
                    $seller_pin = $ch_seller_pin->pincode;

                    $product_rate = $this->Shipping_model->get_qty_wise_product_rate($product_id, $quantity);

                    /*                     * ****Calculate Shipping Rate************* */
                    //$this->calculate_approx_shipping_rate($pro_id,$buyer_pin,$seller_pin,$quantity);
                    $rate = $this->Shipping_model->get_shipping_rate_approx($seller_pin, $buyer_pin);
                    if ($rate <= 0) {
                        $output["status"] = 0;
                        $output["message"] = "Not Deliverable Region !";
                    } else {
                        $total_weight = $product_weight * $quantity;
                        $actual_order_price = $product_rate * $quantity;

                        /////////////////
                        $price = $total_weight * $rate; //As Weight


                        $size = (($product_height * $product_lenght * $product_width )) / 3600;
                        $size = $size * $quantity;

                        $price2 = $size * $rate; //As Length * width * Height

                        $Freight = ($price > $price2) ? $price : $price2;


////////////////


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
                        $exp_time = $this->shipping->approx_calculate_expected_time($seller_id, $buyer_pin);


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

    function order_placed_notify($order_id = 0) {


        $this->load->library("Browser_notification");

        //Get Data
        $this->db->select('a.orders_id,a.user_name,a.user_id,a.user_telephone,a.seller_id,b.firebase_id as buyer_firbase,c.firebase_id as seller_firebase');
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
        $seller_firebase = $query->seller_firebase;

        $msg = " From " . $user_name;
        $tag = 'Against Order ORD' . $order_id;


        $cr_date = date('d M Y');
        $message_for_buyer = 'Order (ORD' . $order_id . ') Placed Successfully ! Thank you for truly appreciating ATZCart.com products. Track Your Order !';
        $message_for_sms = 'Order (ORD' . $order_id . ') Placed Successfully ! Thank you for truly appreciating ATZCart.com products. We are really delightful to serve you the products on your doorstep. Keep track of your product using below given link <a href="atzcart.com">ATZ Cart</a>. Write us on our helpline if you have any queries related to product or supplier or delivery.';


        //To Buyer
        if (!empty($buyer_firbase)) {
            $type = "Order";
            $type_id = $order_id;
            $this->browser_notification->notify_buyer('Order Placed Successfully', $message_for_buyer, $buyer_firbase, $type, $type_id);
        }

        //To Seller
        if (!empty($seller_firebase)) {
            $seller_id = $seller_id;
            $title = 'New Order';


            $this->browser_notification->notifyseller($seller_id, $title, $msg, $tag);
        }

        if (!empty($user_phone)) {
            $this->send_data->send_sms($message_for_sms, $user_phone);
        }

        $this->browser_notification->notifyadmin('New Order Placed !', $msg, $tag);
    }

    function order_cancel_notify($order_id = 0, $cancel) {


        $this->load->library("Browser_notification");

        //Get Data
        $this->db->select('a.orders_id,a.user_name,a.user_id,a.user_telephone,a.seller_id,b.firebase_id as buyer_firbase,c.firebase_id as seller_firebase');
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
        $seller_firebase = $query->seller_firebase;

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
            $msg = 'Order #ORD' . $order_id . ' Cancelled Successfully ! Amount has been added to Your wallet';
            $mob = $this->session->userdata("phone");
            $this->send_data->send_sms($msg, $user_phone);

            //Notify To Seller
            $title = 'Order Cancelled';
            $msg = "Order #ORD" . $order_id . " By Buyer " . $user_name . ' ! Order Amount has been added to Your wallet';
            $tag = 'atzcart.com';
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
            $msg = 'Order #ORD' . $order_id . ' Cancel Request Sent Successfully ! ';
            $this->send_data->send_sms($msg, $user_phone);

            $title = 'New Order Cancel Request';
            $msg = "Order #ORD" . $order_id . " By Buyer " . $user_name;
            $tag = date('d M Y');
            $this->browser_notification->notifyseller($seller_id, $title, $msg, $tag);

            //To Buyer
            if (!empty($buyer_firbase)) {
                $type = "Cancel";
                $this->browser_notification->notify_buyer('Order Cancel Request !', $msg, $buyer_firbase, $type, $type_id = '');
            }


            $msg = 'Order Cancel Request from Buyer ' . $user_name;
            $tag = date('d M Y');
            $this->browser_notification->notifyadmin('Order Cancelled!', $msg, $tag);
        }
    }

    function order_return_notify($order_id = 0) {


        $this->load->library("Browser_notification");

        //Get Data
        $this->db->select('a.orders_id,a.user_name,a.user_id,a.user_telephone,a.seller_id,b.firebase_id as buyer_firbase,c.firebase_id as seller_firebase');
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
        $seller_firebase = $query->seller_firebase;


        //Send SMS to Customer
        $msg = 'Order Return Request Sent Successfully of Order #ORD' . $order_id . '';
        $mob = $user->phone;
        $this->send_data->send_sms($msg, $user_phone);

        //Notify To Seller
        $title = 'Order Return Request';
        $msg = "Order Return Request of  #ORD" . $order_id . " By Buyer " . $user_name;
        $tag = '';
        $this->browser_notification->notifyseller($seller_id, $title, $msg, $tag);

        //To Buyer
        if (!empty($buyer_firbase)) {
            $msg = "Order Return Request Sent Successfully of  #ORD" . $order_id;
            $type = "Return";
            $this->browser_notification->notify_buyer('Order Return Request !', $msg, $buyer_firbase, $type, $type_id = '');
        }


        $msg = 'Order Return Request by  Buyer ' . $user_name;
        $tag = date('d M Y');
        $this->browser_notification->notifyadmin('Order Return Request!', $msg, $tag);

        //insert in adminnotify table
        $msg = 'Return Order Request from ' . $user_name . ' of Order #ORD' . $order_id;
        $msg_buyer = "Return Order Request of order #ORD" . $order_id;
        $adminNotify = array(
            'title' => 'Order Return Request',
            'msg' => $msg . ' ( App ) ',
            'type' => 'order_return',
            'reference_id' => $order_id,
            'status' => 'Received'
        );

        $buyerNotify = array(
            'title' => 'Order Return Request',
            'msg' => $msg_buyer,
            'user_id' => $user_id,
            'type' => 'order_return',
            'reference_id' => $order_id,
            'status' => 'Received'
        );

        $this->Product_model->insertAdminNotify($adminNotify);
        $this->Product_model->insertBuyerNotify($buyerNotify);
    }

    function order_waiting_notify($order_id = 0) {


        $this->load->library("Browser_notification");

        //Get Data
        $this->db->select('a.orders_id,a.user_name,a.user_id,a.user_telephone,a.seller_id,b.firebase_id as buyer_firbase,c.firebase_id as seller_firebase');
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
        $seller_firebase = $query->seller_firebase;


        //Send SMS to Customer
        $msg = 'Order #ORD' . $order_id . ' Waiting ! Any Enquiry Contact to Support ! atzcart.com';
        $mob = $user->phone;
        $this->send_data->send_sms($msg, $user_phone);


        //To Buyer
        if (!empty($buyer_firbase)) {
            $msg = "Order #ORD" . $order_id . " Waiting";
            $type = "Waiting";
            $this->browser_notification->notify_buyer('Order Return Request !', $msg, $buyer_firbase, $type, $type_id = '');
        }


        $msg = 'Order #ORD' . $order_id . ' Waiting Of User ' . $user_name;
        $tag = date('d M Y');
        $this->browser_notification->notifyadmin('Order In Waiting!', $msg, $tag);
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

    function csss_get() {
        $ship_rocket_cost = $this->shiprocket->return_serviceability_for_multiple(20129653);

        print_r($ship_rocket_cost);
    }

    function check_returnable_post() {
        $ws_temp = $this->post("ws");
        $ws = "check_returnable";
        if (isset($ws_temp)) {
            $ws = $ws_temp;
        }
        $output = [
            "status" => 0,
            "message" => "Invalid Inputs",
            "ws" => $ws
        ];

        $this->form_validation->set_rules("prod_id", "Product id", "required");
        $this->form_validation->set_rules("pin_id", "Book ID", "required");

        if ($this->form_validation->run() === false) {
            $this->response($output, REST_Controller::HTTP_OK);
        } else {
            $prod_id = $this->input->post('prod_id');
            $book_id = $this->input->post('pin_id');
            $this->db->select('postcode');
            $this->db->from('address_book');
            $this->db->where('address_book_id', $book_id);
            $pincode_q = $this->db->get()->row();
            $pincode = $pincode_q->postcode;
            //check in shipping
            $ch_seller = $this->Common_model->getAll('product_details', array('id' => $prod_id, 'is_product_returnable' => 'Yes'))->num_rows();
            $ch_pin = $this->Common_model->getAll('shiprocket_pincode', array('pincode' => $pincode, 'reverse' => 'TRUE'))->num_rows();
            if ($ch_seller != 0 && $ch_pin != 0) {
                $output["status"] = 1;
                $output["message"] = "This Order is Returnable at " . $pincode . " Pincode.";
            } else {
                $output["status"] = 1;
                $output["message"] = "This Order is Not Returnable at " . $pincode . " Pincode.";
            }
        }

        $this->response($output, REST_Controller::HTTP_OK);
    }

}
