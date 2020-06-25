<?php

defined('BASEPATH') OR exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;

class Bulkimport extends CI_Controller {

    public function __construct() {
        parent::__construct();
        if (!$this->session->userdata("user_logged_in")) {
            $error = "<div class='alert alert-danger alert-dismissible'>
                        <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                        <strong>Error!</strong> Session timeout, relogin!.
                      </div>";
            $this->session->set_flashdata("message", $error);
            redirect("login", "refresh");
        }
        $this->load->model('Common_model');
        $this->load->model('Product_model');
        $this->load->model('Categories_model');
        $this->load->model('Units_model');
        $this->load->model('Bulkimport_model');
        $this->load->library('form_validation');
        $this->load->library('awsupload');
    }

    public function index() {
        $this->load->view("user/bulkimport/list");
    }

    public function fetch_bulkimport() {

        $columns = array(
            0 => '',
            1 => 'file_name',
            2 => 'total',
            3 => 'tot_pass',
            4 => 'tot_failed',
            5 => 'date_created'
        );

        $limit = $this->input->post('length');
        $start = $this->input->post('start');
        $order = $columns[$this->input->post('order')[0]['column']];
        $dir = $this->input->post('order')[0]['dir'];
        //$dir ="desc";

        $totalData = $this->Bulkimport_model->all_count();

        $totalFiltered = $totalData;

        if (empty($this->input->post('search')['value'])) {
            $vendors = $this->Bulkimport_model->all_bulk($limit, $start, $order, $dir);
            // echo $this->db->last_query();
        } else {
            $search = $this->input->post('search')['value'];

          //  $vendors = $this->Bulkimport_model->all_bulk_search($limit, $start, $search, $order, $dir);

            $totalFiltered = $this->Bulkimport_model->all_bulk_search_count($search);
        }

        $data = array();
        if (!empty($vendors)) {
            $i = 0;
            foreach ($vendors as $vdr) {
                if ($this->session->userdata("user_id") == $vdr->user_id) {

                    
                    $ext=explode('.',$vdr->file_name);    
                    //check failed File
                    //$filename = "uploads/sheets/products/failed_" . $vdr->id .'.'.$ext[1];
                    $filename=$vdr->file_name;
                    if (file_exists($filename)) {
                        $upfile_code = $filename;
                    } else {
                        $upfile_code = '';
                    }
                    $nestedData['sr_no'] = $i += 1;
                    $nestedData['file_name'] = basename($vdr->file_name);
                    $nestedData['total'] = $vdr->tot_pass + $vdr->tot_failed;
                    $nestedData['tot_pass'] = $vdr->tot_pass;
                    $nestedData['tot_failed'] = $vdr->tot_failed;

                    if ($vdr->tot_failed != 0) {
                        $nestedData['download'] = '<a href="' . $vdr->file_name . '">Click To Download</a>';

                    } else {
                        $nestedData['download'] = 'No File Exist';
                    }
                    $nestedData['date_created'] = date("d-m-Y", strtotime($vdr->date_created));
                    $data[] = $nestedData;
                }
            }
        }

        $json_data = array(
            "draw" => intval($this->input->post('draw')),
            "recordsTotal" => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data" => $data,
            'query' => $this->db->last_query()
        );

        echo json_encode($json_data);
    }

