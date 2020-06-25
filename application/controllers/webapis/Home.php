<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Rfqs_model');
        $this->load->model('Company_model');
        $this->load->model('Categories_model');
        //$this->load->model('Products_model');
        $this->load->model('Product_model');
        $this->load->model('Users_model');
        $this->load->model('Offer_model');
        $this->load->library("form_validation");
    }

    //shubham patil > home page combined apis
    public function combined_get() {
        $products = $this->Product_model->topSellingProductsData(); // top selling product
        $topSellings = array();
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
                $product['max_final_price'] = "".$offerData['offerPrice'];
                $product['min_final_price'] = "".$offerData['offerPrice'];
                $product['discount'] = $offerData['offer_discount_value'];
            }
            $topSellings[] = $product;
        }

        $trendingCats = $this->Categories_model->getTopSellingCategories(5); // top trending categories
        $sub_categories = array_chunk($trendingCats, 3)[0];
        $sub_finalcats = array();
        foreach ($sub_categories as $rt) {
            $cats = $this->Categories_model->top_sub_categories_by_parent($limit = '', $rt->category_id); // sub_categories of all the parent categories
            $sub_finalcats[] = array(
                "id" => $rt->category_id,
                "title" => $rt->categories_name,
                "subCategories" => $cats
            );
        }

        // hard coded first three categories
        $threeStaticCat = [
            0 => [
                "categoryName" => "Apparel",
                "image" => base_url() . "uploads/images/categories/PRP5025_4.jpg",
                "referenceId" => "16"
            ],
            1 => [
                "categoryName" => "Consumer Electronics",
                "image" => base_url() . "uploads/images/categories/Mobile.jpg",
                "referenceId" => "23"
            ],
            2 => [
                "categoryName" => "Fashion Accessories",
                "image" => base_url() . "uploads/images/categories/fas.jpg",
                "referenceId" => "18"
            ]
        ];

        $offerZoneData = $this->Offer_model->getRunningOffers(); // offer zone data
        if (count($offerZoneData) == 0) {
            $offerZoneData = [];
        }

        $output = [
            "ws" => "combined_get",
            "status" => 1,
            "message" => "Success",
            "staticCats" => $threeStaticCat,
            "top_selling_products" => $topSellings,
            "offer_zone" => $offerZoneData,
            "top_trending_cats" => $sub_finalcats
        ];

        $this->response($output, REST_Controller::HTTP_OK);
    }

    public function combinedOld_get() {
        //$this->output->enable_profiler(true);
        $recommended_latest = $this->Common_model->select('image,topic,short_description,date(date_created) as created_date', 'insights_recommended', ['status' => 'Active'], array(1 => array('colname' => 'id', 'type' => 'DESC')), 1)[0];
        $recommended_latest["image"] = base_url() . "uploads/images/bi_recommended/" . $recommended_latest["image"];
        $categories = $this->getTrenCatsWithProds();

        $top_product = $this->Product_model->topSellingProductsData(1)[0];

        $top_category = $this->Categories_model->getTopSellingCategories(1)[0];

        $res = $this->Categories_model->getAllChilds_Combined(16);

        $catIds = explode(",", $res);

        $outcats = [];
        $tmcont = 0;


        foreach ($catIds as $cts):
            if (count($cts) > 0) {
                $products = $this->Product_model->getProductListByCategrories($cts, 0, 2);
                if ($products) {
                    $outcats[] = [
                        "products" => $products,
                        "background1" => "https://www.atzcart.com/assets/images/fa_02_background2.jpg",
                        "background2" => "https://www.atzcart.com/assets/images/fa_background1.jpg",
                    ];
                }
            }
            //$tmcont++;
        endforeach;
        $top_trending_products = [
            "category" => "Fashion & Accessories",
            "data" => $outcats
        ];

        $bigSale = [
            0 => [
                "title" => "New Arrivals",
                "image" => base_url() . "uploads/images/bigsale/new_arrivals.png",
                "desc" => "List of new arrived products"
            ],
            1 => [
                "title" => "20% Off",
                "image" => base_url() . "uploads/images/bigsale/20_percent_off.png",
                "desc" => "List of products upto 20% off discount"
            ],
            2 => [
                "title" => "30% Off",
                "image" => base_url() . "uploads/images/bigsale/30_percent_off.png",
                "desc" => "List of products from 30% off discount"
            ]
        ];
        $output = [
            "ws" => "combined",
            "status" => 1,
            "message" => "Success",
            "data" => [
                "selected_products" => [
                    0 => [
                        "title" => "Top Selling",
                        "image" => $top_product['url'],
                        "default_category" => $top_category->category_id
                    ],
                    1 => [
                        "title" => "Hot Imports",
                        "image" => "https://via.placeholder.com/150"
                    ]
                ],
                //"business_inside" => $recommended_latest,
                "categories" => $categories,
                "brand_zone" => [],
                "big_sale" => $bigSale,
                "top_trending_products" => $top_trending_products
            ]
        ];
        //echo "<pre>";
        //print_r($output);
        $this->response($output, REST_Controller::HTTP_OK);

        $this->response($output, HTTP_OK);
    }

    private function getTrenCatsWithProds() {
        $result = $this->Categories_model->getTopSellingCategoriesLastLevel(10);

        $cats = [];
        foreach ($result as $res):

            $products = $this->Product_model->getProductsByCategoryData($res->category_id, 0, 10);
            $cats[] = [
                "title" => $res->categories_name,
                "id" => $res->category_id,
                "image" => $res->categories_image,
                "products" => $products
            ];
        endforeach;

        return $cats;
    }

    public function justforyou_post() {
        $page = $this->post('since');
        $limit = 10;  // Number of entries to show in a page. 
        // Look for a GET variable page if not found default is 1.   
        if (isset($page)) {
            $pn = $page;
        } else {
            $pn = 1;
        }

        $start_from = ($pn - 1) * $limit;
        $interested_categories = $this->input->post("categories_id");
        $catsi = explode(",", $interested_categories);
        $res = "";
        foreach ($catsi as $cati) {
            $res = $res . $cati . "," . $this->Categories_model->getAllChilds($cati) . ",";
        }
        $ctcats = array_filter(explode(",", trim($res, ",")));
        //echo '<pre>';
        // print_r($ctcats);
        // exit;
        $prod_array = $this->Product_model->getProductByCatIds($ctcats, 30, $start_from);
        //echo count($prod_array);
        // exit;
        if (count($prod_array) < 30) {

            // $cats = range(1, 13);
            $rem = 30 - count($prod_array);

            $newProds = $this->Product_model->getProductByCatIds_remain($ctcats, $rem, $start_from);

            $prod_array = array_merge($prod_array, $newProds);
            // print_r($prod_array);
            //echo count($prod_array).'<br>';
            // print_r($prod_array);
            //exit;
        }

        foreach ($prod_array as $product) {
            $arrayOfferPrice['offer_status'] = $product->offer_status;
            $arrayOfferPrice['offer_type'] = $product->offer_type;
            $arrayOfferPrice['offer_discount_value'] = $product->offer_discount_value;
            $arrayOfferPrice['offer_start_time'] = $product->offer_start_time;
            $arrayOfferPrice['offer_end_time'] = $product->offer_end_time;
            //apply discount on mrp if offer is on
            $arrayOfferPrice['offerPrice'] = $product->mrp;
            $offerData = $this->Offer_model->calculateOfferPrice($arrayOfferPrice);
            if ($offerData != false) {
                $product->final_price1 = "" . $offerData['offerPrice'];
                $product->discount = $offerData['offer_discount_value'];
            }
            //$products_offer[] = $product;
        }


        $output = [
            "ws" => "justforyou",
            "status" => 1,
            "message" => "Success",
            "data" => $prod_array
        ];
        $this->response($output, REST_Controller::HTTP_OK);
    }

    public function userZoneBanner_get() {
        $data = array();
        $data['image'][0]['banner_url'] = base_url('uploads/images/app_banner/baner1.jpg');
        $data['image'][0]['html_url'] = base_url() . "users/trade_assurance";


        $data['image'][1]['banner_url'] = base_url('uploads/images/app_banner/baner2.jpg');
        $data['image'][1]['html_url'] = base_url() . "users/new_feeds";

        $data['new_user_offers_url'] = base_url() . "users";
        $data['buyer_success_stories_url'] = base_url() . "users/buyer_success";
        $data['app_guide_video_url'] = "https://commondatastorage.googleapis.com/gtv-videos-bucket/sample/BigBuckBunny.mp4";

        $data['right_supplier_url'] = base_url() . "users/tips_for_new_users";
        $data['found_product_url'] = base_url() . "users/tips_user2";
        $data['protects_orders_url'] = base_url() . "users/tips_user3";
        $data['customer_service_url'] = base_url() . "users/customer_service_url";

        //$data['white_paper'] = base_url()."users/b2b"; 
        //$data['small_busy_hacks'] = base_url()."users/small_busy_hacks"; 
        //$data['atz_success'] = base_url()."users/atz_success";   
        //$data['buyer_success'] = base_url()."users/buyer_success"; 


        $data["products"] = $this->Product_model->getProductList(0, 30, rand(50, 100));
        $output = [
            "ws" => "user_model_banner",
            "status" => 1,
            "message" => "Success",
            "data" => $data
        ];

        $this->response($output, REST_Controller::HTTP_OK);
    }

    /* Search Key For Categories auto-suggest */

    public function searchCategories_post() {
        $ws = $this->post("ws");
        $searchkey = $this->post("searchkey");
        if (empty($ws)) {
            $ws = "searchCategories";
        }
        $popular_cats = $this->Product_model->getPopularCategories(10);
        $data = [
            "categories" => [],
            "sellers" => [],
            "popular_cats" => $popular_cats
        ];
        if ($searchkey != "") {
            $data["categories"] = $this->Categories_model->smart_search_result($searchkey);
            $data["sellers"] = $this->Users_model->searchSellerByName($searchkey);
        }
        $output = [
            "ws" => "searchCategories",
            "status" => 1,
            "message" => "Search",
            "data" => $data,
        ];
        $this->response($output, REST_Controller::HTTP_OK);
    }

    public function search_post() {
        //$this->output->enable_profiler(true);
        $ws = $this->post("ws");
        if (empty($ws)) {
            $ws = "search";
        }
        $output = [
            "ws" => $ws,
            "status" => 0,
            "message" => "Invalid Inputs!",
            "data_count" => 0,
            "message" => 0,
            "data" => [],
        ];
        $this->form_validation->set_rules("searchkey", "serachkey", "required");
        $this->form_validation->set_rules("searchfrom", "serachfrom", "required|in_list[product,seller]");
        if ($this->form_validation->run() === false) {
            $this->response($output, REST_Controller::HTTP_OK);
        } else {
            $sKey = $this->post("searchkey");
            $sFrom = $this->post("searchfrom");
            $id = $this->post("id");
            $page = $this->post('page_no');

            $limit = 10;  // Number of entries to show in a page. 

            if (isset($page)) {
                $pn = $page;
            } else {
                $pn = 1;
            }

            $start_from = ($pn - 1) * $limit;


            //Category specification
            $this->db->select('id as spec_id,name,choices');
            $this->db->from('category_specific_specifications');
            $this->db->where('category_id', $id);
            $q = $this->db->get();

            $category_specification = $q->result_array();

            if ($sFrom == "product" && $id != "") {
                $output["status"] = 1;
                $output["message"] = "Product List";
                $products = $this->Product_model->getProductsByCategoryData_app($id, $start_from, $limit);
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

                $output["data"] = $products_offer;
                $output['category_specification'] = $category_specification;
                $output["data_count"] = count($products_offer);
                $this->response($output, REST_Controller::HTTP_OK);
            } else if ($sFrom == "seller" && $id != "") {
                $output["status"] = 1;
                $output["message"] = "Seller List";
                $sdata = $this->Company_model->getCompanyListByCategory($id);
                $output["data"] = $sdata;
                $output['category_specification'] = $category_specification;
                $output["data_count"] = count($sdata);
                $this->response($output, REST_Controller::HTTP_OK);
            } else {
                $output["status"] = 1;
                $output["message"] = "Seller List";
                $sdata = $this->Product_model->searchProductsByName($sKey, $start_from, $limit);
                $output["data"] = $sdata;
                $output['category_specification'] = $category_specification;
                $output["data_count"] = count($sdata);
                $this->response($output, REST_Controller::HTTP_OK);
            }
        }
    }

    public function discover_post() {

        //$user = $this->_payload->userid;
        $output = [
            "status" => 0,
            "ws" => "discover",
            "message" => "No Data Found!",
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
            };

            $start_from = ($pn - 1) * $limit;

            $categories_topics = $this->Categories_model->getRootCategories();

            foreach ($categories_topics as $val) {
                $val->categories_image = base_url() . "uploads/images/categories/" . $val->categories_image;
            }


            //print_r($bd2_sellers);
            $info = [];
            foreach ($sellers as $seller):
                //echo $seller;
                $company = $this->Company_model->getCompanyBasicByseller($seller);
                //$products = $this->Product_model->getAllProductDetailsBySellers($seller,$start_from,$limit);
                $products = $this->Product_model->getAllProductDetailsBySellers($seller, 0, 9);


                for ($i = 0; $i < count($products); $i++) {
                    $products[$i]['liked'] = false;
                    $products[$i]['followed'] = false;
                }


                $info[] = [
                    "seller_id" => $seller,
                    "liked" => false,
                    "followed" => false,
                    "company_name" => $company->company_name,
                    "logo" => base_url() . "uploads/images/seller_company_logo/" . $company->logo,
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

    public function getFeedsProductVideos_post() {
        $output = [
            "status" => 0,
            "message" => "No Data Found!",
            "ws" => "getFeedsProductVideos",
            "data" => []
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
            };

            $start_from = ($pn - 1) * $limit;
            $categories_topics = $this->Categories_model->getRootCategories();

            foreach ($categories_topics as $val) {
                $val->categories_image = $val->categories_image;
            }

            $info = [];
            $product = $this->Product_model->getProductsVideosList($seller, $start_from, $limit);


            $info[] = [
                "products" => $product
            ];
            if (count($info) > 0) {
                $output["status"] = 1;
                $output["message"] = "Feeds Product Videos list";
                $output["data"] = $info;
                $output["categories_topics"] = $categories_topics;
            } else {
                $output["status"] = 0;
                $output["message"] = "No Data Found";
            }
            $this->response($output, REST_Controller::HTTP_OK);
        }
    }

    public function topSellingProducts_post() {

        $output = [
            "status" => 0,
            "message" => "Invalid inputs!",
            "data" => [],
        ];
        $this->form_validation->set_rules("category_id", "category", "required");
        if ($this->form_validation->run() === false) {
            $this->response($output, REST_Controller::HTTP_OK);
        } else {
            $category = $this->post("category_id");
            $top_categories = $this->Categories_model->getTopSellingCategories(10);
            $top_products = $this->Product_model->topSellingProductsDataByCategory($category);
            $data = [
                "top_categories" => $top_categories,
                "top_products" => $top_products,
            ];
            $output["status"] = 1;
            $output["message"] = "List of top selling products";
            $output["data"] = $data;
            $this->response($output, REST_Controller::HTTP_OK);
        }
    }

    public function newArrivals_post() {
        $page = $this->post('since');
        if (!$page) {
            $page = 1;
        }
        $limit = 30;  // Number of entries to show in a page. 
        // Look for a GET variable page if not found default is 1.   
        if (isset($page)) {
            $pn = $page;
        } else {
            $pn = 1;
        }

        $start_from = ($pn - 1) * $limit;
        $products = $this->Product_model->getProductListSortByDate($limit, $start_from);
        $output = [
            "ws" => "newArrivals",
            "status" => 1,
            "message" => "Success",
            "data" => $products,
            "data_count" => count($products)
        ];
        $this->response($output, REST_Controller::HTTP_OK);
    }

    public function getProductsUpto20PerOff_post() {
        $page = $this->post('since');
        if (!$page) {
            $page = 1;
        }
        $limit = 30;  // Number of entries to show in a page. 
        // Look for a GET variable page if not found default is 1.   
        if (isset($page)) {
            $pn = $page;
        } else {
            $pn = 1;
        }

        $start_from = ($pn - 1) * $limit;
        $products = $this->Product_model->getProductsUptoDiscount(20);
        $output = [
            "ws" => "getProductsUpto20PerOff",
            "status" => 1,
            "message" => "Success",
            "data" => $products,
            "data_count" => count($products)
        ];
        $this->response($output, REST_Controller::HTTP_OK);
    }

    public function getProductsFrom30PerOff_post() {
        $page = $this->post('since');
        if (!$page) {
            $page = 1;
        }
        $limit = 30;  // Number of entries to show in a page. 
        // Look for a GET variable page if not found default is 1.   
        if (isset($page)) {
            $pn = $page;
        } else {
            $pn = 1;
        }

        $start_from = ($pn - 1) * $limit;
        $products = $this->Product_model->getDiscoutedProduct(30);
        $output = [
            "ws" => "getProductsUpto20PerOff",
            "status" => 1,
            "message" => "Success",
            "data" => $products,
            "data_count" => count($products)
        ];
        $this->response($output, REST_Controller::HTTP_OK);
    }

}
