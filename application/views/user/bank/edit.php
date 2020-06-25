<?php $this->load->view("user/common/header"); ?>
<div class="pcoded-content">
	<div class="pcoded-inner-content">
		<div class="main-body">
		<div class="page-wrapper">
			<div class="page-header">
				<div class="row align-items-end">
					<div class="col-lg-8">
						<div class="page-header-title">
							<div class="d-inline">
							<h4>Edit Bank</h4>

							</div>
						</div>
					</div>
					<div class="col-lg-4">
						<div class="page-header-breadcrumb">
							<ul class="breadcrumb-title">
								<li class="breadcrumb-item">
								<a href="<?php echo base_url() ?>seller/dashboard"> <i class="feather icon-home"></i> </a>
								</li>
								<li class="breadcrumb-item"><a href="<?php echo base_url();?>seller/bank">List</a>
								</li>
								<li class="breadcrumb-item"><a href="#!">Edit Bank</a>
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
						<h4 class="sub-title">Banks</h4>
						 <form method="post" enctype="multipart/form-data">
							 <div class="form-group row">
								<label class="col-sm-2 col-form-label">Bank Name</label>
								<div class="col-sm-10">
								   <select name="bank" class="form-control">
										 <?php foreach($banks as $row){ ?>
											<?php if($row['id'] == $result->bank){ ?>
											<option value="<?php echo $row['id']; ?>" selected><?php echo $row['bank_name']; ?></option>
											<?php }else{ ?>
												<option value="<?php echo $row['id']; ?>"><?php echo $row['bank_name']; ?></option>
										 <?php } } ?>
								   </select>
								   <div style="color:red"><?php echo form_error('bank'); ?></div>
								</div>
                               </div>

							<div class="form-group row">
								<label class="col-sm-2 col-form-label">Account Holder Name</label>
								<div class="col-sm-10">
									<input type="text" name="account_holder_name" class="form-control" value= "<?php echo $result->account_holder_name; ?>" required>
									<div><?php echo form_error('account_holder_name'); ?></div>
								</div> 
							</div>
							
							 <div class="form-group row">
								<label class="col-sm-2 col-form-label">Account Number</label>
								<div class="col-sm-10">
									<input type="number" onkeypress="return isNumber(event)" id="account_no" name="account_no" class="form-control" value= "<?php echo $result->account_no; ?>" required>
									<div style="color:red"><?php echo form_error('account_no'); ?></div>
								</div>
							</div>
							
							<div class="form-group row">
								<label class="col-sm-2 col-form-label">IFSC Code</label>
								<div class="col-sm-10">
									<input type="text" name="ifsc_code" class="form-control" value= "<?php echo $result->ifsc_code; ?>" required>
									<input type="hidden" name="created_date"  value= "<?php echo $result->created_date; ?>">
									<div style="color:red"><?php echo form_error('ifsc_code'); ?></div>
								</div>  
							</div>
							
							<div class="form-group row">
								<label class="col-sm-2 col-form-label">Set This Account As Default</label>
								<div class="col-sm-10">
								 <?php if($result->is_default == 1){ ?>
									<input type="checkbox" name="is_default" value="1" checked > Yes <br>
								 <?php }else{ ?>
									<input type="checkbox" name="is_default" value="1" > Yes <br>
								 <?php } ?>
									<div style="color:red"><?php echo form_error('is_default'); ?></div>
								</div>
							</div>
							
							<button type="submit" name="submit" id="submit_brand" class="btn btn-primary pull-right" id="primary-popover-content">Update</button>
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
	
<?php $this->load->view("user/common/footer"); ?>


<script>
$("#ifsc_code").change(function(){
    var ifsc = $('#ifsc_code').val();
    var value = ifsc.match('^[A-Za-z]{4}[a-zA-Z0-9]{7}$');
    if(value == null) {
        $('#ifsc_code_error').html('Invalid IFSC Code!');
        $("#submit").attr("disabled", true);
    } else {
        $('#ifsc_code_error').html('');
        $("#submit").attr("disabled", false);
    }
});


function isNumber(evt) {
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
        return false;
    }
    return true;
}

</script>