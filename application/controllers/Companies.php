<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Companies extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model("Company_model");
        $this->load->model("Product_model");
        $this->load->model("Offer_model");
    }

    public function index($company_name)
    {
        $name = urldecode($company_name);
        $company = $this->Company_model->getCompanyDetailsByName($name);
        if($company){
            $data["company"] = $company;
            $data["products"] = $this->Product_model->getProductsBySellerData($data["company"]->user_id);
//            echo "<pre>";
//            print_r($data["products"]);
            
            $this->load->view("front/company/home_new",$data);
        } else {
            echo "No data found";
        }
    }
}
