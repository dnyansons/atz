<html>
<head>
    <title>send</title>
    <meta charset="utf-8">
    <meta name="aplus-rate-ahot" content="0.001">
    <meta name="aplus-rate-ahot-res" content="0.001">
    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no">
    <meta http-equiv="refresh" content="3;url=<?php echo site_url(); ?>" />
    <meta name="google-site-verification" content="nP5Df-TYNWX_nGB7Qum5d5I4cXzd3E7A2TXtZ0Y2x_Q" /> 
    <link href="<?php echo base_url(); ?>assets/mobile/mobile/send-enq.css" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo base_url();?>assets/mobile/css/ionicons.min.css">
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
<style>
    table tr th{width:40%; text-align: right}              
    table tr{border:1px solid #ccc !important;}
    table td{border:1px solid #ccc !important; padding:5px; }
</style>
</head>
<body>
    <ai-header>
        <div class="header-container" style="position:fixed">
            <div class="header-wrap" ab-test-bucket="" style="background-color:#fff">
                <div class="inner ripple">
                     <a href="<?php echo base_url(); ?>home"><i class="icon ion-android-arrow-back"></i> </a></div>
                <div class="master" clickevent="master" >
                    <div class="title">
                        <title>Post Buying Request</title>
                    </div>
                </div>
            </div>
        </div>
    </ai-header>
    <div id="page" class="content v2" data-page-id="myalibaba-message-send" 
	style="background-color:#fff;  border-radius:10px; margin:10px; padding:50px 0">
        <div style="text-align:center">
                <img src="<?php echo base_url();?>assets/mobile/images/check.png" style="width:40px">
        </div>
        <div class="message-success">
                <h5 class="text-center">Your Buying Request has been successfully submitted.</h5>
        </div>
        <div>
                <table style="width:100%">
                  <tr>
                    <th> <strong>Request No. : </strong></th>
                    <td> <?php echo $rfq->id; ?> </td>
                  </tr> 
                  <tr>
                    <th><strong> Date & Time :</strong></th>
                   <td><?php echo $rfq->added_date; ?></td>
                  </tr>
                </table>
        </div>
    </div>
</body>
</html>