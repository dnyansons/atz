<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Agent_management extends CI_Controller 
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

        $this->load->library('Userpermission');
        $this->load->model('Agent_management_model');
        $this->load->model('adminusers_model');
    }

    public function index()
    {
        $data["pageTitle"] = "Active agents";
        $data["status"] = 1;
        $this->load->view("admin/agent_management/list",$data);
    }
    
    public function inactive()
    {
        $data["pageTitle"] = "Inactive agents";
        $data["status"] = 0;
        $this->load->view("admin/agent_management/list",$data);
    }
    
    public function ajax_list()
    {
        //$this->output->enable_profiler(true);
        $list = $this->Agent_management_model->get_datatables();
        $data = array();
        $no = $_POST['start'];
        $deactivate = "<button class='btn btn-danger btn-sm btn-activate' data-aid='".$customers->admin_id."'>Deactivate</button>";
        $activate = c;
        foreach ($list as $customers) {
            
            $no++;
            $row = array();
            $row[] = $customers->admin_id;
            $row[] = $customers->admin_firstname;
            $row[] = $customers->admin_role_name;
            $row[] = $customers->admin_email;
            $row[] = $customers->admin_telephone;
            $row[] = ($customers->active)?"<button class='btn btn-danger btn-sm btn-deactivate' data-aid='".$customers->admin_id."'>Deactivate</button>":"<button class='btn btn-info btn-sm btn-activate' data-aid='".$customers->admin_id."'>activate</button>";
            $row[] = ($customers->active)?"<a href='".site_url()."/admin/permission/view_permission/".$customers->admin_id."' class='tabledit-edit-button btn btn-warning waves-effect waves-light btn-sm'>Set Permissions</a>":"";
            
            $data[] = $row;
        }
 
        
        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->Agent_management_model->count_all(),
                        "recordsFiltered" => $this->Agent_management_model->count_filtered(),
                        "data" => $data,
                );
        echo json_encode($output);
    }
    
    public function createNew() // add User
    {
        $this->form_validation->set_rules('admin_role', 'Role', 'required');
        $this->form_validation->set_rules('admin_firstname', 'Name', 'required');
        $this->form_validation->set_rules('admin_email', 'Email', 'required|is_unique[admin.admin_email]');
        $this->form_validation->set_rules('admin_telephone', 'Phone', 'required|is_unique[admin.admin_telephone]',[
            "is_unique" => "This mobile number is already registered"
        ]);
        $this->form_validation->set_rules('admin_password', 'Password', 'required');
        $this->form_validation->set_rules('cpass', 'Password Confirmation', 'required|matches[admin_password]');


        if ($this->form_validation->run() == FALSE) {
            $data['title']="Add User";
            $admin_username=$this->session->userdata('admin_username');
            $data['admin_data']=$this->adminusers_model->getUserByUsername($admin_username);
            $data['role_data']=$this->Common_model->getAll('admin_role',array('status'=>'Active'))->result_array();
            $data['country_data']=$this->Common_model->getAll('country')->result_array();
            $this->load->view('admin/agent_management/create_agent', $data);
        } else {
             
            $data['admin_username'] = $this->input->post('admin_email');
            $data['admin_role'] = $this->input->post('admin_role');
            $data['admin_firstname'] = $this->input->post('admin_firstname');
            $data['admin_email'] = $this->input->post('admin_email');
            $data['admin_telephone'] = $this->input->post('admin_telephone');
            $data['address1'] = $this->input->post('address1');
            $data['country'] = $this->input->post('country');
            $data['user_created'] = $this->session->userdata('admin_id');
            $data['status'] = $this->input->post('status');
            $data['admin_password'] = password_hash($this->input->post("admin_password"), PASSWORD_DEFAULT);

            $data['date_created'] = date('Y-m-d H:i:s');
            $data['date_modified'] = date('Y-m-d H:i:s');

            $result = $this->Common_model->insert('admin', $data);
            $msg = '<div class="alert alert-success background-success">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<i class="icofont icofont-close-line-circled text-white"></i>
					</button>
					<strong>User Create Successfully
					</div>';
            $this->session->set_flashdata('message', $msg);
            
            redirect("admin/agent_management","refresh");
        }
    }
    
    public function activate_agent()
    {
        $output = [
            "status" => 0
        ];
        $this->form_validation->set_rules("admin_id","admin_id","required");
        if($this->form_validation->run()===false){
            echo json_encode($output);
        } else {
            $id = $this->input->post("admin_id");
            $data["status"] = 1;
            $this->Agent_management_model->updateAgent($id,$data);
            $output["status"] = 1;
            echo json_encode($output);
        }
    }
    
    public function deactivate_agent()
    {
        $output = [
            "status" => 0
        ];
        $this->form_validation->set_rules("admin_id","admin_id","required");
        if($this->form_validation->run()===false){
            echo json_encode($output);
        } else {
            $id = $this->input->post("admin_id");
            $data["status"] = 0;
            $this->Agent_management_model->updateAgent($id,$data);
            $output["status"] = 1;
            echo json_encode($output);
        }
    }

}
