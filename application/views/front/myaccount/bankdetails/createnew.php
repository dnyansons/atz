<?php $this->load->view('front/common/header'); ?>

<div id="" style="background:#fff;">
    <div>
        <div id="about">
            <div class="lp-about">
                <div role="toolbar" dir="ltr" class="next-slick next-slick-inner next-slick-hoz">
                    <div class="next-slick-container next-slick-initialized">
                        <div class="next-slick-list">
                            <div class="next-slick-track"
                                style="opacity: 1; width: 4047px; transform: translate3d(0px, 0px, 0px);">
                                <div class="next-slick-slide next-slick-active slider-img-wrapper"
                                    data-spm="inspection_header-header-area" data-index="-1" style="width: 1349px;"><img
                                        src="<?php echo base_url();?>assets/front/images/banner/bank.jpg"
                                        alt="inspetion service is a solution to your worries"
                                        data-spm="inspection_header-img">
                                    <div class="main-slider-wrapper">
                                        <div class="w-1000">
                                            <h1 style="color:#fff;">Bank Details</h1>
                                            <div class="" style="text-align:left; color:#fff; font-size:16px;padding-top:15px;">
                                              Manage Your Bank Details </div>
                                        </div>
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                </div>
                <div class="ab-ways w-1000" id="advantages">
                    <br />
                    
                    
                    <div class="next-tabs next-tabs-capsule next-medium">
                        
                        <div class="row justify-content-md-center">
                            <div class="col-12">
                                <nav>
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="<?php echo site_url();?>">Home</a></li>
                                        <li class="breadcrumb-item"><a href = "<?php echo site_url();?>buyer/addbankdetails">Bank</a></li>
                                        <li class="breadcrumb-item active">Add</li>
                                    </ol>
                                </nav>
                            </div>
                        </div>
                        <div class="row justify-content-md-center">
                            <div class="col-8 text-left">
                                <?php if(empty($bank->acc_no))
                                { ?>
                                <h4>Add Bank Details</h4> <?php } else { ?>
                                <h4>Update Bank Details</h4>
                                <?php } ?>
                                <form action="<?php echo site_url();?>buyer/addbankdetails/addnew" method="post" name="add_address"> 
                                
                                <div class="form-group pb-3">
                                    <label for="acc_no">Account Number *</label>
                                    <input type="text" class="form-control" name="acc_no" id="acc_no" value="<?php echo $bank->acc_no;?>" onkeypress="return restrictAlphabets(event)">
                                </div>
								<?php echo form_error('acc_no'); ?>
								
                                <div class="form-group pb-3">
                                    <label for="bank_name">Bank Name *</label>
                                    <input type="text" class="form-control"  maxlength="15" name="bank_name" id="bank_name" value="<?php echo $bank->bank_name;?>" onkeypress="return restrictNumber(event)">
                                </div>
								<?php echo form_error('bank_name'); ?>
								
                                <div class="form-group pb-3">
                                    <label for="ifsc_code">IFSC Code *</label>
                                    <input type="text" class="form-control" name="ifsc_code" id="street1" value="<?php echo $bank->ifsc_code;?>">
                                </div>
								<?php echo form_error('ifsc_code'); ?>
								
                                <div class="form-group pb-3">
                                    <label for="acc_holder_name">Account Holder Name *</label>
                                    <input type="text" class="form-control txtarea" name="acc_holder_name" id="acc_holder_name" value="<?php echo $bank->acc_holder_name;?>" onkeypress="return restrictNumber(event)">
                                </div>
								<?php echo form_error('acc_holder_name'); ?>
								
                               
                               <br>
                               <?php if($data->acc_no!='') {  ?>
                               <button type="submit" class="btn btn-danger pull-right">Add Details</button> <?php } else { ?>
                              <button type="submit" class="btn btn-danger pull-right">Update Details</button>
                                   <?php } ?>
                                </form>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <br />
        
    </div>
</div>
<?php $this->load->view('front/common/footer'); ?>
<script>
    function restrictNumber(e){
        var x=e.which||e.keycode;
        if((x>=65 && x<=90) || (x>=97 && x<=122) || x==8 )
            return true;
        else
            return false;
    }

    function restrictAlphabets(e){
        var x=e.which||e.keycode;
        if((x>=48 && x<=57))
            return true;
        else
            return false;
    }
</script>
