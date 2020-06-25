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
                                    <li class="breadcrumb-item"><a href="#!">User</a></li>
                                    <li class="breadcrumb-item"><a href="#!">Manage Profile</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
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
                                                            <form action="<?php echo base_url() . $action_comp_detail; ?>" method="post">
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
                                                                                    <input type="text" name="company_name" id="company_name" class="form-control" placeholder="Company Name" value="<?php echo $comp_det['company_name']; ?>">
                                                                                </div>
                                                                            </div>
                                                                            <div class="form-group row">
                                                                                <label class="col-sm-2 col-form-label">Location of Registration</label>
                                                                                <div class="col-sm-10">
                                                                                    <div class="form-group row">
                                                                                        <label class="col-sm-4 col-form-label"> Province/State/County</label>
                                                                                        <div class="col-sm-8">
                                                                                            <input type="text" name="location_state_country" id="location_state_country" class="form-control" placeholder="Province/State/County" value="<?php echo $comp_det['location_state_country']; ?>">
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="form-group row">
                                                                                        <label class="col-sm-4 col-form-label">Country/Region</label>
                                                                                        <div class="col-sm-8">
                                                                                            <input type="text" name="location_region" id="location_region" class="form-control" placeholder="Country/Region" value="<?php echo $comp_det['location_region']; ?>">
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
                                                                                            <input type="text" name="comp_operational_addr" id="comp_operational_addr" class="form-control" placeholder="Street" value="<?php echo $comp_det['comp_operational_addr']; ?>">
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="form-group row">
                                                                                        <label class="col-sm-4 col-form-label">City</label>
                                                                                        <div class="col-sm-8">
                                                                                            <input type="text" name="comp_operational_city" id="comp_operational_city" class="form-control" placeholder="City" value="<?php echo $comp_det['comp_operational_city']; ?>">
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="form-group row">
                                                                                        <label class="col-sm-4 col-form-label">Province/State/County</label>
                                                                                        <div class="col-sm-8">
                                                                                            <input type="text" name="comp_operational_state" id="comp_operational_state" class="form-control" placeholder="Province/State/County" value="<?php echo $comp_det['comp_operational_state']; ?>">
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="form-group row">
                                                                                        <label class="col-sm-4 col-form-label">Country/Region</label>
                                                                                        <div class="col-sm-8">
                                                                                            <input type="text" name="comp_operational_region" id="comp_operational_region" class="form-control" placeholder="Country/Region" value="<?php echo $comp_det['comp_operational_region']; ?>">
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="form-group row">
                                                                                        <label class="col-sm-4 col-form-label">Zip/Postal Code</label>
                                                                                        <div class="col-sm-8">
                                                                                            <input type="text" name="comp_operational_zip_code" id="comp_operational_zip_code" class="form-control" placeholder="Zip/Postal Code" value="<?php echo $comp_det['comp_operational_zip_code']; ?>">
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="form-group row">
                                                                                <label class="col-sm-2 col-form-label">Main Products</label>
                                                                                <div class="col-sm-2">
                                                                                    <input type="text" name="main_product_one" id="main_product_one" class="form-control" placeholder="" value="<?php echo $comp_det['main_product_one']; ?>">
                                                                                </div>
                                                                                <div class="col-sm-2">
                                                                                    <input type="text" name="main_product_two" id="main_product_two" class="form-control" placeholder="" value="<?php echo $comp_det['main_product_two']; ?>">
                                                                                </div>
                                                                                <div class="col-sm-2">
                                                                                    <input type="text" name="main_product_three" id="main_product_three" class="form-control" placeholder="" value="<?php echo $comp_det['main_product_three']; ?>">
                                                                                </div>
                                                                                <div class="col-sm-2">
                                                                                    <input type="text" name="main_product_four" id="main_product_four" class="form-control" placeholder="" value="<?php echo $comp_det['main_product_four']; ?>">
                                                                                </div>
                                                                                <div class="col-sm-2">
                                                                                    <input type="text" name="main_product_five" id="main_product_five" class="form-control" placeholder="" value="<?php echo $comp_det['main_product_five']; ?>">
                                                                                </div>
                                                                            </div>
                                                                            <div class="form-group row">
                                                                                <label class="col-sm-2 col-form-label">Other Products you sell</label>
                                                                                <div class="col-sm-2">
                                                                                    <input type="text" name="other_product_one" id="other_product_one" class="form-control" placeholder="" value="<?php echo $comp_det['other_product_one']; ?>">
                                                                                </div>
                                                                                <div class="col-sm-2">
                                                                                    <input type="text" name="other_product_two" id="other_product_two" class="form-control" placeholder="" value="<?php echo $comp_det['other_product_two']; ?>">
                                                                                </div>
                                                                                <div class="col-sm-2">
                                                                                    <input type="text" name="other_product_three" id="other_product_three" class="form-control" placeholder="" value="<?php echo $comp_det['other_product_three']; ?>">
                                                                                </div>
                                                                                <div class="col-sm-2">
                                                                                    <input type="text" name="other_product_four" id="other_product_four" class="form-control" placeholder="" value="<?php echo $comp_det['other_product_four']; ?>">
                                                                                </div>
                                                                                <div class="col-sm-2">
                                                                                    <input type="text" name="other_product_five" id="other_product_five" class="form-control" placeholder="" value="<?php echo $comp_det['other_product_five']; ?>">
                                                                                </div>
                                                                            </div>
                                                                            <div class="form-group row">
                                                                                <label class="col-sm-2 col-form-label">Year Company Registered</label>
                                                                                <div class="col-sm-10">
                                                                                    <select name="year_of_register" class="form-control">
                                                                                        <option value="">Selecy Year of register</option>
                                                                                        <?php
                                                                                        $y = date('Y');
                                                                                        while ($y >= 1920) {
                                                                                            ?>
                                                                                            <option value="<?php echo $y; ?>" <?php if ($comp_det['year_of_register'] == $y) {
                                                                                            echo "selected=selected";
                                                                                        } ?>><?php echo $y; ?></option>
                                                                                            <?php
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
                                                                                        <option value="Fewer than 5" <?php if ($comp_det['no_of_employee'] == 'Fewer than 5') {
                                                                                            echo "selected=selected";
                                                                                        } ?>>Fewer than 5 People</option>
                                                                                        <option value="5-10" <?php if ($comp_det['no_of_employee'] == '5-10') {
                                                                                            echo "selected=selected";
                                                                                        } ?>>5 - 10 People</option>
                                                                                        <option value="11-50" <?php if ($comp_det['no_of_employee'] == '11-50') {
                                                                                            echo "selected=selected";
                                                                                        } ?>>11 - 50 People</option>
                                                                                        <option value="51-100" <?php if ($comp_det['no_of_employee'] == '101-200') {
                                                                                            echo "selected=selected";
                                                                                        } ?>>51 - 100 People</option>
                                                                                        <option value="101-200" <?php if ($comp_det['no_of_employee'] == 'Below 100') {
                                                                                            echo "selected=selected";
                                                                                        } ?>>101 - 200 People</option>
                                                                                        <option value="201-300" <?php if ($comp_det['no_of_employee'] == '201-300') {
                                                                                            echo "selected=selected";
                                                                                        } ?>>201 - 300 People</option>
                                                                                        <option value="301-500" <?php if ($comp_det['no_of_employee'] == '301-500') {
                                                                                            echo "selected=selected";
                                                                                        } ?>>301 - 500 People</option>
                                                                                        <option value="501-1000" <?php if ($comp_det['no_of_employee'] == '501-1000') {
                                                                                            echo "selected=selected";
                                                                                        } ?>>501 - 1000 People</option>
                                                                                        <option value="Above 1000" <?php if ($comp_det['no_of_employee'] == 'Above 1000') {
                                                                                            echo "selected=selected";
                                                                                        } ?>>Above 1000 People</option>
                                                                                    </select>
                                                                                </div>
                                                                            </div>
                                                                            <div class="form-group row">
                                                                                <label class="col-sm-2 col-form-label">Company Website Url</label>
                                                                                <div class="col-sm-10">
                                                                                    <input type="text" name="company_url" class="form-control" placeholder="http" value="<?php echo $comp_det['company_url']; ?>">
                                                                                </div>
                                                                            </div>
                                                                            <div class="form-group row">
                                                                                <label class="col-sm-2 col-form-label">Legal Owner</label>
                                                                                <div class="col-sm-10">
                                                                                    <input type="text" name="legal_owner" placeholder="Legal Owner" class="form-control" value="<?php echo $comp_det['legal_owner']; ?>">
                                                                                </div>
                                                                            </div>
                                                                            <div class="form-group row">
                                                                                <label class="col-sm-2 col-form-label">Office Size</label>
                                                                                <div class="col-sm-10">
                                                                                    <select name="office_size" class="form-control">
                                                                                        <option value="">--- Please select ---</option>
                                                                                        <option value="Below 100" <?php if ($comp_det['office_size'] == 'Below 100') {
                                                                                            echo "selected=selected";
                                                                                        } ?>>Below 100 square meters</option>
                                                                                        <option value="101-500" <?php if ($comp_det['office_size'] == '101-500') {
                                                                                            echo "selected=selected";
                                                                                        } ?>>101 - 500 square meters</option>
                                                                                        <option value="501-1000" <?php if ($comp_det['office_size'] == '501-1000') {
                                                                                            echo "selected=selected";
                                                                                        } ?>>501 - 1000 square meters</option>
                                                                                        <option value="1001-2000" <?php if ($comp_det['office_size'] == '1001-2000') {
                                                                                            echo "selected=selected";
                                                                                        } ?>>1001 -2000 square meters</option>
                                                                                        <option value="Above 2000" <?php if ($comp_det['office_size'] == 'Above 2000') {
                                                                                            echo "selected=selected";
                                                                                        } ?>>Above 2000 square meters</option>
                                                                                    </select>
                                                                                </div>
                                                                            </div>
                                                                            <div class="form-group row">
                                                                                <label class="col-sm-2 col-form-label">Company Advantages</label>
                                                                                <div class="col-sm-10">
                                                                                    <textarea type="text" name="comp_advantages" id="comp_advantages" class="form-control" placeholder="Company Advantages"><?php echo$comp_det['comp_advantages']; ?></textarea>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="j-footer">
                                                                        <button type="submit" class="btn btn-primary pull-right">Save</button>

                                                                    </div>
                                                                </div>

                                                            </form>
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
     <form action="<?php echo base_url() . $action_manufacturing_capability; ?>" method="POST" enctype="multipart/form-data">
         <div class="card-block">
        <div class="form-group row">
            <label class="col-sm-2 col-form-label">Whether to show production process</label>
            <div class="col-sm-10">
                <select name="show_production_process" class="form-control" id="manufacturing_select">
                    <option value="NO" <?php if ($m_compability['show_production_process'] == 'NO') {
                        echo 'selected=selected';
                    } ?>>NO</option>
                    <option value="YES" <?php if ($m_compability['show_production_process'] == 'YES') {
                        echo 'selected=selected';
                    } ?> id="production_yes">YES</option>
                </select>
            </div>
        </div>
    <div class="row" id="production_process">
    <div class="col-sm-2"></div>
    <div class="col-sm-10">
    <table class="table table-responsive table-bordered">
        <thead>
            <tr>
                <th>
                    Process Name
                </th>
                <th>
                    Process Image
                </th>
                <th>
                    Description
                </th>
                <th>
                    Action
                </th>
            </tr>
        </thead>
        <tbody class="appendDynaRow" >
    <?php
    if (isset($production_pro)) {
    foreach ($production_pro as $pro) {
    ?>
                    <tr>
                        <td>
                            <input type="text" class="form-control" name="process_name[]" value="<?php if (isset($pro['process_name'])) {
    echo $pro['process_name'];
    } ?>">
                        </td>
                        <td>
                            <input type="file" class="form-control" name="process_picture[]" value="">
    <?php
    if (isset($pro['process_picture'])) {
    ?>
                                <img src="<?php echo $pro['process_picture']; ?>" style="width:80px;">
                    <?php } ?>
                            <input type="hidden" name="image_name[]" value="<?php echo $pro['process_picture']; ?>">
                        </td>
                        <td>
                            <input type="text" class="form-control" name="process_desc[]" value="<?php if (isset($pro['process_desc'])) {
                echo $pro['process_desc'];
            } ?>">
                        </td>									
                        <td>
                            <div class="addDeleteButton">
                                <span class="tooltips addDynaRow" title="Add" style="cursor: pointer;">
                                    <i class="fa fa-plus"></i>
                                </span>&nbsp;&nbsp;&nbsp;

                            </div>
                        </td>
                    </tr>
    <?php
    }
    } else {
    ?>
                <tr>
                    <td>
                        <input type="text" class="form-control" name="process_name[]" value="">
                    </td>
                    <td>
                        <input type="file" class="form-control" name="process_picture[]" value="">
                    </td>
                    <td>
                        <input type="text" class="form-control" name="process_desc[]" value="">
                    </td>									
                    <td>
                        <div class="addDeleteButton">
                            <span class="tooltips addDynaRow" title="Add" style="cursor: pointer;">
                                <i class="fa fa-plus"></i>
                            </span>&nbsp;&nbsp;&nbsp;

                        </div>
                    </td>
                </tr>
            <?php } ?>

        </tbody>
    </table>
    </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-2 col-form-label">Whether to show production equipment</label>
        <div class="col-sm-10">
            <select name="show_production_equipment" class="form-control" id="manufacturing_select_2">
                <option value="NO" <?php if ($m_compability['show_production_equipment'] == 'NO') {
                        echo 'selected=selected';
                    } ?>>NO</option>
                <option value="YES" <?php if ($m_compability['show_production_equipment'] == 'YES') {
                        echo 'selected=selected';
                    } ?>>YES</option>
            </select>
        </div>
    </div>
    <div class="row" id="eq_row">
        <div class="col-sm-2"></div>
        <div class="col-sm-10">
            <table class="table table-responsive table-bordered">
                <thead>
                    <tr>
                        <th>
                            Equipment Name
                        </th>
                        <th>
                            Equipment Model
                        </th>
                        <th>
                            Equipment quantity
                        </th>
                        <th>
                            Action
                        </th>
                    </tr>
                </thead>
                <tbody class="appendDynaRow" >
