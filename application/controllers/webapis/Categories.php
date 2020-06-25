<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Categories extends REST_Controller 
{
    public function __construct($config = 'rest') 
    {
        $method = $_SERVER['REQUEST_METHOD'];
        if ($method == "OPTIONS") {
            die();
        }
        parent::__construct($config);
        $this->load->model("Categories_model");
        $this->load->library("form_validation");
    }

    public function list_get() 
    {
        $ws = $this->get("ws");

        if (empty($ws)) {
            $ws = "list";
        }

        $output = array(
            "ws" => $ws,
            "status" => 1,
            "message" => "Success"
        );

        $parent_cats = $this->Categories_model->getRootCategories();
        //echo count($parent_cats);
       // echo $this->db->last_query();
        
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
                $img=$parent->categories_image;
                $elements[$j]["id"] = $child->category_id;
                $elements[$j]["image"] = $child->categories_image;
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
            $finalCats[] = array("title" => str_replace("/", " / ", $title), "image"=>$img, "elements" => $elements);
            $i++;
        }
        //var_dump($finalCats);
        //array_shift($finalCats);
        //array_shift($finalCats);
        $output["items"] = $finalCats;
 //echo'<pre>';
          //  print_r($finalCats);
           // exit;
        $this->response($output, REST_Controller::HTTP_OK);
    }

    public function all_get() 
    {
        $ws = $this->get("ws");

        if (empty($ws)) {
            $ws = "all";
        }

        $root = $this->Categories_model->getRootCategories();
        $finalcats = array();
        foreach ($root as $rt) {
            $cats = $this->Categories_model->get_categories_by_parent($rt->category_id);
            $finalCats[] = array(
                "id" => $rt->category_id,
                "title" => $rt->categories_name,
                "elements" => $cats,
            );
        }
        $output = array(
            "ws" => $ws,
            "status" => 1,
            "message" => "Success",
            "root" => $root,
            "all" => $finalCats
        );


        $this->response($output, REST_Controller::HTTP_OK);
    }

    public function getRootCateories_get() 
    {
        
        $ws = $this->get("ws");

        if (empty($ws)) {
            $ws = "getRootCateories";
        }

        $output = array(
            "ws" => $ws,
            "status" => 1,
            "message" => "Success"
        );

        $maincategories = $this->Categories_model->getMainCategories();
        $output["items"] = $maincategories;
        $this->response($output, REST_Controller::HTTP_OK);
    }

    public function getImmediateChildCategories_post() 
    {
        $ws = $this->post("ws");

        if (empty($ws)) {
            $ws = "getImmediateChildCategories";
        }

        $output = array(
            "ws" => $ws,
            "status" => 1,
            "message" => "Success"
        );

        $this->form_validation->set_rules("category_id", "Category", "required");
        if ($this->form_validation->run() === false) {
            $this->response($output, REST_Controller::HTTP_OK);
        } else {
            $category_id = $this->post('category_id');
            $ImidiateChildCategories = $this->Categories_model->getImidiateChildCategories($category_id);

            foreach ($ImidiateChildCategories as $imc) {
                $imc->categories_image = $imc->categories_image;
            }

            $output["items"] = $ImidiateChildCategories;
            $this->response($output, REST_Controller::HTTP_OK);
        }
    }

    public function getFirstTwoLevelCategories_get() 
    {
        $ws = $this->post("ws");

        if (empty($ws)) {
            $ws = "getFirstTwoLevelCategories";
        }

        $output = array(
            "ws" => $ws,
            "status" => 1,
            "message" => "Success"
        );


        $getFirstTwoLevelCategories = $this->Categories_model->getFirstTwoLevelCategoriesData();

        

        foreach ($getFirstTwoLevelCategories as $key => $tlc) {

            $getFirstTwoLevelCategories[$key]['categories_image'] = $tlc['categories_image'];
            if ($tlc['parent_id'] == 1) {
                $childcategories = $this->Categories_model->getImidiateChildCategories($tlc['category_id']);
                //$childcategories = (array) $childcategories;

//                foreach ($childcategories as $ccat) {
//                    $ccat->categories_image = $ccat->categories_image;
//                }

                $getFirstTwoLevelCategories[$key]['subcategories'] = $childcategories;
            }
        }

        

        $output["items"] = $getFirstTwoLevelCategories;
        $this->response($output, HTTP_OK);
    }



    public function markets_get() 
    {
        $ws = $this->get("ws");

        if (empty($ws)) {
            $ws = "markets";
        }

        $output = array(
            "ws" => $ws,
            "status" => 1,
            "message" => "Success"
        );
        $categories = $this->Categories_model->getTopSellingCategories(8);
        $items = array();
        $i = 0;
        foreach ($categories as $cat):
            $items[$i]["title"] = $cat->categories_name;
            $items[$i]["id"] = $cat->category_id;
            $i++;
        endforeach;
        $output["items"] = $items;
        $this->response($output, REST_Controller::HTTP_OK);
    }


    public function category_details_post() 
    {
        $ws = $this->post("ws");

        if (empty($ws)) {
            $ws = "category_details";
        }


        $output = [
            "ws" => $ws,
            "status" => 0,
            "message" => "Invalid inputs"
        ];

        $this->form_validation->set_rules("category_id", "Category", "required");
        if ($this->form_validation->run() === false) {
            $this->response($output, HTTP_OK);
        } else {
            $category_id = $this->post("category_id");
            $categories = $this->Categories_model->getImidiateChildCategories($category_id);
            $catDesc = $this->Categories_model->getCategoryById($category_id);
            $category_description = array();
            foreach ($categories as $cat):
                $category_description[] = array(
                    "id" => $cat->category_id,
                    "title" => $cat->category_id,
                    "image" => base_url() . "uploads/images/categories/" . $cat->categories_image,
                );
            endforeach;

            $category = [
                "id" => $catDesc->category_id,
                "title" => $catDesc->categories_name,
                "description" => $catDesc->seo_description,
                "image" => base_url() . "uploads/images/categories/" . $catDesc->categories_image,
                "elements" => $category_description,
            ];
            $output["status"] = 1;
            $output["message"] = "Success";
            $output["category"] = $category;
            $this->response($output, REST_Controller::HTTP_OK);
        }
    }

}
