<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Supplier_membership extends CI_Controller {

    public function __construct() {
        parent::__construct();
		  $this->load->model("Subscribers_model");
		  $this->load->model("Common_model");
		  $this->load->library("Send_data");

		  $this->load->library("get_header_data");

    }
	
	public function index()
	{
	    $data = $this->get_header_data->get_categories();
		$data["title"] = "ATZCart - Membership";
		
		$user_id = $this->session->userdata('user_id');
		if($user_id){
			$user= $this->Common_model->getAll('users',array('id'=>$this->session->userdata('user_id')))->row_array();
			$country_id=$user['country'];
			$currency_q=$this->Common_model->getAll('country',array('id'=>$country_id))->row_array();
			
			$currency=$currency_q['currency'];
			
			$packages = $this->Subscribers_model->get_subcription_packages();
			
			foreach($packages as $pkg)
			{
				
				$taxes=json_decode($pkg['taxes'],true);
				if(count($taxes) > 0)
				{
					//get taxes
					$this->db->select('*');
					$this->db->from('tax_class a');
					$this->db->join('users b','a.country_id=b.country');
					$this->db->where('b.id='.$user_id.'');
					$this->db->where('a.country_id='.$country_id.'');
					$this->db->where_in('a.tax_class_id',$taxes);
					$query=$this->db->get();
					$tax_data=$query->result_array();
					$tot_price=0;
					
						if(!empty($tax_data))
						{
							foreach($tax_data as $tax)
							{
								$from_currency='INR';
								$to_currency=$currency;
								$amount=$tax['tax_class_rate'];
								
								if($to_currency=='INR')
								{
									$tax_rate_country_wise=$amount;
								}
								else{
									$tax_rate_country_wise=$this->currencyConverter($from_currency,$to_currency,$amount);
								}
								
							$tot_price=($pkg['price']+($pkg['price']*($tax_rate_country_wise/100)));
							}
						}
						else{
							$tot_price=$pkg['price'];
						}
				}
				else{
					$tot_price=$pkg['price'];
				}
				$pass_data[]=array('pkg'=>$pkg,'price'=>number_format($tot_price,2));
			
				
			}
			$data['currency']=$currency;
			$data['packages']=$pass_data;

			$this->load->view('front/supplier_membership/packages',$data);
		}
		else
		{
			redirect('user');
		}
	}
	
	function currencyConverter($from_currency='INR', $to_currency, $amount) 
	{
		$amount = urlencode($amount);
		$from =urlencode($from_currency);
		$to = urlencode($to_currency);

		$url="https://apilayer.net/api/convert?access_key=5db0cfb7902c6c27d172cd9b36eb1de6&from=$from&to=$to&amount=$amount";
		$res = file_get_contents($url);
		$data1= json_decode($res,true);
		
		$var=$data1['result'];
		return round($var,3);
	}

	
	function sons2() 
    {
        $keyaccess = '1f10ab3315b24270cee15f90f588867c';
       // $remote_address = $_SERVER['REMOTE_ADDR'];
        $remote_address = '114.143.151.214';
       
        $curl = curl_init();
        // Set some options - we are passing in a useragent too here
        curl_setopt_array($curl, [
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL => 'http://api.ipstack.com/' . $remote_address . '?access_key=' . $keyaccess,
            CURLOPT_USERAGENT => 'Codular Sample cURL Request'
        ]);

        $resp = curl_exec($curl);
        curl_close($curl);
        $region = json_decode($resp, true);
        echo'<pre>';
        print_r($region);
    }
	
	
	
	function add()
	{
		$country=$this->Common_model->getAll('country')->result_array();
		echo'<pre>';
		foreach($country as $c)
		{
			$getc=$this->Common_model->getAll('currency',array('country'=>strtolower(ucfirst($c['name']))))->row_array();
			if($getc)
			{
				$this->Common_model->update('country',array('currency'=>$getc['code']),array('name'=>strtolower(ucfirst($c['name']))));
			}
		}
	}
	
	function get_package()
	{
		$pkg=$this->input->post('pkg');
		
		if(!empty($pkg))
		{
			$pkg_q=$this->Common_model->getAll('subscription_package',array('sub_id'=>$pkg))->row_array();
			if($pkg_q)
			{
				$pkg_name=$pkg_q['pkg_name'];
				
				if($pkg_q['duration'] == "Month"){
					$price=round($pkg_q['price'],2);
					}
					else{
						$price= round($pkg_q['price']/12,2);
				}
													
				$str=$pkg.'||'.$pkg_name.'||'.$price;
			}
			echo $str;
		}
		else{
		echo'error';
		}
	}
	
	function calculate_pkg_price()
	{
		 $pkg_id=$this->input->post('pkg_id');
		 $duration=$this->input->post('duration');
		
		if(!empty($pkg_id))
		{
			$pkg_q=$this->Common_model->getAll('subscription_package',array('sub_id'=>$pkg_id))->row_array();
			if($pkg_q)
			{
				
				if($pkg_q['duration'] == "Month"){
					$price=($pkg_q['price']);
					}
					else{
						$price=($pkg_q['price']/12);
				}
				
				echo $tot_price=$duration*$price;
													
				
			}
			else{
				echo $tot_price=0;
			}
			
		}
		else{
		//echo'error';
		}
	}
	
	
	function proceed_package()
	{
		$user_id = $this->session->userdata('user_id');
		$get_user=$this->Common_model->getAll('users',array('id'=>$user_id))->row_array();
		if($get_user)
		{
			$pkg_id=$this->input->post('spkg_id');
			$duration=$this->input->post('pkg_duration');
			$pkg_q=$this->Common_model->getAll('subscription_package',array('sub_id'=>$pkg_id));
		
			if($pkg_q->num_rows() > 0)
			{
				
				$pkg_q=$pkg_q->row_array();
				if($pkg_q['duration'] == "Month"){
						$price=($pkg_q['price']);
						}
						else{
							$price=($pkg_q['price']/12);
					}
					$tot_price=$price*$duration;
					
					
					$passdata['pkg_id'] =$pkg_id;
					$passdata['pkg_name'] =$pkg_q['pkg_name'];
					$passdata['duration'] =$duration;
					$passdata['productinfo'] ='Membership Package';
					
					$passdata['productinfo'] ='Membership Package';
					$passdata['txnid'] = time();
					$passdata['surl'] = site_url().'supplier_membership/success';
					$passdata['furl'] = site_url().'supplier_membership/failed';;    
					$passdata['key_id'] = RAZOR_KEY_ID;
					$passdata['currency_code'] = 'INR';            
					$passdata['total'] =$tot_price*100; 
					$passdata['amount'] =$tot_price;
					$passdata['merchant_pkg_id'] = $pkg_id;
					$passdata['card_holder_name'] = $get_user['first_name'].' '.$get_user['last_name'];
					$passdata['email'] =$this->session->userdata('user_email');
					$passdata['phone'] =$this->session->userdata('phone');
					$passdata['name'] = 'ATZ Cart Membership';
					$passdata['return_url'] = site_url().'supplier_membership/callback';
					
					$this->session->set_userdata($passdata);
					
					$this->load->view('front/supplier_membership/package_proceed',$passdata);
			}
			else{
				redirect('supplier_membership');
			}
		}
		else{
			redirect('');
		}
	}
	
	public function callback() {  
			
        if (!empty($this->input->post('razorpay_payment_id')) && !empty($this->input->post('merchant_pkg_id'))) {
			
             $razorpay_payment_id = $this->input->post('razorpay_payment_id');
           
			 $pkg_id = $this->input->post('merchant_pkg_id');
			 $user_id = $this->session->userdata('user_id');
			///////////////////////////////Payment Verify Start////////////////////
				$key_id = RAZOR_KEY_ID;
				$key_secret = RAZOR_KEY_SECRET;
				
				$url = 'https://api.razorpay.com/v1/payments/'.$razorpay_payment_id;
				$ch = curl_init();
				curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				curl_setopt($ch, CURLOPT_URL,$url);
				curl_setopt($ch, CURLOPT_USERPWD, $key_id . ":" . $key_secret);
				$result=curl_exec($ch);
				curl_close($ch);
				if($result){

					$resp = json_decode($result);
					//Response
					foreach ($resp as $value) 
					$array[] = $value;
					
					$pkg_id=$this->session->userdata('pkg_id');
					$duration=$this->session->userdata('duration');
					$pkg_q=$this->Common_model->getAll('subscription_package',array('sub_id'=>$pkg_id))->row_array();
					$pkg_name=$pkg_q['pkg_name'];
					if($pkg_q['duration'] == "Month"){
						$price=($pkg_q['price']);
						}
						else{
							$price=($pkg_q['price']/12);
					}
					 $tot_price=round($price*$duration,2);
					
					 $amt_to_pay=($array[2]/100); //From User
					
					
					if((trim($array[4])=='authorized') && (trim($tot_price)==trim($amt_to_pay)))
					{
						
							$days_added='+ '.$duration.' days';
							$curr_date=date('Y-m-d H:i:s');
							$end_date=date('Y-m-d H:i:s', strtotime($curr_date. $days_added));
							$up['status']='Inactive';
							$this->Common_model->update('user_packages',$up,array('user_id'=>$user_id));
							//Add Free (Package ID 1) Package to Register User
							$insertPkg['pkg_id']=$pkg_id;
							$insertPkg['user_id']=$user_id;
							$insertPkg['duration']=$duration;
							$insertPkg['start_date']=date('Y-m-d H:i:s');
							$insertPkg['end_date']=$end_date;
							$insertPkg['status']='Active';
							$this->Common_model->insert('user_packages',$insertPkg);
							
							//Send SMS 
							$message='Successfully Upgrade Membership Plan';
							$mob=$this->session->userdata('phone');
							$this->send_data->send_sms($message,$mob);
							
							$this->session->unset_userdata('pkg_id');
							
							
							$msg='<i class="fa fa-check-circle" aria-hidden="true"></i><div align="center" style="color: green;">
								   <div id="login-error" class="form-error notice notice-success">
									 
									  <span>Successfully Upgrade Membership Plan '.$pkg_name.' !</span>
								   </div>
								</div>';
							$this->session->set_flashdata('message',$msg);
							
						
					}
					else{
						$msg='<i class="fa fa-exclamation-triangle" aria-hidden="true"></i><div align="center" style="color: red;">
								   <div id="login-error" class="form-error notice notice-error">
									  <span class="icon-notice icon-error"></span>
									  <span>Error ! Payment Failed !</span>
								   </div>
								</div>';
						$this->session->set_flashdata('message',$msg);
						
					}
					
					//Insert Payment Transaction
					$payData['payment_id']=$array[0];//Tras Id
					$payData['user_id']=$user_id;
					$payData['email']=$array[17];
					$payData['contact']=$array[18];
					$payData['pkg_id']=$pkg_id;
					$payData['amount']=($array[2]/100);
					$payData['currency']=$array[3];
					$payData['status']=$array[4];
					$payData['method']=$array[8];
					$payData['platform']='Web';
					$payData['description']=$array[12];
					$payData['created_at']=$array[24]; 
					$up=$this->Common_model->insert('package_payment',$payData);
					
					//Redirct to Page
					redirect(base_url()."userorder/atz_messgae");
					
				}
				else{
					$msg='<i class="fa fa-exclamation-triangle" aria-hidden="true"></i><div align="center" style="color: red;">
								   <div id="login-error" class="form-error notice notice-error">
									  <span class="icon-notice icon-error"></span>
									  <span>Error ! No Valid  Failed!</span>
								   </div>
								</div>';
					
					$this->session->set_flashdata('message',$msg);
					redirect(base_url()."userorder/atz_messgae");
				}
        } else {
			$msg='<i class="fa fa-exclamation-triangle" aria-hidden="true"></i><div align="center" style="color: red;">
								   <div id="login-error" class="form-error notice notice-error">
									  <span class="icon-notice icon-error"></span>
									  <span>Error ! An error occured. Contact site administrator, please!</span>
								   </div>
								</div>';
					
					$this->session->set_flashdata('message',$msg);
					redirect(base_url()."userorder/atz_messgae");
            
        }
    }
	
	
}