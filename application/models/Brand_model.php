<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Brand_model extends CI_Model
{
    private $_table;
    private $_tableDescription;
    public function __construct() 
    {
        parent::__construct();
        $this->load->database();
		$this->load->model('Common_model'); 
        $this->_table = "brands";
        //$this->_tableDescription = "categories_description";
    }
    
	public function get_allbrands()
	{
		$this->db->select('brand_id, brand_name');
		$query=$this->db->get('brands');
		return $query->result();
	}
	
    public function getAll() 
    {
        $query = $this->db->get($this->_table);
        return $query->result();
    }
	
	public function get_brands(){

        $brands = $this->Common_model->getAll("brands",array("email"=>$email))->result_array();
        return $brands;
    }

   
    
    function allbrand_count()
    {   
        $query = $this
                ->db
                ->get($this->_table);
    
        return $query->num_rows();  

    }
    
    function allbrand($limit,$start,$col,$dir)
    {   
       $query = $this->Common_model->getAll("brands")->num_rows();
       $brands = $this->Common_model->getAll("brands")->result();
        
        if($query>0)
        {
            return $brands; 
        }
        else
        {
            return null;
        }
        
    }
   
    function brand_search($limit,$start,$search,$col,$dir)
    {
        $query = $this
                ->db
                ->select("*")
                ->like('brand_id',$search)
                ->or_like('brand_name',$search)
                
                ->limit($limit,$start)
                ->order_by($col,$dir)
                ->get($this->_table);
        
       
        if($query->num_rows()>0)
        {
            return $query->result();  
        }
        else
        {
            return null;
        }
    }

    function brand_search_count($search)
    {
        $query = $this
                ->db
                ->like('brand_id',$search)
                ->or_like('brand_name',$search)
                ->or_like('brand_description',$search)
                ->get($this->_table);
    
        return $query->num_rows();
    }
	
	public function getDistinctCategories()
    {
        $this->db->distinct();
        $this->db->select('a.category_id, b.categories_name', false);
        $this->db->from('categories as a');
        $this->db->join('categories_description as b', 'a.category_id=b.categories_id');
        $query = $this->db->get();
        $result=$query->result();
        return $result; 
    }
    
    
    public function updateCategoryData($data)
    {

        //echo "<pre>";
        //print_r($data);exit;
        
        $this->db->set('parent_id', $data['parent_id']);
        $this->db->set('sort_order', $data['sort_order']);

        if(isset($data['categories_image']) && $data['categories_image']!="")
        {
           $this->db->set('categories_image', $data['categories_image']);
        }
        
        $this->db->set('last_modified', date('Y-m-d H:i:s'));
        $this->db->where('category_id', $data['categories_id']);
        $this->db->update('categories');

        $this->db->set('categories_name', $data['categories_name']);
        $this->db->where('categories_id', $data['categories_id']);
        $this->db->update('categories_description');

        return TRUE;

    }

    public function deleteBrandData($brand_id)
    {
        $this->db->where('brand_id', $brand_id);
        $this->db->delete('brands');
        return TRUE;
    }

    public function getCategoryData($brand_id)
    {
       $result=$this->Common_model->getAll("supplier_verification",array("email"=>$email))->row();
	   return $result;
    }
    
	
}
