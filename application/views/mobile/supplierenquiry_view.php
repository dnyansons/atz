<html os-type="unknow" runtime="browser" pwa="true" os-version="6.0" version="2.1.0" language="EN" debug="false"
    test-prefix="pwa" name="wap:contact-supplier/post" scheme="https" locale="en_us" client="mobilephone"
    chrome-version="73" webview-core="chromium" android-browser="chromium" ab-test-bucket="0">
<head>
    <title>send</title>
    <meta charset="utf-8">
    <meta name="aplus-rate-ahot" content="0.001">
    <meta name="aplus-rate-ahot-res" content="0.001">
    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no">
    <meta name="google-site-verification" content="nP5Df-TYNWX_nGB7Qum5d5I4cXzd3E7A2TXtZ0Y2x_Q" /> 
    <link href="<?php echo base_url(); ?>assets/mobile/mobile/send-enq.css" rel="stylesheet"> 
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
    <ai-header>
        <div class="header-container" style="position:fixed">
            <div class="header-wrap" ab-test-bucket="">
                <div class="inner ripple">
				  <a href="<?php echo base_url(); ?>product/productOverview/<?php echo $productsinfos['id']; ?>"><i aria-label="Close" class="icon iconfont-close"></i></a>
						</div>
                <div class="master" clickevent="master">
                    <div class="title">
                        <title>Contact Supplier</title>
                    </div>
                </div>
            </div>
        </div>
    </ai-header>
    <div id="page" class="content v2" data-page-id="myalibaba-message-send">
        <div class="field field-to">
            To:<?php echo $sellerinfos['first_name'].' '.$sellerinfos['last_name'];?>
            <span id="field-to" data-editable="false">(<?php echo $sellerinfos['compname']; ?>)</span>
        </div>
        <form id="form-send" action="<?php echo base_url(); ?>product/product_enquiry" method="post">
            <div class="text-area">
                <textarea id="field-content" name="product_description">Hi, I’m interested in your product. I would like some more details.I look forward to your reply.
				</textarea>
            </div>
            <section class="btn-submit">
                <button type="submit" id="btn-send" class="ui-btn" data-send-text="Send" data-sending-text="Sending…">Send</button>
            </section>
            <hr>
            <div class="field fancy-checkbox" style="border: none">
                <label for="field-buyerinfoprotection">
                    <input type="checkbox" id="field-buyerinfoprotection" name="buyerinfoprotection" value="true"
                        checked="checked">
                    <span class="iconfont-radio"></span>
                    <p>I agree to share my contact information in my Buyer Profile with this supplier.</p>
                </label>
            </div>
        </form>
    </div>
</body>
</html>