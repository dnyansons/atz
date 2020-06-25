<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Collections_model extends CI_Model
{
    private $_table;
    private $_tableDescription;
    public function __construct() 
    {
        parent::__construct();
        $this->load->database();
        $this->_table = "collections";
    }
	
	public function get_collections()
	{
		$this->db->select('id, name');
		$query=$this->db->get('collections');
		return $query->result();
	}
	
	public function addCollection($data)
	{
		$this->db->insert($this->_table,$data);
		return $this->db->insert_id();
	}
	
	public function getCollectionById($id)
	{
		$query = $this->db->get_where($this->_table,array("id"=>$id));
		return $query->row();
	}
	
	public function updateCollection($id,$data)
	{
		$this->db->where(array("id"=>$id));
		if($this->db->update($this->_table,$data)){
			return true; 
		} else {
			return false;
		}
	}
	
	/*
     * Following functions are added to use with server side datatables
     */
    
    function collections_count()
    {   
        $query = $this
                ->db
                ->get($this->_table);
    
        return $query->num_rows();  

    }
    
    function allcollections($limit,$start,$col,$dir)
    {   
       $query = $this
                ->db
                ->limit($limit,$start)
                ->order_by($col,$dir)
                ->get($this->_table);
        
        if($query->num_rows()>0)
        {
            return $query->result(); 
        }
        else
        {
            return null;
        }
        
    }
   
    function collections_search($limit,$start,$search,$col,$dir)
    {
        $query = $this
                ->db
                ->like('id',$search)
                ->or_like('name',$search)
                ->limit($limit,$start)
                ->order_by($col,$dir)
                ->get($this->_table);
        
       
        if($query->num_rows()>0)
        {
            return $query->result();  
        }
        else
        {
            return null;
        }
    }

    function collections_search_count($search)
    {
        $query = $this
                ->db
                ->like('id',$search)
                ->or_like('name',$search)
                ->get($this->_table);
    
        return $query->num_rows();
    }
}	