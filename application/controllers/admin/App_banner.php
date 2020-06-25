<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class App_banner extends CI_Controller 
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
     $this->load->library("awsupload");

	
    }
    
    public function index()
    {
        $data = array();
        $this->load->view("admin/app_banner/index", $data);
    }
    
    public function ajax_get_app_banners()
    {
        $columns = array(
            0 => 'id',
            1 => 'image',
            2 => 'type',
            3 => 'image_placed',
            4 => 'status',
            5 => 'date_created',
        );

        $limit = $this->input->post('length');
        $start = $this->input->post('start');
        $order = $columns[$this->input->post('order')[0]['column']];
        //$dir = $this->input->post('order')[0]['dir'];
        $dir ="desc";

        $totalData = $this->Common_model->select('count(id)','app_banner')[0]['count_id'];

        $totalFiltered = $totalData;
		
        if (empty($this->input->post('search')['value'])) {
            $list = $this->Common_model->select('*','app_banner','',array(1=>array('colname'=>$order,'type'=>'DESC')),$limit,$start);
           
        } else {
            $search = $this->input->post('search')['value'];
			
            $list = $this->app_banner_search($limit, $start, $search, $order, $dir);
			
            $totalFiltered = $this->app_banner_search_count($search);
        }
		
        $data = array();
        if (!empty($list)) {
            foreach ($list as $row) {
                $nestedData['id'] = $row['id'];
                $nestedData['image'] = '<img src="'.$row['image'].'" style="height:60px; width:60px">';
                $nestedData['type'] = $row['type'];
                $nestedData['image_placed'] = $row['image_placed'];
                $nestedData['status'] = $row['status'];
                $nestedData['date_created'] = $row['date_created'];
                $nestedData['action'] = ' <a href="'.base_url().'admin/app_banner/view/'.$row['id'].'" class="tabledit-delete-button btn btn-success waves-effect waves-light btn-sm" data-toggle="tooltip" data-placement="top" title="View" data-original-title="Delete"><i class="fa fa-eye"></i></a>
				          <a href="'.base_url().'admin/app_banner/edit/'.$row['id'].'" class="tabledit-edit-button btn btn-primary waves-effect waves-light btn-sm" data-toggle="tooltip" data-placement="top" title="Edit" data-original-title="Edit"><i class="fa fa-pencil-square-o"></i></a>
                                          <a href="'.base_url().'admin/app_banner/delete/'.$row['id'].'" class="tabledit-delete-button btn btn-danger waves-effect waves-light btn-sm" data-toggle="tooltip" data-placement="top" title="Delete" data-original-title="Delete" onclick="if (!confirm(\'Are you sure you want to delete this record?\')) return false;"><i class="fa fa-trash"></i></a>';

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
    
    public function app_banner_search_count($search)
    {
        $query = $this
        ->db
        ->like('type',$search)
        ->or_like('status',$search)
        ->or_like('date_created',$search)        
        ->get("app_banner");
    
        return $query->num_rows();
    }
	
    function app_banner_search($limit,$start,$search,$col,$dir)
    {
        $query = $this
                ->db
                ->select('*')
                ->like('type',$search)
                ->or_like('status',$search)    
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
        
        if (isset($_POST['submit']) && $_POST['submit'] != ''){
            
             $this->form_validation->set_rules('type','Type','required');
             $this->form_validation->set_rules('status','Status','required');
             
             if ($this->form_validation->run() == false){
                 $err_msg = validation_errors();
                 $this->session->set_flashdata('error',$err_msg);
             }else{
                    $type = $this->input->post('type');
                    $url = $this->input->post('url');
                    $ban_place = $this->input->post('banner_placed');
                    $on = $this->input->post('on');
                    $reference_id = $this->input->post('reference_id');
                    $status = $this->input->post('status');
                    
                    $insert_arr = array();
                    
              if (!empty($_FILES) && isset($_FILES['image']) && !empty($_FILES['image'])){
                        
                     
                $checkImageSizes = $this->awsupload->checkImageSize('image', 'app_banner');

                if($checkImageSizes !== true)
                 {
                   
                   $message = "<div class='alert alert-danger alert-dismissible text-left'>
                                <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                                <strong>Invalid image!</strong> $checkImageSizes.
                              </div>";
                    $this->session->set_flashdata("message",$message);
                    redirect("admin/app_banner/add","refresh");
                    exit;
                 } 

                      $url = $this->awsupload->upload("image","uploads/images/app_banner","image");

                        if($url==false)
                        {
                      
                      // $data['error'] = "Invalid File - File Type should be jpg | png | jpeg";
                      $message = "<div class='alert alert-danger alert-dismissible text-left'>
                            <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                            <strong>Error!</strong> Invalid Image Type.
                          </div>";
                      $this->session->set_flashdata("message",$message);
                      redirect("admin/app_banner/add","refresh");

                        }else{
                            $insert_arr['image'] = $url;
                            $insert_arr['type'] = $type;
                            $insert_arr['url'] = $url;
                            $insert_arr['image_placed'] = $ban_place;
                            $insert_arr['on_app'] = $on;
                            $insert_arr['reference_id'] = $reference_id;
                            $insert_arr['status'] = $status;

                            $insert_id = $this->Common_model->insert('app_banner',$insert_arr);
                        }
                    }
                
                    if(!empty($insert_id)){
                        $succ_msg = "<div class='alert alert-info'>App Banner Image Added Successfully</div>";
                        $this->session->set_flashdata('message',$succ_msg);
                        redirect('admin/app_banner/');
                    }
            }
        }
	
        $this->load->view("admin/app_banner/add", $data);
    }
    
    public function get_categories()
    {
       $categories = $this->Common_model->select('categories_id,categories_name','categories_description');
       
       if (!empty($categories)){
           $options = '<option value="">Select</option>';
           foreach($categories as $category)
           {
               $options .= '<option value="'.$category['categories_id'].'">'.$category['categories_name'].'</option>';
           }
           
           echo $options;
       }
    }
    
    public function get_products()
    {
       $products = $this->Common_model->select('id,name','product_details');
       
       if (!empty($products)){
           $options = '<option value="">Select</option>';
           foreach($products as $product)
           {
               $options .= '<option value="'.$product['id'].'">'.$product['name'].'</option>';
           }
           
           echo $options;
       }
    }
    
    public function view($id)
    {
        $data = array();
        if ($id){
            $details = $this->Common_model->select('ab.*, cd.categories_name,pd.name','app_banner ab',['ab.id'=>$id],'','','',
                                                    array(1=>array('tableName'=>'categories_description cd','columnNames'=>'cd.categories_id = ab.reference_id','jType'=>'left'),
                                                          2=>array('tableName'=>'product_details pd','columnNames'=>'pd.id = ab.reference_id','jType'=>'left')));
            //echo "<pre>";
            //print_r($details);
            //exit;

            if(!empty($details)){
                $data['details'] = $details[0];
                $this->load->view("admin/app_banner/view", $data);
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
                    $ban_place = $this->input->post('banner_placed');
                    $on = $this->input->post('on');
                    $reference_id = $this->input->post('reference_id');
                    $status = $this->input->post('status');
                  
                    $insert_arr = array();
                    
                    if (!empty($_FILES) && isset($_FILES['image']) && !empty($_FILES['image'])){
                    
               $checkImageSizes = $this->awsupload->checkImageSize('image', 'app_banner');

                if($checkImageSizes !== true)
                 {
                   
                   $message = "<div class='alert alert-danger alert-dismissible text-left'>
                                <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                                <strong>Invalid image!</strong> 900 * 400 image of max size 150 Kb is allowed to upload.
                              </div>";
                    $this->session->set_flashdata("message",$message);
                    redirect("admin/app_banner","refresh");
                    exit;
                 } 
     
                   
               $checkImageSizes = $this->awsupload->checkImageSize('image', 'app_banner');
                $url = $this->awsupload->upload("image","uploads/images/app_banner","image");

                        if($url==false)
                        {
                        
                        // $data['error'] = "Invalid File - File Type should be jpg | png | jpeg";

                        $message = "<div class='alert alert-danger alert-dismissible text-left'>
                            <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                            <strong>Error!</strong> Invalid Image Type.
                          </div>";
                        $this->session->set_flashdata("message",$message);
                        redirect("admin/app_banner","refresh");

                        }else{
                                $insert_arr['image'] = $url;
                                $insert_arr['type'] = $type;
                                $insert_arr['url'] = $url;
                                $insert_arr['image_placed'] = $ban_place;
                                $insert_arr['on_app'] = $on;
                                $insert_arr['reference_id'] = $reference_id;
                                $insert_arr['status'] = $status;
                                $affected_rows = $this->Common_model->update('app_banner',$insert_arr,['id'=>$id]);
                                $succ_msg = "<div class='alert alert-info'>App Banner Image Updated Successfully</div>";
                                $this->session->set_flashdata('message',$succ_msg);
                        }
                    }
                    
                    
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
                      $referrence_arr = $this->Common_model->select('id,name','product_details');
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
    
    public function delete($id)
    {
        if ($id){
            $delete_status = $this->Common_model->delete('app_banner',['id'=>$id]);
            if ($delete_status == 1){
                    $this->session->set_flashdata('error',"<div class='alert alert-info'>Record Deleted</div>");
                    redirect('admin/app_banner');
            }
        }

    }
       
}