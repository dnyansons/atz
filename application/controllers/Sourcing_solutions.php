<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Sourcing_solutions extends CI_Controller 
{

    public function __construct() 
    {
        parent::__construct();
		$this->load->library("get_header_data");
		$data = $this->get_header_data->get_categories();
		$this->data = $data;
        $this->load->model('Users_model');
        $this->load->model('Company_model');
    }

    public function index() 
    {
        $data = $this->data;
        $this->Users_model->get_topselectedSeller();
		$data["title"] = "ATZCart - Top Selected Suppliers";
        $data['result'] = $this->Users_model->get_topselectedSeller();
        $this->load->view('front/sourcing_solutions/top_selected_supplyer', $data);
    }

    public function suppliers_region() 
    {
        $data = $this->get_header_data->get_categories();
        $data["title"] = "ATZCart - Suppliers by region";
        $data["regions"] = $this->Company_model->getSellersCountRegionWise();
        $this->load->view('front/sourcing_solutions/suppliers_region',$data);
    }
    
    public function regionwise_suppliers($region)
    {
        $data = $this->get_header_data->get_categories();
        $data["title"] = "ATZCart - Suppliers by region";
        $data["sellers"] = $this->Company_model->regionWiseSupplierList($region);
        $data["region"] = $region;
        $this->load->view('front/sourcing_solutions/regionwise_supplier_list',$data);
    }


}