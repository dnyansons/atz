<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Notifications extends CI_Controller
{
//	function __construct()
//	{
//		parent::__construct();
//        if (isset($_SESSION) && $this->session->userdata("user_role") != "" && $this->session->userdata("user_row_id") != "") {
//            
//        } else {
//            $this->session->set_flashdata("message", "Invalid Access");
//            redirect("welcome");
//        }
//	}
	
	public function load_views($view_name, $data = "") 
    {
        $header_arr = array();
        $notification_list = $this->Mdgeneraldml->select('*', 'admin_notifications', '', array(1 => array('colname' => 'id', 'type' => 'DESC')), 5);
        $received_count = $this->Mdgeneraldml->select('count(id)', 'admin_notifications', ['status' => 'Received']);
        $count = $received_count[0]['count(id)'];
        //echo $count;
        //exit;
        $notification_list[0]['received_count'] = $count;

        $header_arr['notification_list'] = $notification_list;
        $this->load->view('admin/common_files/header');
        $this->load->view('admin/common_files/sidebar');
        $this->load->view($view_name, $data);
        $this->load->view('admin/common_files/footer');
    }
	
	public function index()
	{
		$this->load->library("form_validation");
		$this->form_validation->set_rules("title","Title","required");
		$this->form_validation->set_rules("message","Message","required");
		$this->form_validation->set_rules("device","Device","required");
		$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
		if($this->form_validation->run()===false){
			$this->load_views("admin/notification/send_multiple");
		} else {
			$title = $this->input->post("title");
			$message = $this->input->post("message");
			$device = $this->input->post("device");
			if($device == "Ios"){
				$this->db->where("device_os = 'ios' and firebaseid !=''");
				$this->db->where("id < 5");
				$this->db->select("firebaseid");
				$query = $this->db->get("users");
				$firebaseIds = $query->result();
				$ids =array();
				foreach($firebaseIds as $key)
				{
					$ids[] = $key->firebaseid;
				}
				$this->send_ios($title,$message,$ids);
			}
			
			
			
			if($device == "Android") {
				$this->db->where("device_os != 'ios' and firebaseid !='' ");
				$this->db->where("id < 5");
				$this->db->select("firebaseid");
				$query = $this->db->get("users");
				$firebaseIds = $query->result();
				$ids2 =array();
				foreach($firebaseIds as $key)
				{
					$ids2[] = $key->firebaseid;
				}
				$this->send_android($title,$message,$ids2);
			}
			
			
			$msg = "<div class='alert alert-success'>
					<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>
					<strong>Well done!</strong> Notification send successfully! 
				</div>";
			$this->session->set_flashdata("message",$msg);
			redirect(site_url().'Notifications');
		}
	}
	
	function send_android($title,$message,$firebaseid)
	{
            
            $title = 'Testing Title';
            $message = 'Testing Message';
            $firebaseid = ["ccxe4PGXBiI:APA91bHBv0WEqGoeygnmSWAoh68g3GpyFkaPB3UkIcz-qr3n6YaU8zCtY3vGI8Q-qmKXTBmYShoWoUD8v-mNtxMaizYJWdA6Dn4015M5q0_enHtGc0WSK1qbhHMtskgY8jmSRfbyLUI2"];
            
		//SERVER KEY TOOK FROM FIREBASE CONSOLE
		$server_key = "AAAAQZPhbOI:APA91bE66fLevVa21qhnG0Wg6pAcUtDCk4CnUDxTDMHCwdDnn1WoHHnkn7oxPOjfG8yZb8H08VwbM6X6VWZoJ7JrP4kZki-Ke8Z5ZipqEhFwq8YviFuOrycxNERMdpNlUOE4NaV4i_j1";
		//FIREBASE URL
		$url = "https://fcm.googleapis.com/fcm/send";
		//DEVICE ID
		
		$headers = array('Content-Type: application/json','Authorization: key='.$server_key);
		$fields = array('registration_ids' =>$firebaseid,'data' => array('title'=>$title,"body"=>$message));
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
                //echo "<pre>";
                //print_r($result);
                //exit;
                if ($result === FALSE){ die('Curl failed: ' . curl_error($ch)); }
                // Close connection
                curl_close($ch);
                        //print_r($result);
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
	
	public function topicnotification()
	{
		$this->load->library("form_validation");
		$this->form_validation->set_rules("topic","Topic","required");
		$this->form_validation->set_rules("title","Title","required");
		$this->form_validation->set_rules("message","Message","required");
		if($this->form_validation->run()===false){
			$this->load_views("admin/notification/send_topic");
		} else {
			
			$topic = $this->input->post("topic");
			$title = $this->input->post("title");
			$message = $this->input->post("message");
			$server_key = 'AAAAL7El5pg:APA91bHZlGImKkEEs-eC8BsfEP7AHc9SWm1PfYcWkFBTDNFXKpN0pmvp9mqlRtpnnmyGfeBS08IO0jvtRlx-2ljGlUW8G20nsMM0H06m_ELx6nCQuXpLSLJI9wOaaz8-1KSHLLQjkdcg';
		
			$url = 'https://fcm.googleapis.com/fcm/send';
			
			$fields['to'] = '/topics/'.$topic;
			$fields['notification'] = array('title' =>$title , 'text' => $message);
			$headers = array(
			'Content-Type:application/json',
			  'Authorization:key='.$server_key
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
			
			$messaged = "<div class='alert alert-success alert-dismissible'>
						  <button type='button' class='close' data-dismiss='alert'>&times;</button>
						  <strong>Success!</strong> ".$result.".
						</div>";
			
			$this->session->set_flashdata("message2",$messaged);
			redirect("Notifications/topicnotification","refresh");
		}
	}
}