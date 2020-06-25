<div class="pcoded-content">
    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-header">
                    <div class="row align-items-end">
                        <div class="col-lg-8">
                            <div class="page-header-title">
                                <div class="d-inline">
                                    <h4>Edit Data Report</h4>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="page-header-breadcrumb">
                                <ul class="breadcrumb-title">
                                    <li class="breadcrumb-item">
                                        <a href="<?php echo base_url('admin/dashboard');?>"> <i class="feather icon-home"></i> </a>
                                    </li>
                                    <li class="breadcrumb-item"><a href="<?php echo base_url('admin/BI/data_reports/');?>">Data Reports</a></li>
                                    <li class="breadcrumb-item">Edit Data Reports</li>
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
                                    <div class="card-header-right">
                                        <i class="icofont icofont-spinner-alt-5"></i>
                                    </div>
                                </div>
                                <div class="card-block">
                                    <h4 class="sub-title">Edit Data Report</h4>
                                        <?php if ($this->session->flashdata('success') != ''){?>
                                                <div class='alert alert-success alert-dismissible'>
                                                   <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                                                   <?php echo $this->session->flashdata('success'); ?>
                                                </div>
                                        <?php } ?>	

                                        <?php if ($this->session->flashdata('error') != ''){?>
                                                <div class='alert alert-danger alert-dismissible'>
                                                   <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                                                   <?php echo $this->session->flashdata('error'); ?>
                                                </div>
                                        <?php } ?>	
									
                                    <form method="post" enctype="multipart/form-data">
	                                <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Topic</label>
                                            <div class="col-sm-10">
                                                <input type="text" name="topic" id="topic" class="form-control" placeholder="Topic" value="<?php echo set_value('topic',$record->topic);?>" required>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Short Description : </label>
                                            <div class="col-sm-10">
                                                <textarea class="form-control" name="short_description" required><?php echo set_value('short_description',$record->short_description);?></textarea>
                                            </div>
                                        </div>
					<div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Overview : </label>
                                            <div class="col-sm-10">
                                                <textarea class="form-control" name="over_view" id="over_view" required><?php echo set_value('over_view',$record->overview);?></textarea>
                                            </div>
                                        </div>
					<div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Product Category : </label>
                                            <div class="col-sm-10">
                                               <select name="prod_category" id="prod_category" class="form-control" required>
                                                    <option value="">Select</option>
                                                     <?php if(!empty($categories)){
                                                              foreach($categories as $category){
                                                     ?>
                                                    <option value="<?php echo $category['category_id']; ?>" <?php echo $category['category_id'] == $record->cat_id ? 'selected':'';?>><?php echo $category['categories_name'];?></option>
                                                     <?php } }?>
                                               </select>				   
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                          <label class="col-sm-2 col-form-label">Product Sub Category : </label>
                                            <div class="col-sm-10">
                                                  <select name="prod_sub_category"  id="prod_sub_category" class="form-control" required>
                                                      <option value="">Select</option>
                                                     <?php if(!empty($sub_categories)){
                                                              foreach($sub_categories as $sub_category){
                                                     ?>
                                                    <option value="<?php echo $sub_category['category_id']; ?>" <?php echo $sub_category['category_id'] == $record->sub_cat_id ? 'selected':'';?>><?php echo $category['categories_name'];?></option>
                                                     <?php } }?>
                                                  </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Status : </label>
                                                <div class="col-sm-10">
                                                  <select name="status"  id="status" class="form-control" required>
                                                    <option value="Active" <?php echo $record->status == 'Active' ? 'selected':'';?> >Active</option>
                                                    <option value="Inactive" <?php echo $record->status == 'Inactive' ? 'selected':'';?> >Inactive</option>
                                                  </select>
                                                </div>
                                        </div>
					<input type="hidden" name="id" value="<?php echo $record->id; ?>"> 
                                        <button type="submit" name="submit" value="submit" id="submit" class="btn btn-primary" id="primary-popover-content">Submit</button>
                                    </form>
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
</div>
<script>
 $('#prod_category').change(function(){
	 var cat_id = $(this).val();
	
	 if (cat_id){
		 $.ajax({
		 type:'post',
		 url:'<?php echo base_url('admin/BI/data_reports/get_product_sub_categories');?>',
		 data:{'cat_id':cat_id},
		 success:function(data){
			 $("#prod_sub_category").html(data);
		 },
		 error:function(){
			 alert('Error Handling Here');
		 }
	   });
	 }
 });
</script>