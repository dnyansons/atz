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
                                    <h4>Refund View Detail</h4>
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
                                        <h4>Order ID # <?php echo $order_id; ?></h4>
                                        <h6>Refund Status : <?php echo $refund[0]->orders_status; ?></h6>
                                    </div>
                                    <div>
                                        <?php
                                        if ($refund[0]->orders_status != 'ATZCART.COM Approved') {
                                            ?>
                                            <button type="button" class="btn btn-primary pull-right" data-toggle="modal" data-target="#actionOrder"><i class="fa fa-check-square"></i> Action On Request</button>
                                            <?php
                                        } else {
                                            echo '<div class="btn btn-success" style="color:#fff;font-weight:bold">Refunded</div>';
                                        }
                                        ?>	

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
                                                <th>Product Price</th>
                                                <th>Product Quantity</th>
                                            </tr>
                                            <?php
                                            $sum = 0;
                                            $sum_of_quantities = 0;
                                            $i = 1;
                                            foreach ($refund as $fund) {
                                                $sum = $sum + $fund->final_price;
                                                $sum_of_quantities = $sum_of_quantities + $fund->products_quantity;
                                                ?>

                                                <tr>
                                                    <td><?php echo $i; ?></td>
                                                    <td><?php echo $fund->products_name; ?></td>
                                                    <td><?php echo $fund->final_price; ?></td>
                                                    <td><?php echo $fund->products_quantity; ?></td>
                                                </tr>
                                                <tr>

                                                    <?php
                                                    $i++;
                                                }
                                                ?>
                                            <tr>

                                                <th></th>
                                                <th>Total</th>
                                                <th><?php echo number_format($sum, 2); ?></th>
                                                <th><?php echo $sum_of_quantities; ?></th>
                                            </tr>

                                        </table>
                                    </div>
                                    <!--End Producr Detial -->
                                    <!-- End Producr Detial -->



                                    <hr>
                                    <div class="card latest-update-card">
                                        <div class="card-header">
                                            <h5>Supplier Refund Reason</h5>

                                        </div>
                                        <div class="card-block">
                                            <div class="latest-update-box">

                                                <?php echo $refund[0]->supplier_reason; ?>

                                            </div>
                                        </div>		
                                    </div>






                                    <hr>
                                    <div class="card latest-update-card">
                                        <div class="card-header">
                                            <h5>Refund History</h5>

                                        </div>
                                        <div class="card-block">
                                            <div class="latest-update-box">
                                                <?php
                                                foreach ($refund_history as $row) {
                                                    ?>
                                                    <div class="row p-t-20 p-b-30">
                                                        <div class="col-auto text-right update-meta">
                                                            <p class="text-muted m-b-0 d-inline"><?php echo date('d M H:i', strtotime($row->created_at)); ?></p>
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
            <form class="form-horizontal" action="<?php echo base_url(); ?>admin/refunds/action_on_refund_request" method="post">

                <input type="hidden" name="orders_id" value="<?php echo $order_id; ?>">
                <div class="modal-body">
                    <p style="color:red;text-align:center;">Note : If Order Pick From Seller then Shipping Cost not refund to Buyer</p>
                    <div class="form-group">
                        <div class="col-md-12">
                            <table class="table table-striped table-bordered nowrap dataTable no-footer">

                                <tr>
                                    <th>Request Amount ( INR )</th>
                                    <td><?php echo $refund[0]->order_price; ?></td>
                                </tr>
                                <?php if ($refund[0]->shipping_type == 'Free') { ?>
                                    <tr>
                                        <th>Shipping Cost</th>
                                        <td style="color:green;">Free</td>
                                    </tr>
                                <?php } else { ?>
                                    <tr>
                                        <th>Shipping Cost</th>
                                        <td style="color:green;"><?php echo $refund[0]->shipping_cost; ?></td>
                                    </tr>
                                <?php } ?>
                                <tr>
                                    <th>Refund Amount ( Suggestion )</th>
                                    <td><?php
                                        if ($refund[0]->shipping_type == 'Free') {
                                            echo number_format($refund[0]->order_price, 2);
                                        } else {
                                            echo number_format($refund[0]->order_price - $refund[0]->shipping_cost, 2);
                                        }
                                        ?></td>
                                </tr>
                                <tr>
                                    <th>Refund Amount ( INR )</th>
                                    <td><input type="text" class="form-control" name="refund_amount" value="<?php echo $refund[0]->refund_amount; ?>" style="width:150px;" required=""></td>
                                </tr>
                                <tr>
                                    <th>Current Status</th>
                                    <td><?php echo $refund[0]->orders_status; ?></td>
                                </tr>
                            </table>

                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <input type="hidden" name="old_status" value="<?php echo $refund[0]->orders_status; ?>">
                            <select class="form-control" name="orders_status">
                                <option value="">Select Status</option>
                                <option value="ATZCART.COM in Progress">ATZCART.COM in Progress</option>
                                <option value="ATZCART.COM Approved">ATZCART.COM Approved</option>
                                <option value="ATZCART.COM Rejected">ATZCART.COM Rejected</option>
                            </select>
                        </div>
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


<div class="modal fade" id="approve_modal" tabindex="-1" role="dialog" style="z-index: 1050; display: none;" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirmation</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="action_on_confirmation">

                </form>
                <p>Are you sure to proceed for this?</p>
            </div>
            <div class="modal-footer">
                <button type="button" id="approve_no_btn" class="btn btn-default waves-effect" data-dismiss="modal">No</button>
                <button type="button" id="approve_proceed_btn" class="btn btn-primary waves-effect waves-light "><i class="fa fa-location-arrow"></i> Proceed</button>
            </div>
        </div>
    </div>
</div>




<div class="modal fade" id="reject_modal" tabindex="-1" role="dialog" style="z-index: 1050; display: none;" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirmation</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Are you sure to proceed for this?</p>
            </div>
            <div class="modal-footer">
                <button type="button" id="rejet_no_btn" class="btn btn-default waves-effect " data-dismiss="modal">No</button>
                <button type="button" id="rejet_proceed_btn" class="btn btn-primary waves-effect waves-light "><i class="fa fa-location-arrow"></i> Proceed</button>
            </div>
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

</script>

<script type="text/javascript">

    $('#reject_modal').on('show.bs.modal', function (e) {

        var orders_id = $(e.relatedTarget).data('order_id');

        $("#rejet_proceed_btn").click(function () {


            $.ajax({
                url: "<?php echo base_url(); ?>admin/refunds/reject_refund_request",
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

</script>

<script>

    $(".modal").on("hidden.bs.modal", function () {
        //location.reload();
    });

</script>