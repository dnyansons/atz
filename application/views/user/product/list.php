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
                                    <h4>Products</h4>
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
                                    <li class="breadcrumb-item"><a href="#">Products List</a></li>
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
                                    <h5>Products Table</h5>
                                    
                                    <?php if(!empty($this->session->flashdata('message'))){ ?>
                                        <div class="alert alert-success alert-dismissible col-md-6 offset-3">
                                          <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                          <strong>Success : </strong> <?php echo $this->session->flashdata('message'); ?>
                                        </div> 
                                     <?php } ?>
									
									<a href="<?php echo base_url(); ?>seller/products/addProduct">
                                    <button type="button" class="btn btn-primary waves-effect waves-light f-right d-inline-block md-trigger" data-modal="modal-13"> <i class="fa fa-plus"></i> Add Product
                                    </button>
                                    </a>
									
                                </div>
                                <div class="card-block">
                                    <div class="dt-responsive table-responsive">
                                        <table id="productsTable" class="table table-striped table-bordered nowrap">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
													<th>Product Image</th>
                                                    <th>Product Name</th>
                                                    <th>Price</th>
													<th>Status</th>
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
    $('#productsTable').DataTable({
        processing: true,
        serverSide: true,
        ajax:{
                 url: "<?php echo base_url('seller/products/ajax_list') ?>",
                 dataType: "json",
                 type: "POST",
                 data:{  '<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>' } },
                 columns: [
                      { data: "products_id" },
                      { data: "products_image" },
                      { data: "products_name" },
					  { data: "products_price" },
					  { data: "products_status" },
                      { data: "action" },
                   ]	 

        });
});
</script>