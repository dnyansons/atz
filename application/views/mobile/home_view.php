<?php $this->load->view("mobile/common/header"); ?>
<style>
    .category-name
    {
        padding:0px !important;
        text-align:center;
    }
    .categories .category-image
    {
        position:unset !important;
    }
    .carousel-indicators {
        left: 0;
        top: auto;
        bottom:0px;
    }
    /* The colour of the indicators */
    .carousel-indicators li {
        background: #a3a3a3;
        border-radius: 50%;
        width: 8px;
        height: 8px;
    }
    .carousel-indicators .active {
        background: #707070;
    }
    .new-markets{
        margin:0px !important;
        padding:0px !important;
        border-top:0px !important;
    }

    #search_T
    {
        cursor: pointer !important;
        width:100%;
        padding: 0px;
        border-radius: 0px;
        border:0px;
    }
    #headersearch
    {
        width:100%;
        z-index: 903; 
        display: none;
        background:none;
    }
    .site-header .search-bar .icon-wrap{
        line-height: 0px !important;
        height: 34px;
    }
    .icon-wrap {
        cursor: pointer;
        display: flex;
        height:44px;
        width: 47px;
        justify-content: center;
        align-items: center;
        background: #bd081b;
        color : white;
		}
    .price del{
        color:#000 !important;
    }
   .top-selling .product
   {
	   box-shadow: rgb(230, 231, 235) 0px 2px 3px 2px;
       border:1px solid #eaeaea;
	   border-radius:4px;
	   width:9rem;
	  
   }
