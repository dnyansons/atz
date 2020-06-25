<!DOCTYPE html>
<html>
    <head>
        <title>Tax Invoice</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
		<link rel="icon" href="<?php echo base_url(); ?>assets/admin/images/favicon.ico" type="image/x-icon">
        <style>
            @media print
		{
		  @page
		  {
			size: landscape; //auto, portrait, landscape or length (2 parameters width and height.
			sets both equal if only one is provided. % values not allowed.)
		  }
		}	
                
            .border{
            border:1px solid #000;
            overflow: hidden;
            }
            .logo img{
            width: 160px;
            }
            .table td {
                border: 1px solid #000 !important;
    
                }

       .table th {
            border: 1px solid #000 !important;
    
            }
            @media (min-width: 1200px){
            .container {
            width: 1170px;
            }
            }
            @media (min-width: 992px){
            .container {
            width: 900px;
            }
            }
            @media only screen and (max-width: 480px) {
            .border{
            padding:5px 10px;
            } 	
            .fess{
            margin-left: 16px;
            }
            .bdtop{
            border-top: 1px solid #000;
            }
            .ddd{
            margin-top: 10px;
            }
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="border">
                <div class="row">
                    <div class="col-xs-12 col-md-12 col-sm-12 text-center">
                        <h5>ATZCart.com- Tax Invoice</h5>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-md-12 col-sm-12 text-center">
                        <h5><strong>TAX INVOICE</strong></h5>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-md-1 col-sm-1"> </div>
                    <div class="col-xs-12 col-md-4 col-sm-4">
                        <span class="logo"><img src="<?php echo base_url(); ?>assets/front/images/logo/logo.png" class="img-fluid"></span>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-md-5 col-sm-5 fess">
                            <h5> <strong>Invoice #:</strong> <span>12233456</span></h5>
                            <p><strong>Date Created: </strong><span><?php echo date('d-m-Y'); ?></span></p>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-xs-12 col-md-1 col-sm-1"> </div>
                    <div class=" col-xs-12 col-md-6 col-sm-6">
                        <address>
                            <strong>Issued to:</strong><span>&nbsp;<?php echo $orderDetails->pick_name; ?> </span> <br>
                            <strong>Seller Name and Address:&nbsp;</strong><span><?php echo $orderDetails->pick_addr_type; ?>, PIN-<?php echo $orderDetails->pick_pincode; ?>, <?php echo $orderDetails->ck_mobile ?>  </br><?php echo $orderDetails->ck_state; ?> India.<br></span><br>
                            <strong>Sellers GSTN:</strong><span><?php echo $orderDetails->gst; ?></span><br>
                        </address>
                    </div>
                    <div class=" col-xs-12 col-md-5 col-sm-5 bdtop pb-10px">
                        <address class="ddd">
                            <strong>Issued by:</strong><span> ATZ Cart</span> <br>
                            <strong>ATZCart.com name and address:</strong></br><span> ATZ Cart PVT LTD<br> Plot No 44,, Phase 1, RGIP, Hinjawadi, Pune Maharashtra 411057</span><br>
                            <strong>ATZcart.com GSTIN: </strong><span> 27AASCA2908A1ZV </span><br>
                            <strong>ATZcart.com PAN:</strong><span> AASCA2908A</span><br>
                            <strong>ATZcart.com CIN No:</strong><span> U72900PN2019PTC184043</span>
                        </address>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-md-12 col-sm-12 table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Sr.No</th>
                                    <th>Date & Time</th>
                                    <th>Transaction Type</th>
                                    <th>Order Id</th>
                                    <th>Product Details</th>
                                    <th>Product Price</th>
                                    <th>ATZ Fees</th>
                                    <th>TAX on Fees</th>
                                    <th>Refunds (In case if partial refund and full refund)</th>
                                    <th>Total Payable</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td><?php echo $orderDetails->date_purchased; ?></td>
                                    <td><?php echo $orderDetails->payment_method; ?></td>
                                    <td><?php echo $orderDetails->orders_id; ?></td>
                                    <td> <?php

                               echo '<div>';
							   $pro_sp = json_decode($orderDetails->product_details['product_specifications'], true);
							   echo 'Product Name: <b>'. $pro_sp["product_name"] . '</b><br>';
							   for($i = 0; $i< count($pro_sp['specifications']); $i++)
							   {
								   if(isset($pro_sp['specifications'][$i]['specifications']['primary']))
								   {
									//Primary 
									   echo $pro_sp['specifications'][$i]['specifications']['primary']['specification_name'].' : '.$pro_sp['specifications'][$i]['specifications']['primary']['spec_value'];
									   echo '<br>';
								   }
								   for($j = 0; $j< count($pro_sp['specifications'][$i]['specifications']['secondary']); $j++)
								   {
									   //Secondary
									   echo $pro_sp['specifications'][$i]['specifications']['secondary'][$j]['specification_name'];
									   echo ' : '.$pro_sp['specifications'][$i]['specifications']['secondary'][$j]['spec_value'] .' | Qnty : '.$pro_sp['specifications'][$i]['specifications']['secondary'][$j]['quantity'];
									   echo '<br>';
								   
								   }
								   for($k = 0; $k< count($pro_sp['specifications'][$i]['specifications']['other']); $k++)
								   {
										//Other
									   echo $pro_sp['specifications'][$i]['specifications']['other'][$k]['specification_name'].' : '. $pro_sp['specifications'][$i]['specifications']['other'][$k]['spec_value'];
									   echo'<br>';
								   }
								   
								}
						   ?>
						   </td>
                                    <td><?php echo $orderDetails->product_details['products_price']; ?></td>
                                    <td><?php echo $orderDetails->commission; ?></td>
                                    <td>0.00</td>
                                    <td>0.00</td>
                                    <td><?php echo $orderDetails->order_price; ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </body>
    <script src="https://code.jquery.com/jquery-1.11.3.min.js"></script>
<script>
$(document).ready(function(){
	  window.print();
      return false;
});
</script>
</html>
