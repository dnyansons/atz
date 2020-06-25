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
                                    <h4>Edit Shipping Vendor</h4>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="page-header-breadcrumb">
                                <ul class="breadcrumb-title">
                                    <li class="breadcrumb-item">
                                        <a href="<?php echo base_url('admin/dashboard');?>"> <i class="feather icon-home"></i> </a>
                                    </li>
                                    <li class="breadcrumb-item"><a href="<?php echo base_url('admin/shipping_vendor');?>">Shipping Vendor</a></li>
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
                                    <h4 class="sub-title">Shipping Vendor</h4>
                                       	
                                    <form method="post" enctype="multipart/form-data">
				        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">Vendor Name :</label>
                                            <div class="col-sm-9">
                                                <input type="text" name="vendor_name" value="<?php echo $vendor['vendor_name']; ?>" id="vendor_name" class="form-control" >
                                             <?php echo form_error("vendor_name"); ?>
                                            </div>
                                        </div>
                                       
<!--                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">Contract Start Date : </label>
                                            <div class="col-sm-9">
                                              <input type="text"  value="<?php //echo date('d-m-Y',strtotime($vendor['contract_start_date'])); ?>" name="contract_start_date" id="contract_start_date" class="form-control">
                                            <?php //echo form_error("contract_start_date"); ?>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">Contract End Date : </label>
                                            <div class="col-sm-9">
                                               <input type="text" value="<?php// echo date('d-m-Y',strtotime($vendor['contract_end_date'])); ?>" name="contract_end_date" id="contract_end_date" class="form-control">
                                            <?php //echo form_error("contract_end_date"); ?>
                                            </div>
                                        </div>-->
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">Notify Me ? : </label>
                                            <div class="col-sm-9 border-checkbox-section">
                                                <div class="border-checkbox-group border-checkbox-group-primary">
                                                    <input class="border-checkbox" <?php if($vendor['notify_me']=='Y'){ echo 'checked'; } ?> type="checkbox" name="notify_me" id="checkbox1">
                                                    <label class="border-checkbox-label" for="checkbox1">Email Before Contract End</label>
                                                </div>
                                            </div>
                                        </div>
<!--                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">Medium of transport : </label>
                                            <div class="col-sm-9">
											
                                                <select name="transport_medium[]" id="transport_medium" class="js-example-tokenizer form-control" required="true" multiple="true">
												
                                                   <option value="">Select</option>
												   <option value='Sea Freight'>Sea Freight</option>
												   <option value='Air Cargo'>Air Cargo</option>
												   <option value='Land Transportation'>Land Transportation</option>
                                                </select>
                                            </div>
                                        </div>-->
                                         
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">Is Default ? : </label>
                                            <div class="col-sm-9 border-checkbox-section">
                                                <div class="border-checkbox-group border-checkbox-group-primary">
                                                    <input class="border-checkbox" type="checkbox" name="is_default" <?php if($vendor['is_default']==1){ echo 'checked'; } ?> id="checkbox2">
                                                    <label class="border-checkbox-label" for="checkbox2">Set Default to Use</label>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">Shipment Type</label>
                                            <div class="col-sm-9">
                                                <select name="shipping_type" id="transport_medium" class="form-control" >
                                                    <option value="">Select</option>
                                                    <option value='Paid' <?php if($vendor['shipping_type']=='Paid') { echo 'selected'; } ?>>Paid</option>
                                                    <option value='Free' <?php if($vendor['shipping_type']=='Free') { echo 'selected'; } ?>>Free</option>

                                                </select>
                                                <?php echo form_error("shippment_type"); ?>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">On Amount</label>
                                            <div class="col-sm-9">
                                                <input type="number" class="form-control" name="free_amount" id="free_amount" value="<?php echo $vendor['free_amount']; ?>">
                                                <?php echo form_error("free_amount"); ?>
                                            </div>

                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">Status : </label>
                                                <div class="col-sm-9">
                                                  <select name="status"  id="status" class="form-control" required>
                                                    <option value="Active" <?php if($vendor['status']=='Active') { echo 'selected'; } ?>>Active</option>
                                                     <option value="Inactive" <?php if($vendor['status']=='Inactive') { echo 'selected'; } ?>>Inactive</option>
                                                  </select>
                                                </div>
                                        </div>
                                       <hr>
                                        <button type="submit" name="submit" value="submit" id="submit" class="btn btn-primary pull-right" id="primary-popover-content">Update</button>
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
    
    $('#avail_in_countries').change(function(){
         var id = $(this).val();
         //alert(on);
         if (id){
            $.ajax({
                url:"<?php echo base_url('admin/shipping_vendor/ajax_get_states');?>",
                type:'post',
                data:{'id':id},
                success:function(data){
                    $('#avail_in_states').html(data);
                },
                error:function(){
                    alert('Error Handling Here');
                }
            });
        }
    });
    
    $('#avail_in_states').change(function(){
         var id = $(this).val();
         //alert(on);
         if (id){
            $.ajax({
                url:"<?php echo base_url('admin/shipping_vendor/ajax_get_cities');?>",
                type:'post',
                data:{'id':id},
                success:function(data){
                    $('#avail_in_cities').html(data);
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
<script>
$(".js-example-tokenizer").select2({
        tags: true,
        tokenSeparators: [',', '<?php echo $vendor["transport_medium"]; ?>']
    });
	


	$(document).ready(function(){
            $("#contract_start_date").dateDropper({
                    format:"d-m-Y",
                    dropWidth: 200,
                    dropPrimaryColor: "#1abc9c",
                    dropBorder: "1px solid #1abc9c",
                    maxYear: "2020",
            })
            
            $("#contract_end_date").dateDropper({
                    format:"d-m-Y",
                    dropWidth: 200,
                    dropPrimaryColor: "#1abc9c",
                    dropBorder: "1px solid #1abc9c",
                    maxYear: "2050",
            })
            
            $(document).on('click','.add_more_item',function(){
                var row = $('#first_row').clone();
                row.find('input').val('');
                row.find('td:last').append(' <button class="btn btn-danger btn_cancel" type="button"><i class="fa fa-times" aria-hidden="true"></i></button>');
                $('#tbl_by_weight tr:last').after(row);
            });
            
             $(document).on('click','.add_more_item_by_distance',function(){
                var row = $('#first_row_by_distance').clone();
                row.find('input').val('');
                row.find('td:last').append(' <button class="btn btn-danger btn_cancel_by_distance" type="button"><i class="fa fa-times" aria-hidden="true"></i></button>');
                $('#tbl_by_distance tr:last').after(row);
            });
	
	    $(document).on('click','.btn_cancel',function(){
                var tr = $(this).closest('tr');
                var nextAll = tr.nextAll();
                nextAll.each(function(index){
                        var id = parseInt($(this).attr('id'));
                        id = id-1;
                        $(this).attr('id',id);
                        $(this).find('td:first').html(id);
                });
		$(this).closest('tr').remove();
            });
            
            $(document).on('click','.btn_cancel_by_distance',function(){
                var tr = $(this).closest('tr');
                var nextAll = tr.nextAll();
                nextAll.each(function(index){
                        var id = parseInt($(this).attr('id'));
                        id = id-1;
                        $(this).attr('id',id);
                        $(this).find('td:first').html(id);
                });
		$(this).closest('tr').remove();
            });
            
	})
</script>