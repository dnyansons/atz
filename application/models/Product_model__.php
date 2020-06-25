<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Product_model extends CI_Model {

    private $_table, $_tableCategory, $_tableMedia, $_tablePrice, $_tableAttr, $_tableSpecs, $_tableUser, $_tableReviews, $_tableCompany;

    /** offer select parameters **/
    var $selectOffer = 'oz.offer_id,offer_type,discount_value as offer_discount_value,oz.status as offer_status, '
                . 'timestamp(valid_from, time_from) offer_start_time, '
                . 'timestamp(valid_to, time_to) offer_end_time ,oz.title,';
    
    /*
     * Following variables as supposed to be used with functions implemented for server side datatables
     */
    var $select = array(
        'P.publish_status',
        'P.low_stock_qty',
        'P.id as product_id',
        'P.name',
        'C.categories_name',
        'PM.type as media_type',
        'PM.url as media_url',
        'P.hike_percentage hike',
        'P.discount_percentage discount',
        'PC1.atz_price as atzprice1',
        'PC2.atz_price as atzprice2',
        'PC1.price as price1',
        'PC2.price as price2',
        'PC1.final_price as final_price',
        'PC1.final_price as final_price1',
        'PC2.final_price as final_price2',
        'P.seller',
        'P.available_quantity',
        'P.requested_on',
        'P.approved_on',
    );
    var $column_order = array('P.id',);
    var $column_search = array('P.id', 'P.name');
    var $order = array('P.id' => 'desc');

    public function __construct() {
        parent::__construct();
        $this->_table = "product_details";
        $this->_tableCategory = "categories_description";
        $this->_tableMedia = "product_media";
        $this->_tablePrice = "product_price";
        $this->_tableSpecs = "product_specifications";
        $this->_tableAttr = "product_attributes";
        $this->_tableUser = "users";
        $this->_tableReviews = "product_review";
        $this->_tableCompany = "seller_company_details";
    }

    public function addProduct($data) {
        $this->db->insert($this->_table, $data);
        return $this->db->insert_id();
    }

    public function updateProduct($id, $data) {
        $this->db->where('id', $id);
        $this->db->update($this->_table, $data);
        return true;
    }

    public function updateProductPublishStatus($id, $data) {
        $this->db->where('id', $id);
        $this->db->update($this->_table, $data);
        return $this->db->affected_rows();
    }

    /*
     * @param associative array of multiple attributes
     */

    public function addAttributes($data) {
        $this->db->insert_batch($this->_tableAttr, $data);
    }

    public function updateAttributes($id, $data) {
        $this->db->where('product_id', $id);
        $this->db->delete($this->_tableAttr);

        $this->db->insert_batch($this->_tableAttr, $data);
    }

    /*
     * @param associative array of multiple specifications
     */

    public function addSpecification($data) {
        $this->db->insert_batch($this->_tableSpecs, $data);
    }

    public function updateSpecification($id, $data) {
        $this->db->where('product_id', $id);
        $this->db->delete($this->_tableSpecs);

        $this->db->insert_batch($this->_tableSpecs, $data);
    }

    /*
     * @param associative array of multiple images
     */

    public function addMedia($data) {
        $this->db->insert_batch($this->_tableMedia, $data);
    }

    public function updateMedia($id, $data) {

        //$this->db->insert_batch($this->_tableMedia,$data);

        if ($data['type'] == "photo") {

            $this->db->where('product_id', $id);
            $this->db->where('type', 'photo');
            $this->db->delete($this->_tableMedia);

            for ($i = 0; $i < count($data['url']); $i++) {
                $this->db->set('type', $data['type']);
                $this->db->set('url', $data['url'][$i]);
                $this->db->set('product_id', $data['product_id']);
                $this->db->insert($this->_tableMedia);
                //echo $this->db->last_query();exit;
            }
        }


        if ($data['type'] == "video") {
            $this->db->where('product_id', $id);
            $this->db->where('type', 'video');
            $this->db->delete($this->_tableMedia);

            $this->db->set('type', $data['type']);
            $this->db->set('url', $data['url']);
            $this->db->set('product_id', $data['product_id']);
            $this->db->insert($this->_tableMedia);
        }
    }

    /*
     * @param associative array of multiple prices
     */

    public function addPrices($data) {
        $this->db->insert_batch($this->_tablePrice, $data);
    }

    public function updatePrices($id, $data) {
        $this->db->where('product_id', $id);
        $this->db->delete($this->_tablePrice);

        $this->db->insert_batch($this->_tablePrice, $data);
    }

    public function add_reviews($data) {
        $this->db->insert($this->_tableReviews, $data);
        return $this->db->insert_id();
    }

    public function updateReview($product_id, $data) {
        $this->db->where(["product_id" => $product_id]);
        $this->db->update($this->_tableReviews, $data);
        return $this->db->affected_rows();
    }

    public function incrementViewCount($product_id) {
        $this->db->where(["product_id" => $product_id]);
        $this->db->set('views', 'views+1', FALSE);
        $this->db->update($this->_tableReviews);
    }

    public function get_count($seller = 0) {
        if ($seller) {
            $this->db->where(["seller" => $seller]);
        }
        return $this->db->count_all($this->_table);
    }

    /*
     *
     */

    public function getProductList($seller = 0, $limit = 18, $start_from = 0, $category = 0) {
        $start_from = rand(0, 50);
        $select = "DISTINCT(P.id) as product_id,
        P.name,
        C.categories_name,
        PM.type as media_type,
        PM.url as media_url,
        PC1.price as price1,
        PC1.atz_price as mrp,
        P.discount_percentage as discount,
        PC2.price as price2,PC1.final_price as final_price1,
        PC2.final_price as final_price2,PC1.quantity_from as moq,PC1.unit as units_id,units.units_name,"
        .'offer_type,discount_value as offer_discount_value,oz.status, valid_from, time_from, valid_to,'
        .'time_to ,oz.title,P.category, parent_id';

        $this->db
                ->select($select)
                ->from($this->_table . " P")
                ->join($this->_tableCategory . " C", "P.category = C.categories_id")
                ->join("categories cat", "cat.category_id = P.category", 'left')
                ->join("offer_categories oc", "oc.category_id = cat.category_id ", 'left')
                ->join("offer_zone oz", " oz.offer_id = oc.offer_id AND oz.status = 'active'", 'left')
                ->join($this->_tableMedia . " PM", "PM.id = (SELECT id FROM $this->_tableMedia PM1 WHERE "
                        . "PM1.product_id = P.id ORDER BY PM1.id ASC LIMIT 1)")
                ->join($this->_tablePrice . " PC1", "PC1.id = (SELECT id FROM $this->_tablePrice PC3 WHERE "
                        . "PC3.product_id = P.id ORDER BY PC3.id ASC LIMIT 1)")
                ->join($this->_tablePrice . " PC2", "PC2.id = (SELECT id FROM $this->_tablePrice PC4 WHERE "
                        . "PC4.product_id = P.id ORDER BY PC4.id DESC LIMIT 1)")
                ->join('units as units', 'PC1.unit=units.units_id', 'LEFT')
                ->where("P.publish_status", "approved");

        if ($seller) {
            $this->db->where(["P.seller" => $seller]);
        }
        if ($category) {
            $this->db->where(["P.category" => $category]);
        }
        $this->db->limit($limit, $start_from);
        $query = $this->db->get($this->_table);
        $result = $query->result();
        return $result;
    }

    public function getProductsVideosList($seller = 0, $start_from = 0, $limit = 30) {

        $this->db->limit($limit, $start_from);
        $this->db->select($this->selectOffer.'P.id as product_id,P.description,P.seller as seller_id,users.first_name as seller_firstname,users.last_name as seller_lastname,users.phone as seller_phone_no,users.email as seller_email,scd.company_name as seller_company_name,scd.logo as company_logo,company_types.name as seller_type,TIMESTAMPDIFF(YEAR, `seller_info.date_created`, CURDATE()) AS supplier_company_age,P.name as product_name,C.categories_name,PM.url as media_url,PM2.url as video_url,PC1.price as price1,PC2.price as price2, PC1.final_price as final_price1,PC2.final_price as final_price2, PC1.quantity_from as moq1, PC2.quantity_from as moq2,units.units_id,units.units_name,PC1.atz_price as mrp,P.discount_percentage as discount');
        $this->db->from("product_details P");
        $this->offerJoins();
        $this->db->join("categories_description C", "P.category = C.categories_id", "LEFT");
        $this->db->join("product_media PM", "PM.id = (SELECT id FROM product_media PM1 WHERE "
                . "PM1.product_id = P.id and type='photo' ORDER BY PM1.id ASC LIMIT 1)", "LEFT");
        $this->db->join("product_media PM2", "PM.id = (SELECT id FROM product_media PM3 WHERE "
                . "PM3.product_id = P.id and type='video' ORDER BY PM3.id)", "LEFT");
        $this->db->join("product_price PC1", "PC1.id = (SELECT id FROM product_price PC3 WHERE "
                . "PC3.product_id = P.id ORDER BY PC3.id ASC LIMIT 1)");
        $this->db->join("product_price PC2", "PC2.id = (SELECT id FROM product_price PC4 WHERE "
                . "PC4.product_id = P.id ORDER BY PC4.id DESC LIMIT 1)");
        $this->db->join("users as users", "users.id=P.seller", "left");
        $this->db->join("seller_info as seller_info", "seller_info.user_id=P.seller", "left");
        $this->db->join("seller_company_details as scd", "P.seller=scd.user_id", "left");
        $this->db->join("company_types as company_types", "company_types.id=seller_info.company_type", "left");
        $this->db->join("units as units", "PC1.unit=units.units_id", "left");
        $this->db->where_in('P.seller', $seller);
        $query = $this->db->get();
        $result = $query->result_array();

        //echo $this->db->last_query();exit;

        for ($i = 0; $i < count($result); $i++) {

            if ($result[$i]['moq1'] < $result[$i]['moq2']) {
                $result[$i]['moq'] = $result[$i]['moq1'];
            } else {
                $result[$i]['moq'] = $result[$i]['moq2'];
            }

            if ($result[$i]['moq1'] != "" || $result[$i]['moq2'] != "") {
                unset($result[$i]['moq1']);
                unset($result[$i]['moq2']);
            }

            $result[$i]['company_logo'] = $result[$i]['company_logo'];

            $result[$i]['liked'] = false;
            $result[$i]['followed'] = false;
            $result[$i]['video_view_count'] = 0;
        }


        return $result;
    }

    /***********
     * Functions userd with server side datatables
     */
    public function get_datatables($from, $to,  $seller2, $category, $name, $publish_status,$bulk) {
        $this->_get_datatables_query($from, $to, $seller2, $category, $name, $publish_status,$bulk);
        
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
   
        return $query->result();
    }

    public function count_filtered($from, $to, $seller2, $category, $name, $publish_status,$bulk) {

          $this->_get_datatables_query($from, $to, $seller2, $category, $name, $publish_status,$bulk);

        $query = $this->db->get();

        return $query->num_rows();
    }

    public function count_all($seller = 0) {
        if ($seller) {
            $this->db->where(["P.seller" => $seller]);
        }
        $this->db->from($this->_table . " P");
        return $this->db->count_all_results();
    }

    private function _get_datatables_query($from, $to, $seller2, $category, $name, $publish_status,$bulk) {

        $this->db
                ->select($this->select)
                ->from($this->_table . " P")
                ->join($this->_tableCategory . " C", "P.category = C.categories_id")
                ->join($this->_tableMedia . " PM", "PM.id = (SELECT id FROM $this->_tableMedia PM1 WHERE "
                        . "PM1.product_id = P.id ORDER BY PM1.id ASC LIMIT 1)")
                ->join($this->_tablePrice . " PC1", "PC1.id = (SELECT id FROM $this->_tablePrice PC3 WHERE "
                        . "PC3.product_id = P.id ORDER BY PC3.id ASC LIMIT 1)")
                ->join($this->_tablePrice . " PC2", "PC2.id = (SELECT id FROM $this->_tablePrice PC4 WHERE "
                        . "PC4.product_id = P.id ORDER BY PC4.id DESC LIMIT 1)")
                ->where(["P.publish_status" => $publish_status]);

        if ($bulk !='') {
            $this->db->where(["P.bulk_upload" => $bulk]);
        }
        
        if ($from != '' && $to != '' || $from != NULL) { // To process our custom input parameter
            $this->db->where('date(p.created_at) BETWEEN "' . date('Y-m-d', strtotime($from)) . '" and "' . date('Y-m-d', strtotime($to)) . '"');
        }
        
        if ($seller2) {
            $this->db->where(["P.seller" => $seller2]);
        }

        if ($category != "") {
            $this->db->where(["P.category" => $category]);
        }

        if ($name != "") {
            $this->db->where(["P.name" => trim($name)]);
        }

        $i = 0;
        foreach ($this->column_search as $item) { // loop column
            //echo $item.'<br>';
            if ($_POST['search']['value']) { // if datatable send POST for search
                if ($i === 0) { // first loop
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    if ($item == 'P.id') {
                        $this->db->like($item, str_replace('PRD', '', $_POST['search']['value']));
                    } else {
                        $this->db->or_like($item, $_POST['search']['value']);
                    }
                } else {
                    if ($item == 'P.id') {
                        $this->db->like($item, str_replace('PRD', '', $_POST['search']['value']));
                    } else {
                        $this->db->or_like($item, $_POST['search']['value']);
                    }
                }

                if (count($this->column_search) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }
        //exit;
        if ($publish_status == "approved") {
            $this->db->order_by("approved_on", "DESC");
        } else if ($publish_status == "requested") {
            $this->db->order_by("requested_on", "DESC");
        }
        if (isset($_POST['order'])) { // here order processing
            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } elseif (isset($this->order)) { // default order processing
            $order = $this->order;

            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    public function getSelectedCategories($parent) {

        /* $this->db->select('b.categories_id, b.categories_name');
          $this->db->from('product_details as a');
          $this->db->join('categories_description as b', 'a.category=b.categories_id');
          $this->db->where('a.id', $product_id);
          $query=$this->db->get();
          $result=$query->row();
          return $result; */

        $this->db->select('t1.category_id,t2.categories_name');
        $this->db->from("categories t1 ");
        $this->db->join("categories_description t2 ", "t1.category_id = t2.categories_id");
        $this->db->where('t1.parent_id', $parent);

        $parent = $this->db->get();

        $categories = $parent->result();
        $i = 0;
        foreach ($categories as $p_cat) {

            $categories[$i]->sub = $this->sub_categories($p_cat->category_id);
            $i++;
        }
        return $categories;
    }

    /////////////// admin product ///////////////////



    function allproducts_count_admin() {
        $this->db->select('P.id as product_id,P.name,C.categories_name,PM.type as media_type,PM.url as media_url,PC1.price as price1,PC2.price as price2,PC1.final_price as final_price1,PC2.final_price as final_price2');
        $this->db->from($this->_table . " P");
        $this->db->join($this->_tableCategory . " C", "P.category = C.categories_id", "LEFT");
        $this->db->join($this->_tableMedia . " PM", "PM.id = (SELECT id FROM $this->_tableMedia PM1 WHERE "
                . "PM1.product_id = P.id ORDER BY PM1.id ASC LIMIT 1)", "LEFT");
        $this->db->join($this->_tablePrice . " PC1", "PC1.id = (SELECT id FROM $this->_tablePrice PC3 WHERE "
                . "PC3.product_id = P.id ORDER BY PC3.id ASC LIMIT 1)", "LEFT");
        $this->db->join($this->_tablePrice . " PC2", "PC2.id = (SELECT id FROM $this->_tablePrice PC4 WHERE "
                . "PC4.product_id = P.id ORDER BY PC4.id DESC LIMIT 1)", "LEFT");
        $this->db->where("P.publish_status", "approved");
        $query = $this->db->get();
        return $query->num_rows();
    }

    function allproducts_admin($limit, $start, $col, $dir) {

        $this->db->select('P.id as product_id,P.name,C.categories_name,PM.type as media_type,PM.url as media_url,PC1.price as price1,PC2.price as price2,PC1.quantity_from,PC1.final_price as final_price1,PC2.final_price as final_price2, SCD.company_name,U.first_name,U.last_name,U.email,U.phone');
        $this->db->from($this->_table . " P");
        $this->db->join($this->_tableCategory . " C", "P.category = C.categories_id", "LEFT");
        $this->db->join($this->_tableMedia . " PM", "PM.id = (SELECT id FROM $this->_tableMedia PM1 WHERE "
                . "PM1.product_id = P.id and type='photo' ORDER BY PM1.id ASC LIMIT 1)", "LEFT");
        $this->db->join($this->_tablePrice . " PC1", "PC1.id = (SELECT id FROM $this->_tablePrice PC3 WHERE "
                . "PC3.product_id = P.id ORDER BY PC3.id ASC LIMIT 1)", "LEFT");
        $this->db->join($this->_tablePrice . " PC2", "PC2.id = (SELECT id FROM $this->_tablePrice PC4 WHERE "
                . "PC4.product_id = P.id ORDER BY PC4.id DESC LIMIT 1)", "LEFT");
        $this->db->join($this->_tableUser . " U", "U.id = P.seller");
        $this->db->join($this->_tableCompany . " SCD", "SCD.user_id = P.seller");
        $this->db->where("P.publish_status", "approved");
        $this->db->limit($limit, $start);
        $this->db->order_by("P." . $col, $dir);
        $query = $this->db->get();

        //echo $this->db->last_query();exit;



        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return null;
        }
    }

    function product_search_admin($limit, $start, $search, $col, $dir) {

        $this->db->select('P.id as product_id,P.name,C.categories_name,PM.type as media_type,PM.url as media_url,PC1.price as price1,PC2.price as price2,PC1.final_price as final_price1,PC2.final_price as final_price2, SCD.company_name,U.first_name,U.last_name,U.email,U.phone');
        $this->db->from($this->_table . " P");
        $this->db->join($this->_tableCategory . " C", "P.category = C.categories_id", "LEFT");
        $this->db->join($this->_tableMedia . " PM", "PM.id = (SELECT id FROM $this->_tableMedia PM1 WHERE "
                . "PM1.product_id = P.id and type='photo' ORDER BY PM1.id ASC LIMIT 1)", "LEFT");
        $this->db->join($this->_tablePrice . " PC1", "PC1.id = (SELECT id FROM $this->_tablePrice PC3 WHERE "
                . "PC3.product_id = P.id ORDER BY PC3.id ASC LIMIT 1)", "LEFT");
        $this->db->join($this->_tablePrice . " PC2", "PC2.id = (SELECT id FROM $this->_tablePrice PC4 WHERE "
                . "PC4.product_id = P.id ORDER BY PC4.id DESC LIMIT 1)", "LEFT");
        $this->db->join($this->_tableUser . " U", "U.id = P.seller");
        $this->db->join($this->_tableCompany . " SCD", "SCD.user_id = P.seller");
        $this->db->where("P.publish_status", "approved");
        $this->db->limit($limit, $start);
        $this->db->order_by("P." . $col, $dir);
        $query = $this->db->get();


        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return null;
        }
    }

    function product_search_count_admin($search) {
        $this->db->select('P.id as product_id,P.name,C.categories_name,PM.type as media_type,PM.url as media_url,PC1.price as price1,PC2.price as price2,PC1.final_price as final_price1,PC2.final_price as final_price2');
        $this->db->like('P.id', $search);
        $this->db->or_like('P.name', $search);
        $this->db->from($this->_table . " P");
        $this->db->join($this->_tableCategory . " C", "P.category = C.categories_id");
        $this->db->join($this->_tableMedia . " PM", "PM.id = (SELECT id FROM $this->_tableMedia PM1 WHERE "
                . "PM1.product_id = p.id ORDER BY PM1.id ASC LIMIT 1)");
        $this->db->join($this->_tablePrice . " PC1", "PC1.id = (SELECT id FROM $this->_tablePrice PC3 WHERE "
                . "PC3.product_id = p.id ORDER BY PC3.id ASC LIMIT 1)");
        $this->db->join($this->_tablePrice . " PC2", "PC2.id = (SELECT id FROM $this->_tablePrice PC4 WHERE "
                . "PC4.product_id = p.id ORDER BY PC4.id DESC LIMIT 1)");
        $this->db->where("P.publish_status", "approved");
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return null;
        }
    }

    ///////////////////////////////////////////////////


//    public function truncate_products() {
//        $this->db->from($this->_table);
//        $this->db->truncate();
//        $this->db->from($this->_tablePrice);
//        $this->db->truncate();
//        $this->db->from($this->_tableAttr);
//        $this->db->truncate();
//        $this->db->from($this->_tableMedia);
//        $this->db->truncate();
//        $this->db->from($this->_tableSpecs);
//        $this->db->truncate();
//    }

    //////////  API BELOW /////////



    public function getProductsByCategoryDataNumRows($category_id) { //api // api
        $this->db->select('P.id as product_id,P.seller as seller_id,company_types.name as seller_type,TIMESTAMPDIFF(YEAR, `seller_info.date_created`, CURDATE()) AS supplier_company_age,P.name as product_name,C.categories_name,PM.type as media_type, PM.url as media_url,PC1.price as price2,PC2.price as price1,PC1.final_price as final_price2,PC2.final_price as final_price1,PC1.quantity_from as moq1, PC2.quantity_from as moq2,P.discount_percentage as discount,PC1.atz_price as mrp');
        $this->db->from("product_details P");
        $this->db->join("categories_description C", "P.category = C.categories_id");
        $this->db->join("product_media PM", "PM.id = (SELECT id FROM product_media PM1 WHERE "
                . "PM1.product_id = P.id ORDER BY PM1.id ASC LIMIT 1)");
        $this->db->join("product_price PC1", "PC1.id = (SELECT id FROM product_price PC3 WHERE "
                . "PC3.product_id = P.id ORDER BY PC3.id ASC LIMIT 1)");
        $this->db->join("product_price PC2", "PC2.id = (SELECT id FROM product_price PC4 WHERE "
                . "PC4.product_id = P.id ORDER BY PC4.id DESC LIMIT 1)");
        $this->db->join("users as users", "users.id=P.seller", "INNER");
        $this->db->join("seller_info as seller_info", "seller_info.user_id=P.seller", "LEFT");
        $this->db->join("company_types as company_types", "company_types.id=seller_info.company_type", "LEFT");
        $this->db->where_in('P.category', $category_id);
        $this->db->where('P.publish_status', "approved");
        $query = $this->db->get();
        $result = $query->num_rows();

        return $result;
    }

    public function getProductsByCategoryData($category_id, $start_from = 0, $limit = 15) { //api // api
        $this->db->limit($limit, $start_from);
        $selectOffer = 'oz.offer_id,offer_type,discount_value as offer_discount_value,oz.status as offer_status, '
                . 'timestamp(valid_from, time_from) offer_start_time, '
                . 'timestamp(valid_to, time_to) offer_end_time ,oz.title,';
        
        $this->db->select($selectOffer.' P.id as product_id,P.seller as seller_id,users.user_package,company_types.name as seller_type,TIMESTAMPDIFF(YEAR, `seller_info.date_created`, CURDATE()) AS supplier_company_age,P.name as product_name,C.categories_name,PM.type as media_type, PM.url as media_url,PC1.price as price2,PC2.price as price1,PC1.final_price as final_price2,PC2.final_price as final_price1,PC1.quantity_from as moq1, PC2.quantity_from as moq2,units.units_id as units_id,units.units_name as units_name,P.name,P.discount_percentage as discount,PC1.atz_price as mrp');
        $this->db->from("product_details P");
        $this->db->join("categories_description C", "P.category = C.categories_id");
        $this->db->join("offer_categories oc","oc.category_id = P.category", 'left');
        $this->db->join("offer_zone oz", " oz.offer_id = oc.offer_id AND oz.status = 'active'", 'left');
        $this->db->join("product_media PM", "PM.id = (SELECT id FROM product_media PM1 WHERE "
                . "PM1.product_id = P.id ORDER BY PM1.id ASC LIMIT 1)");
        $this->db->join("product_price PC1", "PC1.id = (SELECT id FROM product_price PC3 WHERE "
                . "PC3.product_id = P.id ORDER BY PC3.id ASC LIMIT 1)");
        $this->db->join("product_price PC2", "PC2.id = (SELECT id FROM product_price PC4 WHERE "
                . "PC4.product_id = P.id ORDER BY PC4.id DESC LIMIT 1)");
        $this->db->join("users as users", "users.id=P.seller", "INNER");
        $this->db->join("seller_info as seller_info", "seller_info.user_id=P.seller", "LEFT");
        $this->db->join("company_types as company_types", "company_types.id=seller_info.company_type", "LEFT");
        $this->db->join("units as units", "PC1.unit=units.units_id", "left");
        $this->db->join("seller_company_details as scd", "scd.user_id=P.seller", "left");
        $this->db->where_in('P.category', $category_id);
        $this->db->where('P.publish_status', 'approved');
        $query = $this->db->get();
        $result = $query->result_array();

        //  echo $this->db->last_query();exit;

        for ($i = 0; $i < count($result); $i++) {

            if ($result[$i]['moq1'] < $result[$i]['moq2']) {
                $result[$i]['moq'] = $result[$i]['moq1'];
            } else {
                $result[$i]['moq'] = $result[$i]['moq2'];
            }

            if ($result[$i]['moq1'] != "" || $result[$i]['moq2'] != "") {
                unset($result[$i]['moq1']);
                unset($result[$i]['moq2']);
            }

            //get Membership ICON
            $membership_data = $this->get_membership_data($result[$i]['product_id'], $result[$i]['seller_id']);
            $result[$i]['membership_icon'] = $membership_data;
        }
        return $result;
    }

    public function getProductsByCategoryData_app($category_id, $start_from = 0, $limit = 15) { //api // api
        //get mAIN MAIN category
        $this->db->select('category_id');
        $this->db->from('categories');
        $this->db->where('parent_id', $category_id);
        $cat_id_q = $this->db->get()->result();
        // echo $this->db->last_query();
        $cat_id = $cat_id_q->category_id;

        $res = $this->Categories_model->getAllChilds($category_id);
        $catIds = explode(",", $category_id.",".$res);
        $selectOffer = 'oz.offer_id,offer_type,discount_value as offer_discount_value,oz.status as offer_status, '
                . 'timestamp(valid_from, time_from) offer_start_time, '
                . 'timestamp(valid_to, time_to) offer_end_time ,oz.title,';

        $this->db->limit($limit, $start_from);
        $this->db->select($selectOffer.', P.id as product_id,P.seller as seller_id,users.user_package,company_types.name as seller_type,TIMESTAMPDIFF(YEAR, `seller_info.date_created`, CURDATE()) AS supplier_company_age,P.name as product_name,C.categories_name,PM.type as media_type, PM.url as media_url,PC1.price as price2,PC2.price as price1,PC1.final_price as final_price2,PC2.final_price as final_price1,PC1.quantity_from as moq1, PC2.quantity_from as moq2,units.units_id as units_id,units.units_name as units_name,P.name,P.discount_percentage as discount,PC1.atz_price as mrp');
        $this->db->from("product_details P");
        $this->db->join("offer_categories oc", "oc.category_id = P.category ", 'left');
        $this->db->join("offer_zone oz", " oz.offer_id = oc.offer_id AND oz.status = 'active' ", 'left');
        $this->db->join("categories_description C", "P.category = C.categories_id");
        $this->db->join("product_media PM", "PM.id = (SELECT id FROM product_media PM1 WHERE "
                . "PM1.product_id = P.id ORDER BY PM1.id ASC LIMIT 1)");
        $this->db->join("product_price PC1", "PC1.id = (SELECT id FROM product_price PC3 WHERE "
                . "PC3.product_id = P.id ORDER BY PC3.id ASC LIMIT 1)");
        $this->db->join("product_price PC2", "PC2.id = (SELECT id FROM product_price PC4 WHERE "
                . "PC4.product_id = P.id ORDER BY PC4.id DESC LIMIT 1)");
        $this->db->join("users as users", "users.id=P.seller", "INNER");
        $this->db->join("seller_info as seller_info", "seller_info.user_id=P.seller", "LEFT");
        $this->db->join("company_types as company_types", "company_types.id=seller_info.company_type", "LEFT");
        $this->db->join("units as units", "PC1.unit=units.units_id", "left");
        $this->db->join("seller_company_details as scd", "scd.user_id=P.seller", "left");
        $this->db->where_in('P.category', $catIds);
        $this->db->where('P.publish_status', 'approved');
        $query = $this->db->get();
        $result = $query->result_array();

        //  echo $this->db->last_query();exit;

        for ($i = 0; $i < count($result); $i++) {

            if ($result[$i]['moq1'] < $result[$i]['moq2']) {
                $result[$i]['moq'] = $result[$i]['moq1'];
            } else {
                $result[$i]['moq'] = $result[$i]['moq2'];
            }

            if ($result[$i]['moq1'] != "" || $result[$i]['moq2'] != "") {
                unset($result[$i]['moq1']);
                unset($result[$i]['moq2']);
            }

            //get Membership ICON
            $membership_data = $this->get_membership_data($result[$i]['product_id'], $result[$i]['seller_id']);
            $result[$i]['membership_icon'] = $membership_data;
        }
        return $result;
    }

    public function search_ProductsByCategoryData($category_id, $start_from = 0, $limit = 30, $min_order = 0, $min_price = 0, $max_price = 0, $location = 0, $instock = 0, $trade_assurance = 0, $supp_verified = 0, $spec_values = 0) { //api // api
        $this->db->limit($limit, $start_from);
        $this->db->select($this->selectOffer.'P.id as product_id,P.seller as seller_id,users.user_package,company_types.name as seller_type,TIMESTAMPDIFF(YEAR, `seller_info.date_created`, CURDATE()) AS supplier_company_age,P.name as product_name,C.categories_name,PM.type as media_type, PM.url as media_url,PC1.price as price2,PC2.price as price1,PC1.final_price as final_price2,PC2.final_price as final_price1,PC1.quantity_from as moq1, PC2.quantity_from as moq2,units.units_id as units_id,units.units_name as units_name,P.discount_percentage as discount,PC1.atz_price as mrp');
        $this->db->from("product_details P");
        $this->db->join("categories_description C", "P.category = C.categories_id");
        $this->offerJoins();//call to offer joins
        $this->db->join("product_media PM", "PM.id = (SELECT id FROM product_media PM1 WHERE "
                . "PM1.product_id = P.id ORDER BY PM1.id ASC LIMIT 1)");
        $this->db->join("product_price PC1", "PC1.id = (SELECT id FROM product_price PC3 WHERE "
                . "PC3.product_id = P.id ORDER BY PC3.id ASC LIMIT 1)");
        $this->db->join("product_price PC2", "PC2.id = (SELECT id FROM product_price PC4 WHERE "
                . "PC4.product_id = P.id ORDER BY PC4.id DESC LIMIT 1)");
        $this->db->join("users as users", "users.id=P.seller", "INNER");
        $this->db->join("seller_info as seller_info", "seller_info.user_id=P.seller", "LEFT");
        $this->db->join("company_types as company_types", "company_types.id=seller_info.company_type", "LEFT");
        $this->db->join("units as units", "PC1.unit=units.units_id", "left");
        $this->db->join("seller_company_details as scd", "scd.user_id=P.seller", "left");
        $this->db->where_in('P.category', $category_id);
        $this->db->where('P.publish_status', 'approved');

        if ($spec_values) {
            $this->db->join("product_specifications PS", "P.id = PS.product_id");
            $i = 0;
            foreach ($spec_values as $key => $spec) {
                $this->db->group_start();
                if ($i == 0) {
                    $this->db->like("spec_value", $spec[$key]);
                } else {
                    $this->db->or_like("spec_value", $spec[$key]);
                }

                $this->db->group_end();

                $i++;
            }
        }
        //Match start
        if (!empty($min_order)) {
            $this->db->where('PC2.quantity_from >=', $min_order);
        }

        if (!empty($min_price)) {
            $this->db->where('PC2.price >=', $min_price);
        }

        if (!empty($max_price)) {
            $this->db->where('PC2.price <=', $max_price);
        }

        if ($instock == 1) {
            //$this->db->where('P.available_quantity >',0);
        }
        $query = $this->db->get();
        $result = $query->result_array();

        //echo $this->db->last_query();exit;

        for ($i = 0; $i < count($result); $i++) {

            if ($result[$i]['moq1'] < $result[$i]['moq2']) {
                $result[$i]['moq'] = $result[$i]['moq1'];
            } else {
                $result[$i]['moq'] = $result[$i]['moq2'];
            }

            if ($result[$i]['moq1'] != "" || $result[$i]['moq2'] != "") {
                unset($result[$i]['moq1']);
                unset($result[$i]['moq2']);
            }

            //get Membership ICON
            $membership_data = $this->get_membership_data($result[$i]['product_id'], $result[$i]['seller_id']);

            $result[$i]['membership_icon'] = $membership_data;
        }

        return $result;
    }

    function get_membership_data($pro_id = 0, $seller_id = 0) {
        //Package
        $this->db->select('*');
        $this->db->from('user_packages a');
        $this->db->join('subscription_package b', 'b.sub_id=a.pkg_id', 'left');
        $this->db->where('a.user_id', $seller_id);
        $this->db->where('a.status', 'Active');
        $q = $this->db->get();
        $ch = $q->num_rows();
        if ($ch > 0) {
            $mdata = $q->result();
            $pkg_name = $mdata->pkg_name;
            $pkg_desc = $mdata->pkg_description;
            $pkg_img = $mdata->pkg_image;
        } else {
            $pkg_name = '';
            $pkg_desc = '';
            $pkg_img = '';
        }
        //get Onsite Check
        $this->db->select('*');
        $this->db->from('users');
        $this->db->where('id', $seller_id);
        $q = $this->db->get();
        $ch = $q->result;
        if ($ch->onsite_check == 1) {
            $onsite_check = 1;
            $onsite_info = 'he seller`s are authenticated by physical verification performed by our third-party verification company.';
        } else {
            $onsite_check = 1;
            $onsite_info = '';
        }

        $seller_approved = base_url() . 'uploads/images/seller_package_images/verified.png';

        //trade Assurance
        $trade_assurance = '<p>You will enjoy this service by paying online payments.&nbsp;</p>

		<p>1. Payment safety.</p>

		<p>2. Assured Shipping services.&nbsp;</p>
			';


        //Paid Members duration
        $this->db->select('*');
        $this->db->from('user_packages');
        $this->db->where('user_id', $seller_id);
        $query = $this->db->get()->result();
        $member_duration = 0;
        foreach ($query as $mem) {
            $member_duration = $member_duration + $mem->duration;
        }
        if ($member_duration > 0) {
            $paid_supplier = $member_duration . ' Month Paid supplier';
            ;
        } else {
            $paid_supplier = 0;
        }



        $data['pkg_name'] = $pkg_name;
        $data['pkg_desc'] = $pkg_desc;
        $data['pkg_img'] = $pkg_img;
        $data['pkg_name'] = $pkg_name;

        $data['onsite_check'] = $onsite_check;
        $data['onsite_info'] = $onsite_info;

        $data['seller_approved'] = $seller_approved;

        $data['trade_assurance'] = $trade_assurance;

        $data['paid_supplier'] = $paid_supplier;
        $data['paid_supplier_info'] = 'The years display since a seller became a paid member.The number of years will be updated automatically.';

        return $data;
    }

    function getProductDetails($products_id) { //api
        //p.is_product_returnable,p.product_return_days,
        $this->db->select($this->selectOffer.' valid_from, time_from, valid_to, time_to ,track_inventory,low_stock_qty,notifyme,p.is_product_returnable,p.product_return_days,p.discount_percentage,p.publish_status, p.available_quantity, p.id, p.name,p.keywords,p.category as category_id,ctd.categories_name, p.description,p.weight,p.width,p.height,p.length,p.hike_percentage,p.provide_order_at_buyer_place,p.price_type,seller,sc.company_name,address1,main_products,other_products,year_of_register,no_of_employee,office_size,company_url,registration_state,location_country as country_name,currency as currency_name,comp_operational_addr,comp_operational_city,comp_operational_state,comp_operational_region,comp_operational_zip_code,ct.name business_type,users.user_package');
        $this->db->from('product_details p');
        $this->db->join("categories cat", "cat.category_id = p.category", 'left');
        $this->db->join('product_price pp', 'p.id = pp.product_id');
        $this->db->join("offer_categories oc","oc.category_id = p.category", 'left');
        $this->db->join("offer_zone oz", " oz.offer_id = oc.offer_id AND oz.status = 'active'", 'left');
        $this->db->join('seller_info s', 'p.seller = s.user_id');
        $this->db->join('seller_company_details sc', 'sc.user_id = s.user_id');
        $this->db->join('company_types ct', 'ct.id = s.company_type');
        $this->db->join('categories_description ctd', 'ctd.categories_id = p.category', 'LEFT');
        $this->db->join('users users', 'users.id = p.seller', 'LEFT');
        $this->db->where('p.id', $products_id);
        $result = $this->db->get()->row_array();
        if ($result) {

            $this->db->select('url');
            $this->db->where('product_id', $result['id']);
            $this->db->where('type', 'photo');
            $urls = $this->db->get('product_media')->result_array();
            foreach ($urls as $row) {
                $result['images'][] = $row['url'];
            }

            $this->db->select('url');
            $this->db->where('product_id', $result['id']);
            $this->db->where('type', 'video');
            $row = $this->db->get('product_media')->row();
            $result['video'] = $row->url;


            $result["minisite_url"] = site_url() . "company-details/" . $result["company_name"];
            //$result["minisite_url"] = "https://m.atzcart.com/supplier/index/".$result["seller"];
            ///// start of specifications ////////

            $this->db->select('spec_id, spec_value,css.name specification_name, type')->from('product_specifications ps');
            $this->db->join('category_specific_specifications css', 'css.id = ps.spec_id');

            $this->db->where('ps.product_id', $result['id']);
            $specification = $this->db->get()->result_array();

            $spec_arr = array();

            foreach ($specification as $key => $item) {

                $spec_arr[$item['specification_name']][] = $item;
            }

            $result['product_specification_count'] = count($spec_arr);
            $result['product_specification'][] = $spec_arr;


            ///// end of specifications ////////
            ///// start of attributes ////////

            $this->db->select('attribute_id, attribute_value,csa.name as attribute_name, type')->from('product_attributes pa');
            $this->db->join('category_specific_attributes csa', 'csa.id = pa.attribute_id', 'INNER');
            $attributes = $this->db->where('pa.product_id', $result['id'])->get()->result_array();

            $result['product_attributes_count'] = count($attributes);
            $result['product_attributes'] = $attributes;
            ///// end of attributes ////////
        }

        $result['country_flag'] = base_url() . "assets/images/flags/png/in.png";
        $result['response_rate'] = "<24h";
        $result['response_time'] = "75.9%";
        $result['transactions'] = "<i class='fa fa-inr'></i> 1000+";

        $this->db->select('a.quantity_from, a.quantity_upto, a.unit as units_id, b.units_name, a.price,a.atz_price, a.final_price');
        $this->db->from('product_price as a');
        $this->db->join('units as b', 'a.unit=b.units_id');
        $this->db->where('product_id', $products_id);
        $query = $this->db->get();
        $result2 = $query->result();

        $result['product_prices'] = $result2;
        $result['moq'] = $result2[0]->quantity_from;

        //print_r($result);exit;
        $result["coupons"] = [
            "is_coupon_available" => 0,
            "coupon_list" => []
        ];

        $coupons = $this->getProductCoupens($products_id);
        if ($coupons) {
            $result["coupons"]["is_coupon_available"] = 1;
            $result["coupons"]["coupon_list"] = $coupons;
        }
        $shopping_cart_count = $this->getUsersCartItemsCountData($result['seller']);
        $result['shopping_cart_count'] = $shopping_cart_count;

        $result['membership_icon'] = base_url() . "uploads/images/seller_package_images/" . $result['user_package'] . ".png";
        return $result;
    }

    public function getProductDescriptionData($products_id) { //api
        $this->db->select('description');
        $this->db->where('id', $products_id);
        $query = $this->db->get('product_details');
        $result = $query->row();
        return $result;
    }

    public function getUsersCartItemsCountData($user_id) {
        $this->db->select('id');
        $this->db->where('user_id', $user_id);
        $query = $this->db->get('add_to_cart');
        $result = $query->num_rows();
        return $result;
    }

    public function getProductsBySellerData($seller_id, $start_from = 0, $limit = 30) {
        $this->db->limit($limit, $start_from);
        $this->db->select($this->selectOffer.'P.id as product_id,P.seller as seller_id,users.first_name as seller_firstname,users.last_name as seller_lastname,users.phone as seller_phone_no,users.email as seller_email,scd.company_name as seller_company_name,company_types.name as seller_type,TIMESTAMPDIFF(YEAR, `seller_info.date_created`, CURDATE()) AS supplier_company_age,P.name as product_name,C.categories_name,PM.type as media_type, PM.url as media_url,PC1.price as price1,PC2.price as price2, PC1.final_price as final_price1,PC2.final_price as final_price2, PC1.quantity_from as moq1, PC2.quantity_from as moq2,units.units_id,units.units_name,PC1.atz_price as mrp,P.discount_percentage as discount');
        $this->db->from("product_details P");
        $this->offerJoins();
        $this->db->join("categories_description C", "P.category = C.categories_id");
        $this->db->join("product_media PM", "PM.id = (SELECT id FROM product_media PM1 WHERE "
                . "PM1.product_id = P.id ORDER BY PM1.id ASC LIMIT 1)");
        $this->db->join("product_price PC1", "PC1.id = (SELECT id FROM product_price PC3 WHERE "
                . "PC3.product_id = P.id ORDER BY PC3.id ASC LIMIT 1)");
        $this->db->join("product_price PC2", "PC2.id = (SELECT id FROM product_price PC4 WHERE "
                . "PC4.product_id = P.id ORDER BY PC4.id DESC LIMIT 1)");
        $this->db->join("users as users", "users.id=P.seller", "left");
        $this->db->join("seller_info as seller_info", "seller_info.user_id=P.seller", "left");
        $this->db->join("seller_company_details as scd", "P.seller=scd.user_id", "left");
        $this->db->join("company_types as company_types", "company_types.id=seller_info.company_type", "left");
        $this->db->join("units as units", "PC1.unit=units.units_id", "left");
        $this->db->where('P.seller', $seller_id);
        $query = $this->db->get();
        $result = $query->result_array();

        // echo $this->db->last_query();exit;

        for ($i = 0; $i < count($result); $i++) {

            if ($result[$i]['moq1'] < $result[$i]['moq2']) {
                $result[$i]['moq'] = $result[$i]['moq1'];
            } else {
                $result[$i]['moq'] = $result[$i]['moq2'];
            }

            if ($result[$i]['moq1'] != "" || $result[$i]['moq2'] != "") {
                unset($result[$i]['moq1']);
                unset($result[$i]['moq2']);
            }

            $this->db->select('a.quantity_from, a.quantity_upto, a.unit as units_id, b.units_name, a.price, a.final_price');
            $this->db->from('product_price as a');
            $this->db->join('units as b', 'a.unit=b.units_id');
            $this->db->where('product_id', $result[$i]['product_id']);
            $query = $this->db->get();
            $result2 = $query->result();

            $result[$i]['product_prices'] = $result2;
        }


        return $result;
    }

    //little changes minisites
    public function getProductsBySellerId($seller_id, $start_from = 0, $limit = 30) {
        $this->db->limit($limit, $start_from);
        $this->db->select('P.id as product_id,P.seller as seller_id,users.first_name as seller_firstname,users.last_name as seller_lastname,users.phone as seller_phone_no,users.email as seller_email,scd.company_name as seller_company_name,company_types.name as seller_type,TIMESTAMPDIFF(YEAR, `seller_info.date_created`, CURDATE()) AS supplier_company_age,P.name as product_name,C.categories_name,PM.type as media_type, PM.url as media_url,PC1.price as price1,PC2.price as price2,PC2.final_price,PC2.atz_price as mrp,PC1.quantity_from as moq1, PC2.quantity_from as moq2,units.units_id,units.units_name,P.discount_percentage as discount');
        $this->db->from("product_details P");
        $this->db->join("categories_description C", "P.category = C.categories_id");
        $this->db->join("product_media PM", "PM.id = (SELECT id FROM product_media PM1 WHERE "
                . "PM1.product_id = P.id ORDER BY PM1.id ASC LIMIT 1)");
        $this->db->join("product_price PC1", "PC1.id = (SELECT id FROM product_price PC3 WHERE "
                . "PC3.product_id = P.id ORDER BY PC3.id ASC LIMIT 1)");
        $this->db->join("product_price PC2", "PC2.id = (SELECT id FROM product_price PC4 WHERE "
                . "PC4.product_id = P.id ORDER BY PC4.id DESC LIMIT 1)");
        $this->db->join("users as users", "users.id=P.seller", "left");
        $this->db->join("seller_info as seller_info", "seller_info.user_id=P.seller", "left");
        $this->db->join("seller_company_details as scd", "P.seller=scd.user_id", "left");
        $this->db->join("company_types as company_types", "company_types.id=seller_info.company_type", "left");
        $this->db->join("units as units", "PC1.unit=units.units_id", "left");
        $this->db->where('P.seller', $seller_id);
        $this->db->order_by("P.id", "desc");
        $query = $this->db->get();
        $result = $query->result_array();
        //echo $this->db->last_query();exit;
        for ($i = 0; $i < count($result); $i++) {

            if ($result[$i]['moq1'] < $result[$i]['moq2']) {
                $result[$i]['moq'] = $result[$i]['moq1'];
            } else {
                $result[$i]['moq'] = $result[$i]['moq2'];
            }

            if ($result[$i]['moq1'] != "" || $result[$i]['moq2'] != "") {
                unset($result[$i]['moq1']);
                unset($result[$i]['moq2']);
            }
        }


        return $result;
    }

    public function getApproveRequests() {
        $this->db->select("P.id as product_id, P.name, C.categories_name,
                           PM.type as media_type, PM.url as media_url,
                           PC1.price as price1,PC2.price as price2, PC1.final_price as final_price1,
                           PC2.final_price as final_price2, U.first_name, U.last_name, U.id as seller, SCD.company_name,P.created_at")
                ->from($this->_table . " P")
                ->join($this->_tableCategory . " C", "P.category = C.categories_id")
                ->join($this->_tableMedia . " PM", "PM.id = (SELECT id FROM $this->_tableMedia PM1 WHERE "
                        . "PM1.product_id = P.id ORDER BY PM1.id ASC LIMIT 1)")
                ->join($this->_tablePrice . " PC1", "PC1.id = (SELECT id FROM $this->_tablePrice PC3 WHERE "
                        . "PC3.product_id = P.id ORDER BY PC3.id ASC LIMIT 1)")
                ->join($this->_tablePrice . " PC2", "PC2.id = (SELECT id FROM $this->_tablePrice PC4 WHERE "
                        . "PC4.product_id = P.id ORDER BY PC4.id DESC LIMIT 1)")
                ->join($this->_tableUser . " U", "U.id = P.seller")
                ->join($this->_tableCompany . " SCD", "SCD.user_id = P.seller")
                ->where(["publish_status" => "requested"])
                ->order_by('P.id', 'desc');
        $query = $this->db->get();
        return $query->result();
    }

    public function approveProduct($id) {
        $data["publish_status"] = "approved";
        $this->db->where(array("id" => $id));
        $this->db->update($this->_table, $data);
    }

    public function rejectProduct($id) {

        $data["publish_status"] = "Rejected";
        $this->db->where(array("id" => $id));
        $this->db->update($this->_table, $data);
    }

    public function getPopularProducts($limit = 10) {
        $this->db->order_by("views", "DESC");
        $query = $this->db->get($this->_tableReviews);
        return $query->result();
    }

    public function getPopularCategories($limit = 10) {
        $this->db->select("SUM(PR.views) as viewCount,CD.categories_name,CD.categories_id")
                ->from($this->_tableReviews . " PR")
                ->join($this->_table . " PD", "PR.product_id = PD.id")
                ->join($this->_tableCategory . " CD", "CD.categories_id = PD.category")
                ->group_by("CD.categories_id")
                ->order_by("viewCount", "DESC")
                ->limit($limit);
        $query = $this->db->get();
        return $query->result();
    }

    /*     * ************************ shubham patil ********************************* */

    function get_products($cat_id) {
        $this->db->select('name, p.id');
        $this->db->from('product_details p');
        $this->db->where("p.category", $cat_id);
        $this->db->where("p.publish_status", 'approved');
        return $this->db->get()->result_array();
    }

    public function getProductsdetailsByCategory($category_id, $start_from = 0, $limit = 30, $min_order=0, $min_price=0, $max_price=0, $sortby) {

        
        //changed after applying offer to product category
        //Yogesh Pardeshi 16-08-2019 6:33 pm
        $this->db->select(
            "oz.offer_id,offer_type,discount_value as offer_discount_value,oz.status as offer_status, valid_from, time_from, valid_to, time_to ,oz.title,P.category, parent_id,"
            ."P.id as product_id,P.seller as seller_id,users.user_package,company_types.name as seller_type,"
            . "TIMESTAMPDIFF(YEAR, `seller_info.date_created`, CURDATE()) AS supplier_company_age,P.name as product_name,P.name,"
            . "C.categories_name,PM.type as media_type, PM.url as media_url,PC1.price as price2,PC2.price as price1,"
            . "PC1.final_price as final_price2,PC2.final_price as final_price1,"
            . "PC1.quantity_upto as moq1, PC2.quantity_from as moq2,units.units_id as units_id,units.units_name as units_name,"
            . "P.discount_percentage as discount,PC2.atz_price as mrp");
        $this->db->from("product_details P");
        $this->db->join("categories_description C", "P.category = C.categories_id", 'left');
        $this->db->join("categories cat", "cat.category_id = P.category", 'left');
        $this->db->join("offer_categories oc","oc.category_id = P.category", 'left');
        $this->db->join("offer_zone oz", " oz.offer_id = oc.offer_id AND oz.status = 'active'", 'left');
        $this->db->join("product_media PM", "PM.id = (SELECT id FROM product_media PM1 WHERE "
                . "PM1.product_id = P.id ORDER BY PM1.id ASC LIMIT 1)");
        $this->db->join("product_price PC1", "PC1.id = (SELECT id FROM product_price PC3 WHERE "
                . "PC3.product_id = P.id ORDER BY PC3.id ASC LIMIT 1)");
        $this->db->join("product_price PC2", "PC2.id = (SELECT id FROM product_price PC4 WHERE "
                . "PC4.product_id = P.id ORDER BY PC4.id DESC LIMIT 1)");
        $this->db->join("users as users", "users.id=P.seller", "INNER");
        $this->db->join("seller_info as seller_info", "seller_info.user_id=P.seller", "LEFT");
        $this->db->join("company_types as company_types", "company_types.id=seller_info.company_type", "LEFT");
        $this->db->join("units as units", "PC1.unit=units.units_id", "left");
        $this->db->join("seller_company_details as scd", "scd.user_id=P.seller", "left");
        $this->db->where_in('P.category', $category_id);
        $this->db->where("P.publish_status", "approved");
        
        if (!empty($min_order)) {
            $this->db->where('PC2.quantity_from >=', $min_order);
        }

        if (!empty($min_price)) {
            $this->db->where('PC2.final_price >=', $min_price);
        }

        if (!empty($max_price)) {
            $this->db->where('PC2.final_price <=', $max_price);
        }
        
    
        if($sortby){
            $this->db->order_by('PC2.final_price', "DESC");
        }else{
            $this->db->order_by('PC2.final_price', "ASC");
        }
        
        $this->db->limit(12, $start_from);
        
        $query = $this->db->get();
//       echo $this->db->last_query();
        return $query->result_array();
    }

    public function getAllProductCount($catIDs) {
        $this->db->from("product_details P");
        $this->db->join("categories_description C", "P.category = C.categories_id");
        $this->db->join("product_media PM", "PM.id = (SELECT id FROM product_media PM1 WHERE "
                . "PM1.product_id = P.id ORDER BY PM1.id ASC LIMIT 1)");
        $this->db->join("product_price PC1", "PC1.id = (SELECT id FROM product_price PC3 WHERE "
                . "PC3.product_id = P.id ORDER BY PC3.id ASC LIMIT 1)");
        $this->db->join("product_price PC2", "PC2.id = (SELECT id FROM product_price PC4 WHERE "
                . "PC4.product_id = P.id ORDER BY PC4.id DESC LIMIT 1)");
        $this->db->join("users as users", "users.id=P.seller", "INNER");

        $this->db->where_in('P.category', $catIDs);
        $this->db->where("P.publish_status", "approved");
        $query = $this->db->get();
        return $query->num_rows();
    }

    function getfavProductDetails($prod_id) {
        $this->db->select('MAX(final_price) as max_final_price, units_name, quantity_upto, quantity_from, atz_price as mrp, discount_percentage as discount,low_stock_qty,available_quantity, tb1.id,tb1.name,s.company_name,s.location_country,s.comp_operational_city,s.year_of_register,PM.url as media_url');
        $this->db->from("product_details tb1");
        $this->db->join("product_media PM", "PM.id = (SELECT id FROM product_media PM1 WHERE "
                . "PM1.product_id = tb1.id ORDER BY PM1.id ASC LIMIT 1)");
        $this->db->join('product_price pp', "tb1.id = pp.product_id");
        $this->db->join('seller_company_details s', 's.user_id = tb1.seller');
        $this->db->join('units u', 'pp.unit = u.units_id');
        $this->db->where("tb1.id", $prod_id);
        return $this->db->get()->row_array();
    }


    function get_products_price($prod_id)
    {

       $this->db->select('MAX(final_price) as max_final_price,MIN(final_price) as min_final_price, units_name, quantity_upto, quantity_from, atz_price as mrp, discount_percentage as discount,low_stock_qty,available_quantity');
       $this->db->from('product_price pp');
       $this->db->join('product_details p','p.id = pp.product_id');
       $this->db->join('units u','pp.unit = u.units_id');
       $this->db->where("product_id",$prod_id);
       $this->db->limit(1);
       return $this->db->get()->row_array();
   }

    
    function getproduct_image($product_id) {
        $this->db->select('url');
        $this->db->where('product_id',(int)$product_id);
        $this->db->order_by("product_id", "DESC");
        $this->db->limit(1);
        return $this->db->get('product_media')->row();
       
    }

    function get_recommended_list() {
        $this->db->select("oz.offer_id,offer_type,discount_value as offer_discount_value,oz.status as offer_status, valid_from, time_from, valid_to, time_to ,oz.title,PD.id,PD.name,PM.url,PC2.quantity_from,PC2.price as max_price,PP2.price as min_price,PC2.final_price as max_final_price,"
                . "PP2.final_price as min_final_price,u.units_name,"
                . "PD.discount_percentage as discount,PC2.atz_price as mrp");
        $this->db->from("product_details PD");
        $this->db->join("product_media PM", "PM.id = (SELECT id FROM product_media PM1 WHERE "
                . "PM1.product_id = PD.id ORDER BY PM1.id ASC LIMIT 1)");
        $this->db->join("product_price PC2", "PC2.id = (SELECT id FROM product_price PC4 WHERE "
                . "PC4.product_id = PD.id ORDER BY PC4.id ASC LIMIT 1)");
        $this->db->join("product_price PP2", "PP2.id = (SELECT id FROM product_price PP4 WHERE "
                . "PP4.product_id = PD.id ORDER BY PP4.id DESC LIMIT 1)");
        $this->db->join("categories cat", "cat.category_id = PD.category", 'left');
        $this->db->join("offer_categories oc", "oc.category_id = PD.category", 'left');
        $this->db->join("offer_zone oz", " oz.offer_id = oc.offer_id AND oz.status = 'active'", 'left');
        
        $this->db->join('units u', 'PC2.unit = u.units_id');
        $this->db->where('PD.publish_status', "approved");
        $this->db->order_by("PD.id", "DESC");
        $this->db->limit(10);
        $query = $this->db->get();
        return $result = $query->result_array();
    }

    function get_recommended_products($cat_id, $limit = 4) {
        $this->db->select('p.id, name, price, final_price, quantity_upto, units_name');
        $this->db->from('product_details p');
        $this->db->join('product_price pp', 'p.id = pp.product_id');
        $this->db->join('units u', 'pp.unit = u.units_id');
        $this->db->where("p.category", $cat_id);
        $this->db->where("p.publish_status", 'approved');
        $this->db->limit($limit);
        return $this->db->get()->result_array();
    }

    function get_recommended_products_by_category($cat_id, $pid) {
        $this->db->select('oz.offer_id,offer_type,discount_value as offer_discount_value,oz.status as offer_status, valid_from, time_from, valid_to, time_to ,oz.title,p.id, p.discount_percentage as discount, name, price, final_price, quantity_upto, units_name,atz_price as mrp');
        $this->db->from('product_details p');
        $this->db->join('product_price pp', 'p.id = pp.product_id');
        $this->db->join("categories cat", "cat.category_id = p.category", 'left');
        $this->db->join("offer_categories oc", "oc.category_id = p.category", 'left');
        $this->db->join("offer_zone oz", "oz ON oz.offer_id = oc.offer_id AND oz.status = 'active'", 'left');
        $this->db->join('units u', 'pp.unit = u.units_id');
        $this->db->group_by(array("p.id"));
        $this->db->where(array("p.category" => $cat_id, "publish_status" => "approved"));
        $this->db->where_not_in('p.id', $pid);
        $this->db->limit(10);
        return $this->db->get()->result_array();
    }


    function getProductfullDetails($products_id)
    {
        $this->db->select(
            'oz.offer_id,offer_type,discount_value as offer_discount_value,oz.status, valid_from, time_from, valid_to, time_to ,oz.title,p.category, parent_id,'.
            'low_stock_qty, p.id, p.name, p.description,seller,s.company_name,address1,c.currency,main_products,other_products,year_of_register,no_of_employee,office_size,company_url,registration_state,comp_operational_addr,comp_operational_city,comp_operational_state,comp_operational_region,comp_operational_zip_code,ct.name business_type,first_name,last_name, iso3 country_name,iso,category, provide_order_at_buyer_place, u.email, u.phone, c.name as cntry,p.available_quantity, p.discount_percentage as discount');
        $this->db->from('product_details p');
        $this->db->join("categories cat", "cat.category_id = p.category", 'left');
        $this->db->join("offer_categories oc", "oc.category_id = p.category", 'left');
        $this->db->join("offer_zone oz", " oz.offer_id = oc.offer_id AND oz.status = 'active'", 'left');
        $this->db->join('seller_info s','p.seller = s.user_id');
        $this->db->join('users u','p.seller = u.id');
        $this->db->join('country c','u.country = c.id');
        $this->db->join('seller_company_details sc','sc.user_id = s.user_id');
        $this->db->join('company_types ct','ct.id = s.company_type');
        $this->db->where('p.id',$products_id);
        $this->db->where(["p.publish_status" => "approved"]);
        $result = $this->db->get()->result();

//        if ($result) {
//
//            $this->db->select('price,final_price,units_name,quantity_from,quantity_upto,atz_price as mrp')->from('product_price pp');
//            $this->db->join('units u', 'pp.unit = u.units_id');
//            $product_prices = $this->db->where('pp.product_id', $result['id'])->get()->result_array();
//            $result['product_prices'] = $product_prices;
//            $urls = $this->db->select('url')->where('product_id', $result['id'])->get('product_media')->result_array();
//            foreach ($urls as $row) {
//                $result['images'][] = $row['url'];
//            }
//            $this->db->select('spec_id, spec_value,cst.name specification_name, choices, type')->from('product_specifications ps');
//            $this->db->join('category_specific_specifications cst', 'cst.id = ps.spec_id');
//            $specification = $this->db->where('ps.product_id', $result['id'])->get()->result_array();
//
//            foreach ($specification as $spec) {
//                $result['product_specification'][$spec['specification_name']][] = array(
//                    'spec_id' => $spec['spec_id'],
//                    'spec_value' => $spec['spec_value'],
//                );
//            }
//
//            $this->db->select('attribute_value,csa.name')->from('product_attributes pa');
//            $this->db->join('category_specific_attributes csa', 'csa.id = pa.attribute_id');
//            $attributes = $this->db->where('pa.product_id', $result['id'])->get()->result_array();
//            foreach ($attributes as $atr) {
//                $result['product_attributes'][] = array(
//                    'attribute_name' => $atr['name'],
//                    'attribute_value' => $atr['attribute_value'],
//                );
//            }
//        }

        return $result;
    }

    function get_searched_product($keyword) {
        $this->db->select('name,id');
        $this->db->from('product_details');
        $this->db->where("name", $keyword);
        return $this->db->get()->row();
    }

    function getProductPrices($product_id) {
        $this->db->select('*');
        $this->db->where('product_id', $product_id);
        $this->db->from('product_price');
        return $this->db->get()->result();
    }

    function get_product_hints($keyword) {
        $this->db->select('id,name,category');
        $this->db->where(["publish_status" => "approved"]);
        $this->db->like('name', $keyword);
        return $this->db->get('product_details')->result_array();
    }

    function related_product($cat_id) {
        $this->db->select('name, p.id');
        $this->db->from('product_details p');
        $this->db->where("p.category", $cat_id);
        $this->db->where("p.publish_status", 'approved');
        $this->db->limit(8);
        return $this->db->get()->result_array();
    }

    function add_to_cart($arr) {
        $this->db->where('user_id', $arr['user_id']);
        $this->db->where('product_id', $arr['product_id']);
        $this->db->from('add_to_cart');
        $query = $this->db->get()->result_array();
        if (count($query) > 0) {
            $this->db->where('user_id', $arr['user_id']);
            $this->db->where('product_id', $arr['product_id']);
            return $this->db->update('add_to_cart', $arr);
        } else {
            return $this->db->insert('add_to_cart', $arr);
        }
    }

    function add_to_cart1($arr) {
        $this->db->where('user_id', $arr['user_id']);
        $this->db->where('product_id', $arr['product_id']);
        $this->db->from('add_to_cart');
        $query = $this->db->get()->result_array();
        if (count($query) > 0) {
            $this->db->where('user_id', $arr['user_id']);
            $this->db->where('product_id', $arr['product_id']);
            $this->db->update('add_to_cart', $arr);
            return "Exists";
        } else {
            $this->db->insert('add_to_cart', $arr);
            return "Insert";
        }
    }

    function getCartProducts($user_id) {
        $this->db->where('user_id', $user_id);
        return $this->db->get('add_to_cart')->result_array();
    }

    function getCartProductByCartId($cart_id_arr) {
        $this->db->where_in('id', $cart_id_arr);
        return $this->db->get('add_to_cart')->result_array();
    }

    function removeCart($user_id, $id) {
        $this->db->where('user_id', $user_id);
        $this->db->where('id', $id);
        return $this->db->delete('add_to_cart');
    }

    function removeAllProductsOfOrder_id($user_id, $prod_id) {
        $this->db->where('user_id', $user_id);
        $this->db->where_in('product_id', $prod_id);
        return $this->db->delete('add_to_cart');
    }

    function get_orderproduct($orders_id) {
        $this->db->select('products_id');
        $this->db->where('orders_id', $orders_id);
        return $this->db->get('orders_products')->result_array();
    }

    function get_coupononproduct($orders_id) {
        $this->db->select('coupon_id');
        $this->db->where('orders_id', $orders_id);
        return $this->db->get('orders_products')->result_array();
    }

    public function getProductsVideosByCategoryDataNumRows($category_id) {

        $this->db->select('P.id as product_id,P.seller as seller_id,company_types.name as seller_type,TIMESTAMPDIFF(YEAR, `seller_info.date_created`, CURDATE()) AS supplier_company_age,P.name as product_name,C.categories_name,PM.type as media_type, PM.url as media_url,PC1.price as price2,PC2.price as price1, PC1.final_price as final_price2,PC2.final_price as final_price1, PC1.quantity_from as moq1, PC2.quantity_from as moq2,PC1.atz_price as mrp,P.discount_percentage as discount');
        $this->db->from("product_details P");
        $this->db->join("categories_description C", "P.category = C.categories_id", "LEFT");
        $this->db->join("product_media PM", "PM.id = (SELECT id FROM product_media PM1 WHERE "
                . "PM1.product_id = P.id and type='video' ORDER BY PM1.id ASC LIMIT 1)", "LEFT");
        $this->db->join("product_price PC1", "PC1.id = (SELECT id FROM product_price PC3 WHERE "
                . "PC3.product_id = P.id ORDER BY PC3.id ASC LIMIT 1)");
        $this->db->join("product_price PC2", "PC2.id = (SELECT id FROM product_price PC4 WHERE "
                . "PC4.product_id = P.id ORDER BY PC4.id DESC LIMIT 1)");
        $this->db->join("users as users", "users.id=P.seller", "LEFT");
        $this->db->join("seller_info as seller_info", "seller_info.user_id=P.seller", "LEFT");
        $this->db->join("company_types as company_types", "company_types.id=seller_info.company_type", "LEFT");
        $this->db->where_in('P.category', $category_id);
        $query = $this->db->get();
        $result = $query->result_array();

        //echo $this->db->last_query();exit;

        for ($i = 0; $i < count($result); $i++) {

            if ($result[$i]['moq1'] < $result[$i]['moq2']) {
                $result[$i]['moq'] = $result[$i]['moq1'];
            } else {
                $result[$i]['moq'] = $result[$i]['moq2'];
            }

            if ($result[$i]['moq1'] != "" || $result[$i]['moq2'] != "") {
                unset($result[$i]['moq1']);
                unset($result[$i]['moq2']);
            }
        }

        return $query->num_rows();
    }

    public function getProductsVideosByCategoryData($category_id, $start_from = 0, $limit = 30) {//api
        $this->db->limit($limit, $start_from);
        $this->db->select('P.id as product_id,P.seller as seller_id,company_types.name as seller_type,TIMESTAMPDIFF(YEAR, `seller_info.date_created`, CURDATE()) AS supplier_company_age,P.name as name,C.categories_name,PM.type as media_type, PM.url as media_url,PC1.price as price2,PC2.price as price1, PC1.final_price as final_price2,PC2.final_price as final_price1, PC1.quantity_from as moq1, PC2.quantity_from as moq2, PC1.unit as units_id,units.units_name,PC1.atz_price as mrp,P.discount_percentage as discount');
        $this->db->from("product_details P");
        $this->db->join("categories_description C", "P.category = C.categories_id", "LEFT");
        $this->db->join("product_media PM", "PM.id = (SELECT id FROM product_media PM1 WHERE "
                . "PM1.product_id = P.id and type='video' ORDER BY PM1.id ASC LIMIT 1)", "LEFT");
        $this->db->join("product_price PC1", "PC1.id = (SELECT id FROM product_price PC3 WHERE "
                . "PC3.product_id = P.id ORDER BY PC3.id ASC LIMIT 1)", "LEFT");
        $this->db->join("product_price PC2", "PC2.id = (SELECT id FROM product_price PC4 WHERE "
                . "PC4.product_id = P.id ORDER BY PC4.id DESC LIMIT 1)", "LEFT");
        $this->db->join("users as users", "users.id=P.seller", "LEFT");
        $this->db->join("seller_info as seller_info", "seller_info.user_id=P.seller", "LEFT");
        $this->db->join("company_types as company_types", "company_types.id=seller_info.company_type", "LEFT");
        $this->db->join('units as units', 'PC1.unit=units.units_id', 'LEFT');
        $this->db->where_in('P.category', $category_id);
        $query = $this->db->get();
        $result = $query->result_array();

        //echo $this->db->last_query();exit;

        for ($i = 0; $i < count($result); $i++) {

            if ($result[$i]['moq1'] < $result[$i]['moq2']) {
                $result[$i]['moq'] = $result[$i]['moq1'];
            } else {
                $result[$i]['moq'] = $result[$i]['moq2'];
            }

            if ($result[$i]['moq1'] != "" || $result[$i]['moq2'] != "") {
                unset($result[$i]['moq1']);
                unset($result[$i]['moq2']);
            }
        }

        return $result;
    }

    public function deleteProductData($product_id) {
        //echo $product_id;exit;
        $this->db->where('id', $product_id);
        $this->db->delete('product_details');



        $this->db->where('product_id', $product_id);
        $this->db->delete('product_media');

        $this->db->where('product_id', $product_id);
        $this->db->delete('product_attributes');

        $this->db->where('product_id', $product_id);
        $this->db->delete('product_specifications');

        $this->db->where('product_id', $product_id);
        $this->db->delete('product_price ');

        return TRUE;
    }

    /*
     * @param comma separated string of product ids.
     * @return array of objects of product details
     */

    public function getProductDetailsByids($ids) {
        $query = $this->db->select("PD.*")
                ->from("$this->_table PD")
                ->where_in("id", $ids)
                ->get();
        return $query->result();
    }

    public function getProductMoqPrice($product_id) {
        $query = $this->db->select("quantity_from,price,final_price")
                ->from($this->_tablePrice)
                ->where(["product_id" => $product_id])
                ->order_by("id", "ASC")
                ->limit(1)
                ->get();
        return $query->row();
    }

    public function getProductAttrs($product_id) {
        $query = $this->db->select("PA.attribute_value,CSA.name")
                ->from($this->_tableAttr . " PA")
                ->join("category_specific_attributes CSA", "CSA.id = PA.attribute_id")
                ->where(["PA.product_id" => $product_id])
                ->get();
        return $query->result();
    }

    public function getProductBasicsById($product_id) {
        $query = $this->db->where(["id" => $product_id])
                ->get($this->_table);
        return $query->row();
    }

    public function getAllProductDetailsBySellers($sellers, $start_from = 0, $limit = 30) {
        $this->db->limit($limit, $start_from);

        $this->db->select('P.id as product_id,P.seller as seller_id,users.first_name as seller_firstname,users.last_name as seller_lastname,users.phone as seller_phone_no,users.email as seller_email,scd.company_name as seller_company_name,company_types.name as seller_type,TIMESTAMPDIFF(YEAR, `seller_info.date_created`, CURDATE()) AS supplier_company_age,P.name as product_name,P.description,C.categories_name,PM.url as media_url,PM2.url as video_url,PC1.final_price as final_price1,PC2.final_price as final_price2, PC1.quantity_from as moq1, PC2.quantity_from as moq2,units.units_id,units.units_name,P.discount_percentage as discount,PC1.atz_price as mrp');
        $this->db->from("product_details P");
        $this->db->join("categories_description C", "P.category = C.categories_id");
        $this->db->join("product_price PC1", "PC1.id = (SELECT id FROM product_price PC3 WHERE "
                . "PC3.product_id = P.id ORDER BY PC3.id ASC LIMIT 1)");
        $this->db->join("product_price PC2", "PC2.id = (SELECT id FROM product_price PC4 WHERE "
                . "PC4.product_id = P.id ORDER BY PC4.id DESC LIMIT 1)");
        $this->db->join("product_media PM", "PM.id = (SELECT id FROM product_media PM1 WHERE "
                . "PM1.product_id = P.id and type='photo' ORDER BY PM1.id ASC LIMIT 1)", "LEFT");
        $this->db->join("product_media PM2", "PM2.id = (SELECT id FROM product_media PM3 WHERE "
                . "PM3.product_id = P.id and type='video' ORDER BY PM3.id ASC LIMIT 1)", "LEFT");
        $this->db->join("users as users", "users.id=P.seller", "left");
        $this->db->join("seller_info as seller_info", "seller_info.user_id=P.seller", "left");
        $this->db->join("seller_company_details as scd", "P.seller=scd.user_id", "left");
        $this->db->join("company_types as company_types", "company_types.id=seller_info.company_type", "left");
        $this->db->join("units as units", "PC1.unit=units.units_id", "left");
        $this->db->where_in('P.seller', $sellers);
        $this->db->where('P.publish_status', 'approved');
        $query = $this->db->get();
        $result = $query->result_array();

        //echo $this->db->last_query();exit;

        for ($i = 0; $i < count($result); $i++) {

            if ($result[$i]['moq1'] < $result[$i]['moq2']) {
                $result[$i]['moq'] = $result[$i]['moq1'];
            } else {
                $result[$i]['moq'] = $result[$i]['moq2'];
            }

            if ($result[$i]['moq1'] != "" || $result[$i]['moq2'] != "") {
                unset($result[$i]['moq1']);
                unset($result[$i]['moq2']);
            }

            $this->db->where('product_id', $result[$i]['product_id']);
            $this->db->where('type', 'photo');
            $query = $this->db->get('product_media');
            $result[$i]['images'] = $query->result_array();
            $this->db->where('product_id', $result[$i]['product_id']);
            $this->db->where('type', 'video');
            $query = $this->db->get('product_media');
            $result[$i]['video'] = $query->result_array();
        }
        return $result;
    }

    public function returnSubCategory($pid, $limit) {
        $this->db->select("C.category_id");
        $this->db->from("categories C");
        $this->db->where("C.parent_id='" . $pid . "'");
        $query = $this->db->get();
        $result = $query->result_array();
        $subcat_id = array();
        foreach ($result as $res) {
            $subcat_id[] = $res['category_id'];
        }
        $this->db->select("PD.id,PD.name,PM.url,PC2.quantity_from,PC2.price as max_price,PP2.price as min_price, PC2.final_price as max_final_price,PP2.final_price as min_final_price");
        $this->db->from("product_details PD");
        $this->db->join("product_media PM", "PM.id = (SELECT id FROM product_media PM1 WHERE "
                . "PM1.product_id = PD.id ORDER BY PM1.id ASC LIMIT 1)");
        $this->db->join("product_price PC2", "PC2.id = (SELECT id FROM product_price PC4 WHERE "
                . "PC4.product_id = PD.id ORDER BY PC4.id ASC LIMIT 1)");
        $this->db->join("product_price PP2", "PP2.id = (SELECT id FROM product_price PP4 WHERE "
                . "PP4.product_id = PD.id ORDER BY PP4.id DESC LIMIT 1)");
        $this->db->where("PD.publish_status", "approved");
        $this->db->where_in("PD.category", $subcat_id);
        $this->db->order_by("PD.id", "DESC");
        $this->db->limit($limit);
        $query = $this->db->get();
        $result = $query->result_array();
        return $result;
    }

    /* ------------------TOP SELLING PRODUCTS-------------- */

    public function topSellingProductsData($limit = 10) {
        $this->db->limit($limit);
        $this->db->select("oc.offer_id,offer_type,discount_value as offer_discount_value,oz.status as offer_status, valid_from, time_from, valid_to, time_to ,oz.title,PD.id,PD.name,PM.url,PC2.quantity_from,PC2.price as max_price,PP2.price as min_price,"
                . "PR2.sales, PC2.final_price as max_final_price,PP2.final_price as min_final_price,"
                . "PD.discount_percentage as discount,PC2.atz_price as mrp");
        $this->db->from("product_details PD");
        $this->db->join("product_media PM", "PM.id = (SELECT id FROM product_media PM1 WHERE "
                . "PM1.product_id = PD.id ORDER BY PM1.id ASC LIMIT 1)");
        $this->db->join("product_price PC2", "PC2.id = (SELECT id FROM product_price PC4 WHERE "
                . "PC4.product_id = PD.id ORDER BY PC4.id ASC LIMIT 1)");
        $this->db->join("product_price PP2", "PP2.id = (SELECT id FROM product_price PP4 WHERE "
                . "PP4.product_id = PD.id ORDER BY PP4.id DESC LIMIT 1)");
        $this->db->join("product_review PR2", "PR2.product_id=PD.id");
        $this->db->join("categories cat", "cat.category_id = PD.category", 'left');
        $this->db->join("offer_categories oc","oc.category_id = PD.category", 'left');
        $this->db->join("offer_zone oz", " oz.offer_id = oc.offer_id AND oz.status = 'active'", 'left');
        $this->db->where("PD.publish_status", "approved");
        $this->db->order_by("PD.discount_percentage", "DESC");
        $this->db->order_by("PR2.sales", "DESC");
        $this->db->order_by("PD.id", "DESC");
        $query = $this->db->get();
        $result = $query->result_array();
        return $result;
    }

    /* ----------------- Top Selling Products Particular Seller By Seller Id--------------- */

    public function topSellingProductsBySeller($sellerid, $limit = 4) {
        $this->db->limit($limit);
        $this->db->select("PD.id,PD.name,PM.url,PC2.quantity_from,PC2.price as max_price,PP2.price as min_price,PC2.final_price,PC2.atz_price as mrp,PD.discount_percentage as discount,PR2.sales,u.units_id,u.units_name");
        $this->db->from("product_details PD");
        $this->db->join("product_media PM", "PM.id = (SELECT id FROM product_media PM1 WHERE "
                . "PM1.product_id = PD.id ORDER BY PM1.id ASC LIMIT 1)");
        $this->db->join("product_price PC2", "PC2.id = (SELECT id FROM product_price PC4 WHERE "
                . "PC4.product_id = PD.id ORDER BY PC4.id ASC LIMIT 1)");
        $this->db->join("product_price PP2", "PP2.id = (SELECT id FROM product_price PP4 WHERE "
                . "PP4.product_id = PD.id ORDER BY PP4.id DESC LIMIT 1)");
        $this->db->join("product_review PR2", "PR2.product_id=PD.id", "LEFT");
        $this->db->join("units u", "u.units_id=PP2.unit");
        $this->db->where("PD.seller", $sellerid);
        $query = $this->db->get();
        $result = $query->result_array();
        return $result;
    }

    public function getProductsVideosByCategoryDataNumRows2($categories_id) {

        $this->db->select('P.id as product_id,P.seller as seller_id,users.first_name as seller_firstname,users.last_name as seller_lastname,users.phone as seller_phone_no,users.email as seller_email,scd.company_name as seller_company_name,scd.logo as company_logo,company_types.name as seller_type,TIMESTAMPDIFF(YEAR, `seller_info.date_created`, CURDATE()) AS supplier_company_age,P.name as product_name,P.description,C.categories_name,PM.url as media_url,PM2.url as video_url,PC1.price as price1,PC2.price as price2, PC1.final_price as final_price1,PC2.final_price as final_price2, PC1.quantity_from as moq1, PC2.quantity_from as moq2,units.units_id,units.units_name,PC1.atz_price as mrp,P.discount_percentage as discount');
        $this->db->from("product_details P");
        $this->db->join("categories_description C", "P.category = C.categories_id");
        $this->db->join("product_price PC1", "PC1.id = (SELECT id FROM product_price PC3 WHERE "
                . "PC3.product_id = P.id ORDER BY PC3.id ASC LIMIT 1)");
        $this->db->join("product_price PC2", "PC2.id = (SELECT id FROM product_price PC4 WHERE "
                . "PC4.product_id = P.id ORDER BY PC4.id DESC LIMIT 1)");
        $this->db->join("product_media PM", "PM.id = (SELECT id FROM product_media PM1 WHERE "
                . "PM1.product_id = P.id and type='photo' ORDER BY PM1.id ASC LIMIT 1)", "LEFT");
        $this->db->join("product_media PM2", "PM2.id = (SELECT id FROM product_media PM3 WHERE "
                . "PM3.product_id = P.id and type='video' ORDER BY PM3.id ASC LIMIT 1)", "LEFT");
        $this->db->join("users as users", "users.id=P.seller", "left");
        $this->db->join("seller_info as seller_info", "seller_info.user_id=P.seller", "left");
        $this->db->join("seller_company_details as scd", "P.seller=scd.user_id", "left");
        $this->db->join("company_types as company_types", "company_types.id=seller_info.company_type", "left");
        $this->db->join("units as units", "PC1.unit=units.units_id", "left");
        $this->db->where_in('P.category', $categories_id);
        $query = $this->db->get();
        $products_count = $query->num_rows();
        $result = $query->result_array();

        //echo $this->db->last_query();exit;

        for ($i = 0; $i < count($result); $i++) {

            if ($result[$i]['moq1'] < $result[$i]['moq2']) {
                $result[$i]['moq'] = $result[$i]['moq1'];
            } else {
                $result[$i]['moq'] = $result[$i]['moq2'];
            }

            if ($result[$i]['moq1'] != "" || $result[$i]['moq2'] != "") {
                unset($result[$i]['moq1']);
                unset($result[$i]['moq2']);
            }


            $this->db->where('product_id', $result[$i]['product_id']);
            $this->db->where('type', 'photo');
            $query = $this->db->get('product_media');
            $result[$i]['images'] = $query->result_array();

            $this->db->where('product_id', $result[$i]['product_id']);
            $this->db->where('type', 'video');
            $query = $this->db->get('product_media');
            $result[$i]['video'] = $query->result_array();
        }


        return $products_count;
    }

    public function getProductsVideosByCategoryData2($categories_id, $start_from = 0, $limit = 30) {
        $this->db->limit($limit, $start_from);
        $this->db->select($this->selectOffer.'P.id as product_id,P.seller as seller_id,users.first_name as seller_firstname,users.last_name as seller_lastname,users.phone as seller_phone_no,users.email as seller_email,scd.company_name as seller_company_name,scd.logo as company_logo,company_types.name as seller_type,TIMESTAMPDIFF(YEAR, `seller_info.date_created`, CURDATE()) AS supplier_company_age,P.name as product_name,P.description,C.categories_name,PM.url as media_url,PM2.url as video_url,PC1.price as price1,PC2.price as price2, PC1.final_price as final_price1,PC2.final_price as final_price2, PC1.quantity_from as moq1, PC2.quantity_from as moq2,units.units_id,units.units_name,PC1.atz_price as mrp,P.discount_percentage as discount');
        $this->db->from("product_details P");
        $this->offerJoins();
        $this->db->join("categories_description C", "P.category = C.categories_id");
        $this->db->join("product_price PC1", "PC1.id = (SELECT id FROM product_price PC3 WHERE "
                . "PC3.product_id = P.id ORDER BY PC3.id ASC LIMIT 1)");
        $this->db->join("product_price PC2", "PC2.id = (SELECT id FROM product_price PC4 WHERE "
                . "PC4.product_id = P.id ORDER BY PC4.id DESC LIMIT 1)");
        $this->db->join("product_media PM", "PM.id = (SELECT id FROM product_media PM1 WHERE "
                . "PM1.product_id = P.id and type='photo' ORDER BY PM1.id ASC LIMIT 1)", "LEFT");
        $this->db->join("product_media PM2", "PM2.id = (SELECT id FROM product_media PM3 WHERE "
                . "PM3.product_id = P.id and type='video' ORDER BY PM3.id ASC LIMIT 1)", "LEFT");
        $this->db->join("users as users", "users.id=P.seller", "left");
        $this->db->join("seller_info as seller_info", "seller_info.user_id=P.seller", "left");
        $this->db->join("seller_company_details as scd", "P.seller=scd.user_id", "left");
        $this->db->join("company_types as company_types", "company_types.id=seller_info.company_type", "left");
        $this->db->join("units as units", "PC1.unit=units.units_id", "left");
        $this->db->where_in('P.category', $categories_id);
        $query = $this->db->get();
        $result = $query->result_array();

        //echo $this->db->last_query();exit;

        for ($i = 0; $i < count($result); $i++) {

            if ($result[$i]['moq1'] < $result[$i]['moq2']) {
                $result[$i]['moq'] = $result[$i]['moq1'];
            } else {
                $result[$i]['moq'] = $result[$i]['moq2'];
            }

            if ($result[$i]['moq1'] != "" || $result[$i]['moq2'] != "") {
                unset($result[$i]['moq1']);
                unset($result[$i]['moq2']);
            }


            $this->db->where('product_id', $result[$i]['product_id']);
            $this->db->where('type', 'photo');
            $query = $this->db->get('product_media');
            $result[$i]['images'] = $query->result_array();

            $this->db->where('product_id', $result[$i]['product_id']);
            $this->db->where('type', 'video');
            $query = $this->db->get('product_media');
            $result[$i]['video'] = $query->result_array();

            $result[$i]['company_logo'] = base_url() . "uploads/images/seller_company_logo/" . $result[$i]['company_logo'];
        }


        return $result;
    }

    public function topSellingProductsDataByCategory($category, $limit = 30, $start_from = 0) {

        $select = "DISTINCT(P.id) as product_id,"
                . " P.name,C.categories_name,PM.type as media_type, PM.url as media_url,PC1.price as price1,PC1.atz_price as mrp,P.discount_percentage as discount,"
                . "PC2.price as price2,PC1.final_price as final_price1, PC2.final_price as final_price2,PC1.quantity_from as moq,PC1.unit as units_id,units.units_name,"
                . "COUNT(INQ.id) as inquiry_count";

        $this->db
                ->select($select)
                ->from($this->_table . " P")
                ->join($this->_tableCategory . " C", "P.category = C.categories_id")
                ->join($this->_tableMedia . " PM", "PM.id = (SELECT id FROM $this->_tableMedia PM1 WHERE "
                        . "PM1.product_id = P.id ORDER BY PM1.id ASC LIMIT 1)", "LEFT")
                ->join($this->_tablePrice . " PC1", "PC1.id = (SELECT id FROM $this->_tablePrice PC3 WHERE "
                        . "PC3.product_id = P.id ORDER BY PC3.id ASC LIMIT 1)", "LEFT")
                ->join($this->_tablePrice . " PC2", "PC2.id = (SELECT id FROM $this->_tablePrice PC4 WHERE "
                        . "PC4.product_id = P.id ORDER BY PC4.id DESC LIMIT 1)", "LEFT")
                ->join('units as units', 'PC1.unit=units.units_id', 'LEFT')
                ->join("product_review PR", "PR.product_id=P.id", 'LEFT')
                ->join("inquiries INQ", "INQ.for_product=P.id", 'LEFT')
                ->where(["P.category" => $category])
                ->order_by("PR.sales", "DESC")
                ->group_by("P.id");

        $this->db->limit($limit, $start_from);
        $query = $this->db->get($this->_table);
        $result = $query->result();
        return $result;
    }

    /*
     * @param String comma separated list of category ids
     */

    public function getProductNamesByMultipleCats($cats) {
        $this->db->select("id,name");
        $this->db->from($this->_table);
        $this->db->where_in("category", $cats);
        $query = $this->db->get();
        return $query->result();
    }

    /*
     * Add coupon to products (bulk)
     * @param array of object of coupon data
     */

    public function addCouponToProducts($data) {
        $this->db->insert_batch("coupons_to_product", $data);
    }

    /*
     * Get product coupons
     */

    public function getProductCoupens($product_id) {

        $this->db->select("C.coupon_id as coupon_uniqe_id, coupon_code,coupon_value,discount_type,moq,valid_from,valid_to,currency");
        $this->db->from("coupons C");
        $this->db->join("coupons_to_product CP", "CP.coupon_id = C.coupon_id");
        $this->db->where(["CP.product_id" => $product_id]);
        $this->db->where("valid_from <= '" . date("Y-m-d") . "' AND valid_to >= '" . date("Y-m-d") . "'");
        $query = $this->db->get();
        return $query->result();
    }

    public function getProductCoupens_web($product_id, $user_id) {

        $this->db->select("C.coupon_id as coupon_uniqe_id, mc.coupon_id as check_coupon_id, coupon_code,coupon_value,discount_type,moq,valid_from,valid_to,currency");
        $this->db->from("coupons C");
        $this->db->join("coupons_to_product CP", "CP.coupon_id = C.coupon_id");
        $this->db->join("mycoupons mc", "mc.coupon_id = CP.coupon_id AND mc.user_id='$user_id' AND mc.status='REDEEM'", "left");
        $this->db->where(["CP.product_id" => $product_id]);
        $this->db->where("valid_from <= '" . date("Y-m-d") . "' AND valid_to >= '" . date("Y-m-d") . "'");
        $query = $this->db->get();
        return $query->result();
    }

    function checkValidCoupon($coupon_id, $product_id) {
        $this->db->from("coupons_to_product");
        $this->db->where("product_id", $product_id);
        $this->db->where("coupon_id", $coupon_id);
        $query = $this->db->get();
        return $query->num_rows();
    }

    function checkWhetherUsed($coupon_id, $user_id) {
        $this->db->from("mycoupons");
        $this->db->where("user_id", $user_id);
        $this->db->where("coupon_id", $coupon_id);
        $this->db->where("status", 'REDEEM');
        $query = $this->db->get()->result_array();
        return $query;
    }

    function checkCouponValue($coupon_id) {
        $this->db->select('moq,coupon_value');
        $this->db->from("coupons");
        $this->db->where("coupon_id", $coupon_id);
        return $this->db->get()->row();
    }

    public function updateMyCoupon($arr) {
        $this->db->where('user_id', $arr['user_id']);
        $this->db->where('coupon_id', $arr['coupon_id']);
        $this->db->where('status', $arr['status']);
        $query = $this->db->get('mycoupons')->row();
        if (count($query) == 0) {
            return $this->db->insert('mycoupons', $arr);
        }
    }

    function updatemycouponStatus($user_id, $coupon_id) {
        $this->db->set('status', 'REDEEM');
        $this->db->where('user_id', $user_id);
        $this->db->where_in('coupon_id', $coupon_id);
        return $this->db->update('mycoupons');
    }

    public function getProductsByCoupon($coupon_id) {
        $select = "DISTINCT(P.id) as product_id,
        P.name,
        C.categories_name,
        PM.type as media_type,
        PM.url as media_url,
        PC1.price as price1,
        PC2.price as price2,PC1.final_price as final_price1,PC2.final_price as final_price2,PC1.quantity_from as moq,PC1.unit as units_id,units.units_name";

        $this->db
                ->select($select)
                ->from($this->_table . " P")
                ->join($this->_tableCategory . " C", "P.category = C.categories_id")
                ->join($this->_tableMedia . " PM", "PM.id = (SELECT id FROM $this->_tableMedia PM1 WHERE "
                        . "PM1.product_id = P.id ORDER BY PM1.id ASC LIMIT 1)", "LEFT")
                ->join($this->_tablePrice . " PC1", "PC1.id = (SELECT id FROM $this->_tablePrice PC3 WHERE "
                        . "PC3.product_id = P.id ORDER BY PC3.id ASC LIMIT 1)", "LEFT")
                ->join($this->_tablePrice . " PC2", "PC2.id = (SELECT id FROM $this->_tablePrice PC4 WHERE "
                        . "PC4.product_id = P.id ORDER BY PC4.id DESC LIMIT 1)", "LEFT")
                ->join('units as units', 'PC1.unit=units.units_id', 'LEFT')
                ->join("coupons_to_product CP", "CP.product_id = P.id")
                ->where(["CP.coupon_id" => $coupon_id]);
        $query = $this->db->get();
        return $query->result();
    }

    public function updatePolicies($policies_array) {
        if ($policies_array != 0) {
            $this->db->where('product_id', $policies_array['product_id']);
            $this->db->delete('product_return_policy');

            for ($i = 0; $i < count($policies_array['policy']); $i++) {
                $this->db->set('product_id', $policies_array['product_id']);
                $this->db->set('policy', $policies_array['policy'][$i]);
                $this->db->insert('product_return_policy');
            }
        }
    }

    public function getProductPolicies($product_id) {
        $this->db->where('product_id', $product_id);
        $query = $this->db->get('product_return_policy');
        $result = $query->result();
        return $result;
    }

    //Home page search
    public function getProductBySearch($search) {
        $this->db->select('P.id as product_id,P.name,C.categories_name,PM.type as media_type,PM.url as media_url,PC1.price as price1,PC2.price as price2');
        $this->db->like('P.id', $search);
        $this->db->or_like('P.name', $search);
        $this->db->from($this->_table . " P");
        $this->db->join($this->_tableCategory . " C", "P.category = C.categories_id");
        $this->db->join($this->_tableMedia . " PM", "PM.id = (SELECT id FROM $this->_tableMedia PM1 WHERE "
                . "PM1.product_id = p.id ORDER BY PM1.id ASC LIMIT 1)");
        $this->db->join($this->_tablePrice . " PC1", "PC1.id = (SELECT id FROM $this->_tablePrice PC3 WHERE "
                . "PC3.product_id = p.id ORDER BY PC3.id ASC LIMIT 1)");
        $this->db->join($this->_tablePrice . " PC2", "PC2.id = (SELECT id FROM $this->_tablePrice PC4 WHERE "
                . "PC4.product_id = p.id ORDER BY PC4.id DESC LIMIT 1)");
        $this->db->order_by("P.name" . $col, $dir);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return null;
        }
    }

    /*     * **********
     * @Description Get product list by multiple category ids
     * @param Array of category ids
     * @retrun Array of objects of product
     */

    public function getProductListByCategrories($categories, $start = 0, $limit = 100) {
        $select = "DISTINCT(P.id) as product_id,
        P.name,
        C.categories_name,
        PM.type as media_type,
        PM.url as media_url,
        PC1.price as price1,
        PC1.final_price as final_price1,
        PC1.atz_price as mrp,
        P.discount_percentage as discount,
        PC2.final_price as final_price2,
        PC2.price as price2,PC1.quantity_from as moq,PC1.unit as units_id,units.units_name,P.category"
        .',oz.offer_id,offer_type,discount_value as offer_discount_value,oz.status, valid_from, time_from,
         valid_to, time_to ,oz.title,parent_id,';

        $this->db
                ->select($select)
                ->from($this->_table . " P")
                ->join($this->_tableCategory . " C", "P.category = C.categories_id")
                ->join("categories cat", "cat.category_id = P.category", 'left')
                ->join("offer_categories oc", "oc.category_id = P.category", 'left')
                ->join("offer_zone oz", " oz.offer_id = oc.offer_id AND oz.status = 'active'", 'left')
                ->join($this->_tableMedia . " PM", "PM.id = (SELECT id FROM $this->_tableMedia PM1 WHERE "
                        . "PM1.product_id = P.id ORDER BY PM1.id ASC LIMIT 1)")
                ->join($this->_tablePrice . " PC1", "PC1.id = (SELECT id FROM $this->_tablePrice PC3 WHERE "
                        . "PC3.product_id = P.id ORDER BY PC3.id ASC LIMIT 1)")
                ->join($this->_tablePrice . " PC2", "PC2.id = (SELECT id FROM $this->_tablePrice PC4 WHERE "
                        . "PC4.product_id = P.id ORDER BY PC4.id DESC LIMIT 1)")
                ->join('units as units', 'PC1.unit=units.units_id', 'LEFT')
                ->where_in("P.category", $categories)
                ->where("P.publish_status", "approved");


        $this->db->limit($limit, $start_from);
        $query = $this->db->get($this->_table);
        $result = $query->result();
        return $result;
    }

    /*     * **********
     * @Description Get product list by multiple category ids
     * @param Array of category ids
     * @retrun Array of objects of product
     */

    public function getProductListByIds($ids, $start = 0, $limit = 100) {
        $select = "DISTINCT(P.id) as product_id,
        P.name,
        C.categories_name,
        PM.type as media_type,
        PM.url as media_url,
        PC1.price as price1,
        PC1.atz_price as mrp,
        P.discount_percentage as discount,
        PC1.final_price as final_price1,
        PC2.final_price as final_price2,
        PC2.price as price2,PC1.quantity_from as moq,PC1.unit as units_id,units.units_name";

        $this->db
                ->select($select)
                ->from($this->_table . " P")
                ->join($this->_tableCategory . " C", "P.category = C.categories_id")
                ->join($this->_tableMedia . " PM", "PM.id = (SELECT id FROM $this->_tableMedia PM1 WHERE "
                        . "PM1.product_id = P.id ORDER BY PM1.id ASC LIMIT 1)", "LEFT")
                ->join($this->_tablePrice . " PC1", "PC1.id = (SELECT id FROM $this->_tablePrice PC3 WHERE "
                        . "PC3.product_id = P.id ORDER BY PC3.id ASC LIMIT 1)")
                ->join($this->_tablePrice . " PC2", "PC2.id = (SELECT id FROM $this->_tablePrice PC4 WHERE "
                        . "PC4.product_id = P.id ORDER BY PC4.id DESC LIMIT 1)")
                ->join('units as units', 'PC1.unit=units.units_id', 'LEFT')
                ->where_in("P.id", $ids);

        $this->db->limit($limit, $start_from);
        $query = $this->db->get($this->_table);
        $result = $query->result();
        return $result;
    }

    /*
     * @Desc function to get products by discount type and discount value greater than equal to
     * @param String discount type
     * @param Integer value in percentage
     *
     */

    public function getDiscoutedProduct($value = 5, $type = "percentage", $start = 0, $limit = 1000) {
        $select = "DISTINCT(P.id) as product_id,
        P.name,
        C.categories_name,
        PM.type as media_type,
        PM.url as media_url,
        PC1.price as price1,
        PC1.atz_price as mrp,
        P.discount_percentage as discount,
        PC1.final_price as final_price1,
        PC2.final_price as final_price2,
        PC2.price as price2,PC1.quantity_from as moq,PC1.unit as units_id,units.units_name,
        COU.coupon_value as discount,
        COU.discount_type as discount_type , COU.moq as discount_moq";

        $this->db
                ->select($select)
                ->from($this->_table . " P")
                ->join($this->_tableCategory . " C", "P.category = C.categories_id")
                ->join($this->_tableMedia . " PM", "PM.id = (SELECT id FROM $this->_tableMedia PM1 WHERE "
                        . "PM1.product_id = P.id ORDER BY PM1.id ASC LIMIT 1)", "LEFT")
                ->join($this->_tablePrice . " PC1", "PC1.id = (SELECT id FROM $this->_tablePrice PC3 WHERE "
                        . "PC3.product_id = P.id ORDER BY PC3.id ASC LIMIT 1)")
                ->join($this->_tablePrice . " PC2", "PC2.id = (SELECT id FROM $this->_tablePrice PC4 WHERE "
                        . "PC4.product_id = P.id ORDER BY PC4.id DESC LIMIT 1)")
                ->join('units as units', 'PC1.unit=units.units_id', 'LEFT')
                ->join('coupons_to_product as CP', 'CP.product_id=P.id')
                ->join('coupons as COU', 'COU.coupon_id=CP.coupon_id')
                ->where(["COU.coupon_value >=" => $value, "COU.discount_type" => $type])
                ->where('P.publish_status', 'approved')
                ->limit($limit, $start);
        ;

        $this->db->limit($limit, $start_from);
        $query = $this->db->get($this->_table);
        $result = $query->result();
        return $result;
    }

    /*
     * @Desc function to get products by discount type and discount value upto
     * @param String discount type
     * @param Integer value in percentage
     *
     */

    public function getProductsUptoDiscount($value = 5, $type = "percentage", $start = 0, $limit = 1000) {
        $select = "DISTINCT(P.id) as product_id,
        P.name,
        C.categories_name,
        PM.type as media_type,
        PM.url as media_url,
        PC1.price as price1,
        PC1.atz_price as mrp,
        P.discount_percentage as discount,
        PC1.final_price as final_price1,
        PC2.final_price as final_price2,
        PC2.price as price2,PC1.quantity_from as moq,PC1.unit as units_id,units.units_name,
        COU.coupon_value as discount,
        COU.discount_type as discount_type, COU.moq as discount_moq";

        $this->db
                ->select($select)
                ->from($this->_table . " P")
                ->join($this->_tableCategory . " C", "P.category = C.categories_id")
                ->join($this->_tableMedia . " PM", "PM.id = (SELECT id FROM $this->_tableMedia PM1 WHERE "
                        . "PM1.product_id = P.id ORDER BY PM1.id ASC LIMIT 1)", "LEFT")
                ->join($this->_tablePrice . " PC1", "PC1.id = (SELECT id FROM $this->_tablePrice PC3 WHERE "
                        . "PC3.product_id = P.id ORDER BY PC3.id ASC LIMIT 1)")
                ->join($this->_tablePrice . " PC2", "PC2.id = (SELECT id FROM $this->_tablePrice PC4 WHERE "
                        . "PC4.product_id = P.id ORDER BY PC4.id DESC LIMIT 1)")
                ->join('units as units', 'PC1.unit=units.units_id', 'LEFT')
                ->join('coupons_to_product as CP', 'CP.product_id=P.id')
                ->join('coupons as COU', 'COU.coupon_id=CP.coupon_id')
                ->where(["COU.coupon_value <=" => $value, "COU.discount_type" => $type])
                ->where('P.publish_status', 'approved')
                ->limit($limit, $start);
        ;

        $this->db->limit($limit, $start_from);
        $query = $this->db->get($this->_table);
        $result = $query->result();
        return $result;
    }

    /*
     * @Desc function to get products by discount type and discount value upto
     * @param String discount type
     * @param Integer value in percentage
     *
     */

    public function searchProductsByName($name = "DEFAULT_NOT_FOUND", $start_from = 0, $limit = 10) {
        $select = "DISTINCT(P.id) as product_id,
        P.name,
        C.categories_id,
		C.categories_name,
        PM.type as media_type,
        PM.url as media_url,
        PC1.price as price1,
        PC1.final_price as final_price1,
        PC1.atz_price as mrp,
        P.discount_percentage as discount,
        PC2.final_price as final_price2,
        PC2.price as price2,PC1.quantity_from as moq,PC1.unit as units_id,units.units_name";

        $this->db
                ->select($select)
                ->from($this->_table . " P")
                ->join($this->_tableCategory . " C", "P.category = C.categories_id")
                ->join($this->_tableMedia . " PM", "PM.id = (SELECT id FROM $this->_tableMedia PM1 WHERE "
                        . "PM1.product_id = P.id ORDER BY PM1.id ASC LIMIT 1)", "LEFT")
                ->join($this->_tablePrice . " PC1", "PC1.id = (SELECT id FROM $this->_tablePrice PC3 WHERE "
                        . "PC3.product_id = P.id ORDER BY PC3.id ASC LIMIT 1)")
                ->join($this->_tablePrice . " PC2", "PC2.id = (SELECT id FROM $this->_tablePrice PC4 WHERE "
                        . "PC4.product_id = P.id ORDER BY PC4.id DESC LIMIT 1)")
                ->join('units as units', 'PC1.unit=units.units_id', 'LEFT')
                ->like("P.name", $name)
                ->or_like("C.categories_name", $name);

        $this->db->limit($limit, $start_from);
        $query = $this->db->get($this->_table);
        $result = $query->result();
        return $result;
    }

    /*
     * @Desc function to get products by discount type and discount value upto
     * @param String discount type
     * @param Integer value in percentage
     *
     */

    public function getProductListSortByDate($limit, $start) {
        $select = "DISTINCT(P.id) as product_id,
        P.name,
        C.categories_name,
        PM.type as media_type,
        PM.url as media_url,
        PC1.price as price1,
        PC1.atz_price as mrp,
        P.discount_percentage as discount,
        PC1.final_price as final_price1,
        PC2.final_price as final_price2,
        PC2.price as price2,PC1.quantity_from as moq,PC1.unit as units_id,units.units_name";

        $this->db
                ->select($select)
                ->from($this->_table . " P")
                ->join($this->_tableCategory . " C", "P.category = C.categories_id")
                ->join($this->_tableMedia . " PM", "PM.id = (SELECT id FROM $this->_tableMedia PM1 WHERE "
                        . "PM1.product_id = P.id ORDER BY PM1.id ASC LIMIT 1)")
                ->join($this->_tablePrice . " PC1", "PC1.id = (SELECT id FROM $this->_tablePrice PC3 WHERE "
                        . "PC3.product_id = P.id ORDER BY PC3.id ASC LIMIT 1)")
                ->join($this->_tablePrice . " PC2", "PC2.id = (SELECT id FROM $this->_tablePrice PC4 WHERE "
                        . "PC4.product_id = P.id ORDER BY PC4.id DESC LIMIT 1)")
                ->join('units as units', 'PC1.unit=units.units_id', 'LEFT')
                ->where("P.publish_status", "approved")
                ->order_by("P.modified_at", "DESC")
                ->limit($limit, $start);


        $this->db->limit($limit, $start_from);
        $query = $this->db->get($this->_table);
        $result = $query->result();
        return $result;
    }

    public function getSellerIdByProduct($id) {
        $query = $this->db->select("seller")
                ->from($this->_table)
                ->where("id", $id)
                ->get();
        $res = $query->row();
        return $res->seller;
    }

    /* use for add to cart Functionality */

    public function getSellerIdByProductId($id) {
        $query = $this->db->select("name,seller")
                ->from($this->_table)
                ->where("id", $id)
                ->get();
        $res = $query->row();
        return $res;
    }

    public function getSellerInformationBySellerId($seller_id) {
        $this->db->select('first_name, last_name, company_name');
        $this->db->from('seller_info s');
        $this->db->join('users u', 's.user_id = u.id');
        $this->db->where('s.user_id', $seller_id);
        return $result = $this->db->get()->row();
    }

    public function getProductPriceByProductId($arr_productid) {
        $this->db->select('atc.id as cart_id,p.name,u.first_name,u.last_name,p.seller,sinfo.company_name,pm.url,pp.*,un.units_name');
        $this->db->from('product_details p');
        $this->db->join('product_media pm', 'pm.product_id = p.id');
        $this->db->join('product_price pp', 'pp.product_id = p.id');
        $this->db->join('add_to_cart atc', 'atc.product_id = p.id');
        $this->db->join('seller_info sinfo', 'sinfo.user_id = p.seller');
        $this->db->join('users u', 'u.id = sinfo.user_id');
        $this->db->join('units un', 'un.units_id = pp.unit');
        $this->db->group_by('pm.product_id');
        $this->db->where_in('p.id', $arr_productid);
        $result = $this->db->get()->result_array();
        return $result;
    }

    /* End Use of Add To Cart Functionality */

    public function setCommissionOnProduct($product_id, $commision = 100, $discount = 0) {
        //$multi = "$commision / 100";
        $this->db->where(["product_id" => $product_id]);
        $this->db->set('atz_price', "ROUND(price + (price * $commision / 100))", FALSE);
        $this->db->update('product_price');
        //if discount is zero then we must update final price also else it will show final_price = price
        //so changed following removed if condition
        //if($discount){
        $this->db->where(["product_id" => $product_id]);
        $this->db->set('final_price', "ROUND(atz_price - (atz_price * $discount / 100))", FALSE);
        $this->db->update('product_price');
        //}
        return $this->db->last_query();
    }

    /*
      get particular Specification
      @pass spec_id Array
      @pass spec_value Array
      @return specification particular id;
     */

    public function getSpecification($spec_id, $spec_value, $product_id) {
        $this->db->select("*");
        $this->db->from("product_specifications");
        $this->db->where_in("spec_id", $spec_id);
        $this->db->where_in("spec_value", $spec_value);
        $this->db->where("product_id", $product_id);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function getSellerInformation($seller_id) {
        //solved for not showing seller names by adding left join parameter in join query
        $this->db->select('first_name, last_name, company_name, address1, ad.street,ad.city,ad.postcode,ad.state,ct.name, phone, email, c.name as country_name');
        $this->db->from('seller_info s');
        $this->db->join('users u', 's.user_id = u.id', 'left');
        $this->db->join('address_book ad', 'ad.user_id = u.id', 'left'); //change Here add this table line
        $this->db->join('country c', 'u.country = c.id', 'left');
        //$this->db->join('country c','u.country = c.id');
        $this->db->join('company_types ct', 'ct.id = s.company_type', 'left');
        $this->db->where('s.user_id', $seller_id);
        return $result = $this->db->get()->row_array();
    }

    function getCartProducts_Byid($id, $user_id) {
        $this->db->select('offer_id,id,seller_id,user_id,product_id,product_total_quantity,product_name,product_image,supplierDetails,specifications');
        $this->db->where('seller_id', $id);
        $this->db->where('user_id', $user_id);
        return $this->db->get('add_to_cart')->result_array();
    }

    public function increamentQuantity($product, $quantity) {
        if ($quantity < 0) {
            return 'Invalid quantity!';
        }
        /*         * *** This function changes previosly able to increase only now it will update as is ********* */
        $this->db->where("id", $product);
        $this->db->set("available_quantity", $quantity);
        $this->db->update($this->_table);
    }

    // get All Product of Your Favourite List
    function getProductDetailsYourFav($products_id = 0) {

        $this->db->select('p.*,pm.url,pp.*');
        $this->db->from('product_details p');
        $this->db->join('product_media pm', 'pm.product_id = p.id');
        $this->db->join('product_price pp', 'pp.product_id = p.id');
        $this->db->group_by('pm.product_id');
        $this->db->where_in('p.id', $products_id);
        $result = $this->db->get()->result_array();
        return $result;
    }

    function get_filterdProducts($category_id, $min_order, $min_price, $max_price, $sortby) {


        $this->db->select('P.id as product_id,P.seller as seller_id,users.user_package,company_types.name as seller_type,TIMESTAMPDIFF(YEAR, `seller_info.date_created`, CURDATE()) AS supplier_company_age,P.name as product_name,C.categories_name,PM.type as media_type, PM.url as media_url,PC1.price as price2,PC2.price as price1,PC1.final_price as final_price2,PC2.final_price as final_price1,PC1.quantity_upto as moq1, PC2.quantity_from as moq2,units.units_id as units_id,units.units_name as units_name,P.discount_percentage as discount,PC2.atz_price as mrp');
        $this->db->from("product_details P");
        $this->db->join("categories_description C", "P.category = C.categories_id");
        $this->db->join("product_media PM", "PM.id = (SELECT id FROM product_media PM1 WHERE "
                . "PM1.product_id = P.id ORDER BY PM1.id ASC LIMIT 1)");
        $this->db->join("product_price PC1", "PC1.id = (SELECT id FROM product_price PC3 WHERE "
                . "PC3.product_id = P.id ORDER BY PC3.id ASC LIMIT 1)");
        $this->db->join("product_price PC2", "PC2.id = (SELECT id FROM product_price PC4 WHERE "
                . "PC4.product_id = P.id ORDER BY PC4.id DESC LIMIT 1)");
        $this->db->join("users as users", "users.id=P.seller", "INNER");
        $this->db->join("seller_info as seller_info", "seller_info.user_id=P.seller", "LEFT");
        $this->db->join("company_types as company_types", "company_types.id=seller_info.company_type", "LEFT");
        $this->db->join("units as units", "PC1.unit=units.units_id", "left");
        $this->db->join("seller_company_details as scd", "scd.user_id=P.seller", "left");
        $this->db->where_in('P.category', $category_id);
        // $this->db->where('P.category', $category_id);
        //Match start
        if (!empty($min_order)) {
            $this->db->where('PC2.quantity_from >=', $min_order);
        }

        if (!empty($min_price)) {
            $this->db->where('PC2.final_price >=', $min_price);
        }

        if (!empty($max_price)) {
            $this->db->where('PC2.final_price <=', $max_price);
        }
        
        if($sortby){
            $this->db->order_by('PC2.final_price', "DESC");
            $this->db->limit(12);
        }else{
            $this->db->order_by('PC2.final_price', "ASC");
            $this->db->limit(12);
        }
        
//        $this->db->order_by("P.discount_percentage", "desc");
        $query = $this->db->get();
//        echo $this->db->last_query();
        return $query->result_array();
    }

    // function created by shailesh to add the product review count and average review rating  in product
    // details api Date : 01-06-2019
    public function product_review_count($product_id) {
        $this->db->select('count(reviews_id),avg(reviews_rating)');
        $this->db->from('reviews');
        $this->db->where('products_id', $product_id);
        $query = $this->db->get()->row_array();

        $return_arr = array();
        $return_arr['review_count'] = $query['count(reviews_id)'];
        $return_arr['average_review_rating'] = $query['avg(reviews_rating)'];

        return $return_arr;
    }

    public function getProductsReviews($product_id) {
        $this->db->select('rd.review_text,r.reviews_rating,r.user_name');
        $this->db->from('reviews r');
        $this->db->join('reviews_description rd', 'r.reviews_id = rd.reviews_id', 'inner');
        $this->db->where('r.products_id', $product_id);
        return $query_result = $this->db->get()->result_array();
    }

    public function getProductSpecificationsConcatinated($product_id) {
        $this->db->select("GROUP_CONCAT(spec_value SEPARATOR ',') as specifications, name");
        $this->db->where(["product_id" => $product_id]);
        $this->db->join("category_specific_specifications css", "css.id = $this->_tableSpecs.spec_id");
        $this->db->group_by("$this->_tableSpecs.spec_id");
        $query = $this->db->get($this->_tableSpecs);
        return $query->result();
    }

    /**
     * Find Product Price According to Product Quantity
     * @param product id
     * @param Product quantity
     */
    public function getProductPriceByQuantity($product_id, $total_quantity) {
        // $query="select final_price from `product_price` where `quantity_from` <='".$total_quantity."' and `quantity_upto` >= '".$total_quantity."' && product_id='".$product_id."'";
        $this->db->select('final_price');
        $this->db->from('product_price');
        $this->db->where('quantity_from <=', $total_quantity);
        $this->db->where('quantity_upto >=', $total_quantity);
        $this->db->where('product_id', $product_id);
        $query = $this->db->get();
        return $query->row_array();
    }

    public function getProductByCatIds($cats = '', $limit = 30, $start_from = 0) {
        //$start_from = rand(0, 50);

        $select = "DISTINCT(P.id) as product_id,
        P.name,
        C.categories_name,
        PM.type as media_type,
        PM.url as media_url,
        PC1.atz_price as mrp,
        P.discount_percentage as discount,
        PC1.price as price1,
        PC2.price as price2,PC1.final_price as final_price1,
        PC2.final_price as final_price2,PC1.quantity_from as moq,PC1.unit as units_id,units.units_name,"
            .'offer_type,discount_value as offer_discount_value,oz.status as offer_status, valid_from, time_from, valid_to,'
            .'time_to ,oz.title,P.category, parent_id';


        $this->db->select($select);
        $this->db->from($this->_table . " P");
        $this->db->join($this->_tableCategory . " C", "P.category = C.categories_id");
        $this->db->join("categories cat", "cat.category_id = P.category", 'left');
        $this->db->join("offer_categories oc", "oc.category_id = cat.category_id ", 'left');
        $this->db->join("offer_zone oz", "oz.offer_id = oc.offer_id AND oz.status = 'active'", 'left');
        $this->db->join($this->_tableMedia . " PM", "PM.id = (SELECT id FROM $this->_tableMedia PM1 WHERE "
                . "PM1.product_id = P.id ORDER BY PM1.id ASC LIMIT 1)");
        $this->db->join($this->_tablePrice . " PC1", "PC1.id = (SELECT id FROM $this->_tablePrice PC3 WHERE "
                . "PC3.product_id = P.id ORDER BY PC3.id ASC LIMIT 1)");
        $this->db->join($this->_tablePrice . " PC2", "PC2.id = (SELECT id FROM $this->_tablePrice PC4 WHERE "
                . "PC4.product_id = P.id ORDER BY PC4.id DESC LIMIT 1)");
        $this->db->join('units as units', 'PC1.unit=units.units_id');
        $this->db->where("P.publish_status", "approved");
        if (!empty($cats)) {

            $this->db->where_in("P.category", $cats);
        }

        $this->db->limit($limit, $start_from);
        $query = $this->db->get($this->_table);
        $result = $query->result();
        return $result;
    }

    public function getProductByCatIds_remain($cats, $limit = 30, $start_from = 0) {
        //$start_from = rand(0, 50);

        $select = "DISTINCT(P.id) as product_id,
        P.name,
        C.categories_name,
        PM.type as media_type,
        PM.url as media_url,
        PC1.atz_price as mrp,
        P.discount_percentage as discount,
        PC1.price as price1,
        PC2.price as price2,PC1.final_price as final_price1,
        PC2.final_price as final_price2,PC1.quantity_from as moq,PC1.unit as units_id,units.units_name";


        $this->db->select($select);
        $this->db->from($this->_table . " P");
        $this->db->join($this->_tableCategory . " C", "P.category = C.categories_id");
        $this->db->join($this->_tableMedia . " PM", "PM.id = (SELECT id FROM $this->_tableMedia PM1 WHERE "
                . "PM1.product_id = P.id ORDER BY PM1.id ASC LIMIT 1)");
        $this->db->join($this->_tablePrice . " PC1", "PC1.id = (SELECT id FROM $this->_tablePrice PC3 WHERE "
                . "PC3.product_id = P.id ORDER BY PC3.id ASC LIMIT 1)");
        $this->db->join($this->_tablePrice . " PC2", "PC2.id = (SELECT id FROM $this->_tablePrice PC4 WHERE "
                . "PC4.product_id = P.id ORDER BY PC4.id DESC LIMIT 1)");
        $this->db->join('units as units', 'PC1.unit=units.units_id');
        $this->db->where("P.publish_status", "approved");
        if (!empty($cats)) {

            $this->db->where_not_in("P.category", $cats);
        }

        $this->db->limit($limit, $start_from);
        $query = $this->db->get($this->_table);
        $result = $query->result();
        return $result;
    }

    public function getProductByCatIds2($cats = '', $limit = 30, $start_from = 0) {
        //$start_from = rand(0, 50);

        $select = "DISTINCT(P.id) as product_id,
        P.name,
        C.categories_name,
        PM.type as media_type,
        PM.url as media_url,
        PC1.price as price1,
        PC2.price as price2,PC1.final_price as final_price1,
        P.discount_percentage as discount,PC2.atz_price as mrp,
        PC2.final_price as final_price2,PC1.quantity_from as moq,PC1.unit as units_id,units.units_name,
        oz.offer_id,offer_type,discount_value as offer_discount_value,oz.status as offer_status, valid_from, time_from, valid_to, time_to,
        oz.title";
        
        $this->db->select($select);
        $this->db->from($this->_table . " P");
        $this->db->join($this->_tableCategory . " C", "P.category = C.categories_id");
        $this->db->join("categories cat", "cat.category_id = P.category", 'left');
        $this->db->join("offer_categories oc", "oc.category_id = P.category", 'left');
        $this->db->join("offer_zone oz", "oz ON oz.offer_id = oc.offer_id AND oz.status = 'active'", 'left');
        $this->db->join($this->_tableMedia . " PM", "PM.id = (SELECT id FROM $this->_tableMedia PM1 WHERE "
                . "PM1.product_id = P.id ORDER BY PM1.id ASC LIMIT 1)");
        $this->db->join($this->_tablePrice . " PC1", "PC1.id = (SELECT id FROM $this->_tablePrice PC3 WHERE "
                . "PC3.product_id = P.id ORDER BY PC3.id ASC LIMIT 1)");
        $this->db->join($this->_tablePrice . " PC2", "PC2.id = (SELECT id FROM $this->_tablePrice PC4 WHERE "
                . "PC4.product_id = P.id ORDER BY PC4.id DESC LIMIT 1)");
        $this->db->join('units as units', 'PC1.unit=units.units_id');
        $this->db->where("P.publish_status", "approved");
        if (!empty($cats)) {

            $this->db->where_in("P.category", $cats);
        }

        $this->db->limit($limit, $start_from);
        $query = $this->db->get($this->_table);
        $result = $query->result_array();
        return $result;
    }

    public function getSerachProductByname($name, $start_from = 0, $limit = 30) {
        $this->db->limit($limit, $start_from);
        $this->db->select('P.id as product_id,P.seller as seller_id,users.user_package,company_types.name as seller_type,'
                . 'TIMESTAMPDIFF(YEAR, `seller_info.date_created`, CURDATE()) AS supplier_company_age,P.name as product_name,'
                . 'C.categories_name,PM.type as media_type, PM.url as media_url,PC1.price as price2,PC2.price as price1,'
                . 'PC1.final_price as final_price2,PC2.final_price as final_price1,PC1.quantity_upto as moq1, '
                . 'PC2.quantity_from as moq2,units.units_id as units_id,units.units_name as units_name,'
                . 'P.discount_percentage as discount, PC1.atz_price as mrp');
        $this->db->from("product_details P");
        $this->db->join("categories_description C", "P.category = C.categories_id");
        $this->db->join("product_media PM", "PM.id = (SELECT id FROM product_media PM1 WHERE "
                . "PM1.product_id = P.id ORDER BY PM1.id ASC LIMIT 1)");
        $this->db->join("product_price PC1", "PC1.id = (SELECT id FROM product_price PC3 WHERE "
                . "PC3.product_id = P.id ORDER BY PC3.id ASC LIMIT 1)");
        $this->db->join("product_price PC2", "PC2.id = (SELECT id FROM product_price PC4 WHERE "
                . "PC4.product_id = P.id ORDER BY PC4.id DESC LIMIT 1)");
        $this->db->join("users as users", "users.id=P.seller", "INNER");
        $this->db->join("seller_info as seller_info", "seller_info.user_id=P.seller", "LEFT");
        $this->db->join("company_types as company_types", "company_types.id=seller_info.company_type", "LEFT");
        $this->db->join("units as units", "PC1.unit=units.units_id", "left");
        $this->db->join("seller_company_details as scd", "scd.user_id=P.seller", "left");
        $this->db->like('P.name', $name);
        $this->db->where("P.publish_status", "approved");
        $this->db->order_by("P.discount_percentage", "desc");
        $query = $this->db->get();
        return $query->result_array();
    }

    public function getSerachProductBykeyword($keyword, $start_from = 0, $limit = 30) {
        //$this->output->enable_profiler(TRUE);
        $this->db->limit($limit, $start_from);
        $this->db->select($this->selectOffer."P.id as product_id,P.seller as seller_id,users.user_package,company_types.name as seller_type,"
                . "TIMESTAMPDIFF(YEAR, `seller_info.date_created`, CURDATE()) AS supplier_company_age,P.name as product_name,"
                . "C.categories_name,PM.type as media_type, PM.url as media_url,PC1.price as price2,PC2.price as price1,"
                . "PC1.final_price as final_price1,PC2.final_price as final_price2,PC1.quantity_upto as moq1, "
                . "PC2.quantity_from as moq2,units.units_id as units_id,units.units_name as units_name,"
                . "P.discount_percentage as discount, PC1.atz_price as mrp");
        $this->db->from("product_details P");
        $this->db->join("categories_description C", "P.category = C.categories_id");
        $this->offerJoins();
        $this->db->join("product_media PM", "PM.id = (SELECT id FROM product_media PM1 WHERE "
                . "PM1.product_id = P.id ORDER BY PM1.id ASC LIMIT 1)");
        $this->db->join("product_price PC1", "PC1.id = (SELECT id FROM product_price PC3 WHERE "
                . "PC3.product_id = P.id ORDER BY PC3.id ASC LIMIT 1)");
        $this->db->join("product_price PC2", "PC2.id = (SELECT id FROM product_price PC4 WHERE "
                . "PC4.product_id = P.id ORDER BY PC4.id DESC LIMIT 1)");
        $this->db->join("users as users", "users.id=P.seller", "INNER");
        $this->db->join("seller_info as seller_info", "seller_info.user_id=P.seller", "LEFT");
        $this->db->join("company_types as company_types", "company_types.id=seller_info.company_type", "LEFT");
        $this->db->join("units as units", "PC1.unit=units.units_id", "left");
        $this->db->join("seller_company_details as scd", "scd.user_id=P.seller", "left");

        $chunks = explode(" ", $keyword);
        
        $this->db->where("P.publish_status", "approved");
        
        $this->db->order_by("P.discount_percentage", "desc");
        $i = 1;
        //$this->db->like('P.name', $keyword);
        $this->db->group_start();
        foreach ($chunks as $chunk):
            
            $this->db->or_like('P.keywords', $chunk);
            
            $i++;
        endforeach;
        $this->db->group_end();
        
        $query = $this->db->get();
        return $query->result_array();
    }

    function insertAdminNotify($adminNotify) {
        return $this->db->insert('admin_notification', $adminNotify);
    }

    function insertBuyerNotify($adminNotify) {
        return $this->db->insert('buyer_notification', $adminNotify);
    }

    function insertSellerNotify($adminNotify) {
        return $this->db->insert('seller_notification', $adminNotify);
    }

    public function increament_sale_count($product_id) {
        $this->db->where('product_id', $product_id);
        $this->db->set('sales', 'sales+1', FALSE);
        $this->db->update('product_review');
    }

    public function getProductNameByid($product_id) {
        $this->db->where("id", $product_id);
        $this->db->select("id,name");
        $this->db->from("product_details");
        $query = $this->db->get();
        return $query->row_array();
    }

    public function getProductPriceForQuantity($product_id, $quantity) {
        $this->db->from(" product_details p");
        $this->db->join(" product_price pr", "p.id = pr.product_id");
        $this->db->where("$quantity BETWEEN pr.quantity_from AND pr.quantity_upto");
        $this->db->where(["product_id" => $product_id]);
        $query = $this->db->get();
        return $query->row();
    }

    /*     * *
     * @Author Shubham Patil 20072019
     * @param user_id
     * @return favorite product array
     * * */

    function userFavProd($user_id) {
        $this->db->select('products');
        $this->db->where('user_id', $user_id);
        return $this->db->get('buyer_favourites')->row();
    }

    public function getUnitNameByProductId($pid) {
        //make Payment button click on myorder mobile website Issue solve;
        $this->db->where(["product_id" => $pid]);
        $this->db->select("u.units_name");
        $this->db->from("product_price pp");
        $this->db->join("units u", "u.units_id=pp.unit");
        $query = $this->db->get();
        return $query->row();
    }

    /**
     * @auther Yogesh Pardeshi
     * @param product_id pk
     */
    public function readSingleProduct($productId) {
        $result_found = 0; //for adding count number of info found

        if ($productId != null && !empty($productId) && $productId != 0) {
            $product_deatils = $this->db->select('u.status as active_status,u.email, phone, u.id seller_id, CONCAT(first_name, " ", last_name) seller_name, pd.id, name, keywords, seller, categories_name,  description, discount_percentage,
                                           discount_percentage,hike_percentage,weight, width, height, length, provide_order_at_buyer_place, price_type,
                                           publish_status, active_status, DATE_FORMAT(created_at, "%a %d %M %Y %h:%i:%s %p ") created_date, DATE_FORMAT(modified_at, "%a %d %M %Y %h:%i:%s %p ") modified_date, is_product_returnable, product_return_days,
                                           available_quantity, DATE_FORMAT(requested_on, "%a %d %M %Y %h:%i:%s %p ") requested_date, DATE_FORMAT(approved_on, "%a %d %M %Y %h:%i:%s %p ") approved_date, admin_firstname')
                            ->from('product_details pd')
                            ->join('categories_description', 'categories_id = category', 'left')
                            ->join('admin', 'admin_id = approved_by', 'left')
                            ->join('users u', 'u.id = seller', 'left')
                            ->where('pd.id', $productId)
                            ->get()->result()[0];

            (count($product_deatils) > 0) ? $result_found ++ : 0;

            $product_price = $this->db->select("quantity_from, quantity_upto, unit, price, atz_price, final_price ")
                            ->from('product_price')->where('product_id', $productId)->get()->result();

            (count($product_deatils) > 0) ? $result_found ++ : 0;

            $product_media = $this->db->select('url, type, status, DATE_FORMAT(created_at, "%a %d %M %Y %h:%i:%s %p ") created_date, modified_at ')
                            ->from('product_media')->where('product_id', $productId)->get()->result();

            (count($product_deatils) > 0) ? $result_found ++ : 0;


            $product_specs = $this->db->select("css.name, spec_id, spec_value")
                            ->from('product_specifications ps')
                            ->join('category_specific_specifications css', 'css.id = spec_id', 'left')
                            ->where('product_id', $productId)
                            ->get()->result_array();

            //filter product specifications
            $product_specs = $this->filterSpecific($product_specs);

            (count($product_deatils) > 0) ? $result_found ++ : 0;

            if ($result_found > 0) {
                $data = array('product_details' => $product_deatils,
                    'product_price' => $product_price,
                    'product_media' => $product_media,
                    'product_specs' => $product_specs);

                return $data;
            } else {
                return null;
            }
        }
    }

    /**
     *  @param productId
     *  @return categoryId
     */
    public function getCategoryId($productId) {
        $categoryId = $this->db->select('category')
                        ->from('product_details')
                        ->where('id', $productId)->get()->result_array()[0]['category'];

        return $categoryId;
    }

    /**
     * @auther Yogesh Pardeshi 29072019
     * @param status as input and
     * @return respective fa-icon and status text
     */
    public function showStatusIcons($status) {
        switch (strtolower($status)) {
            case 'approved':
                return '<i class="fa fa-check-circle text-success"
                style="font-size: 18px;"></i></b>
                <i>' . strtoupper($status) . '</i>';

            case 'pending':
                return '<i class="fa fa-product-hunt text-secondary"
                style="font-size: 18px;"></i></b>
                <i>' . strtoupper($status) . '</i>';

            case 'rejected':
                return '<i class="fa fa-window-close text-danger"
                style="font-size: 18px;"></i></b>
                <i>' . strtoupper($status) . '</i>';

            default:
                return '<i class="fa fa-product-hunt text-secondary"
            style="font-size: 18px;"></i></b>
            <i>' . strtoupper($status) . '</i>';
        }
    }

    private function filterSpecific($arraySpecs) {
        $allSpecType = array();
        foreach ($arraySpecs as $specsDetails) {
            if (!array_key_exists($specsDetails['name'], $allSpecType)) {
                $allSpecType[$specsDetails['name']] = $specsDetails['spec_value'];
            } else {
                $allSpecType[$specsDetails['name']] = $allSpecType[$specsDetails['name']]
                        . ' , ' . $specsDetails['spec_value'];
            }
        }
        return $allSpecType;
    }

    /* author Ravindra
     * Get Specification Name By Specification Id.
     * @params specification id.
     * return Specification name
     */

    public function specName($spec_id) {
        $this->db->select('css.name name')->from('category_specific_specifications css');
        $this->db->where('css.id', $spec_id);
        return $this->db->get()->row_array();
    }


    /**
     * @auther Yogesh Pardeshi 23082019
     * @param $product_id = product_id of a product, $user_id = users pk
     * @return true if user is in table with NULL date_user_notified else false for no records
     * @use in api and home product
     **/
    public function checkUserInNotifyList($product_id, $user_id)
    {
        if(isset($product_id) && isset($user_id)) {
            $duplicate_notifier = $this->db->select('count(id) duplicate')->from('product_notify_list')
                                        ->where(array('product_id' => $product_id,
                                            'user_id' => $user_id))
                                        ->where('date_user_notified IS NULL')
                                        ->get()->result_array()[0]['duplicate'];
            if($duplicate_notifier > 0){
                return true;
            } else {
                return false;
            }
        } 
        return false;
    }


    /**
     * @auther Yogesh Pardeshi 23082019
     * @param $product_id = product_id of a product, $user_id = users pk
     * @return false if user is registered in a table with NULL notified timestamp
     * other wise will insert the data as new record and return true
     * @use in api and home product
     **/
    public function insertInNotifyList($product_id, $user_id)
    {
        if(isset($product_id) && isset($user_id)) {
            $checkDuplicate = $this->db->select('id')->from('product_notify_list')
                ->where(array('product_id' => $product_id, 'user_id' => $user_id))
                ->where('date_user_notified IS NULL')
                ->get()->result_array()[0];

            if ($checkDuplicate['id'] > 0) {
                return false;
            } else {
                $inserted = $this->db->insert('product_notify_list',
                                      array('product_id' => $product_id,
                                            'user_id' => $user_id));
                if($inserted > 0) {
                  return true;
                }
            }
        }
    }
    
    /**
     * @auther Yogesh Pardeshi 30082019
     * @used to call offer join on various products
     **/
    public function offerJoins() {
        $this->db->join("offer_categories oc","oc.category_id = P.category", 'left');
        $this->db->join("offer_zone oz", " oz.offer_id = oc.offer_id AND oz.status = 'active'", 'left');
    }
    
    /*
     * @return object of products
     */
    public function getAll()
    {
        $query = $this->db->get($this->_table);
        return $query->result();
    }
    
}
