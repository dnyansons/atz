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
    p.smTex{font-size:18px; font-weight:600;}
	

</style>
<div class="container m-0 p-0" style="background:#fff">
    <div role="listSlider">
        <div class="">
            <!-- end -->
            <div class="top-banner topHEad container" style="margin-top:95px;">     
                <div class="row" style="padding:0px;">
                    <div id="blogCarousel" class="carousel slide" data-ride="carousel">
                        <!-- Carousel items -->
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <div class="">
                                    <div class="">
                                        <a href="#">
                                            <img src="<?php echo base_url(); ?>assets/mobile/images/banner/ban1.jpg" alt="Image" style="max-width:100%;">
                                        </a>
                                    </div>									
                                </div>
                                <!--.row-->
                            </div>
                            <!--.item-->

                            <!--.item-->
                            <div class="carousel-item">
                                <div class="">
                                    <div class="">
                                        <a href="#">
                                            <img src="<?php echo base_url(); ?>assets/mobile/images/banner/mobile-site-baner2.png" alt="Image" style="max-width:100%;">
                                        </a>
                                    </div>

                                </div>
                                <!--.row-->
                            </div>
                            <!--.item-->		

                            <div class="carousel-item">
                                <div class="">
                                    <div class="">
                                        <a href="#">
                                            <img src="<?php echo base_url(); ?>assets/mobile/images/banner/2.jpg" alt="Image" style="max-width:100%;">
                                        </a>
                                    </div>

                                </div>
                                <!--.row-->
                            </div>
                            <!--.item-->

                        </div>
                        <!--.carousel-inner-->
                    </div>
                    <!--.Carousel-->
                </div> 
            </div> 
            <div class="m-0"> 
                <p class="text-center p-1 m-0 smTex">New Arrival</p>
                <hr class="p-0 m-0">
                <div class="container">
                    <div class="row"> 	
                        <!-- Start New Arrival-->
                        
                        <?php foreach ($newproducts as $newproduct):?>
                      
                            <div class="col-6 border border-right-0">
							  <a  class="" href="<?php echo site_url();?>product/productOverview/<?php echo $newproduct['product_id']; ?>">
                                <img src="<?php echo $newproduct['media_url']; ?>"
                                     style="height:4rem; padding:10px; width:4rem;">
                                <div class="spanL">
                                    <span numberoflines="2"
                                            style=" font-size: 11.9467px; line-height: 15.36px; color: rgb(51, 51, 51); text-overflow: ellipsis; -webkit-line-clamp: 2; overflow: hidden;">
                                        <?php echo $newproduct['product_name']; ?>
                                    </span>
                                    <span class="priceM">MOQ:<?php echo $newproduct['moq'] . '  ' .
                                        $newproduct['units_name'];
                                        ?>
                                    </span>
                                    <span class="priceM">
                                        <?php
                                        echo '<i class="fa fa-inr"></i> '.$newproduct['final_price'];
                                        if ($newproduct['mrp'] != 0 && $newproduct['mrp'] != $newproduct['final_price']) {
                                            echo " - <i class='fa fa-inr'></i><del>" . $newproduct['mrp'] . "</del>";
                                        }
//                                         echo '<i class="fa fa-inr"></i> ' . $newproduct['final_price'] . '-' .
//                                        '<del><i class="fa fa-inr"></i> ' . $newproduct['mrp']."</del>";
                                        if ($newproduct['mrp'] != 0 && $newproduct['mrp'] != $newproduct['final_price']) {
                                            echo "<br/>";
                                            echo "<span class='text-success'><strong>" . $newproduct['discount'] . "% off</strong></span>";
                                        }
                                        ?>
                                    </span>
                                </div>
								</a>
                            </div>
                        
<?php endforeach; ?>
                        <br> 
                    </div>
                </div>

                <p class="text-center p-1 m-0 smTex">Hot selling</p>
                <hr class="p-0 m-0">
                <div class="container">
                    <div class="row">       
                    <?php foreach ($hotsellings as $hotselling):     ?>
                       
                            <div class="col-6 border border-right-0">
							 <a href="<?php echo site_url();?>product/productOverview/<?php echo $hotselling['id']; ?>">
                                <img resizemode="contain"
                                     src="<?php echo $hotselling['url']; ?>"
                                     style="height:4rem; padding:10px; width:4rem;">
                                <div class="spanL">
                                    <span class="numberoflines1"><?php echo $hotselling['name']; ?></span>
                                    <span class="priceM">MOQ:
                                    <?php echo $hotselling['quantity_from']; ?> <?php echo $hotselling['units_name']; ?></span>
                                     <span class="priceM">
                                        <?php
                                            echo '<i class="fa fa-inr"></i> '.$hotselling['final_price'];
                                            if ($hotselling['mrp'] != 0 && $hotselling['mrp'] != $hotselling['final_price']) {
                                                echo " - <i class='fa fa-inr'></i> <del>" . $hotselling['mrp'] . "</del>";
                                            }
                                            if ($hotselling['mrp'] != 0 && $hotselling['mrp'] != $hotselling['final_price']) {
                                                echo "<br/>";
                                                echo "<span class='text-success'><strong>" . $hotselling['discount'] . "% off</strong></span>";
                                            }
                                        ?>
                                     </span>                  
                                </div>
				</a>
                            </div>
                       
