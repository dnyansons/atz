<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Units extends CI_Controller 
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
        $this->load->model('Units_model');
        $this->load->model('adminusers_model', 'adminusers_model');
        $this->load->library('Userpermission');
    }

    public function index() 
    {
        $this->load->view("admin/units/list");
    }

    public function ajax_list() 
    {
        $columns = array(
            0 => 'units_id',
            1 => 'units_name',
            3 => 'date_added'
        );

        $limit = $this->input->post('length');
        $start = $this->input->post('start');
        $order = $columns[$this->input->post('order')[0]['column']];
        //$dir = $this->input->post('order')[0]['dir'];
        $dir ="desc";

        $totalData = $this->Units_model->allunits_count();

        $totalFiltered = $totalData;

        if (empty($this->input->post('search')['value'])) {
            $units = $this->Units_model->allunits($limit, $start, $order, $dir);
        } else {
            $search = $this->input->post('search')['value'];

            $units = $this->Units_model->units_search($limit, $start, $search, $order, $dir);

            $totalFiltered = $this->Units_model->units_search_count($search);
        }

        $data = array();
        if (!empty($units)) {
            foreach ($units as $un) {
                $nestedData['units_id'] = $un->units_id;
                $nestedData['units_name'] = $un->units_name;
                $nestedData['date_added'] = date('d:m:Y', strtotime($un->date_added));
                $nestedData['action'] = '<a href="'.base_url().'admin/units/updateunits/'.$un->units_id.'" class="tabledit-edit-button btn btn-primary waves-effect waves-light btn-sm" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit"><i class="fa fa-pencil-square-o"></i></a>
                                                                <a href="'.base_url().'admin/units/deleteunits/'.$un->units_id.'" class="tabledit-delete-button btn btn-danger waves-effect waves-light btn-sm" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete"><i class="fa fa-trash"></i></a>';

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


    public function addUnits() // add Units
    {
        
        
        if($_SERVER['REQUEST_METHOD']=="POST")
        {
            $units_name=$this->input->post('units_name');

            $data=array(
            "units_name"=>$units_name
            );

            $result=$this->Units_model->addUnitsData($data);

            if($result)
            {
                redirect(base_url()."admin/units");
            }
            
        }

        else
        {
            $data['title']="Add Units";

            $this->load->view('admin/common/header', $data);
            $this->load->view('admin/units/create');
            $this->load->view('admin/common/footer');
        }


    }

    

    public function updateUnits($units_id) // update Units
    {
        

        if($_SERVER['REQUEST_METHOD']=="POST")
        {
            
            $units_name=$this->input->post('units_name');

            $data=array(
            "units_name"=>$units_name
            );

            
            $result=$this->Units_model->updateUnitsData($data, $units_id);


            if($result)
            {
                redirect(base_url()."admin/units");
            }

            
        }

        else
        {
            $data['title']="Edit Units";
            $data['units_data']=$this->Units_model->getUnitsData($units_id);
            $this->load->view('admin/common/header', $data);
            $this->load->view('admin/units/edit', $data);
            $this->load->view('admin/common/footer');
        }
        
    }


    public function deleteUnits($units_id) // delete units
    {
        $result=$this->Units_model->deleteUnitsData($units_id);

        if($result)
        {
           redirect(base_url()."admin/units");
        }

    }


}
