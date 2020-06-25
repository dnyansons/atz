<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Packages extends CI_Controller {

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
        $this->load->model('Packages_model');
        $this->load->model('Common_model');
        $this->load->library('Userpermission');
        $this->load->library('awsupload');
    }

    public function index() {

        $data['action'] = 'admin/packages/add_package';
        $data["pageTitle"] = "Subcription Packages";
        $this->load->view("admin/package/list", $data);
    }

    public function ajax_list() {
        $user_id = $this->session->userdata("user_id");

        $columns = array(
            0 => 'sub_id',
            1 => 'pkg_name',
            2 => 'duration',
            3 => 'price',
            4 => 'product_ranking',
            5 => 'customized_website',
            6 => 'status',
        );

        $limit = $this->input->post('length');
        $start = $this->input->post('start');
        $order = $columns[$this->input->post('order')[0]['column']];
        //$dir = $this->input->post('order')[0]['dir'];
        $dir = "desc";

        $totalData = $this->Packages_model->all_pkg_count($user_id);


        $totalFiltered = $totalData;

        if (empty($this->input->post('search')['value'])) {
            $alorder = $this->Packages_model->allpkg($user_id, $limit, $start, $order, $dir);
        } else {
            $search = $this->input->post('search')['value'];

            $alorder = $this->Packages_model->pkg_search($user_id, $limit, $start, $search, $order, $dir);
            //echo $this->db->last_query();

            $totalFiltered = $this->Packages_model->pkg_search_count($user_id, $search);
        }

        $data = array();
        if (!empty($alorder)) {
            foreach ($alorder as $br) {
                $nestedData['sub_id'] = $br->sub_id;
                $nestedData['pkg_name'] = $br->pkg_name;
                $nestedData['duration'] = $br->duration;
                $nestedData['price'] = $br->price;

                $nestedData['product_ranking'] = $br->product_ranking;
                $nestedData['customized_website'] = $br->customized_website;
                $nestedData['status'] = $br->status;
                $nestedData['action'] = '<a type="button" href="' . base_url() . 'admin/packages/edit/' . $br->sub_id . '" class="btn btn-warning btn-sm">View & Edit</a>';

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

    function add_package() {
        $data['title'] = 'Add Package';

        $this->db->select('*');
        $this->db->from('tax_class a');
        $this->db->join('country b', 'a.country_id=b.id', 'left');
        $query = $this->db->get();
        $data['taxes'] = $query->result_array();

        $data['action'] = 'admin/packages/create';
        $this->load->view("admin/package/create", $data);
    }

    function create() {
        //$data=$this->input->post();
        $data['pkg_name'] = $this->input->post('pkg_name');
        $data['pkg_sub_title'] = $this->input->post('pkg_sub_title');
        $data['price'] = $this->input->post('price');
        $data['product_ranking'] = $this->input->post('product_ranking');
        $data['pkg_description'] = $this->input->post('pkg_description');
        $data['product_posting'] = $this->input->post('product_posting');
        $data['product_showcase'] = $this->input->post('product_showcase');
        $data['verified_icon'] = $this->input->post('verified_icon');
        $data['customized_website'] = $this->input->post('customized_website');
        $data['duration'] = $this->input->post('duration');
        $data['status'] = $this->input->post('status');
        $data['taxes'] = json_encode($this->input->post('taxes'));

        //Upload Attachment
        if ($_FILES['userFiles']['name'] != '' || !empty($_FILES['userFiles']['name'])) {
            $s3FilePath = $this->awsupload->upload('userFiles', 'uploads/package', 'image');
            $data['pkg_image'] = $s3FilePath;
            if ($s3FilePath == false) {
                $data['pkg_image'] = ''; //if no file selected for upload  
            }
        } else {
            $data['pkg_image'] = '';
        }
        $result = $this->Common_model->insert('subscription_package', $data);

        if ($result) {
            $msg = '<div class="alert alert-success background-success">
<button type="button" class="close" data-dismiss="alert" aria-label="Close">
<i class="icofont icofont-close-line-circled text-white"></i>
</button>
<strong>Success!</strong> Create Successfully
</div>';
        } else {
            $msg = '<div class="alert alert-danger background-danger">
<button type="button" class="close" data-dismiss="alert" aria-label="Close">
<i class="icofont icofont-close-line-circled text-white"></i>
</button>
<strong>Success!</strong> Record Not Added !
</div>';
        }

        $this->session->set_flashdata('message', $msg);
        redirect('admin/packages');
    }

    function edit($id) {

        $data['dat'] = $this->Common_model->getAll('subscription_package', array('sub_id' => $id))->row_array();

        $this->db->select('*');
        $this->db->from('tax_class a');
        $this->db->join('country b', 'a.country_id=b.id', 'left');
        $query = $this->db->get();
        $data['taxes'] = $query->result_array();

        $data['title'] = 'Edit Package';
        $data['action'] = 'admin/packages/update';
        $this->load->view("admin/package/create", $data);
    }

    function update() {
        $data['pkg_name'] = $this->input->post('pkg_name');
        $data['pkg_sub_title'] = $this->input->post('pkg_sub_title');
        $data['price'] = $this->input->post('price');
        $data['product_ranking'] = $this->input->post('product_ranking');
        $data['pkg_description'] = $this->input->post('pkg_description');
        $data['product_posting'] = $this->input->post('product_posting');
        $data['customized_website'] = $this->input->post('customized_website');
        $data['product_showcase'] = $this->input->post('product_showcase');
        $data['verified_icon'] = $this->input->post('verified_icon');
        $data['duration'] = $this->input->post('duration');
        $data['status'] = $this->input->post('status');
        $data['taxes'] = json_encode($this->input->post('taxes'));

        //Upload Attachment
        if ($_FILES['userFiles']['name'][0] != '' || !empty($_FILES['userFiles']['name'][0])) {

            $filesCount = count($_FILES['userFiles']['name']);

            $s3FilePath = $this->awsupload->multiUpload('myfile', 'uploads/package', 'image');
            if ($s3FilePath == false) {
                //error
                 echo json_encode(array('msg' => 'File type not allowed!'));
            } else {
                //success
                $data['pkg_image'] = $s3FilePath;
            }
        } else {
            $data['pkg_image'] = $this->input->post('pkg_image');
        }
        $result = $this->Common_model->update('subscription_package', $data, array('sub_id' => $this->input->post('sub_id')));
        if ($result) {
            $msg = '<div class="alert alert-success background-success">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <i class="icofont icofont-close-line-circled text-white"></i>
                    </button>
                    <strong>Success!</strong> Update Successfully
                    </div>';
        } else {
            $msg = '<div class="alert alert-danger background-danger">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <i class="icofont icofont-close-line-circled text-white"></i>
                    </button>
                    <strong>Error!</strong> Record Not Updated !
                    </div>';
        }

        $this->session->set_flashdata('message', $msg);

        redirect(base_url() . "admin/packages");
    }

}
