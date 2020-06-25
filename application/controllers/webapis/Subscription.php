<?php

class Subscription extends REST_Controller {

    public function __construct($config = 'rest') {
        header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
        parent::__construct($config);
        $this->load->model("Subscribers_model");
        $this->load->library("form_validation");
    }

    public function index_post() 
    {
        $output = [
            "success" => 0,
            "message" => "Invalid Inputs"
        ];
        $this->form_validation->set_rules("email", "Email", "required|valid_email|is_unique[mail_subscriptions.email]", array(
            'required' => 'Invalid input',
            'valid_email' => 'Invalid input',
            'is_unique' => 'Already subscribed.',
                )
        );
        if ($this->form_validation->run() === false) {
            $output["message"] = $this->validation_errors();
            $this->response($output, HTTP_OK);
        } else {
            $insertData = [
                "email" => $this->post("email")
            ];
            $this->Subscribers_model->addNew($insertData);
            $output["message"] = "You have been successfully subscribed to atzcard newsletters mailing list.";
            $output["success"] = 1;
            $this->response($output, HTTP_OK);
        }
    }

    public function test_get() 
    {
        $this->load->view("emailtemplates/subscribed");
    }

}
