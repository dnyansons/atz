<?php $this->load->view("admin/common/header");?>
<style>
    .optionGroup {
        font-weight: bold;
        font-style: italic;
    }
</style>
<div class="pcoded-content">
	<div class="pcoded-inner-content">
		<div class="main-body">
		<div class="page-wrapper">
			<div class="page-header">
				<div class="row align-items-end">
					<div class="col-lg-8">
						<div class="page-header-title">
							<div class="d-inline">
							<h4>Edit Banners</h4>

							</div>
						</div>
					</div>
					<div class="col-lg-4">
						<div class="page-header-breadcrumb">
							<ul class="breadcrumb-title">
								<li class="breadcrumb-item">
								<a href="<?php echo site_url();?>admin/dashboard"> <i class="feather icon-home"></i> </a>
								</li>
								<li class="breadcrumb-item"><a href="<?php echo base_url();?>admin/banners">List</a>
								</li>
								<li class="breadcrumb-item"><a href="#!">Edit Banner</a>
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
						<h4 class="sub-title">Banners</h4>
						 <form method="post" enctype="multipart/form-data">
							<div class="form-group row">
								<label class="col-sm-2 col-form-label">Banner Title</label>
								<div class="col-sm-10">
									<input type="text" name="banner_title" class="form-control" placeholder="Add Banner Title" value= "<?php echo $banners->banners_title;  ?>" required>
									<div style="color:red"><?php echo form_error('banner_title'); ?></div>
								</div>
							</div>
							
							<div class="form-group row">
								<label class="col-sm-2 col-form-label">Banner Type</label>
								<div class="col-sm-10">
									 <select name="banner_type" class="form-control" id="banner_type">
									 <?php if($banners->banner_type == "Default"){ ?>
										<option value = "Default" selected>Default</option>
										<option value = "Offer">Offer</option>
										<option value = "Category">Category</option>
									 <?php }else if($banners->banner_type == "Offer"){ ?>
										  <option value = "Default" >Default</option>
										  <option value = "Offer" selected>Offer</option>
										  <option value = "Category">Category</option>
									 <?php }else{ ?>
										  <option value = "Default" >Default</option>
										  <option value = "Offer" >Offer</option>
										  <option value = "Category" selected>Category</option>
									 <?php } ?>
									 </select>
								</div>
								<div style="color:red"><?php echo form_error('banner_title'); ?></div>
							</div>
							
							<div class="form-group row" id="category_div">
								<label class="col-sm-2 col-form-label">Select Category</label>
								<div class="col-sm-10">
									 <select name="category" class="form-control">
									 <option value="">Select Category</option>
									  <?php foreach($categories_list as $category){
                                          echo 'a'.$category->category_id== $banners->category;
											if(count($category->sub) > 0){
											    //commented due to new requirement
											//echo "<option label='".$category->categories_name."'>";
                                                $selectParent = $category->category_id== $banners->category? 'selected': '';
                                                echo "<option class='optionGroup' value='".$category->category_id."' $selectParent><b>".$category->categories_name."</b></option>";
                                                foreach($category->sub as $cat){

											if($cat->category_id== $banners->category)
											{
											   echo "<option value='".$cat->category_id."' selected='selected'>&nbsp;&nbsp;".$cat->categories_name."</option>";
											}

											else
											{
											   echo "<option value='".$cat->category_id."'>&nbsp;&nbsp;".$cat->categories_name."</option>";
											}

											}
											//echo "</optgroup>";
											?>
										<?php } else {
											echo "<option value='".$category->category_id."'>&nbsp;&nbsp;".$category->categories_name."</option>";
											} ?>
										<?php } ?>
									 </select>
								</div>
							</div>

							<div class="form-group row">
								<label class="col-sm-2 col-form-label">Banner_image</label>
								<div class="col-sm-10">
									<input type="file" name="banner_image" class="form-control" >
									<input type="hidden" name="banner_image_old" value= "<?php echo $banners->banners_image;?>" >
									<?php if($error){?>
									<?php } ?>
									<div style="color:red"><?php echo $error; ?></div>
								</div>
							</div>



							<div class="form-group row">
								<label class="col-sm-2 col-form-label">Sort Order</label>
								<div class="col-sm-10">
									<input type="text" name="sort_order" class="form-control" value= "<?php echo $banners->sort_order;?>" required>
									<div style="color:red"><?php echo form_error('sort_order'); ?></div>
								</div>
							</div>

							<div class="form-group row">
								<label class="col-sm-2 col-form-label">Expired Date</label>
								<div class="col-sm-4">

										<div class="input-group date">
											<input type="text" name="date" id="date" placeholder="Date Added" data-date-format="YYYY-MM-DD" class="form-control" value = "<?php echo date('d-m-Y',strtotime($banners->expire_date)); ?>" readonly="readonly">
											<span class="input-group-btn">
											<button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button>
											</span>
										</div>
										<div style="color:red"><?php echo form_error('date'); ?></div>
								</div>
							</div>

							<div class="form-group row">
								<label class="col-sm-2 col-form-label">Status</label>
								<div class="col-sm-10">
									<select name="status" class="form-control">
									  <?php if($banners->status == 1){ ?>
										<option value="1" selected>Active</option>
										<option value="0">InActive</option>
									  <?php }else{ ?>
										<option value="1" >Active</option>
										<option value="0" selected>InActive</option>
									  <?php } ?>
									</select>
									<div style="color:red"><?php echo form_error('status'); ?></div>
								</div>
							</div>

							<button type="submit" name="submit_brand" id="submit_brand" class="btn btn-primary pull-right" id="primary-popover-content">Update</button>
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
 <!-- Include Date Range Picker -->
<?php $this->load->view("admin/common/footer");?>

<script>
	$(document).ready(function(){
		var optionText = $("#banner_type option:selected").text();
		if(optionText == 'Category')
		{
			$("#category_div").show();
		}else{
			$("#category_div").hide();
		}

		$("#date").dateDropper({
			format:"d-m-Y",
			dropWidth: 200,
			dropPrimaryColor: "#1abc9c",
			dropBorder: "1px solid #1abc9c",
			maxYear: "2020",
		})

		$('#banner_type').on('change',function(){
        var optionText = $("#banner_type option:selected").text();
		if(optionText == 'Category')
		{
			$("#category_div").show();
		}else{
			$("#category_div").hide();
		}

		})
	})
</script>

