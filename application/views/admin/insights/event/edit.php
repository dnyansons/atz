<div class="pcoded-content">
    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-header">
                    <div class="row align-items-end">
                        <div class="col-lg-8">
                            <div class="page-header-title">
                                <div class="d-inline">
                                    <h4>Edit Event</h4>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="page-header-breadcrumb">
                                <ul class="breadcrumb-title">
                                    <li class="breadcrumb-item">
                                        <a href="<?php echo base_url('admin/dashboard');?>"> <i class="feather icon-home"></i> </a>
                                    </li>
                                    <li class="breadcrumb-item"><a href="<?php echo base_url('admin/BI/event/');?>">Event</a></li>
                                    <li class="breadcrumb-item">Edit Event</li>
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
                                    <h4 class="sub-title">Edit Event</h4>
                                        <?php if ($this->session->flashdata('success') != ''){?>
                                                <div class='alert alert-success alert-dismissible'>
                                                   <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                                                   <?php echo $this->session->flashdata('success'); ?>
                                                </div>
                                        <?php } ?>	

                                        <?php if ($this->session->flashdata('error') != ''){?>
                                                <div class='alert alert-danger alert-dismissible'>
                                                   <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                                                   <?php echo $this->session->flashdata('error'); ?>
                                                </div>
                                        <?php } ?>	
									
                                    <form method="post" enctype="multipart/form-data">
	                                <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Event Title :</label>
                                            <div class="col-sm-10">
                                                <input type="text" name="title" id="title" class="form-control"  value="<?php echo set_value('title',$record->title);?>" minlength="10" maxlength="60"required>
                                            </div>
                                        </div>
                                         <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">You Tube Embed URL : </label>
                                            <div class="col-sm-10">
                                                <input type="url" name="you_tube_embed_url" id="you_tube_embed_url" class="form-control"  value="<?php echo set_value('you_tube_embed_url',$record->you_tube_embed_url);?>" required>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Uploaded Event Image : </label>
                                            <div class="col-sm-10">
                                                <img src="<?php echo $record->event_image ?>" style="height: 100px;width:100px;">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">New Event Image : </label>
                                            <div class="col-sm-10">
                                                <input type="file" name="event_image" id="event_image" class="form-control">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Short Description : </label>
                                            <div class="col-sm-10">
                                                <textarea name="short_description" class="form-control" rows="6" minlength="10" maxlength="100"><?php echo set_value('short_description',$record->short_description);?></textarea>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Status : </label>
                                                <div class="col-sm-10">
                                                  <select name="status"  id="status" class="form-control" required>
                                                    <option value="Active" <?php echo $record->status == 'Active' ? 'selected':'';?>>Active</option>
                                                    <option value="Inactive" <?php echo $record->status == 'Inactive' ? 'selected':'';?>>Inactive</option>
                                                  </select>
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
 CKEDITOR.replace('company_competence');
</script>