<?php
if (isset($m_pro_eq)) {
foreach ($m_pro_eq as $eqp) {
?>
                            <tr>
                                <td>
                                    <input type="text" name="equipment_name[]" class="form-control" placeholder="" value="<?php echo $eqp['equipment_name']; ?>">
                                </td>
                                <td>
                                    <input type="text" name="equipment_model[]" class="form-control" placeholder="" value="<?php echo $eqp['equipment_model']; ?>">
                                </td>
                                <td>
                                    <input type="text" name="equipment_quantity[]" class="form-control" placeholder="" value="<?php echo $eqp['equipment_quantity']; ?>">
                                </td>									
                                <td>
                                    <div class="addDeleteButton">
                                        <span class="tooltips addDynaRow" title="Add" style="cursor: pointer;">
                                            <i class="fa fa-plus"></i>
                                        </span>&nbsp;&nbsp;&nbsp;

                                    </div>
                                </td>
                            </tr>
<?php
}
} else {
?>
                        <tr>
                            <td>
                                <input type="text" name="equipment_name[]" class="form-control" placeholder="">
                            </td>
                            <td>
                                <input type="text" name="equipment_model[]" class="form-control" placeholder="">
                            </td>
                            <td>
                                <input type="text" name="equipment_quantity[]" class="form-control" placeholder="">
                            </td>									
                            <td>
                                <div class="addDeleteButton">
                                    <span class="tooltips addDynaRow" title="Add" style="cursor: pointer;">
                                        <i class="fa fa-plus"></i>
                                    </span>&nbsp;&nbsp;&nbsp;

                                </div>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>

            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Whether to show Production Line</label>
                <div class="col-sm-10">
                    <select name="show_production_line" class="form-control" id="manufacturing_select_3">
                        <option value="NO" <?php if ($m_compability['show_production_line'] == 'NO') {
                                echo 'selected=selected';
                            } ?>>NO</option>
                        <option value="YES" <?php if ($m_compability['show_production_line'] == 'YES') {
                                echo 'selected=selected';
                            } ?>>YES</option>
                    </select>
                </div>
            </div>

<div class="row" id="prod_line">
<div class="col-sm-2"></div>
<div class="col-sm-10">
    <table class="table table-responsive table-bordered">
        <thead>
            <tr>
                <th>
                    Production Line name
                </th>
                <th>
                    Supervisor Number
                </th>
                <th>
                    Number of Operators
                </th>
                <th>
                    QC/QA Number
                </th>
                <th>
                    Action
                </th>
            </tr>
        </thead>
        <tbody class="appendDynaRow" >
<?php
if (isset($production_line)) {
foreach ($production_line as $pl) {
?>
                    <tr>
                        <td>
                            <input type="text" name="production_line_name[]" class="form-control" placeholder="" value="<?php echo $pl['production_line_name']; ?>">
                        </td>
                        <td>
                            <input type="text" name="supervisor_number[]" class="form-control" placeholder="" value="<?php echo $pl['supervisor_number']; ?>">
                        </td>
                        <td>
                            <input type="text" name="number_operators[]" class="form-control" placeholder="" value="<?php echo $pl['number_operators']; ?>">
                        </td>	
                        <td>
                            <input type="text" name="qc_number[]" class="form-control" placeholder="" value="<?php echo $pl['qc_number']; ?>">
                        </td>																		
                        <td>
                            <div class="addDeleteButton">
                                <span class="tooltips addDynaRow" title="Add" style="cursor: pointer;">
                                    <i class="fa fa-plus"></i>
                                </span>&nbsp;&nbsp;&nbsp;

                            </div>
                        </td>
                    </tr>
<?php
}
} else {
?>
                <tr>
                    <td>
                        <input type="text" name="production_line_name[]" class="form-control" placeholder="">
                    </td>
                    <td>
                        <input type="text" name="supervisor_number[]" class="form-control" placeholder="">
                    </td>
                    <td>
                        <input type="text" name="number_operstors[]" class="form-control" placeholder="">
                    </td>	
                    <td>
                        <input type="text" name="qc_number[]" class="form-control" placeholder="">
                    </td>																		
                    <td>
                        <div class="addDeleteButton">
                            <span class="tooltips addDynaRow" title="Add" style="cursor: pointer;">
                                <i class="fa fa-plus"></i>
                            </span>&nbsp;&nbsp;&nbsp;

                        </div>
                    </td>
                </tr>
<?php } ?>
        </tbody>
    </table>
</div>
</div>

            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Factory Location</label>
                <div class="col-sm-10">
                    <input type="text" name="factory_location" class="form-control" value="<?php echo $m_compability['factory_location']; ?>" placeholder="factory location">
                </div>
            </div>
    <div class="form-group row">
    <label class="col-sm-2 col-form-label">Factory Size</label>
    <div class="col-sm-10">
    <select name="factory_size" class="form-control">
    <option value="Below 1000" <?php if ($m_compability['factory_size'] == 'Below 1000') {
    echo 'selected=selected';
    } ?>>Below 1,000 square meters</option>
    <option value="1000-3000"  <?php if ($m_compability['factory_size'] == '1000-3000') {
    echo 'selected=selected';
    } ?>>1000-3000 square meters</option>
    <option value="3000-5000"  <?php if ($m_compability['factory_size'] == '3000-5000') {
    echo 'selected=selected';
    } ?>>3,000-5,000 square meters</option>
    <option value="5000-10000"  <?php if ($m_compability['factory_size'] == '5000-10000') {
    echo 'selected=selected';
    } ?>>5,000-10,000 square meters</option>
    <option value="10000-30000"  <?php if ($m_compability['factory_size'] == '10000-30000') {
    echo 'selected=selected';
    } ?>>10,000-30,000 square meters</option>
    <option value="30000-50000"  <?php if ($m_compability['factory_size'] == '30000-50000') {
    echo 'selected=selected';
    } ?>>30,000-50,000 square meters</option>
    <option value="50000-100000"  <?php if ($m_compability['factory_size'] == '50000-100000') {
    echo 'selected=selected';
    } ?>>50,000-100,000 square meters</option>
    <option value="Above 100000"  <?php if ($m_compability['factory_size'] == 'Above 100000') {
    echo 'selected=selected';
    } ?>>Above 100,000 square meters</option>
    </select>
    </div>
    </div>
<div class="form-group row">
    <label class="col-sm-2 col-form-label">Contract Manufacturing</label>
    <div class="col-sm-10">
        <div class="border-checkbox-section">
            <div class="border-checkbox-group border-checkbox-group-primary">
                <input class="border-checkbox" type="checkbox" name="OEM_service_offered" <?php if ($m_compability['OEM_service_offered'] == 'on') {
                echo 'checked';
            } ?> id="checkbox1">
                <label class="border-checkbox-label" for="checkbox1">OEM Service Offered</label>
            </div>
            <div class="border-checkbox-group border-checkbox-group-success">
                <input class="border-checkbox" type="checkbox" name="design_service_offered" <?php if ($m_compability['design_service_offered'] == 'on') {
                echo 'checked';
            } ?> id="checkbox2">
                <label class="border-checkbox-label" for="checkbox2">Design Service Offered</label>
            </div>
            <div class="border-checkbox-group border-checkbox-group-success">
                <input class="border-checkbox" type="checkbox" name="buyer_label_offered" <?php if ($m_compability['buyer_label_offered'] == 'on') {
                echo 'checked';
            } ?>  id="checkbox3">
                <label class="border-checkbox-label" for="checkbox3">Buyer Label Offered</label>
            </div>
        </div>
    </div>
</div>
        <div class="form-group row">
            <label class="col-sm-2 col-form-label">OEM Experience</label>
            <div class="col-sm-10">
                <input type="text" name="oem_experience" class="form-control" value="<?php echo $m_compability['oem_experience']; ?>" placeholder="OEM Experience (Years)">
            </div>
        </div>
    <div class="form-group row">
        <label class="col-sm-2 col-form-label">No. of QC Staff</label>
        <div class="col-sm-10">
            <select name="no_of_qc_staff" class="form-control">
                <option value="Less than 5">Less than 5 People</option>
                <option value="5-10" <?php if ($m_compability['no_of_qc_staff'] == '5-10') {
                    echo 'selected=selected';
                } ?>>5 - 10 People</option>
                <option value="11-20" <?php if ($m_compability['no_of_qc_staff'] == '11-20') {
                    echo 'selected=selected';
                } ?>>11 - 20 People</option>
                <option value="21-30" <?php if ($m_compability['no_of_qc_staff'] == '21-30') {
                    echo 'selected=selected';
                } ?>>21 - 30 People</option>
                <option value="31-40" <?php if ($m_compability['no_of_qc_staff'] == '31-40') {
                    echo 'selected=selected';
                } ?>>31 - 40 People</option>
                <option value="31-40" <?php if ($m_compability['no_of_qc_staff'] == '31-40') {
                    echo 'selected=selected';
                } ?>>41 - 50 People</option>
                <option value="Above 50" <?php if ($m_compability['no_of_qc_staff'] == 'Above 50') {
                        echo 'selected=selected';
                    } ?>>Above 50 People</option>
            </select>
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-2 col-form-label">No. of R & D Staff</label>
        <div class="col-sm-10">
            <select name="no_of_RD_staff" class="form-control">
                <option value="Less than 5">Less than 5 People</option>
                <option value="5-10" <?php if ($m_compability['no_of_RD_staff'] == '5-10') {
                        echo 'selected=selected';
                    } ?>>5 - 10 People</option>
                <option value="11-20" <?php if ($m_compability['no_of_RD_staff'] == '11-20') {
                        echo 'selected=selected';
                    } ?>>11 - 20 People</option>
                <option value="21-30" <?php if ($m_compability['no_of_RD_staff'] == '21-30') {
                                    echo 'selected=selected';
                                } ?>>21 - 30 People</option>
                <option value="31-40" <?php if ($m_compability['no_of_RD_staff'] == '31-40') {
                                    echo 'selected=selected';
                                } ?>>31 - 40 People</option>
                <option value="31-40" <?php if ($m_compability['no_of_RD_staff'] == '31-40') {
                                    echo 'selected=selected';
                                } ?>>41 - 50 People</option>
                <option value="Above 50" <?php if ($m_compability['no_of_RD_staff'] == 'Above 50') {
                                    echo 'selected=selected';
                                } ?>>Above 50 People</option>
            </select>
        </div>
    </div>
        <div class="form-group row">
            <label class="col-sm-2 col-form-label">No. of Production Lines</label>
            <div class="col-sm-10">
                <select name="no_of_production_line" class="form-control">
    <?php
    $y = 0;
    while ($y <= 10) {
    ?>
                        <option value="<?php echo $y; ?>" <?php if ($m_compability['no_of_production_line'] == $y) {
    echo'selected=selected';
    } ?>><?php echo $y; ?></option>';
    <?php
    $y++;
    }
    ?>
                    <option value="Above 10" <?php if ($m_compability['no_of_production_line'] == 'Above 10') {
    echo'selected=selected';
    } ?>>Above 10</option>
                    ';
                </select>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-2 col-form-label">Annual Output Value (Year)</label>
            <div class="col-sm-10">
                <input type="text" name="annual_output_value" value="<?php echo $m_compability['annual_output_value']; ?>" class="form-control" placeholder="">
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-2 col-form-label">Add information about your annual production capacity?</label>
            <div class="col-sm-10">
                <select name="add_information" class="form-control" id="manufacturing_select_4">
                    <option value="NO" <?php if ($m_compability['add_information'] == 'NO') {
                                        echo 'selected=selected';
                                    } ?>>NO</option>
                    <option value="YES" <?php if ($m_compability['add_information'] == 'YES') {
                                        echo 'selected=selected';
                                    } ?>>YES</option>
                </select>
            </div>
        </div>

    <div class="row" id="list">
    <div class="col-sm-2"></div>
    <div class="col-sm-10">
    <table class="table table-responsive table-bordered">
        <thead>
            <tr>
                <th>
                    Product name
                </th>
                <th>
                    Units Produced (pre.year)
                </th>
                <th>
                    Highest Anuual Output
                </th>
                <th>
                    Unit Type
                </th>
                <th>
                    Action
                </th>
            </tr>
        </thead>
        <tbody class="appendDynaRow" > 
    <?php
    if (isset($add_info)) {
    foreach ($add_info as $info) {
    ?>
                    <tr>
                        <td>
                            <input type="text" name="prod_info_product_name[]" class="form-control" value="<?php echo $info['prod_info_product_name']; ?>" placeholder="">
                        </td> 
                        <td>
                            <input type="text" name="unit_produced[]" class="form-control" value="<?php echo $info['unit_produced']; ?>" placeholder=""> 
                        </td>
                        <td>
                            <input type="text" name="highest_annual_output[]" class="form-control" value="<?php echo $info['highest_annual_output']; ?>" placeholder="">
                        </td>	
                        <td>
                            <select class="form-control" name="select_unit_type[]">
    <?php
    foreach ($unit as $u) {
    ?>
                                    <option value="<?php echo $u['units_id']; ?>" <?php if ($info['select_unit_type'] == $u['units_id']) {
    echo 'selected=selected';
    } ?> ><?php echo $u['units_name']; ?></option>
    <?php }
    ?>
                            </select>
                        </td>																		
                        <td>
                            <div class="addDeleteButton">
                                <span class="tooltips addDynaRow" title="Add" style="cursor: pointer;">
                                    <i class="fa fa-plus"></i>
                                </span>&nbsp;&nbsp;&nbsp;

                            </div>
                        </td>
                    </tr>
    <?php
    }
    } else {
    ?>
                <tr>
                    <td>
                        <input type="text" name="prod_info_product_name[]" class="form-control" placeholder="">
                    </td> 
                    <td>
                        <input type="text" name="unit_produced[]" class="form-control" placeholder=""> 
                    </td>
                    <td>
                        <input type="text" name="highest_annual_output[]" class="form-control" placeholder="">
                    </td>	
                    <td>
                        <select class="form-control" name="select_unit_type[]">
                            <option value="">--Select Unit Type --</option>
    <?php
    foreach ($unit as $u) {
    ?>
                                <option value="<?php echo $u['units_id']; ?>"><?php echo $u['units_name']; ?></option>
                <?php }
                ?>
                        </select>
                    </td>																		
                    <td>
                        <div class="addDeleteButton">
                            <span class="tooltips addDynaRow" title="Add" style="cursor: pointer;">
                                <i class="fa fa-plus"></i>
                            </span>&nbsp;&nbsp;&nbsp;

                        </div>
                    </td>
                </tr>
    <?php }5 ?>
        </tbody>
    </table>
    </div>
    </div>
                <div class="j-footer">
                    <button type="submit" class="btn btn-primary pull-right">Save</button>
                </div>

                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                </div>
                                                <div class="tab-pane" id="quality_control" role="tabpanel">
                                                    <div class="page-body">
                                                        <div class="row">

                                                            <div class="col-sm-12">
                                                                <form action="<?php echo base_url() . $action_quality_control; ?>" method="POST" enctype="multipart/form-data">
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
                                                                                    <select name="quality_control_process" class="form-control" id="quality_control_select">
                                                                                        <option value="NO" <?php if (isset($qlty_control)) {
    if ($qlty_control['quality_control_process'] == 'NO') {
        echo'selected=selected';
    }
} ?>>NO</option>
                                                                                        <option value="YES" <?php if (isset($qlty_control)) {
    if ($qlty_control['quality_control_process'] == 'YES') {
        echo'selected=selected';
    }
} ?>>YES</option>
                                                                                    </select>
                                                                                </div>
                                                                            </div>
                                                                            <div class="row" id="quality_demonstrate">
                                                                                <div class="col-sm-2"></div>
                                                                                <div class="col-sm-10">
                                                                                    <table class="table table-responsive table-bordered">
                                                                                        <thead>
                                                                                            <tr>
                                                                                                <th>
                                                                                                    Process Name
                                                                                                </th>
                                                                                                <th>
                                                                                                    Process pictures
                                                                                                </th>
                                                                                                <th>
                                                                                                    Process describe
                                                                                                </th>

                                                                                                <th>
                                                                                                    Action
                                                                                                </th>
                                                                                            </tr>
                                                                                        </thead>
                                                                                        <tbody class="appendDynaRow" >
<?php
if (isset($qlty_ctrl_process)) {
    foreach ($qlty_ctrl_process as $pl) {
        ?>
                                                                                                    <tr>
                                                                                                        <td>
                                                                                                            <input type="text" name="qty_process_name[]" class="form-control" placeholder="" value="<?php echo $pl['qty_process_name']; ?>">
                                                                                                        </td>
                                                                                                        <td>
                                                                                                            <input type="file" class="form-control" name="qty_process_picture[]" value="">
        <?php
        if (isset($pl['qty_process_picture'])) {
            ?>
                                                                                                                <img src="<?php echo $pl['qty_process_picture']; ?>" style="width:80px;">
        <?php } ?>
                                                                                                            <input type="hidden" name="qlty_image_name[]" value="<?php echo $pl['qty_process_picture']; ?>">
                                                                                                        </td>
                                                                                                        <td>
                                                                                                            <input type="text" name="qty_process_describe[]" class="form-control" placeholder="" value="<?php echo $pl['qty_process_describe']; ?>">
                                                                                                        </td>
                                                                                                        <td>
                                                                                                            <div class="addDeleteButton">
                                                                                                                <span class="tooltips addDynaRow" title="Add" style="cursor: pointer;">
                                                                                                                    <i class="fa fa-plus"></i>
                                                                                                                </span>&nbsp;&nbsp;&nbsp;

                                                                                                            </div>
                                                                                                        </td>
                                                                                                    </tr>
    <?php
    }
} else {
    ?>
                                                                                                <tr>
                                                                                                    <td>
                                                                                                        <input type="text" name="qty_process_name[]" class="form-control" placeholder="">
                                                                                                    </td>
                                                                                                    <td>
                                                                                                        <input type="file" name="qty_process_picture[]" class="form-control" placeholder="">
                                                                                                    </td>
                                                                                                    <td>
                                                                                                        <input type="text" name="qty_process_describe[]" class="form-control" placeholder="">
                                                                                                    </td>
                                                                                                    <td>
                                                                                                        <div class="addDeleteButton">
                                                                                                            <span class="tooltips addDynaRow" title="Add" style="cursor: pointer;">
                                                                                                                <i class="fa fa-plus"></i>
                                                                                                            </span>&nbsp;&nbsp;&nbsp;

                                                                                                        </div>
                                                                                                    </td>
                                                                                                </tr>
<?php } ?>
                                                                                        </tbody>
                                                                                    </table>
                                                                                </div>
                                                                            </div>

                                                                            <div class="form-group row">
                                                                                <label class="col-sm-2 col-form-label">Whether to display testing equipment</label>
                                                                                <div class="col-sm-10">
                                                                                    <select name="testing_equipment" class="form-control" id="quality_equipment">
                                                                                        <option value="NO" <?php if (isset($qlty_control)) {
    if ($qlty_control['testing_equipment'] == 'NO') {
        echo'selected=selected';
    }
} ?>>NO</option>
                                                                                        <option value="YES" <?php if (isset($qlty_control)) {
    if ($qlty_control['testing_equipment'] == 'YES') {
        echo'selected=selected';
    }
} ?>>YES</option>
                                                                                    </select>
                                                                                </div>
                                                                            </div>
                                                                            <div class="row" id="quality_first">
                                                                                <div class="col-sm-2"></div>
                                                                                <div class="col-sm-10">
                                                                                    <table class="table table-responsive table-bordered">
                                                                                        <thead>
                                                                                            <tr>
                                                                                                <th>
                                                                                                    Equipment Name
                                                                                                </th>
                                                                                                <th>
                                                                                                    Equipment Model
                                                                                                </th>
                                                                                                <th>
                                                                                                    Equipment quantity
                                                                                                </th>

                                                                                                <th>
                                                                                                    Action 
                                                                                                </th>
                                                                                            </tr>
                                                                                        </thead>
                                                                                        <tbody class="appendDynaRow" >
<?php
if (isset($qlty_test_eqp)) {
    foreach ($qlty_test_eqp as $pl) {
        ?>
                                                                                                    <tr>
                                                                                                        <td>
                                                                                                            <input type="text" name="qlty_equipment_name[]" class="form-control" placeholder="" value="<?php echo $pl['qlty_equipment_name']; ?>">
                                                                                                        </td>
                                                                                                        <td>
                                                                                                            <input type="text" name="qlty_equipment_model[]" class="form-control" placeholder="" value="<?php echo $pl['qlty_equipment_model']; ?>">
                                                                                                        </td>
                                                                                                        <td>
                                                                                                            <input type="text" name="qlty_equipment_quantity[]" class="form-control" placeholder="" value="<?php echo $pl['qlty_equipment_quantity']; ?>">
                                                                                                        </td>
                                                                                                        <td>
                                                                                                            <div class="addDeleteButton">
                                                                                                                <span class="tooltips addDynaRow" title="Add" style="cursor: pointer;">
                                                                                                                    <i class="fa fa-plus"></i>
                                                                                                                </span>&nbsp;&nbsp;&nbsp;

                                                                                                            </div>
                                                                                                        </td>
                                                                                                    </tr>
    <?php
    }
} else {
    ?>
                                                                                                <tr>
                                                                                                    <td>
                                                                                                        <input type="text" name="qlty_equipment_name[]" class="form-control" placeholder="">
                                                                                                    </td>
                                                                                                    <td>
                                                                                                        <input type="text" name="qlty_equipment_model[]" class="form-control" placeholder="">
                                                                                                    </td>
                                                                                                    <td>
                                                                                                        <input type="text" name="qlty_equipment_quantity[]" class="form-control" placeholder="">
                                                                                                    </td>
                                                                                                    <td>
                                                                                                        <div class="addDeleteButton">
                                                                                                            <span class="tooltips addDynaRow" title="Add" style="cursor: pointer;">
                                                                                                                <i class="fa fa-plus"></i>
                                                                                                            </span>&nbsp;&nbsp;&nbsp;

                                                                                                        </div>
                                                                                                    </td>
                                                                                                </tr>
<?php } ?> 
                                                                                        </tbody>
                                                                                    </table>
                                                                                </div>
                                                                            </div>

                                                                        </div>
                                                                        <div class="j-footer">
                                                                            <button type="submit" class="btn btn-primary pull-right">Save</button>
                                                                        </div>
                                                                    </div>
                                                                </form>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="tab-pane" id="miscellaneous" role="tabpanel">
                                                    <form action="<?php echo base_url() . $action_export_capability; ?>" method="POST" enctype="multipart/form-data">
                                                        <div class="row" id="">
                                                            <div class="col-md-7 col-sm-7 col-xs-12" >
                                                                <div class="form-group row">
                                                                    <label class="col-sm-3 col-form-label">Total Annual Revenue:</label>
                                                                    <div class="col-sm-8">
                                                                        <input type="text" name="total_anual_revenue" value="<?php if (isset($m_export['total_anual_revenue'])) {
    echo $m_export['total_anual_revenue'];
} ?>" placeholder="eg. US$1 Million - US$2.5 Million" class="form-control">

                                                                    </div>
                                                                </div>
                                                                <div class="form-group row">
                                                                    <label class="col-sm-3 col-form-label">Export Percentage:</label>
                                                                    <div class="col-sm-8">
                                                                        <select id="trade-export-rate" class="form-control" name="export_percentage">
                                                                            <option value="">--please select--</option>
                                                                            <option value="1-10" <?php if (isset($m_export['export_percentage'])) {
    if ($m_export['export_percentage'] == '1-10') {
        echo 'selected=selected';
    }
} ?> >1-10 (%)</option>
                                                                            <option value="11-20" <?php if (isset($m_export['export_percentage'])) {
    if ($m_export['export_percentage'] == '11-20') {
        echo 'selected=selected';
    }
} ?>>11-20 (%)</option>
                                                                            <option value="21-30" <?php if (isset($m_export['export_percentage'])) {
    if ($m_export['export_percentage'] == '21-30') {
        echo 'selected=selected';
    }
} ?>>21-30 (%)</option>
                                                                            <option value="31-40" <?php if (isset($m_export['export_percentage'])) {
    if ($m_export['export_percentage'] == '31-40') {
        echo 'selected=selected';
    }
} ?>>31-40 (%)</option>
                                                                            <option value="41-50" <?php if (isset($m_export['export_percentage'])) {
                                                                            if ($m_export['export_percentage'] == '41-50') {
                                                                                echo 'selected=selected';
                                                                            }
                                                                        } ?>>41-50 (%)</option>
                                                                            <option value="51-60" <?php if (isset($m_export['export_percentage'])) {
                                                                            if ($m_export['export_percentage'] == '51-60') {
                                                                                echo 'selected=selected';
                                                                            }
                                                                        } ?>>51-60 (%)</option>
                                                                            <option value="61-70" <?php if (isset($m_export['export_percentage'])) {
                                                                            if ($m_export['export_percentage'] == '61-70') {
                                                                                echo 'selected=selected';
                                                                            }
                                                                        } ?>>61-70 (%)</option>
                                                                            <option value="71-80" <?php if (isset($m_export['export_percentage'])) {
                                                                            if ($m_export['export_percentage'] == '71-80') {
                                                                                echo 'selected=selected';
                                                                            }
                                                                        } ?>>71-80 (%)</option>
                                                                            <option value="81-90" <?php if (isset($m_export['export_percentage'])) {
                                                                            if ($m_export['export_percentage'] == '81-90') {
                                                                                echo 'selected=selected';
                                                                            }
                                                                        } ?>>81-90 (%)</option>
                                                                            <option value="91-100" <?php if (isset($m_export['export_percentage'])) {
                                                                            if ($m_export['export_percentage'] == '91-100') {
                                                                                echo 'selected=selected';
                                                                            }
                                                                        } ?>>91-100 (%)</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group row">
                                                                    <label class="col-sm-3 col-form-label">Main Markets and Distribution:</label>
                                                                    <div class="col-sm-9">


                                                                    </div> 
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row" style="margin-top: -60px;margin-bottom: 15px;">
                                                            <label class="col-sm-2"></label>
                                                            <div class="col-sm-10">
                                                                <div class="row">
