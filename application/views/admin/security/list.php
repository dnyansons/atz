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
                                    <h4>Security Questions</h4>
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
                                    <li class="breadcrumb-item"><a href="#">Security Questions List</a></li>
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
                                   
									<a href="<?php echo base_url(); ?>admin/security/add_questions">
                                    <button type="button" class="btn btn-primary waves-effect waves-light f-right d-inline-block md-trigger" data-modal="modal-13"> <i class="icofont icofont-plus m-r-5"></i> Add Questions
                                    </button>
                                    </a>
                                </div>
                                <div class="card-block">
                                    <div class="dt-responsive table-responsive">
                                        <?php echo $this->session->flashdata("message");?>
                                        <table id="security" class="table table-striped table-bordered nowrap">
                                            <thead>
                                                <tr>
                                                    <th>Sr.No</th>
                                                    <th>Questions</th>
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
<?php $this->load->view("admin/common/footer");?>
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
		var oTable = $('#security').dataTable();
		$.ajax({
			url: '<?php echo site_url("admin/security/ajax_list");?>',
			dataType: 'json',
			success: function(s){
				console.log(s);
				oTable.fnClearTable();
				var count = 0;
				for(var i = 0; i <s.length; i++) {
				count++;
				oTable.fnAddData([
						count,
						s[i]['questions'],
						s[i]['added_date'],
						'&nbsp;&nbsp;&nbsp;<a href="<?php echo base_url('admin/security/edit_questions');?>/'+s[i]['id']+'" class="tabledit-edit-button btn btn-primary waves-effect waves-light btn-sm" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit"><i class="fa fa-pencil-square-o fa-2x"></i></a> <a href="<?php echo base_url('admin/security/delete_questions');?>/'+s[i]['id']+'" class="tabledit-edit-button btn btn-primary waves-effect waves-light btn-sm" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit"><i class="fa fa-trash-o fa-2x"></i>'
						  ]);										
					}
			},
		error: function(e){
			}
		});
	 });
</script>
