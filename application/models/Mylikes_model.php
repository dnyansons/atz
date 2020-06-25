<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Mylikes_model extends CI_Model {

    private $_table;
    private $_tableOrderProduct;

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->model('Common_model');
        $this->_table = "products";
        $this->_tableproducts_description = "products_description";
        $this->_tableproducts_images = "products_images";

        $this->_table_user = "users";
        $this->_tableSellerInfo = "seller_info";
        $this->_tableCompanyTypes = "company_types";
        $this->_tableEmailVerification = "email_verification";
        $this->_tableMobileVerification = "mobile_verification";
        $this->_tableAddressBook = "address_book";
        $this->_tableSellerPreferences = "user_preferences";
        $this->_tableUserPurchasingBehaviour = "user_purchasing_behaviour";
        $this->_tableCountry = "country";
    }

    public function getAll()
    {
        $query = $this->db->get($this->_table);
        return $query->result();
    }

    
    public function getUsersLikes($user)
    {
        $this->db->where(["user_id"=>$user]);
        $query = $this->db->get("buyer_likes");
        return $query->row();
    }

}