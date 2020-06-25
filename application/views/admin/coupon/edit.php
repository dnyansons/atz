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
<h4>Edit Coupon</h4>

</div>
</div>
</div>
<div class="col-lg-4">
<div class="page-header-breadcrumb">
<ul class="breadcrumb-title">
<li class="breadcrumb-item">
<a href="<?php echo site_url();?>admin/dashboard"> <i class="feather icon-home"></i> </a>
</li>
<li class="breadcrumb-item"><a href="#!">Coupon</a>
</li>
<li class="breadcrumb-item"><a href="#!">Edit Coupon</a>
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
<h4 class="sub-title">Coupon</h4>
 <form method="post" enctype="multipart/form-data">

<div class="form-group row">
<label class="col-sm-2 col-form-label">Coupon Code</label>
<div class="col-sm-10">
<input type="text" name="coupon_code" id="coupon_code" value="<?php echo $coupon_data['coupon_code'] ?>" class="form-control" placeholder="Coupon Code" required>
</div>
</div>
<div class="form-group row">
<label class="col-sm-2 col-form-label">Discount Type</label>
<div class="col-sm-10">
<select class="form-control" name="discount_type">
<option value="flat" <?php if($coupon_data['discount_type']=='flat') { echo 'selected=selected';} ?>>Flat</option>
<option value="percentage" <?php if($coupon_data['discount_type']=='percentage') { echo 'selected=selected';} ?>>Percentage</option>
</select>
</div>
</div>

<!--

<div class="form-group row">
<label class="col-sm-2 col-form-label">Coupon Type</label>
<div class="col-sm-10">
<select class="form-control" name="coupon_type">
<option value="on_category" <?php if($coupon_data['coupon_type']=='on_category') { echo 'selected=selected';} ?>>On Category</option>
<option value="on_product" <?php if($coupon_data['coupon_type']=='on_product') { echo 'selected=selected';} ?>>On Product</option>
</select>
</div>
</div>

-->

<div class="form-group row">
<label class="col-sm-2 col-form-label">Coupon Value</label>
<div class="col-sm-10">
<input type="number" name="coupon_value" id="coupon_value" value="<?php echo $coupon_data['coupon_value'] ?>" class="form-control" placeholder="0" required>
</div>
</div>


<div class="form-group row">
	<label class="col-sm-2 col-form-label">Applicable Category</label>
	<div class="col-sm-10">
		<select name="applicable_category_id" class="form-control">
			<option value="">Select Category</option>
			<?php foreach($categories_list as $category){ 
				if(count($category->sub) > 0){
				echo "<optgroup label='".$category->categories_name."'>";    
				foreach($category->sub as $cat){
					
				if($cat->category_id==$coupon_data['applicable_category_id'])
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


<?php 
												
if(isset($coupon_data['valid_from']))
{
   $valid_from = str_replace('-', '/', $coupon_data['valid_from']);
   $valid_from= date('d/m/Y', strtotime($valid_from));
}


?>



<div class="form-group row">
  <label class="col-sm-2 col-form-label">Minimum Order Price</label>
  <div class="col-sm-10">
  <div class="input-group">
    <input type="text" name="min_order_price" id="min_order_price" class="form-control" placeholder="Minimum Order Price" value="<?= $coupon_data['min_order_price'] ?>" required >
  </div>
  </div>
</div>


<div class="form-group row">
  <label class="col-sm-2 col-form-label">Valid From</label>
  <div class="col-sm-10">
      
  <div class="input-group date">
    <input type="text" name="valid_from" id="valid_from" class="form-control date" placeholder="Valid From" data-format="dd/MM/yyyy" required readonly="readonly" value="<?= $valid_from; ?>">
    <div class="input-group-addon">
    <span class="fa fa-calendar"></span>
    </div>
  </div>

  </div>
</div>


<?php 
												
if(isset($coupon_data['valid_to']))
{
   $valid_to = str_replace('-', '/', $coupon_data['valid_to']);
   $valid_to= date('d/m/Y', strtotime($valid_to));
}


?>


<div class="form-group row">
  <label class="col-sm-2 col-form-label">Valid To</label>
  <div class="col-sm-10">
      
  <div class="input-group date">
    <input type="text" name="valid_to" id="valid_to" class="form-control date" placeholder="Valid To" data-format="dd/MM/yyyy" required readonly="readonly" value="<?= $valid_to; ?>">
    <div class="input-group-addon">
    <span class="fa fa-calendar"></span>
    </div>
  </div>

  </div>
</div>




<button type="submit" id="submit_brand" class="btn btn-primary pull-right" id="primary-popover-content">Update</button>

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
<script>
 
 $(document).ready(function() {

   $('.date').datepicker({
     format: "dd/mm/yyyy",
	 autoclose: true,  
  });

});

</script>

