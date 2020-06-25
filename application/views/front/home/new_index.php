<!doctype html>
<html class="no-js" lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title><?php echo $pageTitle ?? "aTz || Largest online B2B marketplace";?> </title>
        <meta name="google-site-verification" content="nP5Df-TYNWX_nGB7Qum5d5I4cXzd3E7A2TXtZ0Y2x_Q" />
        <meta name="keywords" content="<?php echo $keywords;?>">
        <meta name="description" content="<?php echo $description;?>">
        <link rel="icon" href="<?php echo base_url(); ?>assets/admin/images/favicon.ico" type="image/x-icon">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/front/css/bootstrap.min.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/front/css/font-awesome.min.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/front/css/ionicons.min.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/front/css/css-plugins-call.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/front/css/main.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/front/css/responsive.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/front/css/colors.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/front/css/demo.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/front/css/jquery.mmenu.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/front/css/swiper.min.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/front/css/all-comman.css?v=0.1">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/front/css/bundle.css">
        <link href="<?php echo base_url(); ?>assets/front/css/customheader.css" rel="stylesheet">
    </head>
    <body id="overlay">
        <div class="d-block d-sm-none">
            <div class="header-wrap demonavheader">
                <div class="site-header with-shadow">
                    <div class="main-header">
                        <a class="header-item btn-search " onclick="openNav()"><i class="fa fa-bars"></i></a>
                        <a class="header-item logo" href=""><img src="<?php echo base_url(); ?>assets/front/images/logo/logo.png" alt=""></a>
                    </div>
                    <div class="search-text">
                        <div class="search-bar">
                            <div class="searchbar">
                                <input class="search_input" type="text" name="" placeholder="Search...">
                                <a href="#" class="search_icon"><i class="fa fa-search"></i></a>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <header class="header-area main-header home-three">
            <!-- Header top area start -->
            <div class="header-top-area home-one ">
                <div class="container">
                    <div class="row">
                        <div class= "col-12">
                            <div class="top-bar-left">
                                <div class="topbar-nav pull-left">
                                    <div class="wpb_wrapper">
                                        <div class="menu-my-account-container">
                                            <!-- site-logo -->
                                            <div class="site-logo">
                                                <a href="<?php echo base_url(); ?>"><img src="<?php echo base_url(); ?>assets/front/images/logo/logo.png" alt="atz" width="130" class="img-fluid"></a>
                                            </div>
                                        </div>
                                        <!-- Suppliers by Regions drop down -->
                                        <div class="J-sc-hd-m-beaconnav sc-hd-cell sc-hd-hide-s sc-hd-m-beaconnav">
                                            <nav class="navbar-expand-sm ">
                                                <ul class="navbar-nav">
                                                    <li class="J-sc-hd-ms-sourcing-solutions sc-hd-ms-dp-trigger nav-item">
                                                        <span class="J-hd-beaconnav-title sc-hd-ms-title nav-link">
                                                            Sourcing Solutions
                                                            <i class="icon ion-ios-arrow-down"></i>
                                                        </span>
                                                        <div class="sc-hd-ms-hover">
                                                            <div class="J-hd-beaconnav-links sc-hd-ms-links">
                                                                <ul style="">
                                                                    <li class="J-beacon-link-group sc-hd-ms-lv1-title">
                                                                        <span>Search For</span>
                                                                    </li>
                                                                    <li>
                                                                        <a  href="<?php echo base_url(); ?>top-selected-supplier"  rel="nofollow" title="Top Selected Suppliers">
                                                                            Top Selected Suppliers
                                                                        </a>
                                                                    </li>
                                                                    <li><a href="#" title="Suppliers by Regions">

                                                                            Suppliers by Regions
                                                                        </a>
                                                                    </li>
                                                                    <!--<li><a href="<?php echo base_url(); ?>ecommerce-buyers-zone"
                                                                       rel="nofollow" title="eCommerce Buyers Zone">
                                                                       eCommerce Buyers Zone
                                                                       </a>
                                                                    </li>-->
                                                                </ul>
                                                                <ul style="">
                                                                    <li class="J-beacon-link-group sc-hd-ms-lv1-title">
                                                                        <span>Source</span>
                                                                    </li>
                                                                    <li>
                                                                        <a href="<?php echo base_url(); ?>submit-rfq"> Submit RFQ </a>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </li>
                                                    <li class="J-sc-hd-ms-services-membership sc-hd-ms-dp-trigger nav-item">
                                                        <span class="J-hd-beaconnav-title sc-hd-ms-title">
                                                            Services&nbsp;&amp; Membership
                                                            <i class="icon ion-ios-arrow-down"></i>
                                                        </span>
                                                        <div class="sc-hd-ms-hover">
                                                            <div class="J-hd-beaconnav-links sc-hd-ms-links">
                                                                <ul style="">
                                                                    <li class="J-beacon-link-group sc-hd-ms-lv1-title">
                                                                        <span>Trade Services</span>
                                                                    </li>
                                                                    <li><a href="<?php echo base_url(); ?>trade-assurance"
                                                                           rel="nofollow" title="Trade Assurance">
                                                                            Trade Assurance
                                                                        </a>
                                                                    </li>
                                                                </ul>
                                                                <ul style="">
                                                                    <li class="J-beacon-link-group sc-hd-ms-lv1-title">
                                                                        <span>Membership Services</span>
                                                                    </li>
                                                                    <li><a  href="<?php echo base_url(); ?>buyer-business-identity"
                                                                            rel="nofollow" title="Buyer Business Identity">
                                                                            Buyer Business Identity
                                                                        </a>
                                                                    </li>
                                                                    <li><a href="<?php echo base_url(); ?>supplier-membership" rel="nofollow"
                                                                           title="Supplier Membership" >
                                                                            Supplier Membership
                                                                        </a>
                                                                    </li>
                                                                </ul>
                                                                <!--                                                <ul style="">
                                                                                                                   <li class="J-beacon-link-group sc-hd-ms-lv1-title">
                                                                                                                      <span>Value-Added Services</span>
                                                                                                                   </li>
                                                                                                                   <li><a href="<?php echo base_url(); ?>submit-rfq"
                                                                                                                      rel="nofollow" title="Urgent Request">
                                                                                                                      Urgent Request
                                                                                                                      </a>
                                                                                                                   </li>
                                                                                                                   <li><a href="<?php echo base_url(); ?>submit-rfq"
                                                                                                                      rel="nofollow" title="Extra Quotes"
                                                                                                                      data-spm-anchor-id="a2700.8293689.scGlobalHomeHeader.18">
                                                                                                                      Extra Quotes
                                                                                                                      </a>
                                                                                                                   </li>
                                                                                                                </ul>-->
                                                            </div>
                                                        </div>
                                                    </li>
                                                    <li class="J-sc-hd-ms-help-community sc-hd-ms-dp-trigger nav-item">
                                                        <span class="J-hd-beaconnav-title sc-hd-ms-title">
                                                            Help&nbsp;&amp; Community
                                                            <i class="icon ion-ios-arrow-down"></i>
                                                        </span>
                                                        <div class="sc-hd-ms-hover sc-hd-ms-help">
                                                            <div class="J-hd-beaconnav-links sc-hd-ms-links">
                                                                <ul style="width:216px">
                                                                    <li class="J-beacon-link-group sc-hd-ms-lv1-title">
                                                                        <span>Help Center</span>
                                                                    </li>
                                                                    <li><a href="<?php echo base_url(); ?>help-center"
                                                                           rel="nofollow" title="For Buyers">
                                                                            For Buyers
                                                                        </a>
                                                                    </li>
                                                                    <li><a href="<?php echo base_url(); ?>for-suppliers"
                                                                           rel="nofollow" title="For Suppliers">
                                                                            For Suppliers
                                                                        </a>
                                                                    </li>
                                                                    <li><a href="<?php echo base_url(); ?>for-new-users"
                                                                           rel="nofollow" title="For New Users">
                                                                            For New Users
                                                                        </a>
                                                                    </li>
                                                                    <li><a href="<?php echo base_url(); ?>submit-a-dispute"
                                                                           rel="nofollow" title="Submit a Dispute">
                                                                            Submit a Dispute
                                                                        </a>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </nav>
                                        </div>
                                        <!-- end -->
                                    </div>

                                </div>
                            </div>
                            <div class="d-none d-sm-block float-right top-bar-right1">
                                <div class="J-hd-beaconnav-right-links sc-hd-cell sc-hd-hide-s sc-hd-m-beaconlink sc-hd-right-beacon top-bar-right" style="">
                                    <ul>

                                        <li>
                                            <a href="<?php echo base_url(); ?>welcome/get_app">
                                                Get App
                                            </a>
                                        </li>
                                        <li class="sc-hd-i-delimit"></li>
                                        <li>
                                            <a href="#">
                                                English-INR
                                            </a>
                                        </li>
                                        <!--  -->
                                    </ul>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <!-- Top bar area end -->
            <!-- Header middle area start -->
            <div class="header-middle-area home-one">
                <div class="container">
                    <div class="row">
                        <!--*********************** TOP CATEGORIES *************************************-->
                        <div class="col-xl-2  col-md-2 hidden-md hidden-sm pull-left category-wrapper">
                            <div class="categori-menu">
                                <span class="categorie-title"> Categories </span>
                                <nav>
                                    <ul class="categori-menu-list menu-hidden">
                                        <?php
                                        $tmpCnt = 0;
                                        foreach ($categories as $category):
                                            if ($tmpCnt < 10) {
                                                ?>
                                                <li>
                                                    <a href="#">
                                                        <span></span>
                                                        <?php echo $category['title']; ?>
                                                        <i class="fa fa-angle-right" aria-hidden="true"></i>
                                                    </a>
                                                    <ul class="ht-dropdown megamenu first-megamenu" style="list-style-type:none;">
                                                        <?php foreach ($category["elements"] as $level2): ?>
                                                            <li class="single-megamenu" style="list-style-type:none;">
                                                                <table>
                                                                    <tbody>
                                                                        <tr>
                                                                            <td style="color:#2192D9">
                                                                                <a class="text-info text-uppercase" href="<?php echo site_url('catalog/') . underscore($level2['title']) . "/" . $level2['id']; ?>" style="font-size: 12px; line-height:15px;">
                                                                                    <?php echo $level2['title']; ?>
                                                                                </a>
                                                                                <table>
                                                                                    <tbody>
                                                                                        <tr>
                                                                                            <td>
                                                                                                <ul class="form-group" >
                                                                                                    <?php foreach ($level2["elements"] as $level3): ?>
                                                                                                        <li style="color:black">
                                                                                                            <a href="<?php echo site_url('product-catalog/') . underscore($level3['title']) . "/" . $level3['id']; ?>" style="font-size: 12px;line-height: 22px;">
                                                                                                                <?php echo $level3['title']; ?>
                                                                                                            </a>
                                                                                                        </li>
                                                                                                    <?php endforeach; ?>
                                                                                                    <li class="text-mute">
                                                                                                        <a href="<?php echo base_url(); ?>welcome/all_categories" style="font-size: 12px;line-height: 22px;">
                                                                                                            view more
                                                                                                        </a>
                                                                                                    </li>
                                                                                                </ul>
                                                                                            </td>
                                                                                        </tr>
                                                                                    </tbody>
                                                                                </table>
                                                                            </td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </li>
                                                        <?php endforeach; ?>
                                                    </ul>
                                                </li>
                                                <?php
                                            }
                                            $tmpCnt++;
                                        endforeach;
                                        ?>
                                        <li>
                                            <a href="<?php echo base_url(); ?>welcome/all_categories"   style="color:skyblue">
                                                <span></span> ALL Categories
                                            </a>
                                        </li>
                                    </ul>
                                </nav>
                            </div>
                        </div>
                        <!--*********************** END CATEGORIES *************************************-->
                        <!--*********************** SEARCH PRODUCT *************************************-->
                        <div class="col-xl-5 col-md-6">
                            <div class="header-search clearfix">
                                <!--<div class="category-select pull-right">
                                   <select class="nice-select-menu">
                                      <option value="1" selected>Products</option>
                                   </select>
                                </div>-->
                                <div class="header-search-form">
                                    <form action="<?php echo base_url(); ?>search-product" method="post" >
                                        <input type="text" name="keyword" class="form-control search-panel" id ="keyword" onkeypress="getproducts(this.id)" placeholder="Search Product..." required autocomplete="off">
                                        <input type="hidden" name="category_hid" id="category_hid">
                                        <input type="submit" name="submit" value="Search">
                                    </form>
                                </div>
                                <div style="color:red"><?php echo form_error('keyword'); ?></div>
                                <div style="color:red"><?php echo $this->session->flashdata('product_message'); ?></div>
                            </div>
                        </div>
                        <!--*********************** END SEARCH PRODUCT *************************************-->
                        <!--*********************** SIGN IN*************************************-->
                        <div class="col-xl-5 col-md-4 d-none d-sm-block sc-hd-language">
                            <div class="sc-hd-cell sc-hd-hide-s sc-hd-m-notify sc-hd-float-r ">
                                <div class="J-hd-m-notify-tab sc-hd-ms-tab sc-hd-ms-ma J-sc-hd-ms-ma">
                                    <div class="J-hd-m-notify-tab-trigger  sc-hd-ms-trigger sc-hd-ms-unsign">
                                        <div class="sc-hd-ms-icon sc-hd-i-unsignavatar"></div>
                                        <?php $username = $this->session->userdata('user_name');
                                        if ($username) {
                                            ?>
                                            <div class="sc-hd-ms-title-top">
                                                <span class="sc-hd-sc-num"><?php echo $inquiry_count; ?></span>      
                                            </div>

                                            <div class="sc-hd-ms-title ">
                                                <?php
                                                if ($this->session->userdata('user_role') == 'seller') {
                                                    ?>
                                                    <a href="<?php echo base_url(); ?>seller/dashboard" title="My atzart"   >My atzCart</a>
                                                <?php } else { ?>
                                                    <a href="<?php echo base_url(); ?>buyer-dashboard" title="My atzart"   >My atzCart</a>
    <?php } ?>
                                            </div>

<?php } else { ?>
                                            <div class="sc-hd-ms-title-top ds-none">
                                                <span class="sc-hd-ms-login">
                                                    <a rel="nofollow" href="<?php echo base_url(); ?>login" title="Sign In"  >Sign In</a> |                         
                                                    <a href="<?php echo base_url(); ?>signup" title="Join Free"  >Join Free</a>
                                                </span>
                                            </div>
<?php } ?>
                                    </div>

                                    <div class="sc-hd-ms-panel">
