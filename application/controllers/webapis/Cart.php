<?php

defined('BASEPATH') OR exit('No direct script access allowed');

use Firebase\JWT\JWT;

class Cart extends REST_Controller {

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
        $this->load->model('Cart_model');
        $this->load->model('Offer_model');
        $this->load->model('Product_model');
    }

    public function addToCart_post() {
        $ws = $this->post("ws");

        if (empty($ws)) {
            $ws = "addToCart";
        }

        //$specifications='[{"specifications":[{"id":"1","name":"color","selected_value":"red"},{"id":"2","name":"size","selected_value":"xl"},{"id":"3","name":"model","selected_value":"r15"}],"quantity":"10","unit_price":"100"},{"specifications":[{"id":"1","name":"color","selected_value":"green"},{"id":"2","name":"size","selected_value":"xl"},{"id":"3","name":"model","selected_value":"r15"}],"quantity":"22","unit_price":"122"}]';


        $this->form_validation->set_rules("product_id", "product_id", "required");
        $this->form_validation->set_rules("offer_id", "offer_id", "required");
        $this->form_validation->set_rules("product_name", "product_name", "required");
        $this->form_validation->set_rules("product_image", "product_image", "required");
        $this->form_validation->set_rules("supplier_company", "supplier_company", "required");
        $this->form_validation->set_rules("specifications", "specifications", "required");

        if ($this->form_validation->run() === false) {
            $output = array(
                "ws" => $ws,
                "status" => 0,
                "message" => "Invalid inputs"
            );
            $this->response($output, REST_Controller::HTTP_OK);
        } else {
            $product_id = $this->input->post('product_id');
            $offer_id = $this->input->post('offer_id');
            $product_name = $this->input->post('product_name');
            $product_image = $this->input->post('product_image');
            $supplier_company = $this->input->post('supplier_company');
            $specifications = $this->input->post('specifications');

            $specification = json_decode($specifications, true);

            $product_total_quantity = 0;


            //check LAST entry

            $tot_arr = count($specification);
            $pass_val = (int) $tot_arr - 1;


            $product_total_quantity = $specifications[$pass_val]['specifications']['total_quantity'];

            /*  for($i=0;$i<count($specifications);$i++)
              {
              $product_total_quantity=$product_total_quantity + $specifications[$i]->total_quantity;
              } */

            $specifications = json_encode($specification);


            $cart_data = array(
                "user_id" => $this->_payload->userid,
                "product_id" => $product_id,
                "offer_id" => $offer_id,
                "product_total_quantity" => $product_total_quantity,
                "product_name" => $product_name,
                "product_image" => $product_image,
                "supplierDetails" => $supplier_company,
                "specifications" => $specifications
            );

            $dat = $this->Cart_model->addToCartData($cart_data);
            if ($dat == 'ADD') {
                $msg = "Product has been added to cart successfully";
            } else {
                $msg = "Product has been Updated successfully";
            }
            $cart_grand_total = $this->Cart_model->getCartListGrandTotal($this->_payload->userid);

            $output["ws"] = $ws;
            $output["status"] = 1;
            $output["message"] = $msg;
            $output["cart_grand_total"] = $this->Product_model->getUsersCartItemsCountData($this->_payload->userid);
            $this->response($output, REST_Controller::HTTP_OK);
        }
    }

    public function getCartList_get() {
        $ws = $this->post("ws");

        if (empty($ws)) {
            $ws = "getCartList";
        }

        $data = $this->Cart_model->getCartListData($this->_payload->userid);

        //echo count($data);exit;

        for ($i = 0; $i < count($data); $i++) {
            $product_id = $data[$i]['product_id'];
            $user_id = $data[$i]['user_id'];
            $user_product_coupans = $this->Cart_model->user_product_coupans($user_id, $product_id);

            $product_data = $this->Cart_model->getCartProductData($data[$i]['product_id']);

            $product_cart_total = $this->Cart_model->getProductsCartTotal($this->_payload->userid, $data[$i]['product_id']);

            $offer_details = "";

            if ($data[$i]['offer_id'] != 0 || $data[$i]['offer_id'] != null) {
                $offer_details = $this->Offer_model->getOfferDetailsForOfferId($data[$i]['offer_id']);
            }
            //echo $data[1]['id'];exit;
            //print_r($product_data);exit;
            $data[$i]['product_name'] = $product_data['name'];
            $data[$i]['units_id'] = $product_data['product_prices'][$i]->units_id;
            $data[$i]['units_name'] = $product_data['product_prices'][$i]->units_name;
            $data[$i]['seller_company'] = $product_data['company_name'];
            $data[$i]['seller_id'] = $product_data['seller'];
            $data[$i]['seller_company_id'] = $product_data['seller_company_id'];
            $data[$i]['moq'] = $product_data['moq'];
            $data[$i]['product_cart_total'] = $product_cart_total;

            $data[$i]['currency_name'] = $product_data['currency_name'];
            $data[$i]['coupon_data'] = $user_product_coupans;

            if (!empty($data[$i]['specifications'])) {
                $data[$i]['specifications'] = json_decode($data[$i]['specifications'], true);

                if ($offer_details != NULL) {
                    //$product_data[$i]['product_prices'] =
                    $specs = $data[$i]['specifications'];
                    $unit_offer_price = $specs[0]['specifications']['unit_price'];
                    $product_data['product_prices'][0]->final_price = "" . $unit_offer_price;
                    $data[$i]['offer_expired_flag'] = false;
                    $data[$i]['offer_expired_msg'] = "";
                }
                if ($data[$i]['offer_id'] == 0) {
                    $data[$i]['offer_expired_flag'] = false;
                    $data[$i]['offer_expired_msg'] = "";
                }
                if ($offer_details == NULL && $data[$i]['offer_id'] != 0) {
                    $data[$i]['offer_expired_flag'] = true;
                    $data[$i]['offer_expired_msg'] = "Product Offer Has Expired!";
                }
            } else {
                $data[$i]['specifications'] = '';
            }

            $data[$i]['product_prices'] = $product_data['product_prices'];
        }

        $cart_grand_total = $this->Cart_model->getCartListGrandTotal($this->_payload->userid);
        //var_dump($data);
        $output["ws"] = $ws;
        $output["status"] = 1;
        $output["message"] = "list fetch success.";
        $output["cart_data"] = $data;
        $output["cart_grand_total"] = $cart_grand_total;
        //$this->response(json_decode(stripcslashes(json_encode($output,JSON_UNESCAPED_SLASHES))), REST_Controller::HTTP_OK);
        echo stripcslashes(json_encode($output, JSON_UNESCAPED_SLASHES));
    }

    public function removeFromCart_post() {
        $ws = $this->post("ws");

        if (empty($ws)) {
            $ws = "removeFromCart";
        }

        $this->form_validation->set_rules("product_id", "product_id", "required");

        if ($this->form_validation->run() === false) {
            $output = array(
                "ws" => $ws,
                "status" => 0,
                "message" => "Invalid inputs"
            );
            $this->response($output, REST_Controller::HTTP_OK);
        } else {
            $product_id = $this->input->post('product_id');
            $this->Cart_model->removeFromCartData($this->_payload->userid, $product_id);

            $output["ws"] = $ws;
            $output["status"] = 1;
            $output["message"] = "Product has been successfully removed from cart.";
            $this->response($output, REST_Controller::HTTP_OK);
        }
    }

    public function emptycart_get() {
        $output = [
            "ws" => "emptycart",
            "status" => 1,
            "message" => "Success",
        ];
        $user = $this->_payload->userid;
        $this->Cart_model->emptyUserCart($user);
        $this->response($output, REST_Controller::HTTP_OK);
    }

}
