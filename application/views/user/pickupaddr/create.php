<?php $this->load->view("user/common/header"); ?>
<div class="pcoded-content">
    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-header">
                    <div class="row align-items-end">
                        <div class="col-lg-8">
                            <div class="page-header-title">
                                <div class="d-inline">
                                    <h4>Add Address </h4>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="page-header-breadcrumb">
                                <ul class="breadcrumb-title">
                                    <li class="breadcrumb-item">

                                        <a href="<?php echo base_url() ?>seller/dashboard"> <i class="feather icon-home"></i> </a>
                                    </li>
                                    <li class="breadcrumb-item"><a href="<?php echo site_url(); ?>seller/pickupaddress">Address</a></li>
                                    <li class="breadcrumb-item"><a href="#!">Add Address</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="page-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="card">
                                <div class="card-header">
                                    <div class="card-header-right">
                                        <i class="icofont icofont-spinner-alt-5"></i>
                                    </div>
                                </div>
                                <div class="card-block">

                                    <form method="post" enctype="multipart/form-data" name="add_address2" id="frm_pickAddr">
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Name *</label>
                                            <div class="col-sm-10">
                                                <input type="text" name="seller_name" id="seller_name" class="form-control txt_box" placeholder="Name" >
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Email *</label>
                                            <div class="col-sm-10">

                                              <!--   <input type="email" name="seller_email" id="seller_email" class="form-control " placeholder="Email" > -->

                                                <input type="email" name="seller_email" id="seller_email" class="form-control email_box" placeholder="Email" >

                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Mobile *</label>
                                            <div class="col-sm-10">
                                                <input type="text" name="seller_mobile" onkeypress="return isNumber();" id="seller_mobile" class="form-control" placeholder="Mobile Number"  >
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Address Type</label>
                                            <div class="col-sm-10">
                                                <select name="address_type" id="address_type" class="form-control" >
                                                    <option value="Business">Business</option>
                                                    <option value="Factory">Factory</option>
                                                    <option value="Residential">Residential</option>
                                                    <option value="Werehouse">Warehouse</option>
                                                </select>
                                                <!--<input type="text" name="address_type" id="address_type" class="form-control" placeholder="Address Type" required>-->
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Address 1 *</label>
                                            <div class="col-sm-10">
                                                <div class="">
                                                    <input type="text" name="address" id="address" class="form-control" placeholder="Address"  >
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Address 2 *</label>
                                            <div class="col-sm-10">
                                                <div class="">
                                                    <input type="text" name="address2" id="address2" class="form-control" placeholder="Address 2"  >
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Address 3 *</label>
                                            <div class="col-sm-10">
                                                <div class="">
                                                    <input type="text" name="address3" id="address3" class="form-control" placeholder="Address 3"  >
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Office Close (24 hrs) *</label>
                                            <div class="col-sm-10">
                                                <div class="">
                                                    <input type="time" name="office_close" id="office_close" class="form-control" placeholder="00:00" >
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">City *</label>
                                            <div class="col-sm-10">
                                                <div class="">
                                                    <input type="text" name="city" id="city" class="form-control txt_box" placeholder="City"  >
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">State *</label>
                                            <div class="col-sm-10">
                                                <div class="">
                                                    <input type="text" name="state" id="state" class="form-control txt_box" placeholder="State"  >
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Country *</label>
                                            <div class="col-sm-10">
                                                <select class="form-control" name="country">
                                                    <option value="">Select Country</option>
                                                    <?php
                                                    foreach ($country as $co) {
                                                        echo'<option value="' . $co["id"] . '">' . $co["name"] . '</option>';
                                                    }
                                                    ?>

                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Pincode *</label>
                                            <div class="col-sm-10">
                                                <div class="">
                                                    <input type="text" maxlength="6" onkeypress="return isNumber();" name="pincode" id="pincode" class="form-control pincode" maxlength="6" placeholder="Pincode"  >
                                                </div>
                                                <p id="areacode"></p>
                                                <?php echo $this->session->flashdata("message"); ?>
                                            </div>

                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Is Default</label>
                                            <div class="col-sm-10">
                                                <div class="input-group">
                                                    <input type="checkbox" name="is_default" id="is_default" value="1" >
                                                </div>
                                            </div>
                                        </div>
                                        <input type="hidden" class="pro_idd" value="<?php echo $this->session->userdata("user_id"); ?>">
                                        <button type="submit" id="submit_brand" class="btn btn-primary pull-right" id="primary-popover-content">Add</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
