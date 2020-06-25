<?php $this->load->view("user/common/header");?>
<div class="pcoded-content">
    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-header">
                    <div class="row align-items-end">
                        <div class="col-lg-8">
                            <div class="page-header-title">
                                <div class="d-inline">
                                    <h4>Add Bank</h4>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="page-header-breadcrumb">
                                <ul class="breadcrumb-title">
                                    <li class="breadcrumb-item">
                                        <a href="<?php echo base_url() ?>seller/dashboard"> <i class="feather icon-home"></i> </a>
                                    </li>
                                    <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>seller/bank">List</a>
                                    </li>
                                    <li class="breadcrumb-item"><a href="#!">Add Bank</a>
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
                                <div class="card-header">
                                    <div class="card-header-right">
                                        <i class="icofont icofont-spinner-alt-5"></i>
                                    </div>
                                </div>
                                <div class="card-block">
                                    <h4 class="sub-title">Bank Details</h4>
                                    <?php echo $this->session->flashdata("message");?>
                                    <form method="post" enctype="multipart/form-data" action="" name="add_bank">
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Bank Name</label>
                                            <div class="col-sm-10">
                                               <select name="bank" class="form-control">
											   <option value="">Select Bank</option>
											     <?php foreach($banks as $row){ ?>
                                                <option value="<?php echo $row['id']; ?>" <?php if(set_value('bank') == $row['id']){ echo 'selected';} ?> ><?php echo $row['bank_name']; ?></option>
												 <?php } ?>
											   </select>
											   <div style="color:red"><?php echo form_error('bank'); ?></div>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Account Holder Name</label>
                                            <div class="col-sm-10">
                                                <input type="text" name="account_holder_name" class="form-control" value= "" >

                                                <!-- <div style="color:red"><?php echo form_error('account_holder_name'); ?></div> -->

                                            </div> 
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Account Number</label>
                                            <div class="col-sm-10">

                                                <input type="text" onkeypress="return isNumber(event)" id="account_no" name="account_no" class="form-control" value= "<?php echo set_value('account_no'); ?>" required>

                                                <div style="color:red" id="account_no_error"><?php echo form_error('account_no'); ?></div>
                                            </div>
                                        </div>
										
					                    <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">IFSC Code</label>
                                            <div class="col-sm-10">
                                                <input type="text" id="ifsc_code" name="ifsc_code" pattern="^[A-Za-z]{4}\d{7}$" class="form-control" value= "<?php echo set_value('ifsc_code'); ?>" required>
												<div style="color:red" id="ifsc_code_error"><?php echo form_error('ifsc_code'); ?></div>
                                            </div>  
                                        </div>
										
										<div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Set This Account As Default</label>
                                            <div class="col-sm-10">
                                                <input type="checkbox" name="is_default" value="1"  value= "<?php echo set_value('is_default'); ?>" > Yes <br>
												<div style="color:red"><?php echo form_error('is_default'); ?></div>
                                            </div>
                                        </div>
                                        <button type="submit" id="submit" class="btn btn-primary pull-right" id="primary-popover-content">Add</button>
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
<!-- Include Date Range Picker -->
<?php $this->load->view("user/common/footer");?>
<script>
// $(function(){
//     $("input[name=ifsc_code]")[0].oninvalid = function () {
//         this.setCustomValidity("Please enter valid ifsc code.");
//     };
// });

// $("#ifsc_code").change(function(){
//     var ifsc = $('#ifsc_code').val();
//     var value = ifsc.match('/^[A-Za-z]{4}\d{7}$/');
//     if(value == null) {
//         $('#ifsc_code_error').html('Invalid IFSC Code!');
//         $("#submit").attr("disabled", true);
//     } else {
//         $('#ifsc_code_error').html('');
//         $("#submit").attr("disabled", false);
//     }
// });


function isNumber(evt) {
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
        return false;
    }
    return true;
}

</script>

