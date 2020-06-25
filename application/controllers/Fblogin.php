<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Fblogin extends CI_Controller {

    function __construct()
    {
		parent::__construct();
    }

	public function index()
	{

        if($this->facebook->is_authenticated())
        {     

           $userProfile = $this->facebook->request('get', '/me?fields=id,first_name,last_name,picture,email,gender');
            
			if(!isset($userProfile['error']))
			{
				$fbdata = array();
				$fbdata['ulogin'] = TRUE;
				$fbdata['user_data'] = $userProfile;
				$this->session->set_userdata($fbdata);
				if($this->session->userdata('ulogin'))
				{
					echo "<pre>";
					print_r($_SESSION);
					exit;
				}
				else
				{
					echo 'Your custom error to login';
				}
			}
			else
			{
				$this->facebook->destroy_session();				
				redirect(base_url()."fblogin");
			}
        }
        else
        {
           $data['fburl'] = $this->facebook->login_url();
           $this->load->view('front/sign_in/sign_in', $data);
        }
		
	}

	public function profile()
	{
       redirect(base_url()."welcome");
	}

	public function logout()
	{
       session_destroy();
       $this->facebook->destroy_session();				
	   redirect(base_url()."fblogin");
	}
}