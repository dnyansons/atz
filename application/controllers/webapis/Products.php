<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * This is a public API file does not need to be token verified
 *
 */
use Firebase\JWT\JWT;

class Products extends REST_Controller {

    public function __construct($config = 'rest') {
        parent::__construct($config);
        /* $token = $this->input->get_request_header('Token');
          try {
          $this->_payload = JWT::decode($token, $this->config->item('jwt_secret_key'), array('HS256'));
          } catch (Exception $ex) {
          $output = array("status" => 0, "message" => $ex->getMessage());
          $this->response($output, REST_Controller::HTTP_UNAUTHORIZED);
          } */
        $this->load->model("Product_model");
        $this->load->model("Categories_model");
        $this->load->model("Company_model");
        $this->load->model("Offer_model");
        $this->load->library("form_validation");
        $this->load->library("Send_data");
        $this->load->library("Shiprocket");
    }

    public function getAll_get() {
        $ws = $this->get("ws");

        if (empty($ws)) {
            $ws = "products";
        }

        $output = array(
            "ws" => $ws,
            "status" => 0,
            "message" => "Test"
        );
        $output["items"] = $this->Product_model->getAll();
        $this->response($output, REST_Controller::HTTP_OK);
    }

    public function getProductsByCategory_post() {
        $ws = $this->post("ws");

        if (empty($ws)) {
            $ws = "getProductsByCategory";
        }

        $this->form_validation->set_rules("category_id", "category", "required|numeric");

        if ($this->form_validation->run() === false) {
            $output = array(
                "ws" => $ws,
                "status" => 0,
                "message" => "Invalid inputs"
            );
            $this->response($output, REST_Controller::HTTP_OK);
        } else {
            $category_id = $this->post('category_id');
            $page = $this->post('page_no');

            $limit = 10;  // Number of entries to show in a page. 

            if (isset($page)) {
                $pn = $page;
            } else {
                $pn = 1;
            }

            $start_from = ($pn - 1) * $limit;

            //$res = $this->Categories_model->getAllChilds($category_id);
            //$catIds = explode(",", $res);
            $cat_ids = $this->post('category_id');
            //print_r($catIds);
            $res = $this->Categories_model->getAllChilds($category_id);
            $catIds = explode(",", $cat_ids . "," . $res);
            $products_count = $this->Product_model->getProductsByCategoryDataNumRows($catIds);
            //echo $this->db->last_query();
            // exit;
            if ($products_count > 0) {

                //Category specification
                $this->db->select('id as spec_id,name,choices');
                $this->db->from('category_specific_specifications');
                $this->db->where('category_id', $category_id);
                $q = $this->db->get();

                $category_specification = $q->result_array();




                $output["ws"] = $ws;
                $output["status"] = 1;
                $output["message"] = "Product list fetch success.";
                $output['data_count'] = $products_count;
                $output['category_specification'] = $category_specification;
                $products = $this->Product_model->getProductsByCategoryData($catIds, $start_from, $limit);
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
                $this->response($output, REST_Controller::HTTP_OK);
            } else {
                $output["ws"] = $ws;
                $output["status"] = 0;
                $output["message"] = "No products found.";
                $this->response($output, REST_Controller::HTTP_OK);
            }
        }
    }

