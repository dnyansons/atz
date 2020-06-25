<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Summary.
 * affiliate model is a model class of affiliate marketing.
 * 
 * Description.
 * affiliate marketing is a process of promoting others product on their own website.
 * 
 * this class contains all(admin module, affiliate user module) affiliate database query functions.
 * 
 * @package affiliate marketing.
 * @version PHP 7.1 20190909.
 * @author shubham patil <shubhampatil@ayninfotech.com>
 */

class Affiliate_model extends CI_Model {

    private $_table,$_affiliateBank;
    public function __construct() 
    {
        parent::__construct();
        $this->load->database();
        $this->_table = "affiliate_login";
        $this->_affiliateBank = "affiliate_bank";
        $this->_affiliateOrders = "affiliate";
        $this->_affiliateBilling = "affiliate_billing";
    }
    
    /**
     * 
     * Description 
     * 
     * checkOrders function check for affiliate order count, if the affiliate id & the order id
     * is already present, it increase the count and update the record.
     * if affiliate id and order id not present then it will insert a new record 
     * 
     * @param type $refCookie
     * @param type $orders_id
     * @param type $affidata
     * @author shubham patil <shubhampatil@ayninfotech.com>
     */
    
    function checkOrders($affidata)
    {
        return $this->db->insert($this->_affiliateOrders,$affidata);
    }
    
    function addAffiliate($data)
    {
        $this->db->insert($this->_table,$data);
        return $this->db->insert_id();
    } 
    
    function addAffiliateBankData($data)
    {
       return $this->db->insert($this->_affiliateBank,$data);
    } 
    
    /**************************  login queries *************************/
    
    function getUserByUsername($username) {
        $this->db->select('id,username,fullname,companyname,status,password,mobileno');
        $this->db->from($this->_table);
        $this->db->where('username', trim($username));
        $query = $this->db->get();
        return $query->row();
    }

    function getUserBymobile($username) {
        $this->db->select('id,username,fullname,companyname,status,password,mobileno');
        $this->db->from($this->_table);
        $this->db->where('mobileno', trim($username));
        $query = $this->db->get();
        return $query->row();
    }
    
    /*************************** Change Password **************************/
    
    function updatePassword($affiliateId,$password)
    {   
        if(is_numeric($affiliateId))
        {
           $this->db->where("id",$affiliateId);
        }else{
            $this->db->where("username",$affiliateId);
        }
        $this->db->set("password",$password);
        
        return $this->db->update($this->_table);
    }
    
