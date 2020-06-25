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
                                    <h4>Add Shipping Method</h4>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="page-header-breadcrumb">
                                <ul class="breadcrumb-title">
                                    <li class="breadcrumb-item">
                                        <a href="<?php echo site_url();?>admin/dashboard"> <i class="feather icon-home"></i> </a>
                                    </li>
                                    <li class="breadcrumb-item"><a href="#!">Shipping Method</a></li>
                                    <li class="breadcrumb-item"><a href="#!">Add Shipping Method</a></li>
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
                                    <h4 class="sub-title">Shipping Method</h4>
                                    <form method="post" enctype="multipart/form-data">
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Shipping Method Name</label>
                                            <div class="col-sm-10">
                                                <input type="text" name="shipping_method_name" id="shipping_method_name" class="form-control" placeholder="Shipping Method Name">
                                            </div>
                                        </div>
                                        
                                        
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Weight Range</label>
                                            <div class="col-sm-10">
                                                <input type="text" name="weight_range" id="weight_range" class="form-control" placeholder="Weight Range">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Dimension Range</label>
                                            <div class="col-sm-10">
                                                <input type="text" name="dimension_range" id="dimension_range" class="form-control" placeholder="Dimension Range">
                                            </div>
                                        </div>

                                        <button type="submit" name="submit" id="submit" class="btn btn-primary" id="primary-popover-content">Submit</button>
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