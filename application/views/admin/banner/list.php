<?php $this->load->view("admin/common/header"); ?>
<style>
    .switch {
        position: relative;
        display: inline-block;
        width: 60px;
        height: 34px;
    }

    .switch input { 
        opacity: 0;
        width: 0;
        height: 0;
    }

    .slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #ccc;
        -webkit-transition: .4s;
        transition: .4s;
    }

    .slider:before {
        position: absolute;
        content: "";
        height: 26px;
        width: 26px;
        left: 4px;
        bottom: 4px;
        background-color: white;
        -webkit-transition: .4s;
        transition: .4s;
    }

    input:checked + .slider {
        background-color: #4CAF50;
    }

    input:focus + .slider {
        box-shadow: 0 0 1px #4CAF50;
    }

    input:checked + .slider:before {
        -webkit-transform: translateX(26px);
        -ms-transform: translateX(26px);
        transform: translateX(26px);
    }

    /* Rounded sliders */
    .slider.round {
        border-radius: 34px;
    }

    .slider.round:before {
        border-radius: 50%;
    }
</style>
<div class="pcoded-content">
    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-header">
                    <div class="row align-items-end">
                        <div class="col-lg-8">
                            <div class="page-header-title">
                                <div class="d-inline">
                                    <h4>Banner</h4>
                                    <span></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="page-header-breadcrumb">
                                <ul class="breadcrumb-title">
                                    <li class="breadcrumb-item">
                                        <a href="<?php echo site_url(); ?>admin/dashboard"> <i class="feather icon-home"></i> </a>
                                    </li>
                                    <li class="breadcrumb-item"><a href="#">Banners List</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="page-body">
                    <div class="row">
                        <div class="col-sm-12">

                            <div class="card">

                                <div class="card-header">

                                    <a href="<?php echo base_url(); ?>admin/banners/add_banner">
                                        <button type="button" class="btn btn-primary waves-effect waves-light f-right d-inline-block md-trigger" data-modal="modal-13"> <i class="icofont icofont-plus m-r-5"></i> Add Banner
                                        </button>
                                    </a>
                                </div>
                                <div class="card-block">
                                    <div class="dt-responsive table-responsive">
                                        <?php echo $this->session->flashdata('message'); ?>
                                        <table id="refund" class="table table-striped table-bordered nowrap">
                                            <thead>
                                                <tr>
                                                    <th>Sr.No</th>
                                                    <th>Banner Title</th>
                                                    <th>Banner Image</th>
                                                    <th>Sort Order</th>
                                                    <th>Expire Date</th>
                                                    <th>Status</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $i = 1;
                                                foreach ($items as $item):
                                                    // echo "<pre>";
                                                    // echo $item['banners_url'].$item['banners_image'];
                                                    ?>
                                                    <tr>
                                                        <td><?php echo $i; ?></td>
                                                        <td><?php echo $item['banners_title']; ?></td>

                                                        <td>
                                                            <img class="img" src="<?php echo $item["banners_url"]; ?>" width="60px" height="60px"/>
                                                        </td>
                                                        <td><?php echo $item['sort_order']; ?></td>
                                                        <td><?php echo date("d:m:Y", $item['expire_date']); ?></td>
                                                        <td id="td<?php echo $item['banners_id']?>"><?php echo $item['status'] ? "Active" : "Inactive"; ?></td>
                                                        <td>
                                                            <label class="switch">
                                                                <input class="bannerToggle" type="checkbox" <?php echo $item['status']==1? 'checked':''; ?> 
                                                                       id="<?php echo $item['banners_id']?>" value="<?php echo $item['status']; ?>">
                                                                <span class="slider round"></span>
                                                            </label>
                                                        </td>
                                                    </tr>
                                                    <?php $i++;
                                                endforeach;
                                                ?>
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
</div>
<?php $this->load->view("admin/common/footer"); ?>
<script>
$(document).ready(function(){
   $('input[type="checkbox"]').click(function(){
       //alert(this.id);
       var bannerId = this.id;
       var bannerStatus = $(this).val();
       //alert(bannerId + "  = "+bannerStatus );
       $.post( "<?php echo base_url('admin/banners/toggleBanner'); ?>", { 'toggleBannerId': bannerId, 'toggltBannerVal' : ""+bannerStatus } )
       .done(function( data ) {
           var values = "";
           if(data == 1){
               values = 'Active';
           } else {
               values = 'Inactive';
           }
            $('#td'+bannerId).html(values);
            $('#'+bannerId).val(data);
       });

   }); 
});  
</script>

