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
                                    <h4>Affiliate Details</h4>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="page-header-breadcrumb">
                                <ul class="breadcrumb-title">
                                    <li class="breadcrumb-item">
                                        <a href="<?php echo site_url(); ?>admin/dashboard"> <i class="feather icon-home"></i> </a>
                                    </li>
                                    <li class="breadcrumb-item"><a href="<?php echo site_url(); ?>admin/affiliate">List</a></li>
                                    <li class="breadcrumb-item"><a href="#!">Affiliate Details</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <hr class="m-0 p-0">
                <div class="container-fluid mb-5 p-0">
                    <div class="row">
                        <div class="col-12 m-auto">
                            <form action="" method="POST" name = "affiliateSignup" id="affiliateSignup">
                                <div class="card mt-4">
                                    <div class="card-body ">
                                        <div class="row ">
                                            <div class="col-lg-6 col-xs-12 col-sm-6">
                                                <div class="form-group">
                                                    <label for="exampleInputEmail1">Enter Full Name </label>
                                                    <input type="text" class="form-control" name="fullname" value ="<?php echo $affiliateData->fullname; ?>" readonly="readonly">
                                                </div>
                                            </div>
                                            <div class="col-lg-offset-0 col-lg-6 col-xs-12 col-sm-6">
                                                <div class="form-group">
                                                    <label for="exampleInputEmail1">Company Name </label>
                                                   <input type="text" name="companyname"  class="form-control" value ="<?php echo $affiliateData->companyname; ?>" readonly="readonly">
                                                </div>
                                            </div>
                                            <div class="col-lg-offset-0 col-lg-6 col-xs-12 col-sm-6">
                                                <div class="form-group">
                                                    <label for="exampleInputEmail1">Phone No. </label>
                                                    <input type="email" name="mobile_number" id="admin_email" class="form-control" value ="<?php echo $affiliateData->mobileno; ?>" readonly="readonly">
                                                </div>
                                            </div>
                                            <div class="col-lg-offset-0 col-lg-6 col-xs-12 col-sm-6">
                                                <div class="form-group">
                                                    <label for="exampleInputEmail1">E-Mail </label>
                                                     <input type="email" name="email" class="form-control" value ="<?php echo $affiliateData->username; ?>" readonly="readonly">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card mt-4">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-lg-offset-0 col-lg-6 col-xs-12 col-sm-6">
                                                <div class="form-group">
                                                    <label for="exampleInputEmail1">Site Name </label>
                                                     <input type="text" name="sitename" class="form-control" value ="<?php echo $affiliateData->sitename; ?>" readonly="readonly">
                                                </div>
                                            </div>
                                            <div class="col-lg-offset-0 col-lg-6 col-xs-12 col-sm-6">
                                                <div class="form-group">
                                                    <label for="exampleInputEmail1">Url </label>
                                                      <input type="text" name="siteurl" class="form-control" value ="<?php echo $affiliateData->url; ?>" readonly="readonly">
                                                </div>
                                            </div>
                                            <div class="col-lg-offset-0 col-lg-6 col-xs-12 col-sm-6">
                                                <div class="form-group">
                                                    <label for="exampleInputEmail1">Generate Ref URL </label>
                                                   <input type="text" name="referenceUrl" class="form-control" value ="<?php echo base_url(); ?>ref?id=<?php echo $affiliateData->id; ?>&url={Your Product Url}" readonly="readonly">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                 <?php if($affiliateData->status == "Pending" || $affiliateData->status == "Rejected"){ ?>
                                <div class="card mt-4">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-lg-offset-0 col-lg-6 col-xs-12 col-sm-6">

                                                <div class="form-group">
                                                    <label for="exampleInputEmail1">Rate <span style = "color:red">*</span></label>
                                                    <input type="text" name="rate" class="form-control"  required="required" placeholder="Rate" >
                                                    <input type="hidden" name="affid" value="<?php echo $affiliateData->id; ?>">
                                                    <?php echo form_error("rate"); ?>
                                                </div>
                                            </div>
                                            <div class="col-lg-offset-0 col-lg-6 col-xs-12 col-sm-6">
                                                <div class="form-group">
                                                    <label for="exampleInputEmail1">Per Order Completion <span style = "color:red">*</span></label>
                                                    <input type="text" name="per_order" class="form-control"  required="required" placeholder="Per Order Click" >
                                                    <?php echo form_error("per_order"); ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php } else { ?>
                                  <div class="card mt-4">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-lg-offset-0 col-lg-6 col-xs-12 col-sm-6">

                                                <div class="form-group">
                                                    <label for="exampleInputEmail1">Rate </label>
                                                    <input type="text" name="rate" class="form-control"  value="<?php echo $affiliateData->rate; ?> " required="required" placeholder="Rate" readonly="readonly">
                                                    <input type="hidden" name="affid" value="<?php echo $affiliateData->rate; ?> " readonly="readonly">

                                                </div>
                                            </div>
                                            <div class="col-lg-offset-0 col-lg-6 col-xs-12 col-sm-6">
                                                <div class="form-group">
                                                    <label for="exampleInputEmail1">Per Order Completion </label>
                                                    <input type="text" name="per_order" class="form-control" value="<?php echo $affiliateData->perclick; ?> " readonly="readonly">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                                <div class="card mt-4">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-lg-offset-0 col-lg-6 col-xs-12 col-sm-6">
                                                <div class="form-group">
                                                    <label for="exampleInputEmail1">Beneficiary Name </label>
                                                    <input type="text" name="benfryname" class="form-control" value ="<?php echo $affiliateData->beneficiaryname; ?>" readonly="readonly">
                                                </div>
                                            </div>
                                            <div class="col-lg-offset-0 col-lg-6 col-xs-12 col-sm-6">
                                                <div class="form-group">
                                                    <label for="exampleInputEmail1">Account Number </label>
                                                     <input type="text" name="accno" class="form-control" value ="<?php echo $affiliateData->accno; ?>" readonly="readonly">
                                                </div>
                                            </div>
                                            <div class="col-lg-offset-0 col-lg-6 col-xs-12 col-sm-6">
                                                <div class="form-group">
                                                    <label for="exampleInputEmail1">Bank Name </label>
                                                    <input type="text" name="bankname" class="form-control" value ="<?php echo $affiliateData->bankname; ?>" readonly="readonly">
                                                </div>
                                            </div>
                                            <div class="col-lg-offset-0 col-lg-6 col-xs-12 col-sm-6">
                                                <div class="form-group">
                                                    <label for="exampleInputEmail1">IFSC Code </label>
                                                      <input type="text" name="ifsccode" class="form-control" value ="<?php echo $affiliateData->ifscno; ?>" readonly="readonly">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                              
                                <?php if($affiliateData->status == "Rejected" || $affiliateData->status == "Pending"){ ?>
                                           <button type="submit" id="submit_brand" class="btn btn-primary float-right" id="primary-popover-content">Approve</button>
                                <?php } ?>
                                  
                            </form>
                             <?php if($affiliateData->status == "Approved" || $affiliateData->status == "Pending"){ ?>
                                        <a data-toggle="modal" data-target="#rejectModal"  > <button type="button" class="btn btn-primary float-right mr-2" id="primary-popover-content"  >Reject</button></a>
                            <?php } ?>
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
<!--reject affiliate Modal-->
<div class="modal fade" id="rejectModal" tabindex="-1" role="dialog" style="z-index: 1050; display: none;" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title ban-title">Reject Affiliate</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body" id="banModalData">
                <form action="<?php echo base_url(); ?>admin/affiliate/adminActionOnRejectedAffiliates" method="POST" id="submit_form">
                    <div class="form-group">Affiliate : <?php echo $affiliateData->username; ?></div>
                    <div class="form-group"><label for="comment"><b>Reject Reason</b></label><textarea required="" class="form-control" name="rejectReason" id="rejectReason"></textarea>
                        <input type="hidden" name="affid"  value="<?php echo $affiliateData->id; ?>">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default waves-effect " data-dismiss="modal">Cancel</button>
                <button type="button" id="reject" class="btn btn-primary waves-effect waves-light " data-dismiss="modal" >Yes, Reject.</button>
            </div>
        </div>
    </div>
</div>
<?php $this->load->view("admin/common/footer"); ?>
<script>
    $(document).on("click","#reject",function(){
        $("#submit_form").submit();
    });
</script>