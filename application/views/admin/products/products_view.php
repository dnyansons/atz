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
                            <h4>Add Product</h4>
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
                            <li class="breadcrumb-item"><a href="#!">Add Product</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <form method="post" enctype="multipart/form-data" id="product_form">
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
                                                <a class="nav-link" data-toggle="tab" href="#images_videos" role="tab">Images & Videos</a>
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
                                                                        <label class="col-sm-2 col-form-label">Name</label>
                                                                        <div class="col-sm-10">
                                                                            <input type="text" name="products_name" id="products_name" class="form-control" placeholder="Name" value="<?php echo isset($products_data->products_name) ? $products_data->products_name : '' ?>">
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group row">
                                                                        <label class="col-sm-2 col-form-label">Alias</label>
                                                                        <div class="col-sm-10">
                                                                            <input type="text" name="products_alias" class="form-control" placeholder="Alias" value="<?php echo isset($products_data->products_alias) ? $products_data->products_alias : '' ?>">
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group row">
                                                                        <label class="col-sm-2 col-form-label">Model</label>
                                                                        <div class="col-sm-10">
                                                                            <input type="text" name="products_model" id="products_model" class="form-control" placeholder="Model" value="<?php echo isset($products_data->products_model) ? $products_data->products_model : '' ?>">
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group row">
                                                                        <label class="col-sm-2 col-form-label">Quantity</label>
                                                                        <div class="col-sm-10">
                                                                            <input type="text" name="products_quantity" id="products_quantity" class="form-control" placeholder="Quantity" value="<?php echo isset($products_data->products_quantity) ? $products_data->products_quantity : '' ?>">
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group row">
                                                                        <label class="col-sm-2 col-form-label">Description</label>
                                                                        <div class="col-sm-10">
                                                                            <textarea class="form-control ckeditor" name="products_description" rows="4"><?php echo isset($products_data->products_description) ? $products_data->products_description : '' ?></textarea>
                                                                        </div>
                                                                    </div>
                                                                    <!--
                                                                        <div class="form-group row">
                                                                            <label class="col-sm-2 col-form-label">Upload Product Image</label>
                                                                            <div class="col-sm-10">
                                                                                <input type="file" name="products_image" class="form-control">
                                                                            </div>
                                                                        </div>
                                                                        
                                                                        -->
                                                                    <div class="form-group row">
                                                                        <label class="col-sm-2 col-form-label">Price</label>
                                                                        <div class="col-sm-10">
                                                                            <input type="text" name="products_price" id="products_price" class="form-control" placeholder="Price" value="<?php echo isset($products_data->products_price) ? $products_data->products_price : '' ?>">
                                                                        </div>
                                                                    </div>
																	
																	<div class="form-group row">
                                                                        <label class="col-sm-2 col-form-label">Currency</label>
                                                                        <div class="col-sm-10">
                                                                            <select name="products_currency" class="form-control">
																			  <option value="">Select Currency</option>
																			  <?php foreach($currencies_list as $curr){
																				  
																				  if($curr->code==$products_data->products_currency)
																				  {
																				    echo "<option value='$curr->code' selected='selected'>$curr->code</option>";
																				  }
																				  
																				  else
																				  {
																					echo "<option value='$curr->code'>$curr->code</option>";
																				  }
																				  
																			   } ?>
																			</select>
                                                                        </div>
                                                                    </div>
																	
                                                                    <div class="form-group row">
                                                                        <label class="col-sm-2 col-form-label">Collection</label>
                                                                        <div class="col-sm-10">
                                                                            <select name="select_collection" class="form-control">
                                                                                <option value="opt1">Select Collection</option>
																				<?php foreach($collection_list as $collection){ 
																				
																				if($collection->id==$products_data->collection_id)
																				{
																				   echo "<option value='$collection->id' selected='selected'>$collection->name</option>";
																				}
																				
																				else
																				{
																				   echo "<option value='$collection->id' >$collection->name</option>";
																				}
																				
                                                                                
                                                                                } ?>
																				 
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group row">
                                                                        <label class="col-sm-2 col-form-label">Brand</label>
                                                                        <div class="col-sm-10">
                                                                            <select name="select_brand" class="form-control">
                                                                                <option value="opt1">Select Brand</option>
																				<?php foreach($brand_list as $brand){ 
																				
																				if($brand->brand_id==$products_data->brand_id)
																				{
																				   echo "<option value='$brand->brand_id' selected='selected'>$brand->brand_name</option>";
																				}
																				
																				else
																				{
																				   echo "<option value='$brand->brand_id' >$brand->brand_name</option>";
																				}
																				
                                                                                
																				} ?>
																				
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group row">
                                                                        <label class="col-sm-2 col-form-label">SKU (Stock Keeping Unit)</label>
                                                                        <div class="col-sm-10">
                                                                            <input type="text" name="sku" class="form-control" placeholder="Stock Keeping Unit" value="<?php echo isset($products_data->stock_keeping_unit) ? $products_data->stock_keeping_unit : ''; ?>">
                                                                        </div>
                                                                    </div>


                                                                    
                                                                     <div class="form-group row">
                                                                        <label class="col-sm-2 col-form-label">Units</label>
                                                                        <div class="col-sm-10">
                                                                            <select name="units_id" class="form-control">
                                                                                <option value="">Select Unit</option>
                                                                                <?php foreach($units_list as $unit){ 
                                                                                
                                                                                if($unit->units_id==$products_data->units_id)
                                                                                {
                                                                                   echo "<option value='$unit->units_id' selected='selected'>$unit->units_name</option>";
                                                                                }
                                                                                
                                                                                else
                                                                                {
                                                                                   echo "<option value='$unit->units_id' >$unit->units_name</option>";
                                                                                }
                                                                                
                                                                                
                                                                                } ?>
                                                                                
                                                                            </select>
                                                                        </div>
                                                                    </div>



                                                                    <div class="form-group row">
                                                                        <label class="col-sm-2 col-form-label">Category</label>
                                                                        <div class="col-sm-10">
                                                                            <select name="categories_id" class="form-control">
                                                                                <option value="">Select Category</option>
                                                                                <?php foreach($categories_list as $category){ 
                                                                                    if(count($category->sub) > 0){
                                                                                    echo "<optgroup label='".$category->categories_name."'>";    
                                                                                    foreach($category->sub as $cat){
																						
																					if($cat->category_id==$products_data->categories_id)
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
                                                                        <label class="col-sm-2 col-form-label">Weight</label>
                                                                        <div class="col-sm-10">
                                                                            <input type="text" name="weight" class="form-control" placeholder="Weight" value="<?php echo isset($products_data->products_weight) ? $products_data->products_weight : '' ?>">
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group row">
                                                                        <label class="col-sm-2 col-form-label">Tax</label>
                                                                        <div class="col-sm-10">
                                                                            <select name="select_tax" class="form-control">
                                                                                <option value="opt1">Select Tax Class</option>
																				<?php foreach($tax_class_list as $tax){ 
																				
																				if($tax->tax_class_id==$products_data->products_tax_class_id)
																				{
																				   echo "<option value='$tax->tax_class_id' selected='selected'>$tax->tax_class_title</option>";
																				}
																				
																				else
																				{
																				   echo "<option value='$tax->tax_class_id'>$tax->tax_class_title</option>";
																				}
																				
                                                                                
																				
																				 } ?>
																				
                                                                               
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group row">
                                                                        <label class="col-sm-2 col-form-label">Minimum Order Quantity</label>
                                                                        <div class="col-sm-10">
                                                                            <input type="text" name="min_order_quantity" id="min_order_quantity" class="form-control" placeholder="Minimum Order Quantity" value="<?php echo isset($products_data->min_order_quantity) ? $products_data->min_order_quantity : '' ?>">
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group row">
                                                                        <label class="col-sm-2 col-form-label">Maximum Order Quantity</label>
                                                                        <div class="col-sm-10">
                                                                            <input type="text" name="max_order_quantity" id="max_order_quantity" class="form-control" placeholder="Maximum Order Quantity" value="<?php echo isset($products_data->max_order_quantity) ? $products_data->max_order_quantity : '' ?>">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="tab-pane" id="inventory" role="tabpanel">
                                                <div class="form-group row">
                                                    <label class="col-sm-3">Inventory Management</label>
                                                    <div class="col-sm-9">
                                                        <div class="form-radio">
                                                            <div class="radio radiofill radio-primary radio-inline">
                                                                <label>
                                                                <input type="radio" name="inventory_radio" value="No" <?php if($products_data->inventory_track=="No" || empty($products_data->inventory_track)){ echo "checked='checked'"; } else{ echo ""; } ?> data-bv-field="member">
                                                                <i class="helper"></i>Don't track my inventory
                                                                </label>
                                                            </div>
                                                            <div class="radio radiofill radio-primary radio-inline">
                                                                <label>
                                                                <input type="radio" name="inventory_radio" value="Yes" <?php if($products_data->inventory_track=="Yes"){ echo "checked='checked'"; } else{ echo ""; } ?> data-bv-field="member">
                                                                <i class="helper"></i>Track my inventory
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <span class="messages"></span>
                                                    </div>
                                                </div>
                                                <div id="track_inventory_div" style="<?= $products_data->inventory_track=='Yes' ? '' : 'display: none;'; ?>">
                                                    <div class="form-group row">
                                                        <label class="col-sm-3">Inventory Allow Out Of Stock</label>
                                                        <div class="col-sm-9">
                                                            <div class="checkbox-fade fade-in-primary">
                                                                <label>
                                                                    <input type="checkbox" id="inventory_allow_check" name="inventory_allow_check" value="Yes" <?= $products_data->inventory_allow_out_of_stock=="Yes" ? "checked='checked'" : ""; ?>>
                                                                    <span class="cr">
                                                                    <i class="cr-icon icofont icofont-ui-check txt-primary"></i>
                                                                    </span>
                                                                    <!-- <span>HTML</span> -->
                                                                </label>
                                                            </div>
                                                            <!-- <div class="checkbox-fade fade-in-primary">
                                                                <label>
                                                                <input type="checkbox" id="checkbox2" name="Language" value="CSS">
                                                                <span class="cr">
                                                                <i class="cr-icon icofont icofont-ui-check txt-primary"></i>
                                                                </span>
                                                                <span>CSS</span>
                                                                </label>
                                                                </div> -->
                                                            <span class="messages"></span>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label class="col-sm-2 col-form-label">Inventory Quantity</label>
                                                        <div class="col-sm-10">
                                                            <input type="text" name="inventory_quantity" class="form-control" value="<?php echo isset($products_data->inventory_quantity) ? $products_data->inventory_quantity : '' ?>">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label class="col-sm-2 col-form-label">Inventory Low Stock Quantity</label>
                                                        <div class="col-sm-10">
                                                            <input type="text" name="inventory_low_stock_quantity" class="form-control" value="<?php echo isset($products_data->inventory_low_stock_quantity) ? $products_data->inventory_low_stock_quantity : '' ?>">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="tab-pane" id="options_and_varients" role="tabpanel">
											
											
											    <!--
                                                <div class="form-group row">
                                                    <label class="col-sm-2 col-form-label">Product Option Name</label>
                                                    <div class="col-sm-10">
                                                        <input type="text" name="products_options_name" id="products_options_name" class="form-control" placeholder="Product Option Name" value="<?= $product_options_data[0]['products_options_name']; ?>">
                                                    </div>
                                                </div>
												-->
												
												
												<!--
												
												
												<div class="form-group">
                                                <label for="tags">&nbsp;</label>
                                                <div class="form-control tags" id="tags">
      	                                        <input type="text" class="labelinput">
                                                <input type="hidden" value="" name="result">
                                                </div>
                                                </div>
												
												
												-->
                                                
												
												

												
												
												<div class="new_option_div">
												
                                                <table id="option-value" class="table table-striped table-bordered table-hover">
                                                    <thead>
                                                        
                                                            <tr>
                                                            <td class="text-left">Option</td>
                                                            <td class="text-left">Option Value</td>
                                                            </tr>
                                                        
                                                    </thead>
                                                    <tbody>
                                                    
                                                    
                                                        <tr>
                                                        
                                                            <td class="text-left">
                                                                <input type="hidden" name="option_name[]" placeholder="Option Name" class="form-control" value="Color">
                                                                Color:
                                                            </td>
                                                            
                                                            <td>
                                                            
                                                             <input type="text" name="option_value[]" placeholder="Option Value" class="form-control" value="<?php if($product_options_data[0]['option_name']=='Color'){ echo $product_options_data[0]['option_value']; } ?>">
                                                            
                                                            </td>
                                                        
                                                        </tr>


                                                         <tr>
                                                        
                                                            <td class="text-left">
                                                                <input type="hidden" name="option_name[]" placeholder="Option Name" class="form-control" value="Size">
                                                                Size:
                                                            </td>
                                                            
                                                            <td>
                                                            
                                                             <input type="text" name="option_value[]" placeholder="Option Value" class="form-control" value="<?php if($product_options_data[1]['option_name']=='Size'){ echo $product_options_data[1]['option_value']; } ?>">
                                                            
                                                            </td>
                                                        
                                                        </tr>

                                                    
                                                        
                                                    </tbody>

                                                </table>
												
												</div>
												
                                            </div>
                                            <div class="tab-pane" id="seo" role="tabpanel">
                                                <div class="form-group row">
                                                    <label class="col-sm-2 col-form-label">Title</label>
                                                    <div class="col-sm-10">
                                                        <input type="text" name="seo_title" class="form-control" value="<?php echo isset($products_data->seo_title) ? $products_data->seo_title : '' ?>">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-sm-2 col-form-label">Description</label>
                                                    <div class="col-sm-10">
                                                        <input type="text" name="seo_description" class="form-control" value="<?php echo isset($products_data->seo_description) ? $products_data->seo_description : '' ?>">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-sm-2 col-form-label">Keywords</label>
                                                    <div class="col-sm-10">
                                                        <input type="text" name="seo_keywords" class="form-control" value="<?php echo isset($products_data->seo_keywords) ? $products_data->seo_keywords : '' ?>">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-sm-2 col-form-label">URL</label>
                                                    <div class="col-sm-10">
                                                        <input type="text" name="seo_url" class="form-control" value="<?php echo isset($products_data->seo_url) ? $products_data->seo_url : '' ?>">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="tab-pane" id="miscellaneous" role="tabpanel">
                                                <div class="form-group row">
                                                    <label class="col-sm-2 col-form-label">Barcode</label>
                                                    <div class="col-sm-10">
                                                        <input type="text" name="barcode" class="form-control" value="<?php echo isset($products_data->barcode) ? $products_data->barcode : '' ?>">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-sm-2 col-form-label">ISBN</label>
                                                    <div class="col-sm-10">
                                                        <input type="text" name="isbn" class="form-control" value="<?php echo isset($products_data->isbn) ? $products_data->isbn : '' ?>">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-sm-2 col-form-label">HSN</label>
                                                    <div class="col-sm-10">
                                                        <input type="text" name="hsn" class="form-control" value="<?php echo isset($products_data->hsn) ? $products_data->hsn : '' ?>">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-sm-2 col-form-label">SAC</label>
                                                    <div class="col-sm-10">
                                                        <input type="text" name="sac" class="form-control" value="<?php echo isset($products_data->sac) ? $products_data->sac : '' ?>">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-sm-2 col-form-label">UPC</label>
                                                    <div class="col-sm-10">
                                                        <input type="text" name="upc" class="form-control" value="<?php echo isset($products_data->upc) ? $products_data->upc : '' ?>">
                                                    </div>
                                                </div>
												
												<div class="form-group row">
                                                    <label class="col-sm-2 col-form-label">Select Marketplace</label>
                                                    <div class="col-sm-10">
                                                        <select name="select_marketplace" class="form-control">
                                                   
                                                            <?php foreach($countries_list as $country_li){ 
															
															 if($country_li->id==$products_data->marketplace_country_id)
															 {
																echo "<option value='$country_li->id' selected='selected'>$country_li->nicename</option>";	
															 }
															 
															 else
															 {
																echo "<option value='$country_li->id'>$country_li->nicename</option>";	
															 }
															
                                                             	
														     } ?>
                                                        </select>
                                                    </div>
                                                </div>
												
												
												 <div class="form-group row">
                                                    <label class="col-sm-3">Customization Required</label>
                                                    <div class="col-sm-9">
                                                        <div class="form-radio">
                                                            <div class="radio radiofill radio-primary radio-inline">
                                                                <label>
                                                                <input type="radio" name="customization_required" value="Yes" data-bv-field="member" <?php if($products_data->customization_required=="Yes"){ echo "checked='checked'"; } else{ echo ""; } ?>>
                                                                <i class="helper"></i>Yes
                                                                </label>
                                                            </div>
                                                            <div class="radio radiofill radio-primary radio-inline">
                                                                <label>
                                                                <input type="radio" name="customization_required" value="No" data-bv-field="member" <?php if($products_data->customization_required=="No" || empty($products_data->customization_required)){ echo "checked='checked'"; } else{ echo ""; } ?>>
                                                                <i class="helper"></i>No
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <span class="messages"></span>
                                                    </div>
                                                </div>
												
												<div style="<?= $products_data->customization_required=='Yes' ? '' : 'display: none;'; ?>" id="customization_div">
												<div class="form-group row">
                                                    <label class="col-sm-3 col-form-label">&nbsp;</label>
                                                   
													<label class="col-sm-5 col-form-label">Customized Logo Minimum order quantity</label>
													<div class="col-sm-2">
                                                        <input type="text" name="customized_logo_minimum_order_qty" class="form-control" value="<?= $products_data->customized_logo_minimum_order_qty; ?>">
                                                    </div>
                                                </div>
												
												
												<div class="form-group row">
                                                    <label class="col-sm-3 col-form-label">&nbsp;</label>
                                   
													<label class="col-sm-5 col-form-label">Customized packaging Minimum order quantity</label>
													<div class="col-sm-2">
                                                        <input type="text" name="customized_packaging_minimum_order_qty" class="form-control" value="<?= $products_data->customized_packaging_minimum_order_qty; ?>">
                                                    </div>
                                                </div>
												
												
												<div class="form-group row">
                                                    <label class="col-sm-3 col-form-label">&nbsp;</label>
                                                   
													<label class="col-sm-5 col-form-label">Graphic customization Minimum order quantity</label>
													<div class="col-sm-2">
                                                        <input type="text" name="graphic_customization_minimum_order_qty" class="form-control" value="<?= $products_data->graphic_customization_minimum_order_qty; ?>">
                                                    </div>
                                                </div>
												
												</div>
												
												
                                                <table id="attribute" class="table table-striped table-bordered table-hover">
                                                    <thead>
                                                        <tr>
                                                            <td class="text-left">Attribute</td>
                                                            <td class="text-left">Attribute Value</td>
                                                            <td></td>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php if(isset($product_attributes_data)){ $att_count=0; foreach($product_attributes_data as $at){  ?>
                                                        <tr id="attribute-row<?php echo $att_count; ?>">
                                                            <td class="text-left" style="width: 40%;">
                                                                <input type="text" name="product_attribute_name[]" placeholder="Attribute" class="form-control" value="<?= $at->product_attribute_name; ?>" autocomplete="off">
                                                                <ul class="dropdown-menu"></ul>
                                                            </td>
                                                            <td class="text-left">
                                                                <div class="input-group">
                                                                    <textarea name="product_attribute_value[]" rows="5" placeholder="Text" class="form-control"><?= $at->product_attribute_value; ?></textarea>
                                                                </div>
                                                            </td>
                                                            <td class="text-right"><button type="button" onclick="$('#attribute-row<?php echo $att_count; ?>').remove();" data-toggle="tooltip" title="" class="btn btn-danger" data-original-title="Remove"><i class="fa fa-minus-circle"></i></button></td>
                                                        </tr>
                                                        <?php $att_count++; } } ?>
                                                    </tbody>
                                                    <tfoot>
                                                        <tr>
                                                            <td colspan="2"></td>
                                                            <td class="text-right"><button type="button" onclick="addAttribute();" data-toggle="tooltip" title="" class="btn btn-primary" data-original-title="Add Attribute"><i class="fa fa-plus-circle"></i></button></td>
                                                        </tr>
                                                    </tfoot>
                                                </table>
                                                <div class="form-group row">
                                                    <label class="col-sm-3">Shipping Required</label>
                                                    <div class="col-sm-9">
                                                        <div class="form-radio">
                                                            <div class="radio radiofill radio-primary radio-inline">
                                                                <label>
                                                                <input type="radio" name="shipping_required" value="Yes" checked="checked" data-bv-field="member">
                                                                <i class="helper"></i>Yes
                                                                </label>
                                                            </div>
                                                            <div class="radio radiofill radio-primary radio-inline">
                                                                <label>
                                                                <input type="radio" name="shipping_required" value="No" data-bv-field="member">
                                                                <i class="helper"></i>No
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <span class="messages"></span>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-sm-2 col-form-label">Sort Order</label>
                                                    <div class="col-sm-10">
                                                        <input type="text" name="product_sort_order" class="form-control" value="<?php echo isset($products_data->product_sort_order) ? $products_data->product_sort_order : '' ?>">
                                                    </div>
                                                </div>
												
												
                                                <div class="form-group row">
                                                    <label class="col-sm-2 col-form-label">Product Status</label>
                                                    <div class="col-sm-10">
                                                        <select name="products_status" class="form-control">
                                                            <option value="1" <?= $products_data->products_status=="1" ? "selected='selected'" : ""; ?>>Enable</option>
                                                            <option value="0" <?= $products_data->products_status=="0" ? "selected='selected'" : ""; ?> >Disable</option>
                                                        </select>
                                                    </div>
                                                </div>
												
												
												<?php 
												
												if(isset($products_data->products_available_date))
												{
												   $products_available_date = str_replace('-', '/', $products_data->products_available_date);
                                                   $products_available_date= date('d/m/Y', strtotime($products_available_date));
												}
												
												
												?>
												
												
												<div class="form-group row">
                                                    <label class="col-sm-2 col-form-label">Product Available Date</label>
                                                    <div class="col-sm-10">
                                                        
														<div class="input-group date">
                                                            <input type="text" name="products_available_date" id="products_available_date" class="form-control date" placeholder="Select Date of Product Available" data-format="dd/MM/yyyy" value="<?= $products_available_date; ?>" readonly="readonly">
                                                            <div class="input-group-addon">
                                                            <span class="fa fa-calendar"></span>
                                                            </div>
                                                        </div>
														
                                                    </div>
                                                </div>
												
												
												<div class="form-group row">
                                                <label class="col-sm-2 col-form-label">Discount</label>
                                                <div class="col-sm-10">
												<div class="table-responsive">
												  <table id="discount" class="table table-striped table-bordered table-hover">
													<thead>
													  <tr>
														<td class="text-center">Minimum Product Quantity</td>
														<td class="text-center">Discount Type</td>
														<td class="text-center">Discount Value</td>
														<td class="text-center">Date Start</td>
														<td class="text-center">Date End</td>
													  </tr>
													</thead>

													<tbody>
													 <tr>
														<td class="text-center"><input type="text" name="discount_min_product_quantity" class="form-control" value="<?= $product_discount_data->discount_min_product_quantity; ?>"></td>
														<td class="text-center">
														  <select name="discount_type" class="form-control">
														    <option value="Flat" <?= $product_discount_data->discount_type=="Flat" ? "selected=selected":"" ?>>Flat</option>
															<option value="Percentage" <?= $product_discount_data->discount_type=="Percentage" ? "selected=selected":"" ?>>Percentage</option>
														  </select>
														</td>
														
														
														<td class="text-center"><input type="text" name="discount_value" class="form-control" value="<?= $product_discount_data->discount_value; ?>"></td>
														
														<?php 
												
														if(isset($product_discount_data->product_discount_start_date))
														{
														   $product_discount_start_date = str_replace('-', '/', $product_discount_data->product_discount_start_date);
														   $product_discount_start_date= date('d/m/Y', strtotime($product_discount_start_date));
														}
														
														
														?>
														
														<td class="text-center">
														  <div class="input-group date">
															<input type="text" name="product_discount_start_date" value="<?= $product_discount_start_date; ?>" placeholder="Date Start" class="form-control date" readonly="readonly">
															<span class="input-group-btn">
															<button class="btn btn-primary" type="button"><i class="fa fa-calendar"></i></button>
															</span>
														  </div>
														</td>
														
														
														<?php 
												
														if(isset($product_discount_data->product_discount_end_date))
														{
														   $product_discount_end_date = str_replace('-', '/', $product_discount_data->product_discount_end_date);
														   $product_discount_end_date= date('d/m/Y', strtotime($product_discount_end_date));
														}
														
														
														?>
														
														
														<td class="text-center">
														
														 <div class="input-group date">
															<input type="text" name="product_discount_end_date" value="<?= $product_discount_end_date; ?>" placeholder="Date End" class="form-control date" readonly="readonly">
															<span class="input-group-btn">
															<button class="btn btn-primary" type="button"><i class="fa fa-calendar"></i></button>
															</span>
														 </div>
														
														</td>
													  </tr>                                                         
													</tbody>
												  </table>
												</div>
												</div>
												</div>
												
												
												
                                            </div>
                                            <div class="tab-pane" id="images_videos" role="tabpanel">
											
											
											 <table id="video" class="table table-striped table-bordered table-hover">
                                                    <thead>
                                                        <tr>
                                                            <td class="text-left">Video</td>
                                                            <td class="text-left">Youtube Video URL</td>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
													
													  <tr>
													  
													    <td>
														  <iframe width="200" height="100" src="" id="youtube_video" frameborder="0" allowFullScreen='allowFullScreen'>
                                                          </iframe>
														</td>
														
														
														<td>
														  <input type="text" class="form-control" name="video_url" id="video_url" value="<?= $product_videos_data->video_url; ?>" onkeyup="getVideo(this.value);">
														  <input type="hidden" class="form-control" name="hidden_video_url" >
														</td>
														
													  </tr>
													  
													</tbody>
											 </table>
											
											
											
											
											
                                                <table id="images" class="table table-striped table-bordered table-hover">
                                                    <thead>
                                                        <tr>
                                                            <td class="text-left">Images</td>
                                                            <td class="text-left">Choose Image</td>
                                                            <td class="text-right">Sort Order</td>
                                                            <td></td>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php if(isset($product_images_data)){ $img_count=0; foreach($product_images_data as $imgd){  ?>
														
														<?php $img_array=explode('.', $imgd->products_image); 
														
														      $thumbnail=$img_array[0].'_thumb.'.$img_array[1];
														
														?>
														
                                                        <tr id="image-row<?php echo $img_count; ?>">
                                                            <td class="text-left">
                                                                <img src="<?php echo base_url().'uploads/images/products/'.$thumbnail; ?>" id="product_image_show<?php echo $img_count; ?>" alt="No Image" title="" width="60" height="60">
                                                            </td>
                                                            <td class="text-left">
                                                                <input type="file" name="product_image_file[]" id="imgfile<?php echo $img_count; ?>" onchange="readImageURL(this, <?php echo $img_count; ?>);" onclick="resetImage(this, <?php echo $img_count; ?>)" value="<?php echo $imgd->products_image; ?>" class="file">
																<input type="hidden" name="product_hidden_image_file[]" id="hidden_img<?php echo $img_count; ?>" value="<?php echo $imgd->products_image; ?>">
																<span id="uploadmsg<?php echo $img_count; ?>"></span>
																
                                                            </td>
                                                            <td class="text-right"><input type="text" name="products_image_sort_order[]" placeholder="Sort Order" class="form-control" value="<?php echo $imgd->products_image_sort_order; ?>"></td>
                                                            <td class="text-right"><button type="button" onclick="$('#image-row<?php echo $img_count; ?>').remove();" data-toggle="tooltip" title="" class="btn btn-danger" data-original-title="Remove"><i class="fa fa-minus-circle"></i></button></td>
                                                        </tr>
                                                        <?php $img_count++; } } ?>
                                                    </tbody>
                                                    <tfoot>
                                                        <tr>
                                                            <td colspan="3"></td>
                                                            <td class="text-right"><button type="button" onclick="addImage();" data-toggle="tooltip" title="" class="btn btn-primary" data-original-title="Add Image"><i class="fa fa-plus-circle"></i></button></td>
                                                        </tr>
                                                    </tfoot>
                                                </table>
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

<script>
var option_value_row =parseInt(<?php echo count($product_options_data) ?>);

 function addOptionValue() {
	 
	 //$('.tags').tagInput({labelClass:"badge badge-success"});
	 
	html  = '<tr id="option-value-row' + option_value_row + '">';
    html += '<td class="text-left">';
	
	html += '<div class="input-group">';
	html += '<input type="text" name="option_name[]" value="" placeholder="Option Name" class="form-control" />';
    html += '</div>';
	html += '</td>';
    html += '<td><input type="text" name="option_value[]" placeholder="Option Value" class="form-control"></td>';
	html += '<td class="text-right"><button type="button" onclick="$(\'#option-value-row' + option_value_row + '\').remove();" data-toggle="tooltip" title="" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>';
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

<script type="text/javascript">
    
	
	var attribute_row =parseInt(<?php echo count($product_attributes_data) ?>);
    
    function addAttribute() {
        html  = '<tr id="attribute-row' + attribute_row + '">';
        html += '  <td class="text-left" style="width: 20%;"><input type="text" name="product_attribute_name[]" value="" placeholder="Attribute" class="form-control" /></td>';
        html += '  <td class="text-left">';
            html += '<div class="input-group"><textarea name="product_attribute_value[]" rows="5" placeholder="Text" class="form-control"></textarea></div>';
            html += '  </td>';
        html += '  <td class="text-right"><button type="button" onclick="$(\'#attribute-row' + attribute_row + '\').remove();" data-toggle="tooltip" title="Remove" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>';
        html += '</tr>';
    
        $('#attribute tbody').append(html);
    
        attributeautocomplete(attribute_row);
    
        attribute_row++;
    }
    
</script> 

<script type="text/javascript">
    
  $('input[name=inventory_radio]').click(function(){

    if(this.value=="Yes")
    {
      $('#track_inventory_div').show();
    }

    else
    {
       $('#track_inventory_div').hide();
    }

  });

</script>

<script type="text/javascript">

  
  var image_row =parseInt(<?php echo count($product_images_data) ?>);
    
  function addImage() {
    html  = '<tr id="image-row' + image_row + '">';
    html += '  <td class="text-left"><img src="#" id="product_image_show'+image_row+'" alt="No Image" title="" /></td>';
    html += '  <td class="text-left"><input type="file" name="product_image_file[]" onchange="readImageURL(this, '+image_row+');" onclick="resetImage(this, '+image_row+')" class="file"><input type="hidden" name="product_hidden_image_file[]" id="hidden_img'+image_row+'" value=""><span id="uploadmsg'+image_row+'"></span></td>';
    html += '  <td class="text-right"><input type="text" name="products_image_sort_order[]" value="" placeholder="Sort Order" class="form-control" /></td>';
    html += '  <td class="text-right"><button type="button" onclick="$(\'#image-row' + image_row  + '\').remove();" data-toggle="tooltip" title="Remove" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>';
    html += '</tr>';

    $('#images tbody').append(html);

    image_row++;
}

</script>

<script type="text/javascript">
    
    function readImageURL(input, id) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#product_image_show'+id)
                    .attr('src', e.target.result)
                    .width(60)
                    .height(60);
					
					
            };

            reader.readAsDataURL(input.files[0]);
			
			//var imgfilename = $("#imgfile"+id).val().split('\\').pop();;
			
			//$("#hidden_img"+id).val('');
			
			
	var fd = new FormData();
    var files = $('.file')[id].files[0];
    fd.append('myfile',files);
    
    $.ajax({
             url:'<?php echo base_url();?>index.php/admin/products/ajax_upload_image',
             type:"post",
             data:fd, //this is formData
             dataType:"json",
             async:true,
             contentType: false,
             processData: false,
             success: function(data){
                  
                  if(data.status=="success")
                  {
                     //alert(data.file_name);
                     $("#hidden_img"+id).val(data.file_name);
                     $("#uploadmsg"+id).html('<span style="color:green;">File uploaded successfully.</span>');
                  }

                  else
                  {
                     //alert(data.error);
                     $("#uploadmsg"+id).html('<span style="color:red;">'+data.error+'</span>');
                  }
           }
    

     });
			
        }
		
		
		
		
    }

</script>


 <script>
  $(document).ready(function(){
	//$('#tags').tagInput({labelClass:"badge badge-success"});
	var url=$("#video_url").val();
	var new_url=url.split("v=").pop();
	new_url="https://www.youtube.com/embed/"+new_url+"?controls=1&loop=0";
	document.getElementById('youtube_video').src ="";
	document.getElementById('youtube_video').src = new_url;
	$("#hidden_video_url").val('');
	$("#hidden_video_url").val(new_url);
	
  });
  </script>
  
  <script>
    function getVideo(url)
	{
		var new_url=url.split("v=").pop();
		new_url="https://www.youtube.com/embed/"+new_url+"?controls=1&loop=0";
		document.getElementById('youtube_video').src ="";
		document.getElementById('youtube_video').src = new_url;
		$("#hidden_video_url").val('');
		$("#hidden_video_url").val(new_url);
	}
  </script>
  
  <script type="text/javascript">
	
	function resetImage(input, id)
	{
		$('#product_image_show'+id).attr('src', '#')      
        $('#product_image_show'+id).width(60)
        $('#product_image_show'+id).height(60);

		$("#hidden_img"+id).val('');
        $("#uploadmsg"+id).empty();
	}

</script>

<script type="text/javascript">
    
  $('input[name=customization_required]').click(function(){

    if(this.value=="Yes")
    {
      $('#customization_div').show();
    }

    else
    {
       $('#customization_div').hide();
    }

  });

</script>



<script>
 
 $(document).ready(function() {

   $('.date').datepicker({
     format: "dd/mm/yyyy",
	 autoclose: true,  
  });

});

</script>




<?php $this->load->view("admin/common/footer");?>