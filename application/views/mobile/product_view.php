<html>
    <head>
        <meta content="text/html; charset=utf-8" http-equiv="Content-Type">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1, user-scalable=no">
        <meta name="data-spm" content="a2706">
        <meta name="google-site-verification" content="nP5Df-TYNWX_nGB7Qum5d5I4cXzd3E7A2TXtZ0Y2x_Q" /> 
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/mobile/css/ionicons.min.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/mobile/mobile/normal-mobile.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/mobile/css/swiper.min.css">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">        
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/mobile/css/font-awesome.min.css">
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
        <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/mobile/css/productOverview.css">
        <title>Product Overview</title>
        <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.css" media="screen">
        
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
		

            #demo {
                height:100%;
                position:relative;
                overflow:hidden;
            }
            .green{
                background-color:#6fb936;
            }
            .thumb{
                margin-bottom:0px;
            }
            .page-top{
                margin-top:85px;
            }
            img.zoom {
                width: 100%;
				height: auto;
                max-height: 100%;			
                border-radius:5px;
                -webkit-transition: all .3s ease-in-out;
                -moz-transition: all .3s ease-in-out;
                -o-transition: all .3s ease-in-out;
                -ms-transition: all .3s ease-in-out;
            }
            .transition {
                -webkit-transform: scale(1.2); 
                -moz-transform: scale(1.2);
                -o-transform: scale(1.2);
                transform: scale(1.2);
            }
            .modal-header {

                border-bottom: none;
            }
            .modal-title {
                color:#000;
            }
            .modal-footer{
                display:none;  
            }
            .swiper-slide
            {
                    padding:10px;
            }
            .swiper-pagination-bullet{display:none!important}
            .swiper-wrapper{height:max-content;}
            .bootbox-close-button{float: right;}
            #notify_buyer{
                background-color: #bd081b !important;
                border:0px !important;
            }
/*            input {
                outline: 0;
                border-width: 0 0 2px;
                border-color: blue
              }
              input:focus {
                border-color: green
              }*/
			  .md-form {
    position: relative;
}

input[type="text"] {
    background-color: transparent;
    border: none;
    border-bottom: 2px solid #bdbdbd;
    border-radius: 0;
    outline: 0;
    height: 2.5rem;    
    font-size: 1.5rem;
	font-weight:700;
    box-shadow: none;
    box-sizing: content-box;
    -webkit-transition: all .3s;
    transition: all .3s;
}
.form-control:focus {
    color: #495057;
    background-color: #fff;
    border-color:none !important;
    outline: 0;
    box-shadow:none;
}
		  
        </style>
    </head>
    <body>
        <div data-comp-name="header" class="">
            <div class="header-wrap">
                <div>
                    <div class="fixed-panel" style="width: 100%; height: 0px; left: 0px; top: 0px; opacity: 1;">
                        <div class="site-header search-bar-hidden">
                            <div class="main-header">
                                <a class="header-item btn-back" href="<?php echo site_url();?>">
                                    <i class="iconfont-back"></i>
                                </a>
                                <span class="header-item title">Overview</span>
