<!DOCTYPE html>
<html lang="en">
   <head>
      <title>ATZ  Register</title>
      <meta http-equiv="content-type" content="text/html;charset=UTF-8" />
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
      <meta http-equiv="X-UA-Compatible" content="IE=edge" >
      <meta name="description" content="#">
      <link rel="icon" href="<?php echo base_url();?>assets/admin/images/favicon.ico" type="image/x-icon">
      <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600,800" rel="stylesheet">
      <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/admin/bower_components/bootstrap/css/bootstrap.min.css">
      <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/admin/icon/themify-icons/themify-icons.css">
      <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/admin/icon/icofont/css/icofont.css">
      <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/admin/icon/feather/css/feather.css">
      <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/admin/bower_components/jquery.steps/css/jquery.steps.css">
      <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/admin/css/style.css">
      <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/admin/css/style.css">
      <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/admin/css/jquery.mCustomScrollbar.css">
      <style>.wizard > .actions > ul > li a[href="#next"]{display: none;}</style>
	  <style>
	  .tooltip {
  position: relative;
  display: inline-block;
  border-bottom: 1px dotted black;
}

.tooltip .tooltiptext {
  visibility: hidden;
  width: 120px;
  background-color: black;
  color: #fff;
  text-align: center;
  border-radius: 6px;
  padding: 5px 0;

  /* Position the tooltip */
  position: absolute;
  z-index: 1;
}

.tooltip:hover .tooltiptext {
  visibility: visible;
} 

.wizard, .tabcontrol {
    display: block;
    width: 100%;
    overflow: hidden;
    text-align: center;
}
.wizard>.steps .current a {
    background: #bd081b !important;
   
}

.card .card-block .wizard-form .steps ul {
    display: block;
    margin-left: 23%;
}
.wizard>.steps a, .wizard>.steps a:hover, .wizard>.steps a:active {
  
    padding:1em !important; 
  
}
.btn-info
{
	 background: #bd081b !important;
	 border:1px solid #bd081b !important;
}
.number
{
	display:none;
}

.card
{
	box-shadow:none !important;
}

.header-area {
    box-shadow: 2px 2px 3px rgba(0, 0, 0, .1);
	padding:20px 0;
	
}
#pcoded{
box-shadow:1px 1px 25px 12px rgba(0, 0, 0, .1);
}

.wizard>.content>.body label
{
 padding:15px;
 margin-bottom:0px !important;
}

.input-group-append .btn-info
{
	
}

.input-group-prepend
{
	width:15%;
	background:#ccc;
}

