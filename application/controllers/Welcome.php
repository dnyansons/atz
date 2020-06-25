<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

    public function __construct() {
        parent::__construct();

        header('Last-Modified:' . gmdate('D, d M Y H:i:s') . 'GMT');
        header('Cache-Control: no-cache, must-revalidate,max-age=0');
        header('Cache-Control: post-check=0, pre-check=0', false);
        header('Pragma: no-cache');

        $this->load->model("Shipping_model");
        $this->load->model("Users_model");
        $this->load->model("Common_model");
        $this->load->model("Categories_model");
        $this->load->model("Banners_model");
        $this->load->model("Rfqs_model");
        $this->load->model("Subscribers_model");
        $this->load->library("get_header_data");
        $this->load->model('Product_model');
        $this->load->model('Order_model');
        $this->load->model('myfavourite_model');
        $this->load->model('Inquiries_model');
        $this->load->model('Company_model');
        $this->load->model('Offer_model');
        $this->load->library('Shipping');
        $this->load->library('user_agent');
        $this->load->library('send_data');
        $this->load->library('browser_notification');
        $this->load->library('awsupload');
    }

    public function index() 
    {
        $data = $this->get_header_data->get_categories();
        if ($this->agent->is_mobile()) {
            redirect($this->config->item("mobile_site_url"));
        }
        $categories = $this->Categories_model->getTopSellingCategories(9);
        $items = array();
        $i = 0;
        foreach ($categories as $cat):
            $items[$i]["title"] = $cat->categories_name;
            $items[$i]["id"] = $cat->category_id;
            $i++;
        endforeach;
        
        $data["items"] = $items;
        $data['username'] = $this->session->userdata('user_name');
        $data["banners"] = $this->Banners_model->get_active_banners();
        //$interested_categories = get_cookie("intesested_categories");
        
        if ($interested_categories != NULL) {
            $catsi = explode(",", $interested_categories);
            $res = "";
            foreach ($catsi as $cati) {
                $res = $res . $cati . "," . $this->Categories_model->getAllChilds($cati) . ",";
            }
            $ctcats = array_unique(explode(",", trim($res, ",")));
            $data["prod_array"] = $this->Product_model->getProductByCatIds($ctcats, 18);
        } else {
            $data['prod_array'] = $this->Product_model->getProductList();
        }
        $sub_categories = $this->Categories_model->getHomePageCategories(3);
        $sub_finalcats = array();
        foreach ($sub_categories as $rt) {
            $cats = $this->Categories_model->get_top_subcategories($rt->category_id);
            $sub_finalcats[] = array(
                "id" => $rt->category_id,
                "title" => $rt->categories_name,
                "elements" => $cats
            );
        }
        
        $data['sub_finalcats'] = $sub_finalcats;
        $data['units'] = $this->Rfqs_model->get_units();
        
        $data["title"] = "Online Shopping Site | Largest Online B2B &amp; B2C Marketplace | ATZ Cart";

        $data["description"] = "Find all the global &amp; Indian wholesalers, importers, exporters, distributors, retailers,
                                manufacturers &amp; buyers under one roof. Maximize your sales with ATZ Cart.";
        $data["keywords"] = "wholesalers directory of wholesale trade suppliers, distributors, importers,
        manufacturers, suppliers, exporters, products, online shopping in India, online
        shopping store, online shopping site,buy online, shop online, online shopping";

        $data["jsscripts"] = '<script data-react-helmet="true" type="application/ld+json">
        {
            "@context": "http://schema.org",
            "@type": "Organization",
            "name": "ATZ Cart",
"description": "Find all the global &amp; Indian wholesalers, importers, exporters, distributors, retailers,manufacturers & buyers under one roof. Maximize your sales with ATZ Cart.",
            "url": "https://www.atzcart.com/",
            "sameAs": [
              " https://www.facebook.com/atzcart/",
              "https://twitter.com/AtzCart",
              "https://www.linkedin.com/company/atz-cart",
              "https://www.youtube.com/channel/UC3bEottzh-zrIAoFQSwjzgw",
              "https://www.instagram.com/atzcart/",
              "https://in.pinterest.com/atzcart/"
            ],
            "logo": "https://www.atzcart.com/assets/front/images/logo/logo.png",
"potentialAction": {
        "@type": "SearchAction",
        "target": "https://www.atzcart.com/?s={search_term_string}",
        "query-input": "required name=search_term_string"
         }
        }
        </script>
        ';

        $data['runningOffers'] = $this->Offer_model->getRunningOffers();
        
        $this->load->view("front/home/index",$data);
    }

    public function all_categories() {
        $data = $this->get_header_data->get_categories();
        $data["title"] = "ATZCart - All Categories";
        $parent_cats = $this->Categories_model->getRootCategories();
        $finalCats = array();
        foreach ($parent_cats as $parent) {
            $child_cats = $this->Categories_model->getImidiateChildCategories($parent->category_id, 4);
            $title = "";
            $elements = array();
            $j = 0;
            foreach ($child_cats as $child) {
                $nm = $child->categories_name;
                if (str_word_count($child->categories_name) > 2) {
                    $tmpnm = explode(" ", $child->categories_name);
                    $nm = $tmpnm[0];
                }
                $title = $title . $nm . "/";
                $id = $child->category_id;
                $elements[$j]["id"] = $child->category_id;
                $elements[$j]["title"] = $child->categories_name;
                $subelements = $this->Categories_model->getImidiateChildCategories($child->category_id, 10);
                $k = 0;
                $sub = array();
                foreach ($subelements as $subele) {
                    $sub[$k]["id"] = $subele->category_id;
                    $sub[$k]["title"] = $subele->categories_name;
                    $k++;
                }
                $elements[$j]["elements"] = $sub;
                $j++;
            }
            $title = rtrim($title, "/");
            $title = rtrim($title, ",");
            $finalCats[] = array("title" => str_replace("/", " / ", $title), "id" => $id, "elements" => $elements);
            $i++;
        }


        $data["categories"] = $finalCats;


        $root = $this->Categories_model->getRootCategories();
        $allCategories = array();
        foreach ($root as $rt) {
            $cats = $this->Categories_model->get_categories_by_parent($rt->category_id);
            $allCategories[] = array(
                "id" => $rt->category_id,
                "title" => $rt->categories_name,
                "image" => $rt->categories_image,
                "elements" => $cats,
            );
        }

        $data['root_categories'] = $root;
        $data['all_categories'] = $allCategories;

        /*         * ************** Upside Categories on Front ********************* */
        //$data['up_categories'] = $this->Categories_model->getTopSellingCategories(6);

        $this->load->view("front/home/all_categories", $data);
    }

    public function get_app() {
        $data = $this->get_header_data->get_categories();
        $data["title"] = "ATZCart - Get App";
        $this->load->view("front/home/get_app", $data);
    }

    public function add_rfqs() {
        $user_id = $this->session->userdata('user_id');
        if ($user_id) {
            $data = $this->get_header_data->get_categories();
            $data["title"] = "ATZCart - Submit RFQS";
            $arr = array(
                "product_name" => $this->input->post('product_name'),
                "quantity" => $this->input->post('quantity'),
                "unit" => $this->input->post('unit'),
            );

            $data['units'] = $this->Rfqs_model->get_units();
            $data['rootCats'] = $this->Categories_model->getBasicCategories();
            $data['categories_list'] = $this->Categories_model->get_categories();
            $data['arr'] = $arr;
            $this->load->view("front/sourcing_solutions/submit_rfq", $data);
        } else {
            redirect('login');
        }
    }

    public function insert_rfqs() {     
        $user_id = $this->session->userdata('user_id');
        $this->load->library("form_validation");
        $this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>');
        $this->form_validation->set_rules("product_name", "product Keyword", "trim|required");
        $this->form_validation->set_rules("categories_id", "category", "required");
        $this->form_validation->set_rules("quantity", "quantity", "required");
        $this->form_validation->set_rules("product_specification", "description", "required");

        if ($this->form_validation->run() === false) {
            if ($user_id) {
                $data = $this->get_header_data->get_categories();
                $data['rootCats'] = $this->Categories_model->getBasicCategories();
                $data['categories_list'] = $this->Categories_model->get_categories();
                $data['units'] = $this->Rfqs_model->get_units();

                $data["title"] = "ATZCart - Submit RFQS";
                $this->load->view("front/sourcing_solutions/submit_rfq", $data);
            } else {
                redirect('user');
            }
        } else {
             
             if ($_FILES['userFiles']['name'] != '' || !empty($_FILES['userFiles']['name'])) {
                    $s3FilePath = $this->awsupload->upload('userFiles', 'uploads/images/rfqs','image');
                    if($s3FilePath == false){
                        $error = "<div class='alert alert-danger alert-dismissible'>
                                <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                                <strong>Error!</strong> File type not allowed.!
                                </div>";
                        $this->session->set_flashdata("message", $error);
                        redirect('welcome/insert_rfqs');
                    }else{
                        $arr['attachments'] = $s3FilePath;
                    }
                } else {
                    $arr['attachments'] = '';
                }
        
                $todays_date = date("Y-m-d H:i:s");
                $product            =   htmlentities($this->input->post('product_name'));
                $arr['looking_for'] = 	$product;
                $arr['quanity']     = 	htmlentities($this->input->post('quantity'));
                $arr['customer_id'] =   $user_id;
                $arr['category_id'] = 	htmlentities($this->input->post('categories_id'));
                $arr['unit']        =   htmlentities($this->input->post('unit'));
                $arr['description'] = 	htmlentities($this->input->post('product_specification'));
                
                $arr['added_date']  = $todays_date;
                $arr['updated_date'] = $todays_date;
                $arr['status'] = 'Pending';
                $arr['expiry_date'] = date('Y-m-d', strtotime("+30 days"));

                $result = $this->Rfqs_model->addRfq($arr);

                $msg = " From " . $this->session->userdata('user_name') . " for the product " . $product." on date ". $todays_date;
                $tag = 'atzcart.com';

                $this->browser_notification->notifyadmin('New FFQ !', $msg, $tag);
                $adminNotify = array(
                    'title' => 'New RFQ',
                    'msg' => $msg . ' ( Web ) ',
                    'type' => 'RFQ',
                    'reference_id' => $user_id,
                    'status' => 'Received'
                );
               $insertAdminNotify = $this->Product_model->insertAdminNotify($adminNotify);

                $success = "<div class='alert alert-success alert-dismissible'>

                             <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                             <strong>Success!</strong> Request for quotation sent successfully!!.
                             </div>";
            $this->session->set_flashdata("message", $success);
            redirect('welcome/insert_rfqs');
        }
    }

    public function getProducthint($keyword) {
        //$this->output->enable_profiler(true);
        //$keyword = $this->input->get("term");
        $this->db->select("CD.categories_name name,CD.categories_id as id,C.parent_id as parent_id, CD1.categories_name as parent_name");
        $this->db->from("categories_description CD");
        $this->db->like("CD.categories_name",$keyword);
        $this->db->or_like("C.seo_keywords",$keyword);
        $this->db->join("categories C","CD.categories_id = C.category_id");
        $this->db->join("categories_description CD1","C.parent_id = CD1.categories_id");
        $this->db->order_by("C.product_count","DESC");
        $this->db->limit(4);
        $query = $this->db->get();
        $cats = $query->result();
        
        
        /************ Get Products ************/
        $this->db->select("P.name,P.id as id,P.category as parent_id,CD.categories_name parent_name");
        $this->db->from("product_details P");
        $this->db->join("categories_description CD","CD.categories_id = P.category");
        $this->db->like("P.name",$keyword);
        $this->db->or_like("P.keywords",$keyword);
        $this->db->limit(4);
        $query = $this->db->get();
        $products = $query->result();
        
        $result = [];
        foreach($cats as $cat){
            $result[] = [
                "type" => "category",
                "name" => $cat->name,
                "cat_id" => $cat->id,
                "parent_id" => $cat->parent_id,
                "parent_name" => $cat->parent_name,
            ];
        }
        
        foreach ($products as $product){
            $result[] = [
                "type" => "product",
                "name" => $product->name,
                "id" => $product->id,
                "cat_id" => $product->parent_id,
                "parent_name" => $product->parent_name,
            ];
        }
        echo json_encode($result);

//        $result = $this->Categories_model->getSearch($keyword);
//        foreach ($result as $row) {
//            $arr[] = array(
//                'id' => $row['id'],
//                'label' => $row['categories_name'],
//                'value' => $row['categories_name']
//            );
//        }
//        echo json_encode($arr);
    }

    public function search_product() {
        $this->form_validation->set_rules("keyword", "Product Name", "required");
        $data = $this->get_header_data->get_categories();
        if ($this->form_validation->run() === false) {
            redirect('welcome');
        } else {
            $keyword = htmlentities($this->input->post('keyword'));
            $cat_id = htmlentities($this->input->post('cat_id'));
            $type = htmlentities($this->input->post('type'));
//            $parent_id = htmlentities($this->input->post('parent_id'));
            $min_order = $this->input->post('min_order');
            $min_price = $this->input->post('min_price');
            $max_price = $this->input->post('max_price');
            $sortby    = $this->input->post('sortby');

            if ($type == "category") {
                $data["search_by"] = "category";
                $catids = $this->Categories_model->getParentsByChild($cat_id);
                $ids = (array) $catids;
               
                foreach (array_values($ids) as $row) {
                    if (empty($row)) {
                        unset($row);
                    } else if ($row != 1) {
                        $catagories[] = $this->Categories_model->get_categoryName($row);
                    }
                }
                $data['catames'] = array_reverse($catagories);
                $data['cat_details'] = $this->Categories_model->getCategoryById($cat_id);
                $data["description"] = $data['cat_details']->seo_description;
                $data["keywords"] = $data['cat_details']->seo_keywords;
                $data["title"] = $data['cat_details']->seo_title;
                $page = 0;
                $perpage = 12;
                $categories = $this->Categories_model->getImidiateChildCategories($cat_id);
                if ($categories) {
                    foreach ($categories as $categoryIds) {
                        $catIDs[] = $categoryIds->category_id;
                        $subCatDropdown[] = array(
                            "cat_id" => $categoryIds->category_id,
                            "cat_name" => $categoryIds->categories_name,
                        );
                    }
                    array_unshift($catIDs, $cat_id);
                } else {
                    $catIDs = $cat_id;
                }
                $data['products'] = $this->Product_model->getProductsdetailsByCategory($catIDs, $page, $perpage,$min_order, $min_price, $max_price,$sortby);
                $data['productsCnt'] = $this->Product_model->getProductsdetailsByCategoryCount($catIDs, $min_order, $min_price, $max_price);
                $data['cat_dropdown'] = $subCatDropdown;

                $root = $this->Categories_model->getRootCategories();
                $allCategories = array();
                foreach ($root as $rt) {
                    $cats = $this->Categories_model->get_categories_by_parent($rt->category_id);
                    $allCategories[] = array(
                        "id" => $rt->category_id,
                        "title" => $rt->categories_name,
                        "image" => $rt->categories_image,
                        "elements" => $cats,
                    );
                }

                $data['root_categories'] = array_reverse($root);
                $data['all_categories'] = array_reverse($allCategories);
            } else {

                $data["title"] = "atzcart - Search results";
                $data["search_by"] = "keyword";
                $data["keyword"] = $keyword;
                if($cat_id != '')
                {
                    $productlists = $this->Product_model->getProductsByCategoryAndTerm($cat_id,0,6,"","","","",$keyword);
                    $data['productsCnt'] = $this->Product_model->getProductsByCategoryAndTermCount($cat_id,"","","",$keyword);
                    echo $data['productsCnt'];
                }else{
                    $productlists = $this->Product_model->getSerachProductByKeyword($keyword, 0, 12);
                    $data['productsCnt'] = $this->Product_model->getSerachProductByKeywordCount($keyword);
                }
                
                $returnOfferProductList=$this->Offer_model->appliedOfferProduct2($productlists); 
                $data['products'] = $returnOfferProductList;
//                $data['products'] = $this->Product_model->getSerachProductByKeyword($keyword, 0, 12);
            }
            
            $data["title"] = "atzcart - Search results";
            $this->load->view("front/product/search_result", $data);
        }
    }

    public function gold_supplier() {
        $this->load->view("front/gold/gold_membership");
    }

    public function becomeseller() {
        $data["pageTitle"] = "The Biggest Ecommerce company";
        $this->load->view("front/seller_intro", $data);
    }

    function calculate_shipping_cost($product_id, $quantity, $user_pincode, $seller_id = 0) {
        $seller_id = $this->session->userdata("user_id");

        $this->load->model("Shipping_model");
        $this->load->model("Common_model");
        //get Existing Data
        $ch_exist = $this->Common_model->getAll('product_details', array('id' => $product_id))->num_rows();
        if ($ch_exist > 0) {
            $ch_pincode = $this->Common_model->getAll('shipping_surface', array('pincode' => $user_pincode))->num_rows();
            if ($ch_exist > 0) {
                $ch_seller = $this->Common_model->getAll('product_details', array('id' => $product_id))->row();


                $product_weight = $ch_seller->weight;
                $product_lenght = $ch_seller->length;
                $product_width = $ch_seller->width;
                $product_height = $ch_seller->height;
                $ship_from = $ch_seller->state;

                $product_rate = $this->Shipping_model->get_qty_wise_product_rate($product_id, $quantity);

                //get Seller Pincode
                $ch_seller_pin = $this->Common_model->getAll('seller_pick_address', array('user_id' => $seller_id))->row();

                if (!empty($ch_seller_pin->pincode)) {
                    $buyer_pin = $user_pincode;
                    $seller_pin = $ch_seller_pin->pincode;
                    /*                     * ****Calculate Shipping Rate************* */
                    //$this->calculate_approx_shipping_rate($pro_id,$buyer_pin,$seller_pin,$quantity);
                    $rate = $this->Shipping_model->get_shipping_rate_approx($seller_pin, $buyer_pin);
                    if ($rate <= 0) {
                        $output["status"] = 0;
                        $output["message"] = "Not Deliverable Region !";
                    } else {
                        $actual_order_price = $product_rate * $quantity;
                        echo "Actutal order price: " . $actual_order_price . "<br />";
                        $total_weight = $product_weight * $quantity;
                        echo "total weight: " . $total_weight . "<br />";
                        /////////////////
                        $price = $total_weight * $rate; //As Weight
                        echo "price: " . $price . "<br />";

                        $size = (($product_height * $product_lenght * $product_width )) / 3600;
                        $size = $size * $quantity;
                        echo "size: " . $size . "<br />";
                        $price2 = $size * $rate; //As Length * width * Height
                        echo "Price2: " . $price2 . "<br />";
                        $Freight = ($price > $price2) ? $price : $price2;
                        ////////////////
                        echo "Fright: " . $Freight . "<br />";


                        $FS = $Freight * (35 / 100); //FS
                        echo "FS: " . $FS . "<br />";

                        $CAF = ($Freight + $FS) * (7.5 / 100); //CAF
                        echo "CAF: " . $CAF . "<br />";
                        $IDC = ($Freight + $FS + $CAF) * (10 / 100); //IDC

                        $AWB = 75; //AWB
                        echo "AWB: " . $AWB . "<br />";
                        $FOV = ($actual_order_price * (0.2 / 100)); //FOV
                        //Sub Total
                        echo "FOV: " . $FOV . "<br />";
                        $sub_total = $Freight + $FS + $CAF + $IDC + $AWB + $VCHC + $FOV;
                        echo "Sub Total: " . $sub_total . "<br />";
                        if (($actual_order_price / $total_weight) > 5000) {
                            $VCHC = $sub_total + $actual_order_price; //VCHC;
                        } else {
                            $VCHC = 0;
                        }

                        //Check 2 pay charge
                        $check2Paycharge = $this->Common_model->getAll('shipping_surface', array('pincode' => $seller_pin))->row_array();

                        $areaCode = $check2Paycharge['area'];


                        if ($areaCode != 'PNQ') {
                            $sub_total = $sub_total + 50; //2 pay charge if out of Pune
                        }

                        $GST = $sub_total * (18 / 100); //GST
                        echo "GST: " . $GST . "<br />";
                        $tot_shipping_rate = round($sub_total + $GST, 2);
                        echo "Total: " . $tot_shipping_rate . "<br />";
                    }
                } else {
                    $output["status"] = 0;
                    $output["message"] = "Not Deliverable Pincode !";
                }
            } else {
                $output["status"] = 0;
                $output["message"] = "Not Deliverable Pincode !";
            }
        } else {
            $output["status"] = 0;
            $output["message"] = "Product Not Found !";
        }
        return $output;
    }

    public function seller_terms() {
        $data = $this->get_header_data->get_categories();
        $data["pageTitle"] = "Terms & Conditions";
        $this->load->view("front/terms", $data);
    }

    public function test() {
//        $json = [
//            "data" => '[{"specifications":{"secondary":[{"spec_id":"7","specification_name":"Size","unit_price":"478.00","quantity":"1","spec_value":"XL","type":"dropdown"}],"unit_price":"478.00","total_quantity":"1","total_price":478,"moq":"1","unit_name":"Pieces"}}]'
//        ];
//
//        /* echo stripslashes(json_encode($json,TRUE));
//          var_dump($json);
//
//          echo "<pre>"; print_r($json); */
//        $x = preg_replace('/\\\\/', '', json_encode($json));
//        echo $x;
        echo password_hash("testpass1#", PASSWORD_DEFAULT);
    }

    public function checkmail() {
        $email_config = Array(
            'protocol' => 'smtp',
            'smtp_host' => 'ssl://smtp.googlemail.com',
            'smtp_port' => '465',
            'smtp_user' => 'bharatgodam@gmail.com',
            'smtp_pass' => '#EvilOverlord#',
            'mailtype' => 'plain/text',
            'starttls' => true,
            'newline' => "\r\n"
        );

        $this->load->library('email', $email_config);
        $this->email->set_newline("\r\n");
        $this->email->from('bharatgodam@gmail.com'); // change it to yours
        $this->email->to('bharatgodam@ayninfotech.com'); // change it to yours
        $this->email->subject('Registration successful');
        $this->email->message("Testing email");
        if ($this->email->send()) {
            // echo 'Email sent.';
        } else {
            show_error($this->email->print_debugger());
        }
    }

    function before_authenticate_order($orders_id) {
        if (!empty($orders_id)) {
            //Check Order Pending and applied with Coupon
            $check_order = $this->Order_model->check_order_with_coupon_applied($orders_id);
            if ($check_order == 0) {
                //Cross Verify Amount and Coupon Validity
                return 0; // all correct
            } elseif ($check_order == 1) {
                return 1; //Coupon Has been Expired ! Make Payment Again.
            } else {
                return 2;
            }
        }
    }

    public function payment_detail($order_id = '') {
        if (!$order_id || $order_id == '') {
            $error = "<div id='login-error' class='form-error notice notice-error'><span class='icon-notice icon-error'></span><span><strong>Error!</strong> Direct script access not allowed.!. </span></div>";
            $this->session->set_flashdata("message", $error);
            redirect("welcome", "refresh");
        } else {
            $user_id = $this->session->userdata("user_id");
            //Get Latest Tracking Status//
            $ord = $this->Common_model->getAll('orders', array('orders_id' => $order_id))->row();

            if ($ord->user_id == $user_id) {

                if ($check == 1) {
                    redirect('userorder/ship_order/' . $order_id);
                }

                $check_order = $this->Order_model->check_accepted_order($order_id);

                if ($check_order->num_rows() > 0) {
                    $order_detail = $check_order->row_array();

                    $pro_id = $order_detail['products_id'];
                    $unit_price = $this->Order_model->get_unit_price($pro_id);
                    $pro_detail = $this->Order_model->get_product_detail($pro_id);

                    $data['res'] = $pro_detail->row_array();
                    $data['order_dtail'] = $order_detail;
                    $data['price_per'] = $unit_price->result_array();

                    $data['quantity'] = $order_detail['products_quantity'];

                    $data['qty_price_per'] = $order_detail['final_price'];

                    $data['productinfo'] = 'Product Description';
                    $data['txnid'] = time();
                    $data['surl'] = site_url() . 'userorder/success';
                    $data['furl'] = site_url() . 'userorder/failed';

                    $data['key_id'] = RAZOR_KEY_ID;
                    $data['currency_code'] = 'INR';
                    $data['total'] = $order_detail['order_price'] * 100;
                    $data['amount'] = $order_detail['order_price'];
                    $data['merchant_order_id'] = $order_id;
                    $data['card_holder_name'] = $order_detail['user_name'];
                    $data['email'] = $this->session->userdata('user_email');
                    $data['phone'] = $this->session->userdata('phone');
                    $data['name'] = 'ATZ Cart';
                    $data['return_url'] = site_url() . 'userorder/callback';


                    if ($order_detail['orders_status'] == '17') {
                        //Rejected
                        $data['pending_order'] = 'Rejected';

                        // redirect('userorder/ship_order/'.$order_id);
                        // $this->load->view('front/order/payment', $data);
                        // $this->load->view('front/common/footer');
                    } elseif ($order_detail['orders_status'] == '8') {

                        $data['productinfo'] = 'Product Description';
                        $data['txnid'] = time();
                        $data['surl'] = site_url() . 'userorder/success';
                        $data['furl'] = site_url() . 'userorder/failed';
                        ;
                        $data['key_id'] = RAZOR_KEY_ID;
                        $data['currency_code'] = 'INR';
                        $data['total'] = $order_detail['order_price'] * 100;
                        $data['amount'] = $order_detail['order_price'];
                        $data['merchant_order_id'] = $order_id;
                        $data['card_holder_name'] = $order_detail['user_name'];
                        $data['email'] = $this->session->userdata('user_email');
                        $data['phone'] = $this->session->userdata('phone');
                        $data['name'] = 'ATZ Cart';
                        $data['return_url'] = site_url() . 'userorder/callback';


                        //Accepted
                        $data['pending_order'] = 'Accepted';
                        //Ship Address

                        $pr_details = $this->Order_model->getOrderDetails($order_id);

                        $data['seller_info'] = $this->Product_model->getSellerInformation($pr_details[0]->seller_id);
                        $data['product_details'] = $pr_details;

                        // $this->load->view('front/order/payment', $data);
                        // redirect('userorder/ship_order/'.$order_id);
                        // $this->load->view('front/common/footer');
                    } else {
                        $msg = '<div class=" clearfix">
                        <div id="notfound">
                           <div class="notfound">
                              <div class="notfound-404">
                                 <h1>Oops!!</h1>
                                 <h2>Error ! Order Not Found !</h2>
                              </div>
                              <a href="' . base_url() . '">Go TO Homepage</a>
                           </div>
                        </div>
                     </div>';
                        $this->session->set_flashdata('message', $msg);
                        redirect(base_url() . "userorder/atz_messgae");
                    }

                    $this->load->view("front/product/payment_detail", $data);
                } else {

                    $msg = '<div class=" clearfix">
                        <div id="notfound">
                           <div class="notfound">
                              <div class="notfound-404">
                                 <h1>Hey!!</h1>
                                 <h2>Somthing Wrong Related to Order..!!</h2>
                              </div>
                              <a href="' . base_url() . '">Go TO Homepage</a>
                           </div>
                        </div>
                     </div>';
                    $this->session->set_flashdata('message', $msg);
                    redirect(base_url() . "userorder/atz_messgae");
                }
            }
        }
    }

    function read_notification($id) {
        $this->load->model("Users_model");
        echo $this->Users_model->update_notification($id);
    }

    function products_offer()
    {
        $data = $this->get_header_data->get_categories();
        $runningOffers = $this->Offer_model->getRunningOffers();
        if(count($data['runningOffers']) == 0){
            $data = $this->get_header_data->get_categories();
            $data['runningOffers'] = $runningOffers;
            $this->load->view("front/product/products_offer", $data);
        } else {
         redirect(base_url('welcome'));   
        }
    }
    
    function autosearch()
    {
        $this->load->view("front/autosearch");
    }
    
    function ajax_autoload($keyword)
    {
        $result = $this->Product_model->getSerachProductByKeyword($keyword,0,12);
        foreach($result as $row){
            $new_array[] = [ "product_name"=>$row["product_name"]];
        }   
       echo json_encode($new_array);
    }

    

}

?>