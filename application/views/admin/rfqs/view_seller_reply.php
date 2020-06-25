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
                                    <h4>Seller Reply</h4>
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
                                    <li class="breadcrumb-item"><a href="#">Reply List</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="page-body">
                    
                    <div class="row">
                        <div class="col-sm-12">
                            <?php echo $this->session->flashdata("message"); ?>
                            <div class="card">
                                <div class="card-header">
                                    <h5>Seller Reply Table</h5>
                                </div>
                                <div class="card-block">
                                    <div class="dt-responsive table-responsive">
                                        <table id="collectionTable" class="table table-striped table-bordered nowrap">
                                            <thead>
                                                <tr>
                                                    <th>Sr.No.</th>
                                                    <th>User Name</th>
                                                    <th>Seller Name</th>
                                                    <th>Looking For</th>
                                                    <th>Quantity </th>
                                                    <th>Unit</th>
                                                    <th>Price</th>
                                                    <th>Status from seller </th>
                                                    <th>Action</th>
                                                </tr>
                                                <?php
                                                $i=1;
                                                foreach($result as $res)
                                                { 
                                                  echo '<tr>';  
                                                  echo'<td>'.$i.'</td>';
                                                  echo'<td>'.$res->first_name.' '.$res->last_name.'</td>';
                                                  echo'<td>'.$res->seller_name.'</td>';
                                                  echo'<td>'.$res->looking_for.'</td>';
                                                  echo'<td>'.$res->quantity.'</td>';
                                                  echo'<td>'.$res->units_name.'</td>';
                                                  echo'<td>'.$res->price.'</td>';
                                                  echo'<td>'.$res->seller_rfq_status.'</td>';
                                                  if($res->seller_rfq_status=='Approved' && $res->admin_approve==0)
                                                  {
                                                  echo'<td><a href="#" class="btn btn-sm btn-info" data-toggle="modal" data-target="#myModal" onclick="get_reply(' . $res->rfq_to_seller_id . ')">Click to Approve</a></td>';
                                                  }else if($res->seller_rfq_status=='Approved' && $res->admin_approve==1){
                                                        echo'<td><a href="#" class="btn btn-sm btn-success" data-toggle="modal" data-target="#myModal" onclick="get_reply(' . $res->rfq_to_seller_id . ')">Approved</a></td>';
                                                  }
                                                  else{
                                                      echo'<td>--</td>';
                                                  }
                                                  echo '</tr>';  
                                                
                                                  $i++;
                                                }
                                                ?>
                                            </thead>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                       
                        <!-- Modal -->
                        <div id="myModal" class="modal fade" role="dialog">
                            <div class="modal-dialog modal-lg">

                                <!-- Modal content-->
                                <div class="modal-content">
                                    <form action="<?php echo base_url(); ?>admin/rfqs/update_seller_reply" method="post">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        <h4 class="modal-title">View Seller Reply</h4>
                                    </div>
                                    <div class="modal-body">
                                        
                                        <p id="seller_reply"></p>
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
<?php $this->load->view("admin/common/footer"); ?>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.html5.min.js"></script>
<script>
  
    function get_reply(id)
    {
        if (id != '')
       {
           
           $.ajax({
               type: 'POST',
               url: '<?php echo base_url(); ?>admin/rfqs/get_sellet_reply',
               data: {'id': id},
               success: function (data) {
                
                   $('#seller_reply').html('');
                   $('#seller_reply').html(data);
   
               },
               error: function () {
                   alert('Somthing Wrong !');
               }
           });
       }
    }
    
    
</script>