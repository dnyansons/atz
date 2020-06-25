<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Data_reports extends CI_Controller 
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
		
        $this->load->model('Insights_model');
        $this->load->library('Userpermission');
    }
	
    public function index()
    {
	$data = [];
        $this->load->view("admin/insights/data_reports/index", $data);
    }
	
    public function ajax_get_data_reports()
    {
        $columns = array(
            0 => 'id',
            1 => 'topic',
            2 => 'short_description',
	    3 => 'status'
        );

        $limit = $this->input->post('length');
        $start = $this->input->post('start');
        $order = $columns[$this->input->post('order')[0]['column']];
        $dir = $this->input->post('order')[0]['dir'];

        $totalData = $this->Common_model->select('count(id)','bi_data_reports')[0]['count_id'];

        $totalFiltered = $totalData;
		
        if (empty($this->input->post('search')['value'])) {
            $list = $this->Common_model->select('*','bi_data_reports','',array(1=>array('colname'=>$order,'type'=>'DESC')),$limit,$start);
           
        } else {
            $search = $this->input->post('search')['value'];
			
            $list = $this->data_report_search($limit, $start, $search, $order, $dir);
			
            $totalFiltered = $this->data_report_search_count($search);
        }
		
        $data = array();
        if (!empty($list)) {
            foreach ($list as $row) {
				
                $nestedData['id'] = $row['id'];
                $nestedData['topic'] = $row['topic'];
                $nestedData['short_description'] = strlen($row['short_description']) > 50 ? substr($row['short_description'],0,20).'...':$row['short_description'];
                $nestedData['status'] = $row['status'];
                $nestedData['action'] = '<a href="'.base_url().'admin/BI/data_reports/view/'.$row['id'].'" class="tabledit-delete-button btn btn-success waves-effect waves-light btn-sm" data-toggle="tooltip" data-placement="top" title="View" data-original-title="Delete"><i class="fa fa-eye"></i></a>
				         <a href="'.base_url().'admin/BI/data_reports/edit/'.$row['id'].'" class="tabledit-edit-button btn btn-primary waves-effect waves-light btn-sm" data-toggle="tooltip" data-placement="top" title="Edit" data-original-title="Edit"><i class="fa fa-pencil-square-o"></i></a>
                                         <a href="'.base_url().'admin/BI/data_reports/delete/'.$row['id'].'" class="tabledit-delete-button btn btn-danger waves-effect waves-light btn-sm" data-toggle="tooltip" data-placement="top" title="Delete" data-original-title="Delete" onclick="if (!confirm(\'Are you sure you want to delete this record?\')) return false;"><i class="fa fa-trash"></i></a>';

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
	
	public function add()
	{
	   $data = [];
	   $categories = $this->Common_model->select('c.category_id,cd.categories_name','categories c','','','','',
	                                              array(1=>array('tableName'=>'categories_description cd','columnNames'=>'c.category_id = cd.categories_id','jType'=>'inner')));
												  
	   if (isset($_POST['submit']) && $_POST['submit'] != ''){
                $this->form_validation->set_rules('topic','Topic','required|is_unique[bi_data_reports.topic]');
                $this->form_validation->set_rules('short_description','Short Description','required');
                $this->form_validation->set_rules('over_view','Overview','required');
                $this->form_validation->set_rules('prod_category','Product Category','required');
                $this->form_validation->set_rules('prod_sub_category','Product Sub Category','required');
		   
                if ($this->form_validation->run() == false){
                    $err_msg = validation_errors();
                    $this->session->set_flashdata('error',$err_msg);
                }else{
                        $topic = $this->input->post('topic');
                        $short_description = $this->input->post('short_description');
                        $over_view = $this->input->post('over_view');
                        $prod_category = $this->input->post('prod_category');
                        $prod_sub_category = $this->input->post('prod_sub_category');
                        $status = $this->input->post('status');

                        $insert_arr = array();

                        $insert_arr['topic'] = $topic;
                        $insert_arr['short_description'] = $short_description;
                        $insert_arr['overview'] = $over_view;
                        $insert_arr['cat_id'] = $prod_category;
                        $insert_arr['sub_cat_id'] = $prod_sub_category;
                        $insert_arr['status'] = $status;

                       $insert_id = $this->Common_model->insert('bi_data_reports',$insert_arr);

                       if(!empty($insert_id)){
                               $succ_msg = "Data Report Added Successfully";
                               $this->session->set_flashdata('success',$succ_msg);
                               redirect('admin/BI/data_reports/');
                       }
		}
	   }
	   $data['categories'] = $categories;
           $this->load->view("admin/insights/data_reports/add", $data);
	}
	
	public function get_product_sub_categories()
	{
		$cat_id = $this->input->post('cat_id');
		
		if (!empty($cat_id)){
			$sub_categories = $this->Common_model->select('c.category_id,cd.categories_name','categories c',['c.parent_id'=>$cat_id],'','','',
	                                              array(1=>array('tableName'=>'categories_description cd','columnNames'=>'c.category_id = cd.categories_id','jType'=>'inner')));
												  
			if (!empty($sub_categories)){
				$str  = '<option value="">Select</option>';
				foreach($sub_categories as $sub_category)
				{
					$str .= '<option value="'.$sub_category['category_id'].'">'.$sub_category['categories_name'].'</option>';
				}
				
				echo $str;
			}									  
		}
	}
	
	public function data_report_search_count($search)
	{
		$query = $this
                ->db
                ->like('topic',$search)
                ->or_like('short_description',$search)
				->or_like('status',$search)
                ->get("bi_data_reports");
    
        return $query->num_rows();
	}
	
    function data_report_search($limit,$start,$search,$col,$dir)
    {
        $query = $this
                ->db
                ->select('*')
                ->like('topic',$search)
                ->or_like('short_description',$search)
				->or_like('status',$search)
                ->limit($limit,$start)
                ->order_by($col,$dir)
                ->get("bi_data_reports");
        
       
        if($query->num_rows()>0)
        {
            return $query->result();  
        }
        else
        {
            return null;
        }
    }
    
    public function view($id)
    {
        $data = array();
	    if ($id){
		$details = $this->Common_model->select('dr.*,cd1.categories_name as category,cd2.categories_name as sub_category','bi_data_reports dr',['dr.id'=>$id],'','','',
                                                       array(1=>array('tableName'=>'categories_description cd1','columnNames'=>'dr.cat_id = cd1.categories_id','jType'=>'inner'),
                                                             2=>array('tableName'=>'categories_description cd2','columnNames'=>'dr.sub_cat_id = cd2.categories_id','jType'=>'inner')));
//                echo "<pre>";
//                print_r($details);
//                exit;
		    if(!empty($details)){
			$data['details'] = $details[0];
			$this->load->view("admin/insights/data_reports/view", $data);
		    }
	    }
    }
    
    public function edit($id)
    {
	$data = array();
	if ($id){
	    $record = $this->Common_model->getAll('bi_data_reports',['id'=>$id])->result();
            $categories = $this->Common_model->select('c.category_id,cd.categories_name','categories c','','','','',
	                                              array(1=>array('tableName'=>'categories_description cd','columnNames'=>'c.category_id = cd.categories_id','jType'=>'inner')));
            
	    if (isset($_POST['submit']) && $_POST['submit'] != ''){
		$id = $this->input->post('id');
                
		$this->form_validation->set_rules('topic','Topic','required|is_unique[bi_industry_news.topic]');
                $this->form_validation->set_rules('short_description','Short Description','required|is_unique[bi_industry_news.topic]');
                $this->form_validation->set_rules('over_view','Overview','required');
                $this->form_validation->set_rules('prod_category','Product Category','required');
                $this->form_validation->set_rules('prod_sub_category','Product Sub Category','required');
			
		if ($this->form_validation->run() == false){
		    $err_msg = validation_errors();
		    $this->session->set_flashdata('error',$err_msg);
		}else{
		    $topic = $this->input->post('topic');
                    $short_description = $this->input->post('short_description');
                    $over_view = $this->input->post('over_view');
                    $prod_category = $this->input->post('prod_category');
                    $prod_sub_category = $this->input->post('prod_sub_category');
                    $status = $this->input->post('status');
				
		    $insert_arr = array();
					
                    $insert_arr['topic'] = $topic;
                    $insert_arr['short_description'] = $short_description;
                    $insert_arr['overview'] = $over_view;
                    $insert_arr['cat_id'] = $prod_category;
                    $insert_arr['sub_cat_id'] = $prod_sub_category;
                    $insert_arr['status'] = $status;
				
	            $affected_rows = $this->Common_model->update('bi_data_reports',$insert_arr,['id'=>$id]);
				
		    if ($affected_rows > 0){
			$this->session->set_flashdata('success','Record Updated Successfully');
			redirect('admin/BI/data_reports/');
		    }
		}
	    }
			
            if (!empty($record)){
              $data['record'] = $record[0];
              $data['categories'] = $categories;
              $sub_categories = $this->Common_model->select('c.category_id,cd.categories_name','categories c',['c.parent_id'=>$record[0]->cat_id],'','','',
	                                              array(1=>array('tableName'=>'categories_description cd','columnNames'=>'c.category_id = cd.categories_id','jType'=>'inner')));
              $data['sub_categories'] = $sub_categories;
              $this->load->view('admin/common/header');
              $this->load->view('admin/common/sidebar');
              $this->load->view("admin/insights/data_reports/edit", $data);
              $this->load->view('admin/common/footer');
            }	
	}
    }
    
    public function check_topic_update()
    {
        $id = $this->input->post('id');
        $topic = $this->input->post('topic');
        $resposnse = true;
        $rec = $this->Common_model->select('*','bi_data_reports',['topic'=>$topic,'id !='=>$id]);
        if (!empty($rec)){
            $this->form_validation->set_message('check_topic_update', 'Topic must be unique');
            $response = false;
        }
        return $response;
     }
    
    public function delete($id)
    {
        if ($id){
                $delete_status = $this->Common_model->delete('bi_data_reports',['id'=>$id]);

                if ($delete_status == 1){
                        $this->session->set_flashdata('error','Record Deleted');
                        redirect('admin/BI/data_reports');
                }

        }

    }
    
    public function detail_web_view()
    {
        $data_report_id = 4;
        $data = array();
        $sub_cat_id = $this->Common_model->select('sub_cat_id','bi_data_reports',['id'=>$data_report_id])[0]['sub_cat_id'];
        //echo $sub_cat_id;
        //exit;
        $sub_category_products_inquiry = $this->Common_model->select('pd.products_id,pd.products_name,p.products_price,p.min_order_quantity,p.products_image,count(enq.for_product) as inquiry_count','products p',['ptc.categories_id'=>$sub_cat_id],array(1=>array('colname'=>'inquiry_count','type'=>'DESC')),10,'',
                                                             array(1=>array('tableName'=>'products_description pd','columnNames'=>'p.products_id = pd.products_id','jType'=>'inner'),
                                                                   2=>array('tableName'=>'products_to_categories ptc','columnNames'=>'ptc.products_id = p.products_id','jType'=>'inner'),
                                                                   3=>array('tableName'=>'inquiries enq','columnNames'=>'enq.for_product = p.products_id','jType'=>'inner')),'enq.for_product');
        
        $data['sub_category_product_inquiry'] = $sub_category_products_inquiry;
        $sub_category_products = $this->Common_model->select('pd.products_id,pd.products_name,p.products_price,p.min_order_quantity,p.products_image','products p',['ptc.categories_id'=>$sub_cat_id],'',10,'',
                                                             array(1=>array('tableName'=>'products_description pd','columnNames'=>'p.products_id = pd.products_id','jType'=>'inner'),
                                                                   2=>array('tableName'=>'products_to_categories ptc','columnNames'=>'ptc.products_id = p.products_id','jType'=>'inner')));
        $data['sub_category_products'] = $sub_category_products;
//        echo "<pre>";
//        print_r($sub_category_products);
//        exit;
        $this->load->view('webviews/data_report_detail',$data);
    }
    
}