<?php
foreach ($mar_dist as $dist) {
    ?>
                                                                        <div class="col-md-4 col-sm-4 row">
                                                                            <input type="text" name="market_dist_value[]" class="form-control" placeholder="0" value="<?php echo $dist['market_dist_value']; ?>" style="width:50px; margin-bottom:5px;">
                                                                            <span style="padding:0px 5px;">%</span>
                                                                            <span><input type="hidden" name="market_dist_id[]" value="<?php echo $dist['id']; ?>"><?php echo $dist['m_name']; ?></span>
                                                                        </div>
<?php }
?> 
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label class="col-sm-2 col-form-label">Year when your company started exporting:</label>
                                                            <div class="col-sm-4">
                                                                <select id="trade-export-rate" class="form-control" name="company_started_exporting">
                                                                    <option value="">--- Please select ---</option>
<?php
$y = date('Y');
while ($y >= 1800) {
    ?>
                                                                        <option value="<?php echo $y; ?>" <?php if ($m_export['company_started_exporting'] == $y) {
        echo "selected=selected";
    } ?>><?php echo $y; ?></option>
    <?php
    $y--;
}
?>
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
                                                        <div class="row" id="customer_case_wrapper">

                                                            <div class="col-sm-12">
                                                                <table class="table table-responsive table-bordered">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>
                                                                                Host/Customer Name
                                                                            </th>
                                                                            <th>
                                                                                Country/Region
                                                                            </th>
                                                                            <th>
                                                                                Supply To Customer
                                                                            </th>
                                                                            <th>
                                                                                Annual Turnover
                                                                            </th>
                                                                            <th>
                                                                                Corporation Photo
                                                                            </th>
                                                                            <th>
                                                                                Transaction Doc
                                                                            </th>
                                                                            <th>
                                                                                Action
                                                                            </th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody class="appendDynaRow" >
