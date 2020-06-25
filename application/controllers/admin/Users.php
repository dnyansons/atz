<?php

defined('BASEPATH') OR exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;


class Users extends CI_Controller {

    private $defaultTable = 'users';

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
        $this->load->model('Users_model');
        $this->load->model('Common_model');
        $this->load->model('Company_model');
        $this->load->model('Myorders_model');
        $this->load->model('Order_model');
        $this->load->model('Packages_model');
        $this->load->model('Wallet_model');
        $this->load->library('Userpermission');
        $this->load->library('awsupload');
        $this->load->library('Send_data');
        $this->load->model('Download_excel_model');
    }

    public function index() {
        $data["pageTitle"] = "Active Users";
        $data['status'] = 1;
        $this->load->view("admin/users/list", $data);
    }

    public function inactive() {
        $data["pageTitle"] = "Active Users";
        $data['status'] = 0;
        $this->load->view("admin/users/list", $data);
    }

    public function ajax_list() {
        $active_status = $this->input->post('status');
        $from = $this->input->post("dateFrom");
        $to = $this->input->post("dateTo");
        $users = $this->Users_model->get_datatablesUsers($active_status,$from,$to);
        $data = array();
        $no = $this->input->post('start');
        foreach ($users as $user) {
            if ($user->status == 1) {
                $status = '<a href="javascript:void(0);" style="color:green;font-weight:bold;"  data-toggle="modal" data-target="#active_inactive_modal" data-user_id="' . $user->id . '" data-status="' . $user->status . '">Active</a>';
            } else {
                $status = '<a href="javascript:void(0);" style="color:red;font-weight:bold;"  data-toggle="modal" data-target="#active_inactive_modal" data-user_id="' . $user->id . '" data-status="' . $user->status . '">Inactitve</a>';
            }

            $no++;
            $details = array();
            $details[] = $user->id;
            $details[] = $user->first_name . ' ' . $user->last_name;
            $details[] = $user->email;
            $details[] = '<a  class="badge badge-success" href="' . base_url('admin/users/view_history') . '/' . $user->role . '/' . $user->id . '" >' . $user->balance . ' </a>';
            $details[] = $user->phone;
            if ($user->total_orders) {
                $details[] = "<a href='".site_url()."admin/users/user_order/".$user->id."' class='btn btn-info'>".$user->total_orders."</a>";
            } else {
                $details[] = "0";
            }

            if (trim($user->status) == 0) {
                //show remove / unban user modal data
                $ban_page_text = "<div class='form-group'>Username : " .
                        $user->first_name . ' ' . $user->last_name . '</div>';
                $ban_page_text .= "<div class='form-group'><label for='comment'><b>Banning Reason : </b></label> " .
                        $user->ban_comment . "
                                <input type='hidden' id='ban_id' value='" . $user->id . "'></div>";
                $ban_details = '<a data-toggle="modal" data-id="' . $ban_page_text . '" data-target="#unBanModal" class="dropdown-item open-unban-events" ><i class="fa fa-ban"></i>Ban User</a>';
            } else {
                //show ban user modal data
                $ban_page_text = "<div class='form-group'>Username : " .
                        $user->first_name . ' ' . $user->last_name . '</div>';
                $ban_page_text .= "<div class='form-group'><label for='comment'><b>Banning Reason</b></label>" .
                        "<textarea required class='form-control' name='ban_comment' id='ban_comment'></textarea>
                                <input type='hidden' id='ban_id' value='" . $user->id . "'>
                                </div>";
                $ban_details = '<a data-toggle="modal" data-id="' . $ban_page_text . '" data-target="#banModal" class="dropdown-item open-ban-events" ><i class="fa fa-ban"></i>Ban User</a>';
            }

            $details[] = date("d-m-Y h:i:s", strtotime($user->created_on));
            $details[] = '<button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-cog" aria-hidden="true"></i></button>
			<div class="dropdown-menu dropdown-menu-right b-none contact-menu" style="width:55px;">
				<a class="dropdown-item" href="' . site_url() . 'admin/users/user_view/' . $user->id . '"><i class="fa fa-eye"></i>view Profile</a>
                <a class="dropdown-item" href="' . site_url() . 'admin/users/user_order/' . $user->id . '"><i class="fa fa-edit"></i>Orders</a>
                ' . $ban_details . '</div>';

            $data[] = $details;
        }

        $output = array(
            "draw" => $this->input->post('draw'),
            "recordsTotal" => $this->Users_model->count_all_users($active_status),
            "recordsFiltered" => $this->Users_model->count_filtered_users($active_status,$from,$to),
            "data" => $data,
        );
        echo json_encode($output);
    }

    function user_order($user_id = 0) {
        $data['user'] = $this->Common_model->getAll('users', array('id' => $user_id))->row_array();
        $this->db->select('O.orders_id,O.order_price,OS.orders_status_name,O.date_purchased');
        $this->db->join("orders_status OS","O.orders_status = OS.orders_status_id");
        $data["orders"] = $this->db->get_where("orders O",["O.user_id"=>$user_id])->result();
        
        if (!empty($data['user'])) {
            $data['user_id'] = $user_id;
            $this->load->view('admin/order/buyer/all_order', $data);
        } else {
            redirect("admin/users", "refresh");
        }
    }

    function user_view($user_id = '') {
        $this->Users_model->read_buyer_notification();
        if ($user_id != '') {
            $data['user_id'] = $user_id;
            $data['user'] = $this->Users_model->getUserAsSellerInfo($user_id);
            $data['user_id'] = $user_id;
            $data['company'] = $this->Company_model->getCompanyDetailsBySeller($user_id);
            $company_document_titles = $this->Common_model->select('*', 'company_documents', ['user_id' => $user_id]);
            $company_document_status = $this->Common_model->getSellerDetails($user_id);
            $seller_pickup_addr = $this->Common_model->getSellerPickupAddres($user_id);

            $role = $data['user']->role;
            $data['role'] = $data['user']->role;

            if ($role == 'seller') {
                $data['pkg_data'] = $this->Packages_model->get_all_user_pkg_info($user_id);
            } else {
                $data['pkg_data'] = 0;
            }

            if (!empty($company_document_titles)) {
                $i = 0;
                foreach ($company_document_titles as $doc_title) {
                
                    $company_document_titles[$i]['files'] = $this->Common_model->select('file', 'company_document_files', ['company_document_title_id' => $doc_title['id']]);
                    $i++;
                }
            }
            $data['company_document_titles'] = $company_document_titles;
            $data['company_document_status'] = $company_document_status;
            $data['seller_pickup_addr'] = $seller_pickup_addr;

            $this->db->select('*');
            $this->db->from('supplier_bank_details a');
            $this->db->join('banks b', 'a.bank=b.id');
            $this->db->where('a.user_id', $user_id);
            $data['bank_details'] = $this->db->get()->result();

            //$data['bank_details'] =$this->Common_model->getAll('supplier_bank_details',array('user_id'=>$user_id))->result();
            ////Company Progress Bar
            $cal_per = $this->calculate_per($data['company']);

            //Total Field 28
            $data['pro_per'] = number_format(($cal_per / 28) * 100, 2);

            $this->load->view('admin/users/user_details', $data);
        } else {
            redirect('admin');
        }
    }

    function getEmail($user_id) {
        $this->load->library("form_validation");
        $this->form_validation->set_error_delimiters('<div class="text-danger pt-3">', '</div>');
        $this->form_validation->set_rules("email", "Email", "trim|required|valid_email|is_unique[users.username]", [
            "is_unique" => "This email id is already registered"
        ]);
        if ($this->form_validation->run() === false) {
           
            $data['details'] = $this->Users_model->getEmailMobile($user_id);
            $this->load->view('admin/common/header');
            $this->load->view('admin/users/update_user_email', $data);
            $this->load->view('admin/common/footer');
        } else {
            $data['email'] = $this->input->post('email');
            $data['username'] = $this->input->post('email');
            $res = $this->Users_model->updateEmailMobile($user_id, $data, $phone = '');
            $success = '<div class="alert alert-success alert-dismissible">
                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                <strong>Success!</strong> Updated successfully.
                                </div>';
            $this->session->set_flashdata('message', $success);
            redirect("admin/users/getEmail/" . $user_id);
        }
    }

    function getMobile($user_id) {
        $this->load->library("form_validation");
        $this->form_validation->set_error_delimiters('<div class="text-danger pt-3">', '</div>');
        $this->form_validation->set_rules('phone', 'Mobile Number ', 'required|is_unique[users.phone]|regex_match[/^[0-9]{10}$/]'); //{10} for 10 digits number
        if ($this->form_validation->run() === false) {

            $data['details'] = $this->Users_model->getEmailMobile($user_id);
            $this->load->view('admin/common/header');
            $this->load->view('admin/users/update_user_mobile', $data);
            $this->load->view('admin/common/footer');
        } else {
            $phone = $this->input->post('phone');
            $res = $this->Users_model->updateEmailMobile($user_id, $data = '', $phone);
            $success = '<div class="alert alert-success alert-dismissible">
                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                <strong>Success!</strong> Updated successfully.
                                </div>';
            $this->session->set_flashdata('message', $success);
            redirect("admin/users/getMobile/" . $user_id);
        }
    }

    function calculate_per($comp) {
        $i = 0;
        if (!empty($comp->company_name)) {
            $i++;
        }
        if (!empty($comp->logo)) {
            $i++;
        }
        if (!empty($comp->primary_business_type)) {
            $i++;
        }
        if (!empty($comp->optional_business_type)) {
            $i++;
        }
        if (!empty($comp->secondary_business_type)) {
            $i++;
        }
        if (!empty($comp->introduction)) {
            $i++;
        }
        if (!empty($comp->registration_state)) {
            $i++;
        }
        if (!empty($comp->location_country)) {
            $i++;
        }
        if (!empty($comp->comp_operational_addr)) {
            $i++;
        }
        if (!empty($comp->comp_operational_state)) {
            $i++;
        }
        if (!empty($comp->comp_operational_region)) {
            $i++;
        }
        if (!empty($comp->comp_operational_zip_code)) {
            $i++;
        }
        if (!empty($comp->building_number_and_street)) {
            $i++;
        }
        if (!empty($comp->main_products)) {
            $i++;
        }
        if (!empty($comp->other_products)) {
            $i++;
        }
        if (!empty($comp->year_of_register)) {
            $i++;
        }
        if (!empty($comp->no_of_employee)) {
            $i++;
        }
        //////////////////////
        if (!empty($comp->company_url)) {
            $i++;
        }
        if (!empty($comp->legal_owner)) {
            $i++;
        }
        if (!empty($comp->office_size)) {
            $i++;
        }
        if (!empty($comp->comp_advantages)) {
            $i++;
        }
        if (!empty($comp->no_of_employee)) {
            $i++;
        }
        if (!empty($comp->display_production_process)) {
            $i++;
        }if (!empty($comp->display_production_equipments)) {
            $i++;
        }if (!empty($comp->display_production_line)) {
            $i++;
        }if (!empty($comp->factory_location)) {
            $i++;
        }if (!empty($comp->factory_size)) {
            $i++;
        }
        if (!empty($comp->oc_staff_count)) {
            $i++;
        }
        return $i;
    }

    public function buyer_ajax_list($user_id = '') {
        $this->output->enable_profiler(true);
        $ret_id = $user_id;
        $columns = array(
            0 => 'orders_id',
            1 => 'order_price',
            2 => 'orders_status_name',
            3 => 'date_purchased',
        );

        $limit = $this->input->post('length');
        $start = $this->input->post('start');
        $order = $columns[$this->input->post('order')[1]['column']];
        $dir = $this->input->post('order')[1]['dir'];
        
        $totaldata = $this->Myorders_model->allorders_count($ret_id);
        $totalfiltered = $totaldata;
        
        if (empty($this->input->post('search')['value'])) {
            $alorder = $this->Myorders_model->allorders($ret_id, $limit, $start, $order, $dir);
        } else {
            $search = $this->input->post('search')['value'];
            $alorder = $this->Myorders_model->order_search($ret_id, $limit, $start, $search, $order, $dir);
            $totalfiltered = $this->Myorders_model->order_search_count($ret_id, $search);
        }

        $data = array();
        if (!empty($alorder)) {
            foreach ($alorder as $br) {
                $nestedData['orders_id'] = $br->orders_id;
                $nestedData['order_price'] = $br->order_price;

                $nestedData['orders_status_name'] = $br->orders_status_name;
                $nestedData['date_purchased'] = date('d-m-Y', strtotime($br->date_purchased));
                $nestedData['action'] = '<a type="button" href="' . base_url() . 'admin/users/buyer_order_view/' . $br->orders_id . '" class="btn btn-warning btn-sm">View&nbsp;Detail</a>';

                $data[] = $nestedData;
            }
        }

        $json_data = array(
            "draw" => intval($this->input->post('draw')),
            "recordsTotal" => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data" => $data
        );

        //echo json_encode($json_data);
    }

    ////Seller Order user wise
