<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Deals extends CI_Controller
{
    public function __construct() 
    {
        parent::__construct();
        $this->load->model("Product_model");
        $this->load->library("get_header_data");
    }
    
    public function index()
    {
        $data["title"] = "ATZCart - Weekly Title";
        $this->load->view("front/deals/list");
    }
    
    public function discounted_products($type = "other_deals")
    {
        $data = $this->get_header_data->get_categories();
        
        $categories = $this->Categories_model->getTopSellingCategories(8);
        $data["top_categories"] = $categories;
        $data["title"] = "ATZCart - Discounted Products";
        if($type == "30-percent-off"){
            $data["products"] = $this->Product_model->getDiscoutedProduct(30,"percentage");
            $this->load->view("front/deals/list",$data);
        } else if($type == "20-percent-off"){
            $data["products"] = $this->Product_model->getProductsUptoDiscount(20,"percentage");
            $this->load->view("front/deals/list",$data);
        } else {
            show_404();
        }
    }
}
