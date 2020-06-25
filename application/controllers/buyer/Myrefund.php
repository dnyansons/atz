<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Myrefund extends CI_Controller 
{
    public function __construct() 
    {
        parent::__construct();
		if(! $this->session->userdata("user_logged_in")){
            $error = "<div id='login-error' class='form-error notice notice-error'><span class='icon-notice icon-error'></span><span><strong>Error!</strong> Session timeout, relogin!. </span></div>";
            $this->session->set_flashdata("message",$error);
            redirect("login","refresh");
        }
		$this->load->model('Refund_model');
    }

    public function index() 
    {
		$data["pageTitle"] = "My Refund";
		$this->load->view("user/myrefund/list",$data);
    }
	
	 public function ajax_list() 
    {
		$ret_id=$this->session->userdata("supplier_id");
	   
        $columns = array(
            0 => 'orders_id',
            1 => 'products_name',
            2 => 'final_price',
            3 => 'orders_status', 
        );

        $limit = $this->input->post('length');
        $start = $this->input->post('start');
        $order = $columns[$this->input->post('order')[1]['column']];
        $dir = $this->input->post('order')[1]['dir'];

        $totalData = $this->Refund_model->allrefund_count($ret_id);
		// echo $this->db->last_query();

        $totalFiltered = $totalData;

        if (empty($this->input->post('search')['value'])) {
            $alorder = $this->Refund_model->allrefund($ret_id,$limit, $start, $order, $dir);
			//echo $this->db->last_query();
        } else {
            $search = $this->input->post('search')['value'];

            $alorder = $this->Refund_model->refund_search($ret_id,$limit, $start, $search, $order, $dir);
			//echo $this->db->last_query();
			
            $totalFiltered = $this->Refund_model->refund_search_count($ret_id,$search);
        }

        $data = array();
        if (!empty($alorder)) {
            foreach ($alorder as $br) {
                $nestedData['orders_id'] = $br->orders_id;
                $nestedData['products_name'] = $br->products_name;
                $nestedData['final_price'] = $br->final_price;
                $nestedData['orders_status'] = $br->orders_status;
                $nestedData['action'] = '<button title="View Detail" type="button" onclick="view_refund('.$br->orders_id.')" class="btn btn-info btn-sm" data-toggle="modal" data-target="#myRefund"><i class="fa fa-eye"></i></button>';

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
	
	
	function refund_view()
	{
		$order_id=$this->input->post('order_id');
		$refund=$this->Refund_model->single_refund($order_id);  
		//echo $this->db->last_query();
		$str='';
		$str.='<table class="table" style="width:100%">';
		$i=0;
		foreach($refund as $fund)
		{
			if($i==0)
			{
				$str.='<tr>';
					$str.='<th>Product Name</th>';
					$str.='<td>'.$fund->products_name.'</td>';
				$str.='</tr>';
				$str.='<tr>';
					$str.='<th>Refund Status</th>';
					$str.='<td>'.$fund->orders_status.'</td>';
				$str.='</tr>';
				$str.='<tr>';
		
				$str.='<th colspan="2" style="text-align:center;" class="alert alert-info">Request Process</th>';
				$str.='</tr>';
			}
			//Refund History
			$str.='<tr>';
					$str.='<th colspan="2"><i class="fa fa-space-shuttle"></i>&nbsp;&nbsp;'.$fund->comment.'</th>';
				$str.='</tr>';
			$i++;
		}
		
		$str.='</table>';
		echo $str;
	}

}	