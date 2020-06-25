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
                                    <h4>Orders</h4>
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
                                    <li class="breadcrumb-item"><a href="#">Orders List</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="page-body">
                    <div class="row">
                        <div class="col-sm-9">
				
                            <?php if(!empty($this->session->flashdata('message'))){ ?>
                                        <div class="alert alert-success alert-dismissible col-md-6 offset-3">
                                          <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                          <strong>Info:</strong> <?php echo $this->session->flashdata('message'); ?>
                                        </div> 
                                     <?php } ?>
                            
                            <div class="card">
							
                                <div class="card-block">
                                    <div class="dt-responsive table-responsive">
                                        <table id="orderTable" class="table table-striped table-bordered nowrap">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Customer</th>
                                                  
                                                    <th>Status</th>
                                                    <!--<th>Price</th>
                                                    <th>Quantity</th>-->
                                                    <th>Total</th>
													<th>Date</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
						<div class="col-sm-3">
							<div class="card user-activity-card ">
								<div class="card-header bg-c-lite-green">
									<h5><i class="fa fa-filter"></i> Filters </h5>
								</div>
								<br />
								<div class="card-block">
									<div class="form-group">
										<label class="control-label" for="filter_order_id">Order ID</label>
										<input type="text" name="filter_order_id" value="" placeholder="Order ID" id="filter_order_id" class="form-control">
									</div>
									
									<div class="form-group">
										<label class="control-label" for="filter_order_status_id">Order Status</label>
										<select name="filter_order_status_id" id="filter_order_status_id" class="form-control">
											<option value=""></option>
											<?php foreach($orderStatus as $status):?>
											<option value="<?php echo $status->orders_status_id;?>">
												<?php echo $status->orders_status_name;?>
											</option>	
											<?php endforeach;?>
										</select>
									</div>
									<div class="form-group">
										<label class="control-label" for="input-total">Total</label>
										<input type="text" name="filter_total" value="" placeholder="Total" id="filter_total" class="form-control">
									</div>
									<div class="form-group">
										<label class="control-label" for="filter_date_added">Date Added</label>
										<div class="input-group date">
											<input type="text" name="filter_date_added" value="" placeholder="Date Added" data-date-format="YYYY-MM-DD" id="dropper-default" class="form-control">
											<span class="input-group-btn">
											<button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button>
											</span>
										</div>
									</div>
									<div class="form-group text-right">
										<button type="button" id="button-filter" class="btn btn-info">
											<i class="fa fa-filter"></i> Filter
										</button>
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
<script>

$(document).ready(function () {
		    	
	var dataTable =  $('#orderTable').DataTable( {
		processing:true,
		serverSide: true,
		"ajax": {
			"url": "<?php echo base_url('admin/orders/ajax_list'); ?>",
			"type": "POST",
			"data":function(data) {
				data.filter_order_id = $('#filter_order_id').val();
				data.filter_order_status_id = $('#filter_order_status_id').val();
				data.filter_total = $('#filter_total').val();
				data.filter_date_added = $('#dropper-default').val();
				data.<?php echo $this->security->get_csrf_token_name(); ?> = "<?php echo $this->security->get_csrf_hash(); ?>";
				//console.log(data);
			},
		},
		"columnDefs": [
			{ className: "dropdown", "targets": [ 5 ] }
		]
		
	} );
	
	$('#button-filter').on( 'click change', function (event) {
		//event.preventDefault();
		dataTable.draw();
	} );

});

</script>