<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Wallet extends CI_Controller {

    public function __construct() {
        parent::__construct();
        if (!$this->session->userdata("admin_logged_in")) {
            $error = "<div class='alert alert-danger alert-dismissible'>
                        <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                        <strong>Error!</strong> Session timeout, relogin!.
                      </div>";
            $this->session->set_flashdata("message", $error);
            redirect("admin/login", "refresh");
        }
        $this->load->model('Users_model');
        $this->load->model('Common_model');
        $this->load->model('Vendorwallet_model');
        $this->load->model('Wallet_model');
        $this->load->model('Vendorwallethistory_model');
        $this->load->library('Userpermission');
    }

    public function vendor() {
        $data["pageTitle"] = "Vendor's Wallet";
        $this->load->view("admin/wallet/vendorwallet_list", $data);
    }

    public function shipping() {
        $data["pageTitle"] = "Shipping Wallet";
        //$data['shipeprs'] = $this->Common_model->getAll("shipping_vendor")->result_array();
        $shipeprs = $this->Common_model->getAll("shipping_vendor")->result();

        $i = 0;
        foreach ($shipeprs as $ship) {
           // $pending = $this->db->query("select ifnull(sum(shipping_cost),0) as total from orders where orders_status=4 and shipping_payment_status= 'Pending'")->row();
            //$available = $this->db->query("select ifnull(sum(shipping_cost),0) as total from orders where orders_status=4 and shipping_payment_status= 'Available'")->row_array()['total'];
            //$settled = $this->db->query("select ifnull(sum(shipping_cost),0) as total from orders where orders_status=4 and shipping_payment_status= 'Settled'")->row_array()['total'];
            //$hold = $this->db->query("select ifnull(sum(shipping_cost),0) as total from orders where orders_status=4 and shipping_payment_status= 'Hold'")->row_array()['total'];

            //Pending 
            $this->db->select('ifnull(sum(a.shipping_cost),0)pending_sum');
            $this->db->from('orders a');
            $this->db->join('order_shipping b', 'a.orders_id=b.orders_id');
            $this->db->where('a.orders_status', 4);
            $this->db->where('a.shipping_payment_status', 'Pending');
            $this->db->where('b.ship_vendor_id', $ship->id);
            $pending_q = $this->db->get()->row();
            $pending = $pending_q->pending_sum;

            //Available 
            $this->db->select('ifnull(sum(a.shipping_cost),0)available_sum');
            $this->db->from('orders a');
            $this->db->join('order_shipping b', 'a.orders_id=b.orders_id');
            $this->db->where('a.orders_status', 4);
            $this->db->where('a.shipping_payment_status', 'Available');
            $this->db->where('b.ship_vendor_id', $ship->id);
            $available_q = $this->db->get()->row();
            $available = $available_q->available_sum;

            //Settled 
            $this->db->select('ifnull(sum(a.shipping_cost),0)settled_sum');
            $this->db->from('orders a');
            $this->db->join('order_shipping b', 'a.orders_id=b.orders_id');
            $this->db->where('a.orders_status', 4);
            $this->db->where('a.shipping_payment_status', 'Settled');
            $this->db->where('b.ship_vendor_id', $ship->id);
            $settled_q = $this->db->get()->row();
            $settled = $settled_q->settled_sum;

            //Settled 
            $this->db->select('ifnull(sum(a.shipping_cost),0)hold_sum');
            $this->db->from('orders a');
            $this->db->join('order_shipping b', 'a.orders_id=b.orders_id');
            $this->db->where('a.orders_status', 4);
            $this->db->where('a.shipping_payment_status', 'Hold');
            $this->db->where('b.ship_vendor_id', $ship->id);
            $hold_q = $this->db->get()->row();
            $hold = $hold_q->hold_sum;

            $dat[$i]['id'] = $ship->id;
            $dat[$i]['vendor_name'] = $ship->vendor_name;
            $dat[$i]['pending'] = $pending;
            $dat[$i]['available'] = $available;
            $dat[$i]['settled'] = $settled;
            $dat[$i]['hold'] = $hold;
            $i++;
        }
        $data['shipeprs'] = $dat;
        $this->load->view("admin/wallet/shippingwallet_list", $data);
    }

    public function shipping_pending_payments($ship_id) {
        $data["pageTitle"] = "Shipping Partner's Pending Payments";
        
        $this->db->select('a.orders_id,a.shipping_cost,a.shipping_subtotal,a.shipping_gst,a.order_price,a.shipping_payment_status');
        $this->db->from('orders a');
        $this->db->join('order_shipping b', 'a.orders_id=b.orders_id');
        $this->db->where('a.orders_status', 4);
        $this->db->where('a.shipping_payment_status', 'Pending');
        $this->db->where('b.ship_vendor_id',$ship_id);
        $data['allhistory']= $this->db->get()->result_array();
        
        //$data['allhistory'] = $this->db->query("select orders_id,shipping_cost,shipping_subtotal,shipping_gst,order_price,shipping_payment_status from orders where orders_status=4 and shipping_payment_status= 'Pending'")->result_array();
        $this->load->view("admin/wallet/shippingpayment_list", $data);
    }

    public function shipping_available_payments($ship_id) {
        $data["pageTitle"] = "Shipping Partner's Available Payments";
        
        $this->db->select('a.orders_id,a.shipping_cost,a.shipping_subtotal,a.shipping_gst,a.order_price,a.shipping_payment_status');
        $this->db->from('orders a');
        $this->db->join('order_shipping b', 'a.orders_id=b.orders_id');
        $this->db->where('a.orders_status', 4);
        $this->db->where('a.shipping_payment_status', 'Available');
        $this->db->where('b.ship_vendor_id',$ship_id);
        $data['allhistory']= $this->db->get()->result_array();
        
        //$data['allhistory'] = $this->db->query("select orders_id,shipping_cost,shipping_subtotal,shipping_gst,order_price,shipping_payment_status from orders where orders_status=4 and shipping_payment_status= 'Available'")->result_array();
        $this->load->view("admin/wallet/shippingpayment_list", $data);
    }

    public function shipping_settled_payments($ship_id) {
        $data["pageTitle"] = "Shipping Partner's Settled Payments";
       
        $this->db->select('a.orders_id,a.shipping_cost,a.shipping_subtotal,a.shipping_gst,a.order_price,a.shipping_payment_status');
        $this->db->from('orders a');
        $this->db->join('order_shipping b', 'a.orders_id=b.orders_id');
        $this->db->where('a.orders_status', 4);
        $this->db->where('a.shipping_payment_status', 'Settled');
        $this->db->where('b.ship_vendor_id',$ship_id);
        $data['allhistory']= $this->db->get()->result_array();
        
       // $data['allhistory'] = $this->db->query("select orders_id,shipping_cost,shipping_subtotal,shipping_gst,order_price,shipping_payment_status from orders where orders_status=4 and shipping_payment_status= 'Settled'")->result_array();
        $this->load->view("admin/wallet/shippingpayment_list", $data);
    }

    public function shipping_hold_payments($ship_id) {
        $data["pageTitle"] = "Shipping Partner's Hold Payments";
        
        $this->db->select('a.orders_id,a.shipping_cost,a.shipping_subtotal,a.shipping_gst,a.order_price,a.shipping_payment_status');
        $this->db->from('orders a');
        $this->db->join('order_shipping b', 'a.orders_id=b.orders_id');
        $this->db->where('a.orders_status', 4);
        $this->db->where('a.shipping_payment_status', 'Hold');
        $this->db->where('b.ship_vendor_id',$ship_id);
        $data['allhistory']= $this->db->get()->result_array();
        
        //$data['allhistory'] = $this->db->query("select orders_id,shipping_cost,shipping_subtotal,shipping_gst,order_price,shipping_payment_status from orders where orders_status=4 and shipping_payment_status= 'Hold'")->result_array();
        $this->load->view("admin/wallet/shippingpayment_list", $data);
    }

    public function fetch_vendors() {
        $columns = array(
            0 => 'id',
            1 => 'username',
            2 => 'first_name',
            3 => 'last_name',
            4 => 'email',
            5 => 'phone'
        );

        $limit = $this->input->post('length');
        $start = $this->input->post('start');
        $order = $columns[$this->input->post('order')[0]['column']];
        //$dir = $this->input->post('order')[0]['dir'];
        $dir = "desc";

        $totalData = $this->Vendorwallet_model->allvendors_count();

        $totalFiltered = $totalData;

        if (empty($this->input->post('search')['value'])) {
            $vendors = $this->Vendorwallet_model->allwallet($limit, $start, $order, $dir);
        } else {
            $search = $this->input->post('search')['value'];

            $vendors = $this->Vendorwallet_model->wallet_search($limit, $start, $search, $order, $dir);

            $totalFiltered = $this->Vendorwallet_model->wallet_search_count($search);
        }

        $data = array();
        if (!empty($vendors)) {
            foreach ($vendors as $vdr) {
                $nestedData['id'] = "ATZ" . $vdr->id;
                $nestedData['name'] = $vdr->first_name . " " . $vdr->last_name;
                $nestedData['username'] = $vdr->username;
                $nestedData['email'] = $vdr->email;
                $nestedData['phone'] = $vdr->phone;
                $nestedData['available'] = "<a target='new' href='" . base_url('admin/wallet/wallet_history/available/' . $vdr->id) . "' class='badge badge-success'>" . $vdr->available_balance . "</a>";
                $nestedData['pending'] = "<a target='new' href='" . base_url('admin/wallet/wallet_history/pending/' . $vdr->id) . "' class='badge badge-warning'>" . $vdr->pending_balance . "</a>";
                $nestedData['hold'] = "<a target='new' href='" . base_url('admin/wallet/wallet_history/hold/' . $vdr->id) . "' class='badge badge-danger'>" . $vdr->hold_balance . "</a>";
                $nestedData['settled'] = "<a target='new' href='" . base_url('admin/wallet/wallet_history/settled/' . $vdr->id) . "' class='badge badge-primary'>" . $vdr->settled_balance . "</a>";

                $data[] = $nestedData;
            }
        }

        $json_data = array(
            "draw" => intval($this->input->post('draw')),
            "recordsTotal" => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data" => $data
        );

        echo json_encode($json_data);
    }

    function wallet_history($status, $vendor_id) {
        $data['vendor_id'] = $vendor_id;
        $data['status'] = $status;
        $data["pageTitle"] = "Vendor's Wallet History Of Pending Amount";
        $this->load->view("admin/wallet/vendorwallet_history", $data);
    }

    function fetch_wallet_history() {

        $columns = array(
            0 => 'order_id',
            1 => 'amount',
            2 => 'type',
            3 => 'date',
        );

        $limit = $this->input->post('length');
        $start = $this->input->post('start');
        $order = $columns[$this->input->post('order')[0]['column']];
        //$dir = $this->input->post('order')[0]['dir'];
        $dir = "desc";

        $totalData = $this->Vendorwallethistory_model->allhostory_count();

        $totalFiltered = $totalData;

        if (empty($this->input->post('search')['value'])) {
            $vendors = $this->Vendorwallethistory_model->allhistory($limit, $start, $order, $dir);
        } else {
            $search = $this->input->post('search')['value'];

            $vendors = $this->Vendorwallethistory_model->history_search($limit, $start, $search, $order, $dir);

            $totalFiltered = $this->Vendorwallethistory_model->history_search_count($search);
        }

        $data = array();
        if (!empty($vendors)) {
            $totalamount = 0;
            foreach ($vendors as $vdr) {
                $nestedData['orderid'] = "<a href='" . base_url() . "admin/order/view/" . $vdr->order_id . "' target='new' class='badge badge-primary'>" . "ORD" . $vdr->order_id . '</a>';
                $nestedData['amount'] = $vdr->amount;
                $totalamount = $totalamount + $vdr->amount;
                $nestedData['status'] = $vdr->type;
                $nestedData['dateadded'] = $vdr->date;
                $data[] = $nestedData;
            }
        }

        $json_data = array(
            "draw" => intval($this->input->post('draw')),
            "recordsTotal" => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data" => $data,
            "total" => $totalamount
        );

        echo json_encode($json_data);
    }

    public function buyers_wallet() {
        $data["pageTitle"] = "Byers's Wallet";
        $this->load->view("admin/wallet/buyers_wallet_list", $data);
    }

    public function get_buyers_wallet() {
        $result = $this->Wallet_model->get_datatables_for_wallet();

        $data = array();
        $no = $this->input->post('start');
        $sr_no = 1;
        foreach ($result as $res) {
            $no++;


            $row = array();
            $row[] = $sr_no;
            $row[] = $res->first_name . ' ' . $res->last_name;
            $row[] = $res->phone;
            $row[] = $res->balance;
            $row[] = '<a href="buyers_wallet_history/' . $res->user_id . '"><button class="btn btn-primary btn-sm" >History </button></a>';

            $data[] = $row;
            $sr_no++;
        }


        $output = array(
            "draw" => $this->input->post('draw'),
            "recordsTotal" => $this->Wallet_model->count_all(),
            "recordsFiltered" => $this->Wallet_model->count_filtered_for_user(),
            "data" => $data,
        );
        echo json_encode($output);
    }

    public function buyers_wallet_history($id) {

        $data["pageTitle"] = "Byers's Wallet";
        $data["user_id"] = $id;
        $this->load->view("admin/wallet/buyers_wallet_history", $data);
    }

    public function get_buyers_wallet_history($user_id) {
        $data["pageTitle"] = "Byers's Wallet";
        $result = $this->Wallet_model->get_datatables_for_walletHistory($user_id);

        $data = array();
        $no = $this->input->post('start');
        $sr_no = 1;
        foreach ($result as $res) {
            $no++;

            $row = array();
            $row[] = $sr_no;
            $row[] = $res->amount;
            $row[] = $res->transaction_type;
            $row[] = $res->against;
            $row[] = $res->referrence;
            $row[] = $res->remark;
            $row[] = $res->created;
            $row[] = $res->first_name . ' ' . $res->last_name;

            $data[] = $row;
            $sr_no++;
        }


        $output = array(
            "draw" => $this->input->post('draw'),
            "recordsTotal" => $this->Wallet_model->count_allHistory($user_id),
            "recordsFiltered" => $this->Wallet_model->count_filtered_history($user_id),
            "data" => $data,
        );
        echo json_encode($output);
    }

}
