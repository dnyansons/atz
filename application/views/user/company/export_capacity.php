<form action="<?php echo site_url(); ?>seller/companyprofile/export_capacity" method="post"  enctype="multipart/form-data">
<input type="hidden" name="com" value="<?php echo $company->pcompany_id;?>">
    <div class="form-group row">
        <label class="col-sm-3 col-form-label">Total Annual Revenue</label>
        <div class="col-sm-6">
            <select name="annual_revenue" class="form-control" >
				<option value = "Below US$1 Million" <?php echo $company->annual_revenue == "Below US$1 Million" ? "selected=selected" : "";?>>Below US$1 Million</option>
				<option value = "US$1 Million - US$2.5 Million" <?php echo $company->annual_revenue == "US$1 Million - US$2.5 Million" ? "selected=selected" : "";?>>US$1 Million - US$2.5 Million</option>
				<option value = "US$2.5 Million - US$5 Million" <?php echo $company->annual_revenue == "US$2.5 Million - US$5 Million" ? "selected=selected" : "";?>>US$2.5 Million - US$5 Million</option>
				<option value = "US$5 Million - US$10 Million" <?php echo $company->annual_revenue == "US$5 Million - US$10 Million" ? "selected=selected" : "";?>>US$5 Million - US$10 Million</option>
				<option value = "US$10 Million - US$50 Million"<?php echo $company->annual_revenue == "US$10 Million - US$50 Million" ? "selected=selected" : "";?>>US$10 Million - US$50 Million</option>
				<option value = "US$50 Million - US$100 Million"<?php echo $company->annual_revenue == "US$50 Million - US$100 Million" ? "selected=selected" : "";?>>US$50 Million - US$100 Million</option>
				<option value = "Above US$100 Million" <?php echo $company->annual_revenue == "Above US$100 Million" ? "selected=selected" : "";?>>Above US$100 Million</option>
			</select>
        </div>
    </div>

    <div class="form-group row">
        <label class="col-sm-3 col-form-label">Export Percentage</label>
        <div class="col-sm-6">
			<select name="export_percentage" class="form-control">
				<option value = "1% - 10% " <?php echo $company->export_percentage == "1% - 10%" ? "selected=selected" : "";?>>1% - 10% </option>
				<option value = "11% - 20%" <?php echo $company->export_percentage == "11% - 20%" ? "selected=selected" : "";?>>11% - 20%</option>
				<option value = "21% - 30%" <?php echo $company->export_percentage == "21% - 30%" ? "selected=selected" : "";?>>21% - 30%</option>
				<option value = "31% - 40%" <?php echo $company->export_percentage == "31% - 40%" ? "selected=selected" : "";?>>31% - 40% </option>
				<option value = "41% - 50%" <?php echo $company->export_percentage == "41% - 50%" ? "selected=selected" : "";?>>41% - 50% </option>
				<option value = "51% - 60%" <?php echo $company->export_percentage == "51% - 60%" ? "selected=selected" : "";?>>51% - 60% </option>
				<option value = "61% - 70%" <?php echo $company->export_percentage == "61% - 70%" ? "selected=selected" : "";?>>61% - 70%</option>
				<option value = "71% - 80%" <?php echo $company->export_percentage == "71% - 80%" ? "selected=selected" : "";?>>71% - 80%</option>
				<option value = "81% - 90%" <?php echo $company->export_percentage == "81% - 90%" ? "selected=selected" : "";?>>81% - 90%</option>
				<option value = "91% - 100%" <?php echo $company->export_percentage == "91% - 100%" ? "selected=selected" : "";?>>91% - 100%</option>
				
				
			</select>
        </div>
    </div>

    <div class="form-group row">
        <label class="col-sm-3 col-form-label">Main Markets and Distribution</label>
        <div class="col-sm-6">
            <input type="text" name="main_markets_distribution" id="location_state_country" 
                   class="form-control" placeholder="Province/State" 
                   value="<?php echo $company->registration_state; ?>">
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-3 col-form-label"></label>
        <div class="col-sm-6">
				
        </div>
    </div>

    <div class="form-group row">
        <label class="col-sm-3 col-form-label">Year when your company started exporting</label>
        <div class="col-sm-6">
			<select name="export_started_year" class="form-control">
            <?php 
					 $tmp_years = range(1800,date("Y"));
					$years = [];
					foreach($tmp_years as $key=>$val){ 
					if($company->export_started_year == $val){
					?>
					<option value="<?php echo $val; ?>" selected><?php echo $val; ?></option>
			<?php  }else{ ?>
					<option value="<?php echo $val; ?>"><?php echo $val; ?></option>
					<?php  } }?>
			</select>
        </div>
    </div>
	
	 <div class="form-group row">
        <label class="col-sm-3 col-form-label">Whether add customer case</label>
		 <?php 
            $yes = "";
            $no = "checked";
            $display = false;
            if($company->Whether_customer_case == 1){
                $no = "";
                $yes = "checked";
                $Whether_customer_case = true;
            }?>
        <label class="col-sm-8" style="margin-left:18px;"><input class="form-check-input" type="radio" name="is_customer_case" id="is_customer_case_1" value="1" <?php echo $yes;?>> Yes</label>
		<label class="col-sm-3 col-form-label"></label>  
	    <label class="col-sm-6 " style="margin-left:18px;"> <input class="form-check-input" type="radio" name="is_customer_case" id="is_customer_case_2" value="0" <?php echo $no;?>"> No</label>
    </div>
	<div class="customer_case_container" id="customer_case_container" <?php if(!$Whether_customer_case){ echo "style='display:none'";}?> >
		  <?php 
        $customer_case = json_decode($company->Whether_customer_case_details);
        if(count($customer_case) > 0 ){
            foreach($customer_case as $customer):?>
		<div class="row dyn_customer_case_container_row" >
			<label class="col-sm-3 col-form-label"> </label>
			<div class="col-sm-6">
				<div class="well">
					<div class="form-group row">
						<label class="col-sm-5 col-form-label">Project/customer name</label>
						<div class="col-sm-6">
							<input type="text" name="project_customer[]" class="form-control" value="<?php echo $customer->project_customer;?>">
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-5 col-form-label">Customers Country/Region</label>
						<div class="col-sm-6">
							<select name="customer_country[]" class="form-control">
							<?php foreach($country as $row){ 
								if($customer->customer_country == $row['id']){ ?>
									<option value= "<?php echo $row['id']; ?>" selected><?php echo $row['name']; ?></option>
									
								<?php }else{ ?>
								
									 <option value= "<?php echo $row['id']; ?>" ><?php echo $row['name']; ?></option>
									 
								<?php }} ?>
							</select>
						</div>
					</div>
					 <div class="form-group row">
						<label class="col-sm-5 col-form-label">Products You Supply To Customer</label>
						<div class="col-sm-6">
							<input type="text_box" name="supply_product_name[]" class="form-control" value="<?php echo $customer->supply_product_name;?>">
						</div>
					</div>
					 <div class="form-group row">
						<label class="col-sm-5 col-form-label">Annual Turnover</label>
						<div class="col-sm-6">
							<input type="text_box" name="anual_turn_over[]" class="form-control" value="<?php echo $customer->anual_turn_over;?>">
						</div>
					</div>
					 <div class="form-group row">
						<label class="col-sm-5 col-form-label">Cooperation photos</label>
						<div class="col-sm-6">
							<input type="file" name="cooperation_photo[]" class="form-control" >
							<input type="hidden" name="cooperation_photo_old[]" value="<?php echo $customer->cooperation_photo;?>" >
						</div>
					</div>
					 <div class="form-group row">
						<label class="col-sm-5 col-form-label">Transaction Documents</label>
						<div class="col-sm-6">
							<input type="file" name="transction_doc[]" class="form-control" >
							<input type="hidden" name="transction_doc_old[]" value="<?php echo $customer->transction_doc;?>" >
						</div>
					</div>
				  
				</div>
			</div>
			<div class="col-md-2">
				<button class="btn btn-primary btn-outline-primary btn-icon btn_customer_case_elem" type="button"><i class="icofont icofont-plus"></i></button>
				<button class="btn btn-primary btn-outline-danger btn-icon btn_remove_customer_case_elem" type="button"><i class="fa fa-remove"></i></button>
			</div>
		</div>
	 <?php 
        endforeach;
        } else { ?>
		<div class="row dyn_customer_case_container_row" >
			<label class="col-sm-3 col-form-label"> </label>
			<div class="col-sm-6">
				<div class="well">
					<div class="form-group row">
						<label class="col-sm-5 col-form-label">Project/customer name</label>
						<div class="col-sm-6">
							<input type="text" name="project_customer[]" class="form-control">
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-5 col-form-label">Customers Country/Region</label>
						<div class="col-sm-6">
							<select name="customer_country[]" class="form-control">
							<?php foreach($country as $row){ ?>
									<option value= "<?php echo $row['id']; ?>" ><?php echo $row['name']; ?></option>
							<?php } ?>
							</select>
						</div>
					</div>
					 <div class="form-group row">
						<label class="col-sm-5 col-form-label">Products You Supply To Customer</label>
						<div class="col-sm-6">
							<input type="text_box" name="supply_product_name[]" class="form-control" >
						</div>
					</div>
					 <div class="form-group row">
						<label class="col-sm-5 col-form-label">Annual Turnover</label>
						<div class="col-sm-6">
							<input type="text_box" name="anual_turn_over[]" class="form-control" >
						</div>
					</div>
					 <div class="form-group row">
						<label class="col-sm-5 col-form-label">Cooperation photos</label>
						<div class="col-sm-6">
							<input type="file" name="cooperation_photo[]" class="form-control" >
						</div>
					</div>
					 <div class="form-group row">
						<label class="col-sm-5 col-form-label">Transaction Documents</label>
						<div class="col-sm-6">
							<input type="file" name="transction_doc[]" class="form-control" >
						</div>
					</div>
				  
				</div>
			</div>
			<div class="col-md-2">
				<button class="btn btn-primary btn-outline-primary btn-icon btn_customer_case_elem" type="button"><i class="icofont icofont-plus"></i></button>
				<button class="btn btn-primary btn-outline-danger btn-icon btn_remove_customer_case_elem" type="button"><i class="fa fa-remove"></i></button>
			</div>
		</div>
	 <?php } ?>
	</div>
	
    <div class="form-group row">
        <label class="col-sm-3 col-form-label">No. of Employees in Trade Department</label>
        <div class="col-sm-6">
		<select name="trade_dep_emp_count" class="form-control">
				<option value = "1-2 People" <?php echo $company->trade_dep_emp_count == "1-2 People" ? "selected=selected" : "";?>>1-2 People</option>
				<option value = "3-5 People" <?php echo $company->trade_dep_emp_count == "3-5 People" ? "selected=selected" : "";?>>3-5 People</option>
				<option value = "6-10 People" <?php echo $company->trade_dep_emp_count == "6-10 People" ? "selected=selected" : "";?>>6-10 People</option>
				<option value = "11-20 People" <?php echo $company->trade_dep_emp_count == "11-20 People" ? "selected=selected" : "";?>>11-20 People </option>
				<option value = "21-50 People" <?php echo $company->trade_dep_emp_count == "21-50 People" ? "selected=selected" : "";?>>21-50 People </option>
				<option value = "Above 50 People" <?php echo $company->trade_dep_emp_count == "Above 50 People" ? "selected=selected" : "";?>>Above 50 People</option>
			</select>
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-3 col-form-label">Nearest Port</label>
        <div class="col-sm-6">
            <input type="text" name="nearest_ports[]" class="col-md-4" style=" max-width: 32.333333%;">
			<input type="text" name="nearest_ports[]" class="col-md-4" style=" max-width: 32.333333%;">
			<input type="text" name="nearest_ports[]" class="col-md-4" style=" max-width: 32.333333%;">
			</br>
			<p>One port name per box.</p>
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-3 col-form-label">Average Lead Time</label>
        <div class="col-sm-6">
             <input type="text" name="average_lead_days" class="col-md-4" style=" max-width: 32.333333%;" value="<?php echo $company->average_lead_days;?>"> Day(s)
        </div>
    </div>
    
	<div class="form-group row">
        <label class="col-sm-3 col-form-label">Does your company have an overseas office?</label>
		 <?php 
            $yes = "";
            $no = "checked";
            $display = false;
            if($company->overseas_offices == 1){
                $no = "";
                $yes = "checked";
                $overseas_offices = true;
            }?>
        <label class="col-sm-8" style="margin-left:18px;"><input class="form-check-input" type="radio" name="is_overseas" id="is_overseas_1" value="1" <?php echo $yes;?>> Yes</label>
		<label class="col-sm-3 col-form-label"></label>  
	    <label class="col-sm-6 " style="margin-left:18px;"> <input class="form-check-input" type="radio" name="is_overseas" id="is_overseas_2" value="0" <?php echo $no;?>> No</label>
    </div>
	<div class="overseas_container" id="overseas_container" <?php if(!$overseas_offices){ echo "style='display:none'";}?> >
		  <?php 
        $details = json_decode($company->overseas_offices_details);
        if(count($details) > 0 ){
            foreach($details as $overseas):?>
		<div class="row dyn_overseas_container_row" >
			<label class="col-sm-3 col-form-label"> </label>
			<div class="col-sm-6">
				<div class="well">
					<div class="form-group row">
						<label class="col-sm-5 col-form-label">Country/Region</label>
						<div class="col-sm-7">
							<select name="overseas_country_region[]" class="form-control">
							<?php foreach($country as $row){ if($overseas->overseas_country_region == $row['id']){?>
									<option value= "<?php echo $row['id']; ?>" selected><?php echo $row['name']; ?></option>
							<?php }else{?>
								<option value= "<?php echo $row['id']; ?>" ><?php echo $row['name']; ?></option>
							<?php }} ?>
							</select>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-5 col-form-label">Province/State/County</label>
						<div class="col-sm-7">
							<input type="text_box" name="p_s_county[]" class="form-control" value = "<?php echo $overseas->p_s_county; ?>">
						</div>
					</div>
					 <div class="form-group row">
						<label class="col-sm-5 col-form-label">City</label>
						<div class="col-sm-7">
							<input type="text_box" name="City[]" class="form-control" value = "<?php echo $overseas->City; ?>">
						</div>
					</div>
					 <div class="form-group row">
						<label class="col-sm-5 col-form-label">Street Address</label>
						<div class="col-sm-7">
							<input type="text_box" name="street_address[]" class="form-control" value = "<?php echo $overseas->street_address; ?>">
						</div>
					</div>
					
					 <div class="form-group row">
						<label class="col-sm-5 col-form-label">Telephone</label>
						<div class="col-sm-7">
						<span>country code</span>&nbsp;
						<span>area code</span>&nbsp;
						<span>phone number</span>
							 <input type="text" name="country_code" class="col-md-4" style=" max-width: 32.333333%;" value = "<?php echo $overseas->country_code; ?>">
							 <input type="text" name="area_code" class="col-md-4" style=" max-width: 32.333333%;" value = "<?php echo $overseas->area_code; ?>">
							 <input type="text" name="phone_number" class="col-md-4" style=" max-width: 32.333333%;" value = "<?php echo $overseas->phone_number; ?>">
						</div>
					</div>
					
					<div class="form-group row">
						<label class="col-sm-5 col-form-label">Duties</label>
						<div class="col-sm-7">
							<select name="duties" class="form-control">
							<option value="">please select</option>
							<option value="Sales" <?php $overseas->duties == "sales" ? "selected=selected" : ""; ?>>Sales</option>
							<option value="After-sale service" <?php $overseas->duties == "After-sale service" ? "selected=selected" : ""; ?>>After-sale service</option>
							<option value="Other" <?php $overseas->duties == "Other" ? "selected=selected" : ""; ?>>Other</option>
							</select>
						</div>
					</div>
					
					 <div class="form-group row">
						<label class="col-sm-5 col-form-label">Person-in-Charge</label>
						<div class="col-sm-7">
							<input type="text_box" name="person_in_charge[]" class="form-control" value = "<?php echo $overseas->person_in_charge; ?>">
						</div>
					</div>
					
					 <div class="form-group row">
						<label class="col-sm-5 col-form-label">Number of Staff</label>
						<div class="col-sm-7">
							<input type="text_box" name="number_of_staff[]" class="form-control" value = "<?php echo $overseas->number_of_staff; ?>">
						</div>
					</div>
					
					 <div class="form-group row">
						<label class="col-sm-5 col-form-label">Ownership/Lease Certifications</label>
						<div class="col-sm-7">
							<input type="file" name="ownership_certification[]" class="form-control" >
							<input type="hidden" name="ownership_certification_old[]" value = "<?php echo $overseas->ownership_certification; ?>" >
						</div>
					</div>
					 <div class="form-group row">
						<label class="col-sm-5 col-form-label">Office Photos</label>
						<div class="col-sm-7">
							<input type="file" name="office_photos[]" class="form-control" >
							<input type="hidden" name="office_photos_old[]" value = "<?php echo $overseas->office_photos; ?>" >
						</div>
					</div>
				  
				</div>
			</div>
			<div class="col-md-2">
				<button class="btn btn-primary btn-outline-primary btn-icon btn_overseas_elem" type="button"><i class="icofont icofont-plus"></i></button>
				<button class="btn btn-primary btn-outline-danger btn-icon btn_remove_overseas_elem" type="button"><i class="fa fa-remove"></i></button>
			</div>
		</div>
		 <?php 
        endforeach;
        } else { ?>
		<div class="row dyn_overseas_container_row" >
			<label class="col-sm-3 col-form-label"> </label>
			<div class="col-sm-6">
				<div class="well">
					<div class="form-group row">
						<label class="col-sm-5 col-form-label">Country/Region</label>
						<div class="col-sm-7">
							<select name="overseas_country_region[]" class="form-control">
							<?php foreach($country as $row){ ?>
									<option value= "<?php echo $row['id']; ?>" ><?php echo $row['name']; ?></option>
							<?php } ?>
							</select>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-5 col-form-label">Province/State/County</label>
						<div class="col-sm-7">
							<input type="text_box" name="p_s_county[]" class="form-control" >
						</div>
					</div>
					 <div class="form-group row">
						<label class="col-sm-5 col-form-label">City</label>
						<div class="col-sm-7">
							<input type="text_box" name="City[]" class="form-control" >
						</div>
					</div>
					 <div class="form-group row">
						<label class="col-sm-5 col-form-label">Street Address</label>
						<div class="col-sm-7">
							<input type="text_box" name="street_address[]" class="form-control" >
						</div>
					</div>
					
					 <div class="form-group row">
						<label class="col-sm-5 col-form-label">Telephone</label>
						<div class="col-sm-7">
						<span>country code</span>&nbsp;
						<span>area code</span>&nbsp;
						<span>phone number</span>
							 <input type="text" name="country_code" class="col-md-4" style=" max-width: 32.333333%;">
							 <input type="text" name="area_code" class="col-md-4" style=" max-width: 32.333333%;">
							 <input type="text" name="phone_number" class="col-md-4" style=" max-width: 32.333333%;">
						</div>
					</div>
					
					<div class="form-group row">
						<label class="col-sm-5 col-form-label">Duties</label>
						<div class="col-sm-7">
							<select name="duties" class="form-control">
							<option value="">please select</option>
							<option value="Sales">Sales</option>
							<option value="After-sale service">After-sale service</option>
							<option value="Other">Other</option>
							</select>
						</div>
					</div>
					
					 <div class="form-group row">
						<label class="col-sm-5 col-form-label">Person-in-Charge</label>
						<div class="col-sm-7">
							<input type="text_box" name="person_in_charge[]" class="form-control" >
						</div>
					</div>
					
					 <div class="form-group row">
						<label class="col-sm-5 col-form-label">Number of Staff</label>
						<div class="col-sm-7">
							<input type="text_box" name="number_of_staff[]" class="form-control" >
						</div>
					</div>
					
					 <div class="form-group row">
						<label class="col-sm-5 col-form-label">Ownership/Lease Certifications</label>
						<div class="col-sm-7">
							<input type="file" name="ownership_certification[]" class="form-control" >
						</div>
					</div>
					 <div class="form-group row">
						<label class="col-sm-5 col-form-label">Office Photos</label>
						<div class="col-sm-7">
							<input type="file" name="office_photos[]" class="form-control" >
						</div>
					</div>
				  
				</div>
			</div>
			<div class="col-md-2">
				<button class="btn btn-primary btn-outline-primary btn-icon btn_overseas_elem" type="button"><i class="icofont icofont-plus"></i></button>
				<button class="btn btn-primary btn-outline-danger btn-icon btn_remove_overseas_elem" type="button"><i class="fa fa-remove"></i></button>
			</div>
		</div>
		<?php } ?>
	</div>

	<div class="form-group row">
        <label class="col-sm-3 col-form-label">Accepted Delivery Terms</label>
		<?php 
        $checked_boxes = json_decode($company->accepted_delivery_terms);
		$payment_currency = json_decode($company->accepted_payment_currency);
		$payment_types = json_decode($company->accepted_payment_types);
		$languages = json_decode($company->languages_spoken);
		?>
        <div class="col-sm-9">
			<div class="row">
			  <div class="col-md-4">
                <div class="col-md-4" style="display:-webkit-box;">
				    <?php if (in_array("FOB",  $checked_boxes)){
						$checked = "checked";
					}else{
						$checked = "";
					}?>
                    <input type="checkbox" class="form-control" name="terms[]" value = "FOB" <?php echo $checked; ?>> FOB
                </div>
				</br>
                <div class="col-md-4" style="display:-webkit-box;">
					<?php if (in_array("EXW",  $checked_boxes)){
						$checked = "checked";
					}else{
						$checked = "";
					}?>
                    <input type="checkbox" class="form-control" name="terms[]" value = "EXW" <?php echo $checked; ?>> EXW
                </div>
				</br>
                <div class="col-md-4" style="display:-webkit-box;">
					<?php if (in_array("FCA",  $checked_boxes)){
						$checked = "checked";
					}else{
						$checked = "";
					}?>
                    <input type="checkbox" class="form-control" name="terms[]" value = "FCA" <?php echo $checked; ?>> FCA
                </div>
				</br>
                <div class="col-md-4" style="display:-webkit-box;">
					<?php if (in_array("DDP",  $checked_boxes)){
						$checked = "checked";
					}else{
						$checked = "";
					}?>
                    <input type="checkbox" class="form-control" name="terms[]" value = "DDP" <?php echo $checked; ?>> DDP

                </div>
				</br>
                <div class="col-md-4" style="display:-webkit-box;">
					<?php if (in_array("DAF",  $checked_boxes)){
						$checked = "checked";
					}else{
						$checked = "";
					}?>
                    <input type="checkbox" class="form-control" name="terms[]" value = "DAF" <?php echo $checked; ?>> DAF
                </div>
				</br>
			  </div>
			   <div class="col-md-4">
                <div class="col-md-4" style="display:-webkit-box;">
					<?php if (in_array("CFR",  $checked_boxes)){
						$checked = "checked";
					}else{
						$checked = "";
					}?>
                    <input type="checkbox" class="form-control" name="terms[]" value = "CFR" <?php echo $checked; ?>> CFR
                </div>
				</br>
                <div class="col-md-4" style="display:-webkit-box;">
					<?php if (in_array("FAS",  $checked_boxes)){
						$checked = "checked";
					}else{
						$checked = "";
					}?>
                    <input type="checkbox" class="form-control" name="terms[]" value = "FAS" <?php echo $checked; ?>> FAS
                </div>
				</br>
                <div class="col-md-4" style="display:-webkit-box;">
					<?php if (in_array("CPT",  $checked_boxes)){
						$checked = "checked";
					}else{
						$checked = "";
					}?>
                    <input type="checkbox" class="form-control" name="terms[]" value = "CPT" <?php echo $checked; ?>> CPT
                </div>
				</br>
                <div class="col-md-4" style="display:-webkit-box;">
					<?php if (in_array("DDU",  $checked_boxes)){
						$checked = "checked";
					}else{
						$checked = "";
					}?>
                    <input type="checkbox" class="form-control" name="terms[]" value = "DDU" <?php echo $checked; ?>> DDU
                </div>
				</br>
                <div class="col-md-4" style="display:-webkit-box;">
					<?php if (in_array("DES",  $checked_boxes)){
						$checked = "checked";
					}else{
						$checked = "";
					}?>
                    <input type="checkbox" class="form-control" name="terms[]" value = "DES" <?php echo $checked; ?>> DES
                </div>
				</br>
			  </div>
			   <div class="col-md-4">
                <div class="col-md-4" style="display:-webkit-box;">
					<?php if (in_array("CIF",  $checked_boxes)){
						$checked = "checked";
					}else{
						$checked = "";
					}?>
                    <input type="checkbox" class="form-control" name="terms[]" value = "CIF" <?php echo $checked; ?>> CIF
                </div>
				</br>
                <div class="col-md-4" style="display:-webkit-box;">
					<?php if (in_array("CIP",  $checked_boxes)){
						$checked = "checked";
					}else{
						$checked = "";
					}?>
                    <input type="checkbox" class="form-control" name="terms[]" value = "CIP" <?php echo $checked; ?>> CIP
                </div>
				</br>
                <div class="col-md-4" style="display:-webkit-box;">
					<?php if (in_array("DEQ",  $checked_boxes)){
						$checked = "checked";
					}else{
						$checked = "";
					}?>
                    <input type="checkbox" class="form-control" name="terms[]" value = "DEQ" <?php echo $checked; ?>> DEQ
                </div>
				</br>
                <div class="col-md-4" style="display:-webkit-box;">
                    <input type="checkbox" class="form-control" name="terms[]" value = "Express_Delivery"> Express Delivery
                </div>
			  </div>
            </div>
            <p class="text-muted">One product each box</p>
        </div>
    </div>
	
	<div class="form-group row">
        <label class="col-sm-3 col-form-label">Accepted Payment Currency</label>
        <div class="col-sm-9">
			<div class="row">
			  <div class="col-md-4">
                <div class="col-md-4" style="display:-webkit-box;">
					<?php if (in_array("USD",  $payment_currency)){
						$checked = "checked";
					}else{
						$checked = "";
					}?>
                    <input type="checkbox" class="form-control" name="payment_currency[]" value = "USD" <?php echo $checked; ?>> USD
                </div>
				</br>
                <div class="col-md-4" style="display:-webkit-box;">
					<?php if (in_array("CAD",  $payment_currency)){
						$checked = "checked";
					}else{
						$checked = "";
					}?>
                    <input type="checkbox" class="form-control" name="payment_currency[]" value = "CAD" <?php echo $checked; ?>> CAD
                </div>
				</br>
                <div class="col-md-4" style="display:-webkit-box;">
					<?php if (in_array("GBP",  $payment_currency)){
						$checked = "checked";
					}else{
						$checked = "";
					}?>
                    <input type="checkbox" class="form-control" name="payment_currency[]" value = "GBP" <?php echo $checked; ?>> GBP
                </div>
				</br>
			  </div>
			   <div class="col-md-4">
                <div class="col-md-4" style="display:-webkit-box;">
					<?php if (in_array("EUR",  $payment_currency)){
						$checked = "checked";
					}else{
						$checked = "";
					}?>
                    <input type="checkbox" class="form-control" name="payment_currency[]" value = "EUR" <?php echo $checked; ?>> EUR
                </div>
				</br>
                <div class="col-md-4" style="display:-webkit-box;">
					<?php if (in_array("AUD",  $payment_currency)){
						$checked = "checked";
					}else{
						$checked = "";
					}?>
                    <input type="checkbox" class="form-control" name="payment_currency[]" value = "AUD" <?php echo $checked; ?>> AUD
                </div>
				</br>
                <div class="col-md-4" style="display:-webkit-box;">
					<?php if (in_array("CNY",  $payment_currency)){
						$checked = "checked";
					}else{
						$checked = "";
					}?>
                    <input type="checkbox" class="form-control" name="payment_currency[]" value = "CNY" <?php echo $checked; ?>> CNY
                </div>
				</br>
			  </div>
			   <div class="col-md-4">
                <div class="col-md-4" style="display:-webkit-box;">
					<?php if (in_array("JPY",  $payment_currency)){
						$checked = "checked";
					}else{
						$checked = "";
					}?>
                    <input type="checkbox" class="form-control" name="payment_currency[]" value = "JPY" <?php echo $checked; ?>> JPY
                </div>
				</br>
                <div class="col-md-4" style="display:-webkit-box;">
					<?php if (in_array("HKD",  $payment_currency)){
						$checked = "checked";
					}else{
						$checked = "";
					}?>
                    <input type="checkbox" class="form-control" name="payment_currency[]" value = "HKD" <?php echo $checked; ?>> HKD
                </div>
				</br>
                <div class="col-md-4" style="display:-webkit-box;">
					<?php if (in_array("CHF",  $payment_currency)){
						$checked = "checked";
					}else{
						$checked = "";
					}?>
                    <input type="checkbox" class="form-control" name="payment_currency[]" value = "CHF" <?php echo $checked; ?>> CHF
                </div>
				</br>
			  </div>
            </div>
        </div>
    </div>
	
	<div class="form-group row">
        <label class="col-sm-3 col-form-label">Accepted Payment Type</label>
        <div class="col-sm-9">
			<div class="row">
			  <div class="col-md-4">
                <div class="col-md-4" style="display:-webkit-box;">
					<?php if (in_array("T/T",  $payment_types)){
						$checked = "checked";
					}else{
						$checked = "";
					}?>
                    <input type="checkbox" class="form-control" name="payment_type[]" value = "T/T" <?php echo $checked; ?>> T/T

                </div>
				</br>
                <div class="col-md-4" style="display:-webkit-box;">
					<?php if (in_array("T/T",  $payment_types)){
						$checked = "checked";
					}else{
						$checked = "";
					}?>
                    <input type="checkbox" class="form-control" name="payment_type[]" value = "MoneyGram" <?php echo $checked; ?>> MoneyGram
                </div>
				</br>
                <div class="col-md-4" style="display:-webkit-box;">
					<?php if (in_array("Western_Union",  $payment_types)){
						$checked = "checked";
					}else{
						$checked = "";
					}?>
                    <input type="checkbox" class="form-control" name="payment_type[]" value = "Western_Union" <?php echo $checked; ?>> Western Union
                </div>
				</br>
			  </div>
			   <div class="col-md-4">
                <div class="col-md-4" style="display:-webkit-box;">
					<?php if (in_array("L/C",  $payment_types)){
						$checked = "checked";
					}else{
						$checked = "";
					}?>
                    <input type="checkbox" class="form-control" name="payment_type[]" value = "L/C" <?php echo $checked; ?>> L/C
                </div>
				</br>
                <div class="col-md-4" style="display:-webkit-box;">
					<?php if (in_array("Credit_Card",  $payment_types)){
						$checked = "checked";
					}else{
						$checked = "";
					}?>
                    <input type="checkbox" class="form-control" name="payment_type[]" value = "Credit_Card" <?php echo $checked; ?>> Credit Card
                </div>
				</br>
                <div class="col-md-4" style="display:-webkit-box;">
					<?php if (in_array("Cash",  $payment_types)){
						$checked = "checked";
					}else{
						$checked = "";
					}?>
                    <input type="checkbox" class="form-control" name="payment_type[]" value = "Cash" <?php echo $checked; ?>> Cash
                </div>
				</br>
			  </div>
			   <div class="col-md-4">
                <div class="col-md-4" style="display:-webkit-box;">
					<?php if (in_array("D/P D/A",  $payment_types)){
						$checked = "checked";
					}else{
						$checked = "";
					}?>
                    <input type="checkbox" class="form-control" name="payment_type[]" value = "D/P D/A" <?php echo $checked; ?>> D/P D/A
                </div>
				</br>
                <div class="col-md-4" style="display:-webkit-box;">
					<?php if (in_array("PayPal",  $payment_types)){
						$checked = "checked";
					}else{
						$checked = "";
					}?>
                    <input type="checkbox" class="form-control" name="payment_type[]" value = "PayPal" <?php echo $checked; ?>> PayPal
                </div>
				</br>
                <div class="col-md-4" style="display:-webkit-box;">
					<?php if (in_array("Escrow",  $payment_types)){
						$checked = "checked";
					}else{
						$checked = "";
					}?>
                    <input type="checkbox" class="form-control" name="payment_type[]" value = "Escrow" <?php echo $checked; ?>> Escrow
                </div>
				</br>
			  </div>
            </div>
        </div>
    </div>
	
	<div class="form-group row">
       
        <label class="col-sm-3 col-form-label">Language Spoken</label>
        <div class="col-sm-9">
			<div class="row">
			  <div class="col-md-4">
                <div class="col-md-4" style="display:-webkit-box;">
					<?php if (in_array("English",  $languages)){
						$checked = "checked";
					}else{
						$checked = "";
					}?>
                    <input type="checkbox" class="form-control" name="languages[]" value="English" <?php echo $checked; ?>> English
                </div>
				</br>
                <div class="col-md-4" style="display:-webkit-box;">
					<?php if (in_array("Japanese",  $languages)){
						$checked = "checked";
					}else{
						$checked = "";
					}?>
                    <input type="checkbox" class="form-control" name="languages[]" value="Japanese" <?php echo $checked; ?>> Japanese
                </div>
				</br>
                <div class="col-md-4" style="display:-webkit-box;">
					<?php if (in_array("Arabic",  $languages)){
						$checked = "checked";
					}else{
						$checked = "";
					}?>
                    <input type="checkbox" class="form-control" name="languages[]" value="Arabic" <?php echo $checked; ?>> Arabic
                </div>
				</br>
                <div class="col-md-4" style="display:-webkit-box;">
					<?php if (in_array("Korean",  $languages)){
						$checked = "checked";
					}else{
						$checked = "";
					}?>
                    <input type="checkbox" class="form-control" name="languages[]" value="Korean" <?php echo $checked; ?>> Korean
                </div>
				</br>
			  </div>
			   <div class="col-md-4">
                <div class="col-md-4" style="display:-webkit-box;">
					<?php if (in_array("Chinese",  $languages)){
						$checked = "checked";
					}else{
						$checked = "";
					}?>
                    <input type="checkbox" class="form-control" name="languages[]" value="Chinese" <?php echo $checked; ?>> Chinese
                </div>
				</br>
                <div class="col-md-4" style="display:-webkit-box;">
					<?php if (in_array("Portuguese",  $languages)){
						$checked = "checked";
					}else{
						$checked = "";
					}?>
                    <input type="checkbox" class="form-control" name="languages[]" value="Portuguese" <?php echo $checked; ?>> Portuguese
                </div>
				</br>
                <div class="col-md-4" style="display:-webkit-box;">
					<?php if (in_array("French",  $languages)){
						$checked = "checked";
					}else{
						$checked = "";
					}?>
                    <input type="checkbox" class="form-control" name="languages[]" value="French" <?php echo $checked; ?>> French
                </div>
				</br>
                <div class="col-md-4" style="display:-webkit-box;">
					<?php if (in_array("Hindi",  $languages)){
						$checked = "checked";
					}else{
						$checked = "";
					}?>
                    <input type="checkbox" class="form-control" name="languages[]" value="Hindi" <?php echo $checked; ?>> Hindi
                </div>
				</br>
			  </div>
			   <div class="col-md-4">
                <div class="col-md-4" style="display:-webkit-box;">
					<?php if (in_array("Spanish",  $languages)){
						$checked = "checked";
					}else{
						$checked = "";
					}?>
                    <input type="checkbox" class="form-control" name="languages[]" value="Spanish" <?php echo $checked; ?>> Spanish
                </div>
				</br>
                <div class="col-md-4" style="display:-webkit-box;">
					<?php if (in_array("German",  $languages)){
						$checked = "checked";
					}else{
						$checked = "";
					}?>
                    <input type="checkbox" class="form-control" name="languages[]" value="German" <?php echo $checked; ?>> German
                </div>
				</br>
                <div class="col-md-4" style="display:-webkit-box;">
					<?php if (in_array("Russian",  $languages)){
						$checked = "checked";
					}else{
						$checked = "";
					}?>
                    <input type="checkbox" class="form-control" name="languages[]" value="Russian" <?php echo $checked; ?>> Russian
                </div>
				</br>
                <div class="col-md-4" style="display:-webkit-box;">
					<?php if (in_array("Italian",  $languages)){
						$checked = "checked";
					}else{
						$checked = "";
					}?>
                    <input type="checkbox" class="form-control" name="languages[]" value="Italian" <?php echo $checked; ?>> Italian
                </div>
			  </div>
            </div>
        </div>
    </div>

    <button type="submit" class="btn btn-info pull-right">Submit</button>

</form>