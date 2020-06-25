<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Sellersalesreport_model extends CI_Model
{

    public function __construct() 
    {
        parent::__construct();
    }

    /*
     * Following functions are added to use with server side datatables
     */
    
    function allsales_count()
    {   
       $this->db->select("concat('ORD',a.orders_id) as orders_id,concat('ATZ',a.seller_id) as seller_id,a.orders_status,a.shipping_cost,a.vendor_payable_price,a.order_price,a.date_purchased,concat(b.first_name,' ',b.last_name) as buyername,b.email as buyeremail,b.phone as buyerphone,concat(c.first_name,' ',c.last_name) as vendorname,c.phone as vendorphone,d.orders_status_name,e.payment_id");
       $this->db->from('orders as a');
       $this->db->join('users as b', 'a.user_id=b.id','left');
       $this->db->join('users as c', 'a.seller_id=c.id','left');
       $this->db->join('orders_status as d', 'd.orders_status_id=a.orders_status','left');
       $this->db->join('order_payment as e', 'e.orders_id=a.orders_id','left');
	   if($_POST['order_id']!=''){ $this->db->where("concat('ORD',a.orders_id)",$_POST['order_id']); }
	   if($_POST['vendor_id']!=''){ $this->db->where("a.seller_id",$this->session->userdata("user_id")); }
	   if($_POST['order_status']!=''){ $this->db->where("a.orders_status",$_POST['order_status']); }
	   if($_POST['datefrom']!=''){ $this->db->where("date(a.date_purchased) >=",date('Y-m-d',strtotime($_POST['datefrom']))); }
	   if($_POST['dateto']!=''){ $this->db->where("date(a.date_purchased) <=", date('Y-m-d',strtotime($_POST['dateto']))); }
       $query =  $this->db->get();
        return $query->num_rows();
    }
    

    function allsales($limit,$start,$col,$dir)
    {
       $this->db->select("concat('ORD',a.orders_id) as orders_id,concat('ATZ',a.seller_id) as seller_id,a.orders_status,a.shipping_cost,a.vendor_payable_price,a.order_price,a.date_purchased,concat(b.first_name,' ',b.last_name) as buyername,b.email as buyeremail,b.phone as buyerphone,concat(c.first_name,' ',c.last_name) as vendorname,c.phone as vendorphone,d.orders_status_name,e.payment_id,a.commission,a.gst");
       $this->db->from('orders as a');
       $this->db->join('users as b', 'a.user_id=b.id','left');
       $this->db->join('users as c', 'a.seller_id=c.id','left');
       $this->db->join('orders_status as d', 'd.orders_status_id=a.orders_status','left');
       $this->db->join('order_payment as e', 'e.orders_id=a.orders_id','left');
	   if($_POST['order_id']!=''){ $this->db->where("concat('ORD',a.orders_id)",$_POST['order_id']); }
	   if($_POST['vendor_id']!=''){ $this->db->where("a.seller_id",$this->session->userdata("user_id")); }
	   if($_POST['order_status']!=''){ $this->db->where("a.orders_status",$_POST['order_status']); }
	   if($_POST['datefrom']!=''){ $this->db->where("date(a.date_purchased) >=",date('Y-m-d',strtotime($_POST['datefrom']))); }
	   if($_POST['dateto']!=''){ $this->db->where("date(a.date_purchased) <=", date('Y-m-d',strtotime($_POST['dateto']))); }
	   if($_POST['order_status'] =='')
        {
            $this->db->where('d.orders_status_id=10');
        }
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
   
    function sales_search($limit,$start,$search,$col,$dir)
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


    function sales_search_count($search)
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