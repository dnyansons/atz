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
</style>

	<div class="container">
	  <h2 class="mt-50">Your Notifications</h2>
	  <br>
     <div class="row">
	 <div class="col-lg-12 px-0 pr-lg-2 mb-2 mb-lg-0">
		<div class="card border-light bg-white card proviewcard shadow-sm">
			<div class="card-header">All Notifications</div>
			<div class="card-body">
				<div class="col-lg-12 p-3 cardlist">
					<div class="col-lg-12">
						<div class="dt-responsive table-responsive">
							<table id="inquiries" class="table table-striped table-bordered nowrap">
								 <thead>
									<tr>
										<th>Sr.no</th>
										<th>Title</th>
										<th>Message</th>
										<th>Type</th>
										<th>Created Date</th>
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
</br></br></br>
<script src="https://code.jquery.com/jquery-1.11.3.min.js"></script>
<script>
   $(function () {
        $('#inquiries').DataTable({
		  "aaSorting": [],
          "paging": true,
          "lengthChange": true,
          "searching": true,
          "ordering": true,
          "info": true,
          "autoWidth": false
        });
      });
</script>

 <script>	  

	$(document).ready(function() {

		var oTable = $('#inquiries').dataTable();
			
		$.ajax({
			url: '<?php echo site_url("buyer/Inquiries/get_inquiries"); ?>',
			dataType: 'json',
			success: function(s){
				oTable.fnClearTable();
				var product_image = '';
				var product_name = '';
				var comment = '';
				var status = '';
				var View = '';
				var short_comment = '';
				for(var i = 0; i <s.inquiries.length; i++) {
				if(s.inquiries[i].status == 'Approved')
				{
					View = '<button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#reply" onclick="getsellerReply('+s.inquiries[i].id+')">Seller Reply</button>';
					status = '<span style="color:green">Approved</span>';
				}else{
					View = '<span style="color:red">Pending</span>';
					status = '<span style="color:red">Pending</span>';
				}
				
				title = s.inquiries[i].name.replace('-', '_', s.inquiries[i].name);
                url_title = s.inquiries[i].name.replace(' ', '-', title);
				product_name = '<a href="<?php echo base_url(); ?>product-details/' + url_title + '/' + s.inquiries[i].for_product + '" title="' + s.inquiries[i].name + '" id="product_name"><b>' + s.inquiries[i].name + '</b></a>';
				
				comment = s.inquiries[i].comment;
				short_comment = '<p title = "'+s.inquiries[i].comment+'">'+comment.substr(0, 40)+'</p>';
				
				 product_image = '<a href="<?php echo base_url(); ?>product-details/' + url_title + '/' + s.inquiries[i].for_product + '" title="' + s.inquiries[i].name + '" id="product_name"><img src="'+s.inquiries[i]['image_url'].url+'" width="100px" height="100px"></a>';

				oTable.fnAddData([
						product_image,
						product_name,
						s.inquiries[i].quantity,
						short_comment+'..',
						status,
						View
						  ]);										
				}
			},
		error: function(e){
			}
		});
	 });
	 


</script>
<?php  $this->load->view('front/common/footer'); ?>