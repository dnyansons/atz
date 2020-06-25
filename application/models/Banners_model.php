<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Banners_model extends CI_Model {

    private $_table;
    private $_tableDescription;

    public function __construct() 
    {
        parent::__construct();
        $this->load->database();
        $this->_table = "banners";
        $this->_bannerMobile = "app_banner";
    }

    function get_active_banners() 
    {
        $this->db->select('*');
        $this->db->where(array(
            "status" => 1,
            "expire_date >=" => date("Y-m-d")
        ));
		$this->db->from('banners b');
		$this->db->join('categories_description c','b.category = c.id','left');
        $this->db->order_by("sort_order", "asc");
        $query = $this->db->get();
        return $query->result_array();
    }
    
    function get_all_banners() 
    {
        $this->db->select('*');
        $this->db->where(array(
            "expire_date >=" => date("Y-m-d")
        ));
		$this->db->from('banners b');
		$this->db->join('categories_description c','b.category = c.id','left');
        $this->db->order_by("sort_order", "asc");
        $query = $this->db->get();
        return $query->result_array();
    }

    function get_active_banners_for_mobile() {
        $this->db->where(array(
            "status" => "Active",
        ));
        $query = $this->db->get($this->_bannerMobile);
        return $query->result_array();
    }

     function get_active_banners_for_mobilebottom() {
        $this->db->where(array(
            "status" => "Active",
            "image_placed" => "bottom",
        ));
        $query = $this->db->get($this->_bannerMobile);
        return $query->result_array();
    }


    function add_banner($arr) {
        return $this->db->insert($this->_table, $arr);
    }

    function get_banners($id) {
        $this->db->where('banners_id', $id);
        return $this->db->get($this->_table)->row();
    }

    function edit_banner($id, $arr) {
        $this->db->where('banners_id', $id);
        return $this->db->update($this->_table, $arr);
    }

    function delete_banner($id) {
        $this->db->where('banners_id', $id);
        return $this->db->delete($this->_table);
    }

}
