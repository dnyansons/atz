<?php $this->load->view("admin/common/header"); ?>
<link rel='stylesheet' href="<?php echo base_url();?>assets/bower_components/sweetalert/css/sweetalert.css">
<div class="pcoded-content">
    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-header">
                    <div class="row align-items-end">
                        <div class="col-lg-8">
                            <div class="page-header-title">
                                <div class="d-inline">
                                    <h4>Product Approve Requests</h4>
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
                        <div class="col-sm-12">
                            <?php echo $this->session->flashdata("message"); ?>
                            <div class="card">
                                <div class="card-header">
                                    <h5>Requests Table</h5>
                                </div>
                                <div class="card-block">
                                    <div class="dt-responsive table-responsive">
                                        <table id="requestsTable" class="table table-striped table-bordered nowrap">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Name</th>
                                                    <th>Image</th>
                                                    <th>Price</th>
                                                    <th>Supplier</th>
                                                    <th>Created</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $i = 0;
                                                foreach ($requests as $req) {
                                                    $i++; ?>
                                                    <tr>
                                                        <td><?php echo $i; ?></td>
                                                        <td><?php echo $req->name; ?></td>
                                                        <td>
                                                            <?php echo "<img src='" . $req->media_url . "' width='64' height='64' >"; ?>
                                                        </td>
                                                        <td><?php echo $req->price1 . "-" . $req->price2; ?></td>
                                                        <td>
                                                            <?php 
                                                            echo $req->first_name . " " . $req->last_name;
                                                            echo "<br />Company :".$req->company_name;
                                                            ?>
                                                        </td>
                                                        <td><?php echo date("d/m/Y", strtotime($req->created_at)); ?></td>
                                                        <td>
                                                            <button data-link="<?php echo site_url(); ?>admin/requests/approve/<?php echo $req->product_id; ?>" 
                                                               class="btn btn-sm btn-success confirmation">
                                                                <i class="fa fa-check"></i>
                                                            </button>
                                                            <button data-link="<?php echo site_url(); ?>admin/requests/reject/<?php echo $req->product_id; ?>" 
                                                               class="btn btn-sm btn-danger confirmation">
                                                                <i class="fa fa-remove"></i>
                                                            </button>
                                                            <a href="<?php echo site_url(); ?>admin/products/update//<?php echo $req->product_id; ?>" class="btn btn-sm btn-info"><i class="fa fa-edit"></i></a>
                                                        </td>
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
<script src="<?php echo base_url();?>assets/bower_components/sweetalert/js/sweetalert.min.js"></script>
<script>
    $(document).ready(function () {
        
        $('.confirmation').click(function(e){
            e.preventDefault();
            var link = $(this).attr('data-link');
            //console.log(link);
            swal({
            title: "Are you sure?",
            text: "",
            type: "warning",
            showCancelButton: true,
            confirmButtonClass: "btn-danger",
            confirmButtonText: "Yes, confirm!",
            cancelButtonText: "No, cancel !",
            closeOnConfirm: false,
            closeOnCancel: false
          },
          function(isConfirm) {
            if (isConfirm) {
              window.location.href = link;
            } else {
                swal("last action cancelled");
            } 
          });
            
            
            
        });
        
        
        $("#requestsTable").DataTable();
    });
</script>