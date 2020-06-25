  <?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Mycoupons extends CI_Controller 
{
    public function __construct() 
    {
        parent::__construct();
        if (!$this->session->userdata("user_logged_in")) {
            $error = "<div id='login-error' class='form-error notice notice-error'><span class='icon-notice icon-error'></span><span><strong>Error!</strong> Session timeout, relogin!. </span></div>";
            $this->session->set_flashdata("message", $error);
            redirect("login", "refresh");
        }
        $this->load->model('Coupon_model');
        $this->load->library("get_header_data");
       
    }

    public function index() 
    {

		$data = $this->get_header_data->get_categories();
		$data["title"] = "ATZCart - Buyers Coupons";
		$user_id=$this->session->userdata("user_id");
		//$data['allorder'] = $this->Myorders_model->allorders($user_id,$limit=100, $start=0, $order=0, $dir=0);
		$data1['allcoupons'] = $this->Coupon_model->allmycoupons($user_id,$limit=100, $start, $order, $dir);
		$this->load->view('front/common/header',$data);
		$this->load->view("front/myaccount/coupons",$data1);
		$this->load->view('front/common/footer');
    }
	
	public function mycoupons_ajax_list() 
    {
		$user_id=$this->session->userdata("user_id");
	   
        $columns = array(
            0 => 'coupon_id',
            1 => 'coupon_code',
            2 => 'coupon_value',
            3 => 'valid_to',
            4 => 'status',
            5 => 'updated_at',
        );

        $limit = $this->input->post('length');
        $start = $this->input->post('start');
        $order = $columns[$this->input->post('order')[1]['column']];
        $dir = $this->input->post('order')[1]['dir'];

        $totalData = $this->Coupon_model->allmycoupon_count($user_id);
		

        $totalFiltered = $totalData;

        if (empty($this->input->post('search')['value'])) {
            $alorder = $this->Coupon_model->allmycoupons($user_id,$limit, $start, $order, $dir);
        } else {
            $search = $this->input->post('search')['value'];

            $alorder = $this->Coupon_model->mycoupon_search($user_id,$limit, $start, $search, $order, $dir);
			//echo $this->db->last_query();
			
            $totalFiltered = $this->Coupon_model->mycoupon_search_count($user_id,$search);
        }

        $data = array();
        if (!empty($alorder)) {
            foreach ($alorder as $br) {
				if($br->valid_to >=date('Y-m-d'))
				{
					$valid_status='<span style="color:green;font-weight:bold;" title="Valid">o</span>'; 
				}
				else
				{
					$valid_status='<span style="color:red;font-weight:bold;" title="Expire">o</span>';
				}
                $nestedData['coupon_id'] = $br->coupon_id;
                $nestedData['coupon_code'] = $br->coupon_code;
                $nestedData['coupon_value'] = $br->coupon_value.' ('.$br->discount_type.' )';
                $nestedData['valid_to'] =$valid_status.' | '.date('d M Y',strtotime($br->valid_from)).' <b style="color:red;"> ~ </b> '.date('d M Y',strtotime($br->valid_to));
                $nestedData['status'] = $br->status;
                $nestedData['updated_at'] = date('d-m-Y H:i',strtotime($br->updated_at));
               
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

	
}	