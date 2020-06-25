<?php

function base64ToImage($base64_string, $output_file)
{
   echo "test";exit;
   $file = fopen($output_file, "wb");
   $data = explode(',', $base64_string);
   fwrite($file, base64_decode($data[0]));
   fclose($file);
   return $output_file;
}


function ImagetoBase64($image)
{
   $imagedata = file_get_contents(FCPATH."/uploads/images/user/".$image);
   // alternatively specify an URL, if PHP settings allow
   $base64 = base64_encode($imagedata);
   return $base64;
}


?>