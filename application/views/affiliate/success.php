
<?php $this->load->view('front/common/header'); ?>
<div class="container">
    <ol id="breadcrumb_CNEP" class="a-ordered-list a-horizontal breadcrumb mt-20">
        <li class="breadcrumb-item "><span class="a-list-item ">
                <a class="a-link-normal" href="<?php echo base_url(); ?>">
                Home
                </a>
                </span>
        </li>

        <li class="breadcrumb-item active"><span class="a-list-item a-color-state">
                <a class="a-link-normal" href="<?php echo base_url(); ?>trade_services/affiliateMarketing">
                Affiliate Marketing
                </a>
                </span>
        </li>
    </ol>
    <div class="row">
        <div class="col-md-12  my-5">               
            <div class="blog-post-text">
                <div class="alert alert-info py-5"  style="background-image: url('<?php echo base_url(); ?>assets/front/images/banner/affiliate.jpg');background-size:cover;background-position:bottom">					
                    <div class="text-center py-5">
                        <img src="http://goactionstations.co.uk/wp-content/uploads/2017/03/Green-Round-Tick.png" width="100" alt="">
                        <h1> Thank You! Your Registration Done Successfully.</h1>
                        <p>Your submission is received, wait for the approval. </p>

                    </div>               
                </div>
            </div>
        </div>
    </div>
    <!-- /.row -->
</div>	
<?php $this->load->view('front/common/footer'); ?>