<?php
$this->load->view("front/common/header");
?>

<style>
    @import url(<?php echo base_url(); ?>assets/front/css/new_product.css);

    /* .menu-item:hover + .sub-menu
     {
     display: block !important;
     }
     .sub-menu:hover{
        display: block !important;
     }*/

    #menu ul {
        list-style: none;
        color: white;
        width: 100%;
        padding: .5em;
    }

    #menu ul ul {
        display: none;
        padding: 20px;
        height: 444px;
        overflow: hidden;
        box-shadow: 0 2px 8px 0 rgba(0, 0, 0, .05);
        border-radius: 12px;
        position: absolute;
        z-index: 10;
        top: 0;
        left: 130px;
        background: #fff;
    }

    #menu ul ul li {
        height: 26px;
        line-height: 26px;
        color: #151515;
        display: block;
        display: -webkit-box;
        -webkit-line-clamp: 1;
        overflow: hidden;
        text-overflow: ellipsis;
        -webkit-box-orient: vertical;
        white-space: normal;
    }
</style>
<div class="ocms-container" dir="ltr">
    <div class="">
        <div class=" ocms-fusion-alibaba-pc-ch-layout-main b2b-ocms-fusion-comp column-two">
            <div class="channel-main-bainer ">
                <div class="banner-content ml-5">
                    <?php echo $main_category['title']; ?>
                </div>

                <div class="mask" data-reactid="4"></div>
            </div>
            <div class="ch-main-layout column-two container-fluid">
                <div class="ch-left-layout col-2">
                    <div name="left-category" class="croco slot">
                        <div>
                            <div class="ocms-fusion-alibaba-pc-ch-category-nav b2b-ocms-fusion-comp"
                                 data-spm="channel_left_category">
                                <div class="alife-bc-category-nav">
                                    <div class="menu-container">
                                        <div class="category-menu-wrapper " data-reactid="4">
                                            <div class="category-head" data-reactid="5">
                                                <!-- react-text: 6 -->CATEGORIES<!-- /react-text -->
                                                <div class="category-head-border"></div>
                                            </div>
                                            <!---
											<div class="menu" id="menu">
                                                <?php //foreach ($child_cats as $child_cat): ?>
                                                    <div data-reactid="9">
                                                        <a class="menu-item" target="_blank" href="<?php //echo site_url('product-catalog/') . underscore($child_cat->categories_name) . "/" . $child_cat->category_id; ?>">
                                                            <div class="category-menu-link" data-reactid="11"><?php //echo $child_cat->categories_name; ?></div>
                                                            <div class="icon-place" data-reactid="12">
                                                                <div class="icon-wrapper" >
                                                                    <i class="icon ion-ios-arrow-forward"></i></div>
                                                            </div>
                                                        </a>
                                                        <div class="sub-menu" style="display: none;">
                                                            <div class="sub-menu-wrapper" id="" >
                                                                <div class="col">
                                                                    <?php //foreach($child_cat->sub as $sub):?>
                                                                    <a href="<?php //echo site_url('product-catalog/') . underscore($sub->categories_name) . "/" . $sub->category_id; ?>" target="_blank" class="sub-menu-item" title="<?php //echo $sub->categories_name;?>">
                                                                        <?php //echo $sub->categories_name;?>
                                                                    </a>
                                                                    <?php //endforeach;?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php //endforeach; ?>
                                            </div>
											-->

                                            <div id="menu">
                                                <ul>
                                                    <?php foreach ($child_cats as $child_cat): ?>
                                                        <li>
                                                            <a class="menu-item" target="_blank"
                                                               href="<?php echo site_url('product-catalog/') . underscore($child_cat->categories_name) . "/" . $child_cat->category_id; ?>">
                                                                <div class="category-menu-link" data-reactid="11">
                                                                    <?php echo $child_cat->categories_name; ?>
                                                                </div>
                                                                <div class="icon-place" data-reactid="12">
                                                                    <div class="icon-wrapper">
                                                                        <i class="icon ion-ios-arrow-forward"></i>
                                                                    </div>
                                                                </div>
                                                            </a>
                                                            <ul class="submenu">
                                                                <?php foreach ($child_cat->sub as $sub): ?>
                                                                    <li>

                                                                        <a href="<?php echo site_url('product-catalog/') . underscore($sub->categories_name) . "/" . $sub->category_id; ?>"
                                                                           target="_blank" class="sub-menu-item"
                                                                           title="<?php echo $sub->categories_name; ?>">
                                                                            <?php echo $sub->categories_name; ?>
                                                                        </a>


                                                                    </li>
                                                                <?php endforeach; ?>
                                                            </ul>
                                                        </li>
                                                    <?php endforeach; ?>
                                                </ul>
                                            </div>

                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="ch-right-layout col-10" data-reactid="7">
                    <div name="right-content" class="croco slot">
                        <div>
                            <div class="ocms-fusion-alibaba-pc-ch-slider-banner b2b-ocms-fusion-comp">
                                <div class="next-slick next-slick-inline next-slick-horizontal">
                                    <div draggable="false" class="next-slick-inner next-slick-initialized">
                                        <div class="next-slick-list">
                                            <div class="next-slick-track"
                                                 style="opacity: 1; width: 3000px; transform: translate3d(0px, 0px, 0px);">
                                                <?php
                                                $ext = pathinfo($main_category['banner_image'], PATHINFO_EXTENSION);
                                               
                                                $len=strlen($ext);
                                                if (empty($ext) || $len==0) {
                                                   $banner_image = base_url('assets/front/images/banners/CommonBanner.jpg');
                                                } else {
                                                 
                                                    $banner_image = $main_category['banner_image'];
                                                }
                                                ?>
                                                <a class="next-slick-slide next-slick-active ch-banner-wrapper"
                                                   style="outline: none; width: 100%;">
                                                    <div class="inner-banner"
                                                         style="background:url(<?php echo $banner_image; ?>)"></div>

                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div>
                            <div class="ocms-fusion-alibaba-pc-ch-nav-with-image b2b-ocms-fusion-comp"
                                 data-spm="channel_image_category" data-realctr="id:topCategoryNav,ext:floorExp-1"
                                 data-reactroot="" data-reactid="1" data-react-checksum="-91759470">
                                <div class="ch-nav-img-head" data-reactid="2">SHOP BY CATEGORY</div>
                                <ul class="ch-nav-img-list" data-reactid="3">
                                    <?php $i = 1;
                                    foreach ($child_cats as $child_cat): if ($i <= 8) { ?>
                                        <li class="ch-nav-img-item" data-reactid="4">
                                            <a
                                                    href="<?php echo site_url('product-catalog/') . underscore($child_cat->categories_name) . "/" . $child_cat->category_id; ?>"
                                                    target="_blank">
                                                <div class="img-box" data-reactid="6">
                                                    <img class="img-item"
                                                         src="<?php echo $child_cat->categories_image; ?>"
                                                         data-reactid="7">
                                                </div>
                                                <div class="category-name" title="Air Conditioning Appliances"
                                                     data-reactid="8"><?php echo $child_cat->categories_name; ?></div>
                                            </a>
                                        </li>
                                    <?php }
                                        $i++; endforeach; ?>
                                </ul>
                            </div>
                        </div>
                    </div>


                    <div>
                        <?php foreach ($child_cats as $key => $val) :
                            if (count($val->products) > 0) {
                                ?>
                                <div class="ocms-fusion-alibaba-pc-ch-complex-offerlist-floor b2b-ocms-fusion-comp"
                                     data-reactroot="" data-reactid="1">
                                    <div class="ocms-fusion-alibaba-pc-ch-floor-title b2b-ocms-fusion-comp"
                                         data-reactid="2">
                                        <span class="floor-title"
                                              data-reactid="3"><?php echo $val->categories_name; ?></span>
                                        <div class="floor-label" data-reactid="4"></div>
                                    </div>
                                    <div>
                                        <div class="container">
                                            <div class="row">
                                                <?php foreach ($val->products as $product):?>
                                                    <div class="col-md-3 col-sm-3 col-xs-10 list-wrapper">
                                                        <div class="offer-item">
                                                            <div class="bravo-normal-offer"
                                                                 data-realctr="id:undefined,ext:tabIndex-Bedding_firstOfferList"
                                                                 data-reactid="9">
                                                                <div class="bravo-offer-image main-section"
                                                                     data-reactid="10">
                                                                    <div class="place" data-reactid="11"></div>
                                                                    <a class="product-link"
                                                                       href="<?php echo site_url(); ?>product-details/<?php echo $product->name . '/' . $product->product_id; ?>"
                                                                       target="_blank" data-reactid="12">
                                                                        <div class="img-wrapper offer-image"
                                                                             data-reactid="13"><img class="inner-img"
                                                                                                    src="<?php echo $product->media_url; ?>"
                                                                                                    data-reactid="14">
                                                                        </div>
                                                                    </a>
                                                                </div>
                                                                <div class="bravo-offer-title main-section">
                                                                    <a class="title-link line-count-1" target="_blank"
                                                                       title="<?php echo $product->name; ?>"
                                                                       href="<?php echo site_url(); ?>product-details/<?php echo $product->name . '/' . $product->product_id; ?>">
                                                                        <?php echo $product->name; ?>
                                                                    </a>
                                                                </div>
                                                                <div class="main-section">
                                                                <?php
                                                                    $offerRunningStatus = $this->Offer_model
                                                                                               ->checkOfferValidity(
                                                                                                    $product->valid_from . ' ' . $product->time_from,
                                                                                                    $product->valid_to . ' ' . $product->time_to,
                                                                                                    $product->status);
                                                                    if ($offerRunningStatus == true) {
                                                                        if(strtolower($product->offer_type) == 'flat') {
                                                                            $product->discount = '<i class="fa fa-inr"></i> '.$product->offer_discount_value. ' Off';
                                                                            $product->final_price = $product->mrp - $product->offer_discount_value;
                                                                            $product->final_price1 = $product->mrp - $product->offer_discount_value;
                                                                        }
                                                                        if(strtolower($product->offer_type) == 'percentage') {
                                                                            $product->discount = $product->offer_discount_value.' % Off';
                                                                            $product->final_price = $product->mrp - ($product->mrp * $product->offer_discount_value * 0.01);
                                                                            $product->final_price1 = $product->final_price;
                                                                        }
                                                                    } else {
                                                                        $product->discount .= ' % Off';
                                                                    }

                                                                ?>
                                                                    <div class="bravo-offer-price sub-section"
                                                                         title="<?php echo $product->final_price; ?>"><i
                                                                                class="fa fa-inr"></i> <?php echo sprintf("%01.2f", $product->final_price1); ?>
                                                                    </div>
                                                                    <?php if ($product->mrp != $product->final_price && $product->mrp != 0) { ?>
                                                                        <i class="fa fa-inr"></i>
                                                                        <del><?php echo sprintf("%01.2f", $product->mrp); ?></del> <span
                                                                                class="text-success font-weight-bold"><?php echo $product->discount; ?></span>
                                                                    <?php } ?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php endforeach; ?>


                                            </div>
                                            <?php if (count($val->products) >= 10) { ?>
                                                <div class="row">
                                                    <div class="col-12">
                                                        <a href="<?php echo site_url('product-catalog/') . underscore($val->categories_name) . "/" . $val->category_id; ?>"
                                                           class="btn btn-link pull-right">View more</a>
                                                    </div>
                                                </div>
                                            <?php } ?>

                                        </div>
                                    </div>
                                </div>
                            <?php } endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<?php $this->load->view("front/common/footer"); ?>

<script type="text/javascript">
    // $(".#menu>ul>li a").hover(function(){
    // $(".#menu>ul>li a").removeClass("active");
    // $(this).addClass("active");
    // })  

    // $(function(){
    // $('#menu>ul>li').on({
    // mouseenter:function(){
    // $(this).siblings().children().hide()
    // $(this).children().show()
    // },
    // })
    // $('#menu>ul').on({
    // mouseleave:function(){
    // $(this).children().hide()
    // },
    // })
    // })

    $('#menu>ul>li').hover(
        function () {
            //console.log('hover over');
            var ss = $(this).children('.submenu').children();
            if (ss.length > 0) {
                $(this).children('.submenu').show();
            } else {
                $(this).children('#menu ul ul').hide();
            }
        },
        function () {
            //console.log('hover out');
            $(this).children('.submenu').hide();
        });
</script>