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
                                    <h4>Inquiries</h4>
                                    <span></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="page-header-breadcrumb">
                                <ul class="breadcrumb-title">
                                    <li class="breadcrumb-item">
                                        <a href="<?php echo site_url(); ?>seller/dashboard"> <i class="feather icon-home"></i> </a>
                                    </li>
                                    <li class="breadcrumb-item"><a href="#">Inquiry List</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="page-body">
                    <div class="row">
                        <div class="col-sm-12">

                            <div class="card">
                                <h6 style="text-align:center;" id="reply_messege" ><?php echo $this->session->flashdata('message'); ?></h6>
                                <div class="card-block">
                                    <div class="dt-responsive table-responsive">
                                        <table id="inquiriesTable" class="table table-striped table-bordered nowrap">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
													<th>User</th>
                                                    <th>Product</th>
                                                    <th>Quantity</th>
                                                    <th>Comment</th>
													<th>Attachment</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                        </table>
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

<div class="modal fade" id="inquiry_modal" tabindex="-1" role="dialog" style="z-index: 1050; display: none;" aria-hidden="true">
<div class="modal-dialog modal-lg" role="document">
  <div class="modal-content">
    <div class="modal-header">
      <h5 class="modal-title">View Reply
      </h5>
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">×
        </span>
      </button>
    </div>
    <div class="modal-body">
	<form method="POST" enctype="multipart/form-data" id="fileUploadForm" >
	
	  <input type="hidden" name="inquiry_id" id="inquiry_id">
	  <div class="form-group row" id="reply_type">
        <div class="col-md-4 col-lg-2">
          <label for="date_added" class="block">Reply Type
          </label>
        </div>
        <div class="col-md-1 col-lg-1">
          <div>:</div>
        </div>
        <div class="col-md-7 col-lg-9">
            <select name="reply_type" id="reply_type_dropdown" class="form-control">
                    <option value = "Normal" >Normal</option>
                    <option value = "Quotation" >Quotation</option>
            </select>
        </div>
      </div>
	  
	  <div class="form-group row" id="price_div">
        <div class="col-md-4 col-lg-2">
          <label for="date_added" class="block">price
          </label>
        </div>
        <div class="col-md-1 col-lg-1">
          <div>:</div>
        </div>
        <div class="col-md-7 col-lg-9">
			<input type="text" name="price" class="form-control" id="price" onkeypress = "return restrictAlphabets(event)">
        </div>
      </div>
	  
      <div class="form-group row" id="reply_div">
        <div class="col-md-4 col-lg-2">
          <label for="date_added" class="block">Comment
          </label>
        </div>
        <div class="col-md-1 col-lg-1">
          <div>:</div>
        </div>
        <div class="col-md-7 col-lg-9">
          <textarea id="reply_text" name="comment" rows="4" class="form-control" placeholder="Write reply here...."></textarea>
        </div>
      </div>
	  
	  <div class="form-group row" id="attachment_div">
        <div class="col-md-4 col-lg-2">
          <label for="date_added" class="block">Attachment
          </label>
        </div>
        <div class="col-md-1 col-lg-1">
          <div>:</div>
        </div>
        <div class="col-md-7 col-lg-9">
          <input type ="file" name="file" id="file" >
        </div>
      </div>
	  
	   <div class="form-group row" id="my_reply_type_div">
        <div class="col-md-4 col-lg-2">
          <label for="my_reply" class="block">Reply Type
          </label>
        </div>
        <div class="col-md-1 col-lg-1">
          <div>:</div>
        </div>
        <div class="col-md-7 col-lg-9" style="text-align: justify;">
          <div id="reply_type_l">
          </div>
        </div>
      </div>
	  
	  <div class="form-group row" id="my_reply_div">
        <div class="col-md-4 col-lg-2">
          <label class="block">My Reply
          </label>
        </div>
        <div class="col-md-1 col-lg-1">
          <div>:</div>
        </div>
        <div class="col-md-7 col-lg-9" style="text-align: justify;">
          <div id="my_reply">
          </div>
        </div>
      </div>
	  
	   <div class="form-group row" id="price_lst_div">
        <div class="col-md-4 col-lg-2">
          <label class="block">Price
          </label>
        </div>
        <div class="col-md-1 col-lg-1">
          <div>:</div>
        </div>
        <div class="col-md-7 col-lg-9" style="text-align: justify;">
          <div id="price_l">
          </div>
        </div>
      </div>
	  
	    <div class="form-group row" id="attachment_div_lst">
        <div class="col-md-4 col-lg-2">
          <label for="date_added" class="block">Attachment
          </label>
        </div>
        <div class="col-md-1 col-lg-1">
          <div>:</div>
        </div>
        <div class="col-md-7 col-lg-9" id="attachment_link">
        
        </div>
      </div>
	  
    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-default waves-effect " data-dismiss="modal">Close</button>
	  <button type="button" class="btn btn-primary waves-effect waves-light " id="reply_btn"><i class="fa fa-reply"></i>Reply</button>
    </div>
	</form>
  </div>
