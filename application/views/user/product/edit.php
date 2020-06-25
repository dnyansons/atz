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
                                    <h4>Edit Product</h4>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="page-header-breadcrumb">
                                <ul class="breadcrumb-title">
                                    <li class="breadcrumb-item">
                                        <a href="#"> <i class="feather icon-home"></i> </a>
                                    </li>
                                    <li class="breadcrumb-item"><a href="#!">Products</a></li>
                                    <li class="breadcrumb-item"><a href="#!">Edit Product</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
				
				
				
				<form method="post" enctype="multipart/form-data">
                <div class="page-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="card">
                                <div class="card-header">
									<span class="text-right"><button type="submit" name="submit_product" id="submit_product" class="btn btn-primary " id="primary-popover-content">Save</button>
									<button type="submit" name="submit_product" id="submit_product" class="btn btn-primary " id="primary-popover-content">Submit</button></span>
								</div>
                                <div class="card-block">
                                    <div class="row m-b-30">
                                        <div class="col-lg-12 col-xl-12 col-md-12 col-sm-12">
                                            <div class="sub-title text-right"></div>
                                            <ul class="nav nav-tabs md-tabs" role="tablist">
                                                <li class="nav-item ">
                                                    <a class="nav-link active" data-toggle="tab" href="#general" role="tab">General</a>
                                                    <div class="slide"></div>
                                                </li>
                                                <li class="nav-item ">
                                                    <a class="nav-link" data-toggle="tab" href="#inventory" role="tab">Inventory</a>
                                                    <div class="slide"></div>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link" data-toggle="tab" href="#options_and_varients" role="tab">Options & Varients</a>
                                                    <div class="slide"></div>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link" data-toggle="tab" href="#seo" role="tab">SEO</a>
                                                    <div class="slide"></div>
                                                </li>
												  <li class="nav-item">
                                                    <a class="nav-link" data-toggle="tab" href="#miscellaneous" role="tab">Miscellaneous</a>
                                                    <div class="slide"></div>
                                                </li>
												  <li class="nav-item">
                                                    <a class="nav-link" data-toggle="tab" href="#seller" role="tab">Seller</a>
                                                    <div class="slide"></div>
                                                </li>
												  
                                            </ul>
                                            <div class="tab-content card-block">
                                                <div class="tab-pane active" id="general" role="tabpanel">
                                                    <div class="page-body">
<div class="row">
<div class="col-sm-12">

<div class="card">
<div class="card-header">
<!-- <h5>Basic Form Inputs</h5>
<span>Lorem Ipsum is simply dummy text</span> -->
<div class="card-header-right">
<i class="icofont icofont-spinner-alt-5"></i>
</div>
</div>
<div class="card-block">
<!-- <h4 class="sub-title">Basic Inputs</h4> -->
 


<div class="form-group row">
<label class="col-sm-2 col-form-label">Product Name</label>
<div class="col-sm-10">
<input type="text" name="products_name" id="products_name" class="form-control" placeholder="Product Name" value="<?= $product_data->products_name; ?>">
</div>
</div>


<div class="form-group row">
<label class="col-sm-2 col-form-label">Product Model</label>
<div class="col-sm-10">
<input type="text" name="products_model" id="products_model" class="form-control" placeholder="Product Model" value="<?= $product_data->products_model; ?>">
</div>
</div>


<div class="form-group row">
<label class="col-sm-2 col-form-label">Product Quantity</label>
<div class="col-sm-10">
<input type="text" name="products_quantity" id="products_quantity" class="form-control" placeholder="Product Quantity" value="<?= $product_data->products_quantity; ?>">
</div>
</div>

<div class="form-group row">
<label class="col-sm-2 col-form-label">Select Category</label>
 <div class="col-sm-10">



<select name="categories_id" class="form-control">
                                                    <option value="">Select Category</option>
                                                    <?php foreach($categories_list as $category){ 
                                                    if(count($category->sub) > 0){
														
                                                    echo "<optgroup label='".$category->categories_name."'>";    
                                                    foreach($category->sub as $cat){
														
														if($product_data->categories_id==$cat->category_id)
														{
														   
														   echo "<option value='".$cat->category_id."' selected='selected'>".$cat->categories_name."</option>";
														}
														
														else
														{ 
														   echo "<option value='".$cat->category_id."'>".$cat->categories_name."</option>";
														}
                                                        
                                                    }
                                                    echo "</optgroup>";
                                                    ?>
                                                        
                                                    <?php } else {
                                                    echo "<option value='".$category->category_id."'>".$category->categories_name."</option>";
                                                    } ?>
                                                        
                                                    <?php } ?>
                                                </select>

