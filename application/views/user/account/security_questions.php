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
							<h4>Set Security Questions</h4>

							</div>
						</div>
					</div>
					<div class="col-lg-4">
						<div class="page-header-breadcrumb">
                                                    <ul class="breadcrumb-title">
                                                        <li class="breadcrumb-item">
                                                            <a href="<?php echo base_url(); ?>seller/dashboard"> <i class="feather icon-home"></i> </a>
                                                        </li>
                                                        <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>seller/myaccount">MyAccount</a>
                                                        </li>
                                                        <li class="breadcrumb-item"><a href="#">Add Questions</a>
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
						<?php if($update){ ?>
							<a href="<?php echo base_url(); ?>seller/myaccount/update_security_questions/<?php echo $update ?>"><button type="button" name="submit_brand" id="submit_brand" class="btn btn-primary pull-right" id="primary-popover-content">update</button></a>
						<?php }else{?>
						 <form action= "" method="post" id="submit_form" name="security_qtn">
							<div class="form-group row">
								<label class="col-sm-2 col-form-label">Questions 1</label>
								<div class="col-sm-10">
									<select name="questions1" id="questions1" class="form-control" value="<?php echo set_value('questions1'); ?>">
									</select>
									<div style="color:red"><?php echo form_error('questions1'); ?></div>
								</div>
							</div>
							
							<div class="form-group row">
								<label class="col-sm-2 col-form-label">Answer</label>
								<div class="col-sm-10">
									<input type="text" name="answer1" class="form-control" placeholder="Answer" value="<?php echo set_value('answer1'); ?>">
									<div style="color:red"><?php echo form_error('answer1'); ?></div>
								</div>
							</div>
							
							<div class="form-group row">
								<label class="col-sm-2 col-form-label">Questions 2</label>
								<div class="col-sm-10">
									<select name="questions2" id="questions2" class="form-control" value="<?php echo set_value('questions2'); ?>">
									</select>
									<div style="color:red"><?php echo form_error('questions2'); ?></div>
								</div>
							</div>
							
							<div class="form-group row">
								<label class="col-sm-2 col-form-label">Answer</label>
								<div class="col-sm-10">
									<input type="text" name="answer2" class="form-control" placeholder="Answer" value="<?php echo set_value('answer2'); ?>">
									<div style="color:red"><?php echo form_error('answer2'); ?></div>
								</div>
							</div>
							
							<div class="form-group row">
								<label class="col-sm-2 col-form-label">Questions 3</label>
								<div class="col-sm-10">
									<select name="questions3" id="questions3" class="form-control" value="<?php echo set_value('questions3'); ?>">
									</select>
									<div style="color:red"><?php echo form_error('questions3'); ?></div>
								</div>
							</div>
							
							<div class="form-group row">
								<label class="col-sm-2 col-form-label">Answer</label>
								<div class="col-sm-10">
									<input type="text" name="answer3" class="form-control" placeholder="Answer" value="<?php echo set_value('answer3'); ?>">
									<div style="color:red"><?php echo form_error('answer3'); ?></div>
								</div>
							</div>
							
							<button type="button" name="submit_brand" id="submit_brand" class="btn btn-primary pull-right" id="primary-popover-content" onclick = "validate_questions()">Submit</button>
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
<?php $this->load->view("user/common/footer"); ?>
<script>
$(document).ready(function(){
	
	$.ajax({
			url: '<?php echo site_url("seller/myaccount/ajax_get_questions");?>',
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

