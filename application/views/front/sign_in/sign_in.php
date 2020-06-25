<?php $this->load->view("front/common/header"); ?>
<style>
    @import url(<?php echo base_url(); ?>assets/front/css/login.css);
</style>
<div id="content" class="clearfix">
    <div id="screen-banner">
    <div class="container login-container">
        <div class="row">               
            <div class="col-md-4 col-sm-6 login-form-2">                    
                <form method="post" name="login_form">
                    
                    <input type="hidden" name="refferer" value="<?php echo $this->session->userdata("refferer"); ?>" />
                    <div align="center" style="color: red;">
                        <?php echo $this->session->flashdata("message"); ?>
                    </div>						  
                    
                    <div class="form-group mb-3">
                        <label for="username" class="mb-2">Enter email or mobile:</label>
                        <input type="text" name="username"  id="fm-login-id" class="form-control"  placeholder="Username" value="" autocorrect="off" autocomplete="off"/>
                        <div class="text-danger"><?php echo form_error('username'); ?></div>
                    </div>							

                    <div class="form-group mb-3">                            
                        <label for="password" class="mb-2">Password:</label>
                        <input type="password" class="form-control" name="password" placeholder=" Password" value=""  autocomplete="off"/>

                        <div class="text-danger">
                            <?php echo form_error('password'); ?></div>
                    </div>

                    <div id="login-submit"  class="form-group">
                        <input value="Sign In" class="btnSubmit" type="submit">
                    </div>


                    <div id="register-link" class="register mt-2">
                        <span class="text-left"><a href="<?php echo site_url(); ?>login/forgot_password"
                                        target="_blank" class="text-info float-right">Forgot Password?</a>
                        </span>
                        <span class="text-right"><a href="<?php echo base_url(); ?>signup" class="text-info" target=" _blank">Join Free</a></span>
                    </div>

                    <!--	
					    <div class="login-login-links">
                                    <span class="thirdpart-login-text">
                                    Sign in with:</span>
                                    <span id="thirdpart-login">
                                    <a href="<?php echo $fburl; ?>" class="btn btn-primary social-login-btn social-facebook"
                                    title="sign in with facebook"> <i class="fa fa-facebook"></i></a>
                                    <a href="<?php echo $google_login_url; ?>" class="btn btn-primary social-login-btn social-google" title="sign in with google"><i class="fa fa-google-plus"></i></a>
                                    </span>
                            </div>-->
                </form>
            </div>
        </div>
    </div>
</div>

</div>
<?php $this->load->view("front/common/footer"); ?>