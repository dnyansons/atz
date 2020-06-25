<!-- Header Start-->

<!--Header End-->
<style>
    .spanL .priceM{
        font-size:11px;
        color:#9a9a9a;
    }
    .spanL{
        border: 0px solid black; position: relative; box-sizing: border-box; display: flex; -webkit-box-orient: vertical; flex-direction: column; align-content: flex-start; flex-shrink: 0; margin-top: 6.82667px;
        margin-bottom:10px;
        padding:0px 0px;
    } 
	a{color:#333;}
    .numberoflines1{font-size:13px;}
    p.smTex{font-size:18px;}
</style>

    <div role="listSlider" class="container" style="margin-top:95px; background:#fff;">
		
        <div role="minimalUIScrollContent"  class="rax-scrollview">
            <div class="container m-0 p-0">  
			<div class="row" style="">
                      <?php foreach($products as $product): ?>
                           <div class="col-6 border border-right-0">
									  <a href="<?php echo site_url();?>product/productOverview/<?php echo $product['product_id']; ?>">
                                    <img resizemode="contain" src="<?php echo $product['media_url']; ?>"
                                         style="height:4rem; padding:10px; width:4rem;">
                                    <div class="spanL">
                                        <span numberoflines="2"
                                            style=" font-size: 11.9467px; line-height: 15.36px; color: rgb(51, 51, 51); text-overflow: ellipsis; -webkit-line-clamp: 2; overflow: hidden;"><?php echo $product['product_name']; ?>
                                        </span>
										<span class="priceM" numberoflines="1">
										MOQ:<?php echo $product['moq']; ?>
                                            <?php echo $product['units_name']; ?></span>
											<span numberoflines="1"
                                            >
                                        <span class="priceM">
                                             <?php
                                            echo '<i class="fa fa-inr"></i> '.$product['final_price'];
                                            if ($product['mrp'] != 0 && $product['mrp'] != $product['final_price']) {
                                                echo " - <i class='fa fa-inr'></i><del>" . $product['mrp'] . "</del>";
                                            }
                                            if ($product['mrp'] != 0 && $product['mrp'] != $product['final_price']) {
                                                echo "<br/>";
                                                echo "<span class='text-success'><strong>" . $product['discount'] . "% off</strong></span>";
                                            }
                                        ?>
                                        </span>
                                    </div>
									</a>
                                </div>
                                
                                <?php endforeach; ?>
                            </div>
                           <!-- <div>
                                <span>
									VIEW ALL</span>
                            </div>-->
             
            </div>
        </div><!-- empty -->
        <!-- empty -->
        <!-- empty -->

</div>
<!--footer start-->

<!-- end Of Footer-->
