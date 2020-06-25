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
                           <h4>Send Enquiry</h4>
                           <span></span>
                        </div>
                     </div>
                  </div>
                  <div class="col-lg-4">
                     <div class="page-header-breadcrumb">
                        <ul class="breadcrumb-title">
                           <li class="breadcrumb-item">
                              <a href="<?php echo site_url();?>user"> <i class="feather icon-home"></i> </a> 
                           </li>
                           <li class="breadcrumb-item"><a href="#">Enquiry Action</a></li>
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
					  <form action="<?php echo base_url(); ?>user/myfavourite/send_seller_enquiry" method="post" onsubmit="return validate()" enctype="multipart/form-data">
                        
                        <input type="hidden" name="for_supplier" value="<?php echo $seller_det->user_id; ?>">
						
                        <div class="form-group row">
                           <label class="col-sm-3 col-form-label">To : </label>
                           
						   <div class="col-sm-8">
                            <?php echo $seller_det->first_name.' ( '.$seller_det->company_name.' )';  ?>
						
						  </div>
						   
                        </div>
						<div class="form-group row">
                           <label class="col-sm-3 col-form-label">Enter Details</label>
                           <div class="col-sm-9">
						   <p>Note: Enter product details such as color, size, materials etc. and other specification requirements to receive an accurate quote.</p>
                            <textarea class="form-control" required="" name="comment" placeholder="Enter Details"></textarea>
                              <span id="error_orders_status"></span>
							  
                           </div>
                        </div>
                        <div id="reason_block">
                           <div class="form-group row"  >
                              <label class="col-sm-3 col-form-label">Quantity</label>
                              <div class="col-sm-9">
                                 <input type="number" class="form-control" name="quantity" id="quantity" placeholder="0" required>
                                 <span class="messages"></span>
                              </div>
                           </div>
                           <div class="form-group row"  >
						    <label class="col-sm-3 col-form-label">Unit</label>
                              <div class="card col-sm-9">
								 <select class="form-control" name="unit" required>
								 <option value="">Select Unit</option>
								 <?php 
									foreach($unit_dat as $u)
									{
										echo '<option value="'.$u["units_id"].'">'.$u["units_name"].'</option>';
									}
								 ?>
								 </select>
									
								  </div>
                              </div>
                           </div>
                        </div>
						<div class="modal-footer">
							<input type="submit" class="btn btn-success" value="Send Enuiry">
						</div> 
						</form>
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