.form-control1{
	width:60% !important;
}
.input-group a {
    padding-top: 5px;
    padding-bottom:11px;
    font-size: 12px;
    width: 151px;
    font-size: 18px;
}
.inputE
{
	margin-left:5%;
}
</style>
	  </style>
   </head>
   <body>
	<header class="header-area main-header home-three">
	<!-- Header top area start -->
	<div class="header-top-area home-one ">
		<div class="container">
			<div class="row">
				<div class="col-12">
					<div class="top-bar-left">
						<div class="topbar-nav pull-left">
							<div class="wpb_wrapper">
								<div class="menu-my-account-container">
									<!-- site-logo -->
									<div class="site-logo text-center">
										<a href="<?php echo base_url(); ?>"><img
												src="<?php  echo base_url(); ?>assets/admin/images/logo/logo.png"
												alt="atz" width="160" class="img-fluid"></a>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	</header>
			<br><br>
    <div class="container dd">	  
      <div class="theme-loader">
         <div class="ball-scale">
            <div class='contain'>
               <div class="ring">
                  <div class="frame"></div>
               </div>
               <div class="ring">
                  <div class="frame"></div>
               </div>
               <div class="ring">
                  <div class="frame"></div>
               </div>
               <div class="ring">
                  <div class="frame"></div>
               </div>
               <div class="ring">
                  <div class="frame"></div>
               </div>
               <div class="ring">
                  <div class="frame"></div>
               </div>
               <div class="ring">
                  <div class="frame"></div>
               </div>
               <div class="ring">
                  <div class="frame"></div>
               </div>
               <div class="ring">
                  <div class="frame"></div>
               </div>
               <div class="ring">
                  <div class="frame"></div>
               </div>
            </div>
         </div>
      </div>
      <div id="pcoded" class="pcoded" >
         
         <div class="pcoded-container navbar-wrapper" style="background-color:#fff;">
            <div class="showChat_inner">
            </div>
            <section class="" style="margin-top:30px;">
            <div class="container">
               <div class="row">
                  <div class="col-sm-12">
                     <div class="page-header">
                        <div class="row align-items-end">
                           <div class="col-lg-8">
                              <div class="page-header-title">
                                 <div class="d-inline">
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                     <div class="page-body">
                        <div class="row">
                           <div class="col-sm-12">
                              <div class="card">
                                
                                 <div class="card-block">
                                    <div class="row">
                                       <div class="col-md-12">
                                          <div id="wizard">
                                             <p style="text-align:center;color:red;font-size:15px;"><?php 
                                                echo $this->session->flashdata('message');
                                                ?></p>
                                             <section>
                                                <form class="wizard-form" id="example-advanced-form" action="<?php echo $action_url; ?>" method="POST">
                                                   <h3> Verification </h3>
                                                   <fieldset>
												   <?php
												   if(isset($url_id))
												   {
													   echo'<input type="hidden" name="url_id" value="'.$url_id.'">';
												   }
												   ?>
												   

                                                      <div class="input-group input-group-lg inputE">
                                                         <div class="input-group-prepend">
                                                            <label  class="input-group-text block" for="email-2" >Email *</label>
                                                         </div>
                                                       
                                                            <input id="email-2"  type="email" class="required form-control1" value='<?php
                                                               if(isset($verified_email))
                                                               {
                                                                echo $verified_email['email'] ;
                                                                
                                                               }
                                                               
                                                               ?>' <?php 
                                                               if(isset($verified_email))
                                                                {
                                                               	 echo 'readonly' ;
                                                               	 
                                                                }
                                                               
                                                               ?>>
                                                            <p class="success"></p>
                                                        
                                                         <div class="input-group-append">
                                                            <?php
                                                               if(isset($verified_email))
                                                               {  } else {?>
                                                            <a href="#"  class="btn btn-info btn-lg input-group-text" onclick="check_mail()">Verify</a>
                                                            <?php } ?>
                                                         </div>
                                                      </div>
                                                      <?php
                                                         if(isset($verified_email))
                                                         {
                                                         ?>
                                                      <div class="form-group row">
                                                         <div class="col-md-4 col-lg-2">
                                                            <label for="name-2" class="block">Verification Code *</label>
                                                         </div>
                                                         <div class="col-md-4 col-lg-4">
                                                            <p class="form-control" id="image_captcha"><?php echo $captchaImg; ?></p>
                                                         </div>
                                                         <div class="col-md-3 col-lg-3"> 
                                                            <input class="form-control"  style="height:67px;" type="text" id="captcha" required name="captcha" autocomplete="off" value="" onkeyup="check_captcha(this.value)"  />
                                                         </div>
                                                         <div class="col-md-1 col-lg-1">
                                                            <a href="javascript:void(0);" class="captcha-refresh" >
                                                            <img style="width:25px;  margin-top: 18px;" src="<?php echo base_url().'assets/admin/refresh.png'; ?>" title="Refresh"/>
                                                            </a>
                                                         </div>
                                                      </div>
                                                      <?php } ?>
                                                      <div class="form-group row">
                                                         <div class="col-md-4 col-lg-2"></div>
                                                         <div class="col-md-4 col-lg-10">
                                                            <p id="success2"></p>
                                                         </div>
                                                      </div>
                                                   </fieldset>
                                                   <h3> General information </h3>
                                                   <fieldset style="overflow:auto;">
                                                      <div class="form-group row">
                                                         <div class="col-md-4 col-lg-2">
                                                            <label for="name-2" class="block">Username *</label>
                                                         </div>
                                                         <div class="col-md-8 col-lg-10">
                                                            <input id="name-2" name="email" type="text" class="form-control" required='' readonly=''
                                                               value='<?php
                                                                  if(isset($verified_email))
                                                                  {
                                                                   echo $verified_email['email'] ;
                                                                   
                                                                  }
                                                                  
                                                                  ?>'>
                                                         </div>
                                                      </div>
                                                      <div class="form-group row">
                                                         <div class="col-md-4 col-lg-2">
                                                            <label for="password-2" class="block">Password *</label>
                                                         </div>
                                                         <div class="col-md-4 col-lg-4">
                                                            <input id="password-2" name="password" type="password" class="form-control required" aria-required="true">
                                                         </div>
                                                         <div class="col-md-4 col-lg-2" style="margin-top: 5px;">
                                                            <label for="confirm-2" class="block">Confirm Password *</label>
                                                         </div>
                                                         <div class="col-md-4 col-lg-4">
                                                            <input id="confirm-2" name="cpassword"  type="password" class="form-control required" aria-required="true">
                                                         </div>
                                                      </div>
                                                      <div class="form-group row">
                                                         <div class="col-md-4 col-lg-2">
                                                            <label for="surname-2" class="block">Select Country *</label>
                                                         </div>
                                                         <div class="col-md-8 col-lg-10">
                                                            <select class="form-control" name="country">
                                                               <option value="">Select Country</option>
                                                               <?php
                                                                  foreach($country as $co)
                                                                  {
                                                                  ?>
                                                               <option value="<?php echo $co['id']; ?>"><?php echo $co['name']; ?></option>
                                                               <?php } ?>
                                                            </select>
                                                         </div>
                                                      </div>
                                                      <div class="form-group row">
                                                         <div class="col-md-4 col-lg-2">
                                                            <label for="surname-2" class="block">Location *</label>
                                                         </div>
                                                         <div class="col-md-8 col-lg-10">
                                                            <input type="text" id="address1" name="address1" class="form-control" value=""  placeholder="Location" required="required">
                                                         </div>
                                                      </div>
                                                      <!--<div class="form-group row">
                                                         <div class="col-md-4 col-lg-2">I Am</div>
                                                         <div class="col-md-8 col-lg-10">
                                                            <select class="form-control required" name="role">
                                                               <option value="">Select</option>
                                                               <option value="seller">Seller</option>
                                                               <option value="buyer">Buyer</option>
                                                               <option value="both">Both</option>
                                                            </select>
                                                         </div>
                                                      </div>
                                                      
                                                      <div class="form-group row">
                                                         <div class="col-md-4 col-lg-2">Want Sell ? </div>
                                                         <div class="col-md-8 col-lg-10">
                                                           <div class="radio radio-matrial radio-primary radio-inline">
                                                                <input class="border-checkbox" name="role" value="Both"  type="radio" id="checkbox1" required>
                                                                <label class="border-checkbox-label" for="checkbox1">Yes&nbsp;&nbsp;</label>
                                                                <input class="border-checkbox" name="role" value="Buyer"  type="radio" id="checkbox2" required>
                                                                <label class="border-checkbox-label" for="checkbox2">No</label>
                                                            </div>
                                                           
                                                         </div>
                                                      </div>-->
                                                      
                                                      <div class="form-group row">
                                                         <div class="col-md-4 col-lg-2">Want Sell ? </div>
                                                         <div class="col-md-8 col-lg-10 form-radio">
                                                          <div class="radio radio-inline">
                                                            <label>
                                                            <input type="radio" name="role" value="seller" required>
                                                            <i class="helper"></i>Yes
                                                            </label>
                                                        </div>
                                                        
                                                          <div class="radio radio-inline">
                                                           
                                                             <label>
                                                            <input type="radio" name="role" value="buyer" required>
                                                            <i class="helper"></i>No
                                                            </label>
                                                        </div>
                                                           
                                                         </div>
                                                      </div>
                                                      
                                                      
                                                      <div class="form-group row">
                                                         <div class="col-md-4 col-lg-2">
                                                            <label for="first_name" class="block">First Name *</label>
                                                         </div>
                                                         <div class="col-md-4 col-lg-4">
                                                            <input id="first_name" name="first_name" type="text" placeholder="First Name" class="form-control required">
                                                         </div>
                                                         <div class="col-md-4 col-lg-2" style="margin-top: 5px;">
                                                            <label for="last_name" class="block">Last Name *</label>
                                                         </div>
                                                         <div class="col-md-4 col-lg-4">
                                                            <input id="last_name" name="last_name" type="text" placeholder="Last Name" class="form-control required">
                                                         </div>
                                                      </div>
                                                      <div class="form-group row">
                                                         <div class="col-md-4 col-lg-2">Company Type</div>
                                                         <div class="col-md-8 col-lg-10">
                                                            <select class="form-control required" name="company_type">
                                                               <option value="">Select Company Type</option>
                                                               <?php
                                                                  foreach($comp_type as $row)
                                                                  {
                                                                  	 echo'<option value="'.$row["id"].'">'.$row["name"].'</option>';
                                                                  }
                                                                  ?>
                                                            </select>
                                                         </div>
                                                      </div>
                                                      <div class="form-group row">
                                                         <div class="col-md-4 col-lg-2">
                                                            <label for="company_name" class="block">Company Name *</label>
                                                         </div>
                                                         <div class="col-md-8 col-lg-10">
                                                            <input id="company_name" name="company_name" placeholder="Company Name" type="text" class="form-control required">
                                                         </div>
                                                      </div>
                                                      <div class="form-group row">
                                                         <div class="col-md-4 col-lg-2">
                                                            <label for="phone-2" class="block">Mobile Number</label>
                                                         </div>
                                                         <div class="col-md-1 col-lg-1">
                                                            <input id="phone-code" name="code" type="text" class="form-control required phone" placeholder="+91" value="<?php echo $country_code; ?>" readonly>
                                                         </div>
                                                         <div class="col-md-5 col-lg-7">
                                                            <input id="phone-2" name="telephone" type="number" class="form-control required phone">
                                                         </div>
                                                         <div class="col-md-2 col-lg-2">
                                                            <img src="<?php echo $flag; ?>" style="width:30px;margin-top: 7px;">
                                                         </div>
                                                      </div>
                                                   </fieldset>
                                                   <h3>Commplete </h3>
                                                   <fieldset>
                                                      Congratulation ! your registration is complete.
                                                      Sign-in Account: <?php
                                                         if(isset($verified_email))
                                                         { echo $verified_email['email'] ; }
                                                         
                                                         ?>
                                                      Note: you can use this account to sign in to atzcart.com
                                                      Next, tell us about your sourcing preferences to personalize your ATZ cart experience.
                                                   </fieldset>
                                                </form>
                                             </section>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <script src="<?php echo base_url(); ?>assets/admin/bower_components/jquery/js/jquery.min.js"></script>
      <script src="<?php echo base_url(); ?>assets/admin/bower_components/jquery-ui/js/jquery-ui.min.js"></script>
      <script src="<?php echo base_url(); ?>assets/admin/bower_components/popper.js/js/popper.min.js"></script>
      <script src="<?php echo base_url(); ?>assets/admin/bower_components/bootstrap/js/bootstrap.min.js"></script>
      <script src="<?php echo base_url(); ?>assets/admin/bower_components/jquery-slimscroll/js/jquery.slimscroll.js"></script>
      <script src="<?php echo base_url(); ?>assets/admin/bower_components/modernizr/js/modernizr.js"></script>
      <script src="<?php echo base_url(); ?>assets/admin/bower_components/modernizr/js/css-scrollbars.js"></script>
      <script src="<?php echo base_url(); ?>assets/admin/bower_components/i18next/js/i18next.min.js"></script>
      <script src="<?php echo base_url(); ?>assets/admin/bower_components/jquery.cookie/js/jquery.cookie.js"></script>
      <script src="<?php echo base_url(); ?>assets/admin/bower_components/jquery.steps/js/jquery.steps.js"></script>
      <script src="<?php echo base_url(); ?>assets/admin/bower_components/jquery-validation/js/jquery.validate.js"></script>
      <script src="<?php echo base_url(); ?>assets/admin/pages/form-validation/validate.js"></script>
      <script src="<?php echo base_url(); ?>assets/admin/js/pcoded.min.js"></script>
      <script src="<?php echo base_url(); ?>assets/admin/js/vartical-layout.min.js"></script>
      <script src="<?php echo base_url(); ?>assets/admin/js/jquery.mCustomScrollbar.concat.min.js"></script>
      <script src="<?php echo base_url(); ?>assets/admin/js/script.js"></script>
      <script src="https://www.googletagmanager.com/gtag/js?id=UA-23581568-13" async ></script>
      <script>
         'use strict';
         $(document).ready(function () {
         
         $('a[href="http://atzcart.com/members/supplier/register#next"]').hide();
         $("#basic-forms").steps({
         headerTag: "h3",
         bodyTag: "fieldset",
         transitionEffect: "slideLeft",
         autoFocus: true
         });
         $("#verticle-wizard").steps({
         headerTag: "h3",
         bodyTag: "fieldset",
         transitionEffect: "slide",
         stepsOrientation: "vertical",
         autoFocus: true
         });
         $("#design-wizard").steps({
         headerTag: "h3",
         bodyTag: "fieldset",
         transitionEffect: "slideLeft",
         autoFocus: true
         });
         var form = $("#example-advanced-form").show();
         form.steps({
         headerTag: "h3",
         bodyTag: "fieldset",
         transitionEffect: "slideLeft",
         onStepChanging: function (event, currentIndex, newIndex) {
         	
			var ab=1;
			var pass=$('#password-2').val();
				
			var passlength=pass.length;
         	if (currentIndex > newIndex) {
         		return true;
         	}
         	if (newIndex === 2 && (pass.length < 8 || (pass.search(/[a-z]/i) < 0) || (pass.search(/[0-9]/) < 0))) {
				
					alert("Your password must be at least 8 characters/at least one letter/at least one digit"); 
				
				return false;
         		
         	}
         	if (currentIndex < newIndex) {
         		form.find(".body:eq(" + newIndex + ") label.error").remove();
         		form.find(".body:eq(" + newIndex + ") .error").removeClass("error");
         	}
         	form.validate().settings.ignore = ":disabled,:hidden";
         	return form.valid();
         },
         onStepChanged: function (event, currentIndex, priorIndex) {
         	if (currentIndex === 2 && Number($("#age-2").val()) >= 18) {
         		
         		form.steps("next");
         		
         	}
         	if (currentIndex === 2 && priorIndex === 3) {
         		form.steps("previous");
         	}
         },
         onFinishing: function (event, currentIndex) {
         	form.validate().settings.ignore = ":disabled";
         	return form.valid();
         },
         onFinished: function (event, currentIndex) {
         
         	form.submit();
         	
         	$('.content input[type="text"]').val('');
         	$('.content input[type="email"]').val('');
         	$('.content input[type="password"]').val('');
			
         }
         }).validate({
         errorPlacement: function errorPlacement(error, element) {
         	element.before(error);
         },
         rules: {
         	confirm: {
         		equalTo: "#password-2"
         	}
         }
         });
         });
          
      </script>
   </body>
   <script>
      function check_mail()
      {
          var email = $('#email-2').val();
      		
          if(email)
          {
                  $.ajax({
                          type:'POST',
                          url :'<?php echo base_url(); ?>user/register/send_mail',
                          data: {'email':email},
                          success:function(data){
							
                              if(data=='sent')
                              {
                                  $(".success").html("<span style='text-align:center;color:green;'>Confirmation Mail sent Successfully ,Verify Email ! </span>");
                              }
                              if(data=='notsent')
                              {
                                  $(".success").html("<span style='text-align:center;color:red;'>Email Not Sent !</span>");
                              }
                              if(data=='registered')
                              {
                                  $(".success").html("<span style='text-align:center;color:red;'>This Email Already Registered !</span>");
                              }
      
                          },
                          error:function(){
                              alert('error handling here'); 
                          }
                  });
          }
          else
          {
                  $(".success").html("<span style='text-align:center;color:red;'>Please Enter Email ID !</span>");
          }
      }
      
      
      
      
      $(document).ready(function(){
          $('.captcha-refresh').on('click', function(){
              $.get('<?php echo base_url().'user/register/refresh'; ?>', function(data){
                  $('#image_captcha').html(data);
              });
          });
      });
         
      function check_captcha(ch)
      {
          $.ajax({
              type:'POST',
              url :'<?php echo base_url(); ?>user/register/check_captcha',
              data: {'captcha':ch},
              success:function(data){
      
                      if(data=='match')
                      {
                               $("#success2").html("<span style='text-align:center;color:green;'>Captcha Matched  !</span>");
                               $('.wizard > .actions > ul > li a[href="#next"]').css('display','block');
                      }
                      if(data=='notmatch')
                      {
                               $("#success2").html("<span style='text-align:center;color:red;'>Captcha Not Matched !</span>");
                                $('.wizard > .actions > ul > li a[href="#next"]').css('display','none');
                      }
      
      
              },
              error:function(){
                      alert('error handling here'); 
              }
          });
      }
	  
   </script>
   <script src="//maps.googleapis.com/maps/api/js?key=AIzaSyAb6APxiRl6nun2CtaDR7yaolY7OLSuAq4&libraries=places&callback=initAutocomplete" 
      async defer></script>
   <script>
      var source,destination;
      function initAutocomplete() {
      	source = new google.maps.places.Autocomplete(
      		/** @type {!HTMLInputElement} */(document.getElementById('address1')),
      		{types: ['geocode']});
      	source.addListener('place_changed', fillsourcelatlong);	
      }
      function fillsourcelatlong() {
      	var place = source.getPlace();
      	//document.getElementById('latfrom').value=place.geometry.location.lat();
      	//document.getElementById('longfrom').value=place.geometry.location.lng();
      }
      
   </script>
</html>