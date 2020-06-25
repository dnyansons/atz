
$(function() {
 //login page validation
  $("form[name='login_form']").validate({
  
    rules: {
     
      username: "required",
      password: "required",
      
    },
    
    messages: {
      username: "Please enter email or mobile",
      password: "Please enter password",
      
     
    },
    submitHandler: function(form) {
      form.submit();
    },
    errorClass:"text-danger"
  });

//sign in page validation
  $("form[name='sign_up']").validate({
  
    rules: {
     
      email: "required",
      mobile_number: "required",
      
    },
    
    messages: {
      email: "Please enter email ",
      mobile_number: "Please enter mobile number",
     
    },
    submitHandler: function(form) {
      form.submit();
    },
    errorClass:"text-danger"
  });

//verify otp page
  $("form[name='verify_otp']").validate({
  
    rules: {
     
      otp: "required",
     
  
    },
    
    messages: {
      otp: "please enter otp ",
     
    },
    submitHandler: function(form) {
      form.submit();
    },
    errorClass:"text-danger"
  });

//general info page 

$("form[name='general_info']").validate({
  
    rules: {
     
      first_name: "required",
      password:"required",
      country:"required",
      state:"required",
      city:"required",
      address:"required",

      

    },
    
    messages: {
      email: "Please enter email ",
      mobile_number: "Please enter mobile number",
      country:"please select the country",
      state:"please select the state",
      city:"please enter the city",
      address:"please enter the address",
     
    },
    submitHandler: function(form) {
      form.submit();
    },
    errorClass:"text-danger"
  });

//change email 
  $("form[name='change_email']").validate({
  
    rules: {
     
      email: "required",
      otp:"required",
  
      

    },
    
    messages: {
      email: "please enter email",
      otp:"please enter otp here",
    },
    submitHandler: function(form) {
      form.submit();
    },
    errorClass:"text-danger"
  });

  //update account name
  $("form[name='update_acc_name']").validate({
  
    rules: {
     
      first_name: "required",
      last_name:"required",
  
      

    },
    
    messages: {
      first_name: "please enter first name",
      last_name:"please enter last name",
    },
    submitHandler: function(form) {
      form.submit();
    },
    errorClass:"text-danger"
  });

//change password page 
  $("form[name='change_password']").validate({
  
    rules: {
     
      old_password: "required",
      new_password:"required",
      confirm_password:"required",
  

    },
    
    messages: {
      old_password: "please enter old password",
      new_password:"please enter new password",
      confirm_password:"please confirm password"
    },
    submitHandler: function(form) {
      form.submit();
    },
    errorClass:"text-danger"
  });

  // Add new Address page
$("form[name='add_address']").validate({
  
    rules: {
     
      country: "required",
      contact_person:"required",
      contact_number:"required",
      street1:"required",
      street2:"required",
      city:"required",
      state:"required",
      postal_code:"required",


    },
    
    messages: {
      country: "please select country first",
      contact_person:"please enter contact person name",
      contact_number:"please enter contact number",
      street1:"please enter street first",
      street2:"please enter street second",
      city:"please enter city",
      state:"please enter state",
      postal_code:"please enter postal code",
    },
    submitHandler: function(form) {
      form.submit();
    },
    errorClass:"text-danger"
  });

// set sequrity questions page
  $("form[name='security_ques']").validate({
  
    rules: {
     
      questions1: "required",
      answer1:"required",
      questions2:"required",
      answer2:"required",
      questions3:"required",
      answer3:"required",
  
      
    },
    
    messages: {
      questions1: "please select question first",
      answer1:"please enter answer here",
      questions2:"please select questions second",
      answer2:"please enter answer here",
      questions3:"please select questions third",
      answer3:"please enter answer here",
    },
    submitHandler: function(form) {
      form.submit();
    },
    errorClass:"text-danger"
  });

   // request for quote
   $("form[name='one_request']").validate({
  
    rules: {
     
      product_name: "required",
      quantity:"required",
      unit:"required",
      
  
      
    },
    
    messages: {
      product_name: "please enter product name ",
      quantity:"please enter quantity ",
      unit:"please select unit",
      
    },
    submitHandler: function(form) {
      form.submit();
    },
    errorClass:"text-danger"
  });


//supplier contact page

   $("form[name='contact_supplier']").validate({
  
    rules: {
     
      for_product: "required",
      quantity:"required",
      unit:"required",
      product_description:"required",
      userFiles:"required",
      
  
      
    },
    
    messages: {
      for_product: "please enter product name ",
      quantity:"please enter quantity ",
      unit:"please select unit",
      product_description:"please enter discripation",
      userFiles:"please chosse the file or image"
      
    },
    submitHandler: function(form) {
      form.submit();
    },
    errorClass:"text-danger"
  });

//m.atzcart register validation


   $("form[name='m_register']").validate({
  
    rules: {
     
      mobile_number: "required",
      email:"required",
      password:"required",
      
      
  
      
    },
    
    messages: {
      mobile_number: "please enter product name ",
      email:"please enter quantity ",
      password:"please enter password here"
      
      
    },
    submitHandler: function(form) {
      form.submit();
    },
    errorClass:"text-danger"
  });

});

