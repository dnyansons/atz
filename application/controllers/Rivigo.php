<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Rivigo extends CI_Controller 
{
    public function __construct()
    {
        parent::__construct();
    }
    public function index()
    {
        echo json_encode(["status"=>1,"message"=>"success"]);
    }
    
    public function test()
    {
        echo "testtest";
    }
}
