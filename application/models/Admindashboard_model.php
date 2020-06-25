<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Admindashboard_model extends CI_Model {

    private $_table;
    private $_tableDescription;

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->model('Common_model');
    }

    public function total_orders($start, $end) {
        $query = $this->db->query('select count(orders_id) as total_orders from orders where date(date_purchased) between "' . $start . '" and "' . $end . '" AND orders_status!=8');
        return $result = $query->row_array()['total_orders'];
    }

    public function total_sale($start, $end) {
        $query = $this->db->query('select ifnull(sum(order_price),0) as total_sale from orders where date(date_purchased) between "' . $start . '" and "' . $end . '" and (orders_status=4 or orders_status=10 or orders_status=26 or orders_status=19 or orders_status=20 or orders_status=23)');
        return $result = $query->row_array()['total_sale'];
    }

    public function total_commission($start, $end) {
        //$query = $this->db->query('SELECT ifnull(sum((order_price - shipping_cost - vendor_payable_price)),0) as comission FROM `orders` where  date(date_purchased) between "' . $start . '" and "' . $end . '" and (orders_status=4 or orders_status=10 or orders_status=26 or orders_status=19)');
        $query1 = $this->db->query('SELECT ifnull(sum((order_price - shipping_cost - vendor_payable_price)),0) as comission FROM `orders` where  date(date_purchased) between "' . $start . '" and "' . $end . '" and shippment_type="Paid" and (orders_status=4 or orders_status=10 or orders_status=26 or orders_status=19)');
        $query2 = $this->db->query('SELECT ifnull(sum((order_price - vendor_payable_price)),0) as comission FROM `orders` where  date(date_purchased) between "' . $start . '" and "' . $end . '" and shippment_type="Free" and(orders_status=4 or orders_status=10 or orders_status=26 or orders_status=19)');
        $result1 = $query1->row_array()['comission'];
        $result2 = $query2->row_array()['comission'];
        return $result1+$result2;
    }

    public function total_shipping($start, $end) {
        $query = $this->db->query('SELECT ifnull(sum((shipping_cost)),0) as shippingcost FROM `orders` where  date(date_purchased) between "' . $start . '" and "' . $end . '" and (orders_status=4 or orders_status=10 or orders_status=26 or orders_status=19)');
        return $result = $query->row_array()['shippingcost'];
    }

    public function total_returns($start, $end) {
        $query = $this->db->query('SELECT count(orders_id) as total_returns FROM `orders_history` where status=23 and date(date_added) between "' . $start . '" and "' . $end . '"');
        return $result = $query->row_array()['total_returns'];
    }

    public function total_dispute($start, $end) {
        $query = $this->db->query('SELECT ifnull(sum((vendor_payable_price)),0) as dispute FROM `orders` where orders_status=4 and vndr_payment_status="hold" and date(delivery_date) between "' . $start . '" and "' . $end . '"');
        return $result = $query->row_array()['dispute'];
    }

    public function total_settled($start, $end) {
        $query = $this->db->query('SELECT ifnull(sum((amount)),0) as settlements FROM `wallet_vendor_history` where status="settled" and type="credit" and date(date) between "' . $start . '" and "' . $end . '"');
        return $result = $query->row_array()['settlements'];
    }

    public function total_refund($start, $end) {
        $query = $this->db->query('SELECT ifnull(sum((amount)),0) as refund FROM buyer_wallet_history  WHERE `against`="refund" and date(`created`) between "' . $start . '" and "' . $end . '"');
        return $result = $query->row_array()['refund'];
    }
    
    
    function all_admin_noti_count() {
        $this->db->select("*");
        $this->db->from('admin_notification');
       
        
        if ($_POST['datefrom'] != '') {
            $this->db->where("date(date_created) >=", date('Y-m-d', strtotime($_POST['datefrom'])));
        }
        if ($_POST['dateto'] != '') {
            $this->db->where("date(date_created) <=", date('Y-m-d', strtotime($_POST['dateto'])));
        }
        $this->db->order_by('id','DESC');
        $query = $this->db->get();
        return $query->num_rows();
    }

    function all_admin_noti($limit, $start, $col, $dir) {
        $this->db->select("*");
        $this->db->from('admin_notification');
       
        if ($_POST['datefrom'] != '') {
            $this->db->where("date(date_created) >=", date('Y-m-d', strtotime($_POST['datefrom'])));
        }
        if ($_POST['dateto'] != '') {
            $this->db->where("date(date_created) <=", date('Y-m-d', strtotime($_POST['dateto'])));
        }

        if ($limit != '' && $start != '') {
            $this->db->limit($limit, $start);
        }

        $this->db->order_by('id','DESC');
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return null;
        }
    }
    
    public function todaysUsers($userRole) {
        $sql = "select count(id) as todaysUsers from users where date(created_on) = curdate() "
                . " AND role = ? ";
        $query = $this->db->query($sql, array($userRole));
        return $result = $query->row_array()['todaysUsers'];
    }

    

}
