<?php  $this->load->view('front/common/header'); ?>
<style>
   body{
	   height:auto;
   }
   
.card{
    border-radius: 0;
}
.card .card-header{
    background-color: #fff;
    font-size: 18px;
    padding: 10px 16px;
}
.proviewcard .card-body{
    padding: 0;
}
.cardlist{
    border-bottom: 1px solid #f0f0f0;
}
.cardlist:last-child{
    border: 0;
}
.addcartimg{
    height: 100px;
}
.cartproname{
    font-size: 15px;
    color: #212529;
    line-height: 1;
    display: inline;
}
.cartproname:hover{
    color: #c16302;
    text-decoration: none;
}
.seller{
    font-size: 12px;
    color: #666;
    margin-bottom: 5px;
    line-height: 1;
}
.cartviewprice{
    margin-bottom: 8px;
    line-height: 1;
}
.cartviewprice span{
    display: inline-block;
    padding-right: 10px;
    margin-bottom: 5px;
}
.cartviewprice .amt{
    font-size: 18px;
    font-weight: 600;
}
.cartviewprice .oldamt{
    color: #757575;
    font-weight: 600;
    text-decoration: line-through;
}
.cartviewprice .disamt{
    font-weight: 600;
    color: #c16302;
}
.qty .input-group{
    width: 100%;
    height: 25px;
}
.btn-qty{
    height: 25px;
    color: #fff !important;
    background-color: #555 !important; 
    border-color: #555 !important;
    padding: 0px 3px !important;
}
.qty input{
    height: 25px;
}
.addcardrmv{
    font-size: 14px;
    line-height: 1.8;
    text-transform: uppercase;
    color: #212529;
}
.addcardrmv:hover{
    color: #c16302;
    text-decoration: none;
    font-weight: 600;
}
.prostatus .del-time {
    font-size: 12px;
    color: #757575;
    margin-right: 10px;
}
.prostatus .del-time > span {
    font-weight: 600;
    color: #555;
}
.proviewcard .card-footer{
    text-align: center;
    box-shadow: rgba(0, 0, 0, 0.1) 0px -2px 10px 0px;
    padding: 8px 15px;
}


.card .card-footer{
    background-color: #fff;
}

/*Card Footer Fixed*/
@supports (box-shadow: 2px 2px 2px black){
  .cart-panel-foo-fix{
    position: sticky;
    bottom: 0;
    z-index: 9;
  }
}

.btn-cust {
    background-color: #fff;
    color: #212121;
    box-shadow: rgba(0, 0, 0, 0.1) 0px 2px 2px 0px;   
    font-weight: 500;   
    order-radius: 2px;
    border-width: 1px;
    border-style: solid;
    border-color: #E0E0E0;
    border-image: initial;
    font-size: 14px;
    padding: 5px 7px;
    min-width: 130px;
}
.btn-cust:hover {
    background-color: #c74b14 !important;
    color: #fff !important;
}
.nav-pills .nav-link.active, .nav-pills .show>.nav-link {
    color: #fff;
    background-color: #007bff;
    padding: 10px;
}
.nav {
    width: 100%;
    height: 40px !important;
    background-color: #FFF;
    box-shadow: 0 2px 2px rgba(0, 0, 0, .12);
    z-index: 1000;
}

.nav-link {
    display: block;
    padding: .7rem 1rem;
}

.nav-pills .nav-link.active, .nav-pills .show>.nav-link {
    color: #716666;
    background-color:none !important;
    padding: 10px;
    border-bottom: 2px solid #007bff;
	
}

.nav-pills .nav-link.active, .nav-pills .show>.nav-link {
  
    background:none !important;
 
}

.nav-pills .nav-link {
    border-radius:0px; 
}
a:focus
{
	outline:none;
}

input, textarea, select
{
	border:1px solid #ccc !important;
}

.modal-dialog {
    margin: 1.75rem auto;
}
</style>


