<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Sourcing_reason_model extends CI_Model
{

    public function __construct() 
    {
        parent::__construct();
    }
	
	function get_all()
	{
	  $query=$this->db->get('reasons_for_sourcing');
	  return $query->result();
	}


     /*
     * Following functions are added to use with server side datatables
     */
    
    function allsourcingreasons_count()
    {   
        $query = $this->db->get('reasons_for_sourcing');
        return $query->num_rows();  
    }
    

    function allsourcingreasons($limit,$start,$col,$dir)
    {   
       $this->db->select("*");
       $this->db->limit($limit,$start);
       $this->db->order_by($col,$dir);
       $query =  $this->db->get("reasons_for_sourcing");
        
        if($query->num_rows()>0)
        {
            return $query->result(); 
        }
        else
        {
            return null;
        }
        
    }
   
    function sourcingreason_search($limit,$start,$search,$col,$dir)
    {
        $this->db->select("*");
        $this->db->like('reason_id',$search);
        $this->db->or_like('reason_name',$search);
        $this->db->limit($limit,$start);
        $this->db->order_by($col,$dir);
        $query = $this->db->get("reasons_for_sourcing");
        
       
        if($query->num_rows()>0)
        {
            return $query->result();  
        }
        else
        {
            return null;
        }
    }

    function sourcingreason_search_count($search)
    {
        $this->db->select("*");
        $this->db->like('reason_id',$search);
        $this->db->or_like('reason_name',$search);
        $query = $this->db->get("reasons_for_sourcing");
        return $query->num_rows();
    }


    function addData($data)
    {
        $this->db->insert('reasons_for_sourcing', $data);
        return true;
    }


    function updateData($data, $reason_id)
    {
        $this->db->set($data);
        $this->db->where('reason_id', $reason_id);
        $this->db->update('reasons_for_sourcing');
        return true;
    }


    function deleteData($reason_id)
    {
        $this->db->where('reason_id', $reason_id);
        $this->db->delete('reasons_for_sourcing');
        return true;
    }

    function getData($reason_id)
    {
        $this->db->where('reason_id', $reason_id);
        $query=$this->db->get('reasons_for_sourcing');
        return $query->row();
    }


}