<?php
//$coupon_id = $this->input->post("coupon");
?>
<html os-type="unknow">
    <head>
        <title></title>
        <meta charset="utf-8">
        <meta name="aplus-rate-ahot" content="0.001">
        <meta name="aplus-rate-ahot-res" content="0.001">
        <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no">
        <!-- tangram:128 end-->
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/mobile/mobile/pro-g.css"  type="text/css" media="all">
		<link rel="stylesheet" href="<?php echo base_url(); ?>assets/mobile/css/ionicons.min.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/mobile/mobile/product-gallary.css"  type="text/css" media="all">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/mobile/css/font-awesome.min.css">
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
        </style>
    </head>
    <body data-spm="7843667">
    <ai-header>
        <div class="header-container" style="position: fixed;">
            <div class="header-wrap" ab-test-bucket="0">
                <div class="inner ripple rtl-icon" clickevent="back">
                    <a href="<?php echo base_url(); ?>home" class="back-btn">
                      <i class="icon ion-android-arrow-back"></i> </div>
                </a>
                <div class="master " clickevent="master" style="width:100%;">
                    <div class="master-search">
                        <div class="search-bar flex ripple" clickevent="search" id="search_list">
                            <div class="text"><?php echo $category_name['categories_name']; ?></div>
                            
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
                        <span id="search-count"><?php echo $prod_count; ?></span>
                        <h1><?php echo $category_name['categories_name']; ?></h1>
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
                <?php if(empty($productlists)){ ?>
                <div class="alert-warning">
                    Oops! No products found.
                </div>
                <?php } ?>
                <?php foreach ($productlists as $product): ?>
                    <div class="product-item ripple grid-item" id="product-60817434128">
                        <a class="product-detail" rel="nofollow"
                           href="<?php echo base_url(); ?>product/productOverview/<?php echo $product['product_id']; ?>">
                            <div class="image-wrap" style="height: 143px; width: 143px;">
                                <img alt="<?php echo $product['product_name']; ?>"
                                     src="<?php echo $product['media_url']; ?>"
                                     style="max-height: 143px; max-width: 143px;">
                            </div>
                            <div class="product-info-wrap">
                                <h3 class="product-title ">
                                    <!-- tangram:2993 begin-->         
                                    <!-- tangram:2993 end-->
                                    <strong><?php echo $product['product_name']; ?></strong> 
                                </h3>
                                <div class="product-moq">
                                    MOQ: <?php echo $product['moq']; ?>
                                </div>
                                <div class="product-price product-fob-wrap">
                                    INR <?php echo $product['price2']; ?>-<?php echo $product['price1']; ?>
                                    <span>/<?php echo $product['units_name']; ?></span>
                                </div>
                                <div class="bicon-wrap">
                                    <i class="list-icons list-icon-ta"></i>
                                    <div class="gs-year-wrapper">
                                        <i class="list-icons list-icon-gs"></i>
                                        <div class="year-num"><?php echo date('Y') - $registers['year_of_register']; ?></div>
                                    </div>
                                    <img src="<?php echo base_url() . "assets/images/flags/png/" . strtolower($country['iso']) . ".png"; ?>" alt="" class="icon-country">
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
                            <!-- <a rel="nofollow" class="contact-wrap ripple"  href="<?php //echo $product['seller_id']; ?>">
                                CONTACT </a> -->
				<a rel="nofollow" class="contact-wrap ripple"  href="<?php echo base_url(); ?>product/send_enquiry/<?php echo $product['product_id'];?>">
                                CONTACT </a> 
                        </div>
                    </div>
                <?php endforeach; ?>
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

