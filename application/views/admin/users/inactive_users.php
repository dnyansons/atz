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
                                    <h4>Inactive Users</h4>
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
                                    <li class="breadcrumb-item"><a href="#">Inactive Users List</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="page-body">
					
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group row">
                                            <div class="col-sm-6">
                                            <select name="filter_role_id" id="filter_role_id" class="form-control">
                                                                        <option value="0">All</option>
                                                                        <option value="both">Both</option>
                                                                        <option value="buyer">Buyer</option>
                                                                        <option value="seller">Seller</option>
                                                                </select>
                                        </div>
                                        <div class="col-sm-6">
                                        <button type="button" id="button-filter" class="btn btn-info">
                                            <i class="fa fa-filter"></i> Filter
                                        </button>
                                        </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
			       <?php echo $this->session->flashdata('message'); ?>
                            <div class="card">
							
                                <div class="card-block">
                                    <div class="dt-responsive table-responsive">
                                        <table id="userTable" class="table table-striped table-bordered nowrap">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>User Name </th>
                                                    <th>Email Address</th>
                                                    <th>Phone</th>
                                                    <th>Role</th>
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


<div class="modal fade" id="active_inactive_modal" tabindex="-1" role="dialog" style="z-index: 1050; display: none;" aria-hidden="true">
<div class="modal-dialog" role="document">
<div class="modal-content">
<div class="modal-header">
<h5 class="modal-title">User Status</h5>
<button type="button" class="close" data-dismiss="modal" aria-label="Close">
<span aria-hidden="true">×</span>
</button>
</div>
<div class="modal-body">
<p>Are you sure to change this user status?</p>
</div>
<div class="modal-footer">
<button type="button" id="no_btn" class="btn btn-default waves-effect " data-dismiss="modal">No</button>
<button type="button" id="yes_btn" class="btn btn-primary waves-effect waves-light ">Yes</button>
</div>
</div>
</div>
</div>


<?php $this->load->view("admin/common/footer");?>
<script>

$(document).ready(function () {
		    	
	var dataTable =  $('#userTable').DataTable( {
		processing:true,
		serverSide: true,
		"ajax": {
			"url": "<?php echo base_url('admin/users/ajax_inactive_user_list'); ?>",
			"type": "POST",
			"data":function(data) {
				data.filter_role_id = $('#filter_role_id').val();
				data.<?php echo $this->security->get_csrf_token_name(); ?> = "<?php echo $this->security->get_csrf_hash(); ?>";
				//console.log(data);
			},
		},
		"columnDefs": [
			{ className: "dropdown", "targets": [ 5 ] }
		]
		
	} );
	
	$('#button-filter').on( 'click change', function (event) {
		//event.preventDefault();
		dataTable.draw();
	} );

});

</script>

<script type="text/javascript">
    

  $('#active_inactive_modal').on('show.bs.modal', function(e) {
        
    var user_id = $(e.relatedTarget).data('user_id');
    var status = $(e.relatedTarget).data('status');

        $("#yes_btn").click(function(){
           
              $.ajax({
                url:"<?php echo base_url(); ?>admin/users/updateUserStatus",
                type:"POST",
                data:{user_id:user_id, status:status},
                dataType:"json",
                success:function(response){
                   if(response.status=="success")
                   {
                      location.reload();
                   }

                   else
                   {
                      location.reload();
                   }
                }
             });

        });

   });


</script>