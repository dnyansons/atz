<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Review_model extends CI_Model
{
    private $_table;
    private $_tableDescription;
    public function __construct() 
    {
        parent::__construct();
        $this->load->database();
		$this->load->model('Common_model'); 
        $this->_table = "reviews";
        $this->_tableDescription = "reviews_description";
    }
    
   
	
	public function get_review(){

        $reviews = $this->Common_model->getAll("reviews")->result_array();
        return $reviews;
    }

   
    
    function allreview_count($supplier_id=0)
    {   
	    if($supplier_id!=0)
		{
		   $this->db->select('a.*');
		   $this->db->from('reviews as a');
		   $this->db->join('product_details as b', 'a.products_id=b.id');
		   $this->db->where('b.seller', $supplier_id);
		   $query = $this->db->get('reviews');
           return $query->num_rows(); 
		}
		else
		{
		   $this->db->select('a.*');
		   $this->db->from('reviews as a');
		   $this->db->join('product_details as b', 'a.products_id=b.id');
		   $query = $this->db->get('reviews');
           return $query->num_rows();
		}
		
         
    }
    
    function allreview($limit,$start,$col,$dir,$pro_id = 0,$supplier_id=0)
    {   
      if($supplier_id!=0)
	  {
		 $this->db->select('a.*, b.*, c.name as products_name');
		 $this->db->from('reviews as a');
	     $this->db->join('reviews_description as b', 'a.reviews_id = b.reviews_id');
		 $this->db->join('product_details as c', 'a.products_id=c.id');

		 
		 if($pro_id !=0)
		 {
		   $this->db->where('a.products_id',$pro_id);
	     }
		 
		 $this->db->where('c.seller', $supplier_id);

	  }
	  
	  else
	  {
	     $this->db->select('a.*, b.*, c.name as products_name');
		 $this->db->from('reviews as a');
	     $this->db->join('reviews_description as b', 'a.reviews_id = b.reviews_id');
		 $this->db->join('product_details as c', 'a.products_id=c.id');
		 
		 if($pro_id !=0)
		 {
		   $this->db->where('a.products_id',$pro_id);
	     }
		 
	  }

	 $query = $this->db->get();
     $query=$query->result();
        if($query>0)
        {
            return $query; 
        }
        else
        {
            return null;
        }
        
    }
   
    function review_search($limit,$start,$search,$col,$dir,$supplier_id=0)
    {
		
		if($supplier_id!=0)
		{
		   $this->db->select('a.*, b.*, c.name as products_name');
		   $this->db->from('reviews as a');
		   $this->db->like('a.reviews_id',$search);
           $this->db->or_like('a.retailers_name',$search);
	       $this->db->join('reviews_description as b', 'a.reviews_id = b.reviews_id');
		   $this->db->join('product_details as c', 'a.products_id=c.id');
		   $this->db->limit($limit,$start);
		   $this->db->where('c.seller',$supplier_id);
           $this->db->order_by('a.'.$col,$dir);
		   $query=$this->db->get();
		}
		
		else
		{
		   $this->db->select('a.*, b.*, c.name as products_name');
		   $this->db->from('reviews as a');
		   $this->db->like('a.reviews_id',$search);
           $this->db->or_like('a.retailers_name',$search);
	       $this->db->join('reviews_description as b', 'a.reviews_id = b.reviews_id');
		   $this->db->join('product_details as c', 'a.products_id=c.id');
		   $this->db->limit($limit,$start);
           $this->db->order_by('a.'.$col,$dir);
		   $query=$this->db->get();
		}
		
        
       
        if($query->num_rows()>0)
        {
            return $query->result();  
        }
        else
        {
            return null;
        }
    }

    function review_search_count($search, $supplier_id=0)
    {
		
		if($supplier_id!=0)
		{
		   $this->db->select('a.*, b.*');
		   $this->db->from('reviews as a');
		   $this->db->like('a.reviews_id',$search);
           $this->db->or_like('a.retailers_name',$search);
	       $this->db->join('reviews_description as b', 'a.reviews_id = b.reviews_id');
		   $this->db->join('product_details as c', 'a.products_id=c.id');
		   $this->db->where('c.seller',$supplier_id);
		   $query=$this->db->get();
		}
		
		else
		{
		   $this->db->select('a.*, b.*');
		   $this->db->from('reviews as a');
		   $this->db->like('a.reviews_id',$search);
           $this->db->or_like('a.retailers_name',$search);
	       $this->db->join('reviews_description as b', 'a.reviews_id = b.reviews_id');
		   $this->db->join('product_details as c', 'a.products_id=c.id');
		   $query=$this->db->get();
		}
		
        return $query->num_rows();
    }
	
	
	public function review_delete($reviews_id)
	{
	   $this->db->where('reviews_id', $reviews_id);
       $this->db->delete('reviews');
	   
	   $this->db->where('reviews_id', $reviews_id);
       $this->db->delete('reviews_description');
       return TRUE;
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
	
	public function review_reply_data($reply_data)
	{
	   //print_r($reply_data);exit;
	   $this->db->set($reply_data);
       $this->db->insert('reviews_reply');
       return TRUE;
	}
	
	public function getReplydata($reviews_id)
	{
	   $this->db->where('reviews_id', $reviews_id);
       $query=$this->db->get('reviews_reply');
       return $query->row();
	}

	public function addReviewData($reviews_data)
	{
	   $this->db->set($reviews_data);
       $this->db->insert('reviews');
       return $this->db->insert_id();
	}

	public function addReviewDescriptionData($reviews_description_data)
	{
       $this->db->set($reviews_description_data);
       $this->db->insert('reviews_description');
       return TRUE;
	}

	function get_reviews($product_id)
	{
       $this->db->select('reviews_rating');
	   $this->db->where('products_id', $product_id);
       $query=$this->db->get('reviews');
        return $query->result_array();
	}
}
