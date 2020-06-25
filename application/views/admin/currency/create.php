
<div class="pcoded-content">
<div class="pcoded-inner-content">

<div class="main-body">
<div class="page-wrapper">

<div class="page-header">
<div class="row align-items-end">
<div class="col-lg-8">
<div class="page-header-title">
<div class="d-inline">
<h4>Add Currency Charges</h4>

</div>
</div>
</div>
<div class="col-lg-4">
<div class="page-header-breadcrumb">
<ul class="breadcrumb-title">
<li class="breadcrumb-item">
<a href="<?php echo site_url();?>admin/dashboard"> <i class="feather icon-home"></i> </a>
</li>
<li class="breadcrumb-item"><a href="#!">Currency</a>
</li>
<li class="breadcrumb-item"><a href="#!">Add Currency Charges</a>
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
<label class="col-sm-2 col-form-label">Currency From</label>
<div class="col-sm-10">
<select class="form-control" name="currency_from" required>
<option value="">--Select--</option>
<?php
foreach($curr as $cu)
{
echo '<option value="'.$cu["code"].'">'.$cu["code"].'</option>';	
}
?>
</select> 
</div>
</div>
<div class="form-group row">
<label class="col-sm-2 col-form-label">Currency To</label>
<div class="col-sm-10">
<select class="form-control" name="currency_to" required>
<option value="">--Select--</option>
<?php
foreach($curr as $cu)
{
echo '<option value="'.$cu["code"].'">'.$cu["code"].'</option>';	
}
?>

</select>
</div>
</div>
<div class="form-group row">
<label class="col-sm-2 col-form-label">Charges</label>
<div class="col-sm-10">
<input type="text" name="charges" id="charges" class="form-control" placeholder="0.00" required>
</div>
</div>



<button type="submit"  id="submit_brand" class="btn btn-primary pull-right" id="primary-popover-content">Add</button>

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

