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
    input[type=number]::-webkit-inner-spin-button, 
    input[type=number]::-webkit-outer-spin-button { 
      -webkit-appearance: none; 
      margin: 0; 
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
        <form id="msform" action="<?php echo site_url();?>seller/createaccount/docs_verification" method="post" name="tax_info" enctype="multipart/form-data" accept-charset="utf-8">
     
            <ul id="progressbar">
                <li class="">Account Setup</li>
                <li class="">Company Profile</li>
                <li class="">Tax info</li>
                <li class="active">Docs Verify</li>
            </ul>

            <fieldset>
                 <p id='success_otp'><?php echo $this->session->flashdata('message'); ?></p>
                <h2 class="fs-title">Document Verification</h2>
                (* All Fields are mandatory )				
                <p class="text-mute text-left tex1">Select Type</p>
                <div class="">
                    <select class="form-control" name="user_type" id="user_type" required="">
                        <option value="">Select</option>
                        <option value="individual">Individual</option>
                        <option value="business">Business</option>
                    </select>
                </div>
				<?php echo form_error('user_type'); ?>
            
            <div class="individualDiv" style="display:none;">
                <p class="text-mute text-left tex1">Your Name</p>
                <div class="">

                    <input type="text" class="form-control txt_box" name="user_name" id="user_name" placeholder="Your Name" autocomplete="off"  required="" value="<?php echo set_value('user_name') ?>" />

                </div>
				<?php echo form_error('user_name'); ?>

                 <p class="text-mute text-left tex1">Pan Image</p>
                <div class="">
                    <input type="file" class="form-control" name="pan_file" placeholder="Pan Image" autocomplete="off"  />
                </div>
                <?php echo form_error('userfile'); ?>

                <p class="text-mute text-left tex1">PAN No</p>
                <div class="">
                    <input type="text" class="form-control validate_panno" name="pan_no" placeholder="PAN No" autocomplete="off" maxlength="16" onkeydown="upperCaseF(this)" value="<?php echo set_value('pan_no') ?>" />
                </div>
                <?php echo form_error('pan_no'); ?>
                   <p class="text-mute text-left tex1">GST Image (Optional)</p>
                <div class="">
                    <input type="file" class="form-control" name="gst_file" placeholder="GST Image" autocomplete="off" />
                </div>
                   
				 <p class="text-mute text-left tex1">GST No (Optional)</p>
                <div class="">
                    <input type="text" class="form-control validate_gstno" name="gst_no" placeholder="GST No" autocomplete="off" maxlength="15" onkeydown="upperCaseF(this)" value="<?php echo set_value('gst_no') ?>" />
                </div>
                <?php echo form_error('gst_no'); ?>
                
                 <p class="text-mute text-left tex1">Bank Name</p>
                <div class="">

                 <!--    <input type="text" class="form-control txt_box" name="bank_acc_detail"  placeholder="Bank Name." autocomplete="off"  /> -->
                <select name="bank_acc_detail" class="form-control">
                   <option value="">Select Bank</option>
                     <?php foreach($banks as $row){ ?>
                    <option value="<?php echo $row['id']; ?>" <?php if(set_value('bank_acc_detail') == $row['id']){ echo 'selected';} ?> ><?php echo $row['bank_name']; ?></option>
                     <?php } ?>
                </select>
                </div>
                <?php echo form_error('bank_acc_detail'); ?>

                 <p class="text-mute text-left tex1">Bank Acc.No</p>
                <div class="">

                    <input type="number" class="form-control back_acc" name="bank_acc_no" id="bank_acc_no" placeholder="Bank Acc.No." min="8" max="13" autocomplete="off"  />

                </div>
                <?php echo form_error('bank_acc_no'); ?>

                 <p class="text-mute text-left tex1">Bank IFSC</p>
                <div class="">

                    <input type="text" class="form-control txt_box" name="bank_ifsc"  placeholder="Bank IFSC" autocomplete="off"  maxlength="12" value="<?php echo set_value('bank_ifsc') ?>" />

                </div>
                <?php echo form_error('bank_ifsc'); ?>

                    <!-- <p>Allowed types are Jpg | Png | Pdf.</p> -->
              </div>  

              <!-- business Dis section -->     

              <div class="businessDiv" style="display:none;">
                <p class="text-mute text-left tex1">Legal Name</p>
                <div class="">

                    <input type="text" class="form-control txt_box" name="legal_name" id="legal_name" placeholder="Legal Name" autocomplete="off"  value="<?php echo set_value('legal_name') ?>"/>

                </div>
                <?php echo form_error('legal_name'); ?>

                 <p class="text-mute text-left tex1">Business Pan Card Image</p>
                <div class="">
                    <input type="file" class="form-control" name="pan_file1" placeholder="Pan Image" autocomplete="off"  />
                </div>
                <?php echo form_error('pan_file'); ?>

                <p class="text-mute text-left tex1">Business Pan No</p>
                <div class="">
                    <input type="text" class="form-control validate_panno" name="pan_no1" placeholder="PAN No" autocomplete="off" maxlength="16" onkeydown="upperCaseF(this)" value="<?php echo set_value('pan_no1') ?>" />
                </div>
                <?php echo form_error('pan_no1'); ?>
                
                <p class="text-mute text-left tex1">GST Image (Optional)</p>
                <div class="">
                    <input type="file" class="form-control" name="gst_file1" id="gst_file" placeholder="GST Image" autocomplete="off" />
                </div>
                <?php echo form_error('gst_file1'); ?>

                 <p class="text-mute text-left tex1">GST No (Optional)</p>
                <div class="">
                    <input type="text" class="form-control validate_gstno" name="gst_no1" placeholder="GST No" autocomplete="off" maxlength="16" onkeydown="upperCaseF(this)"  value="<?php echo set_value('gst_no1') ?>"/>
                </div>
                <?php echo form_error('gst_no1'); ?>
                
                 <p class="text-mute text-left tex1">Bank Name</p>
                <div class="">

                 <!--    <input type="text" class="form-control txt_box" name="bank_acc_detail1" placeholder="Bank Name" autocomplete="off" /> -->

                <select name="bank_acc_detail1" class="form-control">
                   <option value="">Select Bank</option>
                     <?php foreach($banks as $row){ ?>
                    <option value="<?php echo $row['id']; ?>" <?php if(set_value('bank_acc_detail1') == $row['id']){ echo 'selected';} ?> ><?php echo $row['bank_name']; ?></option>
                     <?php } ?>
                </select>
                </div>
                <?php echo form_error('bank_acc_detail1'); ?>

                   <p class="text-mute text-left tex1">Bank Acc.No</p>
                <div class="">

                    <input type="number" class="form-control back_acc" name="bank_acc_no1" id="bank_acc_no1" placeholder="Bank Acc.No"  min="8" max="13" autocomplete="off" value="" />

                </div>
                <?php echo form_error('bank_acc_no1'); ?>

                <p class="text-mute text-left tex1">Bank IFSC</p>
                <div class="">

                    <input type="text" class="form-control txt_box" name="bank_acc_ifsc1" placeholder="Bank IFSC." autocomplete="off" maxlength="12" value="<?php echo set_value('bank_acc_ifsc1') ?>" />

                </div>
                <?php echo form_error('bank_acc_ifsc1'); ?>

                <p class="text-mute text-left tex1">Incorporation Certificate No.</p>
                <div class="">
                    <input type="text" class="form-control txt_box" name="incorporation_no" placeholder="Incorporation No." autocomplete="off" value="<?php echo set_value('incorporation_no') ?>"/>
 
                </div>
                <?php echo form_error('incorporation_no'); ?>

                    <!-- <p>Allowed types are Jpg | Png | Pdf.</p> -->
              </div> 
            
            <div class="roleDiv" style="display:none;">
                <p class="text-mute text-left tex1">Select Role</p>
                <div class="">
                    <select class="form-control" name="user_role" id="user_role">
                        <option value="">Select</option>
                        <option value="director">Director</option>
                        <option value="proprietor">Proprietor</option>
                        <option value="partnership">Partnership</option>
                    </select>
                </div>
                <?php echo form_error('user_role'); ?>
            </div>

            <div class="docs_verify_userrole" style="display:none;">
                
                <p class="text-mute text-left tex1">Full Name.</p>
                <div class="">

                    <input type="text" class="form-control txt_box" name="full_name" id="full_name" placeholder="Full Name" autocomplete="off" value="<?php echo set_value('full_name') ?>" />

                </div>
                <?php echo form_error('full_name'); ?>

                 <p class="text-mute text-left tex1">Pan Card Number.</p>
                <div class="">
                    <input type="text" class="form-control" name="pan_no2" placeholder="Pan Card No" autocomplete="off" maxlength="16" onkeydown="upperCaseF(this)" onkeydown="upperCaseF(this)"  value="<?php echo set_value('pan_no2') ?>" />
                </div>
                <?php echo form_error('pan_no2'); ?>

                <p class="text-mute text-left tex1">Address.</p>
                <div class="">

                    <input type="text" class="form-control txt_box" name="userrole_address" id="userrole_address" placeholder="Address" autocomplete="off" value="<?php echo set_value('userrole_address') ?>" />

                </div>
                <?php echo form_error('userrole_address'); ?>

                <p class="text-mute text-left tex1">Email.</p>
                <div class="">
                    <input type="email" class="form-control" name="userrole_email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,3}$" placeholder="Email" autocomplete="off" />
                </div>
                <?php echo form_error('userrole_email'); ?>

                <p class="text-mute text-left tex1">Phone.</p>
                <div class="">

                    <input type="input" class="form-control" name="userrole_phone" id="userrole_phone" placeholder="Phone"  minlength="10" maxlength="10" autocomplete="off" />

                </div>
                <?php echo form_error('userrole_phone'); ?>

            </div>    
                <p class="text-left">By Clicking continue you are agree to atzcart<a href="<?php echo site_url();?>/policies-rules" target="_blank"> terms & Conditions</a></p>
                <br />
                <button type="submit" name="next" class="btn btn-primary btn-block b1t"  value="Next">Continue</button>
                <br />
                 <p> <a href="<?php echo base_url('seller/dashboard') ?>">Skip</a></p>
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
            
            
            // $(function(){
            //     $("input[name=gst_no]")[0].oninvalid = function () {
            //         this.setCustomValidity("Enter valid GST Number");
            //     };
            //     $("input[name=pan_no]")[0].oninvalid = function () {
            //         this.setCustomValidity("Enter valid GST Number.");
            //     };
            // });
            
            $("#user_type").on('change',function(e){
                var user_type=$(this).val();
                if(user_type=='')
                {
                     $('.individualDiv').hide();
                     $('.roleDiv').hide();
                      $('.businessDiv').hide();
                      $('.docs_verify_userrole').hide();
                }
               else if(user_type==='business')
                {
                        $('.roleDiv').show();
                        $('.individualDiv').hide();
                        $('.businessDiv').show();
                        $('.docs_verify_userrole').hide();
                }
                else
                {
                    $('.roleDiv').hide();   
                    $('.individualDiv').show();
                    $('.businessDiv').hide();
                    $('.docs_verify_userrole').hide();
                }   

            });


            $('#user_role').on('change',function(e){
                var userrole=$(this).val();
                if(userrole!=='')
                {
                    $('.docs_verify_userrole').show();                            
                }
                
                else
                {
                    $('.docs_verify_userrole').hide();
                }

            });
 

    $(function () {
    $("#user_name,#full_name,#legal_name").on('input', function (event) {
        var posCaret = this.selectionStart;
        this.value = this.value.replace(/^\s+/, '');
        setCaretPosition(this, posCaret);
    });
});

function setCaretPosition(elem, caretPos) {
    if(elem != null) {
        if(elem.createTextRange) {
            var range = elem.createTextRange();
            range.move('character', caretPos);
            range.select();
        }
        else {
            if(elem.selectionStart) {
                elem.focus();
                elem.setSelectionRange(caretPos, caretPos);
            }
            else
                elem.focus();
        }
    }
}

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
 $.validator.addMethod(".validate_panno", function(value, element)
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

   

     window.onload=function(){
   
     var inputBox = document.getElementById("bank_acc_no");

var invalidChars = [
  "-",
  "+",
  "e",
];
if(inputBox)
{
        inputBox.addEventListener("input", function() {
  this.value = this.value.replace(/[e\+\-]/gi, "");
});

inputBox.addEventListener("keydown", function(e) {
  if (invalidChars.includes(e.key)) {
    e.preventDefault();
  }
});

}


     var inputBox1 = document.getElementById("bank_acc_no1");

var invalidChars1 = [
  "-",
  "+",
  "e",
];
if(inputBox1)
{
        inputBox1.addEventListener("input", function() {
  this.value = this.value.replace(/[e\+\-]/gi, "");
});

inputBox1.addEventListener("keydown", function(e) {
  if (invalidChars1.includes(e.key)) {
    e.preventDefault();
  }
});

}


}

$("#userrole_phone").on("keyup",function(e){

    if(!$('#userrole_phone').val().match('[0-9]{10}'))  
    {
        // alert("Please put 10 digit mobile number");
        return false;
    } 
    else
    {
        return true;
    } 

});


$(document).ready(function(){
    $('[id^=userrole_phone]').keypress(validateNumber);
});


function validateNumber(event) {
    var key = window.event ? event.keyCode : event.which;
    if (event.keyCode === 8 || event.keyCode === 46) {
        return true;
    } else if ( key < 48 || key > 57 ) {
        return false;
    } else {
        return true;
    }
};


function validateEmail(email) {
    var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
    return emailReg.test( email );
}

    $("#userrole_email").on("keyup",function(e){

    var email = jQuery("input[type='email']").val();

    if(!validateEmail(email) )
    {
        return false;
    }
    else
    {
        return true;
    }
    // ( !validateEmail(email) ) ? return false : return true 

    // });

});

function upperCaseF(a){
    setTimeout(function(){
        a.value = a.value.toUpperCase();
    }, 1);
}

        </script>

    </body>
</html>
