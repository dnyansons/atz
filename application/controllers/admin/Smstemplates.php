<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Smstemplates extends CI_Controller 
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
        $this->load->model("Smstemplate_model");
        $this->load->helper("form");
        $this->load->library("form_validation");
    }
    
    public function index()
    {
        $this->form_validation->set_rules("name","name","required");
        $this->form_validation->set_rules("template","template","required");
        if($this->form_validation->run()===false){
            $data["pageTitle"] = "Sms Templates";
            $data["cats"] = $this->Smstemplate_model->getTemplateNames();
            $this->load->view("admin/sms/update",$data);
        } else {
            $name = $this->input->post("name");            
            $data["template"] = $this->input->post("template");            
            $this->Smstemplate_model->updateTemplate($name,$data);
            $error = "<div class='alert alert-success alert-dismissible'>
                        <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                        <strong>Success!</strong> Selected template updated!.
                      </div>";
            $this->session->set_flashdata("message", $error);
            redirect("admin/Smstemplates", "refresh");
        }
        
    }
    
    public function ajaxGet()
    {
        $output = [
            "status" => false,
            "message" => "Unable to fetch",
            "data" => "",
        ];
        $this->form_validation->set_rules("name","name","required");
        if($this->form_validation->run()===false){
            echo json_encode($output);
        } else {
            $name = $this->input->post("name");
            $data = $this->Smstemplate_model->getTemplateByName($name);
            if($data){
                $output["status"] = true;
                $output["message"] = "template data fetched successfully!";
                $output["data"] = $data->template;
                echo json_encode($output);
            } else {
                echo json_encode($output);
            }
            
        }
    }
}
