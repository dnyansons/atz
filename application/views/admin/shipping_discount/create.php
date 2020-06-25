<?php $this->load->view("admin/common/header"); ?>
<style>
    .optionGroup {
        font-weight: bold;
        font-style: italic;
    }
    .multiselect-container{
        position: absolute !important;
        transform: translate3d(0px, 0px, 0px); 
        top: 42px;
        width: 400px;
        height: 300px;
        overflow-y: scroll !important;
        left: 0px;
        will-change: transform;
    }

    label.text{position:absolute!important; bottom:-27px !important;}
    .text{margin-top: 0px !important;}
    .form-group{margin-bottom: 2rem}
</style>
<div class="pcoded-content">
    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">

                <div class="page-header">
                    <div class="row align-items-end">
                        <div class="col-lg-8">
                            <div class="page-header-title">
                                <div class="d-inline">
                                    <h4>Add Shipping Offer</h4>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="page-header-breadcrumb">
                                <ul class="breadcrumb-title">
                                    <li class="breadcrumb-item">
                                        <a href="<?php echo site_url(); ?>admin/dashboard"> <i class="feather icon-home"></i> </a>
                                    </li>
                                    <li class="breadcrumb-item"><a href="<?php echo site_url(); ?>admin/Shipping_Discount">Shipping Discount</a></li>
                                    <li class="breadcrumb-item"><a href="#!">Add Shipping</a></li>
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
                                    <h4 class="sub-title">New Offer</h4>
                                    <form action="<?php echo site_url(); ?>admin/offer/addoffer" method="post" enctype='multipart/form-data' name="offer_form">
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Offer Title<sup><span style="color:red;">&nbsp;&nbsp;*</span></sup></label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" maxlength="60" name="title" value="<?php echo set_value('title'); ?>">
                                                <?php echo form_error("title"); ?>
                                            </div>    
                                        </div>    

                                       <!--  <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Offer Type<sup><span style="color:red;">&nbsp;&nbsp;*</span></sup></label>
                                            <div class="col-sm-10">
                                                <select class="form-control" name="offer_type" id="offer_type">
                                                    <option value="">Select Offer Type</option>
                                                    <option value="flat">Flat</option>
                                                    <option value="percentage">Percentage</option>
                                                </select>
                                                <?php echo form_error("offer_type"); ?>
                                            </div>
                                        </div> -->

                                       
                                        <div class="form-group row">
                                            <label class="col-sm-2" class="col-form-label">Select Category<sup><span style="color:red;">&nbsp;&nbsp;*</span></sup></label>
                                            <div class="col-sm-10">

                                               <!-- <select name="category_id" class="form-control" id="category_id" multiple="multiple">-->
                                                <select name="category_id" id="category_id" class="form-control">
                                                    <option value = "">Select Category</option>
                                                    <?php
                                                    $i = 1;

                                                    foreach ($categories_list as $category) {
                                                        if (count($category->sub) > 0) {

                                                            $selectParent = $category->category_id == $banners->category ? 'selected' : '';
                                                            echo "<option class='optionGroup' value='' $selectParent><b>" . $category->categories_name . "</b></option>";

                                                            foreach ($category->sub as $cat) {

                                                                if ($cat->category_id == $products_data->categories_id) {
                                                                    echo "<option value='" . $cat->category_id . "' selected='selected'>&nbsp;&nbsp;" . $cat->categories_name . "</option>";
                                                                } else {
                                                                    echo "<option value='" . $cat->category_id . "'>&nbsp;&nbsp;" . $cat->categories_name . "</option>";
                                                                }
                                                            }
                                                            //echo "</optgroup>";
                                                            ?>
                                                            <?php
                                                        } else {
                                                            echo "<option value=''>&nbsp;&nbsp;" . $category->categories_name . "</option>";
                                                        }
                                                        ?>
                                                    <?php } ?> ?>
                                                </select>
                                                <?php echo form_error("category_id"); ?>
                                            </div>    
                                        </div> 

                                         <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Select Discount<sup><span style="color:red;">&nbsp;&nbsp;*</span></sup></label>
                                            <div class="col-sm-10">
                                                <input type="number" min="1" name="discount_value" id="discount_value" class="form-control" placeholder="0" value="<?php echo set_value('discount_value'); ?>">
                                                <?php echo form_error("discount_value"); ?>
                                            </div>
                                        </div>

                                    <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Select ZoneRegions<sup><span style="color:red;">&nbsp;&nbsp;*</span></sup></label>
                                            <div class="col-sm-10">
                                                <input type="number" min="1" name="discount_value" id="discount_value" class="form-control" placeholder="0" value="<?php echo set_value('discount_value'); ?>">
                                                <?php echo form_error("discount_value"); ?>
                                            </div>
                                        </div>


                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Start Date<sup><span style="color:red;">&nbsp;&nbsp;*</span></sup></label>
                                            <div class="col-sm-5">
                                                <div class="input-group date">
                                                    <input type="text" name="valid_from" id="valid_from" class="form-control date" placeholder="yyyy-mm-dd" data-format="yyyy-mm-dd" required readonly="readonly" value="<?php echo set_value('valid_from'); ?>">
                                                    <div class="input-group-addon">
                                                        <span class="fa fa-calendar"></span>
                                                    </div>

                                                </div>
                                                <?php echo $this->session->flashdata('message'); ?>
                                                <?php echo form_error("message"); ?>
                                            </div>          
                                            
                                            <div class='col-sm-5'>
                                                <div class='input-group datetimepicker'>
                                                    <input type='text' name="time_from" class="form-control" value="<?php echo set_value('time_from'); ?>"/>
                                                    <div class="input-group-addon">
                                                        <span class="fa fa-clock-o "></span>
                                                    </div>

                                                </div> 
                                                <?php echo form_error("time_from"); ?>
                                            </div>

                                        </div>


                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">End Date<sup><span style="color:red;">&nbsp;&nbsp;*</span></sup></label>
                                            <div class="col-sm-5">

                                                <div class="input-group date">
                                                    <input type="text" name="valid_to" id="valid_to" class="form-control date" placeholder="yyyy-mm-dd" data-format="yyyy-mm-dd" required readonly="readonly" value="<?php echo set_value('valid_to'); ?>">
                                                    <div class="input-group-addon">
                                                        <span class="fa fa-calendar"></span>
                                                    </div>

                                                </div>
                                                <?php echo form_error("valid_to"); ?>

                                            </div>
                                            <div class='col-sm-5'>
                                                <div class='input-group datetimepicker'>
                                                    <input type='text' name="time_to" class="form-control" value="<?php echo set_value('time_to'); ?>"/>
                                                    <div class="input-group-addon">
                                                        <span class="fa fa-clock-o "></span>
                                                    </div>

                                                </div>   
                                                <?php echo form_error("time_to"); ?>
                                            </div>
                                        </div>
                                        <button type="submit" id="submit_brand" class="btn btn-primary pull-right" id="primary-popover-content">Add Offer</button>
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

