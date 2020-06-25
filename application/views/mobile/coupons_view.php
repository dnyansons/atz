<!doctype html>
<html class="no-js" lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
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

            .product-basic-info .coupon-action {
                display: flex;
                padding: 1rem 1.6rem;
                width: 100%;
                height: 6.8rem;
                font-size: 1.4rem;
                color: #666;
                background: #f7f8fa;
                box-sizing: border-box;
                box-shadow: 0 2px 4px 0 #e6e7eb;
            }
            .product-basic-info .coupon-action .coupon-text, .product-basic-info .coupon-action .iconfont-arrow-right {
                padding: .4rem 0;
            }
            .product-basic-info .coupon-action .coupon-text {
                display: inline-block;
                flex: 0 0 70px;
                width: 70px;
                color: #999;
            }
            .product-basic-info .coupon-action .coupon-detail-wrap {
                flex: 1;
            }
            .product-basic-info .coupon-action .coupon-detail {
                font-size: 0;
            }
            .product-basic-info .coupon-action .coupon-detail .coupon-specification {
                position: relative;
                display: inline-block;
                vertical-align: top;
                border: 1px solid #f60;
                padding: 3px 8px;
                font-size: 1.2rem;
                line-height: 1.2rem;
                color: #f60;
            }
            .product-basic-info .coupon-action .coupon-detail .coupon-specification>span:last-child {
                max-width: 10rem;
                height: 1.2rem;
                vertical-align: top;
                overflow: hidden;
            }
            .product-basic-info .coupon-action .coupon-detail .coupon-specification>span {
                display: inline-block;
            }
            .product-basic-info .coupon-action .coupon-line1 {
                display: -webkit-box;
                -webkit-line-clamp: 1;
                overflow: hidden;
            }
            .product-basic-info .coupon-action .coupon-text, .product-basic-info .coupon-action .iconfont-arrow-right {
                padding: .4rem 0;
            }
            .product-basic-info .coupon-action .coupon-text {
                display: inline-block;
                flex: 0 0 70px;
                width: 70px;
                color: #999;
            }

            .coupon-action {
                display: flex;
                padding: 13px 24px;  
                width: 276px;
                margin: 8px auto;
                font-size: 1rem;
                color: #666;
                background: #f7f8fa;
                box-sizing: border-box;
                box-shadow: 0 2px 4px 0 #e6e7eb;
                align-items: center;
            }
            .action .coupon-text, .product-basic-info .coupon-action .iconfont-arrow-right {
                padding: .4rem 0;
            }

            .coupon-text {
                display: inline-block;
                flex: 0 0 80px;
                width: 70px;
                color: #999;
            }
            .coupon-detail .coupon-specification {
                font-size: 11px; 
                font-weight:600;
                color:#454545;
                text-align:center;
            }

            .coupon-specification:before {
                left: -1px;
                border-left: none;
            }

            .coupon-specification:after {
                right: -1px;
                border-right: none;
            }
            .coupon-specification:after, .coupon-specification:before {
                position: absolute;
                top: 16px;
                z-index: 1;
                display: inline-block;
                width: 13px;
                height: 14px;
                border: 1px solid #bd081b;
                border-radius: 50%;
                background: #fff;
                content: "";
            }

            .alert{
                margin-top: 10px;
                margin: 15px;
            }
        </style>
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
                        <title>Coupons</title>
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
                <?php if (!empty($getUserCoupons)) { ?> 
                    <?php foreach ($getUserCoupons as $getUserCoupon): ?>
                       <div class="mb-3"> 
                        <form class="form-horizontal coupon_ids_<?php echo $getUserCoupon->coupon_id;?>" method="post" action="<?php echo site_url();?>m/home/coupon_pro_list" >
                            <a id="coupon-action" class="coupon-action" data-value="<?php echo $getUserCoupon->coupon_id;?>" href="javascript:void(0)" style="background:url('<?php echo base_url(); ?>assets/front/images/banner/coupon.svg')no-repeat; background-size:cover; padding:5px;" >								
                                 <div class="coupon-detail-wrap">
                                     <div class="coupon-detail normal">
                                         <div class="coupon-specification">
                                             <input type="hidden" name="coupon" id="coupon_id" class="coupon_code" value="<?php echo $getUserCoupon->coupon_id;?>" >
                                             <span><h6>Flat <?php echo $getUserCoupon->coupon_value;  ?><?php echo ($getUserCoupon->discount_type=='percentage'?'% OFF':' INR OFF'); ?></h6></span>
                                             <span><h4> <?php echo $getUserCoupon->coupon_code; ?></h4></span>
                                             <span class="coupon-entry-dis" title="">
                                                     Product value more than MOQ <?php echo $getUserCoupon->moq;  ?>, Capped at 
                                                 </span>
                                                 <span class="coupon-line1">Apply Coupon</span><br/>
                                                 <span class="coupon-line1">Valid Upto :<?php echo date("d-F-Y",strtotime($getUserCoupon->valid_to)); ?></span> 
                                         </div>
                                     </div>
                                 </div>
                                 <span class="coupon-text" style="display: flex;justify-content: center;align-items: center;" onClick="getCoupon(<?php echo $getUserCoupon->coupon_uniqe_id; ?>);">
                                     Get Coupons
                                 </span>	
                             </a>
                        </form>
                    </div>
                    <?php endforeach; ?>
                <?php } else { ?>
                    <div class="text-white text-left mt-2 p-2" style="background:#FF9751!important;    box-shadow: 0 5px 11px 0 rgba(0,0,0,.18), 0 4px 15px 0 rgba(0,0,0,.15);">
                        <small class="title"> No Coupons Available </small>
                    </div>
                <?php } ?> 
            </ul>
        </div>
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/mobile/js/jquery-3.2.1.min.js"></script>
        <script>
//               $(".coupon-action").on("click",function(){
//                   var coupon=$(this).data("value");
//                   $(".coupon_ids_"+coupon).submit();
//               })   
        </script>
    </body>
</html>