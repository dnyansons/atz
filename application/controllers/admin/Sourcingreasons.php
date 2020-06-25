<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class SourcingReasons extends CI_Controller 
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

        $this->load->model('Sourcing_reason_model');
		 $this->load->library('Userpermission');

    }

    public function index() 
    {
        $this->load->view("admin/sourcingreasons/list");
    }

    public function ajax_list() 
    {
        $columns = array(
            0 => 'reason_id',
            1 => 'reason_name'
        );

        $limit = $this->input->post('length');
        $start = $this->input->post('start');
        $order = $columns[$this->input->post('order')[0]['column']];
        //$dir = $this->input->post('order')[0]['dir'];
        $dir ="desc";

        $totalData = $this->Sourcing_reason_model->allsourcingreasons_count();

        $totalFiltered = $totalData;

        if (empty($this->input->post('search')['value'])) {
            $sourcing = $this->Sourcing_reason_model->allsourcingreasons($limit, $start, $order, $dir);
        } else {
            $search = $this->input->post('search')['value'];

            $sourcing = $this->Sourcing_reason_model->sourcingreason_search($limit, $start, $search, $order, $dir);

            $totalFiltered = $this->Sourcing_reason_model->sourcingreason_search_count($search);
        }

        $data = array();
        if (!empty($sourcing)) {
            foreach ($sourcing as $src) {
                $nestedData['reason_id'] = $src->reason_id;
                $nestedData['reason_name'] = $src->reason_name;
                $nestedData['action'] = '<a href="'.base_url().'admin/sourcingreasons/update/'.$src->reason_id.'" class="tabledit-edit-button btn btn-primary waves-effect waves-light btn-sm" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit"><i class="fa fa-pencil-square-o"></i></a>
                                                                <a href="'.base_url().'admin/sourcingreasons/delete/'.$src->reason_id.'" class="tabledit-delete-button btn btn-danger waves-effect waves-light btn-sm" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete"><i class="fa fa-trash"></i></a>';

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


    public function add() // add category
    {
        
        if($_SERVER['REQUEST_METHOD']=="POST")
        {
            $reason_name=$this->input->post('reason_name');
            
            $data=array(
            "reason_name"=>$reason_name,
            );

            
            $result=$this->Sourcing_reason_model->addData($data);


            if($result)
            {
                $error = "<div class='alert alert-success alert-dismissible'>
                        <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                        <strong>Success!</strong> Added successfully.
                      </div>";
                $this->session->set_flashdata("message",$error);
                redirect(base_url()."admin/sourcingreasons");
            }
            
        }

        else
        {
            $data['title']="Add Sourcing Reasons";
            $this->load->view('admin/sourcingreasons/create');
        }


    }

    

    public function update($reason_id) // update 
    {
        
        if($_SERVER['REQUEST_METHOD']=="POST")
        {

            $reason_name=$this->input->post('reason_name');
            
            $data=array(
            "reason_name"=>$reason_name,
            );

            
            $result=$this->Sourcing_reason_model->updateData($data, $reason_id);


            if($result)
            {
                $error = "<div class='alert alert-success alert-dismissible'>
                        <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                        <strong>Success!</strong> Updated successfully.
                      </div>";
                $this->session->set_flashdata("message",$error);
                redirect(base_url()."admin/sourcingreasons");
            }

            
        }

        else
        {
            $data['title']="Edit Sourcing Reason";
            $data['sourcing_reasons_data']=$this->Sourcing_reason_model->getData($reason_id);
            $this->load->view('admin/sourcingreasons/edit', $data);
        }
        
    }


    public function delete($reason_id) // delete 
    {
        $result=$this->Sourcing_reason_model->deleteData($reason_id);

        if($result)
        {
            $error = "<div class='alert alert-success alert-dismissible'>
                    <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                    <strong>Success!</strong> Deleted successfully.
              </div>";
           redirect(base_url()."admin/sourcingreasons");
        }

    }


}
