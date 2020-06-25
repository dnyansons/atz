
<!DOCTYPE html>
<html>
<head>
	 <title>Final Order Invoice </title>
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
            margin-top: 10px;
            border:1px solid #000;
            overflow: hidden;
            padding: 5px 5px;
            }

            .logo img{
             margin-top: 10px;
             height: 50px;
             width: 120px;
            }
            ol{
            margin-left: -25px;
            }

            hr{
            	margin: 0px 0px 4px 0px;
            }

            .mr10{
            	margin-right: 10px;
            }

        	@media (min-width: 1200px){
            .container {
				width: 1000px;
				padding : 30px;
            }
            }
            @media (min-width: 992px){
            .container {
            width: 970px;
            }
            }
            @media (min-width: 768px){
            .container {
            width: 900px;
            }
            }
            @media only screen and (max-width: 480px) {
            .border{
            padding:5px 10px;
            }   
            hr{
            width: 97%;
            }

            .mr10{
            	float: unset !important;
            }
            }
        </style>
</head>
<body>
<div class="container" style="font-size: 13px">
	<div class="border text-center">
		<div class="row pull-right mr10">
			<span class="logo">
				<img src="<?php echo base_url(); ?>assets/front/images/logo/logo.png" class="img-fluid">
			</span>
		</div> 
		<div class="clearfix"></div>
		<div class="row">
            <h5><b>Details of Order ID: #ORD<?php echo $orderDetails[0]["orders_id"]; ?></b></h5>
		</div>
		<hr>
		<div class="clearfix"></div>
		<div class="row">
                    <div class="col-xs-12 col-md-1 col-sm-1"> </div>
                    <div class="col-xs-12 col-md-7 col-sm-7 text-left">
                        <address>
                        
                            Date of Order: <span><?php echo date('d M Y ',strtotime($orderDetails[0]['date_purchased'])); ?></span> <br>
                            ATZCart.com order ID: <span>#ORD<?php echo $orderDetails[0]["orders_id"]; ?></span><br>
                            Order Amount: (Paid by buyer) : <span><?php echo $orderDetails[0]["order_price"]; ?> </span><br>
                            
                        </address>
                    </div>
                 
           </div>

           <div class="row">
		   <h5><strong>Date of Order Dispatched:<span><?php echo date('d M Y ',strtotime($orderDetails[0]['delivery_date'])) ;?></span></strong></h5>
		</div>
	<div class="clearfix"></div>
	<hr>
		<div class="row">
                    <div class="col-xs-12 col-md-1 col-sm-1"> </div>
                    <div class=" col-xs-12 col-md-7 col-sm-7 text-left">
                        <address>
                            <strong>Order To:</strong><span>&nbsp;&nbsp;<?php echo $orderDetails[0]["user_name"];?></span> <br>
                           <ol type="">
                           	<li>product detail</li>
                           </ol>
						   <?php 
							$z=1;
                            foreach ($orderDetails as $row) 
							{
                               echo '<div>';
							   $pro_sp = json_decode($row['product_specifications'], true);
							   echo 'Product Name: <b>'. $pro_sp["product_name"] . '</b><br>';
                                foreach ($pro_sp['specifications'] as $sp) {
                                    if (isset($sp['specifications']['primary'])) {

                                        //Primary
                                        echo $sp['specifications']['primary']['specification_name'] . ' : ' . $sp['specifications']['primary']['spec_value'];
                                        echo '';
                                    }

                                    foreach ($sp['specifications']['secondary'] as $secondary) {
                                        //Secondary
                                        if ($sp['specifications']['primary']['spec_value'] != $secondary['spec_value']) {
                                            echo $secondary['specification_name'];
                                            echo ' : ' . $secondary['spec_value'];
                                        }

                                        echo ' | Qty: ' . $secondary['quantity'];
                                        echo'</br>';
                                    }

                                    foreach ($sp['other'] as $other) {
                                        //Other
                                        echo $other['specification_name'] . ' : ' . $other['spec_value'];
                                        echo'';
                                    }


                                    if (isset($sp['specifications']['primary'])) {
                                        echo'';
                                    } elseif (isset($sp['specifications']['secondary'])) {
                                        echo'';
                                    }
                                }
                                echo "</br>";
							$z++;
						}
						   ?>
                        </address>
                    </div>
                    <div class=" col-xs-12 col-md-4 col-sm-4 bdtop text-left">
                        <address class="ddd">
                            <strong>Price:</strong><span>&nbsp;&nbsp;<?php echo $orderDetails[0]["final_price"]; ?></span> <br>
                            <strong>Item Price:</strong><span>&nbsp;&nbsp;<?php echo $orderDetails[0]["products_price"]; ?></span><br>
                            <strong>(Seller + ATZCart commission) </strong><br>
                        </address>
                    </div>
                </div>
                <hr>
                	<div class="row">
                    <div class="col-xs-12 col-md-1 col-sm-1"> </div>
                    <div class=" col-xs-12 col-md-7 col-sm-7 text-left">
                        <address>
                           <strong>Delivery Address:</strong><span>&nbsp;&nbsp;<?php echo $orderDetails[0]["delivery_name"]; ?></br>
						   <?php echo $orderDetails[0]["delivery_street_address"].' '. $orderDetails[0]["delivery_city"].' '. $orderDetails[0]["delivery_postcode"] ?> </br><?php echo $orderDetails[0]["delivery_state"] . ' '.$orderDetails[0]["delivery_country"]; ?></span> </br></br>
                           <strong>Buyer Name and Address:</strong><span>&nbsp;&nbsp;<?php echo $orderDetails[0]["user_name"]; ?></br><?php echo $orderDetails[0]["user_street_address"] .' '.$orderDetails[0]["user_city"] .' '.$orderDetails[0]["user_postcode"]; ?> </br>
						   <?php echo $orderDetails[0]["user_state"]; ?> India</span> <br>
                            
                        </address>
                    </div>
                    <div class=" col-xs-12 col-md-4 col-sm-4 bdtop text-left">
                        <address class="ddd">
                            Item (s) Subtotal:<span> <?php echo $orderDetails[0]["final_price"]; ?> </span> <br>
                            Shipping cost: (including GST):<span> <?php
                            if($orderDetails[0]["shippment_type"] == "Free"){
                                echo "0.00";
                            }else{
                            echo $orderDetails[0]["shipping_cost"]; } ?> </span><br>
                            Total: Item (Price + Shipping Cost) <br>
                            <span>(Amount Subtracted after coupon value applied)</span><br>
                            Total Amount paid for this delivery: <?php echo $orderDetails[0]["order_price"]; ?> <br>
                             Total paid by ATZcart.com wallet balance: 0<br>
                        </address>
                    </div>
                </div>
                <hr>
                 <div class="row">
		  <h5> <strong>Payment Information:</strong></h5>
		</div>
	<div class="clearfix"></div>

		<div class="row">
                    <div class="col-xs-12 col-md-1 col-sm-1"> </div>
                    <div class=" col-xs-12 col-md-7 col-sm-7 text-left">
                        <address>
                            <strong>Payment Method:</strong><span><?php echo $$orderDetails ["payment_method"]; ?></span> <br>
                           Card type/ Net Banking:<span>atz</span> <br>
                           ATZcart wallet Balance:<span>0</span> <br>
                            
                        </address>
                    </div>
                    <div class=" col-xs-12 col-md-4 col-sm-4 bdtop text-left">
                        <address class="ddd">
                           Item(s) Subtotal: <span>&nbsp;&nbsp;<?php echo $orderDetails[0]["final_price"]; ?></span> <br>
                            Shipping Cost:<span>&nbsp;&nbsp;<?php echo $orderDetails[0]["shipping_cost"]; ?></span><br>
                            
                        </address>
                    </div>
                </div>

                	<div class="row">
                    <div class="col-xs-12 col-md-1 col-sm-1"> </div>
                    <div class=" col-xs-12 col-md-7 col-sm-7 text-left">
                        <address>
                            <strong>Billing Address:</strong><span>&nbsp;&nbsp;<?php echo $orderDetails[0]["user_name"]; ?></br><?php echo $orderDetails[0]["user_street_address"] .' '.$orderDetails[0]["user_city"] .' '.$orderDetails[0]["user_postcode"]; ?> </br>
						   <?php echo $orderDetails[0]["user_state"]; ?> India</span> 
                            
                        </address>
                    </div>
                    <div class=" col-xs-12 col-md-4 col-sm-4 bdtop text-left">
                        <address class="ddd">
                           Total:<span>&nbsp;&nbsp;<?php echo $orderDetails[0]["final_price"]+$orderDetails[0]["shipping_cost"]; ?></span> <br>
                            Promotion/Coupon value:<span>&nbsp;&nbsp;<?php echo $pro_sp['specifications'][0]['specifications']["total_discount"]; ?></span><br>
                            <strong>Grand Total: <span>&nbsp;&nbsp;<?php echo $orderDetails[0]["order_price"]; ?></span></strong><br>
                            
                        </address>
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