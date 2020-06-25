<?php if (!empty($productlists)) {
    foreach ($productlists as $product):
        ?>
        <div class="product-item ripple grid-item" id="product-<?php echo $product['product_id']; ?>">
            <a class="product-detail" rel="nofollow"
               href="<?php echo base_url(); ?>product/productOverview/<?php echo $product['product_id']; ?>">
                <div class="image-wrap" style="height: 143px; width: 143px;">
                    <img alt="<?php echo $product['product_name']; ?>"
                         src="<?php echo $product['media_url']; ?>"
                         style="max-height: 143px; max-width: 143px;">
                </div>
                <div class="product-info-wrap">
                    <h3 class="product-title ">
                        <strong><?php echo $product['product_name']; ?></strong> 
                    </h3>
                    <div class="product-moq" > 
                        <strong style="color:#000;">
                            <?php 
                              if($product['offer_status']=="Active"){
                                echo "<i class='fa fa-inr'></i> " . $product['final_price1'];
                                if ($product['mrp'] != 0 && $product['mrp'] != $product['final_price1']) {
                                    echo " - <del> <i class='fa fa-inr'></i> " . $product['mrp'] . "</del>";
                                    echo " <br> <strong><span style='font-size:14px;color:green'>" . $product['discount'] . "</span></strong>";
                                } 
                              }else{
                                    echo "<i class='fa fa-inr'></i> " . $product['final_price1'];
                                    if ($product['mrp'] != 0 && $product['mrp'] != $product['final_price1']) {
                                        echo " - <del> <i class='fa fa-inr'></i> " . $product['mrp'] . "</del>";
                                        echo " <br> <strong><span style='font-size:14px;color:green'>" . $product['discount'] . "</span></strong>";
                                    } 
                              }
                            ?>
                        </strong>
                    </div>
                    <div class="product-price product-fob-wrap">

                    </div>
                    <div class="bicon-wrap">
                        <div class=""> 
                            <strong style="color:#000;">
                                <i class="fa fa-inr"></i>
                                <?php
                                 if($product['offer_status']=="Active"){
                                    echo $product['final_price1'];
                                    if ($product['mrp'] != 0 && $product['mrp'] != $product['final_price1']) {
                                        echo " - <del> <i class='fa fa-inr'></i> " . $product['mrp'] . "</del><br>";
                                        echo " <strong><span style='font-size:14px;color:green'>" . $product['discount'] . "</span></strong>";
                                    }
                                 }else{
                                     echo $product['final_price1'];
                                     if ($product['mrp'] != 0 && $product['mrp'] != $product['final_price1']) {
                                        echo " - <del> <i class='fa fa-inr'></i> " . $product['mrp'] . "</del><br>";
                                        echo " <strong><span style='font-size:14px;color:green'>" . $product['discount'] . "</span></strong>";
                                    }
                                 }
                                ?>
                            </strong>
                        </div>
<!--                        <i class="list-icons list-icon-ta"></i>
                         <div class="gs-year-wrapper">
                             <i class="list-icons list-icon-gs"></i>
                             <div class="year-num"><?php //echo date('Y') - $registers['year_of_register']; ?></div>
                         </div>-->
                        <img src="<?php echo base_url() . "assets/images/flags/png/in.png"; ?>" alt="" class="icon-country">
                        <span class="country-name"><?php echo $country['name']; ?></span>
                    </div>
                </div>
            </a>
            <div class="product-p4p ripple" >
            </div>
            <div class="list-product-p4p-wrap" data-count="1">
                Sponsored Listing
            </div>
            <div class="contact-container">
            </div>
        </div>
        <?php
        
    endforeach;
} else {
    set_status_header(204);
}?>
