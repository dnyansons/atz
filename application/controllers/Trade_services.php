<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Trade_services extends CI_Controller {

    public function __construct() {
        parent::__construct();
		$this->load->library("get_header_data");

    }
	
	public function index()
	{
		$data = $this->get_header_data->get_categories();
		$data["title"] = "ATZCart - Trade Assurance";
		$this->load->view('front/trade_services/trade_assurance',$data);
		
	}
	
	public function logistic_service()
	{
		$data = $this->get_header_data->get_categories();
		$data["title"] = "ATZCart - Logistic Services";
		$this->load->view('front/trade_services/logistic_service',$data);
	}
        
        public function affiliateMarketing() {
                $data = $this->get_header_data->get_categories();
                $data["title"] = "ATZCart - Affiliate Market";
                $this->load->view('affiliate/affiliateMarket',$data);
        }
}