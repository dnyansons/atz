<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Role extends CI_Controller 
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
        $this->load->library("Datatables");
        $this->load->library('table');
        $this->load->model('Role_model');
        $this->load->model('Common_model');
        $this->load->model('adminusers_model', 'adminusers_model');
        $this->load->library('Userpermission');
    }

    public function index() 
    {
        $this->load->view("admin/role/list");
    }

    public function ajax_list() 
    {
        
        $columns = array(
            0 => 'role_id',
            1 => 'role_name',
            2 => 'status',
            3 => 'created_at',
            4 => 'updated_at',
        );

        $limit = $this->input->post('length');
        $start = $this->input->post('start');
        $order = $columns[$this->input->post('order')[0]['column']];
        //$dir = $this->input->post('order')[0]['dir'];
        $dir = "desc";

        $totalData = $this->Role_model->allrole_count();

        $totalFiltered = $totalData;

        if (empty($this->input->post('search')['value'])) {
            $user_per = $this->Role_model->allrole($limit, $start, $order, $dir);
        } else {
            $search = $this->input->post('search')['value'];

            $user_per = $this->Role_model->role_search($limit, $start, $search, $order, $dir);

            $totalFiltered = $this->Role_model->role_search_count($search);
        }

        $data = array();
        if (!empty($user_per)) {
            foreach ($user_per as $br) {
                $nestedData['role_id'] = $br->role_id;
                $nestedData['role_name'] = $br->role_name;
                $nestedData['status'] = $br->status;
                $nestedData['admin_role'] = $br->admin_role;
                $nestedData['created_at'] = $br->created_at;
                $nestedData['updated_at'] = $br->updated_at;

                $nestedData['action'] = '<a href="' . base_url() . 'admin/role/updaterole/' . $br->role_id . '" class="tabledit-edit-button btn btn-primary waves-effect waves-light btn-sm" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit"><i class="fa fa-pencil-square-o fa-2x"></i></a>
                                                                <a  onclick="return confirm(&#39;Are you sure want to Delete Role ?&#39;)" href="' . base_url() . 'admin/role/deleterole/' . $br->role_id . '" class="tabledit-delete-button btn btn-danger waves-effect waves-light btn-sm" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete"><i class="fa fa-trash fa-2x"></i></a>';

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

    public function addrole() { // add Role


        if ($_SERVER['REQUEST_METHOD'] == "POST") {

            $data = $this->input->post();

            $data['created_at'] = date('Y-m-d H:i:s');
            $data['updated_at'] = date('Y-m-d H:i:s');


            $result = $this->Common_model->insert('admin_role', $data);


            if ($result) {
                $msg = "<div class='alert alert-success alert-dismissible'>
                        <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                        <strong>Success!</strong> Added successfully!.
                      </div>";
                $this->session->set_flashdata("message",$msg);
                redirect(base_url() . "admin/role");
            }
        } else {
            $data['title'] = "Add Role";
            $admin_username = $this->session->userdata('admin_username');
            $data['admin_data'] = $this->adminusers_model->getUserByUsername($admin_username);

            $this->load->view('admin/role/create', $data);
        }
    }

    public function updaterole($role_id) { // update updateRole


        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $data = $this->input->post();


            $data['updated_at'] = date('Y-m-d H:i:s');



            $result = $this->Common_model->update("admin_role", $data, array("role_id" => $role_id));


            if ($result) {
                $msg = "<div class='alert alert-success alert-dismissible'>
                        <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                        <strong>Success!</strong> Updated successfully!.
                      </div>";
                $this->session->set_flashdata("message",$msg);
                redirect(base_url() . "admin/role");
            }
        } else {
            $data['title'] = "Edit Role";
            $admin_username = $this->session->userdata('admin_username');
            $data['admin_data'] = $this->adminusers_model->getUserByUsername($admin_username);

            $data['role_data'] = $this->Common_model->getAll('admin_role', array('role_id' => $role_id))->row_array();

            $this->load->view('admin/role/edit', $data);
        }
    }

    public function deleterole($role_id) { // delete deleterole

        //Check used in or Not
        $ch = $this->Common_model->getAll('admin', array('admin_role', $role_id))->num_rows();
        if ($ch == 0) {
            $this->db->where('role_id', $role_id);
            $this->db->delete('admin_role');


            $msg = "<div class='alert alert-success alert-dismissible'>
                        <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                        <strong>Success!</strong> Deleted successfully!.
                      </div>";
                $this->session->set_flashdata("message",$msg);
            redirect(base_url() . "admin/role");
        } else {
            $msg = "<div class='alert alert-danger alert-dismissible'>
                        <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                        <strong>Error!</strong> No record found!.
                      </div>";
                $this->session->set_flashdata("message",$msg);
            redirect(base_url() . "admin/role");
        }
    }

}
