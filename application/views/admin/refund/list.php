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
                                   <h4>Refund Order Requests</h4>
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
                                    <li class="breadcrumb-item"><a href="#">Report</a></li>
                                    <li class="breadcrumb-item"><a href="#">Return Requests List</a></li>
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
                                <form action = "<?php echo base_url(); ?>admin/Refunds/exportRefundOrderRequest" method = "post" id="form_submit">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <span class="badge badge-success badge-md daterange" data-from="<?php echo date('d-m-Y'); ?>" data-to="<?php echo date('d-m-Y'); ?>" >Today</span>
                                            <span class="badge badge-warning badge-md daterange" data-from="<?php echo date('d-m-Y',strtotime("-1 days")); ?>" data-to="<?php echo date('d-m-Y',strtotime("-1 days")); ?>" >Yesterday</span>
                                            <span class="badge badge-warning badge-md daterange" data-to="<?php echo date('d-m-Y'); ?>" data-from="<?php echo date('d-m-Y',strtotime("-7 days")); ?>">Last 7 Days</span>
                                            <span class="badge badge-warning badge-md daterange" data-from="<?php echo date('01-m-Y'); ?>" data-to="<?php echo date('t-m-Y'); ?>">This Month</span>
                                        </div>
                                        <div class="col-md-2">
                                            <p class="filter-form-label">From</p>
                                            <input type="text" class="form-control" value="<?php echo date('d-m-Y'); ?>" placeholder="Date From" id="dateFrom" name="datefrom">
                                        </div>
                                        <div class="col-md-2">
                                            <p class="filter-form-label">To</p>
                                            <input type="text" class="form-control" value="<?php echo date('d-m-Y'); ?>" placeholder="Date To" id="dateTo" name="dateto">
                                        </div>
                                        <div class="col-md-2">
                                            <p class="filter-form-label">Order id</p>
                                            <input type="text" class="form-control" id="orderid" name="order_id" placeholder="Order Id">
                                        </div>
                                        <div class="col-md-2">
                                            <p class="filter-form-label">Vendor ID</p>
                                            <input type="text" class="form-control" id="vendorid" name="vendor_id" placeholder="Vendor Id">
                                        </div>
                                        
                                       <!-- <div class="col-md-2">
                                            <p class="filter-form-label">Order Status</p>
                                            <select id="orderstatus" class="form-control" name="orderstatus">
                                                <option value="">Select</option>
                                                <?php foreach($statuses as $stat){ ?>
                                                <option value="<?php echo $stat['orders_status_id']; ?>"><?php echo $stat['orders_status_name']; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>-->
                                        
                                        <div class="col-md-2">
                                            <p class="filter-form-label">&nbsp;</p>
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
                                <h5>Refund Order</h5>

                                         <div class="col-md-2">
                                            <p class="filter-form-label">&nbsp;</p>
                                            <input type="button" class="btn btn-info btn-sm" id="export" value="Export To Excel">
                                        </div>
                                </div>
                                <div class="card-block">
                                    <?php echo $this->session->flashdata("message");?>
                                    <div class="dt-responsive table-responsive">
                                        <table id="returnsTable" class="table table-striped table-bordered nowrap">
                                            <thead>
                                                <tr>
                                                    <th>Refund ID</th>
                                                    <th>User</th>
                                                    <th>Request Amount</th>
                                                    <th>Approved Amount</th>
                                                    <th>Created Date</th>
                                                    <th>Updated Date</th>
                                                    <th>Order Status</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                
                                            </tbody>
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
<?php $this->load->view("admin/common/footer"); ?>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.html5.min.js"></script>
<script>
    $(document).ready(function () {
       var dtTable =  $('#returnsTable').DataTable({
            processing: true,
            serverSide: true,
            searching: true,
            // dom: 'Bfrtip',
            /*buttons: [
                'copyHtml5',
                'excelHtml5',
                'csvHtml5',
                'pdfHtml5'
            ],*/
            ajax: {
                url: "<?php echo base_url('admin/refunds/ajax_list') ?>",
                dataType: "json",
                type: "POST",
                data: function(data) {
                            data.order_status = $('#orderstatus').val();
                            data.vendor_id = $('#vendorid').val();
                            data.order_id = $('#orderid').val();
                            data.datefrom = $('#dateFrom').val();
                            data.dateto = $('#dateTo').val();
                            data.<?php echo $this->security->get_csrf_token_name(); ?> = "<?php echo $this->security->get_csrf_hash(); ?>";

                    }
                },
               columns: [
                      { data: "refund_id" },
                      { data: "user_name" },
                      { data: "order_price" },
                      { data: "refund_amount" },
                      { data: "created_at" },
                      { data: "update_at" },
                      { data: "orders_status" },
                      { data: "action" }
                   ],
            "lengthMenu": [[100, 250, 500, -1], [100, 250, 500, "All"]]
        });
        
        $(document).on('click', '#btnFilter', function () {
            //dtTable.destroy();
            dtTable.clear().draw();
        });
        
        $(document).on('click', '#export', function(){
            $('#form_submit').submit();
        });
        
         $("#dateFrom").dateDropper({
            format:"d-m-Y",
            dropWidth: 200,
            dropPrimaryColor: "#1abc9c",
            dropBorder: "1px solid #1abc9c",
            maxYear: "2020",
        });
        $("#dateTo").dateDropper({
            format:"d-m-Y",
            dropWidth: 200,
            dropPrimaryColor: "#1abc9c",
            dropBorder: "1px solid #1abc9c",
            maxYear: "2020",
        });

    /*
        From & To Date Functionality
    */

    $("#dateTo").on("change",function(e){
        
        var from_date=$("#dateFrom").val();

        var to_date=$("#dateTo").val();
          
        if(from_date!=='' && to_date!=='')
        {
            // alert(from_date+''+to_date);
            if(from_date>to_date)
            {
               $("#dateTo").val('');
               alert("Please Select Valid From & To Date to View Details.!");
               // location.reload();
               $('#dateTo').css('border-color', 'red');
            }
             
        }
               return false;
    });




    });
    
    $('.daterange').click(function(){
        var datefrom = $(this).attr('data-from');
        var dateto = $(this).attr('data-to');
        $("#dateFrom").val(datefrom);
        $("#dateTo").val(dateto);
        $('#btnFilter').trigger('click');
        $(".daterange" ).removeClass('badge-success');
        $(".daterange" ).addClass('badge-warning');
        $(this).addClass('badge-success');
    });
</script>
