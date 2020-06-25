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
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-block">
                                    <div class="row">
                                        <div class="col-md-2">
                                            <label class="control-label">Agent Id</label>
                                        </div>
                                        <div class="col-md-2">
                                            From date
                                        </div>
                                        <div class="col-md-2">
                                            End date
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-2">
                                            <input type="text" id="admin_id" name="admin_id" placeholder="Agent id" class="form-control">
                                        </div>
                                        <div class="col-md-2">
                                            <input type="text" id="start_date" name="start_date" class="form-control">
                                        </div>
                                        <div class="col-md-2">
                                            <input type="text" id="end_date" name="end_date" class="form-control">
                                        </div>
                                        <div class="col-md-2">
                                            <button class="btn btn-info btn-sm" id="btn-filter">Filter</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="card">
                                <div class="card-header">
                                    <?php echo $pageTitle;?>
                                    <?php if($status){?>
                                    <a class="pull pull-right btn btn-sm btn-info" href="<?php echo site_url();?>admin/agent_management/createNew">
                                        Add new
                                    </a>
                                    <?php } ?>
                                </div>
                                <div class="card-block">
                                    <div class="dt-responsive table-responsive">
                                        <?php echo $this->session->flashdata("message");?>
                                        <table id="table_agents" class="table table-striped table-bordered nowrap">
                                            <thead>
                                                <tr>
                                                    <th>Agent Id</th>
                                                    <th>Name</th>
                                                    <th>Agent Role</th>
                                                    <th>Email</th>
                                                    <th>Telephone</th>
                                                    <th>Status</th>
                                                    <th>Permissions</th>
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
    table = $('#table_agents').DataTable({ 
 
        processing: true,
        serverSide: true,
        order: [],
        
        ajax: {
            url: "<?php echo site_url('admin/agent_management/ajax_list')?>",
            type: "POST",
            data: function ( data ) {
                data.admin_id = $('#admin_id').val();
                data.start_date = $('#start_date').val();
                data.end_date = $('#end_date').val();
                data.status = "<?php echo $status;?>";
            }
        },
        columnDefs: [
        { 
            targets: [ 1,2,3,4 ], 
            orderable: false, 
        },
        ],
        searching: false,
        
    });
 
    $('#btn-filter').click(function(){ 
        table.ajax.reload();  
    });
    
    
    $("#start_date").dateDropper({
        format:"d-m-Y",
        dropWidth: 200,
        dropPrimaryColor: "#1abc9c",
        dropBorder: "1px solid #1abc9c",
        maxYear: "2020",
    });
    $("#end_date").dateDropper({
        format:"d-m-Y",
        dropWidth: 200,
        dropPrimaryColor: "#1abc9c",
        dropBorder: "1px solid #1abc9c",
        maxYear: "2020",
    });
    
    $(document).on("click",".btn-activate",function(){
        var a = $(this).attr("data-aid");
        console.log(a);
        $.ajax({
            url : "<?php echo site_url();?>admin/agent_management/activate_agent",
            data : {admin_id : a},
            type : "POST",
            success : function(resp){
                console.log(resp);
                table.draw();
            }
        });
    });
    
    $(document).on("click",".btn-deactivate",function(){
        var a = $(this).attr("data-aid");
        console.log(a);
        $.ajax({
            url : "<?php echo site_url();?>admin/agent_management/deactivate_agent",
            data : {admin_id : a},
            type : "POST",
            success : function(resp){
                console.log(resp);
                table.draw();
            }
        });
    });
    
});
</script>