<?php $this->load->view('admin/common/header'); ?>
<style type="text/css">
 body {font-family: Arial, Helvetica, sans-serif;}

#myImg {
  border-radius: 5px;
  cursor: pointer;
  transition: 0.3s;
}

#myImg:hover {opacity: 0.7;}

/* The Modal (background) */
.modal {
  display: none; /* Hidden by default */
  position: fixed; /* Stay in place */
  z-index: 1; /* Sit on top */
  padding-top: 100px; /* Location of the box */
  left: 0;
  top: 0;
  width: 100%; /* Full width */
  height: 100%; /* Full height */
  overflow: auto; /* Enable scroll if needed */
  background-color: rgb(0,0,0); /* Fallback color */
  background-color: rgba(0,0,0,0.9); /* Black w/ opacity */
}

/* Modal Content (image) */
.modal-content {
  margin: auto;
  display: block;
  width: 80%;
  max-width: 700px;
}

/* Caption of Modal Image */
#caption {
  margin: auto;
  display: block;
  width: 80%;
  max-width: 700px;
  text-align: center;
  color: #ccc;
  padding: 10px 0;
  height: 150px;
}

/* Add Animation */
.modal-content, #caption {  
  -webkit-animation-name: zoom;
  -webkit-animation-duration: 0.6s;
  animation-name: zoom;
  animation-duration: 0.6s;
}

@-webkit-keyframes zoom {
  from {-webkit-transform:scale(0)} 
  to {-webkit-transform:scale(1)}
}

@keyframes zoom {
  from {transform:scale(0)} 
  to {transform:scale(1)}
}

/* The Close Button */
.close {
  position: absolute;
  top: -25px!important;
  right: 35px;
  color: #f1f1f1;
  font-size: 40px;
  font-weight: bold;
  transition: 0.3s;
}

.close:hover,
.close:focus {
  color: #bbb;
  text-decoration: none;
  cursor: pointer;
}

/* 100% Image Width on Smaller Screens */
@media only screen and (max-width: 700px){
  .modal-content {
    width: 100%;
  }
}


#myImg {
	height: 100px;
}

#overlay {
	position: fixed;
	top: 0;
	left: 0;
	width: 100%;
	height: 100%;
	background: rgba(0, 0, 0, 0.8) none 50% / contain no-repeat;
	cursor: pointer;
	transition: 0.3s;
	visibility: hidden;
	opacity: 0;
        z-index:99999;
        background-size:50%; 
}
#overlay img {
    width: 60%;
    height: 60%;
}
#overlay.open {
	visibility: visible;
	opacity: 1;
}

