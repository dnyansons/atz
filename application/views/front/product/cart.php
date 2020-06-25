<?php $this->load->view("front/common/header"); ?>
<style>
    @import url(/@sc/trade-contract/entries/ta-buynow/index-part1.51fb78e7.css?_v=51fb78e7a3ee8e51.css);
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
<div class="main" style="background-color: #f7f8fa;">
    <div id="draft" class="draft">
        <div>
            <div id="brandIntro_1" class="brand-intro" style="height: 32px;">
                <ul class="intro-simple">
                    <li class="intro-simple-item ta-brand"><span class="ta-icon"><span>Trade Assurance Order</span></span></li>
                    <li class="intro-simple-item"><span class="approve-icon"><span>Payment Protection</span></span></li>
                    <li class="intro-simple-item"><span class="approve-icon"><span>Product Quality Protection </span></span></li>
                    <li class="intro-simple-item"><span class="approve-icon"><span>Shipping Protection</span></span></li>

                    <div class="intro-multi">
                        <div class="intro-multi-item intro-multi-item-enable">
                            <span class="approve-icon item-label">
                                <span>Payment
                                    Protection</span><!-- react-text: 336 -->：
                                <!-- /react-text -->
                            </span>
                            <span data-i18n-key="fund_security_desc">Trade Assurance will cover all
                                payments made during the ordering
                                process up to 30 days after the buyer receives the goods.</span>
                        </div>
                        <div class="intro-multi-item intro-multi-item-enable">
                            <span class="approve-icon item-label">
                                <span>Product
                                    Quality Protection </span><!-- react-text: 341 -->：
                                <!-- /react-text -->
                            </span>
                            <span>The order will be covered in the event that the
                                product(s) do not match the details outlined in your contract.</span>
                        </div>
                        <div class="intro-multi-item intro-multi-item-enable">
                            <span class="approve-icon item-label">
                                <span
                                    data-i18n-key="shipping_protection_title">Shipping
                                    Protection</span><!-- react-text: 346 -->：
                                <!-- /react-text -->
                            </span>
                            <span data-i18n-key="shipping_protection_desc">The order will be shipped on
                                time according to the details set
                                in the contract. In the event of a delay, the buyer is eligible for a refund.</span>

                            <div class="tip"><span>Note:
                                    Your order will be protected for up to 30 days after the buyer receives the goods.</span>
                            </div>

                        </div>
                    </div>
                </ul>
            </div>
        </div>
        <br>
        <br>
        <div class="container">
            <div> <?php echo $this->session->flashdata("success_msg"); ?> </div>
            <?php
            //if any one of product from supplier goes out of stock then stop payments
            $low_stock_one = array();
            if ($cart_product) {
                $discount = 0;
                $total_amount = 0;
                $total_quantity = 0;
                $index = 0;
                foreach ($cart_product as $key => $sellerwise) {
                    $countProductSellerWise = count($sellerwise);
//                echo "<pre>";
//                print_r($sellerwise);
//                echo "</pre>";
                    if ($countProductSellerWise > 1) {
                        ?>
                        <div id="productsBlock_1" class="biz-block-card-wrap biz-block-card-wrap-undefined card draft-productsBlock">
                            <div class="biz-block-card-header pull-left">
                                <h3 class="biz-block-card-title">
                                    <span>Product Details</span>
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
                                                        <?php echo $cart_product[$key][0]['supplierDetails']; ?>
                                                    </span>
                                                    <!-- <img alt="" class="biz-supplierLite-icon" src="assets/images/product/1.jpg"> -->
                                                </span>
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
                                                                <th >
                                                                    <div class="next-table-cell-wrapper"><strong>Product Image </strong></div>
                                                                </th>
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
                                                                    <div class="next-table-cell-wrapper"><strong>Mrp</strong></div>
                                                                </th>
                                                                <th rowspan="1" class="next-table-header-node last">
                                                                    <div class="next-table-cell-wrapper"><strong>Discount</strong></div>
                                                                </th>
                                                                <th rowspan="1" class="next-table-header-node">
                                                                    <div class="next-table-cell-wrapper"><strong>Unit Price</strong></div>
                                                                </th>
                                                                <th rowspan="1" class="next-table-header-node last">
                                                                    <div class="next-table-cell-wrapper"><strong>Net Amount</strong></div>
                                                                </th>
                                                            </tr>
                                                        </thead>
                                                    </table>
                                                </div>
                                            </div>
                                            <?php
                                            $tot_price = 0;
                                            $qnty = 0;
                                            $count_item = 0;
                                            foreach ($sellerwise as $details) {
                                                ?>
                                                <div class="next-table-body">
                                                    <table>
                                                        <tbody>
                                                            <?php
                                                            $specifications = json_decode($details['specifications']);
                                                            $count_item += count($specifications);
                                                            for ($i = 0; $i < count($specifications); $i++) {
                                                                ?>
                                                                <tr>
                                                                    <td class="next-table-cell first">
                                                                        <div class="next-table-cell-wrapper">
                                                                            <div class="biz-sku-infos">
                                                                                <div class="pic"><img src="<?php echo $details['product_image']; ?>"
                                                                                                      class="media-side"></div>
                                                                            </div>
                                                                        </div>
                                                                    </td>
                                                                    <td class="next-table-cell">
                                                                        <div class="next-table-cell-wrapper pb-5">
                                                                            <strong>
                                                                                <?php
                                                                                if ($specifications[$i]->specifications->case_type > 2 || $specifications[$i]->specifications->case_type == 2) {
                                                                                    echo $details['product_name'] . '<br>';
                                                                                    ?>
                                                                                </strong>
                                                                                <?php
                                                                                for ($j = 0; $j < count($specifications[$i]->specifications->secondary); $j++) {

                                                                                    if ($j == 0) {
                                                                                        if ($specifications[$i]->specifications->other[$j]->spec_value) {
                                                                                            $other = " ( " . $specifications[$i]->specifications->other[$j]->spec_value . " )";
                                                                                        }

                                                                                        echo $specifications[$i]->specifications->primary->specification_name;
                                                                                        ?> : <?php echo $specifications[$i]->specifications->primary->spec_value . "<br>"; ?>
                                                                                        <?php echo $specifications[$i]->specifications->secondary[$j]->specification_name; ?> : <?php
                                                                                        echo $specifications[$i]->specifications->secondary[$j]->spec_value . $other . "<br>";
                                                                                        $qnty += $specifications[$i]->specifications->secondary[$j]->quantity;
                                                                                    } else {

                                                                                        if ($specifications[$i]->specifications->other[$j]->spec_value) {
                                                                                            $other = " ( " . $specifications[$i]->specifications->other[$j]->spec_value . " )";
                                                                                        }
                                                                                        ?>
                                                                                        <?php echo $specifications[$i]->specifications->secondary[$j]->specification_name; ?> : <?php
                                                                                        echo $specifications[$i]->specifications->secondary[$j]->spec_value . $other . "<br>";
                                                                                        $qnty += $specifications[$i]->specifications->secondary[$j]->quantity;
                                                                                    }
                                                                                }
                                                                                ?>
                                                                            </div>
                                                                        <?php } else if ($specifications[$i]->specifications->case_type == 1) { ?>
                                                                            <div class="next-table-cell-wrapper">
                                                                                <strong><?php echo $details['product_name']; ?><br></strong>
                                                                                <?php
                                                                                for ($j = 0; $j < count($specifications[$i]->specifications->secondary); $j++) {

                                                                                    echo $specifications[$i]->specifications->secondary[$j]->specification_name;
                                                                                    ?> : <?php
                                                                                        echo $specifications[$i]->specifications->secondary[$j]->spec_value . "<br>";
                                                                                        $qnty += $specifications[$i]->specifications->secondary[$j]->quantity;
                                                                                    }
                                                                                    ?>
                                                                            </div>
                                                                        <?php } else { ?>
                                                                            <div class="next-table-cell-wrapper">
                                                                                <strong>  <?php echo $details['product_name']; ?> </strong>
                                                                            </div>
                                                                        <?php } ?>
                                                                    </td>
                                                                    <td class="next-table-cell">
                                                                        <div class="next-table-cell-wrapper">
                                                                            <?php echo ($qnty) ? $qnty : $specifications[$i]->specifications->total_quantity; ?> 
                                                                            <?php
                                                                            //Check if product quantity is still available for pending orders
                                                                            //so not to change the available quantity to negative stock
                                                                            //if product is out of stock then do not process pending orders
                                                                            $low_stock = $this->Order_model->checkProductAvailQty($details['product_id'], $specifications[$i]->specifications->total_quantity);
                                                                            if ($low_stock == 0) {
                                                                                echo "<label style='font-weight:bold;font-size:1em;' class='text-danger text-center'>Out Of Stock</label>";
                                                                                $low_stock_one[] = $details['seller_id'];
                                                                            }
                                                                            $result = $this->Offer_model->checkOfferExpiryForCartProducts($details['offer_id']);

                                                                            if ($result['offer_id'] != NULL || $result['offer_id'] != 0) {
                                                                                if ($details['offer_id'] == $result['offer_id']) {
                                                                                    //first match offer_id with current products offer_id if both are same then
                                                                                    //delete record from cart whose offer is applied but expired
                                                                                    $deleted_count = $this->Offer_model->deleteExpiredOfferFromCart($details['id']);
                                                                                    if ($deleted_count > 0) {
                                                                                        $msg = '<div class="alert alert-danger alert-dismissible col-md-6 offset-3">
                                                                  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                                                  <strong>Info:</strong>' . "Offer expired for product " . $details['product_name'] . '</div>';

                                                                                        $this->session->set_flashdata('success_msg', $msg);
                                                                                        redirect(base_url('home_product/getCartProducts'));
                                                                                    }
                                                                                }
                                                                            }
                                                                            ?>
                                                                        </div>
                                                                    </td>
                                                                    <td class="next-table-cell">
                                                                        <div class="next-table-cell-wrapper">
                                                                            <div class="biz-product-unit">
                                                                                <?php echo $specifications[$i]->specifications->unit_name; ?>
                                                                            </div>
                                                                        </div>
                                                                    </td>
                                                                    <td class="next-table-cell">
                                                                        <div class="next-table-cell-wrapper">
                                                                            <div class="biz-product-price">
                                                                                <div class="ladders">
                                                                                    <i class="fa fa-inr"></i> <?php echo sprintf("%1.2f", $product_data[$index]['mrp']); ?>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </td>
                                                                    <td class="next-table-cell">
                                                                        <div class="next-table-cell-wrapper">
                                                                            <div class="biz-product-price">
                                                                                <div class="ladders">
                                                                                    <?php echo $product_data[$index]['discount']; ?>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </td>
                                                                    <td class="next-table-cell">
                                                                        <div class="next-table-cell-wrapper">
                                                                            <div class="biz-product-price">
                                                                                <div class="ladders">
                                                                                    <i class="fa fa-inr"></i> <?php echo $specifications[$i]->specifications->unit_price; ?> 
                                                                                    <?php
                                                                                    if ($details['offer_id'] != 0) {
                                                                                        $offer_title = $this->Offer_model->getOfferTitle($details['offer_id']);
                                                                                        echo "<br><p class='text-success font-weight-bold text-uppercase'>$offer_title</p>";
                                                                                    }
                                                                                    ?>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </td>
                                                                    <td class="next-table-cell last">
                                                                        <div class="next-table-cell-wrapper">
                                                                            <div class="biz-product-amount">
                                                                                <i class="fa fa-inr"></i> <?php
                                                                                if ($qnty) {
                                                                                    $total_price = $qnty * $specifications[$i]->specifications->unit_price;
                                                                                } else {
                                                                                    $total_price = $specifications[$i]->specifications->total_quantity * $specifications[$i]->specifications->unit_price;
                                                                                }

                                                                                echo sprintf("%1.2f", $total_price);
                                                                                $tot_price += $total_price;
                                                                                ?>
                                                                            </div>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                                <?php
                                                                $qnty = 0;
                                                                $discount += $specifications[$i]->specifications->total_discount;
                                                                $discount_percent += $specifications[$i]->specifications->discount_percent;
                                                                $total_amount += $specifications[$i]->specifications->total_price_after_dis;
                                                            }
                                                            ?>
                                                        </tbody>
                                                    </table>
                                                    <a onclick="return confirm('Are You Sure ?')" href= "<?php echo base_url(); ?>removeCartProduct/<?php echo $details['id']; ?>" class="btn btn-danger btn-sm" style="color:#fff !important;">Remove</a></br></br>
                                                </div>
            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="next-row next-row-justify-center block-footer" id="productsFooter_1">
                                    <div class="next-col block-footer-left">
                                        <div id="productsAmountBlock_1" class="block draft-productsAmountBlock">
                                            <div class="biz-products-amount">
                                                <label><span>Subtotal(<?php echo $count_item; ?> Items) without shipping:</span></label>
                                                <span>
                                                    <!-- react-text: 485 --><i class="fa fa-inr"></i>
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
                                                        <!-- react-text: 485 --><i class="fa fa-inr"></i>
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
                                                    <label><span>Net Amount</span></label>
                                                    <span style="color:red">
                                                        <!-- react-text: 485 --><i class="fa fa-inr"></i>
                                                        <!-- /react-text -->
                                                        <!-- react-text: 486 --><?php echo number_format($total_amount, 2); ?>
                                                        <!-- /react-text -->
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php } ?>
                                <div class="text-right">
                                    </br>
                                    <?php if (!in_array($details['seller_id'], $low_stock_one)) { ?>
                                        <a href="<?php echo base_url(); ?>startOrderForCartProduct/<?php echo $details['seller_id']; ?>" ><button  type="submit" class="next-btn next-large next-btn-primary" role="button" ><span>Continue Process</span></button></a>
                                    <?php
                                    } else {
                                        $this->session->set_flashdata('message', $details['product_name'] . " product is out of stock!");
                                        ?>
                                        <a href="<?php echo base_url('buyer-orders'); ?>" ><button  type="submit" class="next-btn next-large next-btn-primary" role="button" ><span>All Orders</span></button></a>
            <?php } ?>
                                </div>
                                </br>
                            </div>
                        </div>
                        <?php
                    } else {
                        foreach ($sellerwise as $details) {
                            ?>
                            <div id="productsBlock_1" class="biz-block-card-wrap biz-block-card-wrap-undefined card draft-productsBlock">
                                <div class="biz-block-card-header pull-left">
                                    <h3 class="biz-block-card-title">
                                        <span>Product Details</span>
                                    </h3>
                                </div>
                                <div class="biz-block-card-body">
                                    <div id="productsHeader_1" class="block draft-productsHeader">
                                        <div class="biz-supplierLite">
                                            <div class="next-row biz-supplierLite-header">
                                                <div class="next-col next-col-16">
                                                    <span class="biz-supplierLite-label"><span>Supplier</span></span>
                                                        <?php
                                                        $supplierData = $this->Product_model->getSupplierInfo($details['seller_id']);
                                                        ?>
                                                    <span class="biz-supplierLite-value">
                                                        <?php echo $details['supplierDetails']; ?>
                                                    </span>
                                                </div>

                                                <div class="next-col biz-supplierLite-showaction"><span
                                                        onclick="show_details()">Show supplier's details</span></div>
                                            </div>
                                            <div class="biz-supplierLite-body" id="seller_details">
                                                <div class="next-row">
                                                    <div class="next-col next-col-3 biz-supplierLite-label"><span>Supplier Name</span>
                                                    </div>
                                                    <div class="next-col biz-supplierLite-value"><?php echo $supplierData['first_name'].' '.$supplierData['last_name']; ?></div>

                                                </div>
                                                <div class="next-row">
                                                    <div class="next-col next-col-3 biz-supplierLite-label"><span>Company Name</span>
                                                    </div>
                                                    <div class="next-col biz-supplierLite-value"><?php echo $supplierData['company_name']; ?></div>
                                                </div>
                                                <div class="next-row">
                                                    <div class="next-col next-col-3 biz-supplierLite-label">
                                                        <span>Address</span></div>
                                                    <div class="next-col biz-supplierLite-value"><?php echo $supplierData['address1']. ' '. $supplierData['comp_operational_city'].
                                                            ' '.$supplierData['comp_operational_state']; ?></div>
                                                </div>
                                                <div class="next-row">
                                                    <div class="next-col next-col-3 biz-supplierLite-label"><span>Business Type</span>
                                                    </div>
                                                    <div class="next-col biz-supplierLite-value"><?php echo $supplierData['business_type']; ?></div>
                                                </div>

                                                <div class="next-row">
                                                    <div class="next-col next-col-3 biz-supplierLite-label"><span>Country/Region</span>
                                                    </div>
                                                    <div class="next-col biz-supplierLite-value"><?php echo ucfirst(strtolower($supplierData['country_name'])); ?></div>
                                                </div>
                                                <div class="next-row">
                                                    <div class="next-col biz-supplierLite-showaction"><span
                                                            onclick="hide_details()">Hide supplier's details</span>
                                                    </div>
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
                                                                    <th >
                                                                        <div class="next-table-cell-wrapper"><strong>Product Image </strong></div>
                                                                    </th>
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
                                                                        <div class="next-table-cell-wrapper"><strong>Mrp</strong></div>
                                                                    </th>
                                                                    <th rowspan="1" class="next-table-header-node last">
                                                                        <div class="next-table-cell-wrapper"><strong>Discount</strong></div>
                                                                    </th>
                                                                    <th rowspan="1" class="next-table-header-node">
                                                                        <div class="next-table-cell-wrapper"><strong>Unit Price</strong></div>
                                                                    </th>
                                                                    <th rowspan="1" class="next-table-header-node last">
                                                                        <div class="next-table-cell-wrapper"><strong>Net Amount</strong></div>
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
                                                            $specifications = json_decode($details['specifications']);
                                                            // echo "<pre>";
                                                            // print_r($specifications);
                                                            // exit;
                                                            $tot_price = 0;
                                                            $count_item = count($specifications);
                                                            $qnty = 0;
                                                            for ($i = 0; $i < count($specifications); $i++) {
                                                                ?>
                                                                <tr>
                                                                    <td class="next-table-cell first">
                                                                        <div class="next-table-cell-wrapper">
                                                                            <div class="biz-sku-infos">
                                                                                <div class="pic"><img src="<?php echo $details['product_image']; ?>"
                                                                                                      class="media-side"></div>
                                                                            </div>
                                                                        </div>
                                                                    </td>
                                                                    <td class="next-table-cell">
                                                                        <strong>
                                                                            <?php
                                                                            if ($specifications[$i]->specifications->case_type > 2 || $specifications[$i]->specifications->case_type == 2) {
                                                                                echo $details['product_name'] . '<br>';
                                                                                ?>
                                                                            </strong>
                                                                            <div class="next-table-cell-wrapper">
                                                                                <?php
                                                                                for ($j = 0; $j < count($specifications[$i]->specifications->secondary); $j++) {

                                                                                    if ($j == 0) {
                                                                                        if ($specifications[$i]->specifications->other[$j]->spec_value) {
                                                                                            $other = " ( " . $specifications[$i]->specifications->other[$j]->spec_value . " )";
                                                                                        }

                                                                                        echo $specifications[$i]->specifications->primary->specification_name;
                                                                                        ?> : <?php echo $specifications[$i]->specifications->primary->spec_value . "<br>"; ?>
                                                                                        <?php echo $specifications[$i]->specifications->secondary[$j]->specification_name; ?> : <?php
                                                                                        echo $specifications[$i]->specifications->secondary[$j]->spec_value . $other . "<br>";
                                                                                        $qnty += $specifications[$i]->specifications->secondary[$j]->quantity;
                                                                                    } else {

                                                                                        if ($specifications[$i]->specifications->other[$j]->spec_value) {
                                                                                            $other = " ( " . $specifications[$i]->specifications->other[$j]->spec_value . " )";
                                                                                        }
                                                                                        ?>
                                                                                        <?php echo $specifications[$i]->specifications->secondary[$j]->specification_name; ?> : <?php
                                                                                        echo $specifications[$i]->specifications->secondary[$j]->spec_value . $other . "<br>";
                                                                                        $qnty += $specifications[$i]->specifications->secondary[$j]->quantity;
                                                                                    }
                                                                                }
                                                                                ?>
                                                                            </div>
                                                                            <strong>
                                                                                <?php
                                                                            } else if ($specifications[$i]->specifications->case_type == 1) {
                                                                                echo $details['product_name'] . '<br>';
                                                                                ?>
                                                                            </strong>
                                                                            <div class="next-table-cell-wrapper">
                                                                                <?php
                                                                                for ($j = 0; $j < count($specifications[$i]->specifications->secondary); $j++) {

                                                                                    echo $specifications[$i]->specifications->secondary[$j]->specification_name;
                                                                                    ?> : <?php
                                                                                    echo $specifications[$i]->specifications->secondary[$j]->spec_value . "<br>";
                                                                                    $qnty += $specifications[$i]->specifications->secondary[$j]->quantity;
                                                                                }
                                                                                ?>
                                                                            </div>
                                                                        <?php } else { ?>
                                                                            <div class="next-table-cell-wrapper">
                                                                                <strong> <?php echo $details['product_name']; ?> </strong>
                                                                            </div>
                                                                            <?php } ?>
                                                                    </td>
                                                                    <td class="next-table-cell">
                                                                        <div class="next-table-cell-wrapper">
                                                                            <?php echo ($qnty) ? $qnty : $specifications[$i]->specifications->total_quantity; ?> 
                                                                            <?php
                                                                            //Check if product quantity is still available for pending orders
                                                                            //so not to change the available quantity to negative stock
                                                                            //if product is out of stock then do not process pending orders
                                                                            $low_stock = $this->Order_model->checkProductAvailQty($details['product_id'], $specifications[$i]->specifications->total_quantity);
                                                                            if ($low_stock == 0) {
                                                                                echo "<label style='font-weight:bold;font-size:1em;' class='text-danger text-center'>Out Of Stock</label>";
                                                                                $low_stock_two[] = $details['seller_id'];
                                                                            }

                                                                            $result = $this->Offer_model->checkOfferExpiryForCartProducts($details['offer_id']);

                                                                            if ($result['offer_id'] != NULL || $result['offer_id'] != 0) {
                                                                                if ($details['offer_id'] == $result['offer_id']) {
                                                                                    //first match offer_id with current products offer_id if both are same then
                                                                                    //delete record from cart whose offer is applied but expired
                                                                                    $deleted_count = $this->Offer_model->deleteExpiredOfferFromCart($details['id']);
                                                                                    if ($deleted_count > 0) {
                                                                                        $msg = '<div class="alert alert-danger alert-dismissible col-md-6 offset-3">
                                                                  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                                                  <strong>Info:</strong>' . "Offer expired for product " . $details['product_name'] . '</div>';

                                                                                        $this->session->set_flashdata('success_msg', $msg);
                                                                                        redirect(base_url('home_product/getCartProducts'));
                                                                                    }
                                                                                }
                                                                            }
                                                                            ?>
                                                                        </div>
                                                                    </td>
                                                                    <td class="next-table-cell">
                                                                        <div class="next-table-cell-wrapper">
                                                                            <div class="biz-product-unit"><?php echo $specifications[$i]->specifications->unit_name; ?></div>
                                                                        </div>
                                                                    </td>
                                                                    <td class="next-table-cell">
                                                                        <div class="next-table-cell-wrapper">
                                                                            <div class="biz-product-price"> 
                                                                                <div class="ladders">
                                                                                    <i class="fa fa-inr"></i> <?php echo sprintf("%01.2f", $product_data[$index]['mrp']); ?> 
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </td>
                                                                    <td class="next-table-cell">
                                                                        <div class="next-table-cell-wrapper">
                                                                            <div class="biz-product-price">
                                                                                <div class="ladders">
                    <?php echo $product_data[$index]['discount']; ?>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </td>
                                                                    <td class="next-table-cell">
                                                                        <div class="next-table-cell-wrapper">
                                                                            <div class="biz-product-price">
                                                                                <div class="ladders">
                                                                                    <i class="fa fa-inr"></i> <?php echo $specifications[$i]->specifications->unit_price; ?> 
                                                                                    <?php
                                                                                    if ($details['offer_id'] != 0) {
                                                                                        $offer_title = $this->Offer_model->getOfferTitle($details['offer_id']);
                                                                                        echo "<br><p class='text-success font-weight-bold text-uppercase'>$offer_title</p>";
                                                                                    }
                                                                                    ?>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </td>
                                                                    <td class="next-table-cell last">
                                                                        <div class="next-table-cell-wrapper">
                                                                            <div class="biz-product-amount">
                                                                                <i class="fa fa-inr"></i>  <?php
                                                                                if ($qnty) {
                                                                                    $total_price = $qnty * $specifications[$i]->specifications->unit_price;
                                                                                } else {
                                                                                    $total_price = $specifications[$i]->specifications->total_quantity * $specifications[$i]->specifications->unit_price;
                                                                                }

                                                                                echo sprintf("%1.2f", $total_price);
                                                                                $tot_price += $total_price;
                                                                                ?>
                                                                            </div>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                                <?php
                                                                $qnty = 0;
                                                                $discount = $specifications[$i]->specifications->total_discount;
                                                                $discount_percent = $specifications[$i]->specifications->discount_percent;
                                                                $total_amount = $specifications[$i]->specifications->total_price_after_dis;
                                                            }
                                                            ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="next-row next-row-justify-center block-footer" id="productsFooter_1">
                                        <a onclick="return confirm('Are You Sure ?')" href= "<?php echo base_url(); ?>removeCartProduct/<?php echo $details['id']; ?>" class="btn btn-danger btn-sm" style="color:#fff !important;">Remove</a></br>
                                        <div class="next-col block-footer-left">
                                            <div id="productsAmountBlock_1" class="block draft-productsAmountBlock">
                                                <div class="biz-products-amount">
                                                    <label><span>Subtotal(<?php echo $count_item; ?> Items) without shipping:</span></label>
                                                    <span>
                                                        <!-- react-text: 485 --><i class="fa fa-inr"></i>
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
                                                            <!-- react-text: 485 --><i class="fa fa-inr"></i>
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
                                                        <label><span>Net Amount</span></label>
                                                        <span style="color:red">
                                                            <!-- react-text: 485 --><i class="fa fa-inr"></i>
                                                            <!-- /react-text -->
                                                            <!-- react-text: 486 --><?php echo number_format($total_amount, 2); ?>
                                                            <!-- /react-text -->
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <?php } ?>
                                    <div class="text-right">
                                        </br>
                                        <?php if (!in_array($details['seller_id'], $low_stock_one)) { ?>
                                            <a href="<?php echo base_url(); ?>startOrderForCartProduct/<?php echo $details['seller_id']; ?>" ><button  type="submit" class="next-btn next-large next-btn-primary" role="button" ><span>Continue Process</span></button></a>
                <?php
                } else {
                    $this->session->set_flashdata('message', $details['product_name'] . " product is out of stock!");
                    ?>
                                            <a href="<?php echo base_url('buyer-orders'); ?>" ><button  type="submit" class="next-btn next-large next-btn-primary" role="button" ><span>All Orders</span></button></a>
                            <?php } ?>
                                    </div>
                                    </br>
                                </div>
                            </div>
            <?php
            }
        }
        $index++;
    }
} else {
    ?>
                <div class=" clearfix">
                    <div id="notfound">
                        <div class="notfound">
                            <div class="notfound-404">
                                <h1>Oops!</h1>
                                <h2>There Are No Products In Cart !!</h2>
                            </div>
                            <a href="<?php echo base_url(); ?>">Go TO Homepage</a>
                        </div>
                    </div>
                </div>
<?php } ?>
        </div>
    </div>
</div>
<?php $this->load->view("front/common/footer"); ?>
<script>
    $(document).ready(function () {
                                $("#seller_details").hide();
                            });
function show_details() {
            $("#seller_details").show();
        }

        function hide_details() {
            $("#seller_details").hide();
        }
</script>