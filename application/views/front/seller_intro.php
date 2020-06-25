<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Seller : Atzcart</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="<?php echo base_url();?>/assets/admin/images/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/front/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?php echo base_url();?>assets/admin/bower_components/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/front/css/swiper.min.css"> <!-- Lity-->
    <link rel="stylesheet" href="<?php echo base_url();?>assets/front/css/seller.css" id="theme-stylesheet">
</head>
<body>
<header class="header">
    <!-- navbar-->
    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <a href="<?php echo site_url();?>" class="navbar-brand">
                <img src="<?php echo base_url();?>/assets/front/images/logo/logo.png" height="60px"/>
            </a>
            <button type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                    aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"
                    class="navbar-toggler navbar-toggler-right mt-0">
                <span class="fa fa-navicon"></span>
            </button>
            <div id="navbarSupportedContent" class="collapse navbar-collapse">
                <div class="navbar-nav ml-auto">
                    <div class="nav-item"><a href="#benefit" class="nav-link active">
                            Benefits
                            <span class="sr-only">(current)</span></a></div>
                    <div class="nav-item"><a href="#how_it_works" class="nav-link">How it works</a></div>
                    <!-- <div class="nav-item"><a href="#steps" class="nav-link">Pricing & Fees </a></div>
                     <div class="nav-item"><a href="#steps" class="nav-link">Delivering orders </a></div>-->
                    <div class="nav-item"><a href="#faq" class="nav-link">FAQ </a></div>
                </div>
            </div>
        </div>
    </nav>
</header>
<!-- Hero Section-->
<section class="hero hero-home">
    <div class="swiper-container hero-slider">
        <div class="swiper-wrapper">
            <div class="swiper-slide">
                <div style="background: url(<?php echo base_url();?>assets/admin/images/banners/selller_banner.jpg);"
                     class="hero-content has-overlay-dark">
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-8">
                                <h1>Sell your products to crores of customers across India </h1>
                                <p class="hero-text pr-5"></p>
                                <div class="CTAs">
                                    <a href="<?php echo site_url();?>createaccount" class="btn btn-primary btn-lg ">Start Selling</a>
                                    <a href="<?php echo site_url();?>login" class="btn btn-primary btn-lg ">Sign In</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="swiper-slide">
                <div style="background: url(<?php echo base_url();?>assets/admin/images/banners/seller-banner2.jpg);"
                     class="hero-content has-overlay-dark">
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-8">
                                <h1 style="">Sell your products to crores of customers across India </h1>
                                <p class="hero-text pr-5"></p>
                                <div class="CTAs"><a href="<?php echo site_url();?>createaccount" class="btn btn-primary btn-lg ">Start Selling</a>
                                    <a href="<?php echo site_url();?>login" class="btn btn-primary btn-lg ">Sign In</a></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="swiper-slide">
                <div style="background: url(<?php echo base_url();?>assets/admin/images/banners/seller-banner3.jpg);"
                     class="hero-content has-overlay-dark">
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-8">
                                <h1>Sell your products to crores of customers across India </h1>
                                <p class="hero-text pr-5"></p>
                                <div class="CTAs"><a href="<?php echo site_url();?>createaccount" class="btn btn-primary btn-lg ">Start Selling</a>
                                    <a href="<?php echo site_url();?>login" class="btn btn-primary btn-lg ">Sign In</a></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Add Pagination-->
        <div class="swiper-pagination"></div>
    </div>
</section>
<!-- Info Boxes Section-->
<section class="info-boxes">
    <div class="container">
        <div class="row"><a href=""
                            style="background: url(<?php echo base_url(); ?>assets/front/images/securad-payment.jpg);"
                            class="info-box cyan col-lg-4" onclick="return false;">
                <div class="info-box-content">
                    <h3 class="text-uppercase">SECURED PAYMENT</h3>
                    <p>Hassle Free, Safe and Highly Encrypted Payment Gateway.</p>
                </div>
            </a><a href=""
                   style="background: url(<?php echo base_url(); ?>assets/front/images/ship-order-stress-free.jpg);"
                   class="info-box orange col-lg-4" onclick="return false;">
                <div class="info-box-content">
                    <h3 class="text-uppercase">STRESS FREE SHIPPING</h3>
                    <p>All the orders will be shipped with ATZCart's trusted shipping partners</p>
                </div>
            </a><a href=""
                   style="background: url(<?php echo base_url(); ?>assets/front/images/serrive-to-help-you.jpg);"
                   class="info-box red col-lg-4" onclick="return false;">
                <div class="info-box-content">
                    <h3 class="text-uppercase">SERVICES TO HELP YOU</h3>
                    <p>ATZCART offers additional add-ons like Shipping Insurance**, PPI Wallet, 3-Tier Vendor Verification.</p>
                </div>
            </a></div>
    </div>
