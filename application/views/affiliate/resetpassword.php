<?php $this->load->view('front/common/header'); ?>
<style>

    .btnCss{
        padding : 25px 0px 0px 0px;
        border-radius : 2px;
        width:50%;
    }

    .btnCss .btn{
        font-size: 1em;
        color: #fff;
        background:linear-gradient(40deg,#FF5858,#ee4392);			
        outline: none;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        border-bottom: 2px solid #0d002b;
    }

.mx-5 {
    margin-left: 5rem!important;
}
    .d-flex {
        display: flex !important;
    }

    .card
    {
        box-shadow: 0 3px 20px 0px rgba(0, 0, 0, 0.1);
        margin:6rem auto;
    }


    body{
        background: url('<?php echo base_url(); ?>assets/front/images/banner/affilatepasword.jpg') !important;
        background-repeat:no-repeat !important;
        background-size:100% !important;
        background-position:center center !important;

    }
.textWidth{
width:80%;
margin:0 auto;
}
</style>
<div class="container" >
    <div class="row full-height-vh m-0 d-flex  align-middle align-items-center justify-content-center">
        <div class="col-lg-5 col-sm-12">
            <div class="card text-center p-2">
                <div class="card-content">
                    <div class="card-body fg-image">
                        <div class="row">
                            <div class="col-lg-12 col-md-12 bg-white ">
                                <form  action="<?php echo base_url(); ?>affiliate/login/resetPassword"  method="post">
                                    <div class="row">
                                        <div class="col-md-12 outerBorder ">
                                            <div id="messege" style="color: red;"></div>
                                            <div class="pb-4" >
                                                <h2> Reset Password.</h2>
                                                <span> Enter Your New Password.</span>
                                            </div>
                                            <div class="textWidth">
                                                <input type="password" name="password" class="form-control" placeholder=" Enter Your Password" value= "" required>
                                                <?php echo form_error("password"); ?>
                                            </div>
                                            </br>
                                            <div class="textWidth">
                                                <input type="password" name="confirm_password" class="form-control" placeholder=" Confirm Password" value= "" required>
                                                <?php echo form_error("confirm_password"); ?>
                                            </div>
                                            <div class="btnCss mx-5">
                                                <input type="submit" value=" Submit " class="btn btn-danger btn-block" id="submit_button">
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $this->load->view('front/common/footer'); ?>
	