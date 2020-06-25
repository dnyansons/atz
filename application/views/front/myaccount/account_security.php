<div class="container mt-3 mb-5">
<div class="a-section auth-pagelet-desktop-wide-container">
	<div class="a-section auth-pagelet-desktop-wide-container">
		 <h6 style="text-align:center;"><?php echo $this->session->flashdata('message'); ?></h6>
		<ol id="breadcrumb_CNEP" class="a-ordered-list a-horizontal breadcrumb">
			<li class="breadcrumb-item "><span class="a-list-item ">
				<a class="a-link-normal" href="<?php echo base_url(); ?>buyer-dashboard">
				Your Account
				</a>
				</span>
			</li>
			
			<li class="breadcrumb-item active"><span class="a-list-item a-color-state">
				Login &amp; Security
				</span>
			</li>
		</ol>
		
		<div class="a-section col-md-6 offset-md-3">
		
		<h1 id="ap_cnep_header" class="a-spacing-small">
			Login &amp; Security
		</h1>
			<div class="a-box a-vertical">
				<div class="a-box-inner a-padding-none">				
				  <div class="card">
                   <div class="card-body">
					<ul class="a-unordered-list a-nostyle a-box-list list-group">
						 <li class="list-group-item d-flex justify-content-between align-items-center py-4">
							<span class="a-list-item w-100">
								<!-- Set in request scope so that this variable is available to to CNEPMenuItem.jsp -->
								<div class="a-section a-padding-medium">
								   
										<div class="a-fixed-right-grid">
											<div class="a-fixed-right-grid-inner">
												<div class="a-fixed-right-grid-col a-col-left" style="padding-right:5%;float:left;">
													<div class="a-row">
														<span class="font-weight-bold">
														Name:
														</span>
													</div>
													<div class="a-row">
													   <?php echo $user_data->first_name.' '.$user_data->last_name; ?>
													</div>
												</div>
												<div class="a-fixed-right-grid-col float-right" style="">
													<div class="a-row">
													  <a href="" type="button" class="btn btn-primary a-btn-slide-text text-white"  id="a-autoid-1" data-toggle="modal" data-target="#change_Name" value="<?php echo $ord->orders_id; ?>"  onclick="get_name(this.value);"><span class="fa fa-edit" aria-hidden="true"></span> <span><strong>Edit</strong></span></a>
													  
													  
													</div>
												</div>
											</div>
										</div>
									
								</div>
							</span>
						</li>
						 <li class="list-group-item d-flex justify-content-between align-items-center py-4">
							<span class="a-list-item w-100">
								<div class="a-section a-padding-medium">
									
										<div class="a-fixed-right-grid">
											<div class="a-fixed-right-grid-inner">
												<div class="a-fixed-right-grid-col a-col-left" style="padding-right:5%;float:left;">
													<div class="a-row">
														<span class="font-weight-bold">
														E-mail:
														</span>
													</div>
													<div class="a-row">
													  <?php echo $user_data->email; ?>
													</div>
												</div>
												<div class="a-fixed-right-grid-col float-right">
											
													<a href="<?php echo base_url(); ?>change-email" class="btn btn-primary a-btn-slide-text" style="color:#fff;"  type="button">
													   <span class="fa fa-edit" aria-hidden="true"></span> <span><strong>Edit</strong></span>
														</a>
														
														
												</div>
											</div>
										</div>
								   
								</div>
							</span>
						</li>
						<!--<li>
							<span class="a-list-item">
								<div class="a-section a-padding-medium">
										<div class="a-fixed-right-grid">
											<div class="a-fixed-right-grid-inner" style="padding-right:70px">
												<div class="a-fixed-right-grid-col a-col-left" style="padding-right:5%;float:left;">
													<div class="a-row">
														<span class="a-text-bold">
														Mobile/Phone Number:
														</span>
													</div>
													<div class="a-row">
														<?php echo $user_data->phone; ?>
													</div>
												</div>
												<div class="a-fixed-right-grid-col a-col-right" style="width:70px;margin-right:-70px;float:left;">
													<div class="a-row">
														<span class="a-button a-button-span12 a-button-base" id="a-autoid-2"><span class="a-button-inner"><input id="auth-cnep-edit-phone-button" class="a-button-input" type="submit" aria-labelledby="a-autoid-2-announce"><span class="a-button-text" aria-hidden="true" id="a-autoid-2-announce">
														Edit
														</span></span></span>
													</div>
												</div>
											</div>
										</div>
								   
								</div>
							</span>
						</li>-->
					   <li class="list-group-item d-flex justify-content-between align-items-center py-4">
							<span class="a-list-item w-100">
								<div class="a-section a-padding-medium">
								   
										<div class="a-fixed-right-grid">
											<div class="a-fixed-right-grid-inner">
												<div class="a-fixed-right-grid-col a-col-left" style="padding-right:5%;float:left;">
													<div class="a-row">
														<span class="font-weight-bold">
														Password:
														</span>
													</div>
													<div class="a-row">
													   **********
													</div>
												</div>
												<div class="a-fixed-right-grid-col float-right">
												
													 <a href="<?php echo base_url(); ?>change-password" class="btn btn-primary a-btn-slide-text" style="color:#fff;"  type="button">
													   <span class="fa fa-edit" aria-hidden="true"></span> <span><strong>Edit</strong></span>
														</a>
													
												</div>	
											</div>
										</div>
								   
								</div>
							</span>
						</li>
						 <li class="list-group-item d-flex justify-content-between align-items-center py-4">
							<span class="a-list-item w-100">
								<div class="a-section a-padding-medium">
									<form method="get" action="">
									   
										<div class="a-fixed-right-grid">
											<div class="a-fixed-right-grid-inner">
												<div class="a-fixed-right-grid-col a-col-left" style="padding-right:5%;float:left;">
													<div class="a-row">
														<span class="font-weight-bold">
														Security Question:
														</span>
													</div>
													<div class="a-row">
														<span class="a-color-secondary">
														Manage security question for better Security
														</span>
													</div>
												</div>
												
												<div class="a-fixed-right-grid-col float-right"> <a href="<?php echo base_url(); ?>change-security-questions" class="btn btn-primary a-btn-slide-text" style="color:#fff;"  type="button">
													   <span class="fa fa-edit" aria-hidden="true"></span> <span><strong>Edit</strong></span>
														</a>				
												</div>
											</div>
										</div>
									</form>
								</div>
							</span>
						</li>
					</ul>
				    </div>
				  </div>
				</div>
			</div>
		  
		</div>
	</div>
