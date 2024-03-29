<?php 
$this->load->view("front/common/header"); 
?>
<style>
    @import url("<?php echo base_url(); ?>assets/front/css/categroies.css");

    .ffnav .dropdown-menu {
        position: absolute;
        position: absolute;
        top: 50px;
        width: 290px
    }

    .ffnav .dropdown:hover .dropdown-menu {
        display: block;
        overflow-y: scroll;
        max-height: 200px;
    }

    .ffnav .dropdown-menu li a:hover {
        background: none !important;
    }
    .woocommerce-ordering {
        float: right;
        margin: 0;
        margin-right: 40px;
        position: relative;
    }
    .woocommerce-ordering {
        float: right;
        margin: 0;
        margin-top:3px;
        margin-right:5px;
        position: relative;
    }

    .woocommerce-ordering .orderby-wrapper label {
        font-size: 1em;
        font-weight: 600;
        margin-right: 10px;
        line-height: 40px;
    }

    select {
        border: 1px solid #ccc;
        padding-left: 10px;
        box-shadow: none;
        color: #555555;
        height: 45px;
        line-height: 45px;
        font-size: 12px;
        width: 100%;
    }
    .woocommerce-ordering .orderby-wrapper .nice-select {
        display: inline-block;
        font-size: 1em;
        padding: 0;
        vertical-align: top;
        float: right;
        background: #fff;
        border: 1px solid #ededed;
        border-radius: 0;
        box-shadow: none;
        color: inherit;
        height: 40px;
        line-height: 38px;
        min-width: 180px;
        padding: 0 15px;
        text-align: left;
    }



    /* This line can be removed it was just for display on CodePen: */

    .slider-labels {
        margin-top:5px;
    }

    /* Functional styling;
     * These styles are required for noUiSlider to function.
     * You don't need to change these rules to apply your design.
     */
    .noUi-target,.noUi-target * {
        -webkit-touch-callout: none;
        -webkit-user-select: none;
        touch-action: none;
        -ms-user-select: none;
        -moz-user-select: none;
        user-select: none;
        box-sizing: border-box;
    }

    .noUi-target {
        position: relative;
        direction: ltr;
    }

    .noUi-base {
        width: 100%;
        height: 100%;
        position: relative;
        z-index: 1;
        /* Fix 401 */
    }

    .noUi-origin {
        position: absolute;
        right: 0;
        top: 0;
        left: 0;
        bottom: 0;
    }

    .noUi-handle {
        position: relative;
        z-index: 1;
    }

    .noUi-stacking .noUi-handle {
        /* This class is applied to the lower origin when its values is > 50%. */
        z-index: 10;
    }

    .noUi-state-tap .noUi-origin {
        transition: left 0.3s,top .3s;
    }

    .noUi-state-drag * {
        cursor: inherit !important;
    }

    /* Painting and performance; Browsers can paint handles in their own layer. */
    .noUi-base,.noUi-handle {
        -webkit-transform: translate3d(0,0,0);
        transform: translate3d(0,0,0);
    }

    /* Slider size and handle placement; */
    .noUi-horizontal {
        height: 4px;
    }

    .noUi-horizontal .noUi-handle {
        width: 18px;
        height: 18px;
        border-radius: 50%;
        left: -7px;
        top: -7px;
        background-color: #bd081b;
    }

    /* Styling;*/
    .noUi-background {
        background:#c7c7c7;
    }

    .noUi-connect {
        background: #c7c7c7;
        transition: background 450ms;
    }

    .noUi-origin {
        border-radius: 2px;
    }

    .noUi-target {
        border-radius: 2px;
    }

    .noUi-target.noUi-connect {
    }

    /* Handles and cursors; */
    .noUi-draggable {
        cursor: w-resize;
    }

    .noUi-vertical .noUi-draggable {
        cursor: n-resize;
    }

    .noUi-handle {
        cursor: default;
        box-sizing: content-box !important;
    }

    .noUi-handle:active {
        border: 8px solid #345DBB;
        border: 8px solid rgba(53,93,187,0.38);
        -webkit-background-clip: padding-box;
        background-clip: padding-box;
        left: -14px;
        top: -14px;
    }

    /* Disabled state;
     */
    [disabled].noUi-connect,[disabled] .noUi-connect {
        background: #B8B8B8;
    }

    [disabled].noUi-origin,[disabled] .noUi-handle {
        cursor: not-allowed;
    }

    .range-font{
        font-size: 12px;
    }
