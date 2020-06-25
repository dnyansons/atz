window.onload = function() {
		var d = new Date().getTime();
		document.getElementById("tid").value = d;

	};
	
	/*input mask jquery script*/
	 $j=jQuery.noConflict();

    $j(document).ready(function () {

        $j(".cc-exp").inputmask("9999 9999 9999 9999");

    });

	$(function(){
      "use strict";
	 /* json object contains
	 	1) payOptType - Will contain payment options allocated to the merchant. Options may include Credit Card, Net Banking, Debit Card, Cash Cards or Mobile Payments.
	 	2) cardType - Will contain card type allocated to the merchant. Options may include Credit Card, Net Banking, Debit Card, Cash Cards or Mobile Payments.
	 	3) cardName - Will contain name of card. E.g. Visa, MasterCard, American Express or and bank name in case of Net banking. 
	 	4) status - Will help in identifying the status of the payment mode. Options may include Active or Down.
	 	5) dataAcceptedAt - It tell data accept at CCAvenue or Service provider
	 	6)error -  This parameter will enable you to troubleshoot any configuration related issues. It will provide error description.
	 */	  
  	  var jsonData;
  	  var access_code="AVVM67DI04BP90MVPB" // shared by CCAVENUE 
	  var amount="6000.00";
  	  var currency="INR";
  	  
      $.ajax({
           url:'https://secure.ccavenue.com/transaction/transaction.do?command=getJsonData&access_code='+access_code+'&currency='+currency+'&amount='+amount,
           dataType: 'jsonp',
           jsonp: false,
           jsonpCallback: 'processData',
           success: function (data) { 
                 jsonData = data;
                 // processData method for reference
                 processData(data); 
		 // get Promotion details
                 $.each(jsonData, function(index,value) {
			if(value.Promotions != undefined  && value.Promotions !=null){  
				var promotionsArray = $.parseJSON(value.Promotions);
		               	$.each(promotionsArray, function() {
					console.log(this['promoId'] +" "+this['promoCardName']);	
					var	promotions=	"<option value="+this['promoId']+">"
					+this['promoName']+" - "+this['promoPayOptTypeDesc']+"-"+this['promoCardName']+" - "+currency+" "+this['discountValue']+"  "+this['promoType']+"</option>";
					$("#promo_code").find("option:last").after(promotions);
				});
			}
		});
           },
           error: function(xhr, textStatus, errorThrown) {
               alert('An error occurred! ' + ( errorThrown ? errorThrown :xhr.status ));
               //console.log("Error occured");
           }
   		});
   		
   		$(".payOption").click(function(){
   			var paymentOption="";
   			var cardArray="";
   			var payThrough,emiPlanTr;
		    var emiBanksArray,emiPlansArray;
   			
           	paymentOption = $(this).val();
           // alert(paymentOption.replace("OPT",""));
           	$("#card_type").val(paymentOption.replace("OPT",""));
           	$("#card_name").children().remove(); // remove old card names from old one
            
           	$("#emi_div").hide();
         
         	if(paymentOption.replace("OPT","")=='CRDC')  		
			{

			$("#card_name").append("<option value=''>Select</option>");
			$.each(jsonData, function(index,value) {
           		//console.log(value);
           		if(paymentOption !="OPTEMI"){
	            	 if(value.payOpt==paymentOption){
	            		cardArray = $.parseJSON(value[paymentOption]);
	                	$.each(cardArray, function() {
	    	            	$(".credit_card_name").find("option:last").after("<option class='"+this['dataAcceptedAt']+" "+this['status']+"'  value='"+this['cardName']+"'>"+this['cardName']+"</option>");
	                	});
	                 }
	              }
	              
           	});


			} 
			else if(paymentOption.replace("OPT","")=='DBCRD')    
			{
				
				$(".credit_card_name").empty();
				$(".debit_card_name").append("<option value=''>Select</option>");
				$.each(jsonData, function(index,value) {
           		//console.log(value);
           		if(paymentOption !="OPTEMI"){
	            	 if(value.payOpt==paymentOption){
	            		cardArray = $.parseJSON(value[paymentOption]);
	            		// console.log("debitcardArrayy"+cardArray);
	                	$.each(cardArray, function() {

	    	            	// $(".debit_card_name").find("option:last").after("<option class='"+this['dataAcceptedAt']+" "+this['status']+"'  value='"+this['cardName']+"'>"+this['cardName']+"</option>");

	    	            	var decrd_arr="<option class='"+this['dataAcceptedAt']+" "+this['status']+"'  value='"+this['cardName']+"'>"+this['cardName']+"</option>";
	    	            	$(".debit_card_name").append(decrd_arr);		

	                	});
	                 }
	              }
	          
           	});

			}   
			else if(paymentOption.replace("OPT","")=='NBK')
			{
				$(".debit_card_name").empty();
				$(".credit_card_name").empty();
				$(".nb_card_name").append("<option value=''>Select</option>");
				$.each(jsonData, function(index,value) {
           		//console.log(value);
           		if(paymentOption !="OPTEMI"){
	            	 if(value.payOpt==paymentOption){
	            		cardArray = $.parseJSON(value[paymentOption]);
	            		// console.log("nbkArrayy"+cardArray);
	                	$.each(cardArray, function() {

	    	            	// $(".debit_card_name").find("option:last").after("<option class='"+this['dataAcceptedAt']+" "+this['status']+"'  value='"+this['cardName']+"'>"+this['cardName']+"</option>");

	    	            	var nbk_arr="<option class='"+this['dataAcceptedAt']+" "+this['status']+"'  value='"+this['cardName']+"'>"+this['cardName']+"</option>";
	    	            	$(".nb_card_name").append(nbk_arr);		

	                	});
	                 }
	              }
	              
	              
           	});

		}
         else if(paymentOption=='OPTEMI')
         {
         	$(".debit_card_name").empty();
			$(".credit_card_name").empty();
			$(".nb_card_name").empty();
         	$("#emi_div").show();

         	$.each(jsonData, function(index,value) { 		
		  			if(value.payOpt=="OPTEMI"){
		             
		              	$("#card_type").val("CRDC");
		              	$("#data_accept").val("Y");
		              	$("#emi_plan_id").val("");
						$("#emi_tenure_id").val("");
						$("span.emi_fees").hide();
		              	$("#emi_banks").children().remove();
		              	$("#emi_banks").append("<option value=''>Select your Bank</option>");
		              	$("#emi_tbl").children().remove();
		              	
	                    emiBanksArray = $.parseJSON(value.EmiBanks);
	                    emiPlansArray = $.parseJSON(value.EmiPlans);
	                	$.each(emiBanksArray, function() {
	                		// console.log("emibankslist"+payThrough);
	    	            	payThrough = "<option value='"+this['planId']+"' class='"+this['BINs']+"' id='"+this['subventionPaidBy']+"' label='"+this['midProcesses']+"'>"+this['gtwName']+"</option>";
	    	            	$("#emi_banks").append(payThrough);
	                	});
	                	
	                	emiPlanTr="<tr class='align-items'><td>&nbsp;</td><td class='align-items'>EMI Plan</td><td class='align-items'>Monthly Installments</td><td class='align-items'>Total Cost</td></tr>";
							
	                $.each(emiPlansArray, function() {
		                	emiPlanTr=emiPlanTr+
							"<tr class='tenuremonth "+this['planId']+"' id='"+this['tenureId']+"' style='display: none'>"+
								"<td> <input type='radio' name='emi_plan_radio' id='"+this['tenureMonths']+"' value='"+this['tenureId']+"' class='emi_plan_radio' > </td>"+
								"<td>"+this['tenureMonths']+ "EMIs. <label class='merchant_subvention'>@ <label class='emi_processing_fee_percent'>"+this['processingFeePercent']+"</label>&nbsp;%p.a</label>"+
								"</td>"+
								"<td>"+this['currency']+"&nbsp;"+this['emiAmount'].toFixed(2)+
								"</td>"+
								"<td><label class='currency'>"+this['currency']+"</label>&nbsp;"+ 
									"<label class='emiTotal'>"+this['total'].toFixed(2)+"</label>"+
									"<label class='emi_processing_fee_plan' style='display: none;'>"+this['emiProcessingFee'].toFixed(2)+"</label>"+
									"<label class='planId' style='display: none;'>"+this['planId']+"</label>"+
								"</td>"+
							"</tr>";
						});
						$("#emi_tbl").append(emiPlanTr);
	                 } 
	            });     
         	}
           	else if(paymentOption.replace("OPT","")=='WLT')
           	{

           		$(".debit_card_name").empty();
				$(".credit_card_name").empty();

				$.each(jsonData, function(index,value) {
           		//console.log(value);
           		if(paymentOption !="OPTEMI"){
	            	 if(value.payOpt==paymentOption){
	            		cardArray = $.parseJSON(value[paymentOption]);
	            		// console.log("wltarray"+cardArray);
	                	$.each(cardArray, function() {

	    	            	var wlt_arr="<option class='"+this['dataAcceptedAt']+" "+this['status']+"'  value='"+this['cardName']+"'>"+this['cardName']+"</option>";
	    	            	$(".wlt_card_name").append(wlt_arr);		

	                	});
	                 }
	              }
	              
           		});

           	}

         });
   
	  
      $("#card_name").click(function(){
      	if($(this).find(":selected").hasClass("DOWN")){
      		alert("Selected option is currently unavailable. Select another payment option or try again later.");
      	}
      	if($(this).find(":selected").hasClass("CCAvenue")){
      		$("#data_accept").val("Y");
      	}else{
      		$("#data_accept").val("N");
      	}
      });
          
     // Emi section start      
     /*on replace instead of live
     */
          $("#emi_banks").on("change",function(){
	           if($(this).val() != ""){
	           		var cardsProcess="";
	           		$("#emi_tbl").show();
	           		cardsProcess=$("#emi_banks option:selected").attr("label").split("|");
					$("#card_name").children().remove();
					$("#card_name").append("<option value=''>Select</option>");
				    $.each(cardsProcess,function(index,card){
				        $("#card_name").find("option:last").after("<option class=CCAvenue value='"+card+"' >"+card+"</option>");
				    });
					$("#emi_plan_id").val($(this).val());
					$(".tenuremonth").hide();
					$("."+$(this).val()+"").show();
					$("."+$(this).val()).find("input:radio[name=emi_plan_radio]").first().attr("checked",true);
					$("."+$(this).val()).find("input:radio[name=emi_plan_radio]").first().trigger("click");
					 
					 if($("#emi_banks option:selected").attr("id")=="Customer"){
						$("#processing_fee").show();
					 }else{
						$("#processing_fee").hide();
					 }
					 
				}else{
					$("#emi_plan_id").val("");
					$("#emi_tenure_id").val("");
					$("#emi_tbl").hide();
				}
				
				
				
				$("label.emi_processing_fee_percent").each(function(){
					if($(this).text()==0){
						$(this).closest("tr").find("label.merchant_subvention").hide();
					}
				});
				
		 });
		 
		 /*on replace instead of live*/
		 $(".emi_plan_radio").on("click",function(){
			var processingFee="";
			$("#emi_tenure_id").val($(this).val());
			processingFee=
					"<span class='emi_fees' >"+
			 			"Processing Fee:"+$(this).closest('tr').find('label.currency').text()+"&nbsp;"+
			 			"<label id='processingFee'>"+$(this).closest('tr').find('label.emi_processing_fee_plan').text()+
			 			"</label><br/>"+
                			"Processing fee will be charged only on the first EMI."+
                	"</span>";
             $("#processing_fee").children().remove();
             $("#processing_fee").append(processingFee);
             
             // If processing fee is 0 then hiding emi_fee span
             if($("#processingFee").text()==0){
             	$(".emi_fees").hide();
             }
			  
		});
		
		
		$("#card_number").focusout(function(){
			/*
			 emi_banks(select box) option class attribute contains two fields either allcards or bin no supported by that emi 
			*/ 
			if($('input[name="payment_option"]:checked').val() == "OPTEMI"){
				if(!($("#emi_banks option:selected").hasClass("allcards"))){
				  if(!$('#emi_banks option:selected').hasClass($(this).val().substring(0,6))){
					  alert("Selected EMI is not available for entered credit card.");
				  }
			   }
		   }
		  
		});
			
			
	/*
		track particular selection
	*/

	$(".payOption").on("click",function(e){
		// e.preventDefault();
		let set_val='';
		if($(this).val().replace("OPT","")=='CRDC' || $(this).val().replace("OPT","")=='DBCRD' || $(this).val().replace("OPT","")=='NBK' || $(this).val().replace("OPT","")=='EMI' || $(this).val().replace("OPT","")=='WLT')
		{	
			set_val='billdesk';
			$("#payment_name").val(set_val);	
		}else
		{
   			set_val='razorpay';
			$("#payment_name").val(set_val);	
		}
			
	});
   
   
   // below code for reference 
 
   function processData(data){
         var paymentOptions = [];
         var creditCards = [];
         var debitCards = [];
         var netBanks = [];
         var cashCards = [];
         var mobilePayments=[];
         $.each(data, function() {
         	 // this.error shows if any error   	
             console.log(this.error);
              paymentOptions.push(this.payOpt);
              switch(this.payOpt){
                case 'OPTCRDC':
                	var jsonData = this.OPTCRDC;
                 	var obj = $.parseJSON(jsonData);
                 	$.each(obj, function() {
                 		creditCards.push(this['cardName']);
                	});
                break;
                case 'OPTDBCRD':
                	var jsonData = this.OPTDBCRD;
                 	var obj = $.parseJSON(jsonData);
                 	$.each(obj, function() {
                 		debitCards.push(this['cardName']);
                	});
                break;
              	case 'OPTNBK':
	              	var jsonData = this.OPTNBK;
	                var obj = $.parseJSON(jsonData);
	                $.each(obj, function() {
	                 	netBanks.push(this['cardName']);
	                });
                break;
                
                case 'OPTCASHC':
                  var jsonData = this.OPTCASHC;
                  var obj =  $.parseJSON(jsonData);
                  $.each(obj, function() {
                  	cashCards.push(this['cardName']);
                  });
                 break;
                   
                  case 'OPTMOBP':
                  var jsonData = this.OPTMOBP;
                  var obj =  $.parseJSON(jsonData);
                  $.each(obj, function() {
                  	mobilePayments.push(this['cardName']);
                  });
              }
              
            });
           
           //console.log(creditCards);
          // console.log(debitCards);
          // console.log(netBanks);
          // console.log(cashCards);
         //  console.log(mobilePayments);
            
      }
  });


