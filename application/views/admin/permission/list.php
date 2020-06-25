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
                                    <h4>User Permission</h4>
                                    <span></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="page-header-breadcrumb">
                                <ul class="breadcrumb-title">
                                    <li class="breadcrumb-item">
                                        <a href="<?php echo site_url();?>admin/dashboard"> <i class="feather icon-home"></i> </a>
                                    </li>
                                    <li class="breadcrumb-item"><a href="#">User List</a></li>
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
                                   
									<a href="<?php echo base_url(); ?>admin/permission/adduser">
                                    <button type="button" class="btn btn-primary waves-effect waves-light f-right d-inline-block md-trigger" data-modal="modal-13"> <i class="icofont icofont-plus m-r-5"></i> Add User
                                    </button>
                                    </a>
                                </div>
                                <div class="card-block">
                                    <div class="dt-responsive table-responsive">
                                        <?php echo $this->session->flashdata('message'); ?>
                                        <table id="permissionTable" class="table table-striped table-bordered nowrap">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Username</th>
                                                    <th>Name</th>
                                                    <th>Role</th>
                                                    <th>Email</th>
													<th>Mobile</th>
                                                    <th>Status</th>
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
<?php $this->load->view("admin/common/footer");?>


<script>
 $(document).ready(function () {
    
    $('#permissionTable').DataTable({
        processing: true,
        serverSide: true,
        ajax:{
                 url: "<?php echo base_url('admin/permission/ajax_list') ?>",
                 dataType: "json",
                 type: "POST",
                 data:{  '<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>' } },
                 columns: [
                      { data: "admin_id" },
                      { data: "admin_username" },
                      { data: "admin_firstname" },
                      { data: "role_name" },
                      { data: "admin_email" },
                      { data: "admin_telephone" },
                      { data: "admin_status" },
                      
                      { data: "action" }
                   ]     

        });
});
</script>