<?php $this->load->view('admin/common/header'); ?>
<div class="pcoded-content">
    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-header">
                    <div class="row align-items-end">
                        <div class="col-lg-8">
                            <div class="page-header-title">
                                <div class="d-inline">
                                    <h4>User ALL Orders</h4>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="page-header-breadcrumb">
                                <ul class="breadcrumb-title">
                                    <li class="breadcrumb-item">
                                        <a href="<?php echo site_url();?>buyer/dashboard"> <i class="feather icon-home"></i> </a>
                                    </li>
                                    <li class="breadcrumb-item"><a href="#!">User Orders</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="page-body">

                    <div class="row">
                        <div class="col-lg-12">
                             <div class="tab-content">
                                <div class="tab-pane active" id="buyer" role="tabpanel">
                                    <div class="card">
                                        <h6 style="text-align:center;"><?php echo $this->session->flashdata('message'); ?></h6>

                                        <div class="card-block">
                                            <div class="dt-responsive table-responsive">
                                                <table id="buyer_orderTable" class="table table-striped table-bordered nowrap">
                                                    <thead>
                                                        <tr>
                                                            <th>Order ID</th>
                                                            <th>Price</th>
                                                            <th>Status</th>
                                                            <th>Date</th>
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
        
    </div>
</div>
<?php $this->load->view('admin/common/footer'); ?>
<script>
    $(document).ready(function () {
        $('#buyer_orderTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "<?php echo base_url('admin/users/buyer_ajax_list/' . $user_id) ?>",
                dataType: "json",
                type: "POST",
                data: {'<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>'}},
            columns: [
                {data: "orders_id"},
                {data: "order_price"},
                {data: "orders_status_name"},
                {data: "date_purchased"},
                {data: "action"}, 
            ]

        });

        $('#button-filter').on('click change', function (event) {
            //event.preventDefault();
            dataTable.draw();
        });

    });

</script>