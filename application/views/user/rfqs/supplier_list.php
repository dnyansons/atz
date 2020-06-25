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
                                    <h4>Suppliers</h4>
                                    <span></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="page-header-breadcrumb">
                                <ul class="breadcrumb-title">
                                    <li class="breadcrumb-item">
                                        <a href="<?php echo site_url();?>user/dashboard"> <i class="feather icon-home"></i> </a>
                                    </li>
                                    <li class="breadcrumb-item"><a href="#">Supplier Users List</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="page-body">
                    <div class="row">
                        <div class="col-sm-12">
							<?php echo $this->session->flashdata("message");?>
							<div class="alert alert-success alert-dismissible" style='display:none;'>Requests forwarded successfully.
								<button data-dismiss="alert" type="button" class="close" aria-label="Close">
									<span aria-hidden="true">&times;</span>
								</button>
							</div>
                            <div class="card">
                                <div class="card-header">
                                    <h5>Suppliers Table</h5>
									<p>Click on row to select supplier</p>
									<button type="button" class="btn btn-sm btn-info pull-right" id="forwardTriger">
										Forward
									</button>
                                </div>
                                <div class="card-block">
                                    <div class="dt-responsive table-responsive">
                                        <table id="supplierTable" class="table table-striped table-bordered nowrap">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Name</th>
                                                    <th>Company</th>
                                                    <th>email</th>
                                                    <th>phone</th>
												</tr>
                                            </thead>
                                        </table>
                                    </div>
                                </div>
                            </div>
							<!-- Remove this only for debugging 
							<div class="row" id="debug">
								
							</div>
							----->
                        </div>
						
						
						
                    </div>
                </div>

            </div>
        </div>
		
        
    </div>
</div>

<?php $this->load->view("user/common/footer");?>
<script>
 $(document).ready(function () {
    var table = $('#supplierTable').DataTable({
        processing: true,
        serverSide: true,
        ajax:{
                 url: "<?php echo base_url('user/rfqs/ajax_supplier_list') ?>",
                 dataType: "json",
                 type: "POST",
                 data:{  '<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>' } 
		},
		columns: [
			{ data: "id" },
			{ data: "name" },
			{ data: "company" },
			{ data: "email" },
			{ data: "telephone" },
		],
	});
	
	$('#supplierTable tbody').on( 'click', 'tr', function () {
		$(this).toggleClass('selected');
	});
	
	$('#forwardTriger').click( function () {
		
		var ids = $.map(table.rows('.selected').data(), function (item) {
			return item["id"]
		});	
		console.log(ids);
		$.ajax({
			url: "<?php echo site_url();?>user/rfqs/ajaxApplyRequestsTosuppliers",
			cache: false,
			type:"POST",
			data : {supplier_ids:ids,rfqs_id:"<?php echo $rfqs_id;?>"},
			success: function(resp){
				var response = JSON.parse(resp);
				console.log(response.success);
				if(resp){
					$('.alert').show();
				} else {
					$('.hide').show();
				}
			}
		});
	});
	
});
</script>