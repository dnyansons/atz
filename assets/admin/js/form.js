
    $(document).ready(function(){
    $("#production_process").hide();
    $('#customer_case_wrapper').hide();
    $('#company_wrapper').hide();
    $('#company_wrapper_2').hide();
    $('#company_second_wrapper').hide();
    $("#comp_panel").hide(); 
    $('#comp_panel_2').hide();
    $('#quality_demonstrate').hide();
    $('#quality_first').hide();
    $('#production_process').hide();
    $('#eq_row').hide();
    $('#prod_line').hide();
    $('#list').hide();
	$("#equipment_row1").hide(); 
    $("#production_yes").click(function(){
    $("#production_process").slideToggle("slow");
    
    });
    
    $("#second_row").hide();
    $("#add_plus").click(function(){
    $("#second_row").slideToggle("slow");
    
    });
    
    $("#prod_line").hide();
    $("#add_plus2").click(function(){
    $("#production_row").slideToggle("slow");
    
    });
    
    $("#minus").click(function(){ 
    $("#second_row").hide();
    
    });
    
    $("#delete").click(function(){
    $("#equipment_row").hide();
    
    });
    
    $("#product_row").hide();
    $("#delete3").click(function(){
    $("#product_row").hide();
    });
    
    $("#production_row").hide();	  
    $("#delete2").click(function(){
    $("#production_row").hide();
    });
    
    $("#eq_row").hide();
    $("#equipment_row").hide();
    $("#add_plus1").click(function(){
    $("#equipment_row").slideToggle("slow");
    });
    
    $("#equipment_row1").hide();
    $("#add_plus1").click(function(){
    $("#equipment_row1").slideToggle("slow");
    });
    });
    
    $("#quality_row1").hide(); 
    $("#delete_1").click(function(){
    $("#quality_row1").hide();
    });
    
	 $("#equipment_row").hide(); 
    $("#delete1").click(function(){
    $("#equipment_row").hide();
    });
    
    $("#add_demonstrate").click(function(){
    $("#quality_row1").slideToggle("slow");
    });
    
    $("#list").hide(); 
    $("#add_capacity").click(function(){
    $("#product_row").slideToggle("slow");
    });
    
    
    $("#com_logo").hide(); 
    $("#add_logo").click(function(){
    $("#com_logo").slideToggle("slow");
    });
    
      
    $("#delete4").click(function(){
    $("#com_logo").slideToggle("slow");
    $("#com_logo").hide();
    });
	
	
	
    
    
    //manufacturing capablity hide and show 
    $('#manufacturing_select').change(function(){
    var manufacturing_select = $(this).val();
    if (manufacturing_select == 'YES'){
    $('#production_process').show();
    }else{
    $('#production_process').hide();
    }
    });
    
    $('#manufacturing_select_2').change(function(){
    var manufacturing_select_2 = $(this).val();
    if (manufacturing_select_2 == 'YES'){
    $('#eq_row').show();
    }else{
    $('#eq_row').hide();
    }
    });
    
    $('#manufacturing_select_3').change(function(){
    var manufacturing_select_3 = $(this).val();
    if (manufacturing_select_3 == 'YES'){
    $('#prod_line').show();
    }else{
    $('#prod_line').hide();
    }
    });
    
    $('#manufacturing_select_4').change(function(){
    var manufacturing_select_4 = $(this).val();
    if (manufacturing_select_4 == 'YES'){
    $('#list').show();
    }else{
    $('#list').hide();
    }
    });
    
    
    
    //Quality Control hide and show code
    
    $('#quality_control_select').change(function(){
    var quality_control_select = $(this).val();
    if (quality_control_select == 'YES'){
    $('#quality_demonstrate').show();
    }else{
    $('#quality_demonstrate').hide();
    }
    });
    
    $('#quality_equipment').change(function(){
    var quality_equipment = $(this).val();
    if (quality_equipment == 'YES'){
    $('#quality_first').show();
    }else{
    $('#quality_first').hide();
    }
    });
    
    //Export Capability hide show code
    
    $('#customer_case').change(function(){
    var customer_case = $(this).val();
    if (customer_case == 'YES'){
    $('#customer_case_wrapper').show();
    }else{
    $('#customer_case_wrapper').hide();
    }
    });
    
    
    $('#company_overseas').change(function(){
    var company_overseas = $(this).val();
    if (company_overseas == 'YES'){
    $('#company_wrapper').show();
    $('#company_wrapper_2').hide();
    }else{
    $('#company_wrapper').hide();
    
    }
    });
    
    
    //company Info hide show code
    $('#attend_trend').change(function(){
    var attend_trend = $(this).val(); 
    if (attend_trend == 'YES'){
    $('#comp_panel').show();
    $('#comp_panel_2').hide();
    }else{
    $('#comp_panel').hide();
    
    }
    });
    
    
    
    $(function () {
    $('#datetimepicker1').datetimepicker();
    });
    									
