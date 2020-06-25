<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Event extends CI_Controller {

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
        $this->load->view("admin/insights/event/index", $data);
    }

    public function add() {
        $data = [];

        if (isset($_POST['submit']) && $_POST['submit'] != '') {
            $this->form_validation->set_rules('title', 'Title', 'required|is_unique[bi_event.title]|min_length[10]|max_length[60]');
            $this->form_validation->set_rules('you_tube_embed_url', 'You Tube Embed URL', 'required');
            $this->form_validation->set_rules('short_description', 'Short Description', 'required|min_length[10]|max_length[100]');
            $this->form_validation->set_rules('status', 'Status', 'required');

            if ($this->form_validation->run() == false) {
                $err_msg = validation_errors();
                $this->session->set_flashdata('error', $err_msg);
            } else {
                $title = $this->input->post('title');
                $you_tube_embed_url = $this->input->post('you_tube_embed_url');
                $short_description = $this->input->post('short_description');
                $status = $this->input->post('status');

                $insert_arr = array();

                if (!empty($_FILES) && isset($_FILES['event_image']) && !empty($_FILES['event_image'])) {
                    $s3FilePath = $this->awsupload->upload('event_image', 'uploads/images/bi_event', 'image');
                    if ($s3FilePath == false) {
                        //error
                        $msg = '<div class="alert alert-danger alert-dismissible">
                                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                        <strong>Error!</strong> File type not allowed.!
                                    </div>';
                            $this->session->set_flashdata('message', $msg);
                            redirect('Event/add');
                    } else {
                        //success
                        $insert_arr['event_image'] = $s3FilePath;
                    }
                }

                $insert_arr['title'] = $title;
                $insert_arr['you_tube_embed_url'] = $you_tube_embed_url;
                $insert_arr['short_description'] = $short_description;
                $insert_arr['status'] = $status;

                $insert_id = $this->Common_model->insert('bi_event', $insert_arr);

                if (!empty($insert_id)) {
                    $succ_msg = "Event Added Successfully";
                    $this->session->set_flashdata('success', $succ_msg);
                    redirect('admin/BI/event/');
                }
            }
        }

        $this->load->view("admin/insights/event/add", $data);
    }

    public function ajax_get_events() {
        $columns = array(
            0 => 'id',
            1 => 'title',
            2 => 'event_image',
            3 => 'youtube_embed_url',
            4 => 'short_description',
            5 => 'status',
            6 => 'date_created',
        );

        $limit = $this->input->post('length');
        $start = $this->input->post('start');
        $order = $columns[$this->input->post('order')[0]['column']];
        $dir = $this->input->post('order')[0]['dir'];

        $totalData = $this->Common_model->select('count(id)', 'bi_supplier_news')[0]['count_id'];

        $totalFiltered = $totalData;

        if (empty($this->input->post('search')['value'])) {
            $list = $this->Common_model->select('*', 'bi_event', '', array(1 => array('colname' => $order, 'type' => 'DESC')), $limit, $start);
        } else {
            $search = $this->input->post('search')['value'];

            $list = $this->event_search($limit, $start, $search, $order, $dir);

            $totalFiltered = $this->event_search_count($search);
        }

        $data = array();
        if (!empty($list)) {
            foreach ($list as $row) {
                $nestedData['id'] = $row['id'];
                $nestedData['title'] = $row['title'];
                $nestedData['event_image'] = '<img src="' . $row['event_image'] . '" style="height:50px;width:50px">';
                $nestedData['you_tube_embed_url'] = $row['you_tube_embed_url'];
                $nestedData['short_description'] = $row['short_description'];
                $nestedData['status'] = $row['status'];
                $nestedData['date_created'] = $row['date_created'];
                $nestedData['action'] = ' 
				          <a href="' . base_url() . 'admin/BI/event/edit/' . $row['id'] . '" class="tabledit-edit-button btn btn-primary waves-effect waves-light btn-sm" data-toggle="tooltip" data-placement="top" title="Edit" data-original-title="Edit"><i class="fa fa-pencil-square-o"></i></a>
                                          <a href="' . base_url() . 'admin/BI/event/delete/' . $row['id'] . '" class="tabledit-delete-button btn btn-danger waves-effect waves-light btn-sm" data-toggle="tooltip" data-placement="top" title="Delete" data-original-title="Delete" onclick="if (!confirm(\'Are you sure you want to delete this record?\')) return false;"><i class="fa fa-trash"></i></a>';

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
                ->like('title', $search)
                ->or_like('you_tube_embed_url', $search)
                ->or_like('short_description', $search)
                ->or_like('status', $search)
                ->or_like('date_created', $search)
                ->get("event");

        return $query->num_rows();
    }

    function event_search($limit, $start, $search, $col, $dir) {
        $query = $this
                ->db
                ->select('*')
                ->like('title', $search)
                ->or_like('youtube_embed_url', $search)
                ->or_like('short_description', $search)
                ->or_like('status', $search)
                ->or_like('date_created', $search)
                ->limit($limit, $start)
                ->order_by($col, $dir)
                ->get("event");

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
            $record = $this->Common_model->getAll('bi_event', ['id' => $id])->result();
            if (isset($_POST['submit']) && $_POST['submit'] != '') {
                $id = $this->input->post('id');

                $this->form_validation->set_rules('title', 'Title', 'required|callback_check_title_update|min_length[10]|max_length[60]');
                $this->form_validation->set_rules('you_tube_embed_url', 'You Tube Embed URL', 'required');
                $this->form_validation->set_rules('short_description', 'Short Description', 'required|min_length[10]|max_length[100]');
                $this->form_validation->set_rules('status', 'Status', 'required');

                if ($this->form_validation->run() == false) {
                    $err_msg = validation_errors();
                    $this->session->set_flashdata('error', $err_msg);
                } else {
                    $title = $this->input->post('title');
                    $you_tube_embed_url = $this->input->post('you_tube_embed_url');
                    $short_description = $this->input->post('short_description');
                    $status = $this->input->post('status');

                    $insert_arr = array();

                    if (!empty($_FILES) && isset($_FILES['event_image']) && !empty($_FILES['event_image'])) {
                        $s3FilePath = $this->awsupload->upload('event_image', 'uploads/images/bi_event', 'image');
                        if ($s3FilePath == false) {
                            //error
                            $msg = '<div class="alert alert-danger alert-dismissible">
                                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                        <strong>Error!</strong> File type not allowed.!
                                    </div>';
                            $this->session->set_flashdata('message', $msg);
                            redirect('Event/edit/'.$id);
                        } else {
                            //success
                            $insert_arr['event_image'] = $s3FilePath;
                        }
                    }

                    $insert_arr['title'] = $title;
                    $insert_arr['you_tube_embed_url'] = $you_tube_embed_url;
                    $insert_arr['short_description'] = $short_description;
                    $insert_arr['status'] = $status;
                    $affected_rows = $this->Common_model->update('bi_event', $insert_arr, ['id' => $id]);

                    $succ_msg = "Event Updated Successfully";
                    $this->session->set_flashdata('success', $succ_msg);
                    redirect('admin/BI/event/');
                }
            }

            if (!empty($record)) {
                $data['record'] = $record[0];
                $this->load->view('admin/common/header');
                $this->load->view('admin/common/sidebar');
                $this->load->view("admin/insights/event/edit", $data);
                $this->load->view('admin/common/footer');
            }
        }
    }

    public function check_title_update() {
        $id = $this->input->post('id');
        $title = $this->input->post('title');
        $response = true;
        $rec = $this->Common_model->select('*', 'bi_event', ['title' => $title, 'id !=' => $id]);
//         echo "<pre>";
//         print_r($rec);
//        exit;
        if (!empty($rec)) {
            $this->form_validation->set_message('check_title_update', 'Event Title must be unique');
            $response = false;
        }
        return $response;
    }

    public function delete($id) {
        if ($id) {
            $delete_status = $this->Common_model->delete('bi_event', ['id' => $id]);
            if ($delete_status == 1) {
                $this->session->set_flashdata('error', 'Record Deleted');
                redirect('admin/BI/event');
            }
        }
    }

}
