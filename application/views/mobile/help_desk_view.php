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
                    <a href="<?php echo $_SERVER["HTTP_REFERER"]; ?>">  <i class="icon ion-android-arrow-back"></i></a> 
                </div>
                <div class="master">
                    <div class="title">
                        <title>Return Orders </title>
                    </div>
                </div>
            </div>
        </div>
    </ai-header>
    <div class="card">
        <div class="card-body">
            <div class="card border-light bg-white card proviewcard shadow-sm">
                <div class="card-body">
                    <div class="row">
           <div class="col-lg-12 p-3 cardlist">                         
                <ul class="list-group list-cust">               
                <h5> A . Once the order is paid by buyer and then cancelled then system should provide list of reasons where buyer has to select the options and submit it with reasons.</h5>
                
                                    <li class="list-group-item ">1. You come across with better deal on the same product which you ordered.</li>
                                    <li class="list-group-item ">2. If you are not going to be available in town due to some urgent travel.</li>
                                    <li class="list-group-item ">3. Product is being delivered at wrong address.</li>
                                    <li class="list-group-item ">4. Product not required any more</li>
                </ul>               
                 <br>
                <ul class="list-group list-cust">
                <h5> B . Once order is paid and confirmed by seller and out for dispatched or collected for dispatched then below reasons to be considered with functionality where buyer has accepted condition to pay shipping charges and order amount will be refunded to account.</h5>
                
                                    <li class="list-group-item ">1. You come across with better deal on the same product which you ordered.</li>
                                    <li class="list-group-item ">2. Product is taking too long to be delivered</li>
                                    <li class="list-group-item ">3. Customer discovered the same product on another website or a shop at a lower price than the order price</li>
                                    <li class="list-group-item ">4. Customer changes his mind and opts for another brand instead</li>
                </ul>               
                 <br>
                <ul class="list-group list-cust">
                 <h5>  C . Return Order : Order is delivered. Buyer want to return the product as per selection of below reason;</h5>
                                    <li class="list-group-item "> 1. Product is damaged (seller will bare shipping fees)</li>
                                    <li class="list-group-item "> 2. Product not received as shown by seller (seller will bare shipping fees)</li>
                                    <li class="list-group-item ">3. Quantity is mismatching. (seller will bare shipping fees)</li>
                                    <li class="list-group-item "> 4. I don't want product any more (Buyer will bare shipping fees)</li>
                </ul>
                            </div> 
                     
                            <div class="col-lg-6 p-3 cardlist radiB hide text-center">
                                <form action="<?php echo site_url(); ?>home/proceed_to_return" name="frm_return_order" id="" method="post">
                                    <input type="hidden" name="order_id" value="<?php echo $user_orders[0]->orders_id; ?>" />
                                    <?php if($current_date <= $upto_delivery_date){ ?>
                                    <input type="submit" class="block-center btn btn-danger" name="return_submit" value="Return Submit"/>
                                    <?php } ?>
                                </form>
                            </div>
                                 
                    </div>
                </div>
            </div>
        </div>
    </div> 
</div><br><br><br><br>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
<script>

 
$(document).ready(function(){
   
  $("#returnO").click(function(){
    $("#returnO").addClass("hide");
    
    $(".radiB").removeClass("hide");
    
  });
})
</script>
</body>
</html>