    public function import() {

        $this->form_validation->set_rules('submit', 'Submit', 'required');
        if (empty($_FILES['upload_file']['name'])) {
            $this->form_validation->set_rules('upload_file', 'xls | csv | xlsx File ', 'required');
            $this->form_validation->set_error_delimiters('<p style="color:red" class="text-left">', '</p>');
        }
        if ($this->form_validation->run() === false) {
            $this->load->view("user/bulkimport/import");
        } else {
            //count Existing File
            $this->db->select("MAX(id) as id");
            $query = $this->db->get("product_bulk_import");
            $res = $query->row();
            $ex_count = $res->id + 1;
            $file_mimes = array('text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'text/plain', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            if (isset($_FILES['upload_file']['name']) && in_array($_FILES['upload_file']['type'], $file_mimes)) {
                $arr_file = explode('.', $_FILES['upload_file']['name']);
                $extension = end($arr_file);

                if ($extension == 'xlsx') {
                    $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
                } elseif ($extension == 'csv') {
                    $reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
                } elseif ($extension == 'xls') {
                    $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
                } else {
                    $msg = "<div class='alert alert-danger alert-dismissible'>
                            <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                            <strong></strong> Only xlsx | xlx | csv File Allowed!
                        </div>";
                    $this->session->set_flashdata('message', $msg);

                    redirect('seller/bulkimport');
                    exit;
                }

                $inputFileName = $_FILES['upload_file']['tmp_name'];
                $spreadsheet = $reader->load($inputFileName);
                $filenNameSave = $_FILES['upload_file']['name'];
                $abc = $spreadsheet->getActiveSheet();

                $data = $abc->toarray();
                array_shift($data);


                $failed = [];
                foreach ($data as $row):
                    $valid = $this->validate_data($row);
                    $category = $this->Categories_model->get_category_by_name($row[1]);
                    $unit = $this->Units_model->getUnitByName($row[6]);

                    if (!$category || !$unit) {
                        $valid = 0;
                    }

                    if ($valid) {
                        $productDetails = [
                            "name" => $row[2],
                            "keywords" => $row[3],
                            "description" => $row[23],
                            "seller" => $this->session->userdata('user_id'),
                            "category" => $category->categories_id,
                            "provide_order_at_buyer_place" => 1,
                            "price_type" => strtolower($row[5]),
                            "height" => $row[21],
                            "weight" => $row[19],
                            "width" => $row[20],
                            "length" => $row[22],
                            "is_product_returnable" => $row[4],
                            "product_return_days" => isset($row[4]) ? 0 : 1,
                            "available_quantity" => $row[17],
                            "track_inventory" => 0,
                            "bulk_upload" => 1
                        ];

                        $product_id = $this->Product_model->addProduct($productDetails);
                        $price[0] = [
                            "product_id" => $product_id,
                            "quantity_from" => $row[7],
                            "quantity_upto" => $row[17],
                            "price" => $row[8],
                            "unit" => $unit->units_id,
                            "final_price" => round($row[8]),
                            "atz_price" => round($row[8])
                        ];
                        if (strtolower($row["5"]) == "uniform") {
                            $price[0] = [
                                "product_id" => $product_id,
                                "quantity_from" => $row[9],
                                "quantity_upto" => $row[11],
                                "price" => $row[10],
                                "unit" => $unit->units_id,
                                "final_price" => round($row[10]),
                                "atz_price" => round($row[10])
                            ];
                            $price[1] = [
                                "product_id" => $product_id,
                                "quantity_from" => $row[11],
                                "quantity_upto" => $row[13],
                                "price" => $row[12],
                                "unit" => $unit->units_id,
                                "final_price" => round($row[12]),
                                "atz_price" => round($row[12])
                            ];
                            $price[2] = [
                                "product_id" => $product_id,
                                "quantity_from" => $row[13],
                                "quantity_upto" => $row[15],
                                "price" => $row[14],
                                "unit" => $unit->units_id,
                                "final_price" => round($row[14]),
                                "atz_price" => round($row[14])
                            ];
                            $price[3] = [
                                "product_id" => $product_id,
                                "quantity_from" => $row[15],
                                "quantity_upto" => $row[17],
                                "price" => $row[16],
                                "unit" => $unit->units_id,
                                "final_price" => round($row[16]),
                                "atz_price" => round($row[16])
                            ];
                        }
                        $this->Product_model->addPrices($price);
                        $product_images = array(
                            "product_id" => $product_id,
                            "type" => "photo",
                            "url" => ["https://www.atzcart.com/uploads/images/products/default.png"],
                        );
                        $this->Product_model->updateMedia($product_id, $product_images);
                        $cats = $this->Categories_model->getParentsByChild($category->categories_id);
                        if ($cats) {
                            $ids = [
                                $cats->child,
                                $cats->parent,
                                $cats->super_parent,
                            ];
                            $this->Categories_model->incrementProductCount($ids);
                        }
                    } else {
                        if (!empty($row)) {
                            $failed[] = array_filter($row);
                        }
                    }
                    $i++;
                endforeach;
                $failed = array_filter($failed);
                if (count($failed) > 0) {

                    $spreadsheet2 = new Spreadsheet();
                    $sheet = $spreadsheet2->getActiveSheet();

                    $sheet->getStyle("A1:X1")->getFont()->setSize(12);
                    $sheet->getStyle("A1:X1")->getFont()->setBold(true);
                    $sheet->getStyle("A1:X1")->getFont()->setName('Calibri');
                    $sheet->getStyle("A1:X1")->getFont()->getColor()->setRGB('3F7FFF');


                    $sheet->setCellValue('A1', 'Vendor ID');
                    $sheet->setCellValue('B1', 'Category');
                    $sheet->setCellValue('C1', 'Product Name');
                    $sheet->setCellValue('D1', 'Meta Keywords');
                    $sheet->setCellValue('E1', 'Is Product Returnabale');
                    $sheet->setCellValue('F1', 'Price Type');
                    $sheet->setCellValue('G1', 'Unit');
                    $sheet->setCellValue('H1', 'Min QTY');
                    $sheet->setCellValue('I1', 'Price per unit');
                    $sheet->setCellValue('J1', 'MOQ 1');
                    $sheet->setCellValue('K1', 'MOQ 1 Price');
                    $sheet->setCellValue('L1', 'MOQ 2');
                    $sheet->setCellValue('M1', 'MOQ 2 Price');
                    $sheet->setCellValue('N1', 'MOQ 3');
                    $sheet->setCellValue('O1', 'MOQ 3 Price');
                    $sheet->setCellValue('P1', 'MOQ 4');
                    $sheet->setCellValue('Q1', 'MOQ 4 Price');
                    $sheet->setCellValue('R1', 'Avail QTY');
                    $sheet->setCellValue('S1', 'Low Stk QTY');
                    $sheet->setCellValue('T1', 'weight');
                    $sheet->setCellValue('U1', 'width');
                    $sheet->setCellValue('V1', 'height');
                    $sheet->setCellValue('W1', 'length');
                    $sheet->setCellValue('X1', 'Description');

                    $rows = 2;
                    $sl = 0;

                    foreach ($failed as $val) {

                        $sl++;
                        $sheet->setCellValue('A' . $rows, $val[0]);
                        $sheet->setCellValue('B' . $rows, $val[1]);
                        $sheet->setCellValue('C' . $rows, $val[2]);
                        $sheet->setCellValue('D' . $rows, $val[3]);
                        $sheet->setCellValue('E' . $rows, $val[4]);
                        $sheet->setCellValue('F' . $rows, $val[5]);
                        $sheet->setCellValue('G' . $rows, $val[6]);
                        $sheet->setCellValue('H' . $rows, $val[7]);
                        $sheet->setCellValue('I' . $rows, $val[8]);
                        $sheet->setCellValue('J' . $rows, $val[9]);
                        $sheet->setCellValue('K' . $rows, $val[10]);
                        $sheet->setCellValue('L' . $rows, $val[11]);
                        $sheet->setCellValue('M' . $rows, $val[12]);
                        $sheet->setCellValue('N' . $rows, $val[13]);
                        $sheet->setCellValue('O' . $rows, $val[14]);
                        $sheet->setCellValue('P' . $rows, $val[15]);
                        $sheet->setCellValue('Q' . $rows, $val[16]);
                        $sheet->setCellValue('R' . $rows, $val[17]);
                        $sheet->setCellValue('S' . $rows, $val[18]);
                        $sheet->setCellValue('T' . $rows, $val[19]);
                        $sheet->setCellValue('U' . $rows, $val[20]);
                        $sheet->setCellValue('V' . $rows, $val[21]);
                        $sheet->setCellValue('W' . $rows, $val[22]);
                        $sheet->setCellValue('X' . $rows, $val[23]);

                        $rows++;
                    }
                    $sheet->getStyle('A1:X' . $rows)->getAlignment()->setHorizontal('center');
                    $sheet->getStyle('A1:X' . $rows)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                    foreach (range('A', $sheet->getHighestDataColumn()) as $col) {
                        $sheet->getColumnDimension($col)->setAutoSize(true);
                    }


                    $fileName = $this->awsupload->getUniqueName('xlsx');
                    $writer = new Xlsx($spreadsheet2);
                    $filenNameSave = $this->awsupload->streamWrapper('uploads/sheets/products/' . $fileName);
                    $writer->save('s3://atzcarttest/uploads/sheets/products/' . $fileName);
                }
                $dat['file_name'] = $filenNameSave;
                $dat['tot_failed'] = count($failed);
                $dat['tot_pass'] = count($data) - count($failed);
                $dat['user_id'] = $this->session->userdata("user_id");
                $dat['upload_by'] = 'Seller - ' . $this->session->userdata("user_name");
                $dat['uploaded_by'] = 'Seller';
                $this->Common_model->insert('product_bulk_import', $dat);

                $msg = "<div class='alert alert-success alert-dismissible'>
                            <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                            <strong></strong> File Import Successfully !
                        </div>";
                $this->session->set_flashdata('message', $msg);

                redirect('seller/bulkimport');
            } else {
                $msg = "<div class='alert alert-danger alert-dismissible'>
                            <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                            <strong></strong> Only xlsx | xlx | csv File Allowed!
                        </div>";
                $this->session->set_flashdata('message', $msg);
                redirect('seller/bulkimport');
            }
        }
    }

    private function validate_data($row) {
        $valid = 1;
        if (empty($row[0]) || empty($row[1]) || empty($row[2]) || empty($row[3]) || empty($row[4]) || empty($row[5]) || empty($row[6]) || empty($row[17]) || empty($row[18]) || empty($row[19]) || empty($row[20]) || empty($row[21]) || empty($row[22]) || empty($row[23])) {
            $valid = 0;
        }

        if (strtolower($row[5]) == "uniform") {
            if (empty($row[9]) || empty($row[10]) || empty($row[11]) || empty($row[12]) || empty($row[13]) || empty($row[14]) || empty($row[15]) || empty($row[16])) {
                $valid = 0;
            }
        } else if (strtolower($row[5]) == "single") {
            if (empty($row[7]) || empty($row[8])) {
                $valid = 0;
            }
        } else {
            $valid = 0;
        }
        return $valid;
    }

}
