<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * @auther Yogesh Pardeshi 19072019
 * controller to handle SMS receivers for order product management
 * by atzcart employees
 */
class Sms_receivers extends CI_Controller 
{
    /*
     * Check user session in every 
     * first call
     */
    public function __construct() 
    {
        parent::__construct();
        if(! $this->session->userdata("admin_logged_in")){
            $error = "<div class='alert alert-danger alert-dismissible'>
                        <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                        <strong>Error!</strong> Session timeout, relogin!.
                      </div>";
            $this->session->set_flashdata("message",$error);
            redirect("admin/login","refresh");
        }
        
        $this->load->library('Userpermission');
    }
    
    /*
     * To handle default route
     * display View view_receivers
     */
    public function index()
    {
        $this->view_receivers();
    }
    
    /**
     * display View all receivers sms list
     */
    function view_receivers() 
    {
        $check_permission = $this->checkPermission('view');
        
        if($check_permission != 1) {
            $this->session->set_flashdata('message', 'You do not have permissions to view sms receivers.');
            redirect('admin/dashboard');
        }
        $data['sms_receivers_row'] = $this->get_all_receivers();  
        $this->load->view("admin/sms_receivers/list", $data);
    }
    
    /**
     * 
     * @return type result array of 
     * emp info for order sms handling
     */
    private function get_all_receivers()
    {
      return $this->db->select('oc.id, emp_name, emp_mobile, sms_for, oc.status, DATE_FORMAT(date_added, "%a %d %M %Y %h:%i:%s %p ") date_added,
                               DATE_FORMAT(date_updated, "%a %d %M %Y %h:%i:%s %p ") date_updated, admin_firstname')
                               ->from('order_cancel_sms_emp_receiver oc')
                               ->join('admin', 'admin_id = oc.assigned_by', 'left')
                ->get()->result_array();
    }
    
    /**
     * display View to add receivers
     */
    function add_receivers() 
    {
        $check_permission = $this->checkPermission('add');
        
        if($check_permission != 1) {
            $this->session->set_flashdata('message', 'You do not have permissions to add sms receivers.');
            redirect('admin/sms_receivers/view_receivers');
        }
        
        $this->load->view("admin/sms_receivers/add_sms_receiver", $data);
    }
    
    /**
     * validate before adding in DB table
     * insert sms_receiver user &
     */
    function submit_receivers()
    {
       $validateForm = $this->setValidateFormAddRules(false);

       if($validateForm === false){
           $this->load->view("admin/sms_receivers/add_sms_receiver");
       } else {
        $sms_receiver_result=$this->db->get_where('order_cancel_sms_emp_receiver',array('emp_mobile' => $this->input->post('emp_mobile'), 'sms_for' => $this->input->post('sms_for')));
        if($sms_receiver_result && $sms_receiver_result->num_rows()>0)
        {
           $this->session->set_flashdata('message', 'Mobile Number Already Used For Employee '.$this->input->post('sms_for'));
               redirect('admin/sms_receivers/view_receivers');
        }
        else
        {
           //save details in table
           //emp_name , emp_mobile, sms_for, status 
           $insert_array = array('emp_name' => $this->input->post('emp_name'),
                                 'emp_mobile' => $this->input->post('emp_mobile'),
                                 'sms_for' => $this->input->post('sms_for'),
                                 'status' => $this->input->post('status'),
                                 'assigned_by' => $this->session->admin_id);
           
           $count = $this->db->insert('order_cancel_sms_emp_receiver', $insert_array);
           if($count > 0){
               $this->session->set_flashdata('message', 'Employee set for '.$this->input->post('sms_for'));
               redirect('admin/sms_receivers/view_receivers');
           } else {
               redirect('admin/sms_receivers/view_receivers');
           }
        }
          
       }
    }
    
    /**
     * edit sms_receiver user &
     * validate before update in DB table
     */
    function edit_submit_receivers()
    {
        $check_permission = $this->checkPermission('edit');
        
        if($check_permission != 1) {
            $this->session->set_flashdata('message', 'You do not have permissions to edit sms receivers.');
            redirect('admin/sms_receivers/view_receivers');
        }
        
       $validateForm = $this->setValidateFormAddRules(true);

       if($validateForm === false){
           $this->edit_sms_receiver($this->input->post('edit_id'));
           $this->load->view("admin/sms_receivers/edit_sms_receiver");
       } else {
           $id = $this->security->xss_clean($this->input->post('edit_id'));
           //save details in table
           //emp_name , emp_mobile, sms_for, status 
           $update_array = array('emp_name' => $this->input->post('emp_name'),
                                 'emp_mobile' => $this->input->post('emp_mobile'),
                                 'sms_for' => $this->input->post('sms_for'),
                                 'status' => $this->input->post('status'),
                                 'assigned_by' => $this->session->admin_id);
           
           $count = $this->db->update('order_cancel_sms_emp_receiver', $update_array, array('id'=>$id));
           if($count > 0){
               $this->session->set_flashdata('message', 'Employee details for sms updated');
               redirect('admin/sms_receivers/view_receivers');
           } else {
               redirect('admin/sms_receivers/view_receivers');
           }
       }
    }
    
    /**
     * 
     *@param type $id pk of order_cancel_sms_emp_receiver table
     * get details to edit that user from table
     */
    function edit_sms_receiver($id) 
    {
        $check_permission = $this->checkPermission('edit');
        if($check_permission == 1) {
            $id = $this->security->xss_clean($id);
            $data['emp_info'] = $this->db->select('*')->from('order_cancel_sms_emp_receiver')
                                        ->where('id', $id)->get()->result_array()[0];
            $this->load->view("admin/sms_receivers/edit_sms_receiver", $data);
        } else {
            $this->session->set_flashdata('message', 'You do not have permission to change this info!');
            redirect('admin/sms_receivers/view_receivers');
        }
    }
    
    /**
     * @param type $id pk of order_cancel_sms_emp_receiver table
     * deletes that user from sms_receiver list
     */
    function delete_sms_receiver($id) 
    {
        $check_permission = $this->checkPermission('delete');
        
        if($check_permission == 1) {
            $id = $this->security->xss_clean($id);
            $count =  $this->db->delete('order_cancel_sms_emp_receiver', array('id'=> $id));
            if($count > 0) {
                $this->session->set_flashdata('message', 'Employee deleted from receiveing sms list.');
                redirect('admin/sms_receivers/view_receivers');
            } else {
                 redirect('admin/sms_receivers/view_receivers');
            }
        } else {
            $this->session->set_flashdata('message', 'You do not have permissions to delete this mobile from sms list.');
            redirect('admin/sms_receivers/view_receivers');
        }
    }
    
    /**
     * @param type $permissionName name of permission 
     * @return type 1 if allowed; otherwise 0
     */
    private function checkPermission($permissionName)
    {
        //here menu_id = 62 means pk of menu id i.e. SMS Receivers
        $admin_id = $this->session->admin_id;
        return $check_permission = $this->db->select($permissionName)->from('user_permission')
                ->where('user_id', $admin_id)

                ->where('menu_id', 62)
                ->get()->result_array()[0][$permissionName];
    }
    
    /**
     * check validation
     * @return type true on success false on failure
     */
    private function setValidateFormAddRules($editFlag) {
       $this->form_validation->set_rules('emp_name', 'Employee Name', 'required');
       if($editFlag) {
            $this->form_validation->set_rules('emp_mobile', 'Employee Mobile', 'required|exact_length[10]|numeric|callback_duplicate_record[true]');
       } else {
            $this->form_validation->set_rules('emp_mobile', 'Employee Mobile', 'required|exact_length[10]|numeric|callback_duplicate_record|callback_invalid_mobile_empname');
       }
       $this->form_validation->set_rules('sms_for', 'SMS For ', 'required|in_list[Order Cancel,Order Processed,Order Delivered]');
       $this->form_validation->set_rules('status', 'Select status ', 'required|in_list[inactive,active]');
       return $this->form_validation->run();
    }

    public function duplicate_record($number, $flag)
    {
        $empName = $this->input->post('emp_name');
        $sms_for = $this->input->post('sms_for');
        $status = $this->input->post('status');
        $duplicate = "";
        
            if($flag == true) {
            $duplicate = $this->db->select('count(*) duplicates')->from('order_cancel_sms_emp_receiver')
                 ->where(array('emp_name' => $empName, 'emp_mobile' => $number, 'sms_for' => $sms_for, 
                     'status' => $status))
                 ->get()->result_array()[0]['duplicates'];
            } else {
                 $duplicate = $this->db->select('count(*) duplicates')->from('order_cancel_sms_emp_receiver')
                 ->where(array('emp_name' => $empName, 'emp_mobile' => $number, 'sms_for' => $sms_for))
                 ->get()->result_array()[0]['duplicates'];
            }
       
        if($duplicate > 0) {
            $this->form_validation->set_message('duplicate_record', 'This employee and mobile number is already assigned for '.$sms_for.' sms!');
            return false;
        } else {
            return true;
        }
    }

    public function invalid_mobile_empname($number)
    {
        $inputEmpName = $this->input->post('emp_name');
        $empName = $this->db->select('emp_name')->from('order_cancel_sms_emp_receiver')
                 ->where(array('emp_mobile' => $number))
                 ->get()->result_array()[0]['emp_name'];
        if($inputEmpName != $empName && !empty($empName)) {
            $this->form_validation->set_message('invalid_mobile_empname', 'Mobile number is already in use by different employee named( '.$empName.' ) !');
            return false;
        } else {
            return true;
        }
    }
    
   
}

