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
                                    <h4><?php echo $Title; ?></h4>
                                    <span></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="page-header-breadcrumb">
                                <ul class="breadcrumb-title">
                                    <li class="breadcrumb-item">
                                        <a href="<?php echo site_url();?>user"> <i class="feather icon-home"></i> </a>
                                    </li>
                                    <li class="breadcrumb-item"><a href="#">My Enquiry  List</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="page-body">
                    <div class="row">
                        <div class="col-sm-12">

                            <div class="card">
							<h6 style="text-align:center;"><?php echo $this->session->flashdata('message'); ?></h6>
                                
                                <div class="card-block">
                                    <div class="dt-responsive table-responsive">
                                        <table id="enquiryTable" class="table table-striped table-bordered nowrap">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Comment</th>
                                                    <th>Product</th>
                                                    <th>Product Qty/Unit</th>
                                                    <th>Forwarded</th>
                                                    <th>Created At</th>
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
		
		
		<!-- Modal Product View -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Order View</h4>
      </div>
      <div class="modal-body">
        <p id="myorder"></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>

		<!-- Modal Review View -->
<div id="myReview" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Product Review</h4>
      </div>
      <div class="modal-body">
        <p id="myreview"></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>
		

        
    </div>
</div>
<?php $this->load->view("user/common/footer");?>
<script> 
 $(document).ready(function () {
    $('#enquiryTable').DataTable({
		 
        processing: true,
        serverSide: true,
        ajax:{
                 url: "<?php echo base_url('user/inquiries/buyer_ajax_enquires_list') ?>",
                 dataType: "json",
                 type: "POST",
                 data:{  '<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>' } },
                 columns: [
                      { data: "id" },
                      { data: "comment" },
                      { data: "for_product"},
                      { data: "quantity" },
                      { data: "is_forwarded"},
                      { data: "created_on"},
                      { data: "action"},
                   ],
                "order": [[ 5, "desc" ]]

        });
});

</script>