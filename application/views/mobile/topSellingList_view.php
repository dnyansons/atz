<html os-type="unknow">
    <head>
        <title>
            <?php echo "Top Selling Product | Atzcart";?>
        </title>
        <meta charset="utf-8">
        <meta name="aplus-rate-ahot" content="0.001">
        <meta name="aplus-rate-ahot-res" content="0.001">
        <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no">
        <meta name="google-site-verification" content="nP5Df-TYNWX_nGB7Qum5d5I4cXzd3E7A2TXtZ0Y2x_Q" /> 
        <!-- tangram:128 end-->
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/mobile/mobile/pro-g.css"  type="text/css" media="all">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/mobile/css/ionicons.min.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/mobile/mobile/product-gallary.css"  type="text/css" media="all">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/mobile/css/font-awesome.min.css">
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
            ai-header .header-wrap .inner.logo
            {
                height: 40px;
                width: 100%;
                padding: 0 5px;
            }
            ai-header .header-wrap>*, .ai-header .header-wrap>*, .ai-header-pwa .header-wrap>* {
                width: 48px;
                height:auto;
                line-height: 52px;
            }
            .ajax-load{
                    background: #e1e1e1;
		    padding: 10px 0px;
		    width: 100%;
  		}
        </style>
    </head>
    <body data-spm="7843667">
    <ai-header>
        <div class="header-container" style="position: fixed;">
            <div class="header-wrap" ab-test-bucket="0">
                <div class="inner ripple rtl-icon" clickevent="back">
                    <a href="<?php echo base_url(); ?>" class="back-btn">
                      <i class="icon ion-android-arrow-back"></i> </div>
                </a>
                <div class="master " clickevent="master" style="width:100%;">
                    <div class="master-search">
                        <div class="search-bar flex ripple" clickevent="search" id="search_list">
                            <div class="text">Top Selling Products</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </ai-header>
    <div class="page-wrapper">
        <div id="page" class="main-list" data-page-id="searchweb-list" data-is-premium="" data-is-affiliate="" data-appck=""
             data-p4p-count="15" data-res-opt="true">
            <div version="2.0.0" tag-placeholder="ai-zero" style-ready="true">
            </div>
            <div view-type="gallery" class="list-refine" style-ready-trigger="" version="1.0.0" search-text="" cate-name=""
                 result-num="" surl="" url="">
                <div class="section-title">
                    <div class="search-result-title">
                        <span id="search-count">Showing</span>
                        <h1><b> Top 10 Selling </b></h1>
                        products below
                    </div>
                    <div class="view-wrapper">
                        <a id="btn-list-view" class="btn-switch-view show " rel="nofollow" href="javascript:;">
                            <span class="fa fa-th-large"></span>
                        </a>
                        <a id="btn-gallery-view" class="btn-switch-view hide" href="javascript:;">
                            <span class="fa fa-th-list"></span>
                        </a>
                    </div>
                </div>
            </div>
            <div id="forbidden-notice" version="1.0.0" tag-placeholder="ai-remind" style-ready="true">
            </div>
            <div version="1.0.0" tag-placeholder="ai-qrw" style-ready="true">
            </div>
            <div id="ai-product-list" class="gallery">
                <!-- start HEre-->
                <?php if(!empty($productlists)){ 
                        foreach($productlists as $product){
                ?>
                    <div class="product-item ripple grid-item" id="product-60817434128">
                    <a class="product-detail" rel="nofollow"
                       href="<?php echo base_url(); ?>product/productOverview/<?php echo $product['id']; ?>">
                        <div class="image-wrap" style="height: 143px; width: 143px;">
                            <img alt="<?php echo $product['name']; ?>"
                                 src="<?php echo $product['url']; ?>"
                                 style="max-height: 143px; max-width: 143px;">
                        </div>
                        <div class="product-info-wrap">
                            <h3 class="product-title ">
                                <strong><?php echo $product['name']; ?></strong> 
                            </h3>
                            <div class="product-moq" > 
                                <strong style="color:#000;">
                                    <?php

                                      if($product['offer_status']=="Active"){
                                        echo "<i class='fa fa-inr'></i> " . number_format($product['max_final_price'],2);
                                        if ($product['mrp'] != 0 && $product['mrp'] != $product['max_final_price']) {
                                            echo " - <del> <i class='fa fa-inr'></i> " . $product['mrp'] . "</del>";
                                            echo " <br> <strong><span style='font-size:14px;color:green'>" . $product['discount'] . "</span></strong>";
                                        } 
                                      }else{
                                            echo "<i class='fa fa-inr'></i> " . number_format($product['max_final_price'],2);
                                            if ($product['mrp'] != 0 && $product['mrp'] != $product['max_final_price']) {
                                                echo " - <del> <i class='fa fa-inr'></i> " . $product['mrp'] . "</del>";
                                                echo " <br> <strong><span style='font-size:14px;color:green'>" . $product['discount'] . "</span></strong>";
                                            } 
                                      }
                                    ?>
                                </strong>
                            </div>
                            <div class="product-price product-fob-wrap">

                            </div>
                            <div class="bicon-wrap">
                                <div class=""> 
                                    <strong style="color:#000;">
                                        <i class="fa fa-inr"></i>
                                        <?php
                                         if($product['offer_status']=="Active"){
                                            echo $product['max_final_price'];
                                            if ($product['mrp'] != 0 && $product['mrp'] != $product['max_final_price']) {
                                                echo " - <del> <i class='fa fa-inr'></i> " . $product['mrp'] . "</del><br>";
                                                echo " <strong><span style='font-size:14px;color:green'>" . $product['discount'] . "</span></strong>";
                                            }
                                         }else{
                                             echo $product['max_final_price'];
                                             if ($product['mrp'] != 0 && $product['mrp'] != $product['max_final_price']) {
                                                echo " - <del> <i class='fa fa-inr'></i> " . $product['mrp'] . "</del><br>";
                                                echo " <strong><span style='font-size:14px;color:green'>" . $product['discount'] . "</span></strong>";
                                            }
                                         }
                                        ?>
                                    </strong>
                                </div>
                                <i class="list-icons list-icon-ta"></i>
                                <div class="gs-year-wrapper">
                                    <i class="list-icons list-icon-gs"></i>
                                    <div class="year-num"><?php echo date('Y') - $registers['year_of_register']; ?></div>
                                </div>
                                <img src="<?php echo base_url() . "assets/images/flags/png/in.png"; ?>" alt="" class="icon-country">
                                <span class="country-name"><?php echo $country['name']; ?></span>
                            </div>
                        </div>
                    </a>
                    <div class="product-p4p ripple" >
                    </div>
                    <div class="list-product-p4p-wrap" data-count="1">
                        Sponsored Listing
                    </div>
                    <div class="contact-container">
                    </div>
                </div>                      
                <?php } }else{
                        
                        echo '<div class="alert-warning">
                        Oops! No products found.
                        </div>';
                    }
                ?>
                <!-- End Here -->
            </div>
        </div>
    </div>
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script>   
        $(document).ready(function(){
            $("#btn-detail-seo").click(function () {
                  $(".section-body").toggleClass("all");
              });
              $("#btn-list-view, #btn-gallery-view").click(function () {
                  $(".btn-switch-view").toggleClass("hide show");
                  $("#ai-product-list").toggleClass("gallery list");

                  $(".contact-wrap").toggleClass("active");
                  if ($(".contact-wrap").hasClass("active")) {
                      $(".contact-wrap").text("CONTACT SUPPLIER");
                  } else {
                      $(".contact-wrap").text("CONTACT");
                  }
              });
              $("#search_list").click(function () {
                  $("#headersearch").show();
              });
       })
    </script>
    
</body>
</html>

