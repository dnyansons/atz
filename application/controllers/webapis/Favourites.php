<?php

defined('BASEPATH') OR exit('No direct script access allowed');

use Firebase\JWT\JWT;

class Favourites extends REST_Controller {

    private $_payload;

    public function __construct($config = 'rest') {
        parent::__construct($config);
        $token = $this->input->get_request_header('Token');
        try {
            $this->_payload = JWT::decode($token, $this->config->item('jwt_secret_key'), array('HS256'));
        } catch (Exception $ex) {
            $output = array("status" => 0, "message" => $ex->getMessage());
            $this->response($output, REST_Controller::HTTP_UNAUTHORIZED);
        }

        $this->load->library('form_validation');
        $this->load->model('Users_model');
        $this->load->model('Myfavourite_model');
        $this->load->model('Common_model');
        $this->load->model('Company_model');
        $this->load->model('Product_model');
        $this->load->model('Mylikes_model');
        $this->load->model('Offer_model');
        $this->load->model('Categories_model');
    }

    public function fav_products_get() {
        $output = [
            "ws" => fav_products,
            "status" => 0,
            "message" => "Unable to fetch Favourite details",
            "data" => []
        ];

        if (!empty($this->_payload->userid)) {
        $fav_products = $this->Myfavourite_model->ws_favourite_product($this->_payload->userid);

            for ($i = 0; $i < count($fav_products); $i++) {
                $fav_products[$i]['logo'] = $fav_products[$i]['logo'];
                $fav_products[$i]['membership_icon'] = $fav_products[$i]['user_package'];
                $fav_products[$i]["minisite_url"] = site_url() . "company-details/" . str_replace(' ', '%20', $fav_products[$i]['company_name']);
                
                $arrayOfferPrice['offer_status'] = $fav_products[$i]['offer_status'];
                $arrayOfferPrice['offer_type'] = $fav_products[$i]['offer_type'];
                $arrayOfferPrice['offer_discount_value'] = $fav_products[$i]['offer_discount_value'];
                $arrayOfferPrice['offer_start_time'] = $fav_products[$i]['offer_start_time'];
                $arrayOfferPrice['offer_end_time'] = $fav_products[$i]['offer_end_time'];

                //apply discount on mrp if offer is on
                $arrayOfferPrice['offerPrice'] = $fav_products[$i]['mrp'];
                $offerData = $this->Offer_model->calculateOfferPrice($arrayOfferPrice);

                if ($offerData != false) {
                    $fav_products[$i]['final_price1'] = $offerData['offerPrice'];
                    $fav_products[$i]['discount'] = $offerData['offer_discount_value'];
                }
            }

            $output["data"] = $fav_products;
            $output["status"] = 1;
            $output["message"] = "Favourite Product data fetch successfully";
            $this->response($output, REST_Controller::HTTP_OK);
        } else {
            $this->response($output, REST_Controller::HTTP_OK);
        }
    }

    public function fav_supplier_get() {
        $output = [
            "ws" => fav_supplier,
            "status" => 0,
            "message" => "Unable to fetch Favourite details",
            "data" => []
        ];



        if (!empty($this->_payload->userid)) {


            $fav_supplier = $this->Myfavourite_model->ws_favourite_supplier($this->_payload->userid);

            //print_r($fav_supplier);exit;

            for ($i = 0; $i < count($fav_supplier); $i++) {
                $fav_supplier[$i]['logo'] = $fav_supplier[$i]['logo'];
                $fav_supplier[$i]['membership_icon'] = $fav_supplier[$i]['user_package'];
                $fav_supplier[$i]["minisite_url"] = site_url() . "company-details/" . str_replace(' ', '%20', $fav_supplier[$i]['company_name']);
            }

            $output["data"] = $fav_supplier;
            $output["status"] = 1;
            $output["message"] = "Favourite Supplier data fetch successfully";

            $this->response($output, REST_Controller::HTTP_OK);
        } else {
            $this->response($output, REST_Controller::HTTP_OK);
        }
    }

