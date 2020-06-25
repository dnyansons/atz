<?php 
$this->load->view("front/common/header"); 
?>
<style>
    @import url("<?php echo base_url(); ?>assets/front/css/categroies.css")
</style>
<div class="">
    <div id="" class="">
        <div id="nxot9umj5">
            <div class="ocms-fusion-atz-pc-common-layout b2b-ocms-fusion-layout full">
                <div>
                    <div id="nngvae1sv">
                        <!-- react-empty: 1 -->
                    </div>
                    <div id="ntwkwuafe" >
                        <div class="ocms-fusion-atz-pc-weekly-deals-home b2b-ocms-fusion-comp">
                            <div class="zone-header">
                                <div class="zone-header-main-content">                     
                                    <div class="zone-background"></div>
                                </div>
                            </div>
                            <!-- All deals -->	
                            <div>
                                <div class="next-affix-top">
                                    <ul class="category-navbar ">
                                        <li class="category-item" style="margin-right: 20px;">
                                            <a href="<?php echo $_SERVER['REQUEST_URI'];?>">
                                            <div class="category-item-image-container">											
                                                <img src="<?php echo base_url(); ?>assets/front/images/product/mobile.png" class="category-item-image">											
                                            </div>
                                            <div class="category-item-text" style="color: rgb(51, 51, 51);">Deals of the day</div>
                                            </a>
                                        </li>
                                        <?php foreach($top_categories as $cats):?>
                                        <li class="category-item link_products" data-cat_id="<?php echo $cats->category_id;?>" data-cat_name="<?php echo $cats->categories_name;?>">
                                            <div class="category-item-image-container"
                                                 style="background-color: rgb(245, 245, 245);">
                                                <img src="<?php echo $cats->categories_image; ?>" class="category-item-image">
                                            </div>
                                            <div class="category-item-text" style="color: rgb(51, 51, 51);">
                                                 <?php echo $cats->categories_name;?> 
                                            </div>
                                        </li>
                                        <?php endforeach;?>
                                    </ul>
                                </div>
                            </div>

                            <div class="zone-navbar">
                                <div class="category-title">Deals of the day</div>
                            </div>
                            <div class="zone-navbar">
                                <div class="col-md-12">
                        <div class="l-grid l-grid-extra ">
                        <div class="l-col-main">
                            <div class="l-main-wrap">
                                <div style="position: relative; z-index: 100;">
                                </div>
                                <div class="l-theme-card-box">
                                    <div id="filtered_data">
                                        <?php if($products){ foreach ($products as $product) { ?>
                                            <div class="m-gallery-product-item-wrap col-2  special-cpvitem__render-product item__offer-global-impression-tags__always-show"
                                               >
                                               <!-- tangram:4161 begin-->
                                               <div class="m-gallery-product-item-v2">
                                                  <div class="item-main">
                                                     <div class="item-img">
                                                        <div class="place"></div>
                                                        <div class="item-img-inner">
                                                           <a  href="<?php echo base_url('product-details/') . $this->Product_model->seoUrl($product->product_name) . "/" . $product->product_id; ?>">
                                                              <div class="offer-image-box">
                                                                 <div
                                                                    class="J-favorite-manager-wrap-product gallery-favorite-container J-sc-fav-item-wrap">
                                                                    <div class="favorite-corner J-sc-fav-item-wrap" id="detail-favorite-mark" >
                                                                       <div class="J-scc-favorite-manager-label scc-favorite-manager-label scc-fav-label-onlyicon scc-fav-icon-bkg">
                                                           <a href="javascript:void(0)" class="add_favorite" data-product-id="<?php echo $product->product_id; ?>"><i class="fa fa-heart scc-fav-i-heart-n-normal-small label-icon-mail"></i></a>
                                                           </div>
                                                           </div>
                                                           </div>
                                                           <a href="<?php echo base_url('product-details/') . $this->Product_model->seoUrl($product->product_name) . "/" . $product->product_id; ?>">
                                                           <img src="<?php echo $product->media_url; ?>" class="img-fluid" alt=""></a>
                                                           </div>
                                                           </a>
                                                        </div>
                                                     </div>
                                                     <div class="item-info">
                                                        <h2 class="title two-line" style="display:flex;">
                                                           <a target="_blank" 
                                                              href="<?php echo base_url('product-details/') . $this->Product_model->seoUrl($product->product_name) . "/" . $product->product_id; ?>"
                                                              title="<?php echo $product->product_name; ?>">
                                                              <!-- tangram:3721 begin-->
                                                              <?php echo $product->product_name; ?>
                                                           </a>
                                                        </h2>
                                                        <div class="pmo ">
                                                           <a href="<?php echo base_url('product-details/') . $this->Product_model->seoUrl($product->product_name) . "/" . $product->product_id; ?>">
                                                              <div class="price">
                                                                 <b>
                                                                 INR.<?php echo $product->final_price1; ?> - <?php echo $product->final_price2; ?> 
                                                                 </b>
                                                                 / <?php echo $product->units_name; ?>
                                                              </div>
            <!--                                                  <div class="min-order">
                                                                 <b><?php echo $product->moq1; ?> <?php echo $product->units_name; ?></b>
                                                                 (Max Order)
                                                              </div>-->
                                                           </a>
                                                        </div>
                                                        <div class="hr">
                                                           <span></span>
                                                        </div>
                                                        <div class="contact">
                                                           <a class="ui2-button ui2-button-default ui2-button-primary ui2-button-small csp"
                                                              href="<?php echo base_url(); ?>home_product/product_inquiry/<?php echo $product->product_id; ?>" rel="nofollow" >
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
                    </div>
                            </div>
                           
                            
                        </div>
                        
                    </div>
                    
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $this->load->view("front/common/footer"); ?>
<script>
$(document).on("click",".link_products",function(){
    var cat_id = $(this).attr("data-cat_id");
    var title = $(this).attr("data-cat_name");
    console.log(cat_id);
    var url = "<?php echo site_url(); ?>home_product/getAjaxfilteredProducts";
    $.ajax({
        url: url,
        type: "post",
        async: false,
        cache: false,
        data : {
            page:0,
            category:cat_id,
        },
        beforeSend: function()
        {
            $('.ajax-load').show();
        }
    }).done(function(resp) {
        var obj = JSON.parse(resp);
        if(obj.status){
            $('.ajax-load').hide();
            $("#filtered_data").empty();
            var html = "";
            $.each( obj.items, function( key, value ) {
                var product_name = value.product_name.replace(/[^A-Z0-9]/ig, "-");
                html = '<div class="m-gallery-product-item-wrap col-2  special-cpvitem__render-product item__offer-global-impression-tags__always-show" >'+
                            '<div class="m-gallery-product-item-v2">'+
                                '<div class="item-main">'+
                                    '<div class="item-img">'+
                                        '<div class="place"></div>'+
                                        '<div class="item-img-inner">'+
                                            '<a  href="">'+
                                                '<div class="offer-image-box">'+
                                                    '<div class="J-favorite-manager-wrap-product gallery-favorite-container J-sc-fav-item-wrap">'+
                                                        '<div class="favorite-corner J-sc-fav-item-wrap" id="detail-favorite-mark" >'+
                                                            '<div class="J-scc-favorite-manager-label scc-favorite-manager-label scc-fav-label-onlyicon scc-fav-icon-bkg">'+
                                                                '<a href="javascript:void(0)" class="add_favorite" data-product-id="'+value.product_id+'">'+
                                                                '<i class="fa fa-heart scc-fav-i-heart-n-normal-small label-icon-mail"></i></a>'+
                                                            '</div>'+
                                                        '</div>'+
                                                    '</div>'+
                                                    '<a href="<?php echo site_url('product-details');?>/'+product_name+'/'+value.product_id+'">'+
                                                       '<img src="'+value.media_url+'" class="img-fluid" alt=""></a>'+
                                                '</div>'+
                                            '</a>'+
                                        '</div>'+
                                    '</div>'+
                                    '<div class="item-info">'+
                                        '<h2 class="title two-line" style="display:flex;">'+
                                            '<a target="_blank" href="<?php echo site_url('product-details');?>/'+product_name+'/'+value.product_id+'">'+
                                               value.product_name+
                                        '</a>'+
                                    '</h2>'+
                                    '<div class="pmo ">'+
                                        '<a href="">'+
                                           '<div class="price">'+
                                                '<b>'+
                                                    'INR.'+value.final_price1+'-'+value.final_price2+' /'+
                                                '</b>'+value.units_name+
                                            '</div>'+
//                                                    '<div class="min-order">'+
//                                                        '<b>'+value.moq1+'/'+value.units_name+'</b>'+
//                                                        '(Max Order)'+
//                                                    '</div>'+
                                        '</a>'+
                                    '</div>'+
                                    '<div class="hr">'+
                                        '<span></span>'+
                                    '</div>'+
                                    '<div class="contact">'+
                                        '<a class="ui2-button ui2-button-default ui2-button-primary ui2-button-small csp"'+
                                           'href="" rel="nofollow" >'+
                                            'Contact Supplier'+
                                        '</a>'+
                                    '</div>'+
                                '</div>'+
                            '</div>'+
                        '</div>'+
                        '</div>';
                $("#filtered_data").append(html);
                $(".category-title").text(title);
                //console.log(html);
            });
        } else {
            $('.ajax-load').html("OOPS! No more records found");
            return;
        }

    }).fail(function(jqXHR, ajaxOptions, thrownError) {
          //alert('server not responding...');
    });
});    
</script>