<?php $this->load->view("admin/common/header"); ?>
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
                                    <h4 id="pageTitle"><?php echo $pageTitle; ?></h4>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="page-header-breadcrumb">
                                <ul class="breadcrumb-title">
                                    <li class="breadcrumb-item">
                                        <a href="<?php echo site_url(); ?>admin/dashboard"> <i class="feather icon-home"></i> </a>
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
                                            <form id="submit_form" method="POST">
                                    <!--<h4 class="sub-title">Search filters</h4>-->
                                        <div class="row">
                                            <input type="hidden" id="status" name="status" value="<?php echo $status; ?>">
                                            
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
                                                <input type="text" class="form-control" id="productName" name="productName" placeholder="Name">
                                            </div>

                                            <div class="col-md-2">
                                                <p class="filter-form-label">Seller Id</p>
                                                <input type="text" class="form-control" id="sellerId" name="sellerId" >
                                            </div>
                                            <div class="col-md-2">
                                            <p class="filter-form-label">ATZ Hike</p>
                                            <input type="text" class="form-control" id="atzHike" name="atzHike" placeholder="ATZ Hike %">
                                        </div>
                                        
                                         <div class="col-md-2">
                                            <p class="filter-form-label">ATZ Discount</p>
                                            <input type="text" class="form-control" id="atzDiscount" name="atzDiscount" placeholder="ATZ Discount %">
                                        </div>
                                        
                                        <div class="col-md-2">
                                            <p class="filter-form-label">Page Limit Start</p>
                                            <input type="text" class="form-control" id="limitStart" name="limitStart" placeholder="Page limit start">
                                        </div>
                                        
                                        <div class="col-md-2">
                                            <p class="filter-form-label">Page Limit End</p>
                                            <input type="text" class="form-control" id="limitEnd" name="limitEnd" placeholder="Page limit end">
                                        </div>
                                        
                                        <div class="col-md-2">
                                            <p class="filter-form-label">From</p>
                                            <input type="text" class="form-control" id="dateFrom" name="dateFrom">
                                        </div>
                                        <div class="col-md-2">
                                            <p class="filter-form-label">To</p>
                                            <input type="text" class="form-control" id="dateTo" name="dateTo">
                                        </div>
                                            <div class="col-md-1">
                                            <input type="hidden" id="bulk" value="">
                                            <p class="filter-form-label">&nbsp;</p>
                                            <button class="btn btn-info btn-sm btn-block p-2" id="btnExport">Export</button>
                                        </div>                                         
                                      </div>                                    
                                    </form>
                                <div class="col-md-1 offset-md-9" style="margin-top:-36px;">
                                            <button type="button" class="btn btn-info btn-sm btn-block" id="btnFilter">Filter</button>
                                     </div>
                                    </div>
                                    
                                </form>
                                
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            
                             <?php if(!empty($this->session->flashdata('message'))){ ?>
<!--                                <div class="alert alert-success alert-dismissible col-md-6 offset-3">
                                  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>-->
                              <?php echo $this->session->flashdata('message'); ?>
<!--                                </div> -->
                            <?php } ?>
                            <div id="approve_message"> </div>
                            <div class="card">
                                <div class="card-header">
                                     <div class="row">
                                         <div class="col-md-2"><b>Products Table</b></div>
                                         <div class="col-md-8" ><button class="btn btn-info btn-sm pull-right" id="filter_bulk">Bulk Filter</button></div>
                                         <div class="col-md-2">