</div>
</div>
<div id="change_Name" class="modal fade"  role="dialog">
<div class="modal-dialog modal-dialog-centered modal-lg" style="width:500px">
<!-- Modal content-->
<div class="modal-content">
	<div class="modal-header">
		<h4 class="modal-title" >Change Account Name</h4>
	</div>
	<form class="form-horizontal" action="<?php echo base_url(); ?>buyer/login_security/update_name" method="post" name="update_acc_name">
		
		
		<div class="modal-body">
		
		<div class="form-group">
			<div class="col-md-12">
				<label><b>First Name</b></label>
				<input type="text" name="first_name" value="<?php echo $user_data->first_name; ?>" required>
			</div>
		</div>
							 <div class="form-group">
			<div class="col-md-12">
				<label><b>Last Name</b></label>
				<input type="text" name="last_name" value="<?php echo $user_data->last_name; ?>" required>
			</div>
		</div>
		 
			
		</div>
		<div class="modal-footer">
			<button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Close</button>
			<button type="submit"  class="btn btn-sm btn-danger" id="btnSubmit">Update</button>
		</div>    
	</form>
</div>

</div>
</div>
<script>
function get_name(name)
{
if(name!='')
{
			
$.ajax({
	type:'POST',
	url :'<?php echo base_url(); ?>buyer/login_security/get_username',
	data: {'fname':<?php echo $user_data->first_name ?>,'lname':<?php echo $user_data->last_name; ?>},
	success:function(data){
	$('#myName').html('');
	$('#myName').html(data);
				
	},
	error:function(){
	alert('Somthing Wrong !'); 
	}
});
}

}
</script>
