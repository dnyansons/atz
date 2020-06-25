<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
* This is a public api file does not need to be token verified
*
*/
class Bi_industry_news extends REST_Controller
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
    
    public function industry_news_list_get()
    {
        $output_arr = array();
        $output_arr['ws'] = "industry_news_list";
        $industry_news = $this->Common_model->select('*','bi_industry_news',['status'=>'Active']);
        if (!empty($industry_news)){
            $i=0;
            foreach ($industry_news as $news){
              $industry_news[$i]['publisher_logo'] = $news['publisher_logo'];  
              $industry_news[$i]['news_category_image'] = $news['news_category_image'];  
              $industry_news[$i]['date_created'] = date('d/m/Y');
            $i++;
            }
           $output_arr['status'] = 1;
           $output_arr['data'] = $industry_news;
        }else{
            $output_arr['status']= 0;
            $output_arr['msg'] = 'No Record Found';
        }
        $this->response($output_arr,HTTP_OK);
    }
    
    public function industry_news_details_post()
    {
        $output_arr = array();
        $output_arr['ws'] = "industry_news_details";
        $this->form_validation->set_rules("industry_news_id","industry_news_id","required");
        if($this->form_validation->run()===false){
            $output_arr['status'] = 0;
            $output_arr['msg'] = "Invalid inputs passed.";
            $this->response($output_arr,HTTP_OK);
        }else{
                $industry_news_id = $this->input->post('industry_news_id');
                $data = array();
                $details =  $this->Common_model->select('*','bi_industry_news',['id'=>$industry_news_id]);
                $industry_news_comments = $this->Common_model->select('id,user_id,date_created,comment,"shailesh" as user_name,"image" as user_image','bi_industry_news_comments',['industry_news_id'=>$industry_news_id]);
                if (!empty($details)){
                    $details = $details[0];
                    $details["news_comments"] = $industry_news_comments;
                    //array_push($details, ["news_comments" =>$industry_news_comments]);
                    $data['details'] = $details;
                    $short_description_web_view = $this->load->view("webviews/industry_news", $data,true);
                    $details['short_description'] = $short_description_web_view;
                    $details['date_created'] = date('d/m/y H:i a');
                    $details['news_comments'] = $industry_news_comments;
                    $output_arr['status'] = 1;
                    $output_arr['data'] = $details;
                }else{
                    $output_arr['status'] = 0;
                    $output_arr['msg'] = "Record Not Found.";
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
        $this->form_validation->set_rules("industy_news_id","recommended_id","required");
        $this->form_validation->set_rules("user_id","user_id","required");
        $this->form_validation->set_rules("comment","comment","required");
        if($this->form_validation->run()===false){			
                $this->response($output,HTTP_OK);
        } else {
                $industy_news_id = $this->post("industy_news_id");
                $user_id = $this->post("user_id");
                $comment = $this->post("comment");
                $ws = $this->post("ws");

                $insert_arr = [];
                $insert_arr['industry_news_id'] = $industy_news_id;
                $insert_arr['comment'] = $comment;
                $insert_arr['user_id'] = $user_id;
                $insert_id = $this->Common_model->insert('bi_industry_news_comments',$insert_arr);
                if ($insert_id){
                    $industry_news_comments = $this->Common_model->select('user_id,date_created,comment','bi_industry_news_comments',['industry_news_id'=>$industy_news_id]);
                    $output['ws'] = !empty($ws) ? $ws : 'add_comment';
                    $output['status'] = 1;
                    $output['message'] = "Success";
                    $output['comments'] = $industry_news_comments;
                    $this->response($output,HTTP_OK);
                }
        }
    }
}

