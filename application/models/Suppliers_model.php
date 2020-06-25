<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Suppliers_model extends CI_Model
{
    private $_table;
    public function __construct() 
    {
        parent::__construct();
        $this->load->database();
        $this->_table = "manufacturers";
    }
    
    public function getAll() 
    {
        $query = $this->db->get($this->_table);
        return $query->result();
    }
    
    public function getUserByEmail($email)
    {
        $query = $this->db->get_where($this->_table,array("email"=>$email));
        return $query->row();
    }
	
    public function getUserById($id)
    {
        $query = $this->db->get_where($this->_table,array("manufacturers_id"=>$id));
        return $query->row();
    }
	
	/*
	 * @param : type Int
	 * @return : type array
	 */
	public function getEmailsByIds($ids)
	{
		$this->db->select("email");
		$this->db->where_in("manufacturers_id",$ids);
		$query = $this->db->get($this->_table);
		return $query->result_array();
	}	
	
	
	/*
     * Following functions are added to use with server side datatables
     */
    
    function allsupplier_count()
    {   
        $query = $this
                ->db
                ->get($this->_table);
    
        return $query->num_rows();  

    }
    
    function allsupplier($limit,$start,$col,$dir)
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
   
    function supplier_search($limit,$start,$search,$col,$dir)
    {
        $query = $this
                ->db
                ->like('manufacturers_id',$search)
                ->or_like('company_name',$search)
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

    function supplier_search_count($search)
    {
        $query = $this
                ->db
                ->like('manufacturers_id',$search)
                ->or_like('company_name',$search)
                ->get($this->_table);
    
        return $query->num_rows();
    }
}
