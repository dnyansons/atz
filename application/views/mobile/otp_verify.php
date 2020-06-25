<?php $this->load->view("mobile/auth_common/header"); ?>
<!-- Material form login -->
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/mobile/css/ionicons.min.css">
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
	box-shadow: 0 2px 5px 0 rgba(0,0,0,.16), 0 2px 10px 0 rgba(0,0,0,.12);
    }
    .card{
        background-color:none;
        height: 100%;
		box-shadow:none!important;
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
</style>
<div class="card">  
    <p class="text-center  py-2 lo">
        <a href="<?php echo site_url();?>register">
            <i class="icon ion-android-arrow-back back "></i>
        </a>
        <a href="<?php echo site_url(); ?>"><img src="<?php echo base_url(); ?>assets/mobile/images/logo/logo.png" width="140"></a>
    </p>
    <!--Card content-->
    <div class="card-body px-lg-5 pt-1">

        <h4 class=" text-center py-0">
            Enter OTP
        </h4>
        <hr class="m-0">
        
        <span class="text-center"><?php echo $this->session->flashdata("message"); ?></span>
        <!-- Form -->
        <form action="<?php echo site_url(); ?>register/verify_otp" class="text-center" method="post" style="color: #757575;">
            <?php echo form_error("otp_txt");?>
            <div class="form-group">
                <input type="text" name="otp_txt" id="materialLoginFormEmail" class="form-control" Placeholder="Enter OTP">
            </div>
            <a href="<?php echo site_url();?>m/register/resend_otp">Resend OTP</a>
            <!-- Sign in button -->
            <button class="btn btn-danger  btn-block my-4" type="submit">Submit OTP</button> 
        </form>
        <!-- Form -->
    </div>
    <br><br>
</div>

<?php $this->load->view("mobile/auth_common/footer"); ?>

