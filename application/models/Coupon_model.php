<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Coupon_model extends CI_Model
{
    private $_table;
    private $_tableDescription;
    public function __construct() 
    {
        parent::__construct();
        $this->load->database();
        $this->load->model('Common_model'); 
        $this->_table = "coupons";
    }
    
    public function getAll() 
    {
        $query = $this->db->get($this->_table);
        return $query->result();
    }
    
    public function get_coupons(){

        $coupons = $this->Common_model->getAll("coupons")->result_array();
        return $coupons;
    }

    function allcoupon_count()
    {   
        $query = $this
                ->db
                ->get($this->_table);
    
        return $query->num_rows();  

    }
    
    function allcoupon($limit,$start,$col,$dir)
    {   
        $this->db->select('a.*');
        $this->db->from('coupons as a');
        //$this->db->join('categories_description as b', 'a.applicable_category_id=b.categories_id', 'left');
        $this->db->limit($limit,$start);
        $this->db->order_by($col,$dir);
        $query = $this->db->get();
        
        if($query->num_rows()>0)
        {
            return $query->result(); 
        }
        else
        {
            return null;
        }
        
    }
   
    function coupon_search($limit,$start,$search,$col,$dir)
    {
        $this->db->select('a.*');
        $this->db->from('coupons as a');
        //$this->db->join('categories_description as b', 'a.applicable_category_id=b.categories_id');
        $this->db->like('a.coupon_id',$search);
        $this->db->or_like('a.coupon_code',$search);
        $this->db->or_like('a.discount_type',$search);
        $this->db->limit($limit,$start);
        $this->db->order_by($col,$dir);
        $query = $this->db->get();
        
       
        if($query->num_rows()>0)
        {
            return $query->result();  
        }
        else
        {
            return null;
        }
    }

    function coupon_search_count($search)
    {
        $query = $this
                ->db
                ->like('coupon_id',$search)
                ->or_like('coupon_code',$search)
                ->or_like('discount_type',$search)
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

    public function deleteCouponData($coupon_id)
    {
        $this->db->where('coupon_id', $coupon_id);
        $this->db->delete('coupons');
        return TRUE;
    }

    public function getCouponData($coupon_id)
    {
       $result=$this->Common_model->getAll("coupons")->row();
       return $result;
    }

    ////////////////////////////My Coupons ///////////////////////////
    function allmycoupons($user_id,$limit,$start,$col,$dir)
    {   
		$this->db->select('*');
		$this->db->from('mycoupons a');
		$this->db->join('coupons b', 'b.coupon_id = a.coupon_id');
		$this->db->where('a.user_id',$user_id);
		$this->db->limit($limit,$start);
		$this->db->group_by('a.coupon_id');
        $this->db->order_by($col,$dir);
		$query = $this->db->get();
	  
        if($query->num_rows()>0)
        {
            return $query->result(); 
        }
        else
        {
            return null;
        }
        
    }
	
    function allmycoupon_count($user_id)
    {   
        $this->db->select('*');
		$this->db->from('mycoupons a');
		$this->db->join('coupons b', 'b.coupon_id = a.coupon_id');
		$this->db->where('a.user_id',$user_id);
		$query = $this->db->get();
        return $query->num_rows();  

    }
	
    function mycoupon_search($user_id,$limit,$start,$search,$col,$dir)
    {
        $this->db->select('*');
		$this->db->from('mycoupons a');
		$this->db->join('coupons b', 'b.coupon_id = a.coupon_id');
		$this->db->where('a.user_id',$user_id);
		$this->db->where("(`a`.`coupon_id` LIKE '%".$search."%' ESCAPE '!' OR `b`.`coupon_code` LIKE '%".$search."%' ESCAPE '!')");
		$this->db->limit($limit,$start);
        $this->db->order_by($col,$dir);
		$query = $this->db->get();
       
        if($query->num_rows()>0)
        {
            return $query->result();  
        }
        else
        {
            return null;
        }
    }
	
    function mycoupon_search_count($user_id,$search) 
    {
        $this->db->select('*');
		$this->db->from('mycoupons a');
		$this->db->join('coupons b', 'b.coupon_id = a.coupon_id');
		$this->db->where('a.user_id',$user_id);
		$this->db->where("(`a`.`coupon_id` LIKE '%".$search."%' ESCAPE '!' OR `b`.`coupon_code` LIKE '%".$search."%' ESCAPE '!')");
		$query = $this->db->get();
    
        return $query->num_rows();
    }
	
	
    
    public function insert($tablename,$data) 
    { 
        $this->db->insert($tablename,$data);
        return $this->db->insert_id();
    } 
    
    public function update($tablename,$data,$where)
    { 
        $this->db->where($where); 
        $query = $this->db->update($tablename,$data); 
        return $this->db->affected_rows();
    } 
    
    public function getCoupon($coupon_id)
    {
        $this->db->select('a.*, b.categories_name as categories_name');
        $this->db->from('coupons as a');
        $this->db->join('categories_description as b', 'a.applicable_category_id=b.categories_id','left');
        $this->db->where('a.coupon_id', $coupon_id);
        $query = $this->db->get();
        return $query;

    }
    
    public function getUserCoupons($user,$isactive = 0)
    {
        $this->db->select("C.coupon_id as coupon_uniqe_id,coupon_code,coupon_value,discount_type,moq,valid_from,valid_to,currency,MC.status");
        $this->db->from("coupons C");
        $this->db->join("mycoupons MC","MC.coupon_id = C.coupon_id");
        $this->db->where(["MC.user_id"=>$user]);
        $this->db->where(["MC.status"=>"GET"]);
        if($isactive){
            $this->db->where("valid_from <= '".date("Y-m-d")."' AND valid_to >= '".date("Y-m-d")."'");
        } else {
            $this->db->where(" valid_to < '".date("Y-m-d")."'");
        }
        $query = $this->db->get();
        return $query->result();
    }
    
    public function addCoupon($data)
    {
        $this->db->insert("coupons",$data);
        return $this->db->insert_id();
    }
    
    public function addUserCoupon($data)
    {
        $this->db->insert("mycoupons",$data);
    }
    
    public function isAlreadyExists($user,$coupon_id)
    {
        $this->db->where(["user_id"=>$user,"coupon_id"=>$coupon_id]);
        $query = $this->db->get("mycoupons");
        $result = $query->result();
        if($result){
            return true;
        }
        return false;
    }
    
    public function isCouponAvailableForUser($coupon_id,$product_id,$user)
    {
        $this->db->where(["C.coupon_id"=>$coupon_id,"CP.product_id"=>$product_id,"MC.user_id"=>$user,"MC.status"=>"GET"]);
        $this->db->where("C.valid_from <= '".date("Y-m-d")."' AND C.valid_to >= '".date("Y-m-d")."'");
        $this->db->from("coupons C");
        $this->db->join("coupons_to_product CP","CP.coupon_id = C.coupon_id");
        $this->db->join("mycoupons MC","C.coupon_id = MC.coupon_id");
        $query = $this->db->get();
        $result = $query->result();
        if($result){
            return true;
        }
        return false;
    }
    
    public function updateCouponRedeemStatus($user,$coupon)
    {
        $data = ["status"=>"REDEEM"];
        $this->db->where(["user_id"=>$user,"coupon_id"=>$coupon]);
        $this->db->update("mycoupons",$data);
        return $this->db->affected_rows();
    }
    
     function expire_coupon($order_id=0)
        {
            if(!empty($order_id))
            {
                $this->db->select('a.user_id,b.coupon_id');
                $this->db->from('orders a');
                $this->db->join('orders_products b','a.orders_id=b.orders_id');
                $this->db->where('a.orders_id',$order_id);
                $query=$this->db->get()->result();

                foreach($query as $ord)
                {
                    if($ord->coupon_id!=0)
                    {
                       $user=$ord->user_id;
                       $coupon=$ord->coupon_id;

                       $data = ["status"=>"REDEEM"];
                       $this->db->where(["user_id"=>$user,"coupon_id"=>$coupon]);
                       $this->db->update("mycoupons",$data); 
                    }
                }


            }
        }
        
    public function getCoupenById($id)
    {
        $this->db->where(["coupon_id"=>$id]);
        $query = $this->db->get("coupons");
        return $query->row();
    }
    
}