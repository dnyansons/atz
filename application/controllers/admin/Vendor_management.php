<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Vendor_management extends CI_Controller 
{
    public function __construct() 
    {
        parent::__construct();
        if(! $this->session->userdata("admin_logged_in")){
            $error = "<div class='alert alert-danger alert-dismissible'>
                        <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                        <strong>Error!</strong> Session timeout, relogin!.
                      </div>";
            $this->session->set_flashdata("message",$error);
            redirect("admin/login","refresh");
        }
		 $this->load->library('Userpermission');
	
    }
    
    public function approved_vendors()
    {
        $data = array();
        $this->load->view("admin/vendor_management/approved_vendors", $data);
    }
    
    public function ajax_get_appoved_vendors()
    {
        $columns = array(
            0 => 'id',
            1 => 'name',
            2 => 'email',
            3 => 'mobile',
            4 => 'product_type',
            5 => 'no_of_sales',
            6 => 'wallet_balance'
        );

        $limit = $this->input->post('length');
        $start = $this->input->post('start');
        $order = $columns[$this->input->post('order')[0]['column']];
        //$dir = $this->input->post('order')[0]['dir'];
        $dir ="desc";

        $totalData = $this->Common_model->select('count(id)','users',['approved_status'=>'Approved','role'=>'seller'])[0]['count_id'];

        $totalFiltered = $totalData;
		
        if (empty($this->input->post('search')['value'])) {
            $list = $this->Common_model->select('u.*,wv.available_balance,sum(pr.sales)','users u',['u.approved_status'=>'Approved','u.role'=>'seller'],array(1=>array('colname'=>$order,'type'=>'DESC')),$limit,$start,
                                                array(1=>array('tableName'=>'wallet_vendor wv','columnNames'=>'u.id = wv.vendor_id','jType'=>'left'),
                                                      2=>array('tableName'=>'product_details pd','columnNames'=>'u.id = pd.seller','jType'=>'left'),
                                                      3=>array('tableName'=>'product_review pr','columnNames'=>'pr.product_id = pd.id','jType'=>'left')));
           
        } else {
            $search = $this->input->post('search')['value'];
			
            $list = $this->approve_vendor_search($limit, $start, $search, $order, $dir);
			
            $totalFiltered = $this->approve_vendor_search_count($search);
        }

		
        $data = array();
        if (!empty($list)) {
            foreach ($list as $row) {
                $nestedData['id'] = '<a class="badge badge-info" href="'. site_url('admin/seller/profile/').$row['id'].'"> ATZ'.$row['id'].'</a>';
                $nestedData['name'] = $row['first_name'].' '.$row['last_name'];
                $nestedData['email'] = $row['email'];
                $nestedData['mobile'] = $row['phone'];
                $nestedData['product_type'] = '';
                $nestedData['no_of_sales'] = $row['sum(pr.sales)'];
                $nestedData['wallet_balance'] = $row['available_balance'];

                $data[] = $nestedData;
            }
        }

        $json_data = array(
            "draw" => intval($this->input->post('draw')),
            "recordsTotal" => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data" => $data
        );

        echo json_encode($json_data);
    }
    
    public function approve_vendor_search_count($search)
    {
        $query = $this
        ->db
        ->like('u.id', str_replace('ATZ', '', $search))
        ->like('u.first_name',$search)
        ->or_like('u.last_name',$search)
        ->or_like('u.email',$search)
        ->or_like('u.phone',$search)
        ->where(['u.approved_status'=>'Approved','u.role'=>'seller'])
        ->join('wallet_vendor wv','u.id = wv.vendor_id','left')
        ->join('product_details pd','u.id = pd.seller','left')
        ->join('product_review pr','pr.product_id = pd.id','left')
        ->get("users u");
    
        return $query->num_rows();
    }
	
    function approve_vendor_search($limit,$start,$search,$col,$dir)
    {
        $query = $this
                ->db
                ->select('u.*,wv.available_balance,sum(pr.sales)')
                ->like('u.id', str_replace('ATZ', '', $search))
                ->or_like('u.first_name',$search)
                ->or_like('u.last_name',$search)  
                ->or_like('u.email',$search)    
		->or_like('u.phone',$search)
                ->where(['u.approved_status'=>'Approved','u.role'=>'seller'])
                ->join('wallet_vendor wv','u.id = wv.vendor_id','left')
                ->join('product_details pd','u.id = pd.seller','left')
                ->join('product_review pr','pr.product_id = pd.id','left')
                ->limit($limit,$start)
                ->order_by('u.'.$col,$dir)
                ->get("users u");
        
        if($query->num_rows() > 0)
        {
            return $query->result_array();  
        }
        else
        {
            return null;
        }
    }
    
    public function pending_approval_vendors()
    {
        $data = array();
        $this->load->view("admin/vendor_management/pending_approval_vendors", $data);
    }
    
    public function ajax_pending_approval_vendors()
    {
        $columns = array(
            0 => 'id',
            1 => 'name',
            2 => 'email',
            3 => 'mobile',
            4 => 'action'
        );

        $limit = $this->input->post('length');
        $start = $this->input->post('start');
        $order = $columns[$this->input->post('order')[0]['column']];
        $dir = "desc";

//        $totalData = $this->Common_model->select('count(id)','users',['approved_status'=>'Pending','role'=>'seller'])[0]['count_id'];
        
         $totalData = $this->pending_approval_vendors_all_count();
         $totalFiltered = $this->pending_approval_vendorfiltered_count();
		
        if (empty($this->input->post('search')['value'])) {
            $list = $this->Common_model->select('*','users u',['approved_status'=>'Pending','role'=>'seller','status'=>'1'],array(1=>array('colname'=>$order,'type'=>'DESC')),$limit,$start);

        } else {
            $search = $this->input->post('search')['value'];
			
            $list = $this->pending_approval_vendors_search($limit, $start, $search, $order, $dir);
			
            $totalFiltered = $this->pending_approval_vendors_search_count($search);
        }
        $data = array();
        if (!empty($list)) {
            foreach ($list as $row) {
                $nestedData['id'] = '<a class="badge badge-info" target="_blank" href="'. site_url('admin/seller/profile/').$row['id'].'"> ATZ'.$row['id'].'</a>';
                $nestedData['name'] = $row['first_name'].' '.$row['last_name'];
                $nestedData['email'] = $row['email'];
                $nestedData['mobile'] = $row['phone'];
                $nestedData['action'] = '<a href="'.base_url('admin/vendor_management/approve_vendor/'.$row['id']).'" class="btn btn-success">Approve</a>';
                $data[] = $nestedData;
            }
        }

        $json_data = array(
            "draw" => intval($this->input->post('draw')),
            "recordsTotal" => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data" => $data
        );

        echo json_encode($json_data);
    }
    
    public function pending_approval_vendors_search_count($search)
    {
        $query = $this
        ->db
        ->like('id', str_replace('ATZ', '', $search))
        ->like('first_name',$search)
        ->or_like('last_name',$search)
        ->or_like('email',$search)
        ->or_like('phone',$search)
        ->where(['approved_status'=>'Pending','role'=>'seller','status'=>'1'])
        ->get("users");
    
        return $query->num_rows();
    }
    
    public function pending_approval_vendors_all_count()
    {
        $query = $this
        ->db
        ->get("users");
        return $query->num_rows();
    }
    
    public function pending_approval_vendorfiltered_count()
    {
        $query = $this
        ->db
        ->where(['approved_status'=>'Pending','role'=>'seller','status'=>'1'])
        ->get("users");
        return $query->num_rows();
    }
   
	
    function pending_approval_vendors_search($limit,$start,$search,$col,$dir)
    {
        $query = $this
                ->db
                ->select('*')
                ->where(['approved_status'=>'Pending','role'=>'seller','status'=>'1'])
                ->group_start()
                ->like('id', str_replace('ATZ', '', $search))
                ->or_like('first_name',$search)
                ->or_like('last_name',$search)  
                ->or_like('email',$search)    
		->or_like('phone',$search)
                ->group_end()
                ->limit($limit,$start)
                ->order_by('u.'.$col,$dir)
                ->get("users u");
        
        if($query->num_rows() > 0)
        {
            return $query->result_array();  
        }
        else
        {
            return null;
        }
    }
    
    function approve_vendor($id)
    {
        if (!empty($id)){
            $this->Common_model->update('users',['approved_status'=>'Approved'],['id'=>$id]);
            $walletData = [
                "vendor_id" => $id,
                "available_balance" => 0,
                "pending_balance" => 0,
                "hold_balance" => 0,
                "settled_balance" => 0,
            ];
            $this->Common_model->insert("wallet_vendor",$walletData);
            $success = "<div class='alert alert-success alert-dismissible'>
                        <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                        <strong>Success!</strong> Vendor Approved Successfully.
                      </div>";
            $this->session->set_flashdata("message",$success);
                
            redirect("admin/vendor_management/pending_approval_vendors","refresh");
        }
    }
    
    public function rejected_vendors()
    {
        $data = array();
        $this->load->view("admin/vendor_management/rejected_vendors", $data);
    }
    
    public function ajax_rejected_vendors()
    {
        $columns = array(
            0 => 'id',
            1 => 'name',
            2 => 'email',
            3 => 'mobile'
        );

        $limit = $this->input->post('length');
        $start = $this->input->post('start');
        $order = $columns[$this->input->post('order')[0]['column']];
        //$dir = $this->input->post('order')[0]['dir'];
        $dir = "desc";

        $totalData = $this->Common_model->select('count(id)','users',['approved_status'=>'Reject','role'=>'seller'])[0]['count_id'];

        $totalFiltered = $totalData;
		
        if (empty($this->input->post('search')['value'])) {
            $list = $this->Common_model->select('*','users u',['approved_status'=>'Reject','role'=>'seller'],array(1=>array('colname'=>$order,'type'=>'DESC')),$limit,$start);
           
        } else {
            $search = $this->input->post('search')['value'];
			
            $list = $this->rejected_vendors_search($limit, $start, $search, $order, $dir);
			
            $totalFiltered = $this->rejected_vendors_search_count($search);
        }
		
        $data = array();
        if (!empty($list)) {
            foreach ($list as $row) {
                $nestedData['id'] = 'ATZ'.$row['id'];
                $nestedData['name'] = $row['first_name'].' '.$row['last_name'];
                $nestedData['email'] = $row['email'];
                $nestedData['mobile'] = $row['phone'];
                $data[] = $nestedData;
            }
        }

        $json_data = array(
            "draw" => intval($this->input->post('draw')),
            "recordsTotal" => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data" => $data
        );

        echo json_encode($json_data);
    }
    
    public function rejected_vendors_search_count($search)
    {
        $query = $this
        ->db
        ->like('id', str_replace('ATZ', '', $search))
        ->like('first_name',$search)
        ->or_like('last_name',$search)
        ->or_like('email',$search)
        ->or_like('phone',$search)
        ->where(['approved_status'=>'Reject','role'=>'seller'])
        ->get("users");
    
        return $query->num_rows();
    }
	
    function rejected_vendors_search($limit,$start,$search,$col,$dir)
    {
        $query = $this
                ->db
                ->select('*')
                ->like('id', str_replace('ATZ', '', $search))
                ->or_like('first_name',$search)
                ->or_like('last_name',$search)  
                ->or_like('email',$search)    
		->or_like('phone',$search)
                ->where(['approved_status'=>'Reject','role'=>'seller'])
                ->limit($limit,$start)
                ->order_by('u.'.$col,$dir)
                ->get("users u");
        
        if($query->num_rows() > 0)
        {
            return $query->result_array();  
        }
        else
        {
            return null;
        }
    }
	
    public function active_agents()
    {

    }
    
    public function updateProfile($id = 0)
    {
        if($id){
            $this->form_validation->set_rules("email","Email","required");
            $this->form_validation->set_rules("mobile","mobile","required");
            if($this->form_validation->run()===false){
                $this->load->view();
            } else {
                echo "<pre>";
                print_r($_POST);
            }
        } else {
            
        }
    }
       
}