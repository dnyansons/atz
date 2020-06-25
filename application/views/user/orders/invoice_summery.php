<!DOCTYPE html>
<html>
    <head>
        <title> seller summery invoice</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
		<link rel="icon" href="<?php echo base_url(); ?>assets/admin/images/favicon.ico" type="image/x-icon">
        <style>
            .border{
            border:1px solid #000;
            overflow: hidden;
            padding: 5px 10px;
            }
            .logo img{
            width: 160px;
            }

            .table td {
                border: 1px solid #000 !important;
    
                }

       .table th {
            border: 1px solid #000 !important;
    
            }

            hr{
                 border: 1px solid #0000007a;
            }
            @media (min-width: 1200px){
            .container {
            width: 1170px;
            }
            }
            @media (min-width: 992px){
            .container {
            width: 900px;
            }
            }
            @media only screen and (max-width: 480px) {
            .border{
            padding:5px 10px;
            } 	
            .fess{
            margin-left: 16px;
            }
            .bdtop{
            border-top: 1px solid #000;
            }
            .ddd{
            margin-top: 10px;
            }
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="border">
                <div class="row">
                    <div class="col-xs-12 col-md-12 col-sm-12 text-center">
                        <h5>ATZCart.com- Tax Invoice</h5>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-md-12 col-sm-12 text-center">
                        <h5><strong>Invoice Summary</strong></h5>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-md-1 col-sm-1"> </div>
                    <div class="col-xs-12 col-md-4 col-sm-4">
                        <span class="logo"><img src="<?php echo base_url(); ?>assets/front/images/logo/logo.png" class="img-fluid"></span>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-md-5 col-sm-5 fess">
                            <h5> <strong>Invoice:</strong> <span>12233456</span></h5>
                            <p><strong>Date Created: </strong><span><?php echo date('d-m-Y'); ?></span></p>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-xs-12 col-md-1 col-sm-1"> </div>
                    <div class=" col-xs-12 col-md-6 col-sm-6">
                        <address>
                            <strong>Issued to:</strong><span>&nbsp;<?php echo $summery['pick_name']; ?> </span> <br>
                            <strong>Seller Name and Address:&nbsp;</strong><span><?php echo $summery['pick_addr_type']; ?>, PIN-<?php echo $summery['pick_pincode']; ?>, <?php echo $summery['pick_mobile']; ?>  </br><?php echo $summery['pick_state']; ?> India.<br></span><br>
                            <strong>Sellers GSTN:</strong><span><?php echo $summery['gst']; ?></span><br>
                        </address>
                    </div>
                    <div class=" col-xs-12 col-md-5 col-sm-5 bdtop">
                        <address class="ddd">
                            <strong>Issued by:</strong><span> ATZ Cart</span> <br>
                            <strong>ATZCart.com name and address:</strong></br> <span> ATZ Cart PVT LTD<br> Plot No 44,, Phase 1, RGIP, Hinjawadi, Pune Maharashtra 411057</span><br>
                            <strong>ATZcart.com GSTIN: </strong><span> 27AASCA2908A1ZV </span><br>
                            <strong>ATZcart.com PAN:</strong><span> AASCA2908A</span><br>
                            <strong>ATZcart.com CIN No:</strong><span> U72900PN2019PTC184043</span>
                        </address>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <p class="text-center">The invoice summary is for the billing duration period (from date- to date)</p>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xs-12 col-sm-1 col-md-1"></div>
                    <div class="col-xs-12 col-sm-11 col-md-11">
                        <p>This is electronic generated invoice for the use of ATZCart.com services. The summary of this document is as follows and details.</p>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xs-12 col-md-12 col-sm-12 table-responsive">
                        <table class="table border">
                            <thead>
                                <tr>
                                    <th>Sr.No</th>
                                    <th>Orders (total number of order)</th>
                                    <th>Product Charges</th>
                                    <th>ATZCart Fees</th>
                                    <th>Taxable Fees</th>
                                    <th>Refunds</th>
                                    <th>Total Payable Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td><?php echo $summery['total_order']; ?></td>
                                    <td><?php echo $summery['product_charges']; ?></td>
                                    <td><?php echo $summery['atz_fees']; ?></td>
                                    <td><?php echo $summery['taxable_fees']; ?></td>
                                    <td><?php echo $summery['refunds']; ?></td>
                                    <td><?php echo $summery['total_amount']; ?></td>
                                </tr> 
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-md-12 col-sm-12">
                        <ol type="number">
                            <li>To get GST input, please make sure that you have updated your GSTIN in your sellers profile.</li>
                            <li>All the Invoice are inclusive of GST.</li>
                            <li>In case your GSTIN is not updated then, SGST & CGST invoice will be generated.</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>