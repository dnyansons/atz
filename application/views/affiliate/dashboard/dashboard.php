<?php $this->load->view("affiliate/dashboard/header"); ?>

<div class="pcoded-content">
    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">
   	                    
                    <div class="row">
                        <div class="col-xl-3 col-md-6">
                            <div class="card bg-c-yellow update-card">
                                <a href="<?php echo base_url(); ?>affiliate/affiliate/affiliateBillingList"><div class="card-block">
                                    <div class="row align-items-end">
                                        <div class="col-8">
                                            <h4 class="text-white"><?php echo number_format($totalCount); ?></h4>
                                            <h6 class="text-white m-b-0">Total Order</h6>
                                        </div>
                                        <div class="col-4 text-right">
                                            <canvas id="update-chart-1" height="50"></canvas>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <p class="text-white m-b-0"><i class="feather icon-clock text-white f-14 m-r-10"></i>Order's Count</p>
                                </div></a>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6">
                            <div class="card bg-c-green update-card">
                                <a href="<?php echo base_url(); ?>affiliate/affiliate/affiliateBillingList"><div class="card-block">
                                    <div class="row align-items-end">
                                        <div class="col-8">
                                            <h4 class="text-white"><?php echo number_format($billingAmount,2); ?></h4>
                                            <h6 class="text-white m-b-0">Total Commission </h6>
                                        </div>
                                        <div class="col-4 text-right">
                                            <canvas id="update-chart-2" height="50"></canvas>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <p class="text-white m-b-0"><i class="feather icon-clock text-white f-14 m-r-10"></i>commission</p>
                                </div></a>
                            </div>
                        </div>

        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $this->load->view("affiliate/dashboard/footer");?>