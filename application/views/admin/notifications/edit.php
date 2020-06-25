<div class="pcoded-content">
    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-header">
                    <div class="row align-items-end">
                        <div class="col-lg-8">
                            <div class="page-header-title">
                                <div class="d-inline">
                                    <h4>Edit App Banner</h4>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="page-header-breadcrumb">
                                <ul class="breadcrumb-title">
                                    <li class="breadcrumb-item">
                                        <a href="<?php echo base_url('admin/dashboard');?>"> <i class="feather icon-home"></i> </a>
                                    </li>
                                    <li class="breadcrumb-item"><a href="<?php echo base_url('admin/BI/event/');?>">Event</a></li>
                                    <li class="breadcrumb-item">Edit Event</li>
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
                                    <h4 class="sub-title">Edit Event</h4>
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
                                            <label class="col-sm-2 col-form-label">Uploaded Banner Image :</label>
                                            <div class="col-sm-10">
                                                <img src="<?php echo $record->image;?>" style="height: 100px;width: 100px;">
                                            </div>
                                        </div>
	                                <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Banner Image :</label>
                                            <div class="col-sm-10">
                                                <input type="file" name="image" id="image" class="form-control">
                                            </div>
                                        </div>
                                         <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Type : </label>
                                            <div class="col-sm-10">
                                                <select name="type" id="type" class="form-control" required="true">
                                                    <option value="">Select</option>
                                                    <option value="App" <?php echo $record->type == 'App' ? 'selected':'';?>>App</option>
                                                    <option value="Webview" <?php echo $record->type == 'Webview' ? 'selected':'';?>>Webview</option>
                                                </select>
                                            </div>
                                        </div>
                                        <?php if($record->type == 'Webview'){ ?>
                                        <div class="form-group row" id="url_wrapper">
                                            <label class="col-sm-2 col-form-label">URL : </label>
                                            <div class="col-sm-10">
                                                <input type="url" name="url" class="form-control" value="<?php echo set_value('url',$record->url);?>">
                                            </div>
                                        </div>
                                        <?php } ?>
                                         <?php if($record->type == 'App'){ ?>
                                         <div class="form-group row" id="on_wrapper">
                                            <label class="col-sm-2 col-form-label">ON : </label>
                                            <div class="col-sm-10">
                                                 <select name="on" id="on" class="form-control">
                                                    <option value="">Select</option>
                                                    <option value="Product"  <?php echo $record->on_app == 'Product' ? 'selected':'';?>>Product</option>
                                                    <option value="Category" <?php echo $record->on_app == 'Category' ? 'selected':'';?>>Category</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row" id="reference_id_wrapper">
                                            <label class="col-sm-2 col-form-label" id="reference_label">Product/Category : </label>
                                            <div class="col-sm-10">
                                                 <select name="reference_id" id="reference_id" class="form-control">
                                                    <option value="">Select</option>
                                                    <?php if (!empty($referrence_arr)){ foreach ($referrence_arr as $reference){?>
                                                      <option value="<?php echo $reference['id']?>" <?php echo $record->reference_id == $reference['id'] ? 'selected':'';?>><?php echo $reference['name'];?></option>
                                                    <?php }} ?>
                                                </select>
                                            </div>
                                        </div>
                                         <?php } ?>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Status : </label>
                                                <div class="col-sm-10">
                                                  <select name="status"  id="status" class="form-control" required>
                                                    <option value="Active" <?php echo $record->status == 'Active' ? 'selected':'';?>>Active</option>
                                                    <option value="Inactive" <?php echo $record->status == 'Inactive' ? 'selected':'';?>>Inactive</option>
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
 $(document).ready(function(){
     //$('#url_wrapper').hide();
     //$('#on_wrapper').hide();
     //$('#reference_id_wrapper').hide();
     
     $('#type').change(function(){
         var type = $(this).val();
         if(type){
            if(type == 'Webview'){
              $('#url_wrapper').show();
            }else{
                $('#on_wrapper').show();
            }
         }else{
            $('#url_wrapper').hide();
            $('#on_wrapper').hide();
         }
     });
     
     $('#on').change(function(){
         var on = $(this).val();
         if (on){
            if (on === 'Category')
            {
                $.ajax({
                    type:'get',
                    url:'<?php echo base_url('admin/app_banner/get_categories');?>',
                    success:function(data){
                        $('#reference_id').html(data);
                    },
                    error:function(){
                        alert('Error Handling Here');
                    }
                });
            }
            if (on === 'Product')
            {
                $.ajax({
                    type:'get',
                    url:'<?php echo base_url('admin/app_banner/get_products');?>',
                    success:function(data){
                        $('#reference_id').html(data);
                    },
                    error:function(){
                        alert('Error Handling Here');
                    }
                });
            }
            $('#reference_id_wrapper').show();
         }else{
             $('#reference_id_wrapper').hide();
         }
     });
     
     $('#type').trigger('change');
    // $('#on').trigger('change');
 });
</script>
