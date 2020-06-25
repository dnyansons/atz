<?php

//ob_start();
defined('BASEPATH') OR exit('No direct script access allowed');

class Permission extends CI_Controller {

    public function __construct() {
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
        $this->load->model('Permission_model');
        $this->load->model('Common_model');
        $this->load->model('Categories_model');
        $this->load->model('adminusers_model', 'adminusers_model');
        $this->load->library('form_validation');
        $this->load->library('Userpermission');
    }

    public function index() {
        $this->load->view("admin/permission/list");
    }

    public function ajax_list() {
        $columns = array(
            0 => 'admin_id',
            1 => 'admin_username',
            2 => 'admin_firstname',
            3 => 'role_name',
            4 => 'admin_email',
            5 => 'admin_telephone',
            6 => 'admin_status',
        );

        $limit = $this->input->post('length');
        $start = $this->input->post('start');
        $order = $columns[$this->input->post('order')[0]['column']];
        $dir = $this->input->post('order')[0]['dir'];

        $totalData = $this->Permission_model->alluser_count();

        $totalFiltered = $totalData;

        if (empty($this->input->post('search')['value'])) {
            $user_per = $this->Permission_model->alluser($limit, $start, $order, $dir);
        } else {
            $search = $this->input->post('search')['value'];

            $user_per = $this->Permission_model->user_search($limit, $start, $search, $order, $dir);

            $totalFiltered = $this->Permission_model->user_search_count($search);
        }

        $data = array();
        if (!empty($user_per)) {
            foreach ($user_per as $br) {
                $nestedData['admin_id'] = $br->admin_id;
                $nestedData['admin_username'] = $br->admin_username;
                $nestedData['admin_firstname'] = $br->admin_firstname;
                $nestedData['role_name'] = $br->role_name;
                $nestedData['admin_email'] = $br->admin_email;
                $nestedData['admin_telephone'] = $br->admin_telephone;
                $nestedData['admin_status'] = $br->admin_status;


                $nestedData['action'] = '<a title="Set User" href="' . base_url() . 'admin/permission/updateuser/' . $br->admin_id . '" class="tabledit-edit-button btn btn-primary waves-effect waves-light btn-sm" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit"><i class="fa fa-pencil-square-o fa-2x"></i></a>
				<a title="Set Permission" href="' . base_url() . 'admin/permission/view_permission/' . $br->admin_id . '" class="tabledit-edit-button btn btn-warning waves-effect waves-light btn-sm" data-toggle="tooltip" data-placement="top" title="" data-original-title="Set Permission"><i class="fa fa-pencil-square-o fa-2x"></i></a>';

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

    public function adduser() { // add User
        $this->form_validation->set_rules('admin_role', 'Role', 'required');
        $this->form_validation->set_rules('admin_firstname', 'Name', 'required');
        $this->form_validation->set_rules('admin_email', 'Email', 'required|is_unique[admin.admin_email]');
        $this->form_validation->set_rules('admin_telephone', 'Phone', 'required|is_unique[admin.admin_telephone]');
        $this->form_validation->set_rules('admin_password', 'Password', 'required');
        $this->form_validation->set_rules('cpass', 'Password Confirmation', 'required|matches[admin_password]');


        if ($this->form_validation->run() == FALSE) {
            $data['title'] = "Add User";
            $admin_username = $this->session->userdata('admin_username');
            $data['admin_data'] = $this->adminusers_model->getUserByUsername($admin_username);
            $data['role_data'] = $this->Common_model->getAll('admin_role', array('status' => 'Active'))->result_array();
            $data['country_data'] = $this->Common_model->getAll('country')->result_array();
            $this->load->view('admin/permission/create_agent', $data);
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
//            $msg = '<div class="alert alert-success background-success">
//					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
//					<i class="icofont icofont-close-line-circled text-white"></i>
//					</button>
//					<strong>User Create Successfully
//					</div>';
//            $this->session->set_flashdata('message', $msg);
            //var_dump(base_url());
            //echo "test";
            redirect("admin/agent_management/active_agents/");
        }
    }

    public function updateuser($user_id) { // update User
        if ($_SERVER['REQUEST_METHOD'] == "POST") {

            $this->form_validation->set_rules('admin_username', 'Username', 'required');
            $this->form_validation->set_rules('admin_role', 'Role', 'required');
            $this->form_validation->set_rules('admin_firstname', 'Name', 'required');
            $this->form_validation->set_rules('admin_email', 'Email', 'required');
            $this->form_validation->set_rules('admin_telephone', 'Phone', 'required');

            if ($this->form_validation->run() == FALSE) {
                $msg = '<div class="alert alert-danger background-danger">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<i class="icofont icofont-close-line-circled text-white"></i>
					</button>
					<strong>' . validation_errors() . '
					</div>';
                $this->session->set_flashdata('message', $msg);
            } else {
                $data['admin_username'] = $this->input->post('admin_username');
                $data['admin_role'] = $this->input->post('admin_role');
                $data['admin_firstname'] = $this->input->post('admin_firstname');
                $data['admin_email'] = $this->input->post('admin_email');
                $data['admin_telephone'] = $this->input->post('admin_telephone');
                $data['address1'] = $this->input->post('address1');
                $data['country'] = $this->input->post('country');
                $data['user_created'] = $this->session->userdata('admin_id');
                $data['status'] = $this->input->post('status');
                $data['date_modified'] = date('Y-m-d H:i:s');

                $result = $this->Common_model->update("admin", $data, array("admin_id" => $user_id));
                $msg = '<div class="alert alert-success background-success">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<i class="icofont icofont-close-line-circled text-white"></i>
					</button>
					<strong>User Update Successfully
					</div>';


                $this->session->set_flashdata('message', $msg);
            }

            redirect(base_url() . "admin/permission");
        } else {
            $data['title'] = "Edit User";
            $data['admin_data'] = $this->adminusers_model->getUserByUsername($admin_username);
            $data['user'] = $this->Common_model->getAll('admin', array('admin_id' => $user_id))->row_array();
            $data['role_data'] = $this->Common_model->getAll('admin_role', array('status' => 'Active'))->result_array();
            $data['country_data'] = $this->Common_model->getAll('country')->result_array();

            $this->load->view('admin/permission/edit', $data);
        }
    }

    public function deletecoupon($coupon_id) { // delete deletecoupon
        $result = $this->Permission_model->deleteCouponData($coupon_id);

        if ($result) {
            $msg = 'Delete Successfully !';
            $this->session->set_flashdata('message', $msg);
            redirect(base_url() . "admin/coupon");
        }
    }

    function view_permission($user_id = 0) {


        //Check User
        $user = $this->Permission_model->get_user($user_id);
        if ($user->num_rows() > 0) {
            $data['menu'] = $this->Permission_model->get_menu($user_id);
            //echo $this->db->last_query();
            // exit;
            $data['action'] = 'admin/permission/set_permission';
            $data['user_info'] = $user->row_array();
            $this->load->view('admin/permission/set_permission', $data);
        } else {
            redirect('admin/permission');
        }
    }

    function set_permission() {
        $user_id = $this->input->post('user_id');
        if (!empty($user_id)) {
            $user = $this->Permission_model->get_user($user_id)->row_array();

            if ($user['admin_role'] == 1) {
                $msg = '<div class="alert alert-danger background-danger">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<i class="icofont icofont-close-line-circled text-white"></i>
						</button>
						<strong>No Permission To Update Permission
						</div>';
            } else {
                $this->Common_model->delete('user_permission', array('user_id' => $user_id));

                $tot_record = $this->input->post('tot_record');
                $insetData['user_id'] = $this->input->post('user_id');
                for ($i = 1; $i <= $tot_record; $i++) {
                    $insetData['menu_id'] = $this->input->post('menu_id' . $i);

                    $insetData['view'] = $this->input->post('view' . $i);

                    $insetData['add'] = $this->input->post('add' . $i);

                    $insetData['edit'] = $this->input->post('edit' . $i);

                    $insetData['delete'] = $this->input->post('delete' . $i);

                    $insetData['sidebar'] = $this->input->post('sidebar' . $i);

                    $insetData['user_created'] = $this->session->userdata('admin_id');
                    ;
                    $insetData['updated_at'] = date('Y-m-d H:i:s');
                    $this->Common_model->insert('user_permission', $insetData);
                }
                $msg = '<div class="alert alert-success background-success">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<i class="icofont icofont-close-line-circled text-white"></i>
						</button>
						<strong>Permission Set Successfully
						</div>';
            }

            $this->session->set_flashdata('message', $msg);
            redirect('admin/agent_management');
        } else {
            redirect('admin/agent_management');
        }
    }

    function error() {
        $this->load->view('block');
    }

    function sort_menu() {
        //get main menu
        $data['action'] = 'admin/permission/update_sort_menu';
        $data['menu'] = $this->Permission_model->get_main_menu();
        $this->load->view('admin/permission/sort_menu', $data);
    }

    function update_sort_menu() {
        $tot = $this->input->post('tot_record');
        $i = 1;
        while ($i <= $tot) {
            $menu_id = $this->input->post('menu_id' . $i);

            $dat['sort_by'] = $this->input->post('arrange' . $i);

            $data = array(
                'sort_by' => $this->input->post('arrange' . $i)
            );

            $this->db->where('menu_id', $menu_id);
            $this->db->update('menu_master', $data);

            $i++;
        }

        $msg = '<div class="alert alert-success background-success">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<i class="icofont icofont-close-line-circled text-white"></i>
						</button>
						<strong>Menu Sort Successfully
						</div>';

        $this->session->set_flashdata('message', $msg);
        redirect('admin/permission/sort_menu');
    }

    function test() {
        $this->db->select('*');
        $this->db->from('menu_master');
        $this->db->where('parent_id', 0);
        $this->db->order_by('menu_id', 'asc');
        $dat = $this->db->get()->result();
        $i = 1;
        foreach ($dat as $row) {
            echo'<pre>';
            print_r($row);
            $da['sort_by'] = $i++;
            $this->Common_model->update('menu_master', $da, array('menu_id' => $row->menu_id));

            $this->db->select('*');
            $this->db->from('menu_master');
            $this->db->where('parent_id', $row->menu_id);
            $sub = $this->db->get()->result();

            foreach ($sub as $srow) {
                echo'SubData------------------<pre>';
                print_r($srow);

                $das['sort_by'] = $i++;
                $this->Common_model->update('menu_master', $das, array('menu_id' => $srow->menu_id));
            }
        }

        //get single menu ID
        $single = $this->db->query('SELECT count(`menu_id`)tot,menu_id FROM `user_permission` WHERE 1 group by menu_id')->result();
        foreach ($single as $si) {
            if ($si->tot == 1) {
                $ab = $this->db->query('SELECT DISTINCT(`user_id`) FROM `user_permission` WHERE `user_id`!=1 ORDER BY `user_permission`.`user_id` ASC')->result();
                foreach ($ab as $val) {
                    $dat['user_id'] = $val->user_id;
                    $dat['menu_id'] = $si->menu_id;
                    $this->Common_model->insert('user_permission', $dat);
                }
            }
        }
    }

    function bulk() {
        //get single menu ID
        $single = $this->db->query('SELECT count(`menu_id`)tot,menu_id FROM `user_permission` WHERE 1 group by menu_id')->result();
        foreach ($single as $si) {
            if ($si->tot == 1) {
                $ab = $this->db->query('SELECT DISTINCT(`user_id`) FROM `user_permission` WHERE `user_id`!=1 ORDER BY `user_permission`.`user_id` ASC')->result();
                foreach ($ab as $val) {
                    $dat['user_id'] = $val->user_id;
                    $dat['menu_id'] = $si->menu_id;
                    $this->Common_model->insert('user_permission', $dat);
                }
            }
        }
    }

}
