<div class="top-banner topHEad container" style="margin-top:95px;">  
    <div role="listSlider">
        <div>
            <div>
                <div>
                    <div tabid="cp">
                        <div  class="">
                            <div class="row">	
                                <div class="col-12">	
                                    <div>
                                        <img src="<?php echo base_url(); ?>assets/mobile/images/verified.png" width="30">
                                        <span class="" style="font-size:16px;">Supplier</span>
                                    </div><!-- empty -->

                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item">About Us</li>
                                        <li class="breadcrumb-item">Verified</li>       
                                    </ol>
                                    <div class="bg-white">
<!--                                        <div class="">
                                            <div horizontal="true" showshorizontalscrollindicator="false"
                                                 scrolleventthrottle="50" showsverticalscrollindicator="true"
                                                 class="rax-scrollview">
                                                <div  class="row">
                                                    <div class="col-3 m-1">
                                                        <img resizemode="cover"
                                                             src="<?php //echo base_url(); ?>assets/mobile/images/dummy.png"
                                                             style="" class="img-fluid"><img
                                                             resizemode="cover"
                                                             src="">
                                                    </div>

                                                    <div class="col-3 m-1">
                                                        <img resizemode="cover"
                                                             src="<?php //echo base_url(); ?>assets/mobile/images/dummy.png"
                                                             class="img-fluid">
                                                        <img resizemode="cover"  src="">
                                                    </div>

                                                    <div class="col-3 m-1">
                                                        <img resizemode="cover"
                                                             src="<?php //echo base_url(); ?>assets/mobile/images/dummy.png"
                                                             class="img-fluid"><img src="">
                                                    </div>

                                                </div>
                                            </div>
                                        </div>-->
                                        <div class="row p-1">
                                            <div class="col-12">
                                                <span class="sT float-left">Business Type:</span>
                                                <span class="sTm float-left"><?php echo $companyinfo->company_type; ?></span>
                                            </div> 

                                            <div class="col-12">
                                                <span class="sT float-left">Year Established:</span>
                                                <span class="sTm float-left"><?php echo $companyinfo->year_of_register; ?></span>
                                            </div>

                                            <div class="col-12">
                                                <span class="sT float-left" >Total Employees:</span>
                                                <span class="sTm float-left"><?php echo $companyinfo->no_of_employee; ?></span>
                                            </div>
                                            <?php if(!empty($companyinfo->annual_revenue)){?>
                                            <div class="col-12">
                                                <span class="sT float-left">Total Annual Revenue:</span>
                                                <span class="sTm float-left"><i class="fa fa-inr"></i><?php echo $companyinfo->annual_revenue; ?></span>
                                            </div>
                                            <?php } ?>

                                            <div class="col-12">
                                                <span class="sT float-left">Main Products:</span>
                                                <span class="sTm float-left">
                                                    <?php
                                                    $products = json_decode($companyinfo->main_products);
                                                    foreach ($products as $product):
                                                        ?>
                                                    </span>
                                                    <span class="sTm">
                                                        <?php echo $product; ?>
                                                    </span>
                                                    <?php endforeach;  ?>
                                            </div>	

                                            <div class="col-12">
                                                <span class="sT float-left">Operational Address:</span>

                                                <span class="sTm float-left"><?php echo $companyinfo->comp_operational_addr; ?></span>
                                            </div>

                                            <div class="col-12">
                                                <span class="sT float-left">Location:</span>
                                                <span class="sTm float-left"><?php echo $companyinfo->comp_operational_city; ?>,<?php echo $companyinfo->comp_operational_region; ?></span>
                                            </div>
                                        </div>
                                        <!-- empty -->
                                    </div>


                                    <div class="bg-white mt-2 p-1">
                                        <div> 
                                            <span class="" style="font-size:16px;">Company
                                                Description</span></div>
                                        <div>		
                                            <span class="sT">
                                                <?php echo $companyinfo->comp_advantages; ?>
                                            </span>
                                        </div>
                                        <div>
                                            <img resizemode="cover"
                                                 src=""
                                                 style="display: flex; width: 13.6533px; height: 9.38667px; object-fit: cover;">
                                        </div>
                                    </div>

									<?php if(!empty($records)){ ?>
                                   <div class="bg-white mt-2 py-2">
                                       <span class="p-1" style="font-size:16px;">Certification</span>
                                       <div  class="rax-scrollview">
                                           <div class="row">
                                               <?php foreach($records as $record): ?>
                                               <div class="col-3 m-1">
                                                   <img resizemode="cover"
                                                        src="<?php echo site_url(); ?>uploads/company_docs/<?php echo $record['file']; ?>"
                                                        class="img-fluid" ><img
                                                        resizemode="cover"
                                                        src="">
                                               </div>
                                               <?php endforeach; ?>
                                           </div>
                                       </div>
                                   </div>
                                   <?php } ?> 
								   

                                    <div class="bg-white mt-2 py-2">
                                        <div class="col-12">
                                            <span class="" style="font-size:16px;">Quality
                                                Supplier</span><span class="p-1" style="font-size:16px;">Learn
                                                More</span>
                                        </div>
                                        <div class="row mt-2">
                                            <div class="col-4 text-center">
                                                <span class="sTm d-block">
                                                    <?php echo $productinfos['response_rate']; ?></span>
                                                <span class="sT">Response Time</span>
                                            </div>

                                            <div class="col-4 text-center">
                                                <span class="sTm d-block"><?php echo $productinfos['response_time']; ?></span><span class="sT">Response Rate</span>
                                            </div>

                                            <div class="col-4 text-center">
                                                <span class="sTm d-block"><?php echo $productinfos['transactions']; ?></span>
                                                <span class="sT"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="bg-white mt-2 mb-3">
                                        <div class="col-12 py-2">
                                            <span style="font-size:16px;">Ratings &amp; Review</span>
                                            <img src=""
                                                 style="display: flex; width: 5.12px; height: 9.38667px; margin-top: 13.6533px; object-fit: cover;">
                                        </div>
                                        <div>
                                            <div class="text-center pt-1 pb-3">
                                                <div style="font-size:20px; color:red;">
                                                    <span >4.9</span><span>/5</span>
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
        </div><!-- empty -->
        <!-- empty -->
        <!-- empty -->
    </div>
</div>