</section>
<!-- Intro Section-->
<section class="intro">
    <div class="container text-center">
        <header>
            <h2>Why sell on atzcart.com?</h2>
        </header>
        <div class="row">
            <p class="col-lg-8 mx-auto">ATZCART.COM is an online e-commerce marketplace where buyer will only deal with bulk orders. ATZCART is a B2B and B2C an online e-commerce marketplace. ATZCART.COM helps to empower Small and Medium sized Vendors to expand and grow their revenues and extend their reach in local markets as well as International market.</p>
        </div>
        <div class="signature mx-auto">
        </div>

    </div>
</section>

<!-- Intro Section-->
<section id="services">
    <div class="container wow fadeIn" style="visibility: visible; animation-name: fadeIn;">
        <div class="section-header">
            <h3 class="section-title">Steps</h3>
            <p class="section-description">How to sell on atzcart</p>
        </div>
        <div class="row">
            <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.2s" style="visibility: visible; animation-delay: 0.2s; animation-name: fadeInUp;">
                <div class="box">
                    <div class="icon"><a href=""><i class="fa fa-desktop"></i></a></div>
                    <h4 class="title">Registration</h4>
                    <p class="description">Fill up and follow simple registration form and verify your contact details.</p>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.4s" style="visibility: visible; animation-delay: 0.4s; animation-name: fadeInUp;">
                <div class="box">
                    <div class="icon"><a href=""><i class="fa fa-bar-chart"></i></a></div>
                    <h4 class="title">Create Company Profile</h4>
                    <p class="description"> Complete your company profile with other required details.</p>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.6s" style="visibility: visible; animation-delay: 0.6s; animation-name: fadeInUp;">
                <div class="box">
                    <div class="icon"><a href=""><i class="fa fa-paper-plane"></i></a></div>
                    <h4 class="title">Start Posting Products</h4>
                    <p class="description">On verification completion, start listing your products.</p>
                </div>
            </div>

            <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.2s" style="visibility: visible; animation-delay: 0.2s; animation-name: fadeInUp;">
                <div class="box">
                    <div class="icon"><a href=""><i class="fa fa-photo"></i></a></div>
                    <h4 class="title">Get Listed on ATZCART</h4>
                    <p class="description">Get your company profile listed on ATZCART.</p>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.4s" style="visibility: visible; animation-delay: 0.4s; animation-name: fadeInUp;">
                <div class="box">
                    <div class="icon"><a href=""><i class="fa fa-road"></i></a></div>
                    <h4 class="title">Receive Orders</h4>
                    <p class="description">Get notified to every order placed by buyer.</p>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.6s" style="visibility: visible; animation-delay: 0.6s; animation-name: fadeInUp;">
                <div class="box">
                    <div class="icon"><a href=""><i class="fa fa-shopping-bag"></i></a></div>
                    <h4 class="title">Receive Payments</h4>
                    <p class="description">Smoother settlement process for completed orders.</p>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Tour Section-->
<!-----------------New Contents -------------->
<div class="container mt-5 mb-5 py-5" id="benefit">
    <header class="text-center">
        <h2 class=" pb-3 ">Benefits?</h2>
    </header>

    <div class="row">
        <div class="col-md-6">
            <ul class="timeline">
                <li>
                    <p>Instant Inquiries on your listed Products.</p>
                </li>
                <li>
                    <p>Receive Quotation requests from buyers.</p>
                </li>
                <li>
                    <p>Grow your business with Bulk Order system.</p>
                </li>
            </ul>
        </div>
        <div class="col-md-6">
            <ul class="timeline">
                <li>
                    <p>Promote your Business with mini website feature.</p>
                </li>
                <li>
                    <p>Better Cancellations and Return policies.</p>
                </li>
            </ul>
        </div>
    </div>
