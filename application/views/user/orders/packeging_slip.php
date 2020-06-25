<!DOCTYPE html>
<html>
    <head>
        <title> slip</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
		<link rel="icon" href="<?php echo base_url(); ?>assets/admin/images/favicon.ico" type="image/x-icon">
        <style>
            .border{
            border:1px solid #000;
            }
            hr{
            margin-top: 0px;
            margin-bottom: 20px;
            border: 0;
            border-top: 1px solid #464545;
            width: 83%;
            }
            .form-group {
            margin-bottom: 5px;
            }
            .logo img{
            width: 160px;
            }
            @media (min-width: 1200px){
            .container {
            width: 1170px;
            }
            }
            @media (min-width: 992px){
            .container {
            width: 970px;
            }
            }
            @media (min-width: 768px){
            .container {
            width: 750px;
            }
            }
            @media only screen and (max-width: 480px) {
            .border{
            padding:5px 10px;
            }   
            hr{
            width: 97%;
            }
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="border">
                <div class="row">
                    <div class="col-xs-12 col-md-1 col-sm-1"></div>
                    <div class="col-xs-12 col-md-10 col-sm-10">
                        <h5>Packaging slip for <?php echo $orderDetails[0]["orders_id"]; ?>  <?php echo date('d M Y ',strtotime($orderDetails[0]['date_purchased'])); ?> </h5>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-md-8 col-sm-8"> </div>
                    <div class="col-xs-12 col-md-2 col-sm-2 img-responsive">
                        <img src="http://www.api2pdf.com/wp-content/uploads/2018/07/download-1.png" />
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-md-1 col-sm-1"> </div>
                    <div class="col-xs-12 col-md-8 col-sm-8 img-responsive">
                        <address>
                            <b>Sold by</b><br>
                            <b>Seller Name: </b><?php echo $orderDetails[0]["pick_name"]; ?><br>
                            <b>Seller Address : </b><?php echo $orderDetails[0]["pick_addr_type"]; ?>, PIN-<?php echo $orderDetails[0]["pick_pincode"]; ?>, <?php echo $orderDetails[0]["pick_mobile"]; ?>  </br><?php echo $orderDetails[0]["pick_state"]; ?> India.<br>
							 
                        </address>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-md-1 col-sm-1"> </div>
                    <div class="col-xs-12 col-md-8 col-sm-8">
                        <div class="form-group">
                            <label for="email" class="email">Email address:</label>
                            <span><?php echo $orderDetails[0]["pick_email"]; ?></span>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-xs-12 col-md-1 col-sm-1"> </div>
                    <div class="col-xs-12 col-md-6 col-sm-6">
                        <strong>Billing Address</strong>
                        <address>
                         <?php echo $orderDetails[0]["user_name"]; ?></br><?php echo $orderDetails[0]["user_street_address"] .' '.$orderDetails[0]["user_city"] .' '.$orderDetails[0]["user_postcode"]; ?> </br>
						   <?php echo $orderDetails[0]["user_state"]; ?> India</span> <br>
                        </address>
                    </div>
                    <div class="col-xs-12 col-md-5 col-sm-5">
                        <strong>Shipping Address</strong>
                        <address>
                            <?php echo $orderDetails[0]["delivery_name"]; ?></br>
						   <?php echo $orderDetails[0]["delivery_street_address"].' '. $orderDetails[0]["delivery_city"].' '. $orderDetails[0]["delivery_postcode"] ?> </br><?php echo $orderDetails[0]["delivery_state"] . ' '.$orderDetails[0]["delivery_country"]; ?>
                        </address>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-md-1 col-sm-1"> </div>
                    <div class="form-group col-xs-12 col-md-6 col-sm-6">
                        <label for="email" class="">Order Id:</label>
                        <span><?php echo $orderDetails[0]["orders_id"]; ?></span>
                    </div>
                    <div class="col-xs-12 col-md-5 col-sm-5"> 
                        <strong>This is computer generated document</strong>
                    </div>
                    <hr>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-md-1 col-sm-1"> </div>
                    <div class="form-group col-xs-12 col-md-6 col-sm-6">
                        <label for="email" class="">Quantity Descripation:</label>
                    </div>
                    <hr>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-md-1 col-sm-1"> </div>
                    <div  class="col-xs-12 col-md-7 col-sm-7">
                        <div class="form-group">
                            <label for="email" class="email">Product Detail:</label>
                            <span>
                            <?php 
							$z=1;
                            foreach ($orderDetails as $row) 
							{
                               echo '<div>';
							   $pro_sp = json_decode($row['product_specifications'], true);
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
								   echo ' : '.$pro_sp['specifications'][$i]['specifications']['secondary'][$j]['spec_value'] .' | '.$pro_sp['specifications'][$i]['specifications']['secondary'][$j]['quantity'];
								   echo '<br>';
							   
							   }
							   for($k = 0; $k< count($pro_sp['specifications'][$i]['specifications']['other']); $k++)
							   {
									//Other
								   echo $pro_sp['specifications'][$i]['specifications']['other'][$k]['specification_name'].' : '. $pro_sp['specifications'][$i]['specifications']['other'][$k]['spec_value'];
								   echo'<br>';
							   }
							   
							}
							$z++;
							}
						   ?>
						    </div>
                            </span>
                        </div>
                    </div>
					 <div class="col-xs-12 col-md-4 col-sm-4"> 
                        <strong>Price (Total Price):<?php echo $orderDetails[0]["order_price"]; ?></strong>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-xs-12 col-md-1 col-sm-1"> </div>
                    <div class="col-xs-12 col-md-10 col-sm-10 text-center">
                        <strong>Billing Address</strong>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-md-1 col-sm-1"> </div>
                    <div class="col-xs-12 col-md-10 col-sm-10 text-center">
                        <address>
                             <?php echo $orderDetails[0]["pick_name"]; ?><br>
                            <?php echo $orderDetails[0]["pick_addr_type"]; ?>, PIN-<?php echo $orderDetails[0]["pick_pincode"]; ?>, <?php echo $orderDetails[0]["pick_mobile"]; ?></br><?php echo $orderDetails[0]["pick_state"]; ?> India.<br>
                        </address>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-xs-12 col-md-1 col-sm-1"></div>
                    <div class="col-xs-12 col-md-10 col-sm-10">
                        <h5>Visit<a> http://www.atzcart.com/returns</a>, to return an item</h5>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-md-1 col-sm-1"></div>
                    <div class="col-xs-12 col-md-10 col-sm-10 logo">
                        <span> Purchase made on  <img src="<?php echo base_url(); ?>assets/front/images/logo/logo.png" class="img-fluid"></span>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </body>
</html>