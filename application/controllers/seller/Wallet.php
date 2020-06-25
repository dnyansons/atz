<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Wallet extends CI_Controller 
{
    public function __construct() 
    {
        parent::__construct();
        if (!$this->session->userdata("user_logged_in") || $this->session->userdata("user_role")!="seller") {
            $error = "<div id='login-error' class='form-error notice notice-error'><span class='icon-notice icon-error'></span><span><strong>Error!</strong> Session timeout, relogin!. </span></div>";
            $this->session->set_flashdata("message", $error);
            redirect("login", "refresh");
        }

        $this->load->model('Wallet_model');
        $this->load->model('Order_model');

    }

    public function all() 
    {
        $this->load->view("user/wallet/all_list");
    }


    public function ajax_list_all() 
    {
        $columns = array(
            0 => 'orders_id',
            1 => 'delivery_date',
            2 => 'order_amount'
        );

        $limit = $this->input->post('length');
        $start = $this->input->post('start');
        $order = $columns[$this->input->post('order')[0]['column']];
        $dir = $this->input->post('order')[0]['dir'];

        $totalData = $this->Wallet_model->allwallet_count();

        $totalFiltered = $totalData;

        if (empty($this->input->post('search')['value']))
        {
            $wallet = $this->Wallet_model->allwallet($limit, $start, $order, $dir);
        }

        else
        {
            $search = $this->input->post('search')['value'];
            $wallet = $this->Wallet_model->wallet_search($limit, $start, $search, $order, $dir);
            $totalFiltered = $this->Wallet_model->wallet_search_count($search);
        }

        $data = array();

        if(!empty($wallet))
        {
            foreach ($wallet as $wall)
            {
                $nestedData['orders_id'] = $wall->orders_id;
                $nestedData['delivery_date'] = $wall->delivery_date;
                $nestedData['order_amount'] = $wall->order_amount;
                
                if($wall->wallet_transaction_status!="Initiated" && $wall->wallet_transaction_status!="Completed" && $wall->wallet_transaction_status!="Rejected")
                {
                    $nestedData['action'] = '<a href="'.base_url().'admin/wallet/withdraw/'.$wall->orders_id.'" class="tabledit-edit-button btn btn-primary waves-effect waves-light btn-sm" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit"><i class="fa fa-yelp"></i>Request for withdraw</a>';
                }

                else if($wall->wallet_transaction_status=="Initiated")
                {
                    $nestedData['action'] = 'Already Requested';
                }
                                                                

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


    public function initiated() 
    {
        $this->load->view("user/wallet/initiated_list");
    }


    public function ajax_list_initiated() 
    {
        $columns = array(
            0 => 'orders_id',
            1 => 'delivery_date',
            2 => 'order_amount'
        );

        $limit = $this->input->post('length');
        $start = $this->input->post('start');
        $order = $columns[$this->input->post('order')[0]['column']];
        $dir = $this->input->post('order')[0]['dir'];

        $totalData = $this->Wallet_model->allwallet_count();

        $totalFiltered = $totalData;

        if (empty($this->input->post('search')['value']))
        {
            $wallet = $this->Wallet_model->allwallet($limit, $start, $order, $dir);
        }

        else
        {
            $search = $this->input->post('search')['value'];
            $wallet = $this->Wallet_model->wallet_search($limit, $start, $search, $order, $dir);
            $totalFiltered = $this->Wallet_model->wallet_search_count($search);
        }

        $data = array();

        if(!empty($wallet))
        {
            foreach ($wallet as $wall)
            {
                $nestedData['orders_id'] = $wall->orders_id;
                $nestedData['delivery_date'] = $wall->delivery_date;
                $nestedData['order_amount'] = $wall->order_amount;

                //echo $wall->wallet_transaction_status;exit;

                if($wall->wallet_transaction_status!="Initiated" && $wall->wallet_transaction_status!="Completed" && $wall->wallet_transaction_status!="Rejected")
                {
                    $nestedData['action'] = '<a href="'.base_url().'admin/wallet/withdraw/'.$wall->orders_id.'" class="tabledit-edit-button btn btn-primary waves-effect waves-light btn-sm" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit"><i class="fa fa-yelp"></i>Request for withdraw</a>';
                }

                else if($wall->wallet_transaction_status=="Initiated")
                {
                    $nestedData['action'] = 'Already Requested';
                }

                
                                                                

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


    public function completed() 
    {
        $this->load->view("user/wallet/completed_list");
    }

    public function rejected() 
    {
        $this->load->view("user/wallet/rejected_list");
    }

    public function onhold() 
    {
        $this->load->view("user/wallet/onhold_list");
    }





}
