<html data-dpr="2" style="font-size: 75px;"><head>
        <meta charset="utf-8">
        <title>Start Order</title>
        <meta name="viewport" content="width=device-width,user-scalable=no,initial-scale=0.5,maximum-scale=0.5,minimum-scale=0.5">
        <meta name="google-site-verification" content="nP5Df-TYNWX_nGB7Qum5d5I4cXzd3E7A2TXtZ0Y2x_Q" /> 
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/mobile/mobile/index3.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/mobile/css/bootstrap.min.css">
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/mobile/mobile/molar.js"></script>
        <script type="text/javascript" id="aplus-sufei" src="<?php echo base_url(); ?>assets/mobile/mobile/index3.js" ></script>
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/mobile/css/ionicons.min.css">
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
            input[type="radio"]
            {
                width:32px !important;
                height:32px;
            }
            .update_msg{
                text-align:center;
                display:block;
                color:green;    
            }
        </style>
    </head>
    <body data-spm="trade-order-buynow-h5">
        <div id="app">
            <div data-reactroot="" id="buynow-page" class="">
                <form  id="form_1" class="mext-form buynow-page-form mext-form-enclosed">
                    <div class="mext-nav mext-nav-normal mext-nav-layout-normal mext-nav-fixed nav buynow-page-h5WsNavBar">
                        <div class="mext-nav-segment mext-nav-segment-left mext-nav-segment-custom" type="custom">
                            <div class="mext-nav-item mext-nav-segment-back mext-nav-item-custom" type="custom">

                            </div>
                        </div>
                        <div class="mext-nav-segment mext-nav-segment-center mext-nav-segment-custom mext-nav-left" type="custom">
                            <div class="mext-nav-item mext-nav-item-title" type="title"> Shipping Address </div>
                        </div>
                    </div>

                    <div class="mext-slip-content">
                        <div class="mext-nav mext-nav-normal mext-nav-layout-normal mext-nav-fixed" style="top: 0px;">
                            <div class="mext-nav-segment mext-nav-segment-left mext-nav-segment-custom" type="custom">
                                <div class="mext-nav-item mext-nav-segment-back mext-nav-item-custom" type="custom"><a href="<?php echo $this->session->userdata('start_order_page'); ?>">
                                        <i class="icon ion-android-arrow-back"style="color:#818181; font-size:46px;"></i></a></div>
                            </div>
                            <div class="mext-nav-segment mext-nav-segment-center mext-nav-segment-custom mext-nav-left" type="custom">
                                <div class="mext-nav-item mext-nav-item-title" type="title">Add Shipping Address</div>
                            </div>
                        </div>
                        <span class="update_msg"><?php echo $this->session->flashdata("update_address_msg"); ?></span>
                        <div class="container" style="margin-top:25px;">
                            <div class="row">                                
                                <!-- Default inline 2-->
                                <?php  echo $this->session->flashdata('message') ; ?>

                                <div class="col-12">								
                                    <form action="#">
                                        <?php
                                        foreach($address as $add) {
                                            if ($add["contact_person"] != "") {
                                                ?>		
                                                <div class="form-check-inline mr-0 mb-1 w-100">          
                                                    <label class="form-check-label w-100" for="default_address">
                                                        <div class="card">
                                                            <div class="card-header " style="padding:8px;">
                                                                <input type="radio" class="form-check-input default_address" id="default_address" name="optradio" value="<?php echo $add["address_book_id"]; ?>" <?php echo ($add["is_default"] == 1) ? "checked" : ""; ?> > 
                                                                <strong class="p-0"><?php echo $add["contact_person"]; ?></strong>
                                                                <a title="Delete This Address" href="<?php echo site_url(); ?>product/delete_shipping_address/<?php echo $add["address_book_id"]; ?>" class="btn btn-danger float-right" style="font-size:24px; padding:2px 20px;margin-left:10px; border-radius:0px;">X</a>
                                                                <a href="<?php echo site_url(); ?>product/edit_shipping_form/<?php echo $add["address_book_id"]; ?>" class="btn btn-warning float-right" style="font-size:24px; padding:2px 20px; border-radius:0px;">Edit </a>
                                                            </div>
                                                            <div class="pl-2 pb-1">
                                                                <?php echo $add["street"]; ?><br>
                                                                <?php echo (!empty($add["city"]) ? $add["city"] . ' - ' : ' '); ?><?php echo $add["postcode"]; ?><br/>
                                                                <?php echo (!empty($add["state"]) ? $add["state"] . ', ' : ' '); ?> <?php echo $add["name"]; ?><br>
                                                                <abbr title="Phone">Mobile :</abbr> <?php echo $add["contact_number"]; ?>
                                                            </div>
                                                        </div>
                                                    </label>  
                                                </div>                                           
                                            <?php }
                                        } ?>
                                        <br><br>
                                    </form>
                                    <input type="hidden" name="hideuserid" id="hideuserid" value="<?php echo $this->session->userdata('user_id'); ?>">
                                </div>
                            </div>
                        </div>
                        <div class="list-button">
                            <a href="<?php echo base_url(); ?>product/shipping_form" class="mext-btn mext-btn-normal mext-btn-normal-secondary mext-btn-small" type="button"><i class="icon ion-android-add"></i> Add Shipping Address</a>
                        </div>
                    </div>
                </div>
            </div>
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/mobile/js/jquery-3.2.1.min.js"></script>
        <script  src="<?php echo base_url(); ?>assets/mobile/js/bootstrap.min.js"></script>
        <script>
            
            $(document).ready(function () {
                $('.default_address').click(function () {
                    var address_id = $(this).val();
                    var user_id = $("#hideuserid").val();
                    if (this.checked) {
                        $.ajax({
                            type: "POST",
                            url: '<?php echo base_url(); ?>m/product/change_address',
                            data: {
                                "address_id": address_id,
                                "user_id": user_id,
                            },
                            success: function (data) {
                                return true;
                            },
                            complete: function () {
                                var prod_id = sessionStorage.getItem('prod_id');
                                check_returnable(prod_id,address_id);                             
                            }
                        });
                    }
                });
            });
            
        function check_returnable(prod_id,address_id)
        { 
            if (prod_id !== '' && address_id !== '') {
                $.ajax({
                    url: '<?php echo base_url(); ?>userorder/check_returnable',
                    method: 'POST',
                    data: {prod_id: prod_id,pin_id: address_id},
                    success: function (data) {
                        var dat=data.split('|');
                        console.log(data);
                        if (dat[0] == 1)
                        {
                            sessionStorage.setItem('returnProd',1);
                        }
                        if (dat[0] == 0){
                             sessionStorage.setItem('returnProd',0);
                         }
                        window.location.href = "<?php echo $this->session->userdata('start_order_page'); ?>";
                    }
                });
            } else {

            }
        }
        </script>
    </body>
</html>
