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
                                    <h4>Vendor's Payment On Hold(Dispute)</h4>
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
									<li class="breadcrumb-item"><a href="<?php echo site_url(); ?>admin/wallet/vendor">Vendors Payment On Hold(Dispute)</a></li>
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
                                    <h5>Vendor's Payment On Hold(Dispute)</h5>
                                </div>
                                <div class="card-block">
                                    <?php echo $this->session->flashdata("message");?>
                                    <div class="dt-responsive table-responsive">
                                        <table id="categoryTable" class="table table-striped table-bordered nowrap">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
													<th>Bank Details</th>
													<th>Vendor ID</th>
                                                    <th>Vendor's Name</th>
													<th>Cpmpany Name</th>
													<th>Order Id</th>
                                                    <th>Amount</th>
													<th>Action</th>
                                                </tr>
                                            </thead>
											<tbody>
												<?php $i=0; foreach($payments as $pay){ ?>
													<tr>
														<td><?php echo $i += 1; ?></td>
														<td><span class="badge badge-primary badge-md" data-toggle="popover" data-placement="bottom" title="" data-content="Bank Name : <?php echo $pay['bank_name']; ?> <br>Account Holder : <?php echo $pay['account_holder_name']; ?> <br>Account No : <?php echo $pay['account_no']; ?> <br>IFSC Code : <?php echo $pay['ifsc_code']; ?>"  data-original-title="<?php echo $pay['first_name']; ?>'s Bank Details" aria-describedby="popover195674">Bank Details</span></td>
														<td><?php echo $pay['vendor_id']; ?></td>
														<td><?php echo $pay['first_name']; ?><?php echo $pay['last_name']; ?></td>
														<td><?php echo $pay['company_name']; ?></td>
														<td>ORD<?php echo $pay['order_id']; ?></td>
														<td><?php echo $pay['amount']; ?></td>
														<td><a href="javascript:void(0)" data-orderid="<?php echo $pay['order_id']; ?>" data-vendorid="<?php echo $pay['vendor_id']; ?>" data-link="<?php echo site_url(); ?>admin/payments/settle" class="badge badge-md badge-success confirmation">Settle</a>
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
        $(document).ready(function() {
            $('[data-toggle="tooltip"]').tooltip();
        });

        $(document).ready(function() {
            $('[data-toggle="popover"]').popover({
                html: true,
                content: function() {
                    return $('#primary-popover-content').html();
                }
            });
        });

    </script>
	<script>	
	$('.confirmation').click(function(){
		swal("Enter UTR Number & Settle:", {
		  content: "input",
		})
		.then((value) => {
		  //swal(`You typed: ${value}`);
		  var link = $(this).attr('data-link');
		  $.ajax({
				url : link,
				type : 'post',
				data : {order_id:$(this).attr('data-orderid'),vendor_id:$(this).attr('data-vendorid'),reason:value,comingfrom:"hold"},
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