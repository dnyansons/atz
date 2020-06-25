<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class App_model extends CI_Model
{

    public function __construct() 
    {
        parent::__construct();
    }


    function getAllData($id)
    {
        $this->db->where('id', $id);
        $query=$this->db->get('app_info');
        return $query->row();
    }

}