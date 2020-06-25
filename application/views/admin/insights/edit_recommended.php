<div class="pcoded-content">
    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-header">
                    <div class="row align-items-end">
                        <div class="col-lg-8">
                            <div class="page-header-title">
                                <div class="d-inline">
                                    <h4>Edit ATZ Bussines Insight Recommended</h4>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="page-header-breadcrumb">
                                <ul class="breadcrumb-title">
                                    <li class="breadcrumb-item">
                                        <a href="<?php echo base_url('admin/dashboard');?>"> <i class="feather icon-home"></i> </a>
                                    </li>
                                    <li class="breadcrumb-item"><a href="<?php echo base_url('admin/insights/recommended');?>">Recommended</a></li>
                                    <li class="breadcrumb-item">Edit Recommended</li>
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
                                    <h4 class="sub-title">Recommended</h4>
									  
                                    <?php //$this->session->flashdata();exit;?>
                                    <?php if ($this->session->flashdata('success') != '') { ?>
                                        <div class='alert alert-success alert-dismissible'>
                                            <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                                            <?php echo $this->session->flashdata('success'); ?>
                                        </div>
                                    <?php } ?>	

                                    <?php if ($this->session->flashdata('error') != '') { ?>
                                        <div class='alert alert-danger alert-dismissible'>
                                            <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                                            <?php echo $this->session->flashdata('error'); ?>
                                        </div>
                                    <?php } ?>	
									
                                    <form method="post" enctype="multipart/form-data">
					<div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Uploaded Image</label>
                                            <div class="col-sm-10">
                                                <img src="<?php echo base_url('uploads/images/bi_recommended/'.$record->image);?>" style="height:100px;width:100px;">
                                            </div>
                                        </div>
					<div class="form-group row">
                                            <label class="col-sm-2 col-form-label">New Image</label>
                                            <div class="col-sm-10">
                                                <input type="file" name="image" id="image" class="form-control">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Topic</label>
                                            <div class="col-sm-10">
                                                <input type="text" name="topic" id="topic" class="form-control" placeholder="Topic" value="<?php echo set_value('topic',$record->topic);?>" required>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Short Description : </label>
                                            <div class="col-sm-10">
                                                <textarea class="form-control" name="short_description" required><?php echo set_value('short_description',$record->short_description);?></textarea>
                                            </div>
                                        </div>
					<div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Full Description : </label>
                                            <div class="col-sm-10">
                                                <textarea class="form-control" name="full_description" id="full_description" required><?php echo set_value('full_description',$record->full_description);?></textarea>
                                            </div>
                                        </div>
					<input type="hidden" name="id" value="<?php echo $record->id; ?>"> 
                                        <button type="submit" name="submit" value="submit" id="submit" class="btn btn-primary" id="primary-popover-content">Submit</button>
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
<script>
CKEDITOR.replace( 'full_description' );
</script>