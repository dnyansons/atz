<?php $this->load->view("supplier/common/header");?>
<div class="pcoded-content">
    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-header">
                    <div class="row align-items-end">
                        <div class="col-lg-8">
                            <div class="page-header-title">
                                <div class="d-inline">
                                    <h4>Product options</h4>
                                    <span></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="page-header-breadcrumb">
                                <ul class="breadcrumb-title">
                                    <li class="breadcrumb-item">
                                        <a href="<?php echo site_url();?>seller/dashboard"> <i class="feather icon-home"></i> </a>
                                    </li>
                                    <li class="breadcrumb-item"><a href="#">Product options List</a></li>
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
                                    <h5>Product Option Table</h5>
									
									<a href="<?php echo base_url(); ?>supplier/productoptions/addproductoptions">
                                    <button type="button" class="btn btn-primary waves-effect waves-light f-right d-inline-block md-trigger" data-modal="modal-13"> <i class="fa fa-plus"></i> Add Product Option
                                    </button>
                                    </a>
									
                                </div>
                                <div class="card-block">
                                    <div class="dt-responsive table-responsive">
                                        <table id="productOptionsTable" class="table table-striped table-bordered nowrap">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Product Option Name</th>
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
<?php $this->load->view("supplier/common/footer");?>
<script>
 $(document).ready(function () {
    $('#productOptionsTable').DataTable({
        processing: true,
        serverSide: true,
        ajax:{
                 url: "<?php echo base_url('supplier/productoptions/ajax_list') ?>",
                 dataType: "json",
                 type: "POST",
                 data:{  '<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>' } },
                 columns: [
                      { data: "products_options_id" },
                      { data: "products_options_name" },
                      { data: "action" },
                   ]	 

        });
});
</script>