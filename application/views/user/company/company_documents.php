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
                                    <h4>Company Certificates and License</h4>
                                    <span></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="page-header-breadcrumb">
                                <ul class="breadcrumb-title">
                                    <li class="breadcrumb-item">
                                        <a href="<?php echo site_url();?>seller/dashboard"> <i class="feather icon-home"></i> </a>
                                    </li>
                                    <li class="breadcrumb-item"><a href="#">Company Certificates and License List</a></li>
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
				    <a href="<?php echo base_url(); ?>seller/companyprofile/upload_documents">
                                        <button type="button" class="btn btn-primary waves-effect waves-light f-right d-inline-block md-trigger"> <i class="icofont icofont-plus m-r-5"></i> Upload documents
                                        </button>
                                    </a>
                                </div>
                                <h6 style="text-align:center;"><?php echo $this->session->flashdata('message'); ?></h6>
                         <?php  
                       
                         if($seller_docs[0]['document_verify_status']=='rejected') 
                                {

                $msg = "<div class='alert alert-danger alert-dismissible'>
                    <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                    <strong>Error!</strong> Your document has been rejected.Please the Re-Upload Document. 
                  </div>";
            $this->session->set_flashdata("message", $msg);  

                                }
                            ?>
                                <div class="card-block">
                                    <div class="dt-responsive table-responsive">
                                    <table id="couponTable" class="table table-striped table-bordered nowrap">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Title</th>
                                                    <th>Date Created</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
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
<?php $this->load->view("user/common/footer");?>


<script>
 $(document).ready(function () {
    
    $('#couponTable').DataTable({
        processing: true,
        serverSide: true,
        ajax:{
                 url: "<?php echo base_url('seller/companyprofile/ajax_list') ?>",
                 dataType: "json",
                 type: "POST",
                 data:{  '<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>' } },
                 columns: [
                      { data: "id" },
                      { data: "title" },
                      { data: "date_created" },
                      { data: "action" }
                   ]     

        });
});
</script>