<?php if ($username) { ?>
                                            <div class="sc-hd-ms-title">
                                                <div class="sc-hd-ms-act">

                                                    <a title="Sign In" href="<?php echo base_url(); ?>logout"   >Sign Out</a>
                                                </div>
                                                <div class="sc-hd-ms-info">
                                                    <div class="sc-hd-ms-name" title="<?php echo $username; ?>"><?php echo $username; ?></div>
                                                </div>
    <?php if ($inquiry_count != 0) { ?>
                                                    <div class="sc-hd-ms-notify-num">
                                                        <div class="text-left">
                                                            <div class="sc-hd-ms-msg" style="padding:0px 0px 0px 0px">
                                                                <a href="<?php echo base_url(); ?>buyer-inquiries"  >
                                                                    <span class="sc-hd-ms-text">New Inquiries </span>
                                                                    <span class="sc-hd-ms-num"><?php echo $inquiry_count; ?></span>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
    <?php } ?>
                                            </div>
                                            <br>
<?php } else { ?>
                                            <div class="sc-hd-ms-group-sign">
                                                <div class="sc-hd-ms-title">
                                                    <div class="sc-hd-ms-info">
                                                        Get started now
                                                    </div>
                                                </div>
                                                <div class="sc-hd-ms-btgroup">

                                                    <a href="<?php echo base_url(); ?>login" title="Sign In"   class="sc-hd-ms-btsignin">Sign In</a>
                                                    <div class="sc-hd-ms-split">or</div>
                                                    <a href="<?php echo base_url(); ?>signup"   class="sc-hd-ms-btjoin" title="Join Free">Join Free</a>
                                                </div>
                                                <div class="sc-hd-ms-login-wrap">
                                                    <div class="sc-hd-ms-login-title">Continue with:</div>
                                                    <div id="J-sc-hd-ms-third-login-wrap" class="sc-hd-ms-login-content">
                                                        <a href="javascript:;" attr-action="window" attr-type="facebook" class="thirdpart-login-icon icon-facebook" title="sign with facebook"></a>
                                                        <a href="javascript:;" attr-action="window" attr-type="google" class="thirdpart-login-icon icon-google" title="sign with google"></a>
                                                        <a href="javascript:;" attr-action="window" attr-type="linkedin" class="thirdpart-login-icon icon-linkedin" title="sign with linkedin">
                                                        </a>
                                                        <a href="javascript:;" attr-action="window" attr-type="twitter" class="thirdpart-login-icon icon-twitter" title="sign with twitter"></a>
                                                    </div>
                                                    <div class="sc-hd-ms-login-terms">
                                                        <label class="sc-hd-ck-label sc-ck-disabled">
                                                            <input class="sc-hd-ck" type="checkbox" disabled="disabled" checked="checked">
                                                            <span class="sc-hd-ck-txt">
                                                                Iagree to 
                                                                <a href="<?php echo site_url(); ?>policies-rules"  >

                                                                    Free Membership Agreement</a>
                                                            </span>
                                                        </label>
                                                        <label class="sc-hd-ck-label sc-ck-disabled">
                                                            <input class="sc-hd-ck" type="checkbox" disabled="disabled" checked="checked">
                                                            <span class="sc-hd-ck-txt">
                                                                Iagree to 

                                                                <a href="<?php echo site_url(); ?>policies-rules">

                                                                    Receive Marketing Materials</a>
                                                            </span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php } ?>
                                        <?php
                                        if ($this->session->userdata('user_role') == 'seller') {
                                            ?>
                                            <a class="sc-hd-ms-maentry"   href="<?php echo base_url(); ?>seller/dashboard">
                                                My ATZCart&nbsp;&nbsp;<i class="sc-hd-i-arr-r"></i>
                                            </a>
                                            <a class="sc-hd-ms-maentrys"   href="//message.atzcart.com/message/default.htm#feedback/all" rel="nofollow" data-val="">
                                            </a>
                                            <a class="sc-hd-ms-maentrys"   href="<?php echo base_url(); ?>seller/rfqs" rel="nofollow" data-val="Manage RFQ">
                                                Manage RFQ
                                            </a>
                                            <a class="sc-hd-ms-maentrys"   href="<?php echo base_url(); ?>seller/orders" rel="nofollow" data-val="My Orders">
                                                My Orders
                                            </a>
                                            <a class="sc-hd-ms-maentrys"   href="<?php echo base_url(); ?>seller/myaccount" rel="nofollow" data-val="My Account">
                                                My Account
                                            </a>
                                            <a class="sc-hd-ms-maentrys"   href="<?php echo base_url(); ?>supplier_membership" rel="nofollow" data-val="Supplier Membership">
                                                Supplier Membership
                                            </a>
<?php } else { ?>
                                            <a class="sc-hd-ms-maentry"   href="<?php echo base_url(); ?>buyer-dashboard">
                                                My ATZCart&nbsp;&nbsp;<i class="sc-hd-i-arr-r"></i>
                                            </a>

<?php } ?>

                                    </div>
                                </div>
