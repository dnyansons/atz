<?php $this->load->view("user/common/header"); ?>
<style>
    .checked_star {
        color: orange;
    }
</style>
<div class="pcoded-content">
    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-header">
                    <div class="row align-items-end">
                        <div class="col-lg-8">
                            <div class="page-header-title">
                                <div class="d-inline">
                                    <h4>Orders View Detail </h4>
                                    <span>Status : <?php echo $sorder["orders_status_name"]; ?></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="page-header-breadcrumb">
                                <ul class="breadcrumb-title">
                                    <li class="breadcrumb-item">
                                        <a href="<?php echo site_url(); ?>user"> <i class="feather icon-home"></i> </a>
                                    </li>
                                    <li class="breadcrumb-item"><a href="#">My Order Detail</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
                if ($sorder["orders_status_name"] != 'Pending') {
                    ?>
                    <div class="card">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-md-12">  
                                    <?php
                                    if ($sorder["orders_status_name"] == 'Accepted') {
                                        echo '<a href="' . base_url() . 'userorder/ship_order/' . $sorder["orders_id"] . '" class="btn btn-success btn-sm">Make Payment</a>';
                                    }
                                    ?>
                                    <?php
                                    if ($sorder['order_tracking_status'] == 1) {
                                        ?>


                                        <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#CancelOrder">Cancel Order</button>


    <?php } ?>
    <?php
    if ($this->session->userdata('user_role') == 'seller') {
        ?>
                                        <a type="button" href="<?php echo base_url(); ?>seller/myorders/track_order/<?php echo $sorder['orders_id']; ?>" class="btn btn-success btn-sm pull-right">Track Order</a>
                                    <?php } else {
                                        ?>
                                        <button type="button" class="btn btn-warning btn-sm pull-right" onclick="printDiv('printableArea')" target="_blank">Print Invoice!</button>

                                        <a type="button" href="<?php echo base_url(); ?>buyer/myorders/track_order/<?php echo $sorder['orders_id']; ?>" class="btn btn-success btn-sm pull-right">Track Order</a>



    <?php } ?>

                                </div>
                            </div>
                        </div>
                    </div>
<?php } ?>
                <div class="page-body">

                    <div class="row">
                        <div class="col-sm-12">

                            <div class="card" id="printableArea">
                                <h6 style="text-align:center;"><?php echo $this->session->flashdata('message'); ?></h6>

                                <div class="card-block">
                                    <h4 style="text-align:center;">Order Invoice</h4>
                                    <br>


                                    <br />
                                    <div class="dt-responsive table-responsive">


                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th class="text-left">Product</th>
                                                    <th class="text-right">Quantity</th>
                                                    <th class="text-right">Unit Price</th>
                                                    <th class="text-right">Total</th>
                                                </tr>
                                            </thead>
