<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Track_Order extends CI_Controller {

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
    }

    public function index($order_id) {
        
        if ($order_id != 0) {
            $user_id = $this->session->userdata("user_id");
            //Get Latest Tracking Status//
            $this->shipping->latest_tracking_status($order_id);
            $order_detail=$this->Order_model->getBuyersOrderbyOrderID($order_id);
            $order_products=$this->Order_model->getUserOrdersWithOrderId($order_id);
            $data['order_detail']=$order_detail;
            $data['order_products']=$order_products;
            $data['hist_dat'] = $this->Order_model->get_order_status($order_id);
            $product_qty=0;
            if(!empty($order_products))
            {
                foreach($order_products as $order_product){
                    $product_qty+=$order_product['products_quantity'];
                }
            }
            $data['total_quantity']=$product_qty;

            $this->load->view('mobile/track_order_view',$data);
       }
    }
    /*
    * Get Order Track Product Details BY Order Id
    */
    public function getOrderProductDetails($order_id)
    {
         if ($order_id != 0) {
            $user_id = $this->session->userdata("user_id");
            $this->shipping->latest_tracking_status($order_id);
            $order_products=$this->Order_model->getTrackProductDetails($order_id);
            $i=0;
            foreach($order_products as $order_pro){
                $order_products[$i]->decode_spec=json_decode($order_pro->product_specifications);
                $i++;
            }
            //printr($order_products);
            $data['order_products']=$order_products;
            $this->load->view('mobile/track_product_view',$data);
        }
    }

}

?>