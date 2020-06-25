<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Get_header_data 
{

    private $CI;

    public function __construct() 
    {
        $this->CI = &get_instance();
        $this->CI->load->database();
        $this->CI->load->model('Categories_model', '', TRUE);
        $this->CI->load->model('Order_model', '', TRUE);
        $this->CI->load->model('Common_model', '', TRUE);
        $this->CI->load->model('Users_model', '', TRUE);
        $this->CI->load->model('Inquiries_model', '', TRUE);
        $this->CI->load->model('Myfavourite_model', '', TRUE);
        $this->CI->load->model('Product_model', '', TRUE);
    }

    public function get_categories() 
    {
		
        $obj_cat_mdl = new Categories_model();
        /************** REMOVED FOR OPTIMIZATION **********************
        $parent_cats = $obj_cat_mdl->getRootCategories();
        $finalCats = array();
        foreach ($parent_cats as $parent) {
            $child_cats = $obj_cat_mdl->getImidiateChildCategories($parent->category_id, 10);
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
                //echo $title."<br>";
                $id = $child->category_id;
                $elements[$j]["id"] = $child->category_id;
                $elements[$j]["title"] = $child->categories_name;
                $subelements = $obj_cat_mdl->getImidiateChildCategories($child->category_id, 10);
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
        ******************* ADDED FOR OPTIMIZATION ****************/
        $tmp = $this->CI->db->select('category_data')->get("tmp_header_cat_data")->row_array();
        $finalCats = json_decode($tmp['category_data'],1);
        $data["categories"] = $finalCats;
        
        /********************* Upside Categories on Front ********************/
        //$data['up_categories'] = $obj_cat_mdl->getTopSellingCategories(6);

        /****************************** orders details *************************************/
        $user_id = $this->CI->session->userdata('user_id');
		if($user_id){
			$obj_order_mdl = new Order_model();
			$data['orders_count'] = $obj_order_mdl->order_details($user_id);
			$data['pending_payment'] = $obj_order_mdl->pending_order_count($user_id);
			$data['pending_confirmation'] = $obj_order_mdl->pending_confirmation_count($user_id);
		

			/******************************* get_favorite products ********************************/
			$obj_fav_mdl = new myfavourite_model();
			$favorite = $obj_fav_mdl->count_fav_products($user_id);
			if ($favorite) {
				$fav_array = json_decode($favorite->products);
				$data['fav_count'] = count($fav_array);
			} else {
				$data['fav_count'] = 0;
			}

			/******************************* Inquiries count ************************************ */
			$obj_inqry_mdl = new Inquiries_model();
            $obj_cmm_mdl = new Common_model();
			//$data['inquiry_count'] = count($obj_inqry_mdl->count_inquiries($user_id));
			$data['inquiry_count'] =$obj_cmm_mdl->getAll('inquiries',array('by_user'=>$user_id,'viewed_by_user'=>0))->num_rows();

			/****************************** Cart Products ************************************/
			$obj_product_mdl = new Product_model();
			$cart = $obj_product_mdl->getCartProducts($user_id);
			$data['cart_count'] = count($cart);
			$data['cart_products'] = $cart;
			
			/****************************** Buyer Notifications ************************************/
			$obj_Users_mdl = new Users_model();
			$notifctn = $obj_Users_mdl->get_user_notifications($user_id);
	
			$data['notifiction_count'] = count($notifctn);
			$data['notifications_list'] = array_reverse($notifctn);

            /****************************** favorite product ************************************/
            $res = $obj_fav_mdl->getUsersFavouritesProducts($user_id);
            $products = json_decode($res['products']);
            for ($i = 0; $i < count($products); $i++) {
                $favorite_prod[]= $obj_product_mdl->getfavProductDetails($products[$i]);
            }

            $data['favorite_prod'] = array_reverse($favorite_prod);
		}
        return $data;
    }

}