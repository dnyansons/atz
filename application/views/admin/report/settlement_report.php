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
                                    <h4>Settlement Report(Settled Transaction)</h4>
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
                                    <li class="breadcrumb-item">Report</li>
                                    <li class="breadcrumb-item">Settlement Report</li>
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
                                    <form action = "<?php echo base_url(); ?>admin/report/exportSettlementReport" method = "post" id="form_submit">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <span class="badge badge-success badge-md daterange" data-from="<?php echo date('d-m-Y'); ?>" data-to="<?php echo date('d-m-Y'); ?>" >Today</span>
                                                <span class="badge badge-warning badge-md daterange" data-from="<?php echo date('d-m-Y', strtotime("-1 days")); ?>" data-to="<?php echo date('d-m-Y', strtotime("-1 days")); ?>" >Yesterday</span>
                                                <span class="badge badge-warning badge-md daterange" data-to="<?php echo date('d-m-Y'); ?>" data-from="<?php echo date('d-m-Y', strtotime("-7 days")); ?>">Last 7 Days</span>
                                                <span class="badge badge-warning badge-md daterange" data-from="<?php echo date('01-m-Y'); ?>" data-to="<?php echo date('t-m-Y'); ?>">This Month</span>
                                            </div>
                                            
                                            <div class="col-md-2">
                                                <p class="">From</p>
                                                <input type="text" class="form-control" value="<?php echo date('d-m-Y'); ?>" placeholder="Date From" id="dateFrom" name="datefrom">
                                            </div>
                                            
                                            <div class="col-md-2">
                                                <p class="">To</p>
                                                <input type="text" class="form-control" value="<?php echo date('d-m-Y'); ?>" placeholder="Date To" id="dateTo" name="dateto">
                                            </div>
                                            
                                            <div class="col-md-2">
                                                <p class="">Order id</p>
                                                <input type="text" class="form-control" id="orderid" name="order_id" placeholder="Order Id">
                                            </div>
                                            
                                            <div class="col-md-2">
                                                <p class="">Vendor ID</p>
                                                <input type="text" class="form-control" id="vendorid" name="vendor_id" placeholder="Vendor Id">
                                            </div>

                                           <div class="col-md-1">
                                                <p>&nbsp;</p>
                                                <input type="button" class="btn btn-info btn-sm" id="btnFilter" value="Filter">
                                            </div>

                                            <div class="col-md-2">
                                                <p>&nbsp;</p>
                                                <input type="button" class="btn btn-info btn-sm " id="export" value="Export To Excel">
                                            </div>
                                            
                                            <div class="col-md-1" style='margin-left:-35px !important;'>
                                                <p>&nbsp;</p>
                                                <input type="reset" class="btn btn-info btn-sm" id="btnReset" value="reset">
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
                                    <h5>Settlement Report</h5>
                                </div>
                                <div class="card-block">
                                    <?php echo $this->session->flashdata("message"); ?>
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
                                                    <th>Date Settled</th>
                                                    <th>Remark</th>
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

    $(document).on('click', '#export', function () {
        var formAction = '<?php echo base_url(); ?>admin/report/generateExcelReportSettlement';
        //set form action
        $('#form_submit').attr('action', formAction);
        //submit form
        $('#form_submit').submit();
    });

//    $(document).on('click', '#btnFilter', function () {
//            var formAction = '<?php echo base_url(); ?>admin/report/exportSettlementReport';
//            //set form action
//            $('#form_submit').attr('action', formAction);
//            //submit form
//            $('#form_submit').submit();
//        });

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
                url: "<?php echo base_url('admin/report/fetch_comission_report') ?>",
                dataType: "json",
                type: "POST",
                data: function (data) {
                    data.order_status = $('#orderstatus').val();
                    data.vendor_id = $('#vendorid').val();
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
                {data: "datesettled"},
                {data: "remark"},
            ],
            "lengthMenu": [[100, 250, 500, -1], [100, 250, 500, "All"]]
        });

        $(document).on('click', '#btnFilter', function () {
            //dtTable.destroy();
            dtTable.clear().draw();
        });

        $(document).on('click', '#export', function () {
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
