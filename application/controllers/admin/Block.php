<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Block extends CI_Controller 
{
    

    public function index() 
    {
        $data['heading']='Not Permission';
		$data['message']='You Have Not Permission To access this Page | Contact to Administrator ';
		$this->load->view('block',$data);
    }

	
}

?>
