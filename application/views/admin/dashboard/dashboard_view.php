<?php $this->load->view("admin/common/header"); ?>
<div class="pcoded-content">
    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">
                    <div class="row">

                        <div class="col-xl-3 col-md-6" title="Today`s Total Order">
                            <a href="<?php echo base_url(); ?>admin/order/all_orders">
                                <div class="card bg-c-yellow update-card">
                                    <div class="card-block">
                                        <div class="row align-items-end">
                                            <div class="col-8">
                                                <h4 class="text-white"><?php echo $tot_order; ?></h4>
                                                <h6 class="text-white m-b-0">Total Orders</h6>
                                            </div>
                                            <div class="col-4 text-right">
                                                <canvas id="update-chart-1" height="50"></canvas>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <p class="text-white m-b-0"><i class="fa fa-shopping-cart text-white f-14 m-r-10"></i>Placed Today</p>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="col-xl-3 col-md-6" title="Today`s Sale of Order">
                            <a href="<?php echo base_url(); ?>admin/report/sale_report">
                                <div class="card bg-c-green update-card">
                                    <div class="card-block">
                                        <div class="row align-items-end">
                                            <div class="col-8">
                                                <h4 class="text-white"><?php echo number_format((float) $tot_sale, 2, '.', '');
; ?></h4>
                                                <h6 class="text-white m-b-0">Total Sale Amount</h6>
                                            </div>
                                            <div class="col-4 text-right">
                                                <canvas id="update-chart-2" height="50"></canvas>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <p class="text-white m-b-0" ><i class="fa fa-shopping-cart text-white f-14 m-r-10"></i>Earned Today</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-xl-3 col-md-6" title="Today`s Total Commission of Order (Order Price -Ship Cost- Vendor Price)">
                            <a href="<?php echo base_url(); ?>admin/report/commission_report">
                                <div class="card bg-c-pink update-card">
                                    <div class="card-block">
                                        <div class="row align-items-end">
                                            <div class="col-8">
                                                <h4 class="text-white"><?php echo number_format((float) $tot_comission, 2, '.', ''); ?></h4>
                                                <h6 class="text-white m-b-0">Total Commission</h6>
                                            </div>
                                            <div class="col-4 text-right">
                                                <canvas id="update-chart-3" height="50"></canvas>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <p class="text-white m-b-0" ><i class="fa fa-users text-white f-14 m-r-10"></i>Today Commission</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-xl-3 col-md-6" title="Today`s` Total Shipping Cost of Order">
                            <a href="<?php echo base_url(); ?>admin/report/shipping_report">
                                <div class="card bg-c-lite-green update-card">
                                    <div class="card-block">
                                        <div class="row align-items-end">
                                            <div class="col-8">
                                                <h4 class="text-white"><?php echo number_format((float) $tot_shipping, 2, '.', ''); ?></h4>
                                                <h6 class="text-white m-b-0">Shipping Cost </h6>
                                            </div>
                                            <div class="col-4 text-right">
                                                <canvas id="update-chart-4" height="50"></canvas>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <p class="text-white m-b-0"><i class="fa fa-credit-card text-white f-14 m-r-10"></i>For Today's Orders</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <!--=======================================================-->
                        <div class="col-xl-3 col-md-6" title="Today`s Total Return Order">
                            <a href="<?php echo base_url(); ?>admin/report/return_report">
                                <div class="card bg-c-yellow update-card">
                                    <div class="card-block">
                                        <div class="row align-items-end">
                                            <div class="col-8">
                                                <h4 class="text-white"><?php echo $tot_return; ?></h4>
                                                <h6 class="text-white m-b-0">Return Request's</h6>
                                            </div>
                                            <div class="col-4 text-right">
                                                <canvas id="update-chart-1" height="50"></canvas>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <p class="text-white m-b-0"><i class="fa fa-shopping-cart text-white f-14 m-r-10"></i>Received Today</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-xl-3 col-md-6" title="Today`s Total Dispute Amount (Order Delivered and Payment on Hold)">
                            <a href="<?php echo base_url(); ?>admin/payments/holdpayments">
                                <div class="card bg-c-green update-card">
                                    <div class="card-block">
                                        <div class="row align-items-end">
                                            <div class="col-8">
                                                <h4 class="text-white"><?php echo number_format((float) $tot_dispute, 2, '.', ''); ?></h4>
                                                <h6 class="text-white m-b-0">Total Dispute</h6>
                                            </div>
                                            <div class="col-4 text-right">
                                                <canvas id="update-chart-2" height="50"></canvas>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <p class="text-white m-b-0"><i class="fa fa-shopping-cart text-white f-14 m-r-10"></i>Total Payment On Hold</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-xl-3 col-md-6" title="Today`s Total Settled Amount">
                            <a href="<?php echo base_url(); ?>admin/report/settlement_report">
                                <div class="card bg-c-pink update-card">
                                    <div class="card-block">
                                        <div class="row align-items-end">
                                            <div class="col-8">
                                                <h4 class="text-white"><?php echo number_format((float) $tot_settled, 2, '.', ''); ?></h4>
                                                <h6 class="text-white m-b-0">Amount Settled</h6>
                                            </div>
                                            <div class="col-4 text-right">
                                                <canvas id="update-chart-3" height="50"></canvas>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <p class="text-white m-b-0"><i class="fa fa-users text-white f-14 m-r-10"></i>Amount Paid To Vendor</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-xl-3 col-md-6" title="Today`s Total Amount Refunded">
                            <a href="<?php echo base_url(); ?>admin/report/refund_report">
                            <div class="card bg-c-lite-green update-card">
                                <div class="card-block">
                                    <div class="row align-items-end">
                                        <div class="col-8">
                                            <h4 class="text-white"><?php echo number_format($total_refund, 2); ?></h4>
                                            <h6 class="text-white m-b-0">Amount Refunded</h6>
                                        </div>
                                        <div class="col-4 text-right">
                                            <canvas id="update-chart-4" height="50"></canvas>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <p class="text-white m-b-0"><i class="fa fa-credit-card text-white f-14 m-r-10"></i>Total Refunded Amount</p>
                                </div>
                            </div>
                                </a>
                        </div>
                        <div class="col-xl-3 col-md-6" title="Today`s Total Buyer Registered">
                            <a href="<?php echo base_url(); ?>admin/users">
                                <div class="card bg-c-yellow update-card">
                                    <div class="card-block">
                                        <div class="row align-items-end">
                                            <div class="col-8">
                                                <h4 class="text-white"><?php echo $todaysBuyerRegs; ?></h4>
                                                <h6 class="text-white m-b-0">Today's Buyer Registrations</h6>
                                            </div>
                                            <div class="col-4 text-right">
                                                <canvas id="update-chart-1" height="50"></canvas>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <p class="text-white m-b-0"><i class="fa fa-shopping-cart text-white f-14 m-r-10"></i>Buyers Registered Today</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-xl-3 col-md-6" title="Today`s Total Seller Registered">
                                <div class="card bg-c-green update-card">
                                  <a href="<?php echo base_url(); ?>admin/vendors">
                                    <div class="card-block">
                                        <div class="row align-items-end">
                                            <div class="col-8">
                                                <h4 class="text-white"><?php echo $todaysSellerRegs; ?></h4>
                                                <h6 class="text-white m-b-0">Today's Seller Registrations</h6>
                                            </div>
                                            <div class="col-4 text-right">
                                                <canvas id="update-chart-2" height="50"></canvas>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <p class="text-white m-b-0"><i class="fa fa-shopping-cart text-white f-14 m-r-10"></i>Seller Registered Today</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-xl-12 col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    Sales analytics
                                </div>
                                <div class="card-block">
                                    <canvas id="canvas"></canvas>
                                </div>
                            </div>
                        </div>


                        <div class="col-xl-12 col-md-12">
                            <div class="card table-card">
                                <div class="card-header">
                                    <h5>Latest Order</h5>
                                    <div class="card-header-right">
                                        <ul class="list-unstyled card-option">
                                            <li><i class="feather icon-maximize full-card"></i></li>
                                            <li><i class="feather icon-minus minimize-card"></i></li>

                                        </ul>
                                    </div>
                                </div>
                                <div class="card-block">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-striped">
                                            <thead>
                                                <tr>
                                                    <th>OderID</th>
                                                    <th>Customer</th>
                                                    <th>Status</th>
                                                    <th>Date</th>
                                                    <th>Total</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $i = 1;
                                                foreach ($latest_order as $order) {
                                                    ?>
                                                    <tr>
                                                        <td><?php echo $order['orders_id']; ?></td>
                                                        <td><?php echo $order['user_name']; ?></td>
                                                        <td><?php echo $order['orders_status_name']; ?></td>
                                                        <td><?php echo $order['date_purchased']; ?></td>
                                                        <td><?php echo $order['final_price']; ?></td>
                                                        <td class=""><a href="<?php echo base_url(); ?>admin/order/view/<?php echo $order['orders_id']; ?>" class="btn btn-info btn-sm">View</a></td>
                                                    </tr>
                                                    <?php $i++;
                                                } ?>
                                            </tbody>
                                        </table>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- <div class="col-xl-4 col-md-12">
                             <div class="card user-activity-card">
                                 <div class="card-header">
                                     <h5>Recent Activites</h5>
                                 </div>
                                 <div class="card-block">
                                     <div class="row m-b-25">
                                         <div class="col-auto p-r-0">
                                             <div class="u-img">
                                                 <img src="<?php // echo base_url(); ?>assets/images/breadcrumb-bg.jpg" alt="user image" class="img-radius cover-img">
                                                 <img src="<?php //echo base_url(); ?>assets/images/avatar-2.jpg" alt="user image" class="img-radius profile-img">
                                             </div>
                                         </div>
                                         <div class="col">
                                             <h6 class="m-b-5">John Deo</h6>
                                             <p class="text-muted m-b-0">Lorem Ipsum is simply dummy text.</p>
                                             <p class="text-muted m-b-0"><i class="feather icon-clock m-r-10"></i>2 min ago</p>
                                         </div>
                                     </div>
                                    
                                    
                                     <div class="row m-b-5">
                                         <div class="col-auto p-r-0">
                                             <div class="u-img">
                                                 <img src="<?php echo base_url(); ?>assets/images/breadcrumb-bg.jpg" alt="user image" class="img-radius cover-img">
                                                 <img src="<?php echo base_url(); ?>assets/images/avatar-2.jpg" alt="user image" class="img-radius profile-img">
                                             </div>
                                         </div>
                                         <div class="col">
                                             <h6 class="m-b-5">John Deo</h6>
                                             <p class="text-muted m-b-0">Lorem Ipsum is simply dummy text.</p>
                                             <p class="text-muted m-b-0"><i class="feather icon-clock m-r-10"></i>2 min ago</p>
                                         </div>
                                     </div>
                                     <div class="text-center">
                                         <a href="#!" class="b-b-primary text-primary">View all Activites</a>
                                     </div>
                                 </div>
                             </div>
                         </div>-->

                    </div>


                </div>
            </div>
        </div>
    </div>
</div>
<?php $this->load->view("admin/common/footer"); ?>
<script src="<?php echo base_url(); ?>assets/admin/bower_components/chart.js/js/Chart.js"></script>
<?php
foreach ($monthly_orders_all as $mo):
    $orders_all[] = $mo["orders"];
endforeach;
foreach ($monthly_orders_pending as $mo):
    $orders_pending[] = $mo["orders"];
endforeach;
foreach ($monthly_orders_completed as $mo):
    $orders_completed[] = $mo["orders"];
endforeach;
?>
<script>

    var config = {
        type: 'line',
        data: {
            labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
            datasets: [
                {
                    label: 'All',
                    backgroundColor: 'rgb(255, 99, 132)',
                    borderColor: 'rgb(255, 99, 132)',
                    data: <?php echo json_encode($orders_all); ?>,
                    fill: false,
                },
                {
                    label: 'Processing',
                    backgroundColor: 'rgb(255, 159, 64)',
                    borderColor: 'rgb(255, 159, 64)',
                    data: <?php echo json_encode($orders_pending); ?>,
                    fill: false,
                },
                {
                    label: 'Completed',
                    backgroundColor: 'rgb(75, 192, 192)',
                    borderColor: 'rgb(75, 192, 192)',
                    data: <?php echo json_encode($orders_completed); ?>,
                    fill: false,
                },
            ]
        },
        options: {
            responsive: true,
            title: {
                display: true,
                text: 'Orders'
            },
            tooltips: {
                mode: 'index',
                intersect: false,
            },
            hover: {
                mode: 'nearest',
                intersect: true
            },
            scales: {
                xAxes: [{
                        display: true,
                        scaleLabel: {
                            display: true,
                            labelString: 'Month'
                        }
                    }],
                yAxes: [{
                        display: true,
                        scaleLabel: {
                            display: true,
                            labelString: 'Value'
                        }
                    }]
            }
        }
    };

    window.onload = function () {
        var ctx = document.getElementById('canvas').getContext('2d');
        window.myLine = new Chart(ctx, config);
    };


</script>