  <?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Role_model extends CI_Model
{
    private $_table;
    private $_tableDescription;
    public function __construct() 
    {
        parent::__construct();
        $this->load->database();
        $this->load->model('Common_model'); 
        $this->_table = "admin_role";
    }
    
   
    
    function allrole_count()
    {   
        $query = $this
                ->db
                ->get($this->_table);
    
        return $query->num_rows();  

    }
    
    function allrole($limit,$start,$col,$dir)
    {   
        $this->db->select('*');
        $this->db->from('admin_role as a');
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
   
    function role_search($limit,$start,$search,$col,$dir)
    {
        $this->db->from('admin_role');
        $this->db->like('role_id',$search);
        $this->db->or_like('role_name',$search);
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

    function role_search_count($search)
    {
        $query = $this
                ->db
                ->like('role_id',$search)
                ->or_like('role_name',$search)
                ->get($this->_table);
    
        return $query->num_rows();
    }
   
    public function getRoles()
    {
        $query = $this->db->get($this->_table);
        return $query->result();
    }
    
    
}