    function add_favourite_post() {
        $ws_temp = $this->post("ws");
        $ws = "add_favourite";
        if (isset($ws_temp)) {
            $ws = $ws_temp;
        }
        $output = [
            "status" => 0,
            "message" => "Invalid Inputs",
            "ws" => $ws
        ];

        $this->form_validation->set_rules("fav_of", "Favourite of", "required");
        $this->form_validation->set_rules("fav", "favourites", "required");
        if ($this->form_validation->run() === false) {
            $this->response($output, REST_Controller::HTTP_OK);
        } else {
            //Pass Value
            $fav = (int) $this->post('fav');

            //echo "<pre>";
            //print_r($this->input->post());
            //echo "User ID : ". $this->_payload->userid;
            // exit;
            $ch_exist = $this->Common_model->getAll('buyer_favourites', array('user_id' => $this->_payload->userid))->num_rows();
            if ($ch_exist > 0) {
                $get_exist = $this->Common_model->getAll('buyer_favourites', array('user_id' => $this->_payload->userid))->row_array();

                if ($this->post('fav_of') == 'products') {
                    $exist_product = json_decode($get_exist['products']);


                    if (in_array($fav, $exist_product)) {
                        $output["status"] = 1;
                        $output["message"] = "Already Added In Favourite !";
                    } else {

                        array_push($exist_product, $fav);

                        $insertdata['products'] = json_encode($exist_product, JSON_NUMERIC_CHECK);


                        $this->Common_model->update("buyer_favourites", $insertdata, array('user_id' => $this->_payload->userid));


                        $output["status"] = 1;
                        $output["message"] = "Favourite Product Add successfully !";
                    }
                } elseif ($this->post('fav_of') == 'suppliers') {

                    $exist_supp = json_decode($get_exist['suppliers']);


                    if (in_array($fav, $exist_supp)) {
                        $output["status"] = 1;
                        $output["message"] = "Already Added In Favourite !";
                    } else {

                        array_push($exist_supp, $fav);

                        $insertdata['suppliers'] = json_encode($exist_supp, JSON_NUMERIC_CHECK);
                        $this->Common_model->update("buyer_favourites", $insertdata, array('user_id' => $this->_payload->userid));

                        $output["status"] = 1;
                        $output["message"] = "Favourite Supplier Add successfully !";
                    }
                } else {
                    $output["status"] = 0;
                    $output["message"] = "Invalid Pass Favourite Data !";
                }
            } else {

                //If New Product or Supplier
                if ($this->post('fav_of') == 'products') {


                    $arr = array($fav);


                    $insertdata['user_id'] = $this->_payload->userid;
                    $insertdata['products'] = json_encode($arr);
                    $insertdata['suppliers'] = json_encode(array());
                    $insertdata['created_at'] = date('Y-m-d H:i:s');




                    $this->Common_model->insert("buyer_favourites", $insertdata, array('user_id' => $this->_payload->userid));


                    $output["status"] = 1;
                    $output["message"] = "Favourite Product Add successfully !";
                } elseif ($this->post('fav_of') == 'suppliers') {

                    $arr = array($fav);
                    $insertdata['user_id'] = $this->_payload->userid;
                    $insertdata['suppliers'] = json_encode($arr);
                    $insertdata['products'] = json_encode(array());
                    $insertdata['created_at'] = date('Y-m-d H:i:s');


                    $this->Common_model->insert("buyer_favourites", $insertdata, array('user_id' => $this->_payload->userid));





                    $output["status"] = 1;
                    $output["message"] = "Favourite Supplier Add successfully !";
                } else {
                    $output["status"] = 0;
                    $output["message"] = "Invalid Pass Favourite Data !";
                }
            }

            $this->response($output, REST_Controller::HTTP_OK);
        }
    }

    function remove_favourite_post() {
        $ws_temp = $this->post("ws");
        $ws = "remove_favourite";
        if (isset($ws_temp)) {
            $ws = $ws_temp;
        }
        $output = [
            "status" => 0,
            "message" => "Invalid Inputs",
            "ws" => $ws
        ];

        $this->form_validation->set_rules("fav_of", "Favourite of", "required|in_list[products,suppliers]");
        $this->form_validation->set_rules("fav", "favourites", "required");

        if ($this->form_validation->run() === false) {
            $this->response($output, REST_Controller::HTTP_OK);
        } else {
            $from = $this->post("fav_of");
            $ids = json_decode(urldecode($this->post("fav")));
            $user = $this->_payload->userid;
            //echo $user;
            //exit;
            $favourites = $this->Myfavourite_model->getUsersFaveriotes($user);
            if ($from == "products") {

                $fav_products_arr = explode(',', str_replace(array('[', ']'), '', $favourites->products));
                $diff = array_diff($fav_products_arr, $ids);
                $diff_string = implode(',', $diff);
                $update = [
                    "products" => '[' . $diff_string . ']'
                ];
            } else {
                $fav_suppliers_arr = explode(',', str_replace(array('[', ']'), '', $favourites->suppliers));
                $diff = array_diff($fav_suppliers_arr, $ids);
                $diff_string = implode(',', $diff);
                $update = [
                    "suppliers" => '[' . $diff_string . ']'
                ];
            }
            $this->Myfavourite_model->updateFavourite($favourites->id, $update);
            $output["status"] = 1;
            $output["message"] = "Removed successfully";
            $output["debug"] = $update;
            $this->response($output, REST_Controller::HTTP_OK);
        }
    }

