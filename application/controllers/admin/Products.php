<?php

defined('BASEPATH') OR exit('No direct script access allowed');

//ini_set("memory_limit", "256M");
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;

class Products extends CI_Controller {

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
        //$this->load->model('Suppliers_model', 'Suppliers_model');
        $this->load->model('Products_model', 'Products_model');
        $this->load->model('Product_model', 'Product_model');
        $this->load->model('Categories_model');
        $this->load->model('Common_model');
        $this->load->model('Brand_model');
        $this->load->model('Units_model');
        $this->load->model('Collections_model');
        $this->load->library('Userpermission');
        $this->load->library('awsupload');
    }

    public function index() {
        $data['pageTitle'] = "Approved Products";
        $data['page'] = "Approved";
        $data["status"] = "approved";
        $data["get_url"] = "admin/products/ajax_list";
        $data['categories'] = $this->Categories_model->getAll();
        $this->load->view("admin/products/list_new", $data);
    }

    public function rejectedProducts() {
        $data['pageTitle'] = "Rejected Products";
        $data['page'] = "Rejected";
        $data["status"] = "rejected";
        $data["get_url"] = "admin/products/ajaxRejected_list";
        $data['categories'] = $this->Categories_model->getAll();
        $this->load->view("admin/products/list_new", $data);
    }

    /**
     * @auther Yogesh Pardeshi
     * shows views for single product for admin
     * @param product_if input of product number pk
     */
    public function viewSingleProduct($productId) {
        $productId = $this->security->xss_clean($productId);
        $data['productData'] = $this->Product_model->readSingleProduct($productId);
        $this->load->view("admin/products/single_product_view", $data);
    }

