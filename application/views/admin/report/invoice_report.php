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
                                    <h4>Invoice Report</h4>
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
                                    <li class="breadcrumb-item">Report</li>
                                    <li class="breadcrumb-item">Invoice Report</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="page-body">
<!--					<div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-block">
                                <h4 class="sub-title">Search filters</h4>
								<form action = "<?php echo base_url(); ?>admin/report/exportSalesReport" method = "post" id="form_submit">
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
                                            <p class="filter-form-label">Vendor ID</p>
                                            <input type="text" class="form-control" id="vendorid" name="vendor_id" placeholder="Vendor Id">
                                        </div>
                                        
                                        <div class="col-md-2">
                                            <p class="filter-form-label">Order Status</p>
                                            <select id="orderstatus" class="form-control" name="orderstatus">
                                                <option value="">Select</option>
												<?php foreach($statuses as $stat){ ?>
												<option value="<?php echo $stat['orders_status_id']; ?>"><?php echo $stat['orders_status_name']; ?></option>
												<?php } ?>
                                            </select>
                                        </div>
                                        
                                        <div class="col-md-2">
                                            <p class="filter-form-label">&nbsp;</p>
                                           <input type="button" class="btn btn-info btn-sm btn-block" id="btnFilter" value="Filter">
                                        </div>
										
										 <div class="col-md-2">
                                            <p class="filter-form-label">&nbsp;</p>
                                            <input type="button" class="btn btn-info btn-sm" id="export" value="Export To Excel">
                                        </div>
                                    </div>
									</form>
                                </div>
                            </div>
                        </div>
                    </div>-->
                    <div class="row">
                        <div class="col-sm-12">

                            <div class="card">
                                <div class="card-header">
                                    <h5>Sales Report</h5>
                                </div>
                                <div class="card-block">
                                    <?php echo $this->session->flashdata("message");?>
                                    <div class="dt-responsive table-responsive">
                                        <table id="invoicereport" class="table table-striped table-bordered nowrap">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Vendor</th>
                                                    <th>Commission</th>
                                                    <th>Gst</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $i=1; foreach($items as $item){?>
                                                <tr>
                                                    <td><?php echo $i;?></td>
                                                    <td><?php echo "ATZ".$item->seller;?></td>
                                                    <td><?php echo $item->commission;?></td>
                                                    <td><?php echo $item->gst;?></td>
                                                    <td>
                                                        <a href="<?php echo site_url('admin/vendorinvoices/view').'/'.$item->seller;?>" class="btn btn-info btn-sm">
                                                            View invoice
                                                        </a>
                                                    </td>
                                                </tr>
                                                <?php $i++; } ?>
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
    $(document).ready(function(){
        $("#invoicereport").DataTable();
    });
</script>
