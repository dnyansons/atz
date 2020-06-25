<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Razorpay extends CI_Controller {
    // construct
    public function __construct() {
        parent::__construct();   
       $this->load->model('Order_model');     
    }
    // index page
    public function index() {
        $data['title'] = 'Razorpay | TechArise';  
        //$data['productInfo'] = $this->site->getProduct();           
        $this->load->view('razorpay/index', $data);
    }
    
    // checkout page
    public function checkout($id=1) {
        $data['title'] = 'Checkout payment | TechArise';  
       // $this->site->setProductID($id);
        $data['itemInfo'] ='Desc'; 
        $data['return_url'] = site_url().'razorpay/callback';
        $data['surl'] = site_url().'razorpay/success';;
        $data['furl'] = site_url().'razorpay/failed';;
        $data['currency_code'] = 'INR';
        $this->load->view('razorpay/checkout', $data);
    }

    // initialized cURL Request
    private function get_curl_handle($payment_id, $amount)  {
        $url = 'https://api.razorpay.com/v1/payments/'.$payment_id.'/capture';
        $key_id = RAZOR_KEY_ID;
        $key_secret = RAZOR_KEY_SECRET;
        $fields_string = "amount=$amount";
        //cURL Request
        $ch = curl_init();
        //set the url, number of POST vars, POST data
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_USERPWD, $key_id.':'.$key_secret);
        curl_setopt($ch, CURLOPT_TIMEOUT, 60);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
        curl_setopt($ch, CURLOPT_CAINFO, dirname(__FILE__).'/ca-bundle.crt');
        return $ch;
    }   
        
    // callback method
   /* public function callback() {  
			
        if (!empty($this->input->post('razorpay_payment_id')) && !empty($this->input->post('merchant_order_id'))) {
			
			
            echo $razorpay_payment_id = $this->input->post('razorpay_payment_id');
            echo'<br>';
			echo $merchant_order_id = $this->input->post('merchant_order_id');
			exit;
            $currency_code = 'INR';
            $amount = $this->input->post('merchant_total');
            //$success = false;
            $error = '';
            try {                
                $ch = $this->get_curl_handle($razorpay_payment_id, $amount);
                //execute post
                $result = curl_exec($ch);
                $http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                if ($result === false) {
                    $success = false;
                    $error = 'Curl error: '.curl_error($ch);
                } else {
                    $response_array = json_decode($result, true);
                    echo "<pre>";print_r($response_array);exit;
                        //Check success response
                        if ($http_status === 200 and isset($response_array['error']) === false) {
                            $success = true;
                        } else {
                            $success = false;
                            if (!empty($response_array['error']['code'])) {
                                $error = $response_array['error']['code'].':'.$response_array['error']['description'];
                            } else {
                                $error = 'RAZORPAY_ERROR:Invalid Response <br/>'.$result;
                            }
                        }
                }
                //close connection
                curl_close($ch);
            } catch (Exception $e) {
                $success = false;
                $error = 'OPENCART_ERROR:Request to Razorpay Failed';
            }
            if ($success === true) {
                if(!empty($this->session->userdata('ci_subscription_keys'))) {
                    $this->session->unset_userdata('ci_subscription_keys');
                 }
                if (!$order_info['order_status_id']) {
                    redirect($this->input->post('merchant_surl_id'));
                } else {
                    redirect($this->input->post('merchant_surl_id'));
                }

            } else {
                redirect($this->input->post('merchant_furl_id'));
            }
        } else {
            echo 'An error occured. Contact site administrator, please!';
        }
    }*/

	public function callback() {  
			
        if (!empty($this->input->post('razorpay_payment_id')) && !empty($this->input->post('merchant_order_id'))) {
			
			
             $razorpay_payment_id = $this->input->post('razorpay_payment_id');
           
			 $orders_id = $this->input->post('merchant_order_id');
			
			///////////////////////////////Payment Verify Start////////////////////
				$key_id = "rzp_test_QERx8gpLbfnHUB";
				$key_secret = "SeR7TzYwVmCWplEaygwb9Hfd";
				
				$url = 'https://api.razorpay.com/v1/payments/'.$trans_id;
				$ch = curl_init();
				curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				curl_setopt($ch, CURLOPT_URL,$url);
				curl_setopt($ch, CURLOPT_USERPWD, $key_id . ":" . $key_secret);
				$result=curl_exec($ch);
				curl_close($ch);
				if($result){
					//Order Detail
					$orderDetail=$this->Order_model->getBuyersOrderbyOrderID($orders_id);
					
					$resp = json_decode($result);
					//Response
					foreach ($resp as $value) 
					$array[] = $value;
					
					
					
					 $pay_amount=$orderDetail['grand_price']; //From Database
					
					 $amt_to_pay=($array[2]/100); //From User
					
					
					
					if((trim($array[4])=='authorized') && (trim($pay_amount)==trim($amt_to_pay)))
					{
						
						$updata['orders_status']=10;
						
						$up=$this->Common_model->update('orders',$updata,array('orders_id'=>$orders_id,'orders_status'=>16));
						
						if($up)
						{
							$output["data"] =$this->Order_model->getBuyersOrderbyOrderID($orders_id);
							$output["status"] = 1;
							$output["message"] = "Order Place Successfully !";
							
							//Order History
							$orderHistory['orders_id']=$orders_id;
							$orderHistory['status']=10;
							$orderHistory['date_added']=date('Y-m-d H:i:s');
							$orderHistory['comment']='Order in Processing !';
							
							$this->Common_model->insert('orders_history',$orderHistory);
						}
						else{
							
							$output["status"] = 0;
							$output["message"] = "Order Not Found !";
						}
					}
					else{
						
						$output["status"] = 0;
						$output["message"] = "Payment Failed !";
					}
					//Insert Payment Transaction
					$payData['payment_id']=$array[0];//Tras Id
					$payData['user_id']=$userid;
					$payData['orders_id']=$orders_id;
					$payData['amount']=($array[2]/100);
					$payData['currency']=$array[3];
					$payData['status']=$array[4];
					$payData['method']=$array[8];
					$payData['description']=$array[12];
					$payData['created_at']=$array[24];
					$up=$this->Common_model->insert('order_payment',$payData);
					
					
					
				}
				else{
					
					$output["status"] = 0;
					$output["message"] = "Order Failed !";
				}
        } else {
            echo 'An error occured. Contact site administrator, please!';
        }
    } 
    public function success() {
        $data['title'] = 'Razorpay Success | TechArise';  
        $this->load->view('razorpay/success', $data);
    }  
    public function failed() {
        $data['title'] = 'Razorpay Failed | TechArise';            
        $this->load->view('razorpay/failed', $data);
    } 
}
?>