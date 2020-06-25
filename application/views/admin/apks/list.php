<?php $this->load->view("admin/common/header");?>
<div class="pcoded-content">
    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-header">
                    <div class="row align-items-end">
                        <div class="col-lg-8">
                            <div class="page-header-title">
                                <div class="d-inline">
                                    <h4><?php echo $pageTitle;?></h4>	
                                    <span></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="page-header-breadcrumb">
                                <ul class="breadcrumb-title">
                                    <li class="breadcrumb-item">
                                        <a href="<?php echo site_url();?>admin/dashboard"> <i class="feather icon-home"></i> </a>
                                    </li>
                                    <li class="breadcrumb-item"><?php echo $pageTitle;?></li>
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
                                    <div class="dt-responsive table-responsive">
                                        <table id="list_table" class="table table-striped table-bordered nowrap">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
						    <th>Version</th>
						    <th>Platform</th>
                                                    <th>Is Current</th>
                                                    <th>Uploaded on</th>
						    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $i = 1; foreach($apks as $apk):?>
                                                <tr>
                                                    <td><?php echo $i;?></td>
                                                    <td><?php echo $apk->version;?></td>
                                                    <td><?php echo $apk->platform;?></td>
                                                    <td>
                                                        <?php 
                                                        if($apk->is_current){
                                                            echo "<label class='label label-success'>Current</label>";
                                                        } else {
                                                            echo "<label class='label label-danger'>Previous</label>";
                                                        }
                                                        ?>
                                                    </td>
                                                    <td><?php echo $apk->uploaded_on;?></td>
                                                    <td>
                                                        <a href="#" class="label label-info btnFeatures" data-id="<?php echo $apk->id;?>">
                                                            View Features
                                                        </a>
                                                    </td>
                                                </tr>
                                                <?php $i++; endforeach;?>
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
<div class="md-modal md-effect-4" id="modal-4">
    <div class="md-content">
        <h3>Apk Featues</h3>
        <div>
            <p>This apk was uploaded with following featues</p>
            <p id="features_container"></p>
            <button type="button" class="btn btn-primary waves-effect md-close">Close</button>
        </div>
    </div>
</div>
<script>
$(document).ready(function() {
   $('#list_table').DataTable();
   
   $(document).on('click', '.btnFeatures', function () {
        var apk_id = $(this).attr("data-id");
        if(pid){
            $.ajax({
                    url : "<?php echo site_url();?>admin/mobileapps/getfeatues",
                    data : {product_id:pid},
                    type : "post",
                    success:function(data){
                        var obj = JSON.parse(data);
                        $("#features_container").html("");
                        if(obj.status){
                            $("#features_container").html(obj.data);
                        }
                    }
            });
        }
    });
});

    
</script>
<?php $this->load->view("admin/common/footer");?>
