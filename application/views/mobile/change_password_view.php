<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="google-site-verification" content="nP5Df-TYNWX_nGB7Qum5d5I4cXzd3E7A2TXtZ0Y2x_Q" />
       
      <title><?php if(isset($pageTitle)){echo $pageTitle;}else{echo "Atzcart || Buyer";}?></title>
      <link rel="icon" href="<?php echo base_url(); ?>assets/admin/images/favicon.ico" type="image/x-icon">

      <style>
         @import url(<?php echo base_url();?>assets/admin/css/form.css);
         .icon-error {
         width: 14px;
         height: 14px;
         background-position: -30px -34px;
         }
		 .header-nav a:hover{
			color:red;
		}
		
		.outerBorder {
			 border : 1px solid grey;
			 margin-top : 60px;
			 padding : 10px 20px 40px 0px;
			 box-shadow : 2px 0px 2px 0px;
		 }
		 
		 .textWidth{
			 width: 400px;
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
                .pass_char{
                    font-size:10px;
                    list-style-type:disc !important;
                }
      </style>
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
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
      <link rel="stylesheet" href="<?php echo base_url(); ?>assets/mobile/css/bootstrap.min.css">
      <script type="text/javascript" src="<?php echo base_url(); ?>assets/admin/js/jquery.validate.min.js"></script> 
   </head>
   <body>
        <nav class="navbar navbar-expand-lg navbar-dark navbar-light static-top" style="background:#ccc">
            <div class="container">
                <a class="navbar-brand" href="<?php echo base_url(); ?>"><img src="<?php echo base_url(); ?>assets/admin/images/logo.png" width="180">
                </a>
            </div>
        </nav>
	<div class="container" >
	   <form  action="<?php echo site_url();?>signin/change_password" name="change_pass"  method="post">
		<div class="row">
			<div class="col-lg-5 col-sm-12 mt-4">
                            <div class="card p-3">
				<?php echo $this->session->flashdata("message"); ?>
				 <div id="messege" style="color: red;"></div>
				<div class="pb-2" >
                                    <h4><center> Change Password </center></h4>
                                    <hr/>
				</div>
                                 <div><?php echo $this->session->flashdata("success_pass"); ?></div>
                                 <div class="">
				   <input type="password" name="txt_old_password" class="form-control" placeholder="Enter Your Old Password" required>
				   <div style="color:red" id="email_error"><?php echo form_error('txt_old_password'); ?></div>
				</div>
                                <br/>
                                <div class="">
                                   <input type="password" name="txt_new_password" class="form-control" placeholder="Enter Your New Password" required >
                                   <div style="color:red" id="email_error"><?php echo form_error('txt_new_password'); ?></div>
                                </div>
                                </br>
                                <div class="">
                                   <input type="password" name="confirm_password" class="form-control" placeholder="Confirm Password" required >
                                   <div style="color:red" ><?php echo form_error('confirm_password'); ?></div>
                                </div>
                                <br/>
                                <div class="container">
                                    <ul class="pass_char">
                                        <li> password field must be of at least 8 characters in length.</li>
                                        <li> password field must have at least one uppercase letter.</li>
                                        <li> password field must have at least one lower letter. </li>
                                        <li> password field must have at least one number.</li>
                                        <li> password field must have at least one special character.</li>
                                    </ul>
                                </div>
				<div>
                                    <input type="submit" value=" Submit " class="btn btn-danger btn-sm" id="submit_button">
				</div>
			</div>
                    </div>
		</div>
            </form>
      </div>
   </body>
   <script type="text/javascript" src="<?php echo base_url(); ?>assets/mobile/js/bootstrap.min.js"></script> 
   <script>
       
   $(function(){
    $("form[name='change_pass']").validate({
    rules: {
      txt_old_password: "required",
      txt_new_password: "required",
      confirm_password:"required",
    },
    messages: {
      txt_old_password: "please enter old password",
      txt_new_password: "please enter new password",
      confirm_password: "please enter confirm password"
    },
    submitHandler: function(form) {
      form.submit();
    },
        errorClass:"text-danger"
  });
})
   </script>
</html>
