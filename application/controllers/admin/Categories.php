<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Categories extends CI_Controller {

    public function __construct() {
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
        $this->load->library("form_validation");
        $this->load->library('table');
        $this->load->model('Categories_model');
        $this->load->model('adminusers_model', 'adminusers_model');
        $this->load->library('Userpermission');
        $this->load->library('awsupload');
        $this->load->helper("file");
    }

    public function index() {
        $this->load->view("admin/categories/list");
    }

    public function ajax_list() {
        $columns = array(
            0 => 'category_id',
            1 => 'categories_name',
            2 => 'parent_id',
        );

        $limit = $this->input->post('length');
        $start = $this->input->post('start');
        $order = $columns[$this->input->post('order')[0]['column']];
        //$dir = $this->input->post('order')[0]['dir'];
        $dir = "desc";

        $totalData = $this->Categories_model->allcategory_count();

        $totalFiltered = $totalData;

        if (empty($this->input->post('search')['value'])) {
            $category = $this->Categories_model->allcategory($limit, $start, $order, $dir);
        } else {
            $search = $this->input->post('search')['value'];

            $category = $this->Categories_model->category_search($limit, $start, $search, $order, $dir);

            $totalFiltered = $this->Categories_model->category_search_count($search);
        }

        $data = array();
        if (!empty($category)) {
            foreach ($category as $cat) {
                $nestedData['id'] = $cat->category_id;
                $nestedData['name'] = $cat->categories_name;
                $nestedData['parent'] = $cat->parent_name;
                $nestedData['created_at'] = '<a href="' . base_url() . 'admin/categories/attributes/' . $cat->category_id . '" class="tabledit-edit-button btn btn-primary waves-effect waves-light btn-sm" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit"><i class="fa fa-eye"></i></a>';
                $nestedData['specifications'] = '<a href="' . base_url() . 'admin/categories/specifications/' . $cat->category_id . '" class="tabledit-edit-button btn btn-primary waves-effect waves-light btn-sm" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit"><i class="fa fa-eye"></i></a>';
                $nestedData['action'] = '<a href="' . base_url() . 'admin/categories/updatecategory/' . $cat->category_id . '" class="tabledit-edit-button btn btn-primary waves-effect waves-light btn-sm" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit"><i class="fa fa-pencil-square-o"></i></a>
                                                                <a href="' . base_url() . 'admin/categories/deletecategory/' . $cat->category_id . '" class="tabledit-delete-button btn btn-danger waves-effect waves-light btn-sm" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete"><i class="fa fa-trash"></i></a>';

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

    public function addCategory() {

        $this->form_validation->set_rules("category_name", "Name", "required");
        $this->form_validation->set_rules("parent_category", "Parent", "required");
        $this->form_validation->set_rules("sort_order", "Order", "required");
        $this->form_validation->set_rules("seo_title", "Title", "required");
        $this->form_validation->set_rules("seo_description", "Description", "required");
        $this->form_validation->set_rules("seo_keywords", "Keywords", "required");
        $this->form_validation->set_rules("seo_url", "Name", "required");
        if ($this->form_validation->run() === false) {
            $data['title'] = "Add Category";
            $admin_username = $this->session->userdata('admin_username');
            $data['admin_data'] = $this->adminusers_model->getUserByUsername($admin_username);
            $data['categories_list'] = $this->Categories_model->getDistinctCategories();
            //echo "<pre>";
            //print_r($data);
            $this->load->view('admin/common/header', $data);
            $this->load->view('admin/categories/create');
            $this->load->view('admin/common/footer');
        } else {

            if ($_FILES['category_image']['name'] != '' || !empty($_FILES['category_image']['name'])) {

                $checkImageSizes = $this->awsupload->checkImageSize('category_image', 'category');

                if($checkImageSizes !== true)
                 {
                      $error = "<div class='alert alert-danger alert-dismissible'>
                                <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                                <strong>Invalid image!</strong> $checkImageSizes.!
                                </div>";
                    $this->session->set_flashdata("message", $error);
                    redirect("admin/categories/addCategory", "refresh");
                    exit;
                 }   

                $s3FilePath = $this->awsupload->upload('category_image', 'uploads/images/categories', 'image');
                if ($s3FilePath == false) {
                    $error = "<div class='alert alert-danger alert-dismissible'>
                                <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                                <strong>Error!</strong> File type not allowed.!
                                </div>";
                    $this->session->set_flashdata("message", $error);
                    redirect("admin/categories/addCategory", "refresh");
                } else {
                    $insertData['categories_image'] = $s3FilePath;
                }
            } else {
                $insertData['categories_image'] = '';
            }

            if ($_FILES['banner_image']['name'] != '' || !empty($_FILES['banner_image']['name'])) {

                $fileDetails=getimagesize($_FILES['banner_image']['tmp_name']);

                $width = $fileDetails[0];
                $height = $fileDetails[1];

                $checkImageSizes = $this->awsupload->checkImageSize('banner_image', 'category_banner');

                if($checkImageSizes!==true)    
                {
                    $error = "<div class='alert alert-danger alert-dismissible'>
                                <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                                 <strong>Invalid image!</strong> $checkImageSizes.!
                                </div>";
                    $this->session->set_flashdata("message", $error);
                    redirect("admin/categories/addCategory", "refresh");
                    exit;
                }
 
                $s3FilePath = $this->awsupload->upload('banner_image', 'uploads/images/banners', 'image');
                if ($s3FilePath == false) {
                    $error = "<div class='alert alert-danger alert-dismissible'>
                                <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                                <strong>Error!</strong> Please select only jpg|png file.!
                                </div>";
                    $this->session->set_flashdata("message", $error);
                    redirect("admin/categories/addCategory", "refresh");
                } else {
                    $insertData['banner_image'] = $s3FilePath;
                }
            } else {
                $insertData['banner_image'] = '';
            }

            $insertData['parent_id'] = $this->input->post("parent_category");
            $insertData['sort_order'] = $this->input->post("sort_order");
            $insertData['seo_title'] = $this->input->post("seo_title");
            $insertData['seo_description'] = $this->input->post("seo_description");
            $insertData['seo_keywords'] = $this->input->post("seo_keywords");
            $insertData['seo_url'] = $this->input->post("seo_url");

            $cat_id = $this->Categories_model->addCategory($insertData);
            $desc = [
                "categories_name" => $this->input->post("category_name"),
                "categories_id" => $cat_id,
                "language_id" => 1
            ];
            $this->Categories_model->addCategoryDesc($desc);

            $error = "<div class='alert alert-success alert-dismissible'>
                                <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                                <strong>Success!</strong> Categories Details Successfully Added.!
                                </div>";
             $this->session->set_flashdata("message", $error);

            redirect("admin/categories", "refresh");
        }
    }

    public function updateCategory($category_id) {
        if ($_SERVER['REQUEST_METHOD'] == "POST") {

            $category_name = $this->input->post('category_name');
            $select_parent_category = $this->input->post('select_parent_category');
            $category_image = $_FILES['category_image']['name'];
            $banner_image = $_FILES['banner_image']['name'];
            $sort_order = $this->input->post('select_sort_order');

            $seo_title = $this->input->post('seo_title');
            $seo_description = $this->input->post('seo_description');
            $seo_keywords = $this->input->post('seo_keywords');
            $seo_url = $this->input->post('seo_url');

            $data = array(
                "categories_id" => $category_id,
                "categories_name" => $category_name,
                "parent_id" => $select_parent_category,
                "sort_order" => $sort_order,
                "seo_title" => $seo_title,
                "seo_description" => $seo_description,
                "seo_keywords" => $seo_keywords,
                "seo_url" => $seo_url,
            );

            if ($_FILES['category_image']['name'] != '' || !empty($_FILES['category_image']['name']) || $_FILES['category_image']['name'] != null) {

                $s3FilePath = $this->awsupload->upload('category_image', 'uploads/images/categories', 'image');
                if ($s3FilePath == false) {
                    //error
                    $error = "<div class='alert alert-danger alert-dismissible'>
                                <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                                <strong>Error!</strong> Please select only jpg|png file for category.!
                                </div>";
                    $this->session->set_flashdata("message", $error);
                    redirect("admin/categories/updateCategory/".$category_id, "refresh");
                } else {
                    //success
                    $data["categories_image"] = $s3FilePath;
                }
            }

            if ($_FILES['banner_image']['name'] != '' || !empty($_FILES['banner_image']['name']) || $_FILES['banner_image']['name'] != null) {


                $checkImageSizes = $this->awsupload->checkImageSize('banner_image', 'category_banner');

                if($checkImageSizes!==true)    
                {
                    $error = "<div class='alert alert-danger alert-dismissible'>
                                <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                                 <strong>Invalid image!</strong> 1200 * 184 image of max size 150  to upload..!
                                </div>";
                    $this->session->set_flashdata("message", $error);
                    redirect("admin/categories/updateCategory/".$category_id, "refresh");
                    //exit;
                }

                $s3FilePath = $this->awsupload->upload('banner_image', 'uploads/images/categories/banner', 'image');
                if ($s3FilePath == false) {
                    //error
                    $error = "<div class='alert alert-danger alert-dismissible'>
                                <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                                <strong>Error!</strong> Please select only jpg|png file for  banners.!
                                </div>";
                    $this->session->set_flashdata("message", $error);
                    redirect("admin/categories/addCategory", "refresh");
                } else {
                    //success
                    $data["banner_image"] = $s3FilePath;
                }
            }
            $result = $this->Categories_model->updateCategoryData($data);
            if ($result) {
                $message = "<div class='alert alert-success alert-dismissible'>
                    <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                    <strong>Success!</strong> Category updated successfully!.
                  </div>";
                $this->session->set_flashdata('message', $message);
                redirect(base_url() . "admin/categories");
            } else {
                $message = "<div class='alert alert-danger alert-dismissible'>
                    <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                    <strong>Success!</strong> Category not updated!.
                  </div>";
                $this->session->set_flashdata('message', $message);
                redirect(base_url() . "admin/categories");
            }
        } else {
            $data['title'] = "Edit Category";
            $admin_username = $this->session->userdata('admin_username');
            $data['admin_data'] = $this->adminusers_model->getUserByUsername($admin_username);

            $data['categories_list'] = $this->Categories_model->getDistinctCategories();

            $data['category_data'] = $this->Categories_model->getCategoryData($category_id);

            $this->load->view('admin/common/header', $data);
            $this->load->view('admin/categories/edit', $data);
            $this->load->view('admin/common/footer');
        }
    }

    public function deleteCategory($category_id) { // delete category
        $result = $this->Categories_model->deleteCategoryData($category_id);

        if ($result) {
            $message = "<div class='alert alert-success alert-dismissible'>
                    <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                    <strong>Success!</strong> Category Deleted Successfully.
                  </div>";
            $this->session->set_flashdata("message", $message);
            redirect(base_url() . "admin/categories");
        }
    }

    public function attributes($cat_id = 0) {
        if ($cat_id) {
            $data["pageTitle"] = "Category Specific Attributes";
            $data["cat_id"] = $cat_id;
            $data['attributes'] = $this->Categories_model->getCategoryAttributes($cat_id);
            $this->load->view("admin/categories/attributes", $data);
        } else {
            $message = "<div class='alert alert-danger alert-dismissible'>
                    <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                    <strong>Error!</strong> Please select valid category first.
                  </div>";
            $this->session->set_flashdata("message", $message);
            redirect("admin/categories", "refresh");
        }
    }

    public function createAttribute($cat_id = 0) {
        if ($cat_id) {
            $this->form_validation->set_rules("name", "Name", "required");
            $this->form_validation->set_rules("type", "type", "required");
            $this->form_validation->set_rules("is_compulsary", "Compulsory", "required");
            if ($this->form_validation->run() === false) {
                $data["cat_id"] = $cat_id;
                $this->load->view("admin/categories/createAttribute", $data);
            } else {
                $choices = json_encode(explode(",", $this->input->post("choices")));
                $insertData = [
                    "category_id" => $cat_id,
                    "name" => $this->input->post("name"),
                    "choices" => $choices,
                    "type" => $this->input->post("type"),
                    "is_required" => $this->input->post("is_compulsary")
                ];
                $this->Categories_model->addAttribute($insertData);
                $message = "<div class='alert alert-success alert-dismissible'>
                        <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                        <strong>Succcess!</strong> Attribute added to selected category.
                      </div>";
                $this->session->set_flashdata("message", $message);
                redirect("admin/categories/attributes/" . $cat_id, "refresh");
            }
        } else {
            $message = "<div class='alert alert-danger alert-dismissible'>
                    <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                    <strong>Error!</strong> Please select valid category first.
                  </div>";
            $this->session->set_flashdata("message", $message);
            redirect("admin/categories", "refresh");
        }
    }

    public function specifications($cat_id = 0) {
        if ($cat_id) {
            $data["pageTitle"] = "Category Specific Specifications";
            $data["cat_id"] = $cat_id;
            $data['specifications'] = $this->Categories_model->getCategorySpecifications($cat_id);
            $this->load->view("admin/categories/specifications", $data);
        } else {
            $message = "<div class='alert alert-danger alert-dismissible'>
                    <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                    <strong>Error!</strong> Please select valid category first.
                  </div>";
            $this->session->set_flashdata("message", $message);
            redirect("admin/categories", "refresh");
        }
    }

    public function createSpecifications($cat_id = 0) {
        if ($cat_id) {
            $this->form_validation->set_rules("name", "Name", "required");
            $this->form_validation->set_rules("type", "type", "required");
            $this->form_validation->set_rules("is_compulsary", "Compulsory", "required");
            if ($this->form_validation->run() === false) {
                $data["cat_id"] = $cat_id;
                $this->load->view("admin/categories/createSpecifications", $data);
            } else {
                $choices = json_encode(explode(",", $this->input->post("choices")));
                $insertData = [
                    "category_id" => $cat_id,
                    "name" => $this->input->post("name"),
                    "choices" => $choices,
                    "type" => $this->input->post("type"),
                    "is_required" => $this->input->post("is_compulsary")
                ];
                $this->Categories_model->addSpecs($insertData);
                $message = "<div class='alert alert-success alert-dismissible'>
                        <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                        <strong>Succcess!</strong> Specifications added to selected category.
                      </div>";
                $this->session->set_flashdata("message", $message);
                redirect("admin/categories/Specifications/" . $cat_id, "refresh");
            }
        } else {
            $message = "<div class='alert alert-danger alert-dismissible'>
                    <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                    <strong>Error!</strong> Please select valid category first.
                  </div>";
            $this->session->set_flashdata("message", $message);
            redirect("admin/categories", "refresh");
        }
    }

    public function tstnew() {
        $data["categories"] = $this->Categories_model->getRootCategories();
        $this->load->view("admin/categories/list_new", $data);
    }

    public function editSpec($id = 0) {
        if ($id) {
            $data["spec"] = $this->Categories_model->getSpecificationById($id);
            $this->form_validation->set_rules("name", "Name", "required");
            $this->form_validation->set_rules("type", "type", "required");
            $this->form_validation->set_rules("is_compulsary", "Compulsory", "required");
            if ($this->form_validation->run() === false) {
                $data["spec_id"] = $id;

                $this->load->view("admin/categories/editSpecifications", $data);
            } else {
                $choices = json_encode(explode(",", $this->input->post("choices")));
                $insertData = [
                    "name" => $this->input->post("name"),
                    "choices" => $choices,
                    "type" => $this->input->post("type"),
                    "is_required" => $this->input->post("is_compulsary")
                ];
                $this->Categories_model->updateSpecs($id, $insertData);
                $message = "<div class='alert alert-success alert-dismissible'>
                        <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                        <strong>Succcess!</strong> Specifications Updated.
                      </div>";
                $this->session->set_flashdata("message", $message);
                redirect("admin/categories/Specifications/" . $data["spec"]->category_id, "refresh");
            }
        } else {
            $message = "<div class='alert alert-danger alert-dismissible'>
                    <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                    <strong>Error!</strong> Please select valid specification first.
                  </div>";
            $this->session->set_flashdata("message", $message);
            redirect("admin/categories", "refresh");
        }
    }

    public function editAttrs($id = 0) {
        if ($id) {
            $data["spec"] = $this->Categories_model->getAttributeById($id);
            $this->form_validation->set_rules("name", "Name", "required");
            $this->form_validation->set_rules("type", "type", "required");
            $this->form_validation->set_rules("is_compulsary", "Compulsory", "required");
            if ($this->form_validation->run() === false) {
                $data["attr_id"] = $id;

                $this->load->view("admin/categories/editAttributes", $data);
            } else {
                $choices = json_encode(explode(",", $this->input->post("choices")));
                $insertData = [
                    "name" => $this->input->post("name"),
                    "choices" => $choices,
                    "type" => $this->input->post("type"),
                    "is_required" => $this->input->post("is_compulsary")
                ];
                $this->Categories_model->updateAttrs($id, $insertData);
                $message = "<div class='alert alert-success alert-dismissible'>
                        <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                        <strong>Succcess!</strong> Attribute Updated.
                      </div>";
                $this->session->set_flashdata("message", $message);
                redirect("admin/categories/attributes/" . $data["spec"]->category_id, "refresh");
            }
        } else {
            $message = "<div class='alert alert-danger alert-dismissible'>
                    <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                    <strong>Error!</strong> Please select valid attribute first.
                  </div>";
            $this->session->set_flashdata("message", $message);
            redirect("admin/categories", "refresh");
        }
    }

    public function delteAttrs($id, $cat_id) {
        $this->Categories_model->removeAttr($id);
        $message = "<div class='alert alert-success alert-dismissible'>
                <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                <strong>Success!</strong> Removed selected attribute.
              </div>";
        $this->session->set_flashdata("message", $message);
        redirect("admin/categories/attributes/" . $cat_id, "refresh");
    }

    public function deleteSpec($id, $cat_id) {
        $this->Categories_model->removeSpec($id);
        $message = "<div class='alert alert-success alert-dismissible'>
                <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                <strong>Suucess!</strong> Removed selected Specification.
              </div>";
        $this->session->set_flashdata("message", $message);
        redirect("admin/categories/specifications/" . $cat_id, "refresh");
    }

}
