<?php $this->load->view('front/common/header'); ?>
<style>
    .foorcont{
        border-top: 1px solid antiquewhite;
        border-bottom: 1px solid antiquewhite;
    }
    ul li{
        line-height: 25px;
    }
	.card{
	
    position: relative;
    width: 100%;
    margin-bottom: 30px;
    border-radius:2px;
    color: rgba(0, 0, 0, 0.87);
    background: #fff;
    box-shadow: 0 2px 2px 0 rgba(0, 0, 0, 0.14), 0 3px 1px -2px rgba(0, 0, 0, 0.2), 0 1px 5px 0 rgba(0, 0, 0, 0.12);
	}
	
	.card-header {
    padding: .75rem 1.25rem;
    margin-bottom: 0;  
    border-bottom: 0px solid rgba(0,0,0,.125);
    }
	.card-footer {
    padding: .75rem 1.25rem;
    margin-bottom: 0;
    background:none !important;
    border-bottom: 0px solid rgba(0,0,0,.125);
    }
	.card-footer a
	{
		font-size:20px;
		width: 40px;
		height: 40px;
		min-width: 40px;
		margin-right:15px;
		color:#4285f4;
	}
	
	.card-footer a:hover {
       color: #4285f4;
	  
    }

</style>
<div id="" style="background:#f5f7f9;">
    <div>
        <div id="about">
            <div class="lp-about">
                <div role="toolbar" dir="ltr" class="next-slick next-slick-inner next-slick-hoz">
                    <div class="next-slick-container next-slick-initialized">
                        <div class="next-slick-list">
                            <div class="next-slick-track"
                                style="opacity: 1; width: 4047px; transform: translate3d(0px, 0px, 0px);">
                                <div class="next-slick-slide next-slick-active slider-img-wrapper"
                                    data-spm="inspection_header-header-area" data-index="-1" style="width: 1349px;"><img
                                        src="<?php echo base_url();?>assets/front/images/banner/address.png"
                                        alt="inspetion service is a solution to your worries"
                                        data-spm="inspection_header-img">
                                    <div class="main-slider-wrapper">
                                        <div class="w-1000">
                                            <h1 style="color:#fff;">Your address Book</h1>
                                            <h1  style="color:#fff;" >Inspection Services</h1>
                                            <div class="" style="text-align:left; color:#fff; font-size:16px;padding-top:15px;">
                                              Manage your address book </div>
                                        </div>
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                </div>
                <div class="ab-ways container" id="advantages">
                    <br />
                    <nav>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?php echo site_url();?>">Home</a></li>
                            <li class="breadcrumb-item"><a href="<?php echo site_url();?>buyer-dashboard">Buyer</a></li>
                            <li class="breadcrumb-item active">Address List</li>
                        </ol>
                    </nav>
                    <h2>Your address</h2>
                    <div class="next-tabs next-tabs-capsule next-medium">
                        <?php echo $this->session->flashdata("message");?>
                        <div class="row">
                            <div class="col-4">

                                <div class="card">
                                    <div class="card-header text-left">
                                        &nbsp;
                                    </div>
                                    <div class="card-body" style="min-height:200px; display: table;">
                                        <a href="<?php echo site_url();?>buyer/addressbook/addnew" style="vertical-align: middle; display: table-cell;">
                                           <i class="icon ion-android-add" style="font-size:60px;"></i>
                                        </a>
                                    </div>
                                    <div class="card-footer text-left">
                                            <a href="#">Create New</a>
                                    </div>
                                </div>
                            </div>
                            <?php $i = 1; foreach($addresses as $address):?>
                            <div class="col-4">
                                <div class="card" style="margin-bottom: 20px;">
                                    <div class="card-header text-left">
                                    <?php echo ($address->is_default)?"Default":"Not Default"; ?>
                                    </div>
                                    <div class="card-body" style="min-height:200px;">
                                        <ul class="text-left">
                                            <li><strong><?php echo $address->contact_person;?>,</strong></li>
                                            <li><?php echo $address->street;?>,<?php echo $address->city;?></li>
                                            <li><?php echo $address->state;?></li>
                                            <li><?php echo $address->postcode;?></li>
                                            <li><?php echo $address->name;?></li>
                                            <li>Phone : <?php echo $address->contact_number;?></li>
                                        </ul>
                                        
                                    </div>
                                    <div class="card-footer text-left">
                                        <a href="<?php echo site_url('buyer/addressbook/edit/').$address->address_book_id;?>" title="Edit"><i class="icon ion-android-create"></i></a>  
                                        <a href="<?php echo site_url('buyer/addressbook/remove/').$address->address_book_id;?>" onclick="return confirm('Are you sure you want to delete this item?');" title="Delete"><i class="icon ion-android-delete"></i></a>  
                                        <?php if(!$address->is_default) { ?> 
                                        <a href="<?php echo site_url('buyer/addressbook/setdefault/').$address->address_book_id;?>" title="Set As Default" style="font-size: 14px;">Set As Default</a>
                                        <?php } ?>

                                    </div>
                                </div>
                            </div>
                            <?php $i++; endforeach;?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <br />
        
    </div>
</div>

<?php $this->load->view('front/common/footer'); ?>