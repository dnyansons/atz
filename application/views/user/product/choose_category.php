<?php $this->load->view("user/common/header");?>
<div class="pcoded-content">
    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-header">
                    <div class="row align-items-end">
                        <div class="col-lg-8">
                            <div class="page-header-title">
                                <div class="d-inline">
                                    <h4>Choose category</h4>
                                    <?php 
                                          $chosenCategoryId = $this->session->selected_category;
                                          $data = $this->Categories_model->getAllParentCategoriesByChildCategory($chosenCategoryId);
                                    ?>
                                      <div>
                                          <br>
                                          You have selected : 
                                             <?php echo $data->level2parent ?> >> <?php echo $data->level1parent ?> >> <b> <?php echo $data->self_category_name; ?></b>
                                      </div>

                                    
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="page-header-breadcrumb">
                                <ul class="breadcrumb-title">
                                    <li class="breadcrumb-item">
                                        <a href="<?php echo site_url();?>seller/dashboard"> <i class="feather icon-home"></i> </a>
                                    </li>
                                    <li class="breadcrumb-item"><a href="#">Choose Category</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="page-body">
                    <div class="row">
                        <div class="col-md-12">
                            
                            <div class="card">
                                
                                <div class="row card-block">
                                    <div class="col-md-3 col-lg-3">
                                        <div class="card card-block user-card">
                                            <ul class="scroll-list wave level1">
                                                <?php foreach($rootCats as $cat):
                                                echo "<li><a href='#' data-cid='$cat->category_id'><h6>$cat->categories_name</h6></a></li>";    
                                                endforeach;?>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-lg-3">
                                        <div class="card card-block user-card">
                                            <ul class="scroll-list wave level2">
                                                
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-lg-3">
                                        <div class="card card-block user-card">
                                            <ul class="scroll-list wave level3">
                                                
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-lg-3">
                                        <div class="card card-block user-card">
                                            <ul class="scroll-list wave level4">
                                                
                                            </ul>
                                        </div>
                                    </div>
									<div id = "cat_error" style= "color:red" class="col-md-12"></div>
                                    <div class="card-footer">
                                        <form action="<?php echo site_url();?>seller/products/create" method="post" id="frmSetCat">
                                            <input type="hidden" name="category_id" value="0" id="category_id">
                                            <button type="button" id="btnSubmit" class="btn btn-info btn-sm">Submit</button>
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
</div>    
<?php $this->load->view("user/common/footer");?>
<script>
$(document).ready(function(){
    $(".level1").on("click","a",function(){
        var cat = $(this).attr("data-cid");
        $("#category_id").val("");
        $("#category_id").val(cat);
        //console.log(cat);
        $.ajax({
            type:"post",
            url:"<?php echo site_url();?>seller/products/ajaxChildCats",
            datatype:"json",
            data:{cat_id:cat},
            success:function(resp){
                //console.log(resp);
                var output = JSON.parse(resp);
                if(output.status){
                    $(".level2").empty();
                    $(output.items).each(function(index,value){
                        $(".level2").append("<li><a href='#' data-cid="+value.category_id+"><h6>"+value.categories_name+"</h6></a></li>");
                    });
                }
            }
                
        });
    })
    
    $(".level2").on("click","a",function(){
        var cat = $(this).attr("data-cid");
        $("#category_id").val("");
        $("#category_id").val(cat);
        //console.log(cat);
        $.ajax({
            type:"post",
            url:"<?php echo site_url();?>seller/products/ajaxChildCats",
            datatype:"json",
            data:{cat_id:cat},
            success:function(resp){
                //console.log(resp);
                var output = JSON.parse(resp);
                if(output.status){
                    $(".level3").empty();
                    $(output.items).each(function(index,value){
                        $(".level3").append("<li><a href='#' data-cid="+value.category_id+"><h6>"+value.categories_name+"</h6></a></li>");
                    });
                }
            }
                
        });
        
        var cat = $(this).attr("data-cid");
        $("#category_id").val(cat);
    })
    
    $(".level3").on("click","a",function(){
        var cat = $(this).attr("data-cid");
        $("#category_id").val(cat);
        console.log(cat);
    });
    
    $("#btnSubmit").click(function(){
        console.log($("#category_id").val());
        if($("#category_id").val() != 0){
             $("#frmSetCat").submit();
        }else{
			$("#cat_error").html('<div class="alert alert-danger alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Note!</strong> Selecting a Category is mandatory.</div>');
		}
    });
});   
</script>