    public function followings_get() {

        $output = [
            "ws" => "followings",
            "message" => "followings",
        ];
        $user = $this->_payload->userid;

        $favs = $this->Myfavourite_model->getUsersFaveriotes($user);
        $fav_sellers = $favs->suppliers;
        $sellers = $this->Myfavourite_model->ws_favourite_supplier($user);
        $bd_sellers = json_decode($fav_sellers);


        $likes = $this->Mylikes_model->getUsersLikes($user);
        $liked_sellers = $likes->suppliers;
        $bd2_sellers = json_decode($liked_sellers);

        //print_r($sellers);exit;


        $info = [];
        foreach ($sellers as $seller):
            //echo $seller->slrid;
            $company = $this->Company_model->getCompanyBasicByseller($seller['slrid']);
            $products = $this->Product_model->getProductList($seller['slrid'], 9, 0);
            
            $products_offer = array();
                foreach ($products as $product) {
                    $arrayOfferPrice['offer_status'] = $product->offer_status;
                    $arrayOfferPrice['offer_type'] = $product->offer_type;
                    $arrayOfferPrice['offer_discount_value'] = $product->offer_discount_value;
                    $arrayOfferPrice['offer_start_time'] = $product->offer_start_time;
                    $arrayOfferPrice['offer_end_time'] = $product->offer_end_time;
                    //apply discount on mrp if offer is on
                    $arrayOfferPrice['offerPrice'] = $product->mrp;
                    $offerData = $this->Offer_model->calculateOfferPrice($arrayOfferPrice);
                    
                    if ($offerData != false) {
                        $product->final_price1 = $offerData['offerPrice'];
                        $product->discount = $offerData['offer_discount_value'];
                    }
                    //$products_offer[] = $product;
                }
            
            $info[] = [
                "seller_id" => $seller['slrid'],
                "liked" => in_array($seller['slrid'], $bd2_sellers),
                "followed" => in_array($seller['slrid'], $bd_sellers),
                "company_name" => $company->company_name,
                "logo" => $company->logo,
                "products" => $products
            ];
        endforeach;
        if (count($info) > 0) {
            $output["status"] = 1;
            $output["message"] = "followings";
            $output["data"] = $info;
        } else {
            $output["status"] = 0;
            $output["message"] = "No Data Found!";
        }
        $this->response($output, REST_Controller::HTTP_OK);
    }

