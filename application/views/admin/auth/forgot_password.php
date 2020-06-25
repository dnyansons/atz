<!DOCTYPE html>
<html lang="en">
    <head>
        <title><?php if(isset($pageTitle)){echo $pageTitle;}else{echo "Atzcart || Suppliers";}?></title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <link rel="icon" href="<?php echo base_url();?>assets/admin/images/favicon.ico" type="image/x-icon">
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600,800" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/admin/bower_components/bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/admin/icon/themify-icons/themify-icons.css">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/admin/icon/icofont/css/icofont.css">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/css/style.css">
    </head>
    <body class="fix-menu">
       
        <section class="login-block">

            <div class="container">
                <div class="row">
                    <div class="col-sm-12">


                        <form class="md-float-material form-material" method="post" action="">

                            <div class="text-center">
                                <img src="<?php echo base_url();?>assets/images/flogo.png" alt="logo.png" height="50" width="150">
                            </div>
                            <div class="auth-box card">
                                <div class="card-block">
                                    <div class="row m-b-20">
                                        <div class="col-md-12">
                                            <h3 class="text-center">Recover your password</h3>
                                        </div>
                                    </div>
                                    <div class="form-group form-primary">
                                        <input type="text" name="username" class="form-control" required=""  placeholder="Your Email Address" value="<?php echo set_value("username");?>" required>
                                        <div style="color:red"><?php echo form_error('username'); ?></div>
                                    </div>
									<?php if($error){ echo $error;}else if($success){ echo $success;?>
										<input type="text" name="otp" class="form-control" required=""  placeholder="Enter OTP" required>
											 
									<?php }?>
                                    <div class="row m-t-30">
                                        <div class="col-md-12">
                                            <button type="submit" name="sign_in" id="sign_in_supllier" class="btn btn-primary btn-md btn-block waves-effect waves-light text-center m-b-20">Submit</button>		
                                        </div>
                                    </div>
									<p class="f-w-600 text-right"><a href="<?php echo base_url();?>user/login">Back to Login.</a></p>
									
                            </div>
                        </form>

                    </div>

                </div>

            </div>

        </section>


        <script type="text/javascript" src="<?php echo base_url();?>assets/admin/bower_components/jquery/js/jquery.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url();?>assets/admin/bower_components/jquery-ui/js/jquery-ui.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url();?>assets/admin/bower_components/popper.js/js/popper.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url();?>assets/admin/bower_components/bootstrap/js/bootstrap.min.js"></script>

        <script type="text/javascript" src="<?php echo base_url();?>assets/admin/bower_components/jquery-slimscroll/js/jquery.slimscroll.js"></script>

        <script type="text/javascript" src="<?php echo base_url();?>assets/admin/bower_components/modernizr/js/modernizr.js"></script>
        <script type="text/javascript" src="<?php echo base_url();?>assets/admin/bower_components/modernizr/js/css-scrollbars.js"></script>

        <script type="text/javascript" src="<?php echo base_url();?>assets/admin/bower_components/i18next/js/i18next.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url();?>assets/admin/bower_components/i18next-xhr-backend/js/i18nextXHRBackend.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url();?>assets/admin/bower_components/i18next-browser-languagedetector/js/i18nextBrowserLanguageDetector.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url();?>assets/admin/bower_components/jquery-i18next/js/jquery-i18next.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url();?>assets/js/common-pages.js"></script>
    </body>
</html>
