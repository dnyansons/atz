<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Browser_notification {

    private $CI;

    function __construct() {
        $this->CI = get_instance();
        $this->CI->load->model('Common_model');
    }

    function notifyadmin($title, $message, $tag) {
        $fb = $this->CI->Common_model->getAll("admin")->result_array();
        $firebaseid = array();
        foreach ($fb as $res) {
            if (!empty($res['firebase_token'])) {
                $firebaseid[] = $res['firebase_token'];
            }
        }
        //SERVER KEY TOOK FROM FIREBASE CONSOLE
        $server_key = "AAAAQZPhbOI:APA91bE66fLevVa21qhnG0Wg6pAcUtDCk4CnUDxTDMHCwdDnn1WoHHnkn7oxPOjfG8yZb8H08VwbM6X6VWZoJ7JrP4kZki-Ke8Z5ZipqEhFwq8YviFuOrycxNERMdpNlUOE4NaV4i_j1";
        //FIREBASE URL
        $url = "https://fcm.googleapis.com/fcm/send";
        $headers = array('Content-Type: application/json', 'Authorization: key=' . $server_key);
        $fields = array('registration_ids' => $firebaseid, 'data' => array('title' => $title, 'body' => $message, 'tag' => $tag));
        $payload = json_encode($fields);
        // Open connection
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        $result = curl_exec($ch);
        if ($result === FALSE) {
            die('Curl failed: ' . curl_error($ch));
        }
        // Close connection
        curl_close($ch);
        return $result;
    }

   function notifyseller($seller_id,$title, $message, $tag) 
    {
        
        $fb =$this->CI->Common_model->getAll("users_firebase_details",array('user_id'=>$seller_id))->result_array();
    
        $firebaseid = array();
        foreach($fb as $res)
        {
            if(!empty($res['firebase_id']))
            {
             $firebaseid[] = $res['firebase_id'];
            }
        }
        //SERVER KEY TOOK FROM FIREBASE CONSOLE
        $server_key = "AAAAQZPhbOI:APA91bE66fLevVa21qhnG0Wg6pAcUtDCk4CnUDxTDMHCwdDnn1WoHHnkn7oxPOjfG8yZb8H08VwbM6X6VWZoJ7JrP4kZki-Ke8Z5ZipqEhFwq8YviFuOrycxNERMdpNlUOE4NaV4i_j1";
        //FIREBASE URL
        $url = "https://fcm.googleapis.com/fcm/send";
        $headers = array('Content-Type: application/json', 'Authorization: key=' . $server_key);
        $fields = array('registration_ids' => $firebaseid, 'data' => array('title' => $title, 'body' => $message, 'tag' => $tag));
        $payload = json_encode($fields);
        // Open connection
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        $result = curl_exec($ch);
        if ($result === FALSE) {
            die('Curl failed: ' . curl_error($ch));
        }
        // Close connection
        curl_close($ch);
        return $result;
    }
    
    function notify_buyer($title,$message,$firebaseid,$type="",$type_id="")
    {
        $device_id = trim($firebaseid);
        $url = 'https://fcm.googleapis.com/fcm/send';
        $api_key = 'AAAAQZPhbOI:APA91bE66fLevVa21qhnG0Wg6pAcUtDCk4CnUDxTDMHCwdDnn1WoHHnkn7oxPOjfG8yZb8H08VwbM6X6VWZoJ7JrP4kZki-Ke8Z5ZipqEhFwq8YviFuOrycxNERMdpNlUOE4NaV4i_j1';

        $fields = array (
            'registration_ids' => array (
                    $device_id
            ),
            'data' => array ("title" => $title,"body" => $message,"type" => $type,"type_id" => $type_id)
        );
       
        $headers = array(
            'Content-Type:application/json',
            'Authorization:key='.$api_key
        );
        
        $ch=curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        $result = curl_exec($ch);
        if ($result === FALSE) {
            die('FCM Send Error: ' . curl_error($ch));
        }
        curl_close($ch);
        
        return $result;
        
    }
    
}

?>