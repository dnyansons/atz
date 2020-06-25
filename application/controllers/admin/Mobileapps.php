<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Mobileapps extends CI_Controller 
{
    public function __construct() 
    {
        parent::__construct();
        if (!$this->session->userdata("admin_logged_in")) {
            $error = "<div class='alert alert-danger alert-dismissible'>
                        <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                        <strong>Error!</strong> Session timeout, relogin!.
                      </div>";
            $this->session->set_flashdata("message", $error);
            redirect("admin/login", "refresh");
        }
        $this->load->library('Userpermission');
        $this->load->model("Apks_model","apks");
    }
    
    /**********************
     * Display history of android apks
     */
    public function index()
    {
        $data["apks"] = $this->apks->getList("android");
        $data["pageTitle"] = "Android apks";
        $this->load->view("admin/apks/list",$data);
    }
    
    /**********************
     * Display history of android apks
     */
    public function ios()
    {
        $data["apks"] = $this->apks->getList("ios");
        $data["pageTitle"] = "Ios apks";
        $this->load->view("admin/apks/list",$data);
    }
    
    public function getfeatues($id)
    {
        $output = [
            "status" => 0,
            "data" => ""
        ];
        $this->apks->getFeatures($this->input->post(""));
    }
}
