<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Myfavourite_model extends CI_Model {

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
        $this->_tableSellerCompanyDetails = "seller_company_details";
        $this->_tableCompanyTypes = "company_types";
        $this->_tableEmailVerification = "email_verification";
        $this->_tableMobileVerification = "mobile_verification";
        $this->_tableAddressBook = "address_book";
        $this->_tableSellerPreferences = "user_preferences";
        $this->_tableUserPurchasingBehaviour = "user_purchasing_behaviour";
        $this->_tableCountry = "country";
    }

    public function getAll() {
        $query = $this->db->get($this->_table);
        return $query->result();
    }

    function allproduct_count($user_id) {
        $this->db->select('*');
        $this->db->from('buyer_favourites');
        $this->db->where('user_id', $user_id);
        $query = $this->db->get();
        $result = $query->row_array();
        $p_fav = json_decode($result['products']);
        if (empty($p_fav)) {
            $p_fav = array(0 => 0);
        }


        $this->db->select('*');
        $this->db->from('products a');
        $this->db->join('products_description c', 'c.products_id = a.products_id');
        $this->db->join('units b', 'b.units_id = a.units_id');

        $this->db->where_in('a.products_id', $p_fav);
        $this->db->limit($limit, $start);
        $this->db->order_by($col, $dir);
        $query = $this->db->get();

        return $query->num_rows();
    }

    function product_det($pro_id) {
        $this->db->select('*');
        $this->db->from('products a');
        $this->db->join('units b', 'b.units_id = a.units_id');
        $this->db->join('products_description c', 'c.products_id = a.products_id');
        $this->db->where('a.products_id', $pro_id);
        $query = $this->db->get();
        return $query->row();
    }

    function allproducts($user_id, $limit, $start, $col, $dir) {
        $this->db->select('*');
        $this->db->from('buyer_favourites');
        $this->db->where('user_id', $user_id);
        $query = $this->db->get();
        $result = $query->row_array();
        $p_fav = json_decode($result['products']);
        if (empty($p_fav)) {
            $p_fav = array(0 => 0);
        }


        $this->db->select('*');
        $this->db->from('products a');
        $this->db->join('units b', 'b.units_id = a.units_id');
        $this->db->join('products_description c', 'c.products_id = a.products_id');

        $this->db->where_in('a.products_id', $p_fav);
        $this->db->limit($limit, $start);
        $this->db->order_by($col, $dir);
        $query = $this->db->get();


        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return null;
        }
    }

    function remove_favourite($user_id, $p_id) {
        $dat = $this->Common_model->getAll('buyer_favourites', array('user_id' => $user_id))->row_array();

        $all_fav = json_decode($dat['products']);
        $pass_arr = $p_id;
        if (($key = array_search($p_id, $all_fav)) !== false) {
            unset($all_fav[$key]);
        }
        // $data_set['products'] = json_encode($all_fav);
        // $this->Common_model->update("buyer_favourites", $data_set, array("user_id" => $user_id));
        exit;
    }

    function product_search($user_id, $limit, $start, $search, $col, $dir) {

        $this->db->select('*');
        $this->db->from('buyer_favourites');
        $this->db->where('user_id', $user_id);
        $query = $this->db->get();
        $result = $query->row_array();
        $p_fav = json_decode($result['products']);
        if (empty($p_fav)) {
            $p_fav = array(0 => 0);
        }


        $this->db->select('*');
        $this->db->from('products a');
        $this->db->join('units b', 'b.units_id = a.units_id');
        $this->db->join('products_description c', 'c.products_id = a.products_id');

        $this->db->where_in('a.products_id', $p_fav);
        $this->db->where("(`c`.`products_name` LIKE '%" . $search . "%' ESCAPE '!' OR `c`.`products_alias` LIKE '%" . $search . "%' ESCAPE '!')");
        $this->db->limit($limit, $start);
        $this->db->order_by($col, $dir);
        $query = $this->db->get();


        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return null;
        }
    }

    function product_search_count($user_id, $search) {
        $this->db->select('*');
        $this->db->from('buyer_favourites');
        $this->db->where('user_id', $user_id);
        $query = $this->db->get();
        $result = $query->row_array();
        $p_fav = json_decode($result['products']);
        if (empty($p_fav)) {
            $p_fav = array(0 => 0);
        }


        $this->db->select('*');
        $this->db->from('products a');
        $this->db->join('products_description c', 'c.products_id = a.products_id');

        $this->db->where_in('a.products_id', $p_fav);
        $this->db->where("(`c`.`products_name` LIKE '%" . $search . "%' ESCAPE '!' OR `c`.`products_alias` LIKE '%" . $search . "%' ESCAPE '!')");
        $this->db->limit($limit, $start);
        $this->db->order_by($col, $dir);
        $query = $this->db->get();

        return $query->num_rows();
    }

    ///////////////Seller /////////////////////
    function allseller_count($user_id) {
        $this->db->select('*');
        $this->db->from('buyer_favourites');
        $this->db->where('user_id', $user_id);
        $query = $this->db->get();
        $result = $query->row_array();
        $p_fav = json_decode($result['suppliers']);
        if (empty($p_fav)) {
            $p_fav = array(0 => 0);
        }


        $this->db->select('*');
        $this->db->from('users a');
        $this->db->join('seller_company_details c', 'c.user_id = a.id');
        $this->db->where_in('a.id', $p_fav);
        $query = $this->db->get();

        return $query->num_rows();
    }

    function allseller($user_id, $limit, $start, $col, $dir) {
        $this->db->select('*');
        $this->db->from('buyer_favourites');
        $this->db->where('user_id', $user_id);
        $query = $this->db->get();
        $result = $query->row_array();
        $p_fav = json_decode($result['suppliers']);
        if (empty($p_fav)) {
            $p_fav = array(0 => 0);
        }


        $this->db->select('*');
        $this->db->from('users a');
        $this->db->join('seller_company_details c', 'c.user_id = a.id');
        $this->db->where_in('a.id', $p_fav);
        $this->db->limit($limit, $start);
        $this->db->order_by($col, $dir);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return null;
        }
    }

    function seller_search($user_id, $limit, $start, $search, $col, $dir) {

        $this->db->select('*');
        $this->db->from('buyer_favourites');
        $this->db->where('user_id', $user_id);
        $query = $this->db->get();
        $result = $query->row_array();
        $p_fav = json_decode($result['suppliers']);
        if (empty($p_fav)) {
            $p_fav = array(0 => 0);
        }


        $this->db->select('*');
        $this->db->select('*');
        $this->db->from('users a');
        $this->db->join('seller_company_details c', 'c.user_id = a.id');
        $this->db->where_in('a.id', $p_fav);
        $this->db->where("(`c`.`first_name` LIKE '%" . $search . "%' ESCAPE '!' OR `c`.`company_name` LIKE '%" . $search . "%' ESCAPE '!')");
        $this->db->limit($limit, $start);
        $this->db->order_by($col, $dir);
        $query = $this->db->get();


        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return null;
        }
    }

    function seller_search_count($user_id, $search) {
        $this->db->select('*');
        $this->db->from('buyer_favourites');
        $this->db->where('user_id', $user_id);
        $query = $this->db->get();
        $result = $query->row_array();
        $p_fav = json_decode($result['suppliers']);
        if (empty($p_fav)) {
            $p_fav = array(0 => 0);
        }


        $this->db->select('*');
        $this->db->from('users a');
        $this->db->join('seller_company_details c', 'c.user_id = a.id');
        $this->db->where_in('a.id', $p_fav);
        $this->db->where("(`c`.`first_name` LIKE '%" . $search . "%' ESCAPE '!' OR `c`.`company_name` LIKE '%" . $search . "%' ESCAPE '!')");
        $this->db->limit($limit, $start);
        $this->db->order_by($col, $dir);
        $query = $this->db->get();

        return $query->num_rows();
    }

    function supplier_det($seller_id) {
        $this->db->select('*');
        $this->db->from('users a');
        $this->db->join('seller_company_details c', 'c.user_id = a.id', 'left');
        $this->db->where('a.id', $seller_id);
        $query = $this->db->get();

        return $query->row();
    }

    function fav_seller_remove($user_id, $p_id) {
        $dat = $this->Common_model->getAll('buyer_favourites', array('user_id' => $user_id))->row_array();

        $all_fav = json_decode($dat['suppliers']);
        $pass_arr = $p_id;

        $new_array = array_diff($all_fav, $pass_arr);

        $data_set['suppliers'] = json_encode($new_array);

        $this->Common_model->update("buyer_favourites", $data_set, array("user_id" => $user_id));
    }

    function updateFavourite($id, $data) {
        $this->db->where(["id" => $id]);
        $this->db->update("buyer_favourites", $data);
    }

    //////////////////Web Service Model ////////////////////////
    //////////////////Web Service Model ////////////////////////
    function ws_favourite_product($user_id) {
        $this->db->select('*');
        $this->db->from('buyer_favourites');
        $this->db->where('user_id', $user_id);
        $query = $this->db->get();
        $result = $query->row_array();
        $p_fav = json_decode($result['products']);
        if (empty($p_fav)) {
            $p_fav = array(0 => 0);
        }

        $this->db->select('P.id as product_id,P.seller as seller_id,SCD.company_name,SCD.logo,users.user_package,company_types.name as seller_type,TIMESTAMPDIFF(YEAR, `seller_info.date_created`, CURDATE()) AS supplier_company_age,P.name as product_name,C.categories_name,PM.type as media_type, PM.url as media_url,PC1.price as price1,PC2.price as price2,PC1.final_price as final_price1,PC2.final_price as final_price2,units.units_name,PC1.quantity_from as moq,PC1.atz_price as mrp,P.discount_percentage as discount,'
                .'offer_type,discount_value as offer_discount_value,oz.status as offer_status'
        .',oz.title,oz.title,timestamp(valid_from, time_from) offer_start_time, '
        .'timestamp(valid_to, time_to) offer_end_time');
        $this->db->from("product_details P");
        $this->db->join("categories_description C", "P.category = C.categories_id", 'left');
//        $this->db->join("offer_categories oc", "oc.category_id = C.categories_id", 'left');
//        $this->db->join("offer_zone oz", " oz.offer_id = oc.offer_id", 'left');
        
        $this->db->join("offer_categories oc", "oc.category_id = P.category AND oc.offer_id = (SELECT oz.offer_id FROM offer_zone oz WHERE oz.status = 'ACTIVE' AND oz.offer_id = oc.offer_id limit 1)", 'left');
        $this->db->join("offer_zone oz", " oz.offer_id = oc.offer_id", 'left');
        
        $this->db->join("product_media PM", "PM.id = (SELECT id FROM product_media PM1 WHERE "
                . "PM1.product_id = P.id ORDER BY PM1.id ASC LIMIT 1)", 'left');
        $this->db->join("product_price PC1", "PC1.id = (SELECT id FROM product_price PC3 WHERE "
                . "PC3.product_id = P.id ORDER BY PC3.id ASC LIMIT 1)", 'left');
        $this->db->join("product_price PC2", "PC2.id = (SELECT id FROM product_price PC4 WHERE "
                . "PC4.product_id = P.id ORDER BY PC4.id DESC LIMIT 1)", 'left');
        $this->db->join("users as users", "users.id=P.seller", "left");
        $this->db->join("seller_info as seller_info", "seller_info.user_id=P.seller", "left");
        $this->db->join("company_types as company_types", "company_types.id=seller_info.company_type", "left");
        $this->db->join("seller_company_details SCD ", "SCD.user_id = seller_info.user_id", "LEFT");
        $this->db->join("units as units", "PC1.unit=units.units_id", "left");
        $this->db->where_in('P.id', $p_fav);
        $query = $this->db->get();


        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return [];
        }
    }

    function ws_favourite_supplier($user_id) {
        $this->db->select('*');
        $this->db->from('buyer_favourites');
        $this->db->where('user_id', $user_id);
        $query = $this->db->get();
        $result = $query->row_array();

        $p_fav = json_decode($result['suppliers']);
        if (empty($p_fav)) {
            $p_fav = array(0 => 0);
        }

        $this->db->select("U.id as slrid,U.first_name,U.last_name,U.user_package,SCD.company_name,SCD.logo,CC.name as country_name,U.email,U.phone,U.profile_photo,UPB.annual_purchasing_amount,UPB.annual_purchasing_frequency,CT.name as companyType,"
                . "SI.address1 as address," . "SP.*");
        $this->db->from($this->_table_user . " U ");
        $this->db->join($this->_tableSellerInfo . " SI ", "SI.user_id = U.id", "LEFT");
        $this->db->join($this->_tableCompanyTypes . " CT ", "CT.id = SI.company_type", "LEFT");
        $this->db->join($this->_tableSellerPreferences . " SP ", "U.id = SP.user_id", "LEFT");
        $this->db->join($this->_tableUserPurchasingBehaviour . " UPB ", "U.id = UPB.user_id", "LEFT");
        $this->db->join($this->_tableCountry . " CC ", "U.country = CC.id", "LEFT");
        $this->db->join($this->_tableSellerCompanyDetails . " SCD ", "SCD.user_id = SI.user_id", "LEFT");
        
        //$this->db->where(array("U.id" => $id));
        $this->db->where_in('U.id', $p_fav);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            $res = $query->result_array();

            for ($i = 0; $i < count($res); $i++) {


                $res[$i]['country_flag'] = base_url() . "assets/images/flags/png/in.png";
                $res[$i]['response_rate'] = "<24h";
                $res[$i]['response_time'] = "75.9%";
                $res[$i]['transactions'] = "$1000+";
            }
            return $res;
        } else {
            return [];
        }
    }
	
	function count_fav_products($user_id)
	{
		$this->db->select('products');
    	$this->db->where('user_id',$user_id);
    	$query=$this->db->get('buyer_favourites');
		return $query->row();
	}
    
    public function getUsersFaveriotes($user)
    {
        $this->db->where(["user_id"=>$user]);
        $query = $this->db->get("buyer_favourites");
        return $query->row();
    }
	
    public function getUsersFavouritesProducts($user_id)
    {
        $this->db->where(["user_id"=>$user_id]);
        $query = $this->db->get("buyer_favourites");
        return $query->row_array();
    }
	
	function deletefavoriteproduct($user_id,$id)
	{
		$dat = $this->Common_model->getAll('buyer_favourites', array('user_id' => $user_id))->row_array();
        $all_fav = json_decode($dat['products']);
        if (($key = array_search($id, $all_fav)) !== false) {
            unset($all_fav[$key]);
        }
	   $insert_array = array_values($all_fav);
	   $this->session->set_userdata('faverite_products', $insert_array);
	   
       $update_data = json_encode($insert_array);
	   $this->db->set('products',$update_data);
	   $this->db->where('id',$dat['id']);
	   return $this->db->update('buyer_favourites');
	}
	
	function deletefavoriteseller($user_id,$id)
	{
		$dat = $this->Common_model->getAll('buyer_favourites', array('user_id' => $user_id))->row_array();
        $all_fav = json_decode($dat['suppliers']);
        if (($key = array_search($id, $all_fav)) !== false) {
            unset($all_fav[$key]);
        }
	   $insert_array = array_values($all_fav);
       $update_data = json_encode($insert_array);
	   $this->db->set('suppliers',$update_data);
	   $this->db->where('id',$dat['id']);
	   return $this->db->update('buyer_favourites');
	}
}
