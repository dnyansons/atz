<style>
input, textarea, select {
border: 1px solid #ccc !important;
}
.modal-dialog{
max-width: 500px;
margin: 1.75rem auto;
}	
.maincenter-box label{
margin:10px 0;
}
.card-header{
background:none;
}	
body{
height:auto;
} 
.card{
padding:1rem 1rem;
box-shadow: 2px 2px 3px rgba(0, 0, 0, .1); 
}
</style>
<!-- Services section -->
<div class="container">
<ol id="breadcrumb_CNEP" class="a-ordered-list a-horizontal breadcrumb mt-20">
			<li class="breadcrumb-item "><span class="a-list-item ">
				<a class="a-link-normal" href="<?php echo base_url(); ?>buyer-dashboard">
				Your Account
				</a>
				</span>
			</li>
			<li class="breadcrumb-item "><span class="a-list-item ">
				<a class="a-link-normal" href="<?php echo base_url(); ?>login-security">
				Login &amp; Security
				</a>
				</span>
			</li>
			
			
			<li class="breadcrumb-item active"><span class="a-list-item a-color-state">
				Change Password
				</span>
			</li>
		</ol>
    <br>
    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">

                <div class="page-body m-auto" style="width:400px;">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="card">

                                <div class="card-header">
                                    <h4 class="sub-title">Change Password</h4>
                                    <?php echo $this->session->flashdata("change_pass_error");?>
                                </div>
                                <div class="card-block">
                                    <div class="maincenter-box">
                                        <form class="ui-form" method="post" name="change_password">
                                            <div class="ui-form-item">
                                                <?php if($error){ echo $error;}?>
                                            </div>
                                            <div class="form-group row">
                                                <label class="control-label col-md-12"> Enter Old Password:</label>
                                                <div class="col-md-12">
                                                    <input type="password" id="old_password" name="old_password"
                                                        value="<?php echo set_value('old_password'); ?>"
                                                        class="form-control">
                                                 
                                                        <?php echo form_error('old_password'); ?>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                 <label class="control-label col-md-12">Enter New Password:</label>
                                                <div class="col-md-12">
                                                    <input type="password" id="new_password" name="new_password"
                                                        value="<?php echo set_value('new_password'); ?>"
                                                        class="form-control">
                                                    
                                                        <?php echo form_error('new_password'); ?>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                 <label class="control-label col-md-12"> Confirm Password:</label>
                                                <div class="col-md-12">
                                                    <input type="password" id="confirm_password" name="confirm_password"
                                                        value="<?php echo set_value('new_password'); ?>"
                                                        class="form-control">
                                                    
                                                        <?php echo form_error('confirm_password'); ?>
                                                </div>
                                            </div>

                                            <br>
                                            <ul class="p-1">
                                                <li><i class="fa fa-circle pr-1" style="font-size:0.5em;"></i>
                                                    <small>Password field must have at least one uppercase letter.</small>
                                                </li>
                                                <li><i class="fa fa-circle pr-1" style="font-size:0.5em;"></i>
                                                    <small>Password field must have at least one lowercase letter.</small>
                                                </li>
                                                <li><i class="fa fa-circle pr-1" style="font-size:0.5em;"></i>
                                                    <small>Password field must have at least one number.</small>
                                                </li>
                                                <li><i class="fa fa-circle pr-1" style="font-size:0.5em;"></i>
                                                    <small>Password field must be of at least 8 characters in length.</small>
                                                </li>
                                                <li><i class="fa fa-circle pr-1" style="font-size:0.5em;"></i>
                                                    <small>Password field must have at least one special character from <b>!@#$%^&*()\-_=+{};:,<.>~</b></small>
                                                </li>
                                            </ul>
                                            <input type="submit" value="Update"
                                                class="btn btn-primary btn-sm pull-right mt-2"
                                                style="width:150px;margin-bottom: 5px;margin-right: 15px;">


                                        </form>
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
