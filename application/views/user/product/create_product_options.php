<?php $this->load->view("supplier/common/header");?>
<div class="pcoded-content">
    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-header">
                    <div class="row align-items-end">
                        <div class="col-lg-8">
                            <div class="page-header-title">
                                <div class="d-inline">
                                    <h4>Add Product Option</h4>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="page-header-breadcrumb">
                                <ul class="breadcrumb-title">
                                    <li class="breadcrumb-item">
                                        <a href="<?php echo base_url() ?>seller/dshaboard"> <i class="feather icon-home"></i> </a>
                                    </li>
                                    <li class="breadcrumb-item"><a href="#!">Product Option</a></li>
                                    <li class="breadcrumb-item"><a href="#!">Add Product Option</a></li>
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
								<form method="post" enctype="multipart/form-data">
                                <div class="card-block">
                                    <h4 class="sub-title">Product Option</h4>
                                    
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Product Option Name</label>
                                            <div class="col-sm-10">
                                                <input type="text" name="products_options_name" id="products_options_name" class="form-control" placeholder="Product Option Name">
                                            </div>
                                        </div>
                                        
                                </div>
								
								
								<div class="card-block">
                                    <h4 class="sub-title">Product Option Values</h4>
                                    
<table id="option-value" class="table table-striped table-bordered table-hover">
    <thead>
        <tr>
            <td class="text-left required">Option Value Name</td>
            <td class="text-center">Image</td>
            <td class="text-right">Sort Order</td>
            <td></td>
        </tr>
    </thead>
    <tbody>
        <tr id="option-value-row0">
            <td class="text-left">
                <input type="hidden" name="option_value[0][option_value_id]" value="">    
                <input type="text" name="option_value_name[]" placeholder="Option Value Name" class="form-control">
            </td>
            <td class="text-center"><img src="#" id="product_option_img0" width="60" height="60" alt="No Image" title="" data-placeholder="#">&nbsp;&nbsp;&nbsp;&nbsp;<input type="file" name="multipleimages[]" id="product_option_imgfile0" onchange="readURL(this, 0);"><input type="hidden" name="option_value_image[]" id="option_value_image0"></td>
            <td class="text-right"><input type="text" name="sort_order[]" value="" placeholder="Sort Order" class="form-control"></td>
            <td class="text-right"><button type="button" onclick="$('#option-value-row0').remove();" data-toggle="tooltip" title="Remove" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>
        </tr>
    </tbody>
    <tfoot>
        <tr>
            <td colspan="3"></td>
            <td class="text-right"><button type="button" onclick="addOptionValue();" data-toggle="tooltip" title="" class="btn btn-primary" data-original-title="Add Option Value"><i class="fa fa-plus-circle"></i></button></td>
        </tr>
    </tfoot>
</table>
                                        
                                        <button type="submit" name="submit" id="submit" class="btn btn-primary" id="primary-popover-content">Submit</button>
                                    
                                </div>
								
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



	





<script>
var option_value_row =1;
 function addOptionValue() {
	 
	html  = '<tr id="option-value-row' + option_value_row + '">';
    html += '  <td class="text-left"><input type="hidden" name="option_value[' + option_value_row + '][option_value_id]" value=""  />';
	
	html += '    <div class="input-group">';
	html += '    <input type="text" name="option_value_name[]" value="" placeholder="Option Value Name" class="form-control" />';
    html += '    </div>';
	html += '  </td>';
    html += '  <td class="text-center"><img src="#" id="product_option_img'+option_value_row+'" width="60" height="60" alt="No Image" title="" data-placeholder="#">&nbsp;&nbsp;&nbsp;&nbsp;<input type="file" name="multipleimages[]" id="product_option_imgfile'+option_value_row+'" onchange="readURL(this, '+option_value_row+');"><input type="hidden" name="option_value_image[]" id="option_value_image'+option_value_row+'" /></td>';
	html += '  <td class="text-right"><input type="text" name="sort_order[]" value="" class="form-control" placeholder="Sort Order" /></td>';
	html += '  <td class="text-right"><button type="button" onclick="$(\'#option-value-row' + option_value_row + '\').remove();" data-toggle="tooltip" title="" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>';
	html += '</tr>';

	$('#option-value tbody').append(html);

	option_value_row++;
}

</script>

<script>
function readURL(input, id) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#product_option_img'+id)
                    .attr('src', e.target.result)
                    .width(60)
                    .height(60);
            };

            reader.readAsDataURL(input.files[0]);
        }
    }
</script>

<?php $this->load->view("supplier/common/footer");?>

