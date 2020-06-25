<?php

defined('BASEPATH') OR exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;

class Refunds extends CI_Controller {

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

        $this->load->model('Myorders_model');
        $this->load->model('Refund_model');
        $this->load->model('Common_model');
        $this->load->library('Userpermission');
        $this->load->library('Browser_notification');
        $this->load->library("Send_data");
        $this->load->library("Shiprocket");
    }

    public function index() {

        $this->load->view("admin/refund/list");
    }

    public function ajax_list() {
        $columns = array(
            0 => 'refund_id',
            1 => 'user_name',
            2 => 'order_price',
            3 => 'refund_amount',
            4 => 'update_at',
            5 => 'orders_status'
        );


        $limit = $this->input->post('length');
        $start = $this->input->post('start');
        $order = $columns[$this->input->post('order')[0]['column']];
        $dir = $this->input->post('order')[0]['dir'];
//        $dir = "desc";

        $totalData = $this->Refund_model->allrefunds_count_admin();

        $totalFiltered = $totalData;

        if (empty($this->input->post('search')['value'])) {
            $refund = $this->Refund_model->allrefunds_admin($limit, $start, $order, $dir);
        } else {
            $search = $this->input->post('search')['value'];

            $refund = $this->Refund_model->refunds_search_admin($limit, $start, $search, $order, $dir);

            $totalFiltered = $this->Refund_model->refunds_search_count_admin($limit, $start, $search, $order, $dir);
        }

        $data = array();
        if (!empty($refund)) {
            foreach ($refund as $ref) {
                $nestedData['refund_id'] = $ref->refund_id;
                $nestedData['user_name'] = $ref->user_name;
                $nestedData['order_price'] = $ref->order_price;
                $nestedData['refund_amount'] = $ref->refund_amount;
                $nestedData['created_at'] = date('d M Y', strtotime($ref->created_at));
                $nestedData['update_at'] = date('d M Y', strtotime($ref->update_at));
                $nestedData['orders_status'] = $ref->orders_status;
                $nestedData['action'] = '<a href="' . base_url() . 'admin/refunds/view_refund_request/' . $ref->orders_id . '" class="btn btn-info btn-sm">View</a>';

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

    public function view_refund_request($orders_id) {
        $data['order_id'] = $orders_id;
        $data['refund'] = $this->Refund_model->view_refunds_data_admin($orders_id);

        $data['refund_history'] = $this->Refund_model->refund_history($orders_id);
        $this->load->view('admin/refund/view_refund', $data);
    }

    function action_on_refund_request() {
        $orders_id = $this->input->post('orders_id');
        $order_details = $this->Common_model->getAll('orders', array('orders_id' => $orders_id))->row();
        $checkshipMethod = $this->Common_model->getAll('order_shipping', array('orders_id' => $orders_id))->row();

        $orders_status = $this->input->post('orders_status');

        $old_status = $this->input->post('old_status');

        $refund_amount = (float) $this->input->post('refund_amount');

        $actual_price = $order_details->order_price;

        if ($old_status != $orders_status && $refund_amount > 0 && $refund_amount <= $actual_price) {
            $dat['orders_id'] = $orders_id;
            $dat['orders_status'] = $orders_status;
            $dat['refund_amount'] = $refund_amount;
            $res = $this->Common_model->update('order_refund', $dat, array('orders_id' => $orders_id));

            if ($orders_status == 'ATZCART.COM Approved') {
                $user_id = $order_details->user_id;

                $this->Myorders_model->refund_added_to_wallet_from_admin($orders_id, $refund_amount, $user_id);

                //Cancel Approved By Update
                $da['cancelled_by'] = $this->session->userdata('admin_role') . ' ' . $this->session->userdata('admin_username');
                $da['orders_status'] = 12;
                $this->Common_model->update('orders', $da, array('orders_id' => $orders_id));

                if ($checkshipMethod->ship_vendor_id == 2) {
                    $postData = json_encode(array(
                        'ids' =>
                        array(
                            0 => $checkshipMethod->ship_order_id,
                        ),
                    ));

                    $this->shiprocket->cancel_order($postData);
                }

                $this->order_refund_notify($orders_id, $refund_amount);

                //Order Request
                $insertHistory['orders_id'] = $orders_id;
                $insertHistory['status'] = 12;
                $insertHistory['date_added'] = date('Y-m-d H:i:s');
                $insertHistory['comment'] = 'Amount Refunded';
                $insertHistory['customer_notified'] = 1;
                $this->Common_model->insert('orders_history', $insertHistory);


                $msg = "<div class='alert alert-success alert-dismissible'>
									<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
									<strong>Success !</strong>Cancel Refund Approved Successfully !
								  </div>";
            }

            if ($orders_status == 'ATZCART.COM in Progress') {
                //Order History
                $data_hist['orders_id'] = $orders_id;
                $data_hist['comment'] = $orders_status;

                $data_hist['created_at'] = date('Y-m-d H:i:s');
                $this->Common_model->insert('order_refund_history', $data_hist);


                $msg = "<div class='alert alert-success alert-dismissible'>
									<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
									<strong>Success !</strong>Status Update Successfully !
								  </div>";
            }

            if ($res) {
                //Order History
                $data_hist['orders_id'] = $orders_id;
                $data_hist['comment'] = $orders_status;

                $data_hist['created_at'] = date('Y-m-d H:i:s');
                $this->Common_model->insert('order_refund_history', $data_hist);
            }
        } else {
            $msg = "<div class='alert alert-error alert-dismissible'>
									<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
									<strong>Error !</strong> Somthing Went Wrong !
								  </div>";
        }
        $this->session->set_flashdata('message', $msg);
        redirect('admin/refunds');
    }

    public function approve_refund_request() {
        $orders_id = $this->input->post('orders_id');
        $status = "ATZCART.COM in Progress";
        $this->Refund_model->update_status_data_admin($orders_id, $status);

        //Order History
        $data_hist['orders_id'] = $orders_id;
        $data_hist['comment'] = $status;
        $data_hist['created_at'] = date('Y-m-d H:i:s');
        $this->Common_model->insert('order_refund_history', $data_hist);

        echo json_encode(array("status" => "success"));
        exit;
    }

    public function reject_refund_request() {
        $orders_id = $this->input->post('orders_id');
        $status = "ATZCART.COM Rejected";
        $this->Refund_model->update_status_data_admin($orders_id, $status);

        //Order History
        $data_hist['orders_id'] = $orders_id;
        $data_hist['comment'] = $status;
        $data_hist['created_at'] = date('Y-m-d H:i:s');
        $this->Common_model->insert('order_refund_history', $data_hist);

        echo json_encode(array("status" => "success"));
        exit;
    }

    function order_refund_notify($order_id = 0, $refund_amt) {

        //Get Data
        $this->db->select('a.orders_id,a.user_name,a.user_id,a.user_telephone,a.seller_id,b.firebase_id as buyer_firbase,c.firebase_id as seller_firebase');
        $this->db->from('orders a');
        $this->db->join('users_firebase_details b', 'a.user_id=b.user_id', 'left');
        $this->db->join('users_firebase_details c', 'a.seller_id=c.user_id', 'left');
        $this->db->where('a.orders_id', $order_id);
        $query = $this->db->get()->row();

        $user_id = $query->user_id;
        $seller_id = $query->seller_id;
        $user_name = $query->user_name;
        $user_phone = $query->user_telephone;
        $buyer_firbase = $query->buyer_firbase;
        $seller_firebase = $query->seller_firebase;


        //Send SMS to Customer
        $msg = 'Amount INR.' . $refund_amt . ' refunded against Order #' . $order_id . ' Thank You for choosing ATZ Cart ! If you have any Queries related to order Please  Visit our Website atzcart.com';
        $mob = $query->user_telephone;
        $this->send_data->send_sms($msg, $user_phone);

        //Notify To Seller
        $title = 'Amount Refunded !';
        $msg = "Amount refunded against Order #ORD" . $order_id . ' In Buyer Account';
        $tag = '';
        $this->browser_notification->notifyseller($seller_id, $title, $msg, $tag);

        //To Buyer
        if (!empty($buyer_firbase)) {
            $msg = "Amount refunded against Order #ORD" . $order_id;
            $type = "Cancel";
            $this->browser_notification->notify_buyer('Amount Refunded !', $msg, $buyer_firbase, $type, $type_id = '');
        }
    }

    public function exportRefundOrderRequest() {

        $orders_id = $this->input->post('orders_id');
        $order_details = $this->Common_model->getAll('orders')->row();

        $fileName = 'RefundOrderRequest' . time() . '.xlsx';
        $result = $this->Refund_model->allrefunds_admin($limit = 100, $start = '', $order = '', $dir = '');

        if ($result) {
            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();
            $sheet->setTitle('Refund Order');
            $sheet->setCellValue('A2', 'Refund Order Request ');
            $sheet->mergeCells('A2:H2');
            $sheet->getStyle("A2")->getFont()->setSize(12);
            $sheet->getStyle("A3:H3")->getFont()->setBold(true);
            $sheet->getStyle("A3:H3")->getFont()->setName('Calibri');
            $sheet->getStyle("A3:H3")->getFont()->getColor()->setRGB('3F7FFF');
            $sheet->getStyle("A3:H3")->getFont()->setSize(12);

            $sheet->setCellValue('A3', 'Sl.no');
            $sheet->setCellValue('B3', 'Refund ID');
            $sheet->setCellValue('C3', 'User');
            $sheet->setCellValue('D3', 'Request Amount');
            $sheet->setCellValue('E3', 'Approved Amount');
            $sheet->setCellValue('F3', 'Created Date');
            $sheet->setCellValue('G3', 'Update Date');
            $sheet->setCellValue('H3', 'Order Status');

            $rows = 4;
            $sl = 0;
            foreach ($result as $val) {
                $sl++;
                $sheet->setCellValue('A' . $rows, $sl);
                $sheet->setCellValue('B' . $rows, $val->refund_id);
                $sheet->setCellValue('C' . $rows, $val->user_name);
                $sheet->setCellValue('D' . $rows, $val->order_price);
                $sheet->setCellValue('E' . $rows, $val->refund_amount);
                $sheet->setCellValue('F' . $rows, $val->created_at);
                $sheet->setCellValue('G' . $rows, $val->update_at);
                $sheet->setCellValue('H' . $rows, $val->orders_status);
                $rows++;
            }

            $sheet->getStyle('A2:H' . $rows)->getAlignment()->setHorizontal('center');
            $sheet->getStyle('A2:H' . $rows)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
            foreach (range('A', $sheet->getHighestDataColumn()) as $col) {
                $sheet->getColumnDimension($col)->setAutoSize(true);
            }

            $writer = new Xlsx($spreadsheet);
            header("Content-Type: application/vnd.ms-excel");
            header('Content-Disposition: attachment;filename="'. $fileName .'.xlsx"'); 
            header('Cache-Control: max-age=0');
            $writer->save('php://output'); // download file 
        
        }else{

            $error = "<div class='alert alert-danger alert-dismissible'>
                        <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                        <strong>Error!</strong> No Records Found.
                      </div>";
            $this->session->set_flashdata('message', $error);
            redirect("admin/refunds/", "refresh");
        }
    }

}