    function filter_getProductsByCategory_post() {
        $ws = $this->post("ws");

        if (empty($ws)) {
            $ws = "filter_getProductsByCategory";
        }

        $this->form_validation->set_rules("category_id", "category", "required");

        if ($this->form_validation->run() === false) {
            $output = array(
                "ws" => $ws,
                "status" => 0,
                "message" => "Invalid inputs"
            );
            $this->response($output, REST_Controller::HTTP_OK);
        } else {
            $category_id = $this->post('category_id');
            $page = $this->post('page_no');

            //Search Parameter 
            $min_order = $this->post('min_order');
            $min_price = $this->post('min_price');
            $max_price = $this->post('max_price');
            $location = $this->post('location');
            $instock = $this->post('instock');
            $trade_assurance = $this->post('trade_assurance');
            $supp_verified = $this->post('supp_verified');
            $spec_values = json_decode($this->post("spec_value"));

            $limit = 10;  // Number of entries to show in a page. 

            if (isset($page)) {
                $pn = $page;
            } else {
                $pn = 1;
            }

            $start_from = ($pn - 1) * $limit;

            $res = $this->Categories_model->getAllChilds($category_id);
            $catIds = explode(",", $category_id . "," . $res);
            $products_count = $this->Product_model->getProductsByCategoryDataNumRows($catIds);


            if ($products_count > 0) {

                //Category specification
                $this->db->select('id as spec_id,name,choices');
                $this->db->from('category_specific_specifications');
                $this->db->where('category_id', $category_id);
                $q = $this->db->get();

                $category_specification = $q->result_array();




                $output["ws"] = $ws;
                $output["status"] = 1;
                $output["message"] = "Product list fetch success.";
                $output['data_count'] = $products_count;
                $output['category_specification'] = $category_specification;
                $products = $this->Product_model->search_ProductsByCategoryData($catIds, $start_from, $limit, $min_order, $min_price, $max_price, $location, $instock, $trade_assurance, $supp_verified, $spec_values);
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
                $this->response($output, REST_Controller::HTTP_OK);
            } else {
                $output["ws"] = $ws;
                $output["status"] = 0;
                $output["message"] = "No products found.";
                $this->response($output, REST_Controller::HTTP_OK);
            }
        }
    }

    public function getProductDescription_post() {
        $ws = $this->post("ws");

        if (empty($ws)) {
            $ws = "getProductDescription";
        }

        $this->form_validation->set_rules("products_id", "products id", "required");

        if ($this->form_validation->run() === false) {
            $output = array(
                "ws" => $ws,
                "status" => 0,
                "message" => "No Output"
            );
            $this->response($output, REST_Controller::HTTP_OK);
        } else {
            $products_id = $this->post('products_id');
            $output["ws"] = $ws;
            $output["status"] = 1;
            $output["message"] = "Product description fetch success.";
            $output["data"] = $this->Product_model->getProductDescriptionData($products_id);
            $this->response($output, REST_Controller::HTTP_OK);
        }
    }

    public function getProductDetails_post() {
        $token = $this->input->get_request_header('Token');
        try {
            $this->_payload = JWT::decode($token, $this->config->item('jwt_secret_key'), array('HS256'));
        } catch (Exception $ex) {
            // $output = array("status" => 0, "message" => $ex->getMessage());
            // $this->response($output, REST_Controller::HTTP_UNAUTHORIZED);
        }


        $ws = $this->post("ws");

        if (empty($ws)) {
            $ws = "getProductDetails";
        }

        $this->form_validation->set_rules("products_id", "products id", "required");

        if ($this->form_validation->run() === false) {
            $output = array(
                "ws" => $ws,
                "status" => 0,
                "message" => "No Output"
            );
            $this->response($output, REST_Controller::HTTP_OK);
        } else {
            $products_id = $this->post('products_id');

            $this->Product_model->incrementViewCount($products_id);
            $output["ws"] = $ws;
            $output["status"] = 1;
            $output["message"] = "Product details fetch success.";
            $output["items"] = $this->Product_model->getProductDetails($products_id);
            //$output['prices'] = $output['items']['product_prices'];

            $products_offer = array();


            foreach ($output["items"]['product_prices'] as $price) {
                $arrayOfferPrice['offer_status'] = $output["items"]['offer_status'];
                $arrayOfferPrice['offer_type'] = $output["items"]['offer_type'];
                $arrayOfferPrice['offer_discount_value'] = $output["items"]['offer_discount_value'];
                $arrayOfferPrice['offer_start_time'] = $output["items"]['offer_start_time'];
                $arrayOfferPrice['offer_end_time'] = $output["items"]['offer_end_time'];
                //apply discount on atz_price if offer is on
                $arrayOfferPrice['offerPrice'] = $price->atz_price;
                $offerData = $this->Offer_model->calculateOfferPrice($arrayOfferPrice);
                if ($offerData != false) {
                    $output["items"]['discount_percentage'] = $output["items"]['offer_discount_value'];
                    //$output['offerPrices'][] = $offerData['offerPrice'];
                    $price->final_price = "" . $offerData['offerPrice'];
                }
            }


            $output["items"]['review_count'] = $this->Product_model->product_review_count($products_id)['review_count'];
            $output["items"]['average_review_rating'] = $this->Product_model->product_review_count($products_id)['average_review_rating'];
            $output["items"]['shopping_cart_count'] = $this->Product_model->getUsersCartItemsCountData($this->_payload->userid);
            $output["items"]['in_notified_list'] = $this->Product_model->checkUserInNotifyList($products_id, $this->_payload->userid);
            $this->response($output, REST_Controller::HTTP_OK);
        }
    }

