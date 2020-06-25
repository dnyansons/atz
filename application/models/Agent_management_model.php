<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Agent_management_model extends CI_Model
{
    private $table;
    var $column_order = array('admin_id'); 
    var $column_search = array('admin_id'); 
    var $order = array('date_created' => 'asc'); 
    public function __construct() 
    {
        parent::__construct();
        $this->table = "admin";
    }
	
    function get_active_agents()
    {
            $this->db->select('admin_id, admin_role,admin_firstname,admin_lastname,admin_gender,date_modified');
            $this->db->from('admin');
            $this->db->where('status',1);
            return $this->db->get()->result_array();
    }

    function get_inactive_agents()
    {
            $this->db->select('admin_id, admin_role,admin_firstname,admin_lastname,admin_gender,date_modified');
            $this->db->from('admin');
            $this->db->where('status',0);
            return $this->db->get()->result_array();
    }

    function get_historyActiveAgent($id)
    {
            $this->db->select('name, approved_on, id');
            $this->db->from('product_details');
            $this->db->where('approved_by',$id);
            return $this->db->get()->result_array();
    }

    function get_historyApprovedVendors($id)
    {
            $this->db->select('first_name,last_name, updated_on, id');
            $this->db->from('users');
            $this->db->where('approved_by',$id);
            return $this->db->get()->result_array();
    }
    
    private function _get_datatables_query()
    {
         
        //add custom filter here
        if($this->input->post('start_date') && $this->input->post('end_date'))
        {
            $to = date("",strtotime($this->input->post('start_date')));
            $from = date("",strtotime($this->input->post('start_to')));
            $this->db->where('date_created >=', $to);
            $this->db->where('date_created <=', $from);
        }
        if($this->input->post('admin_role'))
        {
            $this->db->where('admin_role', $this->input->post('admin_role'));
        }
        if($this->input->post('admin_id'))
        {
            $this->db->where('admin_id', $this->input->post('admin_id'));
        }
        
        $this->db->where(["$this->table.status"=> $this->input->post("status")]);
        
 
        $this->db->from($this->table);
        $i = 0;
     
        
         
        if(isset($_POST['order'])) // here order processing
        {
            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } 
        else if(isset($this->order))
        {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
        $this->db->select("*,role_name as admin_role_name,$this->table.status as active");
        $this->db->join("admin_role","admin_role.role_id = $this->table.admin_role","LEFT");
    }
 
    public function get_datatables()
    {
        $this->_get_datatables_query();
        if($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }
 
    public function count_filtered()
    {
        $this->_get_datatables_query();
        $query = $this->db->get();
        return $query->num_rows();
    }
 
    public function count_all()
    {
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }
    
    public function updateAgent($id,$data)
    {
        $this->db->where(["admin_id"=>$id]);
        $this->db->update("admin",$data);
    }
 
    
}