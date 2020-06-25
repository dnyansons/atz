<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Createaccount extends CI_Controller 
{
    public function __construct() 
    {
        parent::__construct();
        $this->load->model("Users_model");
        $this->load->model("Company_model");
        $this->load->model("Product_model");
        $this->load->model("Common_model");
        $this->load->model("Bank_model");
        $this->load->model("Categories_model");
        $this->load->library("Send_data");
        $this->load->library('Browser_notification');
    }
    
    public function index()
    {
	    $this->load->library("form_validation");
        $this->form_validation->set_rules("first_name","First Name","required");
        $this->form_validation->set_rules("last_name","last Name","required");
        $this->form_validation->set_error_delimiters('<p style="color:red" class="text-left">', '</p>');
        $this->form_validation->set_rules("password","Password","trim|required|callback_valid_password"); 

		$this->form_validation->set_rules("email","Email","required|valid_email|is_unique[users.username]",[
            "is_unique" => "This email id is already registered"
        ]);
		$this->form_validation->set_rules('phone', 'Mobile Number ', 'required|is_unique[users.phone]|regex_match[/^[0-9]{10}$/]',['regex_match'=>'Please Enter The Valid Mobile Number','is_unique'=>'This Mobile number is already registered' ]); //{10} for 10 digits number
        if($this->form_validation->run()===false){
            $data['title'] = "ATZCart - Create Account";
            $this->load->view("user/auth/create_account",$data);
        } else {
            $phone = $this->input->post("phone");
            $otp = rand(100000,999999);
            if($this->send_otp($otp, $phone)){
                $user_temp_data["userinfo"] = [
                    "usettemp_first_name" => $this->input->post("first_name"),
                    "usettemp_last_name" => $this->input->post("last_name"),
                    "usettemp_email" => $this->input->post("email"),
                    "usettemp_phone" => $phone,
                    "usettemp_password" => $this->input->post("password"),
                ];
                $temp_otp = [
                    "temp_otp" => $otp
                ];
                $reg_mob = [
                    "reg_mob" => $phone
                ];
                $this->session->set_userdata($user_temp_data);
                $this->session->set_userdata($temp_otp);
                $this->session->set_userdata($reg_mob);
                $this->session->mark_as_temp('temp_otp', 300);
                redirect("seller/createaccount/verify","refresh");
            } else {
                $msg = '<div class="alert alert-success alert-dismissible">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                            <strong>Success!</strong> Indicates a successful or positive action.
                        </div>';
                redirect("seller/createaccount","refresh");
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
    
    public function verify()
    {
		$this->load->library("form_validation");
		$this->form_validation->set_error_delimiters('<p style="color:red" class="text-left">', '</p>');
        $this->form_validation->set_rules("otp","otp","required");
        if($this->form_validation->run()===false){
            $data["title"] = "ATZart - Verify Mobile";
            $this->load->view("user/auth/verify_mobile",$data);
        } else {
            $otp = $this->input->post("otp");
            $sess_otp = $this->session->tempdata("temp_otp");
            if($otp == $sess_otp){
                $this->session->set_userdata(["otp_verified"=>true]);
                redirect("seller/createaccount/companyprofile","refresh");
            } else {
                $msg = '<div class="alert alert-danger alert-dismissible">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                            <strong>Error!</strong> Invalid Otp.
                        </div>';
				$this->session->set_flashdata('message',$msg);
                redirect("seller/createaccount/verify","refresh");
            }
        }
    }
    
    public function companyprofile()
    {
        $isVerifiedMobile = $this->session->userdata("otp_verified");
        if($isVerifiedMobile){
			$this->load->library("form_validation");
			$this->form_validation->set_error_delimiters('<p style="color:red" class="text-left">', '</p>');
            $this->form_validation->set_rules("company_name","Company Name","required");
            $this->form_validation->set_rules("company_type","Company Type","required");
            $this->form_validation->set_rules("product_category","Product Category","required");
            $this->form_validation->set_rules("pin_code","Pin Code","required");
            $this->form_validation->set_rules("address_line_1","Address","required");
            $this->form_validation->set_rules("country","Country","required");
            $this->form_validation->set_rules("state","State","required");
            $this->form_validation->set_rules("city","City","required");
            if($this->form_validation->run()===false){
				$data["title"] = "ATZCart - Create Company";
				
                $company_types = $this->Common_model->getAll("company_types")->result_array();
				$ct = array();
				foreach($company_types as $ct1):
				$ct[$ct1["id"]] = $ct1["name"];
				endforeach;	
				
				$data["company_types"] = $ct;
				$categories = $this->Categories_model->getFirstTwoLevelCategoriesData();
				$cat = array();
				foreach($categories as $ctg):
					$cat[$ctg["category_id"]] = $ctg["categories_name"];
				endforeach;	
				
				$data["categories"] = $cat;
                $states = $this->Common_model->getAll("states",["country_id"=>"101"])->result_array();
				$stat = array();
                                $stat[""] = "Select";
				foreach($states as $st):
					$stat[$st["name"]] = $st["name"];
				endforeach;	
				$data["states"] = $stat;
                $this->load->view("user/auth/createcompany",$data);
            } else {
                $company_temp_data["company_info"] = $this->input->post();
                $this->session->set_userdata($company_temp_data);
                $this->session->set_userdata(["company_added"=>true]);
                redirect("seller/createaccount/taxinfo","refresh");
            }
        } else {
            $msg = '<div class="alert alert-danger alert-dismissible">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        <strong>Error!</strong> Invalid Otp.
                    </div>';
            redirect("seller/createaccount/verify","refresh");
        }
    }
    
    public function taxinfo()
    {
        $isCompanyAdded = $this->session->userdata("company_added");
        if ($isCompanyAdded) {
            $this->load->library("form_validation");
            $this->form_validation->set_error_delimiters('<p style="color:red" class="text-left">', '</p>');
            $this->form_validation->set_rules("gst_no", "GST No", "required");
            $this->form_validation->set_rules("pan_type", "Pan Type", "required|in_list[personal,business]", [
                "in_list" => "invalid pan type"
            ]);
            $this->form_validation->set_rules("pan_no", "Pan No", "required");
            if ($this->form_validation->run() === false) {
                $data["title"] = "ATZCart - Add Tax info";
                $this->load->view("user/auth/taxinfo", $data);
            } else {

                 $userInfo = $this->session->userdata("userinfo");
                 $companyInfo = $this->session->userdata("company_info");
                 $insertData = [
                         "username" => $userInfo["usettemp_email"],
                         "password" => password_hash($userInfo["usettemp_password"],PASSWORD_DEFAULT),
                         "role" => "seller",
                        "first_name" => $userInfo["usettemp_first_name"],
                         "last_name" => $userInfo["usettemp_last_name"],
                         "email" => $userInfo["usettemp_email"],
                         "phone" => $userInfo["usettemp_phone"],
                         "address" => $companyInfo["address_line_1"],
                         "country" => $companyInfo["country"],
                         "gst_no" => $this->input->post("gst_no"),
                         "pan_type" => $this->input->post("pan_type"),
                         "pan_no" => $this->input->post("pan_no"),
                         "status" => 1,
                 ];                
                 $user = $this->Users_model->add_user($insertData);
                 $insertPkg = [
                     "pkg_id" => 1,
                     "user_id" => $user,
                     "duration" => 0,
                     "status" => "Active",
                 ];
                
                 $title='New Seller Joined';
                 $message=$userInfo["usettemp_first_name"]." ".$userInfo["usettemp_last_name"];
                 $tag=date('d M Y H:i');
                 $this->browser_notification->notifyadmin($title,$message,$tag);
                 
                 
                 //insert in adminnotify table
                $adminNotify = array(
                    'title' => 'New Seller Joined',
                    'msg' => 'Seller '. $message . ' ( Web ) ',
                    'type' => 'Seller_Registration',
                    'reference_id' => $user,
                    'status' => 'Received'
                );

                $insertAdminNotify = $this->Product_model->insertAdminNotify($adminNotify);

                                
                 $this->Common_model->insert('user_packages',$insertPkg);
                 $companyData = [
                     "user_id" => $user,
                     "company_name" => $companyInfo["company_name"],
                     "primary_business_type" => $companyInfo["company_type"],
                     "location_country" => "India",
                     "comp_operational_addr" => $companyInfo["address_line_1"],
                     "comp_operational_city" => $companyInfo["city"],
                     "comp_operational_state" => $companyInfo["state"],
                 ];
                 $companyInfo = [
                         "user_id" => $user,
                         "company_name" => $companyInfo["company_name"],
                         "company_type" => $companyInfo["company_type"],
                         "address1" => $companyInfo["address_line_1"],
                         "currency" => "INR",
                 ];
                 $company = $this->Company_model->createCompany($companyData);
                 $this->Users_model->addSellerInfo($companyInfo);
                 $defaultInfo = [
                         "company_id" => $company
                 ];
                 $this->Company_model->addExportInfo($defaultInfo);
                 $this->Company_model->addManufactureInfo($defaultInfo);
                 $this->Company_model->addQcInfo($defaultInfo);
                 $this->Company_model->addRndInfo($defaultInfo);
                 $session_data = array(
                         "user_logged_in" => TRUE,
                         "user_id" => $user,
                         "user_name" => $userInfo["usettemp_first_name"]." ".$userInfo["usettemp_last_name"],
                         "user_role" => "seller",
                         "user_currency" => "INR",
                         "user_email" => $userInfo["usettemp_email"],
                         "phone" => $userInfo["usettemp_phone"],
                     );
                 $this->session->set_userdata($session_data);
                 $this->session->set_userdata("userinfo",[]);
                 $this->session->set_userdata("company_info",[]);
                 $this->session->set_userdata("company_added",[]);
                 $this->session->set_userdata("otp_verified",[]);
                 $this->session->userdata("userinfo");
                 $this->session->set_userdata(["taxinfoadded"=>true,'user_id'=>$user]);
                 // redirect("seller/dashboard","refresh");
		          redirect("seller/createaccount/docs_verification");
            }
        } else {
            $msg = '<div class="alert alert-danger alert-dismissible">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        <strong>Error!</strong> Invalid Otp.
                    </div>';
            redirect("seller/createaccount/companyprofile", "refresh");
        }
    }

 

   /*
    *   Function for Document Verifications of seller registration
    *
    */
 
    function docs_verification()
    {
       $isTaxAdded= $this->session->userdata("taxinfoadded");
       $user_id= $this->session->userdata("user_id");
        $this->load->helper('file');

         if ($isTaxAdded) {
            $data['banks'] = $this->Bank_model->getBanks();
            $this->load->helper(array('form', 'url'));
            $this->load->library("form_validation");
            $this->load->library('awsupload');
            $this->form_validation->set_error_delimiters('<p style="color:red" class="text-left">', '</p>');
            // $this->form_validation->set_rules("user_type", "User Type", "required");
            // $this->form_validation->set_rules("user_type", "Name", "required|in_list[individual,business]", [
            //     "in_list" => "invalid user type"
            // ]);
            $this->form_validation->set_rules("user_type", "Name", "required");
           
             if ($this->form_validation->run() === false) {
                // echo "validation";
                $data["title"] = "ATZCart - Document Verification";
                $this->load->view("user/auth/docs_verification", $data);
            } else {

                 $userInfo = $this->session->userdata("userinfo");
                 $companyInfo = $this->session->userdata("company_info");
                 $userType=$this->input->post('user_type');
                 $files = $_FILES;
                 $filesCount = count($_FILES['pan_file']['name']);
                
                 $pandataInfo = array();
                 $gstdataInfo1 = array();
                 $file_array=array();
              
                  $this->load->library('upload');  
               
                $user_docs=array();
                $user_docs1=array();
               $docs_insert_id='';
               $TotalfilesCount=0;
               $pan_img_path='';
               $gst_img_path='';

               if($this->input->post('user_type')=='individual')
               {
                 
                 // for ($i = 0; $i < $filesCount; $i++) {

              
                  $pan_img_path=$this->awsupload->upload("pan_file",'uploads/company_docs','company_docs');
                  
                  $gst_img_path=$this->awsupload->upload("gst_file",'uploads/company_docs','company_docs');
                       
                  // }
                 if($pan_img_path==false || $gst_img_path==false)   
                 {
                     $msg = '<div class="alert alert-danger alert-dismissible">
                         <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                         <strong>Error!</strong> Invalid File Type Please Upload Only Jpeg | Jpg | Pdf Files.!
                         </div>';
                        $this->session->set_flashdata('message',$msg);
                        redirect("seller/createaccount/docs_verification", "refresh");
                        exit;
                 }
                 else
                 {
                      $user_docs=array(
                         'user_id'=>$user_id,   
                         'user_type'=>$this->input->post('user_type'),
                         'pan_img'=>$pan_img_path,
                         'user_name'=>$this->input->post('user_name'),
                         'pan_no'=>$this->input->post('pan_no'),
                         'gst_no'=>$this->input->post('gst_no'),
                         'gst_img'=>$gst_img_path,
                         'role_status'=>0,
                         'incorporate_certificate_no'=>'',
                         'document_verify_status'=>'',
                         'incorporate_certificate_no'=>'',
                         'user_role_type'=>$this->input->post('user_role'),
                         'user_role_name'=>$this->input->post('full_name'),
                         'user_role_panNo'=>$this->input->post('pan_no2'),
                         'user_role_address'=> $this->input->post('userrole_address'),
                         'user_role_email'=>$this->input->post('userrole_email'),
                         'user_role_phone'=> $this->input->post('userrole_phone'),
                        );

                      $this->db->insert('document_verify_tbl',$user_docs);
                   
                     $user_docs_bank=array(
                      'user_id'=>$user_id,    
                      'account_no'=>$this->input->post('bank_acc_no'),
                      'bank'=>$this->input->post('bank_acc_detail'),
                      'ifsc_code'=>$this->input->post('bank_ifsc'),
                      'account_holder_name'=>$this->input->post('user_name'),
                      'is_default'=>0

                     );
                        $this->db->insert('supplier_bank_details',$user_docs_bank);
                 }
               
           
               }
               else if($this->input->post('user_type')=='business')
               {

                  // for ($i = 0; $i < $filesCount; $i++) {
                $pan_img_path1='';
                $gst_img_path1='';       

                $TotalfilesCount=count($_FILES);


                $pan_img_path1=$this->awsupload->upload("pan_file1",'uploads/company_docs','company_docs');

                $gst_img_path1=$this->awsupload->upload("gst_file1",'uploads/company_docs','company_docs');
                  
                if($pan_img_path1==false || $gst_img_path1==false)
                  {
                         $msg = '<div class="alert alert-danger alert-dismissible">
                         <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                         <strong>Error!</strong> Invalid File Type.Please Upload Only Jpeg | Jpg | Pdf Files.!
                         </div>';
                        $this->session->set_flashdata('message',$msg);
                        redirect("seller/createaccount/docs_verification", "refresh");
                        exit;
                  }
                  else
                  {
                      $user_docs=array(
                         'user_id'=>$user_id,   
                         'user_type'=>$this->input->post('user_type'),
                         'pan_img'=>$pan_img_path1,
                         'user_name'=>$this->input->post('legal_name'),
                         'pan_no'=>$this->input->post('pan_no1'),
                         'gst_no'=>$this->input->post('gst_no1'),
                         'gst_img'=>$gst_img_path1,
                         'incorporate_certificate_no'=>$this->input->post('incorporation_no'),
                         'role_status'=>count($this->input->post('user_role')),
                         'document_verify_status'=>'',
                         'user_role_type'=>$this->input->post('user_role'),
                         'user_role_name'=>$this->input->post('full_name'),
                         'user_role_panNo'=>$this->input->post('pan_no2'),
                         'user_role_address'=> $this->input->post('userrole_address'),
                         'user_role_email'=>$this->input->post('userrole_email'),
                         'user_role_phone'=> $this->input->post('userrole_phone'),
                        );

                       $docs_insert_id=  $this->db->insert('document_verify_tbl',$user_docs);

                    $user_docs_bank1=array(
                      'user_id'=>$user_id,    
                      'account_no'=>$this->input->post('bank_acc_no1'),
                      'bank'=>$this->input->post('bank_acc_detail1'),
                      'ifsc_code'=>$this->input->post('bank_acc_ifsc1'),
                      'account_holder_name'=>$this->input->post('legal_name'),
                      'is_default'=>0

                     );
                      $this->db->insert('supplier_bank_details',$user_docs_bank1);
                  }

                     
               }
               $fileTitle='';
               if(!empty($files['pan_file']['name']) && !empty($files['gst_file']['name']))      
               {
                    $fileTitle='Pan Card Image'.' & '.'GST Image';
               }
               else if(!empty($files['pan_file1']['name']) && !empty($files['gst_file1']['name'])){

                    $fileTitle='Pan Card Image'.' & '.'GST Image';
               }

                $user_cmpy_docs=array(

                 'user_id'=>$user_id,
                 'title'=>$fileTitle,
                 'file_status'=>'',
                );

                // 
               $cmpy_doc_insert_id= $this->db->insert('company_documents',$user_cmpy_docs);
               $doc_insert_id='';
               $company_reult='';
               if($cmpy_doc_insert_id)  
               {
                    $doc_insert_id=$this->db->insert_id();
                 
                    if($this->input->post('user_type')=='individual')
                    {
                                             
                    $user_docs_file=array(

                             'company_document_title_id'=>$doc_insert_id,
                             'file'=>$user_docs['pan_img'],
                          );
                     
                     $company_reult=$this->db->insert('company_document_files',$user_docs_file);

                     $user_docs_file1=array(

                             'company_document_title_id'=>$doc_insert_id,
                             'file'=>$user_docs['gst_img'],
                            );
                      
                       $company_reult=$this->db->insert('company_document_files',$user_docs_file1);
                    }

                    else if($this->input->post('user_type')=='business')
                    {

                    
                    $user_docs_file2=array(

                                 'company_document_title_id'=>$doc_insert_id,
                                 'file'=>$user_docs['pan_img'],
                              );
                         
                     $company_reult=$this->db->insert('company_document_files',$user_docs_file2);

                    $user_docs_file3=array(

                                 'company_document_title_id'=>$doc_insert_id,
                                 'file'=>$user_docs['gst_img'],
                                );
                          
                    $company_reult=$this->db->insert('company_document_files',$user_docs_file3);

                    }
               }

                if($company_reult)
                {
                    $msg = '<div class="alert alert-success alert-dismissible">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        <strong>Success!</strong> Profile Created Successfully.!
                    </div>';
                    $this->session->set_flashdata('message',$msg);
                      redirect("seller/dashboard", "refresh");
                }
                else
                {
                    $msg = '<div class="alert alert-danger alert-dismissible">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        <strong>Error!</strong> Something Went Wrong.!
                    </div>';
                    $this->session->set_flashdata('message',$msg);
                    redirect("seller/createaccount/docs_verification", "refresh");

                }
                
            }

         }
         else
         {
            $msg = '<div class="alert alert-danger alert-dismissible">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        <strong>Error!</strong> Invalid TaxInfo.
                    </div>';
                    $this->session->set_flashdata('message',$msg);
            redirect("seller/createaccount/taxinfo", "refresh");
         }
    }

     /*
      @author Ishwar
     * This function check file extension during file file uploading
     */

     public function file_check($str){
        $allowed_mime_type_arr = array('application/pdf','image/jpeg','image/jpg','image/png');
        $mime = get_mime_by_extension($str);
        if(isset($str) && $str!=""){
            if(in_array($mime, $allowed_mime_type_arr)){
                return true;
            }else{

                 $msg= '<div class="alert alert-danger alert-dismissible">
                                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                    <strong>Error!</strong> Please select only pdf/jpg/png file.!
                                </div>';
            $this->session->set_flashdata('message',$msg);
            redirect('seller/createaccount/docs_verification/');
            // $this->form_validation->set_message('file_check', 'Please select only pdf/jpg/png file.');
                return false;
            }
        }else{

             $msg= '<div class="alert alert-danger alert-dismissible">
                                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                    <strong>Error!</strong> Please choose a file to upload gst.!
                                </div>';
             $this->session->set_flashdata('message',$msg);     
            redirect('seller/createaccount/docs_verification/');              
             // $this->form_validation->set_message('file_check', 'Please choose a file to upload.');
            return false;
        }
       
    }

    private function set_upload_options() {
            $config = array();
            $config['upload_path'] = './uploads/company_docs/';
            $config['allowed_types'] = 'jpg|png|jpeg|pdf';
            $config['max_size'] = '0';
            $config['overwrite'] = FALSE;
            return $config;
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
    
    function resend_otp()
    {
        $mob = $this->input->post('mob');
        $otp = rand(100000, 999999);
        if ($mob > 0 && $otp != '') {
            $msg = "Dear user please use " . $otp . " as your one time password verification code.";
            $temp_otp = [ "temp_otp" => $otp];
            $this->session->set_userdata($temp_otp);
            $this->send_data->send_sms($msg, $mob);

            echo '<div class="alert alert-success alert-dismissible">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close" style="margin-top: -1px;">&times;</a>
                    OTP Resent Successfully
                  </div>';
        }
    }




}
