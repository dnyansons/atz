 <?php $this->load->view("user/common/header");?>
<div class="pcoded-content">
   <div class="pcoded-inner-content">
      <div class="main-body">
         <div class="page-wrapper">
            <div class="page-header">
               <div class="row align-items-end">
                  <div class="col-lg-8">
                     <div class="page-header-title">
                        <div class="d-inline">
                           <h4>Refund View Detail</h4>
                           <span></span>
                        </div>
                     </div>
                  </div>
                  <div class="col-lg-4">
                     <div class="page-header-breadcrumb">
                        <ul class="breadcrumb-title">
                           <li class="breadcrumb-item">
                              <a href="<?php echo site_url();?>seller/dashboard"> <i class="feather icon-home"></i> </a> 
                           </li>
                           <li class="breadcrumb-item"><a href="#">Order Detail</a></li>
                        </ul>
                     </div>
                  </div>
               </div>
            </div>
            <div class="page-body">
               <div class="row">
                  <div class="col-sm-12">
                     <div class="card">
					  <div class="card-block">
					  <h4 class="title">Order ID # <?php echo $order_id; ?></h4>
					  <!-- Producr Detail -->
					  <!-- Producr Detail -->
					  <div class="dt-responsive table-responsive">
					  <table id="example" class="table table-striped table-bordered nowrap">
					  <tr>
					<th>SR No</th>
					<th>Product Name</th>
					<th>Product Price</th>
					</tr>
					 <?php 
						$sum=0;
						$i=1;			
						foreach($refund as $fund)
						{
							$sum=$sum+$fund->final_price;
							?>
								
								<tr>
									<td><?php  echo  $i; ?></td>
									<td><?php  echo  $fund->products_name; ?></td>
									<td><?php  echo  $fund->final_price; ?></td>
								</tr>
								<tr>
								
						<?php
						 $i++;
						} 
						?>
						<tr>
				
					<th></th>
					<th>Total</th>
					<th><?php echo number_format($sum,2); ?></th>
					</tr>
		
		</table>
		</div>
		  <!--End Producr Detial -->
		    <!-- End Producr Detial -->
					  
					  <hr>
					<div class="card latest-update-card">
<div class="card-header">
<h5>Redund History</h5>

</div>
<div class="card-block">
<div class="latest-update-box">
<?php
foreach($refund_history as $row)
{
?>
	<div class="row p-t-20 p-b-30">
	<div class="col-auto text-right update-meta">
	<p class="text-muted m-b-0 d-inline"><?php echo date('d M H:i',strtotime($row->created_at)); ?></p>
	<i class="feather icon-check bg-simple-c-yellow  update-icon"></i>
	</div>
	<div class="col">
	<h6><?php echo $row->comment; ?></h6>
	<p class="text-muted m-b-0">ATZCart</p>
	</div>
	</div>
<?php } ?>



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
</div>
<?php $this->load->view("user/common/footer");?>
<script>
$(document).ready(function() {
    $('#example').DataTable();
} );


 function validate()
	   {
		   var a=$('#orders_status').val();
		  
		   if(a=='')
		   {
			   $('#error_orders_status').html("<span style='color:red;'>Please Select Order Status !</span>");
			   return false;
		   }else{
			   return true;
		   }
	   }
	   
	   function check_order_status(a)
	   {
		   if(a=='Case Canceled')
		   {
			   $("#reason_block").css("display", "block");
			   $('#error_orders_status').html("");
		   }
		   else{
			    $('#error_orders_status').html("");
			   $("#reason_block").css("display", "none");
		   }
	   }

</script>