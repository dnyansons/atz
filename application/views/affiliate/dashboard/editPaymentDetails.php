<?php $this->load->view("admin/common/header"); ?>
<div class="pcoded-content">
    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-header">
                    <div class="row align-items-end">
                        <div class="col-lg-8">
                            <div class="page-header-title">
                                <div class="d-inline">
                                    <h4>Edit Payment Details</h4>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="page-header-breadcrumb">
                                <ul class="breadcrumb-title">
                                    <li class="breadcrumb-item">
                                        <a href="<?php echo site_url(); ?>affiliate/affiliate"> <i class="feather icon-home"></i> </a>
                                    </li>
                                    <li class="breadcrumb-item"><a href="#!">Payment Details</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="page-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="card">
                                <div class="card-header">
                                    <div class="card-header-right">
                                        <i class="icofont icofont-spinner-alt-5"></i>
                                    </div>
                                </div>
                                <div class="card-block">

                                    <form method="post">
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Benificiary Name</label>
                                            <div class="col-sm-8">
                                                <input type="text" name="benfryname" class="form-control" value ="<?php echo set_value("benfryname",$user->beneficiaryname); ?>" required="required">
                                                <?php echo form_error("benfryname"); ?>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Account Number</label>
                                            <div class="col-sm-8">
                                                <input type="text" name="accno" class="form-control" value ="<?php echo set_value("accno",$user->accno); ?>" required="required">
                                                <?php echo form_error("accno"); ?>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Bank Name</label>
                                            <div class="col-sm-8">
                                                <input type="text" name="bankname" class="form-control" value ="<?php echo set_value("bankname",$user->bankname); ?>" required="required">
                                                <?php echo form_error("bankname"); ?>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">IFSC Number</label>
                                            <div class="col-sm-8">
                                                <input type="text" name="ifsccode" class="form-control" value ="<?php echo set_value("ifsccode",$user->ifscno); ?>" required="required">
                                                <?php echo form_error("ifsccode"); ?>
                                            </div>
                                        </div>
                                       
                                            <button type="submit" id="submit_brand" class="btn btn-primary float-right" id="primary-popover-content">Update</button>    
                                    </form>
                                        <a href="<?php echo base_url(); ?>affiliate/affiliate/affiliateProfile" > <button type="button" class="btn btn-primary float-right mr-2" id="primary-popover-content"  >Cancel</button></a>
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

<?php $this->load->view("admin/common/footer"); ?>

