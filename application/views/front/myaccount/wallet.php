<?php $this->load->view('front/common/header');;?>
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
    #tabs .nav-tabs .nav-item.show .nav-link, .nav-tabs .nav-link.active {
    color: #000;
    background-color: transparent;
    border-color: transparent transparent #f3f3f3;
    //border-bottom: 1px solid !important;
    font-size: 16px;
    font-weight: bold;
    width:100px;
    }
    #tabs .nav-tabs .nav-link {
    //border: 1px solid transparent;
    border-top-left-radius: .25rem;
    border-top-right-radius: .25rem;
    color: #000;
    font-size:16px;
    width:100px;
    }
    .nav{width:40%;}
    div.dataTables_wrapper div.dataTables_filter label {
    justify-content: flex-end;
    align-items: center;
    display: flex;
    }

</style>
<section id="tabs" class="">
    <!-- Services section -->
    <div class="container  bg-white">
    <ol id="breadcrumb_CNEP" class="a-ordered-list a-horizontal breadcrumb mt-20 bg-white">
        <li class="breadcrumb-item "><span class="a-list-item ">
            <a class="a-link-normal" href="<?php echo base_url(); ?>buyer-dashboard">
            Your Account
            </a>
            </span>
        </li>
        <li class="breadcrumb-item active"><span class="a-list-item a-color-state">
            Your Wallet
            </span>
        </li>
    </ol>

    <h2 class="mt-35">Your Wallet</h2>
    <h6 style="text-align:center;"><?php echo $this->session->flashdata('message'); ?></h6>
    <br>
    <div class="row">
        <div class="col-lg-12">
            <div class="card border-light card proviewcard shadow-sm">
                <h3 class="text-right" style="margin-right:10px;" id="balance" >
                    Total Wallet Amount : <?php $balance=0; if($bal->balance > 0){ echo $bal->balance; }else{
                        echo $balance;
                    } ?>
                </h3>
                <a style="cursor:pointer;" class="text-right" id="popup" data-toggle="modal" data-target="#wallet_request">
                <i class="icon ion-android-add" style="font-size:14px;text-align: right;color:green;"> Withdraw Request</i>
                </a>
                <br><br>
            </div>
        </div>
    </div>
    <nav>
        <div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">
            <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="nav-home" aria-selected="true">Wallet History</a>
            <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false">Withdraw Request</a>
        </div>
    </nav>
    <!-- Tab panes -->
    <div class="tab-content" id="nav-tabContent">
        <div id="home" class="tab-pane fade show active" role="tabpanel" aria-labelledby="nav-home-tab">
            <br>                     
            <!-- <div class="card-header h6">Wallet History</div>-->
            <div class="card-body">
                <div id="display_messege" ></div>
                <div class="col-lg-12 px-0 pr-lg-2 mb-2 mb-lg-0">
                    <br>
                    <table  id= "wallet" class="table table-bordered table-striped" style="width:100%">
                        <thead>
                            <tr>
                                <th>Sr.No</th>
                                <th>Amount</th>
                                <th>Type</th>
                                <th>Against</th>
                                <th>Created On</th>
                                <th>Remark</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
        <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
            <div id="home" class="tab-pane fade show active" role="tabpanel" aria-labelledby="nav-home-tab">
                <br>                     
                <!-- <div class="card-header h6">Wallet History</div>-->
                <div class="card-body">
                    <div class="col-lg-12 px-0 pr-lg-2 mb-2 mb-lg-0">
                        <br>
                        <table  id="withdraw" class="table table-bordered table-striped" style="width:100%">
                            <thead>
                                <tr>
                                    <th>SrNo</th>
                                    <th>Amount</th>
                                    <th>Status</th>
                                    <th>Created</th>
                                </tr>
                            </thead>
                            <?php
                                $i=1;
                                foreach($withdraw_req as $dat)
                                {
                                    echo'<tr>';
                                    echo'<td>'.$i.'</td>';
                                    echo'<td>'.$dat["amount"].'</td>';
                                    echo'<td>'.$dat["status"].'</td>';
                                    echo'<td>'.date('d M Y H:i',strtotime($dat["created_at"])).'</td>';
                                    echo'</tr>';
                                    $i++;
                                }
                                ?>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div id="wallet_request" class="modal"  role="dialog">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" >Withdraw Request</h4>
                        <span style="color:red;font-size: 12px;float:right;margin-top: 25px;">(* Required )</span>
                    </div>
                    <form class="form-horizontal" action="<?php echo base_url(); ?>" method="post" id="form_id" >
                        <div class="modal-body">
                            <div class="row">
                                <div class="col">
                                    <div class="form-group">
                                        <label for="contact_person">Your Balance (<i class="fa fa-inr"></i>)</label>
                                        <b><?php $balance="0.00"; if($bal->balance){ echo $bal->balance; }else{ echo $balance; } ?></b>
                                    </div>
                                    <p id="error_contact_person" style="color:red;"></p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <div class="form-group">
                                        <label for="contact_person">Request Amount<span style="color:red">*</span></label>
                                        <input type="text" class="form-control" name="request_amount" id="request_amount" value="0">
                                    </div>
                                    <p id="error_contact_number" style="color:red;"></p>
                                </div>
                            </div>
                            <p id="p_error" style="text-align:center;color:red;"></p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Close</button>
                            <button type="button" onclick="check_balance();" class="btn btn-sm btn-danger" id="btnSubmit" >Request</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<br><br><br><br>
