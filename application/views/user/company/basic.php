<form action="<?php echo site_url(); ?>seller/companyprofile" method="post" id="form_basic_company_details">
    <input type="hidden" name="com" value="<?php echo $company->pcompany_id;?>">
    <div class="form-group row">
        <label class="col-sm-3 col-form-label">Company Name <span class="text-danger">*</span></label>
        <div class="col-sm-6">
            <input type="text" name="company_name" id="company_name" 
                   class="form-control" placeholder="Company Name" 
                   value="<?php echo $company->company_name; ?>">
            <?php echo form_error("company_name");?>
        </div>
    </div>

    <div class="form-group row">
        <label class="col-sm-3 col-form-label">Company Registered Year <span class="text-danger">*</span></label>
        <div class="col-sm-6">
            <?php echo form_dropdown('registration_year', $years, 
            $company->year_of_register, "class='form-control'"); ?>
        </div>
    </div>

    <h4 class="sub-title text-primary">Location Of Registration</h4>

    <div class="form-group row">
        <label class="col-sm-3 col-form-label">Country <span class="text-danger">*</span></label>
        <div class="col-sm-6">
            <input type="text" name="registered_country" id="location_state_country" 
                   class="form-control" placeholder="Country" 
                   value="<?php echo $company->location_country; ?>">
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-3 col-form-label">State<span class="text-danger">*</span></label>
        <div class="col-sm-6">
            <input type="text" name="registered_state" id="registered_state" 
                   class="form-control" placeholder="State" 
                   value="<?php echo $company->registration_state; ?>">
        </div>
    </div>

    <h4 class="sub-title text-primary">Company operational address</h4>

    <div class="form-group row">
        <label class="col-sm-3 col-form-label">Street <span class="text-danger">*</span></label>
        <div class="col-sm-6">
            <input type="text" name="comp_operational_addr" id="comp_operational_addr" 
                   class="form-control" placeholder="Street" 
                   value="<?php echo $company->comp_operational_addr; ?>">
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-3 col-form-label">City <span class="text-danger">*</span></label>
        <div class="col-sm-6">
            <input type="text" name="comp_operational_city" id="comp_operational_city" 
                   class="form-control" placeholder="City" 
                   value="<?php echo $company->comp_operational_city; ?>">
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-3 col-form-label">Province/State/County <span class="text-danger">*</span></label>
        <div class="col-sm-6">
            <input type="text" name="comp_operational_state" id="comp_operational_state" 
                   class="form-control" placeholder="Province/State/County" 
                   value="<?php echo $company->comp_operational_state; ?>">
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-3 col-form-label">Country/Region <span class="text-danger">*</span></label>
        <div class="col-sm-6">
            <input type="text" name="comp_operational_region" id="comp_operational_region" 
                   class="form-control" placeholder="Country/Region" 
                   value="<?php echo $company->comp_operational_region; ?>">
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-3 col-form-label">Zip/Postal Code <span class="text-danger">*</span></label>
        <div class="col-sm-6">
            <input type="text" name="comp_operational_zip_code" id="comp_operational_zip_code" 
                   class="form-control" placeholder="Zip/Postal Code" 
                   value="<?php echo $company->comp_operational_zip_code; ?>">
        </div>
    </div>

    <h4 class="sub-title text-primary">Products</h4>

	<div class="form-group row">
        <?php 
            $tmp_products = json_decode($company->main_products); 
            if(!is_array($tmp_products)){
                $tmp_products = [
					0 => "",
					1 => "",
					2 => "",
					3 => "",
					4 => "",
					5 => "",
					6 => "",
				];
            }   
        ?>
        <label class="col-sm-3 col-form-label">Main Products</label>
        <div class="col-sm-9">
            <div class="row">
                <div class="col-md-2">
                    <input type="text" class="form-control" name="products[]"
                           value="<?php echo $tmp_products[0]; ?>">
                </div>
                <div class="col-md-2">
                    <input type="text" class="form-control" name="products[]"
                           value="<?php echo $tmp_products[1]; ?>">
                </div>
                <div class="col-md-2">
                    <input type="text" class="form-control" name="products[]"
                           value="<?php echo $tmp_products[2]; ?>">
                </div>
                <div class="col-md-2">
                    <input type="text" class="form-control" name="products[]"
                           value="<?php echo $tmp_products[3]; ?>">
                </div>
                <div class="col-md-2">
                    <input type="text" class="form-control" name="products[]"
                           value="<?php echo $tmp_products[4]; ?>">
                </div>
            </div>
            <p class="text-muted">One product each box</p>
            <hr />
        </div>
    </div>
    
	<div class="form-group row">
        <?php 
			$tmp_otherproducts = json_decode($company->other_products);
			if(!is_array($tmp_otherproducts)){
                $tmp_otherproducts = [
					0 => "",
					1 => "",
					2 => "",
					3 => "",
					4 => "",
					5 => "",
					6 => "",
					7 => "",
					8 => "",
					9 => "",
				];
            }  	
		?>
        <label class="col-sm-3 col-form-label">Other Products</label>
        <div class="col-sm-9">
            <div class="row">
                <div class="col-md-2">
                    <input type="text" class="form-control" name="oproducts[]"
                           value="<?php echo $tmp_otherproducts[0]; ?>">
                </div>
                <div class="col-md-2">
                    <input type="text" class="form-control" name="oproducts[]"
                           value="<?php echo $tmp_otherproducts[1]; ?>">
                </div>
                <div class="col-md-2">
                    <input type="text" class="form-control" name="oproducts[]"
                           value="<?php echo $tmp_otherproducts[2]; ?>">
                </div>
                <div class="col-md-2">
                    <input type="text" class="form-control" name="oproducts[]"
                           value="<?php echo $tmp_otherproducts[3]; ?>">
                </div>
                <div class="col-md-2">
                    <input type="text" class="form-control" name="oproducts[]"
                           value="<?php echo $tmp_otherproducts[4]; ?>">
                </div>

            </div>
            <br />
            <div class="row">
                <div class="col-md-2">
                    <input type="text" class="form-control" name="oproducts[]"
                           value="<?php echo $tmp_otherproducts[5]; ?>">
                </div>
                <div class="col-md-2">
                    <input type="text" class="form-control" name="oproducts[]"
                           value="<?php echo $tmp_otherproducts[6]; ?>">
                </div>
                <div class="col-md-2">
                    <input type="text" class="form-control" name="oproducts[]"
                           value="<?php echo $tmp_otherproducts[7]; ?>">
                </div>
                <div class="col-md-2">
                    <input type="text" class="form-control" name="oproducts[]"
                           value="<?php echo $tmp_otherproducts[8]; ?>">
                </div>
                <div class="col-md-2">
                    <input type="text" class="form-control" name="oproducts[]"
                           value="<?php echo $tmp_otherproducts[9]; ?>">
                </div>
            </div>
            <p class="text-muted">One product each box</p>
        </div>

    </div>
    	
    <h4 class="sub-title text-primary">Other Basics </h4>

    <div class="form-group row">
        <label class="control-label col-md-3">Number of Employees <span class="text-danger">*</span></label>
        <div class="col-md-6">
            <?php echo form_dropdown("employee_count", $no_of_employees, $company->no_of_employee, "class='form-control'");
            ?>
        </div>
    </div>
    <div class="form-group row">
        <label class="control-label col-md-3">Office Size <span class="text-danger">*</span></label>
        <div class="col-md-6">
            <?php echo form_dropdown("office_size", $office_size, $company->office_size, "class='form-control'");
            ?>
        </div>
    </div>
    <div class="form-group row">
        <label class="control-label col-md-3">Website URL</label>
        <div class="col-md-6">
            <input type="text" class="form-control" name="website_url" 
                   placeholder="http://" value="<?php echo $company->company_url; ?>">
        </div>
    </div>
    <div class="form-group row">
        <label class="control-label col-md-3">Legal Owner <span class="text-danger">*</span></label>
        <div class="col-md-6">
            <input type="text" class="form-control" name="legal_owner" 
                   placeholder="" value="<?php echo $company->legal_owner; ?>">
        </div>
    </div>
    <div class="form-group row">
        <label class="control-label col-md-3">Company Advantages <span class="text-danger">*</span></label>
        <div class="col-md-6">
            <textarea class="form-control" rows="5" name="company_advantage"><?php echo $company->comp_advantages; ?></textarea>
            <p class="text-muted">Please briefly describe company advantages, for eg "we
                have 10 years of experience ..."</p>
        </div>
    </div>

    <button type="submit" class="btn btn-info pull-right">Submit</button>

</form>