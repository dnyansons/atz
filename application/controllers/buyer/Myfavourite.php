<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Myfavourite extends CI_Controller {

    public function __construct() {
        parent::__construct();
        if (!$this->session->userdata("user_logged_in")) {
            $error = "<div id='login-error' class='form-error notice notice-error'><span class='icon-notice icon-error'></span><span><strong>Error!</strong> Session timeout, relogin!. </span></div>";
            $this->session->set_flashdata("message", $error);
            redirect("login", "refresh");
        }
        $this->load->model('Myfavourite_model');
        $this->load->model('Common_model');
        $this->load->model('Product_model');
        $this->load->library("get_header_data");
        $this->load->library("awsupload");
    }

    public function index() {

        //$data["pageTitle"] = "My Favourite";
        //$this->load->view("user/myfavourite/list", $data);
        $user_id = $this->session->userdata("user_id");
        //$data = $this->get_header_data->get_categories();
        $data1 = $this->Myfavourite_model->getUsersFavouritesProducts($user_id);
        $products = json_decode($data1['products']);
        $suppliers = json_decode($data1['suppliers']);
        $data["products"] = $this->Product_model->getProductListByIds($products);
        //$this->load->view("front/product/favourite_view", $data);
        echo "<pre>";
        print_r($data);
        //print_r($products);
    }

    public function ajax_product_list() {
        $user_id = $this->session->userdata("user_id");

        $columns = array(
            0 => 'products_id',
            1 => 'products_image',
            2 => 'products_name',
        );

        $limit = $this->input->post('length');
        $start = $this->input->post('start');
        $order = $columns[$this->input->post('order')[1]['column']];
        $dir = $this->input->post('order')[1]['dir'];

        $totalData = $this->Myfavourite_model->allproduct_count($user_id);


        $totalFiltered = $totalData;

        if (empty($this->input->post('search')['value'])) {
            $alorder = $this->Myfavourite_model->allproducts($user_id, $limit, $start, $order, $dir);
        } else {
            $search = $this->input->post('search')['value'];

            $alorder = $this->Myfavourite_model->product_search($user_id, $limit, $start, $search, $order, $dir);
            //echo $this->db->last_query();

            $totalFiltered = $this->Myfavourite_model->product_search_count($user_id, $search);
        }

        $data = array();
        if (!empty($alorder)) {
            foreach ($alorder as $br) {
                $nestedData['products_id'] = '<input class="chval" name="sons" value="' . $br->products_id . '" type="checkbox" />';
                $nestedData['products_image'] = '<img src="' .$br->products_image . '" style="width:50px;">';
                $nestedData['products_name'] = '<b>' . $br->products_name . '</b> ( ' . $br->products_alias . ' )<br>' . $br->products_currency . ' ' . $br->products_price . ' / ' . $br->units_name . '<br>Min Order : ' . $br->min_order_quantity;
                $nestedData['action'] = '<a type="button" href="' . base_url() . 'user/myfavourite/send_enquiry/' . $br->products_id . '" class="btn btn-warning btn-sm">Contact&nbsp;Seller</a>';

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

    function ajax_seller_list() {
        $user_id = $this->session->userdata("user_id");

        $columns = array(
            0 => 'id',
            1 => 'first_name',
            2 => 'email',
            3 => 'company_name',
        );

        $limit = $this->input->post('length');
        $start = $this->input->post('start');
        $order = $columns[$this->input->post('order')[1]['column']];
        $dir = $this->input->post('order')[1]['dir'];

        $totalData = $this->Myfavourite_model->allseller_count($user_id);


        $totalFiltered = $totalData;

        if (empty($this->input->post('search')['value'])) {
            $alorder = $this->Myfavourite_model->allseller($user_id, $limit, $start, $order, $dir);
        } else {
            $search = $this->input->post('search')['value'];

            $alorder = $this->Myfavourite_model->seller_search($user_id, $limit, $start, $search, $order, $dir);
            //echo $this->db->last_query();

            $totalFiltered = $this->Myfavourite_model->seller_search_count($user_id, $search);
        }

        $data = array();
        if (!empty($alorder)) {
            foreach ($alorder as $se) {
                $nestedData['id'] = '<input class="chval" name="supplier_remove" value="' . $se->user_id . '" type="checkbox" />';
                $nestedData['first_name'] = '<b>' . $se->first_name . ' ' . $se->last_name;
                $nestedData['email'] = $se->email;
                $nestedData['company_name'] = $se->company_name;
                $nestedData['action'] = '<a type="button" href="' . base_url() . 'user/myfavourite/send_seller_enquiry/' . $se->user_id . '" class="btn btn-warning btn-sm">Contact&nbsp;Seller</a>';

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

    function send_enquiry($pro_id = 0) {
        $data['pro_det'] = $this->Myfavourite_model->product_det($pro_id);
        $data['user_id'] = $this->session->userdata("user_id");


        if ($_SERVER['REQUEST_METHOD'] == "POST") {

            ///////////////////////////
            $user_id = $this->session->userdata("user_id");

            //Upload Attachment
            if ($_FILES['userFiles']['name'][0] != '') {

                $filesCount = count($_FILES['userFiles']['name']);

                for ($i = 0; $i < $filesCount; $i++) {
                    $_FILES['userFiles']['name'][$i];
                    $_FILES['userFile']['name'] = $_FILES['userFiles']['name'][$i];
                    $_FILES['userFile']['type'] = $_FILES['userFiles']['type'][$i];
                    $_FILES['userFile']['tmp_name'] = $_FILES['userFiles']['tmp_name'][$i];
                    $_FILES['userFile']['error'] = $_FILES['userFiles']['error'][$i];
                    $_FILES['userFile']['size'] = $_FILES['userFiles']['size'][$i];
                    $config['upload_path'] = './uploads/enquiry/';
                    $config['allowed_types'] = 'gif|jpg|png|jpeg|bmp';
                    //$config['max_size'] = 9999999999999999999;
                    $new_name = base_url() . 'uploads/enquiry/enquiry_' . $user_id . '_user_' . $_FILES['userFile']['name'];
                    $config['file_name'] = $new_name;
                    $this->load->library('upload', $config);
                    $this->upload->initialize($config);
                    if (!$this->upload->do_upload('userFile')) {
                        echo json_encode(array('msg' => $this->upload->display_errors()));
                    } else {
                        $fileData = $this->upload->data();

                        $uploadData[] = $new_name;
                        //resize image
                        $source_path = './uploads/enquiry/' . $fileData['file_name'];
                        $target_path = './uploads/enquiry/thumbs/';
                        $config_resize = array(
                            'image_library' => 'gd2',
                            'source_image' => $source_path,
                            'new_image' => $target_path,
                            'maintain_ratio' => TRUE,
                            'create_thumb' => TRUE,
                            'width' => 325,
                            'height' => 250
                        );
                        $this->load->library('image_lib');
                        $this->image_lib->initialize($config_resize);
                        $this->image_lib->resize();
                    }
                }

                $enquiry_data['attachments_by_buyer'] = json_encode($uploadData, true);
            } else {
                $enquiry_data['attachments_by_buyer'] = '';
            }
            $enquiry_data['by_user'] = $this->session->userdata("user_id");
            $enquiry_data['for_product'] = $this->input->post('for_product');
            $enquiry_data['unit'] = $this->input->post('unit');
            $enquiry_data['comment'] = $this->input->post('comment');
            $enquiry_data['quantity'] = $this->input->post('quantity');
            $enquiry_data['created_on'] = date('Y-m-d H:i:s');




            $result = $this->Common_model->insert("inquiries", $enquiry_data);
            if ($result) {
                $msg = 'Equiry Sent Successfully';
            } else {
                $msg = 'Somthing Wrong !';
            }

            $this->session->set_flashdata('message', $msg);
            redirect('buyer/myfavourite');

            ///////////////////////////
        } else {
            $this->load->view("user/myfavourite/send_enquiry", $data);
        }
    }

    function send_seller_enquiry($seller_id = 0) {

        $data['seller_det'] = $this->Myfavourite_model->supplier_det($seller_id);

        $data['unit_dat'] = $this->Common_model->getAll("units")->result_array();
        $data['user_id'] = $this->session->userdata("user_id");


        if ($_SERVER['REQUEST_METHOD'] == "POST") {

            ///////////////////////////
            $user_id = $this->session->userdata("user_id");

            $enquiry_data['by_user'] = $this->session->userdata("user_id");
            $enquiry_data['for_supplier'] = $this->input->post('for_supplier');
            $enquiry_data['unit'] = $this->input->post('unit');
            $enquiry_data['comment'] = $this->input->post('comment');
            $enquiry_data['quantity'] = $this->input->post('quantity');
            $enquiry_data['created_on'] = date('Y-m-d H:i:s');




            $result = $this->Common_model->insert("inquiries", $enquiry_data);
            if ($result) {
                $msg = 'Equiry Sent Successfully';
            } else {
                $msg = 'Somthing Wrong !';
            }

            $this->session->set_flashdata('message', $msg);
            redirect('buyer/myfavourite');

            ///////////////////////////
        } else {
            $this->load->view("user/myfavourite/send_seller_enquiry", $data);
        }
    }

    function remove_favourite() {

        $user_id = $this->session->userdata("user_id");
        $ids = $this->input->post("check_pro");
        $dat = $this->Common_model->getAll('buyer_favourites', array('user_id' => $user_id))->row_array();
        $existing_products = json_decode($dat['products']);
        foreach ($ids as $id) {
            if (($key = array_search($id, $existing_products)) !== false) {
                unset($existing_products[$key]);
            }
        }
        $updateData = [
            "products" => json_encode(array_values($existing_products))
        ];
        $this->Myfavourite_model->updateFavourite($dat['id'], $updateData);
        if (count($ids) > 0) {
            echo $msg = 'Favourite Product Delete Successfully !';
        } else {
            echo $msg = 'No Product to Delete !';
        }
    }

    function favourite_seller_remove() {
        $user_id = $this->session->userdata("user_id");
        $ids = $this->input->post("check_pro");
        $dat = $this->Common_model->getAll('buyer_favourites', array('user_id' => $user_id))->row_array();
        $existing_products = json_decode($dat['suppliers']);
        foreach ($ids as $id) {
            if (($key = array_search($id, $existing_products)) !== false) {
                unset($existing_products[$key]);
            }
        }
        $updateData = [
            "suppliers" => json_encode(array_values($existing_products))
        ];
        $this->Myfavourite_model->updateFavourite($dat['id'], $updateData);
        if (count($ids) > 0) {
            echo $msg = 'Favourite Supplier Delete Successfully !';
        } else {
            echo $msg = 'No Supplier to Delete !';
        }
    }

}
