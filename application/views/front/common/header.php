<!doctype html>
<html class="no-js" lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <meta name="google-site-verification" content="nP5Df-TYNWX_nGB7Qum5d5I4cXzd3E7A2TXtZ0Y2x_Q" />
        <meta name="description" content="<?php echo $description??'';?>">
        <meta name="keywords" content="<?php echo $keywords??'';?>">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="google-site-verification" content="DASZu6WXu9Mr-eU5DzcgCCvGbIcwoPuX9wDUaVs4N_U" />
        <link rel="icon" href="<?php echo base_url(); ?>assets/images/favicon.ico" type="image/x-icon">
        <title>
        <?php 
        if($title==='default')
        {
            echo 'ATZ || Largest online B2B marketplace';
        }else{
        $page_title = $title ? $title : "ATZ || Largest online B2B marketplace";
        echo $page_title;
        }
        $this->load->model("Offer_model");
        ?>
        </title>
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/front/css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/admin/bower_components/datatables.net-bs4/css/dataTables.bootstrap4.min.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/front/css/font-awesome.min.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/front/css/ionicons.min.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/front/css/css-plugins-call.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/front/css/main.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/front/css/responsive.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/front/css/colors.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/front/css/demo.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/front/css/jquery.mmenu.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/front/css/swiper.min.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/front/css/all-comman.css?v=0.2">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/front/css/bundle.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/front/css/product_details.css">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/front/css/reset.css">
        <link href="<?php echo base_url(); ?>assets/front/css/magiczoomplus/magiczoomplus.css" rel="stylesheet" type="text/css" media="screen"/>
        <script src="<?php echo base_url(); ?>assets/front/css/magiczoomplus/magiczoomplus.js" type="text/javascript"></script>
        <link href="<?php echo base_url(); ?>assets/front/css/jquery-ui.css" rel="Stylesheet">
        <link href="<?php echo base_url(); ?>assets/front/css/customheader.css" rel="Stylesheet">

        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/front/css/all-inside-inline.css">
        <!-- Facebook Pixel Code -->
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
        <!-- Event snippet for Shopping: Buy Now conversion page -->
        <script>
          gtag('event', 'conversion', {
              'send_to': 'AW-728750276/FvTGCIuq06UBEMSxv9sC',
              'transaction_id': ''
          });
        </script>
        <style>
		.categori-menu{
			border-top: 0px !important;
			border-right: 0px !important;
			border-bottom:0px !important;
			border-left: 0px !important;
		}			

		.categori-menu {
			margin-top:8px !important;
		}
		.categori-menu-list {
			display: none;
		}
		.categori-menu:hover .categori-menu-list {
			display: block;
		}

		.dropdown-toggle::after {
		content: "";
		border:0px !important;
		}
		.dropdown-menu.show
		{
		margin-top:15px !important;
		min-width: 20rem;
		}
		.notifiation{top:15px; left:auto; right:-15px; border-radius:5px;max-width:415px}

		.notifiation ul li{ padding:10px;}
		
		.demoTrangle{
			max-height : 300px;
			overflow-y : scroll;
		}
		
		.demoTrangle:after{
			content: "";
			position: absolute;
			top: -10px;
			right:21px;
			-webkit-transform: rotate(45deg);
			transform: rotate(45deg);
			border: 10px solid #fff;
			border-right-color: transparent;
			border-bottom-color: transparent;
			-webkit-box-shadow: -10px -9px 23px 1px rgba(0,0,0,.1);
			box-shadow: -10px -9px 23px 1px rgba(0,0,0,.1);
		}		
		.badge {
			padding: 2px 4px;
			font-size: 74%;   
			line-height: 1;   
			border-radius: 1.25rem;
			top: -11px;
			position: absolute;  
			left: 6px;
			background: #bd081b;
		}	

.sidebar-headerdropdown {
    max-height: 300px;
  padding:0px;
  overflow: hidden;
  overflow-y : scroll;
}

