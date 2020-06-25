<?php $this->load->view('front/common/header'); ?>

<div id="" style="background:#fff;">
    <div>
        <div id="about">
            <div class="lp-about">
                <div role="toolbar" dir="ltr" class="next-slick next-slick-inner next-slick-hoz">
                    <div class="next-slick-container next-slick-initialized">
                        <div class="next-slick-list">
                            <div class="next-slick-track"  style="">
                                <div class="" style="height:240px">
                                    <img src="<?php echo base_url(); ?>assets/front/images/banner/address.jpg"
                                         width="100%">
                                    <div class="main-slider-wrapper">
                                        <div class="w-1000">
                                            <h1 style="color:#fff;">Your address Book</h1>
                                            <h1  style="color:#fff;" >Inspection Services</h1>
                                            <div class="" style="text-align:left; color:#fff; font-size:16px;padding-top:15px;">
                                                Manage your address book </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="ab-ways w-1000" id="advantages">
                    <br/>              

                    <div class="next-tabs next-tabs-capsule next-medium">

                        <div class="row justify-content-md-center">
                            <div class="col-8 text-left p-0">
                                <nav>
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="<?php echo site_url(); ?>">Home</a></li>
                                        <li class="breadcrumb-item"><a href = "<?php echo site_url(); ?>buyer-addressbook">Address</a></li>
                                        <li class="breadcrumb-item active">Create</li>
                                    </ol>
                                </nav>
                            </div>
                        </div>
                        <div class="row justify-content-md-center">
                            <div class="col-8 text-left card p-2">
                                <h4>Add new address</h4>
                                <div>
                                    <button class='btn btn-sm btn-danger float-right' style="width:200px"  onclick="getLocationDetails()"> Get Current Location</button>
                                </div>
                                <br>
                                <form action="<?php echo site_url(); ?>buyer/addressbook/addnew" method="post" name="add_address"> 
                                    <div class="form-group pb-3">
                                        <label for="country">Country / region</label>
                                        <select name="country" id="country" class="form-control select">
                                            <option value="99">India</option>
                                        </select>
                                    </div>
                                    <div class="form-group pb-3">
                                        <label for="contact_person">Contact Person *</label>
                                        <input type="text" class="form-control" name="contact_person" id="contact_person" value="<?php echo set_value('contact_person'); ?>" onkeypress = "return restrictAlphabets(event)">
                                    </div>
                                    <?php echo form_error('contact_person'); ?>

                                    <div class="form-group pb-3">
                                        <label for="contact_person">Contact Number *</label>
                                        <input type="text" class="form-control" onkeypress="return restrictNumber(event)" maxlength="15" name="contact_number" id="contact_number" value="<?php echo set_value('contact_number'); ?>">
                                    </div>
                                    <?php echo form_error('contact_number'); ?>

                                    <div class="form-group pb-3">
                                        <label for="contact_person">Street1 *</label>
                                        <textarea class="form-control txtarea" name="street1" id="street1"><?php echo set_value('street1'); ?></textarea>
                                    </div>
                                    <?php echo form_error('street1'); ?>

                                    <div class="form-group pb-3">
                                        <label for="contact_person">Street2 *</label>
                                        <textarea class="form-control txtarea" name="street2" id="street2"><?php echo set_value('street2'); ?></textarea>
                                    </div>
                                    <?php echo form_error('street2'); ?>

                                    <div class="form-group pb-3">
                                        <label for="contact_person">City *</label>
                                        <input type="text" class="form-control" id="city" name="city">
                                    </div>
                                    <?php echo form_error('city'); ?>

                                    <div class="form-group pb-3">
                                        <label for="contact_person">State *</label>
                                        <input type="text" class="form-control" id="state" name="state">
                                    </div>
                                    <?php echo form_error('state'); ?>

                                    <div class="form-group pb-3">
                                        <label for="contact_person">Postcode *</label>
                                        <input type="text" class="form-control pincode" onkeypress="return restrictNumber(event)" maxlength="6" name="postal_code" id="postal_code">
                                    </div>
                                    <p id="areacode"></p>
                                    <?php echo $this->session->flashdata("message"); ?>
                                    <?php echo form_error('postal_code'); ?>

                                    <div class="form-group pb-3">
                                        <label for="tag">Address type *</label>
                                        <?php echo form_dropdown('tag', $tags, "class='form-control'"); ?>
                                    </div>
                                    <?php echo form_error('tag'); ?>

                                    <br />
                                    <button type="submit" class="btn btn-primary btn-info pull-right">Submit</button>
                                </form>
                            </div>

                        </div><br><br>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
<?php $this->load->view('front/common/footer'); ?>
<script type="text/javascript">
    function restrictAlphabets(e) {
        var x = e.which || e.keycode;
        if ((x >= 65 && x <= 90) || (x >= 97 && x <= 122) || (x >= 48 && x <= 57) || x == 46 || x == 8 || x == 32)
            return true;
        else
            return false;
    }

    function restrictNumber(e) {
        var x = e.which || e.keycode;
        if ((x >= 48 && x <= 57) || x == 8)
            return true;
        else
            return false;
    }
</script>
<script>
    $("#find_btn").click(function () { //user clicks button
        if ("geolocation" in navigator) { //check geolocation available 
            //try to get user current location using getCurrentPosition() method
            navigator.geolocation.getCurrentPosition(function (position) {
                $("#result").html("Found your location <br />Lat : " + position.coords.latitude + " </br>Lang :" + position.coords.longitude);
            });
        } else {
            console.log("Browser doesn't support geolocation!");
        }
    });

    ////////////////////////////////////////////////////////////////////////////////
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
                        $("#street2").val(address2);
                        $("#street1").val(address1);
                        $("#city").val(city);
                        $("#state").val(state);

                        $("#postal_code").val(pinCode);

                        document.getElementById("val").innerHTML = country +
                                " | " + state + " | " + address1 + "|" + address2 + "|" + address3 + "|" + pinCode;
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