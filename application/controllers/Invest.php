<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Invest extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library("get_header_data");
    }

    public function index()
    {
        $this->form_validation->set_rules("name","Investor Name","required");
        $this->form_validation->set_rules("address1","Address 1","required");
        $this->form_validation->set_rules("address2","Address 2","required");
        $this->form_validation->set_rules("address3","Address 3","required");
        $this->form_validation->set_rules("email","Email","required|valid_email");
        $this->form_validation->set_rules("mobile","Mobile","required|numeric|min_length[10]|max_length[10]");
        $this->form_validation->set_rules("typeofowner","Type","required");
        $this->form_validation->set_rules("amount","amount","required|numeric");
        if($this->form_validation->run()===false){
            $data = $this->get_header_data->get_categories();
            $data["pageTitle"] = "Invest with atzcart";
            $this->load->view("front/investor_enquiry",$data);
        } else {

            ob_start();
            $name = $this->input->post("name");
            $address1 = $this->input->post("address1");
            $address2 = $this->input->post("address2");
            $address3 = $this->input->post("address3");
            $email = $this->input->post("email");
            $mobile = $this->input->post("mobile");
            $type = $this->input->post("typeofowner");
            $amount = $this->input->post("amount");
            $other = $this->input->post("other");
            $this->load->library('Pdf');
            $pdf = new Pdf(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

            // set document information
            $pdf->SetCreator(PDF_CREATOR);
            $pdf->SetAuthor('Nicola Asuni');
            $pdf->SetTitle('TCPDF Example 006');
            $pdf->SetSubject('TCPDF Tutorial');
            $pdf->SetKeywords('TCPDF, PDF, example, test, guide');

            // set default header data
            $pdf->SetHeaderData(base_url()."assets/front/images/logo/logo.png", 280, "Atzcart ", "Investor inquiry form");

            // set header and footer fonts
            $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
            $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

            // set default monospaced font
            $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

            // set margins
            $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
            $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
            $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

            // set auto page breaks
            $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

            // set image scale factor
            $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

            // set some language-dependent strings (optional)
            if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
                require_once(dirname(__FILE__).'/lang/eng.php');
                $pdf->setLanguageArray($l);
            }

            // ---------------------------------------------------------

            // set font
            $pdf->SetFont('dejavusans', '', 10);

            $pdf->AddPage();

            // create some HTML content
            $html = '<div style="text-align:center; text-decoration:underline;"><h1>INVESTOR INTEREST FORM</h1></div>
            <div style="text-align:center"><h2>INVESTOR INFORMATION</h2></div>
            Name of investor: '.$name.'<br /><br />
            Address :'.$address1.' '.$address2.' '.$address3.'<br /><br />
            Mobile Number:'.$mobile.'<br /><br />
            Email ID::'.$email.'<br /><br />
            Type of owner or form of ownership:'.$type.'<br /><br />
            If Other:'.$other.'<br /><br />
            Investing Amount:'.$amount.'<br /><br />';


            // output the HTML content
            $pdf->writeHTML($html, true, false, true, false, '');

            // - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

            // reset pointer to the last page
            $pdf->lastPage();

            // ---------------------------------------------------------

            //Close and output PDF document
            ob_clean();
            $filename = $_SERVER["DOCUMENT_ROOT"]."uploads/enquiries/enquiry.pdf";

            $fileatt = $pdf->Output($filename, 'F');

            //$attachment = chunk_split( base64_encode(file_get_contents($filename)) );
            $from = $this->config->item("default_email_from");
            $this->load->library('email');
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
            $this->email->set_newline("\r\n");
            $this->email->from($from, 'Atzcart investor enquiry');
            $this->email->to("yksheikh@ayninfotech.com");
            //$this->email->bcc("surajhingane@ayninfotech.com");
            $this->email->attach($filename);
            $this->email->subject('Investor enquiry');
            $this->email->message($html);
            $this->email->send();
            $this->email->clear();
            
            $this->email->set_newline("\r\n");
            $this->email->from($from, 'Atzcart');
            $this->email->to($email);
            $this->email->subject('Enquiry recieved');
            $html = $this->load->view("emailtemplates/investorenquiryreply","",true);
            $this->email->message($html);
            $this->email->send();
            
            
            $msg = '<div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>Dear Investor!</strong> Thank you for showing your interest by investing with ATZ CART. 
                    Our consulting representatives will give you contact you for further communication.
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>';
            $this->session->set_flashdata("msg",$msg);
            redirect("invest","refresh");
        }

    }

    public function test()
    {
        echo __DIR__;
    }
}

