<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Offer_model extends CI_Model {

    private $_table;
    private $_tableDescription;

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->model('Common_model');
        $this->_table = "offer_zone";
    }

    public function getAll() {
        $query = $this->db->get($this->_table);
        return $query->result();
    }

    public function getAllCategoriesWithOffer($offer_id) {
        return $this->db->select('GROUP_CONCAT(category_id)  categories_offered')
                        ->from('offer_categories')
                        ->where("offer_id = $offer_id")
                        ->get()->result_array()[0]['categories_offered'];
    }

    public function get_coupons() {

        $coupons = $this->Common_model->getAll("offer_zone")->result_array();
        return $coupons;
    }

    function alloffer_count() {
        $query = $this
                ->db
                ->get($this->_table);
        return $query->num_rows();
    }

    function alloffer($limit, $start, $col, $dir) {
        $this->db->select('a.*,c.categories_name');
        $this->db->from('offer_zone as a');
        //$this->db->join('categories_description as b', 'a.applicable_category_id=b.categories_id', 'left');
        $this->db->join('offer_categories oc', 'oc.offer_id=a.offer_id', 'left');
        $this->db->join('categories_description c', 'c.categories_id=oc.category_id', 'left');
        $this->db->limit($limit, $start);
        $this->db->order_by($col, $dir);

        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return null;
        }
    }

    function offer_search($limit, $start, $search, $col, $dir) {
        $this->db->select('a.*,c.categories_name');
        $this->db->from('offer_zone as a');
        $this->db->join('offer_categories oc', 'oc.offer_id=a.offer_id', 'left');
        $this->db->join('categories_description c', 'c.categories_id=oc.category_id', 'left');
        $this->db->like('a.offer_id', $search);
        $this->db->or_like('a.title', $search);
        $this->db->or_like('a.offer_type', $search);
        $this->db->or_like('a.status', $search);
        $this->db->or_like('c.categories_name', $search);
        $this->db->limit($limit, $start);
        $this->db->order_by($col, $dir);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return null;
        }
    }

    function offer_search_count($search) {
        $query = $this
                ->db
                ->like('offer_id', $search)
                ->or_like('title', $search)
                ->get($this->_table);

        return $query->num_rows();
    }

    public function getDistinctCategories() {
        $this->db->distinct();
        $this->db->select('a.category_id, b.categories_name', false);
        $this->db->from('categories as a');
        $this->db->join('categories_description as b', 'a.category_id=b.categories_id');
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }

    public function updateCategoryData($data) {

        //echo "<pre>";
        //print_r($data);exit;

        $this->db->set('parent_id', $data['parent_id']);
        $this->db->set('sort_order', $data['sort_order']);

        if (isset($data['categories_image']) && $data['categories_image'] != "") {
            $this->db->set('categories_image', $data['categories_image']);
        }

        $this->db->set('last_modified', date('Y-m-d H:i:s'));
        $this->db->where('category_id', $data['categories_id']);
        $this->db->update('categories');

        $this->db->set('categories_name', $data['categories_name']);
        $this->db->where('categories_id', $data['categories_id']);
        $this->db->update('categories_description');

        return TRUE;
    }

    public function deleteOfferData($coupon_id) {
        $this->db->where('offer_id', $coupon_id);
        $this->db->delete('offer_zone');
        return TRUE;
    }

    public function getOfferData($coupon_id) {
        $result = $this->Common_model->getAll("offer_zone")->row();
        return $result;
    }

    /**
     * @auther Yogesh Pardeshi 19082019
     * @param startDateTime, endDateTime, offerStatus datetime from table
     * Check whether the offer is running or not iff not then return false
     * to show default discount and price
     * */
    public function checkOfferValidity($startDateTime, $endDateTime, $offerStatus) {
        //check first iff offer is active first
        if (strtolower($offerStatus) == 'active') {
            //check wheather the offer has started
            $todaysDate = strtotime($this->getNowTimeStamp());
            $offerStartDate = strtotime($startDateTime);
            if ($todaysDate >= $offerStartDate) {
                $offerEndDate = strtotime($endDateTime);
                //check whether the offer has expired using time stamp
                if ($todaysDate <= $offerEndDate) {
                    return true;
                }
            }
        }
        return false; // return false if no offer is running
    }

    function getOfferDetailsForCatId($category_id) {
        $results = $this->db->select('offer_type,discount_value as offer_discount_value,oz.status, valid_from, time_from, valid_to,'
                                . 'time_to ,oz.title')
                        ->from('offer_zone oz')
                        ->join('offer_categories oc', 'oz.offer_id = oc.offer_id')
                        ->where('oc.category_id = ' . $category_id)
                        ->get()->result_array()[0];
        //echo $this->db->last_query();
        return $results;
    }

    /**
     * @auther Yogesh Pardeshi 21082019
     * @param $offerId pk of offer_zone
     * @return
     * @use on front product details page after offer ends
     * */
    public function updateOfferStatus($offerId) {
        $now = $this->getNowTimeStamp();
        $where = "offer_id = $offerId AND TIMESTAMP(valid_to, time_to) <= '$now'";
        if ($offerId != 0) {
            $this->db->update('offer_zone', array("status" => "Inactive"), $where);
            //echo $this->db->last_query();
        }
        if ($offerId == 0) {
            $this->db->update('offer_zone', array("status" => "Inactive"),
                    "TIMESTAMP(valid_to, time_to) <= '$now'");
            //echo $this->db->last_query();
        }
    }

    /**
     * @auther Yogesh Pardeshi 21082019
     * @param $offer_id offer pk
     * @return null if offer is available otherwise offer_id
     *         indicating expired offer
     * @use cart display in purchaseList route
     * */
    public function checkOfferExpiryForCartProducts($offer_id) {
        $now = $this->getNowTimeStamp();
        return $this->db->select('offer_id')
                        ->from('offer_zone')
                        ->where("offer_id = $offer_id")
                        ->where("TIMESTAMP(valid_to, time_to) <= '$now' AND status = 'Inactive'")
                        ->get()->result_array()[0];
    }

    /**
     * @auther Yogesh Pardeshi 22082019
     * @param $cartItemIdPk is a pk of cart item id from add_to_cart Table
     * @return num of records deleted
     * @use to delete only those item from cart which uses offer only if offer expires cart.php
     *  and other payment pages
     * */
    public function deleteExpiredOfferFromCart($cartItemIdPk) {
        return $this->db->delete('add_to_cart', array('id' => $cartItemIdPk));
    }

    /**
     * @auther Yogesh Pardeshi 22082019
     * @param $offer_id = a pk offer_zone
     * @return $title = offer title
     * @use to get the offer name using offer_id
     * */
    public function getOfferTitle($offer_id) {
        $title = $this->db->select('title')
                        ->from('offer_zone')->where('offer_id = ' . $offer_id)
                        ->get()->result_array()[0]['title'];
        return $title;
    }

    /**
     * @auther Yogesh Pardeshi 22082019
     * @param $order_id = pk of order_id
     * @return number of records deleted
     * @use to delete only those product item from orders_product which uses expired offer
     *  or if offer expires
     * */
    public function deleteExpiredOfferFromOrders($order_id) {
        $now = $this->getNowTimeStamp();
        //first select records from orders_product table which contains expired offers
        //then delete them from same table if deleted records are greater than 0 then
        //redirect to cart page else proceed to payment next step
        $results = $this->db->select('count(orders_id) expiredOrders')
                        ->from('orders_products op')
                        ->join('offer_zone oz', 'op.offer_id = oz.offer_id', 'left')
                        ->where("TIMESTAMP(oz.valid_to, oz.time_to) <= '$now' AND oz.status = 'Inactive'")
                        ->where('orders_id = ' . $order_id)
                        ->get()->result_array()[0]['expiredOrders'];

        $count = 0;
        if ($results > 0) {
            //Also delete all order if it contains expired offers
            $deletedOrders = $deleted = $this->db->delete('orders', "orders_id = $order_id");
            $deletedOrdersProducts = $this->db->delete('orders_products', "orders_id = $order_id");
            if ($deletedOrders == 1 || $deletedOrdersProducts == 1) {
                $count++;
            }
        }
        return $count;
    }

    /**
     * @author Ravindra Warthi 26/08/2019
     * @param offer_id
     * @return boolean indicating offer is active and has not been ended
     * */
    function getOfferDetailsForOfferId1($offer_id) {
        $results = $this->db->select('oc.offer_id,offer_type,discount_value as offer_discount_value,oz.status as offer_status, valid_from, time_from, valid_to,'
                                . 'time_to ,oz.title')
                        ->from('offer_zone oz')
                        ->join('offer_categories oc', 'oz.offer_id = oc.offer_id')
                        ->where('oz.offer_id = ' . $offer_id)
                        ->get()->result_array()[0];
        return $results;
    }

    /**
     * @auther Yogesh Pardeshi 22082019
     * @return $arrayOffers
     * @use in front index page for showing offer zone or deal of the Day
     * */
    public function getRunningOffers() {
        $now = $this->getNowTimeStamp();
        $arrayOffers = $this->db->select('oc.offer_id,categories_name, offer_type, discount_value,title, oz.offer_id, oc.category_id, oz.offer_image, 
                                          timestamp(oz.valid_to, oz.time_to) as offer_end_time')
                        ->from('offer_categories oc')
                        ->join('offer_zone oz', 'oz.offer_id = oc.offer_id')
                        ->join('categories_description cd', 'cd.categories_id = oc.category_id ')
                        ->where("oz.status = 'active' AND timestamp(oz.valid_from, oz.time_from)
                                    <= '$now' AND timestamp(oz.valid_to, oz.time_to) >= '$now'")
                        ->get()->result_array();
        return $arrayOffers;
    }

    /**
     * @auther Yogesh Pardeshi 26082019 2pm
     * @param $offer_id = offer id pk to get
     * @return $results array of offer details
     * @use start order for single product inside userorder/proceed_start_order function
     * */
    function getOfferDetailsForOfferId($offer_id) {
        $now = $this->getNowTimeStamp();
        $results = $this->db->select('offer_type,discount_value as offer_discount_value,oz.status, timestamp(oz.valid_from, oz.time_from) offer_start_time,'
                                . 'timestamp(oz.valid_to, oz.time_to) offer_end_time ,oz.title')
                        ->from('offer_zone oz')
                        ->where('oz.offer_id = ' . $offer_id)
                        ->where("oz.status = 'active' AND timestamp(oz.valid_from, oz.time_from) 
                     <= '$now' AND timestamp(oz.valid_to, oz.time_to) >= '$now'")
                        ->get()->result_array()[0];
        return $results;
    }

    /**
     * @auther Yogesh Pardeshi 26082019
     * @param $product_id = product id pk
     * @return $offer_price = for product
     * @use
     * */
    public function getProductOfferPrice($product_id, $total_qty) {
        $now = $this->getNowTimeStamp();
        return $this->db->select('atz_price, offer_type, discount_value, oz.offer_id')
                        ->from('product_price pp')
                        ->join('product_details pd', 'pp.product_id = pd.id', 'left')
                        ->join('categories c', 'c.category_id = pd.category', 'left')
                        ->join('offer_categories oc', "oc.category_id = pd.category AND oc.offer_id = (SELECT oz.offer_id FROM offer_zone oz WHERE oz.status = 'ACTIVE' AND oz.offer_id = oc.offer_id limit 1)", 'left')
                        ->join('offer_zone oz', "oz.offer_id = oc.offer_id AND TIMESTAMP(oz.valid_from, oz.time_from) <= '$now' AND
             TIMESTAMP(oz.valid_to, oz.time_to) >= '$now' AND oz.status = 'active'", 'left')
                        ->where("pd.id = $product_id")
                        ->where("$total_qty BETWEEN quantity_from  AND quantity_upto")
                        ->get()->result_array()[0];
    }

    /* @Author Ravindra 28/8/2019
     * @Params Passing Array in function to make Common Function
     * @return return Array Offer Product.
     * @use topselling List,recommends List function in Home View page.
     */

    public function appliedOfferProduct($arrayProduct) {
        //max_final_price;
        //min_final_price;
        /* Product Offer Start */
        for ($i = 0; $i < count($arrayProduct); $i++) {
            if (strtolower($arrayProduct[$i]['offer_status']) == 'active') {

                $offerRunningStatus = $this->Offer_model->checkOfferValidity(
                        $arrayProduct[$i]['valid_from'] . ' ' . $arrayProduct[$i]['time_from'],
                        $arrayProduct[$i]['valid_to'] . ' ' . $arrayProduct[$i]['time_to'],
                        $arrayProduct[$i]['offer_status']);

                if ($offerRunningStatus == true) {

                    if (strtolower($arrayProduct[$i]['offer_type']) == 'flat') {

                        $arrayProduct[$i]['discount'] = '<i class="fa fa-inr"></i> ' . $arrayProduct[$i]['offer_discount_value'] . ' OFF';
                        $arrayProduct[$i]['max_final_price'] = $arrayProduct[$i]['mrp'] - $arrayProduct[$i]['offer_discount_value'];
                        $arrayProduct[$i]['min_final_price'] = $arrayProduct[$i]['mrp'] - $arrayProduct[$i]['offer_discount_value'];
                    }
                    if (strtolower($arrayProduct[$i]['offer_type']) == 'percentage') {

                        $arrayProduct[$i]['discount'] = $arrayProduct[$i]['offer_discount_value'] . "% OFF";
                        $arrayProduct[$i]['max_final_price'] = $arrayProduct[$i]['mrp'] - ($arrayProduct[$i]['mrp'] * $arrayProduct[$i]['offer_discount_value'] * 0.01);
                        $arrayProduct[$i]['min_final_price'] = $arrayProduct[$i]['mrp'] - ($arrayProduct[$i]['mrp'] * $arrayProduct[$i]['offer_discount_value'] * 0.01);
                    }
                } else {
                    // this case very rare if offer status active but date and time expired.
                    $arrayProduct[$i]['discount'] = $arrayProduct[$i]['discount'] . "% OFF";
                }
            } else {

                $arrayProduct[$i]['discount'] = $arrayProduct[$i]['discount'] . "% OFF";
            }
        }

        return $arrayProduct;
        /* Product Offer Ends */
    }

    /* @Author Ravindra 28/8/2019
     * @Params Passing Array in function to make Common Function
     * @return return Array Offer Product.
     * Reason for creating same Function due to alias name given to final Price.
     * use for JustForYou in Home View Page.
     */

    public function appliedOfferProduct1($arrayProduct) {
        //final_price1
        //final_price2
        /* Product Offer Start */
        for ($i = 0; $i < count($arrayProduct); $i++) {

            if (strtolower($arrayProduct[$i]['offer_status']) == 'active') {

                $offerRunningStatus = $this->Offer_model->checkOfferValidity(
                        $arrayProduct[$i]['valid_from'] . ' ' . $arrayProduct[$i]['time_from'],
                        $arrayProduct[$i]['valid_to'] . ' ' . $arrayProduct[$i]['time_to'],
                        $arrayProduct[$i]['offer_status']);

                if ($offerRunningStatus == true) {

                    if (strtolower($arrayProduct[$i]['offer_type']) == 'flat') {

                        $arrayProduct[$i]['discount'] = '<i class="fa fa-inr"></i> ' . $arrayProduct[$i]['offer_discount_value'] . ' OFF';
                        $arrayProduct[$i]['final_price1'] = $arrayProduct[$i]['mrp'] - $arrayProduct[$i]['offer_discount_value'];
                        $arrayProduct[$i]['final_price2'] = $arrayProduct[$i]['mrp'] - $arrayProduct[$i]['offer_discount_value'];
                    }
                    if (strtolower($arrayProduct[$i]['offer_type']) == 'percentage') {
                        $arrayProduct[$i]['discount'] = $arrayProduct[$i]['offer_discount_value'] . "% OFF";
                        $arrayProduct[$i]['final_price1'] = $arrayProduct[$i]['mrp'] - ($arrayProduct[$i]['mrp'] * $arrayProduct[$i]['offer_discount_value'] * 0.01);
                        $arrayProduct[$i]['final_price2'] = $arrayProduct[$i]['mrp'] - ($arrayProduct[$i]['mrp'] * $arrayProduct[$i]['offer_discount_value'] * 0.01);
                    }
                } else {

                    // this case very rare if offer status active but date and time expired.
                    $arrayProduct[$i]['discount'] = $arrayProduct[$i]['discount'] . "% OFF";
                }
            } else {

                $arrayProduct[$i]['discount'] = $arrayProduct[$i]['discount'] . "% OFF";
            }
        }
        return $arrayProduct;
        /* Product Offer Ends */
    }

    public function appliedOfferProduct2($arrayProduct) {
        //final_price1
        //final_price2
        /* Product Offer Start */
        for ($i = 0; $i < count($arrayProduct); $i++) {

            if (strtolower($arrayProduct[$i]['offer_status']) == 'active') {

                $offerRunningStatus = $this->Offer_model->checkOfferValidity(
                        $arrayProduct[$i]['valid_from'] . ' ' . $arrayProduct[$i]['time_from'],
                        $arrayProduct[$i]['valid_to'] . ' ' . $arrayProduct[$i]['time_to'],
                        $arrayProduct[$i]['offer_status']);

                if ($offerRunningStatus == true) {

                    if (strtolower($arrayProduct[$i]['offer_type']) == 'flat') {

                        $arrayProduct[$i]['discount'] = '<i class="fa fa-inr"></i> ' . $arrayProduct[$i]['offer_discount_value'] . ' OFF';
                        $arrayProduct[$i]['final_price1'] = $arrayProduct[$i]['mrp'] - $arrayProduct[$i]['offer_discount_value'];
                        $arrayProduct[$i]['final_price2'] = $arrayProduct[$i]['mrp'] - $arrayProduct[$i]['offer_discount_value'];
                    }
                    if (strtolower($arrayProduct[$i]['offer_type']) == 'percentage') {
                        $arrayProduct[$i]['discount'] = $arrayProduct[$i]['offer_discount_value'] . "% OFF";
                        $arrayProduct[$i]['final_price1'] = $arrayProduct[$i]['mrp'] - ($arrayProduct[$i]['mrp'] * $arrayProduct[$i]['offer_discount_value'] * 0.01);
                        $arrayProduct[$i]['final_price2'] = $arrayProduct[$i]['mrp'] - ($arrayProduct[$i]['mrp'] * $arrayProduct[$i]['offer_discount_value'] * 0.01);
                    }
                } else {

                    // this case very rare if offer status active but date and time expired.
                    $arrayProduct[$i]['discount'] = $arrayProduct[$i]['discount'];
                }
            } else {

                $arrayProduct[$i]['discount'] = $arrayProduct[$i]['discount'];
            }
        }
        return $arrayProduct;
        /* Product Offer Ends */
    }

    /**
     * @auther Yogesh Pardeshi 29082019
     * @param array of offers with (6) parameters of assoc array
     * @return returns same assoc array with offerPrice for active offers
     * @use mostly in webapis and web for fav products
     * */
    public function calculateOfferPrice($arrayOffers) {
        if (strtolower($arrayOffers['offer_status']) == 'active') {
            $now = strtotime($this->getNowTimeStamp());
            $startTime = strtotime($arrayOffers['offer_start_time']);
            $endTime = strtotime($arrayOffers['offer_end_time']);
            //return $startTime. ' = '.$endTime.' = '. $now ;

            if ($startTime <= $now && $endTime >= $now) {
                if (strtolower($arrayOffers['offer_type']) == 'flat') {
                    $arrayOffers['offerPrice'] = $arrayOffers['offerPrice'] -
                            $arrayOffers['offer_discount_value'];
//                    $arrayOffers['offer_discount_value'] = " Flat <i class='fa fa-inr'></i> "
//                            .$arrayOffers['offer_discount_value'].' OFF';
                }

                if (strtolower($arrayOffers['offer_type']) == 'percentage') {
                    $basePrice = $arrayOffers['offerPrice'];
                    $arrayOffers['offerPrice'] = $basePrice -
                            ($basePrice * 0.01 * $arrayOffers['offer_discount_value']);
                    $arrayOffers['offerPrice'] = sprintf("%1.2f", $arrayOffers['offerPrice']);
//                    $arrayOffers['offer_discount_value'] = $arrayOffers['offer_discount_value']
//                            .' % OFF';
                }
                return $arrayOffers;
            } else {
                return false;
            }
            return false;
        }
    }

    /**
     * @auther Yogesh Pardeshi 30082019
     * @use welcome before showing offer zone
     * */
    public function updateStatusOnOfferExpire() {
        //set offers to inactive if offer end datetime is reached
        $now = $this->getNowTimeStamp();
        $this->db->set("status = inactive")
                ->where("timestamp(valid_to, time_to) <= '$now'")
                ->where("status = active")
                ->update("offer_zone");
    }

    /**
     * @auther Yogesh Pardeshi 03092019
     * @return Return current date timestamp
     * @use while handling offers in Indian time zone
     * */
    public function getNowTimeStamp() {
        date_default_timezone_set("Asia/Kolkata");
        return $now = date("Y-m-d H:i:s");
    }

    /**
     * @auther Yogesh Pardeshi 04092019
     * @param $offerType = offer_type from table offer_zone
     *        $discountVal = offer discount value
     * @return formatted string with discount text
     * @use inside controller and views
     * */
    public function offerDiscount($offerType, $discountVal) {
        switch (strtolower($offerType)) {
            case'flat' : {
                    return "<i class='fa fa-inr'></i> $discountVal Off";
                    break;
                }
            case'percentage' : {
                    return "$discountVal % Off";
                    break;
                }
            //no need of deafult
        }
    }
    
    /**
     * @auther Yogesh Pardeshi 04092019
     * @param $offerType = offer_type from table offer_zone
     *        $discountVal = offer discount value
     * @return formatted string with discount text
     * @use inside excel report
     * */
    public function offerDiscountExcel($offerType, $discountVal) {
        switch (strtolower($offerType)) {
            case'flat' : {
                    return "Rs. $discountVal Off";
                    break;
                }
            case'percentage' : {
                    return "$discountVal % Off";
                    break;
                }
            //no need of deafult
        }
    }

    public function offerTestPrices($arrayPreviewOffer) {
        if (strtolower($arrayPreviewOffer['offer_type']) == 'flat') {
            $offerPrice = $arrayPreviewOffer['offerPrice'] -
                    $arrayPreviewOffer['offer_discount'];
            return sprintf("%1.2f", $offerPrice);
        }
        if (strtolower($arrayPreviewOffer['offer_type']) == 'percentage') {
            $basePrice = $arrayPreviewOffer['offerPrice'];
            $offerPrice = $basePrice -
                    ($basePrice * 0.01 * $arrayPreviewOffer['offer_discount']);
            return sprintf("%1.2f", $offerPrice);
        }
    }

    /**
     * @auther Yogesh Pardeshi $date
     * @param 
     * @return 
     * @use
     * */
    public function productReport() {
        $offer_id = $this->input->post('offer_id');
        $productName = $this->input->post('productName');
        $category_id = $this->input->post('category');
        $hike = $this->input->post('atzHike');
        $discount = $this->input->post('atzDiscount');
        $seller_id = $this->input->post('sellerId');
        $limit_start = $this->input->post('limitStart');
        $limit_end = $this->input->post('limitEnd');

        $select = 'p.id, name, available_quantity, categories_name,
            price, hike_percentage, atz_price, discount_percentage, final_price,
            seller, requested_on,admin_firstname, approved_on';
        $select .= ',oz.title,discount_value,offer_type,timestamp(valid_from, time_from) offer_start_date,
                timestamp(valid_to, time_to) offer_end_date, oz.status as offer_status ';

        $this->db->select($select)
                ->from('product_details p')
                ->join('categories_description cd', 'cd.categories_id = p.category', 'left')
                ->join('offer_categories oc', 'oc.category_id = p.category AND '
                        . " oc.offer_id = (SELECT oz.offer_id FROM offer_zone oz WHERE oz.status = 'ACTIVE' "
                        . " AND oz.offer_id = oc.offer_id limit 1)", 'left')
                ->join('offer_zone oz', "oz.offer_id = oc.offer_id ", 'left')
                ->join('product_price pp', 'pp.product_id = (SELECT product_id FROM product_price PC3 WHERE PC3.product_id = p.id ORDER BY PC3.id ASC LIMIT 1)', 'left')
                ->join('admin ad', 'admin_id = approved_by', 'left');

        if (!empty($offer_id)) {
            $this->db->where('oz.offer_id', $offer_id);
        }

        if (!empty($category_id)) {
            $this->db->where('p.category', $category_id);
        }

        if (!empty($hike)) {
            $this->db->where('p.hike_percentage', $hike);
        }

        if (!empty($discount)) {
            $this->db->where('p.discount_percentage', $discount);
        }

        if (!empty($seller_id)) {
            $this->db->where('p.seller', $seller_id);
        }

        if ($limit_start != '' && $limit_end != '' && isset($limit_start) && isset($limit_end)) {
            $this->db->limit($limit_start, $limit_end);
        }
        
        if($productName != ''){
            $this->db->like('p.name',$productName);
        }

        $this->db->order_by('p.id', 'desc');

        $productData = $this->db->get()->result_array();
        $excelData = array();
        $i = 0;

        foreach ($productData as $product) {
            $excelData[$i]['id'] = 'PRD' . $product['id'];
            $excelData[$i]['seller'] = 'ATZ' . $product['seller'];
            $excelData[$i]['name'] = $product['name'];
            $excelData[$i]['qty'] = $product['available_quantity'];
            $excelData[$i]['category'] = $product['categories_name'];
            $excelData[$i]['price'] = $product['price'];
            $excelData[$i]['hike'] = $product['hike_percentage'] . ' %';
            $excelData[$i]['atz_price'] = $product['atz_price'];
            $excelData[$i]['discount'] = $product['discount_percentage'] . ' %';
            $excelData[$i]['mrp'] = $product['final_price'];

            if ($product['offer_status'] == 'Active') {
                $offerDetails['offer_status'] = $product['offer_status'];
                $offerDetails['offer_start_time'] = $product['offer_start_date'];
                $offerDetails['offer_end_time'] = $product['offer_end_date'];
                $offerDetails['offer_type'] = $product['offer_type'];
                $offerDetails['offerPrice'] = $product['atz_price'];
                $offerDetails['offer_discount_value'] = $product['discount_value'];

                $offerPrices = $this->calculateOfferPrice($offerDetails);

                $excelData[$i]['offer_title'] = $product['title'];
                $excelData[$i]['offer_discount'] = $this->offerDiscountExcel($product['offer_type'], $offerPrices['offer_discount_value']);
                $excelData[$i]['offerPrice'] = $offerPrices['offerPrice'];
                $excelData[$i]['offer_start_date'] = $offerPrices['offer_start_time'];
                $excelData[$i]['offer_end_date'] = $offerPrices['offer_end_time'];
                //$excelData[$i]['offer_type'] = $offerPrices['offer_type'];
            } else {
                $excelData[$i]['offer_title'] = $product['title'];
                $excelData[$i]['offer_discount'] = $product['discount_value'];
                $excelData[$i]['offerPrice'] = $product['offerPrice'];
                $excelData[$i]['offer_start_date'] = $product['offer_start_time'];
                $excelData[$i]['offer_end_date'] = $product['offer_end_time'];

                $excelData[$i]['requested_on'] = $product['requested_on'];
                $excelData[$i]['approved_on'] = $product['approved_on'];
                $excelData[$i]['approved_by_admin'] = $product['admin_firstname'];
            }
            $i++;
        }
        return $excelData;
    }

}