</div>
</div>



<div class="form-group row">
<label class="col-sm-2 col-form-label">Product Description</label>
 <div class="col-sm-10">
  
  <textarea class="form-control ckeditor" name="products_description" rows="4"><?= $product_data->products_description; ?></textarea>
  
</div>
</div>


<div class="form-group row">
<label class="col-sm-2 col-form-label">Image</label>
<div class="col-sm-2">
<img src="<?php echo base_url(); ?>assets/images/product/<?php echo $product_data->products_image; ?>" name="products_image_show" width="50" height="100" class="form-control">
</div>
</div>



<div class="form-group row">
<label class="col-sm-2 col-form-label">Upload Product Image</label>
<div class="col-sm-10">
<input type="file" name="products_image" class="form-control">
</div>
</div>


<div class="form-group row">
<label class="col-sm-2 col-form-label">Product Price</label>
<div class="col-sm-10">
<input type="text" name="products_price" id="products_price" class="form-control" placeholder="Product Price" value="<?= $product_data->products_price; ?>">
</div>
</div>


<div class="form-group row">
<label class="col-sm-2 col-form-label">Minimum Product Quantity</label>
<div class="col-sm-10">
<input type="text" name="minimum_product_quantity" id="minimum_product_quantity" class="form-control" placeholder="Minimum Product Quantity" value="<?= $product_data->min_order_quantity; ?>">
</div>
</div>


<div class="form-group row">
<label class="col-sm-2 col-form-label">Maximum Product Quantity</label>
<div class="col-sm-10">
<input type="text" name="maximum_product_quantity" id="maximum_product_quantity" class="form-control" placeholder="Maximum Product Quantity" value="<?= $product_data->max_order_quantity; ?>">
</div>
</div>


<div class="form-group row">
<label class="col-sm-2 col-form-label">Product Weight</label>
<div class="col-sm-10">
<input type="text" name="products_weight" id="product_weight" class="form-control" placeholder="Product Weight" value="<?= $product_data->products_weight; ?>">
</div>
</div>


<div class="form-group row">
<label class="col-sm-2 col-form-label">Product Status</label>
<div class="col-sm-10">
<select name="products_status" class="form-control">

<option value="0" <?php echo $product_data->products_status=="0" ? "selected=selected" : "" ?> >Disable</option>
<option value="1" <?php echo $product_data->products_status=="1" ? "selected=selected" : "" ?>>Enable</option>

</select>
</div>
</div>




</div>
</div>


</div>
</div>
</div>
                                                </div>
                                                <div class="tab-pane" id="inventory" role="tabpanel">
                                                    <p class="m-0">2.Cras consequat in enim ut efficitur. Nulla posuere elit quis auctor interdum praesent sit amet nulla vel enim amet. Donec convallis tellus neque, et imperdiet felis amet.</p>
                                                </div>
                                                <div class="tab-pane" id="options_and_varients" role="tabpanel">
                                                    <p class="m-0">3. This is Photoshop's version of Lorem IpThis is Photoshop's version of Lorem Ipsum. Proin gravida nibh vel velit auctor aliquet. Aenean sollicitudin, lorem quis bibendum auctor, nisi elit consequat ipsum, nec sagittis sem nibh id elit. Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean mas Cum sociis natoque penatibus et magnis dis.....</p>
                                                </div>
                                                <div class="tab-pane" id="seo" role="tabpanel">
                                                    <p class="m-0">4.Cras consequat in enim ut efficitur. Nulla posuere elit quis auctor interdum praesent sit amet nulla vel enim amet. Donec convallis tellus neque, et imperdiet felis amet.</p>
                                                </div>
												
												<div class="tab-pane" id="miscellaneous" role="tabpanel">
                                                    <p class="m-0">4.Cras consequat in enim ut efficitur. Nulla posuere elit quis auctor interdum praesent sit amet nulla vel enim amet. Donec convallis tellus neque, et imperdiet felis amet.</p>
                                                </div>
												
												<div class="tab-pane" id="seller" role="tabpanel">
                                                    <p class="m-0">4.Cras consequat in enim ut efficitur. Nulla posuere elit quis auctor interdum praesent sit amet nulla vel enim amet. Donec convallis tellus neque, et imperdiet felis amet.</p>
                                                </div>
												
												
												
                                            </div>
											
											

                                        </div>
                                       
                                   
                            </div>
                        </div>
                    </div>
                </div>
				
            </div>
			
        </div>
		
		

		
		</form>
    </div>
</div>
<?php $this->load->view("supplier/common/footer");?>