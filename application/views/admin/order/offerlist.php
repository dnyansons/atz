<?php $this->load->view("admin/common/header"); ?>
<style>
    .filter-form-text {
        margin-bottom: 4px;
        font-weight: bold;
    }

    .blinking {
        animation: blinkingText 0.8s infinite;
    }

    @keyframes blinkingText {
        0% {
            color: #fff;
            padding: 3px;
            font-size: 10px;
        }
        49% {
            color: #fff;
        }
        50% {
            background-color: #f95b5b;
            border-radius: 7px;
            padding: 3px;
            font-size: 10px;
        }
        99% {
            color: #fff;
            padding: 3px;
            font-size: 10px;
        }
        100% {
            color: #fff;
            padding: 3px;
            font-size: 10px;
        }
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
                                    <h4 class="">All Offer Orders</h4>
                                    <span></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="page-header-breadcrumb">
                                <ul class="breadcrumb-title">
                                    <li class="breadcrumb-item">
                                        <a href="<?php echo site_url(); ?>admin/dashboard"> <i
                                                    class="feather icon-home"></i> </a>
                                    </li>
                                    <li class="breadcrumb-item"><a href="#">Orders</a></li>
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
                                    <form method="post" action="<?php echo base_url(); ?>admin/order/show"
                                          id="submit_form">
                                        <div class="row">
                                            <div class="col-md-2">
                                                <p class="">From</p>
                                                <input type="text" class="form-control" value="<?php
                                                if (isset($dateFrom)) {
                                                    echo $dateFrom;
                                                } else {
                                                    echo date('d-m-Y');
                                                }
                                                ?>" placeholder="Date From" id="dateFrom" name="dateFrom">
                                                <input type="hidden" name="page" id="page" value="<?php echo $page; ?>">
                                            </div>
                                            <div class="col-md-2">
                                                <p class="">To</p>
                                                <input type="text" class="form-control" value="<?php
                                                if (isset($dateTo)) {
                                                    echo $dateTo;
                                                } else {
                                                    echo date('d-m-Y');
                                                }
                                                ?>" placeholder="Date To" id="dateTo" name="dateTo">
                                            </div>
                                            <div class="col-md-2">
                                                <p class="">Order id</p>
                                                <input type="text" class="form-control" id="orderid" name="orderid"
                                                       value="<?php
                                                       if (isset($orderid)) {
                                                           echo $orderid;
                                                       }
                                                       ?>" placeholder="Order Id">
                                            </div>
                                            <div class="col-md-2">
                                                <p class="">Vendor ID</p>
                                                <input type="text" class="form-control" id="vendorid" name="vendorid"
                                                       value="<?php
                                                       if (isset($vendorid)) {
                                                           echo $vendorid;
                                                       }
                                                       ?>" placeholder="Vendor Id">
                                            </div>
                                            <div class="col-md-2">
                                                <p class="">Select Offer</p>
                                                <select id="offer_id" class="form-control" name="orderstatus">
  
                                                    <option value="">All Offer</option>
                                                    <?php foreach ($offer as $stat) { ?>

                                                        <?php if ($offer_id == $stat['offer_id']) { ?>
                                                            <option value="<?php echo $stat['offer_id']; ?>"
                                                                    selected><?php echo $stat['title']; ?></option>
                                                        <?php } else { ?>
                                                            <option value="<?php echo $stat['offer_id']; ?>"><?php echo $stat['title']; ?></option>
                                                        <?php }
                                                    } ?>
                                                </select>
 
                                            </div>
                                            <div class="col-md-2">
                                                <p>&nbsp;</p>
                                                <button type="submit" class="btn btn-info btn-sm btn-block"
                                                        id="btnFilter">Filter
                                                </button>
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
                                    <h5>Offer Order Details</h5>
                                    <h5 style="float: right;">Total Orders:<span><?php echo count($total_orders) ?></span>
                                    </h5>

                                    <div class="col-md-2">
                                        <span>&nbsp;</span><br/>
                                        <input type="button" class="btn btn-info btn-sm" id="export"
                                               value="Export To Excel">


                                    </div>
                                </div>
                                <div class="card-block">
                                    <?php echo $this->session->flashdata("message"); ?>
                                    <div class="dt-responsive table-responsive">
                                        <style>
                                            th {
                                                white-space: nowrap;
                                                overflow: hidden;
                                                text-overflow: ellipsis;
                                            }
                                        </style>
                                        <table id="salesreport" class="table table-striped table-bordered nowrap">
                                            <thead>
                                            <tr>
                                                <th>Action</th>
                                                <th>Order ID</th>
                                                <th>Order Date</th>
                                                <th>Offer Title (Offer ID)</th>
                                                <th>Offer Value</th>
                                                <th>Status</th>
                                                <th>Delivery Date</th>
                                                <th>Products</th>
                                                <th>User name</th>
                                                <th>User Email</th>
                                                <th>Mobile Number</th>
                                                <th>Shipping Address</th>
                                                <th>Order Price</th>
                                                <th>Commission</th>
                                                <th>GST</th>
                                                <th>Shipping Price</th>
                                                <th>Payable To Vendor</th>
                                                <th>Vendor Id</th>
                                                <th>Vendor Name</th>
                                                <th>Vendor Email</th>
                                                <th>Vendor Mobile</th>
                                                <th>Vendor Address</th>
                                                <th>Shipping Type</th>
                                                <th>Cancelled/Approved&nbsp;By</th>
                                            </tr>
                                            </thead>
                                            <tbody>

                                            <?php
                                            $ch_repeat=0;
                                            // echo "<pre>";print_r($total_orders);
                                            if ($total_orders) {
                                                foreach ($total_orders as $ord) {
                                                    $offer_type=$ord['offer_type'];
                                                    if($offer_type=='percentage')
                                                    {
                                                        $offer_type='%';
                                                    }
                                                    if($ch_repeat!=$ord['ord'])
                                                    {
                                                      $ch_repeat=$ord['ord'];
                                                    
                                                    ?>
                                                    <tr>
                                                        <td>
                                                            <?php
                                                            if ($ord['order_token_number'] != 0 && $ord['awb_number'] == 0) {
                                                                ?>
                                                                <a href="<?php echo base_url(); ?>admin/order/generate_waybill/<?php echo $ord['ord']; ?>"
                                                                   class="badge badge-primary">Generate Order</a>
                                                                <?php
                                                            } elseif ($ord['awb_number'] != 0) {
                                                                ?>
                                                                <a href="<?php echo base_url(); ?>admin/order/view_waybill/<?php echo $ord['ord']; ?>"
                                                                   class="badge badge-success">View Way Bill</a>
                                                                <?php
                                                            } else {
                                                                if ($ord['orders_status_name'] == 'Processing') {
                                                                    echo '<span class="blinking">NEW</span>';
                                                                } else {
                                                                    echo 'No&nbsp;Action';
                                                                }
                                                            }
                                                            ?>
                                                        </td>
                                                        <td>
                                                            <a href="<?php echo base_url(); ?>admin/order/view/<?php echo $ord['ord']; ?>"
                                                               target="new"
                                                               class="badge badge-primary"><?php echo $ord['orders_id']; ?></a>
                                                        </td>
                                                        <td><?php echo date('d M Y ', strtotime($ord['date_purchased'])); ?></td>
                                                        <td><?php echo $ord['title'].'<br>(Offer ID:#'.$ord['offer_id'].' )'; ?></td>
                                                        <td><?php echo $ord['discount_value'].' ( '.$offer_type.' )'; ?></td>
                                                        <td>
                                                            <?php
                                                            echo $ord['orders_status_name'];
                                                            if ($ord["orders_status_name"] == 'Rejected') {
                                                                echo "<br /> <a class='label label-success' href='" . site_url('admin/order/approve_decline/') . $ord['ord'] . "'>Approve</a>";
                                                            }
                                                            ?>
                                                        </td>
                                                        <td><?php
                                                            if (trim($ord['delivery_date']) != '0000-00-00' && !empty($ord['delivery_date'])) {
                                                                echo date("d M Y ", strtotime($ord['delivery_date']));
                                                            } else {
                                                                echo '--';
                                                            }
                                                            ?></td>
                                                        <td style="white-space: nowrap; overflow: hidden; text-overflow:ellipsis;"><?php
                                                            $products = $this->Common_model->getAll("orders_products", array("orders_id" => $ord['ord']))->result_array();
                                                            foreach ($products as $prod) {
                                                                echo $prod['products_name'] . "<br>";
                                                            }
                                                            ?>
                                                        </td>
                                                        <td style="white-space: nowrap; overflow: hidden; text-overflow:ellipsis;"><?php echo $ord['user_name']; ?></td>
                                                        <td><?php echo $ord['user_email_address']; ?></td>
                                                        <td><?php echo $ord['user_telephone']; ?></td>
                                                        <td><?php echo $ord['shipping_adress']; ?></td>
                                                        <td><?php echo $ord['order_price']; ?></td>
                                                        <td><?php echo $ord['commission']; ?></td>
                                                        <td><?php echo $ord['gst']; ?></td>
                                                        <td><?php echo $ord['shipping_cost']; ?></td>
                                                        <td><?php echo $ord['vendor_payable_price']; ?></td>
                                                        <td>
                                                            <a target="_blank" class="badge badge-info" href="<?php echo base_url('admin/seller/profile/'.$ord['seller_id']); ?>">
                                                                ATZ<?php echo $ord['seller_id']; ?>
                                                            </a>
                                                        </td>
                                                        <td><?php echo $ord['pick_name']; ?></td>
                                                        <td><?php echo $ord['pick_email']; ?></td>
                                                        <td><?php echo $ord['pick_mobile']; ?></td>
                                                        <td><?php echo $ord['pickup_address']; ?></td>
                                                        <td><?php echo $ord['shipping_type']; ?></td>
                                                        <td><?php echo $ord['cancelled_by']; ?></td>
                                                    </tr>
                                                <?php
                                                    }
                                                    
                                                            }
                                            } else { ?>
                                                <tr>
                                                    <td colspan="23" class="text-center">No Records Found</td>
                                                </tr>
                                            <?php } ?>
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
        $(document).on('click', '#export', function () {
            var formAction = '<?php echo base_url(); ?>admin/order/exportAllOrders';
            //set form action
            $('#submit_form').attr('action', formAction);
            //submit form
            $('#submit_form').submit();
        });

        $(document).on('click', '#btnFilter', function () {
            var formAction = '<?php echo base_url(); ?>admin/order/show_offer';
            //set form action
            $('#submit_form').attr('action', formAction);
            //submit form
            $('#submit_form').submit();
        });


        var title = $('#orderstatus option:selected').text();
        if ($.trim(title) == "Offer Order Report") {
            $('.thispagetitle').html(title);
        } else {
            $('.thispagetitle').html(title + ' Orders');
        }


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

</script>