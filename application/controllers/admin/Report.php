<?php

defined('BASEPATH') OR exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;

class Report extends CI_Controller {

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
        $this->load->model('Common_model');
        $this->load->model('Salesreport_model');
        $this->load->model('Shippingreport_model');
        $this->load->model('Commissionreport_model');
        $this->load->model('Nonsettlereport_model');
        $this->load->model('Refundreport_model');
        $this->load->model('Returnreport_model');
        $this->load->library('Userpermission');
    }

    public function sale_report() {
        $data['statuses'] = $this->Common_model->getAll("orders_status")->result_array();
        $this->load->view("admin/report/sales_report", $data);
    }

    public function shipping_report() {
        $data['statuses'] = $this->Common_model->getAll("orders_status")->result_array();
        $this->load->view("admin/report/shipping_report", $data);
    }

    public function refund_report() {
        $data['statuses'] = $this->Common_model->getAll("orders_status")->result_array();
        $this->load->view("admin/report/refund_report", $data);
    }
    
    public function return_report() {
        $data['statuses'] = $this->Common_model->getAll("orders_status")->result_array();
        $this->load->view("admin/report/return_report", $data);
    }

    public function settlement_report() {
        $this->load->view("admin/report/settlement_report", $data);
    }

    public function non_settled_report() {
        $this->load->view("admin/report/non_settlement_report", $data);
    }

    public function commission_report() {
        $data['statuses'] = $this->Common_model->getAll("orders_status")->result_array();
        $this->load->view("admin/report/commission_report", $data);
    }

    public function profit_loss_report() {
        $data['statuses'] = $this->Common_model->getAll("orders_status")->result_array();
        $this->load->view("admin/report/pfofit_loss_report", $data);
    }

    public function fetch_sales_report() {

        $columns = array(
            0 => '',
            1 => 'a.date_purchased',
            2 => 'e.payment_id',
            3 => 'a.orders_id',
            4 => 'a.seller_id',
            5 => 'b.first_name',
            6 => 'b.phone',
            7 => 'a.orders_status',
            8 => 'a.shipping_cost',
            9 => 'a.vendor_payable_price',
            10 => '',
            11 => 'a.order_price',
            12 => '',
            13 => '',
            14 => ''
        );

        $limit = $this->input->post('length');
        $start = $this->input->post('start');
        $order = $columns[$this->input->post('order')[0]['column']];
        $dir = $this->input->post('order')[0]['dir'];
        //$dir ="desc";

        $totalData = $this->Salesreport_model->allsales_count();

        $totalFiltered = $totalData;

        if (empty($this->input->post('search')['value'])) {
            $vendors = $this->Salesreport_model->allsales($limit, $start, $order, $dir);
        } else {
            $search = $this->input->post('search')['value'];

            $vendors = $this->Salesreport_model->wallet_search($limit, $start, $search, $order, $dir);

            $totalFiltered = $this->Salesreport_model->wallet_search_count($search);
        }

        $data = array();
        if (!empty($vendors)) {
            $i = 0;
            foreach ($vendors as $vdr) {

                $nestedData['sr_no'] = $i += 1;
                $nestedData['datepurchased'] = $vdr->date_purchased;
                // old date('Y-m-d',strtotime($vdr->date_purchased));
                $nestedData['trans_id'] = $vdr->payment_id;
                $nestedData['order_id'] = '<a target="new" href="' . base_url('admin/order/view/' . str_replace("ORD", '', $vdr->orders_id)) . '" class="badge badge-primary" >' . $vdr->orders_id . '</a>';
                $nestedData['vendor_id'] = '<a target="new" href="' . base_url('admin/users/user_view/' . str_replace("ATZ", '', $vdr->seller_id)) . '" class="link link-primary" >' . $vdr->seller_id . '</a>';
                $nestedData['vendor_name'] = $vdr->vendorname;
                $nestedData['vendor_mobile'] = $vdr->vendorphone;
                $nestedData['order_status'] = $vdr->orders_status_name;
                $nestedData['shipping_cost'] = $vdr->shipping_cost;
                $nestedData['vendor_cost'] = $vdr->vendor_payable_price;
                $nestedData['atz_cost'] = ($vdr->order_price - $vdr->shipping_cost);
                $nestedData['order_amount'] = $vdr->order_price;
                $nestedData['buyer_name'] = $vdr->buyername;
                $nestedData['buyer_email'] = $vdr->buyeremail;
                $nestedData['buyer_mobile'] = $vdr->buyerphone;
                $nestedData['commission'] = $vdr->commission;
                $nestedData['gst'] = $vdr->gst;

                $data[] = $nestedData;
            }
        }

        $json_data = array(
            "draw" => intval($this->input->post('draw')),
            "recordsTotal" => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data" => $data
                //'query' => $this->db->last_query() //commented by Yogesh Pardeshi No Need 
        );

        echo json_encode($json_data);
    }

    public function fetch_comission_report() {

        $columns = array(
            0 => '',
            1 => 'a.seller_id',
            2 => 'b.first_name',
            3 => 'a.orders_id',
            4 => 'a.date_purchased',
            5 => 'a.delivery_date',
            6 => 'a.order_price',
            7 => 'a.vendor_payable_price',
            8 => '',
            9 => '',
            10 => ''
        );

        $limit = $this->input->post('length');
        $start = $this->input->post('start');
        $order = $columns[$this->input->post('order')[0]['column']];
        $dir = $this->input->post('order')[0]['dir'];
        //$dir ="desc";

        $totalData = $this->Commissionreport_model->allcommission_count();

        $totalFiltered = $totalData;

        if (empty($this->input->post('search')['value'])) {
            $vendors = $this->Commissionreport_model->allcommission($limit, $start, $order, $dir);
        } else {
            $search = $this->input->post('search')['value'];

            $vendors = $this->Commissionreport_model->commission_search($limit, $start, $search, $order, $dir);

            $totalFiltered = $this->Commissionreport_model->commission_search_count($search);
        }

        $data = array();
        if (!empty($vendors)) {
            $i = 0;
            foreach ($vendors as $vdr) {
                $nestedData['sr_no'] = $i += 1;
                $nestedData['vendor_id'] = '<a target="new" href="' . base_url('admin/users/user_view/' . str_replace("ATZ", '', $vdr->seller_id)) . '" class="link link-primary" >' . $vdr->seller_id . '</a>';
                $nestedData['vendor_name'] = $vdr->vendorname;
                $nestedData['order_id'] = '<a target="new" href="' . base_url('admin/order/view/' . str_replace("ORD", '', $vdr->orders_id)) . '" class="link link-primary" >' . $vdr->orders_id . '</a>';
                $nestedData['datepurchased'] = $vdr->date_purchased;
                $nestedData['datedelivered'] = $vdr->delivery_date;
                $nestedData['total_amount'] = $vdr->order_price;
                $nestedData['payable_amount'] = $vdr->vendor_payable_price;
                $nestedData['commission'] = $vdr->commission;
                $nestedData['gst'] = $vdr->gst;
                $deduction = $vdr->commission + $vdr->gst;
                $nestedData['total_deduction'] = $deduction;
                $nestedData['datesettled'] = $vdr->settled_date;
                $nestedData['remark'] = $vdr->remark;
                $data[] = $nestedData;
            }
        }

        $json_data = array(
            "draw" => intval($this->input->post('draw')),
            "recordsTotal" => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data" => $data,
            'query' => $this->db->last_query()
        );

        echo json_encode($json_data);
    }

    public function fetch_return_report() {

        $columns = array(
            0 => '',
            1 => '',
            2 => 'b.return_orders_id',
            3 => 'a.orders_id',
            4 => 'a.user_name',
            5 => 'a.pick_name',
            6 => 'a.shippment_type',
            7 => 'a.order_price',
            8 => 'b.return_order_price',
            9 => 'b.return_shipping_cost',
            10 => 'a.user_telephone',
            11 => 'c.orders_status_name',
            12 => 'a.return_date',
            13 => 'd.ship_vendor_id'
        );

        $limit = $this->input->post('length');
        $start = $this->input->post('start');
        $order = $columns[$this->input->post('order')[0]['column']];
        $dir = $this->input->post('order')[0]['dir'];
        //$dir ="desc";

        $totalData = $this->Returnreport_model->allreturn_count();

        $totalFiltered = $totalData;

        if (empty($this->input->post('search')['value'])) {
            $vendors = $this->Returnreport_model->allreturn($limit, $start, $order, $dir);
            // echo $this->db->last_query();
        } else {
            $search = $this->input->post('search')['value'];
            $vendors = $this->Returnreport_model->return_search($limit, $start, $search, $order, $dir);
            $totalFiltered = $this->Returnreport_model->return_search_count($search);
        }

        $data = array();
        if (!empty($vendors)) {
            $i = 0;
            foreach ($vendors as $vdr) {
                if($vdr->ship_vendor_id==2)
                {
                    $ship_method='ShipRocket';
                }else{
                     $ship_method='BlueDart';
                }
                $nestedData['sr_no'] = $i += 1;
                $nestedData['action'] = '<a class="btn btn-sm btn-success" target="new" href="'.base_url().'admin/return_orders/view_return_request/'.$vdr->return_orders_id.'" >View</a>';
                $nestedData['return_orders_id'] ='RETORD'.$vdr->return_orders_id;
                $nestedData['orders_id'] = '<a target="new" href="' . base_url('admin/order/view/' . str_replace("ORD", '', $vdr->orders_id)) . '" class="LINK LINK-PRIMARY" >#ORD' . $vdr->orders_id . '</a>';
                $nestedData['user_name'] = $vdr->user_name;
                $nestedData['pick_name'] = $vdr->pick_name;
                $nestedData['shippment_type'] = $vdr->shippment_type;
                $nestedData['order_price'] = $vdr->order_price;
                $nestedData['return_order_price'] = $vdr->return_order_price;
                $nestedData['return_shipping_cost'] = $vdr->return_shipping_cost;
                $nestedData['user_telephone'] = $vdr->user_telephone;
                $nestedData['orders_status_name'] = $vdr->orders_status_name;
                $nestedData['return_date'] = $vdr->return_date;
                $nestedData['ship_vendor_id'] = $ship_method;
                $data[] = $nestedData;
            }
        }

        $json_data = array(
            "draw" => intval($this->input->post('draw')),
            "recordsTotal" => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data" => $data,
            'query' => $this->db->last_query()
        );

        echo json_encode($json_data);
    }
    public function fetch_shipping_report() {

        $columns = array(
            0 => '',
            1 => 'a.orders_id',
            2 => 'c.vendor_name',
            3 => 'a.date_purchased',
            4 => 'a.delivery_date',
            5 => 'a.order_price',
            6 => 'a.shipping_cost',
            7 => 'a.shippment_type',
        );

        $limit = $this->input->post('length');
        $start = $this->input->post('start');
        $order = $columns[$this->input->post('order')[0]['column']];
        $dir = $this->input->post('order')[0]['dir'];
        //$dir ="desc";

        $totalData = $this->Shippingreport_model->allshipping_count();

        $totalFiltered = $totalData;

        if (empty($this->input->post('search')['value'])) {
            $vendors = $this->Shippingreport_model->allshipping($limit, $start, $order, $dir);
            // echo $this->db->last_query();
        } else {
            $search = $this->input->post('search')['value'];

            $vendors = $this->Shippingreport_model->shipping_search($limit, $start, $search, $order, $dir);

            $totalFiltered = $this->Shippingreport_model->shipping_search_count($search);
        }

        $data = array();
        if (!empty($vendors)) {
            $i = 0;
            foreach ($vendors as $vdr) {
                $nestedData['sr_no'] = $i += 1;
                $nestedData['order_id'] = '<a target="new" href="' . base_url('admin/order/view/' . str_replace("ORD", '', $vdr->orders_id)) . '" class="link link-primary" >#ORD' . $vdr->orders_id . '</a>';
                $nestedData['vendor_name'] = $vdr->vendor_name;
                $nestedData['datepurchased'] = $vdr->date_purchased;
                $nestedData['datedelivered'] = $vdr->delivery_date;
                $nestedData['total_amount'] = $vdr->order_price;
                $nestedData['shipping_cost'] = $vdr->shipping_cost;
                $nestedData['shippment_type'] = $vdr->ship;

                $data[] = $nestedData;
            }
        }

        $json_data = array(
            "draw" => intval($this->input->post('draw')),
            "recordsTotal" => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data" => $data,
            'query' => $this->db->last_query()
        );

        echo json_encode($json_data);
    }

    public function fetch_refund_report() {

        $columns = array(
            0 => '',
            1 => 'b.first_name',
            2 => 'b.phone',
            3 => 'a.amount',
            4 => 'a.transaction_type',
            5 => 'a.remark',
            6 => 'a.created',
        );

        $limit = $this->input->post('length');
        $start = $this->input->post('start');
        $order = $columns[$this->input->post('order')[0]['column']];
        $dir = $this->input->post('order')[0]['dir'];
        //$dir ="desc";

        $totalData = $this->Refundreport_model->allrefund_count();

        $totalFiltered = $totalData;

        if (empty($this->input->post('search')['value'])) {
            $vendors = $this->Refundreport_model->allrefund($limit, $start, $order, $dir);
            // echo $this->db->last_query();
        } else {
            $search = $this->input->post('search')['value'];

            $vendors = $this->Refundreport_model->refund_search($limit, $start, $search, $order, $dir);

            $totalFiltered = $this->Refundreport_model->refund_search_count($search);
        }

        $data = array();
        if (!empty($vendors)) {
            $i = 0;
            foreach ($vendors as $vdr) {
                $nestedData['sr_no'] = $i += 1;

                $nestedData['first_name'] =$vdr->first_name;;
                $nestedData['phone'] = $vdr->phone;
                $nestedData['amount'] = $vdr->amount;
                $nestedData['transaction_type'] = $vdr->transaction_type;
                $nestedData['remark'] = $vdr->remark;
                $nestedData['created'] = $vdr->created;

                $data[] = $nestedData;
            }
        }

        $json_data = array(
            "draw" => intval($this->input->post('draw')),
            "recordsTotal" => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data" => $data,
            'query' => $this->db->last_query()
        );

        echo json_encode($json_data);
    }

    public function fetch_nonsettled_report() {

        $columns = array(
            0 => '',
            1 => 'a.seller_id',
            2 => 'b.first_name',
            3 => 'a.orders_id',
            4 => 'a.date_purchased',
            5 => 'a.delivery_date',
            6 => 'a.order_price',
            7 => 'a.vendor_payable_price',
            8 => '',
            9 => '',
            10 => ''
        );

        $limit = $this->input->post('length');
        $start = $this->input->post('start');
        $order = $columns[$this->input->post('order')[0]['column']];
        $dir = $this->input->post('order')[0]['dir'];
        //$dir ="desc";

        $totalData = $this->Nonsettlereport_model->allcommission_count();

        $totalFiltered = $totalData;

        if (empty($this->input->post('search')['value'])) {
            $vendors = $this->Nonsettlereport_model->allcommission($limit, $start, $order, $dir);
        } else {
            $search = $this->input->post('search')['value'];

            $vendors = $this->Nonsettlereport_model->commission_search($limit, $start, $search, $order, $dir);

            $totalFiltered = $this->Nonsettlereport_model->commission_search_count($search);
        }

        $data = array();
        if (!empty($vendors)) {
            $i = 0;
            foreach ($vendors as $vdr) {
                $nestedData['sr_no'] = $i += 1;
                $nestedData['vendor_id'] = '<a target="new" href="' . base_url('admin/users/user_view/' . str_replace("ATZ", '', $vdr->seller_id)) . '" class="link link-primary" >' . $vdr->seller_id . '</a>';
                $nestedData['vendor_name'] = $vdr->vendorname;
                $nestedData['order_id'] = '<a target="new" href="' . base_url('admin/order/view/' . str_replace("ORD", '', $vdr->orders_id)) . '" class="link link-primary" >' . $vdr->orders_id . '</a>';
                $nestedData['datepurchased'] = $vdr->date_purchased;
                $nestedData['datedelivered'] = $vdr->delivery_date;
                $nestedData['total_amount'] = $vdr->order_price;
                $nestedData['payable_amount'] = $vdr->vendor_payable_price;
                $nestedData['commission'] = $vdr->commission;
                $nestedData['gst'] = $vdr->gst;
                $deduction = $vdr->commission + $vdr->gst;
                $nestedData['total_deduction'] = $deduction;
                $nestedData['datesettled'] = $vdr->settled_date;
                $nestedData['remark'] = $vdr->remark;
                $data[] = $nestedData;
            }
        }

        $json_data = array(
            "draw" => intval($this->input->post('draw')),
            "recordsTotal" => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data" => $data,
            'query' => $this->db->last_query()
        );

        echo json_encode($json_data);
    }

    public function fetch_profitloss_report() {
        
        $columns = array(
            0 => '',
            1 => 'a.seller_id',
            2 => 'b.first_name',
            3 => 'a.orders_id',
            4 => 'a.date_purchased',
            5 => 'a.delivery_date',
            6 => 'a.order_price',
            7 => 'a.vendor_payable_price',
            8 => '',
            9 => '',
            10 => ''
        );

        $limit = $this->input->post('length');
        $start = $this->input->post('start');
        $order = $columns[$this->input->post('order')[0]['column']];
        $dir = $this->input->post('order')[0]['dir'];
        //$dir ="desc";

        $totalData = $this->Commissionreport_model->allcommission_count();

        $totalFiltered = $totalData;

        if (empty($this->input->post('search')['value'])) {
            $vendors = $this->Commissionreport_model->allcommission($limit, $start, $order, $dir);
        } else {
            $search = $this->input->post('search')['value'];

            $vendors = $this->Commissionreport_model->commission_search($limit, $start, $search, $order, $dir);

            $totalFiltered = $this->Commissionreport_model->commission_search_count($search);
        }

        $data = array();

        if (!empty($vendors)) {
            $i = 0;
            foreach ($vendors as $vdr) {
                $nestedData['sr_no'] = $i += 1;
                $nestedData['vendor_id'] = '<a target="new" href="' . base_url('admin/users/user_view/' . str_replace("ATZ", '', $vdr->seller_id)) . '" class="link link-primary" >' . $vdr->seller_id . '</a>';
                $nestedData['vendor_name'] = $vdr->vendorname;
                $nestedData['order_id'] = '<a target="new" href="' . base_url('admin/order/view/' . str_replace("ORD", '', $vdr->orders_id)) . '" class="link link-primary" >' . $vdr->orders_id . '</a>';
                $nestedData['datepurchased'] = $vdr->date_purchased;
                $nestedData['datedelivered'] = $vdr->delivery_date;
                $nestedData['total_amount'] = $vdr->order_price;
                $nestedData['payable_amount'] = $vdr->vendor_payable_price;
                $nestedData['settled'] = $vdr->settledamount;
                $nestedData['commission'] = $vdr->commission;
                $nestedData['gst'] = $vdr->gst;
                $deduction = $vdr->commission + $vdr->gst;
                $nestedData['total_deduction'] = $deduction;
                $nestedData['datesettled'] = $vdr->settled_date;

                $settled_amount = $vdr->settledamount;
                $order_price = $vdr->order_price;
                if ($order_price > $settled_amount) {
                    $pl = 'Profit';
                } elseif ($order_price < $settled_amount) {
                    $pl = "Loss";
                } elseif ($order_price == $settled_amount) {
                    $pl = "Neutral";
                } else {
                    $pl = '';
                }
                $nestedData['profitloss'] = $pl;
                $data[] = $nestedData;
            }
        }

        $json_data = array(
            "draw" => intval($this->input->post('draw')),
            "recordsTotal" => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data" => $data,
            'query' => $this->db->last_query()
        );

        echo json_encode($json_data);
    }

    public function exportProfitLossReport() {

        // $this->output->enable_profiler(true);

        $fileName = 'profitloss' . time() . '.xlsx';
        $result = $this->Commissionreport_model->allcommission($limit = '', $start = '', $col = '', $dir = '');

        if ($result) {
            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();
            $sheet->setTitle('Profit loss report');
            $sheet->setCellValue('A2', 'Profit/Loss Report ');
            $sheet->mergeCells('A2:K2');
            $sheet->getStyle("A2")->getFont()->setSize(16);
            $sheet->getStyle("A3:K3")->getFont()->setSize(12);
            $sheet->getStyle("A3:K3")->getFont()->setBold(true);
            $sheet->getStyle("A3:K3")->getFont()->setName('Calibri');
            $sheet->getStyle("A3:K3")->getFont()->getColor()->setRGB('3F7FFF');


            $sheet->setCellValue('A3', 'Sr.no');
            $sheet->setCellValue('B3', 'Vendor Id');
            $sheet->setCellValue('C3', 'Vendor Name');
            $sheet->setCellValue('D3', 'Order ID');
            $sheet->setCellValue('E3', 'Total Amount');
            $sheet->setCellValue('F3', 'Payable Amount');
            $sheet->setCellValue('G3', 'Settled Amount');
            $sheet->setCellValue('H3', 'Commission');
            $sheet->setCellValue('I3', 'GST');
            $sheet->setCellValue('J3', 'Total Commission');
            $sheet->setCellValue('K3', 'Profit/Loss');

            $rows = 4;
            $sl = 0;
            foreach ($result as $val) {
                $sl++;
                $sheet->setCellValue('A' . $rows, $sl);
                $sheet->setCellValue('B' . $rows, $val->seller_id);
                $sheet->setCellValue('C' . $rows, $val->vendorname);
                $sheet->setCellValue('D' . $rows, $val->orders_id);
                $sheet->setCellValue('E' . $rows, $val->order_price);
                $sheet->setCellValue('F' . $rows, $val->vendor_payable_price);
                $sheet->setCellValue('G' . $rows, $val->settledamount);
                $sheet->setCellValue('H' . $rows, $val->commission);
                $sheet->setCellValue('I' . $rows, $val->gst);

                $deduction = $val->commission + $val->gst;
                $sheet->setCellValue('J' . $rows, $deduction);

                $settled_amount = $val->settledamount;
                $order_price = $val->order_price;
                if ($order_price > $settled_amount) {
                    $pl = 'Profit';
                } elseif ($order_price < $settled_amount) {
                    $pl = "Loss";
                } elseif ($order_price == $settled_amount) {
                    $pl = "Neutral";
                } else {
                    $pl = '';
                }

                $sheet->setCellValue('K' . $rows, $pl);
                $rows++;
            }

            $sheet->getStyle('A2:K' . $rows)->getAlignment()->setHorizontal('center');
            $sheet->getStyle('A2:K' . $rows)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
            foreach (range('A', $sheet->getHighestDataColumn()) as $col) {
                $sheet->getColumnDimension($col)->setAutoSize(true);
            }

            $writer = new Xlsx($spreadsheet);
//            $writer->save("./uploads/report_excel/" . $fileName);
//            header("Content-Type: application/vnd.ms-excel");
//            redirect(base_url() . "uploads/report_excel/" . $fileName);
            header("Content-Type: application/vnd.ms-excel");
            header('Content-Disposition: attachment;filename="'. $fileName .'.xlsx"'); 
            header('Cache-Control: max-age=0');
            $writer->save('php://output'); // download file 
        } else {
            $error = "<div class='alert alert-danger alert-dismissible'>
                        <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                        <strong>Error!</strong> No Records Found.
                      </div>";
            $this->session->set_flashdata('message', $error);
            redirect("admin/report/profit_loss_report", "refresh");
        }
    }

    public function exportNonSettledReport() {

        // $this->output->enable_profiler(true);

        $fileName = 'NonSettledReport' . time() . '.xlsx';
        ;
        $result = $this->Nonsettlereport_model->allcommission($limit = '', $start = '', $col = '', $dir = '');

        if ($result) {
            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();
            $sheet->setTitle('Non Settled report');
            $sheet->setCellValue('A2', 'Non Settled report ');
            $sheet->mergeCells('A2:K2');
            $sheet->getStyle("A2")->getFont()->setSize(16);
            $sheet->getStyle("A3:K3")->getFont()->setSize(12);
            $sheet->getStyle("A3:K3")->getFont()->setBold(true);
            $sheet->getStyle("A3:K3")->getFont()->setName('Calibri');
            $sheet->getStyle("A3:K3")->getFont()->getColor()->setRGB('3F7FFF');


            $sheet->setCellValue('A3', 'Sr.no');
            $sheet->setCellValue('B3', 'Vendor Id');
            $sheet->setCellValue('C3', 'Vendor Name');
            $sheet->setCellValue('D3', 'Order ID');
            $sheet->setCellValue('E3', 'Order Date');
            $sheet->setCellValue('F3', 'Delivery Date');
            $sheet->setCellValue('G3', 'Total Amount');
            $sheet->setCellValue('H3', 'Total Payble Amount');
            $sheet->setCellValue('I3', 'Commission');
            $sheet->setCellValue('J3', 'GST');
            $sheet->setCellValue('K3', 'Total Deduction');

            $rows = 4;
            $sl = 0;
            foreach ($result as $val) {
                $sl++;
                $sheet->setCellValue('A' . $rows, $sl);
                $sheet->setCellValue('B' . $rows, $val->seller_id);
                $sheet->setCellValue('C' . $rows, $val->vendorname);
                $sheet->setCellValue('D' . $rows, $val->orders_id);
                $sheet->setCellValue('E' . $rows, $val->date_purchased);
                $sheet->setCellValue('F' . $rows, $val->delivery_date);
                $sheet->setCellValue('G' . $rows, $val->order_price);
                $sheet->setCellValue('H' . $rows, $val->vendor_payable_price);
                $sheet->setCellValue('I' . $rows, $val->commission);
                $sheet->setCellValue('J' . $rows, $val->gst);

                $deduction = $val->commission + $val->gst;
                $sheet->setCellValue('K' . $rows, $deduction);
                $rows++;
            }

            $sheet->getStyle('A2:K' . $rows)->getAlignment()->setHorizontal('center');
            $sheet->getStyle('A2:K' . $rows)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
            foreach (range('A', $sheet->getHighestDataColumn()) as $col) {
                $sheet->getColumnDimension($col)->setAutoSize(true);
            }

            $writer = new Xlsx($spreadsheet);
            $writer->save("./uploads/report_excel/" . $fileName);
            header("Content-Type: application/vnd.ms-excel");
            redirect(base_url() . "uploads/report_excel/" . $fileName);
        } else {
            $error = "<div class='alert alert-danger alert-dismissible'>
                        <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                        <strong>Error!</strong> No Records Found.
                      </div>";
            $this->session->set_flashdata('message', $error);
            redirect("admin/report/non_settled_report", "refresh");
        }
    }

    public function exportCommissionReport() {

        // $this->output->enable_profiler(true);

        $fileName = 'CommissionReport' . time() . '.xlsx';
        ;
        $result = $this->Commissionreport_model->allcommission($limit = '', $start = '', $col = '', $dir = '');

        if ($result) {
            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();
            $sheet->setTitle('Commission report');
            $sheet->setCellValue('A2', 'Commission report ');
            $sheet->mergeCells('A2:K2');
            $sheet->getStyle("A2")->getFont()->setSize(16);
            $sheet->getStyle("A3:K3")->getFont()->setSize(12);
            $sheet->getStyle("A3:K3")->getFont()->setBold(true);
            $sheet->getStyle("A3:K3")->getFont()->setName('Calibri');
            $sheet->getStyle("A3:K3")->getFont()->getColor()->setRGB('3F7FFF');


            $sheet->setCellValue('A3', 'SR.no');
            $sheet->setCellValue('B3', 'Vendor Id');
            $sheet->setCellValue('C3', 'Vendor Name');
            $sheet->setCellValue('D3', 'Order ID');
            $sheet->setCellValue('E3', 'Order Date');
            $sheet->setCellValue('F3', 'Delivery Date');
            $sheet->setCellValue('G3', 'Total Amount');
            $sheet->setCellValue('H3', 'Total Payble Amount');
            $sheet->setCellValue('I3', 'Commission');
            $sheet->setCellValue('J3', 'GST');
            $sheet->setCellValue('K3', 'Total Deduction');

            $rows = 4;
            $sl = 0;
            foreach ($result as $val) {
                $sl++;
                $sheet->setCellValue('A' . $rows, $sl);
                $sheet->setCellValue('B' . $rows, $val->seller_id);
                $sheet->setCellValue('C' . $rows, $val->vendorname);
                $sheet->setCellValue('D' . $rows, $val->orders_id);
                $sheet->setCellValue('E' . $rows, $val->date_purchased);
                $sheet->setCellValue('F' . $rows, $val->delivery_date);
                $sheet->setCellValue('G' . $rows, $val->order_price);
                $sheet->setCellValue('H' . $rows, $val->vendor_payable_price);
                $sheet->setCellValue('I' . $rows, $val->commission);
                $sheet->setCellValue('J' . $rows, $val->gst);

                $deduction = $val->commission + $val->gst;
                $sheet->setCellValue('K' . $rows, $deduction);
                $rows++;
            }

            $sheet->getStyle('A2:K' . $rows)->getAlignment()->setHorizontal('center');
            $sheet->getStyle('A2:K' . $rows)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
            foreach (range('A', $sheet->getHighestDataColumn()) as $col) {
                $sheet->getColumnDimension($col)->setAutoSize(true);
            }

            $writer = new Xlsx($spreadsheet);
            $writer->save("./uploads/report_excel/" . $fileName);
            header("Content-Type: application/vnd.ms-excel");
            redirect(base_url() . "uploads/report_excel/" . $fileName);
        } else {
            $error = "<div class='alert alert-danger alert-dismissible'>
                        <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                        <strong>Error!</strong> No Records Found.
                      </div>";
            $this->session->set_flashdata('message', $error);
            redirect("admin/report/commission_report", "refresh");
        }
    }

    /**
     * @auther Yogesh Pardeshi
     * generate download excel report using model
     * * */
    public function generateExcelReportSettlement() {
        $redirectNoData = 'report/settlement_report'; //redirect to show error flash data
        $this->load->model('Download_excel_model');
        $fileName = 'vendor_settlement_From_' . $this->security->xss_clean($this->input->post('datefrom')) . '_To_'
                . $this->security->xss_clean($this->input->post('dateto')) . '_DD';
        $dataRows = $this->Commissionreport_model->generateExcelReportSettlement();

        $excelColumnNames = array('Order Date', 'Order Id', 'Order Payment Id', 'Order Status', 'Product Id', 'Product name',
            'Product category', 'Buyer Name', 'Buyer Email', 'Buyer Mobile', 'buyer address',
            'pick up address',
            'Shipping Start Date', 'Vendor Id', 'vendor name', 'vendor phone',
            'shipping method', 'shipping subtotal', 'shipping gst', 'shipping cost',
            'vendor payable amount', 'commission', 'gst', 'order price',
            'delivered date', 'settled date', 'remark', 'settled amount',
            'vendor_wallet_amount'
        );

        $this->Download_excel_model->download($fileName, 'Vendor Settlement Management', $excelColumnNames,
                $dataRows, $redirectNoData);
    }

    public function exportSettlementReport() {

        // $this->output->enable_profiler(true);

        $fileName = 'Settlementreport' . time() . '.xlsx';
        ;
        $result = $this->Commissionreport_model->allcommission($limit = '', $start = '', $col = '', $dir = '');
        if ($result) {
            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();
            $sheet->setTitle('Settlement report');
            $sheet->setCellValue('A2', 'Settlement report ');
            $sheet->mergeCells('A2:M2');
            $sheet->getStyle("A2")->getFont()->setSize(16);
            $sheet->getStyle("A3:M3")->getFont()->setSize(12);
            $sheet->getStyle("A3:M3")->getFont()->setBold(true);
            $sheet->getStyle("A3:M3")->getFont()->setName('Calibri');
            $sheet->getStyle("A3:M3")->getFont()->getColor()->setRGB('3F7FFF');


            $sheet->setCellValue('A3', 'Sr.no');
            $sheet->setCellValue('B3', 'Vendor Id');
            $sheet->setCellValue('C3', 'Vendor Name');
            $sheet->setCellValue('D3', 'Order ID');
            $sheet->setCellValue('E3', 'Order Date');
            $sheet->setCellValue('F3', 'Delivery Date');
            $sheet->setCellValue('G3', 'Total Amount');
            $sheet->setCellValue('H3', 'Total Payble Amount');
            $sheet->setCellValue('I3', 'Commission');
            $sheet->setCellValue('J3', 'GST');
            $sheet->setCellValue('K3', 'Total Deduction');
            $sheet->setCellValue('L3', 'Date Settled');
            $sheet->setCellValue('M3', 'Remark');

            $rows = 4;
            $sl = 0;
            foreach ($result as $val) {
                $sl++;
                $sheet->setCellValue('A' . $rows, $sl);
                $sheet->setCellValue('B' . $rows, $val->seller_id);
                $sheet->setCellValue('C' . $rows, $val->vendorname);
                $sheet->setCellValue('D' . $rows, $val->orders_id);
                $sheet->setCellValue('E' . $rows, $val->date_purchased);
                $sheet->setCellValue('F' . $rows, $val->delivery_date);
                $sheet->setCellValue('G' . $rows, $val->order_price);
                $sheet->setCellValue('H' . $rows, $val->vendor_payable_price);
                $sheet->setCellValue('I' . $rows, $val->commission);
                $sheet->setCellValue('J' . $rows, $val->gst);

                $deduction = $val->commission + $val->gst;
                $sheet->setCellValue('K' . $rows, $deduction);
                $sheet->setCellValue('L' . $rows, $val->settled_date);
                $sheet->setCellValue('M' . $rows, $val->remark);
                $rows++;
            }

            $sheet->getStyle('A2:M' . $rows)->getAlignment()->setHorizontal('center');
            $sheet->getStyle('A2:M' . $rows)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
            foreach (range('A', $sheet->getHighestDataColumn()) as $col) {
                $sheet->getColumnDimension($col)->setAutoSize(true);
            }

            $writer = new Xlsx($spreadsheet);
            $writer->save("./uploads/report_excel/" . $fileName);
            header("Content-Type: application/vnd.ms-excel");
            redirect(base_url() . "uploads/report_excel/" . $fileName);
        } else {
            $error = "<div class='alert alert-danger alert-dismissible'>
                        <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                        <strong>Error!</strong> No Records Found.
                      </div>";
            $this->session->set_flashdata('message', $error);
            redirect("admin/report/settlement_report", "refresh");
        }
    }

    public function exportSalesReport() {


        $fileName = 'Salesreport' . time() . '.xlsx';
        ;
        $result = $this->Salesreport_model->allsales($limit = '', $start = '', $col = '', $dir = '');

        if ($result) {
            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();
            $sheet->setTitle('Sales report');
            $sheet->setCellValue('A2', 'Sales report ');
            $sheet->mergeCells('A2:P2');
            $sheet->getStyle("A2")->getFont()->setSize(16);
            $sheet->getStyle("A3:P3")->getFont()->setSize(12);
            $sheet->getStyle("A3:P3")->getFont()->setBold(true);
            $sheet->getStyle("A3:P3")->getFont()->setName('Calibri');
            $sheet->getStyle("A3:P3")->getFont()->getColor()->setRGB('3F7FFF');


            $sheet->setCellValue('A3', 'Sr.no');
            $sheet->setCellValue('B3', 'Order Date');
            $sheet->setCellValue('C3', 'Transaction Id');
            $sheet->setCellValue('D3', 'Order ID');
            $sheet->setCellValue('E3', 'Vendor Id');
            $sheet->setCellValue('F3', 'Vendor Name');
            $sheet->setCellValue('G3', 'Vendor Mobile');
            $sheet->setCellValue('H3', 'Order Status');
            $sheet->setCellValue('I3', 'Total Order Price');
            $sheet->setCellValue('J3', 'Shipping Price');
            $sheet->setCellValue('K3', 'Vendors Price');
            $sheet->setCellValue('L3', 'Commission');
            $sheet->setCellValue('M3', 'GST');
            $sheet->setCellValue('N3', 'Buyer Name');
            $sheet->setCellValue('O3', 'Buyer Email');
            $sheet->setCellValue('P3', 'Buyer Mobile');

            $rows = 4;
            $sl = 0;
            foreach ($result as $val) {
                $sl++;
                $sheet->setCellValue('A' . $rows, $sl);
                $sheet->setCellValue('B' . $rows, $val->date_purchased);
                $sheet->setCellValue('C' . $rows, $val->payment_id);
                $sheet->setCellValue('D' . $rows, $val->orders_id);
                $sheet->setCellValue('E' . $rows, $val->seller_id);
                $sheet->setCellValue('F' . $rows, $val->vendorname);
                $sheet->setCellValue('G' . $rows, $val->vendorphone);
                $sheet->setCellValue('H' . $rows, $val->orders_status_name);
                $sheet->setCellValue('I' . $rows, $val->order_price);
                $sheet->setCellValue('J' . $rows, $val->shipping_cost);
                $sheet->setCellValue('K' . $rows, $val->vendor_payable_price);
                $sheet->setCellValue('L' . $rows, $val->commission);
                $sheet->setCellValue('M' . $rows, $val->gst);
                $sheet->setCellValue('N' . $rows, $val->buyername);
                $sheet->setCellValue('O' . $rows, $val->buyeremail);
                $sheet->setCellValue('P' . $rows, $val->buyerphone);
                $rows++;
            }

            $sheet->getStyle('A2:P' . $rows)->getAlignment()->setHorizontal('center');
            $sheet->getStyle('A2:P' . $rows)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
            foreach (range('A', $sheet->getHighestDataColumn()) as $col) {
                $sheet->getColumnDimension($col)->setAutoSize(true);
            }

            $writer = new Xlsx($spreadsheet);
            $writer->save("./uploads/report_excel/" . $fileName);
            header("Content-Type: application/vnd.ms-excel");
            redirect(base_url() . "uploads/report_excel/" . $fileName);
        } else {
            $error = "<div class='alert alert-danger alert-dismissible'>
                        <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                        <strong>Error!</strong> No Records Found.
                      </div>";
            $this->session->set_flashdata('message', $error);
            redirect("admin/report/sale_report", "refresh");
        }
    }

}
