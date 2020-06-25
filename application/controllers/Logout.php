<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Logout extends CI_Controller 
{

    public function __construct() 
    {
        parent::__construct();
        $this->load->library("facebook");
    }

    public function index() 
    {
        $user_data = $this->session->all_userdata();

        foreach ($user_data as $key => $value) {
            if ($key != 'session_id' && $key != 'ip_address' && $key != 'user_agent' && $key != 'last_activity') {
                $this->session->unset_userdata($key);
            }
        }
        $this->session->sess_destroy();
        // $this->session->unset_userdata('access_token');
        // $this->facebook->destroy_session();	
        redirect('login');

    }
}
