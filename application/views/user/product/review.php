<?php $this->load->view("user/common/header");?>
<div class="pcoded-content">
    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-header">
                    <div class="row align-items-end">
                        <div class="col-lg-8">
                            <div class="page-header-title">
                                <div class="d-inline">
                                    <h4><?php echo $product_name; ?> Products Review</h4>
                                    <span><input type="hidden" id="pro_id" value="<?php echo $product_id; ?>"></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="page-header-breadcrumb">
                                <ul class="breadcrumb-title">
                                    <li class="breadcrumb-item">
                                        <a href="<?php echo site_url();?>seller/dashboard"> <i class="feather icon-home"></i> </a>
                                    </li>
                                    <li class="breadcrumb-item"><a href="#">Products Review</a></li>
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
                                </div>
                                <div class="card-block">
                                    <div class="dt-responsive table-responsive">
                                        <table id="reviewTable" class="table table-striped table-bordered nowrap">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
													<th>User Name </th>
                                                    <th>Rating</th>
                                                    <th>Products Name</th>
                                                    <th>Created</th>
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



<div class="modal fade" id="review_modal" tabindex="-1" role="dialog" style="z-index: 1050; display: none;" aria-hidden="true">
<div class="modal-dialog modal-lg" role="document">
<div class="modal-content">
<div class="modal-header">
<h5 class="modal-title">View Review</h5>
<button type="button" class="close" data-dismiss="modal" aria-label="Close">
<span aria-hidden="true">×</span>
</button>
</div>
<div class="modal-body">



<div class="form-group row">
<div class="col-md-4 col-lg-2">
<label for="username" class="block">User Name</label>
</div>
<div class="col-md-1 col-lg-1">
<div>:</div>
</div>
<div class="col-md-7 col-lg-9">
<div id="username"></div>
</div>
</div>
<!-- <div class="form-group row">
<div class="col-md-4 col-lg-2">
<label for="rating" class="block">Rating</label>
</div>
<div class="col-md-1 col-lg-1">
<div>:</div>
</div>
<div class="col-md-7 col-lg-9">
<div id="rating"></div>
</div>
</div> -->

<div class="form-group row">
<div class="col-md-4 col-lg-2">
<label for="rating" class="block">Rating</label>
</div>
<div class="col-md-1 col-lg-1">
<div>:</div>
</div>
<div class="col-md-7 col-lg-9">
<div id="rating"></div>
</div>
</div>

<div class="form-group row">
<div class="col-md-4 col-lg-2">
<label for="product_name" class="block">Products Name</label>
</div>
<div class="col-md-1 col-lg-1">
<div>:</div>
</div>
<div class="col-md-7 col-lg-9">
<div id="product_name"></div>
</div>
</div>


<div class="form-group row">
<div class="col-md-4 col-lg-2">
<label for="description" class="block">Description</label>
</div>
<div class="col-md-1 col-lg-1">
<div>:</div>
</div>
<div class="col-md-7 col-lg-9" style="text-align: justify;">
<div id="description"></div>
</div>
</div>
<div class="form-group row">
<div class="col-md-4 col-lg-2">
<label for="date_added" class="block">Date</label>
</div>
<div class="col-md-1 col-lg-1">
<div>:</div>
</div>
<div class="col-md-7 col-lg-9">
<div id="date_added"></div>
</div>
</div>


<div class="form-group row" id="reply_div">
<div class="col-md-4 col-lg-2">
<label for="date_added" class="block">Reply</label>
</div>
<div class="col-md-1 col-lg-1">
<div>:</div>
</div>
<div class="col-md-7 col-lg-9">
<textarea id="reply_text" rows="4" class="form-control" placeholder="Write reply here...."></textarea>
</div>
</div>

<div class="form-group row" id="my_reply_div">
<div class="col-md-4 col-lg-2">
<label for="my_reply" class="block">My Reply</label>
</div>
<div class="col-md-1 col-lg-1">
<div>:</div>
</div>
<div class="col-md-7 col-lg-9" style="text-align: justify;">
<div id="my_reply"></div>
</div>
</div>

 
</div>
<div class="modal-footer">
<button type="button" class="btn btn-default waves-effect " data-dismiss="modal">Close</button>
<button type="button" class="btn btn-primary waves-effect waves-light " id="reply_btn"><i class="fa fa-reply"></i>Reply</button>
</div>
 </div>
</div>
</div>






