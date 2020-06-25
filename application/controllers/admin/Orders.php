<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Orders extends CI_Controller {

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
		 $this->load->library('Userpermission');
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
    
    public function cancellationReasons()
    {
        $data["pageTitle"] = "Reasons for order cancellation";
        $data["items"] = $this->Order_model->getCancellationReasons();
        $this->load->view("admin/orders/cancellation_reasons",$data);
    }
    
    public function addCancelReason()
    {
        $this->form_validation->set_rules("reason","Reason","Required");
        if($this->form_validation->run()===false){
            $data["pageTitle"] = "Add order cancellation reason";
            $this->load->view("admin/orders/add_cancel_reason",$data);
        } else {
            $insertData = [
                "reason" => $this->input->post("reason"),
                "status" => 1,
            ];
            $this->Order_model->addCancelReason($insertData);
            $error = "<div class='alert alert-success alert-dismissible'>
				<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
				<strong>Success!</strong> Reason added successfully!.
			</div>";
            $this->session->set_flashdata("message", $error);
            redirect("admin/orders/cancellationReasons", "refresh");
        }
        
    }
    
    public function deleteReason($id = 0)
    {
        $this->Order_model->deleteReason($id);
        $error = "<div class='alert alert-success alert-dismissible'>
                            <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                            <strong>Success!</strong> Reason added removed!.
                    </div>";
        $this->session->set_flashdata("message", $error);
        redirect("admin/orders/cancellationReasons", "refresh");
    }

}
