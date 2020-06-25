<?php $this->load->view("front/common/header"); ?>
<style>
    .carousel-indicators
    {
        display:none;
    }
    .img-zoom:hover .hover1{
        transform:scale(1.1);
        transition:1s;

    }
    .hover1{
        height: 100%;
    }
	
	 .bg2
	 {
		 transition:all 0.3s ease-in-out;
	 }
    .hoverScale:hover .bg2{
        transform: scale(1.1);		
        transition: all 0.3s ease-out;
    }

    .product-area-home-three {
        background: #fff;
        padding: 20px;
        padding-bottom: 25px;
    }
    .product-area {
        padding-bottom: 35px;
    }
    .section-title {
        border-bottom: 1px solid #ededed;
    }

    .section-title h3 {
        color: #333333;
        font-size: 20px;
        font-weight: 600;
        text-transform: uppercase;
        margin: 10px 0;
    }

    .single-product-area .gridview {
        background: #ffffff none repeat scroll 0 0;
        position: relative;
        transition: all 0.3s ease 0s;
    }
    .gridview .product-image {
        overflow: hidden;
        position: relative;
        padding: 10px;
    }
    .owl-item{width:260px !important}
    .single-product-area .gridview .list-col8 {
        padding: 0px 15px 14px;
    }

    .owl-prev{
        left: 0px;
        content: "<";
        font-size:30px !important;
    }
    .owl-next {
        right:0px;
        content: ">";
        font-size:30px !important;
    }

