<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Signout extends CI_Controller 
{
    public function __construct() 
    {
        parent::__construct();
		$this->load->library('facebook');
		$this->load->library('google');
    }
    
    public function index() 
    {
        $user_data = $this->session->all_userdata();
		
        foreach ($user_data as $key => $value) {
            if ($key != 'session_id' && $key != 'ip_address' && $key != 'user_agent' && $key != 'last_activity') {
                $this->session->unset_userdata($key);
            }
        }
		// Destroy entire session data
        $this->session->sess_destroy();
		
		$this->facebook->logout_url();	

		// Remove local Facebook session
		$this->facebook->destroy_session();
		
		// Remove user data from session
		$this->session->unset_userdata($session_data);
		
		// Reset OAuth access token
		//$this->google->revokeToken();
		
		// Remove token and user data from the session
        //$this->session->unset_userdata('loggedIn');
        $this->session->unset_userdata($socialgoogleData);		
        redirect();
    }
}
