<?php $this->load->view('front/common/header'); ?>
<style>
    .login_btn {
        -webkit-box-shadow: 0 2px 5px 0 rgba(0,0,0,.16), 0 2px 10px 0 rgba(0,0,0,.12);
        box-shadow: 0 2px 5px 0 rgba(0,0,0,.16), 0 2px 10px 0 rgba(0,0,0,.12);
        padding: .84rem 2.14rem;
        font-size: .81rem;
        -webkit-transition: color .15s ease-in-out,background-color .15s ease-in-out,border-color .15s ease-in-out,-webkit-box-shadow .15s ease-in-out;
        -o-transition: color .15s ease-in-out,background-color .15s ease-in-out,border-color .15s ease-in-out,box-shadow .15s ease-in-out;
        transition: color .15s ease-in-out,background-color .15s ease-in-out,border-color .15s ease-in-out,box-shadow .15s ease-in-out;
        transition: color .15s ease-in-out,background-color .15s ease-in-out,border-color .15s ease-in-out,box-shadow .15s ease-in-out,-webkit-box-shadow .15s ease-in-out;
        margin: .375rem;
        border: 0;
        -webkit-border-radius: .125rem;
        border-radius: 1.5rem;
        cursor: pointer;
        text-transform: uppercase;
        white-space: normal;
        word-wrap: break-word;
        color: inherit;
        background:#fff;
    }
    .btn.pink-gradient {
        background: -webkit-linear-gradient(50deg,#FF5858,#ee4392);
        background: -o-linear-gradient(50deg,#FF5858,#ee4392);
        background: linear-gradient(40deg,#FF5858,#ee4392);
        color:#fff;
    }
    .user_card {      
        width: 400px;		
        margin: 100px auto;
        background: #fff;
        position: relative;
        display: flex;
        justify-content: center;
        flex-direction: column;
        padding: 10px;
        box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
        -webkit-box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
        -moz-box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
        border-radius: 5px;

    }

    .login_btn {
        width: 100%;
        background: #c0392b !important;
        color: white !important;
    }
    .login_btn:focus {
        box-shadow: none !important;
        outline: 0px !important;
    }
    .login_container {
        padding: 0 2rem;
    }
    .input-group-text {
        background: #c0392b !important;
        color: white !important;
        border: 0 !important;
        border-radius: 0.25rem 0 0 0.25rem !important;
    }
    .input_user,
    .input_pass:focus {
        box-shadow: none !important;
        outline: 0px !important;
    }
    .custom-checkbox .custom-control-input:checked~.custom-control-label::before {
        background-color: #c0392b !important;
    }
</style>

<div class="container h-100">
    <div class="d-flex justify-content-center h-100">
        <div class="user_card">
            <div class="px-5 form_container">
                <p class="text-center py-3"><img src="<?php echo base_url(); ?>assets/images/logo.png" width="180"></p>
                <?php echo $this->session->flashdata("affiliatemessage"); ?>
                <form method="post">
                    <div class="input-group mb-1">
                        <div class="input-group-append">
                            <span class="input-group-text"><i class="fa fa-user"></i></span>
                        </div>
                        <input type="text" name="username" class="form-control input_user" value = "<?php echo set_value("username"); ?>" placeholder="username" required="required">
                        
                    </div>
                     <?php echo form_error("username"); ?>
                    
                    <div class="input-group mb-1 mt-2">
                        <div class="input-group-append">
                            <span class="input-group-text"><i class="fa fa-key"></i></span>
                        </div>
                        <input type="password" name="password" class="form-control input_pass" placeholder="password" required="required">
                       
                    </div>
                    <?php echo form_error("password"); ?>
                    <div class="d-flex justify-content-center mt-3 login_container">
                        <button type="submit" class="btn login_btn">Login</button>
                    </div>
                </form>
            </div>

            <div class="mt-4">
                <div class="d-flex justify-content-center links">
                    Don't have an account? <a href="<?php echo base_url(); ?>affiliate/signup" class="ml-2" style="color:blue">Sign Up</a>
                </div>
                <div class="d-flex justify-content-center links">
                   <a href="<?php echo base_url(); ?>affiliate/login/forgotPassword">Forgot your password?</a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $this->load->view('front/common/footer'); ?>
