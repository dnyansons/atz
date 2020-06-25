<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Collections extends CI_Controller 
{
    public function __construct() 
    {
        parent::__construct();
		if(! $this->session->userdata("admin_logged_in")){
            $error = "<div class='alert alert-danger alert-dismissible'>
                        <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                        <strong>Error!</strong> Session timeout, relogin!.
                      </div>";
            $this->session->set_flashdata("message",$error);
            redirect("admin/login","refresh");
        }
        $this->load->model('Collections_model');
		$this->load->library("form_validation");
		 $this->load->library('Userpermission');
    }

    public function index() 
    {
		$data["pageTitle"] = "Admin || Collections";
        $this->load->view("admin/collections/list",$data);
    }

    public function ajax_list() 
    {
        $columns = array(
            0 => 'id',
            1 => 'name',
            2 => 'description',
        );

        $limit = $this->input->post('length');
        $start = $this->input->post('start');
        $order = $columns[$this->input->post('order')[0]['column']];
        //$dir = $this->input->post('order')[0]['dir'];
        $dir ="desc";

        $totalData = $this->Collections_model->collections_count();

        $totalFiltered = $totalData;

        if (empty($this->input->post('search')['value'])) {
            $collections = $this->Collections_model->allcollections($limit, $start, $order, $dir);
        } else {
            $search = $this->input->post('search')['value'];

            $collections = $this->Collections_model->collections_search($limit, $start, $search, $order, $dir);

            $totalFiltered = $this->Collections_model->collections_search_count($search);
        }

        $data = array();
        if (!empty($collections)) {
            foreach ($collections as $col) {
                $nestedData['id'] = $col->id;
                $nestedData['name'] = $col->name;
                $nestedData['description'] = $col->description;
                $nestedData['created_at'] = date('d-m-Y', strtotime($col->created));
                $nestedData['action'] = '<button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-cog" aria-hidden="true"></i></button>
				<div class="dropdown-menu dropdown-menu-right b-none contact-menu">
					<a class="dropdown-item" href="'.site_url("admin/collections/update/").$col->id.'"><i class="icofont icofont-edit"></i>Edit</a>
					<a class="dropdown-item" href="#!"><i class="icofont icofont-ui-delete"></i>Delete</a>
				</div>';

                $data[] = $nestedData;
            }
        }

        $json_data = array(
            "draw" => intval($this->input->post('draw')),
            "recordsTotal" => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data" => $data
        );

        echo json_encode($json_data);
    }
	
	public function create()
	{
		$this->form_validation->set_rules("name","Name","required");
		$this->form_validation->set_rules("description","Description","required");
		$this->form_validation->set_rules("meta_title","Meta Title","required");
		$this->form_validation->set_rules("meta_descriptions","Meta Description","required");
		$this->form_validation->set_rules("meta_keywords","Meta Keywords","required");
		$data["pageTitle"] = "Admin || Create collection";
		if($this->form_validation->run()===false){
			$this->load->view("admin/collections/create",$data);
		} else {
			$insertData = array(
				"name" => $this->input->post("name"),
				"description" => $this->input->post("description"),
				"meta_title" => $this->input->post("meta_title"),
				"meta_description" => $this->input->post("meta_descriptions"),
				"meta_keywords" => $this->input->post("meta_keywords"),
			);
			$this->Collections_model->addCollection($insertData);
			$error = "<div class='alert alert-success alert-dismissible'>
					<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
					<strong>Success!</strong> collection created successfully.
				  </div>";
			$this->session->set_flashdata("message",$error);
			redirect("admin/collections","refresh");
		}
	}
	
	public function update($id = 0)
	{
		if($id == 0) {
			$error = "<div class='alert alert-danger alert-dismissible'>
					<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
					<strong>Error!</strong> Please select valid collection first.
				  </div>";
			$this->session->set_flashdata("message",$error);
			redirect("admin/collections","refresh");
			exit();
		} 
		$this->form_validation->set_rules("name","Name","required");
		$this->form_validation->set_rules("description","Description","required");
		$this->form_validation->set_rules("meta_title","Meta Title","required");
		$this->form_validation->set_rules("meta_descriptions","Meta Description","required");
		$this->form_validation->set_rules("meta_keywords","Meta Keywords","required");
		$data["pageTitle"] = "Admin || Create collection";
		$data["id"] = $id;
		$data["collection"] = $this->Collections_model->getCollectionById($id);
		if($this->form_validation->run()===false){
			$this->load->view("admin/collections/update",$data);
		} else {
			$insertData = array(
				"name" => $this->input->post("name"),
				"description" => $this->input->post("description"),
				"meta_title" => $this->input->post("meta_title"),
				"meta_description" => $this->input->post("meta_descriptions"),
				"meta_keywords" => $this->input->post("meta_keywords"),
			);
			if($this->Collections_model->updateCollection($id,$insertData)){
				$message = "<div class='alert alert-success alert-dismissible'>
					<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
						<strong>Success!</strong> collection updated successfully.
					  </div>";
				$this->session->set_flashdata("message",$message);
				redirect("admin/collections","refresh");	
			} else {
				$message = "<div class='alert alert-danger alert-dismissible'>
					<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
						<strong>Error!</strong> Unable to update.
					  </div>";
				$this->session->set_flashdata("message",$message);
				redirect("admin/collections","refresh");
			}
			
		}	
	
		
	}
}
