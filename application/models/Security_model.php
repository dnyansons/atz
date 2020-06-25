<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Security_model extends CI_Model
{
    private $_table;
    private $_tableDescription;
    public function __construct() 
    {
        parent::__construct();
        $this->load->database();
        $this->_table = "security_questions";
    }
	
	function get_list($id)
	{
		if($id<>'')
		{
			$this->db->where('id',$id);
			return $this->db->get($this->_table)->row();
		}else{
			return $this->db->get($this->_table)->result_array();
		}
	}
	
	function add_questions($id,$arr)
	{
		if($id<>''){
			$this->db->where('id',$id);
			return $this->db->update($this->_table,$arr);
		}else{
			return $this->db->insert($this->_table,$arr);
		}
	}
	
	function delete_questions($id)
	{
		$this->db->where('id',$id);
		return $this->db->delete($this->_table);
	}
}