<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * This is a public API file does not need to be token verified
 *
 */
class Common extends REST_Controller 
{

    public function __construct($config = 'rest') 
    {
        parent::__construct($config);
        $this->load->model("Products_model");
        $this->load->model("Categories_model");
        $this->load->model('Company_model');
        $this->load->model('Sourcing_reason_model');
        $this->load->library("form_validation");
        $this->load->model('Common_model');
        $this->load->model('App_model');
        $this->load->model('Units_model');
        $this->load->model("Apks_model");
		$this->load->model("HelpCenter_model");
    }


    public function getReasonsForSourcing_get()
    {
       
        $ws=$this->get('ws');

        if(empty($ws))
        {
           $ws="getReasonsForSourcing";
        }

        $output = [
            "ws" => $ws,
            "status" => 0,
            "message" => "Unable to get data"
        ];
        
        $output['status']=1;
        $output['message']="reasons for sourcing fetch successfully";
        $output['sourcing_reason']=$this->Sourcing_reason_model->get_all();
        $this->response($output,HTTP_OK);
    }

    
    

    public function checkAppUpdates_post()
    {
         $ws_temp = $this->post("ws");
         $ws = "checkAppUpdates";
         if(isset($ws_temp)){
         $ws = $ws_temp;
         }

         $output = [
         "status" => 0,
         "message" => "Invalid inputs",
         "ws" => $ws
         ];
         
         $this->form_validation->set_rules("version","version","required");

          if($this->form_validation->run() == false)
          {
            $this->response($output, REST_Controller::HTTP_OK);
          }

          else
          {
            $posted_version = $this->post('version');  
            $app_info_data = $this->App_model->getAllData(1);
            $latest_version=$app_info_data->latest_version;
            $previous_latest_version=$app_info_data->previous_latest_version;
            $latest_version_whats_new=$app_info_data->latest_version_whats_new;


            if($posted_version==$latest_version)
            {
                $output["status"] = 1;
                $output["message"] = "This is the latest version.";
                $output["available_update"] ="NO_UPDATE";
                $this->response($output, REST_Controller::HTTP_OK);
            }


            else if($posted_version==$previous_latest_version)
            {
                $output["status"] = 1;
                $output["message"] = "New app version available";
                $output["available_update"] ="NORMAL_UPDATE";
                $output["whats_new"] =$latest_version_whats_new;
                $this->response($output, REST_Controller::HTTP_OK);
            }


            else if($posted_version<$latest_version && $posted_version<$previous_latest_version)
            {
                $output["status"] = 1;
                $output["message"] = "New app version available";
                $output["available_update"] ="FORCE_UPDATE";
                $output["whats_new"] =$latest_version_whats_new;
                $this->response($output, REST_Controller::HTTP_OK);
            }


            else
            {
                
                $output = [
                            "status" => 0,
                            "message" => "something went wrong",
                            "ws" => $ws
                          ];
                $this->response($output, REST_Controller::HTTP_OK);
            }
        }
    }


    public function getUnits_get()
    {
        $ws=$this->get('ws');

        if(empty($ws))
        {
           $ws="getUnits";
        }

        $output = [
            "ws" => $ws,
            "status" => 0,
            "message" => "Unable to get data"
        ];
        
        $output['status']=1;
        $output['message']="Units data fetch successfully";
        $output['units']=$this->Units_model->getAll();
        $this->response($output,HTTP_OK);
    }


    public function getTermsOfLicenseAndUse_get()
    {
        $ws=$this->get('ws');

        if(empty($ws))
        {
           $ws="getTermsOfLicenseAndUse";
        }

        $output = [
            "ws" => $ws,
            "status" => 0,
            "message" => "Unable to get data"
        ];
        
        $output['status']=1;
        $output['message']="Terms Of License And Use data fetch successfully";
        $output['data']=$this->Common_model->getAllDataByWhere(['terms_of_use_data'],'terms_of_use', ['terms_id'=>1]);
        $this->response($output,HTTP_OK);
    }

    public function updatedfeatures_post()
    {
        $output = [
            "status" => 0,
            "message" => "Invalid inputs",
            "ws" => "updatedfeatures",
            "data" => ""
        ];
       
        $this->form_validation->set_rules("platform","platform","required");
        $this->form_validation->set_rules("versionCode","version","required");
        if($this->form_validation->run()===false){
            $this->response($output, REST_Controller::HTTP_OK);
        } else {
             $platform = $this->post("platform");
             $version = $this->post("versionCode");
            $data = $this->Apks_model->getCurrentFeaturesByPlatform($this->input->post("platform"));
            if($data->version != $version){
                $output["status"] = 1;
                $output["message"] = "Get app updates featues";
                $output["data"] = $data->features; 
                $this->response($output, REST_Controller::HTTP_OK);
            } else {
                $output["status"] = 0;
                $output["message"] = "Current app is up to date";
                $this->response($output, REST_Controller::HTTP_OK);
            }
        }
    }
	
	public function parentTitlesOfHelpCenter_get()
	{
		$ws=$this->get('ws');
        if(empty($ws))
        {
           $ws="parentTitlesOfHelpCenter";
        }

        $output = [
            "ws" => $ws,
            "status" => 0,
            "message" => "Unable to get data"
        ];
		
        $output['status']=1;
        $output['message']="HelpCenter Buyers Parent Title fetched successfully";
        $output['data']=$this->HelpCenter_model->getAllTitles();
        $this->response($output,HTTP_OK);
	}
	
	public function subTitlesOfHelpCenter_post()
	{
		
		$ws=$this->get('ws');
        if(empty($ws))
        {
           $ws="subTitlesOfHelpCenter_get";
        }

        $output = [
            "ws" => $ws,
            "status" => 0,
            "message" => "Unable to get data"
        ];
        $id = $this->post('id');
        $output['status']=1;
        $output['message']="HelpCenter Buyers Sub Title fetched successfully";
        $output['data']=$this->HelpCenter_model->getAllsubTitles($id);
        $this->response($output,HTTP_OK);
	}
	
	public function HelpCenterTitleDescription_post()
	{
		
		$ws=$this->get('ws');
        if(empty($ws))
        {
           $ws="HelpCenterTitleDescription_get";
        }

        $output = [
            "ws" => $ws,
            "status" => 0,
            "message" => "Unable to get data"
        ];
		
        $id = $this->post('id');
        $output['status']=1;
        $output['message']="HelpCenter Buyers Title Description fetched successfully";
        $output['data']=$this->HelpCenter_model->getdescription($id);
        $this->response($output,HTTP_OK);
	}
  

}