<!-- Services section -->
<div class="container">
	<ol id="breadcrumb_CNEP" class="a-ordered-list a-horizontal breadcrumb mt-20">
			<li class="breadcrumb-item "><span class="a-list-item ">
				<a class="a-link-normal" href="<?php echo base_url(); ?>buyer-dashboard">
				Your Account
				</a>
				</span>
			</li>
			
			<li class="breadcrumb-item active"><span class="a-list-item a-color-state">
				Your RFQ's
				</span>
			</li>
		</ol>
		
  <h2 class="mt-35">Your RFQ's</h2>
  <br>
  <!-- Nav pills -->
  <ul class="nav nav-pills" role="tablist">
    <li class="nav-item">
      <a class="nav-link active" data-toggle="pill" href="#home"> Pending</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" data-toggle="pill" href="#menu1"> Approved </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" data-toggle="pill" href="#menu2"> Rejected</a>
    </li>
  </ul>

							
						
  <!-- Tab panes -->
  <div class="tab-content">
  
    <div id="home" class="tab-pane active"><br>
     <div class="row">
	 <div class="col-lg-12 px-0 pr-lg-2 mb-2 mb-lg-0">
		<div class="card border-light bg-white card proviewcard shadow-sm">
			<div class="card-header">Pending RFQs</div>
			<div class="card-body">
				<div class="col-lg-12 p-3 cardlist">
					<div class="col-lg-12">
						<div class="dt-responsive table-responsive">
							<table id="pending" class="table table-striped table-bordered nowrap">
								 <thead>
									<tr>
										<th>Sr.No</th>
										<th>Product Name</th>
										<th>Quantity</th>
										<th>Unit</th>
										<th>Description</th>
										<th>Added Date</th>
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
	
    <div id="menu1" class="tab-pane fade"><br>
     <div class="row">
	 <div class="col-lg-12 px-0 pr-lg-2 mb-2 mb-lg-0">
		<div class="card border-light bg-white card proviewcard shadow-sm">
			<div class="card-header">Approved RFQs</div>
			<div class="card-body">
				<div class="col-lg-12 p-3 cardlist">
					<div class="col-lg-12">
						<div class="dt-responsive table-responsive">
							<table id="approved" class="table table-striped table-bordered nowrap">
								 <thead>
									<tr>
										<th>Sr.No.</th>
										<th>Product Name</th>
										<th>Quantity</th>
										<th>Unit</th>
										<th>Description</th>
										<th>Added Date</th>
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
	
    <div id="menu2" class=" tab-pane fade"><br>         
     <div class="row">
	 <div class="col-lg-12 px-0 pr-lg-2 mb-2 mb-lg-0">
		<div class="card border-light bg-white card proviewcard shadow-sm">
			<div class="card-header">Rejected RFQs</div>
			<div class="card-body">
				<div class="col-lg-12 p-3 cardlist">
					<div class="col-lg-12">
						<div class="dt-responsive table-responsive">
							<table id="rejected" class="table table-striped table-bordered nowrap">
								 <thead>
									<tr>
										<th>Sr.No</th>
										<th>Product Name</th>
										<th>Quantity</th>
										<th>Unit</th>
										<th>Description</th>
										<th>Added Date</th>
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
  </div>
 
</div>
  <div id="reply" class="modal fade"  role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title m-1 p-0" >Seller Reply</h3>
            </div>
          
			<div class="modal-body" id="rfq_rply" style="max-height: 380px; overflow-y: scroll;">
			   
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-sm btn-default" data-dismiss="modal">Close</button>
			</div>    
        </div>

    </div>
</div>

<br><br><br>
<script src="https://code.jquery.com/jquery-1.11.3.min.js"></script>
<script>
   $(function () {
        $('#pending #approved #rejected').DataTable({
		  "aaSorting": [],
          "paging": true,
          "lengthChange": true,
          "searching": true,
          "ordering": true,
          "info": true,
          "autoWidth": true
        });
      });