<?php
if (isset($cust_case)) {
    foreach ($cust_case as $ca) {
        ?>
                                                                                <tr>
                                                                                    <td>
                                                                                        <input type="text" class="form-control" name="customer_name[]" value="<?php echo $ca['customer_name']; ?>">
                                                                                    </td>
                                                                                    <td>
                                                                                        <select name="country_region[]" class="form-control">
        <?php
        foreach ($country as $con) {
            ?>
                                                                                                <option value="<?php echo $con['id']; ?>" <?php if ($ca['country_region'] == $con['id']) {
                                                                                        echo 'selected=selected';
                                                                                    } ?>><?php echo ucfirst(strtolower($con['name'])); ?></option>
                                                                                            <?php }
                                                                                            ?>
                                                                                        </select>
                                                                                    </td>
                                                                                    <td>
                                                                                        <input type="text" class="form-control" name="products_supply[]" value="<?php echo $ca['products_supply']; ?>">
                                                                                    </td>
                                                                                    <td>
                                                                                        <input type="text" class="form-control" name="annual_turnover[]" value="<?php echo $ca['annual_turnover']; ?>">
                                                                                    </td>
                                                                                    <td>
                                                                                        <img src="<?php echo $ca['corperation_photos']; ?>" style="width:50px">
                                                                                        <input type="file" class="form-control" name="corperation_photos[]">
                                                                                        <input type="hidden" name="corporation_image[]" value="<?php echo $ca['corperation_photos']; ?>">
                                                                                    </td>
                                                                                    <td>
                                                                                        <img src="<?php echo $ca['transaction_documents']; ?>" style="width:50px">
                                                                                        <input type="file" class="form-control" name="transaction_documents[]">
                                                                                        <input type="hidden" name="transaction_image[]" value="<?php echo $ca['transaction_documents']; ?>">
                                                                                    </td>								
                                                                                    <td>
                                                                                        <div class="addDeleteButton">
                                                                                            <span class="tooltips addDynaRow" title="Add" style="cursor: pointer;">
                                                                                                <i class="fa fa-plus"></i>
                                                                                            </span>&nbsp;&nbsp;&nbsp;

                                                                                        </div>
                                                                                    </td>
                                                                                </tr>
    <?php
    }
} else {
    ?>
                                                                            <tr>
                                                                                <td>
                                                                                    <input type="text" class="form-control" name="customer_name[]" value="">
                                                                                </td>
                                                                                <td>
                                                                                    <select name="country_region[]" class="form-control">
    <?php
    foreach ($country as $con) {
        ?>
                                                                                            <option value="<?php echo $con['id']; ?>"><?php echo ucfirst(strtolower($con['name'])); ?></option>
    <?php }
    ?>
                                                                                    </select>
                                                                                </td>
                                                                                <td>
                                                                                    <input type="text" class="form-control" name="products_supply[]" value="">
                                                                                </td>
                                                                                <td>
                                                                                    <input type="text" class="form-control" name="annual_turnover[]" value="">
                                                                                </td>
                                                                                <td>
                                                                                    <input type="file" class="form-control" name="corperation_photos[]" value="">
                                                                                </td>
                                                                                <td>
                                                                                    <input type="file" class="form-control" name="transaction_documents[]" value="">
                                                                                </td>								
                                                                                <td>
                                                                                    <div class="addDeleteButton">
                                                                                        <span class="tooltips addDynaRow" title="Add" style="cursor: pointer;">
                                                                                            <i class="fa fa-plus"></i>
                                                                                        </span>&nbsp;&nbsp;&nbsp;

                                                                                    </div>
                                                                                </td>
                                                                            </tr>
<?php } ?>

                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>

                                                        <div class="form-group row">
                                                            <label class="col-sm-2 col-form-label">No. of Employees in Trade Department:</label>
                                                            <div class="col-sm-5">
                                                                <select name="no_of_employee" class="form-control">
                                                                    <option value="">--- Please select ---</option> 
                                                                    <option value="Fewer than 5">Fewer than 5 People</option>
                                                                    <option value="5-10" <?php if ($m_export['no_of_employee'] == '5-10') {
    echo'selected=selected';
} ?> >5-10 People</option>
                                                                    <option value="11-50" <?php if ($m_export['no_of_employee'] == '11-50') {
    echo'selected=selected';
} ?>>11-50 People</option>
                                                                    <option value="51-100" <?php if ($m_export['no_of_employee'] == '51-100') {
    echo'selected=selected';
} ?>>51-100 People</option>
                                                                    <option value="101-200" <?php if ($m_export['no_of_employee'] == '101-200') {
    echo'selected=selected';
} ?>>101-200 People</option>
                                                                    <option value="201-300" <?php if ($m_export['no_of_employee'] == '201-300') {
    echo'selected=selected';
} ?>>201-300 People</option>
                                                                    <option value="301-500" <?php if ($m_export['no_of_employee'] == '301-500') {
    echo'selected=selected';
} ?>>301-500 People</option>
                                                                    <option value="501-1000" <?php if ($m_export['no_of_employee'] == '501-1000') {
    echo'selected=selected';
} ?>>501-1000 People</option>
                                                                    <option value="Above 1000" <?php if ($m_export['no_of_employee'] == 'Above 1000') {
    echo'selected=selected';
} ?>>Above 1000 People</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label class="col-sm-2 col-form-label">Nearest Port:</label>
                                                            <div class="col-sm-3">
                                                                <input type="text" name="nearest_port1" class="form-control" placeholder="" value="<?php echo $m_export['nearest_port1']; ?>">
                                                            </div>
                                                            <div class="col-sm-3">
                                                                <input type="text" name="nearest_port2" class="form-control" placeholder="" value="<?php echo $m_export['nearest_port2']; ?>">
                                                            </div>
                                                            <div class="col-sm-3">
                                                                <input type="text" name="nearest_port3" class="form-control" placeholder="" value="<?php echo $m_export['nearest_port3']; ?>">
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label class="col-sm-2 col-form-label">Average Lead Time:</label>
                                                            <div class="col-sm-3">
                                                                <input type="text" name="average_lead_time" class="form-control" placeholder="" value="<?php echo $m_export['average_lead_time']; ?>"> 
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label class="col-sm-2 col-form-label">Does your company have an overseas office?</label>
                                                            <div class="col-sm-10">
                                                                <select name="does_your_company" class="form-control" id="company_overseas">
                                                                    <option value="NO" <?php if ($m_export['does_your_company'] == 'NO') {
                                                                            echo 'selected=selected';
                                                                        } ?> >NO</option>
                                                                    <option value="YES" <?php if ($m_export['does_your_company'] == 'YES') {
                                                                            echo 'selected=selected';
                                                                        } ?>>YES</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="row" id="company_wrapper">  

                                                            <div class="col-sm-12">
                                                                <table class="table table-responsive table-bordered">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>
                                                                                Country/Region
                                                                            </th>
                                                                            <th>
                                                                                Address
                                                                            </th>
                                                                            <th>
                                                                                Telephone
                                                                            </th>
                                                                            <th>
                                                                                Dutiees
                                                                            </th>
                                                                            <th>
                                                                                Person Charge
                                                                            </th>
                                                                            <th>
                                                                                No. of Staff
                                                                            </th>
                                                                            <th>
                                                                                Lease Certification
                                                                            </th>
                                                                            <th>
                                                                                Office Photos
                                                                            </th>
                                                                            <th>
                                                                                Action
                                                                            </th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody class="appendDynaRow" >
                                                                        <?php
                                                                        if (isset($overseas_office)) {
                                                                            foreach ($overseas_office as $office) {
                                                                                ?>
                                                                                <tr>
                                                                                    <td>
                                                                                        <select name="overseas_country_region[]" class="form-control">
        <?php
        foreach ($country as $con) {
            ?>
                                                                                                <option value="<?php echo $con['id']; ?>" <?php if ($office['overseas_country_region'] == $con['id']) {
                echo 'selected=selected';
            } ?>><?php echo ucfirst(strtolower($con['name'])); ?></option>
        <?php }
        ?>
                                                                                        </select>
                                                                                    </td>
                                                                                    <td>
                                                                                        <input type="text" class="form-control" name="overseas_address[]" value="<?php echo $office['overseas_address']; ?>">
                                                                                    </td>
                                                                                    <td>
                                                                                        <input type="text" class="form-control" name="overseas_telephone[]" value="<?php echo $office['overseas_telephone']; ?>">
                                                                                    </td>
                                                                                    <td>
                                                                                        <select name="overseas_duties[]" class="form-control">
                                                                                            <option value="">Please select:</option>
                                                                                            <option value="Sale" <?php if ($office['overseas_duties'] == 'Sales') {
            echo'selected=selected';
        } ?>>Sale</option>
                                                                                            <option value="After sale Service" <?php if ($office['overseas_duties'] == 'After sale Service') {
            echo'selected=selected';
        } ?>>After sale Service</option>
                                                                                            <option value="Other" <?php if ($office['overseas_duties'] == 'Other') {
            echo'selected=selected';
        } ?>>Other</option>
                                                                                        </select>
                                                                                    </td>
                                                                                    <td>
                                                                                        <input type="text" class="form-control" name="overseas_person_charge[]" value="<?php echo $office['overseas_person_charge']; ?>">
                                                                                    </td>	
                                                                                    <td>

                                                                                        <input type="text" class="form-control" name="no_of_staff[]" value="<?php echo $office['no_of_staff']; ?>">

                                                                                    </td>
                                                                                    <td>
                                                                                        <img src="<?php echo $office['lease_certification']; ?>" style="width:50px;">
                                                                                        <input type="file" class="form-control" name="lease_certification[]" value="">
                                                                                        <input type="hidden" name="lease_image" value="<?php echo $office['lease_certification']; ?>">
                                                                                    </td>
                                                                                    <td>
                                                                                        <img src="<?php echo $office['office_photo']; ?>" style="width:50px;">
                                                                                        <input type="file" class="form-control" name="office_photo[]" value="">
                                                                                        <input type="hidden" name="office_image[]" value="<?php echo $office['office_photo']; ?>">
                                                                                    </td>																	
                                                                                    <td> 
                                                                                        <div class="addDeleteButton">
                                                                                            <span class="tooltips addDynaRow" title="Add" style="cursor: pointer;">
                                                                                                <i class="fa fa-plus"></i>
                                                                                            </span>&nbsp;&nbsp;&nbsp;

                                                                                        </div>
                                                                                    </td>
                                                                                </tr>
    <?php
    }
} else {
    ?>
                                                                            <tr>
                                                                                <td>
                                                                                    <select name="overseas_country_region[]" class="form-control">
    <?php
    foreach ($country as $con) {
        ?>
                                                                                            <option value="<?php echo $con['id']; ?>"><?php echo ucfirst(strtolower($con['name'])); ?></option>
    <?php }
    ?>
                                                                                    </select>
                                                                                </td>
                                                                                <td>
                                                                                    <input type="text" class="form-control" name="overseas_address[]" value="">
                                                                                </td>
                                                                                <td> 
                                                                                    <input type="text" class="form-control" name="overseas_telephone[]" value="">
                                                                                </td>
                                                                                <td>
                                                                                    <select name="overseas_duties[]" class="form-control">
                                                                                        <option value="">Please select:</option>
                                                                                        <option value="Sale">Sale</option>
                                                                                        <option value="After sale Service">After sale Service</option>
                                                                                        <option value="Other">Other</option>
                                                                                    </select>
                                                                                </td>
                                                                                <td>
                                                                                    <input type="text" class="form-control" name="overseas_person_charge[]" value="">
                                                                                </td>	
                                                                                <td>
                                                                                    <input type="text" class="form-control" name="no_of_staff[]" value="">
                                                                                </td>
                                                                                <td>
                                                                                    <input type="file" class="form-control" name="lease_certification[]" value="">
                                                                                </td>
                                                                                <td>
                                                                                    <input type="file" class="form-control" name="office_photo[]" value="">
                                                                                </td>																	
                                                                                <td>
                                                                                    <div class="addDeleteButton">
                                                                                        <span class="tooltips addDynaRow" title="Add" style="cursor: pointer;">
                                                                                            <i class="fa fa-plus"></i>
                                                                                        </span>&nbsp;&nbsp;&nbsp;

                                                                                    </div>
                                                                                </td>
                                                                            </tr>
<?php } ?>


                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label class="col-sm-2 col-form-label">Accepted Delivery Terms:</label>
                                                            <div class="col-sm-9 row">
                                                                <div class="col-sm-10">
                                                                    <div class="border-checkbox-section">
