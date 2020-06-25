<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Notifications extends CI_Controller 
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
                 $this->load->library('upload');
                 $this->load->library('awsupload');
	
    }
    
    public function index()
    {
        $data = array();
        $this->load->view("admin/notifications/index", $data);
    }
    
    public function ajax_get_admin_notifications()
    {
        $columns = array(
            0 => 'id',
            1 => 'title',
            2 => 'msg',
            3 => 'type',
            4 => 'send_date_time',
            5 => 'date_created'
        );

        $limit = $this->input->post('length');
        $start = $this->input->post('start');
        $order = $columns[$this->input->post('order')[0]['column']];
        //$dir = $this->input->post('order')[0]['dir'];
        $dir ="desc";

        $totalData = $this->Common_model->select('count(id)','promotional_notifications')[0]['count_id'];

        $totalFiltered = $totalData;
		
        if (empty($this->input->post('search')['value'])) {
            $list = $this->Common_model->select('*','promotional_notifications','',array(1=>array('colname'=>$order,'type'=>'DESC')),$limit,$start);
           
        } else {
            $search = $this->input->post('search')['value'];
			
            $list = $this->admin_notification_search($limit, $start, $search, $order, $dir);
			
            $totalFiltered = $this->admin_notification_search_count($search);
        }
		
        $data = array();
        if (!empty($list)) {
            foreach ($list as $row) {
                $nestedData['id'] = $row['id'];
                $nestedData['title'] = $row['title'];
                $nestedData['msg'] = $row['msg'];
                $nestedData['type'] = $row['type'];
                $nestedData['send_date_time'] = $row['send_date_time'];
                $nestedData['date_created'] = $row['date_created'];
                $nestedData['action'] = '<a href="'.base_url().'admin/notifications/view/'.$row['id'].'" class="tabledit-delete-button btn btn-success waves-effect waves-light btn-sm" data-toggle="tooltip" data-placement="top" title="View" data-original-title="Delete"><i class="fa fa-eye"></i></a>
                                         <a href="'.base_url().'admin/notifications/delete/'.$row['id'].'" class="tabledit-delete-button btn btn-danger waves-effect waves-light btn-sm" data-toggle="tooltip" data-placement="top" title="Delete" data-original-title="Delete" onclick="if (!confirm(\'Are you sure you want to delete this record?\')) return false;"><i class="fa fa-trash"></i></a>';
                         

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
    
    public function admin_notification_search_count($search)
    {
        $query = $this
        ->db
        ->like('title',$search)
        ->or_like('msg',$search)
        ->or_like('type',$search)
        ->or_like('send_date_time',$search)        
        ->or_like('date_created',$search)        
        ->get("promotional_notifications");
    
        return $query->num_rows();
    }
	
    function admin_notification_search($limit,$start,$search,$col,$dir)
    {
        $query = $this
                ->db
                ->select('*')
                ->like('title',$search)
                ->or_like('msg',$search)
                ->or_like('type',$search)
                ->or_like('send_date_time',$search)        
                ->or_like('date_created',$search)    
                ->limit($limit,$start)
                ->order_by($col,$dir)
                ->get("app_banner");
        
        if($query->num_rows() > 0)
        {
            return $query->result_array();  
        }
        else
        {
            return null;
        }
    }
    
    public function add()
    {
        $data = []; 
        $countires = $this->Common_model->select('id,name','country');
//        echo "<pre>";
//        print_r($countires);
//        exit;
        $data['countries'] = $countires;
        if (isset($_POST['submit']) && $_POST['submit'] != ''){
            
//             echo "<pre>";
//              print_r($_POST);
//              exit;
            
            
             $this->form_validation->set_rules('title','Title','required');
             $this->form_validation->set_rules('msg','Message','required');
             $this->form_validation->set_rules('notification_type','Notification Type','required');
             
             if ($this->form_validation->run() == false){
                 $err_msg = validation_errors();
                 $this->session->set_flashdata('error',$err_msg);
             }else{
                    $title = $this->input->post('title');
                    $msg = $this->input->post('msg');
                    $country = $this->input->post('country');
                    $notification_type = $this->input->post('notification_type');
                    $products_arr  = $this->input->post('products');
                    $category  = $this->input->post('category');
                    $send_date_time  = $this->input->post('send_date_time');
                    
                    $insert_arr = array();
                   
                    $insert_arr['title'] = $title;
                    $insert_arr['msg'] = $msg;
                    $insert_arr['country'] = $country;
                    $insert_arr['type'] = $notification_type;
                    $insert_arr['products'] = implode(',',$products_arr);
                    $insert_arr['categories'] = $category;
                    $insert_arr['send_date_time'] = date('Y-m-d H:i:s',strtotime($send_date_time));
                    
                   $insert_id = $this->Common_model->insert('promotional_notifications',$insert_arr);
                
                    if(!empty($insert_id)){
                        $this->topicnotification('offers', $title, $msg);
                        $succ_msg = "Notification Added Successfully";
                        $this->session->set_flashdata('success',$succ_msg);
                        redirect('admin/notifications/');
                    }
            }
        }
	
        $this->load->view("admin/notifications/add", $data);
    }
    
    public function get_categories()
    {
       $categories = $this->Common_model->select('categories_id,categories_name','categories_description');
       
       if (!empty($categories)){
           $options = '<option value="">Select</option>';
           foreach($categories as $category)
           {
               $options .= '<option value="'.$category['id'].'">'.$category['categories_name'].'</option>';
           }
           
           echo $options;
       }
    }
    
    public function get_new_product_offer()
    {
       $date = strtotime(date("Y-m-d", strtotime("-5 day")));
       $products = $this->Common_model->select('pd.id,pd.name,c.coupon_id,','product_details pd',['c.created_at >='=> $date],'','','',
                                                array(1=>array('tableName'=>'coupons_to_product cp','columnNames'=>'pd.id = cp.product_id','jType'=>'inner'),
                                                      2=>array('tableName'=>'coupons c','columnNames'=>'c.coupon_id = cp.coupon_id','jType'=>'inner')));
//       echo "<pre>";
//       print_r($products);
//       exit;
       
       if (!empty($products)){
           $options = '<option value="">Select</option>';
           foreach($products as $product)
           {
               $options .= '<option value="'.$product['id'].'">'.$product['name'].'</option>';
           }
           
           echo $options;
       }
    }
    
    public function get_new_products()
    {
        $date = strtotime(date("Y-m-d", strtotime("-5 day")));
       $products = $this->Common_model->select('pd.id,pd.name','product_details pd',['pd.created_at >='=> $date]);
//       echo "<pre>";
//       print_r($products);
//       exit;
       
       if (!empty($products)){
           $options = '<option value="">Select</option>';
           foreach($products as $product)
           {
               $options .= '<option value="'.$product['id'].'">'.$product['name'].'</option>';
           }
           
           echo $options;
       }
    }
    
    public function get_product_category()
    {
        $product_id_arr = $this->input->post('product_id');

        
        if (!empty($product_id_arr)){
            $category_arr = array();
            foreach ($product_id_arr as $product)
            {
                $category_arr[] = $this->Common_model->select('c.categories_name','categories_description c',['pd.id'=>$product],'','','',
                                                              array(1=>array('tableName'=>'product_details pd','columnNames'=>'pd.category = c.categories_id','jType'=>'inner')))[0]['categories_name'];
            }
                    
//        echo "<pre>";
//        print_r($category_arr);
//        exit;
            
            if (!empty($category_arr)){
                $category_arr = array_unique($category_arr);
                echo implode(',', $category_arr);
            }
        }
        
       
    }
    
    public function view($id)
    {
        $data = array();
        if ($id){
            $details = $this->Common_model->select('nm.*,c.name','promotional_notifications nm',['nm.id'=>$id],'','','',
                                                   array(1=>array('tableName'=>'country c','columnNames'=>'nm.country = c.id','jType'=>'inner')));
            

            if(!empty($details)){
                $data['details'] = $details[0];
                $details = $details[0];
                
                if ($details['type'] == 'New Offers' || $details['type'] == 'New Products'){
                    $product_arr = explode(',', $details['products']);
                    
                    $product_str = '';
                    if (!empty('product_arr')){
                        $products = array();
                        foreach ($product_arr as $product)
                        {
                            $products[] = $this->Common_model->select('name','product_details',['id'=>$product])[0]['name'];
                        }
                        
                        $product_str = implode(',', $products);
                        $data['details']['product_str'] = $product_str;
                    }
                }
                
//                echo "<pre>";
//                print_r($data);
//                exit;
                
                $this->load->view("admin/notifications/view", $data);
            }
        }
    }
    
    public function edit($id)
    {
	$data = array();
	if ($id){
	    $record = $this->Common_model->getAll('app_banner',['id'=>$id])->result();
	    if (isset($_POST['submit']) && $_POST['submit'] != ''){
		$id = $this->input->post('id');
                
		$this->form_validation->set_rules('type','Type','required');
                $this->form_validation->set_rules('status','Status','required');
             
             if ($this->form_validation->run() == false){
                 $err_msg = validation_errors();
                 $this->session->set_flashdata('error',$err_msg);
             }else{
                    $type = $this->input->post('type');
                    $url = $this->input->post('url');
                    $on = $this->input->post('on');
                    $reference_id = $this->input->post('reference_id');
                    $status = $this->input->post('status');
                    
                    $insert_arr = array();
                    
                    if (!empty($_FILES) && isset($_FILES['image']) && !empty($_FILES['image'])){
                      
                        $current_dt 	         = date('Y_m_d');
                        $config['upload_path']	 = './uploads/images/app_banner/';
                        $config['allowed_types'] = 'gif|jpg|png|jpeg|bmp|';
                        $config['overwrite']	 = true;

                        $file_nm  	= $_FILES['image']['name'];
                        $config['file_name'] = $file_nm;

                        $this->upload->initialize($config);

                        if(!$this->upload->do_upload('image'))
                        {
                                $data['error'] = "Invalid File - File Type should be jpg | png | jpeg";
                        }else{
                                $insert_arr['image'] = base_url('uploads/images/app_banner/'.$file_nm);
                        }
                    }
                    
                    $insert_arr['type'] = $type;
                    $insert_arr['url'] = $url;
                    $insert_arr['on_app'] = $on;
                    $insert_arr['reference_id'] = $reference_id;
                    $insert_arr['status'] = $status;

                    $affected_rows = $this->Common_model->update('app_banner',$insert_arr,['id'=>$id]);
                  
                   
                    $succ_msg = "App Banner Image Updated Successfully";
                    $this->session->set_flashdata('success',$succ_msg);
                    redirect('admin/app_banner/');
		}
	    }
			
            if (!empty($record)){
              $data['record'] = $record[0];
              $record = $record[0];
              if ($record->type == 'App'){
                  if ($record->on_app == 'Category'){
                      $referrence_arr = $this->Common_model->select('categories_id as id,categories_name as name','categories_description');
                      $data['referrence_arr'] = $referrence_arr;
                  }else{
                      $referrence_arr = $this->Common_model->select('products_id as id,products_name as name','products_description');
                      $data['referrence_arr'] = $referrence_arr;
                  }
              }
              
              //echo "<pre>";
              //print_r($referrence_arr);
              //exit;
              $this->load->view('admin/common/header');
              $this->load->view('admin/common/sidebar');
              $this->load->view("admin/app_banner/edit", $data);
              $this->load->view('admin/common/footer');
            }	
	}
    }
    
    public function topicnotification($topic,$title,$message)
    {
        $server_key = 'AAAAL7El5pg:APA91bHZlGImKkEEs-eC8BsfEP7AHc9SWm1PfYcWkFBTDNFXKpN0pmvp9mqlRtpnnmyGfeBS08IO0jvtRlx-2ljGlUW8G20nsMM0H06m_ELx6nCQuXpLSLJI9wOaaz8-1KSHLLQjkdcg';

        $url = 'https://fcm.googleapis.com/fcm/send';

        $fields['to'] = '/topics/'.$topic;
        $fields['notification'] = array('title' =>$title , 'text' => $message);
        $headers = array(
        'Content-Type:application/json',
          'Authorization:key='.$server_key
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        $result = curl_exec($ch);
    }
    
    public function delete($id)
    {
        if ($id){
            $delete_status = $this->Common_model->delete('promotional_notifications',['id'=>$id]);
            if ($delete_status == 1){
                    $this->session->set_flashdata('error','Record Deleted');
                    redirect('admin/notifications');
            }
        }

    }
       
}