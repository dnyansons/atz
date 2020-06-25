<html data-dpr="2" style="font-size: 75px;">
  <head>
    <meta charset="utf-8">
    <title>Start Order</title>
    <meta name="viewport" content="width=device-width,user-scalable=no,initial-scale=0.5,maximum-scale=0.5,minimum-scale=0.5">
    <meta name="google-site-verification" content="nP5Df-TYNWX_nGB7Qum5d5I4cXzd3E7A2TXtZ0Y2x_Q" /> 
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/mobile/mobile/index3.css">
    <link rel="stylesheet" href="<?php echo base_url();?>assets/mobile/css/font-awesome.min.css">
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/mobile/mobile/molar.js"> </script>
    <script type="text/javascript" id="aplus-sufei" src="<?php echo base_url(); ?>assets/mobile/mobile/index3.js" ></script>
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/mobile/css/ionicons.min.css">
        <style>
            .address_error{
            color:red;
            }

            #loading{
                width:100%;
                height:100%;
                position:fixed;
                z-index:9999;
                background-size:35%; 
                top: 0;
                left: 0;
                position: fixed;
                display: block;              
                background-color: rgba(0,0,0,0.4);
                z-index: 999;
                text-align: center;
                }
              #loading-image{
                    position: absolute;
                    left: 50%;
                    top:35%;
                    -webkit-transform: translateX(-50%);
                    transform: translateX(-50%)
                }
        </style>
        <!-- Global site tag (gtag.js) - Google Analytics -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=UA-144123824-1"></script>
        <script>
          window.dataLayer = window.dataLayer || [];
          function gtag(){dataLayer.push(arguments);}
          gtag('js', new Date());

          gtag('config', 'UA-144123824-1');
        </script>

        <script>
        !function(f,b,e,v,n,t,s)
        {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
        n.callMethod.apply(n,arguments):n.queue.push(arguments)};
        if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
        n.queue=[];t=b.createElement(e);t.async=!0;
        t.src=v;s=b.getElementsByTagName(e)[0];
        s.parentNode.insertBefore(t,s)}(window,document,'script',
        'https://connect.facebook.net/en_US/fbevents.js');
         fbq('init', '318941032348543'); 
        fbq('track', 'PageView');
        </script>

        <noscript>
         <img height="1" width="1" 
        src="https://www.facebook.com/tr?id=318941032348543&ev=PageView
        &noscript=1"/>
        </noscript>
        <!-- End Facebook Pixel Code -->

        <!-- Global site tag (gtag.js) - Google Ads: 728750276 -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=AW-728750276"></script>
        <script>
         window.dataLayer = window.dataLayer || [];
         function gtag(){dataLayer.push(arguments);}
         gtag('js', new Date());

         gtag('config', 'AW-728750276');
        </script>
  </head>
  <body data-spm="trade-order-buynow-h5">
    <div id="app">
      <div id="buynow-page" class="buynow-page">
        <form id="form_1" action="<?php echo base_url();?>product/place_order_cart_product" method="post" class="mext-form buynow-page-form mext-form-enclosed">
          <div class="mext-nav mext-nav-normal mext-nav-layout-normal mext-nav-fixed nav buynow-page-h5WsNavBar">
            <div class="mext-nav-segment mext-nav-segment-left mext-nav-segment-custom" type="custom">
              <div class="mext-nav-item mext-nav-segment-back mext-nav-item-custom" type="custom">
                <a href="<?php echo $_SERVER['HTTP_REFERER']; ?>"><i class="mext-icon icon ion-android-arrow-back backmext-icon-medium"></i></a>
              </div>
            </div>
            <div class="mext-nav-segment mext-nav-segment-center mext-nav-segment-custom mext-nav-left" type="custom">
              <div class="mext-nav-item mext-nav-item-title" type="title"> Place Order </div>
            </div>
          </div>
          <div class="shipping-address card-container  shippingAddress buynow-page-shippingAddress">
            <div class="line">
			 <i class="icon ion-ios-location"></i>	
			
              <span
                class="contact-person"><?php echo $user_address->contact_person; ?></span> <span class="mobile"><?php echo $user_address->contact_number; ?></span>
            </div>
            <div class="address"><?php echo $user_address->street; ?> <?php echo $user_address->city; ?> <?php echo $user_address->state; ?> <?php echo $user_address->name; ?>-<?php echo $user_address->postcode ;?></div>
            <!-- Hidden Field For Address Validation While Adding -->
            <input type="hidden" name="hide_ship_addr_id" value="<?php echo $user_address->address_book_id; ?>">
            <span class="address_error">
                            <center><?php echo $this->session->flashdata('address_error'); ?></center>
            </span>
            <div class="address-bt">
              <a href="<?php echo base_url(); ?>product/add_shipping_address" class="mext-btn mext-btn-normal mext-btn-normal-secondary mext-btn-small"
                type="button">Add Shipping Address</a>
            </div>
          </div>
           
          <!-- hiddden Place-->
          <div class="card-container">
              <div id="loading" class="my-auto" style="display:none;">
                               <img id="loading-image" class="mx-auto" src="<?php echo base_url();?>assets/mobile/images/loader.gif" alt="Loading..." style="width:300px;" />
              </div>
            <div class="company"><?php echo $sellerinfos['company_name']; ?></div>
            <?php $total_product_price=0; ?>
            <?php for($i=0;$i<count($cart_product);$i++){ ?>
            <div class="product util-clearfix">
              <img class="product-img"
                src="<?php  echo $cart_product[$i]['product_image']; ?>">
              <div class="product-info">
                <div class="product-name"><?php echo $cart_product[$i]['product_name']; ?>
                </div>
                <div class="product-desc">
                  <?php //foreach($cart_product[$i]['specifications_decode'] as $productspec): ?>
                  <div>
                    <span class="label">
                      <!-- react-text: 26 -->Unit Price
                      <!-- /react-text -->
                      <!-- react-text: 27 -->:&nbsp;
                      <!-- /react-text -->
                    </span>
                    <!-- react-text: 28 --><i class="fa fa-inr"></i> <?php echo number_format($cart_product[$i]['specifications_decode'][0]->specifications->unit_price,2); ?> / <?php echo $cart_product[$i]['specifications_decode'][0]->specifications->unit_name; ?>
                    <!-- /react-text -->
                    <br/>
                    <span class="label">
                      <!-- react-text: 26 -->Total Quantity
                      <!-- /react-text -->
                      <!-- react-text: 27 -->:&nbsp;
                      <!-- /react-text -->
                    </span>
                    <!-- react-text: 28 --><?php echo $cart_product[$i]['specifications_decode'][0]->specifications->total_quantity; ?> <?php echo $cart_product[$i]['specifications_decode'][0]->specifications->unit_name; ?>
                    <!-- /react-text -->
                    <br/>
                    <span class="label">
                      <!-- react-text: 26 -->Total Price
                      <!-- /react-text -->
                      <!-- react-text: 27 -->:&nbsp;
                      <!-- /react-text -->
                    </span>
                    <!-- react-text: 28 --><i class="fa fa-inr"></i> <?php echo number_format($tot_product_prices[$i],2); ?>
                    <br/>
                    
                    <!-- Display Specification On Page------>
                    <div>
                    <?php 
                        $spec_name_pri = $cart_product[$i]['specifications_decode'][0]->specifications->primary->specification_name;
                        $spec_name_sec = $cart_product[$i]['specifications_decode'][0]->specifications->secondary[0]->specification_name;
                        if(!empty($spec_name_pri))
                        {
                            echo "<span class='label'>".$spec_name_pri." :&nbsp;</span>";
                            echo $cart_product[$i]['specifications_decode'][0]->specifications->primary->spec_value;
                            echo "<br/>";
                        }
                        if(!empty($spec_name_sec))
                        {
                           echo "<span class='label'>".$spec_name_sec." :&nbsp;</span>";
                           foreach($cart_product[$i]['specifications_decode'][0]->specifications->secondary as $spec){
                               echo str_replace('_',' ',$spec->spec_value.' ('.$spec->quantity.')').",<br>";
                           } 
                        }
                    ?>
                    </div>
                  </div>
                  <input type="hidden" name="cart_id[]" value="<?php echo $cart_product[$i]['id']?>" >
                  <?php //endforeach; ?>
                </div>
              </div>
            </div>
            <hr/>
            <?php } ?>
           
            <div class="util-clearfix"></div>
            <div class="product-footer">
              <div class="subtotal">
                <!-- react-text: 43 -->Subtotal:
                <!-- /react-text -->
                <!-- react-text: 45 -->
                <span style="color: rgb(51, 51, 51);" id="total_price">
                  <!-- /react-text -->
                  <!-- react-text: 46 --><i class="fa fa-inr"></i> <?php echo number_format((float)$tot_order_product_prices, 2, '.', ''); ?>
                  <!-- /react-text -->
                </span>
              </div>
            </div>
            <span id="error_msg" ></span>
          </div>
          <div class="card-container order-remark">
            <div class="title">Order Remark</div>
            <div class="mext-input medium mext-input-multiple mext-input-enclosed">
              <div class="inner-flex" style="height:48%">
                <div class="inner-input-box flex-10">
                  <textarea  id="textareaTextcount" name="order_remark" type="enclosed"
                    placeholder="You can add more product infomation here, e.g. color, size, material and so on."
                    style="text-align: left;"></textarea>
                  <div class="mext-input-counter" id="count">
                    <!-- react-text: 61 -->0
                    <!-- /react-text -->
                    <!-- react-text: 62 -->/
                    <!-- /react-text -->
                    <!-- react-text: 63 -->120
                    <!-- /react-text -->
                  </div>
                </div>
              </div>
            </div>
            <p class="notice">Upon clicking 'Place To Order', I acknowledge I have read and agreed to:</p>
            <div><a class="ta-service-link" href="">Atzcart.com Transaction
              Service Agreement</a>
            </div>
          </div>
          <!--Hidden Field-->
          <!--Hidden Data-->
          <div class="bottom-container mext-form-control fixed">
            <div class="action-collapse">
              <div class="label">Amount To Be Paid:</div>
              <span class="amount total" id="pay_now">
                <!-- react-text: 71 --><i class="fa fa-inr"></i>
                <!-- /react-text -->
                <!-- react-text: 72 --><?php echo number_format((float)$tot_order_product_prices, 2, '.', ''); ?>
                <!-- /react-text -->
              </span>
              <i class="mext-icon mext-icon-arrow-up mext-icon-small arrow rotate"></i>
            </div>
            <div class="mext-btn-group mext-btn-group-block">
              <button class="mext-btn mext-btn-fixed mext-btn-fixed-primary" id="submitOrder" type="submit">Proceed To Order</button>
            </div>
          </div>
          </form>
      </div>
    </div>
    </div>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/mobile/js/jquery-3.2.1.min.js"></script>
  </body>
  <script>
        $(document).ready(function(){
            $("#submitOrder").click(function(){
                $('#loading').show();
            })
        })
        </script>
  <script>
  $(document).ready(function(){
    $('#submitOrder').click(function(){
    });

  });
  document.getElementById('textareaTextcount').onkeyup = function () {
            document.getElementById('count').innerHTML = "0/" + (120 - this.value.length);
            };
  </script>

</html>

