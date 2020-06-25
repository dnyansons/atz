<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
* This is a public api file does not need to be token verified
*
*/
class Bi_supplier_news extends REST_Controller
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
    
    public function supplier_news_list_get()
    {
        $output_arr = array();
        $output_arr['ws'] = "supplier_news_list";
        $supplier_news = $this->Common_model->select('id,company_name,slogan,company_profile,company_profile_images,publisher,publisher_logo','bi_supplier_news',['status'=>'Active'],'',10,0);
        $supplier_news_view2 = $this->Common_model->select('id,slogan,date(date_created) as created_date,company_profile_images','bi_supplier_news',['status'=>'Active'],'',1410065408,10);
        
        //var_dump($supplier_news);
        //exit;
        
        if (!empty($supplier_news)){
            $i=0;
            foreach ($supplier_news as $news){
                $supplier_news[$i]['company_profile_images'] = array();
                $supplier_news[$i]['company_profile'] = substr($supplier_news[$i]['company_profile'],0,100);
                if ($news['company_profile_images'] != '')
                {
                    $company_profile_img_arr = explode(',', $news['company_profile_images']);
                    if (!empty($company_profile_img_arr)){
                         $supplier_news[$i]['company_profile_image'] = $company_profile_img_arr[0];
                    }
                }
                unset($supplier_news[$i]['company_profile_images']);
                
            $i++;
            }
            
            if (!empty($supplier_news_view2)){
                $j = 0;
                    foreach ($supplier_news_view2 as $news){
                    $supplier_news_view2[$j]['company_profile_images'] = array();
                    
                    if ($news['company_profile_images'] != '')
                    {
                        $company_profile_img_arr = explode(',', $news['company_profile_images']);
                        if (!empty($company_profile_img_arr)){
                             $supplier_news_view2[$j]['company_profile_image'] = $company_profile_img_arr[0];
                        }
                    }
                    unset($supplier_news_view2[$j]['company_profile_images']);

                $j++;
                }
            }
           
           $output_arr['status'] = 1;
           $output_arr['data']['view_1'] = $supplier_news;
           $output_arr['data']['view_2'] = $supplier_news_view2;
           
        }else{
            $output_arr['status']= 0;
            $output_arr['msg'] = 'No Record Found';
        }
        $this->response($output_arr,HTTP_OK);
    }
    
    public function supplier_news_details_post()
    {
        $output_arr = array();
        $output_arr['ws'] = "supplier_news_details";
        $this->form_validation->set_rules("supplier_news_id","supplier_news_id","required");
        if($this->form_validation->run()===false){
            $output_arr['status'] = 0;
            $output_arr['msg'] = "Invalid inputs passed.";
            $this->response($output_arr,HTTP_OK);
        }else{
                $supplier_news_id = $this->input->post('supplier_news_id');
                $data = array();
                $details =  $this->Common_model->select('*','bi_supplier_news',['id'=>$supplier_news_id]);
                $details['company_profile_images_arr'] = array();
                $details['company_competence_images_arr'] = array();
                $details['success_story_images_arr'] = array();
                if (!empty($details)){
                    $details = $details[0];
                    $details['date_created'] = date('d/m/Y H:i a');
                    if ($details['company_profile_images'] != '')
                    {
                        $company_profile_img_arr = explode(',', $details['company_profile_images']);
                        if (!empty($company_profile_img_arr)){
                            $j = 0;
                            foreach ($company_profile_img_arr as $img)
                            {
                                $details['company_profile_images_arr'][] = $img;
                            }
                        }
                    }
                
                    if ($details['company_competence_images'] != '')
                    {
                        $company_competence_img_arr = explode(',', $details['company_competence_images']);
                        if (!empty($company_competence_img_arr)){
                            $j = 0;
                            foreach ($company_competence_img_arr as $img)
                            {
                                $details['company_competence_images_arr'][] = $img;
                            }
                        }
                    }
                    if ($details['success_story_images'] != '')
                    {
                        $success_story_img_arr = explode(',', $details['success_story_images']);
                        if (!empty($success_story_img_arr)){
                            $j = 0;
                            foreach ($success_story_img_arr as $img)
                            {
                                $details['success_story_images_arr'][] = $img;
                            }
                        }
                    }
                    
                    $data['details'] = $details;
                    unset($details['company_profile']);
                    unset($details['company_competence']);
                    unset($details['success_story']);
                    unset($details['company_profile_images']);
                    unset($details['company_competence_images']);
                    unset($details['success_story_images']);
                    unset($details['company_profile_images_arr']);
                    unset($details['company_competence_images_arr']);
                    unset($details['success_story_images_arr']);
                    $webview = $this->load->view('webviews/supplier_news_details',$data,true);
                    $details['supplier_news_comments'] = $this->Common_model->select('user_id,date_created,comment','bi_supplier_news_comments',['supplier_news_id'=>$supplier_news_id]);
                    
                    $details['web_view'] = $webview;
                    $output_arr['status'] = 1;
                    $output_arr['data'] = $details;
                }else{
                    $output_arr['status'] = 0;
                     $output_arr['msg'] = "Record Not Found";
                }
            }
            
            $this->response($output_arr,HTTP_OK);
        }
    
    public function add_comment_post()
    {
        $output = [
            "ws" => "add_comment",
                "status" => 0,
                "message" => "Invalid inputs passed."
        ];
        //$data = (array)json_decode($this->encryption->decrypt(strrev($this->input->post('str'))));
        //$this->form_validation->set_data($data);
        $this->form_validation->set_rules("supplier_news_id","supplier_news_id","required");
        $this->form_validation->set_rules("user_id","user_id","required");
        $this->form_validation->set_rules("comment","comment","required");
        if($this->form_validation->run()===false){			
                $this->response($output,HTTP_OK);
        } else {
                $supplier_news_id = $this->post("supplier_news_id");
                $user_id = $this->post("user_id");
                $comment = $this->post("comment");
                $ws = $this->post("ws");

                $insert_arr = [];
                $insert_arr['supplier_news_id'] = $supplier_news_id;
                $insert_arr['comment'] = $comment;
                $insert_arr['user_id'] = $user_id;
                $insert_id = $this->Common_model->insert('bi_supplier_news_comments',$insert_arr);
                if ($insert_id){
                    $supplier_news_comments = $this->Common_model->select('user_id,date_created,comment','bi_supplier_news_comments',['supplier_news_id'=>$supplier_news_id]);
                    $output['ws'] = !empty($ws) ? $ws : 'add_comment';
                    $output['status'] = 1;
                    $output['message'] = "Success";
                    $output['comments'] = $supplier_news_comments;
                    $this->response($output,HTTP_OK);
                }
        } 
    }
}

