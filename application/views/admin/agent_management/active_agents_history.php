<?php $this->load->view("admin/common/header");?>
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
    max-width:500px; 
    margin: 1.75rem auto;
}

</style>


<!-- Services section -->
<div class="pcoded-content">
    <div class="pcoded-inner-content">
	 <div class="main-body">
	  <div class="page-wrapper">
		<div class="page-header">
                    <div class="row align-items-end">
                        <div class="col-lg-8">
                            <div class="page-header-title">
                                <div class="d-inline">
                                    <h4>Approved Products & Approved Vendors</h4>	
                                    <span></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="page-header-breadcrumb">
                                <ul class="breadcrumb-title">
                                    <li class="breadcrumb-item">
                                        <a href="<?php echo site_url();?>admin/dashboard"> <i class="feather icon-home"></i> </a>
                                    </li>
                                    <li class="breadcrumb-item">History</li>
                                </ul>
								   
                            </div>
                        </div>
                    </div>
                </div>
	  <!-- Nav pills -->
	  <ul class="nav nav-pills" role="tablist">
		<li class="nav-item">
		  <a class="nav-link active" data-toggle="pill" href="#home" id="first_tab"> Products</a>
		</li>
		<li class="nav-item">
		  <a class="nav-link" data-toggle="pill" href="#menu1" id="second_tab"> Vendors </a>
		</li>
	  </ul>

							
						
  <!-- Tab panes -->
  <div class="tab-content">
  
    <div id="home" class="tab-pane active"><br>
		<div class="page-body">
			<div class="row">
				<div class="col-sm-12">
					<div class="card">
						<div class="card-header">
							<h5>Approved Products</h5>
													
						</div>
						<div class="card-block">
							<div class="dt-responsive table-responsive">
								<table id="active_agents" class="table table-striped table-bordered nowrap">
									 <thead>
										<tr>
											<th>Sr.No.</th>
											<th>Product Id</th>
											<th>Product Name</th>
											<th>Approved Date</th>
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
	
    <div id="menu1" class="tab-pane"><br>
     <div class="page-body">
			<div class="row">
				<div class="col-sm-12">
					<div class="card">
						<div class="card-header">
							<h5>Approved Vendors</h5>
													
						</div>
						<div class="card-block">
							<div class="dt-responsive table-responsive">
								<table id="inactive_agents" class="table table-striped table-bordered nowrap">
									 <thead>
										<tr>
											<th>Sr.No</th>
											<th>Vendor Id</th>
											<th>Vendor Name</th>
											<th>Approved Date</th>
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
</div>
</div>
<?php $this->load->view("admin/common/footer");?>
<script>
$('#first_tab').click(function(){
	$('#menu1').hide();
	$('#home').show();
});

$('#second_tab').click(function(){
	$('#home').hide();
	$('#menu1').show();
});

   $(function () {
        $('#active_agents #inactive_agents').DataTable({
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
		var id = '<?php echo $id; ?>';
		var oTable1 = $('#active_agents').dataTable();
		var oTable2 = $('#inactive_agents').dataTable();
		$.ajax({
			url: '<?php echo site_url("admin/agent_management/get_historyActiveAgent/");?>'+id,
			dataType: 'json',
			success: function(s){
				console.log(s);
				oTable1.fnClearTable();
				oTable2.fnClearTable();
				var Count = 0;
				for(var i = 0; i <s.result.length; i++) {
			    Count++;
				oTable1.fnAddData([
						Count,
						s.result[i].id,
						s.result[i].name,
						s.result[i].approved_on
						  ]);										
					}
					
				
				var Count_t = 0;
				for(var i = 0; i <s.vendors.length; i++) {
				Count_t++;
				oTable2.fnAddData([
						Count_t,
						s.vendors[i].id,
						s.vendors[i].first_name+' '+s.vendors[i].last_name,
						s.vendors[i].updated_on
						  ]);										
					}
			},
		error: function(e){
			}
		});
	 });
</script>