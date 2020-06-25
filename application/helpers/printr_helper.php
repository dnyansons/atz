<?php 
function printr($data,$lastquery=0,$dump=0) {
   echo "<pre>";
      print_r($data);
      echo "<br/>";
      if($dump==1){
          echo "Variable Data type:<br/>----------------------------<br/>";
          var_dump($data);
      }
      echo "<br/>";
      if($lastquery==1){
          echo "Following Last Query Execute:<br/>----------------------------<br/>";
          $ci=& get_instance();
          $ci->load->database(); 
          echo $ci->db->last_query();
      }
   echo "</pre>";
   die;
}

