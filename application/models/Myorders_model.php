<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Myorders_model extends CI_Model {

    private $_table;
    private $_tableOrderProduct;

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->model('Common_model');
        $this->_table = "orders";
        $this->_tableOrderProduct = "orders_products";
    }

    public function getAll() {
        $query = $this->db->get($this->_table);
        return $query->result();
    }

    function read_order_notification() {
        $this->Common_model->update('admin_notification', ['status' => 'Read'], ['status' => 'Received', 'type' => 'order_place']);
        $this->Common_model->update('admin_notification', ['status' => 'Read'], ['status' => 'Received', 'type' => 'order_return']);
        $this->Common_model->update('admin_notification', ['status' => 'Read'], ['status' => 'Received', 'type' => 'order_cancel']);
        $this->Common_model->update('admin_notification', ['status' => 'Read'], ['status' => 'Received', 'type' => 'order_refund']);
    }

    function read_inquires_notification() {
        $this->Common_model->update('admin_notification', ['status' => 'Read'], ['status' => 'Received', 'type' => 'Inquiry']);
    }

    function allorders_count($id) {
        $query = $this->db->get_where($this->_table, array('user_id' => $id));
        return $query->num_rows();
    }

    function single_order($id) {
        $this->db->select('*');
        $this->db->from('orders a');
        $this->db->join('orders_status c', 'c.orders_status_id = a.orders_status');
        // $this->db->join('order_payment o', 'o.orders_id = a.orders_id');
        $this->db->where('a.orders_id', $id);
        $query = $this->db->get();
        return $query->row_array();
    }

    /*function order_products($id) {
        $this->db->select('*');
        $this->db->from('orders a');
        $this->db->join('orders_products b', 'a.orders_id = b.orders_id', 'left');
        $this->db->where('a.orders_id', $id);
        $query = $this->db->get();
        return $query->result_array();
    }*/
    
    function order_products($id) {
        $this->db->select('*');
        $this->db->from('orders a');
        $this->db->join('orders_products b', 'a.orders_id = b.orders_id', 'left');
        //$this->db->join('product_details c', 'c.id = b.products_id', 'left');
        //$this->db->join('product_media d', 'd.product_id = b.products_id', 'left');
        $this->db->where('a.orders_id', $id);
        $query = $this->db->get();
        return $query->result_array();
    }

    function allorders($ret_id, $limit, $start, $col, $dir) {
        $this->db->select('*');
        $this->db->from('orders a');
        $this->db->join('orders_status c', 'c.orders_status_id = a.orders_status');
        $this->db->where('a.user_id', $ret_id);
        $this->db->limit($limit, $start);
        $this->db->order_by($col, $dir);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return null;
        }
    }

    function order_search($ret_id, $limit, $start, $search, $col, $dir) {
        $this->db->select('*');
        $this->db->from('orders a');
        $this->db->join('orders_status c', 'c.orders_status_id = a.orders_status');
        $this->db->where('a.user_id', $ret_id);
        $this->db->where("(`a`.`seller_id` LIKE '%" . $search . "%' ESCAPE '!' OR `c`.`orders_status_name` LIKE '%" . $search . "%' ESCAPE '!')");

        $this->db->limit($limit, $start);
        $this->db->order_by($col, $dir);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return null;
        }
    }

    function order_search_count($ret_id, $search) {
        $this->db->select('*');
        $this->db->from('orders a');
        $this->db->join('orders_status c', 'c.orders_status_id = a.orders_status');
        $this->db->where('a.user_id', $ret_id);
        $this->db->where("(`a`.`user_id` LIKE '%" . $search . "%' ESCAPE '!' OR `c`.`orders_status_name` LIKE '%" . $search . "%' ESCAPE '!')");
        $query = $this->db->get();
        return $query->num_rows();
    }

    function product_review($ret_id, $pro_id) {
        $this->db->select('*');
        $this->db->from('reviews a');
        $this->db->join('reviews_description b', 'a.reviews_id = b.reviews_id');
        $this->db->where('a.products_id', $pro_id);
        $this->db->where('a.seller_id', $ret_id);
        $query = $this->db->get();
        $ch_res = $query->num_rows();
        if ($ch_res > 0) {
            $res = $query->result();
        } else {
            
        }
    }

    function allproduct_review() {
        $this->db->select('*');
        $this->db->from('reviews a');
        $this->db->join('reviews_description b', 'a.reviews_id = b.reviews_id');
        $this->db->where('a.products_id', $pro_id);
        $query = $this->db->get();
        $ch_res = $query->num_rows();
        if ($ch_res > 0) {
            $res = $query->result();
        } else {
            
        }
    }

    ///////Admin All Seller Orders///////////////////////////
    ///////Admin All Seller Orders///////////////////////////

    function seller_allorders_count($id) {
        $query = $this->db->get_where($this->_table, array('seller_id' => $id));
        return $query->num_rows();
    }

    function seller_allorders($ret_id, $limit, $start, $col, $dir) {
        $this->db->select('*');
        $this->db->from('orders a');
        //$this->db->join('orders_products b', 'a.orders_id = b.orders_id');
        $this->db->join('orders_status c', 'c.orders_status_id = a.orders_status');
        $this->db->where('a.seller_id', $ret_id);
        $this->db->limit($limit, $start);
        $this->db->order_by($col, $dir);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return null;
        }
    }

    function seller_order_search($ret_id, $limit, $start, $search, $col, $dir) {
        $this->db->select('*');
        $this->db->from('orders a');
        $this->db->join('orders_status c', 'c.orders_status_id = a.orders_status');
        $this->db->where('a.user_id', $ret_id);
        $this->db->where("(`a`.`user_id` LIKE '%" . $search . "%' ESCAPE '!' OR `c`.`orders_status_name` LIKE '%" . $search . "%' ESCAPE '!')");

        $this->db->limit($limit, $start);
        $this->db->order_by($col, $dir);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return null;
        }
    }

    function seller_order_search_count($ret_id, $search) {
        $this->db->select('*');
        $this->db->from('orders a');
        $this->db->join('orders_status c', 'c.orders_status_id = a.orders_status');
        $this->db->where('a.user_id', $ret_id);
        $this->db->where("(`a`.`user_id` LIKE '%" . $search . "%' ESCAPE '!' OR `c`.`orders_status_name` LIKE '%" . $search . "%' ESCAPE '!')");
        $query = $this->db->get();

        return $query->num_rows();
    }

    function update_cancel_order_history($order_id = 0) {


//Order Refund Initiated History
        $inserRefundHistory['orders_id'] = $order_id;
        $inserRefundHistory['comment'] = 'Refund to Wallet';
        $inserRefundHistory['created_at'] = date('Y-m-d H:i:s');
        $this->Common_model->insert('order_refund_history', $inserRefundHistory);



        //Pending
        $orderHistory['orders_id'] = $order_id;
        $orderHistory['status'] = 20;
        $orderHistory['date_added'] = date('Y-m-d H:i:s');
        $orderHistory['comment'] = 'Order Cancel Request Pending !';

        $this->Common_model->insert('orders_history', $orderHistory);

        //Order History Approved
        $orderHistory['orders_id'] = $order_id;
        $orderHistory['status'] = 21;
        $orderHistory['date_added'] = date('Y-m-d H:i:s');
        $orderHistory['comment'] = 'Order Cancel Request Approved !';
        $this->Common_model->insert('orders_history', $orderHistory);


        //Order History
        $orderHistory['orders_id'] = $order_id;
        $orderHistory['status'] = 25;
        $orderHistory['date_added'] = date('Y-m-d H:i:s');
        $orderHistory['comment'] = 'Order Cancelled and Amount added to your wallet !';
        $this->Common_model->insert('orders_history', $orderHistory);
    }

    function refund_added_to_wallet_from_buyer($order_id) {
        // Total Order Price Refunded (+ Shipping Cost)
        $get_order = $this->Common_model->getAll('orders', array('orders_id' => $order_id))->row();
        $user_id = $get_order->user_id;
        //$user_id = $this->session->userdata("user_id");

        $insertwallet['user_id'] = $user_id;
        $insertwallet['status'] = 1;
        $insertwallet['created'] = date('Y-m-d H:i:s');
        $insertwallet['updated'] = date('Y-m-d H:i:s');
        $insertwallet['balance'] = $get_order->order_price;

//Check entry in main wallet
        $ch_user = $this->Common_model->getAll('buyer_wallet', array('user_id' => $user_id))->num_rows();
        if ($ch_user > 0) {
            $exist_wallet_bal_q = $this->Common_model->getAll('buyer_wallet', array('user_id' => $user_id))->row();
            $dat['balance'] = $exist_wallet_bal_q->balance + $get_order->order_price;
            $dat['updated'] = date('Y-m-d H:i:s');
            $this->Common_model->update('buyer_wallet', $dat, array('user_id' => $user_id));

            //Insert History
            $his['buyer_id'] = $user_id;
            $his['previous_amount'] = $exist_wallet_bal_q->balance;
            $his['current_amount'] = $exist_wallet_bal_q->balance + $get_order->order_price;
            $his['amount'] = $get_order->order_price;
            $his['transaction_type'] = 'credit';
            $his['against'] = 'refund';
            $his['referrence'] = '#' . $order_id;
            $his['remark'] = 'Amount added to Wallet against Order # ' . $order_id;
            $his['status'] = 1;
            $this->Common_model->insert('buyer_wallet_history', $his);
        } else {
            $this->Common_model->insert('buyer_wallet', $insertwallet);
            
            //Insert History
            $his['buyer_id'] = $user_id;
            $his['previous_amount'] =0;
            $his['current_amount'] = $get_order->order_price;
            $his['amount'] = $get_order->order_price;
            $his['transaction_type'] = 'credit';
            $his['against'] = 'refund';
            $his['referrence'] = '#' . $order_id;
            $his['remark'] = 'Amount added to Wallet against Order # ' . $order_id;
            $his['status'] = 1;
        }
    }

    function refund_added_to_wallet_from_admin($order_id = 0, $amount = 0, $user_id) {
        
// Total Order Price Refunded (+ Shipping Cost)
        $get_order = $this->Common_model->getAll('orders', array('orders_id' => $order_id))->row();
        //$user_id = $this->session->userdata("user_id");

        $insertwallet['user_id'] = $user_id;
        $insertwallet['status'] = 1;
        $insertwallet['created'] = date('Y-m-d H:i:s');
        $insertwallet['updated'] = date('Y-m-d H:i:s');
        $insertwallet['balance'] = $amount;

//Check entry in main wallet
        $ch_user = $this->Common_model->getAll('buyer_wallet', array('user_id' => $user_id))->num_rows();
        if ($ch_user > 0) {
           
            $exist_wallet_bal_q = $this->Common_model->getAll('buyer_wallet', array('user_id' => $user_id))->row();
            $dat['balance'] = $exist_wallet_bal_q->balance + $amount;
            $dat['updated'] = date('Y-m-d H:i:s');
            $this->Common_model->update('buyer_wallet', $dat, array('user_id' => $user_id));

            //Insert History
            $his['buyer_id'] = $user_id;
            $his['previous_amount'] =$exist_wallet_bal_q->balance;
            $his['current_amount'] = $exist_wallet_bal_q->balance + $get_order->order_price;
            $his['amount'] = $amount;
            $his['transaction_type'] = 'credit';
            $his['against'] = 'refund';
            $his['referrence'] = '#' . $order_id;
            $his['remark'] = 'Amount added to Wallet against Order # ' . $order_id;
            $his['status'] = 1;
            $this->Common_model->insert('buyer_wallet_history', $his);
        } else {
            $this->Common_model->insert('buyer_wallet', $insertwallet);
            
            //Insert History
            $his['buyer_id'] = $user_id;
            $his['previous_amount'] =0;
            $his['current_amount'] = $amount;
            $his['amount'] = $amount;
            $his['transaction_type'] = 'credit';
            $his['against'] = 'refund';
            $his['referrence'] = '#' . $order_id;
            $his['remark'] = 'Amount added to Wallet against Order # ' . $order_id;
            $his['status'] = 1;
            $this->Common_model->insert('buyer_wallet_history', $his);
        }
    }

    public function remove_order($order_id) {
        $this->db->where(["orders_id" => $order_id]);
        $this->db->delete("orders");
    }

    public function remove_order_products($order_id) {
        $this->db->where(["orders_id" => $order_id]);
        $this->db->delete("orders_products");
    }

    public function remove_order_history($order_id) {
        $this->db->where(["orders_id" => $order_id]);
        $this->db->delete("orders_history");
    }
	
	function checkIsreturnable($order_id)
	{
		$this->db->select('is_product_returnable');
		$this->db->from('orders_products o');
		$this->db->join('product_details p','o.products_id = p.id','INNER');
		$this->db->where('o.orders_id',$order_id);
		return $this->db->get()->row();
	}

}
