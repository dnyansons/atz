<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Common_model extends CI_Model {

    public function __construct() {
        $this->load->database();
    }

    public function getAll($tablename, $where = '', $orderby = '', $column = '') {
        if ($where != '') {
            $this->db->where($where);
        }

        if ($orderby != '') {
            $this->db->order_by($column, $orderby);
        }

        $query = $this->db->get($tablename);

        return $query;
    }

    public function insert($tablename, $data) {

        $this->db->insert($tablename, $data);

        return $this->db->insert_id();
    }

    public function update($tablename, $data, $where) {

        $this->db->where($where);

        $query = $this->db->update($tablename, $data);

        return $this->db->affected_rows();
    }

    public function getSellerPickupAddres($user_id) {
        $dataArr1 = $this->db->select('*')
                        ->from('seller_pick_address u')
                        ->join('country pd', 'pd.id=u.country ')
                        ->where(array('u.user_id' => $user_id))
                        ->get()->result_array();

        return $dataArr1;
    }

    public function delete($tablename, $where) {

        $this->db->where($where);

        $query = $this->db->delete($tablename);

        return $query;
    }

    function select($select, $from, $where = NULL, $orderBy = NULL, $num = NULL, $offset = NULL, $join = NULL, $group_by = NULL) {

        $this->db->select($select);

        $this->db->from($from);


        //if there is any joining with n($joinCnt) another tables .................

        if ($join != NULL) {

            for ($i = 1; $i <= count($join); $i++) {

                //check whether the third parameter is inserted or not...

                $join[$i]['jType'] = ($join[$i]['jType'] != '') ? $join[$i]['jType'] : '';

                $this->db->join($join[$i]['tableName'], $join[$i]['columnNames'], $join[$i]['jType']);
            }
        }

        //if there is no any where criteria..............

        if ($where != NULL) {

            $this->db->where($where);
        }

        //if result want sorted

        if ($orderBy != NULL) {

            for ($i = 1; $i <= count($orderBy); $i++) {

                $this->db->order_by($orderBy[$i]['colname'], $orderBy[$i]['type']);
            }
        }

        //chk for pagination pages......................

        if ($num != NULL or $offset != NULL) {

            $this->db->limit($num, $offset);
        }

        //chk for order by clause......................

        if ($group_by != NULL) {

            $this->db->group_by($group_by);
        }


        return $this->db->get()->result_array();
    }

    function allusers($limit, $start, $col, $dir) {

        $this->db->select('a.*,b.id,b.username,b.mobile');



        $this->db->from("wallet a");



        $this->db->join("users b", "b.id = a.user_id", "inner");



        $this->db->where("b.role", "1");



        $query = $this->db->limit($limit, $start)->order_by($col, $dir)->get();



        if ($query->num_rows() > 0) {

            return $query->result();
        } else {
            return null;
        }
    }

    function posts_search_count($search) {

        $this->db->select('*');



        $this->db->from("users a");


        $this->db->join("wallet b", "b.user_id = a.id", "inner");


        $this->db->where("a.role", "1");



        $this->db->like('a.id', $search);



        $this->db->or_like('a.username', $search);



        $this->db->or_like('a.mobile', $search);



        $this->db->or_like('b.real_amount', $search);



        $this->db->or_like('b.last_updated', $search);



        $query = $this->db->get();



        return $query->num_rows();
    }

    function usres_search($limit, $start, $search, $col, $dir) {

        $this->db->select('*');



        $this->db->from("users a");



        $this->db->join("wallet b", "b.user_id = a.id", "inner");


        $this->db->where("a.role", "1");

        $this->db->like('a.id', $search);

        $this->db->or_like('upper(a.username)', strtoupper($search));

        $this->db->or_like('a.mobile', $search);

        $this->db->or_like('b.real_amount', $search);

        $this->db->or_like('b.last_updated', $search);

        $this->db->limit($limit, $start);

        $this->db->order_by($col, $dir);

        $query = $this->db->get();

        if ($query->num_rows() > 0) {



            return $query->result();
        } else {
            return null;
        }
    }

    function usersAttemptRetrive() {
        $curdate = date("Y-m-d");

        $usersAttempts = $this->db->query("select name,count(user_id) as no_user from context_detail inner join context_master on context_detail.con_id = context_master.id where con_date='" . $curdate . "' group by name order by no_user desc limit 1")->result_array();

        return $usersAttempts;
    }

    public function get_tax_classes() {
        $this->db->select('tax_class_id, tax_class_title');
        $query = $this->db->get('tax_class');
        return $query->result();
    }

    public function get_countries() {
        $this->db->select('id, nicename');
        $this->db->order_by('nicename', 'asc');
        $query = $this->db->get('country');
        return $query->result();
    }

    public function get_five_countries() {
        $this->db->select('id, nicename');
        $this->db->where_in('name', array('UNITED STATES', 'UNITED KINGDOM', 'GERMANY', 'RUSSIAN FEDERATION', 'UNITED ARAB EMIRATES', 'INDIA'));
        $this->db->order_by('nicename', 'asc');
        $query = $this->db->get('country');
        return $query->result();
    }

    public function get_five_currencies() {
        $this->db->distinct();
        $this->db->select('code');
        $this->db->where_in('code', array('GBP', 'USD', 'EUR', 'RUB', 'AED', 'INR'));
        $this->db->order_by('code', 'asc');
        $query = $this->db->get('currency');
        return $query->result();
    }

    public function get_units() {
        $this->db->order_by('units_name', 'asc');
        $query = $this->db->get('units');
        return $query->result();
    }

    public function getAllDataByWhere($select, $tablename, $where) {
        $this->db->select($select);
        $this->db->where($where);
        $query = $this->db->get($tablename);
        return $query->row();
    }

    /**
     * @auther Yogesh Pardeshi 04082019
     * @param $product_id = product id whose stock goes out of stock
     * @param $select = select list of column from table
     * @return mobile number, email ids
     * @used for sending sms email to seller(only to seller as relation is embedded) if product goes out of stock
     * */
    public function get_notify_list($product_id, $select) {
        //$select must be a single column name
        $dataArray = $this->db->select($select)
                        ->from('users u')
                        ->join('product_details pd', 'pd.seller=u.id AND notifyme = 1 AND track_inventory = 1 AND available_quantity <= low_stock_qty')
                        ->where(array('pd.id' => $product_id))
                        ->get()->result_array();
        // $this->session->set_userdata('sms_seller_query', $this->db->last_query());
        //echo $this->db->last_query();
        // for test purpose
        // $dataArray = array ( 0 => array( "phone" => 9923990308 ), 1 => array( "phone" => 8095080161 ));
        $dataArray = $this->arrayToSingleLine($dataArray, $select);
        return $dataArray;
    }

    /**
     * @auther Yogesh Pardeshi 04082019
     * @param $dataArray = array of elements such as phone numbers, emails
     * @return single line string with , separated list
     * @use in side model only private access
     * */
    private function arrayToSingleLine($dataArray, $select) {
        $commaSepLine = "";
        foreach ($dataArray as $singleData) {
            $commaSepLine .= $singleData[$select] . ',';
        }
        return rtrim($commaSepLine, ',');
    }

    /**
     * @auther Yogesh Pardeshi 04082019
     * @param $product_id = product id pk
     * @return $mobileNumbers = comma seperated list of mobile numbers
     * @used for getting sms email of buyers if product stock is refilled or retained (i.e. on order cancelled
     * add returned products quantity to available quantity
     * */
    public function get_notify_list_buyers($product_id, $select) {
        //$select must be a single column name
        $dataArray = $this->db->select($select)
                        ->from('users u')
                        ->join('product_notify_list pnl', 'user_id = u.id', 'left')
                        ->join('product_details pd', 'pd.id = pnl.product_id', 'left')
                        ->where(array('pd.id' => $product_id))
                        ->where('pnl.date_user_notified IS NULL')
                        ->get()->result_array();
        //echo $this->db->last_query();
        $mobileNumbers = $this->arrayToSingleLine($dataArray, $select);
        return $mobileNumbers;
    }

    /**
     * @auther Yogesh Pardeshi 08082019
     * @param $product_id = id of a product
     * @used for updating timestamp for date_user_notified if
     * sms sent to buyers after product stock is refilled or retained(i.e. on order cancelled )
     * */
    public function update_notify_list_buyer($product_id) {
        //update notify table after sending sms to buyers interested in product_id
        //product_notify_list
        $this->db->set('date_user_notified', 'now()', FALSE)
                ->where('product_id', $product_id)
                ->where('date_user_notified is null')
                ->update('product_notify_list');
        // $this->session->set_userdata('sms_buyer_query', $this->db->last_query());
    }

    /*
      This function are getting the document verify details
      @author ishwar 28081019
     */

    public function get_document_history($verify_id) {

        $dataArray = $this->db->select('*')
                        ->from('company_documents u')
                        ->join('document_verify_tbl pd', 'pd.user_id=u.user_id ')
                        ->where(array('u.id' => $verify_id))
                        ->get()->result_array();
        return $dataArray;
    }

    /*
      @author Ishwar
      This function returun seller document details
     */

    public function getSellerDetails($user_id) {
        $dataArr = $this->db->select('*')
                        ->from('company_documents u')
                        ->join('document_verify_tbl pd', 'pd.user_id=u.user_id ')
                        ->join('company_document_files cdf', 'cdf.company_document_title_id=u.id ')
                        ->where(array('u.user_id' => $user_id))
                        ->get()->result_array();

        return $dataArr;


        // $dataArr= $this->db->select('*');
        //         $this->db->from('company_documents cd');
        //         $this->db->join('company_document_files cdf', 'cdf.company_document_title_id=cd.id');
        //         $this->db->join('document_verify_tbl dvt', 'dvt.user_id=cd.user_id');
        //         $this->db->where(array('cd.user_id'=> $user_id));
        //            return $dataArr;
    }

    public function CheckSellerDetailsStatus() {
        $dataArr = $this->db->select('*')
                        ->from('company_documents u')
                        ->join('document_verify_tbl pd', 'pd.user_id=u.user_id ')
                        ->join('company_document_files cdf', 'cdf.company_document_title_id=u.id ')
                        ->where(array('u.user_id' => $user_id, 'pd.document_verify_status' => 'verify'))
                        ->get()->result_array();

        return $dataArr;
    }

}
