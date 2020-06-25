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
                                    <h4>View Shipping</h4>
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
                                    <li class="breadcrumb-item"><a href="<?php echo base_url('admin/app_banner');?>">App Banner</a></li>
                                    <li class="breadcrumb-item">View</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="page-body">
                    <div class="row">
			<div class="col-lg-12">
			    <div class="card">
                                <div class="card-header">
                                    <h5 class="card-header-text">Charges By Weight</h5>
                                   
                                </div>
                                <div class="card-block">
                                    <div class="view-info">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="general-info">
                                                    <div class="row">
                                                        <div class="col-lg-12 col-xl-12">
                                                            <div class="table-responsive">
                                                                <table class="table table-striped table-bordered nowrap dataTable no-footer">
                                                                    <tbody>
                                                                        <tr>
																		<th>Sr No</th>
																		<th>Zone From</th>
																		<th>Zone To</th>
																		<th>Weight</th>
																		<th>Rate</th>
																		<th>Action</th>
																		</tr>
																		<?php
																		$i=1;
																		foreach($by_weight as $wt)
																		{ 
																				if(!empty($wt['zone_from']))
																				{
																		?>
																			<tr>
																			<td><?php echo $i; ?></td>
																			<td><?php echo $wt['zone_from']; ?></td>
																			<td><?php echo $wt['zone_to']; ?></td>
																			<td><?php echo $wt['weight']; ?></td>
																			<td><?php echo number_format($wt['rate'],2); ?></td>
																			<td><button value="<?php echo $wt['id']; ?>" type="button" class="btn btn-primary btn-sm btn-outline-primary waves-effect" data-toggle="modal" data-target="#edit_weight" onclick="get_by_weight(this.value)">Edit</button>
																			<a onclick="return confirm('Are you sure want to delete ?')" href="<?php echo base_url(); ?>admin/shipping_vendor/delete_by_weight/<?php echo $wt['id']; ?>"  class="btn btn-danger btn-sm btn-outline-primary waves-effect">Delete</a></td>
																			</tr>
																		<?php 
																		$i++;
																				}
																		}
																		?>
                                                                    </tbody>
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
							<hr>
							<div class="card">
                                <div class="card-header">
                                    <h5 class="card-header-text">Charges By Distance</h5>
                                   
                                </div>
                                <div class="card-block">
                                    <div class="view-info">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="general-info">
                                                    <div class="row">
                                                        <div class="col-lg-12 col-xl-12">
                                                            <div class="table-responsive">
                                                                <table class="table table-striped table-bordered nowrap dataTable no-footer">
                                                                    <tbody>
                                                                        <tr>
																		<th>Sr No</th>
																		<th>Distance</th>
																		<th>Kg</th>
																		<th>Rate</th>
																		<th>Action</th>
																		</tr>
																		<?php
																		$i=1;
																		foreach($by_distance as $wt)
																		{
																			if(!empty($wt['distance_from']))
																			{
																		?>
																			<tr>
																			<td><?php echo $i; ?></td>
																			<td><?php echo $wt['distance_from'].' - '.$wt['distance_to']; ?></td>
																			<td><?php echo $wt['kg_from'].' - '.$wt['kg_to']; ?></td>
																			<td><?php echo number_format($wt['rate'],2); ?></td>
																			<td><button value="<?php echo $wt['id']; ?>" type="button" class="btn btn-primary btn-sm btn-outline-primary waves-effect" data-toggle="modal" data-target="#edit_distance" onclick="get_by_distance(this.value)">Edit</button>
																			<a onclick="return confirm('Are you sure want to delete ?')" href="<?php echo base_url(); ?>admin/shipping_vendor/delete_by_distance/<?php echo $wt['id']; ?>"  class="btn btn-danger btn-sm btn-outline-primary waves-effect">Delete</a></td>
																			</tr>
																			</tr>
																		<?php 
																		$i++;
																			}
																		}
																		?>
                                                                    </tbody>
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
							
							 <!-- Modal -->
    <div id="edit_weight" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Shipping Charge By Weight Edit</h4>
                </div>
                <form class="form-horizontal" action="<?php echo base_url();?>admin/shipping_vendor/update_weight" method="post">
					
                   
                    <div class="modal-body">
					
                        <div class="form-group">
                           
                            <div class="col-md-12">
                                <p id="weight_data"></p>
                            </div>
                        </div>
                       
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-sm btn-warning" data-dismiss="modal">Close</button>
                        <button type="Update" class="btn btn-sm btn-info" id="btnSubmit">Update</button>
                    </div>    
                </form>
            </div>

        </div>
    </div>
	<div id="edit_distance" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Shipping Charge by Distance  Edit</h4>
                </div>
                <form class="form-horizontal" action="<?php echo base_url();?>admin/shipping_vendor/update_distance" method="post">
					
                   
                    <div class="modal-body">
					
                        <div class="form-group">
                           
                            <div class="col-md-12">
                                <p id="distance_data"></p>
                            </div>
                        </div>
                       
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-sm btn-warning" data-dismiss="modal">Close</button>
                        <button type="Update" class="btn btn-sm btn-info" id="btnSubmit">Update</button>
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
<script>
function get_by_weight(id)
{
	
                  $.ajax({
                          type:'POST',
                          url :'<?php echo base_url(); ?>admin/shipping_vendor/get_single_wt',
                          data: {'wt_id':id},
                          success:function(data){
							
							$('#weight_data').html(data);
                          },
                          error:function(){
                              alert('error handling here'); 
                          }
                  });
}
function get_by_distance(id)
{

                  $.ajax({
                          type:'POST',
                          url :'<?php echo base_url(); ?>admin/shipping_vendor/get_single_dist',
                          data: {'dist_id':id},
                          success:function(data){
							
							$('#distance_data').html(data);
                          },
                          error:function(){
                              alert('error handling here'); 
                          }
                  });
}
          
</script>		
<?php $this->load->view("admin/common/footer");?>
