<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Policy extends CI_Controller 
{
    public function __construct() 
    {
        parent::__construct(); 
    }
	
    public function index() 
    {
		$this->load->view("mobile/privacy");
	}
	public function cookie() 
    {
		$this->load->view("mobile/cookie");
	}
	public function term() 
    {
		$this->load->view("mobile/term");
	}
}
   ?>     
								