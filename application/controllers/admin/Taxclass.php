<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Taxclass extends CI_Controller 
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

        $this->load->model('Tax_class_model');
        $this->load->model('Categories_model');
        $this->load->model('Common_model');
		$this->load->library('Userpermission');

    }

    public function index() 
    {
        $this->load->view("admin/taxclass/list");
    }

    public function ajax_list() 
    {
        $columns = array(
            0 => 'tax_class_id',
            1 => 'tax_class_title',
            2 => 'country_name',
            3 => 'tax_class_rate',
            4 => 'tax_class_type',
            5 => 'status'
        );

        $limit = $this->input->post('length');
        $start = $this->input->post('start');
        $order = $columns[$this->input->post('order')[0]['column']];
        //$dir = $this->input->post('order')[0]['dir'];
        $dir ="desc";

        $totalData = $this->Tax_class_model->alltaxclass_count();

        $totalFiltered = $totalData;

        if (empty($this->input->post('search')['value'])) {
            $taxclass = $this->Tax_class_model->alltaxclass($limit, $start, $order, $dir);
        } else {
            $search = $this->input->post('search')['value'];

            $taxclass = $this->Tax_class_model->taxclass_search($limit, $start, $search, $order, $dir);

            $totalFiltered = $this->Tax_class_model->taxclass_search_count($search);
        }

        $data = array();
        if (!empty($taxclass)) {
            foreach ($taxclass as $tc) {
                $nestedData['tax_class_id'] = $tc->tax_class_id;
                $nestedData['tax_class_title'] = $tc->tax_class_title;
                $nestedData['country_name'] = $tc->country_name;
                $nestedData['tax_class_rate'] = $tc->tax_class_rate;
                $nestedData['tax_class_type'] = $tc->tax_class_type;
                $nestedData['status'] = $tc->status;
                $nestedData['action'] = '<a href="'.base_url().'admin/taxclass/update/'.$tc->tax_class_id.'" class="tabledit-edit-button btn btn-primary waves-effect waves-light btn-sm" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit"><i class="fa fa-pencil-square-o"></i></a>
                                                                <a href="'.base_url().'admin/taxclass/delete/'.$tc->tax_class_id.'" class="tabledit-delete-button btn btn-danger waves-effect waves-light btn-sm" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete"><i class="fa fa-trash"></i></a>';

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
            $categories_id=$this->input->post('categories_id');
            $country_id=$this->input->post('country_id');
            $tax_class_title=$this->input->post('tax_class_title');
            $tax_class_rate=$this->input->post('tax_class_rate');
            $tax_class_type=$this->input->post('tax_class_type');
            $tax_class_description=$this->input->post('tax_class_description');
            $tax_for=$this->input->post('tax_for');
            $status=$this->input->post('status');
            
            $data=array(
            "category_id"=>$categories_id,
            "country_id"=>$country_id,
            "tax_class_title"=>$tax_class_title,
            "tax_class_rate"=>$tax_class_rate,
            "tax_class_type"=>$tax_class_type,
            "tax_class_description"=>$tax_class_description,
            "tax_for"=>$tax_for,
            "status"=>$status
            );

            
            $result=$this->Tax_class_model->addData($data);


            if($result)
            {
                $message = "<div class='alert alert-success alert-dismissible'>
                        <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                        <strong>Success!</strong> Added successfully!.
                      </div>";
                $this->session->set_flashdata("message",$message);
                redirect(base_url()."admin/taxclass");
            }
            
        }

        else
        {
            $data['title']="Add Tax Class";
            $data['countries_list']=$this->Common_model->get_five_countries();
            $data['categories_list']=$this->Categories_model->get_categories();
            $this->load->view('admin/taxclass/create', $data);
        }


    }

    

    public function update($tax_class_id) // update 
    {
        
        if($_SERVER['REQUEST_METHOD']=="POST")
        {
            $categories_id=$this->input->post('categories_id');
            $country_id=$this->input->post('country_id');
            $tax_class_title=$this->input->post('tax_class_title');
            $tax_class_rate=$this->input->post('tax_class_rate');
            $tax_class_type=$this->input->post('tax_class_type');
            $tax_class_description=$this->input->post('tax_class_description');
            $tax_for=$this->input->post('tax_for');
            $status=$this->input->post('status');
            
            $data=array(
            "category_id"=>$categories_id,
            "country_id"=>$country_id,
            "tax_class_title"=>$tax_class_title,
            "tax_class_rate"=>$tax_class_rate,
            "tax_class_type"=>$tax_class_type,
            "tax_class_description"=>$tax_class_description,
            "tax_for"=>$tax_for,
            "status"=>$status
            );

            
            $result=$this->Tax_class_model->updateData($data, $tax_class_id);


            if($result)
            {
                $message = "<div class='alert alert-success alert-dismissible'>
                        <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                        <strong>Success!</strong> Updated successfully!.
                      </div>";
                $this->session->set_flashdata("message",$message);
                redirect(base_url()."admin/taxclass");
            }

            
        }

        else
        {
            $data['title']="Edit Tax Class";
            $data['countries_list']=$this->Common_model->get_five_countries();
            $data['tax_class_data']=$this->Tax_class_model->getData($tax_class_id);
            $data['categories_list']=$this->Categories_model->get_categories();
            //echo "<pre>";
            //print_r($data);exit;
            $this->load->view('admin/taxclass/edit', $data);
        }
        
    }


    public function delete($tax_class_id) // delete 
    {
        $result=$this->Tax_class_model->deleteData($tax_class_id);

        if($result)
        {
            $message = "<div class='alert alert-success alert-dismissible'>
                        <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                        <strong>Success!</strong> Deleted successfully!.
                      </div>";
                $this->session->set_flashdata("message",$message);
           redirect(base_url()."admin/taxclass");
        }

    }


}
