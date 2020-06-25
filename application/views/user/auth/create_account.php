<!DOCTYPE html>
<html lang="en">
<head>
<title><?php $title = $title ? $title : "ATZCart - Create Account";
echo $title; ?></title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<link rel="icon" href="<?php echo base_url(); ?>assets/admin/images/favicon.ico" type="image/x-icon">
<link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600,800" rel="stylesheet">

<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/admin/bower_components/bootstrap/css/bootstrap.min.css">

<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/admin/icon/themify-icons/themify-icons.css">

<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/admin/icon/icofont/css/icofont.css">

<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/admin/pages/flag-icon/flag-icon.min.css">

<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/admin/pages/menu-search/css/component.css">

<link rel="stylesheet" href="<?php echo base_url(); ?>assets/admin/pages/multi-step-sign-up/css/reset.min.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/admin/pages/multi-step-sign-up/css/style.css">

	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/admin/css/style.css">

		<style>

			#msform {
			width: 100% !important;
			}
			.tex1{margin-top:5px;}
                        .classtxt{
                            font-size: 12px;
                        }
		</style>
	</head>
	<body class="multi-step-sign-up newLoginform">

		<div class="theme-loader">
			<div class="ball-scale">
				<div class='contain'>
					<div class="ring"><div class="frame"></div></div>
					<div class="ring"><div class="frame"></div></div>
					<div class="ring"><div class="frame"></div></div>
					<div class="ring"><div class="frame"></div></div>
					<div class="ring"><div class="frame"></div></div>
					<div class="ring"><div class="frame"></div></div>
					<div class="ring"><div class="frame"></div></div>
					<div class="ring"><div class="frame"></div></div>
					<div class="ring"><div class="frame"></div></div>
					<div class="ring"><div class="frame"></div></div>
				</div>
			</div>
		</div>
		<div class="col-md-12 text-center" style="top:20px;">

			<a href="<?php echo base_url(); ?>"><img src="<?php echo base_url(); ?>assets/front/images/logo/logo.png" width="150"></a>

			</div>
			<div class="mformD">
				<form id="msform" action="<?php echo site_url(); ?>createaccount" method="post" name="create_account">
					<ul id="progressbar">
						<li class="active">Account Setup</li>
						<li class="">Company Profile</li>
						<li class="">Tax Info</li>
						<li class="">Docs Verification</li>
					</ul>

					<fieldset>
						<h2 class="fs-title">Create Account</h2>
						<p class="text-mute text-left tex1">First Name *</p>
						<div class="">
							<input type="text" class="form-control" name="first_name" placeholder="First Name" autocomplete="off" value="<?php echo set_value('first_name'); ?>" />

						</div>
						<?php echo form_error('first_name'); ?> 
						<p class="text-mute text-left tex1">Last Name *</p>
						<div class="">
							<input type="text" class="form-control" name="last_name" placeholder="last Name" autocomplete="off" value="<?php echo set_value('last_name'); ?>" />
						</div>

						<?php echo form_error('last_name'); ?>
						<p class="text-mute text-left tex1">Phone *</p>
						<div class="">
							<input type="text" class="form-control" name="phone" placeholder="Phone" maxlength="15" onkeypress="return restrictAlphabets(event);" autocomplete="off" value="<?php echo set_value('Phone'); ?>"/>
							<p class="text-mute text-left">We will send otp for verification.</p>
						</div>
						<?php echo form_error('phone'); ?>

						<p class="text-mute text-left tex1">Email *</p>
						<div class="">
							<input type="text" class="form-control" name="email" placeholder="Email" autocomplete="off" value="<?php echo set_value('email'); ?>"/>
						</div>
						<?php echo form_error('email'); ?>

						<p class="text-mute text-left tex1">Password *</p>
						<div class="">
							<input type="password" class="form-control" data-toggle="tooltip" data-html="true" data-placement="left" aria-describedby="passHelp" title="The password must be:<ul><li>Password field must be of at least 8 characters in length</li> <li>Start with capital letter</li><li>Contains a special character</li><li>Contains a lower character</li><li>Contains a one number</li></ul>"  name="password" id="password" placeholder="Password" maxlength="32" minlength="6" value="<?php echo set_value('password'); ?>"/> 
							<?php echo form_error('password'); ?>
							
						</div>
                                             
						<br />
                                                
						<button type="submit" name="next" class="btn btn-primary btn-block b1t" value="Next">Create now</button>

					</fieldset>

				</form>
				<div class="col-10 offset-1">
					<div class="a-divider a-divider-break"><h5>Already have an account ?</h5></div>	  
					<p class="text-center col-12"> <a href="<?php echo site_url(); ?>login/" class="btn btn-block signIbtn" >Sign in</a></p>				  
				</div>
			</div>
			<br><br>	

					<div class="divider"></div>
					<p class="text-center">
						All rights reserved @atzcart.com
					</p>
					<br><br>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/admin/bower_components/jquery/js/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/admin/bower_components/jquery-ui/js/jquery-ui.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/admin/bower_components/popper.js/js/popper.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/admin/bower_components/bootstrap/js/bootstrap.min.js"></script>

<script type="text/javascript" src="<?php echo base_url(); ?>assets/admin/bower_components/jquery-slimscroll/js/jquery.slimscroll.js"></script>

<script type="text/javascript" src="<?php echo base_url(); ?>assets/admin/bower_components/modernizr/js/modernizr.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/admin/bower_components/modernizr/js/css-scrollbars.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min.js"></script>
<script src="<?php echo base_url(); ?>assets/admin/pages/multi-step-sign-up/js/main.js"></script>

<script type="text/javascript" src="<?php echo base_url(); ?>assets/admin/bower_components/i18next/js/i18next.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/admin/bower_components/i18next-xhr-backend/js/i18nextXHRBackend.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/admin/bower_components/i18next-browser-languagedetector/js/i18nextBrowserLanguageDetector.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/admin/bower_components/jquery-i18next/js/jquery-i18next.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/admin/js/common-pages.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/front/js/jquery.validate.min.js"></script> 
<script type="text/javascript" src="<?php echo base_url(); ?>assets/front/js/custome_validation.js"></script>
<script type="text/javascript">
function restrictAlphabets(e) {
var x = e.which || e.keycode;
if ((x >= 48 && x <= 57) || x == 8 ||
		(x >= 35 && x <= 40) || x == 46)
			return true;
			else
			return false;
			}
                        
                  function showPassword() {
                    var x = document.getElementById("password");
                    if (x.type === "password") {
                      x.type = "text";
                    } else {
                      x.type = "password";
                    }
                  }
                  
   $(document).ready(function(){
  $('[data-toggle="tooltip"]').tooltip();   
});

		</script>
	</body>
</html> 
