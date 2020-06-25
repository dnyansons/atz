<?php $this->load->view("admin/common/header"); ?>
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
                                        <?php echo $status?"Active":"inactive";?> Users
                                    </h4>
                                    <span></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="page-header-breadcrumb">
                                <ul class="breadcrumb-title">
                                    <li class="breadcrumb-item">
                                        <a href="<?php echo site_url(); ?>admin/dashboard"> <i class="feather icon-home"></i> </a>
                                    </li>
                                    <li class="breadcrumb-item"><a href="#">Users List</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="page-body">
                    <form method="post" action="" name="submit_form" id="submit_form">    
                   <div class="row">
                        <div class="col-md-12">
                            <div class="form-group row">
                                <div class="col-sm-3">
                                    <p class="filter-form-label">From</p>
                                    <input type="text" class="form-control" id="dateFrom" name="dateFrom">
                                </div>
                                <div class="col-sm-3">
                                    <p class="filter-form-label">To</p>
                                    <input type="text" class="form-control" id="dateTo" name="dateTo">
                                </div>
                                <div class="col-sm-3">
                                   <p class="filter-form-label">&nbsp;</p>
                                   <button class="btn btn-info btn-sm btn-block" id="btnFilter">Filter</button>
                                </div>
                                <div class="col-sm-3">
                                   <p class="filter-form-label">&nbsp;</p>
                                   <button type="button" class="btn btn-info btn-sm btn-block" id="export">Export To Excel</button>
                                </div>
                            </div>
                        </div>

                    <br/>    
                    </div>
                    </form>
                    <div class="row">
                        <div class="col-sm-12">
                            <?php
                            if(!empty($this->session->flashdata('message'))){ ?>
<!--                                        <div class="alert alert-success alert-dismissible col-md-6 offset-3">
                                          <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>-->
                                           <?php echo $this->session->flashdata('message'); ?>
                                        <span id="msg"></span>
<!--                                        </div> -->
                                     <?php } ?>
                            <div class="card">

                                <div class="card-block">
                                    <div class="dt-responsive table-responsive">
                                        <table id="userTable" class="table table-striped table-bordered nowrap">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>User Name </th>
                                                    <th>Email Address</th>
                                                    <th>Wallet Balance</th>
                                                    <th>Phone</th>
                                                    <th>Total&nbsp;Orders</th>
                                                    <th>Registered</th>
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


<div class="modal fade" id="active_inactive_modal" tabindex="-1" role="dialog" style="z-index: 1050; display: none;" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">User Status</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Are you sure to change this user status?</p>
            </div>
            <div class="modal-footer">
                <button type="button" id="no_btn" class="btn btn-default waves-effect " data-dismiss="modal">No</button>
                <button type="button" id="yes_btn" class="btn btn-primary waves-effect waves-light ">Yes</button>
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


<?php $this->load->view("admin/common/footer"); ?>
<script>

    $(document).ready(function () {

        var dataTable = $('#userTable').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": "<?php echo base_url('admin/users/ajax_list'); ?>",
                "type": "POST",
                "data": function (data) {
                    data.status = "<?php echo $status;?>";
                    data.registered_from = $('#dateFrom').val();
                    data.registered_to = $('#dateTo').val();
                    data.<?php echo $this->security->get_csrf_token_name(); ?> = "<?php echo $this->security->get_csrf_hash(); ?>";
                },
            },
            "columnDefs": [
                {className: "dropdown", "targets": [5]}
            ]

        });
        
        
        $(".btnOrdersInfo").click(function(){
            var user_id = $(this).attr("data-uid");
            console.log(user_id);
        });
        
        
        $(document).on('click', '.btnOrdersInfo', function () {
            console.log($(this).attr("data-uid"));
            var uid = $(this).attr("data-uid");
            if(uid){
                $.ajax({
                    url : "<?php echo site_url();?>admin/users/ajaxUserOrders",
                    data : {user_id:uid},
                    type : "post",
                    success:function(data){
                        var obj = JSON.parse(data);
                        console.log(obj);
                        //$('#slrname').text(obj.data.first_name+" "+obj.data.last_name);
                        //$('#slremail').text(obj.data.email);
                        //$('#slrmobile').text(obj.data.phone);
                        //$('#sellerModal').modal('show');
                    }
                });
            }
        });    

    });

</script>

<script type="text/javascript">


    $('#active_inactive_modal').on('show.bs.modal', function (e) {

        var user_id = $(e.relatedTarget).data('user_id');
        var status = $(e.relatedTarget).data('status');

        $("#yes_btn").click(function () {

            $.ajax({
                url: "<?php echo base_url(); ?>admin/users/updateUserStatus",
                type: "POST",
                data: {user_id: user_id, status: status},
                dataType: "json",
                success: function (response) {
                    if (response.status == "success")
                    {
                        location.reload();
                    } else
                    {
                        location.reload();
                    }
                }
            });

        });

    });


   $(document).on('click', '#export', function () {
            var formAction = '<?php echo base_url(); ?>admin/users/exportAllUsers';
            //set form action
            $('#submit_form').attr('action', formAction);
            //submit form
            $('#submit_form').submit();
    });
        
    $(document).on('click', '#btnFilter', function () {
            var formAction = '<?php echo base_url(); ?>admin/users/show';
            //set form action
            $('#submit_form').attr('action', formAction);
            //submit form
            $('#submit_form').submit();

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
             location.reload(true);
        });
	});
});

// for showing modal of remove / unbanning users

$(document).on("click", ".open-unban-events", function () {
     var eventId = $(this).data('id');
	 $('#unBanModalData').html(eventId);
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


/*
    Author @Ishwar
    This Function evaluates From & To Date Functionality
*/

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