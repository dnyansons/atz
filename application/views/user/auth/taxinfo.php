<!DOCTYPE html>
<html lang="en">
    <head>
        <title><?php $title = $title ? $title : "ATZCart - Add Tax info"; echo $title; ?></title>

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
		 .mformD{
			width:470px;
		}
		#msform
		{
			width:100%;
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
            <a href="<?php echo site_url();?>"><img src="<?php echo base_url();?>assets/front/images/logo/logo.png" height="60px;" /></a>
        </div>
       <div class="mformD"> 
        <form id="msform" action="<?php echo site_url();?>createaccount/taxinfo" novalidate="" method="post" name="tax_info">

            <ul id="progressbar">
                <li class="">Account Setup</li>
                <li class="">Company Profile</li>
                <li class="active">Tax info</li>
                <li class="">Docs Verify</li>
            </ul>

            <fieldset>
                <h2 class="fs-title">Tax information</h2>
                <p class="text-mute text-left tex1">Gst no</p>
                <div class="">
                    <input type="text" class="form-control" name="gst_no" placeholder="Enter GST Number" autocomplete="off" maxlength="15" />

                </div>
				<?php echo form_error('gst_no'); ?>
				
                <p class="text-mute text-left tex1">Pan Type</p>
                <div class="">
                    <select class="form-control" name="pan_type">
                        <option value="">Select</option>
                        <option value="personal">Personal</option>
                        <option value="business">Business</option>
                    </select>
                </div>
				<?php echo form_error('pan_type'); ?>
				
                <p class="text-mute text-left tex1">Pan no</p>
                <div class="">
                    <input type="text" class="form-control" name="pan_no" placeholder="Pan No" autocomplete="off" maxlength="10" />
                </div>
				<?php echo form_error('pan_no'); ?>
				
                <p class="text-left">By Clicking continue you are agree to atzcart<a href="<?php echo site_url();?>/policies-rules" target="_blank"> terms & Conditions</a></p>
                <br />
                <button type="submit" name="next" class="btn btn-primary btn-block b1t"  value="Next">Continue</button>
                <br />
               
            </fieldset>
        </form>       
         <div class="col-10 offset-1">
			 <div class="a-divider a-divider-break"><h5>Already have an account ?</h5></div>	  
			  <p class="text-center"> <a href="<?php echo site_url();?>login/" class="btn btn-block signIbtn" >Sign in</a></p>				  
			</div>
		</div>
		<br><br>	
		
       <div class="divider"></div>
        <p class="text-center">
            All rights reserved @atzcart.com
        </p>
         <br><br>

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
  <script type="text/javascript" src="<?php echo base_url(); ?>assets/front/js/jquery.validate.min.js"></script> 
     <script type="text/javascript" src="<?php echo base_url(); ?>assets/front/js/custome_validation.js"></script>
        <script type="text/javascript">
            function restrictAlphabets(e){
                    var x=e.which||e.keycode;
                    if((x>=48 && x<=57) || x==8 ||
                            (x>=35 && x<=40)|| x==46)
                            return true;
                    else
                            return false;
            }
            
            
            $(function(){
                $("input[name=gst_no]")[0].oninvalid = function () {
                    this.setCustomValidity("Enter valid GST Number");
                };
                $("input[name=pan_no]")[0].oninvalid = function () {
                    this.setCustomValidity("Enter valid GST Number.");
                };
            });
            
/*
    @author Ishwar03092019
    Gst Number Validation 
    This Function used for validating the gst no.
*/

    $(document).ready(function() {
      $.validator.addMethod("gst_no", function(value3, element3) {
        var gst_value = value3.toUpperCase();
        var reg = /^([0-9]{2}[a-zA-Z]{4}([a-zA-Z]{1}|[0-9]{1})[0-9]{4}[a-zA-Z]{1}([a-zA-Z]|[0-9]){3}){0,15}$/;
        if (this.optional(element3)) {
          return true;
        }
        if (gst_value.match(reg)) {
          return true;
        } else {
          return false;
        }

      }, "Please specify a valid GSTTIN Number");   

    jQuery("#msform").validate({
            rules: {
                "gst_no": {gst_no: true},
            },
        });
  /*
        Ishwar 03092019
        PAN Numbe Validation
        This FUnction used for validating the Pan card Number
    */
 $.validator.addMethod("pan_no", function(value, element)
    {
        var pan_value = value.toUpperCase();
        var reg1= /^([a-zA-Z]){5}([0-9]){4}([a-zA-Z]){1}?$/;
        if(this.optional(element))
        {
            return true;
        }
        if(pan_value.match(reg1))
        {
            return true;
        }else{
            return false;
        }
    }, "Please enter a valid PAN");


    jQuery("#msform").validate({
            rules: {
                "pan_no": {pan_no: true},
            },
        });

});

  
    

        </script>

    </body>
</html>
