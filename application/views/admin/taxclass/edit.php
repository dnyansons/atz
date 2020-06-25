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
                                    <h4>Edit Tax Class</h4>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="page-header-breadcrumb">
                                <ul class="breadcrumb-title">
                                    <li class="breadcrumb-item">
                                        <a href="<?php echo site_url();?>admin/dashboard"> <i class="feather icon-home"></i> </a>
                                    </li>
                                    <li class="breadcrumb-item"><a href="<?php echo site_url();?>admin/taxclass">Tax Class</a></li>
                                    <li class="breadcrumb-item"><a href="#!">Edit Tax Class</a></li>
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
                                    <h4 class="sub-title">Tax Class</h4>
                                    <form method="post" enctype="multipart/form-data">


                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Category</label>
                                            <div class="col-sm-10">
                                                <select name="categories_id" class="form-control">
                                                    <option value="">Select Category</option>
                                                    <?php foreach($categories_list as $category){ 
                                                        if(count($category->sub) > 0){
                                                        echo "<optgroup label='".$category->categories_name."'>";    
                                                        foreach($category->sub as $cat){
                                                            
                                                        if($cat->category_id==$tax_class_data->category_id)
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
                                            <label class="col-sm-2 col-form-label">Tax For</label>
                                            <div class="col-sm-10">
                                                <select name="tax_for" class="form-control">
                                                    <option value="Products" <?php echo $tax_class_data->tax_for=="Products" ? "selected=selected" : ""  ?>>Products</option>
                                                    <option value="Packages" <?php echo $tax_class_data->tax_for=="Packages" ? "selected=selected" : ""  ?>>Packages</option>
                                                </select>
                                            </div>

                                        </div>


                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Country</label>
                                            <div class="col-sm-10">
                                                <select name="country_id" class="form-control">

                                                    <option value="">-- Select Country --</option>

                                                  <?php foreach ($countries_list as $country)
                                                  {
                                                      if($tax_class_data->country_id==$country->id)
                                                      {
                                                          echo "<option value='".$country->id."' selected='selected'>".$country->nicename."</option>";
                                                      }

                                                      else
                                                      {
                                                          echo "<option value='".$country->id."'>".$country->nicename."</option>";
                                                      }
                                                      
                                                  } 
                                                  ?>
                                                  
                                                </select>
                                            </div>
                                        </div>


                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Tax Class Title</label>
                                            <div class="col-sm-10">
                                                <input type="text" name="tax_class_title" id="tax_class_title" class="form-control" placeholder="Tax Class Name" value="<?= $tax_class_data->tax_class_title; ?>">
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Tax Class Rate</label>
                                            <div class="col-sm-10">
                                                <input type="text" name="tax_class_rate" id="tax_class_rate" class="form-control" placeholder="Tax Class Rate" value="<?= $tax_class_data->tax_class_rate; ?>">
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Tax Class Type</label>
                                            <div class="col-sm-10">
                                                
                                                <select name="tax_class_type" class="form-control">
                                                  <option value="Fixed" <?php echo $tax_class_data->tax_class_type=="Fixed" ? "selected=selected" : "" ?>>Fixed</option>
                                                  <option value="Percentage" <?php echo $tax_class_data->tax_class_type=="Percentage" ? "selected=selected" : "" ?>>Percentage</option>
                                                </select>

                                            </div>
                                        </div>


                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Tax Class Description</label>
                                            <div class="col-sm-10">
                                                <textarea name="tax_class_description" class="form-control ckeditor"><?php echo $tax_class_data->tax_class_description; ?></textarea>
                                            </div>
                                        </div>


                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Status</label>
                                            <div class="col-sm-10">
                                                <select name="status" class="form-control">
                                                  <option value="Active" <?php echo $tax_class_data->status=="Active" ? "selected=selected" : "" ?>>Active</option>
                                                  <option value="Inactive" <?php echo $tax_class_data->status=="Inactive" ? "selected=selected" : "" ?>>Inactive</option>
                                                </select>
                                            </div>
                                        </div>
                                        
                                        

                                        <button type="submit" name="submit" id="submit" class="btn btn-primary" id="primary-popover-content">Submit</button>
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