<?php
$k = 5;
foreach ($del_term as $term) {
    ?>
                                                                            <div class="border-checkbox-group border-checkbox-group-primary">

                                                                                <input class="border-checkbox" type="checkbox" name="accepted_delivery_term[]" <?php if ($term['id'] == $term['terms_id']) {
        echo'checked';
    } ?> value="<?php echo $term['id']; ?>" id="checkbox<?php echo $k; ?>"> 
                                                                                <label class="border-checkbox-label" for="checkbox<?php echo $k; ?>"><?php echo $term['term']; ?></label>
                                                                            </div>
    <?php $k++;
}
?>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label class="col-sm-2 col-form-label">Accepted Payment Currency:</label>
                                                            <div class="col-sm-9 row">
                                                                <div class="col-sm-10">
                                                                    <div class="border-checkbox-section">
<?php
$k = 15;
foreach ($acc_currency as $curr) {
    ?>
                                                                            <div class="border-checkbox-group border-checkbox-group-primary">
                                                                                <input class="border-checkbox" <?php if ($curr['id'] == $curr['curr_id']) {
        echo'checked';
    } ?> type="checkbox" name="accepted_currency[]" value="<?php echo $curr['id']; ?>" id="checkbox<?php echo $k; ?>">
                                                                                <label class="border-checkbox-label" for="checkbox<?php echo $k; ?>"><?php echo $curr['currency']; ?></label>
                                                                            </div>
    <?php $k++;
}
?>
                                                                    </div>
                                                                </div>

                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label class="col-sm-2 col-form-label">Accepted Payment Type:</label>
                                                            <div class="col-sm-9 row">
                                                                <div class="col-sm-10">
                                                                    <div class="border-checkbox-section">
