<html data-dpr="2" style="font-size: 75px;">
    <head>
        <meta charset="utf-8">
        <title>Start Order</title>
        <meta name="viewport" content="width=device-width,user-scalable=no,initial-scale=0.5,maximum-scale=0.5,minimum-scale=0.5">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/mobile/mobile/index3.css">
        <meta name="google-site-verification" content="nP5Df-TYNWX_nGB7Qum5d5I4cXzd3E7A2TXtZ0Y2x_Q" /> 
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/mobile/mobile/molar.js"> </script>
        <script type="text/javascript" id="aplus-sufei" src="<?php echo base_url(); ?>assets/mobile/mobile/index3.js" ></script>
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/mobile/css/ionicons.min.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/mobile/css/font-awesome.min.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/mobile/mobile/normal-mobile.css">
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
        <style>
            .address_error{
            color:red;
            }
	 .mext-input .inner-flex{ height: 30%;}
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
        input.largerCheckbox { 
            width: 24px; 
            height: 24px; 
            margin-right: 20px;
            margin-top: 5px;
        } 
        .mext-input-enclosed.mext-input-multiple{
            padding: 10px;
        }
        .total-width{
            width:39%;
            float:right;
        }
       </style>
    </head>
    <body data-spm="trade-order-buynow-h5">
        <div id="app">
            <div id="buynow-page" class="buynow-page">
                <form id="form_1" action="<?php echo base_url();?>product/place_order_product" method="post" class="mext-form buynow-page-form mext-form-enclosed">
                    <div class="mext-nav mext-nav-normal mext-nav-layout-normal mext-nav-fixed nav buynow-page-h5WsNavBar">
                        <div class="mext-nav-segment mext-nav-segment-left mext-nav-segment-custom" type="custom">
                            <div class="mext-nav-item mext-nav-segment-back mext-nav-item-custom" type="custom">
                                <a href="<?php echo base_url(); ?>product/productOverview/<?php echo $productsinfos['id']; ?>"> <i class="mext-icon icon ion-android-arrow-back backmext-icon-medium"></i> </a>
                            </div>
                        </div>
                        <div class="mext-nav-segment mext-nav-segment-center mext-nav-segment-custom mext-nav-left" type="custom">
                            <div class="mext-nav-item mext-nav-item-title" type="title"> Place Order </div>
                        </div>
                    </div>
                    <div class="shipping-address card-container  shippingAddress buynow-page-shippingAddress">
                        <div class="line">
                            <?php if(!empty($user_address)){ ?>
                            <i class="icon ion-android-pin"></i>
                            <span
                                class="contact-person"><?php echo $user_address->contact_person; ?></span> <span class="mobile"><?php echo $user_address->contact_number; ?></span>
                            <?php } ?>
                        </div>
                        <div class="address"><?php echo $user_address->street; ?> <?php echo $user_address->city; ?> <?php echo $user_address->state; ?> <?php echo (!empty($user_address->name)? $user_address->name."-":''); ?><?php echo (!empty($user_address->postcode)?$user_address->postcode:"") ;?></div>
                        <span class="address_error">
                            <center><?php echo $this->session->flashdata('address_error'); ?></center>
                        </span>
                        <div class="address-bt">
                            <?php if(!empty($user_address)){ 
                                   $address= "Change";
                                }else{
                                    $address= "Add";
                                }
                            ?>                          
                            <a href="<?php echo base_url(); ?>product/add_shipping_address" class="mext-btn mext-btn-normal mext-btn-normal-secondary mext-btn-small"
                                type="button"><?php echo $address; ?> Shipping Address</a>
                        </div>
                    </div>
                    <!-- hiddden Place-->
                    <input type="hidden" name="seller_id" value="<?php echo $sellerinfos['id']; ?>">
                    <input type="hidden" name="shipp_addr" id="shipp_addr" value="<?php echo $user_address->address_book_id; ?>">
                    <input type="hidden" name="product_id" value="<?php echo $productsinfos['id']; ?>">
                    <input type="hidden" name="unit" id="hideunit" value="<?php echo $this->session->userdata("unit"); ?>">
                    <input type="hidden" name="moq" id="hidemoq" value="<?php echo $this->session->userdata("moq"); ?>">
                    <input type="hidden" name="product_name" value="<?php echo $productsinfos['name']; ?>">
                    <input type="hidden" name="spec_id" id="hidespec_id" value="<?php echo $this->session->userdata("spec_id");?>">
                    <input type="hidden" name="spec_value" id="hidespec_val" value="<?php echo $this->session->userdata("spec_value");?>">
                    <input type="hidden" name="unit_price" id="hideunit_price" value="<?php  echo $unit_price; ?>"> <!-- Shipprocket One Extra Field Unit Price Error -->
                    <input type="hidden" name="tot_price" id="tot_price">
                    <input type="hidden" name="total_quantity" id="total_quantity">
                    <input type="hidden" name="offer_id" id="offer_id" value="<?php echo $productsinfos['offer_id']; ?>">
                    <!--hidden Place-->
                    <div class="card-container">
                        <div id="loading" class="my-auto" style="display:none;">
                               <img id="loading-image" class="mx-auto" src="<?php echo base_url();?>assets/mobile/images/loader.gif" alt="Loading..." style="width:300px;" />
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
                                        <?php echo $productspec['spec_value']; ?>
                                    </div>
                                    <?php endforeach; ?>
                                    <i class="fa fa-inr"></i>
                                    <span id="priceContainer">
                                        <?php 
                                            if(empty($product_prices[0]->mrp)){
                                                echo number_format($prod_total_price["final_price"]??$productsinfos['product_prices'][0]->final_price,2); 
                                            }else{
                                                echo number_format($product_prices[0]->final_price,2);
                                            }
                                        ?>
                                    </span>/
                                    <span class="label">
                                       <?php  echo $productsinfos['product_prices'][0]->units_name; ?>
                                    </span>
                                    <div>
                                        <span class="label">
                                            MOQ : <?php  echo $productsinfos['moq']; ?>
                                        </span>
                                    </div>
                                    <?php 
                                    $specifications=$this->session->userdata("specifications");
                                    foreach($specifications as $spec){ 
                                            echo "<div class=''>";
                                            echo "<span class='label'>"; 
                                            echo $spec['spec']['name']." :&nbsp;&nbsp;". $spec['spec_value'];        
                                            echo "</span>";  
                                            echo "</div>";
                                    } ?>
                                    
                                </div>
                            </div>
                        </div>
                        <div class="util-clearfix"></div>
                        <div class="product-footer">
                            <div class="mext-number-picker">
                                <button type="button" class="mext-number-picker-reduce disabled" name="minus" onClick="quan(this.name)">
                                <i class="icon ion-android-remove"></i></button>
                                <input class="select-num-input" type="number" id="qty" name="qty" onkeyup="quan(this.name)" 
                                       min="1" max="99999" value="<?php echo $this->session->userdata('qty_value'); ?>">
                                <button type="button"  name="plus" class="mext-number-picker-add" onClick="quan(this.name)"><i class="icon ion-android-add"></i></button>
                            </div>
                            <div class="subtotal">
                                <!-- react-text: 43 -->Subtotal:
                                <!-- /react-text --><i class="fa fa-inr"></i>
                                <!-- react-text: 45 -->
                                <span style="color: rgb(51, 51, 51);" id="total_price">
                          
                                    <!-- /react-text -->
                                    <!-- react-text: 46 -->0
                                    <!-- /react-text -->
                                </span>
                            </div>
                        </div>
                        <span id="error_msg" ></span>
                    </div>
                    
                    <!-- Add To Wallet-->
                    <?php if(!empty($balance) && $balance>0){ ?>
                    <div class="card-container">
                       <div class="title">Use Wallet</div>
                            <div class=" medium mext-input-multiple mext-input-enclosed">
                              <input type="checkbox" name="chk_walletbal" class="form-control checkbox largerCheckbox " id="chk_wallet">Available Wallet Balance 
                              <span class="amount total total-width"><i class="fa fa-inr"></i>
                                <span><?php echo $balance; ?></span>
                            </span>
                            </div>
                       </div>
                    <?php } ?>
                    <!-- End Of Wallet-->
                    <!-- Coupoun Flow END-->
                    <div class="card-container order-remark">
                        <div class="title">Order Remark</div>
                        <div class="mext-input medium mext-input-multiple mext-input-enclosed">
                            <div class="inner-flex">
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
                            <span class="amount total" ><i class="fa fa-inr"></i>
                            <span id="pay_now"> 0.00 </span>
                            </span>
                            <i class="mext-icon mext-icon-arrow-up mext-icon-small arrow rotate"></i>
                        </div>
                        <div class="mext-btn-group mext-btn-group-block">
                            <button class="mext-btn mext-btn-fixed mext-btn-fixed-primary" id="proceed_order" type="submit">Proceed To Order</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        </div>
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/mobile/js/jquery-3.2.1.min.js"></script>
        <script>
        $(document).ready(function(){
            sessionStorage.setItem("prod_id",<?php echo $productsinfos['id']; ?>); // This Session Is Set For Checking Product is Returnable or Non Returnable.
            $("#proceed_order").click(function(){
                $('#loading').show();
            });
        })
        </script>
        <script type="text/javascript">
            $(function(){
            	quan();
            });
            function quan(name){
            	var  quantity= $("#qty").val();
            	var product_prices = JSON.parse('<?php echo json_encode($productsinfos['product_prices']); ?>');
                //console.log(product_prices);
            	if(name=="plus")
            	{
                  quantity++;
            	}
            	else if(name=="minus")
            	{
                  if(quantity>0)
                  {
                        quantity--;
                  }
            	}
                
            	var quantityFromList= product_prices.filter(p => 
            	{
            		let firstInterval = parseInt(p.quantity_from);
            		let secondInterval = parseInt(p.quantity_upto);
            		if(quantity >= firstInterval &&  quantity <= secondInterval)
            		{
                          return true;
            		}
            	});
                
            	if(!quantityFromList.length > 0)
            	{
                    $("#proceed_order").attr("disabled", true);
                    $("#error_msg").html("<small style='color:red'><center>You Cannot Enter Value Less Than Minimum Order Quantity<center><small>");
                    // user Not able To Enter Value manually so comment please Dont Remove.
                    //var val=$("#qty").val(parseInt(product_prices[0].quantity_from));   
                }else{
                    $("#error_msg").html("");
                    $("#qty").val(parseInt(quantity));
                    $("#proceed_order").attr("disabled", false);
            	}
            	quantity= $("#qty").val();
                 //restrict 0 in First Position
//                $('#qty').keypress(function(e){ 
//                    if (this.value.length == 0 && e.which == 48 ){
//                       return false;
//                    }
//                 });
            	var calamount=(quantityFromList.length > 0 && parseInt(quantity)) ? quantityFromList[0].final_price*parseInt(quantity) : (product_prices ? product_prices[0].final_price*parseInt(quantity) : 0);
                // if calamount is Null Then Show Zero.
                if(isNaN(calamount)){
                    $("#qty").val();
                    $("#total_price").text(parseFloat(0).toFixed(2));
                    $("#pay_now").text(parseFloat(0).toFixed(2));
                }else{
                $total_price=$("#total_price").text(parseFloat(calamount).toFixed(2));
            	$pay_now=$("#pay_now").text(parseFloat(calamount).toFixed(2));
                }
            	$("#tot_price").val(parseFloat(calamount).toFixed(2)); //hidden field
            	$("#total_quantity").val(parseInt(quantity)); //hidden field
                // $("#tot_amount").val(parseInt(calamount)); //hidden field
                sessionStorage.setItem("total_qty",quantity);
                sessionStorage.setItem("price",calamount);
            }
            document.getElementById('textareaTextcount').onkeyup = function () {
            document.getElementById('count').innerHTML = "0/" + (120 - this.value.length);
            };

        </script>
        <script>
         $(document).ready(function(){
                var addr = $("#shipp_addr").val();
                if(addr!==""){
                    if(sessionStorage.getItem('returnProd')==1){
                           $(".address_error").html("<center><span style='color:green'>This Order is Returnable at this Pincode.</span></center>");       
                       }
                    if(sessionStorage.getItem('returnProd')==0){
                           $(".address_error").html("<center><span style='color:red'>This Order Not Returnable at this Pincode.</span></center>"); 
                    }
            }else{
                    $(".address_error").html("<center><span style='color:#ccc'> Please Add Your Address </span></center>");
                }
           })
        </script>
    </body>
</html>