<script src="https://code.jquery.com/jquery-1.11.3.min.js"></script>
<script>
    $(function () {
         $('#wallet').DataTable({
             aaSorting: [],
             paging: true,
             lengthChange: true,
             searching: true,
             ordering: true,
             info: true,
             autoWidth: false,
             
         });
       });
    $(function () {
         $('#withdraw').DataTable({
             aaSorting: [],
             paging: true,
             lengthChange: true,
             searching: true,
             ordering: true,
             info: true,
             autoWidth: false,
             
         });
       });
</script>
<script>
    $(document).ready(function() {
    	var oTable = $('#wallet').dataTable();
    	$.ajax({
    		url: '<?php echo site_url("buyer/wallet/get_wallets"); ?>',
    		dataType: 'json',
    		success: function(s){
    			console.log(s);
    			oTable.fnClearTable();
    			var count = 0;
    			var balance = 0.00;
    			for(var i = 0; i <s.length; i++) {
    			count++;
    			balance ='INR '+ s[i]['balance'],
    			oTable.fnAddData([
    					count,
    					s[i]['amount'],
    					s[i]['transaction_type'],
    					s[i]['against'], s[i]['createddate'],
    					s[i]['remark'],
    					  ]);										
    				}
                        //$('#balance').html("Total Wallet Amount : "+balance);
    		},
    	error: function(e){
    		}
    	});
     });
            
            
            function check_balance()
            {
               $('#p_error').html(''); 
               var aval_bal=<?php echo $bal->balance; ?>; 
               var req_amt=$('#request_amount').val();
               
                if(aval_bal < 0)
                {
                   $('#p_error').html(''); 
                   $('#p_error').html('You Do Not Have Sufficient Amount in Your Wallet !');
                   return false;
                }
                else if(aval_bal < req_amt)
                {
                   $('#p_error').html(''); 
                   $('#p_error').html('You Do Not Have Sufficient Amount in Your Wallet !');
                   return false; 
                }else if(aval_bal >=req_amt && aval_bal > 0 && req_amt >0)
                {
                   //Insert Request
                   $.ajax({
                       type: 'POST',
                       url: '<?php echo base_url(); ?>buyer/wallet/request_amount',
                       data: {'req_amt': req_amt},
                       success: function (data) {
                          
                          if(data==1)
                          {
                              // $('#p_error').html(''); 
                              $('#wallet_request').modal('hide');
                              $('#display_messege').html('<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Success!</strong> Withdraw Request Sent Successfully.  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                              window.setTimeout(function(){location.reload()},2000)
                              // 
                          }
                          else
                          {
                             $('#error_addr').html(''); 
                             $('#p_error').html(data); 
                          }
    
                       },
                       error: function () {
                           alert('Somthing Wrong !');
                       }
                   });
                }
                else
                {
                   $('#p_error').html(''); 
                   $('#p_error').html('Please Enter Amount to Withdraw !'); 
                   return false;
               }
            }


/*prevent special characters validation*/

$('input').on('keypress', function (event) {
    var regex = new RegExp("^[0-9.]$");
    var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
    if (!regex.test(key)) {
       event.preventDefault();
       return false;
    }
});



            
</script>
<?php $this->load->view('front/common/footer');?>