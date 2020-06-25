<html data-dpr="2" style="font-size: 75px;"><head>
        <meta charset="utf-8">
        <title>Start Order</title>
        <meta name="viewport" content="width=device-width,user-scalable=no,initial-scale=0.5,maximum-scale=0.5,minimum-scale=0.5">
        <meta name="google-site-verification" content="nP5Df-TYNWX_nGB7Qum5d5I4cXzd3E7A2TXtZ0Y2x_Q" /> 
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/mobile/mobile/index3.css">
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/mobile/mobile/molar.js"></script>
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/mobile/css/ionicons.min.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/mobile/css/font-awesome.min.css">
        <script src="https://code.jquery.com/jquery-1.11.3.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/front/js/jquery.validate.min.js"></script> 
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/front/js/custome_validation.js"></script>
        <!-- Global site tag (gtag.js) - Google Analytics -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=UA-144123824-1"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag() {
                dataLayer.push(arguments);
            }
            gtag('js', new Date());

            gtag('config', 'UA-144123824-1');
        </script>

        <script>
            !function (f, b, e, v, n, t, s)
            {
                if (f.fbq)
                    return;
                n = f.fbq = function () {
                    n.callMethod ?
                            n.callMethod.apply(n, arguments) : n.queue.push(arguments)
                };
                if (!f._fbq)
                    f._fbq = n;
                n.push = n;
                n.loaded = !0;
                n.version = '2.0';
                n.queue = [];
                t = b.createElement(e);
                t.async = !0;
                t.src = v;
                s = b.getElementsByTagName(e)[0];
                s.parentNode.insertBefore(t, s)
            }(window, document, 'script',
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
            function gtag() {
                dataLayer.push(arguments);
            }
            gtag('js', new Date());

            gtag('config', 'AW-728750276');
    </script>
    <style>
        [data-dpr="2"] .mext-form-inset .mext-form-item-label {
            font-size: 28px !important;
        }
        [data-dpr="2"] .mext-input-single input {
            font-size: 28px !important;
        }
        .select {
            text-transform: none;
            width: 100%;
            height: 71px;
            border:0px;
        }

        .select  option
        {
            font-size:12px;
        }

        #contact_person{
            text-align: left;
            margin-top: 10px;
            width: 100%;
            color: #fe5d70;
            margin-left: 20px;
        }
        #country{
            text-align: left;
            margin-top: 10px;
            width: 100%;
            color: #fe5d70;
            margin-left: 20px;
        }
        #street{
            text-align: left;
            margin-top: 10px;
            width: 100%;
            color: #fe5d70;
            margin-left: 20px;
        }
        #city{
            text-align: left;
            margin-top: 10px;
            width: 100%;
            color: #fe5d70;
            margin-left: 20px;
        }
        #state{
            text-align: left;
            margin-top: 10px;
            width: 100%;
            color: #fe5d70;
            margin-left: 20px;
        }
        #postcode{
            text-align: left;
            margin-top: 10px;
            width: 100%;
            color: #fe5d70;
            margin-left: 20px;
        }
        #contact_number{
            text-align: left;
            margin-top: 10px;
            width: 100%;
            color: #fe5d70;
            margin-left: 20px;
        }

    </style>
