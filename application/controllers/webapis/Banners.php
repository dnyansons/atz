<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Banners extends REST_Controller {

    public function __construct($config = 'rest') 
    {
        parent::__construct($config);
        $this->load->model("Banners_model");
    }

    public function web_get() 
    {
        $output = array(
            "status" => 0,
            "message" => "Fetching list of items"
        );
        $output["items"] = $this->Banners_model->get_active_banners();
        $this->response($output, REST_Controller::HTTP_OK);
    }

    public function mobile_get() 
    {
        $output = array(
            "status" => 1,
            "message" => "Fetching list of items"
        );
        $output["items"] = $this->Banners_model->get_active_banners_for_mobile();
        $this->response($output, REST_Controller::HTTP_OK);
    }


    public function mobilebottom_get() 
    {
        $output = array(
            "status" => 1,
            "message" => "Fetching list of items"
        );
        $output["items"] = $this->Banners_model->get_active_banners_for_mobilebottom();
        $this->response($output, REST_Controller::HTTP_OK);
    }

}
