<!DOCTYPE html>
<html>
   <head>
      <title>Buyer invoice</title>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
	  <link rel="icon" href="<?php echo base_url(); ?>assets/admin/images/favicon.ico" type="image/x-icon">
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
      <style>
         .logo img{
         width: 160px;
         }
         .border{
         border:1px solid #000;
         padding:5px 10px;
         }
         .memo{
         text-align: end;
         margin-top: 20px;
         }
         .table td {
         border: 1px solid #000 !important;
         }
         .table th {
         border: 1px solid #000 !important;
         }
         .mbt50{
         margin-top: 50px;
         }
         hr{
         margin: 0px 0px 8px 0px;
         }
         .sign p{
         font-size: 11px;
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
         }
      </style>
   </head>
   <body>
      <div class="container">
         <div class="border">
            <div class="row">
               <div class="col-xs-12 col-md-1 col-sm-1"></div>
               <div class="col-xs-12 col-md-10 col-sm-10">
                  <div class="col-xs-12 col-md-5 col-sm-5 logo">
                     <img src="<?php echo base_url(); ?>assets/front/images/logo/logo.png" class="img-responsive">
                  </div>
                  <div class="col-xs-12 col-md-7 col-sm-7 memo">
                     <h5><strong>TAX Invoice/Bill of Supply/Cash Memo</strong></h5>
                  </div>
               </div>
            </div>
            <hr>
            <div class="row">
               <div class="col-xs-12 col-md-1 col-sm-1"> </div>
               <div class="col-xs-12 col-md-7 col-sm-7">
                  <strong>SOLD BY:</strong>
                  <address>
                     Recipient Name : <?php echo $sorder["pick_name"]; ?><br>
                     Company Name : <?php echo $sorder["pick_addr_type"]; ?><br>
                     Street Address : <?php echo $sorder["pick_addr_type"]; ?><br>
                     City, ST ZIP Code : <?php echo $sorder["pick_pincode"]; ?><br>
                     Phone : <?php echo $sorder["pick_mobile"]; ?><br>
                  </address>
               </div>
               <div class="col-xs-12 col-md-3 col-sm-3">
                  <strong>BILLING ADDRESS:</strong>
                  <address>
                     Recipient Name : <?php echo $sorder["delivery_name"]; ?><br>
                     Company Name : <?php echo $sorder["delivery_name"]; ?><br>
                     Street Address : <?php echo $sorder["delivery_street_address"]; ?><br>
                     City, ST ZIP Code : <?php echo $sorder["delivery_city"].' '.$sorder['delivery_postcode']; ?><br>
                     Phone : <?php echo $sorder["user_telephone"]; ?><br>
                  </address>
               </div>
            </div>
            <hr>
            <div class="row">
               <div class="col-xs-12 col-md-1 col-sm-1"> </div>
               <div class="col-xs-12 col-md-7 col-sm-7">
                  <strong>PAN NO:</strong><br>
                  <strong>GST Registration No:</strong>
               </div>
               <div class="col-xs-12 col-md-3 col-sm-3">
                  <strong>SHIPPING ADDRESS:</strong>
                  <address>
                     Recipient Name : <?php echo $sorder["delivery_name"]; ?><br>
                     Street Address : <?php echo $sorder["delivery_street_address"]; ?><br>
                     City, ST ZIP Code : <?php echo $sorder["delivery_city"].' '.$sorder['delivery_postcode']; ?><br>
                     Phone : <?php echo $sorder["user_telephone"]; ?><br>
                  </address>
               </div>
            </div>
            <hr>
            <div class="row">
               <div class="col-xs-12 col-md-1 col-sm-1"> </div>
               <div class="col-xs-12 col-md-7 col-sm-7">
                  <strong>ORDER NO: <?php echo $sorder["orders_id"]; ?></strong><br>
                  <strong>ORDER Date: <?php echo date('d M Y ',strtotime($sorder['shipping_start_date'])); ?></strong>
               </div>
               <div class="col-xs-12 col-md-3 col-sm-3">
                  <strong>INVOICE NUMBER: #<?php echo $sorder["orders_id"]; ?></strong>
                  <address>
                     <strong>Invoice Date : <?php echo date('d M Y ',strtotime($sorder['orders_date_finished'])); ?></strong><br>
                  </address>
               </div>
            </div>
            <div class="row">
               <div class="col-xs-12 col-sm-1 col-md-1"></div>
               <div class="col-xs-12 col-sm-11 col-md-11">
                  <strong class="">COMMENTS OR SPECIAL INSTRUCTIONS:</strong>
               </div>
            </div>
            <div class="row">
               <div class="col-xs-12 col-sm-1 col-md-1"></div>
               <div class="col-xs-12 col-sm-11 col-md-11">
                  <p>To get started right away, just tap any placeholder text (such as this) and start typing to replace it with your own.</p>
               </div>
            </div>
            <div class="row">
               <div class="col-xs-12 col-md-12 col-sm-12 table-responsive">
                  <table class="table border">
                     <thead>
                        <tr>
                           <th>Sr.No</th>
                           <th>Discription</th>
                           <th>Quantity</th>
                           <th>Discount</th>
                           <th>Unit Price</th>
                           <th>Net Amount</th>
                           <th>TAX Amount</th>
                           <th>Total Amount</th>
                        </tr>
                     </thead>
                     <tbody>
                        <?php
                           echo'<tbody>';
                            $sub_total = 0;
                            $z=1;
                            foreach ($orderDetails as $row) 
							{
                               echo '<tr>';
							   $pro_sp = json_decode($row['product_specifications'], true);
							   $count = count($pro_sp['specifications']);
							   echo'<td class="text-left" rowspan="'.$count.'"><b>'.$z. '. ' . $pro_sp["product_name"] . '</b><br>'; echo '</td>';
                           for($i = 0; $i< count($pro_sp['specifications']); $i++)
						   {
							   echo'<td class="text-left">';
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
								   echo ' : '.$pro_sp['specifications'][$i]['specifications']['secondary'][$j]['spec_value'];
								   echo '<br>';
							   
							   }
							   for($k = 0; $k< count($pro_sp['specifications'][$i]['specifications']['other']); $k++)
							   {
									//Other
								   echo $pro_sp['specifications'][$i]['specifications']['other'][$k]['specification_name'].' : '. $pro_sp['specifications'][$i]['specifications']['other'][$k]['spec_value'];
								   echo'<br>';
							   }
								echo'</td>';
                                echo'<td class="text-right" rowspan="'.$count.'">'.$pro_sp['specifications'][$i]['specifications']["total_quantity"]. '</td>';
                                echo'<td class="text-right" rowspan="'.$count.'">'.$pro_sp['specifications'][$i]['specifications']["total_discount"]. '</td>';
                                echo'<td class="text-right" rowspan="'.$count.'">'.$pro_sp['specifications'][$i]['specifications']["unit_price"]. '</td>';
                           
								$final_price = $pro_sp['specifications'][$i]['specifications']["total_quantity"] * $pro_sp['specifications'][$i]['specifications']["unit_price"];
                           
								echo'<td class="text-right" rowspan="'.$count.'"> '.$final_price.'</td>';
								echo'<td class="text-right" rowspan="'.$count.'"> 0.0 </td>';
                                echo'<td class="text-right" rowspan="'.$count.'">';
							   if($pro_sp['specifications'][$i]['specifications']['total_price_after_dis'] != 0){
									$final_price = $pro_sp['specifications'][$i]['specifications']["total_price_after_dis"];
									 echo $final_price .'</td>';
							   }else{
									 echo $final_price .'</td>';
							   }
							   echo'</tr>';
							}
								   $z++;
						}
                           
                           echo'</tbody>';
                           
                           ///////////// Total //////////
                           ////////////////////////////////
                            ?>
                        <tr>
                           <td colspan="7" class="text-right" ><strong>SUBTOTAL</strong></td>
                           <td colspan="" class="text-right"><?php echo number_format($final_price, 2); ?></td>
                        </tr>
                        <tr>
                           <td colspan="7" class="text-right">Shipping cost (Including GST)</td>
                           <td colspan="" class="text-right"><?php echo number_format($orderDetails[0]['shipping_cost'], 2); ?></td>
                        </tr>
                        <tr>
                           <td colspan="7" class="text-right"><strong>Total</strong></td>
                           <td colspan="" class="text-right"><?php echo number_format($orderDetails[0]['order_price'], 2); ?></td>
                        </tr>
                        <tr>
                           <td colspan="8" style="text-align: right;">
                              <strong>For (sellers name):</strong>
                              <br><br>
                              <span class="sign">
                                 <strong>Authorized Signatory</strong><br>
                                 <p>Signature as uploaded by seller in document upload</p>
                              </span>
                           </td>
                        </tr>
                     </tbody>
                  </table>
               </div>
            </div>
            <div class="row mbt50">
               <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                  <strong class="">THANK YOU FOR SHOPPING WITH ATZCART.COM</strong>
               </div>
            </div>
            <div class="row mbt50">
               <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                  <p>Please note that this invoice is not a demand for payment. T&C of ATZCart.com apply*</p>
               </div>
            </div>
         </div>
      </div>
   </body>
</html>