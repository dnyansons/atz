<?php
//$this->load->view('templates/header');
?>
<div class="row">
    <div class="col-lg-12">
        <h2>Razorpay Payment Gateway Integration In Codeigniter using cURL</h2>                 
    </div>
</div><!-- /.row -->
<div class="row">
    <?php //foreach($productInfo as $key=>$element) { ?>
        <div class="col-lg-6 col-md-6 mb-6">
            <div class="card h-100">
                <a href="#"><img src="#" alt="product 10" title="product 10" class="card-img-top"></a>
                <div class="card-body">
                    <h4 class="card-title">
                        <a href="#">Abc</a>
                    </h4>
                    <h5>₹100</h5>
                    <p class="card-text">abc desc</p>
                </div>
                <div class="card-footer text-right">                    
                    <a href="<?php site_url()?>checkout/1" class="add-to-cart btn-success btn btn-sm" data-productid="1" title="Add to Cart"><i class="fa fa-shopping-cart fa-fw"></i> Buy Now</a>                    
                </div>
            </div>
        </div>
    <?php// } ?>          
</div>
<?php
//$this->load->view('templates/footer');
?>