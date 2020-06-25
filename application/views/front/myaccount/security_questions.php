<?php $this->load->view("front/common/header"); ?>
<style>    
input, textarea, select{
	border:1px solid #ccc !important;}
.modal-dialog {
	max-width:500px; 
	margin: 1.75rem auto;}
.card-header{
	background:none;}
.card{
	padding:1rem 1rem;
	box-shadow: 2px 2px 3px rgba(0, 0, 0, .1);}
body{
	height:auto;}
input[type="text"]{
	width:100%;}
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
				Security Questions
				</span>
			</li>
		</ol>
		
<br>
    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
               
                <div class="page-body m-auto" style="width:600px;">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="card">
								
                                <div class="card-header">
                                    <h4 class="sub-title">Set Security Questions</h4>
                                    <?php echo $this->session->flashdata("message");?>
                                </div>
                                <div class="card-block">
			
			
									<div class="row">
										<div class="col-sm-12">
											<br>
											<div id="note">
											 <?php if($success){echo $success;}?>
											</div>
											
											<?php if($update){ ?>
											
												<a  href="<?php echo base_url(); ?>Security-questions/<?php echo $update ?>"><button type="button" name="submit_brand" id="submit_brand" class="btn btn-primary pull-right" id="primary-popover-content">update</button></a>
											
											<?php }else{ ?>
											 <form action= "" method="post" id="submit_form" name="security_ques">
												<div class="form-group row">
													<label class="col-sm-12 col-form-label">Questions 1</label>
													<div class="col-sm-12">
														<select name="questions1" id="questions1" class="form-control" value="<?php echo set_value('questions1'); ?>">
														</select>
														<div style="color:red"><?php echo form_error('questions1'); ?></div>
													</div>
												</div>
												
												<div class="form-group row">
													<label class="col-sm-12 col-form-label">Answer</label>
													<div class="col-sm-12">
														<input type="text" name="answer1" class="form-control" placeholder="Answer" value="<?php echo set_value('answer1'); ?>">
														<div style="color:red"><?php echo form_error('answer1'); ?></div>
													</div>
												</div>
												
												<div class="form-group row">
													<label class="col-sm-12 col-form-label">Questions 2</label>
													<div class="col-sm-12">
														<select name="questions2" id="questions2" class="form-control" value="<?php echo set_value('questions2'); ?>">
														</select>
														<div style="color:red"><?php echo form_error('questions2'); ?></div>
													</div>
												</div>
												
												<div class="form-group row">
													<label class="col-sm-12 col-form-label">Answer</label>
													<div class="col-sm-12">
														<input type="text" name="answer2" class="form-control" placeholder="Answer" value="<?php echo set_value('answer2'); ?>">
														<div style="color:red"><?php echo form_error('answer2'); ?></div>
													</div>
												</div>
												
												<div class="form-group row">
													<label class="col-sm-12 col-form-label">Questions 3</label>
													<div class="col-sm-12">
														<select name="questions3" id="questions3" class="form-control" value="<?php echo set_value('questions3'); ?>">
														</select>
														<div style="color:red"><?php echo form_error('questions3'); ?></div>
													</div>
												</div>
												
												<div class="form-group row">
													<label class="col-sm-12 col-form-label">Answer</label>
													<div class="col-sm-12">
														<input type="text" name="answer3" class="form-control" placeholder="Answer" value="<?php echo set_value('answer3'); ?>">
														<div style="color:red"><?php echo form_error('answer3'); ?></div>
													</div>
												</div>
												<br>
												<div class="col-sm-12">
												<button type="submit" name="submit_brand" id="submit_brand" class="btn btn-primary pull-right " id="primary-popover-content" onclick = "validate_questions()">Submit</button>
												</div>
											</form>
											<?php } ?>
											
											
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
<br><br>
<?php $this->load->view("front/common/footer");?>
<script>
$(document).ready(function(){
	
	$.ajax({
			url: '<?php echo site_url("buyer/myaccount/ajax_get_questions");?>',
			type: 'POST',
			dataType: 'json',
			success: function(data){
				if(data)
				{
					var opt = "<option value=0>Please Select</option>";
					$.each(data,function(obj, val){
						opt += '<option value='+val.id+'>'+val.questions+'</option>';
					});
					$("#questions1").html(opt);
					$("#questions2").html(opt);
					$("#questions3").html(opt);
				}
	
			},
		error: function(e){
			}
		});
});

function validate_questions()
{
	
	var dropdwn_one  = $("#questions1").val();
	var dropdwn_two = $("#questions2").val();
	var dropdwn_three = $("#questions3").val();
	var flag = 0;
	
	if(dropdwn_one == 0 && dropdwn_two == 0 && dropdwn_three==0 )
	{
		alert('All Fields Are Mandatory');
	}
	if(dropdwn_one == dropdwn_two || dropdwn_two == dropdwn_three || dropdwn_three == dropdwn_one)
	{
		flag++;
		$("#note").html("<div class='alert alert-danger alert-dismissible'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><strong>Note!</strong> All the selected questions from dropdown should different!!</div>");
	}
	
	if(flag == 0)
	{
		$("#submit_form").submit();
	}
	
}
</script>