</style>
<div class="l-page-main-v2 mt-3 container-fluid" style="min-height: auto;">
    <div class="l-main-content">
        <!-- tangram:3986 begin-->
        <div class="l-grid-after-topcontent">
        </div>
        <!-- tangram:3986 end-->
        <div class="l-grid-top">
            <div class="l-top-wrap">
                <div class="m-gallery-product-filter">
                    <div class="m-gallery-filter-wrap">
                        <div class="m-related-category-wrap">
                            <div class="related-category-label">
                                YOU ARE IN :
                            </div>
                            <div class="related-category-result">
                                <div class="m-gallery-product-filter-breadcrumb-wrapper">
                                    <?php foreach ($catames as $row) { ?>
                                        <div class="m-gallery-product-filter-breadcrumb checked">
                                            <a href="<?php echo site_url('product-catalog/') . underscore($row['categories_name']) . "/" . $row['category_id']; ?>"> <?php echo $row['categories_name']; ?></a>
                                            <span class="divider"></span>
                                        </div>
                                    <?php } ?>
                                    <?php if (count($cat_dropdown) > 1) { ?>
                                        <ul class="ffnav navbar-nav">
                                            <li class="dropdown">
                                                <a href="#"><i class="icon ion-ios-arrow-up"></i></a>
                                                <ul class="dropdown-menu">
                                                    <?php for ($i = 1; $i <= count($cat_dropdown); $i++) { ?>
                                                        <li>
                                                            <a href="<?php echo site_url('product-catalog/') . underscore($cat_dropdown[$i]['cat_name']) . "/" . $cat_dropdown[$i]['cat_id']; ?>"><?php echo $cat_dropdown[$i]['cat_name']; ?> </a>
                                                        </li>
                                                    <?php } ?>
                                                </ul>
                                            </li>
                                        </ul>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                        <div class="hr">
                            <div class="line"></div>
                        </div>

                        <div class="m-filter-wrap">
                            <div class="m-filter-label">
                                FILTER RESULTS BY :
                            </div>						

                            <div class="filter-result">
                                <div class="filter-result-item">
                                    <div class="input-group mb-2 mt-2 col">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="basic-addon1">
                                                Min Order :</span>
                                        </div>
                                        <input type="text" class="form-control" id='min_order' placeholder="less than"
                                               onkeypress="return IsAlphaNumeric(event)">
                                    </div>


                                    <div class="col pt-3">
                                        <div class="col-sm-12 p-0">
                                            <div id="slider-range"></div>
                                        </div>									 

                                        <div class="row slider-labels pt-0">
                                            <div class="col-6 p-0 caption">
                                                <p class="p-0 m-0"><strong style="font-size:13px;">Min:&#8377;</strong> <span id="slider-range-value1" style="font-size:13px;"></span> </p>                    
                                            </div>	                                    


                                            <div class="col-6 p-0 float-right text-right caption pr-0">
                                                <p class="p-0 m-0"><strong style="font-size:13px;">Max:&#8377;</strong> <span id="slider-range-value2" style="font-size:13px;"></span></p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <input type="hidden" id='min_price' name="min-value" class="form-control" placeholder="min."
                                                       onkeypress="return IsAlphaNumeric(event)">
                                                <input type="hidden" class="form-control"  name="max-value" placeholder="max." id='max_price'
                                                       onkeypress="return IsAlphaNumeric(event)">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="input-group col mb-2 mt-2">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Sort By</span>
                                        </div>
                                        <select type="select" class="form-control" name="sortby" id="sortby" onchange="filter_product()">
                                            <option value="" class="form-control" >Select</option>
                                            <option value="0" class="form-control" >Price low to high</option>
                                            <option value="1" class="form-control" >Price high to low</option>
                                        </select> 
                                    </div>
                                    <div class="m-price-filter-wrap mt-1 col">
                                        <button type="button" class="btn btn-danger" onclick="filter_product()">Filter
                                        </button>
                                    </div>

                                    <div id="price_error"></div>
                                    <div id="error_messege"></div>
                                </div>						
                            </div>   
                        </div>
                    </div>
                    <div class="m-gallery-selected-wrap">
                        <div class="selected-total-wrap" id="filterd_result">
                            <?php echo $cat_details; ?> results for
                            "<?php echo $catames[count($catames) - 1]["categories_name"]; ?>"
                        </div>
                    </div>
                </div>
                <div data-assets-module="region-filter-noty-weighty"></div>
            </div>
        </div>
        <div class="l-grid l-grid-extra ">
            <div class="l-col-main">
                <div class="l-main-wrap">
                    <div style="position: relative; z-index: 100;">
                    </div>
                    <div class="l-theme-card-box">
                        <div id="filtered_data">
                            <?php
                            if ($products) {
                                foreach ($products as $product) {
                                    ?>
                                    <div class="m-gallery-product-item-wrap col-2  special-cpvitem__render-product item__offer-global-impression-tags__always-show"
                                         >
                                        <!-- tangram:4161 begin-->
                                        <div class="m-gallery-product-item-v2">
                                            <div class="item-main">
                                                <div class="item-img">
                                                    <div class="place"></div>
                                                    <div class="item-img-inner">
                                                        <?php $productNameSeo = $this->Product_model->seoUrl($product['product_name']); ?>
                                                        <a href="<?php echo base_url('product-details/') . $productNameSeo . "/" . $product['product_id']; ?>">
                                                            <div class="offer-image-box">
                                                                <div
                                                                    class="J-favorite-manager-wrap-product gallery-favorite-container J-sc-fav-item-wrap">
                                                                    <div class="favorite-corner J-sc-fav-item-wrap"
                                                                         id="detail-favorite-mark">
                                                                        <div class="J-scc-favorite-manager-label scc-favorite-manager-label scc-fav-label-onlyicon scc-fav-icon-bkg">
                                                                            <a href="javascript:void(0)"
                                                                               class="add_favorite"
                                                                               data-product-id="<?php echo $product['product_id']; ?>"><?php
                                                                                   $fav_prod = $this->session->userdata("faverite_products");
                                                                                   if (in_array($product['product_id'], $fav_prod)) {
                                                                                       ?>
                                                                                    <i class="fa fa-heart scc-fav-i-heart-n-normal-small label-icon-mail"
                                                                                       style="color:red;"></i><?php } else { ?>
                                                                                    <i class="fa fa-heart scc-fav-i-heart-n-normal-small label-icon-mail"></i><?php } ?>
                                                                            </a>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <a href="<?php echo base_url('product-details/') . $productNameSeo . "/" . $product['product_id']; ?>">
                                                                    <img src="<?php echo $product['media_url']; ?>"
                                                                         class="img-fluid" alt=""></a>
                                                            </div>
                                                        </a>
                                                    </div>
                                                </div>
                                                <div class="item-info">
                                                    <h2 class="title two-line" style="display:flex;">
                                                        <a target="_blank"
                                                           href="<?php echo base_url('product-details/') . $productNameSeo . "/" . $product['product_id']; ?>"
                                                           title="<?php echo $product['product_name']; ?>">
                                                            <!-- tangram:3721 begin-->
                                                            <?php echo $product['product_name']; ?>
                                                        </a>
                                                    </h2>
                                                    <div class="pmo">
                                                        <a href="<?php echo base_url('product-details/') . $productNameSeo . "/" . $product['product_id']; ?>">
                                                            <?php
                                                            $discount_unit = '%'; // by default offer percentage // using this to better manage flat discount
                                                            //check first iff offer is active first
                                                            if (strtolower($product['offer_status']) == 'active') {
                                                                //check wheather the offer has started
                                                                $todaysDate = time();
                                                                $offerStartDate = strtotime($product['valid_from'] . ' ' . $product['time_from']);
                                                                if ($todaysDate >= $offerStartDate) {
                                                                    $offerEndDate = strtotime($product['valid_to'] . ' ' . $product['time_to']);
                                                                    //check whether the offer has expired using time stamp
                                                                    if ($todaysDate <= $offerEndDate) {
                                                                        //if offer is still running then change product discount and final price for
                                                                        // display only
                                                                        $product['discount'] = $product['offer_discount_value'];
                                                                        if (strtolower($product['offer_type']) == 'percentage') {
                                                                            //$product['mrp'] = $product['final_price1'];
                                                                            $product['final_price1'] = $product['mrp'] - (($product['mrp'] * $product['offer_discount_value']) / 100);
                                                                            $percent = " % ";
                                                                            $discount_unit = '';
                                                                        }
                                                                        //apply flat value to product discount and final price for
                                                                        if (strtolower($product['offer_type']) == 'flat') {
                                                                            //$product['mrp'] = $product['final_price1'];
                                                                            $product['final_price1'] = $product['mrp'] - $product['offer_discount_value'];
                                                                            $discount_unit = ' <i class=\'fa fa-inr\'></i>';
                                                                            $percent = "";
                                                                        }
                                                                    }
                                                                }
                                                            } else {
                                                                $percent = " % ";
                                                                $discount_unit = '';
                                                            }
                                                            ?>
                                                            <div class="price">
                                                                <b><i class="fa fa-inr"></i> <?php echo $product['final_price1']; ?> / <?php echo strtoupper($product['units_name']); ?> </b>
                                                            </div>
                                                            <?php
                                                            if ($product['mrp'] != $product['final_price1'] && $product['mrp'] != 0) {
                                                                if ($product['discount'] != 0) {
                                                                    echo " <i class='fa fa-inr'></i> <span class='price-new text-mute'><del>" . $product['mrp'] . "</del></span> ";
                                                                    echo " <strong><span class='text-success'> $discount_unit " . $product['discount'] . " $percent Off </span> </strong>";
                                                                }
                                                            }
                                                            ?>
                                                            <!--                                                   <div class="price">
                                                     <b>
                                                     INR.<?php echo $product['final_price1']; ?> - <?php echo $product['final_price2']; ?>
                                                     </b>
                                                     / <?php echo $product['units_name']; ?>
                                                  </div>
                                                 <div class="min-order">
                                                     <b><?php echo $product['moq2']; ?> <?php echo $product['units_name']; ?></b>
                                                     (Min Order)
                                                  </div>-->
                                                        </a>
                                                    </div>
                                                    <!--                                            <div class="hr">
                                               <span></span>
                                            </div>
                                            <div class="contact">
                                               <a class="ui2-button ui2-button-default ui2-button-primary ui2-button-small csp"
                                                  href="<?php echo base_url(); ?>home_product/product_inquiry/<?php echo $product['product_id']; ?>" rel="nofollow" >
                                               Contact Supplier
                                               </a>
                                            </div>-->
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    <?php
                                }
                            } else {
                                ?>
                                <div class="clearfix">
                                    <div id="notfound">
                                        <div class="notfound">
                                            <div class="notfound-404">
                                                <h1>Oops!</h1>
                                                <h2>No Products Found !!</h2>
                                            </div>
                                            <a href="<?php echo base_url(); ?>">Go TO Homepage</a>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>


                        </div>

                    </div>

                </div>
            </div>
        </div>
        <div class="alert ajax-load text-center" style="display:none">
            <p class="text-dnager"><img src="<?php echo base_url(); ?>assets/front/images/loaders/loader.gif">Loading
                More post</p>
        </div>
    </div>
</div>
</div>
<?php
$this->load->view("front/common/footer");
?>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/front/js/slider.js"></script> 
<script>
                                            var faveProd = JSON.parse('<?php echo json_encode($fav_prod); ?>');
                                            var cat_id = '<?php echo $ccat_id; ?>';
                                            var page = 0;

                                            function IsAlphaNumeric(e) {
                                                var x = e.which || e.keycode;
                                                if (x >= 48 && x <= 57)
                                                    return true;
                                                else
                                                    return false;
                                            }

                                            function filter_product() {
                                                page = 0;
                                                var min_order = $("#min_order").val();
                                                var min_price = $("#min_price").val();
                                                var max_price = $("#max_price").val();
                                                var sortby = $('#sortby').val();

                                                $('#error_messege').html('');
                                                $('#price_error').html('');
                                                $.ajax({
                                                    url: '<?php echo site_url(); ?>filterProduct',
                                                    type: 'POST',
                                                    dataType: 'json',
                                                    data: {min_order: min_order, min_price: min_price, max_price: max_price, cat_id: cat_id, sortby: sortby},
                                                    success: function (data) {
                                                        console.log(data);

                                                        if (data != false) {
                                                            var html_data = "";
                                                            var title = '';
                                                            var url_title = '';
                                                            var str = '';
                                                            var icon = '';
                                                            var dis = '';

//                                                            var count = data.length;
                                                            $("#filterd_result").html("filtered results for <?php echo $catames[count($catames) - 1]["categories_name"]; ?>.");
                                                            $.each(data, function (inx, obj) {

                                                                str = obj.product_name;
                                                                title = str.replace('-', '_');
                                                                url_title = title.replace(' ', '-');

                                                                if (jQuery.inArray(parseInt(obj.product_id), faveProd) !== -1) {
                                                                    icon = '<i class="fa fa-heart scc-fav-i-heart-n-normal-small label-icon-mail" style="color:red"></i>';
                                                                } else {
                                                                    icon = '<i class="fa fa-heart scc-fav-i-heart-n-normal-small label-icon-mail"></i>';
                                                                }

                                                                if (obj.mrp != obj.final_price1 && obj.mrp != 0) {
                                                                    dis = "<i class='fa fa-inr'></i> <span class='price-new text-mute'><del>" + obj.mrp + "</del></span><strong><span class='text-success'>" + obj.discount + " % Off </span> </strong>";
                                                                }
                                                                html_data += '<div class="m-gallery-product-item-wrap col-2  special-cpvitem__render-product item__offer-global-impression-tags__always-show">';

                                                                html_data += '<div class="m-gallery-product-item-v2"><div class="item-main"><div class="item-img"><div class="place"></div><div class="item-img-inner"><a  href="<?php echo base_url('product-details/'); ?>' + url_title + "/" + obj.product_id + '"><div class="offer-image-box"><div class="J-favorite-manager-wrap-product gallery-favorite-container J-sc-fav-item-wrap"><div class="favorite-corner J-sc-fav-item-wrap" id="detail-favorite-mark" ><div class="J-scc-favorite-manager-label scc-favorite-manager-label scc-fav-label-onlyicon scc-fav-icon-bkg"><a href="javascript:void(0)" class="add_favorite" data-product-id="' + obj.product_id + '">' + icon + '</a></div></div></div><a href="<?php echo base_url('product-details/') ?>' + url_title + "/" + obj.product_id + '"><img src="' + obj.media_url + '" class="img-fluid" alt=""></a></div></a></div></div>';

                                                                html_data += '<div class="item-info"><h2 class="title two-line" style="display:flex;"><a target="_blank" href="<?php echo base_url('product-details/') ?>' + url_title + "/" + obj.product_id + '" title="' + obj.product_name + '">' + obj.product_name + '</a></h2><div class="pmo "><a href="<?php echo base_url('product-details/') ?>' + url_title + "/" + obj.product_id + '"><div class="price"><b><i class="fa fa-inr"></i>' + obj.final_price1 + '/</b>' + obj.units_name + '</div><div class="min-order">' + dis + '</div></a></div><div class="hr"><span></span></div></div></div></div></div>';
                                                            });

                                                            $('#filtered_data').html(html_data);
                                                        } else {
                                                            $('#filtered_data').html("<div class='clearfix'><div id='notfound'><div class='notfound'><div class='notfound-404'><h1>Oops!</h1><h2>Your Filter Did Not Match Any Product !!</h2></div><a href='<?php echo base_url(); ?>'>Go TO Homepage</a></div></div></div>");
                                                            $("#filterd_result").html("<b>0</b> results for <?php echo $catames[count($catames) - 1]["categories_name"]; ?>.");
                                                        }
                                                    },
                                                });

                                            }

</script>
<script type="text/javascript">

    $(document).ready(function () {
        var maxPages = <?php echo ceil($cat_details / 12) ;?>;
        $(window).scroll(function () {
            if ($(window).scrollTop() + $(window).height() >= $(document).height() * 0.85) {
                page++;
                if(page <= maxPages){
                    loadMoreData(page);
                }
                
            }
        });
    });


    function loadMoreData(page) {

        $.ajax({
            url: "<?php echo site_url(); ?>home_product/getAjaxfilteredProducts",
            type: "post",
            data: {
                page: page,
                category: "<?php echo $ccat_id; ?>",
                moq: $("#min_order").val(),
                min_price: $("#min_price").val(),
                price_from: $("#max_price").val(),
                sortby: $('#sortby').val()
            },
            beforeSend: function () {
                $('.ajax-load').show();
            }
        }).done(function (resp) {
            var obj = JSON.parse(resp);
            if (obj.status) {
                $('.ajax-load').hide();
                var html = "";
                $.each(obj.items, function (key, value) {
                    var product_name = value.product_name.replace(/[^A-Z0-9]/ig, "-");
                    product_name = product_name.replace(/[&\/\\#,+()$~%.'":*?<>{}]/g, '');
                    var icon = '';
                    if (value.mrp != 0 && value.mrp != value.final_price1 && value.discount !=0) {
                        discount = "<i class='fa fa-inr'></i> <span class='price-new text-mute'><del>" + value.mrp + "</del></span>" +
                               "<strong><span class='text-success'>" + value.discount + " % Off </span><strong>";
                    } else {
                        discount = "";
                    }

                    //Added By Yogesh Pardeshi 19082019 for Offer Module
                    //check offer status first i.e. offer is alive or active
                    //Yogesh Pardeshi has changed this multiple times
                    //please keep it as offer_status while conflicting 30082019
                    if (value.offer_status == 'Active') {
                        var todaysDate = Date.parse(obj.todaysDate);
                        var offerStartDate = Date.parse(value.valid_from + ' ' + value.time_from);
                        var offerEndDate = Date.parse(value.valid_to + ' ' + value.time_to);
                        if (todaysDate >= offerStartDate) {
                            //check whether the offer has expired using time stamp
                            if (todaysDate <= offerEndDate) {
                                //if offer is still running then change product discount and final price for
                                // display only
                                discount = value.offer_discount_value;
                                if (value.offer_type == 'percentage') {
                                    value.mrp = value.final_price1;
                                    value.final_price1 = value.final_price1 - ((value.final_price1 * value.offer_discount_value) / 100);
                                    discount = "<i class='fa fa-inr'></i> <span class='price-new text-mute'><del> " + value.mrp + "</del></span>" +
                                            "<strong><span class='text-success'>" + value.offer_discount_value + " % Off </span><strong>";
                                }
                                //apply flat value to product discount and final price for
                                if (value.offer_type == 'flat') {
                                    value.mrp = value.final_price1;
                                    value.final_price1 = value.final_price1 - value.offer_discount_value;
                                    discount = "<i class='fa fa-inr'></i> <span class='price-new text-mute'><del> " + value.mrp + "</del></span>" +
                                            "<strong><span class='text-success'>" + value.offer_discount_value + " <i class='fa fa-inr'></i> Off </span><strong>";
                                }
                                //otherwise show default discount and final prices of product
                            }
                        }
                    }

                    if (jQuery.inArray(parseInt(value.product_id), faveProd) !== -1) {
                        icon = '<i class="fa fa-heart scc-fav-i-heart-n-normal-small label-icon-mail" style="color:red"></i>';
                    } else {
                        icon = '<i class="fa fa-heart scc-fav-i-heart-n-normal-small label-icon-mail"></i>';
                    }

                    html = '<div class="m-gallery-product-item-wrap col-2  special-cpvitem__render-product item__offer-global-impression-tags__always-show" >' +
                            '<div class="m-gallery-product-item-v2">' +
                            '<div class="item-main">' +
                            '<div class="item-img">' +
                            '<div class="place"></div>' +
                            '<div class="item-img-inner">' +
                            '<a  href="">' +
                            '<div class="offer-image-box">' +
                            '<div class="J-favorite-manager-wrap-product gallery-favorite-container J-sc-fav-item-wrap">' +
                            '<div class="favorite-corner J-sc-fav-item-wrap" id="detail-favorite-mark" >' +
                            '<div class="J-scc-favorite-manager-label scc-favorite-manager-label scc-fav-label-onlyicon scc-fav-icon-bkg">' +
                            '<a href="javascript:void(0)" class="add_favorite" data-product-id="' + value.product_id + '">' + icon + '</a>' +
                            '</div>' +
                            '</div>' +
                            '</div>' +
                            '<a target="_blank" href="<?php echo site_url('product-details'); ?>/' + product_name + '/' + value.product_id + '"><img src="' + value.media_url + '" class="img-fluid" alt=""></a>' +
                            '</div>' +
                            '</a>' +
                            '</div>' +
                            '</div>' +
                            '<div class="item-info">' +
                            '<h2 class="title two-line" style="display:flex;">' +
                            '<a target="_blank" href="<?php echo site_url('product-details'); ?>/' + product_name + '/' + value.product_id + '">' +
                            value.product_name +
                            '</a>' +
                            '</h2>' +
                            '<div class="pmo ">' +
                            '<a href="#">' +
                            '<div class="price">' +
                            '<b>' +
                            '<i class="fa fa-inr"></i> ' + value.final_price1 + ' /' +
                            '</b>' + value.units_name +
                            '</div>' +
                            '<div class="min-order">' +
                            '<b>' + discount + '</b></div>' +
                            '</a>' +
                            '</div>' +
                            '</div>' +
                            '</div>' +
                            '</div>' +
                            '</div>';
                    $("#filtered_data").append(html);
                });
            } else {
                $('.ajax-load').html("");
                return;
            }

        }).fail(function (jqXHR, ajaxOptions, thrownError) {
            //alert('server not responding...');
        });
    }



</script>
