<?php $this->load->view("user/common/header");?>
<div class="pcoded-content">
    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-header">
                    <div class="row align-items-end">
                        <div class="col-lg-8">
                            <div class="page-header-title">
                                <div class="d-inline">
                                    <h4>products</h4>
                                    <span></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="page-header-breadcrumb">
                                <ul class="breadcrumb-title">
                                    <li class="breadcrumb-item">
                                        <a href="<?php echo site_url();?>supplier/dashboard"> <i class="feather icon-home"></i> </a>
                                    </li>
                                    <li class="breadcrumb-item"><a href="#">Bulk Import</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="page-body">
                    <div class="row">
                        <div class="col-sm-6">

                            <div class="card">
                                <div class="card-header">
                                    <h5>Bulk Products Import</h5>
									<p>Click <a href="<?php echo base_url();?>uploads/images/products/sample.xlsx">here</a> to download sample file.</p>
                                </div>
                                <div class="card-block">
                                    <form action="<?php echo site_url();?>supplier/products/bulkimport" method="post" enctype="multipart/form-data">
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Simple Input</label>
                                            <div class="col-sm-10">
                                                <select name="category" class="form-control">
                                                    <option value="">Select Category</option>
                                                    <?php foreach($categories as $category){ 
                                                    if(count($category->sub) > 0){
                                                    echo "<optgroup label='".$category->categories_name."'>";    
                                                    foreach($category->sub as $cat){
                                                        echo "<option value='".$cat->categories_name."'>".$cat->categories_name."</option>";
                                                    }
                                                    echo "</optgroup>";
                                                    ?>
                                                        
                                                    <?php } else {
                                                    echo "<option value='".$category->categories_name."'>".$category->categories_name."</option>";
                                                    } ?>
                                                        
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                        
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Upload File</label>
                                            <div class="col-sm-10">
                                                <input type="file" name="rawsheet" class="form-control">
                                            </div>
                                        </div>
                                        
                                        <div class="form-group row">
                                            <div class="col-sm-10">
                                                <input type="submit" class="btn btn-success" value="submit"/>
                                            </div>
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
<?php $this->load->view("user/common/footer");?>
