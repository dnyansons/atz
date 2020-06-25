<?php

defined('BASEPATH') OR exit('No direct script access allowed');

//require('MySoapClient.php');
class Shiprocket extends CI_Controller {

    public function __construct() {

        parent::__construct();
        $this->load->model("Users_model");
        $this->load->model("Common_model");
        $this->load->model("Order_model");
        $this->load->model("Shipping_model");
        $this->load->model('Order_model');
        $this->load->library('Send_data');
        $this->load->library('Browser_notification');
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
        $response = json_decode(curl_exec($ch), TRUE);
        curl_close($ch);
        //$_SESSION['auth_token']=$response['token'];
        return $response['token'];
    }

    function channel() {
        //Generate Token
        $auth_token = $this->auth_login();

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://apiv2.shiprocket.in/v1/external/channels");
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
        echo'<pre>';
        print_r($response);
    }

    function serviceability() {
        //Generate Token
        $auth_token = $this->auth_login();

        //Parameter Required
        $pickup_postcode = 411057;
        $delivery_postcode =411034 ;
        $weight = 1;
        $length = 0; //Meters 50 cm
        $breadth = 0; //Meters
        $height = 0; //Meters
        $cod = 0; //Required Cash :: Delivery =1, Prepaid =0
        $order_id = 18473033; //(Optional)
        $declared_value = 1; //Price of Order
        $mode = 'Surface';  //Surface/Air
        $is_return = 1;  //Check return
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://apiv2.shiprocket.in/v1/external/courier/serviceability?order_id=$order_id");
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
        echo'<pre>';
        print_r($response);
    }

  

