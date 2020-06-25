<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
* This is a public api file does not need to be token verified
*
*/
class Insight_recommended extends REST_Controller
{
	
    public function __construct($config = 'rest') 
    {
		$method = $_SERVER['REQUEST_METHOD'];
		
		if($method == "OPTIONS") {
			die();
		}
        parent::__construct($config);
		//$this->load->model("Common_model");
		$this->load->library("form_validation");
	}
	
	
	public function recommended_list_get()
	{
            $output_arr = array();
            $output_arr['ws'] = "recommended_list";
            $list_1 = $this->Common_model->select('id,image,topic,short_description,publisher,publisher_logo','insights_recommended',['status'=>'Active'],'',10,0);
            $list_2 = $this->Common_model->select('id,image,topic,date(date_created) as created_date','insights_recommended',['status'=>'Active'],'',1410065408,10);
            //echo $this->db->last_query();
           // echo "<pre>";
            // print_r($list_1);
            //print_r($list_2);
           // exit;
            if (!empty($list_1)){
                $i=0;
                
                foreach ($list_1 as $news)
                {
                    $list_1[$i]['image'] = base_url('uploads/images/'.$news['image']);
                    $i++;
                }
                
                if(!empty($list_2)){
                    $j=0;
                    foreach ($list_2 as $news)
                    {
                        $list_2[$j]['image'] = base_url('uploads/images/'.$news['image']);
                        $j++;
                    }
                }
                
               $output_arr['status'] = 1;
               $output_arr['data']['view_1'] = $list_1;
               $output_arr['data']['view_2'] = $list_2;
               $output_arr['data']['buyer_success_story'] = base_url()."users/buyer_story";
               
            }else{
                $output_arr['status']= 0;
                $output_arr['msg'] = 'No Record Found';
            }

            $this->response($output_arr,HTTP_OK);
	}
        
	
	public function recommended_details_post()
	{
		$output = [
			"status" => 0,
			"message" => "Invalid inputs passed."
		];
		//$data = (array)json_decode($this->encryption->decrypt(strrev($this->input->post('str'))));
		//$this->form_validation->set_data($data);
		$this->form_validation->set_rules("recommended_id","recommended_id","required");
		if($this->form_validation->run()===false){			
			$this->response($output,HTTP_OK);
		} else {
			$recommended_id = $this->post("recommended_id");
			$details = $this->Common_model->select('id,topic,publisher,publisher_logo,short_description,full_description,date_created','insights_recommended',['id'=>$recommended_id])[0];
                        $details['date_created'] = date('d/m/Y H:i a');
                        $comments = $this->Common_model->select('id,comment,user_id,recommend_id,date_created,"shailesh" as user_name,"image" as user_image','bi_recommended_comments',['recommend_id'=>$recommended_id]);
                        $details['comments'] = $comments;
                        $output['ws'] = "recommended_details";
                        $output['status'] = 1;
                        $output['message'] = "Success";
                        $output['data'] = $details;
                        $this->response($output,HTTP_OK);
		}
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
            $this->form_validation->set_rules("recommended_id","recommended_id","required");
            $this->form_validation->set_rules("user_id","user_id","required");
            $this->form_validation->set_rules("comment","comment","required");
            if($this->form_validation->run()===false){			
                    $this->response($output,HTTP_OK);
            } else {
                    $recommended_id = $this->post("recommended_id");
                    $user_id = $this->post("user_id");
                    $comment = $this->post("comment");
                    $ws = $this->post("ws");

                    $insert_arr = [];
                    $insert_arr['recommend_id'] = $recommended_id;
                    $insert_arr['comment'] = $comment;
                    $insert_arr['user_id'] = $user_id;

                    $insert_id = $this->Common_model->insert('bi_recommended_comments',$insert_arr);

                    if ($insert_id){
                        $recommended_comments = $this->Common_model->select('user_id,date_created,comment','bi_recommended_comments',['recommend_id' =>$recommended_id]);
                        $output['ws'] = !empty($ws) ? $ws : 'add_comment';
                        $output['status'] = 1;
                        $output['message'] = "Success";
                        $output['comments'] = $recommended_comments;
                        $this->response($output,HTTP_OK);

                    }
            }
	}
	
}