<?php $this->load->view("admin/common/header"); ?>
<link rel='stylesheet' href="<?php echo base_url();?>assets/bower_components/sweetalert/css/sweetalert.css">
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
                                    <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>admin/wallet/shipping">Wallet</a></li>
									<li class="breadcrumb-item"><a href="<?php echo site_url(); ?>admin/wallet/shipping_pending_payments">Shipper Pending Payments</a></li>
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
                                    <?php echo $this->session->flashdata("message");?>
                                    <div class="dt-responsive table-responsive">
                                        <table id="shippingTable" class="table table-striped table-bordered nowrap">
                                            <thead>
                                                <tr>
                                                    <th>Sr.No.</th>
                                                    <th>Order Id</th>
													<th>Order Amount</th>
                                                    <th>Subtotal</th>
													<th>GST</th>
													<th>Total Shipping Cost</th>
													<th>Payment Status</th>
													<th>Action</th>
                                                </tr>
                                            </thead>
											<tbody>
											<?php $i=0; foreach($allhistory as $ship){ ?>
												<tr>
													<td><?php echo $i +=1; ?></td>
													<td><a class="badge badge-primary" target="new" href="<?php echo base_url(); ?>admin/order/view/<?php echo $ship['orders_id']; ?>">ORD<?php echo $ship['orders_id']; ?></a></td>
													<td><?php echo $ship['order_price']; ?></td>
													<td><?php echo $ship['shipping_subtotal']; ?></td>
													<td><?php echo $ship['shipping_gst']; ?></td>
													<td><?php echo $ship['shipping_cost']; ?></td>
													<td><?php echo $ship['shipping_payment_status']; ?></td>
													<td><?php if($ship['shipping_payment_status']=="Available"){ ?>
														<a href="javascript:void(0)" data-orderid="<?php echo $ship['orders_id']; ?>" data-link="<?php echo site_url(); ?>admin/payments/settleshipping" class="badge badge-md badge-success confirmation">Settle</a>
														<a href="javascript:void(0)" data-orderid="<?php echo $ship['orders_id']; ?>" data-link="<?php echo site_url(); ?>admin/payments/holdshipping" class="badge badge-md badge-danger holdpay">Hold</a>
													<?php } if($ship['shipping_payment_status']=="Hold"){ ?>
														<a href="javascript:void(0)" data-orderid="<?php echo $ship['orders_id']; ?>" data-link="<?php echo site_url(); ?>admin/payments/settleshipping" class="badge badge-md badge-success confirmation">Settle</a>
													<?php } ?>
													</td>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
	<script>
    $(document).ready(function () {
        
        $('.confirmation').click(function(e){
            e.preventDefault();
            swal("Enter UTR Number & Settle:", {
			  content: "input",
			})
			.then((value) => {
			  var link = $(this).attr('data-link');
			  $.ajax({
					url : link,
					type : 'post',
					data : {order_id:$(this).attr('data-orderid'),reason:value,comingfrom:"available"},
					dataType:'text',
					success : function(data) {
                                           
                                                if(data==1)
                                                {
						swal('Payment Settled for this Order');
						location.reload();
                                              }else{
                                                  swal('Please Enter UTR Number');
                                              }
					},
					error : function(request,error)
					{
						swal('Payment Settlement Failed');
					}
				});
			});
        });
        
        
        $("#requestsTable").DataTable();
    });
	
	$('.holdpay').click(function(){
		swal("Enter Reason For Holding Payment:", {
		  content: "input",
		})
		.then((value) => {
		  var link = $(this).attr('data-link');
		  $.ajax({
				url : link,
				type : 'post',
				data : {order_id:$(this).attr('data-orderid'),reason:value},
				dataType:'text',
				success : function(data) {
					swal(data);
					location.reload();
				},
				error : function(request,error)
				{
					swal('Something Went Wrong');
				}
			});
		});
	});
</script>
<script>
    $(document).ready(function() {
    $('#shippingTable').DataTable();
} );
    </script>