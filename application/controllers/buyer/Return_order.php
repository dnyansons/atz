<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Return_order extends CI_Controller {

    public function __construct() {
        parent::__construct();
        if (!$this->session->userdata("user_logged_in")) {
            $error = "<div id='login-error' class='form-error notice notice-error'><span class='icon-notice icon-error'></span><span><strong>Error!</strong> Session timeout, relogin!. </span></div>";
            $this->session->set_flashdata("message", $error);
            redirect("login", "refresh");
        }
        $this->load->model("Users_model");
        $this->load->model("Common_model");
        $this->load->model("Order_model");
        $this->load->model("Shipping_model");
        $this->load->library('Shipping');
        $this->load->library('Shiprocket');
        $this->load->library('Send_data');
        $this->load->model('Product_model');
        $this->load->model("Categories_model");
        $this->load->model("Banners_model");
        $this->load->model("Rfqs_model");
        $this->load->model("Subscribers_model");
        $this->load->library("get_header_data");
        $this->load->model('Product_model');
        $this->load->model('Order_model');
        $this->load->model('myfavourite_model');
        $this->load->model('Inquiries_model');
        $this->load->library('user_agent');
        $this->load->library('Send_data');
        $this->load->library('Browser_notification');
        $this->load->model('Myorders_model');
    }

    public function index($order_id) {

        $data["pageTitle"] = "Return Order";
        $data = $this->get_header_data->get_categories();
        //$user_id = $this->session->userdata("user_id");
        //$data['allorder'] = $this->Myorders_model->allorders($user_id, $limit = 100, $start = 0, $order = 0, $dir = 0); 
        $data['single_order'] = $this->Myorders_model->single_order($order_id);
        $data['current_time'] = strtotime(date('Y-m-d'));
        $data['Isreturnable'] = $this->Myorders_model->checkIsreturnable($order_id);

        $this->load->view('front/common/header', $data);
        $this->load->view("front/myaccount/return_order", $data);
        $this->load->view('front/common/footer', $data);
    }

    function return_proceed() {

        $data1 = $this->get_header_data->get_categories();
        $username = $this->session->userdata('user_name');
        $user_id = $this->session->userdata('user_id');
        $phone = $this->session->userdata('phone');

        $order_id = $this->input->post('order_id');
        $return_type = $this->input->post('return_type');


        if (!empty($order_id) && !empty($return_type)) {

            if ($username) {
                //get Shipping Method from existing
                $checkshipMethod = $this->Common_model->getAll("order_shipping", array('orders_id' => $order_id))->row();

                $ship_method = $checkshipMethod->ship_vendor_id;

                //$ship_method = $this->send_data->get_shipping_method();
                //Shipping Address Details
                $chech_shipp = $this->Common_model->getAll('shipping_vendor', array('id' => $ship_method))->row();
                $order_shipping_data = $this->Common_model->getAll('order_shipping', array('orders_id' => $order_id))->row();
                $pr_details = $this->Order_model->getOrderDetails($order_id);

                $data['order_id'] = $order_id;

                if ($pr_details[0]->orders_status == 4 && $this->input->post('return_type') == 'full') {

                    $data['return_type'] = $this->input->post('return_type');
                    $data['return_reason'] = $this->Common_model->getAll('refund_reason', array('reason_type' => 'Return'))->result();
                    $data['seller_info'] = $this->Product_model->getSellerInformation($pr_details[0]->seller_id);
                    $data['details'] = json_decode($pr_details[0]->product_specifications);

                    if (!empty($pr_details) && !empty($this->input->post('return_reason'))) {
                        $user = $this->Common_model->getAll('users', array('id' => $user_id))->row();

                        $dat['orders_id'] = $order_id;
                        $dat['return_reason'] = $this->input->post('return_reason');
                        $dat['user_id'] = $user_id;
                        $dat['return_type'] = 'full';
                        $dat['order_from'] = $pr_details[0]->order_from;

                        $dat['pick_name'] = $pr_details[0]->user_name;
                        $dat['pick_addr_type'] = 'From User';
                        $dat['pick_country'] = $pr_details[0]->delivery_country;
                        $dat['pick_state'] = $pr_details[0]->delivery_city . ' , ' . $pr_details[0]->delivery_state;
                        $dat['pick_mobile'] = $user->phone;
                        $dat['pick_email'] = $user->email;
                        $dat['pick_pincode'] = $pr_details[0]->delivery_postcode;
                        $dat['pick_days'] = 0;
                        $dat['delivery_name'] = $pr_details[0]->pick_name;
                        $dat['delivery_street_address'] = $pr_details[0]->pick_addr_type;
                        $dat['delivery_city'] = $pr_details[0]->pick_address;
                        $dat['delivery_postcode'] = $pr_details[0]->pick_pincode;
                        $dat['delivery_state'] = $pr_details[0]->pick_state;
                        $dat['delivery_country'] = $pr_details[0]->pick_country;
                        $dat['delivery_email_address'] = $pr_details[0]->pick_email; //for delivery

                        $dat['delivery_address_format_id'] = 0;
                        $dat['payment_method'] = $pr_details[0]->payment_method;
                        $dat['last_modified'] = $pr_details[0]->last_modified;
                        $dat['date_purchased'] = $pr_details[0]->date_purchased;

                        $dat['shipping_cost'] = 0;
                        $dat['shipping_subtotal'] = 0;
                        $dat['shipping_gst'] = 0;

                        $dat['order_price'] = $pr_details[0]->order_price;

                        $dat['shipping_method'] = $pr_details[0]->shipping_method;
                        $dat['ex_shipping_days'] = $pr_details[0]->ex_shipping_days;
                        $dat['shipping_expected_date'] = '';
                        $dat['remark'] = $pr_details[0]->remark;
                        $dat['orders_status'] = 23;
                        $dat['order_tracking_status'] = 3;
                        $dat['order_token_number'] = 0;
                        $dat['comments'] = $pr_details[0]->comments;
                        $dat['currency'] = $pr_details[0]->currency;
                        $dat['seller_id'] = $pr_details[0]->seller_id;
                        $dat['user_telephone'] = $pr_details[0]->user_telephone;


                        $seller_id = $pr_details[0]->seller_id;
                        $insert_id = $this->Common_model->insert('return_orders', $dat);
                        if ($pr_details[0]->shippment_type == 'Free') {
                            $grand_price = $pr_details[0]->order_price;
                        } else {
                            $grand_price = $pr_details[0]->order_price - $pr_details[0]->shipping_cost;
                        }
                        if ($insert_id) {
                            $ship_cost_subtotal = 0;
                            $tot_quantity = 0;
                            $actual_order_price = 0;
                            $tot_weight = 0;

                            $max_length = 0.5;
                            $max_height = 0.5;
                            $max_width = 0.5;
                            $max_tot_weight = 0;
                            foreach ($pr_details as $pro) {
                                $prod_dat = $this->send_data->get_product_detail($pro->products_id);
                                //Shippig rate Calculate Start 
                                //calculate length ,width,height
                                if ($prod_dat->length > $max_length) {
                                    $max_length = $prod_dat->length;
                                }

                                if ($prod_dat->width > $max_width) {
                                    $max_width = $prod_dat->width;
                                }

                                if ($prod_dat->height > $max_height) {
                                    $max_height = $prod_dat->height;
                                }

                                $wt = $prod_dat->weight * $pro->products_quantity;
                                $max_tot_weight = $max_tot_weight + $wt;

                                $ch_seller = $this->Common_model->getAll('product_details', array('id' => $pro->products_id))->row();
                                $ch_addr_seller = $this->Common_model->getAll('seller_pick_address', array('user_id' => $seller_id))->row();

                                //$tot_weight=$tot_weight+$ch_seller->weight;
                                $tot_weight = $ch_seller->weight * $pro->products_quantity;


                                $tot_quantity = $tot_quantity + $pro->products_quantity;
                                $actual_order_price = $pro->products_price;

                                //shipping rate
                                $rate = $this->Shipping_model->get_return_shipping_rate($tot_weight, $pr_details[0]->pick_pincode, $pr_details[0]->delivery_postcode);

                                if ($ship_method == 1 && $rate > 0) {
                                    $ship_cost = $this->shipping->get_return_shipping_cost_for_multiple($pro->products_id, $rate, $pro->products_quantity, $tot_weight, $actual_order_price, $pr_details[0]->delivery_postcode);
                                    $ship_cost_subtotal = $ship_cost_subtotal + $ship_cost;
                                    $courier_id = 0;
                                    $dat_pro['return_orders_id'] = $insert_id;
                                    $dat_pro['products_id'] = $pro->products_id;
                                    $dat_pro['products_name'] = $pro->products_name;
                                    $dat_pro['products_price'] = $pro->products_price;
                                    $dat_pro['final_price'] = $pro->final_price;
                                    $dat_pro['vendors_price'] = $pro->vendors_price;
                                    $dat_pro['products_tax'] = 0.00;
                                    $dat_pro['products_quantity'] = $pro->products_quantity;
                                    $dat_pro['product_specifications'] = $pro->product_specifications;

                                    $this->Common_model->insert('return_orders_products', $dat_pro);
                                } elseif ($ship_method == 2) {

                                    $dat_pro['return_orders_id'] = $insert_id;
                                    $dat_pro['products_id'] = $pro->products_id;
                                    $dat_pro['products_name'] = $pro->products_name;
                                    $dat_pro['products_price'] = $pro->products_price;
                                    $dat_pro['final_price'] = $pro->final_price;
                                    $dat_pro['vendors_price'] = $pro->vendors_price;
                                    $dat_pro['products_tax'] = 0.00;
                                    $dat_pro['products_quantity'] = $pro->products_quantity;
                                    $dat_pro['product_specifications'] = $pro->product_specifications;

                                    $this->Common_model->insert('return_orders_products', $dat_pro);
                                } else {
                                    $msg = "<div class='alert alert-danger alert-dismissible'>
                                                            <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                                                            <strong>Error!</strong> Somthing Wrong!
                                                      </div>";
                                    $this->session->set_flashdata("message", $msg);
                                    $this->Common_model->delete('return_orders', array('orders_id' => $insert_id));
                                    redirect('buyer/myorders');
                                }
                            }
                            // add gst to shipping cost
                            if ($ship_method == 2) {

                                //New
                                $pickup_pincode = $pr_details[0]->delivery_postcode;
                                $delivery_pincode = $pr_details[0]->pick_pincode;
                                //$ship_rocket_cost = $this->shiprocket->serviceability_for_multiple($pickup_pincode, $delivery_pincode, $max_length, $max_width, $max_height, $max_tot_weight);
                                $ship_rocket_cost = $this->shiprocket->return_serviceability_for_multiple($order_shipping_data->ship_order_id);

                                if ($ship_rocket_cost['status'] == 200) {
                                    $courier_id = $ship_rocket_cost['courier_id'];
                                    $shipping_rate = $ship_rocket_cost['rate'];
                                    $shipping_subtotal = ($ship_rocket_cost['rate'] - ($ship_rocket_cost['rate'] * (18 / 100)));
                                    $shipping_gst = ($ship_rocket_cost['rate'] * (18 / 100));
                                    $exp_shipping_date = $ship_rocket_cost['est_date'];
                                    $ship_cost_subtotal = $shipping_rate;
                                } else {
                                    $this->Common_model->delete('return_orders', array('return_orders_id' => $insert_id));
                                    $this->Common_model->delete('return_orders_products', array('return_orders_id' => $insert_id));

                                    $msg = "<div class='alert alert-danger alert-dismissible'>
                                                            <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                                                            <strong>Error!</strong>Error Occured in Pickup ! Retry 
                                                      </div>";
                                    $this->session->set_flashdata("message", $msg);
                                    redirect('buyer/myorders');
                                }
                                //New End
                                $gst = ($ship_cost_subtotal * (18 / 100));
                                $final_shipping_cost = $ship_cost_subtotal;
                                $ship_cost_subtotal = $final_shipping_cost - $gst;
                            } else {
                                $gst = $ship_cost_subtotal * (18 / 100);
                                $final_shipping_cost = $ship_cost_subtotal + $gst;
                            }
                            $dat['shipping_subtotal'] = round($ship_cost_subtotal, 2);
                            $dat['shipping_gst'] = round($gst, 2);
                            $dat['shipping_cost'] = round($final_shipping_cost, 2);
                            $dat['order_price'] = round($grand_price + $final_shipping_cost, 2);
                            //update Order
                            $this->Common_model->update('return_orders', $dat, array('orders_id' => $order_id));

                            //Insert into Return Shipping Order
                            $ship_dat['ship_vendor_id'] = $ship_method;
                            $ship_dat['orders_id'] = $order_id;
                            $ship_dat['return_orders_id'] = $insert_id;
                            $ship_dat['courier_id'] = $courier_id;
                            $ship_dat['shipping_subtotal'] = $ship_cost_subtotal;
                            $ship_dat['shipping_gst'] = $gst;
                            $ship_dat['shipping_cost'] = $final_shipping_cost;
                            $ship_dat['on_amount'] = $chech_shipp->free_amount;
                            $ship_dat['pickup_pincode'] = $pr_details[0]->delivery_postcode;
                            $ship_dat['delivery_pincode'] = $pr_details[0]->pick_pincode;
                            $ship_dat['shippment_type'] = $chech_shipp->shipping_type;
                            $ship_dat['length'] = $max_length;
                            $ship_dat['breadth'] = $max_width;
                            $ship_dat['height'] = $max_height;
                            $ship_dat['weight'] = $max_tot_weight;
                            $insert_ship_id = $this->Common_model->insert('return_order_shipping', $ship_dat);

                            //Generate Order if Use Ship Rocket
                            if ($ship_method == 2) {
                                $resp = $this->shiprocket->return_create_order_new($insert_id, $order_id);

                                if (!empty($resp['shipment_id'])) {
                                    $up_ord['ship_order_id'] = $resp['order_id'];
                                    $up_ord['shipment_id'] = $resp['shipment_id'];
                                    $this->Common_model->update('return_order_shipping', $up_ord, array('ship_id' => $insert_ship_id));
                                } else {
                                    $this->Common_model->delete('return_orders', array('return_orders_id' => $insert_id));
                                    $this->Common_model->delete('return_orders_products', array('return_orders_id' => $insert_id));
                                    $this->Common_model->delete('return_order_shipping', array('ship_id' => $insert_ship_id));

                                    $msg = "<div class='alert alert-danger alert-dismissible'>
                                                            <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                                                            <strong>Error!</strong> Return not Pickable!
                                                      </div>";
                                    $this->session->set_flashdata("message", $msg);
                                    redirect('buyer/myorders');
                                }
                            }
                        }
                        //Update Order Status
                        $up['orders_status'] = 23;
                        $up['order_tracking_status'] = 3;

                        $this->Common_model->update('orders', $up, array('orders_id' => $order_id, 'orders_status' => 4));

                        //Order Request and Return Order Request
                        $insertHistory['orders_id'] = $order_id;
                        $insertHistory['status'] = 23;
                        $insertHistory['date_added'] = date('Y-m-d H:i:s');
                        $insertHistory['comment'] = 'Return Request Pending';
                        $insertHistory['customer_notified'] = 1;
                        $this->Common_model->insert('orders_history', $insertHistory);

                        $RinsertHistory['orders_id'] = $insert_id;
                        $RinsertHistory['status'] = 23;
                        $RinsertHistory['date_added'] = date('Y-m-d H:i:s');
                        $RinsertHistory['comment'] = 'Return Request Pending';
                        $RinsertHistory['customer_notified'] = 1;

                        $this->Common_model->insert('return_orders_history', $RinsertHistory);

                        //Send SMS to Customer
                        $msg = 'Return Request Sent Successfully of Order #ORD' . $order_id . '';
                        $mob = $this->session->userdata("phone");
                        $this->send_data->send_sms($msg, $mob);

                        $msg = "<div class='alert alert-success alert-dismissible'>
                                                            <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                                                            <strong>Success!</strong> Return Request Sent Successfully !
                                                      </div>";
                        $this->session->set_flashdata("message", $msg);

                        //insert in adminnotify table
                        $msg = 'Return Order Request from ' . $this->session->userdata('user_name') . ' of Order #ORD' . $order_id;
                        $msg_buyer = "Return Order Request of order #ORD" . $order_id;
                        $adminNotify = array(
                            'title' => 'Order Return Request',
                            'msg' => $msg . ' ( Web ) ',
                            'type' => 'order_return',
                            'reference_id' => $order_id,
                            'status' => 'Received'
                        );
                        $buyerNotify = array(
                            'title' => 'Order Return Request',
                            'msg' => $msg_buyer,
                            'user_id' => $user_id,
                            'type' => 'order_return',
                            'reference_id' => $order_id,
                            'status' => 'Received'
                        );

                        $this->Product_model->insertAdminNotify($adminNotify);
                        $this->Product_model->insertBuyerNotify($buyerNotify);
                        //Notify To Admin
                        $title = 'New Order Return  Request!';
                        $message = 'For Order ORD#' . $order_id;
                        $tag = 'atzcart.com';
                        $this->browser_notification->notifyadmin($title, $message, $tag);


                        redirect('buyer/myorders');
                    } else {
                        $this->load->view('front/common/header', $data1);
                        $this->load->view('front/order/return_proceed_order_full', $data);
                        $this->load->view('front/common/footer');
                    }
                } else {
                    $msg = "<div class='alert alert-danger alert-dismissible'>
			<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
			<strong>Error!</strong> Only Delivered Order Return !
			</div>";
                    $this->session->set_flashdata("message", $msg);
                    redirect('buyer/myorders');
                }
            }
        } else {
            redirect('buyer/myorders');
        }
    }

    function view_waybill($order_id = 0) {
        //echo $order_id;die;
        if ($order_id != 0) {
            $orderDetails = $this->Order_model->getOrderDetailsByReturnOrderId($order_id);
            // echo "<pre>";
            // print_r($orderDetails);die;
            $user_id = $this->session->userdata("user_id");
            if ($user_id == $orderDetails[0]['seller']) {
                $data['order_id'] = $order_id;
                $this->load->view("front/myaccount/return_way_bill", $data);
            } else {
                $error = "<div class='alert alert-danger alert-dismissible'>
								<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
								<strong>Error!</strong> Wrong Order Details !
							  </div>";
                $this->session->set_flashdata("message", $error);
                redirect('buyer/myorders');
            }
        }
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
                $file_name = 'return_wayBill_generate/waybill_' . $orders_id . '.pdf';
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
        redirect("seller/orders", "refresh");
    }

}
