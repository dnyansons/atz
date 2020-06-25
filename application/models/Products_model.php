<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Products_model extends CI_Model 
{

    private $_table, $_tableDescription, $_tableManufacturer;

    public function __construct() {
        parent::__construct();
        $this->_table = "products";
        $this->_tableDescription = "products_description";
        $this->_user = "users";
    }

    
    /*
     * Following functions are added to use with server side datatables
     */

    public function getAll()
    {
        $this->db->select('a.products_id, a.products_image, a.products_price, a.products_status, b.products_name');
        $this->db->from('products as a');
        $this->db->join('products_description as b', 'a.products_id = b.products_id', 'INNER');
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }
    public function getRandomProducts($limit = 100)
    {
        $this->db->limit($limit);
        $this->db->select('a.products_id, a.products_image, a.products_price, a.products_status, b.products_name');
        $this->db->from('products as a');
        $this->db->join('products_description as b', 'a.products_id = b.products_id', 'INNER');
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }


    function allproducts_count($supplier = 0)
    {
        $this->db->select('a.products_id, a.products_image, a.products_price, a.products_status, b.products_name');
        $this->db->from('products as a');
        $this->db->join('products_description as b', 'a.products_id = b.products_id', 'LEFT');
        if ($supplier != 0) {
            $this->db->where("a.seller = " . $supplier);
        }
        $query = $this->db->get();
        return $query->num_rows();
    }



    function allproducts($limit, $start, $col, $dir, $supplier = 0)
    {
        $this->db->select('a.products_id, a.products_image, a.products_price, a.products_status, b.products_name');
        $this->db->from('products as a');
        $this->db->limit($limit, $start);
        $this->db->order_by($col, $dir);
        if ($supplier != 0) {
            $this->db->where("a.seller = " . $supplier);
        }
        $this->db->join('products_description as b', 'a.products_id = b.products_id', 'LEFT');
        $query = $this->db->get();


        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return null;
        }
    }


    function product_search($limit, $start, $search, $col, $dir, $supplier = 0)
    {

        $this->db->select('a.products_id, a.products_image, a.products_price, a.products_status, b.products_name');
        $this->db->like('a.products_id', $search);
        $this->db->or_like('b.products_name', $search);
        $this->db->from("products a ");
        $this->db->join('products_description as b', 'a.products_id = b.products_id', 'LEFT');
        $this->db->limit($limit, $start);
        if ($supplier != 0) {
            $this->db->where("a.seller = " . $supplier);
        }
        $this->db->order_by($col, $dir);
        $query = $this->db->get();


        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return null;
        }
    }


    function product_search_count($search, $supplier = 0)
    {
        $this->db->select('a.products_id, a.products_image, a.products_price, a.products_status, b.products_name');
        $this->db->like('a.products_id', $search);
        $this->db->or_like('b.products_name', $search);
        $this->db->from("products a ");
        $this->db->join('products_description as b', 'a.products_id = b.products_id', 'LEFT');
        $this->db->limit($limit, $start);
        if ($supplier != 0) {
            $this->db->where("a.seller = " . $supplier);
        }
        $this->db->order_by($col, $dir);
        $query = $this->db->get();

        return $query->num_rows();
    }


    //--------------- BELOW FUNCTIONS ARE USED FOR PRODUCT ADD -------------

    public function addProduct($productData) 
    {
        $this->db->insert('products', $productData);

        return $this->db->insert_id();
    }

    public function addProductDesc($descData) 
    {
        $this->db->insert('products_description', $descData);
        return $this->db->insert_id();
    }


    public function addProducttoCategory($ProducttoCategory_data) 
    {
        $this->db->insert('products_to_categories', $ProducttoCategory_data);
        return TRUE;
    }

    public function addProducttoCollection($products_to_collections_table_data) {
        $this->db->insert('products_to_collections', $products_to_collections_table_data);
        return TRUE;
    }

    public function addProductOptions($productOptionsData) {
        $count = count($productOptionsData['option_name']);

        for ($i = 0; $i < $count; $i++) {

            $this->db->set('products_id', $productOptionsData['products_id']);
            $this->db->set('option_name', $productOptionsData['option_name'][$i]);
            $this->db->set('option_value', $productOptionsData['option_value'][$i]);
            $this->db->insert('products_options');
        }

        return true;
    }


    public function addProductAttributes($products_attributes_values_table_data) {
        $count = count($products_attributes_values_table_data['product_attribute_name']);

        for ($i = 0; $i < $count; $i++) {

            $this->db->set('products_id', $products_attributes_values_table_data['products_id']);
            $this->db->set('product_attribute_name', $products_attributes_values_table_data['product_attribute_name'][$i]);
            $this->db->set('product_attribute_value', $products_attributes_values_table_data['product_attribute_value'][$i]);
            $this->db->insert('products_attributes');
        }

        return true;
    }


    public function addProductImages($products_images_table_data) {
        $count = count($products_images_table_data['products_image']);

        for ($i = 0; $i < $count; $i++) {

            $this->db->set('products_id', $products_images_table_data['products_id']);
            $this->db->set('products_image', $products_images_table_data['products_image'][$i]);
            $this->db->set('products_image_sort_order', $products_images_table_data['products_image_sort_order'][$i]);
            $this->db->insert('products_images');

            if ($i == 0) {
                $this->db->set('products_image', $products_images_table_data['products_image'][$i]);
                $this->db->where('products_id', $products_images_table_data['products_id']);
                $this->db->update('products');
            }
        }


        return true;
    }


    public function addProductVideos($products_videos_table_data) {
        $this->db->set($products_videos_table_data);
        $this->db->insert('products_videos');
    }


    public function addProductDiscount($products_discounts_table_data) {
        $this->db->set($products_discounts_table_data);
        $this->db->insert('products_discounts');
    }


    public function updateProduct($productData, $products_id) {
        $this->db->where('products_id', $products_id);
        $this->db->update('products', $productData);
        return true;
    }


    public function updateProductDesc($descData, $products_id) {
        $this->db->where('products_id', $products_id);
        $this->db->update('products_description', $descData);
        return true;
    }


    public function updateProducttoCategory($ProducttoCategory_data, $products_id) {
        $this->db->where('products_id', $products_id);
        $this->db->update('products_to_categories', $ProducttoCategory_data);
        return TRUE;
    }


    public function updateProducttoCollection($products_to_collections_table_data, $products_id) {
        $this->db->where('product_id', $products_id);
        $this->db->update('products_to_collections', $products_to_collections_table_data);
        return TRUE;
    }

    public function updateProductOptions($productOptionsData, $products_id) {
        $this->db->where('products_id', $products_id);
        $this->db->delete('products_options');

        $count = count($productOptionsData['option_name']);

        for ($i = 0; $i < $count; $i++) {

            $this->db->set('products_id', $productOptionsData['products_id']);
            $this->db->set('option_name', $productOptionsData['option_name'][$i]);
            $this->db->set('option_value', $productOptionsData['option_value'][$i]);
            $this->db->insert('products_options');
        }

        return true;
    }


    public function updateProductAttributes($products_attributes_values_table_data, $products_id) {

        $this->db->where('products_id', $products_id);
        $this->db->delete('products_attributes');

        $count = count($products_attributes_values_table_data['product_attribute_name']);

        for ($i = 0; $i < $count; $i++) {

            $this->db->set('products_id', $products_attributes_values_table_data['products_id']);
            $this->db->set('product_attribute_name', $products_attributes_values_table_data['product_attribute_name'][$i]);
            $this->db->set('product_attribute_value', $products_attributes_values_table_data['product_attribute_value'][$i]);
            $this->db->insert('products_attributes');
        }

        return true;
    }


    public function updateProductImages($products_images_table_data, $products_id) {

        $this->db->where('products_id', $products_id);
        $this->db->delete('products_images');

        $count = count($products_images_table_data['products_image']);


        for ($i = 0; $i < $count; $i++) {

            $this->db->set('products_id', $products_images_table_data['products_id']);
            $this->db->set('products_image', $products_images_table_data['products_image'][$i]);
            $this->db->set('products_image_sort_order', $products_images_table_data['products_image_sort_order'][$i]);
            $this->db->insert('products_images');

            if ($i == 0) {
                $this->db->set('products_image', $products_images_table_data['products_image'][$i]);
                $this->db->where('products_id', $products_images_table_data['products_id']);
                $this->db->update('products');
            }
        }

        return true;
    }


    public function updateProductVideos($products_videos_table_data, $products_id) {
        $this->db->where('products_id', $products_id);
        $this->db->delete('products_videos');

        $this->db->set($products_videos_table_data);
        $this->db->insert('products_videos');
    }


    public function updateProductDiscount($products_discounts_table_data, $products_id) {
        $this->db->where('products_id', $products_id);
        $this->db->delete('products_discounts');

        $this->db->set($products_discounts_table_data);
        $this->db->insert('products_discounts');
    }

    //--------------- ABOVE FUNCTIONS ARE USED FOR PRODUCT UPDATE -------------


    public function deleteProductData($products_id) {

        $this->db->where('products_id', $products_id);
        $this->db->delete('products');

        $this->db->where('products_id', $products_id);
        $this->db->delete('products_description');

        $this->db->where('products_id', $products_id);
        $this->db->delete('products_attributes');

        $this->db->where('products_id', $products_id);
        $this->db->delete('products_images');

        $this->db->where('products_id', $products_id);
        $this->db->delete('products_options');


        $this->db->where('products_id', $products_id);
        $this->db->delete('products_to_categories');

        $this->db->where('product_id', $products_id);
        $this->db->delete('products_to_collections');

        return TRUE;
    }


    public function get_products_data($products_id) {
        $this->db->select('a.*, b.products_name, b.products_alias, b.products_description, c.categories_id, d.collection_id');
        $this->db->from('products as a');
        $this->db->join('products_description as b', 'a.products_id = b.products_id', 'LEFT');
        $this->db->join('products_to_categories as c', 'a.products_id = c.products_id', 'LEFT');
        $this->db->join('products_to_collections as d', 'a.products_id = d.product_id', 'LEFT');
        $this->db->where('a.products_id', $products_id);
        $query = $this->db->get();
        return $query->row();
    }


    public function get_product_options($products_id) {
        $this->db->where('products_id', $products_id);
        $this->db->order_by('option_name', 'asc');
        $query = $this->db->get('products_options');
        return $query->result_array();
    }


    public function get_product_attributes($products_id) {
        $this->db->where('products_id', $products_id);
        $query = $this->db->get('products_attributes');
        return $query->result();
    }


    public function get_product_images($products_id) {
        $this->db->where('products_id', $products_id);
        $this->db->order_by('products_image_sort_order');
        $query = $this->db->get('products_images');
        return $query->result();
    }


    public function get_product_videos($products_id) {
        $this->db->where('products_id', $products_id);
        $this->db->limit(1, 0);
        $query = $this->db->get('products_videos');
        return $query->row();
    }


    public function get_product_discount($products_id) {
        $this->db->where('products_id', $products_id);
        $this->db->limit(1, 0);
        $query = $this->db->get('products_discounts');
        return $query->row();
    }


    public function getProductsByManufacture($manufacture) {
        $this->db->select("product.*,desc.products_name,desc.products_description");
        $this->db->from("$this->_table product");
        $this->db->join("$this->_tableDescription desc", "product.products_id = desc.products_id");
        $this->db->where(array("seller" => $manufacture));
        $query = $this->db->get();
        return $query->result();
    }


    public function getApproveRequests() {
        $this->db
                ->select("P.products_id,products_image,products_price,products_available_date,products_name,m.first_name,m.last_name")
                ->from("products P")
                ->join("products_description PD", "P.products_id = PD.products_id")
                ->join("$this->_user m", 'm.id = P.seller', 'LEFT')
                ->where(array("P.products_publish_status" => "PENDING APPROVAL"));
        $query = $this->db->get();
        return $query->result();
    }


    public function approveProduct($id) {
        $data["products_publish_status"] = "PUBLISHED";
        $this->db->where(array("products_id" => $id));
        $this->db->update($this->_table, $data);
    }


    public function rejectProduct($id) {
        $data["products_publish_status"] = "REJECTED";
        $this->db->where(array("products_id" => $id));
        $this->db->get($this->_table, $data);
    }


    public function deleteProductOptionData($products_options_id, $supplier_id) {
        $this->db->where('products_options_id', $products_options_id);
        $this->db->delete('products_options');

        return TRUE;
    }


	


