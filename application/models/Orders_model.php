<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Orders_model extends CI_Model 
{
    private $_table, $_tableProducts, $_tableOrderStatus, $_tableCountry, $_tableProductsDetails, $_tableHistory;
    private $_select, $_column_order, $_column_search, $_order;

    public function __construct() 
    {
        parent::__construct();
        $this->_table = "orders";
        $this->_tableProducts = "orders_products";
        $this->_tableOrderStatus = "orders_status";
        $this->_tableCountry = "country";
        $this->_tableProductsDetails = "product_details";
        $this->_tableHistory = "orders_history";
        $this->_select = "$this->_table.orders_id,order_price,user_name,products_name,orders_status_name,final_price,date_purchased";
        $this->_column_order = array("$this->_table.orders_id", "user_name", "products_name", "orders_status_name", "final_price", "date_purchased");
        $this->_column_search = array("$this->_table.orders_id", "user_name", "products_name", "orders_status_name", "final_price", "date_purchased");
        $this->_order = array("$this->_table.orders_id" => "desc");
    }

    /*
     * @param - $data array of order attributes
     * @return - $order_id int
     *
     */

    public function addOrder($data) 
    {
        $this->db->insert($this->_table, $data);
        return $this->db->insert_id();
    }

    /*
     * @param - $data array of order product details like product id, order id, price
     * @return - $order_product_id int
     *
     */

    public function addOrderProduct($data) 
    {
        $this->db->insert($this->_tableProducts, $data);
        return $this->db->insert_id();
    }

    public function getOrderStatusList() 
    {
        $query = $this->db->get($this->_tableOrderStatus);
        return $query->result();
    }

    public function getOrderDetailsById($order_id) 
    {
        $this->db->select("O.orders_id,O.user_id,O.user_name,O.user_street_address,"
                . "O.user_city,O.user_postcode,O.user_state,O.user_telephone,"
                . "O.user_email_address,O.delivery_name,O.delivery_street_address,"
                . "O.delivery_city,O.delivery_postcode,O.delivery_state,O.date_purchased,"
                . "O.shipping_cost,O.currency,O.payment_method,OS.orders_status_name,OP.products_name,"
                . "OP.products_price,OP.products_tax,OP.final_price,OP.products_quantity,"
                . "C1.name payment_country,C2.name delivery_country");
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

    public function getOrderHistory($order_id) 
    {
        $this->db->select("OH.*, OS.orders_status_name");
        $this->db->join($this->_tableOrderStatus . " OS", "OS.orders_status_id = OH.status");
        $query = $this->db->get_where($this->_tableHistory . " OH", array("orders_id" => $order_id));
        return $query->result();
    }

    public function addOrderHistory($data) 
    {
        $this->db->insert($this->_tableHistory, $data);
        return $this->db->insert_id();
    }

    public function getSellerOrderCount($seller) 
    {
        $this->db->from($this->_tableProducts . " OP ");
        $this->db->join($this->_tableProductsDetails . " PD ", "PD.id = OP.products_id");
        $this->db->where(array("PD.seller" => $seller));
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function getSellerCustomerCount($seller) 
    {
        $this->db->from($this->_table . " O ");
        $this->db->join($this->_tableProducts . " OP ", "O.orders_id = OP.orders_id");
        $this->db->join($this->_tableProductsDetails . " PD ", "PD.id = OP.products_id");
        $this->db->where(array("PD.seller" => $seller));
        $this->db->group_by("O.user_id");
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function getSellerOrderTotal($seller) 
    {
        $this->db->select("SUM(OP.final_price) as total");
        $this->db->from($this->_tableProducts . " OP ");
        $this->db->join($this->_tableProductsDetails . " PD ", "PD.id = OP.products_id");
        $this->db->where(array("PD.seller" => $seller));
        $query = $this->db->get();
        $result = $query->row();
        return $result->total;
    }

    public function getSellerOrders($seller, $limit = 0) 
    {
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

    /*
     * Following functions are added to use with server side datatables
     */

    function allorder_count() 
    {
        $query = $this
                ->db
                ->get($this->_table);

        return $query->num_rows();
    }

    function allorder($limit, $start, $col, $dir) 
    {
        $query = $this
                ->db
                ->select("O1.*,O2.products_name,O2.products_price,O2.products_tax,O2.products_quantity,O2.final_price,O3.orders_status_name")
                ->limit($limit, $start)
                ->order_by($col, $dir)
                ->join($this->_tableProducts . " O2 ", "O2.orders_id = O1.orders_id")
                ->join($this->_tableOrderStatus . " O3 ", "O3.orders_status_id = O1.orders_status")
                ->get($this->_table . " O1 ");

        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return null;
        }
    }

    function order_search($limit, $start, $search, $col, $dir) 
    {
        $query = $this
                ->db
                ->select("O1.*,O2.products_name,O2.products_price,O2.products_tax,O2.products_quantity,O2.final_price,O3.orders_status_name")
                ->like('O1.orders_id', $search)
                ->or_like('O1.retailers_name', $search)
                ->or_like('O1.retailers_email_address', $search)
                ->or_like('O2.products_name', $search)
                ->join($this->_tableProducts . " O2 ", "O2.orders_id = O1.orders_id")
                ->join($this->_tableOrderStatus . " O3 ", "O3.orders_status_id = O1.orders_status")
                ->limit($limit, $start)
                ->order_by($col, $dir)
                ->get($this->_table . " O1 ");


        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return null;
        }
    }

    function order_search_count($search) 
    {
        $query = $this
                ->db
                ->like('O1.orders_id', $search)
                ->or_like('O1.retailers_name', $search)
                ->or_like('O1.retailers_email_address', $search)
                ->or_like('O2.products_name', $search)
                ->join($this->_tableProducts . " O2 ", "O2.orders_id = O1.orders_id")
                ->get($this->_table . " O1 ");

        return $query->num_rows();
    }

    /*     * ****** Following functions are used with server side data table custom filters ****************** */

    public function get_datatables($search_date, $status_id, $total, $order_id, $supplier_id = 0) 
    {
        $this->_get_datatables_query($search_date, $status_id, $total, $order_id, $supplier_id);

        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);

        $query = $this->db->get();

        return $query->result();
    }

    public function count_filtered($search_date, $status_id, $total, $order_id, $supplier_id = 0) 
    {
        $this->_get_datatables_query($search_date, $status_id, $total, $order_id, $supplier_id);

        $query = $this->db->get();

        return $query->num_rows();
    }

    public function count_all() 
    {
        $this->db->from($this->_table);
        return $this->db->count_all_results();
    }

    private function _get_datatables_query($search_date, $status_id, $total, $order_id, $supplier_id = 0) 
    {
        $this->db
                ->select($this->_select)
                ->from($this->_table)
                ->join($this->_tableProducts, $this->_tableProducts . ".orders_id = " . $this->_table . ".orders_id")
                ->join($this->_tableOrderStatus, $this->_tableOrderStatus . ".orders_status_id = " . $this->_table . ".orders_status");

        if ($search_date != '') {

            $this->db->where("DATE(date_purchased) = '" . $search_date . "'");
        }
        if ($order_id != '') {

            $this->db->where("$this->_table.orders_id = " . $order_id);
        }
        if ($status_id != '') {

            $this->db->where("orders_status = " . $status_id);
        }
        if ($total != '') {

            $this->db->where("final_price = " . $total);
        }
        if ($supplier_id != 0) {
            $this->db->join("$this->_tableProductsDetails PD", "PD.id = $this->_tableProducts.products_id AND PD.seller = " . $supplier_id);
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

}
