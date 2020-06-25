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
                                    <h4>Add Specifications</h4>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="page-header-breadcrumb">
                                <ul class="breadcrumb-title">
                                    <li class="breadcrumb-item">
                                        <a href="<?php echo site_url();?>admin/dashboard"> <i class="feather icon-home"></i> </a>
                                    </li>
                                    <li class="breadcrumb-item"><a href="<?php echo site_url();?>admin/categories">Categories</a></li>
                                    <li class="breadcrumb-item"><a href="#">Edit Specification</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="page-body">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="card">
                                <div class="card-header">
                                    <div class="card-header-right">
                                        <i class="icofont icofont-spinner-alt-5"></i>
                                    </div>
                                </div>
                                <div class="card-block">
                                    <h4 class="sub-title">Category</h4>
                                    <form method="post" enctype="multipart/form-data" action="<?php echo site_url();?>admin/categories/editSpec/<?php echo $spec_id;?>">
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Name</label>
                                            <div class="col-sm-10">
                                                <input type="text" name="name" id="name" class="form-control" placeholder="Specification Name" value="<?php echo $spec->name;?>">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Type</label>
                                            <div class="col-sm-10">
                                                <select class="form-control" name="type">
                                                    <option value="dropdown">Dropdown</option>
                                                    <option value="single_input">Single Input</option>
                                                    <option value="multi_checkbox">Multiple checkbox</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Choices</label>
                                            <div class="col-sm-10">
                                                <div class="tags_add_multiple">
                                                    <input name="choices" type="text" data-role="tagsinput" value="<?php echo implode(',',json_decode($spec->choices));?>">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Compulsory</label>
                                            <div class="col-md-10 form-radio m-b-30">
                                                <div class="radio radio-matrial radio-primary radio-inline">
                                                    <label>
                                                        <input type="radio" name="is_compulsary" value="1">
                                                        <i class="helper"></i>Yes
                                                    </label>
                                                </div>
                                                <div class="radio radio-matrial radio-danger radio-inline">
                                                    <label>
                                                        <input type="radio" name="is_compulsary" value="0" checked="checked">
                                                        <i class="helper"></i>No
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <button type="submit" name="submit_category" id="submit_category" 
                                        class="btn btn-primary pull-right" id="primary-popover-content">Submit</button>
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
<?php $this->load->view("admin/common/footer");?>