    public function mainSearch_post() {
        $ws = $this->post("ws");

        if (empty($ws)) {
            $ws = "mainSearch";
        }

        $this->form_validation->set_rules("search_by", "search by", "required");
        $this->form_validation->set_rules("search", "search", "required");

        if ($this->form_validation->run() === false) {
            $output = array(
                "ws" => $ws,
                "status" => 0,
                "message" => "Invalid inputs"
            );

            $this->response($output, REST_Controller::HTTP_OK);
        } else {
            $search_by = $this->post('search_by');
            $search = $this->post('search');

            if ($search_by == "products") {
                $output["ws"] = $ws;
                $output["status"] = 1;
                $output["message"] = "Product main searched list fetch success.";
                $output["items"] = $this->Product_model->searchAllProducts($search);
                $this->response($output, REST_Controller::HTTP_OK);
            } else if ($search_by == "suppliers") {
                $output["ws"] = $ws;
                $output["status"] = 1;
                $output["message"] = "Product searched list fetch success.";
                $output["items"] = $this->Product_model->searchAllSuppliersWithProducts($search);
                $this->response($output, REST_Controller::HTTP_OK);
            }
        }
    }

    public function getRecommendedProducts_get() {
        $ws = $this->get("ws");

        if (empty($ws)) {
            $ws = "getRecommendedProducts";
        }

        $recommendedItemsIds = $this->get('recommendedItemsIds');

        if (empty($recommendedItemsIds) || $recommendedItemsIds == "") {
            /*
              $output = array(
              "success" => 0,
              "message" => "Invalid inputs"
              );

              $this->response($output,HTTP_OK);
             */
            $recommendedItemsIds = 0;
        }


        //$recommendedItemsIds=$this->get('recommendedItemsIds');
        $products_count = count($this->Product_model->getRecommendedProductsData($recommendedItemsIds));

        if ($products_count > 0) {
            $output["ws"] = $ws;
            $output["status"] = 1;
            $output["message"] = "Product recommended items fetch success.";
            $output["items"] = $this->Product_model->getRecommendedProductsData($recommendedItemsIds);
            $this->response($output, REST_Controller::HTTP_OK);
        } else {
            $output["ws"] = $ws;
            $output["status"] = 0;
            $output["message"] = "No products found.";
            $this->response($output, REST_Controller::HTTP_OK);
        }
    }

    public function getWeeklyDeals_get() {
        $ws = $this->get("ws");

        if (empty($ws)) {
            $ws = "getWeeklyDeals";
        }

        $products_count = count($this->Product_model->getWeeklyDealsData());

        if ($products_count > 0) {
            $output["ws"] = $ws;
            $output["status"] = 1;
            $output["message"] = "Product weekly deals fetch success.";
            $output["items"] = $this->Product_model->getWeeklyDealsData();
            $this->response($output, REST_Controller::HTTP_OK);
        } else {
            $output["ws"] = $ws;
            $output["status"] = 0;
            $output["message"] = "No products found.";
            $this->response($output, REST_Controller::HTTP_OK);
        }
    }