<?php if ($username && $this->session->userdata('user_role') == 'buyer') { ?>
                                    <div class="J-hd-m-notify-tab sc-hd-ms-tab sc-hd-ms-order J-sc-hd-ms-order" >
                                        <div class="J-hd-m-notify-tab-trigger sc-hd-ms-trigger sc-hd-ms-last" >
                                            <a class="sc-hd-ms-icon sc-hd-i-taorder"  href="#"  ></a>
                                            <div class="sc-hd-ms-title-top" title="Orders">
                                                <span class="sc-hd-sc-num sc-hd-ms-zero" ><?php echo $orders_count->orders_status; ?></span>
                                            </div>
                                            <div class="sc-hd-ms-title" title="Orders">
                                                <a href="<?php echo base_url(); ?>buyer-orders"  >Orders</a>
                                            </div>
                                        </div>
                                        <div class="sc-hd-ms-panel sc-hd-ms-last">
                                            <div class="sc-hd-ms-order-entrys">
                                                <div class="sc-hd-ms-order-entry"><a href="<?php echo base_url(); ?>buyer-orders">My Orders(<?php echo $pending_payment->pending_order_count; ?>)</a></div>
                                                <div class="sc-hd-ms-order-entry"><a href="<?php echo base_url(); ?>buyer-wallet">My Wallet</a></div>
                                                <div class="sc-hd-ms-order-entry"><a href="<?php echo base_url(); ?>buyer-coupons"   >Coupons</a></div>
                                            </div>


                                        </div>
                                    </div>
<?php } else { ?>
                                    <div class="J-hd-m-notify-tab sc-hd-ms-tab sc-hd-ms-order J-sc-hd-ms-order">
                                        <div class="J-hd-m-notify-tab-trigger sc-hd-ms-trigger sc-hd-ms-last">
                                            <a class="sc-hd-ms-icon sc-hd-i-taorder" href="#"  ></a>
                                            <div class="sc-hd-ms-title  ds-none" title="Order <br/> Protection">
                                                <a href=""  >
                                                    Order <br> Protection
                                                </a>
                                            </div>
                                        </div>
                                        <div class="sc-hd-ms-panel sc-hd-ms-last">
                                            <div class="sc-hd-ms-full-ver ">
                                                <a href="<?php echo base_url(); ?>trade-assurance"  >
                                                    <ul class="sc-hd-ms-kps">
                                                        <li class="sc-hd-ms-kp"><i class="sc-hd-i-dot"></i>Multiple Safe Payment Options</li>
                                                        <li class="sc-hd-ms-kp"><i class="sc-hd-i-dot"></i>Worry-Free Shipping &amp; Quality</li>
                                                        <li class="sc-hd-ms-kp"><i class="sc-hd-i-dot"></i>Build Your Credibility</li>
                                                    </ul>
                                                </a>
                                            </div>
                                        </div>
                                    </div>

<?php } ?>
                                <!--********************** ADD TO FAVORITE *************************************-->
                                <div class="J-hd-m-notify-tab sc-hd-ms-tab sc-hd-ms-favorite J-sc-hd-ms-favorite" data-tab="favorite">
                                    <div class="J-hd-m-notify-tab-trigger J-hd-m-notify-tab-favorite-wrap sc-hd-ms-trigger sc-hd-ms-last"
                                         data-tab="favorite">
                                        <a class="sc-hd-ms-icon sc-hd-i-favorite"
                                           href="<?php echo base_url(); ?>favorite" 
                                           title="Favorites"></a>
                                        <div class="J-sc-hd-num-wrap sc-hd-ms-title-top" title="Favorites">
                                            <span class="J-sc-hd-num sc-hd-sc-num sc-hd-ms-zero" id="fav_count"><?php echo $fav_count; ?></span>
                                        </div>
                                        <div class="sc-hd-ms-title  ds-none" title="Favorites">
                                            <a href="<?php echo base_url(); ?>favorite"  
                                               data-val="Favorites"> Favorites</a>
                                        </div>
                                    </div>
                                    <div class="sc-hd-ms-panel sc-hd-ms-last">
                                        <div class="sc-hd-ms-actbtn sc-hd-btn-viewall">
                                            <a href="<?php echo base_url(); ?>favorite" class="sc-hd-ms-btn">
                                                View All Items
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <!--*********************** END ADD TO FAVORITE *************************************-->
                                <!--*********************** ADD TO CART *************************************-->
                                <div class="sc-hd-cell sc-hd-m-ws-cart sc-hd-float-r cartT sc-hd-cellCART" id="cart">
                                    <div data-reactroot="">
                                        <div class="alife-bc-icbu-simple-shopping-cart">
                                            <a id="dd" class="alife-bc-icbu-simple-shopping-cart-link "
                                               href=""
                                               >
                                                <div class="alife-bc-icbu-simple-shopping-cart-icon"></div>
                                                <div class="alife-bc-icbu-simple-shopping-cart-wrapper  ds-none">
                                                    <div class="alife-bc-icbu-simple-shopping-cart-count" id="cart_count"><?php echo $cart_count; ?></div>
                                                    <div class="alife-bc-icbu-simple-shopping-cart-text"><span>Cart</span></div>
                                                </div>
                                            </a>
                                            <div class="alife-bc-icbu-simple-shopping-cart-panel s-shown" >
                                                <div class="alife-bc-icbu-simple-shopping-cart-panel-con">
                                                    <div class="alife-bc-icbu-simple-shopping-cart-panel-bd">
                                                        <!-- react-text: 15 -->
                                                        <!-- /react-text -->

                                                        <div class="alife-bc-icbu-simple-shopping-cart-panel-bd-con">
                                                            <div class="alife-bc-icbu-simple-shopping-cart-valid-list" id="add_to_cart_data">
                                                                <?php
                                                                foreach ($cart_products as $c_product) {
                                                                    $title = str_replace('-', '_', $c_product['product_name']);
                                                                    $url_title = str_replace(' ', '-', $title);
                                                                    ?>
                                                                    <div class="alife-bc-icbu-simple-shopping-cart-item">
                                                                        <div class="alife-bc-icbu-simple-shopping-cart-item-supplierName"><a
                                                                                href=""><?php echo $c_product['supplierDetails']; ?></a>
                                                                        </div>
                                                                        <div class="alife-bc-icbu-simple-shopping-cart-item-spu">
                                                                            <div class="alife-bc-icbu-simple-shopping-cart-item-spu-img"><a
                                                                                    href="<?php echo base_url(); ?>product-details/<?php echo $url_title; ?>/<?php echo $c_product['product_id']; ?>"><img
                                                                                        src="<?php echo $c_product['product_image']; ?>"></a>
                                                                            </div>
                                                                            <div class="alife-bc-icbu-simple-shopping-cart-item-spu-name"><a
                                                                                    href="<?php echo base_url(); ?>product-details/<?php echo $url_title; ?>/<?php echo $c_product['product_id']; ?>"
                                                                                    title="<?php echo $c_product['product_name']; ?>"><?php echo $c_product['product_name']; ?></a></div>
                                                                                <?php
                                                                                $specification = json_decode($c_product['specifications']);

                                                                                for ($i = 0; $i < count($specification); $i++) {
                                                                                    ?>
                                                                                <div class="alife-bc-icbu-simple-shopping-cart-item-sku-list">
                                                                                    <?php
                                                                                    if ($specification[$i]->specifications->case_type > 2) {
                                                                                        for ($j = 0; $j < count($specification[$i]->specifications->secondary); $j++) {
                                                                                            ?>
                                                                                            <div class="alife-bc-icbu-simple-shopping-cart-item-sku-item ">
                                                                                                <div class="alife-bc-icbu-simple-shopping-cart-item-sku-properties">
                <?php if ($j == 0) { ?>
                                                                                                        <span
                                                                                                            class="alife-bc-icbu-simple-shopping-cart-item-sku-properties-item"><?php echo $specification[$i]->specifications->primary->spec_value; ?></span> |
                                                                                                        <span
                                                                                                            class="alife-bc-icbu-simple-shopping-cart-item-sku-properties-item"><?php echo $specification[$i]->specifications->secondary[$j]->spec_value; ?></span>
                <?php } else { ?>
                                                                                                        <span
                                                                                                            class="alife-bc-icbu-simple-shopping-cart-item-sku-properties-item"><?php echo $specification[$i]->specifications->primary->spec_value; ?></span> |
                                                                                                        <span
                                                                                                            class="alife-bc-icbu-simple-shopping-cart-item-sku-properties-item"><?php echo $specification[$i]->specifications->secondary[$j]->spec_value; ?></span>
                <?php } ?>
                                                                                                </div>
                                                                                                <div class="alife-bc-icbu-simple-shopping-cart-item-sku-price">
                                                                                                    <span>
                                                                                                        <!-- react-text: 34 -->INR.
                                                                                                        <!-- /react-text -->
                                                                                                        <!-- react-text: 35 --><?php echo $specification[$i]->specifications->unit_price; ?>
                                                                                                        <!-- /react-text -->
                                                                                                    </span>
                                                                                                    <!-- react-text: 36 -->  x
                                                                                                    <!-- /react-text -->
                                                                                                    <!-- react-text: 37 --> <?php echo $specification[$i]->specifications->secondary[$j]->quantity; ?>
                                                                                                    <!-- /react-text -->
                                                                                                </div>
                                                                                            </div>
                                                                                        <?php
                                                                                        }
                                                                                    } else if ($specification[$i]->specifications->case_type == 1) {
                                                                                        for ($j = 0; $j < count($specification[$i]->specifications->secondary); $j++) {
                                                                                            ?>
                                                                                            <div class="alife-bc-icbu-simple-shopping-cart-item-sku-item ">
                                                                                                <div class="alife-bc-icbu-simple-shopping-cart-item-sku-properties">
                                                                                                    <span class="alife-bc-icbu-simple-shopping-cart-item-sku-properties-item"><?php echo $specification[$i]->specifications->primary->specification_name; ?></span> |
                                                                                                    <span class="alife-bc-icbu-simple-shopping-cart-item-sku-properties-item"><?php echo $specification[$i]->specifications->secondary[$j]->spec_value; ?></span>
                                                                                                </div>
                                                                                                <div class="alife-bc-icbu-simple-shopping-cart-item-sku-price">
                                                                                                    <span>
                                                                                                        <!-- react-text: 34 -->INR.
                                                                                                        <!-- /react-text -->
                                                                                                        <!-- react-text: 35 --><?php echo $specification[$i]->specifications->unit_price; ?>
                                                                                                        <!-- /react-text -->
                                                                                                    </span>
                                                                                                    <!-- react-text: 36 -->  x
                                                                                                    <!-- /react-text -->
                                                                                                    <!-- react-text: 37 --> <?php echo $specification[$i]->specifications->secondary[$j]->quantity; ?>
                                                                                                    <!-- /react-text -->
                                                                                                </div>
                                                                                            </div>
            <?php }
        } else {
            ?>
                                                                                        <div class="alife-bc-icbu-simple-shopping-cart-item-sku-item ">
                                                                                            <div class="alife-bc-icbu-simple-shopping-cart-item-sku-price">
                                                                                                <span>
                                                                                                    <!-- react-text: 34 -->INR.
                                                                                                    <!-- /react-text -->
                                                                                                    <!-- react-text: 35 --><?php echo $specification[$i]->specifications->unit_price; ?>
                                                                                                    <!-- /react-text -->
                                                                                                </span>
                                                                                                <!-- react-text: 36 -->  x
                                                                                                <!-- /react-text -->
                                                                                                <!-- react-text: 37 --> <?php echo $specification[$i]->specifications->total_quantity; ?>
                                                                                                <!-- /react-text -->
                                                                                            </div>
                                                                                        </div>
                                                                        <?php } ?>
                                                                                </div>
    <?php } ?>
                                                                        </div>
                                                                    </div>
<?php } ?>
                                                            </div>
                                                            <!-- react-text: 48 -->
                                                            <!-- /react-text -->
                                                        </div>

                                                    </div>
                                                    <div class="alife-bc-icbu-simple-shopping-cart-panel-ft"><a
                                                            class="alife-bc-icbu-simple-shopping-cart-btn" href="<?php echo base_url(); ?>purchaseList"><span
                                                                >Go To
                                                                Cart</span></a>
                                                    </div>
                                                    <div class="alife-bc-icbu-simple-shopping-cart-panel-bd-bg"></div> 
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--end cart---->	
                            </div>
                        </div>
                        <!--*********************** END SIGN IN *************************************-->
                    </div>
                </div>
            </div>
            <!-- Body main wrapper start -->
            <header class="header-area sticky-header d-none d-sm-block">
                <!-- Top bar area end -->
                <!-- Header middle area start -->
                <div class="header-middle-area">
                    <div class="container" >
                        <div class="row">
                            <div class="col-xl-4   col-md-3 col-lg-3 col-xs-12  category-wrapper">
                                <div class="site-logo ">
                                    <a href="#"><img src="<?php echo base_url(); ?>assets/front/images/logo/logo.png" alt="atz" width="130" class="img-fluid"></a>

                                </div>
                            </div>
                            <div class="col-xl-8 col-md-9 col-lg-9  col-xs-12">
                                <!-- header-search -->
                                <div class="header-search clearfix">
                                    <div class="category-select pull-right">
                                        <select class="nice-select-menu">
                                            <option value="1" selected>Products</option>
                                            <!-- <option value="2">Suppliers</option>-->
                                        </select>
                                    </div>
                                    <div class="header-search-form">
                                        <form action="<?php echo base_url(); ?>search-product" method="post">
                                            <input type="text" name="keyword" class="form-control search-panel" id ="autodrop" onkeypress="getproducts(this.id)" placeholder="Search Product..." required autocomplete="off">
                                            <input type="hidden" name="category_hid" id="category_hid">
                                            <input type="submit" name="submit" value="Search">
                                        </form>
                                    </div>
                                    <div style="color:red"><?php echo form_error('keyword'); ?></div>
                                    <div style="color:red"><?php echo $this->session->flashdata('product_message'); ?></div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <!-- Header bottom area end -->
            </header>
            <!-- Header bottom area end -->
        </header>
        <div class="main" style="background:#f3f3f5 url(assets/front/images/back.png);background-repeat: no-repeat;">
            asdfasdf
        </div>
    	<div class="d-none d-sm-block">
	   <div id="J-m-trade-alert" class="m-trade-alert" data-widget-cid="widget-7">

		</div>
	</div>
   <footer id="ui-footer" class="ui-footer ui-footer-wrapper  ui-footer-background-version5">
      <hr style="border-top:1px solid #445268; background:none;">
      <ul class="ui-footer-about ui-footer-about-col3 util-clearfix">
         <li>
            <a rel="nofollow" href="">
            About atzcart.com
            </a>
         </li>
         <li>
            <a href="">
            About atzcart Group
            </a>
         </li>
         <li>
            <a href="">
            Sitemap
            </a>
         </li>
      </ul>
      <div class="ui-footer-sitemap util-clearfix" data-spm-anchor-id="a2700.8293689.0.i8.2ce265aaj5Tw1J">
         <div class="ui-footer-col ui-footer-col-first">
            <dl>
               <dt>Customer Services</dt>
               <dd><a rel="nofollow" href="<?php echo base_url(); ?>help-center" >Help Center</a></dd>
               <dd><a rel="nofollow" href="<?php echo base_url(); ?>contact-us" >Contact
                  Us</a>
               </dd>
               <dd><a rel="nofollow" href="<?php echo base_url(); ?>report-abuse" >Report
                  Abuse</a>
               </dd>
               <dd><a rel="nofollow" href="<?php echo base_url(); ?>submit-a-dispute" >Submit
                  a Dispute</a>
               </dd>
               <dd><a rel="nofollow" href="<?php echo base_url(); ?>policies-rules" >Policies &amp; Rules</a></dd>
               <!-- <dd>
                  <a rel="nofollow" href="<?php echo base_url(); ?>Customer_service/get_paid_for_facebook"
                    target="_blank">Get Paid for Your Feedback</a></dd>
                  <!--<dd><a rel="nofollow" href="//resources.atzcart.com/suggestion" target="_blank">New Buyer Guide</a></dd>
                  <dd><a rel="nofollow" href="" target="_blank">Safe Trading Guide</a></dd>-->
            </dl>
         </div>
         <div class="ui-footer-col">
            <dl>
               <dt>About Us</dt>
               <dd><a href="<?php echo base_url(); ?>about_us" >About
                  atzcart.com</a>
               </dd>
               <!--  <dd><a href="<?php echo base_url(); ?>about_us/atzcart_group" target="_blank">
                  About atzcart Group</a></dd>-->
               <!--<dd><a href="<?php echo base_url(); ?>about_us/sitemap" target="_blank">Sitemap</a></dd>-->
            </dl>
         </div>
         <div class="ui-footer-col">
            <dl>
               <dt><a rel="nofollow" href="" class="ui-footer-link">
                  Buy on atzcart.com</a>
               </dt>
               <dd><a rel="nofollow" href="<?php echo base_url(); ?>all-categories" >All
                  Categories</a>
               </dd>
               <dd><a rel="nofollow" href="<?php echo base_url(); ?>instant-quotes" >Request for
                  Quotation</a>
               </dd>
            </dl>
         </div>
         <div class="ui-footer-col">
            <dl>
               <dt><a href="<?php echo site_url();?>welcome/becomeseller">Sell on atzcart.com</a></dt>
               <dd><a href="<?php echo site_url();?>welcome/becomeseller"
                  target="_blank">Supplier Memberships</a></dd>
               <!--<dd><a rel="nofollow" href="" target="_blank">Learning
                  Center</a></dd>-->
            </dl>
         </div>
         <div class="ui-footer-col">
            <dl>
               <dt>Trade Services</dt>
               <dd><a rel="nofollow" href="<?php echo base_url(); ?>trade-assurance"
                  target="_blank">Trade Assurance</a></dd>
               <dd><a rel="nofollow" href="<?php echo base_url(); ?>buyer-business-identity" >Business
                  Identity</a>
               </dd>
               <dd><a rel="nofollow" href="<?php echo base_url(); ?>logistics-service" >Logistics
                  Service</a>
               </dd>
               <!--<dd><a rel="nofollow" href="" target="_blank">Inspection
                  Service</a></dd>-->
            </dl>
         </div>
      </div>
      
   <div class="ui-footer-seo">
    <p class="ui-footer-seo-policy">
      -
        Privacy Policy
      </a><br>
      - <a href="<?php echo base_url(); ?>policies-rules" rel="nofollow">
        Terms of Use
      </a>
      - <a href="#" rel="nofollow">Law
        Enforcement Compliance Guide</a>
    </p>

    <p class="ui-footer-copyright" style="color:#fff">
      © All Rights Reserved 2019.
    </p>
  </div>
 </footer>
