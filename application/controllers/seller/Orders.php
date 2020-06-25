<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Orders extends CI_Controller {

    public function __construct() {
        parent::__construct();
        if (!$this->session->userdata("user_logged_in") || $this->session->userdata("user_role") != "seller") {
            $error = "<div id='login-error' class='form-error notice notice-error'><span class='icon-notice icon-error'></span><span><strong>Error!</strong> Session timeout, relogin!. </span></div>";
            $this->session->set_flashdata("message", $error);
            redirect("login", "refresh");
        }
        $this->load->library('Shipping');
        $this->load->library('Shiprocket');
        $this->load->library('Send_data');
        $this->load->model('Common_model');
        $this->load->model('Order_model');
        $this->load->model('Shipping_model');
        $this->load->model('Myorders_model');
        $this->load->library('awsupload');
    }

    public function index() {
        $data["pageTitle"] = "All Orders";
        $data["orderStatus"] = $this->Order_model->getOrderStatusList();
        //$data["orders_status"] = 4;
        $this->load->view("user/orders/list", $data);
    }

    public function completed() {
        $data["pageTitle"] = "Completed Orders";
        $data["orderStatus"] = $this->Order_model->getOrderStatusList();
        $data["orders_status"] = 4;
        $this->load->view("user/orders/list", $data);
    }

    public function processing() {
        $data["pageTitle"] = "Processing Orders";
        $data["orderStatus"] = $this->Order_model->getOrderStatusList();
        $data["orders_status"] = 10;
        $this->load->view("user/orders/list", $data);
    }

    public function rejected() {
        $data["pageTitle"] = "Rejected Orders";
        $data["orderStatus"] = $this->Order_model->getOrderStatusList();
        $data["orders_status"] = 17;
        $this->load->view("user/orders/list", $data);
    }

    public function ajax_list() {
        $order_id = $this->input->post('filter_order_id');
        $status_id = $this->input->post('filter_order_status_id');
        $total = $this->input->post('filter_total');
        $date_from = $this->input->post('filter_date_from');
        $date_to = $this->input->post('filter_date_to');


        if ($date_from != '' && $date_to != '') {
            $search_date_from = date('Y-m-d', strtotime($date_from));
            $search_date_to = date('Y-m-d', strtotime($date_to));
        }

        $seller = $this->session->userdata("user_id");

        $orders = $this->Order_model->get_datatables($search_date_from, $status_id, $total, $order_id, $seller, $search_date_to);
        $data = array();
        $no = $this->input->post('start');
        $ch_ord=0;
        foreach ($orders as $order) {

            if ($order->orders_status_name != 'Pending') {
                if($ch_ord!=$order->orders_id)
                {
                    $ch_ord=$order->orders_id;
                //checke Shipping
                $ship = $this->Common_model->getAll('order_shipping', array('orders_id' => $order->orders_id))->row();


                $btnAction = '';
//            $delivery_date=date("Y", strtotime($order->delivery_date));
//            if($delivery_date==1970 || $delivery_date == '0000-00-00')
//            {
//                $delivery_date='----';
//            }else{
//                 $delivery_date=date("d-m-Y", strtotime($order->delivery_date));
//            }
                $deliveryDated = strtotime($order->delivery_date);
                $delivery_date = date("Y", strtotime($order->delivery_date));
                if ($deliveryDated < 0 || $delivery_date < 2018) {
                    $delivery_date = '----';
                } else {
                    $delivery_date = date("d-m-Y", strtotime($order->delivery_date));
                }

                //Order Status
                if ($order->orders_status_name == 'Pending') {
                    $ord_status = '<span class="label label-danger">' . $order->orders_status_name . '</span>';
                } else {
                    $ord_status = '<span class="label label-success">' . $order->orders_status_name . '</span>';
                }

                $no++;
                $row = array();

                if ($order->orders_status == 10) {
                    $btnAction = "<a href='" . site_url() . "seller/orders/order_reject/" . $order->orders_id . "' class='label label-danger'  onclick='return confirm(&#39;Are You Sure ?&#39;)'>Decline Order</a><br><br>";
                    $btnAction = $btnAction . "<a href='" . site_url() . "seller/orders/pickupregister/" . $order->orders_id . "' class='pk_order label label-primary'  onclick='return check_order();'>Pack Order</a><br><br>";
                } elseif ((!empty($ship->awb_number)) && $ship->ship_vendor_id == 2) {
                    if (!empty($ship->awb_url)) {
                       
                        $btnAction = "<a style='margin: 1px;' href='" . $ship->awb_url . "' class='label label-info' style='margin:5px;'>Download Way Bill</a><br>";
                    }
                } elseif (!empty($order->awb_number)) {
                     $bpath='https://'.$this->config->item("bucket").'.s3.ap-south-1.amazonaws.com/';
                    $btnAction = "<a style='margin: 1px;' href='" . $bpath . "uploads/wayBill_generate/waybill_" . $order->orders_id . ".pdf' class='label label-info' style='margin:5px;'>Download Way Bill<a><br>";
                }
                $btnAction.="<a href='" . site_url() . "seller/orders/track_order/" . $order->orders_id . "' class='label label-warning' >Track Order</a>";

                $row[] = $btnAction;
                $row[] = "<a href='" . site_url() . "seller/orders/view/" . $order->orders_id . "' class='btn btn-link text-primary' >ORD" . $order->orders_id . "</a>";
                $row[] = date("d-m-Y", strtotime($order->date_purchased));
                $row[] = $delivery_date;
                $row[] = $order->user_name . "<br>" . $order->user_telephone . "<br>" . $order->user_email_address;
                $row[] = "<a href='" . site_url() . "seller/orders/view/" . $order->orders_id . "' class='label label-info' >View<a>";
                $row[] = "<strong>$order->delivery_name</strong>, <br />"
                        . "$order->delivery_street_address, <br >"
                        . "$order->delivery_suburb, <br />"
                        . "$order->delivery_city, <br />"
                        . "$order->delivery_state, <br />"
                        . "$order->delivery_postcode, <br />";

                $row[] = $ord_status;
                $row[] = $order->order_price;
                $row[] = $order->shipping_cost;
                $row[] = $order->commission;
                $row[] = $order->gst;
                $row[] = $order->payment_by;
                $row[] = $order->vendor_payable_price;


                $data[] = $row;
            }
            }
        }

        $output = array(
            "draw" => $this->input->post('draw'),
            "recordsTotal" => $this->Order_model->count_all(),
            "recordsFiltered" => $this->Order_model->count_filtered($search_date_from, $status_id, $total, $order_id, $seller, $search_date_to),
            "data" => $data,
        );
        echo json_encode($output);
    }

    public function view($order_id = 0) {


        $seller = $this->session->userdata("user_id");
        $order_details = $this->Order_model->getOrderById($order_id);
        if ($order_details->seller_id == $seller) {
            $data["pageTitle"] = "Order Details";

            //Get Latest Tracking Status//
            $this->shipping->latest_tracking_status($order_id);

            // $data["order_products"] = $this->Order_model->getOrderProducts($order_id);
            $data['orderDetails'] = $this->Order_model->getOrderDetailsByOrderId($order_id);

            $data['sorder'] = $this->Myorders_model->single_order($order_id);
            $data['products'] = $this->Myorders_model->order_products($order_id);
            $this->db->where(["reference_id"=>$order_id,"type"=>"order_place"]);
            $this->db->update("seller_notification",["status"=>"Read"]);
            $data["paymentDetails"] = $this->Order_model->getPaymentDetail($order_id);
            $this->load->view("user/orders/details_new", $data);

        } else {
            $this->load->library('user_agent');
            if ($this->agent->is_referral()) {
                $redirect = $this->agent->referrer();
            } else {
                $redirect = "seller/orders";
            }
            $message = "<div class='alert alert-danger alert-dismissible'>
                        <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                        <strong>Success!</strong> Order Not Exists.
                    </div>";
            $this->session->set_flashdata("message", $message);
            redirect($redirect, "refresh");
        }
    }

    function finalOrderInvoice($order_id) {
        $data['orderDetails'] = $this->Order_model->getOrderDetailsByOrderId($order_id);
        $data['sorder'] = $this->Myorders_model->single_order($order_id);
        $this->load->view("user/orders/final_order_invoice", $data);
    }

    function sellerOrderDetailsInvoice($order_id) {

        $result = $this->Order_model->getUserOrders_invoice($order_id);
        $res = $this->Order_model->getOrderDetailsForInvoice($result->orders_id);
        $result->product_details = $res;
        $data['orderDetails'] = $result;
        $this->load->view("user/orders/seller_orderdetail_invoice", $data);
    }

    function view_waybill($order_id = 0) {

        if ($order_id != 0) {

            //checke Shipping
            /* $ship = $this->Common_model->getAll('order_shipping', array('orders_id' => $order_id))->row();
              if ($ship->ship_vendor_id == 2) {
              $postData = json_encode(array(
              'shipment_id' =>
              array(
              0 => 18384403,
              ),
              ));
              $resp_url = $this->shiprocket->generate_label($postData);
              } */

            $orderDetails = $this->Order_model->getOrderDetailsByOrderId($order_id);

            $user_id = $this->session->userdata("user_id");
            if ($user_id == $orderDetails[0]['seller']) {
                $data['order_id'] = $order_id;
                $data["pageTitle"] = "Waybill details";
                $data['bpath']='https://'.$this->config->item("bucket").'.s3.ap-south-1.amazonaws.com/';
                $this->load->view("user/orders/waybill", $data);
            } else {
                $error = "<div class='alert alert-danger alert-dismissible'>
                           <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                           <strong>Error!</strong> Wrong Order Details !
                            </div>";
                $this->session->set_flashdata("message", $error);
                redirect('seller/orders');
            }
        }
    }

    function track_order($order_id) {
        if ($order_id != 0) {
            $orderDetails = $this->Order_model->getOrderDetailsByOrderId($order_id);

            $user_id = $this->session->userdata("user_id");
            if ($user_id == $orderDetails[0]['seller']) {
                //Get Latest Tracking Status//
                $this->shipping->latest_tracking_status($order_id);

                $data['order_id'] = $order_id;
                $data['hist_dat'] = $this->Order_model->get_order_status($order_id);
                $data["pageTitle"] = "Order Tracking";
                $this->load->view("user/orders/track_order", $data);
            } else {
                $error = "<div class='alert alert-danger alert-dismissible'>
								<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
								<strong>Error!</strong> Wrong Order Details !
							  </div>";
                $this->session->set_flashdata("message", $error);
                redirect('seller/orders');
            }
        }
    }

    function pickupregister($orders_id = 0) {
        //Get Order
        $orderDetails = $this->Order_model->getOrderDetailsById($orders_id);
        $order_product = $this->Order_model->getOrderProducts($orders_id);

        $checkshipMethod = $this->Common_model->getAll("order_shipping", array('orders_id' => $orders_id))->row();

        if ($checkshipMethod->ship_vendor_id == 2) {
            //$postData ='ids=15789682';
            $postData = array(
                'shipment_id' => [$checkshipMethod->shipment_id],
                'courier_id' => $checkshipMethod->courier_id,
                'status' => 'assign',
            );
            $res = $this->shiprocket->awb_creation(json_encode($postData));
           
            if ($res["awb_assign_status"] == 1) {

                $dat['ShipmentPickupDate'] = date('Y-m-d H:i:s');
                $dat['orders_status'] = 26;
                $this->Common_model->update('orders', $dat, array('orders_id' => $orders_id));

                //Order Request
                $insertHistory['orders_id'] = $orders_id;
                $insertHistory['status'] = 26;
                $insertHistory['date_added'] = date('Y-m-d H:i:s');
                $insertHistory['comment'] = 'Order Packed From Seller';
                $insertHistory['customer_notified'] = 1;
                $this->Common_model->insert('orders_history', $insertHistory);


                $postData = json_encode(array(
                    'shipment_id' =>
                    array(
                        0 => $checkshipMethod->shipment_id,
                    ),
                ));
                $resp_url = $this->shiprocket->generate_label($postData);

                $upship['awb_url']=$resp_url;
                $upship['awb_number'] = $res["response"]["data"]["awb_code"];
                $upship['shipping_start_date'] = date('Y-m-d H:i:s');
                $this->Common_model->update('order_shipping', $upship, array('orders_id' => $orders_id));


                $requestData = array(
                    'shipment_id' => [$checkshipMethod->shipment_id],
                    'status' => 'retry',
                );

                $request = $this->shiprocket->pickup_request(json_encode($requestData));

                //Send Notification
                $this->order_packed_notify($orders_id);
                $error = "<div class='alert alert-success alert-dismissible'>
                          <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                          <strong>Success !</strong> Order  Packed Successfully ! </div>";
                $this->session->set_flashdata("message", $error);
            } else {
                $error = "<div class='alert alert-danger alert-dismissible'>
                        <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                        <strong>Error !</strong> AWB Not Generated ! </div>";
                $this->session->set_flashdata("message", $error);
            }
        } else {

            $areaCode_q = $this->Common_model->getAll('order_accepted_dimention', array('orders_id' => $orders_id))->row_array();
            $areaCode = $areaCode_q['pick_area_code'];
            $pick_id = $areaCode_q['pick_id'];

            $quantity = 0;
            $actual_order_price = 0;
            $total_weight = 0;
            foreach ($order_product as $product):
                $quantity = $quantity + $product->products_quantity;
                $actual_order_price = $actual_order_price + $product->grand_price;
                $total_weight = $total_weight + ($product->weight * $product->products_quantity);
            endforeach;

            //Expected Time Calculation
            $curr_date = date('Y-m-d');
            $pick_date = $curr_date;

            $exp_time = $this->shipping->calculate_expected_time($orders_id, $pick_id, $pick_date);

            $additional_days = $exp_time['GetDomesticTransitTimeForPinCodeandProductResult']['AdditionalDays'] . ' ' . 'days';

            $exp_date = $exp_time['GetDomesticTransitTimeForPinCodeandProductResult']['ExpectedDateDelivery'];

            $shipping_expected_date = date('Y-m-d', strtotime($exp_date . ' +' . $additional_days . ''));

            //Days Difference between pick up and delivery date
            $date1 = strtotime($pick_date);
            $date2 = strtotime($shipping_expected_date);
            $datediff = $date2 - $date1;

            $ship_date['ex_shipping_days'] = abs(round($datediff / (60 * 60 * 24)));
            $ship_date['shipping_start_date'] = $pick_date;
            $ship_date['delivery_date'] = $shipping_expected_date;


            $this->Common_model->update('orders', $ship_date, array('orders_id' => $orders_id));



            $paddress = $this->Common_model->getAll('seller_pick_address', array('pick_id' => $pick_id))->row_array();

            $address1 = $paddress['address'];

            if ($paddress['address2'] == '..') {
                $address2 = $orderDetails->pick_state;
            } else {
                $address2 = $paddress['address2'];
            }

            if ($paddress['address3'] == '..') {
                $address3 = $orderDetails->pick_addr_type;
            } else {
                $address3 = $paddress['address3'];
            }
            //Order Pick Up Registration

            $pickData['AreaCode'] = 'PNQ';
            $pickData['ContactPersonName'] = $orderDetails->pick_name;
            $pickData['CustomerAddress1'] = substr($address1, 0, 29);
            $pickData['CustomerAddress2'] = substr($address2, 0, 29);
            $pickData['CustomerAddress3'] = substr($address3, 0, 29);
            $pickData['CustomerCode'] = CustomerCode;
            $pickData['CustomerName'] = $orderDetails->pick_name;
            $pickData['CustomerPincode'] = $orderDetails->pick_pincode;
            $pickData['CustomerTelephoneNumber'] = $orderDetails->pick_mobile;
            $pickData['DoxNDox'] = '1';
            $pickData['EmailID'] = $orderDetails->pick_email;
            $pickData['MobileTelNo'] = $orderDetails->pick_mobile;
            $pickData['NumberofPieces'] = $quantity;
            $pickData['OfficeCloseTime'] = $paddress['office_close'];
            $pickData['ProductCode'] = 'E';
            //$pickData['ReferenceNo'] = 'ORD'.$orders_id; 
            $pickData['ReferenceNo'] = 'ATZ_ORD' . $orders_id;
            $pickData['Remarks'] = 'ATZ CART';
            $pickData['RouteCode'] = '99';
            $pickData['ShipmentPickupDate'] = $pick_date;
            $pickData['ShipmentPickupTime'] = date('H:i');
            $pickData['VolumeWeight'] = $total_weight;
            $pickData['WeightofShipment'] = $total_weight;
            if ($areaCode == 'PNQ') {
                $pickData['isToPayShipper'] = 'N';
            } else {
                $pickData['isToPayShipper'] = 'Y';
            }
            $pick_register_dat = $this->shipping->pickupRegistration($pickData);

            $ShipmentPickupDate = $pick_register_dat['ShipmentPickupDate'];
            $token_no = $pick_register_dat['token'];

            if (!empty($token_no)) {
                $dat['ShipmentPickupDate'] = $ShipmentPickupDate;
                $dat['order_token_number'] = $token_no;
                $dat['orders_status'] = 26;
                $this->Common_model->update('orders', $dat, array('orders_id' => $orders_id));

                $upship['order_token_number'] =$token_no;
                $upship['shipping_start_date'] = date('Y-m-d H:i:s');
                $this->Common_model->update('order_shipping', $upship, array('orders_id' => $orders_id));
                
                //Order Request
                $insertHistory['orders_id'] = $orders_id;
                $insertHistory['status'] = 26;
                $insertHistory['date_added'] = date('Y-m-d H:i:s');
                $insertHistory['comment'] = 'Order Packed From Seller';
                $insertHistory['customer_notified'] = 1;
                $this->Common_model->insert('orders_history', $insertHistory);

                //Generate Way Bill
                $this->generate_waybill($orders_id);

                //Send Notification
                $this->order_packed_notify($orders_id);
                $error = "<div class='alert alert-success alert-dismissible'>
                          <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                          <strong>Success !</strong> Order  Packed Successfully ! </div>";
                $this->session->set_flashdata("message", $error);
            } else {
                $error = "<div class='alert alert-danger alert-dismissible'>
                        <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                        <strong>Error !</strong> Not Generated ! </div>";
                $this->session->set_flashdata("message", $error);
            }
        }
        redirect('seller/orders');
    }

    function approve_cancel_order_request() {

        $order_id = $this->input->post('order_id');

        if ($order_id != 0) {

            $orderDetails = $this->Order_model->getOrderDetailsByOrderId($order_id);

            $user_id = $this->session->userdata("user_id");
            if ($user_id == $orderDetails[0]['seller']) {
                $dat['orders_status'] = 21;
                $up = $this->Common_model->update('orders', $dat, array('orders_id' => $order_id, 'orders_status' => 20));

                if ($up) {
                    //Order History
                    $orderHistory['orders_id'] = $order_id;
                    $orderHistory['status'] = 21;
                    $orderHistory['date_added'] = date('Y-m-d H:i:s');
                    $orderHistory['comment'] = 'Order Cancel Request Approved !';


                    //Get refunf Amount
                    $ch_refund = $this->Common_model->getAll('orders_history', array('status' => 18, 'orders_id' => $order_id))->num_rows();
                    if ($ch_refund > 0) {
                        $ord_ref['refund_amount'] = $orderDetails[0]['order_price'] - $orderDetails[0]['shipping_cost'];
                    } else {
                        $ord_ref['refund_amount'] = $orderDetails[0]['order_price'];
                    }

                    //Update Order refund_amount
                    $this->Common_model->update('order_refund', $ord_ref, array('orders_id' => $order_id));


                    //Cancel Pick Up Registration
                    $ch_pick = $this->Common_model->getAll('orders_history', array('status' => 4, 'orders_id' => $order_id))->num_rows();

                    if ($ch_pick == 0) {

                        if ($orderDetails[0]['order_token_number'] != 0) {

                            $token_no = $orderDetails[0]['order_token_number'];
                            $pickup_date = $orderDetails[0]['shipping_start_date'];

                            $res = $this->shipping->cancel_pickup($token_no, $pickup_date);
                        }

                        if ($orderDetails[0]['awb_number'] != 0) {
                            $res = $this->shipping->cancelwaybill($order_id);
                        }
                    }


                    $this->Common_model->insert('orders_history', $orderHistory);
                }
            } else {
                $error = "<div class='alert alert-danger alert-dismissible'>
								<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
								<strong>Error!</strong> Wrong Order Details !
							  </div>";
                $this->session->set_flashdata("message", $error);
                redirect('seller/orders');
            }
        }
    }

    public function accept() {

        $order_id = $this->input->post("order_id");
        $weight = ($this->input->post("weight"));

        $height = ($this->input->post("height"));
        $length = ($this->input->post("length"));
        $width = ($this->input->post("width"));
        $pick_id = $this->input->post("pick_id");
        $pick_days = $this->input->post("pick_days");

        if (is_numeric($weight) && is_numeric($height) && is_numeric($length) && is_numeric($pick_id)) {
            $order_product = $this->Order_model->getOrderProducts($order_id);

            $quantity = 0;
            $actual_order_price = 0;
            foreach ($order_product as $product):
                $quantity = $quantity + $product->products_quantity;
                $actual_order_price = $actual_order_price + $product->grand_price;
            endforeach;

            $total_weight = $weight;

            $rate = $this->Shipping_model->get_shipping_rate($order_id, $pick_id, $total_weight);


            if ($rate <= 0) {
                $error = "<div class='alert alert-danger alert-dismissible'>
								<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
								<strong>Error!</strong> Not Deliverable on this Pin Code !
							  </div>";
                $this->session->set_flashdata("message", $error);
            } else {


                $price = $total_weight * $rate;

                $size = (($height * $length * $width )) * 10;

                $price2 = $size * $rate;

                $Freight = ($price > $price2) ? $price : $price2;


                ////////////////////////Shippin Parameters Start////////////////////////////
                ////////////////////////Shippin Parameters Start////////////////////////////
                /*
                  FS : 35 (Percentage)
                  CAF : 7.5 (Percentage)
                  IDC : 10 (Percentage)
                  AWB : 100 (Value)
                  FOV : 0.2 (Percentage)
                  2 PAY Charge : 50 (Rs) on total amount of Product
                  GST : 18 (Per)
                  VCHC : 100 (IF Greater than 5000)
                 */
                $FS = $Freight * (35 / 100); //FS

                $CAF = ($Freight + $FS) * (7.5 / 100); //CAF

                $IDC = ($Freight + $FS + $CAF) * (10 / 100); //IDC

                $AWB = 75; //AWB

                $FOV = ($actual_order_price * (0.2 / 100)); //FOV
                //Sub Total 
                $sub_total = $Freight + $FS + $CAF + $IDC + $AWB + $VCHC + $FOV;

                if (($actual_order_price / $weight) > 5000) {
                    $VCHC = $sub_total + $actual_order_price; //VCHC;
                } else {
                    $VCHC = 0;
                }

                //Check 2 pay charge
                $check2Paycharge = $this->Shipping_model->get_seller_area($pick_id);

                $areaCode = $check2Paycharge['area'];


                if ($areaCode != 'PNQ') {
                    $sub_total = $sub_total + 50; //2 pay charge if out of Pune
                }

                $GST = $sub_total * (18 / 100); //GST

                $tot_shipping_rate = round($sub_total + $GST, 2);


                ////////////////////////Shipping Parameters End////////////////////////////
                ////////////////////////Shipping Parameters End////////////////////////////
                //Shipping Address From Pick ID
                $paddress = $this->Common_model->getAll('seller_pick_address', array('pick_id' => $pick_id))->row_array();

                /////expected Time from API
                $curr_date = date('Y-m-d');
                $pick_date = date('Y-m-d', strtotime($curr_date . ' +' . $pick_days . ''));

                $exp_time = $this->shipping->calculate_expected_time($order_id, $pick_id, $pick_date);

                $additional_days = $exp_time['GetDomesticTransitTimeForPinCodeandProductResult']['AdditionalDays'] . ' ' . 'days';

                $exp_date = $exp_time['GetDomesticTransitTimeForPinCodeandProductResult']['ExpectedDateDelivery'];

                $shipping_expected_date = date('Y-m-d', strtotime($exp_date . ' +' . $additional_days . ''));



                //Insert Data
                $this->Order_model->updateOrderPrice($order_id, $tot_shipping_rate, $pick_date, $shipping_expected_date);



                //Insert Pick up ADDRESS

                $insertpaddr['pick_name'] = $paddress['seller_name'];

                $insertpaddr['pick_addr_type'] = $paddress['address_type'];
                $insertpaddr['pick_country'] = $paddress['country'];
                $insertpaddr['pick_state'] = $paddress['state'];
                $insertpaddr['pick_mobile'] = $paddress['seller_mobile'];
                $insertpaddr['pick_email'] = $paddress['seller_email'];
                $insertpaddr['pick_pincode'] = $paddress['pincode'];
                $insertpaddr['pick_days'] = $pick_days;

                $this->Common_model->update('orders', $insertpaddr, array('orders_id' => $order_id));


                /////Order Accepted Dimension
                $acceptData['orders_id'] = $order_id;
                $acceptData['length'] = $length;
                $acceptData['width'] = $width;
                $acceptData['height'] = $height;
                $acceptData['weight_per_unit'] = $weight;
                $acceptData['pick_id'] = $pick_id;
                $acceptData['pick_area_code'] = $areaCode;

                $this->Common_model->insert('order_accepted_dimention', $acceptData);

                // Send notification to admin while seller accep/approve order; Developer : Shailesh; Date : 10-05-2019

                $notification_title = 'Seller Accept Order';
                $notification_msg = 'Seller accept his product order request';
                $notification_type = 'Order';
                $reference_id = $order_id;
                add_admin_notification($notification_title, $notification_msg, $notification_type, $reference_id);

                // Send notification code end
                //Order History 
                $orderHistory['orders_id'] = $order_id;
                $orderHistory['status'] = 16;
                $orderHistory['date_added'] = date('Y-m-d H:i:s');
                $orderHistory['comment'] = 'Order Accepted From Seller !';

                $this->Common_model->insert('orders_history', $orderHistory);


                $error = "<div class='alert alert-success alert-dismissible'>
									<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
									<strong>Success!</strong> Order Accept Successfully !
									</div>";
                $this->session->set_flashdata("message", $error);
            }
        } else {
            $error = "<div class='alert alert-danger alert-dismissible'>
								<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
								<strong>Error!</strong> Fill Up Proper Data !
							  </div>";
            $this->session->set_flashdata("message", $error);
        }

        redirect("seller/orders", "refresh");
    }

    function order_reject($order_id = 0) {
        if ($order_id > 0) {
            //check order Status
            $ord = $this->Order_model->getOrderDetailsById($order_id);

            if ($ord->orders_status == 8 || $ord->orders_status == 10) {

                $data['orders_status'] = 17;
                //change order status in order table 
                $this->Common_model->update('orders', $data, array('orders_id' => $order_id));
                //insert into table order history so as to show track order correctly
                //status  = 17 = Rejected
                $this->db->insert('orders_history', array('comment' => 'Order Rejected By Seller',
                    'status' => 17, 'orders_id' => $order_id));

                $error = "<div class='alert alert-success alert-dismissible'>
							<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
							<strong>Success!</strong> Order Reject Successfully !.
						  </div>";
                $this->session->set_flashdata("message", $error);

                // Send notification to admin when user reject the  order; Developer : Shailesh; Date : 10-05-2019

                $notification_title = 'Order Reject By Seller';
                $notification_msg = 'Order Reject By Seller with #ORD' . $order_id;
                $notification_type = 'Order';
                $reference_id = $order_id;
                add_admin_notification($notification_title, $notification_msg, $notification_type, $reference_id);

                // Send notification code end
            } else {
                $error = "<div class='alert alert-danger alert-dismissible'>
							<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
							<strong>Error!</strong> Pending Order Not Found !.
						  </div>";
                $this->session->set_flashdata("message", $error);
            }
        }
        redirect("seller/orders", "refresh");
    }

    function generate_waybill($orders_id) {

        $user_id = $this->session->userdata("user_id");
        if (!empty($user_id)) {

            $res = $this->shipping->way_bill($orders_id);

            $awb_no = $res->GenerateWayBillResult->AWBNo;

            if (!empty($awb_no)) {
                $awb_pdf = $res->GenerateWayBillResult->AWBPrintContent;
                $file_name = 'uploads/wayBill_generate/waybill_' . $orders_id . '.pdf';
                // file_put_contents($file_name, $awb_pdf);

                $img_path=$this->awsupload->filePutContents($file_name,$awb_pdf, 'document');

                $dat['awb_number'] = $awb_no;
                $up = $this->Common_model->update('orders', $dat, array('orders_id' => $orders_id));
                
                $upship['awb_number'] =$awb_no;
                $this->Common_model->update('order_shipping', $upship, array('orders_id' => $orders_id));
            }
        }
    }

    function generate_waybill_old($orders_id) {

        $user_id = $this->session->userdata("user_id");
        if (!empty($user_id)) {

            $res = $this->shipping->way_bill($orders_id);

            $awb_no = $res->GenerateWayBillResult->AWBNo;


            if (!empty($awb_no)) {
                $awb_pdf = $res->GenerateWayBillResult->AWBPrintContent;
                $file_name = 'uploads/wayBill_generate/waybill_' . $orders_id . '.pdf';
                // file_put_contents($file_name, $awb_pdf);

                $img_path=$this->awsupload->filePutContents($file_name,$awb_pdf);

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
        redirect("seller/orders", "refresh");
    }

    function return_pickupregister($orders_id = 0) {
        //Get Order
        $orderDetails = $this->Order_model->getOrderDetailsById($orders_id);

        $order_product = $this->Order_model->getOrderProducts($orders_id);

        //get Area Code
        $areaCode_q = $this->Common_model->getAll('order_accepted_dimention', array('orders_id' => $orders_id))->row_array();
        $areaCode = $areaCode_q['pick_area_code'];
        $pick_id = $areaCode_q['pick_id'];


        $quantity = 0;
        $actual_order_price = 0;
        foreach ($order_product as $product):
            $quantity = $quantity + $product->products_quantity;
            $actual_order_price = $actual_order_price + $product->grand_price;
        endforeach;


        //Expected Time Calculation
        $curr_date = date('Y-m-d');
        $pick_date = date('Y-m-d', strtotime($curr_date . ' +' . $orderDetails->pick_days . ''));

        $exp_time = $this->shipping->calculate_expected_time($orders_id, $pick_id, $pick_date);

        $additional_days = $exp_time['GetDomesticTransitTimeForPinCodeandProductResult']['AdditionalDays'] . ' ' . 'days';

        $exp_date = $exp_time['GetDomesticTransitTimeForPinCodeandProductResult']['ExpectedDateDelivery'];

        $shipping_expected_date = date('Y-m-d', strtotime($exp_date . ' +' . $additional_days . ''));

        //Days Difference between pick up and delivery date
        $date1 = strtotime($pick_date);
        $date2 = strtotime($shipping_expected_date);
        $datediff = $date2 - $date1;

        $ship_date['ex_shipping_days'] = abs(round($datediff / (60 * 60 * 24)));
        $ship_date['shipping_start_date'] = $pick_date;
        $ship_date['delivery_date'] = $shipping_expected_date;


        $this->Common_model->update('orders', $ship_date, array('orders_id' => $orders_id));


        $paddress = $this->Common_model->getAll('seller_pick_address', array('pick_id' => $pick_id))->row_array();

        $total_weight = $quantity * $areaCode_q['weight_per_unit'];

        //Order Pick Up Registration

        $pickData['AreaCode'] = $areaCode;
        $pickData['ContactPersonName'] = $orderDetails->pick_name;
        $pickData['CustomerAddress1'] = $orderDetails->pick_addr_type;
        $pickData['CustomerAddress2'] = $paddress['address'];
        $pickData['CustomerAddress3'] = $orderDetails->pick_state;
        $pickData['CustomerCode'] = CustomerCode;
        $pickData['CustomerName'] = $orderDetails->pick_name;
        $pickData['CustomerPincode'] = $orderDetails->pick_pincode;
        $pickData['CustomerTelephoneNumber'] = $orderDetails->pick_mobile;
        $pickData['DoxNDox'] = '1';
        $pickData['EmailID'] = $orderDetails->pick_email;
        $pickData['MobileTelNo'] = $orderDetails->pick_mobile;
        $pickData['NumberofPieces'] = $quantity;
        $pickData['OfficeCloseTime'] = $paddress['office_close'];
        $pickData['ProductCode'] = 'E';
        $pickData['ReferenceNo'] = '123456';
        $pickData['Remarks'] = 'ATZ CART';
        $pickData['RouteCode'] = '99';
        $pickData['ShipmentPickupDate'] = $orderDetails->shipping_start_date;
        $pickData['ShipmentPickupTime'] = '13:00';
        $pickData['VolumeWeight'] = $total_weight;
        $pickData['WeightofShipment'] = $total_weight;
        if ($areaCode == 'PNQ') {
            $pickData['isToPayShipper'] = 'N';
        } else {
            $pickData['isToPayShipper'] = 'Y';
        }

        //From Api Pick Up Registration and Way Billl Generation

        $token_no = $this->shipping->pickupRegistration($pickData);
        //$this->shipping->way_bill($orders_id);


        if (!empty($token_no)) {
            $dat['order_token_number'] = $token_no;
            $this->Common_model->update('orders', $dat, array('orders_id' => $orders_id));
        }
    }

    public function return_order() {
        $data["pageTitle"] = "Returned Orders";
        $data["orderStatus"] = $this->Order_model->getOrderStatusList();
        $data["orders_status"] = 13;
        $this->load->view("user/orders/list", $data);
    }

    function order_packed_notify($order_id = 0) {


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

        $msg = "Order #ORD" . $order_id . " Packed By Seller";
        $tag = 'atzcart.com';


        $cr_date = date('d M Y');
        $message_for_buyer = 'Your Order ORD#' . $order_id . ' Packed ! Track Your Order !';
        $message_for_sms = 'Your Order ORD#' . $order_id . ' Successfully Packed ! Keep track of your product using below given link atzcart.com. Write us on our helpline if you have any queries related to product or supplier or delivery.';


        //To Buyer
        if (!empty($buyer_firbase)) {
            $type = "Order";
            $type_id = $order_id;
            $this->browser_notification->notify_buyer('Order Packed !', $message_for_buyer, $buyer_firbase, $type, $type_id);
        }


        if (!empty($user_phone)) {
            $this->send_data->send_sms($message_for_sms, $user_phone);
        }

        $this->browser_notification->notifyadmin('Order Packed  !', $msg, $tag);
    }

}
