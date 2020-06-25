<html data-dpr="2" style="font-size: 75px;">
   <head>
      <meta charset="utf-8">
      <title>Start Order</title>
      <meta name="viewport" content="width=device-width,user-scalable=no,initial-scale=0.5,maximum-scale=0.5,minimum-scale=0.5">
      <link rel="stylesheet" href="<?php echo base_url();?>assets/mobile/css/ionicons.min.css">
      <link rel="stylesheet" href="<?php echo base_url(); ?>assets/mobile/mobile/index3.css">
      <link rel="stylesheet" href="<?php echo base_url(); ?>assets/mobile/css/font-awesome.min.css">
      <script type="text/javascript" src="<?php echo base_url(); ?>assets/mobile/mobile/molar.js"> </script>
      <script type="text/javascript" id="aplus-sufei" src="<?php echo base_url(); ?>assets/mobile/mobile/index3.js" ></script>
	  <style>
	  .razorpay-backdrop{bacground:#000 !important;}
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

           #loading-image {
               position:absolute;
               top:25%;
               left:30%;
               z-index: 99999;
           }
	  </style>
   </head>
   <body data-spm="trade-order-buynow-h5">
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

      <div id="app">
         <div id="buynow-page" class="buynow-page">
            <form id="form_1" method="post" class="mext-form buynow-page-form mext-form-enclosed">
               <div class="mext-nav mext-nav-normal mext-nav-layout-normal mext-nav-fixed nav buynow-page-h5WsNavBar">
                  <div class="mext-nav-segment mext-nav-segment-left mext-nav-segment-custom" type="custom">
                     <div class="mext-nav-item mext-nav-segment-back mext-nav-item-custom" type="custom">
                         <a href="<?php echo base_url(); ?>product/start_order/<?php echo $productsinfos['id']; ?>"><i class="mext-icon icon ion-android-arrow-back backmext-icon-medium"></i></a>
<!--                         <a href="<?php //echo $_SERVER['HTTP_REFERER']; ?>"> <i class="mext-icon icon ion-android-arrow-back backmext-icon-medium"></i></a>-->
                     </div>
                  </div>
                  <div class="mext-nav-segment mext-nav-segment-center mext-nav-segment-custom mext-nav-left" type="custom">
                     <div class="mext-nav-item mext-nav-item-title" type="title"> Place Order </div>
                  </div>
               </div>
               <div class="shipping-address card-container  shippingAddress buynow-page-shippingAddress">
                  <div class="line"><i class="icon ion-android-pin"></i>	
                     <span
                        class="contact-person"><?php echo $user_address->contact_person; ?></span> <span class="mobile"><?php echo $user_address->contact_number; ?></span>
                  </div>
                  <div class="address"><?php echo $user_address->street; ?> <?php echo $user_address->city; ?> <?php echo $user_address->state; ?> <?php echo $user_address->name; ?>-<?php echo $user_address->postcode ;?></div>
                  <!--<div class="address-bt">
                     <a href="<?php //echo base_url(); ?>product/add_shipping_address" class="mext-btn mext-btn-normal mext-btn-normal-secondary mext-btn-small"
                                  type="button">Change Shipping Address</a></div>
                             </div>-->
                  <!--hiddden Place-->
                  <div class="card-container">
                      <div id="loading" class="my-auto" style="display:none;">
                               <img id="loading-image" class="my-auto" src="<?php echo base_url(); ?>assets/front/images/loader1.gif" alt="Loading..." style="width:300px;" />
                      </div>
                     <div class="company"><?php echo $sellerinfos['company_name']; ?></div>
                     <div class="product">
                        <img class="product-img"
                           src="<?php  echo $productsinfos['images'][0]; ?>">
                        <div class="product-info">
                           <div class="product-name"><?php echo $productsinfos['name']; ?>
                           </div>
                           <div class="product-desc">
                              <?php foreach($productspecs as $productspec): ?>
                              <div>
                                 <span class="label">
                                    <!-- react-text: 26 --><?php echo $productspec['specification_name']; ?>
                                    <!-- /react-text -->
                                    <!-- react-text: 27 -->:&nbsp;
                                    <!-- /react-text -->
                                 </span>
                                 <!-- react-text: 28 --><?php echo $productspec['spec_value']; ?>
                                 <!-- /react-text -->
                              </div>
                              <?php endforeach; ?>
                              <!-- react-text: 29 --><i class="fa fa-inr"></i>
                              <!-- /react-text -->
                              <!-- react-text: 30 --><?php  echo $price_range['final_price'];  ?>
                              <!-- /react-text -->
                              <span class="label">
                                 <!-- react-text: 32 -->/
                                 <!-- /react-text -->
                                 <!-- react-text: 33 --><?php  echo $productsinfos['product_prices'][0]->units_name; ?>
                                 <!-- /react-text -->
                              </span>
                           </div>
                        </div>
                     </div>
                     <div class="util-clearfix"></div>
                     <div class="product-footer">
                         <div class="subtotal1" style="width:100%">                          
                            <span style="float:left"> Total Quantity:</span>
                            <div style="float:right ">
<!--                            <span id="total_quantity"></span>--><?php echo ($order_dtail['products_quantity']); ?>
                              <?php  echo $productsinfos['product_prices'][0]->units_name; ?>
                            </div>
                          <br/>
                             Amount :
                             <div style="float:right">
                                 <span><i class="fa fa-inr"></i></span>                 
<!--                              <span id="amount"></span>--> <?php echo $amount=number_format((float)$order_dtail['products_quantity']*$price_range['final_price'], 2, '.', ''); ?>
                             </div> 
                            <br/>
                             Shipping Amount :
                             <div style="float:right">
                                 <span><i class="fa fa-inr"></i></span>
                                 <?php echo $order_dtail['shipping_cost']; ?>
                             </div>
<!--                            <br/>
                            Coupon Amount :
                             <div style="float:right">
                                 <span><?php //echo $productsinfos['currency_name']; ?></span>
                                 <?php //echo $order_dtail['shipping_cost']; ?>
                             </div>-->
                        </div>
                     </div>
                     <hr>
                      Total Amount :
                    <div style="float:right">
                        <span><i class="fa fa-inr"></i></span>
                        <?php //echo number_format((float)$order_dtail['order_price'], 2, '.', ''); ?>
                         <?php echo number_format((float)$amount+$order_dtail['shipping_cost'], 2, '.', ''); ?>
                        
                    </div>
                    <hr>
                  </div>
                  <div class="bottom-container mext-form-control fixed">
                     <div class="action-collapse">
                        <div class="label">Amount To Be Paid:</div>
                        <span class="amount total" id="pay_now">
                           <!-- react-text: 71 --><i class="fa fa-inr"></i>
                           <!-- /react-text -->
<!--                            react-text: 72 <span id="total_amount"></span>--><?php echo number_format((float)$amount+$order_dtail['shipping_cost'], 2, '.', ''); ?>
                           <!-- /react-text -->
                        </span>
                        <i class="mext-icon mext-icon-arrow-up mext-icon-small arrow rotate"></i>
                     </div>
                     <div class="mext-btn-group mext-btn-group-block">
                        <button class="mext-btn mext-btn-fixed mext-btn-fixed-primary" onclick="razorpaySubmit(this);" type="button">Place Order</button>
                     </div>
                  </div>
               </div>
            </form>
         </div>
      </div>
      <script type="text/javascript" src="<?php echo base_url(); ?>assets/mobile/js/jquery-3.2.1.min.js"></script>
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
                $('#loading').show();
                
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
      
   </body>
</html>