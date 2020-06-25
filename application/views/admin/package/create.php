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
                           <h4><?php echo $title; ?></h4>
                        </div>
                     </div>
                  </div>
                  <div class="col-lg-4">
                     <div class="page-header-breadcrumb">
                        <ul class="breadcrumb-title">
                           <li class="breadcrumb-item">
                              <a href="<?php echo site_url();?>admin/dashboard"> <i class="feather icon-home"></i> </a>
                           </li>
                           <li class="breadcrumb-item"><a href="#!"><?php echo $title; ?></a></li>
                           <li class="breadcrumb-item"><a href="#!"><?php echo $title; ?></a></li>
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
                           <form method="post" enctype="multipart/form-data" action="<?php echo base_url().$action; ?>">
                              <div class="form-group row">
							  <?php
							  if(isset($dat['sub_id']))
							  {
								  echo'<input type="hidden" name="sub_id" value="'.$dat['sub_id'].'">';
							  }
							  ?>
							  
                                 <label class="col-sm-2 col-form-label">Package Name</label>
                                 <div class="col-sm-10">
                                    <input type="text" name="pkg_name" id="pkg_name" class="form-control" value="<?php if(isset($dat['pkg_name'])){ echo $dat['pkg_name']; } ?>" placeholder="Package Name" required>
                                 </div>
                              </div>
							  <div class="form-group row">
                                 <label class="col-sm-2 col-form-label">Package Sub Title</label>
                                 <div class="col-sm-10">
                                    <input type="text" name="pkg_sub_title" id="pkg_sub_title" class="form-control" value="<?php if(isset($dat['pkg_sub_title'])){ echo $dat['pkg_sub_title']; } ?>" placeholder="Package Sub Title" required>
                                 </div>
                              </div>
							  <div class="form-group row">
                                 <label class="col-sm-2 col-form-label">Package Image</label>
                                 <div class="col-sm-10">
                                    <input type="file" name="userFiles" id="pkg_image" class="form-control">
                                 </div>
                              </div>
							  <div class="form-group row">
                                 <label class="col-sm-2 col-form-label">Image</label>
                                 <div class="col-sm-10">
                                    <input type="hidden" name="pkg_image" value="<?php if(isset($dat['pkg_image'])){ echo $dat['pkg_image']; } ?>" id="pkg_image" class="form-control">
									<?php
										if(isset($dat['pkg_image']))
										{
											echo'<img src="'.$dat['pkg_image'].'" style="width:100px;">';
										}
									?>
									<img src="">
                                 </div>
                              </div>
							  <div class="form-group row">
                                 <label class="col-sm-2 col-form-label">Package Description</label>
                                 <div class="col-sm-10">
								 <textarea class="form control ckeditor" name="pkg_description" ><?php if(isset($dat['pkg_description'])){ echo $dat['pkg_description']; } ?></textarea>
                                    
                                 </div>
                              </div>
							    <div class="form-group row">
                                 <label class="col-sm-2 col-form-label">Price</label>
                                 <div class="col-sm-10">
                                    <input type="number" value="<?php if(isset($dat['price'])){ echo $dat['price']; } ?>" name="price" id="price" class="form-control" placeholder="0"  required>
                                 </div>
                              </div>
							   <div class="form-group row">
                                 <label class="col-sm-2 col-form-label">Apply Taxes</label>
                                 <div class="col-sm-10">
								 
								 <?php
								 if(!empty($taxes))
								 {
									 $str='';
									 $str.='<table class="table table-striped table-bordered nowrap dataTable no-footer" style="width:100%;">';
									 $str.='<tr>';
										 $str.='<th>Check</th>';
										 $str.='<th>Tax Name</th>';
										 $str.='<th>Tax Rate ( In )</th>';
										 $str.='<th>For Country</th>';
									 $str.='</tr>';
									 foreach($taxes as $tax)
									 {
										$str.='<tr>';
											$str.='<td><input type="checkbox" name="taxes[]" value="'.$tax['tax_class_id'].'"';
											//Check existing in Update
											if(isset($dat['taxes']))
											{
												if (in_array($tax['tax_class_id'], json_decode($dat['taxes'])))
												{
													$str.='checked';
												}
											}												
											$str.='></td>';
											$str.='<td>'.$tax["tax_class_title"].'</td>';
											$str.='<td>'.$tax["tax_class_rate"].' ( '.$tax["tax_class_type"].' )</td>';
											$str.='<td>'.$tax["name"].'</td>';
										$str.='</tr>';
									 }
									 $str.='</table>';
									 echo $str;
								 }
								 ?>
                                    
                                 </div>
                              </div>
							   <div class="form-group row">
                                 <label class="col-sm-2 col-form-label">Prduct Ranking</label>
                                 <div class="col-sm-10">
                                    <select class="form-control" name="product_ranking">
                                       <option value="">Select Product Ranking</option>
                                       <option value="1" <?php if($dat['product_ranking']=='1'){ echo'selected=selected'; } ?>>1st</option>
									   <option value="2" <?php if($dat['product_ranking']=='2'){ echo'selected=selected'; } ?>>2nd</option>
									   <option value="3" <?php if($dat['product_ranking']=='3'){ echo'selected=selected'; } ?>>3rd</option>
									   <option value="4" <?php if($dat['product_ranking']=='4'){ echo'selected=selected'; } ?>>4th</option>
                                       
                                    </select>
                                 </div>
                              </div>
							   <div class="form-group row">
                                 <label class="col-sm-2 col-form-label">Product Posting</label>
                                 <div class="col-sm-10">
                                    <select class="form-control" name="product_posting">
                                       <option value="">Select Product Posting</option>
                                       <option value="10" <?php if($dat['product_posting']=='10'){ echo'selected=selected'; } ?>>Below 10</option>
									   <option value="50" <?php if($dat['product_posting']=='50'){ echo'selected=selected'; } ?>>Below 50</option>
									   <option value="100" <?php if($dat['product_posting']=='100'){ echo'selected=selected'; } ?>>Below 100</option>
									   <option value="Unlimited" <?php if($dat['product_posting']=='Unlimited'){ echo'selected=selected'; } ?>>Unlimited</option>
                                    </select>
                                 </div>
                              </div>
							   <div class="form-group row">
                                 <label class="col-sm-2 col-form-label">Product Showcase</label>
                                 <div class="col-sm-10">
								
								  <input type="number" value="<?php if(isset($dat['product_showcase'])){ echo $dat['product_showcase']; } ?>" name="product_showcase" id="product_showcase" class="form-control" placeholder="0"  required>
                                    
                                 </div>
                              </div>
							  <div class="form-group row">
                                 <label class="col-sm-2 col-form-label">Verified Icon</label>
                                 <div class="col-sm-10">
                                    <div class="radio radio-inline">
										<label>
										<input type="radio" value="YES" name="verified_icon" required <?php if(isset($dat['verified_icon'])){ if($dat['verified_icon']=='YES'){ echo'checked'; }  } ?>>
										YES
										</label>
									</div>
									 <div class="radio radio-inline">
										<label>
										<input type="radio" value="NO" name="verified_icon" <?php if(isset($dat['verified_icon'])){ if($dat['verified_icon']=='NO'){ echo'checked'; }  } ?> required>
										NO
										</label>
									</div>
                                 </div>
                              </div>
							  <div class="form-group row">
                                 <label class="col-sm-2 col-form-label">Customized Website</label>
                                 <div class="col-sm-10">
                                    <div class="radio radio-inline">
										<label>
										<input type="radio" value="YES" name="customized_website" <?php if(isset($dat['customized_website'])){ if($dat['customized_website']=='YES'){ echo'checked'; }  } ?> required>
										YES
										</label>
									</div>
									 <div class="radio radio-inline">
										<label>
										<input value="NO" type="radio" name="customized_website" <?php if(isset($dat['customized_website'])){ if($dat['customized_website']=='NO'){ echo'checked'; }  } ?>>
										NO
										</label>
									</div>
                                 </div>
                              </div>
                              <div class="form-group row">
                                 <label class="col-sm-2 col-form-label">Duration In</label>
                                 <div class="col-sm-10">
                                    <select class="form-control" name="duration">
                                       <option value="">Select Duration</option>
                                       <option value="Month" <?php if($dat['duration']=='Month'){ echo'selected=selected'; } ?>>Month</option>
                                       <option value="Year" <?php if($dat['duration']=='Year'){ echo'selected=selected'; } ?>>Year</option>
                                    </select>
                                 </div>
                              </div>
							   <div class="form-group row">
                                 <label class="col-sm-2 col-form-label">Status</label>
                                 <div class="col-sm-10">
                                    <select class="form-control" name="status">
                                       <option value="">Select Status</option>
                                       <option value="Active" <?php if($dat['status']=='Active'){ echo'selected=selected'; } ?>>Active</option>
                                       <option value="Inactive" <?php if($dat['status']=='Inactive'){ echo'selected=selected'; } ?>>Inactive</option>
                                    </select>
                                 </div>
                              </div>
                              
                            
                              <?php
							  if(isset($dat['sub_id']))
							  {
								  echo'<button type="submit" id="submit_brand" class="btn btn-primary pull-right" id="primary-popover-content">Update</button>';
							  }
							  else
							  {
							  ?>
								<button type="submit" id="submit_brand" class="btn btn-primary pull-right" id="primary-popover-content">Craete</button>
							  <?php } ?>
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
</div>
<script>
   $(document).ready(function() {
   
     $('.date').datepicker({
       format: "dd/mm/yyyy",
    autoclose: true,  
    });
   
   });
   
</script>
<?php $this->load->view("admin/common/footer");?>