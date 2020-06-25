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
                                    <h4>Post new product</h4>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="page-header-breadcrumb">
                                <ul class="breadcrumb-title">
                                    <li class="breadcrumb-item">
                                        <a href="<?php echo site_url(); ?>seller/dashboard"> <i
                                                    class="feather icon-home"></i> </a>
                                    </li>
                                    <li class="breadcrumb-item"><a href="#">Products</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="page-body">
                    <div class="row">
                        <div class="col-md-12">

                            <?php
                            echo validation_errors();
                            if ($this->session->flashdata('message')) { ?>
                                <div class="alert alert-success alert-dismissible">
                                    <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
                                    <strong>Success :
                                        <?php echo $this->session->flashdata('message'); ?>
                                    </strong>
                                </div>
                            <?php } ?>

                            <div class="card social-tabs">
                                <ul class="nav nav-tabs md-tabs tab-timeline" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link" href="#basics" role="tab" aria-expanded="false">Basic</a>
                                        <div class="slide"></div>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="#trade" role="tab" aria-expanded="false">Trade</a>
                                        <div class="slide"></div>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="#logistic" role="tab"
                                           aria-expanded="false">Logistic</a>
                                        <div class="slide"></div>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="#description" role="tab" aria-expanded="false">Description</a>
                                        <div class="slide"></div>
                                    </li>
                                </ul>
                            </div>
                            <form action="<?php echo site_url(); ?>seller/products/updatepostNew/<?php echo $hidden_product_id; ?>"
                                  method="post" enctype="multipart/form-data" id="frm_post_upadte_product">
                                <div class="card">
                                    <div class="card-body">
                                        <?php //echo validation_errors(); ?>
                                        <h4 class="sub-title">Basics</h4>

                                        <div class="form-group row">
                                            <label class="contol-label col-md-2">Product Category <span
                                                        class="text-danger">*</span></label>
                                            <div class="col-md-6">
                                                <?php
                                                //$cat_id = $this->session->userdata('selected_category');
                                                $categoryNames = $this->Categories_model->getAllParentCategoriesByChildCategory($cat_id);
                                                echo '<b>' . $categoryNames->level2parent . ' >> ' . $categoryNames->level1parent . ' >> ' . $categoryNames->self_category_name . '</b>';
                                                ?>
                                                <a href="<?php echo base_url('seller/products/update/' . $hidden_product_id); ?>"
                                                   class="btn btn-sm btn-info">
                                                    Edit
                                                </a>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="contol-label col-md-2">Product Name <span class="text-danger">*</span></label>
                                            <div class="col-md-6">
                                                <input type="text" name="product_name" class="form-control"
                                                       value="<?= $ProductDetails_data['name'] ?>"
                                                       onkeypress="return restrictAlphabets(event)">
                                            </div>
                                            <span class="text-danger">
                                                <?php echo form_error('product_name'); ?>
                                            </span>
                                        </div>
                                        <div class="form-group row">
                                            <label class="contol-label col-md-2">Meta Keywords <span
                                                        class="text-danger">*</span></label>
                                            <div class="col-md-6">
                                                <input type="text" name="product_keywords" class="form-control"
                                                       maxlength="128"
                                                       placeholder="Please fill in keywords with correct format: 'modifier words + product name + application scenario', 
                                                       e.g., ‘Red 8GB mp3 for sports’."
                                                       value="<?= $ProductDetails_data['keywords'] ?>">
                                            </div>
                                            <span class="text-danger">
                                                <?php echo form_error('product_keywords'); ?>
                                            </span>
                                        </div>
                                        <?php if (count($attrs) > 0 || count($specs) > 0) {
                                            if (count($attrs) > 0) {
                                                ?>
                                                <h4 class="sub-title">Product attributes</h4>
                                                <div class="form-group row">
                                                    <label class="contol-label col-md-10 col-md-padding-1 ">
                                                        <p class="text-muted">
                                                            Please fill in accurate and complete product attributes,
                                                            so that buyers quickly understand the product features.
                                                        </p>
                                                    </label>
                                                </div>
                                            <?php }
                                        }
                                        $j = 0;
                                        foreach ($attrs as $attr): ?>
                                         
                                            <div class="form-group row">
                                                <label class="contol-label col-md-2">
                                                    <?php
                                                    echo $attr->name;
                                                    $required = "";
                                                    if ($attr->is_required) {
                                                        echo "<span class='text-danger'>*</span>";
                                                        $required = "required";
                                                    }
                                                    ?>

                                                </label>
                                                <div class="col-md-6">
                                                    <?php if ($attr->type == "single_input") { ?>
                                                        <input type="text" class="form-control temp_val"
                                                               data-did="<?php echo $attr->id; ?>" <?php echo $required; ?>
                                                               value="<?php echo $attr->attribute_value[0]; ?>">
                                                        <input type="hidden"
                                                               class="form-control orig_val_<?php echo $attr->id; ?>"
                                                               value="<?php echo $attr->attribute_value[0]; ?>" name="attr_val[]">
                                                    <?php } else if ($attr->type == "dropdown") {
                                                        $options = json_decode($attr->choices); ?>
                                                        <select class="form-control"
                                                                name="attr_val[]" <?php echo $required; ?>>
                                                            <option value="">Select option</option>
                                                            <?php foreach ($options as $option) { ?>

                                                                <?php if (in_array($option, $attr->attribute_value)) { ?>
                                                                    <option value="<?php echo $option . '_' . $attr->id; ?>"
                                                                            selected="selected"> <?php echo $option; ?> </option>
                                                                <?php } else { ?>
                                                                    <option value="<?php echo $option . '_' . $attr->id; ?>"> <?php echo $option; ?> </option>
                                                                <?php } ?>


                                                            <?php } ?>
                                                        </select>
                                                    <?php } else if ($attr->type == "multi_checkbox") {
                                                        $options = json_decode($attr->choices); ?>

                                                        <div class="border-checkbox-section">
                                                            <?php $i = 1;
                                                            foreach ($options as $option) { ?>

                                                                <?php if (in_array($option, $attr->attribute_value)) { ?>

                                                                    <div class="border-checkbox-group border-checkbox-group-primary">
                                                                        <input class="border-checkbox" type="checkbox"
                                                                               value="<?php echo $option . "_" . $attr->id; ?>"
                                                                               id="checkbox<?php echo $j . $i; ?>"
                                                                               name="attr_val[]" checked="checked">
                                                                        <label class="border-checkbox-label"
                                                                               for="checkbox<?php echo $j . $i; ?>"><?php echo $option; ?></label>
                                                                    </div>

                                                                <?php } else { ?>

                                                                    <div class="border-checkbox-group border-checkbox-group-primary">
                                                                        <input class="border-checkbox" type="checkbox"
                                                                               value="<?php echo $option . "_" . $attr->id; ?>"
                                                                               id="checkbox<?php echo $j . $i; ?>"
                                                                               name="attr_val[]">
                                                                        <label class="border-checkbox-label"
                                                                               for="checkbox<?php echo $j . $i; ?>"><?php echo $option; ?></label>
                                                                    </div>

                                                                <?php } ?>


                                                                <?php $i++;
                                                            } ?>
                                                        </div>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                            <?php $j++; endforeach; ?>

                                        <?php if (count($specs) > 0) { ?>
                                            <h4 class="sub-title">Product Specification</h4>
                                            <div class="form-group row">
                                                <label class="contol-label col-md-10 col-md-padding-1 ">
                                                    <p class="text-muted">
                                                        Please fill in accurate and complete product specifications,
                                                        These are option selectable when user choose your product.
                                                    </p>
                                                </label>
                                            </div>
                                        <?php }
                                        foreach ($specs as $spec): ?>
                                            <!--                                        <input type="hidden" name="spec_id[]" value="<?php echo $spec->id; ?>">-->
                                            <div class="form-group row">
                                                <label class="contol-label col-md-2">
                                                    <?php
                                                    echo $spec->name;
                                                    $required = "";
                                                    $class = "";
                                                    if ($spec->is_required) {
                                                        echo "<span class='text-danger'>*</span>";
                                                    }

                                                    if ($spec->name == "color") {
                                                        $class = "clone_spec_color";
                                                    }
                                                    ?>

                                                </label>
                                                <div class="col-md-6 <?php echo $class; ?>">
                                                    <?php if ($spec->type == "single_input") { ?>
                                                        <input type="text" class="form-control"
                                                               name="spec_val[]" <?php echo $required; ?>
                                                               value="<?php echo $spec->spec_value; ?>">
                                                        <input type="hidden" class="form-control"
                                                               value="<?php echo $spec->id; ?>"
                                                               name="spec_val_hidden[]" <?php echo $required; ?>>
                                                    <?php } else if ($spec->type == "dropdown") {
                                                        $options = json_decode($spec->choices);
                                                        $data_id = "";
                                                        ?>
                                                        <div class="form-group row cloneme"
                                                             id="clone<?php echo $spec->name; ?>">
                                                            <?php
                                                            $showOptionsCount = count($spec->spec_value) > 0 ? count($spec->spec_value) : 1;
                                                            for ($i = 0; $i < $showOptionsCount; $i++) {
                                                                $divNum = mt_rand(1000, 9999);
                                                                ?>
                                                                <div class="col-md-10 mt-1" id="<?php echo $divNum; ?>">
                                                                    <?php $data_id = '<select class="form-control" name="spec_val[]" ' . $required .
                                                                        ' ><option value="0">Select option</option>'; ?>
                                                                    <select class="form-control "
                                                                            name="spec_val[]" <?php echo $required; ?> >
                                                                        <option value="">Select option</option>
                                                                        <?php foreach ($options as $option) {
                                                                            $data_id .= '<option value="' . $option . '_' . $spec->id . '"> ' . $option . ' </option>';
                                                                            ?>
                                                                            <?php if ($option == $spec->spec_value[$i]) { ?>

                                                                                <option value="<?php echo $option . '_' . $spec->id; ?>"
                                                                                        selected="selected"> <?php echo $option; ?> </option>

                                                                            <?php } else { ?>

                                                                                <option value="<?php echo $option . '_' . $spec->id; ?>"> <?php echo $option; ?> </option>

                                                                            <?php } ?>
                                                                        <?php }
                                                                        $data_id .= '</select>';
                                                                        ?>
                                                                    </select>
                                                                </div>

                                                                <?php if ($i == 0) { ?>

                                                                    <span style="display:none;"
                                                                          id="dataclone<?php echo $spec->name; ?>">
                                                                <?php echo $data_id; ?>
                                                            </span>

                                                                    <button type="button"
                                                                            class="btn btn-sm btn_clone_spec_color"
                                                                            onclick="addSpecs('clone<?php echo $spec->name; ?>')">
                                                                        <i class="fa fa-plus"></i>
                                                                    </button>

                                                                <?php } else { ?>

                                                                    <button type="button" id="btn<?php echo $divNum; ?>"
                                                                            class="btn btn-sm btn_clone_spec_color mt-1"
                                                                            onclick=removeSpecs('<?php echo $divNum; ?>')>
                                                                        <i class="fa fa-remove"></i>
                                                                    </button>
                                                                <?php } ?>

                                                            <?php } ?>
                                                        </div>


                                                    <?php } else if ($spec->type == "multi_checkbox") {
                                                        $options = json_decode($spec->choices); ?>

                                                        <div class="border-checkbox-section">
                                                            <?php $i = 1;
                                                            foreach ($options as $option) {
                                                                $chkid = "checkbox_s" . $i . rand(0, 100);
                                                                ?>


                                                                <?php if (in_array($option, $spec->spec_value)) { ?>


                                                                    <div class="border-checkbox-group border-checkbox-group-primary">
                                                                        <input class="border-checkbox" type="checkbox"
                                                                               value="<?php echo $option . "_" . $spec->id; ?>"
                                                                               id="<?php echo $chkid; ?>"
                                                                               name="spec_val[]" checked="checked">
                                                                        <label class="border-checkbox-label"
                                                                               for="<?php echo $chkid; ?>"><?php echo $option; ?></label>
                                                                    </div>

                                                                <?php } else { ?>

                                                                    <div class="border-checkbox-group border-checkbox-group-primary">
                                                                        <input class="border-checkbox" type="checkbox"
                                                                               value="<?php echo $option . "_" . $spec->id; ?>"
                                                                               id="<?php echo $chkid; ?>"
                                                                               name="spec_val[]">
                                                                        <label class="border-checkbox-label"
                                                                               for="<?php echo $chkid; ?>"><?php echo $option; ?></label>
                                                                    </div>

                                                                <?php } ?>


                                                                <?php $i++;
                                                            } ?>
                                                        </div>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>


                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="sub-title">Trade information</h4>
                                        <div class="form-group row">
                                            <label class="contol-label col-md-2">Help buyers place orders
                                                directly</label>
                                            <div class="col-md-6">
                                                <label>
                                                    <input type="radio" value="1"
                                                           name="buyers_place" <?php echo $ProductDetails_data['provide_order_at_buyer_place'] == "1" ? "checked=checked" : ""; ?>>
                                                    Yes
                                                    <input type="radio" value="0"
                                                           name="buyers_place" <?php echo $ProductDetails_data['provide_order_at_buyer_place'] == "0" ? "checked=checked" : ""; ?>>
                                                    No
                                                </label>
                                                <p class="text-muted">Placing trade assurance orders can quickly speed
                                                    up the order conversion of a product and increase exposure
                                                    opportunities.</p>
                                            </div>
                                        </div>

<!--                                        <div class="form-group row">-->
<!--                                            <label class="control-label col-md-2">Available Quantity <span-->
<!--                                                        class="text-danger">*</span></label>-->
<!--                                            <div class="col-md-6">-->
<!--                                                <input type="text"-->
<!--                                                       value="--><?php //echo $ProductDetails_data['available_quantity'] ?><!--"-->
<!--                                                       class="form-control" name="available_quantity"-->
<!--                                                       placeholder="Enter available quantity" id="available_quantity">-->
<!--                                                <div class="error text-danger">--><?php //echo form_error('available_quantity'); ?><!--</div>-->
<!--                                            </div>-->
<!--                                        </div>-->

                                        <div class="form-group row">
                                            <label class="contol-label col-md-2">Is product returnable</label>
                                            <div class="col-md-6">
                                                <label>
                                                    <input type="radio" value="Yes"
                                                           name="is_product_returnable" <?= $ProductDetails_data['is_product_returnable'] == "Yes" ? "checked=checked" : "" ?>>
                                                    Yes
                                                    <input type="radio" value="No"
                                                           name="is_product_returnable" <?= $ProductDetails_data['is_product_returnable'] == "No" ? "checked=checked" : "" ?>>
                                                    No
                                                </label>
                                            </div>
                                        </div>


                                        <div style="<?= $ProductDetails_data['is_product_returnable'] == 'Yes' ? 'display: block;' : 'display: none;'; ?>"
                                             id="returnable_div">

                                            <div class="form-group row">
                                                <label class="contol-label col-md-2">Select no.of days for product
                                                    return</label>
                                                <div class="col-md-6">

                                                    <select class="form-control" name="product_return_days">
                                                        <?php

                                                        for ($i = 0; $i <= 30; $i++) {
                                                            if ($ProductDetails_data['product_return_days'] == $i) {
                                                                echo "<option value='$i' selected='selected'>$i</option>";
                                                            } else {
                                                                echo "<option value='$i'>$i</option>";
                                                            }

                                                        }

                                                        ?>

                                                    </select>
                                                </div>
                                            </div>


                                            <div class="form-group row">
                                                <label class="contol-label col-md-2">Return policy
                                                </label>
                                                <div class="col-md-10">

                                                    <table id="policy"
                                                           class="table table-striped table-bordered table-hover">
                                                        <thead>
                                                        <tr>
                                                            <td class="text-left">Return Policy</td>
                                                            <td></td>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        <?php if (isset($ProductPolicies_data)) {
                                                            $policy_count = 0;
                                                            foreach ($ProductPolicies_data as $pol) { ?>


                                                                <tr id="policy-row<?php echo $policy_count; ?>">

                                                                    <td class="text-left">
                                                                        <textarea name="policy[]"
                                                                                  id="product_policy<?php echo $policy_count; ?>"
                                                                                  class="form-control policy"><?php echo $pol->policy; ?></textarea>
                                                                    </td>

                                                                    <td class="text-right">
                                                                        <button type="button"
                                                                                onclick="$('#policy-row<?php echo $policy_count; ?>').remove();"
                                                                                data-toggle="tooltip" title=""
                                                                                class="btn btn-danger"
                                                                                data-original-title="Remove"><i
                                                                                    class="fa fa-minus-circle"></i>
                                                                        </button>
                                                                    </td>
                                                                </tr>
                                                                <?php $policy_count++;
                                                            }
                                                        } ?>
                                                        </tbody>
                                                        <tfoot>
                                                        <tr>
                                                            <td colspan="1"></td>
                                                            <td class="text-right">
                                                                <button type="button" onclick="addReturnPolicy();"
                                                                        data-toggle="tooltip" title=""
                                                                        class="btn btn-primary"
                                                                        data-original-title="Add Policy"><i
                                                                            class="fa fa-plus-circle"></i></button>
                                                            </td>
                                                        </tr>
                                                        </tfoot>
                                                    </table>
                                                </div>
                                            </div>

                                        </div>


                                        <div class="form-group row">
                                            <label class="contol-label col-md-2" data-toggle="tooltip" data-placement="top" title="Select Price Type for Setting Price for single product or 'Range of Multiple Products">Price Type <span
                                                        class="text-danger">*</span></label>
                                            <div class="col-md-6">
                                                <label>
                                                    <input type="radio" class="price_type" value="single"
                                                           name="price_type" <?php echo $ProductDetails_data['price_type'] == "single" ? "checked=checked" : ""; ?> data-toggle="tooltip" data-placement="top" title="Set Price Per Unit Quantity">
                                                    Single
                                                    <input type="radio" class="price_type" value="uniform"
                                                           name="price_type" <?php echo $ProductDetails_data['price_type'] == "uniform" ? "checked=checked" : ""; ?> data-toggle="tooltip" data-placement="top" title="Set Multiple Price on Product's Minimum Order Quantity Ranges">
                                                    Uniform
                                                </label>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="control-label col-md-2">Unit</label>
                                            <div class="col-md-6">
                                                <select class="form-control" name="unit">
                                                    <?php foreach ($units as $unit):
                                                        $selected = set_value('unit', $ProductDetails_data['product_prices'][0]->units_id);
                                                        ?>

                                                        <?php if ($selected == $unit->units_id) { ?>

                                                            <option value="<?php echo $unit->units_id; ?>"
                                                                    selected="selected"><?php echo $unit->units_name; ?></option>

                                                        <?php } else { ?>

                                                            <option value="<?php echo $unit->units_id; ?>"><?php echo $unit->units_name; ?></option>

                                                        <?php } ?>

                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>


                                        <?php

                                        if ($ProductDetails_data['price_type'] == "single") {
                                            $disable_single = "";
                                            $disable_uniform = "disabled";
                                        } else if ($ProductDetails_data['price_type'] == "uniform") {
                                            $disable_single = "disabled";
                                            $disable_uniform = "";
                                        }

                                        ?>


                                        <div id="single_container"
                                             style="<?php echo $ProductDetails_data['price_type'] == "single" ? "display:block;" : "display:none;"; ?>">
                                            <div class="form-group row">
                                                <label class="control-label col-md-2">MOQ <span
                                                            class="text-danger">*</span></label></label>
                                                <div class="col-md-3">
                                                    <input type="text" class="form-control" name="moq[]" id="moq_11"
                                                           placeholder="Minimum order quantity"
                                                           value="<?php echo set_value('moq[0]',$ProductDetails_data['product_prices'][0]->quantity_from); ?>" <?= $disable_single; ?>>
                                                </div>
                                                <div class="col-md-3">
                                                    <input type="text" class="form-control" name="price[]" id="price_11"
                                                           placeholder="price per unit"
                                                           value="<?php echo $ProductDetails_data['product_prices'][0]->price; ?>" <?= $disable_single; ?>>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="uniform_container"
                                             style="<?php echo $ProductDetails_data['price_type'] == "uniform" ? "display:block;" : "display:none;"; ?>">
                                            <div class="form-group row">
                                                <label class="control-label col-md-2">MOQ </label>
                                                <div class="col-md-3">
                                                    <div class="input-group">
                                                        <span class="input-group-addon" id="basic-addon1">>=</span>
                                                        <input type="text" class="form-control" name="moq[]" id="moq_1"
                                                               placeholder="Minimum order quantity"
                                                               value="<?php echo $ProductDetails_data['product_prices'][0]->quantity_from; ?>" <?= $disable_uniform; ?>>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <input type="text" class="form-control" name="price[]" id="price_1"
                                                           placeholder="price per unit"
                                                           value="<?php echo $ProductDetails_data['product_prices'][0]->price; ?>" <?= $disable_uniform; ?>>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="control-label col-md-2">MOQ </label>
                                                <div class="col-md-3">
                                                    <div class="input-group">
                                                        <span class="input-group-addon" id="basic-addon1">>=</span>
                                                        <input type="text" class="form-control" name="moq[]" id="moq_2"
                                                               placeholder="Minimum order quantity"
                                                               value="<?php echo $ProductDetails_data['product_prices'][1]->quantity_from; ?>" <?= $disable_uniform; ?>>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <input type="text" class="form-control" name="price[]" id="price_2"
                                                           placeholder="price per unit"
                                                           value="<?php echo $ProductDetails_data['product_prices'][1]->price; ?>" <?= $disable_uniform; ?>>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="control-label col-md-2">MOQ </label>
                                                <div class="col-md-3">
                                                    <div class="input-group">
                                                        <span class="input-group-addon" id="basic-addon1">>=</span>
                                                        <input type="text" class="form-control" name="moq[]" id="moq_3"
                                                               placeholder="Minimum order quantity"
                                                               value="<?php echo $ProductDetails_data['product_prices'][2]->quantity_from; ?>" <?= $disable_uniform; ?>>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <input type="text" class="form-control" name="price[]" id="price_3"
                                                           placeholder="price per unit"
                                                           value="<?php echo $ProductDetails_data['product_prices'][2]->price; ?>" <?= $disable_uniform; ?>>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="control-label col-md-2">MOQ </label>
                                                <div class="col-md-3">
                                                    <div class="input-group">
                                                        <span class="input-group-addon" id="basic-addon1">>=</span>
                                                        <input type="text" class="form-control" name="moq[]" id="moq_4"
                                                               placeholder="Minimum order quantity"
                                                               value="<?php echo $ProductDetails_data['product_prices'][3]->quantity_from; ?>" <?= $disable_uniform; ?>>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <input type="text" class="form-control" name="price[]" id="price_4"
                                                           placeholder="price per unit"
                                                           value="<?php echo $ProductDetails_data['product_prices'][3]->price; ?>" <?= $disable_uniform; ?>>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!----------------------Start Of Inventory Section--------------------->
                                <div class="card" id="trade">
                                    <div class="card-body">
                                        <h4 class="sub-title" >Inventory</h4>
                                        <div class="form-group row">
                                            <label class="contol-label col-md-2">Manage Inventory</label>
                                            <div class="col-md-6">
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input ml-1" type="radio" value="0" name="track_inventory" id="dont_track_inventory" <?php echo set_value('track_inventory', $ProductDetails_data['track_inventory']) == 0 ? 'checked' : ''; ?> >
                                                    <label class="form-check-label ml-1" for="dont_track_inventory">Don't Track My Inventory</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input ml-1" type="radio" value="1" name="track_inventory" id="track_inventory" <?php echo set_value('track_inventory', $ProductDetails_data['track_inventory']) == 1 ? 'checked' : ''; ?>>
                                                    <label class="form-check-label ml-1" for="track_inventory">Track My Inventory</label>
                                                </div>
                                            </div>
                                            <span class="text-danger">
                                                <?php echo form_error('track_inventory'); ?>
                                            </span>
                                        </div>

                                        <div class="form-group row">
                                            <label class="control-label col-md-2">Available Quantity / Inventory Quantity  <span class="text-danger">*</span></label>
                                            <div class="col-md-6">
                                                <input type="text" class="form-control" name="available_quantity" value="<?php echo set_value('available_quantity', $ProductDetails_data['available_quantity'])?>" placeholder="Enter available quantity" id="available_quantity" maxlength="20">
                                                <span class="text-danger" id="available_qty_span">
                                                    <?php echo form_error('available_quantity'); ?>
                                                </span>
                                            </div>
                                        </div>

                                        <!--                                        <div class="form-group row">-->
                                        <!--                                            <label class="control-label col-md-2">Inventory Quantity <span class="text-danger">*</span></label>-->
                                        <!--                                            <div class="col-md-6">-->
                                        <!--                                                <input type="text" class="form-control" name="inventory_quantity" value="--><?php //echo set_value('inventory_quantity')?><!--" placeholder="Enter Available Quantity." id="inventory_quantity"  pattern= "[0-9]">-->
                                        <!--                                            </div>-->
                                        <!--                                            <span class="text-danger">-->
                                        <!--                                                --><?php //echo form_error('inventory_quantity'); ?>
                                        <!--                                            </span>-->
                                        <!--                                        </div>-->
                                        <div class="form-group row">
                                            <label class="control-label col-md-2">Low Stock Quantity <span class="text-danger">*</span></label>
                                            <div class="col-md-6">
                                                <input type="text" class="form-control" name="low_stock_quantity" value="<?php echo set_value('low_stock_qty', $ProductDetails_data['low_stock_qty'])?>" placeholder="Enter Minimum Quantity to Notify" id="low_stock_quantity"  >
                                            </div>
                                            <span class="text-danger">
                                                <?php echo form_error('low_stock_quantity'); ?>
                                            </span>
                                        </div>

                                        <div class="form-group row">
                                            <label class="contol-label col-md-2"></label>
                                            <div class="col-md-6">
                                                <label>
                                                    <input type="checkbox" id="chk_notify" value="1" name="chk_notify" <?php echo $ProductDetails_data['notifyme'] == 1 ? 'checked': ''; ?> > Notify me when reach at Minimum Quantity
                                                </label>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="control-label col-md-2">Current Available Quantity <span class="text-danger">*</span></label>
                                            <div class="col-md-6">
                                                <input type="text" class="form-control" name="remain_quantity" value="<?php echo $ProductDetails_data['available_quantity']?>" placeholder="Current available quantity" id="remain_quantity" readonly>
                                            </div>
                                            <span class="text-danger">
                                                <?php echo form_error('remain_quantity'); ?>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <!----------------------End Of Inventory Section--------------------->
                                <div class="card">
                                    <div class="card-body" id="description">
                                        <h4 class="sub-title">Product Description</h4>
                                        <!-- <div class="form-group row">
                                            <label class="control-label col-md-2">Image</label>
                                            <div class="col-md-6">
                                                <input type="file" name="product_images[]" id="product_images_p" multiple="multiple">

                                                
                                            </div>
                                        </div> -->


                                        <div class="form-group row">
                                            <label class="contol-label col-md-2">Weight (in Kg) <span
                                                        class="text-danger">*</span></label>
                                            </label>
                                            <div class="col-md-6">
                                                <input type="text" name="weight" id="weight" class="form-control"
                                                       value="<?php echo $ProductDetails_data['weight']; ?>">
                                                <span class="text-danger">
                                                    <?php echo form_error('weight'); ?>
                                                </span>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="contol-label col-md-2">Width (in CM) <span
                                                        class="text-danger">*</span></label>
                                            </label>
                                            <div class="col-md-6">
                                                <input type="text" name="width" id="width" class="form-control"
                                                       value="<?php echo $ProductDetails_data['width']; ?>">
                                                <span class="text-danger">
                                                    <?php echo form_error('width'); ?>
                                                </span>
                                            </div>
                                        </div>


                                        <div class="form-group row">
                                            <label class="contol-label col-md-2">Height (in CM) <span
                                                        class="text-danger">*</span></label>
                                            </label>
                                            <div class="col-md-6">
                                                <input type="text" id="height" name="height" class="form-control"
                                                       value="<?php echo $ProductDetails_data['height']; ?>">
                                                <span class="text-danger">
                                                    <?php echo form_error('height'); ?>
                                                </span>
                                            </div>
                                        </div>


                                        <div class="form-group row">
                                            <label class="contol-label col-md-2">Length (in CM) <span
                                                        class="text-danger">*</span></label>
                                            </label>
                                            <div class="col-md-6">
                                                <input type="text" id="length" name="length" class="form-control"
                                                       value="<?php echo $ProductDetails_data['length']; ?>">
                                                <span class="text-danger">
                                                    <?php echo form_error('length'); ?>
                                                </span>
                                            </div>

                                        </div>


                                        <div class="form-group row">

                                            <label class="contol-label col-md-2">Images <span
                                                        class="text-danger">*</span></label>
                                            </label>
                                            <div class="col-md-10">


                                                <table id="images"
                                                       class="table table-striped table-bordered table-hover">
                                                    <thead>
                                                    <tr>
                                                        <td class="text-left">Images</td>
                                                        <td class="text-left">Choose Image</td>
                                                        <td></td>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <?php if (isset($ProductDetails_data['images'])) {
                                                        $img_count = 0;
                                                        foreach ($ProductDetails_data['images'] as $imgd) { ?>

                                                            <?php //$img_array=explode('.', $imgd);

                                                            //$thumbnail=$img_array[0].'_thumb.'.$img_array[1];

                                                            ?>

                                                            <tr id="image-row<?php echo $img_count; ?>">
                                                                <td class="text-left">
                                                                    <img src="<?php echo $imgd; ?>"
                                                                         id="product_image_show<?php echo $img_count; ?>"
                                                                         alt="No Image" title="" width="60" height="60">
                                                                </td>
                                                                <td class="text-left">
                                                                    <input type="file" name="product_image_file[]"
                                                                           id="imgfile<?php echo $img_count; ?>"
                                                                           onchange="readImageURL(this, <?php echo $img_count; ?>);"
                                                                           onclick="resetImage(this, <?php echo $img_count; ?>)"
                                                                           value="<?php echo $imgd; ?>" class="file">
                                                                    <input type="hidden"
                                                                           name="product_hidden_image_file[]"
                                                                           id="hidden_img<?php echo $img_count; ?>"
                                                                           value="<?php echo $imgd; ?>">
                                                                    <span id="uploadmsg<?php echo $img_count; ?>"></span>

                                                                </td>

                                                                <td class="text-right">
                                                                    <button type="button"
                                                                            onclick="$('#image-row<?php echo $img_count; ?>').remove();"
                                                                            data-toggle="tooltip" title=""
                                                                            class="btn btn-danger"
                                                                            data-original-title="Remove"><i
                                                                                class="fa fa-minus-circle"></i></button>
                                                                </td>
                                                            </tr>
                                                            <?php $img_count++;
                                                        }
                                                    } ?>
                                                    </tbody>
                                                    <tfoot>
                                                    <tr>
                                                        <td colspan="2"></td>
                                                        <td class="text-right">
                                                            <button type="button" onclick="addImage();"
                                                                    data-toggle="tooltip" title=""
                                                                    class="btn btn-primary"
                                                                    data-original-title="Add Image"><i
                                                                        class="fa fa-plus-circle"></i></button>
                                                        </td>
                                                    </tr>
                                                    </tfoot>
                                                </table>
                                                <span class="text-danger row mx-auto">
                                                    <?php echo form_error('product_hidden_image_file'); ?>
                                                </span>
                                            </div>


                                        </div>


                                        <div class="form-group row">

                                            <label class="contol-label col-md-2">Video
                                            </label>
                                            <div class="col-md-10">


                                                <table id="video"
                                                       class="table table-striped table-bordered table-hover">
                                                    <thead>
                                                    <tr>
                                                        <td class="text-left">Video</td>
                                                        <td class="text-left">Youtube Video URL</td>
                                                    </tr>
                                                    </thead>
                                                    <tbody>

                                                    <tr>

                                                        <td>
                                                            <iframe width="200" height="100" src="" id="youtube_video"
                                                                    frameborder="0" allowFullScreen='allowFullScreen'>
                                                            </iframe>
                                                        </td>


                                                        <td>
                                                            <input type="text" class="form-control" name="video_url"
                                                                   id="video_url"
                                                                   value="<?= $ProductDetails_data['video']; ?>"
                                                                   onkeyup="getVideo(this.value);">
                                                            <input type="hidden" class="form-control"
                                                                   name="hidden_video_url">
                                                        </td>

                                                    </tr>

                                                    </tbody>
                                                </table>


                                            </div>

                                        </div>


                                        <div class="form-group row">
                                            <label class="control-label col-md-2">Description</label>
                                            <div class="col-md-10">
                                                <textarea class="ckeditor" name="products_description"
                                                          rows="4"><?= $ProductDetails_data['description'] ?></textarea>
                                            </div>

                                        </div>
                                        <button type="button" class="btn btn-info f-right" id="submit_form" >Submit</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
<?php $this->load->view("user/common/footer"); ?>
<script>

    function multiplyByParent(input) {
        var uniqueId = $(input).parent().parent().children(':first-child');
        var cloneFirstOnly = $(input).parent().parent();
        console.log(uniqueId.clone(true).appendTo(cloneFirstOnly));
    }

    $(document).ready(function () {
        $(document).on('click', '#submit_form', function () {
            var id = $('.temp_val').data('did');
            var value = $('.temp_val').val();
            $('.orig_val_' + id).val(value + '_' + id);
			
			$('#frm_post_upadte_product').submit();
        });

        $(".btn_clone_spec_color").click(function () {
            var vv = this;
            //debugger;
            //$( ".cloneme" ).parent().parent().children(':first-child').clone(true).appendTo(".clone_spec_color"); 
            // $(".cloneme:last").clone(true).appendTo(".clone_spec_color");
        });

        //window.multiplyByParent=function(){
        //  console.log('input');
        //}

        /*$(".btn_clone_spec_color").click(function () {
                    //$(this).clone(true).appendTo(".clone_spec_color");
                    $(this).parent().parent().clone(true).appendTo($(this).parent().parent());
                });*/

        $(".price_type").on("click", function () {
            var val = $(this).val();
            if (val == "single") {
                $("#single_container").show();
                $("#uniform_container").hide();

                $("#price_1").prop("disabled", true);
                $("#hike_price_1").prop("disabled", true);
                $("#price_2").prop("disabled", true);
                $("#hike_price_2").prop("disabled", true);
                $("#price_3").prop("disabled", true);
                $("#hike_price_3").prop("disabled", true);
                $("#price_4").prop("disabled", true);
                $("#hike_price_4").prop("disabled", true);
                $("#moq_1").prop("disabled", true);
                $("#moq_2").prop("disabled", true);
                $("#moq_3").prop("disabled", true);
                $("#moq_4").prop("disabled", true);

                $("#price_11").prop("disabled", false);
                $("#hike_price_11").prop("disabled", false);
                $("#moq_11").prop("disabled", false);

            } else {
                $("#single_container").hide();
                $("#uniform_container").show();

                $("#price_11").prop("disabled", true);
                $("#hike_price_11").prop("disabled", true);
                $("#moq_11").prop("disabled", true);

                $("#price_1").prop("disabled", false);
                $("#hike_price_1").prop("disabled", false);
                $("#price_2").prop("disabled", false);
                $("#hike_price_2").prop("disabled", false);
                $("#price_3").prop("disabled", false);
                $("#hike_price_3").prop("disabled", false);
                $("#price_4").prop("disabled", false);
                $("#hike_price_4").prop("disabled", false);
                $("#moq_1").prop("disabled", false);
                $("#moq_2").prop("disabled", false);
                $("#moq_3").prop("disabled", false);
                $("#moq_4").prop("disabled", false);
            }
        });
    });

    $(document).ready(function () {
        'use-strict';
        $('#filer_input_single').filer({
            extensions: ['jpg', 'jpeg', 'png', 'gif', 'psd'],
            changeInput: true,
            showThumbs: true,
            addMore: false
        });
        $('#product_images_p').filer({
            limit: 6,
            maxSize: 3,
            extensions: ['jpg', 'jpeg', 'png', 'gif', 'psd'],
            changeInput: true,
            showThumbs: true,
            addMore: true
        });
        $("#filer_input1").filer({
            limit: null,
            maxSize: null,
            extensions: null,
            changeInput: '<div class="jFiler-input-dragDrop"><div class="jFiler-input-inner"><div class="jFiler-input-icon"><i class="icon-jfi-cloud-up-o"></i></div><div class="jFiler-input-text"><h3>Drag & Drop files here</h3> <span style="display:inline-block; margin: 15px 0">or</span></div><a class="jFiler-input-choose-btn btn btn-primary waves-effect waves-light">Browse Files</a></div></div>',
            showThumbs: true,
            theme: "dragdropbox",
            templates: {
                box: '<ul class="jFiler-items-list jFiler-items-grid"></ul>',
                item: '<li class="jFiler-item">\
                        <div class="jFiler-item-container">\
                            <div class="jFiler-item-inner">\
                                <div class="jFiler-item-thumb">\
                                    <div class="jFiler-item-status"></div>\
                                    <div class="jFiler-item-info">\
                                        <span class="jFiler-item-title"><b title="{{fi-name}}">{{fi-name | limitTo: 25}}</b></span>\
                                        <span class="jFiler-item-others">{{fi-size2}}</span>\
                                    </div>\
                                    {{fi-image}}\
                                </div>\
                                <div class="jFiler-item-assets jFiler-row">\
                                    <ul class="list-inline pull-left">\
                                        <li>{{fi-progressBar}}</li>\
                                    </ul>\
                                    <ul class="list-inline pull-right">\
                                        <li><a class="icon-jfi-trash jFiler-item-trash-action"></a></li>\
                                    </ul>\
                                </div>\
                            </div>\
                        </div>\
                    </li>',
                itemAppend: '<li class="jFiler-item">\
                            <div class="jFiler-item-container">\
                                <div class="jFiler-item-inner">\
                                    <div class="jFiler-item-thumb">\
                                        <div class="jFiler-item-status"></div>\
                                        <div class="jFiler-item-info">\
                                            <span class="jFiler-item-title"><b title="{{fi-name}}">{{fi-name | limitTo: 25}}</b></span>\
                                            <span class="jFiler-item-others">{{fi-size2}}</span>\
                                        </div>\
                                        {{fi-image}}\
                                    </div>\
                                    <div class="jFiler-item-assets jFiler-row">\
                                        <ul class="list-inline pull-left">\
                                            <li><span class="jFiler-item-others">{{fi-icon}}</span></li>\
                                        </ul>\
                                        <ul class="list-inline pull-right">\
                                            <li><a class="icon-jfi-trash jFiler-item-trash-action"></a></li>\
                                        </ul>\
                                    </div>\
                                </div>\
                            </div>\
                        </li>',
                progressBar: '<div class="bar"></div>',
                itemAppendToEnd: false,
                removeConfirmation: true,
                _selectors: {
                    list: '.jFiler-items-list',
                    item: '.jFiler-item',
                    progressBar: '.bar',
                    remove: '.jFiler-item-trash-action'
                }
            },
            dragDrop: {dragEnter: null, dragLeave: null, drop: null,},
            uploadFile: {
                url: "../plugins/jquery.filer/php/upload.php",
                data: null,
                type: 'POST',
                enctype: 'multipart/form-data',
                beforeSend: function () {
                },
                success: function (data, el) {
                    var parent = el.find(".jFiler-jProgressBar").parent();
                    el.find(".jFiler-jProgressBar").fadeOut("slow", function () {
                        $("<div class=\"jFiler-item-others text-success\"><i class=\"icon-jfi-check-circle\"></i> Success</div>").hide().appendTo(parent).fadeIn("slow");
                    });
                },
                error: function (el) {
                    var parent = el.find(".jFiler-jProgressBar").parent();
                    el.find(".jFiler-jProgressBar").fadeOut("slow", function () {
                        $("<div class=\"jFiler-item-others text-error\"><i class=\"icon-jfi-minus-circle\"></i> Error</div>").hide().appendTo(parent).fadeIn("slow");
                    });
                },
                statusCode: null,
                onProgress: null,
                onComplete: null
            },
            files: [{
                name: "Desert.jpg",
                size: 145,
                type: "image/jpg",
                file: "../files/assets/images/file-upload/Desert.jpg"
            }, {
                name: "overflow.jpg",
                size: 145,
                type: "image/jpg",
                file: "../files/assets/images/file-upload/Desert.jpg"
            }],
            addMore: false,
            clipBoardPaste: true,
            excludeName: null,
            beforeRender: null,
            afterRender: null,
            beforeShow: null,
            beforeSelect: null,
            onSelect: null,
            afterShow: null,
            onRemove: function (itemEl, file, id, listEl, boxEl, newInputEl, inputEl) {
                var file = file.name;
                $.post('../plugins/jquery.filer/php/remove_file.php', {file: file});
            },
            onEmpty: null,
            options: null,
            captions: {
                button: "Choose Files",
                feedback: "Choose files To Upload",
                feedback2: "files were chosen",
                drop: "Drop file here to Upload",
                removeConfirmation: "Are you sure you want to remove this file?",
                errors: {
                    filesLimit: "Only {{fi-limit}} files are allowed to be uploaded.",
                    filesType: "Only Images are allowed to be uploaded.",
                    filesSize: "{{fi-name}} is too large! Please upload file up to {{fi-maxSize}} MB.",
                    filesSizeAll: "Files you've choosed are too large! Please upload files up to {{fi-maxSize}} MB."
                }
            }
        });
    });
</script>


<script type="text/javascript">


    var image_row = parseInt(<?php echo count($ProductDetails_data['images']) ?>);

    function addImage() {
        html = '<tr id="image-row' + image_row + '">';
        html += '  <td class="text-left"><img src="#" id="product_image_show' + image_row + '" alt="No Image" title="" /></td>';
        html += '  <td class="text-left"><input type="file" name="product_image_file[]" onchange="readImageURL(this, ' + image_row + ');" onclick="resetImage(this, ' + image_row + ')" class="file"><input type="hidden" name="product_hidden_image_file[]" id="hidden_img' + image_row + '" value=""><span id="uploadmsg' + image_row + '"></span></td>';
        html += '  <td class="text-right"><button type="button" onclick="$(\'#image-row' + image_row + '\').remove();" data-toggle="tooltip" title="Remove" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>';
        html += '</tr>';

        $('#images tbody').append(html);

        image_row++;
    }

</script>


<script type="text/javascript">

    function readImageURL(input, id) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#product_image_show' + id)
                    .attr('src', e.target.result)
                    .width(60)
                    .height(60);


            };

            reader.readAsDataURL(input.files[0]);

            //var imgfilename = $("#imgfile"+id).val().split('\\').pop();;

            //$("#hidden_img"+id).val('');

            var base_url = "<?php echo base_url(); ?>";

            var fd = new FormData();
            var files = $('.file')[id].files[0];
            fd.append('myfile', files);

            $.ajax({
                url: '<?php echo base_url();?>seller/products/ajax_upload_image',
                type: "post",
                data: fd, //this is formData
                dataType: "json",
                async: true,
                contentType: false,
                processData: false,
                success: function (data) {

                    if (data.status == "success") {
                        //alert(data.file_name);
                        $("#hidden_img" + id).val(data.file_name);
                        $("#uploadmsg" + id).html('<span style="color:green;">File uploaded successfully.</span>');
                    } else {
                        //alert(data.error);
                        $("#uploadmsg" + id).html('<span style="color:red;">' + data.error + '</span>');
                    }
                }


            });

        }


    }