</div>
</div>
</div>

<?php $this->load->view("user/common/footer"); ?>
<script>
    function isNumber(evt)
    {
        evt = (evt) ? evt : window.event;
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode > 31 && (charCode < 48 || charCode > 57)) {
            return false;
        }
        return true;
    }

    $(document).ready(function () {
        $("#frm_pickAddr").validate({
            rules: {
                seller_name: "required",
                seller_mobile: {
                    required: true,
                    maxlength: 10
                },
                seller_email: {
                    required: true,
                    email: true
                },
                address_type: "required",
                address: {
                    required: true,
                    maxlength: 30
                },
                address2: {
                    required: true,
                    maxlength: 30
                },
                address3: {
                    required: true,
                    maxlength: 30
                },
                pincode: {
                    required: true,
                    maxlength: 6,
                    digit: true
                },
                office_close: "required",
                state: "required",
                city: "required",
                country: "required",
            },
            messages: {
                seller_name: "Enter Contact person name",
                seller_mobile: {
                    required: "Enter 10 digit mobile number",
                    maxlength: "Enter 10 digit mobile number"
                },
                seller_email: {
                    required: "Enter valid email",
                    email: "Enter valid email"
                },
                address_type: "Select address type",
                address: {
                    required: "Enter max 30 character address",
                    maxlength: "Enter max 30 character address"
                },
                address2: {
                    required: "Enter max 30 character address",
                    maxlength: "Enter max 30 character address"
                },
                address3: {
                    required: "Enter max 30 character address",
                    maxlength: "Enter max 30 character address"
                },
                pincode: {
                    required: "Enter 6 digit pin",
                    maxlength: "Enter 6 digit pin"
                },
                office_close: "Enter max allowed pickup time",
                state: "Enter state",
                city: "Enter city",
                country: "Select Country",
            },
            errorClass: "text-danger"
        });
    });

    $('#pincode').keyup(function () {
        var pincode = $('#pincode').val();

        var cg_length = pincode.length;
        var seller_id = $('.pro_idd').val();
        if (cg_length == 6) {
            $.ajax({
                url: '<?php echo base_url(); ?>home_product/check_pincode',
                method: 'POST',
                dataType: 'json',
                data: {pincode: pincode,sell_id: seller_id},
                success: function (data) {
                    console.log(data);
                    if (data == 0)
                    {
                        $("#areacode").html("<span style='color:red'>Sorry ! Not Deliverable Pincode.</span>");
                    } else if (data == 1) {
                        $("#areacode").html("<span style='color:green'>Success ! Deliverable Pincode.</span>");
                    } else {
                        $("#areacode").html("<span style='color:#DC3545'>Sorry ! Not Deliverable  Pincode.</span>");
                    }
                }
            });
        } else {
            if (cg_length > 6)
            {
                $('#pincode').val('');
            }
            $("#areacode").html("<span style='color:#DC3545'>Enter Valid Pin Code</span>");
        }
    });


    /*
     @author Ishwar04092019
     THis function Prevent the Spcial character while adding pickup address
     */

    $(function () {

        $('.txt_box').keyup(function ()
        {
            var yourInput = $(this).val();
            re = /[`~!@#$%^&*()_|+\-=?;:'",.<>\{\}\[\]\\\/]/gi;
            var isSplChar = re.test(yourInput);
            if (isSplChar)
            {
                var no_spl_char = yourInput.replace(/[`~!@#$%^&*()_|+\-=?;:'",.<>\{\}\[\]\\\/]/gi, '');
                $(this).val(no_spl_char);
            }
        });

        $('.email_box').keyup(function ()
        {
            var yourInput = $(this).val();
            re = /[`~!#$%^&*()_|+\-=?;:'",<>\{\}\[\]\\\/]/gi;
            var isSplChar = re.test(yourInput);
            if (isSplChar)
            {
                var no_spl_char = yourInput.replace(/[`~!@#$%^&*()_|+\-=?;:'",.<>\{\}\[\]\\\/]/gi, '');
                $(this).val(no_spl_char);
            }
        });

    });


</script> 