<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title> <?php echo $company->company_name;?> </title>
        <meta content="width=device-width, initial-scale=1.0" name="viewport">
        <link href="img/favicon.ico" rel="icon">
        <link rel="icon" href="<?php echo base_url(); ?>/assets/admin/images/favicon.ico" type="image/x-icon">
        <link href="https://fonts.googleapis.com/css?family=Raleway:400,500,700|Roboto:400,900" rel="stylesheet">
        <link href="<?php echo base_url(); ?>assets/front/css/bootstrap.min.css" rel="stylesheet">
        <link href="<?php echo base_url(); ?>assets/front/css/font-awesome.min.css" rel="stylesheet">
        <link href="<?php echo base_url(); ?>assets/seller_minisite/css/style.css" rel="stylesheet">
        <link href="<?php echo base_url(); ?>assets/seller_minisite/css/custom-s.css" rel="stylesheet">
        <style>
            .wrap-box {
            border: none;
            padding:0px !important;
            }
            .root #bd {
            padding: 20px 0 1px;
            background: #fff !important;
            }
        </style>
    </head>
    <body>

        <header id="header">
            <div class="container">
                <div id="logo" class="pull-left">
                    <a href="#"><img src="<?php echo $company->logo;?>" alt="" title="" /></img></a>
                </div>
                <nav id="nav-menu-container">
                    <ul class="nav-menu">
                        <li><a href="#">Home</a></li>
                        <li><a href="#productContainer">Products</a></li>
                        <li><a href="#CompanyProfileContainer">Company Profile</a> </li>
                        <li><a href="#contactContainer">Contact Us</a></li>
                    </ul>
                </nav>
                <!-- #nav-menu-container -->
            </div>
        </header>
        <!-- #header -->
        <!-- Hero -->
        <section  background="">
            <div class="container-fluid text-center">
                <div class="row">
                    <div id="carousel1_indicator" class="carousel slide" data-ride="carousel">
                        <ol class="carousel-indicators">
                            <li data-target="#carousel1_indicator" data-slide-to="0" class="active"></li>
                            <li data-target="#carousel1_indicator" data-slide-to="1"></li>
                            <li data-target="#carousel1_indicator" data-slide-to="2"></li>
                        </ol>
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <img class="d-block w-100" src="<?php echo base_url();?>assets/seller_minisite/img/first_slide.jpg" style="" class>
                            </div>
                            <div class="carousel-item">
                                <img class="d-block w-100" src="<?php echo base_url();?>assets/seller_minisite/img/first_slide.jpg" alt="Second slide">
                            </div>
                            <div class="carousel-item">
                                <img class="d-block w-100" src="<?php echo base_url();?>assets/seller_minisite/img/first_slide.jpg" alt="Third slide">
                            </div>
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
                </div>
            </div>
        </section>
        <br>
        <!--Main category--->
        <div class="root">
            <div class="layout layout-1200" id="bd_2">
                <div class="grid grid1200">
                    <div id="5004896452" class="J_module">
                        <div data-reactroot=""
                            class="icbu-mod-wrapper head-border with-round module-recommendProductTile large with-title">
                            <div class="wrap-box">
                                <div class="mod-header" id="CompanyProfileContainer">
                                    <h3 class="title">Company Introduction</h3>
                                </div>
                                <div class="mod-content">
                                    <p style="padding:10px;">
                                        <?php echo $company->introduction;?>
                                    <p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!---products--->
            <div class="layout layout-1200" id="bd_2">
                <div class="grid grid1200">
                    <div id="5004896452" class="J_module">
                        <div data-reactroot=""
                            class="icbu-mod-wrapper head-border with-round module-recommendProductTile large with-title">
                            <div class="wrap-box">
                                <div class="mod-header" id="productContainer">
                                    <h3 class="title">Products</h3>
                                </div>
                                <div class="mod-content">
                                    <div class="icbu-product-list with-border tile-product-list">
                                        <div class="row">
                                            <?php foreach($products as $product):?>
                                            <div class="product-item col-md-3" style="width: 25%;">
                                                <div class="icbu-product-card vertical small" style="width: 160px;">
                                                    <a
                                                        class="product-image"
                                                        href="<?php echo site_url();?>product-details/<?php echo $this->Product_model->seoUrl($product['product_name']);?>/<?php echo $product['product_id'];?>"
                                                        target="_blank" style="width: 160px; height: 160px;">
                                                        <div
                                                            class="next-row next-row-no-padding next-row-justify-center next-row-align-center img-box">
                                                            <img   src="<?php echo $product['media_url'];?>">
                                                        </div>
                                                    </a>
                                                    <div class="product-info">
                                                        <div class="title clamped"
                                                            style="overflow: hidden; text-overflow: ellipsis; -webkit-box-orient: vertical; display: -webkit-box; -webkit-line-clamp: 2;">
                                                            <!-- react-text: 68 -->
                                                            <!-- /react-text --><a class="title-link icbu-link-normal"
                                                                href=""
                                                                target="_blank"
                                                                title="High quality Outsunny 4 Person Aluminum Portable Folding Suitcase outdoor Picnic Table Set with 4 Chairs and Umbrella Hole">
                                                                <span class="title-con">
                                                                    <?php echo $product['product_name'];?>
                                                                </span>
                                                            </a>
                                                        </div>
                                                        <div class="price" title="">
                                                            <span class="num">
                                                                <i class="fa fa-inr"></i> <?php echo $product['final_price1'];?>
                                                            </span>
                                                            <span
                                                                class="unit">
                                                                <span class="seperate">/</span>
                                                                <!-- react-text: 75 -->Set
                                                                <!-- /react-text -->
                                                            </span>
                                                        </div>
                                                        <div class="moq" title="">
                                                            <span class="value">
                                                                <del><?php echo $product['mrp'];?></del>
                                                            </span>
                                                            <span class="description text-success" ><?php echo $product['discount'];?> % Off</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php endforeach;?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--end products--->
            <!--- send form--->
            <div class="layout layout-1200" id="bd_5">
                <div class="grid grid1200">
                    <div id="5004896456" class="J_module ">
                        <div data-reactroot="" class="fast-feedback-form full module-fast-feedback">
                            <div class="fast-feedback-title" id="contactContainer">Send message to supplier</div>
                            <div class="fast-feedback-wrapper">
                                <form id="fast-feedback-form" class="next-form next-form-left ver next-form-medium">
                                    <div class="next-form-item next-row" label="To:">
                                        <label
                                            class="next-col-6 next-form-item-label">To:</label>
                                        <div class="next-col-14 next-form-item-control">
                                            <p>Lance Rowe</p>
                                            <!-- react-text: 16 -->
                                            <!-- /react-text -->
                                            <div class=""></div>
                                            <!-- react-text: 18 -->
                                            <!-- /react-text -->
                                        </div>
                                    </div>
                                    <div class="next-form-item next-row" label="Message:" required="">
                                        <label for="content"
                                            required="" class="next-col-6 next-form-item-label">Message:</label>
                                        <div class="next-col-14 next-form-item-control">
                                            <span
                                                class="next-input next-input-multiple">
                                                <textarea name="content" rows="4"
                                                    placeholder="Enter your inquiry details such as product name, color, size, quantity, material, etc."
                                                    data-meta="Field" id="content" maxlength="8000" type="text"
                                                    height="100%"></textarea>
                                                <span class="next-input-control">
                                                    <span
                                                        class="next-input-len">
                                                        <!-- react-text: 26 -->0
                                                        <!-- /react-text -->
                                                        <!-- react-text: 27 -->/
                                                        <!-- /react-text -->
                                                        <!-- react-text: 28 -->8000
                                                        <!-- /react-text -->
                                                    </span>
                                                </span>
                                            </span>
                                            <!-- react-text: 29 -->
                                            <!-- /react-text -->
                                            <div class=""></div>
                                            <!-- react-text: 31 -->
                                            <!-- /react-text -->
                                        </div>
                                    </div>
                                    <div class="next-form-item next-row" label="">
                                        <label
                                            class="next-col-6 next-form-item-label"></label>
                                        <div class="next-col-14 next-form-item-control">
                                            <button type="button"
                                                class="next-btn next-btn-primary next-btn-medium">
                                                <!-- react-text: 36 -->Send
                                                <!-- /react-text -->
                                            </button>
                                            <div class="next-form-item next-row" style="display: none; margin: 20px 0px;">
                                                <div class=" next-form-item-control">
                                                    <span
                                                        class="next-input next-input-single next-input-medium"
                                                        style="width: 120px; margin-left: 10px; vertical-align: top;"><input
                                                        type="text" name="imagePassword" data-meta="Field" id="checkcode"
                                                        value="" height="100%"></span><input type="hidden" name="_csi_"
                                                        value="af060d88b8ce46ea944a8c0c647f8fed"><!-- react-text: 42 -->
                                                    <!-- /react-text -->
                                                    <div class=""></div>
                                                    <!-- react-text: 44 -->
                                                    <!-- /react-text -->
                                                </div>
                                            </div>
                                            <!-- react-text: 45 -->
                                            <!-- /react-text -->
                                            <div class=""></div>
                                            <!-- react-text: 47 -->
                                            <!-- /react-text -->
                                        </div>
                                    </div>
                                    <div class="next-form-item next-row" label="">
                                        <label for="sendCard"
                                            class="next-col-6 next-form-item-label"></label>
                                        <div class="next-col-14 next-form-item-control">
                                            <label for="sendCard"><span
                                                class="next-checkbox checked "><span class="next-checkbox-inner"><i
                                                class="next-icon next-icon-select next-icon-xs"></i></span><input
                                                type="checkbox" name="sendCard" data-meta="Field" id="sendCard"
                                                aria-checked="true" value="on"></span><span
                                                class="next-checkbox-label"><span class="inquiry-extra-check"
                                                style="font-size: 12px; color: rgb(102, 102, 102);">I agree to share my
                                            <span class="stress">Business Card</span> to the
                                            supplier.</span></span></label><!-- react-text: 58 -->
                                            <!-- /react-text -->
                                            <div class=""></div>
                                            <!-- react-text: 60 -->
                                            <!-- /react-text -->
                                        </div>
                                    </div>
                                    <div id="_umfp" style="display: inline; width: 1px; height: 1px; overflow: hidden;"></div>
                                </form>
                                <div
                                    style="width: 100%; height: 100%; position: absolute; left: 0px; top: 0px; text-align: center; background-color: rgb(245, 247, 250); display: none;">
                                    <div style="width: 350px; margin: 0px auto;">
                                        <i
                                            class="next-icon next-icon-success next-icon-xxl"
                                            style="color: rgb(29, 193, 29); margin: 20px 0px;"></i><br>
                                        <p style="font-size: 16px; margin-bottom: 12px;">Messeage has been sent sucessfully.</p>
                                        <p style="font-size: 14px; color: rgb(153, 153, 153);">Check your messeages on <a
                                            href="//message.Atzcart.com" target="_blank">Messeage Center</a>, the supplier
                                            willcontacts you soon.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--send end form-->
            <!--why choose us--->
            <div class="layout layout-1200" id="bd_6">
                <div class="grid grid1200">
                    <div id="5004896449"  class="J_module  " >
                        <div data-reactroot="" class="module-companyOverview">
                            <div class="company-basic-info"
                                style="background-image:url(<?php echo base_url();?>assets/seller_minisite/img/bck.jpg)">
                                <div class="bg-theme">
                                    <div class="next-row next-row-no-padding next-row-justify-center next-row-align-center bg-mask">
                                        <div class="intro-content">
                                            <div class="title">Why Choose Us</div>
                                            <div
                                                style="overflow: hidden; text-overflow: ellipsis; -webkit-box-orient: vertical; display: -webkit-box; -webkit-line-clamp: 2;">
                                                <a href="" target="_blank" class="desc" >
                                                    <?php echo $company->comp_advantages;?>
                                                </a>
                                            </div>
                                            <div class="tags">
                                                <a class="tag authed" href="" target="_blank"
                                                    title="Founded in 2016">
                                                    <span class="tag-text">Founded in <?php echo $company->year_of_register;?></span>
                                                    <span
                                                        class="bc-verified-icon auth tag-icon"
                                                        title="Authenticated and Audited">
                                                    </span>
                                                </a>
                                                <a class="tag" href="" target="_blank" >
                                                    <span class="tag-text"><?php echo $company->no_of_employee;?></span>
                                                </a>
                                                <a class="tag" href="" target="_blank">
                                                    <span class="tag-text"><?php echo $company->office_size;?></span>
                                                </a>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="company-introduction">
                                <div class="title">Company Address</div>
                                <div class="verify-details" type="wrap">
                                    <a class="vd-item icbu-clearfix authed"
                                        href="" target="_blank">
                                        <div class="left"><i class="company-icon location"></i></div>
                                        <div class="right">
                                            <div class="ver-name">
                                                Location
                                            </div>
                                            <div class="ver-content icbu-clearfix">
                                                <span class="bc-verified-icon auth verified-icon"
                                                    title="Authenticated and Audited">

                                                </span>
                                                <span class="con-text" title="Sichuan, China (Mainland)">
                                                <?php echo $company->comp_operational_addr.",".$company->comp_operational_city.",".
                                                      $company->comp_operational_state.",".$company->comp_operational_region;
                                                ?>
                                                </span>
                                            </div>
                                        </div>
                                    </a>
                                    <a class="vd-item icbu-clearfix authed" href="" target="_blank">
                                        <div class="left"><i class="company-icon year-established"></i></div>
                                        <div class="right">
                                            <div class="ver-name">
                                                Year Established
                                            </div>
                                            <div class="ver-content icbu-clearfix">
                                                <span class="con-text" title="<?php echo $company->year_of_register;?>"><?php echo $company->year_of_register;?></span>
                                            </div>
                                        </div>
                                    </a>
                                    <a class="vd-item icbu-clearfix" href="" target="_blank">
                                        <div class="left"><i class="company-icon business-type"></i></div>
                                        <div class="right">
                                            <div class="ver-name">
                                                Business Type
                                            </div>
                                            <div class="ver-content icbu-clearfix"><span class="con-text"
                                                title="Trading Company"><?php echo $company->company_type;?></span></div>
                                        </div>
                                    </a>
                                    <a class="vd-item icbu-clearfix" href="" target="_blank">
                                        <div class="left"><i class="company-icon main-products"></i></div>
                                        <div class="right">
                                            <div class="ver-name">
                                                Main Products
                                            </div>
                                            <div class="ver-content icbu-clearfix">
                                                <span class="con-text" title="<?php echo implode(",",json_decode($company->main_products));?>">
                                                    <?php echo implode(",",json_decode($company->main_products));?>
                                                </span>
                                            </div>
                                        </div>
                                    </a>
                                    <a class="vd-item icbu-clearfix" href="" target="_blank">
                                        <div class="left"><i class="company-icon accepted-payment-type"></i></div>
                                        <div class="right">
                                            <div class="ver-name">
                                                Accepted Payment Type
                                            </div>
                                            <div class="ver-content icbu-clearfix">
                                                <span class="con-text" title="">
                                                    <?php echo implode(json_decode($company->accepted_payment_types));?>
                                                </span>
                                            </div>
                                        </div>
                                    </a>
                                    <a class="vd-item icbu-clearfix" href="" target="_blank">
                                        <div class="left"><i class="company-icon component"></i></div>
                                        <div class="right">
                                            <div class="ver-name">
                                                Main Markets
                                            </div>
                                            <div class="ver-content icbu-clearfix"><span class="con-text"
                                                title=""></span>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <!--<div class="company-images">
                                    <a class="image-item" href="" target="_blank">
                                        <div
                                            class="next-row next-row-no-padding next-row-justify-center next-row-align-center image-wrapper">
                                            <img src="#">
                                        </div>
                                    </a>
                                </div>-->
                                <div class="next-row next-row-justify-center next-row-align-center contact-actions">
                                    <a
                                        href=""
                                        target="_blank" class="contact-item" title="Click to send an inquiry" data-spm="dmsg"
                                        data-domdot="id:2931">
                                        <button type="button"
                                            class="next-btn next-btn-primary next-btn-large message">
                                            <i
                                                class="next-icon next-icon-email next-icon-medium next-icon-first contact-icon"></i>
                                            <!-- react-text: 112 -->Contact Supplier
                                            <!-- /react-text -->
                                        </button>
                                    </a>
                                    <a
                                        href=""
                                        target="_blank" class="contact-item"
                                        title="Place your order online and pay to the designated bank account to get full protection"
                                        data-spm="dorder" data-domdot="id:2933">
                                        <button type="button"
                                            class="next-btn next-btn-secondary next-btn-large start-order">
                                            <!-- react-text: 115 -->Start Order
                                            <!-- /react-text -->
                                        </button>
                                    </a>
                                    <a href="" target="_blank"
                                        class="contact-item icbu-link-default">Learn more about us &gt;</a>
                                </div>
                            </div>
                            <div class="icbu-mod-wrapper with-round key-capabilities">
                                <div class="wrap-box">
                                    <div class="mod-header">
                                        <h3 class="title">Enterprise core competence</h3>
                                    </div>
                                    <div class="mod-content">
                                        <div class="capabilities-content">
                                            <div class="next-slick next-slick-outer next-slick-horizontal">
                                                <div draggable="true" class="next-slick-inner next-slick-initialized">
                                                    <div class="next-slick-list">
                                                        <div class="next-slick-track"
                                                            style="opacity: 1; width: 3276px; transform: translate3d(0px, 0px, 0px);">
                                                            <a class="next-slick-slide next-slick-active capability-item icbu-link-normal"
                                                                href="" target="_blank"
                                                                data-index="0" tabindex="-1" style="outline: none; width: 364px;">
                                                                <i
                                                                    class="company-icon company-rnd-capacity item-icon"></i>
                                                                <div class="item-title">R&amp;D Capability</div>
                                                                <div class="item-value"
                                                                    title="Number of R&amp;D Staff: Less than 5 People">
                                                                    <span
                                                                        class="val-title">
                                                                        Number of R&amp;D Staff

                                                                    </span>
                                                                    <span class="val-val">
                                                                        <?php echo $company->rd_staff_count;?>
                                                                    </span>
                                                                </div>
                                                            </a>
                                                            <a
                                                                class="next-slick-slide next-slick-active capability-item icbu-link-normal"
                                                                href="" target="_blank"
                                                                data-index="1" tabindex="-1" style="outline: none; width: 364px;">
                                                                <i
                                                                    class="company-icon company-trade-capacity item-icon"></i>
                                                                <div class="item-title">Trade Capability</div>
                                                                <div class="item-value" title="Export Experience: 4 years">
                                                                    <span
                                                                        class="val-title">
                                                                        Export Experience
                                                                    </span>
                                                                    <span class="val-val">
                                                                        4 years
                                                                    </span>
                                                                </div>
                                                                <div class="item-value" title="Trade Staff: 6-10 People">
                                                                    <span
                                                                        class="val-title">
                                                                        Trade Staff
                                                                    </span>
                                                                    <span class="val-val">
                                                                        <?php echo $company->trade_dep_emp_count;?>
                                                                    </span>
                                                                </div>
                                                                <div class="item-value" title="Export Percentage: 91% - 100%">
                                                                    <span class="val-title">
                                                                        Export Percentage
                                                                    </span>
                                                                    <span class="val-val">
                                                                        <?php echo $company->export_percentage;?>
                                                                    </span>
                                                                </div>
                                                            </a>
                                                            <a
                                                                class="next-slick-slide next-slick-active capability-item icbu-link-normal"
                                                                href="" target="_blank"
                                                                data-index="2" tabindex="-1" style="outline: none; width: 364px;">
                                                                <i
                                                                    class="company-icon company-qc-capacity item-icon"></i>
                                                                <div class="item-title">Quality Control</div>
                                                                <div class="item-value" title="QC Staff: Less than 5 People">
                                                                    <span class="val-title">
                                                                        QC staff
                                                                    </span>
                                                                    <span class="val-val">
                                                                        <?php echo $company->oc_staff_count;?>
                                                                    </span>
                                                                </div>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--end why choose us-->
        </div>
        <!--end root--->
        <hr>
        <footer id="ui-footer" class="ui-footer ui-footer-wrapper p-3">
            <div class="ui-footer-seo">
                <p>2019 Atzcart.com. All rights reserved. </p>
            </div>
        </footer>
        <!-- Call to Action -->
        <a class="scrolltop" href="#"><span class="fa fa-angle-up"></span></a>
        <!-- Required JavaScript Libraries -->
        <script src="http://code.jquery.com/jquery-1.11.3.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/front/js/bootstrap.min.js"></script>
        <!-- Template Specisifc Custom Javascript File -->
        <!--<script src="<?php echo base_url(); ?>assets/seller_minisite/js/custom.js"></script>-->
    </body>
</html>