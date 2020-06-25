<!doctype html>
<html class="no-js" lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="x-ua-compatible" content="ie=edge">
<title>aTz || Largest online B2B marketplace </title>
<meta name="description" content="">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="google-site-verification" content="nP5Df-TYNWX_nGB7Qum5d5I4cXzd3E7A2TXtZ0Y2x_Q" /> 
<link rel="icon" type="image/x-icon" href="assets/images/icons/icon_logo.png"> 	
<link rel="stylesheet" href="<?php echo base_url();?>assets/mobile/css/bootstrap.min.css">
<link rel="stylesheet" href="<?php echo base_url();?>assets/mobile/css/font-awesome.min.css">
<link rel="stylesheet" href="<?php echo base_url();?>assets/mobile/css/ionicons.min.css">	
<link rel="stylesheet" href="<?php echo base_url();?>assets/mobile/css/main.css">
<link rel="stylesheet" href="<?php echo base_url();?>assets/mobile/css/slide.css">
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
<body>
<ai-header>
	<div class="header-container" style="position: fixed;">
		<div class="header-wrap" ab-test-bucket="">
			<div class="inner ripple rtl-icon">	
				<a href="<?php echo site_url(); ?>">  <i class="icon ion-android-arrow-back"></i></a> 
			</div>
			<div class="master">
				<div class="title">
					<div class="title-placeholder">
						<!--padding-->
					</div>
                                        <title> My Cart </title>
				</div>
			</div>
		</div>
	</div>
</ai-header>

