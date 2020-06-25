<?php $this->load->view("admin/common/header");?>
<div class="pcoded-content">
    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-header">
                    <div class="row align-items-end">
                        <div class="col-lg-8">
                            <div class="page-header-title">
                                <div class="d-inline">
                                    <h4>
                                        <?php echo $pageTitle;?>
                                        
                                    </h4>	
                                    <span></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="page-header-breadcrumb">
                                <ul class="breadcrumb-title">
                                    <li class="breadcrumb-item">
                                        <a href="<?php echo site_url();?>admin/dashboard"> <i class="feather icon-home"></i> </a>
                                    </li>
                                    <li class="breadcrumb-item">
                                        <?php echo $pageTitle;?>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="page-body">
                    <form method="post" id="submit_form">
                        <div class="row">
                               <div class="col-md-4">
                                   <p class="">From</p>
                                   <input type="text" class="form-control" value="<?php
                                   if (isset($dateFrom)) {
                                       echo $dateFrom;
                                   } else {
                                       echo date('d-m-Y');
                                   }
                                   ?>" placeholder="Date From" id="dateFrom" name="dateFrom">
                                   <input type="hidden" name="page" id="page" value="<?php echo $page; ?>">
                               </div>
                               <div class="col-md-4">
                                   <p class="">To</p>
                                   <input type="text" class="form-control" value="<?php
                                   if (isset($dateTo)) {
                                       echo $dateTo;
                                   } else {
                                       echo date('d-m-Y');
                                   }
                                   ?>" placeholder="Date To" id="dateTo" name="dateTo">
                               </div>

                               <div class="col-md-4">
                                   <p>&nbsp;</p>
                                   <button type="submit" class="btn btn-info btn-sm btn-block"
                                           id="btnFilter">Filter
                                   </button>
                               </div>
                         </div><br/>
                    </form>
                    <div class="row">
                        
                        <div class="col-sm-12">
                            <?php echo $this->session->flashdata("message");?>
                            <div class="card">
                                <div class="card-header">
                                    <table class="table table-striped table-bordered" id="tblSellerList">
                                        <thead>
                                            <tr>
                                                <th>Id</th>
												 <th>Registered date</th>
                                                <th>Name</th>
                                                <th>Email</th>
                                                <th>Mobile</th>
                                                <th>Company</th>
                                                <th>Sell&nbsp;Category</th>
                                                <th>Sell&nbsp;count</th>
                                                <th>Actions</th>
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

<!--Ban Modal-->
<div class="modal fade" id="banModal" tabindex="-1" role="dialog" style="z-index: 1050; display: none;" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title ban-title">Ban Manager</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body" id="banModalData">
                
            </div>
            <div class="modal-footer">
                <button type="button" id="ban_no_btn" class="btn btn-default waves-effect " data-dismiss="modal">Cancel</button>
                <button type="button" id="ban_yes_btn" class="btn btn-primary waves-effect waves-light " data-dismiss="modal" >Yes, Ban It.</button>
            </div>
        </div>
    </div>
</div>


<!--Remove \ Unban Modal-->
<div class="modal fade" id="unBanModal" tabindex="-1" role="dialog" style="z-index: 1050; display: none;" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title ban-title">Ban Manager</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body" id="unBanModalData">
                
            </div>
            <div class="modal-footer">
                <button type="button" id="ban_no_btn" class="btn btn-default waves-effect " data-dismiss="modal">Cancel</button>
                <button type="button" id="unban_yes_btn" class="btn btn-success waves-effect waves-dark text-dark" data-dismiss="modal" >Remove Ban!</button>
            </div>
        </div>
    </div>
</div>


<?php $this->load->view("admin/common/footer");?>

<script>
$(document).ready(function(){

    var sellerDataTable = $("#tblSellerList").dataTable({
        processing: true,
        serverSide: true,
        searching:true,
        ajax:{
            url : "<?php echo site_url('admin/vendors/ajax_list');?>",
            dataType : "json",
            type : "post",
            data : {
                status : "<?php echo $status;?>"
            }
        },
        scrollX: true
    });

});


// for showing modal of banning users

$(document).on("click", ".open-ban-events", function () {
     var eventId = $(this).data('id');
	 $('#banModalData').html(eventId);
});

// for banning users in a script
$(document).ready(function(){
	$("#ban_yes_btn").click(function(){
        if($('#ban_comment').val() == '') {
            alert('Banning reason is must!');
            return;
        }
		$.post( "<?php echo base_url('admin/users/ban_user'); ?>", 
		{ ban_comment: $('#ban_comment').val(), user_id: $("#ban_id").val() } )
        .done(function( data ) {
             window.location.href = "<?php echo base_url(); ?>admin/vendors/pending";
        });
	});
});

// for showing modal of remove / unbanning users

$(document).on("click", ".open-unban-events", function () {
     var eventId = $(this).data('id');
	 $('#unBanModalData').html(eventId);
});


//for showing the filter data

  $(document).on('click', '#btnFilter', function () {
            var formAction = '<?php echo base_url(); ?>admin/vendors/show';
            //set form action
            $('#submit_form').attr('action', formAction);
            //submit form
            $('#submit_form').submit();
       
       
        
   });
        
// for banning users in a script
$(document).ready(function(){
	$("#unban_yes_btn").click(function(){
		$.post( "<?php echo base_url('admin/users/un_ban_user'); ?>", 
						{ user_id: $("#ban_id").val() } )
        .done(function( data ) {
             location.reload(true);
        });
	});
});

 $("#date").dateDropper({
        format:"d-m-Y",
        dropWidth: 200,
        dropPrimaryColor: "#1abc9c",
        dropBorder: "1px solid #1abc9c",
        maxYear: "2020",
    });
    
     $("#dateFrom").dateDropper({
        format:"d-m-Y",
        dropWidth: 200,
        dropPrimaryColor: "#1abc9c",
        dropBorder: "1px solid #1abc9c",
        maxYear: "2020",
    });
    $("#dateTo").dateDropper({
        format:"d-m-Y",
        dropWidth: 200,
        dropPrimaryColor: "#1abc9c",
        dropBorder: "1px solid #1abc9c",
        maxYear: "2020",
        });


$("#dateTo").on("change",function(e){
    
    var from_date=$("#dateFrom").val();

    var to_date=$("#dateTo").val();
      
    if(from_date!=='' && to_date!=='')
    {
        // alert(from_date+''+to_date);
        if(from_date>to_date)
        {
           $("#dateTo").val('');
           alert("Please Select Valid From & To Date to View Details.!");
           // location.reload();
           $('#dateTo').css('border-color', 'red');
        }
         
    }
           return false;
});


</script>
