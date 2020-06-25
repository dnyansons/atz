<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
* This is a public api file does not need to be token verified
*
*/
class Bi_event extends REST_Controller
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
    
    public function event_list_get()
    {
        $output_arr = array();
        $output_arr['ws'] = "event_list";
        $event_list_1 = $this->Common_model->select('*','bi_event',['status'=>'Active'],'',10,0);
        $event_list_2 = $this->Common_model->select('id,title,date(date_created) as created_date','bi_event',['status'=>'Active'],'',1410065408,10);
        
        if (!empty($event_list_1)){
           $output_arr['status'] = 1;
           $output_arr['data']['view_1'] = $event_list_1;
           $output_arr['data']['view_2'] = $event_list_2;
        }else{
            $output_arr['status']= 0;
            $output_arr['msg'] = 'No Record Found';
        }
        $this->response($output_arr,HTTP_OK);
    }
    
    public function event_details_post()
    {
        $output_arr = array();
        $output_arr['ws'] = "event_details";
        $this->form_validation->set_rules("event_id","event_id","required");
        if($this->form_validation->run()===false){
            $output_arr['status'] = 0;
            $output_arr['msg'] = "Invalid inputs passed.";
            $this->response($output_arr,HTTP_OK);
        }else{
                $event_id = $this->input->post('event_id');
                $data = array();
                $details =  $this->Common_model->select('*','bi_event',['id'=>$event_id]);
                if (!empty($details)){
                    $details = $details[0];
                    $details['date_created'] = date('d/m/Y H:i a');
                    $output_arr['status'] = 1;
                    $output_arr['data'] = $details;
                }else{
                    $output_arr['status'] = 0;
                     $output_arr['msg'] = "Record Not Found";
                }
            }
            
            $this->response($output_arr,HTTP_OK);
    }
}