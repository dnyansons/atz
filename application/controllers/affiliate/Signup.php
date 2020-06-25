<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * affiliate sign up.
 * 
 * @package affiliate marketing.
 * @version PHP 7.1 20190909.
 * @author shubham patil <shubhampatil@ayninfotech.com>
 * @see http://atzcart/affiliate/signup
 */
class Signup extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model("Affiliate_model");
        $this->load->library("get_header_data");
        $this->load->library('form_validation');
        $this->load->library('browser_notification');
        if ($this->session->userdata("affiliateLogin")) {
            redirect("affiliate/affiliate", "refresh");
        }
    }

    public function index() {
      
        $this->form_validation->set_error_delimiters('<p style="color:red" class="text-left">', '</p>');
        $this->form_validation->set_rules("email", "Email", "required|valid_email|is_unique[affiliate_login.username]", ["is_unique" => "This email id is already registered"]);
        $this->form_validation->set_rules('mobilenumber', 'Mobile Number ', 'required|is_unique[affiliate_login.mobileno]|regex_match[/^[0-9]{10}$/]', ['regex_match' => 'Please Enter The Valid Mobile Number', 'is_unique' => 'This Mobile number is already registered']); //{10} for 10 digits number
        $this->form_validation->set_rules('companyname','Company Name',"required");
        $this->form_validation->set_rules('fullname','Full Name',"required");
        $this->form_validation->set_rules('password','Password',"trim|required");
        $this->form_validation->set_rules('confirmpassword', 'Confirm Password', 'required|matches[password]');
        
        // Site validation
        $this->form_validation->set_rules('sitename','Site Name',"required");
        $this->form_validation->set_rules('siteurl','Site URL',"required");
        
        // payment validation
        $this->form_validation->set_rules('benfryname','Beneficiary Name',"required");
        $this->form_validation->set_rules('accno','Account Number',"required");
        $this->form_validation->set_rules('bankname','Bank Name',"required");
        $this->form_validation->set_rules('ifsccode','IFSC Code',"required");
        

        if ($this->form_validation->run() === false) {
            $data = $this->get_header_data->get_categories();
            $data["pageTitle"] = "Sign up - Affiliate Marketing";
            $this->load->view('affiliate/signupAffiliate',$data);
        } else {
            
               $affilliateData = [
                    "username" => htmlentities($this->input->post("email")),
                    "password" => password_hash($this->input->post("password"), PASSWORD_DEFAULT),
                    "fullname" => htmlentities($this->input->post("fullname")),
                    "mobileno" => $this->input->post("mobilenumber"),
                    "companyname" => htmlentities($this->input->post("companyname")),
                    "sitename" => htmlentities($this->input->post("sitename")),
                    "url" => htmlentities($this->input->post("siteurl")),
                ];
               
           $affiliateUser = $this->Affiliate_model->addAffiliate($affilliateData); // insert affiliate data into affiliate_login table.
           if($affiliateUser)
           {
               $affilliatePaymentDetails = [
                    "affid" => $affiliateUser,
                    "beneficiaryname" => htmlentities($this->input->post("benfryname")),
                    "accno" => htmlentities($this->input->post("accno")),
                    "bankname" => htmlentities($this->input->post("bankname")),
                    "ifscno" => htmlentities($this->input->post("ifsccode")),
                ];
               $result = $this->Affiliate_model->addAffiliateBankData($affilliatePaymentDetails); // insert affiliate Bank Details into affiliate_bank table.
                
                $this->send_email($affiliateUser);
                
                $todays_date = date("Y-m-d");
                $msg = "-" . $this->input->post("fullname") . " on date ". $todays_date;
                $tag = 'atzcart.com';
                
                $this->browser_notification->notifyadmin('New Affiliate !', $msg, $tag);
                $adminNotify = array(
                    'title' => 'New Affiliate',
                    'msg' => $msg . ' ( Web ) ',
                    'type' => 'Affiliate',
                    'reference_id' => "",
                    'status' => 'Received'
                );
               $insertAdminNotify = $this->Product_model->insertAdminNotify($adminNotify);
               
               redirect("affiliate/signup/Success", "refresh");
           }
        }
    }
    
    public function Success()
    {
        $data = $this->get_header_data->get_categories();
        $data["pageTitle"] = "Sign up - Affiliate Marketing";
        $this->load->view('affiliate/success',$data);
    }
    
    function send_email($affiliateId) {
        
        $data = $this->Affiliate_model->getAffiliateDataById($affiliateId);
        
        $from = $this->config->item("default_email_from");
        $to = trim($data->username);

        $mesg = $this->load->view('emailtemplates/signupTemplate','',true);
        $this->load->library('email');
        $config = array(
            'charset' => 'utf-8',
            'wordwrap' => TRUE,
            'mailtype' => 'html'
        );
        $config['protocol'] = 'smtp';
        $config['smtp_host'] = 'smtp-relay.gmail.com';
        $config['smtp_user'] = 'support@atzcart.com';
        $config['smtp_pass'] = 'asdfghjklQWE123@';
        $config['smtp_port'] = 587;
        $config['smtp_crypto'] = 'tls';
        $this->email->initialize($config);
        $this->email->set_newline("\r\n");
        $this->email->from($from, 'Atzcart');
        $this->email->to($to);
        $this->email->subject('Welcome - ATZCart Affiliate Program');
        $this->email->message($mesg);
        $this->email->send();
    }
    
    public function termsConditions()
    {
        $data = $this->get_header_data->get_categories();
        $data["pageTitle"] = "Sign up - Terms & Conditions";
        $this->load->view('affiliate/termsConditions',$data);
    }
}
