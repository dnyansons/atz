<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/* 
 * @auther Yogesh Pardeshi
 * comman class to download excel
 */
class Excel extends CI_Controller {
    function __construct() {
        parent::__construct();
    }
    
    function download() {
        $user_type = $this->session->user_role;
        $user_id = $this->session->user_id;
        $statusType = $this->security->xss_clean($this->uri->segment(3,0));
        $tableName = $this->security->xss_clean($this->uri->segment(4,0));
        if($this->session->has_userdata('user_id') && $this->session->has_userdata('user_role')){
            //download filename
            $filename = strtolower($tableName.'_'.$statusType);
            
            switch(strtolower($tableName.'_'.$user_type)) {
                case 'products_seller' :
                    //excel column headers 
                    $headerColumns = array('Product Id','Product Name','Category', 
                                    'moq','Price', 'Available Qty','Date Added', 'Date Approved' );
                    $result = $this->db->select(' CONCAT("PRD" , PD.id),name,categories_name,CONCAT(quantity_from, "--",'
                            . ' quantity_upto) moq, price,available_quantity, '
                             . 'requested_on, approved_on')
                             ->from("product_details PD")
                             ->join("product_price PP", "PD.id=product_id", 'left')
                             ->join("categories_description CD", "category = CD.id", 'left')
                             ->where('seller', $user_id)
                             ->where('publish_status', $statusType)
                             ->get()->result_array();
                    //echo $this->db->last_query();
                    $this->makeExcel($result,$filename, $headerColumns);
                    break;
                
                case 'order_seller' :
                    break;
                
            }
        } else {
            echo "invalid access!";
        }
        
    }
    
    private function makeExcel($data, $filename, array $columnNames) {
        //file name 
    	   $filename = $filename.'_'.date('Y_m_d_H_i_s').'.csv'; 
    	   header("Content-Description: File Transfer"); 
    	   header("Content-Disposition: attachment; filename=$filename"); 
    	   header("Content-Type: application/csv; ");
           //column names for excel sheet
	   $header = $columnNames;
    	   // get data
           $file = fopen('php://output', 'w');	   
    	   //change case of headers
           $header = array_flip($header);
           $header = array_change_key_case($header, CASE_UPPER);
           $header = array_flip($header);

    	   fputcsv($file, $header);
 
    	   foreach ($data as $key=>$line) {
    		 fputcsv($file,$line); 
    	   }
    	   
    	   fclose($file); 
    	   exit; 
    }
}