    //get All Order related to Status
    function shipments() {
        //Generate Token
        $auth_token = $this->auth_login();

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://apiv2.shiprocket.in/v1/external/shipments");
        //curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Accept:application/json',
            'Content-Type: application/x-www-form-urlencoded',
            'Authorization:Bearer' . $auth_token
        ));
        $response = json_decode(curl_exec($ch), TRUE);
        curl_close($ch);
        echo'<pre>';
        print_r($response);
    }

    function countries() {
        //Generate Token
        $auth_token = $this->auth_login();

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://apiv2.shiprocket.in/v1/external/countries");
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
        echo'<pre>';
        print_r($response);
    }

    function create_order() {
        //Generate Token

        $auth_token = $this->auth_login();

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
            'order_id' => 'Test order 12',
            'order_date' => date('Y-m-d H:i'),
            'pickup_location' => 'PICK004',
            'channel_id' => '',
            'comment' => 'Reseller: Dnyansons Enterprises',
            'billing_customer_name' => 'Dnyansons',
            'billing_last_name' => 'Sonewane',
            'billing_address' => 'Opp. Yashwant Pride',
            'billing_address_2' => 'Kasarwadi',
            'billing_city' => 'Pune',
            'billing_pincode' => '411034',
            'billing_state' => 'Maharastra',
            'billing_country' => 'India',
            'billing_email' => 'dnyansons@ayninfotech.com',
            'billing_phone' => '7020153445',
            'shipping_is_billing' => true,
            'shipping_customer_name' => 'Dnyanesh',
            'shipping_last_name' => 'Sonewane',
            'shipping_address' => 'Opp. Yashwant Pride',
            'shipping_address_2' => 'Kasarwadi',
            'shipping_city' => 'Pune',
            'shipping_pincode' => '411034',
            'shipping_country' => 'India',
            'shipping_state' => 'Maharstra',
            'shipping_email' => 'dnyansons@ayninfotech.com',
            'shipping_phone' => '7020153445',
            'order_items' =>
            array(0 =>
                array(
                    'name' => 'Test Product 001',
                    'sku' => 'ATZ001', //It Can not be repeated
                    'units' => 1,
                    'selling_price' => '15',
                    'discount' => '',
                    'tax' => '0.00',
                    'hsn' => 123445,
                ),
                1 =>
                array(
                    'name' => 'Test Product 002',
                    'sku' => 'ATZ002',
                    'units' => 1,
                    'selling_price' => '15',
                    'discount' => '0.00',
                    'tax' => '0.00',
                    'hsn' => 123445,
                ),
            ),
            'payment_method' => 'Prepaid', //( Prepaid / COD )
            'shipping_charges' => 0,
            'giftwrap_charges' => 0,
            'transaction_charges' => 0,
            'total_discount' => 0,
            'sub_total' => 30,
            /* the length must be greater than or equal to 0.5.
              The breadth must be greater than or equal to 0.5.
              The height must be greater than or equal to 0.5. */
            'length' => 0.5,
            'breadth' => 0.5,
            'height' => 0.5,
            'weight' => 0.5,
        ));

        curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
        $response = json_decode(curl_exec($ch), TRUE);
        curl_close($ch);
        echo'<pre>';
        print_r($response);
    }

    function cancel_order() {
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
        $postData = json_encode(array(
            'ids' =>
            array(
                0 => 18894736,
            ),
        ));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
        $response = json_decode(curl_exec($ch), TRUE);
        curl_close($ch);
        echo'<pre>';
        print_r($response);
    }

    function get_order_details() {
        //Generate Token
        $auth_token = $this->auth_login();

        //Parameter Required
        $order_id = 19618178;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://apiv2.shiprocket.in/v1/external/orders/show/$order_id");
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
        echo'<pre>';
        print_r($response);
    }

    function track_awb() {
        //Generate Token
        $auth_token = $this->auth_login();

        //Parameter Required
        $awb_code = 18567910;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://apiv2.shiprocket.in/v1/external/courier/track/awb/$awb_code");
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
        echo'<pre>';
        print_r($response);
    }

    function track_shippment() {
        //Generate Token
        $auth_token = $this->auth_login();

        //Parameter Required
        $shipment_id = 18384403;

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
        $response = json_decode(curl_exec($ch), TRUE);
        curl_close($ch);
        echo'<pre>';
        print_r($response);
    }

    function get_shipment_details() {
        //Generate Token
        $auth_token = $this->auth_login();

        //Parameter Required
        //$ship_id = 15789682;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://apiv2.shiprocket.in/v1/external/shipments");
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
        echo'<pre>';
        print_r($response);
    }

    function get_all_order_details() {
        //Generate Token
        $auth_token = $this->auth_login();
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://apiv2.shiprocket.in/v1/external/orders");
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
        echo'<pre>';
        print_r($response);
    }

    function awb_creation() {
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

        //$postData ='ids=15789682';
        $postData = json_encode(array(
            'shipment_id' =>
            array(
                0 => 18384403,
            ),
            'courier_id' => 51,
            'status' => 'assign',
        ));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
        $response = json_decode(curl_exec($ch), TRUE);
        curl_close($ch);
        echo'<pre>';
        print_r($response);
    }

    function pickup_request() {
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

        //$postData ='ids=15789682';
        $postData = json_encode(array(
            'shipment_id' =>
            array(
                0 => 18384403,
            ),
            'status' => 'retry',
        ));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
        $response = json_decode(curl_exec($ch), TRUE);
        curl_close($ch);
        echo'<pre>';
        print_r($response);
    }

    function pickup_location() {
        //Generate Token
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
        echo'<pre>';
        print_r($pickupAddress);


        curl_close($ch);
        $pickupId = 'PI90';
        $result = array_filter($pickupAddress, function ($item) use ($pickupId) {
            if ($item['pickup_location'] == $pickupId) {
                return true;
            }
            return false;
        });

        if ($result) {
            return true;
        } else {
            $this->load->model("pickaddress_model");
            $address = $this->pickaddress_model->getaddress(35);
            if ($address) {
                print_r($address);
                $postData = array(
                    'pickup_location' => 'PICK' . $address["pick_id"],
                    'name' => $address["seller_name"],
                    'email' => $address["seller_email"],
                    'phone' => $address["seller_mobile"],
                    'address' => $address["address"],
                    'address_2' => $address["address2"],
                    'city' => $address["city"],
                    'state' => $address["state"],
                    'country' => 'India',
                    'pin_code' => $address["pincode"],
                );

                $res = $this->add_new_pickup($postData);
                return $res;
            } else {
                return false;
            }
        }
    }

    function add_new_pickup() {
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
        $postData = json_encode(array(
            'pickup_location' => 'y443_121',
            'name' => 'nn',
            'email' => 'iron@gmail.com',
            'phone' => '7020153445',
            'address' => 'Ground Floor, Office 3A, Midas Tower',
            'address_2' => 'Phase 1 Hinjewadi',
            'city' => '-',
            'state' => 'Ground Floor, Midas Tower',
            'country' => 'Ayn Infotech',
            'pin_code' => '411057'
        ));

        curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
        $response = json_decode(curl_exec($ch), TRUE);
        curl_close($ch);
        echo'<pre>';
        print_r($response['address']['id']);
    }

    function generate_label() {
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
        $postData = json_encode(array(
            'shipment_id' =>
            array(
                0 => 18384403,
            ),
        ));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
        $response = json_decode(curl_exec($ch), TRUE);
        curl_close($ch);
        echo'<pre>';
        print_r($response['label_url']);
    }

    function get_all_pickup_location() {
        //Generate Token
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
        curl_close($ch);
        echo'<pre>';
        print_r($response);
    }

    //return Order
    function return_order() {
        //Generate Token

        $auth_token = $this->auth_login();

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
            "order_id" => "123",
            "order_date" => date('Y-m-d'),
            "channel_id" => "250744",
            "pickup_customer_name" => "aaa",
            "pickup_last_name" => "aa",
            "pickup_address" => "aajjjj",
            "pickup_address_2" => "aajjjj",
            "pickup_city" => "aa",
            "pickup_state" => "aa",
            "pickup_country" => "aa",
            "pickup_pincode" => "441912",
            "pickup_email" => "asd@gmail.com",
            "pickup_phone" => "7020153445",
            "pickup_isd_code" => "",
            "pickup_location_id" => "153815",
            "shipping_customer_name" => "ggg",
            "shipping_last_name" => "ggg",
            "shipping_address" => "gkkkkg",
            "shipping_address_2" => "ggkkkk",
            "shipping_city" => "ggg",
            "shipping_country" => "India",
            "shipping_pincode" => "411034",
            "shipping_state" => "ggg",
            "shipping_email" => "asdf@gmail.com",
            "shipping_isd_code" => "",
            "shipping_phone" => "8793177845",
            "order_items" => array(0 =>
                array(
                    'name' => 'Test Product 001',
                    'sku' => 'ATZ001', //It Can not be repeated
                    'units' => 1,
                    'selling_price' => '15',
                    'discount' => '',
                    'tax' => '0.00',
                    'hsn' => 123445,
                ),
            ),
            "payment_method" => "gg",
            "total_discount" => "0.00",
            "sub_total" => "123",
            "length" => "0.5",
            "breadth" => "0.5",
            "height" => "0.5",
            "weight" => "1",
        ));

        curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
        $response = json_decode(curl_exec($ch), TRUE);
        curl_close($ch);
        echo'<pre>';
        print_r($response);
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
            echo'<pre>';
            $response = json_decode($response, true);
            echo $response['data']['channel_id'];
        }
    }

}
