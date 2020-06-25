  <?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Payment_transaction_model extends CI_Model
{
    private $_table;
    private $_tableDescription;
    public function __construct() 
    {
        parent::__construct();
        $this->load->database();
        $this->load->model('Common_model'); 
        $this->_table = "order_payment";
    }

    function allpay_count()
    {   
        $query = $this
                ->db
                ->get($this->_table);
    
        return $query->num_rows();  

    }
    
    function allpay($limit,$start,$col,$dir)
    {   
        $this->db->select('*');
        $this->db->from('order_payment');
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
   
    function pay_search($limit,$start,$search,$col,$dir)
    {
        $this->db->select('*');
        $this->db->from('order_payment a');
        //$this->db->join('categories_description as b', 'a.applicable_category_id=b.categories_id');
        $this->db->like('a.orders_id',$search);
        $this->db->or_like('a.email',$search);
        $this->db->or_like('a.status',$search);
        $this->db->or_like('a.amount',$search);
        $this->db->or_like('a.payment_id',$search);
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

    function pay_search_count($search)
    {
        $query = $this
                ->db
                ->like('orders_id',$search)
                ->or_like('email',$search)
                ->or_like('status',$search)
                ->or_like('payment_id',$search)
                ->get($this->_table);
    
        return $query->num_rows();
    }
    
   
}