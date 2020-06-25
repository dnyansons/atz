<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Brands extends CI_Controller 
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
        $this->load->library("Datatables");
        $this->load->library('table');
        $this->load->model('Brand_model');
        $this->load->model('Common_model');
        $this->load->model('adminusers_model', 'adminusers_model');
		 $this->load->library('Userpermission');
    }

    public function index() 
    {
        $this->load->view("admin/brands/list");
    }

    public function ajax_list() 
    {
        $columns = array(
            0 => 'brand_id',
            1 => 'brand_name',
            2 => 'brand_image',
            3 => 'created_at',
            4 => 'updated_at',
        );

        $limit = $this->input->post('length');
        $start = $this->input->post('start');
        $order = $columns[$this->input->post('order')[0]['column']];
        $dir = $this->input->post('order')[0]['dir'];
        $dir ="desc";

        $totalData = $this->Brand_model->allbrand_count();

        $totalFiltered = $totalData;

        if (empty($this->input->post('search')['value'])) {
            $brand = $this->Brand_model->allbrand($limit, $start, $order, $dir);
        } else {
            $search = $this->input->post('search')['value'];

            $brand = $this->Brand_model->brand_search($limit, $start, $search, $order, $dir);

            $totalFiltered = $this->Brand_model->brand_search_count($search);
        }

        $data = array();
        if (!empty($brand)) {
            foreach ($brand as $br) {
                $nestedData['brand_id'] = $br->brand_id;
                $nestedData['brand_name'] = $br->brand_name;
                $nestedData['brand_description'] = $br->brand_description;
                $nestedData['brand_image'] ='<img src="'.base_url().'assets/images/brand/'.$br->brand_image.'" style="width:40px;">';
                $nestedData['created_at'] = $br->created_at;
                $nestedData['updated_at'] = $br->updated_at;
                
                $nestedData['action'] = '<a href="'.base_url().'admin/brands/updatebrand/'.$br->brand_id.'" class="tabledit-edit-button btn btn-primary waves-effect waves-light btn-sm" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit"><i class="fa fa-pencil-square-o fa-2x"></i></a>
                                                                <a  onclick="return confirm(&#39;Are you sure want to Delete Brand ?&#39;)" href="'.base_url().'admin/brands/deletebrand/'.$br->brand_id.'" class="tabledit-delete-button btn btn-danger waves-effect waves-light btn-sm" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete"><i class="fa fa-trash fa-2x"></i></a>';

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


    public function addBrand() // add Brand
    {
        
        
        if($_SERVER['REQUEST_METHOD']=="POST")
        {
            $brand_name=$this->input->post('brand_name');
            $brand_description=$this->input->post('brand_description');
            $seo_title=$this->input->post('seo_title');
            $seo_description=$this->input->post('seo_description');
            $seo_keyword=$this->input->post('seo_keyword');
            $seo_url=$this->input->post('seo_url');
            $brand_image=$_FILES['brand_image']['name'];
            $created_at=date('Y-m-d H:i:s');
            $updated_at=date('Y-m-d H:i:s');
          
            $upload_path='./assets/images/brand';
            

            $config['upload_path']         =  $upload_path;
            $config['allowed_types']       = 'gif|jpg|png|PNG|JPG|JPEG|jpeg';
            $config['max_size']            = 0;
            $config['max_width']           = 0;
            $config['max_height']          = 0;
            $config['overwrite']           = FALSE;
            //$config['file_name']           = "desired file name";
            $config['remove_spaces']       = TRUE;
                
            $this->load->library('upload', $config);

            
            //$this->upload->initialize($config);

            if (!$this->upload->do_upload('brand_image'))// HERE, 'userfile' is the Name of the form field
            {
               $imgdata = array('error' => $this->upload->display_errors());
              
                if(isset($_FILES['brand_image']['name']))
                {
                    $imgdata['upload_data']['file_name']="";
                }
               
            }
            
            else
            {
               $imgdata = array('upload_data' => $this->upload->data());

               $this->load->library('image_lib');

               $configer = array(
                    'image_library' => 'gd2',
                    'source_image' => $imgdata['upload_data']['full_path'],
                    'create_thumb' => FALSE,//tell the CI do not create thumbnail on image
                    'maintain_ratio' => FALSE,
                    'quality' => '75%', //tell CI to reduce the image quality and affect the image size
                    'width' => 370,//new size of image
                    'height' => 330,//new size of image
                );
                    
               $this->image_lib->initialize($configer);
               $this->image_lib->resize();
               $this->image_lib->clear();
            }


            $data=array(
 
            "brand_name"=>$brand_name,
            "brand_description"=>$brand_description,
            "seo_title"=>$seo_title,
            "seo_description"=>$seo_description,
            "seo_keyword"=>$seo_keyword,
            "seo_url"=>$seo_url,
            "brand_image"=>$brand_image,
            "created_at"=>$created_at,
            "updated_at"=>$updated_at
            );

            
            $result=$this->Common_model->insert('brands',$data);


            if($result)
            {
                redirect(base_url()."admin/brands");
            }
            
        }

        else
        {
            $data['title']="Add Brand";
            $admin_username=$this->session->userdata('admin_username');
            $data['admin_data']=$this->adminusers_model->getUserByUsername($admin_username);

          //  $data['categories_list']=$this->Categories_model->getDistinctCategories();

            $this->load->view('admin/common/header', $data);
            $this->load->view('admin/brands/create');
            $this->load->view('admin/common/footer');
        }


    }

    

    public function updateBrand($brand_id) // update updateBrand
    {
        

        if($_SERVER['REQUEST_METHOD']=="POST")
        {
            
			$data['brand_name']=$this->input->post('brand_name');
            $data['brand_description']=$this->input->post('brand_description');
            $data['seo_title']=$this->input->post('seo_title');
            $data['seo_description']=$this->input->post('seo_description');
            $data['seo_keyword']=$this->input->post('seo_keyword');
            $data['seo_url']=$this->input->post('seo_url');
            $brand_image=$_FILES['brand_image']['name'];
			if(!empty($brand_image))
			{
				$data['brand_image']=$_FILES['brand_image']['name'];
			}
			
            $data['updated_at']=date('Y-m-d H:i:s');

            //$path=$_SERVER['DOCUMENT_ROOT'].'/atzcart/assets/images';
            $upload_path='./assets/images/brand';
            

            $config['upload_path']         =  $upload_path;
            $config['allowed_types']       = 'gif|jpg|png|PNG|JPG|JPEG|jpeg';
            $config['max_size']            = 0;
            $config['max_width']           = 0;
            $config['max_height']          = 0;
            $config['overwrite']           = FALSE;
            //$config['file_name']           = "desired file name";
            $config['remove_spaces']       = TRUE;
                
            $this->load->library('upload', $config);

            
            //$this->upload->initialize($config);
			if(!empty($brand_image))
			{
					if (!$this->upload->do_upload('brand_image'))// HERE, 'userfile' is the Name of the form field
					{
					   $imgdata = array('error' => $this->upload->display_errors());
					  
						if(isset($_FILES['brand_image']['name']))
						{
							$imgdata['upload_data']['file_name']="";
						}
					   
					}
					
					else
					{
					   $imgdata = array('upload_data' => $this->upload->data());

					   $this->load->library('image_lib');

					   $configer = array(
							'image_library' => 'gd2',
							'source_image' => $imgdata['upload_data']['full_path'],
							'create_thumb' => FALSE,//tell the CI do not create thumbnail on image
							'maintain_ratio' => FALSE,
							'quality' => '75%', //tell CI to reduce the image quality and affect the image size
							'width' => 370,//new size of image
							'height' => 330,//new size of image
						);
							
					   $this->image_lib->initialize($configer);
					   $this->image_lib->resize();
					   $this->image_lib->clear();
					}
			}


          

            
            $result=$this->Common_model->update("brands",$data,array("brand_id"=>$brand_id));


            if($result)
            {
				$msg='Update Successfully !';
				$this->session->set_flashdata('message',$msg);
                redirect(base_url()."admin/brands");
            }

            
        }

        else
        {
            $data['title']="Edit Brand";
            $admin_username=$this->session->userdata('admin_username');
            $data['admin_data']=$this->adminusers_model->getUserByUsername($admin_username);

            
            $data['brand_data'] = $this->Common_model->getAll("brands",array("brand_id"=>$brand_id))->row();

        

            $this->load->view('admin/common/header', $data);
            $this->load->view('admin/brands/edit', $data);
            $this->load->view('admin/common/footer');
        }
        
    }


    public function deletebrand($brand_id) // delete category
    {
			 $ch = $this->Common_model->getAll("products",array("brand_id"=>$brand_id))->num_rows();
			if($ch > 0)
			{
				 $msg='Cant Delete ! Brand already Used in Product ';
					$this->session->set_flashdata('message',$msg);
				   redirect(base_url()."admin/brands");
			}
			else{
				$result=$this->Brand_model->deleteBrandData($brand_id);

				if($result)
				{
				   $msg='Delete Successfully !';
					$this->session->set_flashdata('message',$msg);
				   redirect(base_url()."admin/brands");
				}
			}

    }


}
