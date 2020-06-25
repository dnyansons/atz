<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//header('Access-Control-Allow-Origin:*');

class Home extends CI_Controller {
    
    public function __construct(){
        parent::__construct();
        $this->load->model("Categories_model");
        $this->load->library("get_header_data");
        $this->load->model("Banners_model");
        $this->load->model("Rfqs_model");
        $this->load->model("Subscribers_model");
        $this->load->library("Shipping");
        $this->load->library("Browser_notification");
        $this->load->model('Product_model');
        $this->load->model('Order_model');
        $this->load->model('Wallet_model');
        $this->load->model('myfavourite_model');
        $this->load->model('Offer_model');
        $this->load->model('Inquiries_model');
        $this->load->model('Myfavourite_model');
        $this->load->model('Shipping_model');
        $this->load->model('Coupon_model');
        $this->load->library('facebook');
        $this->load->library('google');

        $this->load->library('Send_data');
        $this->load->library('Shiprocket');
    }

    public function index() 
    {
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
        $topSellings = $this->Product_model->topSellingProductsData();
        
        //Checking Offer Applied To Product Or Not
        $returnTopSellings = $this->Offer_model->appliedOfferProduct($topSellings);
        $trendingCats = $this->Categories_model->getTopSellingCategories(10);
        
        $items = array();
        $i = 0;
        foreach ($trendingCats as $cat):
            $items[$i]["title"] = $cat->categories_name;
            $items[$i]["id"] = $cat->category_id;
            $i++;
        endforeach;
        
        $data["items"] = $items;
        $sub_categories = $this->Categories_model->getHomePageCategories(3);
        $sub_finalcats = array();
        foreach ($sub_categories as $rt) {
            $cats = $this->Categories_model->top_sub_categories_by_parent($limit = '', $rt->category_id);
            $sub_finalcats[] = array(
                "id" => $rt->category_id,
                "title" => $rt->categories_name,
                "elements" => $cats
            );
        }
        
        $recoms = $this->Product_model->get_recommended_list();
        
        $returnRecoms = $this->Offer_model->appliedOfferProduct($recoms);
        
        $data['topSellings']= $returnTopSellings;
        $data["trendingCats"] =  $sub_finalcats;
//        $data['recoms'] =  $returnRecoms;
        
        $user_id = $this->session->userdata('user_id');
        $favorite = $this->Myfavourite_model->count_fav_products($user_id);
        $cart = $this->Product_model->getCartProducts($user_id);
        $orders=$this->Order_model->order_details($user_id);
        if($orders){
            $data['orders_count']=$orders->orders_status;
        }else{
            $data['orders_count'] = 0;
        }
	//$data['cart_products'] = $cart;
        if($cart){
            $data['cart_count'] = count($cart);
        }else{
            $data['cart_count'] = 0;
        }
        if ($favorite) {
            $fav_array = json_decode($favorite->products);
            $data['fav_count'] = count($fav_array);
        } else {
            $data['fav_count'] = 0;
        }
        $data["items"] = $this->Banners_model->get_active_banners_for_mobile();
 
        $interested_categories = get_cookie("intesested_categories");
        if ($interested_categories != NULL) 
		{
            $catsi = explode(",", $interested_categories);
            $res = "";
            foreach ($catsi as $cati) {
                $res = $res . $cati . "," . $this->Categories_model->getAllChilds($cati) . ",";
            }
            $ctcats = array_unique(explode(",", trim($res, ",")));
            
            $justforyous = $this->Product_model->getProductByCatIds2($ctcats,18);
           
        } else {
            $justforyous = $this->Product_model->getProductsdetailsByCategory(171,'','','','','','');
        }
        
        $returnJustForYou=$this->Offer_model->appliedOfferProduct1($justforyous);
        
        $data['justforyous']=$returnJustForYou;
        
        $data["title"] = "Online Shopping Site | Largest Online B2B &amp; B2C Marketplace | ATZ Cart";

        $data["description"] = "Find all the global &amp; Indian wholesalers, importers, exporters, distributors, retailers,
                                manufacturers &amp; buyers under one roof. Maximize your sales with ATZ Cart.";
        $data["keywords"] = "wholesalers directory of wholesale trade suppliers, distributors, importers,
        manufacturers, suppliers, exporters, products, online shopping in India, online
        shopping store, online shopping site,buy online, shop online, online shopping";
        
        $data['offer_zone']= $this->Offer_model->getRunningOffers();
        $this->load->view("mobile/home_view", $data);
    }

    public function subcategory($cat_id) 
    {
        $data['categories'] = $this->Categories_model->get_categories_by_parent($cat_id);
        $data['catname'] = $this->Categories_model->getCategoryName($cat_id);
        $this->load->view("mobile/subcategory_view", $data);
    }

