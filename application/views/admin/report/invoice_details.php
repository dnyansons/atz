<?php $this->load->view("admin/common/header"); ?>
<div class="pcoded-content">
    <div class="pcoded-inner-content">

        <div class="main-body">
            <div class="page-wrapper">

                <div class="page-body">

                    <div class="container">
                        
                        <div>
                            `
                            <div class="card">
                                <h3 class="text-center">Tax Invoice</h3>
                                <div class="row invoice-contact">
                                    <div class="col-md-8">
                                        <div class="invoice-box row">
                                            <div class="col-sm-12">
                                                <table class="table table-responsive invoice-table table-borderless">
                                                    <tbody>
                                                        <tr>
                                                            <td><img src="<?php echo base_url();?>/assets/images/logo.png" class="m-b-10" alt=""></td>
                                                        </tr>

                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                    </div>
                                </div>
                                <div class="card-block">
                                    <div class="row invoive-info">
                                        <div class="col-md-4 col-xs-12 invoice-client-info">
                                            <h6>Atzcart</h6>
                                            <p class="m-0 m-t-10">Midas Tower, Plot No:44, Phase 1,RGIP Hinjawadi,<br />Pune,Maharashtra, 411057, India</p>
                                            <p class="m-0">+1800-212-2036</p>
                                            <p><a href="#" class="__cf_email__" data-cfemail="355150585a754d4c4f1b565a58">[billing@atzcart.com]</a></p>
                                        </div>
                                        <div class="col-md-4 col-sm-6">
<!--                                            <h6>Order Information :</h6>
                                            <table class="table table-responsive invoice-table invoice-order table-borderless">
                                                <tbody>
                                                    <tr>
                                                        <th>Date :</th>
                                                        <td>November 14</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Status :</th>
                                                        <td>
                                                            <span class="label label-warning">Pending</span>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th>Id :</th>
                                                        <td>
                                                            #145698
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>-->
                                        </div>
                                        <div class="col-md-4 col-sm-6">
                                            <h6><?php echo $item->first_name." ".$item->last_name;?></h6>
                                            <p class="m-0 m-t-10"><?php echo $item->address;?></p>
                                            <p class="m-0"><?php echo $item->phone;?></p>
                                            <p><a href="#" class="__cf_email__" data-cfemail="355150585a754d4c4f1b565a58">[<?php echo $item->name;?>]</a></p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="table-responsive">
                                                <table class="table  invoice-detail-table">
                                                    <thead>
                                                        <tr class="thead-default">
                                                            <th>Description</th>
                                                            <th>Amount</th>
                                                            <th>Total</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>
                                                                <h6>Total Turnover</h6>
                                                            </td>
                                                            <td><?php echo $item->amount;?></td>
                                                            <td><?php echo $item->amount;?></td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <h6>Return</h6>
                                                            </td>
                                                            <td><?php echo $return;?></td>
                                                            <td><?php echo $return;?></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <table class="table table-responsive invoice-table invoice-total">
                                                <tbody>
                                                    <tr>
                                                        <th>Sub Total :</th>
                                                        <td><?php echo $item->amount;?></td>
                                                    </tr>
                                                    <tr>
                                                        <th>CGST 9%</th>
                                                        <td><?php echo $item->gst / 2;?></td>
                                                    </tr>
                                                    <tr>
                                                        <th>SGST 9%</th>
                                                        <td><?php echo $item->gst / 2;?></td>
                                                    </tr>
                                                    <tr class="text-info">
                                                        <td>
                                                            <hr />
                                                            <h5 class="text-primary">Total :</h5>
                                                        </td>
                                                        <td>
                                                            <hr />
                                                            <h5 class="text-primary"><?php echo $item->amount;?></h5>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="row">
<!--                                        <div class="col-sm-12">
                                            <h6>Terms And Condition :</h6>
                                            <p>lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor </p>
                                        </div>-->
                                    </div>
                                </div>
                            </div>

                            <div class="row text-center">
                                <div class="col-sm-12 invoice-btn-group text-center">
                                    <button type="button" class="btn btn-primary btn-print-invoice m-b-10 btn-sm waves-effect waves-light m-r-20">Print</button>
                                    <button type="button" class="btn btn-danger waves-effect m-b-10 btn-sm waves-light">Cancel</button>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </div>

        <div id="styleSelector">
        </div>
    </div>
</div>
<?php $this->load->view("admin/common/footer"); ?>