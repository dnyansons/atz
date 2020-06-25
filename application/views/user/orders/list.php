<?php $this->load->view("user/common/header"); ?>
<style>
    #loading {
        width: 100%;
        height: 100%;
        top: 0;
        left: 0;
        position: fixed;
        display: block;              
        background-color: rgba(0,0,0,0.4);
        z-index: 99;
        text-align: center;
    }
</style>
<div class="pcoded-content">
    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-header">
                    <div class="row align-items-end">
                        <div class="col-lg-8">
                            <div class="page-header-title">
                                <div class="d-inline">
                                    <h4><?php echo $pageTitle??"Order Management"; ?>
                                    </h4>
                                    <span></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="page-body">
                    <div class="card">
                        <div class="card-block">
                            <form name="order_mgt">
                                <div class="row">

                                    <div class="col-md-2">
                                        <p>OrderId</p>
                                        <input type="text" name="filter_order_id" value="" placeholder="Order ID" id="filter_order_id" class="form-control">
                                    </div>
                                    <div class="col-md-2">
                                        <p>Order Status</p>
                                        <select name="filter_order_status_id" id="filter_order_status_id" class="form-control">
                                            <option value="">All Orders</option>
                                            <?php foreach ($orderStatus as $status): ?>
                                                <?php
                                                if ($orders_status == $status->orders_status_id) {
                                                    $orders_status_seleted = "selected";
                                                } else {
                                                    $orders_status_seleted = "";
                                                }
                                                ?>
                                                <option value="<?php echo $status->orders_status_id; ?>" <?php echo $orders_status_seleted; ?>>
                                                    <?php echo $status->orders_status_name; ?>
                                                </option>	
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <p>Amount</p>
                                        <input type="text" name="filter_total" value="" placeholder="Total" id="filter_total" class="form-control">
                                    </div>
                                    <div class="col-md-2">
                                        <p class="">From</p>
                                        <input type="text" class="form-control" value="<?php echo date('d-m-Y'); ?>" placeholder="Date From" id="dateFrom" name="dateFrom">
                                    </div>
                                    <div class="col-md-2">
                                        <p class="">To</p>
                                        <input type="text" class="form-control" value="<?php echo date('d-m-Y'); ?>" placeholder="Date To" id="dateTo" name="dateTo">
                                    </div>
                                    <div class="col-md-2">
                                        <p>&nbsp;</p>
                                        <button type="button" id="button-filter" class="btn btn-info btn-sm btn-block">
                                            <i class="fa fa-search"></i> Filter
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <?php echo $this->session->flashdata('message'); ?>
                            <div class="card">

                                <div class="card-block">
                                    <div id="loading" style="display:none;padding-top: 300px;">
                                        <img id="loading-image" src="<?php echo base_url(); ?>assets/admin/processing1.gif" alt="Loading..." style="width:120px;" />
                                    </div>
                                    <div class="dt-responsive table-responsive">
                                        <table id="seller_orderTable" class="table table-striped table-bordered nowrap" style="width:100%;">
                                            <thead>
                                                <tr>
                                                    <th>Action</th>
                                                    <th>Order Id</th>
                                                    <th>Order Date</th>
                                                    <th>Delivery Date</th>
                                                    <th>User</th>
                                                    <th>Products</th>
                                                    <th>Shipping Address</th>
                                                    <th>Status</th>
                                                    <th>Amount</th>
                                                    <th>Shipping Cost</th>
                                                    <th>Fees</th>
                                                    <th>Tax</th>
                                                    <th>Payment Mode</th>
                                                    <th>Receivable</th>

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
<?php $this->load->view("user/common/footer"); ?>
<script>
    /*$(document).ready(function () {
     $('#seller_orderTable').DataTable({
     processing: true,
     serverSide: true,
     ajax: {
     url: "<?php echo base_url('seller/orders/ajax_list') ?>",
     dataType: "json",
     type: "POST",
     data: {'<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>'}},
     columns: [
     {data: "action"},
     {data: "orders_id"},
     {data: "user_name"},
     {data: "orders_status_name"},
     {data: "order_price"},
     {data: "date_purchased"}
     
     ]
     
     });
     });
     */

    var dataTable = $('#seller_orderTable').DataTable({
        processing: true,
        serverSide: true,
        "ajax": {
                "url": "<?php echo base_url('seller/orders/ajax_list'); ?>",
                "type": "POST",
                "data":function(data) {
                 
                        data.filter_order_id = $('#filter_order_id').val();
                        data.filter_order_status_id = $('#filter_order_status_id').val();
                        data.filter_total = $('#filter_total').val();
                        data.filter_date_from = $('#dateFrom').val();
                        data.filter_date_to = $('#dateTo').val();
                        data.<?php echo $this->security->get_csrf_token_name(); ?> = "<?php echo $this->security->get_csrf_hash(); ?>";
                        
                },
        },
        "columnDefs": [
            {className: "dropdown", "targets": [5]}
        ],
        order: []

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
    $('#button-filter').on('click change', function (event) {
        //event.preventDefault();
        dataTable.draw();
    });


    function check_order()
    {
        var con = confirm('Are You Sure ?');
        if (con == true)
        {
            $('#loading').show();
        } else {
            return false;
        }
    }


</script>