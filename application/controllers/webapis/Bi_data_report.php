<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
* This is a public api file does not need to be token verified
*
*/
class Bi_data_report extends REST_Controller
{
	
    public function __construct($config = 'rest') 
    {
        $method = $_SERVER['REQUEST_METHOD'];
        if($method == "OPTIONS") {
                die();
        }
        parent::__construct($config);
	$this->load->library("form_validation");
    }
    
    public function data_report_list_get()
    {
        $output_arr = array();
        $output_arr['ws'] = "data_report_list";
        $list_1 = $this->Common_model->select('dr.*,cd1.categories_name as category,cd2.categories_name as sub_category','bi_data_reports dr','','',1,0,
                                                       array(1=>array('tableName'=>'categories_description cd1','columnNames'=>'dr.cat_id = cd1.categories_id','jType'=>'inner'),
                                                             2=>array('tableName'=>'categories_description cd2','columnNames'=>'dr.sub_cat_id = cd2.categories_id','jType'=>'inner')));
        
         $list_2 = $this->Common_model->select('dr.id,dr.topic,date(dr.date_created) as created_date','bi_data_reports dr','','',1410065408,1,
                                                       array(1=>array('tableName'=>'categories_description cd1','columnNames'=>'dr.cat_id = cd1.categories_id','jType'=>'inner'),
                                                             2=>array('tableName'=>'categories_description cd2','columnNames'=>'dr.sub_cat_id = cd2.categories_id','jType'=>'inner')));
         
         
         
        if (!empty($list_1)){
           $output_arr['status'] = 1;
           $output_arr['data']['view_1'] = $list_1;
           $output_arr['data']['view_2'] = $list_2;
        }else{
            $output_arr['status']= 0;
            $output_arr['message'] = 'No Record Found';
        }
        $this->response($output_arr,HTTP_OK);
    }
    
    public function data_report_details_post()
    {
        $output_arr = array();
        $output_arr['ws'] = "data_report_details";
        $this->form_validation->set_rules("data_report_id","data_report_id","required");
        if($this->form_validation->run()===false){
            $output_arr['status'] = 0;
            $output_arr['message'] = "Invalid inputs passed.";
            $this->response($output_arr,HTTP_OK);
        }else{
                $data_report_id = $this->input->post('data_report_id');
                $data = array();
                $data_report_arr = $this->Common_model->select('*','bi_data_reports',['id'=>$data_report_id]);
                if (!empty($data_report_id)){
                    $data_report = $data_report_arr[0];
                    $sub_cat_id = $data_report['sub_cat_id'];
                    $data['data_report'] = $data_report;
                    $sub_category_products_inquiry = $this->Common_model->select('pd.products_id,pd.products_name,p.products_price,p.min_order_quantity,p.products_image,count(enq.for_product) as inquiry_count','products p',['ptc.categories_id'=>$sub_cat_id],array(1=>array('colname'=>'inquiry_count','type'=>'DESC')),10,'',
                                                                     array(1=>array('tableName'=>'products_description pd','columnNames'=>'p.products_id = pd.products_id','jType'=>'inner'),
                                                                           2=>array('tableName'=>'products_to_categories ptc','columnNames'=>'ptc.products_id = p.products_id','jType'=>'inner'),
                                                                           3=>array('tableName'=>'inquiries enq','columnNames'=>'enq.for_product = p.products_id','jType'=>'inner')),'enq.for_product');

                    $data['sub_category_product_inquiry'] = $sub_category_products_inquiry;
                    $sub_category_products = $this->Common_model->select('pd.products_id,pd.products_name,p.products_price,p.min_order_quantity,p.products_image','products p',['ptc.categories_id'=>$sub_cat_id],'',10,'',
                                                                         array(1=>array('tableName'=>'products_description pd','columnNames'=>'p.products_id = pd.products_id','jType'=>'inner'),
                                                                               2=>array('tableName'=>'products_to_categories ptc','columnNames'=>'ptc.products_id = p.products_id','jType'=>'inner')));
                    $data['sub_category_products'] = $sub_category_products;
//                    echo "<pre>";
//                    print_r($data);
//                    exit;
                    $view_data = $this->load->view('webviews/data_report_detail',$data,true);
                    $output_arr['status'] = 1;
                    $output_arr['data'] = $view_data;
                }else{
                    $output_arr['status'] = 0;
                    $output_arr['message'] = "Record Not Found";
                }
                //echo $sub_cat_id;
                //exit;
                
            }
            
        $this->response($output_arr,HTTP_OK);
    }
}

