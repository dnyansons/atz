<?php $this->load->view("affiliate/dashboard/header"); ?>
<div class="pcoded-content">
    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-header">
                    <div class="row align-items-end">
                        <div class="col-lg-8">
                            <div class="page-header-title">
                                <div class="d-inline">
                                    <h4>Account & Security </h4><br>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="page-header-breadcrumb">
                                <ul class="breadcrumb-title">
                                    <li class="breadcrumb-item">
                                        <a href="<?php echo base_url(); ?>affiliate/affiliate"> <i class="feather icon-home"></i> </a>
                                    </li>
                                    <li class="breadcrumb-item"><a href="#!">Account & Security</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="page-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="card">
                                <div class="card-block">
                                    <?php echo $this->session->flashdata("changepass");?>
                                    <h4 class="sub-title">Change Password</h4>
                                    <form class="ui-form" method="post" action="">
                                        <div class="form-group row">
                                            <label class="col-md-2" > Old Password</label>
                                            <div class="col-md-6">
                                                <input type="password" name="old_password" class="form-control" id="old_password" value="<?php echo set_value('old_password'); ?>" >
                                                <?php echo form_error('old_password'); ?>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-md-2" > New Password</label>
                                            <div class="col-md-6">
                                                <input type="password" name="new_password" class="form-control" id="new_password"  value="<?php echo set_value('new_password'); ?>" >
                                                <?php echo form_error('new_password'); ?>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-md-2" > Confirm Password</label>
                                            <div class="col-md-6">
                                                <input type="password" name="confirm_password" class="form-control" id="confirm_password"  value="<?php echo set_value('confirm_password'); ?>" >
                                                <?php echo form_error('confirm_password'); ?>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-md-2" for="togglePwd">Show Password</label>
                                            <div class="col-md-6">
                                                <!-- An element to toggle between password visibility -->
                                                <input type="checkbox" id="togglePwd">
                                            </div>
                                        </div>
                                        
                                                                           
                                        <div class="form-group row">
                                            <label class="col-md-2"></label>
                                            <div class="col-md-6">
                                                <div class="ui-form-item ui-form-item-last m-2 text-right">
                                                 <input value="Submit" class="btn btn-primary" type="submit">
                                                </div>
                                            </div>
                                        </div>
                                        
                                        
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                  
<?php $this->load->view("affiliate/dashboard/footer"); ?>
<script>
    $(document).ready(function(){
       $('#togglePwd').on('click', function(){
           if($(this).prop("checked") == true){
                $('#old_password').prop('type', 'text');
                $('#confirm_password').prop('type', 'text');
                $('#new_password').prop('type', 'text');
            } else {
                $('#old_password').prop('type', 'password');
                $('#confirm_password').prop('type', 'password');
                $('#new_password').prop('type', 'password');
            }
       });
    });
</script>