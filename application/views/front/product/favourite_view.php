<?php $this->load->view("front/common/header"); ?>
<div class="ui2-grid">
    <div class="grid grid-1200 grid-c1-s11">
        <div class="col-main">
            <div class="main-wrap">
                <div id="app">
                    <div data-reactroot="" class="fav-main-content">
                        <div class="page-fav-list-box">
                            <div class="list-top-control ">
                                <div class="next-tabs next-tabs-wrapped next-tabs-medium next-tabs-top">
                                    <div role="tablist" class="next-tabs-bar" tabindex="0">
                                        <div class="next-tabs-nav-container">
                                            <div class="next-tabs-nav-wrap">
                                                <div class="next-tabs-nav-scroll" style="width: 100%;">
                                                    <div class="next-tabs-nav"
                                                         style="transform: translate3d(0px, 0px, 0px);">
                                                        <div role="tab" aria-disabled="false" aria-selected="true"
                                                             class="next-tabs-tab active next-tabs-nav-appear next-tabs-nav-appear-active" data-tag="one">
                                                            <div class="next-tabs-tab-inner">Products</div>
                                                        </div>
                                                        <div role="tab" aria-disabled="false" aria-selected="false"
                                                             class="next-tabs-tab next-tabs-nav-appear next-tabs-nav-appear-active" data-tag="two">
                                                            <div class="next-tabs-tab-inner">Suppliers</div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="next-tabs-content">
                                        <div role="tabpanel" aria-hidden="false" class="next-tabs-tabpane active">
                                            <div class="group-manager-box ">
                                                <div class="g-manager-box-content box-view-less">
                                                </div>
                                                <div class="g-manager-box-view-btn-box box-small">
                                                    <span
                                                        class="g-m-btn-view box-hide">
                                                        View More
                                                        <i class="next-icon next-icon-arrow-down next-icon-xs"></i>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <?php echo $this->session->flashdata('success_msg'); ?>
                                    </div>

                                </div>

                            </div>
                            <div   class="fav-list-box product-list-box ">
                                <div class="fav-list-content tab-body-pane show" id="one">

                                    <?php
                                    if ($user_products) {
                                        foreach ($user_products as $user_product):
                                            $title = str_replace('-', '_', $user_product['name']);
                                            $url_title = str_replace(' ', '-', $title);
                                            ?>
                                            <div class="list-item ">
                                                <div class="item-pic">
                                                    <a class="item-p-img-link" 
                                                       href="<?php echo base_url(); ?>product-details/<?php echo $url_title; ?>/<?php echo $user_product['id']; ?>"
                                                       target="_blank"><img class="item-p-img"
                                                                         src="<?php echo $user_product['media_url']; ?>"></a>
                                                </div>
                                                <div class="item-content">
                                                    <a
                                                        href="<?php echo base_url(); ?>product-details/<?php echo $url_title; ?>/<?php echo $user_product['id']; ?>"
                                                        title="<?php echo $user_product['name']; ?>"
                                                        class="item-p-title" target="_blank"><?php echo $user_product['name']; ?></a>
                                                    <div class="item-p-s-info">
                                                        <div class="item-p-icon-sp-name">
                                                            <a 
                                                                href=""
                                                                class="item-p-suppliers-cp" target="_blank"
                                                                title="Meirun Technology (Guangzhou) Co., Ltd."><span
                                                                    class="item-suppliers-name-wrap"><span
                                                                        class="item-suppliers-name"><?php echo $user_product['company_name']; ?></span></span></a>
                                                            <span>
                                                                <?php echo $user_product['products']['location_country']; ?>(<?php echo $user_product['comp_operational_city']; ?>)
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <?php if ($user_product['available_quantity'] <= $user_product['low_stock_qty']) { ?>
                                                        <p style='font-weight:bold;font-size:1.4em;' class='text-danger mb-2 ml-5 text-center'>Out Of Stock</p>
                                                    <?php } else { ?>
                                                        <div>
                                                            <div class="item-p-field"><span class="item-p-text item-p-text-light"><i class="fa fa-inr"></i>
                                                                    <?php echo $user_product['max_final_price']; ?></span><span class="item-p-des"> / <?php echo $user_product['units_name']; ?></span></br>
                                                                    <?php
                                                                    if ($user_product['mrp'] != $user_product['max_final_price'] && $user_product['mrp'] != 0) {
                                                                        echo "<div class= 'mt-2'><span style='color:black;'> <i class='fa fa-inr'></i> <span class='price-new text-mute'><del>" . $user_product['mrp'] . "</del></span></span> ";
                                                                        echo " <strong><span class='text-success'>" . $user_product['discount'] . " </span> </strong></div>";
                                                                    }
                                                                    ?>
                                                            </div>
                                                        </div>
                                                        <div class="item-p-field">
                                                            <span class="item-p-text">
            <?php echo $user_product['quantity_from']; ?>
            <?php echo $user_product['units_name']; ?>
                                                            </span>
                                                            <span class="item-p-des">(Min.Order)</span>
                                                        </div>
        <?php } ?>
                                                </div>
                                                <div class="item-action">
                                                    <div class="item-p-item-other undefined">
                                                        <div class="pr-100">
                                                            <a href="<?php echo base_url(); ?>remove-favorite/<?php echo $user_product['id']; ?>" >
                                                                <i class="icon ion-trash-b"></i>

                                                                Remove
                                                            </a>
                                                        </div>
                                                    </div>
                                                    <div class="item-p-contact">
                                                        <a href="<?php echo base_url(); ?>product-inquiry/<?php echo $user_product['id']; ?>" >
                                                            <button type="button"
                                                                    class="next-btn next-btn-primary next-btn-medium item-action-btn">
                                                                <i class="icon ion-ios-telephone"></i>
                                                                Contact Supplier
                                                            </button>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php
                                        endforeach;
                                    } else {
                                        ?>
                                        <div class="text-center p-3"><h4>There Are No Products In Favorite </h4></div>
                                        <?php } ?>
                                </div>
                                <div class="fav-list-box suppliers-list-box ">
                                    <div class="fav-list-content tab-body-pane box-hide" id="two"">
