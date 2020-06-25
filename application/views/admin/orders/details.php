<?php 
// echo "<pre>";
// print_r($orderDetails);
// exit;
$this->load->view("admin/common/header");
?>
<div class="pcoded-content">
    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-header">
                    <div class="row align-items-end">
                        <div class="col-lg-8">
                            <div class="page-header-title">
                                <div class="d-inline">
                                    <h4>Order Details</h4>
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
                                    <li class="breadcrumb-item"><a href="#">Orders Details</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
				<div class="page-body">
					<div class="row">
                        <div class="col-md-6">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h4 ><i class="fa fa-shopping-cart"></i> Order Details</h4>
                                </div>
                                <table class="table">
                                    <tbody>
                                        <tr>
                                            <td style="width: 1%;">
												<i class="fa fa-shopping-cart fa-fw"></i>
											</td>
                                            <td><a href="#" target="_blank">Your Store</a></td>
                                        </tr>
                                        <tr>
                                            <td>
												<i class="fa fa-calendar fa-fw"></i>
											</td>
                                            <td><?php echo $orderDetails->date_purchased;?></td>
                                        </tr>
                                        <tr>
                                            <td>
												<i class="fa fa-credit-card fa-fw"></i>
											</td>
                                            <td><?php echo $orderDetails->payment_method;?></td>
                                        </tr>
                                        <tr>
                                            <td>
												<i class="fa fa-truck fa-fw"></i>
											</td>
                                            <td><?php echo $orderDetails->shipping_cost;?></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h4 ><i class="fa fa-user"></i> Customer Details</h4>
                                </div>
                                <table class="table">
                                    <tr>
                                        <td style="width: 1%;">
											<i class="fa fa-user fa-fw"></i>
										</td>
                                        <td> 
											<?php echo $orderDetails->user_name;?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
											<i class="fa fa-group fa-fw"></i>
										</td>
                                        <td>Default</td>
                                    </tr>
                                    <tr>
                                        <td>
											<i class="fa fa-envelope-o fa-fw"></i>
										</td>
                                        <td>
											<a href="mailto:<?php echo $orderDetails->	user_email_address;?>">
												<?php echo $orderDetails->	user_email_address;?>
											</a>
										</td>
                                    </tr>
                                    <tr>
                                        <td>
											<i class="fa fa-phone fa-fw"></i>
										</td>
                                        <td><?php echo $orderDetails->user_telephone;?></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <!--<div class="col-md-4">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h4 ><i class="fa fa-cog"></i> Options</h4>
                                </div>
                                <table class="table">
                                    <tbody>
                                        <tr>
                                            <td>Invoice</td>
                                            <td id="invoice" class="text-right"></td>
                                            <td style="width: 1%;" class="text-center"> 
												<i class="fa fa-cog"></i>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Reward Points</td>
                                            <td class="text-right">0</td>
                                            <td class="text-center"> 
												<i class="fa fa-plus-circle"></i>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Affiliate
                                            </td>
                                            <td class="text-right">0</td>
                                            <td class="text-center"> 
												<i class="fa fa-plus-circle"></i>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>-->
                    </div>
                    
					<br />
					<div class="row">
						<div class="col-md-12">
							<div class="panel panel-default">
								<div class="panel-heading">
									<h4 ><i class="fa fa-info-circle"></i> Order (#<?php echo $orderDetails->orders_id;?>)</h4>
								</div>
								<div class="panel-body">
								<div class="col-md-12">
									<table class="table table-bordered">
										<thead>
											<tr>
												<th style="width: 50%;" class="text-left">Payment Address</th>
												<th style="width: 50%;" class="text-left">Shipping Address</th>
											</tr>
										</thead>
										<tbody>
											<tr>
												<td class="text-left">
													<?php echo $orderDetails->delivery_street_address;?><br />
													<?php echo $orderDetails->retailers_city;?><br />
													<?php echo $orderDetails->retailers_state;?><br />
													<?php echo $orderDetails->retailers_postcode;?><br />
													<?php echo $orderDetails->payment_country;?><br />
												</td>
												<td class="text-left">
													<?php echo $orderDetails->delivery_street_address;?><br />
													<?php echo $orderDetails->delivery_city;?><br />
													<?php echo $orderDetails->delivery_state;?><br />
													<?php echo $orderDetails->delivery_postcode;?><br />
													<?php echo $orderDetails->delivery_country;?><br />
												</td>
											</tr>
										</tbody>
									</table>
									<table class="table table-bordered">
										<thead>
											<tr>
												<td class="text-left">Product</td>
												<td class="text-left">Model</td>
												<td class="text-right">Quantity</td>
												<td class="text-right">Unit Price</td>
												<td class="text-right">Total</td>
											</tr>
										</thead>
										<tbody>
											<tr>
												<td class="text-left">
													<a href="">
														<?php echo $orderDetails->products_model;?>	
													</a> 
													<br />
													&nbsp;
													<small> - Delivery Date: 
													<?php if($orderDetails->orders_date_finished !="0000-00-00 00:00:00"){
															echo $orderDetails->orders_date_finished;
													}?>
													</small> 
												</td>
												<td class="text-left"><?php echo $orderDetails->products_name;?></td>
												<td class="text-right"><?php echo $orderDetails->products_quantity;?></td>
												<td class="text-right"><?php echo $orderDetails->final_price;?></td>
												<td class="text-right"><?php echo $orderDetails->final_price;?></td>
											</tr>
											<tr>
												<td colspan="4" class="text-right">Sub-Total</td>
												<td class="text-right"><?php echo $orderDetails->final_price;?></td>
											</tr>
											<tr>
												<td colspan="4" class="text-right">Flat Shipping Rate</td>
												<td class="text-right"><?php echo $orderDetails->shipping_cost;?></td>
											</tr>
											
											<tr>
												<td colspan="4" class="text-right">Total</td>
												<td class="text-right"><?php echo $orderDetails->final_price;?></td>
											</tr>
										</tbody>
									</table>
									</div>
								</div>
							</div>

						</div>
					</div>
					
					<br />
					
					<div class="row">
						<div class="col-sm-12">
							<div class="card">
								<div class="card-header">
									<h5>Order History</h5>
								</div>
								<div class="card-block">
									<div class="row">
										<div class="col-md-12">
											<ul class="nav nav-tabs  tabs" role="tablist">
												<li class="nav-item">
													<a class="nav-link active" data-toggle="tab" href="#home1" role="tab" aria-expanded="false">History</a>
												</li>
												<li class="nav-item">
													<a class="nav-link" data-toggle="tab" href="#profile1" role="tab" aria-expanded="true">Additional</a>
												</li>
											</ul>
											<div class="tab-content tabs card-block">
												<div class="tab-pane active" id="home1" role="tabpanel" aria-expanded="false">
													<table class="table table-bordered">
														<thead>
															<tr>
																<th>Date added</th>
																<th>Comment</th>
																<th>Status</th>
																<th>Customer Notified</th>
															</tr>	
														</thead>
														<tbody>
															<?php foreach($orderHistory as $history):?>
															<tr>
																<td><?php echo $history->date_added;?></td>
																<td><?php echo $history->comment;?></td>
																<td><?php echo $history->orders_status_name;?></td>
																<td>
																<?php 
																	if($history->customer_notified){
																		echo "Yes";
																	} else {
																		echo "No";
																	}
																?>
																</td>
															</tr>
															<?php endforeach;?>
														</tbody>
													</table>
													
													<hr />
													<h4>Add History</h4>
													<hr />
													<form action="<?php echo site_url("admin/orders/view/").$orderDetails->orders_id;?>" method="post">
														
														
														<div class="form-group row">
															<label class="col-sm-2 col-form-label">Order Status</label>
															<div class="col-sm-10">
																<select name="status" class="form-control">
																	<option value="">Select Status</option>
																	<?php foreach($orderStatus as $status):?>
																	<option 
																	value="<?php echo $status->orders_status_id;?>">
																	<?php echo $status->orders_status_name;?>
																	</option>
																	<?php endforeach;?>
																</select>
															</div>
														</div>
														
														<div class="form-group row">
															<label class="col-sm-2 col-form-label">Notify Customer</label>
															<div class="col-sm-10">
																<input type="checkbox" name="notify" class="">
															</div>
														</div>
														
														<div class="form-group row">
															<label class="col-sm-2 col-form-label">Comment</label>
															<div class="col-sm-10">
																<textarea rows="5" cols="5" name="comment" class="form-control" placeholder="Comment"></textarea>
															</div>
														</div>
														<div class="form-group row">
															<input type="submit" class="btn btn-success pull-right" value="Add History">
														</div>
													</form>
													
													
												</div>
												<div class="tab-pane " id="profile1" role="tabpanel" aria-expanded="true">
													<table class="table table-bordered">
														<thead>
															<tr>
																<td colspan="2">Browser</td>
															</tr>
														</thead>
														<tbody>
															<tr>
																<td>IP Address</td>
																<td>122.160.153.212</td>
															</tr>
															<tr>
																<td>Forwarded IP</td>
																<td>122.160.153.212</td>
															</tr>
															<tr>
																<td>Accept Language</td>
																<td>en-US</td>
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
        </div>
    </div>
</div>
<?php $this->load->view("admin/common/footer");?>