.top-selling  .price {
	margin: 2px;
	padding-top:5px;
	border-radius: 4px;
	box-shadow: rgb(255, 217, 157) 0px -3px 0px 1px;
	background: #e1f8fb;
	min-height:70px;
}
</style>
<div id="contents">
    <div data-comp-name="header">
        <div class="header-wrap">
            <div class="site-header with-shadow">
                <div class="main-header" ><a class="header-item btn-search " onclick="openNav()">
                        <i class="icon ion-navicon" style="font-size:28px"></i> </a>
                    <a class="header-item logo" href="<?php echo site_url(); ?>"><img src="<?php echo base_url(); ?>assets/mobile/images/logo/logo.png" alt=""></a>
                    <a
                        class="header-item btn-search"><i class="iconfont-search"></i></a>
                </div>
                <a class="search-bar">
                    <button class="search-text"  id="search_T">
                        <span>Search Products</span>
                        <div class="icon-wrap"><i class="fa fa-search"></i></div>
                    </button>
                </a>
                <span data-placeholder="after__main-header"></span>
            </div>
            <div class="site-menu" style="display: none;">
                <div class="menu-mask"></div>
                <div class="menu-content" >
                    <header class="header">
                        <div class="member hide">
                            <div class="avatar"><span data-field="avatar"
                                                      style="background-image: url(&quot;&quot;);"></span></div>
                            <div class="nickname" data-field="nickname"></div>
                        </div>
                    </header>
                    <div class="list">
                        <a class="item flex home line-bottom" href="/">
                            <i class="iconfont-home-fill"></i>
							<i class="flex-1">Home</i></a><a class="item flex" href="#"><i
                                class="iconfont-message-fill"></i><i class="flex-1">Messenger</i></a><a class="item flex"
                                                                                                href="/messages/#inbox/inquiry/1"><i class="iconfont-inquery-fill"></i><i
                                class="flex-1">Inquiries</i></a><a class="item flex"
                                                           href="#"><i class="iconfont-rfq-fill"></i><i
                                class="flex-1">RFQ</i></a><span class="item flex new-download-app" data-ck="wap_ma_qq"
                                                        data-page="ma"><i class="iconfont-flash-fill"></i><i class="flex-1">Quick Quotation</i></span><a
                            class="item flex" href="#"><i class="iconfont-star-fill"></i><i
                                class="flex-1">My Favorites</i><span class="badge">3</span></a><span
                            class="item flex line-bottom new-download-app"><i
                                class="iconfont-coupon-fill"></i><i class="flex-1">My Coupons</i></span><span></span>
                        <label
                            class="item flex language">
                            <i class="iconfont-language"></i><i
                                class="flex-1">Language</i>
                            <select class="select-options">
                                <option value="EN">English</option>
                            </select>
                        </label>
                        <span></span><a class="item flex none"
                                        href="#" ><i
                                class="iconfont-off"></i><i class="flex-1">Sign out</i></a>
                        <span
                            class="item flex download-app line-top new-download-app" >
                            <i
                                class="iconfont-download"></i>
                            <div class="action flex-1">
                                <div class="flex">
                                    <h3 class="flex-1">Atzcart.com</h3>
                                    <p class="get-app flex-1">GET APP</p>
                                </div>
                                <p class="description">Greater stability and upgraded communication tools</p>
                            </div>
                        </span>
                    </div>
                    <div class="company-info">
                        <p>
                            <a href="#"rel="nofollow">Privacy Policy</a>-<a
                                href="#" rel="nofollow">Cookie
                                Setting</a>-<a href="#" rel="nofollow">Terms of Use</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <a class="search-bar">
        </a>
    </div>
    <!-- mobile menu -->
    <?php $this->load->view("mobile/common/sidebar"); ?>
    <div class="" style="background:#fff;">
        <!-- multiple slide menu -->
        <div id="page">
            <div class="header">
                <a href="#menunew"> <i class="icon ion-grid"></i> </a>
            </div>
            <div class="content" id="categorys-wrapper">
                <!-- mobile view -->
                <nav id="menunew">
                    <ul>
                        <!-- Start Home Menu-->
                        <li>
                            <a href="<?php site_url(); ?>">
                                <div class="Home dims"> </div>
                                <img class="banner-subitem-image" style="background:#bd081b; border-radius:20px; padding:8px;" src="<?php echo base_url(); ?>uploads/images/categories/home.png" width="40"> Home
                            </a>
                        </li>
                        <!--End Home Menu-->
                        <?php for ($i = 0; $i < count($all_categories); $i++) { ?>
                            <li>
                                <span>
                                    <img class="banner-subitem-image" style="background:#bd081b; border-radius:20px; padding:8px;" src="<?php echo $all_categories[$i]['image']; ?>" width="40">
                                    <?php echo $all_categories[$i]['title']; ?>
                                </span>
                                <!--2nd inner Page-->
                                <ul>
                                    <?php //print_r($all_categories[$i]['elements']); ?>
                                    <?php for ($j = 0; $j < count($all_categories[$i]['elements']); $j++) { ?>
                                        <li>
                                    <!-- <a href="<?php //echo base_url();  ?>home/productList/<?php //echo $all_categories[$i]['elements'][$j]->category_id;  ?>"><?php //echo $all_categories[$i]['elements'][$j]->categories_name;  ?>
                                            </a>-->
                                            <span><?php echo $all_categories[$i]['elements'][$j]->categories_name; ?>
                                            </span>
                                            <!-- 3rd Inner Page -->
                                            <ul>
                                                <?php for ($m = 0; $m < count($all_categories[$i]['elements'][$j]->sub); $m++) { ?>
                                                    <li><a href="<?php echo base_url(); ?>home/productList/<?php echo $all_categories[$i]['elements'][$j]->sub[$m]->category_id; ?>"><?php echo $all_categories[$i]['elements'][$j]->sub[$m]->categories_name; ?></a></li>
                                                <?php } ?>
                                            </ul>
                                            <!-- 3rd Inner Page End-->
                                        </li>
                                    <?php } ?>
                                </ul>
                                <!--2nd inner Page end-->
                            </li>
                        <?php } ?>
                        <!-- mobile view -->  
                    </ul>
                </nav>
                <!--machenry navigation -->
            </div>
        </div>
        <!-- mobile view -->
        <div class="top-banner topHEad">           
            <div id="banner">					
                <div class="swiper-container">								
                    <div class="swiper-wrapper ">
                        <?php
                        $i = 0;
                        foreach ($items as $item):
                            $aclass = "";
                            $link = "#";
                            if ($i == 0) {
                                $aclass = "swiper-slide-active";
                            }

                            if ($item["image_placed"] == "top") {
                                if ($item["type"] == "App" && $item["on_app"] == "Product") {
                                    $link = site_url() . "product/productOverview/" . $item["reference_id"];
                                } else if ($item["type"] == "App" && $item["on_app"] == "Category") {
                                    $link = site_url() . "home/productList/" . $item["reference_id"];
                                }
                                ?>	
                                <div class="swiper-slide <?php echo $aclass; ?>">
                                    <a href="<?php echo $link; ?>">
                                        <img src="<?php echo $item['image']; ?>" alt="Image" width="100%" height="100%">
                                    </a>
                                </div>
                                <?php } ?>
                            <?php
                            $i++;
                        endforeach;
                        ?>	  
                    </div> 

                    <div class="swiper-pagination"></div>
                </div>
            </div>
        </div>
        <!-- end -->
		

        <div class="categories" id="main_menu">
            <a class="category-item all-cate" href="#menunew">
                <h3 class="category-name">All Categories</h3>
                <i class="icon ion-grid" style="font-size: 33px; color: #bd081b;"></i>
            </a>
            <a class="category-item" href="<?php base_url(); ?>home/subcategory/16">
                <h3 class="category-name">
                    <span>Apparel</span>
                </h3>
                <img class="category-image lazyload" src="<?php echo base_url();?>assets/front/images/banner/kids.jpg" width="50" >
            </a>
            <a class="category-item" href="<?php base_url(); ?>home/subcategory/23">
                <h3 class="category-name">
                    <span>Consumer Electronics</span>
                </h3>
               <img class="category-image lazyload" src="<?php echo base_url();?>assets/front/images/banner/mobile.jpg" width="50" >
            </a>

            <a class="category-item" href="<?php base_url(); ?>home/subcategory/18">
                <h3 class="category-name">
                    <span>Fashion Accessories</span>
                </h3>
               <img class="category-image lazyload" src="<?php echo base_url();?>assets/front/images/banner/western.jpg" width="50" >
            </a>
        </div>
        <!-- Offer Images Showing -->
        <?php if (!empty($offer_zone)): ?>
            <div id="top_sell">
                <div class="top-selling">
                    <h3 style="background:url(<?php echo base_url()?>assets/front/images/banner/offer-img.jpg)no-repeat top center ; background-size:cover;">
                        <span class="title" style="font-size: 0.9rem; padding:1rem 10px; font-weight:550;">OFFER ZONE</span> 
                    </h3>
                    <div class="products" style="justify-content: left !important;" >
                        <?php foreach ($offer_zone as $offer): ?>
                            <a class="product" href="<?php echo base_url(); ?>home/productList/<?php echo $offer['category_id']; ?>">							
                                <div class="price">
                                    <img src="<?php echo $offer['offer_image']; ?>" data-src="">
                                    <div class="price">
                                            <?php echo $offer['title']; ?>
                                            <br/>
                                            <small><?php echo (strlen($offer['categories_name']) > 150) ? (ucwords(strtolower(substr($offer['categories_name'], 0, 150)))) . '...' : ucwords(strtolower($offer['categories_name'])); ?></small><br/>
                                       
                                        <?php
                                        if($offer['offer_type']=="flat"){
                                            echo "<strong class='text-success'> <i class='fa fa-inr'></i> ". $offer['discount_value']." OFF</strong>";
                                        }else{
                                            echo "<strong class='text-success'>". $offer['discount_value']."% OFF</strong>";
                                        }
                                        ?>
                                    </div>
                                    <div class="price1">
                                        <div class="text-success" data-countdown="<?php echo $offer['offer_end_time'] ?>"></div>
                                    </div> 
                                </div>
                            </a>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        <?php endif; ?>
       <!--Offer Images End Here-->   
        
      
        <!-- 4rd -->
        <?php foreach ($trendingCats as $trendingCat):
                if(count($trendingCat['elements']) > 0) {
            ?> 
                <div id="top_sell">
                    <div class="top-selling">
                        <h3>
                            <a href="<?php echo site_url('home/productList/') . $trendingCat['id']; ?>">
                                <span class="title" style="font-size: 0.9rem; font-weight:550"><?php echo strtoupper($trendingCat['title']); ?></span>
                            </a>
                        </h3>
                        <div class="products">                           
                            <?php foreach ($trendingCat['elements'] as $fashion): ?>
                                <a class="product" href="<?php echo base_url(); ?>home/productList/<?php echo $fashion['category_id']; ?>">
                                    <div>
                                        <div class="p-image-wrap">
                                            <img class="p-image" src="<?php echo $fashion['categories_image']; ?>">
                                        </div>
                                        <div class="price">
                                            <small><?php echo (strlen($fashion['categories_name']) > 12) ? (ucwords(strtolower(substr($fashion['categories_name'], 0, 12)))) . '...' : ucwords(strtolower($fashion['categories_name'])); ?></small><br/>
                                           <?php  if(!empty($fashion['max_dis'])){ ?>
                                                <h5 class='text-success my-1'>Upto <?php echo $fashion['max_dis'];?>% OFF</h5>  
                                            <?php } ?>
                                            <?php
                                                echo "<strong>".$fashion['final_price2']."</strong></br>";
                                                if ($fashion['mrp'] != 0 && $fashion['mrp'] != $fashion['final_price2']) {
                                                     echo "<i class='fa fa-inr'></i>  <del>" . $fashion['mrp'] . "</del>";
                                                    }
                                            ?>
                                            <?php //echo $offer_discount; ?>
                                        </div>
                                        <div class="moq">
                                            <?php
                                            if ($fashion['mrp'] != 0 && $fashion['mrp'] != $fashion['final_price1']) {
                                                 echo "<strong><span class='text-success'>" . $fashion['discount'] . "% off</span></strong>";
                                            }
                                            ?>
                                        </div>
                                    </div>
                                </a>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            <?php } endforeach; ?>        	
        <!-- 5th -->
        
        <?php if (!empty($topSellings)): ?>
            <div id="top_sell">
                <div class="top-selling">
                    <h3>
                        <a href="<?php echo site_url('home/topselling');?>">
                            <span class="title" style="font-size:0.9rem;  padding:5px 10px; font-weight:550">TOP-SELLING PRODUCTS</span> 
                        </a>
                    </h3>
                    <div class="products">
                        <?php foreach ($topSellings as $topSelling): ?>
                            <a class="product" href="<?php echo base_url(); ?>product/productOverview/<?php echo $topSelling['id']; ?>">
                                   <div class="p-image-wrap">
                                    <img class="p-image" src="<?php echo $topSelling['url']; ?>" data-src="">
									</div>
									 <div class="price">
                                    
                                            <small><?php echo (strlen($topSelling['name']) > 12) ? (ucwords(strtolower(substr($topSelling['name'], 0, 12)))) . '...' : ucwords(strtolower($topSelling['name'])); ?></small><br/>
                                        <i class="fa fa-inr"></i>
                                        <?php
                                        echo "<strong>".number_format($topSelling['max_final_price'],2)."</strong>";
                                        if ($topSelling['mrp'] != 0 && $topSelling['mrp'] != $topSelling['max_final_price']) {
                                            echo " - <strong><i class='fa fa-inr'></i> <del>" . $topSelling['mrp'] . "</del></strong>";
                                        }
                                        ?>
                                  
                                    <div class="moq">
                                        <?php
                                        if ($topSelling['mrp'] != 0 && $topSelling['mrp'] != $topSelling['max_final_price']) {
                                            echo "<span class='text-success'><strong>" . $topSelling['discount'] . "</strong></span>";
                                        }
                                        ?>
                                    </div>
                                </div>
                            </a>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        <?php endif; ?>
        
        <?php if ($recoms): ?>
            <div data-comp-name="recommend-floor" data-spm="mod-recommend-floor">
                <div class="recommend-floor">
                    <h2 class="title" style="font-size: 0.9rem; font-weight:550">RECOMMENDED FOR YOU</h2>
                    <div class="products">
                        <?php foreach ($recoms as $recom): ?>
                        <div class="moq">
                            <a class="product" href="<?php echo base_url(); ?>product/productOverview/<?php echo $recom['id']; ?>">
                                <div class="p-image-wrap">
                                    <div class="p-image-wrap">
                                        <img class="p-image" src="<?php echo $recom['url']; ?>" >
                                    </div>
                                </div>
                                <div class="price">
                                    <small><?php echo (strlen($recom['name']) > 12) ? (ucwords(strtolower(substr($recom['name'], 0, 12)))) . '...' : ucwords(strtolower($recom['name'])); ?></small><br/>
                                    <i class="fa fa-inr"></i> 
                                    <?php
                                    echo "<strong>".number_format($recom['min_final_price'],2)."</strong></br>";
                                    if ($recom['mrp'] != 0 && $recom['mrp'] != $recom['final_price1']) {
                                        echo "<i class='fa fa-inr'></i> <del>" . $recom['mrp'] . "</del>";
                                    }
                                    ?>
                                </div>
                                <div>
                                    <?php
                                    if ($recom['mrp'] != 0 && $recom['mrp'] != $recom['final_price1']) {
                                        echo "<strong><span class='text-success'>" . $recom['discount'] . "</span></strong>";
                                    }
                                    ?>
                                </div>
                            </a>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        <?php endif; ?>
		
        <!-- mobile view -->
        <div class="top-banner topHEad">           
            <div id="banner">					
                <div class="swiper-container">								
                    <div class="swiper-wrapper ">
                        <?php
                        $i = 0;
                        foreach ($items as $item):
                            $aclass = "";
                            $link = "#";
                            if ($i == 0) {
                                $aclass = "swiper-slide-active";
                            }
                            if ($item["image_placed"] == 'bottom') {
                                if ($item["type"] == "App" && $item["on_app"] == "Product") {
                                    $link = site_url() . "product/productOverview/" . $item["reference_id"];
                                } else if ($item["type"] == "App" && $item["on_app"] == "Category") {
                                    $link = site_url() . "home/productList/" . $item["reference_id"];
                                }
                                ?>	
                                <div class="swiper-slide <?php echo $aclass; ?>">
                                    <a href="<?php echo $link; ?>">
                                        <img src="<?php echo $item['image']; ?>" alt="Image" width="100%" height="100%">
                                    </a>
                                </div>
                            <?php
                            } $i++;
                        endforeach;
                        ?>	  
                    </div> 

                    <div class="swiper-pagination"></div>
                </div>
            </div>
        </div>
        <!-- end -->	

        <!-- 9th -->
        <div data-comp-name="recommend-list">
            <div class="recommend-list">

                <?php if (!empty($justforyous)) { ?>
                    <h2 class="module-title">RECOMMENDED FOR YOU</h2>
                    <div class="content" data-spm="mod-recommend-list-product">
                        <?php foreach ($justforyous as $just): ?>
                            <a class="product" href="<?php echo base_url(); ?>product/productOverview/<?php echo $just['product_id']; ?>">
                                <div class="teletext"><img
                                        src="<?php echo $just['media_url']; ?>"
                                        class="main-image"></div>
                                <div class="additional">
                                    <div class="price">
                                        <small><?php echo (strlen($just['name']) > 12) ? (ucwords(strtolower(substr($just['name'], 0, 12)))) . '...' : ucwords(strtolower($just['name'])); ?></small><br/>
                                        <i class="fa fa-inr"></i> 
                                        <?php
                                        echo "<strong>".number_format($just['final_price1'],2)."</strong>";
                                        if ($just['mrp'] != 0 && $just['mrp'] != $just['final_price1']) {
                                            echo "<br /> - <i class='fa fa-inr'></i> <del>" . $just['mrp'] . "</del>";
                                        }
                                        ?>
                                    </div>
                                    <div class="moq">
                                        <?php
                                        if ($just['mrp'] != 0 && $just['mrp'] != $just['final_price1']) {
                                            echo "<strong><span class='text-success'>" . $just['discount'] . "</span></strong>";
                                        }
                                        ?>
                                    </div>
                            </div><br>
                        </a>
                    <?php endforeach; ?>
                </div>
                <?php }?>

            </div>
        </div>
    </div>
    <!-- Search Page Start page-->
    <div id="headersearch" class="headersearch">
        <div data-comp-name="header">
            <div class="header-wrap">
                <div class="site-search site-search1" style="display: block;">
                    <div class="search-header">
                        <a  href="<?php echo site_url(); ?>" class="back-btn" >
                            <i class="icon ion-android-arrow-back"></i>
                        </a>
