<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Requests extends CI_Controller 
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
        $this->load->model('Product_model');
        $this->load->model('Categories_model');
        $this->load->library('Userpermission');
    }

    public function index() 
    {
        $data["pageTitle"] = "Pending Approval Products";
        $data["get_url"] = "admin/products/ajax_requests_list";
        $data["last_column"] = "Requested On";
        $data["status"] = "requested";
        $data['categories'] = $this->Categories_model->getAll();
        $this->load->view("admin/products/list_new", $data);
    }

    public function approve() 
    {

        $output = [
            "status" => 0,
            "message" => "invalid inputs"
        ];
        $this->form_validation->set_rules("product_id","Product","required");
        $this->form_validation->set_rules("commission","Commission","required");
        $this->form_validation->set_rules("discount","discount","required");
        if($this->form_validation->run()===false){
            echo json_encode($output);
        } else {
            $product = $this->input->post("product_id");
            $commission = $this->input->post("commission");
            $discount = $this->input->post("discount");
            $output["status"] = 1;
            $output["message"] = "Sucess";
            $output["debug"] = $this->Product_model->setCommissionOnProduct($product,$commission,$discount);
            
            $updateData = [
                "hike_percentage" => $commission,
                "discount_percentage" => $discount,
                "publish_status" => "approved",
                "approved_by" => $this->session->userdata("admin_id"),
                "approved_on" => date("Y-m-d H:i:s"),
            ];
            $this->Product_model->updateProduct($product,$updateData);
            echo json_encode($output);
        }
        
    }

    public function reject() 
    {
		$id = $this->input->post('product_id');
        $this->Product_model->rejectProduct($id);
        $error = "<div class='alert alert-success alert-dismissible'>
				<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
				<strong>Success!</strong> Request rejected successfully.
			  </div>";
        $this->session->set_flashdata("message", $error);
		$output = ["status"=>1];
        echo json_encode($output);
    }
    
    public function check()
    {
        echo "<pre>";
        print_r($_SESSION);
    }

}
