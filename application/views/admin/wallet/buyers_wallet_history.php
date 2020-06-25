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
                                    <h4>Buyers Wallet History</h4>	
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
                                    <li class="breadcrumb-item">Buyers Wallet History</li>
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
                                    <h5>Wallet History</h5>
			                                    			
                                </div>
                                <div class="card-block">
                                    <div class="dt-responsive table-responsive">
                                        <table id="buyers_wallet" class="table table-striped table-bordered nowrap">
                                            <thead>
                                                <tr>
                                                    <th>Sl.no</th>
                                                    <th>Amount</th>
													<th>Transaction Type</th>
                                                    <th>Against</th>
													<th>reference</th>
													<th>remark</th>
													<th>created</th>
													
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
		var user_id = '<?php echo $user_id; ?>';
        var dataTable = $('#buyers_wallet').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "<?php echo base_url('admin/wallet/get_buyers_wallet_history/'); ?>"+user_id,
                type: "POST",
                data: function (data) {
                    data.<?php echo $this->security->get_csrf_token_name(); ?> = "<?php echo $this->security->get_csrf_hash(); ?>";
                   
                },
            },
            columnDefs: [
                {className: "dropdown", "targets": [6]}
            ],
            "language": {                
                "infoFiltered": ""
            }

        });

        $('#button-filter').on('click change', function (event) {
            dataTable.draw();
        });

    });
</script>


