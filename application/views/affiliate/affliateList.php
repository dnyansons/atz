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
                                    <li class="breadcrumb-item"><a href="#">Affiliate List</a></li>
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
                                            <p class="filter-form-label">From</p>
                                            <input type="text" class="form-control" id="dateFrom" name="dateFrom">
                                        </div>
                                        <div class="col-md-3">
                                            <p class="filter-form-label">To</p>
                                            <input type="text" class="form-control" id="dateTo" name="dateTo">
                                        </div>
                                        <div class="col-md-2">
                                            <p class="filter-form-label">&nbsp;</p>
                                            <button class="btn btn-info btn-sm btn-block" id="btnFilter">Filter</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <?php echo $this->session->flashdata('message'); ?>
                            <div id="approve_message"> </div>
                            <div class="card">
                                <div class="card-block">
                                    <div class="dt-responsive table-responsive">
                                        <table id="affiliateTable" class="table table-striped table-bordered nowrap">
                                            <thead>
                                                <tr>
                                                    <th>Sl.no</th>
                                                    <?php if ($page == "Pending") { ?>
                                                        <th>Added Date</th>
                                                    <?php } else if ($page == "Approved") { ?>
                                                        <th> Approved On </th>
                                                    <?php } else { ?>
                                                        <th> Rejected On </th>
                                                    <?php } ?>
                                                    <th>Affiliate Id</th>
                                                    <th>Name</th>
                                                    <th>Company</th>
                                                    <?php if ($page == "Rejected") { ?>
                                                      <th>Rejected Reason</th>
                                                    <?php } ?>
                                                    <th> Action </th>
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

<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script>
    $(document).ready(function () {

        var dtTable = $('#affiliateTable').DataTable({
            processing: true,
            serverSide: true,
            order: [[0, "desc"]],
            "ajax": {
                "url": "<?php echo base_url($get_url) ?>",
                "type": "POST",
                "data": function (data) {

                    data.fromdate = $('#dateFrom').val();
                    data.todate = $('#dateTo').val();
                    data.status = "<?php echo $status; ?>";
                    data.<?php echo $this->security->get_csrf_token_name(); ?> = "<?php echo $this->security->get_csrf_hash(); ?>";

                },
            },

        });

        $(document).on('click', '#btnFilter', function () {
            dtTable.clear().draw();
        });


        $("#dateFrom").dateDropper({
            format: "d-m-Y",
            dropWidth: 200,
            dropPrimaryColor: "#1abc9c",
            dropBorder: "1px solid #1abc9c",
            maxYear: "2020",
        });
        $("#dateTo").dateDropper({
            format: "d-m-Y",
            dropWidth: 200,
            dropPrimaryColor: "#1abc9c",
            dropBorder: "1px solid #1abc9c",
            maxYear: "2020",
        });

    });

</script>