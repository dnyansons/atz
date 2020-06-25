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
                                    <h4>Add Role</h4>

                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="page-header-breadcrumb">
                                <ul class="breadcrumb-title">
                                    <li class="breadcrumb-item">
                                        <a href="<?php echo site_url(); ?>admin/dashboard"> <i class="feather icon-home"></i> </a>
                                    </li>
                                    <li class="breadcrumb-item"><a href="<?php echo site_url(); ?>admin/role">Role</a>
                                    </li>
                                    <li class="breadcrumb-item"><a href="#">Create New</a>
                                    </li>
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


                                    <div class="card-header-right">
                                        <i class="icofont icofont-spinner-alt-5"></i>
                                    </div>
                                </div>
                                <div class="card-block">
                                    <h4 class="sub-title">Role</h4>
                                    <form method="post" enctype="multipart/form-data">

                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Role</label>
                                            <div class="col-sm-10">
                                                <input type="text" name="role_name" id="role_name" class="form-control" placeholder="Role Name" required>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Status</label>
                                            <div class="col-sm-10">
                                                <select class="form-control" name="status">
                                                    <option value="">Select Status</option>
                                                    <option value="Active">Active</option>
                                                    <option value="Inactive">Inactive</option>
                                                </select>
                                            </div>
                                        </div>


                                        <button type="submit" id="submit_brand" class="btn btn-primary pull-right" id="primary-popover-content">Add Role</button>

                                    </form>


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
</div>
</div>
</div>


<script>

    $(document).ready(function () {

        $('.date').datepicker({
            format: "dd/mm/yyyy",
            autoclose: true,
        });

    });

</script>

<?php $this->load->view("admin/common/footer"); ?>