// =================================================================================================

// =================================== BELOW FUNCTIONS ARE USED FOR APIS ===========================

// =================================================================================================




    public function getProductsByCategoryData($category_id,$start_from=1,$limit=30) 
    { // api
        
         $this->db->limit($limit,$start_from);
         $this->db->select('P.id as product_id,P.seller as seller_id,company_types.name as seller_type,TIMESTAMPDIFF(YEAR, `seller_info.date_created`, CURDATE()) AS supplier_company_age,P.name as product_name,C.categories_name,PM.type as media_type, PM.url as media_url,PC1.price as price1,PC2.price as price2, PC1.quantity_from as moq1, PC2.quantity_from as moq2');
         $this->db->from("product_details P");
         $this->db->join("categories_description C","P.category = C.categories_id");
         $this->db->join("product_media PM","PM.id = (SELECT id FROM product_media PM1 WHERE "
                 . "PM1.product_id = P.id ORDER BY PM1.id ASC LIMIT 1)");
         $this->db->join("product_price PC1","PC1.id = (SELECT id FROM product_price PC3 WHERE "
                 . "PC3.product_id = P.id ORDER BY PC3.id ASC LIMIT 1)");
         $this->db->join("product_price PC2","PC2.id = (SELECT id FROM product_price PC4 WHERE "
                 . "PC4.product_id = P.id ORDER BY PC4.id DESC LIMIT 1)");
         $this->db->join("users as users", "users.id=P.seller", "INNER");
         $this->db->join("seller_info as seller_info", "seller_info.user_id=P.seller", "INNER");
         $this->db->join("company_types as company_types", "company_types.id=seller_info.company_type", "INNER");
         $this->db->where('P.category', $category_id);
         $query = $this->db->get();
         $result = $query->result_array();
         
         //echo $this->db->last_query();exit;

         for($i=0; $i < count($result); $i++)
         {
            
            if($result[$i]['moq1']<$result[$i]['moq2'])
            {
               $result[$i]['moq']=$result[$i]['moq1'];
            }

            else
            {
               $result[$i]['moq']=$result[$i]['moq2'];
            }

            if($result[$i]['moq1']!="" || $result[$i]['moq2']!="")
            {
               unset($result[$i]['moq1']);
               unset($result[$i]['moq2']);
            }

         }


        return $result;
    }



    /*

      public function getProductsByCategoryData($category_id)
      {
      $this->db->select('category_id');
      $this->db->where('parent_id', $category_id);
      $query=$this->db->get('categories');
      $categories=$query->result();

      $categories_id_list=array();

      foreach($categories as $cat)
      {
      array_push($categories_id_list, $cat->category_id);
      }

      array_push($categories_id_list, $category_id);

      $this->db->select('a.*, b.* ');
      $this->db->from('products as a');
      $this->db->join('products_to_categories as b', 'a.products_id = b.products_id', 'INNER');
      $this->db->where_in('b.categories_id', $categories_id_list);
      $query=$this->db->get();
      $result=$query->result();
      return $result;

      }

     */

    
    public function getProductDescriptionData($products_id)
    {
       $this->db->select('description');
       $this->db->where('id', $products_id);
       $query=$this->db->get('product_details');
       $result=$query->row();
       return $result; 
    }



    public function getProductDetailsData($products_id) {
        $data['product_data'] = $this->get_products_data($products_id);
        $data['product_options'] = (object) $this->get_product_options($products_id);
        $data['product_attributes'] = $this->get_product_attributes($products_id);
        $data['product_images'] = $this->get_product_images($products_id);
        $data['product_videos'] = $this->get_product_videos($products_id);
        return $data;
    }
	
    public function searchAllProducts($search) {
        $this->db->select('a.*, b.*, c.company_name, d.products_name, e.categories_name ');
        $this->db->like('e.categories_name', $search);
        $this->db->or_like('d.products_name', $search);
        $this->db->from('products as a');
        $this->db->join('products_to_categories as b', 'a.products_id = b.products_id', 'INNER');
        $this->db->join('users as c', 'a.seller = c.id', 'INNER');
        $this->db->join('products_description as d', 'a.products_id = d.products_id', 'INNER');
        $this->db->join('categories_description as e', 'b.categories_id = e.categories_id', 'INNER');
        //$this->db->where('a.products_publish_status', 'PUBLISHED');
        //$this->db->where('a.products_status', '1');
        //$this->db->where('a.products_available_date<=', date('Y-m-d'));
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }


    public function searchAllSuppliersWithProducts($search) {
        $this->db->distinct('c.*');
        $this->db->select('c.*');
        $this->db->like('e.categories_name', $search);
        $this->db->or_like('d.products_name', $search);
        $this->db->from('products as a');
        $this->db->join('products_to_categories as b', 'a.products_id = b.products_id', 'INNER');
        $this->db->join('users as c', 'a.seller = c.id', 'INNER');
        $this->db->join('products_description as d', 'a.products_id = d.products_id', 'INNER');
        $this->db->join('categories_description as e', 'b.categories_id = e.categories_id', 'INNER');
        //$this->db->where('a.products_publish_status', 'PUBLISHED');
        //$this->db->where('a.products_status', '1');
        //$this->db->where('a.products_available_date<=', date('Y-m-d'));
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }

    public function getRecentlyViewedItemsData($recetlyViewedItemsIds) {
        $recetlyViewedItemsIds_array = explode(',', $recetlyViewedItemsIds);
        $this->db->select('a.products_id, a.products_image, a.products_price, b.products_name');
        $this->db->from('products as a');
        $this->db->join('products_description as b', 'a.products_id = b.products_id', 'INNER');
        //$this->db->where('a.products_publish_status', 'PUBLISHED');
        //$this->db->where('a.products_status', '1');
        //$this->db->where('a.products_available_date<=', date('Y-m-d'));
        $this->db->where_in('a.products_id', $recetlyViewedItemsIds_array);
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }

    public function getRecommendedProductsData($recommendedItemsIds) {
        if ($recommendedItemsIds == 0) {
            $this->db->distinct();
            $this->db->select('products_id, SUM(products_quantity) as TotalQuantity ');
            $this->db->from('orders_products');
            $this->db->group_by('products_id');
            $this->db->order_by('SUM(products_quantity)', 'DESC');
            //$this->db->where('a.products_publish_status', 'PUBLISHED');
            //$this->db->where('a.products_status', '1');
            //$this->db->where('a.products_available_date<=', date('Y-m-d'));
            $this->db->limit('12,0');
            $query = $this->db->get();
            $result = $query->result();

            $recommendedItemsIds_array = array();

            foreach ($result as $res) {
                array_push($recommendedItemsIds_array, $res->products_id);
            }
        } else {
            $recommendedItemsIds_array = explode(',', $recommendedItemsIds);
        }

        $this->db->select('a.products_id, a.products_image, a.products_price, b.products_name');
        $this->db->from('products as a');
        $this->db->join('products_description as b', 'a.products_id = b.products_id', 'INNER');
        //$this->db->where('a.products_publish_status', 'PUBLISHED');
        //$this->db->where('a.products_status', '1');
        //$this->db->where('a.products_available_date<=', date('Y-m-d'));
        $this->db->where_in('a.products_id', $recommendedItemsIds_array);
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }

    public function getWeeklyDealsData() {
        $weekstart_mondays_date_query = $this->db->query("SELECT DATE_ADD(CURDATE(), INTERVAL - WEEKDAY(CURDATE()) DAY) as weekstart_mondays_date");
        $row = $weekstart_mondays_date_query->row();
        $weekstart_mondays_date = $row->weekstart_mondays_date;

        $weekend_sundays_date_query = $this->db->query("SELECT DATE_ADD(CURDATE(), INTERVAL + (6-WEEKDAY(CURDATE())) DAY) as weekend_sundays_date");
        $row = $weekend_sundays_date_query->row();
        $weekend_sundays_date = $row->weekend_sundays_date;


        //$this->db->select('a.products_id, a.products_image, a.products_price, b.products_name');
        //$this->db->from('products as a');
        //$this->db->join('products_description as b', 'a.products_id = b.products_id', 'INNER');
        //$this->db->where('a.products_publish_status', 'PUBLISHED');
        //$this->db->where('a.products_status', '1');
        //$this->db->where('a.products_available_date<=', date('Y-m-d'));
        //$query=$this->db->query('select a.products_id, a.products_image, a.products_price, b.products_name from products as a INNER JOIN products_description as b ON a.products_id = b.products_id where a.products_available_date between '.$weekstart_mondays_date.' and '.$weekend_sundays_date.'');
        //$result=$query->result();
        //return $result;
        //print_r($result);
        //exit;
    }
	
	function get_products($cat_id)
	{
		$this->db->select('name, p.id');
		$this->db->from('product_details p');
		$this->db->where("p.category",$cat_id);
		return $this->db->get()->result_array();
	}
	
	function get_products_price($prod_id)
	{
		$this->db->select('MAX(price) as max_price,MIN(price) as min_price, units_name, quantity_upto');
		$this->db->from('product_price pp');
		$this->db->join('units u','pp.unit = u.units_id');
		$this->db->where("product_id",$prod_id);
		$this->db->limit(1);
		return $this->db->get()->row_array();
	}
	
	function getproduct_image($product_id)
	{
		$this->db->select('url');
		$this->db->limit(1);
		return $this->db->get('product_media')->row();
	}
	
	function get_recommended_products($cat_id)
	{
		$this->db->select('p.id, name, price, quantity_upto, units_name');
		$this->db->from('product_details p');
		$this->db->join('product_price pp','p.id = pp.product_id');
		$this->db->join('units u','pp.unit = u.units_id');
		$this->db->where("p.category",$cat_id);
		$this->db->limit(4);
		return $this->db->get()->result_array();
	}
	
	function getProductDetails($products_id)
	{
		$this->db->select('p.id, p.name, p.description,seller,s.company_name,address1,currency,main_products,other_products,year_of_register,no_of_employee,office_size,company_url,registration_state,comp_operational_addr,comp_operational_city,comp_operational_state,comp_operational_region,comp_operational_zip_code,ct.name business_type,first_name,last_name, iso3 country_name,iso,category');
		$this->db->from('product_details p');
		$this->db->join('seller_info s','p.seller = s.user_id');
		$this->db->join('users u','p.seller = u.id');
		$this->db->join('country c','u.country = c.id');
		$this->db->join('seller_company_details sc','sc.user_id = s.user_id');
		$this->db->join('company_types ct','ct.id = s.company_type');
		$this->db->where('p.id',$products_id);
		$result = $this->db->get()->row_array();
		
		if($result){
			
			$this->db->select('price,units_name,quantity_from,quantity_upto')->from('product_price pp');
			$this->db->join('units u','pp.unit = u.units_id');
			$product_prices = $this->db->where('pp.product_id',$result['id'])->get()->result_array();
			$result['product_prices'] = $product_prices;
			
			
			$urls = $this->db->select('url')->where('product_id',$result['id'])->get('product_media')->result_array();
			foreach($urls as $row){
				$result['images'][] = $row['url'];
			}
			
			$this->db->select('spec_id, spec_value,cst.name specification_name, choices, type')->from('product_specifications ps');
			$this->db->join('category_specific_specifications cst','cst.id = ps.spec_id');
			$specification = $this->db->where('ps.product_id',$result['id'])->get()->result_array();
			
			foreach($specification as $spec){
				$result['product_specification'][] =array(
					'spec_id' 		=> $spec['spec_id'],
					'spec_value' 	=> $spec['spec_value'],
					'specification_name'=> $spec['specification_name'],
					'choises' 	=> $spec['choices'],
					'type' 		=> $spec['type'],
				);
			}
			
			$this->db->select('attribute_value,csa.name')->from('product_attributes pa');
			$this->db->join('category_specific_attributes csa','csa.id = pa.attribute_id');
			$attributes = $this->db->where('pa.product_id',$result['id'])->get()->result_array();
			foreach($attributes as $atr){
				$result['product_attributes'][] =array(
					'attribute_name' 		=> $atr['name'],
					'attribute_value' 	=> $atr['attribute_value'],
				);
			}
                        
                        $result["coupons"] = [
                            "is_available" => 0,
                            "list" => []
                        ];
			
                        $coupons = $this->getProductCoupens($products_id);
                        if($coupons){
                            $result["coupons"]["is_coupon_available"] = 1;
                            $result["coupons"]["coupon_list"] = $coupons;
                        }
		}
		
		return $result;
	}
	
	function get_product_hints($keyword)
	{
		$this->db->select('id,name,category');
		$this->db->like('name',$keyword);
		return $this->db->get('product_details')->result_array();
		
	}
	
	function get_searched_product($keyword)
	{
		$this->db->select('name,id');
		$this->db->from('product_details');
		$this->db->where("name",$keyword);
		return $this->db->get()->row();
	}
	
	function getProductPrices($product_id) {
        $this->db->select('*');
        $this->db->where('product_id', $product_id);
        $this->db->from('product_price');
        return $this->db->get()->result();
    }
	
    function related_product($cat_id)
    {
        $this->db->select('name, p.id');
        $this->db->from('product_details p');
        $this->db->where("p.category",$cat_id);
        $this->db->limit(8);
        return $this->db->get()->result_array();
    }
    
    public function getProductCoupens($product_id)
    {
        $this->db->select("coupon_code,coupon_value,discount_type,moq,valid_from,valid_to");
        $this->db->from("coupons C");
        $this->db->join("coupons_to_product CP","CP.coupon_id = C.coupon_id");
        $this->db->where(["CP.product_id"=>$product_id]);
        $query = $this->db->get();
        return $query->result();
    }	
}
