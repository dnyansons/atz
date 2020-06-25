<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Stores_model extends CI_Model
{
    private $_table,$_tableAddress;
    public function __construct() 
    {
        parent::__construct();
        $this->load->database();
        $this->_table = "retailers";
		$this->_tableAddress = "address_book";
    }
    
    public function getAll() 
    {
        $query = $this->db->get($this->_table);
        return $query->result();
    }
    
    public function getUserByEmail($email)
    {
        $query = $this->db->get_where($this->_table,array("retailers_email_address"=>$email));
        return $query->row();
    }
	
	public function getUserById($id)
    {
        $query = $this->db->get_where($this->_table,array("retailers_id"=>$id));
        return $query->row();
    }
	
	public function addUser($data)
	{
		$this->db->insert($this->_table,$data);
		return $this->db->insert_id();
	}
	
	public function addUserAddressBook($data)
	{
		$this->db->insert($this->_tableAddress,$data);
		return $this->db->insert_id();
	}
	
	public function getUserAddressBook($id)
	{
		$query = $this->db->get_where($this->_tableAddress,array("retailers_id"=>$id));
		return $query->row();
	}
	
	/*
	 * @param : type Int
	 * @return : type array
	 */
	public function getEmailsByIds($ids)
	{
		$this->db->select("email");
		$this->db->where_in("retailers_id",$ids);
		$query = $this->db->get($this->_table);
		return $query->result_array();
	}	
	
	
	/*
     * Following functions are added to use with server side datatables
     */
    
    function allstore_count()
    {   
        $query = $this
                ->db
                ->get($this->_table);
    
        return $query->num_rows();  

    }
    
    function allstore($limit,$start,$col,$dir)
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
   
    function store_search($limit,$start,$search,$col,$dir)
    {
        $query = $this
                ->db
                ->like('retailers_id',$search)
                ->or_like('retailers_email_address',$search)
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

    function store_search_count($search)
    {
        $query = $this
                ->db
                ->like('retailers_id',$search)
                ->or_like('retailers_email_address',$search)
                ->get($this->_table);
    
        return $query->num_rows();
    }
}
