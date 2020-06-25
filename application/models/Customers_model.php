<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Customers_model extends CI_Model
{
    private $_table;
    public function __construct() 
    {
        parent::__construct();
        $this->load->database();
        $this->_table = "customers";
    }
    
    public function getAll() 
    {
        $query = $this->db->get($this->_table);
        return $query->result();
    }
}
