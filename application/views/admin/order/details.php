<?php $this->load->view("admin/common/header"); ?>
<div class="pcoded-content">
    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-header">
                    <div class="row align-items-end">
                        <div class="col-lg-8">
                            <div class="page-header-title">
                                <div class="d-inline">
                                    <h4>Order Details</h4>
                                    <span></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="page-header-breadcrumb">
                                <ul class="breadcrumb-title">
                                    <li class="breadcrumb-item">
                                        <a href="<?php echo site_url(); ?>admin/dashboard"> <i class="feather icon-home"></i> </a>
                                    </li>
                                    <li class="breadcrumb-item"><a href="#">Orders Details</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <?php if ($orderDetails[0]['orders_status_name'] == "Pending") { ?>
                    <div class="card">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-md-12">                                  

                                    <button type="button" class="btn btn-primary waves-effect pull-right" style="color:#fff !important;">Order Pending</button>


                                </div>
                            </div>
                        </div>
                    </div>
                <?php
                } else {
                    ?>
                    <div class="card">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-md-12">                                  

                                    <a type="button" href="<?php echo base_url(); ?>admin/order/track_order/<?php echo $orderDetails[0]['orders_id']; ?>" class="btn btn-success btn-sm btn-outline-info waves-effect pull-right">Track Order</a>

                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
                 <?php
                                            //Check Shipping Status
                                            if ($orderDetails[0]['shippment_type'] == 'Free' && $orderDetails[0]['order_price'] >= 500) {
                                                $ship = '<span style="color:red;"><del>'.number_format($orderDetails[0]['shipping_cost'], 2).'</del></span><br>0.00 ';
                                            } else {
                                                $ship = number_format($orderDetails[0]['shipping_cost'], 2);
                                            }
                                            ?>
                <div class="page-body">
                    <div id="printOrder">
                        <div class="row">
                            <div class="col-md-6 col-lg-6">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h4 ><i class="fa fa-shopping-cart"></i> Order Details</h4>
                                    </div>
                                    <table class="table">
                                        <tbody>

                                            <tr>
                                                <td>
                                                    <i class="fa fa-calendar fa-fw"></i>
                                                </td>
                                                <td><?php echo $orderDetails[0]['date_purchased']; ?></td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <i class="fa fa-credit-card fa-fw"></i>
                                                </td>
                                                <td><?php echo $orderDetails[0]['payment_method']; ?></td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <i class="fa fa-truck fa-fw"></i>
                                                </td>
                                                <td><?php echo $ship; ?></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-6">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h4 ><i class="fa fa-user"></i> Customer Details</h4>
                                    </div>
                                    <table class="table">
                                        <tr>
                                            <td style="width: 1%;">
                                                <i class="fa fa-user fa-fw"></i>
                                            </td>
                                            <td> 
                                                <?php echo $orderDetails[0]['user_name']; ?>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td>
                                                <i class="fa fa-envelope-o fa-fw"></i>
                                            </td>
                                            <td>
                                                <a href="mailto:<?php echo $orderDetails[0]['user_email_address']; ?>">
                                                    <?php echo $orderDetails[0]['user_email_address']; ?>
                                                </a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <i class="fa fa-phone fa-fw"></i>
                                            </td>
                                            <td><?php echo $orderDetails[0]['user_telephone']; ?></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>

                        </div>
                        
                        <br />
                          <div class="page-body">
                            <div id="printableArea">
                                <div class="row">
                                    <div class="col-md-12 col-lg-12">
                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                                <h4 ><i class="fa fa-shopping-cart"></i> Payment Details</h4>
                                            </div>
                                            <table class="table table-bordered">
                                                <tr>
                                                    <th>Order ID</th>
                                                    <th>Transaction ID</th>
                                                    <th>Transaction Date</th>
                                                    <th>Payment Mode</th>
                                                    <th>Payment Method</th>
                                                    <th>Total Amount</th>
                                                </tr>
                                                <?php
                                                $i = 1;
                                                $transaction_id='';
                                                foreach ($paymentDetails as $key => $value) {
                                                    # code...
                                                    $transaction_id=$value->payment_id;
                                                
                                                    ?>
                                                    <tr>
                                                        <td>#<?php echo $orderDetails[0]['orders_id']; ?></td>
                                                        <td><?php echo $value->payment_id; ?></td>
                                                        <td><?php echo $value->created_at; ?></td>
                                                        <td><?php echo $value->payment_by; ?></td>
                                                        <td><?php echo $value->method; ?></td>
                                                        <td><strong>&#x20b9;</strong>&nbsp;<?php echo number_format($orderDetails[0]['order_price'], 2); ?></td>
                                                    </tr>
                                                    <?php $i++;
                                                }
                                                ?>
                                            </table>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <div class="page-body">
                            <div id="printableArea">
                                <div class="row">
                                    <div class="col-md-12 col-lg-12">
                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                                <h4 ><i class="fa fa-shopping-cart"></i> Product Description</h4>
                                            </div>
                                            <table class="table table-bordered">
                                                <tr>
                                                    <th>Prod ID</th>
                                                    <th>Image</th>
                                                    <th>Name</th>
                                                    <th>Dimension ( w * h * l )</th>
                                                    <th>Weight/Per</th>
                                                </tr>
                                                <?php
                                                $i = 1;
                                                foreach ($orderDetails as $row) {
                                                    ?>
                                                    <tr>
                                                        <td><?php echo 'PRD : ' . $row['product_id']; ?></td>
                                                        <td><img src="<?php echo $row['product_image']; ?>" style="width:80px;" ></td>
                                                        <td><?php echo $row['product_name']; ?></td>
                                                        <td><?php echo $row['width'] . '*' . $row['height'] . '*' . $row['length']; ?></td>
                                                        <td><?php echo $row['weight']; ?></td>
                                                    </tr>
                                                    <?php $i++;
                                                }
                                                ?>
                                            </table>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <br />

                        <div class="row">
                            <div class="col-md-12">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h4 ><i class="fa fa-info-circle"></i> Order (#<?php echo $orderDetails[0]['orders_id']; ?>)</h4>
                                    </div>
                                    <div class="panel-body">
                                        <div class="col-md-12">
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th style="width: 50%;" class="text-left">Payment Address</th>
                                                        <th style="width: 50%;" class="text-left">Shipping Address</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td class="text-left">

                                                            <?php echo $orderDetails[0]['delivery_street_address']; ?><br />
                                                            <?php echo $orderDetails[0]['retailers_city']; ?><br />
                                                            <?php echo $orderDetails[0]['retailers_state']; ?><br />
                                                            <?php echo $orderDetails[0]['retailers_postcode']; ?><br />
<?php echo $orderDetails[0]['payment_country']; ?><br />
                                                        </td>
                                                        <td class="text-left">
                                                            <?php echo $orderDetails[0]['delivery_street_address']; ?><br />
                                                            <?php echo $orderDetails[0]['delivery_city']; ?><br />
                                                            <?php echo $orderDetails[0]['delivery_state']; ?><br />
                                                            <?php echo $orderDetails[0]['delivery_postcode']; ?><br />
<?php echo $orderDetails[0]['delivery_country']; ?><br />
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
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


                                                    foreach ($pro_sp['specifications'] as $sp) {
                                                        //print_r($sp);
                                                        // print_r($spd);
                                                        if (isset($sp['specifications']['primary'])) {

                                                            //Primary 
                                                            echo $sp['specifications']['primary']['specification_name'] . ' : ' . $sp['specifications']['primary']['spec_value'];
                                                            echo '<br>';
                                                        }

                                                        foreach ($sp['specifications']['secondary'] as $secondary) {
                                                            //Secondary
                                                             if ($sp['specifications']['primary']['spec_value'] != $secondary['spec_value']) {
                                                                echo $secondary['specification_name'];
                                                              echo ' : ' . $secondary['spec_value'].' |';
                                                            }

                                                           
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
                                               
                                                <tr>
                                                    <td colspan="3" class="text-right">Flat Shipping Rate</td>
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
                    <br />

                </div>
            </div>
        </div>
    </div> 
    <!-- Modal -->
    <div id="acceptOrder" class="modal fade" role="dialog">
        <div class="modal-dialog modal-lg">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Shipping Details</h4>
                </div>
                <form class="form-horizontal" action="<?php echo base_url(); ?>user/orders/accept" method="post">

                    <input type="hidden" name="order_id" value="<?php echo $orderDetails[0]['orders_id']; ?>">
                    <div class="modal-body">
                        <p style="color:red;text-align:center;">Note : Add Proper Dimensions of actual order </p>
                        <div class="form-group">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-12 alert-info">Total Order Quantity : <b><?php echo $order_quantity; ?></b></div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-10">Dimensions in CM</label>
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-3">
                                        <label>Length</label>
                                        <input type="text" id="length" name="length" placeholder="Length" class="form-control" required>
                                    </div>
                                    <div class="col-md-3">
                                        <label>Width</label>
                                        <input type="text" id="width" name="width" placeholder="Width" class="form-control" required>
                                    </div>
                                    <div class="col-md-3">
                                        <label>Height</label>
                                        <input type="text" id="height" name="height" placeholder="Height" class="form-control" required>
                                    </div> 
                                    <div class="col-md-3">
                                        <label class="control-label">Actual Order Weight</label>
                                        <input type="text" id="weight" value="" name="weight" placeholder="0" class="form-control" required>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-12"><b>Select Pick Up Address</b></label>
                            <div class="col-md-12">
                                <?php
                                foreach ($paddress as $paddr) {
                                    ?>
                                    <input type="radio" name="pick_id" value="<?php echo $paddr['pick_id']; ?>" required> <?php echo $paddr['seller_name'] . '<br>' . $paddr['address_type'] . ' ' . $paddr['address'] . '<br>' . $paddr['state'] . ' ' . $paddr['pincode'] . ' Mob: ' . $paddr['seller_mobile']; ?><hr>
                                    <?php
                                }
                                ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-12"><b>Select Pick Up Days (After Payment Done)</b></label>
                            <div class="col-md-12">
                                <select name="pick_days" class="form-control" required>
                                    <option value="">-- Select --</option>
                                    <option value="1">1 Day</option>
                                    <option value="2">2 Day</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-12"><b>Pick Up Time is Must Before 5:30 PM on Pick Up Date</b></label>

                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-sm btn-warning" data-dismiss="modal">Close</button>
                        <button type="submit" onclick="return confirm('Are You Sure ?')" class="btn btn-sm btn-info" id="btnSubmit">Submit</button>
                    </div>    
                </form>
            </div>

        </div>
    </div>

    <div id="approveCancelOrder" class="modal fade" role="dialog">
        <div class="modal-dialog modal-lg">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" >Cancel Order Request</h4>
                </div>
                <form class="form-horizontal" action="<?php echo base_url(); ?>user/orders/approve_cancel_order_request" method="post">

                    <input type="hidden" name="order_id" value="<?php echo $orderDetails[0]['orders_id']; ?>">
                    <div class="modal-body">
                        <p style="color:red;text-align:center;">Note : If Order Pick From Seller then Shipping Cost not refund to Buyer</p>
                        <div class="form-group">
                            <div class="col-md-12">
                                <div class="row">

                                    <div class="col-md-12">Total Order Price : <b><?php echo $orderDetails[0]['order_price']; ?></b></div>

                                    <div class="col-md-12">Shipping Cost : <b><?php echo $orderDetails[0]['shipping_cost']; ?></b></div>
                                    <div class="col-md-12">Current Order Status : <b><?php echo $orderDetails[0]['orders_status_name']; ?></b></div>
                                </div>
                            </div>
                        </div>


                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-sm btn-warning" data-dismiss="modal">Close</button>
                        <button type="submit" onclick="return confirm('Are You Sure ?')" class="btn btn-sm btn-info" id="btnSubmit">Approve</button>
                    </div>    
                </form>
            </div>

        </div>
    </div>

</div>



<script>
    function printDiv(divName) {
        var printContents = document.getElementById(divName).innerHTML;
        var originalContents = document.body.innerHTML;

        document.body.innerHTML = printContents;

        window.print();

        document.body.innerHTML = originalContents;
    }

</script>
<script>

    $(document).ready(function () {

        $('.date').datepicker({
            format: "dd/mm/yyyy",
            autoclose: true,
        });

    });

</script>
<?php $this->load->view("admin/common/footer"); ?>
