<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Geolocations extends REST_Controller
{
    public function __construct($config = 'rest') 
    {
        parent::__construct($config);
        $this->load->library('form_validation');
        $this->load->model('Common_model');
    }
    
    public function countries_get()
    {
        $output = [
            "status" => 1,
            "message" => "List of countries",
            "ws" => countries
        ];

        $this->db->select("*,CONCAT('https://www.atzcart.com/assets/images/flags/png/',LOWER(iso),'.png') as country_flag");
        $countries = $this->Common_model->getAll("country")->result();
        
        $output["items"] = $countries;
        $this->response($output, REST_Controller::HTTP_OK);
    }
}
