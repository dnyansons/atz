<?php $this->load->view("admin/common/header"); ?>
<div class="pcoded-content">
    <div class="pcoded-inner-content">

        <div class="main-body">
            <div class="page-wrapper">

                <div class="page-header">
                    <div class="row align-items-end">
                        <div class="col-lg-8">
                            <div class="page-header-title">
                                <div class="d-inline">
                                    <h4>Add Coupon</h4>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="page-header-breadcrumb">
                                <ul class="breadcrumb-title">
                                    <li class="breadcrumb-item">
                                        <a href="<?php echo site_url();?>admin/dashboard"> <i class="feather icon-home"></i> </a>
                                    </li>
                                    <li class="breadcrumb-item"><a href="<?php echo site_url();?>admin/coupon">Coupon</a></li>
                                    <li class="breadcrumb-item"><a href="#!">Add Coupon</a></li>
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
                                    <h4 class="sub-title">Coupon</h4>
                                    <form action="<?php echo site_url();?>admin/coupon/addcoupon" method="post">
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Title</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" maxlength="60" name="title" value="<?php echo set_value('title');?>">
                                                <?php echo form_error("title");?>
                                            </div>    
                                        </div>    
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Coupon Code</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" maxlength="10" name="code" value="<?php echo set_value('code');?>">
                                                <?php echo form_error("code");?>
                                            </div>    
                                        </div>
                                        
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Discount Type</label>
                                            <div class="col-sm-10">
                                                <select class="form-control" name="discount_type">
                                                    <option value="">Select Discount Type</option>
                                                    <option value="flat">Flat</option>
                                                    <option value="percentage">Percentage</option>
                                                </select>
                                                <?php echo form_error("discount_type");?>
                                            </div>
                                        </div>
                                        
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Coupon Value</label>
                                            <div class="col-sm-10">
                                                <input type="number" min="1" name="coupon_value" id="coupon_value" class="form-control" placeholder="0" required>
                                                <?php echo form_error("coupon_value");?>
                                            </div>
                                        </div>
                                        
                                        <div class="form-group row">
                                            <label class="col-sm-2" class="col-form-label">Category</label>
                                            <div class="col-sm-10">
                                                <?php echo form_dropdown('category', $cats, set_value('category'),"class='form-control' id='selcategory'");?>
                                            </div>    
                                        </div>    
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Products</label>
                                            <div class="col-sm-10">
                                                <select name="products[]" id="products" class="form-control js-example-tokenizer" multiple="multiple">
                                                    <option value="">Select</option>
                                                </select>
                                                <?php echo form_error("products[]");?>
                                            </div>    
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Minimum order quantity</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" maxlength="10" name="moq" value="<?php echo set_value('moq');?>">
                                                <?php echo form_error("moq");?>
                                            </div>    
                                        </div>
                                        
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Valid From</label>
                                            <div class="col-sm-10">

                                                <div class="input-group date">
                                                    <input type="text" name="valid_from" id="valid_from" class="form-control date" placeholder="Valid From" data-format="dd-mm-yyyy" required readonly="readonly">
                                                    <div class="input-group-addon">
                                                        <span class="fa fa-calendar"></span>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Valid To</label>
                                            <div class="col-sm-10">

                                                <div class="input-group date">
                                                    <input type="text" name="valid_to" id="valid_to" class="form-control date" placeholder="Valid To" data-format="dd-mm-yyyy" required readonly="readonly">
                                                    <div class="input-group-addon">
                                                        <span class="fa fa-calendar"></span>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                        <button type="submit" id="submit_brand" class="btn btn-primary pull-right" id="primary-popover-content">Add Coupon</button>
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
        format: "dd-mm-yyyy",
        autoclose: true,
    });
    
    $("#selcategory").change(function(){
        var cat = $(this).val();
        $.ajax({
            url : "<?php echo site_url();?>admin/Coupon/getAjaxProducts",
            type : "POST",
            data : {category_id:cat},
            //datatype:"json",
            success:function(resp){
                
                var obj = JSON.parse(resp);
                console.log(obj);
                $("#products").empty();
                $(obj.data).each(function(index,value){
                    console.log(value.name);
                    $("#products").append("<option value='"+value.id+"'>"+value.name+"</option>")
                });
            }    
        });
    });
});
</script>