</script>


<script>
    $(document).ready(function () {
        var url = $("#video_url").val();
        var new_url = url.split("v=").pop();
        new_url = "https://www.youtube.com/embed/" + new_url + "?controls=1&loop=0";
        document.getElementById('youtube_video').src = "";
        document.getElementById('youtube_video').src = new_url;
        $("#hidden_video_url").val('');
        $("#hidden_video_url").val(new_url);

    });
</script>


<script>
    function getVideo(url) {
        var new_url = url.split("v=").pop();
        new_url = "https://www.youtube.com/embed/" + new_url + "?controls=1&loop=0";
        document.getElementById('youtube_video').src = "";
        document.getElementById('youtube_video').src = new_url;
        $("#hidden_video_url").val('');
        $("#hidden_video_url").val(new_url);
    }
</script>


<script type="text/javascript">


    var policy_row = parseInt(<?php echo count($ProductDetails_data['policy']) ?>);


    function addReturnPolicy() {
        policy_count = parseInt($(".policy").length) + 1;
        if (policy_count <= 5) {
            html = '<tr id="policy-row' + policy_row + '">';

            html += '  <td class="text-left"><textarea name="policy[]" id="product_policy' + policy_row + '"  class="form-control policy"></textarea></td>';
            html += '  <td class="text-right"><button type="button" onclick="$(\'#policy-row' + policy_row + '\').remove();" data-toggle="tooltip" title="Remove" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>';
            html += '</tr>';

            $('#policy tbody').append(html);

            policy_row++;
        }
    }

