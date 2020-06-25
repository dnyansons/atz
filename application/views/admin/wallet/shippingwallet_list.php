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
                                    <h4>Shipping Wallet</h4>
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
                                    <li class="breadcrumb-item"><a href="#">Wallet</a></li>
                                    <li class="breadcrumb-item"><a href="<?php echo site_url(); ?>admin/wallet/shipping">Shipping Wallet</a></li>
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
                                    <h5>Shipping's Wallet</h5>
                                </div>
                                <div class="card-block">
                                    <?php echo $this->session->flashdata("message"); ?>
                                    <div class="dt-responsive table-responsive">
                                        <table id="categoryTable" class="table table-striped table-bordered nowrap">
                                            <thead>
                                                <tr>
                                                    <th>Sr.No.</th>
                                                    <th>Shipper Name</th>
                                                    <th>Pending Amount</th>
                                                    <th>Available Amount</th>
                                                    <th>Hold Amount</th>
                                                    <th>Settled Amount</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $i = 0;
                                                foreach ($shipeprs as $ship) {
                                                    ?>
                                                    <tr>
                                                        <td><?php echo $i +=1; ?></td>
                                                        <td><?php echo $ship['vendor_name']; ?></td>
                                                        <td><a target="new" href="<?php echo base_url(); ?>admin/wallet/shipping_pending_payments/<?php echo $ship['id']; ?>"><span class="badge badge-primary"><?php echo $ship['pending']; ?></span></a></td>
                                                        <td><a target="new" href="<?php echo base_url(); ?>admin/wallet/shipping_available_payments/<?php echo $ship['id']; ?>"><span class="badge badge-success"><?php echo $ship['available']; ?></span></a></td>
                                                        <td><a target="new" href="<?php echo base_url(); ?>admin/wallet/shipping_hold_payments/<?php echo $ship['id']; ?>"><span class="badge badge-danger"><?php echo $ship['hold']; ?></span></a></td>
                                                        <td><a target="new" href="<?php echo base_url(); ?>admin/wallet/shipping_settled_payments/<?php echo $ship['id']; ?>"><span class="badge badge-warning"><?php echo $ship['settled']; ?></span></a></td>
                                                    </tr>
                                                <?php } ?>
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
