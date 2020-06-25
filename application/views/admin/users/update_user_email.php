
<div class="pcoded-content">
	<div class="pcoded-inner-content">
		<div class="main-body">
		<div class="page-wrapper">
			<div class="page-header">
				<div class="row align-items-end">
					<div class="col-lg-8">
						<div class="page-header-title">
							<div class="d-inline">
							<h4>Update email Address</h4>

							</div>
						</div>
					</div>
					<div class="col-lg-4">
						<div class="page-header-breadcrumb">
							<ul class="breadcrumb-title">
								<li class="breadcrumb-item">
								<a href="<?php echo site_url();?>admin/dashboard"> <i class="feather icon-home"></i> </a>
								</li>
								<li class="breadcrumb-item"><a href="<?php echo base_url();?>admin/users">List</a>
								</li>
								<li class="breadcrumb-item"><a href="#!">Update Email</a>
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
								
								</div>
							</div>
						<div class="card-block">
						<?php echo $this->session->flashdata("message"); ?>
						<h4 class="sub-title">Email</h4>
						 <form method="post" enctype="multipart/form-data">
							<div class="form-group row">
								<label class="col-sm-2 col-form-label">Email Address</label>
								<div class="col-sm-6">
									<input type="text" id="email" name="email" ondrop="return false;" onpaste="return false;"  onkeypress="return IsAlphaNumeric(event)" class="form-control" value="<?php echo $details->email; ?>" required>
									<?php echo form_error('email'); ?>
								</div>
								
							</div>
														
							<button type="submit" name="submit_brand" id="submit_brand" class="btn btn-primary btn-sm pull-right" id="primary-popover-content">Update</button>
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


<script type="text/javascript">
    var specialKeys = new Array();
	specialKeys.push(64); //@ 
    specialKeys.push(8);  //Backspace
    specialKeys.push(9);  //Tab
    specialKeys.push(46); //Delete
    specialKeys.push(36); //Home
    specialKeys.push(35); //End
    specialKeys.push(37); //Left
    specialKeys.push(39); //Right

    function IsAlphaNumeric(e) {
		var x=e.which||e.keycode;
        if((x>=48 && x<=57) || x==8 ||
                (x>=65 && x<=90)|| (x>=97 && x<=122) || x==46 || x==64 ||x==95)
                return true;
        else
                return false;
    }
</script>