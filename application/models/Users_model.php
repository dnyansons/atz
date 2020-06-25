<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Users_model extends CI_Model {

    private $_table, $_tableSellerInfo, $_tableCompanyTypes, $_tableEmailVerification, $_tableMobileVerification, $_column_search;
    private $_tableAddressBook, $_select, $_column_order;

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->_table = "users";
        $this->_docs_table = "document_verify_tbl";
        $this->_tableSellerInfo = "seller_info";
        $this->_tableCompanyTypes = "company_types";
        $this->_tableEmailVerification = "email_verification";
        $this->_tableMobileVerification = "mobile_verification";
        $this->_tableAddressBook = "address_book";
        $this->_tableSellerPreferences = "user_preferences";
        $this->_tableUserPurchasingBehaviour = "user_purchasing_behaviour";
        $this->_column_search = ['id', 'first_name', 'username', 'status', 'phone'];
        $this->_select = "users.*, COUNT(orders.orders_id) as total_orders";
        $this->_select2 = "IFNULL(w.balance, 0)balance,users.*, COUNT(orders.orders_id) as total_orders";
    }

    public function add_user($data) {
        $this->db->insert($this->_table, $data);
        return $this->db->insert_id();
    }

    function get_user_mob_number_by_order_id($order_id) {
        $this->db->select('b.phone');
        $this->db->from('orders a');
        $this->db->join('users b', 'a.user_id=b.id');
        $this->db->where('a.orders_id', $order_id);
        $query = $this->db->get()->row_array();
        return $query['phone'];
    }

    function read_buyer_notification() {
        $this->Common_model->update('admin_notification', ['status' => 'Read'], ['status' => 'Received', 'type' => 'Buyer_Registration']);
    }

    function read_seller_notification() {
        $this->Common_model->update('admin_notification', ['status' => 'Read'], ['status' => 'Received', 'type' => 'Seller_Registration']);
    }

    public function addSellerInfo($data) {
        $this->db->insert($this->_tableSellerInfo, $data);
        return $this->db->insert_id();
    }

    public function getAll() {
        $query = $this->db->get($this->_table);
        return $query->result();
    }

    public function getUserByEmail($email) {
        $query = $this->db->get_where($this->_table, array("email" => $email));
        return $query->row();
    }

    public function getUserByEmailOrMobile($email) {
        $this->db->where("(email = '$email' OR phone = '$email')");
        $query = $this->db->get($this->_table);
        return $query->row();
    }

    public function getUserByUsername($username) {
        $this->db->select('*');
        $this->db->from('users');
        $this->db->or_where('username', $username);
        $this->db->or_where('phone', $username);
        $query = $this->db->get();
        //$query = $this->db->get_where($this->_table, array("username" => $username));

        return $query->row();
    }

    public function getUserBymobile($username) {
        $query = $this->db->get_where($this->_table, array("phone" => $username));
        return $query->row();
    }

    public function getUserById($id) {
        $query = $this->db->get_where($this->_table, array("id" => $id));
        return $query->row();
    }

    public function getUserBankDetails($user_id) {

        $query = $this->db->get_where("supplier_bank_details", array("user_id" => $user_id));
        return $query->row();
    }

    public function getSellerPickUpDetails($user_id) {
        $query = $this->db->get_where("seller_pick_address", array("user_id" => $user_id));
        return $query->row();
    }

    public function getUserAsSellerInfo($id) {
        $this->db->select("IFNULL(SI.company_name, 'NA')company_name,U.role,U.approved_status,U.first_name,U.last_name,U.email,U.phone,U.profile_photo,UPB.annual_purchasing_amount,UPB.annual_purchasing_frequency,IFNULL(CT.name, 'NA') as companyType,"
                . "IFNULL(SI.address1, 'NA') as address," . "SP.*,U.gst_no,U.pan_no,U.pan_type, U.created_on,DT.*");
        $this->db->from($this->_table . " U ");
        $this->db->join($this->_tableSellerInfo . " SI ", "SI.user_id = U.id", "LEFT");
        $this->db->join($this->_tableCompanyTypes . " CT ", "CT.id = SI.company_type", "LEFT");
        $this->db->join($this->_tableSellerPreferences . " SP ", "U.id = SP.user_id", "LEFT");
        $this->db->join($this->_tableUserPurchasingBehaviour . " UPB ", "U.id = UPB.user_id", "LEFT");
        $this->db->join($this->_docs_table . " DT ", "U.id = DT.user_id", "LEFT");
        $this->db->where(array("U.id" => $id));
        $query = $this->db->get();
        $result = $query->row();

        $result->total_favourites_count = $this->getBuyersFavouritesCount($id);

        $this->db->select('verify_email');
        $this->db->order_by('id', 'desc');
        $this->db->where('email', $result->email);
        $this->db->limit(1);
        $query_emailv = $this->db->get('email_verification');
        $query_emailv = $query_emailv->row();
        $result->email_verified = (int) $query_emailv->verify_email;


        $sourcing_reasons = $result->preferred_sourcing_reasons_id;
        $sourcing_reasons = explode(',', $sourcing_reasons);
        $this->db->where_in('reason_id', $sourcing_reasons);
        $query_reasn = $this->db->get('reasons_for_sourcing');
        $query_reasn = $query_reasn->result();
        $result->preferred_sourcing_reasons_id = $query_reasn;

        $root_categories = $result->preferred_root_categories_id;
        $root_categories = explode(',', $root_categories);
        $this->db->select('categories_id, categories_name');
        $this->db->where_in('categories_id', $root_categories);
        $query_root = $this->db->get('categories_description');
        $query_root = $query_root->result();
        $result->preferred_root_categories_id = $query_root;

        $sub_categories = $result->preferred_sub_categories_id;
        $sub_categories = explode(',', $sub_categories);
        $this->db->select('categories_id, categories_name');
        $this->db->where_in('categories_id', $sub_categories);
        $query_sub = $this->db->get('categories_description');
        $query_sub = $query_sub->result();
        $result->preferred_sub_categories_id = $query_sub;

        return $result;
    }

    public function getBuyersFavouritesCount($user_id) {
        $this->db->select('products as favourites_products, suppliers as favourites_suppliers');
        $this->db->where('user_id', $user_id);
        $query = $this->db->get('buyer_favourites');
        $result = $query->row();

        $favourites_products = count(json_decode($result->favourites_products));
        $favourites_suppliers = count(json_decode($result->favourites_suppliers));
        $total_favourites_count = $favourites_products + $favourites_suppliers;
        return $total_favourites_count;
    }

    public function updateUserInfo($id, $data) {
        $this->db->where('email', $data['email']);
        $query = $this->db->get($this->_table)->row();
        if (count($query)==1) {
            return false;
        } else {

            $this->db->where(array("id" => $id));
            //$this->db->set(array("email" => $data['email']));
            $this->db->update($this->_table, $data);
            return true;
        }
    }

    public function updateUserSellerInfo($id, $data) {
        $this->db->where(array("user_id" => $id));
        $this->db->update($this->_tableSellerInfo, $data);
    }

    /*     * ********************* shubham patil *********************** */

    function match_otp($otp) {
        return $this->db->get_where($this->_table, array("verification_code" => $otp));
    }

    function reset_password($username, $password) {
        $check_email = $this->Is_email($username);
        if ($check_email) {
            $this->db->where('email', $username);
        } else {
            $this->db->where('phone', $username);
        }

        $this->db->set('password', $password);
        $this->db->where('email', $username);
        $this->db->or_where('phone', $username);
        return $this->db->update($this->_table);
    }

    function getUserpassword($username) {
        $this->db->select('password');
        $this->db->where('email', $username);
        $this->db->from($this->_table);
        $rs = $this->db->get();
        return $rs->row();
    }

    function change_password($username, $hash_password) {
        $this->db->set('password', $hash_password);
        $this->db->where('email', $username);
        return $this->db->update($this->_table);
    }

    function check_for_suppler($user_id) {
        $this->db->where('user_id', $user_id);
        $res = $this->db->get('user_security_questions')->row();
        if ($res) {
            return true;
        } else {
            return false;
        }
    }

    function get_all_questions() {
        $this->db->select('id, questions');
        $this->db->from('security_questions');
        return $this->db->get()->result_array();
    }

    function add_user_questions($id, $arr) {
        if ($id <> '') {
            $this->db->where('id', $id);
            return $this->db->update('user_security_questions', $arr);
        } else {
            return $this->db->insert('user_security_questions', $arr);
        }
    }

    function get_user_questions($id) {
        $this->db->where('user_id', $id);
        return $this->db->get('user_security_questions')->row();
    }

    function add_email_services($email_services) {
        return $this->db->insert('email_preferences', $email_services);
    }

    function gat_email_services($user_id) {
        $this->db->where('user_id', $user_id);
        return $this->db->get('email_preferences')->row();
    }

    function update_email_services($user_id, $id, $val) {
        $this->db->set('user_id', $user_id);
        $this->db->set($id, $val);
        return $this->db->update('email_preferences');
    }

    public function get_datatables($role) {
        $this->_get_datatables_query($role);

        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);

        $this->db->order_by('id', 'desc');

        $query = $this->db->get();

        return $query->result();
    }

    public function get_active_users_datatables($role) {
        $this->_get_datatables_query($role);

        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);

        $this->db->where(['status' => 1]);
        $this->db->order_by('id', 'desc');

        $query = $this->db->get();

        return $query->result();
    }

    public function get_inactive_users_datatables($role) {
        $this->_get_datatables_query($role);

        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);

        $this->db->where(['status' => 0]);
        $this->db->order_by('id', 'desc');

        $query = $this->db->get();

        return $query->result();
    }

    public function count_filtered($role) {
        $this->_get_datatables_query($role);

        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all() {
        $this->db->from($this->_table);
        return $this->db->count_all_results();
    }

    private function _get_datatables_query($role) {

        $this->db->select($this->_select);
        $this->db->from($this->_table);

        if ($role == '0') {
            $this->db->where('id!=', $role);
        } else {
            $this->db->where('role', $role);
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
            $this->db->order_by($this->_column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } elseif (isset($this->_order)) {
            $order = $this->_order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    public function addEmailVerification($data) {
        $this->db->where('email', $data['email']);
        $query = $this->db->get($this->_tableEmailVerification)->result_array();
        if (count($query) >= 1) {
            $this->db->where('email', $data['email']);
            return $this->db->update($this->_tableEmailVerification, $data);
        } else {
            $this->db->insert($this->_tableEmailVerification, $data);
            return $this->db->insert_id();
        }
    }

    // public function getVerficationDetailsByEmail($email) 
    // {
    // $this->db->where(["email" => $email]);
    // $this->db->order_by("id", "DESC");
    // $this->db->limit("1");
    // $query = $this->db->get($this->_tableEmailVerification);
    // return $query->row();
    // }

    public function getVerficationDetailsByEmail($email) {
        $this->db->where(["email" => $email]);
        $query = $this->db->get($this->_table);
        return $query->row();
    }

    /* Ravindra Add this functionality for email and Mobile Forget Password */

    public function getVerficationDetailsByEmail1($email) {
        $this->db->where(["email" => $email]);
        $this->db->or_where(["phone" => $email]);
        $query = $this->db->get($this->_table);
        return $query->row();
    }

    function updateEmailVerification($email, $data) {
        $this->db->where(["email" => $email]);
        $this->db->update($this->_tableEmailVerification, $data);
    }

    function store_email_verification_code($otp, $arr) {
        if ($otp <> '') {
            $res = $this->db->get_where('email_verification', array("captcha" => $otp));
            if ($res) {
                $this->db->set('verify_email', 1);
                return $this->db->update('email_verification');
            } else {
                return false;
            }
        }
        return $this->db->insert('email_verification', $arr);
    }

    function update_email($user_id, $email_address) {
        $this->db->set('email', $email_address);
        $this->db->where('id', $user_id);
        return $this->db->update($this->_table);
    }

    /*     * ***************************************************** */

    public function addMobileOtp($data) {
        $this->db->insert($this->_tableMobileVerification, $data);
        return $this->db->insert_id();
    }

    public function getMobileOtpByMobileNo($mobile, $tag = '') {
       
        if ($tag == 'register') {
            $this->db->select('*');
            $this->db->from($this->_tableMobileVerification);
            $this->db->where('mobile', $mobile);
            $this->db->order_by('id','desc');
            $this->db->limit("1");
            return $query = $this->db->get()->row();
            
        }else{
            $this->db->select('*');
            $this->db->from('users');
            $this->db->where('username', $mobile);
            $this->db->or_where('phone', $mobile);
            $this->db->limit("1");
            $query = $this->db->get()->row();

            $phone = $query->phone;
            $this->db->or_where(["mobile" => $phone]);
            $this->db->order_by("id", "DESC");
            $this->db->limit("1");
            $query = $this->db->get($this->_tableMobileVerification);
            return $query->row();
        }
    }

    public function updateMobileOtp($data, $id) {
        $this->db->where(["id" => $id]);
        $this->db->update($this->_tableMobileVerification, $data);
    }

    public function setPrimaryNeedData($user_id, $primary_need) {
        $this->db->where('user_id', $user_id);
        $query = $this->db->get('user_preferences');

        if ($query->num_rows() > 0) {
            $this->db->set('primary_need', $primary_need);
            $this->db->where('user_id', $user_id);
            $this->db->update('user_preferences');
        } else {
            $this->db->set('primary_need', $primary_need);
            $this->db->set('user_id', $user_id);
            $this->db->insert('user_preferences');
        }
    }

    public function setSourcingReasonsPreferenceData($user_id, $preferred_sourcing_reasons_id) {

        $this->db->where('user_id', $user_id);
        $query = $this->db->get('user_preferences');

        if ($query->num_rows() > 0) {
            $this->db->set('preferred_sourcing_reasons_id', $preferred_sourcing_reasons_id);
            $this->db->where('user_id', $user_id);
            $this->db->update('user_preferences');
        } else {
            $this->db->set('preferred_sourcing_reasons_id', $preferred_sourcing_reasons_id);
            $this->db->set('user_id', $user_id);
            $this->db->insert('user_preferences');
        }
    }

    public function setRootCategoriesPreferenceData($user_id, $preferred_root_categories_id) {
        $this->db->where('user_id', $user_id);
        $query = $this->db->get('user_preferences');

        if ($query->num_rows() > 0) {
            $this->db->set('preferred_root_categories_id', $preferred_root_categories_id);
            $this->db->where('user_id', $user_id);
            $this->db->update('user_preferences');
        } else {
            $this->db->set('preferred_root_categories_id', $preferred_root_categories_id);
            $this->db->set('user_id', $user_id);
            $this->db->insert('user_preferences');
        }
    }

    public function setSubCategoriesPreferenceData($user_id, $preferred_sub_categories_id) {
        $this->db->where('user_id', $user_id);
        $query = $this->db->get('user_preferences');

        if ($query->num_rows() > 0) {
            $this->db->set('preferred_sub_categories_id', $preferred_sub_categories_id);
            $this->db->where('user_id', $user_id);
            $this->db->update('user_preferences');
        } else {
            $this->db->set('preferred_sub_categories_id', $preferred_sub_categories_id);
            $this->db->set('user_id', $user_id);
            $this->db->insert('user_preferences');
        }
    }

    public function setAnnualPurchasingAmountData($user_id, $annual_purchasing_amount) {
        $this->db->where('user_id', $user_id);
        $query = $this->db->get('user_purchasing_behaviour');

        if ($query->num_rows() > 0) {
            $this->db->set('annual_purchasing_amount', $annual_purchasing_amount);
            $this->db->where('user_id', $user_id);
            $this->db->update('user_purchasing_behaviour');
        } else {
            $this->db->set('annual_purchasing_amount', $annual_purchasing_amount);
            $this->db->set('user_id', $user_id);
            $this->db->insert('user_purchasing_behaviour');
        }
    }

    public function setAnnualPurchasingFrequencyData($user_id, $annual_purchasing_frequency) {
        $this->db->where('user_id', $user_id);
        $query = $this->db->get('user_purchasing_behaviour');

        if ($query->num_rows() > 0) {
            $this->db->set('annual_purchasing_frequency', $annual_purchasing_frequency);
            $this->db->where('user_id', $user_id);
            $this->db->update('user_purchasing_behaviour');
        } else {
            $this->db->set('annual_purchasing_frequency', $annual_purchasing_frequency);
            $this->db->set('user_id', $user_id);
            $this->db->insert('user_purchasing_behaviour');
        }
    }

    /*
     * address book by user id
     */

    public function getAddressBook($userid) {
       // $this->db->where(["user_id" => $userid]);
        //$this->db->join("country C", "C.id = ADD.country", "LEFT");
        //$this->db->order_by("id", "DESC");
        //$query = $this->db->get($this->_tableAddressBook . " ADD");
        $this->db->select('*');
        $this->db->from("address_book ad");
        $this->db->join("country C", "C.id = ad.country", "LEFT");
        $this->db->where("ad.user_id",$userid);
        $this->db->order_by("ad.address_book_id", "DESC"); 
        $query = $this->db->get();
        return $query->result();
    }

    /*
     * address book by id
     */

    public function getAddressBookById($id) {
        $this->db->where(["address_book_id" => $id]);
        $query = $this->db->get($this->_tableAddressBook);
        return $query->row();
    }

    public function addAddressBook($data) {
        $this->db->insert($this->_tableAddressBook, $data);
        return $this->db->insert_id();
    }

    public function updateAddressBook($id, $data) {
        $this->db->where(["address_book_id" => $id]);
        $query = $this->db->update($this->_tableAddressBook, $data);
    }

    public function updateAllAddressBookByUser($userid, $data, $default_add_id = 0) {
        $this->db->where(["user_id" => $userid]);
        $this->db->where("address_book_id !=" . $default_add_id);
        $query = $this->db->update($this->_tableAddressBook, $data);
    }

    public function getShippingAddressDetails($id) {
        $this->db->where(["address_book_id" => $id]);
        return $this->db->get($this->_tableAddressBook)->row();
    }

    public function removeAddress($id) {
        $this->db->where(["address_book_id" => $id]);
        $this->db->delete($this->_tableAddressBook);
    }

    public function changePasswordData($new_password, $user_id) {
        $this->db->set('password', $new_password);
        $this->db->where("id", $user_id);
        $this->db->update($this->_table);
        return true;
    }

    public function getEmailsByIds($ids) {
        $this->db->select("email");
        $this->db->where_in("id", $ids);
        $query = $this->db->get($this->_table);
        return $query->result_array();
    }

    //add to cart
    public function getEmailsById($id) {
        $this->db->select("email,password"); // add Password Column Extra
        $this->db->where("id", $id);
        $query = $this->db->get($this->_table);
        return $query->row_array();
    }

    //for Start Order
    function get_buyer_info($user_id) {
        $this->db->select('*');
        $this->db->from('users a');
        $this->db->join('address_book b', 'a.id = b.user_id', 'left');
        $this->db->join('country c', 'c.id = b.country', 'left');
        $this->db->where('a.id', $user_id);
        $query = $this->db->get();
        return $query->row_array();
    }

    //NEW
    function get_buyer_info1($user_id) {
        $this->db->select('*');
        $this->db->from('users a');
        $this->db->join('address_book b', 'a.id = b.user_id', 'left');
        $this->db->join('country c', 'c.id = b.country', 'left');
        $this->db->where('a.id', $user_id);
        $this->db->order_by("b.address_book_id", "desc");
        // $this->db->limit(3);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function getDefaultAddressBook($id) {
        $this->db->select("$this->_tableAddressBook.*,country.name as country_name");
        $this->db->join("country", "$this->_tableAddressBook.country = country.id");
        $query = $this->db->get_where($this->_tableAddressBook, ["user_id" => $id, "is_default" => 1]);
        return $query->row();
    }

    public function searchSellerByName($search) {
        $this->db->select("company_name,user_id");
        $this->db->like('company_name', $search, 'both');
        $query = $this->db->get('seller_company_details');
        return $query->result();
    }

    public function addUserDeviceDetails($data) {
        $this->db->insert("users_firebase_details", $data);
        return $this->db->insert_id();
    }

    public function updateUserDeviceDetails($user_id, $device_data) {
        $this->db->where(["user_id" => $user_id]);
        $this->db->update("users_firebase_details", $device_data);
        return $this->db->affected_rows();
    }

    public function checkPickupaddressAvailable($user_id) {
        $this->db->select('pick_id');
        $this->db->where("user_id", $user_id);
        $query = $this->db->get('seller_pick_address');

        if ($query->num_rows()) {
            return true;
        } else {
            return false;
        }
    }

    public function addSocialAuth($data) {
        $this->db->insert("user_social_access", $data);
        return $this->db->insert_id();
    }

    public function getSocialAuth($user) {
        $query = $this->db->get_where("user_social_access", ["user_id" => $user]);
        return $query->row();
    }

    public function getSellerInfo($seller_id) {
        
        $this->db->select('u.id,u.first_name,u.last_name,sc.company_name');
        $this->db->from('users u');
        $this->db->join('seller_company_details sc', 'sc.user_id = u.id','LEFT');
        $this->db->where("u.id", $seller_id);
        $query = $this->db->get();
        
        return $query->row_array();
    }

    public function getSellerAndCompanyInfo($seller_id) {
        $this->db->select('u.*,sc.*,sc.company_name as compname, si.*,c.name as countryname');
        $this->db->from('users u');
        $this->db->join('seller_info si', 'si.user_id = u.id');
        $this->db->join('country c', 'c.id = u.country');
        $this->db->join('seller_company_details sc', 'sc.user_id = u.id');
        $this->db->where("u.id", $seller_id);
        $query = $this->db->get();
        return $query->row_array();
    }

    public function getUsersCartItemsCountData($user_id) {
        $this->db->select('id');
        $this->db->where('user_id', $user_id);
        $query = $this->db->get('add_to_cart');
        $result = $query->num_rows();
        return $result;
    }

    public function get_unapproved_sellers() {
        $this->db->select('count(id)');
        $this->db->where(['approved_status' => 'Pending', 'role' => 'seller']);
        $this->db->or_where('role', 'both');
        $query = $this->db->get('users');
        $result = $query->result_array();
        return $result[0]['count(id)'];
    }

    /*     * ****************** Functions to get sellers buyers list in datatables ajax ********************** */

    public function get_datatables_buyers($seller) {
        $this->_get_datatables_query_buyers($seller);

        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);

        $query = $this->db->get();
        echo $this->db->last_query();
        exit;
        return $query->result();
    }

    public function count_filtered_buyers($seller) {
        $this->_get_datatables_query_buyers($seller);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all_buyers_buyers($seller) {
        $this->db->from($this->_table . " U ");
        $this->db->join("orders O", "O.user_id = U.id");
        $this->db->join("orders_products OP", "OP.orders_id = O.orders_id");
        $this->db->join("product_details PD", "OP.products_id = PD.id");
        $this->db->where(["PD.seller" => $seller]);

        return $this->db->count_all_results();
    }

    private function _get_datatables_query_buyers($seller) {
        $searchK = ["U.email", "U.phone"];

        $this->db->select("DISTINCT(U.id), U.first_name, U.last_name,U.email, U.phone");
        $this->db->from($this->_table . " U ");
        $this->db->join("orders O", "O.user_id = U.id");
        $this->db->join("orders_products OP", "OP.orders_id = O.orders_id");
        $this->db->join("product_details PD", "OP.products_id = PD.id");
        $this->db->where(["PD.seller" => $seller]);

        $i = 0;

        foreach ($searchK as $item) {
            if ($_POST['search']['value']) {

                if ($i === 0) {
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->db->like($item, $_POST['search']['value']);
                } else {
                    $this->db->or_like($item, $_POST['search']['value']);
                }

                if (count($searchK) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }
    }

    /*     * **************************
     * Ajax server side users list in admin panel
     */

    public function get_datatablesUsers($status,$from,$to) {
        $this->_get_datatablesUsers_query($status,$from,$to);

        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);

        $this->db->order_by("$this->_table.id", 'desc');

        $query = $this->db->get();
  
         return $query->result();
    }

    public function count_filtered_users($status,$from,$to) {
        $this->_get_datatablesUsers_query($status,$from,$to);

        $query = $this->db->get();
        return $query->num_rows();
    }

    /*
     * Term users used for buyers
     */

    public function count_all_users() {
        $this->db->from($this->_table);
        $this->db->join("orders", "orders.user_id = $this->_table.id", "LEFT");
        $this->db->group_by("$this->_table.id");
        $this->db->where(["role" => "buyer"]);
        $this->db->having("COUNT(orders.orders_id) > 0");
        return $this->db->count_all_results();
    }

    private function _get_datatablesUsers_query($status, $from,$to) {
        $this->db->select($this->_select2);
        $this->db->from($this->_table);
        $this->db->join("orders", "orders.user_id = $this->_table.id", "LEFT");
        $this->db->join("buyer_wallet w", "w.user_id = $this->_table.id", "LEFT");
        $this->db->group_by("$this->_table.id");
        $this->db->where(["role" => "buyer"]);
        if ($status) {
            $this->db->having("COUNT(orders.orders_id) > 0");
        } else {
            //$this->db->where("orders.user_id IS NULL");
        }
        if ($from != '' && $to != '' || $from != NULL) { // To process our custom input parameter
            $this->db->where('date(created_on) BETWEEN "' . date('Y-m-d', strtotime($from)) . '" and "' . date('Y-m-d', strtotime($to)) . '"');
        }

        $i = 0;
       
        foreach ($this->_column_search as $item) {
            if ($_POST['search']['value']) {

                if ($i === 0) {
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->db->like("$this->_table.$item", $_POST['search']['value']);
                } else {
                    $this->db->or_like("$this->_table.$item", $_POST['search']['value']);
                }

                if (count($this->_column_search) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }

        if (isset($_POST['order'])) {
            $this->db->order_by($this->_column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } elseif (isset($this->_order)) {
            $order = $this->_order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
       
    }

    /*     * **************************
     * Ajax server side vendors list in admin panel
     */

    public function get_datatablesVendors($status) {
        //$select = "users.*,COUNT(orders.orders_id) as total_orders";
        $this->_get_datatablesVendors_query($status);

        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);

        $this->db->order_by('id', 'desc');

        $query = $this->db->get();

        return $query->result();
    }

    public function count_filtered_vendors($status) {
        $this->_get_datatablesVendors_query($status);
        $query = $this->db->get();
        return $query->num_rows();
    }

    /*
     * Term users used for buyers
     */

    public function count_all_vendors() {
        $this->db->from($this->_table);
        $this->db->where(["role" => "seller"]);
        return $this->db->count_all_results();
    }

    private function _get_datatablesVendors_query($status) {
        $this->db->select($this->_select . ",seller_company_details.company_name,categories_description.categories_name as preferred_category");
        $this->db->from($this->_table);
        $this->db->join("orders", "orders.seller_id = $this->_table.id", "LEFT");
        $this->db->join("seller_company_details", "seller_company_details.user_id = $this->_table.id", "LEFT");
        $this->db->join("user_preferred_categories", "user_preferred_categories.user_id = $this->_table.id", "LEFT");
        $this->db->join("categories_description", "user_preferred_categories.category = categories_description.categories_id", "LEFT");
        $this->db->group_by("$this->_table.id");
        $this->db->where(["role" => "seller"]);
        $this->db->where("$this->_table.status", 1);
        $this->db->where("$this->_table.approved_status", $status);
        
        if ($this->input->post('dateFrom') != "") {
            
            $this->db->where("date($this->_table.created_on) >=", date('Y-m-d', strtotime($this->input->post('dateFrom'))));
        }
        if ($this->input->post('dateTo') != "") {
            $this->db->where("date($this->_table.created_on) <=", date('Y-m-d', strtotime($this->input->post('dateTo'))));
        }
        
        $i = 0;

        foreach ($this->_column_search as $item) {
            if ($_POST['search']['value']) {

                if ($i === 0) {
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->db->like("$this->_table." . $item, $_POST['search']['value']);
                } else {
                    $this->db->or_like("$this->_table." . $item, $_POST['search']['value']);
                }

                if (count($this->_column_search) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }

        if (isset($_POST['order'])) {
            $this->db->order_by($this->_column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } elseif (isset($this->_order)) {
            $order = $this->_order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }
    
    
    public function getBannedVendorstable() {
        $this->_getBannedVendorstable_query();
            
        if ($_POST['length'] != -1)
          $this->db->limit($_POST['length'], $_POST['start']);
          $query = $this->db->get();
        return $query->result();
    }

    public function count_filtered_bannedvendors() {
        $this->_getBannedVendorstable_query();
        $query = $this->db->get();
        return $query->num_rows();
    }

    /*
     * Term users used for buyers
     */

    public function count_banned_vendors() {
        $this->db->from($this->_table);
        $this->db->where(["role" => "seller"]);
        return $this->db->count_all_results();
    }

    private function _getBannedVendorstable_query() {
        $this->db->select("users.*,seller_company_details.company_name");
        $this->db->from($this->_table);
        $this->db->join("seller_company_details", "seller_company_details.user_id = $this->_table.id", "LEFT");
        $this->db->where(["role" => "seller"]);
        $this->db->where("$this->_table.status", 0);
        $i = 0;
        foreach ($this->_column_search as $item) {
            if ($_POST['search']['value']) {

                if ($i === 0) {
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->db->like("$this->_table." . $item, $_POST['search']['value']);
                } else {
                    $this->db->or_like("$this->_table." . $item, $_POST['search']['value']);
                }

                if (count($this->_column_search) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }

        if (isset($_POST['order'])) {
            $this->db->order_by($this->_table.".id", $_POST['order']['0']['dir']);
        } elseif (isset($this->_order)) {
            $order = $this->_order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }
    
    public function setDefaultAddress($user_id, $address_id) {
        $this->db->where(["user_id" => $user_id]);
        $this->db->update($this->_tableAddressBook, ["is_default" => 0]);
        $this->db->where(["address_book_id" => $address_id]);
        $this->db->update($this->_tableAddressBook, ["is_default" => 1]);
    }

    public function get_topselectedSeller() {
        $this->db->select('*');
        $this->db->from('users u');
        $this->db->join('seller_company_details scd', 'u.id = scd.user_id');
        $this->db->where('scd.is_topSelected', 1);
        $this->db->where('u.role', 'seller');
        $result = $this->db->get()->result_array();

        if ($result) {
            foreach ($result as $key => $row) {
                $this->db->where('seller_id', $row['user_id']);
                $this->db->from('orders');
                $result[$key]['orders_count'] = $this->db->get()->num_rows();
            }
        }
        return $result;
    }

    function get_firbase_id($user_id) {

        $this->db->select('firebase_id');
        $this->db->from('users_firebase_details');
        $this->db->where('user_id', $user_id);
        $query = $this->db->get()->row();

        return $query->firebase_id;
    }

    function getEmailMobile($user_id) {
        $this->db->select('email,phone');
        $this->db->where('id', $user_id);
        return $this->db->get($this->_table)->row();
    }

    function updateEmailMobile($user_id, $data, $phone) {
        $this->db->where('id', $user_id);
        if ($data != '') {
            $this->db->set('email', $data['email']);
            $this->db->set('username', $data['email']);
        } else {
            $this->db->set('phone', $phone);
        }
        return $this->db->update($this->_table);
    }

    function Is_email($username) {

        //If the username input string is an e-mail, return true
        if (filter_var($username, FILTER_VALIDATE_EMAIL)) {
            return true;
        } else {
            return false;
        }
    }
	
	function get_user_notifications($user_id)
	{
		$this->db->where('user_id',$user_id);
		$this->db->where('status','Received');
		return $this->db->get('buyer_notification')->result_array();
	}
	
	function update_notification($id)
	{
		$this->db->where('id',$id);
		$this->db->set('status','Read');
		return $this->db->update('buyer_notification');
	}
	

}
