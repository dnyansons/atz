
<div class="pcoded-content">
    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-header">
                    <div class="row align-items-end">
                        <div class="col-lg-8">
                            <div class="page-header-title">
                                <div class="d-inline">
                                    <h4>Return/Refund Reasons</h4>
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
                                    <li class="breadcrumb-item"><a href="#">Return/Refund Reason List</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="page-body">
                    <div class="row">
                        <div class="col-sm-12">

                            <div class="card">
							<h6 style="text-align:center;"><?php echo $this->session->flashdata('message'); ?></h6>
                                <div class="card-header">
                                   
									<a href="<?php echo base_url(); ?>admin/refund_reason/add_reason">
                                    <button type="button" class="btn btn-primary waves-effect waves-light f-right d-inline-block md-trigger" data-modal="modal-13"> <i class="icofont icofont-plus m-r-5"></i> Add Reason
                                    </button>
                                    </a>
                                </div>
                                <div class="card-block">
                                    <div class="dt-responsive table-responsive">
                                        <table id="refund" class="table table-striped table-bordered nowrap">
                                            <thead>
                                                <tr>
                                                    <th>Sr.No</th>				
                                                    <th>Reason</th>
						    <th>Status</th>
                                                    <th>Created Date</th>
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
        $('#security').DataTable({
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
		var oTable = $('#refund').dataTable();
		$.ajax({
			url: '<?php echo site_url("admin/refund_reason/ajax_list");?>',
			dataType: 'json',
			success: function(s){
				console.log(s);
				oTable.fnClearTable();
				var count = 0;
				for(var i = 0; i <s.length; i++) {
				count++;
				oTable.fnAddData([
						count,
						s[i]['reason_name'],
						s[i]['status'],
						s[i]['created_at'],
						'&nbsp;&nbsp;&nbsp;<a href="<?php echo base_url('admin/refund_reason/edit_reason');?>/'+s[i]['reason_id']+'" class="tabledit-edit-button btn btn-primary waves-effect waves-light btn-sm" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit"><i class="fa fa-pencil-square-o fa-2x"></i></a>  <a  onclick="return confirm(&#39;Are you sure want to Delete ?&#39;)" href="<?php echo base_url('admin/refund_reason/delete_reason');?>/'+s[i]['reason_id']+'" class="tabledit-delete-button btn btn-danger waves-effect waves-light btn-sm" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete"><i class="fa fa-trash fa-2x"></i></a>'
						  ]);										
					}
			},
		error: function(e){
			}
		});
	 });
</script>