</style>
<!-- Slider area start homepage content-->
<div class="main" style="background:#f3f3f5 url(assets/front/images/back.png);background-repeat:  no-repeat;">
    </br>
    </br>
    <!-- ========================= SECTION MAIN ========================= -->
    <div class="slider-area d-none d-sm-block" style="margin:0px;">
        <div class=" ">
            <div class="row">
                <div class="col-xl-3">
                    <nav>
                        <ul class="categori-menu-listslider">
                            <li style="font-size: 20px;color:#bd081b;padding: 7px 0px 5px 0px;">
                                <span class="fa fa-list fa-1x" style="padding-right: 20px;font-size: 18px;"> </span> MY MARKETS</li>
                            <?php
                            foreach ($items as $category) {
                                $title = str_replace('-', '_', $category['title']);
                                $url_title = str_replace(' ', '-', $title);
                                ?>
                                <li><a href="<?php echo site_url(); ?>catalog/<?php echo $url_title; ?>/<?php echo $category['id']; ?>" >
                                        <span class="fa fa-circle fa-1x"  style="font-size: 6px"></span> <?php echo $category['title']; ?> </a>
                                </li>
<?php } ?>
                            <li><a href="<?php echo base_url(); ?>all_categories" style="color:skyblue">  ALL Categories</a></li>
                        </ul>
                    </nav>
                </div>
                <!-- slider-area start -->
                <div class="col-xl-6 px-0">
                    <div id="carousel1_indicator" class="carousel slide" >
                        <ol class="carousel-indicators">
                            <li class="active"></li>
                            <li></li>
                            <li></li>
                        </ol>
                        <div class="carousel-inner">
                            <?php
                            $active = "active";
                            $j = 0;
                            foreach ($banners as $row) {
                                $title = str_replace('-', '_', $row['categories_name']);
                                $url_title = str_replace(' ', '-', $title);
                                ?>
                                <?php
                                if ($j == 0) {
                                    $active = "active";
                                } else {
                                    $active = "";
                                }
                                ?>
                                <div class="carousel-item <?php echo $active; ?>  hm-white-slight">
                                        <?php if ($row['banner_type'] == "Offer") { ?>
                                        <a href = "<?php echo base_url(); ?>deals/discounted_products/20-percent-off">
                                            <img class="d-block w-100 lazy" data-src="<?php echo $row['banners_url']; ?>" height=""
                                                 alt="First slide"> </a>
                                        <?php } else if ($row['banner_type'] == "Category") { ?>
                                        <a href = "<?php echo base_url(); ?>product-catalog/category/<?php echo $row['category']; ?>">
                                            <img class="d-block w-100 lazy" data-src="<?php echo $row['banners_url']; ?>" height=""
                                                 alt="First slide"> </a>
                                         <?php } else { ?>
                                        <img class="d-block w-100 lazy" data-src="<?php echo $row['banners_url']; ?>" height=""
                                             alt="First slide">
    <?php } ?>
                                </div>
    <?php $j++;
} ?>
                        </div>
                        <a class="carousel-control-prev" href="#carousel1_indicator" role="button" data-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="sr-only">Previous</span>
                        </a>
                        <a class="carousel-control-next" href="#carousel1_indicator" role="button" data-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="sr-only">Next</span>
                        </a>
                    </div>
                    <!--/.Controls-->
                </div>
                <aside class="col-md-3">
                    <div class="ta-promotion row-content d-none d-sm-block">
                        <a href="#" class="top-bannertw" >
                            Recommended Products
                        </a>
                        <div class="ta-promotion-list">

                            <?php
                            shuffle($prod_array);
                            $arr = array_slice($prod_array, 0, 3);
                            foreach ($arr as $product) {

                                $title = str_replace('-', '_', $product->name);
                                $url_title = str_replace(' ', '-', $title);
                                ?>
                                <a href="<?php echo base_url(); ?>product-details/<?php echo $url_title; ?>/<?php echo $product->product_id; ?>" class="ta-promotion-item zoom-wrap">
                                    <div class="title" title="<?php echo $product->name; ?> " ><?php
                                        if (strlen($product->name) > 47) {
                                            echo substr($product->name, 0, 47) . '...';
                                        } else {
                                            echo $product->name;
                                        }
                                        ?>
                                    </div>
                                    <div class="view-more">Buy Now</div>
                                    <div class="item-banner">
                                        <img data-src="<?php echo $product->media_url; ?>" class="zoom-in lazy">
                                    </div>
                                </a>
<?php } ?>
                        </div>
                    </div>
                </aside>
                <!-- aside section -->
            </div>
        </div>
    </div>
    <!-- Slider area end offer section-->
    <div class=" d-none d-sm-block">
        <style>
            .m-belt-dacu .m-belt-dacu-item.m-dacu-item-1 {
                display: none;
            }
        </style>
        <div class="m-belt-dacu" style="background-image: linear-gradient(to right top, #3488de, #9378d5, #cd63b5, #ea5785, #eb6150);">
            <h2>Featured Offers</h2>
            <div class="m-belt-dacu-items">

                <div class="scaleH">
                    <a class="m-belt-dacu-item m-dacu-item-0" style="background:url(<?php echo base_url(); ?>assets/front/images/banner/1.jpg)no-repeat top center; background-size:100%" href="<?php echo site_url(); ?>product-catalog/featured/171" >
                        <div  class="m-belt-dacu-banner">
                            <h3 >Mobile Zone</h3>
                            <p  class="sub-title">&nbsp;</p>
                            <span  class="view-more">View</span>
                        </div>
                    </a>
                </div>

                <div class="scaleH">
                    <a  class="m-belt-dacu-item m-dacu-item-2"  style="background:url(<?php echo base_url(); ?>assets/front/images/banner/2.jpg)no-repeat top center; background-size:100%" href="<?php echo site_url(); ?>product-catalog/featured/16"  >
                        <div  class="m-belt-dacu-banner">
                            <h3  class="text-white">Apparel</h3>
                            <p  class="sub-title text-white">&nbsp;</p>
                            <span  class="view-more btn-default">View</span>
                        </div>
                    </a>
                </div>

                <div class="scaleH">
                    <a  class="m-belt-dacu-item m-dacu-item-3" style="background:url(<?php echo base_url(); ?>assets/front/images/banner/3.jpg)no-repeat top center;background-size:100% " href="<?php echo site_url(); ?>product-catalog/featured/18" >
                        <div  class="m-belt-dacu-banner">
                            <h3 >Fashion Zone</h3>
                            <p  class="sub-title">&nbsp;</p>
                            <span  class="view-more">View </span>
                        </div>

                    </a>
                </div>
            </div>
        </div>
    </div>

