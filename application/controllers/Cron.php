<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Cron extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Common_model');
        $this->load->library('Send_data');
        $this->load->library('Browser_notification');
    }

    function index() {
        echo'ATZCART';
    }

    public function seller_not_respond_order() {

        $pending_orders = $this->Common_model->select('orders_id', 'orders', ['orders_status' => 8, 'date_purchased <=' => date('Y-m-d H:i:s', strtotime('-1 day', time()))]);

        if (!empty($pending_orders)) {
            foreach ($pending_orders as $order) {
                //$product_id = $this->Common_model->select("products_id","orders_products",["orders_id"=>$order["orders_id"]]);
                //$seller_id = $this->Common_model->select("seller","product_details",["id"=>$product_id]);
                $notification_title = 'Seller Not Respond To Order';
                $notification_msg = 'Seller not responded to his product order from last 24 hours';
                $notification_type = 'Order';
                $reference_id = $order["orders_id"];
                add_admin_notification($notification_title, $notification_msg, $notification_type, $reference_id);
            }
        }
    }

    public function seller_not_respond_inquiry() {
        $pending_inquiries = $this->Common_model->select('id', 'inquiries', ['status' => 'Pending', 'added_date <=' => date('Y-m-d H:i:s', strtotime('-1 day', time()))]);
//        echo "<pre>";
//        print_r($pending_inquiries);
//        exit;
        if (!empty($pending_inquiries)) {
            foreach ($pending_inquiries as $inquiry) {
                //$product_id = $this->Common_model->select("products_id","orders_products",["orders_id"=>$order["orders_id"]]);
                //$seller_id = $this->Common_model->select("seller","product_details",["id"=>$product_id]);
                $notification_title = 'Seller Not Respond To Inquiry';
                $notification_msg = 'Seller not responded to his product inquiry from last 24 hours';
                $notification_type = 'Inquiry';
                $reference_id = $inquiry['id'];
                add_admin_notification($notification_title, $notification_msg, $notification_type, $reference_id);
            }
        }
    }

    public function seller_not_respond_rfq() {
        $pending_rfqs = $this->Common_model->select('id', 'rfqs', ['status' => 'Pending', 'added_date <=' => date('Y-m-d H:i:s', strtotime('-1 day', time()))]);
//        echo "<pre>";
//        print_r($pending_rfqs);
//        exit;
        if (!empty($pending_rfqs)) {
            foreach ($pending_rfqs as $rfq) {
                //$product_id = $this->Common_model->select("products_id","orders_products",["orders_id"=>$order["orders_id"]]);
                //$seller_id = $this->Common_model->select("seller","product_details",["id"=>$product_id]);
                $notification_title = 'Seller Not Respond To RFQ';
                $notification_msg = 'Seller not responded to his RFQ Request from last 24 hours';
                $notification_type = 'RFQ';
                $reference_id = $rfq['id'];
                add_admin_notification($notification_title, $notification_msg, $notification_type, $reference_id);
            }
        }
    }

    public function admin_unapproved_seller_list() {
        $this->load->model('Users_model');
        $unapporved_seller_count = $this->Users_model->get_unapproved_sellers();
        if ($unapporved_seller_count > 0) {
            $notification_title = 'Seller Profile Approval Pending';
            $notification_msg = $unapporved_seller_count . ' Seller Profile approvals are pending';
            $notification_type = 'Registration';
            $reference_id = null;
            add_admin_notification($notification_title, $notification_msg, $notification_type, $reference_id);
        }
    }

    public function admin_unapproved_product_list() {
        $this->load->model('Users_model');
        $unapporved_product_count = $this->Common_model->select('count(id)', 'product_details', ['publish_status' => 'Pending'])[0]['count(id)'];
        if ($unapporved_product_count > 0) {
            $notification_title = 'Product Approval Pending';
            $notification_msg = $unapporved_product_count . ' seller products approvals are pending';
            $notification_type = 'Product Approval';
            $reference_id = null;
            add_admin_notification($notification_title, $notification_msg, $notification_type, $reference_id);
        }
    }

    public function process_vendor_payment() {
        //run url http://localhost/members_new/cron/process_vendor_payment
        //$orders = $this->db->query("select orders_id,seller_id,shipping_cost,order_price,vendor_payable_price FROM `orders` WHERE TIMESTAMPDIFF(DAY,delivery_date,now()) >=15 and orders_status=4 and vndr_payment_status='pending'")->result_array();
        $orders = $this->db->query("select orders_id,seller_id,shipping_cost,order_price,vendor_payable_price FROM `orders` WHERE  orders_status=4 and vndr_payment_status='pending'")->result_array();
        //$orders = $this->db->query("select orders_id,seller_id,shipping_cost,order_price,vendor_payable_price FROM `orders` WHERE orders_status=4 and vndr_payment_status='pending'")->result_array();
        foreach ($orders as $ord) {
            //$price = $ord['order_price'] - $ord['shipping_cost'];    
            $price = $ord["vendor_payable_price"];
            $this->db->insert("wallet_shipper_history", array("vendor_id" => 1, "order_id" => $ord['orders_id'], "amount" => $ord["shipping_cost"], "status" => "available", "type" => "credit", "date" => date('Y-m-d H:i:s')));
            $this->Common_model->update("wallet_vendor_history", array("status" => "available", "date" => date('Y-m-d H:i:s')), array("vendor_id" => $ord['seller_id'], "order_id" => $ord['orders_id'], "amount" => $price, "status" => "pending", "type" => "credit"));
            $this->Common_model->update("orders", array("vndr_payment_status" => "inprocess", "shipping_payment_status" => "Available"), array("seller_id" => $ord['seller_id'], "orders_id" => $ord['orders_id']));
            $this->db->query("update wallet_vendor set available_balance = available_balance + '" . $price . "', pending_balance = pending_balance - '" . $price . "' where vendor_id='" . $ord['seller_id'] . "'");
        }
    }

    function update_tracking_status() {
        $this->db->query('INSERT INTO `sons`(`id`) VALUES (1)');
        $this->load->library('Shipping');
        //Get NOT Delivered Order ID
        $this->db->select('orders_id');
        $this->db->from('orders');
        $this->db->where('orders_status!=', 4);
        $ord = $this->db->get()->result();
        foreach ($ord as $ordid) {
            $this->shipping->latest_tracking_status($ordid->orders_id);
        }
    }

    function update_return_tracking_status() {
        $this->load->library('Shipping');
        //Get NOT Delivered Order ID
        $this->db->select('return_orders_id');
        $this->db->from('return_orders');
        $this->db->where('orders_status!=', 4);
        $ord = $this->db->get()->result();
        foreach ($ord as $ordid) {
            $this->shipping->latest_tracking_status($ordid->return_orders_id);
        }
    }

    function check_pending_orders() {
        //Get Pending Orders
        $res = $this->Common_model->getAll('orders', array('orders_status' => 8))->result();

        foreach ($res as $row) {
            $curr_date = date('Y-m-d');
            $order_date = date('Y-m-d', strtotime($row->date_purchased));
            $date1 = date_create($curr_date);
            $date2 = date_create($order_date);
            $diff = date_diff($date2, $date1);

            echo $tot_hrs = $diff->format("%a") . '|' . $order_date . '<br>'; //Days
            $order_id = $row->orders_id;
            if ($tot_hrs >= 1) {
                $this->Common_model->delete('orders', array('orders_id' => $order_id));
                $this->Common_model->delete('orders_products', array('orders_id' => $order_id));
                $this->Common_model->delete('orders_history', array('orders_id' => $order_id));

                //Send SMS to Buyer for deletd Pending Order
                $message = 'Your Pending Order #ORD' . $order_id . ' has been Deleted from Your Account ! From atzcart.com';
                $mob = $row->user_telephone;
                $this->send_data->send_sms($message, $mob);
            } else {
                //Send SMS to Buyer
                $message = 'Your Order #ORD' . $order_id . ' is Pending. Please Make Payment to avoid Cancellation of Your Product ! From atzcart.com';
                $mob = $row->user_telephone;
                // $this->send_data->send_sms($message, $mob);
                //get firebase ID
                $fb_id = $this->Common_model->getAll('users_firebase_details', array('user_id' => $row->user_id))->row();
                $buyer_firbase = $fb_id->firebase_id;
                //To Buyer
                if (!empty($buyer_firbase)) {
                    $type = "Order";
                    $type_id = $order_id;
                    $this->browser_notification->notify_buyer('Order Pending', $message, $buyer_firbase, $type, $type_id);
                }
            }
        }
    }

    function update_offer_status() {
        $offer = $this->Common_model->getAll('offer_zone', array('status' => 'Active', 'valid_to' => date('Y-m-d')))->result();

        foreach ($offer as $off) {
            echo 'Existing: ' . strtotime($off->time_to);
            echo'<br>';
            echo 'Current: ' . strtotime(date('H:i:s'));
            echo'<br>';
            if (strtotime($off->time_to) < strtotime(date('H:i:s'))) {
                $up['status'] = 'Inactive';
                $this->Common_model->update('offer_zone',$up,array('status' =>'Active','offer_id' =>$off->offer_id));
                echo'Yes';
            } else {
                echo 'No';
            }
        }
    }

}
