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
                        <a href="<?php echo site_url(); ?>">  <i class="icon ion-android-arrow-back"></i></a> 
                </div>
                <div class="master">
                    <div class="title">
                        <div class="title-placeholder">
                                <!--padding-->
                        </div>
                        <title>My Favorites</title>
                    </div>
                </div>
            </div>
	</div>
</ai-header>

<div id="page" class="content">
	<input name="_csrf_token_" type="hidden" value="ikvgjtjh6mdo">
        <div class="fav_msg text-success p-2 ml-4">
            
        </div>
	<div class="j_favorite">
		<div class="loading" style="display: none;"></div>
		<ul class="items">
                        <?php if(!empty($products)){ ?>
                            <?php foreach($products as $product): ?>
                            <li><a class="it flex" href="<?php echo site_url();?>product/productOverview/<?php echo $product['product_id']; ?>">
                                            <div class="photo" style="width:100px;height:100px;">
                                                    <img style="width:100px;height:100px;" src="<?php echo $product['url']; ?>">
                                            </div>
                                            <div class="info flex-1">
                                                    <div class="title"><?php echo $product['name']; ?></div>
                                                    <div>Min Order: <?php echo $product['quantity_from']; ?></div>
                                                    <div>Price:  <i class="fa fa-inr"></i> <?php echo $product['final_price']; ?></div>
                                                    <div class="loc">
                                                    </div>
                                            </div>
                                    </a>
                                    <button class="col-5 offset-5 btn-danger btn py-0 px-2 delf1" data-id="<?php echo $product['product_id']; ?>" ><small>Remove product</small></button>
                            </li>
                            <?php endforeach; ?>
                        <?php } else {?>
                          							
                                <div class="text-white text-left mt-2 p-2 alert-warning" style="background:#FF9751!important;    box-shadow: 0 5px 11px 0 rgba(0,0,0,.18), 0 4px 15px 0 rgba(0,0,0,.15);">
                                    <small class="title">Oops! No Favorite Products </small>
                                </div>
                        <?php } ?>
		</ul>
	</div>
</div>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/mobile/js/jquery-3.2.1.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/mobile/js/bootbox.min.js"></script>
<script>
    $(".delf1").on("click",function(){
                var product_id = $(this).data("id");
                bootbox.confirm({
                    message: "Do You Want to Remove Product From My Favourite?",
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
                                    url: "<?php echo site_url(); ?>product/remove_favourite_product",
                                    method: "POST",
                                    data: {"product_id": product_id},
                                    success: function (data)
                                    { 
                                        $(".fav_msg").text(data);
                                        setTimeout(function() {
                                            $(".fav_msg").delay(800).fadeOut(1000);
                                            $(".fav_msg").fadeOut(function(){
                                                location.reload(true);
                                            });
                                        });
                                    }
                            })  
                        }
                    }
                }); 
            });  
            
</script>
</body>
</html>