<!doctype html>
<html class="no-js" lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <meta name="google-site-verification" content="nP5Df-TYNWX_nGB7Qum5d5I4cXzd3E7A2TXtZ0Y2x_Q" /> 
        <title><?php echo $title;?></title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
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
                font-size:2.5rem !important;
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
        border: none;   
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
            font-size: 15px;
            color: #384d48;
            letter-spacing: 0px;
            line-height: 30px;
            position: relative;
        }
        
        .tab .tab-content h3{
        font-size: 24px;
        margin-top: 0;
        }
        
        .card-body{
            font-size:16px;
        }
        </style>
    </head>
    <body style="background:#fff !important">
        <ai-header>
            <div class="header-container" style="position: fixed;">
                <div class="header-wrap" ab-test-bucket="">
                    <div class="inner ripple rtl-icon">	
                        <a href="<?php echo site_url(); ?>">  <i class="icon ion-android-arrow-back"></i></a> 
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
    <!-- Tab Start-->
    <div class="container mt-5 tab">
        <!-- Nav tabs -->
        <ul class="nav nav-tabs" role="tablist">
          <li class="nav-item">
            <a class="nav-link active" data-toggle="tab" href="#withdraw">Withdraw</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#withdrawrequest">Withdraw Request</a>
          </li>
        </ul>
        <!-- Tab panes -->
                <div class="tab-content">
                  <div id="withdraw" class="container p-0 tab-pane active">
                    <div id="page" class="content">
                        <ol class="text-center" style="padding-left:0px;margin-top:rem">
                            <li class="balance-border" aria-current="page">
                                <h4 class="pt-2 h3">Balance</h4>
                                <h2 style="" class="h1"> <i class="fa fa-inr"></i> <?php echo $balance;?></h2>   
                            </li>
                        </ol>
                    <?php foreach($transactions as $trans):?>
                    <div class="card">
                        <div class="card-header">
                            <strong style="color:black"><?php echo "<i class='fa fa-inr'></i> ".$trans["amount"]." ".ucfirst($trans["transaction_type"]);?></strong>
                        </div>
                        <div class="card-body">
                            <p class="card-text">
                                <?php echo "Against : <strong>".ucfirst($trans["against"])."</strong><br />".$trans["remark"];?>
                            </p>
                            <small>Date : <?php echo date("d-m-Y h:i:s",strtotime($trans["createddate"]));?></small>
                        </div>

                    </div><br/> 

                    <?php endforeach;?>

                </div>
                <?php if($balance > 0 ){ ?>
                <div id="bottom-actions">
                    <div class="bottom-actions-wrap">
                        <div class="bottom-actions-height-placeholder" style="height: 62px;"></div>
                        <div class="bottom-actions">
                            <div class="bottom-actions-btns">
                                <a href="<?php echo site_url(); ?>mywallet/withdraw" class="btn btn-danger btn-block ">
                                    Withdraw
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <?php } ?>
          </div>
          <div id="withdrawrequest" class="container p-0 tab-pane fade"><br>
              <strong style="text-align:center"><u>Last 10 Withdraw Request :</u></strong>
                <table class="table table-bordered text-center table-striped">
                  <thead>
                    <tr>
                      <th>Sr.No</th>
                      <th>Amount</th>
                      <th>Status</th>
                      <th>Date</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php $i=1; foreach($wallet_hists as $wallet){ 
                        if($wallet['status']=="Approve")
                        {$status="<span class='text-success'>Approved</span>";}else{
                        $status="<span class='text-danger'>".$wallet['status']."</span>";}
                    ?>
                    <tr>
                      <td><?php echo $i; ?></td>
                      <td><?php echo $wallet['amount']; ?></td>
                      <td><?php echo $status; ?></td>
                      <td><?php echo date('d-M-Y H:i:s ',strtotime($wallet["updated_at"])); ?></td>
                    </tr>
                    <?php $i++; }?>
                  </tbody>
                </table>
          </div>
        </div>
      </div>
     <!-- Tab End-->
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/mobile/js/jquery-3.2.1.min.js"></script>
        <script src="<?php echo base_url();?>assets/mobile/js/bootstrap.min.js"></script>
    </body>
</html>