<form action="<?php echo site_url(); ?>seller/companyprofile/rndcapability" method="post" enctype="multipart/form-data">
    <input type="hidden" name="com" value="<?php echo $company->pcompany_id;?>">
    <div class="row">
        <label class="col-sm-3 col-form-label">Whether to show R & D process</label>
        <div class="col-sm-6">
            <?php 
            $yes = "";
            $no = "checked";
            $display_rnd_control_process = false;
            if($company->display_rnd_control_process == 1){
                $no = "";
                $yes = "checked";
                $display_rnd_control_process = true;
            }?>
            <div class="form-check form-check-inline">
                <label class="form-check-label">
                    <input class="form-check-input" type="radio" name="is_rnd_process" id="is_rnd_process_1" value="1" <?php echo $yes;?>> Yes
                </label>
            </div>
            <div class="form-check form-check-inline">
                <label class="form-check-label">
                    <input class="form-check-input" type="radio" name="is_rnd_process" id="is_rnd_process_2" value="0" <?php echo $no;?>> No
                </label>
            </div>
            <span class="messages"></span>
        </div>
    </div>
    <div class="rnd_container" id="rnd_container" <?php if(!$display_rnd_control_process){ echo "style='display:none'";}?>>
            <?php 
        $processes = json_decode($company->rnd_details);
        if(count($processes) > 0 ){
            foreach($processes as $process):?>
			<div class="row dyn_rnd_row" >
                <label class="col-sm-3 col-form-label"> </label>
                <div class="col-sm-6">
                    <div class="well">
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label"><span style="color:red">*</span>Process name: </label>
                            <div class="col-sm-9">
                                <input type="text" name="process_name[]" class="form-control" value="<?php echo $process->name;?>" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label"><span style="color:red">*</span>Process Picture:</label>
                            <div class="col-sm-9">
                                <input type="file" name="process_image[]" class="form-control">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label"></label>
                            <div class="col-md-6" id="remove_img">
                                <?php $url = $process->image; ?>
                                <img class="img img-bordered img-thumbnail" src="<?php echo $url;?>">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label"><span style="color:red">*</span>Process Describe:</label>
                            <div class="col-sm-9">
                                <textarea name="process_description[]" class="form-control" required><?php echo $process->description;?></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <button class="btn btn-primary btn-outline-primary btn-icon btn_create_rnd_elem" type="button"><i class="icofont icofont-plus"></i></button>
                    <button class="btn btn-primary btn-outline-danger btn-icon btn_remove_rnd_elem" type="button"><i class="fa fa-remove"></i></button>
                </div>
            </div>
        <?php 
        endforeach;
        } else { ?>
            <div class="row dyn_rnd_row" >
                <label class="col-sm-3 col-form-label"> </label>
                <div class="col-sm-6">
                    <div class="well">
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label"><span style="color:red">*</span>Process name:</label>
                            <div class="col-sm-9">
                                <input type="text" name="process_name[]" class="form-control" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label"><span style="color:red">*</span>Process Picture:</label>
                            <div class="col-sm-9">
                                <input type="file" name="process_image[]" class="form-control" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label"><span style="color:red">*</span>Process Describe:</label>
                            <div class="col-sm-9">
                                <textarea name="process_description[]" class="form-control" required></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <button class="btn btn-primary btn-outline-primary btn-icon btn_create_rnd_elem" type="button"><i class="icofont icofont-plus"></i></button>
                    <button class="btn btn-primary btn-outline-danger btn-icon btn_remove_rnd_elem" type="button"><i class="fa fa-remove"></i></button>
                </div>
            </div>
        <?php } ?>
    </div>    
    <button type="submit" class="btn btn-info pull-right">Submit</button>
</form>    