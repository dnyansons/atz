<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Categories_model extends CI_Model {

    private $_table;
    private $_tableDescription;
    private $_tableAtrributes;
    private $_tableSpecifications;

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->_table = "categories";
        $this->_tableDescription = "categories_description";
        $this->_tableAtrributes = "category_specific_attributes";
        $this->_tableSpecifications = "category_specific_specifications";
        $this->load->model('Categories_model');
        $this->load->model('Common_model');
    }

    public function getAll() {
        $this->db->select("C.category_id,C.parent_id,C.banner_image,C.categories_image,CD.categories_name");
        $this->db->join("$this->_tableDescription CD", "CD.categories_id = C.category_id");
        $this->db->order_by("CD.categories_name","ASC");
        $query = $this->db->get($this->_table . " C");
        return $query->result();
    }

    public function getCategoryById($id) {
        $this->db->select("C.category_id,C.parent_id,C.banner_image,C.categories_image,CD.categories_name");
        $this->db->join("$this->_tableDescription CD", "CD.categories_id = C.category_id");
        $query = $this->db->get_where($this->_table . " C ", array("category_id" => $id));
        return $query->row();
    }

    public function getRootCategories() {
        $this->db->select("C.category_id,CD.categories_name,C.categories_image");
        $this->db->join("$this->_tableDescription CD", "CD.categories_id = C.category_id");
        $this->db->order_by("C.sort_order", "ASC");
        $this->db->order_by("C.product_count", "DESC");
        $query = $this->db->get_where($this->_table . " C ", array("parent_id" => 1));
        return $query->result();
    }

    public function getFirstTwoLevelCategoriesData() {
        $this->db->select("C.category_id,C.parent_id,C.banner_image,C.categories_image,CD.categories_name");
        $this->db->join("$this->_tableDescription CD", "CD.categories_id = C.category_id");
        $this->db->where('parent_id=', 1);
        $query = $this->db->get($this->_table . " C ");
        return $query->result_array();
    }

    public function getMainCategories() {//api
        $this->db->select("C.category_id,C.parent_id,C.banner_image,C.categories_image,CD.categories_name");
        $this->db->join("$this->_tableDescription CD", "CD.categories_id = C.category_id");
        $this->db->order_by("C.sort_order", "ASC");
        $this->db->order_by("C.product_count", "DESC");
        $query = $this->db->get_where($this->_table . " C ", array("parent_id" => 1));
        $result = $query->result();

        foreach ($result as $res) {
            $res->categories_image = base_url() . "uploads/images/categories/" . $res->categories_image;
        }

        return $result;
    }

    public function getImidiateChildCategories($parent, $limit = 0) {
        if ($limit) {
            $this->db->limit($limit);
        }
        $this->db->select("C.category_id,C.parent_id,C.banner_image,C.categories_image,CD.categories_name");
        $this->db->join("$this->_tableDescription CD", "CD.categories_id = C.category_id");
        $this->db->order_by("C.sort_order", "ASC");
        $this->db->order_by("C.product_count", "DESC");
        $query = $this->db->get_where($this->_table . " C ", array("C.parent_id" => $parent));
        return $query->result();
    }

    public function getTopSellingCategories($limit = 0, $is_get_parent = 0) {
        if ($limit) {
            $this->db->limit($limit);
        }
        $this->db->select("C.category_id,CD.categories_name");
        $this->db->order_by("C.sales_count", "DESC");
        $this->db->order_by("C.product_count", "DESC");
        $this->db->join("$this->_tableDescription CD", "CD.categories_id = C.category_id");
        if ($is_get_parent ) {
            $this->db->where(["C.parent_id " => 1]);
        }  else {
           $this->db->where(["C.parent_id >" => 1]);
            $this->db->where(["C.parent_id <" => 14]);
        }

        $query = $this->db->get($this->_table . " C ");
        return $query->result();
    }
    
    public function getTopSellingCategoriesMidLevel($limit = 0, $is_get_parent = 0) {
        if ($limit) {
            $this->db->limit($limit);
        }
        $this->db->select("C.category_id,C.parent_id,C.banner_image,C.categories_image,CD.categories_name");
        $this->db->order_by("C.sort_order", "ASC");
        #$this->db->order_by("C.sales_count", "DESC");
        $this->db->order_by("C.product_count", "DESC");
        $this->db->join("$this->_tableDescription CD", "CD.categories_id = C.category_id");
        $this->db->where(["C.parent_id >" => 14]);
        $this->db->where(["C.parent_id <" => 47]);
        
        $query = $this->db->get($this->_table . " C ");
        return $query->result();
    }

    public function getTopSellingCategoriesLastLevel($limit = 0) {

        $this->db->select("category_id");
        $this->db->from($this->_table);
        $this->db->where('category_id > 48');

        $parent = $this->db->get();

        $categories = $parent->result();
        $i = 0;
        $j = 0;
        $categories_str = '';
        foreach ($categories as $p_cat) {
            //check in Product Count greater than 2 
            if ($j <= 10) {
                $this->db->select('id');
                $this->db->from('product_details');
                $this->db->where('category', $p_cat->category_id);
                $dat = $this->db->get()->num_rows();

                if ($dat >= 10) {
                    $j++;
                    $categories_str = $categories_str . "," . $p_cat->category_id . $this->getAllChilds_Combined($p_cat->category_id);
                }
            }
            $i++;
        }
        //$res = $this->Categories_model->getAllChilds(16);

        $catIds = explode(",", $categories_str);
        //array_shift($catIds);
        //echo'<pre>';
        //print_r($catIds);
        //exit;
        $this->db->select("C.category_id,C.parent_id,C.banner_image,C.categories_image,CD.categories_name");
        $this->db->order_by("C.sales_count", "DESC");
        $this->db->join("$this->_tableDescription CD", "CD.categories_id = C.category_id");
        $this->db->where_in('category_id', $catIds);
        $query = $this->db->get($this->_table . " C ");

        return $query->result();
        // print_r($query->result());
        // exit;
    }

    public function get_categories_by_parent($parent) {

        $this->db->select('t1.category_id,t1.categories_image,t2.categories_name');
        $this->db->from($this->_table . " t1 ");
        $this->db->join($this->_tableDescription . " t2 ", "t1.category_id = t2.categories_id");
        $this->db->where('t1.parent_id', $parent);
        $this->db->order_by("t1.sort_order", "ASC");
        $this->db->order_by("t1.product_count", "DESC");

        $parent = $this->db->get();

        $categories = $parent->result();
        $i = 0;
        foreach ($categories as $p_cat) {

            $categories[$i]->sub = $this->sub_categories($p_cat->category_id);
            $i++;
        }
        return $categories;
    }

    public function getAllParentCategoriesByChildCategory($child_category_id) {
        $this->db->select('C1.category_id as self_category_id,
        CD1.categories_name as self_category_name,
        C2.category_id as level1parentid,
        CD2.categories_name as level1parent,
        C3.category_id as level2parentid,
        CD3.categories_name as level2parent,
        C4.category_id as level3parentid,
        CD4.categories_name as level3parent');
        $this->db->from('categories C1');
        $this->db->join('categories_description CD1', 'CD1.categories_id = C1.category_id', "left");
        $this->db->join('categories C2', 'C2.category_id = C1.parent_id', "left");
        $this->db->join('categories_description CD2', 'C2.category_id = CD2.categories_id', "left");
        $this->db->join('categories C3', 'C3.category_id = C2.parent_id', "left");
        $this->db->join('categories_description CD3', 'C3.category_id = CD3.categories_id', "left");
        $this->db->join('categories C4', 'C4.category_id = C3.parent_id', "left");
        $this->db->join('categories_description CD4', 'C4.category_id = CD4.categories_id', "left");
        $this->db->where('C1.category_id', $child_category_id);
        $query = $this->db->get();
        $result = $query->row();

        return $result;
    }

    public function getAllChildCategoriesByParentCategory1($parent_category_id) {
        /* $this->db->select('C1.category_id as level3parentid,
          CD1.categories_name as level3parent,
          C2.category_id as level2parentid,
          CD2.categories_name as level2parent,
          C3.category_id as level1parentid,
          CD3.categories_name as level1parent,
          C4.category_id as self_cat_id,
          CD4.categories_name as self_cat_name');
          $this->db->from('categories C1');
          $this->db->join('categories_description CD1', 'CD1.categories_id = C1.category_id',"left");
          $this->db->join('categories C2', 'C2.category_id = C1.parent_id',"left");
          $this->db->join('categories_description CD2', 'C2.category_id = CD2.categories_id',"left");
          $this->db->join('categories C3', 'C3.category_id = C2.parent_id',"left");
          $this->db->join('categories_description CD3', 'C3.category_id = CD3.categories_id',"left");
          $this->db->join('categories C4', 'C4.category_id = C3.parent_id',"left");
          $this->db->join('categories_description CD4', 'C4.category_id = CD4.categories_id',"left");
          $this->db->where('C4.category_id', $parent_category_id);
          $query=$this->db->get();

          $result=$query->result_array();
          return $result; */

        $this->db->select('t1.category_id,t2.categories_name');
        $this->db->from($this->_table . " t1 ");
        $this->db->join($this->_tableDescription . " t2 ", "t1.category_id = t2.categories_id");
        $this->db->where('t1.parent_id', $parent_category_id);

        $parent = $this->db->get();

        $categories = $parent->result_array();

        $i = 0;
        foreach ($categories as $p_cat) {

            $categories[$i]['sub'] = $this->sub_categories($p_cat['category_id']);
            $i++;
        }
        return $categories;
    }

    public function get_categories() {

        $this->db->select('t1.category_id,t2.categories_name');
        $this->db->from($this->_table . " t1 ");
        $this->db->join($this->_tableDescription . " t2 ", "t1.category_id = t2.categories_id");
        $this->db->where('t1.parent_id > 1');
        $this->db->order_by("t1.sort_order", "ASC");
        $this->db->order_by("t1.product_count", "DESC");

        $parent = $this->db->get();

        $categories = $parent->result();
        $i = 0;
        foreach ($categories as $p_cat) {

            $categories[$i]->sub = $this->sub_categories($p_cat->category_id);
            $i++;
        }
        return $categories;
    }

    public function sub_categories($id) {

        $this->db->select('t1.category_id,t1.categories_image,t2.categories_name');
        $this->db->from($this->_table . " t1 ");
        $this->db->join($this->_tableDescription . " t2 ", "t1.category_id = t2.categories_id");
        $this->db->where('t1.parent_id', $id);
        $this->db->order_by("t1.sort_order", "ASC");
        $this->db->order_by("t1.product_count", "DESC");

        $child = $this->db->get();
        $categories = $child->result();

        return $categories;
    }

    /*
     * Following functions are added to use with server side datatables
     */

    function allcategory_count() {
        $query = $this
                ->db
                ->where(["category_id >" => 13])
                ->get($this->_table);

        return $query->num_rows();
    }

    function allcategory($limit, $start, $col, $dir) {
        $query = $this
                ->db
                ->select("t1.category_id,t2.categories_name, IFNULL(t3.categories_name,'DEFAULT') as parent_name")
                ->limit($limit, $start)
                ->order_by($col, $dir)
                ->join($this->_tableDescription . " t2 ", "t2.categories_id = t1.category_id")
                ->join($this->_tableDescription . " t3 ", "t3.categories_id = t1.parent_id", "LEFT")
                ->where(["t1.category_id >" => 13])
                ->get($this->_table . " t1 ");

        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return null;
        }
    }

    function category_search($limit, $start, $search, $col, $dir) {
        $query = $this
                ->db
                ->select("t1.category_id,t2.categories_name, IFNULL(t3.categories_name,'DEFAULT') as parent_name")
                ->like('t1.category_id', $search)
                ->or_like('t2.categories_name', $search)
                ->join($this->_tableDescription . " t2 ", "t2.categories_id = t1.category_id")
                ->join($this->_tableDescription . " t3 ", "t3.categories_id = t1.parent_id", "LEFT")
                ->where(["t1.category_id >" => 13])
                ->limit($limit, $start)
                ->order_by($col, $dir)
                ->get($this->_table . " t1 ");


        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return null;
        }
    }

    function category_search_count($search) {
        $query = $this
                ->db
                ->like('t1.category_id', $search)
                ->or_like('t2.categories_name', $search)
                ->join($this->_tableDescription . " t2 ", "t2.categories_id = t1.category_id")
                ->get($this->_table . " t1 ");

        return $query->num_rows();
    }

    public function getDistinctCategories() {
        $this->db->distinct();
        $this->db->select('a.category_id, b.categories_name', false);
        $this->db->from('categories as a');
        $this->db->join('categories_description as b', 'a.category_id=b.categories_id');
        $this->db->order_by("a.sort_order", "ASC");
        $this->db->order_by("a.product_count", "DESC");
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }

    public function addCategory($data) {
        $this->db->insert('categories', $data);
        return $this->db->insert_id();
    }

    public function addCategoryDesc($data) {
        $this->db->insert('categories_description', $data);
        return $this->db->insert_id();
    }

    public function updateCategoryData($data) {

        $this->db->set('parent_id', $data['parent_id']);
        $this->db->set('sort_order', $data['sort_order']);

        if (isset($data['categories_image']) && $data['categories_image'] != "") {
            $this->db->set('categories_image', $data['categories_image']);
        }
        if (isset($data['banner_image']) && $data['banner_image'] != "") {
            $this->db->set('banner_image', $data['banner_image']);
        }

        $this->db->set('seo_title', $data['seo_title']);
        $this->db->set('seo_description', $data['seo_description']);
        $this->db->set('seo_keywords', $data['seo_keywords']);
        $this->db->set('seo_url', $data['seo_url']);


        $this->db->set('last_modified', date('Y-m-d H:i:s'));
        $this->db->where('category_id', $data['categories_id']);
        $this->db->update('categories');

        $this->db->set('categories_name', $data['categories_name']);
        $this->db->where('categories_id', $data['categories_id']);
        $this->db->update('categories_description');

        return TRUE;
    }

    public function deleteCategoryData($category_id) {
        $this->db->where('categories_id', $category_id);
        $this->db->delete('categories_description');

        $this->db->where('category_id', $category_id);
        $this->db->delete('categories');

        return TRUE;
    }

    public function getCategoryData($category_id) {
        $this->db->select('a.category_id, b.categories_name,a.parent_id, a.sort_order, a.categories_image,a.banner_image,a.seo_title, a.seo_description, a.seo_keywords, a.seo_url', false);
        $this->db->from('categories as a');
        $this->db->where('a.category_id', $category_id);
        $this->db->join('categories_description as b', 'a.category_id=b.categories_id');
        $query = $this->db->get();
        $result = $query->row();
        return $result;
    }

    /*
     * @param Int cat_id
     * @return Array of Objects of attributes
     */

    public function getCategoryAttributes($cat_id) {
        $query = $this->db
                ->select("*")
                ->from($this->_tableAtrributes)
                ->where(["category_id" => $cat_id])
                ->get();
        return $query->result();
    }

    public function addAttribute($data) {
        $this->db->insert($this->_tableAtrributes, $data);
        return $this->db->insert_id();
    }

    public function addSpecs($data) {
        $this->db->insert($this->_tableSpecifications, $data);
        return $this->db->insert_id();
    }

    /*
     * @desc function is used to get categories at level 3 
     */

    public function getBasicCategories() {
        $this->db->select("C.category_id,C.parent_id,CD.categories_name");
        $this->db->join("$this->_tableDescription CD", "CD.categories_id = C.category_id");
        $this->db->where(array("parent_id >" => 1));
        $this->db->where(array("parent_id <" => 14));
        $this->db->order_by("C.sort_order", "ASC");
        $this->db->order_by("C.product_count", "DESC");
        $query = $this->db->get($this->_table . " C ");
        return $query->result();
    }

    public function top_sub_categories_by_parent($limit, $parent) {
        if ($limit <> '') {
            $this->db->limit(1);
        } else {
            $this->db->limit(8);
        }
        $this->db->select('t1.category_id,t2.categories_name, t1.categories_image');
        $this->db->from($this->_table . " t1 ");
        $this->db->join($this->_tableDescription . " t2 ", "t1.category_id = t2.categories_id");
        $this->db->where('t1.parent_id', $parent);
        $this->db->order_by('t1.sort_order', "ASC");
        $parent_dat = $this->db->get()->result_array();
        $arr = array();
        $i = 0;

        foreach ($parent_dat as $par) {
            //get Min and Max Discount
            $this->db->select('category_id');
            $this->db->from('categories');
            $this->db->where('parent_id', $par['category_id']);
            $dat = $this->db->get()->result();

            $asarr = [];
            foreach ($dat as $so) {
                $asarr[] = $so->category_id;
            }
            if (empty($asarr)) {
                //calculate for direct ID`s
                $this->db->select('MIN(`discount_percentage`)min_dis, MAX(`discount_percentage`)max_dis');
                $this->db->from('product_details');
                $this->db->where_in('category', $par['category_id']);
                $dis = $this->db->get()->row();

                $max = $dis->max_dis;
            } else {
                //calculate for Parent ID`s
                $this->db->select('MIN(`discount_percentage`)min_dis, MAX(`discount_percentage`)max_dis');
                $this->db->from('product_details');
                $this->db->where_in('category', $asarr);
                $dis = $this->db->get()->row();

                $max = $dis->max_dis;
            }

            $arr[$i]['category_id'] = $par['category_id'];
            $arr[$i]['categories_name'] = $par['categories_name'];
            $arr[$i]['categories_image'] = $par['categories_image'];
            $arr[$i]['min_dis'] = $dis->min_dis;
            $arr[$i]['max_dis'] = $max;


            $i++;
        }

        usort($arr, function($a, $b) {
            return $b['max_dis'] <=> $a['max_dis'];
        });

        return $arr;
    }

    public function getCategorySpecifications($cat_id) {
        $this->db->where(["category_id" => $cat_id]);
        $query = $this->db->get($this->_tableSpecifications);
        return $query->result();
    }

    public function getProductsCategoryAttributes($attribute_id, $product_id) {
        $this->db->select("a.attribute_value");
        $this->db->from('product_attributes as a');
        $this->db->join('category_specific_attributes as b', 'a.attribute_id=b.id');
        $this->db->where("a.attribute_id", $attribute_id);
        $this->db->where("a.product_id", $product_id);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function getProductsCategorySpecifications($spec_id, $product_id) {
        $this->db->select("a.spec_value");
        $this->db->from('product_specifications as a');
        $this->db->join('category_specific_specifications as b', 'a.spec_id=b.id');
        $this->db->where("a.spec_id", $spec_id);
        $this->db->where("a.product_id", $product_id);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function getCategoryDesc($search) {

        $this->db->select("categories_name as category, categories_id as category_id");
        $this->db->like('categories_name', $search, 'both');
        $query = $this->db->get($this->_tableDescription);
        return $query->result();
        
    }
    
    
    function smart_search_result($search)
    {
        $this->db->select("CD.categories_name as category,CD.categories_id as category_id,C.parent_id as parent_id, CD1.categories_name as parent_name");
        $this->db->from("categories_description CD");
        $this->db->like("CD.categories_name",$search);
        $this->db->or_like("C.seo_keywords",$search);
        $this->db->join("categories C","CD.categories_id = C.category_id");
        $this->db->join("categories_description CD1","C.parent_id = CD1.categories_id");
        $this->db->order_by("C.product_count","DESC");
        $this->db->limit(10);
        $query = $this->db->get();
        $cats=$query->result();
        
        $result = [];
        foreach($cats as $cat){
            $result[] = [
                //"type" => "category",
                "category" => $cat->category.'___'.$cat->parent_name,
                "category_id" => $cat->category_id,
                //"parent_id" => $cat->parent_id,
                //"parent_name" => $cat->parent_name,
            ];
        }
        return $result;
    }

    public function getParentsByChild($child_category_id) {
        $this->db->select('C1.category_id as child,C2.category_id as parent, C3.category_id as super_parent, C4.category_id as root');
        $this->db->from('categories C1');
        $this->db->join('categories C2', 'C2.category_id = C1.parent_id', "left");
        $this->db->join('categories C3', 'C3.category_id = C2.parent_id', "left");
        $this->db->join('categories C4', 'C4.category_id = C3.parent_id', "left");
        $this->db->where('C1.category_id', $child_category_id);
        $query = $this->db->get();
        $result = $query->row();
        return $result;
    }

    // public function getParentsCatNameByChild($child_category_id)
    // {
    // $this->db->select('Cd3.categories_name as cat_name3, Cd2.categories_name as cat_name2 ,Cd1.categories_name as cat_name1');
    // $this->db->from('categories C1');
    // $this->db->join('categories C2', 'C2.category_id = C1.parent_id',"left");
    // $this->db->join('categories C3', 'C3.category_id = C2.parent_id',"left");
    // $this->db->join('categories C4', 'C4.category_id = C3.parent_id',"left");
    // $this->db->join('categories_description Cd1', 'C1.category_id = Cd1.id',"left");
    // $this->db->join('categories_description Cd2', 'C2.category_id = Cd2.id',"left");
    // $this->db->join('categories_description Cd3', 'C3.category_id = Cd3.id',"left");
    // $this->db->join('categories_description Cd4', 'C4.category_id = Cd4.id',"left");
    // $this->db->where('C1.category_id', $child_category_id);
    // $query=$this->db->get();
    // $result=$query->row();
    // return $result;
    // }

    public function get_categoryName($cat_id) {
        $this->db->select('t1.category_id,t2.categories_name');
        $this->db->from($this->_table . " t1 ");
        $this->db->join($this->_tableDescription . " t2 ", "t1.category_id = t2.categories_id");
        $this->db->where('t1.category_id', $cat_id);
        return $this->db->get()->row_array();
    }

    /*
     * Recursive function to get all child categories
     * @param Integer parent category id
     * @return String comma separeated list of child category ids
     */

    public function getAllChilds($parent) {
        $this->db->select("category_id");
        $this->db->from($this->_table);
        $this->db->where('parent_id', $parent);

        $parent = $this->db->get();

        $categories = $parent->result();
        $i = 0;

        foreach ($categories as $p_cat) {
            //check in Product Count greater than 2 

            $this->db->select('id');
            $this->db->from('product_details');
            $this->db->where('category', $p_cat->category_id);
            $dat = $this->db->get()->num_rows();

            $categories_str = $categories_str . "," . $p_cat->category_id . $this->getAllChilds($p_cat->category_id);

            $i++;
        }
        return $categories_str;
    }

    public function getAllChilds_Combined($parent) {
        $this->db->select("category_id");
        $this->db->from($this->_table);
        $this->db->where('parent_id', $parent);

        $parent = $this->db->get();

        $categories = $parent->result();
        $i = 0;
        $j = 0;
        foreach ($categories as $p_cat) {
            //check in Product Count greater than 2 
            if ($j <= 5) {
                $this->db->select('id');
                $this->db->from('product_details');
                $this->db->where('category', $p_cat->category_id);
                $dat = $this->db->get()->num_rows();

                if ($dat >= 2) {
                    $j++;
                    $categories_str = $categories_str . "," . $p_cat->category_id . $this->getAllChilds_Combined($p_cat->category_id);
                }
            }
            $i++;
        }
        return $categories_str;
    }

    public function getCategoryName($cat_id) {
        $this->db->select("id,categories_name");
        $this->db->from("categories_description");
        $this->db->where("categories_id", $cat_id);
        $query = $this->db->get();
         $result = $query->row_array();
          return $result;
    }

    public function getSearch($name) {
        $select = $this->db->query("SELECT categories_id as id,categories_name FROM categories_description WHERE categories_name LIKE '%" . $name . "%' limit 10");
        return $select->result_array();
    }

    public function incrementProductCount($ids) {
        $this->db->where_in("category_id", $ids);
        $this->db->set("product_count", "product_count + 1", false);
        $this->db->update($this->_table);
    }

    function getProductIds($order_id) {
        $this->db->select('products_id');
        $this->db->from('orders_products');
        $this->db->where('orders_id', $order_id);
        return $this->db->get()->result();
    }

    function getCategoryIds($prod_id) {
        $this->db->select('category');
        $this->db->from('product_details');
        $this->db->where('id', $prod_id);
        $dat = $this->db->get()->row();
        return $cat_id = $dat->category;
    }

    public function getSpecificationById($id) {
        $this->db->where(["id" => $id]);
        $query = $this->db->get($this->_tableSpecifications);
        return $query->row();
    }

    public function getAttributeById($id) {
        $this->db->where(["id" => $id]);
        $query = $this->db->get($this->_tableAtrributes);
        return $query->row();
    }

    public function updateSpecs($id, $data) {
        $this->db->where(["id" => $id]);
        $this->db->update($this->_tableSpecifications, $data);
    }

    public function updateAttrs($id, $data) {
        $this->db->where(["id" => $id]);
        $this->db->update($this->_tableAtrributes, $data);
    }

    public function removeAttr($id) {
        $this->db->where(["id" => $id]);
        $this->db->delete($this->_tableAtrributes);
    }

    public function removeSpec($id) {
        $this->db->where(["id" => $id]);
        $this->db->delete($this->_tableSpecifications);
    }
    
    public function get_category_by_name($name)
    {
        $this->db->where(["categories_name"=>$name]);
        $query = $this->db->get($this->_tableDescription);
        return $query->row();
    }

    public function get_sub_categories($category_id)
    {
        $this->db->select('t1.category_id,t1.categories_image,t2.categories_name');
        $this->db->from("categories t1 ");
        $this->db->join("categories_description t2 ", "t1.category_id = t2.categories_id");
        $this->db->where('t1.parent_id', $category_id);
        $this->db->order_by("t1.sort_order", "ASC");
        $this->db->order_by("t1.product_count", "DESC");

         $child = $this->db->get();
        $categories = $child->result();
        return $categories;
    }
    
    public function getHomePageCategories($limit = 3)
    {
        if ($limit) {
            $this->db->limit($limit);
        }
        $this->db->select("C.category_id,CD.categories_name");
        $this->db->order_by("C.sort_order", "ASC");
        #$this->db->order_by("C.sales_count", "DESC");
        $this->db->order_by("C.product_count", "DESC");
        $this->db->join("$this->_tableDescription CD", "CD.categories_id = C.category_id");
        $this->db->join("category_tohome CH", "CH.category = C.category_id");
        
        
        $query = $this->db->get($this->_table . " C ");
        return $query->result();
    }
    
    public function get_top_subcategories($parent,$limit = 8)
    {
        $this->db->select("C.category_id,CD.categories_name,C.categories_image,MAX(P1.discount_percentage) max_dis");
        $this->db->from("$this->_table C");
        $this->db->join("$this->_tableDescription CD","CD.categories_id = C.category_id");
        $this->db->join("product_details P1","C.category_id = P1.category","LEFT");
        $this->db->where_in("C.parent_id", $parent);
        $this->db->order_by('C.sort_order', "ASC");
        $this->db->group_by('C.category_id');
        $this->db->limit($limit);
        $query = $this->db->get();
        return $query->result_array();
    }

}
