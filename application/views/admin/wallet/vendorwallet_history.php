<?php $this->load->view("admin/common/header"); ?>
<div class="pcoded-content">
    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-header">
                    <div class="row align-items-end">
                        <div class="col-lg-6">
                            <div class="page-header-title">
                                <div class="d-inline">
                                    <h4>Vendor's Wallet History (<?php echo $status; ?> Payments)</h4>
                                    <span></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="page-header-breadcrumb">
                                <ul class="breadcrumb-title">
                                    <li class="breadcrumb-item">
                                        <a href="<?php echo site_url(); ?>admin/dashboard"> <i class="feather icon-home"></i> </a>
                                    </li>
                                    <li class="breadcrumb-item"><a href="#">Wallet</a></li>
									<li class="breadcrumb-item"><a href="<?php echo site_url(); ?>admin/wallet/vendor">Vendors Wallet</a></li>
									<li class="breadcrumb-item"><a href="<?php echo current_url(); ?>">Vendor's Wallet History</a></li>
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
                                    <h5>Vendor's Wallet History (Pending)</h5>
                                </div>
                                <div class="card-block">
                                    <?php echo $this->session->flashdata("message");?>
                                    <div class="dt-responsive table-responsive">
                                        <table id="categoryTable" class="table table-striped table-bordered nowrap">
                                            <thead>
                                                <tr>
                                                    <th>Order Id</th>
                                                    <th>Amount</th>
													<th>Status</th>
													<th>Date Added</th>
                                                </tr>
                                            </thead>
											<tbody>
												
											</tbody>
											<!--tfoot>
												<td></td>
												<td id="total"></td>
												<td></td>
												<td></td>
											</tfoot-->
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
<script>
    $(document).ready(function () {
        $('#categoryTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "<?php echo base_url('admin/wallet/fetch_wallet_history') ?>",
                dataType: "json",
                type: "POST",
                data: {status:'<?php echo $status; ?>',vendor_id:'<?php echo $vendor_id; ?>','<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>'},
				// success:function(resp){
					//$('#total').text(resp.total);
					// }
				},
				columns: [
					{data: "orderid"},
					{data: "amount"},
					{data: "status"},
					{data: "dateadded"}
				],
				/*"footerCallback": function(row, data, start, end, display) 
				{
						var api = this.api();
						api.columns(1, { page: 'current' }).every(function () {
							var sum = this
								.data()
								.reduce(function (a, b) {
									var x = parseFloat(a) || 0;
									var y = parseFloat(b) || 0;
									return x + y;
								}, 0);
								console.log(sum);
							// Update footer
						$(this.footer()).html(sum);
					});
				}*/
				
        });
    });
</script>
