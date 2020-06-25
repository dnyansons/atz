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
                           <h4>Add Banks</h4>
                        </div>
                     </div>
                  </div>
                  <div class="col-lg-4">
                     <div class="page-header-breadcrumb">
                        <ul class="breadcrumb-title">
                           <li class="breadcrumb-item">
                              <a href="<?php echo site_url();?>admin/dashboard"> <i class="feather icon-home"></i> </a>
                           </li>
                           <li class="breadcrumb-item"><a href="<?php echo site_url();?>admin/agent_management">Bank</a></li>
                           <li class="breadcrumb-item"><a href="#!">Add Bank</a></li>
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
                        <div class="card-block">
                            <form method="post" enctype="multipart/form-data" action="<?php echo site_url('admin/banks/addBank');?>">
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Bank Name</label>
                                    <div class="col-sm-10">
                                        <input type="text" name="bank_name" id="admin_firstname" class="form-control" placeholder="Enter Bank Name" required value="<?php echo set_value('admin_firstname');?>">
                                       <?php echo form_error("bank_name");?>
                                    </div>
                                </div>
                              <button type="submit" id="submit_brand" class="btn btn-primary pull-right" id="primary-popover-content">Add Bank</button>
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
<script>

</script>
<?php $this->load->view("admin/common/footer");?>