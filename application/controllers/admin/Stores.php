<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Stores extends CI_Controller 
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
        $this->load->model('Stores_model');
        $this->load->model('Products_model');
		 $this->load->library('Userpermission');
    }

    public function index() 
    {
        $data["pageTitle"] = "Admin || Suppliers list";
        $this->load->view("admin/users/storelist", $data);
    }

    public function ajax_list() 
    {
        $columns = array(
            0 => 'retailers_id',
            1 => 'retailers_email_address',
            2 => 'retailers_telephone',
        );

        $limit = $this->input->post('length');
        $start = $this->input->post('start');
        $order = $columns[$this->input->post('order')[0]['column']];
        //$dir = $this->input->post('order')[0]['dir'];
        $dir ="desc";

        $totalData = $this->Stores_model->allstore_count();

        $totalFiltered = $totalData;

        if (empty($this->input->post('search')['value'])) {
            $stores = $this->Stores_model->allstore($limit, $start, $order, $dir);
        } else {
            $search = $this->input->post('search')['value'];

            $stores = $this->Stores_model->store_search($limit, $start, $search, $order, $dir);

            $totalFiltered = $this->Stores_model->store_search_count($search);
        }

        $data = array();
        if (!empty($stores)) {
            foreach ($stores as $store) {
                $nestedData['id'] = $store->retailers_id;
                $nestedData['name'] = $store->retailers_firstname . " " . $stores->retailers_lastname;
                $nestedData['email'] = $store->retailers_email_address;
                $nestedData['telephone'] = $store->retailers_telephone;
                $nestedData['created'] = $store->date_created;
                $nestedData['action'] = "<a class='btn btn-link' href='" . site_url() . "admin/stores/view/" . $store->retailers_id . "'>view</a>";


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

    public function view($store_id = 0) 
    {
        if ($store_id == 0) {
            $error = "<div class='alert alert-danger alert-dismissible'>
                <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                <strong>Error!</strong> Please select supplier.
            </div>";
            $this->session->set_flashdata("message", $error);
            redirect("admin/stores", "refresh");
        } else {
            $data["stores"] = $this->Stores_model->getUserById($store_id);
            $data["products"] = $this->Products_model->getProductsByManufacture($supplier_id);
            $this->load->view("admin/users/supplierdetails", $data);
        }
    }
}
