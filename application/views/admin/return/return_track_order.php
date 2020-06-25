<?php $this->load->view("admin/common/header"); ?>
<div class="pcoded-content">
    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-header">
                    <div class="row align-items-end">
                        <div class="col-lg-8">
                            <div class="page-header-title">
                                <div class="d-inline">
                                    <h4>Return Track Order ( Return Order ID : ORD<?php echo $order_id; ?>)</h4>
                                    <span></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="page-header-breadcrumb">
                                <ul class="breadcrumb-title">
                                    <li class="breadcrumb-item">
                                        <a href="<?php echo site_url(); ?>user/dashboard"> <i class="feather icon-home"></i> </a>
                                    </li>
                                    <li class="breadcrumb-item"><a href="#">Return Track Orders</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
               

<div class="card">
                    
                        
								<div class="row">
   <div class="col-sm-12">
      <div class="card">
         
         <div class="card-block">
            <div class="main-timeline">
               <div class="cd-timeline cd-container">
			    <?php	  
					foreach($hist_dat as $row)
					{ ?>
                  <div class="cd-timeline-block">
                     <div class="cd-timeline-icon bg-primary">
                       <img src="<?php echo base_url() ?>assets/images/down-arrow.png" style="margin-top: 4px;">
                     </div>
					
                     <div class="cd-timeline-content card_main">
                        <img src="<?php echo base_url(); ?>assets/images/timeline/img1.jpg" class="img-fluid width-100" alt="" />
                        <div class="p-20">
                           <h6><?php echo $row->status; ?></h6>
                           <div class="timeline-details">
                              <a href="#"><span><?php echo $row->date_added; ?></span> </a>
                             
                              <p class="m-t-10"><?php echo $row->comment; ?>
                              </p>
                           </div>
                        </div>
                        <span class="cd-date"><?php echo $row->status; ?></span>
                        <span class="cd-details"><?php echo $row->date_added; ?></span>
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
                </div>
                </div>

               

<?php $this->load->view("admin/common/footer"); ?>
