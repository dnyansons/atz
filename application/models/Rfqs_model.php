<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Rfqs_model extends CI_Model {

    private $_table;
    private $_tablemap;
    private $_tablesupplier;

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->_table = "rfqs";
        $this->_tablemap = "rfq_to_seller";
        $this->_tableunit = "units";
        $this->_tableusers = "users";
        $this->_tablesellercompanydetails = "seller_company_details";
    }

    function read_rfq_notification() {
        $this->Common_model->update('admin_notification', ['status' => 'Read'], ['status' => 'Received', 'type' => 'RFQ']);
    }

    public function addRfq($arr) {
        $this->db->insert($this->_table, $arr);
        return $this->db->insert_id();
    }

    public function editRfq($arr, $id) {
        $this->db->where('id', $id);
        return $this->db->update($this->_table, $arr);
    }

    public function addRfqToSuppliers($data) {
        $this->db->insert_batch($this->_tablemap, $data);
    }

    public function getRfqById($id) {
        $query = $this->db->get_where($this->_table, array("id" => $id));
        return $query->row();
    }

    public function getRfqByUser($id) {
        $query = $this->db->order_by('id', 'desc')->get_where($this->_table, array("customer_id" => $id));
        return $query->result();
    }

    public function getRfqsBySupplier($id) {
        $this->db->select("R1.*,R2.id as rply_id,R2.reply, R2.status,R2.comment,R2.attachment, R2.rfq_id, units_name, R2.forwarded_date");
        $this->db->from($this->_table . " R1");
        $this->db->join($this->_tablemap . " R2", "R1.id = R2.rfq_id AND R2.seller_id = " . $id);
        $this->db->join($this->_tableunit . " u", "u.units_id = R1.unit");
        $this->db->order_by("R1.id", "desc");
        return $this->db->get()->result();
    }

    public function addReplyToRfq($id, $data) {
        $this->db->update($this->_tablemap, $data, ["id" => $id]);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    /*
     * Following functions are added to use with server side datatables
     */

    function rfqs_count($datefrom, $dateto) {
        $this->db->from($this->_table . " r");
        if ($datefrom != '') {
            $this->db->where("date(r.added_date) >=", date('Y-m-d', strtotime($datefrom)));
        }
        if ($dateto != '') {
            $this->db->where("date(r.added_date) <=", date('Y-m-d', strtotime($dateto)));
        }
        $query = $this->db->get();
        return $query->num_rows();
    }

    function allrfqs($datefrom, $dateto, $limit, $start, $col, $dir) {
        /* $this
          ->db
          ->select('r.id, us.first_name, us.last_name, r.looking_for, r.quanity, r.status, units_name, r.description, r.is_forwarded')
          ->limit($limit, $start)
          ->order_by($col, $dir)
          ->from($this->_table . ' r')
          ->join('users us','r.customer_id = us.id','LEFT')
          ->join('units u','r.unit = u.units_id','LEFT'); */



        $this->db->select('r.attachments,r.id, us.first_name, us.last_name, r.looking_for, r.quanity, r.status, units_name, r.description, r.is_forwarded');
        $this->db->limit($limit, $start);
        $this->db->order_by($col, $dir);
        $this->db->from($this->_table . ' r');
        $this->db->join('users us', 'r.customer_id = us.id', 'LEFT');
        //$this->db->join('rfq_to_seller rs','r.id = rs.rfq_id','LEFT');
        $this->db->join('units u', 'r.unit = u.units_id', 'LEFT');

        if ($datefrom != '') {
            $this->db->where("date(r.added_date) >=", date('Y-m-d', strtotime($datefrom)));
        }
        if ($dateto != '') {
            $this->db->where("date(r.added_date) <=", date('Y-m-d', strtotime($dateto)));
        }
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return null;
        }
    }

    function rfqs_search($limit, $start, $search, $col, $dir) {
        $query = $this
                ->db
                ->from($this->_table . " r")
                ->join('users us', 'r.customer_id = us.id', 'LEFT')
                ->like('r.id', $search)
                ->or_like('r.looking_for', $search)
                ->or_like('us.first_name', $search)
                ->or_like('us.last_name', $search)
                ->limit($limit, $start)
                ->order_by("r." . $col, $dir)
                ->get();


        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return null;
        }
    }

    function rfqs_search_count($search) {
        $query = $this
                ->db
                ->like('id', $search)
                ->or_like('looking_for', $search)
                ->get($this->_table);

        return $query->num_rows();
    }

    /*
     * Following functions are added to use with server side datatables to get suppliers assign list
     */

    function allsupplier_count() {
        $query = $this
                ->db
                ->get($this->_tableusers);

        return $query->num_rows();
    }

    function allsupplier($limit, $start, $col, $dir) {

        $this->db->select('a.*, b.company_name as company_name');
        $this->db->from($this->_tableusers . ' as a');
        $this->db->join($this->_tablesellercompanydetails . ' as b', 'a.id=b.user_id', 'left');
        $this->db->where('a.role', 'seller');
        $this->db->limit($limit, $start);
        $this->db->order_by('a.' . $col, $dir);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return null;
        }
    }

    function supplier_search($limit, $start, $search, $col, $dir) {
        $query = $this->db->select('u.*, b.company_name as company_name');
        $this->db->where('u.role', 'seller');
        $this->db->group_start();
        $this->db->like('u.first_name', $search);
        $this->db->or_like('u.last_name', $search);
        $this->db->or_like('b.company_name', $search);
        $this->db->or_like('u.email', $search);
        $this->db->group_end();
        $this->db->limit($limit, $start);
        $this->db->order_by($col, $dir);
        $this->db->from($this->_tableusers . " u");
        $this->db->join($this->_tablesellercompanydetails . ' as b', 'u.id=b.user_id', 'left');
        $query=$this->db->get();


        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return null;
        }
    }

    function supplier_search_count($search) {
        $query = $this
                ->db
                ->like('id', $search)
                //->or_like('title', $search)
                ->get($this->_tableusers);

        return $query->num_rows();
    }

    function get_units() {
        $this->db->select('units_id, units_name');
        $this->db->from('units');
        return $this->db->get()->result_array();
    }

    function getSupplierRepliesForRfq($rfq_id) {

        $this->db->select("attachment,quantity,price,comment,r.added_date, first_name, last_name, units_name,customer_id, company_name, email, phone,r.seller_id,r.admin_hike,(r.price+(r.price*(r.admin_hike/100))) hike_price");

        $this->db->from("rfq_to_seller r");
        $this->db->join('users u', 'r.seller_id = u.id');
        $this->db->join('seller_info s', 's.user_id = r.seller_id');
        $this->db->join('units unt', 'r.unit = unt.units_id');
        $this->db->join('rfqs rf', 'rf.id = r.rfq_id');
        $this->db->where('r.rfq_id', $rfq_id);
        $this->db->where('r.admin_approve', 1);
        $query = $this->db->get();
        return $query->result_array();
    }

    function rejectRfq($id) {
        $this->db->set('status', "Rejected");
        $this->db->where('id', $id);
        return $this->db->update('rfq_to_seller');
    }

    function updateRfq_approve($rfq_id) {
        $this->db->set('status', "SellerReplied");
        $this->db->where('id', $rfq_id);
        return $this->db->update('rfqs');
    }

    function updateRfq_rejected($rfq_id) {
        $this->db->set('status', "Rejected");
        $this->db->where('id', $rfq_id);
        return $this->db->update('rfqs');
    }

    function getPendingRFQs($user_id) {
        $this->db->select('r.looking_for,r.quanity, units_name, DATE_FORMAT(r.added_date, "%d %M %Y %h:%i:%s") as added_date, r.description,r.status');
        $this->db->from('rfqs r');
        $this->db->join('units u', 'r.unit = u.units_id', 'left');
        $this->db->where('r.customer_id', $user_id);
        $this->db->where('r.status', "Pending");
        $this->db->or_where('r.status', "SellerReplied");
        $this->db->order_by('id desc');
        return $this->db->get()->result_array();
    }

    function getApprovedRFQs($user_id) {
        $this->db->select('r.id, r.looking_for,r.quanity, units_name, DATE_FORMAT(r.added_date, "%d %M %Y %h:%i:%s") as added_date, r.description,r.status');
        $this->db->from('rfqs r');
        $this->db->join('units u', 'r.unit = u.units_id');
        $this->db->join('rfq_to_seller rs', 'r.id = rs.rfq_id');
        $this->db->where('r.status', 'Approved');
        $this->db->where('r.customer_id', $user_id);
        $this->db->where('rs.admin_approve', 1);
        $this->db->order_by('id desc');
        return $this->db->get()->result_array();
    }

    function getRejectedRFQs($user_id) {
        $this->db->select('r.looking_for,r.quanity, units_name, DATE_FORMAT(r.added_date, "%d %M %Y %h:%i:%s") as added_date, r.description,r.status');
        $this->db->from('rfqs r');
        $this->db->join('units u', 'r.unit = u.units_id');
        $this->db->where('r.status', 'Rejected');
        $this->db->where('r.customer_id', $user_id);
        $this->db->order_by('id desc');
        return $this->db->get()->result_array();
    }

    function getSellerReply($rfq_id) {
        $this->db->select('r.admin_hike,r.id, u.first_name, u.last_name, quantity, units_name, price,comment, attachment, DATE_FORMAT(added_date, "%d %M %Y %h:%i:%s") as added_date');
        $this->db->from("rfq_to_seller r");
        $this->db->join("users u", "r.seller_id = u.id");
        $this->db->join('units unt', 'r.unit = unt.units_id');
        $this->db->where('r.rfq_id', $rfq_id);
        return $this->db->get()->result_array();
    }

    function updaterfq($rfqs_id) {
        $this->db->set('is_forwarded', 1);
        $this->db->where('id', $rfqs_id);
        return $this->db->update($this->_table);
    }

}
