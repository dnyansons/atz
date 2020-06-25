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
    </head>
    <body>
    <ai-header>
        <div class="header-container" style="position: fixed;">
            <div class="header-wrap" ab-test-bucket="">
                <div class="inner ripple rtl-icon">	
                    <a href="<?php echo site_url(); ?>home">  <i class="icon ion-android-arrow-back"></i></a> 
                </div>
                <div class="master">
                    <div class="title">
                        <div class="title-placeholder">
                            <!--padding-->
                        </div>
                        <title>Coupons Products</title>
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
                <?php foreach ($getUserCoupons as $getUserCoupon): ?>
                    <li>
                        <a id="coupon-action" class="coupon-action" href="javascript:void(0)">
                            <span class="coupon-text">
                                Coupons
                            </span>
                            <div class="coupon-detail-wrap">

                                <div class="coupon-detail normal">
                                    <div class="coupon-specification">
                                        <input type="hidden" name="coupon" id="coupon" value="<?php echo $coupons[0]->coupon_uniqe_id; ?>">
                                        <span>
                                            INR <?php echo $getUserCoupon->coupon_value; ?> OFF
                                        </span>
                                        <span>
                                            <span class="coupon-line1">
                                                Get the Coupon
                                            </span> 
                                        </span>
                                    </div>
                                </div>
                                <div class="coupon-download coupon-line1"></div>
                            </div>
                            <i class="iconfont-arrow-right">
                            </i>
                        </a>
                        <div class="delf" data-id="<?php echo $getUserCoupon->coupon_uniqe_id; ?>">Apply this Coupon</div>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>

    <script type="text/javascript" src="<?php echo base_url(); ?>assets/mobile/js/jquery-3.2.1.min.js"></script>
    <script>
        $(".delf").on("click", function () {
            var product_id = $(this).data("id");
            $.ajax({
                url: "<?php echo site_url(); ?>product/remove_favourite_product",
                method: "POST",
                data: {"product_id": product_id},
                success: function (data)
                {
                    location.reload();
                }
            })
        })
    </script>
</body>
</html>