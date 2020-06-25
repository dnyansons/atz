<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Order_model extends CI_Model {

    private $_table, $_tableProducts, $_tableOrderStatus, $_tableCountry, $_tableProductsDetails, $_tableHistory, $_companyDetails, $_productMedia;
    private $_select, $_column_order, $_column_search, $_order;

    public function __construct() {
        parent::__construct();
        $this->load->model('Common_model');
        $this->_table = "orders";
        $this->_returnOrders = "return_orders";
        $this->_companyDetails = "seller_company_details";
        $this->_tableProducts = "orders_products";
        $this->_tableReturnProducts = "return_orders_products";
        $this->_orderStatus = "orders_status";
        $this->_tableOrderStatus = "orders_status";
        $this->_tableCountry = "country";
        $this->_tableProductsDetails = "product_details";
        $this->_tableHistory = "orders_history";
        $this->_productMedia = "product_media";
        $this->_productDetails = "product_details";
        $this->_select = "$this->_table.orders_id,awb_number,order_token_number,user_id,orders_status,user_name,delivery_name,delivery_street_address,delivery_suburb,delivery_city,delivery_postcode,"
                . "delivery_state,date_purchased,shipping_cost,order_price,vendor_payable_price,commission,gst,orders_status_name,delivery_date";
        $this->_column_order = array("$this->_table.orders_id", "user_name", "products_name", "orders_status_name", "final_price", "date_purchased");
        $this->_column_search = array("$this->_table.orders_id", "user_name", "products_name", "orders_status_name", "final_price", "date_purchased");
        $this->_order = array("$this->_table.orders_id" => "desc");
        $this->load->model('Common_model');
    }

    /*
     * @param - $data array of order attributes
     * @return - $order_id int
     *
     */

    public function addOrder($data) {
        $this->db->insert($this->_table, $data);
        return $this->db->insert_id();
    }

    function get_selleraddress($seller_id) {
        $this->db->select('*');
        $this->db->from('seller_pick_address a');
        $this->db->join('country b', 'b.pick_country=a.country', 'LEFT');
        $this->db->where('user_id', $seller_id);
        return $this->db->get();
    }

    /*
     * @param - $data array of order product details like product id, order id, price
     * @return - $order_product_id int
     *
     */

    public function addOrderProduct($data) {
        $this->db->insert($this->_tableProducts, $data);
        return $this->db->insert_id();
    }

    public function getOrderStatusList() {
        $query = $this->db->get($this->_tableOrderStatus);
        return $query->result();
    }

    public function getOrderDetailsById($order_id) {
        $this->db->select("P.width,P.height,P.length,P.weight,O.order_price,O.order_tracking_status,O.orders_status,O.orders_id,O.user_id,O.user_name,O.user_street_address,O.shipping_start_date,O.pick_days,O.user_city,O.user_postcode,O.user_state,O.user_telephone,O.user_email_address,O.delivery_name,O.delivery_street_address,O.delivery_city,O.delivery_postcode,O.delivery_state,O.date_purchased,O.pick_name,O.pick_addr_type,O.pick_state,O.pick_mobile,O.pick_email,O.pick_pincode,O.shipping_cost,O.currency,O.payment_method,OS.orders_status_name,OP.products_name,OP.products_price,OP.products_tax,OP.final_price,OP.products_quantity,C1.name payment_country,C2.name delivery_country");
        $this->db->from($this->_table . " O");
        $this->db->where("O.orders_id = " . $order_id);
        $this->db->join($this->_tableProducts . " OP", "OP.orders_id = O.orders_id", "LEFT");
        $this->db->join($this->_tableOrderStatus . " OS", "OS.orders_status_id = O.orders_status", "LEFT");
        $this->db->join($this->_tableCountry . " C1", "C1.id = O.user_country", "LEFT");
        $this->db->join($this->_tableCountry . " C2", "C2.id = O.delivery_country", "LEFT");
        $this->db->join($this->_tableProductsDetails . " P", "P.id = OP.products_id", "LEFT");
        $query = $this->db->get();
        return $query->row();
    }

    public function getOrderHistory($order_id) {
        $this->db->select("OH.*, OS.orders_status_name");
        $this->db->join($this->_tableOrderStatus . " OS", "OS.orders_status_id = OH.status", 'left');
        $query = $this->db->get_where($this->_tableHistory . " OH", array("orders_id" => $order_id));
        return $query->result();
    }

    public function addOrderHistory($data) {
        $this->db->insert($this->_tableHistory, $data);
        return $this->db->insert_id();
    }

    public function getSellerOrderCount($seller) {
        $this->db->from($this->_tableProducts . " OP ");
        $this->db->join($this->_tableProductsDetails . " PD ", "PD.id = OP.products_id");
        $this->db->where(array("PD.seller" => $seller));
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function getSellerCustomerCount($seller) {
        $this->db->from($this->_table . " O ");
        $this->db->join($this->_tableProducts . " OP ", "O.orders_id = OP.orders_id");
        $this->db->join($this->_tableProductsDetails . " PD ", "PD.id = OP.products_id");
        $this->db->where(array("PD.seller" => $seller));
        $this->db->group_by("O.user_id");
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function getSellerOrderTotal($seller) {
        $this->db->select("SUM(OP.final_price) as total");
        $this->db->from($this->_tableProducts . " OP ");
        $this->db->join($this->_tableProductsDetails . " PD ", "PD.id = OP.products_id");
        $this->db->where(array("PD.seller" => $seller));
        $query = $this->db->get();
        $result = $query->row();
        return $result->total;
    }

    public function getSellerOrders($seller, $limit = 0) {
        $this->db->from($this->_table . " O ");
        $this->db->join($this->_tableProducts . " OP ", "O.orders_id = OP.orders_id");
        $this->db->join($this->_tableProductsDetails . " PD ", "PD.id = OP.products_id");
        $this->db->join($this->_tableOrderStatus . " OS ", 'O.orders_status=OS.orders_status_id');
        $this->db->where(array("PD.seller" => $seller));
        $this->db->order_by("O.orders_id", "DESC");
        if ($limit != 0) {
            $this->db->limit($limit);
        }
        $query = $this->db->get();
        return $query->result();
    }

    public function updateOrder($id, $data) {
        $this->db->where(["orders_id" => $id]);
        $this->db->update($this->_table, $data);
        return $this->db->affected_rows();
    }

    /*
     * Following functions are added to use with server side datatables
     */

    function allorder_count() {
        $query = $this
                ->db
                ->get($this->_table);

        return $query->num_rows();
    }

    function allorder($limit, $start, $col, $dir) {
        $this->db->distinct('a.orders_id');
        $this->db->select('a.awb_number,a.orders_status,a.orders_id,a.user_name,c.orders_status_name,a.date_purchased,a.order_price');
        $this->db->from('product_details d');
        $this->db->join('orders_products b', 'b.products_id = d.id', 'left');
        $this->db->join('orders a', 'a.orders_id = b.orders_id', 'left');
        $this->db->join('orders_status c', 'a.orders_status = c.orders_status_id');
        $this->db->limit($limit, $start);
        $this->db->order_by('a.' . $col, $dir);
        $this->db->group_by('a.orders_id');
        $query = $this->db->get();


        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return null;
        }
    }

    function order_search_count($search) {
        $this->db->select('*');
        $this->db->from('orders a');
        $this->db->join('orders_products b', 'a.orders_id = b.orders_id');
        $this->db->join('product_details d', 'b.products_id = d.id');
        $this->db->join('orders_status c', 'a.orders_status = c.orders_status_id');
        $this->db->where("(`orders_status` LIKE '%" . $search . "%' ESCAPE '!' OR `user_name` LIKE '%" . $search . "%' ESCAPE '!')");
        $this->db->limit($limit, $start);
        $this->db->order_by('a.' . $col, $dir);
        $query = $this->db->get();

        return $query->num_rows();
    }

    /*     * ****** Following functions are used with server side data table custom filters ****************** */

    public function get_datatables($from_date, $status_id, $total, $order_id, $supplier_id = 0, $to_date) {
        $this->_get_datatables_query($from_date, $status_id, $total, $order_id, $supplier_id, $to_date);
        //echo $supplier_id;
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
//        echo $this->db->last_query();
        return $query->result();
    }

    public function count_filtered($from_date, $status_id, $total, $order_id, $supplier_id = 0, $to_date) {
        $this->_get_datatables_query($from_date, $status_id, $total, $order_id, $supplier_id, $to_date);

        $query = $this->db->get();

        return $query->num_rows();
    }

    public function count_all() {
        $this->db->from($this->_table);
        return $this->db->count_all_results();
    }

    private function _get_datatables_query($from_date, $status_id, $total, $order_id, $supplier_id = 0, $to_date) {
        //echo $supplier_id." is";
        $this->db
                ->select($this->_select)
                ->from($this->_table)
                ->join($this->_tableProducts, $this->_tableProducts . ".orders_id = " . $this->_table . ".orders_id")
                ->join($this->_tableOrderStatus, $this->_tableOrderStatus . ".orders_status_id = " . $this->_table . ".orders_status");
    
        if ($from_date != '' && $to_date != "") {
            $this->db->where("DATE(date_purchased) >= ", $from_date);
            $this->db->where("DATE(date_purchased) <= ", $to_date);
        }
        if ($order_id != '') {

            $this->db->where("$this->_table.orders_id = " . $order_id);
        }
        if ($status_id != '') {

            $this->db->where("orders_status", $status_id);
        }
        if ($total != '') {

            $this->db->where("final_price = " . $total);
        }
        if ($supplier_id) {
            $this->db->where("seller_id = " . $supplier_id);
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

    function all_order_count() {
        $this->db->select('*');
        $this->db->from('orders a');
        $this->db->join('orders_products b', 'a.orders_id = b.orders_id');
        $this->db->join('product_details d', 'b.products_id = d.id');
        $this->db->join('orders_status c', 'a.orders_status = c.orders_status_id');
        $query = $this->db->get();
        return $query->num_rows();
    }

    function order_search($limit, $start, $search, $col, $dir) {

        $this->db->select('*');
        $this->db->from('orders a');
        $this->db->join('orders_products b', 'a.orders_id = b.orders_id');
        $this->db->join('product_details d', 'b.products_id = d.id');
        $this->db->join('orders_status c', 'a.orders_status = c.orders_status_id');
        $this->db->where("(`orders_status` LIKE '%" . $search . "%' ESCAPE '!' OR `user_name` LIKE '%" . $search . "%' ESCAPE '!')");
        $this->db->limit($limit, $start);
        $this->db->order_by('a.' . $col, $dir);
        $query = $this->db->get();


        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return null;
        }
    }

    function getOrderDetails($order_id) {
        $this->db->select('*');
        $this->db->from('orders a');
        $this->db->join('orders_products b', 'a.orders_id = b.orders_id');
        $this->db->join('orders_status c', 'a.orders_status = c.orders_status_id');
        // $this->db->join('order_payment p', 'p.orders_id = a.orders_id');
        $this->db->where('a.orders_id', $order_id);
        $query = $this->db->get();
        return $query->result();
    }

    function getPaymentDetail($order_id) {
        $this->db->select('*');
        $this->db->from('orders a');
        $this->db->join('order_payment p', 'p.orders_id = a.orders_id');
        $this->db->where('a.orders_id', $order_id);
        $query = $this->db->get();
        return $query->result();
    }

    //////SelleR ALL ORDER//////////////////

    function seller_all_order_count($user_id) {

        $this->db->select('*');
        $this->db->from('orders a');
        $this->db->join('orders_status c', 'a.orders_status = c.orders_status_id');
        $this->db->where('a.seller_id', $user_id);
        $this->db->where('a.orders_status !=',8);
        $query = $this->db->get();
        return $query->num_rows();
    }

    function seller_allorder($user_id, $limit, $start, $dir) {

        $this->db->distinct('a.orders_id');
        $this->db->select('a.orders_status,a.orders_id,a.user_name,c.orders_status_name,a.date_purchased,a.order_price');
        $this->db->from('orders a');
        $this->db->join('orders_status c', 'a.orders_status = c.orders_status_id');
        $this->db->where('a.seller_id', $user_id);
        $this->db->where('a.orders_status !=',8);
        $this->db->limit($limit, $start);
        $this->db->order_by('a.orders_id', $dir);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return null;
        }
    }

    function seller_order_search($user_id, $limit, $start, $search, $dir) {

        $this->db->select('*');
        $this->db->from('orders a');
        $this->db->join('orders_status c', 'a.orders_status = c.orders_status_id');
        $this->db->where('a.seller_id', $user_id);
        $this->db->where('a.orders_status !=',8);
        $this->db->where("(`orders_status` LIKE '%" . $search . "%' ESCAPE '!' OR `user_name` LIKE '%" . $search . "%' ESCAPE '!')");
        $this->db->limit($limit, $start);
        $this->db->order_by('a.orders_id', $dir);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return null;
        }
    }

    function seller_order_search_count($user_id,$limit, $start, $search,$dir) {

        $this->db->select('*');
        $this->db->from('orders a');
        $this->db->join('orders_status c', 'a.orders_status = c.orders_status_id');
         $this->db->where('a.seller_id', $user_id);
         $this->db->where('a.orders_status !=',8);
        $this->db->where("(`orders_status` LIKE '%" . $search . "%' ESCAPE '!' OR `user_name` LIKE '%" . $search . "%' ESCAPE '!')");
        $this->db->limit($limit, $start);
        $this->db->order_by('a.orders_id', $dir);
        $query = $this->db->get();
        return $query->num_rows();
    }

    /*
     * Start Order Start
     */

    function get_product_detail($pro_id) {
        $this->db->select('P.id as product_id,P.seller as seller_id,company_types.name as seller_type,TIMESTAMPDIFF(YEAR, `seller_info.date_created`, CURDATE()) AS supplier_company_age,P.name as product_name,C.categories_name,PM.type as media_type, PM.url as media_url,PC1.price as price1,PC2.price as price2, PC1.quantity_from as moq1, PC2.quantity_from as moq2,CONCAT(users.first_name, " ",users.last_name) AS seller_name,users.phone as seller_phone,seller_info.company_name,seller_info.address1');
        $this->db->from("product_details P");
        $this->db->join("categories_description C", "P.category = C.categories_id", 'left');
        $this->db->join("product_media PM", "PM.id = (SELECT id FROM product_media PM1 WHERE "
                . "PM1.product_id = P.id ORDER BY PM1.id ASC LIMIT 1)", 'left');
        $this->db->join("product_price PC1", "PC1.id = (SELECT id FROM product_price PC3 WHERE "
                . "PC3.product_id = P.id ORDER BY PC3.id ASC LIMIT 1)", 'left');
        $this->db->join("product_price PC2", "PC2.id = (SELECT id FROM product_price PC4 WHERE "
                . "PC4.product_id = P.id ORDER BY PC4.id DESC LIMIT 1)", 'left');
        $this->db->join("users as users", "users.id=P.seller", "left");
        $this->db->join("seller_info as seller_info", "seller_info.user_id=P.seller", "left");
        $this->db->join("company_types as company_types", "company_types.id=seller_info.company_type", "left");

        $this->db->where('P.id', $pro_id);
        return $this->db->get();
    }

    function get_unit_price($pro_id) {
        $this->db->select('a.quantity_from, a.quantity_upto, a.unit as units_id, b.units_name, a.price');
        $this->db->from('product_price as a');
        $this->db->join('units as b', 'a.unit=b.units_id');
        $this->db->where('product_id', $pro_id);
        return $query = $this->db->get();
    }

    function pass_amt_per_qty($pro_id) {
        $this->db->select('quantity_from,price');
        $this->db->from('product_price');
        $this->db->where('product_id', $pro_id);
        $this->db->order_by('quantity_from', 'asc');
        $this->db->limit(1);
        return $query = $this->db->get()->row_array();
    }

    function get_min_qty($pro_id) {
        $this->db->select('quantity_from,price');
        $this->db->from('product_price');
        $this->db->where('product_id', $pro_id);
        $this->db->order_by('quantity_from', 'asc');
        $this->db->limit(1);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row_array();
        } else {
            return 0;
        }
    }

    function get_price($pro_id, $qty) {

        $this->db->select('quantity_from,price');
        $this->db->from('product_price');
        $this->db->where('product_id', $pro_id);
        //$this->db->where('quantity_from >='.$qty.' AND quantity_upto <='.$qty.'');
        $this->db->where("$qty BETWEEN quantity_from AND quantity_upto");
        $this->db->limit(1);
        return $query = $this->db->get()->row_array();
    }

    public function count_of_orders($status = 8) {
        $query = $this->db->get_where($this->_table, ["orders_status" => $status]);
        return $query->num_rows();
    }

    public function getBuyersOrders($id) {
        $select = "O.shippment_type,(O.order_price) as grand_price, "
                . "O.date_purchased as created_on, "
                . "O.orders_id, "
                . "OS.orders_status_name as order_status, "
                . "PD.name as product_name,PD.id as product_id, "
                . "OP.products_price as unit_price, "
                . "OP.products_quantity as products_quantity, "
                . "SCD.company_name, "
                . "PM.url as product_image, units.units_id, units.units_name,PC1.quantity_from as moq, country.iso as country_iso,country.currency as country_currency,"
                .'OP.offer_id, timestamp(valid_from, time_from) offer_start_time, '
                . 'timestamp(valid_to, time_to) offer_end_time ,oz.status as offer_status';

        $this->db->select($select);
        $this->db->from("$this->_table O");
        $this->db->join("$this->_tableProducts OP", "O.orders_id = OP.orders_id", "LEFT");
        $this->db->join("$this->_tableProductsDetails PD", "PD.id = OP.products_id", "LEFT");
        $this->db->join("offer_zone oz", " oz.offer_id = OP.offer_id", 'left');
        $this->db->join("$this->_companyDetails SCD", "SCD.user_id = PD.seller", "LEFT");
        $this->db->join("$this->_tableOrderStatus OS", "OS.orders_status_id = O.orders_status", "LEFT");
        $this->db->join("$this->_productMedia PM", 'ON PM.id = (select id from product_media PM1 where PM1.product_id = PD.id and PM1.type ="photo" ORDER BY id ASC LIMIT 1 )', "LEFT");
        $this->db->join("product_price PC1", "PC1.id = (SELECT id FROM product_price PC3 WHERE "
                . "PC3.product_id = PD.id ORDER BY PC3.id ASC LIMIT 1)", "LEFT");
        $this->db->join("units as units", "PC1.unit=units.units_id", "LEFT");
        $this->db->join("country as country", "O.delivery_country=country.id", "LEFT");
        $this->db->where(["O.user_id" => $id]);
        $this->db->order_by("O.orders_id", "DESC");
        
        $query = $this->db->get();
        $result = $query->result();

        //print_r($result);exit;


        for ($i = 0; $i < count($result); $i++) {
            $order_id = $result[$i]->orders_id;

            $this->db->select('orders_id');
            $this->db->from('orders_products');
            $this->db->where('orders_id', $order_id);
            $this->db->where('coupon_id >', 0);
            $q = $this->db->get()->num_rows();
            if ($q == 0) {
                $coupon = false;
            } else {
                $coupon = true;
            }

            $result[$i]->coupon_apply = $coupon;
            //$result[$i]->delivery_addr = $this->Common_model->getAll('orders', array('orders_id' => $order_id))->result_array();
        }

        return $result;
        //echo $this->db->last_query();
    }

    public function getOrderProducts($order_id) {

        $this->db->select("pd.id,pd.available_quantity, low_stock_qty,pd.weight,OP.products_name, OP.products_price as unit_price, OP.products_quantity, OP.final_price as grand_price, OP.product_specifications");
        $this->db->from("$this->_tableProducts OP");
        $this->db->join('product_details pd', 'pd.id=OP.products_id', 'left');
        $this->db->where(["orders_id" => $order_id]);
        $query = $this->db->get();
        return $query->result();
    }

    public function getReturnOrderProducts($order_id) {

        $this->db->select("pd.weight,OP.products_name, OP.products_price as unit_price, OP.products_quantity, OP.final_price as grand_price, OP.product_specifications");
        $this->db->from("$this->_tableReturnProducts OP");
        $this->db->join('product_details pd', 'pd.id=OP.products_id', 'left');
        $this->db->where(["return_orders_id" => $order_id]);

        $query = $this->db->get();
        return $query->result();
    }

    function get_ship_address($ship_id) {
        $this->db->select('*,b.id as country_id');
        $this->db->from('address_book a');
        $this->db->join('country b', 'a.country = b.id', 'left');
        $this->db->where('a.address_book_id', $ship_id);
        $query = $this->db->get();
        return $query->row_array();
    }

    function check_accepted_order($order_id) {
        $this->db->select('*,d.name as country_name');
        $this->db->from('orders a');
        $this->db->join('orders_products b', 'a.orders_id = b.orders_id');
        $this->db->join('orders_status c', 'a.orders_status = c.orders_status_id');
        $this->db->join('country d', 'a.delivery_country = d.id', 'left');
        $this->db->where('a.orders_id', $order_id);
         $query = $this->db->get();
         return $query->row_array();
    }

    function check_accepted_order_payment($order_id, $order_status) {

        $this->db->select('*');
        $this->db->from('orders a');
        $this->db->join('order_payment d', 'a.orders_id = d.orders_id');
        $this->db->where(["a.orders_id" => $order_id, 'd.status' => trim($order_status)]);
        // echo $this->db->last_query();exit; 
        return $query = $this->db->get();
    }

    function getBuyersOrderbyOrderID($id) {
        $select = "O.shippment_type,O.orders_id,(O.order_price) as grand_price,O.user_telephone,O.wallet_option,O.seller_id,O.pick_mobile,"
                . "O.date_purchased as created_on,O.shipping_expected_date,"
                . "OS.orders_status_name as order_status, "
                . "PD.name as product_name, "
                . "(OP.products_quantity * OP.products_price) as unit_price, "
                . "SCD.company_name, "
                . "PM.url as product_image ";

        $this->db->select($select);
        $this->db->from("$this->_table O");
        $this->db->join("$this->_tableProducts OP", "O.orders_id = OP.orders_id", 'left');
        $this->db->join("$this->_tableProductsDetails PD", "PD.id = OP.products_id", 'left');
        $this->db->join("$this->_companyDetails SCD", "SCD.user_id = PD.seller", 'left');
        $this->db->join("$this->_orderStatus OS", "OS.orders_status_id = O.orders_status", 'left');
        $this->db->join("$this->_productMedia PM", 'ON PM.id = (select id from product_media PM1 where PM1.product_id = PD.id and PM1.type ="photo" ORDER BY id ASC LIMIT 1 )');

        $this->db->where(["O.orders_id" => $id]);
        $query = $this->db->get();
        return $query->row_array();
    }

    function order_details($user_id) {
        $this->db->select('count(orders_id) as orders_status');
        $this->db->from("orders");
        $this->db->where("user_id", $user_id);
        $this->db->where("viewed_by_user", 0);
        return $this->db->get()->row();
    }

    function pending_order_count($user_id) {
        $this->db->select('count(orders_status) as pending_order_count');
        $this->db->from("orders");
        $this->db->where("user_id", $user_id);
        $this->db->where("orders_status", 16);
        return $this->db->get()->row();
    }

    function pending_confirmation_count($user_id) {
        $this->db->select('count(orders_status) as pending_confirmation_count');
        $this->db->from("orders");
        $this->db->where("user_id", $user_id);
        $this->db->where("orders_status", 8);
        return $this->db->get()->row();
    }

    public function getCancellationReasons($res_type) {
        $this->db->select('reason_id,reason_name');
        $this->db->from('refund_reason');
        $this->db->where('reason_type', $res_type);
        return $this->db->get()->result();
        /* $query = $this->db->get("ord_cancel_reason_master");
          return $query->result(); */
    }

    public function addCancelReason($data) {
        $this->db->insert("ord_cancel_reason_master", $data);
        return $this->db->insert_id();
    }

    public function deleteReason($id) {
        $this->db->where('id', $id);
        $this->db->delete('ord_cancel_reason_master');
    }

    public function updateOrderPrice($id, $sprice, $shipping_start_date, $shipping_expected_date) {
        //Order price in ORDER table is total of all product quantity including
        $this->db->where('orders_id', $id);
        $this->db->set('shipping_start_date', $shipping_start_date);
        $this->db->set('delivery_date', $shipping_expected_date);
        $this->db->set('order_price', 'order_price+' . $sprice, FALSE);
        $this->db->set('shipping_cost', $sprice);
        $this->db->set('orders_status', 16);
        $this->db->update('orders');
    }

    public function checkValidUserOrder($user, $order) {
        $this->db->where(["user_id" => $user, "orders_id" => $order]);
        $query = $this->db->get($this->_table);
        $res = $query->row();
        if ($res) {
            return true;
        } else {
            return false;
        }
    }

    public function getOrderDetailsByOrderId($order_id) { //API
        $this->db->select("O.shippment_type,scd.company_name as seller_company_name,pd.id as product_id,P.seller,P.width,P.height,P.length,P.weight,O.*,OS.orders_status_name,OP.product_specifications,OP.products_name as product_name,"
                . "OP.products_price,OP.products_tax,PM.url as product_image,units.units_id,units.units_name,OP.final_price,OP.products_quantity,"
                . "C1.name payment_country,C2.name delivery_country,"
                .'OP.offer_id, timestamp(valid_from, time_from) offer_start_time, '
                . 'timestamp(valid_to, time_to) offer_end_time ,oz.status as offer_status');
        $this->db->from($this->_table . " O");
        $this->db->where("O.orders_id = " . $order_id);
        $this->db->join($this->_tableProducts . " OP", "OP.orders_id = O.orders_id", "LEFT");
        $this->db->join("offer_zone oz", " oz.offer_id = OP.offer_id", 'left');
        $this->db->join($this->_tableOrderStatus . " OS", "OS.orders_status_id = O.orders_status", "LEFT");
        $this->db->join($this->_tableCountry . " C1", "C1.id = O.user_country", "LEFT");
        $this->db->join($this->_tableCountry . " C2", "C2.id = O.delivery_country", "LEFT");
        $this->db->join($this->_tableProductsDetails . " P", "P.id = OP.products_id", "LEFT");
        $this->db->join($this->_productDetails . " pd", "pd.id = OP.products_id", "LEFT");
        $this->db->join($this->_companyDetails . " scd", "scd.user_id = pd.seller", "LEFT");
        $this->db->join($this->_productMedia . " PM", "PM.id = (SELECT id FROM $this->_productMedia PM1 WHERE "
                . "PM1.product_id = pd.id and type='photo' ORDER BY PM1.id ASC LIMIT 1)", "LEFT");
        $this->db->join("product_price PC1", "PC1.id = (SELECT id FROM product_price PC3 WHERE "
                . "PC3.product_id = pd.id ORDER BY PC3.id ASC LIMIT 1)", "LEFT");
        $this->db->join("units as units", "PC1.unit=units.units_id", "left");
        $query = $this->db->get();
        $result = $query->result_array();


        //$final_order_amount=0;


        for ($i = 0; $i < count($result); $i++) {
            if ($result[$i]['orders_status'] == 8) {//pending
                $result[$i]['order_status_image'] = base_url() . "assets/mobile/images/order_status/status1.png";
            } else if ($result[$i]['orders_status'] == 16) {//accepted
                $result[$i]['order_status_image'] = base_url() . "assets/mobile/images/order_status/status2.png";
            } else if ($result[$i]['orders_status'] == 10) {//processing
                $result[$i]['order_status_image'] = base_url() . "assets/mobile/images/order_status/status3.png";
            } else if ($result[$i]['orders_status'] == 9) {//processed
                $result[$i]['order_status_image'] = base_url() . "assets/mobile/images/order_status/status4.png";
            } else if ($result[$i]['orders_status'] == 4) {//complete
                $result[$i]['order_status_image'] = base_url() . "assets/mobile/images/order_status/status5.png";
            } else if ($result[$i]['orders_status'] == 1) {//Cancel
                $result[$i]['order_status_image'] = base_url() . "assets/mobile/images/order_status/status8.png";
            } else if ($result[$i]['orders_status'] == 20) {//Cancel request Pending
                $result[$i]['order_status_image'] = base_url() . "assets/mobile/images/order_status/status8.png";
            } else if ($result[$i]['orders_status'] == 25) {//Cancel & Refund
                $result[$i]['order_status_image'] = base_url() . "assets/mobile/images/order_status/status9.png";
            } else if ($result[$i]['orders_status'] == 13) {//Return 
                $result[$i]['order_status_image'] = base_url() . "assets/mobile/images/order_status/status6.png";
            } else if ($result[$i]['orders_status'] == 23) {//Return  Pending
                $result[$i]['order_status_image'] = base_url() . "assets/mobile/images/order_status/status6.png";
            } else if ($result[$i]['orders_status'] == 24) {//Return Pending
                $result[$i]['order_status_image'] = base_url() . "assets/mobile/images/order_status/status6.png";
            } else {
                $result[$i]['order_status_image'] = base_url() . "assets/mobile/images/order_status/status0.png";
            }
            //$result[$i]['final_order_amount']=$result[$i]['final_price'];
            //$result['final_order_amount']=$result[0]['final_price'];
        }

        return $result;
    }

    function check_coupon_on_order($order_id) {
        //Check Coupon or Not
        $this->db->select('orders_id');
        $this->db->from('orders_products');
        $this->db->where('orders_id', $order_id);
        $this->db->where('coupon_id >', 0);
        $q = $this->db->get()->num_rows();
        if ($q == 0) {
            return false;
        } else {
            return true;
        }
    }

    function get_coupon_on_order($order_id, $user_id = 0) {
        //Check Coupon or Not
        $this->db->select('products_id,coupon_id');
        $this->db->from('orders_products');
        $this->db->where('orders_id', $order_id);
        $this->db->where('coupon_id >', 0);
        $q = $this->db->get()->result();

        $tot_coupon_value = 0;
        foreach ($q as $row) {
            $coupon_id = $row->coupon_id;
            $product = $row->products_id;
            $products_price = $row->products_price;
            $products_quantity = $row->products_quantity;

            $temp_total = $products_price * $products_quantity;
            //Check Coupon valid or Not
            $isvalidcoupen = $this->Coupon_model->isCouponAvailableForUser($coupon_id, $product, $user_id);

            if ($isvalidcoupen) {
                $coupon = $this->Coupon_model->getCoupenById($coupon_id);

                if ($coupon->discount_type == "flat") {
                    $tot_coupon_value = $tot_coupon_value + $coupon->coupon_value;
                } else {
                    $percentage = ($temp_total * $coupon->coupon_value) / 100;
                    $tot_coupon_value = ($tot_coupon_value) + $percentage;
                }
            }
        }
        return round($tot_coupon_value, 2);
    }

    public function getOrderDetailsByReturnOrderId($order_id) {

        $this->db->select("scd.company_name as seller_company_name,pd.id as product_id,P.seller,P.width,P.height,P.length,P.weight,O.*,OS.orders_status_name,OP.product_specifications,OP.products_name as product_name,"
                . "OP.products_price,OP.products_tax,PM.url as product_image,units.units_id,units.units_name,OP.final_price,OP.products_quantity,"
                . "C2.name delivery_country");
        $this->db->from($this->_returnOrders . " O");
        $this->db->where("O.return_orders_id = " . $order_id);
        $this->db->join($this->_tableProducts . " OP", "OP.orders_id = O.orders_id", "LEFT");
        $this->db->join($this->_tableOrderStatus . " OS", "OS.orders_status_id = O.orders_status", "LEFT");
        $this->db->join($this->_tableCountry . " C2", "C2.id = O.delivery_country", "LEFT");
        $this->db->join($this->_tableProductsDetails . " P", "P.id = OP.products_id", "LEFT");
        $this->db->join($this->_productDetails . " pd", "pd.id = OP.products_id", "LEFT");
        $this->db->join($this->_companyDetails . " scd", "scd.user_id = pd.seller", "LEFT");
        $this->db->join($this->_productMedia . " PM", "PM.id = (SELECT id FROM $this->_productMedia PM1 WHERE "
                . "PM1.product_id = pd.id and type='photo' ORDER BY PM1.id ASC LIMIT 1)", "LEFT");
        $this->db->join("product_price PC1", "PC1.id = (SELECT id FROM product_price PC3 WHERE "
                . "PC3.product_id = pd.id ORDER BY PC3.id ASC LIMIT 1)", "LEFT");
        $this->db->join("units as units", "PC1.unit=units.units_id", "left");
        $query = $this->db->get();
        $result = $query->result_array();

        //$final_order_amount=0;
        for ($i = 0; $i < count($result); $i++) {
            if ($result[$i]['orders_status'] == 8) {//pending
                $result[$i]['order_status_image'] = base_url() . "assets/images/order_status/status1.png";
            } else if ($result[$i]['orders_status'] == 16) {//accepted
                $result[$i]['order_status_image'] = base_url() . "assets/images/order_status/status2.png";
            } else if ($result[$i]['orders_status'] == 10) {//processing
                $result[$i]['order_status_image'] = base_url() . "assets/images/order_status/status3.png";
            } else if ($result[$i]['orders_status'] == 9) {//processed
                $result[$i]['order_status_image'] = base_url() . "assets/images/order_status/status4.png";
            } else if ($result[$i]['orders_status'] == 4) {//complete
                $result[$i]['order_status_image'] = base_url() . "assets/images/order_status/status5.png";
            }

            //$result[$i]['final_order_amount']=$result[$i]['final_price'];
            //$result['final_order_amount']=$result[0]['final_price'];
        }

        return $result;
    }

    public function getOrderPaymentStatus($order_id) {
        $this->db->select("P.status as payment_status");
        $this->db->from("$this->_table O");
        $this->db->join("order_payment P", "O.orders_id = P.orders_id", "LEFT");
        $this->db->where(["O.orders_id" => $order_id]);
        $query = $this->db->get();
        return $query->row();
    }

    public function addRefundRequest($data) {
        $this->db->insert("order_refund", $data);
        return $this->db->insert_id();
    }

    function get_order_status($orders_id) {
        $this->db->select('a.orders_id,b.orders_status_name as status,a.comment,DATE_FORMAT(a.date_added,"%d-%M-%Y %H:%i") AS date_added');
        $this->db->from('orders_history a');
        $this->db->join('orders_status b', 'a.status=b.orders_status_id', 'left');
        $this->db->where('a.orders_id', $orders_id);
        $this->db->order_by('a.id', 'asc');
        $query = $this->db->get();
        return $query->result();
    }

    function get_return_order_status($orders_id) {
        $this->db->select('a.orders_id,b.orders_status_name as status,a.comment,DATE_FORMAT(a.date_added,"%d-%M-%Y %H:%i") AS date_added');
        $this->db->from('return_orders_history a');
        $this->db->join('orders_status b', 'a.status=b.orders_status_id', 'left');
        $this->db->where('a.orders_id', $orders_id);
        $this->db->order_by('a.id', 'asc');
        $query = $this->db->get();
        return $query->result();
    }

    public function todaysSale() {
        $this->db->select("COUNT(orders_id) as total_orders, SUM(order_price)");
        $this->db->from($this->_table);
        $this->db->where(["DATE(date_purchased)" => date("Y-m-d")]);
        $query = $this->db->get();
        return $query->row();
    }

    /*
     * Get User(Buyer) Orders without product details
     * @param Int user id
     * @return Array of objects of orders
     */

    public function getUserOrders($user_id) {
        $query = $this->db->get_where($this->_table, ["user_id" => $user_id]);
        return $query->result();
    }

    /*
     * Ravindra Ravindra Mobile Web Site
     * Get User(Buyer) Orders with product details
     * @param Int user id
     * @return Array of objects of orders and Order Product
     */

    public function getUserOrdersWithProducts($user_id) {

        $select = "(O.order_price) as grand_price, "
                . "O.date_purchased as created_on, "
                . "O.orders_id,O.delivery_date,"
                . "OS.orders_status_name as order_status,O.orders_status as OSid,"
                . "PD.name as product_name,PD.id as product_id, "
                . "OP.products_price as unit_price,OP.offer_id, "
                . "OP.products_quantity as products_quantity, "
                . "SCD.company_name, "
                . "PM.url as product_image, units.units_id, units.units_name,PC1.quantity_from as moq, country.iso as country_iso,country.currency as country_currency";

        $this->db->select($select);
        $this->db->from("$this->_table O");
        $this->db->join("$this->_tableProducts OP", "O.orders_id = OP.orders_id", "LEFT");
        $this->db->join("$this->_tableProductsDetails PD", "PD.id = OP.products_id", "LEFT");
        $this->db->join("$this->_companyDetails SCD", "SCD.user_id = PD.seller", "LEFT");
        $this->db->join("$this->_tableOrderStatus OS", "OS.orders_status_id = O.orders_status", "LEFT");
        $this->db->join("$this->_productMedia PM", 'ON PM.id = (select id from product_media PM1 where PM1.product_id = PD.id and PM1.type ="photo" ORDER BY id ASC LIMIT 1 )', "LEFT");
        $this->db->join("product_price PC1", "PC1.id = (SELECT id FROM product_price PC3 WHERE "
                . "PC3.product_id = PD.id ORDER BY PC3.id ASC LIMIT 1)", "LEFT");
        $this->db->join("units as units", "PC1.unit=units.units_id", "LEFT");
        $this->db->join("country as country", "O.delivery_country=country.id", "LEFT");
        $this->db->group_by("O.orders_id");
        $this->db->where(["O.user_id" => $user_id]);
        $this->db->order_by("O.orders_id", "DESC");
        $query = $this->db->get();
        $result = $query->result();

        for ($i = 0; $i < count($result); $i++) {
            $order_id = $result[$i]->orders_id;

            $this->db->select('orders_id');
            $this->db->from('orders_products');
            $this->db->where('orders_id', $order_id);
            $this->db->where('coupon_id >', 0);
            $q = $this->db->get()->num_rows();
            if ($q == 0) {
                $coupon = false;
            } else {
                $coupon = true;
            }

            $result[$i]->coupon_apply = $coupon;
        }

        return $result;
    }

    /*
     * Ravindra Mobile Web Site
     */

    public function getUserOrdersWithOrderId($order_id) {

        $this->db->where("orders_id", $order_id);
        return $query = $this->db->get("$this->_tableProducts")->result_array();
    }

    /*
     * Ravindra Mobile Web Site
     */

    public function getTrackProductDetails($order_id) {

        $select = "(O.order_price) as grand_price,O.delivery_date, "
                . "O.date_purchased as created_on,O.orders_id, "
                . "O.orders_id,O.orders_status as OSid, "
                . "OS.orders_status_name as order_status, "
                . "PD.name as product_name,PD.id as product_id, "
                . "OP.products_price as unit_price,OP.product_specifications,"
                . "OP.offer_id,OP.final_price,"
                . "OP.products_quantity as products_quantity, "
                . "SCD.company_name, "
                . "PM.url as product_image, units.units_id, units.units_name,PC1.quantity_from as moq, country.iso as country_iso,country.currency as country_currency";

        $this->db->select($select);
        $this->db->from("$this->_table O");
        $this->db->join("$this->_tableProducts OP", "O.orders_id = OP.orders_id", "LEFT");
        $this->db->join("$this->_tableProductsDetails PD", "PD.id = OP.products_id", "LEFT");
        $this->db->join("$this->_companyDetails SCD", "SCD.user_id = PD.seller", "LEFT");
        $this->db->join("$this->_tableOrderStatus OS", "OS.orders_status_id = O.orders_status", "LEFT");
        $this->db->join("$this->_productMedia PM", 'ON PM.id = (select id from product_media PM1 where PM1.product_id = PD.id and PM1.type ="photo" ORDER BY id ASC LIMIT 1 )', "LEFT");
        $this->db->join("product_price PC1", "PC1.id = (SELECT id FROM product_price PC3 WHERE "
                . "PC3.product_id = PD.id ORDER BY PC3.id ASC LIMIT 1)", "LEFT");
        $this->db->join("units as units", "PC1.unit=units.units_id", "LEFT");
        $this->db->join("country as country", "O.delivery_country=country.id", "LEFT");
        $this->db->where("O.orders_id", $order_id);
        $this->db->order_by("O.orders_id", "DESC");
        $query = $this->db->get();
        $result = $query->result();

        //print_r($result);exit;


        for ($i = 0; $i < count($result); $i++) {
            $order_id = $result[$i]->orders_id;

            $this->db->select('orders_id');
            $this->db->from('orders_products');
            $this->db->where('orders_id', $order_id);
            $this->db->where('coupon_id >', 0);
            $q = $this->db->get()->num_rows();
            if ($q == 0) {
                $coupon = false;
            } else {
                $coupon = true;
            }

            $result[$i]->coupon_apply = $coupon;
        }
        //echo $this->db->last_query(); die;
        return $result;
        //echo $this->db->last_query(); 
    }

    public function getOrderById($order_id) {
        $this->db->where(["orders_id" => $order_id]);
        $this->db->join("orders_status", "orders_status.orders_status_id = $this->_table.orders_status");
        $query = $this->db->get($this->_table);
        return $query->row();
    }

    public function getUserOrders_invoice($order_id) {
        $this->db->where('orders_id', $order_id);
        $this->db->where('orders_status', 26);
        $this->db->from($this->_table);
        return $this->db->get()->row();
    }

    public function getOrderDetailsForInvoice($order_id) {
        $this->db->where('orders_id', $order_id);
        return $this->db->get('orders_products')->row_array();
    }

    public function getOrderInfo($order_id) {
        $this->db->where(["orders_id" => $order_id]);
        $query = $this->db->get($this->_table);
        return $query->row();
    }

    function check_delivery_return($order_id) {
        $this->db->select('delivery_date,orders_status');
        $this->db->from('orders');
        $this->db->where('orders_id', $order_id);
        $query = $this->db->get()->row();

        //check return status
        if ($query->orders_status == 4) {
            $delivery_date = $query->delivery_date;

            $return_days = strtotime(date('Y-m-d', strtotime($delivery_date . ' + 3 days')));

            if ($return_days >= strtotime(date('Y-m-d'))) {
                return 1;
            } else {
                return 0;
            }
        } else {
            return 0;
        }
    }

    function check_return_shipping_cost($order_id) {
        $this->db->select('shipping_cost');
        $this->db->from('return_orders');
        $this->db->where('orders_id', $order_id);
        $check = $this->db->get()->num_rows();
        if ($check == 0) {
            return 0;
        } else {
            $this->db->select('shipping_cost');
            $this->db->from('return_orders');
            $this->db->where('orders_id', $order_id);
            $query = $this->db->get()->row();
            $shipping_cost = $query->shipping_cost;
            return $shipping_cost;
        }
    }

    function check_order_with_coupon_applied($order_id) {

        //Load Coupon Model
        $this->load->model('Coupon_model');
        $this->load->model('Common_model');

        //Check Coupon Applied or Not
        $check = $this->check_coupon_on_order($order_id);
        if ($check == true) {

            //Gel Coupon Applicable Product 
            $this->db->select('a.user_id,a.orders_id,a.shipping_cost,a.order_price,b.products_id,b.coupon_id,b.products_price,b.products_quantity,b.final_price,b.products_name');
            $this->db->from('orders a');
            $this->db->join('orders_products b', 'a.orders_id=b.orders_id');
            $this->db->where('a.orders_id', $order_id);
            $this->db->where('a.orders_status', 8);
            $q = $this->db->get()->result();

            $this->db->select('SUM(final_price)pro_price');
            $this->db->from('orders_products');
            $this->db->where('orders_id', $order_id);
            $query = $this->db->get()->row();

            $tot_pro_price = $query->pro_price;


            $tot_prod_price = 0;
            $updated_all_product_price = 0;
            $msg = 0;
            $chech_shipp = $this->Common_model->getAll('shipping_vendor', array('id' => $ship_method))->row();
            //Check Shipping Status
            $shipping_type = $chech_shipp->shipping_type;
            $free_amount = $chech_shipp->free_amount;

            foreach ($q as $prod) {

                $user_id = $prod->user_id;
                $orders_id = $prod->orders_id;
                //Order Price
                if ($shipping_type == 'Free' && $tot_pro_price >= $free_amount) {
                    $orderPrice = $prod->order_price - $prod->shipping_cost;
                } else {
                    $orderPrice = $prod->order_price;
                }

                $orderPrice_ch = (int) $orderPrice;

                $quantity = $prod->products_quantity;
                $unit_price = $prod->products_price;

                $temp_total = $quantity * $unit_price;

                if ($prod->coupon_id != 0) {
                    $coupon_id = $prod->coupon_id;
                    $product = $prod->products_id;


                    //Check Coupon valid or Not
                    $isvalidcoupen = $this->Coupon_model->isCouponAvailableForUser($coupon_id, $product, $user_id);

                    if ($isvalidcoupen) {
                        $coupon = $this->Coupon_model->getCoupenById($coupon_id);

                        if ($coupon->discount_type == "flat") {
                            $tot_prod_price = ($tot_prod_price + $temp_total) - $coupon->coupon_value;
                        } else {
                            $percentage = ($temp_total * $coupon->coupon_value) / 100;
                            $tot_prod_price = ($tot_prod_price + $temp_total) - $percentage;
                        }
                    } else {
                        $msg = $msg . ',' . $prod->products_name;
                        $tot_prod_price = $tot_prod_price + $temp_total;

                        //Update Product Final Price
                        $dat['final_price'] = round($temp_total, 2);
                        $this->Common_model->update('orders_products', $dat, array('products_id' => $product, 'orders_id' => $orders_id));
                    }
                } else {
                    $tot_prod_price = $tot_prod_price + $temp_total;
                }
            }

            $tot_prod_price_ch = (int) $tot_prod_price;
            //Check Price
            if (trim($orderPrice_ch) === trim($tot_prod_price_ch)) {
                $success = 0; // All Correct
                return $success;
            } else {
                //Update Final Price 
                 if ($shipping_type == 'Free' && $tot_pro_price >= $free_amount) {
                              $fdat['order_price'] = round($tot_prod_price,2);
                         }else{
                              $fdat['order_price'] = round($tot_prod_price + $prod->shipping_cost, 2);
                         }
               
                $this->Common_model->update('orders', $fdat, array('orders_id' => $orders_id));

                $success = 1; // Coupon Expire and Update Order Price
                return $success;
            }
        } else {
            $success = 2; // No Coupon Applied
            return $success;
        }
    }

    function get_allOrders() {
        $this->db->select("DATE_FORMAT(a.date_purchased, '%a %d %M %Y') as date_purchased_only, DATE_FORMAT(a.date_purchased, '%h:%i:%s %p ') as time_purchased, DATE_FORMAT(a.orders_date_finished, '%a %d %M %Y %h:%i:%s %p ') orders_date_finished, DATE_FORMAT(oh.date_added, '%a %d %M %Y %h:%i:%s %p ') order_accepted_date, vendor.email vendor_email, vendor.phone vendor_mobile, vendor.address vendor_address,CONCAT(first_name, ' ', last_name) vendor_name, publish_status,a.user_id,payment_id,seller_id,b.orders_status_name,a.cancelled_by,a.orders_id as ord,a.order_token_number,a.awb_number,concat('ORD',a.orders_id) as orders_id,DATE_FORMAT(a.date_purchased, '%a %d %M %Y %h:%i:%s %p ') as date_purchased,DATE_FORMAT(a.delivery_date, '%a %d %M %Y %h:%i:%s %p ') as delivery_date,a.user_name,a.user_email_address,a.user_telephone,concat(a.user_street_address,' ',a.user_city,' ',a.user_state,' ',a.user_postcode) as shipping_adress,a.order_price,a.shipping_cost,a.vendor_payable_price,a.pick_name,a.pick_mobile,a.pick_email,concat(a.pick_addr_type,' ',a.pick_state,' ',a.pick_pincode) as pickup_address,a.commission,a.gst, a.shippment_type");
        $this->db->from('orders a');
        $this->db->join('orders_status b', 'a.orders_status=b.orders_status_id', 'left');
        $this->db->join('order_payment op', 'a.orders_id=op.orders_id', 'left');
        $this->db->join('orders_products ops', 'a.orders_id=ops.orders_id', 'left');
        $this->db->join('product_details pd', 'pd.id=ops.products_id', 'left');
        $this->db->join('users vendor', 'vendor.id=a.seller_id', 'left');
        $this->db->join('orders_history oh', 'a.orders_id=oh.orders_id AND oh.status=16', 'left');

        if ($this->input->post('dateFrom') != "") {
            $this->db->where("date(a.date_purchased) >=", date('Y-m-d', strtotime($this->input->post('dateFrom'))));
        }
        if ($this->input->post('dateTo') != "") {
            $this->db->where("date(a.date_purchased) <=", date('Y-m-d', strtotime($this->input->post('dateTo'))));
        }
        if ($this->input->post('orderid') != "") {
            $this->db->where("concat('ORD',a.orders_id)", $this->input->post('orderid'));
        }
        if ($this->input->post('vendorid') != "") {
            $this->db->where("a.seller_id", $this->input->post('vendorid'));
        }
        if ($this->input->post('orderstatus') != "") {
            $this->db->where("a.orders_status", $this->input->post('orderstatus'));
        }
        $this->db->order_by('a.orders_id', 'DESC');
        return $this->db->get()->result_array();
    }

    /*
     * Author Ravindra
     * Get Order Details With Transaction ID, Order Id, Product Id, & Product Details
     * @params Order_id.
     * Date: 07/08/2019 
     */

    public function getOrderProductTrans($order_id) {
    $this->db->select('a.order_price,a.shipping_cost,a.wallet_option,opro.orders_id,opro.products_id,opro.products_quantity,opro.products_name,opro.final_price,opay.description,opay.payment_id,opay.payment_by');

        $this->db->from('orders a');
        $this->db->join('orders_products opro', 'a.orders_id = opro.orders_id');
        $this->db->join('order_payment opay', 'a.orders_id = opay.orders_id');
        $this->db->where('a.orders_id', $order_id);
        $query = $this->db->get();
        return $query->result();
    }

    /**
     * @auther Yogesh Pardeshi 12-08-2019
     * @param $productId  a product id pk
     * @param $totalShoppedQty = quantity shopped by buyer
     * @return true if avail_qty > shopped quantity else false for out of stock, -1 for invalid order id
     * @use at buyer end for checking pending order, while making payment
     * */
    public function checkProductAvailQty($productId, $totalShoppedQty) {
        if (!empty($productId)) {
            $qty = $this->db->select('count(available_quantity) as low_stock')
                            ->from('product_details')
                            ->where('id', $productId)
                            ->where('available_quantity >= ' . $totalShoppedQty)
                            ->get()->result_array();
            return $qty[0]['low_stock'];
        } else {
            return -1;
        }
    }

    /**
     * @auther Yogesh Pardeshi 28092019
     * @param $order_id = pk of order
     * @return $total_products = total number of products shopped by buyer
     * @use payment controller after payment using credit card, debit and wallet
     * Used for deducting quantity after successful payment in product_details table
     * */
    public function reduceProductQty($order_id) {
        if ($order_id == NULL || $order_id == 0) {
            return false;
        } else {
            $result = $this->db->select('product_specifications')
                            ->from('orders_products')
                            ->where("orders_id = $order_id")
                            ->get()->result_array()[0];
            $product_specifications = json_decode($result['product_specifications']);
            $product_id = $product_specifications->product_id;
            $product_qty_shopped = $product_specifications->specifications[0]->specifications->total_quantity;

            if ($product_qty_shopped > 0 && $product_id > 0) {
                $affected = $this->db->set("available_quantity", "available_quantity - $product_qty_shopped", false)
                        ->where("id = $product_id")
                        ->where("available_quantity >= $product_qty_shopped")
                        ->update('product_details');
                return $affected;
            }
            return 0;
        }
    }

}
