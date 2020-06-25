<?php $this->load->view("mobile/auth_common/header"); ?>
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/mobile/css/ionicons.min.css">
 <script type="text/javascript" src="<?php echo base_url()?>assets/mobile/js/jquery-3.2.1.min.js"></script>
 <script type="text/javascript" src="<?php echo base_url(); ?>assets/mobile/js/jquery.validate.min.js"></script>
<style>
    .btn-facebook {
    background-color: #405D9D;
    color: #fff;
    }
    .btn-twitter {
    background-color: #42AEEC;
    color: #fff;
    }
    .social .btn
    {
    width:200px;
    }
    .btn-danger {
    background-color: #cc0000!important;
    color: #fff;
    font-size: 15px;
    font-weight:500;
    padding: 9px;
    }
    .lo{
    box-shadow: 2px 2px 3px rgba(0, 0, 0, .1);}
    .md-form{
    margin-top: 0.5rem !important;
    margin-bottom:0.5rem !important;
    }

       .card-body{
    background-color: #ffffff;
    margin: 0px 13px;
    border: 1px solid;
    border-color: rgb(216 , 221, 230);
    }
    .card{
        background-color: #f4f6f9;
        height:66px !important;
    }

    
    label{
        padding: 0px 10px;
    }
    .form-control:focus {
            box-shadow: unset;
    }
    .form-control{
    border-radius: unset;
    background-clip: unset;
    border: 1px solid;
    transition: unset;
    border-color: rgb(216 , 221, 230);
    }
     .back{
    font-size: 20px;
    padding: 10px;
    cursor: pointer;
    float: left;
    }
    a{
        color: #000;
    }
     .text{
    text-align: left;
    margin-bottom: 10px;
    width: 100%;
   }
   
   .pass_char{
        font-size:10px;
        padding-left:3px;
        color:black;
        text-align:left;
    }
    #eye{
    float: right;
    margin-top: -29px;
    padding: 0px 10px;
    font-size: 14px;
    color: #cccfd2;
    }
  
</style>

<div class="card">

    <P class="text-center py-2 lo">
      <span>
        <a href="<?php echo site_url(); ?>">
            <i class="icon ion-android-arrow-back back "></i>
        </a>
        </span>
         <a href="<?php echo site_url(); ?>"><img src="<?php echo base_url(); ?>assets/mobile/images/logo/logo.png" width="140"></a>
    </p>

    <!--Card content-->
    <div class="card-body px-lg-5 pt-0">
        <h4 class=" text-center py-1">
            Sign Up
        </h4>
        <hr class="m-0">
        <p style="text-align:center;color:red;font-size:15px;">
            <?php  echo $this->session->flashdata('message') ; ?>
        </p>
        <!-- Form -->

        <form class="text-center" action="<?php echo base_url(); ?>register" method="post" style="color: #757575;" name="m_register_page">	  
             <div class="form-row">
                <div class="col">
                    <!-- First name -->
                    <div class="form-group">
                        <input type="text" name="first_name" id="materialRegisterFormFirstName" class="form-control"  placeholder="First Name" value="<?php echo set_value('first_name'); ?>"  >
                    </div>
                    <?php echo form_error('first_name'); ?>
                </div>
                <div class="col">
                    <!-- Last name -->
                    <div class="form-group">
                        <input type="text" name="last_name" id="materialRegisterFormLastName" class="form-control"  placeholder="Last Name" value="<?php echo set_value('last_name'); ?>"  >
                    </div>
                    <?php echo form_error('last_name'); ?>
                </div>
            </div>
            <div class="form-group">
                <input type="tel" maxlength="10" name="mobile_number" id="materialRegisterFormMobile" class="form-control" placeholder="Mobile Number" value="<?php echo set_value('mobile_number'); ?>"  >
                 <?php echo form_error('mobile_number'); ?>
            </div>
			<!-- E-mail -->
            <div class="form-group">  
                <input type="email" name="email" id="materialRegisterFormEmail" class="form-control" placeholder="E-mail" value="<?php echo set_value('email'); ?>"  >
                <?php echo form_error('email'); ?>
            </div>
            <!-- Password -->

            <div class="form-group">
                
                <input type="password" name="password" id="materialRegisterFormPassword" class="form-control" placeholder="Password" >
                <span id="eye" onclick="myFunction()"><i class="fa fa-eye-slash"></i></span>
                <?php echo form_error('password'); ?>
            </div>
            <div class="container">
                <ul class="pass_char">
                    <li> password field must be of at least 8 characters in length.</li>
                    <li> password field must have at least one uppercase letter.</li>
                    <li> password field must have at least one lower letter. </li>
                    <li> password field must have at least one number.</li>
                    <li> password field must have at least one special character.</li>
                </ul>
            </div>
            <!-- Sign up button -->
            <button class="btn btn-danger btn-rounded btn-block my-4 waves-effect z-depth-0" type="submit" id="btn_process"> Submit </button>
            <!-- Terms of service -->
            <p>Already have account?  
                <a href="<?php echo base_url();?>signin">Sign In</a>
        </form>
        <!-- Form -->
    </div>
</div>
<?php $this->load->view("mobile/auth_common/footer"); ?>
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
<script>
       jQuery.validator.addMethod("lettersonly", function(value, element) {
    return this.optional(element) || /^[a-z]+$/i.test(value);
}, "Letters only please"); 
    
    $(function(){
         $("form[name='m_register_page']").validate({
  
    rules: {
     first_name:{
         required : true,
         lettersonly: true
     },
     last_name:{
         required : true,
         lettersonly: true
     },
      mobile_number: {
          maxlength:10,
          required:true
      },

      email:{
          required : true,
          email : true,
      },
      password:"required",

    },
    
    messages: {
      first_name:"Enter first name",
      last_name:"Enter last name",
      mobile_number: "Please enter mobile number ",
      email:"Please enter email here ",
      password:"Please enter password here"
    },
    submitHandler: function(form) {
      form.submit();
    },
    errorClass:"text-danger text"
  });
    })

</script>
<script>
function myFunction(x) {
     
 var x = document.getElementById("materialRegisterFormPassword");
 if (x.type === "password") {
   x.type = "text";
 } else {
   x.type = "password";
 }
}
</script>
<script>
$('#eye').on('click', fav);
function fav(e) {
  $(this).find('.fa').toggleClass('fa fa-eye-slash fa fa-eye');
}

</script>
