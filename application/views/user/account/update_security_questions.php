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
							<h4>Update Security Questions</h4>

							</div>
						</div>
					</div>
					<div class="col-lg-4">
						<div class="page-header-breadcrumb">
							<ul class="breadcrumb-title">
								<li class="breadcrumb-item">
								<a href="<?php echo base_url(); ?>seller/dashboard"> <i class="feather icon-home"></i> </a>
								</li>
								<li class="breadcrumb-item"><a href="<?php echo base_url();?>seller/myaccount">My Account</a>
								</li>
								<li class="breadcrumb-item"><a href="#!">Add Questions</a>
								</li>
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
						<div class="card-block">
						<div id="note">
						 <?php if($success){echo $success;}?>
						</div>
						
						<h4 class="sub-title">Security Questions</h4>
						 <form action= "" method="post" id="submit_form">
							<div class="form-group row">
								<label class="col-sm-2 col-form-label">Questions 1</label>
								<div class="col-sm-10">
									<select name="questions1" id="questions1" class="form-control" >
									</select>
									<div style="color:red"><?php echo form_error('questions1'); ?></div>
								</div>
							</div>
							
							<div class="form-group row">
								<label class="col-sm-2 col-form-label">Answer</label>
								<div class="col-sm-10">
									<input type="text" name="answer1" class="form-control" placeholder="Answer" value="<?php echo $result->answer_one; ?>">
									<input type="hidden" name="row_id"  value="<?php echo $result->id; ?>">
									<div style="color:red"><?php echo form_error('answer1'); ?></div>
								</div>
							</div>
							
							<div class="form-group row">
								<label class="col-sm-2 col-form-label">Questions 2</label>
								<div class="col-sm-10">
									<select name="questions2" id="questions2" class="form-control" >
									</select>
									<div style="color:red"><?php echo form_error('questions2'); ?></div>
								</div>
							</div>
							
							<div class="form-group row">
								<label class="col-sm-2 col-form-label">Answer</label>
								<div class="col-sm-10">
									<input type="text" name="answer2" class="form-control" placeholder="Answer" value="<?php echo $result->answer_two; ?>" >
									<div style="color:red"><?php echo form_error('answer2'); ?></div>
								</div>
							</div>
							
							<div class="form-group row">
								<label class="col-sm-2 col-form-label">Questions 3</label>
								<div class="col-sm-10">
									<select name="questions3" id="questions3" class="form-control" >
									</select>
									<div style="color:red"><?php echo form_error('questions3'); ?></div>
								</div>
							</div>
							
							<div class="form-group row">
								<label class="col-sm-2 col-form-label">Answer</label>
								<div class="col-sm-10">
									<input type="text" name="answer3" class="form-control" placeholder="Answer" value="<?php echo $result->answer_three; ?>">
									<div style="color:red"><?php echo form_error('answer3'); ?></div>
								</div>
							</div>
							
							<button type="button" name="submit_brand" id="submit_brand" class="btn btn-primary pull-right" id="primary-popover-content" onclick = "validate_questions()">Submit</button>
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
<?php $this->load->view("user/common/footer"); ?>
<script>
$(document).ready(function(){
	
	var question_one = '<?Php echo $result->question_id_one; ?>';
	var question_two = '<?Php echo $result->question_id_two; ?>';
	var question_three = '<?Php echo $result->question_id_three; ?>';

	$.ajax({
			url: '<?php echo site_url("seller/myaccount/ajax_get_questions");?>',
			type: 'POST',
			dataType: 'json',
			success: function(data){
				if(data)
				{
					var opt1 = "<option value=0>Please Select</option>";
					var opt2 = "<option value=0>Please Select</option>";
					var opt3 = "<option value=0>Please Select</option>";
					$.each(data,function(obj, val){
						if(val.id == question_one){
							opt1 += '<option value='+val.id+' selected>'+val.questions+'</option>';
						}else{
							opt1 += '<option value='+val.id+' >'+val.questions+'</option>';
						}
					
						if(val.id == question_two){	
							opt2 += '<option value='+val.id+' selected>'+val.questions+'</option>';
						} else {
							opt2 += '<option value='+val.id+' >'+val.questions+'</option>';
						} 
							
						if(val.id == question_three){
							
							opt3 += '<option value='+val.id+' selected>'+val.questions+'</option>';
							
						}else{
							opt3 += '<option value='+val.id+' >'+val.questions+'</option>';
						}
					});
					$("#questions1").html(opt1);
					$("#questions2").html(opt2);
					$("#questions3").html(opt3);
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

