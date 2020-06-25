<?php $this->load->view("mobile/common/header"); ?>
<style>
    input[type="text"], input[type="email"], input[type="submit"] {

        border: 1px solid #dae2ed;
    }
    body{background: #fff !important;}
</style>
<div id="container">
    <ai-header>
        <div class="header-container" style="position: fixed;">
            <div class="header-wrap" ab-test-bucket="">
                <div class="inner ripple rtl-icon">
                    <a href="<?php echo site_url();?>m/home"> <i class="icon ion-android-arrow-back"></i></a>
                </div>
                <div class="master">
                    <div class="title">
                        <title>
                            Bank Details
                        </title>
                    </div>
                </div>
            </div>
        </div>
    </ai-header>
    <div class="">
        <div id="about mb-5">
            <div class="lp-about">
                <div style="background: #000" class="">
                    <div class="next-slick-container next-slick-initialized">
                        <div class="next-slick-list">
                            <div class="next-slick-track text-center"
                                style="opacity: 1;  transform: translate3d(0px, 0px, 0px);">
                                <div   style="background:url(<?php echo base_url();?>assets/front/images/banner/bank.jpg)no-repeat; background-size:cover; height:150px">

                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="ab-ways w-1000 container" id="advantages">
                    <br />
                    <div class="next-tabs next-tabs-capsule next-medium">
                        <div class="justify-content-md-center">
                            <?php echo $this->session->flashdata('message'); ?>
                            <div class="col-12 text-left m-0 p-0">
                                <?php if(empty($bank->acc_no)){ ?>
                                <h5><strong style="font-size: 16px">Add Bank Details<strong></h5>
                               <form  method="post" name="bank_details" id="bank_details">
                                <div class="form-group ">
                                    <label for="acc_no">Account Number *</label>
                                    <input type="text" class="form-control"  maxlength="15" name="acc_no" id="acc_no" value=""  >
                                </div>
                                <?php echo form_error('acc_no');?>         
                                <div class="form-group ">
                                    <label for="bank_name">Bank Name *</label>
                                    <input type="text" class="form-control"  maxlength="15" name="bank_name" id="bank_name" value="" >
                                </div>
                                <?php echo form_error('bank_name');?>
                                
                                <div class="form-group ">
                                    <label for="ifsc_code">IFSC Code *</label>
                                    <input type="text" class="form-control" name="ifsc_code" id="ifsc_code" maxlength="15" id="street1" value="">
                                </div>
                                <?php echo form_error('ifsc_code');?>
                                <div class="form-group">
                                    <label for="acc_holder_name">Account Holder Name *</label>
                                    <input type="text" class="form-control txtarea" name="acc_holder_name" id="acc_holder_name" value="" >
                                </div>
                                <?php echo form_error('acc_holder_name');?>
                                <button type="submit" class="btn btn-danger pull-right" id="bank_submit">Add Details</button>
                                <br>
                                </form>
                                <?php } else { ?>
                               <div class="view_account">
                                        <div class="row  p-0 m-0">
                                              <div class="col-7 p-0">
                                              <h5> <strong style="font-size: 16px">View Bank Details</strong></h5>
                                          </div>
                                          <div class=" col-5 p-0">
                                              <button class="btn btn-primary btn-sm pull-right btn_update"><i class="fa fa-edit"></i> Edit</button>
                                          </div>
                                        <table class="table table-bordered">
                                          <tr>
                                              <th scope="col"><strong>A/C No.</strong></th>
                                            <td><?php echo $bank->acc_no;?></td>
                                          </tr>
                                          <tr>
                                            <th scope="col"><strong>Bank Name</strong></th>
                                             <td><?php echo $bank->bank_name;?></td>
                                          </tr>
                                          <tr>
                                            <th scope="col"><strong>IFSC Code</strong></th>
                                            <td><?php echo $bank->ifsc_code;?></td>
                                          </tr>
                                          <tr>
                                            <th scope="col"><strong>Name</strong></th>
                                            <td><?php echo $bank->acc_holder_name;?></td>
                                          </tr>
                                        </table>
                                    </div>
                               </div>
                                <div id="bank_details" style="display:none">
                                    <form  method="post" name="bank_details">
                                     <h5><strong style="font-size: 16px">Update Bank Details<strong></h5>
                                     <div class="form-group ">
                                         <label for="acc_no">Account Number *</label>
                                         <input type="text" class="form-control"  maxlength="15" name="acc_no" id="acc_no" value="<?php echo $bank->acc_no;?>"  >
                                     </div>
                                     <?php echo form_error('acc_no'); ?>         
                                     <div class="form-group ">
                                         <label for="bank_name">Bank Name *</label>
                                         <input type="text" class="form-control"  maxlength="15" name="bank_name" id="bank_name" value="<?php echo $bank->bank_name;?>" >
                                     </div>
                                     <?php echo form_error('bank_name'); ?>

                                     <div class="form-group ">
                                         <label for="ifsc_code">IFSC Code *</label>
                                         <input type="text" class="form-control" name="ifsc_code" id="ifsc_code" maxlength="15" id="street1" value="<?php echo $bank->ifsc_code;?>">
                                     </div>
                                     <?php echo form_error('ifsc_code'); ?>

                                     <div class="form-group">
                                         <label for="acc_holder_name">Account Holder Name *</label>
                                         <input type="text" class="form-control txtarea" name="acc_holder_name" id="acc_holder_name" value="<?php echo $bank->acc_holder_name;?>" >
                                     </div>
                                     <?php echo form_error('acc_holder_name'); ?>
                                     <button type="submit" class="btn btn-danger pull-right" id="bank_update">Update Details</button>
                                     <br>
                                     </form>
                                </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
</div>
<?php $this->load->view("mobile/common/footer"); ?>
<script>
    jQuery.validator.addMethod(
        "regex",
        function(value, element, regexp) {
            var re = new RegExp(regexp);
            return this.optional(element) || re.test(value);
        },
        "Please check your input."
    );

    $(function() {
        $("form[name='bank_details']").validate({
            rules: {
                acc_no: "required",
                bank_name: "required",
                ifsc_code: "required",
                acc_holder_name: "required",
            },
            acc_no : {
                maxlength : 15,
                minlength : 6,
                digits : true
            },
            messages: {
                acc_no: "Account number is required : enter only characters",
                bank_name: "Bank name is required : enter only Alphabates",
                ifsc_code: "IFSC code is required",
                acc_holder_name: "Account holder name is required : enter only Alphabates"
            },
            submitHandler: function(a) {
                a.submit();
            },
            errorClass: "text-danger text"
        });
    });
    $(".btn_update").click(function(){
        $(".view_account").css("display","none");
        $("#bank_details").css("display","block");
    })
</script>
