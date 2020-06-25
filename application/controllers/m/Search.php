<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Search extends CI_Controller 
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model("Categories_model");
        $this->load->library("get_header_data");
        $this->load->model('Offer_model');
        $this->load->model('Product_model');
    }
    
    public function index()
    {
        /********** Get categories ************/
        $keyword = $this->input->get("term");
        $this->db->select("CD.categories_name name,CD.categories_id as id,C.parent_id as parent_id, CD1.categories_name as parent_name");
        $this->db->from("categories_description CD");
        $this->db->like("CD.categories_name",$keyword);
        $this->db->or_like("C.seo_keywords",$keyword);
        $this->db->join("categories C","CD.categories_id = C.category_id");
        $this->db->join("categories_description CD1","C.parent_id = CD1.categories_id");
        $this->db->order_by("C.product_count","DESC");
        $this->db->limit(4);
        $query = $this->db->get();
        $cats = $query->result();
        
        /************ Get Products ************/
        $this->db->select("P.name,P.id as id,P.category as parent_id,CD.categories_name parent_name");
        $this->db->from("product_details P");
        $this->db->join("categories_description CD","CD.categories_id = P.category");
        $this->db->like("P.name",$keyword);
        $this->db->or_like("P.keywords",$keyword);
        $this->db->limit(4);
        $query = $this->db->get();
        $products = $query->result();
        
        $result = [];
        foreach($cats as $cat){
            $result[] = [
                "type" => "category",
                "name" => $cat->name,
                "id" => $cat->id,
                "parent_id" => $cat->parent_id,
                "parent_name" => $cat->parent_name,
            ];
        }
        
        foreach ($products as $product){
            $result[] = [
                "type" => "product",
                "name" => $product->name,
                "id" => $product->id,
                "parent_id" => $product->parent_id,
                "parent_name" => $product->parent_name,
            ];
        }
        echo json_encode($result); 
    }
    
    public function results($type = "category",$id,$parent_id,$term)
    {
        if($type == "category"){
            $category_id = $id;
            $categories = array_filter(array_unique(explode(",",$category_id.",".$this->Categories_model->getAllChilds($category_id))));
            $productlists = $this->Product_model->getProductsdetailsByCategory($categories,0,6,"","","","");
            $data['productsCnt'] = $this->Product_model->getProductsdetailsByCategoryCount($categories);
            $seller_id = $productlists[0]['seller_id'];
            $country=$this->Product_model->getCountryFlag($seller_id);
            /* -------------company info year-------------------- */
            $registers = $this->Product_model->getRegisterYear($seller_id);
            $data['country'] = $country;
            $data['registers'] = $registers;
            $data['category_name'] = $category_name;
            $parent_cat = $this->Categories_model->getCategoryById($category_id);
            $data["description"] = $parent_cat->seo_description;
            $data["keywords"] = $parent_cat->seo_keywords;
            $data["title"] = $parent_cat->seo_title;
            $returnOfferProductList=$this->Offer_model->appliedOfferProduct1($productlists); 
            $data['productlists'] = $returnOfferProductList;
            $this->load->view("mobile/smart_search_view", $data);
            
        } else if ($type == "product"){
            $term = urldecode($term);
            $category_id = $parent_id;
            $productlists = $this->Product_model->getProductsByCategoryAndTerm($categories,0,6,"","","","",$term);
            $data['productsCnt'] = $this->Product_model->getProductsByCategoryAndTerm($categories,0,6,"","","","",$term);
            $seller_id = $productlists[0]['seller_id'];
            $country=$this->Product_model->getCountryFlag($seller_id);
            /* -------------company info year-------------------- */
            $registers = $this->Product_model->getRegisterYear($seller_id);
            $data['country'] = $country;
            $data['registers'] = $registers;
            $data['category_name'] = $category_name;
            $parent_cat = $this->Categories_model->getCategoryById($category_id);
            $data["description"] = $parent_cat->seo_description;
            $data["keywords"] = $parent_cat->seo_keywords;
            $data["title"] = $parent_cat->seo_title;
            $returnOfferProductList=$this->Offer_model->appliedOfferProduct1($productlists); 
            $data['productlists'] = $returnOfferProductList;
            $this->load->view("mobile/smart_search_view", $data);
        } else {
            
        }
    }
    
    public function sortsmartProducts() { 
       $sortby = $this->input->post("sortby");
       $type = $this->input->post("type");
       $id = $this->input->post("id");
       $parent_id=$this->input->post("parent_id");
       $term = $this->input->post("term");
       $price_range=$this->input->post('price_range');

      if($type == "category"){
            $category_id = $id;
            $categories = array_filter(array_unique(explode(",",$category_id.",".$this->Categories_model->getAllChilds($category_id))));
            $productlists = $this->Product_model->getProductsdetailsByCategory($categories,$start,$perpage,"","","",$sortby);
            $seller_id = $productlists[0]['seller_id'];
            $country=$this->Product_model->getCountryFlag($seller_id);
            /* -------------company info year-------------------- */
            $registers = $this->Product_model->getRegisterYear($seller_id);
            $data['country'] = $country;
            $data['registers'] = $registers;
            $data['category_name'] = $category_name;
            $parent_cat = $this->Categories_model->getCategoryById($category_id);
            $data["description"] = $parent_cat->seo_description;
            $data["keywords"] = $parent_cat->seo_keywords;
            $data["title"] = $parent_cat->seo_title;
            $returnOfferProductList=$this->Offer_model->appliedOfferProduct1($productlists); 
            if(!empty($price_range))
            {
                $priceRangeArr = explode(';',$price_range);
                $results = $this->Product_model->getProductsdetailsByCategory($categories,$start,$perpage,"",$priceRangeArr[0],$priceRangeArr[1],"");
                $returnOfferProductList = $this->Offer_model->appliedOfferProduct1($results);
            }
            $data['productlists'] = $returnOfferProductList;
           
            echo json_encode($data['productlists']); 
            
        } else if($type == "product"){
            $term = urldecode($term);
            $category_id = $parent_id;
            $productlists = $this->Product_model->getProductsByCategoryAndTerm($categories,$start,$perpage,"","","",$sortby,$term);
            $seller_id = $productlists[0]['seller_id'];
            $country=$this->Product_model->getCountryFlag($seller_id);
            /* -------------company info year-------------------- */
            $registers = $this->Product_model->getRegisterYear($seller_id);
            $data['country'] = $country;
            $data['registers'] = $registers;
            $data['category_name'] = $category_name;
            $parent_cat = $this->Categories_model->getCategoryById($category_id);
            $data["description"] = $parent_cat->seo_description;
            $data["keywords"] = $parent_cat->seo_keywords;
            $data["title"] = $parent_cat->seo_title;
            $returnOfferProductList=$this->Offer_model->appliedOfferProduct1($productlists); 
            if(!empty($price_range))
            {
                $priceRangeArr = explode(';',$price_range);
                $results = $this->Product_model->getProductsByCategoryAndTerm($categories,$start,$perpage,"",$priceRangeArr[0],$priceRangeArr[1],"",$term);
                $returnOfferProductList = $this->Offer_model->appliedOfferProduct1($results);
            }
            $data['productlists'] = $returnOfferProductList;
            echo json_encode($data['productlists']);
        } else {
            
        }
    }
    /*
     * @author Ravindra Warthi 20/09/2019
     * @use Smart Search Product and categories according To search box
     *  lazy Loading While Smart Search.
     */
    function loadMoreData()
    {
       $page= $this->input->post("page");
       $type= $this->input->post("type");
       $id= $this->input->post("id");
       $parent_id=$this->input->post("parent_id");
       $term=$this->input->post("term");
       
       $min_price = $this->input->post("min_price");
       $max_price = $this->input->post("max_price");
       
       $perpage = 6;
       $start = ceil($page * $perpage);
       if($type == "category"){
            $category_id = $id;
            $categories = array_filter(array_unique(explode(",",$category_id.",".$this->Categories_model->getAllChilds($category_id))));
            $productlists = $this->Product_model->getProductsdetailsByCategory($categories,$start,$perpage,"","","","");
            $seller_id = $productlists[0]['seller_id'];
            $country=$this->Product_model->getCountryFlag($seller_id);
            /* -------------company info year-------------------- */
            $registers = $this->Product_model->getRegisterYear($seller_id);
            $data['country'] = $country;
            $data['registers'] = $registers;
            $data['category_name'] = $category_name;
            $parent_cat = $this->Categories_model->getCategoryById($category_id);
            $data["description"] = $parent_cat->seo_description;
            $data["keywords"] = $parent_cat->seo_keywords;
            $data["title"] = $parent_cat->seo_title;
            $returnOfferProductList=$this->Offer_model->appliedOfferProduct1($productlists); 
            if(($min_price ==0 && $max_price !=0) || ($min_price !=0 && $max_price !=0))
            {
              $products = $productlists = $this->Product_model->getProductsdetailsByCategory($categories,$start,$perpage,"",$min_price,$max_price,"");
              $returnOfferProductList = $this->Offer_model->appliedOfferProduct1($products);
            }
            $data['productlists'] = $returnOfferProductList; 
            echo json_encode($data['productlists']);
            
        } else if($type == "product"){
            $term = urldecode($term);
            $category_id = $parent_id;
            $productlists = $this->Product_model->getProductsByCategoryAndTerm($categories,$start,$perpage,"",$min_price,$max_price,"",$term);
            $seller_id = $productlists[0]['seller_id'];
            $country=$this->Product_model->getCountryFlag($seller_id);
            /* -------------company info year-------------------- */
            $registers = $this->Product_model->getRegisterYear($seller_id);
            $data['country'] = $country;
            $data['registers'] = $registers;
            $data['category_name'] = $category_name;
            $parent_cat = $this->Categories_model->getCategoryById($category_id);
            $data["description"] = $parent_cat->seo_description;
            $data["keywords"] = $parent_cat->seo_keywords;
            $data["title"] = $parent_cat->seo_title;
            $returnOfferProductList=$this->Offer_model->appliedOfferProduct1($productlists); 
            if(($min_price ==0 && $max_price !=0) || ($min_price !=0 && $max_price !=0))
            {
                $products = $this->Product_model->getProductsByCategoryAndTerm($categories,$start,$perpage,"","","","",$term);
                $returnOfferProductList = $this->Offer_model->appliedOfferProduct1($products);
            }
            $data['productlists'] = $returnOfferProductList;
            echo json_encode($data['productlists']);
            
        } else {
            
        }
    }
}

