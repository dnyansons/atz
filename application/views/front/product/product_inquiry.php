
<?php $this->load->view("front/common/header"); ?>
<div class="main">

    <div class="container py-3">
        <div class="row">
            <div class="detail-box box-type-subscribe col-lg-12 text-center">
                <div class="detail-subscribe top-subscribe" data-spm="debelsubf">
                    <ol class="detail-breadcrumb" style="color: #000;" >
                        Product 
                    </ol>
                    <ol class="detail-breadcrumb" style="color: #000;">
                        Send Inquiry
                    </ol>
                </div>
            </div>


            <div class="mx-auto col-sm-6">
                <!-- form user info -->
                <div class="card">
                    <div class="card-header">
                        <h4 class="mb-0"> Contact supplier </h4>
                    </div>
                    <div class="card-body">

                        <?php echo $this->session->flashdata("inquiry_message"); ?>
                        <table class="table table-striped table-bordered">
                            <tbody>
                                <tr>
                                    <td width="">
                                        <img class="product-img" src="<?php echo $product['images'][0]; ?>">
                                    </td>
                                    <td>
                                        <a class="product-name" href="<?php echo base_url('home_product/get_Product_details/') . $product['id']; ?>" 
                                           title="<?php echo $product['name']; ?>"><?php echo $product['name']; ?>
                                        </a>
                                        <br />
                                        Supplier : <?php echo $product['company_name']; ?>
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                        <form class="form" role="form" action="<?php echo site_url('home_product/product_inquiry/') . $product["id"]; ?>" method="post" enctype="multipart/form-data" name="contact_supplier">
                            <input type="hidden" name="for_product" value="<?php echo $product["id"]; ?>">


                            <div class="form-group row mb-4">
                                <label class="col-lg-3 col-form-label form-control-label ">

                                    Quantity <span style="color:red;">*</span>
                                </label>
                                <div class="col-lg-9 ">
                                    <input type="text" class="form-control" name="quantity" min="1" value="<?php echo set_value('quantity'); ?>"></br>
                                    <?php echo form_error('quantity'); ?>
                                </div>
                            </div>
                            <div class="form-group row mb-4">
                                <label class="col-lg-3 col-form-label form-control-label">
                                    Unit <span style="color:red;">*</span>
                                </label>
                                <div class="col-lg-9">
                                    <select class="form-control" name="unit">
                                        <option value="">Select</option>
                                        <?php
                                        foreach ($units as $row) {
                                            if ($row["units_id"] == "54") {
                                                $selected = "selected";
                                            } else {
                                                $selected = "";
                                            }
                                            ?>

                                            <option value="<?php echo $row['units_id']; ?>" <?php echo $selected; ?>><?php echo $row['units_name']; ?></option>
                                    <?php } ?>
                                    </select></br>
<?php echo form_error('unit'); ?>
                                </div>
                            </div>
                            <div class="form-group row mb-4">
                                <label class="col-lg-3 col-form-label form-control-label">
                                    Description <span style="color:red;">*</span>
                                </label>
                                <div class="col-lg-9">
                                    <textarea id="inquiry-content" name="product_description" class="ui2-textfield-multiple content ui2-textfield"  placeholder="Enter product details such as color, size, materials etc. and other specification requirements to receive an accurate quote." value="<?php echo set_value('product_description'); ?>" ></textarea>

                                    <div class="pt-3"> <?php echo form_error('product_description'); ?> </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label form-control-label">
                                    Attachment
                                </label>
                                <div class="col-lg-9">
                                    <input type="file" name="userFiles" id="file_input" multiple="multiple">
                                </div>
                            </div>			

                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label form-control-label"></label>
                                <div class="col-lg-9">
                                    <div class="send-item">
                                        <input type="submit" class="ui2-button  " value="Send inquiry now">	
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- /form user info -->
            </div>
        </div>
    </div>
    <br>

</div>
<?php $this->load->view("front/common/footer"); ?>