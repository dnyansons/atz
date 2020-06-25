<style>
    //@import url(/@sc/trade-contract/entries/ta-buynow/index-part1.51fb78e7.css?_v=51fb78e7a3ee8e51.css);
    .price{
        font-weight: 500 !important;
        font-size: 13px !important;
        color: #000000ad !important;
    }
    .biz-action-bar-button{
        background-color: #bd081b !important;
    }
    body {
        background-color: #F7F8FA
    }
    .draft {
        padding: 20px;
        max-width: 1200px;
        min-width: 700px;
        background-color: #F7F8FA;
        margin: auto
    }
    .draft .next-icon-help:before,
    .draft .next-icon-success:before {
        color: #1DC11D
    }
    .draft .next-form-item {
        margin-bottom: 12px
    }
    .draft .draft-taBlock {
        border: 1px solid #FFB380
    }
    .draft .draft-productsAmountBlock {
        display: -ms-flexbox;
        display: flex;
        -ms-flex-align: end;
        align-items: flex-end;
        -ms-flex-direction: column;
        flex-direction: column
    }
    .next-form-item-control {
        line-height: 28px
    }
    .next-form-item-control .next-btn-text.next-btn-medium {
        margin: 0
    }
    .remarkContent_1 .next-form-item-control,
    .remarkInput_1 .next-form-item-control {
        width: 100%
    }
    .remarkContent_1 .next-form-item-control .next-input,
    .remarkInput_1 .next-form-item-control .next-input {
        width: 100%
    }
    .biz-block-card-wrap {
        margin: 0 0 20px;
        padding-bottom: 20px
    }
    .bg-color{
        background-color: unset !important;
    }
    .product .pic{
        width: 30% !important;
    }
    .wd100{
        width: 100% !important;
    }
    .font-13{
        font-size: 13px !important;
    }
</style>

</head>

