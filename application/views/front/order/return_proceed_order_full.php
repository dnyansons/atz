
        <style>
        
            .price{
                font-weight: 500 !important;
                font-size: 13px !important;
                color: #000000ad !important;
            }
            .biz-action-bar-button{
                background-color: #bd081b !important;
            }
            body {
                background-color: #F7F8FA
            }
            .draft {
                padding: 20px;
                max-width: 1200px;
                min-width: 700px;
                background-color: #F7F8FA;
                margin: auto
            }
            .draft .next-icon-help:before,
            .draft .next-icon-success:before {
                color: #1DC11D
            }
            .draft .next-form-item {
                margin-bottom: 12px
            }
            .draft .draft-taBlock {
                border: 1px solid #FFB380
            }
            .draft .draft-productsAmountBlock {
                display: -ms-flexbox;
                display: flex;
                -ms-flex-align: end;
                align-items: flex-end;
                -ms-flex-direction: column;
                flex-direction: column
            }
            .next-form-item-control {
                line-height: 28px
            }
            .next-form-item-control .next-btn-text.next-btn-medium {
                margin: 0
            }
            .remarkContent_1 .next-form-item-control,
            .remarkInput_1 .next-form-item-control {
                width: 100%
            }
            .remarkContent_1 .next-form-item-control .next-input,
            .remarkInput_1 .next-form-item-control .next-input {
                width: 100%
            }
            .biz-block-card-wrap {
                margin: 0 0 20px;
                padding-bottom: 20px
            }
            .bg-color{
                background-color: unset !important;
            }
            .product .pic{
                width: 30% !important;
            }
            .wd100{
                width: 100% !important;
            }
            .font-13{
                font-size: 13px !important;
            }
            body{background:#f3f3f5 url(src/assets/front/images/back.png);background-repeat: no-repeat;}
        </style>
    <div class="d-block d-sm-none">
  <div class="header-wrap demonavheader">
    <div class="site-header with-shadow">
      <div class="main-header">
        <a class="header-item btn-search " onclick="openNav()"><i class="fa fa-bars"></i></a>
        <a class="header-item logo" href="/"><img src="<?php echo base_url(); ?>assets/front/images/logo/logo.png" alt=""></a>
      </div>
      <div class="search-text">
        <div class="search-bar">
          <div class="searchbar">
            <input class="search_input" type="text" name="" placeholder="Search...">
            <a href="#" class="search_icon"><i class="fa fa-search"></i></a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

 <div class="main" style="background-color: #f7f8fa;">

<div id="draft" class="draft">
 
    
	
    <div>
      <div class="next-step next-step-arrow next-step-horizontal base-step draft-stepBlock stepBlock_1">
	  
        <div data-spm-click="gostr=/sc.1;locaid=d_step;step=WaitforResponse" class="next-step-item next-step-item-process"
          data-spm-anchor-id="a2756.trade-order-standard.0.d_step" style="width: auto;">
          <div class="next-step-item-container">
            <div class="next-step-item-title">
              Start Return Order</div>
          </div>
        </div>
		
		<div data-spm-click="gostr=/sc.1;locaid=d_step;step= Confirm Receipt" class="next-step-item next-step-item-wait next-step-item-last"
          style="width: auto;">
          <div class="next-step-item-container">
            <div class="next-step-item-title">
             Processing</div>
          </div>
        </div>
		
		<div class="next-step-item next-step-item-wait " style="width: auto;">
          <div class="next-step-item-container">
            <div class="next-step-item-title">
              Return Order Success</div>
          </div>
        </div>
		
		
      </div>
    </div>
    <br>
	<form method="post" action="">
    <div>
        <input type="hidden" name="order_id" value="<?php echo $order_id; ?>">
        <input type="hidden" name="return_type" value="<?php echo $return_type; ?>">
      <?php 

                     if($details) { 
				
                     ?>
                  <div id="productsBlock_1" class="biz-block-card-wrap biz-block-card-wrap-undefined card draft-productsBlock">
                     <div class="biz-block-card-header wd100">
                                <h3 class="biz-block-card-title">
                                    <span data-i18n-appname="" data-i18n-ns="ta.order.com.products" data-i18n-key="title">Product Details</span>
                                </h3>
                            </div>
                     <div class="biz-block-card-body">
                        <div id="productsHeader_1" class="block draft-productsHeader">
                           <div class="biz-supplierLite">
                              <div class="next-row biz-supplierLite-header">
                                 <div class="next-col next-col-16">
                                    <span class="biz-supplierLite-label"><span>Supplier</span></span>
                                    <span
                                       class="biz-supplierLite-value">
                                       <span>
                                       <?php echo $details->supplierDetails; ?>
                                       </span>
                                      
                                    </span>
                                 </div>
                                 <div class="next-col biz-supplierLite-showaction"><span onclick = "show_details()">Show supplier's details</span></div>
                              </div>
							    <div class="biz-supplierLite-body" id="seller_details">
							  <div class="next-row">
								  <div class="next-col next-col-3 biz-supplierLite-label"><span>Supplier Name</span></div>
								  <div class="next-col biz-supplierLite-value"><?php echo $seller_info['first_name']; ?> <?php echo $seller_info['last_name']; ?></div>
							    </div>
								<div class="next-row">
								  <div class="next-col next-col-3 biz-supplierLite-label"><span>Company Name</span></div>
								  <div class="next-col biz-supplierLite-value"><?php echo $seller_info['company_name']; ?></div>
							    </div>
								<div class="next-row">
								  <div class="next-col next-col-3 biz-supplierLite-label"><span>Address</span></div>
								  <div class="next-col biz-supplierLite-value"><?php echo $seller_info['address1']; ?></div>
							    </div>
								<div class="next-row">
								  <div class="next-col next-col-3 biz-supplierLite-label"><span>Business Type</span></div>
								  <div class="next-col biz-supplierLite-value"><?php echo $seller_info['name']; ?></div>
							    </div>
								<!--<div class="next-row">
									<div class="next-col next-col-3 biz-supplierLite-label"><span>Contact Name</span></div>
									<div class="next-col next-col-6 biz-supplierLite-label text-left"><span><?php //echo $seller_info['phone']; ?></span></div>
								</div>
								<div class="next-row">
									<div class="next-col next-col-3 biz-supplierLite-label"><span>Email</span></div>
									<div class="next-col next-col-6 biz-supplierLite-label text-left"><span><?php //echo $seller_info['email']; ?></span></div>
								</div>-->
								
							  <div class="next-row">
								  <div class="next-col next-col-3 biz-supplierLite-label"><span>Country/Region</span></div>
								  <div class="next-col biz-supplierLite-value"><?php echo ucfirst(strtolower($seller_info['country_name'])); ?></div>
							  </div>
							  <div class="next-row">
								<div class="next-col biz-supplierLite-showaction"><span onclick = "hide_details()">Hide supplier's details</span></div>
							  </div>
							 </div>
                           </div>
                        </div>
                        <div class="biz-products">
                           <div class="next-table only-bottom-border component-product-list">
                              <div class="next-table-inner">
                                 <div class="next-table-header">
                                    <div class="next-table-header-inner">
                                       <table>
                                          <thead>
                                             <tr>
											 <th > <div class="next-table-cell-wrapper"><strong>Product Image </strong></div></th>
                                                <th rowspan="1" class="next-table-header-node first">
                                                <div class="next-table-cell-wrapper"><strong>Product Name </strong></div>
                                                </th>
                                                <th rowspan="1" class="next-table-header-node">
                                                   <div class="next-table-cell-wrapper"><strong>Quantity</strong></div>
                                                </th>
                                                <th rowspan="1" class="next-table-header-node">
                                                   <div class="next-table-cell-wrapper"><strong>Unit</strong></div>
                                                </th>
                                                <th rowspan="1" class="next-table-header-node">
                                                   <div class="next-table-cell-wrapper"><strong>Unit Price</strong></div>
                                                </th>
                                                <th rowspan="1" class="next-table-header-node last">
                                                   <div class="next-table-cell-wrapper"><strong>Total Product Amount</strong></div>
                                                </th>
                                             </tr>
                                          </thead>
                                       </table>
                                    </div>
                                 </div>
                                 <div class="next-table-body">
                                     <?php
                                     if($return_type=='full')
                                     {
                                     ?>
                                    <table>
                                       <tbody>
                                          
                                          <?php
                                             $specifications = $details->specifications;
                                             					 
                                             $tot_price = 0;
                                             $count_item = count($specifications);
                                             $qnty = 0;
                                             for ($i = 0; $i < count($specifications); $i++) {
                                                 ?>
                                          <tr>
										  <td class="next-table-cell first">
                                                <div class="next-table-cell-wrapper">
                                                   <div class="biz-sku-infos">
                                                      <div class="pic"><img src="<?php echo $details->product_image; ?>"
                                                         class="media-side"></div>
                                                      <div class="detail">
                                                        
                                                      </div>
                                                   </div>
                                                </div>
                                             </td>
                                              <td class="next-table-cell">
                                                <div class="next-table-cell-wrapper">
												<?php  ?><br>
												 <?php if($specifications[$i]->specifications->case_type > 2 || $specifications[$i]->specifications->case_type == 2){
echo $details->product_name.'<br>';													 ?>
                                                   <?php for ($j = 0; $j < count($specifications[$i]->specifications->secondary); $j++) {
                                                      if ($j == 0) {
														  
														  if($specifications[$i]->specifications->other[$j]->spec_value)
														  { 
															$other = " ( ".$specifications[$i]->specifications->other[$j]->spec_value ." )";
														  }
														  
                                                          echo $specifications[$i]->specifications->primary->specification_name;
                                                          ?> : <?php echo $specifications[$i]->specifications->primary->spec_value. "<br>";
														  
														  echo $specifications[$i]->specifications->secondary[$j]->specification_name; ?> : <?php
														  echo $specifications[$i]->specifications->secondary[$j]->spec_value .$other. "<br>";
                                                          $qnty += $specifications[$i]->specifications->secondary[$j]->quantity;
                                                      } else { 
														if($specifications[$i]->specifications->other[$j]->spec_value)
														{ 
															$other = " ( ".$specifications[$i]->specifications->other[$j]->spec_value ." )";
														}
													  
														echo $specifications[$i]->specifications->secondary[$j]->specification_name; ?> : <?php
														  echo $specifications[$i]->specifications->secondary[$j]->spec_value .$other. "<br>";
                                                          $qnty += $specifications[$i]->specifications->secondary[$j]->quantity;
                                                      }
                                                      }
												 } else if($specifications[$i]->specifications->case_type == 1){
													 echo $details->product_name.'<br>';
                                                      for ($j = 0; $j < count($specifications[$i]->specifications->secondary); $j++) { 		  
														 echo $specifications[$i]->specifications->secondary[$j]->specification_name; ?> : <?php
														 echo $specifications[$i]->specifications->secondary[$j]->spec_value . "<br>";
														 $qnty += $specifications[$i]->specifications->secondary[$j]->quantity;
												} } else{ ?>
														<?php echo $details->product_name; ?>
												<?php } ?>
                                                </div>
                                             </td>
                                             <td class="next-table-cell">
                                                <div class="next-table-cell-wrapper">
                                                   <?php echo ($qnty) ? $qnty: $specifications[$i]->specifications->total_quantity; ?> (<?php echo $specifications[$i]->specifications->unit_name; ?>)
                                                </div>
                                             </td>
                                             <td class="next-table-cell">
                                                <div class="next-table-cell-wrapper">
                                                   <div class="biz-product-unit"><?php echo $specifications[$i]->specifications->unit_name; ?></div>
                                                </div>
                                             </td>
                                             <td class="next-table-cell">
                                                <div class="next-table-cell-wrapper">
                                                   <div class="biz-product-price">
                                                      <div class="ladders">
                                                         <i class='fa fa-inr'></i> <?php echo $specifications[$i]->specifications->unit_price; ?> / <?php echo $specifications[$i]->specifications->unit_name; ?>
                                                      </div>
                                                   </div>
                                                </div>
                                             </td>
                                             <td class="next-table-cell last">
                                                <div class="next-table-cell-wrapper">
                                                   <div class="biz-product-amount">
                                                      <i class='fa fa-inr'></i> <?php
													     if($qnty)
														 {
															$total_price = $qnty * $specifications[$i]->specifications->unit_price;
														 }else{
															$total_price = $specifications[$i]->specifications->total_quantity * $specifications[$i]->specifications->unit_price;
														 }
                                               
                                                         echo $total_price;
                                                         $tot_price += $total_price;
                                                         ?>
                                                   </div>
                                                </div>
                                             </td>
                                          </tr>
                                          <?php $qnty = 0;
                                             $discount = $specifications[$i]->specifications->total_discount;
                                             $discount_percent = $specifications[$i]->specifications->discount_percent;
                                             $total_amount= $specifications[$i]->specifications->total_price_after_dis;
                                           } ?>
											
                                       </tbody>
                                    </table>
                                     
                                     <?php } ?>
                                   
                                 </div>
                              </div>
                           </div>
                        </div>
                        <div class="next-row next-row-justify-center block-footer" id="productsFooter_1">
                           <div class="next-col block-footer-left">
                              <div id="productsAmountBlock_1" class="block draft-productsAmountBlock">
                                 <div class="biz-products-amount">
                                    <label><span>Order Price</span></label>
                                    <span>
                                       <!-- react-text: 485 --><i class='fa fa-inr'></i>
                                       <!-- /react-text -->
                                       <!-- react-text: 486 --><?php echo number_format($tot_price,2); ?>
                                       <!-- /react-text -->
                                    </span>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <?php if($discount > 0){ ?>
                        <div class="next-row next-row-justify-center block-footer" id="productsFooter_1">
                           <div class="next-col block-footer-left">
                              <div id="productsAmountBlock_1" class="block draft-productsAmountBlock">
                                 <div class="biz-products-amount">
                                    <label><span> Max. Coupon Discount of <?php echo $discount_percent; ?>% </span></label>
                                    <span>
                                       <!-- react-text: 485 --><i class='fa fa-inr'></i>
                                       <!-- /react-text -->
                                       <!-- react-text: 486 --><?php echo number_format($discount,2); ?>
                                       <!-- /react-text -->
                                    </span>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <div class="next-row next-row-justify-center block-footer" id="productsFooter_1">
                           <div class="next-col block-footer-left">
                              <div id="productsAmountBlock_1" class="block draft-productsAmountBlock">
                                 <div class="biz-products-amount">
                                    <label><span>Total Product Amount </span></label>
                                    <span style="color:red">
                                      <i class='fa fa-inr'></i><?php echo number_format($total_amount,2); ?>
                                      
                                    </span>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <?php } ?>
                     </div>
                  </div>
                  <?php } ?>
    </div>
	
	  <div>
	  <br>
          <div>
      <div id="shippingBlock_1" class="biz-block-card-wrap biz-block-card-wrap-undefined card draft-shippingBlock">
         <div class="biz-block-card-header wd100">
                                <h3 class="biz-block-card-title">
                                   Return Reason
                                </h3>
                            </div>
        <div class="biz-block-card-body">
          
          <div class="next-form-item next-row" id="shippingTime_1" label="[object Object]">
           
              
                <select name="return_reason" id="return_reason" style="width:100%;" required>
                    <option value=''>Select Reason</option>
                    <?php
                    foreach($return_reason as $reason)
                    { 
                     echo'<option value="'.$reason->reason_id.'">'.$reason->reason_name.'</option>';
                    }
                    ?>
                </select>	
            
         
          </div>
         
         
        </div>
      </div>
          </div>
      <div class="biz-action-bar">
        <div class="biz-action-bar-inner">
         
          <div>
              <input style="width:150px;" onclick="return confirm_return()" type="submit" name="submit" value="Confirm Return" class="next-btn next-btn-primary next-btn-large biz-action-bar-button">
        </div>
      </div>
    </div>
	

</div>
        </form>
</div>
</div>
<script src="http://code.jquery.com/jquery-1.11.3.min.js"></script>
<script>
	$(document).ready(function(){
	   $("#seller_details").hide();
   });
	function show_details()
	{
		$("#seller_details").show();
	}
	
	function hide_details()
	{
		$("#seller_details").hide();
	}
        
        
        function confirm_return()
        {
          var reason=$('#return_reason').val();
          if(reason!='')
          {
              var con=confirm('Are You Sure ? ');
              if(con==true)
              {
                  return true;
              }
              else
              {
                  return false;
              }
          }
          else
          {
              alert('Please Choose Return Reason !');
              return false;
          }
        }
</script>