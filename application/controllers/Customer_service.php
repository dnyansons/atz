<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Customer_service extends CI_Controller {

    public function __construct() {
        parent::__construct();
		$this->load->library("get_header_data");
		$data = $this->get_header_data->get_categories();
		$this->data = $data;
		$this->load->model('HelpCenter_model');
    }
	
	
	public function index()
	{
		$data = $this->data;
		$data['title'] = 'ATZCart - HelpCeller';
		$this->load->view('front/customer_services/help_center',$data);

	}
	
	public function get_titles()
	{
		$parent_title = $this->HelpCenter_model->getAllTitles();
		$data['subTitles'] = $this->HelpCenter_model->getAllsubTitles($parent_title[0]['id']);
		$data['parent_title'] = $parent_title;
		echo json_encode($data);
	}
	
	public function ajxgetSubtitles($id)
	{
		$sub_title = $this->HelpCenter_model->getAllsubTitles($id);
		$this->output->set_output(json_encode($sub_title));
	}
	
	public function getDesciption($id)
	{
		$data = $this->data;
		$data['description'] = $this->HelpCenter_model->getdescription($id);
		echo json_encode($data);
	}
	
	public function Contact_us()
	{
		$this->load->view('front/customer_services/contact_us',$this->data);
	}
	
	
	public function submit_dispute()
	{
		$data = $this->data;
		$data['title'] = 'ATZCart - Submit Dispute';
		$this->load->view('front/customer_services/submit_dispute',$data);
	}
	
		
	public function policies_rules()
	{
		$data = $this->data;
		$data['title'] = 'ATZCart - Policies & Rules';
		$this->load->view('front/customer_services/policies_rules',$data);
	}
	
		
	public function for_supplier()
	{
		$data = $this->data;
		$data['title'] = 'ATZCart - HelpSeller';
		$this->load->view('front/customer_services/for_supplier',$data);
	}

	public function ajax_get_titles()
	{
		$parent_title = $this->HelpCenter_model->getAllTitlesOfSeller();
		$data['subTitles'] = $this->HelpCenter_model->getAllsubTitlesofSeller($parent_title[0]['id']);
		$data['parent_title'] = $parent_title;
		echo json_encode($data);
	}
	
	public function ajxgetSubtitlesOfSeller($id)
	{
		$sub_title = $this->HelpCenter_model->getAllsubTitlesofSeller($id);
		$this->output->set_output(json_encode($sub_title));
	}
	
	public function getDesciptionOfSeller($id)
	{
		$data['description'] = $this->HelpCenter_model->getDesciptionOfSeller($id);
		echo json_encode($data);
	
	}
	
	public function new_user()
	{
		$data = $this->data;
		$data['title'] = 'ATZCart - For New User';
		$this->load->view('front/customer_services/new_user',$data);
	}
	
}