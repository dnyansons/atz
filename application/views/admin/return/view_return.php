<?php $this->load->view("admin/common/header"); ?>
<style>
    #loading {
        width: 100%;
        height: 100%;
        top: 0;
        left: 0;
        position: fixed;
        display: block;              
        background-color: rgba(0,0,0,0.4);
        z-index: 99;
        text-align: center;
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
                                    <h4>Return View Detail</h4>
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
                                    <li class="breadcrumb-item"><a href="#">Order Detail</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="page-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="card">
                                <div class="card-header order">
                                    <div class="">
                                        <h4>Return Order ID # <?php echo $order_id; ?> Against Order ID (# <?php echo $returns[0]->orders_id; ?>)</h4>
                                        <h6>Return Status : <?php echo $returns[0]->orders_status_name; ?></h6>
                                    </div>
                                    <div>
                                        <?php if ($returns[0]->orders_status == 23) {
                                            ?>
                                            <button type="button" class="btn btn-primary pull-right" data-toggle="modal" data-target="#actionOrder"><i class="fa fa-check-square"></i> Action On Request</button>
                                            <?php
                                        }
                                        if ($returns[0]->orders_status == 13) {
                                            ?>
                                            <button type="button" class="btn btn-success pull-right" data-toggle="modal" data-target="#actionRefund"><i class="fa fa-check-square"></i>Refund</button>
                                            <?php
                                        }
                                        if ($returns[0]->orders_status != 23) {
                                            ?>
                                            <a href="<?php echo base_url(); ?>admin/return_orders/return_track_order/<?php echo $order_id; ?>" class="btn btn-primary pull-right"><i class="fa fa-check-square"></i> Track Return</a>
                                        <?php } ?>
                                    </div>
                                </div>
                                <div class="card-block">
                                    <!-- Producr Detail -->
                                    <!-- Producr Detail -->
                                    <div class="dt-responsive table-responsive">
                                        <table id="example" class="table table-striped table-bordered nowrap">
                                            <tr>
                                                <th>SR No</th>
                                                <th>Product Name</th>
                                                <th>Unit Price</th>
                                                <th>Product Quantity</th>
                                                <th>Product Price</th>
                                            </tr>
                                            <?php
                                            $sum = 0;
                                            $sum_of_quantities = 0;
                                            $count = 1;
                                            $prod_price = 0;
                                            for ($i = 0; $i < count($orders); $i++) {
                                                //$sum=$sum+$return->order_price;
                                                $sum = $sum + $orders[$i]->grand_price;
                                                $sum_of_quantities = $sum_of_quantities + $orders[$i]->grand_price;
                                                ?>
                                                <tr>
                                                    <td><?php echo $count; ?></td>
                                                    <td><?php echo $orders[$i]->products_name; ?></td>
                                                    <td><?php echo $orders[$i]->unit_price; ?></td>
                                                    <td><?php echo $orders[$i]->products_quantity; ?></td>
                                                    <td><?php
                                                        $prod_price = $prod_price + $orders[$i]->grand_price;
                                                        echo $orders[$i]->grand_price;
                                                        ?></td>
                                                </tr>
                                                <tr>
                                                    <?php
                                                    $count++;
                                                }
                                                ?>

                                            <tr>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                                <th>Return Shipping Cost</th>
                                                <th><?php echo $returns[0]->shipping_cost; ?></th>
                                            </tr>
                                            <tr>
                                                <th colspan="5" style="text-align: center;">Total Order Product Price : <b style="font-size: 18px;color:green;">Rs. <?php echo number_format($prod_price, 2); ?></b></th>
                                            </tr>
                                            <tr>
                                                <th colspan="3">If Buyer Pay</th>
                                                <th colspan="2">Rs. <?php echo number_format($prod_price - $returns[0]->shipping_cost, 2); ?> Refund</th>
                                            </tr>
                                            <tr>
                                                <th colspan="3">If Seller Pay  ( Shipping Cost Deducted from Seller Wallet ) </th>
                                                <th colspan="2">Rs. <?php echo $returns[0]->shipping_cost; ?> Deduct </th>
                                            </tr>
                                            <?php
                                            if ($returns[0]->orders_status == 11) {
                                                ?>
                                                <tr style="background-color:#87ceeb;">
                                                    <td colspan="3">Order Return with Refunded</td>
                                                    <td colspan="2">Shipping Cost Paid By : <b><?php echo $returns[0]->shipping_cost_pay_by; ?></b> </td>
                                                </tr>
<?php } ?>


                                        </table>
                                    </div>
                                    <!--End Producr Detial -->
                                    <!-- End Producr Detial -->

                                    <?php
                                    if ($return_order_shipping->awb_number != 0 && $return_order_shipping->ship_vendor_id == 1) {
                                        //echo '<hr><span style="color:red;">&nbsp;&nbsp;Return AWB Number :  </span><b>'.$returns[0]->awb_number.'</b>&nbsp;&nbsp;<button onclick="awb_show();" class="btn btn-sm btn-info">Click to View</button>';
                                        echo '<hr><span style="color:red;">&nbsp;&nbsp;Return AWB Number :  </span><b>' . $returns[0]->awb_number . '</b>&nbsp;&nbsp;<a href="' . $bath . 'uploads/wayBill_generate/waybill_' . $returns[0]->orders_id . '.pdf" class="btn btn-sm btn-info">Download AWB</a>';
                                        ?>
                                        <div class="card latest-update-card" style="display: none;" id="awbview">
                                            <div class="card-header">
                                                <h5>Return Way Bill</h5>
                                            </div>
                                            <div class="card-block">
                                                <div class="latest-update-box">
                                                    <embed src="<?php echo base_url(); ?>uploads/return_wayBill_generate/retwaybill_<?php echo $return_order_shipping->awb_number; ?>.pdf" style="width: 100%;height: 700px;"/>
                                                </div>
                                            </div>
                                        </div>
                                    <?php }
                                    ?>
                                    <?php
                                    if ($return_order_shipping->awb_number != 0 && $return_order_shipping->ship_vendor_id == 2) {
                                        echo '<hr><span style="color:red;">&nbsp;&nbsp;Return AWB Number :  </span><b>' . $return_order_shipping->awb_number . '</b>&nbsp;&nbsp;<a href="' . $return_order_shipping->awb_url . '" class="btn btn-sm btn-info">Download AWB Label</a>';
                                        ?>

                                    <?php }
                                    ?>


                                    <hr>
                                    <div class="card latest-update-card">
                                        <div class="card-header">
                                            <h5>Buyer Return Reason</h5>
                                        </div>
                                        <div class="card-block">
                                            <div class="latest-update-box">
