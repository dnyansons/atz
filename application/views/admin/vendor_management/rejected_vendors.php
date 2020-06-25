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
                                    <h4>Rejected Vendors</h4>	
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
                                    <li class="breadcrumb-item">Rejected Vendors</li>
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
                                    <h5>Approved Vendors Table</h5>
                                        <center>
                                                <?php if ($this->session->flashdata('message') != ''){
                                                     echo $this->session->flashdata('message');
                                                }?>
                                                 
                                        </center>
                                       			
                                </div>
                                <div class="card-block">
                                    <div class="dt-responsive table-responsive">
                                        <table id="event_tbl" class="table table-striped table-bordered nowrap">
                                            <thead>
                                                <tr>
                                                    <th>Seller ID</th>
                                                    <th>Name</th>
						    <th>Email</th>
                                                    <th>Mobile</th>
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
<script>
 $(document).ready(function() {
     
    $('#event_tbl').DataTable({
       //console.log('dsfhsddddd');
        processing: true,
        serverSide: true,
        ajax:{
                url: "<?php echo base_url('admin/vendor_management/ajax_rejected_vendors'); ?>",
                dataType: "json",
                type: "POST",
                data:{  '<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>' } },
                columns: [
                    { data: "id"},
                    { data: "name"},
                    { data: "email"},
                    { data: "mobile"}
                ]
        });
});
</script>
<?php $this->load->view("admin/common/footer");?>