<?php $this->load->view("user/common/footer");?>
<script>
 $(document).ready(function () {
	 var pro_id=$('#pro_id').val();
	
    $('#reviewTable').DataTable({
		
		
	   processing: true,
        serverSide: true,
        ajax:{
                 url: "<?php echo base_url('buyer/review/ajax_list') ?>",
                 dataType: "json",
                 type: "POST",
                 data:{  '<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>',pro_id:pro_id} },
                 columns: [
                      { data: "reviews_id" },
                      { data: "user_name" },
                      { data: "reviews_rating" },
                      { data: "products_name" },
					  { data: "date_added" },
					  { data: "action" }
                   ]	 

        });
});
</script>

<script>

$('#review_modal').on('show.bs.modal', function(e) {
	
	
	var reviews_id = $(e.relatedTarget).data('reviewid');
    var username = $(e.relatedTarget).data('username');
	var rating = parseInt($(e.relatedTarget).data('rating'));
	var products_name = $(e.relatedTarget).data('products_name');
	var description = $(e.relatedTarget).data('text');
	var date_added = $(e.relatedTarget).data('dateadded');
	var replied = $(e.relatedTarget).data('replied');
	var myreply = $(e.relatedTarget).data('myreply');
	
	//alert(reviews_id);
	//return false;
	
	if(replied=="yes")
	{
		$("#reply_div").hide();
		$("#reply_btn").hide();
		$("#my_reply_div").show();
		
	}
	
	else
	{
	   	$("#reply_div").show();
		$("#reply_btn").show();
		$("#my_reply_div").hide();
	}
	
	$("#username").empty();
	$("#rating").empty();
	$("#product_name").empty();
	$("#description").empty();
	$("#date_added").empty();
	$("#my_reply").empty();
	
	$("#username").html(username);

    if(rating==1)
    {
      $("#rating").html('<span id="star1" class="fa fa-star checked_star"></span><span id="star2" class="fa fa-star"></span><span id="star3" class="fa fa-star"></span><span id="star4" class="fa fa-star"></span><span id="star5" class="fa fa-star"></span>');
    }

    else if(rating==2)
    {
       $("#rating").html('<span id="star1" class="fa fa-star checked_star"></span><span id="star2" class="fa fa-star checked_star"></span><span id="star3" class="fa fa-star"></span><span id="star4" class="fa fa-star"></span><span id="star5" class="fa fa-star"></span>');
    }

    else if(rating==3)
    {
        $("#rating").html('<span id="star1" class="fa fa-star checked_star"></span><span id="star2" class="fa fa-star checked_star"></span><span id="star3" class="fa fa-star checked_star"></span><span id="star4" class="fa fa-star"></span><span id="star5" class="fa fa-star"></span>');
    }

    else if(rating==4)
    {
       $("#rating").html('<span id="star1" class="fa fa-star checked_star"></span><span id="star2" class="fa fa-star checked_star"></span><span id="star3" class="fa fa-star checked_star"></span><span id="star4" class="fa fa-star checked_star"></span><span id="star5" class="fa fa-star"></span>');
    }

    else if(rating==5)
    {
        $("#rating").html('<span id="star1" class="fa fa-star checked_star"></span><span id="star2" class="fa fa-star checked_star"></span><span id="star3" class="fa fa-star checked_star"></span><span id="star4" class="fa fa-star checked_star"></span><span id="star5" class="fa fa-star checked_star"></span>');
    }

	
	$("#product_name").html(products_name);
	$("#description").html(description);
	$("#date_added").html(date_added);
	$("#my_reply").html(myreply);
	
	
	
    $("#reply_btn").click(function(){
		
	var reply_text=$("#reply_text").val();
	var reply_by_supplier_id="<?php echo $this->session->userdata("user_id"); ?>";
	
		
	 $.ajax({
     url:"<?php echo base_url(); ?>user/review/review_reply",
	 type:"POST",
	 data:{ reviews_id:reviews_id, reply_text:reply_text, reply_by_supplier_id:reply_by_supplier_id },
	 dataType:"json",
	 cache:false,
	 success:function(response){
	
	    if(response.status=="success")
		{
		   location.reload();
		}
		
		else
		{
		   alert("something went wrong");
		}
	
	 }
	 
	 });
		
	});
	
	
});

</script>

<script>
  
  $(".modal").on("hidden.bs.modal", function(){
    location.reload();
});
  
</script>
