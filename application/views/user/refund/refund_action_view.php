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
                           <h4>Refund Action From Supplier</h4>
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
                           <li class="breadcrumb-item"><a href="#">Refund Action</a></li>
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
					  <form action="<?php echo base_url(); ?>seller/refund/action_on_refund" method="post" onsubmit="return validate()" enctype="multipart/form-data">
                        <input type="hidden" name="orders_id" value="<?php echo $order_id; ?>">
                        <div class="form-group row">
                           <label class="col-sm-3 col-form-label">Select Action</label>
                           <div class="col-sm-9">
                              <select class="form-control" name="orders_status" id="orders_status" onchange="check_order_status(this.value)">
                                 <option value="">--Select Status --</option>
                                 <option value="Approved by Supplier">Approved by Supplier</option>
                                 <option value="Case Canceled">Case Canceled</option>
                              </select>
                              <span id="error_orders_status"></span>
                           </div>
                        </div>
                        <div id="reason_block" style="display:none;">
                           <div class="form-group row"  >
                              <label class="col-sm-3 col-form-label">Any Reason</label>
                              <div class="col-sm-9">
                                 <input type="text" class="form-control" name="supplier_reason" id="supp_reason" placeholder="Reason">
                                 <span class="messages"></span>
                              </div>
                           </div>
                           <div class="form-group row"  >
						    <label class="col-sm-3 col-form-label">Upload Evidence</label>
                              <div class="card col-sm-9">
                                 <div class="card-block">
                                    <input type="file" name="userFiles[]" id="filer_input" multiple="multiple">
                                 </div>
                                 <div id="styleSelector"></div>
                              </div>
                           </div>
                        </div>
						<div class="modal-footer">
							<input type="submit" class="btn btn-success" value="Submit">
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