//    public function seller_ajax_list($user_id) {
//
//
//        $columns = array(
//            0 => 'orders_id',
//            1 => 'user_name',
//            2 => 'orders_status_name',
//            3 => 'order_price',
//            4 => 'date_purchased',
//        );
//
//        $limit = $this->input->post('length');
//        $start = $this->input->post('start');
//        $order = $columns[$this->input->post('order')[0]['column']];
//        $dir = $this->input->post('order')[0]['dir'];
//
//        $totalData = $this->Order_model->seller_all_order_count($user_id);
//
//
//        $totalFiltered = $totalData;
//
//        if (empty($this->input->post('search')['value'])) {
//            $allorder = $this->Order_model->seller_allorder($user_id, $limit, $start, $order, $dir);
//            //echo $this->db->last_query();
//            //echo'<pre>';
//            //print_r($allorder);
//        } else {
//            $search = $this->input->post('search')['value'];
//
//            $allorder = $this->Order_model->seller_order_search($user_id, $limit, $start, $search, $order, $dir);
//            //echo $this->db->last_query();
//
//            $totalFiltered = $this->Order_model->seller_order_search_count($user_id, $search);
//        }
//
//        $data = array();
//        if (!empty($allorder)) {
//            //echo'<pre>';
//            //print_r($allorder);
//            foreach ($allorder as $br) {
//                $nestedData['orders_id'] = $br->orders_id;
//                $nestedData['user_name'] = $br->user_name;
//                $nestedData['orders_status_name'] = $br->orders_status_name;
//                $nestedData['order_price'] = $br->order_price;
//                $nestedData['date_purchased'] = date('d-m-Y', strtotime($br->date_purchased));
//                $nestedData['action'] = '<a type="button" href="' . base_url() . 'admin/order/view/' . $br->orders_id . '" class="btn btn-warning btn-sm">View&nbsp;Detail</a>';
//
//                $data[] = $nestedData;
//            }
//        }
//
//        $json_data = array(
//            "draw" => intval($this->input->post('draw')),
//            "recordsTotal" => intval($totaldata),
//            "recordsFiltered" => intval($totalfiltered),
//            "data" => $data
//        );
//
//        echo json_encode($json_data);
//    }

