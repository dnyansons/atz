<?php $this->load->view("front/common/header"); ?>
<style>
    .card {
        background:none !important;   
        border: 0px solid rgba(0,0,0,.125);
        border-radius:0rem;
    }
</style>

<div class="jumbotron jumbotron-fluid" style="background:url(<?php echo base_url();?>assets/front/images/banner/offer-baner.jpg)no-repeat center; background-size:cover">
  <div class="container">
    <h1 class="p-5"></h1>      
    
  </div>
</div>
<div class="main" style="">
    <!--Deals Of The Day-->
    <section class="section-content padding-y-sm mb-5 ">
        <div class="">
            <header class="section-heading heading-line">
                <h4 class="title-section bg">Deals Of The Day</h4>
            </header>
            <div class="card ">
                <div class="row no-gutters">
                    <!-- col.// -->            
                    <div class="row">
  <?php
  if(count($runningOffers) == 0) {
      redirect(base_url('welcome'));
  }
    foreach ($runningOffers as $offer) {
        $link = base_url('product-catalog/') . str_ireplace(" ", '-', $offer['categories_name']) .
                '/' . $offer['category_id'];
  ?>
                        <div class="col-sm-2  p-2">
                            <!-- single product -->
                            <div class="single-product-area card-product">
                                <div class="product-wrapper gridview">
                                    <div class="list-col4">
                                        <div class="product-image ">
                                            <div class="img-wrap">
                                                <a href="<?php echo $link; ?>"> 
                                                    <img width="169px" height="169px" class="lazy" src="<?php echo $offer['offer_image']; ?>" style="display: inline-block;"></a></div>
                                        </div>
                                    </div>
                                    <div class="list-col8">
                                        <div class="product-info">
                                            <h2><a href="<?php echo $link; ?>"><?php echo $offer['categories_name'] ?></a></h2>
                                            <span class="price">
                                                <?php
                                                            if (strtolower($offer['offer_type']) == 'flat') {
                                                                echo '<i class="fa fa-inr"></i> ' . $offer['discount_value'] . ' Off';
                                                            } else {
                                                                echo $offer['discount_value'] . ' % Off';
                                                            }
                                                            ?>
                                            </span>
                                        </div>
                                        <div class="deal-counter m-0 mb-0 p-1">
                                            <div data-countdown="<?php echo $offer['offer_end_time'] ?>"></div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <!-- single product end -->
                        </div>

    <?php } ?>
                        

                    </div>

                    <!-- col.// -->
                </div>
                <!-- row.// -->
            </div>
        </div>
    </section>	

</div>
<!-- main end -->
<?php $this->load->view("front/common/footer"); ?>

