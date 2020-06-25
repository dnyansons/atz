<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Versionone extends REST_Controller 
{
    public function __construct($config = 'rest') 
    {
		parent::__construct($config);
		$this->load->library('encryption');
		$this->load->library('form_validation');
	}
    
    public function index_get() 
    {
        echo "Coming Soon";
    }
	
	
	function request_post()
	{
		$data = $this->input->post();
		echo strrev($this->encryption->encrypt(json_encode($data)));
	}
	function response_post()
	{
		$data = $this->input->post('str');
		echo $this->encryption->decrypt(strrev($data));
	}
	
	public function login_post()
	{
		$output = [
			"success" => 0,
			"message" => "Invalid inputs passed."
		];
		$data = (array)json_decode($this->encryption->decrypt(strrev($this->input->post('str'))));
		$this->form_validation->set_data($data);
		$this->form_validation->set_rules("username","Username","required");
		$this->form_validation->set_rules("password","Password","required");
		if($this->form_validation->run()===false){			
			$this->response($output,HTTP_OK);
		} else {
			$output["debug"] = $data;
			$this->response($output,HTTP_OK);
		}
		
	}
	
	public function profile_get()
	{
		$user = [
			"username" => "testuser@atzcart.com",
			"full_name" => "Test User"
		];
	}
	
	public function check_get()
	{
		phpinfo();
	}
        
        public function social_signup_post() 
        {
            //$user = $this->_payload->userid;
            //echo "skd";
            //exit;
             $ws_temp = $this->post("ws");
             $ws = "social_signup";
             if(isset($ws_temp)){
             $ws = $ws_temp;
             }
             $output = [
                "status" => 0,
                "message" => "Data Not Found",
                "ws" => $ws
             ];

             $this->form_validation->set_rules("country_name","country_name","required");
             $this->form_validation->set_rules("email_id","email_id","required");
             $this->form_validation->set_rules("first_name","first_name","required");
             $this->form_validation->set_rules("last_name","last_name","required");
             $this->form_validation->set_rules("social_media_type","social_media_type","required");

              if($this->form_validation->run() == false)
              {
                $this->response($output, REST_Controller::HTTP_OK);
              }

              else
              {
                $country_name = $this->input->post('country_name');  
                $email_id = $this->input->post('email_id');
                $first_name = $this->input->post('first_name');
                $last_name = $this->input->post('last_name');
                $social_media_type = $this->input->post('social_media_type');

                $user_arr = $this->Common_model->select('*','users',['email'=>$email]);

                if(empty($user_arr)){
                    $insert_arr = array();
                    $insert_arr['username'] = $email_id;
                    $insert_arr['password'] = password_hash($this->randomPassword(), PASSWORD_DEFAULT);
                    $insert_arr['first_name'] = $first_name;
                    $insert_arr['last_name'] = $last_name;
                    $insert_arr['social_media_type'] = $social_media_type;
                    $insert_arr['email'] = $email_id;

                    $user_id = $this->Common_model->insert('users',$insert_arr);

                    if (!empty($user_id)){
                        $message = 'You are registered successfully and your password is '.$this->randomPassword();
                        $this->load->library('email');
                        $this->email->from($this->config->item("default_email_from"), "Atzcart");
                        $this->email->to($email_id);
                        $this->email->mailtype = "html";
                        $this->email->newline = "\r\n" ;
                        $this->email->subject('Email verification');
                        $this->email->message($message);
                        $this->email->send();
                        
                        $output["status"] = 1;
                        $output["message"] = 'User Registered Successfully';
                    }
                }else{
                   $output["status"] = 1;
                   $output["user_info"] = $user_arr[0];
                }

                $this->response($output, REST_Controller::HTTP_OK);
            }
        }
    
    
    function randomPassword() {
        $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
        $pass = array(); //remember to declare $pass as an array
        $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
        for ($i = 0; $i < 8; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }
        return implode($pass); //turn the array into a string
    }
	
}	