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
                                    <h4>Commission Report</h4>
                                    <span></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="page-header-breadcrumb">
                                <ul class="breadcrumb-title">
                                    <li class="breadcrumb-item">
                                        <a href="<?php echo site_url(); ?>seller/dashboard"> <i class="feather icon-home"></i> </a>
                                    </li>
                                    <li class="breadcrumb-item"><a href="#">Report</a></li>
									<li class="breadcrumb-item"><a href="<?php echo site_url(); ?>admin/report/commission_report">Commission Report</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="page-body">
					<div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-block">
                                <!--<h4 class="sub-title">Search filters</h4>-->
                                    <div class="row">
										<div class="col-md-12">
											<span class="badge badge-success badge-md daterange" data-from="<?php echo date('d-m-Y'); ?>" data-to="<?php echo date('d-m-Y'); ?>" >Today</span>
											<span class="badge badge-warning badge-md daterange" data-from="<?php echo date('d-m-Y',strtotime("-1 days")); ?>" data-to="<?php echo date('d-m-Y',strtotime("-1 days")); ?>" >Yesterday</span>
											<span class="badge badge-warning badge-md daterange" data-to="<?php echo date('d-m-Y'); ?>" data-from="<?php echo date('d-m-Y',strtotime("-7 days")); ?>">Last 7 Days</span>
											<span class="badge badge-warning badge-md daterange" data-from="<?php echo date('01-m-Y'); ?>" data-to="<?php echo date('t-m-Y'); ?>">This Month</span>
										</div>
										<div class="col-md-2">
                                            <p class="">From</p>
                                            <input type="text" class="form-control" value="<?php echo date('d-m-Y'); ?>" placeholder="Date From" id="dateFrom" name="dateFrom">
                                        </div>
                                        <div class="col-md-2">
                                            <p class="">To</p>
                                            <input type="text" class="form-control" value="<?php echo date('d-m-Y'); ?>" placeholder="Date To" id="dateTo" name="dateTo">
                                        </div>
                                        <div class="col-md-2">
                                            <p class="">Order id</p>
                                            <input type="text" class="form-control" id="orderid" name="orderid" placeholder="Order Id">
                                        </div>
                                        <div class="col-md-2">
                                            <p class="">Vendor ID</p>
                                            <input type="text" class="form-control" id="vendorid" name="vendorid" placeholder="Vendor Id">
                                        </div>
                                        
                                        <div class="col-md-2">
                                            <p class="">Order Status</p>
                                            <select id="orderstatus" class="form-control" name="orderstatus">
                                                <option value="">Select</option>
												<?php foreach($statuses as $stat){ ?>
												<option value="<?php echo $stat['orders_status_id']; ?>"><?php echo $stat['orders_status_name']; ?></option>
												<?php } ?>
                                            </select>
                                        </div>
                                        
                                        <div class="col-md-2">
                                            <p>&nbsp;</p>
                                            <button class="btn btn-info btn-sm btn-block" id="btnFilter">Filter</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">

                            <div class="card">
                                <div class="card-header">
                                    <h5>Commission Report</h5>
                                </div>
                                <div class="card-block">
                                    <?php echo $this->session->flashdata("message");?>
                                    <div class="dt-responsive table-responsive">
                                        <table id="salesreport" class="table table-striped table-bordered nowrap">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
													<th>Vendor Id</th>
													<th>Vendor Name</th>
													<th>Order ID</th>
                                                    <th>Order Date</th>
                                                    <th>Delivery Date</th>
													<th>Total Amount</th>
													<th>Total Payble Amount</th>
                                                    <th>Commission</th>
													<th>GST</th>
                                                    <th>Total Deduction</th>
                                                </tr>
                                            </thead>
											<tbody>
												
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
<?php $this->load->view("user/common/footer"); ?>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.html5.min.js"></script>
<script>
    $(document).ready(function () {
       var dtTable =  $('#salesreport').DataTable({
            processing: true,
            serverSide: true,
			searching: false,
			dom: 'Bfrtip',
			buttons: [
				'copyHtml5',
				'excelHtml5',
				'csvHtml5',
				'pdfHtml5'
			],
            ajax: {
                url: "<?php echo base_url('seller/report/fetch_comission_report') ?>",
                dataType: "json",
                type: "POST",
                data: function(data) {
                            data.order_status = $('#orderstatus').val();
                            data.vendor_id = '<?php echo $this->session->userdata("user_id"); ?>';
                            data.order_id = $('#orderid').val();
                            data.datefrom = $('#dateFrom').val();
                            data.dateto = $('#dateTo').val();
                            data.<?php echo $this->security->get_csrf_token_name(); ?> = "<?php echo $this->security->get_csrf_hash(); ?>";

                    }
				},
				columns: [
                {data: "sr_no"},
                {data: "vendor_id"},
                {data: "vendor_name"},
				{data: "order_id"},
				{data: "datepurchased"},
				{data: "datedelivered"},
				{data: "total_amount"},
                {data: "payable_amount"},
                {data: "commission"},
				{data: "gst"},
				{data: "total_deduction"},
            ],
			"lengthMenu": [[100, 250, 500, -1], [100, 250, 500, "All"]]
        });
		
		$(document).on('click', '#btnFilter', function () {
			//dtTable.destroy();
			dtTable.clear().draw();
		});
		
		 $("#dateFrom").dateDropper({
			format:"d-m-Y",
			dropWidth: 200,
			dropPrimaryColor: "#1abc9c",
			dropBorder: "1px solid #1abc9c",
			maxYear: "2020",
		});
		$("#dateTo").dateDropper({
			format:"d-m-Y",
			dropWidth: 200,
			dropPrimaryColor: "#1abc9c",
			dropBorder: "1px solid #1abc9c",
			maxYear: "2020",
		});
    });
	
	$('.daterange').click(function(){
		var datefrom = $(this).attr('data-from');
		var dateto = $(this).attr('data-to');
		$("#dateFrom").val(datefrom);
		$("#dateTo").val(dateto);
		$('#btnFilter').trigger('click');
		$(".daterange" ).removeClass('badge-success');
		$(".daterange" ).addClass('badge-warning');
		$(this).addClass('badge-success');
	});
</script>
