<?php 
//echo "<pre>";
//print_r($cats);
//exit;
?>
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
                                    <h4>Sms Templates</h4>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="page-header-breadcrumb">
                                <ul class="breadcrumb-title">
                                    <li class="breadcrumb-item">
                                        <a href="<?php echo site_url(); ?>admin/dashboard"> <i class="feather icon-home"></i> </a>
                                    </li>
                                    <li class="breadcrumb-item"><a href="#">Sms Template Masters</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="page-body">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="sub-title">update sms template</h4>
                                </div>
                                <div class="card-block">
                                    <?php echo $this->session->flashdata("message");?>
                                    <form action="<?php echo site_url(); ?>admin/smstemplates/" method="post">
                                        <div class="form-group">
                                            <label for="name">Name:</label>
                                            <?php echo form_dropdown('name', $cats, 'large',"class='form-control' id='selName'");?>
                                        </div>
                                        <div class="form-group" id="dynContainer" >
                                            <label class="control-label">Template</label>
                                            <textarea name="template" class="form-control" rows="5" id="rtxtTemplate"></textarea>
                                        </div>
                                        <input type="submit" class="btn btn-info btn-sm float-right" value="submit">
                                    </form> 
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
</div>
<?php $this->load->view("admin/common/footer");?>
<script>
$(document).ready(function(){
    $("#selName").change(function(){
        //debugger;
        var name = $(this).val();
        console.log(name);
        if(name){
            $.ajax({
                url:"<?php echo site_url();?>admin/smstemplates/ajaxGet",
                type:"POST",
                data:{name:name},
                success:function(resp){
                    var obj = JSON.parse(resp);
                    if(obj.status){
                        $("textarea#rtxtTemplate").val(obj.data);
                        //$("#dynContainer").show();
                    } else {
                        $("textarea#rtxtTemplate").val("");
                        //$("#dynContainer").hide();
                    }
                },
            });
        }
    });
});    
</script>