    public function discover_post() {

        $user = $this->_payload->userid;
        $output = [
            "status" => 0,
            "ws" => "discover",
           "message" =>"No Data Found!"
        ];
        //$this->form_validation->set_rules("sellers","sellers","required");

        $sellers = $this->post("sellers");

        if (empty($sellers)) {
            $this->response($output, REST_Controller::HTTP_OK);
        } else {


            $page = $this->post('page_no');
            $limit = 30;  // Number of entries to show in a page. 
            // Look for a GET variable page if not found default is 1.   
            if (isset($page)) {
                $pn = $page;
            } else {
                $pn = 1;
            }

            $start_from = ($pn - 1) * $limit;

            $user = $this->_payload->userid;

            $favs = $this->Myfavourite_model->getUsersFaveriotes($user);
            $fav_products = $favs->products;
            $fav_sellers = $favs->suppliers;
            $bd_products = json_decode($fav_products);
            $bd3_sellers = json_decode($fav_sellers);


            $likes = $this->Mylikes_model->getUsersLikes($user);
            $liked_products = $likes->products;
            $liked_sellers = $likes->suppliers;
            $bd2_products = json_decode($liked_products);
            $bd4_sellers = json_decode($liked_sellers);


            /* $favs = $this->Myfavourite_model->getUsersFaveriotes($user);
              $fav_sellers = $favs->suppliers;
              $sellers = $this->post("sellers");
              $bd_sellers = json_decode($fav_sellers);


              $likes = $this->Mylikes_model->getUsersLikes($user);

              $liked_sellers = $likes->suppliers;
              $bd2_sellers = json_decode($liked_sellers); */

            $categories_topics = $this->Categories_model->getRootCategories();

            foreach ($categories_topics as $val) {
                $val->categories_image = $val->categories_image;
            }

            //print_r($bd2_sellers);

            $info = [];
            foreach ($sellers as $seller):
                //echo $seller;
                $company = $this->Company_model->getCompanyBasicByseller($seller);
                //$products=$this->Product_model->getAllProductDetailsBySellers($seller,$start_from,$limit);
                $products = $this->Product_model->getAllProductDetailsBySellers($seller, 0, 9);

                for ($i = 0; $i < count($products); $i++) {

                    $products[$i]['liked'] = empty($likes) == false ? in_array($products[$i]['product_id'], $bd2_products) : false;
                    $products[$i]['followed'] = empty($favs) == false ? in_array($products[$i]['product_id'], $bd_products) : false;
                    
                    $arrayOfferPrice['offer_status'] = $products[$i]['offer_status'];
                    $arrayOfferPrice['offer_type'] = $products[$i]['offer_type'];
                    $arrayOfferPrice['offer_discount_value'] = $products[$i]['offer_discount_value'];
                    $arrayOfferPrice['offer_start_time'] = $products[$i]['offer_start_time'];
                    $arrayOfferPrice['offer_end_time'] = $products[$i]['offer_end_time'];
                    
                    //apply discount on mrp if offer is on
                    $arrayOfferPrice['offerPrice'] = $products[$i]['mrp'];
                    $offerData = $this->Offer_model->calculateOfferPrice($arrayOfferPrice);
                    
                    if ($offerData != false) {
                        $products[$i]['final_price1'] = $offerData['offerPrice'];
                        $products[$i]['discount'] = $offerData['offer_discount_value'];
                    }
                }

                $info[] = [
                    "seller_id" => $seller,
                    "liked" => empty($likes) == false ? in_array($seller, $bd4_sellers) : false,
                    "followed" => empty($favs) == false ? in_array($seller, $bd3_sellers) : false,
                    "company_name" => $company->company_name,
                    "logo" => $company->logo,
                    "products" => $products
                ];
            endforeach;
            if (count($info) > 0) {
                $output["status"] = 1;
                $output["message"] = "Discover seller list";
                $output["data"] = $info;
                $output["categories_topics"] = $categories_topics;
            } else {
                $output["status"] = 0;
                $output["message"] = "No Data Found !";
            }
            $this->response($output, REST_Controller::HTTP_OK);
        }
    }

