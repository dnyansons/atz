<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Refund_model extends CI_Model
{
   
    public function __construct() 
    {
        parent::__construct();
        $this->load->database();
		$this->load->model('Common_model');
    }
    
	
    function allrefund_count($id)
    {   
        $this->db->select('*');
		$this->db->from('orders a');
		//$this->db->join('orders_products b', 'b.orders_id = a.orders_id');
		$this->db->join('order_refund c', 'a.orders_id = c.orders_id');

		$this->db->where('a.user_id',$id);
		$this->db->group_by('a.orders_id');
		$query = $this->db->get();
        return $query->num_rows();  

    }
	
	function single_refund($id)
    {   
        $this->db->select('*');
		$this->db->from('orders a');
		$this->db->join('orders_products b', 'b.orders_id = a.orders_id');
		$this->db->join('order_refund c', 'a.orders_id = c.orders_id');
		//$this->db->join('order_refund_history d', 'a.orders_id = d.orders_id', 'left');
		$this->db->join('refund_reason e', 'e.reason_id = c.reason_id', 'left');  
		$this->db->where('a.orders_id',$id);
		$query = $this->db->get();
		return $query->result();  
    }
	function refund_history($id)
    {   
        $this->db->select('*');
		$this->db->from('order_refund_history');
		$this->db->where('orders_id',$id);
		$query = $this->db->get();
		return $query->result();  
    }
    
    function allrefund($ret_id,$limit,$start,$col,$dir)
    {   

		$this->db->select('*,a.order_price f_price');
		$this->db->from('orders a');
		//$this->db->join('orders_products b', 'b.orders_id = a.orders_id');
		$this->db->join('order_refund c', 'a.orders_id = c.orders_id');
		$this->db->where('a.user_id',$ret_id);
		$this->db->limit($limit,$start);
		$this->db->group_by('a.orders_id');
        $this->db->order_by($col,$dir);
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
   
    function refund_search($ret_id,$limit,$start,$search,$col,$dir)
    {
        $this->db->select('*');
		$this->db->from('orders a');
		//$this->db->join('orders_products b', 'b.orders_id = a.orders_id');
		$this->db->join('order_refund c', 'a.orders_id = c.orders_id');
		$this->db->where('a.user_id',$ret_id);
		$this->db->where("(`a`.`user_id` LIKE '%".$search."%' ESCAPE '!' OR `c`.`orders_status` LIKE '%".$search."%' ESCAPE '!')");
		$this->db->limit($limit,$start);
		$this->db->group_by('a.orders_id');
        $this->db->order_by($col,$dir);
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

    function refund_search_count($ret_id,$search) 
    {
        $this->db->select('*');
		$this->db->from('orders a');
		//$this->db->join('orders_products b', 'b.orders_id = a.orders_id');
		$this->db->join('order_refund c', 'a.orders_id = c.orders_id');
		$this->db->where('a.user_id',$ret_id);
		$this->db->where("(`a`.`user_id` LIKE '%".$search."%' ESCAPE '!' OR `c`.`orders_status` LIKE '%".$search."%' ESCAPE '!')");
		$this->db->group_by('a.orders_id');
		$query = $this->db->get();
    
        return $query->num_rows();
    }

	//<!-- End For  Buyer -->//
	//<!-- End For  Buyer -->//
	
	
	//<!-- Start For  Supplier -->//
	//<!-- Start For  Supplier -->//
	function allrefund_count_supplier($id)
    {   
        $this->db->select('*');
		$this->db->from('orders a');
		//$this->db->join('orders_products b', 'b.orders_id = a.orders_id');
		$this->db->join('order_refund c', 'a.orders_id = c.orders_id');
		//$this->db->join('product_details d', 'b.products_id = d.id');

		$this->db->where('c.seller',$id);
		$this->db->group_by('a.orders_id');
		$query = $this->db->get();
        return $query->num_rows();  

    }
	
	function single_refund_supplier($id)
    {   
        $this->db->select('*');
		$this->db->from('orders a');
		$this->db->join('orders_products b', 'b.orders_id = a.orders_id');
		$this->db->join('order_refund c', 'a.orders_id = c.orders_id');
		$this->db->join('order_refund_history d', 'a.orders_id = d.orders_id', 'left');
		$this->db->join('refund_reason e', 'e.reason_id = c.reason_id', 'left');  
		$this->db->where('a.orders_id',$id);

		$this->db->group_by('a.orders_id');
		$query = $this->db->get();
		return $query->result();  
    }
    
    function allrefund_supplier($ret_id,$limit,$start,$col,$dir)
    {   

		$this->db->select('*,order_price as f_price');

		$this->db->from('orders a');
		//$this->db->join('orders_products b', 'b.orders_id = a.orders_id');
		$this->db->join('order_refund c', 'a.orders_id = c.orders_id');
		//$this->db->join('product_details d', 'b.products_id = d.id');

		$this->db->where('c.seller',$ret_id);
		$this->db->group_by('a.orders_id');

		$this->db->limit($limit,$start);
        $this->db->order_by($col,$dir);
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
   
    function refund_search_supplier($ret_id,$limit,$start,$search,$col,$dir)
    {
        $this->db->select('*');
		$this->db->from('orders a');
		//$this->db->join('orders_products b', 'b.orders_id = a.orders_id');
		$this->db->join('order_refund c', 'a.orders_id = c.orders_id');
		//$this->db->join('product_details d', 'b.products_id = d.id');

		$this->db->where('c.seller',$ret_id);
		$this->db->where("(`c`.`seller` LIKE '%".$search."%' ESCAPE '!' OR `c`.`orders_status` LIKE '%".$search."%' ESCAPE '!')");
		$this->db->limit($limit,$start);
		$this->db->group_by('a.orders_id');
        $this->db->order_by($col,$dir);
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

    function refund_search_count_supplier($ret_id,$search) 
    {
        $this->db->select('*');
		$this->db->from('orders a');
		//$this->db->join('orders_products b', 'b.orders_id = a.orders_id');
		$this->db->join('order_refund c', 'a.orders_id = c.orders_id');
		//$this->db->join('product_details d', 'b.products_id = d.id');

		$this->db->where('c.seller',$ret_id);
		$this->db->where("(`a`.`user_id` LIKE '%".$search."%' ESCAPE '!' OR `c`.`orders_status` LIKE '%".$search."%' ESCAPE '!')");
		$this->db->group_by('a.orders_id');
		$query = $this->db->get();
    
        return $query->num_rows();
    }


    

    /////////////////
    ////////////////

    // BELOW FOR ADMIN //////////////////////////////////////////////////////////////
	
	
	/////////////////
    ////////////////

    /*THis is old function */

/*    function allrefunds_count_admin()
    {   
    	$this->db->select('*');
		$this->db->from('orders a');
		//$this->db->join('orders_products b', 'b.orders_id = a.orders_id');
		$this->db->join('order_refund c', 'a.orders_id = c.orders_id');
		//$this->db->join('product_details d', 'b.products_id = d.id');

		$this->db->where('c.seller',$id);
		$this->db->group_by('a.orders_id');
		$query = $this->db->get();
        return $query->num_rows();  
    }*/

    function allrefunds_count_admin()
    {

    $this->db->select("*");
       $this->db->from('orders as a');
       $this->db->join('order_refund c', 'a.orders_id = c.orders_id');
       if($_POST['order_id']!=''){ $this->db->where("concat('ORD',a.orders_id)",$_POST['order_id']); }
       if($_POST['vendor_id']!=''){ $this->db->where("concat('ATZ',a.seller_id)",$_POST['vendor_id']); }
       // if($_POST['order_status']!=''){ $this->db->where("a.orders_status",$_POST['order_status']); }
       if($_POST['datefrom']!=''){ $this->db->where("date(a.date_purchased) >=",date('Y-m-d',strtotime($_POST['datefrom']))); }
       if($_POST['dateto']!=''){ $this->db->where("date(a.date_purchased) <=", date('Y-m-d',strtotime($_POST['dateto']))); }
       $query =  $this->db->get();
        return $query->num_rows();
    }
    
    function allrefunds_admin($limit,$start,$col,$dir)
    {

       $this->db->select("*");
       $this->db->from('orders as a');
       $this->db->join('order_refund c', 'a.orders_id = c.orders_id');
       if($_POST['order_id']!=''){ $this->db->where("concat('ORD',a.orders_id)",$_POST['order_id']); }
       if($_POST['vendor_id']!=''){ $this->db->where("concat('ATZ',a.seller_id)",$_POST['vendor_id']); }
       // if($_POST['order_status']!=''){ $this->db->where("a.orders_status",$_POST['order_status']); }
       if($_POST['datefrom']!=''){ $this->db->where("date(c.created_at) >=",date('Y-m-d',strtotime($_POST['datefrom']))); }
       if($_POST['dateto']!=''){ $this->db->where("date(c.created_at) <=", date('Y-m-d',strtotime($_POST['dateto']))); }
       $this->db->limit($limit,$start);
       if($dir == "asc")
       {
           $this->db->order_by($col,"desc");
       }else{
           $this->db->order_by($col,"asc");
       }

       $query =  $this->db->get();

        return $query->result();
    }
   

    function refunds_search_admin($limit,$start,$search,$col,$dir)
    {
        $this->db->select('*');
		$this->db->from('orders a');
		//$this->db->join('orders_products b', 'b.orders_id = a.orders_id');
		$this->db->join('order_refund c', 'a.orders_id = c.orders_id');
		//$this->db->join('product_details d', 'b.products_id = d.id');

		
		$this->db->where("(`c`.`orders_status` LIKE '%".$search."%' ESCAPE '!')");
		$this->db->limit($limit,$start);
		$this->db->group_by('a.orders_id');
        $this->db->order_by($col,$dir);
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


    function refunds_search_count_admin($limit,$start,$search,$col,$dir)
    {
        $this->db->select('*');
		$this->db->from('orders a');
		//$this->db->join('orders_products b', 'b.orders_id = a.orders_id');
		$this->db->join('order_refund c', 'a.orders_id = c.orders_id');
		//$this->db->join('product_details d', 'b.products_id = d.id');

		
		$this->db->where("(`c`.`orders_status` LIKE '%".$search."%' ESCAPE '!')");
		$this->db->group_by('a.orders_id');
		$query = $this->db->get();
    
        return $query->num_rows();
    }
    

    public function view_refunds_data_admin($orders_id)
    {

        $this->db->select('*');
        $this->db->from('orders a');
        $this->db->join('orders_products b', 'b.orders_id = a.orders_id');
        $this->db->join('order_refund c', 'a.orders_id = c.orders_id');
        //$this->db->join('order_refund_history d', 'a.orders_id = d.orders_id', 'left');
        $this->db->join('refund_reason e', 'e.reason_id = c.reason_id', 'left');  
        $this->db->where('a.orders_id',$orders_id);
        $query = $this->db->get();
        return $query->result();
    }


    public function update_status_data_admin($orders_id, $status)
    {
        $this->db->set('comment', $status);
        $this->db->where('orders_id',$orders_id);
        $this->db->update('order_refund_history'); 

        $this->db->set('orders_status', $status);
        $this->db->where('orders_id',$orders_id);
        $this->db->update('order_refund'); 

        return true;
    }
    
    
    
    
    ///amount refund to buyer wallet
    function refund_to_buyer($user_id=0,$order_id=0,$amount=0)
    {
          // Total Order Price Refunded (+ Shipping Cost)
        $get_order = $this->Common_model->getAll('orders', array('orders_id' => $order_id))->row();
        
        $insertwallet['user_id'] = $user_id;
        $insertwallet['status'] = 1;
        $insertwallet['created'] = date('Y-m-d H:i:s');
        $insertwallet['updated'] = date('Y-m-d H:i:s');
        $insertwallet['balance'] = $amount;

        //Check entry in main wallet
        $ch_user = $this->Common_model->getAll('buyer_wallet', array('user_id' => $user_id))->num_rows();
        if ($ch_user > 0) {
            $exist_wallet_bal_q = $this->Common_model->getAll('buyer_wallet', array('user_id' => $user_id))->row();
            $dat['balance'] = $exist_wallet_bal_q->balance + $amount;
            $dat['updated'] = date('Y-m-d H:i:s');
            $this->Common_model->update('buyer_wallet', $dat, array('user_id' => $user_id));
            
            //Insert History
            $his['buyer_id'] = $user_id;
            $his['previous_amount'] =$exist_wallet_bal_q->balance;
            $his['current_amount'] = $exist_wallet_bal_q->balance + $get_order->order_price;
            $his['amount'] = $amount;
            $his['transaction_type'] ='credit';
            $his['against'] ='refund';
            $his['referrence'] = '#' . $order_id;
            $his['remark'] = 'Amount add to Wallet against Order # ' . $order_id;
            $his['status'] = 1;
            $this->Common_model->insert('buyer_wallet_history', $his); 
        } else {
            $this->Common_model->insert('buyer_wallet', $insertwallet);
        }

        
    }
    
    
    
    ///amount refund to buyer wallet
    function deduct_from_seller($seller_id,$order_id,$amount)
    {
       
        //Check entry in main wallet
        $ch_user = $this->Common_model->getAll('wallet_vendor', array('vendor_id' => $seller_id))->num_rows();
        if ($ch_user > 0) {
            //from Pending
            $exist_wallet_bal_q = $this->Common_model->getAll('wallet_vendor', array('vendor_id' => $seller_id))->row();
            $dat['available_balance'] = $exist_wallet_bal_q->available_balance - $amount;
            $dat['updated_at'] = date('Y-m-d H:i:s');
            $up=$this->Common_model->update('wallet_vendor', $dat, array('vendor_id' => $seller_id));
            
            
            if($up)
            {
                //Insert History
                $his['vendor_id'] = $seller_id;
                $his['order_id'] = $order_id;
                $his['amount'] = $amount; 
                $his['type'] ='debit';
                $his['remark'] = 'Amount ( Shipping Cost ) Deduct from  Wallet against Order  # ' . $order_id;
                $his['status'] = 'deduct';
                $his['date'] = date('Y-m-d H:i:s');
                $his['approved_by'] =$this->session->userdata("admin_id");
                $this->Common_model->insert('wallet_vendor_history', $his); 
            }
            
        } 

        
    }
    


}
