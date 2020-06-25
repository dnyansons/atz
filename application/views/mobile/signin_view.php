<?php $this->load->view("mobile/auth_common/header"); ?>
<!-- Material form login -->
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

 
</style>

<div class="card">  
    <P class="text-center  py-2 lo">
    <span>
        <a href="<?php echo site_url(); ?>">
        <i class="icon ion-android-arrow-back back"></i>
        </a>
    </span>
        <a href="<?php echo site_url();?>"><img src="<?php echo base_url(); ?>assets/mobile/images/logo/logo.png" width="140"></a>
    </p>
    <!--Card content-->
    <div class="card-body px-lg-5 pt-1">

        <h4 class=" text-center py-0">
            Sign In
        </h4>
        
        <span class="text-center text-danger"><?php echo $this->session->flashdata("message"); ?></span>
        <!-- Form -->
        <form action="<?php echo site_url(); ?>signin" class="text-center" method="post" style="color: #757575;" name="m_sigin_page">
            <!-- Email -->
            <div class="form-group">
                <input type="text" name="email" id="materialLoginFormEmail" class="form-control" placeholder="Email / Mobile Number">
                <?php echo form_error("email");?>
            </div>

            <!-- Password -->
            <div class="form-group">
                <input type="password" name="password" id="materialLoginFormPassword" class="form-control" placeholder="Password">
                <?php echo form_error("password");?>
            </div>
            
            <div class="d-flex justify-content-around">
                <div>
                    <!-- Remember me -->
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="materialLoginFormRemember">
                        <label class="form-check-label" for="materialLoginFormRemember" style="font-size: 14px;">Remember Me</label>
                    </div>
                </div>
                <div>
                    <!-- Forgot password -->
                    <a href="<?php echo site_url(); ?>signin/forgot-password" style="font-size: 14px;">Forgot Password?</a>

                </div>
            </div>

            <!-- Sign in button -->
            <button class="btn btn-danger  btn-block my-4" type="submit" id="signin">Sign in</button>
            <!-- Register -->
            <p>Not a Member?
                <a href="<?php echo base_url(); ?>register">Register</a>
            </p>
            
            <input type="hidden" name="hide_prev_page" value="<?php echo $this->session->userdata('prev_page');?>">

            <!-- Social login -->
          <!--   <p>or sign in with:</p>
            <div class="col-12 social">	
                <a href="<?php //echo $this->facebook_mobile->login_url(); ?>" class="btn btn-sm btn-facebook"> <i class="fab fa-facebook-f"></i>  Login with facebook</a><br>
                <a href="<?php //echo $this->google_mobile->get_login_url(); ?>" class="btn btn-sm btn-twitter"> <i class="fab fa-google"></i>  Login with Google</a>
            </div> -->  
        </form>
        <!-- Form -->
    </div>
    <br><br>
</div>
<script>
    //Set To Redirect To Product Overview Page
    $("#hide_redirect_pview").val(localStorage.getItem("redirect_product_view"));
</script>
<script>
    //remove from Redirect To Product Overview Page
   $("#signin").click(function(){
       localStorage.removeItem("redirect_product_view");
   })
</script>
<script>
      $("form[name='m_sigin_page']").validate({
    rules: {
      email:"required",
      password:"required",
    },
    
    messages: {
  
      email:"please enter email here ",
      password:"please enter password here"
            
    },
    submitHandler: function(form) {
      form.submit();
    },
    errorClass:"text-danger text"
  });
</script>

<?php $this->load->view("mobile/auth_common/footer"); ?>

