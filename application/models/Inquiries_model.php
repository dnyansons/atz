<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Inquiries_model extends CI_Model 
{

    private $_table, $_tableProduct, $_tableUser, $_tableReply, $_tableProductDesc, $_tableUnits;
    private $_select, $_column_order, $_column_search, $_order;

    public function __construct() 
    {
        parent::__construct();
        $this->load->database();
        $this->_table = "inquiries";
        $this->_tableReply = "inquiry_replies";
        $this->_tableProduct = "product_details";
        //$this->_tableProductDesc = "products_description";
        $this->_tableUser = "users";
        $this->_tableUnits = "units";

        $this->_select = "$this->_table.id,bu.first_name as buyerfirstname,bu.last_name as buyerlastname,bu.email as buyeremail,bu.phone as buyerphone,su.first_name as sellerfirstname,su.last_name as sellerlastname,su.email as selleremail,su.phone as sellerphone,name as products_name,quantity,$this->_table.status,$this->_tableUnits.units_name,comment,is_forwarded,attachments_by_buyer";
        $this->_column_order = array("$this->_table.id");
        $this->_column_search = array("$this->_table.id", "name","first_name","last_name");
        $this->_order = array("$this->_table.id" => "desc");
    }

    public function addEnquiry($data) 
    {
        $this->db->insert($this->_table, $data);
        return $this->db->insert_id();
    }

    public function updateEnquiry($data, $id) {
        $this->db->where(array("id" => $id));
        $this->db->update($this->_table, $data);
    }

    /*     * ****** Following functions are used with server side data table custom filters ****************** */

    public function get_datatables($type,$datefrom, $dateto) {

        $this->_get_datatables_query($type,$datefrom, $dateto);
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $this->db->order_by('inquiries.id', 'desc');
        $query = $this->db->get();
        return $query->result();
    }

    public function count_filtered($type,$datefrom, $dateto) {
        $this->_get_datatables_query($type, $datefrom, $dateto);

        $query = $this->db->get();

        return $query->num_rows();
    }

    public function count_all() {
        $this->db->from($this->_table);
        return $this->db->count_all_results();
    }

    private function _get_datatables_query($type, $datefrom, $dateto) {
        $this->db
                ->select($this->_select)
                ->from($this->_table)
                ->join($this->_tableProduct, "$this->_tableProduct.id = $this->_table.for_product", "LEFT")
                ->join($this->_tableUser. " bu", "bu.id = $this->_table.by_user", "LEFT")
                ->join($this->_tableUser. " su", "su.id = $this->_tableProduct.seller", "LEFT")
                ->join($this->_tableUnits, "$this->_tableUnits.units_id = $this->_table.unit", "LEFT")
                ->where("$this->_table.status !=","Rejected");

        if ($type != '') {
            $this->db->where(" $this->_table.is_forwarded = $type");
        }

        if ($datefrom != '') {
            $this->db->where("date($this->_table.added_date) >=", date('Y-m-d', strtotime($datefrom)));
        }
        if ($dateto != '') {
            $this->db->where("date($this->_table.added_date) <=", date('Y-m-d', strtotime($dateto)));
        }

        $i = 0;
        foreach ($this->_column_search as $item) {

              if ($_POST['search']['value']) {
                    if ($i === 0) {
                        $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                        $this->db->like($item, $_POST['search']['value']);
                    } else {
                        $this->db->or_like($item, $_POST['search']['value']);
                    }
                    if (count($this->_column_search) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
                }
            $i++;
        }

        if (isset($_POST['order'])) {
			if($_POST['order']['0']['dir'] == "asc")
			{
				$ordr = "desc";
			}else{
				$ordr = "asc";
			}
            $this->db->order_by($this->_column_order[$_POST['order']['0']['column']], $ordr);
        } elseif (isset($this->_order)) {
            $order = $this->_order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    /*     * ************************ shubham patil ************************ */

    public function get_datatables_for_user($user_id) {
        $this->_get_datatables__for_user($user_id);

        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);

        $query = $this->db->get();

        return $query->result();
    }

    public function count_filtered_for_user($user_id) {
        $this->_get_datatables__for_user($user_id);

        $query = $this->db->get();

        return $query->num_rows();
    }

    private function _get_datatables__for_user($user_id) {

        $this->_column_search_for_user = array("$this->_table.id", "$this->_tableProduct.name", "first_name","last_name");

        $this->db
                ->select("$this->_table.id,name as products_name,quantity,$this->_tableUnits.units_name,comment,attachments_by_buyer, first_name, last_name")
                ->from($this->_table)
				->join($this->_tableProduct, "$this->_tableProduct.id = $this->_table.for_product","left")
				->join($this->_tableUser, "$this->_tableUser.id = $this->_table.by_user","left")
                ->join($this->_tableUnits, "$this->_tableUnits.units_id = $this->_table.unit","left")
                ->where("$this->_tableProduct.seller", $user_id)
                ->where("$this->_table.is_forwarded", 1);

        $i = 0;
        foreach ($this->_column_search_for_user as $item) {
            if ($_POST['search']['value']) {

                if ($i === 0) {
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->db->like($item, $_POST['search']['value']);
                } else {
                    $this->db->or_like($item, $_POST['search']['value']);
                }

                if (count($this->_column_search_for_user) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }

        if (isset($_POST['order'])) {
			if($_POST['order']['0']['dir'] == "asc")
			{
				$ordr = "desc";
			}else{
				$ordr = "asc";
			}
            $this->db->order_by($this->_column_order[$_POST['order']['0']['column']], $ordr);
        } elseif (isset($this->_order)) {
            $order = $this->_order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    function getReplydata($inquiry_id) {
        $this->db->where('inquiry_id', $inquiry_id);
        $query = $this->db->get('inquiry_replies');
        return $query->row();
    }

    function add_inquiry_reply($arr) {
        return $this->db->insert('inquiry_replies', $arr);
    }

    //////////////////////////////Buyer Enquiries Model//////////////////////
    //////////////////////////////Buyer Enquiries Model//////////////////////

    function allenq_count($user_id) {

        $this->db->select('*');
        $this->db->from('inquiries a');
        $this->db->join('product_details b', 'b.id = a.for_product');
        $this->db->join('units c', 'a.unit = c.units_id');
        $this->db->where('a.by_user', $user_id);
        $query = $this->db->get();

        return $query->num_rows();
    }

    function allbuyerenquiries($user_id, $limit, $start, $col, $dir) 
    {

        $this->db->select('*');
        $this->db->from('inquiries a');
        $this->db->join('product_details b', 'b.id = a.for_product');
        $this->db->join('units c', 'a.unit = c.units_id');
        $this->db->where('a.by_user', $user_id);
        $this->db->limit($limit, $start);
        $this->db->order_by("a.".$col, $dir);
        $query = $this->db->get();

        //echo $this->db->last_query();
        //exit;


        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return null;
        }
    }

    function buyer_enquires_search($user_id, $limit, $start, $search, $col, $dir) {


        $this->db->select('*');
        $this->db->from('inquiries a');
        $this->db->join('product_details b', 'b.id = a.for_product');
        $this->db->join('units c', 'a.unit = c.units_id');
        $this->db->where('a.by_user', $user_id);
        $this->db->where("(`b`.`name` LIKE '%" . $search . "%' ESCAPE '!' OR `b`.`products_alias` LIKE '%" . $search . "%' ESCAPE '!')");
        $this->db->limit($limit, $start);
        $this->db->order_by($col, $dir);
        $query = $this->db->get();


        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return null;
        }
    }

    function buye_renquiries_search_count($user_id, $search) {
        
        $this->db->select('*');
        $this->db->from('inquiries a');
        $this->db->join('product_details b', 'b.id = a.for_product');
        $this->db->join('units c', 'a.unit = c.units_id');
        $this->db->where('a.by_user', $user_id);
        $this->db->where("(`b`.`name` LIKE '%" . $search . "%' ESCAPE '!' OR `b`.`products_alias` LIKE '%" . $search . "%' ESCAPE '!')");

        $query = $this->db->get();

        return $query->num_rows();
    }

    function getInquiryByUser($user_id) {
        $this->db->select('b.seller,scd.company_name,con.iso,a.id as inquiry_id, b.id product_id,PM.url as product_image,by_user,b.name products_name, first_name, last_name, a.unit as units_name, quantity,comment, attachments_by_buyer, added_date, a.status');
        $this->db->from('inquiries a');
        $this->db->join('product_details b', 'b.id = a.for_product', 'left');
        $this->db->join('users d', 'd.id = b.seller', 'left');
        $this->db->join('units c', 'a.unit = c.units_id', 'left');
        $this->db->join("seller_company_details as scd", "b.seller=scd.user_id", "left");
        $this->db->join('country con','d.country = con.id', "left");
        $this->db->join("product_media PM","PM.id = (SELECT id FROM product_media PM1 WHERE "
                 . "PM1.product_id = b.id ORDER BY PM1.id ASC LIMIT 1)", 'left');
        $this->db->where('a.by_user', $user_id);
        $this->db->where("a.status !=", "Rejected");
        $this->db->order_by('a.id', 'DESC');
        return $this->db->get()->result();
    }
    
//    function getInquiryByUserEnquiry($enq_id,$user_id) {
//        $this->db->select('b.seller,scd.company_name,con.iso,a.id as inquiry_id, b.id product_id,PM.url as product_image,by_user,b.name products_name, first_name, last_name, a.unit as units_name, quantity,comment, attachments_by_buyer, added_date, a.status');
//        $this->db->from('inquiries a');
//        $this->db->join('product_details b', 'b.id = a.for_product', 'left');
//        $this->db->join('users d', 'd.id = b.seller', 'left');
//        $this->db->join('units c', 'a.unit = c.units_id', 'left');
//        $this->db->join("seller_company_details as scd", "b.seller=scd.user_id", "left");
//        $this->db->join('country con','d.country = con.id', "left");
//        $this->db->join("product_media PM","PM.id = (SELECT id FROM product_media PM1 WHERE "
//                 . "PM1.product_id = b.id ORDER BY PM1.id ASC LIMIT 1)", 'left');
//        $this->db->where('a.by_user', $user_id);
//        $this->db->where('a.id', $enq_id);
//        $this->db->order_by('a.id', 'DESC');
//        return $this->db->get()->row();
//    }

    function getProductPrices($product_id) {
        $this->db->select('*');
        $this->db->where('product_id', $product_id);
        $this->db->from('product_price');
        return $this->db->get()->result();
    }

    function getSupplierRepliesForInquiries($inquiry_id) {
        $this->db->select('by_user,a.comment, attachments, first_name, last_name, reply_type,price,a.added_date,a.status, a.seller_id');
        $this->db->from('inquiry_replies a');
        $this->db->join('inquiries b', 'b.id = a.inquiry_id');
        $this->db->join('users u', 'a.seller_id = u.id');
        $this->db->where('a.inquiry_id', $inquiry_id);
        $query = $this->db->get();

        return $query->result_array();
    }


    public function updateInquiriesReadStatusData($inquiry_id)
    {
        $this->db->set('read_status', 'read');
        $this->db->where('id', $inquiry_id);
        $this->db->update('inquiries');
        return true;
    }

    public function getUnreadInquiriesCountByUserData($user_id)
    {
        $this->db->select('id');
        $this->db->where('read_status', 'unread');
        $this->db->where('by_user', $user_id);
        $query=$this->db->get('inquiries');
        $result=$query->num_rows();
        return $result;
    }
	
    public function count_inquiries($user_id)
    {
            $this->db->select('i.id, name, quantity, units_name, comment, attachments_by_buyer, for_product, i.status, url, DATE_FORMAT(added_date,"%d %M %Y %h:%i:%s") as added_date');
            $this->db->from($this->_table . " i");
            $this->db->join($this->_tableProduct, "$this->_tableProduct.id = i.for_product");
            $this->db->join("product_media PM", "PM.id = (SELECT id FROM product_media PM1 WHERE "
            . "PM1.product_id = $this->_tableProduct.id ORDER BY PM1.id ASC LIMIT 1)");
            $this->db->join($this->_tableUnits, "$this->_tableUnits.units_id = i.unit");
            $this->db->where("i.by_user", $user_id);
             $this->db->where("i.status !=", "Rejected");
            $this->db->order_by("i.id", "desc");
            return $this->db->get()->result_array();
    }
    
	public function updateinquiryStatus($inquiry_id)
	{
		$this->db->set('status','Approved');
		$this->db->where("id", $inquiry_id);
		return $this->db->update($this->_table); 
	}
	
	public function getSellerReply($inquiry_id)
	{
		$this->db->select('i.id, u.first_name, u.last_name, price, comment, attachments, DATE_FORMAT(added_date,"%d %M %Y %h:%i:%s") as added_date');
		$this->db->from($this->_tableReply. " i");
		$this->db->join($this->_tableUser . " u", "i.seller_id = u.id");
		$this->db->where('inquiry_id',$inquiry_id);
		return $this->db->get()->row_array();
	}
	
    public function get_inquiry_user($inquiry_id)
    {
        $this->db->select('by_user');
        $this->db->from('inquiries');
        $this->db->where('id',$inquiry_id);
        $query = $this->db->get();
        $result = $query->row_array();
        return $result['by_user'];
                          
    }
    
    public function get_user_firebase_id($by_user)
    {
        $this->db->select('firebase_id');
        $this->db->from('users_firebase_details');
        $this->db->where('user_id',$by_user);
        $query = $this->db->get();
        $result = $query->row_array();
        return $result['firebase_id'];
                          
    }

    public function deleteEnquiry($id)
    {
       $this->db->set('status',"Rejected");
       $this->db->where('id',$id);
       $this->db->update('inquiries');
       return true;
    }
    
    function getInquiryByUserEnquiry($enq_id,$user_id) {
        $this->db->select('b.seller,scd.company_name,con.iso,a.id as inquiry_id, b.id product_id,PM.url as product_image,by_user,b.name products_name, first_name, last_name, a.unit as units_name, quantity,comment, attachments_by_buyer, added_date, a.status');
        $this->db->from('inquiries a');
        $this->db->join('product_details b', 'b.id = a.for_product', 'left');
        $this->db->join('users d', 'd.id = b.seller', 'left');
        $this->db->join('units c', 'a.unit = c.units_id', 'left');
        $this->db->join("seller_company_details as scd", "b.seller=scd.user_id", "left");
        $this->db->join('country con','d.country = con.id', "left");
        $this->db->join("product_media PM","PM.id = (SELECT id FROM product_media PM1 WHERE "
                 . "PM1.product_id = b.id ORDER BY PM1.id ASC LIMIT 1)", 'left');
        $this->db->where('a.by_user', $user_id);
        $this->db->where('a.id', $enq_id);
        $this->db->where('a.status !=',"Rejected");
        $this->db->order_by('a.id', 'DESC');
        return $this->db->get()->row();
    }
    
}