</script>

 <script>	  

	$(document).ready(function() {

		var oTable1 = $('#pending').dataTable();
		var oTable2 = $('#approved').dataTable();
		var oTable3 = $('#rejected').dataTable();
		
		$.ajax({
			url: '<?php echo site_url("buyer/rfqs/get_RFQsStatus"); ?>',
			dataType: 'json',
			success: function(s){
				oTable1.fnClearTable();
				oTable2.fnClearTable();
				oTable3.fnClearTable();
				var status = '';
				var short_desc = '';
				var description = '';
				var Count = 0;
				for(var i = 0; i <s.pending.length; i++) {
			    Count++;
                            var astatus=s.pending[i].status;
                            if(s.pending[i].status=='SellerReplied')
                            {
                                astatus='Pending';
                            }
				status =  '<span style="color:red">'+astatus+'</span>';
				description = s.pending[i].description;
				short_desc = '<p title="'+description+'">'+description.substr(0, 40)+'</p>';
				oTable1.fnAddData([
						Count,
						s.pending[i].looking_for,
						s.pending[i].quanity,
						s.pending[i].units_name,
						short_desc+'..',
						s.pending[i].added_date,
						status,
						status
						  ]);										
					}
					
				
				var Count_t = 0;
				var action = '';
				for(var i = 0; i <s.approved.length; i++) {
				Count_t++;
				action = '<button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#reply" onclick="getsellerReply('+s.approved[i].id+')">Seller Reply</button>';
				status =  '<span style="color:green">'+s.approved[i].status+'</span>';
				
				description = s.approved[i].description;
				short_desc = '<p title="'+description+'">'+description.substr(0, 40)+'</p>';
				oTable2.fnAddData([
						Count_t,
						s.approved[i].looking_for,
						s.approved[i].quanity,
						s.approved[i].units_name,
						short_desc+'..',
						s.approved[i].added_date,
						status,
						action
						  ]);										
					}
					
				var Cnt = 0;
				for(var i = 0; i <s.rejected.length; i++) {
				Cnt++;
				description = s.rejected[i].description;
				short_desc = '<p title="'+description+'">'+description.substr(0, 40)+'</p>';
				status =  '<span style="color:red">'+s.rejected[i].status+'</span>';
				oTable3.fnAddData([
						Cnt,
						s.rejected[i].looking_for,
						s.rejected[i].quanity,
						s.rejected[i].units_name,
						short_desc+'.......',
						s.rejected[i].added_date,
						status,
						status
						  ]);										
					}
			},
		error: function(e){
			}
		});
	 });
	 
function getsellerReply(id)
{
	$.ajax({
			url: '<?php echo site_url("buyer/Rfqs/getSellerReply"); ?>',
			type : 'POST',
			data : {'rfqs_id' : id},
			success: function(s){
			  var data = JSON.parse(s);
			  var html_data = '';
			  var count = 0;
			  if(data){
				 
				  html_data = '<table class="table table-striped table-bordered"><thead style="background-color:#bd081b; color:#ffff"><tr><th>sr.No</th><th>Seller Name</th><th>Quantity</th><th>Price</th><th>Comment</th><th>Added Date</th></tr></thead><tbody>';
				  
				  $.each(data, function(inx, obj){
                                      var hike_price=Number(obj.price)+Number((obj.price*obj.admin_hike/100));
					  count++;
					  html_data += '<tr><td>'+count+'</td><td>'+obj.first_name+' '+obj.last_name+'</td><td>'+obj.quantity+'</td><td>'+hike_price+'</td><td>'+obj.comment+'</td><td>'+obj.added_date+'</td></tr>';

				  });
				  html_data += '</tbody></table>';
				  $("#rfq_rply").html(html_data);
			  }
			  
			},
			error: function(e){
				
			}
		});
}
</script>
<?php  $this->load->view('front/common/footer'); ?>