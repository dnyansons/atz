<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }
	
	public function index()
	{
		$this->load->view("usersPages/users");
	}
	
	public function b2b()
	{
		$this->load->view("usersPages/b2b");
	}
	
	public function small_busy_hacks()
	{
		$this->load->view("usersPages/small_busi_hacks");
	}
	
	public function tips_for_new_users()
	{
		$this->load->view("usersPages/tips_for_new_users");
	}
	
	public function tips_user2()
	{
		$this->load->view("usersPages/tips_user2");
	}
	
	public function tips_user3()
	{
		$this->load->view("usersPages/tips_user3");
	}
	
	public function trade_assurance()
	{
		$this->load->view("usersPages/trade_assurance");
	}
	
	public function new_feeds()
	{
		$this->load->view("usersPages/new_feeds");
	}
	
	public function atz_success()
	{
		$this->load->view("usersPages/atz_success");
	}
	
	public function buyer_story()
	{
		$this->load->view("usersPages/buyer_story");
	}
	
	public function buyer_success()
	{
		$this->load->view("usersPages/buyer_success");
	}
}