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
                                    <h4><?php echo $pageTitle; ?></h4>
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
                                    <li class="breadcrumb-item"><a href="#">Shipping Report</a></li>
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
                                    <h5><?php echo $pageTitle; ?></h5>
                                </div>
                                <div class="card-block">
                                    <?php echo $this->session->flashdata("message"); ?>
                                    <div class="dt-responsive table-responsive">
                                        <table id="categoryTable" class="table table-striped table-bordered nowrap">
                                            <thead>
                                                <tr>
                                                    <th>Sr.No.</th>
                                                    <th>Order Id</th>
                                                    <th>Pickup Date</th>
                                                    <th>Expected Delivery date</th>
                                                    <th>Actual Delivery date</th>
                                                    <th>Shipper name</th>
                                                    <th>Shipper Id</th>
                                                    <th>Order Amount</th>
                                                    <th>Product Weight</th>
                                                    <th>Shipping cost</th>
                                                    <th>Shipping cost GST</th>
                                                    <th>Subtotal</th>
                                                    <th>Settled Amount</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $i = 0;
                                                if($allhistory){
                                                foreach ($allhistory as $ship) { ?>
                                                    <tr>
                                                        <td><?php echo $i += 1; ?></td>
                                                        <td><a class="badge badge-primary" target="new" href="<?php echo base_url(); ?>admin/order/view/<?php echo $ship['orders_id']; ?>">ORD<?php echo $ship['orders_id']; ?></a></td>
                                                        <td><?php echo $ship['ShipmentPickupDate']; ?></td>
                                                        <td><?php echo $ship['shipping_expected_date']; ?></td>
                                                        <td><?php echo $ship['delivery_date']; ?></td>
                                                        <td>Blue Dart</td>
                                                        <td>1</td>
                                                        <td><?php echo $ship['order_price']; ?></td>
                                                        <td><?php echo $ship['product_weight']; ?></td>
                                                        <td><?php echo $ship['shipping_cost']; ?></td>
                                                        <td><?php echo $ship['shipping_gst']; ?></td>
                                                        <td><?php echo $ship['shipping_subtotal']; ?></td>
                                                        <td><?php echo $ship['shipping_cost']; ?></td>
                                                    </tr>
                                                <?php } } else { ?> 
                                                    <tr><td colspan='13' class="text-center"> No Data Found </td></tr>    
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
<?php $this->load->view("admin/common/footer");?>