<div id="page" class="content mt-2">
	<input name="_csrf_token_" type="hidden" value="ikvgjtjh6mdo">
  <div id="res_msg"></div>
	<div class="j_favorite">
		<div class="loading" style="display: none;"></div>
		<ul class="items">
                    <?php if(!empty($cart_product)){ ?>
                    <?php 
                        $j=1;
                        foreach($cart_product as $key => $sellerwise){ 
                                $countProductSellerWise = count($sellerwise);
                            if ($countProductSellerWise > 1) { ?>
                            <!-- For Multiple Add To Cart-->
                            <span><small><center><u><?php echo $cart_product[$key][0]['supplierDetails']; ?></u></center></small></span>
                            <li class="mt-1">
                            <?php for($i=0; $i<$countProductSellerWise;$i++){ ?>
                                 <a class="it flex " href="<?php echo site_url();?>product/productOverview/<?php echo $cart_product[$key][$i]['product_id']; ?>">
					<div class="photo" style="width:100px;height:100px;">
				         	<img style="width:100px;height:100px;"	src="<?php echo $cart_product[$key][$i]['product_image']; ?>">
					</div>
					<div class="info flex-1">
                                            <div class="title"><b><?php echo $cart_product[$key][$i]['product_name']; ?></b></div>
						<div>Min Order: <?php echo $cart_product[$key][$i]['spec_decode'][0]->specifications->moq; ?> <?php echo $cart_product[$key][$i]['spec_decode'][0]->specifications->unit_name; ?></div>
                                                <div>Price: <i class="fa fa-inr"></i> <?php echo $cart_product[$key][$i]['spec_decode'][0]->specifications->unit_price; ?> / <?php echo $cart_product[$key][$i]['spec_decode'][0]->specifications->unit_name; ?></div>
                                                <div>Order Quantity: <?php echo $cart_product[$key][$i]['spec_decode'][0]->specifications->total_quantity; ?> <?php echo $cart_product[$key][$i]['spec_decode'][0]->specifications->unit_name; ?></div>
                                                <div>
                                                <?php 
                                                if(!empty($cart_product[$key][$i]['spec_decode'][0]->specifications->primary->specification_name)){
                                                 echo "<strong>".$cart_product[$key][$i]['spec_decode'][0]->specifications->primary->specification_name.":"; ?>  <?php  echo $cart_product[$key][$i]['spec_decode'][0]->specifications->primary->spec_value."</strong>";
                                                 echo "<br>";
                                                }
                                                if(!empty($cart_product[$key][$i]['spec_decode'][0]->specifications->secondary[0]->specification_name)){
                                                    echo "<strong>Specification :</strong><br>";
                                                    echo "<strong>".$cart_product[$key][$i]['spec_decode'][0]->specifications->secondary[0]->specification_name.":"."</strong>";
                                                ?> 
                                                <?php  
                                                    foreach($cart_product[$key][$i]['spec_decode'][0]->specifications->secondary as $spec){
                                                        echo str_replace('_',' ',$spec->spec_value.' ('.$spec->quantity.')').",<br>";
                                                    }
                                                }

                                                ?>
                                                </div>
                                                <div>
                                                    <?php
                                                    if(strtolower($cart_product[$key][$i]['offers']['offer_status']) == 'active') 
                                                    { 
                                                       $offer_end_datetime = $cart_product[$key][$i]['offers']['valid_to'].' '.$cart_product[$key][$i]['offers']['time_to'];
                                                       $offerStatus = $cart_product[$key][$i]['offers']['offer_status'];
                                                       echo "<h6 class='p-0 pb-1 m-0 text-success font-weight-bold offer_timer' style='font-size:13px;'  id='offer_timer$j'></h6>";
                                                       $j++;
                                                    } 
                                                  ?>
                                                </div>
                                        </div>    
				</a>
                                   <div class="delf1 col-5 offset-4" data-id="<?php echo $cart_product[$key][$i]['id']; ?>"><button class="btn-danger btn-block btn py-0 px-2"><small>Remove</small></button> </div>
                                   <input type="hidden" name="cart_id" class="cart_id" id="cart_id_offer<?php echo $j; ?>" value="<?php echo $cart_product[$key][$i]['id']; ?>">
                                   <input type="hidden" name="cart_offer" class="cart_offer" id="cart_offer<?php echo $j; ?>" value="<?php echo $cart_product[$key][$i]['offers']['offer_id']; ?>">
                                   <hr>			   
                            <?php } ?>
                                <a href="<?php echo base_url(); ?>product/startOrderForCartProduct/<?php echo $cart_product[$key][0]["seller_id"]; ?>" ><button  type="submit" class=" px-2 py-0 btn btn-outline-danger" role="button" ><span>Continue Process </span> <i class="icon ion-chevron-right"></i></button></a>
                            </li>
                            <?php  } else{ ?>
                            <!-- For Single Add To Cart-->
                            <br>
                            <span><small><center><u><?php echo $cart_product[$key][0]['supplierDetails']; ?></u></center></small></span>
                             <li> <a class="it flex " href="<?php echo site_url();?>product/productOverview/<?php echo $cart_product[$key][0]['product_id']; ?>">
                                                <div class="photo" style="width:100px;height:100px;">
                                                        <img style="width:100px;height:100px;"	src="<?php echo $cart_product[$key][0]['product_image']; ?>">
                                                </div>
                                                <div class="info flex-1">
                                                    <div class="title"><b><?php echo $cart_product[$key][0]['product_name']; ?></b></div>
                                                        <div>Min Order: <?php echo $cart_product[$key][0]['spec_decode'][0]->specifications->moq; ?> <?php echo $cart_product[$key][0]['spec_decode'][0]->specifications->unit_name; ?></div>
                                                        <div>Price:  <i class="fa fa-inr"></i> <?php echo $cart_product[$key][0]['spec_decode'][0]->specifications->unit_price; ?> / <?php echo $cart_product[$key][0]['spec_decode'][0]->specifications->unit_name; ?></div>
                                                        <div>Order Quantity: <?php echo $cart_product[$key][0]['spec_decode'][0]->specifications->total_quantity; ?> <?php echo $cart_product[$key][0]['spec_decode'][0]->specifications->unit_name; ?></div>
                                                        <div><strong>Specification :</strong> <br>
                                                            <?php 
                                                            if(!empty($cart_product[$key][0]['spec_decode'][0]->specifications->primary->specification_name)){
                                                                 echo "<strong>".$cart_product[$key][0]['spec_decode'][0]->specifications->primary->specification_name.":"; ?>  <?php  echo $cart_product[$key][0]['spec_decode'][0]->specifications->primary->spec_value."</strong>";
                                                                 echo "<br>";   
                                                            }
                                                            if(!empty($cart_product[$key][0]['spec_decode'][0]->specifications->secondary[0]->specification_name)){
                                                                    echo "<strong>Specification :</strong><br>";
                                                                    echo "<strong>".$cart_product[$key][0]['spec_decode'][0]->specifications->secondary[0]->specification_name.":"."</strong>"; ?> 
                                                                  <?php 
                                                                    foreach($cart_product[$key][0]['spec_decode'][0]->specifications->secondary as $spec){
                                                                    echo str_replace('_',' ',$spec->spec_value.' ('.$spec->quantity.')').",<br>";
                                                                  }
                                                                }
                                                            ?>
                                                         </div>
                                                        <div>
                                                            <?php
                                                            if(strtolower($cart_product[$key][0]['offers']['offer_status']) == 'active') 
                                                            { 
                                                               $offer_end_datetime = $cart_product[$key][0]['offers']['valid_to'].' '.$cart_product[$key][0]['offers']['time_to'];
                                                               $offerStatus = $cart_product[$key][0]['offers']['offer_status'];
                                                               echo "<p class='p-0 m-0 text-success font-weight-bold offer_timer' id='offer_timer123'></p>";
                                                            } 
                                                          ?>
                                                        </div>
                                                        <div class="loc">
                                                        </div>      
                                                </div>						
                                            </a>
                                        <div class="delf1 col-5 offset-5 " data-id="<?php echo $cart_product[$key][0]['id']; ?>">
					<button class="btn-danger btn-block btn py-0 px-2"><small>Remove</small></button> </div>
                                        <br/>
                                        <a href="<?php echo base_url(); ?>product/startOrderForCartProduct/<?php echo $cart_product[$key][0]["seller_id"]; ?>" ><button  type="submit" class=" px-2 py-0 btn btn-outline-danger"  role="button" ><span>Continue Process </span> <i class="icon ion-chevron-right"></i></button></a>
<!--                                        <input type="hidden" name="cart_id" class="cart_id" id="cart_id_offer" value="<?php //echo $cart_product[$key][0]['id']; ?>">-->
                                        <input type="hidden" name="cart_id" class="cart_id" id="cart_id_offer" value="<?php echo $cart_product[$key][0]['id']; ?>">
                                        <input type="hidden" name="cart_offer" class="cart_offer" id="cart_offer" value="<?php echo $cart_product[$key][0]['offers']['offer_id']; ?>">
                             </li>
                    <?php } } }else{?>
                             							 
                                    <div class="text-white text-left mt-2 p-2" style="background:#FF9751!important;    box-shadow: 0 5px 11px 0 rgba(0,0,0,.18), 0 4px 15px 0 rgba(0,0,0,.15);">
                                            <small class="title">Oops! No Product in Cart </small>
                                    </div>
                    <?php } ?>
		</ul>
            </div>
        </div>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/mobile/js/jquery-3.2.1.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/mobile/js/bootbox.min.js"></script>
