<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Order extends CI_Controller 
{
    public function __construct() 
    {
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
		$this->load->model('Common_model'); 
		$this->load->model('Myorders_model');
    }

    public function index() 
    {
        $data["pageTitle"] = "Admin || Orders";
        $data["orderStatus"] = $this->Order_model->getOrderStatusList();
        $this->load->view("admin/orders/list", $data);
    }

    public function view($order_id = 0) 
    {
        $orderDetails = $this->Order_model->getOrderDetailsById($order_id);
        if ($orderDetails) {
            $this->load->library("form_validation");
            $this->form_validation->set_rules("status", "Order Status", "required");
            $this->form_validation->set_rules("comment", "Comment", "required");
            if ($this->form_validation->run() === false) {
                $data["orderDetails"] = $orderDetails;
                $data["orderHistory"] = $this->Order_model->getOrderHistory($order_id);
                $data["orderStatus"] = $this->Order_model->getOrderStatusList();
                $data["pageTitle"] = "Admin || Order Details";
                $this->load->view("admin/orders/details", $data);
            } else {
                $insertData = [
                    "orders_id" => $order_id,
                    "status" => $this->input->post("status"),
                    "comment" => $this->input->post("comment"),
                ];
                if ($this->input->post("notify")) {
                    $insertData["customer_notified"] = 1;
                }
                $this->Order_model->addOrderHistory($insertData);
                redirect("admin/orders/view/" . $order_id, "refresh");
            }
        } else {
            $error = "<div class='alert alert-danger alert-dismissible'>
					<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
					<strong>Error!</strong> Invalid Order Id.
				  </div>";
            $this->session->set_flashdata("message", $error);
            redirect("admin/orders", "refresh");
        }
    }

    public function ajax_list() 
    {
        $order_id = $this->input->post('filter_order_id');
        $status_id = $this->input->post('filter_order_status_id');
        $total = $this->input->post('filter_total');
        $date_added = $this->input->post('filter_date_added');

        if ($date_added != '') {
            $search_date = date('Y-m-d', strtotime($date_added));
        }


        $orders = $this->Order_model->get_datatables($search_date, $status_id, $total, $order_id);

        $data = array();
        $no = $this->input->post('start');
        foreach ($orders as $order) {
            $no++;
            $row = array();
            $row[] = $order->orders_id;
            $row[] = $order->user_name;
            
            $row[] = $order->orders_status_name;
            $row[] = $order->final_price;
            $row[] = date("d-m-Y", strtotime($order->date_purchased));
            $row[] = '<a type="button" title="View & Action" class="btn btn-primary btn-sm"  href="' . site_url() . 'admin/orders/view/' . $order->orders_id . '">view&nbsp;<i class="fa fa-arrow-down"></i></a>';

            $data[] = $row;
        }

        $output = array(
            "draw" => $this->input->post('draw'),
            "recordsTotal" => $this->Order_model->count_all(),
            "recordsFiltered" => $this->Order_model->count_filtered($search_date, $status_id, $total, $order_id),
            "data" => $data,
        );
        echo json_encode($output);
    }
	
	function finalOrderInvoice($order_id)
	{
		$data['orderDetails']=$this->Order_model->getOrderDetailsByOrderId($order_id);
		$data['sorder']=$this->Myorders_model->single_order($order_id);
		$this->load->view("user/orders/final_order_invoice",$data);      
	}
	
	function packagingSlip($order_id)
	{
		$data['orderDetails']=$this->Order_model->getOrderDetailsByOrderId($order_id);
		$this->load->view("user/orders/packeging_slip",$data);      
	}
	
	function sellerOrderDetailsInvoice()
	{
		$user_id = $this->session->userdata('user_id');
		$result = $this->Order_model->getUserOrders_invoice($user_id);
		for($i= 0; $i<count($result); $i++)
		{
			$res = $this->Order_model->getOrderDetailsForInvoice($result[$i]['orders_id']);
			$result[$i]['product_details'] = $res;
		}
		$data['orderDetails'] = $result;

		$this->load->view("user/orders/seller_orderdetail_invoice",$data);      
	}
	
	function invoiceSummary()
	{
		$user_id = $this->session->userdata('user_id');
		$result = $this->Order_model->getUserOrders_invoice($user_id);
		$total_order = count($result);
		$product_charges = 0;
		$atz_fees = 0;
		$taxable_fees = 0;
		$refunds = 0;
		$total_amount = 0;
		for($i= 0; $i<count($result); $i++)
		{
			$res = $this->Order_model->getOrderDetailsForInvoice($result[$i]['orders_id']);
			$product_charges += $res['final_price'];
			$taxable_fees += $res['products_tax'];
			$atz_fees += $result[$i]['commission'];
			$total_amount += $result[$i]['order_price'];
		}
		$summery = [
			'total_order'=>$total_order,
			'product_charges'=> $product_charges,
			'taxable_fees'=> $taxable_fees,
			'atz_fees'=> $atz_fees,
			'total_amount'=> $total_amount,
			'refunds'=> $refunds,
			'pick_name' =>  $result[0]['pick_name'],
			'pick_addr_type' =>  $result[0]['pick_addr_type'],
			'pick_pincode' =>  $result[0]['pick_pincode'],
			'pick_mobile' =>  $result[0]['pick_mobile'],
			'pick_state' =>  $result[0]['pick_state'],
			'gst' =>  $result[0]['gst'],
			
		];
		$data['summery'] = $summery;
		
		$this->load->view("user/orders/invoice_summery",$data);      
	}
	
	
}
