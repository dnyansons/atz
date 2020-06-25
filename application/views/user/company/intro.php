<form action="<?php echo site_url(); ?>seller/companyprofile/introduction" method="post" enctype="multipart/form-data">
    <input type="hidden" name="com" value="<?php echo $company->pcompany_id;?>">
    <div class="form-group row">
        <label class="col-sm-3 col-form-label">Logo</label>
        <div class="col-sm-6">
            <input type="file" name="logo" class="form-control">
            <p class="text-muted">
                200KB max. JPEG, PNG format only. Suggested photo width and height: 100*100px.
            </p>
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-3 col-form-label"></label>
        <div class="col-sm-6">
            <img class="img img-thumbnail" src="<?php echo $company->logo;?>">
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-3 col-form-label">Introduction</label>
        <div class="col-sm-6">
            <textarea name="introduction" rows="5" class="form-control"><?php echo $company->introduction;?></textarea>
        </div>
    </div>
    

    <button type="submit" class="btn btn-info pull-right">Submit</button>
</form>