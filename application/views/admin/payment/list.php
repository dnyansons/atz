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
                                    <h4>Order Transaction</h4>
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
                                    <li class="breadcrumb-item"><a href="#">Payment List</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="page-body">
                    <div class="row">
                        <div class="col-sm-12">

                            <div class="card">
							<h6 style="text-align:center;"><?php echo $this->session->flashdata('message'); ?></h6>
                               
                                <div class="card-block">
                                    <div class="dt-responsive table-responsive">
                                        <table id="couponTable" class="table table-striped table-bordered nowrap">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Order ID</th>
                                                    <th>User ID</th>
                                                    <th>Email</th>
                                                    <th>Amount</th>
                                                    <th>Status</th>
                                                    <th>Method</th>
                                                    <th>Trans ID</th>
                                                    <th>Created</th>
													
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
    
    $('#couponTable').DataTable({
        processing: true,
        serverSide: true,
        "order":[['1','desc']],
        ajax:{
                 url: "<?php echo base_url('admin/payment_trasaction/ajax_list') ?>",
                 dataType: "json",
                 type: "POST",
                 data:{  '<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>' } },
                 columns: [
                      { data: "id" },
                      { data: "orders_id" },
                      { data: "user_id" },
                      { data: "email" },
                      { data: "amount" },
                      { data: "status" },
                      { data: "method" },
                      { data: "payment_id" },
                      { data: "created_at" }
                   ]     

        });
});
</script>