<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Review extends CI_Controller 
{
    public function __construct() 
    {
        
        parent::__construct();
        if (!$this->session->userdata("user_logged_in") || $this->session->userdata("user_role")!="seller") {
            $error = "<div id='login-error' class='form-error notice notice-error'><span class='icon-notice icon-error'></span><span><strong>Error!</strong> Session timeout, relogin!. </span></div>";
            $this->session->set_flashdata("message", $error);
            redirect("login", "refresh");
        }
        $this->load->library("Datatables");
        $this->load->library('table');
        $this->load->model('Review_model');
        $this->load->model('Common_model');
        $this->load->model('adminusers_model', 'adminusers_model');
    }

    public function index() 
    {
        $this->load->view("user/product/review");
    }
    


    public function ajax_list() 
    {
        $supplier_id=$this->session->userdata("user_id");
        //$supplier_id=3;
        
        $columns = array(
            0 => 'reviews_id',
            1 => 'user_name',
            2 => 'reviews_rating',
            3 => 'products_name',
            4 => 'date_added'
        );

        $limit = $this->input->post('length');
        $start = $this->input->post('start');
        $order = $columns[$this->input->post('order')[0]['column']];
        $dir = $this->input->post('order')[0]['dir'];

        $totalData = $this->Review_model->allreview_count($supplier_id);
        
        

        $totalFiltered = $totalData;

        if (empty($this->input->post('search')['value'])) {
            $review = $this->Review_model->allreview($limit, $start, $order, $dir, null, $supplier_id);
        } else {
            $search = $this->input->post('search')['value'];

            $review = $this->Review_model->review_search($limit, $start, $search, $order, $dir, $supplier_id);

            $totalFiltered = $this->Review_model->review_search_count($search, $supplier_id);
        }

         //$replydata=$this->Review_model->getReplydata(1);

        $data = array();
        if (!empty($review)) {
            
            foreach ($review as $revi) {
                
                $replydata=$this->Review_model->getReplydata($revi->reviews_id);
                
                if(isset($replydata) && $replydata!="")
                {
                    $replied="yes";
                }
                
                else
                {
                    $replied="no";
                }
                
                $nestedData['reviews_id'] = $revi->reviews_id;
                $nestedData['user_name'] = $revi->user_name;
                $nestedData['reviews_rating'] = $revi->reviews_rating;
                $nestedData['products_name'] = $revi->products_name;
                $nestedData['date_added'] = $revi->date_added;
                $nestedData['action'] = '<button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#review_modal" data-placement="top" title="" data-original-title="View" data-reviewid="'.$revi->reviews_id.'" data-username="'.$revi->user_name.'" data-rating="'.$revi->reviews_rating.'" data-products_name="'.$revi->products_name.'" data-text="'.$revi->review_text.'" data-dateadded="'.$revi->date_added.'" data-replied="'.$replied.'" data-myreply="'.$replydata->reply_text.'"><i class="fa fa-eye"></i></button>';
                
                if($replied=="yes")
                {
                    $nestedData['action'].='&nbsp;&nbsp;<span style="color:green;"><i class="fa fa-check"></i>Replied</span>';
                }
                
                else
                {
                    $nestedData['action'].='';
                }
                
                $data[] = $nestedData;
            }
        }

        $json_data = array(
            "draw" => intval($this->input->post('draw')),
            "recordsTotal" => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data" => $data
        );

        echo json_encode($json_data);
    }
    
    public function delete_review($reviews_id)
    {
       $this->Review_model->review_delete($reviews_id);
       redirect(base_url()."seller/review");
    }
    
    public function review_reply()
    {
        $reply_data=array(
        "reviews_id"=>$this->input->post('reviews_id'),
        "reply_text"=>$this->input->post('reply_text'),
        "reply_by_supplier_id"=>$this->input->post('reply_by_supplier_id'),
        "date_added"=>date('Y-m-d H:i:s')
        );
        
        $res=$this->Review_model->review_reply_data($reply_data);
        
        if($res)
        {
            echo json_encode(array("status"=>"success"));
            exit;
        }
        
        else
        {
            echo json_encode(array("status"=>"failed"));
            exit;
        }
        
    }

}
