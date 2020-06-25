
<div class="pcoded-content">
    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-header">
                    <div class="row align-items-end">
                        <div class="col-lg-8">
                            <div class="page-header-title">
                                <div class="d-inline">
                                    <h4>Banks</h4>
                                    <span></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="page-header-breadcrumb">
                                <ul class="breadcrumb-title">
                                    <li class="breadcrumb-item">
                                        <a href="<?php echo site_url(); ?>seller/dashboard"> <i class="feather icon-home"></i> </a>
                                    </li>
                                    <li class="breadcrumb-item"><a href="#">Banks List</a></li>
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

                                    <a href="<?php echo base_url(); ?>seller/bank/add_bank">
                                        <button type="button" class="btn btn-primary waves-effect waves-light f-right d-inline-block md-trigger" data-modal="modal-13"> <i class="icofont icofont-plus m-r-5"></i> Add Bank
                                        </button>
                                    </a>
                                </div>
                                <div class="card-block">
                                    <?php echo $this->session->flashdata('message'); ?>
                                    <div class="dt-responsive table-responsive">
                                        <table id="refund" class="table table-striped table-bordered nowrap">
                                            <thead>
                                                <tr>
                                                    <th>Sl.No</th>
                                                    <th>Bank</th>
                                                    <th>Account No</th>
                                                    <th>IFSC Code</th>
                                                    <th>Created date</th>
                                                    <th>Status</th>
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
    $(document).ready(function () {
        var oTable = $('#refund').dataTable();
        $.ajax({
            url: '<?php echo site_url("seller/bank/ajax_list"); ?>',
            dataType: 'json',
            success: function (s) {
                console.log(s);
                oTable.fnClearTable();
                var count = 0;
				 var formattedDate = '';
                var d = '';
                var m = '';
                var y = '';
				var status
                for (var i = 0; i < s.length; i++) {
                    count++;
					if(s[i]['is_default'] == 1)
					{
						 status = "<p style='color:green'> Default</p>";
					}else{
						status = "Not Default";
					}
					
					formattedDate = new Date(s[i]['created_date']);
                    monthNames = ["January", "February", "March", "April", "May", "June",
                        "July", "August", "September", "October", "November", "December"
                    ];
					
					d = formattedDate.getDate();
                    m = monthNames[formattedDate.getMonth()];  // JavaScript months are 0-11 
                    y = formattedDate.getFullYear();
					
                    oTable.fnAddData([
                        count,
                        s[i]['bank_name'],
                        s[i]['account_no'],
                        s[i]['ifsc_code'],
						 d + " " + m + " " + y,
						status,
                        '&nbsp;&nbsp;&nbsp;<a href="<?php echo base_url('seller/bank/edit_bank'); ?>/' + s[i]['id'] + '" class="tabledit-edit-button btn btn-primary waves-effect waves-light btn-sm" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit"><i class="fa fa-pencil-square-o fa-2x"></i></a> '
                    ]);
                }
            },
            error: function (e) {
            }
        });
    });
</script>
