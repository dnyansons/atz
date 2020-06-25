<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Vendorwallethistory_model extends CI_Model
{

    public function __construct() 
    {
        parent::__construct();
    }

    /*
     * Following functions are added to use with server side datatables
     */
    
    function allhostory_count()
    {   
       $query = $this->db->query("select count(hist_id) as total from wallet_vendor_history where vendor_id='".$_POST['vendor_id']."' ")->row();
        return $query->total;  
    }
    

    function allhistory($limit,$start,$col,$dir)
    {   
       $this->db->select("order_id,amount,type,date");
       $this->db->from('wallet_vendor_history');
       $this->db->limit($limit,$start);
       $this->db->where('status',$_POST['status']);
       $this->db->where('vendor_id',$_POST['vendor_id']);
       $this->db->order_by($col,$dir);
       $query =  $this->db->get();
        
        if($query->num_rows()>0)
        {
            return $query->result(); 
        }
        else
        {
            return null;
        }
        
    }
   
    function history_search($limit,$start,$search,$col,$dir)
    {
        $this->db->select("order_id,amount,type,date");
        $this->db->from('wallet_vendor_history');
		$this->db->where('status',$_POST['status']);
	    $this->db->where('vendor_id',$_POST['vendor_id']);
        $this->db->group_start();
		$this->db->like('order_id',$search);
		$this->db->or_like('amount',$search);
		$this->db->or_like('type',$search);
		$this->db->or_like('date',$search);
		$this->db->group_end();
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


    function history_search_count($search)
    {
        $this->db->select("order_id,amount,type,date");
        $this->db->from('wallet_vendor_history');
		$this->db->where('status',$_POST['status']);
	    $this->db->where('vendor_id',$_POST['vendor_id']);
        $this->db->group_start();
		$this->db->like('order_id',$search);
		$this->db->or_like('amount',$search);
		$this->db->or_like('type',$search);
		$this->db->or_like('date',$search);
		$this->db->group_end();
        $query = $this->db->get();
        return $query->num_rows();
    }
    
    public function addHistory($data)
    {
        $this->db->insert("wallet_vendor_history",$data);
        return $this->db->insert_id();
    }

    function get_vendor_history($vendor_id)
	{
		$this->db->select('amount,type as transaction_type,date as created, remark');
		$this->db->where('vendor_id',$vendor_id);
		$this->db->from('wallet_vendor_history');
		return $this->db->get()->result_array();
	}

}