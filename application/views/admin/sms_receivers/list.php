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
                                    <h4>SMS Receivers</h4>
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
                                    <li class="breadcrumb-item"><a href="<?php echo site_url(); ?>admin/sms_receivers/view_receivers">SMS Receivers</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="page-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="card">
                                <div class="card-header">
                                    <h5>SMS Receivers</h5>
                                    <a class="btn btn-sm btn-danger float-right" href="<?php echo base_url('admin/sms_receivers/add_receivers'); ?>">Add SMS Receivers</a>
                                </div>
                                <div class="card-block">
                                     <?php if(!empty($this->session->flashdata('message'))){ ?>
                                        <div class="alert alert-success alert-dismissible col-md-6 offset-3">
                                          <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                          <strong>Success:</strong> <?php echo $this->session->flashdata('message'); ?>
                                        </div> 
                                     <?php } ?>
                                    <div class="dt-responsive table-responsive">
                                        <table id="empreport" class="table table-striped table-bordered nowrap">
                                            <thead>
                                                <tr>
                                                    <th>Sr. No.</th>
                                                    <th>Emp Name</th>
                                                    <th>Mobile</th>
                                                    <th>SMS FOR</th>
                                                    <th>Status</th>
                                                    <th>Date Added</th>
                                                    <th>Assigned By Admin</th>
                                                    <th>Options</th>		
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $index = 1; foreach($sms_receivers_row as $receiver){ ?>
                                                <tr>
                                                    <td><?php echo $index++; ?></td>
                                                    <td><?php echo $receiver['emp_name']; ?></td>
                                                    <td><?php echo $receiver['emp_mobile']; ?></td>
                                                    <td><?php echo $receiver['sms_for']; ?></td>
                                                    <td><?php echo $receiver['status']; ?></td>
                                                    <td><?php echo $receiver['date_added']; ?></td>
                                                    <td><?php echo $receiver['admin_firstname']; ?></td>
                                                    <td>
                                                        <a href="<?php echo base_url('admin/sms_receivers/edit_sms_receiver/'.$receiver['id']) ?>"
                                                           class="btn btn-sm btn-success"><i class="fa fa-edit"></i></a>
                                                        <a href="<?php echo base_url('admin/sms_receivers/delete_sms_receiver/'.$receiver['id']) ?>"
                                                          onclick="return confirm('Are you sure?')" class="btn btn-sm btn-danger"><i class="fa fa-remove"></i></a>
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
<script src="https://cdn.datatables.net/buttons/1.5.6/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.html5.min.js"></script>
<script>
$(document).ready(function() {
    $('#empreport').DataTable( {
        "pagingType": "full_numbers"
    } );
} );
</script>