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
                                    <h4>
                                        <?php echo $pageTitle;
                                        $title = strtolower(str_ireplace(" ", '_', $pageTitle));
                                        $pg_title = str_ireplace("/", '_', $title)
                                        ?>
                                        <a href="<?php echo base_url('admin/vendors/download_excel/'. $pg_title); ?>" class="btn btn-sm btn-success">Download Excel</a>
                                    </h4>	
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
                                    <li class="breadcrumb-item">
                                        <?php echo $pageTitle;?>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="page-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <?php echo $this->session->flashdata("message");?>
                            <div class="card">
                                <div class="card-header">
                                    <table class="table table-striped table-bordered" id="tblSellerList">
                                        <thead>
                                            <tr>
                                                <th>Id</th>
						<th>Registered date</th>
                                                <th>Name</th>
                                                <th>Email</th>
                                                <th>Mobile</th>
                                                <th>Company</th>
                                                <th>Banned Reason</th>
                                                <th>Actions</th>
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


<!--Remove \ Unban Modal-->
<div class="modal fade" id="unBanModal" tabindex="-1" role="dialog" style="z-index: 1050; display: none;" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title ban-title">Ban Manager</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body" id="unBanModalData">
                
            </div>
            <div class="modal-footer">
                <button type="button" id="ban_no_btn" class="btn btn-default waves-effect " data-dismiss="modal">Cancel</button>
                <button type="button" id="unban_yes_btn" class="btn btn-success waves-effect waves-dark text-dark" data-dismiss="modal" >Remove Ban!</button>
            </div>
        </div>
    </div>
</div>


<?php $this->load->view("admin/common/footer");?>

<script>
$(document).ready(function(){

    var sellerDataTable = $("#tblSellerList").dataTable({
        processing: true,
        serverSide: true,
        searching:true,
        ajax:{
            url : "<?php echo site_url('admin/vendors/getBannedVendors');?>",
            dataType : "json",
            type : "post",
        },
        scrollX: true
    });

});


// for showing modal of remove / unbanning users

$(document).on("click", ".open-unban-events", function () {
     var eventId = $(this).data('id');
	 $('#unBanModalData').html(eventId);
});

// for banning users in a script
$(document).ready(function(){
	$("#unban_yes_btn").click(function(){
		$.post( "<?php echo base_url('admin/users/un_ban_user'); ?>", 
		{ user_id: $("#ban_id").val() } )
        .done(function( data ) {
             location.reload(true);
        });
	});
});

</script>
