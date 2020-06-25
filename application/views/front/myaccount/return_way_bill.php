<?php $this->load->view("front/common/header");?>
<div class="pcoded-content">
    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-header">
                    <div class="row align-items-end">
                        <div class="col-lg-8">
                            <div class="page-header-title">
                                <div class="d-inline">
                                    <h4>Order Way Bill (Order #<?php echo $order_id; ?>)</h4>
                                    <span></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="page-header-breadcrumb">
                                <ul class="breadcrumb-title">
                                    <li class="breadcrumb-item">
                                        <a href="<?php echo site_url(); ?>user/dashboard"> <i class="feather icon-home"></i> </a>
                                    </li>
                                    <li class="breadcrumb-item"><a href="#">Orders AWB</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="card">
                    <div class="card-header">
                        <div class="row">
						<iframe style="width:100%;height:950px;" src="<?php echo base_url(); ?>return_wayBill_generate/waybill_<?php echo $order_id; ?>.pdf"></iframe>
						</div>
						
					</div>
				</div>
			</div>
		</div>
		</div>
		</div>
<?php $this->load->view("front/common/footer"); ?>