.sidebar-headerdropdown .user-pic {  
  padding: 2px;
  border-radius: 12px; 
  overflow: hidden;
}
.sidebar-headerdropdown .user-info > span {
    color:#000;
}
.sidebar-headerdropdown .user-info a{
   color:#000;    
    text-align:left;
    font-family: Roboto;
    font-size:12px;   
    line-height: 20px;
}

 .sidebar-headerdropdown .user-info .user-role {
  font-size: 12px;
  color:#909090;
}
 .sidebar-headerdropdown .user-info .user-status {
  font-size: 11px;
  margin-top: 4px;
  
}

.sidebar-headerdropdown .user-info .user-status i {
  font-size: 11px;
  margin-right: 4px;
}
.sc-hd-m-notify .sc-hd-ms-favorite .sc-hd-btn-viewall
{
  margin:0px 5px;;
}
.sc-hd-m-notify .sc-hd-ms-favorite .sc-hd-ms-panel{width:260px;}
		#load{
    width:100%;
    height:100%;
    position:fixed;
    z-index:9999;
    background:url("<?php echo base_url();?>assets/images/loader.gif") no-repeat center center rgba(255,255,255,1);
}
        .dataTables_paginate {
            float: right !important;
        }
		
		.cart_logo img{
	float: right;
	width: 350px;
	}
	.socialbtns, .socialbtns ul, .socialbtns li {
	margin: 0;
	margin-top:-12px;
	padding:2px;
	margin-left:5px;
}

.socialbtns li {
    list-style: none outside none;
    display: inline-block;
}

.socialbtns .fa {
    color: #FFF;
	background-color:#3d495a;
	width: 40px;
    height: 40px;
    padding-top: 12px;
     transition: all ease 0.3s;
    -moz-transition: all ease 0.3s;
    -webkit-transition: all ease 0.3s;
    -o-transition: all ease 0.3s;
  	transform: rotate(-360deg);
	-moz-transform: rotate(-360deg);
	-webkit-transform: rotate(-360deg);
	-o-transform: rotate(-360deg);
  }
.socialbtns .fa:hover {
	transition: all ease 0.3s;
    -moz-transition: all ease 0.3s;
    -webkit-transition: all ease 0.3s;
    -o-transition: all ease 0.3s;
	transform: rotate(360deg);
	-moz-transform: rotate(360deg);
	-webkit-transform: rotate(360deg);
	-o-transform: rotate(360deg);
}
       .ui-autocomplete .m-icon {
			float: left;
			max-width: 32px;
		}
		.ui-autocomplete .x-icon {
			float: left;
			width: 32px;
			opacity: .5;
			font-size: 18px;
			text-align: center;
		}
.ui-autocomplete .m-name {
	display: block;
	margin-left: 40px;
}
.ui-autocomplete .small_name {
	display: block;
	margin-left: 40px;			
	font-size: 11px;
	color:#2874f0;
}
.ui-autocomplete div::after {
	content: "";
	display: table;
	clear: both;
}
.ui-widget-content {
    border:1px solid #aaaaaa !important;
   
}

.ui-menu-item-wrapper {
    padding:15px 6px;
    border: 0px !important;
    cursor: pointer;
	}
.ui-menu-item-wrapper:hover{
 background:#ececec;
 transition:all 0.2s ease-in-out;
 
}

