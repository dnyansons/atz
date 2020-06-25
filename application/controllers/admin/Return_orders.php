<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Return_orders extends CI_Controller {

    public function __construct() {
        parent::__construct();
        if (!$this->session->userdata("admin_logged_in")) {
            $error = "<div class='alert alert-danger alert-info'>
                        <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                        <strong>Error!</strong> Session timeout, relogin!.
                      </div>";
            $this->session->set_flashdata("message", $error);
            redirect("admin/login", "refresh");
        }

        $this->load->model('Returns_model');
        $this->load->model('Refund_model');
        $this->load->model('Common_model');
        $this->load->model('Order_model');
        $this->load->library('Userpermission');
        $this->load->library('Browser_notification');
        $this->load->library('Shiprocket');
        $this->load->library('Shipping');
        $this->load->library('Send_data');
        $this->load->library('awsupload');
    }

    public function index() {

        $this->load->view("admin/return/return_list");
    }

    public function ajax_return_list() {
        $columns = array(
            0 => 'orders_id',
            1 => 'user_id',
            2 => 'seller_id',
            3 => 'order_price',
            4 => 'return_type',
            5 => 'orders_status_name',
            6 => 'delivery_date',
            7 => 'cr_date',
            8 => 'Action'
        );

        $limit = $this->input->post('length');
        $start = $this->input->post('start');
        $order = $columns[$this->input->post('order')[0]['column']];
        $dir = $this->input->post('order')[0]['dir'];
//        $dir = "desc";

        $totalData = $this->Returns_model->allreturs_count();

        $totalFiltered = $totalData;

        if (empty($this->input->post('search')['value'])) {

            $returns = $this->Returns_model->allreturns($limit, $start, $order, $dir);
        } else {

            $search = $this->input->post('search')['value'];

            $returns = $this->Returns_model->returns_search($limit, $start, $search, $order, $dir);

            $totalFiltered = $this->Returns_model->returns_search_count($limit, $start, $search, $order, $dir);
        }

        if (!empty($returns)) {
            foreach ($returns as $ret) {
                $nestedData['order_id'] = $ret->orders_id;
                $nestedData['seller_id'] = $ret->sellername . " " . $ret->sellerlastname;
                $nestedData['user_id'] = $ret->username . " " . $ret->userlastname;
                $nestedData['order_price'] = $ret->order_price;
                $nestedData['return_type'] = $ret->return_type;
                $nestedData['orders_status_name'] = $ret->orders_status_name;
                $nestedData['delivery_date'] = date('d M Y H:i', strtotime($ret->delivery_date));
                $nestedData['cr_date'] = date('d M Y H:i', strtotime($ret->cr_date));
                $nestedData['action'] = '<a href="' . base_url() . 'admin/return_orders/view_return_request/' . $ret->return_orders_id . '" class="btn btn-info btn-sm">View</a>';
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

    public function view_return_request($orders_id) {
        $data['order_id'] = $orders_id;  //Return Order ID

        $this->shipping->return_latest_tracking_status($orders_id);

        $data['orders'] = $this->Order_model->getReturnOrderProducts($orders_id);
        $data['returns'] = $this->Returns_model->view_return_data_admin($orders_id);
        $data['return_order_history'] = $this->Returns_model->return_orders_history($orders_id);
        $data['return_order_shipping'] = $this->Common_model->getAll('return_order_shipping',array('return_orders_id'=>$orders_id))->row();
        $data['bpath']='https://'.$this->config->item("bucket").'.s3.ap-south-1.amazonaws.com/';
        $this->load->view('admin/return/view_return', $data);
    }

    function action_on_return_request() {
        $orders_id = $this->input->post('return_orders_id'); //return order ID

        $return = $this->Common_model->getAll('return_orders', array('return_orders_id' => $orders_id))->row_array();
        $return_orderid = $return['return_orders_id'];

        $orders_status = $this->input->post('orders_status');

        $old_status = $this->input->post('old_status');

        $return_amount = $this->input->post('return_amount');
        $checkshipMethod = $this->Common_model->getAll("return_order_shipping", array('return_orders_id' => $orders_id))->row();
        
        $checkshipMethod_ship_method = $checkshipMethod->ship_vendor_id;

        if ($return['orders_status'] == 23 && $checkshipMethod_ship_method == 2 && $return_orderid == $orders_id) {
            //$postData ='ids=15789682';
            //echo $checkshipMethod->shipment_id;exit;
            $postData = array(
                'shipment_id' => [$checkshipMethod->shipment_id],
                'courier_id' => $checkshipMethod->courier_id,
                'status' => 'assign',
                'is_return' =>1,
            );
            $res = $this->shiprocket->awb_creation(json_encode($postData));
            //echo'<pre>';
            //print_r($postData);
            // print_r($res);
            // exit;
            if ($res["awb_assign_status"] == 1) {
                $morder_id = $return['orders_id'];
                $dat['orders_id'] = $morder_id;
                $dat["orders_status"] = "24";
                $this->Common_model->update('orders', $dat, array('orders_id' => $morder_id));

                $rdat["orders_status"] = "24";
                $rdat['delivery_date'] = $shipping_expected_date;
                $rdat['order_token_number'] = $token_no;
                $rdat['awb_number'] = $res["response"]["data"]["awb_code"];
                $rdat['shipping_start_date'] = date('Y-m-d H:i:s');
                $this->Common_model->update('return_orders', $rdat, array('return_orders_id' => $orders_id));

                $rdatros['awb_number'] = $res["response"]["data"]["awb_code"];
                $labelpostData = json_encode(array(
                    'shipment_id' =>
                    array(
                        0 => $checkshipMethod->shipment_id,
                    ),
                ));
                $resp_url = $this->shiprocket->generate_label($labelpostData);

                $rdatros['awb_url'] = $resp_url;

                $this->Common_model->update('return_order_shipping', $rdatros, array('return_orders_id' => $orders_id));

                $requestData = array(
                    'shipment_id' => [$checkshipMethod->shipment_id],
                    'status' => 'retry',
                );

                $request = $this->shiprocket->pickup_request(json_encode($requestData));

//Order History
                $data_hist['orders_id'] = $morder_id;
                $data_hist['status'] = "24";
                $data_hist['comment'] = $orders_status;
                $order_insert_id = $this->Common_model->insert('orders_history', $data_hist);

                if ($order_insert_id) {

                    $rdata_hist['orders_id'] = $orders_id;
                    $rdata_hist['status'] = "24";
                    $rdata_hist['comment'] = $orders_status;
                    $this->Common_model->insert('return_orders_history', $rdata_hist);

                    $this->order_return_notify($morder_id);

                    $msg = "<div class='alert alert-success alert-success'>
							<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
										<strong>Success !</strong>Return Request Approved !
                    </div>";
                }
            } else {
                $msg = "<div class='alert alert-error alert-info'>
									<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
									<strong>Error !</strong> AWB Not Generated !
								  </div>";
            }
        } elseif ($return['orders_status'] == 23 && $return_orderid == $orders_id && $checkshipMethod_ship_method == 1) {

            //Getting AreaCode From Pincode
            $morder_id = $return['orders_id'];

            $AreaCode = $this->Common_model->getAll('shipping_surface', array('pincode' => $return['pick_pincode']))->row_array();

            //mobile and email
            $User = $this->Common_model->getAll('users', array('id' => $return['user_id']))->row_array();

            //get quantity by order id
            $order_product = $this->Order_model->getReturnOrderProducts($orders_id);

            //for total Weight
            $total_weight = 0;
            $quantity = 0;
            foreach ($order_product as $pro) {
                $total_weight = $total_weight + ($pro->weight * $pro->products_quantity);
                $quantity = $quantity + ($pro->products_quantity);
            }

            //Close Time
            $timestamp = strtotime(date('H:i')) + 60 * 60;
            $time = date('H:i', $timestamp);
            $time = '11:00';

            // Pick up Date
            $curr_date = date('Y-m-d');
            $pick_date = date('Y-m-d', strtotime($curr_date . ' + 2 day'));


            $exp_time = $this->shipping->return_calculate_expected_time($orders_id, $pick_date);
            $additional_days = $exp_time['GetDomesticTransitTimeForPinCodeandProductResult']['AdditionalDays'] . ' ' . 'days';

            $exp_date = $exp_time['GetDomesticTransitTimeForPinCodeandProductResult']['ExpectedDateDelivery'];
            $shipping_expected_date = date('Y-m-d', strtotime($exp_date . ' +' . $additional_days . ''));

            //shippment pickup time;		
            $timestamp = strtotime(date('H:i')) + 60 * 60;
            $shippment_pickup_time = "10:00";

            //Days Difference between pick up and delivery date
            $date1 = strtotime($pick_date);
            $date2 = strtotime($shipping_expected_date);
            $datediff = $date2 - $date1;

            $ship_date['ex_shipping_days'] = abs(round($datediff / (60 * 60 * 24)));
            $ship_date['shipping_start_date'] = $pick_date;
            $ship_date['delivery_date'] = $shipping_expected_date;

            $this->Common_model->update('return_orders', $ship_date, array('return_orders_id' => $return_orderid));

            $pickData['AreaCode'] = 'PNQ';
            $pickData['ContactPersonName'] = $return['pick_name'];

            $pickData['CustomerAddress1'] = $return['pick_addr_type'];
            $pickData['CustomerAddress2'] = $return['pick_country'];
            $pickData['CustomerAddress3'] = $return['pick_state'];
            $pickData['CustomerCode'] = CustomerCode;
            $pickData['CustomerName'] = $return['pick_name'];
            $pickData['CustomerPincode'] = $return['pick_pincode'];
            $pickData['CustomerTelephoneNumber'] = $return['pick_mobile'];
            $pickData['DoxNDox'] = '1';
            $pickData['EmailID'] = $User['email'];
            $pickData['MobileTelNo'] = $User['phone'];
            $pickData['NumberofPieces'] = $quantity;
            $pickData['OfficeCloseTime'] = $time;
            $pickData['ProductCode'] = 'E';
            $pickData['ReferenceNo'] = 'RETURNORD' . $orders_id;
            $pickData['Remarks'] = 'ATZ CART';
            $pickData['RouteCode'] = '99';
            $pickData['ShipmentPickupDate'] = $pick_date;
            $pickData['ShipmentPickupTime'] = $shippment_pickup_time;
            $pickData['VolumeWeight'] = $total_weight;
            $pickData['WeightofShipment'] = $total_weight;

            if ($areaCode == 'PNQ') {
                $pickData['isToPayShipper'] = 'N';
            } else {
                $pickData['isToPayShipper'] = 'Y';
            }

            //From Api Pick Up Registration and Way Billl Generation
            $token_no = $this->shipping->return_pickupRegistration($pickData);

            if (!empty($token_no)) {
                $dat['orders_id'] = $morder_id;
                $dat["orders_status"] = "24";
                $this->Common_model->update('orders', $dat, array('orders_id' => $morder_id));

                $dat['delivery_date'] = $shipping_expected_date;
                $dat['order_token_number'] = $token_no;

                $return_order_id = $return["return_orders_id"];
                //insert into Return Order Shipping
                $rdatros['delivery_date'] = $shipping_expected_date;
                $rdatros['order_token_number'] = $token_no;
                $this->Common_model->update('return_order_shipping', $rdatros, array('return_orders_id' => $return_order_id));

                //Generate Way Bills 
                $res = $this->shipping->return_way_bill($return_order_id);

                $dat['awb_number'] = $res->GenerateWayBillResult->AWBNo;

                if (!empty($res->GenerateWayBillResult->AWBNo)) {

                    $rdatrosawb['awb_number'] = $res->GenerateWayBillResult->AWBNo;
                    $this->Common_model->update('return_order_shipping', $rdatrosawb, array('return_orders_id' => $return_order_id));

                    $awb_pdf = $res->GenerateWayBillResult->AWBPrintContent;

                    $this->Common_model->update('return_orders', $dat, array('return_orders_id' => $orders_id));

                    $file_name = 'uploads/return_wayBill_generate/retwaybill_' . $orders_id . '.pdf';

                    
                    $this->awsupload->filePutContents($file_name, $awb_pdf,'document');
                   


                    //Order History
                    $data_hist['orders_id'] = $morder_id;
                    $data_hist['status'] = "24";
                    $data_hist['comment'] = $orders_status;
                    $order_insert_id = $this->Common_model->insert('orders_history', $data_hist);

                    if ($order_insert_id) {

                        $rdata_hist['orders_id'] = $orders_id;
                        $rdata_hist['status'] = "24";
                        $rdata_hist['comment'] = $orders_status;
                        $this->Common_model->insert('return_orders_history', $rdata_hist);

                        $this->order_return_notify($morder_id);

                        $msg = "<div class='alert alert-success alert-success'>
							<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
										<strong>Success !</strong>Return Request Approved !
									  </div>";
                    } else {

                        $msg = "<div class='alert alert-error alert-danger'>
									<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
									<strong>Error !</strong> Order Not Generated;
								  </div>";
                    }
                } else {

                    $msg = "<div class='alert alert-error alert-info'>
									<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
									<strong>Error !</strong> " . $res->GenerateWayBillResult->Status->WayBillGenerationStatus->StatusInformation . "
								  </div>";
                }
            } else {

                $msg = "<div class='alert alert-error alert-danger'>
									<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
									<strong>Error !</strong> Token Not Accepted
								  </div>";
            }
        } else {

            $msg = "<div class='alert alert-error alert-danger'>
									<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
									<strong>Error !</strong> Not Updated !
								  </div>";
        }

        $this->session->set_flashdata('message', $msg);
        redirect('admin/return_orders');
    }

    function action_on_refund() {

        $return_order_id = $this->input->post('return_orders_id');
        $returnby = $this->input->post('returnby');
        $refund_amount = $this->input->post('refund_amount');

        if (!empty($return_order_id) && !empty($returnby) && $refund_amount > 0) {
            //get Return Data
            $rorder_data = $this->Returns_model->view_return_data_admin($return_order_id);

            $morder_id = $rorder_data[0]->orders_id;

            $this->db->select('order_price,shippment_type,shipping_cost');
            $this->db->from('orders');
            $this->db->where('orders_id', $morder_id);
            $ship_q = $this->db->get()->row();
            $ship = $ship_q->shippment_type;
            $morder_price = $ship_q->order_price;
            $mshipping_cost = $ship_q->shipping_cost;


            $user_id = $rorder_data[0]->user_id; 
            $seller_id = $rorder_data[0]->seller_id;
            $shipping_cost = $rorder_data[0]->shipping_cost;
           // $product_amount= round($rorder_data[0]->order_price-$rorder_data[0]->shipping_cost,2);
           
            
            if ($ship == 'Free') {
                $product_amount = round($morder_price, 2);
            } else {
                $product_amount = round($morder_price - $mshipping_cost, 2);
            }
           // echo '|'.$product_amount;exit;
            //$product_amount = round($rorder_data[0]->order_price, 2);

            if ($returnby == 'buyer') {
                $buyer_amount_refund = $product_amount - $shipping_cost;
            } else {
                $buyer_amount_refund = $product_amount;
            }

            if ($buyer_amount_refund != 0) {
                $this->Refund_model->refund_to_buyer($user_id, $morder_id, $buyer_amount_refund);
            }

            $this->order_refund_notify($morder_id, $buyer_amount_refund);



            if ($returnby == 'seller') {
                //Deduct from Seller Wallet
                $seller_amount_deduct = $shipping_cost;
                $this->Refund_model->deduct_from_seller($seller_id, $morder_id, $seller_amount_deduct);
                $this->order_deduct_notify($morder_id, $seller_amount_deduct);
            }

            //Update Return Order
            $rorder['orders_status'] = 12;
            $rorder['shipping_cost_pay_by'] = $returnby;
            $up = $this->Common_model->update('return_orders', $rorder, array('return_orders_id' => $return_order_id));
            //in Main Order
            $morder['orders_status'] = 12;
            $this->Common_model->update('orders', $morder, array('orders_id' => $morder_id));
            ///Enter in Return Order History 
            if ($up) {

                //main history Table
                $data_hist['orders_id'] = $morder_id;
                $data_hist['status'] = "24";
                $data_hist['comment'] = "Amount Refunded / Deduct against Order #" . $morder_id;
                $this->Common_model->insert('orders_history', $data_hist);


                $insertHistory['orders_id'] = $return_order_id;
                $insertHistory['status'] = 12;
                $insertHistory['date_added'] = date('Y-m-d H:i:s');
                $insertHistory['comment'] = 'Amount Refunded / Deduct against Order #' . $morder_id;
                $insertHistory['customer_notified'] = 1;
                $this->Common_model->insert('return_orders_history', $insertHistory);
            }


            $msg = "<div class='alert alert-error alert-info'>
                                                                                <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                                                                                <strong>Success !</strong> Refund Successfully !
                                                                          </div>";
        } else {
            $msg = "<div class='alert alert-error alert-info'>
									<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
									<strong>Error !</strong> Somthing Wrong !
								  </div>";
        }
        $this->session->set_flashdata('message', $msg);
        redirect('admin/report/return_report');
    }

    function generate_return_waybill($orders_id) {


        $user_id = $this->session->userdata("user_id");
        if (!empty($user_id)) {
            //echo'<pre>';
            $res = $this->shipping->way_bill($orders_id);
            // print_r($res);

            $awb_no = $res->GenerateWayBillResult->AWBNo;


            if (!empty($awb_no)) {
                $awb_pdf = $res->GenerateWayBillResult->AWBPrintContent;
                
               
                $file_name ='uploads/return_wayBill_generate/waybill_' . $orders_id . '.pdf';

                $this->awsupload->filePutContents($file_name, $awb_pdf,'document');

                $dat['awb_number'] = $awb_no;
                $up = $this->Common_model->update('orders', $dat, array('orders_id' => $orders_id));
                if ($up) {
                    $error = "<div class='alert alert-success alert-info'>
							<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
							<strong>Success !</strong> Way Bill Generate Successfully !
						  </div>";
                    $this->session->set_flashdata("message", $error);
                }
            } else {
                $error = "<div class='alert alert-danger alert-info'>
							<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
							<strong>Error !</strong> Somthing Wrong !
						  </div>";
                $this->session->set_flashdata("message", $error);
            }
        }
        redirect("admin/report/return_report", "refresh");
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

    function return_track_order($order_id) {
        if ($order_id != 0) {
            $orderDetails = $this->Order_model->getOrderDetailsByReturnOrderId($order_id);

            //Get Latest Tracking Status//
            $this->shipping->return_latest_tracking_status($order_id);

            $data['order_id'] = $order_id;
            $data['hist_dat'] = $this->Order_model->get_return_order_status($order_id);

            $this->load->view("admin/return/return_track_order", $data);
        }
    }

    function order_return_notify($order_id = 0) {

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
        $msg = 'Return Request Approved By Admin of Order #ORD' . $order_id . '';
        $mob = $user->phone;
        $this->send_data->send_sms($msg, $user_phone);

        //Notify To Seller
        $title = 'Return Order  Request Approved';
        $msg = "Return Request Approved  of  #ORD" . $order_id . " By Admin ";
        $tag = '';
        $this->browser_notification->notifyseller($seller_id, $title, $msg, $tag);

        //To Buyer
        if (!empty($buyer_firbase)) {
            $msg = "Return Order Request Approved of  #ORD" . $order_id;
            $type = "Return";
            $this->browser_notification->notify_buyer('Return Request Approved!', $msg, $buyer_firbase, $type, $type_id = '');
        }
    }

    function order_refund_notify($order_id = 0, $amount) {

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
        $msg = 'Amount Rs. ' . $amount . ' refunded against Order #' . $order_id . ' Thank You to Use ATZ Cart ! If any Query Visit Site atzcart.com';
        $mob = $user->phone;
        $this->send_data->send_sms($msg, $user_phone);

        //Notify To Seller
        $title = 'Amount Refunded !';
        $msg = "Amount refunded against Order #" . $order_id . ' In Buyer Account';
        $tag = '';
        $this->browser_notification->notifyseller($seller_id, $title, $msg, $tag);

        //To Buyer
        if (!empty($buyer_firbase)) {
            $msg = "Amount refunded against Order #" . $order_id;
            $type = "Return";
            $this->browser_notification->notify_buyer('Amount Refunded !', $msg, $buyer_firbase, $type, $type_id = '');
        }
    }

    function order_deduct_notify($order_id = 0, $amount) {

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


        //Notify To Seller
        $title = 'Amount Deducted !';
        $msg = "Amount Rs. " . $amount . " Deducted against Order #" . $order_id;
        $tag = '';
        $this->browser_notification->notifyseller($seller_id, $title, $msg, $tag);
    }

}
