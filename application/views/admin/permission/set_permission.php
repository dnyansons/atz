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
                           <h4>Set Permission</h4>
						   <br>
						   <h5><b>User :</b> <?php echo $user_info['admin_username']; ?>  <b>Role :</b> <?php echo $user_info['role_name']; ?></h5>
						  
                        </div>
                     </div>
                  </div>
                  <div class="col-lg-4">
                     <div class="page-header-breadcrumb">
                        <ul class="breadcrumb-title">
                           <li class="breadcrumb-item">
                              <a href="<?php echo site_url();?>admin/dashboard"> <i class="feather icon-home"></i> </a>
                           </li>
                           <li class="breadcrumb-item"><a href="#!">Set</a></li>
                           <li class="breadcrumb-item"><a href="#!">Set Permission</a></li>
                        </ul>
                     </div>
                  </div>
               </div>
            </div>
            <div class="page-body">
               <div class="row">
                  <div class="col-sm-12">
                     <div class="card">
                        <div class="card-header">
                           <div class="card-header-right">
                              <i class="icofont icofont-spinner-alt-5"></i>
                           </div>
                        </div>
                        <div class="card-block">
                          
                           <form method="post" enctype="multipart/form-data" action="<?php echo base_url().$action; ?>">
						   <table class="table table-striped table-bordered nowrap">
							  <tr class="alert alert-info">
								<th>SrNo<input type="hidden" name="user_id" value="<?php echo $user_info['admin_id']; ?>"></th>
								<th>Menu</th>
								<th>Sub Menu</th>
								<th><input type="checkbox" id="ckbCheckAll0" /> Sidebar</th>
								<th><input type="checkbox" id="ckbCheckAll1" /> View </th>
								<th><input type="checkbox" id="ckbCheckAll2" /> Add</th>
								<th><input type="checkbox" id="ckbCheckAll3" /> Edit</th>
								<th><input type="checkbox" id="ckbCheckAll4" /> Delete</th>
								
							  </tr>
                              <?php
							  $i=1;
							  foreach($menu as $m)
							  {
							  ?>
							  <tr>
								<td><?php  echo $i; ?></td>
								<th>
								
										<input type="hidden" name="menu_id<?php echo $i; ?>" value="<?php echo $m['menu_id']; ?>"><?php if($m['parent_id']==0){  echo $m['menu_name']; } else { echo '<img src="'.base_url().'assets/admin/arrow.png" style="width:20px;float:right;">'; } ?>			
								</th>
								<td>
									<?php if($m['parent_id']!=0){ echo $m['menu_name']; } else { echo '--'; } ?>
								</td>
								<td><input type="checkbox" value="1" <?php if($m['sidebar']==1){ echo 'checked';} ?> name="sidebar<?php echo $i; ?>" class="checkBoxClass0"></td>
								<td><input type="checkbox" value="1" <?php if($m['view']==1){ echo 'checked';} ?> name="view<?php echo $i; ?>" class="checkBoxClass1"></td>
								
								<td><input type="checkbox" value="1" <?php if($m['add']==1){ echo 'checked';} ?> name="add<?php echo $i; ?>" class="checkBoxClass2"></td>
								
								<td><input type="checkbox" value="1" <?php if($m['edit']==1){ echo 'checked';} ?> name="edit<?php echo $i; ?>" class="checkBoxClass3"></td>
								
								<td><input type="checkbox" value="1" <?php if($m['delete']==1){ echo 'checked';} ?> name="delete<?php echo $i; ?>" class="checkBoxClass4"></td>
								
							  </tr>
							 
								  <?php
									$i++;
								  } ?>
								 
							   </table>
							    <input type="hidden" name="tot_record" value="<?php echo $i; ?>">
                              <button type="submit" id="submit_brand" class="btn btn-primary pull-right" id="primary-popover-content">Set Permission</button>
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
</div>
</div>
</div>
<?php $this->load->view("admin/common/footer");?>
<script>
   $(document).ready(function () {
	   
	    /////////////////////////Zero ///////////////
    $("#ckbCheckAll0").click(function () {
        $(".checkBoxClass0").prop('checked', $(this).prop('checked'));
    });
    
    $(".checkBoxClass1").change(function(){
        if (!$(this).prop("checked")){
            $("#ckbCheckAll0").prop("checked",false);
        }
    });
	   /////////////////////////One ///////////////
    $("#ckbCheckAll1").click(function () {
        $(".checkBoxClass1").prop('checked', $(this).prop('checked'));
    });
    
    $(".checkBoxClass1").change(function(){
        if (!$(this).prop("checked")){
            $("#ckbCheckAll1").prop("checked",false);
        }
    });
	
	/////////////////////////Two ///////////////
	$("#ckbCheckAll2").click(function () {
        $(".checkBoxClass2").prop('checked', $(this).prop('checked'));
    });
    
    $(".checkBoxClass2").change(function(){
        if (!$(this).prop("checked")){
            $("#ckbCheckAll2").prop("checked",false);
        }
    });
	
	
	/////////////////////////Three/////////////////////////
	$("#ckbCheckAll3").click(function () {
        $(".checkBoxClass3").prop('checked', $(this).prop('checked'));
    });
    
    $(".checkBoxClass3").change(function(){
        if (!$(this).prop("checked")){
            $("#ckbCheckAll3").prop("checked",false);
        }
    });
	
	
	//////////////////////////Four////////////////////
	$("#ckbCheckAll4").click(function () {
        $(".checkBoxClass4").prop('checked', $(this).prop('checked'));
    });
    
    $(".checkBoxClass4").change(function(){
        if (!$(this).prop("checked")){
            $("#ckbCheckAll4").prop("checked",false);
        }
    });
});
   
</script>
