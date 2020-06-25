<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Send_data 
{
	 private $CI;
	 function __construct()
		{
			$this->CI = get_instance(); 
			$this->CI->load->model('Common_model');
		}
		
	//Send OTP Function
	function send_sms($message,$mob)
	{  
			if($mob > 0)
			{
				$msg = urlencode($message);
				$ch=curl_init();
				curl_setopt($ch, CURLOPT_URL, "http://sms.smslab.in/api/sendhttp.php?authkey=271209AqkMbb4pSiXR5ca89dc7&mobiles=".$mob."&message=".$msg."&new&mobile&sender=ATZCRT&route=4");
				curl_setopt($ch, CURLOPT_HEADER, 0);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
				$res = curl_exec($ch);
				curl_close($ch);
				
			}
			
	}
        
        
        public function sendNormal_email($toemail,$sub,$msg) 
        {
            $from = $this->CI->config->item("default_email_from");
            $to = $toemail;
            $mesg = $msg;
            $this->CI->load->library('email');
            $config = array(
                'charset' => 'utf-8',
                'wordwrap' => TRUE,
                'mailtype' => 'html'
	);
	     $config['protocol'] = 'smtp';
             $config['smtp_host'] = 'smtp-relay.gmail.com';
             $config['smtp_user'] = 'support@atzcart.com';
             $config['smtp_pass'] = 'asdfghjklQWE123@';
             $config['smtp_port'] = 587;
             $config['smtp_crypto'] = 'tls';
             $this->CI->email->initialize($config);
             $this->CI->email->set_newline("\r\n");
 
            $this->CI->email->from($from, 'Atzcart');
            $this->CI->email->to($to);
            $this->CI->email->subject($sub);
            $this->CI->email->message($mesg);
            $this->CI->email->send();
            /*if ($this->CI->email->send()) {
                return true;
            } else {
                return false;
            }*/
        }
        
        public function send_emailWithTemplate($to,$sub,$temlate_link) 
        {
		    $from = $this->CI->config->item("default_email_from");
                    $mesg = $this->CI->load->view($temlate_link,"",true);
                    $this->CI->load->library('email');
                    $config = array(
                'charset' => 'utf-8',
                'wordwrap' => TRUE,
                'mailtype' => 'html'
        );
             $config['protocol'] = 'smtp';
             $config['smtp_host'] = 'smtp-relay.gmail.com';
             $config['smtp_user'] = 'support@atzcart.com';
             $config['smtp_pass'] = 'asdfghjklQWE123@';
             $config['smtp_port'] = 587;
                                 $config['smtp_crypto'] = 'tls';
             $this->CI->email->initialize($config);
             $this->CI->email->set_newline("\r\n");

            $this->CI->email->from($from, 'Atzcart');
            $this->CI->email->to($to);
            $this->CI->email->subject($sub);
            $this->CI->email->message($mesg);

                    if ($this->CI->email->send()) {
                            return true;
                    } else {
                            return $this->CI->email->print_debugger();
                    }
        }
        
        /* Ravindra Email Localhost */
        public function sendmailwithtemplate($to)
        {
            $config = array(
                            'protocol'  => 'smtp',
                            'smtp_host' => 'ssl://smtp.googlemail.com',
                            'smtp_port' => 465,
                            'smtp_user' => 'support@atzcart.com',
                            'smtp_pass' => 'asdfghjklQWE123@',
                            'mailtype'  => 'html',
                            'charset'   => 'utf-8',
                            'crlf' => "\r\n",
                            'newline' => "\r\n"
                            );
                        $this->CI->email->initialize($config);
                        $this->CI->email->set_mailtype("html");
                        $this->CI->email->set_newline("\r\n");
                        $this->CI->email->to($to);
                        $this->CI->email->from('support@atzcart.com','MyWebsite');
                        $this->CI->email->subject('How to send email via SMTP server in CodeIgniter');
                        $body = $this->CI->load->view('emailtemplates/welcome.php',$data,TRUE);
                        $this->CI->email->message($body);
                        $this->CI->email->send();
                        
        }
        
        
        function get_shipping_method()
        {
            $this->CI->db->select('id');
            $this->CI->db->from('shipping_vendor');
            $this->CI->db->where('is_default',1);
            $res=$this->CI->db->get()->row();
            return $res->id; 
        }
        
        function get_product_detail($product_id)
        {
            $this->CI->db->select('seller,weight,length,width,height');
            $this->CI->db->from('product_details');
            $this->CI->db->where('id',$product_id);
            return $this->CI->db->get()->row();
        }
}

?>
