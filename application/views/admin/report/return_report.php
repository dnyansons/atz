<?php $this->load->view("admin/common/header"); ?>
<div class="pcoded-content">
    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-header">
                    <div class="row align-items-end">
                        <div class="col-lg-8">
                            <div class="page-header-title">
                                <div class="d-inline">
                                    <h4>Return Report</h4>
                                    <span></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="page-header-breadcrumb">
                                <ul class="breadcrumb-title">
                                    <li class="breadcrumb-item">
                                        <a href="<?php echo site_url(); ?>admin/dashboard"> <i class="feather icon-home"></i> </a>
                                    </li>
                                    <li class="breadcrumb-item"><a href="#">Report</a></li>
                                    <li class="breadcrumb-item"><a href="<?php echo site_url(); ?>admin/report/return_report">Return Report</a></li>
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
									<form action = "#">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <span style="cursor: pointer;" class="badge badge-success badge-md daterange" data-from="<?php echo date('d-m-Y'); ?>" data-to="<?php echo date('d-m-Y'); ?>" >Today</span>
                                            <span style="cursor: pointer;" class="badge badge-warning badge-md daterange" data-from="<?php echo date('d-m-Y', strtotime("-1 days")); ?>" data-to="<?php echo date('d-m-Y', strtotime("-1 days")); ?>" >Yesterday</span>
                                            <span style="cursor: pointer;" class="badge badge-warning badge-md daterange" data-to="<?php echo date('d-m-Y'); ?>" data-from="<?php echo date('d-m-Y', strtotime("-7 days")); ?>">Last 7 Days</span>
                                            <span style="cursor: pointer;" class="badge badge-warning badge-md daterange" data-from="<?php echo date('01-m-Y'); ?>" data-to="<?php echo date('t-m-Y'); ?>">This Month</span>
                                        </div>
                                        <br />
                                        <div class="col-md-2">
                                            <span class="">From</span><br />
                                            <input type="text" class="form-control" value="<?php echo date('d-m-Y'); ?>" placeholder="Date From" id="dateFrom" name="datefrom">
                                        </div>
                                        <div class="col-md-2">
                                            <span class="">To</span><br />
                                            <input type="text" class="form-control" value="<?php echo date('d-m-Y'); ?>" placeholder="Date To" id="dateTo" name="dateto">
                                        </div>
                                        <div class="col-md-2">
                                            <span class="">Order id</span><br />
                                            <input type="text" class="form-control" id="orderid" name="orderid" placeholder="Order Id">
                                        </div>
                                        <div class="col-md-2">
                                            <span class="">Mobile</span><br />
                                            <input type="text" class="form-control" id="phone" name="phone" placeholder="Mobile Number">
                                        </div>
                                        <div class="col-md-2">
                                            <span class="">Email</span><br />
                                            <input type="text" class="form-control" id="email" name="email" placeholder="email">
                                        </div>
                                        <div class="col-md-2">
                                            <span>&nbsp;</span><br />
                                            <input type="button" class="btn btn-info btn-sm btn-block" id="btnFilter" value="Filter">
                                        </div>
										
											
                                    </div>
								</form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">

                            <div class="card">
                                <div class="card-header">
                                    <h5>Return Report</h5>
                                </div>
                                <div class="card-block">
                                    <?php echo $this->session->flashdata("message"); ?>
                                    <div class="dt-responsive table-responsive">
                                        <table id="salesreport" class="table table-striped table-bordered nowrap">
                                            <thead>
                                                <tr>
                                                    <th>Sr&nbsp;No</th>
                                                    <th>Action</th>
                                                     <th>Return Order ID</th>
                                                     <th>Order ID</th>
                                                    <th>Buyer</th>
                                                    <th>Seller</th>
                                                    <th>Order Shipment</th>
                                                    <th>Order Price</th>
                                                    <th>Return Order Price</th>
                                                    <th>Return Shipping Cost</th>
                                                    <th>Mobile</th>
                                                    <th>Status</th>
                                                    <th>Return Date</th>
                                                    <th>Shipping Method</th>
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
<?php $this->load->view("admin/common/footer"); ?>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.html5.min.js"></script>
<script>
    $(document).ready(function () {
        var dtTable = $('#salesreport').DataTable({
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
                url: "<?php echo base_url('admin/report/fetch_return_report') ?>",
                dataType: "json",
                type: "POST",
                data: function (data) {
                   
                    data.orders_id = $('#orderid').val();
                    data.datefrom = $('#dateFrom').val();
                    data.dateto = $('#dateTo').val();
                    data.user_telephone = $('#phone').val();
                    data.<?php echo $this->security->get_csrf_token_name(); ?> = "<?php echo $this->security->get_csrf_hash(); ?>";

                }
            },
            columns: [
                {data: "sr_no"},
                {data: "action"},
                {data: "return_orders_id"},
                {data: "orders_id"},
                {data: "user_name"},
                {data: "pick_name"},
                {data: "shippment_type"},
                {data: "order_price"},
                {data: "return_order_price"},
                {data: "return_shipping_cost"},
                {data: "user_telephone"},
                {data: "orders_status_name"},
                {data: "return_date"},
                {data: "ship_vendor_id"},
               
            ],
            "lengthMenu": [[100, 250, 500, -1], [100, 250, 500, "All"]]
        });

        $(document).on('click', '#btnFilter', function () {
            //dtTable.destroy();
            dtTable.clear().draw();
        });
		
		$(document).on('click', '#export', function(){
			$('#form_submit').submit();
		});

        $("#dateFrom").dateDropper({
            format: "d-m-Y",
            dropWidth: 200,
            dropPrimaryColor: "#1abc9c",
            dropBorder: "1px solid #1abc9c",
            maxYear: "2020",
        });
        $("#dateTo").dateDropper({
            format: "d-m-Y",
            dropWidth: 200,
            dropPrimaryColor: "#1abc9c",
            dropBorder: "1px solid #1abc9c",
            maxYear: "2020",
        });
    });

    $('.daterange').click(function () {
        var datefrom = $(this).attr('data-from');
        var dateto = $(this).attr('data-to');
        $("#dateFrom").val(datefrom);
        $("#dateTo").val(dateto);
        $('#btnFilter').trigger('click');
        $(".daterange").removeClass('badge-success');
        $(".daterange").addClass('badge-warning');
        $(this).addClass('badge-success');
    });
</script>