    public function productList($category_id)
    {   
            $category_name = $this->Categories_model->getCategoryName($category_id);
            $categories = array_filter(array_unique(explode(",",$category_id.",".$this->Categories_model->getAllChilds($category_id))));
            
            $productlists = $this->Product_model->getProductsdetailsByCategory($categories,0,6,"","","",""); //by default 30 instead 10           
            $data["productsCnt"] = $this->Product_model->getProductsdetailsByCategoryCount($categories); //by default 30 instead 10           
            /* ------------- Flag OF Country-------------- */
            $seller_id = $productlists[0]['seller_id'];
            $country=$this->Product_model->getCountryFlag($seller_id);
            /* -------------company info year-------------------- */
            $registers = $this->Product_model->getRegisterYear($seller_id);
            $data['country'] = $country;
            $data['registers'] = $registers;
            $data['category_name'] = $category_name;

            $old_cookie_str = get_cookie("intesested_categories");
            $old_cookie_arr = array_unique(explode(",", $old_cookie_str));
            $new_cookie_str = "$category_id";
            if(!in_array($cat_id, $old_cookie_arr)){
                if(count($old_cookie_arr) >= 10 ){
                    array_shift($old_cookie_arr);
                } 
                array_push($old_cookie_arr,$cat_id);
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
            $parent_cat = $this->Categories_model->getCategoryById($category_id);
            $data["description"] = $parent_cat->seo_description;
            $data["keywords"] = $parent_cat->seo_keywords;
            $data["title"] = $parent_cat->seo_title;
            $returnOfferProductList=$this->Offer_model->appliedOfferProduct1($productlists); 
            $data['productlists'] = $returnOfferProductList;
            $this->load->view("mobile/productlist_view", $data);
    }

    public function searchresult() {
        $term = $this->input->get('term');
        $getDetail = $this->Categories_model->getSearch($term);
        $data = array();
        if(!empty($getDetail)){
            foreach ($getDetail as $value) {
                $data[] = array(
                    'id' => $value['id'],
                    'label' => $value['categories_name'],
                    'value' => $value['categories_name']);
            }
            echo json_encode($data);
        }else{
            echo json_encode($data);
        }
    }

    public function mob_search_product()
    {
        if(!empty($this->input->get("page"))) {
            $page = $this->input->get("page");
            $perpage = 1;
            $start = ceil($page * $perpage) + 1;
            $productlists = $this->Product_model->getSerachProductByname($keyword,$start,$perpage);
            /*----------Country Flag----------*/
            $seller_id = $productlists[0]['seller_id'];
            $this->db->select("u.id,c.*");
            $this->db->from("users u");
            $this->db->join("country c", "c.id = u.country");
            $this->db->where("u.id", $seller_id);
            $query = $this->db->get();
            $country = $query->row_array();
            /*------------Register Year---------*/
            /* -------------company info year-------------------- */
            $this->db->select("u.id,sc.year_of_register");
            $this->db->from("users u");
            $this->db->join("seller_company_details sc", "sc.user_id = u.id");
            $this->db->where("u.id", $seller_id);
            $query = $this->db->get();
            $registers = $query->row_array();

            $data['productlists'] = $productlists;
            $data['country'] = $country;
            $data['registers'] = $registers;
            
            $result = $this->load->view('mobile/data', $data);
            echo $result;
        }else{
            $keyword = htmlentities($this->input->post('searchText'));
            $productlists = $this->Product_model->getSerachProductByKeyword($keyword,0,12);
            $returnOfferProductList=$this->Offer_model->appliedOfferProduct1($productlists); 
            $data['productlists'] = $returnOfferProductList;
            $data['category_name'] = $keyword;
            $this->load->view("mobile/productlist_view", $data);
        }
    }

    /* sidebar Menu Function */
    public function messenger() {
        $this->load->view("mobile/messenger_view");
    }

    public function send_enquiry() {
        if (!$this->session->userdata("user_logged_in")) {
            redirect("signin", "refresh");
        } else {
            $user_id = $this->session->userdata('user_id');
            $data['inquires'] = $this->Inquiries_model->getInquiryByUser($user_id);
            //printr($data);
            $this->load->view("mobile/send-inquiry_view", $data);
        }
    }
    
     public function get_enquiry($enq_id) {
         $user_id = $this->session->userdata('user_id');
         $inquire=$this->Inquiries_model->getInquiryByUserEnquiry($enq_id,$user_id);
         $text = "<b>Enquiry Text :</b> ".$inquire->comment."<br> <div id='enq-img-modal'> <img  alt='".$inquire->products_name."' height='100' width='100' src='".$inquire->product_image."' > </div>"
                                           ." <br><b>Seller Name :</b> ".$inquire->first_name.' '.$inquire->last_name.' '
                                           ." <br><b>Enquiry Date :</b> <i>".$inquire->added_date."</i>"
                                           ." <br><b>Quantity :</b> <i>".$inquire->quantity."</i>"; 
         
         echo $text;
     }

    public function rfq() {
        if (!$this->session->userdata("user_logged_in")) {
            redirect("signin", "refresh");
        } else {
            $user_id = $this->session->userdata('user_id');
            $data['rfqrequests'] = $this->Rfqs_model->getRfqByUser($user_id);
            $this->load->view("mobile/rfqlist_view", $data);
        }
    }
    public function get_rfq() 
    {
        $rfq_id = $this->input->post('rfqs_id');
        $user_id = $this->session->userdata('user_id');
        $rfqrequest = $this->Rfqs_model->getRfqById($rfq_id);
        $rfqSellerReplys = $this->Rfqs_model->getSellerReply($rfq_id); 
        //printr($rfqSellerReplys);
        if($rfqrequest->status=="Approved"){
            $color="text-success";
            $display="block";
        }elseif($rfqrequest->status=="Rejected"){
             $display="none";
             $color="text-danger";
        }else{
             $display="none";
             $color="text-warning";
        }
        $text='';
        $text.=     "<b>Quotation Text :</b> ".$rfqrequest->description."<br>"
                    ." <b>Agree To Share Contact :</b> ".$agree
                    ." <br><b>Looking For :</b> ".$rfqrequest->looking_for
                    ." <br><b>Request Date :</b><i> ".$rfqrequest->added_date."</i>"
                    ." <br><b>Quantity :</b><i> ".$rfqrequest->quanity."</i>"
                    ." <br><b>Status :</b><i><small class='$color'> ".$rfqrequest->status."</small></i>";
        $i=1;
        foreach($rfqSellerReplys as $rfqsellreply){
                    $hike_price=($rfqsellreply['price'])+($rfqsellreply['price']*$rfqsellreply['admin_hike']/100);
                    $text.=" <br> <a href='javascript:void(0)' id='seller_rply' onclick='showReply()' style='display:$display'><b> $i)</b> Reply From ".$rfqsellreply['first_name']." ".$rfqsellreply['last_name']."</a>";
                    $text.='<div id="rfqSeller" style="display:none">
                            <table class="table table-responsive">
                                <thead>
                                  <tr>
                                    <th scope="col">Seller</th>
                                    <th scope="col">Qty</th>
                                    <th scope="col">Price</th>
                                    <th scope="col">Comment</th>
                                  </tr>
                                </thead>
                                <tbody>
                                  <tr>
                                    <td>'.$rfqsellreply['first_name'].' '.$rfqsellreply['last_name'].'</td>
                                    <td>'.$rfqsellreply['quantity'].'</td>
                                    <td>'.$hike_price.'</td>
                                    <td>'.$rfqsellreply['comment'].'</td>
                                  </tr>
                                </tbody>
                            </table> </div>';
                    $i++;
                }
        echo $text;
    }

    public function favourite() {
        if (!$this->session->userdata("user_logged_in")) {
            redirect("signin", "refresh");
        } else {
            $user_id = $this->session->userdata('user_id');
            $products_id = $this->Common_model->getAll('buyer_favourites', array('user_id' => $user_id))->row_array();
            $products = json_decode($products_id['products']);
            if (!empty($products)) {
                $products = $this->Product_model->getProductDetailsYourFav($products);
                for($i=0;$i<count($products);$i++) {
                if (strtolower($products[$i]['offer_status']) == 'active') {
                    
                    $offerRunningStatus = $this->Offer_model->checkOfferValidity(
                            $products[$i]['valid_from'] . ' ' . $products[$i]['time_from'],
                            $products[$i]['valid_to'] . ' ' . $products[$i]['time_to'],
                            $products[$i]['offer_status']);
                    
                    if ($offerRunningStatus == true) {
                        if (strtolower($products[$i]['offer_type']) == 'flat') {
                            
                            $products[$i]['discount_percentage'] = '<i class="fa fa-inr"></i> ' . $products[$i]['offer_discount_value'] . ' OFF';
                            $products[$i]['final_price'] = $products[$i]['atz_price'] - $products[$i]['offer_discount_value'];
                        }
                        if (strtolower($products[$i]['offer_type']) == 'percentage') {
                            $products[$i]['discount_percentage'] = $products[$i]['offer_discount_value']."% OFF";
                            $products[$i]['final_price'] = $products[$i]['atz_price'] - ($products[$i]['atz_price'] * $products[$i]['offer_discount_value'] * 0.01);
                        }
                    }else{
                        // this case very rare if offer status active but date and time expired.
                        $products[$i]['discount_percentage'] = $products[$i]['discount_percentage']."% OFF";
                    }
                } else {
                        $products[$i]['discount_percentage'] = $products[$i]['discount_percentage']."% OFF";
                }
            }
                $data['products']=$products;
                $this->load->view("mobile/favourite_view", $data);
            } else {
                $this->load->view("mobile/favourite_view");
            }
        }
    }
    
    public function mycart() {  
        if (!$this->session->userdata("user_logged_in")) {
            redirect("signin", "refresh");
        } else {
            $data = $this->get_header_data->get_categories();
            $user_id = $this->session->userdata('user_id');
            $result = $this->Product_model->getCartProducts($user_id);
            
            for($i=0;$i<count($result);$i++)
            {
                $result[$i]['spec_decode']=json_decode($result[$i]['specifications']);   
                $result[$i]['offers']=$this->Offer_model->getOfferDetailsForOfferId1($result[$i]['offer_id']);    
            }
            
            $count=1; 
            foreach($result as $row)
            {
                $count1= $count;
                $groupBySellerProduct[$row['seller_id']][] = $row;
                $count++;
            }
            $data['cart_product'] = $groupBySellerProduct;
            $data['count_rows']= $count1; //Number of Time Loop in Javascript in View Files.
            $this->load->view('mobile/gotocart_view',$data);
        }
    }
    
    public function coupons() {
        if (!$this->session->userdata("user_logged_in")) {
            redirect("signin", "refresh");
        } else {
              $user_id = $this->session->userdata('user_id');
              $data['getUserCoupons']=$this->Coupon_model->allmycoupons($user_id,5,0,"id","DESC");
       
            $this->load->view("mobile/coupons_view",$data);
        }
    }
    
    public function myorders() {
        
        if (!$this->session->userdata("user_logged_in")) {
            redirect("signin", "refresh");
        } else {
          $user_id=$this->session->userdata("user_id");
          $this->session->set_userdata("start_order_page","home/myorders");
          $data['user_orders']=$this->Order_model->getUserOrdersWithProducts($user_id);
          $result=$this->Offer_model->deleteExpiredOfferFromOrders($data['user_orders'][0]->orders_id);
          $this->load->view("mobile/myorders_view",$data);
        }
    }

    public function help_desk($order_id) {
        if (!$this->session->userdata("user_logged_in")) {
            redirect("signin", "refresh");
        } else {
         $user_id=$this->session->userdata("user_id"); 
         $order_products=$this->Order_model->getTrackProductDetails($order_id);
         $data['user_orders']=$order_products;
         $this->load->view("mobile/help_desk_view",$data);
        }
    }

    public function proceed_to_return() {
        if (!$this->session->userdata("user_logged_in")) {
            redirect("signin", "refresh");
        } else {
          $order_id=$this->input->post('order_id');
          $data['return_reason'] = $this->Common_model->getAll('refund_reason', array('reason_type' => 'Return'))->result();
          $order_products=$this->Order_model->getTrackProductDetails($order_id);
          $data['user_orders']=$order_products;
          
          $this->load->view("mobile/return_proceed_view",$data);
        }
    }
    
    public function return_proceed() {
		
        $data1 = $this->get_header_data->get_categories();
        $username = $this->session->userdata('user_name');
        $user_id = $this->session->userdata('user_id');
        $phone = $this->session->userdata('phone');
        $order_id = $this->input->post('order_id');
        $return_type =$this->input->post('return_type');
        
        if (!empty($order_id) && !empty($return_type)) {

            if ($username) {
                    //get Shipping Method
                    $ship_method = $this->send_data->get_shipping_method();
                    //Shipping Address Details
                    $chech_shipp = $this->Common_model->getAll('shipping_vendor', array('id' => $ship_method))->row();
                    $order_shipping_data = $this->Common_model->getAll('order_shipping', array('orders_id' => $order_id))->row();
                    $pr_details = $this->Order_model->getOrderDetails($order_id);
                    
                    $data['order_id'] = $order_id;

                    if($pr_details[0]->orders_status==4)
                    {                        
                    $data['return_type'] = $this->input->post('return_type');
                    $data['return_reason'] = $this->Common_model->getAll('refund_reason', array('reason_type' => 'Return'))->result();
                    $data['seller_info'] = $this->Product_model->getSellerInformation($pr_details[0]->seller_id);
                    $data['details'] = json_decode($pr_details[0]->product_specifications);

                    if (!empty($pr_details) && !empty($this->input->post('return_reason'))) {
                        
                        $user = $this->Common_model->getAll('users', array('id' => $user_id))->row();
						
                        $dat['orders_id'] = $order_id;
                        $dat['return_reason'] = $this->input->post('return_reason');
                        $dat['user_id'] = $user_id;
                        $dat['return_type'] = 'full';
                        $dat['order_from'] = $pr_details[0]->order_from;   
                        $dat['pick_name'] = $pr_details[0]->user_name;
                        $dat['pick_addr_type'] = 'From User';
                        $dat['pick_country'] = $pr_details[0]->delivery_country;
                        $dat['pick_state'] = $pr_details[0]->delivery_city . ' , ' . $pr_details[0]->delivery_state;
                        $dat['pick_mobile'] = $user->phone;
                        $dat['pick_email'] = $user->email;
                        $dat['pick_pincode'] = $pr_details[0]->delivery_postcode;
                        $dat['pick_days'] = 0;
                        $dat['delivery_name'] = $pr_details[0]->pick_name;
                        $dat['delivery_street_address'] = $pr_details[0]->pick_addr_type;
                        $dat['delivery_city'] = $pr_details[0]->delivery_city;
                        $dat['delivery_email_address'] = $pr_details[0]->pick_email;
                        $dat['delivery_postcode'] = $pr_details[0]->pick_pincode;
                        $dat['delivery_state'] = $pr_details[0]->pick_state;
                        $dat['delivery_country'] = $pr_details[0]->pick_country;

                        $dat['delivery_address_format_id'] = 0;
                        $dat['payment_method'] = $pr_details[0]->payment_method;
                        $dat['last_modified'] = $pr_details[0]->last_modified;
                        $dat['date_purchased'] = $pr_details[0]->date_purchased;

                        $dat['shipping_cost'] =0;
                        $dat['shipping_subtotal'] =0;
                        $dat['shipping_gst'] =0;
                        $dat['order_price'] = $pr_details[0]->order_price;

                        $dat['shipping_method'] = $pr_details[0]->shipping_method;
                        $dat['ex_shipping_days'] = $pr_details[0]->ex_shipping_days;
                        $dat['shipping_expected_date'] ='';
                        $dat['remark'] = $pr_details[0]->remark;
                        $dat['orders_status'] = 23;
                        $dat['order_tracking_status'] = 3;
                        $dat['order_token_number'] = 0;
                        $dat['comments'] = $pr_details[0]->comments;
                        $dat['currency'] = $pr_details[0]->currency;
                        $dat['seller_id'] = $pr_details[0]->seller_id;
                        $dat['user_telephone'] = $user->phone;
						
                        $seller_id=$pr_details[0]->seller_id;
                        $insert_id = $this->Common_model->insert('return_orders', $dat);
                        
                        if ($pr_details[0]->shippment_type == 'Free') {
                            $grand_price = $pr_details[0]->order_price;
                        } else {
                            $grand_price = $pr_details[0]->order_price - $pr_details[0]->shipping_cost;
                        }
                        //$grand_price=$pr_details[0]->order_price-$pr_details[0]->shipping_cost; 
                        if ($insert_id) {
                             $ship_cost_subtotal=0;
                             $tot_quantity=0;
                             $actual_order_price=0;
                             $tot_weight=0;
                             
                            $max_length = 0.5;
                            $max_height = 0.5;
                            $max_width = 0.5;
                            $max_tot_weight = 0;
                            
                            foreach ($pr_details as $pro) {
                               $prod_dat = $this->send_data->get_product_detail($pro->products_id);
                                //Shippig rate Calculate Start 
                                //calculate length ,width,height
                                if ($prod_dat->length > $max_length) {
                                    $max_length = $prod_dat->length;
                                }

                                if ($prod_dat->width > $max_width) {
                                    $max_width = $prod_dat->width;
                                }

                                if ($prod_dat->height > $max_height) {
                                    $max_height = $prod_dat->height;
                                }

                                $wt = $prod_dat->weight * $pro->products_quantity;
                                $max_tot_weight = $max_tot_weight + $wt; 

                               //Shiipigrate Calculate Start 
                                $ch_seller = $this->Common_model->getAll('product_details', array('id' => $pro->products_id))->row();
                                $ch_addr_seller = $this->Common_model->getAll('seller_pick_address', array('user_id' => $seller_id))->row();

                                //$tot_weight=$tot_weight+$ch_seller->weight;
                                $tot_weight=$ch_seller->weight*$pro->products_quantity;


                                $tot_quantity = $tot_quantity + $pro->products_quantity;
                                $actual_order_price =$pro->products_price; 

                                //shipping rate
                                $rate = $this->Shipping_model->get_return_shipping_rate($tot_weight,$pr_details[0]->pick_pincode,$pr_details[0]->delivery_postcode);
                                
                                if($ship_method == 1 && $rate > 0)
                                {
                                       $ship_cost=$this->shipping->get_return_shipping_cost_for_multiple($pro->products_id,$rate,$pro->products_quantity,$tot_weight,$actual_order_price,$pr_details[0]->delivery_postcode);
                                       $ship_cost_subtotal=$ship_cost_subtotal+$ship_cost;
                                       $dat_pro['return_orders_id'] = $insert_id;
                                       $dat_pro['products_id'] = $pro->products_id;
                                       $dat_pro['products_name'] = $pro->products_name;
                                       $dat_pro['products_price'] = $pro->products_price;
                                       $dat_pro['final_price'] = $pro->final_price;
                                       $dat_pro['vendors_price'] = $pro->vendors_price;
                                       $dat_pro['products_tax'] = 0.00;
                                       $dat_pro['products_quantity'] = $pro->products_quantity;
                                       $dat_pro['product_specifications'] = $pro->product_specifications;
									
                                       $this->Common_model->insert('return_orders_products', $dat_pro);
                                   }elseif($ship_method == 2){
                                        $dat_pro['return_orders_id'] = $insert_id;
                                        $dat_pro['products_id'] = $pro->products_id;
                                        $dat_pro['products_name'] = $pro->products_name;
                                        $dat_pro['products_price'] = $pro->products_price;
                                        $dat_pro['final_price'] = $pro->final_price;
                                        $dat_pro['vendors_price'] = $pro->vendors_price;
                                        $dat_pro['products_tax'] = 0.00;
                                        $dat_pro['products_quantity'] = $pro->products_quantity;
                                        $dat_pro['product_specifications'] = $pro->product_specifications;
                                       
                                        $this->Common_model->insert('return_orders_products', $dat_pro);
                                   }
                                   else
                                   {
                                       $msg = "<div class='alert alert-danger alert-dismissible'>
                                                    <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                                                    <strong>Error!</strong> Somthing Wrong !
                                        </div>";
                                        $this->session->set_flashdata("message", $msg);
                                        $this->Common_model->delete('return_orders',array('orders_id'=>$insert_id));
                                        redirect('m/home/myorders');
                                   }
                            }
                            
                            if($ship_method == 2){
                                //New
                                $pickup_pincode = $pr_details[0]->delivery_postcode;
                                $delivery_pincode = $pr_details[0]->pick_pincode;
                                //$ship_rocket_cost = $this->shiprocket->serviceability_for_multiple($pickup_pincode, $delivery_pincode, $max_length, $max_width, $max_height, $max_tot_weight);
                                $ship_rocket_cost = $this->shiprocket->return_serviceability_for_multiple($order_shipping_data->ship_order_id);
                                if ($ship_rocket_cost['status'] == 200) {
                                        $courier_id = $ship_rocket_cost['courier_id'];
                                        $shipping_rate = $ship_rocket_cost['rate'];
                                        $shipping_subtotal = ($ship_rocket_cost['rate'] - ($ship_rocket_cost['rate'] * (18 / 100)));
                                        $shipping_gst = ($ship_rocket_cost['rate'] * (18 / 100));
                                        $exp_shipping_date = $ship_rocket_cost['est_date'];
                                        $ship_cost_subtotal = $shipping_rate;
                                 }else{
                                    $this->Common_model->delete('return_orders', array('return_orders_id' => $insert_id));
                                    $this->Common_model->delete('return_orders_products', array('return_orders_id' => $insert_id));
                                    $msg = "<div class='alert alert-danger alert-dismissible'>
                                                            <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                                                            <strong>Error!</strong>Error Occured in Pickup ! Retry 
                                                      </div>";
                                    $this->session->set_flashdata("message", $msg);
                                    redirect('home/myorders'); 
                                 }
                                 //New End
                                
                                $gst = ($ship_cost_subtotal * (18 / 100));
                                $final_shipping_cost = $ship_cost_subtotal;
                                $ship_cost_subtotal = $final_shipping_cost - $gst;
                                 
                            }else {
                                // add gst to shipping cost
                                $gst = $ship_cost_subtotal * (18 / 100);
                                $final_shipping_cost = $ship_cost_subtotal + $gst;
                            }                           
                            $dat['shipping_subtotal']=$ship_cost_subtotal;
                            $dat['shipping_gst']=$gst;
                            $dat['shipping_cost']=$final_shipping_cost;
                            $dat['order_price']=round($grand_price+$final_shipping_cost,2);
                           
                            //update Order
                            $this->Common_model->update('return_orders',$dat,array('orders_id'=>$order_id));
                            //Insert into Return Shipping Order
                            $ship_dat['ship_vendor_id'] = $ship_method;
                            $ship_dat['orders_id'] = $order_id;
                            $ship_dat['return_orders_id'] = $insert_id;
                            $ship_dat['courier_id'] = $courier_id;
                            $ship_dat['shipping_subtotal'] = $ship_cost_subtotal;
                            $ship_dat['shipping_gst'] = $gst;
                            $ship_dat['shipping_cost'] = $final_shipping_cost;
                            $ship_dat['on_amount'] = $chech_shipp->free_amount;
                            $ship_dat['pickup_pincode'] = $pr_details[0]->delivery_postcode;
                            $ship_dat['delivery_pincode'] = $pr_details[0]->pick_pincode;
                            $ship_dat['shippment_type'] = $chech_shipp->shipping_type;
                            $ship_dat['length'] = $max_length;
                            $ship_dat['breadth'] =$max_width;
                            $ship_dat['height'] = $max_height;
                            $ship_dat['weight'] = $max_tot_weight;
                            $insert_ship_id = $this->Common_model->insert('return_order_shipping', $ship_dat);
                            //Generate Order if Use Ship Rocket
                            if ($ship_method == 2) {
                                $resp = $this->shiprocket->return_create_order_new($insert_id,$order_id);
                            
                                if (!empty($resp['shipment_id'])) {
                                    $up_ord['ship_order_id'] = $resp['order_id'];
                                    $up_ord['shipment_id'] = $resp['shipment_id'];
                                    $this->Common_model->update('return_order_shipping', $up_ord, array('ship_id' => $insert_ship_id));
                                } else {
                                    $this->Common_model->delete('return_orders', array('return_orders_id' => $insert_id));
                                    $this->Common_model->delete('return_orders_products', array('return_orders_id' => $insert_id));
                                    $this->Common_model->delete('return_order_shipping', array('ship_id' => $insert_ship_id));
                                    $msg = "<div class='alert alert-danger alert-dismissible'>
                                                <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                                                <strong>Error!</strong> Return not Pickable!
                                            </div>";
                                    $this->session->set_flashdata("message", $msg);
                                    redirect('home/myorders');
                                }
                            }
                        }
                        //Update Order Status
                        $up['orders_status'] =23;
                        $up['order_tracking_status'] =3;
                        $this->Common_model->update('orders', $up, array('orders_id' => $order_id,'orders_status'=>4));

                        //Order Request and Return Order Request
                        $insertHistory['orders_id'] = $order_id;
                        $insertHistory['status'] = 23;
                        $insertHistory['date_added'] = date('Y-m-d H:i:s');
                        $insertHistory['comment'] = 'Return Request Pending';
                        $insertHistory['customer_notified'] = 1;
                        $this->Common_model->insert('orders_history', $insertHistory);
                        
                        $RinsertHistory['orders_id'] = $insert_id;
                        $RinsertHistory['status'] = 23;
                        $RinsertHistory['date_added'] = date('Y-m-d H:i:s');
                        $RinsertHistory['comment'] = 'Return Request Pending';
                        $RinsertHistory['customer_notified'] = 1;
                        
			$this->Common_model->insert('return_orders_history', $RinsertHistory);
                        
                        //Send SMS to Customer
                        $msg='Return Request Sent Successfully of Order #ORD'.$order_id .'';
                        $mob=$this->session->userdata("phone");
                        $this->send_data->send_sms($msg,$mob);
						
                        $msg = "<div class='alert alert-success alert-dismissible'>
                                    <a href='#' class='close' data-dismiss='modal' aria-label='close'>&times;</a>
                                    <strong>Success!</strong> Return Request Sent Successfully!
                                </div>";
                        $this->session->set_flashdata("message", $msg);
                        
                        //insert in adminnotify table
                       $msg = 'Return Order Request from '.$this->session->userdata('user_name').' of Order #ORD' . $order_id;
                       $adminNotify = array(
                           'title' => 'Order Return Request',
                           'msg' => $msg . ' ( Web ) ',
                           'type' => 'order_return',
                           'reference_id' => $order_id,
                           'status' => 'Received'
                        );
                       
                       $insertAdminNotify = $this->Product_model->insertAdminNotify($adminNotify);

                       $sellerNotify = array(
                           'title' => 'Order Return Request',
                           'msg' => $msg,
                           'type' => 'order_return',
                           'reference_id' => $order_id,
                           'status' => 'Received'
                        );

                       $this->Product_model->insertSellerNotify($sellerNotify);
                        
                        //Notify To Admin
                        $title='New Order Return  Request!';
                        $message='For Order ORD#'.$order_id;
                        $tag='atzcart.com'; 
                        $this->browser_notification->notifyadmin($title,$message,$tag);
                        redirect('home/myorders');
                        
                    } else {
                        $this->load->view('front/common/header', $data1);
                        $this->load->view('front/order/return_proceed_order_full', $data);
                        $this->load->view('front/common/footer');
                    }
                }else
                {
                    $msg = "<div class='alert alert-danger alert-dismissible'>
			<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
			<strong>Error!</strong> Only Delivered Order Return !
			</div>";
                    $this->session->set_flashdata("message", $msg);
                    redirect('home/myorders');
                }
            }
        }
    }
    
    /* CCAvenue Paymet Gateway */
    
    public function payment_process()
    {
        if($this->input->server("REQUEST_METHOD")!=='POST')
        {
            show_error("Direct script access not allowed.!");
        }

        if (!$this->session->userdata("user_logged_in")) {
            $error = "<div id='login-error' class='form-error notice notice-error'><span class='icon-notice icon-error'></span><span><strong>Error!</strong> Session timeout, relogin!. </span></div>";
            $this->session->set_flashdata("message", $error);
            redirect("login", "refresh");
        }
//        error_reporting(0);
        $merchant_data='';
        $working_key='F01FEB197DF7A57851A8354B75C7FADC';//Shared by CCAVENUES
        $data['access_code']='AVLT86GG37AJ33TLJA';//Shared by CCAVENUES
         
        $user_id = $this->session->userdata('user_id');
        $data['bal']=$this->Common_model->getAll('buyer_wallet',array('user_id'=>$user_id))->row();
        
        $wallet_balance=$this->input->post('wallet_balance');
        $order_price=$this->input->post('order_price');
        $wallet_option=$this->input->post('wallet_option');
        $order_id=$this->input->post('order_id');
        $total_order_amount=$this->input->post('total_order_amount');
        
        $totalOrederAmount='';
        $orders_status='';
        if($wallet_option==='checked' && (int)$data['bal']->balance>=(int)$total_order_amount)
        {
          $orders_status=10;
          $wallet_option= $wallet_option;
         
        }
        else if($wallet_option==='checked' && (int)$total_order_amount>=(int)$data['bal']->balance)
        {
          $orders_status=8;
          $wallet_option= $wallet_option;
        }  
        else
        {
           $orders_status=8;
           $wallet_option= $wallet_option;
        }   
         
//        $updata1['final_price'] = round($totalOrederAmount,2); 
        $updata['orders_status'] = $orders_status;
        $updata['wallet_option'] = $wallet_option;
        
       $up = $this->Common_model->update('orders', $updata, array('orders_id' => $order_id));
//       $up1 = $this->Common_model->update('orders_products', $updata1, array('orders_id' => $order_id));
    
        if($wallet_option==='checked' && $data['bal']->balance>=$total_order_amount)
        {
//          $update_wallet_amount=(int)$data['bal']->balance-(int)$order_price;
          redirect('m/product/order_success_wallet/'.$order_id);
           
        }
        else if($wallet_option==='checked' && $total_order_amount>=$data['bal']->balance)
        {
             foreach ($_POST as $key => $value){
            $merchant_data.=$key.'='.urlencode($value).'&';
        
        }
        
//        $UpdateWalletResult= $this->Wallet_model->update_wallet_amount($data['bal']->id,$wallet_balance); 
        $this->load->library('crypto');
        // $CI = & get_instance();
        $data['encrypted_data']=$this->crypto->encrypt($merchant_data,$working_key); // Method for encrypting the data.
        $this->load->view('ccavenue/ccavenue_payment',$data);

        
        }
        
        else if(empty($wallet_option) || $wallet_option=='unchecked')

        {
            foreach ($_POST as $key => $value){
            $merchant_data.=$key.'='.urlencode($value).'&';
        
            }
            
            $this->load->library('crypto');
            // $CI = & get_instance();
            $data['encrypted_data']=$this->crypto->encrypt($merchant_data,$working_key); // Method for encrypting the data.
            $this->load->view('ccavenue/ccavenue_payment',$data);
        }
        
    }
    
    public function success()
    {
        if($this->input->server("REQUEST_METHOD")!=='POST')
        {
            show_error('Direct script access not allowed.!');
        }
            $this->load->library('crypto');

             $encResp=$_REQUEST['encResp'];
         if(isset($encResp))
         {
             $working_key='F01FEB197DF7A57851A8354B75C7FADC';
             $decryptValues=explode('&',$this->crypto->decrypt($encResp,$working_key));
             $dataSize=sizeof($decryptValues);
             $order_status='';
             $orders_id='';
             $tracking_id='';
             $order_amt='';
             $paymnt_mode='';
             $currency='';
             $merchant_wallet_option='';
                     /*CODE FOR GET YOUR VERIABLE WHEN REDIRECT ON YOUR URL */
            for($i = 0; $i < $dataSize; $i++) 
            {
                $information=explode('=',$decryptValues[$i]);
                
                if(trim($information[0]) === 'order_id')
                {
                     $orders_id = $information[1];
                }
                if(trim($information[0]) === 'tracking_id')
                {
                    $tracking_id = $information[1];
                }
                if(trim($information[0]) === 'order_status')
                {
                    $order_status = $information[1];
                }
                if(trim($information[0]) === 'amount')
                {
                    $order_amt = $information[1];
                }
                if(trim($information[0]) === 'payment_mode')
                {
                     $paymnt_mode = $information[1];
                }
                if(trim($information[0]) === 'currency')
                {
                     $currency = $information[1];
                }
                if(trim($information[0]) === 'trans_date')
                {
                     $trans_date = $information[1];
                }
                if(trim($information[0]) === 'merchant_param1')
                {
                     $merchant_wallet_option = $information[1];
                }
            }
        
            $amt_to_pay = ($order_amt); //From User
           
            $user_id = $this->session->userdata('user_id');
            $data['bal']=$this->Common_model->getAll('buyer_wallet',array('user_id'=>$user_id))->row();
            $email_id=$this->session->userdata('user_email');
            $phone_no=$this->session->userdata('phone');
            $orderDetail = $this->Order_model->getBuyersOrderbyOrderID($orders_id);
           
            $pay_amount = round($orderDetail['grand_price'], 2); //From Database

                /*CHECK PAYMENT IS SUCCESS OR FAIL */
           if(trim($order_status) == 'Success')
            {
            /* DO what ever you want after successful payment */
       
                //Order Request
                $insertHistory['orders_id'] = $orders_id;
                $insertHistory['status'] = 16;
                $insertHistory['date_added'] = date('Y-m-d H:i:s');
                $insertHistory['comment'] = 'Order Accepted';
                $insertHistory['customer_notified'] = 1;
                $this->Common_model->insert('orders_history', $insertHistory);

                $updata['orders_status'] = 10;
                $updata['payment_method'] = $paymnt_mode;
                $updata['wallet_option'] = $merchant_wallet_option;
                $up = $this->Common_model->update('orders', $updata, array('orders_id' => $orders_id));
//                $chk_total_amount=$order_amt+$data['bal']->balance;
                

                  if($up)
                  {
                    $this->addToVendorWallet($orders_id);       
                    /*Redirecting Userorder to addToVendorWallet method*/

                    $output["data"] = $this->Order_model->getBuyersOrderbyOrderID($orders_id);
                    $output["status"] = 1;
                    $output["message"] = "<div class='alert alert-success alert-dismissible'>
                                    <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                                    <strong>Success !</strong> Order Placed Successfully !
                                  </div>";

                        //Order History
                    $orderHistory['orders_id'] = $orders_id;
                    $orderHistory['status'] = 10;
                    $orderHistory['date_added'] = date('Y-m-d H:i:s');
                    $orderHistory['comment'] = 'Order in Processing !';

                    $this->Common_model->insert('orders_history', $orderHistory);

                    $orderDetails = $this->Order_model->getOrderDetailsByOrderId($orders_id);
               
                    $count = count($orderDetails);
                        $j = 0;
                        $pro_name = '';
                        $products_quantity = 0;

                        while ($j < $count) {
                             $pro_name = $orderDetails[$j]['product_name'] . ' ,';
                            // $products_quantity = $products_quantity + $orderDetails[$i]['products_quantity'];

                            $j++;
                        }   

                         //Send SMS to Buyer

                         $message = 'Order Placed: Order Placed Successfully: Order ID- #ORD' . $orders_id . ' is Placed and Amount Received is Rs. ' . $pay_amount . ' You can Track the order on atzcart.com.';
                         $mob = $orderDetail['user_telephone'];
                       
                        $this->send_data->send_sms($message, $mob);
                           //sms send to seller
                        $seller_mob = $orderDetail['pick_mobile'];
                        $message = 'You have a new order from buyer ' . $this->session->userdata('user_name') . ' with order #ORD' . $orders_id . 'Please Visit ATZCart.com for further process.';
                        $this->send_data->send_sms($message, $seller_mob);

                        //Notify To Seller
                        $seller_id = $orderDetail['seller_id'];
                        $title = 'New Order';
                        $msg = " From " . $this->session->userdata('user_name') . ' with order #ORD' . $orders_id;
                        $tag = 'atzcart.com';
                        $this->browser_notification->notifyseller($seller_id, $title, $msg, $tag);

                        //insert in adminnotify table
                        $msg_buyer = "New Order Placed with order #ORD" . $orders_id . ' Click to track Order ';
                        $adminNotify = array(
                            'title' => 'New Order',
                            'msg' => $msg . ' ( Web ) ',
                            'type' => 'order_place',
                            'reference_id' => $orders_id,
                            'status' => 'Received'
                        );
                        $sellerNotify = array(
                            'title' => 'New Order',
                            'msg' => $msg,
                            'type' => 'order_place',
                            'reference_id' => $orders_id,
                            'status' => 'Received'
                        );
                        $buyerNotify = array(
                            'title' => 'New Order',
                            'msg' => $msg_buyer,
                            'user_id' => $user_id,
                            'type' => 'order_place',
                            'reference_id' => $orders_id,
                            'status' => 'Received'
                        );

                        //send Email
                        $this->send_email_order_placed($orders_id);


                        $insertAdminNotify = $this->Product_model->insertAdminNotify($adminNotify);
                        $insertSellerNotify = $this->Product_model->insertSellerNotify($sellerNotify);
                        $insertBuyerNotify = $this->Product_model->insertBuyerNotify($buyerNotify);

                        $this->browser_notification->notifyadmin('New Order Placed !', $msg, $tag);

                        $order = $this->Common_model->getAll("orders", ["orders_id" => $orders_id])->row();

                        $cart_prod = $this->Product_model->get_orderproduct($orders_id);
                        foreach ($cart_prod as $row) {
                            $prod_id[] = $row['products_id'];
                        }
                        
                        $result = $this->Product_model->removeAllProductsOfOrder_id($user_id, $prod_id);
                        $msg = $orders_id;

                        $coupon = $this->Product_model->get_coupononproduct($orders_id);
                        foreach ($coupon as $row) {
                            $coupon_id[] = $row['coupon_id'];
                        }
                        $res = $this->Product_model->updatemycouponStatus($user_id, $coupon_id);

                        $this->session->set_flashdata('message', $msg);
                         
                         $chk_total_amount=$order_amt+$data['bal']->balance;

                    if($param_wallet_option==='checked' && $chk_total_amount>=$data['bal']->balance)
                    {
                        $wallet_balance=0.00;
                        $UpdateWalletResult= $this->Wallet_model->update_wallet_amount($data['bal']->id,$wallet_balance); 
                    }     
                         
                  }
                  else {

                        $msg = '<i class="fa fa-exclamation-triangle" aria-hidden="true"></i><div align="center" style="color: red;">
                                   <div id="login-error" class="form-error notice notice-error">
                                      <span class="icon-notice icon-error"></span>
                                      <span>Error ! Order Not Found !</span>
                                   </div>
                                </div>';
                        $this->session->set_flashdata('message', $msg);
                    }
                
                // redirect('welcome/success');
                // exit;
            }
          else 
          {
               /* do whatever you want after failure */
                $msg = '<i class="fa fa-exclamation-triangle" aria-hidden="true"></i><div align="center" style="color: red;">
                                   <div id="login-error" class="form-error notice notice-error">
                                      <span class="icon-notice icon-error"></span>
                                      <span>Error ! Payment Failed !</span>
                                   </div>
                                </div>';
                    $this->session->set_flashdata('message', $msg);
             // redirect('welcome/failed');
          }
            
         $up=0;
         if($orderDetail['wallet_option']==='checked' && $chk_total_amount>=$data['bal']->balance)
          {
            //Insert Payment Transaction
            $payData['payment_id'] = $tracking_id; //Tras Id
            $payData['user_id'] = $user_id;
            $payData['email'] = $email_id;
            $payData['contact'] = $phone_no;
            $payData['orders_id'] = $orders_id;
            $payData['amount'] = $amt_to_pay;
            $payData['currency'] = $currency;
            $payData['status'] = $order_status;
            $payData['method'] = 'wallet '.$paymnt_mode;
            $payData['platform'] = 'Web';
            $payData['payment_by'] = 'billdesk';
            $payData['description'] = 'Order # '.$orders_id;
            $payData['created_at'] = $trans_date;
            $up = $this->Common_model->insert('order_payment', $payData);

          }
          else{

            //Insert Payment Transaction
            $payData['payment_id'] = $tracking_id; //Tras Id
            $payData['user_id'] = $user_id;
            $payData['email'] = $email_id;
            $payData['contact'] = $phone_no;
            $payData['orders_id'] = $orders_id;
            $payData['amount'] = $amt_to_pay;
            $payData['currency'] = $currency;
            $payData['status'] = $order_status;
            $payData['method'] = $paymnt_mode;
            $payData['platform'] = 'Web';
            $payData['payment_by'] = 'billdesk';
            $payData['description'] = 'Order # '.$orders_id;
            $payData['created_at'] = $trans_date;
            $up = $this->Common_model->insert('order_payment', $payData);
            
          } 

            //Redirct to Page
            if ($msg > 0) {
                redirect(base_url() . "m/product/order_success/".$orders_id);
            } else {
                redirect(base_url() . "m/product/atz_messgae");
            }
        }
        else {
                $msg = '<i class="fa fa-exclamation-triangle" aria-hidden="true"></i><div align="center" style="color: red;">
                                   <div id="login-error" class="form-error notice notice-error">
                                      <span class="icon-notice icon-error"></span>
                                      <span>Error ! Order Failed!</span>
                                   </div>
                                </div>';

                $this->session->set_flashdata('message', $msg);
                redirect(base_url() . "product/atz_messgae");
            }
    }

    public function failed()
    {
    $msg = '<i class="fa fa-exclamation-triangle" aria-hidden="true"></i><div align="center" style="color: red;">
                               <div id="login-error" class="form-error notice notice-error">
                                  <span class="icon-notice icon-error"></span>
                                  <span>Error ! Payment Failed From Buyer Please contact support.!</span>
                               </div>
                            </div>';

            $this->session->set_flashdata('message', $msg);
            redirect(base_url() . "home/myorders");
    }
    private function addToVendorWallet($order_id) {
        $orderInfo = $this->Order_model->getOrderInfo($order_id);
        $this->load->model("Vendorwallet_model");
        $this->load->model("Vendorwallethistory_model");
        $this->Vendorwallet_model->creditVendorPendingWallet($orderInfo->seller_id, $orderInfo->vendor_payable_price);
        $wallet_history = [
            "vendor_id" => $orderInfo->seller_id,
            "order_id" => $order_id,
            "amount" => $orderInfo->vendor_payable_price,
            "status" => "pending",
            "type" => "credit",
            "remark" => "After order payment from mobile app!",
        ];
        $this->Vendorwallethistory_model->addHistory($wallet_history);
    }
    
    function send_email_order_placed($order_id) {
        
        $dat = $this->Common_model->getAll('orders', array('orders_id' => $order_id))->row();

        $buyer_email = $dat->user_email_address;
        $seller_email = $dat->pick_email;

        $data['user_name'] = $dat->user_name;
        $data['pick_name'] = $dat->pick_name;
        $data['order_price'] = $dat->order_price;
        $data['shipping_cost'] = $dat->shipping_cost;
        $data['orders_id'] = $dat->orders_id;
        $data['order_desc'] = $this->Common_model->getAll('orders_products', array('orders_id' => $order_id))->result();

        $from = $this->config->item("default_email_from");

        $to = $buyer_email;
        $mesg = $this->load->view('emailtemplates/buyer_order', $data, true);
        $this->load->library('email');
        $config = array(
            'charset' => 'utf-8',
            'wordwrap' => TRUE,
            'mailtype' => 'html'
        );
        $config['protocol'] = 'smtp';
        $config['smtp_host'] = 'smtp-relay.gmail.com';
        $config['smtp_user'] = 'support@atzcart.com';
        $config['smtp_pass'] = 'asdfghjklQWE123@';
        $config['smtp_port'] = 587;
        $config['smtp_crypto'] = 'tls';
        $this->email->initialize($config);
        $this->email->set_newline("\r\n");
        $this->email->from($from, 'Atzcart');
        $this->email->to($to);
        $this->email->bcc($emailString);
        $this->email->subject('Order Placed Successfully');
        $this->email->message($mesg);
        $this->email->send();

        //For Seller
        $to = $seller_email;
        $mesg2 = $this->load->view('emailtemplates/seller_order', $data, true);

        $config = array(
            'charset' => 'utf-8',
            'wordwrap' => TRUE,
            'mailtype' => 'html'
        );
        $config['protocol'] = 'smtp';
        $config['smtp_host'] = 'smtp-relay.gmail.com';
        $config['smtp_user'] = 'support@atzcart.com';
        $config['smtp_pass'] = 'asdfghjklQWE123@';
        $config['smtp_port'] = 587;
        $config['smtp_crypto'] = 'tls';
        $this->email->initialize($config);
        $this->email->set_newline("\r\n");
        $this->email->from($from, 'Atzcart');
        $this->email->to($to);
        $this->email->bcc($emailString);
        $this->email->subject('New Order Received !');
        $this->email->message($mesg2);
        $this->email->send();
    }
    
    public function notfound()
    {
        $this->output->set_status_header('404');
        $this->load->view('mobile/err404');
    }
    
    public function getProductPriceQtyByOrderId($order_id)
    {
        // $query="select final_price from `product_price` where `quantity_from` <='".$total_quantity."' and `quantity_upto` >= '".$total_quantity."' && product_id='".$product_id."'";
        $this->db->select('*,d.name as country_name');
        $this->db->from('orders a');
        $this->db->join('orders_products b', 'a.orders_id = b.orders_id');
        $this->db->join('orders_status c', 'a.orders_status = c.orders_status_id');
        $this->db->join('country d', 'a.delivery_country = d.id', 'left');
        $this->db->where('a.orders_id', $order_id);
        
        return $query = $this->db->get();
    }
    
    public function topSellingList()
    {
        $topSellings = $this->Product_model->topSellingProductsData();
        $returnTopSellings = $this->Offer_model->appliedOfferProduct($topSellings);
        $data["productlists"]=$returnTopSellings;
        $this->load->view("mobile/topsellinglist_view",$data);
    }

    /* @author Ravindra 03-09-2019
     * Sorting Product value Asc and Desc.
     * Sort Product and return result asc and desc
     */
    public function sortProducts() { 
        $result="";
        $cat_id    = $this->input->post('cat_id');
        $sortby    = $this->input->post('sortby');
        $price_range=$this->input->post('price_range');
        $categories = array_values(array_unique(explode(",", $cat_id . "," . $this->Categories_model->getAllChilds($cat_id))));
        $results = $this->Product_model->getProductsdetailsByCategory($categories,0,"","","","",$sortby);
        $result = $this->Offer_model->appliedOfferProduct1($results);
        // When Price Range click
        if(!empty($price_range))
        {
            $priceRangeArr = explode(';',$price_range);
            $results = $this->Product_model->getProductsdetailsByCategory($categories,0,"","",$priceRangeArr[0],$priceRangeArr[1],"");
            $result = $this->Offer_model->appliedOfferProduct1($results);
        }
        echo json_encode($result);
    }
    
    /*
     * @author Ravindra 05/09/2019
     * @use Function Use For lazy Loading.
     */
   public function loadMoreData(){
       //$this->output->enable_profiler(true);
       $result="";
       $page = $this->input->post("page");
       $category = $this->input->post("category");
       $price_range = $this->input->post("price_range");
       $priceRangeArr = explode(';',$price_range);
       $perpage = 6;
       $start = ceil($page * $perpage);
       $categories = $this->Categories_model->getImidiateChildCategories($category);
       if ($categories) {
                foreach ($categories as $categoryIds) {
                    $catIDs[] = $categoryIds->category_id;
                }
                array_unshift($catIDs, $category);
            } else {
                $catIDs = $category;
        }
        $products = $this->Product_model->getProductsdetailsByCategory($catIDs, $start, $perpage, $min_order, $priceRangeArr[0], $priceRangeArr[1], $sortby);
        $result = $this->Offer_model->appliedOfferProduct1($products);
        if(($min_price ==0 && $max_price !=0) || ($min_price !=0 && $max_price !=0))
        {
            $products = $this->Product_model->getProductsdetailsByCategory($catIDs, $start, $perpage, $min_order, $priceRangeArr[0], $priceRangeArr[1], $sortby);
            $result = $this->Offer_model->appliedOfferProduct1($products);
        }
        echo json_encode($result); 
   }
}
