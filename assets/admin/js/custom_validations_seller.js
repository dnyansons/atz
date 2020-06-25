    jQuery.validator.addMethod("lettersonly", function(value, element) {
    return this.optional(element) || /^[a-z\s]+$/i.test(value);
}, "Letters only please"); 

jQuery.validator.addMethod(
        "regex",
        function(value, element, regexp) {
            var re = new RegExp(regexp);
            return this.optional(element) || re.test(value);
        },
        "Please check your input."
);
function getWordCount(wordString) {
    var words = wordString.split(" ");
    words = words.filter(function (words) {
        return words.length > 0
    }).length;
    return words;
}

//add the custom validation method
jQuery.validator.addMethod("wordCount",
   function(value, element, params) {
      var count = getWordCount(value);
      if(count >= params[0]) {
         return true;
      }
   },
   jQuery.validator.format("A minimum of {0} words is required here.")
);



$("#form_basic_company_details").validate({
   rules : {
       company_name : "required",
       registration_year : "required",
       registered_country : "required",
       comp_operational_addr : "required",
       comp_operational_city : "required",
       comp_operational_state : "required",
       comp_operational_region : "required",
       comp_operational_zip_code : "required",
       employee_count : "required",
       office_size : "required",
       legal_owner : "required",
       company_advantage : {
           required : true,
           wordCount: ['30']
       },
comp_operational_zip_code:{
    required:true,
    digits:true,
    minlength:6,
    maxlength:6,
},
   
   },
   messages : {
       company_name : "Please Enter company name",
       registration_year : "Please Select incorporation year",
       registered_country : "Please Enter Country",
       comp_operational_addr : "Please Enter Address",
       comp_operational_city : "Please Enter City",
       comp_operational_state : "Please Enter Province/State/Country",
       comp_operational_region : "Please Enter Region",
       comp_operational_zip_code : "Please Enter Valid Zipcode/Postcode",
       employee_count : "Please  Enter no of employees",
       office_size : "Please Enter Office size",
       legal_owner : "Please Enter name",
       company_advantage : {
           required : "Please Enter description"
       },
   },
   errorClass : "text-danger"
});


$(function(){


//add bank

$("form[name='add_bank']").validate({
   rules : {
       bank : "required",
       account_no : "required",
       ifsc_code : "required",
      account_holder_name:{
          // lettersonly: true,
          required:"true",
      }
    
   },
   messages : {
        bank : "select the bank first",
       account_holder_name : "please enter account holder name",
       account_no : "please enter account number",
       ifsc_code : "please enter ifsc code",
      
       
   },
    submitHandler: function(form) {
            form.submit();
        },
   errorClass : "text-danger"
});

//add address

$("form[name='add_address']").validate({
   rules : {
       seller_name : "required",
       seller_email : {
           require : true,
           email : true,
       },
       seller_mobile : "required",
       address_type : "required",
       address : {
           required : true,
           maxlength: 30
       },
       state : "required",
       country : "required",
       pincode:{
           required : true,
           maxlength: 6
       },
       office_close:"required",
      
      seller_mobile:{
        minlength:10,
        maxlength:10,
        required:true,
        digits:true,
      }

   },

   messages : {

        seller_name : "Please enter seller name",
        seller_email : {
            required : "Enter email",
            email: "Enter valid email"
        },
        seller_mobile : {
            minlength:"Enter 10 Digit mobile number",
            maxlength:"Enter 10 Digit mobile number",
            required:"Enter 10 Digit mobile number",
            digits:"Enter 10 Digit mobile number",
        },
        address_type : "Select addred type",
        address : {
            required : "Enter max 30 character address",
            maxlength : "Enter max 30 character address"
        },
        state : "please enter state",
        country : "please select country",
        pincode:"please enter pin code",

   },
   errorClass : "text-danger"
});

//uploade documents
$("form[name='upload_doc']").validate({
   rules : {
       certificate_title : "required",
       //files: "required",
       // files:{
       //  required: true,
       //  extension:'jpeg,png,gif,pdf',
       //  uploadFile:true,
       // },

       certificate_title:{
        //lettersonly:true,
        required:true,
       }
     
   },
   messages : {
        certificate_title : "Please Enter Title",
       // files: "please select the file",
     
   },

    submitHandler: function(form) {
            form.submit();
        },
   errorClass : "text-danger"
});
//my_acc change password
$("form[name='change_pass']").validate({
   rules : {
      old_password :"required",
       new_password:"required",
       confirm_password:"required",
        confirm_password: {
                    passwordMatch: true,
                }
   },
   messages : { 
        old_password :"enter old password ",
       new_password:"enter new password",
       confirm_password:"enter confirm password same as new password",
     
   },
    submitHandler: function(form) {
            form.submit();
        },
   errorClass : "text-danger"
});
// change email
$("form[name='change_email']").validate({
   rules : {
      email :"required",
       otp:"required",
       
   },
   messages : {
        email :"please enter email address ",
       otp:"please enter otp",
     
   },
    submitHandler: function(form) {
            form.submit();
        },
   errorClass : "text-danger"
});
//security question

$("form[name='security_qtn']").validate({
     rules: {
            questions1: "required",
            answer1: "required",
            questions2: "required",
            answer2: "required",
            questions3: "required",
            answer3: "required",
        },
        messages: {
            questions1: "please select question first",
            answer1: "please enter answer here",
            questions2: "please select questions second",
            answer2: "please enter answer here",
            questions3: "please select questions third",
            answer3: "please enter answer here",
        },
    submitHandler: function(form) {
            form.submit();
        },
   errorClass : "text-danger"
});

//edit profile
$("form[name='edit_profile']").validate({
     rules: {
            first_name: "required",
            last_name: "required",
            company_type: "required",
            address: "required",
            company_name: "required",

            first_name:{
              lettersonly:true,
              required:true,
            },
            last_name:{
              lettersonly:true,
              required:true,
            }
        },
        messages: {
            first_name: "please enter first name ",
            last_name: "please enter last name",
            company_type: "please select company type",
            address: "please add the address",
            company_name: "please add the company name",
        },
    submitHandler: function(form) {
            form.submit();
        },
   errorClass : "text-danger"
});

})