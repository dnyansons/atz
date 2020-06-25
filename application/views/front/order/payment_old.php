<!doctype html>
<html class="no-js" lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="x-ua-compatible" content="ie=edge">
	<title>aTz || Largest online B2B marketplace </title>
	<meta name="description" content="">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="icon" href="<?php echo base_url();?>assets/admin/images/favicon.ico" type="image/x-icon">
	<title>aTz || Largest online B2B marketplace </title>
	<!--<link rel="icon" type="image/x-icon" href="assets/front/images/icons/icon_logo.png"> -->	
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/front/css/bootstrap.min.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/front/css/font-awesome.min.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/front/css/ionicons.min.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/front/css/css-plugins-call.css">		
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/front/css/main.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/front/css/responsive.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/front/css/colors.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/front/css/demo.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/front/css/jquery.mmenu.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/front/css/swiper.min.css">	
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/front/css/all-comman.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/front/css/bundle.css">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/front/css/reset.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/front/css/jquery-picZoomer.css">
	
	    <style>
         .form-control{
         border: 1px solid #ced4da;
         }
         option
         {
         font-size:15px;
         }
		 .next-table table {
		border-collapse: collapse;
		border-spacing: 0;
		width: 100%;
		table-layout: fixed;
		background: #fff;
		}
		.next-table td .next-table-cell-wrapper {
			padding: 12px 16px;
			overflow:none !important;
			text-overflow: ellipsis;
			word-break: break-all;
		}
		.biz-sku-infos .skus {
			font-size: 12px;
			margin-top: 5px;
		}
		.biz-sku-infos .sku {
			color: #999;
			margin: 0;
			display: inline-block;
			margin-right: 4px;
		}
		.biz-sku-infos .name a {
			color: #333;
		}

		.pic {
			width:80px !important;
		}
		th.pname 
		{
			width:390px;
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

 <div class="main">
<?php if($pending_order=='Accepted') { ?>
<form name="razorpay-form" id="razorpay-form" action="<?php echo $return_url; ?>" method="POST">
  <input type="hidden" name="razorpay_payment_id" id="razorpay_payment_id" />
  <input type="hidden" name="merchant_order_id" id="merchant_order_id" value="<?php echo $merchant_order_id; ?>"/>
  <input type="hidden" name="merchant_trans_id" id="merchant_trans_id" value="<?php echo $txnid; ?>"/>
  <input type="hidden" name="merchant_product_info_id" id="merchant_product_info_id" value="<?php echo $productinfo; ?>"/>
  <input type="hidden" name="merchant_surl_id" id="merchant_surl_id" value="<?php echo $surl; ?>"/>
  <input type="hidden" name="merchant_furl_id" id="merchant_furl_id" value="<?php echo $furl; ?>"/>
  <input type="hidden" name="card_holder_name_id" id="card_holder_name_id" value="<?php echo $card_holder_name; ?>"/>
  <input type="hidden" name="merchant_total" id="merchant_total" value="<?php echo $total; ?>"/>

</form>
<?php } ?>
<div id="draft" class="draft">
 
    <div>
      <a href="<?php echo base_url(); ?>">
          <div id="brandIntro_1" class="brand-intro" style="height: 20px;">
            <img style="width:200px;" src="<?php echo base_url(); ?>assets/front/images/logo/logo.png">
          </div>
      </a>
    </div>
    <br>
    <div>
      <div class="next-step next-step-arrow next-step-horizontal base-step draft-stepBlock stepBlock_1">
        <div data-spm-click="gostr=/sc.1;locaid=d_step;step=Start Order" class="next-step-item  next-step-item-first"
          style="width: auto;">
          <div class="next-step-item-container">
            <div class="next-step-item-title">Start Order</div>
          </div>
        </div>
		
        <div data-spm-click="gostr=/sc.1;locaid=d_step;step=WaitforResponse" class="next-step-item next-step-item-wait "
          data-spm-anchor-id="a2756.trade-order-standard.0.d_step" style="width: auto;">
          <div class="next-step-item-container">
            <div class="next-step-item-title">
              Wait for response</div>
          </div>
        </div>
		
		<div class="next-step-item next-step-item-wait next-step-item-process" style="width: auto;">
          <div class="next-step-item-container">
            <div class="next-step-item-title">
              Ship & Payment</div>
          </div>
        </div>
		
		
        <div data-spm-click="gostr=/sc.1;locaid=d_step;step= Confirm Receipt" class="next-step-item next-step-item-wait next-step-item-last"
          style="width: auto;">
          <div class="next-step-item-container">
            <div class="next-step-item-title">
              Confirm Receipt</div>
          </div>
        </div>
      </div>
    </div>
    <br>
	
    <div>
	<?php 
	if(isset($pending_order))
	{
		if($pending_order=='Accepted')
		{
?>			<input type="hidden" name="order_id" value="<?php echo $order_dtail['orders_id']; ?>">
		<div class="ui2-feedback ui2-feedback-large ui2-feedback-success notice" data-spm="notice" data-spm-anchor-id="a2700.8267363.0.notice.7b673e5fRsiKW0">
   
    <div class="ui2-feedback-title"> <img src="<?php echo base_url(); ?>assets/checked.png" style="width:30px;">&nbsp;&nbsp;Order Accepted Successfully</div>
    <div class="ui2-feedback-content">
        <p>
            &nbsp;&nbsp;&nbsp;&nbsp;Go For Payment 
        </p>
        <div class="feedback-action">
           <a href="#" class="ui2-button ui2-button-default ui2-button-normal ui2-button-medium">Go to Message Center</a>
            <a href="<?php echo base_url(); ?>" class="ui2-button ui2-button-normal ui2-button-medium app-button" target="_blank">
                <i class="phone-icon iphone"></i>
                <i class="phone-icon andriod"></i>
                <span class="text"><img src="<?php echo base_url(); ?>assets/playstore.png" style="width:20px;">&nbsp;&nbsp;Download the ATZ Cart App</span>
            </a>
            
        </div>
    </div>
</div>
	<?php	}
	elseif($pending_order=='Rejected'){ ?>
	<div class="ui2-feedback ui2-feedback-large ui2-feedback-success notice" data-spm="notice" data-spm-anchor-id="a2700.8267363.0.notice.7b673e5fRsiKW0">
   
    <div class="ui2-feedback-title"> <img src="<?php echo base_url(); ?>assets/delete.png" style="width:25px;">&nbsp;&nbsp; Order Rejected By Seller</div><br>
    <div class="ui2-feedback-content">
        
        <div class="feedback-action">
           <a href="#" class="ui2-button ui2-button-default ui2-button-normal ui2-button-medium">Go to Message Center</a>
            <a href="<?php echo base_url(); ?>" class="ui2-button ui2-button-normal ui2-button-medium app-button" target="_blank">
                <i class="phone-icon iphone"></i>
                <i class="phone-icon andriod"></i>
                <span class="text"><img src="<?php echo base_url(); ?>assets/playstore.png" style="width:20px;">&nbsp;&nbsp;Download the ATZ Cart App</span>
            </a>
            
        </div>
    </div>
</div>
	<?php
	}
}
	
	?>

	
	
	
	
      <?php 

                     if($details) { 
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
                                       <?php echo $details->supplierDetails; ?>
                                       </span>
                                       <!-- <img alt="" class="biz-supplierLite-icon" src="assets/images/product/1.jpg"> -->
                                    </span>
                                 </div>
                                 <div class="next-col biz-supplierLite-showaction" style="display: block;"><span >Show supplier's details</span></div>
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
                                          <tr class="next-table-row last first">
                                             <td class="next-table-cell first">
                                                <div class="next-table-cell-wrapper">
                                                   <div class="biz-sku-infos">
                                                      <div class="pic"><img src="<?php echo $details->product_image; ?>"
                                                         class="media-side"></div>
                                                      <div class="detail">
                                                         <div class="name"><strong><a href="#">
                                                            <?php echo $details->product_name; ?></a></strong>
                                                         </div>
                                                      </div>
                                                   </div>
                                                </div>
                                             </td>
                                          </tr>
                                          <?php
                                             $specifications = $details->specifications;
											
											 
                                             $tot_price = 0;
                                             $count_item = count($specifications);
                                             $qnty = 0;
                                             for ($i = 0; $i < count($specifications); $i++) {
                                                 ?>
                                          <tr>
                                              <td class="next-table-cell">
                                                <div class="next-table-cell-wrapper">
												 <?php if($specifications[$i]->specifications->case_type > 2 || $specifications[$i]->specifications->case_type == 2){ ?>
                                                   <?php for ($j = 0; $j < count($specifications[$i]->specifications->secondary); $j++) {
                                                      if ($j == 0) {
														  
														  if($specifications[$i]->specifications->other[$j]->spec_value)
														  { 
															$other = " ( ".$specifications[$i]->specifications->other[$j]->spec_value ." )";
														  }
														  
                                                          echo $specifications[$i]->specifications->primary->specification_name;
                                                          ?> : <?php echo $specifications[$i]->specifications->primary->spec_value. "<br>";
														  
														  echo $specifications[$i]->specifications->secondary[$j]->specification_name; ?> : <?php
														  echo $specifications[$i]->specifications->secondary[$j]->spec_value .$other. "<br>";
                                                          $qnty += $specifications[$i]->specifications->secondary[$j]->quantity;
                                                      } else { 
														if($specifications[$i]->specifications->other[$j]->spec_value)
														{ 
															$other = " ( ".$specifications[$i]->specifications->other[$j]->spec_value ." )";
														}
													  
														echo $specifications[$i]->specifications->secondary[$j]->specification_name; ?> : <?php
														  echo $specifications[$i]->specifications->secondary[$j]->spec_value .$other. "<br>";
                                                          $qnty += $specifications[$i]->specifications->secondary[$j]->quantity;
                                                      }
                                                      }
												 } else if($specifications[$i]->specifications->case_type == 1){
                                                      for ($j = 0; $j < count($specifications[$i]->specifications->secondary); $j++) { 		  
														 echo $specifications[$i]->specifications->secondary[$j]->specification_name; ?> : <?php
														 echo $specifications[$i]->specifications->secondary[$j]->spec_value . "<br>";
														 $qnty += $specifications[$i]->specifications->secondary[$j]->quantity;
												} } else{ ?>
														<strong><?php echo $details->product_name; ?></strong>
												<?php } ?>
                                                </div>
                                             </td>
                                             <td class="next-table-cell">
                                                <div class="next-table-cell-wrapper">
                                                   <?php echo $qnty; ?> (<?php echo $specifications[$i]->specifications->unit_name; ?>)
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
                                                         INR.<?php echo $specifications[$i]->specifications->unit_price; ?> / <?php echo $specifications[$i]->specifications->unit_name; ?>
                                                      </div>
                                                   </div>
                                                </div>
                                             </td>
                                             <td class="next-table-cell last">
                                                <div class="next-table-cell-wrapper">
                                                   <div class="biz-product-amount">
                                                      INR. <?php
													     if($qnty)
														 {
															$total_price = $qnty * $specifications[$i]->specifications->unit_price;
														 }else{
															$total_price = $specifications[$i]->specifications->total_quantity * $specifications[$i]->specifications->unit_price;
														 }
                                               
                                                         echo $total_price;
                                                         $tot_price += $total_price;
                                                         ?>
                                                   </div>
                                                </div>
                                             </td>
                                          </tr>
                                          <?php $qnty = 0;
                                             $discount = $specifications[$i]->specifications->total_discount;
                                             $discount_percent = $specifications[$i]->specifications->discount_percent;
                                             $total_amount= $specifications[$i]->specifications->total_price_after_dis;
                                           } ?>
											
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
                                       <!-- react-text: 485 -->INR.
                                       <!-- /react-text -->
                                       <!-- react-text: 486 --><?php echo $tot_price; ?>
                                       <!-- /react-text -->
                                    </span>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <?php if($discount > 0){ ?>
                        <div class="next-row next-row-justify-center block-footer" id="productsFooter_1">
                           <div class="next-col block-footer-left">
                              <div id="productsAmountBlock_1" class="block draft-productsAmountBlock">
                                 <div class="biz-products-amount">
                                    <label><span> Max. Coupon Discount of <?php echo $discount_percent; ?>% </span></label>
                                    <span>
                                       <!-- react-text: 485 -->INR.
                                       <!-- /react-text -->
                                       <!-- react-text: 486 --><?php echo $discount; ?>
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
                                       <!-- react-text: 485 -->INR.
                                       <!-- /react-text -->
                                       <!-- react-text: 486 --><?php echo $total_amount; ?>
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
	<?php if($pending_order=='Accepted') { ?>
	<div>
      <div id="shippingBlock_1" class="biz-block-card-wrap biz-block-card-wrap-undefined card draft-shippingBlock">
        <div class="biz-block-card-header">
          <h3 class="biz-block-card-title">
            <!-- react-text: 491 -->
            <!-- /react-text -->
            <!-- react-text: 492 -->Shipping Details
            <!-- /react-text -->
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
				if(!empty($order_dtail))
				{ 
					
			?>
					<div class="input-group" style="width: 265px; padding: 9px;">
					
						<span style="margin-top:-20px; margin-left:10px;"><?php echo $order_dtail['delivery_name']; ?><br>
						<?php echo $order_dtail['delivery_street_address']; ?><br>
						<?php echo $order_dtail['delivery_city'].','.$order_dtail['delivery_state']; ?><br>
						<?php echo $order_dtail['country_name'].','.$order_dtail['delivery_postcode']; ?></span>
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
                Shipping Time:<br></span></label>
            <div class="next-col-20 next-form-item-control" style=" padding: 9px;">
			<span data-i18n-ns="ta.order.com.shipping_time"
                data-i18n-key="value_format">Ship within 15 business days after Seller receiving payment.</span>
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
                    data-i18n-key="no_fee"><?php echo $order_dtail['shipping_cost'];  ?></span></span></div>
					
					<div class="biz-shipping-fee"><label><span data-i18n-ns="ta.order.buynow.shipping_fee" data-i18n-key="label">Payable Amount</span></label><span class="biz-shipping-fee-value"><span data-i18n-ns="ta.order.buynow.shipping_fee"
                    data-i18n-key="no_fee"><?php echo number_format($order_dtail['order_price'],2);  ?></span></span></div>
            </div>
          </div>
        </div>
      </div>
    </div>
	
	  <div>
      <div class="biz-action-bar">
        <div class="biz-action-bar-inner">
         
          <div class="action-bar-submit-tips"><i class="next-icon next-icon-warning next-icon-medium" style="color: rgb(255, 160, 3); margin-right: 10px;"></i><span
              data-i18n-ns="ta.order.com.action_bar">After
              placing this order, please Wait supplier to confirm order and shipping details. </span></div>
          <div>
		  <input class="next-btn next-btn-primary next-btn-large biz-action-bar-button" id="submit-pay" type="submit" onclick="razorpaySubmit(this);" value="Proceed to Pay" class="btn btn-primary" />
		  
        </div>
      </div>
    </div>
	<?php } ?>

</div>
</div>
</div>
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script>
  var razorpay_options = {
    key: "<?php echo $key_id; ?>",
    amount: "<?php echo $total; ?>",
    name: "<?php echo $name; ?>",
    description: "Order # <?php echo $merchant_order_id; ?>",
    netbanking: true,
    currency: "<?php echo $currency_code; ?>",
    prefill: {
      name:"<?php echo $card_holder_name; ?>",
      email: "<?php echo $email; ?>",
      contact: "<?php echo $phone; ?>"
    },
    notes: {
      soolegal_order_id: "<?php echo $merchant_order_id; ?>",
    },
    handler: function (transaction) {
		
        document.getElementById('razorpay_payment_id').value = transaction.razorpay_payment_id;
        document.getElementById('razorpay-form').submit();
    },
    "modal": {
        "ondismiss": function(){
            location.reload()
        }
    }
  };
  var razorpay_submit_btn, razorpay_instance;

  function razorpaySubmit(el){
    if(typeof Razorpay == 'undefined'){
      setTimeout(razorpaySubmit, 200);
      if(!razorpay_submit_btn && el){
        razorpay_submit_btn = el;
        el.disabled = true;
        el.value = 'Please wait...';  
      }
    } else {
      if(!razorpay_instance){
        razorpay_instance = new Razorpay(razorpay_options);
        if(razorpay_submit_btn){
          razorpay_submit_btn.disabled = false;
          razorpay_submit_btn.value = "Pay Now";
        }
      }
      razorpay_instance.open();
    }
  }  
</script>