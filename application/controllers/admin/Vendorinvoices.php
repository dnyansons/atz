<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Vendorinvoices extends CI_Controller 
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
        $this->load->library('Userpermission');
    }
    
    public function index()
    {
        //$this->output->enable_profiler(true);
       
        $month_ini = new DateTime("first day of last month");
        $month_end = new DateTime("last day of last month");

        $first_day_this_month = $month_ini->format('Y-m-d'); // 2012-02-01
        $last_day_this_month  = $month_end->format('Y-m-d');
        
        $this->db->select("seller_id as seller,SUM(commission) as commission,SUM(gst) as gst, SUM(order_price) amount");
        //$this->db->where(["orders_status"=>4,"vndr_payment_status"=>"Settled"]);
        $this->db->where("delivery_date >= '".$first_day_this_month."'");
        $this->db->where("delivery_date <= '".$last_day_this_month."'");
        $this->db->group_by("seller_id");
        $query = $this->db->get("orders");
        $data["items"] = $query->result();
        $this->load->view("admin/report/invoice_report",$data);
    }
    
    public function view($seller)
    {
        //$this->output->enable_profiler(true);
        $month_ini = new DateTime("first day of last month");
        $month_end = new DateTime("last day of last month");
        $first_day_this_month = $month_ini->format('Y-m-d'); // 2012-02-01
        $last_day_this_month  = $month_end->format('Y-m-d');
        
        $this->db->select("seller_id as seller,SUM(commission) as commission,SUM(gst) as gst, ROUND(SUM(order_price),2) amount,"
                . "users.first_name,users.last_name,users.email,users.phone,users.address");
        //$this->db->where(["orders_status"=>4,"vndr_payment_status"=>"Settled","seller_id"=>$seller]);
        $this->db->where(["seller_id"=>$seller]);
        $this->db->where("delivery_date >= '".$first_day_this_month."'");
        $this->db->where("delivery_date <= '".$last_day_this_month."'");
        $this->db->join("users","orders.seller_id = users.id");
        $query = $this->db->get("orders");
        $data["item"] = $query->row();
        $data["return"] = 0;
        $this->load->view("admin/report/invoice_details",$data);
    }
    
    

}