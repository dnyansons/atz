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
                                    <h4>HelpCenter Titles</h4>
                                    <span></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="page-header-breadcrumb">
                                <ul class="breadcrumb-title">
                                    <li class="breadcrumb-item">
                                        <a href="<?php echo site_url(); ?>admin/dashboard"> <i class="feather icon-home"></i> </a>
                                    </li>
                                    <li class="breadcrumb-item"><a href="#">Titles List</a></li>
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
                                    <a href="<?php echo base_url(); ?>admin/helpCenter/addTitleofSeller">
                                        <button type="button" class="btn btn-primary waves-effect waves-light f-right d-inline-block md-trigger" data-modal="modal-13"> <i class="icofont icofont-plus m-r-5"></i> Add Title
                                        </button>
                                    </a>
                                </div>
                                <div class="card-block">
                                    <div class="dt-responsive table-responsive">
                                        <table id="refund" class="table table-striped table-bordered nowrap">
                                            <thead>
                                                <tr>
                                                    <th>Sl.No</th>
                                                    <th>Title Name</th>
                                                    <th>Parent</th>
                                                    <th>Added date</th>
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
    $(document).ready(function () {
        var oTable = $('#refund').dataTable();
        $.ajax({
            url: '<?php echo site_url("admin/helpCenter/ajax_list_for_seller"); ?>',
            dataType: 'json',
            success: function (s) {
                console.log(s);
                oTable.fnClearTable();
                var count = 0;

                var formattedDate = '';
                var d = '';
                var m = '';
                var y = '';
                for (var i = 0; i < s.length; i++) {
                    count++;
                    formattedDate = new Date(s[i]['added_date']);
                    monthNames = ["January", "February", "March", "April", "May", "June",
                        "July", "August", "September", "October", "November", "December"
                    ];

                    d = formattedDate.getDate();
                    m = monthNames[formattedDate.getMonth()];  // JavaScript months are 0-11 
                    y = formattedDate.getFullYear();
                    oTable.fnAddData([
                        count,
                        s[i]['main_title'],
                        s[i]['parent_title'],
                        d + " " + m + " " + y,
                        '&nbsp;&nbsp;&nbsp;<a href="<?php echo base_url('admin/helpCenter/editTitlesOfSeller'); ?>/' + s[i]['id'] + '" class="tabledit-edit-button btn btn-primary waves-effect waves-light btn-sm" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit"><i class="fa fa-pencil-square-o fa-2x"></i></a>',
                    ]);
                }
            },
            error: function (e) {
            }
        });
    });
</script>
