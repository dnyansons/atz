<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Tax_class_model extends CI_Model
{

    public function __construct() 
    {
        parent::__construct();
    }
	
	function get_all()
	{
	  $query=$this->db->get('tax_class');
	  return $query->result();
	}

     /*
     * Following functions are added to use with server side datatables
     */
    
    function alltaxclass_count()
    {   
        $query = $this->db->get('tax_class');
        return $query->num_rows();  
    }
    

    function alltaxclass($limit,$start,$col,$dir)
    {   
       $this->db->select("a.*, b.nicename as country_name");
       $this->db->from('tax_class as a');
       $this->db->join('country as b', 'a.country_id=b.id', 'left');
       $this->db->limit($limit,$start);
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
   
    function taxclass_search($limit,$start,$search,$col,$dir)
    {
        $this->db->select("a.*, b.nicename as country_name");
        $this->db->from('tax_class as a');
        $this->db->join('country as b', 'a.country_id=b.id', 'left');
        $this->db->like('a.tax_class_id',$search);
        $this->db->or_like('a.tax_class_title',$search);
        $this->db->or_like('b.nicename',$search);
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

    function taxclass_search_count($search)
    {
        $this->db->select("a.*, b.nicename as country_name");
        $this->db->from('tax_class as a');
        $this->db->join('country as b', 'a.country_id=b.id', 'left');
        $this->db->like('a.tax_class_id',$search);
        $this->db->or_like('a.tax_class_title',$search);
        $this->db->or_like('b.nicename',$search);
        $query = $this->db->get();
        return $query->num_rows();
    }


    function addData($data)
    {
        $this->db->insert('tax_class', $data);
        return true;
    }


    function updateData($data, $tax_class_id)
    {
        $this->db->set($data);
        $this->db->where('tax_class_id', $tax_class_id);
        $this->db->update('tax_class');
        return true;
    }


    function deleteData($tax_class_id)
    {
        $this->db->where('tax_class_id', $tax_class_id);
        $this->db->delete('tax_class');
        return true;
    }

    function getData($tax_class_id)
    {
        $this->db->where('tax_class_id', $tax_class_id);
        $query=$this->db->get('tax_class');
        return $query->row();
    }


}