<?php
//don't show offer zone if there are no offers
if (count($runningOffers) > 0) {
    ?>
        <!-- ========================= Deals Of The Day ========================= -->
        <section class="section-content padding-y-sm bg">
            <div class="">
                <header class="section-heading heading-line">
                    <h4 class="title-section bg">Deals Of The Day</h4>
                </header>
                <div class="card">
                    <div class="row no-gutters allproductC">
                        <div class="col-md-3">
                            <div style="width:100%; height:100%; overflow:hidden;" class="hoverScale">
                                <article href="#" class="card-banner h-100 bg2" style="background:url(<?php echo base_url(); ?>assets/front/images/banner/offer.png)no-repeat top center; background-size:100%; height:100%; width:100%">
                                    <a href="<?php echo base_url('welcome/products_offer')?>" class="linksidebar"></a>
                                    <div class="card-body zoom-wrap">
                                        <h4 class="title text-white my-1">WEEKLY DEALS</h4>
                                        <!-- <h5 class="title mm">Machinery items for manufacturers</h5>
                                           <h5 class="title">Selected Products</h5>-->

                                        <a href="<?php echo base_url('welcome/products_offer')?>" class="btn btn-primary text-white" style="border-radius:2rem;">View All</a>
                                        <!--<img src="assets/front/images/items/001.png" height="200" class="img-bg zoom-in">-->
                                    </div>
                                </article>
                            </div>
                        </div>
                        <!-- col.// -->
                        <div class="col-md-9">
                            <div class="owl-carousel pr-3">
    <?php
        foreach ($runningOffers as $offer) {
        $link = base_url('product-catalog/') . str_ireplace(" ", '-', $offer['categories_name']) .
                '/' . $offer['category_id'];
        ?>
                                    <div class="col-sm-12">
                                        <!-- single product -->
                                        <div class="single-product-area">
                                            <div class="product-wrapper gridview">
											   
                                                <div class="list-col4">
												 <h5 class="title text-black text-center p-2 m-0 text-uppercase"><?php echo $offer['title'] ?></h5>
                                                    <div class="product-image">
                                                        <a href="<?php echo $link; ?>">
                                                            <img src="<?php echo $offer['offer_image']; ?>"  alt="">
                                                        </a>
                                                    </div>
                                                </div>
                                                <div class="list-col8">
                                                    <div class="product-info">
                                                        <h2 class="text-left">
														<a href="<?php echo $link; ?>"><?php echo $offer['categories_name'] ?></a></h2>
                                                        <span class="price">
                                                            <?php
                                                            if (strtolower($offer['offer_type']) == 'flat') {
                                                                echo '<i class="fa fa-inr"></i> ' . $offer['discount_value'] . ' Off';
                                                            } else {
                                                                echo $offer['discount_value'] . ' % Off';
                                                            }
                                                            ?>
                                                        </span>
                                                    </div>
                                                    <div class="deal-counter m-0 mb-0 p-0">
                                                        <div data-countdown="<?php echo $offer['offer_end_time'] ?>"></div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                        <!-- single product end -->
                                    </div>
    <?php } ?>

                            </div>
                        </div>
                        <!-- col.// -->
                    </div>
                    <!-- row.// -->
                </div>
            </div>
        </section>
        <!-- end deal  end -->
            <?php } ?>
    <section class="section-content padding-y-sm bg">
        <div class="">
            <?php
            for ($i = 0; $i < count($sub_finalcats); $i++) {
                $title = str_replace('-', '_', $sub_finalcats[$i]['title']);
                $url_title = str_replace(' ', '-', $title);
                ?>
                <header class="section-heading heading-line">
                    <h4 class="title-section bg"><?php echo $sub_finalcats[$i]['title']; ?></h4>
                </header>
                <div class="card">
                    <div class="row no-gutters allproductC">
                        <div class="col-md-3">
                            <?php
                            if ($sub_finalcats[$i]['id'] == 81) {
                                $imgbg = base_url() . "assets/front/images/banner/Mens_wear.jpg";
                            } else if ($sub_finalcats[$i]['id'] == 18) {
                                $imgbg = base_url() . "assets/front/images/banner/Jwellery.jpg";
                            } else if ($sub_finalcats[$i]['id'] == 86) {
                                $imgbg = base_url() . "assets/front/images/banner/Fahion-acessories.jpg";
                            } else {
                                $imgbg = base_url() . "assets/front/images/banner/kids.jpg";
                            }
                            ?>
                            <div style="width:100%; height:100%; overflow:hidden;" class="hoverScale">
                                <article href="#" class="card-banner h-100 bg2" style="background:url(<?php echo $imgbg; ?>)no-repeat top center; background-size:100% 100%">
                                    <a href="<?php echo base_url(); ?>catalog/<?php echo $url_title; ?>/<?php echo $sub_finalcats[$i]['id']; ?>" class="linksidebar"></a>
                                    <div class="card-body zoom-wrap">
                                        <h4 class="title text-white my-1"><?php echo $sub_finalcats[$i]['title']; ?></h4>
                                        <!-- <h5 class="title mm">Machinery items for manufacturers</h5>
                                           <h5 class="title">Selected Products</h5>-->

                                        <a href="<?php echo base_url(); ?>catalog/<?php echo $url_title; ?>/<?php echo $sub_finalcats[$i]['id']; ?>" class="btn btn-light" style="border-radius:2rem;" >Explore</a>
                                        <!--<img src="<?php //echo base_url();  ?>assets/front/images/items/001.png" height="200" class="img-bg zoom-in">-->

                                    </div>

                                </article>
                            </div>
                        </div>
                        <!-- col.// -->
                        <div class="col-md-9">
                            <ul class="row no-gutters border-cols">
                                <?php $j=0; foreach($sub_finalcats[$i]['elements'] as $subcats):?>
                                    <?php if($j==4){
                                        echo "</ul><ul class='row no-gutters border-cols'>";
                                    }
                                    $title = str_replace('-', '_', $subcats['categories_name']);
                                    $url_title = str_replace(' ', '-', $title);
                                    ?>
                                <li class="col-6 col-md-3">
                                    <a href="<?php echo base_url('product-catalog/'); ?><?php echo $url_title; ?>/<?php echo $subcats['category_id']; ?>" class="itembox">
                                        <div class="card-body">
                                            <p class="word-limit mb-2"><?php echo $subcats['categories_name']; ?></p>
                                            <img class="img-sm lazy" data-src="<?php echo $subcats['categories_image']; ?>">
                                            <?php
                                            if (!empty($subcats['max_dis'])) {
                                                ?>
                                                <p class="m-0 pt-2 text-success">Upto <?php echo $subcats['max_dis']; ?> % Off</p>
                                            <?php } ?>
                                        </div>
                                    </a>
                                </li>
                                <?php $j++; endforeach;?>
                            </ul>
                        </div>
                        <!-- col.// -->
                    </div>
                    <!-- row.// -->
                </div>
                <!-- card.// -->
<?php } ?>
        </div>
        <!-- container .//  -->
    </section>
    <!-- ========================= SECTION CONTENT END// ========================= -->


    <!-- ========================= SECTION ITEMS ========================= -->
    <section class="section-request bg padding-y-sm">
        <div class="">
            <header class="section-heading heading-line">
                <h4 class="title-section bg text-uppercase">Recommended items</h4>
            </header>
            <div class="row-sm">
