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
                                    <h4>App Banner</h4>	
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
                                    <li class="breadcrumb-item">App Banner</li>
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
                                    <h5>App Banner Table</h5>
                                        <a href="<?php echo base_url(); ?>admin/app_banner/add">
                                        <button type="button" class="btn btn-primary waves-effect waves-light f-right d-inline-block md-trigger" data-modal="modal-13"> <i class="fa fa-plus"></i> Add 
                                        </button>
                                    </a>				
                                </div>
                                <div class="card-block">
                                    <div class="dt-responsive table-responsive">
                                        <?php echo $this->session->flashdata("message");?>
                                        <table id="event_tbl" class="table table-striped table-bordered nowrap">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
						    <th>Image</th>
                                                    <th>Type</th>
                                                    <th>Placed</th>
						    <th>Status</th>
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
<?php $this->load->view("admin/common/footer");?>
<script>
 $(document).ready(function() {
     
    $('#event_tbl').DataTable({
       //console.log('dsfhsddddd');
        processing: true,
        serverSide: true,
        ajax:{
                url: "<?php echo base_url('admin/app_banner/ajax_get_app_banners'); ?>",
                dataType: "json",
                type: "POST",
                data:{  '<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>' } },
                columns: [
                    { data: "id"},
                    { data: "image"},
                    { data: "type"},
                    { data: "image_placed"},
                    { data: "date_created"},
                    { data: "status"},
                    { data: "action"}
                ]
        });
});
</script>

