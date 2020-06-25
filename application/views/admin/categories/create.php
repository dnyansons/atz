<div class="pcoded-content">
    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-header">
                    <div class="row align-items-end">
                        <div class="col-lg-8">
                            <div class="page-header-title">
                                <div class="d-inline">
                                    <h4>Add Category</h4>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="page-header-breadcrumb">
                                <ul class="breadcrumb-title">
                                    <li class="breadcrumb-item">
                                        <a href="<?php echo site_url();?>admin/dashboard"> <i class="feather icon-home"></i> </a>
                                    </li>
                                    <li class="breadcrumb-item"><a href="<?php echo site_url();?>admin/categories">Categories</a></li>
                                    <li class="breadcrumb-item"><a href="#!">Add Category</a></li>
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
                                    <h4 class="sub-title">Category</h4>
                                    <?php echo $this->session->flashdata("message");?>
                                    <form method="post" enctype="multipart/form-data" action="<?php echo site_url();?>admin/categories/addCategory">
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Category Name</label>
                                            <div class="col-sm-10">
                                                <input type="text" name="category_name" id="category_name" class="form-control" value="<?php echo set_value("category_name");?>" placeholder="Category Name">
                                                <?php echo form_error("category_name");?>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Select Parent Category</label>
                                            <div class="col-sm-10">
                                                <select name="parent_category" class="form-control">
                                                    <option value="">-- Select Parent Category --</option>
                                                    <option value="0">Default</option>
                                                    <?php foreach ($categories_list as $cl) { ?>
                                                    <option value="<?php echo $cl->category_id; ?>"><?php echo ucfirst($cl->categories_name); ?></option>
                                                    <?php } ?>
                                                </select>
                                                <?php echo form_error("parent_category");?>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Select Sort Order</label>
                                            <div class="col-sm-10">
                                                <select name="sort_order" class="form-control">
                                                    <option value="">-- Select Sort Order --</option>
                                                    <?php $count=50; for($i=0;$i<=$count;$i++) { ?>
                                                    <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                                    <?php } ?>
                                                </select>
                                                <?php echo form_error("sort_order");?>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Upload Category Image</label>
                                            <div class="col-sm-10">
                                                <input type="file" name="category_image" class="form-control">
                                                
                                            </div>
                                        </div>
                                         <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Upload Banner Image</label>
                                            <div class="col-sm-10">
                                                <input type="file" name="banner_image" class="form-control">
                                                
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">SEO Title</label>
                                            <div class="col-sm-10">
                                                <input type="text" name="seo_title" id="seo_title" class="form-control" placeholder="SEO Title" value="<?php echo set_value("seo_title");?>">
                                                <?php echo form_error("seo_title");?>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">SEO Description</label>
                                            <div class="col-sm-10">
                                                <input type="text" name="seo_description" id="seo_description" class="form-control" placeholder="SEO Description" value="<?php echo set_value("seo_description");?>">
                                                <?php echo form_error("seo_description");?>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">SEO Keywords</label>
                                            <div class="col-sm-10">
                                                <input type="text" name="seo_keywords" id="seo_keywords" class="form-control" placeholder="SEO Keywords" value="<?php echo set_value("seo_keywords");?>">
                                                <?php echo form_error("seo_keywords");?>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">SEO URL</label>
                                            <div class="col-sm-10">
                                                <input type="text" name="seo_url" id="seo_url" class="form-control" placeholder="SEO URL" value="<?php echo set_value("seo_url");?>">
                                                <?php echo form_error("seo_url");?>
                                            </div>
                                        </div>
                                        <button type="submit" name="submit_category" id="submit_category" class="btn btn-primary" id="primary-popover-content">Submit</button>
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