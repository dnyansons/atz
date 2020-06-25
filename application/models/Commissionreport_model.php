<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Commissionreport_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    /*
     * Following functions are added to use with server side datatables
     */

    function allcommission_count() {
        $this->db->select("concat('ATZ',a.seller_id) as seller_id,concat(c.first_name,' ',c.last_name) as vendorname,c.phone as vendorphone,concat('ORD',a.orders_id) as orders_id,a.date_purchased,a.delivery_date,a.order_price,a.vendor_payable_price");
        $this->db->from('orders as a');
        $this->db->join('users as c', 'a.seller_id=c.id', 'left');
        $this->db->join('wallet_vendor_history as d', 'd.order_id=a.orders_id', 'left');
        $this->db->where("a.orders_status", 4);
        $this->db->where("a.vndr_payment_status", 'settled');
        if ($_POST['order_id'] != '') {
            $this->db->where("concat('ORD',a.orders_id)", $_POST['order_id']);
        }
        if ($_POST['vendor_id'] != '') {
            $this->db->where("concat('ATZ',a.seller_id)", substr($_POST['vendor_id'], 3));
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

    function allcommission($limit, $start, $col, $dir) {
        $this->db->select("concat('ATZ',a.seller_id) as seller_id,concat(c.first_name,' ',c.last_name) as vendorname,c.phone as vendorphone,concat('ORD',a.orders_id) as orders_id,a.date_purchased,a.delivery_date,a.order_price,a.vendor_payable_price,d.date as settled_date,d.remark,d.amount as settledamount,a.commission,a.gst");
        $this->db->from('orders as a');
        $this->db->join('users as c', 'a.seller_id=c.id', 'left');
        $this->db->join('wallet_vendor_history as d', 'd.order_id=a.orders_id', 'left');
        $this->db->where("a.orders_status", 4);
        $this->db->where("a.vndr_payment_status", 'settled');
        if ($_POST['order_id'] != '') {
            $this->db->where("a.orders_id", $_POST['order_id']);
        }
        if ($_POST['vendor_id'] != '') {
            $this->db->where("a.seller_id", substr($_POST['vendor_id'], 3));
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

       // echo $this->db->last_query();
       // exit;
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return null;
        }
    }
    
    /**
     * @auther Yogesh Pardeshi
     * @return type array of results on success and null on failure
     */
    function generateExcelReportSettlement() {
        $this->db->select("DATE_FORMAT(a.date_purchased, '%d-%m-%Y %I : %i : %s %p') ordered_date,concat('ORD', a.orders_id) as orders_id, OPA.payment_id, if(a.orders_status = 4, 'Delivered', '') orderstatus,CONCAT('PRD',OP.products_id),OP.products_name, CS.categories_name, 
                           a.delivery_name, a.user_email_address, user_telephone,
                           CONCAT(delivery_street_address,
                           ' ', delivery_suburb, ' ', delivery_city, ' ', delivery_postcode,
                           ' ', delivery_state, ' ', delivery_country) buyer_address,
                           CONCAT('Picked Up By:', a.pick_name , ' Picked Up From: ',
                           pick_addr_type, ' ', pick_address, '  Pincode: ', pick_pincode,
                           ' ', pick_state, ' ', pick_country, ' ', ' Mob: ', pick_mobile,
                           ' Email: ', pick_email) pickup_address,
                           DATE_FORMAT(a.shipping_start_date, '%d-%m-%Y %I : %i : %s %p') shipping_start,
                           concat('ATZ', a.seller_id) as seller_id,
                           concat(c.first_name, ' ', c.last_name) as vendorname,
                           c.phone as vendorphone,
                           a.shipping_method,
                           a.shipping_subtotal, a.shipping_gst, a.shipping_cost, a.vendor_payable_price,
                           a.commission, a.gst,  a.order_price,  
                           DATE_FORMAT(a.delivery_date, '%d-%m-%Y %I : %i : %s %p') delivered_date,
                           d.date as settled_date, d.remark, 
                           d.amount as settledamount, d.date settled_date, 
                           wv.available_balance vendor_wallet_amount")
                ->from('orders a')
                ->join('orders_products OP', 'OP.orders_id=a.orders_id', 'LEFT')
                ->join('order_payment OPA', 'OPA.orders_id=a.orders_id', 'LEFT')
                ->join('product_details PD', 'PD.id=OP.products_id', 'LEFT')
                ->join('categories_description CS', 'CS.id=PD.category', 'LEFT')
                ->join('users c', 'a.seller_id=c.id', 'LEFT')
                ->join('wallet_vendor_history d', ' d.order_id=a.orders_id', 'LEFT')
                ->join('wallet_vendor wv', 'wv.vendor_id = d.vendor_id', 'LEFT')
                ->where("a.orders_status", '4')
                ->where("a.vndr_payment_status", 'settled');

        if ($_POST['order_id'] != '') {
            $this->db->where("a.orders_id", $_POST['order_id']);
        }
        if ($_POST['vendor_id'] != '') {
            $this->db->where("a.seller_id", $_POST['vendor_id']);
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
            return $query->result_array();
        } else {
            return null;
        }
    }

    function commission_search($limit, $start, $search, $col, $dir) {
        $this->db->select("a.orders_id, a.delivery_date, b.final_price as order_amount, c.wallet_transaction_status");
        $this->db->from('orders as a');
        $this->db->join('orders_products as b', 'a.orders_id=b.orders_id', 'left');
        $this->db->join('users_wallet as c', 'a.orders_id=c.orders_id', 'left');
        $this->db->like('wallet_transaction_id', $search);
        //$this->db->or_like('shipping_method_name',$search);
        $this->db->limit($limit, $start);
        $this->db->where('a.orders_status', 4);
        $this->db->order_by("a." . $col, $dir);
        $query = $this->db->get();


        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return null;
        }
    }

    function commission_search_count($search) {
        $this->db->select("a.orders_id, a.delivery_date, b.final_price as order_amount, c.wallet_transaction_status");
        $this->db->from('orders as a');
        $this->db->join('orders_products as b', 'a.orders_id=b.orders_id', 'left');
        $this->db->join('users_wallet as c', 'a.orders_id=c.orders_id', 'left');
        $this->db->like('wallet_transaction_id', $search);
        //$this->db->or_like('shipping_method_name',$search);
        $this->db->where('a.orders_status', 4);
        $query = $this->db->get();
        return $query->num_rows();
    }

}
