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
<div class="container">
	<ol id="breadcrumb_CNEP" class="a-ordered-list a-horizontal breadcrumb mt-20">
			<li class="breadcrumb-item "><span class="a-list-item ">
				<a class="a-link-normal" href="<?php echo base_url(); ?>buyer-dashboard">
				Your Account
				</a>
				</span>
			</li>
			
			<li class="breadcrumb-item active"><span class="a-list-item a-color-state">
				Your Payment
				</span>
			</li>
		</ol>
    <h2 class="mt-35">Your Payment</h2>
    <h6 style="text-align:center;"><?php echo $this->session->flashdata('message'); ?></h6>
    <br>
   
    <!-- Tab panes -->
    <div class="tab-content">

        <div id="home" class="tab-pane active"><br>
            <div class="row">
                <div class="col-lg-12 px-0 pr-lg-2 mb-2 mb-lg-0">
                    <div class="card border-light bg-white card proviewcard shadow-sm">
                        <div class="card-header">All Order Payment</div>
                       
                        <div class="card-body">
                             <div class="col-lg-12 px-0 pr-lg-2 mb-2 mb-lg-0">
                                  <br>
                            <table id="payment"  class="table table-bordered table-striped" style="width:100%">
					<thead>
						<tr>
							<th>Sr. No.</th>
							<th>Order ID</th>
							<th>Email</th>
							<th>Contact</th>
							<th>Amount</th>
							<th>Method</th>
							<th>Status</th>
							<th>Date</th>
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
<br><br><br><br>
<script src="https://code.jquery.com/jquery-1.11.3.min.js"></script>
<script>
   $(function () {
        $('#payment').DataTable({
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

		var oTable = $('#payment').dataTable();
			
		$.ajax({
			url: '<?php echo site_url("buyer/payment/get_payments"); ?>',
			dataType: 'json',
			success: function(s){
				console.log(s);
				oTable.fnClearTable();
				var count = 0;
				for(var i = 0; i <s.ord_pay.length; i++) {
				count++;

				oTable.fnAddData([
						count,
						s.ord_pay[i].orders_id,
						s.ord_pay[i].email,
						s.ord_pay[i].contact,
						s.ord_pay[i].amount,
						s.ord_pay[i].method,
						s.ord_pay[i].status,
						s.ord_pay[i].cr_date,
						  ]);	
                				  
				}
			},
		error: function(e){
			}
		});
	 });
</script>