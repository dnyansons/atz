<?php $this->load->view("user/common/header");?>
<style type="text/css">
 body {font-family: Arial, Helvetica, sans-serif;}

#myImg {
  border-radius: 5px;
  cursor: pointer;
  transition: 0.3s;
}

#myImg:hover {opacity: 0.7;}

/* The Modal (background) */
.modal {
  display: none; /* Hidden by default */
  position: fixed; /* Stay in place */
  z-index: 1; /* Sit on top */
  padding-top: 100px; /* Location of the box */
  left: 0;
  top: 0;
  width: 100%; /* Full width */
  height: 100%; /* Full height */
  overflow: auto; /* Enable scroll if needed */
  background-color: rgb(0,0,0); /* Fallback color */
  background-color: rgba(0,0,0,0.9); /* Black w/ opacity */
}

/* Modal Content (image) */
.modal-content {
  margin: auto;
  display: block;
  width: 80%;
  max-width: 700px;
}

/* Caption of Modal Image */
#caption {
  margin: auto;
  display: block;
  width: 80%;
  max-width: 700px;
  text-align: center;
  color: #ccc;
  padding: 10px 0;
  height: 150px;
}

/* Add Animation */
.modal-content, #caption {  
  -webkit-animation-name: zoom;
  -webkit-animation-duration: 0.6s;
  animation-name: zoom;
  animation-duration: 0.6s;
}

@-webkit-keyframes zoom {
  from {-webkit-transform:scale(0)} 
  to {-webkit-transform:scale(1)}
}

@keyframes zoom {
  from {transform:scale(0)} 
  to {transform:scale(1)}
}

/* The Close Button */
.close {
  position: absolute;
  top: 15px;
  right: 35px;
  color: #f1f1f1;
  font-size: 40px;
  font-weight: bold;
  transition: 0.3s;
}

.close:hover,
.close:focus {
  color: #bbb;
  text-decoration: none;
  cursor: pointer;
}

/* 100% Image Width on Smaller Screens */
@media only screen and (max-width: 700px){
  .modal-content {
    width: 100%;
  }
}

#myImg {
	height: 100px;
}

#overlay {
	position: fixed;
	top: 0;
	left: 0;
	width: 100%;
	height: 100%;
	background: rgba(0, 0, 0, 0.8) none 50% / contain no-repeat;
	cursor: pointer;
	transition: 0.3s;
	visibility: hidden;
	opacity: 0;
        z-index:99999;
        background-size:50%;
}

#overlay img {
    width: 60%;
    height: 60%;
}

#overlay.open {
	visibility: visible;
	opacity: 1;
}

#overlay:after {
	/* X button icon */
	content: "\2715";
	position: absolute;
	color: #fff;
	top: 10px;
	right: 20px;
	font-size: 2em;
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
                           <h4>View Company Certificates and License</h4>
                        </div>
                     </div>
                  </div>
                  <div class="col-lg-4">
                     <div class="page-header-breadcrumb">
                        <ul class="breadcrumb-title">
                           <li class="breadcrumb-item">
                              <a href="<?php echo base_url() ?>seller/dashboard"> <i class="feather icon-home"></i> </a>
                           </li>
                           <li class="breadcrumb-item"><a href="<?php echo base_url('seller/companyprofile/company_documents/');?>">Company Doc & Certificates </a></li>
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
                                <?php 
                                if(!empty($files)){ foreach($files as $file){
                                    
                                         $dat=explode('.',$file);
                                         
                                  ?>

                                    <div class="col-lg-6 col-md-6 default-grid-item">
                                       
                                            <?php if($dat[5]=='pdf'){ 
                                                
                                                ?>
                                          <div class="card gallery-desc">
                                            <div class="masonry-media">
                                            
                                                
                                                 <a href="<?php echo $file;?>" data-toggle="roadtrip">

                                          <img src="<?php echo base_url();?>assets/admin/icon/pdficon.svg" style="width:60px;height:60px" class="img-fluid m-b-10"> 
                                          </a> 
                                            </div>
                                          </div>
                                              <?php }else {
                                                 
                                                  ?>
                                                 <div class="card gallery-desc">
                                                  <div class="masonry-media">
                                                     
                                                      
                                                <a href="#"><img id="myImg" class="myImg" src="<?php echo $file;?>" alt="<?php echo $file;?>" alt="docs" height ="70px" width ="70px" >
                                                     
                                                </a>
                                            </div>
                                          </div>
                                              
                                        <!-- <div class="row"><?php echo $file; ?></div> -->
                                    </div>

                                                        <?php } } } ?>
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
<div id="overlay"></div>
<?php $this->load->view("user/common/footer");?>
<script type="text/javascript">
  
  function update_status(status) {
      var con = confirm('Are you confirm to Update User ?');
      if (con == true) {
          var user_id = '<?php echo $company->user_id; ?>';
  
          $.ajax({
              type: 'POST',
              url: '<?php echo base_url(); ?>admin/users/update_appr_status/',
              data: {
                  'status': status,
                  'user_id': user_id
              },
              success: function(data) {
  
                  alert('Status Update Successfully');
                  location.reload();
  
              },
              error: function() {
                  alert('Error !');
              }
          });
      } else {
          location.reload();
      }
  } 
 
// Image to Lightbox Overlay $('img').on('click', function() { $('#overlay') .css({backgroundImage: `url(${this.src})`}) .addClass('open') .one('click', function() { $(this).removeClass('open'); }); });
$('.myImg').on('click', function() {
    $('#overlay').css({
        backgroundImage: `url(${this.src})`
    }).addClass('open').one('click', function() {
        $(this).removeClass('open');
    });
});

</script>