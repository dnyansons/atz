<!doctype html>
<html class="no-js" lang="en">
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
            .btn-color{
                background-color: #bd081b;
                color: #fff;
            }
            #loading{
                    width:100%;
                    height:100%;
                    
                    z-index:9999;
                    background-size:35%; 
                }
        #loading-image
        {
            position: absolute;
            left: 50%;
            top: 25%;
            -webkit-transform: translateX(-50%);
            transform: translateX(-50%)
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
    <ai-header>
        <div class="header-container" style="position: fixed;">
            <div class="header-wrap" ab-test-bucket="">
                <div class="inner ripple rtl-icon">	
                    <a href="<?php echo site_url();?>home/myorders"><i class="icon ion-android-arrow-back"></i></a> 
                </div>
                <div class="master">
                    <div class="title">
                        <title>Cancel Orders </title>
                    </div>
                </div>
            </div>
        </div>
    </ai-header>
        <!-- Modal content-->
        <div id="loading" class="my-auto" style="display:none; position:absolute;z-index:9; background:rgba(0,0,0,0.5);width:100%;height:100%">
                 <img id="loading-image" class="mx-auto" src="<?php echo base_url();?>assets/mobile/images/loader.gif" alt="Loading..." style="width:150px;" />
        </div>
        <div class="container">
            <form class="form-horizontal" name="cancel_form" action="<?php echo site_url(); ?>m/orders/submit_cancel_order" method="post" id="form_id" >
                <div class="">
                    <p class="text-danger p-2 m-0">Shipping Cost will not be Refunded for the Orders being already Picked from the Seller.</p>
                    <div class="form-group mb-0">
                        <div class="col-md-12">
                            <p id="myOrder"></p>
                        </div>
                    </div>
                </div>
                <div>
                    <?php echo $this->session->flashdata("message"); ?>
                </div>
                <div class="row">
                    <table class="table table-striped table-bordered">
                    <tr>
                           <td>Total Order Price </td>
                           <td><?php echo $sorder['order_price']; ?></td>
                    </tr> 
                    <tr>
                           <td>Shipping Cost</td>
                           <?php if($sorder['shippment_type']=="Free"){?>
                           <td><?php echo "<span style='color:green'>Free</span>"; ?></td>
                           <?php }else{?>
                           <td><?php echo $sorder['shipping_cost']; ?></td>
                           <?php } ?>
                    </tr>
                    <tr>
                           <td>Current Order Status</td>
                           <td><?php echo $sorder['orders_status_name']; ?></td>
                    </tr>
                    </table>						 
                    <hr>
                    <div class="col-md-12">
                        <label><b>Select Cancel Reason</b></label>
                        <select class="form-control" name="cancel_reason" id="reason" required>
                               <option value="">Select Cancel Reason</option>
                               <?php foreach($reasons as $reason): ?>
                                    <option value="<?php echo $reason['reason_id'];?>"><?php echo $reason['reason_name']; ?></option>
                               <?php endforeach; ?>
                        </select>
                        <?php echo form_error("cancel_reason"); ?>
                    </div>
                <div class="col-md-12">
                <br>
                <label><b>Any Other ?</b></label>
                        <textarea class="form-control" name="other_reason" ></textarea>
                </div>
            </div>
                <input type="hidden" name="order_id" value="<?php echo $sorder['orders_id']; ?>" >
                <br/>
                <div class="">
                    <button type="button" class="btn btn-sm btn-danger btn-block" id="btnSubmit" onClick="cancel_product()" >Cancel Order</button>
                </div>    
            </form>
        </div>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/mobile/js/jquery-3.2.1.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/mobile/js/bootbox.min.js"></script>
<script>
    
   function cancel_product(){
       bootbox.confirm({
                    message: "Are You Sure You Want To Cancel Orders ?",
                    buttons: {
                        confirm: {
                            label: 'Yes',
                            className: 'btn-success'
                        },
                        cancel: {
                            label: 'No',
                            className: 'btn-danger'
                        }
                    },
                    callback: function (result) { 
                            if(result){
                                $('#loading').show();
                                $("#form_id").submit();  
                        }
                    }
                });
            }
</script>
</body>
</html>

