<?php //echo "<pre>"; print_r($order_details); ?>
<?php //echo "<pre>"; print_r($order_products); exit();?>
<?php $this->load->view("user/common/header"); ?>
<div class="pcoded-content">
    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-wrapper">
                    <div class="page-body">
                        <div class="container">
                            <div>
                                <div class="card">
                                    <div class="card-block">
                                        <div class="row invoive-info">
                                            <div class="col-md-4 col-xs-12 invoice-client-info">
                                                <h6>Client Delivery Details:</h6>
                                                <h6 class="m-0">
                                                    <?php echo $order_details->delivery_name;?>
                                                    <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#approveCancelOrder">Approve Cancel Request</button>
                                                </h6>
                                                <p class="m-0 m-t-10">
                                                    <?php 
                                                        echo "<strong>$order_datails->delivery_name </strong>"
                                                            . "$order_details->delivery_street_address "
                                                            . "$order_details->delivery_suburb "
                                                            . "$order_details->delivery_city "
                                                            . "$order_details->delivery_state, "
                                                            . "$order_details->delivery_postcode ";
                                                    ?>
                                                </p>
                                                <p class="m-0"><?php echo $order_details->user_telephone;?></p>
                                                <p><a href="#"><?php echo $order_details->user_email_address;?></a></p>
                                            </div>
                                            <div class="col-md-4 col-sm-6">
                                                <h6>Order Information :</h6>
                                                <table class="table table-responsive invoice-table invoice-order table-borderless">
                                                    <tbody>
                                                        <tr>
                                                            <th>Placed On :</th>
                                                            <td><?php echo date("d-m-Y",strtotime($order_details->date_purchased));?></td>
                                                        </tr>
                                                        <tr>
                                                            <th>Status :</th>
                                                            <td>
                                                                <span class="label label-warning"><?php echo $order_details->orders_status_name;?></span>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <th>Id :</th>
                                                            <td>
                                                                #ORD<?php echo $order_details->orders_id;?>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="col-md-4 col-sm-6">
                                                <h6 class="m-b-20">Others</h6>
                                                <table class="table table-responsive invoice-table invoice-order table-borderless">
                                                    <tbody>
                                                        <?php if($order_details->orders_status == 10) {?>
                                                        <tr>
                                                            <td>
                                                                <a href="<?php echo site_url('seller/orders/order_reject/').$order_details->orders_id;?>" class="label label-danger">Reject</a>
                                                            </td>
                                                        </tr>
                                                        <?php } ?>
                                                        <tr>
                                                            <th>
                                                                <a href="<?php echo site_url('seller/orders/track_order/').$order_details->orders_id;?>" class="label label-warning">Track Order</a>
                                                            </th>
                                                        </tr>
                                                        
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="table-responsive">
                                                    <table class="table  invoice-detail-table">
                                                        <thead>
                                                            <tr class="thead-default">
                                                                <th>Description</th>
                                                                <th>Quantity</th>
                                                                <th>Amount</th>
                                                                <th>Total</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php $total = 0; foreach($order_products as $product):?>
                                                            <tr>
                                                                <td>
                                                                    <h6><?php echo $product->products_name;?></h6>
                                                                    <p>
                                                                        <?php $spec = json_decode($product->product_specifications);?>
                                                                        <?php 
                                                                        $spec = $spec->specifications[0]->specifications;
                                                                        if($spec->primary->primary){
                                                                            echo $spec->primary->primary." ";
                                                                            if($spec->secondary[0]->specification_name){
                                                                                echo $spec->secondary[0]->specification_name;
                                                                            }
                                                                        }
                                                                        ?>
                                                                    </p>
                                                                </td>
                                                                <td><?php echo $product->products_quantity;?></td>
                                                                <td><?php echo $product->vendors_price;?></td>
                                                                <td>
                                                                    <?php echo $product->products_quantity * $product->vendors_price;?>
                                                                </td>
                                                            </tr>
                                                            <?php $total = $total + ($product->products_quantity * $product->vendors_price);?>
                                                            <?php endforeach;?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <table class="table table-responsive invoice-table invoice-total">
                                                    <tbody>
                                                        <tr>
                                                            <th>Sub Total :</th>
                                                            <td><?php echo $total;?></td>
                                                        </tr>
                                                        <tr>
                                                            <th>Taxes (18%) :</th>
                                                            <td><?php echo ($total * 18) / 100;?></td>
                                                        </tr>
                                                        <tr class="text-info">
                                                            <td>
                                                                <hr />
                                                                <h5 class="text-primary">Your receivable :</h5>
                                                            </td>
                                                            <td>
                                                                <hr />
                                                                <h5 class="text-primary"><?php echo $total - (($total * 18) / 100);?></h5>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <h6>Terms And Condition :</h6>
                                                <p>asdf asdf </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row text-center">
                                    <div class="col-sm-12 invoice-btn-group text-center">
                                        <a href="<?php echo site_url();?>seller/orders" type="button" class="btn btn-danger waves-effect m-b-10 btn-sm waves-light">Orders</a>
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
<div id="approveCancelOrder" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" >Cancel Order Request</h4>
            </div>
            <form class="form-horizontal" action="<?php echo base_url(); ?>seller/orders/approve_cancel_order_request" method="post">

                <input type="hidden" name="order_id" value="<?php echo $order_details->orders_id; ?>">
                <div class="modal-body">
                    <p style="color:red;text-align:center;">Note : If Order Pick From Seller then Shipping Cost not refund to Buyer</p>
                    <div class="form-group">
                        <div class="col-md-12">
                            <div class="row">

                                <div class="col-md-12">Total Order Price : <b><?php echo $order_details->order_price; ?></b></div>

                                <div class="col-md-12">Shipping Cost : <b><?php echo $order_details->shipping_cost; ?></b></div>
                                <div class="col-md-12">Current Order Status : <b><?php echo $order_details->orders_status_name; ?></b></div>
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
<?php $this->load->view("user/common/footer"); ?>
