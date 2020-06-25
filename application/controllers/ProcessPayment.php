<?php


class ProcessPayment extends CI_Controller 
{
    public function __construct() 
    {
        parent::__construct();
    }
    
    public function index()
    {
        //xyzzyxabcbca1@00!1
        $data = file_get_contents("php://input");
        $insertdata = [
            "response" => json_encode($data),
            "headers" => json_encode(apache_request_headers()),
        ];
        $this->db->insert("temp_test",$insertdata);
        $this->db->insert("temp_test", ["response"=>"Test insert"]);
        
        $str = '{"entity":"event","account_id":"acc_CYtQS54seOT7kX","event":"payment.authorized","contains":["payment"],"payload":{"payment":{"entity":{"id":"pay_Cc6YALNM3Ue7ah","entity":"payment","amount":459912,"currency":"INR","status":"authorized","order_id":null,"invoice_id":null,"international":false,"method":"netbanking","amount_refunded":0,"refund_status":null,"captured":false,"description":"Order # 138","card_id":null,"bank":"SBIN","wallet":null,"vpa":null,"email":"bharatgodam@yopmail.com","contact":"+911234567981","notes":{"soolegal_order_id":"138"},"fee":null,"tax":null,"error_code":null,"error_description":null,"created_at":1559299433}}},"created_at":1559299434}';
    }
}