#overlay:after {
	/* X button icon */
	content: "\2715";
	position: absolute;
	color: #fff;
	top: 10px;
	right: 20px;
	font-size: 2em;
}
</style>
<div class="pcoded-content">
  <div class="pcoded-inner-content">
    <div class="main-body">
      <div class="page-wrapper">
        <div class="page-header">
          <div class="row align-items-end">
            <div class="col-lg-8">
              <div class="page-header-title">
                <div class="d-inline">
                  <h4><?php echo $user->role; ?> : <?php echo ucfirst(strtolower($user->first_name)) . ' ' . ucfirst(strtolower($user->last_name)); ?></h4>
                  <span>ATZ Cart</span>
                </div>
              </div>
            </div>
            <div class="col-lg-4">
              <div class="page-header-breadcrumb">
                <ul class="breadcrumb-title">
                  <li class="breadcrumb-item">
                    <a href="<?php echo base_url(); ?>admin/dashboard"> <i class="feather icon-home"></i> </a>
                  </li>
                  <?php 
                        $linkOne = $user->role=='buyer'? 'users': 'vendors';
                   ?>
                  <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>admin/<?php echo $linkOne; ?>"><?php echo ucfirst($user->role); ?></a></li>
                  <li class="breadcrumb-item"><a href="#!"><?php echo ucfirst($user->role); ?> Profile</a></li>
                </ul>
              </div>
            </div>
          </div>
        </div>
        <div class="page-body">
          <div class="row">
            <div class="col-lg-12">
              <div class="cover-profile">
                <div class="">
                  <img class="profile-bg-img img-fluid" src="<?php echo base_url(); ?>assets/images/user-profile/bg-img1.jpg" alt="bg-img">
                  <div class="card-block user-info">
                    <form onsubmit="return check_profile();" method="post" action="<?php echo base_url() . $upload_action; ?>" enctype="multipart/form-data" id="upload_file">
                      <div class="col-md-12">
                        <div class="media-left">
                          <div class="profile-image">
                            <label class="filebutton" style="cursor: pointer;">
                            <?php
                              if (!empty($user_details['image'])) {
                                  ?>
                            <img class="user-img img-radius img-100" src="<?php echo $user_details['image']; ?>" alt="user-img">
                            <span>
                            <?php } else { ?>
                            <img class="user-img img-radius img-100" src="<?php echo base_url(); ?>assets/images/user-profile/user-img.jpg" alt="user-img">
                            <span>
                            <?php } ?>
                            </label>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-10" style="text-align:center;"></div>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <?php
              if ($pro_per >= 40) {
                  $pickclass = 'success';
              } else {
                  $pickclass = 'danger';
              }
              ?>
            <div class="col-lg-12">
              <div class="tab-header card">
                <div class="progress progress-xl">
                  <div class="progress-bar progress-bar-<?php echo $pickclass; ?>" role="progressbar" style="width: <?php if($pro_per == 0.00){ echo "100"; } else { echo $pro_per; } ?>%;padding-top: 5px;" aria-valuenow="<?php echo $pro_per ?>" aria-valuemin="0" aria-valuemax="100"><?php echo $pro_per ?>%</div>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-lg-12">
              <div class="tab-header card">
                <ul class="nav nav-tabs md-tabs tab-timeline" role="tablist" id="mytab">
                    <li style="padding:10px;">
                    <a class="nav-link active" data-toggle="tab" href="#personal" role="tab"><?php echo ucfirst(strtolower($user->first_name)) . ' ' . ucfirst(strtolower($user->last_name)); ?>, Company : <?php echo $company->company_name; ?></a>
					registration date : <?php echo $user->created_on; ?>
                    <div class="slide"></div>
                  </li>
                </ul>
              </div>
              <div class="tab-content">
                <div class="tab-pane active" id="personal" role="tabpanel">
                  <div class="card">
                    <div class="card-header">
                      <h5 class="card-header-text">About <?php echo ucfirst(strtolower($user->first_name)) . ' ' . ucfirst(strtolower($user->last_name)); ?></h5>
					  
					  <div class="text-right"> <a href="<?php echo base_url(); ?>admin/users/getEmail/<?php echo $user_id; ?>"><button type="button" class="btn btn-primary btn-sm">Change email</button></a> 
					    <a href="<?php echo base_url(); ?>admin/users/getMobile/<?php echo $user_id; ?>"><button type="button" class="btn btn-primary btn-sm">Change Mobile</button></a> </div>
                    </div>
                    <div class="card-block">
                      <div class="view-info">
                        <div class="row">
                          <div class="col-lg-12">
                            <div class="general-info">
                              <div class="row">
                                <div class="col-lg-12 col-xl-6">
                                  <div class="table-responsive">
                                    <table class="table m-0">
                                      <tbody>
                                        <tr>
                                          <th scope="row">Full Name</th>
                                          <td><?php echo $user->first_name . ' ' . $user->last_name; ?></td>
                                        </tr>
                                        <tr>
                                          <th scope="row">Company Type</th>
                                          <td><?php echo $user->companyType; ?></td>
                                        </tr>
                                        <tr>
                                          <th scope="row">Address</th>
                                          <td><?php echo $user->address; ?></td>
                                        </tr>
                                         <tr>
                                          <th scope="row">GST Number</th>
                                          <td><?php echo $user->gst_no; ?></td>
                                        </tr>
                                      </tbody>
                                    </table>
                                  </div>
                                </div>
                                <div class="col-lg-12 col-xl-6">
                                  <div class="table-responsive">
                                    <table class="table">
                                      <tbody>
                                        <tr>
                                          <th scope="row">Email</th>
                                          <td><a href="#!"><?php echo $user->email; ?></a></td>
                                        </tr>
                                        <tr>
                                          <th scope="row">Company Name</th>
                                          <td><a href="#!"><?php echo $company->company_name; ?></a></td>
                                        </tr>
                                        <tr>
                                          <th scope="row">Mobile Number</th>
                                          <td>
                                            <?php echo $user->phone; ?>
                                          </td>
                                        </tr>
                                        <tr>
                                          <th scope="row">Pan Number</th>
                                          <td>
                                            <?php echo $user->pan_no; ?>
                                          </td>
                                        </tr>
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
                </div>
              </div>
              <div class="tab-content">
                <div class="tab-pane active" id="personal" role="tabpanel">
                  <div class="card">
                    <div class="card-header">
                      <h5 class="card-header-text">Contact Information</h5>
                    </div>
                    <div class="card-block">
                      <div class="view-info">
                        <div class="row">
                          <div class="col-lg-12">
                            <div class="general-info">
                              <div class="row">
                                <div class="col-lg-12 col-xl-6">
                                  <div class="table-responsive">
                                    <table class="table m-0">
                                      <tbody>
                                        <tr>
                                          <th scope="row">Email</th>
                                          <td><?php echo $user->email; ?></td>
                                        </tr>
                                        <tr>
                                          <th scope="row">Alternative Email</th>
                                          <td>None</td>
                                        </tr>
                                      </tbody>
                                    </table>
                                  </div>
                                </div>
                                <div class="col-lg-12 col-xl-6">
                                  <div class="table-responsive">
                                    <table class="table">
                                      <tbody>
                                        <tr>
                                          <th scope="row">Mobile</th>
                                          <td><?php echo $user->phone; ?></td>
                                        </tr>
                                        <tr>
                                          <th scope="row">Social Link</th>
                                          <td>None</td>
                                        </tr>
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
                </div>     
              </div>
              <div class="tab-content">
                <div class="tab-pane active" id="personal" role="tabpanel">
                  <div class="card">
                    <div class="card-header">
                      <h5 class="card-header-text">Pickup Address</h5>
                    </div>
                    <div class="card-block">
                      <div class="view-info">
                        <div class="row">
                          <div class="col-lg-12">
                            <div class="general-info">
                              <div class="row">

                                <?php if (!empty($seller_pickup_addr)) {
                                  # code...
                                  $addrType='';
                                  $address='';
                                  $address2='';
                                  $address3='';
                                  $country='';
                                  $pincode='';
                                  $addrState='';
                                  $office_close='';
                                  foreach ($seller_pickup_addr as $key => $value) {
                                    # code...
                                      $addrType=$value['address_type'];
                                      $address=$value['address'];
                                      $address2=$value['address2'];
                                      $address3=$value['address3'];
                                      $addrState=$value['state'];
                                      $country=$value['name'];
                                      $pincode=$value['pincode'];
                                      $office_close=$value['office_close'];
                                  }
                                }
                                else
                                {
                                  $addrType='';
                                  $address='';
                                  $address2='';
                                  $address3='';
                                  $country='';
                                  $pincode='';
                                  $addrState='';
                                  $office_close='';
                                }

                                 ?>
                                <div class="col-lg-12 col-xl-6">
                                  <div class="table-responsive">
                                    <table class="table m-0">
                                      <tbody>
                                        <tr>
                                          <th scope="row">Address Type</th>
                                          <td><?php echo $addrType; ?></td>
                                        </tr>
                                        <tr>
                                          <th scope="row">Address</th>
                                          <td><?php echo $address ?></td>
                                        </tr>
                                        <tr>
                                          <th scope="row">Address2</th>
                                          <td><?php echo $address2 ?></td>
                                        </tr>
                                         <tr>
                                          <th scope="row">Address3</th>
                                          <td><?php echo $address3 ?></td>
                                        </tr>
                                      </tbody>
                                    </table>
                                  </div>
                                </div>
                                <div class="col-lg-12 col-xl-6">
                                  <div class="table-responsive">
                                    <table class="table">
                                      <tbody>
                                        <tr>
                                          <th scope="row">State</th>
                                          <td><?php echo $addrState; ?></td>
                                        </tr>
                                        <tr>
                                          <th scope="row">Country</th>
                                          <td><?php echo $country; ?></td>
                                        </tr>
                                        <tr>
                                          <th scope="row">Pincode</th>
                                          <td><?php echo $pincode ?></td>
                                        </tr>
                                         <tr>
                                          <th scope="row">Office Close</th>
                                          <td><?php echo $office_close; ?>&nbsp;&nbsp;[24 hrs]</td>
                                        </tr>
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
                </div>     
              </div>
               <div class="tab-content">
                <div class="tab-pane active" id="personal" role="tabpanel">
                  <div class="card">
                    <div class="card-header">
                      <h5 class="card-header-text">Proprietor Information</h5>
                    </div>
                    <div class="card-block">
                      <div class="view-info">
                        <div class="row">
                          <div class="col-lg-12">
                            <div class="general-info">
                              <div class="row">
                                <div class="col-lg-12 col-xl-6">
                                  <div class="table-responsive">
                                    <table class="table m-0">
                                      <tbody>
                                        <tr>
                                          <th scope="row">Name</th>
                                          <td><?php echo $user->user_role_name; ?></td>
                                        </tr>
                                        <tr>
                                          <th scope="row">Address</th>
                                          <td><?php echo $user->user_role_address; ?></td>
                                        </tr>
                                        <tr>
                                          <th scope="row"> Email</th>
                                          <td><?php echo $user->user_role_email; ?></td>
                                        </tr>
                                      </tbody>
                                    </table>
                                  </div>
                                </div>
                                <div class="col-lg-12 col-xl-6">
                                  <div class="table-responsive">
                                    <table class="table">
                                      <tbody>
                                        <tr>
                                          <th scope="row">Pan Number</th>
                                          <td><?php echo $user->user_role_panNo; ?></td>
                                        </tr>
                                        <tr>
                                          <th scope="row">Phone Number</th>
                                          <td><?php echo $user->user_role_phone; ?></td>
                                        </tr>
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
                </div>
              </div>
              <div class="tab-content">
                <div class="tab-pane active" id="personal" role="tabpanel">
                  <div class="card">
                    <div class="card-header">
                      <h5 class="card-header-text">Company Information</h5>
                    </div>
                    <div class="card-block">
                      <div class="view-info">
                        <div class="row">
                          <div class="col-lg-12">
                            <div class="general-info">
                              <div class="row">
                                <div class="col-lg-12 col-xl-6">
                                  <div class="table-responsive">
                                    <table class="table m-0">
                                      <tbody>
                                        <tr>
                                          <th scope="row">Company Name</th>
                                          <td><?php echo $company->company_name; ?></td>
                                        </tr>
                                        <tr>
                                          <th scope="row">Year Established</th>
                                          <td><?php echo $company->year_of_register; ?></td>
                                        </tr>
                                        <tr>
                                          <th scope="row">Official Website</th>
                                          <td><?php echo $company->company_url; ?></td>
                                        </tr>
                                        <tr>
                                          <th scope="row">Business Type</th>
                                          <td><?php echo $company->company_type; ?> </td>
                                        </tr>
                                        <tr>
                                          <th scope="row">Total Number of Employees</th>
                                          <td><?php echo $company->no_of_employee; ?></td>
                                        </tr>
                                      </tbody>
                                    </table>
                                  </div>
                                </div>
                                <div class="col-lg-12 col-xl-6">
                                  <div class="table-responsive">
                                    <table class="table">
                                      <tbody>
                                        <tr>
                                          <th scope="row">Platforms for Selling</th>
                                          <td>None</td>
                                        </tr>
                                        <tr>
                                          <th scope="row">Main Products</th>
                                          <td>
                                            <?php
                                              $main_products = json_decode($company->main_products);
                                              if (!is_array($main_products)) {
                                                  $main_products = [
                                                      0 => "",
                                                      1 => "",
                                                      2 => "",
                                                      3 => "",
                                                      4 => "",
                                                  ];
                                              }
                                              foreach ($main_products as $product):
                                                  echo $product . ", ";
                                              endforeach;
                                              ?>
                                          </td>
                                        </tr>
                                        <tr>
                                          <th scope="row">Registered Address</th>
                                          <td>
                                            <?php
                                              echo $company->registration_state . " ," . $company->location_country;
                                              ?>
                                          </td>
                                        </tr>
                                        <tr>
                                          <th scope="row">Operational Address</th>
                                          <td><?php echo $company->comp_operational_addr; ?> <?php echo $company->comp_operational_city; ?> <?php echo $company->comp_operational_state; ?> <?php echo $company->comp_operational_region; ?> <?php echo $company->comp_operational_zip_code; ?> </td>
                                        </tr>
                                        <tr>
                                          <th scope="row">About Us</th>
                                          <td><?php echo $company->introduction; ?> </td>
                                        </tr>
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
                </div>
              </div>
              <div class="tab-content">
                <div class="tab-pane active" id="personal" role="tabpanel">
                  <div class="card">
                    <div class="card-header">
                      <h5 class="card-header-text">Company Quality Control</h5>
                    </div>
                    <div class="card-block">
                      <div class="view-info">
                        <div class="row">
                          <div class="col-lg-12">
                            <div class="general-info">
                              <div class="row">
                                <div class="col-lg-12 col-xl-6">
                                  <div class="table-responsive">
                                    <table class="table m-0">
                                      <tbody>
                                        <tr>
                                          <th scope="row">Quality Control process</th>
                                          <td><?php if ($company->display_quality_control_process == 1) {
                                            echo 'YES';
                                            } else {
                                            echo'No';
                                            } ?></td>
                                        </tr>
                                        <?php
                                          if ($company->display_quality_control_process == 1) {
                                              $qc_det = json_decode($company->quality_control_details);
                                          
                                              echo'<tr>';
                                              echo'<table class="table table-striped table-bordered nowrap dataTable no-footer">';
                                              echo'<tr>
                                          
                                          <th scope="row">Name</th>
                                          <td>Image</td>
                                          <td>Description</td>
                                          </tr>';
                                              foreach ($qc_det as $det) {
                                                  ?>
                                        <tr>
                                          <td><?php echo $det->name; ?></td>
                                          <td><?php if (!empty($det->image)) {
                                            echo '<img src="' . $det->image . '" style="width:50px;">';
                                            } else {
                                            echo '--';
                                            } ?></td>
                                          <td><?php echo $det->description; ?></td>
                                        </tr>
                                        <?php
                                          }
                                          echo'</table>';
                                          echo'</tr>';
                                          }
                                          ?>
                                      </tbody>
                                    </table>
                                  </div>
                                </div>
                                <div class="col-lg-12 col-xl-6">
                                  <div class="table-responsive">
                                    <table class="table">
                                      <tbody>
                                        <tr>
                                          <th scope="row">Testing Equipments</th>
                                          <td><?php if ($company->display_testing_equipments == 1) {
                                            echo 'YES';
                                            } else {
                                            echo'No';
                                            }
                                            ?></td>
                                        </tr>
                                        <?php
                                          if ($company->display_testing_equipments == 1) {
                                              $qc_det = json_decode($company->testing_equipment_details);
                                          
                                              echo'<tr>';
                                              echo'<table class="table table-striped table-bordered nowrap dataTable no-footer">';
                                              echo'<tr>
                                          																				   
                                          																						<th scope="row">Name</th>
                                          																						<td>Model</td>
                                          																						<td>Quantity</td>
                                          																				    </tr>';
                                              foreach ($qc_det as $det) {
                                                  ?>
                                        <tr>
                                          <td><?php echo $det->name; ?></td>
                                          <td><?php echo $det->model; ?></td>
                                          <td><?php echo $det->quantity; ?></td>
                                        </tr>
                                        <?php
                                          }
                                          echo'</table>';
                                          echo'</tr>';
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
                </div>
              </div>
              <div class="tab-content">
                <div class="tab-pane active" id="personal" role="tabpanel">
                  <div class="card">
                    <div class="card-header">
                      <h5 class="card-header-text">Manufacturing Capability</h5>
                    </div>
                    <div class="card-block">
                      <div class="view-info">
                        <div class="row">
                          <div class="col-lg-12">
                            <div class="general-info">
                              <div class="row">
                                <div class="col-lg-12 col-xl-6">
                                  <div class="table-responsive">
                                    <table class="table m-0">
                                      <tbody>
                                        <tr>
                                          <th scope="row">Factory Location</th>
                                          <td><?php echo $company->factory_location; ?> </td>
                                        </tr>
                                        <tr>
                                          <th scope="row">Factory Size</th>
                                          <td><?php echo $company->factory_size; ?> </td>
                                        </tr>
                                        <tr>
                                          <th scope="row">Production Line Count</th>
                                          <td><?php echo $company->production_line_count; ?> </td>
                                        </tr>
                                        <tr>
                                          <th scope="row">Display Production process</th>
                                          <td><?php if ($company->display_production_process == 1) {
                                            echo 'YES';
                                            } else {
                                            echo'No';
                                            } ?></td>
                                        </tr>
                                        <?php
                                          if ($company->display_production_process == 1) {
                                              $qc_det = json_decode($company->production_process_details);
                                          
                                              echo'<tr>';
                                              echo'<table class="table table-striped table-bordered nowrap dataTable no-footer">';
                                              echo'<tr>
                                          
                                          <th scope="row">Name</th>
                                          <td>Image</td>
                                          <td>Description</td>
                                          </tr>';
                                              foreach ($qc_det as $det) {
                                                  ?>
                                        <tr>
                                          <td><?php echo $det->name; ?></td>
                                          <td><?php if (!empty($det->image)) {
                                            echo '<img src="' . $det->image . '" style="width:50px;">';
                                            } else {
                                            echo '--';
                                            } ?></td>
                                          <td><?php echo $det->description; ?></td>
                                        </tr>
                                        <?php
                                          }
                                          echo'</table>';
                                          echo'</tr>';
                                          }
                                          ?>
                                      </tbody>
                                    </table>
                                  </div>
                                </div>
                                <div class="col-lg-12 col-xl-6">
                                  <div class="table-responsive">
                                    <table class="table">
                                      <tbody>
                                        <tr>
                                          <th scope="row">OC Staff Count</th>
                                          <td><?php echo $company->oc_staff_count; ?> </td>
                                        </tr>
                                        <tr>
                                          <th scope="row">RD Staff Count</th>
                                          <td><?php echo $company->rd_staff_count; ?> </td>
                                        </tr>
                                        <tr>
                                          <th scope="row">Annual Production Capability</th>
                                          <td><?php echo $company->annual_production_capacity; ?> </td>
                                        </tr>
                                        <tr>
                                          <th scope="row">Display Production Line</th>
                                          <td><?php if ($company->display_production_line == 1) {
                                            echo 'YES';
                                            } else {
                                            echo'No';
                                            }
                                            ?></td>
                                        </tr>
                                        <?php
                                          if ($company->display_production_line == 1) {
                                              $qc_det = json_decode($company->production_line_details);
                                          
                                              echo'<tr>';
                                              echo'<table class="table table-striped table-bordered nowrap dataTable no-footer">';
                                              echo'<tr>
                                          																				   
                                          																						<th scope="row">Name</th>
                                          																						<td>Supervisor No</td>
                                          																						<td>Operators</td>
                                          																						<td>QA/QC Number</td>
                                          																				    </tr>';
                                              foreach ($qc_det as $det) {
                                                  ?>
                                        <tr>
                                          <td><?php echo $det->name; ?></td>
                                          <td><?php echo $det->supervisor_no; ?></td>
                                          <td><?php echo $det->operators_count; ?></td>
                                          <td><?php echo $det->qc_qa_number; ?></td>
                                        </tr>
                                        <?php
                                          }
                                          echo'</table>';
                                          echo'</tr>';
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
                </div>
              </div>
              <div class="tab-content">
                <div class="tab-pane active" id="personal" role="tabpanel">
                  <div class="card">
                    <div class="card-header">
                      <h5 class="card-header-text">Company RND Details</h5>
                    </div>
                    <div class="card-block">
                      <div class="view-info">
                        <div class="row">
                          <div class="col-lg-12">
                            <div class="general-info">
                              <div class="row">
                                <div class="col-lg-12 col-xl-12">
                                  <div class="table-responsive">
                                    <table class="table m-0">
                                      <tbody>
                                        <tr>
                                          <th scope="row">Company Control process</th>
                                          <td><?php if ($company->display_rnd_control_process == 1) {
                                            echo 'YES';
                                            } else {
                                            echo'No';
                                            } ?></td>
                                        </tr>
                                        <?php
                                          if ($company->display_rnd_control_process == 1) {
                                              $qc_det = json_decode($company->rnd_details);
                                          
                                              echo'<tr>';
                                              echo'<table class="table table-striped table-bordered nowrap dataTable no-footer">';
                                              echo'<tr>
                                          																				   
                                          																						<th scope="row">Name</th>
                                          																						<td>Image</td>
                                          																						<td>Description</td>
                                          																				    </tr>';
                                              foreach ($qc_det as $det) {
                                                  ?>
                                        <tr>
                                          <td><?php echo $det->name; ?></td>
                                          <td><?php if (!empty($det->image)) {
                                            echo '<img src="' . $det->image . '" style="width:50px;">';
                                            } else {
                                            echo '--';
                                            } ?></td>
                                          <td><?php echo $det->description; ?></td>
                                        </tr>
                                        <?php
                                          }
                                          echo'</table>';
                                          echo'</tr>';
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
                </div>
              </div>
              <div class="tab-content">
                <div class="tab-pane active" id="personal" role="tabpanel">
                  <div class="card">
                    <div class="card-header">
                      <h5 class="card-header-text">Seller Bank Details</h5>
                    </div>
                    <div class="card-block">
                      <div class="view-info">
                        <div class="row">
                          <div class="col-lg-12">
                            <div class="general-info">
                              <div class="row">
                                <div class="col-lg-12 col-xl-12">
                                  <div class="table-responsive">
                                    <table class="table m-0">
                                      <tbody>
                                        <tr>
                                          <th scope="row">Acc Holder Name</th>
                                          <th scope="row">Bank Name</th>
                                          <th scope="row">Acc Number</th>
                                          <th scope="row">IFSC Coder</th>
                                          <th scope="row">Default</th>
                                          <th scope="row">Created At</th>
                                          </tr>
                                          <?php
                                          foreach($bank_details as $ba)
                                          {
                                          echo'<tr>';
                                          echo'<td>'.$ba->account_holder_name.'</td>';
                                          echo'<td>'.$ba->bank_name.'</td>';
                                          echo'<td>'.$ba->account_no.'</td>';
                                          echo'<td>'.$ba->ifsc_code.'</td>';
                                          if($ba->is_default==1)
                                          {
                                          echo'<td>YES</td>';
                                          }
                                          else{
                                              echo'<td>NO</td>'; 
                                          }
                                          echo'<td>'.$ba->created_date.'</td>';
                                          echo'</tr>';
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
                </div>
              </div>
               <p id='success_msg'><?php echo $this->session->flashdata('message'); ?></p>
               <div id="company_docs"></div>
                <div id="company_docs1"></div>
              <div class="tab-pane active" id="personal1" role="tabpanel">
                <div class="card ">
                  <div class="card-header">
                    <h5 class="card-header-text">Company Certificates and License</h5>
                    
                    <a href="<?php echo base_url('admin/users/upload_user_company_documents/'.$user_id);?>" class="btn btn-success pull-right" style="margin-left: 38px;">ADD</a> &nbsp;

                    <?php
                     if($company_document_status[0]['document_verify_status']=='rejected')
                    { ?>

                      <a href="#" id="verify_me" user-id="<?php echo $company_document_titles[0]['user_id']?>" doc-id="<?php echo $company_document_titles[0]['id'] ?>" data-name="verify" class="btn btn-success pull-right">Verify</a>

                   <?php }
                         if($company_document_status[0]['document_verify_status']=='verified'){
                     ?>
                       <a href="#" id="reject_me" user-id="<?php echo $company_document_titles[0]['user_id']?>" doc-id="<?php echo $company_document_titles[0]['id'] ?>" data-name="reject" class="btn btn-success pull-right">Reject</a>

                     <?php
                   }   if($company_document_status[0]['document_verify_status']==''){  
                       
                      ?>
                       <a href="#" id="verify_me" user-id="<?php echo $company_document_titles[0]['user_id']?>" doc-id="<?php echo $company_document_titles[0]['id'] ?>" data-name="verify" class="btn btn-success pull-right">Verify</a>
                     <?php } ?>
                  </div>
                   <div id="loading" style="display:none;">
                                <img id="loading-image" src="<?php echo base_url(); ?>assets/front/images/loader1.gif" alt="Loading..." style="width:250px;height:300px;" />
                         </div>

                  <div class="card-block">
                    <div class="view-info">
                      <div class="row">
                        <div class="col-lg-12">
                          <div class="general-info">
                            <div class="row">
                              <div class="col-lg-12 col-xl-12">
                                <div class="table-responsive">
                                  <table class="table m-0 table table-border" style="border: 1px solid #EEE">

                                    <tbody>
                                      <?php 
                                      if(!empty($company_document_titles)){ $i = 0; foreach($company_document_titles as $title){

                                    // echo "<pre>";  print_r($title['files']) ;
                                        $fileArr=array();
                                        ?>
                                      <tr>
                                        <th scope="row">Title : <?php echo $title['title']?></th>
                                        <td>
                                          <?php foreach ($title['files'] as $file){
                                              $totalCount=count($file['file']);
                                              $fileArr= $file['file'];
                                              // print_r($fileArr);
                                              $dat1=explode('companies/',$file['file']);
                                              //check extension
                                              
                                              $dat=explode('.',$file['file']);

                                              if($dat[5]=='pdf')
                                                      { 
                                                 // $dat2=explode('companies/',$file['file']);  
                                               
                                                   ?>
    
                                         <a href="<?php echo $file['file'];?>" data-toggle="roadtrip">

                                          <img src="<?php echo base_url();?>assets/admin/icon/pdficon.svg" style="width:60px;height:60px" class="img-fluid m-b-10"> 
                                          </a> 
                                                      <?php } 
                                                      else {
                                                          
                                                     
                                           foreach ($dat1 as $key => $value) {
                                                        // print_r($value);
                                                       ?>

                                 <a href="#" data-toggle="roadtrip" targer="_blank">

                                    <a href="#" data-toggle="roadtrip" targer="_blank">

                                        <img id="myImg" class="myImg" src="<?php echo $value;?>" alt="<?php echo $value;?>" height ="70px" width ="70px" class="img-fluid m-b-10">  

                                          <!-- The Modal -->
                                          <div id="myModal" class="modal">
                                            <span class="close">&times;</span>
                                            <img class="modal-content" id="img01">
                                            <div id="caption"></div>
                                          </div>
                                          </a> 

                                          
                                            <?php 
                                                 } } $i++;} 
                                                 ?> 

                                        </td>
                                       
                                        <td>
                                           <?php
                                            // echo "<pre>";
                                            // print_r(count($company_document_status[0]['file_status']));
                                          
                                            if(empty($title['file_status']) || !$title['file_status']) { ?>

                                        <span id="display_advance" style="" class="display_advance label label-danger">None</span>

                                        <?php }else{ ?>

                                          <span id="display_advance" style="" class="display_advance label label-info"><?php echo $title['file_status']; ?> </span>
                                          
                                         <?php } ?>
                                        </td>
                                     
                                        
                                      </tr>
                                      <?php }} ?>																					
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
              </div>
			  <?php
			  if($role=='seller')
			  {
			  ?>
			  <div class="tab-pane active" id="personal" role="tabpanel">
                <div class="card">
                  <div class="card-header">
                    <h5 class="card-header-text">Package Purchase</h5>
                    
                  </div>
                  <div class="card-block">
                    <div class="view-info">
                      <div class="row">
                        <div class="col-lg-12">

                          <div class="general-info">
                            <div class="row">
                              <div class="col-lg-12 col-xl-12">
                                <div class="table-responsive">
                                  <table class="table m-0">
                                    <tbody>
									<tr>
										<th>Name</th>
										<th>Start Date</th>
										<th>End Date</th>
									</tr>
                                     <?php
									foreach($pkg_data as $pkg)
									{ ?>
										<tr>
											<td><?php echo $pkg->pkg_name; ?></td>
											<td><?php echo $pkg->start_date; ?></td>
											<td><?php echo $pkg->end_date; ?></td>
										</tr>
									<?php }
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
              </div>
			  <?php } ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<div id="overlay"></div>
<script>


  function update_status(status) {
      var con = confirm('Are you confirm to Update User ?');
      if (con == true) {
          var user_id = '<?php echo $company->user_id; ?>';
  
          $.ajax({
              type: 'POST',
              url: '<?php echo base_url(); ?>admin/users/update_appr_status/',
              data: {
                  'status': status,
                  'user_id': user_id
              },
              success: function(data) {
  
                  alert('Status Update Successfully');
                  location.reload();
  
              },
              error: function() {
                  alert('Error !');
              }
          });
      } else {
          location.reload();
      }
  } 
 
</script>																

<?php $this->load->view('admin/common/footer'); ?>

<script type="text/javascript">

 $(document).ready(function(e){

// $('.verified').css('display','none');
// $('.rejected').css('display','none');

  var TotalCount='<?php echo $totalCount; ?>';

  $("#verify_me").on("click",function(e){
   var verify_id=$(this).attr('doc-id');
   var user_id=$(this).attr('user-id');
   var req_name=$(this).attr('data-name');
   var file_id=$(this).attr('file-id');

$.ajax({

  url:'<?php echo base_url() ?>/admin/users/updateStatus',
  type:'post',
  data:{
    verify_id:verify_id,
    user_id:user_id,
    req_name:req_name,
    file_id:file_id
  },
  success:function(response){
         // alert(response);
    var result=JSON.parse(response);
    // console.log(response);
    // $("#company_docs").empty();
    if(result.message=='success' && result.status==1)
    {
        var message = '<div class="alert alert-success alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Success!</strong> Document Verified!.</div>';
      
        $("#company_docs").html(message);
        // $('#display_advance').show();
        // $('.verified').css('display','block');
        // $('.verified').html('verified');
        // $('#verify_me').hide();
        // $('#verify_me').addClass('disabled');
        icon = $(this).find("i");
        icon.toggleClass("icon-circle-arrow-up icon-circle-arrow-down");
        location.reload();
        window.location.href = '<?php echo site_url(); ?>admin/users/user_view/'+user_id+'/#personal1';
    }
    else
    {
        var message = '<div class="alert alert-info alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Error!</strong> Already Verified!.</div>';
        $("#company_docs").html(message);

        $('#display_advance').show();
        // $('#verify_me').addClass('disabled');
        icon = $(this).find("i");
        icon.toggleClass("icon-circle-arrow-up icon-circle-arrow-down");
      
        window.location.href = '<?php echo site_url(); ?>admin/users/user_view/'+user_id+'/#personal1';
    }
  },
  error:function(error){

  },
});

});


/*
*/

$("#reject_me").on("click",function(e){
  var verify_id=$(this).attr('doc-id');
   var user_id=$(this).attr('user-id');
  var req_name=$(this).attr('data-name');

$.ajax({

  url:'<?php echo base_url() ?>/admin/users/updateStatus',
  type:'post',
  data:{
    verify_id:verify_id,
    user_id:user_id,
    req_name:req_name
  },
  success:function(response){
       alert(response);
    var result=JSON.parse(response);
    console.log(response);
    // $("#company_docs1").empty();
    if(result.message=='success' && result.status==1)
    {
        var message = '<div class="alert alert-danger alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Error!</strong> Document Rejected.!</div>'
        $("#company_docs1").html(message);
        // window.location.href = '<?php echo site_url(); ?>admin/users/'+user_id/+'#personal';

        // $('#display_advance1').show();
        // $('.rejected').css('display','block');
        // $('.rejected').html('rejected');
        // $('#reject_me').hide();
        // $('#reject_me').addClass('disabled');
        icon = $(this).find("i");
        icon.toggleClass("icon-circle-arrow-up icon-circle-arrow-down");
        location.reload();
        window.location.href = '<?php echo site_url(); ?>admin/users/user_view/'+user_id+'/#personal1';

    }
    else
    {
        var message = '<div class="alert alert-danger alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Error!</strong> Already Rejected!.</div>'
        $("#company_docs1").html(message); 
        $('#display_advance1').show();
         location.reload();
        window.location.href = '<?php echo site_url(); ?>admin/users/user_view/'+user_id+'/#personal1';
    }
  },
  error:function(error){

  },
});

});

 });

  
$('.myImg').on('click', function() {
    $('#overlay').css({
        backgroundImage: `url(${this.src})`
    }).addClass('open').one('click', function() {
        $(this).removeClass('open');
    });
});

</script>