<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Register extends CI_Controller 
{
    public function __construct() 
    {
        parent::__construct();
        $this->load->model('Common_model');
        $this->load->model('Company_model');
        $this->load->model('Users_model');
        $this->load->library('email');
        // $this->load->library('encrypt');
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->helper('captcha');
    }

    public function index() 
    {
        $data['action_url'] = '';
		$data["title"] = "ATZCart - Register";
		
        $this->load->view('user/auth/register',$data);
    }

    public function refresh() 
    {
        $config = array(
            'img_url' => base_url() . 'image_for_captcha/',
            'img_path' => 'image_for_captcha/',
            'img_height' => 50,
            'word_length' => 5,
            'img_width' => '150',
            'font_size' => 12
        );
        $captcha = create_captcha($config);
        $this->session->unset_userdata('valuecaptchaCode');
        $this->session->set_userdata('valuecaptchaCode', $captcha['word']);
        echo $captcha['image'];
    }

    function send_mail() 
    {
        $email = $this->input->post('email');
        $auth = $this->Common_model->getAll("users", array("email" => $email))->row_array();
        if (empty($auth)) {
            $data_email['email'] = $email;
            $data_email['up_date'] = date('Y-m-d H:i:s');
            $ch_in = $this->Common_model->getAll("email_verification", array("email" => $email))->row_array();
            if (empty($ch_in)) {
                $ID = $this->Common_model->insert('email_verification', $data_email);
            } else {
                $ID = $ch_in['id'];
            }
            $data['email'] = $email;
            $en_mail = urlencode($email);
			// shubham patil
			$id=(double)$ID*525325.24;
			$encrypted_id = base64_encode($id);
			/******************************/
            $data['verify_link'] = $encrypted_id;
            $from_email = "tstdev@atzcart.com";//$this->config->item("default_email_from");
            $to_email = $email;
            $mesg = $this->load->view('emailtemplates/verify_email', $data, true);
            $this->load->library('email');
            
            $this->email->set_mailtype("html");
            $this->email->set_newline("\r\n");
            $this->email->set_newline("\r\n");  
            $this->email->from($from_email);
            $this->email->to($to_email);
            $this->email->subject('User Register Verification  Email From ATZ Cart');
            $this->email->message($mesg);
            if ($this->email->send()) {
                $msg = "sent";
            } else {
                //echo $this->email->print_debugger();
                $msg = "notsent";
            }
        } else {
            $msg = "registered";
        }
        echo $msg;
    }

    function verify_email($dat) 
    {
        // shubham patil
		$url_id=base64_decode($dat);
		$email_dat=(double)$url_id/525325.24;
		
		/***********************************/
        $ch = $this->Common_model->getAll("email_verification", array("id" => $email_dat))->row_array();
        if (!empty($ch)) {
            $config = array(
                'img_url' => base_url() . 'uploads/captcha/',
                'img_path' => 'uploads/captcha/',
                'img_height' => 50,
                'word_length' => 5,
                'img_width' => '150',
                'font_size' => 12
            );
            $captcha = create_captcha($config);
            $this->session->unset_userdata('valuecaptchaCode');
            $this->session->set_userdata('valuecaptchaCode', $captcha['word']);
            
            $data['verify_email'] = 1;
            $this->Common_model->update("email_verification", $data, array("id" => $email_dat));
            $data['verified_email'] = $this->Common_model->getAll("email_verification", array("id" => $email_dat))->row_array();
            if ($data['verified_email']['verify_email'] == 1) {
                $data['captchaImg'] = $captcha['image'];
                $data['comp_type'] = $this->Common_model->getAll("company_types")->result_array();
                $data['action_url'] = base_url() . 'user/register/final_submit';
                //Get Geo Location Data 
                $dat1 = $this->geolocation();
                $data['url_id'] = $dat;
                $data['country'] = $dat1['location'];
                $data['country_code'] = $dat1['calling_code'];
                $data['flag'] = $dat1['flag'];
                $data['country']=$this->Common_model->getAll('country')->result_array();
                $this->load->view('user/auth/register', $data);
            } else {
                $msg = 'Email Not Verified !';
                $this->session->set_flashdata('message', $msg);
                redirect('user/register');
            }
        } else {
            $msg = 'Email Not Verified !';
            $this->session->set_flashdata('message', $msg);
            redirect('user/register');
        }
    }

    function final_submit() 
    {
        	$this->form_validation->set_rules("email","Email","required");
		$this->form_validation->set_rules("password","password","required");
		$this->form_validation->set_rules("country","country","required");
		$this->form_validation->set_rules("address1","address","required");
		$this->form_validation->set_rules("role","role","required");
		$this->form_validation->set_rules("first_name","First Name","required");
		$this->form_validation->set_rules("last_name","Last Name","required");
		$this->form_validation->set_rules("company_type","Company Type","required");
		$this->form_validation->set_rules("code","Country Code","required");
		$this->form_validation->set_rules("telephone","Contact No","required");
		
		//Password Check
		$rules = array(
				[
					'field' => 'password',
					'label' => 'Password',
					'rules' => 'callback_valid_password',
				],
				[
					'field' => 'cpassword',
					'label' => 'Confirm Password',
					'rules' => 'matches[password]',
				],
			);
                $this->form_validation->set_rules($rules);
		
		if($this->form_validation->run()===false){
			$msg = '<span style="color:red;">'.validation_errors().'</span>';
			$this->session->set_flashdata('message', $msg);
			redirect('user/register/verify_email/'.$this->input->post('url_id'));
			exit;
		} else {
			$email = $this->input->post("email");
			$ch = $this->Common_model->getAll("email_verification", array("email" => $email))->row_array();
			if($ch){
			    $captcha_insert = $this->input->post('captcha');
                            $contain_sess_captcha = $this->session->userdata('valuecaptchaCode');
                        if ($captcha_insert === $contain_sess_captcha) {
					$data = $this->input->post();
					$dat = $this->geolocation();
					$country_name = $dat['country_name'];
					$ch_curr = $this->Common_model->getAll("currency", array("country" => $country_name))->row_array();
					if (!empty($ch_curr)) {
						$data['currency'] = $ch_curr['code'];
					} else {
						$data['currency'] = 'INR';
					}

					$insertData = [
						"username" => $this->input->post("email"),
						"password" => password_hash($this->input->post("password"),PASSWORD_DEFAULT),
						"role" => $this->input->post("role"),
						"first_name" => $this->input->post("first_name"),
						"last_name" => $this->input->post("last_name"),
						"email" => $this->input->post("email"),
						"phone" => $this->input->post("telephone"),
						"address" => $this->input->post("address1"),
						"country" => $this->input->post("country"),
						"last_login_ip" => $this->input->post("email"),
						"last_login_ip" => $this->input->ip_address(),
						"status" => 1,
					];
                                        
                                        $role = $this->input->post("role");
                                        $first_name = $this->input->post('first_name');
                                        $last_name = $this->input->post('last_name');
					$user = $this->Users_model->add_user($insertData);
					
					
					//Add Free (Package ID 1) Package to Register User
					$insertPkg['pkg_id']=1;
					$insertPkg['user_id']=$user;
					$insertPkg['duration']=0;
					$insertPkg['status']='Active';
					$this->Common_model->insert('user_packages',$insertPkg);
					
					
					
                                        $notification_title = 'New Registration';
                                        $notification_msg = 'New '.$role.'.'.$first_name.' '.$last_name.' has joined ATZCart';
                                        $notification_type = 'Registration';
                                        $reference_id = $user;
                                        add_admin_notification($notification_title,$notification_msg,$notification_type,$reference_id);
                                        
					$email_services=[
						"user_id" => $user,
						"trade_alerts" => 1,
						"expos_trade" => 1,
						"service_instruction" => 1,
						"survey_invitations" =>1,
						"gold_membership" =>1,
						"brq_notifications" => 1,
						"connection_notification" => 1,
					];
					$companyData = [
						"user_id" => $user,
						"company_name" => $this->input->post("company_name"),
						"primary_business_type" => $this->input->post("company_type")
					];
					$companyInfo = [
						"user_id" => $user,
						"company_name" => $this->input->post("company_name"),
						"company_type" => $this->input->post("company_type"),
						"address1" => $this->input->post("address1"),
						"currency" => $data['currency'],
					];
					$email_prefferences = $this->Users_model->add_email_services($email_services);
					
					$company = $this->Company_model->createCompany($companyData);
					$this->Users_model->addSellerInfo($companyInfo);
					$defaultInfo = [
						"company_id" => $company
					];
					$this->Company_model->addExportInfo($defaultInfo);
					$this->Company_model->addManufactureInfo($defaultInfo);
					$this->Company_model->addQcInfo($defaultInfo);
					$this->Company_model->addRndInfo($defaultInfo);
					//Welcome Messgae and Mail
					$name=$this->input->post("first_name").' '.$this->input->post("last_name");
					$mob=$this->input->post("telephone");
					
					$msg="Dear Valuable Customers,
                                              Thank you choosing atzcart.com as your bulk ecommerce platform. Enjoy our seamless Products and Services for your Requirements. Visit Our Site on www.atzcart.com or Download our Mobile Application from Google Playstore and Apple Appstore.";
					$this->welcome_mail($email,$name);
					$this->send_sms($msg,$mob);
					$msg = 'Registered Successfully';
					$this->session->set_flashdata('message', $msg);
					redirect('user/');
					exit;
				} else {
					$msg = 'invalid captcha';
					$this->session->set_flashdata('message', $msg);
					redirect('user/register');
					exit;
				}	
			} else {
				$msg = 'Email Not Verified !';
                                $this->session->set_flashdata('message', $msg);
                                redirect('user/register');
				exit;
			}
		}
		
    }
	
	public function valid_password($password = '')
	{
		$password = trim($password);
		$regex_lowercase = '/[a-z]/';
		$regex_uppercase = '/[A-Z]/';
		$regex_number = '/[0-9]/';
		$regex_special = '/[!@#$%^&*()\-_=+{};:,<.>~]/';
		if (empty($password))
		{
			$this->form_validation->set_message('valid_password', 'The {field} field is required.');
			return FALSE;
		}
		if (preg_match_all($regex_lowercase, $password) < 1)
		{
			$this->form_validation->set_message('valid_password', 'The {field} field must be at least one lowercase letter.');
			return FALSE;
		}
		/*if (preg_match_all($regex_uppercase, $password) < 1)
		{
			$this->form_validation->set_message('valid_password', 'The {field} field must be at least one uppercase letter.');
			return FALSE;
		}*/
		if (preg_match_all($regex_number, $password) < 1)
		{
			$this->form_validation->set_message('valid_password', 'The {field} field must have at least one number.');
			return FALSE;
		}
		/*if (preg_match_all($regex_special, $password) < 1)
		{
			$this->form_validation->set_message('valid_password', 'The {field} field must have at least one special character.' . ' ' . htmlentities('!@#$%^&*()\-_=+{};:,<.>~'));
			return FALSE;
		}*/
		if (strlen($password) < 8)
		{
			$this->form_validation->set_message('valid_password', 'The {field} field must be at least 8 characters in length.');
			return FALSE;
		}
		if (strlen($password) > 32)
		{
			$this->form_validation->set_message('valid_password', 'The {field} field cannot exceed 32 characters in length.');
			return FALSE;
		}
		return TRUE;
	}
  

    function check_captcha() 
    {

        $captcha_insert = $this->input->post('captcha');
        $contain_sess_captcha = $this->session->userdata('valuecaptchaCode');
        if ($captcha_insert === $contain_sess_captcha) {
            echo 'match';
        } else {
            echo 'notmatch';
        }
    }

    function geolocation() 
    {
        $keyaccess = '1f10ab3315b24270cee15f90f588867c';
        $remote_address = $_SERVER['REMOTE_ADDR'];
        $url = file_get_contents("http://api.ipstack.com/" . $remote_address . "?access_key=$keyaccess");

        $curl = curl_init();
        // Set some options - we are passing in a useragent too here
        curl_setopt_array($curl, [
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL => 'http://api.ipstack.com/' . $remote_address . '?access_key=' . $keyaccess,
            CURLOPT_USERAGENT => 'Codular Sample cURL Request'
        ]);

        $resp = curl_exec($curl);
        curl_close($curl);
        $region = json_decode($resp, true);

        return $data = array("country_name" => $region['country_name'], "calling_code" => $region['location']['calling_code'], "location" => $region['country_name'], "flag" => $region['location']['country_flag']);
    }
	
	
	function welcome_mail($email,$name)
	{
		
        
            $data_email['email'] = $email;
            $data_name['name'] = $name;
            $data_email['up_date'] = date('Y-m-d H:i:s');
            
           
            $from_email =$this->config->item("default_email_from");
            $to_email = $email;
            $mesg = $this->load->view('emailtemplates/welcome', $data, true);
            $this->load->library('email');
            
            $this->email->set_mailtype("html");
            $this->email->set_newline("\r\n");
            $this->email->set_newline("\r\n");  
            $this->email->from($from_email);
            $this->email->to($to_email);
            $this->email->subject('Welcome to ATZ Cart !');
            $this->email->message($mesg);
            
        
	}
        
       
	
	
	//Send OTP Function
	function send_sms($message,$mob)
	{ 
			if($mob > 0)
			{
				$msg = urlencode($message);
				$ch=curl_init();
				curl_setopt($ch, CURLOPT_URL, "http://sms.smslab.in/api/sendhttp.php?authkey=271209AqkMbb4pSiXR5ca89dc7&mobiles=".$mob."&message=".$msg."&new&mobile&sender=ATZCRT&route=4");
				curl_setopt($ch, CURLOPT_HEADER, 0);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
				$res = curl_exec($ch);
				curl_close($ch);
				
			}
			
	}
	

    function sons2() 
    {
        $keyaccess = '1f10ab3315b24270cee15f90f588867c';
        $remote_address = $_SERVER['REMOTE_ADDR'];
        $url = file_get_contents("http://api.ipstack.com/" . $remote_address . "?access_key=$keyaccess");

        $curl = curl_init();
        // Set some options - we are passing in a useragent too here
        curl_setopt_array($curl, [
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL => 'http://api.ipstack.com/' . $remote_address . '?access_key=' . $keyaccess,
            CURLOPT_USERAGENT => 'Codular Sample cURL Request'
        ]);

        $resp = curl_exec($curl);
        curl_close($curl);
        $region = json_decode($resp, true);
        echo'<pre>';
        print_r($region);
    }
    
    public function checkemail() 
    {
        ini_set("max_execution_time", 300); 
        
        $config["protocol"]="smtp";
        $config["smtp_host"]="atzcart.com";
        $config["smtp_port"]="465";
        $config["smtp_timeout"]="30";
        $config["smtp_user"]="tstdev@atzcart.com";
        $config["smtp_pass"]="testdev123#@";
        $config["charset"]="utf-8";
        $config["newline"]="\r\n";
        $config["wordwrap"] = TRUE;
        $config["mailtype"] = "html";
        
        
        $email_config = Array(
            'protocol'  => 'smtp',
            'smtp_host' => 'atzcart.com',
            'smtp_port' => '587',
            'smtp_user' => 'tstdev@atzcart.com',
            'smtp_pass' => 'testdev123#@',
            'mailtype'  => 'html',
            'starttls'  => true,
            'newline'   => "\r\n"
        );
        
        $this->load->library("email",$email_config);
        
        //$this->email->initialize($config);
        $this->email->from("no-reply@atzcart.com", "Atzcart");
        $this->email->to("bharatgodam@ayninfotech.com");
        $this->email->subject("Notification Mail");
        $this->email->message("Your message");
        if($this->email->send()){
            echo $this->email->print_debugger();
        } else {
            echo "asdfasdfasdf ";
            echo $this->email->print_debugger();
        }
        echo "test";
            
    }

}