    public function addLike_post() {
        $ws_temp = $this->post("ws");
        $ws = "addLike";
        if (isset($ws_temp)) {
            $ws = $ws_temp;
        }
        $output = [
            "status" => 0,
            "message" => "Invalid Inputs",
            "ws" => $ws
        ];

        $this->form_validation->set_rules("like_of", "Like of", "required");
        $this->form_validation->set_rules("like", "Like", "required");
        if ($this->form_validation->run() === false) {
            $this->response($output, REST_Controller::HTTP_OK);
        } else {
            //Pass Value
            $like = (int) $this->post('like');

            //get Existing Data
            $ch_exist = $this->Common_model->getAll('buyer_likes', array('user_id' => $this->_payload->userid))->num_rows();
            if ($ch_exist > 0) {


                $get_exist = $this->Common_model->getAll('buyer_likes', array('user_id' => $this->_payload->userid))->row_array();

                if ($this->post('like_of') == 'products') {
                    $exist_product = json_decode($get_exist['products']);


                    if (in_array($like, $exist_product)) {
                        $output["status"] = 1;
                        $output["message"] = "Product Already Liked !";
                    } else {

                        array_push($exist_product, $like);

                        $insertdata['products'] = json_encode($exist_product, JSON_NUMERIC_CHECK);


                        $this->Common_model->update("buyer_likes", $insertdata, array('user_id' => $this->_payload->userid));


                        $output["status"] = 1;
                        $output["message"] = "Product Liked successfully !";
                    }
                } elseif ($this->post('like_of') == 'suppliers') {

                    $exist_supp = json_decode($get_exist['suppliers']);


                    if (in_array($like, $exist_supp)) {
                        $output["status"] = 1;
                        $output["message"] = "Supplier Already Liked !";
                    } else {

                        array_push($exist_supp, $like);

                        $insertdata['suppliers'] = json_encode($exist_supp, JSON_NUMERIC_CHECK);


                        $this->Common_model->update("buyer_likes", $insertdata, array('user_id' => $this->_payload->userid));


                        $output["status"] = 1;
                        $output["message"] = "Supplier Liked successfully !";
                    }
                } else {
                    $output["status"] = 0;
                    $output["message"] = "Invalid Pass Like Data !";
                }
            } else {

                //If New Product or Supplier
                if ($this->post('like_of') == 'products') {

                    $arr = array($like);

                    $insertdata['user_id'] = $this->_payload->userid;
                    $insertdata['products'] = json_encode($arr);
                    $insertdata['suppliers'] = json_encode(array());
                    $insertdata['created_at'] = date('Y-m-d H:i:s');

                    $this->Common_model->insert("buyer_likes", $insertdata, array('user_id' => $this->_payload->userid));

                    $output["status"] = 1;
                    $output["message"] = "Favourite Product Add successfully !";
                } elseif ($this->post('like_of') == 'suppliers') {

                    $arr = array($like);
                    $insertdata['user_id'] = $this->_payload->userid;
                    $insertdata['suppliers'] = json_encode($arr);
                    $insertdata['products'] = json_encode(array());
                    $insertdata['created_at'] = date('Y-m-d H:i:s');


                    $this->Common_model->insert("buyer_likes", $insertdata, array('user_id' => $this->_payload->userid));


                    $output["status"] = 1;
                    $output["message"] = "Supplier liked successfully !";
                } else {
                    $output["status"] = 0;
                    $output["message"] = "Invalid Pass liked Data !";
                }
            }

            $this->response($output, REST_Controller::HTTP_OK);
        }
    }

    public function DisLike_post() {
        $ws_temp = $this->post("ws");
        $ws = "DisLike";
        if (isset($ws_temp)) {
            $ws = $ws_temp;
        }
        $output = [
            "status" => 0,
            "message" => "Invalid Inputs",
            "ws" => $ws
        ];

        //$this->form_validation->set_rules("fav_of", "Favourite of", "required");
        //$this->form_validation->set_rules("fav", "favourites", "required");

        $like_of = $this->post("like_of");
        $like = $this->post("like");

        if (empty($like) && empty($like_of)) {
            $this->response($output, REST_Controller::HTTP_OK);
        } else {
            //Pass Value in array
            //$ids = json_decode(urldecode($this->post("fav")));
            $like_id = $this->post("like");

            //get Existing Data
            $ch_exist = $this->Common_model->getAll('buyer_likes', array('user_id' => $this->_payload->userid))->num_rows();
            if ($ch_exist > 0) {
                $get_exist = $this->Common_model->getAll('buyer_likes', array('user_id' => $this->_payload->userid))->row_array();


                if ($this->post('like_of') == 'products') {

                    $existing_products = json_decode($get_exist['products']);


                    if (($key = array_search($like_id, $existing_products)) !== false) {
                        unset($existing_products[$key]);
                    }

                    $updateData = [
                        "products" => json_encode(array_values($existing_products))
                    ];


                    $this->Common_model->update("buyer_likes", $updateData, array('user_id' => $this->_payload->userid));


                    $output["status"] = 1;
                    $output["message"] = "Product DisLiked successfully !";
                } elseif ($this->post('like_of') == 'suppliers') {

                    $exist_supp = json_decode($get_exist['suppliers']);


                    $existing_supp = json_decode($get_exist['suppliers']);


                    if (($key = array_search($like_id, $existing_supp)) !== false) {
                        unset($existing_supp[$key]);
                    }

                    $updateData = [
                        "suppliers" => json_encode(array_values($existing_supp))
                    ];



                    $this->Common_model->update("buyer_likes", $updateData, array('user_id' => $this->_payload->userid));


                    $output["status"] = 1;
                    $output["message"] = "Supplier DisLiked successfully !";
                } else {
                    $output["status"] = 0;
                    $output["message"] = "Invalid Pass DisLike Data !";
                }
            } else {

                $output["status"] = 0;
                $output["message"] = "No Data Available !";
            }

            $this->response($output, REST_Controller::HTTP_OK);
        }
    }