</div>

<div class="demo mb-5 py-5" id="how_it_works" style="background:#f1f1f1;">
    <!-- Page Content -->
    <div class="container" >
        <header class="text-center mb-5 p-3">
            <h2>How it works?</h2>
        </header>
        <div class="row">
            <!-- Team Member 1 -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-0 shadow">
                    <div class="card-body text-center">
                        <h5 class="card-title mb-0">Step:1</h5>
                        <div class="card-text text-black-50">Register your company over ATZCart.com</div>
                    </div>
                </div>
            </div>
            <!-- Team Member 2 -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-0 shadow">
                    <div class="card-body text-center">
                        <h5 class="card-title mb-0">Step:2</h5>
                        <div class="card-text text-black-50">Get your online verification process done</div>
                    </div>
                </div>
            </div>
            <!-- Team Member 3 -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-0 shadow">

                    <div class="card-body text-center">
                        <h5 class="card-title mb-0">Step:3</h5>
                        <div class="card-text text-black-50">Start listing your products</div>
                    </div>
                </div>
            </div>
            <!-- Team Member 4 -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-0 shadow">
                    <div class="card-body text-center">
                        <h5 class="card-title mb-0">Step:4</h5>
                        <div class="card-text text-black-50">Start receiving orders against listed products</div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.row -->
    </div>