    public function getProductsByCollection_post() {
        $ws = $this->post("ws");

        if (empty($ws)) {
            $ws = "getProductsByCollection";
        }

        $output = array(
            "ws" => $ws,
            "status" => 1,
            "message" => "Test"
        );
        $output["items"] = $this->Product_model->getProductsByCollectionData();
        $this->response($output, REST_Controller::HTTP_OK);
    }

    public function getUnits_get() {
        $ws = $this->get("ws");

        if (empty($ws)) {
            $ws = "getUnits";
        }

        $units_arr = $this->Common_model->select('units_id,units_name', 'units');

        if (!empty($units_arr)) {
            $output["ws"] = $ws;
            $output["status"] = 1;
            $output["message"] = "Units fetch success.";
            $output["units"] = $units_arr;
            $this->response($output, REST_Controller::HTTP_OK);
        } else {
            $output["ws"] = $ws;
            $output["status"] = 0;
            $output["message"] = "No units found.";
            $this->response($output, REST_Controller::HTTP_OK);
        }
    }

    public function getProductsBySeller_post() {
        $ws = $this->post('ws');

        if (empty($ws)) {
            $ws = "getProductsBySeller";
        }

        $this->form_validation->set_rules('seller_id', 'seller_id', 'required');

        if ($this->form_validation->run() === false) {
            $output = [
                "ws" => $ws,
                "status" => 0,
                "message" => "Unable to update data"
            ];

            $this->set_response($output, REST_Controller::HTTP_OK);
        } else {
            $seller_id = $this->post('seller_id');

            $page = $this->post('page_no');

            $limit = 30;  // Number of entries to show in a page. 

            if (isset($page)) {
                $pn = $page;
            } else {
                $pn = 1;
            }

            $start_from = ($pn - 1) * $limit;

            $output['ws'] = $ws;
            $output['status'] = 1;
            $output['message'] = "Seller products list fetch success.";
            $output["items"] = $this->Product_model->getProductsBySellerData($seller_id, $start_from, $limit);
            $products_offer = array();


            foreach ($output["items"]['product_prices'] as $price) {
                $arrayOfferPrice['offer_status'] = $output["items"]['offer_status'];
                $arrayOfferPrice['offer_type'] = $output["items"]['offer_type'];
                $arrayOfferPrice['offer_discount_value'] = $output["items"]['offer_discount_value'];
                $arrayOfferPrice['offer_start_time'] = $output["items"]['offer_start_time'];
                $arrayOfferPrice['offer_end_time'] = $output["items"]['offer_end_time'];
                //apply discount on atz_price if offer is on
                $arrayOfferPrice['offerPrice'] = $price->atz_price;
                $offerData = $this->Offer_model->calculateOfferPrice($arrayOfferPrice);
                if ($offerData != false) {
                    $output["items"]['discount'] = $output["items"]['offer_discount_value'];
                    //$output['offerPrices'][] = $offerData['offerPrice'];
                    $price->final_price = "" . $offerData['offerPrice'];
                }
            }
            $this->response($output, REST_Controller::HTTP_OK);
        }
    }

