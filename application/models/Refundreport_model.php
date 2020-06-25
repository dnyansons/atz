<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Refundreport_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    /*
     * Following functions are added to use with server side datatables
     */

    function allrefund_count() {
        $this->db->select("*");
        $this->db->from('buyer_wallet_history as a');
        $this->db->join('users b','a.buyer_id=b.id','LEFT');
        $this->db->where("a.against",'refund');
        
        if ($_POST['order_id'] != '') {
            $this->db->where("concat('#',a.referrence)", $_POST['order_id']);
        }
        if ($_POST['phone'] != '') {
            $this->db->where("b.phone", $_POST['phone']);
        }
        if ($_POST['email'] != '') {
            $this->db->where("b.email", $_POST['email']);
        }
       
        if ($_POST['datefrom'] != '') {
            $this->db->where("date(a.created) >=", date('Y-m-d', strtotime($_POST['datefrom'])));
        }
        if ($_POST['dateto'] != '') {
            $this->db->where("date(a.created) <=", date('Y-m-d', strtotime($_POST['dateto'])));
        }
        $query = $this->db->get();
        return $query->num_rows();
    }

    function allrefund($limit, $start, $col, $dir) {
        $this->db->select("*");
        $this->db->from('buyer_wallet_history as a');
        $this->db->join('users b','a.buyer_id=b.id','LEFT');
        $this->db->where("a.against",'refund');
       
        if ($_POST['orderid'] != '') {
            $this->db->where("concat('#',a.referrence)", $_POST['orderid']);
        }
        if ($_POST['phone'] != '') {
            $this->db->where("b.phone", $_POST['phone']);
        }
        if ($_POST['email'] != '') {
            $this->db->where("b.email", $_POST['email']);
        }
        
        // if($_POST['order_id']!=''){ $this->db->where("concat('ORD',a.orders_id)",$_POST['order_id']); }
        // if($_POST['vendor_id']!=''){ $this->db->where("concat('ATZ',a.seller_id)",$_POST['vendor_id']); }
        if ($_POST['datefrom'] != '') {
            $this->db->where("date(a.created) >=", date('Y-m-d', strtotime($_POST['datefrom'])));
        }
        if ($_POST['dateto'] != '') {
            $this->db->where("date(a.created) <=", date('Y-m-d', strtotime($_POST['dateto'])));
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
    
    
   

    function refund_search($limit, $start, $search, $col, $dir) {
        $this->db->select("*");
        $this->db->from('buyer_wallet_history as a');
         $this->db->join('users b','a.buyer_id=b.id','LEFT');
         $this->db->where("a.against",'refund');
         $this->db->like("concat('#',a.referrence)", $search);
         $this->db->like("b.phone", $search);
         $this->db->like("b.email", $search);
        //$this->db->or_like('shipping_method_name',$search);
        $this->db->limit($limit, $start);
        $this->db->order_by("a." . $col, $dir);
        $query = $this->db->get();


        if ($query->num_rows() > 0) {
            
            return $query->result();
        } else {
            return null;
        }
    }

    function refund_search_count($search) {
        $this->db->select("*");
        $this->db->from('buyer_wallet_history as a');
         $this->db->join('users b','a.buyer_id=b.id','LEFT');
        $this->db->where("a.against",'refund');
        $this->db->like("concat('#',a.referrence)", $search);
        $query = $this->db->get();
        return $query->num_rows();
    }

}
