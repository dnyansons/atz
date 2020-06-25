<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Shippingmethods extends CI_Controller 
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
		 $this->load->library('Userpermission');
        $this->load->model('Shipping_model');

    }

    public function index() 
    {
        $this->load->view("admin/shipping_methods/list");
    }

    public function ajax_list() 
    {
        $columns = array(
            0 => 'shipping_method_id',
            1 => 'shipping_method_name',
            2 => 'weight_range',
            3 => 'dimension_range',
            4 => 'date_added',
            5 => 'date_modified'
        );

        $limit = $this->input->post('length');
        $start = $this->input->post('start');
        $order = $columns[$this->input->post('order')[0]['column']];
        //$dir = $this->input->post('order')[0]['dir'];
        $dir ="desc";

        $totalData = $this->Shipping_model->allshippingmethods_count();

        $totalFiltered = $totalData;

        if (empty($this->input->post('search')['value'])) {
            $shipping = $this->Shipping_model->allshippingmethods($limit, $start, $order, $dir);
        } else {
            $search = $this->input->post('search')['value'];

            $shipping = $this->Shipping_model->shippingmethod_search($limit, $start, $search, $order, $dir);

            $totalFiltered = $this->Shipping_model->shippingmethod_search_count($search);
        }

        $data = array();
        if (!empty($shipping)) {
            foreach ($shipping as $shm) {
                $nestedData['shipping_method_id'] = $shm->shipping_method_id;
                $nestedData['shipping_method_name'] = $shm->shipping_method_name;
                $nestedData['weight_range'] = $shm->weight_range;
                $nestedData['dimension_range'] = $shm->dimension_range;
                $nestedData['date_added'] = date('d:m:Y', strtotime($shm->date_added));
                $nestedData['date_modified'] = date('d:m:Y', strtotime($shm->date_modified));
                $nestedData['action'] = '<a href="'.base_url().'admin/shippingmethods/update/'.$shm->shipping_method_id.'" class="tabledit-edit-button btn btn-primary waves-effect waves-light btn-sm" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit"><i class="fa fa-pencil-square-o"></i></a>
                                                                <a href="'.base_url().'admin/shippingmethods/delete/'.$shm->shipping_method_id.'" class="tabledit-delete-button btn btn-danger waves-effect waves-light btn-sm" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete"><i class="fa fa-trash"></i></a>';

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
            $shipping_method_name=$this->input->post('shipping_method_name');
            $weight_range=$this->input->post('weight_range');
            $dimension_range=$this->input->post('dimension_range');
			
            $data=array(
               "shipping_method_name"=>$shipping_method_name,
               "weight_range"=>$weight_range,
               "dimension_range"=>$dimension_range,
               "date_added"=>date('Y-m-d H:i:s'),
               "date_modified"=>date('Y-m-d H:i:s')
            );

            
            $result=$this->Shipping_model->addData($data);


            if($result)
            {
                $message = "<div class='alert alert-success alert-dismissible'>
                                    <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                                    <strong>Success!</strong> Shipping Method Added Successfully.
                                    </div>";
                
                $this->session->set_flashdata("message", $message);
                redirect(base_url()."admin/shippingmethods");
            }
            
        }

        else
        {
            $data['title']="Add Shipping Method";
            $this->load->view('admin/shipping_methods/create');
        }


    }

    

    public function update($shipping_method_id) // update category
    {
        if($_SERVER['REQUEST_METHOD']=="POST")
        {
            $shipping_method_name=$this->input->post('shipping_method_name');
            $weight_range=$this->input->post('weight_range');
            $dimension_range=$this->input->post('dimension_range');
            
            $data=array(
               "shipping_method_name"=>$shipping_method_name,
               "weight_range"=>$weight_range,
               "dimension_range"=>$dimension_range,
               "date_modified"=>date('Y-m-d H:i:s')
            );

            $result = $this->Shipping_model->updateData($data, $shipping_method_id);

            if($result)
            {
               redirect(base_url()."admin/shippingmethods");
            }

        }
        else
        {
            $data['title'] = "Edit Shipping Method";
            $data['shipping_method_data'] = $this->Shipping_model->getData($shipping_method_id);
            $this->load->view('admin/shipping_methods/edit', $data);
        }
        
    }


    public function delete($shipping_method_id) // delete category
    {
        $result=$this->Shipping_model->deleteData($shipping_method_id);

        if($result)
        {
           redirect(base_url()."admin/shippingmethods");
        }

    }


}
