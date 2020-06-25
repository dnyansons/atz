<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1, minimum-scale=1, user-scalable=no">
        <meta name="google-site-verification" content="nP5Df-TYNWX_nGB7Qum5d5I4cXzd3E7A2TXtZ0Y2x_Q" />
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/mobile/css/bootstrap.min.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/mobile/css/ionicons.min.css"> 
        
        <title>Seller Company Details</title>   
        <style>
            html {
                height: 100%;
                font-size: 32px;
            }

            body {
                height: 100%;
                display: -webkit-box;
                display: -webkit-flex;
                display: flex;
                margin: 0;
                -webkit-font-smoothing: antialiased;
                font-smoothing: antialiased;
                -webkit-text-size-adjust: none;
                text-size-adjust: none;
                -webkit-tap-highlight-color: rgba(0, 0, 0, 0);
                -webkit-user-select: none;
                user-select: none;
                font-family: "Helvetica Neue",Helvetica,Roboto,Arial,"Lucida Grande",sans-serif;
                text-rendering: auto;
                -webkit-backface-visibility: hidden;
                -webkit-user-drag: none;
                color: rgb(51, 51, 51);
                background: rgb(255, 255, 255);
                word-wrap: break-word;		
            }

            a, a:active, a:hover {
                text-decoration: none;
            }

            span{
                word-break: break-word;
            }
            .one
            {
                border: 0px solid black; position: relative; box-sizing: border-box; display: flex; -webkit-box-orient: vertical; flex-direction: column; place-content: flex-start space-between; flex-shrink: 0; cursor: pointer; overflow: hidden; height: 46.9333px; padding-top: 6.82667px; -webkit-box-align: center; align-items: center; -webkit-box-pack: justify; width: 80px;
            }
            .one span
            {
                white-space: pre-wrap; border: 0px solid black; position: relative; box-sizing: border-box; display: -webkit-box; -webkit-box-orient: vertical; flex-direction: column; align-content: flex-start; flex: 0 0 auto; font-size: 10.24px; font-weight:600; margin-top: 15px; line-height: 10.24px; word-break: break-word; text-align: center; color: rgb(255, 255, 255); transform: scale(1.1) translateY(-3.41333px); -webkit-line-clamp: 2; overflow: hidden; 
            }
            .comp1
            {
                border: 0px solid black; position: relative; box-sizing: border-box; display: flex; -webkit-box-orient: horizontal; flex-direction: row; align-content: flex-start; flex-shrink: 0; width: 100%; height: 47.7867px; -webkit-box-align: center; align-items: center; background-image: linear-gradient(to right bottom, rgb(255, 139, 61), rgb(255, 106, 0)); padding-top: 6.82667px; padding-bottom: 6.82667px;
            }
            .comp2{
                border: 0px solid black; position: relative; box-sizing: border-box; display: flex; -webkit-box-orient: vertical; flex-direction: column; place-content: flex-start center; flex-shrink: 0; cursor: pointer; width: 39.2533px; height: 25.6px; -webkit-box-align: center; align-items: center; -webkit-box-pack: center;
            }

            nav ul li{
                list-style:none;
                float:left;
                padding-right:20px;
            }
            nav ul li a{
                text-decoration:none;
                color:#222;
                font-size:12px;

            }
            .active{
                color:#fff !important;		
            } 
            .breadcrumb-item{font-size:14px;}
            .breadcrumb{padding:7px; margin-bottom:10px;}
            .st{font-size:12px; color:#a09f9f; width:120px;}
            .stm{font-size:14px; color:#000; padding-left:5px;}
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
        <script src="<?php echo base_url(); ?>assets/mobile/mobile/suppler.js" crossorigin=""></script>

	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/mobile/css/font-awesome.min.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/mobile/css/ionicons.min.css">

    </head>

    <body data-spm="main" style="background-color: rgb(244, 244, 244); -webkit-tap-highlight-color: transparent;">

        <div role="minimalUI-layout">

            <div style="border: 0px solid black; position: absolute; box-sizing: border-box; display: flex; -webkit-box-orient: vertical; flex-direction: column; align-content: flex-start; flex-shrink: 0; top: 0px; z-index: 999; opacity: 1; width:100%">
                <!-- empty -->
                <!-- Header -->
                <div class="comp1">
                    <div  class="comp2">
                        <a href="<?php echo site_url().$this->session->userdata("prev_page"); ?>"><img src="<?php echo base_url(); ?>assets/mobile/images/arrow_left.png"
                                                                          style="display: flex; width: 13.6533px; height: 13.6533px;"></a>
                    </div>
                    <div style="border: 0px solid black; position: relative; box-sizing: border-box; display: flex; -webkit-box-orient: horizontal; flex-direction: row; place-content: flex-start center; flex: 1 1 0%; -webkit-box-align: center; align-items: center; -webkit-box-pack: center; -webkit-box-flex: 1; background-color: rgb(255, 255, 255); border-radius: 4.26667px; height: 34.1333px; font-size: 14px;">
                            <?php echo $sellercomp['company_name']; ?>
                    </div>
                    <div
                        style="border: 0px solid black; position: relative; box-sizing: border-box; display: flex; -webkit-box-orient: vertical; flex-direction: column; place-content: flex-start center; flex-shrink: 0; cursor: pointer; width: 39.2533px; height: 25.6px; -webkit-box-align: center; align-items: center; -webkit-box-pack: center;">
                        <a href="<?php echo base_url(); ?>m/supplier/product_categories">
                        </a></div>
                </div>

                <nav class="navecation" style="background:#ff7412">
                    <ul id="navi">
                        <li> 
                            <a href="<?php echo base_url(); ?>supplier/<?php echo $this->session->userdata('seller_id'); ?>"  class="" data-target="#quizzes"> 
                                HOME</a>  
                        </li>
                        <li>
                            <a href="<?php echo base_url(); ?>supplier/supplier_products/<?php echo $this->session->userdata('seller_id'); ?>"  class="" data-target="#categories">
                                PRODUCTS
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo base_url(); ?>supplier/supplier_profile/<?php echo $this->session->userdata('seller_id'); ?>"  class="" data-target="#jump">
                                PROFILE
                            </a>   
                        </li>

                    </ul>
                </nav>			

                <!-- End Menu-->
            </div>

