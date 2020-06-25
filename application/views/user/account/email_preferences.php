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
							<h4>Email Services</h4><br>
							<h6 class="sub-title">Select the email which you wish to subscribe</h6>
							</div>
						</div>
					</div>
					<div class="col-lg-4">
						<div class="page-header-breadcrumb">
							<ul class="breadcrumb-title">
								<li class="breadcrumb-item">
								<a href="<?php echo base_url();?>seller/dashboard"> <i class="feather icon-home"></i> </a>
								</li>
								<li class="breadcrumb-item"><a href="<?php echo base_url();?>seller/myaccount">MyAccount</a>
								</li>
								<li class="breadcrumb-item"><a href="#!">Email Services</a>
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
							<div class="card-block">
								<div class="form-group row">
									<div class="col-md-12">
										<div class="row"> 
										<div class="col-md-8">
											<h4 class="sub-title">Trade Alerts</h4>
											<span>Free updates on the latest products, industry trends, buyer sourcing requests and supplier information.</span>
										</div>
										<div class="col-md-4">
											<h4 class="sub-title">Subscribe</h4>
											<?php if($result->trade_alerts == 1){ ?>
												<input type="checkbox" id= "trade_alerts"  data-toggle="toggle" checked onchange="toggle(this.id)">
											<?php }else{?>
												<input type="checkbox" id= "trade_alerts"  data-toggle="toggle" onchange="toggle(this.id)">
											<?php }?>
										</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-sm-12">
						<div class="card">
							<div class="card-block">
								<div class="form-group row">
									<div class="col-md-12">
										<div class="row"> 
											<div class="col-md-8">
												<h4 class="sub-title">Membership Services</h4>
												<span>Comprehensive guidance to help you learn more about atzcart.com's services, events and more.</span>
												<hr>
											</div>
											<div class="col-md-4">
												<h4 class="sub-title">Subscribe</h4>
												<br>
											</div>
											
											<div class="col-md-8">
											<br>
												<h6><b>Expos & Trade Shows</b></h6>
												<span>New services and promotions.</span>
												<hr>
											</div>
											<div class="col-md-4">
												<br>
												<?php if($result->expos_trade == 1){ ?>
													<input type="checkbox" data-toggle="toggle" id= "expos_trade" checked onchange="toggle(this.id)">
												<?php }else{ ?>
													<input type="checkbox" data-toggle="toggle" id= "expos_trade"  onchange="toggle(this.id)">
												<?php } ?>
											</div>
											
											<div class="col-md-8">
											<br>
												<h6><b>Service Instructions</b></h6>
												<span>User guides for atzcart.com members.</span>
												<hr>
											</div>
											<div class="col-md-4">
												<br>
												<?php if($result->service_instruction == 1){ ?>
													<input type="checkbox" data-toggle="toggle" id= "service_instruction" checked onchange="toggle(this.id)"> 
												<?php }else{ ?>
													<input type="checkbox" data-toggle="toggle" id= "service_instruction" onchange="toggle(this.id)"> 
												<?php } ?>
											</div>
											
											<div class="col-md-8">
											<br>
												<h6><b>Survey Invitations</b></h6>
												<span>Invitations to participate in paid/non-paid surveys.</span>
												<hr>
											</div>
											<div class="col-md-4">
												<br>
												<?php if($result->survey_invitations == 1){ ?>
													<input type="checkbox" data-toggle="toggle" id= "survey_invitations" checked onchange="toggle(this.id)"> 
												<?php }else{ ?>
													<input type="checkbox" data-toggle="toggle" id= "survey_invitations" onchange="toggle(this.id)"> 
												<?php } ?>
											</div>
											
											<div class="col-md-8">
											<br>
												<h6><b>Gold Supplier Membership Updates</b></h6>
												<span>Get updates on features, benefits and promotional offers for Gold Supplier Membership.more about atzcart.com's services, events and more.</span>
												<hr>
											</div>
											<div class="col-md-4">
												<br>
												<?php if($result->survey_invitations == 1){ ?>
													<input type="checkbox" data-toggle="toggle" id= "gold_membership" checked onchange="toggle(this.id)"> 
												<?php }else{ ?>
													<input type="checkbox" data-toggle="toggle" id= "gold_membership" onchange="toggle(this.id)">
												<?php } ?>
											</div>
									</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					
					<div class="col-sm-12">
						<div class="card">
							<div class="card-block">
								<div class="form-group row">
									<div class="col-md-12">
										<div class="row"> 
											<div class="col-md-8">
												<h4 class="sub-title">Automated Notifications</h4>
												<span>Emails sent to notify you of important information and account activity on atzcart.com.</span>
												<hr>
											</div>
											<div class="col-md-4">
												<h4 class="sub-title">Subscribe</h4>
												<br>
											</div>
											
											<div class="col-md-8">
											<br>
												<h6><b>Buying Request rejections & insufficient quote notifications</b></h6>
												<span>Email notification when your Buying Request is rejected or there are insufficient quotations for your Buying Request.</span>
												<hr>
											</div>
											<div class="col-md-4">
												<br>
												<?php if($result->brq_notifications == 1){ ?>
													<input type="checkbox" data-toggle="toggle" id= "brq_notifications" checked onchange="toggle(this.id)"> 
												<?php }else{ ?>
													<input type="checkbox" data-toggle="toggle" id= "brq_notifications"  onchange="toggle(this.id)"> 
												<?php } ?>
											</div>
											
											<div class="col-md-8">
											<br>
												<h6><b>Buying Request approvals, new quotes & order confirmations <span style="color:orange">(required)</span></b></h6>
												<span>Notifications when your Buying Request is approved, new quotations arrive and order information confirmation requests.</span>
												<hr>
											</div>
											<div class="col-md-4">
												<br>
											</div>
											
											<div class="col-md-8">
											<br>
												<h6><b>New Message Alerts <span style="color:orange">(required)</span></b></h6>
												<span>Instant access to your latest communication.</span>
												<hr>
											</div>
											<div class="col-md-4">
												<br>
											</div>
											
											<div class="col-md-8">
											<br>
												<h6><b>Connections Notification</b></h6>
												<span>Notification when you receive a new Business Card request or Identity Confirm request.</span>
												<hr>
											</div>
											<div class="col-md-4">
												<br>
												<?php if($result->connection_notification == 1){ ?>
													<input type="checkbox" data-toggle="toggle" id= "connection_notification" checked onchange="toggle(this.id)"> 
												<?php }else{ ?>
													<input type="checkbox" data-toggle="toggle" id= "connection_notification" onchange="toggle(this.id)">
												<?php } ?>
											</div>
											
											<div class="col-md-8">
											<br>
												<h6><b>Membership and Service Information <span style="color:orange">(required)</span></b></h6>
												<span>Review outcomes for Member & Company Profiles and other product information.</span>
												<hr>
											</div>
											<div class="col-md-4">
												<br>
											</div>
											
											<div class="col-md-8">
											<br>
												<h6><b>Penalty Notifications <span style="color:orange">(required)</span></b></h6>
												<span>Information and penalties regarding complaint cases and/or atzcart.com policy violations.</span>
												<hr>
											</div>
											<div class="col-md-4">
												<br>
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

<script>
function toggle(id){
	var toggle_id = '';
	if($("#"+id).is(":checked")){
        toggle_id = 1;
     }else{
         toggle_id = 0;
     }
	 
	 $.ajax({
		 
			url: '<?php echo base_url("seller/myaccount/ajax_manage_email_services"); ?>/'+id+'/'+toggle_id,
			dataType: "json",
			success: function(result) {
			}
	 });
}
</script>
<?php $this->load->view("user/common/footer"); ?>