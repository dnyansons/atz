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
                                    <h4>Add Titles</h4>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="page-header-breadcrumb">
                                <ul class="breadcrumb-title">
                                    <li class="breadcrumb-item">
                                        <a href="<?php echo site_url();?>admin/dashboard"> <i class="feather icon-home"></i> </a>
                                    </li>
                                    <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>admin/helpCenter/forseller">List</a></li>
                                    <li class="breadcrumb-item"><a href="#!">Add Title</a></li>
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
                                    <h4 class="sub-title">Title</h4>
                                    <?php echo $this->session->flashdata("message");?>
                                    <form method="post" enctype="multipart/form-data">
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Title</label>
                                            <div class="col-sm-10">
                                                <input type="text" name="title" id="title" class="form-control" value="<?php echo set_value("title");?>" placeholder="Title">
                                                <?php echo form_error("title");?>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Select Parent Category</label>
                                            <div class="col-sm-10">
                                                <select name="parent_category" class="form-control">
                                                    <option value="">-- Select Parent Category --</option>
                                                    <option value="0">Default</option>
                                                    <?php foreach ($result as $titles) { ?>
                                                    <option value="<?php echo $titles['id']; ?>"><?php echo ucfirst($titles['title']); ?></option>
                                                    <?php } ?>
                                                </select>
                                                <?php echo form_error("parent_category");?>
                                            </div>
                                        </div>
                                       
										
                                        <div class="form-group row">
                                            <label class="control-label col-md-2">Description</label>
                                            <div class="col-md-10">
                                                <textarea class="ckeditor" name="description" rows="4"><?php echo set_value("description");?></textarea>
												<?php echo form_error("description");?>
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
<?php $this->load->view("admin/common/footer");?>