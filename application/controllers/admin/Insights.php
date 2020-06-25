<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Insights extends CI_Controller {

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

        $this->load->model('Insights_model');
        $this->load->library('Userpermission');
        $this->load->library('awsupload');
    }

    public function recommended() {
        $data = [
            "pageTitle" => "Admin Dashboard"
        ];
        $this->load->view("admin/insights/recommended_list", $data);
    }

    public function recommended_ajax_list() {   
        $columns = array(
            0 => 'id',
            1 => 'image',
            2 => 'topic',
            3 => 'short_description',
            4 => 'status'
        );

        $limit = $this->input->post('length');
        $start = $this->input->post('start');
        $order = $columns[$this->input->post('order')[0]['column']];
        $dir = $this->input->post('order')[0]['dir'];
        $dir = "desc";

        $totalData = $this->Insights_model->all_recommended_count();

        $totalFiltered = $totalData;

        if (empty($this->input->post('search')['value'])) {
            $list = $this->Insights_model->all_recommended($limit, $start, $order, $dir);
        } else {
            $search = $this->input->post('search')['value'];

            $product = $this->Insights_model->product_search($limit, $start, $search, $order, $dir);

            $totalFiltered = $this->Insights_model->product_search_count($search);
        }


        $data = array();
        if (!empty($list)) {
            foreach ($list as $row) {

                $nestedData['id'] = $row->id;
                $nestedData['image'] = '<img src="' . base_url() . 'uploads/images/bi_recommended/' . $row->image . '" class=" width="64px" height="64px" alt="img">';
                $nestedData['topic'] = $row->topic;
                $nestedData['short_description'] = strlen($row->short_description) > 50 ? substr($row->short_description, 0, 20) . '...' : $row->short_description;
                $nestedData['status'] = $row->status;
                $nestedData['action'] = ' <a href="' . base_url() . 'admin/insights/view_recommended/' . $row->id . '" class="tabledit-delete-button btn btn-success waves-effect waves-light btn-sm" data-toggle="tooltip" data-placement="top" title="View" data-original-title="Delete"><i class="fa fa-eye"></i></a>
				                           <a href="' . base_url() . 'admin/insights/edit_recommended/' . $row->id . '" class="tabledit-edit-button btn btn-primary waves-effect waves-light btn-sm" data-toggle="tooltip" data-placement="top" title="Edit" data-original-title="Edit"><i class="fa fa-pencil-square-o"></i></a>
                                           <a href="' . base_url() . 'admin/insights/delete_recommended/' . $row->id . '" class="tabledit-delete-button btn btn-danger waves-effect waves-light btn-sm" data-toggle="tooltip" data-placement="top" title="Delete" data-original-title="Delete" onclick="if (!confirm(\'Are you sure you want to delete this record?\')) return false;"><i class="fa fa-trash"></i></a>';

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

    public function add_recommended() {
        $data = [
            "pageTitle" => "Add Insight Recommended"
        ];



        if (isset($_POST['submit']) && $_POST['submit'] != '') {

            $this->form_validation->set_rules('topic', 'Topic', 'required|is_unique[insights_recommended.topic]');
            $this->form_validation->set_rules('short_description', 'Short Description', 'required');
            $this->form_validation->set_rules('full_description', 'Full Description', 'required');

            if ($this->form_validation->run() == false) {
                $err_msg = validation_errors();
                $this->session->set_flashdata('error', $err_msg);
            } else {
                $topic = $this->input->post('topic');
                $short_description = $this->input->post('short_description');
                $full_description = $this->input->post('full_description');

                $insert_arr = array();

                if (!empty($_FILES) && isset($_FILES['image']) && !empty($_FILES['image'])) {
                    $s3FilePath = $this->awsupload->upload('image', 'uploads/images/bi_recommended', 'image');
                    if ($s3FilePath == false) {
                        //error
                        $error = "<div class='alert alert-danger alert-dismissible'>
                                <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                                <strong>Error!</strong> File type not allowed.!
                                </div>";
                        $this->session->set_flashdata("message", $error);
                        redirect("admin/bi/Insights/add_recommended", "refresh");
                    } else {
                        //success
                        $insert_arr['image'] = $s3FilePath;
                    }
                }

                $insert_arr['topic'] = $topic;
                $insert_arr['short_description'] = $short_description;
                $insert_arr['full_description'] = $full_description;

                $insert_id = $this->Common_model->insert('insights_recommended', $insert_arr);

                if ($insert_id) {
                    $this->session->set_flashdata('success', 'Added Successfully');
                    redirect('admin/insights/recommended');
                }
            }
        }

        $this->load->view('admin/common/header');
        $this->load->view('admin/common/sidebar');
        $this->load->view("admin/insights/add_recommended", $data);
        $this->load->view('admin/common/footer');
    }

    public function view_recommended($id) {
        $data = array();
        if ($id) {
            $details = $this->Common_model->getAll('insights_recommended', ['id' => $id])->result();

            if (!empty($details)) {
                $data['details'] = $details[0];
                $this->load->view("admin/insights/view_recommended", $data);
            }
        }
    }

    public function edit_recommended($id) {
        $data = array();
        if ($id) {
            $record = $this->Common_model->getAll('insights_recommended', ['id' => $id])->result();

            if (isset($_POST['submit']) && $_POST['submit'] != '') {

                //echo "<pre>";
                //print_r($_POST);
                // exit;

                $id = $this->input->post('id');
                $this->form_validation->set_rules('topic', 'Topic', 'callback_check_topic_update');
                $this->form_validation->set_rules('short_description', 'Short Description', 'required');
                $this->form_validation->set_rules('full_description', 'Full Description', 'required');

                if ($this->form_validation->run() == false) {
                    $err_msg = validation_errors();
                    $this->session->set_flashdata('error', $err_msg);
                } else {
                    $topic = $this->input->post('topic');
                    $short_description = $this->input->post('short_description');
                    $full_description = $this->input->post('full_description');

                    $insert_arr = array();

                    if (!empty($_FILES) && isset($_FILES['image']) && !empty($_FILES['image'])) {

                        $s3FilePath = $this->awsupload->upload('image', 'uploads/images/bi_recommended', 'image');
                        if ($s3FilePath == false) {
                            //error
                            $error = "<div class='alert alert-danger alert-dismissible'>
                                <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                                <strong>Error!</strong> File type not allowed.!
                                </div>";
                            $this->session->set_flashdata("message", $error);
                            redirect("admin/bi/Insights/add_recommended", "refresh");
                        } else {
                            //success
                            $insert_arr['image'] = $s3FilePath;
                        }
                    }

                    $insert_arr['topic'] = $topic;
                    $insert_arr['short_description'] = $short_description;
                    $insert_arr['full_description'] = $full_description;

                    $affected_rows = $this->Common_model->update('insights_recommended', $insert_arr, ['id' => $id]);
                    $this->session->set_flashdata('success', 'Record Updated Successfully');
                    redirect('admin/insights/recommended');
                }
            }

            if (!empty($record)) {
                $data['record'] = $record[0];
                $this->load->view('admin/common/header');
                $this->load->view('admin/common/sidebar');
                $this->load->view("admin/insights/edit_recommended", $data);
                $this->load->view('admin/common/footer');
            }
        }
    }

    public function check_topic_update() {
        $id = $this->input->post('id');
        $topic = $this->input->post('topic');
        $resposnse = true;
        $rec = $this->Common_model->select('*', 'insights_recommended', ['topic' => $topic, 'id !=' => $id]);
        if (!empty($rec)) {
            $this->form_validation->set_message('check_topic_update', 'Topic must be unique');
            $response = false;
        }
        return $response;
    }

    public function delete_recommended($id) {
        if ($id) {
            $delete_status = $this->Common_model->delete('insights_recommended', ['id' => $id]);

            if ($delete_status == 1) {
                $this->session->set_flashdata('error', 'Record Deleted');
                redirect('admin/insights/recommended');
            }
        }
    }

}
