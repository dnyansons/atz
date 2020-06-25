<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Cart_model extends CI_Model 
{
    
    public function __construct() 
    {
        parent::__construct();
    }
    
    public function addToCartData($data)
    {
    	$this->db->select('id');
    	$this->db->where('user_id', $data['user_id']);
    	$this->db->where('product_id', $data['product_id']);
    	$query=$this->db->get('add_to_cart');

    	if($query->num_rows()>0)
    	{
           $this->db->set($data);
           $this->db->where('user_id', $data['user_id']);
    	   $this->db->where('product_id', $data['product_id']);
           $query=$this->db->update('add_to_cart');
           return 'UPDATE';
    	}

    	else
    	{
    	   $this->db->set($data);
           $query=$this->db->insert('add_to_cart');
           return 'ADD';
    	}
    	
    }

    public function getCartListData($user_id)
    {
        
    	$this->db->select('id as cart_id,user_id,product_id,offer_id,product_name,product_total_quantity,product_image,supplierDetails as seller_company,specifications');
        $this->db->where('user_id', $user_id);
        $query=$this->db->get('add_to_cart');
        //$this->db->group_by('product_id');
        $result=$query->result_array();
        return $result;
    }

    public function getCartListGrandTotal($user_id)
    {
    	$this->db->select('specifications');
        $this->db->where('user_id', $user_id);
        $query=$this->db->get('add_to_cart');
        $result=$query->result_array();
        $cart_grand_total = 0;
        
        for($i=0;$i<count($result);$i++)
        {
           $specifications=json_decode($result[$i]->specifications);
           //print_r($specifications);exit;
           for($j=0;$j<count($specifications);$j++)
           {
              $cart_grand_total=$cart_grand_total+$specifications[$j]->total_price;
           }
        }

        return $cart_grand_total;
    }


    public function getProductsCartTotal($user_id, $product_id)
    {
    	$this->db->select('specifications');
        $this->db->where('user_id', $user_id);
        $this->db->where('product_id', $product_id);
        $query=$this->db->get('add_to_cart');
        $result=$query->row_array();
        
        $results=json_decode($result->specifications);
        // print_r($results);exit;
        //echo count($result['specifications']);exit;

        $products_total_price=0;

        for($i=0;$i<count($results);$i++)
        {
           $products_total_price=$products_total_price+$results[$i]->specifications->total_price;
        }
        
        return $products_total_price;
    }


    public function getCartProductData($product_id)
    {
        $this->db->select('p.discount_percentage, p.id,p.name,p.keywords,p.category as category_id,ctd.categories_name,p.description,p.weight,p.width,p.height,p.length,p.hike_percentage,p.is_product_returnable,p.product_return_days,p.provide_order_at_buyer_place,p.price_type,p.seller,sc.company_name,address1,main_products,other_products,year_of_register,no_of_employee,office_size,company_url,registration_state,location_country as country_name,currency as currency_name,comp_operational_addr,comp_operational_city,comp_operational_state,comp_operational_region,comp_operational_zip_code,ct.name business_type,sc.id as seller_company_id');
        $this->db->from('product_details p');
        $this->db->join('product_price pp','p.id = pp.product_id');
        $this->db->join('seller_info s','p.seller = s.user_id');
        $this->db->join('seller_company_details sc','sc.user_id = s.user_id');
        $this->db->join('company_types ct','ct.id = s.company_type');
        $this->db->join('categories_description ctd','ctd.categories_id = p.category', 'LEFT');
        $this->db->where('p.id',$product_id);
        $result = $this->db->get()->row_array();


        $this->db->select('a.quantity_from, a.quantity_upto, a.unit as units_id, b.units_name, a.price, a.atz_price, a.final_price');
        $this->db->from('product_price as a');
        $this->db->join('units as b', 'a.unit=b.units_id');
        $this->db->where('product_id', $product_id);
        $query=$this->db->get();
        $result2=$query->result();

        $result['product_prices']=$result2;
        $result['moq']=$result2[0]->quantity_from;
        return $result;
    }


    public function removeFromCartData($user_id, $product_id)
    {
        $this->db->where('user_id', $user_id);
        $this->db->where('product_id', $product_id);
        $this->db->delete('add_to_cart');
        return true;
    }
    
    public function user_product_coupans($user_id,$product_id)
    {
        //echo $product_id;
       // exit;
        $this->db->select('c.coupon_id,c.coupon_code,c.coupon_value,c.discount_type,c.moq,c.valid_from,c.valid_to,c.currency');
        $this->db->from('add_to_cart ac');
        $this->db->where(['ac.user_id'=>$user_id,'ac.product_id'=>$product_id,'c.valid_to >=' => date('Y-m-d')]);
        $this->db->join('coupons_to_product cp','ac.product_id = cp.product_id','inner');
        $this->db->join('coupons c','cp.coupon_id = c.coupon_id','inner');
        $result = $this->db->get()->result_array();
        $result = array_unique($result, SORT_REGULAR);
        return $result;
    }
    
    public function emptyUserCart($user)
    {
        $this->db->where("user_id",$user);
        $this->db->delete("add_to_cart");
    }

}