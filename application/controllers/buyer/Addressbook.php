<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Addressbook extends CI_Controller {

    public function __construct() {
        parent::__construct();
        if (!$this->session->userdata("user_logged_in")) {
            $error = "<div id='login-error' class='form-error notice notice-error'><span class='icon-notice icon-error'></span><span><strong>Error!</strong> Session timeout, relogin!. </span></div>";
            $this->session->set_flashdata("message", $error);
            redirect("login", "refresh");
        }
        $this->load->model('Users_model');
        $this->load->model('Common_model');
        $this->load->model('Shipping_model');
        $this->load->helper('form');
        $this->load->library("form_validation");
        $this->load->library("get_header_data");
        $this->load->library("Send_data");
        $this->load->library("Shiprocket");
    }

    public function index() {
        $user = $this->session->userdata("user_id");
        $data = $this->get_header_data->get_categories();
        $data["addresses"] = $this->Users_model->getAddressBook($user);
        $data["title"] = "ATZCart - Shipping Address";
        $this->load->view("user/addressbook/list", $data);
    }

    public function addnew() {
        $data = $this->get_header_data->get_categories();
        $this->form_validation->set_rules("contact_person", "Contact Person", "required");
        $this->form_validation->set_rules("contact_number", "Contact Number", "required|regex_match[/^[0-9]{10}$/]");
        $this->form_validation->set_error_delimiters('<p style="color:red" class="text-left">', '</p>');
        $this->form_validation->set_rules("street1", "street1", "required");
        $this->form_validation->set_rules("street2", "street2", "required");
        $this->form_validation->set_rules("postal_code", "postal_code", "required");
        $this->form_validation->set_rules("country", "country", "required");
        $this->form_validation->set_rules("state", "state", "required");
        $this->form_validation->set_rules("city", "city", "required");
        $this->form_validation->set_rules("tag", "tag", "required");


        if ($this->form_validation->run() === false) {
            $data["title"] = "ATZCart - Add new address book";
            $countries = $this->Common_model->getAll("country")->result();
            $data["countries"] = [];
            foreach ($countries as $country):
                $data["countries"][$country->id] = $country->name;
            endforeach;
            $data["tags"] = [
                "Business" => "Business",
                "Factory" => "Factory",
                "Residential" => "Residential",
                "Werehouse" => "Werehouse",
            ];
            $this->load->view("user/addressbook/create", $data);
        }else {
            $ship_method = $this->send_data->get_shipping_method();
            if ($ship_method == 1) {
                $check_postcode = $this->Shipping_model->get_buyer_area($this->input->post("postal_code"));
                if (empty($check_postcode)) {
                    $message = '<div class="alert alert-danger alert-dismissible">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                            <strong>Error!</strong> Not Deliverable Pincode.
                        </div>';
                    $this->session->set_flashdata("message", $message);
                    redirect("buyer/addressbook/addnew", "refresh");
                    exit;
                }
            }
            if ($ship_method == 2) {
                $seller_pincode = 411057;
                $buyer_pincode = $this->input->post("postal_code");

                $res = $this->shiprocket->serviceability($seller_pincode, $buyer_pincode, 1, 0.5, 0.5, 0.5, 1);

                if ($res['status'] != 200) {
                    $message = '<div class="alert alert-danger alert-dismissible">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                            <strong>Error!</strong> Not Deliverable Pincode.
                        </div>';
                    $this->session->set_flashdata("message", $message);
                    redirect("buyer/addressbook/addnew", "refresh");
                    exit;
                }
            }

            $user = $this->session->userdata("user_id");
            $insertData = [
                "user_id" => $user,
                "contact_person" => htmlentities($this->input->post("contact_person")),
                "contact_number" => htmlentities($this->input->post("contact_number")),
                "street" => htmlentities($this->input->post("street1")),
                "suburb" => htmlentities($this->input->post("street2")),
                "postcode" => htmlentities($this->input->post("postal_code")),
                "city" => htmlentities($this->input->post("city")),
                "state" => htmlentities($this->input->post("state")),
                "country" => htmlentities($this->input->post("country")),
                "is_default" => 0,
                "tag" => htmlentities($this->input->post("tag")),
            ];
            $address_id = $this->Users_model->addAddressBook($insertData);
            $message = '<div class="alert alert-success alert-dismissible">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                            <strong>Success!</strong> Address added successfully.
                        </div>';
            $this->session->set_flashdata("message", $message);
            redirect("buyer/addressbook", "refresh");
        }
    }

    function add_address_ajax() {
        $user = $this->session->userdata("user_id");
        $contact_person = htmlentities($this->input->post("contact_person"));
        $contact_number = htmlentities($this->input->post("contact_number"));
        $street = htmlentities($this->input->post("street1"));
        $postcode = htmlentities($this->input->post("postal_code"));
        $city = htmlentities($this->input->post("city"));
        $state = htmlentities($this->input->post("state"));
        $country = htmlentities($this->input->post("country"));
        $tag = htmlentities($this->input->post("tag"));

        $ship_method = $this->send_data->get_shipping_method();

        if (empty($contact_person)) {
            echo 'Contact Person Is Required !';
            exit;
        }
        if (empty($contact_number)) {
            echo 'Contact Number Is Required !';
            exit;
        }
        if (!is_numeric($contact_number)) {
            echo 'Enter Valid Contact Number ';
            exit;
        }
        if (((int) strlen($contact_number) != 10)) {
            echo 'Mobile Number Must Be of 10 Digit';
            exit;
        }
        if (empty($street)) {
            echo 'Street Is Required !';
            exit;
        }
        if (empty($city)) {
            echo 'City Is Required !';
            exit;
        }
        if (empty($state)) {
            echo 'State Is Required !';
            exit;
        }

        if (empty($country)) {
            echo 'Country Is Required !';
            exit;
        }


        if (empty($postcode)) {
            echo 'Postcode Is Required !';
            exit;
        }

        if ((!is_numeric($postcode)) || (strlen($postcode) != 6)) {
            echo 'Enter Valid PostCode ';
            exit;
        }
        if ($ship_method == 1) {
            $check_postcode = $this->Shipping_model->get_buyer_area($postcode);
            if (empty($check_postcode)) {
                echo 'Not Deliverble Pincode';
                exit;
            }
        }
        if ($ship_method == 2) {
            $seller_pincode = 411057;

            $res = $this->shiprocket->serviceability($seller_pincode, $postcode, 1, 0.5, 0.5, 0.5, 1);

            if ($res['status'] != 200) {
                echo 'Not Deliverble Pincode';
                exit;
            }
        }


        $insertData = [
            "user_id" => $user,
            "contact_person" => htmlentities($this->input->post("contact_person")),
            "contact_number" => htmlentities($this->input->post("contact_number")),
            "street" => htmlentities($this->input->post("street1")),
            "postcode" => htmlentities($this->input->post("postal_code")),
            "city" => htmlentities($this->input->post("city")),
            "state" => htmlentities($this->input->post("state")),
            "country" => htmlentities($this->input->post("country")),
            "is_default" => 0,
            "tag" => htmlentities($this->input->post("tag")),
        ];
        $address_id = $this->Users_model->addAddressBook($insertData);

        if ($address_id) {
            echo 1;
        }
    }

    function all_user_address() {
        $user = $this->session->userdata("user_id");
        $str = '';
        $user_addr = $this->Common_model->getAll('address_book', array('user_id' => $user))->result_array();

        $i = 1;
        foreach ($user_addr as $addr) {

            $str.='<div class="col-md-12 input-group" style="width: 265px; padding: 9px;">';
            $str.='<input type="radio" onclick="check_returnable();" name="shipp_addr"  id="shipp_addr" value="' . $addr["address_book_id"] . '"';
            if ($addr["is_default"] == 1) {
                $str.='checked="checked"';
            }
            $str.='required>';
            $str.='<span style="margin-top:-5px; margin-left:10px;">' . $addr['contact_person'] . ',' .
                    $addr["street"] . '<br>' .
                    $addr["city"] . ',' . $addr['state'] . '<br>India' . ',' . $addr['postcode'] . '</span>
            </div>';
        }
        $str.='<hr style="margin-top:-10px;">
                                               <p id="ch_return" style="margin-top:-50px;"></p><br>' . '<a class="btn btn-danger btn-outline-danger btn-sm" data-toggle="modal" data-target="#ship_address">Add Shipping Address</a>';
        echo $str;
    }

    public function edit($id = 0) {
        $data = $this->get_header_data->get_categories();
        $user = $this->session->userdata("user_id");
        $address = $this->Users_model->getAddressBookById($id);
        if ($address && $address->user_id == $user) {
            //$this->form_validation->set_rules("id","id","required");
            $this->form_validation->set_error_delimiters('<p style="color:red" class="text-left">', '</p>');
            $this->form_validation->set_rules("contact_person", "Contact Person", "required");
            $this->form_validation->set_rules('contact_number', 'Mobile Number ', 'required|regex_match[/^[0-9]{10}$/]', ['regex_match' => 'Please Enter The Valid Mobile Number']);
            $this->form_validation->set_rules("street1", "street1", "required");
            $this->form_validation->set_rules("street2", "street2", "required");
            $this->form_validation->set_rules("postal_code", "postal_code", "required");
            $this->form_validation->set_rules("country", "country", "required");
            $this->form_validation->set_rules("state", "state", "required");
            $this->form_validation->set_rules("city", "city", "required");
            $this->form_validation->set_rules("tag", "tag", "required");
            if ($this->form_validation->run() === false) {
                $data["title"] = "ATZCart - Edit new address book";
                $data["details"] = $address;
                $data["id"] = $id;
                $countries = $this->Common_model->getAll("country")->result();
                $data["countries"] = [];
                foreach ($countries as $country):
                    $data["countries"][$country->id] = $country->name;
                endforeach;
                $data["tags"] = [
                    "Business" => "Business",
                    "Factory" => "Factory",
                    "Residential" => "Residential",
                    "Werehouse" => "Werehouse",
                ];
                $this->load->view("user/addressbook/edit", $data);
            } else {
                $ship_method = $this->send_data->get_shipping_method();
                if ($ship_method == 1) {
                    $check_postcode = $this->Shipping_model->get_buyer_area($this->input->post("postal_code"));
                    if (empty($check_postcode)) {
                        $message = '<p style="color:red" class="text-left"> Not Deliverable Pincode.
                        </p>';
                        $this->session->set_flashdata("message", $message);
                        redirect("buyer/addressbook/edit/$id", "refresh");
                        exit;
                    }
                }

                $updateData = [
                    "user_id" => $user,
                    "contact_person" => htmlentities($this->input->post("contact_person")),
                    "contact_number" => htmlentities($this->input->post("contact_number")),
                    "street" => htmlentities($this->input->post("street1")),
                    "suburb" => htmlentities($this->input->post("street2")),
                    "postcode" => htmlentities($this->input->post("postal_code")),
                    "city" => htmlentities($this->input->post("city")),
                    "state" => htmlentities($this->input->post("state")),
                    "country" => htmlentities($this->input->post("country")),
                    "is_default" => 0,
                    "tag" => htmlentities($this->input->post("tag")),
                ];
                $address_id = $this->Users_model->updateAddressBook($id, $updateData);
                $message = '<div class="alert alert-success alert-dismissible">
                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                <strong>Success!</strong> Address Edited successfully.
                            </div>';
                $this->session->set_flashdata("message", $message);
                redirect("buyer/addressbook", "refresh");
            }
        } else {
            $message = '<div class="alert alert-danger alert-dismissible">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                            <strong>Error!</strong> Please select valid address.
                        </div>';
            $this->session->set_flashdata("message", $message);
            redirect("buyer/addressbook", "refresh");
        }
    }

    public function remove($id = 0) {

        $address = $this->Users_model->getAddressBookById($id);
        $user = $this->session->userdata("user_id");
        if ($address && $address->user_id == $user) {
            $this->Users_model->removeAddress($id);
            $message = '<div class="alert alert-success alert-dismissible">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                            <strong>Success!</strong> Address removed successfully.
                        </div>';
            $this->session->set_flashdata("message", $message);
            redirect("buyer/addressbook", "refresh");
        } else {
            $message = '<div class="alert alert-danger alert-dismissible">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                            <strong>Success!</strong> Please select valid address.
                        </div>';
            $this->session->set_flashdata("message", $message);
            redirect("buyer/addressbook", "refresh");
        }
    }

    public function setdefault($id) {

        $address = $this->Users_model->getAddressBookById($id);
        $user = $this->session->userdata("user_id");
        if ($address && $address->user_id == $user) {
            $this->Users_model->setDefaultAddress($user, $id);
            $message = '<div class="alert alert-success alert-dismissible">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                            <strong>Success!</strong> Successfully set as default.
                        </div>';
            $this->session->set_flashdata("message", $message);
            redirect("buyer/addressbook", "refresh");
        } else {
            $message = '<div class="alert alert-danger alert-dismissible">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                            <strong>Success!</strong> Please select valid address.
                        </div>';
            $this->session->set_flashdata("message", $message);
            redirect("buyer/addressbook", "refresh");
        }
    }

}
