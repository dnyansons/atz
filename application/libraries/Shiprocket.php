<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Shiprocket {

    private $CI;

    function __construct() {
        $this->CI = get_instance();
        $this->CI->load->model('Common_model');
        $this->CI->load->model('Order_model');
        $this->CI->load->model('Shipping_model');
        $this->CI->load->model('Categories_model');
        $this->CI->load->model('Product_model');
        $this->CI->load->library('Send_data');
    }

    function index() {
        echo '<div style="border:2px solid pink;padding:5px;text-align:left;padding-left:150px;"><h1><u>Ship Rocket</u></h1>';
        echo'1.Generate the token using the Authentication API (/v1/external/auth/login).
<br>2.Authenticate the API’s by passing the token in the headers of each request as ‘Authorization: Bearer token_value’.
<br>3.Create an Order using the Create Custom Order API (/v1/external/orders/create/adhoc).
<br>4.Assign AWB using AWB creation API (/v1/external/courier/assign/awb).
<br>5.Request for PickUp using the Request PickUp API (/v1/external/courier/generate/pickup).
<br>6.Track your shipment using Tracking API (/v1/external/track/awb/{awb_code}).';
        echo'</div>';
    }

    function auth_login() {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://apiv2.shiprocket.in/v1/external/auth/login");
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Accept:application/json',
            'Content-Type: application/x-www-form-urlencoded',
            'X-Application:rdMU1CEPHcoM8p5C'
        ));
        //Credential
        $postData = 'email=admin@atzcart.com&password=atz@123456';
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
        $auth = json_decode(curl_exec($ch), TRUE);
        curl_close($ch);
        //$_SESSION['auth_token']=$response['token'];
        return $auth['token'];
    }

    function serviceability($pickup, $delivery, $pweight, $plength, $pbreadth, $pheight, $quantity) {
        //Generate Token
        $auth_token = $this->auth_login();

        //Parameter Required
        $pickup_postcode = $pickup;
        $delivery_postcode = $delivery;

        $weight = $pweight * $quantity;
        $length = $plength / 100; //Meters 50 cm
        $breadth = $pbreadth / 100; //Meters
        $height = $pheight / 100; //Meters
        $cod = 0; //Required Cash :: Delivery =1, Prepaid =0
        // $order_id = 18473033; //(Optional)
        $declared_value = 1; //Price of Order
        $mode = 'Surface';  //Surface/Air
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://apiv2.shiprocket.in/v1/external/courier/serviceability?pickup_postcode=$pickup_postcode&delivery_postcode=$delivery_postcode&weight=$weight&cod=$cod&mode=$mode");
        //curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Accept:application/json',
            'Content-Type: application/x-www-form-urlencoded',
            'X-Application:rdMU1CEPHcoM8p5C',
            'Authorization:Bearer' . $auth_token
        ));
        $response = json_decode(curl_exec($ch), TRUE);
        curl_close($ch);
        // echo'<pre>';
        //print_r($response);

        $res['status'] = $response['status'];
        $res['courier_id'] = $response['data']['shiprocket_recommended_courier_id'];
        $res['rate'] = $response['data']['available_courier_companies'][0]['rate'];
        $res['est_date'] = date('Y-m-d', strtotime($response['data']['available_courier_companies'][0]['etd']));
        return $res;
    }

    function serviceability_for_multiple($pickup, $delivery, $plength, $pbreadth, $pheight, $tot_weight) {
        //Generate Token
        $auth_token = $this->auth_login();

        //Parameter Required
        $pickup_postcode = $pickup;
        $delivery_postcode = $delivery;

        $weight = $tot_weight;
        $length = $plength / 100; //Meters 50 cm
        $breadth = $pbreadth / 100; //Meters
        $height = $pheight / 100; //Meters
        $cod = 0; //Required Cash :: Delivery =1, Prepaid =0
        // $order_id = 18473033; //(Optional)
        $declared_value = 1; //Price of Order
        $mode = 'Surface';  //Surface/Air
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://apiv2.shiprocket.in/v1/external/courier/serviceability?pickup_postcode=$pickup_postcode&delivery_postcode=$delivery_postcode&weight=$weight&cod=$cod&mode=$mode");
        //curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Accept:application/json',
            'Content-Type: application/x-www-form-urlencoded',
            'X-Application:rdMU1CEPHcoM8p5C',
            'Authorization:Bearer' . $auth_token
        ));
        $response = json_decode(curl_exec($ch), TRUE);
        curl_close($ch);
        // echo'<pre>';
        //print_r($response);

        $res['status'] = $response['status'];
        $res['courier_id'] = $response['data']['shiprocket_recommended_courier_id'];
        $res['rate'] = $response['data']['available_courier_companies'][0]['rate'];
        $res['est_date'] = date('Y-m-d', strtotime($response['data']['available_courier_companies'][0]['etd']));
        return $res;
    }

    function return_serviceability_for_multiple($order_id) {
        //Generate Token
        $auth_token = $this->auth_login();
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://apiv2.shiprocket.in/v1/external/courier/serviceability?order_id=$order_id");
        //curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Accept:application/json',
            'Content-Type: application/x-www-form-urlencoded',
            'X-Application:rdMU1CEPHcoM8p5C',
            'Authorization:Bearer' . $auth_token
        ));
        $response = json_decode(curl_exec($ch), TRUE);
        curl_close($ch);
        
        $res['status'] = $response['status'];
        $res['courier_id'] = $response['data']['shiprocket_recommended_courier_id'];
        $res['rate'] = $response['data']['available_courier_companies'][0]['rate'];
        $res['est_date'] = date('Y-m-d', strtotime($response['data']['available_courier_companies'][0]['etd']));
        return $res;
    }

    function create_order($ord_id = 0) {
        //Generate Token
        $addr = $this->CI->Common_model->getAll('orders', array('orders_id' => $ord_id))->row();
        $ship = $this->CI->Common_model->getAll('order_shipping', array('orders_id' => $ord_id))->row();
        $order_pro = $this->CI->Common_model->getAll('orders_products', array('orders_id' => $ord_id))->result();

        //Check Pickup Location
        $check_pick = $this->check_pickupaddress($ship->pick_id);
        if ($check_pick == true) {
           $pick = 'TP' . $ship->pick_id;
            ///check shipping
            if ($addr->shippment_type == 'Paid') {
                $shipping_cost = $addr->shipping_cost;
                $order_price = round($addr->order_price - $addr->shipping_cost, 2);
            } else {
                $shipping_cost = '0.00';
                $order_price = round($addr->order_price, 2);
            }

            if ($ship->length <= 0.5) {
                $length = 0.5;
            } else {
                $length = $ship->length;
            }
            if ($ship->breadth <= 0.5) {
                $breadth = 0.5;
            } else {
                $breadth = $ship->breadth;
            }
            if ($ship->height <= 0.5) {
                $height = 0.5;
            } else {
                $height = $ship->height;
            }
            $weight = $ship->weight;

            foreach ($order_pro as $value) {
                $pro[] = array(
                    'name' => $value->products_name,
                    'sku' => 'ATZ0' . $value->orders_products_id, //It Can not be repeated
                    'units' => $value->products_quantity,
                    'selling_price' => $value->products_price,
                    'discount' => '0.00',
                    'tax' => '0.00',
                    'hsn' => '0'
                );
            }

            $auth_token = $this->auth_login();
            if (!empty($addr)) {
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, "https://apiv2.shiprocket.in/v1/external/orders/create/adhoc");
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                    'Accept:application/json',
                    'Content-Type: application/json',
                    'X-Application:rdMU1CEPHcoM8p5C',
                    'Authorization:Bearer' . $auth_token
                ));
                //Credential
                $postData = json_encode(array(
                    'order_id' => 'TD' . $ord_id, //test demo
                    'order_date' => date('Y-m-d H:i'),
                    'pickup_location' => $pick,
                    'channel_id' => '',
                    'comment' => 'Reseller:' . $addr->pick_name,
                    'billing_customer_name' => $addr->delivery_name,
                    'billing_last_name' => ' ',
                    'billing_address' => $addr->delivery_street_address,
                    'billing_address_2' => ' ',
                    'billing_city' => $addr->delivery_city,
                    'billing_pincode' => $addr->delivery_postcode,
                    'billing_state' => $addr->user_state,
                    'billing_country' => 'India',
                    'billing_email' => $addr->user_email_address,
                    'billing_phone' => $addr->user_telephone,
                    'shipping_is_billing' => true,
                    'shipping_customer_name' => '',
                    'shipping_last_name' => '',
                    'shipping_address' => '',
                    'shipping_address_2' => '',
                    'shipping_city' => '',
                    'shipping_pincode' => '',
                    'shipping_country' => '',
                    'shipping_state' => '',
                    'shipping_email' => '',
                    'shipping_phone' => '',
                    'order_items' => $pro,
                    'payment_method' => 'Prepaid', //( Prepaid / COD )
                    'shipping_charges' => $shipping_cost,
                    'giftwrap_charges' => 0,
                    'transaction_charges' => 0,
                    'total_discount' => 0,
                    'sub_total' => round($order_price, 2),
                    /* the length must be greater than or equal to 0.5.
                      The breadth must be greater than or equal to 0.5.
                      The height must be greater than or equal to 0.5. */
                    'length' => $length,
                    'breadth' => $breadth,
                    'height' => $height,
                    'weight' => $weight,
                ));

                curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
                $response = json_decode(curl_exec($ch), TRUE);
                //echo'<pre>';
               // print_r($response);
                curl_close($ch);

                return $response;
            } else {
                return 0;
            }
        } else {
            return 0;
        }
    }

    //return Order
    function return_create_order_new($rord_id, $ord_id) {

        //Generate Token
        $addr = $this->CI->Common_model->getAll('return_orders', array('return_orders_id' => $rord_id))->row();
        $ship = $this->CI->Common_model->getAll('order_shipping', array('orders_id' => $ord_id))->row();
        $rship = $this->CI->Common_model->getAll('return_order_shipping', array('return_orders_id' => $rord_id))->row();
        $order_pro = $this->CI->Common_model->getAll('return_orders_products', array('return_orders_id' => $rord_id))->result();

        $shipping_cost = $addr->shipping_cost;
        $order_price = round($addr->order_price - $addr->shipping_cost, 2);

        //get channel ID
        $channel_id = $this->get_order_detail($ship->ship_order_id);



        //Check Pickup Location
        $rpostData = json_encode(array(
            'pickup_location' => 'RTP' . $rord_id,
            'name' => $addr->pick_name,
            'email' => $addr->pick_email,
            'phone' => $addr->pick_mobile,
            'address' => $addr->pick_addr_type,
            'address_2' => '---',
            'city' => '-',
            'state' => $addr->pick_state,
            'country' => 'India',
            'pin_code' => $addr->pick_pincode,
            'is_return' => 1,
        ));

        $check_pick = $this->check_pickupaddress_for_return($rord_id, $rpostData);

        if ($check_pick > 0) {

            if ($rship->length <= 0.5) {
                $length = 0.5;
            } else {
                $length = $rship->length;
            }
            if ($rship->breadth <= 0.5) {
                $breadth = 0.5;
            } else {
                $breadth = $rship->breadth;
            }
            if ($rship->height <= 0.5) {
                $height = 0.5;
            } else {
                $height = $rship->height;
            }
            $weight = $rship->weight;

            foreach ($order_pro as $value) {
                $pro[] = array(
                    'name' => $value->products_name,
                    'sku' => 'RETATZ0' . $value->orders_products_id, //It Can not be repeated
                    'units' => $value->products_quantity,
                    'selling_price' => $value->products_price,
                    'discount' => '0.00',
                    'tax' => '0.00',
                    'hsn' => '0'
                );
            }

//Generate Token

            $auth_token = $this->auth_login();
            if (!empty($addr)) {
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, "https://apiv2.shiprocket.in/v1/external/orders/create/return");
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                    'Accept:application/json',
                    'Content-Type: application/json',
                    'X-Application:rdMU1CEPHcoM8p5C',
                    'Authorization:Bearer' . $auth_token
                ));
                //Credential
                $postData = json_encode(array(
                    "order_id" => "rDemo" . $rord_id,
                    "order_date" => date('Y-m-d'),
                    "channel_id" => $channel_id, //Cumpulsory
                    "pickup_customer_name" => $addr->pick_name,
                    "pickup_last_name" => " ",
                    "pickup_address" => $addr->pick_addr_type,
                    "pickup_address_2" => "---",
                    "pickup_city" => "---",
                    "pickup_state" => $addr->pick_state,
                    "pickup_country" => "India",
                    "pickup_pincode" => $addr->pick_pincode,
                    "pickup_email" => $addr->pick_email,
                    "pickup_phone" => $addr->pick_mobile,
                    "pickup_isd_code" => "",
                    "pickup_location_id" => $check_pick, //Pick up Location ID
                    "shipping_customer_name" => $addr->delivery_name,
                    "shipping_last_name" => "-",
                    "shipping_address" => $addr->delivery_street_address,
                    "shipping_address_2" => $addr->delivery_city,
                    "shipping_city" => "---",
                    "shipping_country" => "India",
                    "shipping_pincode" => $addr->delivery_postcode,
                    "shipping_state" => "ggg",
                    "shipping_email" => $addr->delivery_email_address,
                    "shipping_isd_code" => "",
                    "shipping_phone" => $addr->user_telephone,
                    "order_items" => $pro,
                    "payment_method" => "Prepaid",
                    "total_discount" => "0.00",
                    "sub_total" => $order_price,
                    "length" => $length,
                    "breadth" => $breadth,
                    "height" => $height,
                    "weight" => $weight,
                ));

                curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
                $response = json_decode(curl_exec($ch), TRUE);
                curl_close($ch);

                return $response;
            } else {
                return 0;
            }
        } else {
            return 0;
        }
    }

    function return_create_order($ord_id = 0) {
        //Generate Token
        $addr = $this->CI->Common_model->getAll('return_orders', array('return_orders_id' => $ord_id))->row();
        $ship = $this->CI->Common_model->getAll('return_order_shipping', array('return_orders_id' => $ord_id))->row();
        $order_pro = $this->CI->Common_model->getAll('return_orders_products', array('return_orders_id' => $ord_id))->result();

        ///check shipping
        // if ($addr->shippment_type == 'Paid') {
        $shipping_cost = $addr->shipping_cost;
        $order_price = round($addr->order_price - $addr->shipping_cost, 2);
        //} else {
        // $shipping_cost = '0.00';
        // $order_price = round($addr->order_price, 2); 
        // }
        //Check Pickup Location
        $rpostData = json_encode(array(
            'pickup_location' => 'RDEM' . $ord_id,
            'name' => $addr->pick_name,
            'email' => $addr->pick_email,
            'phone' => $addr->pick_mobile,
            'address' => $addr->pick_addr_type,
            'address_2' => '---',
            'city' => '-',
            'state' => $addr->pick_state,
            'country' => 'India',
            'pin_code' => $addr->delivery_postcode,
        ));

        $check_pick = $this->check_pickupaddress_for_return($ord_id, $rpostData); 

        if ($check_pick == true) {

            if ($ship->length <= 0.5) {
                $length = 0.5;
            } else {
                $length = $ship->length;
            }
            if ($ship->breadth <= 0.5) {
                $breadth = 0.5;
            } else {
                $breadth = $ship->breadth;
            }
            if ($ship->height <= 0.5) {
                $height = 0.5;
            } else {
                $height = $ship->height;
            }
            $weight = $ship->weight;

            foreach ($order_pro as $value) {
                $pro[] = array(
                    'name' => $value->products_name,
                    'sku' => 'RETATZ0' . $value->orders_products_id, //It Can not be repeated
                    'units' => $value->products_quantity,
                    'selling_price' => $value->products_price,
                    'discount' => '0.00',
                    'tax' => '0.00',
                    'hsn' => '0'
                );
            }

            $auth_token = $this->auth_login();
            if (!empty($addr)) {
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, "https://apiv2.shiprocket.in/v1/external/orders/create/adhoc");
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                    'Accept:application/json',
                    'Content-Type: application/json',
                    'X-Application:rdMU1CEPHcoM8p5C',
                    'Authorization:Bearer' . $auth_token
                ));
                //Credential
                $postData = json_encode(array(
                    'order_id' => 'r_ORD' . $ord_id,
                    'order_date' => date('Y-m-d H:i'),
                    'pickup_location' => 'RDEM' . $ord_id,
                    'channel_id' => '',
                    'comment' => 'Customer:' . $addr->pick_name,
                    'billing_customer_name' => $addr->delivery_name,
                    'billing_last_name' => ' ',
                    'billing_address' => $addr->pick_addr_type,
                    'billing_address_2' => $addr->delivery_street_address,
                    'billing_city' => $addr->delivery_city,
                    'billing_pincode' => $addr->delivery_postcode,
                    'billing_state' => $addr->delivery_state,
                    'billing_country' => 'India',
                    'billing_email' => $addr->delivery_email_address,
                    'billing_phone' => $addr->user_telephone,
                    'shipping_is_billing' => true,
                    'shipping_customer_name' => '',
                    'shipping_last_name' => '',
                    'shipping_address' => '',
                    'shipping_address_2' => '',
                    'shipping_city' => '',
                    'shipping_pincode' => '',
                    'shipping_country' => '',
                    'shipping_state' => '',
                    'shipping_email' => '',
                    'shipping_phone' => '',
                    'order_items' => $pro,
                    'payment_method' => 'Prepaid', //( Prepaid / COD )
                    'shipping_charges' => $shipping_cost,
                    'giftwrap_charges' => 0,
                    'transaction_charges' => 0,
                    'total_discount' => 0,
                    'sub_total' => round($order_price, 2),
                    /* the length must be greater than or equal to 0.5.
                      The breadth must be greater than or equal to 0.5.
                      The height must be greater than or equal to 0.5. */
                    'length' => $length,
                    'breadth' => $breadth,
                    'height' => $height,
                    'weight' => $weight,
                ));

                curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
                $response = json_decode(curl_exec($ch), TRUE);
                curl_close($ch);
                return $response;
            } else {
                return 0;
            }
        } else {
            return 0;
        }
    }

    function add_new_pickup($postData) {

        //Generate Token
        $auth_token = $this->auth_login();

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://apiv2.shiprocket.in/v1/external/settings/company/addpickup");
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Accept:application/json',
            'Content-Type: application/json',
            'X-Application:rdMU1CEPHcoM8p5C',
            'Authorization:Bearer' . $auth_token
        ));
        //Credential
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
        $response = json_decode(curl_exec($ch), TRUE);
        curl_close($ch);
        //echo'<pre>';
        //print_r($response);
         //exit;
        return $response['success'];
    }
    
    
    function add_new_pickup_for_return($postData) {

        //Generate Token
        $auth_token = $this->auth_login();

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://apiv2.shiprocket.in/v1/external/settings/company/addpickup");
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Accept:application/json',
            'Content-Type: application/json',
            'X-Application:rdMU1CEPHcoM8p5C',
            'Authorization:Bearer' . $auth_token
        ));
        //Credential
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
        $response = json_decode(curl_exec($ch), TRUE);
        curl_close($ch);
        // echo'<pre>';
        // print_r($response);
        // exit;
        return $response['address']['id'];
    }

    function check_pickupaddress($pickid) {

        $auth_token = $this->auth_login();
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://apiv2.shiprocket.in/v1/external/settings/company/pickup");
        //curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Accept:application/json',
            'Content-Type: application/x-www-form-urlencoded',
            'X-Application:rdMU1CEPHcoM8p5C',
            'Authorization:Bearer' . $auth_token
        ));
        $response = json_decode(curl_exec($ch), TRUE);
        
        $pickupAddress = $response["data"]["shipping_address"];
        curl_close($ch);

        $pickupId = 'TP' . $pickid;
        $result = array_filter($pickupAddress, function ($item) use ($pickupId) {
            if ($item['pickup_location'] == $pickupId) {
                return true;
            }
            return false;
        });

        if ($result) {
            return true;
        } else {
            $this->CI->load->model("pickaddress_model");
            $address = $this->CI->pickaddress_model->getaddress($pickid);
            if (empty($address['city'])) {
                $city = 'Pune';//Compulsory city Required
            } else {
                $city = $address['city'];
            }
            if ($address) {
                if(empty($address["address2"]))
                {
                    $addr2='---';
                }
                else{
                    $addr2='---'.$address["address2"];
                }
                $postData = json_encode(array(
                    'pickup_location' => 'TP' . $address["pick_id"],
                    'name' => $address["seller_name"],
                    'email' => $address["seller_email"],
                    'phone' => $address["seller_mobile"],
                    'address' => $address["address"],
                    'address_2' => $addr2,
                    'city' => $city,
                    'state' => $address["state"],
                    'country' => 'India',
                    'pin_code' => $address["pincode"],
                ));

                $res = $this->add_new_pickup($postData);
                if ($res == 1) {
                    return true;
                } else {
                    return false;
                }
            } else {
                return false;
            }
        }
    }

    function check_pickupaddress_for_return($pickid, $rpostData) {

        $auth_token = $this->auth_login();
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://apiv2.shiprocket.in/v1/external/settings/company/pickup");
        //curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Accept:application/json',
            'Content-Type: application/x-www-form-urlencoded',
            'X-Application:rdMU1CEPHcoM8p5C',
            'Authorization:Bearer' . $auth_token
        ));
        $response = json_decode(curl_exec($ch), TRUE);
        $pickupAddress = $response["data"]["shipping_address"];
        curl_close($ch);

        $pickupId = 'RTP' . $pickid;
        $result = array_filter($pickupAddress, function ($item) use ($pickupId) {
            if ($item['pickup_location'] == $pickupId) {
                return $item['id'];
                //return true;
            }
            return false;
        });

        if ($result) {
            return true;
        } else {
            $res = $this->add_new_pickup_for_return($rpostData);
            if ($res > 0) {
                return $res;
            } else {
                return false;
            }
        }
    }

    function awb_creation($postData) {
        //Generate Token

        $auth_token = $this->auth_login();
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://apiv2.shiprocket.in/v1/external/courier/assign/awb");
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Accept:application/json',
            'Content-Type: application/json',
            //Content-Type: application/x-www-form-urlencoded',
            'X-Application:rdMU1CEPHcoM8p5C',
            'Authorization:Bearer' . $auth_token
        ));
        
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
        $response = json_decode(curl_exec($ch), TRUE);
        curl_close($ch);
        return $response;
    }

    function pickup_request($postData) {
        //Generate Token

        $auth_token = $this->auth_login();
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://apiv2.shiprocket.in/v1/external/courier/generate/pickup");
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Accept:application/json',
            'Content-Type: application/json',
            //Content-Type: application/x-www-form-urlencoded',
            'X-Application:rdMU1CEPHcoM8p5C',
            'Authorization:Bearer' . $auth_token
        ));

        curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
        $response = json_decode(curl_exec($ch), TRUE);
        curl_close($ch);
        return $response;
    }

    function cancel_order($postData) {
        //Generate Token
        $auth_token = $this->auth_login();
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://apiv2.shiprocket.in/v1/external/orders/cancel");
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Accept:application/json',
            'Content-Type: application/json',
            //Content-Type: application/x-www-form-urlencoded',
            'X-Application:rdMU1CEPHcoM8p5C',
            'Authorization:Bearer' . $auth_token
        ));

        //$postData ='ids=15789682';
        /* $postData = json_encode(array(
          'ids' =>
          array(
          0 => 18076628,
          ),
          )); */
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
        $response = json_decode(curl_exec($ch), TRUE);
        curl_close($ch);
        // echo'<pre>';
        //print_r($response);
    }

    function generate_label($postData) {
        //Generate Token

        $auth_token = $this->auth_login();
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://apiv2.shiprocket.in/v1/external/courier/generate/label");
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Accept:application/json',
            'Content-Type: application/json',
            //Content-Type: application/x-www-form-urlencoded',
            'X-Application:rdMU1CEPHcoM8p5C',
            'Authorization:Bearer' . $auth_token
        ));

        //$postData ='ids=15789682';
        /* $postData = json_encode(array(
          'shipment_id' =>
          array(
          0 => 18384403,
          ),

          )); */
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
        $response = json_decode(curl_exec($ch), TRUE);
        curl_close($ch);
        // echo'<pre>';
        //print_r($response);
        return $response['label_url'];
    }

    function track_shippment($shipment_id) {
        //Generate Token
        $auth_token = $this->auth_login();

        //Parameter Required
        // $shipment_id = 18384403;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://apiv2.shiprocket.in/v1/external/courier/track/shipment/$shipment_id");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Accept:application/json',
            'Content-Type: application/x-www-form-urlencoded',
            'X-Application:rdMU1CEPHcoM8p5C',
            'Authorization:Bearer' . $auth_token
        ));
        return $response = json_decode(curl_exec($ch), TRUE);
        curl_close($ch);
        //echo'<pre>';
        // print_r($response);
    }

    function get_order_detail() {
        //Generate Token
        $auth_token = $this->auth_login();

        //Parameter Required
        $ord_id = 19332832;

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://apiv2.shiprocket.in/v1/external/orders/show/$ord_id",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => false,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "Content-Type: application/json",
                "Authorization: Bearer" . $auth_token,
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);


        curl_close($curl);
        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            //echo'<pre>';
            $response = json_decode($response, true);
            return $response['data']['channel_id'];
        }
    }

}

?>