<?php
foreach ($prod_array as $product) {
    $title = str_replace('-', '_', $product->name);
    $url_title = str_replace(' ', '-', $title);
    ?>
                    <div class="col-lg-2 col-md-3 ">
                        <figure class="card card-product">
                            <div class="img-wrap">
                                <a href="<?php echo base_url(); ?>product-details/<?php echo $url_title; ?>/<?php echo $product->product_id; ?>" >
                                    <img data-src="<?php echo $product->media_url; ?>" width="169px" height="169px" class="lazy"></a></div>
                            <figcaption class="info-wrap">
                                <h6 class="title ">
                                    <a href="<?php echo base_url(); ?>product-details/<?php echo $url_title; ?>/<?php echo $product->product_id; ?>" ><?php echo $product->name; ?></a>
                                </h6>
                                <div class="price-wrap">
                                    <span class="price-new"><i class="fa fa-inr"></i> <?php
                                        //check first iff offer is active first
                                        if (strtolower($product->offer_status) == 'active') {
                                            //check wheather the offer has started
                                            $todaysDate = time();
                                            $offerStartDate = strtotime($product->valid_from . ' ' . $product->time_from);
                                            if ($todaysDate >= $offerStartDate) {
                                                $offerEndDate = strtotime($product->valid_to . ' ' . $product->time_to);
                                                //check whether the offer has expired using time stamp
                                                if ($todaysDate <= $offerEndDate) {
                                                    //if offer is still running then change product discount and final price for
                                                    // display only
                                                    $product->discount = $product->offer_discount_value;
                                                    if (strtolower($product->offer_type) == 'percentage') {
                                                        //$product->mrp = $product->final_price1;
                                                        $product->final_price1 = $product->mrp - (($product->mrp * $product->offer_discount_value) / 100);
                                                        $discount = $product->offer_discount_value . ' % Off';
                                                    }
                                                    //apply flat value to product discount and final price for
                                                    if (strtolower($product->offer_type) == 'flat') {
                                                        //$product->mrp = $product->final_price1;
                                                        $product->final_price1 = $product->mrp - $product->offer_discount_value;
                                                        $discount = ' <i class=\'fa fa-inr\'></i> ' . $product->offer_discount_value . ' Off';
                                                    }
                                                }
                                            }
                                        } else {
                                            if($product->discount != 0){
                                                $discount = $product->discount . ' % Off';
                                            }
                                        }


                                        echo $product->final_price1;
                                        ?>

                                    </span>
                                                <!--						<span style="color:#999999;font-weight:400;font-size: 14px; margin-left:15px;">  <i class="fa fa-inr"></i><del>150.50</del>  </span>-->

                                    <br />
    <?php
    if ($product->mrp != $product->final_price1 && $product->mrp != 0) {
        echo "<i class='fa fa-inr'></i> <span class='price-new text-mute'><del>$product->mrp</del></span> <strong><span style='color:green'> $discount</span></strong>";
    }
    ?>

                                </div>
                                <!-- price-wrap.// -->
                            </figcaption>
                        </figure>
                        <!-- card // -->
                    </div>
                    <!-- col // -->
<?php } ?>
            </div>
            <!-- row.// -->
        </div>
        <!-- container // -->
    </section>
    <!-- Start product section -->

    <!-- ========================= SECTION REQUEST ========================= -->
    <section class="section-request bg padding-y-sm">
        <div class="">
            <header class="section-heading heading-line">
                <h4 class="title-section bg text-uppercase ">Request for Quotation </h4>
            </header>
            <div class="row">

                <div class="col-md-6">

                    <figure class="card-banner banner-size-lg img-zoom"  style="border:10px solid #ccc">
                        <figcaption class="overlay left">
                            <br>
                            <h2 style="max-width: 300px;"> Big boundle or collection of featured items</h2>
                            <br>
                            <a class="btn btn-warning" href="#"> Detail info </a>
                        </figcaption>
                        <a href="<?php echo base_url(); ?>catalog/consumer_electronics/23">
                            <img data-src="<?php echo base_url(); ?>assets/front/images/banners/banner-request.jpg" class="img-fluid hover1 lazy ">
                        </a>
                    </figure>

                </div>
                <!-- col // -->
                <div class="col-md-6">

                    <div class="card card-body" style="height:352px;">
                        <h2 class="title request" style="overflow: unset;">One Request, Multiple Quotes.</h2>
                        <form method="post" action="<?php echo base_url(); ?>submit-rfqs" name="one_request">

                            <div class="form-group">
                                <input class="form-control" name="product_name" type="text" placeholder="what are you looking for...">
                            </div>
                            <div class="form-group" style="margin:10px 0px;">
                                <div class="">
                                    <input class="form-control" name="quantity" type="text" placeholder="Quantity">
                                </div>

                            </div>
                            <div class="form-group">
                                <div>
                                    <select data-style="btn-primary"  data-max-options="2"class="form-control selectpicker custom-select" name="unit" style="font-size:14px; padding-left:10px; " >
                                        <option value=""> Select </option>
                                        <?php
                                        foreach ($units as $row) {
                                            if ($row["units_id"] == "54") {
                                                $selected = "selected";
                                            } else {
                                                $selected = "";
                                            }
                                            ?>
                                            <option value="<?php echo $row['units_id']; ?>" <?php echo $selected; ?>><?php echo $row['units_name']; ?></option>
<?php } ?>
                                    </select>
                                </div>
                            </div>

                            <br>

