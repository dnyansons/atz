<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Profile extends CI_Controller 
{
    public function __construct() 
    {
        parent::__construct();
        if (!$this->session->userdata("user_logged_in") || $this->session->userdata("user_role")!="seller") {
            $error = "<div id='login-error' class='form-error notice notice-error'><span class='icon-notice icon-error'></span><span><strong>Error!</strong> Session timeout, relogin!. </span></div>";
            $this->session->set_flashdata("message", $error);
            redirect("login", "refresh");
        }
        $this->load->model('Common_model');
        $this->load->model('Profile_model');
        $this->load->helper('url');
        $this->load->helper('file');
        $this->load->library('session');
        $this->load->library('imageupload');
        $this->load->library('upload');
        $this->load->library('awsupload');
        

    }

    public function index() 
    {
        $supplier_id = $this->session->userdata("user_id");
        //Url Posted
        $data['action_comp_detail'] = 'supplier/profile/company_detail';
        $data['action_manufacturing_capability'] = 'supplier/profile/manufacturing_capability';
        $data['action_quality_control'] = 'supplier/profile/quality_control';
        $data['action_export_capability'] = 'supplier/profile/export_capability';
        $data['action_company_info'] = 'supplier/profile/company_info';

        ///Unit Master
        $data['unit'] = $this->Common_model->getAll("units")->result_array();
        //Market Distribution
        $data['mar_dist'] = $this->Common_model->getAll("seller_main_market_distribution")->result_array();


        //Country Data 
        $data['country'] = $this->Common_model->getAll("country")->result_array();

        //Fetch Existing Data 

        //$data['comp_det'] = $this->Common_model->getAll("seller_comp_detail", array("user_id" => $supplier_id))->row_array();

        $data['m_compability'] = $this->Common_model->getAll("seller_capability", array("user_id" => $supplier_id))->row_array();




        //In manufacturer Capability available
        $ch_production_pro = $this->Common_model->getAll("seller_production_process", array("user_id" => $supplier_id))->num_rows();
        if ($ch_production_pro > 0) {
            $data['production_pro'] = $this->Common_model->getAll("seller_production_process", array("user_id" => $supplier_id))->result_array();
        }

        $ch_production_line = $this->Common_model->getAll("seller_production_line", array("user_id" => $supplier_id))->num_rows();
        if ($ch_production_line > 0) {
            $data['production_line'] = $this->Common_model->getAll("seller_production_line", array("user_id" => $supplier_id))->result_array();
        }

        $ch_add_info = $this->Common_model->getAll("seller_capability_add_info", array("user_id" => $supplier_id))->num_rows();
        if ($ch_add_info > 0) {
            $data['add_info'] = $this->Common_model->getAll("seller_capability_add_info", array("user_id" => $supplier_id))->result_array();
        }

        $ch_pro_eq = $this->Common_model->getAll("seller_production_equipment", array("user_id" => $supplier_id))->num_rows();
        if ($ch_pro_eq > 0) {
            $data['m_pro_eq'] = $this->Common_model->getAll("seller_production_equipment", array("user_id" => $supplier_id))->result_array();
        }

        //quality Control
        $data['qlty_control'] = $this->Common_model->getAll("seller_quality_control", array("user_id" => $supplier_id))->row_array();

        //$ch_pro_eq = $this->Common_model->getAll("seller_demostrate_qty_control_process", array("user_id" => $supplier_id))->num_rows();
        if ($ch_pro_eq > 0) {
            //$data['qlty_ctrl_process'] = $this->Common_model->getAll("seller_demostrate_qty_control_process", array("user_id" => $supplier_id))->result_array();
        }
        //$ch_pro_eq = $this->Common_model->getAll("seller_control_testing_equipment", array("user_id" => $supplier_id))->num_rows();

        if ($ch_pro_eq > 0) {
            //$data['qlty_test_eqp'] = $this->Common_model->getAll("quality_control_testing_equipment", array("user_id" => $supplier_id))->result_array();
        }
        //Company Info
        //$ch_comp = $this->Common_model->getAll("seller_company_info", array("user_id" => $supplier_id))->num_rows();
        if ($ch_comp > 0) {
            //$data['comp_info'] = $this->Common_model->getAll("seller_company_info", array("user_id" => $supplier_id))->row_array();
        }

        //Export Capability
        //$data['m_export'] = $this->Common_model->getAll("manufacturer_export_capability", array("manufacturers_id" => $supplier_id))->row_array();


        //$ch_cs_port = $this->Common_model->getAll("seller_add_customer_case_m_export", array("user_id" => $supplier_id))->num_rows();
        if ($ch_cs_port > 0) {
            //$data['cust_case'] = $this->Common_model->getAll("seller_add_customer_case_m_export", array("user_id" => $supplier_id))->result_array();
        }


        //$ch_office = $this->Common_model->getAll("seller_company_overseas", array("user_id" => $supplier_id))->num_rows();
        if ($ch_office > 0) {
           // $data['overseas_office'] = $this->Common_model->getAll("seller_company_overseas", array("user_id" => $supplier_id))->result_array();
        }

        //Accepted Delivery Term
       // $data['del_term'] = $this->Profile_model->del_term($supplier_id);
        //Accepted Currency
        //$data['acc_currency'] = $this->Profile_model->acc_currency($supplier_id);

        //Accepted Payment Type
        //$data['acc_payment'] = $this->Profile_model->acc_payment($supplier_id);
        //Manufacture Langyage Spoke

        //$data['language_spoken'] = $this->Profile_model->language_spoken($supplier_id);
        //manufacturer_main_market_distribution

        //$data['mar_dist'] = $this->Profile_model->mar_dist($supplier_id);







        $this->load->view('user/auth/profile', $data);
    }

    function company_detail() 
    {
        $supplier_id = $this->session->userdata("supplier_id");
        $data = $this->input->post();
        $data['manufacturers_id'] = $supplier_id;
        $data['update_at'] = date('Y-m-d H:i:s');
        $ch = $this->Common_model->getAll("manufacturer_comp_detail", array("manufacturers_id" => $supplier_id))->num_rows();

        if ($ch > 0) {
            $result = $this->Common_model->update("manufacturer_comp_detail", $data, array("manufacturers_id" => $supplier_id));
            if ($result) {
                $msg = 'Company Detail Update Successfully';
            }
        } else {
            $result = $this->Common_model->insert('manufacturer_comp_detail', $data);

            if ($result) {
                $msg = 'Company Detail Add Successfully';
            }
        }

        $this->session->set_flashdata('message', $msg);
        redirect(base_url() . "seller/profile");
    }

    function manufacturing_capability() 
    {
        $supplier_id = $this->session->userdata("supplier_id");
        //$data=$this->input->post();


        $data['manufacturers_id'] = $supplier_id;
        //Posting Data 
        $data['show_production_process'] = $this->input->post('show_production_process');
        $data['show_production_equipment'] = $this->input->post('show_production_equipment');
        $data['show_production_line'] = $this->input->post('show_production_line');
        $data['factory_location'] = $this->input->post('factory_location');
        $data['factory_size'] = $this->input->post('factory_size');
        $data['OEM_service_offered'] = $this->input->post('OEM_service_offered');
        $data['design_service_offered'] = $this->input->post('design_service_offered');
        $data['buyer_label_offered'] = $this->input->post('buyer_label_offered');
        $data['oem_experience'] = $this->input->post('oem_experience');
        $data['no_of_qc_staff'] = $this->input->post('no_of_qc_staff');
        $data['no_of_RD_staff'] = $this->input->post('no_of_RD_staff');
        $data['no_of_production_line'] = $this->input->post('no_of_production_line');
        $data['annual_output_value'] = $this->input->post('annual_output_value');
        $data['add_information'] = $this->input->post('add_information');

        $data['updated_at'] = date('Y-m-d H:i:s');
        $ch = $this->Common_model->getAll("manufacturer_capability", array("manufacturers_id" => $supplier_id))->num_rows();

        if ($ch > 0) {
            $result = $this->Common_model->update("manufacturer_capability", $data, array("manufacturers_id" => $supplier_id));

            if ($this->input->post('show_production_process') == 'YES') {

                $this->Common_model->delete("manufacturers_production_process", array("manufacturers_id" => $supplier_id));

                $p_name = $this->input->post('process_name');
                $p_picture = $this->input->post('process_picture');

                $p_desc = $this->input->post('process_desc');

                $count_row = count($p_name);

                for ($i = 0; $i < $count_row; $i++) {
                    if (isset($_FILES['process_picture']['name'][$i]) && !empty($_FILES['process_picture']['name'][$i])) {


                          $img_path1=$this->awsupload->upload($_FILES,'uploads/supplier','image');
                        
                        // if (!$this->upload->do_upload('userFile')) {
                        //     echo json_encode(array('msg' => $this->upload->display_errors()));
                        // } else {
                        //     $fileData = $this->upload->data();

                            //resize image
                            $source_path = './uploads/supplier/' . $fileData['file_name'];
                            $target_path = '';
                            $config_resize = array(
                                'image_library' => 'gd2',
                                'source_image' => json_encode($img_path1),
                                'new_image' => $target_path,
                                'maintain_ratio' => TRUE,
                                'create_thumb' => TRUE,
                                'width' => 325,
                                'height' => 250
                            );

                            $this->load->library('image_lib');
                            $this->image_lib->initialize($config_resize);
                            $this->image_lib->resize();
                        // }
                        // $dat['process_picture'] = base_url() . 'uploads/supplier/' . $fileData['file_name'];
                            $dat['process_picture']=$img_path1;
                    } else {
                        $image_name = $this->input->post('image_name');
                        $dat['process_picture'] = '';
                    }

                    $dat['manufacturers_id'] = $supplier_id;
                    $dat['process_name'] = $p_name[$i];
                    $dat['process_desc'] = $p_desc[$i];
                    if (!empty($p_name[$i])) {
                        $this->Common_model->insert('manufacturers_production_process', $dat);
                    }
                }
            }



            //Start//////show_production_equipment if YES

            if ($this->input->post('show_production_equipment') == 'YES') {
                $this->Common_model->delete("manufacturing_production_equipment", array("manufacturers_id" => $supplier_id));

                $eq_name = $this->input->post('equipment_name');
                $eq_model = $this->input->post('equipment_model');

                $eq_quantity = $this->input->post('equipment_quantity');

                $count_row_eq = count($eq_name);
                for ($i = 0; $i < $count_row_eq; $i++) {
                    $eq_dat['equipment_name'] = $eq_name[$i];
                    $eq_dat['manufacturers_id'] = $supplier_id;
                    $eq_dat['equipment_model'] = $eq_model[$i];
                    $eq_dat['equipment_quantity'] = $eq_quantity[$i];


                    if (!empty($eq_name[$i])) {
                        $this->Common_model->insert('manufacturing_production_equipment', $eq_dat);
                    }
                }
            }


            ///End/////show_production_equipment if YES
            //Start//////show_production_line if YES

            if ($this->input->post('show_production_line') == 'YES') {
                $this->Common_model->delete("manufacturer_production_line", array("manufacturers_id" => $supplier_id));

                $line_production_line_name = $this->input->post('production_line_name');
                $line_supervisor_number = $this->input->post('supervisor_number');

                $line_number_operators = $this->input->post('number_operators');
                $line_qc_number = $this->input->post('qc_number');

                $count_row_eq = count($line_production_line_name);
                for ($i = 0; $i < $count_row_eq; $i++) {
                    $dat_line['production_line_name'] = $line_production_line_name[$i];
                    $dat_line['manufacturers_id'] = $supplier_id;
                    $dat_line['supervisor_number'] = $line_supervisor_number[$i];
                    $dat_line['number_operators'] = $line_number_operators[$i];
                    $dat_line['qc_number'] = $line_qc_number[$i];


                    if (!empty($line_production_line_name[$i])) {
                        $this->Common_model->insert('manufacturer_production_line', $dat_line);
                    }
                }
            }

            ///End/////show_production_line if YES
            //Start//////show_add Info if YES
            if ($this->input->post('show_production_line') == 'YES') {
                $this->Common_model->delete("manufactur_capability_add_info", array("manufacturers_id" => $supplier_id));

                $pro_name = $this->input->post('prod_info_product_name');
                $pro_unit = $this->input->post('unit_produced');

                $pro_annual_op = $this->input->post('highest_annual_output');
                $pro_unit_type = $this->input->post('select_unit_type');

                $count_row_eq = count($pro_name);
                for ($i = 0; $i < $count_row_eq; $i++) {
                    $add_dat['prod_info_product_name'] = $pro_name[$i];
                    $add_dat['manufacturers_id'] = $supplier_id;
                    $add_dat['unit_produced'] = $pro_unit[$i];
                    $add_dat['highest_annual_output'] = $pro_annual_op[$i];
                    $add_dat['select_unit_type'] = $pro_unit_type[$i];
                    $add_dat['updated_at'] = date('Y-m-d H:i:s');

                    if (!empty($pro_name[$i])) {
                        $this->Common_model->insert('manufactur_capability_add_info', $add_dat);
                    }
                }
            }
            ///End/////how_add Info if YES





            if ($result) {
                $msg = 'Record Detail Update Successfully';
            }
        } else {
            $result = $this->Common_model->insert('manufacturer_capability', $data);


            if ($this->input->post('show_production_process') == 'YES') {


                $p_name = $this->input->post('process_name');
                $p_picture = $this->input->post('process_picture');

                $p_desc = $this->input->post('process_desc');

                $count_row = count($p_name);
                for ($i = 0; $i < $count_row; $i++) {
                    if (isset($_FILES['process_picture']['name'][$i])) {
                          

                    $img_path1=$this->awsupload->upload($_FILES,'uploads/supplier');

                        // if (!$this->upload->do_upload('userFile')) {
                        //     echo json_encode(array('msg' => $this->upload->display_errors()));
                        // } else {
                        //     $fileData = $this->upload->data();

                            //resize image
                            // $source_path = './uploads/supplier/' . $fileData['file_name'];
                            $target_path = '';
                            $config_resize = array(
                                'image_library' => 'gd2',
                                'source_image' => json_encode($img_path1),
                                'new_image' => $target_path,
                                'maintain_ratio' => TRUE,
                                'create_thumb' => TRUE,
                                'width' => 325,
                                'height' => 250
                            );

                            $this->load->library('image_lib');
                            $this->image_lib->initialize($config_resize);
                            $this->image_lib->resize();
                        // }
                        // $dat['process_picture'] = base_url() . 'uploads/supplier/' . $fileData['file_name'];
                        $dat['process_picture']=$img_path1;
                    } else {
                        $dat['process_picture'] = '';
                    }
                    $dat['manufacturers_id'] = $supplier_id;
                    $dat['process_name'] = $p_name[$i];
                    $dat['process_desc'] = $p_desc[$i];

                    if (!empty($p_name[$i])) {
                        $this->Common_model->insert('manufacturers_production_process', $dat);
                    }
                }
            }

            //Start//////show_production_equipment if YES

            if ($this->input->post('show_production_equipment') == 'YES') {
                $eq_name = $this->input->post('equipment_name');
                $eq_model = $this->input->post('equipment_model');

                $eq_quantity = $this->input->post('equipment_quantity');

                $count_row_eq = count($eq_name);
                for ($i = 0; $i < $count_row_eq; $i++) {
                    $eq_dat['equipment_name'] = $eq_name[$i];
                    $eq_dat['manufacturers_id'] = $supplier_id;
                    $eq_dat['equipment_model'] = $eq_model[$i];
                    $eq_dat['equipment_quantity'] = $eq_quantity[$i];


                    if (!empty($eq_name[$i])) {
                        $this->Common_model->insert('manufacturing_production_equipment', $eq_dat);
                    }
                }
            }


            ///End/////show_production_equipment if YES
            //Start//////show_production_line if YES

            if ($this->input->post('show_production_line') == 'YES') {
                $line_production_line_name = $this->input->post('production_line_name');
                $line_supervisor_number = $this->input->post('supervisor_number');

                $line_number_operators = $this->input->post('number_operators');
                $line_qc_number = $this->input->post('qc_number');

                $count_row_eq = count($line_production_line_name);
                for ($i = 0; $i < $count_row_eq; $i++) {
                    $dat_line['production_line_name'] = $line_production_line_name[$i];
                    $dat_line['manufacturers_id'] = $supplier_id;
                    $dat_line['supervisor_number'] = $line_supervisor_number[$i];
                    $dat_line['number_operators'] = $line_number_operators[$i];
                    $dat_line['qc_number'] = $line_qc_number[$i];


                    if (!empty($line_production_line_name[$i])) {
                        $this->Common_model->insert('manufacturer_production_line', $dat_line);
                    }
                }
            }

            ///End/////show_production_line if YES
            //Start//////show_add Info if YES
            if ($this->input->post('show_production_line') == 'YES') {
                $pro_name = $this->input->post('prod_info_product_name');
                $pro_unit = $this->input->post('unit_produced');

                $pro_annual_op = $this->input->post('highest_annual_output');
                $pro_unit_type = $this->input->post('select_unit_type');

                $count_row_eq = count($pro_name);
                for ($i = 0; $i < $count_row_eq; $i++) {
                    $add_dat['prod_info_product_name'] = $pro_name[$i];
                    $add_dat['manufacturers_id'] = $supplier_id;
                    $add_dat['unit_produced'] = $pro_unit[$i];
                    $add_dat['highest_annual_output'] = $pro_annual_op[$i];
                    $add_dat['select_unit_type'] = $pro_unit_type[$i];
                    $add_dat['updated_at'] = date('Y-m-d H:i:s');

                    if (!empty($pro_name[$i])) {
                        $this->Common_model->insert('manufactur_capability_add_info', $add_dat);
                    }
                }
            }
            ///End/////how_add Info if YES 


            if ($result) {
                $msg = 'Record Add Successfully';
            }
        }

        $this->session->set_flashdata('message', $msg);
        redirect(base_url() . "supplier/profile");
    }

    function set_upload_options_checklist() 
    {
        //  upload an image options
        $config = array();
        $config['upload_path'] = base_url() . 'uploads/supplier/';
        $config['fieldname'] = 'process_picture';
        $config['allowed_types'] = '*';
        $config['max_size'] = '640000';
        // $config['encrypt_name']     = TRUE;
        return $config;
    }

    //Quality Control
    //Quality Control

    function quality_control() 
    {
        $supplier_id = $this->session->userdata("supplier_id");
        //$data=$this->input->post();


        $data['manufacturers_id'] = $supplier_id;
        //Posting Data 
        $data['quality_control_process'] = $this->input->post('quality_control_process');
        $data['testing_equipment'] = $this->input->post('testing_equipment');
        $data['updated_at'] = date('Y-m-d H:i:s');



        $ch = $this->Common_model->getAll("manufacturer_quality_control", array("manufacturers_id" => $supplier_id))->num_rows();

        if ($ch > 0) {
            $result = $this->Common_model->update("manufacturer_quality_control", $data, array("manufacturers_id" => $supplier_id));

            if ($this->input->post('quality_control_process') == 'YES') {

                $this->Common_model->delete("manufacturers_demostrate_qty_control_process", array("manufacturers_id" => $supplier_id));

                $p_name1 = $this->input->post('qty_process_name');
                $p_picture = $this->input->post('qty_process_picture');

                $p_desc = $this->input->post('qty_process_describe');

                $count_row = count($p_name1);
                for ($i = 0; $i < $count_row; $i++) {
                    if (isset($_FILES['qty_process_picture']['name'][$i]) && !empty($_FILES['qty_process_picture']['name'][$i])) {
                        $_FILES['userFile']['name'] = $_FILES['qty_process_picture']['name'][$i];
                        $_FILES['userFile']['type'] = $_FILES['qty_process_picture']['type'][$i];
                        $_FILES['userFile']['tmp_name'] = $_FILES['qty_process_picture']['tmp_name'][$i];
                        $_FILES['userFile']['error'] = $_FILES['qty_process_picture']['error'][$i];
                        $_FILES['userFile']['size'] = $_FILES['qty_process_picture']['size'][$i];
                        $config['upload_path'] = './uploads/supplier/';
                        $config['allowed_types'] = 'gif|jpg|png|jpeg|bmp';
                        $config['max_size'] = 999999999999;
                        $new_name = 'supp_qlty_ctrl_' . $_FILES['userFile']['name'];
                        $config['file_name'] = $new_name;
                        $this->load->library('upload', $config);
                        $this->upload->initialize($config);
                        if (!$this->upload->do_upload('userFile')) {
                            echo json_encode(array('msg' => $this->upload->display_errors()));
                        } else {
                            $fileData = $this->upload->data();

                            //resize image
                            $source_path = './uploads/supplier/' . $fileData['file_name'];
                            $target_path = '';
                            $config_resize = array(
                                'image_library' => 'gd2',
                                'source_image' => $source_path,
                                'new_image' => $target_path,
                                'maintain_ratio' => TRUE,
                                'create_thumb' => TRUE,
                                'width' => 325,
                                'height' => 250
                            );

                            $this->load->library('image_lib');
                            $this->image_lib->initialize($config_resize);
                            $this->image_lib->resize();
                        }
                        $dat_qlty['qty_process_picture'] = base_url() . 'uploads/supplier/' . $fileData['file_name'];
                    } else {
                        $image_pro = $this->input->post('qlty_image_name');
                        $dat_qlty['qty_process_picture'] = $image_pro[$i];
                    }
                    $dat_qlty['manufacturers_id'] = $supplier_id;
                    $dat_qlty['qty_process_name'] = $p_name1[$i];
                    $dat_qlty['qty_process_describe'] = $p_desc[$i];

                    if (!empty($p_name1[$i])) {
                        $this->Common_model->insert('manufacturers_demostrate_qty_control_process', $dat_qlty);
                    }
                }
            }

            //Start////// quality_control_testing_equipment if YES

            if ($this->input->post('testing_equipment') == 'YES') {
                $this->Common_model->delete("quality_control_testing_equipment", array("manufacturers_id" => $supplier_id));

                $eq_name_qlty = $this->input->post('qlty_equipment_name');
                $eq_model = $this->input->post('qlty_equipment_model');

                $eq_quantity = $this->input->post('qlty_equipment_quantity');

                $count_row_eq = count($eq_name_qlty);
                for ($i = 0; $i < $count_row_eq; $i++) {
                    $eq_dat_qlty['qlty_equipment_name'] = $eq_name_qlty[$i];
                    $eq_dat_qlty['manufacturers_id'] = $supplier_id;
                    $eq_dat_qlty['qlty_equipment_model'] = $eq_model[$i];
                    $eq_dat_qlty['qlty_equipment_quantity'] = $eq_quantity[$i];


                    if (!empty($eq_name_qlty[$i])) {
                        $this->Common_model->insert('quality_control_testing_equipment', $eq_dat_qlty);
                    }
                }
            }
        } else {

            $result = $this->Common_model->insert('manufacturer_quality_control', $data);


            if ($this->input->post('quality_control_process') == 'YES') {


                $p_name1 = $this->input->post('qty_process_name');
                $p_picture = $this->input->post('qty_process_picture');

                $p_desc = $this->input->post('qty_process_describe');

                $count_row = count($p_name1);
                for ($i = 0; $i < $count_row; $i++) {
                    if (isset($_FILES['qty_process_picture']['name'][$i])) {
                        $_FILES['userFile']['name'] = $_FILES['qty_process_picture']['name'][$i];
                        $_FILES['userFile']['type'] = $_FILES['qty_process_picture']['type'][$i];
                        $_FILES['userFile']['tmp_name'] = $_FILES['qty_process_picture']['tmp_name'][$i];
                        $_FILES['userFile']['error'] = $_FILES['qty_process_picture']['error'][$i];
                        $_FILES['userFile']['size'] = $_FILES['qty_process_picture']['size'][$i];
                        $config['upload_path'] = './uploads/supplier/';
                        $config['allowed_types'] = 'gif|jpg|png|jpeg|bmp';
                        $config['max_size'] = 999999999999;
                        $new_name = 'supp_qlty_ctrl_' . $_FILES['userFile']['name'];
                        $config['file_name'] = $new_name;
                        $this->load->library('upload', $config);
                        $this->upload->initialize($config);
                        if (!$this->upload->do_upload('userFile')) {
                            echo json_encode(array('msg' => $this->upload->display_errors()));
                        } else {
                            $fileData = $this->upload->data();

                            //resize image
                            $source_path = './uploads/supplier/' . $fileData['file_name'];
                            $target_path = '';
                            $config_resize = array(
                                'image_library' => 'gd2',
                                'source_image' => $source_path,
                                'new_image' => $target_path,
                                'maintain_ratio' => TRUE,
                                'create_thumb' => TRUE,
                                'width' => 325,
                                'height' => 250
                            );

                            $this->load->library('image_lib');
                            $this->image_lib->initialize($config_resize);
                            $this->image_lib->resize();
                        }
                        $dat_qlty['qty_process_picture'] = base_url() . 'uploads/supplier/' . $fileData['file_name'];
                    } else {
                        $dat_qlty['qty_process_picture'] = '';
                    }
                    $dat_qlty['manufacturers_id'] = $supplier_id;
                    $dat_qlty['qty_process_name'] = $p_name1[$i];
                    $dat_qlty['qty_process_describe'] = $p_desc[$i];

                    if (!empty($p_name1[$i])) {
                        $this->Common_model->insert('manufacturers_demostrate_qty_control_process', $dat_qlty);
                    }
                }
            }

            //Start////// quality_control_testing_equipment if YES

            if ($this->input->post('testing_equipment') == 'YES') {
                $eq_name_qlty = $this->input->post('qlty_equipment_name');
                $eq_model = $this->input->post('qlty_equipment_model');

                $eq_quantity = $this->input->post('qlty_equipment_quantity');

                $count_row_eq = count($eq_name_qlty);
                for ($i = 0; $i < $count_row_eq; $i++) {
                    $eq_dat_qlty['qlty_equipment_name'] = $eq_name_qlty[$i];
                    $eq_dat_qlty['manufacturers_id'] = $supplier_id;
                    $eq_dat_qlty['qlty_equipment_model'] = $eq_model[$i];
                    $eq_dat_qlty['qlty_equipment_quantity'] = $eq_quantity[$i];


                    if (!empty($eq_name_qlty[$i])) {
                        $this->Common_model->insert('quality_control_testing_equipment', $eq_dat_qlty);
                    }
                }
            }
        }

        redirect(base_url() . "seller/profile");
    }

    function export_capability() 
    {
        $supplier_id = $this->session->userdata("supplier_id");
        $data['manufacturers_id'] = $supplier_id;
        //Posting Data 
        $data['total_anual_revenue'] = $this->input->post('total_anual_revenue');
        $data['export_percentage'] = $this->input->post('export_percentage');
        $data['company_started_exporting'] = $this->input->post('company_started_exporting');
        $data['add_customer_case'] = $this->input->post('add_customer_case');
        //$data['products_supply']=$this->input->post('products_supply');
        $data['no_of_employee'] = $this->input->post('no_of_employee');
        $data['nearest_port1'] = $this->input->post('nearest_port1');
        $data['nearest_port2'] = $this->input->post('nearest_port2');
        $data['nearest_port3'] = $this->input->post('nearest_port3');
        $data['average_lead_time'] = $this->input->post('average_lead_time');
        $data['does_your_company'] = $this->input->post('does_your_company');
        $data['updated_at'] = date('Y-m-d H:i:s');



        $ch = $this->Common_model->getAll("manufacturer_export_capability", array("manufacturers_id" => $supplier_id))->num_rows();

        if ($ch > 0) {
            $result = $this->Common_model->update("manufacturer_export_capability", $data, array("manufacturers_id" => $supplier_id));



            if ($this->input->post('add_customer_case') == 'YES') {
                $this->Common_model->delete("manufacturer_add_customer_case_m_export", array("manufacturers_id" => $supplier_id));
                $customer_name1 = $this->input->post('customer_name');
                $country_region1 = $this->input->post('country_region');
                $products_supply1 = $this->input->post('products_supply');
                $corporation_image1 = $this->input->post('corporation_image');
                $transaction_image1 = $this->input->post('transaction_image');
                $annual_turnover1 = $this->input->post('annual_turnover');
                $count_row = count($customer_name1);
                for ($i = 0; $i < $count_row; $i++) {
                    if (isset($_FILES['corperation_photos']['name'][$i]) && !empty($_FILES['corperation_photos']['name'][$i])) {
                        $_FILES['userFile']['name'] = $_FILES['corperation_photos']['name'][$i];
                        $_FILES['userFile']['type'] = $_FILES['corperation_photos']['type'][$i];
                        $_FILES['userFile']['tmp_name'] = $_FILES['corperation_photos']['tmp_name'][$i];
                        $_FILES['userFile']['error'] = $_FILES['corperation_photos']['error'][$i];
                        $_FILES['userFile']['size'] = $_FILES['corperation_photos']['size'][$i];
                        $config['upload_path'] = './uploads/supplier/';
                        $config['allowed_types'] = 'gif|jpg|png|jpeg|bmp';
                        $config['max_size'] = 999999999999;
                        $new_name = 'supp_corporation_m_export_' . $_FILES['userFile']['name'];
                        $config['file_name'] = $new_name;
                        $this->load->library('upload', $config);
                        $this->upload->initialize($config);
                        if (!$this->upload->do_upload('userFile')) {
                            echo json_encode(array('msg' => $this->upload->display_errors()));
                        } else {
                            $fileData = $this->upload->data();

                            //resize image
                            $source_path = './uploads/supplier/' . $fileData['file_name'];
                            $target_path = '';
                            $config_resize = array(
                                'image_library' => 'gd2',
                                'source_image' => $source_path,
                                'new_image' => $target_path,
                                'maintain_ratio' => TRUE,
                                'create_thumb' => TRUE,
                                'width' => 325,
                                'height' => 250
                            );

                            $this->load->library('image_lib');
                            $this->image_lib->initialize($config_resize);
                            $this->image_lib->resize();
                        }
                        $dat_case['corperation_photos'] = base_url() . 'uploads/supplier/' . $fileData['file_name'];
                    } else {
                        $dat_case['corperation_photos'] = $corporation_image1[$i];
                    }

                    if (isset($_FILES['transaction_documents']['name'][$i]) && !empty($_FILES['transaction_documents']['name'][$i])) {
                        $_FILES['userFile']['name'] = $_FILES['transaction_documents']['name'][$i];
                        $_FILES['userFile']['type'] = $_FILES['transaction_documents']['type'][$i];
                        $_FILES['userFile']['tmp_name'] = $_FILES['transaction_documents']['tmp_name'][$i];
                        $_FILES['userFile']['error'] = $_FILES['transaction_documents']['error'][$i];
                        $_FILES['userFile']['size'] = $_FILES['transaction_documents']['size'][$i];
                        $config['upload_path'] = './uploads/supplier/';
                        $config['allowed_types'] = 'gif|jpg|png|jpeg|bmp';
                        $config['max_size'] = 999999999999;
                        $new_name = 'supp_trans_m_export_' . $_FILES['userFile']['name'];
                        $config['file_name'] = $new_name;
                        $this->load->library('upload', $config);
                        $this->upload->initialize($config);
                        if (!$this->upload->do_upload('userFile')) {
                            echo json_encode(array('msg' => $this->upload->display_errors()));
                        } else {
                            $fileData = $this->upload->data();

                            //resize image
                            $source_path = './uploads/supplier/' . $fileData['file_name'];
                            $target_path = '';
                            $config_resize = array(
                                'image_library' => 'gd2',
                                'source_image' => $source_path,
                                'new_image' => $target_path,
                                'maintain_ratio' => TRUE,
                                'create_thumb' => TRUE,
                                'width' => 325,
                                'height' => 250
                            );

                            $this->load->library('image_lib');
                            $this->image_lib->initialize($config_resize);
                            $this->image_lib->resize();
                        }
                        $dat_case['transaction_documents'] = base_url() . 'uploads/supplier/' . $fileData['file_name'];
                    } else {
                        $dat_case['transaction_documents'] = $transaction_image1[$i];
                    }

                    $dat_case['customer_name'] = $customer_name1[$i];
                    $dat_case['manufacturers_id'] = $supplier_id;
                    $dat_case['country_region'] = $country_region1[$i];
                    $dat_case['products_supply'] = $products_supply1[$i];
                    $dat_case['annual_turnover'] = $annual_turnover1[$i];
                    $dat_case['updated_at'] = date('Y-m-d H:i:s');

                    if (!empty($customer_name1[$i])) {
                        $this->Common_model->insert('manufacturer_add_customer_case_m_export', $dat_case);
                    }
                }
            }



            if ($this->input->post('does_your_company') == 'YES') {
                $this->Common_model->delete("manufacturer_company_overseas", array("manufacturers_id" => $supplier_id));
                $p_overseas_country_region = $this->input->post('overseas_country_region');
                $p_overseas_address = $this->input->post('overseas_address');
                $p_overseas_telephone = $this->input->post('overseas_telephone');
                $p_overseas_duties = $this->input->post('overseas_duties');
                $p_overseas_person_charge = $this->input->post('overseas_person_charge');
                $p_no_of_staff = $this->input->post('no_of_staff');
                $p_lease_image = $this->input->post('lease_image');
                $p_office_image = $this->input->post('office_image');
                //$p_lease_certification=$this->input->post('lease_certification');
                //$p_office_photo=$this->input->post('office_photo');

                $count_row = count($p_overseas_telephone);
                for ($i = 0; $i < $count_row; $i++) {
                    if (isset($_FILES['lease_certification']['name'][$i]) && !empty($_FILES['lease_certification']['name'][$i])) {
                        $_FILES['userFile']['name'] = $_FILES['lease_certification']['name'][$i];
                        $_FILES['userFile']['type'] = $_FILES['lease_certification']['type'][$i];
                        $_FILES['userFile']['tmp_name'] = $_FILES['lease_certification']['tmp_name'][$i];
                        $_FILES['userFile']['error'] = $_FILES['lease_certification']['error'][$i];
                        $_FILES['userFile']['size'] = $_FILES['lease_certification']['size'][$i];
                        $config['upload_path'] = './uploads/supplier/';
                        $config['allowed_types'] = 'gif|jpg|png|jpeg|bmp';
                        $config['max_size'] = 999999999999;
                        $new_name = 'supp_overseas_m_export_' . $_FILES['userFile']['name'];
                        $config['file_name'] = $new_name;
                        $this->load->library('upload', $config);
                        $this->upload->initialize($config);
                        if (!$this->upload->do_upload('userFile')) {
                            echo json_encode(array('msg' => $this->upload->display_errors()));
                        } else {
                            $fileData = $this->upload->data();

                            //resize image
                            $source_path = './uploads/supplier/' . $fileData['file_name'];
                            $target_path = '';
                            $config_resize = array(
                                'image_library' => 'gd2',
                                'source_image' => $source_path,
                                'new_image' => $target_path,
                                'maintain_ratio' => TRUE,
                                'create_thumb' => TRUE,
                                'width' => 325,
                                'height' => 250
                            );

                            $this->load->library('image_lib');
                            $this->image_lib->initialize($config_resize);
                            $this->image_lib->resize();
                        }
                        $dat_overseas['lease_certification'] = base_url() . 'uploads/supplier/' . $fileData['file_name'];
                    } else {
                        $dat_overseas['lease_certification'] = $p_lease_image[$i];
                    }

                    if (isset($_FILES['office_photo']['name'][$i]) && !empty($_FILES['office_photo']['name'][$i])) {
                        $_FILES['userFile']['name'] = $_FILES['office_photo']['name'][$i];
                        $_FILES['userFile']['type'] = $_FILES['office_photo']['type'][$i];
                        $_FILES['userFile']['tmp_name'] = $_FILES['office_photo']['tmp_name'][$i];
                        $_FILES['userFile']['error'] = $_FILES['office_photo']['error'][$i];
                        $_FILES['userFile']['size'] = $_FILES['office_photo']['size'][$i];
                        $config['upload_path'] = './uploads/supplier/';
                        $config['allowed_types'] = 'gif|jpg|png|jpeg|bmp';
                        $config['max_size'] = 999999999999;
                        $new_name = 'supp_office_m_export_' . $_FILES['userFile']['name'];
                        $config['file_name'] = $new_name;
                        $this->load->library('upload', $config);
                        $this->upload->initialize($config);
                        if (!$this->upload->do_upload('userFile')) {
                            echo json_encode(array('msg' => $this->upload->display_errors()));
                        } else {
                            $fileData = $this->upload->data();

                            //resize image
                            $source_path = './uploads/supplier/' . $fileData['file_name'];
                            $target_path = '';
                            $config_resize = array(
                                'image_library' => 'gd2',
                                'source_image' => $source_path,
                                'new_image' => $target_path,
                                'maintain_ratio' => TRUE,
                                'create_thumb' => TRUE,
                                'width' => 325,
                                'height' => 250
                            );

                            $this->load->library('image_lib');
                            $this->image_lib->initialize($config_resize);
                            $this->image_lib->resize();
                        }
                        $dat_overseas['office_photo'] = base_url() . 'uploads/supplier/' . $fileData['file_name'];
                    } else {
                        $dat_overseas['office_photo'] = $p_office_image[$i];
                    }

                    $dat_overseas['manufacturers_id'] = $supplier_id;
                    $dat_overseas['overseas_country_region'] = $p_overseas_country_region[$i];
                    $dat_overseas['overseas_address'] = $p_overseas_address[$i];
                    $dat_overseas['overseas_telephone'] = $p_overseas_telephone[$i];
                    $dat_overseas['overseas_duties'] = $p_overseas_duties[$i];
                    $dat_overseas['overseas_person_charge'] = $p_overseas_person_charge[$i];
                    $dat_overseas['updated_at'] = date('Y-m-d H:i:s');

                    if (!empty($p_overseas_telephone[$i])) {
                        $this->Common_model->insert('manufacturer_company_overseas', $dat_overseas);
                    }
                }
            }



            //accpted delivery Term
            $this->Common_model->delete("manufacturer_accepted_delivery_term_child", array("manufacturers_id" => $supplier_id));

            $adc_count = count($this->input->post('accepted_delivery_term'));
            $adc = $this->input->post('accepted_delivery_term');
            for ($i = 0; $i < $adc_count; $i++) {
                $adc_dat['terms_id'] = $adc[$i];
                $adc_dat['manufacturers_id'] = $supplier_id;
                $this->Common_model->insert('manufacturer_accepted_delivery_term_child', $adc_dat);
            }

            //Accepted Payment Currency
            $this->Common_model->delete("manufacturer_accepted_currency_child", array("manufacturers_id" => $supplier_id));
            $apc_count = count($this->input->post('accepted_currency'));
            $apc = $this->input->post('accepted_currency');
            for ($i = 0; $i < $apc_count; $i++) {
                $apc_dat['curr_id'] = $apc[$i];
                $apc_dat['manufacturers_id'] = $supplier_id;
                $this->Common_model->insert('manufacturer_accepted_currency_child', $apc_dat);
            }

            //Accepted Payment Type
            $this->Common_model->delete("manufacturer_accept_pay_type_child", array("manufacturers_id" => $supplier_id));
            $apt_count = count($this->input->post('acc_payment_type'));
            $apt = $this->input->post('acc_payment_type');
            for ($i = 0; $i < $apt_count; $i++) {
                $apt_dat['pay_id'] = $apt[$i];
                $apt_dat['manufacturers_id'] = $supplier_id;
                $this->Common_model->insert('manufacturer_accept_pay_type_child', $apt_dat);
            }

            //Language Spoken
            $this->Common_model->delete("manufacturer_spoken_language_child", array("manufacturers_id" => $supplier_id));
            $lspoken_count = count($this->input->post('mlanguage_spoken'));
            $lsp = $this->input->post('mlanguage_spoken');
            for ($i = 0; $i < $lspoken_count; $i++) {
                $lsp_dat['lang_id'] = $lsp[$i];
                $lsp_dat['manufacturers_id'] = $supplier_id;
                $this->Common_model->insert('manufacturer_spoken_language_child', $lsp_dat);
            }


            //Main Market
            $this->Common_model->delete("manufacturer_main_market_distribution_child", array("manufacturers_id" => $supplier_id));
            $m_count = count($this->input->post('market_dist_value'));
            $market_dist_value = $this->input->post('market_dist_value');
            $market_dist_id = $this->input->post('market_dist_id');
            for ($i = 0; $i < $m_count; $i++) {
                $mm['market_dist_value'] = $market_dist_value[$i];
                $mm['manufacturers_id'] = $supplier_id;
                $mm['market_dist_id'] = $market_dist_id[$i];
                $this->Common_model->insert('manufacturer_main_market_distribution_child', $mm);
            }




            if ($result) {
                $msg = 'Export Detail Update Successfully';
            }
        } else {

            $result = $this->Common_model->insert('manufacturer_export_capability', $data);


            if ($this->input->post('add_customer_case') == 'YES') {
                $customer_name1 = $this->input->post('customer_name');
                $country_region1 = $this->input->post('country_region');
                $products_supply1 = $this->input->post('products_supply');
                $annual_turnover1 = $this->input->post('annual_turnover');
                $count_row = count($customer_name1);
                for ($i = 0; $i < $count_row; $i++) {
                    if (isset($_FILES['corperation_photos']['name'][$i])) {
                        $_FILES['userFile']['name'] = $_FILES['corperation_photos']['name'][$i];
                        $_FILES['userFile']['type'] = $_FILES['corperation_photos']['type'][$i];
                        $_FILES['userFile']['tmp_name'] = $_FILES['corperation_photos']['tmp_name'][$i];
                        $_FILES['userFile']['error'] = $_FILES['corperation_photos']['error'][$i];
                        $_FILES['userFile']['size'] = $_FILES['corperation_photos']['size'][$i];
                        $config['upload_path'] = './uploads/supplier/';
                        $config['allowed_types'] = 'gif|jpg|png|jpeg|bmp';
                        $config['max_size'] = 999999999999;
                        $new_name = 'supp_corporation_m_export_' . $_FILES['userFile']['name'];
                        $config['file_name'] = $new_name;
                        $this->load->library('upload', $config);
                        $this->upload->initialize($config);
                        if (!$this->upload->do_upload('userFile')) {
                            echo json_encode(array('msg' => $this->upload->display_errors()));
                        } else {
                            $fileData = $this->upload->data();

                            //resize image
                            $source_path = './uploads/supplier/' . $fileData['file_name'];
                            $target_path = '';
                            $config_resize = array(
                                'image_library' => 'gd2',
                                'source_image' => $source_path,
                                'new_image' => $target_path,
                                'maintain_ratio' => TRUE,
                                'create_thumb' => TRUE,
                                'width' => 325,
                                'height' => 250
                            );

                            $this->load->library('image_lib');
                            $this->image_lib->initialize($config_resize);
                            $this->image_lib->resize();
                        }
                        $dat_case['corperation_photos'] = base_url() . 'uploads/supplier/' . $fileData['file_name'];
                    } else {
                        $dat_case['corperation_photos'] = '';
                    }

                    if (isset($_FILES['transaction_documents']['name'][$i])) {
                        $_FILES['userFile']['name'] = $_FILES['transaction_documents']['name'][$i];
                        $_FILES['userFile']['type'] = $_FILES['transaction_documents']['type'][$i];
                        $_FILES['userFile']['tmp_name'] = $_FILES['transaction_documents']['tmp_name'][$i];
                        $_FILES['userFile']['error'] = $_FILES['transaction_documents']['error'][$i];
                        $_FILES['userFile']['size'] = $_FILES['transaction_documents']['size'][$i];
                        $config['upload_path'] = './uploads/supplier/';
                        $config['allowed_types'] = 'gif|jpg|png|jpeg|bmp';
                        $config['max_size'] = 999999999999;
                        $new_name = 'supp_trans_m_export_' . $_FILES['userFile']['name'];
                        $config['file_name'] = $new_name;
                        $this->load->library('upload', $config);
                        $this->upload->initialize($config);
                        if (!$this->upload->do_upload('userFile')) {
                            echo json_encode(array('msg' => $this->upload->display_errors()));
                        } else {
                            $fileData = $this->upload->data();

                            //resize image
                            $source_path = './uploads/supplier/' . $fileData['file_name'];
                            $target_path = '';
                            $config_resize = array(
                                'image_library' => 'gd2',
                                'source_image' => $source_path,
                                'new_image' => $target_path,
                                'maintain_ratio' => TRUE,
                                'create_thumb' => TRUE,
                                'width' => 325,
                                'height' => 250
                            );

                            $this->load->library('image_lib');
                            $this->image_lib->initialize($config_resize);
                            $this->image_lib->resize();
                        }
                        $dat_case['transaction_documents'] = base_url() . 'uploads/supplier/' . $fileData['file_name'];
                    } else {
                        $dat_case['transaction_documents'] = '';
                    }

                    $dat_case['customer_name'] = $customer_name1[$i];
                    $dat_case['manufacturers_id'] = $supplier_id;
                    $dat_case['country_region'] = $country_region1[$i];
                    $dat_case['products_supply'] = $products_supply1[$i];
                    $dat_case['annual_turnover'] = $annual_turnover1[$i];
                    $dat_case['updated_at'] = date('Y-m-d H:i:s');

                    if (!empty($customer_name1[$i])) {
                        $this->Common_model->insert('manufacturer_add_customer_case_m_export', $dat_case);
                    }
                }
            }



            if ($this->input->post('does_your_company') == 'YES') {
                $p_overseas_country_region = $this->input->post('overseas_country_region');
                $p_overseas_address = $this->input->post('overseas_address');
                $p_overseas_telephone = $this->input->post('overseas_telephone');
                $p_overseas_duties = $this->input->post('overseas_duties');
                $p_overseas_person_charge = $this->input->post('overseas_person_charge');
                $p_no_of_staff = $this->input->post('no_of_staff');
                //$p_lease_certification=$this->input->post('lease_certification');
                //$p_office_photo=$this->input->post('office_photo');

                $count_row = count($p_overseas_telephone);
                for ($i = 0; $i < $count_row; $i++) {
                    if (isset($_FILES['lease_certification']['name'][$i])) {
                        $_FILES['userFile']['name'] = $_FILES['lease_certification']['name'][$i];
                        $_FILES['userFile']['type'] = $_FILES['lease_certification']['type'][$i];
                        $_FILES['userFile']['tmp_name'] = $_FILES['lease_certification']['tmp_name'][$i];
                        $_FILES['userFile']['error'] = $_FILES['lease_certification']['error'][$i];
                        $_FILES['userFile']['size'] = $_FILES['lease_certification']['size'][$i];
                        $config['upload_path'] = './uploads/supplier/';
                        $config['allowed_types'] = 'gif|jpg|png|jpeg|bmp';
                        $config['max_size'] = 999999999999;
                        $new_name = 'supp_overseas_m_export_' . $_FILES['userFile']['name'];
                        $config['file_name'] = $new_name;
                        $this->load->library('upload', $config);
                        $this->upload->initialize($config);
                        if (!$this->upload->do_upload('userFile')) {
                            echo json_encode(array('msg' => $this->upload->display_errors()));
                        } else {
                            $fileData = $this->upload->data();

                            //resize image
                            $source_path = './uploads/supplier/' . $fileData['file_name'];
                            $target_path = '';
                            $config_resize = array(
                                'image_library' => 'gd2',
                                'source_image' => $source_path,
                                'new_image' => $target_path,
                                'maintain_ratio' => TRUE,
                                'create_thumb' => TRUE,
                                'width' => 325,
                                'height' => 250
                            );

                            $this->load->library('image_lib');
                            $this->image_lib->initialize($config_resize);
                            $this->image_lib->resize();
                        }
                        $dat_overseas['lease_certification'] = base_url() . 'uploads/supplier/' . $fileData['file_name'];
                    } else {
                        $dat_overseas['lease_certification'] = '';
                    }

                    if (isset($_FILES['office_photo']['name'][$i])) {
                        $_FILES['userFile']['name'] = $_FILES['office_photo']['name'][$i];
                        $_FILES['userFile']['type'] = $_FILES['office_photo']['type'][$i];
                        $_FILES['userFile']['tmp_name'] = $_FILES['office_photo']['tmp_name'][$i];
                        $_FILES['userFile']['error'] = $_FILES['office_photo']['error'][$i];
                        $_FILES['userFile']['size'] = $_FILES['office_photo']['size'][$i];
                        $config['upload_path'] = './uploads/supplier/';
                        $config['allowed_types'] = 'gif|jpg|png|jpeg|bmp';
                        $config['max_size'] = 999999999999;
                        $new_name = 'supp_office_m_export_' . $_FILES['userFile']['name'];
                        $config['file_name'] = $new_name;
                        $this->load->library('upload', $config);
                        $this->upload->initialize($config);
                        if (!$this->upload->do_upload('userFile')) {
                            echo json_encode(array('msg' => $this->upload->display_errors()));
                        } else {
                            $fileData = $this->upload->data();

                            //resize image
                            $source_path = './uploads/supplier/' . $fileData['file_name'];
                            $target_path = '';
                            $config_resize = array(
                                'image_library' => 'gd2',
                                'source_image' => $source_path,
                                'new_image' => $target_path,
                                'maintain_ratio' => TRUE,
                                'create_thumb' => TRUE,
                                'width' => 325,
                                'height' => 250
                            );

                            $this->load->library('image_lib');
                            $this->image_lib->initialize($config_resize);
                            $this->image_lib->resize();
                        }
                        $dat_overseas['office_photo'] = base_url() . 'uploads/supplier/' . $fileData['file_name'];
                    } else {
                        $dat_overseas['office_photo'] = '';
                    }

                    $dat_overseas['manufacturers_id'] = $supplier_id;
                    $dat_overseas['overseas_country_region'] = $p_overseas_country_region[$i];
                    $dat_overseas['overseas_address'] = $p_overseas_address[$i];
                    $dat_overseas['overseas_telephone'] = $p_overseas_telephone[$i];
                    $dat_overseas['overseas_duties'] = $p_overseas_duties[$i];
                    $dat_overseas['overseas_person_charge'] = $p_overseas_person_charge[$i];
                    $dat_overseas['updated_at'] = date('Y-m-d H:i:s');

                    if (!empty($supplier_id)) {
                        $this->Common_model->insert('manufacturer_company_overseas', $dat_overseas);
                    }
                }
            }



            //accpted delivery Term
            $adc_count = count($this->input->post('accepted_delivery_term'));
            $adc = $this->input->post('accepted_delivery_term');
            for ($i = 0; $i < $adc_count; $i++) {
                $adc_dat['terms_id'] = $adc[$i];
                $adc_dat['manufacturers_id'] = $supplier_id;
                $this->Common_model->insert('manufacturer_accepted_delivery_term_child', $adc_dat);
            }

            //Accepted Payment Currency
            $apc_count = count($this->input->post('accepted_currency'));
            $apc = $this->input->post('accepted_currency');
            for ($i = 0; $i < $apc_count; $i++) {
                $apc_dat['curr_id'] = $apc[$i];
                $apc_dat['manufacturers_id'] = $supplier_id;
                $this->Common_model->insert('manufacturer_accepted_currency_child', $apc_dat);
            }

            //Accepted Payment Type
            $apt_count = count($this->input->post('acc_payment_type'));
            $apt = $this->input->post('acc_payment_type');
            for ($i = 0; $i < $apt_count; $i++) {
                $apt_dat['pay_id'] = $apt[$i];
                $apt_dat['manufacturers_id'] = $supplier_id;
                $this->Common_model->insert('manufacturer_accept_pay_type_child', $apt_dat);
            }

            //Language Spoken
            $lspoken_count = count($this->input->post('mlanguage_spoken'));
            $lsp = $this->input->post('mlanguage_spoken');
            for ($i = 0; $i < $lspoken_count; $i++) {
                $lsp_dat['lang_id'] = $lsp[$i];
                $lsp_dat['manufacturers_id'] = $supplier_id;
                $this->Common_model->insert('manufacturer_spoken_language_child', $lsp_dat);
            }

            //Main Market
            $m_count = count($this->input->post('market_dist_value'));
            $market_dist_value = $this->input->post('market_dist_value');
            $market_dist_id = $this->input->post('market_dist_id');
            for ($i = 0; $i < $m_count; $i++) {
                $mm['market_dist_value'] = $market_dist_value[$i];
                $mm['manufacturers_id'] = $supplier_id;
                $mm['market_dist_id'] = $market_dist_id[$i];
                $this->Common_model->insert('manufacturer_main_market_distribution_child', $mm);
            }


            if ($result) {
                $msg = 'Export Detail Add Successfully';
            }
        }

        $this->session->set_flashdata('message', $msg);
        redirect(base_url() . "seller/profile");
    }

    function company_info() 
    {
        $supplier_id = $this->session->userdata("supplier_id");
        $data['manufacturers_id'] = $supplier_id;
        //Posting Data 
        $data['company_detailed'] = $this->input->post('company_detailed');

        $ch = $this->Common_model->getAll("manufacturer_company_info", array("manufacturers_id" => $supplier_id))->num_rows();


        if ($ch > 0) {


            if (isset($_FILES['company_photo']['name']) && !empty($_FILES['company_photo']['name'])) {
                $_FILES['userFile']['name'] = $_FILES['company_photo']['name'];
                $_FILES['userFile']['type'] = $_FILES['company_photo']['type'];
                $_FILES['userFile']['tmp_name'] = $_FILES['company_photo']['tmp_name'];
                $_FILES['userFile']['error'] = $_FILES['company_photo']['error'];
                $_FILES['userFile']['size'] = $_FILES['company_photo']['size'];
                $config['upload_path'] = './uploads/supplier/';
                $config['allowed_types'] = 'gif|jpg|png|jpeg|bmp';
                $config['max_size'] = 999999999999;
                $new_name = 'company_photo_' . $_FILES['userFile']['name'];
                $config['file_name'] = $new_name;
                $this->load->library('upload', $config);
                $this->upload->initialize($config);
                if (!$this->upload->do_upload('userFile')) {
                    echo json_encode(array('msg' => $this->upload->display_errors()));
                } else {
                    $fileData = $this->upload->data();

                    //resize image
                    $source_path = './uploads/supplier/' . $fileData['file_name'];
                    $target_path = '';
                    $config_resize = array(
                        'image_library' => 'gd2',
                        'source_image' => $source_path,
                        'new_image' => $target_path,
                        'maintain_ratio' => TRUE,
                        'create_thumb' => TRUE,
                        'width' => 325,
                        'height' => 250
                    );

                    $this->load->library('image_lib');
                    $this->image_lib->initialize($config_resize);
                    $this->image_lib->resize();
                }
                $data['company_photo'] = base_url() . 'uploads/supplier/' . $fileData['file_name'];
            } else {
                $data['company_photo'] = $this->input->post('company_photo_image');
            }


            if (isset($_FILES['company_logo']['name']) && !empty($_FILES['company_logo']['name'])) {
                $_FILES['userFile']['name'] = $_FILES['company_logo']['name'];
                $_FILES['userFile']['type'] = $_FILES['company_logo']['type'];
                $_FILES['userFile']['tmp_name'] = $_FILES['company_logo']['tmp_name'];
                $_FILES['userFile']['error'] = $_FILES['company_logo']['error'];
                $_FILES['userFile']['size'] = $_FILES['company_logo']['size'];
                $config['upload_path'] = './uploads/supplier/';
                $config['allowed_types'] = 'gif|jpg|png|jpeg|bmp';
                $config['max_size'] = 999999999999;
                $new_name = 'company_logo_' . $_FILES['userFile']['name'];
                $config['file_name'] = $new_name;
                $this->load->library('upload', $config);
                $this->upload->initialize($config);
                if (!$this->upload->do_upload('userFile')) {
                    echo json_encode(array('msg' => $this->upload->display_errors()));
                } else {
                    $fileData = $this->upload->data();

                    //resize image
                    $source_path = './uploads/supplier/' . $fileData['file_name'];
                    $target_path = '';
                    $config_resize = array(
                        'image_library' => 'gd2',
                        'source_image' => $source_path,
                        'new_image' => $target_path,
                        'maintain_ratio' => TRUE,
                        'create_thumb' => TRUE,
                        'width' => 325,
                        'height' => 250
                    );

                    $this->load->library('image_lib');
                    $this->image_lib->initialize($config_resize);
                    $this->image_lib->resize();
                }
                $data['company_logo'] = base_url() . 'uploads/supplier/' . $fileData['file_name'];
            } else {
                $data['company_logo'] = $this->input->post('company_logo_image');
            }


            $result = $this->Common_model->update("manufacturer_company_info", $data, array("manufacturers_id" => $supplier_id));


            if ($result) {
                $msg = 'Export Detail Update Successfully';
            }
        } else {

            if (isset($_FILES['company_photo']['name']) && !empty($_FILES['company_photo']['name'])) {
                $_FILES['userFile']['name'] = $_FILES['company_photo']['name'];
                $_FILES['userFile']['type'] = $_FILES['company_photo']['type'];
                $_FILES['userFile']['tmp_name'] = $_FILES['company_photo']['tmp_name'];
                $_FILES['userFile']['error'] = $_FILES['company_photo']['error'];
                $_FILES['userFile']['size'] = $_FILES['company_photo']['size'];
                $config['upload_path'] = './uploads/supplier/';
                $config['allowed_types'] = 'gif|jpg|png|jpeg|bmp';
                $config['max_size'] = 999999999999;
                $new_name = 'company_photo_' . $_FILES['userFile']['name'];
                $config['file_name'] = $new_name;
                $this->load->library('upload', $config);
                $this->upload->initialize($config);
                if (!$this->upload->do_upload('userFile')) {
                    echo json_encode(array('msg' => $this->upload->display_errors()));
                } else {
                    $fileData = $this->upload->data();

                    //resize image
                    $source_path = './uploads/supplier/' . $fileData['file_name'];
                    $target_path = '';
                    $config_resize = array(
                        'image_library' => 'gd2',
                        'source_image' => $source_path,
                        'new_image' => $target_path,
                        'maintain_ratio' => TRUE,
                        'create_thumb' => TRUE,
                        'width' => 325,
                        'height' => 250
                    );

                    $this->load->library('image_lib');
                    $this->image_lib->initialize($config_resize);
                    $this->image_lib->resize();
                }
                $data['company_photo'] = base_url() . 'uploads/supplier/' . $fileData['file_name'];
            } else {
                $data['company_photo'] = '';
            }


            if (isset($_FILES['company_logo']['name']) && !empty($_FILES['company_logo']['name'])) {
                $_FILES['userFile']['name'] = $_FILES['company_logo']['name'];
                $_FILES['userFile']['type'] = $_FILES['company_logo']['type'];
                $_FILES['userFile']['tmp_name'] = $_FILES['company_logo']['tmp_name'];
                $_FILES['userFile']['error'] = $_FILES['company_logo']['error'];
                $_FILES['userFile']['size'] = $_FILES['company_logo']['size'];
                $config['upload_path'] = './uploads/supplier/';
                $config['allowed_types'] = 'gif|jpg|png|jpeg|bmp';
                $config['max_size'] = 999999999999;
                $new_name = 'company_logo_' . $_FILES['userFile']['name'];
                $config['file_name'] = $new_name;
                $this->load->library('upload', $config);
                $this->upload->initialize($config);
                if (!$this->upload->do_upload('userFile')) {
                    echo json_encode(array('msg' => $this->upload->display_errors()));
                } else {
                    $fileData = $this->upload->data();

                    //resize image
                    $source_path = './uploads/supplier/' . $fileData['file_name'];
                    $target_path = '';
                    $config_resize = array(
                        'image_library' => 'gd2',
                        'source_image' => $source_path,
                        'new_image' => $target_path,
                        'maintain_ratio' => TRUE,
                        'create_thumb' => TRUE,
                        'width' => 325,
                        'height' => 250
                    );

                    $this->load->library('image_lib');
                    $this->image_lib->initialize($config_resize);
                    $this->image_lib->resize();
                }
                $data['company_logo'] = base_url() . 'uploads/supplier/' . $fileData['file_name'];
            } else {
                $data['company_logo'] = '';
            }


            $result = $this->Common_model->insert('manufacturer_company_info', $data);

            if ($result) {
                $msg = 'Company Info Add Successfully';
            }
        }

        $this->session->set_flashdata('message', $msg);
        redirect(base_url() . "seller/profile");
    }

}

?>