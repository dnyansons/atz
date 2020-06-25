<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="google-site-verification" content="nP5Df-TYNWX_nGB7Qum5d5I4cXzd3E7A2TXtZ0Y2x_Q" /> 
        <title><?php if (isset($title)) {
    echo $title;
} else {
    echo "Atzcart || Suppliers";
} ?></title>
        <link rel="icon" href="<?php echo base_url(); ?>assets/admin/images/favicon.ico" type="image/x-icon">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/mobile/css/bootstrap.min.css">
        <style>
            @import url(<?php echo base_url(); ?>assets/admin/css/form.css);
            .icon-error {
                width: 14px;
                height: 14px;
                background-position: -30px -34px;
            }
            .outerBorder {
                border : 1px solid grey;
                margin-top : 60px;
                padding : 10px 25px 40px 0px;
                box-shadow : 2px 0px 2px 0px;
            }
            .textWidth{
                width: 550px;
            }

            .btnCss{
                padding : 20px 0px 0px 0px;
                border-radius : 2px;

            }
            .otpfield{
                padding : 20px 35px 0px 0px;
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
                height:85vh !important;
            }
            .card
            {
                box-shadow: 0 3px 20px 0px rgba(0, 0, 0, 0.1);
            }
            a.nav-link
            {
                color:#000 !important;
            }

            .nav-item a:hover{
                color:red !important;
            }

        </style>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/front/css/bootstrap.min.css">
       <!--  <script type="text/javascript" src="<?php //echo base_url(); ?>assets/admin/js/jquery.validate.min.js"></script> -->
                <!-- Global site tag (gtag.js) - Google Analytics -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=UA-144123824-1"></script>
        <script>
          window.dataLayer = window.dataLayer || [];
          function gtag(){dataLayer.push(arguments);}
          gtag('js', new Date());

          gtag('config', 'UA-144123824-1');
        </script>

        <script>
        !function(f,b,e,v,n,t,s)
        {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
        n.callMethod.apply(n,arguments):n.queue.push(arguments)};
        if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
        n.queue=[];t=b.createElement(e);t.async=!0;
        t.src=v;s=b.getElementsByTagName(e)[0];
        s.parentNode.insertBefore(t,s)}(window,document,'script',
        'https://connect.facebook.net/en_US/fbevents.js');
         fbq('init', '318941032348543'); 
        fbq('track', 'PageView');
        </script>

        <noscript>
         <img height="1" width="1" 
        src="https://www.facebook.com/tr?id=318941032348543&ev=PageView
        &noscript=1"/>
        </noscript>
        <!-- End Facebook Pixel Code -->

        <!-- Global site tag (gtag.js) - Google Ads: 728750276 -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=AW-728750276"></script>
        <script>
         window.dataLayer = window.dataLayer || [];
         function gtag(){dataLayer.push(arguments);}
         gtag('js', new Date());

         gtag('config', 'AW-728750276');
        </script>
    </head>
    <body>

        <nav class="navbar navbar-expand-lg navbar-dark navbar-light static-top" style="background:#ccc">
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
            <div class="row full-height-vh m-0 d-flex align-items-center justify-content-center">	 
                <div class="col-lg-5 col-sm-12"> 		 
                    <div class="card">
                        <div class="card-content">
                            <div class="card-body fg-image">
                                <div class="row">					 
                                    <div class="col-lg-12 col-md-12 bg-white px-4 pt-3">
                                        <form action = "#" method="post" class="form-group" name="forgot_pass">			
                                            <div id="messege"></div>
                                            <div class="pb-4" >
                                                <h4> Forgot Password? </h4>
                                                <span> Enter Registered Email Address or Mobile Number to Reset Your Password.</span>
                                            </div>

                                            <div class=" form-group" id="email_div">
                                                <input type="text" name="username" id="username" class="form-control" placeholder="Enter Email / Mobile" required>
                                                <div style="color:red" id="email_error"><?php echo form_error('username'); ?></div>
                                                <div class="btnCss">
                                                <input type = "button" value="Request OTP " class="btn btn-info btn-sm" id="btnGetOtp">
                                                </div>
                                            </div>
                                            
                                            <div id="show_div">
                                                <div id="otp_msg"></div>
                                                <div class="otpfield">
                                                    <label> Enter OTP: </label>
                                                    <input type="text" name="otp" class="ui-input"  placeholder="Enter OTP" value="<?php echo set_value("otp"); ?>" id = "otp" pattern="{0,9}" required>
                                                </div>
                                                <div class="btnCss">
                                                    <input type="button" value="Submit" class="btn btn-danger btn-sm" id="submit_button" onClick="submit_form()">
                                                </div>
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
    </body>
</html>
<script>
    $(document).ready(function(){
        $("#show_div").hide();
        $("#btnGetOtp").on("click",function(){ 
            $("#email_div").show();
                    var username = $("#username").val();
                    if (username != "") {
                        $.ajax({
                            type: "POST",
                            url: "<?php echo site_url(); ?>m/signin/ajax_send_otp",
                            data: {username: username},
                            success: function (resp) {
                                var data = JSON.parse(resp);
                                $('#email_error').text("");
                                console.log(data);
                                //Email Status
                                if (data.status == 0) {
                                    $('#email_error').text("Invalid Email OR Mobile Number!");
                                } else if (data.status == 1 || data.status == 4) {
                                    $("#messege").html("<div class='alert alert-success'> <strong>Success!</strong> Check Your Email Or Mobile For OTP!</div>");
                                    $('#show_div').show();
                                    $("#username").prop('disabled',true);
                                    $("#btnGetOtp").show();
                                    $("#btnGetOtp").prop('value', 'Resend OTP');
                                    $('#submit_button').show();   
                                } else if (data.status == 2) {
                                    $("#messege").html("<div class='alert alert-danger'> <strong>Error!</strong>  Email Not Sent.</div>");
                                } else if(data.status == 5){
                                    $("#messege").html("<div class='alert alert-danger'> <strong>Error!</strong>  OTP Not Sent.</div>");
                                } else if(data.status == 6){
                                    $("#messege").html("<div class='alert alert-danger'> <strong>Error!</strong> Enter Register Mobile Number.</div>");
                                }else {
                                    $("#messege").html("<div class='alert alert-danger'> <strong>Error!</strong> Email Address is Not Registered.</div>");
                                }
                            },
                        });
                    } else {
                        $('#email_error').text("Email is required");
                    }
            })
        })
        
        function submit_form(){
                   
                   var username = $("#username").val();
                   var otp = $("#otp").val();
                   if(otp!="")
                   {
                    $.ajax({
                        type: "POST",
                        url: "<?php echo site_url(); ?>m/signin/forgot_password",
                        data: {username: username, otp: otp},
                        success: function (resp) {
                            var data = JSON.parse(resp);
                            console.log(data);
                            if (data.status == 0) {
                                $("#messege").html("<div class='alert alert-danger'> <strong>Error!</strong> Invalid OTP. </div>");
                            } else {
                                window.location.href = "<?php echo site_url(); ?>signin/reset-password";
                            }
                        },
                    });
                }else{
                     $("#otp_msg").html("<div class='alert alert-danger'><strong>Error!</strong> Please Enter OTP. </div>");
                }
        }
       
</script>