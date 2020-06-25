
<div class="pcoded-content">
<div class="pcoded-inner-content">

<div class="main-body">
<div class="page-wrapper">

<div class="page-header">
<div class="row align-items-end">
<div class="col-lg-8">
<div class="page-header-title">
<div class="d-inline">
<h4>Edit Brand</h4>

</div>
</div>
</div>
<div class="col-lg-4">
<div class="page-header-breadcrumb">
<ul class="breadcrumb-title">
<li class="breadcrumb-item">
<a href="<?php echo site_url();?>admin/dashboard"> <i class="feather icon-home"></i> </a>
</li>
<li class="breadcrumb-item"><a href="#!">Brands</a>
</li>
<li class="breadcrumb-item"><a href="#!">Edit Brand</a>
</li>
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

<div class="form-group row">
<label class="col-sm-2 col-form-label">Brand Name</label>
<div class="col-sm-10">
<input type="text" name="brand_name" value="<?php echo $brand_data->brand_name; ?>" id="brand_name" class="form-control" placeholder="Brand Name">
</div>
</div>
<div class="form-group row">
<label class="col-sm-2 col-form-label">Brand Description</label>
<div class="col-sm-10">
<input type="text" name="brand_description" value="<?php echo $brand_data->brand_description; ?>" id="brand_description" class="form-control" placeholder="Brand Description">
</div>
</div>
<div class="form-group row">
<label class="col-sm-2 col-form-label">Image</label>
<div class="col-sm-2">
<img src="<?php echo base_url(); ?>assets/images/brand/<?php echo $brand_data->brand_image; ?>" name="category_image_show" width="50" height="100" class="form-control">
</div>
</div>

<div class="form-group row">
<label class="col-sm-2 col-form-label">Upload Brand Image</label>
<div class="col-sm-10">
<input type="file"  value="" name="brand_image" class="form-control">
</div>
</div>


<div class="form-group row">
<label class="col-sm-2 col-form-label">SEO Title</label>
<div class="col-sm-10">
<input type="text" name="seo_title" id="seo_title" value="<?php echo $brand_data->seo_title; ?>" class="form-control" placeholder="SEO Title">
</div>
</div>

<div class="form-group row">
<label class="col-sm-2 col-form-label">SEO Description</label>
<div class="col-sm-10">
<input type="text" name="seo_description" value="<?php echo $brand_data->seo_description; ?>" id="seo_description" class="form-control" placeholder="SEO Description">
</div>
</div>

<div class="form-group row">
<label class="col-sm-2 col-form-label">SEO Keywords</label>
<div class="col-sm-10">
<input type="text" name="seo_keyword" value="<?php echo $brand_data->seo_keyword; ?>" id="seo_keyword" class="form-control" placeholder="SEO Keywords">
</div>
</div>

<div class="form-group row">
<label class="col-sm-2 col-form-label">SEO URL</label>
<div class="col-sm-10">
<input type="text" name="seo_url" value="<?php echo $brand_data->seo_url; ?>" id="seo_url" class="form-control" placeholder="SEO URL">
</div>
</div>


<button type="submit" name="submit_brand"  id="submit_brand" class="btn btn-primary pull-right" id="primary-popover-content">Update Brand</button>

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