<?php
if ($sellers_products) {
    foreach ($sellers_products as $seller_product):
        ?>
                                                <div class="list-item " data-index="0">
                                                    <div class="item-pic">

                                                        <div class="item-p-s-info">
                                                            <div class="item-p-icon-sp-name">
                                                                <a target="_blank" href="" class="bc-fav-gs-wrap fav-mr-5" rel="nofollow">
                                                                    <i class="bc-fav-i-gs"></i>
                                                                    <span class="bc-fav-i-gs-years">
                                                                        <span class="bc-fav-i-gs-y-value"><?php echo (isset($seller_product['sellers']['year_of_register']) ? date("Y") - $seller_product['sellers']['year_of_register'] : ''); ?></span>
                                                                        <span class="bc-fav-i-gs-y-unit">YRS</span>
                                                                    </span></a>
                                                                <a  href="" class="item-p-suppliers-cp" target="_blank" title="<?php echo $seller_product['sellers']['company_name']; ?>">
                                                                    <span class="item-suppliers-name-wrap">
                                                                        <span class="item-suppliers-name"><?php echo $seller_product['sellers']['company_name']; ?></span>
                                                                    </span></a>
                                                                <span>
                                                                    [<?php echo $seller_product['sellers']['location_country']; ?>(<?php echo $seller_product['sellers']['comp_operational_city']; ?>)]
                                                                </span>
                                                            </div>
                                                        </div>

                                                        <div class="item-products-box">
                                                            <div class="item-p-box-subitem"><a class="subitem-img-link" href="#" target="_blank"><img class="subitem-p-img" src="<?php echo $seller_product['sellers']['logo']; ?>"></a><a title="<?php echo $seller_product['sellers']['company_name']; ?>" class="subitem-p-title" href="#" target="_blank"><?php echo $seller_product['sellers']['company_name']; ?></a></div>
                                                        </div>
                                                    </div>
                                                    <div class="item-content">
                                                        <div class="suppliers-detail">
                                                            <div class="item-p-field field-s"><span class="i-field-title">Response Rate:</span><span class="i-field-text"><?php echo rand(10, 100); ?>%</span></div>
                                                        </div>
                                                    </div>
                                                    <div class="item-action">
                                                        <!--  <div class="item-p-item-other undefined">
                                                              <div class="item-other-del pr-100">
                                                                                                              <a href="<?php echo base_url(); ?>remove-seller/<?php echo $seller_product['sellers']['id']; ?>" >
                                                                                                              <i class="next-icon next-icon-ashbin next-icon-small fav-mr-5"></i>
                                                                                                              Delete
                                                                                                              </a>
                                                                                                      </div>
                                                          </div>-->
                                                        <div class="item-p-contact pt-100">
                                                            <a href="<?php echo base_url(); ?>remove-seller/<?php echo $seller_product['sellers']['id']; ?>" >
                                                                <button type="button" class="next-btn next-btn-primary next-btn-medium item-action-btn">
                                                                    <i class="next-icon next-icon-trash next-icon-medium next-icon-first"></i>Remove
                                                                </button>
                                                            </a>
                                                        </div>

                                                    </div>
                                                </div>
                                            <?php
                                            endforeach;
                                        } else {
                                            ?>
                                            <div class="text-center p-3" ><h4>There Are No Suppliers In Favorite </h4></div>
<?php } ?>

                                    </div>

                                </div>
                            </div>
                            <div class="fav-loadding-mask "><i
                                    class="next-icon next-icon-loading next-icon-large mask-icon"></i></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $this->load->view("front/common/footer"); ?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script>
    $(document).ready(function () {
        var cart_count = $("#cart_count").text();
        if (cart_count == 0)
        {
            $("#cart").hide();
        }

        $('.next-tabs-tab').click(function () {
            $('.next-tabs-tab').removeClass('active');
            $(this).addClass('active');
            var tagid = $(this).data('tag');
            $('.tab-body-pane').removeClass('show').addClass('box-hide');
            $('#' + tagid).addClass('show').removeClass('box-hide');
        });
    });
</script>