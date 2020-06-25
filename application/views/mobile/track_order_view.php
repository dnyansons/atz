<!DOCTYPE html>
<html>
    <head>
        <title></title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="google-site-verification" content="nP5Df-TYNWX_nGB7Qum5d5I4cXzd3E7A2TXtZ0Y2x_Q" /> 
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
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
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/mobile/css/ionicons.min.css">	
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/mobile/css/slide.css">
        <style>
            body{
                font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji";
            }
            .order_id{
                padding: 23px 23px 5px 23px;

            }
            .order{
                margin-top: 20px;
            }
            .price{
                display: flex;
            }
            hr{
                margin-top: 5px;
            }
            .wrapper {

                font-size: 14px;

            }
            .StepProgress {
                position: relative;
                padding-left: 52px;
                list-style: none;
            }
            .StepProgress::before {
                display: inline-block;
                content: "";
                position: absolute;
                top: 0;
                left: 22px;
                width: 10px;
                height: 100%;
                border-left: 2px solid #ccc;
            }
            .StepProgress-item {
                position: relative;
                counter-increment: list;
            }
            .StepProgress-item:not(:last-child) {
                padding-bottom: 20px;
            }
            .StepProgress-item::before {
                display: inline-block;
                content: "";
                position: absolute;
                left: -30px;
                height: 100%;
                width: 10px;
            }
            .StepProgress-item::after {
                content: "";
                display: inline-block;
                position: absolute;
                top: 0;
                left: -41px;
                width: 24px;
                height: 24px;
                border: 2px solid #ccc;
                border-radius: 50%;
                background-color: #fff;
            }
            .StepProgress-item.is-done::before {
                border-left: 2px solid #bd081b;
            }
            .StepProgress-item.is-done::after {
                content: "✔";
                font-size: 12px;
                color: #fff;
                text-align: center;
                border: 2px solid #bd081b;
                background-color: #bd081b;
            }
            .StepProgress-item.current::before {
                border-left: 2px solid #bd081b;
            }
            .StepProgress-item.current::after {
                content: counter(list);
                width: 24px;
                height: 24px;
                top: 0px;
                left: -41px;
                font-size: 14px;
                text-align: center;
                color: #bd081b;
                border: 2px solid #bd081b;
                background-color: white;
            }
            .StepProgress strong {
                display: block;
            }
            .track{
                text-align: center;
                padding: 10px 0px;
                font-weight: 700;
                font-size: 15px;
            }
            .tracking{
                background-color: #fff;
            }
            .product_img img{
                width: 50px;
            }
            .solid{
                font-weight: 700;
                font-size: 14px;
            }

            .quantity p{
                margin-top: 6px;
                padding: 3px 0px;
                border: 1px solid #00000054;
                margin-bottom: 0px !important;
            }

        </style>

    </head>
    <body>
    <ai-header>
        <div class="header-container" style="position: fixed;">
            <div class="header-wrap" ab-test-bucket="">
                <div class="inner ripple rtl-icon">	
                    <a href="<?php echo $_SERVER['HTTP_REFERER']; ?>"  <i class="icon ion-android-arrow-back"></i></a> 
                </div>
                <div class="master">
                    <div class="title">
                        <title>Track Order</title>
                    </div>
                </div>
            </div>
        </div>
    </ai-header>

    <div class="container">
        <div class="row">
            <div class="order_id">
                <span>Order Id: </span>
                <span><b> #ORD<?php echo $order_detail['orders_id']; ?></b></span>
            </div>
        </div>
        <hr>
        <div class="row order " >
            <div class="col-xs-8">
                <p class="solid"></p>
                <div>
                    <div class="">
                        <span class="solid">Seller: </span>
                        <span class=""><?php echo $order_detail['company_name']; ?></span>
                    </div>
                </div>
                <div class="">
                    <div class="">
                        <div class="price">
                            <div class="solid">₹ <?php echo $order_detail['grand_price']; ?></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xs-4 product_img text-center">
                <div class="img-responsive">
                    <img src="<?php echo $order_detail['product_image']; ?>">
                </div>
                <div class="quantity">
                    <p>Quantity: <?php echo $total_quantity; ?></p>
                </div>
            </div>
        </div>
        <hr>
        <div class="row tracking">
            <div class="wrapper">
                <ul class="StepProgress">
                    <?php foreach ($hist_dat as $hist): ?>
                        <li class="StepProgress-item is-done"><strong><?php echo $hist->status; ?></strong>
                            <p><?php echo $hist->comment; ?></p>
                            <p><?php echo $hist->date_added; ?></p>
                        </li>
                    <?php endforeach; ?>
                        <li class="StepProgress-item">
                        </li>
                </ul>
                <br/>
                <div>
                    <small style="margin-left:14px"><strong>Expected Shipping Date: <?php echo date("d M Y",strtotime($order_detail['shipping_expected_date']));  ?>.</strong></small>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
