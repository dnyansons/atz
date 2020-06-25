<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Bank_model extends CI_Model {

    private $_table;
    private $_tableDescription;

    public function __construct() 
    {
        parent::__construct();
        $this->load->database();
        $this->_table = "supplier_bank_details";
        $this->_bank = "banks";
    }
	
    function addUserBank($arr) {
		if($arr['is_default'] == 1)
		{
			$this->db->set('is_default',0);
			$this->db->where('user_id',$arr['user_id']);
			$query = $this->db->update($this->_table);
			if($query)
			{
				return $this->db->insert($this->_table,$arr);
			}
		}else{
			return $this->db->insert($this->_table,$arr);
		}
    }

    function getBankDetailsList($id) {
		$this->db->select('sb. id,account_no,bank_name,ifsc_code,account_holder_name,is_default,created_date');
		$this->db->from("supplier_bank_details sb");
		$this->db->join("banks b","sb.bank=b.id");
        $this->db->where('user_id', $id);
        return $this->db->get()->result_array();
    }
	
	function getBanks()
	{
		return $this->db->get($this->_bank)->result_array();
	}
	
	function getUserBanksDetails($id) {
        $this->db->where('id', $id);
        return $this->db->get($this->_table)->row();
    }
	
	function editUserBank($arr,$id) {
		if($arr['is_default'] == 1)
		{
			$this->db->set('is_default',0);
			$this->db->where('user_id',$arr['user_id']);
			$query = $this->db->update($this->_table);
			if($query)
			{
				$this->db->where('id',$id);
				return $this->db->update($this->_table,$arr);
			}
		}else{
			$this->db->where('id',$id);
			return $this->db->update($this->_table,$arr);
		}
    }
   
    public function get_datatables()
    {
        if($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get($this->_bank);
        return $query->result();
    }
    
    public function count_filtered()
    {
        $query = $this->db->get($this->_bank);
        return $query->num_rows();
    }
    
    public function count_all()
    {
        $this->db->from($this->_bank);
        return $this->db->count_all_results();
    }
}
