<?php 
$this->load->view("front/common/header"); 
 
    ?>
<style>
input:focus {
    background: transparent;
    border: 1px solid #4FC1F0;
}

.product-total-price {
    margin-left: 18px;
    font-size: 14px;
    font-weight: 400;
    color: #666;
    word-wrap: break-word;
    word-break: normal;
}
table{
border-collapse:collapse;
}
table td{padding:10px;}

.mark-calculator-quantity {
    font-size: 14px;
    color: #333;
	font-weight: 700;
}

.mark-calculator {
    padding-right: 2px;
    color: #bd081b;
    font-size: 16px;
    font-weight: 700;
}

.text-frame {
    height: 18px;
    line-height: 18px;
    padding: 3px 5px;
    overflow: hidden;
    white-space: nowrap;
    text-overflow: ellipsis;
    display: inline-block;
}
.sku-attr-val-frame
{
	position: relative;
    float: left;
    margin: 0 10px 10px 0;
    background-color: #fff;
    border: 1px solid #ddd;
    cursor: pointer;
	text-align: center;
}
.show-border{
	border : 1px solid orange !important;
}

.show-border-thirdspec{
	border : 1px solid orange !important;
}

.coupon-card{box-sizing:border-box;padding:14px 0 14px 14px;width:410px;height:92px;margin-bottom:13px;background:url("<?php echo base_url();?>assets/front/images/banner/coupon.svg") no-repeat}.coupon-card .card-action{display:inline-block;width:100px;height:65px;margin-left:8px;vertical-align:middle;word-break:break-word;color:#f60;text-align:center;cursor:pointer}.coupon-card .card-action .action-text{display:inline-block;position:relative;top:50%;transform:translateY(-50%)}.coupon-card .card-action-disable{opacity:.6;pointer-events:none;cursor:not-allowed}.coupon-card .card-action-negative{opacity:.6;cursor:not-allowed}.coupon-card .card-info{display:inline-block;box-sizing:border-box;width:273px;max-height:65px;vertical-align:middle;margin-right:8px}.coupon-card .card-info .card-info-title{font-family:Roboto-Bold,sans-serif;font-size:20px;color:#f60}.coupon-card .card-info .card-info-title .promotion-logo{margin-left:7px;height:20px}.coupon-card .card-info .card-info-price,.coupon-card .card-info .card-info-time{color:#666;font-size:12px;line-height:16px;overflow:hidden;white-space:nowrap;text-overflow:ellipsis;word-break:break-word}.coupon-card .card-info .card-info-price{margin-top:8px}#detail-coupon{padding-bottom:12px;background:#fff; padding-top:15px}.module-coupon{position:relative;left:1px;margin-left:18px}.module-coupon .coupon-entry-logo{display:inline-block}.module-coupon .coupon-entry{box-sizing:border-box;vertical-align:middle;display:inline-block;padding:0 8px;height:20px;line-height:20px;font-size:12px;

 no-repeat;background-size:100% 20px;cursor:pointer}.module-coupon .coupon-entry .ui2-icon{transform:scale(.5);color:#f60}.module-coupon .coupon-entry .ui2-icon:before{font-weight:700}.module-coupon .coupon-entry .coupon-entry-price{font-family:Roboto-Bold,sans-serif;color:#f66a00}.module-coupon .coupon-entry .coupon-entry-dis{color:#000;overflow:hidden;white-space:nowrap;text-overflow:ellipsis;word-break:break-word;max-width:280px;display:inline-block;vertical-align:middle;line-height:14px;height:14px}.module-coupon .coupon-entry .coupon-entry-action{border-left:1px dotted #f94d1e;display:inline-block;padding-left:5px;margin-left:5px;margin-right:3px;color:#f66a00;height:18px}.module-coupon .coupon-list-container{position:absolute;width:452px;z-index:2;border:1px solid #e8e8e8}.module-coupon .coupon-list-container .coupon-list{max-height:260px;overflow-y:auto;padding:20.5px 20.5px 0;background:#fff}.module-coupon .coupon-list-container .coupon-tip{position:absolute;top:0;left:0;right:0;bottom:0;margin:auto;background:#fff;width:306px;height:32px;line-height:32px;text-align:center;border-radius:4px;box-shadow:0 0 1px 1px rgba(0,0,0,.1);opacity:1;transition:opacity .3s}.module-coupon .coupon-list-container .coupon-tip i{margin-right:5px}.module-coupon .coupon-list-container .coupon-tip .next-icon-success{color:#1dc11d}.module-coupon .coupon-list-container .coupon-tip .next-icon-error{color:#f33}.module-coupon .coupon-list-container .coupon-tip-success{height:96px;padding:20px;box-sizing:border-box;background:#e8f9e8;text-align:left}.module-coupon .coupon-list-container .coupon-tip-success .coupon-tip-content{font-size:18px;vertical-align:middle;margin-left:10px}.module-coupon .coupon-list-container .coupon-tip-success .coupon-tip-content2{display:block;text-align:center;color:#666}.module-coupon .coupon-list-container .tip-hide{opacity:0;display:none}
._2KHWIh {
    position: relative;
    display: -webkit-flex;
    display: -ms-flexbox;
    display: flex;
    -webkit-flex-direction: column;
    -ms-flex-direction: column;
    flex-direction: column;
	margin-left:20px;
}
._2KHWIh ._29cQtz {
    -webkit-flex: none;
    -ms-flex: none;
    flex: none;
    display: -webkit-flex;
    display: -ms-flexbox;
    display: flex;
    -webkit-align-items: center;
    -ms-flex-align: center;
    align-items: center;
    width: 90px;
    margin-right: 12px;
}
._2KHWIh ._3KEg0q {
    height: 20px;
    width: 18px;
    margin-bottom: -4px;
}
._2KHWIh ._1nBnpg {
    margin-left: 8px;
}
._2KHWIh ._1nBnpg, ._2KHWIh ._3LdjIv {
    font-weight: 500;
    color: #878787;
	font-size: 14px;
}
._2KHWIh ._2FexNG {
    margin: 24px 12px;
    display: inline-block;
}
._2KHWIh .OmFqo5 {
    margin-left: 0!important;
}
._2KHWIh ._20PCkk {
    padding: 0 0 6px;
    font-size: 14px;
    border: none;
    border-bottom: 2px solid #bd081b;
    font-weight: 500;
    -webkit-align-items: center;
    -ms-flex-align: center;
    align-items: center;
    display: inline-block;
    line-height: 25px;
    outline: none;
    box-shadow: none;
    width: 160px;
}
._2KHWIh ._2m9c-p._3PnL67 {
    color: #878787;
    cursor: not-allowed;
}
._2KHWIh ._2m9c-p {
    font-weight: 500;
    cursor: pointer;
    font-size: 14px;
    color: #2874f0;
    position: relative;
    border-bottom: 2px solid #bd081b;
    padding-bottom: 11px;
}
.check{
	margin-left: 20px;
    margin-top: 5px;
}

.OmFqo5:focus {
    border-color: #bd081b;
    box-shadow: none;
    outline: none;
}

.btn.focus, .btn:focus {
    outline: 0;
     box-shadow: unset; 
}

</style>
<div class="" style="background-color:#fff;">

   <div class="details-page unite">
      <div class="content-wrap">
         <div id="container" class="page-root container-fluid">
            <div id="page-container" class="esite-page theme-black component-gap detail-content not-index"
               data-spm="deiletai6">
               <div class="content-header">
                  <div class="detail-box">
                     
                  </div>
               </div>
               <div class="content-body mt-4" id="shopping-ads">
                  <div class="main-content">
                     <div class="detail-col esite-clearfix" id="J-ls-grid-action">
                        <div class="action-sub">
                           <div class="detail-box">
                              <div class=" col">
                                 <?php
                                   
                                   $images = $product["images"];
                                   
                                    $imgCnt = count($images);
                                    if ($imgCnt) {
                                        echo $defaultImg = $images[0];
                                    }else{
                                        echo $defaultImg =  base_url('assets/images/no_imgs.jpg');
                                    }
                                    ?>								
									
                                        <div class="widget-detail-booth-image J-disable-event app-figure" id="zoom-fig">
                                                <a id="Zoom-1" class="MagicZoom" href="<?php echo $defaultImg; ?>">


    <div class="details-page unite">
        <div class="content-wrap">
            <div id="container" class="page-root container-fluid">
                <div id="page-container" class="esite-page theme-black component-gap detail-content not-index"
                    data-spm="deiletai6">
                    <div class="content-header">
                        <div class="detail-box">
                        </div>
                    </div>
                    <div class="content-body mt-4" id="shopping-ads">
                        <div class="main-content">
                            <div class="detail-col esite-clearfix" id="J-ls-grid-action">
                                <div class="action-sub">
                                    <div class="detail-box">
                                        <div class=" col">
                                            <?php
                                                $images = $product["images"];
                                                $imgCnt = count($images);
                                                if ($imgCnt) {
                                                    $defaultImg = $images[0];
                                                }else{
                                                    $defaultImg = "asdfasfd.jpg";
                                                }
                                                ?>								
                                            <div class="widget-detail-booth-image J-disable-event app-figure" id="zoom-fig">
                                                <a id="Zoom-1" class="MagicZoom" href="<?php echo $defaultImg; ?>">

                                                <img src="<?php echo $defaultImg; ?>" alt="" style="max-width:300px !important; max-height:300px !important">
                                                </a>
                                                <div class="selectors">
                                                    <ul class="piclist">
                                                        <?php foreach ($images as $img):?>
                                                        <li>
                                                            <a data-zoom-id="Zoom-1" href="<?php echo $img; ?>"
                                                                data-image="<?php echo $img; ?>">
                                                                <img srcset="<?php echo $img; ?>" src="<?php echo $img; ?> " width="100" height="100"/>
                                                            </a>					
                                                        </li>
                                                        <?php endforeach; ?>									  
                                                    </ul>
                                                </div>
                                                 <div class="favorite-corner J-sc-fav-item-wrap" id="detail-favorite-mark" >
                                                    <div class="J-scc-favorite-manager-label scc-favorite-manager-label scc-fav-label-onlyicon scc-fav-icon-bkg">
                                                        <a href="javascript:void(0)" class="add_favorite" data-product-id="<?php echo $product['id']; ?>"><?php $fav_prod = $this->session->userdata("faverite_products"); if(in_array($product['id'],$fav_prod)){ ?><i class="fa fa-heart scc-fav-i-heart-n-normal-small label-icon-mail" style="color:red;"></i><?php }else{ ?> <i class="fa fa-heart scc-fav-i-heart-n-normal-small label-icon-mail"></i><?php } ?></a>
                                                    </div>
                                                </div>
 
                                             </li>
                                             <?php } ?>
                                          </ul>
                                       </div>
									   
									    <?php if($coupons){ 
										reset($coupons);
										$first_key = key($coupons); ?>
									   	<!--coupan code--->	   
										<div class="detail-coupon" id="detail-coupon" data-widget-cid="widget-4">
											<div class="module-coupon">
												<div class="coupon-entry" id="coupon">
												  <span class="coupon-entry-price">
														<!-- react-text: 4 --><?php echo $coupons[$first_key]->coupon_value; ?> % OFF
														<!-- /react-text -->
														<!-- react-text: 5 -->
														<!-- /react-text --></span>
														
												<span class="coupon-entry-dis" title="">Product value more than MOQ <?php echo $coupons[$first_key]->moq; ?>, Capped at 
													</span>
													<span class="coupon-entry-action"
														data-spm-anchor-id="a2700.wholesale.maonnacta.i0.585e6579CoPaV9">Get Coupon</span>
														<i class="ui2-icon icon ion-ios-arrow-down"></i>
														
														</div>
												
												
												<div class="coupon-list-container " id="coupon-container">
													<ul class="coupon-list tip-hide">
													<?php $i=0; foreach($coupons as $row) { $i++; ?>
														<li class="coupon-card">
															<div class="card-info">
																<div class="card-info-title"><span title="<?php echo $row->coupon_value; ?> OFF"><?php echo $row->coupon_value; ?>% OFF</span><!-- react-text: 266 -->
																	<!-- /react-text -->
																</div>
																 <div class="card-info-price">
																 Product value more than MOQ <?php echo $row->moq; ?>, Capped at US $100
																</div>
																<div class="card-info-time">
																<?php 
																	$from_date = date("d/m/Y", strtotime($row->valid_from));
																	$to_date = date("d/m/Y", strtotime($row->valid_to));
																echo $from_date; ?> - <?php echo $to_date; ?> PDT
																</div>
															</div>
															<div class="card-action" title="Get Coupon">
																<div class="action-text" id="_<?php echo $i; ?>" onclick = "getCoupons('<?php echo $row->moq; ?>','<?php echo $row->coupon_value; ?>','<?php echo $row->coupon_uniqe_id; ?>', this.id)">Get Coupon</div>
															</div>
														</li>
													<?php  } ?>
													</ul>
													<div class="coupon-tip tip-hide"><i class="next-icon next-icon-error next-icon-small"></i>
														<!-- react-text: 282 -->
														<!-- /react-text -->
													</div>
												</div>
												
											</div>
										</div>
										<?php } ?>
										
										<?php if($product_specification) { ?>
                                       <div class="ma-brief-list ma-main-brief-list">
                                          <div id="skuWrap" class="sku-wrap">
                                             <dl id="item-span" class="sku-attr-dl util-clearfix IMAGE">
											 
												<?php 

												$count = count($product_specification);
												$i = 0;												
												if($count==1){ 
												foreach($product_specification as $key => $spec){

												?>
													<dt class="name" title="Color"><?php echo $key; ?>:</dt>
													<input type="hidden" class="class_Type" value="<?php echo $count; ?>">	
													<dd  class="sku-attr-val value util-clearfix">
													<?php foreach($spec as $value){ $i++; 
														 $title = str_replace('.','_',$value['spec_value']); 
														 $url_title = str_replace(' ','_',$title); 
													?>
														
														<span class="text-frame sku-attr-val-frame"  style="width:50px" title="<?php echo $value['spec_value']; ?>" id= "currentItem_<?php echo $i; ?>" onclick ="addProductToCart(this.id, '<?php echo $value['spec_value']; ?>','<?php echo $key; ?>', true)" 
														 ><?php echo $value['spec_value']; ?></span>
														 
														<div class="pb-10" >
															<input type="button" value="-" onclick="minusValue('<?php echo $url_title; ?>',this,'<?php echo $key; ?>', true,'<?php echo $i; ?>')" class="minus"  id="minus" > 
															<input type="number" id= "currentItem_<?php echo $url_title; ?>" onkeyup="addItemsWithSize('<?php echo $url_title; ?>',this,'<?php echo $key; ?>','', true, '0')" value="0" title="Qty" class="qty size-text-field" size="4"> 
															<input type="button" onclick="plusValue('<?php echo $url_title; ?>',this,'<?php echo $key; ?>', true, '<?php echo $i; ?>')" value="+" class="plus" id="plus" >
														</div>
													<?php } ?>
													</dd>
												<?php } 
												} elseif($count==2) {
												 $j=0; foreach($product_specification as $key => $spec){
												?>
													<dt class="name" title="Color"><?php echo $key; ?>:</dt>
													<input type="hidden" class="class_Type" value="<?php echo $count; ?>">
													<dd class="sku-attr-val value util-clearfix">
													<?php foreach($spec as $value){	$i++; 
														 $title = str_replace('.','_',$value['spec_value']); 
														 $spec_under = str_replace(' ','_',$title); 
													?>
													   <?php if($j==0){?>
														<span class="text-frame sku-attr-val-frame" id= "currentItem_<?php echo $i; ?>" onclick ="addProductToCart(this.id, '<?php echo $value['spec_value']; ?>','<?php echo $key; ?>')" 
														 ><?php echo $value['spec_value']; ?></span>
														
													   <?php } else { ?>
													   <div class="input-group pb-10">
														<div style="width:50px" class="mr-10" title="<?php echo $value['spec_value']; ?>" ><?php echo $value['spec_value']; ?></div>
														<div>
															<input type="button" value="-" onclick="minusValue('<?php echo $spec_under; ?>',this,'<?php echo $key; ?>')" class="minus"  id="minus" > 
															<input type="number" id= "currentItem_<?php echo $spec_under; ?>" onkeyup="addItemsWithSize('<?php echo $spec_under; ?>',this,'<?php echo $key; ?>','','','<?php $i; ?>')" value="0" title="Qty" class="qty size-text-field"
															   size="4"> 
															 <input type="button" onclick="plusValue('<?php echo $spec_under; ?>',this,'<?php echo $key; ?>')" value="+" class="plus" id="plus" >
														</div>
													  </div>
													   <?php } }$j++; ?>
													</dd>
														<?php } 
												} else if($count > 2){ 
												  $j =0; foreach($product_specification as $key => $spec){
												?>
													<dt class="name" title="Color"><?php echo $key; ?>:</dt>
													<input type="hidden" class="class_Type" value="<?php echo $count; ?>">
														
														<dd class="sku-attr-val value util-clearfix">
														<?php foreach($spec as $value){ $i++; 
															$title = str_replace('.','_',$value['spec_value']); 
															$url_title = str_replace(' ','_',$title); 
														?>
														   <?php if($j==0){?>
															<span class="text-frame sku-attr-val-frame" id= "currentItem_<?php echo $i; ?>" onclick ="addProductToCart(this.id, '<?php echo $value['spec_value']; ?>','<?php echo $key; ?>')" 
															 ><?php echo $value['spec_value']; ?></span>
														   <?php } if($j==1){ ?>
														   <div class="input-group pb-10">
																<div style="width:50px" class="mr-10" title="<?php echo $value['spec_value']; ?>"><?php echo $value['spec_value']; ?></div>
																<div>
																	<input type="button" value="-" onclick="minusValue('<?php echo $url_title; ?>',this,'<?php echo $key; ?>')" class="minus"  id="minus" > 
																	<input type="number" id= "currentItem_<?php echo $url_title; ?>" onkeyup="addItemsWithSize('<?php echo $url_title; ?>',this,'<?php echo $key; ?>','','','<?php echo $i; ?>')" value="0" title="Qty" class="qty size-text-field"
																	   size="4"> 
																	<input type="button" onclick="plusValue('<?php echo $url_title; ?>',this,'<?php echo $key; ?>')" value="+" class="plus" id="plus" >
																</div>
															</div>
																   
														   <?php } if($j>1){?>
																<span class="text-frame sku-attr-val-frame" id= "currentItem_<?php echo $i; ?>" onclick ="thirdSpec(this.id, '<?php echo $value['spec_value']; ?>','<?php echo $key; ?>')" 
																><?php echo $value['spec_value']; ?></span>
														<?php } } ?>
														</dd>
												 </br> <?php $j++;} } ?>
												
                                             </dl>
											 
                                          </div>
                                       </div>
										<?php }else{

                     ?>
									   	
              <div class="ma-brief-list ma-main-brief-list">
											<div id="skuWrap" class="sku-wrap">
												<dl class="sku-attr-dl util-clearfix IMAGE">
													<dt class="name" title="Color">Quantity:</dt>
													<input type="hidden" class="class_Type" value="0">
													<dd class="sku-attr-val value util-clearfix">
														<div class="quantity">
															<input type="button" value="-" class="minus"  id="minusNoSpec" onclick="valueForNoSpecification('counterNoSpec', 'minus')">
															<input type="number" value="" title="Qty" class="qty"
																size="4" id="counterNoSpec" onkeyup="valueForNoSpecification('counterNoSpec', 'keyup')">
															<input type="button" value="+" class="plus" id="plusNoSpec" onclick="valueForNoSpecification('counterNoSpec', 'plus')">
														</div>
													</dd>
												</dl>
											</div>
										</div>
										  
										<?php } ?>
										
										  <div class="ma-brief-list ma-main-brief-list" id="details">
												<div id="skuWrap" class="sku-wrap">
													<div class="product-total-price" >
														<span class="mark-calculator-quantity" id="qnty"> 1 </span> 
                            <span class="mark-calculator-quantity" >
                              <?php echo $product_prices[0]['units_name']; ?>
                                
                              </span> selected
														<br>
														<span class="mark-calculator">
                                                                                                                    <i class="fa fa-inr"></i>.&nbsp; <span id="price_count"><?php echo $product_prices[0]['final_price']; ?></span>
														</span>in total
														<button type="button" id="modelDetails" class="btn btn-info btn-sm pull-right" data-toggle="modal" data-target="#myModal" style="margin-top: -15px;">view Details </button>
													</div>
												</div>
											</div>
										
                                       </div>
									   </br>
                                    </div>
                                   <div class="ma-operate">
										<div class="ma-main-operate">
											<a id="start_order" href="javascript:void(0)" data-productimage="<?php echo $defaultImg; ?>" data-productname = "<?php echo $product['name']; ?>" data-product-id="<?php echo $product['id']; ?>" data-supplierDetails = "<?php echo $product['first_name']; ?> <?php echo $product['last_name']; ?>  <?php echo $product['company_name']; ?>" data-sellername="<?php echo $product['first_name']; ?> <?php echo $product['last_name']; ?>" data-companyname="<?php echo $product['company_name']; ?>" data-address="<?php echo $product['address1']; ?>" data-businesstype="<?php echo $product['business_type']; ?>" data-countryname="<?php echo $product['cntry']; ?>" data-email="<?php echo $product['email']; ?>" data-phone="<?php echo $product['phone']; ?>" data-seller-id = "<?php echo $product['seller']; ?>"> 
                        <button id="J-btn-order" class="ui2-button ui2-button-primary ui2-button-large placeorder dot-app-pd ui-button-buy ">								
											Start Order
											</button>
                    </a>
											<a href="<?php echo base_url(); ?>product-inquiry/<?php echo $product['id']; ?>"> <button id="J-btn-order" class="ui2-button ui2-button-primary ui2-button-large placeorder dot-app-pd ui-button-buy ">								
											Contact Supplier
											</button></a>
											<?php if ($product['provide_order_at_buyer_place'] == 1) { ?>
											<a href="javascript:void(0)" data-productimage="<?php echo $defaultImg; ?>" data-productname = "<?php echo $product['name']; ?>" data-product-id="<?php echo $product['id']; ?>" data-supplierDetails = "<?php echo $product['first_name']; ?><?php echo $product['last_name']; ?>  <?php echo $product['company_name']; ?>" data-seller-id = "<?php echo $product['seller']; ?>"  id="add_to_cart"> <button id="J-btn-order" class="ui2-button ui2-button-primary ui2-button-large placeorder dot-app-pd ui-button-buy my-btn ">								
											Add to Cart
											</button></a>
											<?php } ?>
										</div>
                                    </div>
                              
                                 </div>
                              </div>
                              <div data-module="detailTradeAssuranceEdu">
                                 <div data-reactroot="" class="details-assurance-educate" data-spm="taedu">
                                    <div class="ma-brief-list">
                                       <dl class="ma-brief-item">
                                          <dt class="ma-brief-item-key" title="Seller Support:">Seller Support:
                                          </dt>
                                          <dd class="ma-brief-item-val">
                                             <div>
                                                <a target="_blank" rel="noopener noreferrer"
                                                   href="<?php echo base_url(); ?>trade-assurance"><i
                                                   class="icon-trade-assurance"></i><span>Trade
                                                Assurance</span><span
                                                   style="font-size: 12px; color: rgb(170, 170, 170);">– To
                                                protect your orders from payment to delivery</span></a>
                                             </div>
											  </br>
											  <div style="color:red; font-weight:bold" id="display_error"></div>
                                          </dd>
                                       </dl>
            										<div class="_2KHWIh"><div class="_29cQtz">
            											<img src="<?php echo base_url(); ?>assets/images/location.png" class="_3KEg0q"><span class="_1nBnpg">Deliver to</span></div>
            											<div class="_2FexNG OmFqo5">
            											<input type="text" name = "pincode" id="pincode" placeholder="Enter delivery pincode" value="" maxlength="6" autocomplete="off" class="_20PCkk" onkeypress="return restrictAlphabets(event)">
            											<button class="btn btn-danger btn-sm check" id="Checkpincode" >Check</button></div>
            											<div id="areacode"></div>
            									  </div>
                                    </div>
                                 </div>
                              </div>
                              <div data-module="logistics"></div>
                           </div>
                        </div>
                     </div>
                     <!----------------------------------->				
                     <div class="details-info" id="J-ls-grid-desc">
                        <div id="detail-banner-below"></div>
                        <div class="detail-box box-type-detailTab" data-module="detailTab">
                           <div data-reactroot="" class="details-tab-wrapper" data-spm="tabs" style="height: auto;">
                              <div></div>
                              <div class="tab-main" style="width: auto;">
                                 <div class="next-tabs next-tabs-wrapped next-tabs-medium next-tabs-top">
                                    <div role="tablist" class="next-tabs-bar" tabindex="0">
                                       <div class="next-tabs-nav-container">
                                          <div class="next-tabs-nav-wrap">
                                             <div class="next-tabs-nav-scroll">
                                                <div class="next-tabs-nav" style="transform: translate3d(0px, 0px, 0px);">
                                                   <div role="tab" aria-disabled="false" aria-selected="true"
                                                      class="next-tabs-tab  active" data-tag="one">
                                                      <div class="next-tabs-tab-inner" style="font-weight: bold;">
                                                         <a class="tab-name" title="Product Details">Product  Details</a>
                                                      </div>
                                                   </div>
                                                   <div role="tab" aria-disabled="false" aria-selected="false"
                                                      class="next-tabs-tab " data-tag="two">
                                                      <div class="next-tabs-tab-inner" style="font-weight: bold;">
                                                         <a class="tab-name" title="Company Profile">Company Profile</a>
                                                      </div>
                                                   </div>
 
                                            </div>
                                        </div>
                                        <div data-module="shareSns">
                                            <div data-reactroot="" class="details-user-actions" data-spm="share">
                                                <span
                                                    class="ua-item action-item share-sns">
                                                    <i class="next-icon next-icon-share next-icon-small"></i>
                                                    Share
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="action-main">
                                    <div class="detail-box">
                                        <div class="scc-wrapper detail-module module-mainAction" data-spm="maonnacta">
                                            <div class="widget-main-action widget-main-action-ws"
                                                data-role="widget-main-action">
                                                <div class="ma-title-wrap">
                                                    <span class="ma-title" title="<?php echo $product['name']; ?>" style="font-size:18px">
                                                    <?php echo $product['name']; ?>
                                                    </span>
 
                                                </div>
                                                <div class="ma-main">
                                                    <div class="promotion-banner" id="detail-banner"></div>
                                                    <div class="ma-price-wrap">
                                                        <ul id="ladderPrice"
                                                            class="ma-ladder-price ma-ladder-price-count-4 util-clearfix">
                                                            <?php foreach($product_prices as $prices){ ?>
                                                            <li data-role="ladder-price-item"
                                                                class="ma-ladder-price-item   ladder-price-1 util-clearfix current-ladder-price">
                                                                <div class="ma-quantity-range" title="1-99 Boxes">
                                                                    <?php echo $prices['quantity_from']. '-' .$prices['quantity_upto']; echo '&nbsp;'.$prices['units_name']; ?>
                                                                </div>
                                                                <div class="ma-spec-price ma-price-promotion">
                                                                    <span class="priceVal"
                                                                        title="US$&nbsp;3.50"><i class="fa fa-inr"></i>&nbsp;<?php echo $prices['final_price']; ?></span>
                                                                </div>
                                                            </li>
                                                            <?php } ?>
                                                        </ul>
                                                    </div>
                                                    <?php if($coupons){ 
                                                        reset($coupons);
                                                        $first_key = key($coupons); ?>
                                                    <!--coupan code--->	   
                                                    <div class="detail-coupon" id="detail-coupon" data-widget-cid="widget-4">
                                                        <div class="module-coupon">
                                                            <div class="coupon-entry" id="coupon">
                                                                <span class="coupon-entry-price">
                                                                    <?php echo $coupons[$first_key]->coupon_value; ?> % OFF
                                                                </span>
                                                                <span class="coupon-entry-dis" title="">Product value more than MOQ <?php echo $coupons[$first_key]->moq; ?>, Capped at 
                                                                </span>
                                                                <span class="coupon-entry-action"
                                                                    data-spm-anchor-id="a2700.wholesale.maonnacta.i0.585e6579CoPaV9">Get Coupon</span>
                                                                <i class="ui2-icon icon ion-ios-arrow-down"></i>
                                                            </div>
                                                            <div class="coupon-list-container " id="coupon-container">
                                                                <ul class="coupon-list tip-hide">
                                                                    <?php $i=0; foreach($coupons as $row) { $i++; ?>
                                                                    <li class="coupon-card">
                                                                        <div class="card-info">
                                                                            <div class="card-info-title">
                                                                                <span title="<?php echo $row->coupon_value; ?> OFF"><?php echo $row->coupon_value; ?>% OFF</span>
                                                                            </div>
                                                                            <div class="card-info-price">
                                                                                Product value more than MOQ <?php echo $row->moq; ?>, Capped at US $100
                                                                            </div>
                                                                            <div class="card-info-time">
                                                                                <?php 
                                                                                    $from_date = date("d/m/Y", strtotime($row->valid_from));
                                                                                    $to_date = date("d/m/Y", strtotime($row->valid_to));
                                                                                    echo $from_date; ?> - <?php echo $to_date; ?> PDT
                                                                            </div>
                                                                        </div>
                                                                        <div class="card-action" title="Get Coupon">
                                                                            <div class="action-text" id="_<?php echo $i; ?>" onclick = "getCoupons('<?php echo $row->moq; ?>','<?php echo $row->coupon_value; ?>','<?php echo $row->coupon_uniqe_id; ?>', this.id)">Get Coupon</div>
                                                                        </div>
                                                                    </li>
                                                                    <?php  } ?>
                                                                </ul>
                                                                <div class="coupon-tip tip-hide">
                                                                    <i class="next-icon next-icon-error next-icon-small"></i>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <?php } ?>
                                                    <?php if($product_specification) { ?>
                                                    <div class="ma-brief-list ma-main-brief-list">
                                                        <div id="skuWrap" class="sku-wrap">
                                                            <dl id="item-span" class="sku-attr-dl util-clearfix IMAGE">
                                                                <?php 
                                                                    $count = count($product_specification);
                                                                    $i = 0;												
                                                                    if($count==1){ 
                                                                    foreach($product_specification as $key => $spec){
                                                                    ?>
                                                                <dt class="name" title="Color"><?php echo $key; ?>:</dt>
                                                                <input type="hidden" class="class_Type" value="<?php echo $count; ?>">	
                                                                <dd  class="sku-attr-val value util-clearfix">
                                                                    <?php foreach($spec as $value){ $i++; 
                                                                        $title = str_replace('.','_',$value['spec_value']); 
                                                                        $url_title = str_replace(' ','_',$title); 
                                                                        ?>
                                                                    <span class="text-frame sku-attr-val-frame"  style="width:50px" title="<?php echo $value['spec_value']; ?>" id= "currentItem_<?php echo $i; ?>" onclick ="addProductToCart(this.id, '<?php echo $value['spec_value']; ?>','<?php echo $key; ?>', true)" 
                                                                        ><?php echo $value['spec_value']; ?></span>
                                                                    <div class="pb-10" >
                                                                        <input type="button" value="-" onclick="minusValue('<?php echo $url_title; ?>',this,'<?php echo $key; ?>', true,'<?php echo $i; ?>')" class="minus"  id="minus" > 
                                                                        <input type="number" id= "currentItem_<?php echo $url_title; ?>" onkeyup="addItemsWithSize('<?php echo $url_title; ?>',this,'<?php echo $key; ?>','', true, '0')" value="0" title="Qty" class="qty size-text-field" size="4"> 
                                                                        <input type="button" onclick="plusValue('<?php echo $url_title; ?>',this,'<?php echo $key; ?>', true, '<?php echo $i; ?>')" value="+" class="plus" id="plus" >
                                                                    </div>
                                                                    <?php } ?>
                                                                </dd>
                                                                <?php } 
                                                                    } elseif($count==2) {
                                                                     $j=0; foreach($product_specification as $key => $spec){
                                                                    ?>
                                                                <dt class="name" title="Color"><?php echo $key; ?>:</dt>
                                                                <input type="hidden" class="class_Type" value="<?php echo $count; ?>">
                                                                <dd class="sku-attr-val value util-clearfix">
                                                                    <?php foreach($spec as $value){	$i++; 
                                                                        $title = str_replace('.','_',$value['spec_value']); 
                                                                        $spec_under = str_replace(' ','_',$title); 
                                                                        ?>
                                                                    <?php if($j==0){?>
                                                                    <span class="text-frame sku-attr-val-frame" id= "currentItem_<?php echo $i; ?>" onclick ="addProductToCart(this.id, '<?php echo $value['spec_value']; ?>','<?php echo $key; ?>')" 
                                                                        ><?php echo $value['spec_value']; ?></span>
                                                                    <?php } else { ?>
                                                                    <div class="input-group pb-10">
                                                                        <div style="width:50px" class="mr-10" title="<?php echo $value['spec_value']; ?>" ><?php echo $value['spec_value']; ?></div>
                                                                        <div>
                                                                            <input type="button" value="-" onclick="minusValue('<?php echo $spec_under; ?>',this,'<?php echo $key; ?>')" class="minus"  id="minus" > 
                                                                            <input type="number" id= "currentItem_<?php echo $spec_under; ?>" onkeyup="addItemsWithSize('<?php echo $spec_under; ?>',this,'<?php echo $key; ?>','','','<?php $i; ?>')" value="0" title="Qty" class="qty size-text-field"
                                                                                size="4"> 
                                                                            <input type="button" onclick="plusValue('<?php echo $spec_under; ?>',this,'<?php echo $key; ?>')" value="+" class="plus" id="plus" >
                                                                        </div>
                                                                    </div>
                                                                    <?php } }$j++; ?>
                                                                </dd>
                                                                <?php } 
                                                                    } else if($count > 2){ 
                                                                      $j =0; foreach($product_specification as $key => $spec){
                                                                    ?>
                                                                <dt class="name" title="Color"><?php echo $key; ?>:</dt>
                                                                <input type="hidden" class="class_Type" value="<?php echo $count; ?>">
                                                                <dd class="sku-attr-val value util-clearfix">
                                                                    <?php foreach($spec as $value){ $i++; 
                                                                        $title = str_replace('.','_',$value['spec_value']); 
                                                                        $url_title = str_replace(' ','_',$title); 
                                                                        ?>
                                                                    <?php if($j==0){?>
                                                                    <span class="text-frame sku-attr-val-frame" id= "currentItem_<?php echo $i; ?>" onclick ="addProductToCart(this.id, '<?php echo $value['spec_value']; ?>','<?php echo $key; ?>')" 
                                                                        ><?php echo $value['spec_value']; ?></span>
                                                                    <?php } if($j==1){ ?>
                                                                    <div class="input-group pb-10">
                                                                        <div style="width:50px" class="mr-10" title="<?php echo $value['spec_value']; ?>"><?php echo $value['spec_value']; ?></div>
                                                                        <div>
                                                                            <input type="button" value="-" onclick="minusValue('<?php echo $url_title; ?>',this,'<?php echo $key; ?>')" class="minus"  id="minus" > 
                                                                            <input type="number" id= "currentItem_<?php echo $url_title; ?>" onkeyup="addItemsWithSize('<?php echo $url_title; ?>',this,'<?php echo $key; ?>','','','<?php echo $i; ?>')" value="0" title="Qty" class="qty size-text-field"
                                                                                size="4"> 
                                                                            <input type="button" onclick="plusValue('<?php echo $url_title; ?>',this,'<?php echo $key; ?>')" value="+" class="plus" id="plus" >
                                                                        </div>
                                                                    </div>
                                                                    <?php } if($j>1){?>
                                                                    <span class="text-frame sku-attr-val-frame" id= "currentItem_<?php echo $i; ?>" onclick ="thirdSpec(this.id, '<?php echo $value['spec_value']; ?>','<?php echo $key; ?>')" 
                                                                        ><?php echo $value['spec_value']; ?></span>
                                                                    <?php } } ?>
                                                                </dd>
                                                                </br> <?php $j++;} } ?>
                                                            </dl>
                                                        </div>
                                                    </div>
                                                    <?php }else{ ?>
                                                    <div class="ma-brief-list ma-main-brief-list">
                                                        <div id="skuWrap" class="sku-wrap">
                                                            <dl class="sku-attr-dl util-clearfix IMAGE">
                                                                <dt class="name" title="Color">Quantity:</dt>
                                                                <input type="hidden" class="class_Type" value="0">
                                                                <dd class="sku-attr-val value util-clearfix">
                                                                    <div class="quantity">
                                                                        <input type="button" value="-" class="minus"  id="minusNoSpec" onclick="valueForNoSpecification('counterNoSpec', 'minus')">
                                                                        <input type="number" value="0" title="Qty" class="qty"
                                                                            size="4" id="counterNoSpec" onkeyup="valueForNoSpecification('counterNoSpec', 'keyup')">
                                                                        <input type="button" value="+" class="plus" id="plusNoSpec" onclick="valueForNoSpecification('counterNoSpec', 'plus')">
                                                                    </div>
                                                                </dd>
                                                            </dl>
                                                        </div>
                                                    </div>
                                                    <?php } ?>
                                                    <div class="ma-brief-list ma-main-brief-list" id="details">
                                                        <div id="skuWrap" class="sku-wrap">
                                                            <div class="product-total-price" >
                                                                <span class="mark-calculator-quantity" id="qnty"> 1 </span> <span class="mark-calculator-quantity" ><?php echo $product_prices[0]['units_name']; ?></span> selected
                                                                <br>
                                                                <span class="mark-calculator">
                                                                <i class="fa fa-inr"></i>&nbsp; <span id="price_count"><?php echo $product_prices[0]['final_price']; ?></span>
                                                                </span>in total
                                                                <button type="button" id="modelDetails" class="btn btn-info btn-sm pull-right" data-toggle="modal" data-target="#myModal" style="margin-top: -15px;">view Details </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                </br>
                                            </div>
                                            <div class="ma-operate">
                                                <div class="ma-main-operate">
                                                    <?php if($product["available_quantity"] <= 0) {   ?>
                                                    <?php echo "<span style='margin-left:20px;font-weight:bold' class='text-danger'>Out Of Stock</span>";?>
                                                    <?php } else { ?>  
                                                    <a id="start_order" href="javascript:void(0)" data-productimage="<?php echo $defaultImg; ?>" data-productname = "<?php echo $product['name']; ?>" data-product-id="<?php echo $product['id']; ?>" data-supplierDetails = "<?php echo $product['first_name']; ?> <?php echo $product['last_name']; ?>  <?php echo $product['company_name']; ?>" data-sellername="<?php echo $product['first_name']; ?> <?php echo $product['last_name']; ?>" data-companyname="<?php echo $product['company_name']; ?>" data-businesstype="<?php echo $product['business_type']; ?>" data-countryname="<?php echo $product['cntry']; ?>" data-seller-id = "<?php echo $product['seller']; ?>"> 
                                                    <button id="J-btn-order" class="ui2-button ui2-button-primary ui2-button-large placeorder dot-app-pd ui-button-buy ">								
                                                    Start Order
                                                    </button>
                                                    </a>
                                                    <a href="<?php echo base_url(); ?>product-inquiry/<?php echo $product['id']; ?>"> <button id="J-btn-order" class="ui2-button ui2-button-primary ui2-button-large placeorder dot-app-pd ui-button-buy ">								
                                                    Contact Supplier
                                                    </button></a>
                                                    <?php if ($product['provide_order_at_buyer_place'] == 1) { ?>
                                                    <a href="javascript:void(0)" data-productimage="<?php echo $defaultImg; ?>" data-productname = "<?php echo $product['name']; ?>" data-product-id="<?php echo $product['id']; ?>" data-supplierDetails = "<?php echo $product['first_name']; ?><?php echo $product['last_name']; ?>  <?php echo $product['company_name']; ?>" data-seller-id = "<?php echo $product['seller']; ?>"  id="add_to_cart"> <button id="J-btn-order" class="ui2-button ui2-button-primary ui2-button-large placeorder dot-app-pd ui-button-buy my-btn ">								
                                                    Add to Cart
                                                    </button></a>
                                                    <?php } ?>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div data-module="detailTradeAssuranceEdu">
                                        <div data-reactroot="" class="details-assurance-educate" data-spm="taedu">
                                            <div class="ma-brief-list">
                                                <dl class="ma-brief-item">
                                                    <dt class="ma-brief-item-key" title="Seller Support:">Seller Support:
                                                    </dt>
                                                    <dd class="ma-brief-item-val">
                                                        <div>
                                                            <a target="_blank" rel="noopener noreferrer"
                                                                href="<?php echo base_url(); ?>trade-assurance"><i
                                                                class="icon-trade-assurance"></i><span>Trade
                                                            Assurance</span><span
                                                                style="font-size: 12px; color: rgb(170, 170, 170);">– To
                                                            protect your orders from payment to delivery</span></a>
                                                        </div>
                                                        </br>
                                                        <div style="color:red; font-weight:bold" id="display_error"></div>
                                                    </dd>
                                                </dl>
                                                <div class="_2KHWIh">
                                                    <div class="_29cQtz">
                                                        <img src="<?php echo base_url(); ?>assets/images/location.png" class="_3KEg0q"><span class="_1nBnpg">Deliver to</span>
                                                    </div>
                                                    <div class="_2FexNG OmFqo5">
                                                        <input type="text" name = "pincode" id="pincode" placeholder="Enter delivery pincode" value="" maxlength="6" autocomplete="off" class="_20PCkk" onkeypress="return restrictAlphabets(event)">
                                                        <button class="btn btn-danger btn-sm check" id="Checkpincode" >Check</button>
                                                    </div>
                                                    <div id="areacode"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div data-module="logistics"></div>
                                </div>
                            </div>
                       
                        <!----------------------------------->				
                        <div class="details-info" id="J-ls-grid-desc">
                            <div id="detail-banner-below"></div>
                            <div class="detail-box box-type-detailTab" data-module="detailTab">
                                <div data-reactroot="" class="details-tab-wrapper" data-spm="tabs" style="height: auto;">
                                    <div></div>
                                    <div class="tab-main" style="width: auto;">
                                        <div class="next-tabs next-tabs-wrapped next-tabs-medium next-tabs-top">
                                            <div role="tablist" class="next-tabs-bar" tabindex="0">
                                                <div class="next-tabs-nav-container">
                                                    <div class="next-tabs-nav-wrap">
                                                        <div class="next-tabs-nav-scroll">
                                                            <div class="next-tabs-nav" style="transform: translate3d(0px, 0px, 0px);">
                                                                <div role="tab" aria-disabled="false" aria-selected="true"
                                                                    class="next-tabs-tab  active" data-tag="one">
                                                                    <div class="next-tabs-tab-inner" style="font-weight: bold;">
                                                                        <a class="tab-name" title="Product Details">Product  Details</a>
                                                                    </div>
                                                                </div>
                                                                <div role="tab" aria-disabled="false" aria-selected="false"
                                                                    class="next-tabs-tab " data-tag="two">
                                                                    <div class="next-tabs-tab-inner" style="font-weight: bold;">
                                                                        <a class="tab-name" title="Company Profile">Company Profile</a>
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
                            <div class="tab-body" data-role="detail-tab-body">
                                <div class="tab-body-pane ls-icon ls-product show " id="one">
                                    <div class="ls-icon">
                                        <div class="detail-box">
                                            <div class="scc-wrapper detail-module module-cspu" data-module="cspu">
                                                <!-- react-empty: 1 -->
                                            </div>
                                            <div class="scc-wrapper detail-module module-productPackagingAndQuickDetail" data-spm="prilinga1e">
                                                <div class="widget-detail-overview">
                                                    <div class="do-content">
                                                        <div class="do-overview">
                                                            <div class="do-entry do-entry-separate">
                                                                <div class="do-entry-title" style="text-indent:20px; font-size: 18px;">Quick Details</div>
                                                                <?php foreach ($products_attribute as $row) { ?>
                                                                <div class="do-entry-list">
                                                                    <dl class="do-entry-item">
                                                                        <dt class="do-entry-item">
                                                                            <span class="attr-name J-attr-name" title="Type"><?php echo $row['attribute_name']; ?>:</span>
                                                                        </dt>
                                                                        <dd class="do-entry-item-val">
                                                                            <div class="ellipsis" title="Dry Iron"><?php echo $row['attribute_value']; ?></div>
                                                                        </dd>
                                                                    </dl>
                                                                </div>
                                                                <?php } ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="scc-wrapper detail-module module-detailVideo" data-spm="detailvideo">
                                            </div>
                                            <div class="scc-wrapper detail-module module-productSpecification" data-spm="pronpeci14">
                                                <!--false | 377944411-->
                                                <style type="text/css">
                                                    .richtext [data-maya] {
                                                    width: 750px;
                                                    font-size: 14px;
                                                    }
                                                </style>
                                                <div id="J-rich-text-description" class="richtext richtext-detail rich-text-description">
                                                    <p><span style="font-size: 18px;"><strong><?php echo $product['name']; ?>
                                                        </strong></span>
                                                    </p>
                                                    <p>&nbsp;</p>
                                                    <p><span style="font-size: 18px;"><strong style="color:#000000;"><?php echo $product['description']; ?>
                                                        </strong></span>
                                                    </p>
                                                    <p>&nbsp;</p>
                                                    <p>
                                                    </p>
                                                    <p>&nbsp;</p>
                                                </div>
                                            </div>
                                            <div data-module="detailMarketPackage"></div>
                                            <div data-module="productAuth"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-body-pane ls-icon ls-company" id="two">
                                    <div class="alisite" data-module="alisite" data-scene="companyProfile"
                                        data-spm-anchor-id="a2700.details.deiletai6.i0.733c5af2m9uRMr">
                                        <div class="J_module" module-name="icbu-pc-cpCompanyOverview" module-title="cpCompanyOverview">
                                            <div data-reactroot="" class="icbu-mod-wrapper with-round no-title icbu-pc-cpCompanyOverview v2">
                                                <div class="wrap-box">
                                                    <div class="mod-content">
                                                        <div class="company-images hoz">
                                                            <div class="next-row next-row-no-padding next-row-align-center title">
                                                                <h3 class="title-text">Company video and photos</h3>
                                                            </div>
                                                            <div class="next-slick next-slick-inline next-slick-horizontal image-slider">
                                                                <div class="next-slick-inner next-slick-initialized" draggable="true">
                                                                    <div class="next-slick-list">
                                                                        <div class="next-slick-track"
                                                                            style="opacity: 1; width: 2407.6px; transform: translate3d(0px, 0px, 0px);">
                                                                            <?php $company_photos = array_filter(json_decode($company->photos)); 
                                                                                foreach($company_photos as $row){?>
                                                                            <div class="next-slick-slide next-slick-active image-item"
                                                                                data-index="0" tabindex="-1"
                                                                                style="outline: none; width: 185.2px;">
                                                                                <div class="image-box">
                                                                                    <div class="img" style="background-image: url(<?php echo base_url();?>;);">
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <?php }?>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <!-- react-empty: 20 -->
                                                        </div>
                                                        <div class="block-bottom">
                                                            <table class="company-basicInfo">
                                                                <tr>
                                                                    <td class="field-title">Business Type</td>
                                                                    <td class="field-content-wrap">
                                                                        <div
                                                                            class="next-row next-row-no-padding next-row-justify-space-between field-content">
                                                                            <div
                                                                                style="overflow: hidden; text-overflow: ellipsis; -webkit-box-orient: vertical; display: -webkit-box; -webkit-line-clamp: 3;">
                                                                                <div class="content-value" title="Trading Company"><?php echo $company->company_type; ?></div>
                                                                            </div>
                                                                            <span class="icbu-verified-icon verified">
                                                                                <svg
                                                                                    class="icbu-icon-svg" width="12">
                                                                                </svg>
                                                                            </span>
                                                                        </div>
                                                                    </td>
                                                                    <td class="field-title">Location</td>
                                                                    <td class="field-content-wrap">
                                                                        <div
                                                                            class="next-row next-row-no-padding next-row-justify-space-between field-content">
                                                                            <div
                                                                                style="overflow: hidden; text-overflow: ellipsis; -webkit-box-orient: vertical; display: -webkit-box; -webkit-line-clamp: 3;">
                                                                                <div class="content-value" title="<?php echo $company->comp_operational_addr; ?>">
                                                                                    <?php echo $company->comp_operational_addr; ?>
                                                                                </div>
                                                                            </div>
                                                                            <span class="icbu-verified-icon verified">
                                                                                <svg
                                                                                    class="icbu-icon-svg" width="12">
                                                                                </svg>
                                                                            </span>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="field-title">Main Products</td>
                                                                    <td class="field-content-wrap">
                                                                        <div
                                                                            class="next-row next-row-no-padding next-row-justify-space-between field-content">
                                                                            <div
                                                                                style="overflow: hidden; text-overflow: ellipsis; -webkit-box-orient: vertical; display: -webkit-box; -webkit-line-clamp: 3;">
                                                                                <a class="content-value"
                                                                                    href="//jmjiaying.en.alibaba.com/featureproductlist.html"
                                                                                    data-spm-click="gostr=/sc.icbuShop.cpCompanyOverviewAnchor;locaid=supplierMainProducts;anchor=supplierMainProducts"
                                                                                    target="_blank"><?php $main_prs = array_filter(json_decode($company->main_products)); 
                                                                                    foreach($main_prs as $row){echo $row.','; }?></a>
                                                                            </div>
                                                                        </div>
                                                                    </td>
                                                                    <td class="field-title">Total Employees</td>
                                                                    <td class="field-content-wrap">
                                                                        <div
                                                                            class="next-row next-row-no-padding next-row-justify-space-between field-content">
                                                                            <div
                                                                                style="overflow: hidden; text-overflow: ellipsis; -webkit-box-orient: vertical; display: -webkit-box; -webkit-line-clamp: 3;">
                                                                                <div class="content-value" title="Fewer than 5 People"><?php echo $company->no_of_employee; ?></div>
                                                                            </div>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="field-title">Total Annual Revenue</td>
                                                                    <td class="field-content-wrap">
                                                                        <div
                                                                            class="next-row next-row-no-padding next-row-justify-space-between field-content">
                                                                            <div
                                                                                style="overflow: hidden; text-overflow: ellipsis; -webkit-box-orient: vertical; display: -webkit-box; -webkit-line-clamp: 3;">
                                                                                <div class="content-value"
                                                                                    title="US$1 Million - US$2.5 Million"><?php echo $company->annual_production_capacity; ?></div>
                                                                            </div>
                                                                        </div>
                                                                    </td>
                                                                    <td class="field-title">Year Established</td>
                                                                    <td class="field-content-wrap">
                                                                        <div
                                                                            class="next-row next-row-no-padding next-row-justify-space-between field-content">
                                                                            <div
                                                                                style="overflow: hidden; text-overflow: ellipsis; -webkit-box-orient: vertical; display: -webkit-box; -webkit-line-clamp: 3;">
                                                                                <div class="content-value"><?php echo $company->year_of_register; ?></div>
                                                                            </div>
                                                                            <span class="icbu-verified-icon verified">
                                                                                <svg
                                                                                    class="icbu-icon-svg" width="12" viewBox="0 0 10 10">
                                                                                </svg>
                                                                            </span>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="field-title">Certifications</td>
                                                                    <td class="field-content-wrap">
                                                                        <div
                                                                            class="next-row next-row-no-padding next-row-justify-space-between field-content">
                                                                            <div
                                                                                style="overflow: hidden; text-overflow: ellipsis; -webkit-box-orient: vertical; display: -webkit-box; -webkit-line-clamp: 3;">
                                                                                <div class="content-value" title=""> <?php echo $company->honor_award_certifications; ?></div>
                                                                            </div>
                                                                        </div>
                                                                    </td>
                                                                    <td class="field-title">Product Certifications(4)</td>
                                                                    <td class="field-content-wrap">
                                                                        <div
                                                                            class="next-row next-row-no-padding next-row-justify-space-between field-content">
                                                                            <div
                                                                                style="overflow: hidden; text-overflow: ellipsis; -webkit-box-orient: vertical; display: -webkit-box; -webkit-line-clamp: 3;">
                                                                                <a class="content-value" href="#cpRDCapacity"
                                                                                    data-spm-click="gostr=/sc.icbuShop.cpCompanyOverviewAnchor;locaid=productCertificatesSummaryIntroduce;anchor=productCertificatesSummaryIntroduce"><?php echo $company->certification_reports; ?></a>
                                                                            </div>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="field-title">Patents</td>
                                                                    <td class="field-content-wrap">
                                                                        <div
                                                                            class="next-row next-row-no-padding next-row-justify-space-between field-content">
                                                                            <div
                                                                                style="overflow: hidden; text-overflow: ellipsis; -webkit-box-orient: vertical; display: -webkit-box; -webkit-line-clamp: 3;">
                                                                                <div class="content-value" title=""> <?php echo $company->patents; ?></div>
                                                                            </div>
                                                                        </div>
                                                                    </td>
                                                                    <td class="field-title">Trademarks</td>
                                                                    <td class="field-content-wrap">
                                                                        <div
                                                                            class="next-row next-row-no-padding next-row-justify-space-between field-content">
                                                                            <div
                                                                                style="overflow: hidden; text-overflow: ellipsis; -webkit-box-orient: vertical; display: -webkit-box; -webkit-line-clamp: 3;">
                                                                                <div class="content-value" title=""><?php echo $company->trademarks; ?></div>
                                                                            </div>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="field-title">Main Markets</td>
                                                                    <td class="field-content-wrap">
                                                                        <div
                                                                            class="next-row next-row-no-padding next-row-justify-space-between field-content">
                                                                            <div
                                                                                style="overflow: hidden; text-overflow: ellipsis; -webkit-box-orient: vertical; display: -webkit-box; -webkit-line-clamp: 3;">
                                                                                <a class="content-value" href="#cpTradeCapability"
                                                                                    data-spm-click="gostr=/sc.icbuShop.cpCompanyOverviewAnchor;locaid=companyMainMarket;anchor=companyMainMarket">
                                                                                    <div class="main-markets">
                                                                                        <div class="market-item">
                                                                                            <?php echo $company->main_markets_distribution; ?>
                                                                                        </div>
                                                                                    </div>
                                                                                </a>
                                                                            </div>
                                                                        </div>
                                                                    </td>
                                                                    <td class="field-title"></td>
                                                                    <td class="field-content-wrap">
                                                                        <!-- react-empty: 112 -->
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
 
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                                 <div class="J_module" module-name="icbu-pc-cpQualityControlCapacity"
                                    module-title="cpQualityControlCapacity">
                                    <div data-reactroot="" class="icbu-pc-cpQualityControlCapacity">
                                      
                                    </div>
                                 </div>
                                 <div class="J_module" module-name="icbu-pc-cpTradeCapability" module-title="cpTradeCapability">
                                    <div data-reactroot="" class="icbu-pc-cpTradeCapability">
                                       <div class="icbu-mod-wrapper with-round icbu-infoList-mod v3" name="tradeCapabilities">
                                          <div class="wrap-box">
                                             <div class="mod-header">
                                                <h3 class="title">TRADE ABILITY</h3>
                                             </div>
                                             <div class="mod-content">
                                                <div class="icbu-mod-viewMore infoList-mod-wrap" style="max-height: 660px;">
                                                   <div class="">
                                                    
                                                      <div class="infoList-mod-field">
                                                         <!--<div class="title">
                                                              <h3>
                                                               <!-- react-text: 140 -->Trade Ability
                                                               <!-- /react-text -->
                                                               <!-- react-text: 141 -->
                                                               <!-- /react-text 
                                                            </h3>
                                                         </div>-->
                                                         <div class="content">
                                                            <table class="icbu-shop-table-col">
                                                               <tbody>
                                                                  <tr class="icbu-shop-table-col-item">
                                                                     <td class="title">Total Annual Revenue</td>
                                                                     <td class="content">
                                                                        <div><?php echo $company->annual_production_capacity; ?></div>
                                                                     </td>
                                                                  </tr>
                                                               </tbody>
                                                            </table>
                                                         </div>
                                                      </div>
                                                   </div>
 
                                            </div>
                                        </div>
                                        <div class="J_module" module-name="icbu-pc-cpProductionCapacity" module-title="cpProductionCapacity">
                                            <div data-reactroot="" class="icbu-pc-cpProductionCapacity">
                                                <div class="icbu-mod-wrapper with-round icbu-infoList-mod v3" name="productCapacity">
                                                    <div class="wrap-box">
                                                        <div class="mod-header">
                                                            <h3 class="title">PRODUCT CAPACITY</h3>
                                                        </div>
                                                        <div class="mod-content">
                                                            <div class="icbu-mod-viewMore infoList-mod-wrap" style="max-height: 660px;">
                                                                <div class="">
                                                                    <div class="infoList-mod-field">
                                                                        <div class="title">
                                                                            <h3>
                                                                                Factory Information
                                                                            </h3>
                                                                        </div>
                                                                        <div class="content">
                                                                            <table class="icbu-shop-table-col">
                                                                                <tbody>
                                                                                    <tr class="icbu-shop-table-col-item">
                                                                                        <td class="title">
                                                                                            <div
                                                                                                style="overflow: hidden; text-overflow: ellipsis; -webkit-box-orient: vertical; display: -webkit-box; -webkit-line-clamp: 2;">
                                                                                                <span title="Factory Size">Factory Size</span>
                                                                                            </div>
                                                                                        </td>
                                                                                        <td class="content">
                                                                                            <div>
                                                                                                <div
                                                                                                    style="overflow: hidden; text-overflow: ellipsis; -webkit-box-orient: vertical; display: -webkit-box; -webkit-line-clamp: 2;">
                                                                                                    <span
                                                                                                        title="5,000-10,000 square meters"><?php echo $company->factory_size; ?></span>
                                                                                                </div>
                                                                                            </div>
                                                                                        </td>
                                                                                    </tr>
                                                                                    <tr class="icbu-shop-table-col-item">
                                                                                        <td class="title">
                                                                                            <div
                                                                                                style="overflow: hidden; text-overflow: ellipsis; -webkit-box-orient: vertical; display: -webkit-box; -webkit-line-clamp: 2;">
                                                                                                <span title="No. of Production Lines">No. of
                                                                                                Production Lines</span>
                                                                                            </div>
                                                                                        </td>
                                                                                        <td class="content">
                                                                                            <div>
                                                                                                <div
                                                                                                    style="overflow: hidden; text-overflow: ellipsis; -webkit-box-orient: vertical; display: -webkit-box; -webkit-line-clamp: 2;">
                                                                                                    <span title="Above 10"><?php echo $company->production_line_count; ?></span>
                                                                                                </div>
                                                                                            </div>
                                                                                        </td>
                                                                                    </tr>
                                                                                </tbody>
                                                                            </table>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="J_module" module-name="icbu-pc-cpQualityControlCapacity"
                                            module-title="cpQualityControlCapacity">
                                            <div data-reactroot="" class="icbu-pc-cpQualityControlCapacity"></div>
                                        </div>
                                        <div class="J_module" module-name="icbu-pc-cpTradeCapability" module-title="cpTradeCapability">
                                            <div data-reactroot="" class="icbu-pc-cpTradeCapability">
                                                <div class="icbu-mod-wrapper with-round icbu-infoList-mod v3" name="tradeCapabilities">
                                                    <div class="wrap-box">
                                                        <div class="mod-header">
                                                            <h3 class="title">TRADE ABILITY</h3>
                                                        </div>
                                                        <div class="mod-content">
                                                            <div class="icbu-mod-viewMore infoList-mod-wrap" style="max-height: 660px;">
                                                                <div class="">
                                                                    <div class="infoList-mod-field">
                                                                        <!--<div class="title">
                                                                            <h3>
                                                                             <!-- react-text: 140 -->Trade Ability
                                                                        <!-- /react-text -->
                                                                        <!-- react-text: 141 -->
                                                                        <!-- /react-text 
                                                                            </h3>
                                                                            </div>-->
                                                                        <div class="content">
                                                                            <table class="icbu-shop-table-col">
                                                                                <tbody>
                                                                                    <tr class="icbu-shop-table-col-item">
                                                                                        <td class="title">Total Annual Revenue</td>
                                                                                        <td class="content">
                                                                                            <div><?php echo $company->annual_production_capacity; ?></div>
                                                                                        </td>
                                                                                    </tr>
                                                                                </tbody>
                                                                            </table>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
 
                                                </div>
                                            </div>
                                        </div>
                                        <div class="J_module" module-name="icbu-pc-cpKeyCustomers" module-title="cpKeyCustomers">
                                            <!-- react-empty: 1 -->
                                        </div>
                                        <div class="J_module" module-name="icbu-pc-cpReports" module-title="cpReports">
                                            <!-- react-empty: 1 -->
                                        </div>
                                    </div>
<<<<<<< HEAD
                                 </div>
                                 <div class="J_module" module-name="icbu-pc-cpKeyCustomers" module-title="cpKeyCustomers">
                                    <!-- react-empty: 1 -->
                                 </div>
                                 <div class="J_module" module-name="icbu-pc-cpReports" module-title="cpReports">
                                    <!-- react-empty: 1 -->
                                 </div>
                              </div>
                              <div class="cp-footer">
                                 <span class="footer-item first">
                                 <a class="link-default" href="<?php echo site_url();?>company-details/<?php echo $company->company_name;?>"
                                    target="_blank" rel="nofollow">
                                 View this supplier’s website
                                 </a>
                                 </span>
                              </div>
                           </div>
                           <div class="tab-body-pane ls-icon" data-module="transactionHistory"></div>
                           <div class="tab-body-pane ls-icon" data-module="detailDiscuss"></div>
                        </div>
                     </div>
                     <!----------------------------------->				
                     <script>
                       
                     </script>
                     <div class="detail-box">
                        <div class="detail-box" data-module="fastFeedback">
                           <div data-reactroot="" class="detail-module module-fastFeedback ls-feedback"
                              id="J-ls-feedback">
                              <div></div>
                              <div class="feedback-wrapper" id="fastFeedbackContent"></div>
                           </div>
=======
                                    <div class="cp-footer">
                                        <span class="footer-item first">
                                        <a class="link-default" href="<?php echo site_url();?>company-details/<?php echo $company->company_name;?>"
                                            target="_blank" rel="nofollow">
                                        View this supplier’s website
                                        </a>
                                        </span>
                                    </div>
                                </div>
                                <div class="tab-body-pane ls-icon" data-module="transactionHistory"></div>
                                <div class="tab-body-pane ls-icon" data-module="detailDiscuss"></div>
                            </div>
>>>>>>> f2ad2ec04b6d47a6dfbcd6bec2a153d74116a047
                        </div>
						 </div>
                        <!----------------------------------->				
                        <script>
                            window._pageFirstScreenTime = new Date().getTime();
                        </script>
                        <div class="detail-box">
                            <div class="detail-box" data-module="fastFeedback">
                                <div data-reactroot="" class="detail-module module-fastFeedback ls-feedback"
                                    id="J-ls-feedback">
                                    <div></div>
                                    <div class="feedback-wrapper" id="fastFeedbackContent"></div>
                                </div>
                            </div>
                            <div class="detail-box">
                                <div class="scc-wrapper detail-module module-seoSimilarProducts" data-spm="seosimilar">
                                </div>
                            </div>
                        </div>
                        <div class="sub-content  fusion-detail ">
                            <div class="detail-box">
                                <div class="detail-box">
                                    <div class="scc-wrapper detail-module module-companyCardIntegrated" >
                                        <div class="widget-supplier-card company-card-integrated  has-ta "
                                            >
                                            <div class="company-name-container">
                                                <a class="company-name" href="<?php echo site_url();?>company-details/<?php echo $company->company_name;?>"
                                                    target="_blank" title="<?php echo $company->company_name;?>"
                                                    ><?php echo $company->company_name;?></a>
                                            </div>
                                            <div class="card-supplier">
                                                <?php $current_year = date('Y');
                                                    $year_of_register = $current_year-$product['year_of_register']; 
                                                    ?>
                                                <ul>
                                                    <li style="line-height:30px;"> <strong> Registered Since : <?php echo ($year_of_register != 0)?$year_of_register:"1"; ?> Yrs </strong></li>
                                                    <li style="line-height:30px;"> <strong>Company Type : <?php echo $product['business_type'];  ?></strong></li>
                                                    <li style="line-height:30px;"> <strong>Country : <?php echo $product['country_name']; ?></strong></li>
                                                </ul>
                                            </div>
                                            <!--                                 <div class="card-icons">
                                                <div class="icon-item">
                                                   <a>
                                                   <i class="svg-card-icon svg-card-icon-gs"></i>Gold Supplier
                                                   </a>
                                                </div>
                                                <div class="icon-item">
                                                   <a data-role="ta-info"
                                                      href="<?php echo base_url(); ?>trade-assurance"
                                                      target="_blank" data-aui="ta-ordered" rel="nofollow">
                                                   <i class="svg-card-icon svg-card-icon-ta"></i>Trade Assurance</a>
                                                </div>
                                                
                                                </div>-->
                                            <!--                                 <div class="transaction-info">
                                                <div style="margin-bottom: 10px;margin-top: 18px;">
                                                   <a class="score">
                                                   <span class="score-big"><?php echo $ratings; ?>.0</span>
                                                   <span class="score-common">/5</span>
                                                   </a>
                                                   <div class="review-level">
                                                      <a class="level-text">Very satisfied</a>
                                                      <a class="reviews">
                                                     <?php echo $reviews_count; ?> Reviews
                                                      </a>
                                                   </div>
                                                </div>
                                                </div>-->
                                            <table>
                                                <tbody>
                                                    <!-- <tr class="card-info-item">
                                                        <th>Transaction Level:</th>
                                                        <td>
                                                           <a href=""
                                                              data-domdot="id:26433" target="_blank" class="no-line">
                                                           <i
                                                              class="ui2-icon-svg ui2-icon-svg-xs ui2-icon-svg-diamond-level-half"></i>
                                                           </a>
                                                        </td>
                                                        </tr>
                                                        tradeIsView:false
                                                        <tr class="card-info-item">
                                                        <th>
                                                           Response Time
                                                        </th>
                                                        <td>
                                                            <b class="util-left">24h</b>
                                                        </td>
                                                        </tr>
                                                        <tr class="card-info-item">
                                                        <th>
                                                           Response Rate
                                                        </th>
                                                        <td>
                                                           <b class="util-left performance-value-wrap util-clearfix"><?php echo rand(10,100); ?>%</b>
                                                        </td>
                                                        </tr>-->
                                                </tbody>
                                            </table>
                                            <div class="card-footer">
                                                <a href="<?php echo site_url();?>company-details/<?php echo $company->company_name;?>"
                                                    target="_blank">View Company Profile</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="detail-module module-rightYouMayLike" data-module="rightYouMayLike">
                                        <div class="details-you-may-like details-you-may-like-vertical detail-module">
                                            <h5 class="you-may-like-title">You may like</h5>
                                            <?php $i=1; foreach($related_product as $rel_prod){ if($i<=3){ 
                                                $title = str_replace('-', '_', $rel_prod->name);
                                                                        $url_title = str_replace(' ', '-', $title);
                                                ?>
                                            <div class="product-item esite-clearfix" >
                                                <div class="iwrap"><a
                                                    title="<?php echo $rel_prod->name; ?>"
                                                    target="_blank"
                                                    href="<?php echo base_url(); ?>product-details/<?php echo $url_title; ?>/<?php echo $rel_prod->product_id; ?>"
                                                    class="ia dot-utm"
                                                    ><img
                                                    alt="<?php echo $rel_prod->name; ?>"
                                                    class="ipic"
                                                    src="<?php echo $rel_prod->media_url; ?>"
                                                    style="visibility: visible;"></a></div>
                                                <div class="info">
                                                    <a class="title dot-utm" target="_blank"
                                                        title=""
                                                        href="<?php echo base_url(); ?>product-details/<?php echo $url_title; ?>/<?php echo $rel_prod->product_id; ?>"
                                                        >
                                                    <?php echo $rel_prod->name; ?>
                                                    </a>
                                                    <div class="attr" title="<?php echo $rel_prod->final_price1; ?> - <?php echo $rel_prod->final_price2; ?> /<?php echo $rel_prod->units_name; ?>">
                                                        <span class="bold"><i class="fa fa-inr"></i>  <?php echo $rel_prod->final_price1; ?></span> </br>
														<span>
                                                        <?php
                                                            if($rel_prod->mrp!=$rel_prod->final_price1 && $rel_prod->mrp !=0){
                                                            	echo "<i class='fa fa-inr'></i> <span class='price-new text-mute'><del>".$rel_prod->mrp."</del></span> ";
                                                            	echo " <strong><span class='text-success'>".$rel_prod->discount." % Off </span> </strong>";
                                                            }
                                                            ?>
                                                        </span>		
                                                    </div>
													
                                                </div>
                                            </div>
                                            <?php } $i++; } ?>
                                        </div>
                                    </div>
                                    <div data-module="floatFeedback"></div>
                                </div>
                            </div>
                        </div>
                        <!-- Recommended Product -->
                              <div>
                            <header class="section-heading heading-line">
                                <h4 class="title-section bg text-uppercase">Recommended items</h4>
                            </header>
                            <div class="row-sm">
                                <?php foreach($related_product as $product){
                                    $title = str_replace('-','_',$product->name); 
                                    $url_title = str_replace(' ','-',$title);   
                                    ?>
                                <div class="col-md-2">
                                    <figure class="card card-product">
                                        <div class="img-wrap"><a href="<?php echo base_url() ;?>product-details/<?php echo $url_title; ?>/<?php echo $product->product_id; ?>" target="_blank"> <img src="<?php echo $product->media_url; ?>" width="169px" height="169px"></a></div>
                                        <figcaption class="info-wrap">
                                            <h6 class="title "><a href="<?php echo base_url() ;?>product-details/<?php echo $url_title; ?>/<?php echo $product->product_id; ?>" target="_blank"><?php echo $product->name; ?></a></h6>
                                            <div class="price-wrap">
                                                <i class="fa fa-inr"></i> <span class="price-new"><?php echo $product->final_price1; ?></a></span>-
                                                <span class="price-new"><?php echo $product->final_price2; ?></a></span></br>
                                                <span>
                                                <?php
                                                    if($product->mrp!=$product->final_price1 && $product->mrp !=0){
                                                    	echo "<i class='fa fa-inr'></i> <span class='price-new text-mute'><del>".$product->mrp."</del></span> ";
                                                    	echo " <strong><span class='text-success'>".$product->discount." % Off </span> </strong>";
                                                    }
                                                    ?>
                                                </span>		
                                            </div>
                                            <!-- price-wrap.// -->
                                        </figcaption>
                                    </figure>
                                    <!-- card // -->
                                </div>
                                <!-- col // -->
                                <?php } ?>
                            </div>
                        </div>

					<!-- End Recommended Product -->
					</div>
				</div>	
            </div>
        </div>
    </div>
</div>

<div class="modal" id="myModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Here is the detailed items you have selected.</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body" id="view_details">
            </div>
            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<?php $this->load->view("front/common/footer");?>
<!-- <script src="https://code.jquery.com/jquery.js"></script> -->
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
<script>
    var price = JSON.parse('<?php echo json_encode($product_prices); ?>');
    var currentId;
    var itemListBeForeAdd = [];
    var totalQuantity = 0;
    var currentkey = '';
    var currentColor = '';
    var thirdSpecValue = '';
    var thirdSpecKey = '';
    var finalObject = [];
    var finalObject_with_dis = [];
    var case_type = 0;
	
    $(document).ready(function () {
		restAllSizeTextField();	
		var cart_count = $("#cart_count").text();
		if(cart_count == 0)
		{
			$("#cart").hide();
		}
        $("#details").hide();
        $('.next-tabs-tab').click(function () {
            $('.next-tabs-tab').removeClass('active');
            $(this).addClass('active');
            var tagid = $(this).data('tag');
            $('.tab-body-pane').removeClass('show').addClass('box-hide');
            $('#' + tagid).addClass('show').removeClass('box-hide');
        });
        $("#currentItem_1").addClass('show-border');
        $('#currentItem_1').click();
        currentId = 'currentItem_1';
        case_type = $('.class_Type').val();
    });
    
    
    
    $('.add_favorite').on("click", function () {
        var product_id = $(this).data("product-id");
        $.ajax({
            url: "<?php echo site_url(); ?>home_product/add_to_favorite",
            method: "POST",
            data: {"product_id": product_id},
            dataType: "JSON",
            success: function (data)
            {
    
                if (data.status == 0)
                {
                    window.location.href = "<?php echo site_url(); ?>/login";
    
                } else if (data.status == 1) {
    
                    alert(data.message);
    
                } else if (data.status == 2) {
    
                    var fav = $('#fav_count').html();
					location.reload();
                    $('#fav_count').html(parseInt(fav) + 1);
					
                }
            }
    
        });
    });

    // $(document).ready(function(){

    // function saveValue(e)
    // {
    //        var id = e.id;  // get the sender's id to save it .
    //        var val = e.value; // get the value.
    //        alert(val);
    //        localStorage.setItem(id, val);// Every time user writing something, the localStorage's value will override .
    // }


    // });

     //No-Specfication functionlity
    function valueForNoSpecification(id, typeOfUpdate) {
		$('#display_error').html("");
        let beforeCounter = $('#' + id).val();

        if (typeOfUpdate == 'plus')
        {
            beforeCounter++;
          
            $('#' + id).val(beforeCounter);
        } else if (typeOfUpdate == 'minus' && (($('#' + id).val()) > 0))
        {
            beforeCounter--;
            $('#' + id).val(beforeCounter);
        }
        updateAmountWithNoSpec();
        if (beforeCounter == 0)
        {
            $("#details").hide();
        } else {
            $("#details").show();
            $("#modelDetails").hide();
        }
        totalQuantity = parseInt(beforeCounter) ? beforeCounter : 0;
        createArrayNoSpec(id, '', '', '', totalQuantity, '', findPriceQuantityBased(totalQuantity), '', '', id);
    }
    
    function createArrayNoSpec(uniqueId, colorkey, sizeKey, colorValue, quantity, itemSize, priceArray, unitsName, rowId, idForRowOnly) {
        var moq = price[0] ? price[0].quantity_from : 0;
        var temparray = {'uniqueId': uniqueId, 'colorkey': colorkey, 'sizeKey': sizeKey, 'colorValue': colorValue, 'quantity': quantity, 'size': itemSize, 'unitPrice': priceArray.final_price, 'unitsName': priceArray.units_name, 'rowId': rowId, 'idForRowOnly': idForRowOnly, 'moq': moq};
    
        itemListBeForeAdd = itemListBeForeAdd.filter(p =>
        {
            if ((p.rowId) != rowId) {
                return true;
            }
    
        });
        itemListBeForeAdd.push(temparray);
        createRequiredObject(itemListBeForeAdd);
    }
    
    function updateAmountWithNoSpec() {
        var quantityNoSpec = $('#counterNoSpec').val();
        $('#qnty').text(quantityNoSpec);
        let priceNoSpec = findPriceQuantityBased(quantityNoSpec);
        var calculateUnitPrice = parseFloat((priceNoSpec) ? priceNoSpec.final_price * quantityNoSpec : 0);
        $("#price_count").text(parseFloat(Math.round(calculateUnitPrice * 100) / 100).toFixed(2));

    }
    //No-Specfication functionlity end
    function addProductToCart(id, color = 'black', key, isOneSpec = false)
    {
        if (key && id && color) {
            if (!isOneSpec) {
                restAllSizeTextField();
            }
            currentColor = color;
            currentkey = key;
            currentId = id;
            $("#item-span").find("span").removeClass('show-border');
            $("#" + id).addClass('show-border');
    
            var tempArrayToUpdate = itemListBeForeAdd.filter(p =>
            {
                if ((p.uniqueId) == id) {
                    return true;
                }
            });
    
            $.each(tempArrayToUpdate, function (index, obj) {
                let tempId = '#' + obj.idForRowOnly
                $(tempId).val(obj.quantity);
            });
		}
    }
    
    // Third Specification only select.
    function thirdSpec(id, tSpec = '', key)
    {
        if ((totalQuantity == 0))
        {
            $('#display_error').html("Please Add The Quantity "); 
    
        } else {
            if (id && tSpec && key) {
                thirdSpecValue = tSpec;
                thirdSpecKey = key;
                currentId = id;
                $("#item-span").find("span").removeClass('show-border-thirdspec');
                $("#" + id).addClass('show-border-thirdspec');
    
                var thirdspecArr = {'thirdSpecValue': thirdSpecValue, 'thirdSpecKey': thirdSpecKey, 'currentId': currentId, 'isOther': true, 'uniqueIdThird': uniqueId};
    
                itemListBeForeAdd = itemListBeForeAdd.filter(p =>
                {
                    if (p.thirdSpecKey == thirdSpecKey && p.uniqueIdThird == uniqueId)
                    {
                        return false;
                    } else
                    {
                        return true;
                    }
                });
                itemListBeForeAdd.push(thirdspecArr);
            }
            createRequiredObject(itemListBeForeAdd);
		}
    }
    
    function restAllSizeTextField() {
        $('.size-text-field').val(0);
    }
    
    function minusValue(id, currentElement, sizekey, isOneSpec = false, currentField) {
        var beforeCounter = 0;
        beforeCounter = $('#currentItem_' + id).val();
        if (beforeCounter > 0) {
            beforeCounter--;
            $('#currentItem_' + id).val(beforeCounter);
            addItemsWithSize(id, currentElement, sizekey, beforeCounter, isOneSpec, currentField);
        }
    
        if (totalQuantity == 0)
        {
            $("#details").hide();
        } else {
            $("#details").show();
        }
        if (isOneSpec) {
            $("#item-span").find("span").removeClass('show-border');
            $("#currentItem_" + currentField).addClass('show-border');
            $("#currentItem_" + currentField).click();
    }
    }
    
    function plusValue(id, currentElement, sizekey, isOneSpec = false, currentField) {
        var beforeCounter = 0;
        beforeCounter = $('#currentItem_' + id).val();
        beforeCounter++;
        $('#currentItem_' + id).val(beforeCounter);
        addItemsWithSize(id, currentElement, sizekey, beforeCounter, isOneSpec, currentField);
        if (isOneSpec) {
            $("#item-span").find("span").removeClass('show-border');
            $("#currentItem_" + currentField).addClass('show-border');
            $("#currentItem_" + currentField).click();
    }
    }
    
    function findPriceQuantityBased(quantity) {
        var quantityFromList = price.filter(p =>
        {
            var firstInterval = parseInt(p.quantity_from);
            var secondInterval = parseInt(p.quantity_upto);
            if (quantity >= firstInterval && quantity <= secondInterval)
            {
                return true;
            }
        });
    
        if (quantityFromList.length == 0) {
            quantityFromList = (price.length > 0 ? price[0] : 0);
        } else {
            quantityFromList = quantityFromList[0];
        }
    
        return quantityFromList;
    }
    
    function addItemsWithSize(itemSize, numOfItem, sizekey, quantity_value, isOneSpec = false, currentField) {
        $('#display_error').html("");
        if (isOneSpec) {
            $("#modelDetails").hide();
        } else {
            $("#modelDetails").show();
        }
        $("#details").show();
    
        uniqueId = currentId;
        var rowId = isOneSpec ? itemSize : currentId + itemSize;
        var idForRowOnly = 'currentItem_' + itemSize;
    
        colorkey = currentkey;
		colorValue = currentColor;

        sizeKey = sizekey;
        var quantity = !quantity_value ? parseInt($(numOfItem).val()) : quantity_value;
        var quantityFromList = price.filter(p =>
        {
            let firstInterval = parseInt(p.quantity_from);
            let secondInterval = parseInt(p.quantity_upto);
            if (quantity >= firstInterval && quantity <= secondInterval)
            {
                return true;
            }
        });

        var unitPrice = parseFloat(quantityFromList[0] ? quantityFromList[0].final_price : price[0].final_price);
        var moq = price[0] ? price[0].quantity_from : 0;
        var unitsName = (quantityFromList[0] ? quantityFromList[0].units_name : price[0].units_name);
    
    
        var temparray = {'uniqueId': uniqueId, 'colorkey': colorkey, 'sizeKey': sizeKey, 'colorValue': colorValue, 'quantity': quantity, 'size': itemSize, 'unitPrice': unitPrice, 'unitsName': unitsName, 'rowId': rowId, 'idForRowOnly': idForRowOnly, 'moq': moq};
		
		
        itemListBeForeAdd = itemListBeForeAdd.filter(p =>
        {
            if ((p.rowId) != rowId) {
                return true;
            }
        });
		
        if (temparray.quantity) {
            itemListBeForeAdd.push(temparray);
        }
        updateAmountQuantity();
        createRow(itemListBeForeAdd);
        if (isOneSpec) {
            $("#item-span").find("span").removeClass('show-border');
            $("#currentItem_" + currentField).addClass('show-border');
            $("#currentItem_" + currentField).click();
    }
 
    
    }
    
    function updateAmountQuantity() {
        totalQuantity = 0;
        $.each(itemListBeForeAdd, function (index, obj) {
            if (obj.quantity)
                totalQuantity = totalQuantity + obj.quantity;
        });
		if(totalQuantity > 0)
		{
			$('#qnty').text(totalQuantity);
		
			var quantity = parseInt(totalQuantity);
			var quantityFromList = price.filter(p =>
			{
				var firstInterval = parseInt(p.quantity_from);
				var secondInterval = parseInt(p.quantity_upto);
				if (quantity >= firstInterval && quantity <= secondInterval)
				{
					return true;
				}
			});
		
			$.each(itemListBeForeAdd, function (index, obj) {
				if (itemListBeForeAdd.length > 0 && quantityFromList.length > 0)
					itemListBeForeAdd[index].unitPrice = (quantityFromList[0] ? quantityFromList[0].final_price : price[0].final_price);
			});
		
			var calculateUnitPrice = (quantityFromList[0] ? quantityFromList[0].final_price : price[0].final_price) * quantity;
			
			$("#price_count").text(calculateUnitPrice.toFixed(2));
		}
    
    
    }
    
    function createRow(itemListBeForeAdd) {
        var data = '<table class="table table-bordered"><thead><tr><th>Color</th><th>Size</th><th>Quantity</th><th>Unit Price</th></tr></thead>';
        // console.log(itemListBeForeAdd);
        $.each(itemListBeForeAdd, function (index, obj) {
            if (obj.colorValue && obj.quantity) {
                data += '<tbody><tr><td>' + obj.colorValue + '</td><td>' + obj.size + '</td><td>' + obj.quantity + '</td><td>INR.' + obj.unitPrice + '</td></tr>';
            }
        });
        data += '</tbody></table>';
        $('#view_details').html(data);
        thirdSpec();
    }
    
    function createRequiredObject(itemListBeForeAdd)
    {
    
        finalObject = [];
        var response = [];
    
        Array.prototype.groupBy = function (prop) {
            return this.reduce(function (groups, item) {
                const val = item[prop]
                groups[val] = groups[val] || []
                groups[val].push(item)
                return groups
            }, {})
        }
    
        const result = itemListBeForeAdd.filter(q =>
        {
            if (q && !q.isOther) {
                return true;
            }
        }).groupBy('colorValue');
        $.each(result, function (key, value) {
            let s =
                    {
                        "specifications": {
                            "primary":
                                    {
                                        "unit_price": -1,
                                        "quantity": "NA",
                                        "id": '',
                                        "spec_value": key,
                                        "specification_name": value[0].colorkey
                                    },
                            "secondary":
                                    [
    
                                    ],
    
                            "other":
                                    [
    
                                    ],
                            "total_quantity": totalQuantity,
                            "moq": value[0].moq,
                            "unit_price": value[0].unitPrice,
                            "unit_name": value[0].unitsName,
                            "coupon_id": 0,
                            "total_price_after_dis": 0,
                            "total_discount": 0,
                            "discount_percent": 0,
                            "case_type": case_type
                        }
                    };
    
            $.each(value, function (k, v) {
                let temp = {
                    "quantity": v.quantity,
                    "id": v.rowId,
                    "spec_value": v.size,
                    "specification_name": v.sizeKey
                };
                s.specifications.secondary.push(temp);
            });
    
            //chaNGE
            const isArrayFound = itemListBeForeAdd.filter(q =>
            {
                if (q.uniqueIdThird == value[0].uniqueId) {
                    return true;
                }
            });
            $.each(isArrayFound, function (k, v) {
                let othr = {
                    "id": v.currentId ? v.currentId : '',
                    "specification_name": v.thirdSpecKey ? v.thirdSpecKey : '',
                    "spec_value": v.thirdSpecValue ? v.thirdSpecValue : ''
                };
                s.specifications.other.push(othr);
            });
    
            finalObject.push(s);
        });
        // console.log(finalObject);
        response = finalObject;
        return response;
    }
    
    function checkQuantityExist(quantity) {
        if (quantity) {
            var quantityfromlist = price.filter(p =>
            {
                var firstinterval = parseInt(p.quantity_from);
                var secondinterval = parseInt(p.quantity_upto);
                if (quantity >= firstinterval && quantity <= secondinterval)
                {
                    return true;
                }
            });
    
            return (quantityfromlist.length > 0 ? true : false);
        }
    
        return false;
    }
    
    
    $('#add_to_cart').click(function () {

        if (totalQuantity > 0 && checkQuantityExist(totalQuantity) && finalObject.length > 0)
        {
			flyimage();
            $('#cart').show();
            var product_id = $(this).data('product-id');
            var product_name = $(this).data('productname');
            var productimage = $(this).data('productimage');
            var supplierDetails = $(this).data('supplierdetails');
            var seller = $(this).data('seller-id');
            var moq = '';
            var unitName = '';
            var addToCart = '';
            var title = '';
            var url_title = '';
			
            $.ajax({
                url: '<?php echo base_url(); ?>addToCart',
                method: 'POST',
                dataType: 'json',
                data: {product_id: product_id, product_name: product_name, productimage: productimage, supplierDetails: supplierDetails, seller: seller, tempList: finalObject},
                success: function (data) {
                    console.log(data);
                    if (data.status == 0)
                    {
                        window.location.href = "<?php echo base_url(); ?>login";
    
                    } else if (data.status == 1) {
						            get_addedCartproducts();
                    }
                },
    
            });
        } else {
            $('#display_error').html("Quantity Should be Between Minimum & Maximum order quantity");
        }
    });
    
    var couponArray = [];
    function getCoupons(moq, percent, coupan_id, id) {
        var qntyForCoupon = $("#qnty").text();
        var parsedqauntity = parseInt(qntyForCoupon);
        var parsedmoq = parseInt(moq);
        if (checkQuantityExist(parsedqauntity))
        {
            if (parsedqauntity > parsedmoq) {
                getObjectAfterCoupon(percent,coupan_id);
                $("#" + id).text("Coupon Added");
            } else {
                $('#display_error').html("Quantity Should be Between Minimum & Maximum order quantity");
            }
        } else {
            $('#display_error').html("Quantity Should be Between Minimum & Maximum order quantity");
        }
    }
    
    function getObjectAfterCoupon(percent,coupan_id) {
        finalObject_with_dis = [];
        if (parseInt(percent))
        {
            couponArray.push(parseInt(percent));
        }
        let maxPercent = Math.max.apply(null, couponArray);
        let resp = finalObject.filter(r => {
            let totalP = r.specifications.total_quantity * parseInt(r.specifications.unit_price);
            r.specifications.total_price_after_dis = (totalP - (totalP * parseInt(maxPercent)) / 100);
            r.specifications.total_discount = ((totalP * parseInt(maxPercent)) / 100);
            r.specifications.discount_percent = maxPercent;
			r.specifications.coupon_id = coupan_id;
            return true;
        });
    
        finalObject_with_dis = resp;
        console.log(finalObject_with_dis);
        return resp;
    }
    
    $('#start_order').click(function (event) {
          
        if ((totalQuantity == 0) || !checkQuantityExist(totalQuantity))
        {
            $('#display_error').html("Quantity Should be Between Minimum & Maximum order quantity");
            event.preventDefault();
            return false;
        } else {
            finalObject_with_dis = finalObject_with_dis.length > 0 ? finalObject_with_dis : finalObject;
            var product_id = $(this).data('product-id');
            var product_name = $(this).data('productname');
            var productimage = $(this).data('productimage');
            var supplierDetails = $(this).data('supplierdetails');
    
            var seller = $(this).data('seller-id');
            var sellername = $(this).data('sellername');
            var companyname = $(this).data('companyname');
            var address = $(this).data('address');
            var businesstype = $(this).data('businesstype');
            var countryname = $(this).data('countryname');
            var email = $(this).data('email');
            var phone = $(this).data('phone');
            $.ajax({
                url: '<?php echo base_url(); ?>startOrder',
                method: 'POST',
                dataType: 'json',
                data: {product_id: product_id, product_name: product_name, productimage: productimage, supplierDetails: supplierDetails, sellername: sellername, companyname: companyname, address: address, businesstype: businesstype, countryname: countryname, email: email, phone: phone, seller: seller, tempList: finalObject_with_dis},
                success: function (data) {
                    console.log(data);
                    if (data.status == 1)
                    {
                        window.location.href = "<?php echo site_url(); ?>userorder/proceed_start_order";
                    }
                },
    
            });
        }
    });
</script>
<script>
    $("#coupon").click(function () {
        $("#coupon-container ul").toggleClass("tip-hide");
        $("#coupon i").toggleClass("ion-ios-arrow-up ion-ios-arrow-down");
    });
	
	function flyimage()
	{
		var cart = $('.sc-hd-cellCART');
        var imgtodrag = $('.MagicZoom').find("img").eq(0);
        if (imgtodrag) {
            var imgclone = imgtodrag.clone()
                .offset({
                top: imgtodrag.offset().top,
                left: imgtodrag.offset().left
            })
                .css({
                'opacity': '0.5',
                    'position': 'absolute',
                    'height': '150px',
                    'width': '150px',
                    'z-index': '100'
            })
                .appendTo($('body'))
                .animate({
                'top': cart.offset().top + 10,
                    'left': cart.offset().left + 10,
                    'width': 75,
                    'height': 75
            }, 1000, 'easeInOutExpo');
            
            setTimeout(function () {
                cart.effect("shake", {
                    times: 2
                }, 200);
            }, 1500);

            imgclone.animate({
                'width': 0,
                    'height': 0
            }, function () {
                $(this).detach()
            });
        }
	}
	
	function get_addedCartproducts()
	{
		$.ajax({
                url: '<?php echo base_url(); ?>getaddedCartProducts',
                method: 'POST',
                dataType: 'json',
                success: function (data) {
                    // console.log(data);
                    if (data)
                    {
						var title = '';
						var url_title = '';
						var cartData = '';
                        $("#cart_count").html(data.length);
						
						for($k = 0; $k < data.length; $k++ ){
							
						title = data[$k].product_name.replace('-', '_', data[$k].product_name);
                        url_title = data[$k].product_name.replace(' ', '-', title);
						
                         cartData += '<div class="alife-bc-icbu-simple-shopping-cart-item"><div class="alife-bc-icbu-simple-shopping-cart-item-supplierName"><a href="" >' + data[$k].supplierDetails + '</a></div><div class="alife-bc-icbu-simple-shopping-cart-item-spu"> <div class="alife-bc-icbu-simple-shopping-cart-item-spu-img"><a href=""><img src="' + data[$k].product_image + '"></a></div><div class="alife-bc-icbu-simple-shopping-cart-item-spu-name"><a href="<?php echo base_url(); ?>purchaseList" title="' + data[$k].product_name + '" id="product_name">' + data[$k].product_name + '</a></div>';
    
                        var parsedSpecifications = JSON.parse(data[$k].specifications);
						
                        for (var i = 0; i < parsedSpecifications.length; i++) {
    
                            cartData += '<div class="alife-bc-icbu-simple-shopping-cart-item-sku-list">';
                            if (parsedSpecifications[i].specifications.case_type >= 2) {
    
                                for (var j = 0; j < parsedSpecifications[i].specifications.secondary.length; j++)
                                {
                                    cartData += '<div class="alife-bc-icbu-simple-shopping-cart-item-sku-item "><div class="alife-bc-icbu-simple-shopping-cart-item-sku-properties">';
                                    if (j == 0) {
                                        cartData += '<span class="alife-bc-icbu-simple-shopping-cart-item-sku-properties-item">' + parsedSpecifications[i].specifications.primary.spec_value + ' | </span><span class="alife-bc-icbu-simple-shopping-cart-item-sku-properties-item">' + parsedSpecifications[i].specifications.secondary[j].spec_value + '</span>';
                                    } else {
                                        cartData += '<span class="alife-bc-icbu-simple-shopping-cart-item-sku-properties-item">' + parsedSpecifications[i].specifications.primary.spec_value + ' | </span><span class="alife-bc-icbu-simple-shopping-cart-item-sku-properties-item">' + parsedSpecifications[i].specifications.secondary[j].spec_value + '</span>';
                                    }
                                    cartData += '</div><div class="alife-bc-icbu-simple-shopping-cart-item-sku-price"><span>INR.' + parsedSpecifications[i].specifications.unit_price + ' x ' + parsedSpecifications[i].specifications.secondary[j].quantity + '</div></div>';
                                }
    
                            } else if (parsedSpecifications[i].specifications.case_type == 1) {
                                for (var j = 0; j < parsedSpecifications[i].specifications.secondary.length; j++)
                                {
                                    cartData += '<div class="alife-bc-icbu-simple-shopping-cart-item-sku-item "><div class="alife-bc-icbu-simple-shopping-cart-item-sku-properties"><span class="alife-bc-icbu-simple-shopping-cart-item-sku-properties-item">' + parsedSpecifications[i].specifications.primary.specification_name + ' | </span><span class="alife-bc-icbu-simple-shopping-cart-item-sku-properties-item">' + parsedSpecifications[i].specifications.secondary[j].spec_value + '</span></div>';
    
                                    cartData += '<div class="alife-bc-icbu-simple-shopping-cart-item-sku-price"><span>INR.' + parsedSpecifications[i].specifications.unit_price + ' x ' + parsedSpecifications[i].specifications.secondary[j].quantity + '</div></div>';
                                }
                            } else {
    
                                cartData += '<div class="alife-bc-icbu-simple-shopping-cart-item-sku-item "><div class="alife-bc-icbu-simple-shopping-cart-item-sku-price"><span>INR.' + parsedSpecifications[i].specifications.unit_price + ' x ' + parsedSpecifications[i].specifications.total_quantity + '</div></div>';
                            }
                            cartData += '</div>';
                        }
                        cartData += '</div></div>';
					}
                        $("#add_to_cart_data").html(cartData);
                        $('#display_success').html("Added in Cart!!!");
					}
				},
		});
	}
	
 

	$('#Checkpincode').click(function(){
		var pincode = $('#pincode').val()
		$.ajax({
				url: '<?php echo base_url(); ?>home_product/check_pincode',
                method: 'POST',
                dataType: 'json',
				data: {pincode:pincode},
                success: function (data) {
					console.log(data);
					if(data.GetServicesforPincodeResult.AreaCode != null)
					{
						$("#areacode").html("<b style='color:green'>The Item is Deliverable at this Pincode.</b>");
					}else{
						$("#areacode").html("<b style='color:red'>Sorry ! The Item is Not Deliverable at this Pincode.</b>");
					}
				}
		});
	});
	
	function restrictAlphabets(e){
			var x=e.which||e.keycode;
			if((x>=48 && x<=57))
					return true;
			else
					return false;
	}

  /**/
 
  
</script>