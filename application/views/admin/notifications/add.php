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
                                    <h4>Send Notification</h4>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="page-header-breadcrumb">
                                <ul class="breadcrumb-title">
                                    <li class="breadcrumb-item">
                                        <a href="<?php echo base_url('admin/dashboard');?>"> <i class="feather icon-home"></i> </a>
                                    </li>
                                    <li class="breadcrumb-item"><a href="<?php echo base_url('admin/notifications');?>">Notifications</a></li>
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
                                    <h4 class="sub-title">Notification</h4>
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
                                            <label class="col-sm-3 col-form-label">Notification Title :</label>
                                            <div class="col-sm-9">
                                                <input type="text" name="title" id="title" class="form-control"  value="<?php echo set_value('title');?>" minlength="2" maxlength="50">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">Notification Message :</label>
                                            <div class="col-sm-9">
                                                <textarea name="msg" class="form-control" rows="5"><?php echo set_value('msg');?></textarea>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">Country : </label>
                                            <div class="col-sm-9">
                                                <select name="country" class="form-control" required="true">
                                                    <option value="">Select</option>
                                                    <?php if (!empty($countries)) { foreach ($countries as $country){?>
                                                      <option value="<?php echo $country['id'];?>"><?php echo $country['name'];?></option>
                                                    <?php }} ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">Notification Type : </label>
                                            <div class="col-sm-9">
                                                <select name="notification_type" id="notification_type" class="form-control" required="true">
                                                    <option value="">Select</option>
                                                    <option value="General">General</option>
                                                    <option value="New Offers">New Offer</option>
                                                    <option value="New Products">New Products</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div id="product_wrapper">
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label">Products : </label>
                                                <div class="col-sm-9">
                                                    <select name="products[]" id="products" class="form-control js-example-tokenizer" multiple="true"></select>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label">Category : </label>
                                                <div class="col-sm-9">
                                                    <input type="text" name="category" id="category" class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">Notification Send Date Time : </label>
                                            <div class="col-sm-9">
                                                <input type="datetime-local" name="send_date_time" class="form-control">
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
<script>
 $(document).ready(function(){
     $('#url_wrapper').hide();
     $('#on_wrapper').hide();
     $('#reference_id_wrapper').hide();
     $('#product_wrapper').hide();
     
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
     
     $('#notification_type').change(function(){
         var notification_type = $(this).val();
         if (notification_type && notification_type != 'General'){
            if (notification_type === 'New Offers')
            {
                $.ajax({
                    type:'get',
                    url:'<?php echo base_url('admin/notifications/get_new_product_offer');?>',
                    success:function(data){
                        console.log(data);
                        $('#products').html(data);
                        $('#product_wrapper').show();
                    },
                    error:function(){
                        alert('Error Handling Here');
                    }
                });
            }
            
            if (notification_type === 'New Products')
            {
                $.ajax({
                    type:'get',
                    url:'<?php echo base_url('admin/notifications/get_new_products');?>',
                    success:function(data){
                        console.log(data);
                        $('#products').html(data);
                        $('#product_wrapper').show();
                    },
                    error:function(){
                        alert('Error Handling Here');
                    }
                });
            }
            
         }else{
             $('#product_wrapper').hide();
         }
     });
     
     
     $('#products').change(function(){
        var product_id = $(this).val();
        console.log(product_id);
        if (product_id)
        {
            $.ajax({
                    type:'post',
                    url:'<?php echo base_url('admin/notifications/get_product_category');?>',
                    data: {'product_id':product_id},
                    success:function(data){
                        console.log(data);
                        $('#category').val(data);
                       // $('#product_wrapper').show();
                    },
                    error:function(){
                        alert('Error Handling Here');
                    }
                });
        }
        
     });
     
     
 });
</script>
<?php $this->load->view("admin/common/footer");?>
