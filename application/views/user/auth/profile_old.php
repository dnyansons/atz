<?php $this->load->view("supplier/common/header");?>
<div class="pcoded-content">
<div class="pcoded-inner-content">
<div class="main-body">
<div class="page-wrapper">
<div class="page-header">
    <div class="row align-items-end">
        <div class="col-lg-8">
            <div class="page-header-title">
                <div class="d-inline">
                    <h4>Manage Profile</h4>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="page-header-breadcrumb">
                <ul class="breadcrumb-title">
                    <li class="breadcrumb-item">
                        <a href="#"> <i class="feather icon-home"></i> </a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">Supplier</a></li>
                    <li class="breadcrumb-item"><a href="#!">Manage Profile</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>
<form method="post" enctype="multipart/form-data" id="profile_form">
    <div class="page-body">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-block">
                    <div class="row m-b-30">
                        <div class="col-lg-12 col-xl-12 col-md-12 col-sm-12">
                            <div class="sub-title text-right"></div>
                            <ul class="nav nav-tabs md-tabs" role="tablist">
                                <li class="nav-item ">
                                    <a class="nav-link active" data-toggle="tab" href="#com_detail" role="tab">Company Detail</a>
                                    <div class="slide"></div>
                                </li>
                                <li class="nav-item ">
                                    <a class="nav-link" data-toggle="tab" href="#manufacturing" role="tab">Manufacturing Capability</a>
                                    <div class="slide"></div>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#quality_control" role="tab">Options & Quality Control</a>
                                    <div class="slide"></div>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#seo" role="tab">R&D Capability</a>
                                    <div class="slide"></div>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#miscellaneous" role="tab">Export Capability</a>
                                    <div class="slide"></div>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#seller" role="tab">Company Info</a>
                                    <div class="slide"></div>
                                </li>
                            </ul>
                            <div class="tab-content card-block">
                                <div class="tab-pane active" id="com_detail" role="tabpanel">
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
                                                        <div class="form-group row">
                                                            <label class="col-sm-2 col-form-label">Company Name</label>
                                                            <div class="col-sm-10">
                                                                <input type="text" name="company_name" id="company_name" class="form-control" placeholder="Company Name">
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label class="col-sm-2 col-form-label">Location of Registration</label>
                                                            <div class="col-sm-10">
                                                                <div class="form-group row">
                                                                    <label class="col-sm-4 col-form-label"> Province/State/County</label>
                                                                    <div class="col-sm-8">
                                                                        <input type="text" name="products_model" id="products_model" class="form-control" placeholder="Province/State/County">
                                                                    </div>
                                                                </div>
                                                                <div class="form-group row">
                                                                    <label class="col-sm-4 col-form-label">Country/Region</label>
                                                                    <div class="col-sm-8">
                                                                        <input type="text" name="products_model" id="products_model" class="form-control" placeholder="Country/Region">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label class="col-sm-2 col-form-label">Company Operational Address</label>
                                                            <div class="col-sm-10">
                                                                <div class="form-group row">
                                                                    <label class="col-sm-4 col-form-label">Street</label>
                                                                    <div class="col-sm-8">
                                                                        <input type="text" name="products_model" id="products_model" class="form-control" placeholder="Street">
                                                                    </div>
                                                                </div>
                                                                <div class="form-group row">
                                                                    <label class="col-sm-4 col-form-label">City</label>
                                                                    <div class="col-sm-8">
                                                                        <input type="text" name="products_model" id="products_model" class="form-control" placeholder="City">
                                                                    </div>
                                                                </div>
                                                                <div class="form-group row">
                                                                    <label class="col-sm-4 col-form-label">Province/State/County</label>
                                                                    <div class="col-sm-8">
                                                                        <input type="text" name="products_model" id="products_model" class="form-control" placeholder="Province/State/County">
                                                                    </div>
                                                                </div>
                                                                <div class="form-group row">
                                                                    <label class="col-sm-4 col-form-label">Country/Region</label>
                                                                    <div class="col-sm-8">
                                                                        <input type="text" name="products_model" id="products_model" class="form-control" placeholder="Country/Region">
                                                                    </div>
                                                                </div>
                                                                <div class="form-group row">
                                                                    <label class="col-sm-4 col-form-label">Zip/Postal Code</label>
                                                                    <div class="col-sm-8">
                                                                        <input type="text" name="products_model" id="products_model" class="form-control" placeholder="Zip/Postal Code">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label class="col-sm-2 col-form-label">Main Products</label>
                                                            <div class="col-sm-2">
                                                                <input type="text" name="main_product_one" id="main_product_one" class="form-control" placeholder="">
                                                            </div>
                                                            <div class="col-sm-2">
                                                                <input type="text" name="main_product_two" id="main_product_two" class="form-control" placeholder="">
                                                            </div>
                                                            <div class="col-sm-2">
                                                                <input type="text" name="main_product_three" id="main_product_three" class="form-control" placeholder="">
                                                            </div>
                                                            <div class="col-sm-2">
                                                                <input type="text" name="main_product_four" id="main_product_four" class="form-control" placeholder="">
                                                            </div>
                                                            <div class="col-sm-2">
                                                                <input type="text" name="main_product_five" id="main_product_five" class="form-control" placeholder="">
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label class="col-sm-2 col-form-label">Other Products you sell</label>
                                                            <div class="col-sm-2">
                                                                <input type="text" name="other_product_one" id="other_product_one" class="form-control" placeholder="">
                                                            </div>
                                                            <div class="col-sm-2">
                                                                <input type="text" name="other_product_two" id="other_product_two" class="form-control" placeholder="">
                                                            </div>
                                                            <div class="col-sm-2">
                                                                <input type="text" name="other_product_three" id="other_product_three" class="form-control" placeholder="">
                                                            </div>
                                                            <div class="col-sm-2">
                                                                <input type="text" name="other_product_four" id="other_product_four" class="form-control" placeholder="">
                                                            </div>
                                                            <div class="col-sm-2">
                                                                <input type="text" name="other_product_five" id="other_product_five" class="form-control" placeholder="">
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label class="col-sm-2 col-form-label">Year Company Registered</label>
                                                            <div class="col-sm-10">
                                                                <select name="year_of_register" class="form-control">
                                                                    <option value="">Selecy Year of register</option>
                                                                    <?php 
                                                                        $y=date('Y');
                                                                        while($y >=1920)
                                                                        {
                                                                        echo' <option value="'.$y.'">'.$y.'</option>';
                                                                        $y--;
                                                                        }
                                                                        ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label class="col-sm-2 col-form-label">Total No. Employees</label>
                                                            <div class="col-sm-10">
                                                                <select name="no_of_employee" class="form-control">
                                                                    <option value="">--- Please select ---</option>
                                                                    <option value="1">Fewer than 5 People</option>
                                                                    <option value="2">5 - 10 People</option>
                                                                    <option value="3">11 - 50 People</option>
                                                                    <option value="4">51 - 100 People</option>
                                                                    <option value="5">101 - 200 People</option>
                                                                    <option value="6">201 - 300 People</option>
                                                                    <option value="7">301 - 500 People</option>
                                                                    <option value="8">501 - 1000 People</option>
                                                                    <option value="9">Above 1000 People</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label class="col-sm-2 col-form-label">Company Website Url</label>
                                                            <div class="col-sm-10">
                                                                <input type="text" name="company_url" class="form-control" placeholder="http">
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label class="col-sm-2 col-form-label">Legal Owner</label>
                                                            <div class="col-sm-10">
                                                                <input type="text" name="legal_owner" placeholder="Legal Owner" class="form-control">
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label class="col-sm-2 col-form-label">Office Size</label>
                                                            <div class="col-sm-10">
                                                                <select name="no_of_employee" class="form-control">
                                                                    <option value="">--- Please select ---</option>
                                                                    <option value="1">below 100 square meters</option>
                                                                    <option value="2">101 - 500 square meters</option>
                                                                    <option value="3">501 - 1000 square meters</option>
                                                                    <option value="4">1001 -2000 square meters</option>
                                                                    <option value="5">above 2000 square meters</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label class="col-sm-2 col-form-label">Company Advantages</label>
                                                            <div class="col-sm-10">
                                                                <textarea type="text" name="comp_advantages" id="comp_advantages" class="form-control" placeholder="Product Price"></textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane" id="manufacturing" role="tabpanel">
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
                                                        <div class="form-group row">
                                                            <label class="col-sm-2 col-form-label">Whether to show production process</label>
                                                            <div class="col-sm-10">
                                                                <select name="show_production_process" class="form-control" id="manufacturing_select">
                                                                    <option value="NO">NO</option>
                                                                    <option value="YES" id="production_yes">YES</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="row" id="production_process">
                                                            <div class="col-md-2"></div>
                                                            <div class="col-md-7 col-sm-7 col-xs-12 bd1px" >
                                                                <div class="form-group row">
                                                                    <label class="col-sm-3 col-form-label ">Process Nane</label>
                                                                    <div class="col-sm-6">
                                                                        <input type="text" name="process_name" class="form-control" placeholder="">
                                                                    </div>
                                                                </div>
                                                                <div class="form-group row">
                                                                    <label class="col-sm-3 col-form-label">Process pictures</label>
                                                                    <div class="col-sm-6">
                                                                        <input type="file" name="process_picture" class="form-control">
                                                                    </div>
                                                                </div>
                                                                <div class="form-group row">
                                                                    <label class="col-sm-3 col-form-label">Process describe</label>
                                                                    <div class="col-sm-6">
                                                                        <textarea name="process_describe" rows="5" cols="5" class="form-control" placeholder="Default textarea"></textarea>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-1">
                                                                <button type="button" class="btn btn-primary clone-btn-left clone" id="add_plus">
                                                                +
                                                                </button>
                                                            </div>
                                                        </div>
                                                        <div class="row" id="second_row">
                                                            <div class="col-md-2"></div>
                                                            <div class="col-md-7 col-sm-7 col-xs-12 bd1px" >
                                                                <div class="form-group row">
                                                                    <label class="col-sm-3 col-form-label ">Process Nane</label>
                                                                    <div class="col-sm-6">
                                                                        <input type="text" name="process_name" class="form-control" placeholder="">
                                                                    </div>
                                                                </div>
                                                                <div class="form-group row">
                                                                    <label class="col-sm-3 col-form-label">Process pictures</label>
                                                                    <div class="col-sm-6">
                                                                        <input type="file" name="process_pictures" class="form-control">
                                                                    </div>
                                                                </div>
                                                                <div class="form-group row">
                                                                    <label class="col-sm-3 col-form-label">Process describe</label>
                                                                    <div class="col-sm-6">
                                                                        <textarea name="process_describe" rows="5" cols="5" class="form-control" placeholder="Default textarea"></textarea>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-1">
                                                                <div class="clone-leftside-btn-2 cloneya-wrap">
                                                                    <div class="unit toclone-widget-left toclone cloneya cloneya1">
                                                                        <button type="button" class="btn btn-default clone-btn-left delete" id="minus">
                                                                        -
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label class="col-sm-2 col-form-label">Whether to show production equipment</label>
                                                            <div class="col-sm-10">
                                                                <select name="show_production_equipment" class="form-control" id="manufacturing_select_2">
                                                                    <option value="NO">NO</option>
                                                                    <option value="YES">YES</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="row" id="eq_row">
                                                            <div class="col-md-2"></div>
                                                            <div class="col-md-7 col-sm-7 col-xs-12 bd1px" >
                                                                <div class="form-group row">
                                                                    <label class="col-sm-4 col-form-label ">Equipment Name:</label>
                                                                    <div class="col-sm-6">
                                                                        <input type="text" name="equipment_name" class="form-control" placeholder="">
                                                                    </div>
                                                                </div>
                                                                <div class="form-group row">
                                                                    <label class="col-sm-4 col-form-label ">Equipment Model:</label>
                                                                    <div class="col-sm-6">
                                                                        <input type="text" name="equipment_model" class="form-control" placeholder="">
                                                                    </div>
                                                                </div>
                                                                <div class="form-group row">
                                                                    <label class="col-sm-4 col-form-label ">Equipment quantity:</label>
                                                                    <div class="col-sm-6">
                                                                        <input type="text" name="equipment_quantity" class="form-control" placeholder="">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-1">
                                                                <button type="button" class="btn btn-primary clone-btn-left clone" id="add_plus1">
                                                                +
                                                                </button>
                                                            </div>
                                                        </div>
                                                        <div class="row" id="equipment_row">
                                                            <div class="col-md-2"></div>
                                                            <div class="col-md-7 col-sm-7 col-xs-12 bd1px" >
                                                                <div class="form-group row">
                                                                    <label class="col-sm-4 col-form-label ">Equipment Name:</label>
                                                                    <div class="col-sm-6">
                                                                        <input type="text" name="equipment_name" class="form-control" placeholder="">
                                                                    </div>
                                                                </div>
                                                                <div class="form-group row">
                                                                    <label class="col-sm-4 col-form-label ">Equipment Model:</label>
                                                                    <div class="col-sm-6">
                                                                        <input type="text" name="equipment_model" class="form-control" placeholder="">
                                                                    </div>
                                                                </div>
                                                                <div class="form-group row">
                                                                    <label class="col-sm-4 col-form-label ">Equipment quantity:</label>
                                                                    <div class="col-sm-6">
                                                                        <input type="text" name="equipment_quantity" class="form-control" placeholder="">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-1">
                                                                <div class="clone-leftside-btn-2 cloneya-wrap">
                                                                    <div class="unit toclone-widget-left toclone cloneya cloneya1">
                                                                        <button type="button" class="btn btn-default clone-btn-left delete" id="delete1">
                                                                        -
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label class="col-sm-2 col-form-label">Whether to show Production Line</label>
                                                            <div class="col-sm-10">
                                                                <select name="show_production_line" class="form-control" id="manufacturing_select_3">
                                                                    <option value="NO">NO</option>
                                                                    <option value="YES">YES</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="row" id="prod_line">
                                                            <div class="col-md-2"></div>
                                                            <div class="col-md-7 col-sm-7 col-xs-12 bd1px" >
                                                                <div class="form-group row">
                                                                    <label class="col-sm-4 col-form-label ">Production Line name:</label>
                                                                    <div class="col-sm-6">
                                                                        <input type="text" name="production_line_name" class="form-control" placeholder="">
                                                                    </div>
                                                                </div>
                                                                <div class="form-group row">
                                                                    <label class="col-sm-4 col-form-label ">Supervisor Number:</label>
                                                                    <div class="col-sm-6">
                                                                        <input type="text" name="supervisor_number" class="form-control" placeholder="">
                                                                    </div>
                                                                </div>
                                                                <div class="form-group row">
                                                                    <label class="col-sm-4 col-form-label ">Number of Operators:</label>
                                                                    <div class="col-sm-6">
                                                                        <input type="text" name="number_operations" class="form-control" placeholder="">
                                                                    </div>
                                                                </div>
                                                                <div class="form-group row">
                                                                    <label class="col-sm-4 col-form-label ">QC/QA Number:</label>
                                                                    <div class="col-sm-6">
                                                                        <input type="text" name="qc_number" class="form-control" placeholder="">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-1">
                                                                <div class="clone-leftside-btn-2 cloneya-wrap">
                                                                    <div class="unit toclone-widget-left toclone cloneya">
                                                                        <button type="button" class="btn btn-primary clone-btn-left clone" id="add_plus2">
                                                                        +
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row" id="production_row">
                                                            <div class="col-md-2"></div>
                                                            <div class="col-md-7 col-sm-7 col-xs-12 bd1px" >
                                                                <div class="form-group row">
                                                                    <label class="col-sm-4 col-form-label ">Production Line name:</label>
                                                                    <div class="col-sm-6">
                                                                        <input type="text" name="production_line_name" class="form-control" placeholder="">
                                                                    </div>
                                                                </div>
                                                                <div class="form-group row">
                                                                    <label class="col-sm-4 col-form-label ">Supervisor Number:</label>
                                                                    <div class="col-sm-6">
                                                                        <input type="text" name="supervisor_number" class="form-control" placeholder="">
                                                                    </div>
                                                                </div>
                                                                <div class="form-group row">
                                                                    <label class="col-sm-4 col-form-label ">Number of Operators:</label>
                                                                    <div class="col-sm-6">
                                                                        <input type="text" name="number_operations" class="form-control" placeholder="">
                                                                    </div>
                                                                </div>
                                                                <div class="form-group row">
                                                                    <label class="col-sm-4 col-form-label ">QC/QA Number:</label>
                                                                    <div class="col-sm-6">
                                                                        <input type="text" name="qc_number" class="form-control" placeholder="">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-1">
                                                                <div class="clone-leftside-btn-2 cloneya-wrap">
                                                                    <div class="unit toclone-widget-left toclone cloneya cloneya1">
                                                                        <button type="button" class="btn btn-default clone-btn-left delete" id="delete2">
                                                                        -
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label class="col-sm-2 col-form-label">Factory Location</label>
                                                            <div class="col-sm-10">
                                                                <input type="text" name="factory_location" class="form-control" placeholder="http">
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label class="col-sm-2 col-form-label">Factory Size</label>
                                                            <div class="col-sm-10">
                                                                <select name="factory_size" class="form-control">
                                                                    <option value="1" selected="">Below 1,000 square meters</option>
                                                                    <option value="2">1,000-3,000 square meters</option>
                                                                    <option value="3">3,000-5,000 square meters</option>
                                                                    <option value="4">5,000-10,000 square meters</option>
                                                                    <option value="5">10,000-30,000 square meters</option>
                                                                    <option value="6">30,000-50,000 square meters</option>
                                                                    <option value="7">50,000-100,000 square meters</option>
                                                                    <option value="8">Above 100,000 square meters</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label class="col-sm-2 col-form-label">Contract Manufacturing</label>
                                                            <div class="col-sm-10">
                                                                <div class="border-checkbox-section">
                                                                    <div class="border-checkbox-group border-checkbox-group-primary">
                                                                        <input class="border-checkbox" type="checkbox" id="checkbox1">
                                                                        <label class="border-checkbox-label" for="checkbox1">OEM Service Offered</label>
                                                                    </div>
                                                                    <div class="border-checkbox-group border-checkbox-group-success">
                                                                        <input class="border-checkbox" type="checkbox" id="checkbox2">
                                                                        <label class="border-checkbox-label" for="checkbox2">Design Service Offered</label>
                                                                    </div>
                                                                    <div class="border-checkbox-group border-checkbox-group-success">
                                                                        <input class="border-checkbox" type="checkbox" id="checkbox3">
                                                                        <label class="border-checkbox-label" for="checkbox3">Buyer Label Offered</label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label class="col-sm-2 col-form-label">OEM Experience</label>
                                                            <div class="col-sm-10">
                                                                <input type="text" name="oem_experience" class="form-control" placeholder="OEM Experience (Years)">
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label class="col-sm-2 col-form-label">No. of QC Staff</label>
                                                            <div class="col-sm-10">
                                                                <select name="no_of_qc_staff" class="form-control">
                                                                    <option value="1">Less than 5 People</option>
                                                                    <option value="2" selected="">5 - 10 People</option>
                                                                    <option value="3">11 - 20 People</option>
                                                                    <option value="4">21 - 30 People</option>
                                                                    <option value="5">31 - 40 People</option>
                                                                    <option value="6">41 - 50 People</option>
                                                                    <option value="7">Above 50 People</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label class="col-sm-2 col-form-label">No. of R & D Staff</label>
                                                            <div class="col-sm-10">
                                                                <select name="no_of_RD_staff" class="form-control">
                                                                    <option value="1">Less than 5 People</option>
                                                                    <option value="2" selected="">5 - 10 People</option>
                                                                    <option value="3">11 - 20 People</option>
                                                                    <option value="4">21 - 30 People</option>
                                                                    <option value="5">31 - 40 People</option>
                                                                    <option value="6">41 - 50 People</option>
                                                                    <option value="7">Above 50 People</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label class="col-sm-2 col-form-label">No. of Production Lines</label>
                                                            <div class="col-sm-10">
                                                                <select name="no_of_production_line" class="form-control">
                                                                    <?php 
                                                                        $y=0;
                                                                        while($y <=10)
                                                                        {
                                                                        echo' <option value="'.$y.'">'.$y.'</option>';
                                                                        $y++;
                                                                        }
                                                                        ?>
                                                                    <option value="Above 10">Above 10</option>
                                                                    ';
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label class="col-sm-2 col-form-label">Annual Output Value</label>
                                                            <div class="col-sm-10">
                                                                <select name="annual_output_value" class="form-control">
                                                                    <option value="">--- Please select ---</option>
                                                                    <option value="1" selected="">Below US$1 Million</option>
                                                                    <option value="2">US$1 Million - US$2.5 Million</option>
                                                                    <option value="3">US$2.5 Million - US$5 Million</option>
                                                                    <option value="4">US$5 Million - US$10 Million</option>
                                                                    <option value="5">US$10 Million - US$50 Million</option>
                                                                    <option value="6">US$50 Million - US$100 Million</option>
                                                                    <option value="7">Above US$100 Million</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label class="col-sm-2 col-form-label">Add information about your annual production capacity?</label>
                                                            <div class="col-sm-10">
                                                                <select name="add_information" class="form-control" id="manufacturing_select_4">
                                                                    <option value="NO">NO</option>
                                                                    <option value="YES">YES</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="row" id="list">
                                                            <div class="col-md-2"></div>
                                                            <div class="col-md-7 col-sm-7 col-xs-12 bd1px" >
                                                                <div class="form-group row">
                                                                    <label class="col-sm-3 col-form-label ">Product name:</label>
                                                                    <div class="col-sm-8">
                                                                        <input type="text" name="product_name" class="form-control" placeholder="">
                                                                    </div>
                                                                </div>
                                                                <div class="form-group row">
                                                                    <label class="col-sm-3 col-form-label ">Units Produced (previous year):</label>
                                                                    <div class="col-sm-4">
                                                                        <input type="text" name="unit_produced" class="form-control" placeholder="">
                                                                    </div>
                                                                    <div class="col-sm-4">
                                                                        <select name="select_unit_type" class="form-control">
                                                                            <option value="">--- Please select ---</option>
                                                                            <option value="1" selected="">Select Unit Type</option>
                                                                            <option value="2">US$1 Million - US$2.5 Million</option>
                                                                            <option value="3">US$2.5 Million - US$5 Million</option>
                                                                            <option value="4">US$5 Million - US$10 Million</option>
                                                                            <option value="5">US$10 Million - US$50 Million</option>
                                                                            <option value="6">US$50 Million - US$100 Million</option>
                                                                            <option value="7">Above US$100 Million</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group row">
                                                                    <label class="col-sm-3 col-form-label ">Highest Ever Anuual Output:</label>
                                                                    <div class="col-sm-4">
                                                                        <input type="text" name="highest_ever" class="form-control" placeholder="">
                                                                    </div>
                                                                    <div class="col-sm-4">
                                                                        <select name="select_unit_type" class="form-control">
                                                                            <option value="">--- Please select ---</option>
                                                                            <option value="1" selected="">Select Unit Type</option>
                                                                            <option value="2">US$1 Million - US$2.5 Million</option>
                                                                            <option value="3">US$2.5 Million - US$5 Million</option>
                                                                            <option value="4">US$5 Million - US$10 Million</option>
                                                                            <option value="5">US$10 Million - US$50 Million</option>
                                                                            <option value="6">US$50 Million - US$100 Million</option>
                                                                            <option value="7">Above US$100 Million</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-1">
                                                                <div class="clone-leftside-btn-2 cloneya-wrap">
                                                                    <div class="unit toclone-widget-left toclone cloneya">
                                                                        <button type="button" class="btn btn-primary clone-btn-left clone" id="add_capacity">
                                                                        +
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row" id="product_row">
                                                            <div class="col-md-2"></div>
                                                            <div class="col-md-7 col-sm-7 col-xs-12 bd1px" >
                                                                <div class="form-group row">
                                                                    <label class="col-sm-3 col-form-label ">Product name:</label>
                                                                    <div class="col-sm-8">
                                                                        <input type="text" name="product_name" class="form-control" placeholder="">
                                                                    </div>
                                                                </div>
                                                                <div class="form-group row">
                                                                    <label class="col-sm-3 col-form-label ">Units Produced (previous year):</label>
                                                                    <div class="col-sm-4">
                                                                        <input type="text" name="unit_produced" class="form-control" placeholder="">
                                                                    </div>
                                                                    <div class="col-sm-4">
                                                                        <select name="select_unit_type" class="form-control">
                                                                            <option value="">--- Please select ---</option>
                                                                            <option value="1" selected="">Select Unit Type</option>
                                                                            <option value="2">US$1 Million - US$2.5 Million</option>
                                                                            <option value="3">US$2.5 Million - US$5 Million</option>
                                                                            <option value="4">US$5 Million - US$10 Million</option>
                                                                            <option value="5">US$10 Million - US$50 Million</option>
                                                                            <option value="6">US$50 Million - US$100 Million</option>
                                                                            <option value="7">Above US$100 Million</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group row">
                                                                    <label class="col-sm-3 col-form-label ">Highest Ever Anuual Output:</label>
                                                                    <div class="col-sm-4">
                                                                        <input type="text" name="highest_ever" class="form-control" placeholder="">
                                                                    </div>
                                                                    <div class="col-sm-4">
                                                                        <select name="select_unit_type" class="form-control">
                                                                            <option value="">--- Please select ---</option>
                                                                            <option value="1" selected="">Select Unit Type</option>
                                                                            <option value="2">US$1 Million - US$2.5 Million</option>
                                                                            <option value="3">US$2.5 Million - US$5 Million</option>
                                                                            <option value="4">US$5 Million - US$10 Million</option>
                                                                            <option value="5">US$10 Million - US$50 Million</option>
                                                                            <option value="6">US$50 Million - US$100 Million</option>
                                                                            <option value="7">Above US$100 Million</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-1">
                                                                <div class="clone-leftside-btn-2 cloneya-wrap">
                                                                    <div class="unit toclone-widget-left toclone cloneya cloneya1">
                                                                        <button type="button" class="btn btn-default clone-btn-left delete" id="delete3">
                                                                        -
                                                                        </button>
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
                                <div class="tab-pane" id="quality_control" role="tabpanel">
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
                                                        <div class="form-group row">
                                                            <label class="col-sm-2 col-form-label">Whether to demonstrate the quality control process</label>
                                                            <div class="col-sm-10">
                                                                <select name="demostrate_quality_control" class="form-control" id="quality_control_select">
                                                                    <option value="NO">NO</option>
                                                                    <option value="YES">YES</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="row" id="quality_demonstrate">
                                                            <div class="col-md-2"></div>
                                                            <div class="col-md-7 col-sm-7 col-xs-12 bd1px" >
                                                                <div class="form-group row">
                                                                    <label class="col-sm-3 col-form-label ">Process Nane</label>
                                                                    <div class="col-sm-6">
                                                                        <input type="text" name="process_name" class="form-control" placeholder="">
                                                                    </div>
                                                                </div>
                                                                <div class="form-group row">
                                                                    <label class="col-sm-3 col-form-label">Process pictures</label>
                                                                    <div class="col-sm-6">
                                                                        <input type="file" name="process_picture" class="form-control">
                                                                    </div>
                                                                </div>
                                                                <div class="form-group row">
                                                                    <label class="col-sm-3 col-form-label">Process describe</label>
                                                                    <div class="col-sm-6">
                                                                        <textarea name="process_describe" rows="5" cols="5" class="form-control" placeholder="Default textarea"></textarea>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-1">
                                                                <button type="button" class="btn btn-primary clone-btn-left clone" id="add_demonstrate">
                                                                +
                                                                </button>
                                                            </div>
                                                        </div>
                                                        <div class="row" id="quality_row1">
                                                            <div class="col-md-2"></div>
                                                            <div class="col-md-7 col-sm-7 col-xs-12 bd1px" >
                                                                <div class="form-group row">
                                                                    <label class="col-sm-3 col-form-label ">Process Nane</label>
                                                                    <div class="col-sm-6">
                                                                        <input type="text" name="process_name" class="form-control" placeholder="">
                                                                    </div>
                                                                </div>
                                                                <div class="form-group row">
                                                                    <label class="col-sm-3 col-form-label">Process pictures</label>
                                                                    <div class="col-sm-6">
                                                                        <input type="file" name="process_pictures" class="form-control">
                                                                    </div>
                                                                </div>
                                                                <div class="form-group row">
                                                                    <label class="col-sm-3 col-form-label">Process describe</label>
                                                                    <div class="col-sm-6">
                                                                        <textarea name="process_describe" rows="5" cols="5" class="form-control" placeholder="Default textarea"></textarea>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-1">
                                                                <div class="clone-leftside-btn-2 cloneya-wrap">
                                                                    <div class="unit toclone-widget-left toclone cloneya cloneya1">
                                                                        <button type="button" class="btn btn-default clone-btn-left delete" id="delete_1">
                                                                        -
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label class="col-sm-2 col-form-label">Whether to display testing equipment</label>
                                                            <div class="col-sm-10">
                                                                <select name="display_testing_equipment" class="form-control" id="quality_equipment">
                                                                    <option value="NO">NO</option>
                                                                    <option value="YES">YES</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="row" id="quality_first">
                                                            <div class="col-md-2"></div>
                                                            <div class="col-md-7 col-sm-7 col-xs-12 bd1px" >
                                                                <div class="form-group row">
                                                                    <label class="col-sm-4 col-form-label ">Equipment Name:</label>
                                                                    <div class="col-sm-6">
                                                                        <input type="text" name="equipment_name" class="form-control" placeholder="">
                                                                    </div>
                                                                </div>
                                                                <div class="form-group row">
                                                                    <label class="col-sm-4 col-form-label ">Equipment Model:</label>
                                                                    <div class="col-sm-6">
                                                                        <input type="text" name="equipment_model" class="form-control" placeholder="">
                                                                    </div>
                                                                </div>
                                                                <div class="form-group row">
                                                                    <label class="col-sm-4 col-form-label ">Equipment quantity:</label>
                                                                    <div class="col-sm-6">
                                                                        <input type="text" name="equipment_quantity" class="form-control" placeholder="">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-1">
                                                                <button type="button" class="btn btn-primary clone-btn-left clone" id="add_plus1">
                                                                +
                                                                </button>
                                                            </div>
                                                        </div>
                                                        
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane" id="miscellaneous" role="tabpanel">
                                    <div class="row" id="">
                                        <div class="col-md-7 col-sm-7 col-xs-12" >
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label">Total Annual Revenue:</label>
                                                <div class="col-sm-8">
                                                    <select id="trade-sales" class="form-control" name="total_revenue">
                                                        <option value="">--please select--</option>
                                                        <option value="1" selected="">Below US$1 Million</option>
                                                        <option value="2">US$1 Million - US$2.5 Million</option>
                                                        <option value="3">US$2.5 Million - US$5 Million</option>
                                                        <option value="4">US$5 Million - US$10 Million</option>
                                                        <option value="5">US$10 Million - US$50 Million</option>
                                                        <option value="6">US$50 Million - US$100 Million</option>
                                                        <option value="7">Above US$100 Million</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label">Export Percentage:</label>
                                                <div class="col-sm-8">
                                                    <select id="trade-export-rate" class="form-control" name="export_percentage">
                                                        <option value="">--please select--</option>
                                                        <option value="1" selected="">1% - 10%</option>
                                                        <option value="2">11% - 20%</option>
                                                        <option value="3">21% - 30%</option>
                                                        <option value="4">31% - 40%</option>
                                                        <option value="5">41% - 50%</option>
                                                        <option value="6">51% - 60%</option>
                                                        <option value="7">61% - 70%</option>
                                                        <option value="8">71% - 80%</option>
                                                        <option value="9">81% - 90%</option>
                                                        <option value="10">91% - 100%</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label">Main Markets and Distribution:</label>
                                                <div class="col-sm-8">
                                                    <div class="progress progress1">
                                                        <div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <label class="col-sm-2"></label>
                                        <div class="col-sm-10">
                                            <div class="row">
                                                <div class="col-md-4 col-sm-4 row">
                                                    <input type="text" name="" class="form-control" placeholder="0" style="width:50px; margin-bottom:5px;">
                                                    <span style="padding:0px 5px;">%</span>
                                                    <span>North America</span>
                                                </div>
                                                <div class="col-md-4 col-sm-4 row">
                                                    <input type="text" name="" class="form-control" placeholder="0" style="width:50px;margin-bottom:5px;">
                                                    <span style="padding:0px 5px;">%</span>
                                                    <span>North America</span>
                                                </div>
                                                <div class="col-md-4 col-sm-4 row">
                                                    <input type="text" name="" class="form-control" placeholder="0" style="width:50px;">
                                                    <span style="padding:0px 5px;">%</span>
                                                    <span>North America</span>
                                                </div>
                                                <div class="col-md-4 col-sm-4 row">
                                                    <input type="text" name="" class="form-control" placeholder="0" style="width:50px;margin-bottom:5px;">
                                                    <span style="padding:0px 5px;">%</span>
                                                    <span>North America</span>
                                                </div>
                                                <div class="col-md-4 col-sm-4 row">
                                                    <input type="text" name="" class="form-control" placeholder="0" style="width:50px;margin-bottom:5px;">
                                                    <span style="padding:0px 5px;">%</span>
                                                    <span>North America</span>
                                                </div>
                                                <div class="col-md-4 col-sm-4 row">
                                                    <input type="text" name="" class="form-control" placeholder="0" style="width:50px;margin-bottom:5px;">
                                                    <span style="padding:0px 5px;">%</span>
                                                    <span>North America</span>
                                                </div>
                                                <div class="col-md-4 col-sm-4 row">
                                                    <input type="text" name="" class="form-control" placeholder="0" style="width:50px;margin-bottom:5px;">
                                                    <span style="padding:0px 5px;">%</span>
                                                    <span>North America</span>
                                                </div>
                                                <div class="col-md-4 col-sm-4 row">
                                                    <input type="text" name="" class="form-control" placeholder="0" style="width:50px;margin-bottom:5px;">
                                                    <span style="padding:0px 5px;">%</span>
                                                    <span>North America</span>
                                                </div>
                                                <div class="col-md-4 col-sm-4 row">
                                                    <input type="text" name="" class="form-control" placeholder="0" style="width:50px;margin-bottom:5px;">
                                                    <span style="padding:0px 5px;">%</span>
                                                    <span>North America</span>
                                                </div>
                                                <div class="col-md-4 col-sm-4 row">
                                                    <input type="text" name="" class="form-control" placeholder="0" style="width:50px;margin-bottom:5px;">
                                                    <span style="padding:0px 5px;">%</span>
                                                    <span>North America</span>
                                                </div>
                                                <div class="col-md-4 col-sm-4 row">
                                                    <input type="text" name="" class="form-control" placeholder="0" style="width:50px;margin-bottom:5px;">
                                                    <span style="padding:0px 5px;">%</span>
                                                    <span>North America</span>
                                                </div>
                                                <div class="col-md-4 col-sm-4 row">
                                                    <input type="text" name="" class="form-control" placeholder="0" style="width:50px;margin-bottom:5px;">
                                                    <span style="padding:0px 5px;">%</span>
                                                    <span>North America</span>
                                                </div>
                                                <div class="col-md-4 col-sm-4 row">
                                                    <input type="text" name="" class="form-control" placeholder="0" style="width:50px;margin-bottom:5px;">
                                                    <span style="padding:0px 5px;">%</span>
                                                    <span>North America</span>
                                                </div>
                                                <div class="col-md-4 col-sm-4 row">
                                                    <input type="text" name="" class="form-control" placeholder="0" style="width:50px;margin-bottom:5px;">
                                                    <span style="padding:0px 5px;">%</span>
                                                    <span>North America</span>
                                                </div>
                                                <div class="col-md-4 col-sm-4 row">
                                                    <input type="text" name="" class="form-control" placeholder="0" style="width:50px;margin-bottom:5px;">
                                                    <span style="padding:0px 5px;">%</span>
                                                    <span>North America</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label">Year when your company started exporting:</label>
                                        <div class="col-sm-4">
                                            <select id="trade-export-rate" class="form-control" name="company_year">
                                                <option value="">--- Please select ---</option>
                                                <option value="2019">2019</option>
                                                <option value="2018">2018</option>
                                                <option value="2017">2017</option>
                                                <option value="2016">2016</option>
                                                <option value="2015">2015</option>
                                                <option value="2014">2014</option>
                                                <option value="2013">2013</option>
                                                <option value="2012">2012</option>
                                                <option value="2011">2011</option>
                                                <option value="2010" selected="">2010</option>
                                                <option value="2009">2009</option>
                                                <option value="2008">2008</option>
                                                <option value="2007">2007</option>
                                                <option value="2006">2006</option>
                                                <option value="2005">2005</option>
                                                <option value="2004">2004</option>
                                                <option value="2003">2003</option>
                                                <option value="2002">2002</option>
                                                <option value="2001">2001</option>
                                                <option value="2000">2000</option>
                                                <option value="1999">1999</option>
                                                <option value="1998">1998</option>
                                                <option value="1997">1997</option>
                                                <option value="1996">1996</option>
                                                <option value="1995">1995</option>
                                                <option value="1994">1994</option>
                                                <option value="1993">1993</option>
                                                <option value="1992">1992</option>
                                                <option value="1991">1991</option>
                                                <option value="1990">1990</option>
                                                <option value="1989">1989</option>
                                                <option value="1988">1988</option>
                                                <option value="1987">1987</option>
                                                <option value="1986">1986</option>
                                                <option value="1985">1985</option>
                                                <option value="1984">1984</option>
                                                <option value="1983">1983</option>
                                                <option value="1982">1982</option>
                                                <option value="1981">1981</option>
                                                <option value="1980">1980</option>
                                                <option value="1979">1979</option>
                                                <option value="1978">1978</option>
                                                <option value="1977">1977</option>
                                                <option value="1976">1976</option>
                                                <option value="1975">1975</option>
                                                <option value="1974">1974</option>
                                                <option value="1973">1973</option>
                                                <option value="1972">1972</option>
                                                <option value="1971">1971</option>
                                                <option value="1970">1970</option>
                                                <option value="1969">1969</option>
                                                <option value="1968">1968</option>
                                                <option value="1967">1967</option>
                                                <option value="1966">1966</option>
                                                <option value="1965">1965</option>
                                                <option value="1964">1964</option>
                                                <option value="1963">1963</option>
                                                <option value="1962">1962</option>
                                                <option value="1961">1961</option>
                                                <option value="1960">1960</option>
                                                <option value="1959">1959</option>
                                                <option value="1958">1958</option>
                                                <option value="1957">1957</option>
                                                <option value="1956">1956</option>
                                                <option value="1955">1955</option>
                                                <option value="1954">1954</option>
                                                <option value="1953">1953</option>
                                                <option value="1952">1952</option>
                                                <option value="1951">1951</option>
                                                <option value="1950">1950</option>
                                                <option value="1949">1949</option>
                                                <option value="1948">1948</option>
                                                <option value="1947">1947</option>
                                                <option value="1946">1946</option>
                                                <option value="1945">1945</option>
                                                <option value="1944">1944</option>
                                                <option value="1943">1943</option>
                                                <option value="1942">1942</option>
                                                <option value="1941">1941</option>
                                                <option value="1940">1940</option>
                                                <option value="1939">1939</option>
                                                <option value="1938">1938</option>
                                                <option value="1937">1937</option>
                                                <option value="1936">1936</option>
                                                <option value="1935">1935</option>
                                                <option value="1934">1934</option>
                                                <option value="1933">1933</option>
                                                <option value="1932">1932</option>
                                                <option value="1931">1931</option>
                                                <option value="1930">1930</option>
                                                <option value="1929">1929</option>
                                                <option value="1928">1928</option>
                                                <option value="1927">1927</option>
                                                <option value="1926">1926</option>
                                                <option value="1925">1925</option>
                                                <option value="1924">1924</option>
                                                <option value="1923">1923</option>
                                                <option value="1922">1922</option>
                                                <option value="1921">1921</option>
                                                <option value="1920">1920</option>
                                                <option value="1919">1919</option>
                                                <option value="1918">1918</option>
                                                <option value="1917">1917</option>
                                                <option value="1916">1916</option>
                                                <option value="1915">1915</option>
                                                <option value="1914">1914</option>
                                                <option value="1913">1913</option>
                                                <option value="1912">1912</option>
                                                <option value="1911">1911</option>
                                                <option value="1910">1910</option>
                                                <option value="1909">1909</option>
                                                <option value="1908">1908</option>
                                                <option value="1907">1907</option>
                                                <option value="1906">1906</option>
                                                <option value="1905">1905</option>
                                                <option value="1904">1904</option>
                                                <option value="1903">1903</option>
                                                <option value="1902">1902</option>
                                                <option value="1901">1901</option>
                                                <option value="1900">1900</option>
                                                <option value="1899">1899</option>
                                                <option value="1898">1898</option>
                                                <option value="1897">1897</option>
                                                <option value="1896">1896</option>
                                                <option value="1895">1895</option>
                                                <option value="1894">1894</option>
                                                <option value="1893">1893</option>
                                                <option value="1892">1892</option>
                                                <option value="1891">1891</option>
                                                <option value="1890">1890</option>
                                                <option value="1889">1889</option>
                                                <option value="1888">1888</option>
                                                <option value="1887">1887</option>
                                                <option value="1886">1886</option>
                                                <option value="1885">1885</option>
                                                <option value="1884">1884</option>
                                                <option value="1883">1883</option>
                                                <option value="1882">1882</option>
                                                <option value="1881">1881</option>
                                                <option value="1880">1880</option>
                                                <option value="1879">1879</option>
                                                <option value="1878">1878</option>
                                                <option value="1877">1877</option>
                                                <option value="1876">1876</option>
                                                <option value="1875">1875</option>
                                                <option value="1874">1874</option>
                                                <option value="1873">1873</option>
                                                <option value="1872">1872</option>
                                                <option value="1871">1871</option>
                                                <option value="1870">1870</option>
                                                <option value="1869">1869</option>
                                                <option value="1868">1868</option>
                                                <option value="1867">1867</option>
                                                <option value="1866">1866</option>
                                                <option value="1865">1865</option>
                                                <option value="1864">1864</option>
                                                <option value="1863">1863</option>
                                                <option value="1862">1862</option>
                                                <option value="1861">1861</option>
                                                <option value="1860">1860</option>
                                                <option value="1859">1859</option>
                                                <option value="1858">1858</option>
                                                <option value="1857">1857</option>
                                                <option value="1856">1856</option>
                                                <option value="1855">1855</option>
                                                <option value="1854">1854</option>
                                                <option value="1853">1853</option>
                                                <option value="1852">1852</option>
                                                <option value="1851">1851</option>
                                                <option value="1850">1850</option>
                                                <option value="1849">1849</option>
                                                <option value="1848">1848</option>
                                                <option value="1847">1847</option>
                                                <option value="1846">1846</option>
                                                <option value="1845">1845</option>
                                                <option value="1844">1844</option>
                                                <option value="1843">1843</option>
                                                <option value="1842">1842</option>
                                                <option value="1841">1841</option>
                                                <option value="1840">1840</option>
                                                <option value="1839">1839</option>
                                                <option value="1838">1838</option>
                                                <option value="1837">1837</option>
                                                <option value="1836">1836</option>
                                                <option value="1835">1835</option>
                                                <option value="1834">1834</option>
                                                <option value="1833">1833</option>
                                                <option value="1832">1832</option>
                                                <option value="1831">1831</option>
                                                <option value="1830">1830</option>
                                                <option value="1829">1829</option>
                                                <option value="1828">1828</option>
                                                <option value="1827">1827</option>
                                                <option value="1826">1826</option>
                                                <option value="1825">1825</option>
                                                <option value="1824">1824</option>
                                                <option value="1823">1823</option>
                                                <option value="1822">1822</option>
                                                <option value="1821">1821</option>
                                                <option value="1820">1820</option>
                                                <option value="1819">1819</option>
                                                <option value="1818">1818</option>
                                                <option value="1817">1817</option>
                                                <option value="1816">1816</option>
                                                <option value="1815">1815</option>
                                                <option value="1814">1814</option>
                                                <option value="1813">1813</option>
                                                <option value="1812">1812</option>
                                                <option value="1811">1811</option>
                                                <option value="1810">1810</option>
                                                <option value="1809">1809</option>
                                                <option value="1808">1808</option>
                                                <option value="1807">1807</option>
                                                <option value="1806">1806</option>
                                                <option value="1805">1805</option>
                                                <option value="1804">1804</option>
                                                <option value="1803">1803</option>
                                                <option value="1802">1802</option>
                                                <option value="1801">1801</option>
                                                <option value="1800">1800</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label">Whether add customer case:</label>
                                        <div class="col-sm-10">
                                            <select name="add_customer_case" class="form-control" id="customer_case">
                                                <option value="NO">NO</option>
                                                <option value="YES">YES</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row" id="customer_case_wrapper">
                                        <div class="col-md-2"></div>
                                        <div class="col-md-7 col-sm-7 col-xs-12 bd1px" >
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label ">Project/customer name:</label>
                                                <div class="col-sm-8">
                                                    <input type="text" name="customer_name" class="form-control" placeholder="">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label ">Host Country/Region:</label>
                                                <div class="col-sm-8">
                                                    <select name="country_region" class="form-control">
                                                        <option value="">--please select--</option>
                                                        <option value="AF">Afghanistan</option>
                                                        <option value="ALA">Aland Islands</option>
                                                        <option value="AL">Albania</option>
                                                        <option value="GBA">Alderney</option>
                                                        <option value="DZ">Algeria</option>
                                                        <option value="AS">American Samoa</option>
                                                        <option value="AD">Andorra</option>
                                                        <option value="AO">Angola</option>
                                                        <option value="AI">Anguilla</option>
                                                        <option value="AQ">Antarctica</option>
                                                        <option value="AG">Antigua and Barbuda</option>
                                                        <option value="AR">Argentina</option>
                                                        <option value="AM">Armenia</option>
                                                        <option value="AW">Aruba</option>
                                                        <option value="ASC">Ascension Island</option>
                                                        <option value="AU">Australia</option>
                                                        <option value="AT">Austria</option>
                                                        <option value="AZ">Azerbaijan</option>
                                                        <option value="BS">Bahamas</option>
                                                        <option value="BH">Bahrain</option>
                                                        <option value="BD">Bangladesh</option>
                                                        <option value="BB">Barbados</option>
                                                        <option value="BY">Belarus</option>
                                                        <option value="BE">Belgium</option>
                                                        <option value="BZ">Belize</option>
                                                        <option value="BJ">Benin</option>
                                                        <option value="BM">Bermuda</option>
                                                        <option value="BT">Bhutan</option>
                                                        <option value="BO">Bolivia</option>
                                                        <option value="BA">Bosnia and Herzegovina</option>
                                                        <option value="BW">Botswana</option>
                                                        <option value="BV">Bouvet Island</option>
                                                        <option value="BR">Brazil</option>
                                                        <option value="IO">British Indian Ocean Territory</option>
                                                        <option value="BN">Brunei Darussalam</option>
                                                        <option value="BG">Bulgaria</option>
                                                        <option value="BF">Burkina Faso</option>
                                                        <option value="BI">Burundi</option>
                                                        <option value="KH">Cambodia</option>
                                                        <option value="CM">Cameroon</option>
                                                        <option value="CA">Canada</option>
                                                        <option value="CV">Cape Verde</option>
                                                        <option value="KY">Cayman Islands</option>
                                                        <option value="CF">Central African Republic</option>
                                                        <option value="TD">Chad</option>
                                                        <option value="CL">Chile</option>
                                                        <option value="CN">China (Mainland)</option>
                                                        <option value="CX">Christmas Island</option>
                                                        <option value="CC">Cocos (Keeling) Islands</option>
                                                        <option value="CO">Colombia</option>
                                                        <option value="KM">Comoros</option>
                                                        <option value="ZR">Congo, The Democratic Republic Of The</option>
                                                        <option value="CG">Congo, The Republic of Congo</option>
                                                        <option value="CK">Cook Islands</option>
                                                        <option value="CR">Costa Rica</option>
                                                        <option value="CI">Cote D'Ivoire</option>
                                                        <option value="HR">Croatia (local name: Hrvatska)</option>
                                                        <option value="CU">Cuba</option>
                                                        <option value="CY">Cyprus</option>
                                                        <option value="CZ">Czech Republic</option>
                                                        <option value="DK">Denmark</option>
                                                        <option value="DJ">Djibouti</option>
                                                        <option value="DM">Dominica</option>
                                                        <option value="DO">Dominican Republic</option>
                                                        <option value="TP">East Timor</option>
                                                        <option value="EC">Ecuador</option>
                                                        <option value="EG">Egypt</option>
                                                        <option value="SV">El Salvador</option>
                                                        <option value="GQ">Equatorial Guinea</option>
                                                        <option value="ER">Eritrea</option>
                                                        <option value="EE">Estonia</option>
                                                        <option value="ET">Ethiopia</option>
                                                        <option value="FK">Falkland Islands (Malvinas)</option>
                                                        <option value="FO">Faroe Islands</option>
                                                        <option value="FJ">Fiji</option>
                                                        <option value="FI">Finland</option>
                                                        <option value="FR">France</option>
                                                        <option value="FX">France Metropolitan</option>
                                                        <option value="GF">French Guiana</option>
                                                        <option value="PF">French Polynesia</option>
                                                        <option value="TF">French Southern Territories</option>
                                                        <option value="GA">Gabon</option>
                                                        <option value="GM">Gambia</option>
                                                        <option value="GE">Georgia</option>
                                                        <option value="DE">Germany</option>
                                                        <option value="GH">Ghana</option>
                                                        <option value="GI">Gibraltar</option>
                                                        <option value="GR">Greece</option>
                                                        <option value="GL">Greenland</option>
                                                        <option value="GD">Grenada</option>
                                                        <option value="GP">Guadeloupe</option>
                                                        <option value="GU">Guam</option>
                                                        <option value="GT">Guatemala</option>
                                                        <option value="GGY">Guernsey</option>
                                                        <option value="GN">Guinea</option>
                                                        <option value="GW">Guinea-Bissau</option>
                                                        <option value="GY">Guyana</option>
                                                        <option value="HT">Haiti</option>
                                                        <option value="HM">Heard and Mc Donald Islands</option>
                                                        <option value="HN">Honduras</option>
                                                        <option value="HK">Hong Kong</option>
                                                        <option value="HU">Hungary</option>
                                                        <option value="IS">Iceland</option>
                                                        <option value="IN">India</option>
                                                        <option value="ID">Indonesia</option>
                                                        <option value="IR">Iran (Islamic Republic of)</option>
                                                        <option value="IQ">Iraq</option>
                                                        <option value="IE">Ireland</option>
                                                        <option value="IM">Isle of Man</option>
                                                        <option value="IL">Israel</option>
                                                        <option value="IT">Italy</option>
                                                        <option value="JM">Jamaica</option>
                                                        <option value="JP">Japan</option>
                                                        <option value="JEY">Jersey</option>
                                                        <option value="JO">Jordan</option>
                                                        <option value="KZ">Kazakhstan</option>
                                                        <option value="KE">Kenya</option>
                                                        <option value="KI">Kiribati</option>
                                                        <option value="KS">Kosovo</option>
                                                        <option value="KW">Kuwait</option>
                                                        <option value="KG">Kyrgyzstan</option>
                                                        <option value="LA">Lao People's Democratic Republic</option>
                                                        <option value="LV">Latvia</option>
                                                        <option value="LB">Lebanon</option>
                                                        <option value="LS">Lesotho</option>
                                                        <option value="LR">Liberia</option>
                                                        <option value="LY">Libya</option>
                                                        <option value="LI">Liechtenstein</option>
                                                        <option value="LT">Lithuania</option>
                                                        <option value="LU">Luxembourg</option>
                                                        <option value="MO">Macau</option>
                                                        <option value="MK">Macedonia</option>
                                                        <option value="MG">Madagascar</option>
                                                        <option value="MW">Malawi</option>
                                                        <option value="MY">Malaysia</option>
                                                        <option value="MV">Maldives</option>
                                                        <option value="ML">Mali</option>
                                                        <option value="MT">Malta</option>
                                                        <option value="MH">Marshall Islands</option>
                                                        <option value="MQ">Martinique</option>
                                                        <option value="MR">Mauritania</option>
                                                        <option value="MU">Mauritius</option>
                                                        <option value="YT">Mayotte</option>
                                                        <option value="MX">Mexico</option>
                                                        <option value="FM">Micronesia</option>
                                                        <option value="MD">Moldova</option>
                                                        <option value="MC">Monaco</option>
                                                        <option value="MN">Mongolia</option>
                                                        <option value="MNE">Montenegro</option>
                                                        <option value="MS">Montserrat</option>
                                                        <option value="MA">Morocco</option>
                                                        <option value="MZ">Mozambique</option>
                                                        <option value="MM">Myanmar</option>
                                                        <option value="NA">Namibia</option>
                                                        <option value="NR">Nauru</option>
                                                        <option value="NP">Nepal</option>
                                                        <option value="NL">Netherlands</option>
                                                        <option value="AN">Netherlands Antilles</option>
                                                        <option value="NC">New Caledonia</option>
                                                        <option value="NZ">New Zealand</option>
                                                        <option value="NI">Nicaragua</option>
                                                        <option value="NE">Niger</option>
                                                        <option value="NG">Nigeria</option>
                                                        <option value="NU">Niue</option>
                                                        <option value="NF">Norfolk Island</option>
                                                        <option value="KP">North Korea</option>
                                                        <option value="MP">Northern Mariana Islands</option>
                                                        <option value="NO">Norway</option>
                                                        <option value="OM">Oman</option>
                                                        <option value="Other">Other Country</option>
                                                        <option value="PK">Pakistan</option>
                                                        <option value="PW">Palau</option>
                                                        <option value="PS">Palestine</option>
                                                        <option value="PA">Panama</option>
                                                        <option value="PG">Papua New Guinea</option>
                                                        <option value="PY">Paraguay</option>
                                                        <option value="PE">Peru</option>
                                                        <option value="PH">Philippines</option>
                                                        <option value="PN">Pitcairn</option>
                                                        <option value="PL">Poland</option>
                                                        <option value="PT">Portugal</option>
                                                        <option value="PR">Puerto Rico</option>
                                                        <option value="QA">Qatar</option>
                                                        <option value="RE">Reunion</option>
                                                        <option value="RO">Romania</option>
                                                        <option value="RU">Russian Federation</option>
                                                        <option value="RW">Rwanda</option>
                                                        <option value="BLM">Saint Barthelemy</option>
                                                        <option value="KN">Saint Kitts and Nevis</option>
                                                        <option value="LC">Saint Lucia</option>
                                                        <option value="MAF">Saint Martin</option>
                                                        <option value="VC">Saint Vincent and the Grenadines</option>
                                                        <option value="WS">Samoa</option>
                                                        <option value="SM">San Marino</option>
                                                        <option value="ST">Sao Tome and Principe</option>
                                                        <option value="SA">Saudi Arabia</option>
                                                        <option value="SCT">Scotland</option>
                                                        <option value="SN">Senegal</option>
                                                        <option value="SRB">Serbia</option>
                                                        <option value="SC">Seychelles</option>
                                                        <option value="SL">Sierra Leone</option>
                                                        <option value="SG">Singapore</option>
                                                        <option value="SK">Slovakia (Slovak Republic)</option>
                                                        <option value="SI">Slovenia</option>
                                                        <option value="SB">Solomon Islands</option>
                                                        <option value="SO">Somalia</option>
                                                        <option value="ZA">South Africa</option>
                                                        <option value="SGS">South Georgia and the South Sandwich Islands</option>
                                                        <option value="KR">South Korea</option>
                                                        <option value="SS">South Sudan</option>
                                                        <option value="ES">Spain</option>
                                                        <option value="LK">Sri Lanka</option>
                                                        <option value="SH">St. Helena</option>
                                                        <option value="PM">St. Pierre and Miquelon</option>
                                                        <option value="SD">Sudan</option>
                                                        <option value="SR">Suriname</option>
                                                        <option value="SJ">Svalbard and Jan Mayen Islands</option>
                                                        <option value="SZ">Swaziland</option>
                                                        <option value="SE">Sweden</option>
                                                        <option value="CH">Switzerland</option>
                                                        <option value="SY">Syrian Arab Republic</option>
                                                        <option value="TW">Taiwan</option>
                                                        <option value="TJ">Tajikistan</option>
                                                        <option value="TZ">Tanzania</option>
                                                        <option value="TH">Thailand</option>
                                                        <option value="TLS">Timor-Leste</option>
                                                        <option value="TG">Togo</option>
                                                        <option value="TK">Tokelau</option>
                                                        <option value="TO">Tonga</option>
                                                        <option value="TT">Trinidad and Tobago</option>
                                                        <option value="TN">Tunisia</option>
                                                        <option value="TR">Turkey</option>
                                                        <option value="TM">Turkmenistan</option>
                                                        <option value="TC">Turks and Caicos Islands</option>
                                                        <option value="TV">Tuvalu</option>
                                                        <option value="UG">Uganda</option>
                                                        <option value="UA">Ukraine</option>
                                                        <option value="AE">United Arab Emirates</option>
                                                        <option value="UK">United Kingdom</option>
                                                        <option value="US">United States</option>
                                                        <option value="UM">United States Minor Outlying Islands</option>
                                                        <option value="UY">Uruguay</option>
                                                        <option value="UZ">Uzbekistan</option>
                                                        <option value="VU">Vanuatu</option>
                                                        <option value="VA">Vatican City State (Holy See)</option>
                                                        <option value="VE">Venezuela</option>
                                                        <option value="VN">Vietnam</option>
                                                        <option value="VG">Virgin Islands (British)</option>
                                                        <option value="VI">Virgin Islands (U.S.)</option>
                                                        <option value="WF">Wallis And Futuna Islands</option>
                                                        <option value="EH">Western Sahara</option>
                                                        <option value="YE">Yemen</option>
                                                        <option value="YU">Yugoslavia</option>
                                                        <option value="ZM">Zambia</option>
                                                        <option value="EAZ">Zanzibar</option>
                                                        <option value="ZW">Zimbabwe</option>
                                                        <option value="CW">Curacao</option>
                                                        <option value="SX">Sint Maarten</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label ">Products You Supply To Customer:</label>
                                                <div class="col-sm-8">
                                                    <input type="text" name="products_supply" class="form-control" placeholder="">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label ">Annual Turnover US$:</label>
                                                <div class="col-sm-8">
                                                    <input type="text" name="annual_turnover" class="form-control" placeholder="">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label">Cooperation photos:</label>
                                                <div class="col-sm-8">
                                                    <input type="file" name="cooperation_photos" class="form-control">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label">Transaction Documents:</label>
                                                <div class="col-sm-8">
                                                    <input type="file" name="transaction_documents" class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-1">
                                            <div class="clone-leftside-btn-2 cloneya-wrap">
                                                <div class="unit toclone-widget-left toclone cloneya cloneya1">
                                                    <button type="button" class="btn btn-primary clone-btn-left clone clone1" id="add_com">
                                                    +
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row" id="company_second_wrapper">
                                        <div class="col-md-2"></div>
                                        <div class="col-md-7 col-sm-7 col-xs-12 bd1px" >
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label ">Project/customer name:</label>
                                                <div class="col-sm-8">
                                                    <input type="text" name="customer_name" class="form-control" placeholder="">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label ">Host Country/Region:</label>
                                                <div class="col-sm-8">
                                                    <select name="country_region" class="form-control">
                                                        <option value="">--please select--</option>
                                                        <option value="AF">Afghanistan</option>
                                                        <option value="ALA">Aland Islands</option>
                                                        <option value="AL">Albania</option>
                                                        <option value="GBA">Alderney</option>
                                                        <option value="DZ">Algeria</option>
                                                        <option value="AS">American Samoa</option>
                                                        <option value="AD">Andorra</option>
                                                        <option value="AO">Angola</option>
                                                        <option value="AI">Anguilla</option>
                                                        <option value="AQ">Antarctica</option>
                                                        <option value="AG">Antigua and Barbuda</option>
                                                        <option value="AR">Argentina</option>
                                                        <option value="AM">Armenia</option>
                                                        <option value="AW">Aruba</option>
                                                        <option value="ASC">Ascension Island</option>
                                                        <option value="AU">Australia</option>
                                                        <option value="AT">Austria</option>
                                                        <option value="AZ">Azerbaijan</option>
                                                        <option value="BS">Bahamas</option>
                                                        <option value="BH">Bahrain</option>
                                                        <option value="BD">Bangladesh</option>
                                                        <option value="BB">Barbados</option>
                                                        <option value="BY">Belarus</option>
                                                        <option value="BE">Belgium</option>
                                                        <option value="BZ">Belize</option>
                                                        <option value="BJ">Benin</option>
                                                        <option value="BM">Bermuda</option>
                                                        <option value="BT">Bhutan</option>
                                                        <option value="BO">Bolivia</option>
                                                        <option value="BA">Bosnia and Herzegovina</option>
                                                        <option value="BW">Botswana</option>
                                                        <option value="BV">Bouvet Island</option>
                                                        <option value="BR">Brazil</option>
                                                        <option value="IO">British Indian Ocean Territory</option>
                                                        <option value="BN">Brunei Darussalam</option>
                                                        <option value="BG">Bulgaria</option>
                                                        <option value="BF">Burkina Faso</option>
                                                        <option value="BI">Burundi</option>
                                                        <option value="KH">Cambodia</option>
                                                        <option value="CM">Cameroon</option>
                                                        <option value="CA">Canada</option>
                                                        <option value="CV">Cape Verde</option>
                                                        <option value="KY">Cayman Islands</option>
                                                        <option value="CF">Central African Republic</option>
                                                        <option value="TD">Chad</option>
                                                        <option value="CL">Chile</option>
                                                        <option value="CN">China (Mainland)</option>
                                                        <option value="CX">Christmas Island</option>
                                                        <option value="CC">Cocos (Keeling) Islands</option>
                                                        <option value="CO">Colombia</option>
                                                        <option value="KM">Comoros</option>
                                                        <option value="ZR">Congo, The Democratic Republic Of The</option>
                                                        <option value="CG">Congo, The Republic of Congo</option>
                                                        <option value="CK">Cook Islands</option>
                                                        <option value="CR">Costa Rica</option>
                                                        <option value="CI">Cote D'Ivoire</option>
                                                        <option value="HR">Croatia (local name: Hrvatska)</option>
                                                        <option value="CU">Cuba</option>
                                                        <option value="CY">Cyprus</option>
                                                        <option value="CZ">Czech Republic</option>
                                                        <option value="DK">Denmark</option>
                                                        <option value="DJ">Djibouti</option>
                                                        <option value="DM">Dominica</option>
                                                        <option value="DO">Dominican Republic</option>
                                                        <option value="TP">East Timor</option>
                                                        <option value="EC">Ecuador</option>
                                                        <option value="EG">Egypt</option>
                                                        <option value="SV">El Salvador</option>
                                                        <option value="GQ">Equatorial Guinea</option>
                                                        <option value="ER">Eritrea</option>
                                                        <option value="EE">Estonia</option>
                                                        <option value="ET">Ethiopia</option>
                                                        <option value="FK">Falkland Islands (Malvinas)</option>
                                                        <option value="FO">Faroe Islands</option>
                                                        <option value="FJ">Fiji</option>
                                                        <option value="FI">Finland</option>
                                                        <option value="FR">France</option>
                                                        <option value="FX">France Metropolitan</option>
                                                        <option value="GF">French Guiana</option>
                                                        <option value="PF">French Polynesia</option>
                                                        <option value="TF">French Southern Territories</option>
                                                        <option value="GA">Gabon</option>
                                                        <option value="GM">Gambia</option>
                                                        <option value="GE">Georgia</option>
                                                        <option value="DE">Germany</option>
                                                        <option value="GH">Ghana</option>
                                                        <option value="GI">Gibraltar</option>
                                                        <option value="GR">Greece</option>
                                                        <option value="GL">Greenland</option>
                                                        <option value="GD">Grenada</option>
                                                        <option value="GP">Guadeloupe</option>
                                                        <option value="GU">Guam</option>
                                                        <option value="GT">Guatemala</option>
                                                        <option value="GGY">Guernsey</option>
                                                        <option value="GN">Guinea</option>
                                                        <option value="GW">Guinea-Bissau</option>
                                                        <option value="GY">Guyana</option>
                                                        <option value="HT">Haiti</option>
                                                        <option value="HM">Heard and Mc Donald Islands</option>
                                                        <option value="HN">Honduras</option>
                                                        <option value="HK">Hong Kong</option>
                                                        <option value="HU">Hungary</option>
                                                        <option value="IS">Iceland</option>
                                                        <option value="IN">India</option>
                                                        <option value="ID">Indonesia</option>
                                                        <option value="IR">Iran (Islamic Republic of)</option>
                                                        <option value="IQ">Iraq</option>
                                                        <option value="IE">Ireland</option>
                                                        <option value="IM">Isle of Man</option>
                                                        <option value="IL">Israel</option>
                                                        <option value="IT">Italy</option>
                                                        <option value="JM">Jamaica</option>
                                                        <option value="JP">Japan</option>
                                                        <option value="JEY">Jersey</option>
                                                        <option value="JO">Jordan</option>
                                                        <option value="KZ">Kazakhstan</option>
                                                        <option value="KE">Kenya</option>
                                                        <option value="KI">Kiribati</option>
                                                        <option value="KS">Kosovo</option>
                                                        <option value="KW">Kuwait</option>
                                                        <option value="KG">Kyrgyzstan</option>
                                                        <option value="LA">Lao People's Democratic Republic</option>
                                                        <option value="LV">Latvia</option>
                                                        <option value="LB">Lebanon</option>
                                                        <option value="LS">Lesotho</option>
                                                        <option value="LR">Liberia</option>
                                                        <option value="LY">Libya</option>
                                                        <option value="LI">Liechtenstein</option>
                                                        <option value="LT">Lithuania</option>
                                                        <option value="LU">Luxembourg</option>
                                                        <option value="MO">Macau</option>
                                                        <option value="MK">Macedonia</option>
                                                        <option value="MG">Madagascar</option>
                                                        <option value="MW">Malawi</option>
                                                        <option value="MY">Malaysia</option>
                                                        <option value="MV">Maldives</option>
                                                        <option value="ML">Mali</option>
                                                        <option value="MT">Malta</option>
                                                        <option value="MH">Marshall Islands</option>
                                                        <option value="MQ">Martinique</option>
                                                        <option value="MR">Mauritania</option>
                                                        <option value="MU">Mauritius</option>
                                                        <option value="YT">Mayotte</option>
                                                        <option value="MX">Mexico</option>
                                                        <option value="FM">Micronesia</option>
                                                        <option value="MD">Moldova</option>
                                                        <option value="MC">Monaco</option>
                                                        <option value="MN">Mongolia</option>
                                                        <option value="MNE">Montenegro</option>
                                                        <option value="MS">Montserrat</option>
                                                        <option value="MA">Morocco</option>
                                                        <option value="MZ">Mozambique</option>
                                                        <option value="MM">Myanmar</option>
                                                        <option value="NA">Namibia</option>
                                                        <option value="NR">Nauru</option>
                                                        <option value="NP">Nepal</option>
                                                        <option value="NL">Netherlands</option>
                                                        <option value="AN">Netherlands Antilles</option>
                                                        <option value="NC">New Caledonia</option>
                                                        <option value="NZ">New Zealand</option>
                                                        <option value="NI">Nicaragua</option>
                                                        <option value="NE">Niger</option>
                                                        <option value="NG">Nigeria</option>
                                                        <option value="NU">Niue</option>
                                                        <option value="NF">Norfolk Island</option>
                                                        <option value="KP">North Korea</option>
                                                        <option value="MP">Northern Mariana Islands</option>
                                                        <option value="NO">Norway</option>
                                                        <option value="OM">Oman</option>
                                                        <option value="Other">Other Country</option>
                                                        <option value="PK">Pakistan</option>
                                                        <option value="PW">Palau</option>
                                                        <option value="PS">Palestine</option>
                                                        <option value="PA">Panama</option>
                                                        <option value="PG">Papua New Guinea</option>
                                                        <option value="PY">Paraguay</option>
                                                        <option value="PE">Peru</option>
                                                        <option value="PH">Philippines</option>
                                                        <option value="PN">Pitcairn</option>
                                                        <option value="PL">Poland</option>
                                                        <option value="PT">Portugal</option>
                                                        <option value="PR">Puerto Rico</option>
                                                        <option value="QA">Qatar</option>
                                                        <option value="RE">Reunion</option>
                                                        <option value="RO">Romania</option>
                                                        <option value="RU">Russian Federation</option>
                                                        <option value="RW">Rwanda</option>
                                                        <option value="BLM">Saint Barthelemy</option>
                                                        <option value="KN">Saint Kitts and Nevis</option>
                                                        <option value="LC">Saint Lucia</option>
                                                        <option value="MAF">Saint Martin</option>
                                                        <option value="VC">Saint Vincent and the Grenadines</option>
                                                        <option value="WS">Samoa</option>
                                                        <option value="SM">San Marino</option>
                                                        <option value="ST">Sao Tome and Principe</option>
                                                        <option value="SA">Saudi Arabia</option>
                                                        <option value="SCT">Scotland</option>
                                                        <option value="SN">Senegal</option>
                                                        <option value="SRB">Serbia</option>
                                                        <option value="SC">Seychelles</option>
                                                        <option value="SL">Sierra Leone</option>
                                                        <option value="SG">Singapore</option>
                                                        <option value="SK">Slovakia (Slovak Republic)</option>
                                                        <option value="SI">Slovenia</option>
                                                        <option value="SB">Solomon Islands</option>
                                                        <option value="SO">Somalia</option>
                                                        <option value="ZA">South Africa</option>
                                                        <option value="SGS">South Georgia and the South Sandwich Islands</option>
                                                        <option value="KR">South Korea</option>
                                                        <option value="SS">South Sudan</option>
                                                        <option value="ES">Spain</option>
                                                        <option value="LK">Sri Lanka</option>
                                                        <option value="SH">St. Helena</option>
                                                        <option value="PM">St. Pierre and Miquelon</option>
                                                        <option value="SD">Sudan</option>
                                                        <option value="SR">Suriname</option>
                                                        <option value="SJ">Svalbard and Jan Mayen Islands</option>
                                                        <option value="SZ">Swaziland</option>
                                                        <option value="SE">Sweden</option>
                                                        <option value="CH">Switzerland</option>
                                                        <option value="SY">Syrian Arab Republic</option>
                                                        <option value="TW">Taiwan</option>
                                                        <option value="TJ">Tajikistan</option>
                                                        <option value="TZ">Tanzania</option>
                                                        <option value="TH">Thailand</option>
                                                        <option value="TLS">Timor-Leste</option>
                                                        <option value="TG">Togo</option>
                                                        <option value="TK">Tokelau</option>
                                                        <option value="TO">Tonga</option>
                                                        <option value="TT">Trinidad and Tobago</option>
                                                        <option value="TN">Tunisia</option>
                                                        <option value="TR">Turkey</option>
                                                        <option value="TM">Turkmenistan</option>
                                                        <option value="TC">Turks and Caicos Islands</option>
                                                        <option value="TV">Tuvalu</option>
                                                        <option value="UG">Uganda</option>
                                                        <option value="UA">Ukraine</option>
                                                        <option value="AE">United Arab Emirates</option>
                                                        <option value="UK">United Kingdom</option>
                                                        <option value="US">United States</option>
                                                        <option value="UM">United States Minor Outlying Islands</option>
                                                        <option value="UY">Uruguay</option>
                                                        <option value="UZ">Uzbekistan</option>
                                                        <option value="VU">Vanuatu</option>
                                                        <option value="VA">Vatican City State (Holy See)</option>
                                                        <option value="VE">Venezuela</option>
                                                        <option value="VN">Vietnam</option>
                                                        <option value="VG">Virgin Islands (British)</option>
                                                        <option value="VI">Virgin Islands (U.S.)</option>
                                                        <option value="WF">Wallis And Futuna Islands</option>
                                                        <option value="EH">Western Sahara</option>
                                                        <option value="YE">Yemen</option>
                                                        <option value="YU">Yugoslavia</option>
                                                        <option value="ZM">Zambia</option>
                                                        <option value="EAZ">Zanzibar</option>
                                                        <option value="ZW">Zimbabwe</option>
                                                        <option value="CW">Curacao</option>
                                                        <option value="SX">Sint Maarten</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label ">Products You Supply To Customer:</label>
                                                <div class="col-sm-8">
                                                    <input type="text" name="products_supply" class="form-control" placeholder="">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label ">Annual Turnover US$:</label>
                                                <div class="col-sm-8">
                                                    <input type="text" name="annual_turnover" class="form-control" placeholder="">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label">Cooperation photos:</label>
                                                <div class="col-sm-8">
                                                    <input type="file" name="cooperation_photos" class="form-control">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label">Transaction Documents:</label>
                                                <div class="col-sm-8">
                                                    <input type="file" name="transaction_documents" class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-1">
                                            <div class="clone-leftside-btn-2 cloneya-wrap">
                                                <div class="unit toclone-widget-left toclone cloneya cloneya1">
                                                    <button type="button" class="btn btn-default clone-btn-left delete" id="delete4">
                                                    -
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label">No. of Employees in Trade Department:</label>
                                        <div class="col-sm-5">
                                            <select name="no_of_employee" class="form-control">
                                                <option value="">--- Please select ---</option>
                                                <option value="1">Fewer than 5 People</option>
                                                <option value="2">5 - 10 People</option>
                                                <option value="3">11 - 50 People</option>
                                                <option value="4">51 - 100 People</option>
                                                <option value="5">101 - 200 People</option>
                                                <option value="6">201 - 300 People</option>
                                                <option value="7">301 - 500 People</option>
                                                <option value="8">501 - 1000 People</option>
                                                <option value="9">Above 1000 People</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label">Nearest Port:</label>
                                        <div class="col-sm-3">
                                            <input type="text" name="nearest_port" class="form-control" placeholder="">
                                        </div>
                                        <div class="col-sm-3">
                                            <input type="text" name="nearest_port" class="form-control" placeholder="">
                                        </div>
                                        <div class="col-sm-3">
                                            <input type="text" name="nearest_port" class="form-control" placeholder="">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label">Average Lead Time:</label>
                                        <div class="col-sm-3">
                                            <input type="text" name="average_lead_time" class="form-control" placeholder=""> 
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label">Does your company have an overseas office?</label>
                                        <div class="col-sm-10">
                                            <select name="does_your_company" class="form-control" id="company_overseas">
                                                <option value="NO">NO</option>
                                                <option value="YES">YES</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row" id="company_wrapper">
                                        <div class="col-md-2"></div>
                                        <div class="col-md-7 col-sm-7 col-xs-12 bd1px" >
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label ">Host Country/Region:</label>
                                                <div class="col-sm-8">
                                                    <select name="country_region" class="form-control">
                                                        <option value="">--please select--</option>
                                                        <option value="AF">Afghanistan</option>
                                                        <option value="ALA">Aland Islands</option>
                                                        <option value="AL">Albania</option>
                                                        <option value="GBA">Alderney</option>
                                                        <option value="DZ">Algeria</option>
                                                        <option value="AS">American Samoa</option>
                                                        <option value="AD">Andorra</option>
                                                        <option value="AO">Angola</option>
                                                        <option value="AI">Anguilla</option>
                                                        <option value="AQ">Antarctica</option>
                                                        <option value="AG">Antigua and Barbuda</option>
                                                        <option value="AR">Argentina</option>
                                                        <option value="AM">Armenia</option>
                                                        <option value="AW">Aruba</option>
                                                        <option value="ASC">Ascension Island</option>
                                                        <option value="AU">Australia</option>
                                                        <option value="AT">Austria</option>
                                                        <option value="AZ">Azerbaijan</option>
                                                        <option value="BS">Bahamas</option>
                                                        <option value="BH">Bahrain</option>
                                                        <option value="BD">Bangladesh</option>
                                                        <option value="BB">Barbados</option>
                                                        <option value="BY">Belarus</option>
                                                        <option value="BE">Belgium</option>
                                                        <option value="BZ">Belize</option>
                                                        <option value="BJ">Benin</option>
                                                        <option value="BM">Bermuda</option>
                                                        <option value="BT">Bhutan</option>
                                                        <option value="BO">Bolivia</option>
                                                        <option value="BA">Bosnia and Herzegovina</option>
                                                        <option value="BW">Botswana</option>
                                                        <option value="BV">Bouvet Island</option>
                                                        <option value="BR">Brazil</option>
                                                        <option value="IO">British Indian Ocean Territory</option>
                                                        <option value="BN">Brunei Darussalam</option>
                                                        <option value="BG">Bulgaria</option>
                                                        <option value="BF">Burkina Faso</option>
                                                        <option value="BI">Burundi</option>
                                                        <option value="KH">Cambodia</option>
                                                        <option value="CM">Cameroon</option>
                                                        <option value="CA">Canada</option>
                                                        <option value="CV">Cape Verde</option>
                                                        <option value="KY">Cayman Islands</option>
                                                        <option value="CF">Central African Republic</option>
                                                        <option value="TD">Chad</option>
                                                        <option value="CL">Chile</option>
                                                        <option value="CN">China (Mainland)</option>
                                                        <option value="CX">Christmas Island</option>
                                                        <option value="CC">Cocos (Keeling) Islands</option>
                                                        <option value="CO">Colombia</option>
                                                        <option value="KM">Comoros</option>
                                                        <option value="ZR">Congo, The Democratic Republic Of The</option>
                                                        <option value="CG">Congo, The Republic of Congo</option>
                                                        <option value="CK">Cook Islands</option>
                                                        <option value="CR">Costa Rica</option>
                                                        <option value="CI">Cote D'Ivoire</option>
                                                        <option value="HR">Croatia (local name: Hrvatska)</option>
                                                        <option value="CU">Cuba</option>
                                                        <option value="CY">Cyprus</option>
                                                        <option value="CZ">Czech Republic</option>
                                                        <option value="DK">Denmark</option>
                                                        <option value="DJ">Djibouti</option>
                                                        <option value="DM">Dominica</option>
                                                        <option value="DO">Dominican Republic</option>
                                                        <option value="TP">East Timor</option>
                                                        <option value="EC">Ecuador</option>
                                                        <option value="EG">Egypt</option>
                                                        <option value="SV">El Salvador</option>
                                                        <option value="GQ">Equatorial Guinea</option>
                                                        <option value="ER">Eritrea</option>
                                                        <option value="EE">Estonia</option>
                                                        <option value="ET">Ethiopia</option>
                                                        <option value="FK">Falkland Islands (Malvinas)</option>
                                                        <option value="FO">Faroe Islands</option>
                                                        <option value="FJ">Fiji</option>
                                                        <option value="FI">Finland</option>
                                                        <option value="FR">France</option>
                                                        <option value="FX">France Metropolitan</option>
                                                        <option value="GF">French Guiana</option>
                                                        <option value="PF">French Polynesia</option>
                                                        <option value="TF">French Southern Territories</option>
                                                        <option value="GA">Gabon</option>
                                                        <option value="GM">Gambia</option>
                                                        <option value="GE">Georgia</option>
                                                        <option value="DE">Germany</option>
                                                        <option value="GH">Ghana</option>
                                                        <option value="GI">Gibraltar</option>
                                                        <option value="GR">Greece</option>
                                                        <option value="GL">Greenland</option>
                                                        <option value="GD">Grenada</option>
                                                        <option value="GP">Guadeloupe</option>
                                                        <option value="GU">Guam</option>
                                                        <option value="GT">Guatemala</option>
                                                        <option value="GGY">Guernsey</option>
                                                        <option value="GN">Guinea</option>
                                                        <option value="GW">Guinea-Bissau</option>
                                                        <option value="GY">Guyana</option>
                                                        <option value="HT">Haiti</option>
                                                        <option value="HM">Heard and Mc Donald Islands</option>
                                                        <option value="HN">Honduras</option>
                                                        <option value="HK">Hong Kong</option>
                                                        <option value="HU">Hungary</option>
                                                        <option value="IS">Iceland</option>
                                                        <option value="IN">India</option>
                                                        <option value="ID">Indonesia</option>
                                                        <option value="IR">Iran (Islamic Republic of)</option>
                                                        <option value="IQ">Iraq</option>
                                                        <option value="IE">Ireland</option>
                                                        <option value="IM">Isle of Man</option>
                                                        <option value="IL">Israel</option>
                                                        <option value="IT">Italy</option>
                                                        <option value="JM">Jamaica</option>
                                                        <option value="JP">Japan</option>
                                                        <option value="JEY">Jersey</option>
                                                        <option value="JO">Jordan</option>
                                                        <option value="KZ">Kazakhstan</option>
                                                        <option value="KE">Kenya</option>
                                                        <option value="KI">Kiribati</option>
                                                        <option value="KS">Kosovo</option>
                                                        <option value="KW">Kuwait</option>
                                                        <option value="KG">Kyrgyzstan</option>
                                                        <option value="LA">Lao People's Democratic Republic</option>
                                                        <option value="LV">Latvia</option>
                                                        <option value="LB">Lebanon</option>
                                                        <option value="LS">Lesotho</option>
                                                        <option value="LR">Liberia</option>
                                                        <option value="LY">Libya</option>
                                                        <option value="LI">Liechtenstein</option>
                                                        <option value="LT">Lithuania</option>
                                                        <option value="LU">Luxembourg</option>
                                                        <option value="MO">Macau</option>
                                                        <option value="MK">Macedonia</option>
                                                        <option value="MG">Madagascar</option>
                                                        <option value="MW">Malawi</option>
                                                        <option value="MY">Malaysia</option>
                                                        <option value="MV">Maldives</option>
                                                        <option value="ML">Mali</option>
                                                        <option value="MT">Malta</option>
                                                        <option value="MH">Marshall Islands</option>
                                                        <option value="MQ">Martinique</option>
                                                        <option value="MR">Mauritania</option>
                                                        <option value="MU">Mauritius</option>
                                                        <option value="YT">Mayotte</option>
                                                        <option value="MX">Mexico</option>
                                                        <option value="FM">Micronesia</option>
                                                        <option value="MD">Moldova</option>
                                                        <option value="MC">Monaco</option>
                                                        <option value="MN">Mongolia</option>
                                                        <option value="MNE">Montenegro</option>
                                                        <option value="MS">Montserrat</option>
                                                        <option value="MA">Morocco</option>
                                                        <option value="MZ">Mozambique</option>
                                                        <option value="MM">Myanmar</option>
                                                        <option value="NA">Namibia</option>
                                                        <option value="NR">Nauru</option>
                                                        <option value="NP">Nepal</option>
                                                        <option value="NL">Netherlands</option>
                                                        <option value="AN">Netherlands Antilles</option>
                                                        <option value="NC">New Caledonia</option>
                                                        <option value="NZ">New Zealand</option>
                                                        <option value="NI">Nicaragua</option>
                                                        <option value="NE">Niger</option>
                                                        <option value="NG">Nigeria</option>
                                                        <option value="NU">Niue</option>
                                                        <option value="NF">Norfolk Island</option>
                                                        <option value="KP">North Korea</option>
                                                        <option value="MP">Northern Mariana Islands</option>
                                                        <option value="NO">Norway</option>
                                                        <option value="OM">Oman</option>
                                                        <option value="Other">Other Country</option>
                                                        <option value="PK">Pakistan</option>
                                                        <option value="PW">Palau</option>
                                                        <option value="PS">Palestine</option>
                                                        <option value="PA">Panama</option>
                                                        <option value="PG">Papua New Guinea</option>
                                                        <option value="PY">Paraguay</option>
                                                        <option value="PE">Peru</option>
                                                        <option value="PH">Philippines</option>
                                                        <option value="PN">Pitcairn</option>
                                                        <option value="PL">Poland</option>
                                                        <option value="PT">Portugal</option>
                                                        <option value="PR">Puerto Rico</option>
                                                        <option value="QA">Qatar</option>
                                                        <option value="RE">Reunion</option>
                                                        <option value="RO">Romania</option>
                                                        <option value="RU">Russian Federation</option>
                                                        <option value="RW">Rwanda</option>
                                                        <option value="BLM">Saint Barthelemy</option>
                                                        <option value="KN">Saint Kitts and Nevis</option>
                                                        <option value="LC">Saint Lucia</option>
                                                        <option value="MAF">Saint Martin</option>
                                                        <option value="VC">Saint Vincent and the Grenadines</option>
                                                        <option value="WS">Samoa</option>
                                                        <option value="SM">San Marino</option>
                                                        <option value="ST">Sao Tome and Principe</option>
                                                        <option value="SA">Saudi Arabia</option>
                                                        <option value="SCT">Scotland</option>
                                                        <option value="SN">Senegal</option>
                                                        <option value="SRB">Serbia</option>
                                                        <option value="SC">Seychelles</option>
                                                        <option value="SL">Sierra Leone</option>
                                                        <option value="SG">Singapore</option>
                                                        <option value="SK">Slovakia (Slovak Republic)</option>
                                                        <option value="SI">Slovenia</option>
                                                        <option value="SB">Solomon Islands</option>
                                                        <option value="SO">Somalia</option>
                                                        <option value="ZA">South Africa</option>
                                                        <option value="SGS">South Georgia and the South Sandwich Islands</option>
                                                        <option value="KR">South Korea</option>
                                                        <option value="SS">South Sudan</option>
                                                        <option value="ES">Spain</option>
                                                        <option value="LK">Sri Lanka</option>
                                                        <option value="SH">St. Helena</option>
                                                        <option value="PM">St. Pierre and Miquelon</option>
                                                        <option value="SD">Sudan</option>
                                                        <option value="SR">Suriname</option>
                                                        <option value="SJ">Svalbard and Jan Mayen Islands</option>
                                                        <option value="SZ">Swaziland</option>
                                                        <option value="SE">Sweden</option>
                                                        <option value="CH">Switzerland</option>
                                                        <option value="SY">Syrian Arab Republic</option>
                                                        <option value="TW">Taiwan</option>
                                                        <option value="TJ">Tajikistan</option>
                                                        <option value="TZ">Tanzania</option>
                                                        <option value="TH">Thailand</option>
                                                        <option value="TLS">Timor-Leste</option>
                                                        <option value="TG">Togo</option>
                                                        <option value="TK">Tokelau</option>
                                                        <option value="TO">Tonga</option>
                                                        <option value="TT">Trinidad and Tobago</option>
                                                        <option value="TN">Tunisia</option>
                                                        <option value="TR">Turkey</option>
                                                        <option value="TM">Turkmenistan</option>
                                                        <option value="TC">Turks and Caicos Islands</option>
                                                        <option value="TV">Tuvalu</option>
                                                        <option value="UG">Uganda</option>
                                                        <option value="UA">Ukraine</option>
                                                        <option value="AE">United Arab Emirates</option>
                                                        <option value="UK">United Kingdom</option>
                                                        <option value="US">United States</option>
                                                        <option value="UM">United States Minor Outlying Islands</option>
                                                        <option value="UY">Uruguay</option>
                                                        <option value="UZ">Uzbekistan</option>
                                                        <option value="VU">Vanuatu</option>
                                                        <option value="VA">Vatican City State (Holy See)</option>
                                                        <option value="VE">Venezuela</option>
                                                        <option value="VN">Vietnam</option>
                                                        <option value="VG">Virgin Islands (British)</option>
                                                        <option value="VI">Virgin Islands (U.S.)</option>
                                                        <option value="WF">Wallis And Futuna Islands</option>
                                                        <option value="EH">Western Sahara</option>
                                                        <option value="YE">Yemen</option>
                                                        <option value="YU">Yugoslavia</option>
                                                        <option value="ZM">Zambia</option>
                                                        <option value="EAZ">Zanzibar</option>
                                                        <option value="ZW">Zimbabwe</option>
                                                        <option value="CW">Curacao</option>
                                                        <option value="SX">Sint Maarten</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label ">Province/State/County:</label>
                                                <div class="col-sm-8">
                                                    <input type="text" name="provience_state" class="form-control" placeholder="">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label ">City:</label>
                                                <div class="col-sm-8">
                                                    <input type="text" name="city" class="form-control" placeholder="">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label ">Street Address:</label>
                                                <div class="col-sm-8">
                                                    <input type="text" name="street_address" class="form-control" placeholder="">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label ">Telephone:</label>
                                                <div class="col-sm-2">
                                                    <input type="text" name="telephone" class="form-control" placeholder="country code">
                                                </div>
                                                <div class="col-sm-2">
                                                    <input type="text" name="telephone" class="form-control" placeholder="area code">
                                                </div>
                                                <div class="col-sm-2">
                                                    <input type="text" name="telephone" class="form-control" placeholder="phonr number">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label ">Duties:</label>
                                                <div class="col-sm-8">
                                                    <select name="duties" class="form-control">
                                                        <option value="">Please select:</option>
                                                        <option value="2021">Sale</option>
                                                        <option value="2020">After sale Service</option>
                                                        <option value="2019">Other</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label ">Person-in-Charge:</label>
                                                <div class="col-sm-8">
                                                    <input type="text" name="person_charge" class="form-control" placeholder="">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label ">Number of Staff:</label>
                                                <div class="col-sm-8">
                                                    <input type="text" name="number_staff" class="form-control" placeholder="">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label">Property Ownership/Lease Certifications:</label>
                                                <div class="col-sm-8">
                                                    <input type="file" name="property_ownership" class="form-control">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label">Office Photos:</label>
                                                <div class="col-sm-8">
                                                    <input type="file" name="office_photos" class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-1">
                                            <div class="clone-leftside-btn-2 cloneya-wrap">
                                                <div class="unit toclone-widget-left toclone cloneya cloneya1">
                                                    <button type="button" class="btn btn-primary clone-btn-left clone clone1" id="add_com">
                                                    +
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row" id="company_wrapper_2">
                                        <div class="col-md-2"></div>
                                        <div class="col-md-7 col-sm-7 col-xs-12 bd1px" >
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label ">Host Country/Region:</label>
                                                <div class="col-sm-8">
                                                    <select name="country_region" class="form-control">
                                                        <option value="">--please select--</option>
                                                        <option value="AF">Afghanistan</option>
                                                        <option value="ALA">Aland Islands</option>
                                                        <option value="AL">Albania</option>
                                                        <option value="GBA">Alderney</option>
                                                        <option value="DZ">Algeria</option>
                                                        <option value="AS">American Samoa</option>
                                                        <option value="AD">Andorra</option>
                                                        <option value="AO">Angola</option>
                                                        <option value="AI">Anguilla</option>
                                                        <option value="AQ">Antarctica</option>
                                                        <option value="AG">Antigua and Barbuda</option>
                                                        <option value="AR">Argentina</option>
                                                        <option value="AM">Armenia</option>
                                                        <option value="AW">Aruba</option>
                                                        <option value="ASC">Ascension Island</option>
                                                        <option value="AU">Australia</option>
                                                        <option value="AT">Austria</option>
                                                        <option value="AZ">Azerbaijan</option>
                                                        <option value="BS">Bahamas</option>
                                                        <option value="BH">Bahrain</option>
                                                        <option value="BD">Bangladesh</option>
                                                        <option value="BB">Barbados</option>
                                                        <option value="BY">Belarus</option>
                                                        <option value="BE">Belgium</option>
                                                        <option value="BZ">Belize</option>
                                                        <option value="BJ">Benin</option>
                                                        <option value="BM">Bermuda</option>
                                                        <option value="BT">Bhutan</option>
                                                        <option value="BO">Bolivia</option>
                                                        <option value="BA">Bosnia and Herzegovina</option>
                                                        <option value="BW">Botswana</option>
                                                        <option value="BV">Bouvet Island</option>
                                                        <option value="BR">Brazil</option>
                                                        <option value="IO">British Indian Ocean Territory</option>
                                                        <option value="BN">Brunei Darussalam</option>
                                                        <option value="BG">Bulgaria</option>
                                                        <option value="BF">Burkina Faso</option>
                                                        <option value="BI">Burundi</option>
                                                        <option value="KH">Cambodia</option>
                                                        <option value="CM">Cameroon</option>
                                                        <option value="CA">Canada</option>
                                                        <option value="CV">Cape Verde</option>
                                                        <option value="KY">Cayman Islands</option>
                                                        <option value="CF">Central African Republic</option>
                                                        <option value="TD">Chad</option>
                                                        <option value="CL">Chile</option>
                                                        <option value="CN">China (Mainland)</option>
                                                        <option value="CX">Christmas Island</option>
                                                        <option value="CC">Cocos (Keeling) Islands</option>
                                                        <option value="CO">Colombia</option>
                                                        <option value="KM">Comoros</option>
                                                        <option value="ZR">Congo, The Democratic Republic Of The</option>
                                                        <option value="CG">Congo, The Republic of Congo</option>
                                                        <option value="CK">Cook Islands</option>
                                                        <option value="CR">Costa Rica</option>
                                                        <option value="CI">Cote D'Ivoire</option>
                                                        <option value="HR">Croatia (local name: Hrvatska)</option>
                                                        <option value="CU">Cuba</option>
                                                        <option value="CY">Cyprus</option>
                                                        <option value="CZ">Czech Republic</option>
                                                        <option value="DK">Denmark</option>
                                                        <option value="DJ">Djibouti</option>
                                                        <option value="DM">Dominica</option>
                                                        <option value="DO">Dominican Republic</option>
                                                        <option value="TP">East Timor</option>
                                                        <option value="EC">Ecuador</option>
                                                        <option value="EG">Egypt</option>
                                                        <option value="SV">El Salvador</option>
                                                        <option value="GQ">Equatorial Guinea</option>
                                                        <option value="ER">Eritrea</option>
                                                        <option value="EE">Estonia</option>
                                                        <option value="ET">Ethiopia</option>
                                                        <option value="FK">Falkland Islands (Malvinas)</option>
                                                        <option value="FO">Faroe Islands</option>
                                                        <option value="FJ">Fiji</option>
                                                        <option value="FI">Finland</option>
                                                        <option value="FR">France</option>
                                                        <option value="FX">France Metropolitan</option>
                                                        <option value="GF">French Guiana</option>
                                                        <option value="PF">French Polynesia</option>
                                                        <option value="TF">French Southern Territories</option>
                                                        <option value="GA">Gabon</option>
                                                        <option value="GM">Gambia</option>
                                                        <option value="GE">Georgia</option>
                                                        <option value="DE">Germany</option>
                                                        <option value="GH">Ghana</option>
                                                        <option value="GI">Gibraltar</option>
                                                        <option value="GR">Greece</option>
                                                        <option value="GL">Greenland</option>
                                                        <option value="GD">Grenada</option>
                                                        <option value="GP">Guadeloupe</option>
                                                        <option value="GU">Guam</option>
                                                        <option value="GT">Guatemala</option>
                                                        <option value="GGY">Guernsey</option>
                                                        <option value="GN">Guinea</option>
                                                        <option value="GW">Guinea-Bissau</option>
                                                        <option value="GY">Guyana</option>
                                                        <option value="HT">Haiti</option>
                                                        <option value="HM">Heard and Mc Donald Islands</option>
                                                        <option value="HN">Honduras</option>
                                                        <option value="HK">Hong Kong</option>
                                                        <option value="HU">Hungary</option>
                                                        <option value="IS">Iceland</option>
                                                        <option value="IN">India</option>
                                                        <option value="ID">Indonesia</option>
                                                        <option value="IR">Iran (Islamic Republic of)</option>
                                                        <option value="IQ">Iraq</option>
                                                        <option value="IE">Ireland</option>
                                                        <option value="IM">Isle of Man</option>
                                                        <option value="IL">Israel</option>
                                                        <option value="IT">Italy</option>
                                                        <option value="JM">Jamaica</option>
                                                        <option value="JP">Japan</option>
                                                        <option value="JEY">Jersey</option>
                                                        <option value="JO">Jordan</option>
                                                        <option value="KZ">Kazakhstan</option>
                                                        <option value="KE">Kenya</option>
                                                        <option value="KI">Kiribati</option>
                                                        <option value="KS">Kosovo</option>
                                                        <option value="KW">Kuwait</option>
                                                        <option value="KG">Kyrgyzstan</option>
                                                        <option value="LA">Lao People's Democratic Republic</option>
                                                        <option value="LV">Latvia</option>
                                                        <option value="LB">Lebanon</option>
                                                        <option value="LS">Lesotho</option>
                                                        <option value="LR">Liberia</option>
                                                        <option value="LY">Libya</option>
                                                        <option value="LI">Liechtenstein</option>
                                                        <option value="LT">Lithuania</option>
                                                        <option value="LU">Luxembourg</option>
                                                        <option value="MO">Macau</option>
                                                        <option value="MK">Macedonia</option>
                                                        <option value="MG">Madagascar</option>
                                                        <option value="MW">Malawi</option>
                                                        <option value="MY">Malaysia</option>
                                                        <option value="MV">Maldives</option>
                                                        <option value="ML">Mali</option>
                                                        <option value="MT">Malta</option>
                                                        <option value="MH">Marshall Islands</option>
                                                        <option value="MQ">Martinique</option>
                                                        <option value="MR">Mauritania</option>
                                                        <option value="MU">Mauritius</option>
                                                        <option value="YT">Mayotte</option>
                                                        <option value="MX">Mexico</option>
                                                        <option value="FM">Micronesia</option>
                                                        <option value="MD">Moldova</option>
                                                        <option value="MC">Monaco</option>
                                                        <option value="MN">Mongolia</option>
                                                        <option value="MNE">Montenegro</option>
                                                        <option value="MS">Montserrat</option>
                                                        <option value="MA">Morocco</option>
                                                        <option value="MZ">Mozambique</option>
                                                        <option value="MM">Myanmar</option>
                                                        <option value="NA">Namibia</option>
                                                        <option value="NR">Nauru</option>
                                                        <option value="NP">Nepal</option>
                                                        <option value="NL">Netherlands</option>
                                                        <option value="AN">Netherlands Antilles</option>
                                                        <option value="NC">New Caledonia</option>
                                                        <option value="NZ">New Zealand</option>
                                                        <option value="NI">Nicaragua</option>
                                                        <option value="NE">Niger</option>
                                                        <option value="NG">Nigeria</option>
                                                        <option value="NU">Niue</option>
                                                        <option value="NF">Norfolk Island</option>
                                                        <option value="KP">North Korea</option>
                                                        <option value="MP">Northern Mariana Islands</option>
                                                        <option value="NO">Norway</option>
                                                        <option value="OM">Oman</option>
                                                        <option value="Other">Other Country</option>
                                                        <option value="PK">Pakistan</option>
                                                        <option value="PW">Palau</option>
                                                        <option value="PS">Palestine</option>
                                                        <option value="PA">Panama</option>
                                                        <option value="PG">Papua New Guinea</option>
                                                        <option value="PY">Paraguay</option>
                                                        <option value="PE">Peru</option>
                                                        <option value="PH">Philippines</option>
                                                        <option value="PN">Pitcairn</option>
                                                        <option value="PL">Poland</option>
                                                        <option value="PT">Portugal</option>
                                                        <option value="PR">Puerto Rico</option>
                                                        <option value="QA">Qatar</option>
                                                        <option value="RE">Reunion</option>
                                                        <option value="RO">Romania</option>
                                                        <option value="RU">Russian Federation</option>
                                                        <option value="RW">Rwanda</option>
                                                        <option value="BLM">Saint Barthelemy</option>
                                                        <option value="KN">Saint Kitts and Nevis</option>
                                                        <option value="LC">Saint Lucia</option>
                                                        <option value="MAF">Saint Martin</option>
                                                        <option value="VC">Saint Vincent and the Grenadines</option>
                                                        <option value="WS">Samoa</option>
                                                        <option value="SM">San Marino</option>
                                                        <option value="ST">Sao Tome and Principe</option>
                                                        <option value="SA">Saudi Arabia</option>
                                                        <option value="SCT">Scotland</option>
                                                        <option value="SN">Senegal</option>
                                                        <option value="SRB">Serbia</option>
                                                        <option value="SC">Seychelles</option>
                                                        <option value="SL">Sierra Leone</option>
                                                        <option value="SG">Singapore</option>
                                                        <option value="SK">Slovakia (Slovak Republic)</option>
                                                        <option value="SI">Slovenia</option>
                                                        <option value="SB">Solomon Islands</option>
                                                        <option value="SO">Somalia</option>
                                                        <option value="ZA">South Africa</option>
                                                        <option value="SGS">South Georgia and the South Sandwich Islands</option>
                                                        <option value="KR">South Korea</option>
                                                        <option value="SS">South Sudan</option>
                                                        <option value="ES">Spain</option>
                                                        <option value="LK">Sri Lanka</option>
                                                        <option value="SH">St. Helena</option>
                                                        <option value="PM">St. Pierre and Miquelon</option>
                                                        <option value="SD">Sudan</option>
                                                        <option value="SR">Suriname</option>
                                                        <option value="SJ">Svalbard and Jan Mayen Islands</option>
                                                        <option value="SZ">Swaziland</option>
                                                        <option value="SE">Sweden</option>
                                                        <option value="CH">Switzerland</option>
                                                        <option value="SY">Syrian Arab Republic</option>
                                                        <option value="TW">Taiwan</option>
                                                        <option value="TJ">Tajikistan</option>
                                                        <option value="TZ">Tanzania</option>
                                                        <option value="TH">Thailand</option>
                                                        <option value="TLS">Timor-Leste</option>
                                                        <option value="TG">Togo</option>
                                                        <option value="TK">Tokelau</option>
                                                        <option value="TO">Tonga</option>
                                                        <option value="TT">Trinidad and Tobago</option>
                                                        <option value="TN">Tunisia</option>
                                                        <option value="TR">Turkey</option>
                                                        <option value="TM">Turkmenistan</option>
                                                        <option value="TC">Turks and Caicos Islands</option>
                                                        <option value="TV">Tuvalu</option>
                                                        <option value="UG">Uganda</option>
                                                        <option value="UA">Ukraine</option>
                                                        <option value="AE">United Arab Emirates</option>
                                                        <option value="UK">United Kingdom</option>
                                                        <option value="US">United States</option>
                                                        <option value="UM">United States Minor Outlying Islands</option>
                                                        <option value="UY">Uruguay</option>
                                                        <option value="UZ">Uzbekistan</option>
                                                        <option value="VU">Vanuatu</option>
                                                        <option value="VA">Vatican City State (Holy See)</option>
                                                        <option value="VE">Venezuela</option>
                                                        <option value="VN">Vietnam</option>
                                                        <option value="VG">Virgin Islands (British)</option>
                                                        <option value="VI">Virgin Islands (U.S.)</option>
                                                        <option value="WF">Wallis And Futuna Islands</option>
                                                        <option value="EH">Western Sahara</option>
                                                        <option value="YE">Yemen</option>
                                                        <option value="YU">Yugoslavia</option>
                                                        <option value="ZM">Zambia</option>
                                                        <option value="EAZ">Zanzibar</option>
                                                        <option value="ZW">Zimbabwe</option>
                                                        <option value="CW">Curacao</option>
                                                        <option value="SX">Sint Maarten</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label ">Province/State/County:</label>
                                                <div class="col-sm-8">
                                                    <input type="text" name="provience_state" class="form-control" placeholder="">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label ">City:</label>
                                                <div class="col-sm-8">
                                                    <input type="text" name="city" class="form-control" placeholder="">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label ">Street Address:</label>
                                                <div class="col-sm-8">
                                                    <input type="text" name="street_address" class="form-control" placeholder="">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label ">Telephone:</label>
                                                <div class="col-sm-2">
                                                    <input type="text" name="telephone" class="form-control" placeholder="country code">
                                                </div>
                                                <div class="col-sm-2">
                                                    <input type="text" name="area_code" class="form-control" placeholder="area code">
                                                </div>
                                                <div class="col-sm-2">
                                                    <input type="text" name="phone_number" class="form-control" placeholder="phonr number">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label ">Duties:</label>
                                                <div class="col-sm-8">
                                                    <select name="duties" class="form-control">
                                                        <option value="">Please select:</option>
                                                        <option value="2021">Sale</option>
                                                        <option value="2020">After sale Service</option>
                                                        <option value="2019">Other</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label ">Person-in-Charge:</label>
                                                <div class="col-sm-8">
                                                    <input type="text" name="person_charge" class="form-control" placeholder="">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label ">Number of Staff:</label>
                                                <div class="col-sm-8">
                                                    <input type="text" name="number_staff" class="form-control" placeholder="">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label">Property Ownership/Lease Certifications:</label>
                                                <div class="col-sm-8">
                                                    <input type="file" name="property_ownership" class="form-control">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label">Office Photos:</label>
                                                <div class="col-sm-8">
                                                    <input type="file" name="office_photos" class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-1">
                                            <div class="clone-leftside-btn-2 cloneya-wrap">
                                                <div class="unit toclone-widget-left toclone cloneya cloneya1">
                                                    <button type="button" class="btn btn-default clone-btn-left delete" id="delete6">
                                                    -
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label">Accepted Delivery Terms:</label>
                                        <div class="col-sm-9 row">
                                            <div class="col-md-3 col-sm-3">
                                                <div class="border-checkbox-group border-checkbox-group-primary">
                                                    <input class="border-checkbox" type="checkbox" id="checkbox1">
                                                    <label class="border-checkbox-label" for="checkbox1">Primary</label>
                                                </div>
                                                <div class="border-checkbox-group border-checkbox-group-primary">
                                                    <input class="border-checkbox" type="checkbox" id="checkbox1">
                                                    <label class="border-checkbox-label" for="checkbox1">Primary</label>
                                                </div>
                                                <div class="border-checkbox-group border-checkbox-group-primary">
                                                    <input class="border-checkbox" type="checkbox" id="checkbox1">
                                                    <label class="border-checkbox-label" for="checkbox1">Primary</label>
                                                </div>
                                            </div>
                                            <div class="col-md-3 col-sm-3">
                                                <div class="border-checkbox-group border-checkbox-group-primary">
                                                    <input class="border-checkbox" type="checkbox" id="checkbox1">
                                                    <label class="border-checkbox-label" for="checkbox1">Primary</label>
                                                </div>
                                                <div class="border-checkbox-group border-checkbox-group-primary">
                                                    <input class="border-checkbox" type="checkbox" id="checkbox1">
                                                    <label class="border-checkbox-label" for="checkbox1">Primary</label>
                                                </div>
                                                <div class="border-checkbox-group border-checkbox-group-primary">
                                                    <input class="border-checkbox" type="checkbox" id="checkbox1">
                                                    <label class="border-checkbox-label" for="checkbox1">Primary</label>
                                                </div>
                                            </div>
                                            <div class="col-md-3 col-sm-3">
                                                <div class="border-checkbox-group border-checkbox-group-primary">
                                                    <input class="border-checkbox" type="checkbox" id="checkbox1">
                                                    <label class="border-checkbox-label" for="checkbox1">Primary</label>
                                                </div>
                                                <div class="border-checkbox-group border-checkbox-group-primary">
                                                    <input class="border-checkbox" type="checkbox" id="checkbox1">
                                                    <label class="border-checkbox-label" for="checkbox1">Primary</label>
                                                </div>
                                                <div class="border-checkbox-group border-checkbox-group-primary">
                                                    <input class="border-checkbox" type="checkbox" id="checkbox1">
                                                    <label class="border-checkbox-label" for="checkbox1">Primary</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label">Accepted Payment Currency:</label>
                                        <div class="col-sm-9 row">
                                            <div class="col-md-3 col-sm-3">
                                                <div class="border-checkbox-group border-checkbox-group-primary">
                                                    <input class="border-checkbox" type="checkbox" id="checkbox1">
                                                    <label class="border-checkbox-label" for="checkbox1">Primary</label>
                                                </div>
                                                <div class="border-checkbox-group border-checkbox-group-primary">
                                                    <input class="border-checkbox" type="checkbox" id="checkbox1">
                                                    <label class="border-checkbox-label" for="checkbox1">Primary</label>
                                                </div>
                                                <div class="border-checkbox-group border-checkbox-group-primary">
                                                    <input class="border-checkbox" type="checkbox" id="checkbox1">
                                                    <label class="border-checkbox-label" for="checkbox1">Primary</label>
                                                </div>
                                            </div>
                                            <div class="col-md-3 col-sm-3">
                                                <div class="border-checkbox-group border-checkbox-group-primary">
                                                    <input class="border-checkbox" type="checkbox" id="checkbox1">
                                                    <label class="border-checkbox-label" for="checkbox1">Primary</label>
                                                </div>
                                                <div class="border-checkbox-group border-checkbox-group-primary">
                                                    <input class="border-checkbox" type="checkbox" id="checkbox1">
                                                    <label class="border-checkbox-label" for="checkbox1">Primary</label>
                                                </div>
                                                <div class="border-checkbox-group border-checkbox-group-primary">
                                                    <input class="border-checkbox" type="checkbox" id="checkbox1">
                                                    <label class="border-checkbox-label" for="checkbox1">Primary</label>
                                                </div>
                                            </div>
                                            <div class="col-md-3 col-sm-3">
                                                <div class="border-checkbox-group border-checkbox-group-primary">
                                                    <input class="border-checkbox" type="checkbox" id="checkbox1">
                                                    <label class="border-checkbox-label" for="checkbox1">Primary</label>
                                                </div>
                                                <div class="border-checkbox-group border-checkbox-group-primary">
                                                    <input class="border-checkbox" type="checkbox" id="checkbox1">
                                                    <label class="border-checkbox-label" for="checkbox1">Primary</label>
                                                </div>
                                                <div class="border-checkbox-group border-checkbox-group-primary">
                                                    <input class="border-checkbox" type="checkbox" id="checkbox1">
                                                    <label class="border-checkbox-label" for="checkbox1">Primary</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label">Accepted Payment Type:</label>
                                        <div class="col-sm-9 row">
                                            <div class="col-md-3 col-sm-3">
                                                <div class="border-checkbox-group border-checkbox-group-primary">
                                                    <input class="border-checkbox" type="checkbox" id="checkbox1">
                                                    <label class="border-checkbox-label" for="checkbox1">Primary</label>
                                                </div>
                                                <div class="border-checkbox-group border-checkbox-group-primary">
                                                    <input class="border-checkbox" type="checkbox" id="checkbox1">
                                                    <label class="border-checkbox-label" for="checkbox1">Primary</label>
                                                </div>
                                                <div class="border-checkbox-group border-checkbox-group-primary">
                                                    <input class="border-checkbox" type="checkbox" id="checkbox1">
                                                    <label class="border-checkbox-label" for="checkbox1">Primary</label>
                                                </div>
                                            </div>
                                            <div class="col-md-3 col-sm-3">
                                                <div class="border-checkbox-group border-checkbox-group-primary">
                                                    <input class="border-checkbox" type="checkbox" id="checkbox1">
                                                    <label class="border-checkbox-label" for="checkbox1">Primary</label>
                                                </div>
                                                <div class="border-checkbox-group border-checkbox-group-primary">
                                                    <input class="border-checkbox" type="checkbox" id="checkbox1">
                                                    <label class="border-checkbox-label" for="checkbox1">Primary</label>
                                                </div>
                                                <div class="border-checkbox-group border-checkbox-group-primary">
                                                    <input class="border-checkbox" type="checkbox" id="checkbox1">
                                                    <label class="border-checkbox-label" for="checkbox1">Primary</label>
                                                </div>
                                            </div>
                                            <div class="col-md-3 col-sm-3">
                                                <div class="border-checkbox-group border-checkbox-group-primary">
                                                    <input class="border-checkbox" type="checkbox" id="checkbox1">
                                                    <label class="border-checkbox-label" for="checkbox1">Primary</label>
                                                </div>
                                                <div class="border-checkbox-group border-checkbox-group-primary">
                                                    <input class="border-checkbox" type="checkbox" id="checkbox1">
                                                    <label class="border-checkbox-label" for="checkbox1">Primary</label>
                                                </div>
                                                <div class="border-checkbox-group border-checkbox-group-primary">
                                                    <input class="border-checkbox" type="checkbox" id="checkbox1">
                                                    <label class="border-checkbox-label" for="checkbox1">Primary</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label">Language Spoken:</label>
                                        <div class="col-sm-9 row">
                                            <div class="col-md-3 col-sm-3">
                                                <div class="border-checkbox-group border-checkbox-group-primary">
                                                    <input class="border-checkbox" type="checkbox" id="checkbox1">
                                                    <label class="border-checkbox-label" for="checkbox1">Primary</label>
                                                </div>
                                                <div class="border-checkbox-group border-checkbox-group-primary">
                                                    <input class="border-checkbox" type="checkbox" id="checkbox1">
                                                    <label class="border-checkbox-label" for="checkbox1">Primary</label>
                                                </div>
                                                <div class="border-checkbox-group border-checkbox-group-primary">
                                                    <input class="border-checkbox" type="checkbox" id="checkbox1">
                                                    <label class="border-checkbox-label" for="checkbox1">Primary</label>
                                                </div>
                                            </div>
                                            <div class="col-md-3 col-sm-3">
                                                <div class="border-checkbox-group border-checkbox-group-primary">
                                                    <input class="border-checkbox" type="checkbox" id="checkbox1">
                                                    <label class="border-checkbox-label" for="checkbox1">Primary</label>
                                                </div>
                                                <div class="border-checkbox-group border-checkbox-group-primary">
                                                    <input class="border-checkbox" type="checkbox" id="checkbox1">
                                                    <label class="border-checkbox-label" for="checkbox1">Primary</label>
                                                </div>
                                                <div class="border-checkbox-group border-checkbox-group-primary">
                                                    <input class="border-checkbox" type="checkbox" id="checkbox1">
                                                    <label class="border-checkbox-label" for="checkbox1">Primary</label>
                                                </div>
                                            </div>
                                            <div class="col-md-3 col-sm-3">
                                                <div class="border-checkbox-group border-checkbox-group-primary">
                                                    <input class="border-checkbox" type="checkbox" id="checkbox1">
                                                    <label class="border-checkbox-label" for="checkbox1">Primary</label>
                                                </div>
                                                <div class="border-checkbox-group border-checkbox-group-primary">
                                                    <input class="border-checkbox" type="checkbox" id="checkbox1">
                                                    <label class="border-checkbox-label" for="checkbox1">Primary</label>
                                                </div>
                                                <div class="border-checkbox-group border-checkbox-group-primary">
                                                    <input class="border-checkbox" type="checkbox" id="checkbox1">
                                                    <label class="border-checkbox-label" for="checkbox1">Primary</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane" id="seller" role="tabpanel">
                                    <div class="row" id="">
                                        <div class="col-md-2"></div>
                                        <div class="col-md-7 col-sm-7 col-xs-12 bd1px" >
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label">Company Logo:</label>
                                                <div class="col-sm-8">
                                                    <input type="file" name="company_logo" class="form-control">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label">Detailed Company Introduction:</label>
                                                <div class="col-sm-8">																<textarea type="text" name="company_detailed" cols="5" id="comp_advantages" class="form-control" placeholder="Detailed Company "></textarea>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label">Company Photo:</label>
                                                <div class="col-sm-8">
                                                    <input type="file" name="company_photo" class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label">Have you attended or planned to attend any trade shows ?</label>
                                        <div class="col-sm-10">
                                            <select name="have_you_attended" class="form-control" id="attend_trend">
                                                <option value="NO">NO</option>
                                                <option value="YES">YES</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row" id="comp_panel">
                                        <div class="col-md-2"></div>
                                        <div class="col-md-7 col-sm-7 col-xs-12 bd1px" >
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label ">Trade Show Name:</label>
                                                <div class="col-sm-8">
                                                    <input type="text" name="trade_show" class="form-control" placeholder="">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label ">Date Attended:</label>
                                                <div class="col-sm-4">
                                                    <select name="date_attended" class="form-control">
                                                        <option value="">Year:</option>
                                                        <option value="2021">2021</option>
                                                        <option value="2020">2020</option>
                                                        <option value="2019">2019</option>
                                                        <option value="2018">2018</option>
                                                        <option value="2017">2017</option>
                                                        <option value="2016">2016</option>
                                                        <option value="2015">2015</option>
                                                        <option value="2014">2014</option>
                                                        <option value="2013">2013</option>
                                                        <option value="2012">2012</option>
                                                        <option value="2011">2011</option>
                                                        <option value="2010">2010</option>
                                                        <option value="2009">2009</option>
                                                        <option value="2008">2008</option>
                                                        <option value="2007">2007</option>
                                                        <option value="2006">2006</option>
                                                        <option value="2005">2005</option>
                                                        <option value="2004">2004</option>
                                                        <option value="2003">2003</option>
                                                        <option value="2002">2002</option>
                                                        <option value="2001">2001</option>
                                                        <option value="2000">2000</option>
                                                        <option value="1999">1999</option>
                                                        <option value="1998">1998</option>
                                                        <option value="1997">1997</option>
                                                        <option value="1996">1996</option>
                                                        <option value="1995">1995</option>
                                                        <option value="1994">1994</option>
                                                        <option value="1993">1993</option>
                                                        <option value="1992">1992</option>
                                                        <option value="1991">1991</option>
                                                        <option value="1990">1990</option>
                                                        <option value="1989">1989</option>
                                                        <option value="1988">1988</option>
                                                        <option value="1987">1987</option>
                                                        <option value="1986">1986</option>
                                                        <option value="1985">1985</option>
                                                        <option value="1984">1984</option>
                                                        <option value="1983">1983</option>
                                                        <option value="1982">1982</option>
                                                        <option value="1981">1981</option>
                                                        <option value="1980">1980</option>
                                                        <option value="1979">1979</option>
                                                        <option value="1978">1978</option>
                                                        <option value="1977">1977</option>
                                                        <option value="1976">1976</option>
                                                        <option value="1975">1975</option>
                                                        <option value="1974">1974</option>
                                                        <option value="1973">1973</option>
                                                        <option value="1972">1972</option>
                                                        <option value="1971">1971</option>
                                                        <option value="1970">1970</option>
                                                        <option value="1969">1969</option>
                                                        <option value="1968">1968</option>
                                                        <option value="1967">1967</option>
                                                        <option value="1966">1966</option>
                                                        <option value="1965">1965</option>
                                                        <option value="1964">1964</option>
                                                        <option value="1963">1963</option>
                                                        <option value="1962">1962</option>
                                                        <option value="1961">1961</option>
                                                        <option value="1960">1960</option>
                                                        <option value="1959">1959</option>
                                                        <option value="1958">1958</option>
                                                        <option value="1957">1957</option>
                                                        <option value="1956">1956</option>
                                                        <option value="1955">1955</option>
                                                        <option value="1954">1954</option>
                                                        <option value="1953">1953</option>
                                                        <option value="1952">1952</option>
                                                        <option value="1951">1951</option>
                                                        <option value="1950">1950</option>
                                                        <option value="1949">1949</option>
                                                        <option value="1948">1948</option>
                                                        <option value="1947">1947</option>
                                                        <option value="1946">1946</option>
                                                        <option value="1945">1945</option>
                                                        <option value="1944">1944</option>
                                                        <option value="1943">1943</option>
                                                        <option value="1942">1942</option>
                                                        <option value="1941">1941</option>
                                                        <option value="1940">1940</option>
                                                        <option value="1939">1939</option>
                                                        <option value="1938">1938</option>
                                                        <option value="1937">1937</option>
                                                        <option value="1936">1936</option>
                                                        <option value="1935">1935</option>
                                                        <option value="1934">1934</option>
                                                        <option value="1933">1933</option>
                                                        <option value="1932">1932</option>
                                                        <option value="1931">1931</option>
                                                        <option value="1930">1930</option>
                                                        <option value="1929">1929</option>
                                                        <option value="1928">1928</option>
                                                        <option value="1927">1927</option>
                                                        <option value="1926">1926</option>
                                                        <option value="1925">1925</option>
                                                        <option value="1924">1924</option>
                                                        <option value="1923">1923</option>
                                                        <option value="1922">1922</option>
                                                        <option value="1921">1921</option>
                                                        <option value="1920">1920</option>
                                                        <option value="1919">1919</option>
                                                        <option value="1918">1918</option>
                                                        <option value="1917">1917</option>
                                                        <option value="1916">1916</option>
                                                        <option value="1915">1915</option>
                                                        <option value="1914">1914</option>
                                                        <option value="1913">1913</option>
                                                        <option value="1912">1912</option>
                                                        <option value="1911">1911</option>
                                                        <option value="1910">1910</option>
                                                        <option value="1909">1909</option>
                                                        <option value="1908">1908</option>
                                                        <option value="1907">1907</option>
                                                        <option value="1906">1906</option>
                                                        <option value="1905">1905</option>
                                                        <option value="1904">1904</option>
                                                        <option value="1903">1903</option>
                                                        <option value="1902">1902</option>
                                                        <option value="1901">1901</option>
                                                        <option value="1900">1900</option>
                                                        <option value="1899">1899</option>
                                                        <option value="1898">1898</option>
                                                        <option value="1897">1897</option>
                                                        <option value="1896">1896</option>
                                                        <option value="1895">1895</option>
                                                        <option value="1894">1894</option>
                                                        <option value="1893">1893</option>
                                                        <option value="1892">1892</option>
                                                        <option value="1891">1891</option>
                                                        <option value="1890">1890</option>
                                                        <option value="1889">1889</option>
                                                        <option value="1888">1888</option>
                                                        <option value="1887">1887</option>
                                                        <option value="1886">1886</option>
                                                        <option value="1885">1885</option>
                                                        <option value="1884">1884</option>
                                                        <option value="1883">1883</option>
                                                        <option value="1882">1882</option>
                                                        <option value="1881">1881</option>
                                                        <option value="1880">1880</option>
                                                        <option value="1879">1879</option>
                                                        <option value="1878">1878</option>
                                                        <option value="1877">1877</option>
                                                        <option value="1876">1876</option>
                                                        <option value="1875">1875</option>
                                                        <option value="1874">1874</option>
                                                        <option value="1873">1873</option>
                                                        <option value="1872">1872</option>
                                                        <option value="1871">1871</option>
                                                        <option value="1870">1870</option>
                                                        <option value="1869">1869</option>
                                                        <option value="1868">1868</option>
                                                        <option value="1867">1867</option>
                                                        <option value="1866">1866</option>
                                                        <option value="1865">1865</option>
                                                        <option value="1864">1864</option>
                                                        <option value="1863">1863</option>
                                                        <option value="1862">1862</option>
                                                        <option value="1861">1861</option>
                                                        <option value="1860">1860</option>
                                                        <option value="1859">1859</option>
                                                        <option value="1858">1858</option>
                                                        <option value="1857">1857</option>
                                                        <option value="1856">1856</option>
                                                        <option value="1855">1855</option>
                                                        <option value="1854">1854</option>
                                                        <option value="1853">1853</option>
                                                        <option value="1852">1852</option>
                                                        <option value="1851">1851</option>
                                                        <option value="1850">1850</option>
                                                        <option value="1849">1849</option>
                                                        <option value="1848">1848</option>
                                                        <option value="1847">1847</option>
                                                        <option value="1846">1846</option>
                                                        <option value="1845">1845</option>
                                                        <option value="1844">1844</option>
                                                        <option value="1843">1843</option>
                                                        <option value="1842">1842</option>
                                                        <option value="1841">1841</option>
                                                        <option value="1840">1840</option>
                                                        <option value="1839">1839</option>
                                                        <option value="1838">1838</option>
                                                        <option value="1837">1837</option>
                                                        <option value="1836">1836</option>
                                                        <option value="1835">1835</option>
                                                        <option value="1834">1834</option>
                                                        <option value="1833">1833</option>
                                                        <option value="1832">1832</option>
                                                        <option value="1831">1831</option>
                                                        <option value="1830">1830</option>
                                                        <option value="1829">1829</option>
                                                        <option value="1828">1828</option>
                                                        <option value="1827">1827</option>
                                                        <option value="1826">1826</option>
                                                        <option value="1825">1825</option>
                                                        <option value="1824">1824</option>
                                                        <option value="1823">1823</option>
                                                        <option value="1822">1822</option>
                                                        <option value="1821">1821</option>
                                                        <option value="1820">1820</option>
                                                        <option value="1819">1819</option>
                                                        <option value="1818">1818</option>
                                                        <option value="1817">1817</option>
                                                        <option value="1816">1816</option>
                                                        <option value="1815">1815</option>
                                                        <option value="1814">1814</option>
                                                        <option value="1813">1813</option>
                                                        <option value="1812">1812</option>
                                                        <option value="1811">1811</option>
                                                        <option value="1810">1810</option>
                                                        <option value="1809">1809</option>
                                                        <option value="1808">1808</option>
                                                        <option value="1807">1807</option>
                                                        <option value="1806">1806</option>
                                                        <option value="1805">1805</option>
                                                        <option value="1804">1804</option>
                                                        <option value="1803">1803</option>
                                                        <option value="1802">1802</option>
                                                        <option value="1801">1801</option>
                                                        <option value="1800">1800</option>
                                                    </select>
                                                </div>
                                                <div class="col-sm-4">
                                                    <select name="month" class="form-control">
                                                        <option value="">Month:</option>
                                                        <option value="1">1</option>
                                                        <option value="2">2</option>
                                                        <option value="3">3</option>
                                                        <option value="4">4</option>
                                                        <option value="5">5</option>
                                                        <option value="6">6</option>
                                                        <option value="7">7</option>
                                                        <option value="8">8</option>
                                                        <option value="9">9</option>
                                                        <option value="10">10</option>
                                                        <option value="11">11</option>
                                                        <option value="12">12</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label ">Host Country/Region:</label>
                                                <div class="col-sm-8">
                                                    <select name="country_region" class="form-control">
                                                        <option value="">--please select--</option>
                                                        <option value="AF">Afghanistan</option>
                                                        <option value="ALA">Aland Islands</option>
                                                        <option value="AL">Albania</option>
                                                        <option value="GBA">Alderney</option>
                                                        <option value="DZ">Algeria</option>
                                                        <option value="AS">American Samoa</option>
                                                        <option value="AD">Andorra</option>
                                                        <option value="AO">Angola</option>
                                                        <option value="AI">Anguilla</option>
                                                        <option value="AQ">Antarctica</option>
                                                        <option value="AG">Antigua and Barbuda</option>
                                                        <option value="AR">Argentina</option>
                                                        <option value="AM">Armenia</option>
                                                        <option value="AW">Aruba</option>
                                                        <option value="ASC">Ascension Island</option>
                                                        <option value="AU">Australia</option>
                                                        <option value="AT">Austria</option>
                                                        <option value="AZ">Azerbaijan</option>
                                                        <option value="BS">Bahamas</option>
                                                        <option value="BH">Bahrain</option>
                                                        <option value="BD">Bangladesh</option>
                                                        <option value="BB">Barbados</option>
                                                        <option value="BY">Belarus</option>
                                                        <option value="BE">Belgium</option>
                                                        <option value="BZ">Belize</option>
                                                        <option value="BJ">Benin</option>
                                                        <option value="BM">Bermuda</option>
                                                        <option value="BT">Bhutan</option>
                                                        <option value="BO">Bolivia</option>
                                                        <option value="BA">Bosnia and Herzegovina</option>
                                                        <option value="BW">Botswana</option>
                                                        <option value="BV">Bouvet Island</option>
                                                        <option value="BR">Brazil</option>
                                                        <option value="IO">British Indian Ocean Territory</option>
                                                        <option value="BN">Brunei Darussalam</option>
                                                        <option value="BG">Bulgaria</option>
                                                        <option value="BF">Burkina Faso</option>
                                                        <option value="BI">Burundi</option>
                                                        <option value="KH">Cambodia</option>
                                                        <option value="CM">Cameroon</option>
                                                        <option value="CA">Canada</option>
                                                        <option value="CV">Cape Verde</option>
                                                        <option value="KY">Cayman Islands</option>
                                                        <option value="CF">Central African Republic</option>
                                                        <option value="TD">Chad</option>
                                                        <option value="CL">Chile</option>
                                                        <option value="CN">China (Mainland)</option>
                                                        <option value="CX">Christmas Island</option>
                                                        <option value="CC">Cocos (Keeling) Islands</option>
                                                        <option value="CO">Colombia</option>
                                                        <option value="KM">Comoros</option>
                                                        <option value="ZR">Congo, The Democratic Republic Of The</option>
                                                        <option value="CG">Congo, The Republic of Congo</option>
                                                        <option value="CK">Cook Islands</option>
                                                        <option value="CR">Costa Rica</option>
                                                        <option value="CI">Cote D'Ivoire</option>
                                                        <option value="HR">Croatia (local name: Hrvatska)</option>
                                                        <option value="CU">Cuba</option>
                                                        <option value="CY">Cyprus</option>
                                                        <option value="CZ">Czech Republic</option>
                                                        <option value="DK">Denmark</option>
                                                        <option value="DJ">Djibouti</option>
                                                        <option value="DM">Dominica</option>
                                                        <option value="DO">Dominican Republic</option>
                                                        <option value="TP">East Timor</option>
                                                        <option value="EC">Ecuador</option>
                                                        <option value="EG">Egypt</option>
                                                        <option value="SV">El Salvador</option>
                                                        <option value="GQ">Equatorial Guinea</option>
                                                        <option value="ER">Eritrea</option>
                                                        <option value="EE">Estonia</option>
                                                        <option value="ET">Ethiopia</option>
                                                        <option value="FK">Falkland Islands (Malvinas)</option>
                                                        <option value="FO">Faroe Islands</option>
                                                        <option value="FJ">Fiji</option>
                                                        <option value="FI">Finland</option>
                                                        <option value="FR">France</option>
                                                        <option value="FX">France Metropolitan</option>
                                                        <option value="GF">French Guiana</option>
                                                        <option value="PF">French Polynesia</option>
                                                        <option value="TF">French Southern Territories</option>
                                                        <option value="GA">Gabon</option>
                                                        <option value="GM">Gambia</option>
                                                        <option value="GE">Georgia</option>
                                                        <option value="DE">Germany</option>
                                                        <option value="GH">Ghana</option>
                                                        <option value="GI">Gibraltar</option>
                                                        <option value="GR">Greece</option>
                                                        <option value="GL">Greenland</option>
                                                        <option value="GD">Grenada</option>
                                                        <option value="GP">Guadeloupe</option>
                                                        <option value="GU">Guam</option>
                                                        <option value="GT">Guatemala</option>
                                                        <option value="GGY">Guernsey</option>
                                                        <option value="GN">Guinea</option>
                                                        <option value="GW">Guinea-Bissau</option>
                                                        <option value="GY">Guyana</option>
                                                        <option value="HT">Haiti</option>
                                                        <option value="HM">Heard and Mc Donald Islands</option>
                                                        <option value="HN">Honduras</option>
                                                        <option value="HK">Hong Kong</option>
                                                        <option value="HU">Hungary</option>
                                                        <option value="IS">Iceland</option>
                                                        <option value="IN">India</option>
                                                        <option value="ID">Indonesia</option>
                                                        <option value="IR">Iran (Islamic Republic of)</option>
                                                        <option value="IQ">Iraq</option>
                                                        <option value="IE">Ireland</option>
                                                        <option value="IM">Isle of Man</option>
                                                        <option value="IL">Israel</option>
                                                        <option value="IT">Italy</option>
                                                        <option value="JM">Jamaica</option>
                                                        <option value="JP">Japan</option>
                                                        <option value="JEY">Jersey</option>
                                                        <option value="JO">Jordan</option>
                                                        <option value="KZ">Kazakhstan</option>
                                                        <option value="KE">Kenya</option>
                                                        <option value="KI">Kiribati</option>
                                                        <option value="KS">Kosovo</option>
                                                        <option value="KW">Kuwait</option>
                                                        <option value="KG">Kyrgyzstan</option>
                                                        <option value="LA">Lao People's Democratic Republic</option>
                                                        <option value="LV">Latvia</option>
                                                        <option value="LB">Lebanon</option>
                                                        <option value="LS">Lesotho</option>
                                                        <option value="LR">Liberia</option>
                                                        <option value="LY">Libya</option>
                                                        <option value="LI">Liechtenstein</option>
                                                        <option value="LT">Lithuania</option>
                                                        <option value="LU">Luxembourg</option>
                                                        <option value="MO">Macau</option>
                                                        <option value="MK">Macedonia</option>
                                                        <option value="MG">Madagascar</option>
                                                        <option value="MW">Malawi</option>
                                                        <option value="MY">Malaysia</option>
                                                        <option value="MV">Maldives</option>
                                                        <option value="ML">Mali</option>
                                                        <option value="MT">Malta</option>
                                                        <option value="MH">Marshall Islands</option>
                                                        <option value="MQ">Martinique</option>
                                                        <option value="MR">Mauritania</option>
                                                        <option value="MU">Mauritius</option>
                                                        <option value="YT">Mayotte</option>
                                                        <option value="MX">Mexico</option>
                                                        <option value="FM">Micronesia</option>
                                                        <option value="MD">Moldova</option>
                                                        <option value="MC">Monaco</option>
                                                        <option value="MN">Mongolia</option>
                                                        <option value="MNE">Montenegro</option>
                                                        <option value="MS">Montserrat</option>
                                                        <option value="MA">Morocco</option>
                                                        <option value="MZ">Mozambique</option>
                                                        <option value="MM">Myanmar</option>
                                                        <option value="NA">Namibia</option>
                                                        <option value="NR">Nauru</option>
                                                        <option value="NP">Nepal</option>
                                                        <option value="NL">Netherlands</option>
                                                        <option value="AN">Netherlands Antilles</option>
                                                        <option value="NC">New Caledonia</option>
                                                        <option value="NZ">New Zealand</option>
                                                        <option value="NI">Nicaragua</option>
                                                        <option value="NE">Niger</option>
                                                        <option value="NG">Nigeria</option>
                                                        <option value="NU">Niue</option>
                                                        <option value="NF">Norfolk Island</option>
                                                        <option value="KP">North Korea</option>
                                                        <option value="MP">Northern Mariana Islands</option>
                                                        <option value="NO">Norway</option>
                                                        <option value="OM">Oman</option>
                                                        <option value="Other">Other Country</option>
                                                        <option value="PK">Pakistan</option>
                                                        <option value="PW">Palau</option>
                                                        <option value="PS">Palestine</option>
                                                        <option value="PA">Panama</option>
                                                        <option value="PG">Papua New Guinea</option>
                                                        <option value="PY">Paraguay</option>
                                                        <option value="PE">Peru</option>
                                                        <option value="PH">Philippines</option>
                                                        <option value="PN">Pitcairn</option>
                                                        <option value="PL">Poland</option>
                                                        <option value="PT">Portugal</option>
                                                        <option value="PR">Puerto Rico</option>
                                                        <option value="QA">Qatar</option>
                                                        <option value="RE">Reunion</option>
                                                        <option value="RO">Romania</option>
                                                        <option value="RU">Russian Federation</option>
                                                        <option value="RW">Rwanda</option>
                                                        <option value="BLM">Saint Barthelemy</option>
                                                        <option value="KN">Saint Kitts and Nevis</option>
                                                        <option value="LC">Saint Lucia</option>
                                                        <option value="MAF">Saint Martin</option>
                                                        <option value="VC">Saint Vincent and the Grenadines</option>
                                                        <option value="WS">Samoa</option>
                                                        <option value="SM">San Marino</option>
                                                        <option value="ST">Sao Tome and Principe</option>
                                                        <option value="SA">Saudi Arabia</option>
                                                        <option value="SCT">Scotland</option>
                                                        <option value="SN">Senegal</option>
                                                        <option value="SRB">Serbia</option>
                                                        <option value="SC">Seychelles</option>
                                                        <option value="SL">Sierra Leone</option>
                                                        <option value="SG">Singapore</option>
                                                        <option value="SK">Slovakia (Slovak Republic)</option>
                                                        <option value="SI">Slovenia</option>
                                                        <option value="SB">Solomon Islands</option>
                                                        <option value="SO">Somalia</option>
                                                        <option value="ZA">South Africa</option>
                                                        <option value="SGS">South Georgia and the South Sandwich Islands</option>
                                                        <option value="KR">South Korea</option>
                                                        <option value="SS">South Sudan</option>
                                                        <option value="ES">Spain</option>
                                                        <option value="LK">Sri Lanka</option>
                                                        <option value="SH">St. Helena</option>
                                                        <option value="PM">St. Pierre and Miquelon</option>
                                                        <option value="SD">Sudan</option>
                                                        <option value="SR">Suriname</option>
                                                        <option value="SJ">Svalbard and Jan Mayen Islands</option>
                                                        <option value="SZ">Swaziland</option>
                                                        <option value="SE">Sweden</option>
                                                        <option value="CH">Switzerland</option>
                                                        <option value="SY">Syrian Arab Republic</option>
                                                        <option value="TW">Taiwan</option>
                                                        <option value="TJ">Tajikistan</option>
                                                        <option value="TZ">Tanzania</option>
                                                        <option value="TH">Thailand</option>
                                                        <option value="TLS">Timor-Leste</option>
                                                        <option value="TG">Togo</option>
                                                        <option value="TK">Tokelau</option>
                                                        <option value="TO">Tonga</option>
                                                        <option value="TT">Trinidad and Tobago</option>
                                                        <option value="TN">Tunisia</option>
                                                        <option value="TR">Turkey</option>
                                                        <option value="TM">Turkmenistan</option>
                                                        <option value="TC">Turks and Caicos Islands</option>
                                                        <option value="TV">Tuvalu</option>
                                                        <option value="UG">Uganda</option>
                                                        <option value="UA">Ukraine</option>
                                                        <option value="AE">United Arab Emirates</option>
                                                        <option value="UK">United Kingdom</option>
                                                        <option value="US">United States</option>
                                                        <option value="UM">United States Minor Outlying Islands</option>
                                                        <option value="UY">Uruguay</option>
                                                        <option value="UZ">Uzbekistan</option>
                                                        <option value="VU">Vanuatu</option>
                                                        <option value="VA">Vatican City State (Holy See)</option>
                                                        <option value="VE">Venezuela</option>
                                                        <option value="VN">Vietnam</option>
                                                        <option value="VG">Virgin Islands (British)</option>
                                                        <option value="VI">Virgin Islands (U.S.)</option>
                                                        <option value="WF">Wallis And Futuna Islands</option>
                                                        <option value="EH">Western Sahara</option>
                                                        <option value="YE">Yemen</option>
                                                        <option value="YU">Yugoslavia</option>
                                                        <option value="ZM">Zambia</option>
                                                        <option value="EAZ">Zanzibar</option>
                                                        <option value="ZW">Zimbabwe</option>
                                                        <option value="CW">Curacao</option>
                                                        <option value="SX">Sint Maarten</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label ">Trade Show Introduction:</label>
                                                <div class="col-sm-8">
                                                    <textarea type="text" name="trade_show" cols="5" id="comp_advantages" class="form-control" placeholder="Product Price"></textarea>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label">Trade Show Photo:</label>
                                                <div class="col-sm-8">
                                                    <input type="file" name="trade_show_photo" class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-1">
                                            <div class="clone-leftside-btn-2 cloneya-wrap">
                                                <div class="unit toclone-widget-left toclone cloneya">
                                                    <button type="button" class="btn btn-primary clone-btn-left clone" id="add_logo">
                                                    +
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row" id="comp_panel_2">
                                        <div class="col-md-2"></div>
                                        <div class="col-md-7 col-sm-7 col-xs-12 bd1px" >
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label ">Trade Show Name:</label>
                                                <div class="col-sm-8">
                                                    <input type="text" name="trade_show_name" class="form-control" placeholder="">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label ">Date Attended:</label>
                                                <div class="col-sm-4">
                                                    <select name="date_attended" class="form-control">
                                                        <option value="">Year:</option>
                                                        <option value="2021">2021</option>
                                                        <option value="2020">2020</option>
                                                        <option value="2019">2019</option>
                                                        <option value="2018">2018</option>
                                                        <option value="2017">2017</option>
                                                        <option value="2016">2016</option>
                                                        <option value="2015">2015</option>
                                                        <option value="2014">2014</option>
                                                        <option value="2013">2013</option>
                                                        <option value="2012">2012</option>
                                                        <option value="2011">2011</option>
                                                        <option value="2010">2010</option>
                                                        <option value="2009">2009</option>
                                                        <option value="2008">2008</option>
                                                        <option value="2007">2007</option>
                                                        <option value="2006">2006</option>
                                                        <option value="2005">2005</option>
                                                        <option value="2004">2004</option>
                                                        <option value="2003">2003</option>
                                                        <option value="2002">2002</option>
                                                        <option value="2001">2001</option>
                                                        <option value="2000">2000</option>
                                                        <option value="1999">1999</option>
                                                        <option value="1998">1998</option>
                                                        <option value="1997">1997</option>
                                                        <option value="1996">1996</option>
                                                        <option value="1995">1995</option>
                                                        <option value="1994">1994</option>
                                                        <option value="1993">1993</option>
                                                        <option value="1992">1992</option>
                                                        <option value="1991">1991</option>
                                                        <option value="1990">1990</option>
                                                        <option value="1989">1989</option>
                                                        <option value="1988">1988</option>
                                                        <option value="1987">1987</option>
                                                        <option value="1986">1986</option>
                                                        <option value="1985">1985</option>
                                                        <option value="1984">1984</option>
                                                        <option value="1983">1983</option>
                                                        <option value="1982">1982</option>
                                                        <option value="1981">1981</option>
                                                        <option value="1980">1980</option>
                                                        <option value="1979">1979</option>
                                                        <option value="1978">1978</option>
                                                        <option value="1977">1977</option>
                                                        <option value="1976">1976</option>
                                                        <option value="1975">1975</option>
                                                        <option value="1974">1974</option>
                                                        <option value="1973">1973</option>
                                                        <option value="1972">1972</option>
                                                        <option value="1971">1971</option>
                                                        <option value="1970">1970</option>
                                                        <option value="1969">1969</option>
                                                        <option value="1968">1968</option>
                                                        <option value="1967">1967</option>
                                                        <option value="1966">1966</option>
                                                        <option value="1965">1965</option>
                                                        <option value="1964">1964</option>
                                                        <option value="1963">1963</option>
                                                        <option value="1962">1962</option>
                                                        <option value="1961">1961</option>
                                                        <option value="1960">1960</option>
                                                        <option value="1959">1959</option>
                                                        <option value="1958">1958</option>
                                                        <option value="1957">1957</option>
                                                        <option value="1956">1956</option>
                                                        <option value="1955">1955</option>
                                                        <option value="1954">1954</option>
                                                        <option value="1953">1953</option>
                                                        <option value="1952">1952</option>
                                                        <option value="1951">1951</option>
                                                        <option value="1950">1950</option>
                                                        <option value="1949">1949</option>
                                                        <option value="1948">1948</option>
                                                        <option value="1947">1947</option>
                                                        <option value="1946">1946</option>
                                                        <option value="1945">1945</option>
                                                        <option value="1944">1944</option>
                                                        <option value="1943">1943</option>
                                                        <option value="1942">1942</option>
                                                        <option value="1941">1941</option>
                                                        <option value="1940">1940</option>
                                                        <option value="1939">1939</option>
                                                        <option value="1938">1938</option>
                                                        <option value="1937">1937</option>
                                                        <option value="1936">1936</option>
                                                        <option value="1935">1935</option>
                                                        <option value="1934">1934</option>
                                                        <option value="1933">1933</option>
                                                        <option value="1932">1932</option>
                                                        <option value="1931">1931</option>
                                                        <option value="1930">1930</option>
                                                        <option value="1929">1929</option>
                                                        <option value="1928">1928</option>
                                                        <option value="1927">1927</option>
                                                        <option value="1926">1926</option>
                                                        <option value="1925">1925</option>
                                                        <option value="1924">1924</option>
                                                        <option value="1923">1923</option>
                                                        <option value="1922">1922</option>
                                                        <option value="1921">1921</option>
                                                        <option value="1920">1920</option>
                                                        <option value="1919">1919</option>
                                                        <option value="1918">1918</option>
                                                        <option value="1917">1917</option>
                                                        <option value="1916">1916</option>
                                                        <option value="1915">1915</option>
                                                        <option value="1914">1914</option>
                                                        <option value="1913">1913</option>
                                                        <option value="1912">1912</option>
                                                        <option value="1911">1911</option>
                                                        <option value="1910">1910</option>
                                                        <option value="1909">1909</option>
                                                        <option value="1908">1908</option>
                                                        <option value="1907">1907</option>
                                                        <option value="1906">1906</option>
                                                        <option value="1905">1905</option>
                                                        <option value="1904">1904</option>
                                                        <option value="1903">1903</option>
                                                        <option value="1902">1902</option>
                                                        <option value="1901">1901</option>
                                                        <option value="1900">1900</option>
                                                        <option value="1899">1899</option>
                                                        <option value="1898">1898</option>
                                                        <option value="1897">1897</option>
                                                        <option value="1896">1896</option>
                                                        <option value="1895">1895</option>
                                                        <option value="1894">1894</option>
                                                        <option value="1893">1893</option>
                                                        <option value="1892">1892</option>
                                                        <option value="1891">1891</option>
                                                        <option value="1890">1890</option>
                                                        <option value="1889">1889</option>
                                                        <option value="1888">1888</option>
                                                        <option value="1887">1887</option>
                                                        <option value="1886">1886</option>
                                                        <option value="1885">1885</option>
                                                        <option value="1884">1884</option>
                                                        <option value="1883">1883</option>
                                                        <option value="1882">1882</option>
                                                        <option value="1881">1881</option>
                                                        <option value="1880">1880</option>
                                                        <option value="1879">1879</option>
                                                        <option value="1878">1878</option>
                                                        <option value="1877">1877</option>
                                                        <option value="1876">1876</option>
                                                        <option value="1875">1875</option>
                                                        <option value="1874">1874</option>
                                                        <option value="1873">1873</option>
                                                        <option value="1872">1872</option>
                                                        <option value="1871">1871</option>
                                                        <option value="1870">1870</option>
                                                        <option value="1869">1869</option>
                                                        <option value="1868">1868</option>
                                                        <option value="1867">1867</option>
                                                        <option value="1866">1866</option>
                                                        <option value="1865">1865</option>
                                                        <option value="1864">1864</option>
                                                        <option value="1863">1863</option>
                                                        <option value="1862">1862</option>
                                                        <option value="1861">1861</option>
                                                        <option value="1860">1860</option>
                                                        <option value="1859">1859</option>
                                                        <option value="1858">1858</option>
                                                        <option value="1857">1857</option>
                                                        <option value="1856">1856</option>
                                                        <option value="1855">1855</option>
                                                        <option value="1854">1854</option>
                                                        <option value="1853">1853</option>
                                                        <option value="1852">1852</option>
                                                        <option value="1851">1851</option>
                                                        <option value="1850">1850</option>
                                                        <option value="1849">1849</option>
                                                        <option value="1848">1848</option>
                                                        <option value="1847">1847</option>
                                                        <option value="1846">1846</option>
                                                        <option value="1845">1845</option>
                                                        <option value="1844">1844</option>
                                                        <option value="1843">1843</option>
                                                        <option value="1842">1842</option>
                                                        <option value="1841">1841</option>
                                                        <option value="1840">1840</option>
                                                        <option value="1839">1839</option>
                                                        <option value="1838">1838</option>
                                                        <option value="1837">1837</option>
                                                        <option value="1836">1836</option>
                                                        <option value="1835">1835</option>
                                                        <option value="1834">1834</option>
                                                        <option value="1833">1833</option>
                                                        <option value="1832">1832</option>
                                                        <option value="1831">1831</option>
                                                        <option value="1830">1830</option>
                                                        <option value="1829">1829</option>
                                                        <option value="1828">1828</option>
                                                        <option value="1827">1827</option>
                                                        <option value="1826">1826</option>
                                                        <option value="1825">1825</option>
                                                        <option value="1824">1824</option>
                                                        <option value="1823">1823</option>
                                                        <option value="1822">1822</option>
                                                        <option value="1821">1821</option>
                                                        <option value="1820">1820</option>
                                                        <option value="1819">1819</option>
                                                        <option value="1818">1818</option>
                                                        <option value="1817">1817</option>
                                                        <option value="1816">1816</option>
                                                        <option value="1815">1815</option>
                                                        <option value="1814">1814</option>
                                                        <option value="1813">1813</option>
                                                        <option value="1812">1812</option>
                                                        <option value="1811">1811</option>
                                                        <option value="1810">1810</option>
                                                        <option value="1809">1809</option>
                                                        <option value="1808">1808</option>
                                                        <option value="1807">1807</option>
                                                        <option value="1806">1806</option>
                                                        <option value="1805">1805</option>
                                                        <option value="1804">1804</option>
                                                        <option value="1803">1803</option>
                                                        <option value="1802">1802</option>
                                                        <option value="1801">1801</option>
                                                        <option value="1800">1800</option>
                                                    </select>
                                                </div>
                                                <div class="col-sm-4">
                                                    <select name="select_unit_month" class="form-control">
                                                        <option value="">Month:</option>
                                                        <option value="1">1</option>
                                                        <option value="2">2</option>
                                                        <option value="3">3</option>
                                                        <option value="4">4</option>
                                                        <option value="5">5</option>
                                                        <option value="6">6</option>
                                                        <option value="7">7</option>
                                                        <option value="8">8</option>
                                                        <option value="9">9</option>
                                                        <option value="10">10</option>
                                                        <option value="11">11</option>
                                                        <option value="12">12</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label ">Host Country/Region:</label>
                                                <div class="col-sm-8">
                                                    <select name="country_region" class="form-control">
                                                        <option value="">--please select--</option>
                                                        <option value="AF">Afghanistan</option>
                                                        <option value="ALA">Aland Islands</option>
                                                        <option value="AL">Albania</option>
                                                        <option value="GBA">Alderney</option>
                                                        <option value="DZ">Algeria</option>
                                                        <option value="AS">American Samoa</option>
                                                        <option value="AD">Andorra</option>
                                                        <option value="AO">Angola</option>
                                                        <option value="AI">Anguilla</option>
                                                        <option value="AQ">Antarctica</option>
                                                        <option value="AG">Antigua and Barbuda</option>
                                                        <option value="AR">Argentina</option>
                                                        <option value="AM">Armenia</option>
                                                        <option value="AW">Aruba</option>
                                                        <option value="ASC">Ascension Island</option>
                                                        <option value="AU">Australia</option>
                                                        <option value="AT">Austria</option>
                                                        <option value="AZ">Azerbaijan</option>
                                                        <option value="BS">Bahamas</option>
                                                        <option value="BH">Bahrain</option>
                                                        <option value="BD">Bangladesh</option>
                                                        <option value="BB">Barbados</option>
                                                        <option value="BY">Belarus</option>
                                                        <option value="BE">Belgium</option>
                                                        <option value="BZ">Belize</option>
                                                        <option value="BJ">Benin</option>
                                                        <option value="BM">Bermuda</option>
                                                        <option value="BT">Bhutan</option>
                                                        <option value="BO">Bolivia</option>
                                                        <option value="BA">Bosnia and Herzegovina</option>
                                                        <option value="BW">Botswana</option>
                                                        <option value="BV">Bouvet Island</option>
                                                        <option value="BR">Brazil</option>
                                                        <option value="IO">British Indian Ocean Territory</option>
                                                        <option value="BN">Brunei Darussalam</option>
                                                        <option value="BG">Bulgaria</option>
                                                        <option value="BF">Burkina Faso</option>
                                                        <option value="BI">Burundi</option>
                                                        <option value="KH">Cambodia</option>
                                                        <option value="CM">Cameroon</option>
                                                        <option value="CA">Canada</option>
                                                        <option value="CV">Cape Verde</option>
                                                        <option value="KY">Cayman Islands</option>
                                                        <option value="CF">Central African Republic</option>
                                                        <option value="TD">Chad</option>
                                                        <option value="CL">Chile</option>
                                                        <option value="CN">China (Mainland)</option>
                                                        <option value="CX">Christmas Island</option>
                                                        <option value="CC">Cocos (Keeling) Islands</option>
                                                        <option value="CO">Colombia</option>
                                                        <option value="KM">Comoros</option>
                                                        <option value="ZR">Congo, The Democratic Republic Of The</option>
                                                        <option value="CG">Congo, The Republic of Congo</option>
                                                        <option value="CK">Cook Islands</option>
                                                        <option value="CR">Costa Rica</option>
                                                        <option value="CI">Cote D'Ivoire</option>
                                                        <option value="HR">Croatia (local name: Hrvatska)</option>
                                                        <option value="CU">Cuba</option>
                                                        <option value="CY">Cyprus</option>
                                                        <option value="CZ">Czech Republic</option>
                                                        <option value="DK">Denmark</option>
                                                        <option value="DJ">Djibouti</option>
                                                        <option value="DM">Dominica</option>
                                                        <option value="DO">Dominican Republic</option>
                                                        <option value="TP">East Timor</option>
                                                        <option value="EC">Ecuador</option>
                                                        <option value="EG">Egypt</option>
                                                        <option value="SV">El Salvador</option>
                                                        <option value="GQ">Equatorial Guinea</option>
                                                        <option value="ER">Eritrea</option>
                                                        <option value="EE">Estonia</option>
                                                        <option value="ET">Ethiopia</option>
                                                        <option value="FK">Falkland Islands (Malvinas)</option>
                                                        <option value="FO">Faroe Islands</option>
                                                        <option value="FJ">Fiji</option>
                                                        <option value="FI">Finland</option>
                                                        <option value="FR">France</option>
                                                        <option value="FX">France Metropolitan</option>
                                                        <option value="GF">French Guiana</option>
                                                        <option value="PF">French Polynesia</option>
                                                        <option value="TF">French Southern Territories</option>
                                                        <option value="GA">Gabon</option>
                                                        <option value="GM">Gambia</option>
                                                        <option value="GE">Georgia</option>
                                                        <option value="DE">Germany</option>
                                                        <option value="GH">Ghana</option>
                                                        <option value="GI">Gibraltar</option>
                                                        <option value="GR">Greece</option>
                                                        <option value="GL">Greenland</option>
                                                        <option value="GD">Grenada</option>
                                                        <option value="GP">Guadeloupe</option>
                                                        <option value="GU">Guam</option>
                                                        <option value="GT">Guatemala</option>
                                                        <option value="GGY">Guernsey</option>
                                                        <option value="GN">Guinea</option>
                                                        <option value="GW">Guinea-Bissau</option>
                                                        <option value="GY">Guyana</option>
                                                        <option value="HT">Haiti</option>
                                                        <option value="HM">Heard and Mc Donald Islands</option>
                                                        <option value="HN">Honduras</option>
                                                        <option value="HK">Hong Kong</option>
                                                        <option value="HU">Hungary</option>
                                                        <option value="IS">Iceland</option>
                                                        <option value="IN">India</option>
                                                        <option value="ID">Indonesia</option>
                                                        <option value="IR">Iran (Islamic Republic of)</option>
                                                        <option value="IQ">Iraq</option>
                                                        <option value="IE">Ireland</option>
                                                        <option value="IM">Isle of Man</option>
                                                        <option value="IL">Israel</option>
                                                        <option value="IT">Italy</option>
                                                        <option value="JM">Jamaica</option>
                                                        <option value="JP">Japan</option>
                                                        <option value="JEY">Jersey</option>
                                                        <option value="JO">Jordan</option>
                                                        <option value="KZ">Kazakhstan</option>
                                                        <option value="KE">Kenya</option>
                                                        <option value="KI">Kiribati</option>
                                                        <option value="KS">Kosovo</option>
                                                        <option value="KW">Kuwait</option>
                                                        <option value="KG">Kyrgyzstan</option>
                                                        <option value="LA">Lao People's Democratic Republic</option>
                                                        <option value="LV">Latvia</option>
                                                        <option value="LB">Lebanon</option>
                                                        <option value="LS">Lesotho</option>
                                                        <option value="LR">Liberia</option>
                                                        <option value="LY">Libya</option>
                                                        <option value="LI">Liechtenstein</option>
                                                        <option value="LT">Lithuania</option>
                                                        <option value="LU">Luxembourg</option>
                                                        <option value="MO">Macau</option>
                                                        <option value="MK">Macedonia</option>
                                                        <option value="MG">Madagascar</option>
                                                        <option value="MW">Malawi</option>
                                                        <option value="MY">Malaysia</option>
                                                        <option value="MV">Maldives</option>
                                                        <option value="ML">Mali</option>
                                                        <option value="MT">Malta</option>
                                                        <option value="MH">Marshall Islands</option>
                                                        <option value="MQ">Martinique</option>
                                                        <option value="MR">Mauritania</option>
                                                        <option value="MU">Mauritius</option>
                                                        <option value="YT">Mayotte</option>
                                                        <option value="MX">Mexico</option>
                                                        <option value="FM">Micronesia</option>
                                                        <option value="MD">Moldova</option>
                                                        <option value="MC">Monaco</option>
                                                        <option value="MN">Mongolia</option>
                                                        <option value="MNE">Montenegro</option>
                                                        <option value="MS">Montserrat</option>
                                                        <option value="MA">Morocco</option>
                                                        <option value="MZ">Mozambique</option>
                                                        <option value="MM">Myanmar</option>
                                                        <option value="NA">Namibia</option>
                                                        <option value="NR">Nauru</option>
                                                        <option value="NP">Nepal</option>
                                                        <option value="NL">Netherlands</option>
                                                        <option value="AN">Netherlands Antilles</option>
                                                        <option value="NC">New Caledonia</option>
                                                        <option value="NZ">New Zealand</option>
                                                        <option value="NI">Nicaragua</option>
                                                        <option value="NE">Niger</option>
                                                        <option value="NG">Nigeria</option>
                                                        <option value="NU">Niue</option>
                                                        <option value="NF">Norfolk Island</option>
                                                        <option value="KP">North Korea</option>
                                                        <option value="MP">Northern Mariana Islands</option>
                                                        <option value="NO">Norway</option>
                                                        <option value="OM">Oman</option>
                                                        <option value="Other">Other Country</option>
                                                        <option value="PK">Pakistan</option>
                                                        <option value="PW">Palau</option>
                                                        <option value="PS">Palestine</option>
                                                        <option value="PA">Panama</option>
                                                        <option value="PG">Papua New Guinea</option>
                                                        <option value="PY">Paraguay</option>
                                                        <option value="PE">Peru</option>
                                                        <option value="PH">Philippines</option>
                                                        <option value="PN">Pitcairn</option>
                                                        <option value="PL">Poland</option>
                                                        <option value="PT">Portugal</option>
                                                        <option value="PR">Puerto Rico</option>
                                                        <option value="QA">Qatar</option>
                                                        <option value="RE">Reunion</option>
                                                        <option value="RO">Romania</option>
                                                        <option value="RU">Russian Federation</option>
                                                        <option value="RW">Rwanda</option>
                                                        <option value="BLM">Saint Barthelemy</option>
                                                        <option value="KN">Saint Kitts and Nevis</option>
                                                        <option value="LC">Saint Lucia</option>
                                                        <option value="MAF">Saint Martin</option>
                                                        <option value="VC">Saint Vincent and the Grenadines</option>
                                                        <option value="WS">Samoa</option>
                                                        <option value="SM">San Marino</option>
                                                        <option value="ST">Sao Tome and Principe</option>
                                                        <option value="SA">Saudi Arabia</option>
                                                        <option value="SCT">Scotland</option>
                                                        <option value="SN">Senegal</option>
                                                        <option value="SRB">Serbia</option>
                                                        <option value="SC">Seychelles</option>
                                                        <option value="SL">Sierra Leone</option>
                                                        <option value="SG">Singapore</option>
                                                        <option value="SK">Slovakia (Slovak Republic)</option>
                                                        <option value="SI">Slovenia</option>
                                                        <option value="SB">Solomon Islands</option>
                                                        <option value="SO">Somalia</option>
                                                        <option value="ZA">South Africa</option>
                                                        <option value="SGS">South Georgia and the South Sandwich Islands</option>
                                                        <option value="KR">South Korea</option>
                                                        <option value="SS">South Sudan</option>
                                                        <option value="ES">Spain</option>
                                                        <option value="LK">Sri Lanka</option>
                                                        <option value="SH">St. Helena</option>
                                                        <option value="PM">St. Pierre and Miquelon</option>
                                                        <option value="SD">Sudan</option>
                                                        <option value="SR">Suriname</option>
                                                        <option value="SJ">Svalbard and Jan Mayen Islands</option>
                                                        <option value="SZ">Swaziland</option>
                                                        <option value="SE">Sweden</option>
                                                        <option value="CH">Switzerland</option>
                                                        <option value="SY">Syrian Arab Republic</option>
                                                        <option value="TW">Taiwan</option>
                                                        <option value="TJ">Tajikistan</option>
                                                        <option value="TZ">Tanzania</option>
                                                        <option value="TH">Thailand</option>
                                                        <option value="TLS">Timor-Leste</option>
                                                        <option value="TG">Togo</option>
                                                        <option value="TK">Tokelau</option>
                                                        <option value="TO">Tonga</option>
                                                        <option value="TT">Trinidad and Tobago</option>
                                                        <option value="TN">Tunisia</option>
                                                        <option value="TR">Turkey</option>
                                                        <option value="TM">Turkmenistan</option>
                                                        <option value="TC">Turks and Caicos Islands</option>
                                                        <option value="TV">Tuvalu</option>
                                                        <option value="UG">Uganda</option>
                                                        <option value="UA">Ukraine</option>
                                                        <option value="AE">United Arab Emirates</option>
                                                        <option value="UK">United Kingdom</option>
                                                        <option value="US">United States</option>
                                                        <option value="UM">United States Minor Outlying Islands</option>
                                                        <option value="UY">Uruguay</option>
                                                        <option value="UZ">Uzbekistan</option>
                                                        <option value="VU">Vanuatu</option>
                                                        <option value="VA">Vatican City State (Holy See)</option>
                                                        <option value="VE">Venezuela</option>
                                                        <option value="VN">Vietnam</option>
                                                        <option value="VG">Virgin Islands (British)</option>
                                                        <option value="VI">Virgin Islands (U.S.)</option>
                                                        <option value="WF">Wallis And Futuna Islands</option>
                                                        <option value="EH">Western Sahara</option>
                                                        <option value="YE">Yemen</option>
                                                        <option value="YU">Yugoslavia</option>
                                                        <option value="ZM">Zambia</option>
                                                        <option value="EAZ">Zanzibar</option>
                                                        <option value="ZW">Zimbabwe</option>
                                                        <option value="CW">Curacao</option>
                                                        <option value="SX">Sint Maarten</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label ">Trade Show Introduction:</label>
                                                <div class="col-sm-8">
                                                    <textarea type="text" name="trade_show_intro" cols="5" id="comp_advantages" class="form-control" placeholder="Product Price"></textarea>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label">Trade Show Photo:</label>
                                                <div class="col-sm-8">
                                                    <input type="file" name="trade_show_photo" class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-1">
                                            <div class="clone-leftside-btn-2 cloneya-wrap">
                                                <div class="unit toclone-widget-left toclone cloneya cloneya1">
                                                    <button type="button" class="btn btn-default clone-btn-left delete" id="delete4">
                                                    -
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane" id="seo" role="tabpanel">
                                    <div class="container">
                                        <ul class="nav nav-tabs">
                                            <li class="active sub-tab"><a data-toggle="tab" href="#home">Certification /Test Report</a></li>
                                            <li class="sub-tab"><a data-toggle="tab" href="#menu1">Honor & Award Certification</a></li>
                                            <li class="sub-tab"><a data-toggle="tab" href="#menu2">Petents</a></li>
                                            <li class="sub-tab"><a data-toggle="tab" href="#menu3">Tredmarks</a></li>
                                        </ul>
                                        <div class="tab-content">
                                            <div id="home" class="tab-pane fade in active">
                                                <h6 class="mtl10">Add a certification</h6>
                                                <div class="col-md-10 col-sm-10 col-xs-12 bd1px">
                                                    <div class="form-group row">
                                                        <label class="col-sm-3 col-form-label ">Type of Certification:</label>
                                                        <div class="col-sm-6">
                                                            <select name="select_unit_type" class="form-control">
                                                                <option value="">Please Select...</option>
                                                                <option value="ManagementCert" title="Management System Certifications">Management System Certifications</option>
                                                                <option value="ProductCert" title="Product Certifications/Testing Reports">Product Certifications/Testing Reports</option>
                                                                <option value="ProductCateCert" title="Industry Standard Authorizations">Industry Standard Authorizations</option>
                                                                <option value="JxsCert" title="Restricted Product Authorizations">Restricted Product Authorizations</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label class="col-sm-3 col-form-label">Reference no:</label>
                                                        <div class="col-sm-6">
                                                            <input type="text" name="reference_no" class="form-control" placeholder=""> 
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label class="col-sm-3 col-form-label ">Name:</label>
                                                        <div class="col-sm-6">
                                                            <select name="name" class="form-control">
                                                                <option value="" selected="">--Please Select--</option>
                                                                <option value="BRC" title="British Retail Consortium">BRC</option>
                                                                <option value="BSCI" title="Business Social Compliance Initiative">BSCI</option>
                                                                <option value="FSC" title="Forest Stewardship Council">FSC</option>
                                                                <option value="GMP" title="Good Manufacturing Practice">GMP</option>
                                                                <option value="GSV" title="Global Security Verification">GSV</option>
                                                                <option value="HACCP" title="Hazard Analysis Critical Control Point">HACCP</option>
                                                                <option value="ISO/TS16949" title="Quality management systems- automotive production">ISO/TS16949</option>
                                                                <option value="ISO10012" title="Measurement management systems">ISO10012</option>
                                                                <option value="ISO13485" title="Medical device-Quality management system-requirements for regulatory">ISO13485</option>
                                                                <option value="ISO14001" title="Environment management systems and standards">ISO14001</option>
                                                                <option value="ISO17025" title="General Requirement for the Competence of Test and Calibration Lab.">ISO17025</option>
                                                                <option value="ISO17799" title="ISO17799">ISO17799</option>
                                                                <option value="ISO22000" title="Food Safety Management System">ISO22000</option>
                                                                <option value="ISO9001" title="Quality management systems">ISO9001</option>
                                                                <option value="OHSAS18001" title="Occupational Health and Safety Assessment Series 18001">OHSAS18001</option>
                                                                <option value="SA8000" title="Social Accountability 8000">SA8000</option>
                                                                <option value="TL9000" title="TL9000">TL9000</option>
                                                                <option value="Other" title="Other">Other</option>
                                                                <option value="ASME" title="ASME">ASME</option>
                                                                <option value="COC" title="COC">COC</option>
                                                                <option value="SAS" title="SAS">SAS</option>
                                                                <option value="SC" title="SC">SC</option>
                                                                <option value="GSV" title="Global Security Verification">GSV</option>
                                                                <option value="ISO10002" title="ISO10002">ISO10002</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label class="col-sm-3 col-form-label ">Issued By:</label>
                                                        <div class="col-sm-6">
                                                            <select name="issued_by" class="form-control">
                                                                <option value="" selected="selected">Please Select...</option>
                                                                <option value="ABS" title="American Bureau of Shipping ">ABS</option>
                                                                <option value="BSI" title="BSI">BSI</option>
                                                                <option value="BV" title="Bureau Veritas">BV</option>
                                                                <option value="China Great Wall Quality" title="China Great Wall Quality">China Great Wall Quality</option>
                                                                <option value="CQC" title="China Quality Certification Centre">CQC</option>
                                                                <option value="CQM" title="China Quality Mark Certification Group">CQM</option>
                                                                <option value="Dekra" title="Dekra">Dekra</option>
                                                                <option value="DNV" title="DNV">DNV</option>
                                                                <option value="DQS" title="DQS Holding GmbH">DQS</option>
                                                                <option value="Intertek" title="Intertek">Intertek</option>
                                                                <option value="LR" title="Lloyd¡¯s Register of Shipping">LR</option>
                                                                <option value="MOODY" title="MOODY">MOODY</option>
                                                                <option value="SGS" title="Societe Generale de Surveillance S.A.">SGS</option>
                                                                <option value="TUV NORD" title="TUV NORD">TUV NORD</option>
                                                                <option value="TUV Rheinland" title="TUV Rheinland">TUV Rheinland</option>
                                                                <option value="TUV SUD" title="TUV SUD">TUV SUD</option>
                                                                <option value="UL" title="Underwriter Laboratories Inc.">UL</option>
                                                                <option value="WIT" title="WIT">WIT</option>
                                                                <option value="Other" title="Other">Other</option>
                                                                <option value="JAKIM" title="JAKIM">JAKIM</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label class="col-sm-3 col-form-label ">Start Date (validity period):</label>
                                                        <div class="col-sm-6">
                                                            <div class='input-group date' id='datetimepicker1'>
                                                                <input type='text' class="form-control" / name="start_date">
                                                                <span class="input-group-addon">
                                                                <span class="glyphicon glyphicon-calendar"></span>
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label class="col-sm-3 col-form-label ">End Date:</label>
                                                        <div class="col-sm-6">
                                                            <div class='input-group date' id='datetimepicker1'>
                                                                <input type='text' class="form-control" / name="end_date">
                                                                <span class="input-group-addon">
                                                                <span class="glyphicon glyphicon-calendar"></span>
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label class="col-sm-3 col-form-label">Image:</label>
                                                        <div class="col-sm-6">
                                                            <input type="file" name="image" class="form-control">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label class="col-sm-3 col-form-label">Scope:</label>
                                                        <div class="col-sm-6">
                                                            <textarea type="text" name="scope" id="comp_advantages" class="form-control" placeholder="Product Price"></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row text-center">
                                                        <label class="col-sm-3 col-form-label"></label>
                                                        <button type="submit" class="btn btn-primary">Upload</button>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <h6 class="mtl10">Submitted Certifications List</h6>
                                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                                        <table class="table">
                                                            <thead>
                                                                <tr>
                                                                    <th>Reference</th>
                                                                    <th>Name</th>
                                                                    <th>Type of Certification</th>
                                                                    <th>Issue By</th>
                                                                    <th>Valid Time</th>
                                                                    <th>Status</th>
                                                                    <th>Action</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr>
                                                                    <td>John</td>
                                                                    <td>Doe</td>
                                                                    <td>john@example.com</td>
                                                                    <td>John</td>
                                                                    <td>Doe</td>
                                                                    <td>john@example.com</td>
                                                                    <td>
                                                                        <a href="#">Edit |</a>
                                                                        <a href="#">Delete</a>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Mary</td>
                                                                    <td>Moe</td>
                                                                    <td>mary@example.com</td>
                                                                    <td>John</td>
                                                                    <td>Doe</td>
                                                                    <td>john@example.com</td>
                                                                    <td>
                                                                        <a href="#">Edit |</a>
                                                                        <a href="#">Delete</a>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>July</td>
                                                                    <td>Dooley</td>
                                                                    <td>july@example.com</td>
                                                                    <td>John</td>
                                                                    <td>Doe</td>
                                                                    <td>john@example.com</td>
                                                                    <td>
                                                                        <a href="#">Edit |</a>
                                                                        <a href="#">Delete</a>
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                            <div id="menu1" class="tab-pane fade">
                                                <h6 class="mtl10">Add an Award or Certification</h6>
                                                <div class="col-md-10 col-sm-10 col-xs-12 bd1px">
                                                    <div class="form-group row">
                                                        <label class="col-sm-3 col-form-label">Name:</label>
                                                        <div class="col-sm-6">
                                                            <input type="text" name="name" class="form-control" placeholder=""> 
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label class="col-sm-3 col-form-label ">Issued By:</label>
                                                        <div class="col-sm-6">
                                                            <select name="issued_by" class="form-control">
                                                                <option value="" selected="selected">Please Select...</option>
                                                                <option value="ABS" title="American Bureau of Shipping ">ABS</option>
                                                                <option value="BSI" title="BSI">BSI</option>
                                                                <option value="BV" title="Bureau Veritas">BV</option>
                                                                <option value="China Great Wall Quality" title="China Great Wall Quality">China Great Wall Quality</option>
                                                                <option value="CQC" title="China Quality Certification Centre">CQC</option>
                                                                <option value="CQM" title="China Quality Mark Certification Group">CQM</option>
                                                                <option value="Dekra" title="Dekra">Dekra</option>
                                                                <option value="DNV" title="DNV">DNV</option>
                                                                <option value="DQS" title="DQS Holding GmbH">DQS</option>
                                                                <option value="Intertek" title="Intertek">Intertek</option>
                                                                <option value="LR" title="Lloyd¡¯s Register of Shipping">LR</option>
                                                                <option value="MOODY" title="MOODY">MOODY</option>
                                                                <option value="SGS" title="Societe Generale de Surveillance S.A.">SGS</option>
                                                                <option value="TUV NORD" title="TUV NORD">TUV NORD</option>
                                                                <option value="TUV Rheinland" title="TUV Rheinland">TUV Rheinland</option>
                                                                <option value="TUV SUD" title="TUV SUD">TUV SUD</option>
                                                                <option value="UL" title="Underwriter Laboratories Inc.">UL</option>
                                                                <option value="WIT" title="WIT">WIT</option>
                                                                <option value="Other" title="Other">Other</option>
                                                                <option value="JAKIM" title="JAKIM">JAKIM</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label class="col-sm-3 col-form-label ">Start Date:</label>
                                                        <div class="col-sm-6">
                                                            <div class='input-group date' id='datetimepicker1'>
                                                                <input type='text' class="form-control" / name="start_date">
                                                                <span class="input-group-addon">
                                                                <span class="glyphicon glyphicon-calendar"></span>
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label class="col-sm-3 col-form-label">Image:</label>
                                                        <div class="col-sm-6">
                                                            <input type="file" name="image" class="form-control">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label class="col-sm-3 col-form-label">Certification Description:</label>
                                                        <div class="col-sm-6">
                                                            <textarea type="text" name="certification_desc" id="comp_advantages" class="form-control" placeholder="Product Price"></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row text-center">
                                                        <label class="col-sm-3 col-form-label"></label>
                                                        <button type="submit" class="btn btn-primary">Upload</button>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <h6 class="mtl10">Submitted Certifications List</h6>
                                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                                        <table class="table">
                                                            <thead>
                                                                <tr>
                                                                    <th>Name</th>
                                                                    <th>Issue By</th>
                                                                    <th>Start Date</th>
                                                                    <th>Action</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr>
                                                                    <td>John</td>
                                                                    <td>Doe</td>
                                                                    <td>john@example.com</td>
                                                                    <td>
                                                                        <a href="#">Edit |</a>
                                                                        <a href="#">Delete</a>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>John</td>
                                                                    <td>Doe</td>
                                                                    <td>john@example.com</td>
                                                                    <td>
                                                                        <a href="#">Edit |</a>
                                                                        <a href="#">Delete</a>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>John</td>
                                                                    <td>Doe</td>
                                                                    <td>john@example.com</td>
                                                                    <td>
                                                                        <a href="#">Edit |</a>
                                                                        <a href="#">Delete</a>
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                            <div id="menu2" class="tab-pane fade">
                                                <h6 class="mtl10">Add a Patent</h6>
                                                <div class="col-md-10 col-sm-10 col-xs-12 bd1px">
                                                    <div class="form-group row">
                                                        <label class="col-sm-3 col-form-label">No. of Patent:</label>
                                                        <div class="col-sm-6">
                                                            <input type="text" name="trade_show" class="form-control" placeholder=""> 
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label class="col-sm-3 col-form-label">Patent Name:</label>
                                                        <div class="col-sm-6">
                                                            <input type="text" name="trade_show" class="form-control" placeholder=""> 
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label class="col-sm-3 col-form-label ">Type of Patent:</label>
                                                        <div class="col-sm-6">
                                                            <select name="select_unit_type" class="form-control">
                                                                <option value="">Please Select...</option>
                                                                <
                                                                <option value="Invention" title="Invention">Invention Patents</option>
                                                                <option value="Practical" title="Practical">Practical Patents</option>
                                                                <option value="Design" title="Design">Design Patents</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label class="col-sm-3 col-form-label ">Start Date (validity period):</label>
                                                        <div class="col-sm-6">
                                                            <div class='input-group date' id='datetimepicker1'>
                                                                <input type='text' class="form-control" />
                                                                <span class="input-group-addon">
                                                                <span class="glyphicon glyphicon-calendar"></span>
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label class="col-sm-3 col-form-label ">End Date:</label>
                                                        <div class="col-sm-6">
                                                            <div class='input-group date' id='datetimepicker1'>
                                                                <input type='text' class="form-control" />
                                                                <span class="input-group-addon">
                                                                <span class="glyphicon glyphicon-calendar"></span>
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label class="col-sm-3 col-form-label">Image:</label>
                                                        <div class="col-sm-6">
                                                            <input type="file" name="company_photo" class="form-control">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row text-center">
                                                        <label class="col-sm-3 col-form-label"></label>
                                                        <button type="submit" class="btn btn-primary">Upload</button>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <h6 class="mtl10">Submitted Petents List</h6>
                                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                                        <table class="table">
                                                            <thead>
                                                                <tr>
                                                                    <th>No of Patents</th>
                                                                    <th>Patents Name</th>
                                                                    <th>Type of Patents</th>
                                                                    <th>Valid Time</th>
                                                                    <th>Status</th>
                                                                    <th>Action</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr>
                                                                    <td>John</td>
                                                                    <td>Doe</td>
                                                                    <td>john@example.com</td>
                                                                    <td>John</td>
                                                                    <td>Doe</td>
                                                                    <td>
                                                                        <a href="#">Edit |</a>
                                                                        <a href="#">Delete</a>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Mary</td>
                                                                    <td>Moe</td>
                                                                    <td>mary@example.com</td>
                                                                    <td>John</td>
                                                                    <td>Doe</td>
                                                                    <td>
                                                                        <a href="#">Edit |</a>
                                                                        <a href="#">Delete</a>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>July</td>
                                                                    <td>Dooley</td>
                                                                    <td>july@example.com</td>
                                                                    <td>John</td>
                                                                    <td>Doe</td>
                                                                    <td>
                                                                        <a href="#">Edit |</a>
                                                                        <a href="#">Delete</a>
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                            <div id="menu3" class="tab-pane fade">
                                                <h6 class="mtl10">Add a trademark</h6>
                                                <div class="col-md-10 col-sm-10 col-xs-12 bd1px">
                                                    <div class="form-group row">
                                                        <label class="col-sm-3 col-form-label ">Type of Patent:</label>
                                                        <div class="col-sm-6">
                                                            <select name="select_unit_type" class="form-control">
                                                                <option value="">Please Select...</option>
                                                                <
                                                                <option value="Invention" title="Invention">Invention Patents</option>
                                                                <option value="Practical" title="Practical">Practical Patents</option>
                                                                <option value="Design" title="Design">Design Patents</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label class="col-sm-3 col-form-label">Source of trademark</label>
                                                        <div class="col-sm-6">
                                                            <select name="show_production_process" class="form-control" id="">
                                                                <option value="NO">Own(On our own name's registration)</option>
                                                                <option value="YES" id="production_yes">Authorized (Authorization from others 'registration)</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label class="col-sm-3 col-form-label">Registration/Filing No:</label>
                                                        <div class="col-sm-6">
                                                            <input type="text" name="trade_show" class="form-control" placeholder=""> 
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label class="col-sm-3 col-form-label">Trademark Name:</label>
                                                        <div class="col-sm-6">
                                                            <input type="text" name="trade_show" class="form-control" placeholder=""> 
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label class="col-sm-3 col-form-label ">Start Date (validity period):</label>
                                                        <div class="col-sm-6">
                                                            <div class='input-group date' id='datetimepicker1'>
                                                                <input type='text' class="form-control" />
                                                                <span class="input-group-addon">
                                                                <span class="glyphicon glyphicon-calendar"></span>
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label class="col-sm-3 col-form-label ">End Date:</label>
                                                        <div class="col-sm-6">
                                                            <div class='input-group date' id='datetimepicker1'>
                                                                <input type='text' class="form-control" />
                                                                <span class="input-group-addon">
                                                                <span class="glyphicon glyphicon-calendar"></span>
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label class="col-sm-3 col-form-label">Image:</label>
                                                        <div class="col-sm-6">
                                                            <input type="file" name="company_photo" class="form-control">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label class="col-sm-3 col-form-label">Approved Goods:</label>
                                                        <div class="col-sm-6">
                                                            <textarea type="text" name="comp_advantages" id="comp_advantages" class="form-control" placeholder="Product Price"></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row text-center">
                                                        <label class="col-sm-3 col-form-label"></label>
                                                        <button type="submit" class="btn btn-primary">Upload</button>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <h6 class="mtl10">Submitted Trademarks List</h6>
                                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                                        <table class="table">
                                                            <thead>
                                                                <tr>
                                                                    <th>Registration/Filing No</th>
                                                                    <th>Trademark Name</th>
                                                                    <th>Valid Time</th>
                                                                    <th>Status</th>
                                                                    <th>Action</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr>
                                                                    <td>John</td>
                                                                    <td>Doe</td>
                                                                    <td>john@example.com</td>
                                                                    <td>John</td>
                                                                    <td>
                                                                        <a href="#">Edit |</a>
                                                                        <a href="#">Delete</a>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Mary</td>
                                                                    <td>Moe</td>
                                                                    <td>mary@example.com</td>
                                                                    <td>John</td>
                                                                    <td>
                                                                        <a href="#">Edit |</a>
                                                                        <a href="#">Delete</a>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>July</td>
                                                                    <td>Dooley</td>
                                                                    <td>july@example.com</td>
                                                                    <td>John</td>
                                                                    <td>
                                                                        <a href="#">Edit |</a>
                                                                        <a href="#">Delete</a>
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="j-footer">
                                    <button type="submit" class="btn btn-primary">Save</button>
                                    <button type="reset" class="btn btn-default m-r-20">Submit</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
</form>
</div>
</div>

<?php $this->load->view("supplier/common/footer");?>