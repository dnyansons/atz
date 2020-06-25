<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Smstemplate_model extends CI_Model
{
    private $_table;
    public function __construct() 
    {
        parent::__construct();
        $this->_table = "sms_templates";
    }
    
    public function getTemplateNames()
    {
        $cats = [
            ""=>"Select",
            "buyer_success_order_place"=>"buyer_success_order_place",
            "order_approved_by_seller"=>"order_approved_by_seller",
            "order_rejected_by_seller"=>"order_rejected_by_seller",
            "order_dispatched"=>"order_dispatched",
            "order_cancelled_by_seller"=>"order_cancelled_by_seller",
            "order_return_request"=>"order_return_request",
            "product_return_approved"=>"product_return_approved",
            "refund_approved"=>"refund_approved",
            "refund_rejected"=>"refund_rejected",
            "new_order_to_seller"=>"new_order_to_seller",
            "order_pick_up"=>"order_pick_up",
            "order_removed_by_seller"=>"order_removed_by_seller",
            "refund_request_recieved"=>"refund_request_recieved",
            "order_delivered_success"=>"order_delivered_success",
            "return_shipment_picked"=>"return_shipment_picked",
        ];
        return $cats;
    }
    
    public function getTemplateByName($name)
    {
        $this->db->where(["name"=>$name]);
        $query = $this->db->get($this->_table);
        return $query->row();
    }
    
    public function updateTemplate($name,$data)
    {
        $this->db->where(["name"=>$name]);
        $this->db->update($this->_table,$data);
        return $this->db->affected_rows();
    }
}