    public function getProductsVideosByCategory_post() {
        $ws = $this->post("ws");

        if (empty($ws)) {
            $ws = "getProductsVideosByCategory";
        }

        $this->form_validation->set_rules("category_id", "category", "required");

        if ($this->form_validation->run() === false) {
            $output = array(
                "ws" => $ws,
                "status" => 0,
                "message" => "Invalid inputs"
            );
            $this->response($output, REST_Controller::HTTP_OK);
        } else {
            $category_id = $this->post('category_id');
            $cat = $this->Categories_model->getAllChildCategoriesByParentCategory1($category_id);

            //print_r($cat);exit;

            $categories_id_array = array();

            for ($i = 0; $i < count($cat); $i++) {
                array_push($categories_id_array, $cat[$i]['category_id']);
                for ($j = 0; $j < count($cat[$i]['sub']); $j++) {
                    array_push($categories_id_array, $cat[$i]['sub'][$j]->category_id);
                }
            }

            $categories_id_array = array_unique($categories_id_array);

            //print_r($categories_id_array);exit;

            $page = $this->post('page_no');

            $limit = 10;  // Number of entries to show in a page. 

            if (isset($page)) {
                $pn = $page;
            } else {
                $pn = 1;
            }

            $start_from = ($pn - 1) * $limit;
            $products_count = $this->Product_model->getProductsVideosByCategoryDataNumRows2($categories_id_array);

            //echo $products_count;exit;


            if ($products_count > 0) {
                $output["ws"] = $ws;
                $output["status"] = 1;
                $output["message"] = "Product list fetch success.";
                $output['data_count'] = $products_count;
                $products = $this->Product_model->getProductsVideosByCategoryData2($categories_id_array, $start_from, $limit);
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


                $this->response($output, REST_Controller::HTTP_OK);
            } else {
                $output["ws"] = $ws;
                $output["status"] = 0;
                $output["message"] = "No products found.";
                $this->response($output, REST_Controller::HTTP_OK);
            }
        }
    }

    public function compare_post() {

        $ws = $this->post("ws");
        if ($ws == "") {
            $ws = "compare";
        }
        $output = [
            "ws" => $ws,
            "status" => 0,
            "message" => "Invalid Inputs",
            "data" => ""
        ];
        $this->form_validation->set_rules("products", "products", "required|callback_isValidArray");
        if ($this->form_validation->run() === false) {
            $this->response($output, REST_Controller::HTTP_OK);
        } else {
            $productIds = json_decode($this->post("products"));
            $product_features = [
                0 => [
                    "name" => "moq",
                    "value" => []
                ],
                1 => [
                    "name" => "price",
                    "value" => []
                ]
            ];
            $seller_details = [
                0 => [
                    "name" => "Company Name",
                    "value" => []
                ],
                1 => [
                    "name" => "Country / Territory",
                    "value" => []
                ],
                2 => [
                    "name" => "Main Product",
                    "value" => []
                ],
                3 => [
                    "name" => "Total annual sale volume",
                    "value" => []
                ],
                4 => [
                    "name" => "Company Type",
                    "value" => []
                ],
                5 => [
                    "name" => "Number of R&D staff",
                    "value" => []
                ],
                6 => [
                    "name" => "Main market distribution",
                    "value" => []
                ]
            ];
            foreach ($productIds as $product):
                $product_price = $this->Product_model->getProductMoqPrice($product);
                array_push($product_features[0]["value"], ($product_price->quantity_from ?? "-"));
                array_push($product_features[1]["value"], ($product_price->price ?? "-"));
                //array_push($product_features["attrs"],(array)$this->Product_model->getProductAttrs($product));
                //echo "<pre>";
                //print_r($attrs);
                $company_details = $this->Company_model->getCompanyDetailsByProduct($product);
                array_push($seller_details[0]["value"], ($company_details->company_name ?? "-"));
                array_push($seller_details[1]["value"], ($company_details->location_country ?? "-"));
                array_push($seller_details[2]["value"], ($company_details->main_products ?? "-"));
                array_push($seller_details[3]["value"], ($company_details->annual_revenue ?? "-"));
                array_push($seller_details[5]["value"], ($company_details->rd_staff_count ?? "-"));
                array_push($seller_details[4]["value"], ($company_details->company_type ?? "-"));
                array_push($seller_details[6]["value"], ($company_details->main_markets_distribution ?? "-"));

                //echo "<pre>";
                //print_r($company_details);
            endforeach;
            $output["data"] = [
                "product_features" => $product_features,
                "seller_details" => $seller_details,
            ];
            $output["status"] = 1;
            $output["message"] = "Product compare details";
            $this->response($output, REST_Controller::HTTP_OK);
        }
    }

