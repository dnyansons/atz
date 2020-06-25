<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Suppliers extends CI_Controller 
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
        $this->load->model('Suppliers_model');
        $this->load->model('Products_model');
		 $this->load->library('Userpermission');
    }
    
    public function index() 
    {
		$data["pageTitle"] = "Admin || Suppliers list";
        $this->load->view("admin/users/supplierslist",$data);
    }
	
	public function ajax_list()
	{
		$columns = array(
            0 => 'manufacturers_id',
            1 => 'contact_person1_name',
            2 => 'company_name',
            3 => 'email',
            4 => 'telephone',
            5 => 'country',
            6 => 'state',
            7 => 'city',
        );

        $limit = $this->input->post('length');
        $start = $this->input->post('start');
        $order = $columns[$this->input->post('order')[0]['column']];
        //$dir = $this->input->post('order')[0]['dir'];
        $dir ="desc";

        $totalData = $this->Suppliers_model->allsupplier_count();

        $totalFiltered = $totalData;

        if (empty($this->input->post('search')['value'])) {
            $suppliers = $this->Suppliers_model->allsupplier($limit, $start, $order, $dir);
        } else {
            $search = $this->input->post('search')['value'];

            $suppliers = $this->Suppliers_model->supplier_search($limit, $start, $search, $order, $dir);

            $totalFiltered = $this->Suppliers_model->supplier_search_count($search);
        }

        $data = array();
        if (!empty($suppliers)) {
            foreach ($suppliers as $supplier) {
                $nestedData['id'] = $supplier->manufacturers_id;
                $nestedData['name'] = $supplier->contact_person1_name;
                $nestedData['company'] = $supplier->company_name;
                $nestedData['email'] = $supplier->email;
                $nestedData['telephone'] = $supplier->telephone;
                $nestedData['country'] = $supplier->country;
                $nestedData['state'] = $supplier->state;
                $nestedData['city'] = $supplier->city;
                $nestedData['subscription_plan'] = "";
                $nestedData['product_categories'] = "";
                $nestedData['products_listed'] = "";
                $nestedData['action'] = "<a class='btn btn-link' href='".site_url()."admin/suppliers/view/".$supplier->manufacturers_id."'>view</a>";
                

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
	
	public function view($supplier_id = 0)
	{
		if($supplier_id == 0){
			$error = "<div class='alert alert-danger alert-dismissible'>
					<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
					<strong>Error!</strong> Please select supplier.
				  </div>";
			$this->session->set_flashdata("message",$error);
			redirect("admin/suppliers","refresh");
		} else {
			$data["supplier"] = $this->Suppliers_model->getUserById($supplier_id);
			$data["products"] = $this->Products_model->getProductsByManufacture($supplier_id);
			//echo "<pre>";
			//print_r($data);
			$this->load->view("admin/users/supplierdetails",$data);
		}
	}
}