/*
	card validation details
*/	

function cardFormValidate(){
    var cardValid = 0;

    var valid = true;	 
    $(".demoInputBox").css('background-color','');
    var message = "";

    var cardHolderNameRegex = /^[a-z ,.'-]+$/i;
    var cvvRegex = /^[0-9]{3,3}$/;
    var regMonth = /^01|02|03|04|05|06|07|08|09|10|11|12$/;
    var regYear = /^2017|2018|2019|2020|2021|2022|2023|2024|2025|2026|2027|2028|2029|2030|2031$/;
    //card number validation
      
    if($("#card_name").val()=="" || $("#card_number").val() == "" || $("#cvv_number").val()=="" || $("#expiry_month").val()=="" || $("#expiry_year").val()=="") {
    	   message  += "<div>All Fields are Required.</div>";  
    	   if($("#card_name").val() == "") {
    		   $("#card_name").css('background-color','#FFFFDF');
    	   }
    	   if($("#card_number").val() == "") {
    		   $("#card_number").css('background-color','#FFFFDF');
    	   }
    	   if ($("#cvv_number").val() == "") {
    		   $("#cvv_number").css('background-color','#FFFFDF');
    	   }
    	   if ($("#expiry_month").val() == "") {
    		   $("#expiry_month").css('background-color','#FFFFDF');
    	   }
    	   if ($("#expiry_year").val() == "") {
    		   $("#expiry_year").css('background-color','#FFFFDF');
    	   }
       valid = false;
    }


     if($("#card_number").val() != "") {
        // 	$('#card_number').validateCreditCard(function(result){
        //     if(!(result.valid)){
        //         	message  += "<div>Card Number is Invalid</div>";    
        //     		$("#card_number").css('background-color','#FFFFDF');
        //     		valid = false;
        //     }
        // });


        validateCCNum($("#card_number").val());
    }

    
    if ($("#cvv_number").val() != "" && !cvvRegex.test($("#cvv_number").val())) {
        message  += "<div>CVV is Invalid</div>";    
        $("#cvv_number").css('background-color','#FFFFDF');
    		valid = false;
    }

    if (!regMonth.test($("#expiry_month").val())) {
        $("#card_number").removeClass('required');
        $("#expiry_month").addClass('required');
        $("#expiry_month").focus();
        return false;
    }

    if (!regYear.test($("#expiry_year").val())) {
        $("#card_number").removeClass('required');
        $("#expiry_month").removeClass('required');
        $("#expiry_year").addClass('required');
        $("#expiry_year").focus();
        return false;
    }

    if(message != "") {
        $("#error-message").show();
        $("#error-message").html(message);
    }
}
$(document).ready(function() {
    //card validation on input fields
    $('#paymentForm .cc-exp').on('keyup',function(){
        cardFormValidate();
    });
});


function validateCCNum(ccnum)
{
    var ccCheckRegExp = /[^\d\s-]/;
    var isValid = !ccCheckRegExp.test(ccnum);
    var i;

    if (isValid) {
        var cardNumbersOnly = ccnum.replace(/[\s-]/g,"");
        var cardNumberLength = cardNumbersOnly.length;

        var arrCheckTypes = ['visa', 'mastercard', 'amex', 'discover', 'dinners', 'jcb'];
        for(i=0; i<arrCheckTypes.length; i++) {
            var lengthIsValid = false;
            var prefixIsValid = false;
            var prefixRegExp;

            switch (arrCheckTypes[i]) {
                case "mastercard":
                    lengthIsValid = (cardNumberLength === 16);
                    prefixRegExp = /^5[1-5]/;
                    break;

                case "visa":
                    lengthIsValid = (cardNumberLength === 16 || cardNumberLength === 13);
                    prefixRegExp = /^4/;
                    break;

                case "amex":
                    lengthIsValid = (cardNumberLength === 15);
                    prefixRegExp = /^3([47])/;
                    break;

                case "discover":
                    lengthIsValid = (cardNumberLength === 15 || cardNumberLength === 16);
                    prefixRegExp = /^(6011|5)/;
                    break;

                case "dinners":
                    lengthIsValid = (cardNumberLength === 14);
                    prefixRegExp = /^(300|301|302|303|304|305|36|38)/;
                    break;

                case "jcb":
                    lengthIsValid = (cardNumberLength === 15 || cardNumberLength === 16);
                    prefixRegExp = /^(2131|1800|35)/;
                    break;

                default:
                    prefixRegExp = /^$/;
            }

            prefixIsValid = prefixRegExp.test(cardNumbersOnly);
            isValid = prefixIsValid && lengthIsValid;

            // Check if we found a correct one
            if(isValid) {

            	var $messageDiv = $('#success-message'); // get the reference of the div
				$messageDiv.show().html('<strong><center>Valid Card.!</center></strong>'); // show and set the message
				setTimeout(function(){ $messageDiv.hide().html('');}, 3000);

                break;
            }
        }
    }

    if (!isValid) {
    	
    		var $messageDiv = $('#error-message'); // get the reference of the div
			$messageDiv.show().html('<strong><center>Invalid Card.!</center></strong>'); // show and set the message
			setTimeout(function(){ $messageDiv.hide().html('');}, 3000);

       	 return false;
    }

    // Remove all dashes for the checksum checks to eliminate negative numbers
    ccnum = ccnum.replace(/[\s-]/g,"");
    // Checksum ("Mod 10")
    // Add even digits in even length strings or odd digits in odd length strings.
    var checksum = 0;
    for (i = (2 - (ccnum.length % 2)); i <= ccnum.length; i += 2) {
        checksum += parseInt(ccnum.charAt(i - 1));
    }

    // Analyze odd digits in even length strings or even digits in odd length strings.
    for (i = (ccnum.length % 2) + 1; i < ccnum.length; i += 2) {
        var digit = parseInt(ccnum.charAt(i - 1)) * 2;
        if (digit < 10) {
            checksum += digit;
        } else {
            checksum += (digit - 9);
        }
    }

    return (checksum % 10) === 0;
}




// $("#final_payment_section").hide();
// $(".payment").on("click",function(e){
// 	e.preventDefault();
// $('#loading').show();
// $("#final_payment_section").show();
// $(".d-block").show();
// $(".main").hide();
// })