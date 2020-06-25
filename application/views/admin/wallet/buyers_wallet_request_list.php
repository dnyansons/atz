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
                                    <h4>Buyers Wallet Request</h4>	
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
                                    <li class="breadcrumb-item">Buyers Wallet Request</li>
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
									<?php echo $this->session->flashdata('message'); ?>
								<form action = "<?php echo base_url(); ?>admin/wallet_request/createExcel" method = "post" id="form_submit">
									<div class="row mt-4">
									     <div class="col-3"><strong>Wallet Request</strong></div>
										<div class="col-3">
											<div class="input-group">
												<label class="pr-2">From Date</label> 
												<input type="text" class="form-control" id="dateFrom" name="dateFrom">
											</div>
										</div>
										<div class="col-3">
											<div class="input-group">
												<label class="pr-2">To Date</label>  <input type="text" class="form-control" id="dateTo" name="dateTo">
											</div>
										</div>
										<div class="col-1">
											<input type="button" class="btn btn-info btn-sm" id="btnFilter" value="Search">
										</div>
									
									
										<div class="col-1">
											<input type="button" class="btn btn-info btn-sm" id="export" value="Export To Excel">
										</div>
									</div>
								</form>
									
								</div>
                               
								
                                <div class="card-block">
                                    <div class="dt-responsive table-responsive">
                                        <table id="buyers_wallet" class="table table-striped table-bordered nowrap">
                                            <thead>
                                                <tr>
                                                    <th>Sr.No</th>
                                                    <th>Name</th>
													<th>Amount</th>
                                                    <th>Request Date</th>
													<th>Updated Date</th>
													<th>Status</th>
                                                                                                        <th>Approved By</th>
													<th>Action</th>
													
                                                </tr>
                                            </thead>
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

<?php $this->load->view("admin/common/footer");?>
 <script>
	 
	  $(document).ready(function () {
        var dataTable = $('#buyers_wallet').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "<?php echo base_url('admin/wallet_request/get_buyers_wallet_request'); ?>",
                type: "POST",
                data: function (data) {
					data.from_date = $('#dateFrom').val();
					data.to_date = $('#dateTo').val();
                    data.<?php echo $this->security->get_csrf_token_name(); ?> = "<?php echo $this->security->get_csrf_hash(); ?>";
                   
                },
            },
            columnDefs: [
                {className: "dropdown", "targets": [6]}

            ],
           "order":[[0,'desc']],
            "language": {                
                "infoFiltered": ""
            },
            
        });

        $(document).on('click', '#btnFilter', function () {
			var dateFrom = $('#dateFrom').val(); 
			var dateTo = $('#dateTo').val();
			if(dateFrom == '' || dateTo == '')
			{
				alert("Please Select Both The Fields");

			}else{
				dataTable.clear().draw();
			}
		});

    });

	$(document).on('click', '#export', function(){
		var dateFrom = $('#dateFrom').val(); 
		var dateTo = $('#dateTo').val();
		if(dateFrom == '' || dateTo == '')
		{
			alert("Please Select Both The Date Fields");

		}else{
			$('#form_submit').submit();
		}
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
</script>


