<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Returns_model extends CI_Model
{

    function allreturs_count()
    {   
        $query = $this->db->get('order_return');
        return $query->num_rows();  
    }

    
    function allreturns($limit,$start,$col,$dir)
    {   
        $this->db->select("*"); 
        $this->db->from("order_return"); 
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
   

    function returns_search($limit,$start,$search,$col,$dir)
    {
        $this->db->select("*"); 
        $this->db->from("order_return"); 
        $this->db->limit($limit,$start);
        $this->db->like('return_id',$search);
        $this->db->or_like('orders_id',$search);
        $this->db->or_like('products_name',$search);
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
        $this->db->from("order_return"); 
        $this->db->limit($limit,$start);
        $this->db->like('return_id',$search);
        $this->db->or_like('orders_id',$search);
        $this->db->or_like('products_name',$search);
        $this->db->order_by($col,$dir);
        $query = $this->db->get();
    
        return $query->num_rows();
    }
    

    public function view_returns_data($return_id)
    {
    	$this->db->where('return_id', $return_id);
        $query=$this->db->get('order_return');
        return $query->row();
    }
    
	
}
