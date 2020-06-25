<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Imageupload
{

function _construct() 
{
   $CI =& get_instance();     
$CI->load->database();     
$CI->load->library("session");
$array = array(); 
}
function image_upload($array)
   {
   	
   	/*  DUMMY
$array = array ('upload_path'=>'./folder_name/',
'max_width'=>'2024',
'max_height'=>'1000',
'overwrite'=>'TRUE',
'fieldname'=>'input_field_name',
'resize'=>TRUE,
'resize_image_path'=>'./folder_path_of_resized_img',
'thumb_marker'=>'_/!/@/#/$',
'resize_width'=>'xx px',
'resize_height'=>'xx px',
'rename_image'=>TRUE,
'rename_name'=>'new_name'
);

$this->imageupload->image_upload($array); 
*/

   	$data_file = array();
   
   	$CI =& get_instance();     
$CI->load->database();     
$CI->load->library("session");
    $uploadpath=$array['upload_path']; //compulsary
$max_width=isset($array['max_width'])?$array['max_width']:'5024';
$max_height=isset($array['max_height'])?$array['max_height']:'5024';
$overwrite=isset($array['overwrite'])?$array['overwrite']:'TRUE';
$fieldname = isset($array['fieldname'])?$array['fieldname']:'';//compulsary
$resize = isset($array['resize'])?$array['resize']:FALSE;
$resize_image_path = isset($array['resize_image_path'])?$array['resize_image_path']:'';//compulsary if resized
$thumb_marker = isset($array['thumb_marker'])?$array['thumb_marker']:'';
$resize_width=isset($array['resize_width'])?$array['resize_width']:'';//compulsary if resized
$resize_height=isset($array['resize_height'])?$array['resize_height']:'';//compulsary if resized
$rename=isset($array['rename_image'])?$array['rename_image']:FALSE;
$en_name=isset($array['encrypt_name'])?$array['encrypt_name']:FALSE;
$rename_name=isset($array['rename_name'])?$array['rename_name']:'';//compulsary if renamed



$config['upload_path'] = $uploadpath;
$config['allowed_types'] = '*';/*'jpg|png|JPEG|PNG|jpeg|JPG|txt|docx|doc|pdf|xlsx|xls|xlsm';*/
$config['max_width']  = $max_width;
$config['max_height']  =$max_height;
$config['overwrite']  = $overwrite;
$config['encrypt_name'] = $en_name;
   }
}
?>