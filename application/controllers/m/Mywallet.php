<?php
class Mywallet extends CI_Controller
{
    public function __construct() 
    {
        parent::__construct();
        if (!$this->session->userdata("user_logged_in")) {
            redirect("signin", "refresh");
        }
        $this->load->model('Wallet_model');
        $this->load->library("pagination");
    }
    
    public function index()
    {
        $user_id = $this->session->userdata('user_id');
        $data["title"] = "My Wallet";
        $data['transactions'] = $this->Wallet_model->get_wallet_history($user_id);
        $bal=$this->Common_model->getAll('buyer_wallet',array('user_id'=>$user_id))->row();
        $data['balance'] = $bal->balance??0;
        $data['wallet_hists'] = $this->Wallet_model->get_wallet_request($user_id,10);
        $this->load->view("mobile/wallet/default",$data);
    }
    
    public function withdraw()
    {
        $user_id = $this->session->userdata('user_id');
        $this->form_validation->set_rules("amount","Amount","required|numeric");
        $this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>');
        $bal=$this->Common_model->getAll('buyer_wallet',array('user_id'=>$user_id),"DESC","created")->row();
        if($this->form_validation->run()===false){
            $data["title"] = "Withdraw";
            $data['balance'] = $bal->balance??0;
            $this->load->view("mobile/wallet/withdraw",$data);
        } else {
            
            $check_bank_details = $this->Common_model->getAll('buyer_bank_details',array('user_id'=>$user_id))->num_rows();
            if($check_bank_details > 0) 
            {
                $req_amount=$this->input->post("amount");
                if($req_amount<=$bal->balance && $bal->balance > 0 && $req_amount > 0 ){
                    
                    $ch_pending=$this->Common_model->getAll('buyer_withdraw_request',array('user_id'=>$user_id,'status'=>'Pending'))->num_rows();
                    if($ch_pending==0) {
                        $amount = $this->input->post("amount");
                        $dat['user_id']=$user_id;
                        $dat['amount']=$amount;
                        $dat['status']='Pending';
                        $dat['created_at']=date('Y-m-d H:i:s');
                        $dat['updated_at']=date('Y-m-d H:i:s');
                        $this->Common_model->insert('buyer_withdraw_request',$dat);
                        $success = "<div class='alert alert-success alert-dismissible fade show' role='alert'>"
                                . "Request submitted"
                                . "<button type='button' class='close' data-dismiss='alert' aria-label='Close'>"
                                . "<span aria-hidden='true'>&times;</span>"
                                . "</button>"
                                . "</div>";
                        $this->session->set_flashdata('message',$success);
                        redirect("mywallet/withdraw","refresh");
                    } else {
                        $error = "<div class='alert alert-warning alert-dismissible fade show' role='alert'>"
                                . "Already Your Withdraw Request is in Pending !"
                                . "<button type='button' class='close' data-dismiss='alert' aria-label='Close'>"
                                . "<span aria-hidden='true'>&times;</span>"
                                . "</button>"
                                . "</div>";
                        $this->session->set_flashdata('message',$error);
                        redirect("mywallet/withdraw","refresh");
                    }  
                }else{
                    $error = "<div class='alert alert-danger alert-dismissible fade show' role='alert'>"
                                . "You Do Not Have Sufficient Amount in Your Wallet !"
                                . "<button type='button' class='close' data-dismiss='alert' aria-label='Close'>"
                                . "<span aria-hidden='true'>&times;</span>"
                                . "</button>"
                                . "</div>";
                        $this->session->set_flashdata('message',$error);
                        redirect("mywallet/withdraw","refresh");
                }
            }else{
                $error = "<div class='alert alert-danger alert-dismissible fade show' role='alert'>"
                                . "Please Add Bank Details! <a href='".base_url()."m/bank' ><b style='color:blue'>Click here</b></a>"
                                . "<button type='button' class='close' data-dismiss='alert' aria-label='Close'>"
                                . "<span aria-hidden='true'>&times;</span>"
                                . "</button>"
                                . "</div>";
                        $this->session->set_flashdata('message',$error);
                        redirect("mywallet/withdraw","refresh");
            }
        }
    }
}
