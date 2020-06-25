<?php $this->load->view("admin/common/header");?>
<div class="pcoded-content">
   <div class="pcoded-inner-content">
      <div class="main-body">
         <div class="page-wrapper">
            <div class="page-header">
               <div class="row align-items-end">
                  <div class="col-lg-8">
                     <div class="page-header-title">
                        <div class="d-inline">
                           <h4>Upload Company Certificates and License</h4>
                        </div>
                     </div>
                  </div>
                  <div class="col-lg-4">
                     <div class="page-header-breadcrumb">
                        <ul class="breadcrumb-title">
                           <li class="breadcrumb-item">
                              <a href="<?php echo site_url();?>admin/dashboard"> <i class="feather icon-home"></i> </a>
                           </li>
                           <li class="breadcrumb-item"><a href="<?php echo site_url('admin/vendor_management/pending_approval_vendors');?>">Users</a></li>
                           <li class="breadcrumb-item"><a href="<?php echo site_url('admin/seller/profile/'.$user_id); ?>">profile</a></li>
                           <li class="breadcrumb-item"><a href="#!">Upload Document</a></li>
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
                           <div class="card-header-right">
                              <i class="icofont icofont-spinner-alt-5"></i>
                           </div>
                        </div>
                  <h6 style="text-align:center;"><?php echo $this->session->flashdata('message'); ?></h6>
                        <div class="card-block">
                            <form method="post" enctype="multipart/form-data">
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Certificate Title</label>
                                    <div class="col-sm-10">
                                      <input type="text" autocomplete="off" name="certificate_title" id="certificate_title" class="form-control" placeholder="Certificate Title" required style="width:350px;">
                                    </div>
                                </div>
				<div class="form-group row image_wrapper ">
                                    <label class="col-2 col-form-label">Select File</label>
                                    <div class="image_wrapper ">                                        
                                        <div class="col-12">
                                            <div class="input-group">
                                                <input type="file" name="files" class="form-control" style="width:350px;">
                                                
                                            </div>
                                            <p>Allowed types are Jpg | Png | Pdf.</p>
                                        </div>                                         
                                    </div>
                                </div>
                                <input type="hidden" name="user_id" value="<?php echo $user_id;?>">
                                <button type="submit" name="submit" value="submit" id="submit_brand" class="btn btn-primary pull-right" id="primary-popover-content">Add</button>
                            </form>
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
<?php $this->load->view("admin/common/footer");?>
<script>
    $(document).ready(function(){
        var i = 0;
        $(document).on('click','.add_more',function(){
            var file_count = $('.image').length;
           
            if(file_count <= 2){
                var image = '<div style="width: 34.6%; margin-left: 18%;" class="image"> <div class="input-group"><input type="file" name="files[]" class="form-control" required><button type="button" class="btn btn-danger btn-sm cancel"><i class="fa fa-times fa-2x"></i></button></div> </div>';
                $(this).closest('.image_wrapper').after(image);
            }else{
                alert('You Can upload maximum 4 images');
            }
            
       });
       $(document).on('click','.cancel',function(){
           $(this).closest('.image').remove();
       });
    });
</script>
