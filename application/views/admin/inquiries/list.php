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
                                    <h4>Inquiries</h4>
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
                                    <li class="breadcrumb-item"><a href="#">Inquiry List</a></li>
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
                                    <!--<h4 class="sub-title">Search filters</h4>-->
                                    <form action = "<?php echo base_url(); ?>" method = "post" id="form_submit">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <span style="cursor: pointer;" class="badge badge-success badge-md daterange" data-from="<?php echo date('d-m-Y'); ?>" data-to="<?php echo date('d-m-Y'); ?>" >Today</span>
                                                <span style="cursor: pointer;" class="badge badge-warning badge-md daterange" data-from="<?php echo date('d-m-Y', strtotime("-1 days")); ?>" data-to="<?php echo date('d-m-Y', strtotime("-1 days")); ?>" >Yesterday</span>
                                                <span style="cursor: pointer;" class="badge badge-warning badge-md daterange" data-to="<?php echo date('d-m-Y'); ?>" data-from="<?php echo date('d-m-Y', strtotime("-7 days")); ?>">Last 7 Days</span>
                                                <span style="cursor: pointer;" class="badge badge-warning badge-md daterange" data-from="<?php echo date('01-m-Y'); ?>" data-to="<?php echo date('t-m-Y'); ?>">This Month</span>
                                            </div>
                                            <br />
                                            <div class="col-md-4">
                                                <span class="">From</span><br />
                                                <input type="text" class="form-control" value="<?php echo date('d-m-Y'); ?>" placeholder="Date From" id="dateFrom" name="datefrom">
                                            </div>
                                            <div class="col-md-4">
                                                <span class="">To</span><br />
                                                <input type="text" class="form-control" value="<?php echo date('d-m-Y'); ?>" placeholder="Date To" id="dateTo" name="dateto">
                                            </div>

                                            <div class="col-md-4">
                                                <span>&nbsp;</span><br />
                                                <input type="button" class="btn btn-info btn-sm btn-block" id="btnFilter" value="Filter">
                                            </div>

                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">

                            <div class="card">
                                <div class="card-header">
                                    <?php echo $this->session->flashdata('message'); ?>
                                </div>

                                <div class="card-block">
                                    <div class="dt-responsive table-responsive">
                                        <table id="inquiriesTable" class="table table-striped table-bordered nowrap">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>User Name</th>
                                                    <th>User Email</th>
                                                    <th>User Phone</th>
                                                    <th>Product</th>
                                                    <th>Quantity</th>
                                                    <th>comment</th>
                                                     <th>Buyer Attachment</th>
                                                    <th>Seller Name</th>
                                                    <th>Seller Email</th>
                                                    <th>Seller Phone</th>
                                                    <th>Forwarded</th>
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

<!-- The Modal -->
<div class="modal" id="myModal">
    <div class="modal-dialog">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Edit Comment</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">
                <label>Comment :</label>
                <input type="hidden" id="inquiryId" >
                <textarea class="form-control" id="description"></textarea>
            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" onclick = "submitComment()">update</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>

        </div>
    </div>
</div>

<?php $this->load->view("admin/common/footer"); ?>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.html5.min.js"></script>
<script>
                    $(document).ready(function () {
                        var dtTable = $('#inquiriesTable').DataTable({
                            processing: true,
                            serverSide: true,
                            searching: false,
                            dom: 'Bfrtip',
                            buttons: [
                                'copyHtml5',
                                'excelHtml5',
                                'csvHtml5',
                                'pdfHtml5'
                            ],
                            ajax: {
                                url: "<?php echo base_url('admin/inquiries/ajax_list'); ?>",
                                type: "POST",
                                data: function (data) {
                                    data.type = $('#type').val();
                                    data.datefrom = $('#dateFrom').val();
                                    data.dateto = $('#dateTo').val();
                                    data.<?php echo $this->security->get_csrf_token_name(); ?> = "<?php echo $this->security->get_csrf_hash(); ?>";
                                },
                            },
                            columnDefs: [
                                {className: "dropdown", "targets": [5]},
                            ]

                        });

                        $(document).on('click', '#btnFilter', function () {
                            //dtTable.destroy();
                            dtTable.clear().draw();
                        });

                        $("#dateFrom").dateDropper({
                            format: "d-m-Y",
                            dropWidth: 200,
                            dropPrimaryColor: "#1abc9c",
                            dropBorder: "1px solid #1abc9c",
                            maxYear: "2020",
                        });
                        $("#dateTo").dateDropper({
                            format: "d-m-Y",
                            dropWidth: 200,
                            dropPrimaryColor: "#1abc9c",
                            dropBorder: "1px solid #1abc9c",
                            maxYear: "2020",
                        });
                    });

                    $('.daterange').click(function () {
                        var datefrom = $(this).attr('data-from');
                        var dateto = $(this).attr('data-to');
                        $("#dateFrom").val(datefrom);
                        $("#dateTo").val(dateto);
                        $('#btnFilter').trigger('click');
                        $(".daterange").removeClass('badge-success');
                        $(".daterange").addClass('badge-warning');
                        $(this).addClass('badge-success');
                    });
                    function getcomment(id)
                    {
                        var comment = $("#" + id).attr("data-comment");
                        var id = $("#" + id).attr("data-id");
                        $("#description").text(comment);
                        $("#inquiryId").val(id);
                    }

                    function submitComment()
                    {
                        var inquiryId = $("#inquiryId").val();
                        var comment = $("#description").val();
                        $.ajax({
                            url: "<?php echo base_url('admin/inquiries/updateComment'); ?>", 
                            method: 'POST',
                            dataType: 'json',
                            data: {inquiryId: inquiryId, comment: comment}, 
                            success: function (result) {
                               window.location.reload();
                            }
                        });
                    }
</script>