<!--                        <form action="<?php //echo base_url(); ?>home/mob_search_product" class="form-wrap" method="post" id="keyword_form">-->
                              <input name="searchText" id="searchText" type="search"
                               placeholder="What are you looking for.." autocorrect="off" autocomplete="off"
                               autocapitalize="off" autofocus >
                                <div class="icon-wrap"><i class="fa fa-search" id="keyword_search"></i></div>
<!--                        </form>-->
                                <a class="clear-btn"
                                       style="display: none;"><i class="iconfont-close"></i>
                                </a>
                    </div>
                    <div class="search-content pagescroll" id="load_view">
                        <div class="history">
                            <div class="keywords-title pl-3"> Search result for category:  </div>
                            <div id="search_histroy">
                                <?php 
//                                  $recents=array_reverse($_SESSION['recent']);
//                                   foreach($recents as $recent){?>  
<!--                                        <a href="<?php //echo base_url(); ?>home/productList/16" class="tag"><i class="ionicons ion-ios-search-strong"></i> <?php //echo $recent; ?> <i class="arr ionicons ion-arrow-up-c"></i></a>-->
                                <?php //} ?>
                                <a href="<?php echo base_url(); ?>home/productList/16" class="tag"><i class="ionicons ion-ios-search-strong"></i>Apparel<i class="arr ionicons ion-arrow-up-c"></i></a>
                                <a href="<?php echo base_url(); ?>home/productList/6" class="tag"><i class="ionicons ion-ios-search-strong"></i>Electronic<i class="arr ionicons ion-arrow-up-c"></i></a>
                                <a href="<?php echo base_url(); ?>home/productList/18" class="tag"><i class="ionicons ion-ios-search-strong"></i>Fashion Accessories<i class="arr ionicons ion-arrow-up-c"></i></a>
                                <a href="<?php echo base_url(); ?>home/productList/2" class="tag"><i class="ionicons ion-ios-search-strong"></i>Agriculture & Food<i class="arr ionicons ion-arrow-up-c"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <a class="search-bar">
            </a>
        </div>
    </div>
</div>

<!-- end mobile section -->
<?php $this->load->view("mobile/common/footer"); ?>
<script>
    if ($("#top_sell").is(":visible")) {

        $("#indmarket").removeClass("new-markets");

    } else
    {
        $("#indmarket").addClass("new-markets");
    }

    $(document).on("click", "#search_T", function () {
        document.getElementById("headersearch").style.display = "block";
    });
</script>
<script>
    var swiper = new Swiper('.swiper-container', {
        spaceBetween: 30,
        centeredSlides: true,
        autoplay: {
            delay: 3000,
            disableOnInteraction: false,
        },
        pagination: {
            el: '.swiper-pagination',
            clickable: true,
        },
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
    });
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

