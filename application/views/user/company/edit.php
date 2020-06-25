<?php $this->load->view("user/common/header"); ?>
<div class="pcoded-content">
    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-header">
                    <div class="row align-items-end">
                        <div class="col-lg-8">
                            <div class="page-header-title">
                                <div class="d-inline">
                                    <h4>Company Details</h4>
                                    <span>Company Profile</span>
                                </div>
                            </div>
                            
                        </div>
                        <div class="col-lg-4">
                            <div class="page-header-breadcrumb">
                                <ul class="breadcrumb-title">
                                    <li class="breadcrumb-item">
                                        <a href="<?php echo site_url(); ?>seller/dashboard"> 
                                            <i class="feather icon-home"></i> 
                                        </a>
                                    </li>
                                    <li class="breadcrumb-item">
                                        <a href="<?php echo site_url(); ?>seller/Companyprofile">
                                            Company Details
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="page-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <?php echo $this->session->flashdata("message");?>
                            <div class="card">
                                <div class="card-header">
                                    <h5>Manage Company information </h5>
                                    <a target="_blank" href="<?php echo site_url()."company-details/".$company->company_name;?>" class="btn btn-link">
                                        My minisite
                                    </a>
                                    
                                </div>
                                <div class="card-block">
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12">
                                            
                                            <div class="sub-title">
                                                Business type selected : <?php echo $company->company_type;?>
                                                <button class="btn btn-link">
                                                    <i class="fa fa-edit"></i>
                                                </button>
                                            </div>
                                            <ul class="nav nav-tabs  tabs" role="tablist">
                                                <li class="nav-item">
                                                    <a class="nav-link active" data-toggle="tab" 
                                                    href="#basicinfo" role="tab" aria-expanded="true">
                                                        Basic Company Details
                                                    </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link" data-toggle="tab" 
                                                    href="#manufacturing" role="tab" aria-expanded="false">
                                                        Manufacturing Capability
                                                    </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link" data-toggle="tab" 
                                                    href="#quality" role="tab" aria-expanded="false">
                                                        Quality control
                                                    </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link" data-toggle="tab" 
                                                    href="#rnd" role="tab" aria-expanded="false">
                                                        R&D Capability
                                                    </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link" data-toggle="tab" 
                                                    href="#export" role="tab" aria-expanded="false">
                                                        Export Capacity
                                                    </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link" data-toggle="tab" 
                                                    href="#intro" role="tab" aria-expanded="false">
                                                        Introduction
                                                    </a>
                                                </li>
                                            </ul>
                                            <div class="tab-content tabs card-block">
                                                <div class="tab-pane active" id="basicinfo" role="tabpanel" aria-expanded="true">
                                                    <?php $this->load->view("user/company/basic");?>
                                                </div>
                                                <div class="tab-pane" id="manufacturing" role="tabpanel" aria-expanded="false">
                                                    <?php $this->load->view("user/company/manufacturing");?>
                                                </div>
                                                <div class="tab-pane" id="quality" role="tabpanel" aria-expanded="false">
                                                    <?php $this->load->view("user/company/quality");?>
                                                </div>
                                                <div class="tab-pane" id="rnd" role="tabpanel" aria-expanded="false">
                                                   <?php $this->load->view("user/company/rnd_capability");?>
                                                </div>
                                                <div class="tab-pane" id="export" role="tabpanel" aria-expanded="false">
                                                    <?php $this->load->view("user/company/export_capacity");?>
                                                </div>
                                                <div class="tab-pane" id="intro" role="tabpanel" aria-expanded="false">
                                                    <?php $this->load->view("user/company/intro");?>
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
<?php $this->load->view("user/common/footer"); ?>
<script>
$(document).ready(function(){
	
	
	/********************* Rnd Process *****************************/
	
	$("#is_rnd_process_1").click(function(){
        $("#rnd_container").show();
    });
    
    $("#is_rnd_process_2").click(function(){
        $("#rnd_container").hide();
    });
    
    $(".btn_create_rnd_elem").click(function(){
		
		$( ".dyn_rnd_row:last" ).clone(true).off().appendTo( "#rnd_container" ).find("input,textarea").val("").end();
		$(".dyn_rnd_row:last #remove_img  img:last-child").remove()
		$(".dyn_rnd_row:last input").prop('required',true);
		
    });
	
    $(".btn_remove_rnd_elem").click(function(){
        if($("#rnd_container > div.dyn_rnd_row").length > 1)
            $(this).closest(".dyn_rnd_row").remove();
    });
	
    /****************** Quality control Functions **********************/
    $("#is_qc_process_1").click(function(){
        $("#qc_container").show();
    });
    
    $("#is_qc_process_2").click(function(){
        $("#qc_container").hide();
    });
    
    $(".btn_create_qc_elem").click(function(){
        $( ".dyn_qc_row:last" ).clone(true).appendTo( "#qc_container" ).find("input,textarea").val("").end();
        $(".dyn_qc_row:last #remove_img2 img:last-child").remove()
        $(".dyn_qc_row:last input").prop('required',true);
    });
    
    $(".btn_remove_qc_elem").click(function(){
        if($("#qc_container > div.dyn_qc_row").length > 1)
            $(this).closest(".dyn_qc_row").remove();
    });
    
    $("#is_te_process_1").click(function(){
        $("#te_container").show();
    });
    
    $("#is_te_process_2").click(function(){
        $("#te_container").hide();
    });
    
    $(".btn_create_te_elem").click(function(){
        $( ".dyn_te_row:last" ).clone(true).appendTo( "#te_container" );
    });
    
    $(".btn_remove_te_elem").click(function(){
        if($("#te_container > div.dyn_te_row").length > 1)
            $(this).closest(".dyn_te_row").remove();
    });
    
    /****************** manufacturing Functions **********************/
    $("#is_prod_process_1").click(function(){
        $("#pp_container").show();
    });
    
    $("#is_prod_process_2").click(function(){
        $("#pp_container").hide();
    });
    
    $(".btn_create_pp_elem").click(function(){
        $( ".dyn_pp_row:last" ).clone(true).appendTo( "#pp_container" );
    });
    
    $(".btn_remove_pp_elem").click(function(){
        if($("#pp_container > div.dyn_pp_row").length > 1)
            $(this).closest(".dyn_pp_row").remove();
    });
    
    $("#is_prod_equipment_1").click(function(){
        $("#pe_container").show();
    });
    
    $("#is_prod_equipment_2").click(function(){
        $("#pe_container").hide();
    });
    
    $(".btn_create_pe_elem").click(function(){
        $( ".dyn_pe_row:last" ).clone(true).appendTo( "#pe_container" );
    });
    
    $(".btn_remove_pe_elem").click(function(){
        if($("#pe_container > div.dyn_pe_row").length > 1)
            $(this).closest(".dyn_pe_row").remove();
    });
    
    $("#is_prod_line_1").click(function(){
        $("#line_container").show();
    });
    
    $("#is_prod_line_2").click(function(){
        $("#line_container").hide();
    });
    
    $(".btn_create_line_elem").click(function(){
        $( ".dyn_line_row:last" ).clone(true).appendTo( "#line_container" );
    });
    
    $(".btn_remove_line_elem").click(function(){
        if($("#line_container > div.dyn_line_row").length > 1)
            $(this).closest(".dyn_line_row").remove();
    });
    
    
    $("#is_prod_capacity_1").click(function(){
        $("#capacity_container").show();
    });
    
    $("#is_prod_capacity_2").click(function(){
        $("#capacity_container").hide();
    });
    
    $(".btn_create_capacity_elem").click(function(){
        $( ".dyn_capacity_row:last" ).clone(true).appendTo( "#capacity_container" );
    });
    
    $(".btn_remove_capacity_elem").click(function(){
        if($("#capacity_container > div.dyn_capacity_row").length > 1)
            $(this).closest(".dyn_capacity_row").remove();
    });
	
	 /****************** Export Capacity  **********************/
	 
	
    $("#is_customer_case_1").click(function(){
        $("#customer_case_container").show();
    });
    
    $("#is_customer_case_2").click(function(){
        $("#customer_case_container").hide();
    });
	
	 $(".btn_customer_case_elem").click(function(){
        $( ".dyn_customer_case_container_row:last" ).clone(true).appendTo( "#customer_case_container" );
    });
    
    $(".btn_remove_customer_case_elem").click(function(){
        if($("#customer_case_container > div.dyn_customer_case_container_row").length > 1)
            $(this).closest(".dyn_customer_case_container_row").remove();
    });
	
	 $("#is_overseas_1").click(function(){
        $("#overseas_container").show();
    });
    
    $("#is_overseas_2").click(function(){
        $("#overseas_container").hide();
    });
	
	 $(".btn_overseas_elem").click(function(){
        $( ".dyn_overseas_container_row:last" ).clone(true).appendTo( "#overseas_container" );
    });
    
    $(".btn_remove_overseas_elem").click(function(){
        if($("#overseas_container > div.dyn_overseas_container_row").length > 1)
            $(this).closest(".dyn_overseas_container_row").remove();
    });
    
});
</script>