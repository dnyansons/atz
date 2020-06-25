<?php $this->load->view('front/common/header'); ?>
<style>
    .rfq_wrapper{
        margin: 0 auto 40px;
        padding: 20px 80px;
        box-sizing: border-box;
        background: #fff;
        border: 1px solid #dbe1ed;
        border-radius: 4px;
    }
    .text{
        margin-bottom:10px;	}

    .unit{
        margin-top: 0px !important;
    }
    p{
        margin-bottom: 0px !important;
    }
	textarea:focus {
      border:1px solid #4FC1F0 !important;
  
    }

</style>
<div class="page-header">
    <div class="container">
        <h1>Request for Quotation</h1>
    </div>

    <div class="page-body">
        <div class="container rfq_wrapper">
            <div class="col-8"><?php echo $this->session->flashdata('message'); ?> </div>
            <div class="row">
                <div class="col-7">
                    <h4 class="sub-title">Tell suppliers what you need</h4>
                    <h5>Complete Your RFQ</h5>
                    <div class="box-block">
                        <form action="<?php echo base_url(); ?>welcome/insert_rfqs" name="frm_sumbit_rfq" method="post" enctype="multipart/form-data">
                          <div class="col-md-11 pl-0"><p>The more specific your information, the more accurately we can match your request to the right suppliers</p></div>                      
						   <div class="form-group ">                               
                                <br>
                                <p>Product <span style="color:red">*</span></p>
                                <input type="text" class="col-md-11" placeholder="Key words of products you are looking for" name="product_name" value="<?php echo set_value('product_name', $arr['product_name']); ?>" >
                                <?php echo form_error('product_name'); ?>
                            </div>
                            <br />
                            <div class="form-group">
                                <p>Please select a category <span style="color:red">*</span></p>
                                <select name="categories_id" class="form-control subject-control col-md-11" ><!--class="form-control ui2-form-control subject-control"-->
                                    <option value="">Select Category</option>
                                    <?php
                                    foreach ($categories_list as $category) {
                                        if (count($category->sub) > 0) {
                                            echo "<optgroup label='" . $category->categories_name . "'>";
                                            foreach ($category->sub as $cat) {

                                                if ($cat->category_id == $products_data->categories_id) {
                                                    echo "<option value='" . $cat->category_id . "' selected='selected'>" . $cat->categories_name . "</option>";
                                                } else {
                                                    echo "<option value='" . $cat->category_id . "'>" . $cat->categories_name . "</option>";
                                                }
                                            }
                                            echo "</optgroup>";
                                            ?>
                                            <?php
                                        } else {
                                            echo "<option value='" . $category->category_id . "'>" . $category->categories_name . "</option>";
                                        }
                                        ?>
                                    <?php } ?>
                                </select>
                                <?php echo form_error('categories_id'); ?>
                                <br />
                                <div class="form-group">
                                    <p>Please select quantity  <span style="color:red">*</span></p>
                                    <div class="input-group mb-3">
                                        <input type="text" class="form-control col-md-11" placeholder="Quanitity"  name= "quantity" value="<?php echo set_value('quantity', $arr['quantity']); ?>" >
                                        <?php echo form_error('quantity'); ?> 
								    </div>	
                                 <p>Please select unit <span style="color:red">*</span></p>									
                                    <div class="input-group mb-3">
                                        <select class="form-control unit col-md-11" name="unit">
                                            <option value="">select</option>
                                            <?php
                                            foreach ($units as $row) {

                                                if ($arr['unit'] == $row['units_id']) {
                                                    ?>
                                                    <option value="<?php echo $row['units_id']; ?>" selected><?php echo $row['units_name']; ?></option>
                                                <?php } else { ?>
                                                    <option value="<?php echo $row['units_id']; ?>" ><?php echo $row['units_name']; ?></option>
                                            <?php }
                                        } ?>
                                        </select>
                                        <?php echo form_error('quantity'); ?>
                                    </div>
                                </div>
                                <!--<br />-->

                                <div class="form-group">
                                    <p>Description <span style="color:red">*</span></p>
                                    <textarea rows="4" cols="50" name="product_specification" class="form-control col-md-11" placeholder="Input Your Text Here..." value="<?php echo set_value('product_specification'); ?>"></textarea>
                                    <?php echo form_error('product_specification'); ?>
                                </div>

                                <!--<br />-->
                                <div class="form-group">
                                    <p>you can also attach image (optional)</p>
                                    <input type="file" name="userFiles" class="form-control col-md-6">
                                </div>
                                <br />
                                <div class="form-group">
                                    <input type="submit"  id="submit_form_data" class="btn btn-block btn-info col-md-6" value="Submit RFQ" >
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-5">
                    <h4>Request for quotation</h4>
                    <h5>guidelines</h5>

                    <ul class="list-group">
                        <li class="list-group-item">Fill correct keywords</li>
                        <li class="list-group-item">Enter estimated bulk order quantity first even if you’re requesting for samples</li>
                        <li class="list-group-item">Input product details.You may include: color, size, material, grade/standard, etc</li>
                    </ul>

                </div>

            </div>
        </div>
    </div>
</div>
<?php $this->load->view('front/common/footer'); ?>
<script type="text/javascript">
    function restrictAlphabets(e) {
        var x = e.which || e.keycode;
        if ((x >= 65 && x <= 90) || (x >= 97 && x <= 122) || x == 46 || x == 8 || x == 32)
            return true;
        else
            return false;
    }
</script>