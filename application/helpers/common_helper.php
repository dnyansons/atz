<?php
function send_android_old($title,$message,$firebaseid)
{
    //echo $title.'<br>';
    //echo $message.'<br>';
    //echo $firebaseid.'<br>';
    //exit;
    $firebaseid_arr = array($firebaseid);
    echo "<pre>";
    print_r($firebaseid_arr);
//    echo "<pre>";
//    print_r($firebaseid_arr);
//    exit;
//
//    $title = 'Testing Title';
//    $message = 'Testing Message';


        //SERVER KEY TOOK FROM FIREBASE CONSOLE
        $server_key = "AAAAQZPhbOI:APA91bE66fLevVa21qhnG0Wg6pAcUtDCk4CnUDxTDMHCwdDnn1WoHHnkn7oxPOjfG8yZb8H08VwbM6X6VWZoJ7JrP4kZki-Ke8Z5ZipqEhFwq8YviFuOrycxNERMdpNlUOE4NaV4i_j1";
        //FIREBASE URL
        $url = "https://fcm.googleapis.com/fcm/send";
        //DEVICE ID

        $headers = array('Content-Type: application/json','Authorization: key='.$server_key);
        $fields = array('registration_ids' => $firebaseid_arr,'data' => array('title'=>$title,"body"=>$message));
        $payload = json_encode($fields);
        // Open connection
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        $result = curl_exec($ch);
        echo "<pre>";
        print_r($result);
        exit;
        if ($result === FALSE){ die('Curl failed: ' . curl_error($ch)); }
        // Close connection
        curl_close($ch);
                        //print_r($result);
}

function send_android($title,$message,$firebaseid,$type="")
    {
        $device_id = trim($firebaseid);

        //API URL of FCM
        $url = 'https://fcm.googleapis.com/fcm/send';

        /*api_key available in:
        Firebase Console -> Project Settings -> CLOUD MESSAGING -> Server key*/    $api_key = 'AAAAQZPhbOI:APA91bE66fLevVa21qhnG0Wg6pAcUtDCk4CnUDxTDMHCwdDnn1WoHHnkn7oxPOjfG8yZb8H08VwbM6X6VWZoJ7JrP4kZki-Ke8Z5ZipqEhFwq8YviFuOrycxNERMdpNlUOE4NaV4i_j1';

        $fields = array (
            'registration_ids' => array (
                    $device_id
            ),
            'data' => array (
                    "title" => $title,
                    "body" => $message,
                    "type" => $type
            )
        );

        //header includes Content type and api key
        $headers = array(
            'Content-Type:application/json',
            'Authorization:key='.$api_key
        );



        $ch = curl_init();
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

    }

function send_ios($title,$body,$firebaseid,$tag="")
{
    $tag = "";
    $ch = curl_init("https://fcm.googleapis.com/fcm/send");
    $notification = array('title' =>$title , 'text' => $body);
    $headers = array();
    $headers[] = 'Content-Type: application/json';
    $headers[] = 'Authorization:key=AAAAL7El5pg:APA91bHZlGImKkEEs-eC8BsfEP7AHc9SWm1PfYcWkFBTDNFXKpN0pmvp9mqlRtpnnmyGfeBS08IO0jvtRlx-2ljGlUW8G20nsMM0H06m_ELx6nCQuXpLSLJI9wOaaz8-1KSHLLQjkdcg'; // key here
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS,json_encode(array("registration_ids" => $firebaseid, "notification" => $notification,"data" => array("tag"=>$tag),"priority"=>"high")));
    curl_setopt($ch, CURLOPT_HTTPHEADER,$headers);
    $res = curl_exec($ch);
    curl_close($ch);
		//return $res;
}

function add_user_notification($user_id,$notification_title,$notification_msg,$notification_type,$reference_id)
{
    $CI = & get_instance();
    $insert_arr = array();
    $insert_arr['notification_title'] = $notification_title;
    $insert_arr['notification_msg'] = json_encode($notification_msg);
    $insert_arr['notification_type'] = $notification_type;
    $insert_arr['reference_id'] = $reference_id;
    $CI->db->insert('notification_master',$insert_arr);
    $notification_id = $CI->db->insert_id();

//    echo "<pre>";
//    print_r($notification_id);
//    exit;

    if (!empty($notification_id)){
        $notification_insert_arr = array();
        $notification_insert_arr['notification_id'] = $notification_id;
        $notification_insert_arr['user_id'] = $user_id;
        $notification_insert_arr['status'] = 'Received';
        $CI->db->insert('notification',$notification_insert_arr);
    }

}
// code by shailesh date 09-05-2019 function returns to user firebase id
function get_user_firebase_id($user_id)
{

    $CI = &get_instance();
    $firebase_id = $CI->Common_model->select('firebase_id','users_firebase_details',['user_id'=>$user_id])[0]['firebase_id'];

    return $firebase_id;
}

// function
function add_admin_notification($title,$msg,$type,$reference_id)
{
    $CI = &get_instance();

    $insert_arr = array();
    $insert_arr['title'] = $title;
    $insert_arr['msg'] = $msg;
    $insert_arr['type'] = $type;
    $insert_arr['reference_id'] = $reference_id;
    $insert_arr['status'] = 'Received';
    $CI->Common_model->insert('admin_notification',$insert_arr);
}