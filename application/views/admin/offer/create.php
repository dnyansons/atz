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
                                    <h4>Add New Offer</h4>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="page-header-breadcrumb">
                                <ul class="breadcrumb-title">
                                    <li class="breadcrumb-item">
                                        <a href="<?php echo site_url(); ?>admin/dashboard"> <i class="feather icon-home"></i> </a>
                                    </li>
                                    <li class="breadcrumb-item"><a href="<?php echo site_url(); ?>admin/offer">Offer</a></li>
                                    <li class="breadcrumb-item"><a href="#!">Add Offer</a></li>
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
                                            <label class="col-sm-2 col-form-label">Title<sup><span style="color:red;">&nbsp;&nbsp;*</span></sup></label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" maxlength="60" name="title" value="<?php echo set_value('title'); ?>">
                                                <?php echo form_error("title"); ?>
                                            </div>    
                                        </div>    
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Offer Image<sup><span style="color:red;">&nbsp;&nbsp;*</span></sup></label>
                                            <div class="col-sm-10">
                                                <input type="file" name="offer_image" class="form-control">
                                                <?php echo form_error("offer_image"); ?>
                                                <?php echo $this->session->flashdata('image_error'); ?>
                                            </div>    
                                        </div>    

                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Offer Type<sup><span style="color:red;">&nbsp;&nbsp;*</span></sup></label>
                                            <div class="col-sm-10">
                                                <select class="form-control" name="offer_type" id="offer_type">
                                                    <option value="0">Select Offer Type</option>
                                                    <option value="flat"<?php echo set_value('offer_type', 0) == 'flat' ? 'selected' : ''; ?>>Flat</option>
                                                    <option value="percentage" <?php echo set_value('offer_type', 0) == 'percentage' ? 'selected' : ''; ?>>Percentage</option>
                                                </select>
                                                <?php echo form_error("offer_type"); ?>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Discount Value<sup><span style="color:red;">&nbsp;&nbsp;*</span></sup></label>
                                            <div class="col-sm-10">
                                                <input type="number" min="1" name="discount_value" id="discount_value" class="form-control" placeholder="0" value="<?php echo set_value('discount_value'); ?>">
                                                <?php echo form_error("discount_value"); ?>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-sm-2" class="col-form-label">Select Category<sup><span style="color:red;">&nbsp;&nbsp;*</span></sup></label>
                                            <div class="col-sm-10">

                                               <!-- <select name="category_id" class="form-control" id="category_id" multiple="multiple">-->
                                                <select name="category_id" id="category_id" class="form-control">
                                                    <option value = "0">Select Category</option>
                                                    <?php
                                                    $i = 1;
                                                    $setValue = trim(set_value('category_id', 0));
                                                    foreach ($categories_list as $category) {
                                                        if (count($category->sub) > 0) {

                                                            $selectParent = $category->category_id == $banners->category ? 'selected' : '';
                                                            echo "<option class='optionGroup' value='' $selectParent ><b>" . $category->categories_name . "</b></option>";
                                                            foreach ($category->sub as $cat) {
                                                                $selectOption = $setValue == $cat->category_id ? 'selected' : '';
                                                                echo "<option value='" . $cat->category_id . "' $selectOption>&nbsp;&nbsp;" . $cat->categories_name . "</option>";
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
                                            <label class="col-sm-2 col-form-label">Valid From<sup><span style="color:red;">&nbsp;&nbsp;*</span></sup></label>
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
                                            <label class="col-sm-2 col-form-label">Valid To<sup><span style="color:red;">&nbsp;&nbsp;*</span></sup></label>
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
                                    <input type="button" class="float-left btn btn-primary pull-right" value="Preview Offer" id="showOfferPreview"/>
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
//            startDate: new Date()
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
    });
</script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/front/js/jquery.validate.min.js"></script> 
<script>
    $(function () {
        $("form[name='offer_form']").validate({
            rules: {
                title: "required",
                offer_type: "required",
                category_id: "required",
                discount_value: {
                    digits: true,
                    required: true
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
            submitHandler: function (a) {
                a.submit();
            },
            errorClass: "text-danger text"
        });
    });

    $(document).ready(function () {
        $('#showOfferPreview').click(function () {
            var newUrl = "<?php echo base_url('admin/offer/previewOffer'); ?>";
            var offer_type = $('#offer_type').val();
            var discount_value = $('#discount_value').val();
            var category_id = $('#category_id').val();
            if (offer_type != '' && discount_value != '' && category_id != '') {
                newUrl = newUrl + '/' + offer_type + '/' + discount_value + '/' + category_id;
                //$('#showOfferPreview').attr("href", newUrl); // Set herf value
                window.open(newUrl, '_blank');
            } else {
                alert('Please select offer type, category and discount to preview Offer');
            }
        });
    });
    
    $('#offer_type, #discount_value').change(function(){
      var discount = $('#discount_value').val();
      if(($('#offer_type').val() == 'percentage' && discount > 99) || discount == 0 ) {
          alert('Discount must be between 1 and 99 percent ');
          $('#discount_value').val("");
          $('#discount_value').css('border-color', 'red');
          return false;
      } else {
          $('#discount_value').css('border-color', '');
          return false;
      }
    });

    $('#discount_value').on('keydown', function (event) {
        var discount = $('#discount_value').val();
        if (event.keyCode == 8 || event.keyCode == 46) {
            return;
        }
        if ($('#offer_type').val() == 'percentage' && discount > 9) {
            event.preventDefault();
        }
        if (event.shiftKey == true) {
            event.preventDefault();
        }
        if ((event.keyCode >= 48 && event.keyCode <= 57) ||
                (event.keyCode >= 96 && event.keyCode <= 105) ||
                event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 37 ||
                event.keyCode == 39 || event.keyCode == 46) {
        } else {
            event.preventDefault();
        }
    });

</script>
