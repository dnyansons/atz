<?php $this->load->view('front/common/header'); ?>
<style>
    .nivoSlider { max-height: 268px !important; }
    .nivo-control { display: none !important; }
    .btn-color{
        color: #fff !important;
    }
    .inner-div{
    width: 220px;
    height: 220px;
    border: 1px solid #e7e8ec;
    border-radius: 100%;
    background: #fff;
    border-bottom:1px solid #f1f1f1;
    border-right:1px solid #f1f1f1;
    padding: 20px;
    text-align: center;
    }
    .inner-pic{
        margin-top: 50px;
        width: 100%;
    }
    .supp_info{
    width: 100%;
    font-size: 13px;
    color: #333;
    margin-left: 26px;
    }
    .inner-pic img{
        width: 120px;
        margin-left: 35px;
    }
    .card-body {
    font-size: 14px;
    }
</style>
<div id="slider" class="nivoSlider"> 
    <img src="<?php echo base_url();?>assets/front/images/banners/shopping.jpg"  alt="" /> 
    <img src="<?php echo base_url();?>assets/front/images/banners/banner-request_.jpg"  alt="" /> 
</div>
<div class="container" style="margin-bottom:20px;">
    <div class="row">
        <div class="col-md-12">
            <?php foreach($regions as $region):
                //echo "<pre>";
                //print_r($$region);
                ?>
            <div class="col-md-4">
                <!-- <div class="card"> -->
                    <div class="card-body">
                        <div class="inner-div">
                        <h5 class="card-title"><?php echo $region->comp_operational_state;?></h5>

                        <p class="card-text">Check the top supplers from <?php echo $region->comp_operational_state;?>.</p>
                        <a href="<?php echo site_url();?>suppliers-by-regions/<?php echo $region->comp_operational_state;?>" class="btn btn-danger btn-color">Explore</a>
                        </div>
                    </div>
                <!-- </div> -->
            </div>
                
            <?php endforeach;?>
        </div>
    </div>
</div>
<?php $this->load->view('front/common/footer'); ?>
<script>
$('#slider').nivoSlider({
    
});
</script>