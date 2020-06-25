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
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/mobile/css/bootstrap.min.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/mobile/css/font-awesome.min.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/mobile/css/ionicons.min.css">	
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/mobile/css/main.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/mobile/css/slide.css">
        
        <style>
            .btn-color{
                background-color: #bd081b;
                color: #fff;
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
    <body>
    <ai-header>
        <div class="header-container" style="position: fixed;">
            <div class="header-wrap" ab-test-bucket="">
                <div class="inner ripple rtl-icon">	
                    <a href="<?php echo site_url(); ?>">  <i class="icon ion-android-arrow-back"></i></a> 
                </div>
                <div class="master">
                    <div class="title">
                        <title>My Orders </title>
                    </div>
                </div>
            </div>
        </div>
    </ai-header>

    <div id="page" class="content">
        <input name="_csrf_token_" type="hidden" value="ikvgjtjh6mdo">
        <div class="j_favorite">
            <?php echo $this->session->flashdata('message'); ?>
            <div class="loading" style="display: none;"></div>
            <ul class="items">
                <?php if (!empty($user_orders)) { ?>
                    <?php foreach ($user_orders as $product): ?>
                        
                        <li><a class="it flex " href="<?php echo site_url(); ?>product/productOverview/<?php echo $product->product_id; ?>">
                                <div class="photo" style="width:100px;height:100px;">
                                    <img style="width:100px;height:100px;" src="<?php echo $product->product_image; ?>">
                                </div>
                                <div class="info flex-1">
                                    <h5 class=""><small><?php echo "#ORD".$product->orders_id; ?></small></h5>
                                    <div><p class="p-0 m-0"><strong>Seller: <?php echo $product->company_name; ?></strong></p></div>
                                    <div><h5><small><i class="fa fa-inr"></i> <?php echo $product->grand_price; ?> </small></h6></div>                        			
                                    <div><p class="p-0 m-0">Status: <?php echo $product->order_status ; ?></p> </div>
                                    <div><b>Date : <?php echo date("d-M-Y h:m:i",strtotime($product->created_on)); ?></b></div> 
                                    <div class="loc">
                                    </div>
                                </div>
                            </a>                            
                            <div class="text-center" style="margin: 10px 0px 0 0;">
                            
                            <a href="<?php echo base_url();?>trackorder/getOrderProductDetails/<?php echo $product->orders_id; ?>" class="btn-warning btn py-0 px-2"><small>View Details</small></a>
                            
                            <?php $arr = array(9, 10, 16, 18, 19, 22, 26);
                                if(in_array($product->OSid, $arr)) {?>
                                <a href="<?php echo base_url();?>myorders/trackorder/<?php echo $product->orders_id; ?>" class="btn-warning btn py-0 px-2"><small>Track Order</small></a>
                                <a href="<?php echo base_url();?>orders/<?php echo $product->orders_id; ?>" class="btn-danger btn py-0 px-2"><small>Cancel Order</small></a>
                            <?php } ?>
                            
                            <?php if(strtolower($product->order_status) == 'pending') {?>
                                <a href="<?php echo base_url();?>product/ship_cart_product/<?php echo $product->orders_id; ?>" class="btn-success btn py-0 px-2"><small>Make Payment</small></a>
                                <a href="javascript:void(0)" data-id="<?php echo $product->orders_id; ?>" class="btn-danger btn py-0 px-2 del_order"><small>Remove Order</small></a>
                            <?php } ?>

                            <?php
                            if($product->OSid==4)
                            {
                            ?>
                             <a href="<?php echo base_url();?>home/help_desk/<?php echo $product->orders_id; ?>" class="btn-danger btn py-0 px-2"><small>Help Desk</small></a>
                            <?php } ?>
                            </div>
                            <div class="clearfix"></div>
                        </li>
                    <?php endforeach; ?>

                <?php } else { ?>
                    <div class="text-white text-left mt-2 p-2" style="background:#FF9751!important; box-shadow: 0 5px 11px 0 rgba(0,0,0,.18), 0 4px 15px 0 rgba(0,0,0,.15);">
                        <small class="title"> No Product in My Orders </small>
                    </div>
                <?php } ?>
            </ul>
        </div>
    </div>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/mobile/js/jquery-3.2.1.min.js"></script>
    <script src="<?php echo base_url();?>assets/mobile/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/mobile/js/bootbox.min.js"></script>
    <script>
        
        $(".del_order").on("click",function(){
                var order_id = $(this).data("id");
                bootbox.confirm({
                    message: "Do You Want To Remove Product From Order?",
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
                                url: "<?php echo site_url(); ?>m/orders/remove_order",
                                method: "POST",
                                data: {"order_id": order_id},
                                success: function (data)
                                {
                                   location.reload();
                                }
                            });  
                        }
                    }
                }); 
            });
            
            $(function() {
                $('.alert').delay(5000).fadeOut('slow');
            });
    </script>
   
</body>
</html>
