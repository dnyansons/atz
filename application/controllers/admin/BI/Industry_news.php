<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Industry_news extends CI_Controller {

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

    public function index() {
        $data = array();
        $this->load->view("admin/insights/industry_news/index", $data);
    }

    public function ajax_get_industry_news() {
        $columns = array(
            0 => 'id',
            1 => 'topic',
            2 => 'publisher_logo',
            3 => 'publisher',
            4 => 'date_created',
            5 => 'status'
        );

        $limit = $this->input->post('length');
        $start = $this->input->post('start');
        $order = $columns[$this->input->post('order')[0]['column']];
        $dir = $this->input->post('order')[0]['dir'];

        $totalData = $this->Common_model->select('count(id)', 'bi_industry_news')[0]['count_id'];

        $totalFiltered = $totalData;

        if (empty($this->input->post('search')['value'])) {
            $list = $this->Common_model->select('*', 'bi_industry_news', '', array(1 => array('colname' => $order, 'type' => 'DESC')), $limit, $start);
        } else {
            $search = $this->input->post('search')['value'];

            $list = $this->industry_news_search($limit, $start, $search, $order, $dir);

            $totalFiltered = $this->industry_news_search_count($search);
        }

        $data = array();
        if (!empty($list)) {
            foreach ($list as $row) {
                $nestedData['id'] = $row['id'];
                $nestedData['topic'] = $row['topic'];
                $nestedData['publisher_logo'] = '<img src="' . base_url('uploads/images/publisher_logo/' . $row['publisher_logo']) . '" style="height:30px;width:30px">';
                $nestedData['publisher'] = $row['publisher'];
                $nestedData['date_created'] = $row['date_created'];
                $nestedData['status'] = $row['status'];
                $nestedData['action'] = ' <a href="' . base_url() . 'admin/BI/industry_news/view/' . $row['id'] . '" class="tabledit-delete-button btn btn-success waves-effect waves-light btn-sm" data-toggle="tooltip" data-placement="top" title="View" data-original-title="Delete"><i class="fa fa-eye"></i></a>
				          <a href="' . base_url() . 'admin/BI/industry_news/edit/' . $row['id'] . '" class="tabledit-edit-button btn btn-primary waves-effect waves-light btn-sm" data-toggle="tooltip" data-placement="top" title="Edit" data-original-title="Edit"><i class="fa fa-pencil-square-o"></i></a>
                                          <a href="' . base_url() . 'admin/BI/industry_news/delete/' . $row['id'] . '" class="tabledit-delete-button btn btn-danger waves-effect waves-light btn-sm" data-toggle="tooltip" data-placement="top" title="Delete" data-original-title="Delete" onclick="if (!confirm(\'Are you sure you want to delete this record?\')) return false;"><i class="fa fa-trash"></i></a>';

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

    public function industry_news_search_count($search) {
        $query = $this
                ->db
                ->like('topic', $search)
                ->or_like('publisher', $search)
                ->or_like('status', $search)
                ->get("bi_industry_news");

        return $query->num_rows();
    }

    function industry_news_search($limit, $start, $search, $col, $dir) {
        $query = $this
                ->db
                ->select('*')
                ->like('topic', $search)
                ->or_like('publisher', $search)
                ->or_like('date_created', $search)
                ->or_like('status', $search)
                ->limit($limit, $start)
                ->order_by($col, $dir)
                ->get("bi_industry_news");

        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return null;
        }
    }

    public function add() {
        $data = [];

        if (isset($_POST['submit']) && $_POST['submit'] != '') {
            $this->form_validation->set_rules('topic', 'Topic', 'required|is_unique[bi_industry_news.topic]');
            $this->form_validation->set_rules('short_description', 'Short Description', 'required|is_unique[bi_industry_news.topic]');
            $this->form_validation->set_rules('publisher', 'Publisher', 'required');
            $this->form_validation->set_rules('publisher_url', 'News URL', 'required');

            if ($this->form_validation->run() == false) {
                $err_msg = validation_errors();
                $this->session->set_flashdata('error', $err_msg);
            } else {
                $topic = $this->input->post('topic');
                $publisher = $this->input->post('publisher');
                $publisher_url = $this->input->post('publisher_url');
                $short_description = $this->input->post('short_description');
                $status = $this->input->post('status');

                $insert_arr = array();

                if (!empty($_FILES) && isset($_FILES['publisher_logo']) && !empty($_FILES['publisher_logo'])) {
                    $s3FilePath = $this->awsupload->upload('publisher_logo', 'uploads/images/publisher_logo', 'image');
                    if ($s3FilePath == false) {
                        //error
                        $msg = '<div class="alert alert-danger alert-dismissible">
                                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                        <strong>Error!</strong> File type not allowed.!
                                    </div>';
                        $this->session->set_flashdata('message', $msg);
                        redirect('Industry_news/add');
                    } else {
                        //success
                        $insert_arr['publisher_logo'] = $s3FilePath;
                    }
                }

                if (!empty($_FILES) && isset($_FILES['news_category_image']) && !empty($_FILES['news_category_image'])) {
                    $s3FilePath = $this->awsupload->upload('news_category_image', 'uploads/images/news_category_image', 'image');
                    if ($s3FilePath == false) {
                        //error
                        $msg = '<div class="alert alert-danger alert-dismissible">
                                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                        <strong>Error!</strong> File type not allowed.!
                                    </div>';
                            $this->session->set_flashdata('message', $msg);
                            redirect('Industry_news/add');
                    } else {
                        //success
                        $insert_arr['news_category_image'] = $s3FilePath;
                    }
                }

                $insert_arr['topic'] = $topic;
                $insert_arr['publisher'] = $publisher;
                $insert_arr['publisher_url'] = $publisher_url;
                $insert_arr['short_description'] = $short_description;
                $insert_arr['status'] = $status;

                $insert_id = $this->Common_model->insert('bi_industry_news', $insert_arr);

                if (!empty($insert_id)) {
                    $succ_msg = "Industry News Added Successfully";
                    $this->session->set_flashdata('success', $succ_msg);
                    redirect('admin/BI/industry_news/');
                }
            }
        }

        $this->load->view("admin/insights/industry_news/add", $data);
    }

    public function view($id) {
        $data = array();
        if ($id) {
            $details = $this->Common_model->select('*', 'bi_industry_news', ['id' => $id]);
            if (!empty($details)) {

                $data['details'] = $details[0];
                $this->load->view("admin/insights/industry_news/view", $data);
            }
        }
    }

    public function edit($id) {
        $data = array();
        if ($id) {
            $record = $this->Common_model->getAll('bi_industry_news', ['id' => $id])->result();
            if (isset($_POST['submit']) && $_POST['submit'] != '') {
                $id = $this->input->post('id');

                $this->form_validation->set_rules('topic', 'Topic', 'required|callback_check_news_topic_update');
                $this->form_validation->set_rules('short_description', 'Short Description', 'required');
                $this->form_validation->set_rules('publisher', 'Publisher', 'required');
                $this->form_validation->set_rules('publisher_url', 'News URL', 'required');

                if ($this->form_validation->run() == false) {
                    $err_msg = validation_errors();
                    $this->session->set_flashdata('error', $err_msg);
                } else {

                    $topic = $this->input->post('topic');
                    $publisher = $this->input->post('publisher');
                    $publisher_url = $this->input->post('publisher_url');
                    $short_description = $this->input->post('short_description');
                    $status = $this->input->post('status');

                    $insert_arr = array();

                    if (!empty($_FILES) && isset($_FILES['publisher_logo']) && !empty($_FILES['publisher_logo'])) {
                        $s3FilePath = $this->awsupload->upload('publisher_logo', 'uploads/images/publisher_logo', 'image');
                        if ($s3FilePath == false) {
                            //error
                            $msg = '<div class="alert alert-danger alert-dismissible">
                                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                        <strong>Error!</strong> File type not allowed.!
                                    </div>';
                            $this->session->set_flashdata('message', $msg);
                            redirect('Industry_news/edit/'.$id);
                        } else {
                            //success
                            $insert_arr['publisher_logo'] = $s3FilePath;
                        }
                    }

                    if (!empty($_FILES) && isset($_FILES['news_category_image']) && !empty($_FILES['news_category_image'])) {
                        $s3FilePath = $this->awsupload->upload('news_category_image', 'uploads/images/news_category_image', 'image');
                        if ($s3FilePath == false) {
                            //error
                            $msg = '<div class="alert alert-danger alert-dismissible">
                                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                        <strong>Error!</strong> File type not allowed.!
                                    </div>';
                            $this->session->set_flashdata('message', $msg);
                            redirect('Industry_news/edit/'.$id);
                        } else {
                            //success
                            $insert_arr['news_category_image'] = $s3FilePath;
                        }
                    }

                    $insert_arr['topic'] = $topic;
                    $insert_arr['publisher'] = $publisher;
                    $insert_arr['publisher_url'] = $publisher_url;
                    $insert_arr['short_description'] = $short_description;
                    $insert_arr['status'] = $status;

                    $affected_rows = $this->Common_model->update('bi_industry_news', $insert_arr, ['id' => $id]);

                    $succ_msg = "Industry News Updated Successfully";
                    $this->session->set_flashdata('success', $succ_msg);
                    redirect('admin/BI/industry_news/');
                }
            }

            if (!empty($record)) {
                $data['record'] = $record[0];
                $this->load->view('admin/common/header');
                $this->load->view('admin/common/sidebar');
                $this->load->view("admin/insights/industry_news/edit", $data);
                $this->load->view('admin/common/footer');
            }
        }
    }

    public function check_news_topic_update() {
        $id = $this->input->post('id');
        $topic = $this->input->post('topic');
        $response = true;
        $rec = $this->Common_model->select('*', 'bi_industry_news', ['topic' => $topic, 'id !=' => $id]);
//         echo "<pre>";
//         print_r($rec);
//        exit;
        if (!empty($rec)) {
            $this->form_validation->set_message('check_topic_update', 'Topic must be unique on update');
            $response = false;
        }
        return $response;
    }

    public function delete($id) {
        if ($id) {
            $delete_status = $this->Common_model->delete('bi_industry_news', ['id' => $id]);
            if ($delete_status == 1) {
                $this->session->set_flashdata('error', 'Record Deleted');
                redirect('admin/BI/industry_news');
            }
        }
    }

}
