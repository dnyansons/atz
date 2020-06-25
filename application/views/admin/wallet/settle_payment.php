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
                                    <h4>Vendor's Payment Settlement</h4>
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
									<li class="breadcrumb-item"><a href="<?php echo site_url(); ?>admin/wallet/vendor">Vendors Payment</a></li>
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
                                    <h5>Vendor's Payment Settlement</h5>
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
													<th>Company Name</th>
													
                                                    <th>Amount</th>
                                                    <th>Settled Date</th>
													<th>Action</th>
                                                </tr>
                                            </thead>
											<tbody>
												<?php $i=0; foreach($payments as $pay){ ?>
													<tr >
														<td><?php echo $i += 1; ?></td>
														<td><span class="badge badge-primary badge-md" data-toggle="popover" data-placement="bottom" title="" data-content="Bank Name : <?php echo $pay['bank_name']; ?> <br>Account Holder : <?php echo $pay['account_holder_name']; ?> <br>Account No : <?php echo $pay['account_no']; ?> <br>IFSC Code : <?php echo $pay['ifsc_code']; ?>"  data-original-title="<?php echo $pay['first_name']; ?>'s Bank Details" aria-describedby="popover195674">Bank Details</span></td>
														<td onclick="get_settled(<?php echo $pay['vendor_id']; ?>)" data-toggle="modal" data-target="#myModal" style="cursor:pointer;"><?php echo $pay['vendor_id']; ?></td>
                                                                                                                <td onclick="get_settled(<?php echo $pay['vendor_id']; ?>)" data-toggle="modal" data-target="#myModal" style="cursor:pointer;"><?php echo $pay['first_name']; ?><?php echo $pay['last_name']; ?></td>
														<td onclick="get_settled(<?php echo $pay['vendor_id']; ?>)" data-toggle="modal" data-target="#myModal" style="cursor:pointer;"><?php echo $pay['company_name']; ?></td>
														
														<td><?php echo $pay['amount']; ?></td>
														<td><?php  $dt=date('d-M-Y',strtotime($pay['settled_date']));
                                                                                                                if($dt=='01-Jan-1970')
                                                                                                                {
                                                                                                                    echo'Pending';
                                                                                                                }else{
                                                                                                                    echo $dt;
                                                                                                                }
                                                                                                                ?></td>
														<td><a href="javascript:void(0)" data-orderid="<?php echo $pay['order_id']; ?>" data-vendorid="<?php echo $pay['vendor_id']; ?>" data-link="<?php echo site_url(); ?>admin/payments/settle" class="badge badge-md badge-success confirmation">Settle</a>
															<a href="javascript:void(0)" data-orderid="<?php echo $pay['order_id']; ?>" data-vendorid="<?php echo $pay['vendor_id']; ?>" data-link="<?php echo site_url(); ?>admin/payments/hold" class="badge badge-md badge-danger holdpay">Hold</a>
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
        
        <!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Pending Settled</h4>
      </div>
      <div class="modal-body">
        <p id="all_settled"></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
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
					data : {order_id:$(this).attr('data-orderid'),vendor_id:$(this).attr('data-vendorid'),reason:value,comingfrom:"available"},
					dataType:'text',
					success : function(data) {
						swal(data);
						if(data != 'Please Enter UTR Number')
						{
							window.setTimeout(function(){location.reload()},2000);
						}
					},
					error : function(request,error)
					{
						swal('Something Went Wrong');
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
                    if(value){
                        var link = $(this).attr('data-link');
                        $.ajax({
                            url : link,
                            type : 'post',
                            data : {order_id:$(this).attr('data-orderid'),vendor_id:$(this).attr('data-vendorid'),reason:value},
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
                    }
		  
		});
	});
</script>
<script>
        function get_settled(vendor)
        { 
        $.ajax({
                    type: 'POST',
                    url: '<?php echo base_url(); ?>admin/payments/get_vendor_wise_settled',
                    data: {'vendor':vendor},
                    success: function (data) {
                        
                      $('#all_settled').html('');
                      $('#all_settled').html(data);

                    },
                    error: function () {
                        alert('Somthing Wrong !');
                    }
                });
        }
    </script>