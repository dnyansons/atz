<!doctype html>
<html class="no-js" lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="google-site-verification" content="nP5Df-TYNWX_nGB7Qum5d5I4cXzd3E7A2TXtZ0Y2x_Q" />
    <title>aTz || Largest online B2B marketplace </title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- <link rel="stylesheet" href="src/assets/css/demo.css"> -->
    <link rel="icon" type="image/x-icon" href="assets/images/icons/icon_logo.png">
    <link rel="stylesheet" href="<?php echo base_url();?>assets/mobile/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo base_url();?>assets/mobile/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?php echo base_url();?>assets/mobile/css/ionicons.min.css">
    <link rel="stylesheet" href="<?php echo base_url();?>assets/mobile/css/main.css">
    <link rel="stylesheet" href="<?php echo base_url();?>assets/mobile/css/slide.css">
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
    <ai-header >
      <div class="header-container" style="position: fixed;">
        <div class="header-wrap">
          <div class="inner ripple rtl-icon"><a href="<?php echo $_SERVER['HTTP_REFERER']; ?>"> <i class="icon ion-android-arrow-back"></i> </a> </div>
          <div class="master">
            <div class="title">
              <div class="title-placeholder">
                <!--padding-->
              </div>
              <title>All Buying Request</title>
            </div>
          </div>
        </div>
      </div>
    </ai-header>
    <ai-rfq-list>
      <!-- rfq list -->
      <div id="rfq-list">
        <div id="rfq-list-scroll-wrapper">
          <!-- loading -->
          <!-- rfq list item -->
          <?php if(!empty($rfqrequests)){ ?>
          <div class="rfq-list-item">
            <?php foreach($rfqrequests as $rfqrequest):
              $agree = (strtolower($rfqrequest->agree_share_contact) == 'true') ? 'Yes': 'No';
              ?>
              <?php
               $color=0;
               if($rfqrequest->status=="Approved"){
                   $color="text-success";
               }elseif($rfqrequest->status=="Rejected"){
                    $color="text-danger";
               }else{
                    $color="text-warning";
               }?>
            <div class="wrapper">
              <h3 class="rfq-list-title" id="openRfqBtn" data-id="<?php echo $rfqrequest->id;?>" style="color : #17a2b8;" data-toggle="modal" data-target="#rfqModal"><?php echo ucfirst($rfqrequest->looking_for);?></h3>
              <span class="status text-right <?php echo $color; ?>"><small><?php  echo $rfqrequest->status;?></small></span>
            </div>
            <?php endforeach; ?>
          </div>
          <?php } else { ?>
          <div class="text-white text-left mt-2 p-2" style="background:#FF9751!important; box-shadow: 0 5px 11px 0 rgba(0,0,0,.18), 0 4px 15px 0 rgba(0,0,0,.15);">
            <small class="title"> No Product in RFQ </small>
          </div>
          <?php } ?>
        </div>
      </div>
    </ai-rfq-list>
  </body>
  <!-- The Modal -->
  <div class="modal" id="rfqModal">
    <div class="modal-dialog">
      <div class="modal-content">
        <!-- Modal Header -->
        <div class="modal-header">
          <h5 class="modal-title" id="rfqProduct">Request For Quotation </h5>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <!-- Modal body -->
        <div class="modal-body" id="rfqComment">
            
        </div>
        <!-- Modal footer -->
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
  <script> 
       $(document).ready(function(){
           $("#rfqSeller").hide();
       });
        $(document).on("click", "#openRfqBtn", function () {
                   var rfqId = $(this).data('id');
                   $.ajax({
                       url: '<?php echo site_url(); ?>m/home/get_rfq',
                       type: 'POST',
                       data : {'rfqs_id' : rfqId},
                       success:function(data){
                           $("#rfqComment").html(data);
                       }
                   });  
                });
        function showReply(){
            $("#rfqSeller").toggle();
        }
  </script>
</html>