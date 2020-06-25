<?php $this->load->view("user/common/header"); ?>
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
                                        <a href="<?php echo site_url(); ?>seller/dashboard"> <i class="feather icon-home"></i> </a>
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
                                        <table id="collectionTable" class="table table-striped table-bordered nowrap">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Forwarded date</th>
                                                    <th>For</th>
                                                    <!--<th>Description</th>-->
                                                    <th>Quantity </th>
                                                    <th>Unit</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                    foreach ($rfqs as $rfq): ?>
                                                    <tr>
                                                        <td><?php echo $rfq->id; ?></td>
                                                        <td><?php echo date("d M Y h:i:s",strtotime($rfq->forwarded_date)); ?></td>
                                                        <td><?php echo $rfq->looking_for; ?></td>
                                                        <td><?php echo $rfq->quanity; ?></td>
                                                        <td><?php echo $rfq->units_name; ?></td>
                                                        <td>
                                                            <?php if ($rfq->status == "Pending") { ?>
                                                                <a href="<?php echo site_url("seller/rfqs/reply") . "/" . $rfq->rply_id ."/".$rfq->rfq_id; ?>" class="btn btn-info">
                                                                    <i class="fa fa-reply"></i>
                                                                </a>
																&nbsp;&nbsp;<a href="<?php echo site_url("seller/rfqs/reject") . "/" . $rfq->rply_id ."/".$rfq->rfq_id; ?>" class="btn btn-danger btn-sm" > Reject
                                                                </a>
                                                            <?php }else if($rfq->status == "SellerReplied"){
                                                                echo "<p style='color:green'>Wait for admin Approve</p>";
                                                            }
                                                            else if($rfq->status == "Approved"){
                                                                echo "<p style='color:green'>Approved</p>";
                                                            }else{
																	echo "<p style='color:red'>Rejected</p>";					
															} ?>								
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>	
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
<?php $this->load->view("user/common/footer"); ?>
<script>
    $(document).ready(function () {
        $('#collectionTable').DataTable({
            order:[[0,"desc"]]
        });
    });
</script>