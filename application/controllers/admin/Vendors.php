<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Vendors extends CI_Controller
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
        $this->load->model('Users_model');
        $this->load->model('Wallet_model');
        $this->load->model('Order_model');
    }
    
    public function index()
    {
        $this->Users_model->read_seller_notification();
        $data["pageTitle"] = "Active Vendors";
        $data["status"] = "Approved";
        $this->load->view("admin/vendor_management/list",$data);
    }
    
    public function pending()
    {
        $data["pageTitle"] = "Inactive/Banned Vendors";
        $this->load->view("admin/vendor_management/bannedVendors",$data);
    }
    
    public function rejected()
    {
        $data["pageTitle"] = "Rejected Vendors";
        $data["status"] = "Rejected";
        $this->load->view("admin/vendor_management/list",$data);
    }
    
    public function ajax_list()
    {
        $active_status = $this->input->post('status');
        
        $users = $this->Users_model->get_datatablesVendors($active_status);
        $data = array();
        $no = $this->input->post('start');
        foreach ($users as $user) {
            if ($user->status == 1) {
                $status = '<a href="javascript:void(0);" style="color:green;font-weight:bold;"  data-toggle="modal" data-target="#active_inactive_modal" data-user_id="'.$user->id.'" data-status="'.$user->status.'">Active</a>';
            } else {
                $status = '<a href="javascript:void(0);" style="color:red;font-weight:bold;"  data-toggle="modal" data-target="#active_inactive_modal" data-user_id="'.$user->id.'" data-status="'.$user->status.'">Inactitve</a>';
            }
            $no++;
            $details = array();
            $details[] = '<a class="badge badge-info" href="'. site_url('admin/seller/profile/').$user->id.'"> ATZ'.$user->id.'</a>';
			$details[] = $user->created_on;
            $details[] = $user->first_name . ' ' . $user->last_name;
            $details[] = $user->email;
            $details[] = $user->phone;
            $details[] = $user->company_name;
            $details[] = $user->preferred_category;
            if($user->total_orders){
                $details[] =$user->total_orders;
            } else {
                $details[] = "0";
            }

            if(trim($user->status) == 0) {
                //show remove / unban user modal data
                $ban_page_text = "<div class='form-group'>Username : ".
                                $user->first_name . ' ' . $user->last_name.'</div>';
                $ban_page_text .= "<div class='form-group'><label for='comment'><b>Banning Reason : </b></label> ".
                                $user->ban_comment."
                                <input type='hidden' id='ban_id' value='".$user->id."'></div>";
                $ban_details = '<a data-toggle="modal" data-id="'.$ban_page_text.'" data-target="#unBanModal" class="dropdown-item open-unban-events" ><i class="fa fa-ban"></i>Ban User</a>';
            } else {
                //show ban user modal data
                $ban_page_text = "<div class='form-group'>Username : ".
                                $user->first_name . ' ' . $user->last_name.'</div>';
                $ban_page_text .= "<div class='form-group'><label for='comment'><b>Banning Reason</b></label>".
                                "<textarea required class='form-control' name='ban_comment' id='ban_comment'></textarea>
                                <input type='hidden' id='ban_id' value='".$user->id."'>
                                </div>";
                $ban_details = '<a data-toggle="modal" data-id="'.$ban_page_text.'" data-target="#banModal" class="dropdown-item open-ban-events" ><i class="fa fa-ban"></i>Ban User</a>';                
            }

            //$details[] = date("d-m-Y", strtotime($user->created_on));
            $details[] = '<button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-cog" aria-hidden="true"></i></button>
			<div class="dropdown-menu dropdown-menu-right b-none contact-menu" style="width:55px;">
				<a class="dropdown-item" href="' . site_url() . 'admin/vendors/vendorsOrderview/' . $user->id . '"><i class="fa fa-eye"></i>view Profile</a>
                <a class="dropdown-item" href="' . site_url() . 'admin/vendors/vendorsOrderview/' . $user->id . '"><i class="fa fa-edit"></i>Orders</a>'
                .$ban_details.'</div>';
                
            if($active_status == "Pending"){
                $details[7] = $details[7].'<a href="'.base_url('admin/vendors/approve/'.$user->id).'" class="dropdown-item"><i class="fa fa-check"></i>Approve</a>';
            }
            $details[7] = $details[7]."</div>";

            $data[] = $details;
        }
	
        $output = array(
            "draw" => $this->input->post('draw'),
            "recordsTotal" => $this->Users_model->count_all_vendors($active_status),
            "recordsFiltered" => $this->Users_model->count_filtered_vendors($active_status),
            "data" => $data,
        );
        echo json_encode($output);
    }
    
    
    public function getBannedVendors()
    {
        $users = $this->Users_model->getBannedVendorstable();
        $data = array();
        $no = $this->input->post('start');
        foreach ($users as $user) {
            
            $no++;
            $details = array();
            $details[] = '<a class="badge badge-info" href="'. site_url('admin/seller/profile/').$user->id.'"> ATZ'.$user->id.'</a>';
            $details[] = $user->created_on;
            $details[] = $user->first_name . ' ' . $user->last_name;
            $details[] = $user->email;
            $details[] = $user->phone;
            $details[] = $user->company_name;
            $details[] = $user->ban_comment;
            
                $ban_page_text = "<div class='form-group'>Username : ".
                                $user->first_name . ' ' . $user->last_name.'</div>';
                $ban_page_text .= "<div class='form-group'><label for='comment'><b>Banning Reason : </b></label> ".
                                $user->ban_comment."
                                <input type='hidden' id='ban_id' value='".$user->id."'></div>";
                $ban_details = '<a data-toggle="modal" data-id="'.$ban_page_text.'" data-target="#unBanModal" class="dropdown-item open-unban-events" ><i class="fa fa-ban"></i>Remove Banned</a>';
                
            $details[] = '<button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-cog" aria-hidden="true"></i></button>
			<div class="dropdown-menu dropdown-menu-right b-none contact-menu" style="width:55px; cursor:pointer">'.$ban_details.'</div>';
            $data[] = $details;
        }
	
        $output = array(
            "draw" => $this->input->post('draw'),
            "recordsTotal" => $this->Users_model->count_banned_vendors(),
            "recordsFiltered" => $this->Users_model->count_filtered_bannedvendors(),
            "data" => $data,
        );
        echo json_encode($output);
    }
    
    public function approve($id)
    {
        $userWallet = $this->Wallet_model->getWallerBySellerId($id);
        if (!empty($id) && !$userWallet){
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
                
            redirect("admin/vendors","refresh");
        } else {
            $success = "<div class='alert alert-danger alert-dismissible'>
                        <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                        <strong>Error!</strong> Please select valid vendor.
                      </div>";
            $this->session->set_flashdata("message",$success);
            redirect("admin/vendors/pending","refresh");
        }
    }
    
    function download_excel($fileName) {
       $this->load->model('Download_excel_model');
       switch($fileName){
           case 'active_vendors' :{
               $redirect = "vendors";//redirect to show iff no data found error
               $dataRows = $this->db->select('CONCAT(first_name," ",last_name) as vname, phone, company_name, legal_owner, gst_no, pan_no, bank_name, account_no, ifsc_code, approved_status, admin_firstname as admin_approved_by,  year_of_register, SP.pkg_name, UP.start_date, UP.end_date, CONCAT(SPA.address, " Pincode: ", SPA.pincode, " ", SPA.state, " ",  SPA.country) as pick_address, (select count(O.orders_id) FROM orders O where O.seller_id = U.id ) sell_count, U.created_on as registered_date')
                                ->from('users U')
                                ->join('seller_company_details SCD', ' U.id = SCD.user_id', 'LEFT')
                                ->join('user_packages UP', 'UP.user_id = U.id ', 'LEFT')
                                ->join('subscription_package SP', 'SP.sub_id=UP.pkg_id', 'LEFT')
                                ->join('supplier_bank_details SBD', 'SBD.user_id=U.id AND SBD.is_default = 1', 'LEFT')
                                ->join('banks B', 'B.id=SBD.bank', 'LEFT')
                                ->join('seller_pick_address SPA', 'SPA.user_id=U.id', 'LEFT')
                                ->join('admin AD', 'AD.admin_id = U.approved_by', 'LEFT')
                                ->where(array('U.status' => '1',  'U.role' => 'seller', 'approved_status' => 'Approved'))
                                ->order_by('U.id', 'DESC')
                                ->get()->result_array();
               
               $excelColumnNames = array('Vendor Name', 'Vendor Mobile', 'Company Name', 'Vendor Legal Owner', 'gst no', 'pan no', 'Bank', 'Acoount No', 'IFSC', 'approved status', 'Approved By Admin', 'Registration Year', 'Membership Package', 'Package Start Date', 'Package End Date', 'Pick Up Address', 'Sell Count','Registered Date');
               $this->Download_excel_model->download($fileName, 'Active Vendors', $excelColumnNames,
                       $dataRows,$redirect);
               break;
           }
           //for pending or incative vendors
           case 'inactive' :{
               $redirect = "vendors/pending/";//redirect to show iff no data found error
               $fileName = 'pending_vendors';
               $dataRows = $this->db->select('CONCAT(first_name," ",last_name) as vname, phone, company_name, legal_owner, gst_no, pan_no, bank_name, account_no, ifsc_code, approved_status, admin_firstname as admin_approved_by,  year_of_register, SP.pkg_name, UP.start_date, UP.end_date, CONCAT(SPA.address, " Pincode: ", SPA.pincode, " ", SPA.state, " ",  SPA.country) as pick_address, (select count(O.orders_id) FROM orders O where O.seller_id = U.id ) sell_count, U.created_on as registered_date')
                                ->from('users U')
                                ->join('seller_company_details SCD', ' U.id = SCD.user_id', 'LEFT')
                                ->join('user_packages UP', 'UP.user_id = U.id ', 'LEFT')
                                ->join('subscription_package SP', 'SP.sub_id=UP.pkg_id', 'LEFT')
                                ->join('supplier_bank_details SBD', 'SBD.user_id=U.id AND SBD.is_default = 1', 'LEFT')
                                ->join('banks B', 'B.id=SBD.bank', 'LEFT')
                                ->join('seller_pick_address SPA', 'SPA.user_id=U.id', 'LEFT')
                                ->join('admin AD', 'AD.admin_id = U.approved_by', 'LEFT')
                                ->where(array('U.status' => '1',  'role' => 'seller', 'approved_status' => 'Pending'))
                                ->order_by('U.id', 'DESC')
                                ->get()->result_array();
               
               $excelColumnNames = array('Vendor Name','Vendor Mobile', 'Company Name', 'Vendor Legal Owner', 'gst no', 'pan no', 'Bank', 'Acoount No', 'IFSC', 'approved status', 'Approved By Admin', 'Registration Year', 'Membership Package', 'Package Start Date', 'Package End Date', 'Pick Up Address', 'Sell Count', 'Registered Date');
               $this->Download_excel_model->download($fileName, 'Inactive Pending Vendors', $excelColumnNames,
                       $dataRows,$redirect);
               break;
           }
           
           case 'inactive_banned_vendors' :{
               $redirect = "vendors/pending/";//redirect to show iff no data found error
               $fileName = 'Banned vendors';
               $dataRows = $this->db->select('CONCAT(first_name," ",last_name) as vname, phone, email, company_name,U.created_on as registered_date, U.ban_comment')
                                ->from('users U')
                                ->join('seller_company_details SCD', ' U.id = SCD.user_id', 'LEFT')
                                ->where(array('U.status' => '0',  'role' => 'seller'))
                                ->order_by('U.id', 'DESC')
                                ->get()->result_array();
               
               $excelColumnNames = array('Vendor Name','Vendor Mobile', 'Email','Company Name', 'Registered Date','Banned Comment');
               $this->Download_excel_model->download($fileName, 'Inactive OR Banned Vendors', $excelColumnNames,
                       $dataRows,$redirect);
               break;
           }
       }
    }
    
    function vendorsOrderview($user_id = 0) {
        $data['user'] = $this->Common_model->getAll('users', array('id' => $user_id))->row_array();
        if (!empty($data['user'])) {
            $data['user_id'] = $user_id;
            $this->load->view('admin/order/buyer/allSellerOrder', $data);
        } else {
            redirect("admin/vendors", "refresh");
        }
    }
    
    public function seller_ajax_list($user_id) {
        $columns = array(
            0 => 'orders_id',
            1 => 'user_name',
            2 => 'orders_status_name',
            3 => 'order_price',
            4 => 'date_purchased',
        );

        $limit = $this->input->post('length');
        $start = $this->input->post('start');
        $order = $columns[$this->input->post('order')[0]['column']];
        $dir = $this->input->post('order')[0]['dir'];
        
         $totalData = $this->Order_model->seller_all_order_count($user_id);

        $totalFiltered = $totalData;
        
        if (empty($this->input->post('search')['value'])) {
            $allorder = $this->Order_model->seller_allorder($user_id, $limit, $start, $dir);
        } else {
            $search = $this->input->post('search')['value'];
            $allorder = $this->Order_model->seller_order_search($user_id, $limit, $start, $search, $dir);
            $totalFiltered= $this->Order_model->seller_order_search_count($user_id, $limit, $start,$search, $dir);
        }

        $data = array();
        if (!empty($allorder)) {
            //echo'<pre>';
            //print_r($allorder);
            foreach ($allorder as $br) {
                $nestedData['orders_id'] = $br->orders_id;
                $nestedData['user_name'] = $br->user_name;
                $nestedData['orders_status_name'] = $br->orders_status_name;
                $nestedData['order_price'] = $br->order_price;
                $nestedData['date_purchased'] = $br->date_purchased;
                $nestedData['action'] = '<a type="button" href="' . base_url() . 'admin/order/view/' . $br->orders_id . '" class="btn btn-warning btn-sm">View&nbsp;Detail</a>';

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
    
    public function show() {
       
         $from = $this->input->post('dateFrom');
         $to = $this->input->post('dateTo');
        $data["pageTitle"] = "Active Vendors";
     
        $users = $this->Users_model->get_datatablesUsers($active_status,$from,$to);
        //$data['total_orders'] = $this->Order_model->get_allOrders();

         $no = $this->input->post('start');
      
         if($users)
         {
             foreach ($users as $user) {
                 
            if ($user->status == 1) {
                $status = '<a href="javascript:void(0);" style="color:green;font-weight:bold;"  data-toggle="modal" data-target="#active_inactive_modal" data-user_id="'.$user->id.'" data-status="'.$user->status.'">Active</a>';
            } else {
                $status = '<a href="javascript:void(0);" style="color:red;font-weight:bold;"  data-toggle="modal" data-target="#active_inactive_modal" data-user_id="'.$user->id.'" data-status="'.$user->status.'">Inactitve</a>';
            }

            $no++;
            $details = array();
            $details[] = '<a class="badge badge-info" href="'. site_url('admin/seller/profile/').$user->id.'"> ATZ'.$user->id.'</a>';
            $details[] = $user->created_on;
            $details[] = $user->email;
            $details[] = '<a  class="badge badge-success" href="' . base_url('admin/users/view_history') . '/' . $user->role . '/' . $user->id . '" >' . $user->balance . ' </a>';
            $details[] = $user->phone;
            if ($user->total_orders) {
                $details[] = "<a href='".site_url()."admin/users/user_order/".$user->id."' class='btn btn-info'>".$user->total_orders."</a>";
            } else {
                $details[] = "0";
            }

            if (trim($user->status) == 0) {
                //show remove / unban user modal data
                $ban_page_text = "<div class='form-group'>Username : " .
                        $user->first_name . ' ' . $user->last_name . '</div>';
                $ban_page_text .= "<div class='form-group'><label for='comment'><b>Banning Reason : </b></label> " .
                        $user->ban_comment . "
                                <input type='hidden' id='ban_id' value='" . $user->id . "'></div>";
                $ban_details = '<a data-toggle="modal" data-id="' . $ban_page_text . '" data-target="#unBanModal" class="dropdown-item open-unban-events" ><i class="fa fa-ban"></i>Ban User</a>';
            } else {
                //show ban user modal data
                $ban_page_text = "<div class='form-group'>Username : " .
                        $user->first_name . ' ' . $user->last_name . '</div>';
                $ban_page_text .= "<div class='form-group'><label for='comment'><b>Banning Reason</b></label>" .
                        "<textarea required class='form-control' name='ban_comment' id='ban_comment'></textarea>
                                <input type='hidden' id='ban_id' value='" . $user->id . "'>
                                </div>";
                $ban_details = '<a data-toggle="modal" data-id="' . $ban_page_text . '" data-target="#banModal" class="dropdown-item open-ban-events" ><i class="fa fa-ban"></i>Ban User</a>';
            }

                $details[] = date("d-m-Y h:i:s", strtotime($user->created_on));
                $details[] = '<button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-cog" aria-hidden="true"></i></button>
                            <div class="dropdown-menu dropdown-menu-right b-none contact-menu" style="width:55px;">
                                    <a class="dropdown-item" href="' . site_url() . 'admin/users/user_view/' . $user->id . '"><i class="fa fa-eye"></i>view Profile</a>
                    <a class="dropdown-item" href="' . site_url() . 'admin/users/user_order/' . $user->id . '"><i class="fa fa-edit"></i>Orders</a>
                    ' . $ban_details . '</div>';

                $data[] = $details;
            }
        }
        else
        {
            $error = "<div class='alert alert-danger alert-dismissible'>
                        <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                        <strong>Error!</strong> No Records Found.!.
                      </div>";
                $this->session->set_flashdata("message", $error);
                redirect("admin/vendors", "refresh");
        }
        
          //$this->load->view("admin/vendor_management/list",$data);
       $output = array(
            "draw" => $this->input->post('draw'),
            "recordsTotal" => $this->Users_model->count_all_vendors($active_status),
            "recordsFiltered" => $this->Users_model->count_filtered_vendors($active_status),
            "data" => $data,
        );
        echo json_encode($output);  
      
    }

}