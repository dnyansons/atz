<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//require('MySoapClient.php');
use Firebase\JWT\JWT;

class Reviews extends REST_Controller 
{

    private $_payload;

    public function __construct($config = 'rest') 
    {
        parent::__construct($config);
        $token = $this->input->get_request_header('Token');
        try {
            $this->_payload = JWT::decode($token, $this->config->item('jwt_secret_key'), array('HS256'));
        } catch (Exception $ex) {
            $output = array("status" => 0, "message" => $ex->getMessage());
            $this->response($output, REST_Controller::HTTP_UNAUTHORIZED);
        }
        $this->load->library('form_validation');
        $this->load->model('Order_model');
        $this->load->model('Product_model');
        $this->load->model('Users_model');
        $this->load->model('Common_model');
        $this->load->model('Categories_model');
        $this->load->model('Coupon_model');
        $this->load->model('Review_model');
    }
    
    public function addReview_post()
    {
        $ws = $this->post("ws");
        if (empty($ws)) {
            $ws = "addReview";
        }

        $this->form_validation->set_rules("products_id", "products_id", "required");
        $this->form_validation->set_rules("rating", "rating", "required");
        $this->form_validation->set_rules("comment", "comment", "required");

        if ($this->form_validation->run() === false)
        {
            $output = array(
                "ws" => $ws,
                "status" => 0,
                "message" => "Invalid Inputs"
            );
            $this->response($output, REST_Controller::HTTP_OK);
        } 

        else
        {
            $products_id = $this->post('products_id');
            $rating = $this->post('rating');
            $comment = $this->post('comment');

            $reviews_data=array(
               "user_id"=>$this->_payload->userid,
               "user_name"=>$this->_payload->user_full_name,
               "products_id"=>$products_id,
               "reviews_rating"=>$rating,
               "date_added"=>date('Y-m-d H:i:s'),
               "last_modified"=>date('Y-m-d H:i:s'),
               "reviews_read"=>0,
               "status"=>"Active"
            ); 
 
            $review_id=$this->Review_model->addReviewData($reviews_data);
            $this->product_review_notify($products_id,$this->_payload->userid);
            $reviews_description_data=array(
               "reviews_id"=>$review_id,
               "review_text"=>$comment
            );

            $this->Review_model->addReviewDescriptionData($reviews_description_data);

            $output["ws"] = $ws;
            $output["status"] = 1;
            $output["message"] = "Review added successfully.";
            $this->response($output, REST_Controller::HTTP_OK);
        }
    }


    public function getReviewsList_get()
    {
        $ws = $this->get("ws");
        if (empty($ws)) {
            $ws = "getReviewsList";
        }

        $data=$this->Review_model->getReviewsListData($this->_payload->userid);

        $output["ws"] = $ws;
        $output["status"] = 1;
        $output["message"] = "Reviews list successfully fetched.";
        
        $this->response($output, REST_Controller::HTTP_OK);
    }
    
     function product_review_notify($prod_id = 0,$user_id) {


        $this->load->library("Browser_notification");

        $this->db->select('id,name,seller');
        $this->db->from('product_details');
        $this->db->where('id',$prod_id);
        $dat=$this->db->get()->row();
        
        $this->db->select('first_name,last_name');
        $this->db->from('users');
        $this->db->where('id',$user_id);
        $user=$this->db->get()->row();
        
        $seller_id = $dat->seller;
        $prod_name = $dat->name;
        $user_name = $user->first_name.' '.$user->last_name;
        
        
            $title = 'New Product Review';
            $msg = "Review On Product '.$prod_name.' By Buyer " . $user_name;
            $tag = date('d M Y');
            $this->browser_notification->notifyseller($seller_id, $title, $msg, $tag);

       
         $msg = "Review On Product '.$prod_name.' By Buyer " . $user_name;
         $tag = date('d M Y');
        $this->browser_notification->notifyadmin('Product Review', $msg, $tag);
    }
    
    

}