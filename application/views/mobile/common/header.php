<!doctype html>
<html class="no-js" lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="x-ua-compatible" content="ie=edge">
<meta name="robots" content="noindex" />
<title>
    <?php 
        $page_title = $title ? $title : "aTz || Largest online B2B marketplace";
        echo $page_title; 
    ?>
</title>
<meta name="description" content="<?php echo $description??'';?>">
<meta name="keywords" content="<?php echo $keywords??'';?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="google-site-verification" content="nP5Df-TYNWX_nGB7Qum5d5I4cXzd3E7A2TXtZ0Y2x_Q" />  
<link rel="icon" href="<?php echo base_url(); ?>assets/images/favicon.ico" type="image/x-icon">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/mobile/css/bootstrap.min.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/mobile/css/font-awesome.min.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/mobile/css/ionicons.min.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/mobile/css/css-plugins-call.css">	
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/mobile/css/main.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/mobile/css/responsive.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/mobile/css/colors.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/mobile/css/demo.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/mobile/css/jquery.mmenu.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/mobile/css/swiper.min.css">	
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/mobile/css/all-comman.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/mobile/css/bundle.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/mobile/mobile/pro-g.css"  type="text/css" media="all">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/mobile/mobile/product-gallary.css"  type="text/css" media="all">
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/mobile/css/reset.css">
<link href="https://fonts.googleapis.com/css?family=Roboto:300,400" rel="stylesheet">
<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
<style>

.pagescroll{
	background-attachment:scroll;
	position: absolute;
    overflow: scroll;
    height: 100%;
}

input[type="text"]{
width: 100%;
background-color: #fff;
}
.searchbar {
    margin-bottom: auto;
    margin-top: auto;
    height: 40px;
    border-radius: 0px;
    border:1px solid #ccc;
}

.site-header .search-bar .search-text {
    display: flex;
    height: 36px;
    line-height: 0.6rem;
    font-size: 12px;
    border-radius: .3rem;
    overflow: hidden;
    background: #f2f3f7;
    color: #c7c7c7;
    text-align: center;
    justify-content: space-between;
    align-items: center;
}

[data-comp-name=header] {
    height:0px !important;
}

.site-header .search-bar .icon-wrap { 
    display: flex;
    width: 37px; 
    justify-content: center;
    align-items: center;
    background: #bd081b;
}

#headersearch{display:none;}

.headersearch {
  height: 100%;
  width: 0;
  position: fixed;
  z-index:999;
  top: 0;
  left: 0;
  background-color: #111;
  overflow-x: hidden;
  transition: 0.5s;
  padding-top: 60px;
  text-align:center;
}
.site-search1 .form-wrap {
    display: flex;
    flex-grow: 1;
    height: 5.2rem;
    align-items: center;
}

.site-search1 input {
    flex-grow: 1;
    height: 3.2rem;
    font-size:12px;
    outline: none;
    border: none;
    vertical-align: middle;
    text-align: start;
}

.site-search1 .tag {
    display: inline-block;
    margin:5px;
    padding: 5px;
    text-align: center;
    border: .1rem solid #ddd;
    color: #333;
    border-radius: .3rem;
    overflow: hidden;    
    text-overflow: ellipsis;
    white-space: nowrap;
}

.site-search1 .keywords-title {
    display: flex;
    justify-content: space-between;
    align-items: center;
    line-height: 3.2rem;
    color: #999;
    background: #fff;
    font-size: 1.4rem;
}

.site-search .search-header {
    position: fixed;
    z-index: 5;
    left: 0;
    top: 0;
    display: flex;
    width: 100%;
    height:44px; 
    background: #fff;
    box-shadow: 1px 2px 3px rgba(0, 0, 0, .3);
}

.site-search1 .form-wrap {
    display: flex;
    flex-grow: 1;
     height:44px; 
    align-items: center;
}

.site-search1 input {
    flex-grow: 1;
    height:44px; 
    font-size: 18px;
    outline: none;
    border: none;
    vertical-align: middle;
    text-align: start;
}
.site-search1 .back-btn {
    display: flex;
    width: 2.8rem;
    font-size:22px;
    height: auto;
    justify-content: center;
    align-items: center;
}

.site-search1 .search-content {
    position: fixed;
    z-index: 4;
    left: 0;
    top:3.2rem;
    width: 100%;
    height: 100%;
    background: #fff;
}

.site-search1 .history {
    border-bottom: .0rem solid #ddd;
}

.site-search1 .history, .site-search .popular, .site-search .suggestion {
    padding:5px;
	padding-bottom:50px;
}

.site-search1 .keywords-title {
    display: flex;
    justify-content: space-between;
    align-items: center;
    line-height:1rem;
    color: #999;
    background: #fff;
    font-size:14px;
}

.site-search1 .keywords-title .iconfont-delete {
    font-size: 2.4rem;
    padding: .5rem;
}
[class*=" iconfont-"], [class^=iconfont-] {
    font-family: icomoon!important;
    speak: none;
    font-style: normal;
    font-weight: 400;
    font-variant: normal;
    text-transform: none;
    line-height: 1;
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;
}

.site-search1 .history a, .site-search .popular a, .site-search .suggestion a {
    font-size: 12px;
}
.site-search1 .tag {
    display:block;
    margin: 0px;
    justify-content:left;
    align-items:center;
    padding: .4rem 0rem;
    text-align: left;
    border:0px;
    border-bottom:1px solid #ddd;
    color: #333;
    border-radius:0rem;
    overflow: hidden;
}
.site-search1 .arr
{
	float:right;
	font-weight:400;
	font-size:18px;
	transform: rotate(-36deg);
	color:#8e8a8a;
}
.site-search1 i{padding:0 10px; font-weight:600;font-size:16px;}
.keywords-title i
{
	font-size:22px;
}
#load{
    width:100%;
    height:100%;
    position:fixed;
    z-index:9999;
    background:url("<?php echo base_url();?>assets/mobile/images/loader.gif") no-repeat center center rgba(255,255,255,1);
    background-size:35%;
}
.smte{padding-left:35px; color:#2874f0; font-weight:bold;font-size:11px;}
</style>
<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-144123824-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-144123824-1');
</script>

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

<!-- Global site tag (gtag.js) - Google Ads: 728750276 -->
<script async src="https://www.googletagmanager.com/gtag/js?id=AW-728750276"></script>
<script>
 window.dataLayer = window.dataLayer || [];
 function gtag(){dataLayer.push(arguments);}
 gtag('js', new Date());

 gtag('config', 'AW-728750276');
</script>
</head>
<body  class="" style="background:#f3f3f5 url(assets/mobile/images/back.jpg);background-repeat: no-repeat;" id="overlay">
<div id="load"></div>
