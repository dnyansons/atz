<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Googlelogin extends CI_Controller {
    function __construct()
    {
        parent::__construct();
        $this->load->library('google');
    }

    public function index()
    {
        $data['google_login_url']=$this->google->get_login_url();
        $this->load->view('front/sign_in/sign_in', $data);
    }

    public function oauth2callback()
    {
        $google_data=$this->google->validate();
		echo "<pre>";
		print_r($google_data);
		exit;
        $session_data=array(
                'name'=>$google_data['name'],
                'email'=>$google_data['email'],
                'source'=>'google',
                'profile_pic'=>$google_data['profile_pic'],
                'link'=>$google_data['link'],
                'birthday'=>$google_data['birthday'],
                'gender'=>$google_data['gender'],
                'sess_logged_in'=>1
                );
        $this->session->set_userdata($session_data);
        redirect(base_url()."googlelogin");
    }
    

    public function logout()
    {
        // Reset OAuth access token
        //$this->google->revokeToken();
        session_destroy();
        unset($_SESSION['access_token']);
        $session_data=array(
                'sess_logged_in'=>0);
        $this->session->set_userdata($session_data);
        redirect(base_url()."googlelogin");
    }
}
