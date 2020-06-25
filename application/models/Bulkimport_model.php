<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Bulkimport_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->model('Common_model');
    }

    function all_count() {
        $this->db->select("*");
        $this->db->from('product_bulk_import');
       
        
        if ($_POST['datefrom'] != '') {
            $this->db->where("date(date_created) >=", date('Y-m-d', strtotime($_POST['datefrom'])));
        }
        if ($_POST['dateto'] != '') {
            $this->db->where("date(date_created) <=", date('Y-m-d', strtotime($_POST['dateto'])));
        }
        $this->db->order_by('id','DESC');
        $query = $this->db->get();
        return $query->num_rows();
    }

    function all_bulk($limit, $start, $col, $dir) {
        $this->db->select("*");
        $this->db->from('product_bulk_import');
       
        if ($_POST['datefrom'] != '') {
            $this->db->where("date(date_created) >=", date('Y-m-d', strtotime($_POST['datefrom'])));
        }
        if ($_POST['dateto'] != '') {
            $this->db->where("date(date_created) <=", date('Y-m-d', strtotime($_POST['dateto'])));
        }

        if ($limit != '' && $start != '') {
            $this->db->limit($limit, $start);
        }

        $this->db->order_by('id','DESC');
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return null;
        }
    }
    

    

}