<!--                                <a class="header-item btn-search" id="search_k">
                                    <i class="iconfont-search"></i>
                                </a>-->
                                <a class="header-item btn-fav add-favourite" data-product-id="<?php echo $productinfos['id']; ?>">
                                    <i class="icon ion-ios-heart" id="heart" style="color:<?php echo (!empty($isColor)) ? $isColor : ""; ?>"></i>
                                </a>
                                <a class="header-item btn-more"  href="<?php echo site_url(); ?>home/mycart">
                                    <i class=" icon ion-android-cart"></i>

                                    <span class="" style="background:#bd081b; padding:0px 3px; color:#fff; font-size:10px; border-radius:10px; position:absolute; top:0; right:5px"><?php echo $cart_count; ?></span>
                                </a>
                            </div>
                            <span data-placeholder="after__main-header"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="banner">
            <div class="swiper-container">
                <div class="swiper-wrapper">
                    <?php foreach ($productinfos['images'] as $img) { ?>	
                        <div class="swiper-slide thumb pb-0" id="imageIphone">
                            <a href="<?php echo $img ?>" class="fancybox" rel="ligthbox">
                             <img src="<?php echo $img ?>" width="100%" height="100%" class="zoom img-fluid ">
                            </a>
                        </div>
                    <?php } ?>
                </div>
                <div class="swiper-pagination"></div>
            </div>
        </div>
        <div class="product-basic-info module-shadow-bottom">
            <div class="product-ship-wrap">              
                 <?php if(strtolower($productinfos['offer_status']) == 'active') 
                    {
                       $offer_end_datetime = $productinfos['valid_to'].' '.$productinfos['time_to'];
                       $offerStatus = $productinfos['offer_status'];
                       echo '<div class="row pl-3" style="background:url('.base_url().'assets/front/images/banner/offer_back.jpg)no-repeat top center ; background-size:cover;"><div class="col-3"><img src='.base_url().'assets/mobile/images/special-offer.png class="img-fluid"></div> <div class="col-7 justify-content-center align-self-center"><h2 class="py-auto text-danger font-weight-bold"  id="offer_timer"></h2></div> <div class="col-2"></div> </div>';
                    }
                 ?>
            </div>
            <div class="product-title">
                <h1><?php echo $productinfos['name']; ?></h1>
            </div>
            <div class="product-price">
                <div class="product-price-ladder-group">
                    <?php foreach ($productinfos['product_prices'] as $prodprice): ?>
                        <div class="product-price-item product-price-item-ladder3">
                            <div class="product-price-ladder">
                                <div>
                                    <div class="price-ladder"><i class="fa fa-inr"></i>
                                        <?php echo number_format($prodprice->final_price,2); ?> 
                                    </div>
                                    <?php if($productinfos['discount_percentage']!=0){?>
                                    <div class="price-ladder">
                                        <?php if(!empty($prodprice->mrp)){
                                            echo "<i class='fa fa-inr'></i> <del>".$prodprice->mrp."</del>";}
                                            else{echo "<i class='fa fa-inr'></i> <del>".$prodprice->atz_price."</del>";}
                                        ?> 
                                    </div>
                                    <div class="price-ladder text-success">
                                        <?php if(!empty($prodprice->mrp)){
                                                if($productinfos['offer_type']=='percentage'){   
                                                    echo $productinfos['offer_discount_value']."% OFF";
                                                }
                                                if($productinfos['offer_type']=='flat'){
                                                    echo "<i class='fa fa-inr'></i> ".$productinfos['offer_discount_value']." OFF";
                                                }
                                            }else{
                                                echo $productinfos['discount_percentage']."% OFF";
                                            }
                                        ?>
                                    </div>
                                    <?php } ?>
                                    <div class="ladder">
                                        <?php echo $prodprice->quantity_from; ?> - <?php echo $prodprice->quantity_upto; ?> <?php echo $prodprice->units_name; ?> 
                                    </div>
                                </div>
                            </div>
                            <span class="text-success"><small>(Expected Delivery In 3-5 Days)</small></span>
                        </div>
                        
                    <?php endforeach; ?>

                </div>
            </div>
            <div></div>
            <div class="product-sale-normal">
                <div >
                    <div class="product-sale-item">
                        <div class="name">
                            Min. Order
                        </div>
                        <div class="value">
                            <?php echo $productinfos['product_prices'][0]->quantity_from; ?>
                            <?php echo $productinfos['product_prices'][0]->units_name; ?>
                        </div>
                    </div>
                </div>
            </div>    
        </div>
        
        <div id="rfq-entry-container ">
            <div class="module-shadow py-5 col-12">
                <div class="row">
                    <div class="col-12 m-auto">
                        <div class="input-group">
                            <i class="fa fa-map-marker fa-2x" aria-hidden="true"></i>
                            <input id="pincode_check" type="text" class="form-control" name="Pincode_check" placeholder="Enter Delivery Pincode">
                            <button id="btn_check" name="btn_check" class="btn btn-danger btn-lg"><i class="fa fa-spinner fa-spin" style="font-size:14px; display:none"></i> Check Available </button>
                        </div>
                            <span class="pl-4" id="areacode"></span>	
                    </div>       
                </div>
            </div>
        </div>
        
        <a href="<?php echo site_url(); ?>supplier/<?php echo $productinfos['seller'] ?>" class="company-info-wrap module-shadow-top">
            <div class="company-header">
                Company Information
                <i class="iconfont-arrow-right company-header-icon"></i>
            </div>
            <div class="company-adress">
                <h2 class="line-1 company-title"><?php echo $productinfos['company_name']; ?></h2>
                <div class="line-1 company-adress-detail">
                    <img src="<?php echo $productinfos['country_flag']; ?>">
                    <span><?php echo $productinfos['address1']; ?></span>
                </div>
            </div>
            <br />
        </a>

        <div id="company-info-more-wrap" class="module-shadow-bottom">
            <div class="">
                <div class="company-info-more-wrap" onclick="" id="company-info-more">
                    <div class="company-info-more">
                        <span><b><?php echo date('Y') - $productinfos['year_of_register']; ?></b> Yrs &nbsp;&nbsp;&nbsp; </span>
                        <div class="line_1 company-info-more-icons">	
                            <img class="company-info-more-icon"  src="<?php echo base_url(); ?>assets/front/images/icons/artzcart.png"   alt="Trade">
                            <img class="company-info-more-icon"  src="<?php echo base_url(); ?>assets/front/images/icons/gold.png"alt="Gold">
                            <img class="company-info-more-icon"  src="<?php echo base_url(); ?>assets/front/images/icons/verified.png" alt="Check">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="quick-detail-container">
            <div class="">
                <div class="quick-detail module-shadow">
                    <div class="header">
                        <h2>Quick Details</h2>
                    </div>
                    <table class="prop-list">
                        <?php foreach ($productinfos['product_attributes'] as $pattr): ?>
                            <tr>
                                <td class="prop-name"><?php echo $pattr['attribute_name'] ?>:</td>
                                <td class="prop-value"><?php echo $pattr['attribute_value'] ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
            </div>
        </div>

        <div id="specifications">
            <div class="user-content-scale">
                <div class="user-content no-init super-text-description">
                    <div class="specifications-wrap richtext richtext-detail rich-text-description">
                        <div id="ali-anchor-AliPostDhMb-19f17" style="padding-top: 8.0px;">
                            <div id="ali-title-AliPostDhMb-19f17" style="padding: 8.0px 0;border-bottom: 1.0px solid #dddddd;"><span style="background-color: #dddddd;color: #333333;font-weight: bold;padding: 8.0px 10.0px;line-height: 12.0px;">Product Description</span></div>
                            <div style="padding: 10.0px 0;">
                                <p><?php echo $productinfos['description']; ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="rfq-entry-container">
            <a class="rfq-entry module-shadow"
               href="<?php echo base_url(); ?>rfq/rfq_product/<?php echo $productinfos['id']; ?>">
                <i
                    class="iconfont-rfq-fill"></i>
                <div class="rfq-content">
                    <div class="main-text"><span id="rfq-supplier-count"></span> suppliers now offering this product
                    </div>
                    <div class="sub-text">Request for Quotation</div>
                </div>
                <i class="iconfont-arrow-right"></i>
            </a>
        </div>

        <div id="recommend">
            <div>
                <div class="recommend-wrap">
                    <div class="recommend-header">Recommended Items</div>
                    <div class="recommend-container">
                        <?php 
                        
                        $cnt = count($prod_array);
                        if($cnt % 2 ==1){
                            unset($prod_array[$cnt-1]);
                        }
                        foreach ($prod_array as $recprod): ?>
                            <a class="recommend-item-wrap"
                               href="<?php echo site_url(); ?>product/productOverview/<?php echo $recprod["products_id"]; ?>">
                                <div class="recommend-item-img-wrap"><img class="lazyload recommend-item-img" src="<?php echo $recprod['products_image']; ?>">
                                </div>
                                <div class="recommend-item-info">
                                    <div class="line-2 recommend-item-title"><?php echo $recprod['products_name']; ?></div>
                                    <div class="recommend-item-price"><i class="fa fa-inr"></i>  <?php echo $recprod['products_price']; ?></div>
                                    <div class="recommend-item-num">
				<?php 
                                        if($recprod['mrp']!=0 && $recprod['mrp']!=$recprod['final_price']){
                                            echo " <i class='fa fa-inr'></i> <del>".$recprod['mrp']."</del>";
                                            echo "<strong><span class='text-success'>  ". $recprod['discount']."</span></strong>";
                                        }
				?>
                                    </div>
                                </div>
                            </a>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>

        
        <div id="bottom-actions" data-id="123">
            <div class="bottom-actions-wrap">
                <div class="bottom-actions-height-placeholder" style="height: 62px;"></div>
                <div class="bottom-actions">
                    <?php
                     if($productinfos["available_quantity"] <= $productinfos["low_stock_qty"]) {   ?>
                        <?php

                         if ($notify_status == 1) 
                         {
                            $class = "style = 'background-color:#ccc;border:1px solid #999;'";
                            $msg = "You have already subscribed for notification of this product!";
                        } else {
                            $class = "";
                            $msg = "";
                        }
                        ?>
                    
                        <div class=" bottom-actions-btns">
                           <!--btn-danger ui2-button ui2-button-primary ui2-button-large placeorder dot-app-pd ui-button-buy'--> 
                           <a href="javascript:void(0);" class='actionsBtn send_inquiry strong font-weight-bold' id="notify_buyer" <?php echo $class ?>
                            data-id="<?php echo $productinfos['id']; ?>">Notify Me
                            </a>&nbsp;
                        
                            <a href="javascript:void(0);" class="actionsBtn send_inquiry strong font-weight-bold" style="backgroud:#f1f1f1!important;">
                                Out Of Stock
                            </a>
                      
                    </div>
                    <?php } else { ?>
                    <div class="bottom-actions-btns">
                        <?php if ($productinfos['provide_order_at_buyer_place'] == 1) { ?>
                            <a href="javascript:void(0);" class="actionsBtn send_inquiry strong" id="addcart" data-id="<?php echo $productinfos['id']; ?>">Add Cart</a>
                        <?php } ?>
                        <a href="<?php echo base_url(); ?>product/send_enquiry/<?php echo $productinfos['id']; ?>" class="actionsBtn send_inquiry strong">Send Inquiry</a>
                        <?php if (!empty($productinfos['product_specification'][0])) { ?>
                            <a href="javascript:void(0);" id="modal22"  class="actionsBtn buy_now strong" >Start Order</a>
                        <?php } else { ?>
                            <a href="<?php echo site_url(); ?>product/start_order/<?php echo $productinfos['id']; ?>"  class="actionsBtn buy_now strong">Place Order</a>    
                        <?php } ?>
                    </div>
                    <?php } ?>
                </div>
            </div>
        </div>

        <div data-comp-name="fixed-tab">
            <div class="fixed-panel fixed-tab" style="width: 100%; height: 0px; left: 0px; top: 5rem; opacity: 1;">
                <div class="tab" id="tbid">
                    <div class="tab-item active"><a href="#banner">Overview</a></div>
                    <div class="tab-item"><a href="#specifications">Details</a></div>
                    <div class="tab-item "><a href="#rfq-entry-container">Recommended</a></div>
                </div>
            </div>
        </div>
        <div id="headersearch1" class="headersearch1" style="display:none">
            <div data-comp-name="header">
                <div class="header-wrap">
                    <div class="site-search site-search1" style="display: block;">
                        <div class="search-header">
                            <a href="<?php //echo $_SERVER['HTTP_REFERER'];  ?>" class="back-btn" >
                                <i class="icon ion-android-arrow-back"></i>
                            </a>
                            <!--<form class="form-wrap" method="post">-->
                            <input name="searchText" id="searchText" type="search"
                                   placeholder="What are you looking for�" autocorrect="off" autocomplete="off"
                                   autocapitalize="off" autofocus onkeypress="displayResult()"><a class="clear-btn"
                                   style="display: none;"><i class="iconfont-close"></i></a>
                            <!--</form>-->
                        </div>
                        <div class="search-content pagescroll" id="load_view">
                            <div class="history">
                                <div class="keywords-title">Search Result:  </div>
                                <div id="search_histroy"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <a class="search-bar"></a>
            </div>
        </div>

        <!-- Large Modal Popup Click Start Order-->
        <div class="modal modal-popup" id="myModal" style="z-index: 20000;">
            <div class="modal-popup-container" style="height:90%;">
                <!-- Modal Header -->
                <div class="modal-header p-0 px-3 py-2">                   
                    <button type="button" class="close" id="closeM" data-dismiss="modal" aria-label="Close"><i style="font-size:18px;" class="icon ion-android-close"></i></button>
                </div>
                <div class="modal-body">
                    <form action="<?php echo base_url(); ?>product/start_order/<?php echo $productinfos['id']; ?>" method="post" id="spec_form">
                        <div class="iframe-wrap" style="top:-6px">
                            <div id="app">
                                <div class="select-sku" style="background: rgb(255, 255, 255);">
                                    <div class="product-info-container">
                                        <div id="err" class="text-danger"></div>
                                        <div class="product-info-wrap py-0">
                                            <img class="product-info-img"
                                                 src="<?php echo $productinfos['images'][0]; ?>">
                                            <div class="product-info-content">
                                                <h3><?php echo $sellerinfos['company_name']; ?></h3>
                                                <h4 class="line-2 product-info-title"><?php echo $productinfos['name']; ?></h4>
                                                <p class="line-1 product-info-min-order">Min. Order: <?php echo $productinfos['product_prices'][0]->quantity_from; ?>
                                                    <?php echo $productinfos['product_prices'][0]->units_name; ?>
                                                </p>
