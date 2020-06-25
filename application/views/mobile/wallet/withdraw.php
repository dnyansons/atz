<!doctype html>
<html class="no-js" lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title><?php echo $title;?></title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="google-site-verification" content="nP5Df-TYNWX_nGB7Qum5d5I4cXzd3E7A2TXtZ0Y2x_Q" /> 
        <link rel="icon" type="image/x-icon" href="assets/images/icons/icon_logo.png">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/mobile/css/bootstrap.min.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/mobile/css/font-awesome.min.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/mobile/css/ionicons.min.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/mobile/css/main.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/mobile/css/slide.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/mobile/css/productOverview.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/mobile/mobile/normal-mobile.css">
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
     			.btn{
				color: #fff !important;
				font-size:2rem !important;
			}
		
			.footer {
				position: fixed;
				left: 0;
				bottom: 0;
				width: 100%;
				color: white;
				text-align: center;
			}
			.balance-border{
			border-radius: 50px;
			margin: 0px 50px;
			padding: 5px 0px;
			color: #000;
			}
			.balance-border h2{font-size:3.2rem;}

			.tab .nav-tabs{
			border: none;
			margin-bottom: 10px;
			}
			.tab{display:block}
			.tab .nav-tabs li a{
			padding:5px 10px;
			margin-right: 15px;  
			font-size: 14px;
			font-weight: 600;
			background: #dc3545;
			color:#fff !important;
			text-transform: uppercase;
			border: 3px solid #dc3545;   
			border-radius: 0;
			overflow: hidden;
			position: relative;
			transition: all 0.3s ease 0s;

			}

			.tab .nav-tabs .nav-item a.active{

			border-top: 3px solid #dc3545;
			border-bottom: 3px solid #dc3545;
			background: #fff;
			color: #dc3545 !important;
			}

			.tab .nav-tabs li.active a,
			.tab .nav-tabs li a:hover{
			border: none;
			border-top: 3px solid #dc3545;
			border-bottom: 3px solid #dc3545;
			background: #fff;
			color: #dc3545 !important;
			}
			.tab .nav-tabs li a:before{
			content: "";
			border-top: 15px solid #dc3545;
			border-right: 15px solid transparent;
			border-bottom: 15px solid transparent;
			position: absolute;
			top: 0;
			left: -50%;
			transition: all 0.3s ease 0s;
			}

			.tab .nav-tabs li a.active:hover:before,
			.tab .nav-tabs li a.active:before{ left: 0; }
			.tab .nav-tabs li a.active:after{
			content: "";
			border-bottom: 15px solid #dc3545;
			border-left: 15px solid transparent;
			border-top: 15px solid transparent;
			position: absolute;
			bottom: 0;
			right: -50%;
			transition: all 0.3s ease 0s;
			}
			.tab .nav-tabs li a.active:hover:after,
			.tab .nav-tabs li a.active:after{ right: 0; }
			.tab .tab-content{
			padding:15px 5px 60px 5px;
			border-top: 3px solid #384d48;
			border-bottom: 3px solid #384d48;
			font-size: 14px;
			color: #384d48;
			letter-spacing: 1px;
			line-height: 30px;
			position: relative;
			}
                        
			.tab .tab-content h3{
			font-size: 24px;
			margin-top: 0;
			}
                       .one{
                            font-size:17px !important;
                        }
                input[type=number]::-webkit-inner-spin-button,
                input[type=number]::-webkit-outer-spin-button {
                    -webkit-appearance: none;
                    margin: 0;
                }
            
        </style>
    </head>
    <body style="background:#fff !important">
        <ai-header>
            <div class="header-container" style="position: fixed;">
                <div class="header-wrap" ab-test-bucket="">
                    <div class="inner ripple rtl-icon">	
                        <a href="<?php echo site_url(); ?>mywallet">  <i class="icon ion-android-arrow-back"></i></a> 
                    </div>
                    <div class="master">
                        <div class="title">
                            <title>
                                My Wallet
                            </title>
                        </div>
                    </div>
                </div>
            </div>
        </ai-header>
       <div class="container mt-5 tab">
                <ol class="text-center" style="padding-left:0px; margin-top:1rem">
                    <li class="balance-border" aria-current="page">
                        <h4 class="pt-2 h3">Balance</h4>
                        <h2 style="" class="h1"> <i class="fa fa-inr"></i> <?php echo $balance;?></h2>
                    </li>
                </ol>
            <div class="row">
                <div class="col-12">
                    <?php echo $this->session->flashdata("message");?>
                </div>
            </div>
            <div class="clearfix"></div>
            <div class="card">
                <div class="card-header ">
                    <strong style="color:#000; font-size:14px;">Send Withdraw Request</strong>
                </div>
                <form autocomplete="off" action="<?php echo site_url();?>mywallet/withdraw" method="post" id="withdraw">
                    <div class="card-body">
                        <div class="control-group">
                            <label class="control-label">Amount :</label>
                            <input class="form-control one numbers_arr" type="text" name="amount" id="amount" placeholder="&#x20B9 0.00"  maxlength="6">
                            <?php echo form_error('amount'); ?>
                            <div id="error"></div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <input class="btn btn-lg btn-block btn-danger" type="button" value="Withdraw" onclick = "submit_form()">
                    </div>
                </form>
            </div>
        </div>
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/mobile/js/jquery-3.2.1.min.js"></script>
        <script src="<?php echo base_url();?>assets/mobile/js/bootstrap.min.js"></script>
        <script>
            var err = 0;
            $(document).ready(function() {
                $("#error").html("");
                var actual_amount = '<?php echo $balance;?>';
                parseFloat(actual_amount);

               $('#amount').on('keyup',function(){
                   $("#error").html("");
                   var amount = $(this).val();
                   if(parseFloat(amount) > actual_amount){
                       err++;
                       $('#error').html('<span style="color:red" id="error"> Amount should be less than wallet amount.</span>');
                       return false;
                   }else{
                       err = 0;
                       return true;
                   }
               });

               /*********************** for e character **************/

                $("#amount").on("input", function() {
                    var nonNumReg = /[^0-9]/g
                    $(this).val($(this).val().replace(nonNumReg, ''));
                });
            });

            function submit_form(){
                var amount = $("#amount").val();
                if(amount)
                {
                    if(err == 0){
                        $("#withdraw").submit();
                    }
                }else{
                    $('#error').html('<span style="color:red" id="error"> Please add the amount.</span>');
                }
            }

        </script>
    </body>
</html>