<?php if ($username) { ?>

                                <div class="form-group">
                                    <input type="submit" value = "Request for quote" style="width:200px;" class="btn btn-sm">
                                </div>
<?php } else { ?>
                                <p><i> Please <a href= "<?php echo base_url(); ?>login" > login </a> to request a quote.</i></p>
<?php } ?>
                        </form>

                    </div>
                </div>
                <!-- col // -->
            </div>
            <!-- row // -->
        </div>
        <!-- container // -->
    </section>
    <!-- ========================= SECTION REQUEST .END// ========================= --
    <!-- wekeely deals--->
    <div class="home-theme-container home-theme-promotion">
        <!-- tangram:3650 begin-->
<?php if ($weekly_deals_product) { ?>
            <div class="theme-item home-theme-weekly-deals-container">
                <div class="home-theme-weekly-deals" data-spm="weeklydeals">
                    <header class="section-heading heading-line">
                        <h4 class="title-section bg text-uppercase">Weekly Deals</h4>
                    </header>
                    <div class="content">
                        <a class="banner" data-goldlog="pos=banner&amp;type=weeklydeals" data-goldkey="theme"
                           style="background:#ff4054 "
                           href="<?php echo base_url(); ?>deals/discounted_products/20-percent-off"
                           >
                            <p class="discount-wrap"><span>From</span> <span class="discount">10% OFF</span></p>
                            <div class="cutdown-wrap">
                                <div class="cutdown-desc">Deals end in:</div>
                                <div id="weekly-deals-cutdown">
                                    <div id="cutdown-days" data-role="day" class="cutnums">03</div>
                                    <div id="cutdown-hours" data-role="hour" class="cutnums">18</div>
                                    <div id="cutdown-minutes" data-role="minute" class="cutnums dot">23</div>
                                    <div id="cutdown-secons" data-role="second" class="cutnums dot">49</div>
                                </div>
                            </div>
                            <div class="view-more" style="height:35px">View More <i class="icon ion-ios-arrow-right"></i></div>
                        </a>
                        <div class="items-wrap">
    <?php
    foreach ($weekly_deals_product as $wkly_prod) {
        $title = str_replace('-', '_', $product->name);
        $url_title = str_replace(' ', '-', $title);
        ?>
                                <div class="item-wrap">
                                    <a href="<?php echo base_url(); ?>product-details/<?php echo $url_title; ?>/<?php echo $product->product_id; ?>"
                                       >
                                        <div class="item-image">
                                            <img class="image zoom-in"
                                                 src="<?php echo $wkly_prod->media_url; ?>">
                                        </div>
                                        <div class="hidden-wrap">
                                            <div class="item-tag">
                                                <span class="status">%<?php echo $wkly_prod->discount; ?></span>
                                                <span class="price"><?php echo $wkly_prod->price1; ?></span>
                                            </div>
                                        </div>
                                    </a>
                                </div>
    <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
<?php } ?>
        <!-- tangram:3651 begin-->
        <div class="theme-item home-theme-buyer-hub-container">
            <div class="home-theme-buyer-hub" data-spm="buyerhub">
                <header class="section-heading heading-line">
                    <h4 class="title-section bg">ECOMMERCE BUYERS' ZONE</h4>
                </header>
                <div class="content">
                    <div class="banner d-flex"
                         style="background-image: url(<?php echo base_url(); ?>assets/front/images/banner/image5.jpg)">
                        <div class="my-auto mx-auto">
                            <p class="m-0" style="font-size:20px; font-weight:lighter"> Customer Support</p>
                        </div>
                    </div>
                    <div class="items-wrap no-flex">
                        <p class="desc">Superior Customer Support</p>
                        <p>
                            Our highly-trained Customer Support employees <br />
                            rapidly resolve urgent issues using troubleshooting, <br />
                            critical thinking and analytical skills to keep <br />
                            operations running efficiently.
                        </p>

                    </div>
                </div>
            </div>
        </div>
        <!-- tangram:3651 end-->
        <div class="theme-item home-theme-brand-zone-container">

            <div class="home-theme-buyer-hub" data-spm="buyerhub">
                <header class="section-heading heading-line">
                    <h4 class="title-section bg">BRAND ZONE</h4>
                </header>
                <div class="content">
                    <div class="banner d-flex"
                         style="background-image: url(<?php echo base_url(); ?>assets/front/images/banner/about-us-img2.jpg)" >

                        <div class="my-auto mx-auto">
                            <h3 class="text-center">Fast Delivery</h3>
                        </div>

                    </div>
                    <div class="items-wrap no-flex">
                        <p class="desc">Logistics Service</p>
                        <p >
                            Our Our Third-party logistics providers are <br />
                            companies that offer comprehensive logistics <br />
                            management services. Basically, these <br />
                            providers will handle most any task related <br />
                            to getting a finished product to its endpoint.
                        </p>
                    </div>
                </div>
            </div>
            <!--
                <div class="home-theme-brand-zone" data-spm="brandzone">
            <header class="section-heading heading-line">
               <h4 class="title-section bg">BRAND ZONE</h4>
            </header>
            <div class="content">
               <div class="banner d-flex"
                  style="background-image: url(<?php echo base_url(); ?>assets/front/images/banner/about-us-img2.jpg)" >
                                <div class="my-auto mx-auto">
                  <h3 class="m-0">Fast Delivery</h3>
                  <p class="description">New to Atzcart.com</p>
                   </div>

               </div>
               <div class="items-wrap">
                  <div class="item-wrap">
                      <p>
                          Our Our Third-party logistics providers /partners are companies that offer exprehensive logistics management services. Basically, these providers will handle most any task related to getting a finished product to its endpoint.
                      </p>
                  </div>

               </div>
            </div>
         </div>-->
        </div>
    </div>
    <!--- end weekly deals --->
    <!-- ========================= SECTION LINKS ========================= -->
    <section class="section-links bg padding-y-sm">
        <div class="">
            <div class="row">
                <!--
                        <div class="col-sm-12">
               <header class="section-heading heading-line">
                  <h4 class="title-section bg text-uppercase">Suppliers by Region</h4>
               </header>
               <ul class="list-icon row">
                   <li class="col-md-2"><a><img src="<?php echo base_url(); ?>assets/admin/images/flags/png/in.png"><span>India</span></a></li>
                   <li class="col-md-2"><a><img src="<?php echo base_url(); ?>assets/admin/images/flags/png/us.png"><span>United States</span></a></li>
                   <li class="col-md-2"><a><img src="<?php echo base_url(); ?>assets/admin/images/flags/png/uk.png"><span>United Kingdom</span></a></li>
                   <li class="col-md-2"><a><img src="<?php echo base_url(); ?>assets/admin/images/flags/png/de.png"><span>Germany</span></a></li>
                   <li class="col-md-2"><a><img src="<?php echo base_url(); ?>assets/admin/images/flags/png/ru.png"><span>Russia</span></a></li>
               </ul>
            </div>
             col // -->
                <div class="col-sm-12">
                    <header class="section-heading heading-line">
                        <h4 class="title-section bg text-uppercase">Trade services</h4>
                    </header>
                    <ul class="list-icon row">
                        <li class="col-md-2"><a href="<?php echo base_url(); ?>trade-assurance"><i class="icon fa fa-comment"></i><span>Trade Assistance</span></a></li>
                        <li class="col-md-2"><a href="<?php echo base_url(); ?>logistics-service"><i class="icon fa fa-globe"></i><span>Worldwide delivery</span></a></li>
                        <li class="col-md-2"><a href="<?php echo base_url(); ?>help-center"><i class="icon fa fa-phone-square"></i><span>Customer support</span></a></li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
    <br><br>
    <!-- ========================= SECTION LINKS END.// ========================= -->
</div>
<!-- main end -->
<?php $this->load->view("front/common/footer"); ?>
<!-- Lazy loading js -->
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jquery.lazy/1.7.9/jquery.lazy.min.js"></script>
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jquery.lazy/1.7.9/jquery.lazy.plugins.min.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $("#carousel1_indicator").carousel({
            interval: 4000,
            pause: false
        });
        $('.lazy').lazy();
    });



    function redir(id)
    {
        window.location = "<?php echo site_url(); ?>product-catalog/featured/" + id;
    }
</script>

<script>
    function getOfferTimer(textId, datetime) {
        // Set the date we're counting down to
        var countDownDate = new Date(datetime).getTime();

        // Update the count down every 1 second
        var x = setInterval(function () {

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
            document.getElementById(textId).innerHTML = 'Offer Ends In ' + days + "d " + hours + "h "
                    + minutes + "m " + seconds + "s ";

            // If the count down is finished, write some text
            if (distance < 0) {
                clearInterval(x);
                document.getElementById(textId).innerHTML = "";
            }
        }, 1000);
    }


</script>
<script>
    jQuery(".owl-carousel").owlCarousel({
        items: 3,
        lazyLoad: true,
        nav: true,
        dots: false,
        pagination: false,
        scrollPerPage: true
    });
</script>
