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
                                    <li class="breadcrumb-item"><a href="#">My Favourite List</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
				

                <div class="page-body">
                    <div class="row">
					
					
					<!----------Tab Start-------->
					<div class="col-lg-12 col-xl-12">
  
					   <ul class="nav nav-tabs md-tabs " role="tablist">
						  <li class="nav-item">
							 <a class="nav-link active" data-toggle="tab" href="#products" role="tab" aria-expanded="false">Products</a>
							 <div class="slide"></div>
						  </li>
						  <li class="nav-item">
							 <a class="nav-link" data-toggle="tab" href="#supplier" role="tab" aria-expanded="false">Suppliers</a>
							 <div class="slide"></div>
						  </li>
					   </ul>
				   <div class="tab-content card-block">
					  <div class="tab-pane active" id="products" role="tabpanel" aria-expanded="false">
						

                            <div class="card">
							<h6 style="text-align:center;"><?php echo $this->session->flashdata('message'); ?></h6>
							<p style="text-align:right;margin-right:20px;"><button type="button" class="btn btn-danger btn-sm pull-right pro_button" style="width:130px;">Delete</button></p>
                                
                                <div class="card-block">
                                    <div class="dt-responsive table-responsive">
                                        <table id="productTable" class="table table-striped table-bordered nowrap">
                                            <thead>
                                                <tr>
                                                    <th>Action</th>
                                                    <th>Image</th>
                                                    <th>Product Description</th>
													<th>Enquiry</th>
													
                                                </tr>
                                            </thead>
                                        </table>
                                    </div>
                                </div>
                            </div>
							
                      
						
					  </div>
					  <div class="tab-pane" id="supplier" role="tabpanel" aria-expanded="false">
						 <div class="tab-pane active" id="home7" role="tabpanel" aria-expanded="false">
						
							<div class="card">
							<h6 style="text-align:center;"><?php echo $this->session->flashdata('message'); ?></h6>
							<p style="text-align:right;margin-right:20px;"><button type="button" class="btn btn-danger btn-sm pull-right supp_button" style="width:130px;">Delete</button></p>
							
							
                                <div class="card-block">
                                    <div class="dt-responsive table-responsive">
                                        <table id="sellerTable" class="table table-striped table-bordered nowrap" style="width:100%;">
                                            <thead>
                                                <tr>
                                                    <th>Action</th>
                                                    <th>Seller Name</th>
                                                    <th>Email</th>
													<th>Company</th>
													<th>Enquiry</th>
													
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
					<!----------Tab End-------->
                        
                    </div>
                </div>

            </div>
        </div>
		
		


        
    </div>
</div>
<?php $this->load->view("user/common/footer");?>
<script>
 $(document).ready(function () {
	
    $('#productTable').DataTable({
        processing: true,
        serverSide: true,
        ajax:{
                 url: "<?php echo base_url('user/myfavourite/ajax_product_list') ?>",
                 dataType: "json",
                 type: "POST",
                 data:{  '<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>' } },
                 columns: [
                      { data: "products_id" },
                      { data: "products_image" },
                      { data: "products_name" },
                      { data: "action" },
                   ]	 

        });
		
		
		
		   $('#sellerTable').DataTable({
        processing: true,
        serverSide: true,
        ajax:{
                 url: "<?php echo base_url('user/myfavourite/ajax_seller_list') ?>",
                 dataType: "json",
                 type: "POST",
                 data:{  '<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>' } },
                 columns: [
                      { data: "id" },
                      { data: "first_name" },
                      { data: "email" },
                      { data: "company_name" },
                      { data: "action" },
                   ]	 

        });
		
		
		
		
		//Checking FOR REMOVE Favourite Product
		$(".pro_button").click(function(){
            var sons = [];
            $.each($("input[name='sons']:checked"), function(){            
                sons.push($(this).val());
            });
            
			if(sons!='')
			{
			$.ajax({
                type:'POST',
                url :'<?php echo base_url(); ?>user/myfavourite/remove_favourite',
                data: {'check_pro':sons},
                success:function(data){
      
				alert(data);
				location.reload();

                },
                error:function(){
                        alert('error handling here'); 
                }
            });
			}
			else
			{
				alert("Please Select atleast 1 Product to Remove ! ");
			}
			
        });
		
		
				//Checking FOR REMOVE Favourite Supplier
		$(".supp_button").click(function(){
            var supp_rem = [];
            $.each($("input[name='supplier_remove']:checked"), function(){            
                supp_rem.push($(this).val());
            });
            
			if(supp_rem!='')
			{
			$.ajax({
                type:'POST',
                url :'<?php echo base_url(); ?>user/myfavourite/favourite_seller_remove',
                data: {'check_pro':supp_rem},
                success:function(data){
      
				alert(data);
				location.reload();

                },
                error:function(){
                        alert('error handling here'); 
                }
            });
			}
			else
			{
				alert("Please Select atleast 1 Supplier to Remove ! ");
			}
			
        });
		
		
		
});
		

</script>