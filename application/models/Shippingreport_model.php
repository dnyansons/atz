<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Shippingreport_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    /*
     * Following functions are added to use with server side datatables
     */

    function allshipping_count() {
        $this->db->select("*");
        $this->db->from('orders as a');
        $this->db->join('order_shipping b','b.orders_id=a.orders_id','left');
        $this->db->join('shipping_vendor c','c.id=b.ship_vendor_id','left');
        $this->db->where("(a.orders_status=4 OR a.orders_status=10 OR a.orders_status=26 OR a.orders_status=19)");
        
        if ($_POST['order_id'] != '') {
            $this->db->where("concat('ORD',a.orders_id)", $_POST['order_id']);
        }
       
        if ($_POST['datefrom'] != '') {
            $this->db->where("date(a.date_purchased) >=", date('Y-m-d', strtotime($_POST['datefrom'])));
        }
        if ($_POST['dateto'] != '') {
            $this->db->where("date(a.date_purchased) <=", date('Y-m-d', strtotime($_POST['dateto'])));
        }
        $query = $this->db->get();
        return $query->num_rows();
    }

    function allshipping($limit, $start, $col, $dir) {
        $this->db->select("*,a.shippment_type as ship");
        $this->db->from('orders as a');
         $this->db->join('order_shipping b','b.orders_id=a.orders_id','left');
        $this->db->join('shipping_vendor c','c.id=b.ship_vendor_id','left');
        $this->db->where("(a.orders_status=4 OR a.orders_status=10 OR a.orders_status=26 OR a.orders_status=19)");
       
        if ($_POST['order_id'] != '') {
            $this->db->where("a.orders_id", $_POST['order_id']);
        }
        if ($_POST['order_id'] != '') {
            $this->db->where("a.orders_id", $_POST['order_id']);
        }
        if ($_POST['ship_vendor_id'] != '') {
            $this->db->where("b.ship_vendor_id", $_POST['ship_vendor_id']);
        }
        if ($_POST['shippment_type'] != '') {
            $this->db->where("a.shippment_type", $_POST['shippment_type']);
        }
        // if($_POST['order_id']!=''){ $this->db->where("concat('ORD',a.orders_id)",$_POST['order_id']); }
        // if($_POST['vendor_id']!=''){ $this->db->where("concat('ATZ',a.seller_id)",$_POST['vendor_id']); }
        if ($_POST['datefrom'] != '') {
            $this->db->where("date(a.date_purchased) >=", date('Y-m-d', strtotime($_POST['datefrom'])));
        }
        if ($_POST['dateto'] != '') {
            $this->db->where("date(a.date_purchased) <=", date('Y-m-d', strtotime($_POST['dateto'])));
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
    
    
   

    function shipping_search($limit, $start, $search, $col, $dir) {
        $this->db->select("*,a.shippment_type as ship");
        $this->db->from('orders as a');
        $this->db->join('orders_products as b', 'a.orders_id=b.orders_id', 'left');
         $this->db->like('a.orders_id', $search);
         $this->db->like('a.shippment_type', $search);
        //$this->db->or_like('shipping_method_name',$search);
        $this->db->limit($limit, $start);
       $this->db->where("(a.orders_status=4 OR a.orders_status=10 OR a.orders_status=26 OR a.orders_status=19)");
        $this->db->order_by("a." . $col, $dir);
        $query = $this->db->get();


        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return null;
        }
    }

    function shipping_search_count($search) {
       $this->db->select("*,a.shippment_type as ship");
        $this->db->from('orders as a');
        $this->db->like('orders_id', $search);
        $this->db->like('shippment_type', $search);
        //$this->db->or_like('shipping_method_name',$search);
       $this->db->where("(a.orders_status=4 OR a.orders_status=10 OR a.orders_status=26 OR a.orders_status=19");
        $query = $this->db->get();
        return $query->num_rows();
    }

}
