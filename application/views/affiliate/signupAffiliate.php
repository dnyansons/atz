<?php $this->load->view("front/common/header"); ?>       
<style>
    .login_btn {
        -webkit-box-shadow: 0 2px 5px 0 rgba(0,0,0,.16), 0 2px 10px 0 rgba(0,0,0,.12);
        box-shadow: 0 2px 5px 0 rgba(0,0,0,.16), 0 2px 10px 0 rgba(0,0,0,.12);
        padding: .84rem 2.14rem;
        font-size: .81rem;
        -webkit-transition: color .15s ease-in-out,background-color .15s ease-in-out,border-color .15s ease-in-out,-webkit-box-shadow .15s ease-in-out;
        -o-transition: color .15s ease-in-out,background-color .15s ease-in-out,border-color .15s ease-in-out,box-shadow .15s ease-in-out;
        transition: color .15s ease-in-out,background-color .15s ease-in-out,border-color .15s ease-in-out,box-shadow .15s ease-in-out;
        transition: color .15s ease-in-out,background-color .15s ease-in-out,border-color .15s ease-in-out,box-shadow .15s ease-in-out,-webkit-box-shadow .15s ease-in-out;
        margin: .375rem;
        border: 0;
        -webkit-border-radius: .125rem;
        border-radius: 1.5rem;
        cursor: pointer;
        text-transform: uppercase;
        white-space: normal;
        word-wrap: break-word;
        color: inherit;
        background:#fff;
        width:200px !important;
    }

    .btn.pink-gradient {
        background: -webkit-linear-gradient(50deg,#FF5858,#ee4392);
        background: -o-linear-gradient(50deg,#FF5858,#ee4392);
        background: linear-gradient(40deg,#FF5858,#ee4392);
        color:#fff;
    }
    .user_card {
        height: 400px;
        width: 400px;		
        margin: 100px auto;
        background: #fff;
        position: relative;
        display: flex;
        justify-content: center;
        flex-direction: column;
        padding: 10px;
        box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
        -webkit-box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
        -moz-box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
        border-radius: 5px;

    }

    .login_btn {
        width: 100%;
        background: #c0392b !important;
        color: white !important;
    }
    .login_btn:focus {
        box-shadow: none !important;
        outline: 0px !important;
    }
    .login_container {
        padding: 0 2rem;
    }
    .input-group-text {
        background: #c0392b !important;
        color: white !important;
        border: 0 !important;
        border-radius: 0.25rem 0 0 0.25rem !important;
    }
    .input_user,
    .input_pass:focus {
        box-shadow: none !important;
        outline: 0px !important;
    }
    .custom-checkbox .custom-control-input:checked~.custom-control-label::before {
        background-color: #c0392b !important;
    }
	body{background:#fff !important}
</style>

<div class="container mb-5">
<div class="row">
<div class="col-9 m-auto">
    <form action="" method="POST" name = "affiliateSignup" id="affiliateSignup">
        <div class="card mt-4">
            <div class="card-header">
                <h6 class="h5 ">General Information</h6>		
            </div>
            <div class="card-body ">
                <div class="row ">
                    <div class="col-lg-6 col-xs-12 col-sm-6">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Full Name <span style = "color:red">*</span></label>
                            <input type="text" class="form-control" name="fullname" maxlength = "50" placeholder="Full Name" value ="<?php echo set_value("fullname"); ?>" onkeypress= " return restrictNumber(event)">
                            <?php echo form_error("fullname"); ?>
                        </div>
                    </div>

                    <div class="col-lg-offset-0 col-lg-6 col-xs-12 col-sm-6">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Company Name <span style = "color:red">*</span></label>
                            <input type="text" class="form-control" name="companyname" placeholder="Company Name" value ="<?php echo set_value("companyname"); ?>" onkeypress= " return restrictNumber(event)" maxlength = "50">
                            <?php echo form_error("companyname"); ?>
                        </div>
                    </div>

                    <div class="col-lg-offset-0 col-lg-6 col-xs-12 col-sm-6">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Phone No. <span style = "color:red">*</span></label>
                            <input type="text" class="form-control" placeholder="Phone Number" name="mobilenumber" maxlength = "15" value ="<?php echo set_value("mobilenumber"); ?>" onkeypress="return restrictAlphabates(event)">
                            <?php echo form_error("mobilenumber"); ?>
                        </div>
                    </div>
                </div>
                <hr class="m-3 p-0">
                <div class="row">	   
                    <div class="col-lg-offset-0 col-lg-6 col-xs-12 col-sm-6">
                        <div class="form-group">
                            <label for="exampleInputEmail1">E-Mail <span style = "color:red">*</span></label>
                            <input type="email" class="form-control txt_box" name="email" placeholder="Email" value ="<?php echo set_value("email"); ?>" >
                            <?php echo form_error("email"); ?>
                        </div>
                    </div>

                    <div class="col-lg-offset-0 col-lg-6 col-xs-12 col-sm-6"></div>

                    <div class="col-lg-offset-0 col-lg-6 col-xs-12 col-sm-6">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Password <span style = "color:red">*</span></label>
                            <input type="password" class="form-control" placeholder="Password" name="password" value ="<?php echo set_value("password"); ?>" >
                            <?php echo form_error("password"); ?>
                        </div>
                    </div>


                    <div class="col-lg-offset-0 col-lg-6 col-xs-12 col-sm-6">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Confirm-Password <span style = "color:red">*</span></label>
                            <input type="password" class="form-control" placeholder="Confirm Password" name="confirmpassword" value ="<?php echo set_value("confirmpassword"); ?>">
                            <?php echo form_error("confirmpassword"); ?>
                        </div>
                    </div>		  
                </div>
            </div>
        </div>


        <div class="card mt-4">
            <div class="card-header">
                <h6 class="h5">Site Information</h6>
            </div>
            <div class="card-body">
                <div class="row">	   
                    <div class="col-lg-offset-0 col-lg-6 col-xs-12 col-sm-6">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Site Name <span style = "color:red">*</span></label>
                            <input type="text" class="form-control" placeholder="xyz pvt ltd" name="sitename" value ="<?php echo set_value("sitename"); ?>">
                            <?php echo form_error("sitename"); ?>
                        </div>
                    </div>  


                    <div class="col-lg-offset-0 col-lg-6 col-xs-12 col-sm-6">
                        <div class="form-group">
                            <label for="exampleInputEmail1">URL <span style = "color:red">*</span></label>
                            <input type="text" class="form-control" placeholder="https://www.example.com" name="siteurl" value ="<?php echo set_value("siteurl"); ?>">
                            <?php echo form_error("siteurl"); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mt-4">
            <div class="card-header">
                <h6 class="h5">Payment Detail</h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-offset-0 col-lg-6 col-xs-12 col-sm-6">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Beneficiary Name <span style = "color:red">*</span></label>
                            <input type="text" class="form-control" placeholder="Beneficiary Name" name="benfryname" value ="<?php echo set_value("benfryname"); ?>" >
                            <?php echo form_error("benfryname"); ?>
                        </div>
                    </div>
                    <div class="col-lg-offset-0 col-lg-6 col-xs-12 col-sm-6">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Account Number <span style = "color:red">*</span></label>
                            <input type="text" class="form-control" placeholder="Account Number" name="accno" value ="<?php echo set_value("accno"); ?>" >
                            <?php echo form_error("accno"); ?>
                        </div>
                    </div>

                    <div class="col-lg-offset-0 col-lg-6 col-xs-12 col-sm-6">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Bank Name <span style = "color:red">*</span></label>
                            <input type="text" class="form-control" placeholder="Bank Name" name="bankname" value ="<?php echo set_value("bankname"); ?>" >
                            <?php echo form_error("bankname"); ?>
                        </div>
                    </div>
                    <div class="col-lg-offset-0 col-lg-6 col-xs-12 col-sm-6">
                        <div class="form-group">
                            <label for="exampleInputEmail1">IFSC Code <span style = "color:red">*</span></label>
                            <input type="text" class="form-control" placeholder="IFSC Code" name="ifsccode" value ="<?php echo set_value("ifsccode"); ?>" >
                            <?php echo form_error("ifsccode"); ?>
                        </div>
                    </div>		  
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-lg-offset-0 col-lg-12 col-xs-12">
                <div class="checkbox">
                    <label>
                        <input type="checkbox" name="termscondition" id="termscondition" value="agreed" >
                        <a href="<?php echo base_url(); ?>affiliate/signup/termsConditions" style="color:blue">I agree with Terms and conditions.</a> <span id="errorTerm" style="color:red"> </span> 
                    </label>
                </div>
            </div>

            <div class="col-lg-offset-0 mt-2 col-lg-12 col-xs-12">
                <div class="checkbox">
                    <label>
                        <input type="checkbox" name="programEmails"  id="programEmails" value="agreed">
                        I agree to receive email from ATZ CART Affiliate Program. <span id="errorEmail" style="color:red"> </span>
                    </label>
                </div>
            </div>
        </div><!--/ Row-->

        <hr class="my-4">
        <button type="button" class="btn login_btn" id="submit_button"> Submit</button>    
    </form>
	</div>
	</div>
</div>
<?php $this->load->view("front/common/footer"); ?>  
<script type="text/javascript">
    jQuery.validator.addMethod("lettersonly", function(value, element) 
    {
        return this.optional(element) || /^[a-z ]+$/i.test(value);
    }, "Letters and spaces only please");


    $(document).ready(function () {

        $("form[name='affiliateSignup']").validate({
            rules: {
                fullname: {
                    required: true,
                    lettersonly:"letters only"
                },
                email:{
                    required : true,
                    email : true
                },
                mobilenumber: {
                    required: true,
                    maxlength: 15,
                    digits: true
                },
                companyname: {
                    required: true,
                    lettersonly:"letters only"
                },
                password: {
                    required: true,
                    maxlength: 8,
                    minlength:6
                },
                confirmpassword: "required",
                
                sitename: {
                    required: true,
                    maxlength: 50,
                    lettersonly:"letters only"
                },
                siteurl: {
                    required: true,
                    maxlength: 50
                },
                benfryname: {
                    required: true,
                    maxlength: 50,
                    lettersonly:"letters only"
                },
                accno: {
                    required: true,
                    maxlength: 15,
                    digits: true
                },
                bankname: {
                    required: true,
                    maxlength: 50,
                    lettersonly:"letters only"
                },
                ifsccode: "required",
               
            },
            messages: {
                fullname: { required : "Full name is required.", lettersonly:"Enter only alphabates."},
                mobilenumber: { required: "Mobile number is required", digit :"Enter only numbers."},
                email: {
                    required: "Email is required",
                    email: "Enter valid email"
                },
                companyname: { required:"Company name is required", lettersonly:"Enter only alphabates."},
                sitename: { required:"Site Name is required.", lettersonly:"Enter only alphabates."},
                siteurl: "Site Url is required.",
                
                password: { required: "Password is required.", maxlength:"Password should be less than 8 characters",minlength:"password should be more than 6 characters."},
                confirmpassword: "Confirm your password.",
                benfryname: { required : "Beneficiary name is required.", lettersonly:"Enter only alphabates.", maxlength:"Beneficiary name should be less than 50 characters."},
                accno: { required : "Account number is required.", digit :"Enter only numbers.",maxlength:"Account number should be less than 15 numbers."},
                bankname: { required : "Bank name is required", lettersonly:"Enter only alphabates."},
                ifsccode: "IFSC code is required"
                
            },
            errorClass: "text-danger",
        });
    });
    
    $('#submit_button').click(function(e){
        if ($("#affiliateSignup").valid()) {
            if ($('#termscondition').prop("checked") == true && $('#programEmails').prop("checked")== true ){
                     $("#affiliateSignup").submit();
                } else {
                    $("#errorTerm").html("Must agree to Terms of Use.");
                    $("#errorEmail").html("Must agree to Terms of Use.");
                }
        } 
    });
    function restrictNumber(e) {
        var x = e.which || e.keycode;
        if ((x >= 65 && x <= 90) || (x >= 97 && x <= 122) || x == 8 || x == 32)
            return true;
        else
            return false;
    }

    function restrictAlphabates(e) {

        var x = e.which || e.keycode;
        if ((x >= 48 && x <= 57) || x == 8)
            return true;
        else
            return false;
    }

</script>