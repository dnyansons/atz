<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Dashboard extends CI_Controller 
{
    public function __construct() 
    {
        parent::__construct();
        if (!$this->session->userdata("user_logged_in") || $this->session->userdata("user_role")!="seller") {
            $error = "<div id='login-error' class='form-error notice notice-error'><span class='icon-notice icon-error'></span><span><strong>Error!</strong> Session timeout, relogin!. </span></div>";
            $this->session->set_flashdata("message", $error);
            redirect("login", "refresh");
        }
        $this->load->model('Dashboard_model'); 
        $this->load->model('Packages_model'); 
        $this->load->model('Users_model'); 
    }

    public function index() 
    {
        $user_id=$this->session->userdata("user_id");
        $data = [
            "pageTitle" => "Seller Dashboard"
        ];
		
        //Seller Dashboard
        $data['user_role'] = 'seller';

        $this->session->set_userdata("user_role", 'seller');

        $user_id = $this->session->userdata("user_id");
        $data['tot_order'] = $this->Dashboard_model->tot_order_supp($user_id);
        $data['tot_sale'] = $this->Dashboard_model->tot_sale_supp($user_id);
       // echo $this->db->last_query();
        // exit;
        $data['tot_customer'] = $this->Dashboard_model->tot_customer_supp($user_id);
        $data['monthly_orders'] = $this->Dashboard_model->supp_orders_monthly($user_id);
		$this->db->select("P.id")
                ->from("product_details P")
                ->join("categories_description C", "P.category = C.categories_id")
                ->join("product_media PM", "PM.id = (SELECT id FROM product_media PM1 WHERE "
                        . "PM1.product_id = P.id ORDER BY PM1.id ASC LIMIT 1)")
                ->join("product_price PC1", "PC1.id = (SELECT id FROM product_price PC3 WHERE "
                        . "PC3.product_id = P.id ORDER BY PC3.id ASC LIMIT 1)")
                ->join("product_price PC2", "PC2.id = (SELECT id FROM product_price PC4 WHERE "
                        . "PC4.product_id = P.id ORDER BY PC4.id DESC LIMIT 1)")
                ->where("P.publish_status", "approved")
				->where("P.seller",$user_id)
				->order_by("P.id","ASC");
				$query = $this->db->get();
		$data["approved_count"] = $query->num_rows();		
		$data['tot_approved_product'] = $this->Dashboard_model->tot_sale_supp($user_id);
		

        //Get Package Info
        $pkg_q = $this->Packages_model->get_user_pkg_info($user_id);
        if (!empty($pkg_q->pkg_id)) {
            $data['join_package'] = $pkg_q->pkg_name;
            $data['join_id'] = $pkg_q->pkg_id;
            $data['exp_date'] = $pkg_q->end_date;
        } else {
            $data['join_package'] = 'Free';
            $data['join_id'] = 1;
        }
 
        $data['latest_order'] = 0; //$this->Dashboard_model->latest_order($user_id);
        $data['currency'] = $this->session->userdata("currency");
        $this->session->set_userdata("user_role", 'seller');
		
        $user_id = $this->session->userdata("user_id");
        $data['tot_order'] = $this->Dashboard_model->tot_order_supp($user_id);
        $data['tot_sale'] = $this->Dashboard_model->tot_sale_supp($user_id);
        $data['tot_customer'] = $this->Dashboard_model->tot_customer_supp($user_id);
        $data['monthly_orders'] = $this->Dashboard_model->supp_orders_monthly($user_id);

        $data['latest_order'] = 0; //$this->Dashboard_model->latest_order($user_id);
        $data['currency'] = $this->session->userdata("currency");

        $data['wallet'] = $this->Common_model->getAll("wallet_vendor", array("vendor_id" => $user_id))->row_array();
        $data["user_info"] = $this->Users_model->getUserById($user_id);
        $data["bank_details"] = $this->Users_model->getUserBankDetails($user_id);
        $data["seller_pickup_details"] = $this->Users_model->getSellerPickUpDetails($user_id);
        
        $this->load->view("user/dashboard_view", $data);
    }
    
    public function read_notification($id)
    {
        echo $this->Common_model->update('seller_notification',['status'=>'Read'],['status'=>'Received','id'=>$id]);
    }

    public function check() 
    {
        phpinfo();
    }
	
	public function updatetoken()
	{
		$token = $_POST['token'];
		$user_id=$this->session->userdata("user_id");
		$check = $this->Common_model->getAll("users_firebase_details",array("user_id"=>$user_id))->row_array();
		if(empty($check))
		{
                    $this->Common_model->insert("users_firebase_details",array("firebase_id"=>$token,"user_id"=>$user_id));
		}
		else
		{
                    $this->Common_model->update("users_firebase_details",array("firebase_id"=>$token),array("user_id"=>$user_id));
		}
	}
        
        
        function test()
        {
              //  $seller_id=$this->session->userdata("user_id");
                 //echo $this->notifyadmin($seller_id,"Test Notification","Test Message","New Order Placed");
            echo $this->send_android('Test','Notify','dzNx67Pipgs:APA91bFVAu1Eg3U3zZa_pcFdwQN8S7DjdWy0sQin8HSk8E4eoz80VDhF7Cxp9mfDGjhPjzVN1Wp6EZJve4vmtDK-u7ejG94_qG8exj0dVHpVmnhP_htrsxWgcNrzc6KIeozkyaahTHXq','type');
        }
    
    function notifyadmin($seller_id,$title, $message, $tag) 
    {
        
        $fb =$this->Common_model->getAll("users_firebase_details",array('user_id'=>$seller_id))->result_array();
    
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
        
        return $result;
        
    }
      
}
