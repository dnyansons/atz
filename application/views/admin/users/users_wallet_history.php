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
                                    <h4>
                                        <?php echo $title;?>'s Wallet History
                                    </h4>
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
                                    <li class="breadcrumb-item"><a href="#">Wallet History</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mb-2"><b>Current Balance : <span class="btn-success p-1"> <?php echo $balance; ?> </span></b></div>

                <div class="page-body">

                    <div class="row">
                        <div class="col-sm-12">
                            <?php echo $this->session->flashdata('message'); ?>
                            <div class="card">
                            
                                <div class="card-block">
                                    <div class="dt-responsive table-responsive">
                                        <table id="userHistoryTable" class="table table-striped table-bordered nowrap">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th title="Previous Amount">Pre Amount</th>
                                                    <th title="Current Amount">Curr Amount</th>
                                                    <th title="Transaction Amount">Trans Amount</th>
                                                    <th>Type</th>
                                                    <th>Created</th>
                                                    <th>Remark</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            <?php $index = 1; foreach($history as $details) { ?>
                                                <tr>
                                                    <td><?php echo $index++;?></td>
                                                    <td><?php echo $details['previous_amount'] ?></td>
                                                    <td><?php echo $details['current_amount'] ?></td>
                                                    <td><?php echo $details['amount'] ?></td>
                                                    <td><?php echo $details['transaction_type'] ?></td>
                                                    <td><?php echo $details['created'] ?></td>
                                                    <td><?php echo $details['remark'] ?></td>
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

<script>
$(document).ready(function() {
    $('#userHistoryTable').DataTable( {
        "pagingType": "full_numbers"
    } );
} );
</script>