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
                                    <h4>Requests for quotations</h4>
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
                                    <li class="breadcrumb-item"><a href="#">Requests List</a></li>
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
                                                <input type="button" class="btn btn-info btn-sm " id="btnFilter" value="Filter">
                                            </div>

                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <p id="errorMsg"><?php echo $this->session->flashdata("message"); ?></p>
                            <div class="card">
                                <div class="card-header">
                                    <h5>Requests Table</h5>
                                </div>
                                <div class="card-block">
                                    <div class="dt-responsive table-responsive">
                                        <table id="collectionTable" class="table table-striped table-bordered nowrap">
                                            <thead>
                                                <tr>
                                                    <th>Sr.No.</th>
                                                    <th>User Name</th>
                                                    <th>For</th>
                                                    <!--<th>Description</th>-->
                                                    <th>Quantity </th>
                                                    <th>Unit</th>
                                                    <th>Document</th>
                                                    <th>Status </th>
                                                    <th>Seller Replied</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                       
                        <!-- Modal -->
                        <div id="myModal" class="modal fade" role="dialog">
                            <div class="modal-dialog modal-lg">

                                <!-- Modal content-->
                                <div class="modal-content">
                                    <form action="<?php echo base_url(); ?>admin/rfqs/update_seller_reply" method="post">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        <h4 class="modal-title">View Seller Reply</h4>
                                    </div>
                                    <div class="modal-body">
                                        
                                        <p id="seller_reply"></p>
                                    </div>
                                   
                                    </form>
                                </div>

                            </div>
                        </div>





                    </div>
                </div>

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
        var dtTable = $('#collectionTable').DataTable({
            "columnDefs": [
                {className: "dropdown", "targets": [3]}
            ],
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
                url: "<?php echo base_url('admin/rfqs/ajax_list') ?>",
                dataType: "json",
                type: "POST",
                data: function (data) {
                    data.datefrom = $('#dateFrom').val();
                    data.dateto = $('#dateTo').val();
                    
                    if($('#dateFrom').val()>$('#dateTo').val())
                    {
                        var msg="<div class='alert alert-danger alert-dismissible'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><strong></strong> End date must be greater than From date</div>";
                        $("#errorMsg").html(msg);
                        return false;
                    }
                    data.<?php echo $this->security->get_csrf_token_name(); ?> = "<?php echo $this->security->get_csrf_hash(); ?>";
                }
            },
            columns: [
                {data: "id"},
                {data: "user_name"},
                {data: "looking_for"},
                /*{ data: "description" },*/
                {data: "quanity"},
                {data: "unit"},
                {data: "document"},
                {data: "status"},
                {data: "reply"},
                {data: "actions"},
            ],
        });

        $(document).on('click', '#btnFilter', function () {
            //dtTable.destroy();
              if($('#dateFrom').val()>$('#dateTo').val())
                {
                    var msg="<div class='alert alert-danger alert-dismissible'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><strong></strong> End date must be greater than From date</div>";
                    $("#errorMsg").html(msg);
                    return false;
                }

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
    
    
    function get_reply(id)
    {
        if (id != '')
       {
           $.ajax({
               type: 'POST',
               url: '<?php echo base_url(); ?>admin/rfqs/get_sellet_reply',
               data: {'id': id},
               success: function (data) {
                  
                   $('#seller_reply').html('');
                   $('#seller_reply').html(data);
   
               },
               error: function () {
                   alert('Somthing Wrong !');
               }
           });
       }
    }
    
    
</script>