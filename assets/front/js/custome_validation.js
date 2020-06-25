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
    

$(function() {
    $("form[name='login_form']").validate({
        rules: {
            username: "required",
            password: "required"
        },
        messages: {
            username: "please enter email or mobile",
            password: "please enter password"
        },
        submitHandler: function(a) {
            a.submit();
        },
        errorClass: "text-danger text"
    });
    $("form[name='sign_up']").validate({
        rules: {
            email: {
                required : true,
                email : true,
            },
            mobile_number: "required",
            mobile_number: {
                minlength: 10,
                maxlength: 10,
                required: true,
                digits: true,
                number: true
            }
        },
        messages: {
            email: {
                required : "Please Enter the email id",
                email : "Please Enter the valid email id",
            },
            mobile_number: "Please enter the valid mobile number"
        },
        submitHandler: function(a) {
            a.submit();
        },
        errorClass: "text-danger text"
    });
    $("form[name='verify_otp']").validate({
        rules: {
            otp: "required"
        },
        messages: {
            otp: "please enter otp "
        },
        submitHandler: function(a) {
            a.submit();
        },
        errorClass: "text-danger text"
    });
    $("form[name='general_info']").validate({
        rules: {
            first_name: {
                lettersonly: true,
                required: true
            },
            last_name: {
                lettersonly: true,
                required: true
            },
            password: "required",
            country: "required",
            state: "required",
            city: "required",
            address: "required",
            mobile_number: "required",
            mobile_number: {
                minlength: 10,
                maxlength: 10,
                required: true,
                digits: true,
                number: true
            },
            pincode:{
                required:"true",
                digits:true,
                maxlength:6,
                minlength:6,
            },
        },
        messages: {
            first_name: "Please enter first name",
            last_name: "Please enter last name",
            email: "Please enter email ",
            mobile_number: "Please enter mobile number",
            country: "Please select the country",
            state: "Please select the state",
            city: "Please enter the city",
            address: "Please enter the address",
            pincode:"Please enter the pin code "
        },
        submitHandler: function(a) {
            a.submit();
        },
        errorClass: "text-danger text"
    });
    $("form[name='change_email']").validate({
        rules: {
            email: "required",
            otp: "required"
        },
        messages: {
            email: "Please enter an valid email",
            otp: "Please enter otp here"
        },
        submitHandler: function(a) {
            a.submit();
        },
        errorClass: "text-danger"
    });
    $("form[name='update_acc_name']").validate({
        rules: {
            first_name: "required",
            last_name: "required",
            first_name: {
                lettersonly: true,
                required: true
            },
            last_name: {
                lettersonly: true,
                required: true
            }
        },
        messages: {
            first_name: "Please enter first name",
            last_name: "Please enter last name"
        },
        submitHandler: function(a) {
            a.submit();
        },
        errorClass: "text-danger text"
    });
    $("form[name='change_password']").validate({
        rules: {
            old_password: "required",
            new_password: "required",
            confirm_password: "required"
        },
        messages: {
            old_password: "Please enter old password",
            new_password: "Please enter new password",
            confirm_password: "Please confirm password"
        },
        submitHandler: function(a) {
            a.submit();
        },
        errorClass: "text-danger text"
    });
    $("form[name='add_address']").validate({
        rules: {
            country: "required",
            contact_person: "required",
            contact_number: "required",
            street1: "required",
            street2: "required",
            city: "required",
            state: "required",
            postal_code: "required"
        },
        messages: {
            country: "Please select country first",
            contact_person: "Please enter contact person name",
            contact_number: "Please enter contact number",
            street1: "Please enter street first",
            street2: "Please enter street second",
            city: "Please enter city",
            state: "Please enter state",
            postal_code: "Please enter postal code"
        },
        submitHandler: function(a) {
            a.submit();
        },
        errorClass: "text-danger text"
    });
    $("form[name='security_ques']").validate({
        rules: {
            questions1: "required",
            answer1: "required",
            questions2: "required",
            answer2: "required",
            questions3: "required",
            answer3: "required"
        },
        messages: {
            questions1: "Please select question first",
            answer1: "Please enter answer here",
            questions2: "Please select questions second",
            answer2: "Please enter answer here",
            questions3: "Please select questions third",
            answer3: "Please enter answer here"
        },
        submitHandler: function(a) {
            a.submit();
        },
        errorClass: "text-danger text"
    });
    $("form[name='one_request']").validate({
        rules: {
            product_name: "required",
            quantity: "required",
            unit: "required"
        },
        messages: {
            product_name: "Please enter product name ",
            quantity: "Please enter quantity ",
            unit: "Please select unit"
        },
        submitHandler: function(a) {
            a.submit();
        },
        errorClass: "text-danger"
    });
    $("form[name='contact_supplier']").validate({
        rules: {
            for_product: "required",
            quantity: "required",
            unit: "required",
            product_description: "required",
            userFiles: "required"
        },
        messages: {
            for_product: "Please enter product name ",
            quantity: "Please enter quantity ",
            unit: "Please select unit",
            product_description: "Please enter discripation",
            userFiles: "Please chosse the file or image"
        },
        submitHandler: function(a) {
            a.submit();
        },
        errorClass: "text-danger text"
    });
    $("form[name='create_account']").validate({
        rules: {
            first_name: "required",
            last_name: "required",
            phone: "required",
            email: {
                email: true,
                required: true
            },
            password: "required",
            phone: {
                minlength: 10,
                maxlength: 10,
                required: true,
                digits: true
            },
            first_name: {
                lettersonly: true,
                required: true
            },
            last_name: {
                lettersonly: true,
                required: true
            }
        },
        messages: {
            first_name: "Please enter valid first name ",
            last_name: "Please enter valid last name",
            phone: "Please enter the valid number",
            email: "Please enter valid email",
            password: "Please enter password here"
        },
        submitHandler: function(a) {
            a.submit();
        },
        errorClass: "text-danger text"
    });
    $("form[name='verify_mobile']").validate({
        rules: {
            otp: "required"
        },
        messages: {
            otp: "Please enter otp here "
        },
        submitHandler: function(a) {
            a.submit();
        },
        errorClass: "text-danger text"
    });
    $("form[name='create_profile']").validate({
        rules: {
            company_name: "required",
            company_type: "required",
            product_category: "required",
            address_line_1: "required",
            pin_code: "required",
            country: "required",
            state: "required",
            city: "required",
//            company_name: {
//                lettersonly: true,
//                required: true
//            }
        },
        messages: {
            company_name: "enter company name",
            company_type: "select company type",
            product_category: "select product category",
            address_line_1: "enter address here",
            pin_code: "enter pin code",
            country: "select country code",
            state: "select state first",
            city: "enter city name"
        },
        submitHandler: function(a) {
            a.submit();
        },
        errorClass: "text-danger text"
    });
    $("form[name='tax_info']").validate({
        rules: {
            gst_no: {
                required : true,
                maxlength:15
            },
            pan_type: "required",
            pan_no: {
                required : true,
                pattern : /[a-zA-z]{5}\d{4}[a-zA-Z]{1}/
            }
        },
        messages: {
            gst_no: "Enter GST number",
            pan_type: "Select PAN type",
            pan_no: {
                required : "Enter valid PAN Number",
                pattern : "Enter valid PAN Number ",
            },

        },
        submitHandler: function(a) {
            a.submit();
        },
        errorClass: "text-danger text"
    });

    $("form[name='frm_sumbit_rfq']").validate({
        rules: {
			product_name: "required",
            categories_id: "required",
            unit: "required",
            product_specification: "required",
			quantity : {
				 required:true,
				digits:true,
			},
        },
        messages: {
			product_name:"Please Enter Product",
            categories_id: "Select category",
            quantity: "Enter quantity in digits",
            unit: "Select Unit",
            product_specification: "Enter Descrition"
        },
        submitHandler: function(a) {
            a.submit();
        },
        errorClass: "text-danger text"
    });

    //     $("form[name='add_shipping_address']").validate({
    //     rules: {
    //         contact_person:{
    //             lettersonly:true,
    //             required:true,
    //         },
    //         country: "required",
    //         street: "required",
    //         city: {
    //             lettersonly:true,
    //             required:true,
    //         },
    //         state:{
    //             lettersonly:true,
    //             required:true,
    //         },
    //         postcode:{
    //             digits:true,
    //             required:true,
    //         },
    //         contact_number:{
    //             digits:true,
    //             required:true,
    //             minlength:10,
    //             maxlength:10,
    //         },
            
    //     },
    //     messages: {
    //         contact_person: "please enter contact name",
    //         country: "please select country",
    //         street: "please enter street address",
    //         city: "please enter city name",
    //         state: "please enter state name",
    //         postcode: "please enter zip code ",
    //         contact_number: "please enter valid mobile number",
    //     },
    //      showErrors: function(errorMap, errorList) {
    //         console.log(errorList)
    //     if(errorList.length) {
    //         $("#contact_person").html(errorList[0].message);
    //         $("#country").html(errorList[1].message);
    //         $("#street").html(errorList[2].message);
    //         $("#city").html(errorList[3].message);
    //         $("#state").html(errorList[4].message);
    //         $("#postcode").html(errorList[5].message);
    //         $("#contact_number").html(errorList[6].message);
    //     }
    // },
    //     submitHandler: function(a) {
    //         a.submit();
    //     },

    // });

});