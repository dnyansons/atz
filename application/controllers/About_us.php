<?php
/****/
defined('BASEPATH') OR exit('No direct script access allowed');

class About_us extends CI_Controller {

    public function __construct() {
        parent::__construct();
		$this->load->library("get_header_data");
    }
	
	public function index()
	{
		$data = $this->get_header_data->get_categories();
		$data['title'] = 'ATZCart - About us';
		$this->load->view("front/about/about",$data);
	}
	
}