<form action="<?php echo site_url(); ?>seller/companyprofile/manufacturing" method="post" enctype="multipart/form-data">
    <input type="hidden" name="com" value="<?php echo $company->pcompany_id;?>">
    <div class="row">
        <label class="col-sm-3 col-form-label">Display production process</label>
        <div class="col-sm-6">
            <?php 
            $yes = "";
            $no = "checked";
            $display_process = false;
            if($company->display_production_process == 1){
                $no = "";
                $yes = "checked";
                $display_production_process = true;
            }?>
            <div class="form-check form-check-inline">
                <label class="form-check-label">
                    <input class="form-check-input" type="radio" name="is_display_process" id="is_prod_process_1" value="1" <?php echo $yes;?>> Yes
                </label>
            </div>
            <div class="form-check form-check-inline">
                <label class="form-check-label">
                    <input class="form-check-input" type="radio" name="is_display_process" id="is_prod_process_2" value="0" <?php echo $no;?>> No
                </label>
            </div>
            <span class="messages"></span>
        </div>
    </div>
    <div class="pp_container" id="pp_container" <?php if(!$display_production_process){ echo "style='display:none'";}?>>
        <?php 
        $processes = json_decode($company->production_process_details);
        if(count($processes) > 0 ){
            foreach($processes as $process):?>
            <div class="row dyn_pp_row" >
                <label class="col-sm-3 col-form-label"> </label>
                <div class="col-sm-6">
                    <div class="well">
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Name</label>
                            <div class="col-sm-9">
                                <input type="text" name="process_name[]" class="form-control" value="<?php echo $process->name;?>">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Image</label>
                            <div class="col-sm-9">
                                <input type="file" name="process_image[]" class="form-control" >
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label"></label>
                            <div class="col-md-6">
                                <?php $url = $process->image; ?>
                                <img class="img img-bordered img-thumbnail" src="<?php echo $url;?>">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Description</label>
                            <div class="col-sm-9">
                                <textarea name="process_description[]" class="form-control"><?php echo $process->description;?></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <button class=" btn-primary btn-infor  btn-icon btn_create_pp_elem" type="button"><i class="icofont icofont-plus"></i></button>
                    <button class=" btn-primary  btn-icon btn_remove_pp_elem" type="button"><i class="fa fa-remove"></i></button>
                </div>
            </div>
        <?php 
        endforeach;
        } else { ?>
            <div class="row dyn_pp_row" >
                <label class="col-sm-3 col-form-label"> </label>
                <div class="col-sm-6">
                    <div class="well">
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Name</label>
                            <div class="col-sm-9">
                                <input type="text" name="process_name[]" class="form-control" >
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Image</label>
                            <div class="col-sm-9">
                                <input type="file" name="process_image[]" class="form-control" >
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Description</label>
                            <div class="col-sm-9">
                                <textarea name="process_description[]" class="form-control"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <button class="btn btn-primary btn-outline-primary btn-icon btn_create_pp_elem" type="button"><i class="icofont icofont-plus"></i></button>
                    <button class="btn btn-primary btn-outline-danger btn-icon btn_remove_pp_elem" type="button"><i class="fa fa-remove"></i></button>
                </div>
            </div>
        <?php } ?>
    </div>
    
    
    <div class="row">
        <label class="col-sm-3 col-form-label">Display production equipment</label>
        <div class="col-sm-6">
            
            <?php 
            $yes = "";
            $no = "checked";
            $display_equipments = false;
            if($company->display_production_equipments == 1){
                $no = "";
                $yes = "checked";
                $display_equipments = true;
            }?>
            <div class="form-check form-check-inline">
                <label class="form-check-label">
                    <input class="form-check-input" type="radio" name="display_prod_equipment" id="is_prod_equipment_1" value="1" <?php echo $yes;?>> Yes
                </label>
            </div>
            <div class="form-check form-check-inline">
                <label class="form-check-label">
                    <input class="form-check-input" type="radio" name="display_prod_equipment" id="is_prod_equipment_2" value="0" selected="selected" <?php echo $no;?>> No
                </label>
            </div>
            <span class="messages"></span>
        </div>
    </div>
    <div class="pe_container" id="pe_container" <?php if(!$display_process){ echo "style='display:none'";}?>>
        <?php 
        $equipments = json_decode($company->production_equipment_details); 
        if(count($equipments) > 0 ){
            foreach($equipments as $equipment):?>
            <div class="row dyn_pe_row" >
                <label class="col-sm-3 col-form-label"> </label>
                <div class="col-sm-6">
                    <div class="well">
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Name</label>
                            <div class="col-sm-9">
                                <input type="text" name="equipment_name[]" class="form-control" value="<?php echo $equipment->name;?>">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Model</label>
                            <div class="col-sm-9">
                                <input type="text" name="equipment_model[]" class="form-control" value="<?php echo $equipment->model;?>">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Quantity</label>
                            <div class="col-sm-9">
                                <input type="text" name="equipment_quantity[]" class="form-control" value="<?php echo $equipment->quantity;?>">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <button class="btn btn-primary btn-outline-primary btn-icon btn_create_pe_elem" type="button"><i class="icofont icofont-plus"></i></button>
                    <button class="btn btn-primary btn-outline-danger btn-icon btn_remove_pe_elem" type="button"><i class="fa fa-remove"></i></button>
                </div>
            </div>

            <?php endforeach;
        } else { ?>
            <div class="row dyn_pe_row" >
                <label class="col-sm-3 col-form-label"> </label>
                <div class="col-sm-6">
                    <div class="well">
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Name</label>
                            <div class="col-sm-9">
                                <input type="text" name="equipment_name[]" class="form-control" >
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Model</label>
                            <div class="col-sm-9">
                                <input type="text" name="equipment_model[]" class="form-control" >
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Quantity</label>
                            <div class="col-sm-9">
                                <input type="text" name="equipment_quantity[]" class="form-control" >
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <button class="btn btn-primary btn-outline-primary btn-icon btn_create_pe_elem" type="button"><i class="icofont icofont-plus"></i></button>
                    <button class="btn btn-primary btn-outline-danger btn-icon btn_remove_pe_elem" type="button"><i class="fa fa-remove"></i></button>
                </div>
            </div>
       <?php } ?>
        
    </div>
    
    
    <div class="row">
        <label class="col-sm-3 col-form-label">Display production Line</label>
        <div class="col-sm-6">
            
            <?php 
            $yes = "";
            $no = "checked";
            $display_line = false;
            if($company->display_production_line == 1){
                $no = "";
                $yes = "checked";
                $display_line = true;
            }?>
            <div class="form-check form-check-inline">
                <label class="form-check-label">
                    <input class="form-check-input" type="radio" name="display_prod_line" id="is_prod_line_1" value="1" <?php echo $yes;?>> Yes
                </label>
            </div>
            <div class="form-check form-check-inline">
                <label class="form-check-label">
                    <input class="form-check-input" type="radio" name="display_prod_line" id="is_prod_line_2" value="0" selected="selected" <?php echo $no;?>> No
                </label>
            </div>
            <span class="messages"></span>
        </div>
    </div>
    <div class="line_container" id="line_container" <?php if(!$display_process){ echo "style='display:none'";}?>>
        <?php 
        $lines = json_decode($company->production_line_details); 
        if(count($lines) > 0 ){
            foreach($lines as $line):?>
            <div class="row dyn_line_row" >
                <label class="col-sm-3 col-form-label"> </label>
                <div class="col-sm-6">
                    <div class="well">
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Line Name</label>
                            <div class="col-sm-9">
                                <input type="text" name="line_name[]" class="form-control" value="<?php echo $line->name;?>">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Supervisor No</label>
                            <div class="col-sm-9">
                                <input type="text" name="supervisor_no[]" class="form-control" value="<?php echo $line->supervisor_no;?>">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Number of Operators</label>
                            <div class="col-sm-9">
                                <input type="text" name="operators_count[]" class="form-control" value="<?php echo $line->operators_count;?>">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">QC/AQ number</label>
                            <div class="col-sm-9">
                                <input type="text" name="qc_qa_number[]" class="form-control" value="<?php echo $line->quantity;?>">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <button class="btn btn-primary btn-outline-primary btn-icon btn_create_line_elem" type="button"><i class="icofont icofont-plus"></i></button>
                    <button class="btn btn-primary btn-outline-danger btn-icon btn_remove_line_elem" type="button"><i class="fa fa-remove"></i></button>
                </div>
            </div>

            <?php endforeach;
        } else { ?>
            <div class="row dyn_line_row" >
                <label class="col-sm-3 col-form-label"> </label>
                <div class="col-sm-6">
                    <div class="well">
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Line Name</label>
                            <div class="col-sm-9">
                                <input type="text" name="line_name[]" class="form-control" value="<?php echo $line->name;?>">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Supervisor No</label>
                            <div class="col-sm-9">
                                <input type="text" name="supervisor_no[]" class="form-control" value="<?php echo $line->model;?>">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Number of Operators</label>
                            <div class="col-sm-9">
                                <input type="text" name="operators_count[]" class="form-control" value="<?php echo $line->quantity;?>">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">QC/AQ number</label>
                            <div class="col-sm-9">
                                <input type="text" name="qc_qa_number[]" class="form-control" value="<?php echo $line->quantity;?>">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <button class="btn btn-primary btn-outline-primary btn-icon btn_create_line_elem" type="button"><i class="icofont icofont-plus"></i></button>
                    <button class="btn btn-primary btn-outline-danger btn-icon btn_remove_line_elem" type="button"><i class="fa fa-remove"></i></button>
                </div>
            </div>
       <?php } ?>
        
    </div>
    
    <div class="row">
        <label class="col-sm-3 col-form-label">Annual production capacity</label>
        <div class="col-sm-6">
            
            <?php 
            $yes = "";
            $no = "checked";
            $display_production_capacity = false;
            if($company->display_annual_production_capacity == 1){
                $no = "";
                $yes = "checked";
                $display_production_capacity = true;
            }?>
            <div class="form-check form-check-inline">
                <label class="form-check-label">
                    <input class="form-check-input" type="radio" name="display_prod_capacity" id="is_prod_capacity_1" value="1" <?php echo $yes;?>> Yes
                </label>
            </div>
            <div class="form-check form-check-inline">
                <label class="form-check-label">
                    <input class="form-check-input" type="radio" name="display_prod_capacity" id="is_prod_capacity_2" value="0" <?php echo $no;?>> No
                </label>
            </div>
            <span class="messages"></span>
        </div>
    </div>
    <div class="capacity_container" id="capacity_container" <?php if(!$display_production_capacity){ echo "style='display:none'";}?>>
        <?php 
        $capacities = json_decode($company->annual_production_capacity_details); 
        if(count($capacities) > 0 ){
            foreach($capacities as $capacity):?>
            <div class="row dyn_capacity_row" >
                <label class="col-sm-3 col-form-label"> </label>
                <div class="col-sm-6">
                    <div class="well">
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Product Name</label>
                            <div class="col-sm-9">
                                <input type="text" name="product_name[]" class="form-control" value="<?php echo $capacity->unit_per_year_quantity;?>">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Units produced per year</label>
                            <div class="col-sm-5">
                                <input type="text" name="unit_per_year_quantity[]" class="form-control" value="<?php echo $capacity->unit_per_year_quantity;?>">
                            </div>
                            <div class="col-md-4">
                                <?php echo form_dropdown('unit_per_year_factor[]', $units, 
                                "", "class='form-control'"); ?>
                                
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Highest ever annual output</label>
                            <div class="col-md-5">
                                <input type="text" name="highest_output[]" class="form-control" value="<?php echo $capacity->highest_output;?>">
                            </div>
                            <div class="col-md-4">
                                <?php echo form_dropdown('unit_factor[]', $units, 
                                "", "class='form-control'"); ?>
                                
                            </div>
                        </div>
                        
                    </div>
                </div>
                <div class="col-md-2">
                    <button class="btn btn-primary btn-outline-primary btn-icon btn_create_capacity_elem" type="button"><i class="icofont icofont-plus"></i></button>
                    <button class="btn btn-primary btn-outline-danger btn-icon btn_remove_capacity_elem" type="button"><i class="fa fa-remove"></i></button>
                </div>
            </div>

            <?php endforeach;
        } else { ?>
            <div class="row dyn_capacity_row" >
                <label class="col-sm-3 col-form-label"> </label>
                <div class="col-sm-6">
                    <div class="well">
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Product Name</label>
                            <div class="col-sm-9">
                                <input type="text" name="product_name[]" class="form-control" value="<?php echo $capacity->name;?>">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Units produced per year</label>
                            <div class="col-sm-5">
                                <input type="text" name="unit_per_year_quantity[]" class="form-control" value="<?php echo $capacity->model;?>">
                            </div>
                            <div class="col-sm-4">
                                <?php echo form_dropdown('unit_per_year_factor[]', $units, 
                                "", "class='form-control'"); ?>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label">Highest ever annual output</label>
                            <div class="col-md-5">
                                <input type="text" name="highest_output[]" class="form-control" value="<?php echo $capacity->quantity;?>">
                            </div>
                            <div class="col-md-4">
                                <?php echo form_dropdown('unit_factor[]', $units, 
                                "", "class='form-control'"); ?>
                            </div>
                        </div>
                        
                    </div>
                </div>
                <div class="col-md-2">
                    <button class="btn btn-primary btn-outline-primary btn-icon btn_create_capacity_elem" type="button"><i class="icofont icofont-plus"></i></button>
                    <button class="btn btn-primary btn-outline-danger btn-icon btn_remove_capacity_elem" type="button"><i class="fa fa-remove"></i></button>
                </div>
            </div>
       <?php } ?>
        
    </div>
    
    <div class="form-group row">
        <label class="col-sm-3 col-form-label">Factory Location <span class="text-danger">*</span></label>
        <div class="col-sm-6">
            <input type="text" name="factory_location" value = "<?php echo $company->factory_location; ?>" class="form-control" >
        </div>
    </div>
    
    <div class="form-group row">
        <label class="col-sm-3 col-form-label">Factory Size</label>
        <div class="col-sm-6">
            <?php echo form_dropdown('factory_size', $factory_size, 
            $company->factory_size, "class='form-control'"); ?>
        </div>
    </div>
    
    <div class="form-group row">
        <label class="col-sm-3 col-form-label">Contract Manufacturing</label>
        <div class="col-sm-9">
            <div class="border-checkbox-section">
                <div class="border-checkbox-group border-checkbox-group-primary">
                    <input class="border-checkbox" type="checkbox" name="contract_services[]" id="checkbox1">
                    <label class="border-checkbox-label" for="checkbox1">OEM service offered</label>
                </div>
                <div class="border-checkbox-group border-checkbox-group-primary">
                    <input class="border-checkbox" type="checkbox" name="contract_services[]" id="checkbox2">
                    <label class="border-checkbox-label" for="checkbox2">Design service offered</label>
                </div>
                <div class="border-checkbox-group border-checkbox-group-primary">
                    <input class="border-checkbox" type="checkbox" name="contract_services[]" id="checkbox3">
                    <label class="border-checkbox-label" for="checkbox3">Buyer Label offered</label>
                </div>
            </div>
        </div>
    </div>
    
   <!-- <div class="form-group row">
        <label class="col-sm-3 col-form-label">OEM experience(Years)</label>
        <div class="col-sm-6">
            <input type="text" name="oem_experience" class="form-control" >
        </div>
    </div>-->
    
    <div class="form-group row">
        <label class="col-sm-3 col-form-label">No of QC Staff</label>
        <div class="col-sm-6">
            <?php echo form_dropdown('oc_staff_count', $staff_size, 
            $company->oc_staff_count, "class='form-control'"); ?>
        </div>
    </div>
    
    <div class="form-group row">
        <label class="col-sm-3 col-form-label">No Of RND Staff</label>
        <div class="col-sm-6">
            <?php echo form_dropdown('rd_staff_count', $staff_size, 
            $company->rd_staff_count, "class='form-control'"); ?>
        </div>
    </div>
    
    <div class="form-group row">
        <label class="col-sm-3 col-form-label">No Of Production lines</label>
        <div class="col-sm-6">
            <?php echo form_dropdown('production_line_count', $production_lines, 
            $company->production_line_count, "class='form-control'"); ?>
        </div>
    </div>
    
    <div class="form-group row">
        <label class="col-sm-3 col-form-label">Annual Output Value</label>
        <div class="col-sm-6">
            <?php echo form_dropdown('annual_output_value', $annual_output_value, 
            $company->annual_output_value, "class='form-control'"); ?>
        </div>
    </div>
    
    
    <button type="submit" class="btn btn-info pull-right">Submit</button>
</form>    