    /**
     * 
     * @version PHP 7.1 20190909
     * @author shubham patil <shubhampatil@ayninfotech.com>
     * @see http://atzcart/admin/affiliate
     * @param type $from
     * @param type $to
     * @param type $status
     * @return type array() Description - i have implemented server side data table. this function returns the list of 
     * pending and approved affiliates list - admin panel.  
     * 
     */
    public function getAffiliateList($from, $to,$status) {
        $this->_get_datatables_query($from, $to,$status);

        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    public function count_filtered($from, $to, $status) {

        $this->_get_datatables_query($from, $to, $status);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all() {

        $this->db->from($this->_table);
        return $this->db->count_all_results();
    }

    private function _get_datatables_query($from, $to, $status) {
        $this->db
                ->select("id,added_date,approved_date,fullname,companyname,reason")
                ->from($this->_table. " a")
                ->where(["status" => $status]);
        
        if ($from != '' && $to != '' || $from != NULL) { // To process our custom input parameter
            if ($status == "Pending") {
                 $this->db->where('date(added_date) BETWEEN "' . date('Y-m-d', strtotime($from)) . '" and "' . date('Y-m-d', strtotime($to)) . '"');
            } else if($status == "Approved" || $status == "Rejected"){
                $this->db->where('date(approved_date) BETWEEN "' . date('Y-m-d', strtotime($from)) . '" and "' . date('Y-m-d', strtotime($to)) . '"');
            }
        }

        $i = 0;
        $column_search = array('id', 'fullname','companyname');
        foreach ($column_search as $item) { // loop column
            //echo $item.'<br>';
            if ($_POST['search']['value']) { // if datatable send POST for search
                if ($i === 0) { // first loop
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    if ($item == 'id') {
                        $this->db->like($item, $_POST['search']['value']);
                    } else {
                        $this->db->or_like($item, $_POST['search']['value']);
                    }
                } else {
                    if ($item == 'id') {
                        $this->db->like($item, $_POST['search']['value']);
                    } else {
                        $this->db->or_like($item, $_POST['search']['value']);
                    }
                }

                if (count($column_search) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }
      
        if (isset($_POST['order'])) { // here order processing
            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } elseif (isset($this->order)) { // default order processing
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }
    
    function getAffiliateDataById($affiliateId)
    {
        $this->db->select("a.id, a.username, a.fullname,a.mobileno,a.companyname,a.sitename,a.url, a.status,a.approved_date, a.rate, a.perclick, a.password, a.refurl,beneficiaryname,accno,bankname,ifscno"); 
        $this->db->from($this->_table." a");
        $this->db->join($this->_affiliateBank. " ab","a.id = ab.affid","INNER");
        $this->db->where("a.id",$affiliateId);
        $query = $this->db->get($this->_table)->row();
        return $query;
    }
    
    function updateAdminActionOnAfflt($affiliateId, $updatedata)
    {
        $this->db->where("id",$affiliateId);
        return $this->db->update($this->_table,$updatedata);
    }
    
     function updateAdminActionOnRjected($activateEnum,$affiliateId, $reason)
    {
        $todays_date = date("Y-m-d H:i:s"); 
        $this->db->set("status",$activateEnum);
        $this->db->set("reason",$reason);
        $this->db->set("approved_date",$todays_date);
        $this->db->where("id",$affiliateId);
        return $this->db->update($this->_table);
    }
    
    /******************************* Billing Queries ********************************/
    
    function getAffiliateBillingData($affiliateId)
    {
        $this->db->select("a.rate, a.perclick, b.count");
        $this->db->from($this->_table. " a");
        $this->db->join($this->_affiliateOrders. " b","a.id = b.RefId");
        $this->db->where("a.id",$affiliateId);
        $this->db->where("b.is_hold",0);
        return $this->db->get()->result();
    }
    
    function getAffiliateholdBillingData($billingId)
    {
        $this->db->select("totalorder, amount");
        $this->db->where("id",$billingId);
        $this->db->from($this->_affiliateBilling);
        return $this->db->get()->row();
    }
    
    
    function insertAffiliateBilling($bilingDetails)
    {
       return $this->db->insert($this->_affiliateBilling,$bilingDetails);
    }
    
    function updateAffiliateBilling($bilingDetails,$billingId)
    {   
        $this->db->where("id",$billingId);
        return $this->db->update($this->_affiliateBilling,$bilingDetails);
    }
    
    function updateAffiliateOrders($affiliateId)
    {
        $this->db->set("count",0);
        $this->db->where("RefId",$affiliateId);
        return $this->db->update($this->_affiliateOrders);
    }
    
    function updateaffiliate($affId)
    {
        $this->db->set("is_hold",1);
        $this->db->where("afid",$affId);
        return $this->db->update($this->_affiliateOrders);
    }
    
    /**
     * 
     * @version PHP 7.1 20190909
     * @author shubham patil <shubhampatil@ayninfotech.com>
     * @see http://atzcart/admin/affiliate
     * @param type $from
     * @param type $to
     * @param type $status
     * @return type array() Description - i have implemented server side data table. this function returns the list of 
     * affiliates billing - admin panel.  
     * 
     */
    public function getAffiliatePendingBillingList() {
        $this->_getPendingBillingdatatables_query();

        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    public function countPendingBillingfiltered() {

        $this->_getPendingBillingdatatables_query();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function countPendingBillingAll() {

        $this->db->from($this->_table);
        return $this->db->count_all_results();
    }

    private function _getPendingBillingdatatables_query() {
        $this->db
                ->select("id,afid,fullname,companyname")
                ->from($this->_table. " a")
                ->join($this->_affiliateOrders." b","a.id = b.RefId","LEFT")
                ->where("b.count",1)
                ->where("b.is_hold",0)
                ->group_by("a.id"); 

        $i = 0;
        $column_search = array('a.companyname', 'a.fullname');
        foreach ($column_search as $item) { // loop column
            if ($_POST['search']['value']) { // if datatable send POST for search
                if ($i === 0) { // first loop
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    if ($item == 'id') {
                        $this->db->like($item, $_POST['search']['value']);
                    } else {
                        $this->db->or_like($item, $_POST['search']['value']);
                    }
                } else {
                    if ($item == 'id') {
                        $this->db->like($item, $_POST['search']['value']);
                    } else {
                        $this->db->or_like($item, $_POST['search']['value']);
                    }
                }

                if (count($column_search) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }
      
        if (isset($_POST['order'])) { // here order processing
            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } elseif (isset($this->order)) { // default order processing
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }
    
    
    public function getAffiliateBillingList($from, $to, $affiliateId='', $status) {
        $this->_getBillingdatatables_query($from, $to, $affiliateId, $status);

        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    public function countBillingfiltered($from, $to, $affiliateId='', $status) {

        $this->_getBillingdatatables_query($from, $to, $affiliateId, $status);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function countBillingAll() {

        $this->db->from($this->_table);
        return $this->db->count_all_results();
    }

    private function _getBillingdatatables_query($from, $to, $affiliateId, $status) {
        $this->db
                ->select("a.id,a.affid,b.fullname,a.totalorder,a.amount,a.paymentstatus,a.referenceid,a.paymentdate,a.holdcomment")
                ->from($this->_affiliateBilling. " a")
                ->join($this->_table. " b","a.affid = b.id")
                ->where("a.paymentstatus",$status);
        if ($affiliateId != "") { // To process our custom input parameter
           $this->db->where("a.affid",$affiliateId);
        }
        
        if ($from != '' && $to != '' || $from != NULL) { // To process our custom input parameter
                 $this->db->where('date(a.paymentdate) BETWEEN "' . date('Y-m-d', strtotime($from)) . '" and "' . date('Y-m-d', strtotime($to)) . '"');
        }

        $i = 0;
        $column_search = array('a.affid', 'b.fullname');
        foreach ($column_search as $item) { // loop column
            if ($_POST['search']['value']) { // if datatable send POST for search
                if ($i === 0) { // first loop
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    if ($item == 'affid') {
                        $this->db->like($item, $_POST['search']['value']);
                    } else {
                        $this->db->or_like($item, $_POST['search']['value']);
                    }
                } else {
                    if ($item == 'affid') {
                        $this->db->like($item, $_POST['search']['value']);
                    } else {
                        $this->db->or_like($item, $_POST['search']['value']);
                    }
                }

                if (count($column_search) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }
      
        if (isset($_POST['order'])) { // here order processing
            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } elseif (isset($this->order)) { // default order processing
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }
    function getAffilliateTotalOrders($affiliateId)
    {
        $this->db->select("SUM(totalorder) totalorder, SUM(amount) amount");
        $this->db->from($this->_affiliateBilling);
        $this->db->where("affid", $affiliateId);
        return $this->db->get()->row(); 
    }
    
    function updateBankDetails($affiliateId,$paymentUpdate)
    {
        $this->db->where("affid",$affiliateId);
        return $this->db->update($this->_affiliateBank,$paymentUpdate);
    }
}
