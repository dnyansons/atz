<html data-dpr="2" style="font-size: 75px;">
   <head>
      <meta charset="utf-8">
      <title>Start Order</title>
      <meta name="viewport" content="width=device-width,user-scalable=no,initial-scale=0.5,maximum-scale=0.5,minimum-scale=0.5">
      <link rel="stylesheet" href="<?php echo base_url(); ?>assets/mobile/mobile/index3.css">
      <link rel="stylesheet" href="<?php echo base_url();?>assets/mobile/css/font-awesome.min.css">
      <script type="text/javascript" src="<?php echo base_url(); ?>assets/mobile/mobile/molar.js"> </script>
      <script type="text/javascript" id="aplus-sufei" src="<?php echo base_url(); ?>assets/mobile/mobile/index3.js" ></script>
      <link rel="stylesheet" href="<?php echo base_url(); ?>assets/mobile/css/ionicons.min.css">
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
         <!-- Two Hidden Field Create For Remove Product From Cart-->
        <input type="hidden" name="cart_pro_arr" value="<?php echo $cart_implode_arr; ?>"/>
        <input type="hidden" name="cart_user_id" value="<?php echo $cart_user_id; ?>"/>
      </form>
      <?php } ?>
      <div id="app">
         <div id="buynow-page" class="">
            <form id="form_1" method="post" class="mext-form buynow-page-form mext-form-enclosed">
               <div class="mext-nav mext-nav-normal mext-nav-layout-normal mext-nav-fixed nav buynow-page-h5WsNavBar">
                  <div class="mext-nav-segment mext-nav-segment-left mext-nav-segment-custom" type="custom">
                     <div class="mext-nav-item mext-nav-segment-back mext-nav-item-custom" type="custom">
                        <a href="<?php echo ($this->session->userdata("start_order_page")=="home/myorders")?site_url()."home/myorders":site_url("product/").$this->session->userdata("start_order_page"); ?>"><i class="mext-icon mext-icon-back mext-icon-medium icon ion-android-arrow-back"></i></a>
