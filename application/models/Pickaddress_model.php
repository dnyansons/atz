<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Pickaddress_model extends CI_Model
{
    private $_table;
    private $_tableDescription;
    public function __construct() 
    {
        parent::__construct();
        $this->load->database();
        $this->load->model('Common_model'); 
        $this->_table = "seller_pick_address";
    }
    
    function alladdr_count($user_id)
    {   
        $query = $this
                ->db
				->where('user_id',$user_id)
                ->get($this->_table);
    
        return $query->num_rows();  

    }
    
    function alladdr($user_id,$limit,$start,$col,$dir)
    {   
        $this->db->select('a.*,b.name');
        $this->db->from('seller_pick_address as a');
        $this->db->join('country as b', 'a.country=b.id', 'left');
		$this->db->where('a.user_id',$user_id);
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
   
    function addr_search($user_id,$limit,$start,$search,$col,$dir)
    {
        
        $this->db->select('a.*,b.name');
        $this->db->from('seller_pick_address as a');
        $this->db->join('country as b', 'a.country=b.id', 'left');
        $this->db->like('a.seller_name',$search);
        $this->db->or_like('a.seller_email',$search);
        $this->db->or_like('a.pincode',$search);
		$this->db->where('a.user_id',$user_id);
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

    function addr_search_count($user_id,$search)
    {
        $query = $this
                ->db
                ->like('seller_name',$search)
                ->or_like('seller_email',$search)
                ->or_like('pincode',$search)
                ->where('user_id',$user_id)
                ->get($this->_table);
    
        return $query->num_rows();
    }
    
  function getaddress($addr_id)
  {
	  $this->db->select('a.*,b.name');
        $this->db->from('seller_pick_address as a');
        $this->db->join('country as b', 'a.country=b.id', 'left');
		$this->db->where('a.pick_id',$addr_id);
       
        $query = $this->db->get();
        
        if($query->num_rows()>0)
        {
            return $query->row_array(); 
        }
        else
        {
            return null;
        }
  }
     
}