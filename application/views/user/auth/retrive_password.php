<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title><?php
            if (isset($title)) {
                echo $title;
            } else {
                echo "Atzcart || Suppliers";
            }
            ?></title>
        <link rel="icon" href="<?php echo base_url(); ?>assets/admin/images/favicon.ico" type="image/x-icon">

        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/front/css/bootstrap.min.css">

        <style>
            @import url(<?php echo base_url(); ?>assets/admin/css/form.css);
            html, body{
                height:100%;
            }

            .navbar-expand-lg {
                box-shadow: 1px 1px 3px #ccc;
            }

            .btnCss{
                padding : 15px 0px 0px 0px;
                border-radius : 2px;
            }

            .btnCss .btn{
                font-size: 1em;
                color: #fff;
                background: #0086E5;			
                outline: none;
                border: none;
                border-radius: 5px;
                cursor: pointer;
                border-bottom: 3px solid #045B99;
            }

            .header-nav a:hover{
                color:red;
            }
            .align-items-center {
                align-items: center !important;
            }
            .justify-content-center {
                justify-content: center !important;
            }
            .d-flex {
                display: flex !important;
            }

            .full-height-vh {
                height:100%;
            }
            .card
            {
                box-shadow: 0 3px 20px 0px rgba(0, 0, 0, 0.1);
                margin:6rem auto;
            }
            a.nav-link
            {
                color:#000 !important;
            }

            .nav-item a:hover{
                color:red !important;
            }

            body{
                background-image: url("<?php echo base_url(); ?>assets/images/pasword-bg-4.jpg");
                background-repeat:no-repeat;
                background-size:cover;
                background-position:right center;

            }

        </style>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/front/css/bootstrap.min.css">
       <!--  <script type="text/javascript" src="<?php echo base_url(); ?>assets/admin/js/jquery.validate.min.js"></script> -->

    </head>
    <body>

        <nav class="navbar navbar-expand-lg navbar-dark navbar-light static-top" style="background:#fff">
            <div class="container">
                <a class="navbar-brand" href="<?php echo base_url(); ?>"><img src="<?php echo base_url(); ?>assets/admin/images/logo.png" width="180">
                </a>

                <div class="collapse navbar-collapse" id="navbarResponsive">
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item active">
                            <a class="nav-link" href="<?php echo base_url(); ?>signup" > Join </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo base_url(); ?>login" target="_blank"> Sign In </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo base_url(); ?>"> Home Page </a>		  
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <div class="container" >	  	     
            <div class="row full-height-vh m-0 d-flex  align-middle align-items-center justify-content-center">	 
                <div class="col-lg-5 col-sm-12"> 		 
                    <div class="card text-center">
                        <div class="card-content">
                            <div class="card-body fg-image">
                                <div class="row">					 
                                    <div class="col-lg-12 col-md-12 bg-white px-4 py-5">
                                        <form action = "" method="post" class="form-group">			
                                            <div id="messege"></div>
                                            <div class="" >
                                                <h1> Forgot Password? </h1>
                                                <p id="lable_name">Enter Email / Mobile Number</p>
                                            </div>

                                            <div class="form-group mx-4" id="email_div">
                                                <input type="text" name="username" id="username" class="form-control" placeholder="Enter Email / Mobile" required>

                                                <div style="color:red" id="email_error"><?php echo form_error('username'); ?></div>
                                            </div>
                                            <div id="show_div" class="mx-4 my-3">
                                                <input type="text" name="otp" class="ui-input form-control"  placeholder="Enter Your OTP" value="<?php echo set_value("otp"); ?>" id = "otp" class="form-control" required>
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
                            url: "<?php echo site_url(); ?>login/ajax_send_otp",
                            data: {username: username},
                            success: function (resp) {
                                var data = JSON.parse(resp);
                                console.log(data.status);
                                console.log(data);
                                $('#email_error').text("");
                                if (data.status == 0) {
                                    $('#email_error').text("Invalid Email!");
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
                if(otp != "")
                {
                    $.ajax({
                        type: "POST",
                        url: "<?php echo site_url(); ?>forgot-password",
                        data: {username: username, otp: otp},
                        success: function (resp) {
                            var data = JSON.parse(resp);
                            console.log(data);
                            if (data.status == 0) {
                                $("#messege").html('<div class="alert alert-danger alert-dismissible">' +
                                        '<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>' +
                                        '<strong>Error!</strong> Invalid otp.' +
                                        '</div>');
                            } else {
                                window.location.href = "<?php echo site_url(); ?>reset-password";
                            }
                        },
                    });
                } else {
                    $("#otp").css("border", "1px solid red");
                }
            }
        </script>
    </body>
</html>