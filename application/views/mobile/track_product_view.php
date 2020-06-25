<!doctype html>
<html class="no-js" lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="x-ua-compatible" content="ie=edge">
<meta name="google-site-verification" content="nP5Df-TYNWX_nGB7Qum5d5I4cXzd3E7A2TXtZ0Y2x_Q" /> 
<title>aTz || Largest online B2B marketplace </title>
<meta name="description" content="">
<meta name="viewport" content="width=device-width, initial-scale=1">
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
				<a href="<?php echo $_SERVER['HTTP_REFERER']; ?>"> <i class="icon ion-android-arrow-back"></i></a> 
			</div>
			<div class="master">
				<div class="title">
					<div class="title-placeholder">
						<!--padding-->
					</div>
					<title>Order Products</title>
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
                <?php if(!empty($order_products)){ ?>
                    <?php foreach($order_products as $product): ?>
                    
                            <li>
                                <a class="it flex " href="<?php echo site_url();?>product/productOverview/<?php echo $product->product_id; ?>">
					<div class="photo">
				         	<img style="width:150px;height:150px;"	src="<?php echo $product->product_image; ?>">
					</div>
					<div class="info flex-1">
                                            <div class="title"><h6><?php echo $product->product_name; ?></h6></div>
						<div>Min Order: <?php echo $product->moq; ?> / <?php echo $product->units_name; ?></div>
						<?php 
                                                    if(!empty($product->offer_id)){
                                                      echo '<div>Price: <i class="fa fa-inr"></i> '.$product->final_price.' / '.$product->units_name.'</div>';  
                                                    }else{
                                                      echo '<div>Price: <i class="fa fa-inr"></i> '.$product->unit_price.' / '.$product->units_name.'</div>';
                                                    }
                                                ?>
                                                <div>Order Quantity: <?php echo $product->products_quantity; ?> <?php echo $product->units_name; ?></div>
                                                <div class="font-weight-bold">Total Price: <i class="fa fa-inr"></i> <?php echo ($product->grand_price); ?> </div>
                                                <?php 
                                                 if(!empty($product->decode_spec->specifications[0]->specifications->primary)){
                                                     $spec_pri = $product->decode_spec->specifications[0]->specifications->primary;
                                                    echo "<div class='font-weight-bold'>".$spec_pri->specification_name.": ".$spec_pri->spec_value."</div>";
                                                 } 
                                                 if(!empty($product->decode_spec->specifications[0]->specifications->secondary[0]->specification_name)){
                                                     $spec_sec = $product->decode_spec->specifications[0]->specifications->secondary;
                                                     echo "<div class='font-weight-bold'>".$spec_sec[0]->specification_name.": ".$spec_sec[0]->spec_value."</div>";
                                                 }
                                                ?> 
                                                <div>Status: <?php echo $product->order_status; ?> </div>                                                
                                                <div class="loc">
						</div>
					</div>
                                    </a>	
                            </li>
			<?php endforeach; ?>
                    <?php } ?>
		</ul>
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

