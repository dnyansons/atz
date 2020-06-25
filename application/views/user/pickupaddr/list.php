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
                                    <h4><?php echo $pageTitle; ?></h4>
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
                                    <li class="breadcrumb-item"><a href="#"><?php echo $pageTitle; ?> List</a></li>
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

                                    <a href="<?php echo base_url(); ?>seller/pickupaddress/addaddr">
                                        <button type="button" class="btn btn-primary waves-effect waves-light f-right d-inline-block md-trigger" data-modal="modal-13"> <i class="icofont icofont-plus m-r-5"></i> Add Pick Address
                                        </button>
                                    </a>
                                </div>
                                 <h6 style="text-align:center;"><?php echo $this->session->flashdata('message'); ?></h6>
                                <div class="card-block">
                                    <div class="dt-responsive table-responsive">
                                        <table id="couponTable" class="table table-striped table-bordered nowrap">
                                            <thead>
                                                <tr>
                                                    <th>Sr.no</th>
                                                    <th>Name</th>
                                                    <th>Email</th>
                                                    <th>Mobile</th>
                                                    <th>Address Type</th>
                                                    <th>Address</th>
                                                    <th>Country</th>
                                                    <th>Pincode</th>
                                                    <th>Default</th>
                                                    <th>Action</th>
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
    $(document).ready(function () {

        $('#couponTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "<?php echo base_url('seller/pickupaddress/ajax_list') ?>",
                dataType: "json",
                type: "POST",
                data: {'<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>'}},
            columns: [
                {data: "sr_no"},
                {data: "seller_name"},
                {data: "seller_email"},
                {data: "seller_mobile"},
                {data: "address_type"},
                {data: "address"},
                {data: "name"},
                {data: "pincode"},
                {data: "is_default"},
                {data: "action"}
            ]

        });
    });
</script>