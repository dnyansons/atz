<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Supplier_news extends CI_Controller {

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
        $this->load->library('Userpermission');
        $this->load->library('awsupload');
    }

    public function index() {
        $data = array();
        $this->load->view("admin/insights/supplier_news/index", $data);
    }

    public function add() {
        $data = [];

        if (isset($_POST['submit']) && $_POST['submit'] != '') {
            $this->form_validation->set_rules('company_name', 'Company Name', 'required|is_unique[bi_supplier_news.company_name]');
            $this->form_validation->set_rules('slogan', 'Slogan', 'required');
            $this->form_validation->set_rules('company_profile_info', 'Company Profile Info', 'required|min_length[100]|max_length[500]');
            $this->form_validation->set_rules('company_competence', 'Company Competence', 'required|min_length[50]|max_length[400]');
            $this->form_validation->set_rules('success_story', 'Success Story', 'required|min_length[100]|max_length[700]');
            $this->form_validation->set_rules('status', 'Status', 'required');

            if ($this->form_validation->run() == false) {
                $err_msg = validation_errors();
                $this->session->set_flashdata('error', $err_msg);
            } else {
                $company_name = $this->input->post('company_name');
                $slogan = $this->input->post('slogan');
                $company_profile_info = $this->input->post('company_profile_info');
                $company_competence = $this->input->post('company_competence');
                $success_story = $this->input->post('success_story');
                $status = $this->input->post('status');

                $insert_arr = array();

                $checklist_attachment = array();
                $this->load->library('upload');
                if (isset($_FILES['company_profile_images']['name']) && !empty($_FILES['company_profile_images']['name']) &&
                        isset($_FILES['company_competence_images']['name']) && !empty($_FILES['company_competence_images']['name']) &&
                        isset($_FILES['success_story_images']['name']) && !empty($_FILES['success_story_images']['name'])) 
                {
                    $pathsToSaveImages = array('demo/uploads/images/bi_company_profile_images',
                        'demo/uploads/images/bi_company_competence_images',
                        'demo/uploads/images/bi_company_success_story');
                    $s3FilePathManyPaths = $this->awsupload->manyFilesControlUpload($_FILES, $pathsToSaveImages);
                    
                    if ($s3FilePathManyPaths == false) {
                        //error
                        $this->session->set_flashdata('message', 'File not uploaded for company profile images!');
                        redirect('admin/BI/supplier_news/');
                    } else {
                        //success
                        $insert_arr['company_profile_images'] = json_encode($s3FilePathManyPaths['company_profile_images']);
                        $insert_arr['company_competence_images'] = json_encode($s3FilePathManyPaths['company_competence_images']);
                        $insert_arr['success_story_images'] = json_encode($s3FilePathManyPaths['success_story_images']);
                    }
                }
                $insert_arr['company_name'] = $company_name;
                $insert_arr['slogan'] = $slogan;
                $insert_arr['company_profile'] = $company_profile_info;
                $insert_arr['company_competence'] = $company_competence;
                $insert_arr['success_story'] = $success_story;
                $insert_arr['status'] = $status;

                $insert_id = $this->Common_model->insert('bi_supplier_news', $insert_arr);

                if (!empty($insert_id)) {
                    $succ_msg = "Supplier News Added Successfully";
                    $this->session->set_flashdata('success', $succ_msg);
                    redirect('admin/BI/supplier_news/');
                }
            }
        }

        $this->load->view("admin/insights/supplier_news/add", $data);
    }

    public function ajax_get_supplier_news() {
        $columns = array(
            0 => 'id',
            1 => 'company_name',
            2 => 'slogan',
            3 => 'status',
            4 => 'date_created',
        );

        $limit = $this->input->post('length');
        $start = $this->input->post('start');
        $order = $columns[$this->input->post('order')[0]['column']];
        $dir = $this->input->post('order')[0]['dir'];

        $totalData = $this->Common_model->select('count(id)', 'bi_supplier_news')[0]['count_id'];

        $totalFiltered = $totalData;

        if (empty($this->input->post('search')['value'])) {
            $list = $this->Common_model->select('*', 'bi_supplier_news', '', array(1 => array('colname' => $order, 'type' => 'DESC')), $limit, $start);
        } else {
            $search = $this->input->post('search')['value'];

            $list = $this->supplier_news_search($limit, $start, $search, $order, $dir);

            $totalFiltered = $this->supplier_news_search_count($search);
        }

        $data = array();
        if (!empty($list)) {
            foreach ($list as $row) {
                $nestedData['id'] = $row['id'];
                $nestedData['company_name'] = $row['company_name'];
                $nestedData['slogan'] = $row['slogan'];
                $nestedData['status'] = $row['status'];
                $nestedData['date_created'] = $row['date_created'];
                $nestedData['action'] = ' <a href="' . base_url() . 'admin/BI/supplier_news/view/' . $row['id'] . '" class="tabledit-delete-button btn btn-success waves-effect waves-light btn-sm" data-toggle="tooltip" data-placement="top" title="View" data-original-title="Delete"><i class="fa fa-eye"></i></a>
				          <a href="' . base_url() . 'admin/BI/supplier_news/edit/' . $row['id'] . '" class="tabledit-edit-button btn btn-primary waves-effect waves-light btn-sm" data-toggle="tooltip" data-placement="top" title="Edit" data-original-title="Edit"><i class="fa fa-pencil-square-o"></i></a>
                                          <a href="' . base_url() . 'admin/BI/supplier_news/delete/' . $row['id'] . '" class="tabledit-delete-button btn btn-danger waves-effect waves-light btn-sm" data-toggle="tooltip" data-placement="top" title="Delete" data-original-title="Delete" onclick="if (!confirm(\'Are you sure you want to delete this record?\')) return false;"><i class="fa fa-trash"></i></a>';

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

    public function supplier_news_search_count($search) {
        $query = $this
                ->db
                ->like('company_name', $search)
                ->or_like('slogan', $search)
                ->or_like('date_created', $search)
                ->or_like('status', $search)
                ->get("bi_supplier_news");

        return $query->num_rows();
    }

    function supplier_news_search($limit, $start, $search, $col, $dir) {
        $query = $this
                ->db
                ->select('*')
                ->like('company_name', $search)
                ->or_like('slogan', $search)
                ->or_like('status', $search)
                ->or_like('date_created', $search)
                ->or_like('status', $search)
                ->limit($limit, $start)
                ->order_by($col, $dir)
                ->get("bi_supplier_news");

        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return null;
        }
    }

    public function view($id) {
        $data = array();
        if ($id) {
            $details = $this->Common_model->select('*', 'bi_supplier_news', ['id' => $id]);

            if (!empty($details)) {
                $data['details'] = $details[0];
                $this->load->view("admin/insights/supplier_news/view", $data);
            }
        }
    }

    public function webview() {
        $details = $this->Common_model->select('*', 'bi_supplier_news', ['id' => 1])[0];
        $data['details'] = $details;
        $company_profile_images = $details['company_profile_images'];
        if ($company_profile_images != '') {
            $company_profile_image_arr = explode(',', $company_profile_images);
            if (!empty($company_profile_image_arr)) {
                foreach ($company_profile_image_arr as $img) {
                    $data['details']['company_profile_image_arr'][] = base_url('uploads/images/bi_company_profile_images/' . $img);
                }
            }
        }
        $company_competence_images = $details['company_competence_images'];
        if ($company_competence_images != '') {
            $company_competence_image_arr = explode(',', $company_competence_images);
            if (!empty($company_competence_image_arr)) {
                foreach ($company_competence_image_arr as $img) {
                    $data['details']['company_competence_image_arr'][] = base_url('uploads/images/bi_company_competence_images/' . $img);
                }
            }
        }
        $success_story_images = $details['success_story_images'];
        if ($success_story_images != '') {
            $success_story_image_arr = explode(',', $success_story_images);
            if (!empty($success_story_image_arr)) {
                foreach ($success_story_image_arr as $img) {
                    $data['details']['success_story_image_arr'][] = base_url('uploads/images/bi_company_success_story/' . $img);
                }
            }
        }

//        echo "<pre>";
//        print_r($data);
//        exit;
        $this->load->view('webviews/supplier_news_details', $data);
    }

    public function edit($id) {
        $data = array();
        if ($id) {
            $record = $this->Common_model->getAll('bi_supplier_news', ['id' => $id])->result();
            if (isset($_POST['submit']) && $_POST['submit'] != '') {
                $id = $this->input->post('id');

                $this->form_validation->set_rules('company_name', 'Company Name', 'required|callback_check_company_name_update');
                $this->form_validation->set_rules('slogan', 'Slogan', 'required');
                $this->form_validation->set_rules('company_profile_info', 'Company Profile Info', 'required|min_length[100]|max_length[500]');
                $this->form_validation->set_rules('company_competence', 'Company Competence', 'required|min_length[50]|max_length[400]');
                $this->form_validation->set_rules('success_story', 'Success Story', 'required|min_length[100]|max_length[700]');
                $this->form_validation->set_rules('status', 'Status', 'required');

                if ($this->form_validation->run() == false) {
                    $err_msg = validation_errors();
                    $this->session->set_flashdata('error', $err_msg);
                } else {
                    
                    if (isset($_FILES['company_profile_images']['name']) && !empty($_FILES['company_profile_images']['name']) &&
                        isset($_FILES['company_competence_images']['name']) && !empty($_FILES['company_competence_images']['name']) &&
                        isset($_FILES['success_story_images']['name']) && !empty($_FILES['success_story_images']['name'])) 
                {
                    $pathsToSaveImages = array('demo/uploads/images/bi_company_profile_images',
                        'demo/uploads/images/bi_company_competence_images',
                        'demo/uploads/images/bi_company_success_story');
                    $s3FilePathManyPaths = $this->awsupload->manyFilesControlUpload($_FILES, $pathsToSaveImages);
                    
                    if ($s3FilePathManyPaths == false) {
                        //error
                        $this->session->set_flashdata('message', 'File not uploaded for company profile images!');
                    } else {
                        //success
                        $insert_arr['company_profile_images'] = json_encode($s3FilePathManyPaths['company_profile_images']);
                        $insert_arr['company_competence_images'] = json_encode($s3FilePathManyPaths['company_competence_images']);
                        $insert_arr['success_story_images'] = json_encode($s3FilePathManyPaths['success_story_images']);
                    }
                }
                    $insert_arr['company_name'] = $company_name;
                    $insert_arr['slogan'] = $slogan;
                    $insert_arr['company_profile'] = $company_profile_info;
                    $insert_arr['company_competence'] = $company_competence;
                    $insert_arr['success_story'] = $success_story;
                    $insert_arr['status'] = $status;
                    $affected_rows = $this->Common_model->update('bi_supplier_news', $insert_arr, ['id' => $id]);


                    $succ_msg = "Supplier News Updated Successfully";
                    $this->session->set_flashdata('success', $succ_msg);
                    redirect('admin/BI/supplier_news/');
                }
            }

            if (!empty($record)) {
                $data['record'] = $record[0];
                $this->load->view('admin/common/header');
                $this->load->view('admin/common/sidebar');
                $this->load->view("admin/insights/supplier_news/edit", $data);
                $this->load->view('admin/common/footer');
            }
        }
    }

    public function check_company_name_update() {
        $id = $this->input->post('id');
        $company_name = $this->input->post('company_name');
        $response = true;
        $rec = $this->Common_model->select('*', 'bi_supplier_news', ['company_name' => $company_name, 'id !=' => $id]);
//         echo "<pre>";
//         print_r($rec);
//        exit;
        if (!empty($rec)) {
            $this->form_validation->set_message('check_company_name_update', 'Company name must be unique');
            $response = false;
        }
        return $response;
    }

    public function delete($id) {
        if ($id) {
            $delete_status = $this->Common_model->delete('bi_supplier_news', ['id' => $id]);
            if ($delete_status == 1) {
                $this->session->set_flashdata('error', 'Record Deleted');
                redirect('admin/BI/supplier_news');
            }
        }
    }

}
