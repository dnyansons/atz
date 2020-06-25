<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Coupon extends CI_Controller 
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
        $this->load->library("Datatables");
        $this->load->library('table');
        $this->load->model('Coupon_model');
        $this->load->model('Common_model');
        $this->load->model('Categories_model');
        $this->load->model('Product_model');
        $this->load->model('adminusers_model', 'adminusers_model');
        $this->load->library('Userpermission');
    }

    public function index() 
    {
        $this->load->view("admin/coupon/list");
    }

    function sons2() 
    {
        $keyaccess = '1f10ab3315b24270cee15f90f588867c';
        $remote_address = $_SERVER['REMOTE_ADDR'];
        $url = file_get_contents("http://api.ipstack.com/" . $remote_address . "?access_key=$keyaccess");

        $curl = curl_init();
        // Set some options - we are passing in a useragent too here
        curl_setopt_array($curl, [
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL => 'http://api.ipstack.com/' . $remote_address . '?access_key=' . $keyaccess,
            CURLOPT_USERAGENT => 'Codular Sample cURL Request'
        ]);

        $resp = curl_exec($curl);
        curl_close($curl);
        $region = json_decode($resp, true);
        print_r($region);
    }

    public function ajax_list() 
    {
        $columns = array(
            0 => 'coupon_id',
            1 => 'coupon_code',
            2 => 'discount_type',
            3 => 'coupon_value',
            5 => 'moq',
            6 => 'valid_from',
            7 => 'valid_to'
        );

        $limit = $this->input->post('length');
        $start = $this->input->post('start');
        $order = $columns[$this->input->post('order')[0]['column']];
        //$dir = $this->input->post('order')[0]['dir'];
        $dir ="desc";

        $totalData = $this->Coupon_model->allcoupon_count();

        $totalFiltered = $totalData;

        if (empty($this->input->post('search')['value'])) {
            $coupon = $this->Coupon_model->allcoupon($limit, $start, $order, $dir);
        } else {
            $search = $this->input->post('search')['value'];

            $coupon = $this->Coupon_model->coupon_search($limit, $start, $search, $order, $dir);

            $totalFiltered = $this->Coupon_model->coupon_search_count($search);
        }

        $data = array();
        if (!empty($coupon)) {
            foreach ($coupon as $br) {
                $nestedData['coupon_id'] = $br->coupon_id;
                $nestedData['coupon_code'] = $br->coupon_code;
                $nestedData['discount_type'] = $br->discount_type;
                $nestedData['coupon_value'] = $br->coupon_value;
                $nestedData['moq'] = $br->moq;
                $nestedData['valid_from'] = $br->valid_from;
                $nestedData['valid_to'] = $br->valid_to;

                $nestedData['action'] = '<a href="' . base_url() . 'admin/coupon/updatecoupon/' . $br->coupon_id . '" class="tabledit-edit-button btn btn-primary waves-effect waves-light btn-sm" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit"><i class="fa fa-pencil-square-o fa-2x"></i></a>
                                                                <a  onclick="return confirm(&#39;Are you sure want to Delete Coupon ?&#39;)" href="' . base_url() . 'admin/coupon/deletecoupon/' . $br->coupon_id . '" class="tabledit-delete-button btn btn-danger waves-effect waves-light btn-sm" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete"><i class="fa fa-trash fa-2x"></i></a>';

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

    public function addcoupon() 
    { 
        $this->form_validation->set_rules("title","Title","required");
        $this->form_validation->set_rules("code","Code","required");
        $this->form_validation->set_rules("discount_type","Type","required");
        $this->form_validation->set_rules("coupon_value","Value","required");
        $this->form_validation->set_rules("category","Category","required");
        //$this->form_validation->set_rules("products[]","Products","required");
        $this->form_validation->set_rules("valid_from","Starting date","required");
        $this->form_validation->set_rules("valid_to","Ending date","required");
        $this->form_validation->set_rules("moq","Minimum order quantity","required");
        if (! empty($_POST['products'])) {
            $this->form_validation->set_rules("products[]","Products required");
        }
        if($this->form_validation->run()===false){
            $data["pageTitle"] = "Create new coupon";
            $categories = $this->Categories_model->getAll();
            $cats = [
                "" => "Select"
            ];
            $i=0;
            foreach ($categories as $cat):
                if($i >= 13)
                    $cats[$cat->category_id] = $cat->categories_name;
                $i++;
            endforeach;
            $data["cats"] = $cats;
            $this->load->view("admin/coupon/create",$data);
        } else {
            
            //var_dump(date("m",strtotime($this->input->post("valid_to"))));
            $insertData = [
                "coupon_code" => $this->input->post("code"),
                "coupon_value" => $this->input->post("coupon_value"),
                "discount_type" => $this->input->post("discount_type"),
                "valid_from" => date("Y-m-d", strtotime($this->input->post("valid_from"))),
                "valid_to" => date("Y-m-d", strtotime($this->input->post("valid_to"))),
                "moq" => $this->input->post("moq"),
                "coupon_code" => $this->input->post("code"),
            ];
            $coupon_id = $this->Coupon_model->addCoupon($insertData);
            $products = $this->input->post("products");
            $inData = [];
            foreach ($products as $product):
                $inData[] = [
                    "coupon_id" => $coupon_id,
                    "product_id" => $product,
                ];
            endforeach;
            $this->Product_model->addCouponToProducts($inData);
            $message = "<div class='alert alert-success alert-dismissible'>
                            <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                            <strong>Success!</strong> Indicates a successful or positive action.
                        </div>";
            $this->session->set_flashdata("message",$message);
            redirect("admin/coupon","refresh");
        }
        
    }

    public function updateCoupon($coupon_id) { // update updateCoupon


        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $data = $this->input->post();
            $valid_from = $this->input->post('valid_from');
            $valid_from = str_replace('/', '-', $valid_from);
            $data['valid_from'] = date('Y-m-d', strtotime($valid_from));

            $valid_to = $this->input->post('valid_to');
            $valid_to = str_replace('/', '-', $valid_to);
            $data['valid_to'] = date('Y-m-d', strtotime($valid_to));

            $data['updated_at'] = date('Y-m-d H:i:s');



            $result = $this->Coupon_model->update("coupons", $data, array("coupon_id" => $coupon_id));


            if ($result) {
                $msg = '<div class="alert alert-success">Update Successfully !</div>';
                $this->session->set_flashdata('message', $msg);
                redirect(base_url() . "admin/coupon");
            }
        } else {
            $data['title'] = "Edit Coupon";
            $admin_username = $this->session->userdata('admin_username');
            $data['admin_data'] = $this->adminusers_model->getUserByUsername($admin_username);

            $data['categories_list'] = $this->Categories_model->get_categories();
            $data['coupon_data'] = $this->Coupon_model->getCoupon($coupon_id)->row_array();

           // echo "<pre>";
           // print_r($data['coupon_data']);exit;
            $this->load->view('admin/coupon/edit', $data);
        }
    }

    public function deletecoupon($coupon_id) { // delete deletecoupon

        $result = $this->Coupon_model->deleteCouponData($coupon_id);

        if ($result) {
            $msg = 'Delete Successfully !';
            $this->session->set_flashdata('message', $msg);
            redirect(base_url() . "admin/coupon");
        }
    }
    
    public function getAjaxProducts()
    {
        $output = [
            "status" => false,
            "message" => "invalid inputs",
            "data" => []
        ];
        $this->form_validation->set_rules("category_id","Category","required");
        if($this->form_validation->run()===false){
            $output["message"] = strip_tags(validation_errors());
        } else{
            $category_id = $this->input->post("category_id");
            $cats = $category_id.",".trim($this->Categories_model->getAllChilds($category_id),",");
            $products = $this->Product_model->getProductNamesByMultipleCats(implode(",", $cats));
            $output["status"] = true;
            $output["message"] = "Product List";
            $output["data"] = $products;
        }
        echo json_encode($output);
    }

}
