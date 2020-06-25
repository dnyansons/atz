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
                                    <h4>InActive Agents</h4>	
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
                                    <li class="breadcrumb-item">InActive Agents</li>
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
                                    <h5>InActive Agents</h5>
			                                    			
                                </div>
                                <div class="card-block">
                                    <div class="dt-responsive table-responsive">
                                        <table id="active_agents" class="table table-striped table-bordered nowrap">
                                            <thead>
                                                <tr>
                                                    <th>Agent Id</th>
                                                    <th>Name</th>
													<th>Agent Role</th>
                                                    <th>Gender</th>
                                                    <th>Last Login</th>
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
<script>
   $(function () {
        $('#active_agents').DataTable({
		  "aaSorting": [],
          "paging": true,
          "lengthChange": true,
          "searching": true,
          "ordering": true,
          "info": true,
          "autoWidth": false
        });
      });
</script>

 <script>
	$(document).ready(function() {
		var oTable = $('#active_agents').dataTable();
		$.ajax({
			url: '<?php echo site_url("admin/agent_management/get_inactive_agents");?>',
			dataType: 'json',
			success: function(s){
				console.log(s);
				oTable.fnClearTable();
				for(var i = 0; i <s.length; i++) {
				oTable.fnAddData([
						s[i]['admin_id'],
						s[i]['admin_firstname']+' '+s[i]['admin_lastname'],
						s[i]['admin_role'],
						s[i]['admin_gender'],
						s[i]['date_modified'],
						'&nbsp;&nbsp;&nbsp;<a href="<?php echo base_url('admin/agent_management/inactive_agents_history'); ?>/' + s[i]['admin_id'] + '" ><button class="btn btn-primary btn-sm" >History </button></a> '
						  ]);										
					}
			},
		error: function(e){
			}
		});
	 });
</script>

<?php $this->load->view("admin/common/footer");?>
