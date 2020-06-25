<?php
class Sitemap extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model("Categories_model");
        $this->load->helper("xml");
    }
    public function index()
    {
        header("Content-Type: text/xml;charset=iso-8859-1");
        $this->load->view("front/sitemap/home");
    }
    
    public function category()
    {
        header("Content-Type: text/xml;charset=iso-8859-1");
        $data["categories"] = $this->Categories_model->getAll();
        $this->load->view("front/sitemap/category",$data);
    }
    
    public function product()
    {
        header("Content-Type: text/xml;charset=iso-8859-1");
        $this->db->where(["publish_status"=>"approved"]);
        $query = $this->db->get("product_details");
        $data["products"] = $query->result();
        $this->load->view("front/sitemap/product",$data);
    }
    
    public function allstatic()
    {
        header("Content-Type: text/xml;charset=iso-8859-1");
        $this->load->view("front/sitemap/staticpages");
    }
    
    public function robots()
    {
        header("Content-Type: text/plain;");
        echo "User-agent: * \nDisallow: /";
    }
}