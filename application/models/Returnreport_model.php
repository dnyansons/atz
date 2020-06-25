<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Returnreport_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    /*
     * Following functions are added to use with server side datatables
     */

    function allreturn_count() {
        $this->db->select("return_orders_id,a.orders_id,a.user_name,a.pick_name,a.order_price,b.order_price as return_order_price,b.shipping_cost as return_shipping_cost,b.date_purchased as return_date,c.orders_status_name,a.user_telephone");
        $this->db->from('orders as a');
        $this->db->join('return_orders as b','a.orders_id=b.orders_id');
        $this->db->join('orders_status as c','a.orders_status=c.orders_status_id','left');
        //$this->db->where("(a.orders_status=23 OR a.orders_status=24)");
        
        if ($_POST['orders_id'] != '') {
            $this->db->where("concat('ORD',a.orders_id)", $_POST['orders_id']);
        }
       
        if ($_POST['datefrom'] != '') {
            $this->db->where("date(b.date_purchased) >=", date('Y-m-d', strtotime($_POST['datefrom'])));
        }
        if ($_POST['dateto'] != '') {
            $this->db->where("date(b.date_purchased) <=", date('Y-m-d', strtotime($_POST['dateto'])));
        }
        $query = $this->db->get();
        return $query->num_rows();
    }

    function allreturn($limit, $start, $col, $dir) {
        $this->db->select("d.ship_vendor_id,a.shippment_type,b.return_orders_id,a.orders_id,a.user_name,a.pick_name,a.order_price,b.order_price as return_order_price,b.shipping_cost as return_shipping_cost,b.date_purchased as return_date,c.orders_status_name,a.user_telephone");
        $this->db->from('orders as a');
       $this->db->join('return_orders as b','a.orders_id=b.orders_id');
        $this->db->join('orders_status as c','a.orders_status=c.orders_status_id','left');
        $this->db->join('return_order_shipping as d','a.orders_id=d.orders_id','left');
        //$this->db->where("(a.orders_status=23 OR a.orders_status=24)");
       
        if ($_POST['orders_id'] != '') {
            $this->db->where("a.orders_id", $_POST['orders_id']);
        }
        if ($_POST['user_telephone'] != '') {
            $this->db->where("a.user_telephone", $_POST['user_telephone']);
        }
        // if($_POST['order_id']!=''){ $this->db->where("concat('ORD',a.orders_id)",$_POST['order_id']); }
        // if($_POST['vendor_id']!=''){ $this->db->where("concat('ATZ',a.seller_id)",$_POST['vendor_id']); }
        if ($_POST['datefrom'] != '') {
            $this->db->where("date(b.date_purchased) >=", date('Y-m-d', strtotime($_POST['datefrom'])));
        }
        if ($_POST['dateto'] != '') {
            $this->db->where("date(b.date_purchased) <=", date('Y-m-d', strtotime($_POST['dateto'])));
        }

        if ($limit != '' && $start != '') {
            $this->db->limit($limit, $start);
        }

        if ($col != '' && $dir != '') {
            $this->db->order_by($col, $dir);
        }
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return null;
        }
    }
    
    
   

    function return_search($limit, $start, $search, $col, $dir) {
       $this->db->select("d.ship_vendor_id,b.return_orders_id,a.orders_id,a.user_name,a.pick_name,a.order_price,b.order_price as return_order_price,b.shipping_cost as return_shipping_cost,b.date_purchased as return_date,c.orders_status_name,a.user_telephone");
        $this->db->from('orders as a');
       $this->db->join('return_orders as b','a.orders_id=b.orders_id');
        $this->db->join('orders_status as c','a.orders_status=c.orders_status_id','left');
         $this->db->join('return_order_shipping as d','a.orders_id=d.orders_id','left');
         $this->db->like('a.orders_id', $search);
        //$this->db->or_like('shipping_method_name',$search);
        $this->db->limit($limit, $start);
      // $this->db->where("(a.orders_status=23 OR a.orders_status=24)");
        $this->db->order_by("a." . $col, $dir);
        $query = $this->db->get();


        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return null;
        }
    }

    function return_search_count($search) {
        $this->db->select("*");
        $this->db->from('orders as a');
        $this->db->like('orders_id', $search);
        //$this->db->or_like('shipping_method_name',$search);
      // $this->db->where("(a.orders_status=23 OR a.orders_status=24)");
        $query = $this->db->get();
        return $query->num_rows();
    }

}
