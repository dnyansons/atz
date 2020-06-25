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
                                    <li class="breadcrumb-item"><a href="#">Orders Cancellation reasons List</a></li>
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
                                <div class="card-header">
                                    <a href="<?php echo site_url();?>admin/orders/addCancelReason" class="btn btn-info float-right">
                                        Add New
                                    </a>
                                </div>
                                <div class="card-block">
                                    <div class="dt-responsive table-responsive">
                                        <table id="orderTable" class="table table-striped table-bordered nowrap">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Text</th>
                                                    <th style="width:10%">Edit</th>
                                                    <th style="width:10%">Delete</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $i=1; foreach($items as $item):?>
                                                <tr>
                                                    <td><?php echo $i;?></td>
                                                    <td><?php echo $item->reason;?></td>
                                                    <td>
                                                        <a class="btn btn-link" href='<?php echo site_url("admin/orders/updateReason/").$item->id;?>'>
                                                            <i class="fa fa-edit"></i>
                                                        </a>
                                                    </td>
                                                    <td>
                                                        <a class="btn btn-link" href='<?php echo site_url("admin/orders/deleteReason/").$item->id;?>'>
                                                            <i class="fa fa-remove"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                                <?php $i++; endforeach;?>
                                            </tbody>
                                        </table>
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
<?php $this->load->view("admin/common/footer"); ?>