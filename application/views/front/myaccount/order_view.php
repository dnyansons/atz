<style>
    .checked_star {
        color: orange;
    }
    body{background-color:#fff !important;}
</style>
<!-- Services section -->
<div class="container">
    <h2 class="mt-50">Order View</h2>

    <?php
    if ($sorder["orders_status_name"] != 'Pending') {
        ?>


        <div class="row">

            <div class="col-md-12">
                <a type="button" href="<?php echo base_url(); ?>buyer/myorders/track_order/<?php echo $sorder['orders_id']; ?>" class="btn btn-danger btn-sm pull-right" style="color:#fff;">Track Order</a>


            </div>

        </div>


    <?php } ?>
    <div class="page-body">
        <br>

        <div class="col-sm-12">

            <div class="card" id="printableArea">
                <div class="card-block">
                    <h4 style="text-align:center;">Order Details</h4>
                    <?php
                    if ($return_order_shipping) {
                        echo ' <span style="color:red;">&nbsp;&nbsp;Return AWB Number :  </span><b>' . $return_order_shipping->awb_number . '</b>';
                        if ($return_order_shipping->ship_vendor_id == 2) {
                            echo'<a href="'.$return_order_shipping->awb_url.'">Download Label </a>';
                        }
                    }
                    // if($retord)
                    // {
                    //echo ' <span style="color:red;">&nbsp;&nbsp;Return AWB Number :  </span><b>'.$retord->awb_number.'</b>';
                    // } 
                    ?>
                    <br>

                    <div class="dt-responsive table-responsive">


                        <table class="table table-bordered">
                            <thead>
<?php
echo'<tr> 
					 <th colspan="3">Status : ' . $sorder["orders_status_name"] . ' </th> 
					 <td colspan="4">Order ID : <b>#' . $sorder["orders_id"] . '</b><br>Order Date : ' . date('d M Y H:i', strtotime($sorder["date_purchased"])) . '<br>Transaction ID :<b># ' . $sorder["payment_id"] . '</td> 
				 </tr> 
				 <tr> 
					 <th colspan="3">Sold By : <br><b>' . $sorder["pick_name"] . '</b> ,<br>' . $sorder["pick_addr_type"] . ' ,' . $sorder["delivery_city"] . ' ,<br>' . $sorder["pick_pincode"] . '<br></th> 
					 <td colspan="4">Billing Address<br><b>' . $sorder["delivery_name"] . '</b> ,<br>' . $sorder["delivery_street_address"] . ' ,' . $sorder["delivery_city"] . ' ,<br>' . $sorder["delivery_postcode"] . ' ,' . $sorder["delivery_state"] . '</td> 
				 </tr> 
				 <tr> 
					 <th colspan="3" >Payment Method : ' . $sorder["payment_method"] . '<br>Shipping Method: ' . $sorder["shipping_method"] . '</th> 
					 <td colspan="4">Shipping Address<br><b>' . $sorder["delivery_name"] . '</b> ,<br>' . $sorder["delivery_street_address"] . ' ,' . $sorder["delivery_city"] . ' ,<br>' . $sorder["delivery_postcode"] . ' ,' . $sorder["delivery_state"] . '</td> 
				 </tr>';
?>
                                <tr>
                                    <th  style="font-weight:bold;text-align:center;" colspan="4">Product Details</th>

                                </tr>
                                <tr>
                                    <th class="text-left" style="font-weight:bold;">Product</th>
                                    <th class="text-right" style="font-weight:bold;">Quantity</th>
                                    <th class="text-right" style="font-weight:bold;">Unit Price</th>
                                    <th class="text-right" style="font-weight:bold;" >Total</th>
                                </tr>
                            </thead>
<?php
echo'<tbody>';
$sub_total = 0;
$z = 1;
foreach ($orderDetails as $row) {
    $sub_total = $sub_total + $row['final_price'];
    echo '<tr>';

    echo'<td class="text-left"><b>' . $z . '. ' . $row["product_name"] . '</b><br>';




    $pro_sp = json_decode($row['product_specifications'], true);

    // print_r($pro_sp);

    foreach ($pro_sp['specifications'] as $sp) {
        // echo'<pre>';
        //print_r($sp);

        if (isset($sp['specifications']['primary'])) {


//Primary 
            echo $sp['specifications']['primary']['specification_name'] . ' : ' . $sp['specifications']['primary']['spec_value'];
            echo '<br>';
        }

        foreach ($sp['specifications']['secondary'] as $secondary) {

//Secondary                                            
            if ($sp['specifications']['primary']['spec_value'] != $secondary['spec_value']) {
                echo $secondary['specification_name'];
                echo ' : ' . $secondary['spec_value'] . ' | ';
            }
            echo ' Quantity: ' . $secondary['quantity'];
            echo'<br>';
        }

        foreach ($sp['other'] as $other) {
            //Other
            echo $other['specification_name'] . ' : ' . $other['spec_value'];
            echo'<br>';
        }


        if (isset($sp['specifications']['primary'])) {
            echo'----------------------------------------------------------<br>';
        } elseif (isset($sp['specifications']['secondary'])) {
            echo'----------------------------------------------------------<br>';
        }
    }

    echo '</td>';
    echo'<td class="text-right">' . $row["products_quantity"] . '</td>';
    echo'<td class="text-right">' . $row["products_price"] . '</td>';
    echo'<td class="text-right">' . $row["final_price"] . '</td>';
    echo'</tr>';
    $z++;
}

echo'</tbody>';

///////////// Total //////////
////////////////////////////////
?>
                            <tr>
                                <td colspan="3" class="text-right">Sub-Total</td>
                                <td class="text-right"><?php echo number_format($sub_total, 2); ?></td>
                            </tr>
                            <tr>
                                <td colspan="3" class="text-right">Flat Shipping Rate</td>

                            <?php
                            //Check Shipping Status
                            if ($orderDetails[0]['shippment_type'] == 'Free' && $orderDetails[0]['order_price'] >= 500) {
                                $ship = '0.00';
                            } else {
                                $ship = number_format($orderDetails[0]['shipping_cost'], 2);
                            }
                            ?>

                                <td class="text-right"><?php echo $ship; ?></td>
                            </tr>

                            <tr>
                                <td colspan="3" class="text-right">Total</td>
                                <td class="text-right" style="font-weight:bold;"><?php echo number_format($orderDetails[0]['order_price'], 2); ?></td>
                            </tr>
                            </tbody>




                        </table>	
                    </div>
                </div>
            </div>
        </div>

    </div>

</div>

</div>
</div>
<br><br>
<script>

//View Review 
    function view_review(products_id)
    {

        $.ajax({
            type: 'POST',
            url: '<?php echo base_url(); ?>buyer/myorders/review_view',
            data: {'products_id': products_id},
            success: function (data) {
                $('#myreview').html('');
                $('#myreview').html(data);

            },
            error: function () {
                alert('Somthing Wrong !');
            }
        });
    }


</script>
<script>
    function printDiv(divName) {
        var printContents = document.getElementById(divName).innerHTML;
        var originalContents = document.body.innerHTML;

        document.body.innerHTML = printContents;

        window.print();

        document.body.innerHTML = originalContents;
    }
</script>