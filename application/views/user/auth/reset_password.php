<!DOCTYPE html>
<html lang="en">
   <head>
      <title><?php if(isset($pageTitle)){echo $pageTitle;}else{echo "Atzcart || Suppliers";}?></title>
      <link rel="icon" href="<?php echo base_url(); ?>assets/admin/images/favicon.ico" type="image/x-icon">
      <link rel="stylesheet" href="http://localhost/atzcart/assets/front/css/font-awesome.min.css">
      <link rel="stylesheet" href="http://localhost/atzcart/assets/front/css/ionicons.min.css">

      <style>
         @import url(<?php echo base_url();?>assets/admin/css/form.css);
		 html, body{
             height:100vh ! important;
			 max-height:120vh;
			}

		 .header-nav a:hover{
			color:red;
		}

		.header-nav a:hover{
			color:red;
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
				margin:3rem auto;

            }
            a.nav-link
            {
                color:#000 !important;
            }

            .nav-item a:hover{
                color:red !important;
            }

            body{
                background-image: url("<?php echo base_url();?>assets/images/pasword-bg-4.jpg");
			    background-repeat:no-repeat;
                background-size: cover;
				background-position: center;

            }
      </style>
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	   <link rel="stylesheet" href="<?php echo base_url(); ?>assets/front/css/bootstrap.min.css">
	  <script src="<?php echo base_url(); ?>assets/admin/bower_components/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js"></script>
	  <script type="text/javascript" src="<?php echo base_url(); ?>assets/admin/js/jquery.validate.min.js"></script>
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
		<div class="card text-center p-2">
		<div class="card-content">
		<div class="card-body fg-image">
		<div class="row">
		<div class="col-lg-12 col-md-12 bg-white ">
		   <form  action="<?php echo site_url();?>reset-password"  method="post">
			<div class="row">
				<div class="col-md-12 outerBorder ">
					<?php echo $this->session->flashdata("message"); ?>
					 <div id="messege" style="color: red;"></div>
					<div class="pb-4" >
						<h2> Reset Password.</h2>
						<span> Enter Your New Password.</span>
					</div>

					<div class="textWidth">
					   <input type="password" name="password" class="form-control" placeholder="Enter Your Password" value= "<?php echo set_value("password"); ?>" required>
					   <div style="color:red" id="email_error"><?php echo form_error('password'); ?></div>
					</div>
					</br>
					<div class="textWidth">
					   <input type="password" name="confirm_password" class="form-control" placeholder="Confirm Password" value= "<?php echo set_value("confirm_password"); ?>" required>
					   <div style="color:red" ><?php echo form_error('confirm_password'); ?></div>
					</div>
									<div class="text-left mt-2">
												<ul class="p-1">
													<li><i class="fa fa-circle pr-1" style="font-size:0.5em;"></i>
														<small>Password field must have at least one uppercase letter.</small>
													</li>
													<li><i class="fa fa-circle pr-1" style="font-size:0.5em;"></i>
														<small>Password field must have at least one lowercase letter.</small>
													</li>
													<li><i class="fa fa-circle pr-1" style="font-size:0.5em;"></i>
														<small>Password field must have at least one number.</small>
													</li>
													<li><i class="fa fa-circle pr-1" style="font-size:0.5em;"></i>
														<small>Password field must be of at least 8 characters in length.</small>
													</li>
													<li><i class="fa fa-circle pr-1" style="font-size:0.5em;"></i>
														<small>Password field must have at least one special character from <b>!@#$%^&*()\-_=+{};:,<.>~</b></small>
													</li>
												 </ul>
									</div>

					<div class="btnCss mx-5">
						<input type="submit" value=" Submit " class="btn btn-danger btn-block" id="submit_button">
					</div>
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
          </br></br>
   </body>
   <script>
   	          	$(function(){


      	   $("form[name='reset_pass']").validate({

    rules: {

      password: "required",
      confirm_password:"required",

    },

    messages: {
      Password: "please enter password ",
      confirm_password:"please enter confirm password"

    },
    submitHandler: function(form) {
      form.submit();
    },
    errorClass:"text-danger"
  });
})
   </script>
</html>