<!--                        <a href="<?php //echo site_url("product/").$this->session->userdata("start_order_page"); ?>"><i class="mext-icon mext-icon-back mext-icon-medium icon ion-android-arrow-back"></i></a>-->
                     </div>
                  </div>
                  <div class="mext-nav-segment mext-nav-segment-center mext-nav-segment-custom mext-nav-left" type="custom">
                     <div class="mext-nav-item mext-nav-item-title" type="title"> Place Order </div>
                  </div>
               </div>
               <div class="shipping-address card-container  shippingAddress buynow-page-shippingAddress" style="margin-bottom:3rem">
                  <div class="line"><i class="icon ion-ios-location"></i></i>
                     <span
                        class="contact-person"><?php echo $user_address->contact_person; ?></span> <span class="mobile"><?php echo $user_address->contact_number; ?></span>
                  </div>
                  <div class="address"><?php echo $user_address->street; ?> <?php echo $user_address->city; ?> <?php echo $user_address->state; ?> <?php echo $user_address->name; ?>-<?php echo $user_address->postcode ;?></div>
                  <div class="card-container" >
                    
                     <div class="company"><?php echo $seller_info['company_name']; ?></div>
                     <?php foreach($productsinfos as $productsinfo): ?>
                     <div class="product ">
                         <img class="product-img" style="max-width: 130px; max-height:130px"
                           src="<?php echo $productsinfo->images->url; ?>">
                        <div class="product-info">
                           <div class="product-name"><?php echo $productsinfo->product_name; ?>
                           </div>
                        <div class="product-desc">      
                           <!-- react-text: 29 --><i class="fa fa-inr"></i>
                           <!-- /react-text -->
                           <!-- react-text: 30 --><?php echo $productsinfo->products_price; ?>
                           <!-- /react-text -->
                           <span class="label">
                              <!-- react-text: 32 -->/
                              <!-- /react-text -->
                              <!-- react-text: 33 --><?php echo $productsinfo->units->units_name; ?>
                              <!-- /react-text -->
                           </span>
                        </div>
                        <div>
                            <span class="label">
                               <!-- react-text: 26 -->Total Quantity
                               <!-- /react-text -->
                               <!-- react-text: 27 -->:&nbsp;
                               <!-- /react-text -->
                            </span>
                            <!-- react-text: 28 --><?php echo $productsinfo->products_quantity; ?>
                            <!-- /react-text --><?php echo $productsinfo->units->units_name; ?>
                         </div>
                              <div>
                            <span class="label">
                               <!-- react-text: 26 -->Total Price`s
                               <!-- /react-text -->
                               <!-- react-text: 27 -->:&nbsp;
                               <!-- /react-text -->
                            </span>
                            <!-- react-text: 28 --><i class="fa fa-inr"></i>
                            <!-- /react-text --><?php echo $productsinfo->final_price; ?>
                         </div>
                        </div>
                     </div>
                     <hr/>
                     <div class="util-clearfix"></div>
                     <?php $total_quantity+=$productsinfo->products_quantity;?>
                     <?php $total_price+=$productsinfo->final_price;?>
                     <?php endforeach; ?>
                      
                    <div class="product-footer">
                         <div class="subtotal1" style="width:100%">                          
                            <span style="float:left"> Total Quantity:</span>
                            <div style="float:right ">
<!--                            <span id="total_quantity"></span>--><?php echo $total_quantity; ?> 
                            </div>
                          <br/>
                             Amount :
                             <div style="float:right">
                                 <span><i class="fa fa-inr"></i></span>                 
<!--                              <span id="amount"></span>--> <?php echo number_format((float)$total_price, 2, '.', '') ?>
                             </div> 
                            <br/>
                             Shipping Amount :
                             <div style="float:right">
                                 <span><i class="fa fa-inr"></i></span>
                                 <?php echo $productsinfo->shipping_cost; ?>
                             </div>
                             <hr>
                                Total Amount :
                              <div style="float:right">
                                  <span><i class="fa fa-inr"></i></span>
                                  <?php echo $productsinfo->order_price; ?>                           
                              </div>
                        </div>
                     </div>
                     <span id="error_msg" ></span>
                  </div>
                 
                  <div class="bottom-container mext-form-control fixed">
                     <div class="action-collapse">
                        <div class="label">Amount To Be Paid:</div>
                        <span class="amount total" id="pay_now">
                           Total Amount :<br/> 
                           <i class="fa fa-inr"></i> <?php echo $productsinfo->order_price; ?>
                          <span id="total_amount"></span>
                        </span>
                        <i class="mext-icon mext-icon-arrow-up mext-icon-small arrow rotate"></i>
                     </div>
                     <div class="mext-btn-group mext-btn-group-block mt-50">
                        <button class="mext-btn mext-btn-fixed mext-btn-fixed-primary" onclick="razorpaySubmit(this);" type="button">Place Order</button>
                     </div>
                  </div>
               </div>
<!--                <input type="hidden" name="hide_cart_user_id" value="<?php echo $cart_user_id;?> ">
                   <input type="hidden" name="hide_cart_pro_arr" value="<?php echo $cart_pro_arr;?>">-->
            </form>
         </div>
      </div>
       
       
       <div class="mt-50"></div>
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
            },
            "modal": {
                "ondismiss": function(){
                    location.reload()
                }
            }
          };
          var razorpay_submit_btn, razorpay_instance;
         
          function razorpaySubmit(el){
          
          /**
                                         * Before calling razor pay we check 
                                         * wheather the user has been banned by admin or not 
                                         * iff yes(true) then don't let them shopping
                                         * logout of the system by redirecting
                                         * @param pass nothing we will check it from session
                                         */
                                        $(document).ready(function () {
                                            $.post('<?php echo base_url('userorder/checkBeforePay') ?>')
                                                    .done(function (isBanned) {
                                                        if(isBanned == 0){
                                                            alert('Your account has been banned. Please contact support!');
                                                            window.location.href = "<?php echo base_url('signin'); ?>";
                                                            exit();
                                                        } 
                                                        
                                                    });
                                        });
          
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

