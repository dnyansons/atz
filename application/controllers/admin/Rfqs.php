<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Rfqs extends CI_Controller {

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
        $this->load->model('Rfqs_model');
        $this->load->model('Users_model');
        $this->load->model('Product_model');
        $this->load->library("form_validation");
        $this->load->library("Browser_notification");
        $this->load->library('Userpermission');
        $this->load->library('Send_data');
    }

    public function index() {
        $this->Rfqs_model->read_rfq_notification();
        $data["pageTitle"] = "Admin || rfqs";
        $this->load->view("admin/rfqs/list", $data);
    }

    public function ajax_list() {

        $columns = array(
            0 => 'id',
            1 => 'looking_for',
        );

        $datefrom = $this->input->post('datefrom');
        $dateto = $this->input->post('dateto');
  
        $limit = $this->input->post('length');
        $start = $this->input->post('start');
        $order = $columns[$this->input->post('order')[0]['column']];

        $dir = "desc";

        $totalData = $this->Rfqs_model->rfqs_count($datefrom, $dateto);

        $totalFiltered = $totalData;

        if (empty($this->input->post('search')['value'])) {
            $rfqs = $this->Rfqs_model->allrfqs($datefrom, $dateto, $limit, $start, $order, $dir);
        } else {
            $search = $this->input->post('search')['value'];

            $rfqs = $this->Rfqs_model->rfqs_search($limit, $start, $search, $order, $dir);

            $totalFiltered = $this->Rfqs_model->rfqs_search_count($search);
        }

        $data = array();
        if (!empty($rfqs)) {
            $status = '';
            $action = '';
            $reply = 'No Reply';
            foreach ($rfqs as $col) {

                $count_enq = $this->Common_model->getAll('rfq_to_seller', array('rfq_id' => $col->id))->num_rows();

                if ($col->is_forwarded == 1) {
                    $action = "<span style='color:green'>Forwarded</span>";
                } else {
                    $action = "<a class='btn btn-info' href=" . site_url() . "admin/rfqs/forward/" . $col->id . "><i class='fa fa-mail-forward'></i></a>";
                }

                if ($col->status == "Pending") {
                    $status = "<span style='color:red'>Pending</span>";
                } else if ($col->status == "Rejected") {
                    $status = "<span style='color:red'>Rejected</span>";
                    $action = "<span style='color:red'>Rejected</span>";
                    $reply = '--';
                } elseif ($col->status == 'SellerReplied') {
                    //$reply = '<a href="#" class="btn btn-sm btn-info" data-toggle="modal" data-target="#myModal" onclick="get_reply(' . $col->rfq_to_seller_id . ')">Click to Approve</a>';
                    $reply = '<a href="' . base_url() . 'admin/rfqs/view_seller_reply/' . $col->id . '">Click to View (' . $count_enq . ')</a>';
                    $status = "<span style='color:green'>Seller Replied</span>";
                    $action = "<span style='color:red'>--</span>";
                } elseif ($col->status == 'Approved') {
                    $reply = '<a href="' . base_url() . 'admin/rfqs/view_seller_reply/' . $col->id . '">Click to View (' . $count_enq . ')</a>';
                    $status = "<span style='color:green'>Seller Replied</span>";
                    $action = "<span style='color:green'>Completed</span>";
                } else {
                    $status = "<span style='color:green'>Approved</span>";
                    $action = "<span style='color:green'>Completed</span>";
                }


                if (empty($col->attachments)) {
                    $attch = '--';
                } else {
                    $attch = '<a href="' . $col->attachments . '">Download</a>';
                }
                $nestedData['id'] = $col->id;
                $nestedData['user_name'] = $col->first_name . ' ' . $col->last_name;
                $nestedData['looking_for'] = $col->looking_for;
                $nestedData['quanity'] = $col->quanity;
                $nestedData['unit'] = $col->units_name;
                // $nestedData['description'] = $col->description;
                $nestedData['document'] = $attch;
                $nestedData['status'] = $status;
                $nestedData['reply'] = $reply;
                $nestedData['actions'] = $action;

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

    function view_seller_reply($id) {
        $data["pageTitle"] = "Admin || rfqs";
        $this->db->select('rs.admin_approve,rs.status as seller_rfq_status,rs.id as rfq_to_seller_id,r.id, us.first_name, us.last_name,us_seller.first_name seller_name, r.looking_for, rs.quantity, u.units_name,rs.price, units_name, r.description, r.is_forwarded,rs.comment');

        $this->db->from('rfqs r');
        $this->db->join('users us', 'r.customer_id = us.id', 'LEFT');
        $this->db->join('rfq_to_seller rs', 'r.id = rs.rfq_id', 'LEFT');
        $this->db->join('users us_seller', 'rs.seller_id = us_seller.id', 'LEFT');
        $this->db->join('units u', 'r.unit = u.units_id', 'LEFT');
        $this->db->where('r.id', $id);

        $query = $this->db->get();
        $data['result'] = $query->result();
        //echo'<pre>';
//print_r($data['result']);
//exit;
        $this->load->view("admin/rfqs/view_seller_reply", $data);
    }

    function get_sellet_reply() {
        $id = $this->input->post('id');
        $res = $this->Common_model->getAll('rfq_to_seller', array('id' => $id))->row();
        if ($res->admin_approve != 1) {
            $readonly = '';
        } else {
            $readonly = 'readonly';
        }
        $dat = '';
        if ($res->price == 0) {
            $price = 0;
        }
        $price = $res->price;
        $dat = '<div class="card-block">

                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Attachment</label>
                                            <div class="col-sm-10" style="margin-top:7px;">
                                               <a href="' . $res->attachment . '" >Click to Download</a>
                                            </div>

                                        </div>

                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Quantity</label>
                                            <div class="col-sm-10">
                                                <input type="textbox" name="quantity" class="form-control" value="' . $res->quantity . '" readonly>
                                                
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Unit</label>
                                            <div class="col-sm-10">
                                                
                                            <input type="textbox" name="unit" class="form-control" value="' . $res->unit . '" readonly>
                                            <input type="hidden" name="rfq_id" value="' . $res->rfq_id . '">
                                            <input type="hidden" name="rfq_to_seller_id" value="' . $res->id . '">
                                               
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Price</label>
                                            <div class="col-sm-10">
                                                <input type="textbox" name="price" class="form-control" value="' . $price . '" readonly>
                                               
                                            </div>
                                        </div>
                                        
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Admin Hike (%)</label>
                                            <div class="col-sm-10">
                                                <input type="number" name="admin_hike" class="form-control" value="' . $res->admin_hike . '" required ' . $readonly . '>
                                               
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Comment</label>
                                            <div class="col-sm-10">
                                                <textarea rows="5" cols="5" name="comment" class="form-control" placeholder="Comment" ' . $readonly . ' >' . $res->comment . '</textarea>
                                               
                                            </div>
                                        </div>';
        if ($res->admin_approve != 1) {
            $dat.='<div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Choose Action</label>
                                            <div class="col-sm-10">
                                                <select name="act" class="form-control" required>
                                                <option value="Approve">Approve</option>
                                                <option value="Reject">Reject</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    ';
        }
        if ($res->admin_approve != 1) {
            $dat.=' <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-success" onclick="return confirm(&#39;Are You Sure ?&#39;)">Submit</button>
                                       
                                       
                                    </div>';
        }
        echo $dat;
    }

    function update_seller_reply() {
        $this->load->library("form_validation");
        $this->form_validation->set_rules("admin_hike", "Admin Hike", "required");
        $this->form_validation->set_rules("rfq_id", "", "required");
        $this->form_validation->set_rules("act", "", "required");
        $this->form_validation->set_rules("comment", "", "required");
        $rfq_id = $this->input->post('rfq_id');
        if ($this->form_validation->run() === false) {
            $error = "<div class='alert alert-danger alert-dismissible'>
                                <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                                <strong>Success!</strong> All Fields are Required !
                                </div>";
            $this->session->set_flashdata("message", $error);
            redirect("admin/rfqs/view_seller_reply/$rfq_id", "refresh");
        } else {

            $comment = $this->input->post('comment');
            $act = $this->input->post('act');
            $rfq_to_seller_id = $this->input->post('rfq_to_seller_id');
            $admin_hike = $this->input->post('admin_hike');
            if ($admin_hike >= 0 && $admin_hike <= 100) {
                $dat['admin_hike'] = $admin_hike;
                $dat['comment'] = $comment;
                $dat['admin_approve'] = 1;

                $this->Common_model->update('rfq_to_seller', $dat, array('id' => $rfq_to_seller_id));

                if ($act == 'Approve') {
                    $dat1['status'] = 'Approved';
                } else {
                    $dat1['status'] = 'Rejected';
                }
                $this->Common_model->update('rfqs', $dat1, array('id' => $rfq_id));

                $error = "<div class='alert alert-success alert-dismissible'>
                                <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                                <strong>Success!</strong> RFQ update Successfullly !
                                </div>";
                $this->session->set_flashdata("message", $error);


                $rfq_rec = $this->Rfqs_model->getRfqById($rfq_id);
                $customer_id = $rfq_rec->customer_id;

                $rfqUser = $this->Users_model->getUserById($customer_id);
                $this->load->library("email");

                $mobile = $rfqUser->phone;
                //Send SMS
                $mesg = "Reply recieved for Request for quotation. Please login to your account to view the details.";
                $this->send_data->send_sms($mesg, $mobile);

                //send Mail
                /* $from = $this->config->item("default_email_from");
                  $to = $rfqUser->email;
                  $config = array(
                  'charset' => 'utf-8',
                  'wordwrap' => TRUE,
                  'mailtype' => 'html'
                  );
                  $config['protocol'] = 'smtp';
                  $config['smtp_host'] = 'smtp-relay.gmail.com';
                  $config['smtp_user'] = 'support@atzcart.com';
                  $config['smtp_pass'] = 'asdfghjklQWE123@';
                  $config['smtp_port'] = 587;
                  $config['smtp_crypto'] = 'tls';
                  $this->email->initialize($config);
                  $this->email->from($from, 'Atzcart');
                  $this->email->to($to);
                  $this->email->subject('Request For Quotaion Reply from Seller');
                  $this->email->message($mesg);
                  $this->email->send(); */

                redirect("admin/rfqs/view_seller_reply/$rfq_id", "refresh");
            } else {
                $error = "<div class='alert alert-danger alert-dismissible'>
                                <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                                <strong>Error!</strong> Please Add Proper Hike !
                                </div>";
                $this->session->set_flashdata("message", $error);
                //redirect("admin/rfqs", "refresh");
                redirect("admin/rfqs/view_seller_reply/$rfq_id", "refresh");
            }
        }
    }

    public function forward($id) {
        $data["rfqs_id"] = $id;
        $data["pageTitle"] = "Admin || Forward Rfqs";
        $this->load->view("admin/rfqs/supplier_list", $data);
    }

    public function ajax_supplier_list() {
        $columns = array(
            0 => 'id',
            1 => 'contact_person1_name',
            2 => 'company_name',
            3 => 'email',
            4 => 'telephone',
            5 => 'country',
            6 => 'state',
            7 => 'city',
        );

        $limit = $this->input->post('length');
        $start = $this->input->post('start');
        $order = $columns[$this->input->post('order')[0]['column']];
        $dir = $this->input->post('order')[0]['dir'];

        $totalData = $this->Rfqs_model->allsupplier_count();

        $totalFiltered = $totalData;

        if (empty($this->input->post('search')['value'])) {
            $suppliers = $this->Rfqs_model->allsupplier($limit, $start, $order, $dir);
        } else {
            $search = $this->input->post('search')['value'];

            $suppliers = $this->Rfqs_model->supplier_search($limit, $start, $search, $order, $dir);

            $totalFiltered = $this->Rfqs_model->supplier_search_count($search);
        }

        $data = array();
        if (!empty($suppliers)) {
            foreach ($suppliers as $supplier) {
                $nestedData['id'] = $supplier->id;
                $nestedData['name'] = $supplier->first_name . " " . $supplier->last_name;
                $nestedData['company'] = $supplier->company_name;
                $nestedData['email'] = $supplier->email;
                $nestedData['telephone'] = $supplier->phone;
                $nestedData['country'] = $supplier->country;
                $nestedData['state'] = $supplier->state;
                $nestedData['city'] = $supplier->city;
                $nestedData['subscription_plan'] = "";
                $nestedData['product_categories'] = "";
                $nestedData['products_listed'] = "";
                $nestedData['action'] = "<a class='btn btn-link' href='" . site_url() . "admin/suppliers/view/" . $supplier->id . "'>view</a>";
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

    public function ajaxApplyRequestsTosuppliers() {
        $output = array(
            "success" => 0,
            "message" => "Unable to process now"
        );
        $user_id = $this->session->userdata("admin_id");
        $supplier_ids = $this->input->post("supplier_ids");
        $rfqs_id = $this->input->post("rfqs_id");
        if (count($supplier_ids) > 0) {
            $emails = $this->Users_model->getEmailsByIds($supplier_ids);
            $rfq = $this->Rfqs_model->getRfqById($rfqs_id);
            if ($emails && $rfq) {
                $emailString = implode(',', array_map(function ($entry) {
                            return $entry['email'];
                        }, $emails));
                $this->load->library('email');
                $config = array(
                    'charset' => 'utf-8',
                    'wordwrap' => TRUE,
                    'mailtype' => 'html'
                );
                $from = $this->config->item("default_email_from");
                $to = $this->config->item("default_email_to");
                $data["refq"] = $rfq;
                $mesg = $this->load->view('emailtemplates/quotation_request', $data, true);
                $this->email->initialize($config);
                $this->email->from($from, 'Atzcart');
                $this->email->to($to);
                $this->email->bcc($emailString);
                $this->email->subject('Request For Quotaion');
                $this->email->message($mesg);
                $this->email->send();
                $insertData = array();
                $i = 0;
                foreach ($supplier_ids as $sup) {
                    $insertData[$i] = array(
                        "rfq_id" => $rfqs_id,
                        "forwarded_by" => $user_id,
                        "seller_id" => $sup,
                        "status" => "Pending",
                    );

                    $this->rfq_notify_to_seller($sup);

                    /* $sellerNotify = array(
                      'title' => 'New RFQ',
                      'msg' => 'New RFQ Request',
                      'type' => 'RFQ',
                      'reference_id' => $rfqs_id,
                      'status' => 'Received'
                      );
                      $this->Product_model->insertSellerNotify($sellerNotify); */


                    $i++;
                }
                $this->Rfqs_model->updaterfq($rfqs_id);

                $this->Rfqs_model->addRfqToSuppliers($insertData);


                $success = '<div class="alert alert-success alert-dismissible">Requests forwarded successfully.
                            <button data-dismiss="alert" type="button" class="close" aria-label="Close">
									<span aria-hidden="true">&times;</span>
								</button>
							</div>';
                $this->session->set_flashdata("message", $success);
                $output["success"] = 1;
                echo json_encode($output);
            } else {
                echo json_encode($output);
            }
        } else {
            echo json_encode($output);
        }
    }

    function rfq_notify_to_seller($seller_id) {
        $this->load->model('Product_model');
        $this->load->library("Browser_notification");

        if (!empty($seller_id)) {
            $title = 'New RFQ !';
            $msg = 'You Have New RFQ Request!';
            $tag = 'atzart.com';
            $this->browser_notification->notifyseller($seller_id, $title, $msg, $tag);

            $sellerNotify = array(
                'title' => $title,
                'msg' => $msg,
                'type' => 'RFQ',
                'reference_id' => $seller_id,
                'status' => 'Received'
            );

            $this->Product_model->insertSellerNotify($sellerNotify);
        }
    }

}
