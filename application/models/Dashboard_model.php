<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Dashboard_model extends CI_Model
{
    private $_table;
    private $_tableDescription;
    public function __construct() 
    {
        parent::__construct();
        $this->load->database();
		$this->load->model('Common_model'); 
        
    }
    
    public function tot_order_supp($supp_id) 
    {
        $this->db->select('*', false);
        $this->db->from('orders_products as a');
        $this->db->join('product_details as b', 'a.products_id=b.id AND b.seller="'.$supp_id.'"');
        $this->db->join('orders as c', 'c.orders_id=a.orders_id');
	$this->db->where('c.orders_status !=',8);	
	$this->db->where('date(c.date_purchased)',date('Y-m-d'));	
        $query = $this->db->get();
        return $result=$query->num_rows();
	  
    }
	
	public function tot_sale_supp($supp_id)
	{

            /*$this->db->select('SUM(c.order_price) sale', false);
            $this->db->from('orders_products as a');
            $this->db->join('product_details as b', 'a.`products_id`=b.`id`');
            $this->db->join('orders as c', 'a.orders_id=c.orders_id');
            $this->db->join('orders_status as d', 'c.orders_status=d.orders_status_id');
            $this->db->where('b.seller="'.$supp_id.'"');
            $this->db->where('date(c.date_purchased)',date('Y-m-d'));
            $this->db->where('c.orders_status=4');
            $this->db->or_where('c.orders_status=10');
            $this->db->or_where('c.orders_status=26');
            $this->db->or_where('c.orders_status=19');*/
            
            $this->db->select('SUM(a.vendor_payable_price) sale', false);
            $this->db->from('orders as a');
            $this->db->where('a.seller_id="'.$supp_id.'" AND date(a.date_purchased)="'.date('Y-m-d').'" and (a.orders_status=4 or a.orders_status=10 or a.orders_status=26 or a.orders_status=19)');
           
            

            $query = $this->db->get();
           

            $result=$query->row_array();
            return $result['sale'];
		

	}
	
	public function tot_customer_supp($supp_id)
	{

		$this->db->select('*', false);
        $this->db->from('orders as a');
       // $this->db->join('orders_products as b', 'a.`orders_id`=b.`orders_id`');
       // $this->db->join('product_details as c', 'b.products_id=c.id');
		$this->db->where('a.seller_id="'.$supp_id.'"');
		$this->db->group_by('a.`user_id`');
		
		$query = $this->db->get();
        return $result=$query->num_rows();
	}
	
	public function latest_order($supp_id)
	{
		$this->db->select('*', false);
        $this->db->from('orders as a');
        $this->db->join('orders_products as b', 'a.`orders_id`=b.`orders_id`');
        $this->db->join('product_details as c', 'b.products_id=c.id');
        $this->db->join('orders_status as d', 'a.orders_status=d.orders_status_id');
		$this->db->where('c.seller="'.$supp_id.'"');
		$this->db->order_by('a.orders_id','desc');
		$this->db->limit(5,0);
		
        $query = $this->db->get();
        return $result=$query->result_array();
		
	}
	
	
	function supp_orders_monthly($supp_id)
	{
		$this->db->select('COUNT(a.orders_id)orders,YEAR(a.date_purchased)Year, DATE_FORMAT(a.date_purchased,"%b")Month');
        $this->db->from('orders as a');
        $this->db->join('orders_products as b', 'a.`orders_id`=b.`orders_id`');
        $this->db->join('product_details as c', 'b.products_id=c.id');
        $this->db->join('orders_status as d', 'a.orders_status=d.orders_status_id');
		$this->db->where('c.seller="'.$supp_id.'"');
		$this->db->group_by('YEAR(a.date_purchased),MONTH(a.date_purchased)');
		$this->db->order_by('MONTH(a.date_purchased)');
		$query = $this->db->get();
        return $result=$query->result_array();
		
	}
	
	
	///////////////////Buyer Information/////////////////////////////
	function tot_order_buyer($user_id)
	{
		$this->db->select('*');
        $this->db->from('orders');
		$this->db->where('user_id',$user_id);
        $query = $this->db->get();
        return $result=$query->num_rows();
	}
	
	
	function user_info($user_id)
	{
		$this->db->select('*');
        $this->db->from('users');
		$this->db->where('id',$user_id);
        $query = $this->db->get();
        return $result=$query->row();
	}
	
	function buyer_coupons($user_id)
	{
		$this->db->select('*');
        $this->db->from('mycoupons');
		$this->db->where('user_id',$user_id);
        $query = $this->db->get();
        return $result=$query->num_rows();
	}
	
	function buyer_favourites($user_id)
	{
		$this->db->select('*');
        $this->db->from('buyer_favourites');
		$this->db->where('user_id',$user_id);
        $query = $this->db->get();
       
	    $result=$query->row_array();
		$p_fav=json_decode($result['products']);
		//$s_fav=explode(',',$result['suppliers']);   
		return $product_fav=count($p_fav);
		
		 
	}
	
	function buyer_inquiries($user_id)
	{
		$this->db->select('*');
        $this->db->from('inquiries');
		$this->db->where('by_user',$user_id);
        $query = $this->db->get();
        return $result=$query->num_rows();
	}


	//////////////////////////----------------------------------------------

	// BELOW FOR ADMIN 

	//////////////////////////----------------------------------------------


    public function tot_order_admin() 
    {
        $this->db->select('*', false);
        $this->db->from('orders_products as a');
        $this->db->join('product_details as b', 'a.products_id=b.id');
		
        $query = $this->db->get();
        return $result=$query->num_rows();
	  
    }
	
	public function tot_sale_admin()
	{

		$this->db->select('SUM(a.`final_price`)sale', false);
        $this->db->from('orders_products as a');
        $this->db->join('product_details as b', 'a.`products_id`=b.`id`');
        $this->db->join('orders as c', 'a.orders_id=c.orders_id');
        $this->db->join('orders_status as d', 'c.orders_status=d.orders_status_id');
		$this->db->where('c.orders_status=4');
		
		$query = $this->db->get();
        
		$result=$query->row_array();
		return $result['sale'];
		

	}
	
	public function tot_customer_admin()
	{	
		$query = $this->db->get('users');
        return $result=$query->num_rows();
	}
	
	public function latest_order_admin()
	{
		$this->db->select('*', false);
        $this->db->from('orders as a');
        $this->db->join('orders_products as b', 'a.`orders_id`=b.`orders_id`');
        $this->db->join('product_details as c', 'b.products_id=c.id');
        $this->db->join('orders_status as d', 'a.orders_status=d.orders_status_id');
		$this->db->order_by('a.orders_id','desc');
		$this->db->limit(5,0);
		
        $query = $this->db->get();
        return $result=$query->result_array();
		
	}
	
	
	function admin_orders_monthly($status = 0)
	{
            $this->db->select('COUNT(a.orders_id)orders,YEAR(a.date_purchased)Year, DATE_FORMAT(a.date_purchased,"%b")Month');
            $this->db->from('orders as a');
            $this->db->join('orders_products as b', 'a.`orders_id`=b.`orders_id`');
            $this->db->join('product_details as c', 'b.products_id=c.id');
            $this->db->join('orders_status as d', 'a.orders_status=d.orders_status_id');
            $this->db->group_by('YEAR(a.date_purchased),MONTH(a.date_purchased)');
            $this->db->order_by('MONTH(a.date_purchased)');
            if($status){
                $this->db->where(["orders_status" => $status]);
            }
            $query = $this->db->get();
            return $result=$query->result_array();
		
	}
        
       
	
}
