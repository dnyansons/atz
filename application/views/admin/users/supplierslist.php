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
                                    <h4>Suppliers</h4>
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
                            <div class="card">
                                <div class="card-header">
                                    <h5>Suppliers Table</h5>
                                </div>
                                <div class="card-block">
                                    <div class="dt-responsive table-responsive">
                                        <table id="categoryTable" class="table table-striped table-bordered nowrap">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Name</th>
                                                    <th>Company</th>
                                                    <th>Categories</th>
													<th>Products</th>
                                                    <th>Plan</th>
                                                    <!--<th>Email</th>
                                                    <th>Phone</th>-->
                                                    <th>Country</th>
                                                    <th>State</th>
                                                    <!--<th>City</th>-->
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
    $('#categoryTable').DataTable({
        processing: true,
        serverSide: true,
        ajax:{
                 url: "<?php echo base_url('admin/suppliers/ajax_list') ?>",
                 dataType: "json",
                 type: "POST",
                 data:{  '<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>' } },
                 columns: [
                      { data: "id" },
                      { data: "name" },
                      { data: "company" },
                      { data: "product_categories" },
                      { data: "products_listed" },
                      { data: "subscription_plan" },
                      /*{ data: "email" },
                      { data: "telephone" },*/
                      { data: "country" },
                      { data: "state" },
                      /*{ data: "city" },*/
                      { data: "action" },
                   ]	 

        });
});
</script>