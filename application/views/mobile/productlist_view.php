<html os-type="unknow">
    <head>
        <title>
            <?php echo $title ?? "Atzcart"; ?>
        </title>
        <meta charset="utf-8">
        <meta name="aplus-rate-ahot" content="0.001">
        <meta name="aplus-rate-ahot-res" content="0.001">
        <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no">
        <meta name="google-site-verification" content="nP5Df-TYNWX_nGB7Qum5d5I4cXzd3E7A2TXtZ0Y2x_Q" /> 
        <!-- tangram:128 end-->
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/mobile/mobile/pro-g.css"  type="text/css" media="all">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/mobile/css/ionicons.min.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/mobile/css/bootstrap.min.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/mobile/mobile/product-gallary.css"  type="text/css" media="all">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/mobile/css/font-awesome.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ion-rangeslider/2.3.0/css/ion.rangeSlider.min.css"/>
        
        <!-- Global site tag (gtag.js) - Google Analytics -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=UA-144123824-1"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag() {
                dataLayer.push(arguments);
            }
            gtag('js', new Date());

            gtag('config', 'UA-144123824-1');
        </script>

        <script>
            !function (f, b, e, v, n, t, s)
            {
                if (f.fbq)
                    return;
                n = f.fbq = function () {
                    n.callMethod ?
                            n.callMethod.apply(n, arguments) : n.queue.push(arguments)
                };
                if (!f._fbq)
                    f._fbq = n;
                n.push = n;
                n.loaded = !0;
                n.version = '2.0';
                n.queue = [];
                t = b.createElement(e);
                t.async = !0;
                t.src = v;
                s = b.getElementsByTagName(e)[0];
                s.parentNode.insertBefore(t, s)
            }(window, document, 'script',
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
            function gtag() {
                dataLayer.push(arguments);
            }
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

        .da a{
            text-decoration:none;
            color:#000;
            font-weight:600;
        }

        .newmodal .modal-content
        {
            border:none !important;
            border-radius:0px !important;

        }
        .newmodal .modal-dialog{
            margin:0px !important;

        }

        .left .modal-dialog {
            position: fixed;
            margin: auto;
            width: 100%;			
            -webkit-transform: translate3d(0%, 0, 0);
            -ms-transform: translate3d(0%, 0, 0);
            -o-transform: translate3d(0%, 0, 0);
            transform: translate3d(0%, 0, 0);
        }

        .left .modal-content {
            height: 100%;
            overflow-y: auto;
        }

        .left .modal-body {
            padding: 15px 15px 20px;
        }

        .left.fade .modal-dialog {
            bottom: -320px;
            -webkit-transition: opacity 0.3s linear, bottom 0.3s ease-out;
            -moz-transition: opacity 0.3s linear, bottom 0.3s ease-out;
            -o-transition: opacity 0.3s linear, bottom 0.3s ease-out;
            transition: opacity 0.3s linear, bottom 0.3s ease-out;
        }
        .left.fade.show .modal-dialog {
            bottom: 0;
        }

        /*left side*/
        .left_side .modal-dialog {
            position: fixed;
            margin: auto;
            width: 100%;
            height:100%;			
            -webkit-transform: translate3d(0%, 0, 0);
            -ms-transform: translate3d(0%, 0, 0);
            -o-transform: translate3d(0%, 0, 0);
            transform: translate3d(0%, 0, 0);
        }

        .left_side .modal-content {
            width:300px;
            height: 100%;
            overflow-y: auto;
        }
        .left_side .modal-body {
            padding: 15px 15px 20px;
        }
        .left_side.fade .modal-dialog {
            left: -320px;
            -webkit-transition: opacity 0.3s linear, left 0.3s ease-out;
            -moz-transition: opacity 0.3s linear, left 0.3s ease-out;
            -o-transition: opacity 0.3s linear, left 0.3s ease-out;
            transition: opacity 0.3s linear, left 0.3s ease-out;
        }
        .left_side.fade.show .modal-dialog {
            left: 0;
        }
        .irs--round .irs-handle{
            border:4px solid #dc3545;
        }
        .irs--round .irs-from, .irs--round .irs-to, .irs--round .irs-single{
            background-color:#dc3545;
        }
        .irs--round .irs-from:before, .irs--round .irs-to:before, .irs--round .irs-single:before{
            border-top-color:#dc3545;
        }
        .irs--round .irs-bar{
            background-color:#dc3545;
        }
        
        #loading{position:relative; height:100%; width:100%;}
        #loading img{position:absolute; top:25%; left:40%;}        
    </style>
</head>
<body>
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
                        <div class="text"><?php
                            if (isset($category_name['categories_name'])) {
                                echo $category_name['categories_name'];
                            } else {
                                echo $category_name;
                            }
                            ?></div>
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
                    <span id="search-count">Showing<?php // echo $prod_count;   ?></span>
                    <h1><?php
                        if(isset($category_name['categories_name'])) {
                            echo "<b class='text-danger'>".$category_name['categories_name']."</b>";
                        } else {
                            echo "<b class='text-danger'>".$category_name."</b>";
                        }
                        ?></h1>
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
        <div class="row m-0 text-center da">
            <div class="col-6 p-2 border-right slidemodal" >
                <a href="javascript:void(0);" class="text-danger" id="sort" data-toggle="modal" data-target="#myModal"><i class="ionicons ion-android-options"></i> Sort</a>
            </div>
            <div class="col-6 p-2">
                <a href="javascript:void(0);" class="text-danger" id="filter" data-toggle="modal" data-target="#myModal2"><i class="ionicons ion-social-buffer-outline"></i> Filter</a>
            </div>
        </div>
        <hr class="m-0">
        <div id="forbidden-notice" version="1.0.0" tag-placeholder="ai-remind" style-ready="true">
        </div>
        <div version="1.0.0" tag-placeholder="ai-qrw" style-ready="true">
        </div>

        <div id="ai-product-list" class="gallery">
            <!-- start HEre-->
            <?php
            if (empty($productlists)) {
                echo '<div class="alert-warning">
                        Oops! No products found.
                        </div>';
            } else {
                $this->load->view('mobile/data', $data['productlists']);
            }
            ?>
            <!-- End Here -->
        </div>
    </div>
</div>
 
<div id="loading" class="my-auto load-more justify-content-center align-items-center text-center" style="display:none;">
    <img id="loading-image" class="mx-auto" src="<?php echo base_url(); ?>assets/mobile/images/loader.gif" alt="Loading..." style="width:100px;" />
</div>

<!-- The Modal -->
<div class="modal newmodal left fade" id="myModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <b>SORT BY</b>
                <button type="button" class="close p-1" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                <!-- Default unchecked -->
                <div class="custom-control custom-radio">
                    <input type="radio" value="0" class="custom-control-input" id="defaultUnchecked" name="defaultExampleRadios" onChange="sortBy(this.value)" checked>
                    <label class="custom-control-label" for="defaultUnchecked">Price -- Low to High</label>
                </div>
                <div class="pt-2"></div>
                <!-- Default checked -->
                <div class="custom-control custom-radio">
                    <input type="radio" value="1" class="custom-control-input" id="defaultChecked" name="defaultExampleRadios" onChange="sortBy(this.value)">
                    <label class="custom-control-label" for="defaultChecked">Price -- High to Low</label>
                </div>
                <div class="pt-2"></div> 
            </div>
        </div>
    </div>
</div>
<!-- End Modal-->
<!-- The filter Modal -->
<div class="modal newmodal left_side fade" id="myModal2">
    <div class="modal-dialog modal-lg lab-modal-body">

        <div class="modal-content">      
            <!-- Modal Header -->
            <div class="modal-header">
                <h4> Price Filter </h4>
                <button type="button" class="close p-1" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
               <div class="filter-panel">
                   <div class="row m-0">
                        <div class="col-6">
                            <input type="number" name="min_price" id="min_price" value="" width="100px" class="form-control border text-center amount" placeholder=" &#8377 0.00 (min)" onkeyup="priceFilter()">
                        </div>
                        <div class="col-6">
                            <input type="number" name="max_price" id="max_price"  value="" width="100px" class="form-control border text-center amount" placeholder=" &#8377 0.00 (max)" onkeyup="priceFilter()">
                        </div>
                   </div>
                   <br/>
                    <p class="px-3"><input type="text" class="js-range-slider" name="my_range" value="" /></p>
                    <br/>
                     <p class="px-3"><input type="button" class="btn btn-danger btn-block" onclick="filterProducts()" value="FILTER" /></p>
                     <p class="px-3"><input type="button" class="btn btn-danger btn-block" onclick="resetFilter()" value="RESET" /></p>
               </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/mobile/js/jquery-3.2.1.min.js"></script>
<script  src="<?php echo base_url(); ?>assets/mobile/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/ion-rangeslider/2.3.0/js/ion.rangeSlider.min.js"></script>

<script>
	$(document).ready(function () {
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
	});
</script>
<script>
     
    $(".js-range-slider").change(function(){
        var price_range = $('.js-range-slider').val();
        var prices = price_range.split(";");
        $("#min_price").val(prices[0]);
        $("#max_price").val(prices[1]);   
    });
    
    $(".js-range-slider").ionRangeSlider({
        type: "double",
        min: 0,
        max: 100000,
        from: 0,
        to: 0,
        prefix: "<i class='fa fa-inr'></i> ",
        skin: "round",
        grid: true
    });
    
    
    function priceFilter(){
        var slider = $(".js-range-slider").data("ionRangeSlider");
        value1 = $("#min_price").val();
        value2 = $("#max_price").val();
        slider.update({
            from:value1,
            to: value2
        });
    }
    
    function resetFilter(){
        var slider = $(".js-range-slider").data("ionRangeSlider");
        slider.update({
            from:0,
            to:0
        });
        $("#min_price").val("");
        $("#max_price").val("");
    }
        
    function sortBy(sort){
        var cat_id = "<?php echo $this->uri->segment(3); ?>";
        $.ajax({
            url: '<?php echo site_url(); ?>home/sortProducts',
            type: 'POST',
            dataType: "json",
            beforeSend: function ()
            {
                $("#ai-product-list").html("");
                $('#myModal').modal('hide');
                $('.modal-backdrop').removeClass('modal-backdrop');
                $('.in').removeClass('in');
                $("#loading").show();
            },
            data: {sortby: sort, cat_id: cat_id},
            success: function (data) {
                $("#loading").hide();
                if (data != false) {
                    var offer_price = '';
                    var disc = '';
                    $.each(data, function (inx, obj) {
                        //console.log(obj);
                        if (obj.offer_status == "Active")
                        {
                            offer_price = '<i class="fa fa-inr"></i>' + obj.final_price1;
                            if (obj.mrp != 0 && obj.mrp != obj.final_price1) {
                                disc = " - <del> <i class='fa fa-inr'></i> " + obj.mrp + "</del><br><strong><span style='font-size:14px;color:green'>" + obj.discount + "</span></strong>";
                            }
                        } else {
                            offer_price = '<i class="fa fa-inr"></i>' + obj.final_price1;
                            if (obj.mrp != 0 && obj.mrp != obj.final_price1) {
                                disc = " - <del> <i class='fa fa-inr'></i> " + obj.mrp + "</del><br><strong><span style='font-size:14px;color:green'>" + obj.discount + "</span></strong>";
                            }
                        }
                        var html_str = '<div class="product-item ripple grid-item" id="product-' + obj.product_id + '"><a class="product-detail" rel="nofollow" href="<?php echo base_url(); ?>product/productOverview/' + obj.product_id + '"><div class="image-wrap" style="height: 143px; width: 143px;"><img alt="' + obj.product_name + '" src="' + obj.media_url + '" style="max-height: 143px; max-width: 143px;"></div><div class="product-info-wrap"><h3 class="product-title "><strong>' + obj.product_name + '</strong></h3><div class="product-moq" ><strong style="color:#000;"> ' + offer_price + ' ' + disc + '</strong></div><div class="product-price product-fob-wrap"></div><div class="bicon-wrap"><div class=""><strong style="color:#000;"> ' + offer_price + ' ' + disc + '</strong></div><img src="<?php echo base_url() . "assets/images/flags/png/in.png"; ?>" alt="" class="icon-country"><span class="country-name">INDIA</span></div></div></a><div class="product-p4p ripple" ></div><div class="list-product-p4p-wrap" data-count="1">Sponsored Listing</div><div class="contact-container"></div></div>';
                        $("#ai-product-list").append(html_str);
                    });
                };
                $('#myModal').modal('hide');
                $('.modal-backdrop').removeClass('modal-backdrop');
                $('.in').removeClass('in');
            }
        });
    }
       
function filterProducts() {
    var cat_id = "<?php echo $this->uri->segment(3); ?>";
    var price_range = $('.js-range-slider').val();
    var prices=price_range.split(";");
    $("#min_price").val(prices[0]);
    $("#max_price").val(prices[1]);
    $.ajax({
        type: 'POST',
        url: '<?php echo site_url(); ?>home/sortProducts',
        dataType: "json",
        data:{
                price_range:price_range,
                cat_id:cat_id
            },
        beforeSend: function () {
            $("#ai-product-list").html("");
            $("#loading").show();
        },
        success: function (data) {
             if (data != false) {
                    var offer_price = '';
                    var disc = '';
                    $.each(data, function (inx, obj) {
                        if (obj.offer_status == "Active")
                        {
                            offer_price = '<i class="fa fa-inr"></i>' + obj.final_price1;
                            if (obj.mrp != 0 && obj.mrp != obj.final_price1) {
                                disc = " - <del> <i class='fa fa-inr'></i> " + obj.mrp + "</del><br><strong><span style='font-size:14px;color:green'>" + obj.discount + "</span></strong>";
                            }
                        } else {
                            offer_price = '<i class="fa fa-inr"></i>' + obj.final_price1;
                            if (obj.mrp != 0 && obj.mrp != obj.final_price1) {
                                disc = " - <del> <i class='fa fa-inr'></i> " + obj.mrp + "</del><br><strong><span style='font-size:14px;color:green'>" + obj.discount + "</span></strong>";
                            }
                        }
                        $("#loading").hide();
                        var html_str = '<div class="product-item ripple grid-item" id="product-' + obj.product_id + '"><a class="product-detail" rel="nofollow" href="<?php echo base_url(); ?>product/productOverview/' + obj.product_id + '"><div class="image-wrap" style="height: 143px; width: 143px;"><img alt="' + obj.product_name + '" src="' + obj.media_url + '" style="max-height: 143px; max-width: 143px;"></div><div class="product-info-wrap"><h3 class="product-title "><strong>' + obj.product_name + '</strong></h3><div class="product-moq" ><strong style="color:#000;"> ' + offer_price + ' ' + disc + '</strong></div><div class="product-price product-fob-wrap"></div><div class="bicon-wrap"><div class=""><strong style="color:#000;"> ' + offer_price + ' ' + disc + '</strong></div><img src="<?php echo base_url() . "assets/images/flags/png/in.png"; ?>" alt="" class="icon-country"><span class="country-name">INDIA</span></div></div></a><div class="product-p4p ripple" ></div><div class="list-product-p4p-wrap" data-count="1">Sponsored Listing</div><div class="contact-container"></div></div>';
                        $("#ai-product-list").append(html_str);
                    })
                }else{
                     $("#loading").hide();
                     var html_str='<div class="alert-warning">Oops! No products found.</div>';
                     $("#ai-product-list").append(html_str);
                }
                $('#myModal2').modal('hide');
            }
    });
}
</script>
<script>
 
    /* @author Ravindra Warthi 05/09/2019
       *  When User Scroll Page Load Images lazy.
       */
        $(document).ready(function () {
          var page=0;
        $(window).scroll(function () {
            if ($(window).scrollTop() + $(window).height() >= $(document).height() * 0.85) {
                page++;
                loadMoreData(page);
            }
        });
    });

    function loadMoreData(page){
        
        var category  = "<?php echo $this->uri->segment(3); ?>";
        var price_range = $('.js-range-slider').val();        
        $.ajax({
            url: "<?php echo site_url(); ?>m/home/loadMoreData",
            type: "post",
            dataType:"json",
            data: {
                page: page,
                category:category,
                price_range:price_range
            },
            beforeSend: function () {
                //console.log("Called");
            },
            success: function (data) {
                console.log(data);
                if (data != false) {
                       var offer_price = '';
                       var disc = '';
                       $.each(data, function (inx, obj) {
                           
                           if (obj.offer_status == "Active")
                           {
                               offer_price = '<i class="fa fa-inr"></i>' + obj.final_price1;
                               if (obj.mrp != 0 && obj.mrp != obj.final_price1) {
                                   disc = " - <del> <i class='fa fa-inr'></i> " + obj.mrp + "</del><br><strong><span style='font-size:14px;color:green'>" + obj.discount + "</span></strong>";
                               }
                           } else {
                               offer_price = '<i class="fa fa-inr"></i>' + obj.final_price1;
                               if (obj.mrp != 0 && obj.mrp != obj.final_price1) {
                                   disc = " - <del> <i class='fa fa-inr'></i> " + obj.mrp + "</del><br><strong><span style='font-size:14px;color:green'>" + obj.discount + "</span></strong>";
                               }
                           }
                           var html_str = '<div class="product-item ripple grid-item" id="product-' + obj.product_id + '"><a class="product-detail" rel="nofollow" href="<?php echo base_url(); ?>product/productOverview/' + obj.product_id + '"><div class="image-wrap" style="height: 143px; width: 143px;"><img alt="' + obj.product_name + '" src="' + obj.media_url + '" style="max-height: 143px; max-width: 143px;"></div><div class="product-info-wrap"><h3 class="product-title "><strong>' + obj.product_name + '</strong></h3><div class="product-moq" ><strong style="color:#000;"> ' + offer_price + ' ' + disc + '</strong></div><div class="product-price product-fob-wrap"></div><div class="bicon-wrap"><div class=""><strong style="color:#000;"> ' + offer_price + ' ' + disc + '</strong></div><img src="<?php echo base_url() . "assets/images/flags/png/in.png"; ?>" alt="" class="icon-country"><span class="country-name">INDIA</span></div></div></a><div class="product-p4p ripple" ></div><div class="list-product-p4p-wrap" data-count="1">Sponsored Listing</div><div class="contact-container"></div></div>';
                           $("#ai-product-list").append(html_str);
                       });
                   }
                }
            });
        }
      
</script>
</body>
</html>
