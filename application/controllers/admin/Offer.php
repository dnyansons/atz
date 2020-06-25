<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Offer extends CI_Controller {

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
        $this->load->library('table');
        $this->load->model('Offer_model');
        $this->load->model('Common_model');
        $this->load->model('Categories_model');
        $this->load->model('Product_model');
        $this->load->model('adminusers_model', 'adminusers_model');
        $this->load->library('Userpermission');
        $this->load->library('awsupload');
    }

    public function index() {
        $this->load->view("admin/offer/list");
    }

    public function ajax_list() {
        $columns = array(
            0 => 'offer_id',
            1 => 'title',
            2 => 'offer_on',
            3 => 'offer_type',
            4 => 'category_id',
            5 => 'discount_value',
            6 => 'valid_from',
            7 => 'valid_to',
            8 => 'status'
        );

        $limit = $this->input->post('length');
        $start = $this->input->post('start');
        $order = $columns[$this->input->post('order')[0]['column']];
        //$dir = $this->input->post('order')[0]['dir'];
        $dir = "desc";

        $totalData = $this->Offer_model->alloffer_count();

        $totalFiltered = $totalData;

        if (empty($this->input->post('search')['value'])) {
            $offer = $this->Offer_model->alloffer($limit, $start, $order, $dir);
            //$last_query = $this->db->last_query();
        } else {
            $search = $this->input->post('search')['value'];

            $offer = $this->Offer_model->offer_search($limit, $start, $search, $order, $dir);

            $totalFiltered = $this->Offer_model->offer_search_count($search);
        }

        $data = array();
        if (!empty($offer)) {
            $i = 1;
            foreach ($offer as $br) {
                $nestedData['srno'] = $i;
                $nestedData['offer_id'] = $br->offer_id;
                $nestedData['title'] = $br->title;
                $nestedData['offer_on'] = $br->offer_on;
                $nestedData['offer_type'] = $br->offer_type;
                // $nestedData['category_id'] = $this->Offer_model->getAllCategoriesWithOffer($br->offer_id);
                $nestedData['category_id'] = $br->categories_name;
                $nestedData['discount_value'] = $br->discount_value;
                $nestedData['valid_from'] = $br->valid_from . ' - ' . date('h:i:A', strtotime($br->time_from));
                $nestedData['valid_to'] = $br->valid_to . ' - ' . date('h:i:A', strtotime($br->time_to));
                $nestedData['status'] = $br->status;

                $nestedData['action'] = '<a href="' . base_url() . 'admin/offer/updateoffer/' . $br->offer_id . '" class="tabledit-edit-button btn btn-primary waves-effect waves-light btn-sm" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit"><i class="fa fa-pencil-square-o fa-2x"></i></a>';
                // $nestedData['last_query'] = $last_query;

                $data[] = $nestedData;
                $i++;
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

    /**
     * @auther Yogesh Pardeshi $date
     * @param 
     * @return 
     * @use
     * */
    public function ajaxListDatatable() {
        //datatables values
        $limit = $this->input->post('length');
        $start = $this->input->post('start');
        //direct posted values
        $offer_type = $this->input->post('offerType');
        $discount_value = $this->input->post('offerDiscount');
        $category_id = $this->input->post('categoryId');

        $offerDetails = array('offerType' => $offer_type,
            'offerDiscount' => $discount_value,
            'categoryId' => $category_id,
            'limit' => $limit,
            'start' => $start);


        $offerDataPreview = $this->getPreivewPrices($offerDetails);
        $recordsTotal = $this->totalCountsOfferPreview($category_id);

        $data = array();
        $htmlTableData = array();
        $index = $start + 1;
        $minusCount = 0;
        $discount_msg = $this->Offer_model->offerDiscount($offer_type, $discount_value);
        foreach ($offerDataPreview as $offers) {
            $data["srno"] = $index++;
            $data["name"] = '<span style="display: inline-block;width: 10em;
                overflow: hidden;white-space: nowrap;text-overflow: ellipsis;">' . $offers['name'] . '</span>';
            $data["product_id"] = '<a target="_blank" href="' . base_url("admin/products/viewSingleProduct/" . $offers['product_id']) .
                    '" class="label label-info">PRD' . $offers['product_id'] . '</a>';
            $data["price"] = $offers['price'];
            $data["default_hike"] = $offers['default_hike'] . '%';
            $data["atz_price"] = $offers['atz_price'];
            $data["default_discount"] = $offers['default_discount'] . '%';
            $data["final_price"] = $offers['final_price'];
            $data["offerDiscount"] = $discount_msg;
            if ($offers['offer_price'] <= 0) {
                $span = '<span class ="text-danger font-weight-bold">';
                $minusCount++;
            } else {
                $span = '<span class="text-success font-weight-bold" >';
            }
            $data["offer_price"] = $span . '<i class="fa fa-inr"></i> ' . $offers['offer_price'] . '</span>';
            $htmlTableData[] = $data;
        }

//        if($minusCount > 0){
//            $warnMsg = "There are $minusCount products in negetive Offer price!";
//        } else {
//            $warnMsg = "";
//        }

        $json_data = array(
            "draw" => intval($this->input->post('draw')),
            "recordsTotal" => $recordsTotal,
            "recordsFiltered" => intval($recordsTotal),
            "data" => $htmlTableData
        );

        echo json_encode($json_data);
    }

    public function addoffer() {

        $data["pageTitle"] = "Create new Offer";
        // $data['totcategories'] = $this->Categories_model->getAll();
        $data['categories_list'] = $this->Categories_model->get_categories();

        $admin_id = $this->session->userdata("admin_id");
        $this->form_validation->set_rules("title", "Title", "required");

        $this->form_validation->set_rules("offer_type", "Offer Type", "required");
        $this->form_validation->set_rules("discount_value", "Value", "required|callback_checkPercentage");
        $this->form_validation->set_rules("category_id", "Category", "required");
        //$this->form_validation->set_rules("products[]","Products","required");
        $this->form_validation->set_rules("valid_from", "Starting date", "required");
        $this->form_validation->set_rules("time_from", "Time From", "required");
        $this->form_validation->set_rules("time_to", "Time To", "required");
        //$this->form_validation->set_rules("valid_to", "Ending date", "required");
        if (empty($_FILES['offer_image']['name'])) {
            $this->form_validation->set_rules('offer_image', 'Image', 'required');
        }
        $this->form_validation->set_error_delimiters('<p style="color:red" class="text-left">', '</p>');
        $this->form_validation->set_rules("valid_to", "Offer", "required|callback_checkOfferTimes");


        if ($this->form_validation->run() == false) {
            $this->load->view("admin/offer/create", $data);
        } else {

            //check already in offer
            $date = date('Y-m-d');
            $time = date('H:i:s');
            $this->db->select('*');
            $this->db->from('offer_zone t1');
            $this->db->where("CURDATE() between valid_from AND valid_to");
            //$this->db->where("CURTIME() BETWEEN time_from AND time_to");
            $this->db->where('t1.status=', 'Active');
            //$this->db->where_in('t2.category_id',$this->input->post("category_id"));
            $ch_cat = $this->db->get()->result();
            $tot_aval = 0;

            //check Producr in Category
            $cat_count = $this->db->query("SELECT id FROM `product_details` WHERE category='" . $this->input->post('category_id') . "' AND available_quantity > 0 AND publish_status = 'Approved'")->num_rows();

            foreach ($ch_cat as $sub_cat) {
                //check categoty ID 
                $this->db->select('offer_id');
                $this->db->from('offer_categories');
                $this->db->where('category_id', $this->input->post("category_id"));
                $this->db->where('offer_id', $sub_cat->offer_id);
                $dat = $this->db->get()->num_rows();
                $tot_aval = $tot_aval + $dat;
            }

            if ($tot_aval > 0) {
                $message = "<div class='alert alert-danger alert-dismissible'>
                            <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                            <strong></strong>This Category Already In Offer .
                        </div>";
                $this->session->set_flashdata("message", $message);
            } elseif ($cat_count == 0) {
                $message = "<div class='alert alert-danger alert-dismissible'>
                            <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                            <strong></strong>No Product Found In This Category !
                        </div>";
                $this->session->set_flashdata("message", $message);
            } else {
                $config['upload_path'] = './uploads/offer/';
                $config['allowed_types'] = 'gif|jpg|png|jpeg|JPEG';
                $config['max_size'] = 3072; // 3 MB
                $config['max_width'] = 3072; // 3 MB
                $config['max_height'] = 768;
                //$this->load->library('upload', $config);
                $s3FilePath = $this->awsupload->upload('offer_image', 'uploads/offer', 'image');
                if ($s3FilePath == false) {
                    //$error = $this->upload->display_errors();
                    // $this->session->set_flashdata("image_error", $error);
                    $this->session->set_flashdata('message', "<div class='alert alert-danger alert-dismissible'>
                            <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                            <strong></strong>Unable to upload file</div>");
                    redirect("admin/offer/add_offer", "refresh");
                    exit;
                } else {
//                    $upload_data = $this->upload->data();
                    $insertData = [
                        "title" => $this->input->post("title"),
                        "offer_type" => $this->input->post("offer_type"),
                        "discount_value" => $this->input->post("discount_value"),
                        "offer_image" => $s3FilePath,
                        "time_from" => date('H:i:s', strtotime($this->input->post('time_from'))),
                        "time_to" => date('H:i:s', strtotime($this->input->post('time_to'))),
                        "valid_from" => date("Y-m-d", strtotime($this->input->post("valid_from"))),
                        "valid_to" => date("Y-m-d", strtotime($this->input->post("valid_to"))),
                        "created_by" => $admin_id
                    ];

                    //so as access faster
                    $offer_id = $this->Common_model->insert('offer_zone', $insertData);

                    /* $category_id_multiple = $this->input->post("category_id");
                      $batch_offer_values = array();
                      foreach ($category_id_multiple as $category_id) {
                      $batch_offer_values[] = array('category_id' => $category_id, 'offer_id' => $offer_id);
                      }

                      //batch insert once offer is generated
                      $this->db->insert_batch('offer_categories', $batch_offer_values); */
                    $sdat['category_id'] = $this->input->post("category_id");
                    $sdat['offer_id'] = $offer_id;
                    $this->Common_model->insert('offer_categories', $sdat);
                    $message = "<div class='alert alert-success alert-dismissible'>

                            <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                            <strong>Success!</strong>Offer Successfully Added .
                        </div>";
                    $this->session->set_flashdata("message", $message);
                }
            }
            redirect("admin/offer", "refresh");
        }
    }

    public function updateoffer($offer_id = 0) { // update update Offer
        $this->form_validation->set_rules("title", "Title", "required");

        $this->form_validation->set_rules("offer_type", "Offer Type", "required");
        $this->form_validation->set_rules("discount_value", "Value", "required");
        $this->form_validation->set_rules("category_id", "Category", "required");
        //$this->form_validation->set_rules("products[]","Products","required");
        $this->form_validation->set_rules("valid_from", "Starting date", "required");
        $this->form_validation->set_rules("time_from", "Time From", "required");
        $this->form_validation->set_rules("time_to", "Time To", "required");
        $this->form_validation->set_rules("valid_to", "Ending date", "required");

        if (strtotime($this->input->post('valid_from')) > strtotime($this->input->post('valid_to'))) {
            //$this->form_validation->set_rules("valid_from", "End date must be greater than the start date", "required");
            //$this->form_validation->set_message('message', 'The end date must be greater than the start date.');
            $this->session->set_flashdata('message', "<div class='alert alert-danger alert-dismissible'>
                            <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                            <strong></strong>Offer end date must be greater than Offer start date</div>");
            redirect(base_url("admin/offer/updateoffer/$offer_id"));
            exit;
        }

        $offerEndTimeStamp = strtotime($this->input->post('valid_to') . ' ' . $this->input->post('time_to'));
        $status = $this->input->post('status');
        $now = strtotime('now');
        if ($offerEndTimeStamp < $now && $status == 'Active') {
            $this->session->set_flashdata('message', "<div class='alert alert-danger alert-dismissible'>
                            <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                            <strong></strong>Offer End date must be greater than current time for active offers only!</div>");
            redirect(base_url("admin/offer/updateoffer/$offer_id"));
            exit;
        }


        if ($_SERVER['REQUEST_METHOD'] == "POST" && $this->form_validation->run() === true) {

            $data['title'] = $this->input->post('title');
            $data['offer_type'] = $this->input->post('offer_type');
            $data['discount_value'] = $this->input->post('discount_value');
            $data['time_from'] = date('H:i:s', strtotime($this->input->post('time_from')));

            $data['time_to'] = date('H:i:s', strtotime($this->input->post('time_to')));


            $data['status'] = $this->input->post('status');

            $valid_from = $this->input->post('valid_from');
            $offer_id = $this->input->post('offer_id');
            //$valid_from = str_replace('/', '-', $valid_from);
            $data['valid_from'] = date('Y-m-d', strtotime($valid_from));

            $valid_to = $this->input->post('valid_to');
            //$valid_to = str_replace('/', '-', $valid_to);
            $data['valid_to'] = date('Y-m-d', strtotime($valid_to));

            //check already in offer
            $date = date('Y-m-d');
            $time = date('H:i:s');
            $this->db->select('*');
            $this->db->from('offer_zone t1');
            $this->db->where("CURDATE() between valid_from AND valid_to");
            //$this->db->where("CURTIME() BETWEEN time_from AND time_to");
            $this->db->where('t1.status=', 'Active');
            $this->db->where_not_in('t1.offer_id', $offer_id);
            //$this->db->where_in('t2.category_id',$this->input->post("category_id"));
            $ch_cat = $this->db->get()->result();
            $tot_aval = 0;
            foreach ($ch_cat as $sub_cat) {
                //check categoty ID
                $this->db->select('offer_id');
                $this->db->from('offer_categories');
                $this->db->where('category_id', $this->input->post("category_id"));
                $this->db->where('offer_id', $sub_cat->offer_id);
                $dat = $this->db->get()->num_rows();
                $tot_aval = $tot_aval + $dat;
                // echo $this->db->last_query();
                // exit;
            }


            if ($tot_aval > 0) {
                $message = "<div class='alert alert-danger alert-dismissible'>
                            <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                            <strong></strong>Category Already In Offer .
                        </div>";
                $this->session->set_flashdata("message", $message);
            } else {

                $offer_image = $_FILES['offer_image']['name'];
                if (empty($offer_image)) {
                    $result = $this->Common_model->update("offer_zone", $data, array("offer_id" => $offer_id));
                    $this->Common_model->delete('offer_categories', array('offer_id' => $offer_id));
                    $sdat['category_id'] = $this->input->post("category_id");
                    $sdat['offer_id'] = $offer_id;
                    $this->Common_model->insert('offer_categories', $sdat);


                    /* $category_id_multiple = $this->input->post("category_id");

                      $batch_offer_values = array();
                      foreach ($category_id_multiple as $category_id) {
                      $batch_offer_values[] = array('category_id' => $category_id, 'offer_id' => $offer_id);
                      }
                      //batch insert once offer is generated
                      $this->db->insert_batch('offer_categories', $batch_offer_values); */

                    $msg = "<div class='alert alert-success alert-dismissible'>
                            <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                            <strong></strong>Offer Update Successfully</div>";
                    $this->session->set_flashdata('message', $msg);
                } else {

                    //                    $config['upload_path'] = './uploads/offer/';
                    //                    $config['allowed_types'] = 'gif|jpg|png|jpeg|JPEG';
                    //                    $config['max_size'] = 1024;
                    //                    $config['max_width'] = 1024;
                    //                    $config['max_height'] = 768;
                    //$this->load->library('upload', $config);
                    $s3FilePath = $this->awsupload->upload('offer_image', 'uploads/offer', 'image');
                    if (!$s3FilePath) {
                        $error = $this->upload->display_errors();
                        $this->session->set_flashdata('message', "<div class='alert alert-danger alert-dismissible'>
                            <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                            <strong></strong>" . $error . "</div>");
                        redirect("admin/offer/updateOffer/" . $offer_id, "refresh");
                        //redirect("admin/banners/add_banner","refresh");
                    } else {
                        //$upload_data = $this->upload->data();
                        $data['offer_image'] = $s3FilePath;

                        $result = $this->Common_model->update("offer_zone", $data, array("offer_id" => $offer_id));


                        $this->Common_model->delete('offer_categories', array('offer_id' => $offer_id));
                        $sdat['category_id'] = $this->input->post("category_id");
                        $sdat['offer_id'] = $offer_id;
                        $this->Common_model->insert('offer_categories', $sdat);

                        $msg = "<div class='alert alert-success alert-dismissible'>
                            <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                            <strong></strong>Offer Update Successfully</div>";
                        $this->session->set_flashdata('message', $msg);
                    }
                }
            }
            redirect(base_url() . "admin/offer");
        } else {

            $get_selected_categories = $this->Common_model->getAll('offer_categories', array('offer_id' => $offer_id))->result();
            foreach ($get_selected_categories as $selected_c) {
                $ids[] = $selected_c->category_id;
            }

            $this->db->select('oc.category_id,t2.categories_name');
            $this->db->from("offer_categories oc");
            $this->db->join("categories_description t2", "oc.category_id = t2.categories_id");
            $this->db->where('offer_id', $offer_id);
            $this->db->where_in('oc.category_id', $ids);

            $parent = $this->db->get();

            $data['selected_cat'] = $parent->row();


            $data['title'] = "Edit Offer";
            $data['totcategories'] = $this->Categories_model->get_categories();
            $admin_username = $this->session->userdata('admin_username');
            $data['admin_data'] = $this->adminusers_model->getUserByUsername($admin_username);

            $data['offer_data'] = $this->Common_model->getAll('offer_zone', array('offer_id' => $offer_id))->row_array();

            $this->load->view('admin/offer/edit', $data);
        }
    }

    public function sub_categories($id) {

        $this->db->select('t1.category_id,t1.categories_image,t2.categories_name');
        $this->db->from("categories t1 ");
        $this->db->join("categories_description t2 ", "t1.category_id = t2.categories_id");
        $this->db->where('t1.parent_id', $id);
        $this->db->order_by("t1.sort_order", "ASC");
        $this->db->order_by("t1.product_count", "DESC");

        $child = $this->db->get();
        $categories = $child->result();

        return $categories;
    }

    public function deleteoffer($offer_id) { // delete deletecoupon
        $result = $this->Offer_model->deleteOfferData($offer_id);
        if ($result) {
            $message = "<div class='alert alert-success alert-dismissible'>
                            <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                            <strong></strong> Delete Successfully ! .
                        </div>";

            $this->session->set_flashdata('message', $message);
            redirect(base_url() . "admin/offer");
        }
    }

    public function getAjaxProducts() {
        $output = [
            "status" => false,
            "message" => "invalid inputs",
            "data" => []
        ];
        $this->form_validation->set_rules("category_id", "Category", "required");
        if ($this->form_validation->run() === false) {
            $output["message"] = strip_tags(validation_errors());
        } else {
            $category_id = $this->input->post("category_id");
            $cats = $category_id . "," . trim($this->Categories_model->getAllChilds($category_id), ",");
            $products = $this->Product_model->getProductNamesByMultipleCats(implode(",", $cats));
            $output["status"] = true;
            $output["message"] = "Product List";
            $output["data"] = $products;
        }
        echo json_encode($output);
    }

    /**
     * @auther Yogesh Pardeshi $date
     * @param 
     * @return 
     * @use
     * */
    public function previewOffer() {
        $this->load->view('admin/offer/previewOffer');
    }

    private function getPreivewPrices($arrayOfferDetails) {

        $category_id = $arrayOfferDetails['categoryId'];
        $offer_type = $arrayOfferDetails['offerType'];
        $discount_value = $arrayOfferDetails['offerDiscount'];

        if ($offer_type == 'flat') {
            $offerExpression = ' (atz_price - ' . $discount_value . ')';
        } else {
            $offerExpression = ' (atz_price - (atz_price * 0.01 * ' . $discount_value . '))';
        }
        if ($category_id != 0 && $category_id != null) {
            $limit = $arrayOfferDetails['limit'];
            $start = $arrayOfferDetails['start'];
            if ($limit != 0 || $limit != null) {
                $this->db->limit($limit, $start);
            }
            return $this->db->select('pd.id as product_id, name, price, 
                atz_price, final_price, hike_percentage default_hike,
                discount_percentage default_discount,' .
                                    $offerExpression . ' as offer_price')
                            ->from('product_details pd')
                            ->join('product_price pp', 'pp.product_id = pd.id', 'left')
                            ->join('categories_description cd', 'cd.categories_id = pd.category', 'left')
                            ->join('categories c', 'c.category_id = pd.category', 'left')
                            ->where('pd.category', $category_id)
                            ->where('pd.publish_status', 'Approved')
                            ->order_by('offer_price', 'ASC')
                            ->get()->result_array();
        }
    }

    /**
     * @auther Yogesh Pardeshi $date
     * @param 
     * @return 
     * @use
     * */
    public function totalCountsOfferPreview($categoryId) {
        $query = $this->db->select('pd.id')
                ->from('product_details pd')
                ->join('product_price pp', 'pp.product_id = pd.id', 'left')
                ->join('categories c', 'c.category_id = pd.category', 'left')
                ->where('pd.category', $categoryId)
                ->where('pd.publish_status', 'Approved')
                ->get();
        return $query->num_rows();
    }

    /**
     * @auther Yogesh Pardeshi 27092019
     * @return validates form for date time and returns true or false 
     * @use with message
     * */
    public function checkOfferTimes() {
        date_default_timezone_set('Asia/Calcutta');
        $startTimeStamp = strtotime($this->input->post('valid_from') . ' ' . $this->input->post('time_from'));
        $endTimeStamp = strtotime($this->input->post('valid_to') . ' ' . $this->input->post('time_to'));
        $now = strtotime('now');

        if ($startTimeStamp < $now) {
            $this->form_validation->set_message('checkOfferTimes', 'Offer start date time must not be less than current date and time ');
            return false;
        } else if ($endTimeStamp <= $now) {
            $this->form_validation->set_message('checkOfferTimes', 'Offer end date must not be less than current date and time ');
            return FALSE;
        } else if ($startTimeStamp > $endTimeStamp) {
            $this->form_validation->set_message('checkOfferTimes', 'Offer start date time must be less than end date time');
            return FALSE;
        } else {
            return TRUE;
        }
    }

    /**
     * @auther Yogesh Pardeshi 27092019
     * @return validates form for date time and returns true or false 
     * @use with message
     * */
    public function checkPercentage() {
        $offerType = strtolower($this->input->post('offer_type'));
        $discountValue = $this->input->post('discount_value');

        if ($offerType == 'percentage' && $discountValue > 99) {
            $this->form_validation->set_message('checkPercentage', 'Offer discount value must not be greater than 99!');
            return false;
        } else {
            return TRUE;
        }
    }

    

}
