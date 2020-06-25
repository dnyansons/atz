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
                                    <h4>Orders</h4>
                                    <span></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="page-header-breadcrumb">
                                <ul class="breadcrumb-title">
                                    <li class="breadcrumb-item">
                                        <a href="<?php echo site_url(); ?>admin/dashboard"> <i class="feather icon-home"></i> </a>
                                    </li>
                                    <li class="breadcrumb-item"><a href="#">Add cancellation reason</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="page-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <?php echo $this->session->flashdata('message'); ?>
                            <div class="card">
                                
                                <div class="card-block">
                                    <form action="<?php echo site_url();?>admin/orders/addCancelReason" method="post">
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Reason</label>
                                            <div class="col-sm-10">
                                                <textarea name="reason" rows="5" cols="5" class="form-control" placeholder="Default textarea"></textarea>
                                            </div>
                                        </div>
                                        <input type="submit" value="Submit" class="btn btn-info float-right">
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