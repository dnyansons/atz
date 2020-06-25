<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Create account : atzcart</title>
        
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <link rel="icon" href="<?php echo base_url();?>assets/admin/images/favicon.ico" type="image/x-icon">
        <meta http-equiv="refresh" content="5;url=<?php echo site_url();?>/login" />

        <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600,800" rel="stylesheet">

        <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/admin/bower_components/bootstrap/css/bootstrap.min.css">

        <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/admin/icon/themify-icons/themify-icons.css">

        <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/admin/icon/icofont/css/icofont.css">

        <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/admin/pages/flag-icon/flag-icon.min.css">

        <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/admin/pages/menu-search/css/component.css">

        <link rel="stylesheet" href="<?php echo base_url();?>assets/admin/pages/multi-step-sign-up/css/reset.min.css">
        <link rel="stylesheet" href="<?php echo base_url();?>assets/admin/pages/multi-step-sign-up/css/style.css">

        <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/admin/css/style.css">

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
             <a href="<?php echo base_url(); ?>"><img src="<?php echo base_url();?>assets/front/images/logo/logo.png" height="60px;" /></a>
        </div>
        <form id="msform" action="<?php echo site_url();?>signup/verify" method="post" style="min-height:400px;">
            
            <ul id="progressbar">
                <li class="">Verification</li>
                <li class="">Information</li>
                <li class="active">Complete</li>
            </ul>
            
            <fieldset>
                
                <p style="font-size:14px; line-height: 22px;">
                    Success! You have successfully registered with atzcart.com.
                Please visit the login section to continue with your account.
                You will be redirected to login.
                </p>
            </fieldset>
            
        </form>
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

        <script type="text/javascript">
            function restrictAlphabets(e){
                    var x=e.which||e.keycode;
                    if((x>=48 && x<=57) || x==8 ||
                            (x>=35 && x<=40)|| x==46)
                            return true;
                    else
                            return false;
            }
        </script>

    </body>
</html>