</div>
</div>

<?php $this->load->view("user/common/footer"); ?>
<script>

  function restrictAlphabets(e){
                    var x=e.which||e.keycode;
                    if((x>=48 && x<=57))
                            return true;
                    else
                            return false;
            }
			
    $(document).ready(function () {
        var dataTable = $('#inquiriesTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "<?php echo base_url('seller/inquiries/ajax_list'); ?>",
                type: "POST",
                data: function (data) {
                    data.<?php echo $this->security->get_csrf_token_name(); ?> = "<?php echo $this->security->get_csrf_hash(); ?>";
                    console.log(data);
                },
            },
            columnDefs: [
                {className: "dropdown", "targets": [6]}
            ],
            "language": {                
                "infoFiltered": ""
            }

        });

        $('#button-filter').on('click change', function (event) {
            dataTable.draw();
        });

    });
	
$('#inquiry_modal').on('show.bs.modal', function(e) {
	$("#price_div").hide();
	
	var inquiry_id = $(e.relatedTarget).data('inquiryid');
	var replied = $(e.relatedTarget).data('replied');
	var comment = $(e.relatedTarget).data('comment');
	var replytype = $(e.relatedTarget).data('replytype');
	var price = $(e.relatedTarget).data('price');
	var attachment = $(e.relatedTarget).data('attachment');

	
	if(replied=="yes")
	{
	
		$("#reply_btn").hide();
		$("#my_reply_div").show();
		$("#my_reply_type_div").show();
		$("#price_lst_div").show();
		$("#attachment_div_lst").show();
		
		$("#reply_type").hide();
		$("#price_div").hide();
		$("#reply_div").hide();
		$("#attachment_div").hide();
	}
	else
	{
		$("#reply_btn").show();
		$("#my_reply_div").hide();
		$("#my_reply_type_div").hide();
		$("#price_lst_div").hide();
		$("#attachment_div_lst").hide();
		
		$("#reply_type").show();
		$("#reply_div").show();
		$("#attachment_div").show();
	}

	$("#my_reply").html(comment);
	$("#reply_type_l").html(replytype);
	$("#inquiry_id").val(inquiry_id);
	if(price)
	{
		$("#price_l").html(price);
	}else{
		$("#price_lst_div").hide();
	}
	
	if(attachment != '')
	{
		$("#attachment_link").html('<a href="'+ attachment +'" >download</a>');
	}else{
		$("#attachment_link").html("No Attachment");
	}
	 
	
});

$('#reply_type_dropdown').change(function(e){
	var reply_type = $(this).val();
	if(reply_type == "Normal")
	{
		$("#price_div").hide();
	}else{
		$("#price_div").show();
	}
});

$("#reply_btn").click(function(){
		 var data = new FormData($('#fileUploadForm')[0]);
		 $.ajax({
			 url:"<?php echo base_url(); ?>seller/inquiries/inquiries_reply",
			 type:"POST",
			 dataType:"json",
			 data: data,
			 cache: false,
			 processData: false,
			 contentType: false,
			 success:function(response){
				 console.log(response);
				if(response.status== 1)
				{
				   location.reload();
				   
				}else if(response.error){
					alert(" Please select pdf|doc|docx file!");
				}else {
				   alert("something went wrong");
				}
			 }
		 });
	});
	

</script>