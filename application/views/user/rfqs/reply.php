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
                                        <a href="<?php echo site_url(); ?>admin/dashboard"> <i class="feather icon-home"></i> </a>
                                    </li>
                                    <li class="breadcrumb-item"><a href="#">Requests Reply</a></li>
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
                                    <h5>Requests Reply</h5>
                                </div>

                                <form action="<?php echo site_url("seller/rfqs/reply/" . $id . "/" . $rfqid); ?>" enctype='multipart/form-data' method="post">
                                    <div class="card-block">

                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Attachment *</label>
                                            <div class="col-sm-10">
                                                <input type="file" name="quote_attachment" class="form-control">
                                                <div style="color:red"><?php echo form_error("quote_attachment"); ?></div>
                                                <span> allowed file types doc|pdf|docx </span>
                                            </div>

                                        </div>

                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Quantity *</label>
                                            <div class="col-sm-10">
                                                <input type="textbox" name="quantity" class="form-control" value="<?php echo set_value("quantity"); ?>">
                                                <div style="color:red"><?php echo form_error("quantity"); ?></div>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Unit</label>
                                            <div class="col-sm-10">
                                                <select name="unit" class="form-control">
                                                    <?php foreach ($units as $row) { ?>
                                                        <option value="<?php echo $row['units_id']; ?>"><?php echo $row['units_name']; ?></option>
                                                    <?php } ?>
                                                </select>

                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Price *</label>
                                            <div class="col-sm-10">
                                                <input type="textbox" name="price" class="form-control" value="<?php echo set_value("price"); ?>">
                                                <div style="color:red"><?php echo form_error("price"); ?></div>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Comment *</label>
                                            <div class="col-sm-10">
                                                <textarea rows="5" cols="5" name="comment" class="form-control" placeholder="Comment"><?php echo set_value("comment"); ?></textarea>
                                                <div style="color:red"><?php echo form_error("comment"); ?></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <div class="form-group row">
                                            <label class="col-sm-2"></label>
                                            <div class="col-sm-10">
                                                <button type="submit" class="btn btn-primary m-b-0">Submit</button>
                                            </div>
                                        </div>
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
<?php $this->load->view("user/common/footer"); ?>