</div>
<!---demo4-->
<div class="container mt-10 py-5" id="faq">
    <header class="text-center">
        <h2>Frequently Asked Questions </h2>
    </header>
    <div class="col-md-12">
        <center>
            <div class="col-md-8 col-12">
                <div class="panel-group" id="accordion4" role="tablist" aria-multiselectable="true">
                    <div class="panel panel-default">
                        <div class="panel-heading" role="tab" id="headingOne4">
                            <h4 class="panel-title">
                                <a role="button" data-toggle="collapse" data-parent="#accordion4" href="#collapseOne4" aria-expanded="true" aria-controls="collapseOne4">
                                    Sellers registration process
                                </a>
                            </h4>
                        </div>
                        <div id="collapseOne4" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne4">
                            <div class="panel-body">
                                <ul>
                                    <li>Visit seller registration page on https://www.atzcart.com/welcome/becomeseller
                                    </li>
                                    <li>Simple fill required information.</li>
                                    <li>Verify your mobile number.</li>
                                    <li>Upload your legal documents.</li>
                                    <li>Set your order pickup address.</li>
                                    <li>Add your bank details.</li>
                                    <li>Start publishing your products.</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading" role="tab" id="headingTwo4">
                            <h4 class="panel-title">
                                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion4" href="#collapseTwo4" aria-expanded="false" aria-controls="collapseTwo4">
                                    Product Management
                                </a>
                            </h4>
                        </div>
                        <div id="collapseTwo4" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo4">
                            <div class="panel-body">
                                <ul>
                                    <li><strong>How to add product?</strong></li>
                                    <p>- To add product, a seller should be registered and verified by ATZCart's 3 tier verification system. Once the seller's account is verified then you can start posting your products using product management options from the menu bar.
                                    </p>

                                    <li><strong>When my product will get published?</strong></li>
                                    <p>- Once you entered all the required fields of the product, ATZCart product management team will review and approve the product, you will receive an approval notification over mail.
                                    </p>

                                    <li><strong>Can I change product details?</strong></li>
                                    <p>- Yes, you can change product details but it will go back for approval from ATZcart product management team.
                                    </p>

                                    <li><strong>Can I change product price?</strong></li>
                                    <p>- Yes, but on changing of product price your live product will get unlisted from website and mobile app, your product will get posted after 24 hours after approval from ATZCart product management team.
                                    </p>

                                    <li><strong>Can I unpublish my product?</strong></li>
                                    <p>- Yes. On request your product will get unpublish from site.</p>

                                    <li><strong>How many products I can publish?</strong></li>
                                    <p>- You can post many products at the initial stage, based on agreement time period, once your agreement is over, you need to subscribe for subscription based on pricing model which you want to opt.</p>

                                    <li><strong>Can I publish various category products?</strong></li>
                                    <p>- Yes. A seller can publish many products under any available category. Unless the seller and product is verified by ATZCart verification and products team.</p>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading" role="tab" id="headingThree4">
                            <h4 class="panel-title">
                                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion4" href="#collapseThree4" aria-expanded="false" aria-controls="collapseThree4">
                                    Company and site management
                                </a>
                            </h4>
                        </div>
                        <div id="collapseThree4" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree4">
                            <div class="panel-body">
                                <ul>
                                    <li><strong>How my mini-website will be designed?</strong></li>
                                    <p>- Once your fill up all the company details in profile and your profile is approved by ATZCart then system will automatically create a mini website which will get opened within ATZCart applications like official website and buyer mobile application.
                                    </p>

                                    <li><strong>When my company profile will get approved?</strong></li>
                                    <p>- On submission of all the required information, within 24-48 hours your profile will get approved by ATZCart.
                                    </p>

                                    <li><strong>Who will manage mini-website contents?</strong></li>
                                    <p>- Sellers mini website contents depends on profile completion. The more clear and accurate a seller enters it will get reflected over site.
                                    </p>

                                    <li><strong>What is mini-website?</strong></li>
                                    <p>- A mini website is an informative publicity website page for every registered seller of the ATZCart.
                                    </p>

                                    <li><strong>Can I edit my company profile?</strong></li>
                                    <p>- Yes, a seller can edit company profile. Go To My profile, click on the Edit icon and update the information.
                                    </p>

                                    <li><strong>Can I change Business Type?</strong></li>
                                    <p>- Yes, you can change your business type, on click of change business type you will be redirected to selection of business types option and update.
                                    </p>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading" role="tab" id="headingThree5">
                            <h4 class="panel-title">
                                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion4" href="#collapseThree5" aria-expanded="false" aria-controls="collapseThree5">
                                    Performance and marketing
                                </a>
                            </h4>
                        </div>
                        <div id="collapseThree5" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree5">
                            <div class="panel-body">
                                <ul>
                                    <li><strong>How do I improve my product performance?</strong></li>
                                    <p>- You can improve your product performance by entering popular product search keywords, clear product images.
                                    </p>
                                    <li><strong>How to promote my products on ATZCart.com?</strong></li>
                                    <p>- Post your all the products under ATZCart.com, all the approved products will be promoted using offers under respective category and on sellers mini website.
                                    </p>
                                    <li><strong>How my product will get listed on top?</strong></li>
                                    <p>- The maximum you opt for sellers subscription plan your product will be listed accordingly.
                                    </p>
                                    <li><strong>Where I can mention product keywords while adding new product?</strong></li>
                                    <p>- Go To post 'Product Management'> 'Create New Product'> 'Select category and sub-category'> Enter keyword in 'Meta Keywords'
                                    </p>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading" role="tab" id="headingThree6">
                            <h4 class="panel-title">
                                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion6" href="#collapseThree6" aria-expanded="false" aria-controls="collapseThree6">
                                    Seller Settlement
                                </a>
                            </h4>
                        </div>
                        <div id="collapseThree6" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree4">
                            <div class="panel-body">
                                <ul>
                                    <li><strong>What is wallet system in sellers account?</strong></li>
                                    <p>- Once the order is placed and confirmed by seller, seller wallet will display amount which will be settled towards order.
                                    </p>
                                    <li><strong>What is settlement cycle?</strong></li>
                                    <p>- Settlement cycle is a time period on completion of same payments will be disbursed towards sellers account for successful delivery of products.
                                    </p>
                                    <li><strong>How do I update my settlement account?</strong></li>
                                    <p>- Go to 'Company and Site' > select 'Bank Details' > 'Enter bank account details' or 'Select Saved bank account as default.
                                    </p>
                                    <li><strong>Why there is deductions in settlement amount?</strong></li>
                                    <p>- You have observed deductions due to dispute or return order or due to breaking terms of ATZCart sellers policies and terms.
                                    </p>
                                    <li><strong>How I can update my contact information?</strong></li>
                                    <p>- Go To 'My Account' select 'Edit Member Profile' click on 'Update' after editing new information.
                                    </p>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading" role="tab" id="headingThree7">
                            <h4 class="panel-title">
                                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion7" href="#collapseThree7" aria-expanded="false" aria-controls="collapseThree7">
                                    Trade Confidence
                                </a>
                            </h4>
                        </div>
                        <div id="collapseThree7" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree4">
                            <div class="panel-body">
                                <ul>
                                    <li><strong>How buyer will pay to me?</strong></li>
                                    <p>- ATZCart.com will accept payment on sellers behalf, the payments will be settled as per sellers contract with ATZCart.com
                                    </p>
                                    <li><strong>How to generate invoice?</strong></li>
                                    <p>- ATZCart.com system will automatically generate invoices against successfully placed orders. You can download system generated invoices against your order.
                                    </p>
                                    <li><strong>Who will pick order?</strong></li>
                                    <p>- On successful confirmation of order packing from seller side, order pickup will get registered and ATZCart.com trusted shipping partner will pickup shipment from sellers picuk address location.
                                    </p>

                                    <li><strong>How do Buyer confirms order delivery?</strong></li>
                                    <p>- To confirm order receipt, please sign in your  "All Orders" to find the order and check order status as 'Delivered'
                                        1> If you do not received the order then you can write us or contact on our helpline number.
                                        2> "Delivered" status will be available when the order is successfully delivered by our trusted shipping partner to you.
                                    </p>

                                    <li><strong>What is the meaning of 'Order Delivered'?</strong></li>
                                    <p>- Order Delivered" means your order has been shipped to your address and you have received it.
                                    </p>

                                    <li><strong>What is the available logistic method available with ATZCart.com?</strong></li>
                                    <p>- ATZCart.com is partnered with highly renowned logistic companies. Our logistic partners are verified and trusted. ATZCart.com provides logistic have road, sea and air as logistic mediums.
                                    </p>

                                    <li><strong>How to place an order?</strong></li>
                                    <p>- To place the order, a buyer should be registered with ATZCart.com. You can select the product from listed categories and click on 'start order' with required MOQ. On successfully completing payment, your order will be confirmed and delivered to your saved addresses.
                                    </p>

                                </ul>
                            </div>
                        </div>
                    </div>


                </div>
        </center>
    </div>
