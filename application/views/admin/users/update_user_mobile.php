
<div class="pcoded-content">
	<div class="pcoded-inner-content">
		<div class="main-body">
		<div class="page-wrapper">
			<div class="page-header">
				<div class="row align-items-end">
					<div class="col-lg-8">
						<div class="page-header-title">
							<div class="d-inline">
							<h4>Update mobile</h4>

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
								<li class="breadcrumb-item"><a href="#!">Update Mobile</a>
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
						<h4 class="sub-title">Mobile</h4>
						 <form method="post" enctype="multipart/form-data">
					
							<div class="form-group row">
								<label class="col-sm-2 col-form-label">Mobile</label>
								<div class="col-sm-6">
									<input type="text" name="phone" class="form-control" value="<?php echo $details->phone; ?>" required>
									<?php echo form_error('phone'); ?>
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


