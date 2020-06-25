<!doctype html>
<html class="no-js" lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="x-ua-compatible" content="ie=edge">
<title>aTz || Largest online B2B marketplace </title>
<meta name="description" content="">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="google-site-verification" content="nP5Df-TYNWX_nGB7Qum5d5I4cXzd3E7A2TXtZ0Y2x_Q" /> 
<!-- <link rel="stylesheet" href="src/assets/css/demo.css"> -->
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
				<a href="<?php echo site_url(); ?>"> <i class="icon ion-android-arrow-back"></i></a> 
			</div>
			<div class="master">
				<div class="title">
					<div class="title-placeholder">
						<!--padding-->
					</div>
					<title>My Cart</title>
				</div>
			</div>
		</div>
	</div>
</ai-header>

<div id="page" class="content">
	<input name="_csrf_token_" type="hidden" value="ikvgjtjh6mdo">
	<div class="j_favorite">
		<div class="loading" style="display: none;"></div>
		<ul class="items">
                <?php if(!empty($prod_cart)){ ?>
                    <?php foreach($prod_cart as $product): ?>
                    <span><small><center><u><?php echo $product['supplierDetails']; ?></u></center></small></span>
                        <li><a class="it flex " href="<?php echo site_url();?>product/productOverview/<?php echo $product['product_id']; ?>">
					<div class="photo" style="width:100px;height:100px;">
				         	<img style="width:100px;height:100px;"	src="<?php echo $product['product_image']; ?>">
					</div>
					<div class="info flex-1">
                                            <div class="title"><b><?php echo $product['product_name']; ?></b></div>
						<div>Min Order: <?php echo $product['spec_decode'][0]->specifications->moq; ?> <?php echo $product['spec_decode'][0]->specifications->unit_name; ?></div>
						<div>Price: INR <?php echo $product['spec_decode'][0]->specifications->unit_price; ?> / <?php echo $product['spec_decode'][0]->specifications->unit_name; ?></div>
                                                <div>Order Quantity: <?php echo $product['spec_decode'][0]->specifications->total_quantity; ?> <?php echo $product['spec_decode'][0]->specifications->unit_name; ?></div>
                                                <div>Total Price: INR <?php echo ($product['spec_decode'][0]->specifications->total_quantity)*($product['spec_decode'][0]->specifications->unit_price); ?> </div>				
                                                <div class="loc">
						</div>
					</div>
				</a>
				<div class="delf" data-id="<?php echo $product['cart_id']; ?>">Remove this product from cart</div>
			</li>
			<?php endforeach; ?>
                        <?php } else {?>
                                <div class="text-white text-left mt-2 p-2" style="background:#FF9751!important;    box-shadow: 0 5px 11px 0 rgba(0,0,0,.18), 0 4px 15px 0 rgba(0,0,0,.15);">
                                        <small class="title"> No Product in Cart </small>
                                </div>
                        <?php } ?>
		</ul>
                <a href="<?php echo base_url();?>product/getCartProducts" class="btn btn-warning alife-bc-icbu-simple-shopping-cart-btn">Go To Cart</a>
	</div>
</div>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/mobile/js/jquery-3.2.1.min.js"></script>
<script>
	$(".delf").on("click",function(){
		var product_id = $(this).data("id");
		$.ajax({
			url: "<?php echo site_url(); ?>product/removeCartProduct",
					method: "POST",
					data: {"cart_id": product_id},
					success: function (data)
					{
                                            location.reload();
                                        }
			})
		})


</script>
</body>
</html>