<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Packages_model extends CI_Model
{
    private $_table;
    private $_tableOrderProduct;
    public function __construct() 
    {
        parent::__construct();
        $this->load->database();
		$this->load->model('Common_model'); 
        $this->_table = "subscription_package";
    }
    
    public function getAll() 
    {
        $query = $this->db->get($this->_table);
        return $query->result(); 
    }
	
	
    function all_pkg_count()
    {   
        
		$this->db->select('*');
		$this->db->from('subscription_package');
		$this->db->limit($limit,$start);
        $this->db->order_by($col,$dir);
		$query = $this->db->get();
		
        return $query->num_rows();  

    }
	
	function product_det($pro_id)
	{
		$this->db->select('*');
		$$this->db->from('subscription_package');
		$query = $this->db->get();
		return $query->row();  
	}
	
	
    
    function allpkg($user_id,$limit,$start,$col,$dir)
    {   
		
			$this->db->select('*');
			$this->db->from('subscription_package');
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
	
	
   
    function pkg_search($user_id,$limit,$start,$search,$col,$dir)
    {
        
		$this->db->select('*');
		$this->db->from('subscription_package');
		$this->db->where("(`pkg_name` LIKE '%".$search."%' ESCAPE '!' OR `pkg_sub_title` LIKE '%".$search."%' ESCAPE '!')");
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
	
	
	function pkg_search_count($user_id,$search)
    {
		
		$this->db->select('*');
		$this->db->from('subscription_package a');
		$this->db->where("(`pkg_name` LIKE '%".$search."%' ESCAPE '!' OR `pkg_sub_title` LIKE '%".$search."%' ESCAPE '!')");
		$this->db->limit($limit,$start);
        $this->db->order_by($col,$dir);
		$query = $this->db->get();
    
        return $query->num_rows();
    }
	
	
	function get_user_pkg_info($user_id)
	{
		$this->db->select('*');
		$this->db->from('user_packages a');
		$this->db->join('subscription_package b','a.pkg_id=b.sub_id','left');
		$this->db->where('a.user_id',$user_id);
		$this->db->where('a.status','Active');
		$query=$this->db->get();
		return $query->row();
	}
	
	function get_all_user_pkg_info($user_id)
	{
		$this->db->select('*');
		$this->db->from('user_packages a');
		$this->db->join('subscription_package b','a.pkg_id=b.sub_id','left');
		$this->db->where('a.user_id',$user_id);
		$this->db->order_by('a.pkg_id');
		$query=$this->db->get();
		return $query->result();
	}
	


}