//    public function ajax_list() 
//    {
//
//        $columns = array(
//            0 => 'id',
//            1 => 'media_url',
//            2 => 'name',
//            3 => 'categories_name'
//        );
//
//        $limit = $this->input->post('length');
//        $start = $this->input->post('start');
//        $order = $columns[$this->input->post('order')[0]['column']];
//        //$dir = $this->input->post('order')[0]['dir'];
//        $dir = "desc";
//
//        $totalData = $this->Product_model->allproducts_count_admin();
//
//        $totalFiltered = $totalData;
//
//        if (empty($this->input->post('search')['value'])) {
//            $product = $this->Product_model->allproducts_admin($limit, $start, $order, $dir);
//        } else {
//            $search = $this->input->post('search')['value'];
//
//            $product = $this->Product_model->product_search_admin($limit, $start, $search, $order, $dir);
//
//            $totalFiltered = $this->Product_model->product_search_count_admin($search);
//        }
//
//
//        //echo "<pre>";
//        //print_r($product);exit;
//
//        $data = array();
//        if (!empty($product)) {
//            foreach ($product as $prod) {
//                //echo "<pre>";
//                //print_r($prod);
//                $img_array = explode('.', $prod->media_url);
//                $thumbnail = $img_array[0] . '_thumb.' . $img_array[1];
//
//                $nestedData['product_id'] = $prod->product_id;
//                $nestedData['media_url'] = '<img src="' . $prod->media_url . '" class="img-fluid" width="64" height="64" alt="img">';
//                $nestedData['name'] = $prod->name;
//                $nestedData['moq'] = $prod->quantity_from;
//                $nestedData['price'] = $prod->price1."-".$prod->price2;
//                $nestedData["seller"] = "Name : ".$prod->first_name." ".$prod->last_name."<br />Company : ".$prod->company_name.""
//                        . "<br /> Email : ".$prod->email.""
//                        . "<br /> Phone : ".$prod->phone;
//                $nestedData['categories_name'] = $prod->categories_name;
//                //$nestedData['products_status'] = $prod->products_status=="1" ? 'Enable' : 'Disable';
//                $nestedData['action'] = '<a href="' . base_url() . 'admin/products/update/' . $prod->product_id . '" class="tabledit-edit-button btn btn-primary waves-effect waves-light btn-sm" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit"><i class="fa fa-pencil-square-o"></i></a>
//                                                                <a href="' . base_url() . 'admin/products/delete/' . $prod->product_id . '" class="tabledit-delete-button btn btn-danger waves-effect waves-light btn-sm" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete"><i class="fa fa-trash"></i></a>';
//
//                $data[] = $nestedData;
//            }
//        }
//
//        $json_data = array(
//            "draw" => intval($this->input->post('draw')),
//            "recordsTotal" => intval($totalData),
//            "recordsFiltered" => intval($totalFiltered),
//            "data" => $data
//        );
//
//        echo json_encode($json_data);
//    }

    public function ajax_list() {
        $from = $this->input->post("published_from");
        $to = $this->input->post("published_to");
        $category = $this->input->post("category");
        $name = $this->input->post("pname");
        $seller2 = $this->input->post("seller") ?? 0;
        $bulk = $this->input->post("bulk");
        $status = $this->input->post("status");

        $products = $this->Product_model->get_datatables($from, $to, $seller2, $category, $name, $status, $bulk);
        $data = array();
        $no = $this->input->post('start');

        foreach ($products as $product) {
            $thumb = $product->media_url;
            if ($product->price1 == $product->price2) {
                $price = $product->price1;
            } else {
                $price = $product->price2 . " - " . $product->price1;
            }
            if (strlen($product->name) > 15) {
                $len = "...";
            } else {
                $len = '';
            }
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = "<a target='_blank' href='" . site_url('admin/products/viewSingleProduct/') . $product->product_id . "' class='label label-info'>PRD" . $product->product_id . "</a>";
            $row[] = "<img class='img img-thumbnail' src='" . $thumb . "' width='60' height='60'>";
            //if status is approved then show out of stock products
            if (strtolower($product->publish_status) == 'approved') {
                if ($product->available_quantity == 0) {
                    $outOfStock = '<br><small class="text-danger ml-4 blinking">Out Of Stock</small>';
                } else {
                    $outOfStock = "";
                }
            }
            $row[] = "<span title = '" . $product->name . "'>" . substr($product->name, 0, 15) . $len . "</span>" . $outOfStock;
            $row[] = $product->categories_name;
            $row[] = $price;
            $row[] = $product->hike;
            $row[] = $product->atzprice2 . '-' . $product->atzprice1;
            $row[] = $product->discount;
            $row[] = $product->final_price2 . '-' . $product->final_price2;
            $seller = "ATZ" . $product->seller;
            $row[] = "<a href='javascript:void(0);' class='label label-info btnViewSeller' data-sid='" . $product->seller . "' >" . $seller . "</a>";
            $row[] = $product->available_quantity;
            $row[] = "<a href='javascript:void(0);' class='label label-primary btnViewSpecs' data-pid='" . $product->product_id . "' >View</a>";
            if ($product->requested_on != "") {
                $row[] = date("d M Y", strtotime($product->requested_on));
            } else {
                $row[] = "-";
            }
            if ($product->approved_on != "") {
                $adate = date("d M Y", strtotime($product->approved_on));
                $row[] = "<a href='javascript:void(0);' class='label label-primary btnViewApprover' data-pid='" . $product->product_id . "' >" . $adate . "</a>";
            } else {
                $row[] = "-";
            }


            $row[] = '<a href="' . base_url() . 'user/products/updatepostNew/' . $product->product_id . '" class="tabledit-edit-button btn btn-primary waves-effect waves-light btn-sm" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit"><i class="fa fa-pencil-square-o"></i></a>
                    <button type="button" class="tabledit-delete-button btn btn-danger waves-effect waves-light btn-sm btn_publish" data-toggle="tooltip"  data-products_id="' . $product->product_id . '" data-original-title="Publish"><i class="fa fa-snowflake-o "></i></button>';

            $data[] = $row;
        }

        $output = array(
            "draw" => $this->input->post('draw'),
            "recordsTotal" => $this->Product_model->count_all(),
            "recordsFiltered" => $this->Product_model->count_filtered($from, $to, $seller2, $category, $name, $status, $bulk),
            "data" => $data,
            "posts" => $this->input->post()
        );
        //output to json format
        echo json_encode($output);
    }

    public function ajaxRejected_list() {
        $from = $this->input->post("published_from");
        $to = $this->input->post("published_to");
        $category = $this->input->post("category");
        $name = $this->input->post("pname");
        $seller2 = $this->input->post("seller") ?? 0;
        $bulk = $this->input->post("bulk");
        $status = $this->input->post("status");

        $products = $this->Product_model->get_datatables($from, $to, $seller2, $category, $name, $status, $bulk);

        $data = array();
        $no = $this->input->post('start');
        foreach ($products as $product) {
            $thumb = $product->media_url;
            if ($product->price1 == $product->price2) {
                $price = $product->price1;
            } else {
                $price = $product->price2 . " - " . $product->price1;
            }

            if (strlen($product->name) > 15) {
                $len = "...";
            } else {
                $len = '';
            }

            $no++;
            $row = array();
            $row[] = $no;
            $row[] = "<a href='" . site_url('admin/products/update/') . $product->product_id . "' class='label label-info'>PRD" . $product->product_id . "</a>";
            $row[] = "<img class='img img-thumbnail' src='" . $thumb . "' width='60' height='60'>";
            $row[] = "<span title = '" . $product->name . "'>" . substr($product->name, 0, 15) . $len . "</span>";
            $row[] = $product->categories_name;
            $row[] = $price;
            $row[] = $product->hike;
            $row[] = $product->atzprice2 . '-' . $product->atzprice1;
            $row[] = $product->discount;
            $row[] = $product->final_price2 . '-' . $product->final_price2;
            $seller = "ATZ" . $product->seller;
            $row[] = "<a href='javascript:void(0);' class='label label-info btnViewSeller' data-sid='" . $product->seller . "' >" . $seller . "</a>";
            $row[] = $product->available_quantity;
            $row[] = "<a href='javascript:void(0);' class='label label-primary btnViewSpecs' data-pid='" . $product->product_id . "' >View</a>";
            if ($product->requested_on != "") {
                $row[] = date("d M Y", strtotime($product->requested_on));
            } else {
                $row[] = "-";
            }
            if ($product->approved_on != "") {
                $adate = date("d M Y", strtotime($product->approved_on));
                $row[] = "<a href='javascript:void(0);' class='label label-primary btnViewApprover' data-pid='" . $product->product_id . "' >" . $adate . "</a>";
            } else {
                $row[] = "-";
            }


            $row[] = '<a href="' . base_url() . 'user/products/updatepostNew/' . $product->product_id . '" class="tabledit-edit-button btn btn-primary waves-effect waves-light btn-sm" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit"><i class="fa fa-pencil-square-o"></i></a>
                    <button type="button" class="tabledit-delete-button btn btn-danger waves-effect waves-light btn-sm btn_publish" data-toggle="tooltip"  data-products_id="' . $product->product_id . '" data-original-title="Publish"><i class="fa fa-snowflake-o "></i></button>';

            $data[] = $row;
        }

        $output = array(
            "draw" => $this->input->post('draw'),
            "recordsTotal" => $this->Product_model->count_all(),
            "recordsFiltered" => $this->Product_model->count_filtered($from, $to, $seller2, $category, $name, $status, $bulk),
            "data" => $data,
            "posts" => $this->input->post()
        );
        //output to json format
        echo json_encode($output);
    }

    public function ajax_requests_list() {
        $from = $this->input->post("published_from");
        $to = $this->input->post("published_to");
        $category = $this->input->post("category");
        $name = $this->input->post("pname");
        $seller2 = $this->input->post("seller") ?? 0;
        $bulk = $this->input->post("bulk");
        $status = $this->input->post("status");


        $products = $this->Product_model->get_datatables($from, $to, $seller2, $category, $name, $status, $bulk);

        $data = array();
        $no = $this->input->post('start');
        foreach ($products as $product) {
            //print_r($product);
            $img = explode("/", $product->media_url);
            $cnt = count($img) - 1;
            //echo $img[$cnt];

            $img2 = explode('.', $img[$cnt]);
//            $thumb = base_url() . "uploads/images/products/" . $img2[0] . "_thumb." . $img2[1];
            $thumb = $product->media_url;
            if ($product->price1 == $product->price2) {
                $price = $product->price1;
            } else {
                $price = $product->price2 . " - " . $product->price1;
            }

            if (strlen($product->name) > 15) {
                $len = "...";
            } else {
                $len = '';
            }

            $no++;
            $row = array();
            $row[] = $no;
            $row[] = "<a href='" . site_url('admin/products/update/') . $product->product_id . "' class='label label-info'>PRD" . $product->product_id . "</a>";
            $row[] = "<img class='img img-thumbnail' src='" . $thumb . "' width='60' height='60'>";
            $row[] = "<span title = '" . $product->name . "'>" . substr($product->name, 0, 15) . $len . "</span>";
            $row[] = $product->categories_name;
            $row[] = $price;
            $row[] = $product->hike;
            $row[] = $product->atzprice2 . '-' . $product->atzprice1;
            $row[] = $product->discount;
            $row[] = $product->final_price2 . '-' . $product->final_price2;
            $seller = "ATZ" . $product->seller;
            $row[] = "<a href='javascript:void(0);' class='label label-info btnViewSeller' data-sid='" . $product->seller . "' >" . $seller . "</a>";
            $row[] = $product->available_quantity;
            $row[] = "<a href='javascript:void(0);' class='label label-primary btnViewSpecs' data-pid='" . $product->product_id . "' >View</a>";
            if ($product->requested_on != "") {
                $row[] = date("d M Y", strtotime($product->requested_on));
            } else {
                $row[] = "-";
            }
            $row[] = "<a href='#' class='label label-primary btnApprove' data-pid='" . $product->product_id . "' >Approve</a>&nbsp;<a href='#' class='label label-danger btnReject' data-pid='" . $product->product_id . "' >Reject</a>";
            //$row[] = "".$product->requested_on;

            $data[] = $row;
        }
        //echo "<pre>";
        //print_r($data);

        $output = array(
            "draw" => $this->input->post('draw'),
            "recordsTotal" => $this->Product_model->count_all(),
            "recordsFiltered" => $this->Product_model->count_filtered($from, $to, $seller2, $category, $name, $status, $bulk),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function update_category($product_id) {
        $this->form_validation->set_rules("category_id", "Category_id", "required");
        $this->form_validation->set_rules("hidden_update_product", "hidden_update_product", "required");

        if ($this->form_validation->run() === false) {
            $data["pageTitle"] = "Choose Category";
            $data['rootCats'] = $this->Categories_model->getBasicCategories();

            $data['ProductDetails_data'] = $this->Product_model->getProductDetails($product_id);

            $product_category_id = $data['ProductDetails_data']['category_id'];

            $data['Products_categories_data'] = $this->Categories_model->getAllParentCategoriesByChildCategory($product_category_id);

            $data['products_level2_cats'] = $this->Categories_model->getImidiateChildCategories($data['Products_categories_data']->level2parentid);

            $data['products_level3_cats'] = $this->Categories_model->getImidiateChildCategories($data['Products_categories_data']->level1parentid);

            $data['product_id'] = $product_id;

          $this->load->view("admin/products/choose_category_edit", $data);
        } else {

            //update product 
            $category_id = $this->security->xss_clean($this->input->post('category_id'));
            $product_id = $this->security->xss_clean($this->uri->segment(4, 0));

            if (!empty($category_id) && $product_id != 0) {
                $this->db->where('id', $product_id)
                        ->update('product_details', array('category' => $category_id));
                $flash_message = '<div class="alert alert-success alert-dismissible">
                                                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Success!</strong> Product category successfully updated !.
                                                  </div>';
                $this->session->set_flashdata('message', $flash_message);
            }

            redirect("admin/products/update/$product_id", "refresh");
        }
    }

    public function update($product_id) {
        $cat_id = $this->Product_model->getCategoryId($product_id); //read from db for old product
        $data['cat_id'] = $cat_id;
        //$this->session->userdata("selected_category");
        $this->form_validation->set_rules("product_name", "Name", "required");
        $this->form_validation->set_rules("product_keywords", "Keywords", "required");
        $this->form_validation->set_rules("track_inventory", "Track Inventory", "required");

        $track_inventory = $this->input->post('track_inventory'); // added for inventory management concept

        if ($this->form_validation->run() === false) {
            $data["pageTitle"] = "Post New Product";
            $data["attrs"] = $this->Categories_model->getCategoryAttributes($cat_id);
            $data["specs"] = $this->Categories_model->getCategorySpecifications($cat_id);

            //$produts_attrs = $this->Categories_model->getProductsCategoryAttributes($cat_id, $product_id);
            //$produts_specs = $this->Categories_model->getProductsCategorySpecifications($cat_id, $product_id);

            $data["units"] = $this->Units_model->getAll();
            $data['ProductDetails_data'] = $this->Product_model->getProductDetails($product_id);
            $data['ProductPolicies_data'] = $this->Product_model->getProductPolicies($product_id);

            for ($i = 0; $i < count($data["specs"]); $i++) {
                $produts_specs_val_array = $this->Categories_model->getProductsCategorySpecifications($data["specs"][$i]->id, $product_id);

                $produts_specs_val_array_new = array();

                foreach ($produts_specs_val_array as $item) {
                    array_push($produts_specs_val_array_new, $item['spec_value']);
                }

                $produts_specs_val = implode(',', $produts_specs_val_array_new);
                //$data["specs"][$i]->spec_val="[".$produts_specs_val."]";
                $data["specs"][$i]->spec_value = $produts_specs_val_array_new;
            }

            for ($i = 0; $i < count($data["attrs"]); $i++) {
                $produts_attributes_val_array = $this->Categories_model->getProductsCategoryAttributes($data["attrs"][$i]->id, $product_id);

                $produts_attributes_val_array_new = array();

                foreach ($produts_attributes_val_array as $item) {
                    array_push($produts_attributes_val_array_new, $item['attribute_value']);
                }

                $produts_attr_val = implode(',', $produts_attributes_val_array_new);
                //$data["attrs"][$i]->attribute_value="[".$produts_attr_val."]";
                $data["attrs"][$i]->attribute_value = $produts_attributes_val_array_new;
            }



            $data['hidden_product_id'] = $product_id;

            $this->load->view("admin/products/update_new", $data);
        } else {


            $selected_category = $this->session->userdata("selected_category");

            $is_product_returnable = $this->input->post("is_product_returnable");
            if ($is_product_returnable == "Yes") {
                $product_return_days = $this->input->post("product_return_days");
            } else {
                $product_return_days = 0;
            }

            $productDetails = [
                "name" => $this->input->post("product_name"),
                "keywords" => $this->input->post("product_keywords"),
                "meta_description" => $this->input->post("meta_desc"),
                "meta_title" => $this->input->post("meta_title"),
                "surl" => $this->input->post("surl"),
                "description" => $this->input->post("products_description"),
                "provide_order_at_buyer_place" => $this->input->post("buyers_place"),
                "price_type" => $this->input->post("price_type"),
                "height" => $this->input->post("height"),
                "weight" => $this->input->post("weight"),
                "width" => $this->input->post("width"),
                "length" => $this->input->post("length"),
                "hike_percentage" => $this->input->post("hike_percentage"),
                "discount_percentage" => $this->input->post("discount_percentage"),
                "is_product_returnable" => $is_product_returnable,
                "product_return_days" => $product_return_days,
                "available_quantity" => $this->input->post("available_quantity"),
                "track_inventory" => $track_inventory
            ];

            if ($track_inventory == 1) {
                //update to product details whose inventory has to be managed
                $productDetails['low_stock_qty'] = $this->input->post("low_stock_quantity");
                $productDetails['notifyme'] = $this->input->post("chk_notify") == NULL ? 0 : 1;
            } else {
                //update to product details whose inventory has to be managed
                //i.e. set below fields to zero means nothing to be tracked
                $productDetails['low_stock_qty'] = 0;
                $productDetails['notifyme'] = 0;
            }

            $this->Product_model->updateProduct($product_id, $productDetails);

            $vals = $this->input->post("attr_val");
            $vals = array_filter($vals);
            foreach ($vals as $val) {
                $chunk = explode("_", $val);
                $attrs[] = [
                    "product_id" => $product_id,
                    "attribute_id" => $chunk[1],
                    "attribute_value" => $chunk[0],
                ];
            }
            $vals = $this->input->post("spec_val");
            $vals = array_filter($vals);
            foreach ($vals as $val) {
                $chunk = explode("_", $val);
                $specs[] = [
                    "product_id" => $product_id,
                    "spec_id" => $chunk[1],
                    "spec_value" => $chunk[0],
                ];
            }
            if ($attrs) {
                $this->Product_model->updateAttributes($product_id, $attrs);
            }
            if ($specs) {
                $this->Product_model->updateSpecification($product_id, $specs);
            }

            $price_type = $this->input->post("price_type");
            $price_unit = $this->input->post("unit");
            $price_moq = $this->input->post("moq");
            $price_moq = array_filter($price_moq);
            $price_rate = $this->input->post("price");
            $price_rate = array_values(array_filter($price_rate));

            $discount_price = $this->input->post("hike_price");
            $discount_price = array_values(array_filter($discount_price));

            $final_price = $this->input->post("discount_price");
            $final_price = array_values(array_filter($final_price));

            $price = [];
            if ($price_type == "single") {
                $price[] = [
                    "product_id" => $product_id,
                    "quantity_from" => $price_moq[0],
                    "quantity_upto" => $this->input->post("available_quantity"),
                    "price" => round($price_rate[0]),
                    "atz_price" => round($discount_price[0]),
                    "unit" => $price_unit,
                    "final_price" => round($final_price[0])
                ];
            } else {

                for ($i = 0; $i < (count($price_rate)); $i++) {

                    $start = $price_moq[$i] ?? "0";
                    $end = $price_moq[$i + 1];
                    if ($end) {
                        $end = $end - 1;
                    } else {
                        $end = $this->input->post("available_quantity");
                    }

                    if ($i == 0) {
                        $atz_prize = $discount_price[$i + 1];
                        $f_price = $final_price[$i + 1];
                    } else {
                        $atz_prize = $discount_price[$i + 1];
                        $f_price = $final_price[$i + 1];
                    }

                    $price[] = [
                        "product_id" => $product_id,
                        "quantity_from" => $start,
                        "quantity_upto" => $end,
                        "price" => round($price_rate[$i]),
                        "atz_price" => round($atz_prize),
                        "unit" => $price_unit,
                        "final_price" => round($f_price)
                    ];
                }
            }

            $data = array();

            $product_hidden_image_file = $this->input->post('product_hidden_image_file');
            $result = array_filter($product_hidden_image_file);
            $product_images = array(
                "product_id" => $product_id,
                "type" => "photo",
                "url" => $result,
            );

            if ($product_images) {
                $this->Product_model->updateMedia($product_id, $product_images);
            }


            $video_url = $this->input->post('video_url');

            $product_video = array(
                "product_id" => $product_id,
                "type" => "video",
                "url" => $video_url,
            );

            if ($product_video) {
                $this->Product_model->updateMedia($product_id, $product_video);
            }


            if ($price) {
                $this->Product_model->updatePrices($product_id, $price);
            }


            $policies_array = array(
                "product_id" => $product_id,
                "policy" => $this->input->post('policy')
            );

            if ($is_product_returnable == "No") {
                $policies_array = 0;
            }

            $this->Product_model->updatePolicies($policies_array);

            $available_quantity = $this->input->post("available_quantity");
            $low_stock_qty = $this->input->post("low_stock_quantity");

            if ($available_quantity > 0) {
                //after update of product quantity if available qunatity reaches to max than 0
                //then send sms email to buyers that product is available for shopping
                $productName = $this->input->post("product_name");
                $sms_message = "Hurry up! Product " . $productName . " is available for shopping on atzcart.com";
                $notify_numbers = $this->Common_model->get_notify_list_buyers($product_id, 'phone');
                $notify_emails = $this->Common_model->get_notify_list_buyers($product_id, 'email');
                if ($notify_numbers != '') {
                    $this->load->library('Send_data');
                    $this->load->library('Common_email');
                    $this->send_data->send_sms($sms_message, $notify_numbers);
                    $urlPath = 'product_details/' . $this->Product_model->seoUrl($productName) . '/' . $product_id;
                    $emailData = array('from' => '',
                        'to' => 'yogeshpardeshi@ayninfotech.com',
                        'emailViewOrMsg' => 'emailtemplates/buyer_stock_reminder',
                        'emailViewValues' => array('product_name' => $productName,
                            'url' => $urlPath));
                    $data = $this->common_email->send_custom_email($emailData);
                    //update buyer notify timestamp after sms sent
                    $this->Common_model->update_notify_list_buyer($product_id);
                    $this->session->set_userdata('sms_buyer_numbers', $notify_numbers);
                }
            }
            $this->session->set_flashdata('message', 'Product updated successfully!');
            redirect("admin/products", "refresh");
        }
    }

    public function ajaxChildCats() {
        $cat_id = $this->input->post("cat_id");
        $output = [
            "status" => 0,
        ];
        $cats = $this->Categories_model->getImidiateChildCategories($cat_id);
        if ($cat_id) {
            $output["status"] = 1;
            $output["items"] = $cats;
        }
        echo json_encode($output);
    }

    public function delete($product_id) {
        $result = $this->Product_model->deleteProductData($product_id);

        if ($result) {
            redirect(base_url() . "admin/products");
        }
    }

    public function ajax_upload_image() {
        $checkImageSizes = $this->awsupload->checkImageSize('myfile', 'product');
        if ($checkImageSizes !== true) {
            echo json_encode(array("status" => "failed", "error" => '<br>' . $checkImageSizes));
            exit;
        }
        $s3FilePath = $this->awsupload->upload('myfile', 'uploads/images/products', 'image');
        if ($s3FilePath == false) {

            echo json_encode(array("status" => "failed", "error" => 'File type not allowed!'));
            exit;
        } else {
            echo json_encode(array("status" => "success", "file_name" => $s3FilePath));
            exit;
        }
    }

    public function rejected() {
        $data['pageTitle'] = "Atzcart || Products";
        $this->load->view("admin/products/rejected_list", $data);
    }

    public function ajaxProductSpecsAttr() {
        $output = [
            "status" => 0,
            "message" => "invalid inputs",
            "data" => []
        ];
        $this->form_validation->set_rules("product_id", "Product", "required");
        if ($this->form_validation->run() === false) {
            echo json_encode($output);
        } else {
            $product_id = $this->input->post("product_id");
            $data['attrs'] = $this->Product_model->getProductAttrs($product_id);
            $output["status"] = 1;
            $output["message"] = "Success";
            $output["data"] = $data;
            echo json_encode($output);
        }
    }

    function deactivateProducts() {
        $data['pageTitle'] = "Deactivated Products";
        $data["get_url"] = "admin/products/ajax_deactivated_list";
        $data["status"] = "rejected";
        $data['categories'] = $this->Categories_model->getAll();
        $this->load->view("admin/products/deactivated_list_new", $data);
    }

    public function ajax_deactivated_list() {
        $from = $this->input->post("published_from");
        $to = $this->input->post("published_to");
        $category = $this->input->post("category");
        $name = $this->input->post("pname");
        $seller2 = $this->input->post("seller") ?? 0;
        $status = $this->input->post("status");

        if ($from != '' && $to != '') {
            $from = date('Y-m-d', strtotime($from));
            $to = date('Y-m-d', strtotime($to));
        }

        $products = $this->Product_model->get_datatables($from, $to, $seller2, $category, $name, $status, $bulk = '');

        $data = array();
        $no = $this->input->post('start');
        foreach ($products as $product) {
            $img = explode("/", $product->media_url);
            $cnt = count($img) - 1;

            $img2 = explode('.', $img[$cnt]);
//            $thumb = base_url() . "uploads/images/products/" . $img2[0] . "_thumb." . $img2[1];

            $thumb = $product->media_url;

            if ($product->price1 == $product->price2) {
                $price = $product->price1;
            } else {
                $price = $product->price2 . " - " . $product->price1;
            }
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = "<a href='" . site_url('admin/products/update/') . $product->product_id . "' class='label label-info'>PRD" . $product->product_id . "</a>";
            $row[] = "<img class='img img-thumbnail' src='" . $thumb . "' width='60' height='60'>";
            $row[] = $product->name;
            $row[] = $product->categories_name;
            $row[] = $price;
            $row[] = $product->hike;
            $row[] = $product->atzprice2 . '-' . $product->atzprice1;
            $row[] = $product->discount;
            $row[] = $product->final_price2 . '-' . $product->final_price2;
            $seller = "ATZ" . $product->seller;
            $row[] = "<a href='javascript:void(0);' class='label label-info btnViewSeller' data-sid='" . $product->seller . "' >" . $seller . "</a>";
            $row[] = $product->available_quantity;
            $row[] = "<a href='javascript:void(0);' class='label label-primary btnViewSpecs' data-pid='" . $product->product_id . "' >View</a>";

            $row[] = '<a href="' . base_url() . 'admin/products/toggleActivation/approved/' . $product->product_id .
                    '" class="tabledit-edit-button '
                    . 'btn btn-primary waves-effect waves-light btn-sm" '
                    . 'data-toggle="tooltip" data-placement="top" title="" '
                    . 'data-original-title="Edit" title="To activate click here"><i class="fa fa-ban"></i></a>';

            $data[] = $row;
        }

        $output = array(
            "draw" => $this->input->post('draw'),
            "recordsTotal" => $this->Product_model->count_all(),
            "recordsFiltered" => $this->Product_model->count_filtered($from, $to, $seller2, $category, $name, $status, $bulk = ''),
            "data" => $data,
            "posts" => $this->input->post()
        );
        //output to json format
        echo json_encode($output);
    }

    function toggleActivation() {
        $activateEnum = $this->security->xss_clean($this->uri->segment(4, 0));
        $productId = $this->security->xss_clean($this->uri->segment(5, 0));
        if ($productId == 0) {
            $this->session->flashdata('message', 'You do not have permission to add deactivation!');
            redirect($_SERVER['HTTP_REFERER']);
        }
        if ($this->session->has_userdata('admin_id')) {
            if ($this->checkSession()) {
                if ($this->checkPermission('add')) {
                    //toggle product here
                    $this->db->update('product_details',
                            array('publish_status' => $activateEnum), array('id' => $productId));
//                   echo $this->db->last_query();
//                   exit();
                    if ($this->db->affected_rows() > 0) {
                        $msg = ($activateEnum == 'rejected' ? 'deactivated' : 'activated');
                        $this->session->set_flashdata('message', 'Product successfully ' . $msg);
                        redirect('admin/products/deactivateProducts');
                    } else {
                        $this->session->set_flashdata('message', 'No such product found!');
                        redirect('admin/products/deactivateProducts');
                    }
                } else {
                    $this->session->flashdata('message', 'You do not have permission to add deactivation!');
                    redirect($_SERVER['HTTP_REFERER']);
                }
            } else {
                $error = "<div class='alert alert-danger alert-dismissible'>
                        <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                        <strong>Error!</strong> Session timeout, relogin!.
                      </div>";
                $this->session->set_flashdata("message", $error);
                redirect("admin/login", "refresh");
            }
        }
    }

    private function checkSession() {
        if (!$this->session->userdata("admin_logged_in")) {
            return false;
        } else {
            return true;
        }
    }

    private function checkPermission($permName) {
        //menu id for deactivated is 59 and 
//        if ($this->session->has_userdata("admin_id")) {
//            $adminId = $this->session->userdata("admin_id");
//            $result = $this->db->select('view, add, edit, delete')
//                     ->from('user_permission')
//                     ->where(array('menu_id'=>59, 'user_id' => $adminId))
//                     ->get()->result_array()[0];
//            if($result[$permName] == 1) {
//                return true;
//            } else {
//                return false;
//            }
//        } else {
//            return false;
//        }
        return true;
    }

    public function tst($product_id, $commision = 100, $discount = 0) {
        $this->output->enable_profiler(true);
        $data["pageTitle"] = "Post New Product";
        $data["attrs"] = $this->Categories_model->getCategoryAttributes($cat_id);
        $data["specs"] = $this->Categories_model->getCategorySpecifications($cat_id);

        //$produts_attrs = $this->Categories_model->getProductsCategoryAttributes($cat_id, $product_id);
        //$produts_specs = $this->Categories_model->getProductsCategorySpecifications($cat_id, $product_id);

        $data["units"] = $this->Units_model->getAll();
        $data['ProductDetails_data'] = $this->Product_model->getProductDetails($product_id);
        $data['ProductPolicies_data'] = $this->Product_model->getProductPolicies($product_id);

        for ($i = 0; $i < count($data["specs"]); $i++) {
            $produts_specs_val_array = $this->Categories_model->getProductsCategorySpecifications($data["specs"][$i]->id, $product_id);

            $produts_specs_val_array_new = array();

            foreach ($produts_specs_val_array as $item) {
                array_push($produts_specs_val_array_new, $item['spec_value']);
            }

            $produts_specs_val = implode(',', $produts_specs_val_array_new);
            //$data["specs"][$i]->spec_val="[".$produts_specs_val."]";
            $data["specs"][$i]->spec_value = $produts_specs_val_array_new;
        }


        //echo "<pre>";
        //print_r($data["specs"]);exit;


        for ($i = 0; $i < count($data["attrs"]); $i++) {
            $produts_attributes_val_array = $this->Categories_model->getProductsCategoryAttributes($data["attrs"][$i]->id, $product_id);

            $produts_attributes_val_array_new = array();

            foreach ($produts_attributes_val_array as $item) {
                array_push($produts_attributes_val_array_new, $item['attribute_value']);
            }

            $produts_attr_val = implode(',', $produts_attributes_val_array_new);
            //$data["attrs"][$i]->attribute_value="[".$produts_attr_val."]";
            $data["attrs"][$i]->attribute_value = $produts_attributes_val_array_new;
        }


        echo "<pre>";
        print_r($data);
        exit;

        $data['hidden_product_id'] = $product_id;
    }

    /**
     * @author Yogesh Pardeshi 11072019
     * @param avail_qty user input for available quantity
     * @return true if available quantity is greater than min order quantity
     */
    function compare_avail_qty_moq($avail_qty) {
        $min_qty = $this->security->xss_clean($this->input->post('moq'));
        foreach ($min_qty as $qty) {
            if ($avail_qty < $qty) {
                $this->form_validation->set_message('compare_avail_qty_moq', 'The available quantity must be greater than or equal to minimum order quantity!');
                return false;
            } else {
                return true;
            }
        }
    }

    /**
     * @author Yogesh Pardeshi 04082019
     * @param avail_qty user input for available quantity
     * @return true if low stock is less than available quantity
     * for inventory only
     */
    function compare_with_low_quantity($avail_qty) {
        $low_stock_quantity = $this->security->xss_clean($this->input->post('low_stock_quantity'));
        if ($avail_qty < $low_stock_quantity) {
            $this->form_validation->set_message('compare_with_low_quantity', 'The available quantity must be greater than low stock quantity!');
            return false;
        } else {
            return true;
        }
    }


    public function exportAllProducts() {

        $fileName = 'product_details' . time() . '.xlsx';
        $result = $this->Offer_model->productReport();
        if ($result) {
            $this->load->model('Download_excel_model');
            $this->Download_excel_model->download(
                    $fileName, 'Product Details',
                    array('Product ID','Seller', 'Product name','quantity', 'Category',
                        'Seller price', 'ATZ Hike%', 'ATZ Price', 'Discount', 'Final price',
                        'Offer Name', 'Offer %', 'Offer Price', 'Offer start date',
                        'Offer End date', 'Requested date', 'Approved date','Approved by'),
                    $result,'products'
            );
        } else {
            redirect("admin/products/" . $page, "refresh");
        }
    }

}
