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
                                    <h4>Update Address</h4>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="page-header-breadcrumb">
                                <ul class="breadcrumb-title">
                                    <li class="breadcrumb-item">
                                        <a href="<?php echo site_url(); ?>seller/dashboard"> <i class="feather icon-home"></i> </a>
                                    </li>
                                    <li class="breadcrumb-item"><a href="<?php echo site_url(); ?>seller/pickupaddress">Address</a></li>

                                    <li class="breadcrumb-item"><a href="#!">Update Address</a></li>
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

                                    <form method="post" enctype="multipart/form-data">
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Name</label>
                                            <div class="col-sm-10">
                                                <input type="text" value="<?php echo $addr_data['seller_name']; ?>" name="seller_name" id="seller_name" class="form-control" placeholder="Name" required>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Email</label>
                                            <div class="col-sm-10">
                                                <input type="text" value="<?php echo $addr_data['seller_email']; ?>" name="seller_email" id="seller_email" class="form-control" placeholder="Email" required>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Mobile</label>
                                            <div class="col-sm-10">
                                                <input type="number" value="<?php echo $addr_data['seller_mobile']; ?>" name="seller_mobile" id="seller_mobile" class="form-control" placeholder="Mobile Number" required>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Address Type</label>
                                            <div class="col-sm-10">
                                                <input type="text" value="<?php echo $addr_data['address_type']; ?>" name="address_type" id="address_type" class="form-control" placeholder="Address Type" required>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Address</label>
                                            <div class="col-sm-10">
                                                <div class="input-group">
                                                    <input type="text" value="<?php echo $addr_data['address']; ?>" name="address" id="address" class="form-control" placeholder="Address" required >
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Address 2</label>
                                            <div class="col-sm-10">
                                                <div class="input-group">
                                                    <input type="text" value="<?php echo $addr_data['address2']; ?>" name="address2" id="address2" class="form-control" placeholder="Address 2" required >
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Address 3</label>
                                            <div class="col-sm-10">
                                                <div class="input-group">
                                                    <input type="text" value="<?php echo $addr_data['address3']; ?>" name="address3" id="address3" class="form-control" placeholder="Address 3" required >
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Office Close (24 hrs)</label>
                                            <div class="col-sm-10">
                                                <div class="input-group">
                                                    <input type="time"  value="<?php echo $addr_data['office_close']; ?>" name="office_close" id="office_close" class="form-control" placeholder="00:00" required >
                                                </div>
                                            </div>
                                        </div> 
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">State</label>
                                            <div class="col-sm-10">
                                                <div class="input-group">
                                                    <input type="text" value="<?php echo $addr_data['state']; ?>" name="state" id="state" class="form-control" placeholder="state" required >
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Country</label>
                                            <div class="col-sm-10">
                                                <select class="form-control" name="country">
                                                    <option value="">Select Country</option>
                                                    <?php
                                                    foreach ($country as $co) {
                                                        echo'<option value="' . $co["id"] . '"';
                                                        if ($co["id"] == $addr_data['country']) {
                                                            echo'selected';
                                                        }
                                                        echo '>' . $co["name"] . '</option>';
                                                    }
                                                    ?>

                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Pincode</label>
                                            <div class="col-sm-10">
                                                <div class="input-group">
                                                    <input type="number" value="<?php echo $addr_data['pincode']; ?>" name="pincode" maxlength="6" id="pincode" class="form-control" placeholder="Pincode" required >
                                                </div>
                                                <p id="areacode"></p>
                                                <?php echo $this->session->flashdata("message"); ?>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Is Default</label>
                                            <div class="col-sm-10">
                                                <div class="input-group">
                                                    <input type="checkbox" <?php
                                                    if ($addr_data['is_default'] == 1) {
                                                        echo 'checked';
                                                    }
                                                    ?> name="is_default" id="is_default" value="1" >
                                                </div>
                                            </div>
                                        </div>

                                        <button type="submit" id="submit_brand" class="btn btn-primary pull-right" id="primary-popover-content">Update</button>
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
<script>
    $('#pincode').keyup(function () {
        var pincode = $('#pincode').val();

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
            if (cg_length > 6)
            {
                $('#pincode').val('');
            }
            $("#areacode").html("<span style='color:#DC3545'>Enter Valid Pin Code</span>");
        }
    });
</script> 
<?php $this->load->view("user/common/footer"); ?>