.ui-front{
    max-height:800px;
}


		</style>
                <script>
                    var  __cfRLUnblockHandlers = true;
                </script>
                <?php if(isset($jsscripts)){
                    echo $jsscripts;
                }?>
   </head>
   <body id="overlay">
    <div id="load"></div>
      <div class="d-none">
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
      <nav class="navbar navbar-expand-md navbar-light" style="background:#FFF;border-top:1px solid #E6E7EB;">
         <div class="container-fluid px-2">
            <div class="logoH">
               <a href="<?php echo base_url(); ?>" class="nav-brand ">		
               <img src="<?php echo base_url(); ?>assets/front/images/logo/logo.png" alt="atz" width="138" class="img-fluid">
               </a>
            </div>
            <div class="col-12 col-sm-3 col-md-2 hidden-md hidden-sm pull-left category-wrapper">
               <a href="<?php echo base_url(); ?>">		
               <img src="<?php echo base_url(); ?>assets/front/images/logo/logo.png" alt="atz" width="158" class="img-fluid">
               </a>
            </div>
            <!--- end categories-->	
            <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
            <span class="navbar-toggler-icon"></span>
            </button>	
            <div class="collapse navbar-collapse justify-content-between pl-0" id="navbarCollapse">
               <!-- Suppliers by Regions drop down -->
               <div class="J-sc-hd-m-beaconnav sc-hd-hide-s sc-hd-m-beaconnav">
                  <nav class="navbar-expand-sm ">
                     <ul class="navbar-nav">
                        <li class="J-sc-hd-ms-sourcing-solutions sc-hd-ms-dp-trigger nav-item">
                           <span class="J-hd-beaconnav-title sc-hd-ms-title">
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
									
                                    <li><a href="<?php echo base_url(); ?>affiliate-marketing"
                                       rel="nofollow" title="Affiliate Marketing">
                                     Affiliate Market
                                       </a>
                                    </li>
                                 </ul>
                                 <ul style="">
                                    <li class="J-beacon-link-group sc-hd-ms-lv1-title">
                                       <span>Membership Services</span>
                                    </li>
                                    <li><a href="<?php echo base_url(); ?>supplier-membership" rel="nofollow"
                                       title="Supplier Membership" >
                                       Supplier Membership
                                       </a>
                                    </li>
                                 </ul>

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
               <div class="d-none d-sm-block float-right top-bar-right1">
                  <div class="J-hd-beaconnav-right-links sc-hd-hide-s sc-hd-m-beaconlink p-0 sc-hd-right-beacon top-bar-right" style="">			
                     <ul>	
						<?php 
						$username = $this->session->userdata('user_name');
						if($username){ ?>
                        <li class="header-notification dropdown">
                           <div class="dropdown-primary dropdown">
                              <div class="dropdown-toggle" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <a href="javascript:void(0)"><span class="fa fa-bell-o"></span>
                                 <span class="badge btn-danger notification_count">
								 <?php echo $notifiction_count ?? 0; ?>
								 </span>
								 </a>
                              </div>

								<div class="dropdown-menu notifiation"  data-dropdown-in="fadeIn" data-dropdown-out="fadeOut">
								
						      <ul class="demoTrangle">
                                 <li class="dropdown-item pl-4">
                                    Notifications
                                    <label class="label label-danger float-right btn-danger badge-pill">New</label>
                                 </li>
                                 <?php if(!empty($notifications_list)){ foreach ($notifications_list as $notification){?>
                                 <?php
                                    $type = $notification['type'];
                                    $redirect_url = '';
                                    switch ($type){
                                     case 'order_place':
									 $id = $notification['id'];
                                     $redirect_url = base_url('buyer-orders');    
                                     break;
                                    
                                     case 'order_cancel':
									 $id = $notification['id'];
                                     $redirect_url = base_url('buyer-orders');
                                     break;
                                    
                                     case 'order_return':
									 $id = $notification['id'];
                                     $redirect_url = base_url('buyer-orders');    
                                     break;
                                    
                                     case 'order_refund':
									 $id = $notification['id'];
                                     $redirect_url = base_url('buyer-orders');    
                                     break;
                                     
                                     case 'request_reject':
									 $id = $notification['id'];
                                     $redirect_url = base_url('buyer-wallet');
                                     break;
                                    
                                     case 'request_approved':
									 $id = $notification['id'];
                                     $redirect_url = base_url('buyer-wallet');
                                     break;

                                    case 'RFQ':
                                        $id = $notification['id'];
                                        $redirect_url = base_url('buyer-rfqs');
                                        break;
                                    }
                                    ?>
                                 <a href="javascript:void(0)" class="dropdown-item notification_url " data-id="<?php echo $id; ?>" data-url="<?php echo $redirect_url; ?>">
                                    <div class="media">
                                       <div class="media-body" >
                                          <h6 class="notification-user my-1 font-weight-bold"><?php echo $notification['title'];?></h6>
                                          <small class="notification-msg"><?php echo $notification['msg'];?></small>
                                       </div>
                                    </div>
                                 </a>
                                 <?php }}?>
                              </ul>
								</div>
                              
                           </div>
                        </li>
						<?php } ?>
                        <li>
                           <a href="<?php echo base_url(); ?>welcome/get_app">
                           Get App
                           </a>
                        </li>

                     </ul>
					 
                  </div>
               </div>
            </div>
         </div>
      </nav>
	  
	  
	  
      <header class="header-area main-header home-three" style="box-shadow: 2px 2px 3px rgba(0,0,0,.1);">
         <!-- Header top area start -->
         <!-- Header middle area start -->
         <div class="header-middle-area">
            <div class="container-fluid px-4">
               <div class="row">
                  <!--*********************** TOP CATEGORIES *************************************-->
                  <div class="col-12 col-sm-3 col-md-2">
                     <div class="hidden-md hidden-sm pull-left category-wrapper">
                        <div class="categori-menu">
                           <span class="categorie-title"> Categories </span>
                           <nav>
                              <ul class="categori-menu-list"  aria-labelledby="dropdownMenuButton">
                                 <?php
                                    $tmpCnt = 0;
                                    foreach ($categories as $category):
                                    	if ($tmpCnt < 10) {
                                    		?>
                                 <li class="hoverM">
                                    <a href="#" class="pl-2">
                                    <?php echo $category['title']; ?>
                                    <i class="fa fa-angle-right" aria-hidden="true"></i>
                                    </a>
                                    <ul class="ht-dropdown megamenu first-megamenu row" style="list-style-type:none;">
                                       <?php foreach ($category["elements"] as $level2): ?>
                                       <li class="single-megamenu col-6" style="list-style-type:none;">
                                          <a class="text-info text-uppercase" href="<?php echo site_url('catalog/') . underscore($level2['title']) . "/" . $level2['id']; ?>" style="font-size: 12px; line-height:15px;font-weight: 800; text-transform: unset !important;">
                                          <?php echo $level2['title']; ?>
                                          </a>
                                          <ul class="form-group">
                                             <?php 
                                                $tmpCntDEMO = 0;
                                                foreach ($level2["elements"] as $level3): 			
                                                if ($tmpCntDEMO < 6) {
                                                	?>
                                             <li style="color:black">
                                                <a href="<?php echo site_url('product-catalog/') . underscore($level3['title']) . "/" . $level3['id']; ?>" style="font-size: 12px;line-height: 22px;">
                                                <?php echo $level3['title']; ?>
                                                </a>
                                             </li>
                                             <?php 
                                                }
                                                $tmpCntDEMO++;
                                                endforeach; 
                                                ?>
                                             <li class="text-mute">
                                                <a href="<?php echo base_url(); ?>welcome/all_categories" style="font-size: 12px;line-height: 22px; color:#999;">
                                                view more
                                                </a>
                                             </li>
                                          </ul>
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
                  </div>
                  <!--*********************** END CATEGORIES *************************************-->
                  <!--*********************** SEARCH PRODUCT *************************************-->
                  <div class="col-12  col-sm-12 col-md-5">
                     <div class="header-search clearfix">
                        <!--<div class="category-select pull-right">
                           <select class="nice-select-menu">
                              <option value="1" selected>Products</option>
                           </select>
                           </div>-->
                        <div class="header-search-form">
                           <form action="<?php echo base_url(); ?>search-product" method="post">
                               <input type="text" name="keyword" class="form-control search-panel" id ="keyword" onkeypress="getproducts(this.id)"  placeholder="Search Product..." required autocomplete="off">
                              <input type="hidden" name="cat_id" id="cat_id">
                              <input type="hidden" name="type" id="type">
                              <input type="submit" name="submit" value="Search" id="searchform">
                           </form>
                        </div>
                        <div style="color:red"><?php echo form_error('keyword'); ?></div>
                        <div style="color:red"><?php echo $this->session->flashdata('product_message'); ?></div>
                     </div>
                  </div>
                  <!--*********************** END SEARCH PRODUCT *************************************-->
                  <!--*********************** SIGN IN*************************************-->
                  <div class="col-12 col-md-5 d-none d-sm-block sc-hd-language p-0">
                     <div class="sc-hd-cell sc-hd-hide-s sc-hd-m-notify sc-hd-float-r ">
                        <div class="J-hd-m-notify-tab sc-hd-ms-tab sc-hd-ms-ma J-sc-hd-ms-ma">
                           <div class="J-hd-m-notify-tab-trigger  sc-hd-ms-trigger sc-hd-ms-unsign">
                              <div class="sc-hd-ms-icon">
                                 <!--sc-hd-i-unsignavatar-->
                                 <img src="<?php echo base_url(); ?>assets/front/images/icons/user.svg" width="30">
                              </div>
                              <?php
                                 $username = $this->session->userdata('user_name');
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
                                    <a rel="nofollow" href="<?php echo base_url(); ?>login/" title="Sign In"  >Sign In <br>Join Free</a>                      
                                    <!--<a href="<?php //echo base_url();  ?>signup" title="Join Free"  >Join Free</a>-->
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
                                    <a href="<?php echo base_url(); ?>login/" title="Sign In"   class="sc-hd-ms-btsignin">Sign In</a>
                                    <div class="sc-hd-ms-split">or</div>
                                    <a href="<?php echo base_url(); ?>signup/"   class="sc-hd-ms-btjoin" title="Join Free">Join Free</a>
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
                                       I agree to 
                                       <a href="<?php echo site_url(); ?>policies-rules"  >
                                       Free Membership Agreement</a>
                                       </span>
                                       </label>
                                       <label class="sc-hd-ck-label sc-ck-disabled">
                                       <input class="sc-hd-ck" type="checkbox" disabled="disabled" checked="checked">
                                       <span class="sc-hd-ck-txt">
                                       I agree to 
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
                              <a class="sc-hd-ms-icon"  href="#"  >
                              <img src="<?php echo base_url();?>assets/front/images/icons/product.svg" width="35">
                              </a>
                              <div class="sc-hd-ms-title-top" title="Orders">
                                 <span class="sc-hd-sc-num sc-hd-ms-zero" >
                                    <?php echo $orders_count->orders_status; ?>
                                 </span>
                              </div>
                              <div class="sc-hd-ms-title" title="Orders">
                                 <a href="<?php echo base_url(); ?>buyer-orders"  >Orders</a>
                              </div>
                           </div>
                           <div class="sc-hd-ms-panel sc-hd-ms-last">
                              <div class="sc-hd-ms-order-entrys">
                                 <div class="sc-hd-ms-order-entry"><a href="<?php echo base_url(); ?>buyer-orders">My Orders</a></div>
                                 <div class="sc-hd-ms-order-entry"><a href="<?php echo base_url(); ?>buyer-wallet">My Wallet</a></div>
                                 <div class="sc-hd-ms-order-entry"><a href="<?php echo base_url(); ?>buyer-coupons"   >Coupons</a></div>
                              </div>
                           </div>
                        </div>
                        <?php } else { ?>
                        <div class="J-hd-m-notify-tab sc-hd-ms-tab sc-hd-ms-order J-sc-hd-ms-order">
                            <!-- <div class="J-hd-m-notify-tab-trigger sc-hd-ms-trigger sc-hd-ms-last">
                              <a class="sc-hd-ms-icon " href="<?php echo base_url(); ?>buyer-orders" >
                                 <img src="<?php echo base_url();?>assets/front/images/icons/product.svg" width="35">
                              </a>
                              <div class="sc-hd-ms-title  ds-none" title="Order">
                                  <a href="<?php echo base_url(); ?>buyer-orders">
                                    Orders
                                  </a>
                              </div>
                           </div>
                           <div class="sc-hd-ms-panel sc-hd-ms-last">
                              <div class="sc-hd-ms-full-ver ">
                                 <a href="<?php //echo base_url(); ?>trade-assurance"  >
                                    <ul class="sc-hd-ms-kps">
                                       <li class="sc-hd-ms-kp"><i class="sc-hd-i-dot"></i>Multiple Safe Payment Options</li>
                                       <li class="sc-hd-ms-kp"><i class="sc-hd-i-dot"></i>Worry-Free Shipping &amp; Quality</li>
                                       <li class="sc-hd-ms-kp"><i class="sc-hd-i-dot"></i>Build Your Credibility</li>
                                    </ul>
                                 </a>
                              </div>
                           </div>-->
                        </div>
                        <?php } ?>
                        <!--********************** ADD TO FAVORITE *************************************-->
                        <?php if ($this->session->userdata('user_role') == 'buyer') { ?>
                            <div class="J-hd-m-notify-tab sc-hd-ms-tab sc-hd-ms-favorite J-sc-hd-ms-favorite" data-tab="favorite">
                                <div class="J-hd-m-notify-tab-trigger J-hd-m-notify-tab-favorite-wrap sc-hd-ms-trigger sc-hd-ms-last"
                                     data-tab="favorite">
                                    <!--sc-hd-i-favorite-->
                                    <a class="sc-hd-ms-icon"
                                       href="<?php echo base_url(); ?>favorite"
                                       title="Favorites">
                                        <img src="<?php echo base_url();?>assets/front/images/icons/heart.svg" width="35">
                                    </a>
                                    <div class="J-sc-hd-num-wrap sc-hd-ms-title-top" title="Favorites">
                                        <?php if ($username) { ?>
                                            <span class="J-sc-hd-num sc-hd-sc-num sc-hd-ms-zero" id="fav_count"><?php echo $fav_count; ?></span>
                                        <?php } else { ?>
                                            <span class="J-sc-hd-num sc-hd-sc-num sc-hd-ms-zero" id="fav_count">0</span>
                                        <?php } ?>
                                    </div>
                                    <div class="sc-hd-ms-title  ds-none" title="Favorites">
                                        <a href="<?php echo base_url(); ?>favorite"
                                           data-val="Favorites"> Favorites</a>
                                    </div>
                                </div>
                              <!-- sideber drop down-->
                                <div class="sc-hd-ms-panel sc-hd-ms-last">
                                    <div class="sc-hd-ms-actbtn  sc-hd-btn-viewall " style="background:none; border:0px; color:#ccc">
										<div class="sidebar-headerdropdown row text-left" id="fav_product">
                                            <?php 
                                            if($favorite_prod){ 
                                                foreach($favorite_prod as $f_prod){ 
                                                $arrayOffers['offer_status'] = $f_prod['offer_status'];
                                                $arrayOffers['offer_start_time'] = $f_prod['offer_start_time'];
                                                $arrayOffers['offer_end_time'] = $f_prod['offer_end_time'];
                                                $arrayOffers['offer_type'] = $f_prod['offer_type'];
                                                $arrayOffers['offerPrice'] = $f_prod['mrp'];
                                                $arrayOffers['offer_discount_value'] = $f_prod['offer_discount_value'];
 
                                                $offersData = $this->Offer_model->calculateOfferPrice($arrayOffers);

                                                if ($offersData != false) {
                                                    $f_prod['max_final_price'] = $offersData['offerPrice'];
                                                    $f_prod['discount'] = $this->Offer_model->
                                                            offerDiscount($favouriteProduct['offer_type'],
                                                            $offersData['offer_discount_value']);
                                                } else {
                                                    $f_prod['discount'] .= ' % Off';
                                                }
                                                
                                                ?>
											<div class="user-pic col-sm-3 p-0">
											 <a href="<?php echo base_url(); ?>favorite">
											 <img src="<?php echo $f_prod['media_url']; ?>" class="img-fluid"></a>
											</div>
											<div class="user-info col-sm-9 pl-1 pr-0" style="border-bottom:1px solid #cccccc">
											  <div class="user-name">
													<a href="<?php echo base_url(); ?>favorite" ><?php echo $f_prod['name']; ?>
													</a>
											  </div>
											  <div class="user-role">
												  <span class="user-status">
												  <span style = "color:#ee9900; font-size: 13px; font-weight: bold"> <i class="fa fa-inr fa-3x"></i><?php echo $f_prod['max_final_price']; ?></span>
												  </span>
											 </div>
											</div>
                                            <?php } } ?>
										  </div>							 
                                        <a style="background-color: #bd081b;border: 1px solid #bd081b; padding:3px  0px !important; font-size:14px;"href="<?php echo base_url(); ?>favorite" class="p-0 btn btn-primary btn-block ">
                                            View All Items
                                        </a>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>  
                        <!--*********************** END ADD TO FAVORITE *************************************-->
                        <!--*********************** ADD TO CART *************************************-->
                        <div class="sc-hd-cell sc-hd-m-ws-cart sc-hd-float-r cartT sc-hd-cellCART" id="cart">
                           <div data-reactroot="">
                              <div class="alife-bc-icbu-simple-shopping-cart">
                                 <a id="dd" class="alife-bc-icbu-simple-shopping-cart-link "
                                    href=""
                                    >
                                    <div class="alife-bc-icbu-simple-shopping-cart-icon">
                                       <a href="<?php echo base_url(); ?>/purchaseList"><img src="<?php echo base_url();?>assets/front/images/icons/cart.svg" width="35"></a>
                                    </div>
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
                                                         href="<?php echo base_url(); ?>purchaseList"><img
                                                         src="<?php echo $c_product['product_image']; ?>"></a>
                                                      </div>
                                                      <div class="alife-bc-icbu-simple-shopping-cart-item-spu-name"><a
                                                         href="<?php echo base_url(); ?>purchaseList"
                                                         title="<?php echo $c_product['product_name']; ?>"><?php echo $c_product['product_name']; ?></a></div>
                                                      <?php
                                                         $specification = json_decode($c_product['specifications']);
                                                         
                                                         for ($i = 0; $i < count($specification); $i++) {
                                                             ?>
                                                      <div class="alife-bc-icbu-simple-shopping-cart-item-sku-list">
                                                         <?php
                                                            if ($specification[$i]->specifications->case_type >= 2) {
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
                                                                  <!-- react-text: 34 --><i class="fa fa-inr"></i>
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
                                                                  <!-- react-text: 34 --><i class="fa fa-inr"></i>
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
                                                            } else {
                                                            ?>
                                                         <div class="alife-bc-icbu-simple-shopping-cart-item-sku-item ">
                                                            <div class="alife-bc-icbu-simple-shopping-cart-item-sku-price">
                                                               <span>
                                                                  <!-- react-text: 34 --><i class="fa fa-inr"></i>
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
                                          class="alife-bc-icbu-simple-shopping-cart-btn" href="<?php echo base_url(); ?>purchaseList">
                                          <span class="sc-hd-ms-title text-white"> Go to Cart</span></a>
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
         <!-- Body
            <header class="header-area sticky-header d-none d-sm-block">
             
                <div class="header-middle-area">
                    <div class="container" >
                        <div class="row">
                            <div class="col-xl-4   col-md-3 col-lg-3 col-xs-12  category-wrapper">
                                <div class="site-logo ">
                                    <a href="#"><img src="<?php //echo base_url();   ?>assets/front/images/logo/logo.png" alt="atz" width="130" class="img-fluid"></a>
            
                                </div>
                            </div>
                            <div class="col-xl-6 col-md-6 col-lg-6  col-xs-12">
                              
                                <div class="header-search clearfix">
            
                                    <div class="header-search-form">
                                        <form action="<?php //echo base_url();   ?>search-product" method="post">
                                            <input type="text" name="keyword" class="form-control search-panel" id ="autodrop" onkeypress="getproducts(this.id)" placeholder="Search Product..." required autocomplete="off">
                                            <input type="hidden" name="category_hid" id="category_hid">
                                            <input type="submit" name="submit" value="Search">
                                        </form>
                                    </div>
                                    <div style="color:red"><?php //echo form_error('keyword');   ?></div>
                                    <div style="color:red"><?php //echo $this->session->flashdata('product_message');   ?></div>
                                </div>
                            </div>
            
                        </div>
                    </div>
                </div>
                
            </header>-->
         <!-- Header bottom area end -->
      </header>