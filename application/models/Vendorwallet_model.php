<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Vendorwallet_model extends CI_Model
{

    public function __construct() 
    {
        parent::__construct();
    }

    /*
     * Following functions are added to use with server side datatables
     */
    
    function allvendors_count()
    {   
       $query = $this->db->query("select count(id) as total from users where role='seller' and approved_status='Approved'")->row();
        return $query->total;  
    }
    

    function allwallet($limit,$start,$col,$dir)
    {   
       $this->db->select("a.id,a.username,a.first_name,a.last_name,a.email,a.phone,b.*");
       $this->db->from('users as a');
       $this->db->join('wallet_vendor as b', 'a.id=b.vendor_id','left');
       $this->db->limit($limit,$start);
       $this->db->where('a.approved_status',"Approved");
	   $this->db->where('a.role',"seller");
       $this->db->order_by("a.".$col,$dir);
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
   
    function wallet_search($limit,$start,$search,$col,$dir)
    {
        $this->db->select("a.id,a.username,a.first_name,a.last_name,a.email,a.phone,b.*");
        $this->db->from('users as a');
        $this->db->join('wallet_vendor as b', 'a.id=b.vendor_id','left');
		$this->db->where('a.approved_status',"Approved");
		$this->db->where('a.role',"seller");
        $this->db->group_start();
		$this->db->like('concat("ATZ",a.id)',$search);
		$this->db->or_like('a.username',$search);
		$this->db->or_like('a.first_name',$search);
		$this->db->or_like('a.last_name',$search);
		$this->db->or_like('a.email',$search);
		$this->db->or_like('a.phone',$search);
		$this->db->group_end();
        $this->db->limit($limit,$start);
        $this->db->order_by("a.".$col,$dir);
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


    function wallet_search_count($search)
    {
        $this->db->select("a.id,a.username,a.first_name,a.last_name,a.email,a.phone,b.*");
        $this->db->from('users as a');
        $this->db->join('wallet_vendor as b', 'a.id=b.vendor_id','left');
		$this->db->where('a.approved_status',"Approved");
		$this->db->where('a.role',"seller");
		$this->db->group_start();
        $this->db->like('concat("ATZ",a.id)',$search);
		$this->db->or_like('a.username',$search);
		$this->db->or_like('a.first_name',$search);
		$this->db->or_like('a.last_name',$search);
		$this->db->or_like('a.email',$search);
		$this->db->or_like('a.phone',$search);
		$this->db->group_end();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function creditVendorPendingWallet($vendor_id,$amount)
    {
        $this->db->where(["vendor_id"=>$vendor_id]);
        $this->db->set("pending_balance","pending_balance + ".$amount,false);
        $this->db->update("wallet_vendor");
    }

}