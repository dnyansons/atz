<?php $this->load->view("user/common/header"); ?>
<style>
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
                                    <h4><?php echo $pageTitle; ?>
                                   <span id="excel_download" > <?php echo "<a href=".base_url('excel/download/'.$download_excel).
                                            " class='inline-block btn btn-sm btn-success'>Download ".
                                            $header."</a>"; ?></span>
                                    </h4>
                                </div>
                            </div>
                           
                        </div>
                        <div class="col-lg-4">
                            <div class="page-header-breadcrumb">
                                <ul class="breadcrumb-title">
                                    <li class="breadcrumb-item">
                                        <a href="<?php echo site_url(); ?>seller/dashboard"> <i class="feather icon-home"></i> </a>
                                    </li>
                                    <li class="breadcrumb-item"><a href="#">Products List</a></li>
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
                                    <div class="row">
                                        <div class="col-md-3">
                                            <p class="filter-form-label">Category</p>
                                            <select id="category" class="form-control" name="category" >
                                                <option value="">Select</option>
                                                <?php if (!empty($categories)) { foreach ($categories as $category){ if($category->category_id > 13){?>
                                                  <option value="<?php echo $category->category_id; ?>"><?php echo $category->categories_name; ?></option>
                                                <?php } } } ?>
                                            </select>
                                        </div>
                                        <div class="col-md-2">
                                            <p class="filter-form-label">Product Name</p>
                                            <input type="text" class="form-control" id="productName" name="productName" placeholder="name">
                                        </div>
                                        
                                        <div class="col-md-2">
                                            <p class="filter-form-label">From</p>
                                            <input type="text" class="form-control from_dates" id="dateFrom" name="dateFrom">
                                        </div>
                                        <div class="col-md-2">
                                            <p class="filter-form-label">To</p>
                                            <input type="text" class="form-control to_dates" id="dateTo" name="dateTo">
                                        </div>
                                        <div class="col-md-1">
                                            <p class="filter-form-label">&nbsp;</p>
                                            <button class="btn btn-info btn-sm btn-block" id="btnFilter">Filter</button>
                                        </div>
                                         <div class="col-md-2">
                                            <p class="filter-form-label">&nbsp;</p>
                                            <input type="hidden" id="bulk" value="">
                                            <button class="btn btn-info btn-sm btn-block" id="filter_bulk">Bulk Filter</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-12">
                            
                            <?php if(!empty($this->session->flashdata('message'))){ ?>
                                <div class="alert alert-success alert-dismissible col-md-6 offset-3">
                                  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                  <strong>Success:</strong> <?php echo $this->session->flashdata('message'); ?>
                                </div> 
                            <?php } ?>

                            <div class="card">
                                <div class="card-header">
                                    <h5>Products Table</h5>
                                    <a class="btn btn-info float-right" href="<?php echo site_url(); ?>seller/products/create">
                                        Post New 
                                    </a>
                                </div>
                                <div class="card-block">

                                    <div class="dt-responsive table-responsive">
                                        <table id="productsTable" class="table table-striped table-bordered nowrap">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Id</th>
                                                    <th>Image</th>
                                                    <th>Name</th>
                                                    <th>Category</th>
                                                    <th>Price</th>
                                                    <th>Quantity</th>
                                                    <th>Specifications</th>
                                                    <th>status</th>
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


<!-------------------- Specification modal ---------------------->
<div class="modal fade" id="myModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <table class="table table-striped" id="tblGrid">
                    <thead id="tblHead">
                        <tr>
                            <th>Name</th>
                            <th>Values</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>    

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default " data-dismiss="modal">Close</button>
            </div>

        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!------------------------- Close ----------------------------------->  


