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
                                    <h4>Edit SMS Receivers</h4>
                                    <span></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="page-header-breadcrumb">
                                <ul class="breadcrumb-title">
                                    <li class="breadcrumb-item">
                                        <a href="<?php echo site_url(); ?>admin/dashboard"> <i class="feather icon-home"></i> </a>/ Edit SMS Receivers
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
                                    <h5>SMS Receivers</h5>
                                </div>
                                <div class="card-block">
                                    <div class="dt-responsive table-responsive offset-1">
                                        <div class="col-md-12">
                                            <form action="<?php echo base_url('admin/sms_receivers/edit_submit_receivers') ?>" method="post">
                                                <input type="hidden" name="edit_id" value="<?php echo $emp_info['id']; ?>" >
                                                <div class="form-group row">
                                                    <label for="emp_name">Employee Name : &nbsp;</label>&nbsp;&nbsp;
                                                    <input type="text" value="<?php echo set_value('emp_name', $emp_info['emp_name']); ?>" class="ml-4 form-control col-md-4" name="emp_name" onkeypress="return restrictAlphabets(event)">
                                                </div>
                                                <span class=" row text-danger">
                                                    <?php echo form_error('emp_name'); ?>
                                                </span>

                                                <div class="form-group row">
                                                    <label for="emp_mobile">Employee Mobile  : </label>&nbsp;&nbsp;
                                                    <input type="text" maxlength="10"  value="<?php echo set_value('emp_mobile', $emp_info['emp_mobile']); ?>" class="ml-4 form-control col-md-4" id="emp_mobile"  name="emp_mobile">
                                                </div>
                                                <span class=" row text-danger">
                                                    <?php echo form_error('emp_mobile'); ?>
                                                </span>

                                                <div class="form-group row">
                                                    <label for="sms_for">Receive SMS For : &nbsp;</label>&nbsp;&nbsp;
                                                    <select class="ml-4 form-control col-md-4" name="sms_for">
                                                        <option value="select">Select</option>
                                                        <option value="Order Cancel" <?php echo set_value('sms_for', $emp_info['sms_for']) == 'Order Cancel' ? 'selected' : ''; ?>>Order Cancel</option>
                                                        <option value="Order Processed" <?php echo $emp_info['sms_for'] == 'Order Processed' ? 'selected' : ''; ?>>Order Processed</option>
                                                        <option value="Order Delivered" <?php echo $emp_info['sms_for'] == 'Order Delivered' ? 'selected' : ''; ?>>Order Delivered</option>
                                                    </select>
                                                </div>
                                                <span class=" row text-danger">
                                                    <?php echo form_error('sms_for'); ?>
                                                </span>

                                                <div class="form-group row">
                                                    <label for="status">Status : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
                                                    <select class="form-control col-md-4 offset-1" name="status">
                                                        <option value="0">Select</option>
                                                        <option value="active" <?php echo set_value('status', $emp_info['status']) == 'active' ? 'selected' : ''; ?>>Active</option>
                                                        <option value="inactive" <?php echo set_value('status', $emp_info['status']) == 'inactive' ? 'selected' : ''; ?>>Inactive</option>
                                                    </select>
                                                </div>
                                                <span class=" row text-danger ">
                                                    <?php echo form_error('status'); ?>
                                                </span>

                                                <div class="form-group row ml-4">
                                                    <button type="submit" name="submit" style="margin-left: 120px;"
                                                            class=" btn btn-submit btn-danger">
                                                        Update
                                                    </button>
                                                     <a href="<?php echo base_url() ?>/admin/sms_receivers/view_receivers" class="btn btn-danger" style="margin-left: 20px;">Cancel </a>
                                                </div>

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
<?php $this->load->view("admin/common/footer"); ?>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.html5.min.js"></script>
<script>
    $(document).ready(function () {
        $('#emp_mobile').keydown(function (event) {

            if (event.shiftKey == true) {
                event.preventDefault();
            }

            if ((event.keyCode >= 48 && event.keyCode <= 57) ||
                    (event.keyCode >= 96 && event.keyCode <= 105) ||
                    event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 37 ||
                    event.keyCode == 39 || event.keyCode == 46 || event.keyCode == 190) {

            } else {
                event.preventDefault();
            }

            if ($(this).val().indexOf('.') !== 0 && event.keyCode == 190)
                event.preventDefault();
            //if a decimal has been added, disable the "."-button

        });

    });

    function restrictAlphabets(e) {
        var x = e.which || e.keycode;
        if ((x >= 65 && x <= 90) || (x >= 97 && x <= 122) || (x >= 48 && x <= 57) || x == 46 || x == 8 || x == 32)
            return true;
        else
            return false;
    }

</script>