<body style="background:#f3f3f5 url(src/assets/front/images/back.png);background-repeat: no-repeat;" id="overlay">
    <div class="d-block d-sm-none">
        <div class="header-wrap demonavheader">
            <div class="site-header with-shadow">
                <div class="main-header">
                    <a class="header-item btn-search " onclick="openNav()"><i class="fa fa-bars"></i></a>
                    <a class="header-item logo" href="/"><img src="<?php echo base_url(); ?>assets/front/images/logo/logo.png" alt=""></a>
                </div>
                <div class="search-text">
                    <div class="search-bar">
                        <div class="searchbar">
                            <input class="search_input" type="text" name="" placeholder="Search...">
                            <a href="#" class="search_icon"><i class="fa fa-search"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="main" style="background-color: #f7f8fa;">

        <div id="draft" class="draft">


            <div class='alert alert-success alert-dismissible'>
                <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                <strong>Payment Received !</strong> Order Placed Successfully !</div>
            <div>
                <div class="next-step next-step-arrow next-step-horizontal base-step draft-stepBlock stepBlock_1">

                    <div data-spm-click="gostr=/sc.1;locaid=d_step;step=WaitforResponse" class="next-step-item next-step-item-wait"
                         data-spm-anchor-id="a2756.trade-order-standard.0.d_step" style="width: auto;">
                        <div class="next-step-item-container">
                            <div class="next-step-item-title">
                                Start Order</div>
                        </div>
                    </div>

                    <div data-spm-click="gostr=/sc.1;locaid=d_step;step= Confirm Receipt" class="next-step-item next-step-item-wait next-step-item-last"
                         style="width: auto;">
                        <div class="next-step-item-container">
                            <div class="next-step-item-title">
                                Ship & Payment</div>
                        </div>
                    </div>

                    <div class="next-step-item next-step-item-wait next-step-item-process" style="width: auto;">
                        <div class="next-step-item-container">
                            <div class="next-step-item-title">
                                Order Success</div>
                        </div>
                    </div>


                </div>
            </div>

            <br>
            <div class="biz-action-bar">
                <div class="biz-action-bar-inner">

                    <div>
                        <a href="<?php echo base_url(); ?>buyer/myorders/track_order/<?php echo $orders_id; ?>" class="next-btn next-btn-primary next-btn-large biz-action-bar-button">Track Order </a> 
                    </div>
                </div>
            </div>

            <div>

                <?php
                if ($product_details) {
                    ?>
                    <div id="productsBlock_1" class="biz-block-card-wrap biz-block-card-wrap-undefined card draft-productsBlock">
                        <div class="biz-block-card-header wd100">
                            <h3 class="biz-block-card-title">
                                <span data-i18n-appname="" data-i18n-ns="ta.order.com.products" data-i18n-key="title">Product Details</span>
                            </h3>
                        </div>
                        <div class="biz-block-card-body">
                            <div id="productsHeader_1" class="block draft-productsHeader">
                                <div class="biz-supplierLite">
                                    <div class="next-row biz-supplierLite-header">
                                        <div class="next-col next-col-16">
                                            <span class="biz-supplierLite-label"><span>Supplier</span></span>
                                            <span
                                                class="biz-supplierLite-value">
                                                <span>
    <?php echo $seller_info['first_name']; ?> <?php echo $seller_info['last_name']; ?> <?php echo $seller_info['company_name']; ?>
                                                </span>
                                                <!-- <img alt="" class="biz-supplierLite-icon" src="assets/images/product/1.jpg"> -->
                                            </span>
                                        </div>
                                        <div class="next-col biz-supplierLite-showaction"><span onclick = "show_details()">Show supplier's details</span></div>
                                    </div>
                                    <div class="biz-supplierLite-body" id="seller_details">
                                        <div class="next-row">
                                            <div class="next-col next-col-3 biz-supplierLite-label"><span>Supplier Name</span></div>
                                            <div class="next-col biz-supplierLite-value"><?php echo $seller_info['first_name']; ?> <?php echo $seller_info['last_name']; ?></div>
                                        </div>
                                        <div class="next-row">
                                            <div class="next-col next-col-3 biz-supplierLite-label"><span>Company Name</span></div>
                                            <div class="next-col biz-supplierLite-value"><?php echo $seller_info['company_name']; ?></div>
                                        </div>
                                        <div class="next-row">
                                            <div class="next-col next-col-3 biz-supplierLite-label"><span>Address</span></div>
                                            <div class="next-col biz-supplierLite-value"><?php echo $seller_info['address1']; ?></div>
                                        </div>
                                        <div class="next-row">
                                            <div class="next-col next-col-3 biz-supplierLite-label"><span>Business Type</span></div>
                                            <div class="next-col biz-supplierLite-value"><?php echo $seller_info['name']; ?></div>
                                        </div>

                                        <div class="next-row">
                                            <div class="next-col next-col-3 biz-supplierLite-label"><span>Country/Region</span></div>
                                            <div class="next-col biz-supplierLite-value"><?php echo ucfirst(strtolower($seller_info['country_name'])); ?></div>
                                        </div>
                                        <div class="next-row">
                                            <div class="next-col biz-supplierLite-showaction"><span onclick = "hide_details()">Hide supplier's details</span></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="biz-products">
                                <div class="next-table only-bottom-border component-product-list">
                                    <div class="next-table-inner">
                                        <div class="next-table-header">
                                            <div class="next-table-header-inner">
                                                <table>
                                                    <thead>
                                                        <tr>
                                                            <th > <div class="next-table-cell-wrapper"><strong>Product Image </strong></div></th>
                                                    <th rowspan="1" class="next-table-header-node first">
                                                    <div class="next-table-cell-wrapper"><strong>Product Name </strong></div>
                                                    </th>
                                                    <th rowspan="1" class="next-table-header-node">
                                                    <div class="next-table-cell-wrapper"><strong>Quantity</strong></div>
                                                    </th>
                                                    <th rowspan="1" class="next-table-header-node">
                                                    <div class="next-table-cell-wrapper"><strong>Unit</strong></div>
                                                    </th>
                                                    <th rowspan="1" class="next-table-header-node">
                                                    <div class="next-table-cell-wrapper"><strong>Unit Price</strong></div>
                                                    </th>
                                                    <th rowspan="1" class="next-table-header-node last">
                                                    <div class="next-table-cell-wrapper"><strong>Total Product Amount</strong></div>
                                                    </th>
                                                    </tr>
                                                    </thead>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="next-table-body">
                                            <table>
                                                <tbody>

    <?php
    $tot_price = 0;
    $qnty = 0;
    $count_item = 0;
    $totalAmount = 0;
    foreach ($product_details as $details) {
        $specifications = json_decode($details->product_specifications);
        $totalAmount+= $specifications->final_price;
        $count_item += count($specifications->specifications);

        for ($i = 0; $i < count($specifications->specifications); $i++) {
            ?>
                                                            <tr>
                                                                <td class="next-table-cell first">
                                                                    <div class="next-table-cell-wrapper">
                                                                        <div class="biz-sku-infos">
                                                                            <div class="pic"><img src="<?php echo $specifications->product_image; ?>"
                                                                                                  class="media-side"></div>
                                                                            <div class="detail">

                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td class="next-table-cell">
                                                                    <div class="next-table-cell-wrapper">
            <?php ?><br>
            <?php if ($specifications->specifications[$i]->specifications->case_type > 2 || $specifications->specifications[$i]->specifications->case_type == 2) {
                echo '<strong>' . $specifications->product_name . '</strong><br><br>';
                ?>
                                                                            <?php
                                                                            for ($j = 0; $j < count($specifications->specifications[$i]->specifications->secondary); $j++) {
                                                                                if ($j == 0) {

                                                                                    if ($specifications->specifications[$i]->specifications->other[$j]->spec_value) {
                                                                                        $other = " ( " . $specifications->specifications[$i]->specifications->other[$j]->spec_value . " )";
                                                                                    }

                                                                                    echo $specifications->specifications[$i]->specifications->primary->specification_name;
                                                                                    ?> : <?php echo $specifications->specifications[$i]->specifications->primary->spec_value . "<br>";

                                                            echo $specifications->specifications[$i]->specifications->secondary[$j]->specification_name;
                                                                                    ?> : <?php
                                                                                    echo $specifications->specifications[$i]->specifications->secondary[$j]->spec_value . $other . "<br>";
                                                                                    $qnty += $specifications->specifications[$i]->specifications->secondary[$j]->quantity;
                                                                                } else {
                                                                                    if ($specifications->specifications[$i]->specifications->other[$j]->spec_value) {
                                                                                        $other = " ( " . $specifications->specifications[$i]->specifications->other[$j]->spec_value . " )";
                                                                                    }

                                                                                    echo $specifications->specifications[$i]->specifications->secondary[$j]->specification_name;
                                                                                    ?> : <?php
                                                                                    echo $specifications->specifications[$i]->specifications->secondary[$j]->spec_value . $other . "<br>";
                                                                                    $qnty += $specifications->specifications[$i]->specifications->secondary[$j]->quantity;
                                                                                }
                                                                            }
                                                                        } else if ($specifications->specifications[$i]->specifications->case_type == 1) {
                                                                            echo '<strong>' . $specifications->product_name . '</strong><br><br>';
                                                                            for ($j = 0; $j < count($specifications->specifications[$i]->specifications->secondary); $j++) {
                                                                                echo $specifications->specifications[$i]->specifications->secondary[$j]->specification_name;
                                                                                ?> : <?php
                                                                                echo $specifications->specifications[$i]->specifications->secondary[$j]->spec_value . "<br>";
                                                                                $qnty += $specifications->specifications[$i]->specifications->secondary[$j]->quantity;
                                                                            }
                                                                        } else {
                                                                            ?>
                <?php echo '<strong>' . $specifications->product_name . '</strong>'; ?>
            <?php } ?>
                                                                    </div>
                                                                </td>
                                                                <td class="next-table-cell">
                                                                    <div class="next-table-cell-wrapper">
            <?php echo ($qnty) ? $qnty : $specifications->specifications[$i]->specifications->total_quantity; ?> (<?php echo $specifications->specifications[$i]->specifications->unit_name; ?>)
                                                                    </div>
                                                                </td>
                                                                <td class="next-table-cell">
                                                                    <div class="next-table-cell-wrapper">
                                                                        <div class="biz-product-unit"><?php echo $specifications->specifications[$i]->specifications->unit_name; ?></div>
                                                                    </div>
                                                                </td>
                                                                <td class="next-table-cell">
                                                                    <div class="next-table-cell-wrapper">
                                                                        <div class="biz-product-price">
                                                                            <div class="ladders">
                                                                                <i class='fa fa-inr'></i><?php echo $specifications->specifications[$i]->specifications->unit_price; ?> / <?php echo $specifications->specifications[$i]->specifications->unit_name; ?>

                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td class="next-table-cell last">
                                                                    <div class="next-table-cell-wrapper">
                                                                        <div class="biz-product-amount">
                                                                            <i class='fa fa-inr'></i> <?php
                                                                            if ($qnty) {
                                                                                $total_price = $qnty * $specifications->specifications[$i]->specifications->unit_price;
                                                                            } else {
                                                                                $total_price = $specifications->specifications[$i]->specifications->total_quantity * $specifications->specifications[$i]->specifications->unit_price;
                                                                            }

                                                                            echo $total_price;
                                                                            $tot_price += $total_price;
                                                                            ?>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                            <?php
                                                            $qnty = 0;
                                                            $discount += $specifications->specifications[$i]->specifications->total_discount;
                                                            $discount_percent += $specifications->specifications[$i]->specifications->discount_percent;
                                                            $total_amount += $specifications->specifications[$i]->specifications->total_price_after_dis;
                                                        }
                                                    }
                                                    ?>

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="next-row next-row-justify-center block-footer" id="productsFooter_1">
                                <div class="next-col block-footer-left">
                                    <div id="productsAmountBlock_1" class="block draft-productsAmountBlock">
                                        <div class="biz-products-amount">
                                            <label><span>Subtotal(<?php echo $count_item; ?> Items) without shipping:</span></label>
                                            <span>
                                                <!-- react-text: 485 --><i class='fa fa-inr'></i>

                                                <!-- /react-text -->
                                                <!-- react-text: 486 --><?php echo number_format($tot_price, 2); ?>
                                                <!-- /react-text -->
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
    <?php if ($discount > 0) { ?>
                                <div class="next-row next-row-justify-center block-footer" id="productsFooter_1">
                                    <div class="next-col block-footer-left">
                                        <div id="productsAmountBlock_1" class="block draft-productsAmountBlock">
                                            <div class="biz-products-amount">
                                                <label><span> Max. Coupon Discount of <?php echo $discount_percent; ?>% </span></label>
                                                <span>
                                                    <!-- react-text: 485 --><i class='fa fa-inr'></i>
                                                    <!-- /react-text -->
                                                    <!-- react-text: 486 --><?php echo number_format($discount, 2); ?>
                                                    <!-- /react-text -->
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="next-row next-row-justify-center block-footer" id="productsFooter_1">
                                    <div class="next-col block-footer-left">
                                        <div id="productsAmountBlock_1" class="block draft-productsAmountBlock">
                                            <div class="biz-products-amount">
                                                <label><span>Total Product Amount </span></label>
                                                <span style="color:red">
                                                    <!-- react-text: 485 --><i class='fa fa-inr'></i>
                                                    <!-- /react-text -->
                                                    <!-- react-text: 486 --><?php echo number_format($total_amount, 2); ?>
                                                    <!-- /react-text -->
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
    <?php } ?>
                        </div>
                    </div>
<?php } ?>
            </div>

            <div class="row">
                <div class="biz-block-card-wrap biz-block-card-wrap-undefined card draft-shippingBlock" style="width: inherit">
                    <div class="biz-block-card-header wd100">
                        <h3 class="biz-block-card-title">
                            Payment Details
                        </h3>
                    </div>
                    <div class="biz-block-card-body">

                        <div class="next-form-item next-row" id="shippingAddress_shippingAddress_1" label="[object Object]" required="">

                            <?php
                            $payment_mode = '';
                            $payment_date = '';
                            $payment_id = '';
                            foreach ($payment_details as $key => $value) {
                                # code...
                                $payment_status = $value->status;
                                $payment_mode = $value->payment_by;
                                $payment_date = $value->created_at;
                                $payment_date1 = $value->cr_date;
                                $payment_id = $value->payment_id;
                            }
                            ?>

                            <div class="next-table-body">
                                <table class="table table-border" style="border: 1px solid #EEE">

                                    <thead>
                                    <th style="width: 220px; padding: 9px;"><strong>Order ID</strong></th>
                                    <th style="width: 220px; padding: 9px;"><strong>Payment Mode</strong></th>
                                    <th style="width: 220px; padding: 9px;"><strong>Transaction ID</strong></th>
                                    <th style="width: 220px; padding: 9px;"><strong>Transaction Date</strong></th>
                                    <th style="width: 220px; padding: 9px;"><strong>Transaction Amount</strong></th>
                                    </thead>

                                    <tbody>
                                        <tr>
                                            <td style="width: 220px; padding: 9px;">
                                                <?php echo '#ORD' . $order_dtail['orders_id']; ?>
                                            </td>
                                            <td style="width: 220px; padding: 9px;">
                                                <?php echo $payment_mode; ?>
                                            </td>
                                            <td style="width: 220px; padding: 9px;">
                                                <?php echo $payment_id; ?>
                                            </td>
                                            <?php  if($payment_mode==='razorpay' && $payment_status=='authorized') {?>
                                            <td style="width: 220px; padding: 9px;">
                                                <?php echo $payment_date1; ?>
                                            </td>
                                            <?php }else{ ?>
                                             <td style="width: 220px; padding: 9px;">
                                                <?php echo $payment_date1; ?>
                                            </td>
                                            <?php } ?>
                                            <td style="width: 220px; padding: 9px;">
                                                <i class='fa fa-inr'>&nbsp;</i><?php echo number_format($order_dtail['order_price'], 2); ?>
                                            </td>
                                        </tr>
                                    </tbody>

                                </table>
                            </div>

                            <!--  <div class="input-group" style="width: 200px; padding: 9px;">
                             Order ID:<br> 
                            <?php echo $order_dtail['orders_id']; ?>
                             </div>
                              <div class="input-group" style="width: 200px; padding: 9px;">
                              Payment Mode: <br>
                            <?php echo $payment_mode; ?> 
                             </div>
                                <div class="input-group" style="width: 200px; padding: 9px;">
                              Transaction ID:<br>
                            <?php echo $payment_id; ?> 
                             </div>
                              <div class="input-group" style="width: 200px; padding: 9px;">
                               Transaction Date:<br> 
                            <?php echo $payment_date; ?> 
                             </div>
                             <div class="input-group" style="width: 293px; padding: 9px;">
                             Transaction Amount: <br>
                              <i class='fa fa-inr'></i><?php echo number_format($order_dtail['order_price'], 2); ?>
                               
                             </div> -->

                        </div>


                    </div>
                </div>
            </div>


            <div>
                <div id="shippingBlock_1" class="biz-block-card-wrap biz-block-card-wrap-undefined card draft-shippingBlock">
                    <div class="biz-block-card-header wd100">
                        <h3 class="biz-block-card-title">
                            Shipping Details
                        </h3>
                    </div>
                    <div class="biz-block-card-body">

                        <div class="next-form-item next-row" id="shippingAddress_shippingAddress_1" label="[object Object]" required=""><label
                                for="shippingAddress_shippingAddress_1" required="" class="next-col-4 next-form-item-label"><span
                                    data-i18n-ns="ta.order.com.shippingaddress.form-item" data-i18n-key="label">Shipping
                                    Address:</span></label>
                            <div class="next-col-20 next-form-item-control">
                                <div class="bc-icbu-shipping-address-container">
                                    <?php
                                    if (!empty($order_dtail)) {
                                        ?>
                                        <div class="input-group" style="width: 265px; padding: 9px;">

                                            <span style="margin-top:-5px; margin-left:10px;"><?php echo $order_dtail['delivery_name']; ?>, 
    <?php echo $order_dtail['delivery_street_address']; ?> , 
                                                <?php echo $order_dtail['delivery_city'] . ',' . $order_dtail['delivery_state']; ?><br>
                                                <?php echo $order_dtail['country_name'] . ',' . $order_dtail['delivery_postcode']; ?></span>
                                        </div>
                                                <?php
                                            }
                                            ?>
                                </div><!-- react-text: 517 -->
                                <!-- /react-text -->
                                <div class=""></div><!-- react-text: 519 -->
                                <!-- /react-text -->
                            </div>
                        </div>

                        <div class="next-form-item next-row" id="shippingTime_1" label="[object Object]"><label for="shippingTime_1"
                                                                                                                class="next-col-4 next-form-item-label"><span data-i18n-ns="ta.order.com.shipping_time" data-i18n-key="label">Estimated
                                    Shipping Date:<br></span></label>
                            <div class="next-col-20 next-form-item-control">&nbsp;&nbsp;&nbsp;&nbsp;
                                <span><?php echo date('d M Y', strtotime($order_dtail['shipping_expected_date'])); ?></span>
                                <!-- react-text: 533 -->
                                <!-- /react-text -->
                                <div class=""></div><!-- react-text: 535 -->
                                <!-- /react-text -->
                            </div>
                        </div>

                        <div class="next-row next-row-justify-center block-footer" id="shippingFooter_1">
                            <div class="next-col block-footer-left">
                                <div class="biz-shipping-fee"><label><span data-i18n-ns="ta.order.buynow.shipping_fee" data-i18n-key="label">Shipping
                                            Fee:</span></label><span class="biz-shipping-fee-value"><span data-i18n-ns="ta.order.buynow.shipping_fee"
                                                                                                  data-i18n-key="no_fee"><?php
                                    if ($order_dtail['shippment_type'] == 'Free'){
                                        echo '0.00';
                                    } else {
                                        echo $order_dtail['shipping_cost'];
                                    }
                                                ?></span></span></div>
                                    <div class="biz-shipping-fee"><label><span data-i18n-ns="ta.order.buynow.shipping_fee" data-i18n-key="label">Total Amount:</span></label><span class="biz-shipping-fee-value"><span data-i18n-ns="ta.order.buynow.shipping_fee"
                                                                                                                                                                                                            data-i18n-key="no_fee"><?php echo number_format($order_dtail['order_price'], 2); ?></span></span></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div>


            </div>
        </div>
    </div>
    <script src="http://code.jquery.com/jquery-1.11.3.min.js"></script>
    <script>
                                                                        $(document).ready(function () {
                                                                            $("#seller_details").hide();
                                                                        });
                                                                        function show_details()
                                                                        {
                                                                            $("#seller_details").show();
                                                                        }

                                                                        function hide_details()
                                                                        {
                                                                            $("#seller_details").hide();
                                                                        }
    </script>
