<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Companyprofile extends CI_Controller {

    public function __construct() {
        parent::__construct();
        if (!$this->session->userdata("user_logged_in") || $this->session->userdata("user_role") != "seller") {
            $error = "<div id='login-error' class='form-error notice notice-error'><span class='icon-notice icon-error'></span><span><strong>Error!</strong> Session timeout, relogin!. </span></div>";
            $this->session->set_flashdata("message", $error);
            redirect("login", "refresh");
        }
        $this->load->model('Company_model');
        $this->load->model('Units_model');
        $this->load->helper('form');
        $this->load->helper('file');
        $this->load->library("form_validation");
        $this->load->library('awsupload');
    }

    public function index() {
        $seller = $this->session->userdata("user_id");
        $this->form_validation->set_rules("company_name", "Company Name", "required");
        $this->form_validation->set_rules("registration_year", "Registrated On", "required");
        if ($this->form_validation->run() === false) {
            $data["pageTitle"] = "Atzcart | Manufacturer directory";
            /*             * ********** Dynamic units list *************** */
            $tmp_units = $this->Units_model->getAll();
            $units = [];
            foreach ($tmp_units as $unit) {
                $units[$unit->units_id] = $unit->units_name;
            }
            $data["units"] = $units;
            /*             * ********** Dynamic years list *************** */
            $tmp_years = range(1920, date("Y"));
            $years = [];
            $years[""] = "Select year";
            foreach ($tmp_years as $key => $val) {
                $years[$val] = $val;
            }
            $data["years"] = $years;
            /*             * ********** Dynamic employees count list *************** */
            $data["no_of_employees"] = [
                "Fewer than 5" => "Fewer than 5",
                "5-10 People" => "5-10 People",
                "11-50 People" => "11-50 People",
                "51-100 People" => "51-100 People",
                "101-200 People" => "101-200 People",
                "201-300 People" => "201-300 People",
                "501-1000 People" => "501-1000 People",
                "Above 1000" => "Above 1000",
            ];
            /*             * ********** Dynamic staff size list *************** */
            $data["staff_size"] = [
                "Less than 5 People" => "Less than 5 People",
                "5 - 10 People" => "5 - 10 People",
                "11 - 20 People" => "11 - 20 People",
                "21 - 30 People" => "21 - 30 People",
                "31 - 40 People" => "31 - 40 People",
                "41 - 50 People" => "41 - 50 People",
                "Above 50 People" => "Above 50 People",
            ];
            /*             * ********** Dynamic Production line list *************** */
            $data["production_lines"] = [
                "" => "--- Select Item ---",
                "1" => "1",
                "2" => "2",
                "3" => "3",
                "4" => "4",
                "5" => "5",
                "6" => "6",
                "7" => "7",
                "8" => "8",
                "9" => "9",
                "10" => "10",
                "Above 10" => "Above 10",
            ];
            /*             * ********** Dynamic units list *************** */
            $data["office_size"] = [
                "below 100 square meters" => "below 100 square meters",
                "101 - 500 square meters" => "101 - 500 square meters",
                "501 - 1000 square meters" => "501 - 1000 square meters",
                "1001 -2000 square meters" => "1001 -2000 square meters",
                "above 2000 square meters" => "above 2000 square meters",
            ];
            /*             * ********** Dynamic output values list *************** */
            $data["annual_output_value"] = [
                "Below INR 1 Million" => "Below INR 1 Million",
                "INR 1 Million - INR 2.5 Million" => "INR 1 Million - INR 2.5 Million",
                "INR 2.5 Million - INR 5 Million" => "INR 2.5 Million - INR 5 Million",
                "INR 5 Million - INR 10 Million" => "INR 5 Million - INR 10 Million",
                "INR 10 Million - INR 50 Million" => "INR 10 Million - INR 50 Million",
                "INR 50 Million - INR 100 Million" => "INR 50 Million - INR 100 Million",
                "Above INR 100 Million" => "Above INR 100 Million",
            ];
            /*             * ********** Dynamic facotory list *************** */
            $data["factory_size"] = [
                "Below 1,000 square meters" => "Below 1,000 square meters",
                "1,000-3,000 square meters" => "1,000-3,000 square meters",
                "3,000-5,000 square meters" => "3,000-5,000 square meters",
                "5,000-10,000 square meters" => "5,000-10,000 square meters",
                "10,000-30,000 square meters" => "10,000-30,000 square meters",
                "30,000-50,000 square meters" => "30,000-50,000 square meters",
                "50,000-100,000 square meters" => "50,000-100,000 square meters",
                "Above 100,000 square meters" => "Above 100,000 square meters",
            ];
            /************ Supplier/Seller company details *************** */
            $data["company"] = $this->Company_model->getCompanyDetailsBySeller($seller);
            $data["country"] = $this->Company_model->getCountries();
            $this->load->view("user/company/edit", $data);
        } else {
            $updateData = [
                "company_name" => htmlentities($this->input->post("company_name")),
                "registration_state" => htmlentities($this->input->post("registered_state")),
                "location_country" => htmlentities($this->input->post("registered_country")),
                "comp_operational_addr" => htmlentities($this->input->post("comp_operational_addr")),
                "comp_operational_city" => htmlentities($this->input->post("comp_operational_city")),
                "comp_operational_state" => htmlentities($this->input->post("comp_operational_state")),
                "comp_operational_region" => htmlentities($this->input->post("comp_operational_region")),
                "comp_operational_zip_code" => htmlentities($this->input->post("comp_operational_zip_code")),
                "main_products" => json_encode($this->input->post("products")),
                "other_products" => json_encode($this->input->post("oproducts")),
                "year_of_register" => htmlentities($this->input->post("registration_year")),
                "no_of_employee" => htmlentities($this->input->post("employee_count")),
                "company_url" => htmlentities($this->input->post("website_url")),
                "legal_owner" => htmlentities($this->input->post("legal_owner")),
                "office_size" => htmlentities($this->input->post("office_size")),
                "comp_advantages" => htmlentities($this->input->post("company_advantage")),
            ];
            $id = $this->input->post("com");
            $this->Company_model->updateCompany($id, $updateData);
            $msg = "<div class='alert alert-success alert-dismissible'>
                    <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                    <strong>Success!</strong> Comapny Basic Details Updated Successfully.
                  </div>";
            $this->session->set_flashdata("message", $msg);
            redirect("seller/companyprofile", "refresh");
        }
    }

    public function quality_control() {
        $seller = $this->session->userdata("user_id");
        
        $this->form_validation->set_rules("com","Company","required");
        $this->form_validation->set_rules("is_qc_process","Display Process","required");
        $this->form_validation->set_rules("is_te_process","Display Equipments","required");
        $this->form_validation->set_rules('process_image', '', 'callback_file_check');
        if($this->form_validation->run()===false){
 
            $msg = "<div class='alert alert-danger alert-dismissible'>
                    <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                    <strong>Error!</strong> " . validation_errors() . ".
                  </div>";
            $this->session->set_flashdata("message", $msg);
            redirect("seller/companyprofile", "refresh");
        } else {
            $companyDetails = $this->Company_model->getCompanyDetailsBySeller($seller);

            $img_path1=$this->awsupload->multiUpload($_FILES,'uploads/images/companies/process', 'image');

            $this->load->library('upload');
            $dataInfo = array();
            $files = $_FILES;
            $cpt = count($_FILES['process_image']['name']);
            $process = [];
            $equipments = [];
            $prevProcessDetails = json_decode($companyDetails->quality_control_details);

            $process_name_raw = $this->input->post("process_name");
            $process_description_raw = $this->input->post("process_description");
            for ($i = 0; $i < count($process_name_raw); $i++) {
                $process[] = [
                    "name" => $process_name_raw[$i],
                    "image" => $img_path1[$i],
                    "description" => $process_description_raw[$i] 

                ];
            }

            $process_eq_name = htmlentities($this->input->post("equipment_name"));
            $process_eq_model = htmlentities($this->input->post("equipment_model"));
            $process_eq_quantity = htmlentities($this->input->post("equipment_quantity"));
            for ($i = 0; $i < count($process_eq_name); $i++) {
                $equipments[] = [
                    "name" => $process_eq_name[$i],
                    "model" => $process_eq_model[$i],
                    "quantity" => $process_eq_quantity[$i]
                ];
            }

            $company = $this->input->post("com");
            $updateData = [
                "display_quality_control_process" => htmlentities($this->input->post("is_qc_process")),
                "quality_control_details" => json_encode($process),
                "display_testing_equipments" => htmlentities($this->input->post("is_te_process")),
                "testing_equipment_details" => json_encode($equipments),
            ];

            $this->Company_model->updateCompanyQualityProcess($company, $updateData);

            $msg = "<div class='alert alert-success alert-dismissible'>
                    <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                    <strong>Success!</strong> Comapny Quality control details updated.
                  </div>";
            $this->session->set_flashdata("message", $msg);
            redirect("seller/companyprofile", "refresh");
        }
    }

    public function rndcapability() {
        $seller = $this->session->userdata("user_id");

        $this->form_validation->set_rules("com", "Company", "required");
        $this->form_validation->set_rules("is_rnd_process", "R & D Process", "required");
        $this->form_validation->set_rules('process_image', '', 'callback_file_check');

        if ($this->form_validation->run() === false) {
            $msg = "<div class='alert alert-danger alert-dismissible'>
                    <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                    <strong>Error!</strong> " . validation_errors() . ".
                  </div>";
            $this->session->set_flashdata("message", $msg);
            redirect("seller/companyprofile", "refresh");
        } else {

            $companyDetails = $this->Company_model->getCompanyDetailsBySeller($seller);

            $this->load->library('upload');
            $dataInfo = array();
            $files = $_FILES;
            $cpt = count($_FILES['process_image']['name']);
            $process = [];
            $equipments = [];
            $prevRndDetails = json_decode($companyDetails->rnd_details);

        $img_path=$this->awsupload->multiUpload($_FILES,'uploads/images/companies/rnd_process', 'image');

            $process_name_raw = $this->input->post("process_name");
            $process_description_raw = $this->input->post("process_description");
            for ($i = 0; $i < count($process_name_raw); $i++) {
                $process[] = [
                    "name" => $process_name_raw[$i],
                    "image" => $img_path[$i],
                    "description" => $process_description_raw[$i]
                ];
            }
            $company = $this->input->post("com");

            $updateData = [
                "display_rnd_control_process" => $this->input->post("is_rnd_process"),
                "rnd_details" => json_encode($process),
            ];

            $this->Company_model->updateCompanyRndProcess($company, $updateData);

            $msg = "<div class='alert alert-success alert-dismissible'>
                    <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                    <strong>Success!</strong> Comapny RND Process updated.
                  </div>";
            $this->session->set_flashdata("message", $msg);
            redirect("seller/companyprofile", "refresh");
        }
    }

    public function manufacturing() {
        $seller = $this->session->userdata("user_id");

        $this->form_validation->set_rules("com", "Company", "required");
        $this->form_validation->set_rules("display_prod_equipment", "Display Equipments", "required");
        $this->form_validation->set_rules("display_prod_line", "Display Line", "required");
        $this->form_validation->set_rules("factory_location", "Factory Location", "required");
        $this->form_validation->set_rules("factory_size", "Factory Size", "required");
        // $this->form_validation->set_rules("oem_experience","OEM Experience","required");

        $this->form_validation->set_rules("oc_staff_count","QA Staff","required");
        $this->form_validation->set_rules("rd_staff_count","RND Staff","required");
        $this->form_validation->set_rules("production_line_count","Line count","required");
        $this->form_validation->set_rules("annual_output_value","Annual output value","required");
        $this->form_validation->set_rules('process_image', '', 'callback_file_check');

        if($this->form_validation->run()===false){

            $msg = "<div class='alert alert-danger alert-dismissible'>
                    <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                    <strong>Error!</strong> " . validation_errors() . "
                  </div>";
            $this->session->set_flashdata("message", $msg);
            redirect("seller/companyprofile", "refresh");
        } else {
            $companyDetails = $this->Company_model->getCompanyDetailsBySeller($seller);
            // echo "<pre>";
            // print_r($companyDetails);
            // exit();
            $this->load->library('upload');
            $dataInfo = array();
            $files = $_FILES;
            $cpt = count($_FILES['process_image']['name']);
            $process = [];
            $equipments = [];
            $line = [];
            $capacity = [];
            $prevProcessDetails = json_decode($companyDetails->production_process_details);
			
             $img_path_save=$this->awsupload->multiUpload($_FILES,'uploads/images/companies/manu_capacity', 'image');

             if ($_FILES['userfile']['name'] != '' || !empty($_FILES['userfile']['name'])) {
                    $s3FilePath = $this->awsupload->multiUpload($_FILES, 'uploads/images/companies/manu_capacity','all_document');

                    if($s3FilePath == false){
                    
                    $msg = "<div class='alert alert-danger alert-dismissible'>
                        <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                        <strong>Error!</strong> File Type Not Allowed.!
                      </div>";
                        $this->session->set_flashdata("message", $msg);
                        redirect("seller/companyprofile", "refresh");

                    } else {
                        $dataInfo[]  = $s3FilePath;
                    }
                } 
            
            $process_raw_names = htmlentities($this->input->post("process_name"));
            $process_raw_descs = htmlentities($this->input->post("process_description"));
            for ($i = 0; $i < count($process_raw_names); $i++) {
                $process[] = [
                    "name" => $process_raw_names[$i],
                    "image" => $img_path_save[$I],
                    "description" => $process_raw_descs[$i] 
                ];
            }

            $process_eq_name = htmlentities($this->input->post("equipment_name"));
            $process_eq_model = htmlentities($this->input->post("equipment_model"));
            $process_eq_quantity = htmlentities($this->input->post("equipment_quantity"));
            for ($i = 0; $i < count($process_eq_name); $i++) {
                $equipments[] = [
                    "name" => $process_eq_name[$i],
                    "model" => $process_eq_model[$i],
                    "quantity" => $process_eq_quantity[$i]
                ];
            }

            $line_name = htmlentities($this->input->post("line_name"));
            $supervisor_no = htmlentities($this->input->post("supervisor_no"));
            $operators_count = htmlentities($this->input->post("operators_count"));
            $qc_qa_number = htmlentities($this->input->post("qc_qa_number"));
            for ($i = 0; $i < count($line_name); $i++) {
                $line[] = [
                    "name" => $line_name[$i],
                    "supervisor_no" => $supervisor_no[$i],
                    "operators_count" => $operators_count[$i],
                    "qc_qa_number" => $qc_qa_number[$i]
                ];
            }

            $product_name = htmlentities($this->input->post("product_name"));
            $unit_per_year_quantity = htmlentities($this->input->post("unit_per_year_quantity"));
            $unit_per_year_factor = htmlentities($this->input->post("unit_per_year_factor"));
            $highest_output = htmlentities($this->input->post("highest_output"));
            $unit_factor = htmlentities($this->input->post("unit_factor"));
            for ($i = 0; $i < count($line_name); $i++) {
                $capacity[] = [
                    "product_name" => $product_name[$i],
                    "unit_per_year_quantity" => $unit_per_year_quantity[$i],
                    "unit_per_year_factor" => $unit_per_year_factor[$i],
                    "highest_output" => $highest_output[$i],
                    "unit_factor" => $unit_factor[$i]
                ];
            }

            $updateData = [
                "display_production_process" => htmlentities($this->input->post("is_display_process")),
                "production_process_details" => json_encode($process),
                "display_production_equipments" => htmlentities($this->input->post("display_prod_equipment")),
                "production_equipment_details" => json_encode($equipments),
                "display_production_line" => htmlentities($this->input->post("display_prod_line")),
                "production_line_details" => json_encode($line),
                "display_annual_production_capacity" => htmlentities($this->input->post("display_prod_capacity")),
                "annual_production_capacity_details" => json_encode($capacity),
                "factory_location" => htmlentities($this->input->post("factory_location")),
                "factory_size" => htmlentities($this->input->post("factory_size")),
                "contract_manufacturing_info" => json_encode($this->input->post("contract_services")),
                "oc_staff_count" => htmlentities($this->input->post("oc_staff_count")),
                "rd_staff_count" => htmlentities($this->input->post("rd_staff_count")),
                "production_line_count" => htmlentities($this->input->post("production_line_count")),
                "annual_production_capacity" => htmlentities($this->input->post("annual_output_value")),
            ];

            $com = htmlentities($this->input->post("com"));
            $this->Company_model->updateCompanyManufactureDetails($com, $updateData);

            $msg = "<div class='alert alert-success alert-dismissible'>
                    <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                    <strong>Success!</strong> Comapny Manufacture Process updated.
                  </div>";
            $this->session->set_flashdata("message", $msg);
            redirect("seller/companyprofile", "refresh");
        }
    }

    public function introduction() {
        $seller = $this->session->userdata("user_id");

        
        $this->form_validation->set_rules("com","Company","required");
        $this->form_validation->set_rules("introduction","Introduction","required");
       // $this->form_validation->set_rules('logo', '', 'callback_file_check');

        if($this->form_validation->run()===false){

            $msg = "<div class='alert alert-danger alert-dismissible'>
                    <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                    <strong>Error!</strong> " . validation_errors() . "
                  </div>";
            $this->session->set_flashdata("message", $msg);
            redirect("seller/companyprofile", "refresh");
        } else {

            $tmpmsg = "";
            $s3img_path="";

            // if ($this->file_check($_FILES['logo']['name'])) {

            $s3img_path=$this->awsupload->upload("logo",'uploads/images/companies/intro','image');
            if($s3img_path==false)
            {
            
             $msg = "<div class='alert alert-danger alert-dismissible'>
                    <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                    <strong>Error!</strong> File Type Not Allowed.Try again.!
                  </div>";
                $this->session->set_flashdata("message", $msg);
                redirect("seller/companyprofile", "refresh");
            }
            else
            {
            
                $com = htmlentities($this->input->post("com"));
                $updateData["introduction"] = $this->input->post("introduction");
                if (!empty($s3img_path)) {
                    // $updateData["logo"] = base_url().$imagesavepath.$data["file_name"];
                     $updateData["logo"] = $s3img_path;
                }
                else
                {
                     $updateData["logo"] = '';
                } 
                $this->Company_model->updateCompany($com,$updateData);

                
            $msg = "<div class='alert alert-success alert-dismissible'>
                <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                <strong>Success!</strong> Company introduction updated.
              </div>";
            $this->session->set_flashdata("message", $msg);
//            redirect("seller/companyprofile", "refresh");

            }
            // }
        }
    }

    public function export() {

        $seller = $this->session->userdata("user_id");
        $this->form_validation->set_rules("com", "Company", "required");
        $this->form_validation->set_rules("introduction", "Introduction", "required");
        if ($this->form_validation->run() === false) {
            $msg = "<div class='alert alert-danger alert-dismissible'>
                    <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                    <strong>Error!</strong> " . validation_errors() . "
                  </div>";
            $this->session->set_flashdata("message", $msg);
            redirect("seller/companyprofile", "refresh");
        } else {
            echo "<pre>";
            print_r($_POST);
        }
    }

    public function export_capacity() {

        $seller = $this->session->userdata("user_id");
        $this->form_validation->set_rules("main_markets_distribution", "Main Markets Distribution", "required");
        // $this->form_validation->set_rules("Whether_customer_case","Whether Add Customer Case","required");
        if ($this->form_validation->run() === false) {
            $msg = "<div class='alert alert-danger alert-dismissible'>
                    <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                    <strong>Error!</strong> " . validation_errors() . "
                  </div>";
            $this->session->set_flashdata("message", $msg);
            redirect("seller/companyprofile", "refresh");
        } else {

            $annual_revenue = htmlentities($this->input->post("annual_revenue"));
            $export_percentage = htmlentities($this->input->post("export_percentage"));
            $main_markets_distribution = htmlentities($this->input->post("main_markets_distribution"));
            $export_started_year = htmlentities($this->input->post("export_started_year"));
            $Whether_customer_case = htmlentities($this->input->post("is_customer_case"));
            $trade_dep_emp_count = htmlentities($this->input->post("trade_dep_emp_count"));
            $nearest_ports = json_encode($this->input->post("nearest_ports"));
            $average_lead_days = htmlentities($this->input->post("average_lead_days"));
            $is_overseas = htmlentities($this->input->post("is_overseas"));
            $accepted_delivery_terms = json_encode($this->input->post("terms"));
            $accepted_payment_currency = json_encode($this->input->post("payment_currency"));
            $accepted_payment_types = json_encode($this->input->post("payment_type"));
            $languages_spoken = json_encode($this->input->post("languages"));

            $project_customer = $this->input->post("project_customer");


            for ($i = 0; $i < count($project_customer); $i++) {
                $arr[$i]['project_customer'] = htmlentities($this->input->post("project_customer")[$i]);
                $arr[$i]['customer_country'] = htmlentities($this->input->post("customer_country")[$i]);
                $arr[$i]['supply_product_name'] = htmlentities($this->input->post("supply_product_name")[$i]);
                $arr[$i]['anual_turn_over'] = htmlentities($this->input->post("anual_turn_over")[$i]);

                $files = $_FILES;
                if ($_FILES['cooperation_photo']['name'][$i] != '') {

                    $_FILES['uploadfile']['name'] = $files['cooperation_photo']['name'][$i];
                    $_FILES['uploadfile']['type'] = $files['cooperation_photo']['type'][$i];
                    $_FILES['uploadfile']['tmp_name'] = $files['cooperation_photo']['tmp_name'][$i];
                    $_FILES['uploadfile']['error'] = $files['cooperation_photo']['error'][$i];
                    $_FILES['uploadfile']['size'] = $files['cooperation_photo']['size'][$i];
                    $path = 'company_export/';
                    $this->load->library('upload');
                    $this->upload->initialize($this->set_upload_options($path, $name)); //function defination below
                    $this->upload->do_upload('uploadfile');
                    $upload_data1 = $this->upload->data();
                    $fileName1 = $upload_data1['file_name'];
                    $images1[] = $fileName1;
                    $fileName1 = $images1;
                    $arr[$i]['cooperation_photo'] = $fileName1;
                } else {
                    $arr[$i]['cooperation_photo'] = htmlentities($this->input->post("cooperation_photo_old")[$i]);
                }


                if ($_FILES['transction_doc']['name'][$i] != '') {

                    $_FILES['userfile']['name'] = $files['transction_doc']['name'][$i];
                    $_FILES['userfile']['type'] = $files['transction_doc']['type'][$i];
                    $_FILES['userfile']['tmp_name'] = $files['transction_doc']['tmp_name'][$i];
                    $_FILES['userfile']['error'] = $files['transction_doc']['error'][$i];
                    $_FILES['userfile']['size'] = $files['transction_doc']['size'][$i];
                    $path = 'company_export/';
                    $this->load->library('upload');
                    $this->upload->initialize($this->set_upload_options($path, $name)); //function defination below
                    $this->upload->do_upload('userfile');
                    $upload_data2 = $this->upload->data();
                    $fileName2 = $upload_data2['file_name'];
                    $images2[] = $fileName2;
                    $fileName2 = $images2;
                    $arr[$i]['transction_doc'] = $fileName2;
                } else {
                    $arr[$i]['transction_doc'] = htmlentities($this->input->post("transction_doc_old")[$i]);
                }
            }

            $country = $this->input->post("overseas_country_region");
            for ($i = 0; $i < count($country); $i++) {
                $arr1[$i]['overseas_country_region'] = htmlentities($this->input->post("overseas_country_region")[$i]);
                $arr1[$i]['p_s_county'] = htmlentities($this->input->post("p_s_county")[$i]);
                $arr1[$i]['City'] = htmlentities($this->input->post("City")[$i]);
                $arr1[$i]['street_address'] = htmlentities($this->input->post("street_address")[$i]);
                $arr1[$i]['country_code'] = htmlentities($this->input->post("country_code")[$i]);
                $arr1[$i]['area_code'] = htmlentities($this->input->post("area_code")[$i]);
                $arr1[$i]['phone_number'] = htmlentities($this->input->post("phone_number")[$i]);
                $arr1[$i]['duties'] = htmlentities($this->input->post("duties")[$i]);
                $arr1[$i]['person_in_charge'] = htmlentities($this->input->post("person_in_charge")[$i]);
                $arr1[$i]['number_of_staff'] = htmlentities($this->input->post("number_of_staff")[$i]);


                $files = $_FILES;
                if ($_FILES['ownership_certification']['name'][$i] != '') {

                    $_FILES['photo']['name'] = $files['ownership_certification']['name'][$i];
                    $_FILES['photo']['type'] = $files['ownership_certification']['type'][$i];
                    $_FILES['photo']['tmp_name'] = $files['ownership_certification']['tmp_name'][$i];
                    $_FILES['photo']['error'] = $files['ownership_certification']['error'][$i];
                    $_FILES['photo']['size'] = $files['ownership_certification']['size'][$i];
                    $path = 'company_export/';
                    $this->load->library('upload');
                    $this->upload->initialize($this->set_upload_options($path, $name)); //function defination below
                    $this->upload->do_upload('photo');
                    $upload_data3 = $this->upload->data();
                    $fileName3 = $upload_data3['file_name'];
                    $images3[] = $fileName3;
                    $fileName3 = $images3;
                    $arr1[$i]['ownership_certification'] = $fileName3;
                } else {
                    $arr[$i]['ownership_certification'] = htmlentities($this->input->post("ownership_certification_old")[$i]);
                }


                if ($_FILES['office_photos']['name'][$i] != '') {

                    $_FILES['o_photo']['name'] = $files['office_photos']['name'][$i];
                    $_FILES['o_photo']['type'] = $files['office_photos']['type'][$i];
                    $_FILES['o_photo']['tmp_name'] = $files['office_photos']['tmp_name'][$i];
                    $_FILES['o_photo']['error'] = $files['office_photos']['error'][$i];
                    $_FILES['o_photo']['size'] = $files['office_photos']['size'][$i];
                    $path = 'company_export/';
                    $this->load->library('upload');
                    $this->upload->initialize($this->set_upload_options($path, $name)); //function defination below
                    $this->upload->do_upload('o_photo');
                    $upload_data4 = $this->upload->data();
                    $fileName4 = $upload_data4['file_name'];
                    $images4[] = $fileName4;
                    $fileName4 = $images4;
                    $arr1[$i]['office_photos'] = $fileName4;
                } else {
                    $arr[$i]['office_photos'] = htmlentities($this->input->post("office_photos_old")[$i]);
                }
            }

            $updateData = [
                "annual_revenue" => $annual_revenue,
                "export_percentage" => $export_percentage,
                "main_markets_distribution" => $main_markets_distribution,
                "export_started_year" => $export_started_year,
                "Whether_customer_case" => $Whether_customer_case,
                "overseas_offices" => $is_overseas,
                "Whether_customer_case_details" => json_encode($arr),
                "overseas_offices_details" => json_encode($arr1),
                "trade_dep_emp_count" => $trade_dep_emp_count,
                "nearest_ports" => $nearest_ports,
                "average_lead_days" => $average_lead_days,
                "accepted_delivery_terms" => $accepted_delivery_terms,
                "accepted_payment_currency" => $accepted_payment_currency,
                "accepted_payment_types" => $accepted_payment_types,
                "languages_spoken" => $languages_spoken
            ];

            $id = $this->input->post("com");

            $this->Company_model->update_company_export_capability_details($id, $updateData);
            $msg = "<div class='alert alert-success alert-dismissible'>
                    <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                    <strong>Success!</strong> Comapny Export Capability Details Updated Successfully.
                  </div>";
            $this->session->set_flashdata("message", $msg);
            redirect("seller/companyprofile", "refresh");
        }
    }

    private function set_upload_options($path, $name) {
        //upload an image options
        $config = array();
        $config['upload_path'] = 'uploads/images/companies/' . $path;
        $config['allowed_types'] = 'gif|jpg|png|jpeg';
        $config['max_size'] = '0';
        //$config['file_name']     = $name;
        $config['overwrite'] = FALSE;

        return $config;
    }

    public function company_documents() {
        $user_id = $this->session->userdata("user_id");

        $data['seller_docs'] = $this->Common_model->getSellerDetails($user_id);

        $this->load->view('user/company/company_documents', $data);
    }

    public function ajax_list() {
        $user_id = $this->session->userdata("user_id");

        $columns = array(
            0 => 'id',
            1 => 'title'
        );

        $limit = $this->input->post('length');
        $start = $this->input->post('start');
        $order = $columns[$this->input->post('order')[1]['column']];
        $dir = $this->input->post('order')[1]['dir'];

        $totalData = $this->Common_model->select('count(id)', 'company_documents', ['user_id' => $user_id])[0]['count_id'];

        $totalFiltered = $totalData;

        if (empty($this->input->post('search')['value'])) {

            $list = $this->Common_model->select('*', 'company_documents', ['user_id' => $user_id], array(1 => array('colname' => $order, 'type' => 'DESC')), $limit, $start);
        } else {
            $search = $this->input->post('search')['value'];
            $list = $this->document_search($limit, $start, $search, $order, $dir);
            $totalFiltered = $this->document_search_count($search);
        }

        $data = array();
        if (!empty($list)) {
            foreach ($list as $br) {
                $nestedData['id'] = $br['id'];
                $nestedData['title'] = $br['title'];
                $nestedData['date_created'] = $br['date_created'];

                $nestedData['action'] = '<a type="button" href="' . base_url() . 'seller/companyprofile/view_documents/' . $br['id'] . '" class="btn btn-warning btn-sm">View</a>
				         <a onclick="return confirm(&apos;Are You Sure ?&apos;)" type="button" href="' . base_url() . 'seller/companyprofile/delete_company_documents/' . $br['id'] . '" class="btn btn-danger btn-sm">Delete</a>';

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

    public function document_search_count($search) {
        $query = $this
                ->db
                ->like('title', $search)
                ->or_like('date_created', $search)
                ->get("company_documents");

        return $query->num_rows();
    }

    function document_search($limit, $start, $search, $col, $dir) {
        $query = $this
                ->db
                ->select('*')
                ->like('title', $search)
                ->or_like('date_created', $search)
                ->limit($limit, $start)
                ->order_by($col, $dir)
                ->get("company_documents");

        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return null;
        }
    }
    

    public function upload_documents() {
        $this->load->helper('file');

        if (isset($_POST['submit']) && $_POST['submit'] != '') {

            $this->form_validation->set_rules('certificate_title', 'Title', 'required');
//            $this->form_validation->set_rules('files', '', 'callback_file_check');

            if ($this->form_validation->run() == false) {
                $validation_erros = validation_errors();
                $this->session->set_flashdata('message', $validation_erros);
            } else {

                $title = htmlentities($this->input->post('certificate_title'));
                $user_id = $this->session->userdata('user_id');

                // $data['seller_docs']=$this->Common_model->CheckSellerDetailsStatus($user_id);

                $insert_arr = array();
                $insert_arr['title'] = $title;
                $insert_arr['user_id'] = $user_id;
                $insert_arr['file_status'] = '';
                $insert_id = $this->Common_model->insert('company_documents', $insert_arr);
              
                if (!empty($_FILES['files']['name'])) {

                    // for($i=0; $i<$cpt; $i++)
                    // {           

                    $FileNames=explode(".",$files['files']['name']);
                        
                $img_path=$this->awsupload->upload("files",'uploads/company_docs','company_docs');

                    if($img_path==false)
                    {
                        $msg = '<div class="alert alert-danger alert-dismissible">
                                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                    <strong>Error!</strong> File Type Not Allowed.Please Select Only jpeg/ jpg/ png/ pdf File.!
                                </div>';

                        $this->session->set_flashdata('message', $msg);
                        redirect('seller/companyprofile/upload_documents');

                    }
                    else
                    {

                        $uniquesavename=time().uniqid(rand());
                        $newName1=$uniquesavename.'.'.$FileNames[1];
                        
                        
                            $file_insert_arr['company_document_title_id'] = $insert_id;
                            $file_insert_arr['file'] = $img_path;
                            
                            $this->Common_model->insert('company_document_files',$file_insert_arr);

                        $msg = "<div class='alert alert-success alert-dismissible'>

                               <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                               <strong>Success!</strong> Company Documents Uploaded Successfully.
                            </div>";

                        $this->session->set_flashdata('message', $msg);
                        redirect('seller/companyprofile/upload_documents');

                    }
                    // }

               }
               else
               {
                       $msg= '<div class="alert alert-danger alert-dismissible">
                                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                    <strong>Error!</strong> Something went wrong.!'.$this->upload->display_errors().
                                '</div>';

                            $this->session->set_flashdata('message',$msg);
                            redirect('seller/companyprofile/upload_documents');
               }
           }
           
       }
       $this->load->view('user/company/upload_documents'); 

    }

    /*
      @author Ishwar
     * This function check file extension during file file uploading
     */


    public function file_check($str){
        $allowed_mime_type_arr = array('application/pdf','image/jpeg','image/jpg','image/png');
        $mime = get_mime_by_extension($str);
       
        if(isset($str) && $str!=""){
            if(in_array($mime, $allowed_mime_type_arr)){
                return true;
            } else {

                $msg = '<div class="alert alert-danger alert-dismissible">
                                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                    <strong>Error!</strong> Please select only pdf/jpg/png file.!
                                </div>';

            $this->session->set_flashdata('message',$msg);
            redirect('seller/companyprofile');
            // $this->form_validation->set_message('file_check', 'Please select only pdf/jpg/png file.');

                $this->session->set_flashdata('message', $msg);
                redirect('seller/companyprofile/upload_documents');
                // $this->form_validation->set_message('file_check', 'Please select only pdf/jpg/png file.');

                return false;
            }
        } else {
            $msg = '<div class="alert alert-danger alert-dismissible">
                                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                    <strong>Error!</strong> Please choose a file to upload.!
                                </div>';

             $this->session->set_flashdata('message',$msg);   
              redirect('seller/companyprofile');                 
             // $this->form_validation->set_message('file_check', 'Please choose a file to upload.');

            $this->session->set_flashdata('message', $msg);
            redirect('seller/companyprofile/upload_documents');
            // $this->form_validation->set_message('file_check', 'Please choose a file to upload.');

            return false;
        }
    }

    public function view_documents($id) {
        $data = array();
        $record = $this->Common_model->select('cd.*,cdf.file', 'company_documents cd', ['cd.id' => $id], '', '', '',
                array(1 => array('tableName' => 'company_document_files cdf', 'columnNames' => 'cd.id = cdf.company_document_title_id', 'jType' => 'right')));

        if (!empty($record)) {
            $data['record'] = $record[0];
            $files_arr = array();
            foreach ($record as $file) {
                array_push($files_arr, $file['file']);
            }

            $data['files'] = $files_arr;

            $this->load->view('user/company/view_documents', $data);
        } else {
            echo 'Record Not Found';
        }
    }

    private function set_upload_options_company_docs() {
        //upload an image options
        $config = array();
        $config['upload_path'] = './uploads/company_docs/';
        $config['allowed_types'] = 'jpg|jpeg|png|pdf';
        $config['max_size'] = '0';
        $config['overwrite'] = FALSE;

        return $config;
    }

    public function delete_company_documents($id) {
        $this->Common_model->delete('company_documents', ['id' => $id]);
        $msg = "<div class='alert alert-success alert-dismissible'>
                    <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                    <strong>Success!</strong> Company Certificate/license Deleted Successfully.
                  </div>";
        $this->session->set_flashdata("message", $msg);
        redirect("seller/companyprofile/company_documents", "refresh");
    }

}
