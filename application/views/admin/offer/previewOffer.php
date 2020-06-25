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
                                    <h4>Offer Price Changes Preview</h4>
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
                                    <li class="breadcrumb-item"><a href="#">Offer Preview</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="page-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="card">
                                <div class="card-block">
                                    <div class="dt-responsive table-responsive">
                                        <div class="h5 text-center m-1 p-1 font-weight-bold text-uppercase text-muted">Offer applies on ATZ Price </div>
                                        <table id="offerTable" class="table table-striped table-bordered nowrap">
                                            <thead>
                                                <tr>
                                                    <th>Sr No</th>
                                                    <th>Name</th>
                                                    <th>Product Id</th>
                                                    <th>Seller Price</th>
                                                    <th>Hike</th>
                                                    <th class="text-success font-weight-bold">ATZ Price</th>
                                                    <th>Default Discount</th>
                                                    <th>Final Price</th>
                                                    <th>Offer Discount</th>
                                                    <th class="text-warning font-weight-bold">Offer Price</th>
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

        $('#offerTable').DataTable({
            "processing": true,
            "serverSide": false,
            "searching": false,
            "sorting": false,
            ajax: {
                url: "<?php echo base_url('admin/offer/ajaxListDatatable') ?>",
                dataType: "json",
                type: "POST",
                data: {
                    "offerType": "<?php echo $this->uri->segment(4, 0); ?>",
                    "offerDiscount": "<?php echo $this->uri->segment(5, 0); ?>",
                    "categoryId": "<?php echo $this->uri->segment(6, 0); ?>",
                    '<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>'}},
            columns: [
                {data: "srno"},
                {data: "name"},
                {data: "product_id"},
                {data: "price"},
                {data: "default_hike"},
                {data: "atz_price"},
                {data: "default_discount"},
                {data: "final_price"},
                {data: "offerDiscount"},
                {data: "offer_price"}
            ]
        });
    });
</script>