<!--                                                <p class="line-1 product-info-price-wrap"><span class="product-info-price"><?php echo $productinfos['currency_name']; ?> <?php echo $productinfos['product_prices'][0]->final_price; ?> /
                                                <?php echo $productinfos['product_prices'][0]->units_name; ?>
                                                </p>-->
                                            </div>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="quantity-container-wrap mt-0">
                                        <h4 class="quantity-container-title">Quantity:</h4>
                                        <div class="quantity-container-items">
                                            <div class="select-num-wrap" style="width:120px;">
                                                <button class="select-num-btn desc-btn" type="button" name="minus" id="minus" onClick="quan(this.id)"> <i class="icon ion-android-remove"></i> </button>

                                                <input class="select-num-input" type="number" id="qty" value="<?php echo $productinfos['product_prices'][0]->quantity_from; ?>" onkeyup="quan(this.id)">

                                                <button class="select-num-btn plus-btn" type="button" name="plus" id="plus" onClick="quan(this.id)"> <i class="icon ion-android-add"></i> </button>

                                            </div>
                                            <span class="quantity-container-item-unit"><?php echo $productinfos['product_prices'][0]->units_name; ?></span>
                                        </div>
                                </div>
                                <div class="select-sku-container" style="position: absolute;
                                     overflow: scroll;top: 155px;right: 0;left: 0; bottom: -388px;">
                                    <div class="product-container-wrap"> 
                                        <?php foreach ($productinfos['product_specification'] as $value) { ?>
                                            <?php foreach ($value as $key => $spec) { ?>
                                                <div class="select-container-wrap">
                                                    <h4 class="select-container-title" ><?php echo $key . " :"; ?>
                                                        <span class="select-container-selected-name"></span>
                                                    </h4>
                                                    <?php foreach ($spec as $s) { ?>
                                                        <div class="select-item select-item-enable" >
                                                            <div class="chec-radio">
                                                                <li class="pz select-item-text">
                                                                    <label id="spec_value" class="radio-inline" data-id="<?php echo $s['spec_id']; ?> ">
                                                                        <input type="radio" name="<?php echo str_replace(' ', '', $s['specification_name']); ?>" id="<?php echo $s['spec_id']; ?>" value="<?php echo $s['spec_value']; ?>" id="pro-chx-residential" name="property_type" class="pro-chx" value="constructed" required>
                                                                        <div class="clab"> <span id="spec_value" data-id="<?php echo $s['spec_id']; ?> "><?php echo $s['spec_value']; ?></span></div>
                                                                    </label>
                                                                </li>
                                                            </div>

                                                        </div>
                                                    <?php } ?>           
                                                </div>
                                            <?php }
                                        }
                                        ?>
                                        <!-- Quantity Block Here-->
                                    </div>

                                </div>
                                <!--keep extra fields-->
                                <input class="moq" type="hidden" name="hidemoq" id="hidemoq" value="<?php echo $productinfos['product_prices'][0]->quantity_from; ?>">
                                <input class="unit" type="hidden" name="hideunit" id="hideunit" value="<?php echo $productinfos['product_prices'][0]->units_name; ?>">
                                <!--end keep extra fields-->
                                <input class="pro_id" type="hidden" name="hidepro_id" id="hidepro_id" value="<?php echo $productinfos['id']; ?>">       
                                <input class="spec_id" type="hidden" name="hidespec_id" id="hidespec_id">
                                <input class="spec_value" type="hidden" name="hidespec_value" id="hidespec_value" required="required">
                                <input class="quantity" type="hidden" name="hideqty_value"  id="hideqty_value">
                                <input type="hidden" name="hideunit_price" id="hideunit_price" value="<?php echo $prodprice->final_price; ?>"> <!--uncomment for shiprocket -->
                                <input type="hidden" name="hidespec_count" id="hidespec_count" value="<?php echo count($productinfos['product_specification'][0]); ?>"> 
                                <input type="hidden" name="hideoffer_id" id="hideoffer_id" value="<?php echo $productinfos['offer_id']; ?>"> 
                                <input type="hidden" name="flag" value="0"> 
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- End Large Modal Popup-->

        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/mobile/mobile/icon.css">
        <script src="<?php echo base_url(); ?>assets/mobile/mobile/common.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/mobile/js/jquery-3.2.1.min.js"></script> 
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/mobile/js/swiper.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script> 
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/mobile/js/bootbox.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/mobile/js/bootbox.all.min.js"></script>
        <script>
            // Add To Cart Functionality
            $("#addcart").on("click", function () {
                
              // Check User Login or Not;
              var sess_user="<?php echo $this->session->userdata("user_logged_in"); ?>";
              if(sess_user){
                $("#myModal").modal("show");
                var product_id = $(this).data("id");
                var moq = $("#hidemoq").val();
                var unit = $("#hideunit").val();
                var spec_id = $(".spec_id").val();
                var spec_value = $(".spec_value").val();
                var total_quantity = $("#hideqty_value").val();
                var unit_price = $("#hideunit_price").val();
                var spec_count = $("#hidespec_count").val();
                var offer_id = $("#hideoffer_id").val();
                
                if (spec_count == 0) {
                    $("#addcart").on("click",function(){
                        var total_quantity = $("#hideqty_value").val();
					    $.ajax({
                        url: "<?php echo site_url(); ?>product/addtocart",
                        method: "POST",
                        data: {"product_id": product_id, "moq": moq, "unit": unit, "spec_id": spec_id, "spec_value": spec_value, "total_quantity": total_quantity, "unit_price": unit_price,"offer_id": offer_id},
                        dataType: "json",
                        success: function (data)
                        {
                            if (data.status == 0)
                            {
                              window.location.href = "<?php echo site_url(); ?>signin";
                            } else if (data.status == 1) {
                                
                                bootbox.alert({
                                            message: data.message,
                                            backdrop: true,
                                            callback: function () {
                                               location.reload(); 
                                            }
                                        });
                                $("#myModal").modal("hide");
                                //alert(data.message);
                            } else if(data.status == 2)
                            {
                                bootbox.alert({
                                            message:"<h4 class='text-success'>Product Quantity Updated Successfully</h4>",
                                            backdrop: true,
                                            callback: function () {
                                               location.reload(); 
                                            }
                                        });
                                 $("#myModal").modal("hide");
                            }
                        }
                    });   
                 });
                } else if (spec_id == "") {
                    $("#myModal").modal("show");
                } 
                
                if(spec_count>0) {
                   // $("#myModal").modal("show");
                    var clicks = $(this).data('clicks');
                    $(this).data("clicks", !clicks);
                    if (clicks) {
                        var check = true;
                        $("input:radio").each(function () {
                            var name = $(this).attr("name");
                            if ($("input:radio[name=" + name + "]:checked").length === 0) {
                                check = false;
                            }
                        });
                        if (check) {
							
                                $.ajax({
                                url: "<?php echo site_url(); ?>product/addtocart",
                                method: "POST",
                                data: {"product_id": product_id, "moq": moq, "unit": unit, "spec_id": spec_id, "spec_value": spec_value, "total_quantity": total_quantity, "unit_price": unit_price,"offer_id": offer_id},
                                dataType: "json",
                                success: function (data)
                                {
									
                                    if (data.status == 0)
                                    {
                                        window.location.href = "<?php echo site_url(); ?>signin";
                                    } else if (data.status == 1) {
                                        
                                        bootbox.alert({
                                            message: data.message,
                                            backdrop: true,
                                            callback: function () {
                                               location.reload(); 
                                            }
                                        });
                                        $("#myModal").modal("hide");

                                    } else if (data.status == 2)
                                    {
                                       bootbox.alert({
                                            message: data.message,
                                            backdrop: true,
                                            callback: function () {
                                               location.reload(); 
                                            }
                                        });
                                        $("#myModal").modal("hide");
                                    }
                                }
                            });
                        } else {
                            $("#err").html("<center>Please Choose Specification</center>");
                        }
                  }
                }
              }// session user login or not
              else{
                //user not login redirect to signin Page.
                window.location.href = "<?php echo site_url(); ?>signin";
              }
        });
        </script> 
        <script>
            $(".add-favourite").on("click", function () {
                var product_id = $(this).data("product-id");
                $.ajax({
                    url: "<?php echo site_url(); ?>product/add_favourite_product",
                    method: "POST",
                    data: {"product_id": product_id},
                    dataType: "JSON",
                    success: function (data)
                    {
                        if (data.status == 0)
                        {
                            window.location.href = "<?php echo site_url(); ?>signin";

                        } else if (data.status == 1) {
                            bootbox.alert({
                                message: data.message,
                                backdrop: true
                            });
                            

                        } else if (data.status == 2) {
                            $("#heart").addClass('ion-ios-heart').css({"color": "#ff6a00"})
                            var fav = $('#fav_count').html();
                            $('#fav_count').html(parseInt(fav) + 1);
                            bootbox.alert({
                                message: data.message,
                                backdrop: true
                            });
                        }
                    }
                });
            });

        </script>
        <script>
            //swiper
            var swiper = new Swiper('.swiper-container', {
                pagination: {
                    el: '.swiper-pagination',
                },
            });
        </script>
        <script type="text/javascript">
            $("#modal22").click(function () {
              // Check User Login or Not;
              var sess_user="<?php echo $this->session->userdata("user_logged_in"); ?>";
              if(sess_user){
                $("#myModal").modal("show");
                var clicks = $(this).data('clicks');
                $(this).data("clicks", !clicks);
                //alert(clicks);
                if (clicks) {
                    var check = true;
                    $("input:radio").each(function () {
                        var name = $(this).attr("name");
                        if ($("input:radio[name=" + name + "]:checked").length === 0) {
                            check = false;
                        }
                    });
                    if (check) {
                        //alert("check");
                        $("#spec_form").submit();
                        $("#err").text("");

                    } else {
                        $("#err").html("<center>Please Choose Specification</center>");
                    }
                }
              } //session check user login or not
              else
              {
                //user not login redirect to signin Page.
                window.location.href = "<?php echo site_url(); ?>signin";
              }
            });

            $("#closeM").click(function () {
                $("#myModal").modal("hide");
                $('input:radio').prop('checked', false);
            });

            $(function () {
                quan();
            });

            function quan(name) {
                
                var moq = JSON.parse('<?php echo json_encode($productinfos['product_prices'][0]->quantity_from); ?>')
                
                var quantity = $("#qty").val();

                if (name == "plus") {
                    quantity++;
                } else if (name == "minus") {
                    if (quantity > moq) {
                        quantity--;
                    }
                } 
                $("#qty").val(quantity);
                $("#hideqty_value").val(quantity);//new
                $(".product-info-price").val(quantity);//new
            }

            /* selected Box */
            var $links = $('#tbid  .tab-item');
            $links.click(function () {
                $links.removeClass('active');
                $(this).addClass('active');
            });

            $('.select-item-text').click(function () {
                var sel_val = $('input[type=radio]:checked').map(function (_, el) {
                    return el.value
                }).get();

                var sel = $('input[type=radio]:checked').map(function (_, el) {
                    return $(el).attr('id');
                }).get();

                $("#hidespec_id").val(sel);
                $("#hidespec_value").val(sel_val);
                $("#flag").val("1");
            });

            $("#search_k").click(function () {
                $("#headersearch1").show();
            });

        </script>
        <script type="text/javascript">
            function displayResult() {
                $('#searchText').autocomplete({
                    source: function (request, response) {
                        $.ajax({
                            url: "<?php echo site_url(); ?>m/home/searchresult",
                            data: {term: request.term},
                            dataType: "json",
                            success: function (data) {
                                if (data.length > 0)
                                {
                                    var item = [];
                                    $.each(data, function (key, value) {
                                        item.push({
                                            id: value.id,
                                            label: value.label
                                        });
                                    });

                                    $("#search_histroy").html('');
                                    $.each(item, function (key, value) {
                                        $("#search_histroy").append('<a href="<?php echo base_url(); ?>home/productList/' + value.id + '" class="tag">' + value.label + '</a>');
                                    });
                                } else
                                {
                                    $("#search_histroy").html("<center>No Result Found</center>");
                                }
                            }
                        })
                    }
                });
            }
            ;


        </script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.js"></script>
        <script>
                   $(document).ready(function () {
                       $(".fancybox").fancybox({
                           openEffect: "none",
                           closeEffect: "none"
                       });

                       $(".zoom").hover(function () {

                           $(this).addClass('transition');
                       }, function () {

                           $(this).removeClass('transition');
                       });

        $('#notify_buyer').click(function () {
            $.post("<?php echo base_url('m/product/add_notify_buyer'); ?>",
                {product_id: $(this).attr("data-id")})
                .done(function (data) {
                   
                    if (data == 1) {
                        $('#notify_buyer').attr("disabled", true);
                        $('#notify_buyer').css({"background-color": "#ccc", "border": "1px solid #999"});
                        $('#notify-msg-success').html('You have successfully subscribed for notification of this product!')
                            bootbox.alert({
                                            message:"<h4 class='text-success'>You have Successfully Subscribed for Notification of this product!</h4>",
                                            backdrop: true,
                                            callback: function () {
                                               location.reload(); 
                                            }
                                        });
                            } else {
                            bootbox.alert({
                                            message:"<h4 class='text-danger'>You have Already Subscribed for Notification of this product!</h4>",
                                            backdrop: true,
                                            callback: function () {
                                               location.reload(); 
                                            }
                                        });
                    }
                });
             });
        });
        </script>
        <script>
   
        // Set the date we're counting down to
        var countDownDate = new Date("<?php echo $offer_end_datetime; ?>").getTime();

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

            // Display the result in the element with id="demo"
            document.getElementById("offer_timer").innerHTML = days + "D : " + hours + "H : "
                + minutes + "M : " + seconds + "S";

            // If the count down is finished, write some text
            if (distance < 0) {
                clearInterval(x);
                document.getElementById("offer_timer").innerHTML = "";
            }
        }, 1000);
    
        </script>
        <script>
            
            $("#btn_check").on("click",function(){ 
                $(".fa-spinner").show();
                var pincode=$("#pincode_check").val();
                var cg_length = pincode.length;
                if (cg_length == 6) {
                    $.ajax({
                        url: '<?php echo base_url(); ?>home_product/check_pincode',
                        method: 'POST',
                        dataType: 'json',
                        data: {pincode: pincode},
                        success: function (data) {
                            console.log(data);
                            if (data==0)
                            {
                                $("#areacode").html("<span style='color:red'>Sorry ! Not Deliverable Pincode.</span>");
                            }
                            else if (data==1) {
                                $("#areacode").html("<span style='color:green'>The Item is Deliverable at this Pincode.<br>&nbsp;&nbsp;&nbsp;&nbsp;Expected Delivery In 3-5 Days. </span>");
                            } else {
                                $("#areacode").html("<span style='color:#DC3545'>Sorry ! Not Deliverable  Pincode.</span>");
                            }
                            $(".fa-spinner").hide();
                        }
                        
                    });
                }else{
                    $("#areacode").html("<span style='color:#DC3545'>Enter 6 Digit Valid Pin Code</span>");
                    $(".fa-spinner").hide();
                }
            }); 
        </script>
    </body>
</html>