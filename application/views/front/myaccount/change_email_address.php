<style>
body{height:auto;}    
input, textarea, select{
border:1px solid #ccc !important;
}
.modal-dialog {
max-width:500px; 
margin: 1.75rem auto;
}
.llebel label{
display:flex;
align-items:center;
}
.maincenter-box label{
margin:10px 0;
}
.card-header{
background:none;
}
.maincenter-box p{
 margin-bottom:2px !important;
}

.card{
padding:1rem 1rem;
box-shadow: 2px 2px 3px rgba(0, 0, 0, .1); 

}
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
<!-- Services section -->
<div class="container">
<ol id="breadcrumb_CNEP" class="a-ordered-list a-horizontal breadcrumb mt-20">
			<li class="breadcrumb-item "><span class="a-list-item ">
				<a class="a-link-normal" href="<?php echo base_url(); ?>buyer-dashboard">
				Your Account
				</a>
				</span>
			</li>
			<li class="breadcrumb-item "><span class="a-list-item ">
				<a class="a-link-normal" href="<?php echo base_url(); ?>login-security">
				Login &amp; Security
				</a>
				</span>
			</li>
			
			
			<li class="breadcrumb-item active"><span class="a-list-item a-color-state">
				Change Email Address
				</span>
			</li>
		</ol>
<br>
    <div class="pcoded-inner-content mt-0">
        <div class="main-body">
            <div class="page-wrapper">
               
                <div class="page-body m-auto"  style="width:500px;">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="llebel maincenter-box">
								 <div class="card">
                                <div class="card-header">
                                    <h4 class="sub-title">Change Email</h4>
                                    
                                </div>
                                <div class="card-block">
                                    <div   style="text-align:center;"><div style="display:none;" class="loader"></div></div>

								<div id="message"></div><br>
                                    <form method="post" action="" name="change_email">
                                        <div class="form-group row">
                                            <label class="control-label col-md-12">Email</label>
                                            <div class="col-md-10">
                                                <input type="email" id="email" name="email" value="<?php echo set_value('email');?>" class="form-control">
                                                <p id="email_error" style="color:red"></p>
                                            </div>
                                            <div class="com-md-2">
                                                <button id="btnGetOtp" class="btn btn-info btn-sm" type="button">Get OTP</button>
                                            </div>
                                        </div>
										 
                                        <div class="form-group row" id="otp_div">
                                            <label class="control-label col-md-12">OTP</label>
                                            <div class="col-md-10">
                                                <input type="text" name="otp" maxlength="6" value="<?php echo set_value('otp');?>" style="width:100% !important;" class="form-control" id="otp">
                                                <div style="color:red"><?php echo form_error("otp");?></div>
												<p id="otp_error" style="color:red;"></p>
                                            </div>
                                             <div class="com-md-2"></div>
                                        </div>
                                       
										<hr style="margin:20px 0;">
								
										<button id="submitbutton" class="btn btn-primary btn-sm pull-right" style="width:150px;margin-bottom: 5px;margin-right: 5px;" type="button">Submit</button>
                                    
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
     <br><br> 
     <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script>
    
$(document).ready(function(){
    $("#otp_div").hide();
	$("#submitbutton").attr("disabled", true);
   $("#btnGetOtp").click(function(){
      var email = $("#email").val();
      if(email!=""){
          $.ajax({
              type : "POST",
              url : "<?php echo site_url();?>buyer/myaccount/ajax_send_otp_for_change_email",
              data : {email:email},
               beforeSend: function(){
        $('.loader').show();
    },
              success : function(resp){
                  var data = JSON.parse(resp);
				  if(data.status == 0)
				  {
						$("#email_error").text("Invalid Email!");
				  }else if(data.status == 2)
				  {
						$("#message").html("<div class='alert alert-danger alert-dismissible'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><strong>Error!</strong> Email Should not be same as current email!!</div>");
				   }else if(data.status == 1){
					    $("#message").html("<div class='alert alert-success alert-dismissible'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><strong>Success!</strong> Check Your Email For OTP!!</div>");
						$("#otp_div").show();
						$("#submitbutton").attr("disabled", false); 
						$("#email").attr("disabled", true);
                        $("#email_error").html("");
						
				  }else{
					   $("#message").html("<div class='alert alert-danger alert-dismissible'><strong>Failed!</strong> Email Not Sent!</div>");
				  }
                  $('.loader').hide();
              },    
          });
      }else{
		  $('#email_error').text("Email is required");
	  }
   }); 
   
   
    $("#submitbutton").click(function(){
		var email = $("#email").val();
		var otp = $("#otp").val();
		if(otp!=""){
		 $.ajax({
			  type : "POST",
			  url : "<?php echo site_url();?>buyer/myaccount/change_email",
			  data : {email:email, otp:otp},
			  success : function(resp){
				  var data = JSON.parse(resp);
				 if(data.status == 0)
				  {
						$("#message").html("<div class='alert alert-danger alert-dismissible'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><strong>Error!</strong> Invalid OTP!.</div>");
						$("#otp_div").show();
						$("#email_error").html("");
				   }else if(data.status == 2){
						$("#message").html("<div class='alert alert-danger alert-dismissible'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><strong>Error!</strong> Email Address Already Exist ! Plz Use Another Email Address!.</div>");
						$("#otp_div").hide();
						$("#email_error").html("");

				  }else{
					   $("#message").html("<div class='alert alert-success alert-dismissible'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><strong>Success!</strong> Email Changed Successfully!.</div>");
					   $("#otp_div").hide();
					   $("#email_error").html("");
				  }
			  },
		  });
		   }else{
		  $('#otp_error').text("Please Enter OTP!");
	  }
   });
   
   
});




</script>
