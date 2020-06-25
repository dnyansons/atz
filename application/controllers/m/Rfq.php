<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Rfq extends CI_Controller {

    public function __construct() {
        parent::__construct();
        if (!$this->session->userdata("user_logged_in")) {
            redirect("signin", "refresh");
        }
        $this->load->model('Product_model');
        $this->load->model('Units_model');
        $this->load->model('Rfqs_model');
        $this->load->model('Rfqs_model');
        $this->load->library('session');
        $this->load->library('awsupload');

       
    }

    public function index() {
         $data['units'] = $this->Units_model->getAll(); 
        $this->load->view("mobile/rfq_view", $data);
    }
    
    public function rfq_product($product_id) {
        $data['productinfos'] = $this->Product_model->getProductDetails($product_id);
         $data['units'] = $this->Units_model->getAll(); 

        $this->load->view("mobile/rfq_view", $data);
    }

    public function insertRfq() {
        
         $this->load->helper('file');
        $this->load->library("form_validation");
        $this->form_validation->set_rules("quantity", "Quantity", "required");
        $this->form_validation->set_rules("unit", "Unit", "required");
        $this->form_validation->set_rules("details", "Details", "required");
        // $this->form_validation->set_rules('quote_attachment[]', '', 'callback_file_check');
        if ($this->form_validation->run() === false) {

             $this->session->set_flashdata('message', validation_errors());

            redirect(base_url()."m/Rfq", "refresh");
        } else {
            $checklist_attachment = array();
            
            if (!empty($_FILES['quote_attachment']['name'][0])) {
    
                $files = $_FILES;
                  
             $img_path=$this->awsupload->multiUpload($_FILES, 'uploads/images/rfqs','image');
             if($img_path==false)
             {
                $msg= '<div class="alert alert-danger alert-dismissible">
                                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                    <strong>Error!</strong> Invalid File Type.Please Select jpeg/jpg/png.!
                                </div>';
                $this->session->set_flashdata('message',$msg);
                redirect(base_url().'m/Rfq');
             }
             else
             {
                   $cpt = count($_FILES['quote_attachment']['name']);
                   $img_implode=implode(",",$img_path);
                   $checklist_attachment[] = $img_implode;
             }
                

            } else {
                $checklist_attachment = 0;
            }
            if ($checklist_attachment === 0) {
                $encode_image = "";
            } else {
               $encode_image =json_encode($checklist_attachment) ;
            }
            $insertData["customer_id"] = $this->session->userdata("user_id");
            $insertData["attachments"] = $encode_image;
            $insertData["looking_for"] = $this->input->post("pname");
            $insertData["quanity"] = $this->input->post("quantity");
            $insertData["unit"] = $this->input->post("unit");
            $insertData["description"] = $this->input->post("details");
            $insertData["agree_share_contact"] = $this->input->post("shareConsent") ? 'true' : 'false';
            $insertData["status"] = 'Pending';
            $insertData["added_date"] = date('Y-m-d H:i:s');
            $rfq_id=$this->Rfqs_model->addRfq($insertData);
          
            if(!empty($rfq_id)){
               $rfq=$this->Rfqs_model->getRfqById($rfq_id);
               $data['rfq']=$rfq;
            }
             $this->load->view("mobile/rfq_sent_view",$data);
        }
    }


    /*
    @author Ishwar
     * file value and type check during validation
     */

     public function file_check($str){

        $allowed_mime_type_arr = array('application/pdf','image/jpeg','image/jpg','image/png');
         $mime = get_mime_by_extension($str);
        
        if(isset($str) && $str!=""){
            if(in_array($mime, $allowed_mime_type_arr)){
                return true;
            }else{

                 $msg= '<div class="alert alert-danger alert-dismissible">
                                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                    <strong>Error!</strong> Please select only jpeg/jpg/png file.!
                                </div>';
            $this->session->set_flashdata('message',$msg);
             redirect(base_url().'m/Rfq');
            // $this->form_validation->set_message('file_check', 'Please select only pdf/jpg/png file.');
                return false;
            }
        }else{

             $msg= '<div class="alert alert-danger alert-dismissible">
                                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                    <strong>Error!</strong> Please choose a file to upload.!
                                </div>';
             $this->session->set_flashdata('message',$msg);     
            redirect(base_url().'m/Rfq');         
             // $this->form_validation->set_message('file_check', 'Please choose a file to upload.');
            return false;
        }
       
    }
}

?>