<?php echo $returns[0]->reason_name; ?>
                                            </div>
                                        </div>
                                    </div>

                                    <hr>
                                    <div class="card latest-update-card">
                                        <div class="card-header">
                                            <h5>Return History</h5>
                                        </div>
                                        <div class="card-block">
                                            <div class="latest-update-box">
                                                <?php
                                                foreach ($return_order_history as $row) {
                                                    ?>
                                                    <div class="row p-t-20 p-b-30">
                                                        <div class="col-auto text-right update-meta">
                                                            <p class="text-muted m-b-0 d-inline"><?php echo date('d M H:i', strtotime($row->date_added)); ?></p>
                                                            <i class="feather icon-check bg-simple-c-yellow  update-icon"></i>
                                                        </div>
                                                        <div class="col">
                                                            <h6><?php echo $row->comment; ?></h6>
                                                            <p class="text-muted m-b-0">ATZCart</p>
                                                        </div>
                                                    </div>
<?php } ?>
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
<div id="actionOrder" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" >Action On Return / Refund Request</h4>
            </div>
            <form class="form-horizontal" action="<?php echo base_url(); ?>admin/return_orders/action_on_return_request" method="post" id="approve_form" onsubmit="return check_order();">
                <input type="hidden" name="return_orders_id" value="<?php echo $order_id; ?>">
                <div class="modal-body">
                    <div id="loading" style="display:none;padding-top: 200px;">
                        <img id="loading-image" src="<?php echo base_url(); ?>assets/admin/processing1.gif" alt="Loading..." style="width:120px;" />
                    </div>
                    <div class="form-group">
                        <div class="col-md-12">
                            <table class="table table-striped table-bordered nowrap dataTable no-footer">
                                <tr>
                                    <th>Total Product Price ( INR )</th>
                                    <td><?php echo number_format($prod_price, 2); ?></td>
                                </tr>
                                <tr>
                                    <th>Shipping Cost ( INR ) - <span style="color:red;font-size:10px;">New</span></th>
                                    <td><?php echo number_format($returns[0]->shipping_cost, 2); ?></td>
                                </tr>
                                <tr>
                                    <th>Return Amount ( INR )</th>
                                    <td><input type="number" class="form-control" name="return_amount" value="<?php echo round($prod_price - $returns[0]->shipping_cost, 2) ?>" style="width:150px;"></td>
                                </tr>
                                <tr>
                                    <th>Current Status</th>
                                    <td><?php echo $returns[0]->orders_status_name; ?></td>
                                </tr>
                                <!--<tr>
                                    <th>Shipping Cost<br><span style="color:red;font-weight: bold;">( Pay By Seller / Buyer )</span></th>
                                    <td>
                                        <input type="radio" name="returnby" value="buyer" checked> Buyer &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        <input type="radio" name="returnby" value="seller"> Seller
                                    </td>
                                </tr>-->
                            </table>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <input type="hidden" name="old_status" value="<?php echo $returns[0]->orders_status; ?>">
                            <select class="form-control" name="orders_status" id="select_status" >
                                <option value="0">Select Status</option>
                                <option value="Return Request Approved">Return Request Approved</option>
                            </select>
                            <div id="err_msg" style="color:red"></div>
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-warning" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-sm btn-info" id="approve_retun_reqst">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div id="actionRefund" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" >Action On Refund</h4>
            </div>
            <form class="form-horizontal" action="<?php echo base_url(); ?>admin/return_orders/action_on_refund" method="post">
                <input type="hidden" name="return_orders_id" value="<?php echo $order_id; ?>">

                <div class="modal-body">
                    <div class="form-group">
                        <div class="col-md-12">
                            <table class="table table-striped table-bordered nowrap dataTable no-footer">
                                <tr>
                                    <th>Total Product Price ( INR )</th>
                                    <td><?php echo number_format($prod_price, 2); ?></td>
                                </tr>
                                <tr>
                                    <th>Shipping Cost ( INR ) - <span style="color:red;font-size:10px;">New</span></th>
                                    <td><?php echo number_format($returns[0]->shipping_cost, 2); ?></td>
                                </tr>
                                <tr>
                                    <th>Refund Amount ( INR )</th>
                                    <td><input readonly type="number" class="form-control" name="refund_amount" value="<?php echo round($prod_price - $returns[0]->shipping_cost, 2) ?>" style="width:150px;"></td>
                                </tr>
                                <tr>
                                    <th>Current Status</th>
                                    <td><?php echo $returns[0]->orders_status_name; ?></td>
                                </tr>
                                <tr>
                                    <th>Shipping Cost<br><span style="color:red;font-weight: bold;">( Pay By Seller / Buyer )</span></th>
                                    <td>
                                        <input type="radio" <?php
                                               if ($returns[0]->shipping_cost_pay_by == 'buyer') {
                                                   echo 'checked="checked"';
                                               }
                                               ?> name="returnby" value="buyer" checked> Buyer &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        <input type="radio" <?php
                                        if ($returns[0]->shipping_cost_pay_by == 'seller') {
                                            echo 'checked="checked"';
                                        }
                                               ?> name="returnby" value="seller"> Seller
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-warning" data-dismiss="modal">Close</button>
                    <button type="submit" onclick="return confirm('Are You Sure ?')" class="btn btn-sm btn-info" id="btnSubmit"> Refund </button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php $this->load->view("admin/common/footer"); ?>