//    function buyer_order_view($order_id) {
//        $data['sorder'] = $this->Myorders_model->single_order($order_id);
//        $data['products'] = $this->Myorders_model->order_products($order_id);
//
//        $this->load->view("admin/order/buyer/order_view", $data);
//    }

    function review_view() {

        $products_id = $this->input->post('products_id');
        $myreview = $this->Myorders_model->allproduct_review($products_id);

        $str = '';
        $str .= '<table class="table table-striped table-bordered nowrap dataTable">';
        $i = 1;
        foreach ($myreview as $re) {
            $not_rating = 5 - $re->reviews_rating;
            $rating = $re->reviews_rating;
            $str .= '<tr>';
            $str .= '<th>Review</th>';
            $str .= '<td>' . $re->review_text . '</td>';
            $str .= '</tr>';
            $str .= '<tr>';

            $str .= '<th>Rating</th>';
            $str .= '<td>';
            for ($i = 1; $i <= $rating; $i++) {
                $str .= '<span class="fa fa-star checked_star"></span>';
            }
            for ($i = 1; $i <= $not_rating; $i++) {
                $str .= '<span class="fa fa-star"></span>';
            }
            $str .= '</td>';

            $str .= '</tr>';
            $str .= '<tr>';
            $str .= '<th>Date Added</th>';
            $str .= '<td>' . $re->date_added . '</td>';
            $str .= '</tr>';
            $i++;
        }
        $str .= '</table>';
        echo $str;
    }

    function update_appr_status() {

        $user_id = $this->input->post('user_id');
        $status = $this->input->post('status');
        $admin_id = $this->session->userdata("admin_id");

        if (!empty($user_id) && !empty($status)) {
            $data['approved_status'] = $status;
            $data['approved_by'] = $admin_id;
            $flag = $this->Common_model->update('users', $data, array('id' => $user_id));
            $userWallet = $this->Wallet_model->getWallerBySellerId($user_id);
//            echo "<pre>";
//            print_r($userWallet);
            if ($status == "Approved" && !$userWallet) {
                $insertWalletData = [
                    "vendor_id" => $user_id,
                    "available_balance" => 0,
                    "available_balance" => 0,
                    "pending_balance" => 0,
                    "hold_balance" => 0,
                    "settled_balance" => 0,
                ];
                $this->Wallet_model->createWallet($insertWalletData);
            }


            echo 'success';
        } else {
            echo'error';
        }
    }

    public function upload_user_company_documents($user_id) {
        $this->load->helper('file');
        $data = array();

        if (isset($_POST['submit']) && $_POST['submit'] != '') {

            $this->form_validation->set_rules('certificate_title', 'Title', 'required');
           
            if ($this->form_validation->run() == false) {
                $validation_erros = validation_errors();
                $this->session->set_flashdata('message', $validation_erros);
            } else {

                // $img_arr = array();
                if (!empty($_FILES['files']['name'])) {

                    $s3FilePath = $this->awsupload->upload('files', 'uploads/company_docs', 'company_docs');
                    if ($s3FilePath == false) {
                        //error
                         // $msg= $this->upload->display_errors();
                        $msg = '<div class="alert alert-danger alert-dismissible">
                                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                    <strong>Error!</strong> Something went wrong. File Type Not Allowed.! </div>';

                        $this->session->set_flashdata('message', $msg);
                        redirect('admin/users/upload_user_company_documents/' . $user_id);
                        exit;
                    } else {
                        //success
                        $title = $this->input->post('certificate_title');
                        $user_id = $this->input->post('user_id');
                        $insert_arr = array();
                        $insert_arr['title'] = $title;
                        $insert_arr['user_id'] = $user_id;
                        $insert_arr['file_status'] = '';
                        $insert_id = $this->Common_model->insert('company_documents', $insert_arr);

                        // array_push($img_arr, $files['files']['name'][$i]);
                        $file_insert_arr = array();
                        $file_insert_arr['company_document_title_id'] = $insert_id;
                        $file_insert_arr['file'] = $s3FilePath;

                        $this->Common_model->insert('company_document_files', $file_insert_arr);

                        $msg = '<div class="alert alert-success alert-dismissible">
                                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                    <strong>Success!</strong> Company Documents Uploaded Successfully.!
                                </div>';

                        $this->session->set_flashdata('message', $msg);
                       // redirect('admin/users/user_view/' . $user_id);
                    }
                }
            }
        }
        $data['user_id'] = $user_id;
        $this->load->view('admin/users/upload_company_documents', $data);
    }

    /*
      @author Ishwar
     * file value and type check during validation
     */

    public function file_check($str) {
        $allowed_mime_type_arr = array('application/pdf', 'image/jpeg', 'image/jpg', 'image/png');
        $mime = get_mime_by_extension($_FILES['files']['name']);
        if (isset($_FILES['files']['name']) && $_FILES['files']['name'] != "") {
            if (in_array($mime, $allowed_mime_type_arr)) {
                return true;
            } else {

                $msg = '<div class="alert alert-danger alert-dismissible">
                                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                    <strong>Error!</strong> Please select only pdf/jpg/png file.!
                                </div>';
                $this->session->set_flashdata('message', $msg);
                redirect('admin/users/upload_user_company_documents/' . $user_id);
                // $this->form_validation->set_message('file_check', 'Please select only pdf/jpg/png file.');
                return false;
            }
        } else {

            $msg = '<div class="alert alert-danger alert-dismissible">
                                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                    <strong>Error!</strong> Please choose a file to upload.!
                                </div>';
            $this->session->set_flashdata('message', $msg);
            redirect('admin/users/upload_user_company_documents/' . $user_id);
            // $this->form_validation->set_message('file_check', 'Please choose a file to upload.');
            return false;
        }
    }

    public function view_user_company_documents($user_id) {
        $data = array();
        $record = $this->Common_model->select('cd.*,cdf.file', 'company_documents cd', ['cd.id' => $id], '', '', '',
                array(1 => array('tableName' => 'company_document_files cdf', 'columnNames' => 'cd.id = cdf.company_document_title_id', 'jType' => 'right')));

//        echo "<pre>";
//        print_r($record);
//        exit;

        if (!empty($record)) {
            $data['record'] = $record[0];
            $files_arr = array();
            foreach ($record as $file) {
                array_push($files_arr, $file['file']);
            }

            $data['files'] = $files_arr;
//            echo "<pre>";
//            print_r($data);
//            exit;
            $this->load->view('admin/users/view_user_company_documents', $data);
        } else {
            echo 'Record Not Found';
        }
    }

    private function set_upload_options_company_docs() {
        //upload an image options
        $config = array();
        $config['upload_path'] = './uploads/company_docs/';
        $config['allowed_types'] = 'jpeg|jpg|png|pdf';
        $config['max_size'] = '0';
        $config['overwrite'] = FALSE;

        return $config;
    }

    public function updateUserStatus() {
        $user_id = $this->input->post('user_id');
        $status = $this->input->post('status');


        if (isset($user_id) && isset($status)) {

            if ($status == 1) {
                $status = 0;
            } else if ($status == 0) {
                $status = 1;
            }

            $data['status'] = $status;
            $this->Common_model->update('users', $data, array('id' => $user_id));
            echo json_encode(array('status' => 'success', 'res' => $status));
            exit;
        } else {
            echo json_encode(array('status' => 'error'));
            exit;
        }
    }

    public function ajaxUserInfo() {
        $output = [
            "status" => 0,
            "message" => "Invalid inputs",
            "data" => []
        ];
        $this->form_validation->set_rules("seller_id", "seller", "required");
        if ($this->form_validation->run() == false) {
            echo json_encode($output);
        } else {
            $seller_id = $this->input->post("seller_id");
            $userInfo = $this->Users_model->getUserById($seller_id);
            $output["status"] = 1;
            $output["message"] = "Success";
            $output["data"] = $userInfo;
            echo json_encode($output);
        }
    }

    /**
     * @auther Yogesh Pardeshi
     * @param user_id to be banned
     * @param admin_id who bans 
     * @param comment reason for banning
     */
    public function ban_user() {
        $user_to_banned = $this->security->xss_clean($this->input->post('user_id'));
        $ban_comment = $this->security->xss_clean($this->input->post('ban_comment'));

        if (empty($this->session->admin_id) || empty($user_to_banned) || empty($ban_comment)) {
            echo 'invalid access';
            return;
        } else {
            $update_fields = array('banned_by' => $this->session->admin_id,
                'status' => 0,
                'ban_comment' => $ban_comment);

            $this->db->where('id', $user_to_banned);
            $this->db->update($this->defaultTable, $update_fields);

            if ($this->db->affected_rows()) {
                $this->session->set_flashdata('message', 'User banned successfully!');
                echo 'success';
            } else {
                $this->session->set_flashdata('message', 'User banned successfully!');
                echo 'failure';
            }
        }
    }

    /**
     * @auther Yogesh Pardeshi
     * @param user_id to be banned
     * @param admin_id who bans 
     * @param comment reason for banning
     * Note: Keep banned by as it is so it will store who unbanned the user
     */
    public function un_ban_user() {
        $user_to_banned = $this->security->xss_clean($this->input->post('user_id'));

        if (empty($this->session->admin_id) || empty($user_to_banned)) {
            echo 'invalid access';
            return;
        } else {
            $update_fields = array('banned_by' => $this->session->admin_id,
                'status' => 1,
                'ban_comment' => "");

            $this->db->where('id', $user_to_banned);
            $this->db->update($this->defaultTable, $update_fields);

            if ($this->db->affected_rows()) {
                $this->session->set_flashdata('message', 'User ban removed successfully!');
                echo 'success';
            } else {
                $this->session->set_flashdata('message', 'User ban removed successfully!');
                echo 'failure';
            }
        }
    }

    public function view_history() {
        $user_role = $this->uri->segment(4, 0);
        $user_id = $this->uri->segment(5, 0);
        if ($user_role == 'buyer') {
            $this->load->model('wallet_model');
            $data['history'] = $this->wallet_model->get_wallet_history($user_id);
            $data['balance'] = $this->wallet_model->getWalletBalance($user_id);
            $data['title'] = $user_role;
        } else {
            $this->load->model('vendorwallethistory_model');
            $data['history'] = $this->vendorwallethistory_model->get_vendor_history($user_id);
            $data['title'] = $user_role;
        }
        $this->load->view('admin/users/users_wallet_history', $data);
    }

    /*
     * @Ishwar
      This function is used to update status for document verification purpose.
     */

    public function updateStatus() {
        $verify_id = $this->input->post('verify_id');
        $data = array();
        $user_id = $this->input->post('user_id');
        $req_name = $this->input->post('req_name');
        $file_id = $this->input->post('file_id');

        $retdata = array();
        $result = 0;
        if ($verify_id !== '') {
            $this->Common_model->get_document_history($verify_id);

            if ($req_name == 'verify') {

                $data['document_verify_status'] = 'verified';
                $result = $this->Common_model->update('document_verify_tbl', $data, array('user_id' => $user_id));

                $data1['file_status'] = 'verified';
                $result1 = $this->Common_model->update('company_documents', $data1, array('user_id' => $user_id));
            } else if ($req_name == 'reject') {

                $data['document_verify_status'] = 'rejected';
                $result = $this->Common_model->update('document_verify_tbl', $data, array('user_id' => $user_id));

                $data2['file_status'] = 'rejected';
                $result1 = $this->Common_model->update('company_documents', $data2, array('user_id' => $user_id));

                if ($result > 0 && $result1 > 0) {
                    //send Email
                    $this->send_email_by_docs_reject($user_id);
                    
                }
            }
            $retdata["message"] = "success";
            $retdata["status"] = $result;
            echo json_encode($retdata);
        }
    }

     /*
     * @Ishwar
      This function is used to send email for document rejected .
     */
    function send_email_by_docs_reject($user_id) {
        
        $data['user'] = $this->Common_model->getAll('users', array('id' => $user_id))->row_array();

        $data1['user_docs_detail'] = $this->Common_model->getAll('document_verify_tbl', array('user_id' => $user_id))->row_array();

        $from = $this->config->item("default_email_from");

        $to = trim($data1['user'][0]['email']);
        $mesg = 'Dear ' . $data['user'][0]['email'] . ' Your Submitted Document.' . $data1['user_docs_detail'][0]['pan_img'] . 'And' . $data1['user_docs_detail'][0]['gst_img'] . ' is rejected during audit process. Requesting you to login and upload appropriate document. You can write us on "helpdesk@atzcart.com" or call on 1800-212-2036 for any query';

       $this->load->library('email');
        $config = array(
            'charset' => 'utf-8',
            'wordwrap' => TRUE,
            'mailtype' => 'html'
        );
        $config['protocol'] = 'smtp';
        $config['smtp_host'] = 'smtp-relay.gmail.com';
        $config['smtp_user'] = 'support@atzcart.com';
        $config['smtp_pass'] = 'asdfghjklQWE123@';
        $config['smtp_port'] = 587;
        $config['smtp_crypto'] = 'tls';
        $this->email->initialize($config);
        $this->email->set_newline("\r\n");
        $this->email->from($from, 'Atzcart');
        $this->email->to($to);
        $this->email->bcc($emailString);
        $this->email->subject('Document Rejected');
        $this->email->message($mesg);
        $this->email->send();
        
    }
    
    function exportAllUsers()
    {
        $active_status = $this->input->post('status');
        $from = $this->input->post("dateFrom");
        $to = $this->input->post("dateTo");
        
         $page = $this->input->post('page');
         $fileName = 'product_details' . time() . '.xlsx';
         $users = $this->Users_model->get_datatablesUsers($active_status,$from,$to);
      
        if ($users) {
            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();
            $sheet->setTitle('Users Details');
            $sheet->setCellValue('A2', 'Users Details');
            $sheet->mergeCells('A2:AA2');
            $sheet->getStyle("A2")->getFont()->setSize(16);

            $sheet->getStyle("A3:AA3")->getFont()->setSize(12);
            $sheet->getStyle("A3:AA3")->getFont()->setBold(true);
            $sheet->getStyle("A3:AA3")->getFont()->setName('Calibri');
            $sheet->getStyle("A3:AA3")->getFont()->getColor()->setRGB('3F7FFF');


            $sheet->setCellValue('A3', 'Sr.No');
            $sheet->setCellValue('B3', 'User ID');
            $sheet->setCellValue('C3', 'User Name');
            $sheet->setCellValue('D3', 'User Email');
            $sheet->setCellValue('E3', 'Wallet Balance');
            $sheet->setCellValue('F3', 'Phone');
            $sheet->setCellValue('G3', 'Total Order');
            $sheet->setCellValue('H3', 'Registered');

            $rows = 4;
            $sl = 0;
            foreach ($users as $val) {
                $sl++;
                $sheet->setCellValue('A' . $rows, $sl);
                $sheet->setCellValue('B' . $rows, $val->id);
                $sheet->setCellValue('C' . $rows, $val->first_name.''.$val->last_name);
                $sheet->setCellValue('D' . $rows, $val->email);
                $sheet->setCellValue('E' . $rows, $val->balance);
                $sheet->setCellValue('F' . $rows, $val->phone);

                $sheet->setCellValue('G' . $rows, $val->total_orders);

                $sheet->setCellValue('H' . $rows, date("d M Y", strtotime($val->created_on)));
                $products_names = '';

                $rows++;
            }

            $sheet->getStyle('A2:AA' . $rows)->getAlignment()->setHorizontal('center');
            $sheet->getStyle('A2:AA' . $rows)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
            foreach (range('A','Z') as $col) {
                $sheet->getColumnDimension($col)->setAutoSize(true);
            }
            $sheet->getColumnDimension("AA")->setAutoSize(true);


            $writer = new Xlsx($spreadsheet);
            //$writer->save("./uploads/order_excel/" . $fileName);
            header("Content-Type: application/vnd.ms-excel");
            header('Content-Disposition: attachment;filename="'. $fileName .'.xlsx"'); 
            header('Cache-Control: max-age=0');
            $writer->save('php://output'); // download file 
        } else {
            $error = "<div class='alert alert-danger alert-dismissible'>
                        <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                        <strong>Error!</strong> No Records Found.
                      </div>";
            $this->session->set_flashdata('message', $error);
            redirect("admin/products/" . $page, "refresh");
        }
    }
    
    public function show() {
       
        $from = $this->input->post('dateFrom');
        $to = $this->input->post('dateTo');
      
        $data['page'] = "show";
      
        $users = $this->Users_model->get_datatablesUsers($active_status,$from,$to);
        //$data['total_orders'] = $this->Order_model->get_allOrders();

         $no = $this->input->post('start');
      
         if($users)
         {
             foreach ($users as $user) {
                 
             if ($user->status == 1) {
                    $status = '<a href="javascript:void(0);" style="color:green;font-weight:bold;"  data-toggle="modal" data-target="#active_inactive_modal" data-user_id="' . $user->id . '" data-status="' . $user->status . '">Active</a>';
                } else {
                    $status = '<a href="javascript:void(0);" style="color:red;font-weight:bold;"  data-toggle="modal" data-target="#active_inactive_modal" data-user_id="' . $user->id . '" data-status="' . $user->status . '">Inactitve</a>';
                }

            $no++;
            $details = array();
            $details[] = $user->id;
            $details[] = $user->first_name . ' ' . $user->last_name;
            $details[] = $user->email;
            $details[] = '<a  class="badge badge-success" href="' . base_url('admin/users/view_history') . '/' . $user->role . '/' . $user->id . '" >' . $user->balance . ' </a>';
            $details[] = $user->phone;
            if ($user->total_orders) {
                $details[] = "<a href='".site_url()."admin/users/user_order/".$user->id."' class='btn btn-info'>".$user->total_orders."</a>";
            } else {
                $details[] = "0";
            }

            if (trim($user->status) == 0) {
                //show remove / unban user modal data
                $ban_page_text = "<div class='form-group'>Username : " .
                        $user->first_name . ' ' . $user->last_name . '</div>';
                $ban_page_text .= "<div class='form-group'><label for='comment'><b>Banning Reason : </b></label> " .
                        $user->ban_comment . "
                                <input type='hidden' id='ban_id' value='" . $user->id . "'></div>";
                $ban_details = '<a data-toggle="modal" data-id="' . $ban_page_text . '" data-target="#unBanModal" class="dropdown-item open-unban-events" ><i class="fa fa-ban"></i>Ban User</a>';
            } else {
                //show ban user modal data
                $ban_page_text = "<div class='form-group'>Username : " .
                        $user->first_name . ' ' . $user->last_name . '</div>';
                $ban_page_text .= "<div class='form-group'><label for='comment'><b>Banning Reason</b></label>" .
                        "<textarea required class='form-control' name='ban_comment' id='ban_comment'></textarea>
                                <input type='hidden' id='ban_id' value='" . $user->id . "'>
                                </div>";
                $ban_details = '<a data-toggle="modal" data-id="' . $ban_page_text . '" data-target="#banModal" class="dropdown-item open-ban-events" ><i class="fa fa-ban"></i>Ban User</a>';
            }

                $details[] = date("d-m-Y h:i:s", strtotime($user->created_on));
                $details[] = '<button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-cog" aria-hidden="true"></i></button>
                            <div class="dropdown-menu dropdown-menu-right b-none contact-menu" style="width:55px;">
                                    <a class="dropdown-item" href="' . site_url() . 'admin/users/user_view/' . $user->id . '"><i class="fa fa-eye"></i>view Profile</a>
                    <a class="dropdown-item" href="' . site_url() . 'admin/users/user_order/' . $user->id . '"><i class="fa fa-edit"></i>Orders</a>
                    ' . $ban_details . '</div>';

                $data[] = $details;
            }
        }
        else
        {
            $error = "<div class='alert alert-danger alert-dismissible'>
                        <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                        <strong>Error!</strong> No Records Found.!.
                      </div>";
                $this->session->set_flashdata("message", $error);
                redirect("admin/users", "refresh");
        }
     
         $this->load->view("admin/users/list", $data);
         
    }
    
}
