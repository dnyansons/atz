<?php $this->load->view("admin/common/header");?>
<div class="pcoded-content">
    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-header">
                    <div class="row align-items-end">
                        <div class="col-lg-8">
                            <div class="page-header-title">
                                <div class="d-inline">
                                    <h4>Supplier Details</h4>
                                    <span></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="page-header-breadcrumb">
                                <ul class="breadcrumb-title">
                                    <li class="breadcrumb-item">
                                        <a href="<?php echo site_url();?>admin/dashboard"> <i class="feather icon-home"></i> </a>
                                    </li>
                                    <li class="breadcrumb-item"><a href="#">Supplier Details view</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="page-body">
					
					<div class="row">
						<div class="col-lg-12">
							<div class="cover-profile">
								<div class="profile-bg-img">
									<img class="profile-bg-img img-fluid" src="<?php echo base_url();?>assets/images/user-profile/bg-img1.jpg" alt="bg-img">
									<div class="card-block user-info">
										<div class="col-md-12">
											<div class="media-left">
												<a href="#" class="profile-image">
													<img class="user-img img-radius" src="<?php echo base_url();?>assets/images/user-profile/user-img.jpg" alt="user-img">
												</a>
											</div>
											<div class="media-body row">
												<div class="col-lg-12">
													<div class="user-title">
														<h2><?php echo $supplier->contact_person1_name;?></h2>
														<span class="text-white">Supplier User</span>
													</div>
												</div>
												<div>
													<div class="pull-right cover-btn">
														
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					
                    <div class="row">
						<div class="col-lg-12">

							<div class="tab-header card">
								<ul class="nav nav-tabs md-tabs tab-timeline" role="tablist" id="mytab">
									<li class="nav-item">
										<a class="nav-link active" data-toggle="tab" href="#personal" role="tab">Personal Info</a>
										<div class="slide"></div>
									</li>
									<li class="nav-item">
										<a class="nav-link" data-toggle="tab" href="#binfo" role="tab">Products Posted</a>
										<div class="slide"></div>
									</li>
									<!--<li class="nav-item">
										<a class="nav-link" data-toggle="tab" href="#contacts" role="tab">User's Contacts</a>
										<div class="slide"></div>
									</li>-->
									
								</ul>
							</div>


							<div class="tab-content">

								<div class="tab-pane active" id="personal" role="tabpanel">

									<div class="card">
										<div class="card-header">
											<h5 class="card-header-text">About Supplier</h5>
											<button id="edit-btn" type="button" class="btn btn-sm btn-primary waves-effect waves-light f-right">
												<i class="fa fa-edit"></i>
											</button>
										</div>
										<div class="card-block">
											<div class="view-info">
												<div class="row">
													<div class="col-lg-12">
														<div class="general-info">
															<div class="row">
																<div class="col-lg-12 col-xl-6">
																	<div class="table-responsive">
																		<table class="table m-0">
																			<tbody>
																				<tr>
																					<th scope="row">Full Name</th>
																					<td><?php echo $supplier->contact_person1_name;?></td>
																				</tr>
																				<tr>
																					<th scope="row">Date registered</th>
																					<td><?php echo $supplier->date_created;?></td>
																				</tr>
																				<tr>
																					<th scope="row">Location</th>
																					<td><?php echo $supplier->state.",".$supplier->state;?></td>
																				</tr>
																				<tr>
																					<th scope="row">user Type</th>
																					<td>Seller / Buyer</td>
																				</tr>
																			</tbody>
																		</table>
																	</div>
																</div>

																<div class="col-lg-12 col-xl-6">
																	<div class="table-responsive">
																		<table class="table">
																			<tbody>
																				<tr>
																					<th scope="row">Email</th>
																				
																					<td><a href="#!"><span class="__cf_email__" ><?php echo $supplier->email;?>
																					</span></a></td>
																				</tr>
																				<tr>
																					<th scope="row">Mobile Number</th>
																					<td><?php echo $supplier->telephone;?></td>
																				</tr>
																				<tr>
																					<th scope="row">Company</th>
																					<td><?php echo $supplier->company_name;?></td>
																				</tr>
																				
																			</tbody>
																		</table>
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


								<div class="tab-pane" id="binfo" role="tabpanel">

									<div class="card">
										<div class="card-header">
											<h5 class="card-header-text">Products Posted</h5>
										</div>
										<div class="card-block">
											<div class="row">
												<?php foreach($products as $product){ ?>
												<div class="col-md-6">
													<div class="card b-l-success business-info services m-b-20">
														<div class="card-header">
															<div class="service-header">
																<a href="#">
																	<h5 class="card-header-text"><?php echo $product->products_name;?></h5>
																</a>
															</div>
															<span class="dropdown-toggle addon-btn text-muted f-right service-btn" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" role="tooltip">
															</span>
															<div class="dropdown-menu dropdown-menu-right b-none services-list">
																<a class="dropdown-item" href="#!"><i class="icofont icofont-edit"></i> Edit</a>
																<a class="dropdown-item" href="#!"><i class="icofont icofont-ui-delete"></i> Delete</a>
																<a class="dropdown-item" href="#!"><i class="icofont icofont-eye-alt"></i> View</a>
															</div>
														</div>
														<div class="card-block">
															<div class="row">
																<div class="col-sm-12">
																	<p class="task-detail"><?php echo $product->products_description;?></p>
																</div>

															</div>

														</div>

													</div>
												</div>
												<?php } ?>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-lg-12">
											<div class="card">
												<div class="card-header">
													<h5 class="card-header-text">Profit</h5>
												</div>
												<div class="card-block">
													<div id="main" style="height:300px;width: 100%;"></div>
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
<?php $this->load->view("admin/common/footer");?>
