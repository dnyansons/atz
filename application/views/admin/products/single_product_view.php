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
                                    <h4>
                                        Single Product Details                                         
                                    </h4>
                                    <span></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="page-header-breadcrumb">
                                <ul class="breadcrumb-title">
                                    <li class="breadcrumb-item">
                                        <a href="<?php echo site_url(); ?>admin/dashboard">
                                            <i class="feather icon-home"></i> </a>
                                    </li>
                                    <li class="breadcrumb-item"><a href="#">Product Details </a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-12">
                            <a href="<?php echo base_url('admin/products/update/'.$productData['product_details']->id); ?>" class="btn btn-sm btn-success float-right" style="font-size:1em; font-weight:bold;">Edit</a>
                                <p class="h5 text-uppercase">Product Name :
                                    <b><?php echo $productData['product_details']->name; ?> <a href="#"
                                            class="badge badge-info">PRD<?php echo $productData['product_details']->id; ?></a></b>
                                </p>
                            </div>
                        </div>
                        <div class="row text-dark">
                            <span class="col-md-5">
                                <b>Created At : </b><i><?php echo $productData['product_details']->created_date; ?></i>
                            </span>
                            <span class="col-md-2">
                            </span>
                            <span class="col-md-5">
                                <b>Modified At :
                                </b><i><?php echo $productData['product_details']->modified_date? : '--'; ?></i>
                            </span>
                        </div>
                        <div class="row">
                            <span class="col-md-5 text-info">
                                <b>Requested On :
                                </b><i><?php echo $productData['product_details']->requested_date? : '--'; ?></i>
                            </span>
                            <span class="col-md-2">
                            </span>
                            <span class="col-md-5 text-success">
                                <b>Approved On :
                                </b><i><?php echo $productData['product_details']->approved_date? : '--'; ?></i>
                            </span>
                        </div>
                        <div class="row">
                            <span class="col-md-5 text-dark">
                                <b>Publish Status :</b>
                                <i><?php echo $this->Product_model->showStatusIcons(strtoupper($productData['product_details']->publish_status)); ?></i>
                            </span>
                            <span class="col-md-2">
                            </span>
                            <span class="col-md-5 text-dark">
                                <b>Approved By :
                                </b><i><?php echo $productData['product_details']->admin_firstname? : '--'; ?></i>
                            </span>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-12" style="font-size:1.2em;">
                                Seller Name :
                                <b><?php echo $productData['product_details']->seller_name; ?></b>
                            </div>
                        </div>
                        <div class="row text-dark">
                            <span class="col-md-5">
                                <b>Email : </b><i><?php echo $productData['product_details']->email; ?></i>
                            </span>
                            <span class="col-md-2">
                            </span>
                            <span class="col-md-5">
                                <b>Mobile : </b><i><?php echo $productData['product_details']->phone; ?></i>
                            </span>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-12">
                                <h5 class="text-dark"><b class="text-uppercase"><i
                                            class="fa fa-key font-weight-bold"></i> &nbsp; Keywords :</b>
                                    <?php echo $productData['product_details']->keywords; ?>
                                </h5>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="page-body">
                    <div id="printOrder">
                        <div class="row">
                            <div class="col-md-12 col-lg-12">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h5 class="font-weight-bold"><i class="fa fa-list-alt"></i> &nbsp; Product
                                            Details
                                        </h5>
                                    </div>
                                    <table class="table table-bordered">
                                        <tbody>
                                            <tr class="text-uppercase">
                                                <th>Quantity</th>
                                                <th class="text-uppercase" width="15%">Category</th>
                                                <th>Dimension<br>(L * H * W) </th>
                                                <th>Weight/Per </th>
                                                <th>Provide Order<br> At Buyers Place</th>
                                                <th>Product<br>Returnable</th>
                                                <th>Return<br>Days</th>
                                            </tr>
                                            <tr>
                                                <th>
                                                    <b class="badge badge-success" style="font-size:1em">
                                                        <?php echo $productData['product_details']->available_quantity?>
                                                    </b>
                                                </th>
                                                <th>
                                                    <?php echo $productData['product_details']->categories_name?>
                                                </th>
                                                <td><?php echo $productData['product_details']->length.'*'.
                                                               $productData['product_details']->height.'*'.
                                                               $productData['product_details']->width; ?></td>
                                                <td><?php echo $productData['product_details']->weight; ?></td>
                                                <td><?php echo $productData['product_details']->provide_order_at_buyer_place == 1 ? 'Yes':'No'; ?>
                                                </td>
                                                <td><?php echo $productData['product_details']->is_product_returnable; ?>
                                                </td>
                                                <td><?php echo $productData['product_details']->product_return_days; ?>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h5 class="font-weight-bold"><i class="fa fa-list-ol"></i> &nbsp; Product Specifications
                                </h5>
                            </div>
                            <table class="table table-bordered">
                                <tbody>
                                    <tr class="text-uppercase">
                                        <th>Attribute</th>
                                        <th>Specifications</th>
                                    </tr>
                                    <?php foreach($productData['product_specs'] as $key => $vals ) { 
                                                echo "<tr><td><b>".$key."</b></td>".
                                                "<td>".$vals."</td></tr>";
                                              }?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <br />
                    <div class="page-body">
                        <div id="printableArea">
                            <div class="row">
                                <div class="col-md-12 col-lg-12">
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <h5 class="font-weight-bold"><i class="fa fa-rupee"
                                                    style="font-size: 18px;"></i> &nbsp; Product Price</h5>
                                        </div>
                                        <table class="table table-bordered">
                                            <tr class="text-uppercase">
                                                <th>Quantity From - To</th>
                                                <th>Seller Price</th>
                                                <th>Hike(%)</th>
                                                <th>ATZ Price</th>
                                                <th>Discount(%)</th>
                                                <th>Final Price</th>
                                            </tr>

                                            <?php  
                                                    foreach ($productData['product_price'] as $obj) {    ?>
                                            <tr>
                                                <td>
                                                    <?php echo $obj->quantity_from. '--'. $obj->quantity_upto; ?>
                                                </td>
                                                <td>
                                                    <?php echo $obj->price; ?>
                                                </td>
                                                <td>
                                                    <?php echo $productData['product_details']->hike_percentage; ?>
                                                </td>
                                                <td>
                                                    <?php echo $obj->atz_price; ?>
                                                </td>
                                                <td>
                                                    <?php echo $productData['product_details']->discount_percentage; ?>
                                                </td>
                                                <td>
                                                    <?php echo $obj->final_price; ?>
                                                </td>
                                            </tr>
                                            <?php } ?>
                                        </table>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <br />
                    <div class="page-body">
                        <div id="printableArea">
                            <div class="row">
                                <div class="col-md-12 col-lg-12">
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <h5 class="font-weight-bold"><i class="fa fa-image"
                                                    style="font-size: 18px;"></i> &nbsp; Product Media</h5>
                                        </div>
                                        <table class="table table-bordered">
                                            <?php foreach ($productData['product_media'] as $objMedia) { 
                                                    ?>
                                            <tbody>
                                                <tr>
                                                    <?php if(!empty($objMedia->url)) { ?>
                                                    <td><?php echo strtoupper($objMedia->type). '<br> Upload Date : '. $objMedia->created_date; ?>
                                                    </td>
                                                    <td>
                                                        <?php if($objMedia->type == 'photo') { ?>
                                                        <img src="<?php echo $objMedia->url; ?>" style="width:120px;"
                                                            class="border p-1 rounded mx-auto d-block">
                                                        <?php } else { ?>

                                                        <?php } ?>
                                                    </td>
                                                </tr>
                                                <?php 
                                                } }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                    <br>
                    <div class="card">
                    <div class="card-body">
                        <div class="card-title">
                            <h5 class="font-weight-bold"><i class="fa fa-align-justify"></i> &nbsp; Product Description
                            </h5>
                        </div>
                        <p class="card-text">
                            <?php echo $productData['product_details']->description;?>
                        </p>
                        </div>
                    </div>
                </div>

                <br />

            </div>
        </div>
    </div>
</div>
</div>
</div>
<</div> <?php $this->load->view("admin/common/footer"); ?>