<?php
echo'<tbody>';
$sub_total = 0;
foreach ($orderDetails as $row) {
    $sub_total = $sub_total + $row['final_price'];
    echo '<tr>';

    echo'<td class="text-left"><b>' . $row["product_name"] . '</b><br>';




    $pro_sp = json_decode($row['product_specifications'], true);

    // print_r($pro_sp);

    foreach ($pro_sp as $sp) {
        //print_r($sp);
        // print_r($spd);
        if (isset($sp['specifications']['primary'])) {

            //Primary 
            echo $sp['specifications']['primary']['specification_name'] . ' : ' . $sp['specifications']['primary']['spec_value'];
            echo '<br>';
        }

        foreach ($sp['specifications']['secondary'] as $secondary) {
            //Secondary
            echo $secondary['specification_name'];
            echo ' : ' . $secondary['spec_value'];
            echo ' Qty: ' . $secondary['quantity'];
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
}

echo'</tbody>';

///////////// Total //////////
////////////////////////////////
?>
                                            <tr>
                                                <td colspan="3" class="text-right">Sub-Total</td>
                                                <td class="text-right"><?php echo number_format($sub_total, 2); ?></td>
                                            </tr>
                                            <?php
                                            //Check Shipping Status
                                            if ($orderDetails[0]['shippment_type'] == 'Free' && $orderDetails[0]['order_price'] >= 500) {
                                                $ship = '0.00';
                                            } else {
                                                $ship = number_format($orderDetails[0]['shipping_cost'], 2);
                                            }
                                            ?>
                                            <tr>
                                                <td colspan="3" class="text-right">Flat Shipping Rate</td>
                                                <td class="text-right"><?php echo $ship; ?></td>
                                            </tr>

                                            <tr>
                                                <td colspan="3" class="text-right">Total</td>
                                                <td class="text-right" style="font-weight:bold;"><?php echo number_format($orderDetails[0]['order_price'], 2); ?></td>
                                            </tr>
                                            </tbody>


                                            <?php
                                            echo'<tr> 
					 <th colspan="3">Status</th> 
					 <td colspan="4">' . $sorder["orders_status_name"] . '</td> 
				 </tr> 
				 <tr> 
					 <th colspan="3">Delivery Address</th> 
					 <td colspan="4"><b>' . $sorder["delivery_name"] . '</b> ,<br>' . $sorder["delivery_street_address"] . ' ,' . $sorder["delivery_city"] . ' ,<br>' . $sorder["delivery_postcode"] . ' ,' . $sorder["delivery_state"] . '</td> 
				 </tr> 
				 <tr> 
					 <th colspan="3" >Payment Method</th> 
					 <td colspan="4">' . $sorder["payment_method"] . '</td> 
				 </tr>
				 <tr> 
					 <th colspan="3" >Shipping Method</th> 
					 <td colspan="4">' . $sorder["shipping_method"] . '</td> 
				 </tr>
				 <tr> 
					 <th colspan="3" >Currency</th> 
					 <td colspan="4">' . $sorder["currency"] . '</td> 
				 </tr>
				 <tr> 
					 <th colspan="3" >Order Date</th> 
					 <td colspan="4">' . date('d M Y H:i', strtotime($sorder["date_purchased"])) . '</td> 
				 </tr>';
                                            ?>

                                        </table>	
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>


        <!-- Modal Product View -->
        <div id="myModal" class="modal fade" role="dialog">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Order View</h4>
                    </div>
                    <div class="modal-body">
                        <p id="myorder"></p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>

            </div>
        </div>

        <!-- Modal Review View -->
        <div id="myReview" class="modal fade" role="dialog">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Product Review</h4>
                    </div>
                    <div class="modal-body">
                        <p id="myreview"></p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>

            </div>
        </div>


        <div id="CancelOrder" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" >Cancel Order</h4>
                    </div>
                    <form class="form-horizontal" action="<?php echo base_url(); ?>buyer/myorders/cancel_order" method="post">

                        <input type="hidden" name="order_id" value="<?php echo $sorder['orders_id']; ?>">
                        <div class="modal-body">
                            <p style="color:red;text-align:center;">Note : If Order Pick From Seller then Shipping Cost not refunded</p>
                            <div class="form-group">
                                <div class="col-md-12">
                                    <div class="row">
                                        <table class="table table-striped table-bordered nowrap dataTable">
                                            <tr>
                                                <td>Total Order Price </td>
                                                <td><?php echo $sorder['order_price']; ?></td>
                                            </tr> 
                                            <tr>
                                                <td>Shipping Cost</td>
                                                <td><?php echo $sorder['shipping_cost']; ?></td>
                                            </tr>
                                            <tr>
                                                <td>Current Order Status</td>
                                                <td><?php echo $sorder['orders_status_name']; ?></td>
                                            </tr>
                                        </table>

                                        <hr>
                                        <div class="col-md-12">
                                            <label><b>Select Cancel Reason</b></label>
                                            <select class="form-control" name="cancel_reason" required>
                                                <option value="">Select Cancel Reason</option>
<?php
foreach ($reason as $re) {
    echo'<option value="' . $re["reason_id"] . '">' . $re["reason_name"] . '</option>';
}
?>
                                            </select>
                                        </div>

                                        <div class="col-md-12">
                                            <br>
                                            <label><b>Any Other ?</b></label>
                                            <textarea class="form-control" name="other_reason"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>


                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-sm btn-warning" data-dismiss="modal">Close</button>
                            <button type="submit" onclick="return confirm('Are you sure want to Cancel Order ?')" class="btn btn-sm btn-info" id="btnSubmit">Canecel Order</button>
                        </div>    
                    </form>
                </div>

            </div>
        </div>



    </div>
</div>
<?php $this->load->view("user/common/footer"); ?>
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