<!DOCTYPE html>
<html lang="en">
    <head>
        <title><?php $title = $title ? $title : "ATZCart - Buyer Registration"; echo $title; ?></title>
        
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <link rel="icon" href="<?php echo base_url();?>assets/admin/images/favicon.ico" type="image/x-icon">

        <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600,800" rel="stylesheet">

        <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/admin/bower_components/bootstrap/css/bootstrap.min.css">

        <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/admin/icon/themify-icons/themify-icons.css">

        <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/admin/icon/icofont/css/icofont.css">

        <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/admin/pages/flag-icon/flag-icon.min.css">

        <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/admin/pages/menu-search/css/component.css">

        <link rel="stylesheet" href="<?php echo base_url();?>assets/admin/pages/multi-step-sign-up/css/reset.min.css">
        <link rel="stylesheet" href="<?php echo base_url();?>assets/admin/pages/multi-step-sign-up/css/style.css">

        <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/admin/css/style.css">

        <style>
            body{
                background-image: url("<?php echo base_url(); ?>assets/images/registration.jpg");
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
             <a href="<?php echo base_url(); ?>"><img src="<?php echo base_url();?>assets/front/images/logo/logo.png" width="150px;" /></a>
        </div>
       <div class="mformD">
          <form id="msform" action="<?php echo site_url();?>signup" method="post" name="sign_up">
            <ul id="progressbar">
                <li class="active">Verification</li>
                <li class="">Information</li>
                <li class="">Complete</li>
            </ul>
            
            <fieldset>
                <h2 class="fs-title">Create Account</h2>
                <p class="text-mute text-left">Email</p>
                <div class=" mb-0">
                    <input type="email" class="form-control" name="email" placeholder="Email" value = "<?php echo set_value('email'); ?>" autocomplete="off" /  pattern="/^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/">
                </div>
                <?php echo form_error('email'); ?>
                
                <p class="text-mute text-left">Mobile </p>
                <div class=" mb-0" >
                    <input type="text" class="form-control" name="mobile_number" value = "<?php echo set_value('mobile_number'); ?>"  placeholder="Mobile Number" autocomplete="off"   onkeypress="return restrictAlphabets(event)" maxlength = "15" />
                </div>
                <?php echo form_error('mobile_number'); ?>
                </br>
                <button type="submit" name="next" class="btn btn-primary btn-block b1t" value="Next">Verify</button>

                </br>
                <?php echo $this->session->flashdata('message'); ?>
                <br />
            </fieldset>            
        </form>       
            <div class="col-10 offset-1">
             <div class="a-divider a-divider-break"><h5>Already have an account ?</h5></div>      
              <p class="text-center"> <a href="<?php echo site_url();?>login/" class="btn btn-primary btn-block b1t" >Sign in</a></p>
            </div>
        </div>
        <br><br>             
        
        <div class="divider"></div>
        <p class="text-center">
            All rights reserved @atzcart.com
        </p>

        <script type="text/javascript" src="<?php echo base_url();?>assets/admin/bower_components/jquery/js/jquery.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url();?>assets/admin/bower_components/jquery-ui/js/jquery-ui.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url();?>assets/admin/bower_components/popper.js/js/popper.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url();?>assets/admin/bower_components/bootstrap/js/bootstrap.min.js"></script>

        <script type="text/javascript" src="<?php echo base_url();?>assets/admin/bower_components/jquery-slimscroll/js/jquery.slimscroll.js"></script>

        <script type="text/javascript" src="<?php echo base_url();?>assets/admin/bower_components/modernizr/js/modernizr.js"></script>
        <script type="text/javascript" src="<?php echo base_url();?>assets/admin/bower_components/modernizr/js/css-scrollbars.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min.js"></script>
        <script src="<?php echo base_url();?>assets/admin/pages/multi-step-sign-up/js/main.js"></script>

        <script type="text/javascript" src="<?php echo base_url();?>assets/admin/bower_components/i18next/js/i18next.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url();?>assets/admin/bower_components/i18next-xhr-backend/js/i18nextXHRBackend.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url();?>assets/admin/bower_components/i18next-browser-languagedetector/js/i18nextBrowserLanguageDetector.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url();?>assets/admin/bower_components/jquery-i18next/js/jquery-i18next.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url();?>assets/admin/js/common-pages.js"></script>
           <script type="text/javascript" src="<?php echo base_url();?>assets/admin/js/jquery.validate.min.js"></script>
         <script type="text/javascript" src="<?php echo base_url();?>assets/admin/js/jquery.validate.js"></script>
          <script type="text/javascript" src="<?php echo base_url();?>assets/front/js/custome_validation.js"></script>
        <script type="text/javascript">
            function restrictAlphabets(e){
                    var x=e.which||e.keycode;
                    if((x>=48 && x<=57))
                            return true;
                    else
                            return false;
            }
        </script>
        
    </body>
</html>
