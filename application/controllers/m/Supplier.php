<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Supplier extends CI_Controller 
{
    public function __construct() 
    {
        parent::__construct();
        $this->load->model('Product_model');
        $this->load->model('Users_model');
        $this->load->model('Company_model');
    }

    public function index($seller_id) 
    {
        $session_seller = array("seller_id" => $seller_id,);
        $this->session->set_userdata($session_seller);
        $data['sellerinfos'] = $this->Users_model->getSellerAndCompanyInfo($seller_id);
        $data['newproducts'] = $this->Product_model->getProductsBySellerId($seller_id, 0, 4);
        $data['hotsellings'] = $this->Product_model->topSellingProductsBySeller($seller_id);
        $sellinfo['sellercomp']=$this->Users_model->getSellerInfo($seller_id);
        $data['seller'] = $session_seller;
        $this->load->view("mobile/supplier_common/header",$sellinfo);
        $this->load->view("mobile/supplier_view", $data);
        $this->load->view("mobile/supplier_common/footer");
    }

    public function product_categories() 
    {
        $this->load->view("mobile/pcategories_view");
    }

    public function supplier_products($seller_id) 
    {
        $data['products'] = $this->Product_model->getProductsBySellerId($seller_id);
        $data['sellerinfos'] = $this->Users_model->getSellerAndCompanyInfo($seller_id);
        $sellinfo['sellercomp']=$this->Users_model->getSellerInfo($seller_id);
        $this->load->view("mobile/supplier_common/header",$sellinfo); 
        $this->load->view("mobile/supplierproducts_view",$data);
        $this->load->view("mobile/supplier_common/footer");
    }

    public function supplier_profile($seller_id) 
    {
        $data['productinfos'] = $this->Product_model->getProductDetails($product_id);
        $data["companyinfo"] = $this->Company_model->getCompanyDetailsBySeller($seller_id);
        $sellinfo['sellercomp']=$this->Users_model->getSellerInfo($seller_id);

        $data['records'] = $this->Common_model->select('cd.*,cdf.file','company_documents cd',['cd.user_id'=>33],'','','',
        array(1=>array('tableName'=>'company_document_files cdf','columnNames'=>'cd.id = cdf.company_document_title_id','jType'=>'right')));


        $this->load->view("mobile/supplier_common/header",$sellinfo);
        $this->load->view("mobile/supplierprofile_view", $data);
        $this->load->view("mobile/supplier_common/footer");
    }

    public function supplier_videos($seller_id) 
    {
        $this->load->view("mobile/suppliervideos_view");
    }

    public function supplier_enquiry($seller_id) 
    {
        $data['sellerinfos'] = $this->Users_model->getSellerAndCompanyInfo($seller_id);

        $this->load->view("mobile/supplierenquiry_view", $data);
    }

}
