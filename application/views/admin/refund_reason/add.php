
<div class="pcoded-content">
	<div class="pcoded-inner-content">
		<div class="main-body">
		<div class="page-wrapper">
			<div class="page-header">
				<div class="row align-items-end">
					<div class="col-lg-8">
						<div class="page-header-title">
							<div class="d-inline">
							<h4>Add Return/Refund Reasons</h4>

							</div>
						</div>
					</div>
					<div class="col-lg-4">
						<div class="page-header-breadcrumb">
							<ul class="breadcrumb-title">
								<li class="breadcrumb-item">
								<a href="<?php echo site_url();?>admin/dashboard"> <i class="feather icon-home"></i> </a>
								</li>
								<li class="breadcrumb-item"><a href="<?php echo base_url();?>admin/refund_reason">List</a>
								</li>
								<li class="breadcrumb-item"><a href="#!">Add Reasons</a>
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
						<h4 class="sub-title">Return/Refund Reasons</h4>
						 <form method="post" enctype="multipart/form-data">
						 <div class="form-group row">
								<label class="col-sm-2 col-form-label">Reason Type</label>
								<div class="col-sm-10">
									<select name="reason_type" class="form-control">
										<option value="Return">Return</option>
										<option value="Refund">Refund</option>
										<option value="Cancel">Cancel</option>
									</select>
								</div>
							</div>
							
							<div class="form-group row">
								<label class="col-sm-2 col-form-label">Reason</label>
								<div class="col-sm-10">
									<input type="text" name="reason" class="form-control" placeholder="Add Reason" required>
								</div>
							</div>
							<div class="form-group row">
								<label class="col-sm-2 col-form-label">Status</label>
								<div class="col-sm-10">
									<select name="status" class="form-control">
										<option value="Active">Active</option>
										<option value="InActive">InActive</option>
									</select>
								</div>
							</div>
							
							<button type="submit" name="submit_brand" id="submit_brand" class="btn btn-primary pull-right" id="primary-popover-content">Add</button>
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


