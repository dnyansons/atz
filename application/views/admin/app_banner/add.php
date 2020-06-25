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
                                    <h4>Add App Banner</h4>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="page-header-breadcrumb">
                                <ul class="breadcrumb-title">
                                    <li class="breadcrumb-item">
                                        <a href="<?php echo base_url('admin/dashboard');?>"> <i class="feather icon-home"></i> </a>
                                    </li>
                                    <li class="breadcrumb-item"><a href="<?php echo base_url('admin/app_banner');?>">App Banner</a></li>
                                    <li class="breadcrumb-item">Add</li>
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
                                    <h4 class="sub-title">Event</h4>
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
                                         <?php echo $this->session->flashdata("message");?>	
                                    <form method="post" enctype="multipart/form-data">
				        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Banner Image :</label>
                                            <div class="col-sm-10">
                                                <input type="file" name="image" id="image" class="form-control"  value="<?php echo set_value('image');?>">
                                            </div>
                                        </div>
                                         <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Type : </label>
                                            <div class="col-sm-10">
                                                <select name="type" id="type" class="form-control" required="true">
                                                    <option value="">Select</option>
                                                    <option value="App">App</option>
                                                    <option value="Webview">Webview</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row" id="url_wrapper">
                                            <label class="col-sm-2 col-form-label">URL : </label>
                                            <div class="col-sm-10">
                                                <input type="url" name="url" class="form-control" value="<?php echo set_value('url');?>">
                                            </div>
                                        </div>
                                        <div class="form-group row" id="on_placed">
                                            <label class="col-sm-2 col-form-label">Banner Placed : </label>
                                            <div class="col-sm-10">
                                                 <select name="banner_placed" class="form-control">
                                                    <option value="">Select</option>
                                                    <option value="top">Top</option>
                                                    <option value="bottom">Bottom</option>
                                                </select>
                                            </div>
                                        </div>
                                         <div class="form-group row" id="on_wrapper">
                                            <label class="col-sm-2 col-form-label">ON : </label>
                                            <div class="col-sm-10">
                                                 <select name="on" id="on" class="form-control">
                                                    <option value="">Select</option>
                                                    <option value="Product">Product</option>
                                                    <option value="Category">Category</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row" id="reference_id_wrapper">
                                            <label class="col-sm-2 col-form-label" id="reference_label">Product/Category : </label>
                                            <div class="col-sm-10">
                                                 <select name="reference_id" id="reference_id" class="form-control">
                                                    <option value="">Select</option>
                                                </select>
                                            </div>
                                        </div>
                                        
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Status : </label>
                                                <div class="col-sm-10">
                                                  <select name="status"  id="status" class="form-control" required>
                                                    <option value="Active">Active</option>
                                                     <option value="Inactive">Inactive</option>
                                                  </select>
                                                </div>
                                        </div>
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
<?php $this->load->view("admin/common/footer");?>
<script>
 $(document).ready(function(){
     $('#url_wrapper').hide();
     $('#on_wrapper').hide();
     $('#on_placed').hide();
     $('#reference_id_wrapper').hide();
     
     $('#type').change(function(){
         var type = $(this).val();
         if(type){
            if(type == 'Webview'){
              $('#url_wrapper').show();
            }else{
                $('#on_wrapper').show();
                $('#on_placed').show();
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
 });
</script>

