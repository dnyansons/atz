 <?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Products extends CI_Controller {

    public function __construct() 
    {
        parent::__construct();
        if (!$this->session->userdata("user_logged_in") || $this->session->userdata("user_role")!="seller") {
            $error = "<div id='login-error' class='form-error notice notice-error'><span class='icon-notice icon-error'></span><span><strong>Error!</strong> Session timeout, relogin!. </span></div>";
            $this->session->set_flashdata("message", $error);
            redirect("login", "refresh");
        }

        $this->load->model('Product_model');
        $this->load->model('Users_model');
        $this->load->model('Categories_model');
        $this->load->model('Common_model');
        $this->load->model('Brand_model');
        $this->load->model('Collections_model');
        $this->load->model('Units_model');
        $this->load->library('form_validation');
        $this->load->library('Browser_notification');
        $this->load->library('awsupload');
    }

    public function index() {
        $data["pageTitle"] = "Approved Products";
        //pass the name such that we can extract 
        //the table name and status of product
        $data["download_excel"] = "approved/products";
        $data["status"] = "approved";
        $data["header"] = "Approved Products";
        $data['categories'] = $this->Categories_model->getAll();
        $data["get_url"] = "seller/products/ajax_list";
        $this->load->view("user/product/list_new", $data);
    }

    public function pending() {
        $data["pageTitle"] = "Pending For Approval Products";
        $data["status"] = "requested";
        //pass the name such that we can extract 
        //the table name and status of product
        $data["download_excel"] = "requested/products";
	$data["header"] = "Pending Products";
        $data['categories'] = $this->Categories_model->getAll();
        $data["get_url"] = "seller/products/ajax_list";
        $this->load->view("user/product/list_new", $data);
    }

    public function initiated() {
        $data["pageTitle"] = "Products Not Requested Yet";
        //pass the name such that we can extract 
        //the table name and status of product
        $data["download_excel"] = "initiated/products";
        $data["status"] = "initiated";
        $data["header"] = "Initiated Products";
        $data['categories'] = $this->Categories_model->getAll();
        $data["get_url"] = "seller/products/ajax_list";
        $this->load->view("user/product/list_new", $data);
    }

    public function rejectedProducts() 
    {
        $data['pageTitle'] = "Rejected Products";
        $data["download_excel"] = "rejected/products";
        $data["status"] = "Rejected";
        $data["get_url"] = "seller/products/ajaxRejected_list";
        $data['categories'] = $this->Categories_model->getAll();
        $this->load->view("user/product/list_new", $data);
    }

    public function ajax_list() {

        $from     = $this->input->post("from");
        $to       = $this->input->post("to");
        $category = $this->input->post("category");
        $productName = $this->input->post("productName");
        $bulk = $this->input->post("bulk");
        $status = $this->input->post("status");
        $seller = $this->session->userdata("user_id");

        $products = $this->Product_model->get_datatables($from, $to, $seller, $category, $productName, $status, $bulk);
        $data = array();
        $no = $this->input->post('start');
        $outOfStock = "";//for out of stock product
        
        foreach ($products as $product) {
            $thumb = $product->media_url;

            if ($product->price1 == $product->price2) {
                $price = $product->price1;
            } else {
                $price = $product->price2 . " - " . $product->price1;
            }
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = "<a class='label label-info' href='". site_url('seller/products/updatepostNew/').$product->product_id."' </a>PRD" . $product->product_id."</a>";
            $row[] = "<img class='img img-thumbnail' src='" . $thumb . "' width='60' height='60'>";
            //if status is approved then show out of stock products
            if(strtolower($product->publish_status) == 'approved') {
                if ($product->available_quantity == 0) {
                    $outOfStock = '<br><small class="text-danger ml-5 blinking">Out Of Stock</small>';
                } else {
                    $outOfStock = "";
                }
            }
            
            $row[] = $product->name.$outOfStock;
            $row[] = $product->categories_name;
            $row[] = $price;
            $row[] = "<a href='javascript:void(0);' class='badge badge-info btnUpdateQuantity' data-pid='" . $product->product_id . "'>" . $product->available_quantity . " | Set</a>";
            $row[] = "<a href='javascript:void(0);' class='label label-primary btnViewSpecs' data-pid='" . $product->product_id . "' >View</a>";

            if($status == "initiated"){
                $row[] = $row[8]."<a href='#' class='label label-primary btn_publish' data-pid='" . $product->product_id . "' >Request</a>";
            } else if($status == "requested") {
                $row[] = "<a href=" . base_url('seller/products/updatepostNew/'. $product->product_id). " class='label label-primary ' data-pid='" . $product->product_id . "' >Edit</a>";
            }else{
				 $row[] = '<span style="color:green"> Approved </span>';
			}
            $data[] = $row;
        }

        $output = array(
            "draw" => $this->input->post('draw'),
            "recordsTotal" => $this->Product_model->count_all(),
            "recordsFiltered" => $this->Product_model->count_filtered($from, $to, $seller, $category, $name, $status, $bulk),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }


    public function ajaxRejected_list()
    {
        $from = $this->input->post("published_from");
        $to = $this->input->post("published_to");
        $category = $this->input->post("category");
        $name = $this->input->post("pname");
        $seller2 = $this->input->post("seller")??0;
        $bulk = $this->input->post("bulk");
        $status = $this->input->post("status");
        $seller2 = $this->session->userdata("user_id");
        
        $products = $this->Product_model->get_datatables($from,$to,$seller2,$category,$name,$status, $bulk);
        
        $data = array();
        $no = $this->input->post('start');
        foreach ($products as $product) {
            $thumb =$product->media_url;
            
            if($product->price1 == $product->price2){
                $price = $product->price1;
            } else {
                $price = $product->price2." - ".$product->price1;
            }
            
            if(strlen($product->name) > 15){ 
                $len = "...";
            }else{
                $len = '';
            }
            
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = "<a href='#' class='label label-info'>PRD".$product->product_id."</a>";
            $row[] = "<img class='img img-thumbnail' src='".$thumb."' width='60' height='60'>";
            $row[] = "<span title = '". $product->name ."'>". substr($product->name,0,15). $len ."</span>";
            $row[] = $product->categories_name;
            $row[] = $price;
            $row[] = $product->hike;
            $row[] = $product->atzprice2.'-'.$product->atzprice1;
            $row[] = $product->discount;
            $row[] = $product->final_price2.'-'.$product->final_price2;
            $seller = "ATZ".$product->seller;
            $row[] = "<a href='javascript:void(0);' class='label label-info btnViewSeller' data-sid='".$product->seller."' >".$seller."</a>";
            $row[] = $product->available_quantity;
            $row[] = "<a href='javascript:void(0);' class='label label-primary btnViewSpecs' data-pid='".$product->product_id."' >View</a>";
            if($product->requested_on!=""){
                $row[] = date("d M Y",strtotime($product->requested_on));
            } else {
                $row[] = "-";
            }
            if($product->approved_on!=""){
                $adate = date("d M Y",strtotime($product->approved_on));
                $row[] = "<a href='javascript:void(0);' class='label label-primary btnViewApprover' data-pid='".$product->product_id."' >".$adate."</a>";
            } else {
                $row[] = "-";
            }
            
            
            $row[] = '<a href="'.base_url().'seller/products/updatepostNew/'.$product->product_id.'" class="tabledit-edit-button btn btn-primary waves-effect waves-light btn-sm" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit"><i class="fa fa-pencil-square-o"></i></a>
                    <button type="button" class="tabledit-delete-button btn btn-danger waves-effect waves-light btn-sm btn_publish" data-toggle="tooltip"  data-products_id="'.$product->product_id.'" data-original-title="Publish"><i class="fa fa-snowflake-o "></i></button>';

            $data[] = $row;
        }

        $output = array(
            "draw" => $this->input->post('draw'),
            "recordsTotal" => $this->Product_model->count_all(),
            "recordsFiltered" => $this->Product_model->count_filtered($from,$to,$seller2,$category,$name,$status, $bulk),
            "data" => $data,
            "posts" => $this->input->post()
        );
        //output to json format
        echo json_encode($output);
        
    }

    public function create() {
        
        $user = $this->session->userdata("user_id");
        $user_details = $this->Users_model->getUserById($user);
        if ($user_details->approved_status != "Approved") {
            $error = '<div class="alert alert-danger alert-dismissible">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        <strong>Warning!</strong> Your profile is not approved by admin yet.
                      </div>';
            $this->session->set_flashdata("message", $error);
            redirect("seller/Companyprofile", "refresh");
            exit;
        }
        $this->form_validation->set_rules("category_id", "Category_id", "required");
        if ($this->form_validation->run() === false) {
            $data["pageTitle"] = "Choose Category";
            $data['rootCats'] = $this->Categories_model->getBasicCategories();
            $this->load->view("user/product/choose_category", $data);
        } else {
            $newdata = array(
                'selected_category' => $this->input->post("category_id")
            );
            $this->session->set_userdata($newdata);
            redirect("seller/products/postNew", "refresh");
        }
    }

    /**
     * @auther Yogesh Pardeshi
     * shows views for single product for admin
     * @param product_if input of product number pk
     */
    public function viewSingleProduct($productId)
    {
        $productId = $this->security->xss_clean($productId);
        $sessionSellerId = $this->session->user_id;
        $checkUserIdWithPdId = $this->db->select('id')->from('product_details')
                               ->where('seller', $sessionSellerId)
                               ->where('id', $productId)
                               ->get()->result_array()[0]['id'];
        if($checkUserIdWithPdId) {
            $data['productData'] = $this->Product_model->readSingleProduct($productId);
            $this->load->view("user/product/single_seller_product_view", $data);
        } else {
            $errorData = '<div class="alert alert-success alert-dismissible col-md-6 offset-3">
                                          <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                          <strong>Info:</strong> Invalid product number!
                                        </div>';
            $this->session->set_flashdata('message', $errorData);
            redirect("seller/dashboard", "refresh");
        }
    }

    public function postNew() {
       
        $user = $this->session->userdata("user_id");
        $cat_id = $this->session->userdata("selected_category");
        $this->form_validation->set_rules("product_name", "Name", "required");
        $this->form_validation->set_rules("height", "Height per Unit", "required");
        $this->form_validation->set_rules("width", "Width per Unit", "required");
        $this->form_validation->set_rules("width", "Width per Unit", "required");
        $this->form_validation->set_rules("weight", "Weight per Unit", "required");
        $this->form_validation->set_rules("length", "Length per Unit", "required");
        $this->form_validation->set_rules("product_keywords", "Keywords", "required");
	$this->form_validation->set_rules("products_description", "products description", "required");
        $this->form_validation->set_rules("available_quantity", "available quantity", "required|callback_compare_avail_qty_moq");
        $this->form_validation->set_rules('product_hidden_image_file', 'Product image ');


        //for better handling of validation if product has attributes or specification only then
        //validate or block page to show errors validation added on date 09-08-2019 by Yogesh Pardeshi
        if(isset($_POST['attr_val'])){
            // print_r(var_dump($_POST['attr_val']));
            $this->form_validation->set_rules('attr_val[]',"attribute", "required");
        }
        if(isset($_POST['spec_val'])){
            $this->form_validation->set_rules('spec_val[]',"specification", "required");
            //  print_r(var_dump($_POST['spec_val']));
        }

        $this->form_validation->set_rules("track_inventory", "Track Inventory", "required");

        $track_inventory = $this->input->post('track_inventory'); // added for inventory management concept

        if($track_inventory == 1) {
            $this->form_validation->set_rules("low_stock_quantity", "Low Stock Quantity", "required|numeric");
            $this->form_validation->set_rules("available_quantity", "available_quantity", "required|callback_compare_avail_qty_moq|callback_compare_with_low_quantity");
        }
        // $this->form_validation->set_rules("product_hidden_image_file[]", "Images", "required");
        //[track_inventory] => 1 [available_quantity] => 125 [low_stock_quantity] => 5 [chk_notify] => 1

        if ($this->form_validation->run() === false) {
            $data["pageTitle"] = "Post New Product";
            $data["attrs"] = $this->Categories_model->getCategoryAttributes($cat_id);
            $data["specs"] = $this->Categories_model->getCategorySpecifications($cat_id);
            $data["units"] = $this->Units_model->getAll();
            $data["pickupaddress"] = $this->Users_model->checkPickupaddressAvailable($user);

           // echo validation_errors();
            if ($data["pickupaddress"] === false) {
                $error = '<div class="alert alert-danger alert-dismissible">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        <strong>Error!</strong> Please update pickup address first.
                      </div>';
                $this->session->set_flashdata("message", $error);
            }
            $this->load->view("user/product/create_new", $data);
        } else {
			
			
            $data["pickupaddress"] = $this->Users_model->checkPickupaddressAvailable($user);

            if ($data["pickupaddress"] === false) {
                $error = '<div class="alert alert-danger alert-dismissible">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        <strong>Error!</strong> Please update pickup address first.
                      </div>';
                $this->session->set_flashdata("message", $error);
                redirect("seller/products/postNew", "refresh");
            }

            $user = $this->session->userdata("user_id");
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
                "description" => $this->input->post("products_description"),
                "seller" => $user,
                "category" => $selected_category,
                "provide_order_at_buyer_place" => $this->input->post("buyers_place"),
                "price_type" => $this->input->post("price_type"),
                "height" => $this->input->post("height"),
                "weight" => $this->input->post("weight"),
                "width" => $this->input->post("width"),
                "length" => $this->input->post("length"),
                "is_product_returnable" => $is_product_returnable,
                "product_return_days" => $product_return_days,
                "available_quantity" => $this->input->post("available_quantity"),
                "track_inventory" => $track_inventory
            ];


            if($track_inventory == 1) {
                //add to product details if inventory has to be managed
                $productDetails['low_stock_qty'] = $this->input->post("low_stock_quantity");
                $productDetails['notifyme'] = $this->input->post("chk_notify") == NULL? 0 : 1 ;
            }

            $product_id = $this->Product_model->addProduct($productDetails);

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
                $this->Product_model->addAttributes($attrs);
            }
            if ($specs) {
                $this->Product_model->addSpecification($specs);
            }


            $price_type = $this->input->post("price_type");
            $price_unit = $this->input->post("unit");
            $price_moq = $this->input->post("moq");
            $price_moq = array_filter($price_moq);
            $price_rate = $this->input->post("price");
            $price_rate = array_values(array_filter($price_rate));
			
			
            $price = [];
            if ($price_type == "single") {
                $price[] = [
                    "product_id" => $product_id,
                    "quantity_from" => $price_moq[0],
                    "quantity_upto" => $this->input->post("available_quantity"),
                    "price" => $price_rate[0],

                    "unit" => $price_unit,
                    "final_price" => round($price_rate[0]),
                    "atz_price" => round($price_rate[0])
                ];
            } else {

                for ($i = 0; $i < (count($price_rate)); $i++) {
                    $start = $price_moq[$i] ?? "0";
					$end = $price_moq[$i + 1];
					if($end)
					{
						$end = $end - 1;
					}else{
						$end = $this->input->post("available_quantity");
					}
                    $price[] = [
                        "product_id" => $product_id,
                        "quantity_from" => $start,
                        "quantity_upto" => $end,
                        "price" => round($price_rate[$i]),
                        "unit" => $price_unit,
                        "final_price" => round($price_rate[$i]),
                        "atz_price" => round($price_rate[$i])
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
                $this->Product_model->addPrices($price);
            }

            $policies_array = array(
                "product_id" => $product_id,
                "policy" => $this->input->post('policy')
            );

            if ($is_product_returnable == "No") {
                $policies_array = 0;
            }


            $this->Product_model->updatePolicies($policies_array);


            $rev = [
                "product_id" => $product_id,
                "views" => 0,
                "sales" => 0,
                "rating" => 0,
            ];
            $cats = $this->Categories_model->getParentsByChild($selected_category);
            if($cats){
                $ids = [
                    $cats->child,
                    $cats->parent,
                    $cats->super_parent,
                ];
                $this->Categories_model->incrementProductCount($ids);
            }
            $this->session->set_flashdata('message', 'New product created!');
            redirect("seller/products/initiated", "refresh");
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

    /**
     * Create thumbnail
     *
     * @return Response
     */
    public function resizeImage($filename) {
        $source_path = './uploads/images/products/' . $filename;
        $target_path = './uploads/images/products/';
        $config_manip = array(
            'image_library' => 'gd2',
            'source_image' => $source_path,
            'new_image' => $target_path,
            'maintain_ratio' => TRUE,
            'create_thumb' => TRUE,
            'thumb_marker' => '_thumb',
            'width' => 150,
            'height' => 150
        );

        $this->load->library('image_lib');
        $this->image_lib->initialize($config_manip);
        if (!$this->image_lib->resize()) {
            //echo $this->image_lib->display_errors();
        }
        $this->image_lib->clear();
    }

    public function publishRequest() {

        $output = [
            "status" => 0,
            "msg" => ""
        ];

        $this->form_validation->set_rules('product_id', 'product_id', 'required');

        if ($this->form_validation->run() === false) {
            echo json_encode($output);
        } else {
            $product_id = $this->input->post('product_id');
            $data = ["publish_status" => "requested","requested_on" => date("Y-m-d h:i:s")];
            $res = $this->Product_model->updateProductPublishStatus($product_id, $data);
            if ($res) {
                $output = [
                    "status" => 1,
                    "msg" => "publish request placed successfully"
                ];
                echo json_encode($output);
                
                //Notify To Admin
                $title='New Product Request!';
                $message='New Product Publish Request From Seller For Product #PRD'.$product_id;
                $tag=date('d M Y H:i'); 
                $this->browser_notification->notifyadmin($title,$message,$tag);
            }
        }
    }

    public function update($product_id) {
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

            $this->load->view("user/product/choose_category_edit", $data);
        } else {
            //update product 
            $category_id = $this->security->xss_clean($this->input->post('category_id'));
            $product_id = $this->security->xss_clean($this->uri->segment(4,0));
            if(isset($category_id) && !empty($category_id) && $product_id !=0){
                $this->db->where('id', $product_id)
                ->update('product_details', array('category' => $category_id ));
                $this->session->set_flashdata('message', 'Product category updated successfully!');
            }
            $newdata = array(
                'selected_category' => $this->input->post("category_id")
            );
            $this->session->set_userdata($newdata);
            redirect("seller/products/updatepostNew/$product_id", "refresh");
        }
    }

    public function updatepostNew($product_id) {
        if(strcasecmp($this->session->user_role, 'seller') == 0) {
            $id = $this->security->xss_clean($product_id);
            $status = $this->db->select('publish_status')
                               ->from('product_details')
                               ->where('id', $id)->get()->result_array()[0]['publish_status'];
            if(strcasecmp($status, 'approved') == 0) {
                $this->session->set_flashdata('message',"You can't edit approved products!");
                $this->load->library('user_agent');
                    redirect($_SERVER['HTTP_REFERER']);
            }
        }

        $cat_id = $this->Product_model->getCategoryId($product_id);//read from db for old product
        $data['cat_id'] = $cat_id;
        $this->form_validation->set_rules("product_name", "Name", "required");
        $this->form_validation->set_rules("height", "Height per Unit", "required");
        $this->form_validation->set_rules("width", "Width per Unit", "required");
        $this->form_validation->set_rules("weight", "Weight per Unit", "required");
        $this->form_validation->set_rules("length", "Length per Unit", "required");
        $this->form_validation->set_rules("product_keywords", "Keywords", "required");
        $this->form_validation->set_rules("available_quantity", "available_quantity", "required|callback_compare_avail_qty_moq");
        $this->form_validation->set_rules('product_hidden_image_file', 'Product image ', "callback_validate_product_image");
        $this->form_validation->set_rules('products_description',"description","required");
        $this->form_validation->set_rules("track_inventory", "Track Inventory", "required");

        //for better handling of validation if product has attributes or specification only then
        //validate or block page to show errors validation added on date 09-08-2019 by Yogesh Pardeshi
        if(isset($_POST['attr_val'])){
           // print_r(var_dump($_POST['attr_val']));
            $this->form_validation->set_rules('attr_val[]',"attribute", "required");
        }
        if(isset($_POST['spec_val'])){
            $this->form_validation->set_rules('spec_val[]',"specification", "required");
            //  print_r(var_dump($_POST['spec_val']));
        }

        $track_inventory = $this->input->post('track_inventory'); // added for inventory management concept

        if($track_inventory == 1) {
            $this->form_validation->set_rules("low_stock_quantity", "Low Stock Quantity", "required|numeric");
            $this->form_validation->set_rules("available_quantity", "available_quantity", "required|callback_compare_avail_qty_moq|callback_compare_with_low_quantity");
        }

        if ($this->form_validation->run() === false) {

            $data["pageTitle"] = "Post New Product";
            
            $data["attrs"] = $this->Categories_model->getCategoryAttributes($cat_id);

            $data["specs"] = $this->Categories_model->getCategorySpecifications($cat_id);

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

            $this->load->view("user/product/update_new", $data);
        } else {
            $user = $this->session->userdata("user_id");
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
                "description" => $this->input->post("products_description"),
                "seller" => $user,
                "provide_order_at_buyer_place" => $this->input->post("buyers_place"),
                "price_type" => $this->input->post("price_type"),
                "height" => $this->input->post("height"),
                "weight" => $this->input->post("weight"),
                "width" => $this->input->post("width"),
                "length" => $this->input->post("length"),
                "is_product_returnable" => $is_product_returnable,
                "product_return_days" => $product_return_days,
                "available_quantity" => $this->input->post("available_quantity"),
                "track_inventory" => $track_inventory
            ];

            if($track_inventory == 1) {
                //update to product details whose inventory has to be managed
                $productDetails['low_stock_qty'] = $this->input->post("low_stock_quantity");
                $productDetails['notifyme'] = $this->input->post("chk_notify") == NULL? 0 : 1 ;
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

            $price = [];
            if ($price_type == "single") {
                $price[] = [
                    "product_id" => $product_id,
                    "quantity_from" => $price_moq[0],
                    "quantity_upto" => $this->input->post("available_quantity"),
                    "price" => $price_rate[0],
                    "unit" => $price_unit,
                    "final_price" => $price_rate[0],
                ];
            } else {
                //array_shift($price_moq);
                for ($i = 0; $i < (count($price_rate)); $i++) {
                    //echo "test<br>";
                    $start = $price_moq[$i] ?? "0";
                    $end = $price_moq[$i + 1] ?? $this->input->post("available_quantity");
                    $end = $end - 1;
                    $price[] = [
                        "product_id" => $product_id,
                        "quantity_from" => $start,
                        "quantity_upto" => $end,
                        "price" => $price_rate[$i],
                        "unit" => $price_unit,
                        "final_price" => $price_rate[$i],
                    ];
                }
            }

            $data = array();

            $product_hidden_image_file = $this->input->post('product_hidden_image_file');

            $product_images = array(
                "product_id" => $product_id,
                "type" => "photo",
                "url" => $product_hidden_image_file,
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

            if($available_quantity > $low_stock_qty) {
                //after update of product quantity if available qunatity reaches to max than low_stock_qty
                //then send sms email to buyers that product is available for shopping
                $sms_message = "Hurry up! Product " . $this->input->post("product_name") . " is available for shopping! ";
                $notify_numbers = $this->Common_model->get_notify_list_buyers($product_id, 'phone');
                $this->load->library('Send_data');
                $this->send_data->send_sms($sms_message, $notify_numbers);
            }
            if($status == 'initiated') {
                $this->session->set_flashdata('message', 'New product updated!');
                redirect("seller/products/initiated", "refresh");
            } else {
                $this->session->set_flashdata('message', 'New product updated!');
                redirect("seller/products/pending", "refresh");
            }
        }
    }

    public function ajax_upload_image() {


        $checkImageSizes = $this->awsupload->checkImageSize('myfile', 'product');
        if ($checkImageSizes !== true) {
            echo json_encode(array("status" => "failed", "error" => '<br>'.$checkImageSizes));
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
    
    public function increaseQuantity()
    {
        /***** This function changes previosly able to increase only now it will update as is **********/
        $output = [
            "status" => 0,
            "message" => "Invali inputs"
        ];
        $this->form_validation->set_rules("product_id","Product","required");
        $this->form_validation->set_rules("quantity","Quantity","required");
        if($this->form_validation->run()===false){
            echo json_encode($output);
        } else {
            $product = $this->input->post("product_id");
            $quantity = $this->input->post("quantity");
            $this->Product_model->increamentQuantity($product,$quantity);
            $output["status"] = 1;
            $output["message"] = "Success";
            $output["debug"] = $this->db->last_query();
            echo json_encode($output);
        }
    }
    
    public function getProductSpecifications()
    {
        $output = [
            "status" => 0,
            "data" => []
        ];
        $this->form_validation->set_rules("product_id","product","required");
        if($this->form_validation->run()===false){
            echo json_encode($output);
        } else {
            $product = $this->input->post("product_id");
            $output["status"] = 1;
            $output["data"] = $this->Product_model->getProductSpecificationsConcatinated($product);
            echo json_encode($output);
        }
    }
    
    /**
     * @author Yogesh Pardeshi 11072019
     * @param avail_qty user input for available quantity
     * @return true if available quantity is greater than min order quantity
     */
    function compare_avail_qty_moq($avail_qty) {
        $min_qty = $this->security->xss_clean($this->input->post('moq'));
        foreach ($min_qty as $qty) {
            if($avail_qty < $qty) {
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
    function compare_with_low_quantity($avail_qty)
    {
        $low_stock_quantity = $this->security->xss_clean($this->input->post('low_stock_quantity'));
        if ($avail_qty < $low_stock_quantity) {
            $this->form_validation->set_message('compare_with_low_quantity', 'The available quantity must be greater than low stock quantity!');
            return false;
        } else {
            return true;
        }
    }

    /**
     * @author Yogesh Pardeshi 20072019
     * checks for product image validation
     * @auto @param accepts file input name
     * i.e. one product image is mandatory
     */
    function validate_product_image()
    { 
        $imageUrl = $this->input->post('product_hidden_image_file');
        
        if(is_array($imageUrl)){
            foreach ($imageUrl as $url){
                if(!empty($url)){
                    return true;
                }
            }
            $this->form_validation->set_message('validate_product_image', "Please upload at least one product image!");
            return false;
        } else {
           $this->form_validation->set_message('validate_product_image', "Please upload at least one product image!");
           return false;
        }
    }
    
    
    function pro_view($product_id)
    {
        if(strcasecmp($this->session->user_role, 'seller') == 0) {
            $id = $this->security->xss_clean($product_id);
            $status = $this->db->select('publish_status')
                               ->from('product_details')
                               ->where('id', $id)->get()->result_array()[0]['publish_status'];
            if(strcasecmp($status, 'approved') == 0) {
                $this->session->set_flashdata('message',"You can't edit approved products!");
                $this->load->library('user_agent');
                    redirect($_SERVER['HTTP_REFERER']);
            }
        }
        
       
            $data["pageTitle"] = "Post New Product";
            $data["attrs"] = $this->Categories_model->getCategoryAttributes($cat_id);
            $data["specs"] = $this->Categories_model->getCategorySpecifications($cat_id);

            $data["units"] = $this->Units_model->getAll();
            $data['ProductDetails_data'] = $this->Product_model->getProductDetails($product_id);
            
            $data['ProductPolicies_data'] = $this->Product_model->getProductPolicies($product_id);

            //echo "<pre>";
            //print_r($data['ProductPolicies_data']);exit;


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


            //echo "<pre>";
            //print_r($data);exit;

            $data['hidden_product_id'] = $product_id;

            $this->load->view("user/product/view_product", $data);
    }


}
