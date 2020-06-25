<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class HelpCenter extends CI_Controller 
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
        $this->load->model('HelpCenter_model');
        $this->load->library('form_validation');
		$this->load->library('Userpermission');
    }

    public function index() 
    {
        
        $this->load->view("admin/helpcenter/list");
        
    }

    public function ajax_list() 
	{
        $result = $this->HelpCenter_model->getTitlesList();
        $this->output->set_output(json_encode($result));
    }

    public function addTitle() 
    {
        $this->form_validation->set_rules("title","Title","required");
		$this->form_validation->set_rules("parent_category","Parent","required");
        if($this->form_validation->run()===false){
            $data["pageTitle"] = "Add Title";
			$data['result'] = $this->HelpCenter_model->getTitles();
            $this->load->view("admin/helpcenter/add",$data);
        } else {
			
				$insertData = [
                    "title" => $this->input->post("title"),
					"parent" => $this->input->post("parent_category"),
					"description" => $this->input->post("description"),
                    "added_date" => date("Y-m-d H:i:s"),
					"updated_date" => date("Y-m-d H:i:s")
                ];
                $result = $this->HelpCenter_model->add_title($insertData);
				  $success = "<div class='alert alert-success alert-dismissible'>
						<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
						<strong>Success!</strong> Successfully Added!.
					  </div>";
				$this->session->set_flashdata("message",$success);
                redirect("admin/HelpCenter/addTitle","refresh");
            }
    }
	
	public function editTitles($id) 
    {
        $this->form_validation->set_rules("title","Title","required");
		$this->form_validation->set_rules("parent_category","Parent","required");
        if($this->form_validation->run()===false){
            $data["pageTitle"] = "Add Sub Title";
			$data['titles'] = $this->HelpCenter_model->getTitles();
			 $data['result'] = $this->HelpCenter_model->getTitlesIdwise($id);

            $this->load->view("admin/helpcenter/edit",$data);
        } else {
			
				$updateData = [
                    "title" => $this->input->post("title"),
					"parent" => $this->input->post("parent_category"),
                    "updated_date" => date("Y-m-d H:i:s"),
                ];
                  $result = $this->HelpCenter_model->updateTitle($updateData,$id);
				  $success = "<div class='alert alert-success alert-dismissible'>
						<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
						<strong>Success!</strong> Successfully Updated!.
					  </div>";
				$this->session->set_flashdata("message",$success);
                redirect("admin/HelpCenter","refresh");
            }
    }
	
    public function forseller() 
    {
        $this->load->view("admin/helpcenter/helpseller");
    }

    public function ajax_list_for_seller() 
	{
        $result = $this->HelpCenter_model->getTitlesListOfSeller();
        $this->output->set_output(json_encode($result));
    }
	
	public function addTitleofSeller() 
    {
        $this->form_validation->set_rules("title","Title","required");
		$this->form_validation->set_rules("parent_category","Parent","required");
        if($this->form_validation->run()===false){
            $data["pageTitle"] = "Add Title";
			$data['result'] = $this->HelpCenter_model->getTitlesOfSeller();
            $this->load->view("admin/helpcenter/addtitlesofseller",$data);
        } else {
			
				$insertData = [
                    "title" => $this->input->post("title"),
					"parent" => $this->input->post("parent_category"),
					"description" => $this->input->post("description"),
                    "added_date" => date("Y-m-d H:i:s"),
					"updated_date" => date("Y-m-d H:i:s")
                ];
                $result = $this->HelpCenter_model->add_titleOfSeller($insertData);
				  $success = "<div class='alert alert-success alert-dismissible'>
						<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
						<strong>Success!</strong> Successfully Added!.
					  </div>";
				$this->session->set_flashdata("message",$success);
                redirect("admin/HelpCenter/addTitleofSeller","refresh");
            }
    }
	
	public function editTitlesOfSeller($id) 
    {
        $this->form_validation->set_rules("title","Title","required");
		$this->form_validation->set_rules("parent_category","Parent","required");
        if($this->form_validation->run()===false){
            $data["pageTitle"] = "Add Sub Title";
			$data['titles'] = $this->HelpCenter_model->getTitlesOfSeller();
			 $data['result'] = $this->HelpCenter_model->getTitlesOfSellerIdwise($id);

            $this->load->view("admin/helpcenter/editTitlesOfSeller",$data);
        } else {
			
				$updateData = [
                    "title" => $this->input->post("title"),
					"parent" => $this->input->post("parent_category"),
                    "updated_date" => date("Y-m-d H:i:s"),
                ];
                  $result = $this->HelpCenter_model->updateTitleofSeller($updateData,$id);
				  $success = "<div class='alert alert-success alert-dismissible'>
						<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
						<strong>Success!</strong> Successfully Updated!.
					  </div>";
				$this->session->set_flashdata("message",$success);
                redirect("admin/HelpCenter/forseller","refresh");
            }
    }
	  
}
