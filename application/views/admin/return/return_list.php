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
                                    <h4>Return Order</h4>
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
                                    <li class="breadcrumb-item"><a href="#">Return Requests List</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="page-body">
                    <div class="row">
                        <div class="col-sm-12">
							<?php echo $this->session->flashdata('message'); ?>
                            <div class="card">
                                
                                <div class="card-block">
                                    <div class="dt-responsive table-responsive">
                                        <table id="returnsTable" class="table table-striped table-bordered nowrap">
                                            <thead>
                                                <tr>
                                                    <th>Order ID</th>
                                                    <th>User</th>
													<th>Seller</th>
                                                    <th>Order Price</th>
													<th>Return Type</th>
													<th>Status</th>
                                                    <th>Delivery Date</th>
                                                    <th>Return Date</th>
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
    $('#returnsTable').DataTable({
        processing: true,
        serverSide: true,
        ajax:{
                 url: "<?php echo base_url('admin/return_orders/ajax_return_list') ?>",
                 dataType: "json",
                 type: "POST",
                 data:{  '<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>' } 
             },
                 columns: [
                      { data: "order_id" },
                      { data: "user_id" },
					  { data: "seller_id" },
                      { data: "order_price" },
                      { data: "return_type" },
                      { data: "orders_status_name" },
                     { data: "delivery_date" },
                      { data: "cr_date" },
					  { data: "action" }
                   ]	 

        });
});
</script>