<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Shipping_report extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if(! $this->session->userdata("admin_logged_in")){
            $error = "<div class='alert alert-danger alert-dismissible'>
                        <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                        <strong>Error!</strong> Session timeout, relogin!.
                      </div>";
            $this->session->set_flashdata("message",$error);
            redirect("admin/login","refresh");
        }
        $this->load->model("Order_model");
        $this->load->library('Userpermission');
    }

    public function index()
    {
        $data["pageTitle"] = "Shipping Report";

        $this->db->select("orders.orders_id,shipping_cost,shipping_subtotal,"
                . "shipping_gst,order_price,shipping_payment_status,shipping_expected_date,ShipmentPickupDate,delivery_date,ShipmentPickupDate,"
                . "SUM(weight_per_unit) as product_weight");
        $this->db->from("orders");
        $this->db->group_by("orders.orders_id");
        $this->db->join("order_accepted_dimention","order_accepted_dimention.orders_id = orders.orders_id");
        $this->db->where("orders_status=4 and shipping_payment_status= 'Settled'");
        $data['allhistory'] = $this->db->get()->result_array();
        $this->load->view("admin/report/shippingreport", $data);
    }
}