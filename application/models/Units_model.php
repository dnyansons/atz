<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Units_model extends CI_Model
{

    public function __construct() 
    {
        parent::__construct();
    }
    
    public function getAll() 
    {
        $query = $this->db->get('units');
        return $query->result();
    }

    
    /*
     * Following functions are added to use with server side datatables
     */
    
    function allunits_count()
    {   
        $query = $this
                ->db
                ->get('units');
    
        return $query->num_rows();  

    }
    
    function allunits($limit,$start,$col,$dir)
    {   
       $query = $this
                ->db
                ->select("units_id,units_name")
                ->limit($limit,$start)
                ->order_by($col,$dir)
                ->get("units");
        
        if($query->num_rows()>0)
        {
            return $query->result(); 
        }
        else
        {
            return null;
        }
        
    }
   
    function units_search($limit,$start,$search,$col,$dir)
    {
        $query = $this
                ->db
                ->select("units_id,units_name")
                ->like('units_id',$search)
                ->or_like('units_name',$search)
                ->limit($limit,$start)
                ->order_by($col,$dir)
                ->get("units");
        
       
        if($query->num_rows()>0)
        {
            return $query->result();  
        }
        else
        {
            return null;
        }
    }

    function units_search_count($search)
    {
        $query = $this
                ->db
                ->like('units_id',$search)
                ->or_like('units_name',$search)
                ->get("units");
    
        return $query->num_rows();
    }
	
    
    
    public function addUnitsData($data)
    {
        $this->db->set('units_name', $data['units_name']);
		$this->db->set('date_added', date('Y-m-d H:i:s'));
        $this->db->insert('units');

        return TRUE;

    }

    public function updateUnitsData($data, $units_id)
    {

        $this->db->set('units_name', $data['units_name']);
        $this->db->set('date_modified', date('Y-m-d H:i:s'));
        $this->db->where('units_id', $units_id);
        $this->db->update('units');
        return TRUE;
    }

    public function deleteUnitsData($units_id)
    {
        $this->db->where('units_id', $units_id);
        $this->db->delete('units');
        return TRUE;
    }

    public function getUnitsData($units_id)
    {   
	
        $this->db->where('units_id', $units_id);
        $query = $this->db->get('units');
        $result=$query->row();
        return $result; 
    }
    
    public function getUnitByName($name)
    {
        $this->db->where(["units_name"=>$name]);
        $query = $this->db->get("units");
        return $query->row();
    }
    
	
}
