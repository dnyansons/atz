<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Insights_model extends CI_Model
{
	private $_table,$_tableDescription,$_tableManufacturer;
    public function __construct() 
    {
       parent::__construct();
	   $this->_table = "insights_recommended";
	   $this->_tableDescription = "atz_insight_description";
	   $this->_tableManufacturer = "manufacturers";
    }
	
	function all_recommended_count($supplier = 0)
    {   
        $this->db->select('id');
        $this->db->from('insights_recommended');
        $query=$this->db->get();
        return $query->num_rows();  
    }
	
	function all_recommended($limit,$start,$col,$dir)
    {   
		$this->db->select('*');
		$this->db->from('insights_recommended');
		$this->db->limit($limit,$start);
		$this->db->order_by($col,$dir);
      
		$query = $this->db->get();
		
		if($query->num_rows()>0) {
			return $query->result(); 
		} else {
			return null;
		}
        
    }
}