</head>
<body data-spm="trade-order-buynow-h5">
    <div id="app">
        <div data-reactroot="" id="buynow-page" class="">		  
            <div class="mext-slip mext-slip-left address-form-slip mext-animate slideInLeft" style="z-index: 399; width: 100%; animation-duration: 300ms; animation-delay: 0ms;">
                <div class="mext-slip-content">
                    <div class="mext-nav mext-nav-normal mext-nav-layout-normal mext-nav-fixed" style="top: 0px;">
                        <div class="mext-nav-segment mext-nav-segment-left mext-nav-segment-custom" type="custom">
                            <div class="mext-nav-item mext-nav-segment-back mext-nav-item-custom" type="custom">
                                <a href="<?php echo $this->session->userdata("start_order_page"); ?>">
                                    <i class="icon ion-android-arrow-back"style="color:#818181; font-size:46px;"></i> </a></div>
                        </div>
                        <div class="mext-nav-segment mext-nav-segment-center mext-nav-segment-custom mext-nav-left" type="custom">
                            <div class="mext-nav-item mext-nav-item-title" type="title">Shipping Address</div>
                        </div>
                    </div>

                    <div class=" address-form ">
                        <div class="inner-input-box flex-10" style="text-align:center">
                            <button class="mext-btn mext-btn-fixed-primary btn btn-block" style="margin:12px 10px; padding:15px;" onclick="getLocationDetails()" ><i class="fa fa-map-marker" aria-hidden="true"></i> Get Current location</button> 
                        </div>
                        
                        <form style="padding:0.1rem 0 !important; " class="mext-form address-form mext-form-inset" action="<?php echo base_url(); ?>product/submit_shipping_form" method="post" name="add_shipping_address">
                            <div class="mext-form-item mext-form-item-left" name="fullName" label="Contact Name">
                                <div class="mext-form-item-wrapper">
                                    <div class="mext-form-item-control-row">
                                        <label class="mext-form-item-label">Contact Name <span style="color:red">*</span></label>
                                        <div class="mext-form-item-control">
                                            <div class="mext-input medium mext-input-single mext-input-inset mext-input-in-form">
                                                <div class="inner-flex">
                                                    <div class="inner-input-box flex-10">
                                                        <input type="text" value="<?php echo set_value("contact_person"); ?>" name="contact_person" placeholder="Enter contact name" maxlength="20" style="text-align: left;" required="required" pattern="[a-zA-Z ]{1,}" title="Please Enter Character Only"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <span><?php echo form_error('contact_person'); ?></span>
                            <div id="contact_person"></div>

                            <div class="mext-form-item mext-form-item-has-arrow mext-form-item-left" name="countryCode" label="Country/Region">
                                <div class="mext-form-item-wrapper">
                                    <div class="mext-form-item-control-row">
                                        <label class="mext-form-item-label">Country/Region<span style="color:red">*</span></label>
                                        <div class="mext-form-item-control">
                                            <div class="mext-select mext-select-inset mext-select-arrow mext-select-in-form">
                                                <select name="country" class="form-control select">	
                                                    <option value="99" selected>India</option>
                                                </select>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <div class="mext-form-item mext-form-item-has-arrow mext-form-item-left" name="countryCode" label="Country/Region">
                                <div class="mext-form-item-wrapper">
                                    <div class="mext-form-item-control-row">

                                        <label class="mext-form-item-label">Address Type<span style="color:red">*</span></label>
                                        <div class="mext-form-item-control">
                                            <div class="mext-select mext-select-inset mext-select-arrow mext-select-in-form">
                                                <select name="address_type" class="form-control select" required>	
                                                    <option value="" selected>--Select Address Type--</option>
                                                    <option value="Factory" >Factory</option>
                                                    <option value="Residential" >Residential</option>
                                                    <option value="Warehouse" >Warehouse</option>
                                                </select>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <span><?php echo form_error('address_type'); ?></span>
                            <div id="country"></div>
                            <div class="mext-form-item mext-form-item-left" name="address" label="Stree Adress">
                                <div class="mext-form-item-wrapper">
                                    <div class="mext-form-item-control-row">
                                        <label class="mext-form-item-label">Address <span style="color:red">*</span></label>
                                        <div class="mext-form-item-control">
                                            <div class="mext-input medium mext-input-single mext-input-inset mext-input-in-form">
                                                <div class="inner-flex">
                                                    <div class="inner-input-box flex-10">
                                                        <input type="text" value="<?php echo set_value("street"); ?>" name="street" id="street" placeholder="building number,Street1" maxlength="128" style="text-align: left;" required="required"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="street"></div>
                            <div class="mext-form-item mext-form-item-left" name="alternateAddress">
                                <div class="mext-form-item-wrapper">
                                    <div class="mext-form-item-control-row">
                                        <div class="mext-form-item-control">
                                            <div class="mext-input medium mext-input-single mext-input-inset mext-input-in-form">
                                                <div class="inner-flex">
                                                    <div class="inner-input-box flex-10">
                                                        <input type="text" value="" name="alternateAddress" placeholder="apt.,P.P.box,etc" maxlength="40" style="text-align: left;"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <span><?php echo form_error('street'); ?></span>
                             <div class="mext-form-item mext-form-item-left" name="zip" label="Zip code ">
                                <div class="mext-form-item-wrapper">
                                    <div class="mext-form-item-control-row">
                                        <label class="mext-form-item-label">Post code <span style="color:red">*</span></label>

                                        <div class="mext-form-item-control">
                                            <div class="mext-input medium mext-input-single mext-input-inset mext-input-in-form">
                                                <div class="inner-flex">
                                                    <div class="inner-input-box flex-10">
                                                        <input type="number" value="<?php echo set_value('postcode'); ?>" name="postcode" id = "postcode" placeholder="Enter a Post code" maxlength="6" style="text-align: left;" required="required" pattern="[0-9]{6,6}" title="Please Enter Post Code"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <span><?php echo form_error('postcode'); ?></span>
                            <div id="postcode"></div>
                            <div class="mext-form-item mext-form-item-left" name="city" label="City">
                                <div class="mext-form-item-wrapper">
                                    <div class="mext-form-item-control-row">
                                        <label class="mext-form-item-label">City <span style="color:red">*</span></label>
                                        <div class="mext-form-item-control">
                                            <div class="mext-input medium mext-input-single mext-input-inset mext-input-in-form">
                                                <div class="inner-flex">
                                                    <div class="inner-input-box flex-10">
                                                        <input type="text" value="<?php echo set_value("city"); ?>" name="city" id="city" placeholder="Enter a city" maxlength="64" style="text-align: left;" required="required" pattern="[a-zA-Z ]{1,}" title="Please Enter Character"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <span><?php echo form_error('city'); ?></span>
                            <div id="city"></div>
                            <div class="mext-form-item mext-form-item-left" name="province" label="State">
                                <div class="mext-form-item-wrapper">
                                    <div class="mext-form-item-control-row">
                                        <label class="mext-form-item-label">State <span style="color:red">*</span></label>
                                        <div class="mext-form-item-control">
                                            <div class="mext-input medium mext-input-single mext-input-inset mext-input-in-form">
                                                <div class="inner-flex">
                                                    <div class="inner-input-box flex-10">
                                                        <input type="text" value="<?php echo set_value("state"); ?>" name="state" id="state" placeholder="Enter a state" maxlength="64" style="text-align: left;" required="required" pattern="[a-zA-Z ]{1,}" title="Please Enter Character"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <span><?php echo form_error('state'); ?></span>
                            <div id="state"></div>
                           
                            <div class="mext-form-item mext-form-item-left" name="mobileNumber" label="mobile">
                                <div class="mext-form-item-wrapper">
                                    <div class="mext-form-item-control-row">
                                        <label class="mext-form-item-label">Contact Person <span style="color:red">*</span></label>
                                        <div class="mext-form-item-control">
                                            <div class="mext-input medium mext-input-single mext-input-inset mext-input-in-form">
                                                <div class="inner-flex">
                                                    <div class="inner-input-box flex-10"><input type="number" name="contact_number" value="<?php echo set_value('contact_number'); ?>" placeholder="Enter a Mobile number" maxlength="10" style="text-align: left;" required="required" pattern="[0-9]{10,10}" title="Please Enter Mobile Number"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <span><?php echo form_error('contact_number'); ?></span>
                            <div id="contact_number"></div>
                            <p id="error_addr" style="text-align:center;"></p>
                            <input type="hidden" name="hide_user_id" value="<?php echo $this->session->userdata('user_id'); ?>" placeholder="" maxlength="16" style="text-align: left;">
                            <div class="mext-form-control fixed">
                                <div class="mext-btn-group mext-btn-group-block mext-btn-group-fixed"><button class="mext-btn mext-btn-fixed mext-btn-fixed-primary" type="submit">Ship to This address</button></div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        var country, state, city, pinCode, address1, address12, address3;

        function createCORSRequest(method, url) {
            var xhr = new XMLHttpRequest();

            if ("withCredentials" in xhr) {
                // XHR for Chrome/Firefox/Opera/Safari.
                xhr.open(method, url, true);

            } else if (typeof XDomainRequest != "undefined") {
                // XDomainRequest for IE.
                xhr = new XDomainRequest();
                xhr.open(method, url);

            } else {
                // CORS not supported.
                xhr = null;
            }
            return xhr;
        }
        function getLocationDetails() {
            if ("geolocation" in navigator) { //check geolocation available 

                navigator.geolocation.getCurrentPosition(function (position) {

                    $("#result").html("Found your location <br />Lat : " + position.coords.latitude + " </br>Lang :" + position.coords.longitude);
                    latitude1 = position.coords.latitude;
                    longitude1 = position.coords.longitude;
                    //alert(latitude1 + ' ' + longitude1);
                    //latitude1=position.coords.latitude;
                    //longitude1=position.coords.longitude;
                    var url = "https://maps.googleapis.com/maps/api/geocode/json?latlng=" +
                            latitude1 + "," + longitude1 + "&sensor=true" + "&key=AIzaSyA3n-18QsM5JsNRtlPLNvuSBFV5g2Z1YOc";
                    var xhr = createCORSRequest('POST', url);
                    if (!xhr) {
                        alert('CORS not supported');
                    }

                    xhr.onload = function () {

                        var data = JSON.parse(xhr.responseText);

                        if (data.results.length > 0) {
                            console.log(data.results);
                            var locationDetails = data.results[1].formatted_address;
                            var value = locationDetails.split(",");

                            count = value.length;

                            address3 = value[count - 7];
                            address2 = value[count - 6];
                            address1 = value[count - 5];
                            country = value[count - 1];
                            state = value[count - 2];
                            city = value[count - 3];
                            pin = state.split(" ");
                            pinCode = pin[pin.length - 1];
                            state = state.replace(pinCode, ' ');
                            // $("#street2").val(address2+' '+ address3);
                            $("#street").val(address1).css('color','#000');;
                            $("#city").val(city).css('color','#000');;
                            $("#state").val(state).css('color','#000');
                            $("#postcode").val(pinCode).css('color','#000');

                        } else {
                            document.getElementById("messageBox").style.visibility = "visible";
                            document.getElementById("message").innerHTML =
                                    "No location available for provided details.";
                        }

                    };

                    xhr.onerror = function () {
                        alert('Woops, there was an error making the request.');

                    };
                    xhr.send();
                });


            } else {
                console.log("Browser doesn't support geolocation!");
            }
        }
        
        
         $(document).on("blur", "#postcode", function () {

                    var pincode = $(this).val();
                    $.ajax({
                        url: "<?php echo site_url(); ?>userorder/getArea",
                        type: "POST",
                        data: {pincode: pincode},
                        success: function (resp) {
                            var obj = JSON.parse(resp);
                            if (obj.status) {
                                $("#city").val(obj.data.city);
                                $("#state").val(obj.data.state);
                                $("#error_addr").text("This pincode is deliverable");
                                  $('#error_addr').css("color", "green");
                            } else {
                                $("#error_addr").text("This pincode is not deliverable");
                                 $('#error_addr').css("color", "red");
                                $("#city").val("");
                                $("#state").val("");
                            }
                        }
                    })
                });


    </script>
    <script>
                $('.pincode').keyup(function () {
                var pincode = $('.pincode').val();
                var cg_length = pincode.length;
                if (cg_length == 6) {
                    $.ajax({
                        url: '<?php echo base_url(); ?>home_product/check_pincode',
                        method: 'POST',
                        dataType: 'json',
                        data: {pincode: pincode},
                        success: function (data) {
                            if (data==0)
                            {
                                $("#areacode").html("<span style='color:red'>Sorry ! Not Deliverable Pincode.</span>");
                            }
                            else if (data==1) {
                                $("#areacode").html("<span style='color:green'>Success ! Deliverable Pincode.</span>");
                            } else {
                                $("#areacode").html("<span style='color:#DC3545'>Sorry ! Not Deliverable  Pincode.</span>");
                            }
                        }
                    });
                } else {
                    $("#areacode").html("<span style='color:#DC3545'>Enter Valid Pin Code</span>");
                }
            }); 
            
    </script>
</body>
</html>
