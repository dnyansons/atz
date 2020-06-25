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
                                    <h4>Import xls File</h4>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="page-header-breadcrumb">
                                <ul class="breadcrumb-title">
                                    <li class="breadcrumb-item">
                                        <a href="<?php echo site_url();?>admin/dashboard"> <i class="feather icon-home"></i> </a>
                                    </li>
                                    <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>admin/bulkimport">List</a>
                                    </li>
                                    <li class="breadcrumb-item"><a href="#!">Bulk Upload</a>
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
                                    <h4 class="sub-title">Bulk Import</h4>
                                   
                                    <?php echo $this->session->flashdata("message");?>
                                    <form method="post" enctype="multipart/form-data" action="<?php echo site_url();?>admin/bulkimport/import">
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Upload xls</label>
                                            <div class="col-sm-10">
                                                <input type="file" name="upload_file" class="form-control" >
                                                <div><?php echo form_error('upload_file'); ?></div>
                                            </div>
                                        </div>

                                        

                                        <button type="submit" id="submit_brand" name="submit" value="submit" class="btn btn-primary pull-right" id="primary-popover-content">Import File</button>
                                        
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
		$('#category_div').hide();
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
	});
	
</script>


