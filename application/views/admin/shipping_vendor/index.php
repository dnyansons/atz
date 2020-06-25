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
                                    <h4>Shipping Vendors</h4>	
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
                                    <li class="breadcrumb-item">Shipping Vendors</li>
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
                                    <h5>Shipping Vendors Table</h5>
                                        
<!--                                        <a href="<?php //echo base_url(); ?>admin/shipping_vendor/add">
                                            <button type="button" class="btn btn-primary waves-effect waves-light f-right d-inline-block md-trigger" data-modal="modal-13"> <i class="fa fa-plus"></i> Add 
                                            </button>
                                        </a>-->
                                   
                                </div>
                                <div class="card-block">
                                     <center>
                                            <?php if ($this->session->flashdata('success') != ''){?>
                                                    <div class='alert alert-success alert-dismissible'>
                                                       <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                                                       <?php echo $this->session->flashdata('success'); ?>
                                                    </div>
                                            <?php } ?>	

                                            <?php if ($this->session->flashdata('error') != ''){?>
                                                    <div class='alert alert-danger alert-dismissible'>
                                                       <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                                                       <?php echo $this->session->flashdata('error'); ?>
                                                    </div>
                                            <?php } ?>	
                                        </center>
                                    <div class="dt-responsive table-responsive">
                                        <table id="event_tbl" class="table table-striped table-bordered nowrap">
                                            <thead>
                                                <tr>
                                                    <th>Vendor ID</th>
						    <th>Vendor Name</th>
<!--                                                    <th>Contract Start Date</th>
						    <th>Contract End Date</th>-->
                                                    <th>Is Default ?</th>
                                                    <th>Shippment</th>
                                                    <th>On Amount( If Free )</th>
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
                url: "<?php echo base_url('admin/shipping_vendor/ajax_get_shipping_vendors'); ?>",
                dataType: "json",
                type: "POST",
                data:{  '<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>' } },
                columns: [
                    { data: "id"},
                    { data: "vendor_name"},
                    //{ data: "contract_start_date"},
                    //{ data: "contract_end_date"},
                    { data: "is_default"},
                    { data: "shipping_type"},
                    { data: "free_amount"},
                    { data: "action"}
                ]
        });
});
</script>
