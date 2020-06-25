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
                                    <h4>Product Bulk Upload</h4>
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
                                    <li class="breadcrumb-item"><a href="#">Bulk</a></li>
                                    <li class="breadcrumb-item"><a href="<?php echo site_url(); ?>seller/bulkimport">Product Bulk Import</a></li>
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
                                        <div class="col-md-4">
                                            <span class="">From</span><br />
                                            <input type="text" class="form-control" value="<?php echo date('d-m-Y'); ?>" placeholder="Date From" id="dateFrom" name="datefrom">
                                        </div>
                                        <div class="col-md-4">
                                            <span class="">To</span><br />
                                            <input type="text" class="form-control" value="<?php echo date('d-m-Y'); ?>" placeholder="Date To" id="dateTo" name="dateto">
                                        </div>
                                       
                                        <div class="col-md-4">
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
                                    <h5>All Bulk Product Import</h5>
                                    <a class="btn btn-success btn-sm pull-right" href="<?php echo base_url(); ?>seller/bulkimport/import">Import File</a><a class="btn btn-info btn-sm pull-right mr-2" href="<?php echo base_url(); ?>uploads/sheets/products/sample_upload.xlsx">Sample Data</a>
                                </div>
                                <div class="card-block">
                                    <?php echo $this->session->flashdata("message"); ?>
                                    <div class="dt-responsive table-responsive">
                                        <table id="bulkreport" class="table table-striped table-bordered nowrap">
                                            <thead>
                                                <tr>
                                                    <th>Sr&nbsp;No</th>
                                                    <th>File Name</th>
                                                     <th>Total Record</th>
                                                     <th>Total Pass</th>
                                                     <th>Total Failed</th>
                                                     <th>Failed Data</th>
                                                     <th>Date Created</th>
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
   

//
$(document).ready(function () {
        var dtTable = $('#bulkreport').DataTable({
            processing: true,
            serverSide: true,
            searching: false,
            dom: 'Bfrtip',
            buttons: [
                'excelHtml5',
                'pdfHtml5'
            ],
            ajax: {
                url: "<?php echo base_url('seller/bulkimport/fetch_bulkimport') ?>",
                dataType: "json",
                type: "POST",
                data: function (data) {
                    console.log("import data"+data);
                    data.datefrom = $('#dateFrom').val();
                    data.dateto = $('#dateTo').val();
                    data.<?php echo $this->security->get_csrf_token_name(); ?> = "<?php echo $this->security->get_csrf_hash(); ?>";

                }
            },
             columns: [
                {data: "sr_no"},
                {data: "file_name"},
                {data: "total"},
                {data: "tot_pass"},
                {data: "tot_failed"},
                {data: "download"},
                {data: "date_created"}
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
