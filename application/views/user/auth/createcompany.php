<!DOCTYPE html>
<html lang="en">
    <head>
        <title><?php $title = $title ? $title : "ATZCart - Create Company"; echo $title; ?></title>

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

                       <a href="<?php echo base_url(); ?>"><img src="<?php echo base_url();?>assets/front/images/logo/logo.png" width="150" /></a>

        </div>
       <div class="mformD">
        <form id="msform" action="<?php echo site_url();?>createaccount/companyprofile" method="post" name="create_profile">

            <ul id="progressbar">
                <li class="">Account Setup</li>
                <li class="active">Company Profile</li>
                <li class="">Tax Info</li>
                 <li class="">Docs Verify</li>
            </ul>

            <fieldset>
                <h2 class="fs-title">About Your Business</h2>
                <p class="text-mute text-left tex1">Your Company name</p>
                <div class="">
                    <input type="text" class="form-control txt_box" name="company_name" placeholder="Company Name" autocomplete="off" value="<?php echo set_value('company_name'); ?>" />

                </div>
				<?php echo form_error('company_name'); ?>
				
                <p class="text-mute text-left tex1">Company Type</p>
                <div class="input-group">
                  <?php 
				  echo form_dropdown('company_type', $company_types, set_value('company_type'),"class='form-control'"); ?>

                </div>
				<?php echo form_error('company_type'); ?>
				
                <p class="text-mute text-left tex1">Product Category</p>
                <div class="">
					<?php 
				  echo form_dropdown('product_category', $categories, set_value('product_category'),"class='form-control'"); ?>

                </div>
				<?php echo form_error('product_category'); ?>
				
                <p class="text-mute text-left tex1">Address line 1</p>
                <div class="">
                    <textarea name="address_line_1" class="form-control " value="<?php echo set_value('address_line_1'); ?>"></textarea>

                </div>
				<?php echo form_error('address_line_1'); ?>
				
                <p class="text-mute text-left tex1">Pincode</p>
                <div class="">
                    <input type="text" class="form-control" name="pin_code" maxlength="6" onkeypress="return restrictAlphabets(event)" value="<?php echo set_value('pin_code'); ?>" />

                </div>
				<?php echo form_error('pin_code'); ?>
				
                <p class="text-mute text-left tex1">Country</p>
                <div class="">
                    <select class="form-control" name="country">
                        <option value="99">India</option>
                    </select>
                </div>
				<?php echo form_error('country'); ?>
				
                <p class="text-mute text-left tex1">State</p>
                <div class="">
                   <?php 
				  echo form_dropdown('state', $states, set_value('state'),"class='form-control'"); ?>

                </div>
				<?php echo form_error('state'); ?>
				
                <p class="text-mute text-left tex1">City</p>
                <div class="">
                    <input type="text" class="form-control txt_box" name="city" value="<?php echo set_value('city'); ?>"/>
                </div>
				<?php echo form_error('city'); ?>
				
                <button type="submit" name="next"  class="btn btn-primary btn-block b1t" value="Next" style="margin-top: 10px;">Next</button>

               
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

              /*
        special character validation for registration process
    */

      $(function(){
     
      $('.txt_box').keyup(function()
      {
        var yourInput = $(this).val();
        re = /[`~!@#$%^&*()_|+\-=?;:'",.<>\{\}\[\]\\\/]/gi;
        var isSplChar = re.test(yourInput);
        if(isSplChar)
        {
          var no_spl_char = yourInput.replace(/[`~!@#$%^&*()_|+\-=?;:'",.<>\{\}\[\]\\\/]/gi, '');
          $(this).val(no_spl_char);
        }
      });
     
    });

        </script>

    </body>
</html>