    public function recommended_post() {

        $ws = $this->post("ws");
        if (!$ws) {
            $ws = "recommended";
        }
        $output = [
            "status" => 0,
            "message" => "Invalid Inputs!",
            "data" => [],
            "ws" => $ws
        ];
        $this->form_validation->set_rules("product_id", "product", "required");
        if ($this->form_validation->run() === false) {
            $this->response($output, REST_Controller::HTTP_OK);
        } else {
            $page = $this->input->post("page_no");
            if (isset($page)) {
                $pn = $page;
            } else {
                $pn = 1;
            }
            $limit = 15;
            $start_from = ($pn - 1) * $limit;

            $product_id = $this->post("product_id");
            $product_details = $this->Product_model->getProductBasicsById($product_id);
            $category = $product_details->category;
            $products = $this->Product_model->getProductsByCategoryData($category, $start_from, $limit);
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
            $output["status"] = 1;
            $output["message"] = "Recommended Product List";
            $output["data"] = $products_offer;
            $this->response($output, REST_Controller::HTTP_OK);
        }
    }

    public function isValidArray($str) {
        $products = json_decode($str);
        if (!$products || count($products) < 2) {
            $this->form_validation->set_message("isValidArray", "Invalid Inputs");
            return false;
        } else {
            return true;
        }
    }

    public function getCouponsOnProduct_post() {
        $ws = $this->post("ws");
        if (!$ws) {
            $ws = "getCouponsOnProduct";
        }
        $output = [
            "status" => 0,
            "message" => "Invalid Inputs!",
            "data" => [],
            "ws" => $ws
        ];
        $this->form_validation->set_rules("product_id", "product", "required");
        if ($this->form_validation->run() === false) {
            $this->response($output, REST_Controller::HTTP_OK);
        } else {
            $product_id = $this->post("product_id");
            $data = $this->Product_model->getProductCoupens($product_id);
            $output["status"] = 1;
            $output["message"] = "Products available coupon list";
            $output["data"] = $data;
            $this->response($output, REST_Controller::HTTP_OK);
        }
    }

    public function getProductsByCoupon_post() {

        $ws = $this->post("ws");
        if (!$ws) {
            $ws = "getProductsByCoupen";
        }
        $output = [
            "status" => 0,
            "message" => "Invalid Inputs!",
            "data" => [],
            "ws" => $ws
        ];
        $this->form_validation->set_rules("coupon_id", "Coupon", "required");
        if ($this->form_validation->run() === false) {
            $this->response($output, REST_Controller::HTTP_OK);
        } else {
            $coupon_id = $this->post("coupon_id");
            $data = $this->Product_model->getProductsByCoupon($coupon_id);
            $output["status"] = 1;
            $output["message"] = "Product list by coupons";
            $output["data"] = $data;
            $this->response($output, REST_Controller::HTTP_OK);
        }
    }

    // Api by shailesh to get product review list date : 01/06/2019

    public function getProductReviewList_post() {

        $ws = $this->post("ws");
        if (!$ws) {
            $ws = "getProductReviewList";
        }
        $output = [
            "status" => 0,
            "message" => "Invalid Inputs!",
            "data" => [],
            "ws" => $ws
        ];
        $this->form_validation->set_rules("products_id", "products_id", "required");
        if ($this->form_validation->run() === false) {
            $this->response($output, REST_Controller::HTTP_OK);
        } else {
            $products_id = $this->input->post('products_id');
            $data = $this->Product_model->getProductsReviews($products_id);
            $output["status"] = 1;
            $output["message"] = "Review list of product";
            $output["data"] = $data;
            $this->response($output, REST_Controller::HTTP_OK);
        }
    }

    function sons2_get() {
        $dat = $this->Product_model->get_membership_data(93, 1);

        print_r($dat);
    }

