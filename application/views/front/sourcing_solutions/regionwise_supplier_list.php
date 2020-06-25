<?php 
//echo "<pre>";
//print_r($sellers);
//exit;
$this->load->view('front/common/header'); 

?>
<style>
    .nivoSlider { max-height: 268px !important; }
    .nivo-control { display: none !important; }
</style>
<style>
    .nivoSlider { max-height: 268px !important; }
    .nivo-control { display: none !important; }

.inner-div{
    border: 1px solid #ced5f3;
    background: #fff;
    padding: 20px;
    }
 
 .card-body{
    background-color: #f7f8fa;
 }
</style>
<div id="slider" class="nivoSlider"> 
    <img src="<?php echo base_url();?>assets/front/images/banners/shopping.jpg"  alt="" /> 
    <img src="<?php echo base_url();?>assets/front/images/banners/banner-request_.jpg"  alt="" /> 
</div>
<div class="container" style="margin-bottom:20px;">
    <div class="row">
        <div class="col-md-12">
            <h2>Central Industry Hub</h2>
            <div class="card">
                <div class="card-header">
                    Suppliers in <?php echo $region;?> Region
                </div>
                <div class="card-body">
                    <div class="row">
                        <?php foreach($sellers as $seller):?>
                            <div class="col-lg-3 col-sm-4 col-xs-6 p-2 ">
                                <div style="" class="inner-div">
                                    <div class="inner-pic">
                                    <a title="Image 1" href="#" class="">
                                        <img class="img-responsive" src="<?php echo $seller->logo;?>">
                                    </a>
                                   </div>
                                    <div class="caption p-2 supp_info">
                                        Supplier name :<?php echo $seller->supplier_name;?><br />
                                        Company :<?php echo $seller->company_name;?><br />
                                        type :<?php echo $seller->company_type;?><br />
                                    </div>
                                    
                                </div>
                            </div>
                        <?php endforeach;?>
                    </div>
                </div>
                <div class="card-footer"></div>
            </div>
            
        </div>
    </div>
</div>
<?php $this->load->view('front/common/footer'); ?>
<script>
$('#slider').nivoSlider({
    
});
</script>