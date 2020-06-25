<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Notifications_model extends CI_Model 
{
    public function __construct() 
    {
        parent::__construct();
        $this->load->database();
        
    }
    
    public function getUserNoticationList($user_id,$notification_type)
    {
        $this->db->select('n.id,m.notification_title,m.notification_msg,m.notification_type,n.status,m.date_created,m.reference_id');
        $this->db->from('notification n');
        $this->db->join('notification_master m','m.id = n.notification_id','inner');
        if ($notification_type != 'All'){
            $this->db->where(['notification_type'=>$notification_type,'user_id'=>$user_id]);
        }else{
            $this->db->where('n.user_id',$user_id);
        }
        
        $query = $this->db->get();
        $result = $query->result_array();
        return $result;
    }
    
    public function markAsRead($notification_id)
    {
        $this->db->where(['id'=>$notification_id]);

	$query = $this->db->update('notification',['status'=>'Read']);
    }
    
    public function deleteNotification($notification_id)
    {
        $this->db->where(['id'=>$notification_id]);

        $query = $this->db->delete('notification');
    }
}