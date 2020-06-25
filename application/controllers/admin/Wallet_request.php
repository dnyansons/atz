<?php

defined('BASEPATH') OR exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;

class Wallet_request extends CI_Controller {

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
        $this->load->library('Userpermission');
        $this->load->library('Send_data');
        $this->load->library('Browser_notification');
        $this->load->model('Common_model');
        $this->load->model('Wallet_model');
        $this->load->model('Product_model');
    }

    public function index() {
        $data["pageTitle"] = "Byers's Wallet Request";
        $this->load->view("admin/wallet/buyers_wallet_request_list", $data);
    }

    public function get_buyers_wallet_request() {
        $from = $this->input->post("from_date");
        $to = $this->input->post("to_date");

        if ($from != '' && $to != '') {
            $from = date('Y-m-d', strtotime($from));
            $to = date('Y-m-d', strtotime($to));
        }
        $result = $this->Wallet_model->get_datatables_for_wallet_request($from, $to);
//        echo $this->db->last_query();
//        echo "<pre>";
//        print_r($result);
//         exit;
        $data = array();
        $no = $this->input->post('start');
        $sr_no = 1;
        foreach ($result as $res) {
            $no++;
            if ($res->status == "Pending") {
                $action = '<a href="wallet_request/approve_wallet_request/' . $res->request_id . '/' . $res->amount . '/' . $res->user_id . '" onclick="return confirm(&#39;Are you sure?&#39;)" ><button class="btn btn-success btn-sm" >Approve </button></a> <a href="wallet_request/reject_wallet_request/' . $res->request_id . '" onclick="return confirm(&#39;Are you sure?&#39;)" ><button class="btn btn-danger btn-sm" >Reject</button></a>';
            } else if ($res->status == "Approve") {
                $action = "<p style='color:green'>Approved</p>";
            } else {
                $action = "<p style='color:red'>Rejected</p>";
            }

            if ($res->status == "Pending") {
                $status = "<p style='color:red'>Pending</p>";
            } else if ($res->status == "Approve") {
                $status = "<p style='color:green'>Approved</p>";
            } else {
                $status = "<p style='color:red'>Rejected</p>";
            }

            $row = array();
            $row[] = $sr_no;
            $row[] = $res->first_name . ' ' . $res->last_name;
            $row[] = $res->amount;
            $row[] = $res->created_at;
            $row[] = $res->updated_at;
            $row[] = $status;
            $row[] = $res->admin_firstname;
            $row[] = $action;

            $data[] = $row;
            $sr_no++;
        }


        $output = array(
            "draw" => $this->input->post('draw'),
            "recordsTotal" => $this->Wallet_model->count_all_request(),
            "recordsFiltered" => $this->Wallet_model->count_filtered_for_buyer_request($from, $to),
            "data" => $data,
        );
        echo json_encode($output);
    }

    public function approve_wallet_request($id, $amount, $buyer_id) {
        $res = $this->Wallet_model->compare_wallet_amount($buyer_id);
        if ($amount <= $res->balance) {
            $final_amount = $res->balance - $amount;
            $update_wallet = $this->Wallet_model->update_wallet_amount($res->id, $final_amount);
            if ($update_wallet) {
                $arr = array(
                    'buyer_id' => $buyer_id,
                    'amount' => $amount,
                    'transaction_type' => 'debit',
                    'against' => 'withdraw',
                    'referrence' => 0,
                    'remark' => 'Withdraw request Approved for the amount ' . $amount,
                    'status' => 1
                );

                $update_wallet = $this->Common_model->insert('buyer_wallet_history', $arr);

                $user_id = $this->session->userdata('admin_id');
                $arr1['updated_at'] = date('Y-m-d');
                $arr1['status'] = "Approve";
                $arr1['approved_by'] = $user_id;

                $this->Wallet_model->approve_wallet($id, $arr1);

                $this->notify_user_approved($buyer_id, $amount);
            }
        } else {
            $error = "<div class='alert alert-danger'>
						<strong>Error!</strong> This Request Cannot be Approved, Requested Amount Exceeds The Wallet Balance.</div>";
            $this->session->set_flashdata('message', $error);
        }
        redirect("admin/wallet_request", "refresh");
    }

    public function reject_wallet_request($id) {
        $dat = $this->Common_model->getAll('buyer_withdraw_request', array('id' => $id))->row();
        $user_id = $this->session->userdata('admin_id');
        if (!empty($dat->id)) {
            $arr['updated_at'] = date('Y-m-d');
            $arr['status'] = "Reject";
            $arr['approved_by'] = $user_id;
            $this->Wallet_model->reject_wallet($dat->id, $arr);
            $this->notify_user_reject($dat->user_id, $dat->amount);
        }
        redirect("admin/wallet_request", "refresh");
    }

    public function notify_user_approved($buyer_id, $amount) {
        $firebase_id = $this->Common_model->getAll('users_firebase_details', array('user_id' => $buyer_id))->row();
        $user_dat = $this->Common_model->getAll('users', array('id' => $buyer_id))->row();
        //To Buyer
        $msg = "Your Withdraw Request for wallet Amount " . $amount . " Approved!  The withdrawal amount will be reflected in your bank account within (6-7 Working Days). Please contact our support for any queries. Thank you!";
        if (!empty($firebase_id->firebase_id)) {
            $type = "Request";
            $this->browser_notification->notify_buyer('Request Approved', $msg, $firebase_id->firebase_id, $type, $type_id = '');
        }
        $this->send_data->send_sms($msg, $user_dat->phone);

        $buyerNotify = array(
            'title' => 'Request Approved',
            'msg' => $msg,
            'user_id' => $buyer_id,
            'type' => 'request_approved',
            'reference_id' => '',
            'status' => 'Received'
        );

        $this->Product_model->insertBuyerNotify($buyerNotify);
        $email=$user_dat->email;
        $title='Request Approved';
        $this->send_email($email,$title,$msg);
    }

    public function notify_user_reject($buyer_id, $amount) {
        $firebase_id = $this->Common_model->getAll('users_firebase_details', array('user_id' => $buyer_id))->row();
        $user_dat = $this->Common_model->getAll('users', array('id' => $buyer_id))->row();
        //To Buyer
        $msg = "Withdraw Request for wallet Amount " . $amount . " Rejected!";
        if (!empty($firebase_id->firebase_id)) {
            $type = "Request";
            $this->browser_notification->notify_buyer('Request Reject', $msg, $firebase_id->firebase_id, $type, $type_id = '');
        }
        $this->send_data->send_sms($msg, $user_dat->phone);

        $buyerNotify = array(
            'title' => 'Request Rejected',
            'msg' => $msg,
            'user_id' => $buyer_id,
            'type' => 'request_reject',
            'reference_id' => '',
            'status' => 'Received'
        );

        $this->Product_model->insertBuyerNotify($buyerNotify);
        $email=$user_dat->email;
        $title='Request Rejected';
        $this->send_email($email,$title,$msg);
    }

    public function createExcel() {


        $from = $this->input->post("dateFrom");
        $to = $this->input->post("dateTo");

        $fileName = 'wallethistory' . time() . '.xlsx';
        ;
        $result = $this->Wallet_model->excel_data($from, $to);

        if ($result) {
            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();
            $sheet->setTitle('Withdraw Wallet Amount');
            $sheet->setCellValue('A2', 'Wallet Amount Withdrawal Request List ');
            $sheet->mergeCells('A2:K2');
            $sheet->getStyle("A2")->getFont()->setSize(16);
            $sheet->getStyle("A3:K3")->getFont()->setSize(12);
            $sheet->getStyle("A3:K3")->getFont()->setBold(true);
            $sheet->getStyle("A3:K3")->getFont()->setName('Calibri');
            $sheet->getStyle("A3:K3")->getFont()->getColor()->setRGB('3F7FFF');


            $sheet->setCellValue('A3', 'Id');
            $sheet->setCellValue('B3', 'Name');
            $sheet->setCellValue('C3', 'Amount');
            $sheet->setCellValue('D3', 'Email');
            $sheet->setCellValue('E3', 'Phone');
            $sheet->setCellValue('F3', 'Requested Date');
            $sheet->setCellValue('G3', 'Approved Date');
            $sheet->setCellValue('H3', 'Account Holder Name');
            $sheet->setCellValue('I3', 'Account Number');
            $sheet->setCellValue('J3', 'Bank Name');
            $sheet->setCellValue('K3', 'IFSC Code');

            $rows = 4;
            $sl = 0;
            foreach ($result as $val) {
                $sl++;
                $sheet->setCellValue('A' . $rows, $sl);
                $sheet->setCellValue('B' . $rows, $val['first_name'] . ' ' . $val['last_name']);
                $sheet->setCellValue('C' . $rows, $val['amount']);
                $sheet->setCellValue('D' . $rows, $val['email']);
                $sheet->setCellValue('E' . $rows, $val['phone']);
                $sheet->setCellValue('F' . $rows, $val['created_at']);
                $sheet->setCellValue('G' . $rows, $val['updated_at']);
                $sheet->setCellValue('H' . $rows, $val['acc_holder_name']);
                $sheet->setCellValue('I' . $rows, $val['acc_no']);
                $sheet->setCellValue('J' . $rows, $val['bank_name']);
                $sheet->setCellValue('K' . $rows, $val['ifsc_code']);


                $rows++;
            }

            $sheet->getStyle('A2:K' . $rows)->getAlignment()->setHorizontal('center');
            $sheet->getStyle('A2:K' . $rows)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
            foreach (range('A', $sheet->getHighestDataColumn()) as $col) {
                $sheet->getColumnDimension($col)->setAutoSize(true);
            }

            $writer = new Xlsx($spreadsheet);
//            $writer->save("./uploads/wallet_history_excel/" . $fileName);
//            header("Content-Type: application/vnd.ms-excel");
//            redirect(base_url() . "uploads/wallet_history_excel/" . $fileName);
            header("Content-Type: application/vnd.ms-excel");
            header('Content-Disposition: attachment;filename="'. $fileName .'.xlsx"'); 
            header('Cache-Control: max-age=0');
            $writer->save('php://output'); // download file 
        } else {
            $error = "<div class='alert alert-danger alert-dismissible fade show'>
	   <strong>Opps!</strong> Not Found Any Records Between Added Dates.
            <button type='button' class='close mt-0' data-dismiss='alert'>&times;</button></div>";

            $this->session->set_flashdata('message', $error);
            redirect("admin/wallet_request", "refresh");
        }
    }
    
    function send_email($email,$title,$msg) {
        
        $buyer_email =$email;
       
        $data['msg'] = $msg;
        $data['title'] = $title;
        
        $from = $this->config->item("default_email_from");

        $to =$buyer_email;
        $mesg = $this->load->view('emailtemplates/wallet_request', $data, true);
        $this->load->library('email');
        $config = array(
            'charset' => 'utf-8',
            'wordwrap' => TRUE,
            'mailtype' => 'html'
        );
        $config['protocol'] = 'smtp';
        $config['smtp_host'] = 'smtp-relay.gmail.com';
        $config['smtp_user'] = 'support@atzcart.com';
        $config['smtp_pass'] = 'asdfghjklQWE123@';
        $config['smtp_port'] = 587;
        $config['smtp_crypto'] = 'tls';
        $this->email->initialize($config);
        $this->email->set_newline("\r\n");
        $this->email->from($from, 'Atzcart');
        $this->email->to($to);
        $this->email->bcc($emailString);
        $this->email->subject('Wallet Request');
        $this->email->message($mesg);
        $this->email->send();

    }

}

