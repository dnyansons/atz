<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Currency_model extends CI_Model
{
    private $_table;
    private $_tableDescription;
    public function __construct() 
    {
        parent::__construct();
        $this->load->database();
		$this->load->model('Common_model'); 
        $this->_table = "currency_conver_charges";
        //$this->_tableDescription = "categories_description";
    }
    
    public function getAll() 
    {
        $query = $this->db->get($this->_table);
        return $query->result();
    }
	
	

   
    
    function allcurr_count()
    {   
        $query = $this
                ->db
                ->get($this->_table);
    
        return $query->num_rows();  

    }
    
    function allbrand($limit,$start,$col,$dir)
    {   
       $query = $this->Common_model->getAll("currency_conver_charges")->num_rows();
       $curr = $this->Common_model->getAll("currency_conver_charges")->result();
        
        if($query>0)
        {
            return $curr; 
        }
        else
        {
            return null;
        }
        
    }
   
    function curr_search($limit,$start,$search,$col,$dir)
    {
        $query = $this
                ->db
                ->select("*")
                ->like('curr_id',$search)
                ->or_like('currency_from',$search)
                
                ->limit($limit,$start)
                ->order_by($col,$dir)
                ->get($this->_table);
        
       
        if($query->num_rows()>0)
        {
            return $query->result();  
        }
        else
        {
            return null;
        }
    }

    function curr_search_count($search)
    {
        $query = $this
                ->db
                ->like('curr_id',$search)
                ->or_like('currency_from',$search)
                ->or_like('currency_to',$search)
                ->get($this->_table);
    
        return $query->num_rows();
    }
	
	
    
   

    public function deletecurr($curr_id)
    {
        $this->db->where('curr_id', $curr_id);
        $this->db->delete('currency_conver_charges');
        return TRUE;
    }

  
	
}
