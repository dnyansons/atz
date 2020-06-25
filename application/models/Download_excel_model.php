<?php

defined('BASEPATH') OR exit('No direct script access allowed');
/*
 * Model to handle download of excel reports
 * @auther Yogesh  Pardeshi 23072019 1050am
 * uses phpoffice spreadsheet library
 */

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;

class Download_excel_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function download($fileName, $excelTitle, $excelCoulmunNames, $excelColumnData, $redirect) {
        $atzAlpha = range('A', 'Z');
        $countTotalColumns = count($excelCoulmunNames);
        if($countTotalColumns <= 26){
            $excelColumnIndex = range('A', $atzAlpha[$countTotalColumns]);
        } else {
            $excelColumnIndex = range('A', 'Z');
        }
        
        $column = array();
        //add columns iff greater than 26
        if( $countTotalColumns > 26) {
            $dummyColumnNames = $excelColumnIndex;
            // Iterate over 26 letters.
            foreach ($dummyColumnNames as $letter) {
                // Paste the $first_letters before the next.
                $column = 'A' . $letter;
                // Add the column to the final array.
                $excelColumnIndex[] = $column;
            }
        }

        //$fileName = $fileName . '_' . date('d-m-Y') . '_'.time().'_.xlsx';

        if (!empty($fileName) && count($excelCoulmunNames) > 0 && count($excelColumnData) > 0) {
            $countSizestretch = count($excelCoulmunNames);
            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();
            $sheet->setTitle($excelTitle);
            $sheet->setCellValue('A2', strtoupper($excelTitle));
            $sheet->mergeCells('A2:'.$excelColumnIndex[$countSizestretch].'2');
            $sheet->getStyle("A2")->getFont()->setSize(18);
            $sheet->getStyle("A3:"+$excelColumnIndex[$countSizestretch]+"3")->getFont()->setSize(14);
            $sheet->getStyle("A3:"+$excelColumnIndex[$countSizestretch]+"3")->getFont()->setBold(true);
            $sheet->getStyle("A3:"+$excelColumnIndex[$countSizestretch]+"3")->getFont()->setName('Calibri');
            $sheet->getStyle("A3:"+$excelColumnIndex[$countSizestretch]+"3")->getFont()->getColor()->setRGB('3F7FFF');

            $count = count($excelCoulmunNames);

            $sheet->setCellValue('A3', 'SR. NO.');

            for ($i = 1; $i <= $count; $i++) {
                $sheet->setCellValue($excelColumnIndex[$i] . '3', strtoupper($excelCoulmunNames[$i - 1]));
            }

            $rows = 4; //to start actual data to print from row number
            $countValues = count($excelColumnData); //so as to automate data autoprint
            $j = 0;
            $k = 1;
            
            foreach ($excelColumnData as $dataRow) {
                $sheet->setCellValue($excelColumnIndex[0] . $rows, $j + 1);
                foreach($dataRow as $val){
                    $sheet->setCellValue($excelColumnIndex[$k] . $rows, $val);
                    $k++;
                }
                $j++;
                $rows++;
                $k = 1;
            }

            $setCenterUpto = $excelColumnIndex[$countTotalColumns];
            $sheet->getStyle('A2:'.$setCenterUpto . $rows)->getAlignment()->setHorizontal('center');
            $sheet->getStyle('A2:'.$setCenterUpto . $rows)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
            
            foreach ($excelColumnIndex as $col) {
                $sheet->getColumnDimension($col)->setAutoSize(true);
            }

            $writer = new Xlsx($spreadsheet);
            $writer->save("./uploads/" . $fileName);
            header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // Date in the past
            header("Content-Type:   application/vnd.ms-excel; charset=utf-8");
            header("Content-Type: application/vnd.ms-excel");
            header('Content-Disposition: attachment;filename="'. $fileName); 
            header('Cache-Control: max-age=0');
            $writer->save('php://output'); // download file 
        } else {
            $error = "<div class='alert alert-danger alert-dismissible'>
                        <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                        <strong>Error!</strong> No Records Found.
                      </div>";
            $this->session->set_flashdata('message', $error);
            redirect("admin/$redirect" . $page, "refresh");
        }
    }

}