<?php endforeach; ?>					
                    </div>
                </div>  
                <p class="text-center p-1 m-0 smTex">Recommended for You</p>
                <hr class="p-0 m-0">
                <div class="container">
                    <div class="row">  
<?php foreach ($hotsellings as $hotselling): ?>
                        
                            <div class="col-6 border border-right-0">
							<a href="<?php echo site_url();?>product/productOverview/<?php echo $hotselling['id']; ?>">
                                <img resizemode="contain"
                                     src="<?php echo $hotselling['url']; ?>"
                                     style="height:4rem; padding:10px; width:4rem;">
                                <div class="spanL">
                                    <span class="numberoflines1"><?php echo $hotselling['name']; ?></span>
                                    <span class="priceM">MOQ:
    <?php echo $hotselling['quantity_from']; ?> <?php echo $hotselling['units_name']; ?></span>
                                    <span class="priceM">
                                        <?php
                                            echo '<i class="fa fa-inr"></i> '.$hotselling['final_price'];
                                            if ($hotselling['mrp'] != 0 && $hotselling['mrp'] != $hotselling['final_price']) {
                                                echo " - <i class='fa fa-inr'></i> <del>" . $hotselling['mrp'] . "</del>";
                                            }
                                            if ($hotselling['mrp'] != 0 && $hotselling['mrp'] != $hotselling['final_price']) {
                                                echo "<br/>";
                                                echo "<span class='text-success'><strong>" . $hotselling['discount'] . "% off</strong></span>";
                                            }
                                        ?>
                                     </span> 
                                </div>
								</a>
                            </div>
                        
<?php endforeach; ?>
                        <!-- End Of Hot Selling -->
                    </div><!-- empty -->
                </div>

                <p class="text-center p-1 m-0 smTex">Top Selected</p>
                <hr class="p-0 m-0">				
                <div class="container">
                    <div class="row">  
<?php foreach ($hotsellings as $hotselling): ?>
                      
                            <div class="col-6 border border-right-0">
							  <a href="<?php echo site_url();?>product/productOverview/<?php echo $hotselling['id']; ?>">
                                <img resizemode="contain"
                                     src="<?php echo $hotselling['url']; ?>"
                                     style="height:4rem; padding:10px; width:4rem;">
                                <div class="spanL">
                                    <span class="numberoflines1"><?php echo $hotselling['name']; ?></span>
                                    <span class="priceM">MOQ:
                                <?php echo $hotselling['quantity_from']; ?> <?php echo $hotselling['units_name']; ?></span>
                                    <span class="priceM">
                                        <?php
                                            echo '<i class="fa fa-inr"></i> '.$hotselling['final_price'];
                                            if ($hotselling['mrp'] != 0 && $hotselling['mrp'] != $hotselling['final_price']) {
                                                echo " - <i class='fa fa-inr'></i> <del>" . $hotselling['mrp'] . "</del>";
                                            }
                                            if ($hotselling['mrp'] != 0 && $hotselling['mrp'] != $hotselling['final_price']) {
                                                echo "<br/>";
                                                echo "<span class='text-success'><strong>" . $hotselling['discount'] . "% off</strong></span>";
                                            }
                                        ?>
                                     </span> 
                                </div>
				</a>
                            </div>
            <?php endforeach; ?>
                        <!-- End Of Hot Selling -->
                    </div><!-- empty -->
                </div>                   


            </div>

        </div>
        <div role="padding"
             style="border: 0px solid black; position: relative; box-sizing: border-box; display: flex; -webkit-box-orient: vertical; flex-direction: column; align-content: flex-start; flex-shrink: 0; width: 320px; height: 0px;">
        </div>
    </div>
</div><!-- empty -->
<!-- empty -->
<!-- empty -->

