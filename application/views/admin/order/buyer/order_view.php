  <?php $this->load->view("admin/common/header");?>
  <style>
  .checked_star {
  color: orange;
}
  </style>
<div class="pcoded-content">
    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-header">
                    <div class="row align-items-end">
                        <div class="col-lg-8">
                            <div class="page-header-title">
                                <div class="d-inline">
                                    <h4>Orders View Detail </h4>
                                    <span>Status : <?php echo $sorder["orders_status_name"]; ?></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="page-header-breadcrumb">
                                <ul class="breadcrumb-title">
                                    <li class="breadcrumb-item">
                                        <a href="<?php echo site_url();?>user"> <i class="feather icon-home"></i> </a>
                                    </li>
                                    <li class="breadcrumb-item"><a href="#">My Order Detail</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="page-body">
                    <div class="row">
                        <div class="col-sm-12">

                            <div class="card">
							<h6 style="text-align:center;"><?php echo $this->session->flashdata('message'); ?></h6>
                                
                                <div class="card-block">
                                    <div class="dt-responsive table-responsive">
                                     
										
		<table class="table table-striped table-bordered nowrap dataTable">
		 <tr class="alert alert-info"> 
		 <th>SrNo</th> 
		 <th>Product</th> 
		 <th>Quantity</th> 
		 <th>Price</th> 
		 <th>Tax</th> 
		 <th>Sub Total</th> 
		 <th>Review</th> 
		 </tr>
<?php		 
		$i=1;
		foreach($products as $row)
		{
				 echo'<tr> 
				
					 <th>'.$i.'</th> 
					 <th>'.$row["products_name"].'</th> 
					 <th>'.$row["products_quantity"].'</th> 
					 <th>'.$row["products_price"].'</th> 
					 <th>'.$row["products_tax"].'</th> 
					 <th>'.$row["final_price"].'</th> 
					 <th><button type="button" onclick="view_review('.$row["products_id"].')" class="btn btn-info btn-sm" data-toggle="modal" data-target="#myReview"><i class="fa fa-eye"></i></button></th> 
				 </tr>'; 
			$i++;
		}
		 echo'<tr> 
					 <th colspan="3">Status</th> 
					 <td colspan="4">'.$sorder["orders_status_name"].'</td> 
				 </tr> 
				 <tr> 
					 <th colspan="3">Delivery Address</th> 
					 <td colspan="4"><b>'.$sorder["delivery_name"].'</b> ,<br>'.$sorder["delivery_street_address"].' ,'.$sorder["delivery_city"].' ,<br>'.$sorder["delivery_postcode"].' ,'.$sorder["delivery_state"].'</td> 
				 </tr> 
				 <tr> 
					 <th colspan="3" >Payment Method</th> 
					 <td colspan="4">'.$sorder["payment_method"].'</td> 
				 </tr>
				 <tr> 
					 <th colspan="3" >Shipping Method</th> 
					 <td colspan="4">'.$sorder["shipping_method"].'</td> 
				 </tr>
				 <tr> 
					 <th colspan="3" >Currency</th> 
					 <td colspan="4">'.$sorder["currency"].'</td> 
				 </tr>
				 <tr> 
					 <th colspan="3" >Order Date</th> 
					 <td colspan="4">'.date('d M Y H:i',strtotime($sorder["date_purchased"])).'</td> 
				 </tr>'; 
		
		?>
		
		 </table>	
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
		
		
		<!-- Modal Product View -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Order View</h4>
      </div>
      <div class="modal-body">
        <p id="myorder"></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>

		<!-- Modal Review View -->
<div id="myReview" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Product Review</h4>
      </div>
      <div class="modal-body">
        <p id="myreview"></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>
		

        
    </div>
</div>
<?php $this->load->view("user/common/footer");?>
<script>

	   //View Review 
function view_review(products_id)
	   {
		 
		 $.ajax({
						type:'POST',
						url :'<?php echo base_url(); ?>admin/users/review_view',
						data: {'products_id':products_id},
						success:function(data){
						$('#myreview').html('');
						$('#myreview').html(data);
							
						},
						error:function(){
							alert('Somthing Wrong !'); 
						}
					});
	   }


</script>