<?php $this->load->view("user/common/footer"); ?>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<script>
    $(document).ready(function () {
        var dataTable = $('#productsTable').DataTable({
            processing: true,
            serverSide: true,
            searching: true,
            order: [[0, "desc"]],
            ajax: {
                url: "<?php echo base_url($get_url) ?>",
                type: "POST",
                data: function (data) {
                 console.log(data);
                    data.category = $('#category').val();
                    data.productName = $('#productName').val();
                    data.from = $('#dateFrom').val();
                    data.to = $('#dateTo').val();
                    data.bulk = $('#bulk').val();
                    
                    data.status = "<?php echo $status; ?>";
                    data.<?php echo $this->security->get_csrf_token_name(); ?> = "<?php echo $this->security->get_csrf_hash(); ?>";
                }
			
            },
                "drawCallback": function (settings) { 
                       // Here the response
                       var response = settings.json;
                       if(response.data == '')
                       {
                               $('#excel_download').html('');
                       }
               },
            language: {
                infoFiltered: ""
            }

        });
        
        $('#btnFilter').on( 'click change', function (event) {
         //event.preventDefault();
          $("#bulk").val("0");
          dataTable.draw();
        } );
        
        $('#filter_bulk').on( 'click change', function (event) {
         //event.preventDefault();
          $("#bulk").val("1");
          dataTable.draw();
        } );

        $('#search').on('click change', function (event) {
            event.preventDefault();

            if ($('#datepicker1').val() == "")
            {
                $('#datepicker1').focus();
            } else if ($('#datepicker2').val() == "")
            {
                $('#datepicker2').focus();
            } else
            {
                dataTable.draw();
            }

        });

/* swal set to input type number*/

        $("#productsTable").on("click", ".btn_publish", function () {
            var product_id = $(this).attr('data-pid');
            if (product_id) {

                swal({
                    title: "Are you sure?",
                    text: "Once submitted, you will not be able to update the product features images and price!",
                    className: "col-md-4",
                    buttons: true,
                    dangerMode: true,
                })
                        .then((cnf) => {
                            if (cnf) {
                                $.ajax({
                                    url: "<?php echo base_url(); ?>seller/products/publishRequest",
                                    type: "POST",
                                    dataType: "json",
                                    data: {product_id: product_id},
                                    success: function (response) {
                                        if (response.status == 1)
                                        {
                                            swal("publish request sent successfully");
                                            dataTable.draw();
                                        }
                                    }
                                });
                            } else {
                                swal("Request not submitted");
                            }
                        });

            }
        });

        $(document).on('click', '.btnUpdateQuantity', function () {
        
            //console.log($(this).attr("data-pid"));
            var pid = $(this).attr("data-pid");
            if (pid) {
                swal({
                    text: 'Set Quantity To',
                    // content: "input",
                    content: {
                    element: "input",
                    attributes: {
                    placeholder: "Enter Quantity",
                    type: "number",
                    max:"99999",
                    min:"1",
                         },
                },   
                    button: {
                        text: "Submit!",
                        closeModal: false,
                    },
                })
                        .then(quantity => {
                            if (quantity < 0){
                                swal("Quantity must not be a negative number");
                                throw null;
                            }
                            else if (isNaN(quantity)){
                                swal("Quantity must not be a number");
                                throw null;
                            }
                            else if (!quantity){
                                swal("Quantity must not be empty");
                                throw null;
                            }
                            else {
                                $.ajax({
                                    url: "<?php echo site_url(); ?>seller/products/increaseQuantity",
                                    data: {product_id: pid, quantity: quantity},
                                    type: "post",
                                    success: function (data) {
                                        var obj = JSON.parse(data);
                                        //console.log(obj)
                                        if (obj.status) {

                                            dataTable.clear().draw();
                                            swal("Product Quantity updated successfully");
                                        }
                                    }
                                });
                            }
                        });
            }
        });

        $(document).on("click", ".btnViewSpecs", function () {
            console.log($(this).attr("data-pid"));
            var product_id = $(this).attr("data-pid");
            $.ajax({
                url: "<?php echo site_url('seller/products/getProductSpecifications'); ?>",
                type: "post",
                datatype: "json",
                data: {product_id: product_id},
                success: function (resp) {
                    var obj = JSON.parse(resp);
                    if (obj.status & obj.data.length > 0) {
                        $("#tblGrid tbody").empty();
                        $.each(obj.data, function (index, value) {
                            //console.log(value);
                            $("#tblGrid tbody").append("<tr><td>" + value.name + "</td><td>" + value.specifications + "</td></tr>");
                        });
                        $("#myModal").modal("show");
                    } else {
                        swal("Specification data not found");
                        console.log("test");
                    }
                }
            });
        });



/*spcial character validation*/

 $('.inputcls').on('keypress', function (event) {

            var regex = new RegExp("^[a-zA-Z0-9_ ]*$");
            var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
            if (!regex.test(key)) {
               event.preventDefault();
               return false;
            }
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
    


$(".to_dates").on("change",function(e){
    
    var from_date=$(".from_dates").val();

    var to_date=$(".to_dates").val();
      
    if(from_date!=='' && to_date!=='')
    {
        // alert(from_date+''+to_date);
        if(from_date>to_date)
        {
           $(".to_dates").val('');
           alert("From date should not be greater than To date.!");
           location.reload();
        }
         
    }
       return false;
  });

    });
    
</script>

