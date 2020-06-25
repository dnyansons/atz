<?php $this->load->view("user/common/header");?>

<div class="pcoded-content">
   <div class="pcoded-inner-content">
      <div class="main-body">
         <div class="page-wrapper">
            <div class="page-header">
               <div class="row align-items-end">
                  <div class="col-lg-8">
                     <div class="page-header-title">
                        <div class="d-inline">
                           <h4>View Company Certificates and License</h4>
                        </div>
                     </div>
                  </div>
                  <div class="col-lg-4">
                     <div class="page-header-breadcrumb">
                        <ul class="breadcrumb-title">
                           <li class="breadcrumb-item">
                              <a href="<?php echo site_url();?>admin/dashboard"> <i class="feather icon-home"></i> </a>
                           </li>
                           <li class="breadcrumb-item"><a href="<?php echo base_url('user/companyprofile/company_documents/');?>">Company Doc & Certificates </a></li>
                           <li class="breadcrumb-item"><a href="#!">View</a></li>
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
                                <h5> Title :  <?php echo $record['title'];?></h5>
                            </div>
                        <div class="card-block">
                            <div class="default-grid row">
                                <?php if(!empty($files)){ foreach($files as $file){?>
                                    <div class="col-lg-3 col-md-6 default-grid-item">
                                        <div class="card gallery-desc">
                                            <div class="masonry-media">
                                                <a class="media-middle" href="#!">
                                                    <img class="img-fluid" src="<?php echo base_url('uploads/company_docs/'.$file);?>" alt="<?php echo $file;?>">
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                <?php } } ?>
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
</div>
</div>
</div>
</div>

<?php $this->load->view("user/common/footer");?>