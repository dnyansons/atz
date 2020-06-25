<html os-type="unknow" runtime="browser" pwa="true" os-version="6.0" version="2.1.0" language="EN" debug="false"
    test-prefix="pwa" name="wap:contact-supplier/post" scheme="https" locale="en_us" client="mobilephone"
    chrome-version="73" webview-core="chromium" android-browser="chromium" ab-test-bucket="0">
<head>
    <title>send</title>
    <meta charset="utf-8">
    <meta name="aplus-rate-ahot" content="0.001">
    <meta name="aplus-rate-ahot-res" content="0.001">
    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no">
    <link href="<?php echo base_url(); ?>assets/mobile/mobile/send-enq.css" rel="stylesheet">
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
		background-image: url(../../assets/front/images/order.svg);
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
		background-color: #FF6A00;
		border-color: #FF6A00;
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
	</style>
</head>
<body>
    <ai-header>
        <div class="header-container" style="position:fixed">
            <div class="header-wrap" ab-test-bucket="" style="background-color:#fff">
                <div class="inner ripple">
				  <a href="<?php echo base_url(); ?>home" class="header-item btn-back">
				    <i aria-label="Close" class="icon iconfont-back"></i> </a>
						</div>
                <div class="master" clickevent="master" >
                    <div class="title">
                        <title>Start Order Result</title>
                    </div>
                </div>
            </div>
        </div>
    </ai-header>
    
	<div class="feedback-body">
			<div style="text-align:center">
				<img src="<?php echo base_url();?>assets/mobile/images/check.png" style="width:40px">
			</div>
		<div class="feedback-success-content">
		   Start order successfully,
			<br>please contact the supplier to confirm the shipping cost and pay!
		   
		</div>
		<div class="feedback-step-svg"></div>
	</div>

<div class="feedback-footer">
    <div class="feedback-footer-prompt">
        <div class="feedback-footer-text">
		 Due to the shipping cost is not included in this order, please download App
            and contact the supplier to confirm the shipping cost.</div>
    </div>
	<a class="feedback-download-app-link" href="">
	<button  class="mext-btn mext-btn-fixed mext-btn-fixed-primary" type="button">Download Atzcart.com App</button>
	</a>
</div>
<script>
		$(document).ready(function(){
						localStorage.clear();

						})
</script>
</body>
</html>