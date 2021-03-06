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
                                    <h4>All refund requests</h4>
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
                                    <li class="breadcrumb-item"><a href="#">Refund Request List</a></li>
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
                                        <table id="orderTable" class="table table-striped table-bordered nowrap">
                                            <thead>
                                                <tr>
                                                    <th>Order ID</th>
                                                    <th>Refund Request Amount</th>
                                                    <th>Refund Amount</th>
                                                    <th>Status</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
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
<div id="myRefund" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Refund Detail View</h4>
      </div>
      <div class="modal-body">
        <p id="myrefund"></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>


		<!-- Supplier Evidence Model -->
<div id="suppEvidence" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Supplier Evidence</h4>
      </div>
      <div class="modal-body">
        <p id="supp_evidence"></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
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
 $(document).ready(function () {
    $('#orderTable').DataTable({
        processing: true,
        serverSide: true,
        ajax:{
                 url: "<?php echo base_url('seller/refund/all_request_ajax_list') ?>",
                 dataType: "json",
                 type: "POST",
                 data:{  '<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>' } },
                 columns: [
                      { data: "orders_id" },
                      { data: "final_price" },
                      { data: "refund_amount" },
                      { data: "orders_status" },
                      { data: "action" },
                   ]	 

        });
});


//View Product 
function view_refund(ch)
	   { 
		  $.ajax({
						type:'POST',
						url :'<?php echo base_url(); ?>seller/refund/refund_view',
						data: {'order_id':ch},
						success:function(data){
						
						$('#myrefund').html('');
						$('#myrefund').html(data);
							
						},
						error:function(){
							alert('Somthing Wrong !'); 
						}
					});
	   }
	   
	   
	   //Supplier Evidence 
function supp_evidence(ch)
	   { 
		  
		  $.ajax({
						type:'POST',
						url :'<?php echo base_url(); ?>seller/refund/supp_evidence_view',
						data: {'orders_id':ch},
						success:function(data){
						
						$('#supp_evidence').html('');
						$('#supp_evidence').html(data);
							
						},
						error:function(){
							alert('Somthing Wrong !'); 
						}
					});
	   }
	   
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