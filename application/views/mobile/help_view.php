<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title>aTz || Largest online B2B marketplace </title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="google-site-verification" content="nP5Df-TYNWX_nGB7Qum5d5I4cXzd3E7A2TXtZ0Y2x_Q" /> 
        <link rel="icon" type="image/x-icon" href="assets/images/icons/icon_logo.png">  
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/mobile/css/bootstrap.min.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/mobile/css/font-awesome.min.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/mobile/css/ionicons.min.css">  
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/mobile/css/main.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/mobile/css/slide.css">
<style>

body{
 height:auto;
}
.cardlist label {
  margin: 2em;
  display: inline-block;
  position: relative;
  padding-left: 40px;
  cursor: pointer;
}

.cardlist input[type="radio"] {
  height: 1px;
  width: 1px;
  opacity: 0;
}

.outside {
  display: inline-block;
  position: absolute;
  left: 0;
  top: 50%;
  margin-top: -10px;
  width: 20px;
  height: 20px;
  border: 2px solid red;
  border-radius: 50%;
  -webkit-box-sizing: border-box;
          box-sizing: border-box;
  background: none;
}

.inside {
  position: absolute;
  top: 50%;
  left: 50%;
  -webkit-transform: translate(-50%, -50%);
          transform: translate(-50%, -50%);
  display: inline-block;
  border-radius: 50%;
  width: 10px;
  height: 10px;
  background: red;
  left: 3px;
  top: 3px;
  -webkit-transform: scale(0, 0);
          transform: scale(0, 0);
}
.no-transforms .inside {
  left: auto;
  top: auto;
  width: 0;
  height: 0;
}

.cardlist input:checked + .outside .inside {
  -webkit-animation: radio-select 0.1s linear;
          animation: radio-select 0.1s linear;
  -webkit-transform: scale(1, 1);
          transform: scale(1, 1);
}
.no-transforms input:checked + .outside .inside {
  width: 10px;
  height: 10px;
}
.cardlist input[type="button"]
{
 /* width:200px;*/
  margin:30px 33px;
    height:38px;
    font-size:14px; 
  padding: 0 30px;
    color: #fff;
    transition: .3s;
    background-color: #bd081b;
    cursor: pointer;
    border-color: #bd081b;
        margin-left: 95px;
}
.cardlist input[type="submit"]
{
  width:200px;
  margin:30px 33px;
}
h5{
  font-size:14px !important;
  font-weight:600;
  margin:5px 0;}
.card-body
{
  padding:6px !important;
}
.list-group-item
{
  background:none;
  border:0px;
  padding-bottom:0px !important;
}
.cardlist ul
{
  background:#ffebdb !important;
  padding:15px;
   border-radius:5px;
}

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
<body>
<?php   
        $date = strtotime($user_orders[0]->delivery_date);
      
         $uptodate = strtotime("+3 day",$date);
          $upto_delivery_date = date('Y-m-d', $uptodate);
      
          $current_date=date("Y-m-d");
          
         //$current_date=date("2019-06-03");
?>
<br>
<div class="container">
     <ai-header>
        <div class="header-container" style="position: fixed;">
            <div class="header-wrap" ab-test-bucket="">
                <div class="inner ripple rtl-icon"> 
                    <a href="<?php echo site_url(); ?>">  <i class="icon ion-android-arrow-back"></i></a> 
                </div>
                <div class="master">
                    <div class="title">
                        <title>Help Center</title>
                    </div>
                </div>
            </div>
        </div>
    </ai-header>
    <div class="">
        <div class="card-body">
            <div class="card border-light bg-white card proviewcard shadow-sm">
                <div class="">
                    <div class="row">
                        <div class="col-lg-12 cardlist">                         
                             <ul class="list-group list-cust  text-center font-weight-bold">               
                                 Toll Free:<br/> 1800-212-2036<br><br>
                                 Write us on:<br/> support@atzcart.com
                             </ul>               
                             
                       </div>       
                    </div>
                </div>
            </div>
        </div>
    </div> 
</div><br><br><br><br>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
</body>
</html>




