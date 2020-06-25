<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Returns_model extends CI_Model
{
	
    function allreturs_count()
    {   
        $query = $this->db->get('return_orders');
		
        return $query->num_rows();  
    }

    function allreturns($limit,$start,$col,$dir)
    {   
        $this->db->select("ro.*,od.orders_status_name,u.first_name as sellername,u.last_name as sellerlastname,u1.first_name as username,u1.last_name as userlastname"); 
        $this->db->from("return_orders ro");
		$this->db->join("users u","u.id=ro.seller_id");
		$this->db->join("users u1","u1.id=ro.user_id");
		//$this->db->join("return_orders_products rod","rod.return_orders_id=ro.return_orders_id");
		//$this->db->join("refund_reason rfr","rfr.reason_id=ro.return_reason");
		$this->db->join("orders_status od","od.orders_status_id=ro.orders_status");
        $this->db->limit($limit,$start);
        if($dir == "asc")
        {
            $this->db->order_by($col,"desc");
        }else{
            $this->db->order_by($col,"asc");
        }
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
   
    function returns_search($limit,$start,$search,$col,$dir)
    {
		$this->db->select("ro.*,u.first_name as sellername,u.last_name as sellerlastname,u1.first_name as username,u1.last_name as userlastname"); 
        $this->db->from("return_orders ro");
		$this->db->join("users u","u.id=ro.seller_id");
		$this->db->join("users u1","u1.id=ro.user_id");
		//$this->db->join("return_orders_products rod","rod.return_orders_id=ro.return_orders_id");
		//$this->db->join("refund_reason rfr","rfr.reason_id=ro.return_reason");
        $this->db->limit($limit,$start);
       // $this->db->like('rod.return_orders_id',$search);
        $this->db->or_like('ro.orders_id',$search);
        $this->db->or_like('u.first_name',$search);
        $this->db->or_like('u.last_name',$search);
        //$this->db->or_like('rod.products_name',$search);
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

    function returns_search_count($limit,$start,$search,$col,$dir)
    {
        $this->db->select("*"); 
        $this->db->from("return_orders"); 
        $this->db->limit($limit,$start);
        $this->db->like('return_orders_id',$search);
        $this->db->or_like('orders_id',$search);
        //$this->db->or_like('products_name',$search);
        $this->db->order_by($col,$dir);
        $query = $this->db->get();
        return $query->num_rows();
    }
    
    public function view_returns_data($return_id)
    {
    	$this->db->where('return_orders_id', $return_id);
        $query=$this->db->get('return_orders');
        return $query->row();
    }
    
	 public function view_return_data_admin($orders_id)
    {
        $this->db->select('a.*,os.orders_status_name,rop.products_name,rop.final_price,rop.products_quantity,rfr.reason_name');
        $this->db->from('return_orders a');
		$this->db->join('orders_status os','os.orders_status_id=a.orders_status');
		$this->db->join('return_orders_products rop','rop.return_orders_id=a.return_orders_id');
		$this->db->join('refund_reason rfr','rfr.reason_id=a.return_reason');
        $this->db->where('a.return_orders_id',$orders_id);
        $query = $this->db->get();
        return $query->result();
    }
	
	function return_orders_history($id)
    {   
        $this->db->select('*');
		$this->db->from('return_orders_history');
		$this->db->where('orders_id',$id);
		$query = $this->db->get();
		return $query->result();  
    }
	
}
