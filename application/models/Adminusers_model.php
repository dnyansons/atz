<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Adminusers_model extends CI_Model
{
    private $_table;
    public function __construct() 
    {
        parent::__construct();
        $this->load->database();
        $this->_table = "admin";
    }
    
    public function getAll() 
    {
        $query = $this->db->get($this->_table);
        return $query->result();
    }
    
    public function getUserByUsername($username)
    {
        $query = $this->db->get_where($this->_table,array("admin_username"=>$username));
        return $query->row();
    }
}