<?php
$k = 25;
foreach ($acc_payment as $pay) {
    ?> 
                                                                            <div class="border-checkbox-group border-checkbox-group-primary">
                                                                                <input class="border-checkbox" type="checkbox" <?php if ($pay['id'] == $pay['pay_id']) {
        echo'checked';
    } ?> name="acc_payment_type[]" value="<?php echo $pay['id']; ?>" id="checkbox<?php echo $k; ?>">
                                                                                <label class="border-checkbox-label" for="checkbox<?php echo $k; ?>"><?php echo $pay['pay_type']; ?></label>
                                                                            </div>
    <?php $k++;
}
?>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label class="col-sm-2 col-form-label">Language Spoken:</label>
                                                            <div class="col-sm-9 row">
                                                                <div class="col-sm-10">
                                                                    <div class="border-checkbox-section">
<?php
$k = 35;
foreach ($language_spoken as $spoke) {
    ?>
                                                                            <div class="border-checkbox-group border-checkbox-group-primary"> 
                                                                                <input class="border-checkbox" <?php if ($spoke['id'] == $spoke['lang_id']) {
        echo'checked';
    } ?> type="checkbox" name="mlanguage_spoken[]" value="<?php echo $spoke['id']; ?>" id="checkbox<?php echo $k; ?>">
                                                                                <label class="border-checkbox-label" for="checkbox<?php echo $k; ?>"><?php echo $spoke['language']; ?></label>
                                                                            </div>
    <?php $k++;
}
?>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="j-footer">
                                                            <button type="submit" class="btn btn-primary pull-right">Save</button>
                                                        </div>
                                                    </form>
                                                </div>
                                                <div class="tab-pane" id="seller" role="tabpanel">
                                                    <form action="<?php echo base_url() . $action_company_info; ?>" method="POST" enctype="multipart/form-data">
                                                        <div class="row" id="">

                                                            <div class="col-md-2"></div>
                                                            <div class="col-md-7 col-sm-7 col-xs-12 bd1px" >
                                                                <div class="form-group row">
                                                                    <label class="col-sm-3 col-form-label">Company Logo:</label>
                                                                    <div class="col-sm-8">
                                                                        <input type="file" name="company_logo" class="form-control">
                                                                        <input type="hidden" name="company_logo_image" value="<?php if (isset($comp_info['company_logo'])) {
    echo $comp_info['company_logo'];
} ?>">
                                                                        <img src="<?php echo $comp_info['company_logo'] ?>" style="width:50px;">
                                                                    </div>
                                                                </div>
                                                                <div class="form-group row">
                                                                    <label class="col-sm-3 col-form-label">Detailed Company Introduction:</label>
                                                                    <div class="col-sm-8">																<textarea type="text" name="company_detailed" cols="5" id="comp_advantages" class="form-control" placeholder="Detailed Company "><?php if (isset($comp_info['company_logo'])) {
    echo $comp_info['company_detailed'];
} ?></textarea>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group row">
                                                                    <label class="col-sm-3 col-form-label">Company Photo:</label>
                                                                    <div class="col-sm-8">
                                                                        <input type="file" name="company_photo" class="form-control">
                                                                        <input type="hidden" name="company_photo_image" value="<?php if (isset($comp_info['company_photo'])) {
    echo $comp_info['company_photo'];
} ?>">
                                                                        <img src="<?php echo $comp_info['company_photo'] ?>" style="width:50px;">
                                                                    </div> 
                                                                </div>
                                                                <div class="j-footer">
                                                                    <button type="submit" class="btn btn-primary pull-right">Save</button>
                                                                </div>
                                                            </div>


                                                        </div>
                                                    </form>


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

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
<?php $this->load->view("user/common/footer"); ?>
                    <script>
                        $(document).on('click', '.addDynaRow', function () {
                            var clonedRow = $(this).closest('tbody.appendDynaRow').find('tr:first').clone();
                            clonedRow.find('select').val('');
                            clonedRow.find('input').val('');
                            clonedRow.find('input').removeAttr('readonly');

                            clonedRow.find('div.addDeleteButton').each(function (index) {
                                if ($(this).find('span.deleteParticularRow').length == 0 && $(this).find('span.deleteRow').length == 0) {
                                    $(this).append('<span class="tooltips deleteParticularRow" data-placement="top" data-original-title="Remove" style="cursor: pointer;">' +
                                            '<i class="fa fa-trash-o"></i>' +
                                            '</span>');
                                }
                            });

                            clonedRow.find('span.deleteRow').removeClass('deleteRow').addClass('deleteParticularRow').removeAttr('rev rel');

                            $(this).closest('tbody.appendDynaRow').append(clonedRow);

                        });

                        $(document).on('click', '.deleteParticularRow', function () {
                            $(this).closest('tr').remove();
                        });

                    </script>