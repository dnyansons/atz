<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Common_email {

    private $CI;

    public function __construct() {
        $this->CI = &get_instance();
        $this->CI->load->database();
        $this->CI->load->library('email');
    }

    /**
     * @auther Yogesh Pardeshi 20092018 2.30pm
     * @param array of values e.g. 
     * $emailData = array('from' => 'fromemailaddress', 
            'to' => 'toemailaddress', 
            'emailViewOrMsg' => 'load view to pass in a message, or plain text',
            'emailViewValues' => view values as assoc array or null
            'subject' => 'subject line');
     * @return true on success; false on failure
     * @use sending stock reminder to buyer, seller
     **/
    public function send_custom_email($emailData) {
        if(!is_array($emailData)){
            return 'Accepts only array as value';   
        }
        if(empty($emailData)){
            return 'Empty email details';
        }
        if(!array_key_exists('from', $emailData)){
            return 'Missing sender email';
        }
        if(!array_key_exists('to', $emailData)){
            return 'Missing receipent email';
        }
        if(!array_key_exists('subject', $emailData)){
            return 'Missing subject of an email';
        }
        
        $config['protocol'] = 'smtp';
        $config['smtp_host'] = 'smtp-relay.gmail.com';
        $config['smtp_user'] = 'support@atzcart.com';
        $config['smtp_pass'] = 'asdfghjklQWE123@';
        $config['smtp_port'] = 587;
        $config['smtp_crypto'] = 'tls';
        $this->CI->email->initialize($config);
        $this->CI->email->from($emailData['from'], 'Atzcart');
        $this->CI->email->to($emailData['to']);
        $this->CI->email->subject($emailData['subject']);
        
        if(in_array('emailViewValues', $emailData)){
            if(is_array($emailData['emailViewValues'])){
                $data = $emailData['emailViewValues'];
                $emailMessage = $this->load->view($emailData['emailViewOrMsg'], $data, true);
                $this->CI->email->message($emailMessage);
            } else {
                return 'Invalid load view to send in a message';
            }
        } else {
            $this->CI->email->message($emailData['emailViewOrMsg']);
        }
        
        $emailSent = false;
        try {
            return $emailSent = $this->CI->email->send();
        } catch (Exception $ex) {
            //echo $ex->getMessage();
            return false;
        }
    }

}
