<?php

defined('BASEPATH') OR exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;

class Order extends CI_Controller {

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
        $this->load->model('Order_model');
        $this->load->model('Myorders_model');
        $this->load->model('Common_model');
        $this->load->library("userpermission");
        $this->load->library("shipping");
    }

    public function show() {
        $data["pageTitle"] = "Admin || Orders";
        $data['statuses'] = $this->Common_model->getAll("orders_status")->result_array();
        $data['order_status'] = $this->input->post('orderstatus');
        $data['dateFrom'] = $this->input->post('dateFrom');
        $data['dateTo'] = $this->input->post('dateTo');
        $data['orderid'] = $this->input->post('orderid');
        $data['vendorid'] = $this->input->post('vendorid');
        $data['page'] = "show";

        //$data['total_orders'] = $this->Order_model->get_allOrders();

        $this->db->select("e.awb_number as awb,e.ship_vendor_id,e.awb_url,a.shippment_type,a.delivery_date,DATE_FORMAT(a.date_purchased, '%a %d %M %Y') as date_purchased_only, DATE_FORMAT(a.date_purchased, '%h:%i:%s %p ') as time_purchased, DATE_FORMAT(a.orders_date_finished, '%a %d %M %Y %h:%i:%s %p ') orders_date_finished, DATE_FORMAT(oh.date_added, '%a %d %M %Y %h:%i:%s %p ') order_accepted_date, vendor.email vendor_email, vendor.phone vendor_mobile, vendor.address vendor_address, 
             CONCAT(first_name, ' ', last_name) vendor_name, publish_status,a.user_id,payment_id,seller_id,b.orders_status_name,a.cancelled_by,a.orders_id as ord,a.order_token_number,a.awb_number,concat('ORD',a.orders_id) as orders_id,DATE_FORMAT(a.date_purchased, '%a %d %M %Y %h:%i:%s %p ') as date_purchased,DATE_FORMAT(a.delivery_date, '%a %d %M %Y %h:%i:%s %p ') as delivery_date,a.user_name,a.user_email_address,a.user_telephone,concat(a.user_street_address,' ',a.user_city,' ',a.user_state,' ',a.user_postcode) as shipping_adress,a.order_price,a.shipping_cost,a.vendor_payable_price,a.pick_name,a.pick_mobile,a.pick_email,concat(a.pick_addr_type,' ',a.pick_state,' ',a.pick_pincode) as pickup_address,a.commission,a.gst");
        $this->db->from('orders a');
        $this->db->join('orders_status b', 'a.orders_status=b.orders_status_id', 'left');
        $this->db->join('order_payment op', 'a.orders_id=op.orders_id', 'left');
        $this->db->join('orders_products ops', 'a.orders_id=ops.orders_id', 'left');
        $this->db->join('product_details pd', 'pd.id=ops.products_id', 'left');
         $this->db->join('order_shipping e', 'e.orders_id=e.orders_id', 'left');
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

        $data['total_orders'] = $this->db->get()->result_array();

        $this->load->view("admin/order/orderlist", $data);
    }

    public function exportAllOrders() {

        $page = $this->input->post('page');
        $fileName = 'order_details' . time() . '.xlsx';
        $result = $this->Order_model->get_allOrders();

        if ($result) {
            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();
            $sheet->setTitle('Order Details');
            $sheet->setCellValue('A2', 'Order Details');
            $sheet->mergeCells('A2:AA2');
            $sheet->getStyle("A2")->getFont()->setSize(16);

            $sheet->getStyle("A3:AA3")->getFont()->setSize(12);
            $sheet->getStyle("A3:AA3")->getFont()->setBold(true);
            $sheet->getStyle("A3:AA3")->getFont()->setName('Calibri');
            $sheet->getStyle("A3:AA3")->getFont()->getColor()->setRGB('3F7FFF');


            $sheet->setCellValue('A3', 'Sr.No');
            $sheet->setCellValue('B3', 'Order ID');
            $sheet->setCellValue('C3', 'Order Date');
            $sheet->setCellValue('D3', 'Order Time');
            $sheet->setCellValue('E3', 'Order Status');
            $sheet->setCellValue('F3', 'Payment Id');
            $sheet->setCellValue('G3', 'Products');
            $sheet->setCellValue('H3', 'Ordered By');
            $sheet->setCellValue('I3', 'User Id');
            $sheet->setCellValue('J3', 'Shipping Address');
            $sheet->setCellValue('K3', 'Way Bill No.');
            $sheet->setCellValue('L3', 'Consumer Mobile');
            $sheet->setCellValue('M3', 'Amount');
            $sheet->setCellValue('N3', 'Shipping Price');
            $sheet->setCellValue('O3', 'Fees/Commission');
            $sheet->setCellValue('P3', 'GST');
            $sheet->setCellValue('Q3', 'Payable Amount To Vendor');
            $sheet->setCellValue('R3', 'Product Status');

            $sheet->setCellValue('S3', 'Vendor Id');
            $sheet->setCellValue('T3', 'Vendor Name');
            $sheet->setCellValue('U3', 'Vendor Email');
            $sheet->setCellValue('V3', 'Vendor Mobile');
            $sheet->setCellValue('W3', 'Vendor Address');
            $sheet->setCellValue('X3', 'Order Accepted DateTime');
            $sheet->setCellValue('Y3', 'Shipping Status');
            $sheet->setCellValue('Z3', 'Delivery Date');
            $sheet->setCellValue('AA3', 'Shipping Type');

            $rows = 4;
            $sl = 0;
            foreach ($result as $val) {
                $sl++;
                $sheet->setCellValue('A' . $rows, $sl);

                $sheet->setCellValue('B' . $rows, $val['orders_id']);
                $sheet->setCellValue('C' . $rows, $val['date_purchased_only']);
                $sheet->setCellValue('D' . $rows, $val['time_purchased']);
                $sheet->setCellValue('E' . $rows, $val['orders_status_name']);

                if (trim($val['orders_date_finished']) != '0000-00-00') {
                    $f_date = $val['orders_date_finished'];
                } else {
                    $f_date = '--';
                }

                $sheet->setCellValue('F' . $rows, $val['payment_id']);

                $products = $this->Common_model->getAll("orders_products", array("orders_id" => $val['ord']))->result_array();
                foreach ($products as $prod) {
                    $products_names .= $prod['products_name'] . ' ';
                }

                $sheet->setCellValue('G' . $rows, $products_names);
                $products_names = '';
                $sheet->setCellValue('H' . $rows, $val['user_name']);
                $sheet->setCellValue('I' . $rows, 'ATZ' . $val['user_id']);
                $sheet->setCellValue('J' . $rows, $val['shipping_adress']);
                $sheet->setCellValue('K' . $rows, $val['awb_number']);
                $sheet->setCellValue('L' . $rows, $val['user_telephone']);
                $sheet->setCellValue('M' . $rows, $val['order_price']);

                $sheet->setCellValue('N' . $rows, $val['shipping_cost']);
                $sheet->setCellValue('O' . $rows, $val['commission']);
                $sheet->setCellValue('P' . $rows, $val['gst']);
                $sheet->setCellValue('Q' . $rows, $val['vendor_payable_price']);
                $sheet->setCellValue('R' . $rows, $val['publish_status']);
                $sheet->setCellValue('S' . $rows, 'ATZ' . $val['seller_id']);
                $sheet->setCellValue('T' . $rows, $val['vendor_name']);
                $sheet->setCellValue('U' . $rows, $val['vendor_email']);
                $sheet->setCellValue('V' . $rows, $val['vendor_mobile']);
                $sheet->setCellValue('W' . $rows, $val['vendor_address']);
                $sheet->setCellValue('X' . $rows, $val['order_accepted_date']);
                $sheet->setCellValue('Y' . $rows, $val['orders_status_name']);
                $sheet->setCellValue('Z' . $rows, $val['delivery_date']);
                $sheet->setCellValue('AA' . $rows, $val['shippment_type']);

                $rows++;
            }

            $sheet->getStyle('A2:AA' . $rows)->getAlignment()->setHorizontal('center');
            $sheet->getStyle('A2:AA' . $rows)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
            foreach (range('A','Z') as $col) {
                $sheet->getColumnDimension($col)->setAutoSize(true);
            }
            $sheet->getColumnDimension("AA")->setAutoSize(true);


            $writer = new Xlsx($spreadsheet);
            //$writer->save("./uploads/order_excel/" . $fileName);
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
            redirect("admin/order/" . $page, "refresh");
        }
    }

    public function all_orders() {
        $this->Myorders_model->read_order_notification();
        $data["pageTitle"] = "Admin || Orders";
        $data['statuses'] = $this->Common_model->getAll("orders_status")->result_array();
        $data['order_status'] = '';
        $data['page'] = "all_orders";
        $this->db->select("c.awb_number as awb,c.ship_vendor_id,c.awb_url,a.shippment_type,a.delivery_date,seller_id, b.orders_status_name,a.cancelled_by,a.orders_id as ord,a.order_token_number,a.awb_number,concat('ORD',a.orders_id) as orders_id,date(a.date_purchased) as date_purchased,date(a.orders_date_finished) as orders_date_finished,a.user_name,a.user_email_address,a.user_telephone,concat(a.user_street_address,' ',a.user_city,' ',a.user_state,' ',a.user_postcode) as shipping_adress,a.order_price,a.shipping_cost,a.vendor_payable_price,a.pick_name,a.pick_mobile,a.pick_email,concat(a.pick_addr_type,' ',a.pick_state,' ',a.pick_pincode) as pickup_address,a.commission,a.gst, a.orders_status");
        $this->db->from('orders a');
        $this->db->join('orders_status b', 'a.orders_status=b.orders_status_id', 'left');
        $this->db->join('order_shipping c', 'c.orders_id=a.orders_id', 'left');
        $this->db->where("date(a.date_purchased) >=", date('Y-m-d'));
        $this->db->where("date(a.date_purchased) <=", date('Y-m-d'));
        $this->db->where("a.orders_status !=", 8);
        $this->db->order_by("a.orders_id desc");
        $data['total_orders'] = $this->db->get()->result_array();
        $this->load->view("admin/order/orderlist", $data);
    }

    public function completed() {
        $this->Myorders_model->read_order_notification();

        $data["pageTitle"] = "Admin || Orders";
        $data['statuses'] = $this->Common_model->getAll("orders_status")->result_array();

        $data['order_status'] = 4;
        $data['page'] = "completed";
        $this->db->select("c.awb_number as awb,c.ship_vendor_id,c.awb_url,a.shippment_type,a.delivery_date,seller_id,b.orders_status_name,a.cancelled_by,a.orders_id as ord,a.order_token_number,a.awb_number,concat('ORD',a.orders_id) as orders_id,date(a.date_purchased) as date_purchased,date(a.orders_date_finished) as orders_date_finished,a.user_name,a.user_email_address,a.user_telephone,concat(a.user_street_address,' ',a.user_city,' ',a.user_state,' ',a.user_postcode) as shipping_adress,a.order_price,a.shipping_cost,a.vendor_payable_price,a.pick_name,a.pick_mobile,a.pick_email,concat(a.pick_addr_type,' ',a.pick_state,' ',a.pick_pincode) as pickup_address,a.commission,a.gst");
        $this->db->from('orders a');
        $this->db->join('orders_status b', 'a.orders_status=b.orders_status_id', 'left');
        $this->db->join('order_shipping c', 'c.orders_id=a.orders_id', 'left');
        $this->db->where("date(a.date_purchased) >=", date('Y-m-d'));
        $this->db->where("date(a.date_purchased) <=", date('Y-m-d'));
        $this->db->where("a.orders_status", 4);
        $this->db->order_by("a.orders_id", "DESC");
        $data['total_orders'] = $this->db->get()->result_array();
        $this->load->view("admin/order/orderlist", $data);
    }

    public function processing() {
        $this->Myorders_model->read_order_notification();

        $data["pageTitle"] = "Admin || Orders";
        $data['statuses'] = $this->Common_model->getAll("orders_status")->result_array();
        $data['page'] = "processing";
        $data['order_status'] = 10;
        $this->db->select("c.awb_number as awb,c.ship_vendor_id,c.awb_url,a.shippment_type,a.delivery_date,seller_id,b.orders_status_name,a.cancelled_by,a.orders_id as ord,a.order_token_number,a.awb_number,concat('ORD',a.orders_id) as orders_id,date(a.date_purchased) as date_purchased,date(a.orders_date_finished) as orders_date_finished,a.user_name,a.user_email_address,a.user_telephone,concat(a.user_street_address,' ',a.user_city,' ',a.user_state,' ',a.user_postcode) as shipping_adress,a.order_price,a.shipping_cost,a.vendor_payable_price,a.pick_name,a.pick_mobile,a.pick_email,concat(a.pick_addr_type,' ',a.pick_state,' ',a.pick_pincode) as pickup_address,a.commission,a.gst");
        $this->db->from('orders a');
        $this->db->join('orders_status b', 'a.orders_status=b.orders_status_id', 'left');
        $this->db->join('order_shipping c', 'c.orders_id=a.orders_id', 'left');
        $this->db->where("date(a.date_purchased) >=", date('Y-m-d'));
        $this->db->where("date(a.date_purchased) <=", date('Y-m-d'));
        $this->db->where("a.orders_status", 10);
        $this->db->order_by("a.orders_id", "DESC");
        $data['total_orders'] = $this->db->get()->result_array();
        $this->load->view("admin/order/orderlist", $data);
    }

    public function pending() {
        $this->Myorders_model->read_order_notification();
        $data["pageTitle"] = "Admin || Orders";
        $data['statuses'] = $this->Common_model->getAll("orders_status")->result_array();
        $data['order_status'] = 8;
        $data['page'] = "pending";
        $this->db->select("c.awb_number as awb,c.ship_vendor_id,c.awb_url,a.shippment_type,a.delivery_date,seller_id,b.orders_status_name,a.cancelled_by,a.orders_id as ord,a.order_token_number,a.awb_number,concat('ORD',a.orders_id) as orders_id,date(a.date_purchased) as date_purchased,date(a.orders_date_finished) as orders_date_finished,a.user_name,a.user_email_address,a.user_telephone,concat(a.user_street_address,' ',a.user_city,' ',a.user_state,' ',a.user_postcode) as shipping_adress,a.order_price,a.shipping_cost,a.vendor_payable_price,a.pick_name,a.pick_mobile,a.pick_email,concat(a.pick_addr_type,' ',a.pick_state,' ',a.pick_pincode) as pickup_address,a.commission,a.gst");
        $this->db->from('orders a');
        $this->db->join('orders_status b', 'a.orders_status=b.orders_status_id', 'left');
        $this->db->join('order_shipping c', 'c.orders_id=a.orders_id', 'left');
        $this->db->where("date(a.date_purchased) >=", date('Y-m-d'));
        $this->db->where("date(a.date_purchased) <=", date('Y-m-d'));
        $this->db->order_by("a.orders_id", "DESC");
        $this->db->where("a.orders_status", 8);
        $data['total_orders'] = $this->db->get()->result_array();
        $this->load->view("admin/order/orderlist", $data);
    }

    public function cancelled() {

        $this->Myorders_model->read_order_notification();
        $data["pageTitle"] = "Admin || Orders";
        $data['statuses'] = $this->Common_model->getAll("orders_status")->result_array();
        $data['order_status'] = 1;
        $data['page'] = "cancelled";
        $this->db->select("c.awb_number as awb,c.ship_vendor_id,c.awb_url,a.shippment_type,a.delivery_date,seller_id,b.orders_status_name,a.cancelled_by,a.orders_id as ord,a.order_token_number,a.awb_number,concat('ORD',a.orders_id) as orders_id,date(a.date_purchased) as date_purchased,date(a.orders_date_finished) as orders_date_finished,a.user_name,a.user_email_address,a.user_telephone,concat(a.user_street_address,' ',a.user_city,' ',a.user_state,' ',a.user_postcode) as shipping_adress,a.order_price,a.shipping_cost,a.vendor_payable_price,a.pick_name,a.pick_mobile,a.pick_email,concat(a.pick_addr_type,' ',a.pick_state,' ',a.pick_pincode) as pickup_address,a.commission,a.gst");
        $this->db->from('orders a');
        $this->db->join('orders_status b', 'a.orders_status=b.orders_status_id', 'left');
        $this->db->join('order_shipping c', 'c.orders_id=a.orders_id', 'left');
        $this->db->where("date(a.date_purchased) >=", date('Y-m-d'));
        $this->db->where("date(a.date_purchased) <=", date('Y-m-d'));
        $this->db->order_by("a.orders_id", "DESC");
        $this->db->where("a.orders_status", 1);
        $this->db->or_where("a.orders_status", 25);
        $this->db->or_where("a.orders_status", 20);
        $this->db->or_where("a.orders_status", 21);
        $data['total_orders'] = $this->db->get()->result_array();
        $this->load->view("admin/order/orderlist", $data);
    }

    function offer_report() {
        $this->Myorders_model->read_order_notification();
        $data["pageTitle"] = "Admin || Offer Orders";
        $data['offer'] = $this->Common_model->getAll("offer_zone")->result_array();
        $data['order_status'] = '';
        $data['page'] = "Offer Order";
        $this->db->select("e.awb_number as awb,e.ship_vendor_id,e.awb_url,a.shippment_type,d.title,d.offer_id,d.offer_type,d.discount_value,a.delivery_date,seller_id,b.orders_status_name,a.cancelled_by,a.orders_id as ord,a.order_token_number,a.awb_number,concat('ORD',a.orders_id) as orders_id,date(a.date_purchased) as date_purchased,date(a.orders_date_finished) as orders_date_finished,a.user_name,a.user_email_address,a.user_telephone,concat(a.user_street_address,' ',a.user_city,' ',a.user_state,' ',a.user_postcode) as shipping_adress,a.order_price,a.shipping_cost,a.vendor_payable_price,a.pick_name,a.pick_mobile,a.pick_email,concat(a.pick_addr_type,' ',a.pick_state,' ',a.pick_pincode) as pickup_address,a.commission,a.gst");
        $this->db->from('orders a');
        $this->db->join('orders_status b', 'a.orders_status=b.orders_status_id', 'left');
        $this->db->join('orders_products c', 'a.orders_id=c.orders_id', 'left');
        $this->db->join('order_shipping e', 'e.orders_id=a.orders_id', 'left');
        $this->db->join('offer_zone d', 'c.offer_id=d.offer_id', 'left');
        $this->db->where("date(a.date_purchased) >=", date('Y-m-d'));
        $this->db->where("date(a.date_purchased) <=", date('Y-m-d'));
        $this->db->order_by("a.orders_id", "DESC");
        $this->db->where("a.orders_status!=", 8);
        $this->db->where("c.offer_id > ", 0);
        $data['total_orders'] = $this->db->get()->result_array();
        $this->load->view("admin/order/offerlist", $data);
    }

    public function show_offer() {
        $data["pageTitle"] = "Admin || Orders";
        $data['offer'] = $this->Common_model->getAll("offer_zone")->result_array();
        $data['offer_id'] = $this->input->post('offer_id');
        $data['dateFrom'] = $this->input->post('dateFrom');
        $data['dateTo'] = $this->input->post('dateTo');
        $data['orderid'] = $this->input->post('orderid');
        $data['vendorid'] = $this->input->post('vendorid');
        $data['page'] = "show Offer";

        //$data['total_orders'] = $this->Order_model->get_allOrders();

        $this->db->select("e.awb_number as awb,e.ship_vendor_id,e.awb_url,a.shippment_type,d.title,ops.offer_id,d.offer_type,d.discount_value,a.delivery_date,a.delivery_date,DATE_FORMAT(a.date_purchased, '%a %d %M %Y') as date_purchased_only, DATE_FORMAT(a.date_purchased, '%h:%i:%s %p ') as time_purchased, DATE_FORMAT(a.orders_date_finished, '%a %d %M %Y %h:%i:%s %p ') orders_date_finished, DATE_FORMAT(oh.date_added, '%a %d %M %Y %h:%i:%s %p ') order_accepted_date, vendor.email vendor_email, vendor.phone vendor_mobile, vendor.address vendor_address, 
             CONCAT(first_name, ' ', last_name) vendor_name, publish_status,a.user_id,payment_id,seller_id,b.orders_status_name,a.cancelled_by,a.orders_id as ord,a.order_token_number,a.awb_number,concat('ORD',a.orders_id) as orders_id,DATE_FORMAT(a.date_purchased, '%a %d %M %Y %h:%i:%s %p ') as date_purchased,DATE_FORMAT(a.delivery_date, '%a %d %M %Y %h:%i:%s %p ') as delivery_date,a.user_name,a.user_email_address,a.user_telephone,concat(a.user_street_address,' ',a.user_city,' ',a.user_state,' ',a.user_postcode) as shipping_adress,a.order_price,a.shipping_cost,a.vendor_payable_price,a.pick_name,a.pick_mobile,a.pick_email,concat(a.pick_addr_type,' ',a.pick_state,' ',a.pick_pincode) as pickup_address,a.commission,a.gst");
        $this->db->from('orders a');
        $this->db->join('orders_status b', 'a.orders_status=b.orders_status_id', 'left');
        $this->db->join('order_payment op', 'a.orders_id=op.orders_id', 'left');
        $this->db->join('orders_products ops', 'a.orders_id=ops.orders_id', 'left');
        $this->db->join('product_details pd', 'pd.id=ops.products_id', 'left');
        $this->db->join('users vendor', 'vendor.id=a.seller_id', 'left');
         $this->db->join('order_shipping e', 'e.orders_id=a.orders_id', 'left');
        $this->db->join('offer_zone d', 'd.offer_id=ops.offer_id', 'left');
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
        if ($this->input->post('offer_id') != "") {
            $this->db->where("ops.offer_id", $this->input->post('offer_id'));
        }
        $this->db->where('ops.offer_id >', 0);
        $this->db->order_by('a.orders_id', 'DESC');
        $data['total_orders'] = $this->db->get()->result_array();

        $this->load->view("admin/order/offerlist", $data);
    }

    /* public function return()
      {
      $data["pageTitle"] = "Admin || Orders";
      $data['statuses'] = $this->Common_model->getAll("orders_status")->result_array();
      $data['order_status'] = 13;
      $data['page'] = "return";
      $this->db->select("a.delivery_date,seller_id,b.orders_status_name,a.orders_id as ord,a.order_token_number,a.awb_number,concat('ORD',a.orders_id) as orders_id,date(a.date_purchased) as date_purchased,date(a.orders_date_finished) as orders_date_finished,a.user_name,a.user_email_address,a.user_telephone,concat(a.user_street_address,' ',a.user_city,' ',a.user_state,' ',a.user_postcode) as shipping_adress,a.order_price,a.shipping_cost,a.vendor_payable_price,a.pick_name,a.pick_mobile,a.pick_email,concat(a.pick_addr_type,' ',a.pick_state,' ',a.pick_pincode) as pickup_address,a.commission,a.gst");
      $this->db->from('orders a');
      $this->db->join('orders_status b','a.orders_status=b.orders_status_id','left');
      $this->db->where("date(a.date_purchased) >=",date('Y-m-d'));
      $this->db->where("date(a.date_purchased) <=",date('Y-m-d'));

      $this->db->order_by("a.orders_id","DESC");

      $this->db->where("a.orders_status",13);
      $data['total_orders'] = $this->db->get()->result_array();
      $this->load->view("admin/order/orderlist", $data);

      } */
    /*
      Use this function if you want datatable in working, do not delete this
      public function show($status)
      {
      $data["pageTitle"] = "Admin || Orders";
      $data['statuses'] = $this->Common_model->getAll("orders_status")->result_array();
      $data['order_status'] = $status;
      $this->load->view("admin/order/list", $data);
      } */

    public function view($order_id = 0) {
        //$orderDetails = $this->Order_model->getOrderDetailsById($order_id);
        $orderDetails = $this->Order_model->getOrderDetailsByOrderId($order_id);

        if ($orderDetails) {
            $this->load->library("form_validation");
            $this->form_validation->set_rules("status", "Order Status", "required");
            $this->form_validation->set_rules("comment", "Comment", "required");

            if ($this->form_validation->run() === false) {

                $data["orderDetails"] = $orderDetails;
                $data["productDetails"] = $this->Order_model->getOrderDetails($order_id);
                $data["orderHistory"] = $this->Order_model->getOrderHistory($order_id);
                $data["orderStatus"] = $this->Order_model->getOrderStatusList();
                $data["pageTitle"] = "Admin || Order Details";
               
                $data["paymentDetails"] = $this->Order_model->getPaymentDetail($order_id);
                $this->load->view("admin/order/details", $data);
            } else {
                $insertData = [
                    "orders_id" => $order_id,
                    "status" => $this->input->post("status"),
                    "comment" => $this->input->post("comment"),
                ];
                if ($this->input->post("notify")) {
                    $insertData["customer_notified"] = 1;

                    //get User Id
                    $user_q = $this->Common_model->getAll('orders', array('orders_id' => $order_id))->row_array();
                    $user_id = $user_q['user_id'];

                    //Get Mobile Number
                    $mom_q = $this->Common_model->getAll('users', array('id' => $user_id))->row_array();
                    $mobile = $mom_q['phone'];
                    $msg_one = $this->input->post("comment");
                    $msg_two = '  From ATZ Cart';
                    $msg = $msg_one . ' ' . $msg_two;
                    $this->sendSms($mobile, $msg);
                }
                $this->Order_model->addOrderHistory($insertData);
                redirect("admin/order/view/" . $order_id, "refresh");
            }
        } else {
            $error = "<div class='alert alert-danger alert-dismissible'>
					<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
					<strong>Error!</strong> Invalid Order Id.
				  </div>";
            $this->session->set_flashdata("message", $error);
            redirect("admin/order", "refresh");
        }
    }

    public function ajax_list() {
        //$user_id = $this->session->userdata("user_id");

        $columns = array(
            0 => 'orders_id',
            1 => 'user_name',
            2 => 'orders_status_name',
            3 => 'order_price',
            4 => 'date_purchased',
        );

        $limit = $this->input->post('length');
        $start = $this->input->post('start');
        $order = $columns[$this->input->post('order')[0]['column']];
        $dir = "desc";

        $totalData = $this->Order_model->all_order_count();


        $totalFiltered = $totalData;

        if (empty($this->input->post('search')['value'])) {
            $alorder = $this->Order_model->allorder($limit, $start, $order, $dir);
        } else {
            $search = $this->input->post('search')['value'];

            $alorder = $this->Order_model->order_search($limit, $start, $search, $order, $dir);
            //echo $this->db->last_query();

            $totalFiltered = $this->Order_model->order_search_count($search);
        }

        $data = array();
        if (!empty($alorder)) {
            foreach ($alorder as $br) {
                $nestedData['orders_id'] = $br->orders_id;
                $nestedData['user_name'] = $br->user_name;
                $nestedData['orders_status_name'] = $br->orders_status_name;
                $nestedData['order_price'] = $br->order_price;
                $nestedData['date_purchased'] = $br->date_purchased;
                $nestedData['action'] = '<a type="button" title="View & Action" class="btn btn-primary btn-sm"  href="' . site_url() . 'admin/order/view/' . $br->orders_id . '">view&nbsp;<i class="fa fa-arrow-down"></i></a>';

                if ($br->awb_number != 0) {
                    //$action.=' <a type="button" href="'.base_url().'wayBill_generate/waybill_'.$br->orders_id.'.pdf" class="btn btn-success btn-sm">WayBill</a>';
                    $nestedData['action'] .= ' <a type="button" href="' . base_url() . 'admin/order/view_waybill/' . $br->orders_id . '" class="btn btn-success btn-sm">WayBill</a>';
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

    //Send SMS
    function sendSms($mob, $msg) {
        if ($mob > 0) {
            $message = urlencode($msg);
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, "http://sms.smslab.in/api/sendhttp.php?authkey=271209AqkMbb4pSiXR5ca89dc7&mobiles=" . $mob . "&message=" . $message . "&new&mobile&sender=ATZCRT&route=4");
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            $res = curl_exec($ch);
            curl_close($ch);
            //return 'success';
        } else {
            //return 'error';
        }
    }

    function view_waybill($order_id = 0) {

        if ($order_id != 0) {
            $orderDetails = $this->Order_model->getOrderDetailsByOrderId($order_id);
            //echo'<pre>';
            //print_r($orderDetails);
            //exit;
            //$user_id=$this->session->userdata("user_id");

            $data['order_id'] = $order_id;
            $this->load->view("admin/order/waybill", $data);
        }
    }

    function track_order($order_id) {
        if ($order_id != 0) {
            $orderDetails = $this->Order_model->getOrderDetailsByOrderId($order_id);

            $user_id = $this->session->userdata("user_id");
//			if($user_id==$orderDetails[0]['seller'])
//			{
            //Get Latest Tracking Status//
            $this->shipping->latest_tracking_status($order_id);

            $data['order_id'] = $order_id;
            $data['hist_dat'] = $this->Order_model->get_order_status($order_id);

            $this->load->view("admin/order/track_order", $data);
            //}
//			else{
//						$error = "<div class='alert alert-danger alert-dismissible'>
//								<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
//								<strong>Error!</strong> Wrong Order Details !
//							  </div>";
//						$this->session->set_flashdata("message", $error);
//						redirect('admin/dashboard');
//			}
        }
    }

    function generate_waybill($orders_id) {

        $user_id = $this->session->userdata("user_id");
        if (!empty($user_id)) {

            $res = $this->shipping->way_bill($orders_id);

            $awb_no = $res->GenerateWayBillResult->AWBNo;


            if (!empty($awb_no)) {
                $awb_pdf = $res->GenerateWayBillResult->AWBPrintContent;
                $file_name = 'uploads/wayBill_generate/waybill_' . $orders_id . '.pdf';
                file_put_contents($file_name, $awb_pdf);


                $dat['awb_number'] = $awb_no;
                $up = $this->Common_model->update('orders', $dat, array('orders_id' => $orders_id));
                if ($up) {
                    $error = "<div class='alert alert-success alert-dismissible'>
							<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
							<strong>Success !</strong> Way Bill Generate Successfully !
						  </div>";
                    $this->session->set_flashdata("message", $error);
                }
            } else {
                $error = "<div class='alert alert-danger alert-dismissible'>
							<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
							<strong>Error !</strong> Somthing Wrong !
						  </div>";
                $this->session->set_flashdata("message", $error);
            }
        }
        redirect("admin/order/all_orders", "refresh");
    }

    public function approve_decline($order_id) {
        $det = $this->Order_model->getOrderDetails($order_id);
        if ($det) {
            $amt = $det->order_price;
            $dat['orders_status'] = 12;
            $up = $this->Common_model->update('orders', $dat, array('orders_id' => $order_id));
            $this->Myorders_model->refund_added_to_wallet_from_buyer($order_id);
            $this->order_cancel_notify($order_id);
        }
        redirect("admin/order/all_orders", "refresh");
    }

    function order_cancel_notify($order_id = 0) {


        $this->load->library("Browser_notification");

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
        $msg = 'Order #ORD' . $order_id . ' Rejected By Seller ! Amount has been added to Your wallet';
        $mob = $this->session->userdata("phone");
        $this->send_data->send_sms($msg, $user_phone);

        //Notify To Seller
        $title = 'Order Rejected Approved';
        $msg = "Order #ORD" . $order_id . " Order Rejected Approved By Admin ";
        $tag = 'atzcart.com';
        $this->browser_notification->notifyseller($seller_id, $title, $msg, $tag);

        //To Buyer
        $msg = 'Order #ORD' . $order_id . ' Rejected By Seller ! Amount has been added to Your wallet';
        if (!empty($buyer_firbase)) {
            $type = "Reject";
            $this->browser_notification->notify_buyer('Order Rejected Approved !', $msg, $buyer_firbase, $type, $type_id = '');
        }


        //$msg = 'Order Cancelled by  Buyer ' . $user_name;
        // $tag = date('d M Y');
        //$this->browser_notification->notifyadmin('Order Rejected Approved!', $msg, $tag);
    }

}
