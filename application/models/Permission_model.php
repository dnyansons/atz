<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Permission_model extends CI_Model {

    private $_table;
    private $_tableDescription;

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->model('Common_model');
        $this->_table = "admin";
    }

    function alluser_count() {
        $query = $this
                ->db
                ->get($this->_table);

        return $query->num_rows();
    }

    function alluser($limit, $start, $col, $dir) {
        $this->db->select('*,a.status as admin_status');
        $this->db->from('admin as a');
        $this->db->join('admin_role as c', 'a.admin_role=c.role_id');
        $this->db->join('country as b', 'a.country=b.id', 'left');
        $this->db->limit($limit, $start);
        $this->db->order_by($col, $dir);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return null;
        }
    }

    function user_search($limit, $start, $search, $col, $dir) {
        $this->db->select('*,a.status as admin_status');
        $this->db->from('admin as a');
        $this->db->join('admin_role as c', 'a.admin_role=c.role_id');
        $this->db->join('country as b', 'a.country=b.id', 'left');
        $this->db->like('a.admin_id', $search);
        $this->db->like('a.admin_firstname', $search);
        $this->db->like('a.admin_username', $search);
        $this->db->or_like('a.admin_role', $search);
        $this->db->or_like('a.admin_telephone', $search);
        $this->db->limit($limit, $start);
        $this->db->order_by('a.' . $col, $dir);
        $query = $this->db->get();


        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return null;
        }
    }

    function user_search_count($search) {
        $query = $this
                ->db
                ->like('admin_id', $search)
                ->or_like('admin_firstname', $search)
                ->or_like('admin_username', $search)
                ->or_like('admin_telephone', $search)
                ->get($this->_table);

        return $query->num_rows();
    }

    function get_menu($user_id = 0) {
        $ch_exist = $this->Common_model->getAll('user_permission', array('user_id' => $user_id))->num_rows();

        if ($ch_exist > 0) {
            $this->db->select('*');
            $this->db->from('user_permission as a');
            $this->db->join('menu_master as b', 'a.menu_id=b.menu_id AND a.user_id=' . $user_id . '');
            //$this->db->order_by('b.menu_id', 'asc');
            $this->db->order_by('b.sort_by', 'asc');
             $this->db->group_by('b.menu_id');
        } else {
            $this->db->select('*');
            $this->db->from('menu_master a');
            $this->db->order_by('a.menu_id', 'asc');
            $this->db->order_by('a.sort_by', 'asc');
        }

        $query = $this->db->get();


        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return null;
        }
    }

    function get_user($user_id) {
        $this->db->select('*,a.status as admin_status');
        $this->db->from('admin as a');
        $this->db->join('admin_role as c', 'a.admin_role=c.role_id');
        $this->db->join('country as b', 'a.country=b.id', 'left');
        $this->db->where('a.admin_id', $user_id);
        return $this->db->get();
    }

    function user_permission($user_id) {

        $this->db->select('*');
        $this->db->from('user_permission as a');
        $this->db->join('menu_master as b', 'a.menu_id=b.menu_id AND a.user_id=' . $user_id . '');
        $this->db->order_by('a.menu_id');
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return null;
        }
    }

    function get_main_menu() {
        $this->db->select('*');
        $this->db->from('menu_master');
        $this->db->where('parent_id', 0);
        $this->db->order_by('menu_id');
        $query = $this->db->get();
        return $query->result();
    }

}
