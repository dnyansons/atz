<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Banners extends CI_Controller 
{

    public function __construct() 
    {
        parent::__construct();
        if (!$this->session->userdata("admin_logged_in")) {
            $error = "<div class='alert alert-danger alert-dismissible'>
                        <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                        <strong>Error!</strong> Session timeout, relogin!.
                      </div>";
            $this->session->set_flashdata("message", $error);
            redirect("admin/login", "refresh");
        }
        $this->load->model('Banners_model');
		 $this->load->model('Categories_model');
        $this->load->library('form_validation');
        $this->load->library('Userpermission');
        $this->load->library("awsupload");
    }

    public function index() 
    {
        $data["pageTitle"] = "Banner Settings";
        $data["items"]=$this->Banners_model->get_all_banners();
        $this->load->view("admin/banner/list",$data);
    }

    public function add_banner() 
    {
        $this->form_validation->set_rules("banner_title","Title","required");
        $this->form_validation->set_rules("sort_order","Order","required");
        $this->form_validation->set_rules("expire_on","Expity date","required");
        if (empty($_FILES['banner_image']['name'])) {
            $this->form_validation->set_rules('banner_image', 'Image', 'required');
        }
        if($this->form_validation->run()===false){
            $data["pageTitle"] = "Add New Banner";
            $data['categories_list'] = $this->Categories_model->get_categories();
            $this->load->view("admin/banner/add",$data);
        } else {
            $image_info = getimagesize($_FILES["banner_image"]["tmp_name"]);
            $image_width = $image_info[0];
            $image_height = $image_info[1];
            // $filesize = round(filesize($_FILES["banner_image"]["tmp_name"]) / 900,2);

            $checkImageSizes = $this->awsupload->checkImageSize('banner_image', 'web_banner');

            if($checkImageSizes !== true)
             {
               
               $message = "<div class='alert alert-danger alert-dismissible text-left'>
                            <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                            <strong>Invalid image!</strong> 900 * 400 image of max size 150 Kb is allowed to upload.
                          </div>";
                $this->session->set_flashdata("message",$message);
                redirect("admin/banners","refresh");
             }   
            else {
 
                $url = $this->awsupload->upload("banner_image","uploads/banners","image");
                $insertData = [
                    "banners_title" => $this->input->post("banner_title"),
                    "banners_url"   => $url,
                    "banners_image" => basename($url),
                    "banners_group" => "slider",
                    "expire_date"   => date("Y-m-d", strtotime($this->input->post("expire_on"))),
                    "sort_order"    => $this->input->post("sort_order"),
                    "banner_type"   => $this->input->post("banner_type"),
                    "category"      => $this->input->post("category"),
                    "status" 	    => $this->input->post("status"),
                ];
                $result = $this->Banners_model->add_banner($insertData);
                $message = "<div class='alert alert-success alert-dismissible text-left'>
                            <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                            <strong>Success!</strong> Banners added successfully.
                          </div>";
                $this->session->set_flashdata("message",$message);
                redirect("admin/banners","refresh");
            }
            
        }
    }

    public function edit_banner($id) {

        $data['banners'] = $this->Banners_model->get_banners($id);
		$data['categories_list'] = $this->Categories_model->get_categories();
	
        if ($_SERVER['REQUEST_METHOD'] == "POST") {

            $this->form_validation->set_rules('banner_title', 'Banner Title', 'required');
            $this->form_validation->set_rules('sort_order', 'Sort Order', 'required');
            $this->form_validation->set_rules('status', 'status', 'required');
            $this->form_validation->set_rules('date', 'date', 'required');

            if ($this->form_validation->run()) {
                $arr = array();
                $flag = 0;
                if ($_FILES['banner_image']['name'] != "") {
                   
                $image_info = getimagesize($_FILES["banner_image"]["tmp_name"]);
                $image_width = $image_info[0];
                $image_height = $image_info[1];
                // $filesize = round(filesize($_FILES["banner_image"]["tmp_name"]) / 1024,2);

            $checkImageSizes = $this->awsupload->checkImageSize('banner_image', 'web_banner');

               if($checkImageSizes !== true){

                    $message = "<div class='alert alert-danger alert-dismissible text-left'>
                            <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                            <strong>Invalid image!</strong> $checkImageSizes.
                          </div>";
                    $this->session->set_flashdata("message",$message);
                    redirect("admin/banners","refresh");
                    exit;
                }

                $ImageUrl = $this->awsupload->upload("banner_image","uploads/banners","image");

                    if($ImageUrl==false)
                    {
                         $error = "<div class='alert alert-danger alert-dismissible'>
                                <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                                <strong>Error!</strong> Invalid File Type!.
                              </div>";
                        $this->session->set_flashdata("message",$error);

                        redirect('admin/banners');
                    }
                    else
                    {
                        $configer = array(
                            'image_library' => 'gd2',
                            'source_image' => json_encode($ImageUrl),
                            'create_thumb' => TRUE, //tell the CI do not create thumbnail on image
                            'thumb_marker' => '_thumb',
                            'maintain_ratio' => FALSE,
                            'quality' => '75%', //tell CI to reduce the image quality and affect the image size
                            'width' => 370, //new size of image
                            'height' => 330, //new size of image
                        );

                        $this->image_lib->initialize($configer);
                        $this->image_lib->resize();
                        $this->image_lib->clear();

                    }
                  
                } else {
                    $arr['banners_image'] = $this->input->post('banner_image_old');
                }
                if ($flag == 0) {
                    
					$banner_type = $this->input->post('banner_type');
                    $arr["banners_title"] = $this->input->post('banner_title');
                    $arr["sort_order"] = $this->input->post('sort_order');
                    $arr["status"] = $this->input->post('status');
                    $arr['expire_date'] = date('Y-m-d', strtotime($this->input->post('date')));
					
                    if($banner_type == "Category")
                    {
                            $arr["category"] = $this->input->post('category');
                    }else{
                            $arr["category"] = '';
                    }
                    $arr["banner_type"] = $banner_type;


                    $result = $this->Banners_model->edit_banner($id, $arr);
                    $error = "<div class='alert alert-success alert-dismissible'>
                                <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                                <strong>Success!</strong> Banner updated sucessfully!.
                              </div>";
                    $this->session->set_flashdata("message",$error);

                    redirect('admin/banners');
                }
            }
        }
        $this->load->view("admin/banner/edit", $data);
    }

    public function delete_banner($id) 
    {
        $error = "<div class='alert alert-success alert-dismissible'>
                    <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                    <strong>Success!</strong> Banner removed sucessfully!.
                  </div>";
        $this->session->set_flashdata("message",$error);

        $result = $this->Banners_model->delete_banner($id);
        redirect('admin/banners');
    }
    
    /**
     * @auther Yogesh Pardeshi 21092018
     * @param 
     * @return 
     * @use
     **/
    public function toggleBanner() {
       $bannerId = $this->input->post('toggleBannerId');        
       $bannerStatus = $this->input->post('toggltBannerVal');
       //print_r(var_dump($bannerStatus));
        if($bannerId != 0){
            $status = $bannerStatus == 1 ? 0 : 1;
            $result =  $this->db->set("status", $status)
                            ->where("banners_id", $bannerId)
                            ->update('banners');
           //echo $this->db->last_query();
           echo $status;
        } 
    }

}
