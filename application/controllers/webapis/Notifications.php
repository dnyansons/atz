<?php

defined('BASEPATH') OR exit('No direct script access allowed');

use Firebase\JWT\JWT;

class Notifications extends REST_Controller 
{

    public function __construct($config = 'rest') 
    {
        parent::__construct($config);
        $token = $this->input->get_request_header('Token');
        try {
            $this->_payload = JWT::decode($token, $this->config->item('jwt_secret_key'), array('HS256'));
        } catch (Exception $ex) {
            $output = array("status" => 0, "message" => $ex->getMessage());
            $this->response($output, REST_Controller::HTTP_UNAUTHORIZED);
        }
        $this->load->library('form_validation');
        $this->load->model('Users_model');
        $this->load->model('Notifications_model');
        $this->load->library('upload');
    }

    
    public function userNotificationList_post() 
    {
        
         if (!empty($this->_payload->userid)) {
            $user_id = $this->_payload->userid;
            $notification_type = $this->input->post('notification_type');
            $notification_list = $this->Notifications_model->getUserNoticationList($user_id,$notification_type);
         }

        $output = [
            "ws" => 'userNotificationList',
            "status" => 1,
            "message" => "Notification list",
            "data" => $notification_list
        ];
        $this->response($output, REST_Controller::HTTP_OK);
    }
    
    public function markAsRead_post()
    {
        $notification_ids = $this->input->post('notification_ids');
        
        if (!empty($notification_ids)){
            foreach($notification_ids as $notification_id)
            {
                $this->Notifications_model->markAsRead($notification_id);
            }
            
        }
        
        $output = [
            "ws" => 'markAsRead',
            "status" => 1,
            "message" => "Notification Marked as read",
        ];
        $this->response($output, REST_Controller::HTTP_OK);
        
    }
    
    public function deleteNotification_post()
    {
        $notification_ids = $this->input->post('notification_id');
        $this->Notifications_model->deleteNotification($notification_id);
        
        $output = [
            "ws" => 'deleteNotification',
            "status" => 1,
            "message" => "Notification Deleted Successfully",
        ];
        $this->response($output, REST_Controller::HTTP_OK);
        
    }

}
