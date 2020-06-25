<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Payment_trasaction extends CI_Controller {

    public function __construct() 
    {
        parent::__construct();
        if (!$this->session->userdata("admin_logged_in")) {
            $error = "<div class='alert alert-danger alert-dismissible'>
                        <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                        <strong>Error!</strong> Session timeout, relogin!.
                      </div>";
            $this->session->set_flashdata("message", $error);
            redirect("admin/login", "refresh");
        }
        $this->load->library("Datatables");
        $this->load->library('table');
        $this->load->model('Payment_transaction_model');
        $this->load->model('adminusers_model', 'adminusers_model');
        $this->load->library('Userpermission');
    }

    public function index() {
        $this->load->view("admin/payment/list");
    }

    public function ajax_list() {
        $columns = array(
            0 => 'id',
            1 => 'orders_id',
            2 => 'user_id',
            3 => 'email',
            4 => 'amount',
            5 => 'status',
            6 => 'method',
            7 => 'payment_id',
            8 => 'created_at'
        );

        $limit = $this->input->post('length');
        $start = $this->input->post('start');
        $order = $columns[$this->input->post('order')[0]['column']];
        $dir = $this->input->post('order')[0]['dir'];

        $totalData = $this->Payment_transaction_model->allpay_count();

        $totalFiltered = $totalData;

        if (empty($this->input->post('search')['value'])) {
            $payment = $this->Payment_transaction_model->allpay($limit, $start, $order, $dir);
        } else {
            $search = $this->input->post('search')['value'];

            $payment = $this->Payment_transaction_model->pay_search($limit, $start, $search, $order, $dir);

            $totalFiltered = $this->Payment_transaction_model->pay_search_count($search);
        }

        $data = array();
        if (!empty($payment)) {
            foreach ($payment as $br) {
                $nestedData['id'] = $br->id;
                $nestedData['orders_id'] = $br->orders_id;
                $nestedData['user_id'] = $br->user_id;
                $nestedData['email'] = $br->email;
                $nestedData['amount'] = $br->amount;
                $nestedData['status'] = $br->status;
                $nestedData['method'] = $br->method;
                $nestedData['payment_id'] = $br->payment_id;
                $nestedData['created_at'] = date('Y-m-d H:i:s', $br->created_at);

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

}
