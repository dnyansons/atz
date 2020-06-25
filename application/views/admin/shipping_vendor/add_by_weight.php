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
                                    <h4>Add Shipping Charges By Weight </h4>
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
                                    <form method="post" enctype="multipart/form-data">
                                        <input type="hidden" name="vendor_id" value="<?php echo $vendor_id; ?>">
                                        <div class="table-responsive">
                                            <table class="table" id="tbl_by_weight">
                                                <thead>
                                                    <tr>
                                                        <th>Zone From</th>
                                                        <th>Zone To</th>
                                                        <th>Weight</th>
                                                        <th>Price</th>
                                                        <th>Action</th>
                                                        <th></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr id="first_row">
                                                        <td>
															<select class="form-control" name="zone_from[]">
															<option value="">Select</option>
															<option value="EAST">EAST</option>
															<option value="WEST">WEST</option>
															<option value="NORTH">NORTH</option>
															<option value="SOUTH">SOUTH</option>
															<option value="CENTRAL">CENTRAL</option>
															<option value="NE">NE</option>
															<option value="NORTHEAST">NORTHEAST</option>
															</select>
														</td>
														 <td>
															<select class="form-control" name="zone_to[]">
															<option value="">Select</option>
															<option value="EAST">EAST</option>
															<option value="WEST">WEST</option>
															<option value="NORTH">NORTH</option>
															<option value="SOUTH">SOUTH</option>
															<option value="CENTRAL">CENTRAL</option>
															<option value="NE">NE</option>
															<option value="NORTHEAST">NORTHEAST</option>
															</select>
														</td>
														<td><input value="1" type="text" class="form-control" name="weight[]" placeholder="weight / Kg"></td>
                                                        <td><input type="text" class="form-control" name="price[]" placeholder="0"></td>
                                                        <td><button class="add_more_item btn btn-success" type="button">Add</button></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                            <hr>
                                        <button type="submit" name="submit" value="submit" id="submit" class="btn btn-primary pull-right" id="primary-popover-content">Submit</button>
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
	$(document).ready(function(){
            $("#contract_start_date").dateDropper({
                    format:"d/m/Y",
                    dropWidth: 200,
                    dropPrimaryColor: "#1abc9c",
                    dropBorder: "1px solid #1abc9c",
                    maxYear: "2020",
            })
            
            $("#contract_end_date").dateDropper({
                    format:"d/m/Y",
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