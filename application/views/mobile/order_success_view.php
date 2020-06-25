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
    <link rel="stylesheet" href="<?php echo base_url();?>assets/mobile/css/ionicons.min.css">
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
    <style>
		.header-item {
		display: flex;
		width:3rem;
		height:3rem;
		justify-content: center;
		align-items: center;
		font-size: 2.4rem;
		}
		.p-5
		{
		padding:15px;
		}

		.feedback-body {
		display: -webkit-box;
		display: -webkit-flex;
		display: flex;   
		flex-direction: column; 
		align-items: center;
		background-color: #FFF;
		padding: 2.4rem .8rem .8rem;
		}
		.feedback-icon-success {
		color: #1DC11D;
		}

		.feedback-success-content {
		padding: .24rem .8rem;
		font-size:14px;
		line-height:16px;
		text-align: center;
		}

		.feedback-step-svg {
		height: 2rem;
		width: 100%;
		background-repeat: no-repeat;
		background-size: cover;
		margin-top: 50px;
		}
		.header-container
		{
		box-shadow: 0 2px 5px rgba(0,0,0,.32);
		}
		.feedback-footer {
		padding:1rem 1rem;
		align-items: center;
		}
		.feedback-footer-text {
		margin: 0 1rem 1rem;
		color: #666;
		font-size:12px;
		line-height: 1rem;
		text-align:center;
		}

		.mext-btn-fixed-primary {
		color: #FFF;
		background-color: #bd081b;
		border-color: #bd081b;
		}
		.mext-btn-fixed {
		width: 100%;
		display: block;
		border: 0;
		border-style: solid;
		height: 2.28rem;
		padding: 0 1rem;
		border-top-width: 1px;
		}
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
				  <a href="<?php echo site_url(); ?>"  class="header-item btn-back">
				    <i class="icon ion-android-arrow-back"></i>	 </a>
		</div>
                <div class="master" clickevent="master" >
                    <div class="title">
                        <title>Order Placed</title>
                    </div>
                </div>
            </div>
        </div>
    </ai-header>
        
	<div class="feedback-body">
			<div style="text-align:center">
				<img src="<?php echo base_url();?>assets/mobile/images/check.png" style="width:40px">
                        </div><br>
		<div class="feedback-success-content">
	         	  <!-- Order Placed Successfully    -->

              <div class="alert alert-success alert-dismissible">
                  <!-- <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> -->
                  <strong>Success!</strong> Order Placed Successfully.
               </div>

                  
                </div><br>
                <?php
                if(!empty($orders))
                { 
                    ?>
                     <div class="card-body" style="width:100%">
                         <label style="txt"> <strong><center>Seller Details</center></strong></label>
                    <table style="width:100%">
                      <tr>
                        <th> <strong>Seller Name : </strong></th>
                        <td> <?php echo $orders['pick_name']; ?> </td>
                      </tr>
                      <tr>
                        <th><strong> Address :</strong></th>
                       <td><?php echo $orders['pick_addr_type']; ?></td>
                      </tr>
                      <tr>
                       <th><strong> State : </strong></th>
                       <td> <?php echo $orders['pick_state']; ?> </td>
                      </tr>
                      <tr> 
                        <th><strong>  Mobile Number : </strong></th> 
                        <td><?php echo $orders['pick_mobile'];  ?></td>
                      </tr>
                      <tr> 
                        <th><strong>  Email : </strong></th> 
                        <td><?php echo $orders['pick_email'];  ?></td>
                      </tr>
                    </table>
                </div>
                <br/>
               <?php }
                if(!empty($results)){
                     // $product_details=array();
                    foreach($results as $result){
                        $product_id[]=$result->products_id;
                        $product_ids=implode(",",$product_id);
                        $product_details[]=$result->products_name;
                        $product_detail=implode(", ",$product_details);
                    }

                     // $shipping_cost=0; 
                     if ($chech_shipp->shipping_type == 'Free' && $result->final_price >= $chech_shipp->free_amount) {
                         $shipping_cost='<span style="color:green">Free</span>';
                     }else
                     {
                        $shipping_cost=$result->shipping_cost;
                     }
                ?>
                <div class="card-body">
                    <table style="width:100%">
                      <tr>
                        <th> <strong>Order Id : </strong></th>
                        <td> <?php echo "#ORD".$result->orders_id; ?> </td>
                      </tr>
                      <tr>
                        <th><strong> Product Id :</strong></th>
                       <td><?php echo $product_ids; ?></td>
                      </tr>
                      <tr>
                       <th><strong> Trans. Id : </strong></th>
                       <td> <?php echo $result->payment_id; ?> </td>
                      </tr>
                       <tr> 
                        <th><strong>  Product Image : </strong></th> 
                        <td>
                            <div class="item-banner">
                                <img class="zoom-in lazy" style="width:60px;height:60px;" src="<?php echo $orderProduct[0]->product_image; ?>" alt="<?php echo $orderProduct[0]->product_image;?>" style="display: inline-block;">
                            </div>
                        </td>
                      </tr>
                      <tr> 
                        <th><strong>  Product Details : </strong></th> 
                        <td><?php echo $product_detail;  ?></td>
                      </tr>
                       <tr> 
                        <th><strong>  Product Qty : </strong></th> 
                        <td><?php echo $result->products_quantity;;  ?></td>
                      </tr>
                      <tr> 
                        <th><strong>  Shipping Cost : </strong></th> 
                        <td><?php echo $shipping_cost;  ?></td>
                      </tr>
                      <tr> 
                        <th><strong>  Total Amount : </strong></th> 
                        <td> <?php echo $result->order_price;  ?></td>
                      </tr>
                      <tr> 
                        <th><strong> Payment Mode : </strong></th> 
                        <td><?php echo $result->payment_by;  ?></td>
                      </tr>
                    </table>
                </div>
           <?php } ?>
	</div>
<div class="feedback-footer">
	<a class="feedback-download-app-link" href="https://play.google.com/store/apps/details?id=com.atzcart.in&hl=en">
	<button  class="mext-btn mext-btn-fixed mext-btn-fixed-primary" type="button">Download Atzcart App</button>
	</a> 
</div>
<script src="https://code.jquery.com/jquery-1.11.3.min.js"></script>
<script>
		$(document).ready(function(){
                    sessionStorage.clear();
                })
</script>
</body>
</html>