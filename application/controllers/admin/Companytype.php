<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class CompanyType extends CI_Controller 
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
        $this->load->library("Datatables");
        $this->load->library('table');
        $this->load->model('Companytype_model');
        $this->load->model('adminusers_model', 'adminusers_model');
        $this->load->library('Userpermission');
    }

    public function index() 
    {
        $this->load->view("admin/companytype/list");
    }
	
    public function ajax_list() 
    {
        $columns = array(
            0 => 'id',
            1 => 'company_type',
            2 => 'date_added',
            3 => 'date_modified',
        );

        $limit = $this->input->post('length');
        $start = $this->input->post('start');
        $order = $columns[$this->input->post('order')[0]['column']];
        //$dir = $this->input->post('order')[0]['dir'];
        $dir ="desc";

        $totalData = $this->Companytype_model->allcompany_count();

        $totalFiltered = $totalData;

        if (empty($this->input->post('search')['value'])) {
            $company = $this->Companytype_model->allcompany($limit, $start, $order, $dir);
        } else {
            $search = $this->input->post('search')['value'];

            $company = $this->Companytype_model->company_search($limit, $start, $search, $order, $dir);

            $totalFiltered = $this->Companytype_model->company_search_count($search);
        }

        $data = array();
        if (!empty($company)) {
            foreach ($company as $comp) {
                $nestedData['id'] = $comp->id;
                $nestedData['company_type'] = $comp->name;
                $nestedData['date_added'] = date('d:m:Y', strtotime($comp->date_added));
                $nestedData['date_modified'] = date('d:m:Y', strtotime($comp->date_modified));
                $nestedData['action'] = '<a href="'.base_url().'admin/companytype/updatecompanytype/'.$comp->id.'" class="tabledit-edit-button btn btn-primary waves-effect waves-light btn-sm" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit"><i class="fa fa-pencil-square-o"></i></a>
                                                                <a href="'.base_url().'admin/companytype/deletecompanytype/'.$comp->id.'" class="tabledit-delete-button btn btn-danger waves-effect waves-light btn-sm" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete"><i class="fa fa-trash"></i></a>';

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
	
	public function addCompanyType()
	{
		if($_SERVER['REQUEST_METHOD']=="POST")
		{
			$company_type=$this->input->post('company_type');
			
			$company_type_data=array(
			
			"name"=>$company_type,
			"date_added"=>date('Y-m-d H:i:s'),
			"date_modified"=>date('Y-m-d H:i:s'),
			
			);
			
			$this->Companytype_model->addCompanyData($company_type_data, $id);
                        $message = "<div class='alert alert-success alert-dismissible'>
                                    <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                                    <strong>Success!</strong> Company Type Added Successfully.
                                    </div>";
                        $this->session->set_flashdata("message", $message);
			redirect(base_url()."admin/companytype");
		}
		
		else
	    {
		    $data['title']="Add Company Type";
            $admin_username=$this->session->userdata('admin_username');
            $data['admin_data']=$this->adminusers_model->getUserByUsername($admin_username);

            $this->load->view('admin/common/header', $data);
			$this->load->view('admin/common/sidebar');
            $this->load->view("admin/companytype/create");
            $this->load->view('admin/common/footer');
		    
		}
		
	}
	
	public function updateCompanyType($id)
	{
		if($_SERVER['REQUEST_METHOD']=="POST")
		{
			$company_type=$this->input->post('company_type');
			
			$company_type_data=array(
			
			"name"=>$company_type,
			"date_modified"=>date('Y-m-d H:i:s'),
			
			);
			
			$this->Companytype_model->updateCompanyData($company_type_data, $id);
                         $message = "<div class='alert alert-success alert-dismissible'>
                                    <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                                    <strong>Success!</strong> Company Type Updated Successfully.
                                    </div>";
                        $this->session->set_flashdata("message", $message);	
			
			redirect(base_url()."admin/companytype");
		}
		
		else
	    {
		    $data['title']="Edit Company Type";
            $admin_username=$this->session->userdata('admin_username');
            $data['admin_data']=$this->adminusers_model->getUserByUsername($admin_username);
	   	
	    $data['companytype_data']=$this->Companytype_model->getCompanyTypeData($id);
            $this->load->view('admin/common/header', $data);
	    $this->load->view('admin/common/sidebar');
            $this->load->view("admin/companytype/edit",$data);
            $this->load->view('admin/common/footer');
		    
		}
	}
	
	public function deleteCompanyType($id)
	{
		$result=$this->Companytype_model->deleteCompanyData($id);
		
		if($result)
        {
           $message = "<div class='alert alert-success alert-dismissible'>
                                    <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                                    <strong>Success!</strong> Company Type Deleted Successfully.
                                    </div>";
            $this->session->set_flashdata("message", $message);         
           redirect(base_url()."admin/companytype");
        }
	}
	
}