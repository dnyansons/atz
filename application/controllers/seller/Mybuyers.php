<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Mybuyers extends CI_Controller
{
    public function __construct() 
    {
        parent::__construct();
        if (!$this->session->userdata("user_logged_in") || $this->session->userdata("user_role")!="seller") {
            $error = "<div id='login-error' class='form-error notice notice-error'><span class='icon-notice icon-error'></span><span><strong>Error!</strong> Session timeout, relogin!. </span></div>";
            $this->session->set_flashdata("message", $error);
            redirect("login", "refresh");
        }
        $this->load->model("Users_model");
    }
    
    public function index()
    {
        $data["pageTitle"] = "My Buyers List";
        $this->load->view("user/buyers/list",$data);
    }
    
    public function ajax_list()
    {
        $seller = $this->session->userdata("user_id");
        $users = $this->Users_model->get_datatables_buyers($seller);

        $data = array();
        $no = $this->input->post('start');
        foreach ($users as $user) {
            $no++;
            $details = array();
            $details[] = $no;
            $details[] = $user->first_name . ' ' . $user->last_name;
            $details[] = $user->email;
            $details[] = $user->phone;
            $details[] = 'view';

            $data[] = $details;
        }

        $output = array(
            "draw" => $this->input->post('draw'),
            "recordsTotal" => $this->Users_model->count_all(),
            "recordsFiltered" => $this->Users_model->count_filtered($role_id),
            "data" => $data,
        );
        echo json_encode($output);
    }
    
}
