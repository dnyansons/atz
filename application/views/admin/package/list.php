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
								
                                    <h4><?php echo $pageTitle; ?></h4>
                                    <span></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="page-header-breadcrumb">
                                <ul class="breadcrumb-title">
                                    <li class="breadcrumb-item">
                                        <a href="<?php echo site_url();?>user"> <i class="feather icon-home"></i> </a>
                                    </li>
                                    <li class="breadcrumb-item"><a href="#">Subcription Packages</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
				

                <div class="page-body">
                    <div class="row">
					
					
					<!----------Tab Start-------->
					<div class="col-lg-12 col-xl-12">
  
					   
				   <div class="tab-content card-block">
					  <div class="tab-pane active" id="products" role="tabpanel" aria-expanded="false">
						

                            <div class="card">
							<h6 style="text-align:center;"><?php echo $this->session->flashdata('message'); ?></h6>
							<p style="text-align:right;margin-right:20px;"><a href="<?php echo base_url().$action; ?>" type="button" class="btn btn-danger btn-sm pull-right" style="width:130px;">Create Package</a></p>
                                
                                <div class="card-block">
                                    <div class="dt-responsive table-responsive">
                                        <table id="productTable" class="table table-striped table-bordered nowrap">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th title="Package Name">Pkg Name</th>
                                                    <th>Duration</th>
													<th>Basic Price</th>
													<th title="Product Ranking">Prod Ranking</th>
													<th title="Customized Website">C Website</th>
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
					<!----------Tab End-------->
                        
                    </div>
                </div>

            </div>
        </div>
		
		


        
    </div>
</div>
<?php $this->load->view("admin/common/footer");?>
<script>
 $(document).ready(function () {
	
    $('#productTable').DataTable({
        processing: true,
        serverSide: true,
        ajax:{
                 url: "<?php echo base_url('admin/packages/ajax_list') ?>",
                 dataType: "json",
                 type: "POST",
                 data:{  '<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>' } },
                 columns: [
                      { data: "sub_id" },
                      { data: "pkg_name" },
                      { data: "duration" },
                      { data: "price" },
                      { data: "product_ranking" },
                      { data: "customized_website" },
                      { data: "status" },
                      { data: "action" },
                   ]	 

        });
		
	
		
		
});
		

</script>