<script>
        // Set the date we're counting down to
        var countDownDate = new Date("<?php echo $offer_end_datetime; ?>").getTime();
        // Number Of Time Loop.
        var count = "<?php echo $count_rows ?>";
        // Update the count down every 1 second
       
        var x = setInterval(function() {
            // Get today's date and time
            var now = new Date().getTime();
            // Find the distance between now and the count down date
            var distance = countDownDate - now;
            // Time calculations for days, hours, minutes and seconds
            var days = Math.floor(distance / (1000 * 60 * 60 * 24));
            var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            var seconds = Math.floor((distance % (1000 * 60)) / 1000);
            
            //single Order Offer Time
           /*$("#offer_timer123").html(' '+days + "D : " + hours + "H : "
                + minutes + "M : " + seconds + "S");*/
                if (distance < 0) {
                    clearInterval(x);
                    $("#offer_timer123").html("");
                }
               if(days<=0 && hours<=0 && minutes<=0 && seconds<=0)
               {
                    var cart_offer=($("#cart_offer").val());
                    var cart_id_offer=($("#cart_id_offer").val());
                    
                    if(cart_offer!="" && cart_offer!=null){
                     setTimeout(setTimeOutOffer(cart_id_offer),distance);
                    }
               }
            
        // Display the result in the element with id="demo"
        //Multiple order Offer Time    
        for(var j=1;j<=count;j++){  
            /*$("#offer_timer"+j).html(' '+days + "D : " + hours + "H : "
                + minutes + "M : " + seconds + "S") ;*/
                // If the count down is finished, write some text
                if (distance < 0) {
                    clearInterval(x);
                    $("#offer_timer"+j).html("");
                }
                if(days<=0 && hours<=0 && minutes<=0 && seconds<=0)
                {
                    var cart_offer=($("#cart_offer"+j).val());
                    var cart_id_offer=($("#cart_id_offer"+j).val());
                    
                    if(cart_offer!="" && cart_offer!=null){
                       setTimeout(setTimeOutOffer(cart_id_offer),distance);
                    }
                }
            }
        },1000);
        
        function setTimeOutOffer(cart_id_offer){
                        $.ajax({
                             url: "<?php echo base_url();?>product/removeCartProduct",
                             data: { cart_id:cart_id_offer},
                             type: "POST",
                             success:function(data){
                                 location.reload();
                             }
                        });
                    }
        
</script>
<script>
        $(".delf1").on("click",function(){
                var product_id = $(this).data("id");
                bootbox.confirm({
                    message: "Do You Want To Remove Product From Cart?",
                    buttons: {
                        confirm: {
                            label: 'Yes',
                            className: 'btn-success'
                        },
                        cancel: {
                            label: 'No',
                            className: 'btn-danger'
                        }
                    },
                    callback: function (result) {
                        if(result){
                          $.ajax({
                                url: "<?php echo site_url(); ?>product/removeCartProduct",
                                method: "POST",
                                data: {"cart_id": product_id},
                                success: function (data)
                                { 
                                  var result=JSON.parse(data);
                                   console.log(result.status);
                                   if(result.flag==1 && result.status=='success') 
                                   {
                                       $msg = "<div class='alert alert-success alert-dismissible'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><strong>Success !</strong> Item has been successfully removed from cart.! </div>";
                                       // location.reload();
                                       $('#res_msg').html($msg);
                                       window.location.href = '<?php echo site_url(); ?>home/mycart/';
                                   }
                                   else if(result.flag==0 && result.status=='failed') 
                                   {
                                      $msg = "<div class='alert alert-danger alert-dismissible'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><strong>Error !</strong> Something went wrong.! </div>";
                                      $('#res_msg').html($msg);
                                      window.location.href = '<?php echo site_url(); ?>home/mycart/';
                                   }
                                }
                            });  
                        }
                    }
                }); 
            });       
            
</script>
</body>
</html>