<?php $this->load->view("admin/common/footer"); ?>
<script>
    $(document).ready(function () {

    $('.date').datepicker({
   // useCurrent: true //Important! See issue #1075
            format: "yyyy-mm-dd",
            autoclose: true,
            todayHighlight: true,
            //startDate: today,
            //endDate: end
    });
            $("#selcategory").change(function () {
    var cat = $(this).val();
            $.ajax({
            url: "<?php echo site_url(); ?>admin/Coupon/getAjaxProducts",
                    type: "POST",
                    data: {category_id: cat},
                    //datatype:"json",
                    success: function (resp) {

                    var obj = JSON.parse(resp);
                            console.log(obj);
                            $("#products").empty();
                            $(obj.data).each(function (index, value) {
                    console.log(value.name);
                            $("#products").append("<option value='" + value.id + "'>" + value.name + "</option>")
                    });
                    }
            });
    });
    });
            $(function () {
            $('.datetimepicker').datetimepicker({
            format: 'LT'
            });
            });
            $(function () {
            $('#datetimepicker5').datetimepicker({
            format: 'LT'
            });
            });</script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/front/js/jquery.validate.min.js"></script> 
<script>
            $(function() {
            $("form[name='offer_form']").validate({
            rules: {
            title: "required",
                    offer_type: "required",
                    category_id: "required",
                    discount_value:{
                    digits:true,
                            required:true
                    },
                    // valid_from: "required",
                    // valid_to: "required",
                    time_from: "required",
                    time_to: "required"
            },
                    messages: {
                    title: "Please Enter  Title",
                            offer_type: "Please Select  offer_type",
                            category_id: "Please Select  Category",
                            discount_value: "Please Enter  Discount value",
                            // valid_from: "Please Enter Valid From Date",
                            // valid_to: "Please Enter Valid To Date",
                            time_from: "Please Enter  Time From",
                            time_to: "Please Enter  Time To"

                    },
                    submitHandler: function(a) {
                    a.submit();
                    },
                    errorClass: "text-danger text"
            });
            });
</script>