</div>
</div>

<!-- footer-->


<!--footer starts from here-->
<footer class="footer pt-3 sellerfooter" style="background:#445268; color:#fff;">
    <div class="container bottom_border">
        <div class="row">
            <div class="col">
                <h5 class="text-white">Customer Services</h5>
                <!--headin5_amrc-->
                <ul class="list-unstyled">
                    <li><a class="text-white" rel="nofollow" href="<?php echo base_url(); ?>help-center" >Help Center</a></li>
                    <li><a class="text-white" href="<?php echo base_url(); ?>about_us" >About
                            atzcart.com</a></li>
                    <!--<li><a rel="nofollow" href="<?php //echo base_url(); ?>contact-us" >Contact
					Us</a></li>-->
                    <li><a class="text-white" rel="nofollow" href="<?php echo base_url(); ?>submit-a-dispute" >Submit
                            a Dispute</a></li>
                    <li><a class="text-white" rel="nofollow" href="<?php echo base_url(); ?>policies-rules" >Policies &amp; Rules</a></li>
                </ul>
            </div>

            <div class="col">
                <h5 class="text-white">Buy on atzcart.com</h5>
                <!--headin5_amrc-->
                <ul class="list-unstyled">
                    <li><a class="text-white" href="<?php echo base_url(); ?>all-categories" >All
                            Categories</a></li>
                    <li><a class="text-white"  href="<?php echo base_url(); ?>submit-rfq" >Request for  Quotation</a></li>

                </ul>
                <!--footer_ul_amrc ends here-->
            </div>


            <div class="col">
                <h5 class="text-white">Sell on atzcart.com</h5>
                <!--headin5_amrc ends here-->

                <ul class="list-unstyled">
                    <li>
                        <a class="text-white" href="<?php echo site_url();?>supplier-membership"
                        >Supplier Memberships</a>
                    </li>

                </ul>
                <!--footer_ul2_amrc ends here-->
            </div>


            <div class="col">
                <h5 class="text-white">Trade Services</h5>
                <!--headin5_amrc ends here-->

                <ul class="list-unstyled">
                    <li><a rel="nofollow" class="text-white" href="<?php echo base_url(); ?>trade-assurance"
                           target="_blank">Trade Assurance</a>
                    </li>

                    <li><a class="text-white" rel="nofollow" href="<?php echo base_url(); ?>logistics-service" >Logistics
                            Service</a></li>

                </ul>
                <!--footer_ul2_amrc ends here-->
            </div>



            <div class="col">
                <h5 class="text-white">Registered Office Address:</h5>
                <!--headin5_amrc ends here-->
                <div class="text-white m-0" style="font-weight:500; font-size:13px;" >
                    <p class="text-white m-0"> ATZ CART PRIVATE LIMITED </p>
                    <p class="text-white m-0"> Midas Tower, Plot No:44, Phase 1, </p>
                    <p class="text-white m-0"> RGIP Hinjawadi, Pune, </p>
                    <p class="text-white m-0"> Maharashtra, 411057, India </p>
                    <p class="text-white m-0"> CIN : U72900PN2019PTC184043</p>
                    <p class="text-white m-0"> Toll Free: <a> 1800-212-2036 </a></p>
                    <p class="text-white "> Email: <a> helpdesk@atzcart.com</a></p>
                </div>

                <!--footer_ul2_amrc ends here-->
            </div>

        </div>
        <div class="container-fluid text-center ddd ">

            <p class="white border-top pt-2 ">
                - <a  class="text-white" href="<?php echo base_url(); ?>policies-rules#privacy_policy" rel="nofollow">
                    Privacy Policy
                </a>
                - <a  class="text-white" href="<?php echo base_url(); ?>policies-rules#terms_service" rel="nofollow">
                    Terms of Use
                </a>
            </p>

            <small class="ui-footer-copyright " style="color:#fff">
                © All rights reserved 2019.
            </small>

        </div>
    </div>

