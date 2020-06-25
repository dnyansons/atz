<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Subscribers_model extends CI_Model
{
    private $_table;
    public function __construct() 
    {
        parent::__construct();
        $this->load->database();
		$this->_tableSubcription = "subscription_package";
        $this->_table = "mail_subscriptions";
		$this->_tableEmailSubcription = "email_subscriptions";
	}
    
    public function getAll() 
    {
        $query = $this->db->get($this->_table);
        return $query->result();
    }
	
	public function addNew($data)
	{
		$this->db->insert($this->_table,$data);
		return $this->db->insert_id();
	}
	
	function get_subcription_packages()
	{
		$this->db->where("status","Active");
		$query = $this->db->get($this->_tableSubcription);
        return $query->result_array();
	}
	
	function add_subcription_emails($arr)
	{
		$this->db->where('email',$arr['email']);
		$this->db->from($this->_tableEmailSubcription);
		$query = $this->db->get();
		if($query->num_rows() > 0){
			return false;
		}else{
			return $this->db->insert($this->_tableEmailSubcription,$arr);
		}
	}
}
