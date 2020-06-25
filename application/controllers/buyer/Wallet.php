<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Wallet extends CI_Controller 
{

    public function __construct() 
    {
        parent::__construct();
        $this->load->library('session');
        if (!$this->session->userdata("user_logged_in")) {
            $error = "<div id='login-error' class='form-error notice notice-error'><span class='icon-notice icon-error'></span><span><strong>Error!</strong> Session timeout, relogin!. </span></div>";
            $this->session->set_flashdata("message", $error);
            redirect("login", "refresh");
        }
        $this->load->model('Wallet_model');
        $this->load->model('Common_model');
        // $this->load->model('Wallet_model');
        $this->load->library("get_header_data");
        $this->load->library("browser_notification");
    }

    public function index() 
    {
        $user_id = $this->session->userdata('user_id');
        $data = $this->get_header_data->get_categories();
        $data["title"] = "Wallet history";
        //get Withdraw Request
        $data['withdraw_req'] = $this->Wallet_model->get_wallet_request($user_id);
        $data['bal']=$this->Common_model->getAll('buyer_wallet',array('user_id'=>$user_id))->row();
        $this->load->view('front/myaccount/wallet',$data);
    }
	
    public function get_wallets()
    {
        $user_id = $this->session->userdata('user_id');
        $result = $this->Wallet_model->get_wallet_history($user_id);
        echo json_encode($result);
    }
	
    function request_amount()
    {
        $user_id = $this->session->userdata('user_id');
		$check_bank_details = $this->Common_model->getAll('buyer_bank_details',array('user_id'=>$user_id))->num_rows();
	
		if($check_bank_details > 0)
		{
			$req_amount=$this->input->post('req_amt');
			$bal=$this->Common_model->getAll('buyer_wallet',array('user_id'=>$user_id))->row();
			if($req_amount <=$bal && $bal > 0 && $req_amount > 0)
			{
				$ch_pending=$this->Common_model->getAll('buyer_withdraw_request',array('user_id'=>$user_id,'status'=>'Pending'))->num_rows();
				if($ch_pending==0)
				{
					$dat['user_id']=$user_id;
					$dat['amount']=$req_amount;
					$dat['status']='Pending';
					$this->Common_model->insert('buyer_withdraw_request',$dat);
					$this->request_notify();
					echo 1;
				}else
				{
					echo 'Already Your Withdraw Request is in Pending !';
				}
			}
			else
			{
				echo 'Not Sufficent Amount to Withdraw !';
			}
		}else{
			echo 'Please Add Bank Details!';
		}
    }
        
    function request_notify() {
        $msg='New Withdraw Request from Buyer !';
        $tag=date('d M Y');
        $this->browser_notification->notifyadmin('Withdraw Request', $msg, $tag);
    }
    
    public function check($id = 0) 
    {
        $user_id = $id;
        $data = $this->get_header_data->get_categories();
        $data["title"] = "Wallet history";
        //get Withdraw Request
        $data['withdraw_req'] = $this->Wallet_model->get_wallet_request($user_id);
        $data['bal']=$this->Common_model->getAll('buyer_wallet',array('user_id'=>$user_id))->row();
        $this->load->view('front/myaccount/wallet',$data);
        //echo "<pre>";
        //print_r($data);
        $this->output->enable_profiler(true);
    }
}