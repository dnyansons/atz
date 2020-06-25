<?php $this->load->view("admin/common/header"); ?>
<div class="pcoded-content">
    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-header">
                    <div class="row align-items-end">
                        <div class="col-lg-8">
                            <div class="page-header-title">
                                <div class="d-inline">
                                    <h4>Suppliers</h4>
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
                                    <li class="breadcrumb-item"><a href="#">Supplier Users List</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="page-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <?php echo $this->session->flashdata("message"); ?>

                            <div id="error_msg" ></div>
                            <div class="card">
                                <div class="card-header">
                                    <h5>Suppliers Table</h5>
                                    <p>Click on row to select supplier</p>
                                    <button type="button" class="btn btn-sm btn-info pull-right" id="forwardTriger">
                                        Forward
                                    </button>
                                </div>
                                <div class="card-block">
                                    <div class="dt-responsive table-responsive">
                                        <table id="supplierTable" class="table table-striped table-bordered nowrap">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Name</th>
                                                    <th>Company</th>
                                                    <th>email</th>
                                                    <th>phone</th>
                                                </tr>
                                            </thead>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <!-- Remove this only for debugging 
                            <div class="row" id="debug">
                                    
                            </div>
                            ----->
                        </div>



                    </div>
                </div>

            </div>
        </div>


    </div>
</div>

<?php $this->load->view("admin/common/footer"); ?>
<script>
    /*$(document).ready(function () {
     var table = $('#supplierTable').DataTable({
     
     processing: true,
     serverSide: true,
     ajax: {
     url: "<?php //echo base_url('admin/rfqs/ajax_supplier_list')  ?>",
     dataType: "json",
     type: "POST",
     data: {'<?php //echo $this->security->get_csrf_token_name();  ?>': '<?php //echo $this->security->get_csrf_hash();     ?>'}
     },
     columns: [
     {data: "id"},
     {data: "name"},
     {data: "company"},
     {data: "email"},
     {data: "telephone"},
     ],
     
     });
     $('#supplierTable tbody').on('click', 'tr', function () {
     $("#error_msg").html('');
     $('#forwardTriger').removeAttr("disabled");
     $(this).toggleClass('selected');
     var dat_arr = [];
     newarr=[];
     var ids = $.map(table.rows('.selected').data(), function (item) {
     
     dat_arr = item["id"];
     localStorage.setItem("newarr", dat_arr);
     
     var x = localStorage.getItem("newarr");
     console.log(x);
     
     });
     
     
     });
     
     $('#forwardTriger').click(function () {
     $("#forwardTriger").attr("disabled", true);
     var ids = $.map(table.rows('.selected').data(), function (item) {
     return item["id"]
     });
     
     if (ids != '') {
     $("#error_msg").html('');
     var con = confirm('Are You Sure ? ');
     if (con == true)
     {
     $.ajax({
     url: "<?php //echo site_url();  ?>admin/rfqs/ajaxApplyRequestsTosuppliers",
     cache: false,
     type: "POST",
     data: {supplier_ids: ids, rfqs_id: "<?php //echo $rfqs_id;  ?>"},
     success: function (resp) {
     var response = JSON.parse(resp);
     if (response.success == 1) {
     window.location.href = "<?php //echo site_url();  ?>admin/rfqs";
     }
     }
     });
     }
     } else {
     $("#error_msg").html('<div class="alert alert-danger alert-dismissible" >Please select the seller.' +
     '<button data-dismiss="alert" type="button" class="close" aria-label="Close">' +
     '<span aria-hidden="true">&times;</span></button></div>');
     }
     });
     
     });*/

    //Old
    $(document).ready(function () {
        var table = $('#supplierTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "<?php echo base_url('admin/rfqs/ajax_supplier_list') ?>",
                dataType: "json",
                type: "POST",
                data: {'<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>'}
            },
            columns: [
                {data: "id"},
                {data: "name"},
                {data: "company"},
                {data: "email"},
                {data: "telephone"},
            ],
        });

        $('#supplierTable tbody').on('click', 'tr', function () {
            $("#error_msg").html('');
            $('#forwardTriger').removeAttr("disabled");
            $(this).toggleClass('selected');

        });

        $('#forwardTriger').click(function () {
            $("#forwardTriger").attr("disabled", true);
            var ids = $.map(table.rows('.selected').data(), function (item) {
                return item["id"]
            });

            if (ids != '') {
                $("#error_msg").html('');
                var con = confirm('Are You Sure ? ');
                if (con == true)
                {
                    $.ajax({
                        url: "<?php echo site_url(); ?>admin/rfqs/ajaxApplyRequestsTosuppliers",
                        cache: false,
                        type: "POST",
                        data: {supplier_ids: ids, rfqs_id: "<?php echo $rfqs_id; ?>"},
                        success: function (resp) {
                            var response = JSON.parse(resp);
                            if (response.success == 1) {
                                window.location.href = "<?php echo site_url(); ?>admin/rfqs";
                            }
                        }
                    });
                }
            } else {
                $("#error_msg").html('<div class="alert alert-danger alert-dismissible" >Please select the seller.' +
                        '<button data-dismiss="alert" type="button" class="close" aria-label="Close">' +
                        '<span aria-hidden="true">&times;</span></button></div>');
            }
        });

    });
</script>