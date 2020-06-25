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
                           <h4>Update User</h4>
                        </div>
                     </div>
                  </div>
                  <div class="col-lg-4">
                     <div class="page-header-breadcrumb">
                        <ul class="breadcrumb-title">
                           <li class="breadcrumb-item">
                              <a href="<?php echo site_url();?>admin/dashboard"> <i class="feather icon-home"></i> </a>
                           </li>
                           <li class="breadcrumb-item"><a href="#!">User</a></li>
                           <li class="breadcrumb-item"><a href="#!">Update User</a></li>
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
                          
                           <form method="post" enctype="multipart/form-data">
                              <div class="form-group row">
                                 <label class="col-sm-2 col-form-label">Username</label>
                                 <div class="col-sm-10">
                                    <input type="text" name="admin_username" id="admin_username" class="form-control" value="<?php echo $user['admin_username']; ?>" placeholder="Username" required>
                                 </div>
                              </div>
							  <div class="form-group row">
                                 <label class="col-sm-2 col-form-label">User Role</label>
                                 <div class="col-sm-10">
                                    <select class="form-control" name="admin_role" required>
                                       <option value="">Select Role</option>
										<?php
										foreach($role_data as $role)
										{
											echo'<option value="'.$role["role_id"].'"';
											if($role['role_id']==$user['admin_role'])
											{
												echo 'selected';
											}
											echo '>'.$role["role_name"].'</option>';
										}
										?>
                                    </select>
                                 </div>
                              </div>
							   <div class="form-group row">
                                 <label class="col-sm-2 col-form-label">Name</label>
                                 <div class="col-sm-10">
                                    <input type="text" name="admin_firstname" id="admin_firstname" class="form-control" value="<?php echo $user['admin_firstname']; ?>" placeholder="Name" required>
                                 </div>
                              </div>
							  <div class="form-group row">
                                 <label class="col-sm-2 col-form-label">Email</label>
                                 <div class="col-sm-10">
                                    <input type="email" name="admin_email" id="admin_email" class="form-control" value="<?php echo $user['admin_email']; ?>" placeholder="Email" required>
                                 </div>
                              </div>
							  <div class="form-group row">
                                 <label class="col-sm-2 col-form-label">Phone</label>
                                 <div class="col-sm-10">
                                    <input type="number" name="admin_telephone" id="admin_telephone" class="form-control" value="<?php echo $user['admin_telephone']; ?>" placeholder="Phone" required>
                                 </div>
                              </div>
							  <div class="form-group row">
                                 <label class="col-sm-2 col-form-label">Address</label>
                                 <div class="col-sm-10">
                                    <input type="text" name="address1" id="address1" class="form-control" value="<?php echo $user['address1']; ?>" placeholder="Address" required>
                                 </div>
                              </div>
                              <div class="form-group row">
                                 <label class="col-sm-2 col-form-label">Select Country</label>
                                 <div class="col-sm-10">
                                    <select class="form-control" name="country">
                                       <option value="">Select Country</option>
										<?php
										foreach($country_data as $co)
										{
											echo'<option value="'.$co["id"].'"';
											if($co['id']==$user['country'])
											{
												echo 'selected';
											}
											echo '>'.$co["name"].'</option>';
										}
										?>
                                    </select>
                                 </div>
                              </div>
							  <div class="form-group row">
                                 <label class="col-sm-2 col-form-label">Select Status</label>
                                 <div class="col-sm-10">
                                    <select class="form-control" name="status">
                                       <option value="">Select Status</option>
                                       <option value="Active" <?php if($user['status']=='Active'){ echo'selected'; } ?>>Active</option>
                                       <option value="Inactive" <?php if($user['status']=='Inactive'){ echo'selected'; } ?>>Inactive</option>
										
                                    </select>
                                 </div>
                              </div>
                            
                              <button type="submit" id="submit_brand" class="btn btn-primary pull-right" id="primary-popover-content">Update User</button>
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

</script>
<?php $this->load->view("admin/common/footer");?>