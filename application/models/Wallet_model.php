<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Wallet_model extends CI_Model
{
    private $_column_order =["bw.id"];
    public function __construct() 
    {
        parent::__construct();
    }

    /*
     * Following functions are added to use with server side datatables
     */
    
    function allwallet_count()
    {   
       $this->db->select("a.orders_id, a.delivery_date, b.final_price as order_amount, c.wallet_transaction_status");
       $this->db->from('orders as a');
       $this->db->join('orders_products as b', 'a.orders_id=b.orders_id','left');
       $this->db->join('users_wallet as c', 'a.orders_id=c.orders_id','left');
       $this->db->where('a.orders_status', 4);
       $query =  $this->db->get();
        return $query->num_rows();  
    }
    

    function allwallet($limit,$start,$col,$dir)
    {   
       $this->db->select("a.orders_id, a.delivery_date, b.final_price as order_amount, c.wallet_transaction_status");
       $this->db->from('orders as a');
       $this->db->join('orders_products as b', 'a.orders_id=b.orders_id','left');
       $this->db->join('users_wallet as c', 'a.orders_id=c.orders_id','left');
       $this->db->limit($limit,$start);
       $this->db->where('a.orders_status', 4);
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
        $this->db->select("a.orders_id, a.delivery_date, b.final_price as order_amount, c.wallet_transaction_status");
        $this->db->from('orders as a');
        $this->db->join('orders_products as b', 'a.orders_id=b.orders_id','left');
        $this->db->join('users_wallet as c', 'a.orders_id=c.orders_id','left');
        $this->db->like('wallet_transaction_id',$search);
        //$this->db->or_like('shipping_method_name',$search);
        $this->db->limit($limit,$start);
        $this->db->where('a.orders_status', 4);
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
        $this->db->select("a.orders_id, a.delivery_date, b.final_price as order_amount, c.wallet_transaction_status");
        $this->db->from('orders as a');
        $this->db->join('orders_products as b', 'a.orders_id=b.orders_id','left');
        $this->db->join('users_wallet as c', 'a.orders_id=c.orders_id','left');
        $this->db->like('wallet_transaction_id',$search);
        //$this->db->or_like('shipping_method_name',$search);
        $this->db->where('a.orders_status', 4);
        $query = $this->db->get();
        return $query->num_rows();
    }
    
    public function createWallet($data)
    {
        $this->db->insert("wallet_vendor",$data);
        return $this->db->insert_id();
    }
    public function getWallerBySellerId($seller)
    {
        $query = $this->db->get_where("wallet_vendor",["vendor_id"=>$seller]);
        return $query->row();
    }

	function get_wallet_history($user_id)
	{
		$this->db->select('bwh.previous_amount,bwh.current_amount,bw.balance, bwh.amount,bwh.transaction_type, bwh.against, bwh.referrence, bwh.remark, DATE_FORMAT(bwh.created, "%d %M %Y %H:%i:%s") createddate');
		$this->db->from('buyer_wallet bw');
                $this->db->join('buyer_wallet_history bwh','bw.user_id = bwh.buyer_id');
                $this->db->where('bw.user_id',$user_id);
		$this->db->order_by('bwh.id','desc');
		return $this->db->get()->result_array();
	}
	
    function add_wallet_history($data)
    {
            $this->db->insert("buyer_wallet_history",$data);
        return $this->db->insert_id();
    }
   public function get_datatables_for_wallet() {
        $this->_get_datatables__for_wallet();

        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);

        $query = $this->db->get();

        return $query->result();
    }
	
	 public function count_all() {
        $this->db->from('buyer_wallet');
        return $this->db->count_all_results();
    }

    public function count_filtered_for_user() {
        $this->_get_datatables__for_wallet();

        $query = $this->db->get();

        return $query->num_rows();
    }

    private function _get_datatables__for_wallet() {

        $this->_column_search_for_user = array("first_name", "last_name", "phone", "balance");

        $this->db
                ->select("user_id, first_name, last_name, phone, balance")
                ->from('buyer_wallet bw')
				->join('users u', " bw.user_id = u.id","left");

        $i = 0;
        foreach ($this->_column_search_for_user as $item) {
            if ($_POST['search']['value']) {

                if ($i === 0) {
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->db->like($item, $_POST['search']['value']);
                } else {
                    $this->db->or_like($item, $_POST['search']['value']);
                }

                if (count($this->_column_search_for_user) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }

        if (isset($_POST['order'])) {
			if($_POST['order']['0']['dir'] == "asc")
			{
				$ordr = "desc";
			}else{
				$ordr = "asc";
			}
            $this->db->order_by($this->_column_order[$_POST['order']['0']['column']], $ordr);
        } elseif (isset($this->_order)) {
            $order = $this->_order;
            $this->db->order_by(key($order), $order[key($order)]);
        }else{
            $this->db->where('id','desc');
        }
        
    }
	
	
	 public function get_datatables_for_walletHistory($user_id) {
        $this->_get_datatables_for_walletHistory($user_id);

        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);

        $query = $this->db->get();

        return $query->result();
    }
	
	 public function count_allHistory($user_id) {
		$this->db->where('buyer_id',$user_id);
        $this->db->from('buyer_wallet_history');
        return $this->db->count_all_results();
    }

    public function count_filtered_history() {
        $this->_get_datatables_for_walletHistory($user_id);

        $query = $this->db->get();

        return $query->num_rows();
    }

    private function _get_datatables_for_walletHistory($user_id) {

        $this->_column_search_for_user = array("first_name", "last_name", "amount", "transaction_type","against","referrence","remark","created");

        $this->db
                ->select("first_name, last_name, amount, transaction_type, against, referrence, remark, created")
                ->from('buyer_wallet_history bw')
				->join('users u', " bw.buyer_id = u.id","left")
				->where('buyer_id',$user_id);

        $i = 0;
        foreach ($this->_column_search_for_user as $item) {
            if ($_POST['search']['value']) {

                if ($i === 0) {
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->db->like($item, $_POST['search']['value']);
                } else {
                    $this->db->or_like($item, $_POST['search']['value']);
                }

                if (count($this->_column_search_for_user) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }

        if (isset($_POST['order'])) {
			if($_POST['order']['0']['dir'] == "asc")
			{
				$ordr = "desc";
			}else{
				$ordr = "asc";
			}
            $this->db->order_by($this->_column_order[$_POST['order']['0']['column']], $ordr);
        } elseif (isset($this->_order)) {
            $order = $this->_order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }
	
	
	public function get_datatables_for_wallet_request($from, $to) {
        $this->_get_datatables_for_wallet_request($from, $to);

        if ($_POST['length'] != -1)
           $this->db->limit($_POST['length'], $_POST['start']);
		
        $query = $this->db->get();
        return $query->result();
    }
	
	 public function count_all_request() {
        $this->db->from('buyer_withdraw_request');
        return $this->db->count_all_results();
    }

    public function count_filtered_for_buyer_request($from, $to) {
        $this->_get_datatables_for_wallet_request($from, $to);

        $query = $this->db->get();

        return $query->num_rows();
    }

    private function _get_datatables_for_wallet_request($from, $to) {

        $this->_column_search_for_user = array("first_name", "last_name", "created_at", "amount");

        $this->db
                ->select("admin_firstname, bw.id as request_id,first_name, last_name, amount, bw.status, created_at, updated_at, bw.user_id")
                ->from('buyer_withdraw_request bw')
		->join('users u', " bw.user_id = u.id","left")
                ->join('admin ad', 'ad.admin_id=bw.approved_by', 'left');
		
	
		if ($from != '' && $to != '') { // To process our custom input parameter
            $this->db->where('date_format(bw.created_at,"%Y-%m-%d") BETWEEN "' . date('Y-m-d', strtotime($from)) . '" and "' . date('Y-m-d', strtotime($to)) . '"');
           // $this->db->order_by('id','d');
        }
		
        $i = 0;
        foreach ($this->_column_search_for_user as $item) {
            if ($_POST['search']['value']) {

                if ($i === 0) {
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->db->like($item, $_POST['search']['value']);
                } else {
                    $this->db->or_like($item, $_POST['search']['value']);
                }

                if (count($this->_column_search_for_user) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }

        if (isset($_POST['order'])) {
			if($_POST['order']['0']['dir'] == "asc")
			{
				$ordr = "desc";
			}else{
				$ordr = "desc";
			}
            $this->db->order_by($this->_column_order[$_POST['order']['0']['column']], $ordr);
        } elseif (isset($this->_order)) {
            $order = $this->_order;
            $this->db->order_by(key($order), $order[key($order)]);
            
        }else{
            $this->db->order_by('bw.id','desc');
        }

    }
	
	function approve_wallet($id,$arr)
	{
		$this->db->where('id',$id);
		return $this->db->update('buyer_withdraw_request',$arr);
	}
	
	function reject_wallet($id,$arr)
	{
		$this->db->where('id',$id);
		return $this->db->update('buyer_withdraw_request',$arr);
	}
	
	function compare_wallet_amount($buyer_id)
	{
		$this->db->select('id,balance');
		$this->db->where('user_id',$buyer_id);
		return $this->db->get('buyer_wallet')->row();
	}
	
	function update_wallet_amount($id, $final_amount)
	{
		$this->db->where('id',$id);
		$this->db->set('balance',$final_amount);
		return $this->db->update('buyer_wallet');
	}

	function excel_data($from,$to)
	{
		 $this->db->select("first_name, last_name, amount, email, phone, bw.created_at, bw.updated_at, acc_no, bank_name, ifsc_code, acc_holder_name");
         $this->db->from('buyer_withdraw_request bw');
		 $this->db->join('users u', " bw.user_id = u.id","left");
		 $this->db->join('buyer_bank_details b', " bw.user_id = b.user_id");
		 $this->db->where('date_format(bw.created_at,"%Y-%m-%d") BETWEEN "' . date('Y-m-d', strtotime($from)) . '" and "' . date('Y-m-d', strtotime($to)) . '"');
		 $this->db->where('bw.status','Approve');
		 return $this->db->get()->result_array();

    }
    
    public function getWalletBalance($user_id)
    {
        $query = $this->db->select("balance")
                ->from('buyer_wallet')
                ->where('user_id', $user_id)->get();
        $balance = $query->result_array()[0]['balance'];
        return $balance?$balance:'00';
    }
    
    function get_wallet_request($user_id,$limit=0)
    {
        $this->db->select('*');
        $this->db->from('buyer_withdraw_request');
        $this->db->where('user_id',$user_id);
        $this->db->order_by('id','desc');
        if(!empty($limit)){
          $this->db->limit($limit);
        }
        $query=$this->db->get();
        return $query->result_array();
    }
    
    
}