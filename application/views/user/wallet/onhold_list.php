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
                                    <h4>Wallet</h4>
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
                                    <li class="breadcrumb-item"><a href="#">Wallet List</a></li>
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
                                    <!-- <h5>Wallet Table</h5> -->
									<!-- <a href="<?php echo base_url(); ?>admin/shippingmethods/add">
                                    <button type="button" class="btn btn-primary waves-effect waves-light f-right d-inline-block md-trigger" data-modal="modal-13"> <i class="icofont icofont-plus m-r-5"></i> Add Wallet
                                    </button>
                                    </a> -->
                                    <div align="center">
                                    <a href="<?= base_url(); ?>user/wallet/all"><button class="btn btn-sm btn-default ml-4">All</button></a>
                                    <a href="<?= base_url(); ?>user/wallet/initiated"><button class="btn btn-sm btn-default ml-4">Initiated</button></a>
                                    <a href="<?= base_url(); ?>user/wallet/completed"><button class="btn btn-sm btn-default ml-4">Completed</button></a>
                                    <a href="<?= base_url(); ?>user/wallet/rejected"><button class="btn btn-sm btn-default ml-4">Rejected</button></a>
                                    <a href="<?= base_url(); ?>user/wallet/onhold"><button class="btn btn-sm btn-primary ml-4">On Hold</button></a>
                                    </div>
                                </div>
                                <div class="card-block">
                                    <div class="dt-responsive table-responsive">
                                        <table id="walletTable" class="table table-striped table-bordered nowrap">
                                            <thead>
                                                <tr>
                                                    <th>Orders ID</th>
                                                    <th>Delivery Date</th>
                                                    <th>Order Amount</th>
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
<?php $this->load->view("user/common/footer");?>
<script>
 $(document).ready(function () {
    $('#walletTable').DataTable({
        processing: true,
        serverSide: true,
        ajax:{
                 url: "<?php echo base_url('user/wallet/ajax_list_all') ?>",
                 dataType: "json",
                 type: "POST",
                 data:{  '<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>' } },
                 columns: [
                      { data: "orders_id" },
                      { data: "delivery_date" },
                      { data: "order_amount" },
                      { data: "action" }
                   ]	 

        });
});
</script>