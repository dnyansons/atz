<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Dashboard extends CI_Controller {

    public function __construct() {
        parent::__construct();
        if (!$this->session->userdata("admin_logged_in")) {
            $error = "<div class='alert alert-danger alert-dismissible'>
                        <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                        <strong>Error!</strong> Session timeout, relogin!.
                      </div>";
            $this->session->set_flashdata("message", $error);
            redirect("admin/login", "refresh");
        }
        $this->load->model('Dashboard_model');
        $this->load->model('Admindashboard_model');
        $this->load->model('Order_model');
        $this->load->model('Common_model');
        $this->load->library('Userpermission');
    }

    public function index() {

        $data = ["pageTitle" => "Admin Dashboard"];

        $data['tot_order'] = $this->Admindashboard_model->total_orders(date('Y-m-d'), date('Y-m-d'));
        $data['tot_sale'] = $this->Admindashboard_model->total_sale(date('Y-m-d'), date('Y-m-d'));
        $data['tot_comission'] = $this->Admindashboard_model->total_commission(date('Y-m-d'), date('Y-m-d'));
        $data['tot_shipping'] = $this->Admindashboard_model->total_shipping(date('Y-m-d'), date('Y-m-d'));
        $data['tot_return'] = $this->Admindashboard_model->total_returns(date('Y-m-d'), date('Y-m-d'));
        $data['tot_dispute'] = $this->Admindashboard_model->total_dispute(date('Y-m-d'), date('Y-m-d'));
        $data['tot_settled'] = $this->Admindashboard_model->total_settled(date('Y-m-d'), date('Y-m-d'));
        $data['total_refund'] = $this->Admindashboard_model->total_refund(date('Y-m-d'), date('Y-m-d'));
        // $data['tot_sale'] = $this->Dashboard_model->tot_sale_admin();
        // $data['tot_customer'] = $this->Dashboard_model->tot_customer_admin();
        // $data['monthly_orders_all'] = $this->Dashboard_model->admin_orders_monthly();
        $data['monthly_orders_pending'] = $this->Dashboard_model->admin_orders_monthly(8);
        $data['monthly_orders_completed'] = $this->Dashboard_model->admin_orders_monthly(4);
        $data["todays_sale"] = $this->Order_model->todaysSale();
        $data['latest_order'] = $this->Dashboard_model->latest_order_admin();
        $data['currency'] = $this->session->userdata("currency");
        $data['todaysBuyerRegs'] = $this->Admindashboard_model->todaysUsers('buyer');
        $data['todaysSellerRegs'] = $this->Admindashboard_model->todaysUsers('seller');
        
        $this->load->view("admin/dashboard/dashboard_view", $data);
    }

    function get_notifications() {
        $return_arr = [];
        $notification_list = $this->Common_model->select('*', 'admin_notification', '', array(1 => array('colname' => 'id', 'type' => 'DESC')), 5);
        $received_count = $this->Common_model->select('count(id)', 'admin_notification', ['status' => 'Received']);
        $count = $received_count[0]['count(id)'];
        $count_arr = [];
        $notification_list[0]['received_count'] = $count;
        echo json_encode($notification_list);
    }
    
    function read_notification($id)
    {
        $dat["status"]="Read";
        $result = $this->Common_model->update('admin_notification',$dat,array("status"=>"Received","id"=>$id));
        echo json_encode($result);

    }

    public function check() {
        $data = $this->userpermission->menus();
        echo "<pre>";
        print_r($data);
    }

    function updatetoken() {
        $this->Common_model->update('admin', ['firebase_token' => $_POST['token']], ['admin_id' => $_SESSION['admin_id']]);
    }

    function test() {
        echo $this->notifyadmin("Test Notification", "Test Message", "New Order Placed");
    }

    function notifyadmin($title, $message, $tag) {
        $fb = $this->Common_model->getAll("admin")->result_array();

        $firebaseid = array();
        foreach ($fb as $res) {
            if (!empty($res['firebase_token'])) {
                $firebaseid[] = $res['firebase_token'];
            }
        }
        //SERVER KEY TOOK FROM FIREBASE CONSOLE
        $server_key = "AAAAQZPhbOI:APA91bE66fLevVa21qhnG0Wg6pAcUtDCk4CnUDxTDMHCwdDnn1WoHHnkn7oxPOjfG8yZb8H08VwbM6X6VWZoJ7JrP4kZki-Ke8Z5ZipqEhFwq8YviFuOrycxNERMdpNlUOE4NaV4i_j1";
        //FIREBASE URL
        $url = "https://fcm.googleapis.com/fcm/send";
        $headers = array('Content-Type: application/json', 'Authorization: key=' . $server_key);
        $fields = array('registration_ids' => $firebaseid, 'data' => array('title' => $title, 'body' => $message, 'tag' => $tag));
        $payload = json_encode($fields);
        // Open connection
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        $result = curl_exec($ch);
        if ($result === FALSE) {
            die('Curl failed: ' . curl_error($ch));
        }
        // Close connection
        curl_close($ch);
        return $result;
    }

    function all_admin_notification() {
        //update all Status

        $dat['status'] = 'Read';
        $this->Common_model->update('admin_notification', $dat, array('status' => 'Received'));
        $this->load->view("admin/dashboard/all_admin_notification", $data);
    }

    public function fetch_admin_notification() {
        

        $columns = array(
            0 => '',
            1 => 'title',
            2 => 'type',
            3 => 'msg',
            4 => 'status',
            5 => 'date_created',
        );

        $limit = $this->input->post('length');
        $start = $this->input->post('start');
        $order = $columns[$this->input->post('order')[0]['column']];
        $dir = $this->input->post('order')[0]['dir'];
        //$dir ="desc";

        $totalData = $this->Admindashboard_model->all_admin_noti_count();

        $totalFiltered = $totalData;

        if (empty($this->input->post('search')['value'])) {
            $vendors = $this->Admindashboard_model->all_admin_noti($limit, $start, $order, $dir);
            // echo $this->db->last_query();
        } else {
            $search = $this->input->post('search')['value'];

            $vendors = $this->Admindashboard_model->all_admin_noti_search($limit, $start, $search, $order, $dir);

            $totalFiltered = $this->Admindashboard_model->all_admin_noti_search_count($search);
        }

        $data = array();
        if (!empty($vendors)) {
            $i = 0;
            foreach ($vendors as $vdr) {
                $positionOrd = stripos($vdr->msg, '#ORD');
                if($positionOrd !== false){
                    $orderIdWithSpaceHash = strstr($vdr->msg, '#ORD');
                    $orderIdWithHash = strstr($orderIdWithSpaceHash, ' ', true);
                    $orderId = str_ireplace('#ORD', '', $orderIdWithHash);
                    $orderLink = '<a href="'.base_url("admin/order/view/$orderId").'"
                        target="new" class="badge badge-primary">'.$orderIdWithHash.'</a>';
                    $vdr->msg = str_ireplace($orderIdWithHash,$orderLink, $vdr->msg);
                    //echo $vdr->msg;
                }
                
                $nestedData['sr_no'] = $i += 1;
                $nestedData['title'] = $vdr->title;
                $nestedData['type'] = $vdr->type;
                $nestedData['msg'] = $vdr->msg;
                $nestedData['status'] = $vdr->status;
                /*********** Mysqls default time is at GMT, Thus added 5:30 to convert to IST *******/
                $nestedData['date_created'] = date("d:m:Y h:i",strtotime($vdr->date_created . '+330 minutes' ));
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
