<?php $this->load->view("front/common/header"); ?>


<div class="ocms-container" dir="ltr" >
    <div class="ocms-fusion-atzcart-pc-ch-layout-main-0-0-8 ctrdot-item ctrdot-item-ocm">
        <div class="ocms-fusion-atzcart-pc-ch-layout-main b2b-ocms-fusion-comp column-two" >
            <div class="channel-main-bainer">
                <div class="banner-content"><?php echo $main_category['title']; ?> </div>
                <div class="mask" ></div>
            </div>
			
            <div class="ch-main-layout column-two">
                <div class="">
                    <div name="right-content" class="croco slot">
                        <div class="ocms-fusion-atzcart-pc-ch-nav-with-image-0-0-13 ctrdot-item ctrdot-item-ocms" >
                            <div class="ocms-fusion-atzcart-pc-ch-nav-with-image b2b-ocms-fusion-comp"
                                data-spm="channel_image_category" data-realctr="id:topCategoryNav,ext:floorExp-1"
                                data-reactroot="" data-reactid="1" data-react-checksum="-1395662926">
                                <div class="ch-nav-img-head" data-reactid="2"> SHOP BY CATEGORY </div>
                                <ul class="ch-nav-img-list" data-reactid="3">
                                    <?php foreach($child_cats as $child_cat):?>
                                    <li class="ch-nav-img-item" data-reactid="4">
                                        <a
                                            href="<?php echo site_url('catalog/'). underscore($child_cat->categories_name)."/".$child_cat->category_id;?>"
                                            target="_blank" data-reactid="5">
                                            <div class="img-box" data-reactid="6">
                                                <img class="img-item"
                                                    src="<?php echo $child_cat->categories_image;?>"
                                                    data-reactid="7">
                                            </div>
                                            <div class="category-name" title="<?php echo $child_cat->categories_name;?>"
                                                data-reactid="8"><?php echo $child_cat->categories_name;?></div>
                                        </a>
                                    </li>
                                    <?php endforeach;?>
                                </ul>
                            </div>
                        </div>
                        <?php foreach($products_cats as $key=>$val) :?>
                        <div class="ocms-fusion-atzcart-pc-ch-newarrival-floor-0-0-14 ctrdot-item ctrdot-item-ocms">
                            <div class="ocms-fusion-atzcart-pc-ch-newarrival-floor b2b-ocms-fusion-comp">
                                <div class="ocms-fusion-atzcart-pc-ch-floor-title b2b-ocms-fusion-comp"
                                    >
                                    <span class="floor-title"><?php echo $key;?></span>
                                    <div class="floor-label"></div>
                                </div>
                                <div class="ocms-fusion-atzcart-pc-ch-newarrival-floor-wrapper offer-list row">
                                    <?php foreach($val as $product):?>
                                    <div class="offer-item col-3">
                                        <div class="bravo-normal-offer">
                                            <div class="bravo-offer-image main-section">
                                                <div class="place"></div>
                                                <a class="product-link"
                                                    target="_blank"
                                                    href="<?php echo site_url(); ?>product-details/<?php echo $product->name.'/'.$product->product_id; ?>">
                                                    <div class="img-wrapper offer-image"><img
                                                        class="inner-img"
                                                        src="<?php echo $product->media_url; ?>">
                                                    </div>
                                                </a>
                                            </div>
                                            <div class="bravo-offer-title main-section" >
                                                <a class="title-link line-count-1" target="_blank" 
                                                title="<?php echo $product->name;?>"
                                                href="<?php echo site_url(); ?>product-details/<?php echo $product->name.'/'.$product->product_id; ?>">
                                                    <?php echo $product->name;?>
                                                </a>
                                            </div>
                                            <div class="main-section">
                                                <div class="bravo-offer-price sub-section">
                                                    INR. <?php echo $product->final_price2."-".$product->final_price1;?>
                                                </div>
                                                <div class="bravo-offer-moq sub-section">MOQ: <?php echo $product->moq;?></div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php endforeach;?>
                                </div>
                            </div>
                        </div>
                        <?php endforeach;?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $this->load->view("front/common/footer"); ?>