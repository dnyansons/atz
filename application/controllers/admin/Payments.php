<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Payments extends CI_Controller {

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
        $this->load->library('Userpermission');
    }

    public function index() {
        $data["pageTitle"] = "Vendor's Payment Settlement";
        $this->db->select('d.delivery_date,a.date as settled_date,a.hist_id,a.vendor_id,a.order_id,SUM(a.amount)amount,a.status,a.type,a.date,c.company_name,b.first_name,b.last_name,e.account_no,e.ifsc_code,e.account_holder_name,f.bank_name');
        $this->db->from('wallet_vendor_history a');
        $this->db->join("users b", "b.id=a.vendor_id", "left");
        $this->db->join("seller_company_details c", "c.user_id=a.vendor_id", "left");
        $this->db->join("orders d", "d.orders_id=a.order_id", "left");
        $this->db->join("supplier_bank_details e", "e.user_id=a.vendor_id", "left");
        $this->db->join("banks f", "f.id=e.bank", "left");
        $this->db->where("d.vndr_payment_status", "inprocess");
        $this->db->where("a.status", "available");
        $this->db->group_by("a.vendor_id");
        $this->db->order_by("a.date", "desc");
        //$this->db->group_by("a.hist_id");
        $data['payments'] = $this->db->get()->result_array();
        $this->load->view("admin/wallet/settle_payment", $data);
    }

    public function holdpayments() {
        $data["pageTitle"] = "Vendor's Payment Settlement";
        $this->db->select('a.hist_id,a.vendor_id,a.order_id,a.amount,a.status,a.type,a.date,c.company_name,b.first_name,b.last_name,e.account_no,e.ifsc_code,e.account_holder_name,f.bank_name');
        $this->db->from('wallet_vendor_history a');
        $this->db->join("users b", "b.id=a.vendor_id", "left");
        $this->db->join("seller_company_details c", "c.user_id=a.vendor_id", "left");
        $this->db->join("orders d", "d.orders_id=a.order_id", "left");
        $this->db->join("supplier_bank_details e", "e.user_id=a.vendor_id", "left");
        $this->db->join("banks f", "f.id=e.bank", "left");
        $this->db->where("d.vndr_payment_status", "hold");
        $this->db->where("a.status", "hold");
        $data['payments'] = $this->db->get()->result_array();
        $this->load->view("admin/wallet/hold_payments", $data);
    }

    public function hold() {
        $vendor_id = $this->input->post("vendor_id");
        $order_id = $this->input->post("order_id");
        $reason = $this->input->post("reason");
        if (!empty($reason)) {
            //$this->Common_model->update("wallet_vendor_history",array("status"=>"hold","date"=>date('Y-m-d H:i:s'),"remark"=>$reason,"approved_by"=>$this->session->userdata('admin_id')),array("vendor_id"=>$vendor_id,"order_id"=>$order_id));
            $this->Common_model->update("wallet_vendor_history", array("status" => "hold", "date" => date('Y-m-d H:i:s'), "remark" => $reason, "approved_by" => $this->session->userdata('admin_id')), array("vendor_id" => $vendor_id, "status" => 'available'));
            $details = $this->Common_model->getAll("wallet_vendor", array("vendor_id" => $vendor_id))->row_array();
            $price = $details['available_balance'];
            $this->db->query("update wallet_vendor set hold_balance = hold_balance + '" . $price . "', available_balance = available_balance - '" . $price . "' where vendor_id='" . $vendor_id . "'");
            $this->Common_model->update("orders", array("vndr_payment_status" => "hold"), array("orders_id" => $order_id));
            echo "Payment Hold For Order No. #ORD" . $order_id;
        }
    }

    public function settle() {
        $vendor_id = $this->input->post("vendor_id");
        $order_id = $this->input->post("order_id");
        $reason = $this->input->post("reason");
        $comingfrom = $this->input->post("comingfrom");
        if ($reason == "") {
            echo "Please Enter UTR Number";
            exit();
        }
        //$this->Common_model->update("wallet_vendor_history",array("status"=>"settled","date"=>date('Y-m-d H:i:s'),"remark"=>"UTR NO : ".$reason,"approved_by"=>$this->session->userdata('admin_id')),array("vendor_id"=>$vendor_id,"order_id"=>$order_id));
        $this->Common_model->update("wallet_vendor_history", array("status" => "settled", "date" => date('Y-m-d H:i:s'), "remark" => "UTR NO : " . $reason, "approved_by" => $this->session->userdata('admin_id')), array("vendor_id" => $vendor_id, "status" => 'available'));
        $details = $this->Common_model->getAll("wallet_vendor", array("vendor_id" => $vendor_id))->row_array();

        if ($comingfrom == "available" && $reason != "") {
            $price = $details['available_balance'];
            $this->db->query("update wallet_vendor set settled_balance = settled_balance + '" . $price . "', available_balance = available_balance - '" . $price . "' where vendor_id='" . $vendor_id . "'");
            $this->Common_model->update("orders", array("vndr_payment_status" => "settled"), array("orders_id" => $order_id));
            //echo "Payment Settled For Order No. #ORD".$order_id;
            echo "Payment Settled For Available Order List";
        }

        if ($comingfrom == "hold" && $reason != "") {
            $price = $details['hold_balance'];
            $this->db->query("update wallet_vendor set settled_balance = settled_balance + '" . $price . "', hold_balance = hold_balance - '" . $price . "' where vendor_id='" . $vendor_id . "'");
            $this->Common_model->update("orders", array("vndr_payment_status" => "settled"), array("orders_id" => $order_id));
            echo "Payment Settled For Order No. #ORD" . $order_id;
        }
    }

    public function settleshipping() {
        $vendor_id = 1;
        $order_id = $this->input->post("order_id");
        $reason = $this->input->post("reason");
        if (!empty($reason)) {
            $this->Common_model->update("wallet_shipper_history", array("status" => "settled", "date" => date('Y-m-d H:i:s'), "remark" => "UTR NO : " . $reason, "approved_by" => $this->session->userdata('admin_id')), array("order_id" => $order_id));

            $this->Common_model->update("orders", array("shipping_payment_status" => "Settled"), array("orders_id" => $order_id));
            //echo "Shipper's Payment Settled For Order No. #ORD" . $order_id;
            echo 1;
        } else {
            echo 0;
        }
    }

    public function holdshipping() {
        $vendor_id = 1;
        $order_id = $this->input->post("order_id");
        $reason = $this->input->post("reason");
        if (!empty($reason)) {
            $this->Common_model->update("wallet_shipper_history", array("status" => "hold", "date" => date('Y-m-d H:i:s'), "remark" => "Hold Reason :" . $reason, "approved_by" => $this->session->userdata('admin_id')), array("order_id" => $order_id));
            $this->Common_model->update("orders", array("shipping_payment_status" => "Hold"), array("orders_id" => $order_id));
            echo "Shipper's Payment Hold For Order No. #ORD" . $order_id;
        }
    }

    function get_vendor_wise_settled() {
        $vendor = $this->input->post('vendor');

        $this->db->select('d.delivery_date,a.date as settled_date,a.hist_id,a.vendor_id,a.order_id,a.amount,a.status,a.type,a.date,c.company_name,b.first_name,b.last_name,e.account_no,e.ifsc_code,e.account_holder_name,f.bank_name');
        $this->db->from('wallet_vendor_history a');
        $this->db->join("users b", "b.id=a.vendor_id", "left");
        $this->db->join("seller_company_details c", "c.user_id=a.vendor_id", "left");
        $this->db->join("orders d", "d.orders_id=a.order_id", "left");
        $this->db->join("supplier_bank_details e", "e.user_id=a.vendor_id", "left");
        $this->db->join("banks f", "f.id=e.bank", "left");
        $this->db->where("d.vndr_payment_status", "inprocess");
        $this->db->where("a.status", "available");
        $this->db->where("a.vendor_id", $vendor);
        $this->db->group_by("a.hist_id");
        $payments = $this->db->get()->result_array();

        $str = '';
        $str.='<table id="payment" class="table table-striped table-bordered nowrap">
                                            <thead>
                                                <tr>
                                                    <th>#</th>					
                                                    <th>Vendor&nbsp;Name</th>
                                                     <th>Company</th>
                                                    <th>Order&nbsp;ID</th>
                                                   
                                                    <th>Amount</th>
                                                    <th>Date</th>
                                                    						
                                                </tr>
                                            </thead>';
        $str.='
											<tbody>';
        $i = 1;
        foreach ($payments as $pay) {

            $str.='<tr>
                <td>' . $i . '</td>';
            $str.='<td>' . $pay['first_name'] . ' ' . $pay['last_name'] . '</td>';
            $str.='<td>' . $pay['company_name'] . '</td>';
            $str.='<td>' . $pay['order_id'] . '</td>';



            $str.='<td>' . $pay['amount'] . '</td>';
            $str.='<td>' . $pay['delivery_date'] . '</td>';

            $str.='</tr>';
            $i++;
        }
        $str.='</tbody>
</table>';
        echo $str;
    }

    function get_vendor_wise_settled_ss() {
        $vendor = $this->input->post('vendor');

        $this->db->select('d.delivery_date,a.date as settled_date,a.hist_id,a.vendor_id,a.order_id,a.amount,a.status,a.type,a.date,c.company_name,b.first_name,b.last_name,e.account_no,e.ifsc_code,e.account_holder_name,f.bank_name');
        $this->db->from('wallet_vendor_history a');
        $this->db->join("users b", "b.id=a.vendor_id", "left");
        $this->db->join("seller_company_details c", "c.user_id=a.vendor_id", "left");
        $this->db->join("orders d", "d.orders_id=a.order_id", "left");
        $this->db->join("supplier_bank_details e", "e.user_id=a.vendor_id", "left");
        $this->db->join("banks f", "f.id=e.bank", "left");
        $this->db->where("d.vndr_payment_status", "inprocess");
        $this->db->where("a.status", "available");
        $this->db->where("a.vendor_id", $vendor);
        $this->db->group_by("a.hist_id");
        $payments = $this->db->get()->result_array();

        $data = array();


        $i = 1;
        foreach ($payments as $pay) {

            $nestedData['srno'] = $i;
            $nestedData['first_name'] = $pay['first_name'] . ' ' . $pay['last_name'];
            $nestedData['company_name'] = $pay['company_name'];
            $nestedData['order_id'] = $pay['order_id'];
            $nestedData['amount'] = $pay['amount'];
            $nestedData['delivery_date'] = $pay['delivery_date'];

            $i++;
        }
        $data[] = $nestedData;
        echo json_encode($data);
    }

}