    /**
     * @auther Yogesh Pardeshi 23082019
     * @param @posted parameters $products_id
     * @return true if user is newly added in table
     * other wise false for already added user
     * @use in api only
     * */
    public function insertUserInNotifyList_post() {
        $token = $this->input->get_request_header('Token');
        try {
            $this->_payload = JWT::decode($token, $this->config->item('jwt_secret_key'), array('HS256'));
        } catch (Exception $ex) {
            // $output = array("status" => 0, "message" => $ex->getMessage());
            // $this->response($output, REST_Controller::HTTP_UNAUTHORIZED);
        }

        $ws = $this->post("ws");

        if (empty($ws)) {
            $ws = "insertUserInNotifyList";
        }

        $this->form_validation->set_rules("products_id", "products id", "required");

        if ($this->form_validation->run() === false) {
            $output = array(
                "ws" => $ws,
                "status" => 0,
                "message" => "No Output"
            );
            $this->response($output, REST_Controller::HTTP_OK);
        } else {
            $products_id = $this->post('products_id');
            $output["ws"] = $ws;
            $output["status"] = 1;
            $output["message"] = "User notify process success.";
            $output['in_notified_list'] = $this->Product_model->insertInNotifyList($products_id, $this->_payload->userid);
            $this->response($output, REST_Controller::HTTP_OK);
        }
    }

    function getGeoAddress_post() {
        $this->load->library("Shipping");
        $output = [
            "status" => 0,
            "message" => "Invalid pincode",
            "data" => [],
            "ws" => "getGeoAddress"
        ];
        $pincode = $this->input->post("pincode"); // Google HQ
        $seller_id = $this->input->post('seller_id');
        $numlength = strlen((string) $pincode);
        if ($numlength == 6) {

            $geocode = file_get_contents('https://maps.google.com/maps/api/geocode/json?address=' . $pincode . '&key=AIzaSyBkN0wRthzWGnY1ppnijgRhqVwkjY03Eko');
            $output = json_decode($geocode);
            $city = $output->results[0]->address_components[1]->long_name;
            $state = $output->results[0]->address_components[2]->long_name;

            $ship_method = $this->send_data->get_shipping_method();
            if ($ship_method == 2) {
                $paddress = $this->Common_model->getAll('seller_pick_address', array('user_id' => $seller_id))->row_array();
                $seller_pincode = $paddress['pincode'];
                if (empty($seller_pincode)) {
                    $seller_pincode = 411057;
                }
                $res = $this->shiprocket->serviceability($seller_pincode, $pincode, 1, 0.5, 0.5, 0.5, 1);

                if ($res['status'] == 200) {
                    $output = [
                        "status" => 1,
                        "city" => $city,
                        "state" => $state,
                        "message" => "The Item is Deliverable at this Pincode (Expected Delivery In 3-5 Days).",
                        "ws" => "getGeoAddress"
                    ];
                } else {
                    $output = [
                        "status" => 0,
                        "message" => "Sorry ! The Item is Not Deliverable at this Pincode.",
                        "data" => [],
                        "ws" => "getGeoAddress"
                    ];
                }
            } else {
                $result = $this->shipping->location_finder($pincode);
              
                if ($result['GetServicesforPincodeResult']['AreaCode'] != '' && $result['GetServicesforPincodeResult']['EDLDist']==0) {
                    $output = [
                        "status" => 1,
                        "city" => $city,
                        "state" => $state,
                        "message" => "The Item is Deliverable at this Pincode (Expected Delivery In 3-5 Days).",
                        "ws" => "getGeoAddress"
                    ];
                } else {
                    $output = [
                        "status" => 0,
                        "message" => "Sorry ! The Item is Not Deliverable at this Pincode.",
                        "data" => [],
                        "ws" => "getGeoAddress"
                    ];
                }
            }
        }
        $this->response($output, REST_Controller::HTTP_OK);
    }

}