<!--                                        <span>&nbsp;</span>-->
<!--                                        <input type="button" class="btn btn-info btn-sm" id="export"
                                               value="Export To Excel">-->

                                    </div>
                                     </div>

                                    <!-- <a class="btn btn-info float-right" href="<?php echo site_url(); ?>admin/products2/create">
                                       Post New 
                                    </a> -->
                                    &nbsp;
                                    
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
                                                    <th>Hike %</th>
                                                    <th>ATZ Price</th>
                                                    <th>Discount %</th>
                                                    <th>Final Price</th>
                                                    <th>Seller</th>
                                                    <th>Quantity</th>
                                                    <th>Specifications</th>
                                                    <th>Requested</th>
                                                    <?php if($page == "Rejected"){ ?>
                                                        <th>Rejected On</th>
                                                   <?php }else if($page == "Approved"){ ?>
                                                        <th> Approved On </th>
                                                  <?php }else{ ?>
                                                        <th> Action </th>
                                                  <?php } ?>

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
<!-- Seller information modal -->
<div class="modal fade" id="sellerModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Seller Info</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table table-bordered table-striped">
                    <tbody>
                        <tr>
                            <td>Name</td>
                            <td id="slrname"></td>
                        </tr>
                        <tr>
                            <td>Email</td>
                            <td id="slremail"></td>
                        </tr>
                        <tr>
                            <td>Mobile</td>
                            <td id="slrmobile"></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default waves-effect " data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!-- end --->
<!-- Product Attributes and specification modal -->
<div class="modal fade" id="productSpecsModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4>Product attributes and specifications</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table table-bordered table-striped" id="tblAttrs">
                    <tbody>
                        
                    </tbody>
                </table>
                <table class="table table-bordered table-striped" id="tblSpecs">
                    <tbody>
                        
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default waves-effect " data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!-- end --->

<!-- Product Approve modal -->


<div class="modal fade" id="modal_approve_product" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            
            <form class="horizontal-form">
                <div class="modal-body">
                    <h4 class="sub-title">Approve Product</h4>
                    <div class="form-group-row">
                        <label class="control-label col-md-2">Percentage</label>
                        <div class="col-md-10">
                            <input type="hidden" name="hidden_product_id" id="hidden_product_id" >
                            <select class="form-control" name="sel_commission" id="sel_commission">
                                <?php for($i=0;$i<=99;$i++){ if($i==15){$selected = "selected";}else{$selected = "";}?>
                                <option value="<?php echo $i;?>" <?php echo $selected;?>><?php echo $i;?>%</option>
                                <?php } ?>
                                
                            </select>
                            <p class="text-muted">The product will be published by incremented amount</p>
                        </div>
                        
                    </div>
                    <div class="form-group-row">
                        <label class="control-label col-md-2">Discount</label>
                        <div class="col-md-10">
                            <select class="form-control" name="sel_discount" id="sel_discount">
                                <?php for($i=0;$i<=99;$i++){?>
                                <option value="<?php echo $i;?>"><?php echo $i;?>%</option>
                                <?php } ?>
                            </select>
                            <p class="text-muted">The product will be published by incremented amount</p>
                        </div>
                        
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default waves-effect " data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-info waves-effect " id="brn_submit_approve">Submit</button>
                </div>
            </form>
            
        </div>
    </div>
</div>
<!-- end --->


<?php $this->load->view("admin/common/footer"); ?>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/dataTables.buttons.min.js"></script>

