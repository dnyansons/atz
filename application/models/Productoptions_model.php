<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Productoptions_model extends CI_Model
{
	private $_table,$_tableDescription;
    public function __construct() 
    {
       parent::__construct();
    }
	
	
	
	public function addProductOptions($productOptionsData)
    {
        $this->db->insert('products_options',$productOptionsData);
        return $this->db->insert_id();
    }
	
	public function addProductOptionsValues($product_options_values_data)
    {
		
		$count=count($product_options_values_data['option_value_name']);
		
		for($i=0;$i<$count;$i++)
		{
			
			$this->db->set('products_options_id',$product_options_values_data['products_options_id']);
			$this->db->set('option_value_name',$product_options_values_data['option_value_name'][$i]);
			$this->db->set('image',$product_options_values_data['image'][$i]);
		    $this->db->set('sort_order',$product_options_values_data['sort_order'][$i]);
			$this->db->insert('products_options_values');
		}
		
        return true;
    }
    
	
	public function updateProductOptions($data, $products_options_id)
	{
		$this->db->set('products_options_name', $data['products_options_name']);
		$this->db->where('products_options_id', $products_options_id);
		//$this->db->where('manufacturers_id', $manufacturers_id);
		$this->db->update('products_options');
        return TRUE;
	}
	
	
	
	public function updateProductOptionsValues($product_options_values_data, $products_options_id)
    {
		
		$this->db->where('products_options_id', $products_options_id);
		$this->db->delete('products_options_values');
		
		$count=count($product_options_values_data['option_value_name']);
		
		for($i=0;$i<$count;$i++)
		{
			$this->db->set('products_options_id',$product_options_values_data['products_options_id']);
			$this->db->set('option_value_name',$product_options_values_data['option_value_name'][$i]);
			$this->db->set('image',$product_options_values_data['image'][$i]);
		    $this->db->set('sort_order',$product_options_values_data['sort_order'][$i]);
			$this->db->insert('products_options_values');
		}
		
        return true;
    }
	
	
	
	public function deleteProductOptionData($products_options_id, $supplier_id)
	{
	   $this->db->where('products_options_id', $products_options_id);
	   $this->db->where('manufacturers_id', $supplier_id);
       $this->db->delete('products_options');
	   
	   //echo $this->db->last_query();exit;
	   
	   $this->db->where('products_options_id', $products_options_id);
       $this->db->delete('products_options_values');
	   
       return TRUE;
	}
	
	public function getProductOptionsDetails($products_options_id)
	{
		$this->db->distinct();
		$this->db->select('a.products_options_id, a.products_options_name, b.*');
		$this->db->from('products_options as a');
		$this->db->join('products_options_values as b', 'a.products_options_id = b.products_options_id', 'LEFT');
		$this->db->where('a.products_options_id', $products_options_id);
		//$this->db->where('manufacturers_id', $manufacturers_id);
        $query=$this->db->get('products_options');
        return $query->result_array();
			
	}
	
    
	
	
	
	
    /*
     * Following functions are added to use with server side datatables
     */
    
	
	public function getAll() 
    {
		//$this->db->where('manufacturers_id', $manufacturers_id);
        $$query=$this->db->get();
        $result=$query->result();
		return $result;
    }
	
	
    function allproductoptions_count()
    {   
	    //$this->db->where('manufacturers_id', $manufacturers_id);
        $query=$this->db->get('products_options');
        return $query->num_rows();  
    }
    
    function allproductoptions($limit,$start,$col,$dir)
    {   
	   //$this->db->where('manufacturers_id', $manufacturers_id);
	   $this->db->limit($limit,$start);
       $this->db->order_by($col,$dir);
       $query=$this->db->get('products_options');
	
        if($query->num_rows()>0)
        {
            return $query->result(); 
        }
        else
        {
            return null;
        }
        
    }
   
    function productoptions_search($limit,$start,$search,$col,$dir)
    {
        $query = $this
                ->db
                ->select('products_options_id, products_options_name')
                ->like('products_options_id',$search)
                ->or_like('products_options_name',$search)
                ->limit($limit,$start)
                ->order_by($col,$dir)
                ->get("products_options");
        
       
        if($query->num_rows()>0)
        {
            return $query->result();  
        }
        else
        {
            return null;
        }
    }

    function productoptions_search_count($search)
    {
        $query = $this
                ->db
                ->like('products_options_id',$search)
                ->or_like('products_options_name',$search)
                ->get("products_options");
    
        return $query->num_rows();
    }
	
	
	
}