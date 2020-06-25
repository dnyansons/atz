<?php
defined('BASEPATH') OR exit("Direct access denied");
class Inquiries extends CI_Controller
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
        $this->load->model("Inquiries_model");
        $this->load->model("Myorders_model");
	$this->load->library('Userpermission');
    }
    
    public function index()
    {
        $this->Myorders_model->read_inquires_notification();
        $data["pageTitle"] = "Admin | Inquiries";
        $this->load->view("admin/inquiries/list");
    }
    
    public function ajax_list()
    {
        $type = $this->input->post('type');
        $datefrom = $this->input->post('datefrom');
        $dateto = $this->input->post('dateto');

        $inquiries = $this->Inquiries_model->get_datatables($type, $datefrom, $dateto);

        $data = array();
        $no = $this->input->post('start');
        foreach ($inquiries as $enquiry) {
            $forwarded = 0;
            if($enquiry->is_forwarded){
                $forwarded = 1;
            }
            $no++;
            $row = array();
            $row[] = $enquiry->id;
            $row[] = $enquiry->buyerfirstname.' '.$enquiry->buyerlastname;
            $row[] = $enquiry->buyeremail;
            $row[] = $enquiry->buyerphone;
            $row[] = $enquiry->products_name;
            $row[] = $enquiry->quantity." (".$enquiry->units_name.")";
            $row[] = $enquiry->comment;
            if($enquiry->attachments_by_buyer =='')
            {
                 $row[] = 'No Attachment';
            }else{
                $row[] = '<a href="'.$enquiry->attachments_by_buyer.'">download</a>';
            }
            $row[] = $enquiry->sellerfirstname.' '.$enquiry->sellerlastname;
            $row[] = $enquiry->selleremail;
            $row[] = $enquiry->sellerphone;
//            $row[] = $forwarded?"-":'<span style="cursor: pointer;" class="badge badge-success badge-md" data-toggle="modal" data-target="#myModal" onclick = "getcomment(this.id)" id="comment_'.$no.'" data-id = "'.$enquiry->id.'" data-comment = "'.$enquiry->comment.'">Edit</span>';
            $row[] = $forwarded?"<span class='text-success'>Yes</span>":"<span class='text-danger'>No</span>";
            $row[] = "<button type='button' class='btn btn-primary dropdown-toggle' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'><i class='fa fa-cog' aria-hidden='true'></i></button>
                        <div class='dropdown-menu dropdown-menu-right b-none contact-menu' style='width:200px'>
                            <a class='dropdown-item' onclick='return confirm(\"are you sure\");' href='" . site_url() . 'admin/inquiries/forward/' . $enquiry->id . "'><i class='fa fa-reply'></i>Forward</a>
                            <a class='dropdown-item' onclick='return confirm(\"are you sure\");' href='" . site_url() . 'admin/inquiries/delete/' . $enquiry->id . "'><i class='fa fa-remove'></i>Delete</a>
                        </div>";
         
            $data[] = $row;
        }

        $output = array(
            "draw" => $this->input->post('draw'),
            "recordsTotal" => $this->Inquiries_model->count_all(),
            "recordsFiltered" => $this->Inquiries_model->count_filtered($type,$datefrom, $dateto),
            "data" => $data,
        );
        echo json_encode($output);
    }
    
    public function forward($id = 0)
    {
        $updateData = [
            "is_forwarded" => 1,
            "status" => "Approved"
        ];
        $this->Inquiries_model->updateEnquiry($updateData,$id);
        $error = "<div class='alert alert-success alert-dismissible'>
            <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
            <strong>Success!</strong> Inquiry forwarded successfully.
        </div>";
        $this->session->set_flashdata("message",$error);
        redirect("admin/inquiries","refresh");
    }

    public function delete($id)
    {
        $this->Inquiries_model->deleteEnquiry($id);
        $error = "<div class='alert alert-success alert-dismissible'>
            <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
            <strong>Success!</strong> Inquiry deleted successfully.
        </div>";
        $this->session->set_flashdata("message",$error);
        redirect("admin/inquiries","refresh");
    }
    
//    public function updateComment()
//    {
//        $inquiryId  = $this->input->post("inquiryId");
//        $updateData = [
//            "id" => $this->input->post("inquiryId"),
//            "comment" =>$this->input->post("comment")
//        ];
//        $res = $this->Inquiries_model->updateEnquiry($updateData,$inquiryId);
//        echo json_encode($res);
//    }
    
//    public function getSellerReply($inquiry_id) {
//         $data["pageTitle"] = "Admin | Inquiries Seller Reply";
//         $data['result'] = $this->Inquiries_model->getSellerReply($inquiry_id);
//         $this->load->view("admin/inquiries/sellerReply",$data);
//    }
}