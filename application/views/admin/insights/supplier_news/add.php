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
                                    <h4>Add Supplier News</h4>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="page-header-breadcrumb">
                                <ul class="breadcrumb-title">
                                    <li class="breadcrumb-item">
                                        <a href="<?php echo base_url('admin/dashboard');?>"> <i class="feather icon-home"></i> </a>
                                    </li>
                                    <li class="breadcrumb-item"><a href="<?php echo base_url('admin/BI/supplier_news');?>">Supplier News</a></li>
                                    <li class="breadcrumb-item">Add Supplier News</li>
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
                                    <h4 class="sub-title">Supplier News</h4>
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
                                            <label class="col-sm-2 col-form-label">Company Name :</label>
                                            <div class="col-sm-10">
                                                <input type="text" name="company_name" id="company_name" class="form-control"  value="<?php echo set_value('company_name');?>" required>
                                            </div>
                                        </div>
                                         <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Slogan : </label>
                                            <div class="col-sm-10">
                                                <input type="text" name="slogan" id="slogan" class="form-control"  value="<?php echo set_value('slogan');?>" required>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Company Profile Info : </label>
                                            <div class="col-sm-10">
                                                <textarea name="company_profile_info" class="form-control" rows="6"><?php echo set_value('company_profile_info');?></textarea>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Company Profile Images :</label>
                                            <div class="col-sm-10">
                                                <input type="file" name="company_profile_images[]" required="" multiple=""><br><br>
                                                <p style="color: red">Press Ctrl to select multiple images</p>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Company Competence :</label>
                                            <div class="col-sm-10">
                                                <textarea name="company_competence" id="company_competence" class="form-control"><?php echo set_value('company_competence');?></textarea>
                                            </div>
                                        </div>
					<div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Company Competence Images : </label>
                                            <div class="col-sm-10">
                                                <input type="file" name="company_competence_images[]" required="" multiple=""><br><br>
                                                <p style="color: red">Press Ctrl to select multiple images</p>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Success Story :</label>
                                            <div class="col-sm-10">
                                                <textarea name="success_story" id="success_story" class="form-control"><?php echo set_value('success_story');?></textarea>
                                            </div>
                                        </div>
					<div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Success Story Images : </label>
                                            <div class="col-sm-10">
                                                <input type="file" name="success_story_images[]" required="" multiple=""><br><br>
                                                <p style="color: red">Press Ctrl to select multiple images</p>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Status : </label>
                                                <div class="col-sm-10">
                                                  <select name="status"  id="status" class="form-control" required>
                                                    <option value="Active">Active</option>
                                                        <option value="Inactive">Inactive</option>
                                                  </select>
                                                </div>
                                        </div>
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
<?php $this->load->view("admin/common/footer");?>
