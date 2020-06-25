<!DOCTYPE html>
<html lang="en">
    <head>
        <title><?php if(isset($pageTitle)){echo $pageTitle;}else{echo "Atzcart || Suppliers";}?></title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <link rel="icon" type="image/x-icon" href="<?php echo base_url();?>assets/admin/images/favicon.ico" >
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:400,600,800" >
        <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/admin/bower_components/bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/admin/icon/themify-icons/themify-icons.css">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/admin/icon/icofont/css/icofont.css">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/admin/css/style.css">
    </head>
    <body class="fix-menu">
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

        <section class="login-block">

            <div class="container">
                <div class="row">
                    <div class="col-sm-12">


                        <form class="md-float-material form-material" method="post" action="<?php echo site_url();?>user/login">

                            <div class="text-center">
                                <img src="<?php echo base_url();?>assets/admin/images/flogo.png" alt="logo.png" height="50" width="150">
                            </div>
                            <div class="auth-box card">
                                <div class="card-block">
                                    <div class="row m-b-20">
                                        <div class="col-md-12">
                                            <h3 class="text-center">Sign In</h3>
                                        </div>
                                    </div>
                                    <div class="form-group form-primary">
                                        <input type="text" name="username" class="form-control" required=""  placeholder="Your Email Address" value="">
                                        <span style="color: red"></span>
                                        <span class="form-bar"></span>
                                    </div>
                                    <div class="form-group form-primary">
                                        <input type="password" name="password" class="form-control" required=""  placeholder="Password" value="">
                                        <span style="color: red"></span>
                                        <span class="form-bar"></span>
                                    </div>

                                    <div class="row m-t-30">
                                        <div class="col-md-12">
                                            <button type="submit" name="sign_in" id="sign_in_supllier" class="btn btn-primary btn-md btn-block waves-effect waves-light text-center m-b-20">Sign in</button>
                                        </div>
                                    </div>

                                    <div class="row m-t-25 text-left">
                                        <div class="col-12">

                                            <div class="forgot-phone text-right">

                                                <a href="<?php echo site_url();?>login/forgot_password" class="text-right f-w-600 pull-left"> Forgot Password?</a> |  <a href="<?php echo site_url();?>user/register" class="text-right f-w-600 pull-right">Not Yet ? Register</a>

                                            </div>
                                        </div>
                                    </div>

                                    <hr />

                                    <div class="row m-t-30">
                                        <div class="col-md-12">
                                            <div align="center" style="color: red;">
                                                <?php echo $this->session->flashdata("message");?>
                                            </div>
                                        </div>
                                    </div>

                                </div>
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
        <script type="text/javascript" src="<?php echo base_url();?>assets/admin/js/common-pages.js"></script>
    </body>
</html>