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
                                    <h4>Affiliates Billing </h4>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="page-header-breadcrumb">
                                <ul class="breadcrumb-title">
                                    <li class="breadcrumb-item">
                                        <a href="<?php echo site_url();?>admin/dashboard"> <i class="feather icon-home"></i> </a>
                                    </li>
                                    <li class="breadcrumb-item"><a href="<?php echo site_url();?>admin/affiliate">Affiliate</a></li>
                                    <li class="breadcrumb-item"><a href="#!">Billing</a></li>
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
                                    <h4 class="sub-title">Billing</h4>
                                    <?php echo $this->session->flashdata("message");?>
                                    <form method="post" id="form_submit">
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label text-right"></label>
                                            <div class="col-sm-3">
                                                <label class="col-form-label"><strong>Total Orders</strong></label>
                                                <input type="text" name="totalCount" class="form-control" value="<?php echo $totalCount; ?>" readonly="readonly">
                                            </div>
                                            <div class="col-sm-3">
                                                <label class=" col-form-label"><strong>Billing Amount rs.</strong></label>
                                                <input type="text" name="billingAmount" class="form-control" value="<?php echo $billingAmount; ?>" readonly="readonly">
    
                                                <input type="hidden" name="affId" class="form-control" value="<?php echo $affid; ?>" readonly="readonly">
                                            </div>
                                        </div>
                                         </br>
                                        <hr>
                                        </br>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Billing Status<span style="color:red"> *</span></label>
                                            <div class="col-sm-3">
                                                <select name="paymentStatus" id="paymentStatus" class="form-control" value="<?php echo set_value("paymentStatus"); ?>" required>
                                                    <option value="">Payment status</option>
                                                    <option value="Paid">Paid</option>
                                                    <option value="Hold">Hold</option>
                                                </select>
                                                <?php echo form_error("paymentStatus");?>
                                            </div>
                                            <div class="col-sm-3" id="referenceId" >
                                                <input type="text" name="referenceId" class="form-control" value="<?php echo set_value("referenceId"); ?>" placeholder="Reference #" >
                                            </div>
                                            <div class="col-sm-3" id="paymentDate">
                                                <input type="text" name="paymentDate"  class="form-control"  id="date" value="<?php echo set_value("paymentDate"); ?>" placeholder="Payment Date" >
                                            </div>
                                            <div id="reason" class="row">
                                             <div class="col-md-4">Hold Reason<span style="color:red"> *</span></div>
                                             <div class="col-md-4">
                                                <textarea rows="3" cols="40" name="holdreason" id="description"></textarea>
                                             </div>
                                            </div>
                          
                                        </div>
                                            <div class="col-md-11">
                                                <button type="submit" id="submit_form" class="btn btn-primary float-right" >Submit</button>
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
</div>
</div>
</div>
</div>
</div>
<?php $this->load->view("admin/common/footer"); ?>

<script>
        $("#reason").hide();
        $(document).on("change","#paymentStatus",function(){
            var paymentStatus = $(this).val();
            if(paymentStatus == "Hold")
            {
                 $("#referenceId").prop('required',false);
                 $("#paymentDate").prop('required',false);
                 $("#referenceId").hide();
                 $("#paymentDate").hide(); 
                 $("#description").prop('required',true);
                 $("#reason").show();
            }else{
                $("#referenceId").prop('required',true);
                $("#paymentDate").prop('required',true);
                 $("#referenceId").show();
                 $("#paymentDate").show();
            }
        });


    $("#date").dateDropper({
        format: "d-m-Y",
        dropWidth: 200,
        dropPrimaryColor: "#1abc9c",
        dropBorder: "1px solid #1abc9c",
        maxYear: "2020",
    });


</script>
