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
                           <h4>Sort Menu</h4>
						  
                        </div>
                     </div>
                  </div>
                  <div class="col-lg-4">
                     <div class="page-header-breadcrumb">
                        <ul class="breadcrumb-title">
                           <li class="breadcrumb-item">
                              <a href="<?php echo site_url();?>admin/dashboard"> <i class="feather icon-home"></i> </a>
                           </li>
                           <li class="breadcrumb-item"><a href="#!">Sort</a></li>
                           <li class="breadcrumb-item"><a href="#!">Sort Menu</a></li>
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
						<h6 style="text-align:center;"><?php echo $this->session->flashdata('message'); ?></h6>
                        <div class="card-block">
                          
                           <form method="post" enctype="multipart/form-data" action="<?php echo base_url().$action; ?>">
						   <table class="table table-striped table-bordered nowrap">
							  <tr class="alert alert-info">
								<th>SrNo</th>
								<th>Menu</th>
								<th>Arrange</th>
							  </tr>
							  <?php
							  $i=1;
								foreach($menu as $m)
								{ ?>
									<tr>
									<th><?php echo $i; ?></th>
									<th><?php echo $m->menu_name; ?><input type="hidden" name="menu_id<?php echo $i; ?>" value="<?php echo $m->menu_id; ?>"></th>
									<th><input type="number" name="arrange<?php echo $i; ?>" value="<?php echo $m->sort_by; ?>" required></th>
									</tr>
								<?php 
								   $i++;
								}
							  ?>
                              
								 
							   </table>
							    <input type="hidden" name="tot_record" value="<?php echo $i; ?>">
                              <button type="submit" id="submit_brand" class="btn btn-primary pull-right" id="primary-popover-content">Arrange</button>
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
<?php $this->load->view("admin/common/footer");?>