</script>

<script type="text/javascript">

    $('input[name=is_product_returnable]').click(function () {

        if (this.value == "Yes") {
            $('#returnable_div').show();
        } else {
            $('#returnable_div').hide();
        }

    });

    function restrictAlphabets(e) {
        var x = e.which || e.keycode;
        if ((x >= 65 && x <= 90) || (x >= 97 && x <= 122) || (x >= 48 && x <= 57) || x == 46 || x == 8 || x == 32)
            return true;
        else
            return false;
    }

    function restrictNumbers(e) {
        var x = e.which || e.keycode;
        if (x >= 48 && x <= 57 || x == 46)
            return true;
        else
            return false;
    }

    function restrictPrice(e) {
        var x = e.which || e.keycode;
        if (x >= 48 && x <= 57 || x == 46)
            return true;
        else
            return false;
    }

    $(document).ready(function () {
        $('#moq_11, #moq_1, #moq_2, #moq_3, #moq_4, #price_1, #price_2, #price_3, #price_4, #price_11, #available_quantity, #low_stock_quantity')
            .keydown(function (event) {

                //alert(event.keyCode);
                if (event.shiftKey == true) {
                    event.preventDefault();
                }

                if ((event.keyCode >= 48 && event.keyCode <= 57) ||
                    (event.keyCode >= 96 && event.keyCode <= 105) ||
                    event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 37 ||
                    event.keyCode == 39 || event.keyCode == 46 || event.keyCode == 190) {

                } else {
                    event.preventDefault();
                }

                var arrOfIds = ['price_1', 'price_2', 'price_3', 'price_4', 'price_11'];
                //alert(jQuery.inArray(this.id, arrOfIds));

                if(jQuery.inArray(this.id, arrOfIds) != -1) {
                    if ($(this).val().indexOf('.') != -1 && event.keyCode == 190)
                        event.preventDefault();
                    //if a decimal has been added, disable the "."-button
                } else {
                    if ($(this).val().indexOf('.') !== 0 && event.keyCode == 190)
                        event.preventDefault();
                    //dont allow decimal to be added for qty except prices
                }

            });

    });

    function addSpecs(value) {
        var newAddedListId = value + Math.floor(1000 + Math.random() * 9000);
        var htmlSelectList = $('#data' + value).html();
        $addHtml = '<div class="col-md-10 mt-1" id="' + newAddedListId + '">' +
            htmlSelectList +
            '</div><button type="button" id="btn' + newAddedListId + '" class="btn btn-sm btn_clone_spec_color mt-1" onclick=removeSpecs("' + newAddedListId + '")>' +
            '<i class="fa fa-remove"></i></button>';
        $("#" + value).append($addHtml);
    }

    function removeSpecs(value) {
        document.getElementById(value).remove();
        document.getElementById('btn' + value).remove();
    }

    $(document).ready(function () {
        $("#weight,#height, #length, #width").on("keypress keyup blur", function (event) {
            //this.value = this.value.replace(/[^0-9\.]/g,'');
            $(this).val($(this).val().replace(/[^0-9\.]/g, ''));
            if ((event.which != 46 || $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57)) {
                event.preventDefault();
            }
        });
    });

    /***
     * @auther Yogesh Pardeshi
     * start of inventory control handling and validations
     ***/
    function toggleGreenRed() {
        if($("#track_inventory").prop('checked') === true) {
            var avail_quantity = parseInt($('#available_quantity').val());
            var min_quantity = parseInt($('#low_stock_quantity').val());
            $('#remain_quantity').val(avail_quantity);
            if (min_quantity < avail_quantity) {
                $("#available_quantity").css("border", "1px solid green");//more efficient
                return;
            } else {
                $("#available_quantity").css("border", "1px solid red");//more efficient
                return;
            }
        }
    }

    $(document).ready(function(){
        $('#available_quantity, #low_stock_quantity').change(function(){
            toggleGreenRed();
        });

        $('#chk_notify').click(function(){
            if($("#track_inventory").prop('checked') === true) {
                if ($(this).prop("checked") == false) {
                    alert("You will not receive SMS and Email when product will reach at minimum quantity.");
                    $(this).val(0);
                } else {
                    alert("You will receive SMS and Email when product will reach at minimum quantity.");
                    $(this).val(1);
                }
            }
        });

        $("input[name='track_inventory']").click(function(){
            var toggleInventory = parseInt($(this).val());
            if(toggleInventory === 0) {
                //disable Low Stock Quantity and checkbox
                $('#low_stock_quantity').prop('disabled', true);
                $('#chk_notify').prop('disabled', true);
                $("#available_quantity").css("border", "1px solid #ccc");//more efficient
            } else {
                //enable Low Stock Quantity and checkbox
                $('#low_stock_quantity').prop('disabled', false);
                $('#chk_notify').prop('disabled', false);
                $('#available_quantity').trigger('change');
            }
        })

    });

    $(window).on('load', function() {
        if($("#dont_track_inventory").prop('checked') === true) {
            var toggleInventory = parseInt($('#dont_track_inventory').val());
            if(toggleInventory === 0) {
                //disable Low Stock Quantity and checkbox
                $('#low_stock_quantity').prop('disabled', true);
                $('#chk_notify').prop('disabled', true);
                $("#available_quantity").css("border", "1px solid #ccc");//more efficient
            }
        }
        if($("#track_inventory").prop('checked') === true) {
            //enable Low Stock Quantity and checkbox
            $('#low_stock_quantity').prop('disabled', false);
            $('#chk_notify').prop('disabled', false);
            toggleGreenRed();
        }
    });

    /**
     * End of inventory control handling and validations
     **/

</script>