<?php $this->load->view("user/common/header");?>
<style>
    .loader {
  border: 16px solid #f3f3f3; /* Light grey */
  border-top: 16px solid #3498db; /* Blue */
  border-radius: 50%;
  width: 20px;
  height: 20px;
  animation: spin 2s linear infinite;
  margin-left: 45%;
}

@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}
    </style>
<div class="pcoded-content">
    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-header">
                    <div class="row align-items-end">
                        <div class="col-lg-8">
                            <div class="page-header-title">
                                <div class="d-inline">
                                    <h4>My Account</h4>
                                    <span></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="page-header-breadcrumb">
                                <ul class="breadcrumb-title">
                                    <li class="breadcrumb-item">
                                        <a href="<?php echo site_url();?>seller/dashboard"> <i class="feather icon-home"></i> </a>
                                    </li>
                                    <li class="breadcrumb-item"><a href="#">Change email</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="page-body">
                    <div class="row">
                        <div class="col-sm-8">
                            <div class="card">
				<div   style="text-align:center;"><div style="display:none;" class="loader"></div></div>				
                                <div class="card-header">
                                    <h4 class="sub-title">Change email</h4>
                                    <?php echo $this->session->flashdata("message");?>
                                     
                                </div>
                                <div class="card-block">
                                   
								<div id="messege"></div>
                                    <form method="post" action="<?php echo site_url();?>seller/myaccount/change_email_address" name="change_email">
                                        <div class="form-group row">
                                            <label class="control-label col-md-3">Email</label>
                                            <div class="col-md-6">
                                                <input type="email" id="email" name="email" value="<?php echo set_value('email');?>" class="form-control">
                                               <div style="color:red" id="email_error"> <?php echo form_error("email");?></div>
                                            </div>
                                            <div class="com-md-3">
                                                <button id="btnGetOtp" class="btn btn-info btn-sm" type="button">Get otp</button>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="control-label col-md-3">Otp</label>
                                            <div class="col-md-6">
                                                <input type="text" name="otp" maxlength="6" value="<?php echo set_value('otp');?>" class="form-control">
                                                <div style="color:red"><?php echo form_error("otp");?></div>
                                            </div>
                                        </div>
										<hr>
                                        <input type="submit" class="btn btn-success btn-sm pull-right">
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
<?php $this->load->view("user/common/footer");?>        
<script>
$(document).ready(function(){
   $("#btnGetOtp").click(function(){
      var email = $("#email").val();
      if(email!=""){
          $.ajax({
              type : "POST",
              url : "<?php echo site_url();?>seller/myaccount/ajax_send_otp",
              data : {email:email},
               beforeSend: function(){
        $('.loader').show();
    },
              success : function(resp){
				  var data = JSON.parse(resp);
                  console.log(data);
				  if(data.status == 0)
				  {
					  $("#email_error").text("Invalid Email!");
				  }else if(data.status == 2)
				  {
					  $("#messege").html("<div class='alert alert-danger alert-dismissible'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><strong>note!</strong> Email Should not be same as current email!!</div>");
				   }else if(data.status == 1){
					    $("#messege").html("<div class='alert alert-success alert-dismissible'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><strong>Success!</strong> Check Your Email For OTP!!</div>");
					    $("#email_error").html("");
						
				  }else{
					   $("#messege").html("<div id='login-error' class='form-error notice notice-error'><span class='icon-notice icon-error'></span><span><strong>Failed!</strong> Email Not Sent!</span></div>");
				  }
                                   $('.loader').hide();
              },    
          });
      }else{
		  $('#email_error').text("Email is required");
	  }
   }); 
});
</script>