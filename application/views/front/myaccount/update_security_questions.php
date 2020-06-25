<style>

    input, textarea, select
    {
        border:1px solid #ccc !important;
    }

    .modal-dialog {
        max-width:500px; 
        margin: 1.75rem auto;
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
				Update Security Questions
				</span>
			</li>
		</ol>
		
    <br>
    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">

                <div class="page-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="card">

                                <div class="card-header">
                                    <h4 class="sub-title">Set Security Questions</h4>
                                    <?php echo $this->session->flashdata("message"); ?>
                                </div>
                                <div class="card-block">
                                    <div class="page-wrapper">
                                            <br>
                                      
                                            <div class="row">
                                                <div class="col-sm-12">
                                                        <div class="card-block">
                                                            <div id="note">
                                                                <?php if ($success) {
                                                                    echo $success;
                                                                } ?>
                                                            </div>

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
																
																<div class="form-group row">
																	<div class="col-md-12 text-right mt-15 mb-10" >
																	 <button type="button" name="submit_brand" id="submit_brand" class="btn btn-primary" onclick = "validate_questions()">Submit</button>
																	</div>
																</div>
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
        </div>
    </div>
    <br><br>
</div>

 <script src="<?php echo base_url();?>assets/bower_components/jquery/js/jquery.min.js"></script>
 <script src="https://code.jquery.com/jquery-1.11.3.min.js"></script>
<script>
    $(document).ready(function () {

        var question_one = '<?Php echo $result->question_id_one; ?>';
        var question_two = '<?Php echo $result->question_id_two; ?>';
        var question_three = '<?Php echo $result->question_id_three; ?>';

        $.ajax({
            url: '<?php echo site_url("buyer/myaccount/ajax_get_questions"); ?>',
            type: 'POST',
            dataType: 'json',
            success: function (data) {
                if (data)
                {
                    var opt1 = "<option value=0>Please Select</option>";
                    var opt2 = "<option value=0>Please Select</option>";
                    var opt3 = "<option value=0>Please Select</option>";
                    $.each(data, function (obj, val) {
                        if (val.id == question_one) {
                            opt1 += '<option value=' + val.id + ' selected>' + val.questions + '</option>';
                        } else {
                            opt1 += '<option value=' + val.id + ' >' + val.questions + '</option>';
                        }

                        if (val.id == question_two) {
                            opt2 += '<option value=' + val.id + ' selected>' + val.questions + '</option>';
                        } else {
                            opt2 += '<option value=' + val.id + ' >' + val.questions + '</option>';
                        }

                        if (val.id == question_three) {

                            opt3 += '<option value=' + val.id + ' selected>' + val.questions + '</option>';

                        } else {
                            opt3 += '<option value=' + val.id + ' >' + val.questions + '</option>';
                        }
                    });
                    $("#questions1").html(opt1);
                    $("#questions2").html(opt2);
                    $("#questions3").html(opt3);
                }

            },
            error: function (e) {
            }
        });
    });

    function validate_questions()
    {
        var dropdwn_one = $("#questions1").val();
        var dropdwn_two = $("#questions2").val();
        var dropdwn_three = $("#questions3").val();
        var flag = 0;

        if (dropdwn_one == 0 && dropdwn_two == 0 && dropdwn_three == 0)
        {
            alert('All Fields Are Mandatory');
        }

        if (dropdwn_one == dropdwn_two || dropdwn_two == dropdwn_three || dropdwn_three == dropdwn_one)
        {
            flag++;
            $("#note").html("<div class='alert alert-danger alert-dismissible'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><strong>Note!</strong> All the selected questions from dropdown should different!!</div>");
        }

        if (flag == 0)
        {
            $("#submit_form").submit();
        }

    }
</script>

