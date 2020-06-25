<?php $this->load->view('front/common/header'); ?>
<style>

    .btnCss{
        padding : 15px 0px 0px 0px;
        border-radius : 2px;
    }

    .btnCss .btn{
        font-size: 1em;
        color: #fff;
        background:linear-gradient(40deg,#FF5858,#ee4392);			
        outline: none;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        border-bottom: 2px solid #0d002b;
    }


    .d-flex {
        display: flex !important;
    }

    .card
    {
        box-shadow: 0 3px 20px 0px rgba(0, 0, 0, 0.1);
        margin:6rem auto;
    }


    body{
        background: url('<?php echo base_url(); ?>assets/front/images/banner/affilatepasword.jpg') !important;
        background-repeat:no-repeat !important;
        background-size:100% !important;
        background-position:center center !important;

    }

</style>


<div class="container" >	  	     
    <div class="row full-height-vh m-0 d-flex  align-middle align-items-center justify-content-center">	 
        <div class="col-lg-5 col-sm-12"> 		 
            <div class="card text-center">
                <div class="card-content">
                    <div class="card-body fg-image">
                        <div class="row">					 
                            <div class="col-lg-12 col-md-12 bg-white px-4 py-5">
                                <form action = "" class="form-group">			
                                    <div id="messege"></div>
                                    <div class="" >
                                        <h1> Forgot Password? </h1>
                                        <p id="lable_name">Enter Email / Mobile Number</p>
                                    </div>

                                    <div class="form-group mx-4" id="email_div">
                                        <input type="text" name="username" id="username" class="form-control" placeholder="Enter Email / Mobile" required>

                                        <div style="color:red" id="email_error"></div>
                                    </div>
                                    <div id="show_div" class="mx-4 my-3">
                                        <input type="text" name="otp" class="ui-input form-control"  placeholder="Enter Your OTP" value="" id = "otp" class="form-control" required>
                                    </div>
                                    <div class="btnCss mx-5">
                                        <input type= "button" value="Request For OTP " class="btn btn-danger " id="btnGetOtp">
                                        <input type="button" value=" Submit " class="btn btn-danger " id="submit_button" onclick = "submit_form()" >
                                    </div>	
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>		   
    </div>
</div>
<?php $this->load->view('front/common/footer'); ?>
<script>

    $(document).on("click", "div.alert .close", function () {
        $("div.alert").hide();
    });

    $(document).ready(function () {

        $('#show_div').hide();
        $('#email_div').show();
        $('#submit_button').hide();
        var func_call = 0;
        $("#btnGetOtp").click(function () {
            func_call++;

            var username = $("#username").val();
            if (username != "") {
                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url(); ?>affiliate/login/ajaxSendOtp",
                    data: {username: username},
                    success: function (resp) {
                        var data = JSON.parse(resp);
                        $('#email_error').text("");
                        if (data.status == 0) {
                            $("#messege").html("<div class='alert alert-danger alert-dismissible'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><strong>Error!</strong> Invalid Email.</div>");
                            
                        } else if (data.status == 1) {

                            if (func_call == 1)
                            {
                                $("#messege").html("<div class='alert alert-success alert-dismissible'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><strong>Success!</strong> OTP sent successfully! </div>");
                            } else {
                                $("#messege").html('<div class="alert alert-success alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Success!</strong> OTP resent successfully! </div>');
                            }


                            $("#info_text").text("Enter Otp");
                            $('#show_div').show();
                            $('#email_div').hide();
                            $("#btnGetOtp").prop('value', 'Resend OTP');
                            $("#lable_name").text('Please Enter OTP :');
                            $('#submit_button').show();

                        } else if (data.status == 2) {
                            $("#messege").html('<div class="alert alert-danger alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Error!</strong> This Email / mobile number is not registered.</div>');
                        }
                    },
                });
            } else {
                $('#email_error').text("Enter email or mobile number");
            }
        });
    });

    function submit_form()
    {
        var username = $("#username").val();
        var otp = $("#otp").val();
        if(otp != '')
        {
            $('#otp').css("");
            $.ajax({
                type: "POST",
                url: "<?php echo base_url(); ?>affiliate/login/forgotPassword",
                data: {username: username, otp: otp},
                success: function (resp) {
                    var data = JSON.parse(resp);
                    if (data.status == 0) {
                        $("#messege").html('<div class="alert alert-danger alert-dismissible">' +
                                '<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>' +
                                '<strong>Error!</strong> Invalid otp.' +
                                '</div>');
                    } else {
                        window.location.href = "<?php echo base_url(); ?>affiliate/login/resetPassword";
                    }
                },
            });
        }else{
             $('#otp').css("border","1px solid red");
        }
    }
     </script>