</footer>


<!-- JavaScript files-->
<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script src="<?php echo base_url(); ?>assets/front/js/popper.min.js"></script>
<script src="<?php echo base_url(); ?>assets/front/js/bootstrap.min.js"></script>
<script type="text/javascript">
    (function (factory) {
        if (typeof define === 'function' && define.amd) {
            // AMD
            define(['jquery'], factory);
        } else if (typeof exports === 'object') {
            // CommonJS
            factory(require('jquery'));
        } else {
            // Browser globals
            factory(jQuery);
        }
    }(function ($) {

        var pluses = /\+/g;

        function encode(s) {
            return config.raw ? s : encodeURIComponent(s);
        }

        function decode(s) {
            return config.raw ? s : decodeURIComponent(s);
        }

        function stringifyCookieValue(value) {
            return encode(config.json ? JSON.stringify(value) : String(value));
        }

        function parseCookieValue(s) {
            if (s.indexOf('"') === 0) {
                // This is a quoted cookie as according to RFC2068, unescape...
                s = s.slice(1, -1).replace(/\\"/g, '"').replace(/\\\\/g, '\\');
            }

            try {
                s = decodeURIComponent(s.replace(pluses, ' '));
                return config.json ? JSON.parse(s) : s;
            } catch(e) {}
        }

        function read(s, converter) {
            var value = config.raw ? s : parseCookieValue(s);
            return $.isFunction(converter) ? converter(value) : value;
        }

        var config = $.cookie = function (key, value, options) {

            // Write

            if (value !== undefined && !$.isFunction(value)) {
                options = $.extend({}, config.defaults, options);

                if (typeof options.expires === 'number') {
                    var days = options.expires, t = options.expires = new Date();
                    t.setTime(+t + days * 864e+5);
                }

                return (document.cookie = [
                    encode(key), '=', stringifyCookieValue(value),
                    options.expires ? '; expires=' + options.expires.toUTCString() : '', // use expires attribute, max-age is not supported by IE
                    options.path    ? '; path=' + options.path : '',
                    options.domain  ? '; domain=' + options.domain : '',
                    options.secure  ? '; secure' : ''
                ].join(''));
            }

            // Read

            var result = key ? undefined : {};

            // To prevent the for loop in the first place assign an empty array
            // in case there are no cookies at all. Also prevents odd result when
            // calling $.cookie().
            var cookies = document.cookie ? document.cookie.split('; ') : [];

            for (var i = 0, l = cookies.length; i < l; i++) {
                var parts = cookies[i].split('=');
                var name = decode(parts.shift());
                var cookie = parts.join('=');

                if (key && key === name) {
                    // If second argument (value) is a function it's a converter...
                    result = read(cookie, value);
                    break;
                }

                // Prevent storing a cookie that we couldn't decode.
                if (!key && (cookie = read(cookie)) !== undefined) {
                    result[name] = cookie;
                }
            }

            return result;
        };

        config.defaults = {};

        $.removeCookie = function (key, options) {
            if ($.cookie(key) === undefined) {
                return false;
            }

            // Must not alter options, thus extending a fresh object...
            $.cookie(key, '', $.extend({}, options, { expires: -1 }));
            return !$.cookie(key);
        };

    }));
</script>
<script src="<?php echo base_url(); ?>assets/front/js/swiper.min.js"></script>
<script src="https://d19m59y37dris4.cloudfront.net/university/1-1-1/vendor/bootstrap-select/js/bootstrap-select.js"></script>

<script>
    $(function () {

        // ------------------------------------------------------- //
        // Search Popup
        // ------------------------------------------------------ //
        $('a.search-btn').on('click', function () {
            $('.search').fadeIn();
        });
        $('.search .close-btn').on('click', function () {
            $('.search').fadeOut();
        });



        // ------------------------------------------------------- //
        // Bootstrap Select initialization
        // ------------------------------------------------------ //
        $('.selectpicker').selectpicker({
            size: 4
        });


        // ------------------------------------------------------- //
        // Adding fade effect to dropdowns
        // ------------------------------------------------------ //
        $('.dropdown').on('show.bs.dropdown', function () {
            $(this).find('.dropdown-menu').first().stop(true, true).fadeIn(100).addClass('active');
        });
        $('.dropdown').on('hide.bs.dropdown', function () {
            $(this).find('.dropdown-menu').first().stop(true, true).fadeOut(100).removeClass('active');
        });

        $("ul.dropdown-menu [data-toggle='dropdown']").on("click", function (event) {
            event.preventDefault();
            event.stopPropagation();

            $(this).siblings().toggleClass("show");


            if (!$(this).next().hasClass('show')) {
                $(this).parents('.dropdown-menu').first().find('.show').removeClass("show");
            }
            $(this).parents('li.nav-item.dropdown.show').on('hidden.bs.dropdown', function (e) {
                $('.dropdown-submenu .show').removeClass("show");
            });

        });


        // ------------------------------------------------------- //
        // Navbar Toggler Button
        // ------------------------------------------------------- //
        $('.navbar-toggler').on('click', function () {
            $(this).toggleClass('active');
        });


        // ------------------------------------------------------- //
        // Hero Slider
        // ------------------------------------------------------ //
        var swiper = new Swiper('.hero-slider', {
            slidesPerView: 1,
            spaceBetween: 0,
            speed: 600,
            autoplay: {
                delay: 10000,
            },
            pagination: {
                el: '.swiper-pagination',
                clickable: true
            }
        });


        // ------------------------------------------------------- //
        // Events Slider
        // ------------------------------------------------------ //
        var swiper = new Swiper('.events-slider', {
            slidesPerView: 2,
            spaceBetween: 30,
            breakpoints: {
                991: {
                    slidesPerView: 1
                }
            },
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
                dynamicBullets: true
            }
        });


        // ------------------------------------------------------- //
        // Testimonials Slider
        // ------------------------------------------------------ //
        var swiper = new Swiper('.testimonials-slider', {
            slidesPerView: 1,
            spaceBetween: 0,
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
                dynamicBullets: true
            }
        });

        // ------------------------------------------------------- //
        // Google Maps
        // ------------------------------------------------------ //
        if ($('#map').length > 0) {


            function initMap() {

                var location = new google.maps.LatLng(50.0875726, 14.4189987);

                var mapCanvas = document.getElementById('map');
                var mapOptions = {
                    center: location,
                    zoom: 16,
                    panControl: false,
                    mapTypeId: google.maps.MapTypeId.ROADMAP
                }
                var map = new google.maps.Map(mapCanvas, mapOptions);

                var markerImage = 'img/marker.png';

                var marker = new google.maps.Marker({
                    position: location,
                    map: map,
                    icon: markerImage
                });

                var contentString = '<div class="info-window">' +
                    '<h3>Info Window Content</h3>' +
                    '<div class="info-content">' +
                    '<p>Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Vestibulum tortor quam, feugiat vitae, ultricies eget, tempor sit amet, ante. Donec eu libero sit amet quam egestas semper. Aenean ultricies mi vitae est. Mauris placerat eleifend leo.</p>' +
                    '</div>' +
                    '</div>';

                var infowindow = new google.maps.InfoWindow({
                    content: contentString,
                    maxWidth: 400
                });

                marker.addListener('click', function () {
                    infowindow.open(map, marker);
                });

                var styles = [{ "featureType": "landscape", "stylers": [{ "saturation": -100 }, { "lightness": 65 }, { "visibility": "on" }] }, { "featureType": "poi", "stylers": [{ "saturation": -100 }, { "lightness": 51 }, { "visibility": "off" }] }, { "featureType": "road.highway", "stylers": [{ "saturation": -100 }, { "visibility": "simplified" }] }, { "featureType": "road.arterial", "stylers": [{ "saturation": -100 }, { "lightness": 30 }, { "visibility": "on" }] }, { "featureType": "road.local", "stylers": [{ "saturation": -100 }, { "lightness": 40 }, { "visibility": "on" }] }, { "featureType": "transit", "stylers": [{ "saturation": -100 }, { "visibility": "simplified" }] }, { "featureType": "administrative.province", "stylers": [{ "visibility": "off" }] }, { "featureType": "water", "elementType": "labels", "stylers": [{ "visibility": "on" }, { "lightness": -25 }, { "saturation": -100 }] }, { "featureType": "water", "elementType": "geometry", "stylers": [{ "hue": "#ffff00" }, { "lightness": -25 }, { "saturation": -97 }] }];

                map.set('styles', styles);


            }

            google.maps.event.addDomListener(window, 'load', initMap);


        }

        // ------------------------------------------------------ //
        // For demo purposes, can be deleted
        // ------------------------------------------------------ //

        var stylesheet = $('link#theme-stylesheet');
        $( "<link id='new-stylesheet' rel='stylesheet'>" ).insertAfter(stylesheet);
        var alternateColour = $('link#new-stylesheet');

        if ($.cookie("theme_csspath")) {
            alternateColour.attr("href", $.cookie("theme_csspath"));
        }

        $("#colour").change(function () {

            if ($(this).val() !== '') {

                var theme_csspath = 'css/style.' + $(this).val() + '.css';

                alternateColour.attr("href", theme_csspath);

                $.cookie("theme_csspath", theme_csspath, { expires: 365, path: document.URL.substr(0, document.URL.lastIndexOf('/')) });

            }

            return false;
        });


    });
</script>
<script>
    $(document).ready(function(){
        // Add smooth scrolling to all links
        $("#navbarSupportedContent a").on('click', function(event) {

            // Make sure this.hash has a value before overriding default behavior
            if (this.hash !== "") {
                // Prevent default anchor click behavior
                event.preventDefault();

                // Store hash
                var hash = this.hash;

                // Using jQuery's animate() method to add smooth page scroll
                // The optional number (800) specifies the number of milliseconds it takes to scroll to the specified area
                $('html, body').animate({
                    scrollTop: $(hash).offset().top
                }, 1000, function(){

                    // Add hash (#) to URL when done scrolling (default click behavior)
                    window.location.hash = hash;
                });
            } // End if
        });
    });
</script>
</body>
</html>