
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
    <h2 class="mt-50">Your Coupons</h2>
    <h6 style="text-align:center;"><?php echo $this->session->flashdata('message'); ?></h6>
    <br>
   

    <!-- Tab panes -->
    <div class="tab-content">

        <div id="home" class="tab-pane active"><br>
            <div class="row">
                <div class="col-lg-12 px-0 pr-lg-2 mb-2 mb-lg-0">
                    <div class="card border-light bg-white card proviewcard shadow-sm">
                        <div class="card-header">All Coupons</div>

                        <div class="card-body">
                            <div class="col-lg-12 p-3 cardlist">
                                <div class="col-lg-12">
                                     <table id="couponTable" class="table table-striped table-bordered nowrap">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Coupon Code</th>
                                                    <th>Value</th>
						    <th>Validity</th>
						    <th>Status</th>
						    <th>Date</th>
                                                </tr>
                                            </thead>
                                       
                                    <?php
                                        foreach ($allcoupons as $ord) {
                                                 ?>
                                    <tr>
                                        <?php
                                    if($ord->valid_to >=date('Y-m-d'))
                                        {
                                                $valid_status= '<span style="color:green;font-weight:bold;" title="Valid">o</span>'; 
                                        }
                                        else
                                        {
                                                $valid_status= '<span style="color:red;font-weight:bold;" title="Expire">o</span>';
                                        }
                                   ?>
                                         <td><?php echo $ord->coupon_id; ?></td>
                                          <td><?php echo $ord->coupon_code; ?></td>
                                           <td><?php echo $ord->coupon_value.' ('.$ord->discount_type.' )'; ?></td>
                                            <td><?php echo $valid_status.' | '.date('d M Y',strtotime($ord->valid_from)).' <b style="color:red;"> ~ </b> '.date('d M Y',strtotime($ord->valid_to)); ?></td>
                                             <td><?php echo $ord->status; ?></td>
                                             <td><?php echo date('d M Y H:i',strtotime($ord->updated_at)); ?></td>
                                         
                                    </tr>
                                        <?php } ?>
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
</div>

</div>

</div>

</div>
<br><br><br><br>