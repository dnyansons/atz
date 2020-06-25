<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Currency extends CI_Controller 
{
    public function __construct() 
    {
        parent::__construct();
        if (!$this->session->userdata("admin_logged_in")) {
            $error = "<div class='alert alert-danger alert-dismissible'>
                        <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                        <strong>Error!</strong> Session timeout, relogin!.
                      </div>";
            $this->session->set_flashdata("message", $error);
            redirect("admin/login", "refresh");
        }
        $this->load->library("Datatables");
        $this->load->library('table');
        $this->load->model('Currency_model');
        $this->load->model('Common_model');
        $this->load->model('adminusers_model', 'adminusers_model');
		 $this->load->library('Userpermission');
    }

    public function index() 
    {
        $this->load->view("admin/currency/list");
    }

    public function ajax_list() 
    {
        $columns = array(
            0 => 'curr_id',
            1 => 'currency_from',
            2 => 'currency_to',
            3 => 'charges',
            4 => 'updated_at',
        );

        $limit = $this->input->post('length');
        $start = $this->input->post('start');
        $order = $columns[$this->input->post('order')[0]['column']];
        //$dir = $this->input->post('order')[0]['dir'];
        $dir ="desc";

        $totalData = $this->Currency_model->allcurr_count();

        $totalFiltered = $totalData;

        if (empty($this->input->post('search')['value'])) {
            $curr = $this->Currency_model->allbrand($limit, $start, $order, $dir);
        } else {
            $search = $this->input->post('search')['value'];

            $curr = $this->Currency_model->curr_search($limit, $start, $search, $order, $dir);

            $totalFiltered = $this->Currency_model->curr_search_count($search);
        }

        $data = array();
        if (!empty($curr)) {
            foreach ($curr as $br) {
                $nestedData['curr_id'] = $br->curr_id;
                $nestedData['currency_from'] = $br->currency_from;
                $nestedData['currency_to'] = $br->currency_to;
                $nestedData['charges'] = $br->charges;
                $nestedData['updated_at'] = $br->updated_at;
                
                $nestedData['action'] = '<a href="'.base_url().'admin/currency/updatecurr/'.$br->curr_id.'" class="tabledit-edit-button btn btn-primary waves-effect waves-light btn-sm" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit"><i class="fa fa-pencil-square-o fa-2x"></i></a>
                                                                <a  onclick="return confirm(&#39;Are you sure want to Delete Curr Charges ?&#39;)" href="'.base_url().'admin/currency/deletecurr/'.$br->curr_id.'" class="tabledit-delete-button btn btn-danger waves-effect waves-light btn-sm" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete"><i class="fa fa-trash fa-2x"></i></a>';

                $data[] = $nestedData;
            }
        }

        $json_data = array(
            "draw" => intval($this->input->post('draw')),
            "recordsTotal" => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data" => $data
        );

        echo json_encode($json_data);
    }


     public function addcurr() // add addcurr
    {
        
        
        if($_SERVER['REQUEST_METHOD']=="POST")
        {
			        
		    $data=$this->input->post();
            $data['updated_at']=date('Y-m-d H:i:s');
          
           
            $ch=$this->db->query("SELECT `curr_id` FROM currency_conver_charges WHERE `currency_from`='".$this->input->post('currency_from')."' AND `currency_to`='".$this->input->post('currency_to')."'")->num_rows();
			if($ch==0 && $this->input->post('currency_from')!=$this->input->post('currency_to'))
			{
				$result=$this->Common_model->insert('currency_conver_charges',$data);
			}

          
			if($result)
            {
				$msg='Insert Successfully !';
				$this->session->set_flashdata('message',$msg);
                redirect(base_url()."admin/currency");
            }
			else{
				$msg='Something Wrong !';
				$this->session->set_flashdata('message',$msg);
                redirect(base_url()."admin/currency");
			}
            
        }

        else
        {
            $data['title']="Add Currency Charges";
            $admin_username=$this->session->userdata('admin_username');
            $data['admin_data']=$this->adminusers_model->getUserByUsername($admin_username);
			$data['curr'] = $this->Common_model->getAll("currency")->result_array();
            $this->load->view('admin/common/header', $data);
            $this->load->view('admin/currency/create',$data);
            $this->load->view('admin/common/footer');
        }


    }

    

     public function updatecurr($curr_id) // update updateCoupon
    {
        

        if($_SERVER['REQUEST_METHOD']=="POST")
        {
            
			          
		    $data=$this->input->post();
            $data['updated_at']=date('Y-m-d H:i:s');
          

            if($this->input->post('currency_from')!=$this->input->post('currency_to'))
			{
				$result=$this->Common_model->update("currency_conver_charges",$data,array("curr_id"=>$curr_id));
			}

            if($result)
            {
				$msg='Update Successfully !';
				$this->session->set_flashdata('message',$msg);
                redirect(base_url()."admin/currency");
            }
			else{
				$msg='Something Wrong !';
				$this->session->set_flashdata('message',$msg);
                redirect(base_url()."admin/currency");
			}

            
        }

        else
        {
            $data['title']="Edit Currency Charges";
            $admin_username=$this->session->userdata('admin_username');
            $data['admin_data']=$this->adminusers_model->getUserByUsername($admin_username);

            $data['curr'] = $this->Common_model->getAll("currency")->result_array();
            $data['crr_data'] = $this->Common_model->getAll("currency_conver_charges",array("curr_id"=>$curr_id))->row_array();

        

            $this->load->view('admin/common/header', $data);
            $this->load->view('admin/currency/edit', $data);
            $this->load->view('admin/common/footer');
        }
        
    }


    public function deletecurr($curr_id) // delete category
    {
			
				$result=$this->Currency_model->deletecurr($curr_id);

				if($result)
				{
				   $msg='Delete Successfully !';
					$this->session->set_flashdata('message',$msg);
				   redirect(base_url()."admin/currency");
				}
			

    }


}
