<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Profile_model extends CI_Model
{
  
    public function __construct() 
    {
        parent::__construct();
        $this->load->database();
		$this->load->model('Common_model'); 
        
    }
    
    function language_spoken($supplier_id)
	{
		$q=$this->db->query('SELECT t1.`id`,t1.`language`,t2.lang_id FROM manufacturer_language_spoken t1 LEFT JOIN (SELECT lang_id,manufacturers_id FROM manufacturer_spoken_language_child WHERE manufacturers_id="'.$supplier_id.'")t2 ON (t1.id=t2.lang_id)')->result_array();
		return $q;
	}
	
	function acc_payment($supplier_id)
	{
		$q=$this->db->query("SELECT t1.`id`,t1.`pay_type`,t2.pay_id FROM manufacturer_accept_pay_type t1 LEFT JOIN(SELECT `manufacturers_id`,`pay_id` FROM manufacturer_accept_pay_type_child WHERE `manufacturers_id`='".$supplier_id."')t2 ON (t1.id=t2.pay_id)")->result_array();
		return $q;
	}
	
	function acc_currency($supplier_id)
	{
		$q=$this->db->query("SELECT t1.id,t1.currency,t2.curr_id FROM manufacturer_accepted_currency t1 LEFT JOIN(SELECT `manufacturers_id`,`curr_id` FROM manufacturer_accepted_currency_child WHERE `manufacturers_id`='".$supplier_id."')t2 ON(t1.id=t2.curr_id)")->result_array();
		return $q;
	}
	
	function del_term($supplier_id)
	{
		$q=$this->db->query("SELECT `id`,`term`,terms_id FROM accepted_delivery_terms t1 LEFT JOIN(SELECT `manufacturers_id`,`terms_id` FROM manufacturer_accepted_delivery_term_child WHERE `manufacturers_id`='".$supplier_id."')t2 ON(t1.`id`=t2.terms_id)")->result_array();
		return $q;
	}
	
	function mar_dist($supplier_id)
	{
		$q=$this->db->query("SELECT t1.`id`,t1.`m_name`,t2.market_dist_value,t2.market_dist_id FROM manufacturer_main_market_distribution t1 LEFT JOIN (SELECT `manufacturers_id`,`market_dist_value`,`market_dist_id` FROM manufacturer_main_market_distribution_child WHERE `manufacturers_id`='".$supplier_id."')t2 ON (t1.id=t2.market_dist_id)")->result_array();
		return $q;
		
	}
        
        public function check_user_exits($user_id)
        {
            $this->db->select('username');
            $this->db->from('users');
            $this->db->where('id',$user_id);
            $user_arr = $this->db->get()->result_array();
            if (!empty($user_arr)){
                return true;
            }else{
                return false;
            }
            
        }
        
        function buyer_notification($user_id,$date)
        {
            $this->db->select('*');
            $this->db->from('buyer_notification');
            $this->db->where('user_id',$user_id);
            $this->db->where('DATE(date_created)',$date);
            //$this->db->where('status','Received');
            $this->db->order_by('id','desc');
            return $this->db->get()->result();
        }
        
        
        public function user_wallet_balance($user_id)
        {
            $where = array('user_id' => $user_id,'status' => 1);
            $this->db->select('balance');
            $this->db->from('buyer_wallet');
            $this->db->where($where);
             $bal=$this->db->get()->result_array()[0]['balance'];
             if($bal > 0)
             {
                 return $bal;
             }else{
                 return 0;
             }
        }
        
        public function user_wallet_history($user_id)
        {
            $this->db->select('*');
            $this->db->from('buyer_wallet_history');
            $this->db->where('buyer_id',$user_id);
            $this->db->order_by('id','desc');
            return $this->db->get()->result_array();
        }
    
	
}