<script>
    $(document).ready(function () {
        $('#example').DataTable();
    });


    function validate()
    {
        var a = $('#orders_status').val();

        if (a == '')
        {
            $('#error_orders_status').html("<span style='color:red;'>Please Select Order Status !</span>");
            return false;
        } else {
            return true;
        }
    }

    function check_order_status(a)
    {
        if (a == 'Case Canceled')
        {
            $("#reason_block").css("display", "block");
            $('#error_orders_status').html("");
        }
        else {
            $('#error_orders_status').html("");
            $("#reason_block").css("display", "none");
        }
    }

</script>
<script type="text/javascript">
    $('#approve_modal').on('show.bs.modal', function (e) {

        var orders_id = $(e.relatedTarget).data('order_id');

        $("#approve_proceed_btn").click(function () {

            $.ajax({
                url: "<?php echo base_url(); ?>admin/refunds/approve_refund_request",
                type: "POST",
                data: {orders_id: orders_id},
                dataType: "json",
                cache: false,
                success: function (response) {

                    if (response.status == "success")
                    {
                        location.reload();
                    }

                    else
                    {
                        alert("something went wrong");
                    }

                }

            });

        });

    });


    function awb_show()
    {
        $("#awbview").toggle();
    }

    $(document).on('click', '#approve_retun_reqst', function () {
        $('#err_msg').html('');
        var selected_option = $('#select_status option:selected').val();
        if (selected_option == 0) {
            $('#err_msg').html("Please Select The status.");
        } else {

            $('#approve_form').submit();
        }
    });


    function check_order()
    {
        var con = confirm('Are You Sure ?');
        if (con == true)
        {
            $('#loading').show();
        } else {
            return false;
        }
    }
</script>