<script src="https://code.jquery.com/jquery-1.11.3.min.js"></script>


<script type="text/javascript" src="<?php echo base_url(); ?>assets/front/js/popper.min.js"></script> 
<script type="text/javascript" src="<?php echo base_url(); ?>assets/front/js/bootstrap.min.js"></script> 
<script type="text/javascript" src="<?php echo base_url(); ?>assets/front/js/jquery.nivo.slider.pack.js"></script> 
<script type="text/javascript" src="<?php echo base_url(); ?>assets/front/js/plugins.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/front/js/swiper.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/front/js/jquery.mmenu.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/front/js/jquery.picZoomer.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/front/js/jquery-ui.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/front/js/main.js"></script> 
<script src="<?php echo base_url(); ?>assets/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url(); ?>assets/bower_components/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="<?php echo base_url(); ?>assets/bower_components/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
<script src="<?php echo base_url(); ?>assets/bower_components/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js"></script>
<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-141044350-1"></script>
<script>
 window.dataLayer = window.dataLayer || [];
 function gtag(){dataLayer.push(arguments);}
 gtag('js', new Date());

 gtag('config', 'UA-141044350-1');
</script>

<script type="text/javascript">

$(document).ready(function(){
    var cart_count = $("#cart_count").text();
    if(cart_count == 0)
    {
        $("#cart").hide();
    }
});
   function getproducts(mat_id)
   {
	   console.log(mat_id);
   	var mat_id2='#'+mat_id;
   	var mat_type='';
   	var getData = function (request, response) {
   	$.getJSON(
   		'<?php echo base_url("welcome/getProducthint");?>/' + request.term,
   			function (data) {
   		console.log(data);
   		response(data);
   		});
   	};
   
   	var selectItem = function (event, ui) {
   		console.log(ui);
   		$(mat_id2).val(ui.item.value);
   		$('#category_hid').val(ui.item.id);
   		return false;
   	}
   
   	$(mat_id2).autocomplete({
   		source: getData,
   		select: selectItem,
   		minLength: 1,
   		maxShowItems:5,
   		scroll:true
   	});
	
	if(mat_id == "autodrop")
	{
		$('.ui-autocomplete').addClass('autocomplete');
	}else{
		$('.ui-autocomplete').removeClass('autocomplete');
	}
	
   }
   
   $(function() {
	   $('.picZoomer').picZoomer();
	   $('.piclist li').hover(function(event){
		//alert("hello");
		   var $pic = $(this).find('img');
		   $('.picZoomer-pic').attr('src',$pic.attr('src'));
	   });
   });
   		
   		
   	$("#email_subcription").click(function(){
   		$("#loading").show();
   		var email_sub = $("#subcription_email").val();
   		if(email_sub != ''){
   				$.ajax({
   					url:'<?php echo base_url(); ?>welcome/ajaxEmailsubcription',
   					type : 'POST',
   					DataType:"json",
   					data : {email_sub:email_sub},
   					success : function(data){
   						var res = JSON.parse(data);
   						if(res.status == 2){
   							$("#email_error").text("Please Enter a Valid Email Address!!");
   							$("#subcription_email").css({"border": "1px solid #CC1414"});
   						}else if(res.status == 0){
   							$("#email_error").text("This Subscriber is Already There");
   							$("#subcription_email").css({"border": "1px solid #CC1414"});
   						}else if(res.status == 1){
   							$("#subcibe_to_trade_alert").show();
   							$("#subcribe").hide();
   							$("#success_message").show();
   						}
   						$("#loading").hide();
   					},
   					
   				});
   		}else{
   			$("#loading").hide();
   			$("#subcription_email").css({"border": "1px solid #CC1414"});
   			$("#email_error").text("Email Field is Required!!");
   		}
   	});
       
</script>
<script>
   $("#dddd td").click(function() {
   $(this).prevAll().length+1;     
   $('.anchor-wrap').removeClass('selected');
    $(this).addClass('selected');
   });
</script>
</body>
</html>