<script>
 $(document).ready(function () {
     
     var dtTable =  $('#productsTable').DataTable( {
            processing:true,
            serverSide: true,
            order: [[0, "desc" ]],
            "lengthMenu": [[25, 50, 100, 250, 500, 1000], [25, 50, 100, 250, 500, 1000]],
           
            ajax: {
                    url: "<?php echo base_url($get_url) ?>",
                    type: "POST",
                    data:function(data) {
                            data.pname = $('#productName').val();
                            data.category = $('#category').val();
                            data.seller = $('#sellerId').val();
                            data.published_from = $('#dateFrom').val();
                            data.published_to = $('#dateTo').val();
                            data.bulk = $('#bulk').val();
                            data.status = "<?php echo $status; ?>";
                            data.<?php echo $this->security->get_csrf_token_name(); ?> = "<?php echo $this->security->get_csrf_hash(); ?>";

                    },
            },
            
            

    } );
     
    $(document).on('click', '#btnFilter', function () {
        $("#bulk").val("0");
        dtTable.clear().draw();
    });
    
    $(document).on('click', '#filter_bulk', function () {
        $("#bulk").val("1");
        dtTable.clear().draw();
    });
    
    $(document).on('click', '#btnExport', function () {
          var formAction = '<?php echo base_url(); ?>admin/products/exportAllProducts';
          //set form action
          $('#submit_form').attr('action', formAction);
          //submit form
          $('#submit_form').submit();
      });
    
    $(document).on('click', '.btnViewSeller', function () {
        console.log($(this).attr("data-sid"));
        var sid = $(this).attr("data-sid");
        if(sid){
            $.ajax({
                url : "<?php echo site_url();?>admin/users/ajaxUserInfo",
                data : {seller_id:sid},
                type : "post",
                success:function(data){
                    var obj = JSON.parse(data);
                    console.log(obj);
                    $('#slrname').text(obj.data.first_name+" "+obj.data.last_name);
                    $('#slremail').text(obj.data.email);
                    $('#slrmobile').text(obj.data.phone);
                    $('#sellerModal').modal('show');
                }
            });
        }
    });    
    
    $(document).on('click', '.btnViewSpecs', function () {
        //console.log($(this).attr("data-pid"));
        var pid = $(this).attr("data-pid");
        if(pid){
            $.ajax({
                url : "<?php echo site_url();?>admin/products/ajaxProductSpecsAttr",
                data : {product_id:pid},
                type : "post",
                success:function(data){
                    var obj = JSON.parse(data);
                    $("#tblAttrs tbody").empty();
                    $(obj.data.attrs).each(function(index,value){
                        //console.log(value);
                        $("#tblAttrs tbody").append("<tr><td>"+value.name+"</td><td>"+value.attribute_value+"</td></tr>")
                    });
                    $('#productSpecsModal').modal('show');
                }
            });
        }
    });
    
    $(document).on('click', '.btnApprove', function () {
        var pid = $(this).attr("data-pid");
        if(pid){
            $("#hidden_product_id").val(pid);
            $("#modal_approve_product").modal("show");
        }
    });
    
    $(document).on('click', '#brn_submit_approve', function () {
        var pid = $("#hidden_product_id").val();
        var value = $("#sel_commission").val();
        var discount = $("#sel_discount").val();
        $.ajax({
            url : "<?php echo site_url();?>admin/requests/approve",
            data : {product_id:pid,commission:value,discount:discount},
            type : "post",
            success:function(data){
                var obj = JSON.parse(data);
                console.log(obj)
                if(obj.status){
                    dtTable.clear().draw();
                    $("#modal_approve_product").modal("hide");
					$('#approve_message').html('<div class="alert alert-success alert-dismissible col-md-6 offset-3"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Success!</strong> Product Approved! </div>');
                }
            }
        });
    });
	
	$(document).on('click', '.btnReject', function () {
        var pid = $(this).attr("data-pid");
        
                    var con=confirm('Are You Sure ? ');
                    if(con==true)
                    {
        
			if(pid){
			$.ajax({
				url : "<?php echo site_url();?>admin/requests/reject",
				data : {product_id:pid},
				type : "post",
				success:function(data){
					var obj = JSON.parse(data);
					//console.log(obj)
					if(obj.status == 1){
					   location.reload();
					}
				}
			});
        }
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
    
     $('#atzHike, #atzDiscount, #sellerId, #limitStart, #limitEnd').keydown(function (event) {

            //alert(event.keyCode);
            if (event.shiftKey == true) {
                event.preventDefault();
            }

            if ((event.keyCode >= 48 && event.keyCode <= 57) ||
                (event.keyCode >= 96 && event.keyCode <= 105) ||
                event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 37 ||
                event.keyCode == 39 || event.keyCode == 46) {

            } else {
                event.preventDefault();
            }
        });
    
});

</script>