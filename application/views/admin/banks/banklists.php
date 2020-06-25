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
                                    <h4><?php echo $pageTitle; ?></h4>	
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
                                    <li class="breadcrumb-item"><?php echo $pageTitle; ?></li>
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
                                    <?php echo $pageTitle;?>
                                    <?php if($status){?>
                                    <a class="pull pull-right btn btn-sm btn-info" href="<?php echo site_url();?>admin/banks/addBank">
                                        Add New Bank
                                    </a>
                                    <?php } ?>
                                </div>
                                <div class="card-block">
                                    <div class="dt-responsive table-responsive">
                                        <?php echo $this->session->flashdata("message");?>
                                        <table id="bank_list" class="table table-striped table-bordered nowrap">
                                            <thead>
                                                <tr>
                                                    <th>Bank Id</th>
                                                    <th>Name</th>
                                                    <th>Status</th>
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
$(document).ready(function(){
    table = $('#bank_list').DataTable({ 
        processing: true,
        serverSide: true,
        order: [],
        
        ajax: {
            url: "<?php echo site_url('admin/banks/ajax_list')?>",
            type: "POST"
        },
        columnDefs: [
        { 
            targets: [ ], 
            orderable: false 
        }
        ],
        searching: false
        
    });
});
</script>