<form action="<?php echo site_url(); ?>seller/companyprofile/quality_control" method="post" enctype="multipart/form-data">
    <input type="hidden" name="com" value="<?php echo $company->pcompany_id;?>">
    <div class="row">
        <label class="col-sm-3 col-form-label">Display quality control process</label>
        <div class="col-sm-6">
            <?php 
            $yes = "";
            $no = "checked";
            $display_process = false;
            if($company->display_quality_control_process == 1){
                $no = "";
                $yes = "checked";
                $display_process = true;
            }?>
            <div class="form-check form-check-inline">
                <label class="form-check-label">
                    <input class="form-check-input" type="radio" name="is_qc_process" id="is_qc_process_1" value="1" <?php echo $yes;?>> Yes
                </label>
            </div>
            <div class="form-check form-check-inline">
                <label class="form-check-label">
                    <input class="form-check-input" type="radio" name="is_qc_process" id="is_qc_process_2" value="0" selected="selected" <?php echo $no;?>> No
                </label>
            </div>
            <span class="messages"></span>
        </div>
    </div>
    <div class="qc_container" id="qc_container" <?php if(!$display_process){ echo "style='display:none'";}?>>
        <?php 
        $processes = json_decode($company->quality_control_details);
        if(count($processes) > 0 ){
            foreach($processes as $process):?>
            <div class="row dyn_qc_row" >
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
                            <div class="col-md-6" id="remove_img2">
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
                    <button class="btn btn-primary btn-outline-primary btn-icon btn_create_qc_elem" type="button"><i class="icofont icofont-plus"></i></button>
                    <button class="btn btn-primary btn-outline-danger btn-icon btn_remove_qc_elem" type="button"><i class="fa fa-remove"></i></button>
                </div>
            </div>
        <?php 
        endforeach;
        } else { ?>
            <div class="row dyn_qc_row" >
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
                    <button class="btn btn-primary btn-outline-primary btn-icon btn_create_qc_elem" type="button"><i class="icofont icofont-plus"></i></button>
                    <button class="btn btn-primary btn-outline-danger btn-icon btn_remove_qc_elem" type="button"><i class="fa fa-remove"></i></button>
                </div>
            </div>
        <?php } ?>
    </div>
    
    
    <div class="row">
        <label class="col-sm-3 col-form-label">Display testing equipment</label>
        <div class="col-sm-6">
            
            <?php 
            $yes = "";
            $no = "checked";
            $display_equipments = false;
            if($company->display_testing_equipments == 1){
                $no = "";
                $yes = "checked";
                $display_equipments = true;
            }?>
            <div class="form-check form-check-inline">
                <label class="form-check-label">
                    <input class="form-check-input" type="radio" name="is_te_process" id="is_te_process_1" value="1" <?php echo $yes;?>> Yes
                </label>
            </div>
            <div class="form-check form-check-inline">
                <label class="form-check-label">
                    <input class="form-check-input" type="radio" name="is_te_process" id="is_te_process_2" value="0" selected="selected" <?php echo $no;?>> No
                </label>
            </div>
            <span class="messages"></span>
        </div>
    </div>
    <div class="te_container" id="te_container" <?php if(!$display_equipments){ echo "style='display:none'";}?>>
        <?php 
        $equipments = json_decode($company->testing_equipment_details); 
        if(count($equipments) > 0 ){
            foreach($equipments as $equipment):?>
            <div class="row dyn_te_row" >
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
                    <button class="btn btn-primary btn-outline-primary btn-icon btn_create_te_elem" type="button"><i class="icofont icofont-plus"></i></button>
                    <button class="btn btn-primary btn-outline-danger btn-icon btn_remove_te_elem" type="button"><i class="fa fa-remove"></i></button>
                </div>
            </div>

            <?php endforeach;
        } else { ?>
            <div class="row dyn_te_row" >
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
                    <button class="btn btn-primary btn-outline-primary btn-icon btn_create_te_elem" type="button"><i class="icofont icofont-plus"></i></button>
                    <button class="btn btn-primary btn-outline-danger btn-icon btn_remove_te_elem" type="button"><i class="fa fa-remove"></i></button>
                </div>
            </div>
       <?php } ?>
        
    </div>
    <button type="submit" class="btn btn-info pull-right">Submit</button>
</form>    