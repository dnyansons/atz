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
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->helper('captcha');
	$this->load->library('facebook');
	$this->load->library('google');
    }
    
    public function index() 
    {
        $array_items = array('mobile_otp' => '', 'temp_email' => '','temp_mobile'=>'');
        $this->session->unset_userdata($array_items);
        $this->session->set_userdata(["mobile_otp"=>"","temp_email"=>"", "temp_mobile"=>'']);
        $this->form_validation->set_error_delimiters('<p style="color:red" class="text-left">', '</p>');
        $this->form_validation->set_rules("first_name","First Name","required");
        $this->form_validation->set_rules("last_name","Last Name","required");
        $this->form_validation->set_rules('mobile_number', 'Mobile Number ','required|is_unique[users.phone]|regex_match[/^[0-9]{10}$/]',[
            "is_unique" => "This mobile is already registered"
        ]); //{10} for 10 digits number
        $this->form_validation->set_rules("password","Password","trim|required|callback_valid_password"); 
        $this->form_validation->set_rules("email","Email","required|is_unique[users.username]",[
        "is_unique" => "This email id is already registered"
        ]);
        //Password Check
        $rules = array([
                            'field' => 'password',
                            'label' => 'Password',
                            'rules' => 'callback_valid_password',
                        ]);
        if($this->form_validation->run()===false){
            $data["pageTitle"] = "Sign up - atzcart";
            $this->load->view("mobile/register_view");
        } else {
            
            $insertData = [
                                "country" => '99',
                                "first_name" => $this->input->post("first_name"),
                                "last_name" => $this->input->post("last_name"),
                                "username" => $this->input->post("email"),
                                "phone" => $this->input->post("mobile_number"),
                                "email" => $this->input->post("email"),
                                "password" => password_hash($this->input->post("password"),PASSWORD_DEFAULT),
                                "last_login_ip" => $this->input->ip_address(),
                                "status" => 1,
                            ];

            $this->session->set_userdata(["user_info"=>$insertData]);
               
            $otp = rand(100000,999999);
                        
            if($this->send_otp($otp,$insertData['phone'])){
                $this->session->set_userdata(["mobile_otp"=>$otp,"temp_email"=>$insertData['email'],"temp_mobile"=>$insertData['phone']]);
                $msg = '<div class="alert alert-success alert-dismissible">
                             <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                             <strong>Success!</strong> Send OTP.
                         </div>';
                $this->session->set_flashdata("message",$msg);
                redirect("register/verify_otp","refresh");
            }else {
                $msg = '<strong>Success!</strong> Indicates a successful or positive action.';
			$this->session->set_flashdata("message",$msg);
                        redirect("register","refresh");
            }
        }   
    }
    
    public function verify_otp() 
    {
        $this->form_validation->set_error_delimiters('<p style="color:red" class="text-center">', '</p>');
        $this->form_validation->set_rules("otp_txt","OTP","required",array("required"=>"Please enter OTP"));
        if($this->form_validation->run()===false){
            $this->load->view("mobile/otp_verify");
        }
        else{
           $otp = $this->input->post("otp_txt");
           $sess_otp = $this->session->userdata("mobile_otp");
             if($otp == $sess_otp){
                $this->session->set_userdata(["email_verified"=>true]);
                $user_info=$this->session->userdata("user_info");
                $user = $this->Users_model->add_user($user_info);
//                echo "<pre>";
//                print_r($user_info);die;
                $addressBook = [
                    "user_id" => $user,
                    "contact_person" => $user_info['first_name']." ".$user_info['last_name'],
                    "contact_number" => $user_info['phone'],
                    "country" => "99",
                    "is_default"=>"1"
                ];
                $this->Users_model->addAddressBook($addressBook);
                
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

                $email_prefferences = $this->Users_model->add_email_services($email_services);

                $insertPkg['pkg_id']=1;
                $insertPkg['user_id']=$user;
                $insertPkg['duration']=0;
                $insertPkg['status']='Active';
                $this->Common_model->insert('user_packages',$insertPkg);

                $companyData = [
                                "user_id" => $user,
                                "company_name" => $this->input->post("first_name"),
                                "primary_business_type" => "1"
                               ];

                $company = $this->Company_model->createCompany($companyData);

                $defaultInfo = [
                        "company_id" => $company
                ];
             
                $this->Company_model->addExportInfo($defaultInfo);
                $this->Company_model->addManufactureInfo($defaultInfo);
                $this->Company_model->addQcInfo($defaultInfo);
                $this->Company_model->addRndInfo($defaultInfo);
                
                //Welcome Messgae and Mail
                $name=$user_info['first_name'].' '.$user_info['last_name'];
                $email=$user_info['email'];
                $mob=$user_info['phone'];
                $msg="Dear Customers,
                      Thank you choosing ATZCart.com as your bulk ecommerce platform, Enjoy our seamless products and services for your requirements. Visit our site on www.atzcart.com or download our application from Google playstore and Apple appstore.";
                $this->welcome_mail($email,$name);
                $msg = '<div class="alert alert-success alert-dismissible">
                             <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                             <strong>Registered Successfully!</strong>.
                         </div>';
                $this->session->set_flashdata('message', $msg);
                $this->session->unset_userdata($user_info);
                redirect('signin');
                exit;	
                    
            } else {
                    $msg = '<div class="alert alert-danger alert-dismissible">
                             <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                             <strong>Error !</strong> Invalid OTP.
                         </div>';
                    $this->session->set_flashdata("message",$msg);
                    redirect("register/verify_otp","refresh");
            }
        }
     }
    
    function send_otp($otp=0,$mob=0)
    { 
         if($mob > 0) {
            $msg = urlencode("Dear user please use ".$otp." as your one time password verification code.");
            $ch=curl_init();
            curl_setopt($ch, CURLOPT_URL, "http://sms.smslab.in/api/sendhttp.php?authkey=271209AqkMbb4pSiXR5ca89dc7&mobiles=".$mob."&message=".$msg."&new&mobile&sender=ATZCRT&route=4");
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
            $res = curl_exec($ch);
            curl_close($ch);
           
            return true;
        } else {
            return false;
        }
    }
  
    function resend_otp($otp=0,$mob=0)
    { 
      $user_info= $this->session->userdata("user_info");
      $mob=$user_info["phone"];
      $otp = rand(100000,999999);
      $this->send_otp($otp,$mob);
      $this->session->set_userdata(["mobile_otp"=>$otp]);
      $msg = '<div class="alert alert-success alert-dismissible">
                             <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                             <strong> OTP Resend successfully </strong>   
                         </div>';
      $this->session->set_flashdata("message",$msg);
      redirect("register/verify_otp","refresh");
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
            if (preg_match_all($regex_uppercase, $password) < 1)
            {
                    $this->form_validation->set_message('valid_password', 'The {field} field must be at least one uppercase letter.');
                    return FALSE;
            }
            if (preg_match_all($regex_number, $password) < 1)
            {
                    $this->form_validation->set_message('valid_password', 'The {field} field must have at least one number.');
                    return FALSE;
            }
            if (preg_match_all($regex_special, $password) < 1)
            {
//                  $this->form_validation->set_message('valid_password', 'The {field} field must have at least one special character.' . ' ' . htmlentities('!@#$%^&*()\-_=+{};:,<.>~'));
                    $this->form_validation->set_message('valid_password', 'The {field} field must have at least one special character.');
                    return FALSE;
            }
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
        
	function welcome_mail($email,$name)
	{
            $data_email['email'] = $email;
            $data_name['name'] = $name;
            $data_email['up_date'] = date('Y-m-d H:i:s');
            $from_email = $this->config->item("default_email_from");
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
        
        
    function check()
    {
        echo "<pre>";
        print_r($_SESSION);
    }
}

?>