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
                           <h4>Add Address</h4>
                        </div>
                     </div>
                  </div>
                  <div class="col-lg-4">
                     <div class="page-header-breadcrumb">
                        <ul class="breadcrumb-title">
                           <li class="breadcrumb-item">
                              <a href="index.html"> <i class="feather icon-home"></i> </a>
                           </li>
                           <li class="breadcrumb-item"><a href="#!">Address</a></li>
                           <li class="breadcrumb-item"><a href="#!">Add Address</a></li>
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
                                 <label class="col-sm-2 col-form-label">Name</label>
                                 <div class="col-sm-10">
                                    <input type="text" name="seller_name" id="seller_name" class="form-control" placeholder="Name" required>
                                 </div>
                              </div>
							   <div class="form-group row">
                                 <label class="col-sm-2 col-form-label">Email</label>
                                 <div class="col-sm-10">
                                    <input type="text" name="seller_email" id="seller_email" class="form-control" placeholder="Email" required>
                                 </div>
                              </div>
							   <div class="form-group row">
                                 <label class="col-sm-2 col-form-label">Mobile</label>
                                 <div class="col-sm-10">
                                    <input type="number" name="seller_mobile" id="seller_mobile" class="form-control" placeholder="Mobile Number" required>
                                 </div>
                              </div>
                              <div class="form-group row">
                                 <label class="col-sm-2 col-form-label">Address Type</label>
                                 <div class="col-sm-10">
                                    <input type="text" name="address_type" id="address_type" class="form-control" placeholder="Address Type" required>
                                 </div>
                              </div>
                              <div class="form-group row">
                                 <label class="col-sm-2 col-form-label">Address</label>
                                 <div class="col-sm-10">
                                    <div class="input-group">
                                       <input type="text" name="address" id="address" class="form-control" placeholder="Address" required >
                                    </div>
                                 </div>
                              </div>
							  <div class="form-group row">
                                 <label class="col-sm-2 col-form-label">Office Close (24 hrs)</label>
                                 <div class="col-sm-10">
                                    <div class="input-group">
                                       <input type="time" name="office_close" id="office_close" class="form-control" placeholder="00:00" required >
                                    </div>
                                 </div>
                              </div>
							  <div class="form-group row">
                                 <label class="col-sm-2 col-form-label">State</label>
                                 <div class="col-sm-10">
                                    <div class="input-group">
                                       <input type="text" name="state" id="state" class="form-control" placeholder="state" required >
                                    </div>
                                 </div>
                              </div>
							  <div class="form-group row">
                                 <label class="col-sm-2 col-form-label">Country</label>
                                 <div class="col-sm-10">
                                    <select class="form-control" name="country">
										<option value="">Select Country</option>
										<?php
										foreach($country as $co)
										{
												echo'<option value="'.$co["id"].'">'.$co["name"].'</option>';
										}
										?>
										
									</select>
                                 </div>
                              </div>
							  <div class="form-group row">
                                 <label class="col-sm-2 col-form-label">Pincode</label>
                                 <div class="col-sm-10">
                                    <div class="input-group">
                                       <input type="number" name="pincode" id="pincode" class="form-control" placeholder="Pincode" required >
                                    </div>
                                 </div>
                              </div>
							  <div class="form-group row">
                                 <label class="col-sm-2 col-form-label">Is Default</label>
                                 <div class="col-sm-10">
                                    <div class="input-group">
                                       <input type="checkbox" name="is_default" id="is_default" value="1" >
                                    </div>
                                 </div>
                              </div>
                              
                              <button type="submit" id="submit_brand" class="btn btn-primary pull-right" id="primary-popover-content">Add</button>
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

<?php $this->load->view("user/common/footer");?>