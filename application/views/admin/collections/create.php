<?php $this->load->view("admin/common/header"); ?>
<div class="pcoded-content">
    <div class="pcoded-inner-content">

        <div class="main-body">
            <div class="page-wrapper">

                <div class="page-header">
                    <div class="row align-items-end">
                        <div class="col-lg-8">
                            <div class="page-header-title">
                                <div class="d-inline">
                                    <h4>Create Collection</h4>
                                    <span>create new collections</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="page-header-breadcrumb">
                                <ul class="breadcrumb-title">
                                    <li class="breadcrumb-item">
                                        <a href="<?php echo site_url(); ?>admin/dashboard"> <i class="feather icon-home"></i> </a>
                                    </li>
                                    <li class="breadcrumb-item"><a href="#">Collections</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="page-body">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="card">
                                <div class="card-header">
                                    <h5>Create Collections form</h5>
                                </div>
                                <div class="card-block">
                                    <form action="<?php echo site_url(); ?>admin/collections/create" method="post">
                                        <div class="form-group">
                                            <label for="name">Name:</label>
                                            <input type="text" class="form-control" id="name" placeholder="Enter name" name="name" value="<?php echo set_value('name'); ?>">
                                            <?php echo form_error("name"); ?>
                                        </div>
                                        <div class="form-group">
                                            <label for="description">Description:</label>
                                            <textarea class="form-control" rows="6" name="description"><?php echo set_value('description'); ?></textarea>
                                            <?php echo form_error("description"); ?>
                                        </div>
                                        <div class="form-group">
                                            <label for="meta_title">Meta title:</label>
                                            <input type="text" class="form-control" id="meta_title" placeholder="Enter Title" name="meta_title" value="<?php echo set_value('meta_title'); ?>">
                                            <?php echo form_error("meta_title"); ?>
                                        </div>
                                        <div class="form-group">
                                            <label for="meta_descriptions">Meta Description:</label>
                                            <textarea class="form-control" rows="6" name="meta_descriptions"><?php echo set_value('meta_descriptions'); ?></textarea>
                                            <?php echo form_error("meta_descriptions"); ?>
                                        </div>
                                        <div class="form-group">
                                            <label for="meta_keywords">Meta Keywords:</label>
                                            <input type="text" class="form-control" id="meta_keywords" placeholder="Enter keywords" name="meta_keywords" value="<?php echo set_value('meta_keywords'); ?>">
                                            <?php echo form_error("meta_keywords"); ?>
                                        </div>

                                        <button type="submit" class="btn btn-success pull-right">Submit</button>
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
<?php $this->load->view("admin/common/footer"); ?>