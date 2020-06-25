<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Report extends CI_Controller 
{
    public function __construct() 
    {
        parent::__construct();
        if (!$this->session->userdata("user_logged_in") || $this->session->userdata("user_role")!="seller") {
            $error = "<div id='login-error' class='form-error notice notice-error'><span class='icon-notice icon-error'></span><span><strong>Error!</strong> Session timeout, relogin!. </span></div>";
            $this->session->set_flashdata("message", $error);
            redirect("login", "refresh");
        }
       $this->load->model('Common_model');
       $this->load->model('Sellersalesreport_model');
       $this->load->model('Sellercommissionreport_model');
       $this->load->model('Sellernonsettlereport_model');
    }
    
    

    public function sale_report()
    {
        $data['statuses'] = $this->Common_model->getAll("orders_status")->result_array();
        $data["pageTitle"] = "Sales Report";
        $this->load->view("user/report/sales_report",$data);
    }
	
    public function settlement_report()
    {
        $data["pageTitle"] = "Settlement Report";
        $this->load->view("user/report/settlement_report",$data);
    }
	
    public function non_settled_report()
    {
        $data["pageTitle"] = "Not Settled Report";
        $this->load->view("user/report/non_settlement_report",$data);
    }
	
    public function commission_report()
    {
        $data["pageTitle"] = "Commission Report";
        $data['statuses'] = $this->Common_model->getAll("orders_status")->result_array();
        $this->load->view("user/report/commission_report",$data);
    }
	
    public function profit_loss_report()
    {
        $data["pageTitle"] = "Profitloss Report";
        $data['statuses'] = $this->Common_model->getAll("orders_status")->result_array();
        $this->load->view("admin/report/pfofit_loss_report",$data);
    }
	
	public function fetch_sales_report()
	{
		
        $columns = array(
            0 => '',
            1 => 'a.date_purchased',
            2 => 'e.payment_id',
			3 => 'a.orders_id',
			4 => 'a.seller_id',
			5 => 'b.first_name',
			6 => 'b.phone',
			7 => 'a.orders_status',
			8 => 'a.shipping_cost',
			9 => 'a.vendor_payable_price',
			10 => '',
			11 => 'a.order_price',
			12 => '',
			13 => '',
			14 => ''
        );

        $limit = $this->input->post('length');
        $start = $this->input->post('start');
        $order = $columns[$this->input->post('order')[0]['column']];
        $dir = $this->input->post('order')[0]['dir'];
        //$dir ="desc";

        $totalData = $this->Sellersalesreport_model->allsales_count();
		$query = $this->db->last_query();
        $totalFiltered = $totalData;

        if (empty($this->input->post('search')['value'])) {
            $vendors = $this->Sellersalesreport_model->allsales($limit, $start, $order, $dir);
        } else {
            $search = $this->input->post('search')['value'];

            $vendors = $this->Sellersalesreport_model->wallet_search($limit, $start, $search, $order, $dir);

            $totalFiltered = $this->Sellersalesreport_model->wallet_search_count($search);
        }
 
        $data = array();
        if (!empty($vendors)) {
			$i=0;
            foreach ($vendors as $vdr) {
                $nestedData['sr_no'] = $i += 1;
                $nestedData['datepurchased'] = $vdr->date_purchased;
                $nestedData['trans_id'] = $vdr->payment_id;
                $nestedData['order_id'] = '<a target="new" href="'.base_url('seller/orders/view/'.str_replace("ORD",'',$vdr->orders_id)).'" class="badge badge-primary" >'.$vdr->orders_id.'</a>';
				$nestedData['vendor_id'] = $vdr->seller_id;
				$nestedData['vendor_name'] = $vdr->vendorname;
				$nestedData['vendor_mobile'] = $vdr->vendorphone;
				$nestedData['order_status'] = $vdr->orders_status_name;
				$nestedData['shipping_cost'] = $vdr->shipping_cost;
				$nestedData['vendor_cost'] = $vdr->vendor_payable_price;
				$nestedData['atz_cost'] = ($vdr->order_price - $vdr->shipping_cost);
				$nestedData['order_amount'] = $vdr->order_price;
				$nestedData['buyer_name'] = $vdr->buyername;
				$nestedData['buyer_email'] = $vdr->buyeremail;
				$nestedData['buyer_mobile'] = $vdr->buyerphone;
                
                $data[] = $nestedData;
            }
        }

        $json_data = array(
            "draw" => intval($this->input->post('draw')),
            "recordsTotal" => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data" => $data,
            'query' => $this->db->last_query()
        );

        echo json_encode($json_data);
	}
	
	public function fetch_comission_report()
	{
		
        $columns = array(
            0 => '',
			1 => 'a.seller_id',
			2 => 'b.first_name',
			3 => 'a.orders_id',
			4 => 'a.date_purchased',
			5 => 'a.delivery_date',
			6 => 'a.order_price',
            7 => 'a.vendor_payable_price',
            8 => '',
			9 => '',
			10 => ''
        );
		
        $limit = $this->input->post('length');
        $start = $this->input->post('start');
        $order = $columns[$this->input->post('order')[0]['column']];
        $dir = $this->input->post('order')[0]['dir'];
        //$dir ="desc";

        $totalData = $this->Sellercommissionreport_model->allcommission_count();

        $totalFiltered = $totalData;

        if (empty($this->input->post('search')['value'])) {
            $vendors = $this->Sellercommissionreport_model->allcommission($limit, $start, $order, $dir);
        } else {
            $search = $this->input->post('search')['value'];

            $vendors = $this->Sellercommissionreport_model->commission_search($limit, $start, $search, $order, $dir);

            $totalFiltered = $this->Sellercommissionreport_model->commission_search_count($search);
        }

        $data = array();
        if (!empty($vendors)) {
			$i=0;
            foreach ($vendors as $vdr) 
			{
                $nestedData['sr_no'] = $i += 1;
				$nestedData['vendor_id'] = $vdr->seller_id;
				$nestedData['vendor_name'] = $vdr->vendorname;
				$nestedData['order_id'] = '<a target="new" href="'.base_url('seller/orders/view/'.str_replace("ORD",'',$vdr->orders_id)).'" class="link link-primary" >'.$vdr->orders_id.'</a>';
				$nestedData['datepurchased'] = $vdr->date_purchased;
				$nestedData['datedelivered'] = $vdr->delivery_date;
                $nestedData['total_amount'] = $vdr->order_price;
                $nestedData['payable_amount'] = $vdr->vendor_payable_price;
				$nestedData['commission'] = $vdr->commission;
				$nestedData['gst'] = $vdr->gst;
				$nestedData['total_deduction'] = $vdr->commission + $vdr->gst;
				$nestedData['total_settled'] = $vdr->settledamount;
				$nestedData['datesettled'] = $vdr->settled_date;
				$nestedData['remark'] = $vdr->remark;
                $data[] = $nestedData;
            }
        }

        $json_data = array(
            "draw" => intval($this->input->post('draw')),
            "recordsTotal" => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data" => $data,
			'query' => $this->db->last_query()
        );

        echo json_encode($json_data);
	}
	
	public function fetch_nonsettled_report()
	{
		
        $columns = array(
            0 => '',
			1 => 'a.seller_id',
			2 => 'b.first_name',
			3 => 'a.orders_id',
			4 => 'a.date_purchased',
			5 => 'a.delivery_date',
			6 => 'a.order_price',
            7 => 'a.vendor_payable_price',
            8 => '',
			9 => '',
			10 => ''
        );
		
        $limit = $this->input->post('length');
        $start = $this->input->post('start');
        $order = $columns[$this->input->post('order')[0]['column']];
        $dir = $this->input->post('order')[0]['dir'];
        //$dir ="desc";

        $totalData = $this->Sellernonsettlereport_model->allcommission_count();

        $totalFiltered = $totalData;

        if (empty($this->input->post('search')['value'])) {
            $vendors = $this->Sellernonsettlereport_model->allcommission($limit, $start, $order, $dir);
        } else {
            $search = $this->input->post('search')['value'];

            $vendors = $this->Sellernonsettlereport_model->commission_search($limit, $start, $search, $order, $dir);

            $totalFiltered = $this->Sellernonsettlereport_model->commission_search_count($search);
        }

        $data = array();
        if (!empty($vendors)) {
			$i=0;
            foreach ($vendors as $vdr) 
			{
                $nestedData['sr_no'] = $i += 1;
				$nestedData['vendor_id'] = $vdr->seller_id;
				$nestedData['vendor_name'] = $vdr->vendorname;
				$nestedData['order_id'] = '<a target="new" href="'.base_url('seller/orders/view/'.str_replace("ORD",'',$vdr->orders_id)).'" class="link link-primary" >'.$vdr->orders_id.'</a>';
				$nestedData['datepurchased'] = $vdr->date_purchased;
				$nestedData['datedelivered'] = $vdr->delivery_date;
                $nestedData['total_amount'] = $vdr->order_price;
                $nestedData['payable_amount'] = $vdr->vendor_payable_price;
				$nestedData['commission'] = $vdr->commission;
				$nestedData['gst'] = $vdr->gst;
				$nestedData['total_deduction'] = $commission + $gst;
				$nestedData['total_settlement'] = $vdr->vendor_payable_price;
				$nestedData['datesettled'] = $vdr->settled_date;
				$nestedData['remark'] = $vdr->remark;
                $data[] = $nestedData;
            }
        }

        $json_data = array(
            "draw" => intval($this->input->post('draw')),
            "recordsTotal" => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data" => $data,
			'query' => $this->db->last_query()
        );

        echo json_encode($json_data);
	}
	
	public function fetch_profitloss_report()
	{
		
        $columns = array(
            0 => '',
			1 => 'a.seller_id',
			2 => 'b.first_name',
			3 => 'a.orders_id',
			4 => 'a.date_purchased',
			5 => 'a.delivery_date',
			6 => 'a.order_price',
            7 => 'a.vendor_payable_price',
            8 => '',
			9 => '',
			10 => ''
        );
		
        $limit = $this->input->post('length');
        $start = $this->input->post('start');
        $order = $columns[$this->input->post('order')[0]['column']];
        $dir = $this->input->post('order')[0]['dir'];
        //$dir ="desc";

        $totalData = $this->Sellercommissionreport_model->allcommission_count();

        $totalFiltered = $totalData;

        if (empty($this->input->post('search')['value'])) {
            $vendors = $this->Sellercommissionreport_model->allcommission($limit, $start, $order, $dir);
        } else {
            $search = $this->input->post('search')['value'];

            $vendors = $this->Sellercommissionreport_model->commission_search($limit, $start, $search, $order, $dir);

            $totalFiltered = $this->Sellercommissionreport_model->commission_search_count($search);
        }

        $data = array();
        if (!empty($vendors)) {
			$i=0;
            foreach ($vendors as $vdr) 
			{
                $nestedData['sr_no'] = $i += 1;
				$nestedData['vendor_id'] = $vdr->seller_id;
				$nestedData['vendor_name'] = $vdr->vendorname;
				$nestedData['order_id'] = '<a target="new" href="'.base_url('seller/orders/view/'.str_replace("ORD",'',$vdr->orders_id)).'" class="link link-primary" >'.$vdr->orders_id.'</a>';
				$nestedData['datepurchased'] = $vdr->date_purchased;
				$nestedData['datedelivered'] = $vdr->delivery_date;
                $nestedData['total_amount'] = $vdr->order_price;
                $nestedData['payable_amount'] = $vdr->vendor_payable_price;
                $nestedData['settled'] = $vdr->settledamount;
				$nestedData['commission'] = round($vdr->commission,2);
				$nestedData['gst'] = $vdr->gst;
				$nestedData['total_deduction'] = round($vdr->commission + $vdr->gst,2);
				$nestedData['datesettled'] = $vdr->settled_date;
				
				$settled_amount = $vdr->settledamount;
				$order_price = $vdr->order_price;
				if($order_price > $settled_amount){ $pl='Profit'; }elseif($order_price < $settled_amount){ $pl="Loss"; }elseif($order_price == $settled_amount){ $pl="Neutral"; }else{ $pl=''; }
				$nestedData['profitloss'] = $pl;
                $data[] = $nestedData;
            }
        }

        $json_data = array(
            "draw" => intval($this->input->post('draw')),
            "recordsTotal" => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data" => $data,
			'query' => $this->db->last_query()
        );

        echo json_encode($json_data);
	}
}