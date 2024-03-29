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
                                    <h4>Buy One Get One</h4>
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
                                    <li class="breadcrumb-item"><a href="#">Offer List</a></li>
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

                                    <a href="<?php echo base_url(); ?>admin/Buy_one_get_one/addBuyOneGetOneOffer">
                                        <button type="button" class="btn btn-primary waves-effect waves-light f-right d-inline-block md-trigger" data-modal="modal-13"> <i class="icofont icofont-plus m-r-5"></i> Add B-O-G-O Offer
                                        </button>
                                    </a>
                                </div>
                                <div class="card-block">
                                    <?php echo $this->session->flashdata('message'); ?>
                                    <div class="dt-responsive table-responsive">
                                        <table id="couponTable" class="table table-striped table-bordered nowrap">
                                            <thead>
                                                <tr>
                                                    <th>Sr No</th>
                                                    <th>Offer ID</th>
                                                    <th>Title</th>
                                                    <!-- <th>Offer On</th>
                                                    <th>Offer Type</th> -->
                                                    <th>Category</th>
                                                    <th>Sub-Category</th>
                                                    <th>Child Category</th>
                                                    <th>Product</th>
                                                    <th>Start Date</th>
                                                    <th>End Date</th>
                                                    <th>Product Sold</th>
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
<?php $this->load->view("admin/common/footer"); ?>


<script>
    $(document).ready(function () {

        $('#couponTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "<?php echo base_url('admin/offer/ajax_list') ?>",
                dataType: "json",
                type: "POST",
                data: {'<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>'}},
            columns: [
                {data: "srno"},
                {data: "offer_id"},
                {data: "title"},
                {data: "offer_on"},
                {data: "offer_type"},
                {data: "category_id"},
                {data: "discount_value"},
                {data: "valid_from"},
                {data: "valid_to"},
                {data: "status"},
                {data: "action"}
            ]


        });
    });
</script>