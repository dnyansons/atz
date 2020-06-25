<?php $this->load->view("front/common/header"); ?>
<style>
   @import url("<?php echo base_url(); ?>assets/front/css/categroies.css")
</style>
<div class="l-page-main-v2" style="min-height: auto;">
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
                              <a href="<?php echo site_url('product-catalog/'). underscore($row['categories_name'])."/".$row['category_id'];?>" > <?php  echo $row['categories_name']; ?></a>
                              <span class="divider"></span>
                           </div>
                           <?php }?>
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
                           <div class="input-group mb-2 mt-2 col-3">
                              <div class="input-group-prepend">
                                 <span class="input-group-text" id="basic-addon1">
                                 Min Order :</span>
                              </div>
                              <input type="text" class="form-control" id='min_order' placeholder="less than">
                           </div>
                           <div class="input-group col-5 mb-2 mt-2">
                              <div class="input-group-prepend">
                                 <span class="input-group-text"> Price : </span>
                              </div>
                              <input type="text" id='min_price'  class="form-control" placeholder="min.">
                              <input type="text"  class="form-control"  placeholder="max." id='max_price'>
                           </div>
                           <div class="m-price-filter-wrap pl-15 mt-1">
                              <button type="button" class="btn btn-danger" onclick = "filter_product()">Filter</button>
                           </div>
                        </div>
                        <div id="error_messege"> </div>
                     </div>
                  </div>
               </div>
               <div class="m-gallery-selected-wrap">
                  <div class="selected-total-wrap">
                     <span><?php echo $total_count; ?></span> results for "<?php echo $main_category['title']; ?>" 
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
                     <!--first product:1 begin-->
                     <?php if($products){
                        foreach ($products as $product) { ?>
                     <div class="m-gallery-product-item-wrap col-2  special-cpvitem__render-product item__offer-global-impression-tags__always-show"
                        >
                        <!-- tangram:4161 begin-->
                        <div class="m-gallery-product-item-v2">
                           <div class="item-main">
                              <div class="item-img">
                                 <div class="place"></div>
                                 <div class="item-img-inner">
                                    <a  href="<?php echo base_url('product-details/') . $this->Product_model->seoUrl($product['product_name']) . "/" . $product['product_id']; ?>">
                                       <div class="offer-image-box">
                                          <div
                                             class="J-favorite-manager-wrap-product gallery-favorite-container J-sc-fav-item-wrap">
                                             <div class="favorite-corner J-sc-fav-item-wrap" id="detail-favorite-mark" >
                                                <div class="J-scc-favorite-manager-label scc-favorite-manager-label scc-fav-label-onlyicon scc-fav-icon-bkg">
                                    <a href="javascript:void(0)" class="add_favorite" data-product-id="<?php echo $product['id']; ?>"><i class="fa fa-heart scc-fav-i-heart-n-normal-small label-icon-mail"></i></a>
                                    </div>
                                    </div>
                                    </div>
                                    <a href="<?php echo base_url('product-details/') . $this->Product_model->seoUrl($product['product_name']) . "/" . $product['product_id']; ?>">
                                    <img src="<?php echo $product['media_url']; ?>" class="img-fluid" alt=""></a>
                                    </div>
                                    </a>
                                 </div>
                              </div>
                              <div class="item-info">
                                 <h2 class="title two-line" style="display:flex;">
                                    <a target="_blank" 
                                       href="<?php echo base_url('product-details/') . $this->Product_model->seoUrl($product['product_name']) . "/" . $product['product_id']; ?>"
                                       title="<?php echo $product['product_name']; ?>">
                                       <!-- tangram:3721 begin-->
                                       <?php echo $product['product_name']; ?>
                                    </a>
                                 </h2>
                                 <div class="pmo ">
                                    <a href="<?php echo base_url('product-details/') . $this->Product_model->seoUrl($product['product_name']) . "/" . $product['product_id']; ?>">
                                       <div class="price">
                                          <b>
                                          INR.<?php echo $product['final_price1']; ?> - <?php echo $product['final_price2']; ?> 
                                          </b>
                                          / <?php echo $product['units_name']; ?>
                                       </div>
                                       <div class="min-order">
                                          <b><?php echo $product['moq1']; ?> <?php echo $product['units_name']; ?></b>
                                          (Max Order)
                                       </div>
                                    </a>
                                 </div>
                                 <div class="hr">
                                    <span></span>
                                 </div>
                                 <div class="contact">
                                    <a class="ui2-button ui2-button-default ui2-button-primary ui2-button-small csp"
                                       href="<?php echo base_url(); ?>home_product/product_inquiry/<?php echo $product['product_id']; ?>" rel="nofollow" >
                                    Contact Supplier
                                    </a>
                                 </div>
                              </div>
                           </div>
                            
                        </div>
                     </div>
                     <?php } }else{ ?>
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
                     <!-- end---->
                  </div>
                   
               </div>
                <div class="clear-fix"></div>
                <hr />
                <?php echo $links; ?>
                
            </div>
         </div>
      </div>
   </div>
</div>
</div>
<?php $this->load->view("front/common/footer"); ?>
<script>
   $('.add_favorite').on("click", function () {
   
       event.preventDefault();
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
                   window.location.href = "<?php echo site_url(); ?>user/login";
   
               } else if (data.status == 1) {
   
                   alert(data.message);
   
               } else if (data.status == 2) {
   
                   var fav = $('#fav_count').html();
				   alert("Added In Favourite");
                   $('#fav_count').html(parseInt(fav) + 1);
               }
           }
   
       });
   });
   
   function filter_product()
   {
       var cat_id = '<?php echo $main_category["id"]; ?>';
       var min_order = $("#min_order").val();
       var min_price = $("#min_price").val();
       var max_price = $("#max_price").val();
       console.log(min_order, min_price, max_price);
   
       if(min_order == '' || min_price == '' || max_price == '')
       {
               $('#error_messege').html("<div class='pt-3 pb-3 pl-3' style='color:red'>Please Fill Out All The Fields</div>");
   
       }else{
	   $('#error_messege').html('');
       $.ajax({
           url: '<?php echo site_url(); ?>filterProduct',
           type: 'POST',
           dataType: 'json',
           data: {min_order: min_order, min_price: min_price, max_price: max_price, cat_id: cat_id},
           success: function (data) {
               console.log(data);
               if(data != false)
               {
                   var html_data = "";
                   var title = '';
                   var url_title = '';
                   var str = '';
                   $.each(data, function (inx, obj) {
					   str = obj.product_name;
                       title = str.replace('-', '_');
                       url_title = title.replace(' ', '-');
   
                           html_data += '<div class="m-gallery-product-item-wrap col-2  special-cpvitem__render-product item__offer-global-impression-tags__always-show">';
   
                           html_data +=  '<div class="m-gallery-product-item-v2"><div class="item-main"><div class="item-img"><div class="place"></div><div class="item-img-inner"><a  href="<?php echo base_url('product-details/'); ?>' + url_title + "/" + obj.product_id+'"><div class="offer-image-box"><div class="J-favorite-manager-wrap-product gallery-favorite-container J-sc-fav-item-wrap"><div class="favorite-corner J-sc-fav-item-wrap" id="detail-favorite-mark" ><div class="J-scc-favorite-manager-label scc-favorite-manager-label scc-fav-label-onlyicon scc-fav-icon-bkg"><a href="javascript:void(0)" class="add_favorite" data-product-id="'+obj.product_id+'"><i class="fa fa-heart scc-fav-i-heart-n-normal-small label-icon-mail"></i></a></div></div></div><a href=<?php echo base_url('product-details/')?>'+ url_title + "/" + obj.product_id +'"><img src="'+obj.media_url+'" class="img-fluid" alt=""></a></div></a></div></div>';
   
                           html_data += '<div class="item-info"><h2 class="title two-line" style="display:flex;"><a target="_blank" href="<?php echo base_url('product-details/')?>'+ url_title + "/" + obj.product_id +'" title="'+obj.product_name +'">'+obj.product_name +'</a></h2><div class="pmo "><a href="<?php echo base_url('product-details/')?>'+ url_title + "/" + obj.product_id +'"><div class="price"><b>INR.'+obj.final_price1+'-'+obj.final_price2+'</b>/ '+obj.units_name+'</div><div class="min-order"><b>'+obj.moq2+' '+obj.units_name+'</b>(Min Order)</div></a></div><div class="hr"><span></span></div><div class="contact"><a class="ui2-button ui2-button-default ui2-button-primary ui2-button-small csp" href="<?php echo base_url(); ?>home_product/product_inquiry/'+obj.product_id+'" rel="nofollow" >Contact Supplier</a></div></div></div></div></div>';
                   });
   
                   $('#filtered_data').html(html_data);
               }else{
                       $('#filtered_data').html("<div class='clearfix'><div id='notfound'><div class='notfound'><div class='notfound-404'><h1>Oops!</h1><h2>Your Filter Did Not Match Any Product !!</h2></div><a href='<?php echo base_url(); ?>'>Go TO Homepage</a></div></div></div>");
               }
           },
       });
   }
   
   }
   
</script>