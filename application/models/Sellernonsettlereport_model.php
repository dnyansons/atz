<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Sellernonsettlereport_model extends CI_Model
{
    public function __construct() 
    {
        parent::__construct();
    }

    /*
     * Following functions are added to use with server side datatables
     */
    
    function allcommission_count()
    {   
       $this->db->select("concat('ATZ',a.seller_id) as seller_id,concat(c.first_name,' ',c.last_name) as vendorname,c.phone as vendorphone,concat('ORD',a.orders_id) as orders_id,a.date_purchased,a.delivery_date,a.order_price,a.vendor_payable_price");
       $this->db->from('orders as a');
       $this->db->join('users as c', 'a.seller_id=c.id','left');
       //$this->db->join('wallet_vendor_history as d', 'd.order_id=a.orders_id','left');
	   $this->db->where("a.orders_status !=",'4');
	   $this->db->where("a.vndr_payment_status !=",'settled');
	   if($_POST['order_id']!=''){ $this->db->where("concat('ORD',a.orders_id)",$_POST['order_id']); }
	   $this->db->where("a.seller_id",$this->session->userdata("user_id"));
	   if($_POST['datefrom']!=''){ $this->db->where("date(a.date_purchased) >=",date('Y-m-d',strtotime($_POST['datefrom']))); }
	   if($_POST['dateto']!=''){ $this->db->where("date(a.date_purchased) <=", date('Y-m-d',strtotime($_POST['dateto']))); }
       $query =  $this->db->get();
       return $query->num_rows();
    }
    

    function allcommission($limit,$start,$col,$dir)
    {   
       $this->db->select("concat('ATZ',a.seller_id) as seller_id,concat(c.first_name,' ',c.last_name) as vendorname,c.phone as vendorphone,concat('ORD',a.orders_id) as orders_id,a.date_purchased,a.delivery_date,a.order_price,a.vendor_payable_price,a.commission,a.gst");
       $this->db->from('orders as a');
       $this->db->join('users as c', 'a.seller_id=c.id','left');
       //$this->db->join('wallet_vendor_history as d', 'd.order_id=a.orders_id','left');
	   $this->db->where("a.orders_status !=",'4');
	   $this->db->where("a.vndr_payment_status !=",'settled');
	   if($_POST['order_id']!=''){ $this->db->where("concat('ORD',a.orders_id)",$_POST['order_id']); }
	   $this->db->where("a.seller_id",$this->session->userdata("user_id"));
	   if($_POST['datefrom']!=''){ $this->db->where("date(a.date_purchased) >=",date('Y-m-d',strtotime($_POST['datefrom']))); }
	   if($_POST['dateto']!=''){ $this->db->where("date(a.date_purchased) <=", date('Y-m-d',strtotime($_POST['dateto']))); }
       $this->db->limit($limit,$start);
       $this->db->order_by($col,$dir);
       $query =  $this->db->get();
        if($query->num_rows()>0)
        {
            return $query->result(); 
        }
        else
        {
            return null;
        }
    }
   
    function commission_search($limit,$start,$search,$col,$dir)
    {
        $this->db->select("a.orders_id, a.delivery_date, b.final_price as order_amount, c.wallet_transaction_status");
        $this->db->from('orders as a');
        $this->db->join('orders_products as b', 'a.orders_id=b.orders_id','left');
        $this->db->join('users_wallet as c', 'a.orders_id=c.orders_id','left');
        $this->db->like('wallet_transaction_id',$search);
        //$this->db->or_like('shipping_method_name',$search);
        $this->db->limit($limit,$start);
        $this->db->where('a.orders_status', 4);
        $this->db->order_by("a.".$col,$dir);
        $query = $this->db->get();
        
       
        if($query->num_rows()>0)
        {
            return $query->result();  
        }
        else
        {
            return null;
        }
    }


    function commission_search_count($search)
    {
        $this->db->select("a.orders_id, a.delivery_date, b.final_price as order_amount, c.wallet_transaction_status");
        $this->db->from('orders as a');
        $this->db->join('orders_products as b', 'a.orders_id=b.orders_id','left');
        $this->db->join('users_wallet as c', 'a.orders_id=c.orders_id','left');
        $this->db->like('wallet_transaction_id',$search);
        //$this->db->or_like('shipping_method_name',$search);
        $this->db->where('a.orders_status', 4);
        $query = $this->db->get();
        return $query->num_rows();
    }
    
   
}