    public function getFeedsProductVideos_post() {

        $user = $this->_payload->userid;
        $output = [
            "status" => 0,
            "message" => "No Data Found!",
            "ws" => "getFeedsProductVideos",
            "data" => []
        ];


        $sellers = $this->post("sellers");

        if (empty($sellers)) {
            $this->response($output, REST_Controller::HTTP_OK);
        } else {
            $page = $this->post('page_no');
            $limit = 30;  // Number of entries to show in a page. 

            if (isset($page)) {
                $pn = $page;
            } else {
                $pn = 1;
            }

            $start_from = ($pn - 1) * $limit;

            $user = $this->_payload->userid;

            $favs = $this->Myfavourite_model->getUsersFaveriotes($user);
            $fav_products = $favs->products;
            $bd_products = json_decode($fav_products);


            $likes = $this->Mylikes_model->getUsersLikes($user);
            $liked_products = $likes->products;
            $bd2_products = json_decode($liked_products);


            $categories_topics = $this->Categories_model->getRootCategories();

            foreach ($categories_topics as $val) {
                $val->categories_image = $val->categories_image;
            }

            $info = [];
            $products = $this->Product_model->getProductsVideosList($seller, $start_from, $limit);

            for ($i = 0; $i < count($products); $i++) {

                $products[$i]['liked'] = empty($likes) == false ? in_array($products[$i]['product_id'], $bd2_products) : false;
                $products[$i]['followed'] = empty($favs) == false ? in_array($products[$i]['product_id'], $bd_products) : false;
            }
            
            $products_offer = array();
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
                        $product['final_price1'] = $offerData['offerPrice'];
                        $product['discount'] = $offerData['offer_discount_value'];
                    }
                    $products_offer[] = $product;
                }


            $info[] = [
                "products" => $products_offer
            ];

            $output["status"] = 1;
            $output["message"] = "Feeds Product Videos list";
            $output["data"] = $info;
            $output["categories_topics"] = $categories_topics;
            $this->response($output, REST_Controller::HTTP_OK);
        }
    }

    public function UpdateFeedsProductVideoCount_post() {
        $user = $this->_payload->userid;
        $output = [
            "status" => 0,
            "message" => "invalid inputs",
            "ws" => "UpdateFeedsProductVideoCount",
            "data" => []
        ];
        //$this->form_validation->set_rules("sellers","sellers","required");

        $product_id = $this->post("product_id");

        if (empty($sellers)) {
            $this->response($output, REST_Controller::HTTP_OK);
        } else {

            $user = $this->_payload->userid;
            $favs = $this->Myfavourite_model->getUsersFaveriotes($user);
            $fav_sellers = $favs->suppliers;
            $sellers = $this->post("sellers");
            $bd_sellers = json_decode($fav_sellers);


            $likes = $this->Mylikes_model->getUsersLikes($user);

            $liked_sellers = $likes->suppliers;
            $bd2_sellers = json_decode($liked_sellers);

            $categories_topics = $this->Categories_model->getRootCategories();

            foreach ($categories_topics as $val) {
                $val->categories_image = $val->categories_image;
            }


            //print_r($bd2_sellers);
            $info = [];
            foreach ($sellers as $seller):
                //echo $seller;
                $company = $this->Company_model->getCompanyBasicByseller($seller);


                $info[] = [
                    "seller_id" => $seller,
                    "liked" => empty($likes) == false ? in_array($seller, $bd2_sellers) : false,
                    "followed" => empty($favs) == false ? in_array($seller, $bd_sellers) : false,
                    "company_name" => $company->company_name,
                    "logo" => $company->logo,
                    "products" => $this->Product_model->getProductList($seller, 9, 0)
                ];
            endforeach;
            $output["status"] = 1;
            $output["message"] = "Discover seller list";
            $output["data"] = $info;
            $output["categories_topics"] = $categories_topics;
            $this->response($output, REST_Controller::HTTP_OK);
        }
    }

}
