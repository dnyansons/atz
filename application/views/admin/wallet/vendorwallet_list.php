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
                                    <h4>Vendor's Wallet</h4>
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
                                    <li class="breadcrumb-item"><a href="#">Wallet</a></li>
									<li class="breadcrumb-item"><a href="<?php echo site_url(); ?>admin/wallet/vendor">Vendors Wallet</a></li>
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
                                    <h5>Vendor's Wallet</h5>
                                </div>
                                <div class="card-block">
                                    <?php echo $this->session->flashdata("message");?>
                                    <div class="dt-responsive table-responsive">
                                        <table id="categoryTable" class="table table-striped table-bordered nowrap">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Vendor's Name</th>
													<th>Phone</th>
													<th>Settled Amount</th>
                                                    <th>Available Amount</th>
                                                    <th>Pending Amount</th>
                                                    <th>Hold Amount</th>													
													<th>Username</th>
													<th>Email</th>
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
<script>
    $(document).ready(function () {
        $('#categoryTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "<?php echo base_url('admin/wallet/fetch_vendors') ?>",
                dataType: "json",
                type: "POST",
                data: {'<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>'}},
            columns: [
                {data: "id"},
                {data: "name"},
				{data: "phone"},
				{data: "settled"},
                {data: "available"},
                {data: "pending"},
                {data: "hold"},
				{data: "username"},
				{data: "email"}
            ]

        });
    });
</script>
