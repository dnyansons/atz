<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Home_product extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Categories_model');
        $this->load->model('Product_model');
        $this->load->model('Company_model');
        $this->load->model('Myfavourite_model');
        $this->load->model('Rfqs_model');
        $this->load->model('Review_model');
        $this->load->model('Inquiries_model');
        $this->load->helper("url");
        $this->load->library("get_header_data");
        $this->load->library("Send_data");
        $this->load->library("Shiprocket");
        $this->load->model('Common_model');
        $this->load->model('Offer_model');
        $this->load->library("pagination");
        $this->load->library("browser_notification");
        $this->load->library("awsupload");
    }

    public function get_products($product_name, $cat_id, $page = 0) {
        //$this->output->enable_profiler(true);
        $this->load->library('user_agent');
        if ($this->agent->is_mobile()) {
            redirect($this->config->item("mobile_site_url") . "/home/productList/" . $cat_id);
        }
        $data = $this->get_header_data->get_categories();
        $parent_cat = $this->Categories_model->getCategoryById($cat_id);

        $data["description"] = $parent_cat->seo_description;
        $data["keywords"] = $parent_cat->seo_keywords;
        $data["title"] = $parent_cat->seo_title;
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
        $page = 0;
        $perpage = 12;

        $categories = $this->Categories_model->getImidiateChildCategories($cat_id);
        // $categories = array_values(array_unique(explode(",",$cat_id.",".$this->Categories_model->getAllChilds($cat_id))));
        array_unshift($categories, $parent_cat);

        //for Title Start

        if ($parent_cat->seo_title == 'default') {
            $new_title = ' ';
            foreach ($data['catames'] as $sons) {
                $new_title = $new_title . ' ' . $sons['categories_name'];
            }
        } else {
            $new_title = $parent_cat->seo_title;
        }

        //for Title End
        $subCatDropdown = [];
        if ($categories) {
            foreach ($categories as $categoryIds) {
                $catIDs[] = $categoryIds->category_id;
                $subCatDropdown[] = array(
                    "cat_id" => $categoryIds->category_id,
                    "cat_name" => $categoryIds->categories_name,
                );
            }
        } else {
            $catIDs = $cat_id;
        }

        $products = $this->Product_model->getProductsdetailsByCategory($catIDs, $page, $perpage, $min_order = '', $min_price = '', $max_price = '', $sortby = '');
        $data['cat_details'] = $this->Product_model->getAllProductCount($catIDs);
  
        $data['products'] = $products;
        $data['cat_dropdown'] = $subCatDropdown;
        $data['title'] = $new_title . ' | ATZCart';

        //for Title End 

        /*         * *********** Set cookie ************* */
        $old_cookie_str = get_cookie("intesested_categories");
        $old_cookie_arr = array_unique(explode(",", $old_cookie_str));
        $new_cookie_str = "$cat_id";
        if (!in_array($cat_id, $old_cookie_arr)) {
            if (count($old_cookie_arr) >= 10) {
                array_shift($old_cookie_arr);
            }
            array_push($old_cookie_arr, $cat_id);
            $new_cookie_str = implode(",", array_unique($old_cookie_arr));
        }

        $cookie = [
            "name" => "intesested_categories",
            "value" => $new_cookie_str,
            "expire" => 6000,
            "path" => "/",
            "prefix" => "",
            "secure" => false,
            "httponly" => false,
        ];
        $this->input->set_cookie($cookie);
        $data["ccat_id"] = $cat_id;

        /*         * *************** end **************** */
        $this->load->view("front/product/product_catalog", $data);
    }

    public function get_Product_details($product_name, $product_id) {
        $this->load->library('user_agent');
        if ($this->agent->is_mobile()) {
            redirect($this->config->item("mobile_site_url") . "/product/productOverview/" . $product_id);
        }

        $data = $this->get_header_data->get_categories();
        $data["title"] = "ATZCart - Product Details";
        $user_id = $this->session->userdata('user_id');
        $products_details = $this->Product_model->getProductfullDetails($product_id);
        if ($products_details) {
            $coupons = $this->Product_model->getProductCoupens_web($product_id, $user_id);
            $result = array_filter($coupons, function ($val) {
                if ($val->check_coupon_id == '') {
                    return true;
                }
            });

            $data['coupons'] = $result;

            $interested_categories = get_cookie("intesested_categories");
            if ($interested_categories != NULL) {
                $catsi = explode(",", $interested_categories);
                $res = "";
                foreach ($catsi as $cati) {
                    $res = $res . $cati . "," . $this->Categories_model->getAllChilds($cati) . ",";
                }
                $ctcats = array_unique(explode(",", trim($res, ",")));
                $related_product = $this->Product_model->getProductByCatIds($ctcats, 10);
            } else {
                $related_product = $this->Product_model->getProductList(0, 10);
            }

            foreach ($related_product as $products) {
                if (strtolower($products->offer_status) == 'active') {
                    $offerRunningStatus = $this->Offer_model
                            ->checkOfferValidity(
                            $products->offer_start_time, $products->offer_end_time, $products->offer_status);
                    if ($offerRunningStatus == true) {
                        //$products->mrp = $products->final_price1;
                        if (strtolower($products->offer_type) == 'flat') {
                            $products->discount = '<i class="fa fa-inr"></i> ' . $products->offer_discount_value . ' Off';
                            $products->final_price1 = $products->mrp - $products->offer_discount_value;
                            $products->final_price2 = $products->mrp - $products->offer_discount_value;
                        }
                        if (strtolower($products->offer_type) == 'percentage') {
                            $products->discount = $products->offer_discount_value . ' % Off';
                            $products->final_price1 = $products->mrp - ($products->mrp * $products->offer_discount_value * 0.01);
                            $products->final_price2 = $products->mrp - ($products->mrp * $products->offer_discount_value * 0.01);
                        }
                    }
                } else {
                    if ($products->discount != 0) {
                        $products->discount = $products->discount . ' % Off';
                    }
                }
            }

            $data['related_product'] = $related_product;

            $data['products_attribute'] = $products_details['product_attributes'];
            $data['product_specification'] = $products_details['product_specification'];

            $seller = $products_details["seller"];
            $product_prices = $products_details['product_prices'];
            //$data['product_prices'] = $products_details['product_prices'];
            $data['product'] = $products_details;

            $offerRunningStatus = $this->Offer_model->checkOfferValidity(
                    $data['product']['offer_start_time'], $data['product']['offer_end_time'], $data['product']['offer_status']);
            if ($offerRunningStatus == true) {
                for ($i = 0; $i < count($product_prices); $i++) {
                    //$product_prices[$i]['mrp'] = $product_prices[$i]['final_price'];
                    if (strtolower($data['product']['offer_type']) == 'flat') {
                        $data['product']['discount'] = '<i class="fa fa-inr"></i> ' . $data['product']['offer_discount_value'] . ' Off';
                        $product_prices[$i]['final_price'] = $product_prices[$i]['mrp'] - $data['product']['offer_discount_value'];
                    }
                    if (strtolower($data['product']['offer_type']) == 'percentage') {
                        $data['product']['discount'] = $data['product']['offer_discount_value'] . ' % Off';
                        $product_prices[$i]['final_price'] = $product_prices[$i]['mrp'] - ($product_prices[$i]['mrp'] * $data['product']['offer_discount_value'] * 0.01);
                    }
                    $data['product_prices'] = $product_prices;
                }
            } else {
                $data['product_prices'] = $products_details['product_prices'];
                $data['product']['discount'] = $data['product']['discount'] . ' % Off';
            }

            $data['available_quantity'] = $products_details['available_quantity'];

            $data['company'] = $this->Company_model->getCompanyDetailsBySeller($seller);
            $reviews = $this->Review_model->get_reviews($product_id);
            if ($reviews) {
                foreach ($reviews as $row) {
                    $sum += $row['reviews_rating'];
                }
                $data['ratings'] = $sum / count($reviews);
                $data['reviews_count'] = count($reviews);
            } else {
                $data['ratings'] = 0;
                $data['reviews_count'] = 0;
            }
            //New Title
            $data["title"] = $products_details['name'] . " | Online at Best Prices | ATZCart";
            $data["notify_status"] = $this->check_duplicate_notify_buyer($product_id); //iff 1 means user is alredy register for notify me
            $this->load->view("front/product/product_detail", $data);
        } else {
            $this->load->view("front/product/opps", $data);
        }
    }

    public function get_all_products_categorywise($cat_name, $cat_id) {
        $this->load->library('user_agent');
        if ($this->agent->is_mobile()) {
            redirect($this->config->item("mobile_site_url") . "/home/productList/" . $cat_id);
        }
        $data = $this->get_header_data->get_categories();
        $parent_cat = $this->Categories_model->getCategoryById($cat_id);

        $data["description"] = $parent_cat->seo_description;
        $data["keywords"] = $parent_cat->seo_keywords;
        $data["title"] = $parent_cat->seo_title;

        $data['main_category'] = array(
            "id" => $parent_cat->category_id,
            "title" => $parent_cat->categories_name,
            "image" => $parent_cat->categories_image,
            "banner_image" => $parent_cat->banner_image,
        );

        $child_cats = $this->Categories_model->getImidiateChildCategories($cat_id);
        array_unshift($child_cats, $parent_cat);
        foreach ($child_cats as $child_cat):
            $res = $child_cat->category_id . "," . $this->Categories_model->getAllChilds($child_cat->category_id);
            $catIds = array_filter(explode(",", $res));
            $child_cat->products = $this->Product_model->getProductListByCategrories($catIds, 0, 12);
            $child_cat->sub = $this->Categories_model->getImidiateChildCategories($child_cat->category_id, 20);
        endforeach;
        $data["child_cats"] = $child_cats;
        $this->load->view("front/product/product_new", $data);
    }

    public function add_to_favorite() {
        if ($this->session->userdata('user_role') == 'seller') {
            $this->session->sess_destroy();
            $this->session->set_flashdata("message", '<div class="alert alert-danger">Please Login as Buyer. </div>');
            redirect('login');
        }
        $user_id = $this->session->userdata('user_id');
        if ($user_id) {
            $product_id = $this->input->post('product_id');
            $result = $this->Common_model->getAll('buyer_favourites', array('user_id' => $user_id))->num_rows();
            if ($result > 0) {
                $get_exist = $this->Common_model->getAll('buyer_favourites', array('user_id' => $user_id))->row_array();
                $exist_product = json_decode($get_exist['products']);
                if (in_array($product_id, $exist_product)) {
                    $output["status"] = 1;
                    $output["message"] = "Already Added In Favourite !";
                    echo json_encode($output);
                } else {
                    array_push($exist_product, $product_id);
                    $insertdata['products'] = json_encode($exist_product, JSON_NUMERIC_CHECK);
                    $this->Common_model->update("buyer_favourites", $insertdata, array('user_id' => $user_id));
                    $this->session->set_userdata('faverite_products', $exist_product);

                    $output["status"] = 2;
                    echo json_encode($output);
                }
            } else {

                $arr = array($product_id);
                $this->session->set_userdata('faverite_products', $arr);
                $insertdata['user_id'] = $user_id;
                $insertdata['products'] = json_encode($arr);
                $insertdata['suppliers'] = json_encode(array());
                $insertdata['created_at'] = date('Y-m-d H:i:s');
                $this->Common_model->insert("buyer_favourites", $insertdata, array('user_id' => $this->_payload->userid));
                $output["status"] = 2;
                $output["debug"] = "IN ELSE";
                echo json_encode($output);
            }
        } else {
            $output["status"] = 0;
            echo json_encode($output);
        }
    }

    /* Working On Favourite Product */

    public function favouriteProduct() {
        $data = $this->get_header_data->get_categories();
        $user_id = $this->session->userdata("user_id");
        $user_role = $this->session->userdata("user_role");
        if (!empty($user_id) && $user_role == 'buyer') {
            $user_products = array();
            $data = $this->Myfavourite_model->getUsersFavouritesProducts($user_id);
            $products = json_decode($data['products']);
            $suppliers = json_decode($data['suppliers']);

            for ($i = 0; $i < count($products); $i++) {

                $favouriteProduct = $this->Product_model->getfavProductDetails($products[$i]);
                $arrayOffers['offer_status'] = $favouriteProduct['offer_status'];
                $arrayOffers['offer_start_time'] = $favouriteProduct['offer_start_time'];
                $arrayOffers['offer_end_time'] = $favouriteProduct['offer_end_time'];
                $arrayOffers['offer_type'] = $favouriteProduct['offer_type'];
                $arrayOffers['offerPrice'] = $favouriteProduct['mrp'];
                $arrayOffers['offer_discount_value'] = $favouriteProduct['offer_discount_value'];

                $offersData = $this->Offer_model->calculateOfferPrice($arrayOffers);

                if ($offersData != false) {
                    $favouriteProduct['max_final_price'] = $offersData['offerPrice'];
                    $favouriteProduct['discount'] = $this->Offer_model->
                            offerDiscount($favouriteProduct['offer_type'], $offersData['offer_discount_value']);
                } else {
                    $favouriteProduct['discount'] .= ' % Off';
                }

                $favorite_prod[] = $favouriteProduct;
            }

            for ($i = 0; $i < count($suppliers); $i++) {

                $this->db->select('u.*,s.company_name,s.location_country,s.comp_operational_city,s.year_of_register,s.logo');
                $this->db->from('users u');
                $this->db->join('seller_company_details s', 's.user_id = u.id');
                $this->db->where('u.id', $suppliers[$i]);
                $query = $this->db->get();
                $sellers_products[$i]['sellers'] = $query->row_array();
            }

            $data = $this->get_header_data->get_categories();
            $data["title"] = "ATZCart - Favorite Products ";

            $data['user_products'] = array_reverse($favorite_prod);
            $data['sellers_products'] = $sellers_products;
            $this->load->view("front/product/favourite_view", $data);
        } else {
            redirect("login", "refresh");
        }
    }

    public function removefavouriteProduct($id) {
        $user_id = $this->session->userdata("user_id");
        $result = $this->Myfavourite_model->deletefavoriteproduct($user_id, $id);
        $remove_msg = "<div class='alert alert-danger alert-dismissible'>
                <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                Item has removed from favorite!!.
            </div>";
        $this->session->set_flashdata("success_msg", $remove_msg);
        redirect("home_product/favouriteProduct");
    }

    public function deletefavoriteseller($id) {
        $user_id = $this->session->userdata("user_id");
        $result = $this->Myfavourite_model->deletefavoriteseller($user_id, $id);
        $remove_msg = "<div class='alert alert-danger alert-dismissible'>
                <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                <strong>Success!</strong>Removed!!.
            </div>";
        $this->session->set_flashdata("success_msg", $remove_msg);
        redirect("home_product/favouriteProduct");
    }

    public function product_inquiry($product_id) {

        $this->load->library("form_validation");
        $this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>');
        $this->form_validation->set_rules("unit", "Unit", "required");
        $this->form_validation->set_rules("quantity", "Quantity", "required");
        $this->form_validation->set_rules("product_description", "Product Description", "required");
        if ($this->form_validation->run() === false) {

            $user_id = $this->session->userdata('user_id');
            if ($user_id) {
                $data = $this->get_header_data->get_categories();
                $data["title"] = "ATZCart - Product Enquiry";

                $data['product'] = $this->Product_model->getProductfullDetails($product_id);
                $data['units'] = $this->Rfqs_model->get_units();
                $this->load->view("front/product/product_inquiry", $data);
            } else {
                redirect('login');
            }
        } else {
     
            $user_id = $this->session->userdata('user_id');
            $s3FilePath = $this->awsupload->upload("userFiles", "uploads/inquiries_attachment", 'image');
            
             if ($_FILES['userFiles']['name'] != '' || !empty($_FILES['userFiles']['name'])) {
                    $s3FilePath = $this->awsupload->upload('userFiles', 'uploads/inquiries_attachment','image');
                    if($s3FilePath == false){
                        $error = "<div class='alert alert-danger alert-dismissible'>
                                <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                                <strong>Error!</strong> File type not allowed | Upload only jpeg|png!
                                </div>";
                        $this->session->set_flashdata("inquiry_message", $error);
                        redirect('home_product/product_inquiry/' . $product_id);
                    }else{
                        $arr['attachments_by_buyer'] = $s3FilePath;
                    }
                } else {
                    $arr['attachments_by_buyer'] = '';
                }
                
            $product = $this->input->post('for_product');
            $arr['by_user'] = $user_id;
            $arr['for_product'] = $product;
            $arr['quantity'] = htmlentities($this->input->post('quantity'));
            $arr['unit'] = $this->input->post('unit');
            $arr['comment'] = htmlentities($this->input->post('product_description'));
            
            $arr['is_forwarded'] = 0;
            $arr['status'] = 'Pending';

            $result = $this->Inquiries_model->addEnquiry($arr);
            $msg = " From " . $this->session->userdata('user_name') . " on date " . $todays_date;
            $tag = 'atzcart.com';

            $this->browser_notification->notifyadmin('New Inquiry !', $msg, $tag);
            $adminNotify = array(
                'title' => 'New Inquiry',
                'msg' => $msg . ' ( Web ) ',
                'type' => 'Inquiry',
                'reference_id' => $user_id,
                'status' => 'Received'
            );
            $insertAdminNotify = $this->Product_model->insertAdminNotify($adminNotify);

            $success = "<div class='alert alert-success alert-dismissible'>
                                             <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                                             <strong>Success!</strong> Inquiry added successfully!!.
                                       </div>";
            $this->session->set_flashdata("inquiry_message", $success);
            redirect('home_product/product_inquiry/' . $product_id);

        }
    }

    public function add_to_cart() {
        if ($this->session->userdata('user_role') == 'seller') {
            $this->session->sess_destroy();
            $this->session->set_flashdata("message", '<div class="alert alert-danger">Please Login as Buyer. </div>');
            redirect('login');
        }
        $user_id = $this->session->userdata('user_id');
        if ($user_id) {
            $product_id = $this->input->post('product_id');
            $arr['user_id'] = $user_id;
            $t_quantity = $this->input->post('t_quantity');
            $offer_id = $this->input->post('offer_id');
            $arr['product_total_quantity']= $t_quantity;

            $products_detail = $this->Product_model->getProductfullDetails($product_id);

            $arr['product_id'] = $product_id;
            $arr['offer_id'] = $offer_id;
            $arr['product_name'] = $products_detail['name'];
            $arr['product_image'] = $products_detail['images'][0];


            $arr['supplierDetails'] = $products_detail['first_name'] . ' ' . $products_detail['last_name'] . ' ' . $products_detail['company_name'];
            $arr['seller_id'] = $products_detail['seller'];

            $productPrice = $this->Product_model->getProductPriceForQuantity($product_id, $t_quantity);

            $offerRunningStatus = $this->Offer_model
                    ->checkOfferValidity(
                    $products_detail['offer_start_time'], $products_detail['offer_end_time'], $products_detail['offer_status']);
            if ($offerRunningStatus == true) {
                if (strtolower($products_detail['offer_type']) == 'flat') {
                    $productPrice->final_price = $productPrice->atz_price - $products_detail['offer_discount_value'];
                }
                if (strtolower($products_detail['offer_type']) == 'percentage') {
                    $productPrice->final_price = $productPrice->atz_price - ($productPrice->atz_price * $products_detail['offer_discount_value'] * 0.01);
                }
            }

            $unit_price = $productPrice->final_price;

            $specifications = $this->input->post('tempList');
            for ($i = 0; $i < count($specifications); $i++) {
                $specifications[$i]['specifications']['unit_price'] = $unit_price;
                $specifications[$i]['specifications']['total_quantity'] = $t_quantity;
            }
            
            $arr['specifications'] = json_encode($specifications);
            
            $result = $this->Product_model->add_to_cart($arr);
            if ($result) {
                $output = ['status' => 1];
                return $this->output->set_output(json_encode($output));
            }
        } else {
            $output = ['status' => 0];
            return $this->output->set_output(json_encode($output));
        }
    }

    public function get_addedCartProducts() {
        $user_id = $this->session->userdata('user_id');
        $res = $this->Product_model->getCartProducts($user_id);
        echo json_encode($res);
    }

    public function getCartProducts() {
        $data["title"] = "ATZCart - Cart Products";

        $data = $this->get_header_data->get_categories();
        $user_id = $this->session->userdata('user_id');
        $result = $this->Product_model->getCartProducts($user_id);
        foreach ($result as $row) {
            $groupBySellerProduct[$row['seller_id']][] = $row;
            $specification = json_decode($row['specifications']);
            $totalQty = $specification[0]->specifications->total_quantity;
            $productData[] = $this->Product_model->getProductData($row['product_id'],
                    $row['offer_id'], $totalQty);
           // $data[]['supplier_data'] = $this->Product_model->getSupplierInfo($row['seller_id']);
        }

        $data['cart_product'] = $groupBySellerProduct;
        $data['product_data'] = $productData;
        //$data['supplier_data'] = $this->Product_model->getSupplierInfo();
        
        $this->load->view('front/product/cart', $data);
    }

    public function removeCart($id) {
        $user_id = $this->session->userdata('user_id');
        $result = $this->Product_model->removeCart($user_id, $id);
        $success_msg = "<div class='alert alert-danger alert-dismissible'>
                <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                <strong>Success!</strong> Item has been Successfully Removed from Cart !!.
            </div>";
        $this->session->set_flashdata("success_msg", $success_msg);
        redirect('home_product/getCartProducts');
    }

    public function filterProduct() {
        $min_order = $this->input->post('min_order');
        $min_price = $this->input->post('min_price');
        $max_price = $this->input->post('max_price');
        $cat_id = $this->input->post('cat_id');
        $sortby = $this->input->post('sortby');

        $categories = array_values(array_unique(explode(",", $cat_id . "," . $this->Categories_model->getAllChilds($cat_id))));

        $products = $this->Product_model->get_filterdProducts($categories, $min_order, $min_price, $max_price, $sortby);
        $offer_products = array();
        foreach ($products as $product) {
            $arrayOfferPrice['offer_status'] = $product['offer_status'];
            $arrayOfferPrice['offer_type'] = $product['offer_type'];
            $arrayOfferPrice['offer_discount_value'] = $product['offer_discount_value'];
            $arrayOfferPrice['offer_start_time'] = $product['offer_start_time'];
            $arrayOfferPrice['offer_end_time'] = $product['offer_end_time'];
            //apply discount on mrp if offer is on
            $arrayOfferPrice['offerPrice'] = $product['mrp'];
            $offerData = $this->Offer_model->calculateOfferPrice($arrayOfferPrice);
            if ($offerData != false) {
//                $product['final_price2'] = $offerData['offerPrice'];
                $product['final_price1'] = $offerData['offerPrice'];
                $product['discount'] = $offerData['offer_discount_value'];
            }
            $product['final_price'] = 100;
            $offer_products[] = $product;
        }
        echo json_encode($offer_products);
    }

    public function getAjaxfilteredProducts() {
        //$this->output->enable_profiler(true);
        $output = [
            "status" => 0,
            "items" => [],
        ];
        $this->form_validation->set_rules("category", "Category", "required");
        $this->form_validation->set_rules("page", "page", "required");
        if ($this->form_validation->run() === false) {
            
        } else {
            $category = $this->input->post("category");
            $page = $this->input->post("page");
            $min_order = $this->input->post('min_order');
            $min_price = $this->input->post('min_price');
            $max_price = $this->input->post('price_from');
            $sortby = $this->input->post('sortby');

            $perpage = 12;
            $start = ceil($page * $perpage);
//          $categories = array_values(array_unique(explode(",",$category.",".$this->Categories_model->getAllChilds($category))));
            $categories = $this->Categories_model->getImidiateChildCategories($category);
            if ($categories) {
                foreach ($categories as $categoryIds) {
                    $catIDs[] = $categoryIds->category_id;
                }
                array_unshift($catIDs, $category);
            } else {
                $catIDs = $category;
            }

            $products = $this->Product_model->getProductsdetailsByCategory($catIDs, $start, $perpage, $min_order, $min_price, $max_price, $sortby);
            $offer_products = array();
            foreach ($products as $product) {
                $arrayOfferPrice['offer_status'] = $product['offer_status'];
                $arrayOfferPrice['offer_type'] = $product['offer_type'];
                $arrayOfferPrice['offer_discount_value'] = $product['offer_discount_value'];
                $arrayOfferPrice['offer_start_time'] = $product['offer_start_time'];
                $arrayOfferPrice['offer_end_time'] = $product['offer_end_time'];
                //apply discount on mrp if offer is on
                $arrayOfferPrice['offerPrice'] = $product['mrp'];
                $offerData = $this->Offer_model->calculateOfferPrice($arrayOfferPrice);
                if ($offerData != false) {
                    $product['final_price2'] = $offerData['offerPrice'];
                    $product['discount'] = $offerData['offer_discount_value'];
                }
                $offer_products[] = $product;
            }

            if ($products) {
                $output["status"] = 1;
                $output["items"] = $offer_products;
                $output["todaysDate"] = date('Y-m-d H:i:s');
            }
        }
        echo json_encode($output);
    }

    public function getAjaxfilteredProductsbykeyword() {
        $output = [
            "status" => 0,
            "items" => [],
        ];
        $this->form_validation->set_rules("keyword", "keyword", "required");
        $this->form_validation->set_rules("page", "page", "required");
        if ($this->form_validation->run() === false) {
            
        } else {
            $keyword = $this->input->post("keyword");
            $page = $this->input->post("page");
            $perpage = 12;
            $start = ceil($page * $perpage) + 1;
            //$products = $this->Product_model->getSerachProductByname($keyword, $start, $perpage);
            $products = $this->Product_model->getSerachProductByKeyword($keyword, $start, $perpage);
            if ($products) {
                $output["status"] = 1;
                $output["items"] = $products;
            }
        }
        echo json_encode($output);
    }

    public function check_pincode() {

        //get Shipping Method
        $pincode = $this->input->post('pincode');
        $seller_id = $this->input->post('sell_id');
        $ship_method = $this->send_data->get_shipping_method();
        if ($ship_method == 2) {
            if (strlen($pincode) == 6) {
                $paddress = $this->Common_model->getAll('seller_pick_address', array('user_id' => $seller_id))->row_array();
                $seller_pincode = $paddress['pincode'];
                if(empty($seller_pincode))
                {
                    $seller_pincode=411057;
                }
                $res = $this->shiprocket->serviceability($seller_pincode, $pincode, 1, 0.5, 0.5, 0.5, 1);
                
                if ($res['status'] == 200) {
                    $result = 1;
                } else {
                    $result = 0;
                }
                echo $result;
            }
        } else {
            $this->load->library("Shipping");

            if (strlen($pincode) == 6) {
                $result = $this->shipping->location_finder($pincode);
                $edl_dist = $result['GetServicesforPincodeResult']['EDLDist'];
                $area_code = $result['GetServicesforPincodeResult']['AreaCode'];
                if ($edl_dist == 0 && $area_code != '') {
                    $result = 1;
                } else {
                    $result = 0;
                }
                echo $result;
            }
        }
    }

    /**
     * @auther Yogesh Pardeshi
     * @input takes post data for product id and from session user id
     * echo 1 if user is added to Table else nothing on failure
     */
    public function add_notify_buyer() {
        if ($this->session->has_userdata('user_id')) {
            $inserted = 0;
            $product_id = $this->input->post('product_id');
            $buyer_id = $this->session->user_id;
            $checkDuplicate = $this->db->select('id')->from('product_notify_list')
                            ->where(array('product_id' => $product_id, 'user_id' => $buyer_id))
                            ->where('date_user_notified is null')
                            ->get()->result_array()[0];
            if ($checkDuplicate['id'] > 0) {
                echo "2"; //ajaxresponse
            } else {
                $inserted = $this->db->insert('product_notify_list', array('product_id' => $product_id, 'user_id' => $buyer_id));
                echo $inserted; //ajaxresponse
            }
        } else {
            echo 'Invalid Access!';
        }
    }

    /**
     * @auther Yogesh Pardeshi
     * checks whether user is added in product notify list
     * @param GET product id and from session user id
     * @return true if user found in table else false
     */
    private function check_duplicate_notify_buyer($product_id) {
        if ($this->session->has_userdata('user_id')) {
            $buyer_id = $this->session->user_id;
            $duplicate_user = $this->db->select('count(id) as duplicate')
                            ->from('product_notify_list')
                            ->where(array('product_id' => $product_id, 'user_id' => $buyer_id))
                            ->where('date_user_notified IS NULL')
                            ->get()->result_array()[0]['duplicate'];
            if ($duplicate_user == 1) {
                return 1;
            } else {
                return 0;
            }
        } else {
            return 'Invalid Access!';
        }
    }

}
